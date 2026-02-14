<template>
    <div>
        <h5 class="mx-2 my-1 custom-view-heading">Collaboration List</h5>
        <div class="bg-toolbar my-2 p-1">
            <div class="d-flex justify-content-end align-items-center">
                <div class="d-flex m-auto">
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
                                 :sort-by.sync="sortByColumn"
                                 :sort-desc.sync="sortByDesc"
                                 bordered class="my-table bootstrap-vue-table a" hover
                                 id="data-table" responsive small
                                 striped>
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
                            <template #head(is_installation)="data">
                                <div class="d-flex mx-1 custom-input-header">
                                    <div class="btn-group">
                                        <select @change="filterRecords(1)" class="form-control-sm rounded-0 border bg-light" v-model="queryFields[data.field.parent].find(item => item.column == data.column).value">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <hr class="border">
                                <span class="ml-3 mr-1 custom-table-heading">{{data.label}}</span>
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
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" range v-if="!singleDatePicker" v-model="orderDate"/>
                                        <VueDatePicker :disabled="queryFields[data.field.parent].find(item => item.column == data.column).operator == 'IS' ? true : false " @input="filterRecords(1)" class="form-control-sm rounded-0 border"
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
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" range v-if="!closeDatePicker" v-model="closeDate"/>
                                        <VueDatePicker :disabled="queryFields[data.field.parent].find(item => item.column == data.column).operator == 'IS' ? true : false " @input="filterRecords(1)" class="form-control-sm rounded-0 border"
                                                       clearable
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" v-if="closeDatePicker" v-model="closeDate"/>
                                    </div>
                                </div>
                                <hr class="border">
                                <span class="ml-2 mr-1 custom-table-heading">{{ data.label }}</span>
                            </template>
                            <template #head(ship_date)="data">
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
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" range v-if="!shipDatePicker" v-model="shipDate"/>
                                        <VueDatePicker :disabled="queryFields[data.field.parent].find(item => item.column == data.column).operator == 'IS' ? true : false " @input="filterRecords(1)" class="form-control-sm rounded-0 border"
                                                       clearable
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" v-if="shipDatePicker" v-model="shipDate"/>
                                    </div>
                                </div>
                                <hr class="border">
                                <span class="ml-2 mr-1 custom-table-heading">{{ data.label }}</span>
                            </template>
                            <template #head(date_promised)="data">
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
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" range v-if="!promiseDatePicker" v-model="promisedDate"/>
                                        <VueDatePicker :disabled="queryFields[data.field.parent].find(item => item.column == data.column).operator == 'IS' ? true : false " @input="filterRecords(1)" class="form-control-sm rounded-0 border"
                                                       clearable
                                                       format="MM/DD/YY" no-calendar-icon no-header placeholder="MM/DD/YY" v-if="promiseDatePicker" v-model="promisedDate"/>
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
                            <template #cell(is_installation)="data">
                                <span class="custom-table-body ml-1">{{ data.item.is_installation == 1 ? 'Yes' : 'No' }}</span>
                            </template>
                            <template #cell(date)="data">
                                <span class="custom-table-body ml-1">{{ data.item.order ? changeDateFormat(data.item.order.date) : '' }}</span>
                            </template>
                            <template #cell(closed_date)="data">
                                <span class="custom-table-body ml-1">{{ data.item.order ? changeDateFormat(data.item.order.invoice.closed_date) : '' }}</span>
                            </template>
                            <template #cell(date_promised)="data">
                                <span class="custom-table-body ml-1">{{ data.item.order ? changeDateFormat(data.item.order.invoice.date_promised) : '' }}</span>
                            </template>
                            <template #cell(ship_date)="data">
                                <span class="custom-table-body ml-1">{{ data.item.order ? changeDateFormat(data.item.order.invoice.ship_date) : ''}}</span>
                            </template>
                            <template #cell(invoice_total)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.order?.invoice?.invoice_total ? data.item.order?.invoice?.invoice_total.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,") : '0.00' }}</span>
                            </template>
                            <template #cell(sub_total)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.order?.sub_total ? data.item.order?.sub_total.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,") : '0.00' }}</span>
                            </template>
                            <template #cell(tax_rate)="data">
                                <span class="custom-table-body ml-1">% {{ data.item.order?.tax_rate ? data.item.order?.tax_rate.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,") : '0.00' }}</span>
                            </template>
                            <template #cell(tax_amount)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.order?.tax_amount ? data.item.order?.tax_amount.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,") : '0.00' }}</span>
                            </template>
                            <template #cell(discount)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.order?.discount ? data.item.order.discount.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,") : '0.00' }}</span>
                            </template>
                            <template #cell(action)="data">
                                <div class="mx-1 custom-input-header">
                                    <b-button @click="setViewRecord(data.item.id)" class="btn mx-1 py-1 custom-view-btn custom-view-text" v-b-modal.view-modal v-if="isReadPermitted">View</b-button>
                                    <router-link :to="'collaboration/' + data.item.id" class="btn mx-1 py-1 custom-edit-btn custom-edit-text" v-if="isUpdatePermitted">Edit</router-link>
                                </div>
                            </template>
                        </b-table>
                        <Modal :module="'Collaboration'" :recordID="viewRecord" :title="'Collaboration'"></Modal>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {deleteRecord, fetchPaginateRecord, filterRecords} from '../../helpers/axios';
    import Modal from '../../Modules/Modal';
    import {debounce} from "../../helpers/common";
    import {VueDatePicker} from '@mathieustan/vue-datepicker';
    import '@mathieustan/vue-datepicker/dist/vue-datepicker.min.css';

    export default {
        name: "List",
        data() {
            return {
                sortByColumn: 'id',
                sortByDesc: false,
                columnTableName: 'collaboration',
                foreignKey: '',
                childClassName: '',
                childTableName: '',
                sortDirection: 'desc',
                pageCurrentPage: 1,
                pageTotalRows: 1,
                pagePerPage: 1,
                pageFrom: 1,
                pageTo: 1,
                orderDate: null,
                closeDate: null,
                shipDate: null,
                promisedDate: null,
                currentPage: 1,
                singleDatePicker: true,
                closeDatePicker: true,
                shipDatePicker: true,
                promiseDatePicker: true,
                perPage: 10,
                viewRecord: 1,
                tableFields: [
                    {key: 'index', label: 'Index', thClass: 'px-0', tdClass: '', parent: "custom"},
                    {key: 'action', label: 'Action', parent: "custom", thClass: "px-0", tdClass: 'flexClass'}
                ],
                queryFields: {},
                axiosParams: {module: 'collaboration'},
            }
        },
        metaInfo() {
            return {
                title: `Collaboration List`,
            }
        },
        computed: {
            rows() {
                return this.tableData.length
            },
            tableData() {
                return this.$store.getters.getCollaborationTableData(this.axiosParams);
            },
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
            isBusy() {
                return this.$store.state[this.axiosParams.module].busy;
            },
            filterFields() {
                let filterObj = {};
                let customFilterFields = {};
                let displayCounter = 0;
                const labelMap = {
                    date: 'Order Date',
                    name_on_stone: 'Last Name on Stone',
                    title: 'Order Status',
                    type_title: 'Order Type',
                    location_title: 'Paper Location',
                };
                const showListColumn = ['date', 'name_on_stone', 'title', 'invoice_number'];
                const hideListColumn = ['date_promised', 'ship_date', 'closed_date'];
                const orderStatusColumn = ['is_installation','on_hold'];
                const choosColumnLabel = ['Invoice', 'Order', 'Order Type', 'Family'];
                const statusColumnLabel = ['Order Status', 'Paper Location'];
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
                    if (choosColumnLabel.includes(customKey)) {
                        if (!customFilterFields['Inv/Order']) {
                            customFilterFields['Inv/Order'] = [];
                        }
                        for (let orderKey of objArray) {
                            if (!orderStatusColumn.includes(orderKey.key)){
                                customFilterFields['Inv/Order'].splice(0, 0, orderKey)
                            }
                        }
                    } else if (statusColumnLabel.includes(customKey)) {
                        if (!customFilterFields['Status']) {
                            customFilterFields['Status'] = [];
                        }
                        for (let orderKey of objArray) {
                            customFilterFields['Status'].splice(0, 0, orderKey)
                        }
                    }
                    if (customKey == 'Order'){
                        if (!customFilterFields['Status']) {
                            customFilterFields['Status'] = [];
                        }
                        for (let orderKey of objArray) {
                            if (orderStatusColumn.includes(orderKey.key)){
                                customFilterFields['Status'].splice(0, 0, orderKey)
                            }
                        }
                    }
                    /*if (customKey == 'Collaboration'){
                        customFilterFields[customKey] = objArray;
                    }*/
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
                const dropDownKeyMap = [
                    {key: 'invoice_number', loc: 0, keyName: 'Inv/Order'},
                    {key: 'name_on_stone', loc: 1, keyName: 'Inv/Order'},
                    {key: 'contact', loc: 2, keyName: 'Inv/Order'},
                    {key: 'closed_date', loc: 3, keyName: 'Inv/Order'},
                    {key: 'ship_date', loc: 4, keyName: 'Inv/Order'},
                    {key: 'date_promised', loc: 5, keyName: 'Inv/Order'},
                    {key: 'invoice_total', loc: 6, keyName: 'Inv/Order'},
                    {key: 'date', loc: 7, keyName: 'Inv/Order'},
                    {key: 'po', loc: 8, keyName: 'Inv/Order'},
                    {key: 'sales_person', loc: 9, keyName: 'Inv/Order'},
                    {key: 'type_title', loc: 10, keyName: 'Inv/Order'},
                ];
                if (Object.keys(customFilterFields).length) {
                    dropDownKeyMap.forEach(objKey => {
                        const indx = customFilterFields[objKey.keyName].findIndex(obj2 => obj2.key == objKey.key)
                        if (indx != -1)
                            customFilterFields[objKey.keyName].splice(objKey.loc, 0, customFilterFields[objKey.keyName].splice(indx, 1)[0])
                    })
                }
                return customFilterFields;
            },
            isReadPermitted() {
                return this.$store.getters.isPermitted({resource: 'Collaboration', action: 'read'});
            },
            isCreatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Collaboration', action: 'create'});
            },
            isUpdatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Collaboration', action: 'update'});
            },
            isDeletePermitted() {
                return this.$store.getters.isPermitted({resource: 'Collaboration', action: 'delete'});
            },

        },
        components: {
            Modal,
            VueDatePicker
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Collaboration', action: 'read'}))
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
            changeDateFormat: function (value) {
                return this.$store.getters.changeDateFormat(value);
            },
            getRecordList: function () {
                fetchPaginateRecord({module: this.axiosParams.module, apiURL: 'paginateRecord', page: this.pageCurrentPage}, (response) => {
                    this.setDataForPagination(response.data)
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
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
                        } else if (obj.operator == '...' && obj.column == 'ship_date') {
                            isDateRangeSet = true
                            this.shipDatePicker = false
                            if (this.shipDate?.start && this.shipDate?.end) {
                                obj.value = this.shipDate.start + '...' + this.shipDate.end
                                isDateRangeSet = false
                            } else if (this.shipDate == undefined) {
                                obj.value = null
                                isDateRangeSet = false
                            }
                        } else if (obj.operator != '...' && obj.column == 'ship_date') {
                            this.shipDatePicker = true
                            if (this.shipDate?.start && this.shipDate?.end) {
                                this.shipDate = null
                            }
                            obj.value = this.shipDate == undefined ? null : this.shipDate
                        } else if (obj.operator == '...' && obj.column == 'date_promised') {
                            isDateRangeSet = true
                            this.promiseDatePicker = false
                            if (this.promisedDate?.start && this.promisedDate?.end) {
                                obj.value = this.promisedDate.start + '...' + this.promisedDate.end
                                isDateRangeSet = false
                            } else if (this.promisedDate == undefined) {
                                obj.value = null
                                isDateRangeSet = false
                            }
                        } else if (obj.operator != '...' && obj.column == 'date_promised') {
                            this.promiseDatePicker = true
                            if (this.promisedDate?.start && this.promisedDate?.end) {
                                this.promisedDate = null
                            }
                            obj.value = this.promisedDate == undefined ? null : this.promisedDate
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
                    this.axiosParams.page = pageNo;
                    await filterRecords(this.axiosParams, (response) => {
                        this.setDataForPagination(response.data)
                    }, (error) => {
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    })
                }
            },
            sortByAscDesc: function () {
                this.$store.state[this.axiosParams.module].busy = true
                let tableNames = {
                    'Invoice': {'columnTableName': 'idInChildTable', 'tableName': 'invoices', 'childClassName': '\\Invoice', 'foreignKey': 'order_id'},
                    'Family': {'columnTableName': 'idInChildTable', 'tableName': 'families', 'childClassName': '\\Family', 'foreignKey': 'order_id'},
                    'Order Status': {'columnTableName': 'idNotInChildOrParentTable', 'tableName': 'order_statuses', 'childClassName': '\\OrderStatus', 'foreignKey': 'order_status_id'},
                    'Order Type': {'columnTableName': 'idNotInChildOrParentTable', 'tableName': 'order_types', 'childClassName': '\\OrderType', 'foreignKey': 'order_type_id'},
                    'Paper Location': {'columnTableName': 'idNotInChildOrParentTable', 'tableName': 'paper_location', 'childClassName': '\\PaperLocation', 'foreignKey': 'paper_location_id'},
                    'Order': {'columnTableName': 'idInParentTable', 'foreignKey': 'order_id', 'childClassName': '\\Order'},
                    'Collaboration': {'columnTableName': 'collaboration', 'childClassName': ''}
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
                    this.columnTableName = 'collaboration';
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
                this.columnTableName = 'collaboration'
                for (let objects of Object.values(this.queryFields)) {
                    for (let obj of objects) {
                        obj.operator = 'like';
                        obj.value = '';
                    }
                }
                this.orderDate = null
                this.closeDate = null
                this.shipDate = null
                this.promisedDate = null
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
                    id: 'cemetery-toast',
                    title: params.title,
                    variant: params.variant,
                    toaster: 'b-toaster-top-center',
                    autoHideDelay: params.duration ? params.duration : 2000,
                    noAutoHide: this.toastHider,
                    noCloseButton: true,
                })
                this.saveDisabled = false;

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

    .input-md {
        width: 20rem;
    }

    .bootstrap-vue-table {
        min-height: 80vh;
    }
</style>
