<template>
    <div class="bg-white mt-n1 pt-1">
        <div>
            <h3 class="mx-2 my-1 custom-form-heading"> Delivery-Work Order Form</h3>
            <div class="d-flex non-print-elm justify-content-center bg-toolbar my-2 p-1">
                <button type="button" v-if="formFields.id > 0 ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                    {{ formFields.id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                </button>
                <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/orders/' +id">Cancel</router-link>

            </div>
        </div>

        <PDF :title="'printWorkOrder'">

            <div slot="header" class="pdf-custom-margin-form">
              <h2 class="pdf-title col-md-12">DELIVERY WORK ORDER FORM</h2>
                <div>
                    <div class=" work-order-row border rounded">
                        <div class="d-block border-right px-1 pt-1 my-0">
                            <label class="font-weight-bold">Date:</label><br>
                            <label>{{ changeDateFormat(order_date) }}</label>
                        </div>
                       <!-- <div class="d-block border-right px-1 pt-1 my-0">
                            <label class="font-weight-bold">Day:</label><br>
                            <label>{{getDayOfWeek(order_date)}}</label>
                        </div>-->
                        <div class="d-block border-right px-1 pt-1 my-0">
                            <label class="font-weight-bold">Name on Monument:</label>
                            <label class="d-block">{{name_on_stone ? name_on_stone.toUpperCase() : '' }}</label>
                        </div>
                        <div class="d-block px-1">
                            <label class="font-weight-bold">Invoice. No:</label>
                            <label class="d-block">{{invoice_no}}</label>
                        </div>
                    </div>
                    <div class="work-order-row">
                        <div class="">
                            <label class="font-weight-bold pdf-labels">Delivery To Store Location:</label>

                            <b-form-input
                                class=""
                                size="sm"
                                style="border:none !important;"
                                v-model="formFields.store_location"
                            ></b-form-input>
                           <!-- <b-form-select
                                    :options="storeLocations"
                                    v-model="formFields.delivery_store_location_id"
                                    class="custom-caret-agreement pdf-input-select pdf-fields"
                                    size="sm">
                                <template #first>
                                    <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                                </template>
                            </b-form-select>-->
                        </div>
                        <div class="">
                            <label class="font-weight-bold pdf-labels">Other Location:</label>

                            <b-form-input
                                    class="ml-2 input-xl pdf-fields"
                                    size="sm"
                                    v-model="formFields.other_location"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>
                    </div>
                    <div class="work-order-row my-2">
                        <div class="">
                            <label class="font-weight-bold pdf-input-label pdf-labels">Company:</label>

                            <b-form-input
                                    class="pdf-fields"
                                    size="sm"
                                    v-model="formFields.company"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="work-order-row my-2">
                        <div class="">
                            <label class="font-weight-bold pdf-input-label pdf-labels">Address:</label>

                            <b-form-input
                                    class="pdf-fields"
                                    size="sm"
                                    v-model="formFields.address"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="work-order-row pdf-custom-div-size1 my-2">
                        <div>
                            <label class="font-weight-bold pdf-label-city pdf-labels">City:</label>
                            <b-form-input type="text"  class="form-control form-control-sm pdf-input-city pdf-fields" style="border:none !important" size="sm" v-model="formFields.city"></b-form-input>
                        </div>
                        <div>
                            <label class="font-weight-bold pdf-labels">State:</label>
                            <b-form-input type="text"  class="form-control form-control-sm pdf-input-state pdf-fields" style="border:none !important" size="sm" v-model="formFields.state"></b-form-input>
                        </div>
                        <div>
                            <label class="font-weight-bold pdf-labels">Zip:</label>
                            <b-form-input type="text"  class="form-control form-control-sm pdf-input-zip pdf-fields" style="border:none !important" size="sm" v-model="formFields.zip"></b-form-input>
                        </div>

                    </div>
                    <div class="work-order-row my-2">
                        <div class="pdf-custom-div-size2">
                            <label class="font-weight-bold pdf-label-contact pdf-labels">Contact:</label>
                            <b-form-input type="text"  class="form-control form-control-sm pdf-fields" style="border:none !important" size="sm" v-model="formFields.contact"></b-form-input>
                        </div>
                        <div class="pdf-custom-div-size2">
                            <label class="font-weight-bold pdf-labels">Phone:</label>
                            <b-form-input type="text"  class="form-control form-control-sm pdf-fields" style="border:none !important" size="sm" v-model="formFields.phone"></b-form-input>
                        </div>

                    </div>
                    <div class="work-order-row my-2">
                        <div class="flex-grow-1">
                            <label class="font-weight-bold pdf-labels mt-1">Work to be done:</label>

                            <b-form-textarea
                                    class="ml-2 pdf-fields"
                                    rows="3"
                                    size="sm"
                                    v-model="formFields.work_to_be_done"
                                    no-resize
                            ></b-form-textarea>
                        </div>

                    </div>
                    <div class="work-order-row my-2">
                        <div class="flex-grow-1">
                            <label class="font-weight-bold pdf-labels mt-1">Stone Size Type & Color:</label>

                            <b-form-textarea
                                    class="ml-2 pdf-fields"
                                    rows="3"
                                    size="sm"
                                    v-model="formFields.stone_details"
                                    no-resize
                            ></b-form-textarea>
                        </div>

                    </div>
                    <div class="work-order-row my-2">
                        <div class="flex-grow-1">
                            <label class="font-weight-bold pdf-labels mt-1">Supplies Needed:</label>

                            <b-form-textarea
                                    class="ml-2 pdf-fields"
                                    rows="4"
                                    size="sm"
                                    v-model="formFields.supplies_needed"
                                    no-resize
                            ></b-form-textarea>
                        </div>

                    </div>
                    <div class="work-order-row my-2">
                        <div class="flex-grow-1">
                            <label class="font-weight-bold pdf-labels mt-1">Work Order Notes:</label>

                            <b-form-textarea
                                    class="ml-1 pdf-fields"
                                    rows="8"
                                    size="sm"
                                    v-model="formFields.work_order_notes"
                                    no-resize
                            ></b-form-textarea>
                        </div>

                    </div>
                    <div class="work-order-row my-2">
                        <div class="custom-div-size2">
                            <label class="font-weight-bold pdf-labels">Completed By:</label>

                            <b-form-input
                                    class="ml-2 pdf-fields"
                                    size="sm"
                                    v-model="formFields.completed_by"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="work-order-row my-2">
                        <div class="custom-div-size1">
                            <label class="font-weight-bold pdf-labels">Date:</label>
<!--                            v-model="formFields.date"-->
                            <b-form-input
                                    class="my-auto input-date pdf-fields"
                                    size="sm"
                                    :value="changeDateFormat(formFields.date)"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                </div>
            </div>

        </PDF>

        <div id="monument-work-order" class="d-flex justify-content-center py-3" >
            <form id="work-order-form" class="form-width">
                <div v-bind:class="[alertClasses, 'd-flex justify-content-center m-auto p-0 w-50']">{{alertMessage}}</div>
                <div class=" work-order-row border rounded">
                    <div class="d-block border-right px-1 pt-1 my-0">
                        <label class="font-weight-bold">Date:</label><br>
                        <label>{{ changeDateFormat(order_date) }}</label>
                    </div>
                    <!--<div class="d-block border-right px-1 pt-1 my-0">
                        <label class="font-weight-bold">Day:</label><br>
                        <label>{{getDayOfWeek(order_date)}}</label>
                    </div>-->
                    <div class="d-block border-right px-1 pt-1 my-0">
                        <label class="font-weight-bold">Name on Monument:</label>
                        <label class="d-block">{{name_on_stone ? name_on_stone.toUpperCase() : '' }}</label>
                    </div>
                    <div class="d-block px-1">
                        <label class="font-weight-bold">Invoice. No:</label>
                        <label class="d-block">{{invoice_no}}</label>
                    </div>
                </div>
                <div class="work-order-row">
                    <div class="">
                        <label class="font-weight-bold">Delivery To Store Location:</label>

                        <!--<b-form-select
                                :options="storeLocations"
                                v-model="formFields.delivery_store_location_id"
                                class="custom-caret-agreement input-select"
                                size="sm">
                            <template #first>
                                <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                            </template>
                            </b-form-select>-->
                        <b-form-input
                            class=""
                            size="sm"
                            v-model="formFields.store_location"
                        ></b-form-input>
                    </div>
                    <div class="">
                        <label class="font-weight-bold">Other Location:</label>

                        <b-form-input
                                class="ml-2 input-xl"
                                size="sm"
                                v-model="formFields.other_location"
                        ></b-form-input>
                    </div>
                </div>
                <div class="work-order-row">
                    <div class="">
                        <label class="font-weight-bold input-label">Company:</label>

                        <b-form-input
                                class=""
                                size="sm"
                                v-model="formFields.company"
                        ></b-form-input>
                    </div>

                </div>
                <div class="work-order-row">
                    <div class="">
                        <label class="font-weight-bold input-label">Address:</label>

                        <b-form-input
                                class=""
                                size="sm"
                                v-model="formFields.address"
                        ></b-form-input>
                    </div>

                </div>
                <div class="work-order-row custom-div-size1">
                    <div>
                        <label class="font-weight-bold label-city">City:</label>
                        <b-form-input type="text"  class="form-control form-control-sm input-city" size="sm" v-model="formFields.city"></b-form-input>
                    </div>
                    <div>
                        <label class="font-weight-bold">State:</label>
                        <b-form-input type="text"  class="form-control form-control-sm input-state" size="sm" v-model="formFields.state"></b-form-input>
                    </div>
                    <div>
                        <label class="font-weight-bold">Zip:</label>
                        <b-form-input type="text"  class="form-control form-control-sm input-zip" size="sm" v-model="formFields.zip"></b-form-input>
                    </div>

                </div>
                <div class="work-order-row">
                    <div class="custom-div-size2">
                        <label class="font-weight-bold label-contact">Contact:</label>
                        <b-form-input type="text"  class="form-control form-control-sm" size="sm" v-model="formFields.contact"></b-form-input>
                    </div>
                    <div class="custom-div-size2">
                        <label class="font-weight-bold">Phone:</label>
                        <b-form-input type="text"  class="form-control form-control-sm" size="sm" v-model="formFields.phone"></b-form-input>
                    </div>

                </div>
                <div class="work-order-row">
                    <div class="flex-grow-1">
                        <label class="font-weight-bold">Work to be done:</label>

                        <b-form-textarea
                                class="ml-2"
                                rows="2"
                                size="sm"
                                v-model="formFields.work_to_be_done"
                                no-resize
                        ></b-form-textarea>
                    </div>

                </div>
                <div class="work-order-row">
                    <div class="flex-grow-1">
                        <label class="font-weight-bold">Stone Size Type & Color:</label>

                        <b-form-textarea
                                class="ml-2"
                                rows="2"
                                size="sm"
                                v-model="formFields.stone_details"
                                no-resize
                        ></b-form-textarea>
                    </div>

                </div>
                <div class="work-order-row">
                    <div class="flex-grow-1">
                        <label class="font-weight-bold">Supplies Needed:</label>

                        <b-form-textarea
                                class="ml-2"
                                rows="3"
                                size="sm"
                                v-model="formFields.supplies_needed"
                                no-resize
                        ></b-form-textarea>
                    </div>

                </div>
                <div class="work-order-row">
                    <div class="flex-grow-1">
                        <label class="font-weight-bold">Work Order Notes:</label>

                        <b-form-textarea
                                class="ml-1"
                                rows="5"
                                size="sm"
                                v-model="formFields.work_order_notes"
                                no-resize
                        ></b-form-textarea>
                    </div>

                </div>
                <div class="work-order-row">
                    <div class="custom-div-size2">
                        <label class="font-weight-bold">Completed By:</label>

                        <b-form-input
                                class="ml-2"
                                size="sm"
                                v-model="formFields.completed_by"
                        ></b-form-input>
                    </div>

                </div>
                <div class="work-order-row">
                    <div class="custom-div-size1">
                        <label class="font-weight-bold">Date:</label>

                        <b-form-datepicker  :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="my-auto input-date" size="sm" name="date" placeholder="" v-model="formFields.date"
                                            @input="formFields.date = checkDate(formFields.date)"
                                           today-button
                                           reset-button
                                           close-button
                                           locale="en">

                        </b-form-datepicker>
                    </div>

                </div>
                <div>
                    <div class="my-2 ml-1" >
                        <button type="button" class="btn btn-sm btn-info custom-print-button  px-2" @click="printPdf">Print Preview</button>
                        <!--<button type="button" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                            save<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                        </button>
                        <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/orders/' + formFields.order_id">Cancel</router-link>
                    --></div>
                </div>
            </form>
        </div>


    </div>
</template>

<script>
    import PDF from "../../../../Modules/PDF-Modal";
    import {event, eventBus} from "../../../../event-bus/event-bus";
    import {saveRecord, fetchRecord} from "../../../../helpers/axios";
    import {searchForEmptyDate} from "../../../../helpers/common";

    export default {
        name: "Add",
        props: {
            id: {
                type: Number
            }
        },
        data() {
            return  {
                formFields:{
                    id:0,
                    other_location:null,
                    customer:null,
                    address:null,
                    city:null,
                    state:null,
                    zip:null,
                    phone:null,
                    contact:null,
                    work_to_be_done:null,
                    stone_details:null,
                    completed_by:null,
                    supplies_needed:null,
                    work_order_notes:null,
                    date:null,
                    delivery_store_location_id:null,
                    order_id:null
                },
                order_date:null,
                order_day:null,
                name_on_stone:'',
                invoice_no:null,
                axiosParams: {module: 'order/deliveryWorkOrder'},
                alertMessage:'',
                hideAlert:true,
                successResponse: false,
                errorResponse: false,
                saveDisabled:false,
            }
        },
        metaInfo() {
            return {
                title: 'Delivery Work Order'
            }
        },
        components:{
            PDF
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
            storeLocations: function () {
                let options = [];
                if(this.$store.state.deliveryWorkOrder.deliveryWorkOrderInfo)
                    for (let opt of this.$store.state.deliveryWorkOrder.deliveryWorkOrderInfo){
                        let obj = {value: opt.id, text: opt.title};
                        options.push(obj);
                    }
                return options;
            },
            isCreatePermitted(){
                return this.$store.getters.isPermitted({resource:'Orders',action:'create'});
            },
            isUpdatePermitted(){
                return this.$store.getters.isPermitted({resource:'Orders',action:'update'});
            },
        },
        beforeCreate(){
            if(!this.$store.getters.isPermitted({resource:'Orders',action:'read'}))
                this.$router.push( '/access-denied');
        },
        mounted() {
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            if(this.$store.state.deliveryWorkOrder.deliveryWorkOrderInfo.length == 0){
                this.$store.dispatch('getDeliveryWorkOrderInfo');
            }
            this.getDeliveryWorkOrder();
            this.$store.getters.detectFormChanges();
        },
        methods:{
            getDeliveryWorkOrder(){
                this.axiosParams.id = this.formFields.id;
                fetchRecord(this.axiosParams, (response) => {
                    this.formFields = response.data.delivery_work_order;

                    this.order_date = response.data.date;
                    this.order_day = this.getDayOfWeek(response.data.date);

                    if(response.data.invoice != undefined)
                        this.invoice_no  = response.data.invoice.invoice_number;
                    if(response.data.family != undefined)
                        this.name_on_stone  = response.data.family.name_on_stone;
                })
            },
            save(){
                this.saveDisabled = true; //Disabling save button
                let data = this.formFields;
                let formData = new FormData();
                formData.append('data',JSON.stringify(data));

                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo){
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                      /*  this.errorResponse = true;
                        this.handleAlert();*/
                        this.makeToast({title: "Error", message:this.alertMessage, variant: "danger", duration: 5000});
                        this.alertMessage = '';
                    }
                    else{
                        let status = this.formFields.id ? 'Updated': 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                       /* this.successResponse = true;
                        this.handleAlert();*/
                        this.makeToast({title: 'Success', message: this.alertMessage, variant: 'success'});
                        this.alertMessage = '';

                        this.formFields = response.data;
                        // this.axiosParams.data = response.data;
                        // this.$store.commit('appendOrUpdateInRecordList', this.axiosParams);
                    }
                },(error) => {
                    if (error.response.status == 403){
                        this.makeToast({title: 'Error', message: error.response.data.message , variant: 'danger', duration: 3000});
                    }
                })
            },

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
            printPdf() {
                eventBus.$emit(event.PRINT_PDF);
            },
            getDayOfWeek:function(date) {
                if(date != null){
                    const dayOfWeek = new Date(date).getDay();

                    return isNaN(dayOfWeek) ? null :
                        ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
                }
            },
            makeToast: function (params) {
                this.$bvToast.toast(params.message, {
                    id: 'cemetery-toast',
                    title: params.title,
                    variant: params.variant,
                    toaster: 'b-toaster-top-center',
                    autoHideDelay: params.duration ? params.duration : 2000,
                    noAutoHide: this.toastHider,
                    noCloseButton: true,
                })
                this.saveDisabled = false;//enabling save button

            },
            checkDate: function(date){
                return searchForEmptyDate(date);
            },
            changeDateFormat: function(value){
                return this.$store.getters.changeDateFormat(value);
            },
        },
    }
</script>

<style scoped>
    .pdf-fields{
        border:none !important;
        color: black !important;
        font-size: 22px !important;
    }
    .pdf-labels{
        font-size: 22px !important;
    }
    .pdf-custom-margin-form{
        margin-top:1rem !important;
        margin-left: 1rem !important;
        margin-right: 1rem !important;
    }
    .pdf-title{
        font-family: Roboto;
        font-style: normal;
        font-weight: 600;
        font-size: 28px;
        line-height: 25px;
        text-align: center;
        letter-spacing: 0.02em;
        color: #000000;
    }
    .pdf-input-select{
        font-size:22px !important;
        color:#6C757D;
        border: 1px solid #C4C4C4;
        box-sizing: border-box;
        border-radius: 3px;
        height: 2.5rem !important;
        padding: 3px;
        background:none !important;
    }
    .pdf-custom-table-header,.pdf-custom-table-body{
        font-size: 22px;
        border: 2px solid #c4c4c4;
    }
    .pdf-input-label{
        width: 9rem !important;
    }
    .pdf-label-city{
        width: 8rem !important;
    }
    .pdf-label-contact{
        width: 11rem !important;
    }
    .pdf-input-city{
        width: 20rem !important;
    }
    .pdf-input-state{
        width: 15rem !important;
    }
    .pdf-input-zip{
        width: 11rem !important;
    }
    .pdf-custom-div-size1{
        width:30rem !important;
    }
    .pdf-custom-div-size2{
        width:35rem !important;
    }

    .pdf label{
        display: block;
        font-size: 0.5em;
        margin-bottom: 0;
    }

    .form-width{
        width:45rem !important;
    }

    .work-order-row
    {
        display: flex;
        padding: 0;
    }
    .work-order-row div
    {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }
    .work-order-row div  label{
        margin: auto 0.5rem;
        white-space: nowrap !important;
        color: #000 !important;
    }
    .work-order-row div input,textarea,.input-date{
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        margin-right: 0;
        font-size: 12px;
    }
    .work-order-row div input,.input-date{
        height:1.5rem;
    }
    header{
        padding: 0 3rem;
    }
    .input-xl{
        width: 20rem;
    }

    .custom-print-button{
        font-size: 12px;
        background: #007BFF;
        box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.25);
        border-radius: 5px
    }

    .custom-div-size1{
        width:16rem !important;
    }
    .custom-div-size2{
        width:20rem !important;
    }
    .input-label{
        width: 4rem !important;
    }
    .label-city{
        width: 3.8rem !important;
    }
    .label-contact{
        width: 4.8rem !important;
    }
    .input-city{
        width: 12rem !important;
    }
    .input-state{
        width: 8rem !important;
    }
    .input-zip{
        width: 6rem !important;
    }

    .table-bordered th {
        border-bottom: none;
    }
    .table-bordered td {
        border-top: none;
    }
    .input-select{
        font-size:12px !important;
        color:#6C757D;
        border: 1px solid #C4C4C4;
        box-sizing: border-box;
        border-radius: 3px;
        height: 1.5rem !important;
        padding: 3px;
    }
    .custom-dangerbtn-text{
        width: 89px;
    }
    .custom-caret-agreement{
        background: #FFF url(http:/images/agreement-icon.png) right 0.75rem center no-repeat;
    }
</style>
