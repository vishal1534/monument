<template>

    <div>
        <div class="row">
            <div class="col-md-12">

                <form class=" bg-white rounded mx-2 mb-2 p-3">

                    <div class="form-content">

                        <div class="installation-row my-2">
                            <div class="col-2 d-block border pb-4">
                                <h5 class="my-auto p-0 week-label py-2">Week of:</h5>
                                <label class="print-elm text-center">{{formFields.week_of}}</label>
                                <b-form-input type="text" class="non-print-elm" size="sm" :disabled="hideInModal" v-model="formFields.week_of"></b-form-input>
                            </div>
                        </div>

                        <div class="installation-row">
                            <div>
                                <b-table  bordered class="memorial-table-border"
                                          :items="inPDF ? weeklyScheduleList.slice(0, weeklyScheduleList.length -1) : weeklyScheduleList"
                                          :fields="fields">


                                    <template #head()="data">
                                        <div class="my-n1 justify-content-center">
                                            <label class="header-label">{{ data.label }}</label>
                                        </div>
                                    </template>
                                    <!--<template #cell(day)="data">
                                        <b-form-input v-if="data.index < 7" type="text"  class="my-n1" style="width:5rem" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(person)="data">
                                        <b-form-input v-if="data.index < 7" type="text"  class="input-md my-n1" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(cemetery)="data">
                                        <b-form-input v-if="data.index < 7" type="text"  class="input-md my-n1" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(monument_name)="data">
                                        <b-form-input v-if="data.index < 7" type="text"  class="input-lg  my-n1" size="sm" ></b-form-input>
                                    </template>
                                    <template #cell(special_notes)="data">
                                        <b-form-input v-if="data.index < 7" type="text"  class="input-lg  my-n1" size="sm" ></b-form-input>
                                    </template>
                                    <template #cell(approved)="data">
                                        <div v-if="data.index < 7" class="input-sm my-n3">
                                            <b-form-group class="m-0 my-auto custom-radio-and-checkbox">
                                                <b-form-radio-group name="monument-loaded">
                                                    <b-form-radio name="monument-loaded-radio"  class="pr-3"  value="1">Yes</b-form-radio>
                                                    <b-form-radio name="monument-loaded-radio"  value="0">No</b-form-radio>
                                                </b-form-radio-group>
                                            </b-form-group>
                                        </div>
                                    </template>-->
                                    <template v-slot:cell(day)="row">
                                        <b-form-datepicker :disabled="hideInModal"
                                                           :date-format-options="{ year: '2-digit', month: 'numeric', day: 'numeric' }"
                                                           class="mt-0 border input-date non-print-elm"
                                                           size="sm" name="date" placeholder=""
                                                           v-model="row.item.day"
                                                           today-button
                                                           reset-button
                                                           close-button
                                                           @input="checkDate(row)"
                                                           locale="en">
                                        </b-form-datepicker>
                                        <label class="print-elm bg-column pl-2">{{getDayOfWeek(row.item.day)}}, ({{getShortDate(row.item.day)}})</label>
                                        <label class="print-elm pl-2">{{row.item.person}}</label>
                                    </template>
                                    <template #cell(person)="row">
                                        <b-form-input type="text" class="non-print-elm" :disabled="hideInModal" size="sm"
                                                      v-model="row.item.person"></b-form-input>
                                        <label class="print-elm text-center">{{row.item.person}}</label>
                                    </template>
                                    <template #cell(cemetery)="row">
                                        <b-form-input type="text" class="non-print-elm" :disabled="hideInModal" size="sm"
                                                      v-model="row.item.cemetery"></b-form-input>
                                        <label class="print-elm text-center">{{row.item.cemetery}}</label>
                                    </template>
                                    <template #cell(monument_name)="row">
                                        <b-form-input type="text" class="non-print-elm" :disabled="hideInModal" size="sm"
                                                      v-model="row.item.monument_name"></b-form-input>
                                        <label class="print-elm text-center">{{row.item.monument_name}}</label>
                                    </template>
                                    <template #cell(special_notes)="row">
                                        <b-form-input type="text" class="non-print-elm" :disabled="hideInModal" size="sm"
                                                      v-model="row.item.special_notes"></b-form-input>
                                        <label class="print-elm text-center">{{row.item.special_notes}}</label>
                                    </template>
                                    <template #cell(approved)="row">
                                        <b-form-group class="non-print-elm m-0 custom-radio-and-checkbox">
                                            <b-form-radio-group class="m-0"  :disabled="hideInModal" v-model="row.item.approved">
                                                <b-form-radio class="m-0 mr-2" :value=1 size="sm" >Yes</b-form-radio>
                                                <b-form-radio class="m-0" :value="0" size="sm" >No</b-form-radio>
                                            </b-form-radio-group>
                                        </b-form-group>
                                        <label class="print-elm text-center">{{row.item.approved ? 'Yes' : 'No'}}</label>
                                    </template>
                                    <template #cell(zone)="row">
                                        <b-dropdown no-caret class="border rounded m-0 non-print-elm" size="sm" variant="none"
                                                    :disabled="hideInModal">

                                            <template #button-content>
                                                <div class="d-flex m-0 input-xs">
                                                    <small>{{ row.item.zone ? zoneOptions.filter(obj => obj.value == row.item.zone)[0].text : 'Select' }}
                                                    </small>
                                                    <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                                                </div>
                                            </template>

                                            <b-dropdown-group class="overflow-auto scroll px-1" style="height:18vh !important;">
                                                <template v-for="obj of zoneOptions">
                                                    <b-dropdown-group @click="handleDropdownChange">
                                                        <b-dropdown-item-button class="small" @click="row.item.zone = obj.value">
                                                            {{ obj.text }}
                                                        </b-dropdown-item-button>
                                                    </b-dropdown-group>
                                                </template>
                                            </b-dropdown-group>

                                        </b-dropdown>
                                        <label class="print-elm text-center">{{ row.item.zone ? row.item.zone : 'Select' }}</label>
                                    </template>

                                </b-table>
                            </div>
                        </div>

                        <div class="installation-row non-print-elm">
                            <div>
                                <button type="button" :disabled="hideInModal" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="printPDF">
                                    Print Form<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                                </button>
                               <!-- <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" to="/installation-production-list">Back To List</router-link>
                            --></div>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

</template>

<script>

    import {fetchRecord} from "../../../helpers/axios";
    import {event, eventBus} from "../../../event-bus/event-bus";

    export default {
        name: "Content",
        props: ['formFields', 'inPDF', 'hideInModal','saveDisabled'],
        data() {
            return {
                axiosParams: {module: 'weeklySchedule'},
                zoneOptions:[
                    {value:'East', text:'East'},
                    {value:'North', text:'North'},
                    {value:'South', text:'South'},
                    {value:'West', text:'West'}
                ],
                fields: [
                    {
                        key: 'day',
                        label: this.$props.inPDF ? 'Day/Person' : 'Day',
                    },
                    {
                        key: 'person',
                        label: 'Person',
                        thClass: this.$props.inPDF ? 'd-none' : '', tdClass: this.$props.inPDF ? 'd-none' : ''
                    },
                    {
                        key: 'cemetery',
                        label: 'Cemetery',
                    },
                    {
                        key: 'monument_name',
                        label: 'Monument Name',
                    },
                    {
                        key: 'special_notes',
                        label: 'Special Notes',
                    },
                    {
                        key: 'approved',
                        label: 'Approved',
                    },
                    {
                        key: 'zone',
                        label: 'Zone',
                    }
                ],
            }
        },
        computed:{
            weeklyScheduleList(){
                if(this.formFields.weekly_schedule_list.length == 0 || !this.hasNewRow)
                    this.addRow()
                return [...this.formFields.weekly_schedule_list];
            },
            orders(){
                return this.$store.state.order.recordList;
            },
            hasNewRow(){
                for (let item of [...this.formFields.weekly_schedule_list]){
                    if (item.id == 0)
                        return true
                }
                return false;
            },
        },
        mounted() {
            this.$store.getters.detectFormChanges();
        },
        methods: {
            getRecord: function(id){

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
            addRow(){
                if (!this.inPDF)
                    this.formFields.weekly_schedule_list.push({id:0})
            },
            save:function(){
                eventBus.$emit(event.SAVE_WEEKLY_SCHEDULE);
            },
            handleDropdownChange: function(value){
                window.detectChanges = true;
            },
            getDayOfWeek:function(date) {
                if(date != null){
                    const dayOfWeek = new Date(date).getDay();

                    return isNaN(dayOfWeek) ? null :
                        ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
                }
            },

            getShortDate:function(date) {

                if(date != null) {
                    let dd = String(new Date(date).getDate())//.padStart(2, '0');
                    let mm = String(new Date(date).getMonth() + 1)//.padStart(2, '0'); //January is 0!

                    return mm + '/' + dd ;
                }
            },

            checkDate:function(row) {
                if(this.formFields.weekly_schedule_list[row.index].day == "") {
                    this.formFields.weekly_schedule_list[row.index].day = null;
                    console.log(this.formFields.weekly_schedule_list[row.index].day);
                }
            },

            /** Generic*/
            printPDF() {
                eventBus.$emit(event.PRINT_PDF)
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

    .installation-row div input {
        border: 1px solid #c4c4c4;
        margin: auto;
        margin-right: 0;
        height: 1.5rem;
        font-size: 12px !important;
    }

    header {
        padding: 0 3rem;
    }

    .input-xl {
        width: 12rem;
    }

    .input-lg {
        width: 10rem !important;
    }

    .input-md {
        width: 8rem !important;
    }

    .input-sm {
        width: 6rem;
    }
    .input-xs {
        width: 3rem !important;
    }


    .input-date {
        font-size: .6rem;
        width: 6rem !important;
    }

    .bg-column{
        background-color:#FFF503 !important;
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

    .custom-caret-agreement{
        background: #FFF url(http:/images/agreement-icon.png) right 0.75rem center no-repeat;
    }

    /*.printing .form-content{
        width: 100%;
    }
    .printing label, .printing input, .printing textarea{
        font-size: 1.2rem;
    }
    .printing h5, .printing h3{
        font-size: 2rem;
    }
    .printing input, .printing textarea{
        border-color: transparent !important;
        background: transparent !important;
        pointer-events: none;
        height: auto;
    }
    .printing .non-print-elm{
        display: none !important;
    }
    .printing .print-elm{
        display: block !important;
    }*/
</style>
