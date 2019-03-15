<template>
    <div>
        <div class="row mb-3">
            <div class="col-16 d-flex justify-content-between align-items-center">
                <h2>Products</h2>
                <a :href="'/account/producer/'+producer.id+'/product/create'" class="btn btn-primary wc box-shadow">Create new product</a>
            </div>
        </div>

        <div class="row mb-5">
            <div v-if="!adHocLocation" class="col-16">
                <div class="white-box">
                    <p>Filter on delivery location and dates</p>
                    <!-- Filter location -->
                    <div class="dropdown dropdown-form">
                        <div class="dropdown-toggle w-100 select-location" href="#" role="button" id="select-location" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ selectLocationLabel }}
                        </div>
                        <div class="dropdown-menu dropdown-form-menu" aria-labelledby="select-location">
                            <div v-if="producer.farm_delivery_link">
                                <div class="dropdown-item mt-2">Farm delivery</div>
                                <div class="dropdown-item" @click="setSelectedNode(producer.farm_delivery_link.node_relationship)"><small>- {{ producer.name }}</small></div>
                            </div>

                            <div class="dropdown-item mt-2">Nodes</div>
                            <div v-for="node in nodes" :key="node.id" @click="setSelectedNode(node)" class="dropdown-item"><small>- {{ node.name }}</small></div>

                            <div class="dropdown-item mt-2">Ad Hocs</div>
                            <a class="dropdown-item" @click="adHocLocation = !adHocLocation"><small class="rc text-uppercase font-weight-bold">- Add new location</small></a>

                            <div class="dropdown-item mt-2">Home deliveries</div>
                            <a class="dropdown-item" href="#"><small class="font-italic">- Not yet available</small></a>
                        </div>
                    </div>

                    <!-- Filter date -->
                    <div v-if="selectedNode" class="tags mt-3">
                        <div v-for="date in dates" :key="date.unix()" @click="setSelectedDate(date)" class="tag d-inline">
                            <label class="tag-label badge badge-light" :class="{'selected': date.format('YYYY-MM-DD') == selectedDate}">
                                <i v-if="selectedNode.is_adhoc || selectedNode.is_farm" class="fa fa-times-circle delete" @click="deleteDate(date)"></i> {{ date.format('YYYY-MM-DD') }} <small>{{ date.format('HH:mm') }}</small>
                            </label>
                        </div>

                        <hr v-if="selectedNode && (selectedNode.is_adhoc || selectedNode.is_farm)" />

                        <div class="tag d-inline" v-if="selectedNode && (selectedNode.is_adhoc || selectedNode.is_farm)">
                            <button id="add-new-date-button" class="btn btn-primary wc picker datetime confirm" @click="openDatepicker">Add new date</button>
                            <datetime ref="datepicker" v-model="datepickerDate" zone="UTC" value-zone="UTC" type="datetime" input-class="hidden"></datetime>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="adHocLocation" class="col-16">
                <div class="white-box">
                    <h4>Ad hoc location</h4>
                    <p>En kort beskrivande text om vad ad hoc är</p>

                    <div class="form-row">
                        <div class="form-group col-16">
                            <label for="">Location name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Location name" v-model="adHocLocationData.name">
                            </div>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="">Address</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Address" v-model="adHocLocationData.address">
                            </div>
                        </div>

                        <div class="form-group col-8 col-md-4">
                            <label for="">Zip</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Zip" v-model="adHocLocationData.zip">
                            </div>
                        </div>

                        <div class="form-group col-8 col-md-4">
                            <label for="">City</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="City" v-model="adHocLocationData.city">
                            </div>
                        </div>

                        <a class="rc" @click="adHocLocation = !adHocLocation">cancel</a>
                        <button class="btn btn-secondary ml-auto" @click="saveAdHocLocation">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row py-2" v-if="selectedNode && selectedDate">
            <div class="col-16">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Product list</h2>
                </div>
                <p>These are the products you've activated for <b>{{ selectedNode.name }}</b> on the <b>{{ selectedDate }}</b></p>
                <div class="btn btn-outline-secondary"><i class="fa fa-share-alt mr-2" aria-hidden="true"></i> Share product list</div>

                <div class="row mt-5">
                    <div v-for="product in activeProducts" v-bind:key="product.id" class="col-16 col-lg-8 col-xl-4 mb-3">
                        <card-product-edit
                            :producer="producer"
                            :product="product"
                            :node="selectedNode"
                            :date="selectedDate"
                            :lang="lang"
                            loading="loading"
                            @changed="fetchProducts">
                        </card-product-edit>
                    </div>
                </div>
            </div>
        </div>

        <div class="row py-2">
            <div class="col-16">
                <h2>Your products</h2>
                <div class="row">
                    <div v-for="product in inactiveProducts" v-bind:key="product.id" class="col-16 col-lg-8 col-xl-4 mb-3">
                        <card-product-edit
                            :producer="producer"
                            :product="product"
                            :node="selectedNode"
                            :date="selectedDate"
                            :lang="lang"
                            loading="loading"
                            @changed="fetchProducts">
                        </card-product-edit>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { DateTime } from 'vue-datetime';
    import 'vue-datetime/dist/vue-datetime.css';

    import ProductEdit from './../../cards/ProductEdit';
    import Info from './../../components/info';

    export default {
        props: ['producer', 'lang'],
        components: {
            ProductEdit,
            Info,
            DateTime
        },
        data: function() {
            return {
                activeProductIds: [],
                adHocLocation: false,
                adHocLocationData: {
                    name: null,
                    address: null,
                    zip: null,
                    city: null,
                },
                info: {},
                nodes: [],
                dates: [],
                products: [],
                selectedNode: false,
                selectedDate: false,
                datepickerDate: null,
            }
        },
        beforeMount() {
            this.infoSort();
            this.fetchNodes();
            this.fetchProducts();
        },
        computed: {
            selectLocationLabel() {
                return this.selectedNode ? this.selectedNode.name : 'Select location';
            },
            selectDateLabel() {
                return this.selectedDate ? this.selectedDate : 'Select date';
            },
            activeProducts() {
                return this.products.filter(product => {
                    return product.delivery_links_relationship && product.delivery_links_relationship.length > 0;
                });
            },
            inactiveProducts() {
                return this.products.filter(product => {
                    return !product.delivery_links_relationship || product.delivery_links_relationship.length == 0;
                });
            }
        },
        watch: {
            datepickerDate() {
                if (this.datepickerDate) {
                    axios.post(`/${this.lang}/api/account/nodes/${this.selectedNode.id}/date`, {
                        date: this.datepickerDate
                    }).then((response) => {
                        this.dates = [];
                        response.data.forEach(date => {
                            this.dates.push(moment(date));
                        });
                    }).catch((error) => {
                        // console.error(error);
                        $(document).trigger('system-message', { type: 'error', body: error.response.data });
                    });
                }

                this.datepickerDate = null;
            },
            selectedNode() {
                this.selectedDate = null;
                if (this.selectedNode) {
                    this.fetchDates();
                }
            },
            selectedDate() {
                if (this.selectedNode) {
                    this.fetchProducts();
                }
            }
        },
        methods: {
            openDatepicker(event) {
                this.$refs['datepicker'].open(event);
            },
            deleteDate(date) {
                axios.delete(`/${this.lang}/api/account/nodes/${this.selectedNode.id}/date/${date.format('YYYY-MM-DD HH:mm')}`)
                .then((response) => {
                    $(document).trigger('system-message', { type: 'error', body: date.format('YYYY-MM-DD') + ' has been deleted' });
                    this.dates = [];
                    response.data.forEach(date => {
                        this.dates.push(moment(date));
                    });
                }).catch((error) => {
                    console.error(error);
                });
            },
            setSelectedNode(node) {
                this.selectedNode = node;
                this.selectedDate = null;

                window.history.pushState({}, 'node', `?node=${this.selectedNode.id}`);
            },
            setSelectedDate(date) {
                this.selectedDate = date.format('YYYY-MM-DD');
                this.fetchProducts();
                window.history.pushState({}, 'date', `?node=${this.selectedNode.id}&date=${this.selectedDate}`);
            },
            fetchNodes() {
                axios.get(`/${this.lang}/api/account/producers/${this.producer.id}/nodes`).then((response) => {
                    this.nodes = response.data;

                    // If node is set in query...
                    const urlParams = new URLSearchParams(window.location.search);
                    this.selectedNode = this.nodes.find((node) => {
                        return node.id == urlParams.get('node')
                    });

                    if (!this.selectedNode) {
                        // Check if farm or ad hoc and make that active!
                    }
                }).catch((error) => {
                    console.error(error);
                });
            },
            fetchDates() {
                axios.get(`/${this.lang}/api/account/nodes/${this.selectedNode.id}/dates`).then((response) => {
                    this.dates = [];
                    response.data.forEach(date => {
                        this.dates.push(moment(date));
                    });

                    // If date is set in query...
                    const urlParams = new URLSearchParams(window.location.search);
                    this.selectedDate = urlParams.get('date');
                }).catch((error) => {

                });
            },
            fetchProducts() {
                axios.get(`/${this.lang}/api/account/producers/${this.producer.id}/products`, {
                    params: {
                        all: true,
                        nodeId: this.selectedNode.id,
                        date: this.selectedDate
                    }
                })
                .then((response) => {
                    this.products = response.data;
                });
            },
            infoSort() {
                this.info.deliveries = {
                    placement: 'right',
                    text: 'Select delivery location and date to activate and administer your products.',
                    class: '',
                }
            },
            saveAdHocLocation() {
                axios.post(`/${this.lang}/api/account/nodes/${this.selectedNode.id}/deliveries`)
                .then((response) => {

                }).catch((error) => {
                    console.error(error);
                });
            }
        },
    }
</script>
