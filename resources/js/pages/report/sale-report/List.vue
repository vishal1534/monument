<template>
    <div>
        <h5 class="mx-2 my-1 custom-view-heading">Sales Report</h5>
        <div class="bg-toolbar my-2 p-1">
            <div class="d-flex justify-content-end align-items-center">
                <div class="d-flex m-auto">
                    <button @click="printPDF" class="btn-info mx-1 custom-infobtn-toolbar custom-infobtn-text" type="button">Print</button>
                </div>
                <div class="d-flex">
                </div>
                <div class="mx-2 d-flex">
                    <img class="mx-1 my-auto" height="26" src="/images/video-chat.png" width="26"/>
                    <img class="mx-1" height="30" src="/images/help-icon.png" width="30"/>
                </div>
            </div>
        </div>
        <div id="quote">
            <div class="row m-0">
                <div class="col-md-12">
                    <div class="quote-body p-3">
                        <div class="d-flex">
                            <b-dropdown class="m-2 custom-choose-btn d-none " id="dropdown-form" ref="dropdown"
                                size="sm" text="Choose Columns" variant="info custom-choose-text">
                                <b-dropdown-form class="overflow-auto scroll" style="height: 50vh;">
                                    <template v-for="(objects, key) of filterFields">
                                        <h6>{{key}}</h6>
                                        <b-form-group :key="key + index" class="form-inline" v-for="(item, index) of objects">
                                            <b-form-checkbox :checked="!item.thClass.includes('d-none')" v-if="item.key != 'action'" v-on:change="toggleColumn(item)"><span class="custom-checkbox-margin">{{item.label}}</span></b-form-checkbox>
                                        </b-form-group>
                                    </template>
                                </b-dropdown-form>
                            </b-dropdown>
                            <div class="d-flex ml-auto">
                                <button @click="filterRecords" class="btn btn-sm btn-info my-auto px-3 custom-search-btn custom-search-text" data-placement="bottom" data-toggle="tooltip" title="Apply filters">Search</button>
                                <button :class="['btn btn-sm custom-clear-btn custom-clear-text my-auto px-3 mx-3', {'btn-danger': this.$store.state[this.axiosParams.module].isFiltered}]" :disabled="!this.$store.state[this.axiosParams.module].isFiltered" @click="clearFilter">Clear Filter</button>
                                <b-pagination
                                    :per-page="pagePerPage" :total-rows="rows"
                                    align="right" aria-controls="data-table" class="my-auto ml-2" size="sm" v-model="currentPage"
                                ></b-pagination>
                                <b-form-select size="sm" class="input-list-md form-control-sm rounded-0 my-1 mx-3"
                                               :options="perPageRecordList" v-model="getSelected" @change="getRecord">
                                    <template #first>
                                        <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                                    </template>
                                </b-form-select>
                            </div>
                        </div>
                        <div class="d-flex">
                            <label class="ml-auto custom-record-showing">Showing {{(currentPage*pagePerPage) - (pagePerPage-1)}} to {{rows < 10 || currentPage*pagePerPage > rows ? rows : currentPage*pagePerPage}} of {{rows}} records</label>
                        </div>
                        <b-table :busy="isBusy" :current-page="currentPage" :fields="tableFields" :items="tableData" :per-page="pagePerPage" bordered
                                 class="my-table bootstrap-vue-table a" hover id="data-table" no-footer-sorting responsive small striped>
                            <template #table-busy>
                                <div class="text-center text-info my-2">
                                    <b-spinner class="align-middle"></b-spinner>
                                    <strong>Loading...</strong>
                                </div>
                            </template>
                            <template #head(action)="data">
                                <hr class="border">
                                <span class="ml-3 mr-1 custom-table-heading">{{data.label}}</span>
                            </template>
                            <template #head(index)="data">
                                <hr class="border">
                                <span class="ml-2 mr-1 custom-table-heading">{{data.label}}</span>
                            </template>
                            <template #head(date)="data">
                                <div class="d-flex mx-1 custom-date-header">
                                    <div class="btn-group">
                                        <select @change="filterRecords" class="form-control-sm rounded-0 border bg-light" v-model="queryFields[data.field.parent].find(item => item.column == data.column).operator">
                                            <option title="Equals To" v-b-tooltip.hover value="like">=</option>
                                            <option title="Empty" v-b-tooltip.hover value="IS">=''</option>
                                            <option title="Not Equals to" v-b-tooltip.hover value="not like"><></option>
                                            <option title="Greater Than" v-b-tooltip.hover value=">">></option>
                                            <option title="Less Than" v-b-tooltip.hover value="<"><</option>
                                            <option title="Greater & Equals to" v-b-tooltip.hover value=">=">>=</option>
                                            <option title="Less & Equals to" v-b-tooltip.hover value="<="><=</option>
                                            <option title="Range" v-b-tooltip.hover value="...">...</option>
                                        </select>
                                        <VueDatePicker :disabled="queryFields[data.field.parent].find(item => item.column == data.column).operator == 'IS' ? true : false " @input="filterRecords" class="form-control-sm rounded-0 border"
                                                       clearable
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" range v-if="!singleDatePicker" v-model="orderDate"/>
                                        <VueDatePicker :disabled="queryFields[data.field.parent].find(item => item.column == data.column).operator == 'IS' ? true : false " @input="filterRecords" class="form-control-sm rounded-0 border"
                                                       clearable
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" v-if="singleDatePicker" v-model="orderDate"/>
                                    </div>
                                </div>
                                <hr class="border">
                                <span class="ml-2 mr-1 custom-table-heading">{{ data.label }}</span>
                            </template>
                            <template #head(closed_date)="data">
                                <div class="d-flex mx-1 custom-date-header">
                                    <div class="btn-group">
                                        <select @change="filterRecords" class="form-control-sm rounded-0 border bg-light" v-model="queryFields[data.field.parent].find(item => item.column == data.column).operator">
                                            <option title="Equals To" v-b-tooltip.hover value="like">=</option>
                                            <option title="Empty" v-b-tooltip.hover value="IS">=''</option>
                                            <option title="Not Equals to" v-b-tooltip.hover value="not like"><></option>
                                            <option title="Greater Than" v-b-tooltip.hover value=">">></option>
                                            <option title="Less Than" v-b-tooltip.hover value="<"><</option>
                                            <option title="Greater & Equals to" v-b-tooltip.hover value=">=">>=</option>
                                            <option title="Less & Equals to" v-b-tooltip.hover value="<="><=</option>
                                            <option title="Range" v-b-tooltip.hover value="...">...</option>
                                        </select>
                                        <VueDatePicker :disabled="queryFields[data.field.parent].find(item => item.column == data.column).operator == 'IS' ? true : false " @input="filterRecords" class="form-control-sm rounded-0 border"
                                                       clearable
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" range v-if="!closeDatePicker" v-model="closeDate"/>
                                        <VueDatePicker :disabled="queryFields[data.field.parent].find(item => item.column == data.column).operator == 'IS' ? true : false " @input="filterRecords" class="form-control-sm rounded-0 border"
                                                       clearable
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" v-if="closeDatePicker" v-model="closeDate"/>
                                    </div>
                                </div>
                                <hr class="border">
                                <span class="ml-2 mr-1 custom-table-heading">{{ data.label }}</span>
                            </template>
                            <template #head()="data">
                                <div class="d-flex mx-1 custom-input-header">
                                    <div class="mx-1 btn-group">
                                        <select @change="filterRecords" class="form-control-sm rounded-0 border bg-light" v-model="queryFields[data.field.parent].find(item => item.column == data.column).operator">
                                            <option selected title="Equals To" v-b-tooltip.hover value="like">=</option>
                                            <option title="Empty" v-b-tooltip.hover value="IS">=''</option>
                                            <option title="Not Equals to" v-b-tooltip.hover value="not like"><></option>
                                            <option title="Greater Than" v-b-tooltip.hover value=">">></option>
                                            <option title="Less Than" v-b-tooltip.hover value="<"><</option>
                                            <option title="Greater & Equals to" v-b-tooltip.hover value=">=">>=</option>
                                            <option title="Less & Equals to" v-b-tooltip.hover value="<="><=</option>
                                            <option title="Range" v-b-tooltip.hover value="...">...</option>
                                        </select>
                                        <input :disabled="queryFields[data.field.parent].find(item => item.column == data.column).operator == 'IS' ? true : false " @input="debounce" @keyup.enter="filterRecords" class="form-control-sm border rounded-0 custom-input-width"
                                               placeholder="Search here..."
                                               type="text" v-model="queryFields[data.field.parent].find(item => item.column == data.column).value"/>
                                    </div>
                                </div>
                                <hr class="border">
                                <span class="ml-2 mr-1 custom-table-heading">{{ data.label }}</span>
                            </template>
                            <template #cell()="data">
                                <span class="custom-table-body ml-1"> {{ data.value }}</span>
                            </template>
                            <template #cell(index)="data">
                                <span class="custom-table-body ml-1"> {{ (data.index + 1) + ((currentPage-1) * pagePerPage)}}</span>
                            </template>
                            <template #cell(date)="data">
                                <span class="custom-table-body ml-1"> {{ changeDateFormat(data.item.date) }}</span>
                            </template>
                            <template #cell(closed_date)="data">
                                <span class="custom-table-body ml-1"> {{ changeDateFormat(data.item.invoice.closed_date) }}</span>
                            </template>
                            <template #cell(sub_total)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.sub_total ? convertDecimal(Number(data.item.sub_total)) : '0.00' }}</span>
                            </template>
                            <template #cell(tax_amount)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.tax_amount ? convertDecimal(Number(data.item.tax_amount)) : '0.00' }}</span>
                            </template>
                            <template #cell(name)="data">
                                <span class="custom-table-body ml-1"> {{ data.item.company ? data.item.company.name : '' }}</span>
                            </template>
                            <template #cell(invoice_total)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.invoice.invoice_total ? convertDecimal(Number(data.item.invoice.invoice_total)) : '0.00' }}</span>
                            </template>
                            <!--<template #foot()="data">
                                <span class="custom-table-heading"></span>
                            </template>
                            <template #foot(tax_rate)="data">
                                <label>Total : % {{ convertDecimal(Number(calculateSubTotal.tax)) }}</label>
                            </template>
                            <template #foot(tax_amount)="data">
                                <label>Total : $ {{ convertDecimal(Number(calculateSubTotal.amount)) }}</label>
                            </template>
                            <template #foot(invoice_total)="data">
                                <label>Total : $ {{ convertDecimal(Number(calculateSubTotal.invoice_total)) }}</label>
                            </template>-->
                        </b-table>
                    </div>
                </div>
            </div>
        </div>
        <PDF>
            <div class="pdf" slot="header">
                <h5 class="text-center">Sales Report</h5>
            </div>
            <div class="pdf" slot="body">
                <div class="row">
                    <b-table :fields="pdfTableFields" :items="tableData" bordered class="" foot-clone id="data-table-pdf" no-footer-sorting
                             responsive small>
                        <template #head()="data">
                            <label>{{ data.label }}</label>
                        </template>
                        <template #cell(index)="data">
                            <span class="custom-table-body ml-1"> {{ (data.index + 1)}}</span>
                        </template>
                        <template #cell(date)="data">
                            <span class="custom-table-body ml-1"> {{ changeDateFormat(data.item.date) }}</span>
                        </template>
                        <template #cell(closed_date)="data">
                            <span class="custom-table-body ml-1"> {{ changeDateFormat(data.item.invoice.closed_date) }}</span>
                        </template>
                        <template #cell(tax_amount)="data">
                            <span class="custom-table-body ml-1">$ {{ data.item.tax_amount ? convertDecimal(Number(data.item.tax_amount)) : '0.00' }}</span>
                        </template>
                        <template #cell(sub_total)="data">
                            <span class="custom-table-body ml-1">$ {{ data.item.sub_total ? convertDecimal(Number(data.item.sub_total)) : '0.00' }}</span>
                        </template>
                        <template #cell(name)="data">
                            <span class="custom-table-body ml-1"> {{ data.item.company ? data.item.company.name : '' }}</span>
                        </template>
                        <template #cell(invoice_total)="data">
                            <span class="custom-table-body ml-1">$ {{ data.item.invoice.invoice_total ? convertDecimal(Number(data.item.invoice.invoice_total)) : '0.00' }}</span>
                        </template>
                        <template #foot()="data">
                            <span class="custom-table-heading"></span>
                        </template>
                        <template #foot(date)="data">
                            <label>Total</label>
                        </template>
                        <template #foot(sub_total)="data">
                            <label>$ {{ convertDecimal(Number(calculateAllSubTotal.sub_total)) }}</label>
                        </template>
                        <template #foot(tax_amount)="data">
                            <label>$ {{ convertDecimal(Number(calculateAllSubTotal.amount)) }}</label>
                        </template>
                        <template #foot(invoice_total)="data">
                            <label>$ {{ convertDecimal(Number(calculateAllSubTotal.invoice_total)) }}</label>
                        </template>
                    </b-table>
                </div>
            </div>
        </PDF>
    </div>
</template>

<script>
    import {debounce} from "../../../helpers/common";
    import {event, eventBus} from "../../../event-bus/event-bus";
    import PDF from '../../../Modules/PDF-Modal';
    import {VueDatePicker} from '@mathieustan/vue-datepicker';
    import '@mathieustan/vue-datepicker/dist/vue-datepicker.min.css';

    export default {
        name: "Sale-Report",
        data() {
            return {
                pagePerPage: 10,
                orderDate: null,
                singleDatePicker: true,
                closeDate: null,
                closeDatePicker: true,
                currentPage: 1,
                perPage: 10,
                tableFields: [
                    {key: 'index', label: 'Index', thClass: 'px-0', tdClass: '', parent: "custom"},
                    {key: 'action', label: 'Action', parent: "custom", thClass: "px-0 d-none", tdClass: 'flexClass d-none'}
                ],
                queryFields: {},
                axiosParams: {module: 'saleReport'},
                currentRecord: [],
                pdfTableFields: [
                    {key: 'index', label: "Index", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'name', label: "Company Name", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'date', label: "Invoice Date", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'closed_date', label: "Inv. Close Date", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'invoice_number', label: "Invoice #", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'sub_total', label: "Amount", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'tax_amount', label: "Tax", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'invoice_total', label: "Total Amount", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'total_material', label: "Total Material", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'total_o_e', label: "Total O&E", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                ],
            }
        },
        metaInfo() {
            return {
                title: `Sales Report`,
            }
        },
        computed: {
            perPageRecordList(){
                return this.$store.state.listNumberOfRecord.recordList;
            },
            getSelected: {
                get() {
                    return this.pagePerPage
                },
                set(value) {
                    return value
                },
            },
            rows() {
                return this.tableData.length
            },
            tableData() {
                return this.$store.getters.getOrderTableData(this.axiosParams);
            },
            isBusy() {
                return this.$store.state[this.axiosParams.module].busy;
            },
            filterFields() {
                let filterObj = {};
                let displayCounter = 0;
                const showListColumn = ['date', 'closed_date', 'name', 'invoice_total', 'invoice_number', 'tax_amount', 'sub_total', 'total_material', 'total_o_e'];
                const hideListColumn = ['original_invoice_number', 'ship_date', 'po', 'sales_person', 'order_type'];
                const labelMap = {
                    date: 'Invoice Date',
                    closed_date: 'Inv. Close Date',
                    name: 'Company Name',
                    invoice_number: 'Invoice #',
                    invoice_total: 'Total Amount',
                    sub_total: 'Amount',
                    tax_amount: 'Tax',
                    total_o_e: 'Total O&E',
                };
                for (const [key, value] of Object.entries(this.$store.state[this.axiosParams.module].columnList)) {
                    let customKey = this.customizeLabel(key);
                    let objArray = [];
                    for (let val of value) {
                        let showColumn = displayCounter > 3 ? 'd-none' : '';
                        if (hideListColumn.includes(val)) {
                            showColumn = 'd-none';
                        }
                        if (showListColumn.includes(val)) {
                            showColumn = '';
                        }
                        let label = this.customizeLabel(val);
                        if (labelMap.hasOwnProperty(val)) {
                            label = labelMap[val]
                        }
                        let obj = {key: val, label: label, parent: customKey, sortable: true, thClass: `px-0 ${showColumn}`, tdClass: showColumn};
                        objArray.push(obj);
                        displayCounter++;
                    }
                    filterObj[customKey] = objArray;
                }
                for (let objects of Object.entries(filterObj)) {
                    let key = objects[0];
                    let values = objects[1];
                    let queryObjArray = [];
                    for (let obj of values) {
                        this.tableFields.splice(this.tableFields.length - 1, 0, obj);
                        let queryObj = {column: obj.key, operator: 'like', value: ''};
                        queryObjArray.push(queryObj)
                    }
                    this.queryFields[key] = queryObjArray;
                }
                const orderMap = [
                    {key: 'name', loc: 1},
                    {key: 'date', loc: 2},
                    {key: 'closed_date', loc: 3},
                    {key: 'invoice_number', loc: 4},
                    {key: 'sub_total', loc: 5},
                    {key: 'tax_amount', loc: 6},
                    {key: 'invoice_total', loc: 7},
                ];
                orderMap.forEach(objLoc => {
                    const index = this.tableFields.findIndex(obj => obj.key == objLoc.key);
                    this.tableFields.splice(objLoc.loc, 0, this.tableFields.splice(index, 1)[0]);
                })
                return filterObj;
            },
            calculateSubTotal() {
                this.currentRecord = []
                let fields = {
                    tax: 0,
                    amount: 0,
                    invoice_total: 0,
                };
                let record = this.$store.state[this.axiosParams.module].recordList;
                let startPoint = (this.currentPage - 1) * this.pagePerPage;
                let endPoint = (this.currentPage * this.pagePerPage);
                for (startPoint; startPoint < endPoint; startPoint++) {
                    if (record[startPoint]) {
                        this.currentRecord.push(record[startPoint]);
                        fields.tax += Number(record[startPoint]['tax_rate'])
                        fields.amount += Number(record[startPoint]['tax_amount'])
                        fields.invoice_total += Number(record[startPoint]['invoice']['invoice_total'])
                    }
                }
                return fields;
            },
            calculateAllSubTotal() {
                let fields = {
                    sub_total: 0, amount: 0, invoice_total: 0,
                };
                let record = this.$store.state[this.axiosParams.module].recordList;
                let startPoint = 0;
                let endPoint = record.length;
                for (startPoint; startPoint < endPoint; startPoint++) {
                    if (record[startPoint]) {
                        fields.sub_total += Number(record[startPoint]['sub_total'])
                        fields.amount += Number(record[startPoint]['tax_amount'])
                        fields.invoice_total += Number(record[startPoint]['invoice']['invoice_total'])
                    }
                }
                return fields;
            },
        },
        components: {
            PDF,
            VueDatePicker
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Products', action: 'read'}))
                this.$router.push('/access-denied');
        },
        mounted() {
            this.getColumnList();
            this.getRecordList();
        },
        methods: {
            debounce: debounce(function () {
                this.filterRecords();
            }, 500),
            /**
             * CRUD
             * */
            getColumnList: function () {
                if (this.$store.state[this.axiosParams.module].columnList.length == 0) {
                    this.axiosParams.column = 'columns';
                    this.$store.dispatch('getColumnList', this.axiosParams);
                }
            },
            getRecordList() {
                this.axiosParams.method = 'info';
                this.$store.dispatch('getReportInfo', this.axiosParams);
            },
            filterRecords: function () {
                let isDateRangeSet = false;
                let formData = new FormData();
                for (let key in this.queryFields) {
                    this.queryFields[key].filter(obj => {
                        if (obj.operator == 'IS') {
                            obj.value = 'NULL'
                        }
                        if (obj.operator != 'IS' && obj.value == 'NULL') {
                            obj.value = ''
                        }
                        if (obj.operator == '...' && obj.column == 'date') {
                            isDateRangeSet = true
                            this.singleDatePicker = false
                            if (this.orderDate?.start && this.orderDate?.end) {
                                obj.value = this.orderDate.start + '...' + this.orderDate.end
                                isDateRangeSet = false
                            } else if (this.orderDate == undefined) {
                                obj.value = null
                                isDateRangeSet = false
                            }
                        } else if (obj.operator != '...' && obj.column == 'date') {
                            this.singleDatePicker = true
                            if (this.orderDate?.start && this.orderDate?.end) {
                                this.orderDate = null
                            }
                            obj.value = this.orderDate == undefined ? null : this.orderDate
                        } else if (obj.operator == '...' && obj.column == 'closed_date') {
                            isDateRangeSet = true
                            this.closeDatePicker = false
                            if (this.closeDate?.start && this.closeDate?.end) {
                                obj.value = this.closeDate.start + '...' + this.closeDate.end
                                isDateRangeSet = false
                            } else if (this.closeDate == undefined) {
                                obj.value = null
                                isDateRangeSet = false
                            }
                        } else if (obj.operator != '...' && obj.column == 'closed_date') {
                            this.closeDatePicker = true
                            if (this.closeDate?.start && this.closeDate?.end) {
                                this.closeDate = null
                            }
                            obj.value = this.closeDate == undefined ? null : this.closeDate
                        }
                    })
                    formData.append(key, JSON.stringify(this.queryFields[key]));
                }
                this.axiosParams.filterData = formData;
                if (!isDateRangeSet) {
                    this.$store.state[this.axiosParams.module].busy = true;
                    this.$store.state[this.axiosParams.module].isFiltered = true;
                    this.axiosParams.method = 'search';
                    this.$store.dispatch('getCompsiteReportFilteredRecord', this.axiosParams);
                }
            },
            getRecord: function (value) {
                this.pagePerPage = value
                this.calculateSubTotal
            },

            /**
             * Generic
             * */
            clearFilter: function () {
                for (let objects of Object.values(this.queryFields)) {
                    for (let obj of objects) {
                        obj.operator = 'like';
                        obj.value = '';
                    }
                }
                this.closeDate = null
                this.orderDate = null
                this.filterRecords();
                this.$store.state[this.axiosParams.module].isFiltered = false;
            },
            toggleColumn: function (column) {

                this.tableFields.filter(obj => {
                    if (obj.key == column.key) {
                        if (column.thClass.includes('d-none')) {
                            let modifyClass = column.thClass.replace("d-none", '');
                            this.$set(obj, 'thClass', modifyClass)
                            this.$set(obj, 'tdClass', modifyClass)
                        } else {
                            let modifyClass = column.thClass + " d-none";
                            this.$set(obj, 'thClass', modifyClass)
                            this.$set(obj, 'tdClass', modifyClass)
                        }
                    }
                });
            },
            customizeLabel: function (str) {
                let i, labels = str.split('_');
                for (i = 0; i < labels.length; i++) {
                    labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
                }
                return labels.join(' ');
            },
            convertDecimal: function (value) {
                value = (value).toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
                return value;
            },
            changeDateFormat: function (value) {
                return this.$store.getters.changeDateFormat(value);
            },
            printPDF() {
                eventBus.$emit(event.PRINT_PDF);
            },
        },
    }

</script>
<style scoped>
    .flexClass {
        display: flex;
    }

    .input-md {
        width: 20rem;
    }

    .bootstrap-vue-table {
        min-height: 80vh;
    }

    .order-form-btn {
        font-size: 0.5rem;
    }
</style>
