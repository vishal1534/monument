<template>
    <div>

        <div class="form-content">
             <Content></Content>

            <div class="buttons-row">
<!--                btn btn-sm btn-info mx-1 px-4-->
                <button type="button" class="btn-info mx-1 px-2 w-auto custom-infobtn-toolbar custom-infobtn-text" @click="printPDF">Print Preview</button>
<!--                btn btn-sm btn-warning mx-1 px-4-->
                <router-link class="btn btn-sm btn-warning mx-1 px-4 custom-dangerbtn-toolbar custom-dangerbtn-text" to="/order-list">Cancel</router-link>
            </div>
        </div>


        <PDF :title="'printMaintenanceWorkOrderForm'">

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
import {event, eventBus} from "../../../../event-bus/event-bus";
export default {
    name: "Add",
    components:{
        Content,
        PDF
    },
    data() {
        return{
        }
    },
    beforeCreate(){
        if(!this.$store.getters.isPermitted({resource:'Maintenance',action:'read'}))
            this.$router.push( '/access-denied');
    },
    metaInfo() {
        return {
            title: 'Printable Maintenance Work Order'
        }
    },
    methods:{
        printPDF(){
            eventBus.$emit(event.PRINT_PDF)
        },
    }
}
</script>

<style scoped>

.form-content{
    margin: 0 auto;
    width: 45rem;
}
.buttons-row{
    display: flex;
    margin: 0.5rem auto;
}

</style>
