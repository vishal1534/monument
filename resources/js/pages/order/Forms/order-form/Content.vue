<template>

    <div>
        <h5 class="mx-2 my-1 non-print-elm custom-view-heading">Order Form</h5>
        <div class="d-flex non-print-elm justify-content-center bg-toolbar my-2 p-1">
            <button type="button" v-if="formFields.order_form.id > 0 ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1 px-4 w-auto custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                {{ formFields.order_form.id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
            </button>
            <router-link class="btn btn-sm btn-warning mx-1 px-4 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/orders/'+formFields.id">Back</router-link>
        </div>

        <div class="row ">
            <div class="col-md-12">

                <div v-bind:class="[alertClasses, 'd-flex non-print-elm justify-content-center m-auto p-1 w-50']">{{alertMessage}}</div>

                <form class="div-shadow bg-white rounded mx-2 mb-2 p-3">

                    <div class="form-content">

                        <div class="order-form-row border rounded">

                            <div class="d-block border-right px-1">
                                <label class="font-weight-bold">Date:</label>
                                <label class="d-block">{{ changeDateFormat(formFields.date) }}</label>
                            </div>
                            <!--<div class="d-block border-right px-1">
                                <label class="font-weight-bold">Day:</label>
                                <label class="d-block">{{getDayOfWeek(formFields.date)}}</label>
                            </div>
                            <div class="d-block border-right px-1">
                                <label class="font-weight-bold">Customer Name:</label>
                                <label class="d-block">{{formFields.company.name}}</label>
                            </div>-->
                            <div class="d-block border-right px-1">
                                <label class="font-weight-bold">Last Name on Stone:</label>
                                <label class="d-block">{{formFields.family?.name_on_stone}}</label>
                            </div>
                            <div class="d-block px-1">
                                <label class="font-weight-bold">Invoice No.</label>
                                <label class="d-block">{{ formFields.invoice.invoice_number }}</label>
                            </div>
                        </div>

                        <div class="order-form-row my-2">
                            <div>
                                <label class="font-weight-bold my-auto text-nowrap">Appt. Location:</label>
                                <b-form-input type="text" class="mx-4" size="sm" v-model="formFields.order_form.appt_location"></b-form-input>
                            </div>
                            <div>
                                <label class="font-weight-bold my-auto text-nowrap">Store to Get Credit:</label>
                                <b-form-input type="text" class="ml-4" size="sm" v-model="formFields.order_form.store_credit"></b-form-input>
                            </div>
                        </div>

                        <hr class="border">

                        <div class="order-form-row w-75">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">Date:</label>
                                <span class="ml-n5 mr-2 print-elm"></span>
                                <label class="print-elm print-elm-label">{{ changeDateFormat(formFields.order_form.date) }}</label>
                                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="non-print-elm input-date" size="sm" placeholder="" v-model="formFields.order_form.date"
                                                   @input="formFields.order_form.date = checkDate(formFields.order_form.date)"
                                                   today-button
                                                   reset-button
                                                   close-button
                                                   locale="en">
                                </b-form-datepicker>
                            </div>
                        </div>
                        <div class="order-form-row w-75">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">Part #:</label>
                                <span class="ml-n5 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.part_no"></b-form-input>
                            </div>
                        </div>
                        <div class="order-form-row w-75">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">Color:</label>
                                <span class="ml-n5 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.color"></b-form-input>
                            </div>
                        </div>
                        <div class="order-form-row w-75">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">Type:</label>
                                <span class="ml-n5 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.type"></b-form-input>
                            </div>
                        </div>
                        <div class="order-form-row w-75">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">Shape:</label>
                                <span class="ml-n5 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.shape"></b-form-input>
                            </div>
                        </div>
                        <div class="order-form-row w-75">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">Size:</label>
                                <span class="ml-n5 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.size"></b-form-input>
                            </div>
                        </div>
                        <div class="order-form-row w-75">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">Top Finish:</label>
                                <span class="ml-n5 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.top_finish"></b-form-input>
                            </div>
                        </div>
                        <div class="order-form-row w-75">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">Base:</label>
                                <span class="ml-n5 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.base"></b-form-input>
                            </div>
                        </div>
                        <div class="order-form-row w-75">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">Base Finish:</label>
                                <span class="ml-n5 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.base_finish"></b-form-input>
                            </div>
                        </div>
                        <div class="order-form-row w-75">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">Picture:</label>
                                <span class="ml-n5 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.picture"></b-form-input>
                            </div>
                        </div>

                        <hr class="border my-3">

                        <div class="order-form-row">
                            <label class="font-weight-bold">Custom To Fill Out</label>
                        </div>
                        <div class="order-form-row">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">Last Name on Monument:</label>
                                <span class="ml-n5 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.last_name_on_monument"></b-form-input>
                            </div>
                        </div>
                        <div class="order-form-row">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">Purchaser:</label>
                                <span class="ml-n5 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.purchaser"></b-form-input>
                            </div>
                        </div>
                        <div class="order-form-row">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">Address:</label>
                                <span class="ml-n5 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.address"></b-form-input>
                            </div>
                        </div>
                        <div class="order-form-row">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">City, State, Zip:</label>
                                <span class="ml-n5 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.city_state_zip"></b-form-input>
                            </div>
                        </div>
                        <div class="order-form-row">
                            <div>
                                <label class="font-weight-bold col-6 m-0 px-0">Phone:</label>
                                <span class="ml-n5 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.phone"></b-form-input>
                            </div>
                            <div>
                                <label class="font-weight-bold col-3 m-0">Alt. Phone:</label>
                                <span class="ml-n2 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.alt_phone"></b-form-input>
                            </div>
                        </div>
                        <div class="order-form-row">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">Email:</label>
                                <span class="ml-n5 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.email"></b-form-input>
                            </div>
                        </div>
                        <div class="order-form-row">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">Name:</label>
                                <span class="ml-n5 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.first_name"></b-form-input>
                            </div>
                        </div>
                        <div class="order-form-row">
                            <div>
                                <label class="font-weight-bold col-6 my-auto px-0">Birth Date:</label>
                                <span class="ml-n5 mr-2 print-elm"></span>
                                <label class="print-elm print-elm-label">{{ changeDateFormat(formFields.order_form.first_birth_date) }}</label>
                                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="non-print-elm input-date" size="sm" placeholder="" v-model="formFields.order_form.first_birth_date"
                                                   @input="formFields.order_form.first_birth_date = checkDate(formFields.order_form.first_birth_date)"
                                                   today-button
                                                   reset-button
                                                   close-button
                                                   locale="en">
                                </b-form-datepicker>
                            </div>
                            <div>
                                <label class="font-weight-bold col-3 my-auto">Death Date:</label>
                                <label class="print-elm print-elm-label mr-2">{{ changeDateFormat(formFields.order_form.first_death_date) }}</label>
                                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="non-print-elm input-date" size="sm" placeholder="" v-model="formFields.order_form.first_death_date"
                                                   @input="formFields.order_form.first_death_date = checkDate(formFields.order_form.first_death_date)"
                                                   today-button
                                                   reset-button
                                                   close-button
                                                   locale="en">
                                </b-form-datepicker>
                            </div>
                        </div>
                        <div class="order-form-row">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">2nd Name (Companion Stone):</label>
<!--                                <label class="print-elm print-elm-label">{{formFields.order_form.second_name}}</label>-->
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.second_name"></b-form-input>
                            </div>
                        </div>
                        <div class="order-form-row">
                            <div>
                                <label class="font-weight-bold col-6 my-auto px-0">Birth Date:</label>
                                <span class="ml-n5 mr-2 print-elm"></span>
                                <label class="print-elm print-elm-label">{{ changeDateFormat(formFields.order_form.second_birth_date) }}</label>
                                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="non-print-elm input-date" size="sm" placeholder="" v-model="formFields.order_form.second_birth_date"
                                                   @input="formFields.order_form.second_birth_date = checkDate(formFields.order_form.second_birth_date)"
                                                   today-button
                                                   reset-button
                                                   close-button
                                                   locale="en">
                                </b-form-datepicker>
                            </div>
                            <div>
                                <label class="font-weight-bold col-3">Death Date:</label>
                                <label class="print-elm print-elm-label mr-2">{{ changeDateFormat(formFields.order_form.second_death_date) }}</label>
                                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="non-print-elm input-date" size="sm" placeholder="" v-model="formFields.order_form.second_death_date"
                                                   @input="formFields.order_form.second_death_date = checkDate(formFields.order_form.second_death_date)"
                                                   today-button
                                                   reset-button
                                                   close-button
                                                   locale="en">
                                </b-form-datepicker>
                            </div>
                        </div>
                        <div class="order-form-row">
                            <div>
                                <label class="font-weight-bold col-3 m-0 px-0">Marriage Date</label>
                                <span class="ml-n5 mr-2 print-elm"></span>
                                <label class="print-elm print-elm-label">{{ changeDateFormat(formFields.order_form.marriage_date) }}</label>
                                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="non-print-elm input-date" size="sm" placeholder="" v-model="formFields.order_form.marriage_date"
                                                   @input="formFields.order_form.marriage_date = checkDate(formFields.order_form.marriage_date)"
                                                   today-button
                                                   reset-button
                                                   close-button
                                                   locale="en">
                                </b-form-datepicker>
                            </div>
                        </div>
                        <div class="order-form-row">
                            <div>
                                <label class="font-weight-bold col-6 m-0 px-0">Cemetery:</label>
                                <span class="ml-n5 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.cemetery"></b-form-input>
                            </div>
                            <div>
                                <label class="font-weight-bold col-4">City, State, Zip</label>
                                <span class="ml-n5 mr-2 print-elm"></span>
                                <b-form-input type="text" size="sm" v-model="formFields.order_form.cemetery_city_state_zip"></b-form-input>
                            </div>
                        </div>

                        <hr class="border my-3">

                        <div class="order-form-row" style="page-break-before: always">
                            <div class="col-7 d-block pl-0">

                                <div class="order-form-row">
                                    <div>
                                        <label class="font-weight-bold col-3 m-0 px-0">Price:</label>
                                        <label class="col-1"></label>
                                        <span class="ml-n5 print-elm"></span>
                                        <b-form-input type="text" size="sm" v-model="formFields.order_form.price"></b-form-input>
                                    </div>
                                </div>
                                <div class="order-form-row">
                                    <div>
                                        <label class="font-weight-bold col-3 m-0 px-0">Engraving:</label>
                                        <label class="col-1"></label>
                                        <span class="ml-n5 print-elm"></span>
                                        <b-form-input type="text" size="sm" v-model="formFields.order_form.engraving"></b-form-input>
                                    </div>
                                </div>
                                <div class="order-form-row">
                                    <div>
                                        <label class="font-weight-bold col-3 m-0 px-0">Back:</label>
                                        <label class="col-1"></label>
                                        <span class="ml-n5 print-elm"></span>
                                        <b-form-input type="text" size="sm" v-model="formFields.order_form.back"></b-form-input>
                                    </div>
                                </div>
                                <div class="order-form-row">
                                    <div>
                                        <label class="font-weight-bold col-3 m-0 px-0">Adt. Lattering:</label>
                                        <label class="col-1"></label>
                                        <span class="ml-n5 print-elm"></span>
                                        <b-form-input type="text" size="sm" v-model="formFields.order_form.adt_lattering"></b-form-input>
                                    </div>
                                </div>
                                <div class="order-form-row">
                                    <div>
                                        <label class="font-weight-bold col-3 m-0 px-0">Laser Etching:</label>
                                        <label class="col-1"></label>
                                        <span class="ml-n5 print-elm"></span>
                                        <b-form-input type="text" size="sm" v-model="formFields.order_form.laser_etching"></b-form-input>
                                    </div>
                                </div>
                                <div class="order-form-row">
                                    <div>
                                        <label class="font-weight-bold col-3 m-0 px-0">Apron:</label>
                                        <label class="col-1"></label>
                                        <span class="ml-n5 print-elm"></span>
                                        <b-form-input type="text" size="sm" v-model="formFields.order_form.apron"></b-form-input>
                                    </div>
                                </div>
                                <div class="order-form-row">
                                    <div>
                                        <label class="font-weight-bold col-3 m-0 px-0">Other:</label>
                                        <label class="col-1"></label>
                                        <span class="ml-n5 print-elm"></span>
                                        <b-form-input type="text" size="sm" v-model="formFields.order_form.other"></b-form-input>
                                    </div>
                                </div>
                                <div class="order-form-row">
                                    <div>
                                        <label class="font-weight-bold col-3 m-0 px-0">Vases:</label>
                                        <label class="col-1"></label>
                                        <span class="ml-n5 print-elm"></span>
                                        <b-form-input type="text" size="sm" v-model="formFields.order_form.vases"></b-form-input>
                                    </div>
                                </div>
                                <div class="order-form-row">
                                    <div>
                                        <label class="font-weight-bold col-3 m-0 px-0">Setting:</label>
                                        <label class="col-1"></label>
                                        <span class="ml-n5 print-elm"></span>
                                        <b-form-input type="text" size="sm" v-model="formFields.order_form.setting"></b-form-input>
                                    </div>
                                </div>
                                <div class="order-form-row">
                                    <div>
                                        <label class="font-weight-bold col-3 m-0 px-0">Freight:</label>
                                        <label class="col-1"></label>
                                        <span class="ml-n5 print-elm"></span>
                                        <b-form-input type="text" size="sm" v-model="formFields.order_form.freight"></b-form-input>
                                    </div>
                                </div>
                                <div class="order-form-row">
                                    <div>
                                        <label class="font-weight-bold col-3 m-0 px-0">Total $:</label>
                                        <label class="col-1"></label>
                                        <span class="ml-n5 print-elm"></span>
                                        <b-form-input type="text" size="sm" v-model="formFields.order_form.total"></b-form-input>
                                    </div>
                                </div>

                            </div>

                            <div class="border rounded"></div>
                        </div>

                        <hr class="border my-3">

                        <div class="order-form-row">
                            <div>
                                <label class="non-print-elm font-weight-bold">Notes:</label>
                                <label class="print-elm font-weight-bold" style="margin-top: 0rem !important;">Notes:</label>
                                <b-form-textarea
                                    class="ml-2 py-0"
                                    size="sm"
                                    v-model="formFields.order_form.notes"
                                    no-resize
                                ></b-form-textarea>
                            </div>
                        </div>

                        <div class="order-form-row non-print-elm">
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
import {saveRecord} from "../../../../helpers/axios";
import {event, eventBus} from "../../../../event-bus/event-bus";
import {searchForEmptyDate} from "../../../../helpers/common";

export default {
    name: "Content",
    props: ['formFields'],
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
    data(){
        return {
            axiosParams:{module: 'order/form'},
            axiosParamsOrder: {module: 'order'},
            alertMessage:'',
            hideAlert:true,
            successResponse: false,
            errorResponse: false,
            saveDisabled:false,
        }
    },
    methods:{
        save(){
            let currentId = this.formFields.id
            this.saveDisabled = true; //Disabling save button
            let data = this.formFields.order_form;
            let formData = new FormData();
            formData.append('data',JSON.stringify(data));

            saveRecord(this.axiosParams, formData, (response) => {
                if (response.data.errorInfo){
                    this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                    this.makeToast({title:'Error', message:this.alertMessage, variant:'danger'});
                    this.alertMessage = '';
                }
                else{
                    let status = this.formFields.order_form.id ? 'Updated': 'Added';
                    this.alertMessage = `Record Successfully ${status}`;
                    this.makeToast({title:'Success', message:this.alertMessage, variant:'success'});
                    this.alertMessage = '';
                    let record = Object.values(this.$store.state[this.axiosParamsOrder.module].recordList).find(obj => obj.id == currentId);
                    if (record != undefined) {
                        record.order_form.id = response.data.id
                    }
                }
            },(error) => {
                if (error.response.status == 403){
                    this.makeToast({title: 'Error', message: error.response.data.message , variant: 'danger', duration: 3000});
                }
            })
        },
        changeDateFormat: function(value){
            return this.$store.getters.changeDateFormat(value);
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
    }

}
</script>

<style scoped>
.form-content{
    margin: 0 auto;
    width: 45rem;
}
.order-form-row
{
    display: flex;
    padding: 0;
}
.order-form-row div
{
    display: flex;
    margin: 0.3rem 0;
    width: 100%;
}
.order-form-row div label{
    margin: auto 0 !important;
    white-space: nowrap !important;
}
.order-form-row div input,.input-date{
    border: 1px solid #c4c4c4;
    margin: auto;
    margin-right: 0;
    font-size: 0.75rem !important;
    height: 1.5rem;
}
textarea{
    border: 1px solid #c4c4c4;
    font-size: 0.75rem !important;
}
header{
    padding: 0 3rem;
}
.print-elm-label{
    font-size: 0.75rem !important;
}
.input-xl{
    width: 20rem;
}
.input-lg{
    width: 12rem;
}
.input-md{
    width: 6rem;
}
.input-sm{
    width: 4rem;
}

.input-date{
    font-size: .6rem;
}

/*.print-elm{
    display: none;
}
.printing .form-content{
    width: 100%;
}
.printing label, .printing input, .printing textarea{
    font-size: 1.3rem;
}
.printing h5, .printing h3{
    font-size: 2rem;
}
.printing input, .printing textarea{
    border-color: transparent !important;
    background: transparent !important;
    pointer-events: none;
    height: auto !important;
}
.printing .non-print-elm{
    display: none !important;
}
.printing .print-elm{
    display: block !important;
}*/
</style>
