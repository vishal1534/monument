<template>
    <div class="d-flex align-items-center w-100">
        <div class="toolbar" v-if="isCreatePermitted || isUpdatePermitted">
            <div class="m-0">
                <b-dropdown menu-class="p-0 m-0 custom-dropdown-ul" no-caret size="sm" variant="none">
                    <template #button-content>
                        <div class="d-flex input-md form-control-sm rounded-0 custom-caret-toolbar my-1">
                            <label>{{getSelected[0] ? getSelected[0].text : 'Go To' }}</label>
                        </div>
                    </template>
                    <b-dropdown-group class="overflow-auto scroll">
                        <div>
                            <div class="bg-toolbar text-center">
                                <label class="m-0">Week No.</label>
                            </div>
                            <div class="mt-2 mx-2 d-flex flex-column">
                                <b-form-input
                                    class="h-100 py-1"
                                    size="sm"
                                    v-model="searchTerm"
                                ></b-form-input>
                            </div>
                        </div>
                        <template v-for="obj of recordList">
                            <b-dropdown-group class="mx-2">
                                <b-dropdown-item-button @click="getRecord(obj.value)">
                                    <label>{{obj.text}}</label>
                                </b-dropdown-item-button>
                            </b-dropdown-group>
                        </template>
                    </b-dropdown-group>
                </b-dropdown>
            </div>
        </div>
        <div class="toolbar">
            <button @click="addRecord" class="btn btn-sm custom-label-toolbar" type="button" v-if="isCreatePermitted">New Record</button>
            <button @click="deleteRecord(id)" class="btn btn-sm custom-label-toolbar" type="button" v-if="isDeletePermitted">Delete Record</button>
        </div>
        <div class="toolbar ml-auto">
            <button :disabled="saveDisabled" @click="save" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" type="button" v-if="id ? isUpdatePermitted : isCreatePermitted">
                {{ id ? 'Update' : 'Save' }}<span class="spinner-grow spinner-grow-sm ml-1" v-if="saveDisabled"></span>
            </button>
            <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" to="/installation-production-list">Back To List</router-link>
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
    import {event, eventBus} from '../../../../event-bus/event-bus';

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
                    let obj = {value: opt.id, text: opt.week_of.toString()};
                    options.push(obj);
                }
                if (this.searchTerm != '') {
                    options = options.filter(obj => obj.text.toUpperCase().indexOf(this.searchTerm.toUpperCase()) > -1)
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
            isCreatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Installation', action: 'create'});
            },
            isReadPermitted() {
                return this.$store.getters.isPermitted({resource: 'Installation', action: 'read'});
            },
            isUpdatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Installation', action: 'update'});
            },
            isDeletePermitted() {
                return this.$store.getters.isPermitted({resource: 'Installation', action: 'delete'});
            },
            /**
             * Directly placing id in v-model causing error "can not change prop in child component", so that's why
             using computed property to only get value and setting nothing in return
             */
            getSelected() {
                return this.recordList.filter(obj => obj.value == this.id)
            },
        },
        data() {
            return {
                axiosParams: {module: 'installationProduction'},
                searchTerm: "",
            }
        },
        methods: {
            save: function () {
                eventBus.$emit(event.SAVE_INSTALLATION_PRODUCTION);
            },
            first: function () {
                this.$store.state[this.axiosParams.module].busy = true
                eventBus.$emit(event.FIRST_INSTALLATION_PRODUCTION_RECORD);
            },
            last: function () {
                this.$store.state[this.axiosParams.module].busy = true
                eventBus.$emit(event.LAST_INSTALLATION_PRODUCTION_RECORD);
            },
            next: function (id) {
                this.$store.state[this.axiosParams.module].busy = true
                eventBus.$emit(event.NEXT_INSTALLATION_PRODUCTION_RECORD, id);
            },
            prev: function (id) {
                this.$store.state[this.axiosParams.module].busy = true
                eventBus.$emit(event.PREVIOUS_INSTALLATION_PRODUCTION_RECORD, id);
            },
            getRecord: function (value) {
                this.$store.state[this.axiosParams.module].busy = true
                eventBus.$emit(event.GET_INSTALLATION_PRODUCTION, value);
            },
            addRecord: function () {
                eventBus.$emit(event.ADD_INSTALLATION_PRODUCTION);
            },
            deleteRecord: function (id) {
                eventBus.$emit(event.DELETE_INSTALLATION_PRODUCTION, id);
            }
        }
    }
</script>

<style scoped>
    .toolbar {
        display: flex;
        margin: 0 1rem;
    }

    .input-md {
        width: 6rem;
    }
</style>
