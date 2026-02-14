<template>
    <div class="bg-white mt-n1 pt-1">
        <h3 class="mx-2 my-1 custom-form-heading">Monument (Headstone) Agreement</h3>
        <div class="d-flex non-print-elm justify-content-center bg-toolbar my-2 p-1">
            <button type="button" v-if="formFields.id > 0 ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                {{ formFields.id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
            </button>
            <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/orders/' +id">Cancel</router-link>

        </div>

        <PDF :title="'printMonumentAgreement'">

            <div slot="header" class="my-3 pdf row pdf-margin">
                <div class="pdf-custom-margin-agreement py-3" >
                    <h2 class="pdf-title col-md-12 mb-5">FRISBIE MONUMENTS <br> MONUMENT (HEADSTONE) AGREEMENT</h2>
                    <form >
                         <div class=" agreement-row flex-column mx-auto">
                            <div class="mt-n2">
                                <p>
                                    <!--<b-form-select
                                            class="custom-caret-agreement pdf-input-select"
                                            size="sm">
                                        <option :value="formFields.option_1">{{printValue(formFields.option_1)}}</option>

                                    </b-form-select>-->
                                    -
                                    <span class="pdf-label-form"> 1/2 of the monument must be paid for when the order is placed. If you have a bronze order.
                            <br>it must be paid in full up front. Any invoice total under $250.00 must be paid in advance.</span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <!--<b-form-select
                                            class="custom-caret-agreement pdf-input-select"
                                            size="sm">
                                        <option :value="formFields.option_2">{{printValue(formFields.option_2)}}</option>

                                    </b-form-select>-->
                                    -
                                    <span class="pdf-label-form">If monument is not paid for in full within 45 days of completion or picked up you will lose <br> your deposit and Frisbie’s is not responsible for any damages if the monument is left. If we are waiting <br> for you to complete the order and you do not provided us with the information or payment to proceed <br> within 6 months of order date or you forfeit all moneys put towards the order.</span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <!--<b-form-select
                                            class="custom-caret-agreement pdf-input-select"
                                            size="sm">
                                        <option :value="formFields.option_3">{{printValue(formFields.option_3)}}</option>

                                    </b-form-select>-->
                                    -
                                    <span class="pdf-label-form">Your monument must be paid in full before it will be installed at the cemetery.</span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <!--<b-form-select
                                            class="custom-caret-agreement pdf-input-select"
                                            size="sm">
                                        <option :value="formFields.option_4">{{printValue(formFields.option_4)}}</option>

                                    </b-form-select>-->
                                    -
                                    <span class="pdf-label-form">You are responsible for any additional fees or price increase that the cemetery has such as <br>perpetual care fees, fees for opening and closing of the grave, ext... </span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <!--<b-form-select
                                            class="custom-caret-agreement pdf-input-select"
                                            size="sm">
                                        <option :value="formFields.option_5">{{printValue(formFields.option_5)}}</option>

                                    </b-form-select>-->
                                    -
                                    <span class="pdf-label-form"> Once you have signed the final rough draft of what your monument will look like you are <br> responsible for any additional fees to correct the monument if something is misspelled, misplaced or <br> punctuation is incorrect. Frisbie Monuments is only held responsible if the monument looks different <br> than the final approval signed by you. <b>(Initials</b></span><label class="text-center ml-0 pdf-input-initial pdf-label-value">{{formFields.initials}}</label><span class="pdf-label-form pdf-label-initial"><b>)</b></span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <!--<b-form-select
                                            class="custom-caret-agreement pdf-input-select"
                                            size="sm">
                                        <option :value="formFields.option_6">{{printValue(formFields.option_6)}}</option>

                                    </b-form-select>-->
                                    -
                                    <span class="pdf-label-form">Once the order is written if you wish to have anything changed with your order the price <br> may increase or decrease.</span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <!--<b-form-select
                                            class="custom-caret-agreement pdf-input-select"
                                            size="sm">
                                        <option :value="formFields.option_7">{{printValue(formFields.option_7)}}</option>

                                    </b-form-select>-->
                                    -
                                    <span class="pdf-label-form">If you decide to cancel your order it must be within 25 days of placing the order. On all <br> cancelled orders there will be a charge of 15% ($85 minimum).</span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <!--<b-form-select
                                            class="custom-caret-agreement pdf-input-select"
                                            size="sm">
                                        <option :value="formFields.option_8">{{printValue(formFields.option_8)}}</option>

                                    </b-form-select>-->
                                    -
                                    <span class="pdf-label-form">Frisbie Monuments guarantees the monument to be free of defects that naturally occur.</span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <!--<b-form-select
                                            class="custom-caret-agreement pdf-input-select"
                                            size="sm">
                                        <option :value="formFields.option_9">{{printValue(formFields.option_9)}}</option>

                                    </b-form-select>-->
                                    -
                                    <span class="pdf-label-form">Frisbie Monuments guarantees the foundation work to be free of defects.</span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <!--<b-form-select
                                            class="custom-caret-agreement pdf-input-select"
                                            size="sm">
                                        <option :value="formFields.option_10">{{printValue(formFields.option_10)}}</option>

                                    </b-form-select>-->
                                    -
                                    <span class="pdf-label-form">Our guarantee is that if you are not 100% satisfied with the outcome of your order (once <br> the monument is installed), we will have the opportunity to fix the issue to your satisfaction and if we <br> can not fix the issue to your satisfaction then we will replace your monument with a new one. (Problems <br> must be reported within 30 days of installation)</span>
                                </p>
                            </div>
                            <div class="mt-n2">

                                <!--<b-form-select
                                        class="custom-caret-agreement pdf-input-select"
                                        size="sm">
                                    <option :value="formFields.option_11">{{printValue(formFields.option_11)}}</option>

                                </b-form-select>-->
                                -
                                <label class="pdf-label-form">Date Promised:</label>
                                <b-form-select
                                        class="custom-caret-agreement pdf-approve-select"
                                        size="sm">
                                    <option :value="formFields.date_promised">{{printDateValue(formFields.date_promised)}}</option>
                                </b-form-select>
                                <label class="text-center ml-1 pdf-input-approve pdf-label-value">{{formFields.approval}}</label>
                                <label class="pdf-label-form ml-1">(After Signed Approval & weather pending)</label>
                            </div>
                            <div class="pl-4 custom-div-padding">
                                <label class="text-center pdf-input-customer pdf-label-value">{{formFields.customer_name}}</label>
                                <label class="pdf-label-form custom-label-width">(Customer Name Printed)</label>
                            </div>
                            <div class="pl-4 custom-div-padding">
                                <label class="text-center pdf-input-customer pdf-label-value">{{formFields.customer_signature}}</label>
                                <label class="pdf-label-form">(Customer Signature)</label>
                            </div>
                            <div>
                                <p class="pdf-label-form undertaking-height"> <span class="pdf-undertake-margin">I certify that I am the plot owner of the next in Kin. I understand that I am not to be present at the</span> <br> time the monument is installed. I give Frisbie Monuments my permission to install the monument.</p>
                            </div>
                            <div class="mt-4 pdf-input-padding">
                                <div class="flex-column">
                                    <label class="pdf-label-form text-center ml-0">Date</label>
                                    <label class="text-center ml-0 pdf-label-value">{{ changeDateFormat(formFields.date) }}</label>
                                </div>
                                <div class="flex-column pdf-inputs-margin">
                                    <label class="pdf-label-form text-center ml-0">Invoice No</label>
                                    <label class="text-center ml-0 pdf-label-value">{{formFields.invoice_no}}</label>
                                </div>
                                <div class="flex-column mr-2">
                                    <label class="pdf-label-form text-center ml-0">Last Name on Stone</label>
                                    <label class="text-center ml-0 pdf-label-value">{{formFields.name_on_stone}}</label>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </PDF>

        <div id="monument-agreement" class="custom-margin-agreement py-3" >
            <form id="agreement-form px-1" >
                <div v-bind:class="[alertClasses, 'd-flex justify-content-center m-auto p-0 w-50']">{{alertMessage}}</div>
                <div class=" agreement-row flex-column mx-auto">
                    <div class="mt-n2">
                        <p>
                            <!--<b-form-select
                                :options="options"
                                v-model="formFields.option_1"
                                class="custom-caret-agreement input-select"
                                size="sm">

                            </b-form-select>-->
                            -
                            <span class="label-form"> 1/2 of the monument must be paid for when the order is placed. If you have a bronze order.
                            <br>it must be paid in full up front. Any invoice total under $250.00 must be paid in advance.</span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <!--<b-form-select
                                :options="options"
                                v-model="formFields.option_2"
                                class="custom-caret-agreement input-select"
                                size="sm">

                            </b-form-select>-->
                            -
                            <span class="label-form">If monument is not paid for in full within 45 days of completion or picked up you will lose <br> your deposit and Frisbie’s is not responsible for any damages if the monument is left. If we are waiting <br> for you to complete the order and you do not provided us with the information or payment to proceed <br> within 6 months of order date or you forfeit all moneys put towards the order.</span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <!--<b-form-select
                                :options="options"
                                v-model="formFields.option_3"
                                class="custom-caret-agreement input-select"
                                size="sm">

                            </b-form-select>-->
                            -
                            <span class="label-form">Your monument must be paid in full before it will be installed at the cemetery.</span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <!--<b-form-select
                                :options="options"
                                v-model="formFields.option_4"
                                class="custom-caret-agreement input-select"
                                size="sm">

                            </b-form-select>-->
                            -
                            <span class="label-form">You are responsible for any additional fees or price increase that the cemetery has such as <br>perpetual care fees, fees for opening and closing of the grave, ext... </span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <!--<b-form-select
                                :options="options"
                                v-model="formFields.option_5"
                                class="custom-caret-agreement input-select"
                                size="sm">

                            </b-form-select>-->
                            -
                            <span class="label-form"> Once you have signed the final rough draft of what your monument will look like you are <br> responsible for any additional fees to correct the monument if something is misspelled, misplaced or <br> punctuation is incorrect. Frisbie Monuments is only held responsible if the monument looks different <br> than the final approval signed by you. <b>(Initials</b></span><b-form-input type="text" :disabled="hideInModal" class="form-control form-control-sm input-md input-initial" size="sm" v-model="formFields.initials"></b-form-input><span class="label-form label-initial"><b>)</b></span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <!--<b-form-select
                                :options="options"
                                v-model="formFields.option_6"
                                class="custom-caret-agreement input-select"
                                size="sm">

                            </b-form-select>-->
                            -
                            <span class="label-form">Once the order is written if you wish to have anything changed with your order the price <br> may increase or decrease.</span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <!--<b-form-select
                                :options="options"
                                v-model="formFields.option_7"
                                class="custom-caret-agreement input-select"
                                size="sm">

                            </b-form-select>-->
                            -
                            <span class="label-form">If you decide to cancel your order it must be within 25 days of placing the order. On all <br> cancelled orders there will be a charge of 15% ($85 minimum).</span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <!--<b-form-select
                                :options="options"
                                v-model="formFields.option_8"
                                class="custom-caret-agreement input-select"
                                size="sm">

                            </b-form-select>-->
                            -
                            <span class="label-form">Frisbie Monuments guarantees the monument to be free of defects that naturally occur.</span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <!--<b-form-select
                                :options="options"
                                v-model="formFields.option_9"
                                class="custom-caret-agreement input-select"
                                size="sm">

                            </b-form-select>-->
                            -
                            <span class="label-form">Frisbie Monuments guarantees the foundation work to be free of defects.</span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <!--<b-form-select
                                :options="options"
                                v-model="formFields.option_10"
                                class="custom-caret-agreement input-select"
                                size="sm">

                            </b-form-select>-->
                            -
                            <span class="label-form">Our guarantee is that if you are not 100% satisfied with the outcome of your order (once <br> the monument is installed), we will have the opportunity to fix the issue to your satisfaction and if we <br> can not fix the issue to your satisfaction then we will replace your monument with a new one. (Problems <br> must be reported within 30 days of installation)</span>
                        </p>
                    </div>
                    <div class="mt-n2 custom-div-padding">

                            <!--<b-form-select
                                :options="options"
                                v-model="formFields.option_11"
                                class="custom-caret-agreement input-select"
                                size="sm">

                            </b-form-select>-->
                        -
                        <label class="label-form">Date Promised:</label>
                        <b-form-select
                                v-model="formFields.date_promised"
                                class="custom-caret-agreement input-select"
                                size="sm">
                            <option :value=null>Select</option>
                            <option :value=1>Date</option>
                            <option :value=0>Weeks</option>
                        </b-form-select>
                        <b-form-input type="text" class="form-control form-control-sm ml-1 input-approve" size="sm" v-model="formFields.approval"></b-form-input>
                        <label class="label-form ml-1">(After Signed Approval & weather pending)</label>
                    </div>
                    <div class="pl-4 custom-div-padding">
                        <b-form-input type="text"  class="form-control form-control-sm input-customer" size="sm" v-model="formFields.customer_name"></b-form-input>
                        <label class="label-form custom-label-width">(Customer Name Printed)</label>
                    </div>
                    <div class="pl-4 custom-div-padding">
                        <b-form-input type="text" :disabled="hideInModal" class="form-control form-control-sm input-customer" size="sm" v-model="formFields.customer_signature"></b-form-input>
                        <label class="label-form">(Customer Signature)</label>
                    </div>
                    <div>
                        <p class="label-form undertaking-height"> <span class="pl-4">I certify that I am the plot owner of the next in Kin. I understand that I am not to be present at the</span> <br> time the monument is installed. I give Frisbie Monuments my permission to install the monument.</p>
                    </div>
                    <div class="mt-n2 custom-input-padding">
                        <div class="flex-column custom-div-size1">
                            <label class="label-form text-center ml-0">Date</label>
                            <b-form-input type="text"  class="form-control form-control-sm input-customer" size="sm" v-model="getDateToChange"></b-form-input>
<!--                            <b-form-input type="text" class="form-control form-control-sm input-customer" size="sm" v-model="formFields.date"></b-form-input>-->
                        </div>
                        <div class="flex-column custom-invoice-margin custom-div-size1">
                            <label class="label-form text-center ml-0">Invoice No</label>
                            <b-form-input type="text" class="form-control form-control-sm input-customer" size="sm" v-model="formFields.invoice_no"></b-form-input>
                        </div>
                        <div class="flex-column custom-div-size2">
                            <label class="label-form text-center ml-0">Last Name on Stone</label>
                            <b-form-input type="text"  class="form-control form-control-sm input-customer" size="sm" v-model="formFields.name_on_stone"></b-form-input>
                        </div>
                    </div>


                </div>
                <div>
                    <div >
                        <button type="button" class="btn btn-sm btn-info custom-print-button px-2" @click="printPDF">Print Preview</button>
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
                    option_1:null,
                    option_2:null,
                    option_3:null,
                    option_4:null,
                    option_5:null,
                    initials:'',
                    option_6:null,
                    option_7:null,
                    option_8:null,
                    option_9:null,
                    option_10:null,
                    option_11:null,
                    date_promised:null,
                    approval:'',
                    customer_name:'',
                    customer_signature:'',
                    date:'',
                    invoice_no:'',
                    name_on_stone:'',
                },
                options:[
                    {value:null,text:'Select'},
                    {value:1,text:'Yes'},
                    {value:0,text:'NA'}
                    ],
                axiosParams: {module: 'order/monumentAgreement'},
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
                title: 'Monument Agreement'
            }
        },
        components:{
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
            getDateToChange:{
                get(){
                    return this.$store.getters.changeDateFormat(this.formFields.date);
                },
                set(newVal){
                    this.formFields.date = this.$store.getters.changeDateFormat(newVal)
                    return this.formFields.date
                    //return this.$store.getters.changeDateFormat(newVal);
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
            this.getMonumentAgreement();
            this.$store.getters.detectFormChanges();
        },
        methods:{
            getMonumentAgreement(){
                this.axiosParams.id = this.formFields.id;
                fetchRecord(this.axiosParams, (response) => {
                    this.formFields = response.data.monument_agreement;
                    if (response.data.date)
                    this.formFields.date = response.data.date;
                    if(response.data.invoice != undefined)
                        this.formFields.invoice_no  = response.data.invoice.invoice_number;
                    if(response.data.family != undefined)
                        this.formFields.name_on_stone  = response.data.family.name_on_stone;

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
                        let record = Object.values(this.$store.state[this.axiosParamsOrder.module].recordList).find(obj => obj.id == this.id);
                        if (record != undefined) {
                            record.monument_agreement.id = this.formFields.id
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

            printPDF(){
                eventBus.$emit(event.PRINT_PDF)
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

            /** Generic*/
            printValue(val) {
                if(val == 1)
                    return 'Yes'
                else if(val == 0)
                    return 'NA'
                else
                    return ''
            },
            printDateValue(val) {
                if(val == 1)
                    return 'Date'
                else if(val == 0)
                    return 'Weeks'
                else
                    return ''
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
        },
    }
</script>

<style scoped>

    .pdf-title{
        font-weight: 600;
        font-size: 30px;
        line-height: 30px;
        text-align: center;
        letter-spacing: 0.02em;
        margin-left: -4rem;
    }
    .pdf-label-form{
        font-size:22px !important;
        font-family:'Times New Roman' !important;
        line-height: initial;
    }
    .pdf-label-value{
        font-size: 20px !important;
    }

    .pdf-label-initial{
        margin-top: -1.23rem !important;
        margin-left: 30.7rem !important;
        position:absolute;
    }
    .pdf-input-initial{
        margin-top:-2rem !important;
        margin-left: 25.2rem !important;
        height: 20px;
        width: 95px !important;
    }
    .pdf-input-select{
        background: none !important;
        width:90px;
        height:35px;
        font-size:20px;
        color:#6C757D;
        border: 1px solid #C4C4C4;
        box-sizing: border-box;
        border-radius: 3px;
        padding-top: 2px;
        padding-left: 28px;
        padding-right: 0px;
    }
    .pdf-approve-select{
        background: none !important;
        width:95px;
        height:35px;
        font-size:20px;
        border: 1px solid #C4C4C4;
        box-sizing: border-box;
        border-radius: 3px;
        padding-top: 2px;
        padding-left: 15px;
        padding-right: 0px;
    }
    .pdf-input-approve{
        height: 22px;
        width: 181px !important;
    }
    .pdf-input-customer{
        width:40.5rem;
    }
    .pdf-input-padding{
        margin-left:-4rem !important;
    }
    .pdf-undertake-margin {
        margin-left: 4rem !important;
    }
    .pdf-inputs-margin{
        margin-left:2rem !important;
        margin-right:2rem !important;
    }
    .pdf label{
        display: block;
        font-size: 0.5em;
        margin-bottom: 0;
    }
    .pdf-custom-margin-agreement{
        margin-top:-8rem !important;
        margin-left: 3rem !important;
        margin-right: 0rem !important;
    }
    .pdf-custom-div-padding{
        padding-right: 8.5rem !important;
    }
    .pdf .bottom-section label{
        font-size: 0.5em;
    }

    .pdf .first-row{
        width: 10rem;
        height: 2rem;
    }
    .printing {
        font-family: Roboto;
        padding: 3em;
        margin: 2em auto;
        font-size: 1.5em;
    }

    .label-form{
        font-size:13px !important;
        font-family:'Times New Roman' !important;
        line-height: 14px;
    }
    .agreement-row
    {
        display: flex;
        padding: 0;
    }
    .agreement-row div
    {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }
    .agreement-row div  label{
        margin: auto 0.5rem;
        white-space: nowrap !important;
    }
    .agreement-row div input,.input-date{
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        margin-right: 0;
        font-size: 12px;
    }
    header{
        padding: 0 3rem;
    }
    .custom-label-width{
        width:7rem;
    }
    .label-initial{
        margin-top: -1.15rem !important;
        margin-left: 21.7rem !important;
        position:absolute;
    }
    .input-initial{
       margin-top:-1.3rem !important;
       margin-left: 15.5rem !important;
       height: 20px;
       width: 95px !important;
    }
    .input-select{
        width:67px;
        height:21px;
        font-size:11px;
        color:#6C757D;
        border: 1px solid #C4C4C4;
        box-sizing: border-box;
        border-radius: 3px;
        padding-top: 2px;
        padding-left: 5px;
    }
    .input-approve{
        height: 22px;
        width: 82px !important;
    }
    .input-customer{
        height: 22px;
    }
    .input-md{
        width: 6rem;
    }
    .undertaking-height{
        line-height: inherit;
    }
    .custom-print-button{
        background: #007BFF;
        box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.25);
        border-radius: 5px;
        font-size: 12px;
    }
    .custom-div-size1{
        width:16rem !important;
    }
    .custom-div-size2{
        width:22rem !important;
    }
    .custom-div-padding{
        padding-right: 8.5rem !important;
    }
    .custom-input-padding{
        padding-right: 7.7rem !important;
    }
    .custom-margin-agreement{
        width: 45rem;
        margin:auto;
        /*margin-left: 24rem !important;
        margin-right: 19rem !important;*/
    }
    .custom-invoice-margin{
        margin-left: 2.5rem !important;
        margin-right: 2.5rem !important;
    }
    .custom-dangerbtn-text{
        width: 89px;
    }
    .custom-caret-agreement{
        background: #FFF url(http:/images/agreement-icon.png) right 0.75rem center no-repeat;
    }
</style>
