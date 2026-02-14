<template>

    <div class="d-flex align-items-center w-100">

        <div v-if="isCreatePermitted || isUpdatePermitted" class="toolbar">
            <label class="my-auto mx-2">Go to</label>

            <div class="flex-grow-1">
                <b-form-select size="sm"
                               class="input-md form-control-sm rounded-0 custom-caret-toolbar my-1"
                               :options="recordList"
                               v-model="getSelected"
                               @change="getRecord">
                    <!-- This slot appears above the options from 'options' prop -->
                    <template #first>
                        <b-form-select-option :value="null" disabled >Select a record</b-form-select-option>
                    </template>
                </b-form-select>

            </div>

        </div>

        <div class="toolbar">
            <button type="button" v-if="isCreatePermitted" class="btn btn-sm custom-label-toolbar" @click="addRecord">New Record</button>
            <button type="button" v-if="isDeletePermitted" :disabled="emptyRecord"  class="btn btn-sm custom-label-toolbar" @click="deleteRecord(id)">Delete Record</button>
        </div>

        <div class="toolbar ml-auto">
            <button type="button" v-if="id ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                {{ id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
            </button>
            <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" to="/resource-list">Back To List</router-link>
        </div>

        <div class="toolbar ml-auto">

            <div v-if="isReadPermitted" class="d-flex">
                <div class="align-items-center align-self-center custom-pagination-toolbar d-flex">
                    <button type="button" @click="first()" id="first" class="btn btn-xs"  :disabled="!id" data-toggle="tooltip" data-placement="bottom" title="First">
                        <svg width="14" height="19">
                            <rect width="2" height="19" fill="black"></rect>
                            <path d="M14 19L14 0L5.27193e-07 9.75676L14 19Z" fill="black"></path>
                        </svg>
                    </button>
                    <button type="button" @click="prev(id)" id="previous" class="btn btn-xs"  :disabled="!id" data-toggle="tooltip" data-placement="bottom" title="Previous">
                        <svg width="14" height="19">
                            <path d="M14 19L14 0L5.27193e-07 9.75676L14 19Z" fill="black"></path>
                        </svg>
                    </button>
                    <button type="button" @click="next(id)" id="next" class="btn btn-xs" :disabled="!id" data-toggle="tooltip" data-placement="bottom" title="Next">
                        <svg width="14" height="19">
                            <path d="M2.26573e-07 0L0 19L14 9.24324L2.26573e-07 0Z" fill="black"></path>
                        </svg>
                    </button>
                    <button type="button" @click="last" id="last" class="btn btn-xs" :disabled="!id" data-toggle="tooltip" data-placement="bottom" title="Last">
                        <svg width="16" height="19" fill="none">
                            <path d="M2.26573e-07 0L0 19L14 9.24324L2.26573e-07 0Z" fill="black"></path>
                            <rect x="14" width="2" height="19" fill="black"></rect>
                        </svg>
                    </button>
                    <!--<span>
                        <svg width="2" height="26" viewBox="0 0 2 26" fill="none">
                            <path d="M1 0V26" stroke="black" stroke-opacity="0.39" stroke-width="0.5"></path>
                        </svg>
                    </span>
                    <button type="button" disabled @click="" id="sort" class="btn btn-xs">
                        <svg width="27" height="25" fill="none">
                            <path d="M11 11L0 11L5.64865 15L11 11Z" fill="black"></path>
                            <path d="M27 11L16 11L21.6486 15L27 11Z" fill="black"></path>
                            <path d="M3.11328 9L5.28125 3.25781H5.72266H6.16797L8.23047 9H7.8125H7.39453L6.8125 7.33594H4.51562L3.91406 9H3.51562H3.11328ZM5.6875 4.10156L4.76562 6.64844H6.57422L5.6875 4.10156Z" fill="black"></path>
                            <path d="M19.1836 8.32422L22.7266 3.94531H19.4609V3.60156V3.25781H23.6992V3.59375V3.93359L20.1562 8.3125H23.6953V8.65625V9H19.1836V8.66406V8.32422Z" fill="black"></path>
                            <path d="M3.18359 22.3242L6.72656 17.9453H3.46094V17.6016V17.2578H7.69922V17.5938V17.9336L4.15625 22.3125H7.69531V22.6562V23H3.18359V22.6641V22.3242Z" fill="black"></path>
                            <path d="M19.1133 23L21.2812 17.2578H21.7227H22.168L24.2305 23H23.8125H23.3945L22.8125 21.3359H20.5156L19.9141 23H19.5156H19.1133ZM21.6875 18.1016L20.7656 20.6484H22.5742L21.6875 18.1016Z" fill="black"></path>
                        </svg>
                    </button>-->
                </div>
                <div class="my-auto mx-2">
                    <label class="small mt-2" v-if="currentRecord > 0">Record {{currentRecord}} of {{totalRecords}}</label>
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
    import { event , eventBus } from '../../../event-bus/event-bus';
    export default {
        name: "Toolbar",
        props: {
            id:{
                type: Number,
                default: null
            },
            saveDisabled:{
                type: Boolean,
                default: false
            }
        },
        computed:{
            recordList: function () {
                let options = [];
                for (let opt of this.$store.state[this.axiosParams.module].recordList){
                    let obj = {value: opt.id, text: opt.id};
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
            isCreatePermitted(){
                return this.$store.getters.isPermitted({resource:'Setting',action:'create'});
            },
            isReadPermitted(){
                return this.$store.getters.isPermitted({resource:'Setting',action:'read'});
            },
            isUpdatePermitted(){
                return this.$store.getters.isPermitted({resource:'Setting',action:'update'});
            },
            isDeletePermitted(){
                return this.$store.getters.isPermitted({resource:'Setting',action:'delete'});
            },
            /**
             * Directly placing id in v-model causing error "can not change prop in child component", so that's why
             using computed property to only get value and setting nothing in return
             */
            getSelected: {
                get () { return this.$props.id },
                set (value) { return value },
            }
        },
        data(){
            return {
                axiosParams: {module: 'userResources'},
            }
        },
        methods: {
            save:function(){
                eventBus.$emit(event.SAVE_RESOURCE);
            },
            first: function(){
                eventBus.$emit(event.FIRST_RESOURCE_RECORD);
            },
            last: function(){
                eventBus.$emit(event.LAST_RESOURCE_RECORD);
            },
            next: function(id){
                eventBus.$emit(event.NEXT_RESOURCE_RECORD, id);
            },
            prev: function(id){
                eventBus.$emit(event.PREVIOUS_RESOURCE_RECORD, id);
            },
            getRecord: function (value) {
                eventBus.$emit(event.GET_RESOURCE, value);
            },
            addRecord: function () {
                eventBus.$emit(event.ADD_RESOURCE);
            },
            deleteRecord: function (id) {
                eventBus.$emit(event.DELETE_RESOURCE, id);
            }
        }
    }
</script>

<style scoped>
    .toolbar
    {
        display: flex;
        margin: 0 1rem;
    }
    .input-md{
        width: 8rem;
    }
</style>
