<template>
    <div>
        <div class="row">
            <div class="col-md-12">

                <form class="bg-white rounded mx-2 mb-2 p-3" :class="inPDF ? 'pdf-fields' : '' ">

                    <div class="form-content">

                        <div class="custom-row border rounded my-2">

                            <div  class="d-block custom-border-right px-1 pt-1 my-0">
                                <label class="font-weight-bold custom-font-size-label " :class="inPDF ? 'pdf-labels': '' ">Date:</label><br>
                                <b-form-datepicker :disabled="hideInModal" @input="setNewDayName(formFields.date)" :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                class="px-1 input-date non-print-elm" :class="inPDF ? 'pdf-fields' : '' " size="sm" placeholder="" v-model="formFields.date"

                                today-button
                                reset-button
                                close-button
                                locale="en">

                                </b-form-datepicker>
                                <label class="print-elm" :class="inPDF ? 'pdf-labels' : '' ">{{formFields.date}}</label>
                            </div>
                            <div class="d-block custom-border-right px-1 pt-1 my-0">
                                <label class="font-weight-bold custom-font-size-label" :class="inPDF ? 'pdf-labels' : '' ">Day:</label><br>
<!--                               <label class="pdf-labels">{{formFields.dayName}}</label>-->
                               <label class="" :class="inPDF ? 'pdf-labels': '' ">{{ getDayName(formFields.date)  }}</label>
                            </div>
                            <div class="d-block custom-border-right px-1 pt-1 my-0">
                                <label class="font-weight-bold custom-font-size-label" :class="inPDF ? 'pdf-labels' : '' ">Person Requesting</label><br>
                                <b-form-input :disabled="hideInModal" type="text" size="sm" class="my-1" :class="inPDF ? 'pdf-fields' : '' " v-model="formFields.person_requesting"></b-form-input>
                            </div>
                            <div class="d-block px-1 pt-1 my-0">
                                <label class="font-weight-bold custom-font-size-label" :class="inPDF ? 'pdf-labels' : '' ">Work Order #</label><br>
                              <label class="" :class="inPDF ? 'pdf-labels' : '' ">{{formFields.id}}</label>
                            </div>
                        </div>

                        <div class="custom-row col-6 margin-left-alignment">
                            <div>
                                <label class="font-weight-bold" :class="inPDF ? 'pdf-labels' : '' ">Equipment #:</label>
                                <b-form-input :disabled="hideInModal" type="text" class="form-control form-control-sm" :class="inPDF ? 'pdf-fields' : '' " size="sm" v-model="formFields.equipment"
                                              ></b-form-input>
                            </div>
                        </div>

                        <div class="custom-row">
                            <div class="col-5">
                                <label class="font-weight-bold label-contact ml-n3" :class="inPDF ? 'pdf-labels' : '' ">Location</label>
                                <b-form-input :disabled="hideInModal" type="text" class="form-control form-control-sm" :class="inPDF ? 'pdf-fields' : '' " size="sm" v-model="formFields.location"
                                ></b-form-input>
                            </div>

                            <div class="col-5">
                                <label class="font-weight-bold label-contact ml-3" :class="inPDF ? 'pdf-labels' : '' ">Dept.</label>
                                <b-form-input :disabled="hideInModal" type="text" class="form-control form-control-sm" :class="inPDF ? 'pdf-fields' : '' " size="sm" v-model="formFields.department"
                                ></b-form-input>
                            </div>
                        </div>

                        <div class="custom-row">
                            <div class="col-12">
                                <label class="font-weight-bold ml-n3" :class="inPDF ? 'pdf-labels' : '' ">Type of Repair:</label>
                                <b-form-input
                                    :disabled="hideInModal"
                                    class=""
                                    :class="inPDF ? 'pdf-fields' : '' "
                                    size="sm"
                                    v-model="formFields.type_of_repair"
                                ></b-form-input>
                            </div>
                        </div>

                        <div class="custom-row">
                            <div class="col-12">
                                <label class="font-weight-bold ml-n3" :class="inPDF ? 'pdf-labels' : '' ">Urgency</label>
                                <b-form-input
                                    :disabled="hideInModal"
                                    class="custom-input-margin-left"
                                    :class="inPDF ? 'pdf-fields' : '' "
                                    size="sm"
                                    v-model="formFields.urgency"
                                ></b-form-input>
                            </div>
                        </div>

                        <div class="custom-row">
                            <div class="col-12">
                                <label class="font-weight-bold ml-n3 custom-margin-top-description" :class="inPDF ? 'pdf-labels' : '' ">Description of <br>the Problem:</label>
                                <b-form-textarea
                                    :disabled="hideInModal"
                                    class="custom-textarea-margin-left"
                                    :class="inPDF ? 'pdf-fields' : '' "
                                    size="sm"
                                    :rows="inPDF ? 6 : 3"
                                    v-model="formFields.description_of_problem"
                                    no-resize
                                ></b-form-textarea>
                            </div>
                        </div>

                        <div class="custom-row">
                            <div class="col-5">
                                <label class="font-weight-bold label-contact ml-n3" :class="inPDF ? 'pdf-labels' : '' ">Person assigned</label>
                                <b-form-input :disabled="hideInModal" type="text" :class="inPDF ? 'pdf-fields' : '' " class="form-control form-control-sm custom-input-margin-right" size="sm" v-model="formFields.person_assigned"
                                ></b-form-input>
                            </div>

                            <div class="col-5">
                                <label class="font-weight-bold label-contact ml-3" :class="inPDF ? 'pdf-labels' : '' ">Date to perform w.o.</label>
                              <!--  <b-form-input :disabled="hideInModal" type="text" class="form-control form-control-sm" size="sm" v-model="formFields.perform_work_order"
                                ></b-form-input>-->
                                <b-form-datepicker :date-format-options="{ year : 'numeric', month: 'numeric', day : 'numeric' }"
                                :disabled="hideInModal" class="px-1 ml-2 input-date non-print-elm" :class="inPDF ? 'pdf-fields' : '' " size="sm"
                                placeholder="" v-model="formFields.perform_work_order" @input="formFields.perform_work_order = checkDate(formFields.perform_work_order)"
                                today-button
                                reset-button
                                close-button
                                locale="en">

                                </b-form-datepicker>
                                <label class="print-elm" :class="inPDF ? 'pdf-labels' : '' ">{{formFields.perform_work_order}}</label>
                            </div>
                        </div>

                        <div class="custom-row col-5 margin-left-alignment">
                            <div>
                                <label class="font-weight-bold" :class="inPDF ? 'pdf-labels' : '' "> Estimated man hours</label>
                                <b-form-input :disabled="hideInModal" type="text" class="form-control form-control-sm" :class="inPDF ? 'pdf-fields' : '' " size="sm" v-model="formFields.estimated_man_hours"
                                ></b-form-input>
                            </div>
                        </div>

                        <div class="custom-row col-5 margin-left-alignment">
                            <div>
                                <label class="font-weight-bold" :class="inPDF ? 'pdf-labels' : '' "> Actual man hours </label>
                                <b-form-input :disabled="hideInModal" type="text" class="form-control form-control-sm" :class="inPDF ? 'pdf-fields' : '' " size="sm" v-model="formFields.actual_man_hours"
                                ></b-form-input>
                            </div>
                        </div>

                        <div class="custom-row col-5 margin-left-alignment">
                            <div>
                                <label class="font-weight-bold" :class="inPDF ? 'pdf-labels' : '' ">Date w.o. completed</label>
<!--                                <b-form-input :disabled="hideInModal" type="text" class="form-control form-control-sm" size="sm" v-model="formFields.work_order_completed"-->
<!--                                ></b-form-input>-->
                                <b-form-datepicker :date-format-options="{ year : 'numeric', month : 'numeric', day : 'numeric' }"
                                       @input="formFields.work_order_completed = checkDate(formFields.work_order_completed)"  :disabled="hideInModal" class="px-1 ml-2 input-date non-print-elm" :class="inPDF ? 'pdf-fields' : '' " size="sm" placeholder="" v-model="formFields.work_order_completed"
                                today-button
                                reset-button
                                close-button
                                locale="en">

                                </b-form-datepicker>
                                <label class="print-elm" :class="inPDF ? 'pdf-labels' : '' ">{{formFields.work_order_completed}}</label>
                            </div>
                        </div>

                        <div class="custom-row non-print-elm">

                            <div v-if="!hideInModal">
                                <button type="button" class="btn-info px-2 w-auto custom-infobtn-toolbar custom-infobtn-text"
                                        @click="printPDF">Print Preview
                                </button>
                                <button  v-if="formFields.id ? isUpdatePermitted : isCreatePermitted"  type="button" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                                    {{ formFields.id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                                </button>
                                <router-link v-if="!hideInModal" class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" to="/maintenance-work-order-list">Back To List</router-link>
                            </div>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

</template>

<script>
    import Toolbar from "./Toolbar";
    import {fetchRecord, deleteRecord} from "../../../helpers/axios";
    import {searchForEmptyDate} from "../../../helpers/common";
    import {event, eventBus} from "../../../event-bus/event-bus";

    export default {
        name: "Content",
        props: ['formFields', 'inPDF', 'hideInModal','saveDisabled'],
        computed: {
            alertClasses: function () {
                return {
                    alert: true,
                    'alert-success': this.successResponse,
                    'alert-danger': this.errorResponse,
                    'd-none': this.hideAlert
                }
            },
            isUpdatePermitted(){
                return this.$store.getters.isPermitted({resource:'Maintenance',action:'update'});
            },
            isCreatePermitted(){
                return this.$store.getters.isPermitted({resource:'Maintenance',action:'create'});
            },

            WorkOrderList() {
                if (this.formFields.workOrder_list.length == 0 || !this.hasNewRow)
                    this.addRow()
                return this.formFields.workOrder_list;
            },
          /*  orders() {
                return this.$store.state.order.recordList;
            },*/
            hasNewRow() {
                for (let item of this.formFields.workOrder_list) {
                    if (item.id == 0)
                        return true
                }
                return false;
            },
        },
        data() {
            return {
                axiosParams: {module: 'maintenanceWorkOrder'},
                alertMessage:'',
                hideAlert:true,
                successResponse: false,
                errorResponse: false,
                fields: [],
            }
        },
        components: {
            Toolbar
        },
        mounted() {
            this.$store.getters.detectFormChanges();
        },
        methods: {
            getRecord: function (id) {

                if (id) {
                    let record = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == id);
                    if (record != undefined) {
                        this.formFields = {...record};
                    } else {
                        this.axiosParams.id = id;
                        fetchRecord(this.axiosParams, (response) => {
                            this.formFields = response.data;
                        })
                    }
                }
            },
            getDayName : function(currentDate){
                if (currentDate){
                    const dayOfWeek = new Date(currentDate).getDay();
                    return isNaN(dayOfWeek) ? null :
                        ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
                }

            },
            setNewDayName : function(currentDate){
                if (currentDate == '')
                  return  this.formFields.date = null;
                const dayOfWeek = new Date(currentDate).getDay();
                this.formFields.dayName = isNaN(dayOfWeek) ? null :
                    ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
            },
            addRow() {
                if (!this.inPDF)
                    this.formFields.workOrder_list.push({id: 0})
            },
            save: function () {
                eventBus.$emit(event.SAVE_WORK_ORDER);
            },

            /** Generic*/
            printPDF() {
                eventBus.$emit(event.PRINT_PDF)
            },
            checkDate: function(date){
               return searchForEmptyDate(date);
            },

        }
    }
</script>

<style scoped>
    .form-content {
        margin: 0 auto;
        width: 58rem;
    }

    .header-label {
        font-family: Roboto;
        font-style: normal;
        font-weight: normal;
        font-size: 12px;
        line-height: 14px;
        text-align: center;
        letter-spacing: 0.02em;
        color: #000;
    }

    .week-label {
        font-family: Roboto;
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 16px;
        text-align: center;
        letter-spacing: 0.02em;
        color: #000;
    }

    .custom-row {
        display: flex;
        padding: 0;
    }

    .custom-row div {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }

    .custom-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
        color: #000 !important;
    }

    .custom-row div  input {
        border: 1px solid #c4c4c4;
        margin: auto;
        margin-right: 0;
        height: 1.5rem;
        font-size: 12px;
    }
    .custom-row div textarea{
        margin: auto;
        font-size: 12px;
        border: 1px solid #c4c4c4;
    }
   .b-form-datepicker {
        border: 1px solid #c4c4c4;
    }

    .input-style{
        height: 1.5rem;
        font-size: 12px;
    }
    .dropdown-style{
        font-size: 12px;
        border: 1px solid #c4c4c4 !important;
    }

    header {
        padding: 0 3rem;
    }

    .input-xl {
        width: 12rem;
    }

    .input-lg {
        width: 10rem;
    }

    .input-md {
        width: 8rem;
    }

    .input-sm {
        width: 6rem;
    }

    .input-xs {
        width: 4rem;
    }

    .input-date {
        font-size: .65rem;
    }


    element.style {
    }
    .porcelain-production-row div[data-v-aa69c822] {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }
    .pb-4, .py-4 {
        padding-bottom: 1.5rem !important;
    }
    .d-block {
        display: block !important;
    }
    .border {
        border: 1px solid #c4c4c4 !important;
    }
    .printing .border {
        border: 1px solid #000 !important;
    }
.margin-left-alignment{
    margin-left: -7px !important;
}
    .custom-font-size-label{
        font-size: 14px !important;
    }
    .custom-input-margin-left{
        margin-left: 37px !important;
    }
    .custom-textarea-margin-left{
        margin-left: 5px !important;
    }
    .custom-input-margin-right{
        margin-right: -6px !important;
    }
.custom-margin-top-description{
    margin-top: 4px !important;
}


/*    for generating pdf*/
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
        border: 2px solid #dee2e6;
    }

    .pdf label{
        display: block;
        font-size: 0.5em;
        margin-bottom: 0;
    }

</style>
