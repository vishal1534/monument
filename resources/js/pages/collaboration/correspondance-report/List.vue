<template>
    <div>
        <h5 class="mx-2 my-1 custom-view-heading">Correspondence Report</h5>
        <div class="bg-toolbar my-2 p-1">
            <div class="d-flex justify-content-end align-items-center">
                <div class="d-flex m-auto">
                    <button @click="printPDF" class="btn-info mx-1 custom-infobtn-toolbar custom-infobtn-text" type="button">Print</button>
                </div>
                <div class="d-flex mx-2">
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
                            <b-dropdown
                                class="m-2 custom-choose-btn d-none"
                                id="dropdown-form"
                                ref="dropdown"
                                size="sm"
                                text="Choose Columns"
                                variant="info custom-choose-text">
                                <b-dropdown-form class="overflow-auto scroll" style="height: 25vh;">
                                    <template v-for="(objects, key) of filterFields">
                                        <h6>{{key}}</h6>
                                        <b-form-group :key="key + index" class="form-inline" v-for="(item, index) of objects">
                                            <b-form-checkbox :checked="!item.thClass.includes('d-none')" v-if="item.key != 'action'" v-on:change="toggleColumn(item)"><span class="custom-checkbox-margin">{{item.label}}</span></b-form-checkbox>
                                        </b-form-group>
                                    </template>
                                </b-dropdown-form>
                            </b-dropdown>
                            <div class="d-flex ml-auto">
                                <button @click="filterRecords(1)" class="btn btn-sm btn-info my-auto px-3 custom-search-btn custom-search-text" data-placement="bottom" data-toggle="tooltip" title="Apply filters">Search</button>
                                <button :class="['btn btn-sm custom-clear-btn custom-clear-text my-auto px-3 mx-3', {'btn-danger': this.$store.state[this.axiosParams.module].isFiltered}]" :disabled="!this.$store.state[this.axiosParams.module].isFiltered" @click="clearFilter">Clear Filter</button>
                                <b-pagination
                                    :per-page="pagePerPage"
                                    :total-rows="pageTotalRows"
                                    @page-click="getPaginatedRecord"
                                    align="right"
                                    aria-controls="data-table"
                                    class="my-auto ml-2"
                                    size="sm"
                                    v-model="pageCurrentPage"
                                ></b-pagination>
                                <b-form-select :options="perPageRecordList"
                                               @change="getRecord"
                                               class="input-list-md form-control-sm rounded-0 my-1 mx-3"
                                               size="sm"
                                               v-model="getSelected">
                                    <template #first>
                                        <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                                    </template>
                                </b-form-select>
                            </div>
                        </div>
                        <div class="d-flex">
                            <label class="ml-auto custom-record-showing">Showing {{pageFrom}} to {{pageTo}} of {{pageTotalRows}} records</label>
                        </div>
                        <b-table :busy="isBusy" :current-page="currentPage" :fields="tableFields" :items="tableData" :no-local-sorting="true" :per-page="pagePerPage"
                                 :sort-by.sync="sortByColumn" :sort-desc.sync="sortByDesc"
                                 bordered class="my-table bootstrap-vue-table a" hover id="data-table" responsive small striped>
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
                            <template #head()="data">
                                <div class="d-flex mx-1 custom-input-header">
                                    <div class="mx-1 btn-group">
                                        <select @change="filterRecords(1)" class="form-control-sm rounded-0 border bg-light" v-model="queryFields[data.field.parent].find(item => item.column == data.column).operator">
                                            <option selected title="Equals To" v-b-tooltip.hover value="like">=</option>
                                            <option title="Empty" v-b-tooltip.hover value="IS">=''</option>
                                            <option title="Not Equals to" v-b-tooltip.hover value="not like"><></option>
                                            <option title="Greater Than" v-b-tooltip.hover value=">">></option>
                                            <option title="Less Than" v-b-tooltip.hover value="<"><</option>
                                            <option title="Greater & Equals to" v-b-tooltip.hover value=">=">>=</option>
                                            <option title="Less & Equals to" v-b-tooltip.hover value="<="><=</option>
                                            <option title="Range" v-b-tooltip.hover value="...">...</option>
                                        </select>
                                        <input :disabled="queryFields[data.field.parent].find(item => item.column == data.column).operator == 'IS' ? true : false " @input="debounce" @keyup.enter="filterRecords(1)" class="form-control-sm border rounded-0 custom-input-width"
                                               placeholder="Search here..."
                                               type="text" v-model="queryFields[data.field.parent].find(item => item.column == data.column).value"/>
                                    </div>
                                </div>
                                <hr class="border">
                                <span class="ml-2 mr-1 custom-table-heading">{{ data.label }}</span>
                            </template>
                            <template #head(date)="data">
                                <div class="d-flex mx-1 custom-date-header">
                                    <div class="btn-group">
                                        <select @change="filterRecords(1)" class="form-control-sm rounded-0 border bg-light" v-model="queryFields[data.field.parent].find(item => item.column == data.column).operator">
                                            <option title="Equals To" v-b-tooltip.hover value="like">=</option>
                                            <option title="Empty" v-b-tooltip.hover value="IS">=''</option>
                                            <option title="Not Equals to" v-b-tooltip.hover value="not like"><></option>
                                            <option title="Greater Than" v-b-tooltip.hover value=">">></option>
                                            <option title="Less Than" v-b-tooltip.hover value="<"><</option>
                                            <option title="Greater & Equals to" v-b-tooltip.hover value=">=">>=</option>
                                            <option title="Less & Equals to" v-b-tooltip.hover value="<="><=</option>
                                            <option title="Range" v-b-tooltip.hover value="...">...</option>
                                        </select>
                                        <VueDatePicker :disabled="queryFields[data.field.parent].find(item => item.column == data.column).operator == 'IS' ? true : false " @input="filterRecords(1)" class="form-control-sm rounded-0 border"
                                                       clearable
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" range v-if="!taskDatePicker" v-model="taskDate"/>
                                        <VueDatePicker :disabled="queryFields[data.field.parent].find(item => item.column == data.column).operator == 'IS' ? true : false " @input="filterRecords(1)" class="form-control-sm rounded-0 border"
                                                       clearable
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" v-if="taskDatePicker" v-model="taskDate"/>
                                    </div>
                                </div>
                                <hr class="border">
                                <span class="ml-2 mr-1 custom-table-heading">{{ data.label }}</span>
                            </template>
                            <template #cell()="data">
                                <span class="custom-table-body ml-1"> {{ data.value }}</span>
                            </template>
                            <template #cell(index)="data">
                                <span class="custom-table-body ml-1"> {{(data.index + 1) + ((pageCurrentPage-1) * pagePerPage) }} </span>
                            </template>
                            <template #cell(date)="data">
                                <span class="custom-table-body ml-1">{{ data.item.date ? changeDateFormat(data.item.date) : '' }}</span>
                            </template>
                        </b-table>
                    </div>
                </div>
            </div>
        </div>

        <PDF>
            <div class="pdf" slot="header">
                <h5 class="text-center">Correspondance Report</h5>
            </div>
            <div class="pdf" slot="body">
                <div class="row">
                    <b-table :fields="pdfTableFields" :items="printTableData"
                             bordered class="printPDFFooter" id="data-table-pdf" no-footer-sorting responsive small>
                        <template #head()="data">
                            <label>{{ data.label }}</label>
                        </template>
                        <template #cell(index)="data">
                            <span class="custom-table-body ml-1"> {{ (data.index + 1)}}</span>
                        </template>
                        <template #cell(invoice_number)="data">
                            <span class="custom-table-body ml-1"> {{data.item.correspondence.order.invoice.invoice_number }}</span>
                        </template>
                        <template #cell(name_on_stone)="data">
                            <span class="custom-table-body ml-1"> {{ data.item.correspondence.order.family ? data.item.correspondence.order.family.name_on_stone : '' }}</span>
                        </template>
                        <template #cell(date)="data">
                            <span class="custom-table-body ml-1">{{ data.item.date ? changeDateFormat(data.item.date) : '' }}</span>
                        </template>
                    </b-table>
                </div>
            </div>
        </PDF>
    </div>
</template>

<script>
    import {fetchPaginateRecord, filterRecords} from '../../../helpers/axios';
    import {debounce} from "../../../helpers/common";
    import PDF from '../../../Modules/PDF-Modal';
    import {VueDatePicker} from '@mathieustan/vue-datepicker';
    import '@mathieustan/vue-datepicker/dist/vue-datepicker.min.css';
    import {event, eventBus} from "../../../event-bus/event-bus";

    export default {
        name: "List",
        data() {
            return {
                sortByColumn: 'id',
                sortByDesc: false,
                columnTableName: 'correspondenceTask',
                foreignKey: '',
                childClassName: '',
                childTableName: '',
                sortDirection: 'asc',
                pageCurrentPage: 1,
                pageTotalRows: 1,
                pagePerPage: 1,
                pageFrom: 1,
                pageTo: 1,
                currentPage: 1,
                perPage: 10,
                paginateOrGet: 'addpaginate',
                createdByDatePicker: true,
                createdByDate: null,
                taskDatePicker: true,
                taskDate: null,
                tableFields: [
                    {key: 'index', label: 'Index', thClass: 'px-0', tdClass: '', parent: "custom"},
                    {key: 'action', label: 'Action', parent: "custom", thClass: "px-0 d-none", tdClass: 'flexClass d-none'}
                ],
                queryFields: {},
                axiosParams: {module: 'correspondenceTask'},
                pdfTableFields: [
                    {key: 'index', label: "Index", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'invoice_number', label: "Invoice Number", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'name_on_stone', label: "Last Name On Stone", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'date', label: "Date", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'who_corsp', label: "Who Corsp", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'form_of_communication', label: "Form of Communication", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'why_contacted', label: "Why Contacted", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'customer_reasons', label: "Reasons from Customer", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'notes', label: "Notes", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'contact_name', label: "Name of Contact", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                ],
            }
        },
        metaInfo() {
            return {
                title: `Correspondence Report`,
            }
        },
        computed: {
            perPageRecordList() {
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
                return this.$store.getters.getCorrespondenceTaskData;
            },
            printTableData() {
                return this.$store.getters.getCorrespondencePrintTaskData;
            },
            isBusy() {
                return this.$store.state[this.axiosParams.module].busy;
            },
            filterFields() {
                let customFilterFields = {};
                let filterObj = {};
                let displayCounter = 0;
                const labelMap = {
                    customer_reasons: 'Reasons from Customer', contact_name: 'Name of Contact', form_of_communication: 'Form of Communication'
                };
                for (const [key, value] of Object.entries(this.$store.state[this.axiosParams.module].columnList)) {
                    let customKey = this.customizeLabel(key);
                    let objArray = [];
                    for (let val of value) {
                        let showColumn = displayCounter > 4 ? '' : '';
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
                return customFilterFields;
            },
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Collaboration', action: 'read'}))
                this.$router.push('/access-denied');
        },
        components: {
            VueDatePicker,
            PDF
        },
        mounted() {
            this.$store.state[this.axiosParams.module].busy = true
            this.getColumnList();
            this.getRecordList();
        },
        methods: {
            debounce: debounce(function () {
                this.filterRecords(1);
            }, 500),
            /**
             * CRUD
             * */
            getColumnList: function () {
                if (this.$store.state[this.axiosParams.module].columnList.length == 0) {
                    this.axiosParams.column = 'taskColumns';
                    this.$store.dispatch('getColumnList', this.axiosParams);
                }
            },
            getRecordList: function () {
                fetchPaginateRecord({module: this.axiosParams.module, apiURL: 'info', page: this.pageCurrentPage}, (response) => {
                    this.setDataForPagination(response.data)
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            filterRecords: async function (pageNo) {
                let isDateRangeSet = false;
                let formData = new FormData();
                for (let key in this.queryFields) {
                    this.queryFields[key].filter(obj => {
                        if (obj.operator == 'IS') {
                            obj.value = 'NULL'
                        } else if (obj.value == 'NULL') {
                            obj.value = ''
                        }
                        if (obj.operator == '...' && obj.column == 'date') {
                            isDateRangeSet = true
                            this.taskDatePicker = false
                            if (this.taskDate?.start && this.taskDate?.end) {
                                obj.value = this.taskDate.start + '...' + this.taskDate.end
                                isDateRangeSet = false
                            } else if (this.orderDate == undefined) {
                                obj.value = null
                                isDateRangeSet = false
                            }
                        } else if (obj.operator != '...' && obj.column == 'date') {
                            this.taskDatePicker = true
                            if (this.taskDate?.start && this.taskDate?.end) {
                                this.taskDate = null
                            }
                            obj.value = this.taskDate == undefined ? null : this.taskDate
                        }
                    })
                    formData.append(key, JSON.stringify(this.queryFields[key]));
                }
                let queryData = [{
                    'sortDirection': this.sortDirection,
                    'columnTableName': this.columnTableName,
                    'sortByColumn': this.sortByColumn,
                    'pagePerPage': this.pagePerPage,
                    'childTableName': this.childTableName,
                    'paginateOrGet': this.paginateOrGet,
                }]
                formData.append('queryData', JSON.stringify(queryData));
                this.axiosParams.filterData = formData;
                if (!isDateRangeSet) {
                    this.$store.state[this.axiosParams.module].busy = true;
                    this.$store.state[this.axiosParams.module].isFiltered = true;
                    this.axiosParams.page = pageNo;
                    await filterRecords(this.axiosParams, (response) => {
                        this.setDataForPagination(response.data)
                    }, (error) => {
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    })
                }
            },
            setDataForPagination: function (data) {
                if (data) {
                    this.pageCurrentPage = data.current_page
                    this.pageTotalRows = data.total
                    this.pagePerPage = data.per_page
                    this.pageFrom = data.from
                    this.pageTo = data.to
                    this.$store.state[this.axiosParams.module].recordList = data.data
                }
                this.$store.state[this.axiosParams.module].busy = false
            },
            getPaginatedRecord: function () {
                this.$store.state[this.axiosParams.module].busy = true
                setTimeout(() => {
                    this.filterRecords(this.pageCurrentPage)
                }, 500);
            },
            sortByAscDesc: function () {
                this.$store.state[this.axiosParams.module].busy = true
                let tableNames = {
                    'CorrespondenceTask': {'columnTableName': 'correspondenceTask', 'childClassName': ''},
                    'Family': {'columnTableName': 'idNotInChildOrParentTable', 'tableName': 'families', 'childClassName': ''},
                    'Invoice': {'columnTableName': 'idNotInChildOrParentTable', 'tableName': 'invoices', 'childClassName': ''},
                };
                let findParent = this.tableFields.find(obj => obj.key == this.sortByColumn)
                if (this.sortByColumn != 'id' && tableNames[findParent.parent]) {
                    this.columnTableName = tableNames[findParent.parent].columnTableName;
                    this.childClassName = tableNames[findParent.parent].childClassName;
                    if (tableNames[findParent.parent].tableName) {
                        this.childTableName = tableNames[findParent.parent].tableName;
                    }
                } else {
                    this.columnTableName = 'correspondenceTask';
                    this.sortByColumn = 'id'
                }
                this.sortByDesc == false ? this.sortDirection = 'asc' : this.sortByDesc == true ? this.sortDirection = 'desc' : ''
                this.filterRecords(1)
            },
            getRecord: function (value) {
                this.$store.state[this.axiosParams.module].busy = true
                this.pagePerPage = value
                this.filterRecords(1);
            },

            /**
             * Generic
             * */
            clearFilter: function () {
                this.sortByColumn = 'id'
                this.sortDirection = 'asc'
                this.sortByDesc = false
                this.columnTableName = 'correspondenceTask'
                this.paginateOrGet = 'addpaginate'
                for (let objects of Object.values(this.queryFields)) {
                    for (let obj of objects) {
                        obj.operator = 'like';
                        obj.value = '';
                    }
                }
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
            makeToast: function (params) {
                this.$bvToast.toast(params.message, {
                    id: 'task-collaboration-report-toast',
                    title: params.title,
                    variant: params.variant,
                    toaster: 'b-toaster-top-center',
                    autoHideDelay: params.duration ? params.duration : 2000,
                    noAutoHide: this.toastHider,
                    noCloseButton: true,
                })
                this.saveDisabled = false;
            },
            changeDateFormat: function (value) {
                return this.$store.getters.changeDateFormat(value);
            },
            printPDF() {
                this.paginateOrGet = 'printGet';
                let formData = new FormData();
                for (let key in this.queryFields) {
                    formData.append(key, JSON.stringify(this.queryFields[key]));
                }
                let queryData = [{
                    'sortDirection': this.sortDirection, 'columnTableName': this.columnTableName, 'sortByColumn': this.sortByColumn,
                    'pagePerPage': this.pagePerPage, 'childTableName': this.childTableName, 'paginateOrGet': this.paginateOrGet,
                }]
                formData.append('queryData', JSON.stringify(queryData));
                this.axiosParams.filterData = formData;
                this.axiosParams.page = 1;
                filterRecords(this.axiosParams, (response) => {
                    this.$store.state[this.axiosParams.module].printRecordList = response.data
                    this.paginateOrGet = 'addpaginate'
                    this.$nextTick(() => {
                        eventBus.$emit(event.PRINT_PDF);
                    });
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
        },
        watch: {
            sortByColumn(newColName, oldColName) {
                if (newColName !== oldColName) {
                    this.sortByAscDesc()
                }
            },
            sortByDesc(newSortDir, oldSortDir) {
                this.sortByAscDesc()
            }
        },
    }

</script>
<style scoped>

</style>
