<template>
    <div>
        <div class="white-box">
            <h5 class="rc mb-4">Stock</h5>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td class="font-weight-bold w-50">Stock</td>
                        <td>
                            <input class="d-block mx-auto" type="checkbox" v-model="stock.has_stock">
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold w-50">Quantity</td>
                        <td>
                            <input type="number" class="form-control form-control-sm w-50" v-model="stock.stock_quantity" :disabled="!stock.has_stock">
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold w-50">Recurring</td>
                        <td>
                            <input class="d-block mx-auto" type="checkbox" v-model="recurring" :disabled="!stock.has_stock">
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold w-50">CSA</td>
                        <td>
                            <input class="d-block mx-auto" type="checkbox" v-model="stock.csa" :disabled="!stock.has_stock || !stock.recurring">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="white-box">
            <h5 class="rc mb-4">Variants</h5>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td class="font-weight-bold w-50">Use variants</td>
                        <td>
                            <input class="d-block mx-auto" type="checkbox" v-model="variants.use_variants">
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold w-50">Shared variant stock</td>
                        <td>
                            <input class="d-block mx-auto" type="checkbox" :disabled="!stock.has_stock" v-model="variants.shared_variant_quantity">
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold w-50">Content specified in</td>
                        <td>
                            <select class="form-control form-control-sm w-50" :disabled="Object.keys(this.units).length === 1" v-model="variants.package_unit">
                                <option v-for="unit in units" :key="unit">{{ unit }}</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div id="new-variants-container" v-if="variants.use_variants">
                <table class="form-table table table-hover">
                    <thead border="0">
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col" class="w-35">Name</th>
                            <th scope="col">Main</th>
                            <th scope="col">{{ packageUnit }} per package</th>
                            <th scope="col" v-if="product.has_stock">Stock <span v-if="variants.shared_variant_quantity">(calculated)</span></th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Empty row -->
                        <tr v-if="variants.variants.length == 0 && variants.newVariants.length == 0">
                            <td colspan="6">No variants</td>
                        </tr>

                        <!-- Added variants -->
                        <tr v-for="(variant, index) in variants.variants" :key="'existing-' + index">
                            <td class="position-relative">
                                <img src="https://local-food-nodes.s3.eu-central-1.amazonaws.com/201810161102_img_4010_jpeg_small.jpeg" class="rounded-circle form-table-image">
                            </td>
                            <td class="position-relative">
                                <input type="text" class="form-control form-control-sm w-100" placeholder="Variant name" :class="{'red-b': hasError(variant.id, 'name')}" v-model="variants.variants[index]['name']">
                            </td>
                            <td class="position-relative">
                                <input type="radio" :value="variant.id" v-model="variants.main_variant">
                            </td>
                            <td class="position-relative">
                                <input type="number" min="0" step="1" class="form-control form-control-sm" :class="{'red-b': hasError(variant.id, 'package_amount')}" v-model="variants.variants[index]['package_amount']">
                            </td>
                            <td class="position-relative" v-if="stock.has_stock">
                                <input type="number" min="0" step="1" class="form-control form-control-sm" :class="{'red-b': hasError(variant.id, 'quantity')}" v-model="variants.variants[index]['quantity']" :disabled="variants.shared_variant_quantity || (variant.main_variant && stock.has_stock)">
                            </td>
                            <td class="position-relative">
                                <input type="number" min="0" step="1" class="form-control form-control-sm" :class="{'red-b': hasError(variant.id, 'price')}" v-model="variants.variants[index]['price']" :disabled="variant.id === variants.main_variant">
                            </td>
                            <td><span v-on:click="deleteVariant(variant)">Remove</span></td>
                        </tr>

                        <!-- New variants -->
                        <tr v-for="(variant, index) in variants.newVariants" :key="variant.id">
                            <td class="position-relative">
                                <img src="https://local-food-nodes.s3.eu-central-1.amazonaws.com/201810161102_img_4010_jpeg_small.jpeg" class="rounded-circle form-table-image">
                            </td>
                            <td class="position-relative">
                                <input type="text" class="form-control form-control-sm w-100" placeholder="New variant name" :class="{'red-b': hasError(variant.id, 'name')}" v-model="variants.newVariants[index]['name']">
                            </td>
                            <td class="position-relative text-center">
                                <input type="radio" :value="variant.id" v-model="variants.main_variant" disabled>
                            </td>
                            <td class="position-relative">
                                <input type="number" min="0" step="1" class="form-control form-control-sm" :class="{'red-b': hasError(variant.id, 'package_amount')}" v-model="variants.newVariants[index]['package_amount']">
                            </td>
                            <td class="position-relative" v-if="stock.has_stock">
                                <input type="number" min="0" step="1" class="form-control form-control-sm" :class="{'red-b': hasError(variant.id, 'quantity') && !variants.shared_variant_quantity}" v-model="variants.newVariants[index]['quantity']" :disabled="variants.shared_variant_quantity || (variant.main_variant && stock.has_stock)">
                            </td>
                            <td class="position-relative">
                                <input type="number" min="0" step="1" class="form-control form-control-sm" :class="{'red-b': hasError(variant.id, 'price')}" v-model="variants.newVariants[index]['price']" :disabled="variant.id === variants.main_variant">
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <div class="btn btn-secondary" v-on:click="addNewVariantRow"><i class="fa fa-plus"></i> Add variant</div>
            </div>
        </div>
        <div class="row">
            <button class="btn btn-secondary mt-5 ml-auto" v-on:click="save">Save</button>
        </div>
    </div>
</template>

<script>
    // TODO: OM MAN AKTIVERAR STOCK SÅ SKA DET ÄNDRA VILKA FÄLT SOM SYNS DIREKT
    export default {
        props: ['lang', 'producerId', 'productId'],
        data: function() {
            return {
                product: null,
                stock: {
                    has_stock: false,
                    stock_quantity: null,
                    recurring: false,
                    csa: false,
                },
                units: [],
                variants: {
                    errors: [],
                    main_variant: null,
                    shared_variant_quantity: false,
                    use_variants: false,
                    package_unit: null,
                    variants: [],
                    newVariants: [],
                },
            }
        },
        mounted() {
            this.getData();
        },
        computed: {
            recurring: {
                get() {
                    return this.stock.recurring || (this.stock.recurring && this.stock.csa);
                },
                set(value) {
                    this.stock.recurring = value;
                }
            },
            packageUnit() {
                if (this.variants.package_unit) {
                    return this.variants.package_unit.charAt(0).toUpperCase() + this.variants.package_unit.slice(1);
                } else {
                    return 'Amount';
                }
            }
        },
        methods: {
            /**
             *
             */
            getData() {
                axios.all([
                    axios.get('/' + this.lang + '/api/account/producers/' + this.producerId + '/products/' + this.productId),
                    axios.get('/' + this.lang + '/api/account/producers/' + this.producerId + '/products/' + this.productId + '/variants'),
                    axios.get('/' + this.lang + '/api/account/producers/' + this.producerId + '/products/' + this.productId + '/stock'),
                ])
                .then(axios.spread((product, variants, stock) => {
                    this.product = product.data;
                    this.variants = variants.data;
                    this.stock = stock.data;
                }))
                .then(() => {
                    return axios.get('/' + this.lang + '/api/package-units', {
                        params: {
                            product_price_unit: this.product.price_unit,
                        }
                    });
                })
                .then(packageUnits => {
                    this.units = packageUnits.data;

                    if (Object.keys(this.units).length === 1) {
                        this.variants.package_unit = this.units[this.product.price_unit];
                    }
                })
                .catch(error => {
                    console.error(error);
                });
            },

            /**
             *
             */
            save() {
                this.loading = true;

                axios.post('/' + this.lang + '/api/account/producers/' + this.producerId + '/products/' + this.productId + '/stock', {
                    stock: this.stock
                })
                .then(() => {
                    return axios.post('/' + this.lang + '/api/account/producers/' + this.producerId + '/products/' + this.productId + '/variants', {
                        variants: this.variants,
                    })
                })
                .then(variants => {
                    this.loading = false;
                    $(document).trigger('system-message', { type: 'success', body: 'Saved' });
                    this.getData();
                })
                .catch(error => {
                    console.error(error.response.data);
                    this.variants.errors = error.response.data.errors;
                    this.variants.newVariants = error.response.data.newVariants;
                    this.variants.variants = error.response.data.variants;

                    this.loading = false;
                    $(document).trigger('system-message', { type: 'error', body: this.formatError(error.response.data.errors) });
                });
            },

            /**
             *
             */
            formatError(errorObject) {
                let formattedError = [];

                for (var variantId in errorObject) {
                    if (errorObject.hasOwnProperty(variantId)) {
                        for (var field in errorObject[variantId]) {
                            if (errorObject[variantId].hasOwnProperty(field)) {
                                formattedError.push(errorObject[variantId][field]);
                            }
                        }
                    }
                }

                return formattedError.join(' ');
            },

            /**
             *
             */
            addNewVariantRow() {
                axios.get('/' + this.lang + '/api/account/producers/' + this.producerId + '/products/' + this.productId + '/variant', {
                    params: {
                        next_index: this.variants.newVariants.length
                    }
                })
                .then(response => {
                    this.variants.newVariants.push(response.data);

                    // Set main
                    if (this.variants.variants.length == 0 && this.variants.newVariants.length == 1) {
                        this.variants.main_variant = this.variants.newVariants[0].id;
                    }
                })
                .catch(error => {
                    console.error(error.response.data);
                });
            },

            /**
             *
             */
            deleteVariant(variant) {
                axios.delete('/' + this.lang + '/api/account/producers/' + this.producerId + '/products/' + this.productId + '/variants/' + variant.id)
                .then(variants => {
                    this.variants.variants = variants.data;
                })
                .catch(error => {
                    console.error(error.response.data);
                });
            },

            /**
             *
             */
            hasError(variantId, field) {
                if (this.variants.errors && this.variants.errors[variantId] && this.variants.errors[variantId][field]) {
                    return true;
                }

                return false;
            }
        },
    }
</script>
