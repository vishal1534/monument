<template>
    <div class="bg-white mt-n1 pt-1">
        <div>
            <h3 class="mx-2 my-1 custom-form-heading"> Misc. Monument Work Order Form</h3>
            <div class="d-flex non-print-elm justify-content-center bg-toolbar my-2 p-1">
                <button type="button" v-if="formFields.id > 0 ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                    {{ formFields.id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                </button>
                <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/orders/' +id">Cancel</router-link>

            </div>
        </div>

        <PDF :title="'printWorkOrder'">

            <div slot="header" class="pdf-custom-margin-form">
              <h2 class="pdf-title col-md-12">MISC. MONUMENT WORK ORDER FORM</h2>
                <div  class="pdf-fields">
                    <div class="pdf-custom-title">FINAL DATE, BRONZE MILITARY MARKER,<br> MONUMENT RESTORATION, MONUMENT REPAIR, ETC</div>
                    <div class=" work-order-row border rouned my-2">
                        <div class="d-block border-right px-1 pt-1 my-0">
                            <label class="font-weight-bold">Date:</label><br>
                            <label>{{ changeDateFormat(order_date) }}</label>
                        </div>
                       <!-- <div class="d-block border-right px-1 pt-1 my-0">
                            <label class="font-weight-bold">Day:</label><br>
                            <label>{{getDayOfWeek(order_date)}}</label>
                        </div>-->
                        <div class="d-block border-right  px-1 pt-1 my-0">
                            <label class="font-weight-bold">Last Name on Stone :</label>
                            <label class="d-block">{{name_on_stone ? name_on_stone.toUpperCase() : '' }}</label>
                        </div>
                        <div class="d-block  px-1">
                            <label class="font-weight-bold">Invoice. No:</label>
                            <label class="d-block">{{invoice_no}}</label>
                        </div>
                    </div>
                    <div class="work-order-row">
                        <div class="flex-grow-1">
                            <label class="font-weight-bold pdf-labels mt-1">Monument Location:<br> (cemetery & description <br> of area)</label>

                            <b-form-textarea
                                    class="ml-2 pdf-fields"
                                    rows="4"
                                    size="sm"
                                    name="who_follow_up"
                                    v-model="formFields.monument_location"
                                    no-resize
                            ></b-form-textarea>
                        </div>

                    </div>
                    <div class="work-order-row">
                        <div class="">
                            <label class="font-weight-bold pdf-labels">Customer Name:</label>

                            <b-form-input
                                    class="ml-2 input-xl pdf-fields"
                                    size="sm"
                                    v-model="formFields.customer_name"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="work-order-row flex-grow-1">
                        <div class="custom-div-size1">
                            <label class="font-weight-bold pdf-labels">Phone:</label>
                            <b-form-input type="text"  class="form-control form-control-sm pdf-fields" size="sm" style="border:none !important" v-model="formFields.phone"></b-form-input>
                        </div>
                        <div class="pdf-custom-div-size2 pdf-margin-email">
                            <label class="font-weight-bold pdf-labels">Email:</label>
                            <b-form-input type="text"  class="form-control form-control-sm pdf-fields" size="sm" style="border:none !important" v-model="formFields.email"></b-form-input>
                        </div>
                    </div>
                    <div class="work-order-row">
                        <div class="flex-grow-1">
                            <label class="font-weight-bold pdf-labels">Work to be done:</label>

                            <b-form-input
                                    class="ml-2 pdf-fields"
                                    size="sm"
                                    v-model="formFields.work_to_be_done"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="work-order-row">
                        <div class="flex-grow-1">
                            <label class="font-weight-bold pdf-labels">Stone Size Type & Color:</label>

                            <b-form-input
                                    class="ml-2 pdf-fields"
                                    size="sm"
                                    v-model="formFields.stone_details"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="work-order-row">
                        <div class="flex-grow-1">
                            <label class="font-weight-bold pdf-labels mt-1">Supplies Needed:</label>

                            <b-form-textarea
                                    class="ml-2 pdf-fields"
                                    rows="3"
                                    size="sm"
                                    v-model="formFields.supplies_needed"
                                    no-resize
                            ></b-form-textarea>
                        </div>

                    </div>
                    <div class="work-order-row">
                        <div class="flex-grow-1">
                            <label class="font-weight-bold pdf-labels mt-1">Work Order Notes:</label>

                            <b-form-textarea
                                    class="ml-1 pdf-fields"
                                    rows="5"
                                    size="sm"
                                    v-model="formFields.work_order_notes"
                                    no-resize
                            ></b-form-textarea>
                        </div>

                    </div>
                    <div class="work-order-row">
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
                    <div class="work-order-row">
                        <div class="custom-div-size1">
                            <label class="font-weight-bold pdf-labels">Date:</label>
                            <b-form-input
                                    class="my-auto input-date pdf-fields"
                                    size="sm"
                                    v-model="getDateToChange"
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
                <div class="custom-title">FINAL DATE, BRONZE MILITARY MARKER,<br> MONUMENT RESTORATION, MONUMENT REPAIR, ETC</div>
                <div class=" work-order-row border rounded my-2">
                    <div class="d-block border-right px-1 pt-1 my-0">
                        <label class="font-weight-bold">Date:</label><br>
                        <label>{{ changeDateFormat(order_date) }}</label>
                    </div>
                    <!--<div class="d-block border-right px-1 pt-1 my-0">
                        <label class="font-weight-bold">Day:</label><br>
                        <label>{{getDayOfWeek(order_date)}}</label>
                    </div>-->
                    <div class="d-block border-right  px-1 pt-1 my-0">
                        <label class="font-weight-bold">Last name on stone:</label>
                        <label class="d-block">{{name_on_stone ? name_on_stone.toUpperCase() : '' }}</label>
                    </div>
                    <div class="d-block  px-1">
                        <label class="font-weight-bold">Invoice. No:</label>
                        <label class="d-block">{{invoice_no}}</label>
                    </div>
                </div>
                <div class="work-order-row">
                    <div class="flex-grow-1">
                        <label class="font-weight-bold">Monument Location:<br> (cemetery & description <br> of area)</label>

                        <b-form-textarea
                                class="ml-2"
                                rows="3"
                                size="sm"
                                name="who_follow_up"
                                v-model="formFields.monument_location"
                                no-resize
                        ></b-form-textarea>
                    </div>

                </div>
                <div class="work-order-row">
                    <div class="">
                        <label class="font-weight-bold">Customer Name:</label>

                        <b-form-input
                                class="ml-2 input-xl"
                                size="sm"
                                v-model="formFields.customer_name"
                                readonly
                        ></b-form-input>
                    </div>

                </div>
                <div class="work-order-row flex-grow-1">
                    <div class="custom-div-size1">
                        <label class="font-weight-bold">Phone:</label>
                        <b-form-input type="text"  class="form-control form-control-sm" size="sm" v-model="formFields.phone" readonly></b-form-input>
                    </div>
                    <div class="custom-div-size2">
                        <label class="font-weight-bold">Email:</label>
                        <b-form-input type="text"  class="form-control form-control-sm" size="sm" v-model="formFields.email" readonly></b-form-input>
                    </div>
                </div>
                <div class="work-order-row">
                    <div class="flex-grow-1">
                        <label class="font-weight-bold">Work to be done:</label>

                        <b-form-input
                                class="ml-2"
                                size="sm"
                                v-model="formFields.work_to_be_done"
                                no-resize
                        ></b-form-input>
                    </div>

                </div>
                <div class="work-order-row">
                    <div class="flex-grow-1">
                        <label class="font-weight-bold">Stone Size Type & Color:</label>

                        <b-form-input
                                class="ml-2"
                                size="sm"
                                v-model="formFields.stone_details"
                                no-resize
                        ></b-form-input>
                    </div>

                </div>
                <div class="work-order-row">
                    <div class="flex-grow-1">
                        <label class="font-weight-bold">Supplies Needed:</label>

                        <b-form-textarea
                                class="ml-2"
                                rows="2"
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
                                rows="3"
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
                        <button  v-if="formFields.id ? isUpdatePermitted : isCreatePermitted" type="button" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                            Save<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                        </button>
                        <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/orders/' + formFields.order_id">Cancel</router-link>
                    </div>
                </div>
            </form>
        </div>


    </div>
</template>

<script>
    import PDF from "../../../../Modules/PDF-Modal";
    import {event, eventBus} from "../../../../event-bus/event-bus";
    import {saveRecord, fetchRecord} from "../../../../helpers/axios";
    import  {searchForEmptyDate} from "../../../../helpers/common";
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
                    monument_location:null,
                    customer_name:null,
                    phone:null,
                    email:null,
                    work_to_be_done:null,
                    stone_details:null,
                    completed_by:null,
                    supplies_needed:null,
                    work_order_notes:null,
                    date:null
                },
                order_date:null,
                order_day:null,
                name_on_stone:'',
                invoice_no:null,
                axiosParams: {module: 'order/monumentWorkOrder'},
                axiosParamsOrder: {module: 'order'},
                alertMessage:'',
                hideAlert:true,
                successResponse: false,
                errorResponse: false,
                saveDisabled:false,
            }
        },
        metaInfo() {
            return {
                title: 'Monument Work Order'
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
            isCreatePermitted(){
                return this.$store.getters.isPermitted({resource:'Orders',action:'create'});
            },
            isUpdatePermitted(){
                return this.$store.getters.isPermitted({resource:'Orders',action:'update'});
            },
            getDateToChange:{
                get(){
                    return this.$store.getters.changeDateFormat(this.formFields.date);
                },
                set(newVal){
                    return this.$store.getters.changeDateFormat(newVal);
                }
            },
        },
        beforeCreate(){
            if(!this.$store.getters.isPermitted({resource:'Orders',action:'read'}))
                this.$router.push( '/access-denied');
        },
        mounted() {
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            this.getMonumentWorkOrder();
            this.$store.getters.detectFormChanges();
        },
        methods:{
            getMonumentWorkOrder(){
                this.axiosParams.id = this.formFields.id;
                fetchRecord(this.axiosParams, (response) => {
                    this.formFields = response.data.monument_work_order;

                    this.order_date = response.data.date;
                    this.order_day = this.getDayOfWeek(response.data.date);

                    if(response.data.invoice != undefined)
                        this.invoice_no  = response.data.invoice.invoice_number;
                    if(response.data.family != undefined)
                        this.name_on_stone  = response.data.family.name_on_stone;
                        this.formFields.customer_name  = response.data.family.contact;
                        this.formFields.phone  = response.data.family.phone;
                        this.formFields.email  = response.data.family.email;
                })
            },
            changeDateFormat: function(value){
                return this.$store.getters.changeDateFormat(value);
            },
            save(){
                this.saveDisabled = true; //Disabling save button
                let data = this.formFields;
                let formData = new FormData();
                formData.append('data',JSON.stringify(data));

                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo){
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        /*this.errorResponse = true;
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
                        let record = Object.values(this.$store.state[this.axiosParamsOrder.module].recordList).find(obj => obj.id == this.id);
                        if (record != undefined) {
                            record.monument_work_order.id = this.formFields.id
                        }
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
            checkDate: function(date){
                return searchForEmptyDate(date);
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
    .pdf-margin-email{
        margin-left: 10rem !important;
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
    .pdf-custom-title{
        font-style: italic;
        font-weight: 600;
        font-size: 18px;
        line-height: 20px;
        text-align: center;
        letter-spacing: 0.02em;
    }
    .pdf-custom-table-header,.pdf-custom-table-body{
        font-size: 22px;
        border: 2px solid #c4c4c4;
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
    .pdf-custom-div-size2{
        width:30rem !important;
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
        width:25rem !important;
    }

    .table-bordered th {
        border-bottom: none;
    }
    .table-bordered td {
        border-top: none;
    }
    .custom-title{
        font-style: italic;
        font-weight: 600;
        font-size: 13px;
        line-height: 15px;
        text-align: center;
        letter-spacing: 0.02em;

    }
    .custom-dangerbtn-text{
        width: 89px;
    }
</style>
