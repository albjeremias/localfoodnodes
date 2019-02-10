<template>
    <div class="map-container">
        <div ref="map">Loading...</div>
        <transition>
            <div v-if="selectedNode" class="white-box sidebar"> <!-- v-bind:class="{ visible: selectedNode }" -->
                <h4>{{ selectedNode.name }}</h4>
                <div class="row no-gutters">
                    <div class="col">
                        <div>{{ selectedNode.name }}</div>
                        <small><a :href="selectedNode.permalink_relationship.url">Visit node</a></small>
                    </div>
                </div>
            </div>
        </transition>
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
        position: absolute;
        top: 0.5rem;
        right: 1rem; /* padding of white box */
        z-index: 999;
        /* -webkit-transition: right 1s;
        transition: right 1s; */
    }

</style>

<script>
    export default {
        props: ['lang'],
        data: function() {
            return {
                map: null,
                nodes: [],
                selectedNode: null,
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

                    let markerIcon = L.divIcon({
                        html: '<i class="fa fa-map-marker leaflet-marker"></i>',
                        iconAnchor: [16, 32],
                    });

                    let marker = L.marker([node.location.lat, node.location.lng], { icon: markerIcon });
                    marker.on('click', (event) => {
                        if (this.selectedNode && node.id === this.selectedNode.id) {
                            this.resetSelectedNode();
                        } else {
                            this.resetSelectedNode();

                            // Set selected marker icon
                            let selectedIcon = L.divIcon({
                                html: '<i class="fa fa-map-marker leaflet-marker selected"></i>',
                                iconAnchor: [16, 32],
                            });
                            event.target.setIcon(selectedIcon);

                            this.selectedNode = node;
                            $(marker._icon).addClass('selected');
                        }
                    }, this);

                    markers.addLayer(marker);
                }

                this.map.addLayer(markers);
            },
        },
        methods: {
            fetchNodes() {
                axios.get(`${this.lang}/api/nodes`)
                .then(nodes => {
                    this.nodes = nodes.data.nodes;
                    this.createMap();
                })
                .catch(function (error) {
                    console.log(error);
                });;
            },

            createMap() {
                this.map = L.map(this.$refs.map, {
                    attributionControl: false,
                    // todo: how to center?
                    center: {
                        lat: 56,
                        lng: 13,
                    },
                    maxZoom: 12,
                    scrollWheelZoom: false,
                    zoom: 8,
                    zoomControl: false,
                });

                L.control.zoom({
                    position:'bottomleft',
                }).addTo(this.map);

                let mapboxUrl = 'https://api.mapbox.com/styles/v1/davidajnered/cjbhze779dawz2sp6vvsw4ktq/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZGF2aWRham5lcmVkIiwiYSI6ImNpenZxcWhoMzAwMGcyd254dGU4YzNkMjQifQ.DJncF9-KJ5RQAozfIwlKDw';

                let tileLayer = L.tileLayer(mapboxUrl, {
                    attribution: '© <a href="https://www.mapbox.com/map-feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                    subdomains: 'abcd',
                    maxZoom: 19
                });

                tileLayer.addTo(this.map);
            },

            resetSelectedNode(node) {
                let selectedMarker = document.getElementsByClassName('leaflet-marker selected');
                if (selectedMarker.length > 0) {
                    selectedMarker[0].classList.remove('selected');
                }

                this.selectedNode = null;
            }
        },
    }
</script>
