<template>
    <div class="map-container">
        <div ref="map">Loading...</div>
        <div class="white-box sidebar">
            <h4>Connected nodes</h4>
            <ul class="list-unstyled node-list">
                <li v-for="node in userNodes" v-bind:key="node.id">
                    <div class="row no-gutters">
                        <div class="col">
                            <div>{{ node.name }}</div>
                            <small><span v-on:click="removeNode(node)">Remove</span></small>
                        </div>
                    </div>
                </li>

                <li v-if="selectedNode">
                    <div class="row no-gutters">
                        <div class="col">
                            <div>{{ selectedNode.name }}</div>
                            <small><span v-on:click="addNode(selectedNode)">Confirm add</span> or <span v-on:click="cancelNode">cancel</span></small>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<style>
    .leaflet-container {
        height: 500px;
    }
    .leaflet-control-attribution,
    .leaflet-control-attribution a {
        color: #333 !important;
        font-size: 10px !important;
        font-weight: normal !important;
    }
    .leaflet-control a {
        line-height: 30px !important;
    }
    .map-container {
        position: relative;
    }
    .map-container .sidebar {
        background: #fff;
        height: calc(100% - 2rem);
        padding: 1rem;
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: 999;
    }
</style>

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
                console.log('WATCH!', nodes);
                let markers = L.markerClusterGroup({
                    iconCreateFunction: function(cluster) {
                        return L.divIcon({
                            html: '<i class="fa fa-map-pin leaflet-cluster-marker"></i',
                            iconAnchor: [16, 16],
                        });
                    },
                    showCoverageOnHover: false,
                    spiderLegPolylineOptions: { opacity: 0 }
                });

                markers.clearLayers()

                for (let i = 0; i < nodes.length; i++) {
                    let node = nodes[i];
                    let classes = ['leaflet-marker'];

                    let added = this.userNodes.some(userNode => {
                        return userNode.id === node.id;
                    });

                    if (added) {
                        classes.push('added');
                    }

                    if (this.selectedNode && this.selectedNode.id === node.id) {
                        classes.push('selected');
                    }

                    let markerIcon = L.divIcon({
                        html: '<i class="fa fa-map-marker ' + classes.join(' ') + '"></i>',
                        iconAnchor: [16, 32],
                    });

                    let marker = L.marker([node.location.lat, node.location.lng], { icon: markerIcon });
                    marker.on('click', (event) => {
                        this.resetSelectedNode();

                        // Set selected marker icon
                        let selectedIcon = L.divIcon({
                            html: '<i class="fa fa-map-marker leaflet-marker selected"></i>',
                            iconAnchor: [16, 32],
                        });
                        event.target.setIcon(selectedIcon);

                        this.selectedNode = node;
                        $(marker._icon).addClass('selected');
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
                    this.userNodes = userNodes.data;
                    this.createMap();
                }))
                .catch(function (error) {
                    console.log(error);
                });;
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

            resetSelectedNode(node) {
                let selectedMarker = document.getElementsByClassName('leaflet-marker selected');
                if (selectedMarker.length > 0) {
                    selectedMarker[0].classList.remove('selected');
                }
            }
        },
    }
</script>
