<template>
    <div class="product product-edit">
        <div class="product__img-container image bg-img-basket" style="">
            <span class="product__img-container__quantity">KVAR</span>
            <!--<span class="product-items-quantity badge badge-warning">SLUT</span>-->

            <div class="transparent-circle-icon-bg">
                <i class="product__img-container__share" aria-hidden="true"></i>
            </div>

            <small class="product__img-container__tag">{{ tag }}</small>
        </div>

        <div class="product-container px-3 py-1">

            <a :href="'/account/producer/' + producer.id + '/product/' + product.id"><h4 class="rc h10 mt-1 line-clamp-1">{{ product.name }}</h4></a>

            <select v-if="variants.length > 0" class="custom-select bb-38">
                <option v-for="variant in variants" :key="variant.id">
                    {{ variant.name }}
                </option>
            </select>

            <div v-else class="divider d-flex">
                <small class="font-italic my-auto">This product doesn't have any variants</small>
            </div>

            <div class="form-container">
                <hr class="mb-2">
                <p class="mb-2 rc d-inline-block">Delivery date settings</p>
                <info :text="info.settings.text" :placement="info.settings.placement" :class="info.settings.class"></info>

                <div class="product-edit-form">
                    <input type="text" aria-describedby="input-aria-name" name="name" class="form-control input-group w-25" id="form-input-stock" value="" placeholder="Stock" autocomplete="off">
                    <input type="text" aria-describedby="input-aria-name" name="name" class="form-control input-group w-25 mx-lg-1" id="form-input-price" value="" placeholder="Price" autocomplete="off">
                    <input type="text" aria-describedby="input-aria-name" name="name" class="form-control input-group w-25 mr-lg-1" id="form-input-deadline" value="" placeholder="Deadline" autocomplete="off">
                    <a class="btn btn-secondary wc" @click="saveSettings()">Save</a>
                </div>
            </div>

            <div class="custom-control custom-checkbox custom-checkbox-lg product-edit-active">
                <input type="checkbox" :checked="product.is_hidden" @click="product.is_hidden = !product.is_hidden" :name="'checkbox-active-' + product.id" class="custom-control-input" :id="'checkbox-active-' + product.id">
                <label class="custom-control-label" :for="'checkbox-active-' + product.id">Make available</label>
                <info :text="info.available.text" :placement="info.available.placement" :class="info.available.class"></info>
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
