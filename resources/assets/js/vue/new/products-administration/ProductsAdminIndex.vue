<template>
    <div class="row">
        <div class="col-md-16 d-flex pb-4">
            <h2 class="d-inline h1 mb-0 bc">Products administration</h2>
            <a :href="'/account/producer/'+producer.id+'/product/create'" class="btn btn-primary ml-auto d-inline-flex">Create new product</a>
        </div>


        <div class="col-md-8">
            <div class="white-box little-min">
                <h4 class="position-absolute">Dates</h4>

                <div class="d-flex h-100">
                    <div class="my-auto w-100">
                        <div class="dropdown show dropdown-form d-inline-flex mb-3">

                            <!--Select location-->
                            <span class="dropdown-toggle w-100 select-location" href="#" role="button" id="select-location" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Select location
                            </span>

                            <div class="dropdown-menu dropdown-form-menu" aria-labelledby="select-location">
                                <a class="dropdown-item" href="#">Nodes</a>
                                <a class="dropdown-item" href="#"><small>-En nod</small></a>

                                <a class="dropdown-item" href="#">Ad Hocs</a>
                                <a class="dropdown-item" href="#"><small class="rc text-uppercase font-weight-bold">-Add new</small></a>

                                <a class="dropdown-item" href="#">Home deliveries</a>
                                <a class="dropdown-item" href="#"><small class="font-italic">-Not yet available</small></a>
                            </div>
                        </div>

                        <span>and</span>

                        <!-- Select date -->
                        <div class="dropdown show dropdown-form d-inline-flex mt-3">
                            <span class="dropdown-toggle w-100 select-location" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Select date
                            </span>

                            <div class="dropdown-menu dropdown-form-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">1992-05-29</a>
                                <a class="dropdown-item" href="#">2019-01-15</a>

                                <a class="dropdown-item" href="#"><small class="rc text-uppercase font-weight-bold">-Add new date</small></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="white-box little-min">
                <h4>Product list</h4>
                <small class="pt-3">Till utlämningen "<strong>Nodens namn</strong>" "<strong>datum</strong>" har "<strong>gårdens namn</strong>" följande produkter till salu.</small>

                <!-- Slick -->
                <div class="slick-container">
                    <div class="">
                        <div class="slick-image mx-auto">
                            <img class="rounded-circle w-100 h-100" src="/images/shutterstock_436974091.jpg">
                            <small class="d-block text-center pt-1">Test 1</small>
                        </div>
                    </div>
                </div>

                <input type="text" class="form-control form-control-sm input-buttom-r w-75" readonly value="https://lfn.org/bla">
                <a href="#" class="bottom-link text-uppercase rc">Copy link</a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-16">
                <div class="custom-control custom-checkbox products-active-all">
                    <input type="checkbox" v-model="allProductActive" name="" class="custom-control-input" id="activate-all">
                    <label class="custom-control-label" for="activate-all">Activate all products</label>
                </div>
            </div>

            <div v-for="product in products" class="col-16 col-lg-8 col-xl-5 mb-3">
                <card-product-edit
                        :product="product"
                        :producer="producer"
                        :tag="'CSA'"
                        :variants="{}"
                ></card-product-edit>
            </div>
        </div>

    </div>
</template>

<style scoped>
</style>

<script>
    import ProductEdit from './../cards/ProductEdit';

    export default {
        props: ['producer', 'products'],
        data: function() {
            return {
                allProductActive: false
            }
        },
        mounted () {
            // Do something useful with the data in the template
        },
        watch: {
            allProductActive: 'activateAllProducts'
        },
        methods: {
            activateAllProducts() {
                console.log(this.allProductActive);
            },
        },
        components: {
            ProductEdit,
        }
    }
</script>
