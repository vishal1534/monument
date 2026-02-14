<template>
    <div>
        <div>
            <div>
                <h5 class="mx-2 my-1 custom-view-heading">Installation Check List</h5>
                <div class="bg-toolbar my-2 p-1">
                    <Toolbar :id="formFieldsData.id" :saveDisabled="saveDisabled"></Toolbar>
                </div>
            </div>
            <div class="col-md-12 custom-margin pr-1 my-2">
                <div v-bind:class="[alertClasses, 'd-flex justify-content-center m-auto p-1 w-50']">{{alertMessage}}</div>
                <Content :formFields="formFieldsData"></Content>
            </div>
        </div>


        <PDF :title="'InstallationCheckListForm'">

            <div slot="header">
                <div class="d-flex justify-content-center">
                    <h3>INSTALLATION CHECK LIST</h3>
                </div>
            </div>

            <div slot="body">
                <Content :formFields="formFieldsData" :in-pdf="true"></Content>
            </div>

            <div slot="footer"></div>
        </PDF>

    </div>

</template>

<script>

    import PDF from "../../../../Modules/PDF-Modal";
    import Content from "./Content";
    import Toolbar from "./Toolbar"
    import {event, eventBus} from "../../../../event-bus/event-bus";
    import {saveRecord, deleteRecord, fetchRecord} from "../../../../helpers/axios";
    export default {
        name: "Add",
        props: {
            hideInModal: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                // storeID : this.$store.getters.getCurrentStoreID,
                formFields: {
                    // store_id: this.storeID,
                    id: 0,
                },
                // axiosParams: {module: 'installation/check-list'},
                axiosParams: {module: 'installation'},
                axiosParamsVase: {module: 'installation/vase-direction'},
                axiosParamsDepth: {module: 'installation/foundation-depth'},
                saveDisabled:false,
                alertMessage:'',
                hideAlert:true,
                successResponse: false,
                errorResponse: false,
            }
        },
        components: {
            PDF,
            Content,
            Toolbar
        },
        computed: {
            alertClasses: function () {
                return {
                    alert: true,
                    'alert-success': this.successResponse,
                    'alert-danger': this.errorResponse,
                    'd-none': this.hideAlert
                }
            },
            formFieldsData() {
                if (this.formFields.id == 0 && this.$store.state.installation.recordList.length > 0){
                    this.formFields = this.$store.state.installation.recordList[0];
                }
                if (this.formFields.check_list == null) {
                    this.formFields.check_list = {};
                    this.formFields.order = {company:{}, invoice:{}, family: {}};
                }
                return this.formFields;
            },

        },
        created() {
            eventBus.$on(event.SAVE_INSTALLATION, this.storeInstallation);
            eventBus.$on(event.FIRST_INSTALLATION_RECORD, this.first);
            eventBus.$on(event.LAST_INSTALLATION_RECORD, this.last);
            eventBus.$on(event.NEXT_INSTALLATION_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_INSTALLATION_RECORD, this.prev);
            eventBus.$on(event.GET_INSTALLATION, this.getInstallation);
            eventBus.$on(event.ADD_INSTALLATION, this.clearForm);
            eventBus.$on(event.DELETE_INSTALLATION, this.deleteRecord);
        },
        destroyed() {
            eventBus.$off(event.SAVE_INSTALLATION, this.storeInstallation);
            eventBus.$off(event.FIRST_INSTALLATION_RECORD, this.first);
            eventBus.$off(event.LAST_INSTALLATION_RECORD, this.last);
            eventBus.$off(event.NEXT_INSTALLATION_RECORD, this.next);
            eventBus.$off(event.PREVIOUS_INSTALLATION_RECORD, this.prev);
            eventBus.$off(event.GET_INSTALLATION, this.getInstallation);
            eventBus.$off(event.ADD_INSTALLATION, this.clearForm);
            eventBus.$off(event.DELETE_INSTALLATION, this.deleteRecord);
        },
        beforeCreate(){
            if(!this.$store.getters.isPermitted({resource:'Installation',action:'read'}))
                this.$router.push( '/access-denied');
        },
        mounted() {
            // this.formFields.store_id = this.storeID
            this.getRecords();
            this.$store.getters.detectFormChanges();
        },
        methods: {
            getRecords() {

                if (this.$store.state.installation.recordList.length == 0){
                    this.$store.dispatch('getModuleInfo', {module:'installation'});
                }

                this.axiosParamsVase.id = 0;
                fetchRecord(this.axiosParamsVase, (response) => {
                    this.$store.state[this.axiosParams.module].vaseDirection = response.data;
                    this.$store.getters.sortByAlphaNumeric({'fieldName': 'direction', 'recordList': this.$store.state[this.axiosParams.module].vaseDirection});
                })
                this.axiosParamsDepth.id = 0
                fetchRecord(this.axiosParamsDepth, (response) => {
                    this.$store.state[this.axiosParams.module].foundationDepth = response.data
                    this.$store.getters.sortByAlphaNumeric({'fieldName': 'depth', 'recordList': this.$store.state[this.axiosParams.module].foundationDepth});
                })
            },
            getInstallation: function(id){

                if (id){
                    let record = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == id);
                    if (record != undefined){
                        this.formFields = {...record};
                    }
                    else{
                        this.axiosParams.id = id;
                        fetchRecord(this.axiosParams, (response) => {
                            this.formFields = response.data;
                        })
                    }
                }
            },
            storeInstallation: function(){
                this.saveDisabled = true; //Disabling save button
                let data = this.formFields;
                let formData = new FormData();
                formData.append('installing_area_image_file', this.formFields.check_list.installing_area_image_file);
                formData.append('before_pouring_concrete_image_file', this.formFields.check_list.before_pouring_concrete_image_file);
                formData.append('after_pouring_concrete_image_file', this.formFields.check_list.after_pouring_concrete_image_file);
                formData.append('finished_installed_image_file', this.formFields.check_list.finished_installed_image_file);
                formData.append('damaged_grave_image_file', this.formFields.check_list.damaged_grave_image_file);
                formData.append('data',JSON.stringify(data));

                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo){
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        /*this.errorResponse = true;
                        this.handleAlert();*/
                        this.makeToast({title : 'Error', message: this.alertMessage, variant : 'danger', duration : 5000});
                        this.alertMessage = '';
                        this.saveDisabled = true;
                    }
                    else{
                        let status = this.formFields.id ? 'Updated': 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                      /*  this.successResponse = true;
                        this.handleAlert();*/
                        this.makeToast({title : 'Success ', message : this.alertMessage, variant : 'success'});
                        this.alertMessage = '';
                        this.formFields = response.data;
                        this.axiosParams.data = response.data;
                        this.$store.commit('appendOrUpdateInRecordList', this.axiosParams);
                        // Update Order record in store (in case of changing order_status, paper_location,on_hold_order,on_hold_order_description)
                        this.$store.commit('appendOrUpdateInRecordList', {module: 'order', data: this.formFields.order});
                        this.saveDisabled = false;
                    }
                },(error) => {
                    if (error.response.status == 403){
                        this.makeToast({title: 'Error', message: error.response.data.message , variant: 'danger', duration: 3000});
                    }
                })
            },
            deleteRecord: function (id) {

                if (confirm("Do you really want to delete this record?")){
                    let record = this.$store.state[this.axiosParams.module].recordList.filter(obj => obj.id == this.formFields.id);
                    record[0].check_list = {}
                    // this.$set(record[0], 'check_list', {});
                    // this.$store.dispatch('removeRecordFromList', this.axiosParams);
                    let deleteAxiosParams = {};
                    deleteAxiosParams.id = this.formFields.id;
                    deleteAxiosParams.module = "installation/check-list";
                    deleteRecord(deleteAxiosParams, (response) => {
                        if (response.data){
                            let params = {detail:'check_list',id:deleteAxiosParams.id}
                            this.$store.dispatch('removeInstallationDetailFromList', params);
                            this.formFields = this.$store.state[this.axiosParams.module].firstRecord;
                            if (this.$store.state[this.axiosParams.module].recordList.length == 0)
                                this.clearForm();
                        }
                        else{
                            console.log(response.data);
                        }
                    },(error) => {
                        if (error.response.status == 403){
                            this.makeToast({title: 'Error', message: error.response.data.message , variant: 'danger', duration: 3000});
                        }
                    })
                }
            },

            /** Pagination*/
            first:function(){
                if (Object.keys(this.$store.state[this.axiosParams.module].firstRecord).length > 0){
                    this.formFields = this.$store.state[this.axiosParams.module].firstRecord;
                }
                else{
                    firstRecord(this.axiosParams,(response) => {
                        if (Object.keys(response.data).length > 0){
                            this.formFields = response.data;
                        }
                    })
                }
            },
            last:function(){
                if (Object.keys(this.$store.state[this.axiosParams.module].lastRecord).length > 0) {
                    this.formFields = this.$store.state[this.axiosParams.module].lastRecord;
                }
                else{
                    lastRecord(this.axiosParams,(response) => {
                        if (Object.keys(response.data).length > 0){
                            this.formFields = response.data;
                        }
                    })
                }
            },
            next: function(id){

                if(Object.keys(this.$store.state[this.axiosParams.module].recordList).length > 0){
                    let list = this.$store.state[this.axiosParams.module].recordList;
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
                            this.formFields = response.data;
                        }
                    })
                }
            },
            prev: function(id){
                if (Object.keys(this.$store.state[this.axiosParams.module].recordList).length > 0){
                    let list = this.$store.state[this.axiosParams.module].recordList;
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
                            this.formFields = response.data;
                        }
                    })
                }
            },

            /** Generic*/
            clearForm: function(){
                this.formFields = {
                    // store_id: this.storeID,
                    id:0, check_list:{}};
            },
            handleAlert: function(){
                this.saveDisabled = false;//enabling save button
                this.hideAlert = false;
                setTimeout(() => {
                    this.alertMessage = "";
                    this.successResponse = false;
                    this.errorResponse = false;
                    this.hideAlert = true;
                }, 3000)
            },
            customizeLabel: function (str) {
                // Remove underscore and capitalize first letter of each word
                let i, labels = str.split('_');
                for (i=0; i < labels.length; i++) {
                    labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
                }
                return labels.join(' ');
            },
            makeToast : function (params){
              this.$bvToast.toast(params.message,{
                  id: 'Installation-Check-List',
                  title: params.title,
                  variant: params.variant,
                  toaster: 'b-toaster-top-center',
                  autoHideDelay : params.duration ? params.duration : 2000,
                  noAutoHide : this.toastHider,
                  noCloseButton : true,
              })
            },

        },
        metaInfo() {
            return {
                title: 'Installation Check List'
            }
        },
    }
</script>

<style scoped>
    .custom-margin{
        margin: auto;
        width: 50rem;
    }
    @page check-list {
        size: unset;
    }
</style>
