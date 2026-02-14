<template>

    <div>
        <h5 class="mx-2 my-1 custom-view-heading non-print-elm">Soldier's Memorial Legacy Brick</h5>
        <div class="d-flex non-print-elm justify-content-center bg-toolbar my-2 p-1">
            <button type="button" v-if="formFields.brick.id > 0 ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1 px-4 w-auto custom-infobtn-toolbar custom-infobtn-text"
                    @click="save" :disabled="saveDisabled">
                {{ formFields.brick.id   ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
            </button>
            <router-link class="btn btn-sm btn-warning mx-1 px-4 custom-dangerbtn-toolbar custom-dangerbtn-text"
                         :to="'/orders/'+formFields.id">Back
            </router-link>

        </div>

        <div class="row">
            <div class="col-md-12">

                <div v-bind:class="[alertClasses, 'd-flex non-print-elm justify-content-center m-auto p-1 w-50']">
                    {{alertMessage}}
                </div>

                <form class="div-shadow bg-white rounded mx-2 mb-2 p-3">

                    <div class="form-content">
                        <div class="brick-row border rounded">

                            <div class="d-block border-right px-1 m-0">
                                <label class="font-weight-bold">Date:</label>
                                <label class="d-block">{{ changeDateFormat(formFields.date) }}</label>
                            </div>
                            <!--<div class="d-block border-right px-1 m-0">
                                <label class="font-weight-bold">Day:</label>
                                <label class="d-block">{{getDayOfWeek(formFields.date)}}</label>
                            </div>-->
                            <div class="d-block border-right px-1 m-0">
                                <label class="font-weight-bold">Last Name on Stone:</label>
                                <label class="d-block">{{formFields.family.name_on_stone}}</label>
                            </div>
                            <div class="d-block px-1 m-0">
                                <label class="font-weight-bold">Invoice No.</label>
                                <label class="d-block">{{ formFields.invoice.invoice_number }}</label>
                            </div>
                        </div>

                        <div class="brick-row my-2">
                            <div class="d-block">
                                <div class="my-2">
                                    <label class="font-weight-bold col-2 my-auto p-0">Name:</label>
                                    <b-form-input type="text" class="mx-4" size="sm"
                                                  v-model="formFields.brick.first_name"></b-form-input>
                                </div>
                                <div>
                                    <label class="font-weight-bold col-2 my-auto p-0">Phone:</label>
                                    <b-form-input type="text" class="mx-4" size="sm"
                                                  v-model="formFields.brick.first_phone"></b-form-input>
                                </div>
                            </div>
                            <div>
                                <label class="non-print-elm font-weight-bold my-0">Address:</label>
                                <label class="print-elm font-weight-bold mt-1">Address:</label>
                                <b-form-textarea
                                        size="sm"
                                        class="non-print-elm py-0"
                                        v-model="formFields.brick.first_address"
                                        no-resize
                                ></b-form-textarea>
                                <div class="print-elm">{{formFields.brick.first_address}}</div>
                            </div>
                        </div>
                        <div class="brick-row">
                            <div>
                                <h5 class="mx-auto text-purple">MESSAGE FOR YOUR LEGACY BRICK</h5>
                            </div>
                        </div>
                        <div class="brick-row flex-wrap">
                            <div class="justify-content-center">
                                <template v-for="(s, i) in 14">
                                    <b-form-input type="text" class="input-sm my-1 mx-2" size="sm" maxlength="1"
                                                  v-model="brick1[i]"></b-form-input>
                                </template>
                            </div>
                            <div class="justify-content-center">
                                <template v-for="(s, i) in 14">
                                    <b-form-input type="text" class="input-sm my-1 mx-2" size="sm" maxlength="1"
                                                  v-model="brick1[i+14]"></b-form-input>
                                </template>
                            </div>
                            <div class="justify-content-center">
                                <template v-for="(s, i) in 14">
                                    <b-form-input type="text" class="input-sm my-1 mx-2" size="sm" maxlength="1"
                                                  v-model="brick1[i+28]"></b-form-input>
                                </template>
                            </div>
                        </div>

                        <hr class="border my-3">

                        <div class="brick-row my-2">
                            <div class="d-block">

                                <div class="my-2">
                                    <label class="font-weight-bold col-2 my-auto p-0">Name:</label>
                                    <b-form-input type="text" class="mx-4" size="sm"
                                                  v-model="formFields.brick.second_name"></b-form-input>
                                </div>
                                <div>
                                    <label class="font-weight-bold col-2 my-auto p-0">Phone:</label>
                                    <b-form-input type="text" class="mx-4" size="sm"
                                                  v-model="formFields.brick.second_phone"></b-form-input>
                                </div>

                            </div>
                            <div>
                                <label class="non-print-elm font-weight-bold my-0">Address:</label>
                                <label class="print-elm font-weight-bold mt-1">Address:</label>
                                <b-form-textarea
                                        class="non-print-elm py-0"
                                        size="sm"
                                        v-model="formFields.brick.second_address"
                                        no-resize
                                ></b-form-textarea>
                                <div class="print-elm">{{formFields.brick.second_address}}</div>
                            </div>
                        </div>
                        <div class="brick-row">
                            <div>
                                <h5 class="mx-auto text-purple">MESSAGE FOR YOUR LEGACY BRICK</h5>
                            </div>
                        </div>
                        <div class="brick-row flex-wrap">
                            <div class="justify-content-center">
                                <template v-for="(s, i) in 14">
                                    <b-form-input type="text" class="input-sm my-1 mx-2" size="sm" maxlength="1"
                                                  v-model="brick2[i]"></b-form-input>
                                </template>
                            </div>
                            <div class="justify-content-center">
                                <template v-for="(s, i) in 14">
                                    <b-form-input type="text" class="input-sm my-1 mx-2" size="sm" maxlength="1"
                                                  v-model="brick2[i+14]"></b-form-input>
                                </template>
                            </div>
                            <div class="justify-content-center">
                                <template v-for="(s, i) in 14">
                                    <b-form-input type="text" class="input-sm my-1 mx-2" size="sm" maxlength="1"
                                                  v-model="brick2[i+28]"></b-form-input>
                                </template>
                            </div>
                        </div>


                        <div class="brick-row px-5" style="margin-top: 8rem;">
                            <div>
                                <label class="font-weight-bold my-auto text-nowrap">Approved by:</label>
                                <b-form-input type="text" class="mx-4" size="sm"
                                              v-model="formFields.brick.approved_by"></b-form-input>
                            </div>
                            <div>
                                <label class="font-weight-bold my-auto text-nowrap">Date:</label>
                                <label class="print-elm d-none">{{ changeDateFormat(formFields.brick.date) }}</label>
                                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="non-print-elm input-date" size="sm" placeholder=""
                                                   v-model="formFields.brick.date"
                                                   @input="formFields.brick.date = checkDate(formFields.brick.date)"
                                                   today-button
                                                   reset-button
                                                   close-button
                                                   locale="en">
                                </b-form-datepicker>

                            </div>
                        </div>
                        <div class="d-block text-center font-weight-bold" style="font-family: Roboto;">
                            <label class="d-block m-0">BY SIGNING THE APPROVAL I ASSUME COMPLETE RESPONSIBILITY FOR
                                LAYOUT/SPELLING/DATES.</label>
                            <label class="d-block m-0">I ALSO AGREE THAT AFTER SIGNING THE APPROVAL, NO FURTHER CHANGES
                                WILL BE MADE & IF </label>
                            <label class="d-block m-0">SOMETHING IS INCORRECT UPON COMPLETION OF THE MONUMENT I AM
                                RESPONSIBLE</label>
                            <label class="d-block m-0">FOR THE COST TO CORRECT IT.</label>

                        </div>

                        <div class="brick-row non-print-elm">
                            <div>
                                <button type="button" class="btn btn-sm btn-info custom-print-button  px-2" @click="printPDF">Print Preview</button>
                            </div>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

</template>

<script>
    import {saveRecord, fetchRecord} from "../../../../helpers/axios";
    import {event, eventBus} from "../../../../event-bus/event-bus";
    import {searchForEmptyDate} from "../../../../helpers/common";

    export default {
        name: "Content",
        props: ['formFields'],
        computed: {
            alertClasses: function () {
                return {
                    alert: true,
                    'alert-success': this.successResponse,
                    'alert-danger': this.errorResponse,
                    'd-none': this.hideAlert
                }
            },
            brick1() {
                let brick = [];

                if (this.formFields.brick.brick_1 != null && this.formFields.brick.brick_1 != '') {

                    if (typeof this.formFields.brick.brick_1 == 'string')
                        this.formFields.brick.brick_1 = [...this.formFields.brick.brick_1]

                    for (let i = 0; i < 43; i++) {
                        // setting index to empty "" in case of space " " , because only one character allowed in input,
                        // so if there is a space " " then first we need to clear the space after that we can enter character.
                        if (this.formFields.brick.brick_1[i] == undefined || this.formFields.brick.brick_1[i] == " ")
                            brick[i] = '';
                        else
                            brick[i] = this.formFields.brick.brick_1[i];
                    }
                }

                return brick
            },
            brick2() {
                let brick = [];

                if (this.formFields.brick.brick_2 != null && this.formFields.brick.brick_2 != '') {

                    if (typeof this.formFields.brick.brick_2 == 'string')
                        this.formFields.brick.brick_2 = [...this.formFields.brick.brick_2]

                    for (let i = 0; i < 43; i++) {
                        // setting index to empty "" in case of space " " , because only one character allowed in input,
                        // so if there is a space " " then first we need to clear the space after that we can enter character.
                        if (this.formFields.brick.brick_2[i] == undefined || this.formFields.brick.brick_2[i] == " ")
                            brick[i] = '';
                        else
                            brick[i] = this.formFields.brick.brick_2[i];
                    }
                }
                return brick
            },
            isCreatePermitted(){
                return this.$store.getters.isPermitted({resource:'Orders',action:'create'});
            },
            isUpdatePermitted(){
                return this.$store.getters.isPermitted({resource:'Orders',action:'update'});
            },
        },
        data() {
            return {
                axiosParams: {module: 'order/brick'},
                alertMessage: '',
                hideAlert: true,
                successResponse: false,
                errorResponse: false,
                saveDisabled: false,
            }
        },
        methods: {
            save() {

                this.setBrickFields()

                this.saveDisabled = true; //Disabling save button
                let data = this.formFields.brick;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));

                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                      /*  this.errorResponse = true;
                        this.handleAlert();*/
                        this.makeToast({title: "Error", message:this.alertMessage, variant: "danger", duration: 5000});
                        this.alertMessage = '';
                    } else {
                        let status = this.formFields.brick.id ? 'Updated' : 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                        this.makeToast({title: 'Success', message: this.alertMessage, variant: 'success'});
                        this.alertMessage = '';
                        /*this.successResponse = true;
                        this.handleAlert();*/
                    }
                },(error) => {
                    if (error.response.status == 403){
                        this.makeToast({title: 'Error', message: error.response.data.message , variant: 'danger', duration: 3000});
                    }
                })
            },
            setBrickFields() {

                this.formFields.brick.brick_1 = this.brick1
                this.formFields.brick.brick_2 = this.brick2
            },
            printPDF() {
                this.setBrickFields()
                eventBus.$emit(event.PRINT_PDF)
            },
            handleAlert: function () {
                this.saveDisabled = false;//enabling save button
                this.hideAlert = false;
                setTimeout(() => {
                    this.alertMessage = "";
                    this.successResponse = false;
                    this.errorResponse = false;
                    this.hideAlert = true;
                }, 3000)
            },
            getDayOfWeek: function (date) {
                if (date != null) {
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
        }
    }
</script>

<style scoped>
    .form-content {
        margin: 0 auto;
        width: 45rem;
    }

    .brick-row {
        display: flex;
        padding: 0;
    }

    .brick-row div {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }

    .brick-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
    }

    .brick-row div input, .input-date {
        border: 1px solid #c4c4c4;
        margin: auto;
        margin-right: 0;
        height: 1.5rem;
        font-size: 0.75rem;
    }

    textarea{
        font-size: 0.75rem;
        border: 1px solid #c4c4c4;
    }

    header {
        padding: 0 3rem;
    }

    .input-xl {
        width: 20rem;
    }

    .input-lg {
        width: 12rem;
    }

    .input-md {
        width: 6rem;
    }

    .input-sm {
        width: 2.2rem;
        height: 1.4rem;
    }

    .input-date {
        font-size: .6rem;
    }

    /*.printing .form-content{
        width: 100%;
    }
    .printing label, .printing input, .printing textarea{
        font-size: 1.2rem;
    }
    .printing h5, .printing h3{
        font-size: 2rem;
    }
    .printing input, .printing textarea{
        border-color: transparent !important;
        background: transparent !important;
        pointer-events: none;
        height: auto;
    }
    .printing .non-print-elm{
        display: none !important;
    }
    .printing .print-elm{
        display: block !important;
    }*/
</style>
