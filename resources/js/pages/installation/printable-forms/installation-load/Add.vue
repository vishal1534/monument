<template>
    <div>
        <Content></Content>

        <PDF :title="'printablnstallationLoad'">

            <div slot="header" class="">
                <div class="d-flex justify-content-center">
                    <h3 class="header-label mb-3">Frisbie Monument's
                        <br>Daily Installation Load
                        <br>Check List</h3>
                </div>
            </div>

            <div slot="body">
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
                title: 'Printable Installation Load'
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
        font-size: 50px;
        line-height: 50px;
        text-align: center;
        letter-spacing: 0.02em;
        color:#000;
    }
</style>
