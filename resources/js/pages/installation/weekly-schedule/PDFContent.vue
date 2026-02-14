<template>

    <div>

        <form class="bg-white rounded mx-2 mb-2 p-3">
            <div class="d-flex justify-content-center">
                <h5>Week of: {{formFields.week_of}}</h5>
            </div>
            <div class="form-content">

                <div class="installation-row">
                    <div>
                        <b-table  bordered class="printable-truckload-table-border"
                                  :items="modifiedList"
                                  :fields="fields">

                            <template #head()="data">
                                <div class="my-n1 justify-content-center">
                                    <label class="header-label">{{ data.label }}</label>
                                </div>
                            </template>

                            <template #cell(day)="row">
                                <label v-if="row.item.day" class="bg-column px-1 w-100 m-auto">{{getDayOfWeek(row.item.day)}}, ({{getShortDate(row.item.day)}})</label>
                                <label v-if="row.item.person" class="">{{row.item.person}}</label>
                            </template>
                            <template #cell(person)="row">
                                <label class="text-center">{{row.item.person}}</label>
                            </template>
                            <template #cell(cemetery)="row">
                                <label class="text-center">{{row.item.cemetery}}</label>
                            </template>
                            <template #cell(monument_name)="row">
                                <label class="text-center">{{row.item.monument_name}}</label>
                            </template>
                            <template #cell(special_notes)="row">
                                <label class="text-center">{{row.item.special_notes}}</label>
                            </template>
                            <template #cell(approved)="row">
                                <!--<label>{{row.item.approved ? row.item.approved == 1 ? 'YES': 'NO' : ''}}</label>-->
                                <label v-if="row.item.approved && row.item.approved == 1">YES</label>
                                <label v-if="row.item.approved == 0">NO</label>
                            </template>
                            <template #cell(zone)="row">
                                <label>{{ row.item.zone ? row.item.zone : '' }}</label>
                            </template>

                        </b-table>
                    </div>
                </div>


            </div>

        </form>

    </div>

</template>

<script>
    export default {
        name: "Content",
        props: ['formFields', 'inPDF'],
        computed:{
            modifiedList(){

                let sorted_array = [], structure_array = [],modified_array = [];
                sorted_array= [... this.formFields.weekly_schedule_list]
                sorted_array = sorted_array.sort((a, b) => {
                    return new Date(a.day) - new Date(b.day)
                });
                //console.log(sorted_array,...this.formFields.weekly_schedule_list)
                for(let i=0; i < sorted_array.length; i++){
                    if(sorted_array[i].day != undefined)
                        structure_array[sorted_array[i].day]={};
                }
                for(let i=0; i < sorted_array.length; i++){
                    if(sorted_array[i].day != undefined && sorted_array[i].person != undefined)
                        structure_array[sorted_array[i].day][sorted_array[i].person]=[];
                }
                console.log(structure_array);
                for(let i=0; i < sorted_array.length; i++){
                    let row = sorted_array[i];
                    //console.log(row);
                    if(row.day != undefined && row.person != undefined)
                        structure_array[row.day][row.person].push(row);
                }

                for (let day in structure_array) {
                    modified_array.push({day:day})
                   // console.log(day,structure_array[day]);
                    for (let person in structure_array[day]) {
                        //console.log(person,structure_array[day][person]);
                        for (let row in structure_array[day][person]) {
                            let record = {...structure_array[day][person][row]};
                            if(row == 0){
                                delete record['day']
                            }
                            else{
                                delete record['day'];
                                delete record['person']
                            }
                            modified_array.push(record)
                            //console.log(row,structure_array[day][person][row]);
                        }
                    }
                }

                //console.log(structure_array,modified_array);
                return modified_array;
            },

        },
        data() {
            return {
                fields: [
                    {
                        key: 'day',
                        label: 'Day/Person',
                        /*tdClass: (value, key, item) => {

                            if(value != '')
                                return 'bg-warning'
                        }*/
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
        methods: {
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
            getDayOfWeek:function(date) {
                if(date != null){
                    const dayOfWeek = new Date(date).getDay();

                    return isNaN(dayOfWeek) ? null :
                        ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
                }
            }

        }
    }
</script>

<style scoped>
    .form-content {
        margin: 0 auto;
        width: 45rem;
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
        font-size: 12px;
    }

    .installation-row div input {
        border: 1px solid #c4c4c4;
        margin: auto;
        margin-right: 0;
        height: 1.5rem;
    }
    .installation-row div textarea {
        border: 1px solid #c4c4c4;
    }

    .bg-column{
        background-color:#FFF503 !important;
    }

    .custom-view-heading{
        font-size: 16px !important;
    }

    header {
        padding: 0 3rem;
    }

    .input-xl {
        width: 12rem;
    }

    .input-lg {
        width: 10rem;
    }

    .input-md {
        width: 8rem;
    }

    .input-sm {
        width: 6rem;
    }
    .input-xs {
        width: 3.9rem;
    }

    .input-select{
        font-size:12px !important;
        color:#6C757D;
        border: 1px solid #C4C4C4;
        box-sizing: border-box;
        border-radius: 3px;
        height: 1.5rem !important;
        padding: 3px;
        width: 11.8rem;
    }
    .custom-caret-agreement{
        background: #FFF url(http:/images/agreement-icon.png) right 0.75rem center no-repeat;
    }

    .border {
        border: 1px solid #c4c4c4 !important;
    }
    .border-right {
        border-right: 1px solid #000 !important;
    }
    .printing .border {
        border: 1px solid #000 !important;
    }
    @media print {
        body {
            -webkit-print-color-adjust: exact;
        }

    }


</style>
