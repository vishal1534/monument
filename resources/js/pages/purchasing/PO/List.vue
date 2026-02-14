<template>
    <div>
        <h5 class="mx-2 my-1 custom-view-heading">PO List</h5>
        <div class="bg-toolbar my-2 p-1">
            <div class="d-flex justify-content-end align-items-center">
                <div class="d-flex m-auto">
                    <router-link class="btn custom-infobtn-list custom-infobtn-list-text" to="/purchase-order" v-if="isCreatePermitted">Add PO</router-link>
                    <button @click="printPDF" class="btn custom-infobtn-list custom-infobtn-list-text mx-2" v-if="isCreatePermitted">Print PO Report</button>
                </div>
                <div class="d-flex">
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
                                class="m-2 custom-choose-btn"
                                id="dropdown-form"
                                ref="dropdown"
                                size="sm"
                                text="Choose Columns"
                                variant="info custom-choose-text">
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
                                 bordered class="my-table bootstrap-vue-table a"
                                 hover id="data-table" responsive small striped>
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
                            <template #head(po_date)="data">
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
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" range v-if="!pODatePicker" v-model="pODate"/>
                                        <VueDatePicker :disabled="queryFields[data.field.parent].find(item => item.column == data.column).operator == 'IS' ? true : false " @input="filterRecords(1)" class="form-control-sm rounded-0 border"
                                                       clearable
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" v-if="pODatePicker" v-model="pODate"/>
                                    </div>
                                </div>
                                <hr class="border">
                                <span class="ml-2 mr-1 custom-table-heading">{{ data.label }}</span>
                            </template>
                            <template #head(order_place_on)="data">
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
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" range v-if="!orderPlaceOnDatePicker" v-model="orderPlaceOnDate"/>
                                        <VueDatePicker :disabled="queryFields[data.field.parent].find(item => item.column == data.column).operator == 'IS' ? true : false " @input="filterRecords(1)" class="form-control-sm rounded-0 border"
                                                       clearable
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" v-if="orderPlaceOnDatePicker" v-model="orderPlaceOnDate"/>
                                    </div>
                                </div>
                                <hr class="border">
                                <span class="ml-2 mr-1 custom-table-heading">{{ data.label }}</span>
                            </template>
                            <template #head(shipping_date)="data">
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
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" range v-if="!shippingDatePicker" v-model="shippingDate"/>
                                        <VueDatePicker :disabled="queryFields[data.field.parent].find(item => item.column == data.column).operator == 'IS' ? true : false " @input="filterRecords(1)" class="form-control-sm rounded-0 border"
                                                       clearable
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" v-if="shippingDatePicker" v-model="shippingDate"/>
                                    </div>
                                </div>
                                <hr class="border">
                                <span class="ml-2 mr-1 custom-table-heading">{{ data.label }}</span>
                            </template>
                            <template #head(po_closed_on)="data">
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
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" range v-if="!pOCloseOnDatePicker" v-model="pOCloseOnDate"/>
                                        <VueDatePicker :disabled="queryFields[data.field.parent].find(item => item.column == data.column).operator == 'IS' ? true : false " @input="filterRecords(1)" class="form-control-sm rounded-0 border"
                                                       clearable
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" v-if="pOCloseOnDatePicker" v-model="pOCloseOnDate"/>
                                    </div>
                                </div>
                                <hr class="border">
                                <span class="ml-2 mr-1 custom-table-heading">{{ data.label }}</span>
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
                            <template #cell()="data">
                                <span class="custom-table-body ml-1"> {{ data.value }}</span>
                            </template>
                            <template #cell(order_place_on)="data">
                                <span class="custom-table-body ml-1"> {{ changeDateFormat(data.item.order_place_on) }}</span>
                            </template>
                            <template #cell(po_closed_on)="data">
                                <span class="custom-table-body ml-1"> {{ changeDateFormat(data.item.po_closed_on) }}</span>
                            </template>
                            <template #cell(po_date)="data">
                                <span class="custom-table-body ml-1"> {{ changeDateFormat(data.item.po_date) }}</span>
                            </template>
                            <template #cell(shipping_date)="data">
                                <span class="custom-table-body ml-1"> {{ changeDateFormat(data.item.shipping_date) }}</span>
                            </template>
                            <template #cell(index)="data">
                                <span class="custom-table-body ml-1"> {{(data.index + 1) + ((pageCurrentPage-1) * pagePerPage) }} </span>
                            </template>
                            <template #cell(action)="data">
                                <div class="mx-1 custom-input-header">
                                    <b-button @click="setViewRecord(data.item.id)" class="btn mx-1 py-1 custom-view-btn custom-view-text" v-b-modal.view-modal v-if="isReadPermitted">View</b-button>
                                    <router-link :to="'purchase-order/' + data.item.id" class="btn mx-1 py-1 custom-edit-btn custom-edit-text" v-if="isUpdatePermitted">Edit</router-link>
                                    <a @click="deleteRecord(data.item.id)" class="btn mx-1 py-1 custom-delete-btn custom-delete-text" href="javascript:void(0)" v-if="isDeletePermitted">Delete</a>
                                </div>
                            </template>
                        </b-table>
                        <Modal :module="'PurchaseOrder'" :recordID="viewRecord" :title="'Purchase Order'"></Modal>
                    </div>
                </div>
            </div>
        </div>
        <PDF :title="'printPurchaseOrderReport'" class=" ml-n4">
            <div class="d-flex" slot="header">
                <div class="align-self-center ml-3 mr-5">
                    <img class=" ml-4 w-100 height-150" src="/images/monument-logo.png">
                    <h6 class="text-center">816-833-5111</h6>
                </div>
                <div class="d-flex justify-content-center mt-4 ml-5">
                    <h2 class="font-weight-bold ml-5">REGULAR PURCHASE ORDER REPORT</h2>
                </div>
            </div>
            <div class="ml-n3" slot="body">
                <PDFReport></PDFReport>
            </div>
            <div slot="footer"></div>
        </PDF>
    </div>
</template>

<script>
    import {event, eventBus} from "../../../event-bus/event-bus";
    import PDF from "../../../Modules/PDF-Modal";
    import {deleteRecord, fetchPaginateRecord, filterRecords} from '../../../helpers/axios';
    import {debounce} from "../../../helpers/common";
    import Modal from '../../../Modules/Modal';
    import PDFReport from "./PDFReport";
    import {VueDatePicker} from '@mathieustan/vue-datepicker';
    import '@mathieustan/vue-datepicker/dist/vue-datepicker.min.css';

    export default {
        name: "List",
        data() {
            return {
                sortByColumn: 'id',
                sortByDesc: false,
                columnTableName: 'poOrder',
                foreignKey: '',
                childClassName: '',
                childTableName: '',
                sortDirection: 'desc',
                pageCurrentPage: 1,
                pageTotalRows: 1,
                pagePerPage: 1,
                pageFrom: 1,
                pageTo: 1,
                pOCloseOnDate: null,
                pOCloseOnDatePicker: true,
                shippingDate: null,
                shippingDatePicker: true,
                orderPlaceOnDate: null,
                orderPlaceOnDatePicker: true,
                pODate: null,
                pODatePicker: true,
                currentPage: 1,
                perPage: 10,
                viewRecord: 1,
                tableFields: [
                    {key: 'index', label: 'Index', thClass: 'px-0', tdClass: '', parent: "custom"},
                    {key: 'action', label: 'Action', parent: "custom", thClass: "px-0", tdClass: 'flexClass'}
                ],
                queryFields: {},
                axiosParams: {module: 'PoOrder'},
            }
        },
        metaInfo() {
            return {
                title: `Purchase Order List`,
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
                return this.$store.getters.getPurchaseOrderTableData;
            },
            isBusy() {
                return this.$store.state[this.axiosParams.module].busy;
            },
            filterFields() {
                let filterObj = {};
                let displayCounter = 0;
                for (const [key, value] of Object.entries(this.$store.state[this.axiosParams.module].columnList)) {
                    let customKey = this.customizeLabel(key);
                    let objArray = [];
                    for (let val of value) {
                        let showColumn = displayCounter > 2 ? 'd-none' : '';
                        let label = this.customizeLabel(val);
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
                return filterObj;
            },
            isReadPermitted() {
                return this.$store.getters.isPermitted({resource: 'Purchasing', action: 'read'});
            },
            isCreatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Purchasing', action: 'create'});
            },
            isUpdatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Purchasing', action: 'update'});
            },
            isDeletePermitted() {
                return this.$store.getters.isPermitted({resource: 'Purchasing', action: 'delete'});
            },

        },
        components: {
            Modal,
            PDF,
            PDFReport,
            VueDatePicker
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Purchasing', action: 'read'}))
                this.$router.push('/access-denied');
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
                    this.$store.dispatch('getColumnList', this.axiosParams);
                }
            },
            getRecordList: function () {
                /* if (this.$store.state[this.axiosParams.module].recordList.length == 0) {
                     this.$store.dispatch('getModuleInfo', this.axiosParams);
                 }*/
                fetchPaginateRecord({module: this.axiosParams.module, apiURL: 'paginateRecord', page: this.pageCurrentPage}, (response) => {
                    this.setDataForPagination(response.data)
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            deleteRecord: function (id) {
                if (confirm("Do you really want to delete this record?")) {
                    this.axiosParams.id = id;
                    deleteRecord(this.axiosParams, (response) => {
                        if (response.data) {
                            this.$store.dispatch('removeRecordFromList', this.axiosParams);
                        } else {
                            console.log(response.data);
                        }
                    }, (error) => {
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    })
                }

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
                        if (obj.operator == '...' && obj.column == 'po_date') {
                            isDateRangeSet = true
                            this.pODatePicker = false
                            if (this.pODate?.start && this.pODate?.end) {
                                obj.value = this.pODate.start + '...' + this.pODate.end
                                isDateRangeSet = false
                            } else if (this.pODate == undefined) {
                                obj.value = null
                                isDateRangeSet = false
                            }
                        } else if (obj.operator != '...' && obj.column == 'po_date') {
                            this.pODatePicker = true
                            if (this.pODate?.start && this.pODate?.end) {
                                this.pODate = null
                            }
                            obj.value = this.pODate == undefined ? null : this.pODate
                        } else if (obj.operator == '...' && obj.column == 'order_place_on') {
                            isDateRangeSet = true
                            this.orderPlaceOnDatePicker = false
                            if (this.orderPlaceOnDate?.start && this.orderPlaceOnDate?.end) {
                                obj.value = this.orderPlaceOnDate.start + '...' + this.orderPlaceOnDate.end
                                isDateRangeSet = false
                            } else if (this.orderPlaceOnDate == undefined) {
                                obj.value = null
                                isDateRangeSet = false
                            }
                        } else if (obj.operator != '...' && obj.column == 'order_place_on') {
                            this.orderPlaceOnDatePicker = true
                            if (this.orderPlaceOnDate?.start && this.orderPlaceOnDate?.end) {
                                this.orderPlaceOnDate = null
                            }
                            obj.value = this.orderPlaceOnDate == undefined ? null : this.orderPlaceOnDate
                        } else if (obj.operator == '...' && obj.column == 'shipping_date') {
                            isDateRangeSet = true
                            this.shippingDatePicker = false
                            if (this.shippingDate?.start && this.shippingDate?.end) {
                                obj.value = this.shippingDate.start + '...' + this.shippingDate.end
                                isDateRangeSet = false
                            } else if (this.shippingDate == undefined) {
                                obj.value = null
                                isDateRangeSet = false
                            }
                        } else if (obj.operator != '...' && obj.column == 'shipping_date') {
                            this.shippingDatePicker = true
                            if (this.shippingDate?.start && this.shippingDate?.end) {
                                this.shippingDate = null
                            }
                            obj.value = this.shippingDate == undefined ? null : this.shippingDate
                        } else if (obj.operator == '...' && obj.column == 'po_closed_on') {
                            isDateRangeSet = true
                            this.pOCloseOnDatePicker = false
                            if (this.pOCloseOnDate?.start && this.pOCloseOnDate?.end) {
                                obj.value = this.pOCloseOnDate.start + '...' + this.pOCloseOnDate.end
                                isDateRangeSet = false
                            } else if (this.pOCloseOnDate == undefined) {
                                obj.value = null
                                isDateRangeSet = false
                            }
                        } else if (obj.operator != '...' && obj.column == 'po_closed_on') {
                            this.pOCloseOnDatePicker = true
                            if (this.pOCloseOnDate?.start && this.pOCloseOnDate?.end) {
                                this.pOCloseOnDate = null
                            }
                            obj.value = this.pOCloseOnDate == undefined ? null : this.pOCloseOnDate
                        }
                    })
                    formData.append(key, JSON.stringify(this.queryFields[key]));
                }
                let queryData = [{
                    'sortDirection': this.sortDirection,
                    'columnTableName': this.columnTableName,
                    'childClassName': this.childClassName,
                    'foreignKey': this.foreignKey,
                    'sortByColumn': this.sortByColumn,
                    'childTableName': this.childTableName,
                    'pagePerPage': this.pagePerPage,
                }]
                formData.append('queryData', JSON.stringify(queryData));
                this.axiosParams.filterData = formData;
                if (!isDateRangeSet) {
                    this.$store.state[this.axiosParams.module].busy = true;
                    this.$store.state[this.axiosParams.module].isFiltered = true;
                    // this.$store.dispatch('getFilteredRecords', this.axiosParams);
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
                    'Supplier': {'columnTableName': 'idInParentTable', 'foreignKey': 'supplier_id', 'childClassName': '\\Supplier'},
                    'PoOrder': {'columnTableName': 'poOrder', 'childClassName': ''}
                };

                let findParent = this.tableFields.find(obj => obj.key == this.sortByColumn)
                if (this.sortByColumn != 'id' && tableNames[findParent.parent]) {
                    this.columnTableName = tableNames[findParent.parent].columnTableName;
                    this.childClassName = tableNames[findParent.parent].childClassName;
                    if (tableNames[findParent.parent].foreignKey) {
                        this.foreignKey = tableNames[findParent.parent].foreignKey;
                    }
                    if (tableNames[findParent.parent].tableName) {
                        this.childTableName = tableNames[findParent.parent].tableName;
                    }
                } else {
                    this.columnTableName = 'poOrder';
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
                this.sortDirection = 'desc'
                this.sortByDesc = false
                this.columnTableName = 'poOrder'
                for (let objects of Object.values(this.queryFields)) {
                    for (let obj of objects) {
                        obj.operator = 'like';
                        obj.value = '';
                    }
                }
                this.pODate = null
                this.orderPlaceOnDate = null
                this.shippingDate = null
                this.pOCloseOnDate = null
                // this.filterRecords();
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
            setViewRecord: function (id) {
                this.viewRecord = id;
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
                    id: 'supplier-toast',
                    title: params.title,
                    variant: params.variant,
                    toaster: 'b-toaster-top-center',
                    autoHideDelay: params.duration ? params.duration : 2000,
                    noAutoHide: this.toastHider,
                    noCloseButton: true,
                })
                this.saveDisabled = false;

            },
            printPDF() {
                eventBus.$emit(event.PRINT_PDF)
            },
            changeDateFormat: function (value) {
                return this.$store.getters.changeDateFormat(value);
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
    .flexClass {
        display: flex;
    }

    .custom-header-width {
        min-width: 260px;
    }

    .bootstrap-vue-table {
        min-height: 80vh;
    }

    @page report-print {
        size: landscape;
    }

    .page {
        page: report-print;
    }
</style>
