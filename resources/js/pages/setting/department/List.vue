<template>
    <div>
        <h5 class="mx-2 my-1 custom-view-heading">Department List</h5>
        <div class="bg-toolbar my-2 p-1">
            <div class="d-flex justify-content-end align-items-center">
                <div class="d-flex m-auto">
                    <router-link class="btn custom-infobtn-list custom-infobtn-list-text" to="/department" v-if="isCreatePermitted">Add Department</router-link>
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
                            <template #head(index)="data">
                                <hr class="border">
                                <span class="ml-2 mr-1 custom-table-heading">{{data.label}}</span>
                            </template>
                            <template #head()="data">
                                <div class="d-flex mx-1 custom-input-header">
                                    <div class="mx-1 btn-group">
                                        <select @change="filterRecords(1)" class="form-control-sm rounded-0 border bg-light" v-model="queryFields[data.field.parent].find(item => item.column == data.column).operator">
                                            <option selected title="Equals To" v-b-tooltip.hover value="like">=</option>
                                            <option title="Not Equals to" v-b-tooltip.hover value="not like"><></option>
                                        </select>
                                        <input @input="debounce" @keyup.enter="filterRecords(1)" class="form-control-sm border rounded-0 custom-input-width" placeholder="Search here..."
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
                                <span class="custom-table-body ml-1"> {{(data.index + 1) + ((pageCurrentPage-1) * pagePerPage) }} </span>
                            </template>
                            <template #cell(action)="data">
                                <div class="mx-1 custom-input-header">
                                    <b-button @click="setViewRecord(data.item.id)" class="btn mx-1 py-1 custom-view-btn custom-view-text" v-b-modal.view-modal v-if="isReadPermitted">View</b-button>
                                    <router-link :to="'department/' + data.item.id" class="btn mx-1 py-1 custom-edit-btn custom-edit-text" v-if="isUpdatePermitted">Edit</router-link>
                                    <a @click="deleteRecord(data.item.id)" class="btn mx-1 py-1 custom-delete-btn custom-delete-text" href="javascript:void(0)" v-if="isDeletePermitted">Delete</a>
                                </div>
                            </template>
                        </b-table>
                        <Modal :module="'Department'" :recordID="viewRecord" :title="'Department'"></Modal>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {deleteRecord, fetchPaginateRecord, filterRecords} from '../../../helpers/axios';
    import Modal from '../../../Modules/Modal';
    import {debounce} from "../../../helpers/common";

    export default {
        name: "List",
        data() {
            return {
                sortByColumn: 'id',
                sortByDesc: false,
                columnTableName: 'department',
                foreignKey: '',
                childClassName: '',
                childTableName: '',
                sortDirection: 'desc',
                pageCurrentPage: 1,
                pageTotalRows: 1,
                pagePerPage: 1,
                pageFrom: 1,
                pageTo: 1,
                currentPage: 1,
                perPage: 10,
                viewRecord: 1,
                tableFields: [
                    {key: 'index', label: 'Index', thClass: 'px-0', tdClass: '', parent: "custom"},
                    {key: 'action', label: 'Action', parent: "custom", thClass: "px-0", tdClass: 'flexClass'}
                ],
                queryFields: {},
                axiosParams: {module: 'department'},
            }
        },
        metaInfo() {
            return {
                title: `Department List`,
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

                return this.$store.getters.getDepartmentTableData;
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
                        let showColumn = displayCounter > 3 ? 'd-none' : '';
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
                return this.$store.getters.isPermitted({resource: 'Setting', action: 'read'});
            },
            isCreatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Setting', action: 'create'});
            },
            isUpdatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Setting', action: 'update'});
            },
            isDeletePermitted() {
                return this.$store.getters.isPermitted({resource: 'Setting', action: 'delete'});
            },
        },
        components: {
            Modal
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Setting', action: 'read'}))
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
                            let params = {module: 'collaboration', detail: 'department', id: this.axiosParams.id}
                            this.$store.dispatch('removeDetailFromList', params);
                        } else {
                            console.log(response.data);
                        }
                    }, (error) => {
                            this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    })
                }
            },
            filterRecords: async function (pageNo) {
                this.$store.state[this.axiosParams.module].busy = true;
                this.$store.state[this.axiosParams.module].isFiltered = true;
                let formData = new FormData();
                for (let key in this.queryFields) {
                    formData.append(key, JSON.stringify(this.queryFields[key]));
                }
                let queryData = [{
                    'sortDirection': this.sortDirection,
                    'columnTableName': this.columnTableName,
                    'sortByColumn': this.sortByColumn,
                    'pagePerPage': this.pagePerPage,
                }]
                formData.append('queryData', JSON.stringify(queryData));
                this.axiosParams.filterData = formData;
                this.axiosParams.page = pageNo;
                await filterRecords(this.axiosParams, (response) => {
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
            sortByAscDesc: function () {
                this.$store.state[this.axiosParams.module].busy = true
                let tableNames = {
                    'Department': {'columnTableName': 'equipment', 'childClassName': ''}
                };
                let findParent = this.tableFields.find(obj => obj.key == this.sortByColumn)
                if (this.sortByColumn != 'id' && tableNames[findParent.parent]) {
                    this.columnTableName = tableNames[findParent.parent].columnTableName;
                    this.childClassName = tableNames[findParent.parent].childClassName;
                } else {
                    this.columnTableName = 'department';
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
                this.columnTableName = 'department'
                for (let objects of Object.values(this.queryFields)) {
                    for (let obj of objects) {
                        obj.operator = 'like';
                        obj.value = '';
                    }
                }
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

</style>
