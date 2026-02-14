<template>
    <div :class="hideInModal?' custom-modal-margin':''">
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Simple Product</h5>
            <div class="bg-toolbar my-2 p-1">
                <Toolbar :id="formFields.id" :saveDisabled="saveDisabled"></Toolbar>
            </div>
        </div>
        <div class="col-md-12 custom-margin pr-1 my-2" id="simple">
            <form class="div-shadow bg-white rounded" id="monument-form">
                <template v-if="isLoading">
                    <div class="text-center text-info my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>
                <template v-else>
                    <div class="product-row-1 ml-2">
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
                    <div class="product-row-1 pt-1">
                        <div>
                            <label class="mr-2">Product #</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="w-100 my-auto" name="product_number" size="sm" type="text" v-model="formFields.product_number"></b-form-input>
                        </div>
                        <div class="flex-grow-1 mx-2">
                            <label>Item Name</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="w-100 my-auto" name="item_name" size="sm" type="text" v-model="formFields.item_name"></b-form-input>
                        </div>
                        <div class="flex-grow-1 mx-2">
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
                    <div class="product-row-2">
                        <div>
                            <label class="mr-2">Category</label>
                            <b-dropdown :disabled="hideInModal" class="input-xl my-auto border rounded ml-0 cutsom-width-dropdown" no-caret size="sm" toggle-class=""
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
                        <div>
                            <label class="col-2 tex-center">Cost</label>
                            <Price :classes="hideInModal ? 'input-price-modal my-auto ml-3':'input-price my-auto'" :disable="hideInModal || hideinAuth" v-model="formFields.product_cost"></Price>
                        </div>
                        <div>
                            <label>Freight</label>
                            <vue-numeric :disabled="hideInModal || hideinAuth" class="input-md mt-1 form-control form-control-sm " currency=""
                                         separator="," v-bind:minus="false" v-bind:precision="2" v-model="formFields.freight"></vue-numeric>
                        </div>
                    </div>
                    <div class="product-row-6">
                        <div>
                            <label>Selling Formula</label>
                            <vue-numeric :disabled="hideInModal || hideinAuth" class="input-md mt-1 form-control form-control-sm " currency=""
                                         separator="," v-bind:minus="false" v-bind:precision="2" v-model="formFields.selling_formula"></vue-numeric>
                        </div>
                        <div>
                            <label :class="hideInModal?'label-modal-price ml-0':'my-auto ml-4'">Selling Price</label>
                            <Price :classes="hideInModal?'input-price-modal my-auto ml-3':'my-auto'" disable
                                   v-model="formFields.price = costCalculationFields.selling_price"></Price>
                        </div>
                        <div>
                            <label class="ml-4">Override Price</label>
                            <vue-numeric :disabled="hideInModal || hideinAuth" class="input-md mt-1 form-control form-control-sm " currency="$"
                                         separator="," v-bind:minus="false" v-bind:precision="2" v-model="formFields.override_selling_price"></vue-numeric>
                        </div>
                        <div>
                            <label class="ml-4">Misc. Notes</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-md-width" name="misc_note"
                                          size="sm" type="text" v-model="formFields.misc_note"
                            ></b-form-input>
                        </div>
                        <div>
                            <label class="ml-4">A</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" name="misc_note_a"
                                          size="sm" type="text" v-model="formFields.misc_note_a"
                            ></b-form-input>
                            <label class="ml-4">B</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" name="misc_note_b"
                                          size="sm" type="text" v-model="formFields.misc_note_b"
                            ></b-form-input>
                            <label class="ml-4">C</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" name="misc_note_c"
                                          size="sm" type="text" v-model="formFields.misc_note_c"
                            ></b-form-input>
                            <label class="ml-4">D</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" name="misc_note_d"
                                          size="sm" type="text" v-model="formFields.misc_note_d"
                            ></b-form-input>
                        </div>
                    </div>
                    <div class="product-row-6">
                        <div>
                            <label class="mr-4" title="Total Added - Total Sold" v-b-tooltip.hover>Total on Hand</label>
                            <label class="d-none">{{ formFields.total_on_hand = formFields.total_added - formFields.total_sold }}</label>
                            <b-form-input class="input-sm" disabled min="0"
                                          name="total_on_hand" size="sm" type="text"
                                          v-model="formFields.total_on_hand"></b-form-input>
                        </div>
                        <div>
                            <label>Total Sold</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" disabled min="0" name="total_sold"
                                          size="sm" type="text" v-model="formFields.total_sold"></b-form-input>
                        </div>
                        <div>
                            <label>Quantity Stocked</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" min="0" name="quantity_stocked"
                                          size="sm" type="text" v-model="formFields.quantity_stocked"></b-form-input>
                        </div>
                        <div>
                            <label class="ml-4">Quantity Backordered</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" min="0" name="quantity_backordered"
                                          size="sm" type="text" v-model="formFields.quantity_backordered"></b-form-input>
                        </div>
                        <div>
                            <label class="ml-4">Total Added</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" disabled min="0" name="total_added"
                                          size="sm" type="text" v-model="formFields.total_added"></b-form-input>
                        </div>
                        <div v-if="!hideInModal">
                            <button :disabled="saveDisabled" class="btn-info mx-4 custom-infobtn-toolbar custom-infobtn-text" type="button"
                                    v-b-modal.posted-product-inventory v-if="id ? isUpdatePermitted : isCreatePermitted">
                                {{'Add Quantity' }}<span class="spinner-grow spinner-grow-sm ml-1" v-if="saveDisabled"></span>
                            </button>
                        </div>
                    </div>
                    <div class="product-row-6">
                        <div class="div-width">
                            <label>Misc. Notes</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="w-100 my-auto ml-4" name="gi_misc_note"
                                          size="sm" type="text" v-model="formFields.gi_misc_note"
                            ></b-form-input>
                        </div>
                        <div>
                            <label class="ml-4">Indep</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm m-0" name="gi_misc_note_indep"
                                          size="sm" type="text" v-model="formFields.indep"
                            ></b-form-input>
                            <label class="ml-4">Buckner</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm m-0" name="gi_misc_note_clinton"
                                          size="sm" type="text" v-model="formFields.clinton"
                            ></b-form-input>
                            <label class="ml-4">Ex-Spring</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm m-0" name="gi_misc_note_ex_spring"
                                          size="sm" type="text" v-model="formFields.ex_spring"
                            ></b-form-input>
                            <label class="ml-4">PH</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm m-0" name="gi_misc_note_ph"
                                          size="sm" type="text" v-model="formFields.ph"
                            ></b-form-input>
                            <label class="ml-4">BS</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm m-0" name="gi_misc_note_bs"
                                          size="sm" type="text" v-model="formFields.bs"
                            ></b-form-input>
                        </div>
                    </div>
                    <div class="product-row-5">
                        <div>
                            <label class="mr-2">Stocking</label>
                            <b-form-select :disabled="hideInModal || hideinAuth"
                                           :options="stockList"
                                           class="input-lg custom-caret-form marginLeftStock"
                                           size="sm"
                                           v-model="formFields.stock_info">
                                <template #first>
                                    <b-form-select-option :value="null" disabled>Select option</b-form-select-option>
                                </template>
                            </b-form-select>
                        </div>
                        <div>
                            <label class="mr-2">Supplier</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="w-100 my-auto" name="product_number" size="sm" type="text" v-model="formFields.supplier"></b-form-input>
                        </div>
                    </div>
                    <div class="product-row-2">
                        <div>
                            <label class="mr-4">Type</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="simpleTypeMarginLeft" name="simple_type"
                                          size="sm" type="text" v-model="formFields.type"></b-form-input>
                        </div>
                        <div>
                            <label class="ml-4">Color</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="ml-1" name="simple_color"
                                          size="sm" type="text" v-model="formFields.color"></b-form-input>
                        </div>
                        <div>
                            <label class="ml-4">Shape</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="ml-1" name="simple_shape"
                                          size="sm" type="text" v-model="formFields.shape"></b-form-input>
                        </div>
                        <div>
                            <label class="ml-4">Weight</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="ml-1" min="0" name="simple_weight"
                                          size="sm" type="text" v-model="formFields.weight"></b-form-input>
                        </div>
                        <div>
                            <label class="ml-4">Tax Info</label>
                            <b-form-select :disabled="hideInModal || hideinAuth"
                                           :options="taxInfoList"
                                           class="custom-caret-form"
                                           size="sm"
                                           v-model="formFields.tax_info">
                                <template #first>
                                    <b-form-select-option :value="null" disabled>Select option</b-form-select-option>
                                </template>
                            </b-form-select>
                        </div>
                    </div>
                    <hr class="border my-2">
                    <div class="mt-4"></div>
                    <h6 class="heading-of-row my-1 custom-form-heading">Documents and Upload Details</h6>
                    <div class="documents-row ml-n2">
                        <div :class="hideInModal || hideinAuth ? 'invisible' : '' ">
                            <label class="my-2">Image:</label>
                            <div class="flex-column">
                                <b-form-file
                                    :disabled="hideInModal || hideinAuth"
                                    accept="image/*"
                                    browse-text="Choose File"
                                    class="border rounded custom-file-upload mt-0"
                                    drop-placeholder="Drop file here..."
                                    multiple
                                    placeholder="No Chosen File"
                                    plain
                                    ref="inputFile"
                                    v-model="uploadImages.files"
                                    v-on:change="previewImage"
                                ></b-form-file>
                                <label></label>
                            </div>
                        </div>
                        <div :class="hideInModal || hideinAuth ? 'invisible' : '' " class="ml-5">
                            <label class="my-2">Files: </label>
                            <div class="flex-column">
                                <b-form-file
                                    :disabled="hideInModal || hideinAuth"
                                    browse-text="Choose File"
                                    class="border rounded custom-file-upload mt-0"
                                    drop-placeholder="Drop file here..."
                                    id="monument-files"
                                    multiple
                                    placeholder="No Chosen File"
                                    plain
                                    ref="inputFile1"
                                    v-model="uploadDocuments.files"
                                    v-on:change="checkFile"
                                ></b-form-file>
                                <label class="mt-0">You can also upload multiple files.<br> <span class="small text-danger">Docxs *, excel *, ai *, svg *, fs *, eps * and PDFs formats are allowed</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="documents-row ml-n2">
                        <div class="col-md-3 ml-n2">
                            <div class="flex-wrap m-1">
                                <template v-if="this.formFields.images">
                                    <template v-for="(file,index) of this.formFields.images">
                                        <div class="flex-column border mx-1 mb-2 py-1 justify-content-center file-container">
                                            <template v-if="checkFileType(file.file)">
                                                <i :title="`${file.name}`" @click="openPreviewNewPage(imagePath+file.file)" style="cursor: pointer;"
                                                   class="fa fa-file fa-2x m-auto" v-b-tooltip.hover></i>
                                                <label class="" @click="openPreviewNewPage(imagePath+file.file)" style="cursor: pointer;">
                                                    {{file.file.length > 10 ? file.file.substr(0,10)+'...' : file.path}}</label>
                                            </template>
                                            <template v-else>
                                                <img :src="imagePath + file.file" :title="`${file.name}`" alt="product-file"
                                                     class="btn img-thumbnail product-images " height="51px" @click="openPreviewNewPage(imagePath+file.file)"
                                                     v-b-tooltip.hover width="89px">
                                            </template>
                                            <div class="btn m-auto" v-if="!hideInModal || hideinAuth">
                                                <a :download="file.name" :href="`${imagePath+file.file}`" style="margin-top: -2px !important;color: #000 !important;">
                                                    <i aria-hidden="true" class="fa fa-download mx-2"></i></a>
                                                <i @click="deleteImage(file.id,index)" aria-hidden="true" class="fa fa-trash-o mx-2"
                                                   style='color: red'></i>
                                            </div>
                                        </div>
                                    </template>
                                </template>
                            </div>
                        </div>
                        <div class="col-md-3 flex-wrap m-1">
                            <template v-if="this.formFields.files">
                                <template v-for="(file,index) of this.formFields.files">
                                    <div class="flex-column border mx-1 mb-2 py-1 justify-content-center file-container">
                                        <i :title="`${file.name}`" class="fa fa-file fa-2x m-auto" v-b-tooltip.hover
                                           @click="openPreviewNewPage(imagePath+file.file)" style="cursor: pointer;"></i>
                                        <label :title="`${file.name}`" v-b-tooltip.hover @click="openPreviewNewPage(imagePath+file.file)" style="cursor: pointer;">
                                            {{file.file.length > 10 ? file.file.substr(0,10)+'...' : file.path}}</label>
                                        <div class="btn m-auto" v-if="!hideInModal || hideinAuth">
                                            <a :download="file.name" :href="`${imagePath+file.file}`" style="margin-top: -2px !important;color: #000 !important;">
                                                <i aria-hidden="true" class="fa fa-download mx-2"></i></a>
                                            <i @click="deleteFile(file.id,index)" aria-hidden="true" class="fa fa-trash-o mx-2"
                                               style='color: red'></i>
                                        </div>
                                    </div>
                                </template>
                            </template>
                        </div>
                    </div>
                </template>
            </form>
        </div>
        <b-modal hide-footer hide-header hide-header-close id="posted-product-inventory">
            <InventoryHistory :formRecord="simpleInventory" :id="formFields.id" :inventoryName="'simple_inventory'" :module="this.axiosParams.module"></InventoryHistory>
        </b-modal>
        <SaleHistory :invoice="'simple_invoice'" :module="this.axiosParams.module" :recordID="formFields.id"></SaleHistory>
    </div>
</template>

<script>
    import Toolbar from "./Toolbar";
    import InventoryHistory from "../service/InventoryHistory";
    import SaleHistory from "../product-monument/SaleHistory";
    import Price from "../../Modules/Price";
    import VueNumeric from 'vue-numeric';
    import {event, eventBus} from "../../event-bus/event-bus";
    import {deleteProductFile, deleteRecord, fetchRecord, nextRecord, saveRecord} from "../../helpers/axios";

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
                    product_cost: 0,
                    price: 0,
                    selling_formula: 0,
                    override_selling_price: 0,
                    freight: 0,
                    description: null,
                    category_id: null,
                    tax_info: 'taxable',
                    stock_info: 'stock',
                    color: null,
                    weight: null,
                    type: null,
                    shape: null,
                    supplier: null,
                    uploadDocuments: {image: null, files: []},
                    uploadImages: {image: null, files: []}
                },
                taxInfoList: [{value: 'taxable', text: "Taxable"},
                    {value: 'taxexempt', text: "Tax Exempt"}],
                stockList: [{value: 'stock', text: 'Stock'},
                    {value: 'non-stock', text: 'Non-Stock'}],
                image: null,
                imagePath: '/images/simple/',
                imageDefault: '/images/default-image.jpg',
                imageData: '/images/default-image.jpg',
                axiosParams: {module: 'simple'},
                axiosParamsComposite: {module: 'composite'},
                axiosParamsCategory: {module: 'simpleCategory'},
                searchCategory: "",
                alertMessage: '',
                hideAlert: true,
                successResponse: false,
                errorResponse: false,
                saveDisabled: false,
                hideinAuth: false,
                qtySaleHistory: false,
            }
        },
        metaInfo() {
            return {
                title: `${this.formFields.id ? 'Edit' : 'Add'} Simple Product`,
            }
        },
        created() {
            eventBus.$on(event.SAVE_SIMPLE, this.storeSimple);
            eventBus.$on(event.FIRST_SIMPLE_RECORD, this.first);
            eventBus.$on(event.LAST_SIMPLE_RECORD, this.last);
            eventBus.$on(event.NEXT_SIMPLE_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_SIMPLE_RECORD, this.prev);
            eventBus.$on(event.GET_SIMPLE, this.getSimpleDropDown);
            eventBus.$on(event.ADD_SIMPLE, this.clearForm);
            eventBus.$on(event.DELETE_SIMPLE, this.deleteRecord);
            eventBus.$on(event.HIDE_INVENTORY_MODEL_CANCEL, this.hideInventoryModel);
            eventBus.$on(event.HIDE_INVENTORY_MODEL, this.addOrUpdateQtyInventory);
        },
        destroyed() {
            eventBus.$off(event.SAVE_SIMPLE, this.storeSimple);
            eventBus.$off(event.FIRST_SIMPLE_RECORD, this.first);
            eventBus.$off(event.LAST_SIMPLE_RECORD, this.last);
            eventBus.$off(event.NEXT_SIMPLE_RECORD, this.next);
            eventBus.$off(event.PREVIOUS_SIMPLE_RECORD, this.prev);
            eventBus.$off(event.GET_SIMPLE, this.getSimpleDropDown);
            eventBus.$off(event.ADD_SIMPLE, this.clearForm);
            eventBus.$off(event.DELETE_SIMPLE, this.deleteRecord);
            eventBus.$off(event.HIDE_INVENTORY_MODEL_CANCEL, this.hideInventoryModel);
            eventBus.$off(event.HIDE_INVENTORY_MODEL, this.addOrUpdateQtyInventory);
        },
        components: {
            Toolbar,
            InventoryHistory,
            SaleHistory,
            Price,
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
            costCalculationFields() {
                let fields = {
                    selling_price: 0
                };
                fields.selling_price = parseFloat(((+this.formFields.product_cost + +this.formFields.freight) * +this.formFields.selling_formula).toFixed(2));
                return fields;
            },
            overrideSellingPrice: {
                get() {
                    this.formFields.override_selling_price = +this.formFields.override_selling_price > 0 ? +this.formFields.override_selling_price : this.formFields.price;
                    return parseFloat(this.formFields.override_selling_price);
                },
                set(value) {
                    this.formFields.override_selling_price = +value > +this.formFields.override_selling_price ? value : value;
                }
            },
            categoryTitle() {
                let opt = "Select";
                if (this.$store.state[this.axiosParams.module].simpleInfo?.length > 0 && this.formFields.category_id != 0 && this.formFields.category_id != null) {
                    opt = this.$store.state[this.axiosParams.module].simpleInfo.filter(obj => obj.id == this.formFields.category_id);
                    opt = opt.length > 0 ? opt[0].title : "Select";
                }
                return opt
            },
            categories() {
                let options = [];
                if (this.$store.state[this.axiosParams.module].simpleInfo) {
                    this.$store.getters.sortByAlphaNumeric({'fieldName': 'title', 'recordList': this.$store.state[this.axiosParams.module].simpleInfo});
                    for (let opt of this.$store.state[this.axiosParams.module].simpleInfo) {
                        let obj = {value: opt.id, text: opt.title};
                        options.push(obj);
                    }
                    if (this.searchCategory != '') {
                        options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchCategory.toUpperCase()) > -1)
                    }
                }
                return options;
            },
            isUpdatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Products', action: 'update'});
            },
            isCreatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Products', action: 'create'});
            },
            simpleInventory() {
                if (!this.formFields.simple_inventory) this.formFields.simple_inventory = [];
                if (!this.hideInModal) {
                    if (this.formFields.simple_inventory?.length && this.formFields.id) {
                        this.$store.getters.getProductInventory({
                            data: this.formFields.simple_inventory,
                            module: this.axiosParams.module,
                            id: this.formFields.id,
                            childModule: 'simple_inventory'
                        });
                    }
                }
                return this.formFields.simple_inventory;
            },
            uploadDocuments() {

                if (this.formFields.uploadDocuments == undefined || Object.keys(this.formFields.uploadDocuments).length == 0) {
                    this.formFields.uploadDocuments = {image: null, files: []};
                }
                return this.formFields.uploadDocuments;
            },
            uploadImages() {

                if (this.formFields.uploadImages == undefined || Object.keys(this.formFields.uploadImages).length == 0) {
                    this.formFields.uploadImages = {image: null, files: []};
                }
                return this.formFields.uploadImages;
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
            this.getSimple(this.formFields.id);
            this.getColumns();
            this.getRecords();
            this.$store.getters.detectFormChanges();
        },
        watch: {
            'formFields.price'(newValue, oldValue) {
                if (this.formFields.id == 0) {
                    this.changeOverridePrice(newValue, oldValue);
                }
            },
            'formFields.override_selling_price'(newValue, oldValue) {
                if (this.formFields.id == 0) {
                    this.changeOverridePrice(newValue, oldValue);
                } else {
                    newValue = parseFloat(newValue);
                    this.overrideSellingPrice = newValue;
                }
            },
        },
        methods: {
            previewImage: function (event) {
                let input = event.target;
                let FileSize = input.files[0].size / 1024 / 1024;
                if (FileSize > 2 || input.files[0].type.indexOf("image") == -1) {
                    this.makeToast({title: 'Error', message: 'Invalid image type or File size exceeds 2 MB', variant: 'danger', duration: 3000});
                    this.$refs['inputFile'].reset();
                    this.imageData = this.imageDefault;
                    return false;
                } else {
                    if (input.files && input.files[0]) {
                        let reader = new FileReader();
                        reader.onload = (e) => {
                            this.imageData = e.target.result;
                            this.image = event.target.files[0];
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            },
            /** CRUD */
            getSimpleDropDown: function (id) {
                this.axiosParams.id = id;
                fetchRecord(this.axiosParams, (response) => {
                    this.formFields = response.data;
                    this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                })
            },
            getSimple: function (id) {
                if (id) {
                    this.axiosParams.id = id;
                    fetchRecord(this.axiosParams, (response) => {
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                        if (this.$store.state[this.axiosParams.module].recordList.length > 0 || this.hideInModal)
                            this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                }
                this.$store.dispatch('getSimpleInfo');
            },
            storeSimple: function () {
                this.saveDisabled = true;
                let data = this.formFields;
                let formData = new FormData();
                formData.append('image_file', this.image);
                formData.append('data', JSON.stringify(data));
                if (this.uploadImages.files.length > 0) {
                    for (let file of data.uploadImages.files) {
                        formData.append('doc_images[]', file);
                    }
                }
                formData.append('data', JSON.stringify(data));
                if (this.uploadDocuments.files.length > 0) {
                    for (let file of data.uploadDocuments.files) {
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
                        this.makeToast({title: 'Simple Product ' + status, message: this.alertMessage, variant: 'success'});
                        this.image = null;
                        this.$refs['inputFile'].reset();
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                        this.imageData = this.formFields.image ? this.imagePath + this.formFields.image : this.imageDefault;
                        this.alertMessage = '';
                        this.axiosParams.data =
                            {
                                id: this.formFields.id,
                                product_number: this.formFields.product_number
                            };
                        this.$store.commit('appendOrUpdateDropDown', this.axiosParams)
                    }
                }, (error) => {
                    this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                })
            },
            handleDropdownChange: function(value){
                window.detectChanges = true;
            },

            deleteRecord: function (id) {
                if (confirm("Do you really want to delete this record?")) {
                    this.axiosParams.id = id;
                    deleteRecord(this.axiosParams, (response) => {
                        if (response.data) {
                            this.$store.dispatch('removeRecordFromList', this.axiosParams);
                            if (this.$store.state[this.axiosParams.module].recordList.length == 0) {
                                this.clearForm();
                            } else {
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
                        let list = this.$store.state[this.axiosParams.module]['simpleInfo'];
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
                    // store_id: this.storeID,
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
                        this.$store.state[this.axiosParams.module]['simpleInfo'].splice(this.$store.state[this.axiosParams.module]['simpleInfo'].length + 1, 0, response.data)
                    }
                })
            },
            openPreviewNewPage: function (url) {
                window.open(url, '_blank');
            },

            /** Pagination*/
            first: function () {
                if (this.$store.state[this.axiosParams.module].recordList.length) {
                    let firstIndex = this.$store.state[this.axiosParams.module].recordList[0]
                    if (firstIndex) {
                        this.axiosParams.id = firstIndex.id;
                        nextRecord(this.axiosParams, (response) => {
                            if (Object.keys(response.data).length > 0) {
                                this.formFields = response.data;
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
                                this.formFields = response.data;
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
                            this.formFields = response.data;
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
                                this.formFields = response.data;
                                this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                            }
                            this.$store.state[this.axiosParams.module].busy = false
                        }, (error) => {
                            this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                        })
                    }
                }
            },
            changeOverridePrice: function (newValue, oldValue) {
                if (isNaN(newValue))
                    newValue = 0;
                this.formFields.override_selling_price = newValue;
            },

            /** Generic*/
            clearForm: function () {
                if (window.detectChanges && !confirm('You have unsaved changes. Are you sure you want to navigate away?')) {
                    this.$store.state[this.axiosParams.module].busy = false
                } else {
                    window.detectChanges = false;
                }
                if (!window.detectChanges) {
                    this.$refs['inputFile'].reset();
                    this.imageData = this.imageDefault;
                    this.$store.state[this.axiosParams.module].currentSaleHistory = []
                    this.formFields = {
                        id: 0, price: 0, product_cost: 0, override_selling_price: 0, tax_info: 'taxable',
                        // store_id: this.storeID,
                        stock_info: 'stock', weight: null, shape: null, color: null, type: null, category_id: null
                    };
                    this.image = null;
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
            setCurrentRecord() {
                this.$store.state[this.axiosParams.module].currentRecord = this.formFields;
            },
            makeToast(params) {
                this.$bvToast.toast(params.message, {
                    title: params.title,
                    variant: params.variant,
                    toaster: 'b-toaster-top-center',
                    autoHideDelay: 3000,
                    noCloseButton: true,
                })
                this.saveDisabled = false;
            },
            hideInventoryModel: function (qty) {
                this.formFields.qty_add_or_remove = qty;
                this.$bvModal.hide('posted-product-inventory');
            },
            addOrUpdateQtyInventory: function (qty) {
                this.formFields.qty_add_or_remove = qty;
                let date = this.$store.getters.getCurrentDate;
                let userName = this.$store.getters.getUserName;
                if (qty) {
                    this.formFields.simple_inventory.push({
                        id: 0, date: date, by_whom: userName, qty_add_or_remove: qty
                    });
                    this.simpleInventory;
                }
                this.$bvModal.hide('posted-product-inventory');
            },
            checkFile: function (event) {
                let input = event.target;
                for (let i = 0; i < input.files.length; i++) {
                    let FileSize = input.files[i].size / 1024 / 1024; // in MiB
                    if (FileSize > 20 || (input.files[i].type != "application/vnd.ms-excel"
                        && input.files[i].type != "text/plain" && input.files[i].type != "application/pdf" && input.files[i].type != "application/doc"
                        && input.files[i].type != "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                        && input.files[i].type != "application/postscript" && input.files[i].type != "image/svg+xml"
                        && input.files[i].name.substr(input.files[i].name.lastIndexOf('.') + 1) != 'fs'
                        && input.files[i].type != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")) {
                        this.makeToast({title: 'Error', message: 'Invalid file type or file size exceeds 20 MB', variant: 'danger'});
                        this.$refs['inputFile1'].reset();
                        return false;
                    }
                }
            },
            checkFileType: function (fileName) {
                let ext = fileName.substr(fileName.lastIndexOf('.') + 1);
                if (ext == 'fs') {
                    return true;
                }
                return false;
            },
            deleteImage(id, index) {
                if (confirm("Do you really want to delete this Image?")) {
                    this.axiosParams.id = id;
                    this.axiosParams.method = '/deleteImage/';
                    deleteProductFile(this.axiosParams, (response) => {
                        if (response.data) {
                            this.formFields.images.splice(index, 1);
                        } else {
                            console.log(response.data);
                        }
                    }, (error) => {
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    });
                }
            },
            deleteFile(id, index) {
                if (confirm("Do you really want to delete this file?")) {
                    this.axiosParams.id = id;
                    this.axiosParams.method = '/deleteFile/';
                    deleteProductFile(this.axiosParams, (response) => {
                        if (response.data) {
                            this.formFields.files.splice(index, 1);

                        } else {
                            console.log(response.data);
                        }
                    })
                }
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

    .product-row-1, .product-row-2, .product-row-5, .product-row-3, .product-row-4, .product-row-6 {
        display: flex;
        margin: 0.5rem 0;
        padding-left: 1rem;
    }

    .product-row-1 div, .product-row-2 div, .product-row-5 div, .product-row-3 div, .product-row-4 div, .product-row-6 div {
        display: flex;
    }

    .product-row-1 div label, .product-row-2 div label, .product-row-5 div label, .product-row-3 div label, .product-row-4 div label, .product-row-6 div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
    }

    input, textarea, select {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.75rem;
    }

    .label-price {
        width: 5.5rem;
    }

    .label-modal-price {
        width: 4.5rem;
    }

    .input-xl {
        width: 26rem;
    }

    .input-lg {
        width: 12rem;
    }

    .input-price {
        width: 10.2rem;
    }

    .input-price-modal {
        width: 2.5rem;
    }

    .input-md {
        width: 6rem;
    }

    .input-sm {
        width: 4rem;
    }

    .product-image {
        min-width: 13.5rem;
        max-width: 13.5rem;
    }

    .description-width {
        min-width: 30rem;
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

    .simpleTypeMarginLeft {
        margin-left: 0.7rem !important;
    }

    .marginLeftStock {
        margin-left: 0.5rem;
    }

    .input-md-width {
        width: 16rem;
    }

    .div-width {
        width: 32rem;
    }

    .documents-row {
        display: flex;
        margin: 0.5rem 0;
        padding-left: 1rem;
    }

    .documents-row div {
        display: flex;
    }

    .documents-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
    }

    .file-container {
        max-height: 7rem;
    }

    .file-container > div {
        opacity: 0;
        transition: 1s;
    }

    .file-container:hover > div {
        opacity: 1;
    }

    .product-images {
        width: 8rem;
        height: 4rem;
    }
</style>
