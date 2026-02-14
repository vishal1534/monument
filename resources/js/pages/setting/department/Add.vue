<template>
    <div :class="hideInModal?' custom-modal-margin':''">
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Department</h5>
            <div class="bg-toolbar my-2 p-1">
                <Toolbar :id="formFields.id" :saveDisabled="saveDisabled"></Toolbar>
            </div>
        </div>
        <div class="col-md-12 custom-margin pr-1 my-2" id="monumentType">
            <form class=" pb-2 div-shadow bg-white rounded" id="monument-form">
                <template v-if="isLoading">
                    <div class="text-center text-info my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>
                <template v-else>
                    <div v-bind:class="[alertClasses, 'd-flex justify-content-center mx-auto p-1 w-50']">{{alertMessage}}</div>
                    <div class="pt-1">
                        <b-form-input hidden name="department[id]" size="sm" type="text" v-model="formFields.id"></b-form-input>
                    </div>
                    <div class="product-row">
                        <div>
                            <label class="ml-0 font-weight-bold">Title</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-xl my-auto" size="sm" type="text" v-model="formFields.title"></b-form-input>
                        </div>
                        <div class="mx-2">
                            <label class="ml-0 font-weight-bold">Email Message</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-xl my-auto" size="sm" type="text" v-model="formFields.email_message"></b-form-input>
                        </div>
                        <div class="mx-2">
                            <label class="ml-0 font-weight-bold">Text Message</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-xl my-auto" size="sm" type="text" v-model="formFields.text_message"></b-form-input>
                        </div>
                    </div>
                    <div class="product-row mt-3 ml-n2">
                        <div class="mx-2">
                            <label class="ml-0 font-weight-bold">Order Status</label>
                            <b-form-checkbox
                                :disabled="hideInModal || hideinAuth"
                                class="custom-radio-and-checkbox mt-0"
                                unchecked-value=0
                                v-model="formFields.generic"
                                value=1>
                            </b-form-checkbox>
                        </div>
                    </div>
                    <div class="product-row mt-3 flex-column">
                        <label class="ml-0 font-weight-bold">Notify via</label>
                        <b-form-checkbox-group
                            :disabled="hideInModal || hideinAuth"
                            :options="notifyList"
                            class="flex-column custom-radio-and-checkbox"
                            v-model="formFields.notify"
                        ></b-form-checkbox-group>
                    </div>
                </template>
            </form>
        </div>

    </div>
</template>
<script>
    import Toolbar from "./Toolbar";
    import {event, eventBus} from "../../../event-bus/event-bus";
    import {deleteRecord, fetchRecord, firstRecord, lastRecord, nextRecord, previousRecord, saveRecord} from "../../../helpers/axios";

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
            return {
                pageNumber: 1,
                // storeID : this.$store.getters.getCurrentStoreID,
                formFields: {
                    // store_id: this.storeID,
                    id: 0,
                    title: null,
                    email_message: null,
                    text_message: null,
                    generic: 0,
                    notify: []
                },
                notifyList: [
                    {value: 'mail', text: 'Send Email'},
                    {value: 'nexmo', text: 'Send Message'},
                ],
                axiosParams: {module: 'department'},
                alertMessage: '',
                hideAlert: true,
                successResponse: false,
                errorResponse: false,
                saveDisabled: false,
                hideinAuth: false,
            }
        },
        metaInfo() {
            return {
                title: `${this.formFields.id ? 'Edit' : 'Add'} Department`,
            }
        },
        created() {
            eventBus.$on(event.SAVE_DEPARTMENT, this.storeMonumentType);
            eventBus.$on(event.FIRST_DEPARTMENT_RECORD, this.first);
            eventBus.$on(event.LAST_DEPARTMENT_RECORD, this.last);
            eventBus.$on(event.NEXT_DEPARTMENT_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_DEPARTMENT_RECORD, this.prev);
            eventBus.$on(event.GET_DEPARTMENT, this.getDepartment);
            eventBus.$on(event.ADD_DEPARTMENT, this.clearForm);
            eventBus.$on(event.DELETE_DEPARTMENT, this.deleteRecord);
        },
        destroyed() {
            eventBus.$off(event.SAVE_DEPARTMENT, this.storeMonumentType);
            eventBus.$off(event.FIRST_DEPARTMENT_RECORD, this.first);
            eventBus.$off(event.LAST_DEPARTMENT_RECORD, this.last);
            eventBus.$off(event.NEXT_DEPARTMENT_RECORD, this.next);
            eventBus.$off(event.PREVIOUS_DEPARTMENT_RECORD, this.prev);
            eventBus.$off(event.GET_DEPARTMENT, this.getDepartment);
            eventBus.$off(event.ADD_DEPARTMENT, this.clearForm);
            eventBus.$off(event.DELETE_DEPARTMENT, this.deleteRecord);
        },
        components: {
            Toolbar
        },
        computed: {
            isLoading() {
                return this.$store.state[this.axiosParams.module].busy;
            },
            alertClasses: function () {
                return {
                    alert: true,
                    'alert-success': this.successResponse,
                    'alert-danger': this.errorResponse,
                    'd-none': this.hideAlert
                }
            }
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Setting', action: 'read'}))
                this.$router.push('/access-denied');
        },
        mounted() {
            // this.formFields.store_id = this.storeID
            this.$store.state[this.axiosParams.module].busy = true
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            if (!this.$store.getters.isPermitted({resource: 'Setting', action: 'create'}) && !this.$store.getters.isPermitted({resource: 'Setting', action: 'update'}))
                this.$props.hideInModal = true;
            if (this.formFields.id > 0 && !this.$store.getters.isPermitted({resource: 'Setting', action: 'update'}))
                this.hideinAuth = true;
            this.getDepartment(this.formFields.id);
            this.getColumns();
            this.getRecords();
            this.$store.getters.detectFormChanges();
        },
        methods: {
            /** CRUD */
            getDepartment: function (id) {
                if (id) {
                    this.axiosParams.id = id;
                    fetchRecord(this.axiosParams, (response) => {
                        this.formFields = response.data;
                        if (this.$store.state[this.axiosParams.module].recordList.length > 0)
                            this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    })
                }
            },
            storeMonumentType: function () {
                this.saveDisabled = true;
                let data = this.formFields;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: this.alertMessage, variant: 'danger', duration: 5000});
                        this.alertMessage = '';
                    } else {
                        let status = this.formFields.id ? 'Updated' : 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                        this.makeToast({title: 'Department ' + status, message: this.alertMessage, variant: 'success'});
                        this.formFields = response.data;
                        this.alertMessage = '';
                        this.axiosParams.data = {
                            id: this.formFields.id
                        }
                        this.$store.commit('appendOrUpdateDropDown', this.axiosParams)
                    }
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            deleteRecord: function (id) {
                if (confirm("Do you really want to delete this record?")) {
                    this.axiosParams.id = id;
                    deleteRecord(this.axiosParams, (response) => {
                        if (response.data) {
                            if (this.$store.state[this.axiosParams.module].recordList.length == 0) {
                                this.clearForm();
                            } else {
                                this.$store.dispatch('removeRecordFromList', this.axiosParams);
                                this.first()
                                let params = {module: 'collaboration', detail: 'department', id: this.axiosParams.id}
                                this.$store.dispatch('removeDetailFromList', params);
                            }
                        } else {
                            console.log(response.data);
                        }
                    }, (error) => {
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    })
                }
            },
            getColumns() {
                if (this.$store.state[this.axiosParams.module].columnList.length == 0) {
                    this.$store.dispatch('getColumnList', this.axiosParams);
                }
            },
            getRecords() {
                if (!this.hideInModal)
                    this.$store.dispatch('getDropDownInfo', {module: this.axiosParams.module, apiURL: 'getDropDownRecord', page: this.pageNumber})
            },

            /** Pagination*/
            first: function () {
                firstRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.formFields = response.data;
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            last: function () {
                lastRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.formFields = response.data;
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            next: function (id) {
                this.axiosParams.id = id;
                nextRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.formFields = response.data;
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            prev: function (id) {
                this.axiosParams.id = id;
                previousRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.formFields = response.data;
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
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
                        // store_id: this.storeID,
                        id: 0, generic: 0, notify: []
                    };
                }
            },
            handleAlert: function () {
                this.saveDisabled = false;
                this.hideAlert = false;
                setTimeout(() => {
                    this.alertMessage = "";
                    this.successResponse = false;
                    this.errorResponse = false;
                    this.hideAlert = true;
                }, 3000)
            },
            customizeLabel: function (str) {
                let i, labels = str.split('_');
                for (i = 0; i < labels.length; i++) {
                    labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
                }
                return labels.join(' ');
            },
            setCurrentRecord() {
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
                this.saveDisabled = false;
            },
        },
    }
</script>

<style scoped>
    .custom-margin {
        margin-top: -1.5rem;
        margin-left: -0.4rem;
        margin-bottom: -0.9rem;
    }

    .product-row {
        display: flex;
        margin: 0.5rem 0;
        padding-left: 1rem;
    }

    .product-row div {
        display: flex;
    }

    .product-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
    }

    input {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.75rem;
    }

    .input-xl {
        width: 20rem;
    }

    .custom-modal-margin {
        padding-top: 0.5rem;
        margin-right: 0rem;
        padding-left: 0rem;
        padding-bottom: .1rem;
        background-color: #e9ecef;
    }

</style>


