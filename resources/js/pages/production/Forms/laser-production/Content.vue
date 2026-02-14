<template>

    <div>
        <form class="div-shadow bg-white rounded mx-2 mb-2 p-3">

            <div class="form-content">

                <div class="custom-row my-2">
                    <div class="col-2 d-block border pb-4">
                        <h5 class="my-auto p-0 week-label py-2">Week of:</h5>
                        <label class="print-elm text-center">{{formFields.week_of}}</label>
                        <b-form-input type="text" class="non-print-elm" size="sm" :disabled="hideInModal"
                                      v-model="formFields.week_of"></b-form-input>
                    </div>
                </div>
                <div class="custom-row">
                    <b-table bordered class="memorial-table-border"
                             :items="inPDF ? LaserList.slice(0, LaserList.length - 1) : LaserList"
                             :fields="fields">

                        <template #head()="data">
                            <div class="my-n1 justify-content-center">
                                <label class="header-label">{{ data.label }}</label>
                            </div>
                        </template>

                        <template class="non-print-elm" v-slot:cell(invoice_no)="row">

                            <b-dropdown no-caret class="border rounded m-0 non-print-elm dropdown-style mt-1" size="sm" variant="none"
                                        :disabled="hideInModal">

                                <template #button-content>
                                    <div class="d-flex m-0">
                                        <small>{{ row.item.order ? (row.item.order.invoice ?
                                            row.item.order.invoice.invoice_number : '') : 'Select' }}
                                        </small>
                                        <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                                    </div>
                                </template>

                                <b-dropdown-group class="overflow-auto scroll px-1">
                                    <template v-for="obj of orders">
                                        <b-dropdown-group  @click="handleDropdownChange">
                                            <b-dropdown-item-button class="small"
                                                                    @click="row.item.order_id = obj.id, $set(row.item, 'order', obj)">
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
                            <label>{{row.item.order ? (row.item.order.family ? row.item.order.family.name_on_stone : '')
                                : ''}}</label>
                        </template>

                        <template v-slot:cell(size_of_die)="row">
                            <div class="d-flex justify-content-center">
                                <b-form-input type="text" min="0" class="input-md input-style ml-0" :disabled="hideInModal" size="sm"
                                          v-model="row.item.size_of_die"></b-form-input>
                            </div>
                        </template>

                        <template v-slot:cell(total_sq_ft)="row">
                            <div class="d-flex justify-content-center">
                                <b-form-input type="text" min="0" class="input-md input-style ml-0" :disabled="hideInModal" size="sm"
                                          v-model="row.item.total_sq_ft"></b-form-input>
                            </div>
                        </template>

                        <template v-slot:cell(date)="row">
                            <b-form-datepicker :disabled="hideInModal"
                                               :date-format-options="{ year: '2-digit', month: 'numeric', day: 'numeric' }"
                                               class="mt-1 border input-date non-print-elm"
                                               size="sm" name="date" placeholder=""
                                               @input="row.item.date = checkDate(row.item.date)"
                                               v-model="row.item.date"
                                               today-button
                                               reset-button
                                               close-button
                                               locale="en">
                            </b-form-datepicker>
                            <label class="print-elm">{{row.item.date}}</label>
                        </template>

                        <template v-slot:cell(initials)="row">
                            <div class="d-flex justify-content-center">
                                <b-form-input type="text" min="0" class="input-md input-style ml-0" :disabled="hideInModal" size="sm"
                                          v-model="row.item.initials"></b-form-input>
                            </div>
                        </template>

                    </b-table>
                </div>
                <div class="d-block text-center" style="font-family: Roboto;">
                    <label class="d-block m-0">To Convert Sq. Inches to Sq.Ft.</label>
                    <label class="d-block m-0">Length (x) Width, Divided by 144 (24x12 = 288/144 = 2)</label>
                </div>

                <div class="custom-row">
                    <div class="col-5 p-0 flex-column">
                        <h6 class="font-weight-bold">GRASSER</h6>
                        <label class="ml-0">16x8 = 0.88 sq.ft.</label>
                        <label class="ml-0">20x10 = 1.4</label>
                        <label class="ml-0">24x12 = 2</label>
                        <label class="ml-0">36x12 = 3</label>
                        <label class="ml-0">36x14 = 3.5</label>
                    </div>
                    <div class="col-5 p-0 flex-column mx-4">
                        <h6 class="font-weight-bold">SLANTS</h6>
                        <label class="ml-0">16x12 = 1.33 sq.ft.</label>
                        <label class="ml-0">20x16 = 2.2</label>
                        <label class="ml-0">24x16 = 2.6</label>
                        <label class="ml-0">36x16 = 4</label>
                        <label class="ml-0">42x16 = 4.7</label>
                    </div>
                    <div class="col-2 p-0 flex-column">
                        <h6 class="font-weight-bold">DIES</h6>
                        <label class="ml-0">14x18 = 1.75 sq.ft.</label>
                        <label class="ml-0">24x18 = 3</label>
                        <label class="ml-0">36x20 = 5</label>
                        <label class="ml-0">42x22 = 6.41</label>
                        <label class="ml-0">48x24 = 8</label>
                    </div>
                </div>

                <div v-if="!hideInModal" class="custom-row non-print-elm">
                    <div>
                        <button type="button" class="btn-info px-2 w-auto custom-infobtn-toolbar custom-infobtn-text"
                                @click="printPDF">Print Preview
                        </button>
                        <button  v-if="formFields.id ? isUpdatePermitted : isCreatePermitted" type="button" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                            {{ formFields.id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                        </button>
                        <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" to="/laser-production-list">Back To List</router-link>
                    </div>

                </div>

            </div>
        </form>
    </div>

</template>

<script>
    import Toolbar from "./Toolbar";
    import {fetchRecord, deleteRecord} from "../../../../helpers/axios";
    import {event, eventBus} from "../../../../event-bus/event-bus";
    import {searchForEmptyDate} from "../../../../helpers/common";

    export default {
        name: "Content",
        props: ['formFields', 'inPDF', 'hideInModal','saveDisabled'],
        computed: {
            LaserList() {
                if (this.formFields.laser_list.length == 0 || !this.hasNewRow)
                    this.addRow()
                return this.formFields.laser_list;
            },
            isUpdatePermitted(){
                return this.$store.getters.isPermitted({resource:'Production',action:'update'});
            },
            isCreatePermitted(){
                return this.$store.getters.isPermitted({resource:'Production',action:'create'});
            },
            orders() {
                return this.$store.state.order.recordList;
            },
            hasNewRow() {
                for (let item of this.formFields.laser_list) {
                    if (item.id == 0)
                        return true
                }
                return false;
            },
        },
        data() {
            return {
                axiosParams: {module: 'productionLaser'},
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
                        key: 'size_of_die',
                        label: 'Size of Die (in)',
                    },
                    {
                        key: 'total_sq_ft',
                        label: 'Total Sq.ft',
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
        components: {
            Toolbar
        },
        mounted() {
            this.$store.getters.detectFormChanges();
        },
        methods: {
            getRecord: function (id) {

                if (id) {
                    /*let record = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == id);
                    if (record != undefined) {
                        this.formFields = {...record};
                    } else {*/
                        this.axiosParams.id = id;
                        fetchRecord(this.axiosParams, (response) => {
                            this.formFields = response.data;
                        })
                    // }
                }
            },
            handleDropdownChange: function(value){
                window.detectChanges = true;
            },
            addRow() {
                if (!this.inPDF)
                    this.formFields.laser_list.push({id: 0})
            },
            save: function () {
                eventBus.$emit(event.SAVE_PRODUCTION_LASER);
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

</style>
