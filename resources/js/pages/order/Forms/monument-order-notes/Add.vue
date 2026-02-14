<template>
    <div class="bg-white mt-n1 pt-1">
        <div v-if="!hideInModal">
            <h3 class="mx-2 my-1 custom-form-heading">Monument Order Notes</h3>
            <div class="d-flex non-print-elm justify-content-center bg-toolbar my-2 p-1">
                <button type="button" v-if="formFields.id > 0 ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                    {{ formFields.id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                </button>
                <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/orders/' +id">Cancel</router-link>

            </div>
        </div>
        <div id="porcelain" class="d-flex justify-content-center py-3" >
            <form id="porcelain-form" class="form-width">
                <div v-bind:class="[alertClasses, 'd-flex justify-content-center m-auto p-0 w-50']">{{alertMessage}}</div>
                <div class=" monument-order-row border rounded">
                    <div class="d-block border-right px-1 pt-1 my-0">
                        <label class="font-weight-bold">Date:</label><br>
                        <label>{{ changeDateFormat(order_date) }}</label>
                    </div>
                    <!--<div class="d-block border-right px-1 pt-1 my-0">
                        <label class="font-weight-bold">Day:</label><br>
                        <label>{{getDayOfWeek(order_date)}}</label>
                    </div>-->
                    <div class="d-block border-right px-1 pt-1 my-0">
                        <label class="font-weight-bold">Last Name on Stone:</label><br>
                        <label>{{customizeLabel(name_on_stone)}}</label>
                    </div>
                    <div class="d-block border-right px-1">
                        <label class="font-weight-bold">Invoice. No:</label>
                        <label class="d-block">{{invoice_no}}</label>
                    </div>
                    <!--<div class="d-block px-1 pt-1 my-0">
                        <label class="font-weight-bold">Family Name:</label>
                        <label class="d-block">{{name_on_stone ? name_on_stone.toUpperCase() : '' }}</label>
                    </div>-->
                </div>
                <div class="mx-2 my-1 custom-title">Actions, Services, Other items & Misc. things that still need to be completed
                    <br>to process Order</div>
                <div class="monument-order-row">
                    <div class=" flex-column flex-grow-1">
                        <b-form-textarea
                                class="mt-1"
                                rows="2"
                                size="sm"
                                v-model="formFields.note_1"
                                no-resize
                        ></b-form-textarea>
                    </div>
                </div>
                <div class="monument-order-row">
                    <div class=" flex-column flex-grow-1">
                        <hr class="border mt-1 mb-2">
                        <b-form-textarea
                                class="mt-1"
                                rows="2"
                                size="sm"
                                v-model="formFields.note_2"
                                no-resize
                        ></b-form-textarea>
                    </div>
                </div>
                <div class="monument-order-row">
                    <div class=" flex-column flex-grow-1">
                        <hr class="border mt-1 mb-2">
                        <b-form-textarea
                                class="mt-1"
                                rows="2"
                                size="sm"
                                v-model="formFields.note_3"
                                no-resize
                        ></b-form-textarea>
                    </div>
                </div>
                <div class="monument-order-row">
                    <div class=" flex-column flex-grow-1">
                        <hr class="border mt-1 mb-2">
                        <b-form-textarea
                                class="mt-1"
                                rows="2"
                                size="sm"
                                v-model="formFields.note_4"
                                no-resize
                        ></b-form-textarea>
                    </div>
                </div>
                <div class="monument-order-row">
                    <div class=" flex-column flex-grow-1">
                        <hr class="border mt-1 mb-2">
                        <b-form-textarea
                                class="mt-1"
                                rows="2"
                                size="sm"
                                v-model="formFields.note_5"
                                no-resize
                        ></b-form-textarea>
                    </div>
                </div>
                <div class="monument-order-row">
                    <div class=" flex-column flex-grow-1">
                        <hr class="border mt-1 mb-2">
                        <b-form-textarea
                                class="mt-1"
                                rows="2"
                                size="sm"
                                v-model="formFields.note_6"
                                no-resize
                        ></b-form-textarea>
                    </div>
                </div>
                <div class="monument-order-row">
                    <div class=" flex-column flex-grow-1">
                        <hr class="border mt-1 mb-2">
                        <b-form-textarea
                                class="mt-1"
                                rows="4"
                                size="sm"
                                v-model="formFields.note_7"
                                no-resize
                        ></b-form-textarea>
                    </div>
                </div>

                <div>
                    <div class="my-2 ml-1" >
                        <button type="button" class="btn btn-sm btn-info custom-print-button  px-2" @click="printPdf">Print Preview</button>
                        <!--<button type="button" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="storeMonumentOrderNotes" :disabled="saveDisabled">
                            {{ id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                        </button>
                        <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" to="/order-list">Cancel</router-link>
                   --> </div>
                </div>
            </form>
        </div>
        <PDF :title="'printMonumentOrderNotes'">
            <div slot="header" class="pdf-custom-margin-form">
                <h2 class="pdf-title col-md-12">MONUMENT ORDER NOTES</h2>
                <form>
                    <div class=" monument-order-row border rounded">
                        <div class="d-block border-right px-1 pt-1 my-0">
                            <label class="font-weight-bold">Date:</label><br>
                            <label>{{ changeDateFormat(order_date) }}</label>
                        </div>
                        <!--<div class="d-block border-right px-1 pt-1 my-0">
                            <label class="font-weight-bold">Day:</label><br>
                            <label>{{getDayOfWeek(order_date)}}</label>
                        </div>-->
                        <div class="d-block border-right px-1 pt-1 my-0">
                            <label class="font-weight-bold">Last Name on Stone:</label><br>
                            <label>{{customizeLabel(name_on_stone)}}</label>
                        </div>
                        <div class="d-block border-right px-1">
                            <label class="font-weight-bold">Invoice. No:</label>
                            <label class="d-block">{{invoice_no}}</label>
                        </div>
                        <!--<div class="d-block px-1 pt-1 my-0">
                            <label class="font-weight-bold">Family Name:</label>
                            <label class="d-block">{{name_on_stone ? name_on_stone.toUpperCase() : '' }}</label>
                        </div>-->
                    </div>
                    <div class="mx-2 my-1 pdf-custom-title my-4">Actions, Services, Other items & Misc. things that still need to be completed
                        <br>to process Order</div>
                    <div class="monument-order-row">
                        <div class=" flex-column flex-grow-1">
                            <b-form-textarea
                                class="mt-1 pdf-fields"
                                rows="2"
                                size="sm"
                                v-model="formFields.note_1"
                                no-resize
                            ></b-form-textarea>
                        </div>
                    </div>
                    <div class="monument-order-row">
                        <div class=" flex-column flex-grow-1">
                            <hr class="border mt-1 mb-2">
                            <b-form-textarea
                                class="mt-1 pdf-fields"
                                rows="2"
                                size="sm"
                                v-model="formFields.note_2"
                                no-resize
                            ></b-form-textarea>
                        </div>
                    </div>
                    <div class="monument-order-row">
                        <div class=" flex-column flex-grow-1">
                            <hr class="border mt-1 mb-2">
                            <b-form-textarea
                                class="mt-1 pdf-fields"
                                rows="2"
                                size="sm"
                                v-model="formFields.note_3"
                                no-resize
                            ></b-form-textarea>
                        </div>
                    </div>
                    <div class="monument-order-row">
                        <div class=" flex-column flex-grow-1">
                            <hr class="border mt-1 mb-2">
                            <b-form-textarea
                                class="mt-1 pdf-fields"
                                rows="2"
                                size="sm"
                                v-model="formFields.note_4"
                                no-resize
                            ></b-form-textarea>
                        </div>
                    </div>
                    <div class="monument-order-row">
                        <div class=" flex-column flex-grow-1">
                            <hr class="border mt-1 mb-2">
                            <b-form-textarea
                                class="mt-1 pdf-fields"
                                rows="2"
                                size="sm"
                                v-model="formFields.note_5"
                                no-resize
                            ></b-form-textarea>
                        </div>
                    </div>
                    <div class="monument-order-row">
                        <div class=" flex-column flex-grow-1">
                            <hr class="border mt-1 mb-2">
                            <b-form-textarea
                                class="mt-1 pdf-fields"
                                rows="2"
                                size="sm"
                                v-model="formFields.note_6"
                                no-resize
                            ></b-form-textarea>
                        </div>
                    </div>
                    <div class="monument-order-row">
                        <div class=" flex-column flex-grow-1">
                            <hr class="border mt-1 mb-2">
                            <b-form-textarea
                                class="mt-1 pdf-fields"
                                rows="5"
                                size="sm"
                                v-model="formFields.note_7"
                                no-resize
                            ></b-form-textarea>
                        </div>
                    </div>
                </form>
            </div>



        </PDF>
    </div>
</template>

<script>
    import PDF from "../../../../Modules/PDF-Modal";
    import {event, eventBus} from "../../../../event-bus/event-bus";
    import {saveRecord, fetchRecord, deleteRecord,nextRecord, previousRecord, firstRecord, lastRecord} from "../../../../helpers/axios";
    export default {
        name: "Add",
        props: {
            id: {
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
                    note_1:null,
                    note_2:null,
                    note_3:null,
                    note_4:null,
                    note_5:null,
                    note_6:null,
                    note_7:null,
                    order_id:null
                },
                order_date:null,
                order_day:'',
                name_on_stone:'',
                invoice_no:null,
                axiosParams: {module: 'order/monumentOrderNotes'},
                alertMessage:'',
                hideAlert:true,
                successResponse: false,
                errorResponse: false,
                saveDisabled:false,
            }
        },
        metaInfo() {
            return {
                title: 'Monument Order Notes'
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
        },
        beforeCreate(){
            if(!this.$store.getters.isPermitted({resource:'Orders',action:'read'}))
                this.$router.push( '/access-denied');
        },
        mounted() {
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            this.getMonumentOrderNotes();
            this.$store.getters.detectFormChanges();
        },
        methods:{
            getMonumentOrderNotes(){
                this.axiosParams.id = this.formFields.id;
                fetchRecord(this.axiosParams, (response) => {
                    this.formFields = response.data.monument_order_notes;

                    this.order_date = response.data.date;
                    this.order_day = this.getDayOfWeek(response.data.date);

                    if(response.data.invoice != undefined)
                        this.invoice_no  = response.data.invoice.invoice_number;
                    if(response.data.family != undefined)
                        this.name_on_stone  = response.data.family.name_on_stone;
                },(error) => {
                    if (error.response.status == 403){
                        this.makeToast({title: 'Error', message: error.response.data.message , variant: 'danger', duration: 3000});
                    }
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
                       /* this.errorResponse = true;
                        this.handleAlert();*/
                        this.makeToast({title: "Error", message:this.alertMessage, variant: "danger", duration: 5000});
                        this.alertMessage = '';
                    }
                    else{
                        let status = this.formFields.id ? 'Updated': 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                      /*  this.successResponse = true;
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
            changeDateFormat: function(value){
                return this.$store.getters.changeDateFormat(value);
            },
            customizeLabel: function (str) {
                let i, labels = str.split('_');
                for (i = 0; i < labels.length; i++) {
                    labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
                }
                return labels.join(' ');
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
        margin-left: 2rem !important;
        margin-right: 2rem !important;
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
        font-weight: 600;
        font-size: 22px;
        line-height: 24px;
        text-align: center;
        color: #6868FF;
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
        width: 45rem !important;
    }
    .monument-order-row
    {
        display: flex;
        padding: 0;
    }
    .monument-order-row div
    {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }
    .monument-order-row div  label{
        margin: auto 0.5rem;
        white-space: nowrap !important;
        color: #000 !important;
    }
    .monument-order-row div input,textarea{
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        margin-right: 0;
        font-size: 12px;
    }
    header{
        padding: 0 3rem;
    }



    .table-bordered th {
        border-bottom: none;
    }
    .table-bordered td {
        border-top: none;
    }
    .custom-title{
        font-weight: 600;
        font-size: 15px;
        line-height: 17px;
        text-align: center;
        color: #6868FF;
    }
    .custom-dangerbtn-text{
        width: 89px;
    }
</style>
