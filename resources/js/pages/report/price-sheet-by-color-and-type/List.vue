<template>
    <div>
        <h5 class="mx-2 my-1 custom-view-heading">Price Sheet by Color & Type</h5>
        <div class="bg-toolbar my-2 p-1">
            <div class="d-flex justify-content-end align-items-center">
                <div class="d-flex m-auto">
                    <button @click="printPDF" class="btn-info mx-1 custom-infobtn-toolbar custom-infobtn-text" type="button">Print</button>
                </div>
                <div class="d-flex">
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
                            <b-dropdown class="m-2 custom-choose-btn d-none " id="dropdown-form" ref="dropdown"
                                        size="sm" text="Choose Columns" variant="info custom-choose-text">
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
                                <b-form-select :options="perPageRecordList" @change="getRecord"
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
                        <b-table :busy="isBusy" :current-page="currentPage" :fields="tableFields" :items="tableData" :per-page="pagePerPage" bordered
                                 class="my-table bootstrap-vue-table a" hover id="data-table" responsive small striped>
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
                                        <input @input="debounce" @keyup.enter="filterRecords" class="form-control-sm border rounded-0 custom-input-width" placeholder="Search here..." type="text" v-model="queryFields[data.field.parent].find(item => item.column == data.column).value"/>
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
                            <template #cell(override_selling_price)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.override_selling_price ? convertDecimal(Number(data.item.override_selling_price)) : '0.00' }}</span>
                            </template>
                            <template #cell(installation_amount)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.installation ? convertDecimal(Number(data.item.installation.installation_amount)) : '0.00' }}</span>
                            </template>
                            <template #cell(selling_price_with_installation)="data">
                                <span class="custom-table-body ml-1">$ {{ data.item.selling_price_with_installation ? convertDecimal(Number(data.item.selling_price_with_installation)) : '0.00' }}</span>
                            </template>
                        </b-table>
                    </div>
                </div>
            </div>
        </div>
        <PDF>
            <div class="pdf" slot="header">
                <h5 class="text-center">Price Sheet by Color & Type</h5>
            </div>
            <div class="pdf" slot="body">
                <div class="row">
                    <b-table :fields="pdfTableFields" :items="tableData" bordered class="" id="data-table-pdf"
                             responsive
                             small>
                        <template #head()="data">
                            <label>{{ data.label }}</label>
                        </template>
                        <template #cell(index)="data">
                            <span class="custom-table-body ml-1"> {{ (data.index + 1)}}</span>
                        </template>
                        <template #cell(override_selling_price)="data">
                            <span class="custom-table-body ml-1">$ {{ data.item.override_selling_price ? convertDecimal(Number(data.item.override_selling_price)) : '0.00' }}</span>
                        </template>
                        <template #cell(installation_amount)="data">
                            <span class="custom-table-body ml-1">$ {{ data.item.installation ? convertDecimal(Number(data.item.installation.installation_amount)) : '0.00' }}</span>
                        </template>
                        <template #cell(selling_price_with_installation)="data">
                            <span class="custom-table-body ml-1">$ {{ data.item.selling_price_with_installation ? convertDecimal(Number(data.item.selling_price_with_installation)) : '0.00' }}</span>
                        </template>
                        <template #cell(color_title)="data">
                            <span class="custom-table-body ml-1">{{  data.item.color_id ? data.item.color.color_title : '' }}</span>
                        </template>
                        <template #cell(type_title)="data">
                            <span class="custom-table-body ml-1">{{  data.item.type_id ? data.item.type.type_title : '' }}</span>
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
        name: "Price-Sheet-By-Color-And-Type",
        data() {
            return {
                pagePerPage: 10,
                currentPage: 1,
                perPage: 10,
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
                    {key: 'color_title', label: "Color", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'type_title', label: "Type", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'misc_note_d', label: "No Engraving (D)", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'override_selling_price', label: "Selling Price", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'installation_amount', label: "Installation", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                    {key: 'selling_price_with_installation', label: "Total Amount", class: 'small', thClass: 'text-nowrap', tdClass: ''},
                ],
            }
        },
        metaInfo() {
            return {
                title: `Price Sheet by Color & Type`,
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
                const hideListColumn = ['cost', 'product_cost','description','total_on_hand','gi_misc_note','gi_misc_note_a'];
                const showListColumn = ['product_number', 'item_name', 'installation_amount', 'selling_price_with_installation', 'override_selling_price',
                    'misc_note_d','color_title','type_title', 'product_type'];
                const labelMap = {
                    misc_note_d: 'No Engraving (D)',
                    override_selling_price: 'Selling Price',
                    installation_amount: 'Installation',
                    selling_price_with_installation: 'Total Amount',
                    color_title: 'Color',
                    type_title: 'Type',
                    product_type: 'Category',
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
                    {key: 'product_type', loc: 1},
                    {key: 'product_number', loc: 2},
                    {key: 'item_name', loc: 3},
                    {key: 'color_title', loc: 4},
                    {key: 'type_title', loc: 5},
                    {key: 'misc_note_d', loc: 6},
                    {key: 'override_selling_price', loc: 7},
                    {key: 'installation_amount', loc: 8},
                    {key: 'selling_price_with_installation', loc: 9},
                ];
                orderMap.forEach(objLoc => {
                    const index = this.tableFields.findIndex(obj => obj.key == objLoc.key);
                    this.tableFields.splice(objLoc.loc, 0, this.tableFields.splice(index, 1)[0]);
                })
                return filterObj;
            },
            calculateSubTotal() {
                this.currentRecord = []
                let record = this.$store.state[this.axiosParamsReport.module].recordList;
                let startPoint = (this.currentPage - 1) * this.pagePerPage;
                let endPoint = (this.currentPage * this.pagePerPage);
                for (startPoint; startPoint < endPoint; startPoint++) {
                    if (record[startPoint]) {
                        this.currentRecord.push(record[startPoint]);
                    }
                }
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
                this.calculateSubTotal
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
            changeDateFormat: function (value) {
                return this.$store.getters.changeDateFormat(value);
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
