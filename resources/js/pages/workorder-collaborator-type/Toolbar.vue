<template>
    <div class="d-flex align-items-center w-100">

        <div v-if="isCreatePermitted || isUpdatePermitted"  class="toolbar">

            <div class="m-0">
                <b-dropdown no-caret menu-class="p-0 m-0 custom-dropdown-ul" size="sm" variant="none">

                    <template #button-content>
                        <div class="d-flex input-md form-control-sm rounded-0 custom-caret-toolbar my-1 ml-n2">
                            <label>{{getSelected[0] ? getSelected[0].text : 'Go To' }}</label>
                        </div>
                    </template>

                    <b-dropdown-group class="overflow-auto scroll input-md">
                        <div>
                            <div class="bg-toolbar text-center">
                                <label class="m-0">Type</label>
                            </div>
                            <div class="mt-2 mx-2 d-flex flex-column">
                                <b-form-input
                                    size="sm"
                                    class="input-search h-100 py-1"
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
            <button type="button" class="btn btn-sm custom-label-toolbar" @click="addRecord">New Record</button>
            <button type="button" :disabled="emptyRecord" class="btn btn-sm custom-label-toolbar" @click="deleteRecord(id)">Delete Record</button>
        </div>

        <div class="toolbar ml-auto">
            <button type="button" class="btn-info mx-1 custom-infobtn-toolbar custom-infobtn-text" v-if="isUpdatePermitted"  @click="save" :disabled="saveDisabled">
                {{ id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
            </button>
            <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" to="/work-order-collaboratorType-list">Back To List</router-link>
        </div>

        <div class="toolbar ml-auto">

            <div v-if="isReadPermitted"  class="d-flex">
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
            recordList: function () {
                this.$store.getters.sortByAlphaNumeric({'module' : 'collaboratorType', 'fieldName': 'title'});
                let options = [];
                for (let opt of this.$store.state[this.axiosParams.module].recordList){
                    let obj = {value: opt.id, text: opt.title};
                    options.push(obj);
                }
                if (this.searchTerm != ''){
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
            isCreatePermitted(){
                return this.$store.getters.isPermitted({resource:'Collaboration',action:'create'});
            },
            isReadPermitted(){
                return this.$store.getters.isPermitted({resource:'Collaboration',action:'read'});
            },
            isUpdatePermitted(){
                return this.$store.getters.isPermitted({resource:'Collaboration',action:'update'});
            },
            isDeletePermitted(){
                return this.$store.getters.isPermitted({resource:'Collaboration',action:'delete'});
            },
            emptyRecord: function () {
                return this.$store.state[this.axiosParams.module].recordList.length == 0 || this.$props.id == 0;
            },
            getSelected(){
                return this.recordList.filter(obj => obj.value == this.id);
            },
        },
        data(){
            return {
                axiosParams: {module: 'collaboratorType'},
                searchTerm: "",
            }
        },
        methods: {
            save:function(){
                eventBus.$emit(event.SAVE_COLLABORATORTYPE);
            },
            first: function(){
                eventBus.$emit(event.FIRST_COLLABORATORTYPE_RECORD);
            },
            last: function(){
                eventBus.$emit(event.LAST_COLLABORATORTYPE_RECORD);
            },
            next: function(id){
                eventBus.$emit(event.NEXT_COLLABORATORTYPE_RECORD, id);
            },
            prev: function(id){
                eventBus.$emit(event.PREVIOUS_COLLABORATORTYPE_RECORD, id);
            },
            getRecord: function (value) {
                eventBus.$emit(event.GET_COLLABORATORTYPE, value);
            },
            addRecord: function () {
                eventBus.$emit(event.ADD_COLLABORATORTYPE);
            },
            deleteRecord: function (id) {
                eventBus.$emit(event.DELETE_COLLABORATORTYPE, id);
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
        width: 15rem;
        font-size: 0.75rem;
    }
    .input-search{
        font-size: 0.75rem;
    }
</style>
