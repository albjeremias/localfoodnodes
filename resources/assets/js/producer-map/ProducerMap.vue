<template>
    <div class="map-container">
        <div ref="map"></div>
        <div class="white-box sidebar">
            <h4>Your delivery locations</h4>
            <ul class="list-unstyled list-group">
                <li v-for="node in userNodes" v-bind:key="node.id" class="list-group-item" :class="{active: node.selected}">
                    <div>{{ node.name }}</div>
                    <small><span v-on:click="removeNode(node)"><i class="fa fa-minus-circle"></i> Remove from list</span></small>
                </li>

                <li v-if="selectedNode" class="list-group-item active">
                    <div>{{ selectedNode.name }}</div>
                    <small><span v-on:click="addNode(selectedNode)"><i class="fa fa-plus-circle"></i> Add to list</span> or <span v-on:click="cancelNode">cancel</span></small>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['producerId'],
        data: function() {
            return {
                map: null,
                nodes: [],
                selectedNode: null,
                user: null,
                userNodes: [],
            }
        },
        mounted() {
            this.fetchNodes();
        },
        watch: {
            nodes: function(nodes) {
                let markers = L.markerClusterGroup({
                    iconCreateFunction: function(cluster) {
                        return L.divIcon({
                            html: '<i class="fas fa-map-marker map-marker map-cluster-marker"><span>' + cluster.getChildCount() + '</span></i>',
                            iconAnchor: [16, 16],
                        });
                    },
                    showCoverageOnHover: false,
                    spiderLegPolylineOptions: { opacity: 0 }
                });

                markers.clearLayers()

                for (let i = 0; i < nodes.length; i++) {
                    let node = nodes[i];
                    let classes = ['fas', 'fa-map-marker-alt', 'map-marker'];

                    let added = this.userNodes.some(userNode => {
                        return userNode.id === node.id;
                    });

                    // if (added) {
                    //     classes.push('added');
                    // }

                    // if (this.selectedNode && this.selectedNode.id === node.id) {
                    //     classes.push('selected');
                    // }

                    let markerIcon = L.divIcon({
                        html: '<i class="' + classes.join(' ') + '"></i>',
                        iconAnchor: [16, 32],
                    });

                    let marker = L.marker([node.location.lat, node.location.lng], { icon: markerIcon });
                    marker.on('click', (event) => {
                        // Reset selections??

                        // Check id node is already added to userNodes
                        // and highlight the node in sidebar
                        let alreadySelected = this.userNodes.some(userNode => {
                            return userNode.id === node.id;
                        });

                        if (alreadySelected) {
                            // Set selected on node to highlight in sidebar
                            let index = this.userNodes.findIndex(userNode => {
                                return userNode.id === node.id;
                            });

                            this.userNodes[index].selected = !this.userNodes[index].selected;
                        } else if (this.selectedNode && node.id === this.selectedNode.id) {
                            // If node is already selected (selectedNode) we reset and remove it from the sidebar since it's not permanently added
                            this.resetSelectedNode();
                        } else {
                            // Set selected node
                            this.resetSelectedNode();
                            this.selectedNode = node;
                        }
                    }, this);

                    markers.addLayer(marker);
                }

                this.map.addLayer(markers);
            },
        },
        methods: {
            fetchNodes() {
                axios.all([
                    axios.get('/api/nodes'),
                    axios.get('/api/account/users/user'),
                    axios.get('/api/account/producers/' + this.producerId + '/nodes'),
                ])
                .then(axios.spread((allNodes, user, userNodes) => {
                    this.nodes = allNodes.data.nodes;
                    this.user = user.data;
                    this.userNodes = userNodes.data.map(userNode => {
                        userNode.selected = false;
                        return userNode;
                    });


                    this.createMap();
                }));
            },

            createMap() {
                this.map = L.map(this.$refs.map, {
                    attributionControl: false,
                    center: this.user.location,
                    zoom: 8,
                    scrollWheelZoom: false,
                });

                let mapboxUrl = 'https://api.mapbox.com/styles/v1/davidajnered/cjbhze779dawz2sp6vvsw4ktq/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZGF2aWRham5lcmVkIiwiYSI6ImNpenZxcWhoMzAwMGcyd254dGU4YzNkMjQifQ.DJncF9-KJ5RQAozfIwlKDw';

                let tileLayer = L.tileLayer(mapboxUrl, {
                    attribution: '© <a href="https://www.mapbox.com/map-feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                    subdomains: 'abcd',
                    maxZoom: 19
                });

                tileLayer.addTo(this.map);
            },

            addNode(node) {
                let component = this;

                axios.get('/api/account/producers/' + this.producerId + '/nodes/' + node.id + '/add')
                .then(data => {
                    component.userNodes = data.data;
                    component.cancelNode();
                });
            },

            removeNode(node) {
                let component = this;
                axios.get('/api/account/producers/' + this.producerId + '/nodes/' + node.id + '/remove')
                .then(data => {
                    component.userNodes = data.data;
                });
            },

            cancelNode(node) {
                this.selectedNode = null;
                this.resetSelectedNode();
            },

            resetSelectedNode() {
                let selectedMarker = document.getElementsByClassName('leaflet-marker selected');
                if (selectedMarker.length > 0) {
                    selectedMarker[0].classList.remove('selected');
                }

                this.selectedNode = null;
            }
        },
    }
</script>
