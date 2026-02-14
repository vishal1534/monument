<template>
 <div>
     <h5 class="mx-2 my-1 custom-view-heading">Collaborator Type List</h5>
     <div class="bg-toolbar my-2 p-1">

         <div class="d-flex justify-content-end align-items-center">

             <div class="d-flex m-auto">
                 <router-link class="btn custom-infobtn-list custom-infobtn-list-text" to="/collaborator-types">Add Collaborator Type</router-link>
             </div>

             <div class="d-flex">
             </div>

             <div class="d-flex mx-2">
                <img class="mx-1 my-auto" src="/images/video-chat.png" width="26" height="26"/>
                 <img class="mx-1" src="/images/help-icon.png" width="30" height="30"/>
             </div>
         </div>

     </div>
     <div id="quote">

         <div class="row m-0">
             <div class="col-md-12">

                 <div class="quote-body p-3">

                     <div class="d-flex">
                         <b-dropdown
                             id="dropdown-form"
                             text="Choose Columns"
                             variant="info custom-choose-text"
                             ref="dropdown"
                             size="sm"
                             class="m-2 custom-choose-btn">

                             <b-dropdown-form class="overflow-auto scroll" style="height: 12vh;">

                                 <template v-for="(objects, key) of filterFields">
                                     <h6>{{key}}</h6>
                                     <b-form-group class="form-inline" v-for="(item, index) of objects"  :key="key + index" >
                                         <b-form-checkbox v-if="item.key != 'action'" v-on:change="toggleColumn(item)" :checked="!item.thClass.includes('d-none')" ><span class="custom-checkbox-margin">{{item.label}}</span></b-form-checkbox>
                                     </b-form-group>
                                 </template>


                             </b-dropdown-form>

                         </b-dropdown>

                         <div class="d-flex ml-auto">
                             <button class="btn btn-sm btn-info my-auto px-3 custom-search-btn custom-search-text" data-toggle="tooltip" data-placement="bottom" title="Apply filters" @click="filterRecords">Search</button>
                             <button :class="['btn btn-sm custom-clear-btn custom-clear-text my-auto px-3 mx-3', {'btn-danger': this.$store.state[this.axiosParams.module].isFiltered}]" :disabled="!this.$store.state[this.axiosParams.module].isFiltered" @click="clearFilter">Clear Filter</button>
                             <b-pagination
                                 class="my-auto ml-2"
                                 v-model="currentPage"
                                 :total-rows="rows"
                                 :per-page="perPage"
                                 size="sm"
                                 align="right"
                                 aria-controls="data-table"
                             ></b-pagination>
                         </div>
                     </div>

                     <div class="d-flex">
                         <label class="ml-auto custom-record-showing">Showing {{(currentPage*perPage) - (perPage-1)}} to {{rows < 10 || currentPage*perPage > rows ? rows : currentPage*perPage}} of {{rows}} records</label>
                     </div>

                     <b-table id="data-table" class="my-table bootstrap-vue-table a" striped hover responsive bordered small
                              :items="tableData"
                              :fields="tableFields"
                              :busy="isBusy"
                              :per-page="perPage"
                              :current-page="currentPage">

                         <template #table-busy>
                             <div class="text-center text-info my-2">
                                 <b-spinner class="align-middle"></b-spinner>
                                 <strong>Loading...</strong>
                             </div>
                         </template>


                         <template #head(action)="data">
                             <hr class="border"><span class="ml-3 mr-1 custom-table-heading">{{data.label}}</span>
                         </template>
                         <template #head(index)="data">
                             <hr class="border"><span class="ml-2 mr-1 custom-table-heading">{{data.label}}</span>
                         </template>

                         <template #head()="data">
                             <div class="d-flex mx-1 custom-input-header">
                                 <div class="mx-1 btn-group">
                                     <select class="form-control-sm rounded-0 border bg-light" @change="filterRecords" v-model="queryFields[data.field.parent].find(item => item.column == data.column).operator">
                                         <option value ="like" selected v-b-tooltip.hover title="Equals To">=</option>
                                            <option value ="IS" v-b-tooltip.hover title="Empty">=''</option>
                                         <option value ="not like" v-b-tooltip.hover title="Not Equals to"><></option>
                                         <option value =">" v-b-tooltip.hover title="Greater Than">></option>
                                         <option value ="<" v-b-tooltip.hover title="Less Than"><</option>
                                         <option value =">=" v-b-tooltip.hover title="Greater & Equals to">>=</option>
                                         <option value ="<=" v-b-tooltip.hover title="Less & Equals to"><=</option>
                                         <option value ="..." v-b-tooltip.hover title="Range">...</option>

                                     </select>
                                     <input type="text" class="form-control-sm border rounded-0 custom-input-width" placeholder="Search here..." @input="debounce" @keyup.enter="filterRecords" v-model="queryFields[data.field.parent].find(item => item.column == data.column).value"/>
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

                         <template #cell(action)="data" >
                             <div class="mx-1 custom-input-header">
                                 <b-button class="btn mx-1 py-1 custom-view-btn custom-view-text" v-if="isReadPermitted" v-b-modal.view-modal @click="setViewRecord(data.item.id)" >View</b-button>
                                 <router-link class="btn mx-1 py-1 custom-edit-btn custom-edit-text" v-if="isUpdatePermitted" :to="'collaborator-type/' + data.item.id" >Edit</router-link>
                                 <a class="btn mx-1 py-1 custom-delete-btn custom-delete-text" v-if="isDeletePermitted" href="javascript:void(0)" @click="deleteRecord(data.item.id)">Delete</a>
                             </div>
                         </template>

                     </b-table>

                     <Modal :module="'CollaboratorType'" :title="'Collaborator Type'" :recordID="viewRecord"></Modal>

                 </div>
             </div>
         </div>

     </div>

 </div>
</template>

<script>
    import {deleteRecord} from '../../helpers/axios';
    import Modal from '../../Modules/Modal';
    import {debounce} from "../../helpers/common";
    export default {
        name: "List",
        data() {
            return {
                currentPage:1,
                perPage:10,
                viewRecord: 1,
                tableFields:[
                    {key: 'index', label: 'Index', thClass : 'px-0', tdClass : '', parent: "custom"},
                    {key: 'action', label: 'Action', parent: "custom", thClass: "px-0", tdClass: 'flexClass'}
                ],
                queryFields: {},
                axiosParams: {module: 'collaboratorType'},
            }
        },
        metaInfo() {
            return {
                title: `Collaborator Type Info. List`,
            }
        },
        computed:{
            rows(){
                return this.tableData.length
            },
            tableData(){
                return this.$store.getters.getCollaboratorTypeTableData;
            },
            isBusy(){
                return this.$store.state[this.axiosParams.module].busy;
            },
            filterFields(){
                let filterObj = {};
                let displayCounter = 0;
                for (const [key, value] of Object.entries(this.$store.state[this.axiosParams.module].columnList)) {
                    let customKey = this.customizeLabel(key);
                    let objArray = [];
                    for (let val of value){
                        let showColumn = displayCounter > 3 ? 'd-none' : '';
                        let label = this.customizeLabel(val);

                        if(val == 'phone_2' || val == 'email_2' || val == 'contact_2') {
                            let labelArr = label.split(' ');
                            label = labelArr[0] + ' #2';
                        }
                        let obj = {key: val, label: label, parent: customKey, sortable: true, thClass : `px-0 ${showColumn}`, tdClass : showColumn};
                        objArray.push(obj);
                        displayCounter++;
                    }

                    filterObj[customKey] = objArray;
                }
                for (let objects of Object.entries(filterObj)){
                    let key = objects[0];
                    let values = objects[1];
                    let queryObjArray = [];
                    for (let obj of values){
                        this.tableFields.splice(this.tableFields.length - 1, 0, obj);
                        let queryObj = {column: obj.key, operator:'like', value:''};
                        queryObjArray.push(queryObj)
                    }
                    this.queryFields[key] = queryObjArray;
                }
                return filterObj;
            },
            isReadPermitted(){
                return this.$store.getters.isPermitted({resource:'Collaboration',action:'read'});
            },
            isCreatePermitted(){
                return this.$store.getters.isPermitted({resource:'Collaboration',action:'create'});
            },
            isUpdatePermitted(){
                return this.$store.getters.isPermitted({resource:'Collaboration',action:'update'});
            },
            isDeletePermitted(){
                return this.$store.getters.isPermitted({resource:'Collaboration',action:'delete'});
            },

        },
        components:{
            Modal
        },
        beforeCreate(){
            if(!this.$store.getters.isPermitted({resource:'Collaboration',action:'read'}))
                this.$router.push( '/access-denied');
        },
        mounted() {
            this.getColumnList();
            this.getRecordList();
        },
        methods: {
            debounce : debounce(function () {
                this.filterRecords();
            }, 500),
            /**
             * CRUD
             * */
            getColumnList: function () {
                if (this.$store.state[this.axiosParams.module].columnList.length == 0){
                    this.$store.dispatch('getColumnList', this.axiosParams);

                }
            },
            getRecordList: function () {
                if (this.$store.state[this.axiosParams.module].recordList.length == 0){
                    this.$store.dispatch('getModuleInfo', this.axiosParams);
                }
            },
            deleteRecord: function (id) {
                if (confirm("Do you really want to delete this record?")){
                    this.axiosParams.id = id;
                    this.$store.dispatch('removeRecordFromList', this.axiosParams);
                    deleteRecord(this.axiosParams, (response) => {
                        if (response.data){
                            console.log(response.data);
                        }
                    })
                }

            },
            filterRecords: function(){
                this.$store.state[this.axiosParams.module].busy = true;
                this.$store.state[this.axiosParams.module].isFiltered = true;
                let formData = new FormData();
                for (let key in this.queryFields) {
                    formData.append(key, JSON.stringify(this.queryFields[key]));
                }
                this.axiosParams.filterData = formData;
                this.$store.dispatch('getFilteredRecords', this.axiosParams);
            },

            /**
             * Generic
             * */
            clearFilter: function () {
                for (let objects of Object.values(this.queryFields)){
                    for (let obj of objects){
                        obj.operator = 'like';
                        obj.value = '';
                    }
                }
                this.filterRecords();
                this.$store.state[this.axiosParams.module].isFiltered = false;
            },
            toggleColumn: function (column) {

                this.tableFields.filter(obj => {
                    if(obj.key == column.key){
                        if (column.thClass.includes('d-none')){
                            let modifyClass = column.thClass.replace("d-none", '');
                            this.$set(obj, 'thClass', modifyClass)
                            this.$set(obj, 'tdClass', modifyClass)
                        }
                        else{
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
                for (i=0; i < labels.length; i++) {
                    labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
                }
                return labels.join(' ');
            },
        },
    }
</script>

<style scoped>

</style>
