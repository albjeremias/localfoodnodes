<template>
    <div class="product product-edit">
        <div v-if="!active" class="visibility-overlay">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <a :href="product.url">
                    <h2 class="text-center mb-3 rc">{{ product.name }}</h2>
                </a>
                <p class="text-center">Make this product avaialble for purchases on "node" and "date"</p>
                <button class="btn btn-outline-secondary" v-on:click="addDeliveryDate">Make available</button>
            </div>
        </div>

        <div class="product__img-container image">
            <img v-if="image" :src="image">
        </div>

        <div class="product-container px-3 py-1">
            <div class="flex-fill">
                <div class="d-flex align-items-center justify-content-between">
                    <a :href="product.url">
                        <h5 class="rc h10 mt-3 line-clamp-1 d-inline-block">{{ product.name }}</h5>
                    </a>
                    <i class="fas fa-share-alt"></i>
                </div>

                <div class="form-container">
                    <hr class="mt-0 mb-2">
                    <p class="mb-2 d-inline-block">Delivery date settings</p>
                    <select v-if="product.product_variants_relationship.length > 0" @change="setVariant" class="custom-select bb-38 mb-2">
                        <option v-for="variant in product.product_variants_relationship" :key="variant.id" :value="variant.id">
                            {{ variant.name }}
                        </option>
                    </select>

                    <!-- Variants -->
                    <div v-if="selectedVariant && product.product_variants_relationship.length > 0" class="product-edit-form form-row">
                        <div class="col">
                            <label>Stock</label>
                            <input type="number" :disabled="!node || !date" v-model="quantity" aria-describedby="input-aria-name" class="form-control" id="form-input-stock" autocomplete="off">
                        </div>
                        <div class="col">
                            <label>Price</label>
                            <input type="number" :disabled="!node || !date" v-model="price" aria-describedby="input-aria-name" class="form-control" id="form-input-price" autocomplete="off">
                        </div>
                        <div class="col">
                            <label>Deadline</label>
                            <input type="number" :disabled="!node || !date" v-model="deadline" aria-describedby="input-aria-name" class="form-control" id="form-input-deadline" autocomplete="off">
                        </div>
                    </div>

                    <!-- Product - should (only?) use deliveryLink first and fallback to product... -->
                    <div v-if="!product.product_variants_relationship.length" class="product-edit-form form-row">
                        <div v-if="product.has_stock" class="col">
                            <label>Stock</label>
                            <input type="number" :disabled="!node || !date" v-model="quantity" aria-describedby="input-aria-name" class="form-control" id="form-input-stock" autocomplete="off">
                        </div>
                        <div class="col">
                            <label>Price</label>
                            <input type="number" :disabled="!node || !date" v-model="price" aria-describedby="input-aria-name" class="form-control" id="form-input-price" autocomplete="off">
                        </div>
                        <div class="col">
                            <label>Deadline</label>
                            <input type="number" :disabled="!node || !date" v-model="deadline" aria-describedby="input-aria-name" class="form-control" id="form-input-deadline" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mb-2 mt-2">
                <button class="btn btn-secondary wc w-100" :class="{'mb-1': node && date}" @click="updateDeliveryDate" :disabled="(!node || !date) || disableSaveButton">{{ buttonLabel }} <i class="fa" :class="buttonIcon"></i></button>
                <small class="rc" v-show="node && date" v-on:click="deleteDeliveryDate">Disable product for this date</small>
            </div>
        </div>
    </div>
</template>

<script>
    import Info from './../components/info';

    export default {
        props: ['producer', 'product', 'node', 'date', 'lang'],
        components: {
            Info,
        },
        data: function() {
            return {
                selectedVariant: null,
                disableSaveButton: true,
                info: {},
                error: false,
                saved: false,
                saving: false,
            }
        },
        beforeMount () {
            this.infoSort();

            if (this.product.product_variants_relationship.length > 0) {
                this.selectedVariant = this.product.product_variants_relationship[0];
            }
        },
        updated() {
            if (this.selectedVariant) {
                this.selectedVariant = this.product.product_variants_relationship.find(variant => {
                    return variant.id === this.selectedVariant.id;
                });
            }
        },
        watch: {
            disableSaveButton() {
                this.saved = false;
            }
        },
        computed: {
            active() {
                if (this.product.hasOwnProperty('delivery_links_relationship')) {
                    return this.product.delivery_links_relationship.length > 0;
                } else {
                    return true;
                }
            },
            buttonLabel() {
                if (this.saved) {
                    return 'Saved';
                } else if (this.saving) {
                    return 'Saving...';
                } else if (this.error) {
                    return 'Could not save';
                } else {
                    return 'Save changes';
                }
            },
            buttonIcon() {
                if (this.saved) {
                    return 'fa-check';
                } else if (this.saving) {
                    return 'fa-spinner fa-spin';
                } else if (this.error) {
                    return 'fa-exclamation-circle ';
                } else {
                    return '';
                }
            },
            quantity: {
                set(value) {
                    if (this.selectedVariant) {
                        this.selectedVariant.delivery_links_relationship[0].quantity = value;
                    } else {
                        this.product.delivery_links_relationship[0].quantity = value;
                    }
                    this.disableSaveButton = false;
                },
                get() {
                    let fallback = this.selectedVariant ? this.selectedVariant.quantity : this.product.stock_quantity;
                    return this.hasDeliveryLink() ? this.getDeliveryLink().quantity : fallback;
                }
            },
            price: {
                set(value) {
                    if (this.selectedVariant) {
                        this.selectedVariant.delivery_links_relationship[0].price = value;
                    } else {
                        this.product.delivery_links_relationship[0].price = value;
                    }
                    this.disableSaveButton = false;
                },
                get() {
                    let fallback = this.selectedVariant ? this.selectedVariant.price : this.product.price;
                    return this.hasDeliveryLink() ? this.getDeliveryLink().price : fallback;
                }
            },
            deadline: {
                set(value) {
                    if (this.selectedVariant) {
                        this.selectedVariant.delivery_links_relationship[0].deadline = value;
                    } else {
                        this.product.delivery_links_relationship[0].deadline = value;
                    }
                    this.disableSaveButton = false;
                },
                get() {
                    return this.hasDeliveryLink() ? this.getDeliveryLink().deadline : this.product.deadline;
                }
            },
            image() {
                if (this.product.image_relationship && this.product.image_relationship.length > 0) {
                    return this.product.image_relationship[0].urls.small;
                }
            },
        },
        methods: {
            updateDeliveryDate() {
                this.saved = false;
                this.saving = true;

                if (this.selectedVariant) {
                    axios.post(`/${this.lang}/api/account/producers/${this.producer.id}/products/${this.product.id}/deliveries/${this.node.id}/${this.date}/update`, {
                        product_variant_id: this.selectedVariant.id,
                        quantity: this.quantity,
                        price: this.price,
                        deadline: this.deadline,
                    })
                    .then((response) => {
                        this.disableSaveButton = true;
                        this.saved = true;
                        this.saving = false;
                        this.error = false;
                        $(document).trigger('system-message', { type: 'success', body: 'Saved' });
                    }).catch((error) => {
                        this.saved = false;
                        this.saving = false;
                        this.error = this.formatError(error.response.data);
                        $(document).trigger('system-message', { type: 'error', body: this.error });
                    });
                } else {
                    axios.post(`/${this.lang}/api/account/producers/${this.producer.id}/products/${this.product.id}/deliveries/${this.node.id}/${this.date}/update`, {
                        quantity: this.quantity,
                        price: this.price,
                        deadline: this.deadline,
                    })
                    .then((response) => {
                        this.disableSaveButton = true;
                        this.saved = true;
                        this.saving = false;
                        this.error = false;
                        $(document).trigger('system-message', { type: 'success', body: 'Saved' });
                    }).catch((error) => {
                        this.saved = false;
                        this.saving = false;
                        this.error = this.formatError(error.response.data);
                        $(document).trigger('system-message', { type: 'error', body: this.error });
                    });
                }
            },

            formatError(errorObject) {
                let formattedError = [];

                for (var field in errorObject) {
                    if (errorObject.hasOwnProperty(field)) {
                        formattedError.push(errorObject[field]);
                    }
                }

                return formattedError.join(' ');
            },

            addDeliveryDate() {
                axios.post(`/${this.lang}/api/account/producers/${this.producer.id}/products/${this.product.id}/deliveries/${this.node.id}/${this.date}/add`)
                .then((response) => {
                    this.$emit('changed');
                }).catch((error) => {
                    console.error(error);
                });
            },

            deleteDeliveryDate() {
                axios.delete(`/${this.lang}/api/account/producers/${this.producer.id}/products/${this.product.id}/deliveries/${this.node.id}/${this.date}/delete`)
                .then((response) => {
                    this.$emit('changed');
                }).catch((error) => {
                    console.error(errors);
                });
            },

            setVariant(event) {
                this.selectedVariant = this.product.product_variants_relationship.find(variant => {
                    return variant.id == event.target.value;
                });
            },

            hasDeliveryLink() {
                if (this.selectedVariant) {
                    return this.selectedVariant.hasOwnProperty('delivery_links_relationship') && this.selectedVariant.delivery_links_relationship.length > 0;
                } else {
                    return this.product.hasOwnProperty('delivery_links_relationship') && this.product.delivery_links_relationship.length > 0;
                }
            },

            getDeliveryLink() {
                if (this.hasDeliveryLink()) {
                    return this.selectedVariant ? this.selectedVariant.delivery_links_relationship[0] : this.product.delivery_links_relationship[0];
                }
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
