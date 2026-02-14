<template>
    <div>

        <div class="form-content">
            <label class="d-flex justify-content-end font-weight-bold">Pg. {{component}} of 3</label>
            <component :is="'form-'+component"></component>

            <div class="buttons-row">
                <button type="button" class="btn btn-sm btn-info custom-infobtn-text custom-infobtn-toolbar mx-1" @click="printPDF">Print Form</button>
                <router-link class="btn btn-sm btn-warning custom-dangerbtn-text custom-dangerbtn-toolbar  mx-1 px-4" to="/order-list">Cancel</router-link>
                <button v-if="component > 1" type="button" class="btn btn-sm btn-info custom-infobtn-text custom-infobtn-toolbar ml-auto  mx-1 " style="width:100px !important;" @click="component--">Previous Page</button>
                <button v-if="component < 3" type="button" :class="['btn btn-sm btn-info custom-infobtn-text custom-infobtn-toolbar mx-1 ', {'ml-auto': component == 1}]" @click="component++">Next Page</button>
            </div>

        </div>


        <PDF :title="'printInstallationForm'">

            <div slot="header"></div>

            <div slot="body">
<!--                <component :is="'form-'+component"></component>-->
                <form-1></form-1>
                <form-2></form-2>
                <form-3></form-3>
            </div>

            <div slot="footer"></div>
        </PDF>

    </div>

</template>

<script>

import PDF from "../../../../Modules/PDF-Modal";
import StepOne from "./Step-1";
import StepTwo from "./Step-2";
import StepThree from "./Step-3";
import {event, eventBus} from "../../../../event-bus/event-bus";
export default {
    name: "Add",
    components:{
        PDF,
        'form-1':StepOne,
        'form-2':StepTwo,
        'form-3':StepThree,
    },
    data() {
        return{
            component: 1,
        }
    },
    beforeCreate(){
        if(!this.$store.getters.isPermitted({resource:'Orders',action:'read'}) && !this.$store.getters.isPermitted({resource:'Production',action:'read'}))
            this.$router.push( '/access-denied');
    },
    metaInfo() {
        return {
            title: 'Printable OrderInstallation Form'
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
    width: 57.5rem;
}
.buttons-row{
    display: flex;
    margin: 0.5rem auto;
}

</style>
