<template>
    <div>
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Collaborator Type</h5>
            <div class="bg-toolbar my-2 p-1">
                <Toolbar :id="formFields.id" :saveDisabled="saveDisabled"></Toolbar>
            </div>
        </div>
        <div>
            <div class="row m-0">
                <div class="col-md-12">
                    <form>
                        <div class="div-shadow bg-white rounded p-2 mb-2">

                            <div class="custom-row">
                                <div>
                                    <label>Type</label>
                                    <b-form-input type="text" class="input-xxl" name="type" size="sm"
                                              v-model="formFields.title" :disabled="hideInModal"></b-form-input>
                                </div>

                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Toolbar from "./Toolbar";
    import {event, eventBus} from "../../event-bus/event-bus";
    import {
        nextRecord,
        previousRecord,
        firstRecord,
        fetchRecords,
        lastRecord, fetchRecord, saveRecord, deleteRecord,
    } from "../../helpers/axios";

    export default {
        name: "Add",
        props: {
            id: {
                type: Number
            },
            hideInModal: {
                type: Boolean,
                default: false
            }
        },
        components: {
            Toolbar,
        },
        computed: {
        },
        created() {
            eventBus.$on(event.SAVE_COLLABORATORTYPE, this.storeCollaboratorType);
            eventBus.$on(event.FIRST_COLLABORATORTYPE_RECORD, this.first);
            eventBus.$on(event.LAST_COLLABORATORTYPE_RECORD, this.last);
            eventBus.$on(event.NEXT_COLLABORATORTYPE_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_COLLABORATORTYPE_RECORD, this.prev);
            eventBus.$on(event.GET_COLLABORATORTYPE, this.getCollaborator);
            eventBus.$on(event.ADD_COLLABORATORTYPE, this.clearForm);
            eventBus.$on(event.DELETE_COLLABORATORTYPE, this.deleteRecord);
        },
        destroyed() {
            eventBus.$off(event.SAVE_COLLABORATORTYPE);
            eventBus.$off(event.FIRST_COLLABORATORTYPE_RECORD);
            eventBus.$off(event.LAST_COLLABORATORTYPE_RECORD);
            eventBus.$off(event.NEXT_COLLABORATORTYPE_RECORD);
            eventBus.$off(event.PREVIOUS_COLLABORATORTYPE_RECORD);
            eventBus.$off(event.GET_COLLABORATORTYPE);
            eventBus.$off(event.ADD_COLLABORATORTYPE);
            eventBus.$off(event.DELETE_COLLABORATORTYPE);
        },
        data() {
            return {

                formFields: {
                    id: 0,
                },
                saveDisabled: false,
                axiosParams: {module: 'collaboratorType'},
            }
        },
        metaInfo() {
            return {
                title: `${this.formFields.id ? 'Edit' : 'Add'} Collaborator Type`,
            }
        },
        beforeCreate(){
            if(!this.$store.getters.isPermitted({resource:'Collaboration',action:'read'}))
                this.$router.push( '/access-denied');
        },
        mounted() {
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            if(!this.$store.getters.isPermitted({resource:'Collaboration',action:'update'}))
                this.$props.hideInModal = true;
            this.getCollaborator(this.formFields.id);
            this.getColumns();
            this.getRecords();
        },
        methods: {

            getCollaborator: function(id){
                if (id){
                    let record = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == id);
                    if (record != undefined){
                        this.formFields = {...record};
                    }else{
                        this.axiosParams.id = id;
                        fetchRecord(this.axiosParams, (response) => {
                            this.formFields = response.data
                        });
                    }
                }
            },
            getRecords: function(){
                if (this.$store.state[this.axiosParams.module].recordList.length == 0){
                    this.$store.dispatch('getModuleInfo', this.axiosParams);
                }
            },
            getColumns: function(){
                if (this.$store.state[this.axiosParams.module].columnList.length == 0){
                    this.$store.dispatch('getColumnList', this.axiosParams);
                }
            },
            storeCollaboratorType: function(){
              this.saveDisabled - true;
              let data = this.formFields;
              let formData = new FormData();
              formData.append('data', JSON.stringify(data));
              saveRecord(this.axiosParams, formData, (response) => {
                  if (response.data.errorInfo){
                      let message = (response.data.errorInfo[response.data.errorInfo.length -1]);
                      this.makeToast({title: 'Error', message: message, variant: 'danger'});
                  }else{
                      let message = `Record Successfully ${this.formFields.id ? 'updated' : 'Added'}`;
                      this.makeToast({title: 'Success', message:message, variant: 'success'});
                      this.formFields = response.data;
                      this.axiosParams.data = response.data;
                      this.$store.commit('appendOrUpdateInRecordList', this.axiosParams)
                  }
              });
            },
            deleteRecord: function(id){
                if (confirm('Do you really want to delete this record?')){
                    this.axiosParams.id = id
                    deleteRecord(this.axiosParams, (response) => {
                        if (response.data){
                            if (this.$store.state[this.axiosParams.module].recordList.length == 0){
                                this.clearForm();
                            }else{
                                this.$store.dispatch('removeRecordFromList', this.axiosParams)
                                this.formFields = this.$store.state[this.axiosParams.module].firstRecord
                            }
                        }else{
                            console.log(response.data)
                        }
                    }, (error) => {
                        if (error.response.status == 400){
                            this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger'});
                        }
                        })
                }
            },

            /** Pagination*/
            first: function () {
                if (Object.keys(this.$store.state[this.axiosParams.module].firstRecord).length > 0) {
                    this.formFields = this.$store.state[this.axiosParams.module].firstRecord;
                } else {
                    firstRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.formFields = response.data;
                        }
                    })
                }
            },
            last: function () {
                if (Object.keys(this.$store.state[this.axiosParams.module].lastRecord).length > 0) {
                    this.formFields = this.$store.state[this.axiosParams.module].lastRecord;
                } else {
                    lastRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.formFields = response.data;
                        }
                    })
                }
            },
            next: function (id) {

                if (Object.keys(this.$store.state[this.axiosParams.module].recordList).length > 0) {
                    let list = this.$store.state[this.axiosParams.module].recordList;
                    let record = list.find(obj => obj.id == id)
                    let nextIndex = list.indexOf(record) + 1;
                    let totalRecords = list.length - 1;
                    if (nextIndex <= totalRecords) {
                        this.formFields = list[nextIndex];
                    }
                } else {
                    this.axiosParams.id = id;
                    nextRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.formFields = response.data;
                        }
                    })
                }
            },
            prev: function (id) {
                if (Object.keys(this.$store.state[this.axiosParams.module].recordList).length > 0) {
                    let list = this.$store.state[this.axiosParams.module].recordList;
                    let record = list.find(obj => obj.id == id);
                    let prevIndex = list.indexOf(record) - 1;
                    if (prevIndex > -1) {
                        this.formFields = list[prevIndex];
                    }
                } else {
                    this.axiosParams.id = id;
                    previousRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.formFields = response.data;
                        }
                    })
                }
            },

            /** Generic*/
            clearForm: function () {
                if (window.detectChanges && !confirm('You have unsaved changes. Are you sure you want to navigate away?')) {
                    this.$store.state[this.axiosParams.module].busy = false
                } else {
                    window.detectChanges = false;
                }
                if (!window.detectChanges) {
                    this.formFields = {id: 0};
                }
            },
            makeToast: function (params) {
                this.$bvToast.toast(params.message, {
                    id: 'collaboration-toast',
                    title: params.title,
                    variant: params.variant,
                    toaster: 'b-toaster-top-center',
                    autoHideDelay: params.duration ? params.duration : 2000,
                    noAutoHide: this.toastHider,
                    noCloseButton: true,
                })
                this.saveDisabled = false;
            },
            customizeLabel: function (str) {
                let i, labels = str.split('_');
                for (i = 0; i < labels.length; i++) {
                    labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
                }
                return labels.join(' ');
                },
},
}
</script>

<style scoped>

    .custom-row
    {
        display: flex;
        margin: 0.5rem 0;
    }
    .custom-row div
    {
        display: flex;
        margin: 0 10px;
    }
    .custom-row div label{
        margin: auto 0.5rem;
        white-space: nowrap !important;
        width: 5rem;
    }
    .custom-row div input,select,textarea{
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.7rem;
    }
    .input-xxl {
        width: 18rem;
    }
    .border{
        border: 1px solid #c4c4c4 !important;
    }
    select{
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.75rem;
    }
    .b-select-width{
        width: 18rem;
    }
</style>



