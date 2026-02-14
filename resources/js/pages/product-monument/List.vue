<template>
    <div>
        <template v-if="!getTitleOfPage">
            <h5 class="mx-2 my-1 custom-view-heading">Monument List</h5>
        </template>
        <template v-else-if="getTitleOfPage">
            <h5 class="mx-2 my-1 custom-view-heading">Price Estimator List</h5>
        </template>
        <div class="bg-toolbar my-2 p-1">
            <div class="d-flex justify-content-end align-items-center">
                <template v-if="!getTitleOfPage">
                    <div class="d-flex m-auto">
                        <router-link class="btn custom-infobtn-list custom-infobtn-list-text" to="/monuments" v-if="isCreatePermitted">Add Monument</router-link>
                    </div>
                </template>
                <template v-else-if="getTitleOfPage">
                    <div class="d-flex m-auto">
                        <router-link class="btn custom-infobtn-list custom-infobtn-list-text" to="/price-estimator" v-if="isCreatePermitted">Add New Price Estimation</router-link>
                    </div>
                </template>
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
                            <template #head(image)="data">
                                <div class="d-flex mx-1 custom-input-header">
                                </div>
                                <hr class="border">
                                <span class="ml-2 mr-1 custom-table-heading">{{ data.label }}</span>
                            </template>
                            <template #head(selling_price_with_installation)="data">
                                <div class="d-flex mx-1 custom-date-header">
                                    <div class="btn-group">
                                        <select @change="filterRecords(1)" class="form-control-sm rounded-0 border bg-light" v-model="queryFields[data.field.parent].find(item => item.column == data.column).operator = 'like'">
                                            <option title="Equals To" v-b-tooltip.hover value="=">=</option>
                                            <option title="Empty" v-b-tooltip.hover value="IS">=''</option>
                                            <option title="Not Equals to" v-b-tooltip.hover value="!="><></option>
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
                            <template #cell(image)="data">
                                <img :src="`images/monuments/${data.value}`" class="ml-1" height="38" v-if="data.value !=''" width="58"/>
                            </template>
                            <template #cell(index)="data">
                                <span class="custom-table-body ml-1"> {{ (data.index + 1) + ((pageCurrentPage-1) * pagePerPage)}}</span>
                            </template>
                            <template #cell(product_cost)="data">
                                <span class="custom-table-body ml-1"> $ {{ data.item.product_cost ? convertDecimal(data.item.product_cost) : '0.00' }}</span>
                            </template>
                            <template #cell(override_selling_price)="data">
                                <span class="custom-table-body ml-1"> $ {{ data.item.override_selling_price ?  convertDecimal(data.item.override_selling_price) : '0.00' }}</span>
                            </template>
                            <template #cell(selling_price)="data">
                                <span class="custom-table-body ml-1"> $ {{ data.item.selling_price ? convertDecimal(data.item.selling_price) : '0.00' }}</span>
                            </template>
                            <template #cell(selling_price_with_installation)="data">
                                <span class="custom-table-body ml-1"> $ {{ data.item.selling_price_with_installation ? convertDecimal(data.item.selling_price_with_installation) : '0.00' }}</span>
                            </template>
                            <template #cell(special_shape_cost)="data">
                                <span class="custom-table-body ml-1"> $ {{ data.item.special_shape_cost ? convertDecimal(data.item.special_shape_cost) : '0.00' }}</span>
                            </template>
                            <template #cell(cost)="data">
                                <span class="custom-table-body ml-1"> $ {{ data.item.cost ? convertDecimal(data.item.cost) : '0.00' }}</span>
                            </template>
                            <template #cell(total_cost_with_freight)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.total_cost_with_freight ? convertDecimal(data.item.total_cost_with_freight) : '0.00' }}</span>
                            </template>
                            <template #cell(price)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.polish ? convertDecimal(data.item.polish.price) : '0.00' }}</span>
                            </template>
                            <template #cell(engrave_back_total_price)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.engrave ? convertDecimal(data.item.engrave.engrave_back_total_price) : '0.00' }}</span>
                            </template>
                            <template #cell(engrave_premium_cost)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.engrave ? convertDecimal(data.item.engrave.engrave_premium_cost) : '0.00' }}</span>
                            </template>
                            <template #cell(engrave_front_total_price)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.engrave ? convertDecimal(data.item.engrave.engrave_front_total_price) : '0.00' }}</span>
                            </template>
                            <template #cell(product_min_install_price)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.installation ? convertDecimal(data.item.installation.product_min_install_price) : '0.00' }}</span>
                            </template>
                            <template #cell(installation_price)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.installation ? convertDecimal(data.item.installation.installation_price) : '0.00' }}</span>
                            </template>
                            <template #cell(installation_amount)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.installation ? convertDecimal(data.item.installation.installation_amount) : '0.00' }}</span>
                            </template>
                            <template #cell(freight_cost_per_100_lb)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.freight ? convertDecimal(data.item.freight.freight_cost_per_100_lb) : '0.00' }}</span>
                            </template>
                            <template #cell(freight_cost)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.freight ? convertDecimal(data.item.freight.freight_cost) : '0.00' }}</span>
                            </template>
                            <template #cell(freight_amount)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.freight ? convertDecimal(data.item.freight.freight_amount) : '0.00' }}</span>
                            </template>
                            <template #cell(tariff_amount)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.freight ? convertDecimal(data.item.freight.tariff_amount) : '0.00' }}</span>
                            </template>
                            <template #cell(action)="data">
                                    <div class="mx-1 custom-input-header">
                                        <b-button @click="setViewRecord(data.item.id)" class="btn mx-1 py-1 custom-view-btn custom-view-text" v-b-modal.view-modal v-if="isReadPermitted">View</b-button>
                                        <template v-if="!getTitleOfPage">
                                            <router-link :to="'monuments/' + data.item.id" class="btn mx-1 py-1 custom-edit-btn custom-edit-text" v-if="isUpdatePermitted">Edit</router-link>
                                        </template>
                                        <template v-else-if="getTitleOfPage">
                                            <router-link :to="'price-estimator/' + data.item.id" class="btn mx-1 py-1 custom-edit-btn custom-edit-text" v-if="isUpdatePermitted">Edit</router-link>
                                        </template>
                                        <a @click="deleteRecord(data.item.id)" class="btn mx-1 py-1 custom-delete-btn custom-delete-text" href="javascript:void(0)" v-if="isDeletePermitted">Delete</a>
                                    </div>
                            </template>
                        </b-table>
                        <template v-if="!getTitleOfPage">
                            <Modal :module="'Monument'" :recordID="viewRecord" :title="'Monument'"></Modal>
                        </template>
                        <template v-else-if="getTitleOfPage">
                            <Modal :module="'Monument'" :recordID="viewRecord" :title="'Price Estimator'"></Modal>
                        </template>
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

    export default {
        name: "Monument-List",
        data() {
            return {
                sortByColumn: 'product_number',
                sortByDesc: false,
                tableColumnName: null,
                columnTableName: 'monument',
                foreignKey: '',
                childClassName: '',
                childTableName: '',
                sortDirection: 'asc',
                currentPage: 1,
                pageCurrentPage: 1,
                pageTotalRows: 1,
                pagePerPage: 1,
                pageFrom: 1,
                pageTo: 1,
                perPage: 10,
                viewRecord: 1,
                currentURL: null,
                tableFields: [
                    {key: 'index', label: 'Index', thClass: 'px-0', tdClass: '', parent: "custom"},
                    {key: 'action', label: 'Action', parent: "custom", thClass: "px-0", tdClass: 'flexClass'}
                ],
                queryFields: {},
                axiosParams: {module: 'monument'},
            }
        },
        metaInfo() {
            if (this.$route.path == '/price-estimator-list'){
                return {
                    title: `Price Estimator List`,
                }
            }else{
                return {
                    title: `Monument List`,
                }
            }
        },
        computed: {
            rows() {
                return this.tableData.length
            },
            tableData() {
                return this.$store.getters.getMonumentTableData;
            },
            perPageRecordList() {
                return this.$store.state.listNumberOfRecord.recordList;
            },
            isBusy() {
                return this.$store.state[this.axiosParams.module].busy;
            },
            filterFields() {
                let filterObj = {};
                let displayCounter = 0;
                const removePriceColumns = ['price_estimator','product_number']
                const removeMonumentColumns = ['quote_id','reference_id', 'price_estimator']
                let monumentColumn = this.$store.state[this.axiosParams.module].columnList;
                if (monumentColumn.monument) {
                    monumentColumn.monument = monumentColumn.monument.filter(column => {
                        if (this.currentURL === '/monuments-list') {
                            if (!removeMonumentColumns.includes(column))
                                return column
                        } else {
                            if (!removePriceColumns.includes(column))
                                return column
                        }
                    });
                }
                for (const [key, value] of Object.entries(this.$store.state[this.axiosParams.module].columnList)) {
                    let customKey = this.customizeLabel(key);
                    let objArray = [];
                    for (let val of value) {
                        let showColumn = displayCounter > 3 ? 'd-none' : '';
                        if (this.currentURL == '/price-estimator-list'){
                            if (val == 'cost' || val == 'description' || val == 'gi_misc_note' || val == 'gi_misc_note_a' || val == 'total_on_hand' || val=='total_sold') {
                                showColumn = 'd-none';
                            }
                            if (val == 'item_name' || val == 'quote_id' || val == 'product_cost') {
                                showColumn = '';
                            }
                        }else{
                            if (val == 'cost' || val == 'description' || val == 'gi_misc_note' || val == 'gi_misc_note_a') {
                                showColumn = 'd-none';
                            }
                            if (val == 'product_number' || val == 'item_name' || val == 'product_cost' || val == 'override_selling_price' || val == 'total_on_hand') {
                                showColumn = '';
                            }
                        }
                        let label = this.customizeLabel(val);
                        if (this.currentURL == '/price-estimator-list'){
                            if (val == 'quote_id'){
                                label = 'Quote #'
                            }else if (val == 'item_name'){
                                label = 'Product Name'
                            }
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
                return filterObj;
            },
            isReadPermitted() {
                return this.$store.getters.isPermitted({resource: 'Products', action: 'read'});
            },
            isCreatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Products', action: 'create'});
            },
            isUpdatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Products', action: 'update'});
            },
            isDeletePermitted() {
                return this.$store.getters.isPermitted({resource: 'Products', action: 'delete'});
            },
            getSelected: {
                get() {
                    return this.pagePerPage
                },
                set(value) {
                    return value
                },
            },
            getTitleOfPage() {
                this.currentURL = this.$route.path
                this.$route.path == '/price-estimator-list' ? this.columnTableName = 'estimator' : ''
                return this.$route.path == '/price-estimator-list'
            },
        },
        components: {
            Modal
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Products', action: 'read'}))
                this.$router.push('/access-denied');
        },
        mounted() {
            this.$store.state[this.axiosParams.module].busy = true
            this.$store.state[this.axiosParams.module].columnList = []
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
                    this.$store.dispatch('getColumnList', this.axiosParams);
            },
            getRecordList: function () {
                let estimator = null
                this.currentURL == '/price-estimator-list' ? estimator = 'priceEstimator' : estimator = 'monument'
                fetchPaginateRecord({
                    module: this.axiosParams.module, apiURL: 'paginateRecord',
                    page: this.pageCurrentPage, estimator: estimator
                }, (response) => {
                    this.setDataForPagination(response.data)
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            getPaginatedRecord: async function () {
                this.$store.state[this.axiosParams.module].busy = true
                setTimeout(() => {
                    this.filterRecords(this.pageCurrentPage)
                }, 500);

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
            deleteRecord: function (id) {

                if (confirm("Do you really want to delete this record?")) {
                    this.$store.state[this.axiosParams.module].busy = true;
                    this.axiosParams.id = id;
                    deleteRecord(this.axiosParams, (response) => {
                        if (response.data) {
                            this.$store.dispatch('removeRecordFromList', this.axiosParams);
                            this.filterRecords(this.pageCurrentPage);
                        } else {
                            console.log(response.data);
                        }
                    }, (error) => {
                        if (error.response.status == 403) {
                            this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                        }
                    })
                }
            },
            filterRecords: async function (pageNo) {
                this.$store.state[this.axiosParams.module].busy = true;
                this.$store.state[this.axiosParams.module].isFiltered = true;
                let formData = new FormData();
                for (let key in this.queryFields) {
                    this.queryFields[key].filter(obj => {
                        if (obj.operator == 'IS') {
                            obj.value = 'NULL'
                        } else if (obj.value == 'NULL') {
                            obj.value = ''
                        }
                    })
                    formData.append(key, JSON.stringify(this.queryFields[key]));
                }
                formData.append('sortDirection', this.sortDirection);
                formData.append('sortByColumn', this.sortByColumn);
                formData.append('columnTableName', this.columnTableName);
                formData.append('foreignKey', this.foreignKey);
                formData.append('childClassName', this.childClassName);
                formData.append('childTableName', this.childTableName);
                formData.append('pagePerPage', this.pagePerPage);
                this.axiosParams.filterData = formData;
                this.axiosParams.page = pageNo;
                await filterRecords(this.axiosParams, (response) => {
                    this.setDataForPagination(response.data)
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            sortByAscDesc: function () {
                this.$store.state[this.axiosParams.module].busy = true
                let tableNames = {
                    'Specification': {'columnTableName': 'idInChildTable', 'tableName': 'product_specifications', 'childClassName': '\\ProductSpecification'},
                    'Polish': {'columnTableName': 'idInChildTable', 'tableName': 'product_polishes', 'childClassName': '\\ProductPolish'},
                    'Engrave': {'columnTableName': 'idInChildTable', 'tableName': 'product_engraves', 'childClassName': '\\ProductEngrave'},
                    'Freight': {'columnTableName': 'idInChildTable', 'tableName': 'product_freights', 'childClassName': '\\ProductFreight'},
                    'Installation': {'columnTableName': 'idInChildTable', 'tableName': 'product_installation', 'childClassName': '\\ProductInstallation'},
                    'Shape': {'columnTableName': 'idInParentTable', 'foreignKey': 'shape_id', 'childClassName': '\\ProductShape'},
                    'Side': {'columnTableName': 'idInParentTable', 'foreignKey': 'side_id', 'childClassName': '\\ProductSide'},
                    'Color': {'columnTableName': 'idInParentTable', 'foreignKey': 'color_id', 'childClassName': '\\ProductColor'},
                    'Type': {'columnTableName': 'idInParentTable', 'foreignKey': 'type_id', 'childClassName': '\\ProductType'},
                    'Monument': {'columnTableName': 'monument', 'childClassName': ''}
                };

                let estimatorTableNames = {
                    'Specification': {'columnTableName': 'idInSubTable', 'tableName': 'product_specifications', 'childClassName': '\\ProductSpecification'},
                    'Polish': {'columnTableName': 'idInSubTable', 'tableName': 'product_polishes', 'childClassName': '\\ProductPolish'},
                    'Engrave': {'columnTableName': 'idInSubTable', 'tableName': 'product_engraves', 'childClassName': '\\ProductEngrave'},
                    'Freight': {'columnTableName': 'idInSubTable', 'tableName': 'product_freights', 'childClassName': '\\ProductFreight'},
                    'Installation': {'columnTableName': 'idInSubTable', 'tableName': 'product_installation', 'childClassName': '\\ProductInstallation'},
                    'Shape': {'columnTableName': 'idInLinkedTable', 'foreignKey': 'shape_id', 'childClassName': '\\ProductShape'},
                    'Side': {'columnTableName': 'idInLinkedTable', 'foreignKey': 'side_id', 'childClassName': '\\ProductSide'},
                    'Color': {'columnTableName': 'idInLinkedTable', 'foreignKey': 'color_id', 'childClassName': '\\ProductColor'},
                    'Type': {'columnTableName': 'idInLinkedTable', 'foreignKey': 'type_id', 'childClassName': '\\ProductType'},
                    'Monument': {'columnTableName': 'estimator', 'childClassName': ''}
                };

                let findParent = this.tableFields.find(obj => obj.key == this.sortByColumn)
                if (this.currentURL == '/price-estimator-list') {
                    if (estimatorTableNames[findParent.parent]) {
                        this.columnTableName = estimatorTableNames[findParent.parent].columnTableName;
                        this.childClassName = estimatorTableNames[findParent.parent].childClassName;
                        if (estimatorTableNames[findParent.parent].foreignKey) {
                            this.foreignKey = estimatorTableNames[findParent.parent].foreignKey;
                        }
                        if (estimatorTableNames[findParent.parent].tableName) {
                            this.childTableName = estimatorTableNames[findParent.parent].tableName;
                        }
                    }
                } else if (tableNames[findParent.parent]) {
                    this.columnTableName = tableNames[findParent.parent].columnTableName;
                    this.childClassName = tableNames[findParent.parent].childClassName;
                    if (tableNames[findParent.parent].foreignKey) {
                        this.foreignKey = tableNames[findParent.parent].foreignKey;
                    }
                    if (tableNames[findParent.parent].tableName) {
                        this.childTableName = tableNames[findParent.parent].tableName;
                    }
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
                this.sortByColumn = 'product_number'
                this.sortDirection = 'asc'
                this.sortByDesc = false
                if (this.currentURL == '/price-estimator-list')
                    this.columnTableName = 'estimator'
                else
                    this.columnTableName = 'monument'
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
            convertDecimal: function (value) {
                value = (value).toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
                return value;
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
