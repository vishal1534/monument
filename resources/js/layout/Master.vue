<template>
    <div class="page-container container-fluid p-0 overflow-hidden">
        <div class="content-wrap">
            <NavBar/>
            <slot/>
        </div>
        <Footer/>
    </div>
</template>

<script>


    import NavBar from './components/NavBar';
    import Footer from './components/Footer';
    export default {
        name: "Master",
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
            NavBar,
            Footer
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
