<template>

    <div>
        <div class="row">
            <div class="col-md-12">

                <form class=" bg-white rounded mx-2 mb-2 p-3">

                    <div class="form-content">

                        <div class="installation-row my-2">
                            <div class="col-2 d-block border pb-4">
                                <h5 class="my-auto p-0 week-label py-2">Role:</h5>
                                <b-form-input type="text" class="non-print-elm" size="sm" :disabled="hideInModal ? hideInModal : false" v-model="formFields.title"></b-form-input>
                            </div>
                        </div>

                        <div class="installation-row">
                            <div>
                                <b-table  bordered class="memorial-table-border"
                                          :items="formFields.permissions"
                                          :fields="fields">


                                    <template #head()="data">
                                        <div class="my-n1 justify-content-center">
                                            <label class="header-label">{{ data.label }}</label>
                                        </div>
                                    </template>
                                    <template #cell(resource)="row">
                                        <b-form-select
                                                :options="userRoleRecordList"
                                                :disabled="hideInModal"
                                                v-model="row.item.resource"
                                                class="custom-caret-agreement"
                                                size="sm">
                                            <template #first>
                                                <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                                            </template>

                                        </b-form-select>
                                       <!-- <template v-for="obj of userRoleRecordList">
                                            <b-dropdown-group class="mx-2">
                                                <b-dropdown-item-button @click="getRecord(obj.value)">
                                                    <label>{{obj.text}}</label>
                                                </b-dropdown-item-button>
                                            </b-dropdown-group>
                                        </template>-->
                                       <!-- <b-dropdown no-caret class="border rounded m-0 non-print-elm" size="sm" variant="none"
                                                    :disabled="hideInModal">

                                            <template #button-content>
                                                <div class="d-flex m-0 input-xs">
                                                    <small>{{ row.item.resource ? resourceOptions.filter(obj => obj.value == row.item.resource)[0].text : 'Select' }}
                                                    </small>
                                                    <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                                                </div>
                                            </template>

                                            <b-dropdown-group class="overflow-auto scroll px-1" style="height:18vh !important;">
                                                <template v-for="obj of resourceOptions">
                                                    <b-dropdown-group>
                                                        <b-dropdown-item-button class="small" @click="row.item.resource = obj.value">
                                                            {{ obj.text }}
                                                        </b-dropdown-item-button>
                                                    </b-dropdown-group>
                                                </template>
                                            </b-dropdown-group>

                                        </b-dropdown>
                                        <label class="print-elm text-center">{{ row.item.resource ? row.item.resource : 'Select' }}</label>
-->
                                    </template>
                                    <template #cell(mine)="row">
                                        <b-form-checkbox
                                                v-model="row.item.mine"
                                                class="justify-content-center"
                                                :value=true
                                                :disabled="hideInModal"
                                                :unchecked-value=false
                                        >
                                        </b-form-checkbox>
                                    </template>

                                    <template #cell(read)="row">
                                        <b-form-checkbox
                                                v-model="row.item.read"
                                                class="justify-content-center"
                                                :value=true
                                                :disabled="hideInModal"
                                                :unchecked-value=false
                                        >
                                        </b-form-checkbox>
                                    </template>
                                    <template #cell(create)="row">
                                        <b-form-checkbox
                                                v-model="row.item.create"
                                                class="justify-content-center"
                                                :value=true
                                                :disabled="hideInModal"
                                                :unchecked-value=false
                                        >
                                        </b-form-checkbox>
                                    </template>
                                    <template #cell(update)="row">
                                        <b-form-checkbox
                                                v-model="row.item.update"
                                                class="justify-content-center"
                                                :value=true
                                                :disabled="hideInModal"
                                                :unchecked-value=false
                                        >
                                        </b-form-checkbox>
                                    </template>
                                    <template #cell(delete)="row">
                                        <b-form-checkbox
                                                v-model="row.item.delete"
                                                class="justify-content-center"
                                                :value=true
                                                :disabled="hideInModal"
                                                :unchecked-value=false
                                        >
                                        </b-form-checkbox>
                                    </template>

                                </b-table>
                            </div>
                        </div>

                        <div class="installation-row" v-if="!hideInModal">
                            <div>
                                <button type="button" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" :disabled="hideInModal" @click="addRow">
                                    Add Row
                                </button>
                                <button type="button" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" :disabled="hideInModal" @click="formFields.permissions.pop()">
                                    Delete Row
                                </button>
                            </div>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

</template>

<script>

    import {fetchRecord} from "../../helpers/axios";

    export default {
        name: "Content",
        props: ['formFields', 'hideInModal','saveDisabled'],
        data() {
            return {
                axiosParams: {module: 'userRole'},
                axiosUserParams: {module: 'userResources'},
                /*resourceOptions:[
                    {value:'Quotes', text:'Quotes'},
                    {value:'Orders', text:'Orders'},
                    {value:'Cemetery', text:'Cemetery'},
                    {value:'Products', text:'Products'},
                    {value:'Collaboration', text:'Collaboration'},
                    {value:'Production', text:'Production'},
                    {value:'Installation', text:'Installation'},
                    {value:'Accounting', text:'Accounting'},
                    {value:'Maintenance', text:'Maintenance'},
                    {value:'Department', text:'Department'},
                    {value:'Setting', text:'Setting'},
                    {value:'User', text:'User'}
                ],*/
                resourceOptions: null,
                fields: [
                    {
                        key: 'resource',
                        label: 'Resource',
                    },
                    {
                        key: 'mine',
                        label: 'Is Mine',
                    },
                    {
                        key: 'read',
                        label: 'Read',
                    },
                    {
                        key: 'create',
                        label: 'Create',
                    },
                    {
                        key: 'update',
                        label: 'Update',
                    },
                    {
                        key: 'delete',
                        label: 'Delete',
                    },
                ],
            }
        },
        computed:{
            resourceList(){

                /*if(this.formFields.permissions && this.formFields.permissions[this.formFields.permissions.length-1] != {}) {
                    this.addRow();
                }*/
                return this.formFields.permissions;
            },
            userRoleRecordList(){
                this.$store.getters.sortByAlphaNumeric({'module': 'userResources', 'fieldName': 'title'});
                let options = [];
                for (let opt of this.$store.state[this.axiosUserParams.module].recordList){
                    let obj = null;
                    if ( (this.hideInModal) && (this.formFields.title == 'Customer') ){
                        obj = {value: 'Customer Portal', text: 'Customer Portal', disabled: true};
                    }else{
                        obj = {value: opt.title, text: opt.title};
                    }
                        options.push(obj);
                }
                return options;
            },
        },
        mounted() {
            this.userRoleList();
        },
        methods: {
            getRecord: function(id){
                console.log("here comes ",id)
                if (id){
                    let record = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == id);
                    if (record != undefined){
                        this.formFields = {...record};
                    }
                    else{
                        this.axiosParams.id = id;
                        fetchRecord(this.axiosParams, (response) => {
                            this.formFields = response.data;
                        })
                    }
                }
            },
            userRoleList: function (){
                if (this.$store.state[this.axiosUserParams.module].recordList.length == 0 ){
                    this.$store.dispatch('getModuleInfo', this.axiosUserParams);
                }

            },
            addRow(){
                    this.formFields.permissions.push({})
            },
        }
    }
</script>

<style scoped>
    .form-content {
        margin: 0 auto;
        width: 58rem;
    }
    .header-label{
        font-family: Roboto;
        font-style: normal;
        font-weight: normal;
        font-size: 12px;
        line-height: 14px;
        text-align: center;
        letter-spacing: 0.02em;
        color:#000;
        font-weight: bold;
    }
    .installation-row {
        display: flex;
        padding: 0;
    }

    .installation-row div {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }

    .installation-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
        color:#000 !important;
    }

    .installation-row div input,select {
        border: 1px solid #c4c4c4;
        margin: auto;
        margin-right: 0;
        font-size: 12px !important;
    }

    header {
        padding: 0 3rem;
    }

    .border {
        border: 1px solid #c4c4c4 !important;
    }
    .printing .border {
        border: 1px solid #000 !important;
    }
    .week-label{
        font-family: Roboto;
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 16px;
        text-align: center;
        letter-spacing: 0.02em;
        color:#000;
    }
</style>
