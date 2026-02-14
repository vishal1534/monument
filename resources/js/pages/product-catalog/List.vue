<template>
    <div>
        <h5 class="mx-2 my-1 custom-view-heading">All Product List</h5>
        <div class="bg-toolbar my-2 p-1">
            <div class="d-flex justify-content-end align-items-center">
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
                            <b-dropdown
                                class="m-2 custom-choose-btn d-none "
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
                                <button @click="filterRecords" class="btn btn-sm btn-info my-auto px-3 custom-search-btn custom-search-text" data-placement="bottom" data-toggle="tooltip" title="Apply filters">Search</button>
                                <button :class="['btn btn-sm custom-clear-btn custom-clear-text my-auto px-3 mx-3', {'btn-danger': this.$store.state[this.axiosParamsCatalog.module].isFiltered}]" :disabled="!this.$store.state[this.axiosParamsCatalog.module].isFiltered" @click="clearFilter">Clear Filter</button>
                                <b-pagination
                                    :per-page="pagePerPage"
                                    :total-rows="rows"
                                    align="right"
                                    aria-controls="data-table"
                                    class="my-auto ml-2"
                                    size="sm"
                                    v-model="currentPage"
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
                            <label class="ml-auto custom-record-showing">Showing {{(currentPage*pagePerPage) - (pagePerPage-1)}} to {{rows < 10 || currentPage*pagePerPage > rows ? rows : currentPage*pagePerPage}} of {{rows}} records</label>
                        </div>
                        <b-table :busy="isBusy" :current-page="currentPage" :fields="tableFields" :items="tableData" :per-page="pagePerPage"
                                 bordered class="my-table bootstrap-vue-table a"
                                 hover id="data-table" no-footer-sorting responsive small striped>
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
                            <template #cell(product_cost)="data">
                                <span class="custom-table-body ml-1"> $ {{ data.item.product_cost ? convertDecimal(data.item.product_cost) : '0.00' }}</span>
                            </template>
                            <template #cell(selling_price)="data">
                                <span class="custom-table-body ml-1"> $ {{ data.item.selling_price ? convertDecimal(data.item.selling_price) : '0.00' }}</span>
                            </template>
                            <template #cell(action)="data">
                                <div class="mx-1 custom-input-header">
                                    <b-button @click="setViewRecord(data.item.id, data.item.product_type)" class="btn mx-1 py-1 custom-view-btn custom-view-text" v-b-modal.view-modal>View</b-button>
                                    <template v-if="data.item.product_type == 'Monument'">
                                        <router-link :to="'monuments/' + data.item.id" class="btn mx-1 py-1 custom-edit-btn custom-edit-text">Edit</router-link>
                                    </template>
                                    <template v-else-if="data.item.product_type == 'Simple'">
                                        <router-link :to="'simples/' + data.item.id" class="btn mx-1 py-1 custom-edit-btn custom-edit-text">Edit</router-link>
                                    </template>
                                    <template v-else-if="data.item.product_type == 'Service'">
                                        <router-link :to="'services/' + data.item.id" class="btn mx-1 py-1 custom-edit-btn custom-edit-text">Edit</router-link>
                                    </template>
                                    <template v-else-if="data.item.product_type == 'Composite'">
                                        <router-link :to="'composites/' + data.item.id" class="btn mx-1 py-1 custom-edit-btn custom-edit-text">Edit</router-link>
                                    </template>
                                </div>
                            </template>
                        </b-table>
                        <template v-if="productType == 'Monument'">
                            <Modal :module="'Monument'" :recordID="viewRecord" :title="'Monument'"></Modal>
                        </template>
                        <template v-else-if="productType == 'Simple'">
                            <Modal :module="'Simple'" :recordID="viewRecord" :title="'Simple'"></Modal>
                        </template>
                        <template v-else-if="productType == 'Service'">
                            <Modal :module="'Service'" :recordID="viewRecord" :title="'Service'"></Modal>
                        </template>
                        <template v-else-if="productType == 'Composite'">
                            <Modal :module="'Composite'" :recordID="viewRecord" :title="'Composite'"></Modal>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {debounce} from "../../helpers/common";
    import Modal from '../../Modules/Modal'

    export default {
        name: "Product-Catalog",
        data() {
            return {
                pagePerPage: 10,
                currentPage: 1,
                perPage: 10,
                tableFields: [
                    {key: 'index', label: 'Index', thClass: 'px-0', tdClass: '', parent: "custom"},
                    {key: 'action', label: 'Action', parent: "custom", thClass: "px-0", tdClass: 'flexClass'}
                ],
                queryFields: {},
                axiosParams: {module: 'monument'},
                axiosParamsCatalog: {module: 'productCatalog'},
                axiosParamsService: {module: 'service'},
                axiosParamsSimple: {module: 'simple'},
                axiosParamsComposite: {module: 'composite'},
                currentRecord: [],
                viewRecord: 1,
                productType: 'Monument',
            }
        },
        metaInfo() {
            return {
                title: `All Product List`,
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
                this.$store.getters.sortByAlphaNumeric({'module': 'productCatalog', 'fieldName': 'product_number'});
                return this.$store.getters.getProductCatalogTableData;
            },
            isBusy() {
                return this.$store.state[this.axiosParamsCatalog.module].busy;
            },
            filterFields() {
                let filterObj = {};
                let displayCounter = 0;
                const showListColumn = ['product_type','product_number', 'item_name', 'product_cost'];
                const hideListColumn = ['total_on_hand'];
                for (const [key, value] of Object.entries(this.$store.state[this.axiosParamsCatalog.module].columnList)) {
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
                    {key: 'product_type', loc: 1},
                    {key: 'product_number', loc: 2},
                    {key: 'item_name', loc: 3},
                    {key: 'product_cost', loc: 4},
                    {key: 'action', loc: this.tableFields.length - 1},
                ];
                orderMap.forEach(objLoc => {
                    const index = this.tableFields.findIndex(obj => obj.key == objLoc.key);
                    this.tableFields.splice(objLoc.loc, 0, this.tableFields.splice(index, 1)[0]);
                })
                return filterObj;
            },
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Products', action: 'read'}))
                this.$router.push('/access-denied');
        },
        components: {
            Modal,
        },
        mounted() {
            this.getColumnList();
            this.getRecordList();
        },
        methods: {
            debounce: debounce(function () {
                this.filterRecords();
            }, 1000),
            /**
             * CRUD
             * */
            getColumnList: function () {
                if (this.$store.state[this.axiosParamsCatalog.module].columnList.length == 0) {
                    this.axiosParamsCatalog.column = 'catalogColumns';
                    this.$store.dispatch('getColumnList', this.axiosParamsCatalog);
                }
            },
            setViewRecord: function (id, type) {
                this.viewRecord = id;
                this.productType = type
            },
            getRecordList: function () {
                this.axiosParamsCatalog.method = 'info';
                this.$store.dispatch('getReportInfo', this.axiosParamsCatalog);
            },
            filterRecords: function () {
                this.$store.state[this.axiosParamsCatalog.module].busy = true;
                this.$store.state[this.axiosParamsCatalog.module].isFiltered = true;
                this.$store.state[this.axiosParamsCatalog.module].recordList = [];
                this.getDataForSearch('Monument', 'Monument', 'axiosParams', 'searchMonument')
                this.getDataForSearch('Monument', 'Service', 'axiosParamsService', 'searchService')
                this.getDataForSearch('Monument', 'Simple', 'axiosParamsSimple', 'searchSimple')
                this.getDataForSearch('Monument', 'Composite', 'axiosParamsComposite', 'searchComposite')
            },
            getRecord: function (value) {
                this.pagePerPage = value
            },
            getDataForSearch: function(parentKey, childKey, axiosName, searchBy){
                let formData = new FormData();
                for (let key in this.queryFields) {
                    this.queryFields[key].filter(obj => {
                        if (obj.operator == 'IS') {
                            obj.value = 'NULL'
                        } else if (obj.value == 'NULL') {
                            obj.value = ''
                        }
                    })
                    if (key == parentKey) {
                        formData.append(childKey, JSON.stringify(this.queryFields[key]));
                    } else {
                        formData.append(key, JSON.stringify(this.queryFields[key]));
                    }
                }
                this[axiosName].filterData = formData;
                this[axiosName].column = searchBy;
                this[axiosName].methodName = this.axiosParamsCatalog.module;
                this.$store.dispatch('getProductCatalogRecord', this[axiosName]);
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
                this.filterRecords();
                this.$store.state[this.axiosParamsCatalog.module].isFiltered = false;
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
