<template>
    <div>
        <Content></Content>

        <PDF :title="'printableWeeklyProduction'" class="page">

            <div slot="header" >
                <div class="d-flex justify-content-center mt-n4">
                    <h3 class="header-label">WEEKLY SCHEDULE</h3>
                </div>
            </div>

            <div slot="body" style="margin-left: -2.15rem!important;">
                <Content></Content>
            </div>

            <div slot="footer"></div>
        </PDF>

    </div>

</template>

<script>

    import PDF from "../../../../Modules/PDF-Modal";
    import Content from "./Content";

    export default {
        name: "Add",
        components: {
            PDF,
            Content
        },
        beforeCreate(){
            if(!this.$store.getters.isPermitted({resource:'Installation',action:'read'}))
                this.$router.push( '/access-denied');
        },
        metaInfo() {
            return {
                title: 'Printable Weekly Schedule'
            }
        },
    }
</script>

<style scoped>

    .buttons-row {
        display: flex;
        margin: 0.5rem auto;
        width: 40rem;
    }
    .header-label{
        font-family: Roboto;
        font-style: normal;
        font-weight: 600;
        font-size: 30px;
        line-height: 14px;
        text-align: center;
        letter-spacing: 0.02em;
        color:#000;
    }
    @page weekly-print {
        size: landscape;
    }
    .page{
        page: weekly-print;
    }
</style>

