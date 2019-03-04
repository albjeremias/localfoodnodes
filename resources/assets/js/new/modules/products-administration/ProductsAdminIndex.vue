<template>
    <div>
        <div class="row mb-3">
            <div class="col-16 d-flex justify-content-between align-items-center">
                <h2>Products</h2>
                <a :href="'/account/producer/'+producer.id+'/product/create'" class="btn btn-primary wc box-shadow">Create new product</a>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-16">
                <div class="white-box">
                    <!-- Filter location -->
                    <div class="dropdown dropdown-form">
                        <span class="dropdown-toggle w-100 select-location" href="#" role="button" id="select-location" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ selectLocationLabel }}
                        </span>
                        <div class="dropdown-menu dropdown-form-menu" aria-labelledby="select-location">
                            <div class="dropdown-item">Nodes</div>
                            <div v-for="node in nodes" :key="node.id" @click="setSelectedNode(node)" class="dropdown-item"><small>- {{ node.name }}</small></div>

                            <div class="dropdown-item mt-2">Ad Hocs</div>
                            <a class="dropdown-item" @click="adHocLocation = !adHocLocation"><small class="rc text-uppercase font-weight-bold">- Add new location</small></a>

                            <div class="dropdown-item mt-2">Home deliveries</div>
                            <a class="dropdown-item" href="#"><small class="font-italic">- Not yet available</small></a>
                        </div>
                    </div>

                    <!-- Filter date -->
                    <div class="tags mt-3">
                        <div v-for="date in nodeDeliveryDates" :key="date" @click="setSelectedDate(date)" class="tag d-inline">
                            <label class="tag-label badge badge-light" :class="{'selected': date == selectedDate}">{{ date }}</label>
                        </div>
                        <a class="dropdown-item" href="#"><small class="rc text-uppercase font-weight-bold">- Add new date</small></a>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="adHocLocation">
            <h4>Ad hoc location</h4>
            <p>En kort beskrivande text om vad ad hoc är</p>
            <div class="form-row">
                <div class="form-group col-16">
                    <label for="">Location name</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Location name">
                    </div>
                </div>

                <div class="form-group col-md-8">
                    <label for="">Address</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Address">
                    </div>
                </div>

                <div class="form-group col-8 col-md-4">
                    <label for="">Zip</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Zip">
                    </div>
                </div>

                <div class="form-group col-8 col-md-4">
                    <label for="">City</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="City">
                    </div>
                </div>
            </div>

            <a class="rc" @click="adHocLocation = !adHocLocation">cancel</a>
            <button class="btn btn-secondary ml-auto">Save</button>
        </div>

        <div class="row">
            <h2>Product list</h2>
            <div class="row">
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

        <div class="row">
            <h2>The other products...</h2>
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
</template>

<script>
    import ProductEdit from './../../cards/ProductEdit';
    import Info from './../../components/info';

    export default {
        props: ['producer', 'lang'],
        data: function() {
            return {
                activeProductIds: [],
                adHocLocation: false,
                info: {},
                nodes: [],
                nodeDeliveryDates: [],
                products: [],
                selectedNode: false,
                selectedDate: false,
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
            selectedNode() {
                this.selectedDate = null;
                this.fetchDeliveryDates();
            },
            selectedDate() {
                this.fetchProducts();
            }
        },
        methods: {
            setSelectedNode(node) {
                this.selectedNode = node;
                this.selectedDate = null;

                window.history.pushState({}, 'node', `?node=${this.selectedNode.id}`);
            },
            setSelectedDate(date) {
                this.selectedDate = date;
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

                }).catch((error) => {

                });
            },
            fetchDeliveryDates() {
                axios.get(`/${this.lang}/api/account/nodes/${this.selectedNode.id}/deliveries`).then((response) => {
                    this.nodeDeliveryDates = response.data;

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
        },
        components: {
            ProductEdit, Info
        }
    }
</script>
