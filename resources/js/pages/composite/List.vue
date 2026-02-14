<template>
    <div>
        <h5 class="mx-2 my-1 custom-view-heading">Composite List</h5>
        <div class="bg-toolbar my-2 p-1">

            <div class="d-flex justify-content-end align-items-center">

                <div class="d-flex m-auto">
                    <router-link class="btn custom-infobtn-list custom-infobtn-list-text" to="/composites" v-if="isCreatePermitted">Add Composite</router-link>
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
                                <!--<b-pagination
                                        class="my-auto ml-2"
                                        v-model="currentPage"
                                        :total-rows="rows"
                                        :per-page="perPage"
                                        size="sm"
                                        align="right"
                                        aria-controls="data-table"
                                ></b-pagination>-->
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
                                <b-form-select size="sm"
                                               class="input-list-md form-control-sm rounded-0 my-1 mx-3"
                                               :options="perPageRecordList"
                                               v-model="getSelected"
                                               @change="getRecord">
                                    <template #first>
                                        <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                                    </template>
                                </b-form-select>
                            </div>
                        </div>

                        <div class="d-flex">
                            <label class="ml-auto custom-record-showing">Showing {{pageFrom}} to {{pageTo}} of {{pageTotalRows}} records</label>
                            <!--                            <label class="ml-auto custom-record-showing">Showing {{(currentPage*perPage) - (perPage-1)}} to {{rows < 10 || currentPage*perPage > rows ? rows : currentPage*perPage}} of {{rows}} records</label>-->
                        </div>
                        <!--                        @sort-changed="sortByAscDesc"-->
                        <b-table :busy="isBusy" :current-page="currentPage" :fields="tableFields" :items="tableData" :no-local-sorting="true" :per-page="pagePerPage"
                                 :sort-by.sync="sortByColumn"
                                 :sort-desc.sync="sortByDesc"
                                 bordered class="my-table bootstrap-vue-table a"
                                 hover
                                 id="data-table"
                                 responsive
                                 small
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
                            <template #head(image)="data">
                                <div class="d-flex mx-1 custom-input-header">
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

                            <template #cell(index)="data">
                                <!--   <span class="custom-table-body ml-1"> {{ (data.index + 1) + ((currentPage-1) * perPage)}}</span>-->
                                <span class="custom-table-body ml-1"> {{ (data.index + 1) + ((pageCurrentPage-1) * pagePerPage)}}</span>
                            </template>

                            <template #cell(image)="data">
                                <img :src="`images/composite/${data.value}`" class="ml-1" height="38" v-if="data.value !=''" width="58"/>
                            </template>

                            <!--<template #cell(install_price)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.install_price }}</span>
                            </template>-->

                            <template v-slot:cell(install_price)="row">
                                <span class="custom-table-body ml-1">$ {{ row.item.install_price }}</span>
                            </template>

                            <template v-slot:cell(retail_price)="row">
                                <span class="custom-table-body ml-1">$ {{ row.item.retail_price }}</span>
                            </template>

                            <template v-slot:cell(final_price)="row">
                                <span class="custom-table-body ml-1">$ {{ row.item.final_price }}</span>
                            </template>

                            <template v-slot:cell(price)="row">
                                <span class="custom-table-body ml-1">$ {{ row.item.price }}</span>
                            </template>

                            <template #cell(action)="data">
                                <div class="mx-1 custom-input-header">
                                    <b-button @click="setViewRecord(data.item.id)" class="btn mx-1 py-1 custom-view-btn custom-view-text" v-b-modal.view-modal v-if="isReadPermitted">View</b-button>
                                    <router-link :to="'composites/' + data.item.id" class="btn mx-1 py-1 custom-edit-btn custom-edit-text" v-if="isUpdatePermitted">Edit</router-link>
                                    <a @click="deleteRecord(data.item.id)" class="btn mx-1 py-1 custom-delete-btn custom-delete-text" href="javascript:void(0)" v-if="isDeletePermitted">Delete</a>
                                </div>
                            </template>

                        </b-table>

                        <Modal :module="'Composite'" :recordID="viewRecord" :title="'Composite'"></Modal>

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
        name: "List",
        data() {
            return {
                sortByColumn: 'product_number',
                sortByDesc: false,
                tableColumnName: null,
                columnTableName: 'composite',
                foreignKey: '',
                childClassName: '',
                sortDirection: 'asc',
                pageCurrentPage: 1,
                pageTotalRows: 1,
                pagePerPage: 1,
                pageFrom: 1,
                pageTo: 1,
                currentPage: 1,
                perPage: 10,
                viewRecord: 1, // contains the id of the record that will be shown in modal
                tableFields: [
                    {key: 'index', label: 'Index', thClass: 'px-0', tdClass: '', parent: "custom"},
                    {key: 'action', label: 'Action', parent: "custom", thClass: "px-0", tdClass: 'flexClass'}
                ],// Table requires data in form of array
                queryFields: {},
                axiosParams: {module: 'composite'},
            }
        },
        metaInfo() {
            return {
                title: `Composite List`,
            }
        },
        computed: {
            rows() {
                return this.tableData.length
            },
            tableData() {
                //this.$store.getters.sortByAlphaNumeric({'module': 'composite', 'fieldName': 'product_number'});
                if (this.$store.state[this.axiosParams.module].recordList.length)
                    this.$store.getters.getInstallationPrice(this.$store.state[this.axiosParams.module].recordList);
                return this.$store.getters.getCompositeTableData;
            },
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
            isBusy() {
                return this.$store.state[this.axiosParams.module].busy;
            },
            filterFields() {
                let filterObj = {};
                let displayCounter = 0;

                for (const [key, value] of Object.entries(this.$store.state[this.axiosParams.module].columnList)) {

                    // Capitalizing first letter of each word for key e.g(monument => Monument)
                    let customKey = this.customizeLabel(key);
                    let objArray = [];
                    for (let val of value) {
                        let showColumn = displayCounter > 3 ? 'd-none' : '';// Only show first 4 columns by default
                        if (val == 'install_price') {
                            showColumn = '';
                        }
                        // Removing underscore & capitalizing first letter of each word for label e.g(item_name => Item Name)
                        let label = this.customizeLabel(val);
                        if (val == 'price') {
                            label = 'Selling Price';
                        } else if (val == 'install_price') {
                            label = "Installation Price";
                        }
                        let obj = {key: val, label: label, parent: customKey, sortable: true, thClass: `px-0 ${showColumn}`, tdClass: showColumn};
                        objArray.push(obj);
                        displayCounter++;
                    }

                    filterObj[customKey] = objArray;
                }
                // Convert all array of objects to a single array of objects (For Table fields)

                for (let objects of Object.entries(filterObj)) {
                    let key = objects[0];
                    let values = objects[1];
                    let queryObjArray = [];
                    for (let obj of values) {
                        this.tableFields.splice(this.tableFields.length - 1, 0, obj); // Pushing objects in array before Action fields (index & action fields are pre-added in array)
                        // this.$set(this.queryFields, obj.key, {operator:'', value:''});
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
            this.getColumnList();
            this.getRecordList();
        },
        beforeMount() {
            this.$store.state[this.axiosParams.module].recordList = []
        },
        methods: {
            debounce: debounce(function () {
                this.filterRecords(1);
            }, 500),
            /**
             * CRUD
             * */
            getPaginatedRecord: function () {
                this.$store.state[this.axiosParams.module].busy = true
                setTimeout(() => {
                    this.filterRecords(this.pageCurrentPage)
                }, 500);
            },
            getColumnList: function () {
                if (this.$store.state[this.axiosParams.module].columnList.length == 0) {
                    this.$store.dispatch('getColumnList', this.axiosParams);
                }
            },
            getRecordList: function () {
                //if (this.$store.state[this.axiosParams.module].recordList.length == 0){
                // this.$store.dispatch('getModuleInfo', this.axiosParams);
                // }
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
            deleteRecord: function (id) {

                if (confirm("Do you really want to delete this record?")) {
                    this.$store.state[this.axiosParams.module].busy = true;
                    this.axiosParams.id = id;

                    deleteRecord(this.axiosParams, (response) => {
                        if (response.data) {
                            this.filterRecords(this.pageCurrentPage);
                            this.$store.dispatch('removeRecordFromList', this.axiosParams);
                            //after deletion of product get update quote and order products
                            /*this.$store.dispatch('getModuleInfo', {module:'order'});
                            this.$store.dispatch('getModuleInfo', {module:'quote'});
                             this.$store.state[this.axiosParams.module].busy = false;
                            this.$store.dispatch('removeFromList', this.axiosParams);*/
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
            filterRecords: function (pageNo) {
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
                let queryData = [{
                    'sortDirection': this.sortDirection,
                    'columnTableName': this.columnTableName,
                    'childClassName': this.childClassName,
                    'foreignKey': this.foreignKey,
                    'sortByColumn': this.sortByColumn,
                    'pagePerPage': this.pagePerPage,
                }]
                formData.append('queryData', JSON.stringify(queryData));
                this.axiosParams.filterData = formData;
                this.axiosParams.page = pageNo;
                // this.$store.dispatch('getFilteredRecords', this.axiosParams);
                filterRecords(this.axiosParams, (response) => {
                    this.setDataForPagination(response.data)
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            sortByAscDesc: function () {
                this.$store.state[this.axiosParams.module].busy = true

                let tableNames = {
                    'Category': {'columnTableName': 'idInParentTable', 'foreignKey': 'category_id', 'childClassName' : '\\CompositeCategory'},
                    'Composite': {'columnTableName': 'composite', 'childClassName' : ''}
                };
                let findParent = this.tableFields.find(obj => obj.key == this.sortByColumn)
                if (tableNames[findParent.parent]) {
                    this.columnTableName = tableNames[findParent.parent].columnTableName;
                    this.childClassName = tableNames[findParent.parent].childClassName;
                    if (tableNames[findParent.parent].foreignKey) {
                        this.foreignKey = tableNames[findParent.parent].foreignKey;
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
                this.columnTableName = 'composite'
                for (let objects of Object.values(this.queryFields)) {
                    for (let obj of objects) {
                        obj.operator = 'like';
                        obj.value = '';
                    }
                }
                this.filterRecords(1);
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
                // Remove underscore and capitalize first letter of each word
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
                this.saveDisabled = false;//enabling save button

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
<style>
    .flexClass {
        display: flex;
    }
</style>
