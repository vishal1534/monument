<template>
    <div>
        <Content></Content>

        <PDF :title="'printBrickForm'">

            <div slot="header"></div>

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
    components:{
        PDF,
        Content
    },
    beforeCreate(){
        if(!this.$store.getters.isPermitted({resource:'Orders',action:'read'}))
            this.$router.push( '/access-denied');
    },
    metaInfo() {
        return {
            title: 'Brick Form'
        }
    },
}
</script>

<style scoped>
</style>
