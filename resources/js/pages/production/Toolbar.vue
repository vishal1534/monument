<template>
    <div class="d-flex align-items-center w-100">

        <div class="toolbar" v-if="isCreatePermitted || isUpdatePermitted">
            <label class="my-auto mx-2">Go to</label>

            <div class="flex-grow-1">
                <b-form-select :options="recordList"
                               @change="getRecord"
                               class="input-md form-control-sm rounded-0 custom-caret-toolbar my-1"
                               size="sm"
                               v-model="getSelected">
                    <!-- This slot appears above the options from 'options' prop -->
                    <template #first>
                        <b-form-select-option :value="null" disabled>Select a record</b-form-select-option>
                    </template>
                </b-form-select>

            </div>

        </div>

        <div class="toolbar">
            <!--<button type="button" v-if="isCreatePermitted" class="btn btn-sm custom-label-toolbar" @click="addRecord">New Record</button>
            <button type="button" v-if="isDeletePermitted" :disabled ="emptyRecord" class="btn btn-sm custom-label-toolbar" @click="deleteRecord(id)">Delete Record</button>
        -->
        </div>

        <div class="toolbar ml-auto">
            <button :disabled="saveDisabled" @click="save" class="btn-info mx-1 custom-infobtn-toolbar custom-infobtn-text" type="button" v-if="id ? isUpdatePermitted : isCreatePermitted">
                {{ id ? 'Update' : 'Save' }}<span class="spinner-grow spinner-grow-sm ml-1" v-if="saveDisabled"></span>
            </button>
            <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" to="/production-list">Back To List</router-link>
            <template v-if="this.id">
                <b-dropdown class="border rounded dropdown-custom-order" no-caret size="sm" toggle-class="p-0"
                            variant="none">
                    <template #button-content>
                        <div class="d-flex text-white">
                            <small>Select the form</small>
                            <i aria-hidden="true" class="fa fa-caret-down ml-auto pl-2"></i>
                        </div>
                    </template>
                    <b-dropdown-group class="overflow-auto scroll px-1" style="height: 13vh;">
                        <template v-for="(obj, key) of orderLinkLists">
                            <b-dropdown-group>
                                <b-dropdown-item-button :key="key">
                                    <router-link :to="'/'+obj.link+'/'+obj.id"
                                                 class="btn btn-sm m-0 my-n2">{{obj.text}}
                                    </router-link>
                                </b-dropdown-item-button>
                            </b-dropdown-group>
                        </template>
                    </b-dropdown-group>
                </b-dropdown>
            </template>
            <button type="button" class="btn-info mx-1 custom-infobtn-toolbar custom-infobtn-text" @click="printPDF">Print Preview</button>
        </div>

        <div class="toolbar ml-auto">

            <div class="d-flex" v-if="isReadPermitted">
                <div class="align-items-center align-self-center custom-pagination-toolbar d-flex">
                    <button :disabled="!id || isFirstRecord" @click="first()" class="btn btn-xs" data-placement="bottom" data-toggle="tooltip" id="first" title="First" type="button">
                        <svg height="19" width="14">
                            <rect fill="black" height="19" width="2"></rect>
                            <path d="M14 19L14 0L5.27193e-07 9.75676L14 19Z" fill="black"></path>
                        </svg>
                    </button>
                    <button :disabled="!id || isFirstRecord" @click="prev(id)" class="btn btn-xs" data-placement="bottom" data-toggle="tooltip" id="previous" title="Previous" type="button">
                        <svg height="19" width="14">
                            <path d="M14 19L14 0L5.27193e-07 9.75676L14 19Z" fill="black"></path>
                        </svg>
                    </button>
                    <button :disabled="!id || isLastRecord" @click="next(id)" class="btn btn-xs" data-placement="bottom" data-toggle="tooltip" id="next" title="Next" type="button">
                        <svg height="19" width="14">
                            <path d="M2.26573e-07 0L0 19L14 9.24324L2.26573e-07 0Z" fill="black"></path>
                        </svg>
                    </button>
                    <button :disabled="!id || isLastRecord" @click="last" class="btn btn-xs" data-placement="bottom" data-toggle="tooltip" id="last" title="Last" type="button">
                        <svg fill="none" height="19" width="16">
                            <path d="M2.26573e-07 0L0 19L14 9.24324L2.26573e-07 0Z" fill="black"></path>
                            <rect fill="black" height="19" width="2" x="14"></rect>
                        </svg>
                    </button>
                </div>
                <div class="my-auto mx-2">
                    <label class="small mt-2" v-if="currentRecord > 0">Record {{currentRecord}} of {{totalRecords}}</label>
                </div>
            </div>

            <div class="d-flex mt-1">
                <img class="toolbar-image mx-1 mt-1" height="26" src="/images/video-chat.png" width="26"/>
                <img class="toolbar-image mx-1" height="30" src="/images/help-icon.png" width="30"/>
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
            }
        },
        computed: {
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
            recordList: function () {
                let options = [];
                for (let opt of this.$store.state[this.axiosParams.module].recordList) {
                    let obj = {value: opt.id, text: opt.order.invoice.invoice_number};
                    options.push(obj);
                }
                return options;
            },
            totalRecords: function () {
                return this.$store.state[this.axiosParams.module].recordList.length;
            },
            currentRecord: function () {
                let list = this.$store.state[this.axiosParams.module].recordList;
                let record = list.find(obj => obj.id == this.id);
                let currentIndex = list.indexOf(record) + 1;
                return currentIndex
            },
            emptyRecord: function () {
                return this.$store.state[this.axiosParams.module].recordList.length == 0 || this.$props.id == 0;
            },
            isCreatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Production', action: 'create'});
            },
            isReadPermitted() {
                return this.$store.getters.isPermitted({resource: 'Production', action: 'read'});
            },
            isUpdatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Production', action: 'update'});
            },
            isDeletePermitted() {
                return this.$store.getters.isPermitted({resource: 'Production', action: 'delete'});
            },
            orderLinkLists() {
                //let record = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == this.id);
                let record = this.$store.state[this.axiosParams.module].currentRecord
                if (record.order) {
                    this.$store.getters.setOrderCollabProdInstallID({record: record.order, recordList: this.orderLinkList});
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
        data() {
            return {
                axiosParams: {module: 'production'},
                orderLinkList: [{value: 1, text: 'Order Form', link: 'orders', id: null},
                    {value: 2, text: 'Collaboration Form', link: 'collaboration', id: null},
                    {value: 3, text: 'Installation Form', link: 'installation', id: null},
                ],
            }
        },
        methods: {
            save: function () {
                eventBus.$emit(event.SAVE_PRODUCTION);
            },
            first: function () {
                this.$store.state[this.axiosParams.module].busy = true
                eventBus.$emit(event.FIRST_PRODUCTION_RECORD);
            },
            last: function () {
                this.$store.state[this.axiosParams.module].busy = true
                eventBus.$emit(event.LAST_PRODUCTION_RECORD);
            },
            next: function (id) {
                this.$store.state[this.axiosParams.module].busy = true
                eventBus.$emit(event.NEXT_PRODUCTION_RECORD, id);
            },
            prev: function (id) {
                this.$store.state[this.axiosParams.module].busy = true
                eventBus.$emit(event.PREVIOUS_PRODUCTION_RECORD, id);
            },
            getRecord: function (value) {
                this.$store.state[this.axiosParams.module].busy = true
                eventBus.$emit(event.GET_PRODUCTION, value);
            },
            addRecord: function () {
                eventBus.$emit(event.ADD_PRODUCTION);
            },
            deleteRecord: function (id) {
                eventBus.$emit(event.DELETE_PRODUCTION, id);
            },
            printPDF() {
                 eventBus.$emit(event.PRINT_PDF);
            },
        }
    }
</script>

<style scoped>
    .toolbar {
        display: flex;
        margin: 0 1rem;
    }

    .input-md {
        width: 8rem;
    }
</style>
