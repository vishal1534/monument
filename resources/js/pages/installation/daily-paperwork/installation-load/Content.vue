<template>

    <div>

        <form class="div-shadow bg-white rounded mx-2 mb-2 p-3">

            <div class="form-content">

                <div class="custom-row border rounded">

                    <div class="d-block border-right px-1 m-0">
                        <label class="font-weight-bold">Date:</label>
                        <label class="d-block my-1">{{ changeDateFormat(formFields.date) }}</label>
                    </div>
                   <!-- <div class="d-block border-right px-1 m-0">
                        <label class="font-weight-bold">Day:</label>
                        <label class="d-block my-1">{{getDayOfWeek(formFields.date)}}</label>
                    </div>-->
                    <div class="d-block border-right px-1 m-0">
                        <label class="font-weight-bold">Name of Installer:</label>
                        <b-form-input type="text" class="my-1 mx-0" :disabled="hideInModal" size="sm"
                                      v-model="formFields.name_of_installer"></b-form-input>
                    </div>
                    <div class="d-block px-1 m-0">
                        <label class="font-weight-bold">Name of Checker:</label>
                        <b-form-input type="text" class="my-1 mx-0" :disabled="hideInModal" size="sm"
                                      v-model="formFields.name_of_checker"></b-form-input>
                    </div>
                </div>

                <div class="custom-row">
                    <div>
                        <b-table bordered class="memorial-table-border my-4"
                                 :items="inPDF ? dailyLoadList.slice(0,dailyLoadList.length - 1) : dailyLoadList"
                                 :fields="fields">

                            <template #head()="data">
                                <div class="my-n1 justify-content-center">
                                    <label class="header-label">{{ data.label }}</label>
                                </div>
                            </template>
                            <template #head(bags_of_concrete)="data">
                                <div class="my-n1 justify-content-center">
                                    <label class="header-label" style="line-height: inherit;">Bags of <br> Concrete</label>
                                </div>
                            </template>
                            <template #head(no_of_vases)="data">
                                <div class="my-n1 justify-content-center">
                                    <label class="header-label" style="line-height: inherit;"># of <br> Vases</label>
                                </div>
                            </template>
                            <template #head(last_name)="data">
                                <div class="my-n1 justify-content-center">
                                    <label class="header-label" style="line-height: inherit;">Customer <br> Name</label>
                                </div>
                            </template>
                            <template #head(monument_loaded)="data">
                                <div class="my-n1 justify-content-center">
                                    <label class="header-label" style="line-height: inherit;">Monument <br> Loaded</label>
                                </div>
                            </template>
                            <template #head(apron_cap)="data">
                                <div class="my-n1 justify-content-center">
                                    <label class="header-label" style="line-height: inherit;">Apron <br> / Cap</label>
                                </div>
                            </template>

                            <template #cell(invoice_no)="row">
                                <b-dropdown no-caret class="border rounded m-0 non-print-elm" size="sm" variant="none"
                                            :disabled="hideInModal">

                                    <template #button-content>
                                        <div class="d-flex m-0">
                                            <small>{{ row.item.order ? (row.item.order.invoice ?
                                                row.item.order.invoice.invoice_number : '') : 'Select' }}
                                            </small>
                                            <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                                        </div>
                                    </template>

                                    <b-dropdown-group class="overflow-auto scroll px-1">
                                        <template v-for="obj of orders">
                                            <b-dropdown-group @click="handleDropdownChange">
                                                <b-dropdown-item-button class="small"
                                                                        @click="row.item.order_id = obj.id, $set(row.item, 'order', obj)">
                                                    {{ obj.invoice.invoice_number }}
                                                </b-dropdown-item-button>
                                            </b-dropdown-group>
                                        </template>
                                    </b-dropdown-group>

                                </b-dropdown>
                                <label class="print-elm">{{ row.item.order ? (row.item.order.invoice ?
                                    row.item.order.invoice.invoice_number : '') : 'Select' }}</label>
                            </template>

                            <template #cell(last_name)="row">
                                <label>{{row.item.order ? (row.item.order.family ? row.item.order.family.name_on_stone :
                                    '') : ''}}</label>
                            </template>

                            <template #cell(monument_loaded)="row">
                                <b-form-group class="non-print-elm m-0 custom-radio-and-checkbox">
                                    <b-form-radio-group class="m-0"  :disabled="hideInModal" v-model="row.item.monument_loaded">
                                        <b-form-radio class="m-0"  value="1" size="sm" >Yes</b-form-radio>
                                        <b-form-radio class="m-0 ml-2" value="0" size="sm" >No</b-form-radio>
                                    </b-form-radio-group>
                                </b-form-group>
                                <label class="print-elm text-center" v-if="row.item.monument_loaded && row.item.monument_loaded == 1">Yes</label>
                                <label class="print-elm text-center" v-if="row.item.monument_loaded == 0">No</label>
                                <!--<label class="print-elm text-center">{{row.item.monument_loaded ? 'Yes' : 'No'}}</label>-->
                            </template>

                            <template #cell(no_of_vases)="row">
                                <b-form-input type="text" class="input-xs " :disabled="hideInModal" size="sm"
                                              v-model="row.item.no_of_vases"></b-form-input>
                            </template>

                            <template #cell(apron_cap)="row">
                                <b-form-group class="non-print-elm m-0 custom-radio-and-checkbox">
                                    <b-form-radio-group class="m-0" :disabled="hideInModal" v-model="row.item.apron_cap">
                                        <b-form-radio class="m-0 mr-2" value="1" size="sm" >Yes</b-form-radio>
                                        <b-form-radio class="m-0" value="0" size="sm" >No</b-form-radio>
                                    </b-form-radio-group>
                                </b-form-group>
                                <label class="print-elm text-center" v-if="row.item.apron_cap && row.item.apron_cap == 1">Yes</label>
                                <label class="print-elm text-center" v-if="row.item.apron_cap == 0">No</label>
<!--                                <label class="print-elm text-center">{{row.item.apron_cap ? 'Yes' : 'No'}}</label>-->
                            </template>

                            <template #cell(base_size)="row">
                                <b-dropdown no-caret class="border rounded m-0 non-print-elm" size="sm" variant="none"
                                            :disabled="hideInModal" style="width: 11rem;!important;">

                                    <template #button-content>
                                        <div class="d-flex m-0">
                                            <small>{{ row.item.base_size ?  baseOptions.filter(obj => obj.value == row.item.base_size)[0].text : 'Select' }}
                                            </small>
                                            <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                                        </div>
                                    </template>

                                    <b-dropdown-group class="overflow-auto scroll px-1">
                                        <template v-for="obj of baseOptionList">
                                            <b-dropdown-group @click="handleDropdownChange">
                                                <b-dropdown-item-button class="small" @click="row.item.base_size = obj.value">
                                                    {{ obj.text }}
                                                </b-dropdown-item-button>
                                            </b-dropdown-group>
                                        </template>
                                    </b-dropdown-group>

                                </b-dropdown>
                                <label class="print-elm text-center" style="word-break: break-all;">{{ findBaseOption(row.item.base_size) }}</label>
                            </template>

                            <template #cell(bags_of_concrete)="row">
                                <b-form-input type="text" class="input-xs non-print-elm" :disabled="hideInModal" size="sm"
                                              v-model="row.item.bags_of_concrete"></b-form-input>
                                <label class="print-elm text-center">{{ row.item.bags_of_concrete }}</label>
                            </template>

                            <template #cell(sign)="row">
                                <b-form-input type="text" class="input-xs non-print-elm" :disabled="hideInModal" size="sm"
                                              v-model="row.item.sign"></b-form-input>
                                <label class="print-elm text-center">{{ row.item.sign }}</label>
                            </template>

                        </b-table>
                    </div>
                </div>
                <div class="d-block text-center" style="font-family: Roboto;">
                    <label class="d-block m-0">To Convert Sq. Inches to Sq.Ft.</label>
                    <label class="d-block m-0">Length (x) Width, Divided by 144 (24x12 = 288/144 = 2)</label>

                </div>

                <div class="custom-row">
                    <div class="col-5 p-0 flex-column">
                        <h6 class="font-weight-bold">GRASSER</h6>
                        <label class="ml-0">16x8 = 0.88 sq.ft.</label>
                        <label class="ml-0">20x10 = 1.4</label>
                        <label class="ml-0">24x12 = 2</label>
                        <label class="ml-0">36x12 = 3</label>
                        <label class="ml-0">36x14 = 3.5</label>
                    </div>
                    <div class="col-5 p-0 flex-column mx-4">
                        <h6 class="font-weight-bold">SLANTS</h6>
                        <label class="ml-0">16x12 = 1.33 sq.ft.</label>
                        <label class="ml-0">20x16 = 2.2</label>
                        <label class="ml-0">24x16 = 2.6</label>
                        <label class="ml-0">36x16 = 4</label>
                        <label class="ml-0">42x16 = 4.7</label>
                    </div>
                    <div class="col-2 p-0 flex-column">
                        <h6 class="font-weight-bold">DIES</h6>
                        <label class="ml-0">14x18 = 1.75 sq.ft.</label>
                        <label class="ml-0">24x18 = 3</label>
                        <label class="ml-0">36x20 = 5</label>
                        <label class="ml-0">42x22 = 6.41</label>
                        <label class="ml-0">48x24 = 8</label>
                    </div>
                </div>


                <div v-if="!hideInModal" class="custom-row non-print-elm">
                    <div>
                        <button type="button" class="btn-info px-2 w-auto custom-infobtn-toolbar custom-infobtn-text"
                                @click="printPDF">Print Preview
                        </button>
                        <router-link
                                class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text"
                                to="/installation-load-list">Back to List
                        </router-link>


                            <button type="button" v-if="formFields.id ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="saveData" :disabled="saveDisabled">
                                {{ formFields.id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                            </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

</template>

<script>
    import {fetchRecord} from "../../../../helpers/axios";
    import {event, eventBus} from "../../../../event-bus/event-bus";

    export default {
        name: "Content",
        props: ['formFields', 'inPDF', 'hideInModal', 'saveDisabled'],
        computed: {
            dailyLoadList() {
                if (this.formFields.daily_load_list.length == 0 || !this.hasNewRow)
                    this.addRow()

                return this.formFields.daily_load_list;
            },
            isUpdatePermitted(){
                return this.$store.getters.isPermitted({resource:'Installation',action:'update'});
            },
            isCreatePermitted(){
                return this.$store.getters.isPermitted({resource:'Installation',action:'create'});
            },
            orders() {
                return this.$store.state.order.recordList;
            },
            hasNewRow() {
                for (let item of this.formFields.daily_load_list) {
                    if (item.id == 0)
                        return true
                }
                return false;
            },
            baseOptionList(){
                this.baseOptions = this.$store.getters.sortByAlphaNumeric({'fieldName': 'text', 'recordList': this.baseOptions});
                return this.baseOptions;
            },
        },
        data() {
            return {
                axiosParams: {module: 'installer'},
                fields: [
                    {
                        key: 'invoice_no',
                        label: 'Inv #',
                    },
                    {
                        key: 'last_name',
                        label: 'Customer Name',
                    },
                    {
                        key: 'monument_loaded',
                        label: 'Monument Loaded'
                    },
                    {
                        key: 'no_of_vases',
                        label: '# of Vases',
                    },
                    {
                        key: 'apron_cap',
                        label: 'Apron / Cap'
                    },
                    {
                        key: 'base_size',
                        label: 'Base Size',
                    },
                    {
                        key: 'bags_of_concrete',
                        label: 'Bags of Concrete',
                    },
                    {
                        key: 'sign',
                        label: 'Sign',
                    },
                ],
                baseOptions:[
                    {value:'1-4x0-8x0-4-grasser-2-bags', text:'1-4x0-8x0-4 grasser = 2 bags'},
                    {value:'1-8x0-10x0-4-grasser-3-bags', text:'1-8x0-10x0-4 grasser = 3 bags'},
                    {value:'2-0x1-0x0-4-grasser-4-bags', text:'2-0x1-0x0-4 grasser = 4 bags'},
                    {value:'1-8x0-8x0-6-base-3-bags', text:'1-8x0-8x0-6 base = 3 bags'},
                    {value:'2-10x0-10x0-6-base-6-bags', text:'2-10x0-10x0-6 base = 6 bags'},
                    {value:'3-0x1-0x0-6-base-8-bags', text:'3-0x1-0x0-6 base = 8 bags'},
                    {value:'3-6x1-0x0-6-base-9-bags', text:'3-6x1-0x0-6 base = 9 bags'},
                    {value:'4-0x1-0x0-6-base-10-bags', text:'4-0x1-0x0-6 base = 10 bags'},
                    {value:'4-6x1-0x0-6-base-11-bags', text:'4-6x1-0x0-6 base = 11 bags'},
                    {value:'5-0x1-2x0-8-base-15-bags', text:'5-0x1-2x0-8 base = 15 bags'},
                ],
            }
        },
        mounted() {
            this.$store.getters.detectFormChanges();
        },
        methods: {
            getRecord: function (id) {

                if (id) {
                    let record = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == id);
                    if (record != undefined) {
                        this.formFields = {...record};
                    } else {
                        this.axiosParams.id = id;
                        fetchRecord(this.axiosParams, (response) => {
                            this.formFields = response.data;
                        })
                    }
                }
            },
            changeDateFormat: function(value){
                return this.$store.getters.changeDateFormat(value);
            },
            saveData:function(){
                eventBus.$emit(event.SAVE_INSTALLER);
            },
            addRow() {
                if (!this.inPDF)
                    this.formFields.daily_load_list.push({id: 0})
            },
            handleDropdownChange: function(value){
                window.detectChanges = true;
            },

            /** Generic*/
            printPDF() {
                eventBus.$emit(event.PRINT_PDF)
            },
            getDayOfWeek:function(date) {
                if(date != null){
                    const dayOfWeek = new Date(date).getDay();

                    return isNaN(dayOfWeek) ? null :
                        ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
                }
            },
            findBaseOption(val){
                let option = []
                option =  this.baseOptions.filter(obj => obj.value == val);
                return option.length > 0 ? option[0].text : ' ';
            }
        }
    }
</script>

<style scoped>
    .form-content {
        margin: 0 auto;
        width: 59rem;
    }

    .header-label {
        font-family: Roboto;
        font-style: normal;
        font-weight: normal;
        font-size: 12px;
        line-height: 14px;
        text-align: center;
        letter-spacing: 0.02em;
        color: #000;
    }

    .custom-row {
        display: flex;
        padding: 0;
    }

    .custom-row div {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }

    .custom-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
        color: #000 !important;
    }

    .custom-row div input {
        border: 1px solid #c4c4c4;
        margin: auto;
        margin-right: 0;
        height: 1.5rem;
        font-size: 12px;
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
        width: 4rem;
    }

    .input-date {
        font-size: .6rem;
    }

    .border {
        border: 1px solid #c4c4c4 !important;
    }
    .printing .border {
        border: 1px solid #000 !important;
    }

</style>
