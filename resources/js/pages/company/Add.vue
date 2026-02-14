<template>
    <div>
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Company Information</h5>
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
                                <div class="company-row">
                                    <div>
                                        <label class="w-auto font-weight-bold">Account #</label>
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="input-md" name="account_number" size="sm" type="text" v-model="formFields.account_number"></b-form-input>
                                    </div>
                                </div>
                                <hr>
                                <div class="company-row">
                                    <div>
                                        <h6 class="my-auto ml-2 custom-form-heading">Company Information</h6>
                                    </div>
                                </div>
                                <div class="company-row">
                                    <div>
                                        <label class="font-weight-bold">Name:</label>
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="input-xl" name="name" size="sm" type="text" v-model="formFields.name"></b-form-input>
                                    </div>
                                </div>
                                <div class="company-row">
                                    <div>
                                        <label class="font-weight-bold">Address:</label>
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="input-xl" name="address" size="sm" type="text" v-model="formFields.address"></b-form-input>
                                    </div>
                                </div>
                                <div class="company-row">
                                    <div>
                                        <label class="font-weight-bold">City:</label>
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="input-md" name="city" size="sm" type="text" v-model="formFields.city"></b-form-input>
                                    </div>
                                    <div>
                                        <label class="w-auto font-weight-bold">State:</label>
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" name="state" size="sm" type="text" v-model="formFields.state"></b-form-input>
                                    </div>
                                    <div>
                                        <label class="w-auto font-weight-bold">Zip:</label>
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="input-xs" name="zip" size="sm" type="text" v-model="formFields.zip"></b-form-input>
                                    </div>
                                </div>
                                <div class="company-row">
                                    <div>
                                        <label class="font-weight-bold">Contact:</label>
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="input-lg" name="contact" size="sm" type="text" v-model="formFields.contact"></b-form-input>
                                    </div>
                                    <div>
                                        <label class="font-weight-bold">Contact #2:</label>
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="input-lg" name="contact-2" size="sm" type="text" v-model="formFields.contact_2"></b-form-input>
                                    </div>
                                </div>
                                <div class="company-row">
                                    <div>
                                        <label class="font-weight-bold">Phone:</label>
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="input-lg" name="phone" size="sm" type="text" v-model="formFields.phone"></b-form-input>
                                    </div>
                                    <div>
                                        <label class="font-weight-bold">Phone #2:</label>
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="input-lg" name="phone-2" size="sm" type="text" v-model="formFields.phone_2"></b-form-input>
                                    </div>
                                </div>
                                <div class="company-row">
                                    <div>
                                        <label class="font-weight-bold">Email:</label>
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="input-lg" name="email" size="sm" type="text" v-model="formFields.email"></b-form-input>
                                    </div>
                                    <div>
                                        <label class="font-weight-bold">Email #2:</label>
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="input-lg" name="email-2" size="sm" type="text" v-model="formFields.email_2"></b-form-input>
                                    </div>
                                </div>
                                <div class="company-row">
                                    <div>
                                        <label class="font-weight-bold">Type</label>
                                        <b-dropdown :disabled="hideInModal" class="input-md border rounded ml-0 cutsom-width-dropdown" no-caret size="sm" toggle-class=""
                                                    variant="none">
                                            <template #button-content>
                                                <div class="d-flex product-color">
                                                    <small>{{customizeLabel(companyTypeTitle)}}</small>
                                                    <small class="w-25 ml-auto custom-caret"></small>
                                                </div>
                                            </template>
                                            <b-dropdown-group class="overflow-auto scroll px-1">
                                                <b-form-input
                                                    class="mt-1"
                                                    placeholder="Search..."
                                                    size="sm"
                                                    v-model="searchCompanyType"
                                                ></b-form-input>
                                                <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                                <template v-if="companyTypes.length > 0">
                                                    <template v-for="(obj, key) of companyTypes">
                                                        <b-dropdown-group @click="handleDropdownChange">
                                                            <b-dropdown-item-button :key="key" @click="setDetail(obj,'company_info_type')"
                                                                                    class="w-100">
                                                                <label class="btn btn-sm m-0">{{obj.text}}</label>
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
                                        <!--<b-dropdown no-caret class="border rounded input-md m-0 py-1 dropdown-width" toggle-class="p-0 py-1 my-n1" size="sm" variant="none" :disabled="hideInModal || hideinAuth">

                                            <template #button-content>
                                                <div class="d-flex">
                                                    <small>{{customerType}}</small>
                                                    <small class="w-25 ml-auto custom-caret-agreement"></small>
                                                </div>
                                            </template>

                                            <b-dropdown-group class="overflow-auto scroll px-1" >
                                                <b-form-input
                                                    size="sm"
                                                    placeholder="Search..."
                                                    class="d-none"
                                                    :disabled="hideInModal || hideinAuth"
                                                ></b-form-input>

                                                <template v-if="customerTypes.length > 0">
                                                    <template v-for="(obj, key) of customerTypeList">
                                                        <b-dropdown-group>
                                                            <b-dropdown-item-button :key="key" @click="formFields.type = obj.text">
                                                                <label class="btn btn-sm m-0 type-list mr-5" >{{obj.text}}</label>
                                                            </b-dropdown-item-button>
                                                        </b-dropdown-group>
                                                    </template>
                                                </template>

                                                <template v-else>
                                                    <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                                </template>
                                            </b-dropdown-group>

                                        </b-dropdown>-->

                                    </div>
                                </div>
                                <div class="company-row">
                                    <div>
                                        <label class="font-weight-bold">Acct Payable:</label>
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="input-lg" name="acct_payable" size="sm" type="text" v-model="formFields.acct_payable"></b-form-input>
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
    import {event, eventBus} from '../../event-bus/event-bus';
    import Toolbar from "./Toolbar";
    import {deleteRecord, fetchRecord, firstRecord, lastRecord, nextRecord, previousRecord, saveRecord} from "../../helpers/axios";

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
                    name: null,
                    account_number: null,
                    address: null,
                    contact: null,
                    contact_2: null,
                    city: null,
                    state: null,
                    zip: null,
                    phone: null,
                    phone_2: null,
                    type: null,
                    company_role_id: null,
                    company_info_type_id: null,
                },
                axiosParams: {module: 'company'},
                axiosParamsType: {module: 'company/type'},
                alertMessage: '',
                searchCompanyType: "",
                hideAlert: true,
                successResponse: false,
                errorResponse: false,
                saveDisabled: false,
                hideinAuth: false,
            }
        },
        metaInfo() {
            return {
                title: `${this.formFields.id ? 'Edit' : 'Add'} Company`,
            }
        },
        created() {
            eventBus.$on(event.SAVE_COMPANY, this.storeCompany);
            eventBus.$on(event.FIRST_CUSTOMER_RECORD, this.first);
            eventBus.$on(event.LAST_CUSTOMER_RECORD, this.last);
            eventBus.$on(event.NEXT_CUSTOMER_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_CUSTOMER_RECORD, this.prev);
            eventBus.$on(event.GET_CUSTOMER, this.getCompany);
            eventBus.$on(event.ADD_CUSTOMER, this.clearForm);
            eventBus.$on(event.DELETE_CUSTOMER, this.deleteRecord);
        },
        destroyed() {
            eventBus.$off(event.SAVE_COMPANY, this.storeCompany);
            eventBus.$off(event.FIRST_CUSTOMER_RECORD, this.first);
            eventBus.$off(event.LAST_CUSTOMER_RECORD, this.last);
            eventBus.$off(event.NEXT_CUSTOMER_RECORD, this.next);
            eventBus.$off(event.PREVIOUS_CUSTOMER_RECORD, this.prev);
            eventBus.$off(event.GET_CUSTOMER, this.getCompany);
            eventBus.$off(event.ADD_CUSTOMER, this.clearForm);
            eventBus.$off(event.DELETE_CUSTOMER, this.deleteRecord);
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
            roles: function () {
                let options = [];
                for (let opt of this.$store.state.company.companyInfo) {
                    let obj = {value: opt.id, text: opt.name};
                    options.push(obj);
                }
                return options;
            },
            companyTypeTitle() {
                let opt = "Select";
                if (this.$store.state[this.axiosParams.module].type.length > 0 && this.formFields.company_info_type_id != 0 && this.formFields.company_info_type_id != null) {
                    opt = this.$store.state[this.axiosParams.module].type.filter(obj => obj.id == this.formFields.company_info_type_id);
                    opt = opt.length > 0 ? opt[0].title : "Select";
                }
                return opt
            },
            companyTypes() {
                let options = [];
                for (let opt of this.$store.state[this.axiosParams.module].type) {
                    let obj = {value: opt.id, text: opt.title, options: opt};
                    options.push(obj);
                }
                if (this.searchCompanyType != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchCompanyType.toUpperCase()) > -1)
                }
                return options;
            },
        },
        components: {
            Toolbar
        },
        beforeCreate() {
            if (this.$store.getters.isAdmin == 'Supper Admin')
                this.$router.push('/access-denied');
            if (!this.$store.getters.isPermitted({resource: 'User', action: 'read'}))
                this.$router.push('/access-denied');
        },
        mounted() {
            // this.formFields.store_id = this.storeID
            this.$store.state[this.axiosParams.module].busy = true
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            if (!this.$store.getters.isPermitted({resource: 'User', action: 'create'}) && !this.$store.getters.isPermitted({resource: 'User', action: 'update'}))
                this.$props.hideInModal = true;
            if (this.formFields.id > 0 && !this.$store.getters.isPermitted({resource: 'User', action: 'update'}))
                this.hideinAuth = true;
            this.getCompany(this.formFields.id);
            this.getColumns();
            this.getRecords();
            this.$store.getters.detectFormChanges();
        },
        methods: {

            /** CRUD */
            getCompany: async function (id) {
                if (id) {
                        this.axiosParams.id = id;
                       await fetchRecord(this.axiosParams, (response) => {
                            this.formFields = response.data;
                           if (this.$store.state[this.axiosParams.module].recordList.length > 0)
                               this.$store.state[this.axiosParams.module].busy = false
                        }, (error) => {
                           console.log(error)
                           this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                       })
                }

                if (this.$store.state.company.companyInfo.length == 0) {
                    this.$store.dispatch('getCompanyInfo');
                }

                if (this.$store.state[this.axiosParams.module].type.length == 0){
                    this.axiosParamsType.id = 0
                    fetchRecord(this.axiosParamsType, (response) => {
                        this.$store.state[this.axiosParams.module].type = response.data
                        this.$store.getters.sortByAlphaNumeric({'fieldName': 'title', 'recordList': this.$store.state[this.axiosParams.module].type});
                    })
                }
            },
            storeCompany: function () {
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
                            id : this.formFields.id,
                            name : this.formFields.name
                        }
                        this.$store.commit('appendOrUpdateDropDown', this.axiosParams)
                    }
                }, (error) => {
                    console.log(error)
                    if (error.response.status == 403) {
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    }
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
                            let params = {module: 'quote', detail: 'company', id: this.axiosParams.id}
                            this.$store.dispatch('removeDetailFromList', params);
                            if (this.$store.state[this.axiosParams.module].recordList.length == 0)
                                this.clearForm();
                        } else {
                            console.log(response.data);
                        }
                    }, (error) => {
                        console.log(error);
                        if (error.response.status == 403) {
                            this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                        }
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
            setDetail(obj, detail) {
                this.formFields[detail + '_id'] = obj.value;
                this.formFields[detail] = obj.text;
            },
            deleteDropDown: function (id) {
                if (confirm('Do you really want to delete this record ?')) {
                    let moduleName = this.axiosParamsType.module;
                    deleteRecord({id: id, module: moduleName}, (response) => {
                        let list = this.$store.state[this.axiosParams.module].type;
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
                let data = {id: 0};
                data[detail] = this.searchCompanyType
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
                        this.$store.state[this.axiosParams.module][recordList].splice(this.$store.state[this.axiosParams.module][recordList].length + 1, 0, response.data)
                    }
                })
            },
            handleDropdownChange: function(value){
                window.detectChanges = true;
            },

            /** Pagination*/
            first: function () {
                    firstRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.formFields = response.data;
                        }
                        this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        console.log(error)
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
                        console.log(error)
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
                        console.log(error)
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
                        console.log(error)
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
                        id: 0, company_info_type_id: null
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
        }
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
</style>
