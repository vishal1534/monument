<template>
    <div>
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} PO Order</h5>
            <div class="bg-toolbar my-2 p-1">
                <Toolbar :id="formFields.id" :saveDisabled="saveDisabled"></Toolbar>
            </div>
        </div>
        <div>
            <div :class="hideInModal ? '' : 'm-0' " class="row ">
                <div class="col-md-12">
                    <form>
                        <template v-if="isLoading">
                            <div class="text-center text-info my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>
                        </template>
                        <template v-else>
                            <div class="div-shadow bg-white rounded p-2 mb-2">
                                <div class="po-row">
                                    <div>
                                        <label class="w-auto">PO No.</label>
                                        <b-form-input :disabled="true" class="input-xs " size="sm" type="text" v-model="formFields.id"></b-form-input>
                                    </div>
                                    <div>
                                        <label class="w-auto">PO Date</label>
                                        <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" :disabled="hideInModal || hideinAuth || hideInCloseDate " @input="formFields.po_date = checkDate(formFields.po_date)" class="form-control-sm border input-date" close-button locale="en"
                                                           placeholder=""
                                                           reset-button
                                                           size="sm"
                                                           today-button
                                                           v-model="formFields.po_date">
                                        </b-form-datepicker>

                                    </div>
                                    <div>
                                        <label class="w-auto">Supplier No</label>
                                        <b-dropdown :disabled="hideInModal || hideinAuth || hideInCloseDate" class="dropdown b-dropdown border rounded input-xs m-0 dropdown-width btn-group" no-caret
                                                    size="sm" style="width: 5rem; height: 27px;" toggle-class="" variant="none">
                                            <template #button-content>
                                                <div class="d-flex">
                                                    <small>{{supplier}}</small>
                                                    <small class="w-100 ml-auto custom-caret-agreement"></small>
                                                </div>
                                            </template>
                                            <b-dropdown-group class="overflow-auto scroll px-1">
                                                <b-form-input
                                                    @change="setNewSupplierNo(searchSupplier)"
                                                    class="mt-1"
                                                    placeholder="Search..."
                                                    size="sm"
                                                    v-model="searchSupplier"
                                                ></b-form-input>
                                                <template v-if="suppliers.length > 0">
                                                    <template v-for="(obj, key) of suppliers">
                                                        <b-dropdown-group @click="handleDropdownChange">
                                                            <b-dropdown-item-button :key="key" @click="setSupplier(obj)"
                                                                                    class="small">
                                                                <label class="btn btn-sm m-0 ml-n3">{{obj.text}}</label>
                                                            </b-dropdown-item-button>
                                                        </b-dropdown-group>
                                                    </template>
                                                </template>
                                                <template v-else>
                                                    <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                                    <button class="d-flex w-auto m-auto px-3 btn-sm btn-info custom-add-btn" type="button"
                                                            v-b-modal.purchase-order-modal>Add Supplier
                                                    </button>
                                                </template>
                                            </b-dropdown-group>
                                        </b-dropdown>
                                    </div>
                                    <div>
                                        <label class="w-auto">Supplier Name</label>
                                        <b-form-input :disabled="true" class="input-tax-group " size="sm" type="text" v-model="formFields.supplier.supplier_name"></b-form-input>
                                    </div>
                                    <div>
                                        <label class="w-auto">Order Placed On</label>
                                        <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" :disabled="hideInModal || hideinAuth || hideInCloseDate " @input="formFields.order_place_on = checkDate(formFields.order_place_on)" class="form-control-sm border input-date" close-button
                                                           locale="en"
                                                           placeholder=""
                                                           reset-button
                                                           size="sm"
                                                           today-button
                                                           v-model="formFields.order_place_on">
                                        </b-form-datepicker>
                                    </div>
                                    <div>
                                        <label class="w-auto">Shipping Date</label>
                                        <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" :disabled="hideInModal || hideinAuth || hideInCloseDate " @input="formFields.shipping_date = checkDate(formFields.shipping_date)" class="form-control-sm border input-date" close-button
                                                           locale="en"
                                                           placeholder=""
                                                           reset-button
                                                           size="sm"
                                                           today-button
                                                           v-model="formFields.shipping_date">
                                        </b-form-datepicker>
                                    </div>
                                    <div>
                                        <label class="w-auto">PO Closed On</label>
                                        <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" :disabled="hideInModal || hideinAuth || hideInCloseDate" @input="formFields.po_closed_on = checkDate(formFields.po_closed_on)" class="form-control-sm border input-date" close-button
                                                           locale="en"
                                                           placeholder=""
                                                           reset-button
                                                           size="sm"
                                                           today-button
                                                           v-model="formFields.po_closed_on">
                                        </b-form-datepicker>
                                    </div>
                                </div>
                                <hr class="border my-3">
                                <div class="po-row">
                                    <div>
                                        <label class="w-auto">Contact Person</label>
                                        <b-form-input :disabled="true" class="input-lg" size="sm" type="text" v-model="formFields.supplier.contact_person"></b-form-input>
                                    </div>
                                    <div>
                                        <label class="w-auto">Phone</label>
                                        <b-form-input :disabled="true" class="input-tax-group" size="sm" type="text" v-model="formFields.supplier.phone"></b-form-input>
                                    </div>
                                    <div>
                                        <label class="w-auto">Fax</label>
                                        <b-form-input :disabled="true" class="input-tax-group" size="sm" type="text" v-model="formFields.supplier.fax"></b-form-input>
                                    </div>
                                    <div>
                                        <label class="w-auto">Email</label>
                                        <b-form-input :disabled="true" class="input-lg" size="sm" type="text" v-model="formFields.supplier.email"></b-form-input>
                                    </div>

                                </div>
                                <div class="po-row">
                                    <div>
                                        <label class="mr-4">Notes:</label>
                                        <b-form-textarea
                                            :disabled="hideInModal || hideinAuth || hideInCloseDate"
                                            class="input-xl ml-n3 custom-po-textarea-width"
                                            name="description"
                                            no-resize
                                            rows="3"
                                            size="sm"
                                            v-model="formFields.notes"
                                        ></b-form-textarea>
                                    </div>
                                </div>
                                <hr class="border my-3">
                                <div class="po-row">
                                    <div class="bg-toolbar rounded px-3">
                                        <b-form-group class="mb-0 custom-radio-and-checkbox">
                                            <b-form-radio-group @change="updateSelectedItem" v-model="selectedItem">
                                                <label class="font-weight-bold mr-n4" style="font-size: 14px;">Show:</label>
                                                <b-form-radio value="true">MONUMENT item fields</b-form-radio>
                                                <b-form-radio value="false">REGULAR item fields</b-form-radio>
                                            </b-form-radio-group>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="my-table bootstrap-vue-table a ">
                                    <b-table :fields="purchaseOrderTableFields" :items="formFields.po_products" bordered class="" hover responsive
                                             small
                                             striped>
                                        <template #head()="data">
                                            <span class="custom-form-heading ml-2">{{ data.label }}</span>
                                        </template>
                                        <template v-slot:cell(product_number)="row">

                                            <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                                <b-form-input :disabled="hideInModal || hideinAuth || hideInCloseDate" class="input-md" name="product_number"
                                                              size="sm" type="text"
                                                              v-model="row.item.non_stock_product[0].product_number"></b-form-input>
                                            </template>

                                            <template v-if="row.item.monument && row.item.monument.length > 0">
                                                <label>{{row.item.monument[0].product_number}}</label>
                                            </template>

                                            <template v-if="row.item.service && row.item.service.length > 0">
                                                <label>{{row.item.service[0].product_number}}</label>
                                            </template>

                                            <template v-if="row.item.simple && row.item.simple.length > 0">
                                                <label>{{row.item.simple[0].product_number}}</label>
                                            </template>

                                            <template v-if="row.item.composite && row.item.composite.length > 0">
                                                <label>{{row.item.composite[0].product_number}}</label>
                                            </template>
                                        </template>
                                        <template v-slot:cell(item_name)="row">
                                            <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                                <b-form-input :disabled="hideInModal || hideinAuth || hideInCloseDate" class="input-md" name="item_name" size="sm"
                                                              type="text"
                                                              v-model="row.item.non_stock_product[0].item_name"></b-form-input>
                                            </template>

                                            <template v-if="row.item.monument && row.item.monument.length > 0">
                                                <label>{{row.item.monument[0].item_name}}</label>
                                            </template>

                                            <template v-if="row.item.service && row.item.service.length > 0">
                                                <label>{{row.item.service[0].item_name}}</label>
                                            </template>

                                            <template v-if="row.item.simple && row.item.simple.length > 0">
                                                <label>{{row.item.simple[0].item_name}}</label>
                                            </template>

                                            <template v-if="row.item.composite && row.item.composite.length > 0">
                                                <label>{{row.item.composite[0].item_name}}</label>
                                            </template>
                                        </template>
                                        <template v-slot:cell(item_type)="row">
                                            <template v-if="row.item.monument && row.item.monument.length > 0">
                                                <label>{{(row.item.monument[0].type_title != null ? row.item.monument[0].type_title : '' ) || (row.item.monument[0].type != null ? row.item.monument[0].type.type_title : '' )}}</label>
                                            </template>
                                        </template>
                                        <template v-slot:cell(color)="row">
                                            <template v-if="row.item.monument && row.item.monument.length > 0">
                                                <label>{{(row.item.monument[0].color_title != null ? row.item.monument[0].color_title : '' ) || (row.item.monument[0].color != null ? row.item.monument[0].color.color_title : '' ) }}</label>
                                            </template>

                                        </template>
                                        <template v-slot:cell(shapes)="row">
                                            <template v-if="row.item.monument && row.item.monument.length > 0">
                                                <label>{{(row.item.monument[0].shape_title != null ? row.item.monument[0].shape_title : '' ) || (row.item.monument[0].shape != null ? row.item.monument[0].shape.shape_title : '' ) }}</label>
                                            </template>

                                        </template>
                                        <template v-slot:cell(polish)="row">
                                            <template v-if="row.item.monument && row.item.monument.length > 0">
                                                <label>{{(row.item.monument[0].polish_type != null ? row.item.monument[0].polish_type : '' ) || (row.item.monument[0].polish != null ? row.item.monument[0].polish.polish_type : '' ) }}</label>
                                            </template>

                                        </template>
                                        <template v-slot:cell(side)="row">
                                            <template v-if="row.item.monument && row.item.monument.length > 0">
                                                <label>{{(row.item.monument[0].side_title != null ? row.item.monument[0].side_title : '' ) || (row.item.monument[0].side != null ? row.item.monument[0].side.side_title : '' ) }}</label>
                                            </template>
                                        </template>
                                        <template v-slot:cell(cost)="row">
                                            <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                                <Price :classes="'input-md'" :disable="hideInModal || hideinAuth || hideInCloseDate" v-model="row.item.cost"></Price>
                                            </template>
                                            <template v-if="row.item.monument && row.item.monument.length > 0">
                                                <label>$ {{row.item.cost}}</label>
                                            </template>
                                            <template v-if="row.item.service && row.item.service.length > 0">
                                                <label>$
                                                    {{row.item.cost}}</label>
                                            </template>
                                            <template v-if="row.item.simple && row.item.simple.length > 0">
                                                <label>$
                                                    {{row.item.cost}}</label>
                                            </template>
                                            <template v-if="row.item.composite && row.item.composite.length > 0">
                                                <label>$
                                                    {{row.item.cost}}</label>
                                            </template>
                                        </template>
                                        <template v-slot:cell(quantity)="row">
                                            <b-form-input :disabled="hideInModal || hideinAuth || hideInCloseDate" class="input-sm" min="0" name="quantity"
                                                          size="sm" type="number" v-model="row.item.quantity"></b-form-input>
                                        </template>
                                        <template v-slot:cell(notes)="row">
                                            <b-form-input :disabled="hideInModal || hideinAuth || hideInCloseDate" class="" min="0" name="notes"
                                                          size="sm" type="text" v-model="row.item.notes"></b-form-input>
                                        </template>
                                        <template v-slot:cell(amount)="row">
                                            <label>$ {{ row.item.amount = Math.abs((row.item.quantity* (row.item.cost) )).toFixed(2) }}</label>
                                        </template>
                                        <template v-slot:cell(unit_weight)="row">
                                            <label class="">{{ row.item.unit_weight }}</label>
                                        </template>
                                        <template v-slot:cell(total_weight)="row">
                                            <label>{{ row.item.total_weight =
                                                Math.abs((row.item.quantity* (row.item.unit_weight ? row.item.unit_weight : 0 ) )).toFixed(2) }}</label>
                                            <input :disabled="hideInModal || hideinAuth || hideInCloseDate" :value="row.item.total_weight" name="amount" type="hidden">
                                        </template>
                                        <template v-slot:cell(posted)="row">
                                            <template v-if="row.item.monument && row.item.monument.length > 0">
                                                <input :disabled="hideInModal || hideinAuth || hideInCloseDate ||  row.item.posted" :value="row.item.posted " @click="showPoMonumentProduct(row,row.item.monument[0].product_number, row.item.monument[0].id,row.item.monument[0].item_name)" class="input-xs mt-3 " size="sm" type="checkbox" v-b-modal.posted-product-inventory v-if="!row.item.posted" v-model="row.item.posted">
                                                <input :disabled="hideInModal || hideinAuth || hideInCloseDate || row.item.posted" :value="row.item.posted" class="input-xs mt-3" name="posted2" size="sm" type="checkbox" v-else v-model="row.item.posted">
                                            </template>
                                        </template>
                                        <template #cell(action)="data">
                                            <a :disabled="hideInModal || hideinAuth || hideInCloseDate" @click="removeProduct(data.index, data.item.id,data)" class="btn btn-sm btn-danger mx-1 py-1"
                                               href="javascript:void(0)">
                                                <i aria-hidden="true" class="fa fa-trash-o"></i>
                                            </a>
                                        </template>
                                        <template v-slot:cell(showProducts)="row">
                                            <b-button
                                                :disabled="hideInModal || hideinAuth || hideInCloseDate"
                                                @click="row.toggleDetails"
                                                class="btn btn-sm btn-info order-form-btn py-1 mx-1 "
                                                size="sm"
                                                v-if="row.item.iscompositeDetails">
                                                {{ row.detailsShowing ? 'Hide' : 'Show'}}
                                            </b-button>
                                        </template>

                                    </b-table>
                                </div>
                                <div class="po-row">
                                    <div>
                                        <label class="input-lg font-weight-bold" style="font-size:14px;">Products</label>
                                        <b-dropdown :disabled="hideInModal || hideinAuth || hideInCloseDate" class="dropdown b-dropdown border rounded input-xs m-0 dropdown-width btn-group" no-caret
                                                    size="sm" style="width: 18rem; height: 30px;" toggle-class="" variant="none">
                                            <template #button-content>
                                                <div class="d-flex">
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
                                                <template v-for="(objects, key) of productsByNumber">
                                                    <b-dropdown-group :header="customizeLabel(key)" class="text-left">
                                                        <template v-if="typeof objects === 'object'">
                                                            <b-dropdown-item-button :key="key + index"
                                                                                    @click="addProduct(obj,key)" class="small text-wrap"
                                                                                    v-for="(obj, index) of objects">
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
                                    <div class="custom-dropdown-margin">
                                        <b-dropdown :disabled="hideInModal || hideinAuth || hideInCloseDate" class="dropdown b-dropdown border rounded input-xs m-0 dropdown-width btn-group" no-caret
                                                    size="sm" style="width: 18rem; height: 30px;" toggle-class="" variant="none">
                                            <template #button-content>
                                                <div class="d-flex">
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
                                                <template v-for="(objects, key) of productsByTitle">
                                                    <b-dropdown-group :header="customizeLabel(key)" class="text-left">
                                                        <template v-if="typeof objects === 'object'">
                                                            <b-dropdown-item-button :key="key + index"
                                                                                    @click="addProduct(obj,key)" class="small text-wrap"
                                                                                    v-for="(obj, index) of objects">
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
                                    <div v-if="!hideInModal">
                                        <button :disabled="saveDisabled || hideInModal || hideinAuth || hideInCloseDate" @click="addNonStockingProduct" class="btn-info custom-infobtn-toolbar custom-infobtn-text" type="button">
                                            Add New
                                        </button>
                                    </div>
                                </div>
                                <div class="po-row">
                                    <div class="custom-row justify-content-end col-md-12 ml-n3">
                                        <div class="flex-column">
                                            <label class="">Total PO Amount</label>
                                            <input name="foo" type="hidden" v-model="formFields.total_po_amount = getTotal[0]">
                                            <div class="input-sm  form-control form-control-sm custom-totalAmount"> $ {{formFields.total_po_amount}}</div>
                                        </div>
                                        <div class="flex-column ml-4">
                                            <label class="">Total Weight</label>
                                            <b-form-input :disabled="true" class="input-sm " size="sm" type="text" v-model="formFields.po_total_weight = getTotal[1]"></b-form-input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </form>
                    <b-modal hide-footer hide-header hide-header-close id="posted-product-inventory">
                        <p class="my-4">Do you want to post Product # {{monumentProductInventory.poMonumentNumber}} ({{monumentProductInventory.poMonumentName}}) to the inventory now?</p>
                        <div class="d-flex justify-content-center">
                            <button :disabled="saveDisabled" @click="updateMonumentInventory(monumentProductInventory)" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" type="button">
                                OK<span class="spinner-grow spinner-grow-sm ml-1" v-if="saveDisabled"></span>
                            </button>
                            <button :disabled="saveDisabled" @click="unCheckBox()" class="btn btn-sm btn-warning mx-3 px-4 custom-dangerbtn-toolbar custom-dangerbtn-text" type="button">
                                Cancel<span class="spinner-grow spinner-grow-sm ml-1" v-if="saveDisabled"></span>
                            </button>
                        </div>
                    </b-modal>
                    <b-modal hide-footer hide-header hide-header-close id="posted-inventory-updated" size="sm">
                        <p>Successfully added to inventory!</p>
                        <div class="d-flex justify-content-center">
                            <button :disabled="saveDisabled" @click="closeSuccesModal()" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" type="button">
                                OK<span class="spinner-grow spinner-grow-sm ml-1" v-if="saveDisabled"></span>
                            </button>
                        </div>
                    </b-modal>
                    <b-modal id="purchase-order-modal"
                             scrollable
                             size="lg"
                             v-if="!hideInModal">
                        <template #modal-footer="{ ok, cancel, hide }">
                            <b-button @click="addSupplierDetail(addSupplier)" size="sm" variant="primary">Add Supplier
                            </b-button>
                        </template>
                        <div class="installation-row d-block">
                            <h5 class="text-center" style="color: #000!important;">Supplier</h5>
                            <div class="d-flex">
                                <div class="col-6">
                                    <label class="">Supplier Name:</label>
                                    <b-form-input size="sm" type="text" v-model="addSupplier.supplier_name"></b-form-input>
                                </div>
                                <div class="col-6">
                                    <label class="">Contact Person:</label>
                                    <b-form-input size="sm" type="text" v-model="addSupplier.contact_person"></b-form-input>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="col-6">
                                    <label class="">Phone:</label>
                                    <b-form-input size="sm" type="text" v-model="addSupplier.phone"></b-form-input>
                                </div>
                                <div class="col-6">
                                    <label class="">Email:</label>
                                    <b-form-input size="sm" type="email" v-model="addSupplier.email"></b-form-input>
                                </div>
                            </div>
                            <div>
                                <div class="col-6">
                                    <label class="">Fax:</label>
                                    <b-form-input size="sm" type="text" v-model="addSupplier.fax"></b-form-input>
                                </div>
                            </div>
                        </div>
                    </b-modal>
                </div>
            </div>
            <PDF :title="'printPurchaseOrder'" class="px-0">
                <div class="d-flex" slot="header">
                    <div class="align-self-center ml-3 mr-5">
                        <img class=" ml-4 w-100 height-150" src="/images/monument-logo.png">
                        <h6 class="text-center">816-833-5111</h6>
                    </div>
                    <div class="d-flex justify-content-center mt-4 ml-5">
                        <h2 class="font-weight-bold ml-5">REGULAR PURCHASE ORDER FORM</h2>
                    </div>
                </div>
                <div class="pdf" slot="body">
                    <div class="row">
                        <div class="col-9">
                        </div>
                        <div class="col-3">
                            <label class="w-auto">PO Number:</label>
                            <b>{{formFields.id}}</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-9">
                        </div>
                        <div class="col-3 mt-n2">
                            <label class="w-auto ml-5">Date:</label>
                            <b>{{ changeDateFormat(formFields.po_date) }}</b>
                        </div>
                    </div>
                    <div class="row m-0 pl-3 mt-n4">
                        <div class="col-md-6 border-3 p-2">
                            <div><label><b>Supplier No: {{formFields.supplier.supplier_no}}</b> </label></div>
                            <div><label><b>Supplier Name: {{formFields.supplier.supplier_name}}</b></label></div>
                            <div><label><b>Telephone: {{formFields.supplier.phone}}</b></label></div>
                            <div><label><b>Fax: {{formFields.supplier.fax}}</b></label></div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row my-4 mx-0">
                        <div class="col-md-12">
                            <b-table :fields="pdfTableFields" :items="formFields.po_products" bordered class="printable-truckload-table-border"
                                     foot-clone
                                     responsive
                                     small>
                                <template v-slot:cell(product_number)="row">
                                    <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                        <label class="">{{row.item.non_stock_product[0].product_number}}</label>
                                    </template>
                                    <template v-if="row.item.monument && row.item.monument.length > 0">
                                        <label class="">{{row.item.monument[0].product_number}}</label>
                                    </template>
                                    <template v-if="row.item.service && row.item.service.length > 0">
                                        <label class="">{{row.item.service[0].product_number}}</label>
                                    </template>
                                    <template v-if="row.item.simple && row.item.simple.length > 0">
                                        <label class="d-flex justify-content-center product-table">{{row.item.simple[0].product_number}}</label>
                                    </template>
                                    <template v-if="row.item.composite && row.item.composite.length > 0">
                                        <label class="">{{row.item.composite[0].product_number}}</label>
                                    </template>
                                </template>
                                <template v-slot:cell(item_name)="row">
                                    <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                        <label class="">{{row.item.non_stock_product[0].item_name}}</label>
                                    </template>
                                    <template v-if="row.item.monument && row.item.monument.length > 0">
                                        <label class="">{{row.item.monument[0].item_name}}</label>
                                    </template>
                                    <template v-if="row.item.service && row.item.service.length > 0">
                                        <label class="">{{row.item.service[0].item_name}}</label>
                                    </template>
                                    <template v-if="row.item.simple && row.item.simple.length > 0">
                                        <label class="">{{row.item.simple[0].item_name}}</label>
                                    </template>
                                    <template v-if="row.item.composite && row.item.composite.length > 0">
                                        <label class="d-flex justify-content-center product-table">{{row.item.composite[0].item_name}}</label>
                                    </template>
                                </template>
                                <template v-slot:cell(item_type)="row">
                                    <template v-if="row.item.monument && row.item.monument.length > 0">
                                        <label>{{(row.item.monument[0].type_title != null ? row.item.monument[0].type_title : '' ) || (row.item.monument[0].type != null ? row.item.monument[0].type.type_title : '' )}}</label>
                                    </template>
                                </template>
                                <template v-slot:cell(cost)="row">
                                    <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                        {{row.item.cost}}
                                    </template>
                                    <template v-if="row.item.monument && row.item.monument.length > 0">
                                        {{row.item.cost}}
                                    </template>
                                    <template v-if="row.item.service && row.item.service.length > 0">
                                        {{row.item.cost}}
                                    </template>
                                    <template v-if="row.item.simple && row.item.simple.length > 0">
                                        {{row.item.cost}}
                                    </template>
                                    <template v-if="row.item.composite && row.item.composite.length > 0">
                                        {{row.item.cost}}
                                    </template>
                                </template>
                                <template v-slot:cell(quantity)="row">
                                    <label class="">{{row.item.quantity}}</label>
                                </template>
                                <template v-slot:cell(amount)="row">
                                    {{ row.item.amount = Math.abs((row.item.quantity* (row.item.cost) )).toFixed(2) }}
                                </template>
                                <template v-slot:cell(unit_weight)="row">
                                    <label class="">{{ row.item.unit_weight }}</label>
                                </template>
                                <template v-slot:cell(total_weight)="row">
                                    {{ row.item.total_weight =
                                    Math.abs((row.item.quantity* (row.item.unit_weight ? row.item.unit_weight : 0 ) )).toFixed(2) }}
                                    <input :disabled="true" :value="row.item.total_weight" name="amount" type="hidden">
                                </template>
                                <template v-slot:cell(notes)="row">
                                    {{row.item.notes}}
                                </template>
                                <template #foot()="data">
                                    <span class="custom-table-heading"></span>
                                </template>
                                <template #foot(quantity)="data">
                                    <label>Total :</label>
                                </template>
                                <template #foot(amount)="data">
                                    <label>${{ getTotal[0] }}</label>
                                </template>
                                <template #foot(total_weight)="data">
                                    <label>{{ getTotal[1] }}</label>
                                </template>
                            </b-table>
                        </div>
                    </div>
                </div>
                <div slot="footer"></div>
            </PDF>
        </div>
    </div>
</template>

<script>
    import Toolbar from "./Toolbar";
    import Price from "../../../Modules/Price";
    import {event, eventBus} from '../../../event-bus/event-bus';
    import PDF from '../../../Modules/PDF-Modal';
    import {deleteProduct, deleteRecord, fetchRecord, firstRecord, lastRecord, nextRecord, previousRecord, saveRecord, searchPoProducts, updateMonumentInventory} from "../../../helpers/axios";
    import {searchForEmptyDate} from "../../../helpers/common";

    export default {
        name: "Add",
        props: {
            id: {
                type: Number,
                default: null
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
                    order_place_on: this.getCurrentWeek().date,
                    po_closed_on: null,
                    po_date: this.getCurrentWeek().date,
                    supplier_id: null,
                    shipping_date: null,
                    notes: null,
                    total_po_amount: null,
                    po_products: [],
                    supplier: {
                        supplier_name: null,
                    },
                },
                addSupplier: {
                    id: 0,
                    supplier_no: null,
                    supplier_name: null,
                    contact_person: null,
                    phone: null,
                    email: null,
                    fax: null
                },
                monumentProductInventory: {
                    poMonumentId: 0,
                    poMonumentName: null,
                    poMonumentNumber: null,
                    selectedRowIndex: null,
                    poMonumentQuantity: null
                },
                axiosParams: {module: 'PoOrder'},
                supplierAxiosParams: {module: 'supplier'},
                userFamilyStatus: {
                    familyId: null,
                },
                alertMessage: '',
                checkUncheckBox: false,
                hideInInventoryUpdated: false,
                hideAlert: true,
                successResponse: false,
                errorResponse: false,
                saveDisabled: false,
                hideinAuth: false,
                hideInCloseDate: false,
                selectedItem: "true",
                purchaseOrderTableFields: [
                    {key: 'product_number', label: "Product #"},
                    {key: 'item_name', label: "Product Name"},
                    {key: 'item_type', label: "Item Type", isMonumentSelected: true},
                    {key: 'color', label: "Color", isMonumentSelected: true},
                    {key: 'shapes', label: "Shapes", isMonumentSelected: true},
                    {key: 'polish', label: "Polish", isMonumentSelected: true},
                    {key: 'side', label: "Side", isMonumentSelected: true},
                    {key: 'quantity', label: "Quantity"},
                    {key: "cost", label: "Cost"},
                    {key: "amount", label: "Amount"},
                    {key: "unit_weight", label: "Unit Weight", isMonumentSelected: true},
                    {key: "total_weight", label: "Total Weight", isMonumentSelected: true},
                    {key: "notes", label: "Notes"},
                    {key: "posted", label: "Posted", isMonumentSelected: true},
                    {
                        key: 'action',
                        label: "Action",
                        thClass: this.$props.hideInModal ? 'd-none' : '',
                        tdClass: this.$props.hideInModal ? 'd-none' : ''
                    },
                ],
                pdfTableFields: [
                    {key: 'product_number', label: "Product #", thClass: 'text-center small font-weight-bold'},
                    {key: 'item_name', label: "Product Name", thClass: 'text-center small font-weight-bold'},
                    {key: 'item_type', label: "Item Type", thClass: 'text-center small font-weight-bold'},
                    {key: 'cost', label: "Cost", thClass: 'text-center small font-weight-bold'},
                    {key: 'quantity', label: "Quantity", thClass: 'text-center small font-weight-bold'},
                    {key: 'amount', label: "Amount", thClass: 'text-center small font-weight-bold'},
                    {key: 'unit_weight', label: "Unit Weight", thClass: 'text-center small font-weight-bold'},
                    {key: 'total_weight', label: "Total Weight", thClass: 'text-center small font-weight-bold'},
                    {key: 'notes', label: "Notes", thClass: 'text-center small font-weight-bold'},
                ],
                productsByNumber: {},
                productsByTitle: {},
                searchByNumber: "",
                searchByTitle: "",
                searchSupplier: "",
            }
        },
        metaInfo() {
            return {
                title: `${this.formFields.id ? 'Edit' : 'Add'} Purchase Order`,
            }
        },
        created() {
            eventBus.$on(event.SAVE_PURCHASE_ORDER, this.storePO);
            eventBus.$on(event.FIRST_PURCHASE_ORDER_RECORD, this.first);
            eventBus.$on(event.LAST_PURCHASE_ORDER_RECORD, this.last);
            eventBus.$on(event.NEXT_PURCHASE_ORDER_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_PURCHASE_ORDER_RECORD, this.prev);
            eventBus.$on(event.GET_PURCHASE_ORDER, this.getPoOrderFromDropDown);
            eventBus.$on(event.ADD_PURCHASE_ORDER, this.clearForm);
            eventBus.$on(event.DELETE_PURCHASE_ORDER, this.deleteRecord);
        },
        destroyed() {
            eventBus.$off(event.SAVE_PURCHASE_ORDER, this.storePO);
            eventBus.$off(event.FIRST_PURCHASE_ORDER_RECORD, this.first);
            eventBus.$off(event.LAST_PURCHASE_ORDER_RECORD, this.last);
            eventBus.$off(event.NEXT_PURCHASE_ORDER_RECORD, this.next);
            eventBus.$off(event.PREVIOUS_PURCHASE_ORDER_RECORD, this.prev);
            eventBus.$off(event.GET_PURCHASE_ORDER, this.getPO);
            eventBus.$off(event.ADD_PURCHASE_ORDER, this.clearForm);
            eventBus.$off(event.DELETE_PURCHASE_ORDER, this.deleteRecord);
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
            products() {
                let prods = {productsByNumber: [], productsByTitle: []};

                if (Object.keys(this.$store.state[this.axiosParams.module].productList).length > 0) {
                    this.productsByNumber = this.$store.state[this.axiosParams.module].productList;
                    this.productsByTitle = this.$store.state[this.axiosParams.module].productList;
                }
                return prods;
            },
            suppliers: function () {
                this.$store.getters.sortByAlphaNumeric({'fieldName': 'supplier_no', 'recordList': this.$store.state.supplier.supplierInfo});
                let options = [];
                for (let opt of this.$store.state.supplier.supplierInfo) {
                    let obj = {value: opt.id, text: opt.supplier_no, options: opt};
                    options.push(obj);
                }
                if (typeof this.searchSupplier == 'number')
                    this.searchSupplier = this.searchSupplier.toString();
                if (this.searchSupplier != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchSupplier.toUpperCase()) > -1)
                }

                return options;
            },
            supplier() {
                let opt = "Select";
                if (this.$store.state.supplier.supplierInfo.length > 0 && this.formFields.supplier_id != 0 && this.formFields.supplier_id != null) {
                    opt = this.$store.state.supplier.supplierInfo.filter(obj => obj.id == this.formFields.supplier_id);
                    opt = opt.length > 0 ? opt[0].supplier_no : "Select";
                }
                return opt
            },
            getTotal() {
                let totalAmount = 0;
                let totalWeight = 0;
                for (let prod of this.formFields.po_products) {
                    totalAmount += parseFloat(prod.amount);
                    if (prod.total_weight)
                        totalWeight += parseFloat(prod.total_weight);
                }
                return [parseFloat(totalAmount.toFixed(2)), parseFloat(totalWeight.toFixed(2))];
            },
        },
        components: {
            Toolbar,
            Price,
            PDF,
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Purchasing', action: 'read'}))
                this.$router.push('/access-denied');
        },
        mounted() {
            // this.formFields.store_id = this.storeID
            this.$store.state[this.axiosParams.module].busy = true
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            if (!this.$store.getters.isPermitted({resource: 'Purchasing', action: 'create'}) && !this.$store.getters.isPermitted({resource: 'Purchasing', action: 'update'}))
                this.$props.hideInModal = true;
            if (this.formFields.id > 0 && !this.$store.getters.isPermitted({resource: 'Purchasing', action: 'update'}))
                this.hideinAuth = true;
            this.getPO(this.formFields.id);
            this.getColumns();
            this.getRecords();
            this.$store.getters.detectFormChanges();
        },
        methods: {

            /** CRUD */
            getPoOrderFromDropDown: async function(id){
                this.axiosParams.id = id;
                await fetchRecord(this.axiosParams, (response) => {
                    this.formFields = response.data;
                    if (this.formFields.supplier == null) {
                        this.formFields.supplier = {};
                    }
                    this.checkClosedDateExists();
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            getPO: function (id) {
                if (id) {
                        this.axiosParams.id = id;
                        fetchRecord(this.axiosParams, (response) => {
                            this.formFields = response.data;
                            if (this.formFields.supplier == null) {
                                this.formFields.supplier = {};
                            }
                            this.checkClosedDateExists();
                            if (this.$store.state[this.axiosParams.module].recordList.length > 0)
                                this.$store.state[this.axiosParams.module].busy = false
                        }, (error) => {
                                this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                        })
                }
                if (this.$store.state.supplier.supplierInfo.length == 0) {
                    this.$store.dispatch('getSupplierInfo')
                }
                this.findProducts('byNumber')
                this.findProducts('byTitle')
            },
            chechEmptySupplier: function () {
                if (this.formFields.supplier == null) {
                    this.formFields.supplier = {};
                    return;
                }
            },
            showPoMonumentProduct: function (row, poNumber, poId, poName) {
                this.monumentProductInventory.selectedRowIndex = row.index;
                this.monumentProductInventory.poMonumentId = poId;
                this.monumentProductInventory.poMonumentName = poName;
                this.monumentProductInventory.poMonumentNumber = poNumber;
                this.monumentProductInventory.poMonumentQuantity = row.item.quantity;
            },
            unCheckBox: function () {
                this.checkUncheckBox = false;
                let indexOfPo = this.monumentProductInventory.selectedRowIndex;
                this.formFields.po_products[indexOfPo].posted = false;
                this.$bvModal.hide('posted-product-inventory');
            },
            updateMonumentInventory: function (data) {
                this.$bvModal.hide('posted-product-inventory');
                this.formFields.po_products[data.selectedRowIndex].hideInPosted = true;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                updateMonumentInventory(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: message, variant: 'danger'});
                    } else {
                        this.monumentProductInventory.poMonumentId = 0;
                        this.monumentProductInventory.poMonumentName = null;
                        this.monumentProductInventory.poMonumentNumber = null;
                        this.monumentProductInventory.poMonumentQuantity = null;
                        this.monumentProductInventory.selectedRowIndex = null;
                        this.$bvModal.show('posted-inventory-updated');
                    }
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })

            },
            closeSuccesModal: function () {
                this.$bvModal.hide('posted-inventory-updated');
            },
            updateSelectedItem: function () {

                this.purchaseOrderTableFields.filter(obj => {
                    if (this.selectedItem === 'false') {
                        if (obj.isMonumentSelected) {
                            let modifyClass = obj.thClass + " d-none";
                            this.$set(obj, 'thClass', modifyClass)
                            this.$set(obj, 'tdClass', modifyClass)
                        }
                    } else {
                        if (obj.isMonumentSelected) {
                            let modifyClass = obj.thClass.replace("d-none", '');
                            this.$set(obj, 'thClass', modifyClass)
                            this.$set(obj, 'tdClass', modifyClass)
                        }
                    }
                });
            },
            addNonStockingProduct: function () {
                let obj = {
                    non_stock_product: [{id: 0, product_number: '', item_name: ''}],
                    id: 0,
                    quantity: 0,
                    price: 0,
                    cost: 0,
                    client_price: 0,
                    amount: 0,
                    installation_price: 0,
                    total: 0
                };
                this.formFields.po_products.splice(this.formFields.po_products.length, 0, obj);
            },
            removeProduct: function (index, id, data) {
                if (this.formFields.id > 0 && this.formFields.po_closed_on != null) {
                    return;
                }
                this.formFields.po_products.splice(index, 1);
                if (id) {
                    let params = {module: this.axiosParams.module + '/deleteProduct/', id: id};
                    deleteProduct(params, (response) => {
                        console.log(response)
                    })
                }
            },
            setNewSupplierNo: function (data) {
                this.addSupplier.supplier_no = data;
            },
            addProduct: function (obj, type) {
                window.detectChanges = true
                let exists = this.formFields.po_products.includes(obj)
                let price = 0, unit_weight = 0, compositeObj = [], iscompositeDetails = false;
                if (type == 'monument') {
                    price = obj.product_cost;
                    unit_weight = obj.specification.weight_lb;
                } else if (type == 'simple' || type == 'service')
                    price = obj.product_cost;
                else
                    price = obj.price;
                let installationAmount = obj.installation ? obj.installation.installation_amount : 0;
                if (type == 'composite') {
                    compositeObj.push(obj);
                }
                if (obj.composite_products && obj.composite_products.length > 0)
                    iscompositeDetails = true;
                if (!exists) {
                    let customObj = {
                        [type]: [{
                            id: obj.id,
                            product_number: obj.product_number,
                            item_name: obj.item_name,
                            type_title: obj.type != null ? obj.type.type_title : '',
                            color_title: obj.color != null ? obj.color.color_title : '',
                            shape_title: obj.shape != null ? obj.shape.shape_title : '',
                            side_title: obj.side != null ? obj.side.side_title : '',
                            polish_type: obj.polish != null ? obj.polish.polish_type : '',
                            price: price != null ? price : '',
                            weight_lb: obj.specification != null ? obj.specification.weight_lb : 0
                        }],
                        id: 0,
                        quantity: 1,
                        price: price,
                        cost: price,
                        unit_weight: unit_weight,
                        client_price: price,
                        amount: 0,
                        installation_price: installationAmount,
                        total: 0,
                        composite: compositeObj,
                        iscompositeDetails: iscompositeDetails,
                        _showDetails: iscompositeDetails
                    };
                    this.formFields.po_products.push(customObj)
                }
            },
            handleDropdownChange: function(value){
                window.detectChanges = true;
            },

            addSupplierDetail: function (data) {
                this.formFields.supplier = data;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                saveRecord(this.supplierAxiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: message, variant: 'danger'});
                    } else {
                        this.formFields.supplier = response.data;
                        let supplier_id = this.formFields.supplier.id;
                        this.formFields.supplier_id = supplier_id;
                        this.searchSupplier = this.formFields.supplier.supplier_no;
                        this.supplierAxiosParams.data = response.data;
                        this.$store.commit('appendOrUpdateInSupplierInfo', this.supplierAxiosParams);
                    }
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
                this.$bvModal.hide('purchase-order-modal');
            },
            /** Select List */
            setSupplier(obj) {
                this.formFields.supplier_id = obj.value;
                this.formFields.supplier = obj.options;
            },
            showCompositeProductDetails() {
                for (let item of this.formFields.po_products) {
                    for (let item of this.formFields.po_products) {
                        item.iscompositeDetails = false;
                        if (item.composite && item.composite.length > 0)
                            if (item.composite[0].composite_products && item.composite[0].composite_products.length > 0) {
                                item.iscompositeDetails = true;
                            }
                    }
                }
            },
            printPdf() {
                eventBus.$emit(event.PRINT_PDF);
            },
            checkClosedDateExists() {
                if (this.formFields.id > 0 && this.formFields.po_closed_on != null)
                    return this.hideInCloseDate = true;
                else
                    return this.hideInCloseDate = false;
            },

            /** Products*/
            findProducts: function (type = 'byNumber') {
                let keywords = type == 'byNumber' ? this.searchByNumber : this.searchByTitle;
                let formData = new FormData();
                formData.append('keywords', keywords);
                formData.append('type', type);
                searchPoProducts(formData, (response) => {
                    type == 'byNumber' ? this.productsByNumber = response.data : this.productsByTitle = response.data;
                });

            },
            storePO: function () {
                this.saveDisabled = true;
                let data = this.formFields;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: message, variant: 'danger'});
                    } else {

                        let status = this.formFields.id ? 'Updated' : 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                        this.makeToast({title: 'Success', message: this.alertMessage, variant: 'success'});

                        this.formFields = response.data;
                        if (this.formFields.supplier == null) {
                            this.formFields.supplier = {};
                        }
                        this.axiosParams.data = response.data;
                        this.alertMessage = '';
                        this.$store.commit('appendOrUpdateInRecordList', this.axiosParams);
                        this.showCompositeProductDetails();
                        this.checkClosedDateExists();
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
                            // this.formFields = this.$store.state[this.axiosParams.module].firstRecord;
                            this.first()
                            if (this.$store.state[this.axiosParams.module].recordList.length == 0)
                                this.clearForm();
                        } else {
                            console.log(response.data);
                        }
                    }, (error) => {
                        console.log(error);
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
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
                    this.$store.dispatch('getDropDownInfo', {module: this.axiosParams.module, apiURL: 'getDropDownRecord', page: this.pageNumber})
            },

            /** Pagination*/
            first: function () {
                    firstRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.formFields = response.data;
                            this.chechEmptySupplier();
                        }
                        this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            last: function () {
                    lastRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.formFields = response.data;
                            this.chechEmptySupplier();
                        }
                        this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            next: function (id) {
                    this.axiosParams.id = id;
                    nextRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.formFields = response.data;
                            this.chechEmptySupplier();
                        }
                        this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            prev: function (id) {
                    this.axiosParams.id = id;
                    previousRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.formFields = response.data;
                            this.chechEmptySupplier();
                        }
                        this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },

            /** Generic*/
            clearForm: function () {
                if (window.detectChanges && !confirm('You have unsaved changes. Are you sure you want to navigate away?')) {
                    this.$store.state[this.axiosParams.module].busy = false
                } else {
                    window.detectChanges = false;
                }
                if (!window.detectChanges) {
                    this.formFields = {
                        // store_id: this.storeID,
                        id: 0,
                        order_place_on: this.getCurrentWeek().date,
                        po_closed_on: null,
                        po_date: this.getCurrentWeek().date,
                        supplier_id: null,
                        shipping_date: null,
                        notes: null,
                        total_po_amount: null,
                        po_products: [],
                        supplier: {
                            supplier_name: null,
                        }
                    },
                        this.addSupplier = {
                            id: 0,
                            supplier_no: null,
                            supplier_name: null,
                            contact_person: null,
                            phone: null,
                            email: null,
                            fax: null
                        };

                    this.searchByNumber = '';
                    this.searchByTitle = '';
                    this.searchSupplier = '';
                    this.hideInCloseDate = false;
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
            getCurrentWeek() {
                let currentdate = new Date();
                let oneJan = new Date(currentdate.getFullYear(), 0, 1);
                let numberOfDays = Math.floor((currentdate - oneJan) / (24 * 60 * 60 * 1000));
                let currentWeek = Math.floor((currentdate.getDay() + 1 + numberOfDays) / 7);
                const month = String(currentdate.getMonth() + 1).padStart(2, '0');
                const day = String(currentdate.getDate()).padStart(2, '0');
                const year = currentdate.getFullYear();
                const date = year + '-' + month + "-" + day;
                return {week: currentWeek, date: date};
            },
            makeToast: function (params) {
                this.$bvToast.toast(params.message, {
                    id: 'supplier-toast',
                    title: params.title,
                    variant: params.variant,
                    toaster: 'b-toaster-top-center',
                    autoHideDelay: params.duration ? params.duration : 2000,
                    noAutoHide: this.toastHider,
                    noCloseButton: true,
                })
                this.saveDisabled = false;
            },
            checkDate: function (date) {
                return searchForEmptyDate(date);
            },
            changeDateFormat: function (value) {
                return this.$store.getters.changeDateFormat(value);
            },
        }
    }

</script>

<style scoped>
    .po-row {
        display: flex;
        margin: 0.5rem 0;
    }

    .po-row div {
        display: flex;
    }

    .po-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
        width: 5rem;
    }

    .po-row div input, select, textarea {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.75rem !important;
    }

    input {
        font-size: 0.75rem !important;
    }

    .po-row .custom-po-textarea-width {
        width: 63.6rem !important;
    }

    .custom-dropdown-margin {
        margin: auto 2.5rem;
    }

    .input-label {
        width: 4rem !important;
    }

    .input-xl {
        width: 30rem;
    }

    .input-lg {
        width: 18rem;
    }

    .input-md {
        width: 13rem;
    }

    .input-sm {
        width: 7rem;
    }

    .input-xs {
        width: 5rem;
    }

    .type-list {
        font-size: 0.8rem;
        text-align: left;
    }

    .border {
        border: 1px solid #c4c4c4 !important;
    }

    .custom-add-btn {
        box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.25);
        border-radius: 5px;
        height: 26px;
        font-size: 12px;
        letter-spacing: 0.02em;
    }

    .input-date {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.6rem !important;
    }

    .printing {
        margin: 0px !important;
        padding: 0px !important;
    }

    .custom-totalAmount {
        background: #dee2e6;
        height: 28px !important;
        font-size: 0.75rem !important;
    }
</style>

