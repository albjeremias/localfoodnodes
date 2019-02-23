<template>
    <div>
        <div class="row">
            <div class="col-md-16">
                <h2>Products</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="white-box little-min">
                    <h4>Deliveries</h4>
                    <p>{{ info.deliveries.text }}</p>

                    <div>
                        <div class="dropdown show dropdown-form d-inline-flex">
                            <span class="dropdown-toggle w-100 select-location" href="#" role="button" id="select-location" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ selectLocationLabel }}
                            </span>
                            <div class="dropdown-menu dropdown-form-menu" aria-labelledby="select-location">
                                <a class="dropdown-item" href="#">Nodes</a>
                                <a v-for="node in nodes" :key="node.id" @click="selectedNode = node" class="dropdown-item" href="#"><small>- {{ node.name }}</small></a>

                                <a class="dropdown-item" href="#">Ad Hocs</a>
                                <a class="dropdown-item" href="#"><small class="rc text-uppercase font-weight-bold">- Add new</small></a>

                                <a class="dropdown-item" href="#">Home deliveries</a>
                                <a class="dropdown-item" href="#"><small class="font-italic">- Not yet available</small></a>
                            </div>
                        </div>

                        <div class="my-3 text-center">and</div>

                        <!-- Select date -->
                        <div class="dropdown show dropdown-form d-inline-flex">
                            <span class="dropdown-toggle w-100 select-location" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ selectDateLabel }}
                            </span>

                            <div class="dropdown-menu dropdown-form-menu" aria-labelledby="dropdownMenuLink">
                                <a v-for="date in nodeDeliveryDates" :key="date" @click="selectedDate = date" class="dropdown-item" href="#">{{ date }}</a>

                                <a class="dropdown-item" href="#"><small class="rc text-uppercase font-weight-bold">- Add new date</small></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="white-box little-min">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4>Product list</h4>
                        <i class="fa fa-share-alt mr-2" aria-hidden="true"></i>
                    </div>
                    <div v-if="selectedNode && selectedDate">
                        <div v-if="activeProducts.length > 0">
                            <p>These are the products you've activated for <strong>{{ selectedNode.name }}</strong> on the <strong>{{ selectedDate }}</strong></p>
                            <span v-for="product in activeProducts" :key="product.id" class="badge badge-light">{{ product.name }}</span>
                        </div>
                        <div v-else>
                            <p>No products activated for this delivery</p>
                        </div>
                    </div>
                    <p v-if="!selectedNode || !selectedDate">
                        Here you will see all your products that's been activated for a specific delivery
                    </p>

                    <!-- Slick -->
                    <!-- <div class="slick-container">
                        <div v-for="product in this.products" :key="product.id" class="slick-image mx-auto">
                            <div class="w-100 h-100" v-if="selectedNode && selectedDate && product.delivery_links_relationship && product.delivery_links_relationship.length > 0">
                                <img class="rounded-circle w-100 h-100" src="/images/shutterstock_436974091.jpg">
                                <small class="d-block text-center pt-1">{{ product.name }}</small>
                            </div>

                            <div v-if="!selectedNode || !selectedDate">
                                <img class="rounded-circle w-100 h-100" src="/images/shutterstock_436974091.jpg">
                                <small class="d-block text-center pt-1">{{ product.name }}</small>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>

        <div class="row mt-5 mb-4">
            <div class="col-16 text-right">
                <a :href="'/account/producer/'+producer.id+'/product/create'" class="btn btn-primary wc box-shadow">Create new product</a>
            </div>
        </div>

        <div class="row">
            <div v-for="product in products" v-bind:key="product.id" class="col-16 col-lg-8 col-xl-4 mb-3">
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
</template>

<script>
    import ProductEdit from './../../cards/ProductEdit';
    import Info from './../../components/info';

    export default {
        props: ['producer', 'lang'],
        data: function() {
            return {
                activeProductIds: [],
                allProductActive: false,
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
                })
            }
        },
        watch: {
            allProductActive: 'activateAllProducts',
            selectedNode: function () {
                this.selectedDate = null;
                this.fetchDeliveryDates();
                this.fetchProducts();
            },
            selectedDate: function () {
                this.fetchProducts();
            }
        },
        methods: {
            activateAllProducts() {
                console.log(this.allProductActive);
            },
            fetchNodes() {
                axios.get(`/${this.lang}/api/account/producers/${this.producer.id}/nodes`).then((response) => {
                    this.nodes = response.data;
                }).catch((error) => {

                });
            },
            fetchDeliveryDates() {
                axios.get(`/${this.lang}/api/account/nodes/${this.selectedNode.id}/deliveries`).then((response) => {
                    this.nodeDeliveryDates = response.data;
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
