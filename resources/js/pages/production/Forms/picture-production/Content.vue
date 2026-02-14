<template>

    <div>
        <form class="div-shadow bg-white rounded mx-2 mb-2 p-3">

            <div class="form-content">

                <div class="porcelain-production-row my-2">
                    <div class="col-2 d-block border pb-4">
                        <h5 class="my-auto p-0 week-label py-2">Week of:</h5>
                        <label class="print-elm text-center">{{formFields.week_of}}</label>
                        <b-form-input type="text" class="non-print-elm" size="sm" :disabled="hideInModal" v-model="formFields.week_of"></b-form-input>
                    </div>
                </div>
                <div class="porcelain-production-row">
                    <div>
                        <b-table  bordered class="memorial-table-border"
                                  :items="inPDF ? pictureList.slice(0, pictureList.length -1) : pictureList"
                                  :fields="fields">
                            <template #head()="data">
                                <div class="my-n1 justify-content-center">
                                    <label class="header-label">{{ data.label }}</label>
                                </div>
                            </template>

                            <template #cell(invoice_no)="row">

                                <b-dropdown no-caret class="border rounded m-0 non-print-elm dropdown-style mt-1" size="sm" variant="none" :disabled="hideInModal">

                                    <template #button-content>
                                        <div class="d-flex m-0">
                                            <small>{{ row.item.order ? (row.item.order.invoice ? row.item.order.invoice.invoice_number : '') : 'Select' }}</small>
                                            <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                                        </div>
                                    </template>

                                    <b-dropdown-group class="overflow-auto scroll px-1">
                                        <template v-for="obj of orders" >
                                            <b-dropdown-group @click="handleDropdownChange">
                                                <b-dropdown-item-button class="small" @click="row.item.order_id = obj.id, $set(row.item, 'order', obj)">
                                                    {{ obj.invoice.invoice_number }}
                                                </b-dropdown-item-button>
                                            </b-dropdown-group>
                                        </template>
                                    </b-dropdown-group>

                                </b-dropdown>
                                <label class="print-elm">{{ row.item.order ? (row.item.order.invoice ?
                                    row.item.order.invoice.invoice_number : '') : 'Select' }}</label>
                            </template>

                            <template v-slot:cell(last_name)="row">
                                <label>{{row.item.order ? (row.item.order.family ? row.item.order.family.name_on_stone : '') : ''}}</label>
                            </template>

                            <template v-slot:cell(size_of_photo)="row">
                                <div class="d-flex justify-content-center">
                                    <b-form-input type="text" min="0" class="input-md ml-0" :disabled="hideInModal" size="sm" v-model="row.item.size_of_photo"></b-form-input>
                                </div>
                            </template>

                            <template v-slot:cell(complete)="row">
                                <div class="d-flex justify-content-center">
                                    <b-form-input type="text" min="0" class="input-md ml-0" :disabled="hideInModal" size="sm" v-model="row.item.complete"></b-form-input>
                                </div>
                            </template>

                            <template v-slot:cell(date)="row">
                                <b-form-datepicker :disabled="hideInModal"
                                                   :date-format-options="{ year: '2-digit', month: 'numeric', day: 'numeric' }"
                                                   @input="row.item.date = checkDate(row.item.date)"
                                                   class="mt-1 border input-date non-print-elm"
                                                   size="sm" name="date" placeholder=""
                                                   v-model="row.item.date"
                                                   today-button
                                                   reset-button
                                                   close-button
                                                   locale="en">
                                </b-form-datepicker>
                                <label class="print-elm">{{ changeDateFormat(row.item.date) }}</label>
                            </template>

                            <template v-slot:cell(initials)="row">
                                <div class="d-flex justify-content-center">
                                    <b-form-input type="text" min="0" class="input-md ml-0" :disabled="hideInModal" size="sm" v-model="row.item.initials"></b-form-input>
                                </div>
                            </template>

                        </b-table>
                    </div>
                </div>

                <div v-if="!hideInModal" class="porcelain-production-row non-print-elm">
                    <div>
                        <button type="button" class="btn-info mx-1 px-2 w-auto custom-infobtn-toolbar custom-infobtn-text" @click="printPDF">
                            Print Preview
                        </button>
                        <button  v-if="formFields.id ? isUpdatePermitted : isCreatePermitted"  type="button" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                            {{ formFields.id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                        </button>
                        <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" to="/picture-production-list">Back To List</router-link>
                    </div>

                </div>

            </div>

        </form>
    </div>

</template>

<script>

    import {fetchRecord} from "../../../../helpers/axios";
    import {event, eventBus} from "../../../../event-bus/event-bus";
    import {searchForEmptyDate} from "../../../../helpers/common";

    export default {
        name: "Content",
        props: ['formFields', 'inPDF', 'hideInModal','saveDisabled'],
        data() {
            return {
                axiosParams: {module: 'productionPicture'},
                fields: [
                    {
                        key: 'invoice_no',
                        label: 'Invoice No.',
                    },
                    {
                        key: 'last_name',
                        label: 'Last Name',
                    },
                    {
                        key: 'size_of_photo',
                        label: 'Size of Photo',
                    },
                    {
                        key: 'complete',
                        label: 'Complete',
                    },
                    {
                        key: 'date',
                        label: 'Date',
                    },
                    {
                        key: 'initials',
                        label: 'Initials',
                    }
                ],
            }
        },
        computed:{
            pictureList(){
                if(this.formFields.picture_list.length == 0 || !this.hasNewRow)
                    this.addRow()
                return this.formFields.picture_list;
            },
            isUpdatePermitted(){
                return this.$store.getters.isPermitted({resource:'Production',action:'update'});
            },
            isCreatePermitted(){
                return this.$store.getters.isPermitted({resource:'Production',action:'create'});
            },
            orders(){
              return this.$store.state.order.recordList;
            },
            hasNewRow(){
                for (let item of this.formFields.picture_list){
                    if (item.id == 0)
                    return true
                }
                return false;
            },
        },
        mounted() {
            this.$store.getters.detectFormChanges();
        },
        methods: {
            getRecord: function(id){

                if (id){
                    let record = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == id);
                    if (record != undefined){
                        this.formFields = {...record};
                    }
                    else{
                        this.axiosParams.id = id;
                        fetchRecord(this.axiosParams, (response) => {
                            this.formFields = response.data;
                        })
                    }
                }
            },
            addRow(){
                if (!this.inPDF)
                    this.formFields.picture_list.push({id:0})
            },
            save:function(){
                eventBus.$emit(event.SAVE_PRODUCTION_PICTURE);
            },
            handleDropdownChange: function(value){
                window.detectChanges = true;
            },

            /** Generic*/
            printPDF() {
                eventBus.$emit(event.PRINT_PDF)
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
        width: 58rem;
    }
    .header-label{
        font-family: Roboto;
        font-style: normal;
        font-weight: normal;
        font-size: 12px;
        line-height: 14px;
        text-align: center;
        letter-spacing: 0.02em;
        color:#000;
    }
    .week-label{
        font-family: Roboto;
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 16px;
        text-align: center;
        letter-spacing: 0.02em;
        color:#000;
    }

    .porcelain-production-row {
        display: flex;
        padding: 0;
    }

    .porcelain-production-row div {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }

    .porcelain-production-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
        color:#000 !important;
    }

    .porcelain-production-row div input {
        border: 1px solid #c4c4c4;
        margin: auto;
        margin-right: 0;
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
        font-size: .6rem;
    }

    .border {
        border: 1px solid #c4c4c4 !important;
    }
    .printing .border {
        border: 1px solid #000 !important;
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
