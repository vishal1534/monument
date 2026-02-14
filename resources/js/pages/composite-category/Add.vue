<template>
    <div :class="hideInModal?' custom-modal-margin':''">
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Composite Category</h5>
            <div class="bg-toolbar my-2 p-1">
                <Toolbar :id="formFields.id" :saveDisabled="saveDisabled"></Toolbar>
            </div>
        </div>

        <div class="row m-0">
        <div id="compositeCategory" class="col-md-12">

            <form id="category-form">
                <div class="mb-2 p-2 div-shadow bg-white rounded">
                <div v-bind:class="[alertClasses, 'd-flex justify-content-center mx-auto p-1 w-50']">{{alertMessage}}</div>
                <div class="pt-1">
                    <b-form-input hidden name="monument[id]" type="text"  size="sm" v-model="formFields.id"></b-form-input>
                </div>
                <div class="product-row">
                    <div>
                        <h6 class="my-auto ml-2 custom-form-heading">Composite Category Information</h6>
                    </div>
                </div>
                <div class="product-row">
                    <div>
                        <label class="font-weight-bold">Title:</label>
                        <b-form-input type="text"  :disabled="hideInModal || hideinAuth" name="title" class="input-xl" size="sm" v-model="formFields.title"></b-form-input>
                    </div>
                </div>
                </div>
            </form>
        </div>
        </div>
    </div>
</template>
<script>
    import Toolbar from "./Toolbar";
    import {event, eventBus} from "../../event-bus/event-bus";
    import {saveRecord, fetchRecord, deleteRecord,nextRecord, previousRecord, firstRecord, lastRecord} from "../../helpers/axios";
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
        data() {
            return  {
                formFields:{
                    id:0,
                    title:null,
                },
                axiosParams: {module: 'compositeCategory'},
                alertMessage:'',
                hideAlert:true,
                successResponse: false,
                errorResponse: false,
                saveDisabled:false,
                hideinAuth:false,
            }
        },
        metaInfo() {
            return {
                title: `${this.formFields.id ? 'Edit' : 'Add'} Composite Category`,
            }
        },
        created() {
            eventBus.$on(event.SAVE_COMPOSITE_CATEGORY, this.storeCompositeCategory);
            eventBus.$on(event.FIRST_COMPOSITE_CATEGORY_RECORD, this.first);
            eventBus.$on(event.LAST_COMPOSITE_CATEGORY_RECORD, this.last);
            eventBus.$on(event.NEXT_COMPOSITE_CATEGORY_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_COMPOSITE_CATEGORY_RECORD, this.prev);
            eventBus.$on(event.GET_COMPOSITE_CATEGORY, this.getCompositeCategory);
            eventBus.$on(event.ADD_COMPOSITE_CATEGORY, this.clearForm);
            eventBus.$on(event.DELETE_COMPOSITE_CATEGORY, this.deleteRecord);
        },
        destroyed() {
            eventBus.$off(event.SAVE_COMPOSITE_CATEGORY, this.storeCompositeCategory);
            eventBus.$off(event.FIRST_COMPOSITE_CATEGORY_RECORD, this.first);
            eventBus.$off(event.LAST_COMPOSITE_CATEGORY_RECORD, this.last);
            eventBus.$off(event.NEXT_COMPOSITE_CATEGORY_RECORD, this.next);
            eventBus.$off(event.PREVIOUS_COMPOSITE_CATEGORY_RECORD, this.prev);
            eventBus.$off(event.GET_COMPOSITE_CATEGORY, this.getCompositeCategory);
            eventBus.$off(event.ADD_COMPOSITE_CATEGORY, this.clearForm);
            eventBus.$off(event.DELETE_COMPOSITE_CATEGORY, this.deleteRecord);
        },
        components:{
            Toolbar
        },
        computed:{
            alertClasses: function () {
                return {
                    alert: true,
                    'alert-success': this.successResponse,
                    'alert-danger': this.errorResponse,
                    'd-none': this.hideAlert
                }
            }
        },
        beforeCreate(){
            if(!this.$store.getters.isPermitted({resource:'Products',action:'read'}))
                this.$router.push( '/access-denied');
        },
        mounted() {
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            if(!this.$store.getters.isPermitted({resource:'Products',action:'create'}) && !this.$store.getters.isPermitted({resource:'Products',action:'update'}))
                this.$props.hideInModal = true;
            if(this.formFields.id > 0 && !this.$store.getters.isPermitted({resource:'Products',action:'update'}))
                this.hideinAuth = true;
            this.getCompositeCategory(this.formFields.id);
            this.getColumns();
            this.getRecords();
        },
        methods:{
            /** CRUD */
            getCompositeCategory: function(id){

                if (id){
                    let record = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == id);
                    if (record != undefined){
                        this.formFields = {...record};
                        this.setCurrentRecord();
                    }
                    else{
                        this.axiosParams.id = id;
                        fetchRecord(this.axiosParams, (response) => {
                            this.formFields = response.data;
                        })
                    }
                }

            },
            storeCompositeCategory: function(){
                this.saveDisabled = true; //Disabling save button
                let data = this.formFields;
                let formData = new FormData();

                formData.append('data',JSON.stringify(data));

                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo){
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title : 'Error', message: this.alertMessage, variant : 'danger', duration : 5000});
                        this.alertMessage = '';
                    }
                    else{
                        let status = this.formFields.id ? 'Updated': 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                        this.makeToast({title : 'Composite Category '+status, message : this.alertMessage, variant : 'success'});

                        this.formFields = response.data;

                        this.axiosParams.data = response.data;
                        this.alertMessage = '';
                        this.$store.commit('appendOrUpdateInRecordList', this.axiosParams);
                    }
                },(error) => {
                    if (error.response.status == 403){
                        this.makeToast({title: 'Error', message: error.response.data.message , variant: 'danger', duration: 3000});
                    }
                })
            },
            deleteRecord: function (id) {

                if (confirm("Do you really want to delete this record?")){
                    this.axiosParams.id = id;
                    deleteRecord(this.axiosParams, (response) => {
                        if (response.data){
                                this.$store.dispatch('removeRecordFromList', this.axiosParams);
                                this.formFields = this.$store.state[this.axiosParams.module].firstRecord;
                                let params = {module: 'composite', detail: 'category', id: this.axiosParams.id}
                                this.$store.dispatch('removeDetailFromList', params);
                            if (this.$store.state[this.axiosParams.module].recordList.length == 0){
                                this.clearForm();
                            }

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
            getColumns(){
                if (this.$store.state[this.axiosParams.module].columnList.length == 0){
                    this.$store.dispatch('getColumnList', this.axiosParams);
                }
            },
            getRecords(){
                if (this.$store.state[this.axiosParams.module].recordList.length == 0){
                    this.$store.dispatch('getModuleInfo', this.axiosParams);
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
                this.formFields = {id:0};
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
            setCurrentRecord(){
                // Set current Record in store for PDF generation
                this.$store.state[this.axiosParams.module].currentRecord = this.formFields;
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
    }
</script>

<style scoped>

    .product-row{
        display: flex;
        margin: 0.5rem 0;
    }
    .product-row div{
        display: flex;
        margin: 0 10px;
    }
    .product-row div label{
        margin: auto 0.5rem;
        white-space: nowrap !important;
        width: 5rem;
    }
    .product-row div input{
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.75rem;
    }
    .input-xl{
        width: 43.2rem;
    }
    .custom-modal-margin{
        padding-top:0.5rem;
        margin-right: 0rem;
        padding-left: 0rem;
        padding-bottom: .1rem;
        background-color: #e9ecef;
    }

</style>


