<template>
    <div>
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Collaborator</h5>
            <div class="bg-toolbar my-2 p-1">
                <Toolbar :id="formFields.id" :saveDisabled="saveDisabled"></Toolbar>
            </div>
        </div>
        <div>
            <div class="row m-0">
                <div class="col-md-12">
                    <form>
                        <template v-if="isLoading">
                            <div class="text-center text-info my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>
                        </template>
                        <template v-else>
                            <div class="div-shadow bg-white rounded p-2 mb-2">
                                <hr>
                                <div class="custom-row">

                                    <div>
                                        <label>First Name</label>
                                        <b-form-input :disabled="hideInModal" class="input-xxl" name="first_name" size="sm"
                                                      type="text" v-model="formFields.first_name"></b-form-input>
                                    </div>

                                    <div>
                                        <label>Last Name</label>
                                        <b-form-input :disabled="hideInModal" class="input-xxl" name="last_name" size="sm"
                                                      type="text" v-model="formFields.last_name"></b-form-input>
                                    </div>
                                </div>
                                <div class="custom-row">
                                    <div>
                                        <label>Email</label>
                                        <b-form-input :disabled="hideInModal" class="input-xxl" name="email" size="sm"
                                                      type="text" v-model="formFields.email"></b-form-input>
                                    </div>
                                </div>
                                <div class="custom-row">
                                    <div>
                                        <label>Phone</label>
                                        <b-form-input :disabled="hideInModal" class="input-xxl" name="email" size="sm"
                                                      type="text" v-model="formFields.phone"></b-form-input>
                                    </div>
                                    <div>
                                        <label>Type</label>
                                        <b-dropdown :disabled="hideInModal"
                                                    class="input-md border rounded ml-0 input-xxl cutsom-width-dropdown"
                                                    no-caret size="sm" toggle-class="" variant="none">
                                            <template #button-content>
                                                <div class="d-flex product-color">
                                                    <small>{{customizeLabel(collaboratorTypeTitle)}}</small>
                                                    <small class="w-25 ml-auto custom-caret"></small>
                                                </div>
                                            </template>
                                            <b-dropdown-group class="overflow-auto scroll px-1">
                                                <b-form-input
                                                    class="mt-1"
                                                    placeholder="Search..."
                                                    size="sm"
                                                    v-model="searchCollaboratorType"
                                                ></b-form-input>
                                                <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                                <template v-if="collaboratorType.length > 0">
                                                    <template v-for="(obj, key) of collaboratorType">
                                                        <b-dropdown-group @click="handleDropdownChange">
                                                            <b-dropdown-item-button :key="key" @click="setDetail(obj,'type')"
                                                                                    class="w-100">
                                                                <label class="btn btn-sm m-0" style="text-align: left">{{obj.text}}</label>
                                                            </b-dropdown-item-button>
                                                            <b-icon @click="deleteDropDown(obj.value)" aria-hidden="true" class="mt-n4 float-right" icon="trash-fill" variant="danger"></b-icon>
                                                        </b-dropdown-group>
                                                    </template>
                                                </template>
                                                <template v-else>
                                                    <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                                    <button @click="saveDetail('title')" class="d-flex m-auto px-3 btn-sm btn-info custom-add-btn"
                                                            type="button">Add Type
                                                    </button>
                                                </template>
                                            </b-dropdown-group>
                                        </b-dropdown>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
let vue_global = '';
</script>
<script>
    import Toolbar from "./Toolbar";
    import Price from "../../Modules/Price";
    import {event, eventBus} from "../../event-bus/event-bus";
    import {deleteRecord, fetchRecord, fetchRecords, firstRecord, lastRecord, nextRecord, previousRecord, saveRecord,} from "../../helpers/axios";

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
            Price,
        },
        computed: {
            isLoading() {
                return this.$store.state[this.axiosParams.module].busy;
            },
            collaboratorTypeList() {
                /*if (this.collaboratorTypes != undefined)
                    this.$store.getters.sortByAlphaNumeric({'fieldName': 'title', 'recordList': this.collaboratorTypes});*/
                let list = [];
                for (let opt of this.collaboratorTypes) {
                    list.push({value: opt.id, text: this.customizeLabel(opt.title)})
                }
                return list;
            },
            collaboratorTypeTitle() {
                let opt = "Select";

                // assign first as default if not select before
                if(this.collaboratorTypes.length > 0 && this.formFields.id === 0){
                    this.formFields.type_id = this.collaboratorTypes[0].id;
                }

                if (this.collaboratorTypes.length > 0 && this.formFields.type_id != 0 && this.formFields.type_id != null) {
                    opt = this.collaboratorTypes.filter(obj => obj.id == this.formFields.type_id);
                    opt = opt.length > 0 ? opt[0].title : "Select";
                }
                return opt
            },
            collaboratorType() {
                window.vue_global = this;
                let options = [];
                for (let opt of this.collaboratorTypes) {
                    let obj = {value: opt.id, text: opt.title, options: opt};
                    options.push(obj);
                }
                if (this.searchCollaboratorType != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchCollaboratorType.toUpperCase()) > -1)
                }
                return options;
            },
        },
        created() {
            eventBus.$on(event.SAVE_COLLABORATOR, this.storeCollaborator);
            eventBus.$on(event.FIRST_COLLABORATOR_RECORD, this.first);
            eventBus.$on(event.LAST_COLLABORATOR_RECORD, this.last);
            eventBus.$on(event.NEXT_COLLABORATOR_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_COLLABORATOR_RECORD, this.prev);
            eventBus.$on(event.GET_COLLABORATOR, this.getCollaborator);
            eventBus.$on(event.ADD_COLLABORATOR, this.clearForm);
            eventBus.$on(event.DELETE_COLLABORATOR, this.deleteRecord);
        },
        destroyed() {
            eventBus.$off(event.SAVE_COLLABORATOR);
            eventBus.$off(event.FIRST_COLLABORATOR_RECORD);
            eventBus.$off(event.LAST_COLLABORATOR_RECORD);
            eventBus.$off(event.NEXT_COLLABORATOR_RECORD);
            eventBus.$off(event.PREVIOUS_COLLABORATOR_RECORD);
            eventBus.$off(event.GET_COLLABORATOR);
            eventBus.$off(event.ADD_COLLABORATOR);
            eventBus.$off(event.DELETE_COLLABORATOR);
        },
        data() {
            return {
                pageNumber: 1,
                // storeID : this.$store.getters.getCurrentStoreID,
                formFields: {
                    // store_id: this.storeID,
                    id: 0,
                    type_id: null,
                },
                saveDisabled: false,
                axiosParams: {module: 'collaborator'},
                axiosParamsType: {module: 'collaborator/type'},
                searchCollaboratorType: "",
                collaboratorTypes: [],
            }
        },
        metaInfo() {
            return {
                title: `${this.formFields.id ? 'Edit' : 'Add'} Collaborator`,
            }
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Collaboration', action: 'read'}))
                this.$router.push('/access-denied');
        },
        mounted() {
            // this.formFields.store_id = this.storeID
            this.$store.state[this.axiosParams.module].busy = true
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            if (!this.$store.getters.isPermitted({resource: 'Collaboration', action: 'update'}))
                this.$props.hideInModal = true;
            this.getCollaborator(this.formFields.id);
            this.getColumns();
            this.getRecords();
            this.$store.getters.detectFormChanges();
        },
        methods: {

            getCollaborator: function (id) {
                if (id) {
                        this.axiosParams.id = id;
                        fetchRecord(this.axiosParams, (response) => {
                            this.formFields = response.data
                            if (this.$store.state[this.axiosParams.module].recordList.length > 0)
                                this.$store.state[this.axiosParams.module].busy = false
                        }, (error) => {
                            console.log(error)
                            this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                        });
                }
            },
            getRecords: function () {
                if (!this.hideInModal){
                    this.$store.dispatch('getDropDownInfo', {module: this.axiosParams.module, apiURL: 'getDropDownRecord', page: this.pageNumber})
                    fetchRecords({module: 'collaborator/type'}, (response) => {
                        this.collaboratorTypes = response.data;
                    });
                }
            },
            getColumns: function () {
                if (this.$store.state[this.axiosParams.module].columnList.length == 0) {
                    this.$store.dispatch('getColumnList', this.axiosParams);
                }
            },
            storeCollaborator: function () {
                this.saveDisabled - true;
                let data = this.formFields;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: message, variant: 'danger'});
                    } else {
                        let message = `Record Successfully ${this.formFields.id ? 'updated' : 'Added'}`;
                        this.makeToast({title: 'Success', message: message, variant: 'success'});
                        this.formFields = response.data;
                        // this.axiosParams.data = response.data;
                        // this.$store.commit('appendOrUpdateInRecordList', this.axiosParams)
                        this.axiosParams.data = {
                            id : this.formFields.id,
                            email : this.formFields.email
                        }
                        this.$store.commit('appendOrUpdateDropDown', this.axiosParams)
                    }
                }, (error) => {
                    const errorObject = error.response.data.errors;
                    const dynamicKey = Object.keys(errorObject)[0];
                    if (dynamicKey)
                        this.makeToast({title: 'Error', message: errorObject[dynamicKey][0], variant: 'danger', duration: 3000});
                });
            },
            deleteRecord: function (id) {
                if (confirm('Do you really want to delete this record?')) {
                    this.axiosParams.id = id
                    deleteRecord(this.axiosParams, (response) => {
                        if (response.data) {
                            if (this.$store.state[this.axiosParams.module].recordList.length == 0) {
                                this.clearForm();
                            } else {
                                this.$store.dispatch('removeRecordFromList', this.axiosParams)
                                this.first()
                            }
                        } else {
                            console.log(response.data)
                        }
                    }, (error) => {
                        if (error.response.status == 400) {
                            this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger'});
                        }
                    })
                }
            },
            handleDropdownChange: function(value){
                window.detectChanges = true;
            },
            setDetail(obj, detail) {
                this.formFields[detail + '_id'] = obj.value;
                this.formFields[detail] = obj.text;
            },
            deleteDropDown: function (id) {
                if (confirm('Do you really want to delete this record ?')) {
                    let moduleName = this.axiosParamsType.module;
                    deleteRecord({id: id, module: moduleName}, (response) => {
                        let list = this.collaboratorTypes;
                        this.spliceRecord(list, id);
                    })
                }
            },
            spliceRecord: function (list, id) {
                let record = list.find(obj => obj.id == id);
                let currentIndex = list.indexOf(record);
                list.splice(currentIndex, 1);
            },
            saveDetail: function (detail) {
                let data = {
                    id: 0,
                    // store_id: this.storeID
                };
                data[detail] = this.searchCollaboratorType
                let params = this.axiosParamsType;
                let recordList = 'type'
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                saveRecord(params, formData, (response) => {
                    if (response.data.errorInfo) {
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.errorResponse = true;
                        this.handleAlert();
                    } else {
                        this.collaboratorTypes.splice(this.collaboratorTypes.length + 1, 0, response.data)
                    }
                })
            },

            /** Pagination*/
            first: function () {
                let firstIndex = this.$store.state[this.axiosParams.module].recordList[0]
                if (firstIndex) {
                    this.axiosParams.id = firstIndex.id;
                    nextRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.formFields = response.data;
                        }
                        this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    })
                }
            },
            last: function () {
                let lastIndex = this.$store.state[this.axiosParams.module].recordList.slice(-1)[0]
                if (lastIndex) {
                    this.axiosParams.id = lastIndex.id;
                    nextRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.formFields = response.data;
                        }
                        this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    })
                }
            },
            next: function (id) {
                let list = this.$store.state[this.axiosParams.module].recordList;
                let nextIndex = list.findIndex(obj => obj.id == id);
                nextIndex = list[nextIndex + 1].id
                this.axiosParams.id = nextIndex;
                    nextRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.formFields = response.data;
                        }
                        this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    })
            },
            prev: function (id) {
                let list = this.$store.state[this.axiosParams.module].recordList;
                let previousIndex = list.findIndex(obj => obj.id == id);
                if (previousIndex > -1) {
                    previousIndex = list[previousIndex - 1].id
                    this.axiosParams.id = previousIndex;
                    previousRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.formFields = response.data;
                        }
                        this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
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
                    this.formFields = {
                        id: 0,
                        type_id: null,
                        // store_id: this.storeID
                    };
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

    .custom-row {
        display: flex;
        margin: 0.5rem 0;
    }

    .custom-row div {
        display: flex;
        margin: 0 10px;
    }

    .custom-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
        width: 5rem;
    }

    .custom-row div input, select, textarea {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.7rem;
    }

    .input-xxl {
        width: 18rem;
    }

    .border {
        border: 1px solid #c4c4c4 !important;
    }

    select {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.75rem;
    }

    .b-select-width {
        width: 18rem;
    }
</style>



