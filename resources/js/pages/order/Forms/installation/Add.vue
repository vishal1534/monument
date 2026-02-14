<template>
    <div>
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> Installation Form - {{ component }} of 3 </h5>
            <div class="bg-toolbar my-2 p-1">
                <Toolbar :id="formFields.id" :installation_id="formFields.order_installation.id" :production_id="production_id" :saveDisabled="saveDisabled" :component="component"></Toolbar>
            </div>
        </div>

        <div>

            <div class="row m-0">

                <div class="col-md-12">

                    <div v-bind:class="[alertClasses, 'd-flex justify-content-center m-auto p-1 w-50']">{{alertMessage}}</div>

                    <form class="shadow-lg bg-white py-1">

                        <div class="form-content">
                            <component :formFields="formFieldsData" :is="'form-'+component"></component>

                            <!--<div class="buttons-row">
                                <button type="button" class="btn btn-sm btn-info mx-1 px-4" @click="printPDF">Print Preview</button>
                                <button v-if="component > 1" type="button" class="btn btn-sm btn-info mx-1 ml-auto px-4" @click="component&#45;&#45;">Previous Page</button>
                                <button v-if="component < 3" type="button" :class="['btn btn-sm btn-info mx-1 px-4', {'ml-auto': component == 1}]" @click="component++">Next Page</button>
                            </div>-->

                            <div class="buttons-row">
                                <button type="button" class="btn btn-sm btn-info custom-infobtn-text custom-infobtn-toolbar mx-1" @click="printPDF">Print Form</button>
                                <button v-if="component > 1" type="button" class="btn btn-sm btn-info custom-infobtn-text custom-infobtn-toolbar ml-auto  mx-1 " style="width:100px !important;" @click="component--">Previous Page</button>
                                <button v-if="component < 3" type="button" :class="['btn btn-sm btn-info custom-infobtn-text custom-infobtn-toolbar mx-1 ', {'ml-auto': component == 1}]" @click="component++">Next Page</button>
                            </div>
                        </div>


                    </form>

                </div>

            </div>

        </div>

        <PDF :title="'printInstallationForm'">

            <div slot="header" class="">
                <div class="d-flex justify-content-end">
<!--                    <label class="font-weight-bold">Pg. {{component}} of 3</label>-->
                </div>
                <div class="d-flex justify-content-center">
                    <h3>INSTALLATION FORM</h3>
                </div>
            </div>

            <div slot="body">
<!--                <component :formFields="formFieldsData" :is="'form-'+component" :inPDF="true"></component>-->
                <InstallPDF :formFields="formFieldsData" :inPDF="true"></InstallPDF>
            </div>

            <div slot="footer" ></div>
        </PDF>

    </div>
</template>

<script>
    import Toolbar from "./Toolbar";
    import StepOne from "./Step-1";
    import StepTwo from "./Step-2";
    import StepThree from "./Step-3";
    import InstallPDF from './Installation-PDF';
    import PDF from "../../../../Modules/PDF-Modal";
    import {event, eventBus} from '../../../../event-bus/event-bus';
    import {saveRecord, fetchRecord} from "../../../../helpers/axios";
    export default {
        name: "Add",
        props: {
            id: {
                type: Number
            },
            production_id: {
                type: Number
            },
            hideInModal: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return  {
                formFields:{
                    id:0,
                    order_installation:{
                        id:0
                    }
                },
                component: 1,
                axiosParams: {module: 'orderInstallation'},
                axiosParamsOrder: {module: 'order'},
                alertMessage:'',
                hideAlert:true,
                successResponse: false,
                errorResponse: false,
                saveDisabled:false,
            }
        },
        created() {
            eventBus.$on(event.SAVE_ORDER_INSTALLATION, this.storeInstallation);
            eventBus.$on(event.GET_ORDER_INSTALLATION, this.getInstallation);
        },
        beforeDestroy() {
            eventBus.$off(event.SAVE_ORDER_INSTALLATION);
            eventBus.$off(event.GET_ORDER_INSTALLATION);
        },
        metaInfo() {
            return {
                title: 'OrderInstallation Form'
            }
        },
        components:{
            Toolbar,
            InstallPDF,
            'form-1':StepOne,
            'form-2':StepTwo,
            'form-3':StepThree,
            PDF,
        },
        computed:{
            alertClasses: function () {
                return {
                    alert: true,
                    'alert-success': this.successResponse,
                    'alert-danger': this.errorResponse,
                    'd-none': this.hideAlert
                }
            },
            formFieldsData(){
                if (this.formFields.cemetery == null){
                  this.formFields.cemetery = {gps:'', street:'',city:{}, county:{}, state:{}};
                }
                if (this.formFields.cemetery.city == null){
                    this.formFields.cemetery.city = {};
                }
                if (this.formFields.cemetery.county == null){
                    this.formFields.cemetery.county = {};
                }
                if (this.formFields.cemetery.state == null){
                    this.formFields.cemetery.state = {};
                }
                if (this.formFields.family == null){
                  this.formFields.family = {};
                }
                if (this.formFields.company == null){
                  this.formFields.company = {};
                }
                if (this.formFields.products == null){
                  this.formFields.products = [];
                }
                if (this.formFields.invoice == null){
                  this.formFields.invoice = {payments:[]};
                }
                if (this.formFields.order_installation == null || this.formFields.order_installation.id == 0){
                  this.formFields.order_installation = {id:0, flagging:{id:0}, monument:{id:0}, payment:{id:0}, placement:{id:0}, cemetery_confirmation:{id:0}};
                }

                return this.formFields;
            },
        },
        beforeCreate(){
            if((!this.$store.getters.isPermitted({resource:'Orders',action:'read'})) && (!this.$store.getters.isPermitted({resource:'Production',action:'read'})))
                this.$router.push( '/access-denied');
        },
        mounted() {
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            this.getInstallation();
            this.$store.getters.detectFormChanges();
        },
        methods:{
            /** CRUD */
            getInstallation(){
                let id = this.formFields.id;
                if (id){
                    // Get data from store if exists
                    let record = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == id);
                    if (record != undefined){
                        this.formFields = record;
                    }
                    else{
                        this.axiosParams.id = id;
                        fetchRecord(this.axiosParams, (response) => {
                          this.formFields = response.data;
                          // this.order = response.data;
                            // if(!this.formFields.id)
                            //     this.formFields.id = 0;
                            //
                            // this.order = response.data.order;
                        })
                    }
                }

            },
            storeInstallation: function(data){
                console.log('add');
                this.saveDisabled = true; //Disabling save button
                let formData = new FormData();
                formData.append('data',JSON.stringify({...data}));
                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo){
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        /*this.errorResponse = true;
                        this.handleAlert();*/
                        this.makeToast({title: "Error", message:this.alertMessage, variant:"danger", duration: 5000});
                        this.alertMessage = '';
                    }
                    else{
                        let status = this.formFields.id ? 'Updated': 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                        /*this.successResponse = true;
                        this.handleAlert();*/
                        this.makeToast({title:'Success', message:this.alertMessage, variant:'success'});
                        this.alertMessage = '';

                        this.formFields = response.data;
                        let record = Object.values(this.$store.state[this.axiosParamsOrder.module].recordList).find(obj => obj.id == this.id);
                        if (record != undefined) {
                            record.order_installation.id = this.formFields.id
                        }
                        let data = {module:'installation', data: response.data};
                        this.$store.commit('appendOrUpdateInRecordList', data);
                    }
                },(error) => {
                    if (error.response.status == 403){
                        this.makeToast({title: 'Error', message: error.response.data.message , variant: 'danger', duration: 3000});
                    }
                })
            },


            /** Generic*/
            handleAlert: function(){
                this.saveDisabled = false;//enabling save button
                this.hideAlert = false;
                setTimeout(() => {
                    this.alertMessage = "";
                    this.successResponse = false;
                    this.errorResponse = false;
                    this.hideAlert = true;
                }, 3000)
            },
            customizeLabel: function (str) {
                // Remove underscore and capitalize first letter of each word
                let i, labels = str.split('_');
                for (i=0; i < labels.length; i++) {
                    labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
                }
                return labels.join(' ');
            },
            printPDF(){
                eventBus.$emit(event.PRINT_PDF)
            },
            makeToast(params) {
                this.$bvToast.toast(params.message, {
                    title: params.title,
                    variant: params.variant,
                    toaster: 'b-toaster-top-center',
                    autoHideDelay: 3000,
                    noCloseButton: true,
                })
                this.saveDisabled = false;//enabling save button
            },
        },
    }
</script>

<style scoped>

    .buttons-row{
        display: flex;
        margin: 0.5rem auto;

    }
    .form-content{
        width: 45rem;
        margin: 0 auto;
    }
</style>
