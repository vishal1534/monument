<template>
    <div>
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Order Status</h5>
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
                                <div v-bind:class="[alertClasses, 'd-flex justify-content-center m-auto p-1 w-50']">{{alertMessage}}</div>
                                <hr>
                                <div class="company-row">
                                    <div>
                                        <h6 class="my-auto ml-2 custom-form-heading">Order Status</h6>
                                    </div>
                                </div>
                                <div class="company-row">
                                    <div>
                                        <label class="font-weight-bold">Title:</label>
                                        <b-form-input :disabled="hideInModal" class="input-xl" name="name" size="sm" type="text" v-model="formFields.title"></b-form-input>
                                    </div>
                                </div>
                                <div class="company-row">
                                    <div>
                                        <label class="font-weight-bold w-20">Email text to Customer:</label>
                                        <b-form-input :disabled="hideInModal" class="input-xl" name="name" size="sm" type="text"
                                                      v-model="formFields.email_text_to_customer"></b-form-input>
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
                    email_text_to_customer: null,
                },
                axiosParams: {module: 'orderStatus'},
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
                title: `${this.formFields.id ? 'Edit' : 'Add'} Order Status`,
            }
        },
        created() {
            eventBus.$on(event.SAVE_ORDER_STATUS, this.storeOrderStatus);
            eventBus.$on(event.FIRST_ORDER_STATUS_RECORD, this.first);
            eventBus.$on(event.LAST_ORDER_STATUS_RECORD, this.last);
            eventBus.$on(event.NEXT_ORDER_STATUS_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_ORDER_STATUS_RECORD, this.prev);
            eventBus.$on(event.GET_ORDER_STATUS, this.getCurrentOrderStatus);
            eventBus.$on(event.ADD_ORDER_STATUS, this.clearForm);
            eventBus.$on(event.DELETE_ORDER_STATUS, this.deleteRecord);
        },
        destroyed() {
            eventBus.$off(event.SAVE_ORDER_STATUS, this.storeOrderStatus);
            eventBus.$off(event.FIRST_ORDER_STATUS_RECORD, this.first);
            eventBus.$off(event.LAST_ORDER_STATUS_RECORD, this.last);
            eventBus.$off(event.NEXT_ORDER_STATUS_RECORD, this.next);
            eventBus.$off(event.PREVIOUS_ORDER_STATUS_RECORD, this.prev);
            eventBus.$off(event.GET_ORDER_STATUS, this.getCurrentOrderStatus);
            eventBus.$off(event.ADD_ORDER_STATUS, this.clearForm);
            eventBus.$off(event.DELETE_ORDER_STATUS, this.deleteRecord);
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
            this.getCurrentOrderStatus(this.formFields.id);
            this.getColumns();
            this.getRecords();
            this.$store.getters.detectFormChanges();
        },
        methods: {
            /** CRUD */
            getCurrentOrderStatus: function (id) {
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
            storeOrderStatus: function () {
                this.saveDisabled = true;
                let data = this.formFields;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data[0]) {
                        this.alertMessage = (response.data[response.data.length - 1]);
                        this.makeToast({title: "Error", message: this.alertMessage, variant: "danger", duration: 5000});
                        this.alertMessage = '';
                    } else {
                        let status = this.formFields.id ? 'Updated' : 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                        this.makeToast({title: "User Resource " + status, message: this.alertMessage, variant: "success"});
                        this.successResponse = false;
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
                        id: 0, title: ''
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
                    id: 'paper-location-toast',
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
    .company-row {
        display: flex;
        margin: 0.5rem 0;
    }

    .company-row div {
        display: flex;
        margin: 0 10px;
    }

    .company-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
        width: 5rem;
    }

    .company-row div input, select, textarea {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.7rem;
    }

    .input-xl {
        width: 43.2rem;
    }

    .input-lg {
        width: 18rem;
    }

    .input-md {
        width: 13rem;
    }

    .input-sm {
        width: 10rem;
    }

    .input-xs {
        width: 8rem;
    }

    .type-list {
        font-size: 0.8rem;
        text-align: left;
    }

    .border {
        border: 1px solid #c4c4c4 !important;
    }

    .custom-caret-agreement {
        background: #FFF url(http:/images/agreement-icon.png) right 0.75rem center no-repeat;
    }
</style>
