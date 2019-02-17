<template>
    <div class="product product-edit">
        <div v-if="!active" class="visibility-overlay">
            <div class="m-auto">
                <a :href="product.url"><h2 class="text-center mb-5 wc">{{ product.name }}</h2></a>
                <button class="btn btn-lg btn-white bb px-5" v-on:click="addDeliveryDate">Make available</button>
            </div>
        </div>

        <div class="product__img-container image bg-img-basket"></div>

        <div class="product-container px-3 py-1">
            <div class="flex-fill">
                <div class="d-flex align-items-center justify-content-between">
                    <a :href="product.url"><h4 class="rc h10 mt-1 line-clamp-1 d-inline-block">{{ product.name }}</h4></a>
                    <i class="fas fa-share-alt"></i>
                </div>

                <div class="form-container">
                    <hr class="mt-0 mb-2">
                    <p class="mb-2 d-inline-block">Delivery date settings</p>
                    <info :text="info.settings.text" :placement="info.settings.placement" :icon-class="info.settings.class"></info>

                    <select v-if="product.product_variants_relationship.length > 0" class="custom-select bb-38 mb-2">
                        <option v-for="variant in product.product_variants_relationship" :key="variant.id">
                            {{ variant.name }}
                        </option>
                    </select>

                    <div class="product-edit-form form-row">
                        <div class="col">
                            <input type="text" aria-describedby="input-aria-name" name="name" class="form-control" id="form-input-stock" value="" placeholder="Stock" autocomplete="off">
                        </div>
                        <div class="col">
                            <input type="text" aria-describedby="input-aria-name" name="name" class="form-control mx-lg-1" id="form-input-price" value="" placeholder="Price" autocomplete="off">
                        </div>
                        <div class="col">
                            <input type="text" aria-describedby="input-aria-name" name="name" class="form-control mr-lg-1" id="form-input-deadline" value="" placeholder="Deadline" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mb-2 mt-2">
                <a class="btn btn-secondary wc w-100" @click="saveSettings()">Save changes</a>
                <small class="rc" v-show="node && date" v-on:click="deleteDeliveryDate">Disable product for this delivery</small>
            </div>
        </div>
    </div>
</template>

<script>
    import Info from './../components/info';

    export default {
        props: ['producer', 'product', 'node', 'date', 'active', 'lang'],
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
        methods: {
            saveSettings() {
                console.log(this.product.is_hidden);
            },
            addDeliveryDate() {
                axios.post(`/${this.lang}/api/account/producers/${this.producer.id}/products/${this.product.id}/deliveries/${this.node.id}/${this.date}/add`)
                .then((response) => {
                    this.$emit('changed');
                }).catch((error) => {
                    this.errors = error.response.data
                    console.log(error);
                });
            },
            deleteDeliveryDate() {
                console.log('delete');
                axios.delete(`/${this.lang}/api/account/producers/${this.producer.id}/products/${this.product.id}/deliveries/${this.node.id}/${this.date}/delete`)
                .then((response) => {
                    console.log(response);
                    this.$emit('changed');
                }).catch((error) => {
                    console.log(errors);
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
