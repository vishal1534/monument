<template>
    <div>

        <div class="form-content">
            <label class="d-flex justify-content-end font-weight-bold">Pg. {{component}} of 5</label>
            <component :is="'form-'+component"></component>

            <div class="buttons-row">
                <button type="button" class="btn btn-sm btn-info custom-infobtn-text custom-infobtn-toolbar mx-1" @click="printPDF">Print Form</button>
                <router-link class="btn btn-sm btn-warning custom-dangerbtn-text custom-dangerbtn-toolbar  mx-1 px-4" to="/order-list">Cancel</router-link>
                <button v-if="component > 1" type="button" class="btn btn-sm btn-info custom-infobtn-text custom-infobtn-toolbar ml-auto  mx-1 " style="width:100px !important;" @click="component--">Previous Page</button>
                <button v-if="component < 5" type="button" :class="['btn btn-sm btn-info custom-infobtn-text custom-infobtn-toolbar mx-1 ', {'ml-auto': component == 1}]" @click="component++">Next Page</button>
            </div>
        </div>


        <PDF :title="'printTruckLoad'">

            <div slot="header"></div>

            <div slot="body">
<!--                <component :is="'form-'+component"></component>-->
                <!--<component :is="'form-2'"></component>
                <component :is="'form-3'"></component>
                <component :is="'form-4'"></component>
                <component :is="'form-5'"></component>-->
                <form-1></form-1>
                <form-2></form-2>
                <form-3></form-3>
                <form-4></form-4>
                <form-5></form-5>
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
import StepFour from "./Step-4";
import StepFive from "./Step-5";
import {event, eventBus} from "../../../../event-bus/event-bus";
export default {
    name: "Add",
    components:{
        PDF,
        'form-1':StepOne,
        'form-2':StepTwo,
        'form-3':StepThree,
        'form-4':StepFour,
        'form-5':StepFive,
    },
    data() {
        return{
            component: 1,
        }
    },
    beforeCreate(){
        if(!this.$store.getters.isPermitted({resource:'Installation',action:'read'}))
            this.$router.push( '/access-denied');
    },
    metaInfo() {
        return {
            title: 'Printable Truck Load'
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
