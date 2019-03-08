<template>
    <div class="bg-shell nm" id="products-administration">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <div class="col-md-16">
                        <div class="white-box product-info">
                            <h2 class="text-center">{{ activeProduct.name }}</h2>
                            <img
                                v-if="productImage"
                                class="my-2 box-shadow-square"
                                style="width: 100%; height: 300px; object-fit: cover;"
                                :src="productImage[0].urls.medium"/>
                            <p v-html="activeProduct.info"></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="white-box producer-info">
                        <h4 class="rc mb-0">{{ producer.name }}</h4>
                        <small>{{ producer.email }}</small>
                        <span class="pt-3" v-html="producer.info"></span>
                    </div>

                    <div class="white-box producer-products">
                        <div class="d-flex">
                            <a :href="'/account/producer/' + producer.id + '/products'" class="rc">
                                <h4>{{ producer.name }} products</h4>
                            </a>
                        </div>
                        <div class="overflow-scroll h-100">
                            <div class="producer-products-list">
                                <ul class="list-unstyled node-list mt-2 list-group">
                                    <a v-for="producerProduct in producerProducts" @click="getProduct(producerProduct.id)" class="my-0 py-2 list-group-item-action">
                                        <div class="products-list-image">
                                            <img class="box-shadow" src="/images/shutterstock_436974091.jpg">
                                        </div>
                                        <small class="col black-87">{{ producerProduct.name }}</small>
                                    </a>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-16">
                    <div class="white-box">

                            <b-dropdown id="ddown1" class="m-md-2 d-inline-block rounded">
                                <template slot="button-content">
                                    <span v-if="selectedVariant">{{ selectedVariant.name }}</span>
                                    <span v-else>Variant</span>
                                </template>
                                <b-dropdown-item v-for="variant in variants" :key="variant.id" @click="selectedVariant = variant">{{ variant.name }}</b-dropdown-item>
                            </b-dropdown>

                        <div class="dropdown show dropdown-form d-inline-flex mt-3 w-25">
                            <span class="dropdown-toggle w-100 select-location" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Select pickup spot
                            </span>

                            <div class="dropdown-menu dropdown-form-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#"></a>

                                <a class="dropdown-item" href="#"><small class="rc text-uppercase font-weight-bold">-Add new date</small></a>
                            </div>
                        </div>

                        <div class="delivery-dates-container">
                            <div class="row p-1">
                                <div v-for="date in [1,2,3,4,5,6,7,8,9,10,11,12]" class="col-md-4">
                                    <div class="box-shadow-square mb-3 p-2">
                                        <h3 class="text-center rc">29-05-2018</h3>
                                        <h5 class="text-center mt-2">129 kr</h5>
                                        <div class="text-center mt-2">
                                            <div class="d-inline-block mr-4">
                                                <p class="m-0">3</p>
                                                <small>Saldo</small>
                                            </div>

                                            <div class="d-inline-block">
                                                <p class="m-0">1</p>
                                                <small>Deadline</small>
                                            </div>
                                        </div>

                                        <input type="text" aria-describedby="input-aria-name" name="quantity" class="form-control input-group mt-2" id="form-input-stock" value="" placeholder="Quantity..." autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mt-4">
                                <textarea class="d-inline-block w-100" rows="4" placeholder="Medelande till producent..."></textarea>
                            </div>
                            <div class="col-md-8 d-flex">
                                <div class="m-auto">
                                    <button class="btn btn-primary">Lägg till i varukorg</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import BootstrapVue from 'bootstrap-vue';
    import 'bootstrap-vue/dist/bootstrap-vue.css'

    export default {
        props: ['product'],
        components: { BootstrapVue },
        data: function() {
            return {
                activeProduct: this.product,
                producer: this.product.producer_relationship,
                producerProducts: this.product.producer_relationship.products_relationship,

                variants: [],
                selectedVariant: false,
            }
        },
        computed: {
            productImage() {
                if (this.activeProduct.image_relationship.length > 0) {
                    return this.activeProduct.image_relationship;
                }
            },
        },
        beforeMount () {
        },
        mounted() {
            this.getVariants();
        },
        watch: {
        },
        methods: {
            getProduct(id) {
                axios.get('/api/account/producers/' + this.producer.id + '/products/' + id)
                    .then(response => {
                        this.activeProduct = response.data;
                        this.getVariants();
                });
            },
            getVariants() {
                axios.get('/api/account/producers/' + this.producer.id + '/products/' + this.activeProduct.id + '/variants')
                    .then(response => {
                        this.variants = response.data.variants;
                    });
            },
        },
    }
</script>
