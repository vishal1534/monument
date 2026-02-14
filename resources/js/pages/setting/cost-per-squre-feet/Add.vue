<template>
    <div>
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Cost P/Sq. Ft.</h5>
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
                                        <label class="custom-label-width">Color</label>
                                        <b-form-input :disabled="hideInModal" class="input-xxl" name="cost_color" size="sm"
                                                      type="text" v-model="formFields.cost_color"></b-form-input>
                                    </div>
                                    <div>
                                        <label>Type</label>
                                        <b-form-input :disabled="hideInModal" class="input-xxl" name="cost_type" size="sm"
                                                      type="text" v-model="formFields.cost_type"></b-form-input>
                                    </div>
                                    <div>
                                        <label>Granite Thickness</label>
                                        <b-form-input :disabled="hideInModal" class="input-xxl" name="thickness" size="sm"
                                                      type="text" v-model="formFields.granite_thickness"></b-form-input>
                                    </div>
                                    <div>
                                        <label>Granite Sq. Ft. Price</label>
                                        <b-form-input :disabled="hideInModal" class="input-xxl" name="granite_price" size="sm"
                                                      type="text" v-model="formFields.granite_sq_ft_price"></b-form-input>
                                    </div>
                                </div>
                                <div class="custom-row">
                                    <div>
                                        <label>Granite Desc.</label>
                                        <b-form-input :disabled="hideInModal" class="input-xxxl" name="granite_description" size="sm"
                                                      type="text" v-model="formFields.granite_description"></b-form-input>
                                    </div>
                                </div>
                                <div class="custom-row">
                                    <div>
                                        <label class="custom-label-width">Vendor</label>
                                        <b-form-input :disabled="hideInModal" class="input-xxxl" name="cost_vendor" size="sm"
                                                      type="text" v-model="formFields.cost_vendor"></b-form-input>
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
                    granite_description: '',
                },
                axiosParams: {module: 'costPerSqureFeet'},
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
                title: `${this.formFields.id ? 'Edit' : 'Add'} Cost P/Sq. Ft.`,
            }
        },
        created() {
            eventBus.$on(event.SAVE_COSTPSQUREFEET, this.storeCostPSFeet);
            eventBus.$on(event.FIRST_COSTPSQUREFEET_RECORD, this.first);
            eventBus.$on(event.LAST_COSTPSQUREFEET_RECORD, this.last);
            eventBus.$on(event.NEXT_COSTPSQUREFEET_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_COSTPSQUREFEET_RECORD, this.prev);
            eventBus.$on(event.GET_COSTPSQUREFEET, this.getCostPSFeet);
            eventBus.$on(event.ADD_COSTPSQUREFEET, this.clearForm);
            eventBus.$on(event.DELETE_COSTPSQUREFEET, this.deleteRecord);
        },
        destroyed() {
            eventBus.$off(event.SAVE_COSTPSQUREFEET, this.storeCostPSFeet);
            eventBus.$off(event.FIRST_COSTPSQUREFEET_RECORD, this.first);
            eventBus.$off(event.LAST_COSTPSQUREFEET_RECORD, this.last);
            eventBus.$off(event.NEXT_COSTPSQUREFEET_RECORD, this.next);
            eventBus.$off(event.PREVIOUS_COSTPSQUREFEET_RECORD, this.prev);
            eventBus.$off(event.GET_COSTPSQUREFEET, this.getCostPSFeet);
            eventBus.$off(event.ADD_COSTPSQUREFEET, this.clearForm);
            eventBus.$off(event.DELETE_COSTPSQUREFEET, this.deleteRecord);
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
            },
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
            this.getCostPSFeet(this.formFields.id);
            this.getColumns();
            this.getRecords();
            this.$store.getters.detectFormChanges();
        },
        methods: {
            /** CRUD */
            getCostPSFeet: function (id) {
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
            storeCostPSFeet: function () {
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
                    const errorObject = error.response.data.errors;
                    const dynamicKey = Object.keys(errorObject)[0];
                    if (dynamicKey)
                        this.makeToast({title: 'Error', message: errorObject[dynamicKey][0], variant: 'danger', duration: 3000});
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
                        id: 0,
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
    }

    .custom-row div input, select, textarea {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.7rem;
    }

    .custom-label-width {
        width: 4.5rem;
    }

    .input-xxl {
        width: 12rem;
    }

    .input-xxxl {
        width: 28rem;
    }

    .border {
        border: 1px solid #c4c4c4 !important;
    }
</style>


