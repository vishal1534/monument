<template>
    <div>
        <Content></Content>

        <PDF :title="'printableSandblastingProduction'">

            <div slot="header" class="moz-title">
                <div class="d-flex justify-content-center">
                    <h3 class="header-label">SandBlasting</h3>
                </div>
            </div>

            <div slot="body" class="moz-table">
                <Content></Content>
            </div>

            <div slot="footer"></div>
        </PDF>

    </div>

</template>

<script>

    import PDF from "../../../../Modules/PDF-Modal";
    import Content from "./Content";
    import {fetchRecord} from "../../../../helpers/axios";

    export default {
        name: "Add",
        components: {
            PDF,
            Content
        },
        beforeCreate(){
            if(!this.$store.getters.isPermitted({resource:'Production',action:'read'}))
                this.$router.push( '/access-denied');
        },
        metaInfo() {
            return {
                title: 'Printable Sandblasting Production Form'
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
        text-decoration: underline;
    }
    @-moz-document url-prefix() {
        .moz-title {
            margin-top: -1.5rem !important;
            margin-bottom: 0.35rem !important;
        }
        .moz-table {
            margin-top: -0.25rem !important;
            margin-left: -0.75rem !important;
        }
    }
</style>
