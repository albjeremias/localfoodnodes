<template>
    <div class="product product-edit">
        <div class="visibility-overlay">
            <div class="m-auto">
                <a :href="'/account/producer/' + producer.id + '/product/' + product.id"><h2 class="text-center mb-5 wc">{{ product.name }}</h2></a>
                <button class="btn btn-lg btn-white bb px-5">Make available</button>
            </div>
        </div>

        <div class="product__img-container image bg-img-basket" style="">
            <small class="product__img-container__tag">{{ tag }}</small>
        </div>

        <div class="product-container px-3 py-1">

            <a :href="'/account/producer/' + producer.id + '/product/' + product.id"><h4 class="rc h10 mt-1 line-clamp-1 d-inline-block">{{ product.name }}</h4></a>
            <i class="fas fa-share-alt"></i>

            <select v-if="variants.length > 0" class="custom-select bb-38">
                <option v-for="variant in variants" :key="variant.id">
                    {{ variant.name }}
                </option>
            </select>

            <div v-else class="divider d-flex">
                <select class="w-100"></select>
            </div>

            <div class="form-container">
                <hr class="mb-2">



                <p class="mb-2 d-inline-block">Delivery date settings</p>
                <info :text="info.settings.text" :placement="info.settings.placement" :icon-class="info.settings.class"></info>

                <div class="product-edit-form">
                    <input type="text" aria-describedby="input-aria-name" name="name" class="form-control input-group" id="form-input-stock" value="" placeholder="Stock" autocomplete="off">
                    <input type="text" aria-describedby="input-aria-name" name="name" class="form-control input-group mx-lg-1" id="form-input-price" value="" placeholder="Price" autocomplete="off">
                    <input type="text" aria-describedby="input-aria-name" name="name" class="form-control input-group mr-lg-1" id="form-input-deadline" value="" placeholder="Deadline" autocomplete="off">
                </div>
                <a class="btn btn-secondary wc mt-2 w-100" @click="saveSettings()">Save changes</a>

                <i class="fas fa-unlock-alt"></i>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>

<script>
    import Info from './../components/info';

    export default {
        props: ['product', 'variants', 'images', 'tag', 'producer'],

        components: {
            Info,
        },

        data: function() {
            return {
                info: {}
            }
        },
        beforeMount () {
            this.infoSort()
        },
        watch: {
            // active: 'activateProduct'
        },
        methods: {
            saveSettings() {
                console.log(this.product.is_hidden);
            },
            toggleProductVisibility(productID) {
                axios.post('/api/account/producers/' + this.producer.id + '/products/' + productID + '/toggle-visibility', this.info).then((response) => {

                }).catch((error) => {
                    this.errors = error.response.data
                    console.log(error);
                });
            },
            infoSort() {
                this.info.available = {
                    placement: 'right',
                    text: 'Make this product available to be booked for selected delivery date.',
                    class: '',
                }
                this.info.settings = {
                    placement: 'right',
                    text: 'Finetune your stock, price, and booking deadline for this delivery date.',
                    class: '',
                }
            }
        }
    }
</script>
