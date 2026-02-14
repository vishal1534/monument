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
                   <template #first>
                        <b-form-select-option :value="null" disabled >Select a record</b-form-select-option>
                    </template>
                </b-form-select>
            </div>
        </div>
        <div class="toolbar">
            <button type="button" v-if="isCreatePermitted" class="btn btn-sm custom-label-toolbar"  @click="addRecord">New Record</button>
            <button type="button" v-if="isDeletePermitted" :disabled="emptyRecord" class="btn btn-sm custom-label-toolbar" @click="deleteRecord(id)">Delete Record</button>
        </div>
        <div class="toolbar ml-auto">
            <button type="button" v-if="id ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                {{ id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
            </button>
            <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" to="/cemetery-list">Back To List</router-link>
        </div>
        <div class="toolbar ml-auto">
            <div v-if="isReadPermitted" class="d-flex">
                <div  class="align-items-center align-self-center custom-pagination-toolbar d-flex">
                    <button type="button" @click="first()" id="first" class="btn btn-xs"  :disabled="!id || isFirstRecord" data-toggle="tooltip" data-placement="bottom" title="First">
                        <svg width="14" height="19">
                            <rect width="2" height="19" fill="black"></rect>
                            <path d="M14 19L14 0L5.27193e-07 9.75676L14 19Z" fill="black"></path>
                        </svg>
                    </button>
                    <button type="button" @click="prev(id)" id="previous" class="btn btn-xs"  :disabled="!id || isFirstRecord" data-toggle="tooltip" data-placement="bottom" title="Previous">
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
                    <label class="small mt-2" v-if="currentRecord.currentIndex > 0">Record {{currentRecord.currentIndex}} of {{totalRecords}}</label>
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
    import { event , eventBus } from '../../event-bus/event-bus';
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
                return {currentIndex: currentIndex, record: record}
            },
            emptyRecord: function () {
                return this.$store.state[this.axiosParams.module].recordList.length == 0 || this.$props.id == 0;
            },
            isCreatePermitted(){
                return this.$store.getters.isPermitted({resource:'Cemetery',action:'create'});
            },
            isReadPermitted(){
                return this.$store.getters.isPermitted({resource:'Cemetery',action:'read'});
            },
            isUpdatePermitted(){
                return this.$store.getters.isPermitted({resource:'Cemetery',action:'update'});
            },
            isDeletePermitted(){
                return this.$store.getters.isPermitted({resource:'Cemetery',action:'delete'});
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
              axiosParams: {module: 'cemetery'},
          }
        },
        methods: {
            save:function(){
                eventBus.$emit(event.SAVE_CEMETERY);
            },
            first: function(){
                eventBus.$emit(event.FIRST_CEMETERY_RECORD);
            },
            last: function(){
                eventBus.$emit(event.LAST_CEMETERY_RECORD);
            },
            next: function(id){
                eventBus.$emit(event.NEXT_CEMETERY_RECORD, id);
            },
            prev: function(id){
                eventBus.$emit(event.PREVIOUS_CEMETERY_RECORD, id);
            },
            getRecord: function (value) {
                this.$store.state[this.axiosParams.module].busy = true
                eventBus.$emit(event.GET_CEMETERY, value);
            },
            addRecord: function () {
                eventBus.$emit(event.ADD_CEMETERY);
            },
            deleteRecord: function (id) {
                eventBus.$emit(event.DELETE_CEMETERY, id);
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
