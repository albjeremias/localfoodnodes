<template>
    <div class="map-container">
        <div class="white-box map-site-metrics">
            <!-- Metrics -->
            <div v-if="metrics && !searchResults" class="row">
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
            <div class="input-group" :class="{ 'mt-3': metrics, 'mb-3': searchResults }">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                </div>
                <input v-model="searchString" type="text" class="form-control" placeholder="Search locations" />
            </div>

            <!-- Search results -->
            <ul class="list-unstyled">
                <li v-for="result in searchResults" :key="result.place_id" v-on:click="selectSearchResult(result.lat, result.lon)">
                    <div>{{ result.display_name.split(',')[0] }}</div>
                    <small>{{ result.display_name.split(',').splice(1).join(', ') }}</small>
                </li>
            </ul>
        </div>

        <!-- Node info sidebar -->
        <transition>
            <div v-if="selectedNode" class="white-box sidebar">
                <h4>{{ selectedNode.name }}</h4>
                <div class="row no-gutters">
                    <div class="col">
                        <div>{{ selectedNode.name }}</div>
                        <small><a :href="selectedNode.permalink_relationship.url">Visit node</a></small>
                    </div>
                </div>
            </div>
        </transition>

        <div ref="map"></div>
    </div>
</template>

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
                searchString: '',
                debouncedSearch: this.debounce(this.search, 300),
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

                    let markerIcon = L.divIcon({
                        html: '<i class="' + classes.join(' ') + '"></i>',
                        iconAnchor: [16, 32],
                    });

                    let marker = L.marker([node.location.lat, node.location.lng], { icon: markerIcon });
                    marker.on('click', (event) => {
                        if (this.selectedNode && node.id === this.selectedNode.id) {
                            this.resetSelectedNode();
                        } else {
                            this.resetSelectedNode();

                            this.selectedNode = node;
                            $(marker._icon).addClass('selected');
                        }
                    }, this);

                    markers.addLayer(marker);
                }

                this.map.addLayer(markers);
            },

            searchString(searchString) {
                this.debouncedSearch(searchString);
            }
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

            search(searchString) {
                if (!searchString) {
                    this.searchResults = null;
                } else {
                    return axios({
                        url: 'https://nominatim.openstreetmap.org/search',
                        method: 'get',
                        params: {
                            addressdetails: 1,
                            featuretype: 'settlement',
                            format: 'json',
                            limit: 5,
                            q: searchString,
                        }
                    })
                    .then(searchResults => {
                        this.searchResults = searchResults.data;
                    });
                }
            },

            selectSearchResult(lat, lng) {
                this.map.panTo(new L.LatLng(lat, lng));
            }
        },
    }
</script>
