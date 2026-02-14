<template>
    <div>
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Order</h5>
            <div class="bg-toolbar my-2 p-1">
                <Toolbar :id="formFields.id" :invoiceNumber="invoiceNumber" :saveDisabled="saveDisabled" :totalRecord="totalRecord"></Toolbar>
            </div>
        </div>
        <div>
            <form class="div-shadow bg-white rounded mx-2 mb-2 " :disabled="'true'">
                <template v-if="isLoading">
                    <div class="text-center text-info my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>
                <template v-else>
<!--                    <div :class="checkDataLoaded ? 'loading-data' : 'loading-data'">-->
                        <div class="custom-row">
                            <div>
                                <label>Invoice No.</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-md " name="invoice_number" readonly
                                              size="sm" type="text" v-model="invoice.invoice_number"></b-form-input>
                            </div>
                            <div>
                                <label>Order Date</label>
                                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                                   :disabled="hideInModal || hideinAuth"
                                                   @input="formFields.date = checkDate(formFields.date)" class="my-auto input-date" close-button locale="en"
                                                   name="date"
                                                   placeholder=""
                                                   reset-button
                                                   size="sm"
                                                   today-button
                                                   v-model="formFields.date">
                                </b-form-datepicker>
                            </div>
                            <div>
                                <label>PO.</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-lg " name="po" size="sm" type="text"
                                              v-model="formFields.po"></b-form-input>
                            </div>
                            <div class="d-block ml-auto" v-if="!hideInModal  && formFields.id">
                                <div class="bg-primary text-white p-1 rounded mb-1">
                                    <label class="">Order Form</label>
                                    <router-link :class="formFields.order_form?.id ? 'btn-success' : 'btn-info' " :to="'/order-form/' + formFields.id"
                                                 class="btn btn-sm order-form-btn py-1 px-1 mx-1 order-form">Order Form
                                    </router-link>
                                    <router-link :class="formFields.order_installation?.id ? 'btn-success' : 'btn-info' " :to="'/order-installation/' + formFields.id"
                                                 class="btn btn-sm order-form-btn py-1 px-1 order-form">Install
                                    </router-link>
                                    <router-link :class="formFields.monument_agreement?.id ? 'btn-success' : 'btn-info' " :to="'/monument-agreement/' + formFields.id"
                                                 class="btn btn-sm order-form-btn py-1 px-1 mx-1 order-form">Agreement
                                    </router-link>
                                    <router-link :class="formFields.approval_monument?.id ? 'btn-success' : 'btn-info' " :to="'/approval-monument/' + formFields.id"
                                                 class="btn btn-sm order-form-btn py-1 px-1 order-form">Approval
                                    </router-link>
                                    <router-link
                                        :class="formFields.monument_work_order?.id ? 'btn-success' : 'btn-info' " :to="'/monument-work-order/' + formFields.id"
                                        class="btn btn-sm order-form-btn py-1 px-1 mx-1 order-form text-nowrap">Work Order
                                    </router-link>
                                    <router-link :class="formFields.final_date?.id ? 'btn-success' : 'btn-info' " :to="'/final-date/' + formFields.id"
                                                 class="btn btn-sm order-form-btn py-1 px-1 order-form text-nowrap">Final Date
                                    </router-link>
                                </div>
                                <div class="m-0">
                                    <div class="bg-primary text-white p-1 rounded">
                                        <label>Other Forms</label>
                                        <b-dropdown class="border rounded input-md " no-caret size="sm" toggle-class="p-0"
                                                    variant="none">
                                            <template #button-content>
                                                <div class="d-flex text-white">
                                                    <small>Select the form</small>
                                                    <i aria-hidden="true" class="fa fa-caret-down ml-auto"></i>
                                                </div>
                                            </template>
                                            <b-dropdown-group class="overflow-auto scroll px-1" style="height: 36vh;">
                                                <template v-for="(obj, key) of orderFormList">
                                                    <b-dropdown-group>
                                                        <b-dropdown-item-button :key="key">
                                                            <router-link :to="'/'+obj.link+'/'+formFields.id"
                                                                         class="btn btn-sm m-0 my-n2">{{obj.text}}
                                                            </router-link>
                                                        </b-dropdown-item-button>
                                                    </b-dropdown-group>
                                                </template>
                                            </b-dropdown-group>
                                        </b-dropdown>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-danger my-auto mx-1 order-form-btn" type="button">Order
                                            Check List
                                        </button>
                                        <button @click="formFields.uploadedFrom = 'uploads'"
                                                class="btn btn-sm btn-danger my-auto order-form-btn"
                                                type="button"
                                                v-b-modal.multiple-file-upload-collab>Upload Files
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="border">
                        <div class="custom-row">
                            <div class="d-block custom-border-right py-2 my-n1 pr-3" style="width:40%">
                                <div>
                                    <h6 class="m-0 custom-form-heading">Company Information</h6>
                                </div>
                                <b-dropdown :disabled="hideInModal || hideinAuth" class="border rounded my-1 w-50 dropdown-width" no-caret size="sm" toggle-class=""
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small>{{company.selectedOpt}}</small>
                                            <i aria-hidden="true" class="fa fa-caret-down ml-auto"></i>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            class="mt-1"
                                            placeholder="Search..."
                                            size="sm"
                                            v-model="searchCompany"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="companies.length > 0">
                                            <template v-for="(obj, key) of companies">
                                                <b-dropdown-group @click="handleDropdownChange">
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.company_id = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                            <button class="d-flex m-auto px-3 btn-sm btn-info custom-btn" type="button"
                                                    v-b-modal.add-modal>Add Company
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>
                                <div class="mt-2 ml-0">
                                    <label class="w-15">Name</label>
                                    <div class="flex-grow-1">
                                        <b-form-input :disabled="hideInModal || hideinAuth" :value="company.data.name" class="ml-0 w-75 bg-order"
                                                      readonly size="sm" type="text"></b-form-input>
                                    </div>
                                </div>
                                <div class="mt-2 ml-0">
                                    <label class="w-15">Address</label>
                                    <div class="flex-grow-1">
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="ml-0 w-75 bg-order" readonly
                                                      size="sm" type="text" v-model="company.data.address"></b-form-input>
                                    </div>
                                </div>
                                <div class="mt-2 ml-0">
                                    <label class="w-15">City</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" :value="company.data.city" class="ml-1 w-50 bg-order" readonly
                                                  size="sm" type="text"></b-form-input>
                                    <label>State</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" :value="company.data.state" class="input-sm bg-order" readonly
                                                  size="sm" type="text"></b-form-input>
                                    <label>Zip</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" :value="company.data.zip" class="input-sm w-25 bg-order" readonly
                                                  size="sm" type="text"></b-form-input>
                                </div>
                                <div class="mt-2 ml-0">
                                    <label class="w-15">Contact </label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" :value="company.data.contact" class="ml-1 w-75 bg-order" readonly
                                                  size="sm" type="text"></b-form-input>
                                    <label>Phone</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" :value="company.data.phone" class="mr-0 bg-order" readonly
                                                  size="sm" type="text"></b-form-input>
                                </div>
                                <div class="mt-2 ml-0">
                                    <label class="w-15">Email</label>
                                    <div class="flex-grow-1">
                                        <b-form-input :disabled="hideInModal || hideinAuth" :value="company.data.email" class="ml-0 w-75 bg-order"
                                                      readonly size="sm" type="email"></b-form-input>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block custom-border-right py-2 my-n1 pr-3" style="width:40%">
                                <div>
                                    <h6 class="m-0 custom-form-heading">Family Information</h6>
                                </div>
                                <div class="mt-2 ml-0">
                                    <div class="w-25">
                                        <label>Last Name on Stone</label>
                                    </div>
                                    <div class="flex-grow-1">
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="ml-0 w-75" name="name_on_stone"
                                                      size="sm" type="text"
                                                      v-model="family.name_on_stone"></b-form-input>
                                    </div>
                                </div>
                                <div class="mt-2 ml-0">
                                    <div class="w-25">
                                        <label>Address</label>
                                    </div>
                                    <div class="flex-grow-1">
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="ml-0 w-75" name="family_address"
                                                      size="sm" type="text" v-model="family.address"></b-form-input>
                                    </div>
                                </div>
                                <div class="mt-2 ml-0">
                                    <div class="w-50">
                                        <label>City</label>
                                    </div>
                                    <b-form-input :disabled="hideInModal || hideinAuth" class="input-field-margin w-50" name="family_city" size="sm"
                                                  type="text" v-model="family.city"></b-form-input>
                                    <label>State</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" name="family_state" size="sm"
                                                  type="text" v-model="family.state"></b-form-input>
                                    <label>Zip</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm w-25" name="family_zip" size="sm"
                                                  type="text" v-model="family.zip"></b-form-input>
                                </div>
                                <div class="mt-2 ml-0">
                                    <div class="w-75">
                                        <label>Customer Contact</label>
                                    </div>
                                    <b-form-input :disabled="hideInModal || hideinAuth" class="w-75" name="family_contact" size="sm"
                                                  type="text" v-model="family.contact"></b-form-input>
                                    <label>Phone</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" class="mr-0 " name="family_phone" size="sm"
                                                  type="text" v-model="family.phone"></b-form-input>
                                </div>
                                <div class="mt-2 ml-0">
                                    <div class="w-25">
                                        <label>Email</label>
                                    </div>
                                    <div class="flex-grow-1">
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="ml-0 w-75" name="email"
                                                      size="sm" type="text" v-model="family.email"></b-form-input>
                                    </div>
                                </div>
                                <div class="mt-2 ml-0">
                                    <div class="w-25">
                                        <label>Update Customer via</label>
                                    </div>
                                    <div class="flex-grow-1">
                                        <b-form-group class="m-0 my-auto custom-radio-and-checkbox">
                                            <b-form-radio-group :disabled="hideInModal || hideinAuth" name="update-customer"
                                                                v-model="family.update_customer">
                                                <b-form-radio name="update-customer-radio" size="sm" value="mail">E-Mail</b-form-radio>
                                                <b-form-radio name="update-customer-radio" size="sm" value="text">Text Message</b-form-radio>
                                            </b-form-radio-group>
                                        </b-form-group>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block py-2" style="width:30%">
                                <div>
                                    <h6 class="m-0 custom-form-heading">Invoice Info</h6>
                                </div>
                                <div class="mt-2 ml-0">
                                    <label>Type of Order</label>
                                    <b-dropdown :disabled="hideInModal" class="input-xl mr-0 border rounded ml-auto cutsom-order-dropdown-width"
                                                no-caret size="sm" toggle-class=""
                                                variant="none">
                                        <template #button-content>
                                            <div class="d-flex product-color">
                                                <small>{{customizeLabel(orderTypeTitle)}}</small>
                                                <small class="w-25 ml-auto custom-caret"></small>
                                            </div>
                                        </template>
                                        <b-dropdown-group class="overflow-auto scroll px-1 mycustom-width">
                                            <b-form-input
                                                class="mt-1"
                                                placeholder="Search..."
                                                size="sm"
                                                v-model="searchOrderType"
                                            ></b-form-input>
                                            <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                            <template v-if="orderTypes.length > 0">
                                                <template v-for="(obj, key) of orderTypes">
                                                    <b-dropdown-group @click="handleDropdownChange">
                                                        <b-dropdown-item-button :key="key" @click="setDetail(obj,'order_type')"
                                                                                class="w-100">
                                                            <label class="btn btn-sm m-0">{{obj.text}}</label>
                                                        </b-dropdown-item-button>
                                                        <b-icon @click="deleteDropDown(obj.value)" aria-hidden="true" class="mt-n4 float-right" icon="trash-fill" variant="danger"></b-icon>
                                                    </b-dropdown-group>
                                                </template>
                                            </template>
                                            <template v-else>
                                                <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                                <button @click="saveDetail('type_title')" class="d-flex m-auto px-3 btn-sm btn-info custom-add-btn"
                                                        type="button">Add Order Type
                                                </button>
                                            </template>
                                        </b-dropdown-group>
                                    </b-dropdown>
                                </div>
                                <div class="mt-2 ml-0">
                                    <label>Inv. Closed Date</label>
                                    <b-form-datepicker
                                        :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                        :disabled="hideInModal || hideinAuth"
                                        @input="invoice.closed_date = checkDate(invoice.closed_date)"
                                        class="input-xl ml-auto mr-0 input-date"
                                        close-button
                                        locale="en"
                                        placeholder=""
                                        reset-button
                                        size="sm"
                                        today-button
                                        v-model="invoice.closed_date">
                                    </b-form-datepicker>
                                </div>
                                <div class="mt-2 ml-0">
                                    <label>Org. Inv. No.</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" class="input-xl mr-0 " name="invoice_original_number"
                                                  size="sm" type="text"
                                                  v-model="invoice.original_invoice_number"></b-form-input>
                                </div>
                                <div class="mt-2 ml-0">
                                    <label>Ship/Invoice Date</label>
                                    <b-form-datepicker
                                        :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                        :disabled="hideInModal || hideinAuth"
                                        @input="invoice.ship_date = checkDate(invoice.ship_date)"
                                        class="input-xl ml-auto mr-0 input-date"
                                        close-button
                                        locale="en"
                                        placeholder=""
                                        reset-button
                                        size="sm"
                                        today-button
                                        v-model="invoice.ship_date">
                                    </b-form-datepicker>
                                </div>
                                <div class="mt-2 ml-0">
                                    <label>Sales Person</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" class="input-xl mr-0 " name="sales_person" size="sm" type="text" v-model="formFields.sales_person"></b-form-input>
                                </div>
                                <div class="mt-2 ml-0">
                                    <label>Date Promised</label>
                                    <b-form-datepicker
                                        :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                        :disabled="hideInModal || hideinAuth"
                                        @input="invoice.date_promised = checkDate(invoice.date_promised)"
                                        class="input-xl ml-auto mr-0 input-date"
                                        close-button
                                        locale="en"
                                        placeholder=""
                                        reset-button
                                        size="sm"
                                        today-button
                                        v-model="invoice.date_promised">
                                    </b-form-datepicker>
                                </div>
                            </div>
                        </div>
                        <hr class="border">
                        <div class="custom-row mt-1">
                            <div class="d-block m-0 product-table-width">
                                <b-table :fields="productTableFields" :items="formFields.products" bordered class="ml-2" hover responsive
                                         small
                                         striped>
                                    <template #head()="data">
                                        <span class="custom-form-heading ml-2">{{ data.label }}</span>
                                    </template>
                                    <template v-slot:cell(product_number)="row">
                                        <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-md" name="product_number"
                                                          size="sm" type="text"
                                                          v-model="row.item.non_stock_product[0].product_number"></b-form-input>
                                        </template>
                                        <template v-if="row.item.monument && row.item.monument.length > 0">
                                            <label class="d-flex justify-content-center product-table">{{row.item.monument[0].product_number}}</label>
                                        </template>
                                        <template v-if="row.item.service && row.item.service.length > 0">
                                            <label class="d-flex justify-content-center product-table">{{row.item.service[0].product_number}}</label>
                                        </template>
                                        <template v-if="row.item.simple && row.item.simple.length > 0">
                                            <label class="d-flex justify-content-center product-table">{{row.item.simple[0].product_number}}</label>
                                        </template>
                                        <template v-if="row.item.composite && row.item.composite.length > 0">
                                            <label class="d-flex justify-content-center product-table">{{row.item.composite[0].product_number}}</label>
                                        </template>
                                    </template>
                                    <template v-slot:cell(item_name)="row">
                                        <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-md" name="item_name" size="sm"
                                                          type="text"
                                                          v-model="row.item.non_stock_product[0].item_name"></b-form-input>
                                        </template>
                                        <template v-if="row.item.monument && row.item.monument.length > 0">
                                            <label class="d-flex justify-content-center product-table">{{row.item.monument[0].item_name}}</label>
                                        </template>
                                        <template v-if="row.item.service && row.item.service.length > 0">
                                            <label class="d-flex justify-content-center product-table">{{row.item.service[0].item_name}}</label>
                                        </template>
                                        <template v-if="row.item.simple && row.item.simple.length > 0">
                                            <label class="d-flex justify-content-center product-table">{{row.item.simple[0].item_name}}</label>
                                        </template>
                                        <template v-if="row.item.composite && row.item.composite.length > 0">
                                            <label class="d-flex justify-content-center product-table">{{row.item.composite[0].item_name}}</label>
                                        </template>
                                    </template>
                                    <template v-slot:cell(price)="row">
                                        <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                            <vue-numeric :disable="hideInModal || hideinAuth" class="input-md form-control form-control-sm" currency="$"
                                                         separator="," v-bind:minus="false" v-bind:precision="2" v-model="row.item.price" v-remove-zero></vue-numeric>
                                        </template>
                                        <template v-if="row.item.monument && row.item.monument.length > 0">
                                            <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(row.item.price) ?
                                                changeNumberFormat(row.item.price) : '0.00' }}</label>
                                        </template>
                                        <template v-if="row.item.service && row.item.service.length > 0">
                                            <label class="d-flex justify-content-center product-table">$
                                                {{ changeNumberFormat(row.item.price) ?
                                                changeNumberFormat(row.item.price) : '0.00' }}</label>
                                        </template>
                                        <template v-if="row.item.simple && row.item.simple.length > 0">
                                            <label class="d-flex justify-content-center product-table">$
                                                {{ changeNumberFormat(row.item.price) ?
                                                changeNumberFormat(row.item.price) : '0.00' }}</label>
                                        </template>
                                        <template v-if="row.item.composite && row.item.composite.length > 0">
                                            <label class="d-flex justify-content-center product-table">$
                                                {{ changeNumberFormat(row.item.price) ?
                                                changeNumberFormat(row.item.price) : '0.00' }}</label>
                                        </template>
                                    </template>
                                    <template v-slot:cell(quantity)="row">
                                        <b-form-input :disabled="hideInModal || hideinAuth" class="input-xsmall" min="0" name="quantity"
                                                      size="sm" type="number" v-model="row.item.quantity"></b-form-input>
                                    </template>
                                    <template v-slot:cell(client_price)="row">
                                        <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                            <label class="d-none">{{row.item.client_price > row.item.price ? row.item.client_price : row.item.client_price = row.item.price}}</label>
                                            <vue-numeric :disable="hideInModal || hideinAuth"
                                                         class="input-md form-control form-control-sm" currency="$"
                                                         id="inline-form-input-client-price-one" separator=","
                                                         v-bind:precision="2" v-model="row.item.client_price" v-remove-zero></vue-numeric>
                                        </template>
                                        <template v-else>
                                            <vue-numeric :disable="hideInModal || hideinAuth"
                                                         class="input-md form-control form-control-sm" currency="$"
                                                         id="inline-form-input-client-price-two" separator=","
                                                         v-bind:precision="2" v-model="row.item.client_price" v-remove-zero></vue-numeric>
                                        </template>
                                    </template>
                                    <template v-slot:cell(amount)="row">
                                        <label class="d-none">$ {{ row.item.amount =
                                            Math.abs((row.item.quantity*row.item.client_price)).toFixed(2) }}</label>
                                        <label class="">$ {{ changeNumberFormat(row.item.amount) ? changeNumberFormat(row.item.amount) : '0.00' }}</label>
                                        <input :disabled="hideInModal || hideinAuth" :value="row.item.amount" name="amount" type="hidden">
                                    </template>
                                    <template v-slot:cell(installation_price)="row">
                                        <vue-numeric :disable="hideInModal || hideinAuth"
                                                     class="input-md form-control form-control-sm" currency="$"
                                                     id="inline-form-input-installation_price" separator=","
                                                     v-bind:precision="2" v-model="row.item.installation_price" v-remove-zero></vue-numeric>
                                    </template>
                                    <template v-slot:cell(installation_amount)="row">
                                        <label class="d-none">$ {{
                                            Math.abs((row.item.quantity * row.item.installation_price)).toFixed(2) }}</label>
                                        <label>$ {{ changeNumberFormat(row.item.quantity * row.item.installation_price) ? changeNumberFormat(row.item.quantity * row.item.installation_price)
                                            : '0.00' }}</label>
                                    </template>
                                    <template v-slot:cell(total)="row">
                                        <label class="d-none">$ {{ row.item.total = Math.abs(+row.item.amount +
                                            parseFloat(row.item.installation_price == '' ? 0 :
                                            row.item.quantity * row.item.installation_price)).toFixed(2) }}</label>
                                        <label>$ {{ changeNumberFormat(row.item.total) ? changeNumberFormat(row.item.total) : '0.00' }}</label>
                                        <input :disabled="hideInModal || hideinAuth" :value="row.item.total" name="total" type="hidden">
                                    </template>
                                    <template #cell(action)="data">
                                        <a @click="removeProduct(data.index, data.item.id)" class="btn btn-sm btn-danger mx-1 py-1"
                                           href="javascript:void(0)">
                                            <i aria-hidden="true" class="fa fa-trash-o"></i>
                                        </a>
                                    </template>
                                    <template v-slot:cell(showProducts)="row">
                                        <b-button
                                            @click="row.toggleDetails"
                                            class="btn btn-sm btn-info order-form-btn py-1 mx-1 "
                                            size="sm"
                                            v-if="row.item.iscompositeDetails">
                                            {{ row.detailsShowing ? 'Hide' : 'Show'}}
                                        </b-button>
                                    </template>
                                    <template v-slot:row-details="row">
                                        <b-card>
                                            <table class="table table-sm table-striped table-bordered my-2 ">
                                                <thead class="custom-table-header">
                                                <tr>
                                                    <th>Product #</th>
                                                    <th>Product Name</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th>Amount</th>
                                                    <th>Install Price</th>
                                                    <th>Install Amount</th>
                                                </tr>
                                                </thead>
                                                <tbody class="custom-table-body">
                                                <tr v-for="(obj, key) of row.item.composite[0].composite_products">
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
                                                        <label class="d-flex justify-content-center product-table">{{row.item.quantity
                                                            * obj.quantity}}</label>
                                                    </td>
                                                    <td>
                                                        <template v-if="obj.monument && obj.monument.length > 0">
                                                            <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(obj.monument[0].override_selling_price) ?
                                                                changeNumberFormat(obj.monument[0].override_selling_price) : '0.00' }}</label>
                                                        </template>
                                                        <template v-if="obj.service && obj.service.length > 0">
                                                            <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(obj.service[0].override_selling_price) ?
                                                                changeNumberFormat(obj.service[0].override_selling_price) : '0.00' }}</label>
                                                        </template>
                                                        <template v-if="obj.simple && obj.simple.length > 0">
                                                            <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(obj.simple[0].override_selling_price) ?
                                                                changeNumberFormat(obj.simple[0].override_selling_price) : '0.00' }}</label>
                                                        </template>
                                                    </td>
                                                    <td>
                                                        <template v-if="obj.monument && obj.monument.length > 0">
                                                            <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(row.item.quantity * obj.quantity * obj.monument[0].override_selling_price) ?
                                                                changeNumberFormat(row.item.quantity * obj.quantity * obj.monument[0].override_selling_price) : '0.00' }}</label>
                                                        </template>
                                                        <template v-if="obj.service && obj.service.length > 0">
                                                            <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(row.item.quantity * obj.quantity * obj.service[0].override_selling_price) ?
                                                                changeNumberFormat(row.item.quantity * obj.quantity * obj.service[0].override_selling_price) : '0.00' }}</label>
                                                        </template>
                                                        <template v-if="obj.simple && obj.simple.length > 0">
                                                            <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(row.item.quantity * obj.quantity * obj.simple[0].override_selling_price) ?
                                                                changeNumberFormat(row.item.quantity * obj.quantity * obj.simple[0].override_selling_price) : '0.00' }}</label>
                                                        </template>
                                                    </td>
                                                    <td>
                                                        <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(obj.installation_price) ?
                                                            changeNumberFormat(obj.installation_price) : '0.00' }}</label>
                                                    </td>
                                                    <td>
                                                        <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(row.item.quantity * obj.quantity * obj.installation_price) ?
                                                            changeNumberFormat(row.item.quantity * obj.quantity * obj.installation_price) : '0.00' }}</label>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </b-card>
                                    </template>
                                </b-table>
                                <div class="custom-row ml-0" v-if="!hideInModal">
                                    <div>
                                        <h6 class="my-auto custom-form-heading">Products</h6>
                                    </div>
                                    <div>
                                        <b-dropdown class="border rounded input-product dropdown-width" no-caret size="sm" toggle-class="p-0"
                                                    variant="none">
                                            <template #button-content>
                                                <div class="d-flex product-color">
                                                    <small>Select Product by Number</small>
                                                    <i aria-hidden="true" class="fa fa-caret-down ml-auto"></i>
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
                                                <template v-for="(object, key) of allProductsByNumber">
                                                    <b-dropdown-group class="text-left">
                                                        <template v-if="typeof object === 'object'">
                                                            <b-dropdown-item-button :key="key"
                                                                                    @click="addProduct(object,object.product_type)"
                                                                                    class="small">
                                                                {{object.product_number}}
                                                            </b-dropdown-item-button>
                                                        </template>
                                                        <template v-else>
                                                            <b-dropdown-text class="small">{{object}}</b-dropdown-text>
                                                        </template>
                                                    </b-dropdown-group>
                                                </template>
                                            </b-dropdown-group>
                                        </b-dropdown>
                                    </div>
                                    <div class="w-100">
                                        <b-dropdown class="border rounded w-100 dropdown-width" no-caret size="sm" toggle-class="p-0"
                                                    variant="none">
                                            <template #button-content>
                                                <div class="d-flex product-color">
                                                    <small>Select Product by Title</small>
                                                    <i aria-hidden="true" class="fa fa-caret-down ml-auto"></i>
                                                </div>
                                            </template>
                                            <b-dropdown-group class="overflow-auto scroll px-1">
                                                <b-form-input
                                                    :disabled="hideInModal || hideinAuth"
                                                    @keyup="findProducts('byTitle')"
                                                    class="mt-1"
                                                    placeholder="Search..."
                                                    size="sm"
                                                    v-model="searchByTitle"
                                                ></b-form-input>
                                                <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                                <template v-for="(object, key) of allProductsByTitle">
                                                    <b-dropdown-group class="text-left">
                                                        <template v-if="typeof object === 'object'">
                                                            <b-dropdown-item-button :key="key"
                                                                                    @click="addProduct(object,object.product_type)"
                                                                                    class="small"
                                                                                    style="word-break: break-all;">
                                                                {{object.item_name}}
                                                            </b-dropdown-item-button>
                                                        </template>
                                                        <template v-else>
                                                            <b-dropdown-text class="small">{{object}}</b-dropdown-text>
                                                        </template>
                                                    </b-dropdown-group>
                                                </template>
                                            </b-dropdown-group>
                                        </b-dropdown>
                                    </div>
                                    <div>
                                        <button @click="addNonStockingProduct" class="btn btn-sm btn-info px-3 mt-1 custom-btn"
                                                type="button">Add New
                                        </button>
                                    </div>
                                </div>
                                <div class="custom-row justify-content-end custom-margin-total">
                                    <div class="flex-column mr-0">
                                        <label class="label-total">Discount</label>
                                        <price :disabled="hideInModal || hideinAuth" class="input-total" min="0" name="discount" size="sm" type="number"
                                               v-model="formFields.discount" v-on:change="discount" v-remove-zero></price>
                                    </div>
                                    <div class="flex-column mr-0">
                                        <label class="label-total">Sub Total</label>
                                        <Price :classes="'input-total'" :disable="hideInModal || hideinAuth" :readonly="true"
                                               v-model="formFields.sub_total= getTotal[0]"></Price>
                                    </div>
                                    <div class="flex-column mr-n1">
                                        <label class="ml-2">Tax Rate</label>
                                        <b-input-group class="input-tax-group" prepend="%" size="sm">
                                            <!--<b-form-input :disabled="hideInModal || hideinAuth" class="col-8 ml-n2 input-total margin-top-2 mx-2" min="0" name="tax_rate" size="sm" type="number"
                                                          v-model="formFields.tax_rate" v-on:change="taxRate" v-remove-zero></b-form-input>-->
                                            <vue-numeric :disable="hideInModal || hideinAuth" :empty-value="0.00"
                                                         class="input-md margin-top-2 ml-n2 inputinstallation form-control form-control-sm"
                                                         id="inline-form-input-installation_price" separator="," style="margin-top: 2px;" v-bind:minus="false"
                                                         v-bind:precision="2" v-model="formFields.tax_rate" v-on:change="taxRate" v-remove-zero></vue-numeric>
                                        </b-input-group>
                                    </div>
                                    <div class="flex-column">
                                        <label class="label-total">Tax Amount</label>
                                        <Price :classes="'input-total'" :disable="hideInModal || hideinAuth" :readonly="true"
                                               v-model="formFields.tax_amount = getTax"></Price>
                                    </div>
                                    <div class="flex-column">
                                        <label class="label-total">Invoice Total</label>
                                        <Price :classes="'input-total'" :disable="hideInModal || hideinAuth" :readonly="true"
                                               v-model="invoice.invoice_total = getTotal[1]"></Price>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block custom-border-left ml-3 mt-n2 payment-table-width">
                                <div>
                                    <h6 class="custom-form-heading ml-1">Payments</h6>
                                </div>
                                <div class="custom-row m-0 flex-column">
                                    <div class="justify-content-center px-2">
                                        <table class="table table-sm table-striped table-bordered small">
                                            <thead>
                                            <th>Pay Date</th>
                                            <th>Amount</th>
                                            <th>Type</th>
                                            <th v-if="!hideInModal">Action</th>
                                            </thead>
                                            <tbody>
                                            <template v-if="invoice.payments.length > 0">
                                                <template v-for="row of invoice.payments">
                                                    <tr>
                                                        <td>{{ changeDateFormat(row.date) }}</td>
                                                        <td>$ {{ convertDecimal(row.amount) }}</td>
                                                        <td>{{row.type}}</td>
                                                        <td v-if="!hideInModal"><a @click="updatePayment(row.id)" class="btn mx-1 py-1 custom-edit-btn custom-edit-text"
                                                                                   href="javascript:void(0)">Edit</a></td>
                                                    </tr>
                                                    <tr v-if="row.details">
                                                        <td colspan="5">{{row.details}}</td>
                                                    </tr>
                                                    <tr v-if="row.attendant">
                                                        <td colspan="5"><span class="custom-form-heading">Attendant:</span> {{row.attendant}}</td>
                                                    </tr>
                                                </template>
                                            </template>
                                            <template v-else>
                                                <tr>
                                                    <td colspan="5">No Record</td>
                                                </tr>
                                            </template>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="m-auto flex-wrap">
                                        <label><b>Total</b> : $ {{ convertDecimal((invoicePayment.total)) ? convertDecimal((invoicePayment.total)) : '0.00' }}</label>
                                        <label><b>Paid</b> : $ {{ convertDecimal((invoicePayment.paid)) ? convertDecimal((invoicePayment.paid)) : '0.00' }}</label>
                                        <label><b>Remaining</b> : $ {{ convertDecimal((invoicePayment.remaining)) ? convertDecimal((invoicePayment.remaining)) : '0.00' }}</label>
                                    </div>
                                    <div class="flex-column pt-2" v-if="formFields.id">
                                        <div class="mt-1" v-if="!hideInModal">
                                            <label class="col-3 ml-n2 mr-2">Amount</label>
                                            <b-form-input :disabled="hideInModal || hideinAuth" class="col-8" name="payment_amount"
                                                          size="sm" type="text"
                                                          v-model="paymentUpdate.amount"></b-form-input>
                                        </div>
                                        <div class="mt-1 " v-if="!hideInModal">
                                            <label>Type</label>
                                            <b-form-input :disabled="hideInModal || hideinAuth" class="col-8 mr-3" name="payment_type"
                                                          size="sm" type="text" v-model="paymentUpdate.type"></b-form-input>
                                        </div>
                                        <div class="mt-1 " v-if="!hideInModal">
                                            <label>Date</label>
                                            <b-form-datepicker
                                                :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                                :disabled="hideInModal || hideinAuth"
                                                @input="paymentUpdate.date = checkDate(paymentUpdate.date)"
                                                class="col-8 ml-auto mr-3 input-date"
                                                close-button
                                                locale="en"
                                                placeholder=""
                                                reset-button
                                                size="sm"
                                                today-button
                                                v-model="paymentUpdate.date">
                                            </b-form-datepicker>
                                        </div>
                                        <div class="mt-1 " v-if="!hideInModal">
                                            <label>Details</label>
                                            <b-form-textarea
                                                :disabled="hideInModal || hideinAuth"
                                                class="col-8 ml-auto mr-3 textarea-focus"
                                                name="details"
                                                no-resize
                                                placeholder=""
                                                size="sm"
                                                v-model="paymentUpdate.details"
                                            ></b-form-textarea>
                                        </div>
                                        <div class="mt-1 " v-if="!hideInModal">
                                            <label>Attendant</label>
                                            <b-form-input :disabled="hideInModal || hideinAuth" class="col-8 mr-3" name="attendant"
                                                          size="sm" type="text" v-model="paymentUpdate.attendant"></b-form-input>
                                        </div>
                                        <div class="m-auto" v-if="!hideInModal">
                                            <button @click="addPayment" class="btn btn-sm btn-info mt-2 custom-btn w-auto"
                                                    type="button"> {{ paymentUpdate.id ? 'Update' : 'Add' }} Payment Rec
                                            </button>
                                            <button @click="cancelPayment" class="btn btn-sm btn-warning mt-2 custom-btn w-auto ml-1" type="button"
                                                    v-if="paymentUpdate.id">Cancel
                                            </button>
                                            <button @click="printPaymentPDF" class="btn btn-sm btn-info mt-2 custom-btn w-auto ml-1"
                                                    type="button">Print Payments
                                            </button>
                                            <!--<button @click="newPayment" class="btn btn-sm btn-info mt-2 custom-btn w-auto ml-1"
                                                    type="button">New Payments
                                            </button>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="border">
                        <div class="custom-row">
                            <div class="my-4">
                                <label>Cemetery</label>
                                <b-dropdown :disabled="hideInModal || hideinAuth" class="border rounded input-select" no-caret size="sm" toggle-class=""
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small>{{cemetery}}</small>
                                            <i aria-hidden="true" class="fa fa-caret-down ml-auto"></i>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            class="mt-1"
                                            placeholder="Search..."
                                            size="sm"
                                            v-model="searchCemetery"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="cemeteries.length > 0">
                                            <template v-for="(obj, key) of cemeteries">
                                                <b-dropdown-group @click="handleDropdownChange">
                                                    <b-dropdown-item-button :key="key" @click="formFields.cemetery_id = obj.value, $set(formFields, 'cemetery', {company:obj.text}) "
                                                                            class="small m-0 p-0">
                                                        {{obj.text}}
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                            <button @click="addCemetery(searchCemetery)" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add Cemetery
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>
                            </div>
                            <div class="my-4">
                                <label>Installation</label>
                                <b-form-group class="m-0 my-auto custom-radio-and-checkbox">
                                    <b-form-radio-group :disabled="hideInModal || hideinAuth" name="installation"
                                                        v-model="formFields.is_installation">
                                        <b-form-radio name="installation-radio" size="sm" value="1">Yes</b-form-radio>
                                        <b-form-radio name="installation-radio" size="sm" value="0">No</b-form-radio>
                                    </b-form-radio-group>
                                </b-form-group>
                            </div>
                        </div>
                        <div class="custom-row">
                            <div class="flex-grow-1 justify-content-start" v-if="!hideInModal">
                                <button :disabled="saveDisabled" @click="storeOrder" class="btn-info mx-2 my-1  custom-infobtn-toolbar custom-infobtn-text" type="button" v-if="formFields.id ? isUpdatePermitted : isCreatePermitted">
                                    {{ formFields.id ? 'Update' : 'Save' }}<span class="spinner-grow spinner-grow-sm ml-1" v-if="saveDisabled"></span>
                                </button>
                            </div>
                        </div>
<!--                    </div>-->
                </template>
            </form>
        </div>

        <PDF :title="'printOrderInvoice'">
            <div class="mb-5 pdf row" slot="header">
                <PrintHeader :title="getTitle"></PrintHeader>
            </div>
            <div class="pdf" slot="body">
                <CompanyFamily :company="company" :family="family" :formFields="formFields" :invoice="invoice"></CompanyFamily>
                <div class="row my-3 mx-0">
                    <div :class="showHidePDF ? '': 'border'" class="col-md-12 p-2">
                        <b-table :fields="pdfTableFields" :items="formFields.products" bordered responsive
                                 small
                                 v-if="!showHidePDF">
                            <template v-slot:cell(product_number)="row">
                                <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.non_stock_product[0].product_number}}</label>
                                </template>
                                <template v-if="row.item.monument && row.item.monument.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.monument[0].product_number}}</label>
                                </template>
                                <template v-if="row.item.service && row.item.service.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.service[0].product_number}}</label>
                                </template>
                                <template v-if="row.item.simple && row.item.simple.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.simple[0].product_number}}</label>
                                </template>
                                <template v-if="row.item.composite && row.item.composite.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.composite[0].product_number}}</label>
                                </template>
                            </template>
                            <template v-slot:cell(item_name)="row">
                                <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.non_stock_product[0].item_name}}</label>
                                </template>
                                <template v-if="row.item.monument && row.item.monument.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.monument[0].item_name}}</label>
                                </template>
                                <template v-if="row.item.service && row.item.service.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.service[0].item_name}}</label>
                                </template>
                                <template v-if="row.item.simple && row.item.simple.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.simple[0].item_name}}</label>
                                </template>
                                <template v-if="row.item.composite && row.item.composite.length > 0">
                                    <label class="d-flex justify-content-center product-table">{{row.item.composite[0].item_name}}</label>
                                </template>
                            </template>
                            <template v-slot:cell(client_price)="row">
                                <label class="d-flex justify-content-center product-table">$
                                    {{ changeNumberFormat(row.item.client_price) ?
                                    changeNumberFormat(row.item.client_price) : '0.00' }}</label>
                            </template>
                            <template v-slot:cell(installation_price)="row">
                                <label class="d-flex justify-content-center product-table">$
                                    {{ changeNumberFormat(row.item.installation_price) ?
                                    changeNumberFormat(row.item.installation_price) : '0.00' }}</label>
                            </template>
                            <template v-slot:cell(total)="row">
                                <label class="d-flex justify-content-center product-table">$
                                    {{ changeNumberFormat(row.item.total) ?
                                    changeNumberFormat(row.item.total) : '0.00' }}</label>
                            </template>
                            <template v-slot:row-details="row">
                                <b-card class="w-75 border-0">
                                    <table class="table table-sm table-striped table-bordered my-2">
                                        <thead class="custom-table-header">
                                        <tr>
                                            <th class="th-text-align-center">Item#</th>
                                            <th class="th-text-align-center">Item Name</th>
                                            <th class="th-text-align-center">QTY</th>
                                        </tr>
                                        </thead>
                                        <tbody class="custom-table-body">
                                        <tr v-for="(obj, key) of row.item.composite[0].composite_products">
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
                                                <label class="d-flex justify-content-center product-table">{{row.item.quantity
                                                    * obj.quantity}}</label>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </b-card>
                            </template>
                        </b-table>
                        <table class="table table-sm table-striped table-bordered small" v-if="showHidePDF">
                            <thead>
                            <th>Pay Date</th>
                            <th>Amount</th>
                            </thead>
                            <tbody>
                            <template v-if="invoice.payments.length > 0">
                                <template v-for="row of invoice.payments">
                                    <tr>
                                        <td>{{ changeDateFormat(row.date) }}</td>
                                        <td>$ {{ convertDecimal(row.amount) }}</td>
                                    </tr>
                                </template>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="5">No Record</td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                        <div class="d-flex mb-5 bottom-section">
                            <div class="">
                            </div>
                            <div class="col-md-5 ml-auto" v-if="!showHidePDF">
                                <div class="d-flex justify-content-end" v-if="formFields.discount">
                                    <div class=" text-right pr-0"><label>Discount</label></div>
                                    <div class="col-md-3 text-right"><label>${{ changeNumberFormat(formFields.discount) ?
                                        formFields.discount.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,") : '0.00' }}</label></div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class=" text-right pr-0"><label>Sub Total</label></div>
                                    <div class="col-md-3 text-right"><label>${{ changeNumberFormat(formFields.sub_total) ?
                                        changeNumberFormat(formFields.sub_total) : '0.00' }}</label></div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class=" text-right pr-0"><label>Tax </label></div>
                                    <div class="col-md-3 text-right"><label>{{ changeNumberFormat(formFields.tax_rate) ?
                                        changeNumberFormat(formFields.tax_rate) : '0.00' }}%</label></div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class=" text-right pr-0"><label>Tax Amount</label></div>
                                    <div class="col-md-3 text-right"><label>${{ changeNumberFormat(formFields.tax_amount) ?
                                        changeNumberFormat(formFields.tax_amount) : '0.00' }}</label></div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class=" text-right pr-0"><label>Total</label></div>
                                    <div class="col-md-3 text-right"><label>${{ changeNumberFormat(invoice.invoice_total) ?
                                        changeNumberFormat(invoice.invoice_total) : '0.00' }}</label></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row bottom-section" v-if="!showHidePDF">
                    <div class="col-md-5">
                        <label><b>Cemetery:</b> {{formFields.cemetery.company}}</label>
                    </div>
                </div>
                <div class="row bottom-section mt-5" v-if="showHidePDF">
                    <div class="col-md-12 d-flex justify-content-end mt-5">
                        <label><b>Total:</b> $ {{invoicePayment.paid}}</label>
                    </div>
                </div>
                <PrintFooter></PrintFooter>
            </div>
        </PDF>
        <Modal :title="'Company'"></Modal>
        <MultipleFileUpload :orderID="formFields.id"></MultipleFileUpload>
    </div>
</template>

<script>
    import Toolbar from "./Toolbar";
    import axios from 'axios';
    import store from "../../store/store";
    import Price from "../../Modules/Price";
    import PDF from "../../Modules/PDF-Modal";
    import Modal from "./Modal";
    import PrintHeader from './Invoice-header-PDF';
    import CompanyFamily from './Company-Family-PDF';
    import PrintFooter from './Invoice-footer-PDF';
    import VueNumeric from 'vue-numeric';
    import MultipleFileUpload from './MultipleFileUpload';
    import {event, eventBus} from "../../event-bus/event-bus";
    import {searchForEmptyDate} from "../../helpers/common";
    import {deleteProduct, deleteRecord, fetchRecord, fetchRecords, firstRecord, lastRecord, nextRecord, previousRecord, savePayment, saveRecord, searchOrderProducts, totalRecords} from "../../helpers/axios";

    export default {
        name: "Add",
        props: {
            id: {
                type: Number
            },
            quote_to_order_id: {
                type: Number
            },
            hideInModal: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                cancelRequest: null,
                isFirstTime: true,
                pageNumber: 1,
                isFirstMount: true,
                // storeID : this.$store.getters.getCurrentStoreID,
                formFields: {
                    // store_id: this.storeID,
                    cemetery: {},
                    cemetery_id: null,
                    company_id: 0,
                    collaboration: {id: 0},
                    correspondence: {id: 0},
                    date: null,
                    family: null,
                    id: 0,
                    is_installation: 0,
                    installation: {id: 0},
                    invoice: {invoice_number: 0, payments: [], invoice_total: 0},
                    order_type: null,
                    po: null,
                    production: {id: 0},
                    accounting: {id: 0},
                    products: [],
                    sales_person: null,
                    store_address: null,
                    store_location: null,
                    sub_total: 0,
                    tax_rate: 0,
                    tax_amount: 0,
                    discount: 0,
                    order_type_id: null,
                },
                productTableFields: [
                    {key: 'product_number', label: "Product #"},
                    {key: 'item_name', label: "Product Name"},
                    {key: 'quantity', label: "Qty"},
                    {key: 'price', label: "Price"},
                    {key: 'client_price', label: "Client Price"},
                    {key: 'amount', label: "Amount"},
                    {key: 'installation_price', label: "Install"},
                    {key: 'installation_amount', label: "Install Amount", thClass: 'text-nowrap'},
                    {key: 'total', label: "Total"},
                    {key: "showProducts", label: "Details"},
                    {
                        key: 'action',
                        label: "Action",
                        thClass: this.$props.hideInModal ? 'd-none' : '',
                        tdClass: this.$props.hideInModal ? 'd-none' : ''
                    },
                ],
                productList: [],
                productsByNumber: {},
                allProductsByNumber: [],
                productsByTitle: {},
                allProductsByTitle: [],
                searchByNumber: "",
                searchByTitle: "",
                pdfTableFields: [
                    {key: 'product_number', label: "Item#", class: 'text-center small'},
                    {key: 'item_name', label: "Item Name", class: 'text-center small'},
                    {key: 'quantity', label: "QTY", class: 'text-center small'},
                    {key: 'client_price', label: "Price", class: 'text-center small'},
                    {key: 'installation_price', label: "Installation", class: 'text-center small'},
                    {key: 'total', label: "Amount", class: 'text-center small'}
                ],
                searchCompany: "",
                searchCemetery: "",
                payment: {id: 0, amount: ''},
                paymentUpdate: {id: 0, amount: ''},
                formsList: [{value: 1, text: 'Porcelain Form', link: 'porcelain'},
                    {value: 2, text: 'Monument Order Notes', link: 'monument-order-notes'},
                    {value: 3, text: 'Brick Form', link: 'brick-form'},
                    {value: 4, text: 'Delivery - Work Order Form', link: 'delivery-work-order'},
                    {value: 5, text: 'Memorial Production Form', link: 'memorial-production'},
                    {value: 6, text: 'Granit Bronz Memorial Order Form', link: 'granit-bronz-memorial-form'},
                    {value: 7, text: 'Granit Bronz Precious Order Form', link: 'granit-bronz-precious-form'},
                ],
                axiosParams: {module: 'order'},
                quoteAxiosParams: {module: 'quote'},
                axiosUserFamilyParams: {module: 'user'},
                axiosCompanyParams: {module: 'company'},
                axiosParamsOrderType: {module: 'order/orderType'},
                saveDisabled: false,
                totalRecord: 0,
                invoiceNumber: 0,
                hideinAuth: false,
                orderType: [],
                searchOrderType: '',
                detectChanges: null,
            }
        },
        metaInfo() {
            return {
                title: `${this.formFields.id ? 'Edit' : 'Add'} Order`,
            }
        },
        created() {
            eventBus.$on(event.SAVE_ORDER, this.storeOrder);
            eventBus.$on(event.FIRST_ORDER_RECORD, this.first);
            eventBus.$on(event.LAST_ORDER_RECORD, this.last);
            eventBus.$on(event.NEXT_ORDER_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_ORDER_RECORD, this.prev);
            eventBus.$on(event.GET_ORDER, this.getOrderFromDropDown);
            eventBus.$on(event.ADD_ORDER, this.clearForm);
            eventBus.$on(event.DELETE_ORDER, this.deleteRecord);
            eventBus.$on(event.SHOW_HIDE_COMPOSITE_PRODUCT, this.toggleCompositeProduct);
            eventBus.$on(event.MULTIPLE_FILE_UPLOAD_MSG, this.makeToast);
        },
        destroyed() {
            eventBus.$off(event.SAVE_ORDER);
            eventBus.$off(event.FIRST_ORDER_RECORD);
            eventBus.$off(event.LAST_ORDER_RECORD);
            eventBus.$off(event.NEXT_ORDER_RECORD);
            eventBus.$off(event.PREVIOUS_ORDER_RECORD);
            eventBus.$off(event.GET_ORDER);
            eventBus.$off(event.ADD_ORDER);
            eventBus.$off(event.DELETE_ORDER);
            eventBus.$off(event.SHOW_HIDE_COMPOSITE_PRODUCT);
            eventBus.$off(event.MULTIPLE_FILE_UPLOAD_MSG);
        },
        components: {
            Toolbar,
            Price,
            PDF,
            Modal,
            PrintHeader,
            CompanyFamily,
            PrintFooter,
            VueNumeric,
            MultipleFileUpload
        },
        computed: {
            isLoading() {
                     return this.$store.state[this.axiosParams.module].busy;
            },
            checkDataLoaded(){
                return this.$store.state.checkChangeFormEdit.record.length > 0
            },
            showHidePDF() {
                return this.$store.state[this.axiosParams.module].showHidePDF;
            },
            getTitle() {
                if (this.$store.state[this.axiosParams.module].showHidePDF) {
                    return 'Payments';
                } else {
                    return 'Invoice';
                }
            },
            getTotal() {
                let subTotal = 0;
                let total = 0;
                for (let prod of this.formFields.products) {
                    subTotal += parseFloat(prod.total);
                }
                if (this.formFields.discount > 0) {
                    subTotal = subTotal - parseFloat(this.formFields.discount);
                }
                total = subTotal + parseFloat(this.formFields.tax_amount);
                return [parseFloat(subTotal.toFixed(2)), parseFloat(total.toFixed(2))];
            },
            isUpdatePermitted() {
                let element = document.getElementById('remove-width-style');
                element.classList.add("remove-div-width-for-mobile");
                return this.$store.getters.isPermitted({resource: 'Orders', action: 'update'});
            },
            isCreatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Orders', action: 'create'});
            },
            getTax: function () {
                return parseFloat((this.formFields.sub_total * (this.formFields.tax_rate / 100)).toFixed(2));
            },
            products() {
                let prods = {productsByNumber: [], productsByTitle: []};
                if (Object.keys(this.$store.state[this.axiosParams.module].productList).length > 0) {
                    console.log("here in computed products")
                    this.productsByNumber = this.$store.state[this.axiosParams.module].productList;
                    this.productsByTitle = this.$store.state[this.axiosParams.module].productList;
                }
                return prods;
            },
            invoice() {
                if (this.formFields.invoice == null) {
                    this.formFields.invoice = {invoice_number: 0, payments: [], invoice_total: 0};
                }
                return this.formFields.invoice;
            },
            invoicePayment() {
                let data = {total: 0, paid: 0, remaining: 0};
                data.total = this.invoice.invoice_total;
                for (let payment of this.invoice.payments) {
                    data.paid += +payment.amount;
                }
                data.remaining = data.total - data.paid;
                return {total: data.total, paid: data.paid, remaining: data.remaining};
            },
            family() {
                if (this.formFields.family == null) {
                    this.formFields.family = {id: 0};
                }
                return this.formFields.family;
            },
            companies: function () {
                this.$store.getters.sortByAlphaNumeric({'module': 'company', 'fieldName': 'name'});
                let options = [];
                for (let opt of this.$store.state.company.recordList) {
                    let obj = {value: opt.id, text: opt.name, options: opt};
                    options.push(obj);
                }
                if (this.searchCompany != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchCompany.toUpperCase()) > -1)
                }
                return options;
            },
            orderFormList() {
                this.formsList = this.$store.getters.sortByAlphaNumeric({'fieldName': 'text', 'recordList': this.formsList});
                return this.formsList;
            },
            company() {
                let opt = "Select a company";
                let obj = {};
                if (this.$store.state.company.recordList.length > 0 && this.formFields.company_id != 0 && this.formFields.company_id != null) {
                    obj = this.$store.state.company.recordList.filter(obj => obj.id == this.formFields.company_id);
                    obj = obj[0];
                    opt = Object.keys(obj).length > 0 ? obj.name : opt;// Return object instead of array of object
                }
                return {selectedOpt: opt, data: obj}
            },
            cemeteries: function () {
                this.$store.getters.sortByAlphaNumeric({'module': 'cemetery', 'fieldName': 'company'});
                let options = [];
                for (let opt of this.$store.state.cemetery.recordList) {
                    let obj = {value: opt.id, text: opt.company};
                    options.push(obj);
                }
                if (this.searchCemetery != '') {
                    options = options.filter(obj => obj.text.toUpperCase().indexOf(this.searchCemetery.toUpperCase()) > -1)
                }
                return options;
            },
            cemetery() {
                let opt = "Select a cemetery";
                if (this.$store.state.cemetery.recordList.length > 0 && this.formFields.cemetery_id != 0 && this.formFields.cemetery_id != null) {
                    opt = this.$store.state.cemetery.recordList.filter(obj => obj.id == this.formFields.cemetery_id);
                    if (opt[0])
                        opt = opt[0].company;
                }
                return opt
            },
            orderTypeTitle() {
                let opt = "Select";
                if (this.orderType.length > 0 && this.formFields.order_type_id != 0 && this.formFields.order_type_id != null) {
                    opt = this.orderType.filter(obj => obj.id == this.formFields.order_type_id);
                    opt = opt.length > 0 ? opt[0].type_title : "Select";
                }
                return opt
            },
            orderTypes() {
                let options = [];
                if (this.orderType) {
                    for (let opt of this.orderType) {
                        let obj = {value: opt.id, text: opt.type_title};
                        options.push(obj);
                    }
                    if (this.searchOrderType != '') {
                        options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchOrderType.toUpperCase()) > -1)
                    }
                }
                return options;
            },
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Orders', action: 'read'}))
                this.$router.push('/access-denied');
        },
        mounted() {
            // this.formFields.store_id = this.storeID
            this.isFirstMount = true
            window.isDirty = false
            this.$store.state[this.axiosParams.module].busy = true
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            this.formFields.from_quote = this.$props.quote_to_order_id ? this.$props.quote_to_order_id : null;
            if (!this.$store.getters.isPermitted({resource: 'Orders', action: 'create'}) && !this.$store.getters.isPermitted({resource: 'Orders', action: 'update'}))
                this.$props.hideInModal = true;
            if (this.formFields.id > 0 && !this.$store.getters.isPermitted({resource: 'Orders', action: 'update'}))
                this.hideinAuth = true;
            this.getTotalRecord();
            this.getOrder(this.formFields.id);
            this.getColumns();
            this.getRecords();
            this.$store.getters.detectFormChanges();
        },
        /*beforeRouteLeave(to, from, next) {
            const formFieldsString = JSON.stringify(this.formFields);
            const withoutChangesString = this.$store.state.checkChangeFormEdit.record
            if (formFieldsString == withoutChangesString) {
                this.$store.state.checkChangeFormEdit.record = {}
                next();
            } else {
                if (!confirm('Do you really want to go back without saving?')) {
                    let currentId = this.$props.id ? this.$props.id : 0;
                    if (currentId) {
                        next('/orders/' + currentId);
                    } else {
                        next('/orders');
                    }
                } else {
                    next();
                    this.$store.state.checkChangeFormEdit.record = {}
                }
            }
        },*/
        methods: {
            /** CRUD */

            printPaymentPDF() {
                this.$store.state[this.axiosParams.module].showHidePDF = true;
                setTimeout(() => eventBus.$emit(event.PRINT_PDF), 500);
            },
            changeDateFormat: function (value) {
                return this.$store.getters.changeDateFormat(value);
            },
            changeNumberFormat: function (value) {
                return this.$store.getters.changeNumberFormat(value);
            },
            convertDecimal: function (value) {
                //value = parseFloat(value).toFixed(2);
                return this.$store.getters.changeNumberFormat(value);
            },
            getTotalRecord: function () {
                totalRecords(this.axiosParams, (response) => {
                    this.totalRecord = response.data
                })
            },
            getQuote: async function (id) {
                if (id) {
                    let record = null;
                    this.quoteAxiosParams.id = id;
                    await fetchRecord(this.quoteAxiosParams, (response) => {
                        record = response.data;
                        if (record.cemetery == null) {
                            record.cemetery = {};
                        }
                        if (record != undefined) {
                            let quoteData = {...record};
                            let recordOrder = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == this.formFields.id);
                            if (recordOrder == undefined) {
                                this.family.name_on_stone = quoteData.name_on_stone;
                                this.family.address = quoteData.family_address;
                                this.family.email = quoteData.customer_email;
                                this.family.city = quoteData.family_city;
                                this.family.state = quoteData.family_state;
                                this.family.zip = quoteData.family_zip;
                                this.family.contact = quoteData.family_contact;
                                this.family.phone = quoteData.family_phone;
                                this.formFields.sales_person = quoteData.sales_person;
                                this.formFields.products = quoteData.products;
                                this.formFields.sub_total = quoteData.sub_total;
                                this.formFields.tax_rate = quoteData.tax_rate;
                                this.formFields.discount = quoteData.discount;
                                this.formFields.tax_amount = quoteData.tax_amount;
                                this.formFields.company_id = quoteData.company_id;
                                this.formFields.cemetery_id = quoteData.cemetery_id;
                                this.formFields.is_installation = quoteData.installation;
                            }
                            if (recordOrder != undefined) {
                                this.axiosParams.id = this.formFields.id;
                                fetchRecord(this.axiosParams, (response) => {
                                    this.formFields = response.data;
                                    this.setCurrentRecord();
                                    this.showCompositeProductDetails();
                                }, (error) => {
                                    console.log(error)
                                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                                })
                                // this.formFields = {...recordOrder};
                            }
                            this.setCurrentRecord();
                            this.showCompositeProductDetails();
                        }
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    })
                }
            },
            setDetail(obj, detail) {
                this.formFields[detail + '_id'] = obj.value;
                this.formFields[detail] = obj.text;
            },
            deleteDropDown: function (id) {
                if (confirm('Do you really want to delete this record ?')) {
                    let moduleName = this.axiosParamsOrderType.module;
                    deleteRecord({id: id, module: moduleName}, (response) => {
                        let list = this.orderType;
                        this.spliceRecord(list, id);
                        if (id == this.formFields.order_type_id) {
                            this.formFields.order_type_id = null
                            this.formFields.order_type = null
                        }
                    }, (error) => {
                        this.makeToast({title: 'Error', message: error.message, variant: 'danger'});
                        if (error.response.status)
                            this.makeToast({title: 'Error', message: error.response.statusText, variant: 'danger'});
                    })
                }
            },
            spliceRecord: function (list, id) {
                let record = list.find(obj => obj.id == id);
                let currentIndex = list.indexOf(record);
                list.splice(currentIndex, 1);
            },
            saveDetail: function (detail) {
                let data = {id: 0};
                if (this.searchOrderType) {
                    data[detail] = this.searchOrderType
                    let params = this.axiosParamsOrderType;
                    let formData = new FormData();
                    formData.append('data', JSON.stringify(data));
                    saveRecord(params, formData, (response) => {
                        if (response.data.errorInfo) {
                            let alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                            this.makeToast({title: 'Error', message: alertMessage, variant: 'danger'});
                        } else {
                            this.orderType.splice(this.orderType.length + 1, 0, response.data)
                        }
                    }, (error) => {
                        this.makeToast({title: 'Error', message: error.message, variant: 'danger'});
                        if (error.response.status)
                            this.makeToast({title: 'Error', message: error.response.statusText, variant: 'danger'});
                    })
                }
            },
            getOrderFromDropDown: async function (id) {
                this.axiosParams.id = id;
                await fetchRecord(this.axiosParams, (response) => {
                    this.$store.getters.changedCompositePrice(response.data.products);
                    this.formFields = response.data;
                    this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                    this.invoiceNumber = this.formFields.invoice.invoice_number
                    this.showCompositeProductDetails();
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            getOrder: async function (id) {
                if (id) {
                    this.axiosParams.id = id;
                    await fetchRecord(this.axiosParams, (response) => {
                        this.$store.getters.changedCompositePrice(response.data.products);
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.invoiceNumber = this.formFields.invoice.invoice_number
                        this.showCompositeProductDetails();
                        if (this.$store.state[this.axiosParams.module].recordList.length > 0)
                            this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    })
                }
                if (this.formFields.from_quote) {
                    this.getQuote(this.formFields.from_quote);
                }
                this.$store.dispatch('getCompaniesInfo')
                this.$store.dispatch('getCemeteriesInfo')
                fetchRecords({module: this.axiosParamsOrderType.module}, (response) => {
                    this.orderType = response.data
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.message, variant: 'danger'});
                })
                this.findProducts('byNumber')
                this.findProducts('byTitle')
            },
            storeOrder: function () {
                this.saveDisabled = true;
                let data = this.formFields;
                let products = this.formFields.products;
                products = products.filter(obj => {
                    if (obj.quote_composite_product?.length == 0 || obj.quote_composite_product?.length > 0)
                        obj.order_composite_product = obj.quote_composite_product
                    if ((obj.iscompositeDetails) && (obj.composite[0].composite_products.length > 0) && (obj.order_composite_product.length == 0)) {
                        let compositeProduct = obj.composite[0].composite_products;
                        compositeProduct = compositeProduct.filter(compo => {
                            let price, acutalID, productType = null;
                            let simpleService = [];
                            if (compo.monument.length > 0) {
                                price = compo.monument[0].override_selling_price;
                                acutalID = compo.monument[0].id;
                                productType = 'monument';
                            } else {
                                simpleService = this.$store.getters.productIdPrice(compo);
                                price = simpleService.price;
                                acutalID = simpleService.id;
                                productType = simpleService.type;
                            }
                            let customObj = {
                                id: 0, product_id: obj.id, quantity: compo.quantity,
                                price: price, price_override: price, computer_selling_price: price,
                                [productType]: [{id: acutalID}],
                                installation_price: compo.installation_price, installation: compo.installation,
                            };
                            obj.order_composite_product.push(customObj);
                        });
                    }
                    return obj;
                });
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: message, variant: 'danger'});
                    } else {
                        let message = `Record Successfully ${this.formFields.id ? 'Updated' : 'Added'}`;
                        this.makeToast({title: 'Success', message: message, variant: 'success'});
                        this.formFields = response.data
                        this.showCompositeProductDetails();
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.invoiceNumber = this.formFields.invoice.invoice_number
                        this.axiosParams.data =
                            {
                                id: this.formFields.id,
                                collaboration: {id: this.formFields.collaboration.id, order_id: this.formFields.id},
                                installation: {id: this.formFields.installation.id, order_id: this.formFields.id},
                                invoice: {invoice_number: this.formFields.invoice.invoice_number, order_id: this.formFields.id},
                                production: {id: this.formFields.production.id, order_id: this.formFields.id}
                            };
                        this.$store.commit('appendOrUpdateDropDown', this.axiosParams)
                        if (this.$store.state[this.axiosUserFamilyParams.module].userFamilies.length == 0) {
                            this.$store.dispatch('getUserFamiliesInfo', this.axiosUserFamilyParams);
                        } else {
                            this.axiosUserFamilyParams.data = response.data.family;
                            this.$store.commit('appendOrUpdateInUserFamilyList', this.axiosUserFamilyParams);
                        }
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
                            if (this.$store.state[this.axiosParams.module].recordList.length == 0)
                                this.clearForm();
                            else
                                this.first();
                        } else {
                            console.log(response.data);
                        }
                    }, (error) => {
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
            handleDropdownChange: function(value){
                window.detectChanges = true;
            },

            /** Products*/
            findProducts: function (type = 'byNumber') {
                if (this.cancelRequest) {
                    this.requestCancel();
                }
                this.makeSearchProducts(type)
            },
            makeSearchProducts: async function(type){
                let axiosSource = null;
                if (!this.isFirstTime){
                     axiosSource = axios.CancelToken.source();
                    this.cancelRequest = {cancel: axiosSource.cancel, message: 'request is cancel'}
                }
                let keywords = type == 'byNumber' ? this.searchByNumber : this.searchByTitle;
                let formData = new FormData();
                formData.append('keywords', keywords);
                formData.append('type', type);
                const url = '/api/order/searchProducts';
                axios.post(url, formData, {cancelToken: axiosSource?.token })
                    .then(response => {
                        type == 'byNumber' ? this.productsByNumber = response.data : this.productsByTitle = response.data;
                        if (type == 'byNumber') {
                            this.allProductsByNumber = []
                            this.allProductsByNumber = this.allProductsByNumber.concat(this.productsByNumber.monument)
                            this.allProductsByNumber = this.allProductsByNumber.concat(this.productsByNumber.service)
                            this.allProductsByNumber = this.allProductsByNumber.concat(this.productsByNumber.simple)
                            this.allProductsByNumber = this.allProductsByNumber.concat(this.productsByNumber.composite)
                            this.allProductsByNumber = this.allProductsByNumber.filter(obj => obj != 'No record found')
                            this.$store.getters.sortByAlphaNumeric({'fieldName': 'product_number', 'recordList': this.allProductsByNumber})
                        } else {
                            this.allProductsByTitle = []
                            this.allProductsByTitle = this.allProductsByTitle.concat(this.productsByTitle.monument)
                            this.allProductsByTitle = this.allProductsByTitle.concat(this.productsByTitle.service)
                            this.allProductsByTitle = this.allProductsByTitle.concat(this.productsByTitle.simple)
                            this.allProductsByTitle = this.allProductsByTitle.concat(this.productsByTitle.composite)
                            this.allProductsByTitle = this.allProductsByTitle.filter(obj => obj != 'No record found')
                            this.$store.getters.sortByAlphaNumeric({'fieldName': 'item_name', 'recordList': this.allProductsByTitle})
                        }
                         this.requestCancel()
                        this.isFirstTime = false
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },
            requestCancel(){
                this.cancelRequest?.cancel()
                this.cancelRequest = null
            },
            calculateOverideAndSubTotal: function (prod, getPercent) {
                return new Promise(function (resolve, reject) {
                    let overridePrice = 0, subTotal = 0;
                    let index = null
                    for (let compo of prod.composite_products) {
                        index = prod.composite_products.indexOf(compo);
                        if (compo.monument && compo.monument.length > 0) {
                            compo.installation_price = compo.monument[0].installation != null ? compo.monument[0].installation.installation_amount : compo.installation_price;
                            overridePrice += parseFloat(compo.monument[0].override_selling_price) * compo.quantity;
                            subTotal += parseFloat(compo.monument[0].override_selling_price) ? parseFloat(compo.monument[0].override_selling_price) * compo.quantity : 0;
                        } else {
                            let productPrice = store.getters.getSimpleAndServicePrice(compo);
                            overridePrice += parseFloat(productPrice.price) * compo.quantity;
                        }
                    }
                    if (index === prod.composite_products.length - 1) {
                        overridePrice = parseFloat(overridePrice.toFixed(2));
                        subTotal = store.getters.calculatePercentage({'overridePrice': overridePrice, 'getPercent': getPercent});
                        subTotal = overridePrice + (subTotal);
                        subTotal = parseFloat(subTotal.toFixed(2));
                        resolve(subTotal)
                    }
                })
            },
            calculateTotalExecuation: function (data) {
                let totalLoopCount = 0
                data.composite.filter(obj => {
                    totalLoopCount++
                    if (obj.composite_products.length)
                        totalLoopCount += obj.composite_products.length
                    return totalLoopCount
                });
                return totalLoopCount
            },
            calculateRetailPrice: function (data) {
                return new Promise((async (resolve, reject) => {
                    if (data.composite != "No record found") {
                        // let  getPercent = null, subTotal = 0, productNumber = null;
                        let overridePrice = 0, subTotal = 0, getPercent = null, productNumber = null;
                        let totalExecution = this.calculateTotalExecuation(data);
                        let countExecution = 0
                        for (let prod of data.composite) {
                            let index = data.composite.indexOf(prod);
                            productNumber = prod.product_number;
                            getPercent = prod.percentage;
                            getPercent = parseFloat(getPercent);
                            if (prod.composite_products.length > 0) {
                                subTotal = await this.calculateOverideAndSubTotal(prod, getPercent);
                                countExecution += prod.composite_products.length
                                /*for (let compo of prod.composite_products) {
                                    if (compo.monument && compo.monument.length > 0) {
                                        compo.installation_price = compo.monument[0].installation != null ? compo.monument[0].installation.installation_amount : compo.installation_price;
                                        overridePrice += parseFloat(compo.monument[0].override_selling_price) * compo.quantity;
                                        subTotal += parseFloat(compo.monument[0].override_selling_price) ? parseFloat(compo.monument[0].override_selling_price) * compo.quantity : 0;
                                    } else {
                                        let productPrice = this.$store.getters.getSimpleAndServicePrice(compo);
                                        overridePrice += parseFloat(productPrice.price) * compo.quantity;
                                    }
                                    countExecution++
                                }
                                overridePrice = parseFloat(overridePrice.toFixed(2));
                                subTotal = this.$store.getters.calculatePercentage({'overridePrice': overridePrice, 'getPercent': getPercent});
                                subTotal = overridePrice + (subTotal);
                                subTotal = parseFloat(subTotal.toFixed(2));*/
                            }
                            prod.retail_price = subTotal;
                            overridePrice = 0;
                            subTotal = 0;
                            countExecution++
                        }
                        if (countExecution === totalExecution) {
                            setTimeout(() => {
                                resolve(data);
                            }, [1000])
                        }
                    }
                }))
            },
            addProduct: function (obj, type) {
                window.detectChanges = true;
                let exists = this.formFields.products.includes(obj)
                let price = 0, compositeObj = [], iscompositeDetails = false;
                if (type == 'monument') {
                    price = obj.override_selling_price;
                } else if (type == 'simple' || type == 'service') {
                    price = obj.override_selling_price ? obj.override_selling_price : 0;
                } else {
                    price = obj.retail_price;
                }
                let installationAmount = obj.installation ? obj.installation.installation_amount : 0;
                if (type == 'composite') {
                    installationAmount = obj.install_price;
                    compositeObj.push(obj);
                }
                if (obj.composite_products && obj.composite_products.length > 0) {
                    let recordList = [];
                    recordList.push(obj)
                    this.$store.getters.getInstallationPrice(recordList);
                    installationAmount = obj.install_price;
                    iscompositeDetails = true;
                }
                if (!exists) {
                    let customObj = {
                        [type]: [{id: obj.id, product_number: obj.product_number, item_name: obj.item_name}],
                        id: 0,
                        quantity: 1,
                        price: price,
                        client_price: price,
                        amount: 0,
                        installation_price: installationAmount,
                        total: 0,
                        composite: compositeObj,
                        order_composite_product: [],
                        iscompositeDetails: iscompositeDetails,
                        _showDetails: iscompositeDetails
                    };
                    this.formFields.products.push(customObj)
                }
            },
            addNonStockingProduct: function () {
                let obj = {
                    non_stock_product: [{id: 0, product_number: '', item_name: ''}],
                    id: 0,
                    quantity: 0,
                    price: 0,
                    client_price: 0,
                    amount: 0,
                    installation_price: 0,
                    total: 0
                };
                this.formFields.products.splice(this.formFields.products.length, 0, obj);
            },
            removeProduct: function (index, id) {
                this.formFields.products.splice(index, 1);
                if (id) {
                    let params = {module: this.axiosParams.module + '/deleteProduct/', id: id};
                    deleteProduct(params, (response) => {
                        console.log(response)
                    })
                }
            },

            /**
             * Invoice
             * */
            addPayment() {
                if (this.paymentUpdate.amount) {
                    let data = this.paymentUpdate;
                    data.order = this.formFields.id;
                    let formData = new FormData();
                    formData.append('data', JSON.stringify(data));
                    savePayment(formData, (response) => {
                        if (!data.id) {
                            this.formFields.invoice.payments.splice(this.formFields.invoice.payments.length + 1, 0, response.data);
                        } else {
                            this.formFields.invoice.payments.splice(this.formFields.invoice.payments.findIndex(obj => obj.id == response.data.id), 1, response.data);
                        }
                        this.payment = {id: 0};
                        this.paymentUpdate = {id: 0};
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    });
                }
            },
            cancelPayment() {
                this.payment = {id: 0};
                this.paymentUpdate = {id: 0};
            },
            newPayment() {
                this.payment = {id: 0};
                this.paymentUpdate = {id: 0};
            },
            updatePayment: function (id) {
                let record = this.formFields.invoice.payments.find(obj => obj.id == id);
                this.payment = {...record};
                this.paymentUpdate = {...record};
            },

            /** Select List */
            setCompany(obj) {
                this.formFields.company_id = obj.value;
                this.formFields.company = obj.options;
            },
            addCemetery(name) {
                let data = {
                    id: 0, company: name, regulation: [],
                    // store_id: this.storeID
                };
                let formData = new FormData();
                let params = {module: 'cemetery'};
                formData.append('data', JSON.stringify(data));
                saveRecord(params, formData, (response) => {
                    this.$store.dispatch('getCemeteriesInfo')
                })
            },

            /** Pagination*/
            first: function () {
                this.$store.state[this.axiosParams.module].busy = true
                firstRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.$store.getters.changedCompositePrice(response.data.products);
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.invoiceNumber = this.formFields.invoice.invoice_number
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            last: function () {
                this.$store.state[this.axiosParams.module].busy = true
                lastRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.$store.getters.changedCompositePrice(response.data.products);
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.invoiceNumber = this.formFields.invoice.invoice_number
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            next: function (id) {
                this.$store.state[this.axiosParams.module].busy = true
                this.axiosParams.id = id;
                nextRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.$store.getters.changedCompositePrice(response.data.products);
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.invoiceNumber = this.formFields.invoice.invoice_number
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            prev: function (id) {
                this.$store.state[this.axiosParams.module].busy = true
                this.axiosParams.id = id;
                previousRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.$store.getters.changedCompositePrice(response.data.products);
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.invoiceNumber = this.formFields.invoice.invoice_number
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },

            /** Generic*/
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
            taxRate() {
                if (this.formFields.tax_rate == '')
                    this.formFields.tax_rate = '0.00';
                return this.formFields.tax_rate;
            },
            discount() {
                if (this.formFields.discount == '')
                    this.formFields.discount = 0;
                return this.formFields.discount;
            },
            clearForm: function () {
                if (window.detectChanges && !confirm('You have unsaved changes. Are you sure you want to navigate away?')) {
                    this.$store.state[this.axiosParams.module].busy = false
                } else {
                    window.detectChanges = false;
                }
                if (!window.detectChanges) {
                    this.formFields = {
                        // store_id: this.storeID,
                        id: 0, sub_total: 0, tax_rate: 0, tax_amount: 0, discount: 0,
                        company_id: 0, cemetery_id: null, family: null, invoice: null,
                        production: {id: 0}, installation: {id: 0}, collaboration: {id: 0},
                        accounting: {id: 0}, correspondence: null,
                        cemetery: {id: 0, company: "", gps: "", city: {}, county: {}, state: {}},
                        products: [], order_type_id: null,
                    };
                    this.$store.state.checkChangeFormEdit.record = {}
                    this.searchCompany = ""
                    this.searchCemetery = ""
                    this.$store.state[this.axiosParams.module].currentRecord = []
                }
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
            async showCompositeProductDetails() {
                for (let item of this.formFields.products) {
                    let index = this.formFields.products.indexOf(item);
                    item.iscompositeDetails = false;
                    //item['_showDetails'] = false;
                    if (item.composite && item.composite.length > 0)
                        if (item.composite[0].composite_products && item.composite[0].composite_products.length > 0) {
                            item.iscompositeDetails = true;
                            let retailPrice = await this.calculateRetailPrice(item);
                            item.price = retailPrice.composite[0].retail_price;
                            //this.$set(item, "_showDetails", !item._showDetails);
                        }
                    if (index === this.formFields.products.length - 1 && !this.hideInModal) {
                        this.$store.commit('setCurrentFormData', JSON.stringify(this.formFields))
                    }
                }
            },
            toggleCompositeProduct: function (toggle) {
                for (let item of this.formFields.products) {
                    if (item.composite && item.composite.length > 0)
                        if (item.composite[0].composite_products && item.composite[0].composite_products.length > 0) {
                            this.$set(item, "_showDetails", toggle);
                        }
                }
            },
            checkDate: function (date) {
                return searchForEmptyDate(date);
            },
        },
        directives: {
            removeZero: {
                bind: function (element, binding, vnode) {
                    element.onfocus = function () {
                        if (parseFloat(element.value) === 0) {
                            element.value = null;
                        }
                    };
                },
            },
        },
        watch: {
            formFields: {
                handler() {
                    if (!this.isLoading && !this.isFirstMount) {
                        window.isDirty = true
                    }
                },
                deep: true,
                immediate: true,
            },
            'formFields.tax_rate'(newValue, oldValue) {
                if (newValue == '' || newValue == 0) {
                    this.formFields.tax_rate = '0.00'
                }
            },
        }
    }
</script>

<style scoped>

    .loading-data {
        background: transparent url('https://miro.medium.com/max/882/1*9EBHIOzhE1XfMYoKz1JcsQ.gif') center no-repeat;
    }

    .printing {
        font-family: Roboto;
        padding: 3em;
        margin: 2em auto;
        font-size: 1.5em;
    }

    .custom-row {
        display: flex;
        padding: 0.3rem;
    }

    .custom-row div {
        display: flex;
        margin: 0 0.2rem;
    }

    .custom-row div label {
        margin: auto 0.3rem;
        white-space: nowrap !important;
    }

    .custom-row div input, textarea, .input-date {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.75rem;
    }

    .input-date {
        min-width: 8rem;
    }

    .family-col {
        width: 5rem;
    }

    hr {
        margin: 0;
    }

    header {
        padding: 0 3rem;
    }

    .input-product {
        width: 250px;
    }

    .product-table {
        font-size: 0.8rem;
    }

    .product-color {
        color: #6C757D;
    }

    .dropdown-header {
        font-weight: bold;
    }

    .input-xxl {
        width: 18rem;
    }

    .input-xl {
        width: 60%;
    }

    .input-lg {
        width: 10rem;
    }

    .input-md {
        width: 7rem;
    }

    .input-xsmall {
        width: 4rem;
    }

    .input-sm {
        width: 45%;
    }

    .input-select {
        width: 100%;
    }

    .vertical-line {
        border-right: 1px solid #cccccc;
        padding-right: 2%;
    }

    .product-table-width {
        min-width: 71.1% !important;
        max-width: 71.1% !important;
    }

    .payment-table-width {
        min-width: 29.1% !important;
        max-width: 29.1% !important;
    }

    .custom-btn {
        box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.25);
        border-radius: 5px;
        width: 111px;
        height: 26px;
        font-size: 12px;
        letter-spacing: 0.02em;
    }

    .order-form-btn {
        font-size: 0.5rem;
    }

    .border {
        border: 1px solid #c4c4c4 !important;
    }

    .custom-margin-total {
        margin-right: -15px !important;
    }

    .label-total {
        margin-left: 0.0rem !important;
    }

    .input-group-prepend {
        margin-top: 0px !important;
    }

    .order-email-width {
        width: 12rem;
    }

    .th-text-align-center {
        text-align: center;
    }

    .input-field-margin {
        margin-left: 15px !important;
    }

    .customer-input-field-margin {
        margin-left: 16px !important;
    }

    .input-field-width {
        width: 303px !important;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
    }
</style>
