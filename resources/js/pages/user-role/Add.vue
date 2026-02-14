<template>
    <div>

        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading" style="margin-bottom: 0rem !important;">Role Management - {{ formFields.id ? 'Edit' : 'Add'}}</h5>
            <div class="bg-toolbar">
                <Toolbar :id="formFields.id" :title="formFields.title" :saveDisabled="saveDisabled"></Toolbar>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{addOrUpdate}}
                <Content :formFields="formFields" :hide-in-modal="hideInModal"></Content>
            </div>
        </div>

    </div>

</template>

<script>

    import Toolbar from "./Toolbar";
    import {event, eventBus} from "../../event-bus/event-bus";
    import Content from "./Content";
    import {saveRecord, fetchRecord, deleteRecord} from "../../helpers/axios";

    export default {
        name: "Add",
        props: {
            id: {
                type: Number
            },
            title: {
              type: String
            },
            hideInModal: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {

                formFields: {
                    id: 0,
                    title:null,
                    permissions:[],
                },
                checkEmptyRecord : false,
                axiosParams: {module: 'userRole'},
                axiosRoleParams: {module: 'roleAddEdit'},
                axiosUserParams: {module: 'userResources'},
                saveDisabled: false,
            }
        },
        components: {
            Content,
            Toolbar
        },
        computed: {

            formData(){

               /* if (this.formFields.id == 0 ){
                    this.formFields.title = null;
                    this.formFields.permissions = [];
                }
                if (this.formFields.permissions == null ){
                    this.formFields.permissions = [];
                }*/
                return this.formFields;
            },
            addOrUpdate: function(){
              this.$store.getters.getModuleAddEdit({parentModule:'userRole',childModule:'roleAddEdit'});
            },
            /*formData(){

                if (this.formFields.id == 0 || this.formFields.permissions == null) {
                    this.formFields.permissions = [];
                    for (let i = 0; i < this.resourceList.length; i++)
                        this.formFields.permissions.push({...{'resource': this.resourceList[i].resource}, ...this.defaultPermissions})
                }
                else {
                    for (let i = 0; i < this.resourceList.length; i++){
                        let newresource = true;
                        for (let j = 0; j < this.formFields.permissions.length; j++)
                            if (this.resourceList[i].resource == this.formFields.permissions[j].resource)
                                 newresource = false;
                        if(newresource)
                                this.formFields.permissions.push({...{'resource': this.resourceList[i].resource}, ...this.defaultPermissions})
                    }
                }
                return this.formFields;
            }*/
        },
        created() {
            eventBus.$on(event.SAVE_USER_ROLE, this.save);
            eventBus.$on(event.DELETE_USER_ROLE, this.deleteRecord);
            eventBus.$on(event.FIRST_USER_ROLE_RECORD, this.first);
            eventBus.$on(event.LAST_USER_ROLE_RECORD, this.last);
            eventBus.$on(event.NEXT_USER_ROLE_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_USER_ROLE_RECORD, this.prev);
            eventBus.$on(event.GET_USER_ROLE, this.getRecord);
            eventBus.$on(event.ADD_USER_ROLE, this.clearForm);
        },
        destroyed() {
            eventBus.$off(event.SAVE_USER_ROLE);
            eventBus.$off(event.DELETE_USER_ROLE);
            eventBus.$off(event.FIRST_USER_ROLE_RECORD,);
            eventBus.$off(event.LAST_USER_ROLE_RECORD);
            eventBus.$off(event.NEXT_USER_ROLE_RECORD);
            eventBus.$off(event.PREVIOUS_USER_ROLE_RECORD);
            eventBus.$off(event.GET_USER_ROLE);
            eventBus.$off(event.ADD_USER_ROLE);
        },
        beforeCreate(){
            if(this.$store.getters.isAdmin != 'Admin' && this.$store.getters.isAdmin != 'Supper Admin')
                this.$router.push( '/access-denied');
        },
        mounted() {
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            this.getColumns();
            this.getRecords();
            this.getUserRoleList();
            if(this.formFields.id > 0)
                this.getRecord(this.formFields.id);
            this.$store.getters.detectFormChanges();
        },
        methods: {
            /** CRUD */
            getRecord: function(id){

                if (id){
                    let record = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == id);
                    if (record != undefined){
                        this.formFields = {...record};
                    }
                    else{
                        this.axiosParams.id = id;
                        fetchRecord(this.axiosParams, (response) => {
                          if (response.data.title != 'Customer'){
                              this.formFields = response.data;
                              this.axiosParams.data = this.formFields;
                              this.$store.commit('appendOrUpdateInRecordList', this.axiosParams);
                          }else{
                              this.clearForm();
                          }

                        })
                    }
                }
            },
            getRecords(){
                if (this.$store.state[this.axiosParams.module].recordList.length == 0){
                    this.$store.dispatch('getModuleInfo', this.axiosParams);
                }

            },
            getUserRoleList(){
             /* if (this.$store.state[this.axiosUserParams.module].recordList.length == 0 ){
                  this.$store.dispatch('getModuleInfo', this.axiosUserParams);
              }*/
            },
            getColumns(){
                if (this.$store.state[this.axiosParams.module].columnList.length == 0){
                    this.$store.dispatch('getColumnList', this.axiosParams);
                }
            },
            save() {

                //check for empty obj
                if (this.formFields.permissions )
                    for(let i = 0; i < this.formFields.permissions.length; i++){
                        if(Object.keys(this.formFields.permissions[i]).length == 0)
                    this.formFields.permissions.splice(i,1);
                }
                  /*  if(this.formFields.permissions[this.formFields.permissions.length-1] == {})
                        this.formFields.permissions.pop();*/

                this.saveDisabled = true; //Disabling save button
                let data = this.formFields;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));

                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data[0]) {
                        let message = (response.data[response.data.length - 1]);
                        this.makeToast({title:'Error', message:message, variant:'danger'});
                    } else {
                        let message = `Record Successfully ${this.formFields.id ? 'Updated' : 'Added'}`;
                        this.makeToast({title:'Success', message:message, variant:'success'});
                        this.formFields = response.data;
                        this.axiosParams.data = response.data;
                        this.$store.commit('appendOrUpdateInRecordList', this.axiosParams);
                        let params = response.data;
                        this.$store.commit('updatePermission', params);
                    }
                })
            },
            deleteRecord: function (id) {
                if (confirm("Do you really want to delete this record?")){
                    this.axiosParams.id = id;
                    this.$store.dispatch('removeRecordFromList', this.axiosParams);
                    deleteRecord(this.axiosParams, (response) => {
                        if (response.data){
                            if(this.$store.state[this.axiosRoleParams.module].firstRecord)
                                this.formFields = this.$store.state[this.axiosRoleParams.module].firstRecord;
                            else
                                this.formFields = {id:0, title:null,permission_list:[]};
                        }
                        else{
                            console.log(response.data);
                        }
                    })
                }
            },

            /** Pagination*/
            first:function(){
                if (Object.keys(this.$store.state[this.axiosRoleParams.module].firstRecord).length > 0){
                        this.formFields = this.$store.state[this.axiosRoleParams.module].firstRecord;
                }
                else{
                    firstRecord(this.axiosParams,(response) => {
                        if (Object.keys(response.data).length > 0){
                            if (response.data.title != 'Customer'){
                                this.formFields = response.data;
                            }

                        }
                    })
                }
            },
            last:function(){
                if (Object.keys(this.$store.state[this.axiosRoleParams.module].lastRecord).length > 0) {
                        this.formFields = this.$store.state[this.axiosRoleParams.module].lastRecord;
                }
                else{
                    lastRecord(this.axiosParams,(response) => {
                        if (Object.keys(response.data).length > 0){
                            if (response.data.title != 'Customer'){
                                this.formFields = response.data;
                            }
                        }
                    })
                }
            },
            next: function(id){

                if(Object.keys(this.$store.state[this.axiosRoleParams.module].recordList).length > 0){
                    let list = this.$store.state[this.axiosRoleParams.module].recordList;
                    let record = list.find(obj => obj.id == id)
                        let nextIndex = list.indexOf(record) + 1;
                        let totalRecords = list.length - 1;
                        if (nextIndex <= totalRecords){
                                this.formFields = list[nextIndex];
                        }
                }
                else{
                    this.axiosParams.id = id;
                    nextRecord(this.axiosParams,(response) => {
                        if (Object.keys(response.data).length > 0){
                            if (response.data.title != 'Customer')
                                this.formFields = response.data;
                        }
                    })
                }
            },
            prev: function(id){
                if (Object.keys(this.$store.state[this.axiosRoleParams.module].recordList).length > 0){
                    let list = this.$store.state[this.axiosRoleParams.module].recordList;
                    let record = list.find(obj => obj.id == id);

                        let prevIndex = list.indexOf(record) - 1;
                        if (prevIndex > -1){
                                this.formFields = list[prevIndex];
                        }


                }
                else{
                    this.axiosParams.id = id;
                    previousRecord(this.axiosParams,(response) => {
                        if (Object.keys(response.data).length > 0){
                            if (response.data.title != 'Customer')
                            this.formFields = response.data;
                        }
                    })
                }
            },

            /** Generic */
            makeToast(params) {
                this.$bvToast.toast(params.message, {
                    title: params.title,
                    variant: params.variant,
                    toaster: 'b-toaster-top-center',
                    autoHideDelay: 3000,
                    noCloseButton: true,
                })
                this.saveDisabled = false;//enabling save button
            },
            clearForm: function(){
                this.formFields = {
                    id: 0,
                    title:null,
                    permissions:[]
                };
            },
        },
        metaInfo() {
            return {
                title: 'Role Management'
            }
        },
    }
</script>

<style scoped>
</style>
