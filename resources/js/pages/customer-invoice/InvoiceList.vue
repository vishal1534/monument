<template>
    <div>
        <div>
            <h5 class="mx-2 my-1 custom-view-heading">Customer Portal </h5>
            <div class="bg-toolbar my-2 p-1">
                <Toolbar :customerName="customerName"></Toolbar>
            </div>
            <div>
                <Button :invoice="true"></Button>
            </div>
        </div>
        <div class="ml-4 mr-4">
            <div class="d-flex">
                <b-dropdown
                    class="m-2 custom-choose-btn d-none"
                    id="dropdown-form" ref="dropdown" size="sm" text="Choose Columns" variant="info custom-choose-text">
                    <b-dropdown-form class="overflow-auto scroll" style="height: 50vh;">
                        <template v-for="(objects, key) of filterFields">
                            <h6>{{key}}</h6>
                            <b-form-group :key="key + index" class="form-inline" v-for="(item, index) of objects">
                                <b-form-checkbox :checked="!item.thClass.includes('d-none')" v-if="item.key != 'action'" v-on:change="toggleColumn(item)"><span class="custom-checkbox-margin">{{item.label}}</span></b-form-checkbox>
                            </b-form-group>
                        </template>
                    </b-dropdown-form>
                </b-dropdown>

                <div class="d-flex ml-auto p-2">
                    <button @click="filterRecords" class="btn btn-sm btn-info my-auto px-3 custom-search-btn custom-search-text" data-placement="bottom" data-toggle="tooltip" title="Apply filters">Search</button>
                    <button :class="['btn btn-sm custom-clear-btn custom-clear-text my-auto px-3 mx-3', {'btn-danger': this.$store.state[this.axiosParams.module].isFiltered}]" :disabled="!this.$store.state[this.axiosParams.module].isFiltered" @click="clearFilter">Clear Filter</button>
                    <b-pagination
                        :per-page="perPage" :total-rows="rows"
                        align="right" aria-controls="data-table" class="my-auto ml-2" size="sm"
                        v-model="currentPage"
                    ></b-pagination>
                </div>
            </div>
            <div class="d-flex p-2">
                <label class="ml-auto custom-record-showing">Showing {{(currentPage*perPage) - (perPage-1)}} to {{rows < 10 || currentPage*perPage > rows ? rows : currentPage*perPage}} of {{rows}} records</label>
            </div>
            <b-table :busy="isBusy" :current-page="currentPage" :fields="tableFields" :items="tableData" :per-page="perPage"
                     bordered class="my-table bootstrap-vue-table a" hover responsive small striped>
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
                            <VueDatePicker @input="filterRecords" class="form-control-sm rounded-0 border" clearable
                                           format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" range v-if="!singleDatePicker" v-model="orderDate"/>
                            <VueDatePicker @input="filterRecords" class="form-control-sm rounded-0 border" clearable
                                           format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" v-if="singleDatePicker" v-model="orderDate"/>
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
                            <input @input="debounce" @keyup.enter="filterRecords" class="form-control-sm border rounded-0 custom-input-width" placeholder="Search here..." type="text" v-model="queryFields[data.field.parent].find(item => item.column == data.column).value"/>
                        </div>
                    </div>
                    <hr class="border">
                    <span class="ml-2 mr-1 custom-table-heading">{{ data.label }}</span>
                </template>

                <template #cell()="data">
                    <span class="custom-table-body ml-1"> {{ data.value }}</span>
                </template>

                <template #cell(index)="data">
                    <span class="custom-table-body ml-1"> {{ (data.index + 1) + ((currentPage-1) * perPage)}}</span>
                </template>

                <template #cell(date)="data">
                    <span class="custom-table-body ml-1"> {{ changeDateFormat(data.item.date) }}</span>
                </template>

                <template #cell(invoice_total)="data">
                    <span class="custom-table-body ml-1">$ {{ data.item.invoice ? data.item.invoice.invoice_total.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,") : '0.00' }}</span>
                </template>

                <template #cell(action)="data">
                    <div class="mx-1 custom-input-header">
                        <b-button :to="'customer-invoice/' + data.item.id" class="btn mx-1 py-1 custom-view-btn custom-view-text" v-if="isReadPermitted">View</b-button>
                        <router-link :to="'customerPortal/' + data.item.id" class="btn mx-1 py-1 custom-edit-btn custom-edit-text" v-if="isUpdatePermitted">Edit</router-link>
                        <a @click="deleteRecord(data.item.id)" class="btn mx-1 py-1 custom-delete-btn custom-delete-text" href="javascript:void(0)" v-if="isDeletePermitted">Delete</a>
                    </div>
                </template>
            </b-table>
        </div>
        <Modal :module="'AddInvoiceList'" :recordID="viewRecord" :title="'Invoice'"></Modal>
    </div>
</template>

<script>
    import Toolbar from "../customer-dashboard/Toolbar";
    import Button from '../customer-dashboard/Button';
    import {debounce} from "../../helpers/common";
    import Modal from '../../Modules/Modal';
    import {VueDatePicker} from '@mathieustan/vue-datepicker';
    import '@mathieustan/vue-datepicker/dist/vue-datepicker.min.css';

    export default {
        name: "InvoiceList",
        data() {
            return {
                orderDate: null,
                singleDatePicker: true,
                currentPage: 1,
                perPage: 10,
                viewRecord: 1,
                tableFields: [
                    {key: 'index', label: 'Index', thClass: 'px-0', tdClass: '', parent: "custom"},
                    {key: 'action', label: 'Action', parent: "custom", thClass: "px-0", tdClass: 'flexClass'}
                ],
                queryFields: {},
                axiosParams: {module: 'customerPortal'},
            }
        },
        metaInfo() {
            return {
                title: 'Customer Invoice'
            }
        },
        computed: {
            rows() {
                return this.tableData.length
            },
            tableData() {
                return this.$store.getters.getOrderTableData(this.axiosParams);
            },
            isBusy() {
                return this.$store.state[this.axiosParams.module].busy;
            },
            customerName: function () {
                if (this.$store.state['auth'].user && this.$store.state['auth'].user.role) {
                    return this.$store.state['auth'].user.name;
                }
            },
            isReadPermitted() {
                return this.$store.getters.isPermitted({resource: 'Customer Portal', action: 'read'});
            },
            isCreatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Customer Portal', action: 'create'});
            },
            isUpdatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Customer Portal', action: 'update'});
            },
            isDeletePermitted() {
                return this.$store.getters.isPermitted({resource: 'Customer Portal', action: 'delete'});
            },
            filterFields() {
                let filterObj = {};
                let displayCounter = 0;
                const showListColumn = ['date', 'name_on_stone', 'invoice_total', 'invoice_number'];
                const hideListColumn = ['date_promised', 'ship_date', 'closed_date'];
                const labelMap = {
                    date: 'Order Date', name_on_stone: 'Last Name on Stone', invoice_number: 'Invoice No.'
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
                    {key: 'invoice_number', loc: 1},
                    {key: 'name_on_stone', loc: 2},
                    {key: 'date', loc: 3},
                    {key: 'invoice_total', loc: 4},
                    {key: 'action', loc: this.tableFields.length - 1},
                ];
                orderMap.forEach(objLoc => {
                    const index = this.tableFields.findIndex(obj => obj.key == objLoc.key);
                    this.tableFields.splice(objLoc.loc, 0, this.tableFields.splice(index, 1)[0]);
                })
                return filterObj;
            },
        },
        components: {
            Modal,
            Toolbar,
            Button,
            VueDatePicker
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Customer Portal', action: 'read'}))
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
            changeDateFormat: function (value) {
                return this.$store.getters.changeDateFormat(value);
            },
            getColumnList: function () {
                if (this.$store.state[this.axiosParams.module].columnList.length == 0) {
                    this.axiosParams.column = 'orderColumns';
                    this.$store.dispatch('getColumnList', this.axiosParams);
                }
            },
            getRecordList: function () {
                if (this.$store.state[this.axiosParams.module].recordList.length == 0) {
                    this.axiosParams.methodName = 'customerOrder';
                    this.$store.dispatch('getCustomerPortalInfo', this.axiosParams);
                }
            },
            setViewRecord: function (id) {
                this.viewRecord = id;
            },
            filterRecords: function () {
                let isDateRangeSet = false;
                let formData = new FormData();
                for (let key in this.queryFields) {
                    this.queryFields[key].filter(obj => {
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
                        }
                    })
                    formData.append(key, JSON.stringify(this.queryFields[key]));
                }
                this.axiosParams.filterData = formData;
                if (!isDateRangeSet) {
                    this.$store.state[this.axiosParams.module].busy = true;
                    this.$store.state[this.axiosParams.module].isFiltered = true;
                    this.$store.dispatch('getFilteredRecords', this.axiosParams);
                }
            },
            customizeLabel: function (str) {
                let i, labels = str.split('_');
                for (i = 0; i < labels.length; i++) {
                    labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
                }
                return labels.join(' ');
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
            clearFilter: function () {
                for (let objects of Object.values(this.queryFields)) {
                    for (let obj of objects) {
                        obj.operator = 'like';
                        obj.value = '';
                    }
                }
                this.orderDate = null
                this.filterRecords();
                this.$store.state[this.axiosParams.module].isFiltered = false;
            },
        }
    }
</script>

<style scoped>
    .bootstrap-vue-table {
        min-height: 80vh;
    }
</style>
