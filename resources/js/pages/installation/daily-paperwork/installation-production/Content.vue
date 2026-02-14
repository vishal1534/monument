<template>

    <div>

        <form class="div-shadow bg-white rounded mx-2 mb-2 p-3">

            <div class="form-content">

                <div class="custom-row border rounded">

                    <div class="d-block border-right px-1 m-0">
                        <label class="font-weight-bold">Date:</label>
                        <label class="d-block my-1">{{ changeDateFormat(formFields.date)}}</label>
                    </div>
                 <!--   <div class="d-block border-right px-1 m-0">
                        <label class="font-weight-bold">Day:</label>
                        <label class="d-block my-1">{{getDayOfWeek(formFields.date)}}</label>
                    </div>-->
                    <div class="d-block border-right px-1 m-0">
                        <label class="font-weight-bold">Week of:</label>
                        <b-form-input type="text" class="my-1 mx-0" :disabled="hideInModal" size="sm"
                                      v-model="formFields.week_of"></b-form-input>
                    </div>
                    <div class="d-block px-1 m-0">
                        <label class="font-weight-bold">Name of Installer:</label>
                        <b-form-input type="text" class="my-1 mx-0" :disabled="hideInModal" size="sm"
                                      v-model="formFields.name_of_installer"></b-form-input>
                    </div>
                </div>

                <div class="custom-row">
                    <div>
                        <b-table bordered class="memorial-table-border my-4"
                                 :items="inPDF ? installProductionList.slice(0,installProductionList.length - 1) : installProductionList"
                                 :fields="fields">

                            <template #head()="data">
                                <div class="my-n1 justify-content-center">
                                    <label class="header-label">{{ data.label }}</label>
                                </div>
                            </template>

                            <template #cell(invoice_no)="row">
                                <b-dropdown no-caret class="border rounded m-0 non-print-elm" size="sm" variant="none"
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
                                            <b-dropdown-group @click="handleDropdownChange">
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

                            <template #cell(last_name)="row">
                                <label>{{row.item.order ? (row.item.order.family ? row.item.order.family.name_on_stone :
                                    '') : ''}}</label>
                            </template>

                            <template #cell(size_of_base)="row">
                                <b-dropdown no-caret class="border rounded m-0 non-print-elm" size="sm" variant="none"
                                            :disabled="hideInModal">

                                    <template #button-content>
                                        <div class="d-flex m-0">
                                            <small>{{ row.item.size_of_base ? baseOptions.filter(obj => obj.value == row.item.size_of_base)[0].text : 'Select' }}
                                            </small>
                                            <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                                        </div>
                                    </template>

                                    <b-dropdown-group class="overflow-auto scroll px-1">
                                        <template v-for="obj of baseOptions">
                                            <b-dropdown-group @click="handleDropdownChange">
                                                <b-dropdown-item-button class="small" @click="row.item.size_of_base = obj.value">
                                                    {{ obj.text }}
                                                </b-dropdown-item-button>
                                            </b-dropdown-group>
                                        </template>
                                    </b-dropdown-group>

                                </b-dropdown>
                                <label class="print-elm text-center">{{findBaseOption(row.item.size_of_base) }}</label>
                            </template>

                            <template #cell(total_sq_ft)="row">
                                <b-form-input type="text" class="" :disabled="hideInModal" size="sm"
                                              v-model="row.item.total_sq_ft"></b-form-input>
                            </template>

                            <template #cell(date)="row">
                                <b-form-datepicker :disabled="hideInModal"
                                                   :date-format-options="{ year: '2-digit', month: 'numeric', day: 'numeric' }"
                                                   class="my-auto border input-date non-print-elm"
                                                   size="sm" name="date" placeholder=""
                                                   v-model="row.item.date"
                                                   @input="row.item.date = checkDate(row.item.date)"
                                                   today-button
                                                   reset-button
                                                   close-button
                                                   locale="en">
                                </b-form-datepicker>
                                <label class="print-elm">{{ changeDateFormat(row.item.date) }}</label>
                            </template>

                            <template #cell(initials)="row">
                                <b-form-input type="text" class="" :disabled="hideInModal" size="sm"
                                              v-model="row.item.initials"></b-form-input>
                            </template>

                        </b-table>
                    </div>
                </div>

                <div v-if="!hideInModal" class="custom-row non-print-elm">
                    <div>
                        <button type="button" class="btn-info px-2 w-auto custom-infobtn-toolbar custom-infobtn-text"
                                @click="printPDF">Print Preview
                        </button>

                            <button type="button" v-if="formFields.id ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                                {{ formFields.id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                            </button>

                        <router-link
                                class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text"
                                to="/installation-production-list">Back to List
                        </router-link>
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
        props: ['formFields', 'inPDF', 'hideInModal', 'saveDisabled'],
        computed: {
            installProductionList() {
                if (this.formFields.install_production_list.length == 0 || !this.hasNewRow)
                    this.addRow()

                return this.formFields.install_production_list;
            },
            isUpdatePermitted(){
                return this.$store.getters.isPermitted({resource:'Installation',action:'update'});
            },
            isCreatePermitted(){
                return this.$store.getters.isPermitted({resource:'Installation',action:'create'});
            },
            orders() {
                return this.$store.state.order.recordList;
            },
            hasNewRow() {
                for (let item of this.formFields.install_production_list) {
                    if (item.id == 0)
                        return true
                }
                return false;
            },
        },
        data() {
            return {
                axiosParams: {module: 'installationProduction'},
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
                        key: 'size_of_base',
                        label: 'Size of Base (inches)',
                    },
                    {
                        key: 'total_sq_ft',
                        label: 'Total sq.ft',
                    },
                    {
                        key: 'date',
                        label: 'Date',
                    },
                    {
                        key: 'initials',
                        label: 'Initials',
                    },
                ],
                baseOptions:[
                    {value:'20x10-1.3-Sq.Ft', text:'20x10 = 1.3 Sq.Ft'},
                    {value:'36x10-2.5-Sq.Ft', text:'36x10 = 2.5 Sq.Ft'},
                    {value:'36x12-3.0-Sq.Ft', text:'36x12 = 3.0 Sq.Ft'},
                    {value:'42x12-3.5-Sq.Ft', text:'42x12 = 3.5 Sq.Ft'},
                    {value:'48x12-4.0-Sq.Ft', text:'48x12 = 4.0 Sq.Ft'},
                    {value:'48x14-4.7-Sq.Ft', text:'48x14 = 4.7 Sq.Ft'},
                    {value:'54x12-4.5-Sq.Ft', text:'54x12 = 4.5 Sq.Ft'},
                    {value:'60x14-5.9-Sq.Ft', text:'60x14 = 5.9 Sq.Ft'},
                ],
            }
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
            handleDropdownChange: function(value){
                window.detectChanges = true;
            },
            changeDateFormat: function(value){
                return this.$store.getters.changeDateFormat(value);
            },
            save:function(){
                eventBus.$emit(event.SAVE_INSTALLATION_PRODUCTION);
            },
            addRow() {
                if (!this.inPDF)
                    this.formFields.install_production_list.push({id: 0})
            },

            /** Generic*/
            printPDF() {
                eventBus.$emit(event.PRINT_PDF)
            },
            checkDate: function(date){
                return searchForEmptyDate(date);
            },
            getDayOfWeek:function(date) {
                if(date != null){
                    const dayOfWeek = new Date(date).getDay();

                    return isNaN(dayOfWeek) ? null :
                        ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
                }
            },
            findBaseOption(val){
                let option = []
                option =  this.baseOptions.filter(obj => obj.value == val);
                return option.length > 0 ? option[0].text : ' ';
            }
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

    .custom-row div input {
        border: 1px solid #c4c4c4;
        margin: auto;
        margin-right: 0;
        height: 1.5rem;
        font-size: 12px;
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

</style>
