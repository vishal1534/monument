<template>
    <div>
        <h5 class="mx-2 my-1 custom-view-heading">Price Sheet by Color & Type - Composites</h5>
        <div class="bg-toolbar my-2 p-1">
            <div class="d-flex justify-content-end align-items-center">
                <div class="d-flex m-auto">
                    <b-form-group class="m-0 my-auto custom-radio-and-checkbox">
                        <b-form-radio-group @change="toggleComponent" name="compositeProducts" v-model="groupUngroup">
                            <b-form-radio size="sm" value="1">Grouped</b-form-radio>
                            <b-form-radio size="sm" value="0">Ungrouped</b-form-radio>
                        </b-form-radio-group>
                    </b-form-group>
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
                                <button :class="['btn btn-sm custom-clear-btn custom-clear-text my-auto px-3 mx-3', {'btn-danger': this.$store.state[this.axiosParamsComposite.module].isFiltered}]" :disabled="!this.$store.state[this.axiosParamsComposite.module].isFiltered" @click="clearFilter">Clear Filter</button>
                                <b-pagination
                                    :per-page="pagePerPage"
                                    :total-rows="rows"
                                    align="right"
                                    aria-controls="data-table"
                                    class="my-auto ml-2"
                                    size="sm"
                                    v-model="currentPage"
                                ></b-pagination>
                                <b-form-select :options="perPageRecordList"
                                               @change="getRecord"
                                               class="input-list-md form-control-sm rounded-0 my-1 mx-3"
                                               size="sm"
                                               v-model="getSelected">
                                    <template #first>
                                        <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                                    </template>
                                </b-form-select>
                            </div>
                        </div>
                        <div class="d-flex">
                            <label class="ml-auto custom-record-showing">Showing {{(currentPage*pagePerPage) - (pagePerPage-1)}} to {{rows < 10 || currentPage*pagePerPage > rows ? rows : currentPage*pagePerPage}} of {{rows}} records</label>
                        </div>
                        <b-table :busy="isBusy" :current-page="currentPage" :fields="tableFields" :items="tableData" :per-page="pagePerPage" bordered class="my-table bootstrap-vue-table a"
                                 id="data-table" responsive small tbody-class="custom-tables-heading">
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
                            <template v-slot:cell(install_price)="row">
                                <span class="custom-table-body ml-1">$ {{ row.item.install_price ? convertDecimal(row.item.install_price) : '0.00' }}</span>
                            </template>
                            <template v-slot:cell(retail_price)="row">
                                <span class="custom-table-body ml-1">$ {{ row.item.retail_price ? convertDecimal(row.item.retail_price) : '0.00' }}</span>
                            </template>
                            <template v-slot:cell(final_price)="row">
                                <span class="custom-table-body ml-1">$ {{  row.item.final_price ? convertDecimal(row.item.final_price) : '0.00' }}</span>
                            </template>
                            <!--<template v-slot:cell(title)="row">
                                <b-button
                                    @click="row.toggleDetails"
                                    class="btn btn-sm btn-info order-form-btn py-1 mx-1 "
                                    size="sm"
                                    v-if="row.item.composite_products.length > 0">
                                    {{ row.detailsShowing ? 'Hide' : 'Show'}}
                                </b-button>
                            </template>-->
                            <template v-slot:row-details="row">
                                <b-card>
                                    <table class="table table-sm table-bordered my-2 " style="background: white !important;">
                                        <thead class="custom-table-header">
                                        <tr>
                                            <th>Product Number</th>
                                            <th>Item Name</th>
                                            <th>Color</th>
                                            <th>Type</th>
                                            <th>Selling Price</th>
                                            <th>Installation</th>
                                            <th>Total Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody class="custom-table-body">
                                        <tr v-for="(obj, key) of row.item.composite_products">
                                            <td>
                                                <template v-if="obj.monument && obj.monument.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{obj.monument[0].product_number}}</label>
                                                </template>
                                                <template v-if="obj.service && obj.service.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{obj.service[0].product_number}}</label>
                                                </template>
                                                <template v-if="obj.simple && obj.simple.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{obj.simple[0].product_number}}</label>
                                                </template>
                                            </td>
                                            <td>
                                                <template v-if="obj.monument && obj.monument.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{obj.monument[0].item_name}}</label>
                                                </template>
                                                <template v-if="obj.service && obj.service.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{obj.service[0].item_name}}</label>
                                                </template>
                                                <template v-if="obj.simple && obj.simple.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{obj.simple[0].item_name}}</label>
                                                </template>
                                            </td>
                                            <td>
                                                <template v-if="obj.monument && obj.monument.length > 0">
                                                    <label class="d-flex justify-content-center product-table"> {{ obj.monument[0].color ? obj.monument[0].color.color_title : '' }}</label>
                                                </template>
                                                <template v-if="obj.service && obj.service.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{obj.service[0].color}}</label>
                                                </template>
                                                <template v-if="obj.simple && obj.simple.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{obj.simple[0].color}}</label>
                                                </template>
                                            </td>
                                            <td>
                                                <template v-if="obj.monument && obj.monument.length > 0">
                                                    <label class="d-flex justify-content-center product-table"> {{ obj.monument[0].type ?
                                                        obj.monument[0].type.type_title : '' }}</label>
                                                </template>
                                                <template v-if="obj.service && obj.service.length > 0">
                                                    <label class="d-flex justify-content-center product-table"> {{ obj.service[0].type }}</label>
                                                </template>
                                                <template v-if="obj.simple && obj.simple.length > 0">
                                                    <label class="d-flex justify-content-center product-table"> {{ obj.simple[0].type }}</label>
                                                </template>
                                            </td>
                                            <td>
                                                <template v-if="obj.monument && obj.monument.length > 0">
                                                    <label class="d-flex justify-content-center product-table">$ {{ parseFloat((obj.monument[0].override_selling_price * obj.quantity).toFixed(2)) }}</label>
                                                </template>
                                                <template v-if="obj.service && obj.service.length > 0">
                                                    <label class="d-flex justify-content-center product-table">$ {{ parseFloat((obj.service[0].override_selling_price * obj.quantity).toFixed(2)) }}</label>
                                                </template>
                                                <template v-if="obj.simple && obj.simple.length > 0">
                                                    <label class="d-flex justify-content-center product-table">$ {{ parseFloat((obj.simple[0].override_selling_price * obj.quantity).toFixed(2)) }}</label>
                                                </template>
                                            </td>
                                            <td>
                                                <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(obj.installation_price) ?
                                                    changeNumberFormat(obj.installation_price) : '0.00' }}</label>
                                            </td>
                                            <td>
                                                <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat( obj.quantity * obj.installation_price) ?
                                                    changeNumberFormat( obj.quantity * obj.installation_price) : '0.00' }}</label>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </b-card>
                            </template>
                        </b-table>
                    </div>
                </div>
            </div>
        </div>
        <PDF>
            <div class="pdf" slot="header">
                <h5 class="text-center">{{printTitle}} Composite Price Sheet By Color/Type</h5>
            </div>
            <div class="pdf" slot="body">
                <div class="row">
                    <b-table :fields="pdfTableFields" :items="tableData"
                             bordered class="printPDFFooter" foot-clone id="data-table-pdf" no-footer-sorting responsive small>
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
                        <template v-slot:row-details="row">
                            <table class="table table-sm table-bordered my-2 ">
                                <thead class="custom-table-header">
                                <tr>
                                    <th class="font-weight-normal">Product Number</th>
                                    <th class="font-weight-normal">Item Name</th>
                                    <th class="font-weight-normal">Color</th>
                                    <th class="font-weight-normal">Type</th>
                                    <th class="font-weight-normal">Selling Price</th>
                                    <th class="font-weight-normal">Installation</th>
                                    <th class="font-weight-normal">Total Amount</th>
                                </tr>
                                </thead>
                                <tbody class="custom-table-body">
                                <tr v-for="(obj, key) of row.item.composite_products">
                                    <td>
                                        <template v-if="obj.monument && obj.monument.length > 0">
                                            <span class="d-flex justify-content-center product-table">{{obj.monument[0].product_number}}</span>
                                        </template>
                                        <template v-if="obj.service && obj.service.length > 0">
                                            <span class="d-flex justify-content-center product-table">{{obj.service[0].product_number}}</span>
                                        </template>
                                        <template v-if="obj.simple && obj.simple.length > 0">
                                            <span class="d-flex justify-content-center product-table">{{obj.simple[0].product_number}}</span>
                                        </template>
                                    </td>
                                    <td>
                                        <template v-if="obj.monument && obj.monument.length > 0">
                                            <span class="d-flex justify-content-center product-table">{{obj.monument[0].item_name}}</span>
                                        </template>
                                        <template v-if="obj.service && obj.service.length > 0">
                                            <span class="d-flex justify-content-center product-table">{{obj.service[0].item_name}}</span>
                                        </template>
                                        <template v-if="obj.simple && obj.simple.length > 0">
                                            <span class="d-flex justify-content-center product-table">{{obj.simple[0].item_name}}</span>
                                        </template>
                                    </td>
                                    <td>
                                        <template v-if="obj.monument && obj.monument.length > 0">
                                            <span class="d-flex justify-content-center product-table"> {{ obj.monument[0].color ? obj.monument[0].color.color_title : '' }}</span>
                                        </template>
                                        <template v-if="obj.service && obj.service.length > 0">
                                            <span class="d-flex justify-content-center product-table">{{obj.service[0].color}}</span>
                                        </template>
                                        <template v-if="obj.simple && obj.simple.length > 0">
                                            <span class="d-flex justify-content-center product-table">{{obj.simple[0].color}}</span>
                                        </template>
                                    </td>
                                    <td>
                                        <template v-if="obj.monument && obj.monument.length > 0">
                                                <span class="d-flex justify-content-center product-table"> {{ obj.monument[0].type ?
                                                    obj.monument[0].type.type_title : '' }}</span>
                                        </template>
                                        <template v-if="obj.service && obj.service.length > 0">
                                            <span class="d-flex justify-content-center product-table"> {{ obj.service[0].type }}</span>
                                        </template>
                                        <template v-if="obj.simple && obj.simple.length > 0">
                                            <span class="d-flex justify-content-center product-table"> {{ obj.simple[0].type }}</span>
                                        </template>
                                    </td>
                                    <td>
                                        <template v-if="obj.monument && obj.monument.length > 0">
                                            <span class="d-flex justify-content-center product-table">$ {{ parseFloat((obj.monument[0].override_selling_price * obj.quantity).toFixed(2)) }}</span>
                                        </template>
                                        <template v-if="obj.service && obj.service.length > 0">
                                            <span class="d-flex justify-content-center product-table">$ {{ parseFloat((obj.service[0].override_selling_price * obj.quantity).toFixed(2)) }}</span>
                                        </template>
                                        <template v-if="obj.simple && obj.simple.length > 0">
                                            <span class="d-flex justify-content-center product-table">$ {{ parseFloat((obj.simple[0].override_selling_price * obj.quantity).toFixed(2)) }}</span>
                                        </template>
                                    </td>
                                    <td><span class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(obj.installation_price) ?
                                                changeNumberFormat(obj.installation_price) : '0.00' }}</span>
                                    </td>
                                    <td><span class="d-flex justify-content-center product-table">$ {{ changeNumberFormat( obj.quantity * obj.installation_price) ?
                                                changeNumberFormat( obj.quantity * obj.installation_price) : '0.00' }}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </template>
                        <template #foot()="data">
                            <span class="custom-table-heading"></span>
                        </template>
                        <template #foot(item_name)="data">
                            <label>Total</label>
                        </template>
                        <template #foot(install_price)="data">
                            <label>$ {{ convertDecimal(Number(calculateAllSubTotal.installation)) }}</label>
                        </template>
                        <template #foot(final_price)="data">
                            <label>$ {{ convertDecimal(Number(calculateAllSubTotal.total_amount)) }}</label>
                        </template>
                    </b-table>
                </div>
            </div>
        </PDF>
    </div>
</template>

<script>
    import {debounce} from "../../../helpers/common";
    import PDF from '../../../Modules/PDF-Modal';
    import {event, eventBus} from "../../../event-bus/event-bus";

    export default {
        name: "Price-Sheet-By-Color-And-Type-Composites",
        data() {
            return {
                pagePerPage: 10,
                currentPage: 1,
                perPage: 8,
                tableFields: [
                    {key: 'index', label: 'Index', thClass: 'px-0', tdClass: 'custom-td-classs', parent: "custom"},
                    {key: 'action', label: 'Action', parent: "custom", thClass: "px-0 d-none", tdClass: 'flexClass d-none'}
                ],
                queryFields: {},
                axiosParamsComposite: {module: 'compositeReport'},
                pdfTableFields: [
                    {key: 'index', label: "Index", class: 'small', thClass: 'text-nowrap', tdClass: 'font-weight-bold'},
                    {key: 'product_number', label: "Product Number", class: 'small', thClass: 'text-nowrap', tdClass: 'font-weight-bold'},
                    {key: 'item_name', label: "Item Name", class: 'small', thClass: 'text-nowrap', tdClass: 'font-weight-bold '},
                    {key: 'color', label: "Color", class: 'small', thClass: 'text-nowrap', tdClass: 'font-weight-bold'},
                    {key: 'type', label: "Type", class: 'small', thClass: 'text-nowrap', tdClass: 'font-weight-bold'},
                    {key: 'retail_price', label: "Selling Price", class: 'small', thClass: 'text-nowrap', tdClass: 'font-weight-bold'},
                    {key: 'install_price', label: "Installation", class: 'small', thClass: 'text-nowrap', tdClass: 'font-weight-bold'},
                    {key: 'final_price', label: "Total Amount", class: 'small', thClass: 'text-nowrap', tdClass: 'font-weight-bold'},
                ],
                groupUngroup: 1,
                printTitle: 'Grouped',
            }
        },
        metaInfo() {
            return {
                title: `Price Sheet by Color And Type - Composites List`,
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
                return this.$store.getters.getReportCompositeTableData.length
            },
            tableData() {
                this.$store.getters.sortByAlphaNumeric({'module': 'compositeReport', 'fieldName': 'product_number'});
                if (this.groupUngroup == '0') {
                    return this.toggleCompositeProduct(true)
                } else {
                    return this.$store.getters.getReportCompositeTableData;
                }
            },
            isBusy() {
                return this.$store.state[this.axiosParamsComposite.module].busy;
            },
            filterFields() {
                let filterObj = {};
                let displayCounter = 0;
                const hideListColumn = ['stocked', 'price'];
                const showListColumn = ['install_price', 'retail_price', 'final_price'];
                const labelMap = {
                    retail_price: 'Selling Price', install_price: 'Installation', final_price: 'Total Amount'
                };
                for (const [key, value] of Object.entries(this.$store.state[this.axiosParamsComposite.module].columnList)) {
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
                        let obj = {key: val, label: label, parent: customKey, sortable: true, thClass: `px-0 ${showColumn}`, tdClass: `custom-td-classs ${showColumn}`};
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
                return filterObj;
            },
            calculateAllSubTotal() {
                let fields = {
                    installation: 0, total_amount: 0
                };
                let record = this.$store.state[this.axiosParamsComposite.module].recordList;
                let startPoint = 0;
                let endPoint = record.length;
                for (startPoint; startPoint < endPoint; startPoint++) {
                    fields.installation += Number(record[startPoint]['install_price'])
                    fields.total_amount += Number(record[startPoint]['final_price'])
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
                if (this.$store.state[this.axiosParamsComposite.module].columnList.length == 0) {
                    this.axiosParamsComposite.column = 'columns';
                    this.$store.dispatch('getColumnList', this.axiosParamsComposite);
                }
            },
            async getRecordList() {
                this.axiosParamsComposite.method = 'info';
                await this.$store.dispatch('getReportInfo', this.axiosParamsComposite);
            },
            filterRecords: function () {
                this.$store.state[this.axiosParamsComposite.module].busy = true;
                this.$store.state[this.axiosParamsComposite.module].isFiltered = true;
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
                this.axiosParamsComposite.filterData = formData;
                this.axiosParamsComposite.method = 'search';
                this.$store.dispatch('getCompsiteReportFilteredRecord', this.axiosParamsComposite);
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
                this.$store.state[this.axiosParamsComposite.module].isFiltered = false;
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
            changeNumberFormat: function (value) {
                return this.$store.getters.changeNumberFormat(value);
            },
            printPDF() {
                eventBus.$emit(event.PRINT_PDF);
            },
            toggleComponent() {
                this.groupUngroup == '0' ? this.printTitle = 'Ungrouped' : this.printTitle = 'Grouped'
                this.groupUngroup == '0' ? this.toggleCompositeProduct(true) : this.toggleCompositeProduct(false)
            },
            toggleCompositeProduct: function (toggle) {
                let record = this.$store.state[this.axiosParamsComposite.module].recordList;
                for (let item of record) {
                    if (item.composite_products && item.composite_products.length > 0)
                        this.$set(item, "_showDetails", toggle);
                }
                return record
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

    .order-form-btn {
        font-size: 0.5rem;
    }
</style>
