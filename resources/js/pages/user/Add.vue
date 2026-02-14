<template>
    <div>
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} User Information</h5>
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
                                    <h6 class="my-auto ml-2 custom-form-heading">User Information</h6>
                                </div>
                            </div>
                            <div class="company-row">
                                <div>
                                    <label class="font-weight-bold">Name:</label>
                                    <b-form-input :disabled="hideInModal" class="input-xl" name="name" size="sm" type="text" v-model="formFields.name"></b-form-input>
                                </div>
                            </div>
                            <div class="company-row">
                                <div>
                                    <label class="font-weight-bold">Email Address:</label>
                                    <b-form-input :disabled="hideInModal" class="input-xl" name="address" size="sm" type="text" v-model="formFields.email"></b-form-input>
                                </div>
                            </div>
                            <div class="company-row">
                                <div>
                                    <label class="font-weight-bold">Phone:</label>
                                    <b-form-input :disabled="hideInModal" class="input-xl" name="contact" size="sm" type="text" v-model="formFields.phone_number"></b-form-input>
                                </div>
                            </div>
                            <div class="company-row">
                                <div>
                                    <label class="font-weight-bold">User Role</label>
                                    <b-dropdown :disabled="hideInModal" class="border rounded input-lg m-0 py-1 dropdown-width" no-caret size="sm" toggle-class="p-0 py-1 my-n1" variant="none">
                                        <template #button-content>
                                            <div class="d-flex">
                                                <small>{{userType}}</small>
                                                <small class="w-25 ml-auto custom-caret-agreement"></small>
                                            </div>
                                        </template>
                                        <b-dropdown-group class="overflow-auto scroll px-1">
                                            <b-form-input
                                                :disabled="hideInModal"
                                                class="d-none"
                                                placeholder="Search..."
                                                size="sm"
                                            ></b-form-input>
                                            <template v-if="roles.length > 0">
                                                <template v-for="(obj, key) of roles">
                                                    <b-dropdown-group @click="handleDropdownChange">
                                                        <b-dropdown-item-button :key="key" @click="formFields.role_id = obj.value">
                                                            <label class="btn btn-sm m-0 type-list mr-5">{{obj.text}}</label>
                                                        </b-dropdown-item-button>
                                                    </b-dropdown-group>
                                                </template>
                                            </template>
                                            <template v-else>
                                                <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                            </template>
                                        </b-dropdown-group>
                                    </b-dropdown>
                                </div>
                                <div>
                                    <label class="font-weight-bold">User Status</label>
                                    <b-dropdown :disabled="hideInModal" class="border rounded input-lg m-0 py-1 dropdown-width" no-caret size="sm" toggle-class="p-0 py-1 my-n1" variant="none">
                                        <template #button-content>
                                            <div class="d-flex">
                                                <small>{{loginStatus}}</small>
                                                <small class="w-25 ml-auto custom-caret-agreement"></small>
                                            </div>
                                        </template>
                                        <b-dropdown-group class="overflow-auto scroll px-1">
                                            <b-form-input
                                                :disabled="hideInModal"
                                                class="d-none"
                                                placeholder="Search..."
                                                size="sm"
                                            ></b-form-input>
                                            <template v-if="userStatus.length > 0">
                                                <template v-for="(obj, key) of userStatus">
                                                    <b-dropdown-group @click="handleDropdownChange">
                                                        <b-dropdown-item-button :key="key" @click="formFields.status = obj.val">
                                                            <label class="btn btn-sm m-0 type-list mr-5">{{obj.text}}</label>
                                                        </b-dropdown-item-button>
                                                    </b-dropdown-group>
                                                </template>
                                            </template>
                                            <template v-else>
                                                <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                            </template>
                                        </b-dropdown-group>
                                    </b-dropdown>

                                </div>
                            </div>
                            <!--<div class="company-row" v-if="isSupperAdmin">
                                <div>
                                    <label class="font-weight-bold">Store Domain:</label>
                                    <b-form-input type="text" :disabled="hideInModal" class="input-lg" name="store-domain" size="sm"
                                    v-model="formFields.store.subdomain"></b-form-input>
                                </div>
                            </div>-->
                            <div>
                                <br>
                                <hr>
                                <div class="company-row" v-if="!hideInModal">
                                    <div>
                                        <h6 class="my-auto ml-2 custom-form-heading">Family Information</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="company-row" v-if="!hideInModal">
                                <div>
                                    <label class="font-weight-bold">Family</label>
                                    <b-dropdown class="dropdown b-dropdown border rounded input-lg m-0 dropdown-width btn-group" no-caret size="sm"
                                                style="width: 12rem; height: 27px;" toggle-class="p-0" variant="none">
                                        <template #button-content>
                                            <div class="d-flex">
                                                <small>{{userFamily}}</small>
                                                <small class="w-25 ml-auto custom-caret-form"></small>
                                            </div>
                                        </template>
                                        <b-dropdown-group class="overflow-auto scroll px-1">
                                            <b-form-input
                                                class="mt-1"
                                                placeholder="Search..."
                                                size="sm"
                                                v-model="searchUserFamily"
                                            ></b-form-input>
                                            <template v-if="userFamilies.length > 0">
                                                <template v-for="(obj, key) of userFamilies">
                                                    <b-dropdown-group @click="handleDropdownChange">
                                                        <b-dropdown-item-button :key="key" @click="setUserFamily(userFamilyStatus.familyId = obj.value)"
                                                                                class="small">
                                                            {{obj.text}}
                                                        </b-dropdown-item-button>
                                                    </b-dropdown-group>
                                                </template>
                                            </template>
                                            <template v-else>
                                                <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
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
    import {event, eventBus} from '../../event-bus/event-bus';
    import Toolbar from "./Toolbar";
    import {deleteRecord, fetchRecord, firstRecord, lastRecord, nextRecord, previousRecord, saveRecord,} from "../../helpers/axios";

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
                formFields: {
                    id: 0,
                    name: null,
                    email: null,
                    phone_number: null,
                    role_id: null,
                    status: null,
                    family: null,
                    store: {
                        subdomain: null
                    }
                },
                userFamilyStatus: {
                    familyId: null,
                },
                userStatus: [
                    {val: 1, text: 'Active'},
                    {val: 0, text: 'Inactive'},
                ],
                axiosParams: {module: 'user'},
                axiosAddEditParams: {module: 'userAddEdit'},
                alertMessage: '',
                searchUserFamily: "",
                hideAlert: true,
                successResponse: false,
                errorResponse: false,
                saveDisabled: false,
            }
        },
        metaInfo() {
            return {
                title: `${this.formFields.id ? 'Edit' : 'Add'} User`,
            }
        },
        created() {
            eventBus.$on(event.SAVE_USER, this.storeUser);
            eventBus.$on(event.FIRST_USER_RECORD, this.first);
            eventBus.$on(event.LAST_USER_RECORD, this.last);
            eventBus.$on(event.NEXT_USER_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_USER_RECORD, this.prev);
            eventBus.$on(event.GET_USER, this.getUser);
            eventBus.$on(event.ADD_USER, this.clearForm);
            eventBus.$on(event.DELETE_USER, this.deleteRecord);
        },
        destroyed() {
            eventBus.$off(event.SAVE_USER, this.storeUser);
            eventBus.$off(event.FIRST_USER_RECORD, this.first);
            eventBus.$off(event.LAST_USER_RECORD, this.last);
            eventBus.$off(event.NEXT_USER_RECORD, this.next);
            eventBus.$off(event.PREVIOUS_USER_RECORD, this.prev);
            eventBus.$off(event.GET_USER, this.getUser);
            eventBus.$off(event.ADD_USER, this.clearForm);
            eventBus.$off(event.DELETE_USER, this.deleteRecord);
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
                this.$store.getters.getModuleAddEdit({parentModule: 'user', childModule: 'userAddEdit'});
                this.$store.getters.sortByAlphaNumeric({'module': 'userRole', 'fieldName': 'title'});
                //this.$store.getters.sortByAlphaNumeric({'module': 'userAddEdit', 'fieldName': 'email'});
                let options = [];
                for (let opt of this.$store.state.userRole.recordList) {
                    let obj = {value: opt.id, text: opt.title};
                    options.push(obj);
                }
                return options;
            },
            userType() {
                let opt = "Select";
                if (this.formFields.role_id != null) {
                    opt = this.$store.state.userRole.recordList.filter(obj => obj.id == this.formFields.role_id);
                    opt = opt.length > 0 ? opt[0].title : opt;
                }
                return opt
            },
            userFamily() {
                let opt = "Select";
                if (this.userFamilyStatus.familyId != null) {
                    opt = this.$store.state.user.userFamilies.filter(obj => obj.id == this.userFamilyStatus.familyId);
                    if (opt[0].email)
                        opt = opt.length > 0 ? opt[0].email : opt;
                }
                return opt
            },
            userFamilies() {
                this.$store.getters.sortByAlphaNumeric({'fieldName': 'email', 'recordList': this.$store.state.user.userFamilies});
                let options = [];
                for (let opt of this.$store.state.user.userFamilies) {
                    let obj = {value: opt.id, text: opt.email};
                    if (obj.text)
                        options.push(obj);
                }
                if (this.searchUserFamily != '') {
                    options = options.filter(obj => obj.text.toUpperCase().indexOf(this.searchUserFamily.toUpperCase()) > -1)
                }
                return options;
            },
            loginStatus() {
                let opt = "Select";
                if (this.formFields.status != null) {
                    opt = this.userStatus.filter(obj => obj.val == this.formFields.status);
                    opt = opt.length > 0 ? opt[0].text : opt;
                }
                return opt
            },
            isSupperAdmin() {
                return this.$store.getters.isAdmin == 'Supper Admin' ? true : false
            },
        },
        components: {
            Toolbar
        },
        beforeCreate() {
            if (this.$store.getters.isAdmin != 'Admin' && this.$store.getters.isAdmin != 'Supper Admin')
                this.$router.push('/access-denied');
        },
        mounted() {
            this.$store.state[this.axiosParams.module].busy = true
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            this.getRecords();
            this.getUser(this.formFields.id);
            this.$store.getters.detectFormChanges();
        },
        methods: {

            /** CRUD */
            getUser: function (id) {
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
                if (this.$store.state.userRole.recordList.length == 0)
                    this.$store.dispatch('getModuleInfo', {module: 'userRole'});
                if (this.$store.state[this.axiosParams.module].columnList.length == 0)
                    this.$store.dispatch('getColumnList', this.axiosParams);
                if (this.$store.state[this.axiosParams.module].userFamilies.length == 0)
                    this.$store.dispatch('getUserFamiliesInfo', this.axiosParams);
            },
            setUserFamily: function (id) {
                if (id) {
                    let record = Object.values(this.$store.state.user.userFamilies).find(obj => obj.id == id);
                    this.formFields.family = 1;
                    this.formFields.email = record.email;
                    this.formFields.phone_number = record.phone;
                    this.formFields.name = record.name_on_stone;
                    record = '';
                }
            },
            storeUser: function () {
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
                        let emailMessage = " and email has been sent to user!!";
                        this.makeToast({title: "User " + status, message: status == "Added" ? this.alertMessage + emailMessage : this.alertMessage, variant: "success", duration: 5000});
                        this.successResponse = false;
                        this.alertMessage = '';
                        this.formFields = response.data;
                        /*this.axiosParams.data = response.data;
                        this.axiosAddEditParams.data = response.data;
                        this.$store.commit('appendOrUpdateInRecordList', this.axiosParams);*/
                        this.axiosParams.data = {
                            id : this.formFields.id,
                            email : this.formFields.email
                        }
                        this.$store.commit('appendOrUpdateDropDown', this.axiosParams)
                    }
                })
            },
            deleteRecord: function (id) {
                if (confirm("Do you really want to delete this record?")) {
                    this.axiosParams.id = id;
                    this.$store.dispatch('removeRecordFromList', this.axiosParams);
                    deleteRecord(this.axiosParams, (response) => {
                        if (response.data) {
                            if (this.$store.state[this.axiosAddEditParams.module].recordList.length == 0) {
                                this.clearForm();
                            } else {
                               // this.formFields = this.$store.state[this.axiosAddEditParams.module].firstRecord;
                                this.first()
                                let params = {module: 'quote', detail: 'company', id: this.axiosParams.id}
                                this.$store.dispatch('removeDetailFromList', params);
                            }
                        } else {
                            console.log(response.data);
                        }
                    })
                }
            },
            getRecords() {
                // this.$store.dispatch('getModuleInfo', this.axiosParams)
                if (!this.hideInModal)
                    this.$store.dispatch('getDropDownInfo', {module: this.axiosParams.module, apiURL: 'getDropDownRecord', page: this.pageNumber})
            },
            handleDropdownChange: function(value){
                window.detectChanges = true;
            },


            /** Pagination*/
            first: function () {
                let firstIndex = this.$store.state[this.axiosParams.module].recordList[0]
                if (firstIndex) {
                    this.axiosParams.id = firstIndex.id;
                    nextRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            if (response.data.role.title != 'Admin')
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
                            if (response.data.role.title != 'Admin')
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
                            if (response.data.role.title != 'Admin')
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
                            if (response.data.role.title != 'Admin')
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
                        role_id: null,
                        status: null,
                        email: null,
                        family: null,
                        name: null,
                        phone_number: null,
                        store: {
                            subdomain: null
                        }
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

    .input-email {
        width: 15.4rem;
    }

    .product-color {
        color: #6C757D;
    }
</style>
