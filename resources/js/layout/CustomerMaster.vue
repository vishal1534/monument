<template>
    <div class="page-container container-fluid p-0 overflow-hidden">
        <div class="content-wrap">
            <CustomerNavBar/>
            <slot/>
        </div>
    </div>
</template>

<script>
    import CustomerNavBar from "./components/CustomerNavBar";
    export default {
        name: "CustomerMaster",
        metaInfo() {
            return {
                title: "Dashboard",
                titleTemplate: '%s - MPS',
                meta: [
                    { name: 'description', content:  'Monument'},
                    { property: 'og:title', content: "Monument"},
                    { property: 'og:site_name', content: 'Monument'},
                    {property: 'og:type', content: 'website'},
                    {name: 'robots', content: 'index,follow'}
                ]
            }
        },
        components:{
            CustomerNavBar,
        },
    }
</script>

<style scoped>

    .page-container{
        position: relative;
        min-height: 100vh;
    }
    .content-wrap{
        padding-bottom: 2.5rem;
    }

</style>
