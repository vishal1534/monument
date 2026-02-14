<template>
    <div>
        <div class="align-self-center pdf-title ml-2">
            <img src="/images/invoice_image.png" class="w-100">
            <h5 class="text-right">816-833-5111</h5>
        </div>

        <div class="ml-5">
            <h3 class="font-italic pdf-title-invoice">{{title}}</h3>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Invoice-header-PDF",
        props:{
            title: String,
        }
    }
</script>

<style scoped>

</style>
