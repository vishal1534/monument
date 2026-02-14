<template>
    <div>
        <h5 class="mx-2 my-1 custom-view-heading">Cost of Display Inventory</h5>
        <div class="bg-toolbar my-2 p-1">
            <div class="d-flex justify-content-end align-items-center">
                <div class="d-flex m-auto">
                    <button @click="printPDF" class="btn-info mx-1 custom-infobtn-toolbar custom-infobtn-text" type="button">Print</button>
                </div>
                <div class="mx-2 d-flex">
                    <img class="mx-1 my-auto" height="26" src="/images/video-chat.png" width="26"/>
                    <img class="mx-1" height="30" src="/images/help-icon.png" width="30"/>
                </div>
            </div>
        </div>
        <div id="quote">
            <div class="row m-0">
                <div class="col-md-12">
                    <div class="quote-body p-3">
                        <div class="d-flex">
                            <b-dropdown
                                class="m-2 custom-choose-btn d-none "
                                id="dropdown-form"
                                ref="dropdown"
                                size="sm"
                                text="Choose Columns"
                                variant="info custom-choose-text">
                                <b-dropdown-form class="overflow-auto scroll" style="height: 50vh;">
                                    <template v-for="(objects, key) of filterFields">
                                        <h6>{{key}}</h6>
                                        <b-form-group :key="key + index" class="form-inline" v-for="(item, index) of objects">
                                            <b-form-checkbox :checked="!item.thClass.includes('d-none')" v-if="item.key != 'action'" v-on:change="toggleColumn(item)"><span class="custom-checkbox-margin">{{item.label}}</span></b-form-checkbox>
                                        </b-form-group>
                                    </template>
                                </b-dropdown-form>
                            </b-dropdown>
                            <div class="d-flex ml-auto">
                                <button @click="filterRecords" class="btn btn-sm btn-info my-auto px-3 custom-search-btn custom-search-text" data-placement="bottom" data-toggle="tooltip" title="Apply filters">Search</button>
                                <button :class="['btn btn-sm custom-clear-btn custom-clear-text my-auto px-3 mx-3', {'btn-danger': this.$store.state[this.axiosParamsReport.module].isFiltered}]" :disabled="!this.$store.state[this.axiosParamsReport.module].isFiltered" @click="clearFilter">Clear Filter</button>
                                <b-pagination
                                    :per-page="pagePerPage" :total-rows="rows"
                                    align="right" aria-controls="data-table" class="my-auto ml-2" size="sm" v-model="currentPage"
                                ></b-pagination>
                                <b-form-select :options="perPageRecordList"
                                               @change="getRecord"
                                               class="input-list-md form-control-sm rounded-0 my-1 mx-3" size="sm" v-model="getSelected">
                                    <template #first>
                                        <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                                    </template>
                                </b-form-select>
                            </div>
                        </div>
                        <div class="d-flex">
                            <label class="ml-auto custom-record-showing">Showing {{(currentPage*pagePerPage) - (pagePerPage-1)}} to {{rows < 10 || currentPage*pagePerPage > rows ? rows : currentPage*pagePerPage}} of {{rows}} records</label>
                        </div>
                        <!--                        foot-clone-->
                        <b-table :busy="isBusy" :current-page="currentPage" :fields="tableFields" :items="tableData" :per-page="pagePerPage"
                                 bordered class="my-table bootstrap-vue-table a"
                                 hover id="data-table" no-footer-sorting responsive small striped>
                            <template #table-busy>
                                <div class="text-center text-info my-2">
                                    <b-spinner class="align-middle"></b-spinner>
                                    <strong>Loading...</strong>
                                </div>
                            </template>
                            <template #head(action)="data">
                                <hr class="border">
                                <span class="ml-3 mr-1 custom-table-heading">{{data.label}}</span>
                            </template>
                            <template #head(index)="data">
                                <hr class="border">
                                <span class="ml-2 mr-1 custom-table-heading">{{data.label}}</span>
                            </template>
                            <template #head()="data">
                                <div class="d-flex mx-1 custom-input-header">
                                    <div class="mx-1 btn-group">
                                        <select @change="filterRecords" class="form-control-sm rounded-0 border bg-light" v-model="queryFields[data.field.parent].find(item => item.column == data.column).operator">
                                            <option selected title="Equals To" v-b-tooltip.hover value="like">=</option>
                                            <option title="Empty" v-b-tooltip.hover value="IS">=''</option>
                                            <option title="Not Equals to" v-b-tooltip.hover value="not like"><></option>
                                            <option title="Greater Than" v-b-tooltip.hover value=">">></option>
                                            <option title="Less Than" v-b-tooltip.hover value="<"><</option>
                                            <option title="Greater & Equals to" v-b-tooltip.hover value=">=">>=</option>
                                            <option title="Less & Equals to" v-b-tooltip.hover value="<="><=</option>
                                            <option title="Range" v-b-tooltip.hover value="...">...</option>
                                        </select>
                                        <input :disabled="queryFields[data.field.parent].find(item => item.column == data.column).operator == 'IS' ? true : false " @input="debounce" @keyup.enter="filterRecords" class="form-control-sm border rounded-0 custom-input-width"
                                               placeholder="Search here..."
                                               type="text" v-model="queryFields[data.field.parent].find(item => item.column == data.column).value"/>
                                    </div>
                                </div>
                                <hr class="border">
                                <span class="ml-2 mr-1 custom-table-heading">{{ data.label }}</span>
                            </template>
                            <template #cell()="data">
                                <span class="custom-table-body ml-1"> {{ data.value }}</span>
                            </template>
                            <template #cell(index)="data">
                                <span class="custom-table-body ml-1"> {{ (data.index + 1) + ((currentPage-1) * pagePerPage)}}</span>
                            </template>
                            <!--search filter will not work with this column total_on_hand (Total QTY) -->
                            <template #cell(total_on_hand)="data">
                                <span class="custom-table-body ml-1"> {{ Number(data.item.indep) + Number(data.item.clinton) + Number(data.item.ex_spring) + Number(data.item.ph) + Number(data.item.bs)  }}</span>
                            </template>
                            <template #cell(product_cost)="data">
                                <span class="custom-table-body ml-1"> $ {{ convertDecimal(data.item.product_cost) ? convertDecimal(data.item.product_cost) : '0.00' }}</span>
                            </template>
                            <!--search filter will not work with this column total_added (Total) -->
                            <template #cell(total_added)="data">
                                <span class="custom-table-body ml-1">$ {{  convertDecimal( (Number(data.item.indep) + Number(data.item.clinton) + Number(data.item.ex_spring) + Number(data.item.ph) + Number(data.item.bs)) * data.item.product_cost ) }}</span>
                            </template>
                            <!--<template #foot()="data">
                                <span class="custom-table-heading"></span>
                            </template>
                            <template #foot(clinton)="data">
                                <label>Total : {{ convertDecimal(Number(calculateSubTotal.clinton)) }}</label>
                            </template>
                            <template #foot(indep)="data">
                                <label>Total : {{ convertDecimal(Number(calculateSubTotal.indep)) }}</label>
                            </template>
                            <template #foot(ex_spring)="data">
                                <label>Total : {{ convertDecimal(Number(calculateSubTotal.ex_spring)) }}</label>
                            </template>
                            <template #foot(ph)="data">
                                <label>Total : {{ convertDecimal(Number(calculateSubTotal.ph)) }}</label>
                            </template>
                            <template #foot(bs)="data">
                                <label>Total : {{ convertDecimal(Number(calculateSubTotal.bs)) }}</label>
                            </template>
                            <template #foot(total_added)="data">
                                <label>Total : $ {{ convertDecimal(calculateSubTotal.total_added) }}</label>
                            </template>
                            <template #foot(total_on_hand)="data">
                                <label>Total : {{ calculateSubTotal.total_on_hand }}</label>
                            </template>
                            <template #foot(product_cost)="data">
                                <label>Total : $ {{ convertDecimal(calculateSubTotal.product_cost) }}</label>
                            </template>-->
                        </b-table>
                    </div>
                </div>
            </div>
        </div>
        <PDF>
            <div class="pdf" slot="header">
                <h5 class="text-center">Cost of Display Inventory</h5>
            </div>
            <div class="pdf" slot="body">
                <div class="row">
                    <b-table :fields="pdfTableFields" :items="tableData"
                             bordered class="printPDFFooter" id="data-table-pdf" foot-clone no-footer-sorting responsive small>
                        <template #head()="data">
                            <label>{{ data.label }}</label>
                        </template>
                        <template #cell(index)="data">
                            <span class="custom-table-body ml-1"> {{ (data.index + 1)}}</span>
                        </template>
                        <template #cell(total_on_hand)="data">
                            <span class="custom-table-body ml-1"> {{ Number(data.item.indep) + Number(data.item.clinton) + Number(data.item.ex_spring) + Number(data.item.ph) + Number(data.item.bs)  }}</span>
                        </template>
                        <template #cell(product_cost)="data">
                            <span class="custom-table-body ml-1"> $ {{ convertDecimal(data.item.product_cost) ? convertDecimal(data.item.product_cost) : '0.00' }}</span>
                        </template>
                        <template #cell(total_added)="data">
                            <span class="custom-table-body ml-1">$ {{  convertDecimal( (Number(data.item.indep) + Number(data.item.clinton) + Number(data.item.ex_spring) + Number(data.item.ph) + Number(data.item.bs)) * data.item.product_cost ) }}</span>
                        </template>
                        <template #foot()="data">
                            <span class="custom-table-heading"></span>
                        </template>
                        <template #foot(item_name)="data">
                            <label>Total</label>
                        </template>
                        <template #foot(clinton)="data">
                            <label>{{ convertDecimal(Number(calculateAllSubTotal.clinton)) }}</label>
                        </template>
                        <template #foot(indep)="data">
                            <label>{{ convertDecimal(Number(calculateAllSubTotal.indep)) }}</label>
                        </template>
                        <template #foot(ex_spring)="data">
                            <label>{{ convertDecimal(Number(calculateAllSubTotal.ex_spring)) }}</label>
                        </template>
                        <template #foot(ph)="data">
                            <label>{{ convertDecimal(Number(calculateAllSubTotal.ph)) }}</label>
                        </template>
                        <template #foot(bs)="data">
                            <label>{{ convertDecimal(Number(calculateAllSubTotal.bs)) }}</label>
                        </template>
                        <template #foot(total_added)="data">
                            <label>$ {{ convertDecimal(calculateAllSubTotal.total_added) }}</label>
                        </template>
                        <template #foot(total_on_hand)="data">
                            <label>{{ calculateAllSubTotal.total_on_hand }}</label>
                        </template>
                        <template #foot(product_cost)="data">
                            <label>$ {{ convertDecimal(calculateAllSubTotal.product_cost) }}</label>
                        </template>
                    </b-table>
                </div>
            </div>
        </PDF>
    </div>
</template>

<script>
    import {debounce} from "../../../helpers/common";
    import {event, eventBus} from "../../../event-bus/event-bus";
    import PDF from '../../../Modules/PDF-Modal';

    export default {
        name: "Display-Inventory",
        data() {
            return {
                pagePerPage: 10,
                currentPage: 1,
                perPage: 10,
                tableLastIndex: 0,
                tableFields: [
                    {key: 'index', label: 'Index', thClass: 'px-0', tdClass: '', parent: "custom"},
                    {key: 'action', label: 'Action', parent: "custom", thClass: "px-0 d-none", tdClass: 'flexClass d-none'}
                ],
                queryFields: {},
                axiosParams: {module: 'monument'},
                axiosParamsReport: {module: 'report'},
                axiosParamsService: {module: 'service'},
                axiosParamsSimple: {module: 'simple'},
                currentRecord: [],
                pdfTableFields: [
                    {key: 'index', label: "Index", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'product_number', label: "Product Number", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'item_name', label: "Item Name", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'indep', label: "Indep", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'clinton', label: "Buckner", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'ex_spring', label: "Ex Spring", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'ph', label: "Ph", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'bs', label: "Bs", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'total_on_hand', label: "QTY on Hand", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'product_cost', label: "Cost", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'total_added', label: "Total", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                ],
            }
        },
        metaInfo() {
            return {
                title: `Cost of Display Inventory List`,
            }
        },
        computed: {
            perPageRecordList() {
                return this.$store.state.listNumberOfRecord.recordList;
            },
            getSelected: {
                get() {
                    return this.pagePerPage
                },
                set(value) {
                    return value
                },
            },
            rows() {
                return this.tableData.length
            },
            tableData() {
                this.$store.getters.sortByAlphaNumeric({'module': 'report', 'fieldName': 'product_number'});
                return this.$store.getters.getReportTableData;
            },
            isBusy() {
                return this.$store.state.report.busy;
            },
            filterFields() {
                let filterObj = {};
                let displayCounter = 0;
                const hideListColumn = ['cost','description','gi_misc_note','product_type','gi_misc_note_a'];
                const showListColumn = ['product_number','item_name','indep','clinton','total_on_hand','ex_spring','ph','bs','product_cost','total_added'];
                const labelMap = {
                    clinton: 'Buckner', total_on_hand: 'Total QTY', product_cost: 'Cost', total_added: 'Total'
                };
                for (const [key, value] of Object.entries(this.$store.state[this.axiosParamsReport.module].columnList)) {
                    let customKey = this.customizeLabel(key);
                    let objArray = [];
                    for (let val of value) {
                        let showColumn = displayCounter > 3 ? 'd-none' : '';
                        if (hideListColumn.includes(val)) {
                            showColumn = 'd-none';
                        }
                        if (showListColumn.includes(val)) {
                            showColumn = '';
                        }
                        let label = this.customizeLabel(val);
                        if (labelMap.hasOwnProperty(val)) {
                            label = labelMap[val]
                        }
                        let obj = {key: val, label: label, parent: customKey, sortable: true, thClass: `px-0 ${showColumn}`, tdClass: showColumn};
                        objArray.push(obj);
                        displayCounter++;
                    }
                    filterObj[customKey] = objArray;
                }
                for (let objects of Object.entries(filterObj)) {
                    let key = objects[0];
                    let values = objects[1];
                    let queryObjArray = [];
                    for (let obj of values) {
                        this.tableFields.splice(this.tableFields.length - 1, 0, obj);
                        let queryObj = {column: obj.key, operator: 'like', value: ''};
                        queryObjArray.push(queryObj)
                    }
                    this.queryFields[key] = queryObjArray;
                }
                const orderMap = [
                    {key: 'item_name', loc: 3},
                    {key: 'indep', loc: 4},
                    {key: 'clinton', loc: 5},
                    {key: 'ex_spring', loc: 6},
                    {key: 'ph', loc: 7},
                    {key: 'bs', loc: 8},
                    {key: 'total_on_hand', loc: 9},
                    {key: 'product_cost', loc: 10},
                    {key: 'total_added', loc: 11},
                ];
                orderMap.forEach(objLoc => {
                    const index = this.tableFields.findIndex(obj => obj.key == objLoc.key);
                    this.tableFields.splice(objLoc.loc, 0, this.tableFields.splice(index, 1)[0]);
                })
                return filterObj;
            },
            calculateAllSubTotal() {
                let fields = {
                    clinton: 0, indep: 0, ex_spring: 0, ph: 0, bs: 0, total_added: 0, total_on_hand: 0, product_cost: 0,
                };
                let record = this.$store.state[this.axiosParamsReport.module].recordList;
                let startPoint = 0;
                let endPoint = record.length;
                for (startPoint; startPoint < endPoint; startPoint++) {
                    fields.clinton += Number(record[startPoint]['clinton'])
                    fields.indep += Number(record[startPoint]['indep'])
                    fields.ex_spring += Number(record[startPoint]['ex_spring'])
                    fields.ph += Number(record[startPoint]['ph'])
                    fields.bs += Number(record[startPoint]['bs'])
                    fields.total_added += (Number(record[startPoint]['indep']) + Number(record[startPoint]['clinton']) + Number(record[startPoint]['ex_spring']) + Number(record[startPoint]['ph']) + Number(record[startPoint]['bs'])) * record[startPoint]['product_cost']
                    fields.total_on_hand += Number(record[startPoint]['indep']) + Number(record[startPoint]['clinton']) + Number(record[startPoint]['ex_spring']) + Number(record[startPoint]['ph']) + Number(record[startPoint]['bs'])
                    fields.product_cost += record[startPoint]['product_cost']
                }
                return fields;
            },
            calculateSubTotal() {
                this.currentRecord = []
                let fields = {
                    clinton: 0,
                    indep: 0,
                    ex_spring: 0,
                    ph: 0,
                    bs: 0,
                    total_added: 0,
                    total_on_hand: 0,
                    product_cost: 0,
                };
                let record = this.$store.state[this.axiosParamsReport.module].recordList;
                let startPoint = (this.currentPage - 1) * this.pagePerPage;
                let endPoint = (this.currentPage * this.pagePerPage);
                for (startPoint; startPoint < endPoint; startPoint++) {
                    if (record[startPoint]) {
                        this.currentRecord.push(record[startPoint])
                        fields.clinton += Number(record[startPoint]['clinton'])
                        fields.indep += Number(record[startPoint]['indep'])
                        fields.ex_spring += Number(record[startPoint]['ex_spring'])
                        fields.ph += Number(record[startPoint]['ph'])
                        fields.bs += Number(record[startPoint]['bs'])
                        fields.total_added += (Number(record[startPoint]['indep']) + Number(record[startPoint]['clinton']) + Number(record[startPoint]['ex_spring']) + Number(record[startPoint]['ph']) + Number(record[startPoint]['bs'])) * record[startPoint]['product_cost']
                        fields.total_on_hand += Number(record[startPoint]['indep']) + Number(record[startPoint]['clinton']) + Number(record[startPoint]['ex_spring']) + Number(record[startPoint]['ph']) + Number(record[startPoint]['bs'])
                        fields.product_cost += record[startPoint]['product_cost']
                    }
                }
                return fields;
            },
        },
        components: {
            PDF
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Products', action: 'read'}))
                this.$router.push('/access-denied');
        },
        mounted() {
            this.getColumnList();
            this.getRecordList();
        },
        methods: {
            debounce: debounce(function () {
                this.filterRecords();
            }, 500),
            /**
             * CRUD
             * */
            getColumnList: function () {
                if (this.$store.state[this.axiosParamsReport.module].columnList.length == 0) {
                    this.axiosParamsReport.column = 'reorderColumns';
                    this.$store.dispatch('getColumnList', this.axiosParamsReport);
                }
            },
            getRecordList: function () {
                this.axiosParamsReport.method = 'info';
                this.$store.dispatch('getReportInfo', this.axiosParamsReport);
            },
            filterRecords: function () {
                this.$store.state[this.axiosParamsReport.module].busy = true;
                this.$store.state[this.axiosParamsReport.module].isFiltered = true;
                let formData = new FormData();
                for (let key in this.queryFields) {
                    this.queryFields[key].filter(obj => {
                        if (obj.operator == 'IS') {
                            obj.value = 'NULL'
                        } else if (obj.value == 'NULL') {
                            obj.value = ''
                        }
                    })
                    formData.append(key, JSON.stringify(this.queryFields[key]));
                }
                this.$store.state[this.axiosParamsReport.module].recordList = [];
                this.axiosParams.filterData = formData;
                this.axiosParams.column = 'searchMonument';
                this.$store.dispatch('getReportFilteredRecord', this.axiosParams);
                let formDataService = new FormData();
                for (let key in this.queryFields) {
                    this.queryFields[key].filter(obj => {
                        if (obj.operator == 'IS') {
                            obj.value = 'NULL'
                        } else if (obj.value == 'NULL') {
                            obj.value = ''
                        }
                    })
                    if (key == 'Monument') {
                        formDataService.append('Service', JSON.stringify(this.queryFields[key]));
                    } else {
                        formDataService.append(key, JSON.stringify(this.queryFields[key]));
                    }
                }
                this.axiosParamsService.filterData = formDataService;
                this.axiosParamsService.column = 'searchService';
                this.$store.dispatch('getReportFilteredRecord', this.axiosParamsService);
                let formDataSimple = new FormData();
                for (let key in this.queryFields) {
                    this.queryFields[key].filter(obj => {
                        if (obj.operator == 'IS') {
                            obj.value = 'NULL'
                        } else if (obj.value == 'NULL') {
                            obj.value = ''
                        }
                    })
                    if (key == 'Monument') {
                        formDataSimple.append('Simple', JSON.stringify(this.queryFields[key]));
                    } else {
                        formDataSimple.append(key, JSON.stringify(this.queryFields[key]));
                    }
                }
                this.axiosParamsSimple.filterData = formDataSimple;
                this.axiosParamsSimple.column = 'searchSimple';
                this.$store.dispatch('getReportFilteredRecord', this.axiosParamsSimple);
            },
            getRecord: function (value) {
                this.pagePerPage = value
            },

            /**
             * Generic
             * */
            clearFilter: function () {
                for (let objects of Object.values(this.queryFields)) {
                    for (let obj of objects) {
                        obj.operator = 'like';
                        obj.value = '';
                    }
                }
                this.filterRecords();
                this.$store.state[this.axiosParamsReport.module].isFiltered = false;
            },
            toggleColumn: function (column) {
                this.tableFields.filter(obj => {
                    if (obj.key == column.key) {
                        if (column.thClass.includes('d-none')) {
                            let modifyClass = column.thClass.replace("d-none", '');
                            this.$set(obj, 'thClass', modifyClass)
                            this.$set(obj, 'tdClass', modifyClass)
                        } else {
                            let modifyClass = column.thClass + " d-none";
                            this.$set(obj, 'thClass', modifyClass)
                            this.$set(obj, 'tdClass', modifyClass)
                        }
                    }
                });
            },
            customizeLabel: function (str) {
                let i, labels = str.split('_');
                for (i = 0; i < labels.length; i++) {
                    labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
                }
                return labels.join(' ');
            },
            convertDecimal: function (value) {
                value = (value).toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
                return value;
            },
            printPDF() {
                eventBus.$emit(event.PRINT_PDF);
            },
        },
    }

</script>
<style scoped>
    .flexClass {
        display: flex;
    }

    .input-md {
        width: 20rem;
    }

    .bootstrap-vue-table {
        min-height: 80vh;
    }
</style>
