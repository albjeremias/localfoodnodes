<template>
    <i
        class="ml-2 fa fa-info-circle"
       :class="infoClass"
       data-toggle="tooltip"
       :data-placement="infoPlacement"
       :title="infoText">
    </i>
</template>

<style scoped>
</style>

<script>
    export default {
        props: ['text', 'placement', 'iconClass'],

        data: function() {
            return {
                infoText: this.text,
                infoPlacement: this.placement,
                infoClass: this.iconClass
            }
        },
    }
</script>
