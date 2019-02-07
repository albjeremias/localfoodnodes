<template>
    <div class="product product-edit">
        <div class="product__img-container image bg-img-basket" style="">
            <span class="product__img-container__quantity">KVAR</span>
            <!--<span class="product-items-quantity badge badge-warning">SLUT</span>-->

            <i class="product__img-container__share" aria-hidden="true"></i>

            <small class="product__img-container__tag">{{ tag }}</small>
        </div>

        <div class="product-container px-3 py-1">

            <h4 class="h10 mt-1 line-clamp-1">{{ product.name }}</h4>

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
                <p class="mb-2 rc">Settings</p>

                <div class="product-edit-form">
                    <input type="text" aria-describedby="input-aria-name" name="name" class="form-control input-group w-25" id="form-input-stock" value="" placeholder="Stock" autocomplete="off">
                    <input type="text" aria-describedby="input-aria-name" name="name" class="form-control input-group w-25 mx-lg-1" id="form-input-price" value="" placeholder="Price" autocomplete="off">
                    <input type="text" aria-describedby="input-aria-name" name="name" class="form-control input-group w-25 mr-lg-1" id="form-input-deadline" value="" placeholder="Deadline" autocomplete="off">
                    <a class="btn btn-secondary wc" @click="saveSettings()">Save</a>
                </div>
            </div>

            <a class="bottom-link rc" :href="'/account/producer/' + producer.id + '/product/' + product.id ">ADVANCED SETTINGS</a>

            <div class="custom-control custom-checkbox custom-checkbox-lg product-edit-active">
                <input type="checkbox" :checked="product.is_hidden" @click="product.is_hidden = !product.is_hidden" :name="'checkbox-active-' + product.id" class="custom-control-input" :id="'checkbox-active-' + product.id">
                <label class="custom-control-label" :for="'checkbox-active-' + product.id">Active</label>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>

<script>
    export default {
        props: ['product', 'variants', 'images', 'tag', 'producer'],

        data: function() {
            return {
                //
            }
        },
        mounted () {
            //
        },
        watch: {
            // active: 'activateProduct'
        },
        methods: {
            saveSettings() {
                console.log(this.product.is_hidden);
            },
        }
    }
</script>
