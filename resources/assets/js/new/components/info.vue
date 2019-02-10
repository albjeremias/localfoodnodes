<template>
    <i
        class="ml-2 fa fa-info-circle"
       :class="classes"
       data-toggle="tooltip"
       :data-placement="placement"
       :title="text">
    </i>
</template>

<style scoped>
</style>

<script>
    export default {
        props: ['text', 'placement', 'class'],

        data: function() {
            return {
                text: this.text,
                placement: this.placement,
                classes: this.class
            }
        },
    }
</script>
