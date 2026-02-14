<template>
    <div class="d-flex align-items-center w-100">
        <div v-if="isCreatePermitted || isUpdatePermitted" class="toolbar">
            <label class="my-auto mx-2">Go to</label>
            <div class="parent flex-grow-1">
                <b-form-select size="sm"
                               class="input-md form-control-sm rounded-0 custom-caret-toolbar my-1"
                               :options="recordList"
                               v-model="getSelected"
                               @change="getRecord">
                    <template #first>
                        <b-form-select-option :value="null" disabled>Select a record</b-form-select-option>
                    </template>
                </b-form-select>
            </div>
        </div>
        <div class="toolbar">
            <button type="button" v-if="isCreatePermitted" class="btn btn-sm custom-label-toolbar" @click="addRecord">New Record</button>
            <button type="button" v-if="isDeletePermitted" class="btn btn-sm custom-label-toolbar" @click="deleteRecord(id)" :disabled="emptyRecord">Delete Record</button>
        </div>
        <div class="toolbar ml-auto">
            <button type="button" v-if="id ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                {{ id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
            </button>
            <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" to="/order-list">Back To List</router-link>
            <button type="button" class="btn-info mx-1 custom-infobtn-toolbar custom-infobtn-text" @click="printPDF">Print Invoice</button>
            <template v-if="this.id">
                <b-dropdown no-caret class="border rounded dropdown-custom-order" toggle-class="p-0" size="sm"
                            variant="none">
                    <template #button-content>
                        <div class="d-flex text-white">
                            <small>Select the form</small>
                            <i class="fa fa-caret-down ml-auto pl-2" aria-hidden="true"></i>
                        </div>
                    </template>
                    <b-dropdown-group class="overflow-auto scroll px-1" style="height: 13vh;">
                        <template v-for="(obj, key) of orderLinkLists">
                            <b-dropdown-group>
                                <b-dropdown-item-button :key="key">
                                    <router-link class="btn btn-sm m-0 my-n2"
                                                 :to="'/'+obj.link+'/'+obj.id">{{obj.text}}
                                    </router-link>
                                </b-dropdown-item-button>
                            </b-dropdown-group>
                        </template>
                    </b-dropdown-group>
                </b-dropdown>
            </template>
        </div>
        <div class="toolbar ml-auto">
            <div v-if="isReadPermitted" class="d-flex">
                <div class="align-items-center align-self-center custom-pagination-toolbar d-flex">
                    <button type="button" @click="first()" id="first" class="btn btn-xs" :disabled="!id || isFirstRecord" data-toggle="tooltip" data-placement="bottom" title="First">
                        <svg width="14" height="19">
                            <rect width="2" height="19" fill="black"></rect>
                            <path d="M14 19L14 0L5.27193e-07 9.75676L14 19Z" fill="black"></path>
                        </svg>
                    </button>
                    <button type="button" @click="prev(id)" id="previous" class="btn btn-xs" :disabled="!id || isFirstRecord" data-toggle="tooltip" data-placement="bottom" title="Previous">
                        <svg width="14" height="19">
                            <path d="M14 19L14 0L5.27193e-07 9.75676L14 19Z" fill="black"></path>
                        </svg>
                    </button>
                    <button type="button" @click="next(id)" id="next" class="btn btn-xs" :disabled="!id || isLastRecord" data-toggle="tooltip" data-placement="bottom" title="Next">
                        <svg width="14" height="19">
                            <path d="M2.26573e-07 0L0 19L14 9.24324L2.26573e-07 0Z" fill="black"></path>
                        </svg>
                    </button>
                    <button type="button" @click="last" id="last" class="btn btn-xs" :disabled="!id || isLastRecord" data-toggle="tooltip" data-placement="bottom" title="Last">
                        <svg width="16" height="19" fill="none">
                            <path d="M2.26573e-07 0L0 19L14 9.24324L2.26573e-07 0Z" fill="black"></path>
                            <rect x="14" width="2" height="19" fill="black"></rect>
                        </svg>
                    </button>
                </div>
                <div class="my-auto mx-2">
                    <label class="small mt-2" v-if="currentRecord.currentIndex > 0">Record {{currentRecord.currentIndex}} of {{totalRecord}}</label>
                </div>
            </div>
            <div class="d-flex mt-1">
                <img class="toolbar-image mx-1 mt-1" src="/images/video-chat.png" width="26" height="26"/>
                <img class="toolbar-image mx-1" src="/images/help-icon.png" width="30" height="30"/>
            </div>
        </div>
    </div>
</template>

<script>
    import {event, eventBus} from '../../event-bus/event-bus';

    export default {
        name: "Toolbar",
        props: {
            id: {
                type: Number,
                default: null
            },
            saveDisabled: {
                type: Boolean,
                default: false
            },
            totalRecord: {
                type: Number,
                default: 0,
            },
            invoiceNumber: {
                type: Number,
                default: 0
            }
        },
        data() {
            return {
                axiosParams: {module: 'order'},
                orderLinkList: [{value: 1, text: 'Collaboration Form', link: 'collaboration', id: null},
                    {value: 2, text: 'Production Form', link: 'productions', id: null},
                    {value: 3, text: 'Installation Form', link: 'installation', id: null},
                ],
                dropDownLimit: 10,
                dropDownObserver: null,
                dropDownSearch: '',
                selectedLabel: {id: this.$props.id, label: null},
                perPageNumber: 1,
            }
        },
        computed: {
            recordList: function () {
                let options = [];
                for (let opt of this.$store.state[this.axiosParams.module].recordList) {
                    let obj = {
                        value: opt.id,
                        text: opt.invoice ? opt.invoice.invoice_number : opt.invoice,
                    };
                    options.push(obj);
                }
                return options;
            },
            isLastRecord: function () {
                let lastRecord = this.$store.state[this.axiosParams.module].recordList.slice(-1)[0]
                if (lastRecord)
                    return lastRecord.id == this.id
                return false
            },
            isFirstRecord: function () {
                let firstRecord = this.$store.state[this.axiosParams.module].recordList[0]
                if (firstRecord)
                    return firstRecord.id == this.id
                return false
            },
            checkDataIsSet: function(){
                return this.$store.state.checkChangeFormEdit.record.length > 0
            },
            currentRecord: function () {
                let list = this.$store.state[this.axiosParams.module].recordList;
                let record = list.find(obj => obj.id == this.id);
                let currentIndex = list.indexOf(record) + 1;
                return {currentIndex: currentIndex, record: record}
            },
            emptyRecord: function () {
                return this.totalRecord == 0 || this.$props.id == 0;
                // return this.$store.state[this.axiosParams.module].recordList.length == 0 || this.$props.id == 0;
            },
            isCreatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Orders', action: 'create'});
            },
            isReadPermitted() {
                return this.$store.getters.isPermitted({resource: 'Orders', action: 'read'});
            },
            isUpdatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Orders', action: 'update'});
            },
            isDeletePermitted() {
                return this.$store.getters.isPermitted({resource: 'Orders', action: 'delete'});
            },
            orderLinkLists() {
                let record = this.$store.state[this.axiosParams.module].currentRecord
                if (record != undefined) {
                    this.$store.getters.setOrderCollabProdInstallID({record: record, recordList: this.orderLinkList});
                }
                return this.$store.getters.sortByAlphaNumeric({'fieldName': 'text', 'recordList': this.orderLinkList});
            },
            /**
             * Directly placing id in v-model causing error "can not change prop in child component", so that's why
             using computed property to only get value and setting nothing in return
             */
            getSelected: {
                get() {
                    return this.$props.id
                },
                set(value) {
                    return value
                },
            }
        },
        methods: {
            sortDropDown: function () {
                let sortInvoiceNumber = this.$store.state[this.axiosParams.module].recordList;
                sortInvoiceNumber.sort((obj, o) => o.invoice.invoice_number - obj.invoice.invoice_number);
            },
            save: function () {
                eventBus.$emit(event.SAVE_ORDER);
            },
            first: function () {
                eventBus.$emit(event.FIRST_ORDER_RECORD);
            },
            last: function () {
                eventBus.$emit(event.LAST_ORDER_RECORD);
            },
            next: function (id) {
                eventBus.$emit(event.NEXT_ORDER_RECORD, id);
            },
            prev: function (id) {
                eventBus.$emit(event.PREVIOUS_ORDER_RECORD, id);
            },
            getRecord: function (value) {
                this.$store.state[this.axiosParams.module].busy = true
                eventBus.$emit(event.GET_ORDER, value);
            },
            addRecord: function () {
                eventBus.$emit(event.ADD_ORDER);
            },
            deleteRecord: function (id) {
                eventBus.$emit(event.DELETE_ORDER, id);
            },
            printPDF() {
                eventBus.$emit(event.SHOW_HIDE_COMPOSITE_PRODUCT, true);
                this.$store.state[this.axiosParams.module].showHidePDF = false;
                setTimeout(() => eventBus.$emit(event.PRINT_PDF), 500);
                setTimeout(() => eventBus.$emit(event.SHOW_HIDE_COMPOSITE_PRODUCT, false), 1000);
            },
        }
    }
</script>

<style scoped>
    .toolbar {
        display: flex;
        margin: 0 1rem;
    }

    .input-lg {
        width: 8rem;
    }

</style>
