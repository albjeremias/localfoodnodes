<template>
    <div class="map-container">
        <div ref="map">Loading...</div>
        <div class="map-site-info p-3 d-none d-xl-block">
            <!-- Metrics -->
            <div v-if="metrics" class="row">
                <div class="col">
                    <h4 class="m-0">{{ metrics.users.count }}</h4>
                    <small>{{ metrics.users.label }}</small>
                </div>

                <div class="col px-5">
                    <h4 class="m-0">{{ metrics.nodes.count }}</h4>
                    <small>{{ metrics.nodes.label }}</small>
                </div>

                <div class="col">
                    <h4 class="m-0">{{ metrics.producers.count }}</h4>
                    <small>{{ metrics.producers.label }}</small>
                </div>
            </div>

            <!-- Search -->
            <div class="row">
                <input v-on:keyup="search" type="text" placeholder="Search locations" />
            </div>

            <!-- Search results -->
            <div v-if="searchResults" class="row">
                <ul>
                    <li v-for="result in searchResults" v-bind:key="result.place_id" v-on:click="selectSearchResult(result.lat, result.lon)">
                        <div>{{ result.display_name.split(',')[0] }}</div>
                        <small>{{ result.display_name.split(',').splice(1).join(', ') }}</small>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Node info sidebar -->
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
                metrics: null,
                nodes: [],
                selectedNode: null,
                searchResults: null,
            }
        },
        mounted() {
            this.fetchNodes();
            this.fetchMetrics();
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
                });
            },

            fetchMetrics() {
                axios.get(`${this.lang}/api/mapMetrics`)
                .then(metrics => {
                    this.metrics = metrics.data;
                });
            },

            createMap() {
                this.map = L.map(this.$refs.map, {
                    attributionControl: false,

                    // @Todo: how to center?!!!!!!!!

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
            },

            search(event) {
                axios({
                    url: 'https://nominatim.openstreetmap.org/search',
                    method: 'get',
                    params: {
                        q: event.target.value,
                        format: 'json',
                        addressdetails: 1,
                        featuretype: 'settlement'
                    }
                })
                .then(searchResults => {
                    this.searchResults = searchResults.data;
                });
            },

            debounce(func, wait, immediate) {
                let timeout;

                return function() {
                    let context = this, args = arguments;
                    let later = function() {
                        timeout = null;
                        if (!immediate) {
                            func.apply(context, args);
                        }
                    };
                    let callNow = immediate && !timeout;
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);

                    if (callNow) {
                        func.apply(context, args);
                    }
                };
            },

            selectSearchResult(lat, lng) {
                this.map.panTo(new L.LatLng(lat, lng));
            }
        },
    }
</script>
