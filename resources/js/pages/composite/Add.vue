<template>
    <div :class="hideInModal?' custom-modal-margin':''">
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Composite</h5>
            <div class="bg-toolbar my-2 p-1">
                <Toolbar :id="formFields.id" :saveDisabled="saveDisabled"></Toolbar>
            </div>
        </div>
        <div class="col-md-12 custom-margin pr-1 my-2" id="composite">
            <form class="div-shadow bg-white rounded" id="composite-form">
                <template v-if="isLoading">
                    <div class="text-center text-info my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>
                <template v-else>
                    <b-form-input hidden name="composite[id]" size="sm" type="text" v-model="formFields.id"></b-form-input>
                    <div class="general-information-row-1">
                        <div>
                            <h6 class="pt-3 custom-form-heading">General Information</h6>
                        </div>
                        <div class="pt-2">
                            <button :disabled="qtySaleHistory" class="btn-info mx-4 mt-1 custom-infobtn-toolbar custom-infobtn-text" type="button"
                                    v-b-modal.product-sale-history v-if="id ? isUpdatePermitted : isCreatePermitted">
                                {{'Sale History' }}<span class="spinner-grow spinner-grow-sm ml-1" v-if="qtySaleHistory"></span>
                            </button>
                        </div>
                    </div>
                    <div class="general-information-row-1 ml-n2">
                        <div>
                            <label class="mr-4">Product #</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-lg my-auto ml-1" name="product_number" size="sm" type="text" v-model="formFields.product_number"></b-form-input>
                        </div>
                        <div class="mx-4 flex-grow-1">
                            <label>Item Name</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="w-100 my-auto" name="item_name" size="sm" type="text" v-model="formFields.item_name"></b-form-input>
                        </div>
                        <div class="mx-4 flex-grow-1">
                            <label>Item Description</label>
                            <b-form-textarea
                                :disabled="hideInModal || hideinAuth"
                                class="w-100"
                                name="description"
                                no-resize
                                rows="3"
                                size="sm"
                                v-model="formFields.description"
                            ></b-form-textarea>
                        </div>
                    </div>
                    <div class="general-information-row-2 pb-2">
                        <label class="mr-4">Category</label>
                        <b-dropdown :disabled="hideInModal" class="input-category my-auto border rounded ml-2 cutsom-width-dropdown" no-caret size="sm" toggle-class=""
                                    variant="none">
                            <template #button-content>
                                <div class="d-flex product-color">
                                    <small>{{customizeLabel(categoryTitle)}}</small>
                                    <small class="w-25 ml-auto custom-caret"></small>
                                </div>
                            </template>
                            <b-dropdown-group class="overflow-auto scroll px-1">
                                <b-form-input
                                    class="mt-1"
                                    placeholder="Search..."
                                    size="sm"
                                    v-model="searchCategory"
                                ></b-form-input>
                                <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                <template v-if="categories.length > 0">
                                    <template v-for="(obj, key) of categories">
                                        <b-dropdown-group @click="handleDropdownChange">
                                            <b-dropdown-item-button :key="key" @click="setDetail(obj,'category')"
                                                                    class="w-100">
                                                <label class="btn btn-sm m-0">{{obj.text}}</label>
                                            </b-dropdown-item-button>
                                            <b-icon @click="deleteDropDown(obj.value)" aria-hidden="true" class="mt-n4 float-right" icon="trash-fill" variant="danger"></b-icon>
                                        </b-dropdown-group>
                                    </template>
                                </template>
                                <template v-else>
                                    <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                    <button @click="saveDetail('title')" class="d-flex m-auto px-3 btn-sm btn-info custom-add-btn"
                                            type="button">Add Category
                                    </button>
                                </template>
                            </b-dropdown-group>
                        </b-dropdown>
                    </div>
                    <div class="general-information-row-3 ml-n2 ">
                        <div>
                            <label>Total Sold</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" :min=0 class="input-sm" name="total_sold" oninput="validity.valid||(value=0);" size="sm" type="number" v-model="formFields.sold"></b-form-input>
                        </div>
                    </div>

                    <hr class="border my-3">

                    <div class="product-row">
                        <b-table :fields="productTableFields" :items="formFields.composite_products" bordered class="col-md-11 ml-0" foot-clone hover id="data-table" responsive
                                 small
                                 striped>
                            <template #head()="data">
                                <span class="custom-form-heading">{{ data.label }}</span>
                            </template>
                            <template v-slot:cell(product_number)="row">
                                <template v-if="row.item.monument && row.item.monument.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.monument[0].product_number}}</label>
                                </template>
                                <template v-if="row.item.service && row.item.service.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.service[0].product_number}}</label>
                                </template>
                                <template v-if="row.item.simple && row.item.simple.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.simple[0].product_number}}</label>
                                </template>
                            </template>
                            <template v-slot:cell(item_name)="row">
                                <template v-if="row.item.monument && row.item.monument.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.monument[0].item_name}}</label>
                                </template>
                                <template v-if="row.item.service && row.item.service.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.service[0].item_name}}</label>
                                </template>
                                <template v-if="row.item.simple && row.item.simple.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.simple[0].item_name}}</label>
                                </template>
                            </template>
                            <template v-slot:cell(quantity)="row">
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-product-sm" min="0" name="quantity" oninput="validity.valid||(value=0);" size="sm" type="number" v-model="row.item.quantity"></b-form-input>
                            </template>
                            <template v-slot:cell(product_price_override)="row">
                                <template v-if="row.item.monument && row.item.monument.length > 0">
                                    <label class="d-flex justify-content-center product-table">$ {{row.item.monument[0].override_selling_price}}</label>
                                </template>
                                <template v-if="row.item.service && row.item.service.length > 0">
                                    <label class="d-flex justify-content-center product-table">$ {{row.item.service[0].override_selling_price}}</label>
                                </template>
                                <template v-if="row.item.simple && row.item.simple.length > 0">
                                    <label class="d-flex justify-content-center product-table">$ {{row.item.simple[0].override_selling_price}}</label>
                                </template>
                            </template>
                            <template v-slot:cell(amount)="row">
                                <template v-if="row.item.monument && row.item.monument.length > 0">
                                    <label class="d-flex justify-content-center product-table">$ {{ parseFloat((row.item.monument[0].override_selling_price * row.item.quantity).toFixed(2)) }}</label>
                                </template>
                                <template v-if="row.item.service && row.item.service.length > 0">
                                    <label class="d-flex justify-content-center product-table">$ {{ parseFloat((row.item.service[0].override_selling_price * row.item.quantity).toFixed(2)) }}</label>
                                </template>
                                <template v-if="row.item.simple && row.item.simple.length > 0">
                                    <label class="d-flex justify-content-center product-table">$ {{ parseFloat((row.item.simple[0].override_selling_price * row.item.quantity).toFixed(2)) }}</label>
                                </template>
                            </template>
                            <template v-slot:cell(installation_price)="row">
                                <label>$ {{row.item.installation_price}}</label>
                            </template>
                            <template v-slot:cell(installation_amount)="row">
                                <label>$ {{ parseFloat((row.item.installation_price * row.item.quantity).toFixed(2)) }}</label>
                            </template>
                            <template v-slot:cell(installation)="row">
                                <b-form-row class="m-0 my-auto">
                                    <b-form-radio :disabled="hideInModal || hideinAuth" :value=1 class="mr-1 custom-radio-and-checkbox" v-model="row.item.installation">Yes</b-form-radio>
                                    <b-form-radio :disabled="hideInModal || hideinAuth" :value=0 class="ml-1 custom-radio-and-checkbox" v-model="row.item.installation">No</b-form-radio>
                                </b-form-row>
                            </template>
                            <template v-slot:cell(total_on_hand)="row">
                                <template v-if="row.item.monument && row.item.monument.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.monument[0].total_on_hand}}</label>
                                </template>
                                <template v-if="row.item.service && row.item.service.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.service[0].total_on_hand}}</label>
                                </template>
                                <template v-if="row.item.simple && row.item.simple.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.simple[0].total_on_hand}}</label>
                                </template>
                            </template>
                            <template v-slot:cell(stocked)="row">
                                <template v-if="row.item.monument && row.item.monument.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.monument[0].quantity_stocked}}</label>
                                </template>
                                <template v-if="row.item.service && row.item.service.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.service[0].quantity_stocked}}</label>
                                </template>
                                <template v-if="row.item.simple && row.item.simple.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.simple[0].quantity_stocked}}</label>
                                </template>
                            </template>
                            <template v-slot:cell(weight)="row">
                                <template v-if="row.item.monument && row.item.monument.length > 0">
                                    <label class="d-flex justify-content-center product-table" v-if="row.item.monument[0].total_weight">{{row.item.monument[0].total_weight}}</label>
                                    <label class="d-flex justify-content-center product-table" v-else>{{row.item.monument[0].weight}}</label>
                                </template>
                                <template v-if="row.item.service && row.item.service.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.service[0].weight}}</label>
                                </template>
                                <template v-if="row.item.simple && row.item.simple.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.simple[0].weight}}</label>
                                </template>
                            </template>
                            <template #cell(action)="data">
                                <a @click="removeProduct(data.index, data.item.id)" class="btn btn-danger mx-1 py-1" href="javascript:void(0)">
                                    <i aria-hidden="true" class="fa fa-trash-o"></i>
                                </a>
                            </template>
                            <template #foot()="data">
                                <span class="custom-table-heading"></span>
                            </template>
                            <template #foot(amount)="data">
                                <label>Total : $ {{ formFields.price = getTotal.amount}}</label>
                            </template>
                            <template #foot(installation_amount)="data">
                                <label>Total : $ {{ formFields.install_price = getTotal.totalInstallAmount }}</label>
                            </template>
                            <template #foot(weight)="data">
                                <label>Total : {{formFields.totalWeight = getTotal.weight}}</label>
                            </template>
                        </b-table>
                    </div>
                    <div class="selling-price-row ml-1 ">
                        <div>
                            <label>Selling Price Change +- %age</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-total" size="sm" type="number" v-model="formFields.percentage"
                            ></b-form-input>
                        </div>
                        <div>
                            <label title="Sum of Price Overrides" v-b-tooltip.hover>Total Retail Price</label>
                            <Price :classes="'input-total'" :disable="hideInModal || hideinAuth" :readonly="true" v-model="formFields.retail_price = getTotal.subtotal"></Price>
                         </div>
                        <div>
                            <label>Total Install Price</label>
                            <Price :classes="'input-total'" :disable="hideInModal || hideinAuth" :readonly="true" v-model="formFields.install_price = getTotal.totalInstallAmount"></Price>
                        </div>
                        <div>
                            <label title="Total Retail Price + Total Install Price" v-b-tooltip.hover>Total Final Price</label>
                            <vue-numeric :disable="hideInModal || hideinAuth" :readonly="true" class=" input-total input-md form-control form-control-sm" currency="$" separator="," v-bind:precision="2" v-model="formFields.final_price = getTotal.total"></vue-numeric>
                        </div>
                    </div>
                    <div class="product-row" v-if="!hideInModal || hideinAuth">
                        <div>
                            <b-dropdown class="border rounded input-product dropdown-width" no-caret size="sm" variant="none">
                                <template #button-content>
                                    <div class="d-flex product-color">
                                        <small>Select Product by Number</small>
                                        <small class="w-25 ml-auto custom-caret-form"></small>
                                    </div>
                                </template>
                                <b-dropdown-group class="overflow-auto scroll px-1">
                                    <b-form-input
                                        @keyup="findProducts('byNumber')"
                                        class="mt-1"
                                        placeholder="Search..."
                                        size="sm"
                                        v-model="searchByNumber"
                                    ></b-form-input>
                                    <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                    <template v-for="(objects, key) of productsByNumber">
                                        <b-dropdown-group :header="customizeLabel(key)">
                                            <template v-if="typeof objects === 'object'">
                                                <b-dropdown-item-button :key="key + index" @click="addProduct(obj,key)" class="small" v-for="(obj, index) of objects">
                                                    {{obj.product_number}}
                                                </b-dropdown-item-button>
                                            </template>
                                            <template v-else>
                                                <b-dropdown-text class="small">{{objects}}</b-dropdown-text>
                                            </template>
                                        </b-dropdown-group>
                                    </template>
                                </b-dropdown-group>
                            </b-dropdown>
                        </div>
                        <div>
                            <b-dropdown class="border rounded input-product dropdown-width" no-caret size="sm" variant="none">
                                <template #button-content>
                                    <div class="d-flex product-color">
                                        <small>Select Product by Title</small>
                                        <small class="w-25 ml-auto custom-caret-form"></small>
                                    </div>
                                </template>
                                <b-dropdown-group class="overflow-auto scroll px-1">
                                    <b-form-input
                                        @keyup="findProducts('byTitle')"
                                        class="mt-1"
                                        placeholder="Search..."
                                        size="sm"
                                        v-model="searchByTitle"
                                    ></b-form-input>
                                    <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                    <template v-for="(objects, key) of productsByTitle">
                                        <b-dropdown-group :header="customizeLabel(key)">
                                            <template v-if="typeof objects === 'object'">
                                                <b-dropdown-item-button :key="key + index" @click="addProduct(obj,key)" class="small" v-for="(obj, index) of objects">
                                                    {{obj.item_name}}
                                                </b-dropdown-item-button>
                                            </template>
                                            <template v-else>
                                                <b-dropdown-text class="small">{{objects}}</b-dropdown-text>
                                            </template>
                                        </b-dropdown-group>
                                    </template>
                                </b-dropdown-group>
                            </b-dropdown>
                        </div>
                    </div>
                    <hr class="border my-3">
                    <h6 class="heading-of-row pt-3 custom-form-heading">Design and Upload</h6>
                    <div class="row col-md-12 row">
                        <div class="col-md-4 row my-1 no-gutters" v-if="!hideInModal || hideinAuth">
                            <label class="m-1">Design Image:</label>
                            <b-form-file
                                :disabled="hideInModal || hideinAuth"
                                browse-text="Choose File"
                                class="col-md-8 ml-2 border rounded custom-file-upload mt-0"
                                drop-placeholder="Drop file here..."
                                placeholder="No Chosen File"
                                plain
                                ref="inputFile"
                                v-on:change="previewImage"
                            ></b-form-file>
                        </div>
                        <div :class="hideInModal || hideinAuth?' flex-column border ml-3':'flex-column border ml-n5 mt-n3'" v-if="formFields.image">
                            <img :src="formFields.image ? storagePath+formFields.image : imageDefault" alt="product-image" class=" p-1 product-image"
                                 @click="openPreviewNewPage(storagePath+formFields.image)" style="cursor: pointer;">
                        </div>
                         <div class="col-md-4 row my-1 no-gutters" v-if="!hideInModal || hideinAuth">
                            <label class="m-1">Files:</label>
                            <b-form-file
                                :disabled="hideInModal || hideinAuth"
                                browse-text="Choose File"
                                class="col-md-8 ml-2 border rounded custom-file-upload mt-0"
                                drop-placeholder="Drop file here..."
                                multiple
                                placeholder="No Chosen Files"
                                plain
                                ref="inputFile1"
                                v-model="documents.files"
                                v-on:change="checkFile"
                            ></b-form-file>
                            <label class="ml-5 mt-1">You can also upload multiple files.<br> <span class="small text-danger">Docxs *, excel *, and PDFs formats are allowed</span></label>
                        </div>
                    </div>
                    <div class="documents-row ml-n2">
                        <div class="flex-wrap m-1 ">
                            <template v-if="this.formFields.files">
                                <template v-for="(file,index) of this.formFields.files">
                                    <div class="flex-column border mx-1  pl-0 py-1 justify-content-center file-container">
                                        <i class="fa fa-file fa-2x m-auto" @click="openPreviewNewPage(imagePath+file.file)" style="cursor: pointer;"></i>
                                        <label class="" @click="openPreviewNewPage(imagePath+file.file)" style="cursor: pointer;">
                                            {{file.file.length > 10 ? file.file.substr(0,10)+'...' : file.path}}</label>
                                        <div class="btn m-auto" v-if="!hideInModal || hideinAuth">
                                            <i @click="deleteFile(file.id,index)" aria-hidden="true"
                                               class="fa fa-trash-o mx-2"></i>
                                            <a :download="file.file" :href="`/${storagePath+file.file}`" style="margin-top: -2px !important;color: #000 !important;">
                                                <i aria-hidden="true" class="fa fa-download mx-2"></i></a>
                                        </div>
                                    </div>
                                </template>
                            </template>
                        </div>
                    </div>
                </template>
            </form>
        </div>
        <b-modal :title="modalData.title"
                 id="image-modal"
                 ok-only
                 ok-title="Cancel"
                 ok-variant="secondary"
                 scrollable
                 size="lg">
            <div class="d-flex">
                <img :src="modalData.src" class="w-100">
            </div>
        </b-modal>
        {{compositeSaleHistory}}
        <SaleHistory :invoice="'composite_invoice'" :module="this.axiosParams.module" :recordID="formFields.id"></SaleHistory>
    </div>
</template>

<script>
    import Toolbar from "./Toolbar";
    import Price from "../../Modules/Price";
    import SaleHistory from '../product-monument/SaleHistory';
    import {event, eventBus} from "../../event-bus/event-bus";
    import VueNumeric from 'vue-numeric';
    import {deleteCompositeProduct, deleteProductFile, deleteRecord, downloadFile, fetchRecord, nextRecord, saveRecord, searchCompositeProducts} from "../../helpers/axios";

    export default {
        name: "Add",
        props: {
            id: {
                type: Number
            },
            hideInModal: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                pageNumber: 1,
                // storeID : this.$store.getters.getCurrentStoreID,
                formFields: {
                    // store_id: this.storeID,
                    id: 0,
                    item_name: null,
                    product_number: null,
                    composite_price: 0,
                    description: null,
                    price: 0,
                    retail_price: 0,
                    install_price: 0,
                    final_price: 0,
                    stocked: null,
                    added: null,
                    sold: null,
                    on_hand: null,
                    category_id: null,
                    documents: {image: null, files: []},
                    composite_products: [],
                },
                productTableFields: [
                    {key: 'product_number', label: "Product #"},
                    {key: 'item_name', label: "Product Name"},
                    {key: 'quantity', label: "Quantity"},
                    {key: 'product_price_override', label: "Selling Price"},
                    {key: 'amount', label: "Amount"},
                    {key: 'installation_price', label: "Installation Price"},
                    {key: 'installation_amount', label: "Installation Amount"},
                    {key: 'installation', label: "Installation"},
                    {key: 'total_on_hand', label: "Total on Hand"},
                    {key: 'stocked', label: "Qty Stocked"},
                    {key: 'weight', label: "Weight"},
                    {key: 'action', label: "Action", thClass: this.$props.hideInModal ? 'd-none' : '', tdClass: this.$props.hideInModal ? 'd-none' : ''},
                ],
                productList: [],
                productsByNumber: {},
                productsByTitle: {},
                searchByNumber: "",
                searchByTitle: "",
                imagePath: '/images/composite/',
                imageDefault: '/images/default-image.jpg',
                storagePath: '/images/composite/',
                modalData: {src: '', title: ''},
                axiosParams: {module: 'composite'},
                axiosParamsCategory: {module: 'compositeCategory'},
                searchCategory: "",
                alertMessage: '',
                hideAlert: true,
                successResponse: false,
                errorResponse: false,
                saveDisabled: false,
                hideinAuth: false,
                qtySaleHistory: false,
                showToastAlert : true,
            }
        },
        metaInfo() {
            return {
                title: `${this.formFields.id ? 'Edit' : 'Add'} Composite`,
            }
        },
        created() {
            eventBus.$on(event.SAVE_COMPOSITE, this.storeComposite);
            eventBus.$on(event.FIRST_COMPOSITE_RECORD, this.first);
            eventBus.$on(event.LAST_COMPOSITE_RECORD, this.last);
            eventBus.$on(event.NEXT_COMPOSITE_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_COMPOSITE_RECORD, this.prev);
            eventBus.$on(event.GET_COMPOSITE, this.getCompositeDropDown);
            eventBus.$on(event.ADD_COMPOSITE, this.clearForm);
            eventBus.$on(event.DELETE_COMPOSITE, this.deleteRecord);
        },
        destroyed() {
            eventBus.$off(event.SAVE_COMPOSITE, this.storeComposite);
            eventBus.$off(event.FIRST_COMPOSITE_RECORD, this.first);
            eventBus.$off(event.LAST_COMPOSITE_RECORD, this.last);
            eventBus.$off(event.NEXT_COMPOSITE_RECORD, this.next);
            eventBus.$off(event.PREVIOUS_COMPOSITE_RECORD, this.prev);
            eventBus.$off(event.GET_COMPOSITE, this.getCompositeDropDown);
            eventBus.$off(event.ADD_COMPOSITE, this.clearForm);
            eventBus.$off(event.DELETE_COMPOSITE, this.deleteRecord);
        },
        components: {
            Toolbar,
            Price,
            SaleHistory,
            VueNumeric
        },
        computed: {
            isLoading() {
                return this.$store.state[this.axiosParams.module].busy;
            },
            alertClasses: function () {
                return {
                    alert: true,
                    'alert-success': this.successResponse,
                    'alert-danger': this.errorResponse,
                    'd-none': this.hideAlert
                }
            },
            categoryTitle() {
                let opt = "Select";
                if (this.$store.state[this.axiosParams.module].compositeInfo?.length > 0 && this.formFields.category_id != 0 && this.formFields.category_id != null) {
                    opt = this.$store.state[this.axiosParams.module].compositeInfo.filter(obj => obj.id == this.formFields.category_id);
                    opt = opt.length > 0 ? opt[0].title : "Select";
                }
                return opt
            },
            categories() {
                let options = [];
                if (this.$store.state[this.axiosParams.module].compositeInfo) {
                    this.$store.getters.sortByAlphaNumeric({'fieldName': 'title', 'recordList': this.$store.state[this.axiosParams.module].compositeInfo});
                    for (let opt of this.$store.state[this.axiosParams.module].compositeInfo) {
                        let obj = {value: opt.id, text: opt.title};
                        options.push(obj);
                    }
                    if (this.searchCategory != '') {
                        options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchCategory.toUpperCase()) > -1)
                    }
                }
                return options;
            },
            getTotal() {
                let subTotal = 0;
                let cost = 0;
                let total = 0;
                let getPercent = 0;
                let installation = 0;
                let overridePrice = 0;
                let amount = 0;
                let totalInstallAmount = 0;
                let weight = 0;
                for (let prod of this.formFields.composite_products) {
                    if (prod.monument && prod.monument.length > 0) {
                        cost += parseFloat(prod.monument[0].product_cost * prod.quantity);
                        overridePrice += parseFloat(prod.monument[0].override_selling_price) * prod.quantity;
                        amount += parseFloat(prod.monument[0].override_selling_price) * prod.quantity;
                        if (prod.monument[0].total_weight)
                            weight += parseFloat(prod.monument[0].total_weight) ? parseFloat(prod.monument[0].total_weight) : 0;
                        else
                            weight += parseFloat(prod.monument[0].weight) ? parseFloat(prod.monument[0].weight) : 0;

                        subTotal += parseFloat(prod.monument[0].override_selling_price) ? parseFloat(prod.monument[0].override_selling_price) * prod.quantity : 0;

                    } else {
                        let product = [];
                        product = this.$store.getters.getSimpleAndServicePrice(prod);
                        cost += parseFloat(product.product_cost) * prod.quantity;
                        overridePrice += parseFloat(product.override_selling_price) * prod.quantity;
                        // overridePrice += parseFloat(product.price) * prod.quantity;
                        // amount += parseFloat(product.price) * prod.quantity;
                        amount += parseFloat(product.override_selling_price) * prod.quantity;
                        weight += parseFloat(product.weight) ? parseFloat(product.weight) : 0;
                        subTotal += parseFloat(product.price) * prod.quantity;

                    }
                    // cost += parseFloat(prod.price * prod.quantity);
                    // subTotal += parseFloat(prod.price_override * prod.quantity);
                    // here prod.installation depends on monument edit if installation is 0 that means installation_price will not count here
                    // if installation in 1 then installation_price will be count so thats why totalInstallAmount is not calculating correctly.
                    if (prod.installation) {
                        installation += parseFloat(prod.installation_price);
                        totalInstallAmount += parseFloat(prod.installation_price) * prod.quantity;
                    }
                }
                getPercent = parseFloat(this.formFields.percentage);
                overridePrice = parseFloat(overridePrice.toFixed(2));
                amount = parseFloat(amount.toFixed(2));
                let percentageVal = parseFloat(this.formFields.percentage);
                subTotal = this.$store.getters.calculatePercentage({'overridePrice': overridePrice, 'getPercent': percentageVal});
                subTotal = overridePrice + (subTotal);
                total = subTotal + totalInstallAmount;
                //total = subTotal + installation;
                cost = parseFloat(cost.toFixed(2));
                subTotal = parseFloat(subTotal.toFixed(2));
                installation = parseFloat(installation.toFixed(2));
                totalInstallAmount = parseFloat(totalInstallAmount.toFixed(2));
                total = parseFloat(total.toFixed(2));
                weight = parseFloat(weight.toFixed(2));
                return {cost: cost, subtotal: subTotal, installation: installation, total: total, overridePrice: overridePrice, weight: weight, amount: amount, totalInstallAmount: totalInstallAmount}
            },
            documents() {

                if (this.formFields.documents == undefined || Object.keys(this.formFields.documents).length == 0) {
                    this.formFields.documents = {image: null, files: []};
                }
                return this.formFields.documents;
            },
            products() {
                let prods = {productsByNumber: [], productsByTitle: []};

                if (Object.keys(this.$store.state[this.axiosParams.module].productList).length > 0) {
                    this.productsByNumber = this.$store.state[this.axiosParams.module].productList;
                    this.productsByTitle = this.$store.state[this.axiosParams.module].productList;
                }
                return prods;
            },
            isUpdatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Products', action: 'update'});
            },
            isCreatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Products', action: 'create'});
            },
            compositeSaleHistory: function () {
                let record = this.$store.state[this.axiosParams.module].currentSaleHistory
                if (record) {
                    if (Object.keys(record).indexOf('composite_inventory') > -1) {
                        record.composite_service_inventory.filter(obj => {
                            if (!record.sale_history.find(obj2 => obj2.id == obj.id)) {
                                record.sale_history.push(obj)
                            }
                        });
                    }
                    if (Object.keys(record).indexOf('composite_simple_inventory') > -1) {
                        record.composite_simple_inventory.filter(obj => {
                            if (!record.sale_history.find(obj2 => obj2.id == obj.id)) {
                                record.sale_history.push(obj)
                            }
                        });
                    }

                }
            },
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Products', action: 'read'}))
                this.$router.push('/access-denied');
        },
        mounted() {
            this.$store.state[this.axiosParams.module].busy = true
            // this.formFields.store_id = this.storeID
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            if (!this.$store.getters.isPermitted({resource: 'Products', action: 'create'}) && !this.$store.getters.isPermitted({resource: 'Products', action: 'update'}))
                this.$props.hideInModal = true;
            if (this.formFields.id > 0 && !this.$store.getters.isPermitted({resource: 'Products', action: 'update'}))
                this.hideinAuth = true;
            this.getComposite(this.formFields.id);
            this.getColumns();
            this.getRecords();
            this.$store.getters.detectFormChanges();
        },
        methods: {

            /** CRUD */
            getCompositeDropDown: function (id) {
                this.axiosParams.id = id;
                fetchRecord(this.axiosParams, (response) => {
                    console.log("getCompositeDropDown ", response.data)
                    let recordList = [];
                    recordList.push(response.data)
                    this.$store.getters.getInstallationPrice(recordList);
                    this.formFields = recordList[0];
                    this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                })
            },
            getComposite: function (id) {
                if (id) {
                    this.axiosParams.id = id;
                    fetchRecord(this.axiosParams, (response) => {
                        let recordList = [];
                        recordList.push(response.data)
                        this.$store.getters.getInstallationPrice(recordList);
                        this.formFields = recordList[0];
                        this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                        if (this.$store.state[this.axiosParams.module].recordList.length > 0 || this.hideInModal)
                            this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                }
                if (this.$store.state.composite.compositeInfo.length == 0) {
                    this.$store.dispatch('getCompositeInfo');
                }
                this.findProducts('byNumber')
                this.findProducts('byTitle')
            },
            storeComposite: function () {
                if(this.showToastAlert)
                    this.saveDisabled = true;
                if (typeof this.formFields.final_price == "object") {
                    this.formFields.final_price = this.formFields.final_price.total
                }
                let data = this.formFields;
                let formData = new FormData();
                formData.append('image_file', this.documents.image);
                formData.append('data', JSON.stringify(data));
                if (data.documents.files.length > 0) {
                    for (let file of data.documents.files) {
                        formData.append('doc_files[]', file);
                    }
                }
                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: this.alertMessage, variant: 'danger', duration: 5000});
                        this.alertMessage = '';
                    } else {
                        let status = this.formFields.id ? 'Updated' : 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                        if(this.showToastAlert)
                            this.makeToast({title: 'Composite ' + status, message: this.alertMessage, variant: 'success'});
                        this.$refs['inputFile'].reset();
                        let recordList = [];
                        recordList.push(response.data)
                        this.$store.getters.getInstallationPrice(recordList);
                        this.formFields = recordList[0];
                        this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                        this.alertMessage = '';
                        this.axiosParams.data =
                            {
                                id: this.formFields.id,
                                product_number: this.formFields.product_number
                            };
                        this.$store.commit('appendOrUpdateDropDown', this.axiosParams)
                        this.showToastAlert = true
                    }
                }, (error) => {
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            deleteRecord: function (id) {
                if (confirm("Do you really want to delete this record?")) {
                    this.axiosParams.id = id;
                    deleteRecord(this.axiosParams, (response) => {
                        if (response.data) {
                            this.$store.dispatch('removeRecordFromList', this.axiosParams);
                            if (this.$store.state[this.axiosParams.module].recordList.length == 0){
                                this.clearForm();
                            }else{
                                this.image = null;
                                this.$refs['inputFile'].reset();
                                this.first();
                            }
                        } else {
                            console.log(response.data);
                        }
                    }, (error) => {
                            this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                }
            },
            getColumns() {
                if (this.$store.state[this.axiosParams.module].columnList.length == 0) {
                    this.$store.dispatch('getColumnList', this.axiosParams);
                }
            },
            getRecords() {
                if (!this.hideInModal)
                    this.$store.dispatch('getDropDownInfo', {module: this.axiosParams.module, apiURL: 'dropDown', page: this.pageNumber})
            },
            setDetail(obj, detail) {
                this.formFields[detail + '_id'] = obj.value;
                this.formFields[detail] = obj.text;
            },
            deleteDropDown: function (id) {
                if (confirm('Do you really want to delete this record ?')) {
                    let moduleName = this.axiosParamsCategory.module;
                    deleteRecord({id: id, module: moduleName}, (response) => {
                        let list = this.$store.state[this.axiosParams.module]['compositeInfo'];
                        this.spliceRecord(list, id);
                    }, (error) => {
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                }
            },
            spliceRecord: function (list, id) {
                let record = list.find(obj => obj.id == id);
                let currentIndex = list.indexOf(record);
                list.splice(currentIndex, 1);
            },
            saveDetail: function (detail) {
                let data = {
                    id: 0,
                    // store_id: this.storeID
                };
                data[detail] = this.searchCategory
                let params = this.axiosParamsCategory;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                saveRecord(params, formData, (response) => {
                    if (response.data.errorInfo) {
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.errorResponse = true;
                        this.handleAlert();
                    } else {
                        this.$store.state[this.axiosParams.module]['compositeInfo'].splice(this.$store.state[this.axiosParams.module]['compositeInfo'].length + 1, 0, response.data)
                    }
                })
            },
            openPreviewNewPage: function (url) {
                window.open(url, '_blank');
            },
            handleDropdownChange: function(value){
                window.detectChanges = true;
            },

            /** Products*/
            findProducts: function (type = 'byNumber') {
                let keywords = type == 'byNumber' ? this.searchByNumber : this.searchByTitle;
                let formData = new FormData();
                formData.append('keywords', keywords);
                formData.append('type', type);
                searchCompositeProducts(formData, (response) => {
                    type == 'byNumber' ? this.productsByNumber = response.data : this.productsByTitle = response.data;
                });
            },
            addProduct: function (obj, type) {
                let exists = this.formFields.composite_products.includes(obj);
                let installationAmount = 0;
                let price = obj.override_selling_price ? obj.override_selling_price : 0;
                let productCost = obj.product_cost ? obj.product_cost : 0;
                let totalWeight = obj.total_weight ? obj.total_weight : 0;
                if (type == 'monument') {
                    price = obj.override_selling_price;
                    totalWeight = obj.total_weight ? obj.total_weight : 0;
                }
                if (type == 'simple') {
                    totalWeight = obj.weight ? obj.weight : 0;
                }
                if (type == 'service') {
                    totalWeight = obj.weight ? obj.weight : 0;
                }
                installationAmount = obj.installation ? obj.installation.installation_amount : 0;
                let onHand = obj.total_on_hand ? obj.total_on_hand : 0;
                let quantityStocked = obj.quantity_stocked ? obj.quantity_stocked : 0;
                if (!exists) {
                    let customObj = {
                        [type]: [{
                            id: obj.id, product_number: obj.product_number, item_name: obj.item_name, total_on_hand: onHand,
                            quantity_stocked: quantityStocked, weight: totalWeight, product_cost: productCost, override_selling_price: price,
                            price: price, installation: {installation_amount: installationAmount}
                        }],
                        id: 0, quantity: 1, price: productCost, price_override: price, installation_price: installationAmount, installation: 0
                    };
                    this.formFields.composite_products.push(customObj)
                }
            },
            removeProduct: function (index, id) {
                if (confirm("Do you really want to delete this product permanently?")){
                    this.formFields.composite_products.splice(index, 1);
                    if (id) {
                        deleteCompositeProduct(id, (response) => {
                            this.showToastAlert = false
                            console.log("Product Deleted " + response)
                            this.storeComposite()
                        }, (error) => {
                            this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                        })
                    }
                }
            },

            /** Pagination*/
            first: function () {
                if (this.$store.state[this.axiosParams.module].recordList.length) {
                    let firstIndex = this.$store.state[this.axiosParams.module].recordList[0]
                    if (firstIndex) {
                        this.axiosParams.id = firstIndex.id;
                        nextRecord(this.axiosParams, (response) => {
                            if (Object.keys(response.data).length > 0) {
                                let recordList = [];
                                recordList.push(response.data)
                                this.$store.getters.getInstallationPrice(recordList);
                                this.formFields = recordList[0];
                                this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                            }
                            this.$store.state[this.axiosParams.module].busy = false
                        }, (error) => {
                            this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                        })
                    }
                }
            },
            last: function () {
                if (this.$store.state[this.axiosParams.module].recordList.length) {
                    let lastIndex = this.$store.state[this.axiosParams.module].recordList.slice(-1)[0]
                    if (lastIndex) {
                        this.axiosParams.id = lastIndex.id;
                        nextRecord(this.axiosParams, (response) => {
                            if (Object.keys(response.data).length > 0) {
                                let recordList = [];
                                recordList.push(response.data)
                                this.$store.getters.getInstallationPrice(recordList);
                                this.formFields = recordList[0];
                                this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                            }
                            this.$store.state[this.axiosParams.module].busy = false
                        }, (error) => {
                            this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                        })
                    }
                }
            },
            next: function (id) {
                if (this.$store.state[this.axiosParams.module].recordList.length) {
                    let list = this.$store.state[this.axiosParams.module].recordList;
                    let nextIndex = list.findIndex(obj => obj.id == id);
                    nextIndex = list[nextIndex + 1].id
                    this.axiosParams.id = nextIndex;
                    nextRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            let recordList = [];
                            recordList.push(response.data)
                            this.$store.getters.getInstallationPrice(recordList);
                            this.formFields = recordList[0];
                            this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                        }
                        this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                }
            },
            prev: function (id) {
                if (this.$store.state[this.axiosParams.module].recordList.length) {
                    let list = this.$store.state[this.axiosParams.module].recordList;
                    let previousIndex = list.findIndex(obj => obj.id == id);
                    if (previousIndex > -1) {
                        previousIndex = list[previousIndex - 1].id
                        this.axiosParams.id = previousIndex;
                        nextRecord(this.axiosParams, (response) => {
                            if (Object.keys(response.data).length > 0) {
                                let recordList = [];
                                recordList.push(response.data)
                                this.$store.getters.getInstallationPrice(recordList);
                                this.formFields = recordList[0];
                                this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                            }
                            this.$store.state[this.axiosParams.module].busy = false
                        }, (error) => {
                            this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                        })
                    }
                }
            },

            /** Generic*/
            clearForm: function () {
                if (window.detectChanges && !confirm('You have unsaved changes. Are you sure you want to navigate away?')) {
                    this.$store.state[this.axiosParams.module].busy = false
                } else {
                    window.detectChanges = false;
                }
                if (!window.detectChanges) {
                    this.$refs['inputFile', 'inputFile1'].reset();
                    this.imageData = this.imageDefault;
                    this.$store.state[this.axiosParams.module].currentSaleHistory = []
                    this.formFields = {
                        // store_id: this.storeID,
                        id: 0,
                        composite_products: [],
                        category_id: null,
                        documents: {image: null, files: []}
                    };
                    this.showToastAlert = true
                }
            },
            handleAlert: function () {
                this.saveDisabled = false;
                this.hideAlert = false;
                setTimeout(() => {
                    this.alertMessage = "";
                    this.successResponse = false;
                    this.errorResponse = false;
                    this.hideAlert = true;
                }, 3000)
            },
            customizeLabel: function (str) {
                let i, labels = str.split('_');
                for (i = 0; i < labels.length; i++) {
                    labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
                }
                return labels.join(' ');
            },
            downloadFile: function (src) {
                let formData = new FormData();
                formData.append('module', this.axiosParams.module);
                formData.append('file', src);
                downloadFile(formData, (response) => {
                    console.log(response)
                }, (error) => {
                    this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                });
            },
            setCurrentRecord() {
                this.$store.state[this.axiosParams.module].currentRecord = this.formFields;
            },
            setImageModalData(src, title) {
                this.modalData.src = src;
                this.modalData.title = title;
            },
            deleteFile(id, index) {
                if (confirm("Do you really want to delete this file?")) {
                    this.axiosParams.id = id;
                    this.axiosParams.method = '/deleteFile/';
                    deleteProductFile(this.axiosParams, (response) => {
                        if (response.data) {
                            this.formFields.files.splice(index, 1);
                        }
                    }, (error) => {
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                }
            },
            downloadDocument(src, name) {
                let formData = new FormData();
                formData.append('module', this.axiosParams.module);
                formData.append('file', src);
                formData.append('name', name);
                downloadFile(formData, (response) => {
                    console.log(response)
                }, (error) => {
                    this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                });
            },
            previewImage: function (event) {
                let input = event.target;
                let FileSize = input.files[0].size / 1024 / 1024;
                if (FileSize > 2 || input.files[0].type.indexOf("image") == -1) {
                    this.makeToast({title: 'Error', message: 'Invalid image type or File size exceeds 2 MB', variant: 'danger', duration: 5000});
                    this.$refs['inputFile'].reset();
                    this.imageData = this.imageDefault;
                    return false;
                } else {
                    if (input.files && input.files[0]) {
                        let reader = new FileReader();
                        reader.onload = (e) => {
                            this.imageData = e.target.result;
                            this.formFields.documents.image = event.target.files[0];
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            },
            checkFile: function (event) {
                let input = event.target;
                console.log(input.files);
                for (let i = 0; i < input.files.length; i++) {
                    let FileSize = input.files[i].size / 1024 / 1024;
                    if (FileSize > 2 || (input.files[i].type != "application/vnd.ms-excel" && input.files[i].type != "text/plain" && input.files[i].type != "application/pdf" && input.files[i].type != "application/doc" && input.files[i].type != "application/vnd.openxmlformats-officedocument.wordprocessingml.document" && input.files[i].type != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")) {
                        this.makeToast({title: 'Error', message: 'Invalid file type or file size exceeds 2 MB', variant: 'danger', duration: 5000});
                        this.$refs['inputFile1'].reset();
                        return false;
                    }
                }
            },
            makeToast: function (params) {
                this.$bvToast.toast(params.message, {
                    id: 'cemetery-toast',
                    title: params.title,
                    variant: params.variant,
                    toaster: 'b-toaster-top-center',
                    autoHideDelay: params.duration ? params.duration : 2000,
                    noAutoHide: this.toastHider,
                    noCloseButton: true,
                })
                this.saveDisabled = false;
            },
        },
    }
</script>

<style scoped>
    .custom-margin {
        margin-top: -1.5rem;
        margin-left: -0.4rem;
        margin-bottom: -0.9rem;
    }

    .heading-of-row {
        padding-left: 1rem;
    }

    .general-information-row-1, .general-information-row-2, .general-information-row-3,
    .selling-price-row, .documents-row div {
        display: flex;
        margin: 0.5rem 0;
        padding-left: 1rem;
    }

    .general-information-row-1 div, .general-information-row-2 div, .general-information-row-3 div,
    .selling-price-row div, .documents-row div {
        display: flex;
    }

    .general-information-row-1 div label, .general-information-row-2 div label, .general-information-row-3 div label,
    .selling-price-row div label, .documents-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
    }

    .product-row {
        display: flex;
        padding: 0.5rem;
    }

    .product-row div {
        display: flex;
        margin: 0 10px;
    }

    .product-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
    }

    .product-row div input {
        border: 1px solid #dee2e6 !important;
        margin: auto;
    }

    input, textarea, select {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.75rem;
    }

    .input-xl {
        width: 20rem;
    }

    .input-lg {
        width: 12rem;
    }

    .input-md {
        width: 6rem;
    }

    .input-sm {
        width: 4rem;
    }

    .input-price {
        width: 10rem;
    }

    .input-category {
        width: 32.2rem;
    }

    .input-product {
        width: 320px;
    }

    .product-image {
        width: 8rem;
        height: 8rem;
    }

    .description-width {
        min-width: 28rem;
    }

    .border {
        border: 1px solid #c4c4c4 !important;
    }

    .custom-modal-margin {
        padding-top: 0.5rem;
        margin-right: -.9rem;
        padding-left: 0rem;
        padding-bottom: .2rem;
        background-color: #e9ecef;
    }

    .input-product-xl {
        width: 30rem;
    }

    .input-product-lg {
        width: 10rem;
    }

    .input-product-md {
        width: 6rem;
    }

    .input-product-sm {
        width: 4rem;
    }

    .product-image {
        width: 10rem;
        height: 8rem;
    }

    .product-color {
        color: #6C757D;
    }

    .dropdown-header {
        font-weight: bold;
    }

    .file-container > div {
        opacity: 0;
        transition: 1s;
    }

    .file-container:hover > div {
        opacity: 1;
    }
</style>
