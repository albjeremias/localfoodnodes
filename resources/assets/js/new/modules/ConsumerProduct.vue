<template>
    <div class="row">
        <div class="col-md-10">
            <div class="col-md-16">
                <div class="white-box">
                    <p>{{ product.description}}</p>
                </div>
            </div>
            <div class="col-md-16">
                <div class="white-box">
                    bokning
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="white-box">
                alla produkter
            </div>

            <div class="white-box">
                product info
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['product'],
        data: function() {
            return {
            }
        },
        beforeMount () {
        },
        mounted() {
        },
        watch: {
        },
        methods: {
        },
        components: {
            ProductEdit, Info
        }
    }
</script>
