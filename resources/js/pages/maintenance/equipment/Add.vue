<template>
    <div>
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Equipment Information</h5>
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
                                <div class="equipment-row">
                                    <div>
                                        <label class="mr-2">Equipment No.</label>
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" size="sm" type="text" v-model="formFields.equipment_no"></b-form-input>
                                    </div>
                                    <div>
                                        <label class="ml-1">Date Purchased</label>
                                        <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric'}" :disabled="hideInModal"
                                                           class="input-sm input-date" close-button locale="en" placeholder=""

                                                           reset-button
                                                           size="sm"
                                                           today-button
                                                           v-model="formFields.date_purchased">

                                        </b-form-datepicker>
                                    </div>
                                    <div class="ml-n4">
                                        <label class="mx-4">Amount Purchased</label>
                                        <Price :classes="'input-total ml-1'" :disable="hideInModal || hideinAuth" v-model="formFields.amount_purchased"></Price>
                                    </div>
                                </div>
                                <div class="equipment-row">
                                    <div>
                                        <label class="mr-4">Description:</label>
                                        <b-form-textarea
                                            :disabled="hideInModal || hideinAuth"
                                            class=" input-xl ml-n3"
                                            name="description"
                                            no-resize
                                            rows="3"
                                            size="sm"
                                            v-model="formFields.description"
                                        ></b-form-textarea>
                                    </div>
                                </div>
                                <div class="equipment-row">
                                    <div>
                                        <label class="mr-4">Comment:</label>
                                        <b-form-textarea
                                            :disabled="hideInModal || hideinAuth"
                                            class=" input-xl ml-n3"
                                            name="description"
                                            no-resize
                                            rows="3"
                                            size="sm"
                                            v-model="formFields.comment"
                                        ></b-form-textarea>
                                    </div>
                                </div>
                                <div class="equipment-row">
                                    <div>
                                        <label class="">Department</label>
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="input-md" size="sm" type="text" v-model="formFields.department"></b-form-input>
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
    import {event, eventBus} from '../../../event-bus/event-bus';
    import Toolbar from "./Toolbar";
    import Price from "../../../Modules/Price";
    import {deleteRecord, fetchRecord, firstRecord, lastRecord, nextRecord, previousRecord, saveRecord} from "../../../helpers/axios";

    export default {
        name: "Add",
        props: {
            id: {
                type: Number,
                default: null
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
                    equipment_no: null,
                    date_purchased: null,
                    amount_purchased: 0,
                    description: null,
                    comment: null,
                    department: null
                },
                axiosParams: {module: 'equipment'},
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
                title: `${this.formFields.id ? 'Edit' : 'Add'} Equipment`,
            }
        },
        created() {
            eventBus.$on(event.SAVE_EQUIPMENT, this.storeEquipment);
            eventBus.$on(event.FIRST_EQUIPMENT_RECORD, this.first);
            eventBus.$on(event.LAST_EQUIPMENT_RECORD, this.last);
            eventBus.$on(event.NEXT_EQUIPMENT_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_EQUIPMENT_RECORD, this.prev);
            eventBus.$on(event.GET_EQUIPMENT, this.getEquipment);
            eventBus.$on(event.ADD_EQUIPMENT, this.clearForm);
            eventBus.$on(event.DELETE_EQUIPMENT, this.deleteRecord);
        },
        destroyed() {
            eventBus.$off(event.SAVE_EQUIPMENT, this.storeEquipment);
            eventBus.$off(event.FIRST_EQUIPMENT_RECORD, this.first);
            eventBus.$off(event.LAST_EQUIPMENT_RECORD, this.last);
            eventBus.$off(event.NEXT_EQUIPMENT_RECORD, this.next);
            eventBus.$off(event.PREVIOUS_EQUIPMENT_RECORD, this.prev);
            eventBus.$off(event.GET_EQUIPMENT, this.getEquipment);
            eventBus.$off(event.ADD_EQUIPMENT, this.clearForm);
            eventBus.$off(event.DELETE_EQUIPMENT, this.deleteRecord);
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
        components: {
            Toolbar,
            Price
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Maintenance', action: 'read'}))
                this.$router.push('/access-denied');
        },
        mounted() {
            // this.formFields.store_id = this.storeID
            this.$store.state[this.axiosParams.module].busy = true
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            if (!this.$store.getters.isPermitted({resource: 'Maintenance', action: 'create'}) && !this.$store.getters.isPermitted({resource: 'User', action: 'update'}))
                this.$props.hideInModal = true;
            if (this.formFields.id > 0 && !this.$store.getters.isPermitted({resource: 'Maintenance', action: 'update'}))
                this.hideinAuth = true;
            this.getEquipment(this.formFields.id);
            this.getColumns();
            this.getRecords();
            this.$store.getters.detectFormChanges();
        },
        methods: {

            /** CRUD */
            getEquipment: function (id) {
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
            storeEquipment: function () {
                this.saveDisabled = true;
                let data = this.formFields;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: message, variant: 'danger'});
                    } else {
                        let status = this.formFields.id ? 'Updated' : 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                        this.makeToast({title: 'Success', message: this.alertMessage, variant: 'success'});
                        this.formFields = response.data;
                        this.alertMessage = '';
                        this.axiosParams.data = {
                            id : this.formFields.id
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
                            console.log(response.data);
                            this.$store.dispatch('removeRecordFromList', this.axiosParams);
                            this.first()

                            if (this.$store.state[this.axiosParams.module].recordList.length == 0)
                                this.clearForm();
                        } else {
                            console.log(response.data);
                        }
                    }, (error) => {
                        console.log(error);
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
                        id: 0, amount_purchased: 0
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
            makeToast: function (params) {
                this.$bvToast.toast(params.message, {
                    id: 'equipment-toast',
                    title: params.title,
                    variant: params.variant,
                    toaster: 'b-toaster-top-center',
                    autoHideDelay: params.duration ? params.duration : 2000,
                    noAutoHide: this.toastHider,
                    noCloseButton: true,
                })
                this.saveDisabled = false;
            },
        }
    }

</script>

<style scoped>
    .equipment-row {
        display: flex;
        margin: 0.5rem 0;
    }

    .equipment-row div {
        display: flex;
        margin: 0 10px;
    }

    .equipment-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
        width: 5rem;
    }

    .equipment-row div input, select, textarea {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.7rem;
    }

    .input-label {
        width: 4rem !important;
    }

    .input-xl {
        width: 40.2rem;
    }

    .input-lg {
        width: 18rem;
    }

    .input-md {
        width: 13rem;
    }

    .input-sm {
        width: 8rem;
    }

    .input-date {
        font-size: .75rem;
        border: 1px solid #c4c4c4 !important
    }
</style>
