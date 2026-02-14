<template>
    <div>
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Accounting</h5>
            <div class="bg-toolbar my-2 p-1">
                <Toolbar :id="formFields.id" :saveDisabled="saveDisabled"></Toolbar>
            </div>
        </div>
        <div id="accounting">
            <div class="col-md-12">

                <div v-bind:class="[alertClasses, 'd-flex justify-content-center m-auto p-1 w-50']">{{alertMessage}}</div>
                <form id="accounting-form">
                    <template v-if="isLoading">
                        <div class="text-center text-info my-2">
                            <b-spinner class="align-middle"></b-spinner>
                            <strong>Loading...</strong>
                        </div>
                    </template>
                    <template v-else>
                        <div class="div-shadow bg-white rounded p-2 mb-2">
                            <div>
                                <h5 class="mx-1 custom-form-heading">Accounting</h5>
                            </div>
                            <div class="accounting-row">
                                <div>
                                    <label>Material</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" name="material" size="sm" type="text" v-model="formFields.material"></b-form-input>
                                </div>
                                <div>
                                    <label>Material Installation <br> Labour Cemt.</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" name="material_installation_labour_cemt" size="sm" type="text" v-model="formFields.material_installation_labour_cemt"></b-form-input>
                                </div>
                                <div>
                                    <label>Dealer/Comm.</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" name="dealer" size="sm" type="text" v-model="formFields.dealer"></b-form-input>
                                </div>
                                <div>
                                    <label>Material Shipping</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" name="material_shipping" size="sm" type="text" v-model="formFields.material_shipping"></b-form-input>
                                </div>
                                <div>
                                    <label>Total Material</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" name="total_material" size="sm" type="text" v-model="formFields.total_material"></b-form-input>
                                </div>
                            </div>
                            <div class="accounting-row">
                                <div>
                                    <label class="mr-4">O&E</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" class="ml-1" name="o_e" size="sm" type="text" v-model="formFields.o_e"></b-form-input>
                                </div>
                                <div>
                                    <label class="mr-4">O&E Labour Shop <br> & Install</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" name="o_e_labour_shop_install" size="sm" type="text" v-model="formFields.o_e_labour_shop_install"></b-form-input>
                                </div>
                                <div>
                                    <label class="mr-4">Total O&E</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" class="ml-2" name="total_o_e" size="sm" type="text" v-model="formFields.total_o_e"></b-form-input>
                                </div>
                            </div>
                            <div class="col-md-12 border w-100"></div>
                            <!--<div class="form-group col-md-12 row no-gutters">
                                <div class="col-md-5">
                                    <table class="table table-sm table-striped table-bordered mt-3 ">
                                        <thead class="custom-table-header">
                                        <tr>
                                            <th>Date</th>
                                            <th>Material Exp.</th>
                                            <th>O&E Exp.</th>
                                            <th>Eq. Maintainence</th>
                                            <th>Tax</th>
                                        </tr>
                                        </thead>
                                        <tbody class="custom-table-body">
                                        <tr>
                                            <td>10/17/2019</td>
                                            <td>$792.00</td>
                                            <td>$1331.00</td>
                                            <td>$1267.88</td>
                                            <td>$37.30</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>-->
                            <div class="custom-row">
                                <div>
                                    <label>Invoice No.</label>
                                    <b-form-input :value="invoice.invoice_number" class="input-md" name="invoice_number"
                                                  readonly size="sm" type="text"></b-form-input>
                                </div>
                                <div>
                                    <label>Order Date</label>
                                    <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                                       @input="order.date = checkDate(order.date)"
                                                       class="my-auto input-date" close-button disabled
                                                       locale="en"
                                                       name="date"
                                                       placeholder=""
                                                       reset-button
                                                       size="sm"
                                                       today-button
                                                       v-model="order.date">
                                    </b-form-datepicker>
                                </div>
                                <div>
                                    <label>PO.</label>
                                    <b-form-input :value="order.po" class="input-lg " disabled name="po" size="sm"
                                                  type="text"></b-form-input>
                                </div>
                            </div>
                            <hr class="border">
                            <div class="custom-row">
                                <div class="d-block custom-border-right py-2 my-n1 pr-3" style="width:40%">
                                    <div>
                                        <h6 class="m-0 custom-form-heading">Company Information</h6>
                                    </div>
                                    <b-dropdown class="border rounded my-1 w-75 dropdown-width" disabled no-caret size="sm" toggle-class=""
                                                variant="none">
                                        <template #button-content>
                                            <div class="d-flex product-color">
                                                <small>{{company.selectedOpt}}</small>
                                                <i aria-hidden="true" class="fa fa-caret-down ml-auto"></i>
                                            </div>
                                        </template>
                                        <b-dropdown-group class="overflow-auto scroll px-1">
                                            <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        </b-dropdown-group>
                                    </b-dropdown>
                                    <div class="mt-2 ml-0">
                                        <label class="w-15">Name</label>
                                        <div class="flex-grow-1">
                                            <b-form-input :value="company.data.name" class="ml-0 w-75 bg-order" disabled
                                                          size="sm" type="text"></b-form-input>
                                        </div>
                                    </div>
                                    <div class="mt-2 ml-0">
                                        <label class="w-15">Address</label>
                                        <div class="flex-grow-1">
                                            <b-form-input class="ml-0 w-75 bg-order" disabled
                                                          size="sm" type="text" v-model="company.data.address"></b-form-input>
                                        </div>
                                    </div>
                                    <div class="mt-2 ml-0">
                                        <label class="w-15">City</label>
                                        <b-form-input :value="company.data.city" class="ml-1 w-50 bg-order"
                                                      disabled size="sm" type="text"></b-form-input>
                                        <label>State</label>
                                        <b-form-input :value="company.data.state" class="w-50 input-sm bg-order"
                                                      disabled size="sm" type="text"></b-form-input>
                                        <label>Zip</label>
                                        <b-form-input :value="company.data.zip" class="input-sm w-25 bg-order"
                                                      disabled size="sm" type="text"></b-form-input>
                                    </div>
                                    <div class="mt-2 ml-0">
                                        <label class="w-15">Contact </label>
                                        <b-form-input :value="company.data.contact" class="ml-1 w-75 bg-order"
                                                      disabled size="sm" type="text"></b-form-input>
                                        <label>Phone</label>
                                        <b-form-input :value="company.data.phone" class="mr-0 bg-order"
                                                      disabled size="sm" type="text"></b-form-input>
                                    </div>
                                    <div class="mt-2 ml-0">
                                        <label class="w-15">Email</label>
                                        <div class="flex-grow-1">
                                            <b-form-input :value="company.data.email"
                                                          class="ml-0 w-75 bg-order" disabled size="sm" type="email"></b-form-input>
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
                                            <b-form-input :value="family.name_on_stone" class="ml-0 w-75" disabled
                                                          name="name_on_stone" size="sm" type="text"
                                            ></b-form-input>
                                        </div>
                                    </div>
                                    <div class="mt-2 ml-0">
                                        <div class="w-25">
                                            <label>Address</label>
                                        </div>
                                        <div class="flex-grow-1">
                                            <b-form-input :value="family.address" class="ml-0 w-75" disabled
                                                          name="family_address" size="sm" type="text"></b-form-input>
                                        </div>
                                    </div>
                                    <div class="mt-2 ml-0">
                                        <div class="w-50">
                                            <label>City</label>
                                        </div>
                                        <b-form-input :value="family.city" class="input-field-margin w-75" disabled name="family_city"
                                                      size="sm" type="text"></b-form-input>

                                        <label>State</label>
                                        <b-form-input :value="family.state" class="input-sm w-75" disabled name="family_state"
                                                      size="sm" type="text"></b-form-input>

                                        <label>Zip</label>
                                        <b-form-input :value="family.zip" class="input-sm was-validated" disabled name="family_zip"
                                                      size="sm" type="text"></b-form-input>

                                    </div>
                                    <div class="mt-2 ml-0">
                                        <div class="w-75">
                                            <label>Customer Contact</label>
                                        </div>
                                        <b-form-input :value="family.contact" class="w-75" disabled name="family_contact"
                                                      size="sm" type="text"></b-form-input>
                                        <label>Phone</label>
                                        <b-form-input :value="family.phone" class="mr-0 " disabled name="family_phone"
                                                      size="sm" type="text"></b-form-input>
                                    </div>
                                    <div class="mt-2 ml-0">
                                        <div class="w-25">
                                            <label>Email</label>
                                        </div>
                                        <div class="flex-grow-1">
                                            <b-form-input :value="family.email" class="ml-0 w-75" disabled
                                                          name="family_address" size="sm" type="text"></b-form-input>
                                        </div>
                                    </div>
                                    <div class="mt-2 ml-0">
                                        <div class="w-25">
                                            <label>Update Customer via</label>
                                        </div>
                                        <div class="flex-grow-1">
                                            <b-form-group class="m-0 my-auto custom-radio-and-checkbox">
                                                <b-form-radio-group disabled name="update-customer" v-model="family.update_customer">
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
                                        <!--<b-form-input :value="order.order_type" class="input-xl mr-0 " disabled name="order_type"
                                                      size="sm" type="text"></b-form-input>-->
                                        <b-dropdown class="border dropdown-width rounded ml-auto" disabled no-caret size="sm" style="width: 14.5rem; background-color: #e9ecef;opacity: 1;"
                                                    variant="none">
                                            <template #button-content>
                                                <div class="d-flex product-color">
                                                    <small :class="orderTypeTitle == 'Select' ? 'invisible' : '' "
                                                           class="overflow-hidden">{{orderTypeTitle}}</small>
                                                    <small class="w-25 ml-auto custom-caret"></small>
                                                </div>
                                            </template>
                                            <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                            </b-dropdown-group>
                                        </b-dropdown>
                                    </div>
                                    <div class="mt-2 ml-0">
                                        <label>Inv. Closed Date</label>
                                        <b-form-datepicker
                                            :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                            @input="invoice.closed_date = checkDate(invoice.closed_date)"
                                            class="input-xl ml-auto mr-0 input-date"
                                            close-button
                                            disabled
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
                                        <b-form-input :value="invoice.original_invoice_number" class="input-xl mr-0 " disabled
                                                      name="invoice_original_number" size="sm" type="text"
                                        ></b-form-input>
                                    </div>
                                    <div class="mt-2 ml-0">
                                        <label>Ship/Invoice Date</label>
                                        <b-form-datepicker
                                            :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                            @input="invoice.ship_date = checkDate(invoice.ship_date)"
                                            class="input-xl ml-auto mr-0 input-date"
                                            close-button
                                            disabled
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
                                        <b-form-input :value="order.sales_person" class="input-xl mr-0 " disabled name="sales_person" size="sm"
                                                      type="text"></b-form-input>
                                    </div>
                                    <div class="mt-2 ml-0">
                                        <label>Date Promised</label>
                                        <b-form-datepicker
                                            :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                            @input="invoice.date_promised = checkDate(invoice.date_promised)"
                                            class="input-xl ml-auto mr-0 input-date"
                                            close-button
                                            disabled
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
                                    <b-table :fields="productTableFields" :items="formFields.order?.products" bordered
                                             class="small"
                                             responsive
                                             small>

                                        <template #cell(product_number)="row">

                                            <template
                                                v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
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
                                            <template
                                                v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
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
                                            <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                                <label class="d-none">{{row.item.client_price > row.item.price ? row.item.client_price : row.item.client_price = row.item.price}}</label>
                                                <label class="d-flex product-table">$ {{ changeNumberFormat(row.item.client_price) ?
                                                    changeNumberFormat(row.item.client_price) : '0.00' }}</label>
                                            </template>
                                            <template v-else>
                                                <label class="d-flex product-table">$ {{ changeNumberFormat(row.item.client_price) ?
                                                    changeNumberFormat(row.item.client_price) : '0.00' }}</label>
                                            </template>
                                        </template>

                                        <template v-slot:cell(amount)="row">
                                            <label class="d-none">$ {{ row.item.amount =
                                                Math.abs((row.item.quantity*row.item.client_price)).toFixed(2) }}</label>
                                            <label class="">$ {{ changeNumberFormat(row.item.amount) ? changeNumberFormat(row.item.amount) : '0.00' }}</label>
                                            <input :value="row.item.amount" disabled name="amount" type="hidden">
                                        </template>

                                        <template v-slot:cell(installation_price)="row">
                                            <label class="d-flex product-table">$ {{ changeNumberFormat(row.item.installation_price) ?
                                                changeNumberFormat(row.item.installation_price) : '0.00' }}</label>
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
                                            <input :value="row.item.total" disabled name="total" type="hidden">
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
                                            <b-card no-body>
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
                                    <div class="custom-row justify-content-end custom-margin-total">
                                        <div class="flex-column mr-0">
                                            <label class="label-total">Discount</label>
                                            <Price :readonly="true" class="input-total" min="0" name="discount" size="sm" type="number"
                                                   v-model="formFields.order.discount" v-remove-zero></Price>
                                        </div>
                                        <div class="flex-column mr-0">
                                            <label class="label-total">Sub Total</label>
                                            <Price :classes="'input-total'" :readonly="true"
                                                   v-model="formFields.order.sub_total"></Price>
                                        </div>
                                        <div class="flex-column mr-n1">
                                            <label class="ml-2">Tax Rate</label>
                                            <b-input-group class="input-tax-group" prepend="%" size="sm">
                                                <b-form-input class="col-8 ml-n2 input-total margin-top-2 mx-2" disabled min="0" name="tax_rate" size="sm" type="number"
                                                              v-model="formFields.order.tax_rate" v-remove-zero></b-form-input>
                                            </b-input-group>
                                        </div>
                                        <div class="flex-column">
                                            <label class="label-total">Tax Amount</label>
                                            <Price :classes="'input-total'" :disable="hideInModal || hideinAuth" :readonly="true"
                                                   v-model="formFields.order.tax_amount"></Price>
                                        </div>
                                        <div class="flex-column">
                                            <label class="label-total">Invoice Total</label>
                                            <Price :classes="'input-total'" :disable="hideInModal || hideinAuth" :readonly="true"
                                                   v-model="invoice.invoice_total"></Price>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block custom-border-left ml-3 mt-n2 w-100">
                                    <div class="mt-2">
                                        <h6 class="custom-form-heading ml-1">Payments</h6>
                                    </div>
                                    <div class="custom-row m-0 flex-column">
                                        <div class="justify-content-center px-2">
                                            <table class="table table-sm table-striped table-bordered small">
                                                <thead>
                                                <th>Pay Date</th>
                                                <th>Amount</th>
                                                <th>Type</th>
                                                </thead>
                                                <tbody>
                                                <template v-if="invoice.payments.length > 0">
                                                    <template v-for="row of invoice.payments">
                                                        <tr>
                                                            <td>{{ changeDateFormat(row.date) }}</td>
                                                            <td>$ {{ convertDecimal(row.amount) }}</td>
                                                            <td>{{row.type}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">{{row.details}}</td>
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
                                    </div>
                                </div>
                            </div>
                            <hr class="border">
                            <div class="custom-row">
                                <div class="my-4">
                                    <label>Cemetery</label>
                                    <b-dropdown class="border rounded input-select" disabled no-caret size="sm" toggle-class=""
                                                variant="none">
                                        <template #button-content>
                                            <div class="d-flex product-color">
                                                <small>{{cemetery}}</small>
                                                <i aria-hidden="true" class="fa fa-caret-down ml-auto"></i>
                                            </div>
                                        </template>
                                        <b-dropdown-group class="overflow-auto scroll px-1">
                                            <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        </b-dropdown-group>
                                    </b-dropdown>
                                </div>
                                <div class="my-4">
                                    <label>Installation</label>
                                    <b-form-group class="m-0 my-auto custom-radio-and-checkbox">
                                        <b-form-radio-group disabled name="installation"
                                                            v-model="order.is_installation">
                                            <b-form-radio name="installation-radio" size="sm" value="1">Yes</b-form-radio>
                                            <b-form-radio name="installation-radio" size="sm" value="0">No</b-form-radio>
                                        </b-form-radio-group>
                                    </b-form-group>
                                </div>
                            </div>
                        </div>
                    </template>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import {event, eventBus} from '../../event-bus/event-bus';
    import Toolbar from "./Toolbar";
    import Price from "../../Modules/Price";
    import {deleteRecord, fetchRecord, firstRecord, lastRecord, nextRecord, previousRecord, saveRecord} from "../../helpers/axios";
    import {searchForEmptyDate} from "../../helpers/common";

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
                formFields: {
                    id: null,
                    material: null,
                    material_installation_labour_cemt: null,
                    dealer: null,
                    material_shipping: null,
                    total_material: null,
                    o_e: null,
                    o_e_labour_shop_install: null,
                    total_o_e: null,
                    order: {
                        family: null,
                        invoice: {invoice_number: 0, payments: [], invoice_total: 0},
                        products: [],
                        sub_total: 0,
                        tax_rate: 0,
                        tax_amount: 0,
                        discount: 0,
                    },
                },
                productTableFields: [
                    {key: 'product_number', label: "Product #", class: 'text-center text-nowrap'},
                    {key: 'item_name', label: "Product Name", class: 'text-center'},
                    {key: 'quantity', label: "Qty", class: 'text-center'},
                    {key: 'client_price', label: "Client Price", class: 'text-nowrap'},
                    {key: 'amount', label: "Amount"},
                    {key: 'installation_price', label: "Install"},
                    {key: 'installation_amount', label: "Install Amount", thClass: 'text-nowrap'},
                    {key: 'total', label: "Total", class: 'text-center'},
                    {key: "showProducts", label: "Details"},
                ],
                axiosParams: {module: 'accounting'},
                alertMessage: '',
                hideAlert: true,
                successResponse: false,
                errorResponse: false,
                saveDisabled: false,
                hideinAuth: false,
            }
        },
        metaInfo() {
            return {
                title: `${this.formFields.id ? 'Edit' : 'Add'} Accounting`,
            }
        },
        created() {
            eventBus.$on(event.SAVE_ACCOUNTING, this.storeAccount);
            eventBus.$on(event.FIRST_ACCOUNTING_RECORD, this.first);
            eventBus.$on(event.LAST_ACCOUNTING_RECORD, this.last);
            eventBus.$on(event.NEXT_ACCOUNTING_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_ACCOUNTING_RECORD, this.prev);
            eventBus.$on(event.GET_ACCOUNTING, this.getAccount);
            eventBus.$on(event.ADD_ACCOUNTING, this.clearForm);
            eventBus.$on(event.DELETE_ACCOUNTING, this.deleteRecord);
        },
        destroyed() {
            eventBus.$off(event.SAVE_ACCOUNTING, this.storeAccount);
            eventBus.$off(event.FIRST_ACCOUNTING_RECORD, this.first);
            eventBus.$off(event.LAST_ACCOUNTING_RECORD, this.last);
            eventBus.$off(event.NEXT_ACCOUNTING_RECORD, this.next);
            eventBus.$off(event.PREVIOUS_ACCOUNTING_RECORD, this.prev);
            eventBus.$off(event.GET_ACCOUNTING, this.getAccount);
            eventBus.$off(event.ADD_ACCOUNTING, this.clearForm);
            eventBus.$off(event.DELETE_ACCOUNTING, this.deleteRecord);
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
            invoicePayment() {
                let data = {total: 0, paid: 0, remaining: 0};
                data.total = this.formFields.order.invoice.invoice_total;
                for (let payment of this.formFields.order.invoice.payments) {
                    data.paid += +payment.amount;
                }
                data.remaining = data.total - data.paid;
                return {total: data.total, paid: data.paid, remaining: data.remaining};
            },
            order() {
                if (this.formFields.order == null) {
                    this.formFields.order = {
                        invoice: {invoice_number: 0, invoice_total: 0, payments: []}, company: {}, family: {}, products: [], collaboration: {tasks: []},
                        correspondence: {tasks: []}, discount: 0, sub_total: 0, tax_rate: 0, tax_amount: 0,
                    };
                }
                return this.formFields.order
            },
            invoice() {
                if (this.formFields.order.invoice == null) {
                    this.formFields.order.invoice = {invoice_number: 0, payments: [], invoice_total: 0};
                }
                return this.formFields.order.invoice;
            },
            family() {
                if (this.formFields.order.family == null) {
                    this.formFields.order.family = {id: 0};
                }
                return this.formFields.order.family;
            },
            company() {
                let opt = "Select a company";
                let obj = {};
                if (this.formFields.order.company_id != 0 && this.formFields.order.company_id != null) {
                    obj = this.formFields.order.company;
                    opt = Object.keys(obj).length > 0 ? obj.name : opt;
                }
                return {selectedOpt: opt, data: obj}
            },
            cemetery() {
                let opt = "Select a cemetery";
                if (this.formFields.order.cemetery_id != 0 && this.formFields.order.cemetery_id != null) {
                    opt = this.formFields.order.cemetery;
                    opt = Object.keys(opt).length > 0 ? opt.company : 'Select a cemetery';
                }
                return opt
            },
            orderTypeTitle() {
                let opt = "";
                let obj = {};
                if (this.formFields.order.order_type_id != 0 && this.formFields.order.order_type_id != null) {
                    obj = this.formFields.order.order_type;
                    opt = Object.keys(obj).length > 0 ? obj.type_title : '';
                }
                return opt == '' ? 'Select' : opt
            },
        },
        components: {
            Toolbar,
            Price
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Accounting', action: 'read'}))
                this.$router.push('/access-denied');
        },
        mounted() {
            this.$store.state[this.axiosParams.module].busy = true
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            if (!this.$store.getters.isPermitted({resource: 'Accounting', action: 'create'}) && !this.$store.getters.isPermitted({resource: 'Accounting', action: 'update'}))
                this.$props.hideInModal = true;
            if (this.formFields.id > 0 && !this.$store.getters.isPermitted({resource: 'Accounting', action: 'update'}))
                this.hideinAuth = true;
            this.getAccount(this.formFields.id);
            this.getColumns();
            this.getRecords();
            this.$store.getters.detectFormChanges();
        },
        methods: {
            /** CRUD */
            getAccount: function (id) {
                if (id) {
                    this.axiosParams.id = id;
                    fetchRecord(this.axiosParams, (response) => {
                        if (response.data.order.products.length > 0)
                            this.$store.getters.changedCompositePrice(response.data.order.products);
                        this.formFields = response.data;
                        if (this.formFields.order == null)
                            this.order();
                        this.showCompositeProductDetails();
                        if (this.$store.state[this.axiosParams.module].recordList.length > 0)
                            this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        if (error.response.status == 403) {
                            this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                        }
                    })
                }
            },
            storeAccount: function () {
                this.saveDisabled = true;
                let data = this.formFields;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: this.alertMessage, variant: 'danger', duration: 5000});
                        this.alertMessage = '';
                    } else {
                        let status = this.formFields.id ? 'Updated' : 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                        this.makeToast({title: 'Accounting ' + status, message: this.alertMessage, variant: 'success'});
                        this.formFields = response.data;
                        this.axiosParams.data = response.data;
                        this.alertMessage = '';
                        this.$store.commit('appendOrUpdateInRecordList', this.axiosParams);

                    }
                }, (error) => {
                    if (error.response.status == 403) {
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    }
                })
            },
            deleteRecord: function (id) {
                if (confirm("Do you really want to delete this record?")) {
                    this.axiosParams.id = id;
                    deleteRecord(this.axiosParams, (response) => {
                        if (response.data) {
                            this.$store.dispatch('removeRecordFromList', this.axiosParams);
                            this.first()
                            if (this.$store.state[this.axiosParams.module].recordList.length == 0)
                                this.clearForm();
                        } else {
                            console.log(response.data);
                        }
                    }, (error) => {
                        if (error.response.status == 403) {
                            this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                        }
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
            showCompositeProductDetails() {
                for (let item of this.formFields.order.products) {
                    item.iscompositeDetails = false;
                    if (item.composite && item.composite.length > 0)
                        if (item.composite[0].composite_products && item.composite[0].composite_products.length > 0) {
                            item.iscompositeDetails = true;
                        }
                }
            },
            checkDate: function (date) {
                return searchForEmptyDate(date);
            },
            /** Pagination*/
            first: function () {
                firstRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.formFields = response.data;
                        this.$store.getters.changedCompositePrice(this.formFields.order.products);
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    if (error.response.status == 403) {
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    }
                })
            },
            last: function () {
                lastRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.formFields = response.data;
                        this.$store.getters.changedCompositePrice(this.formFields.order.products);
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    if (error.response.status == 403) {
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    }
                })
            },
            next: function (id) {
                this.axiosParams.id = id;
                nextRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.formFields = response.data;
                        this.$store.getters.changedCompositePrice(this.formFields.order.products);
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    if (error.response.status == 403) {
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    }
                })
            },
            prev: function (id) {
                this.axiosParams.id = id;
                previousRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.formFields = response.data;
                        this.$store.getters.changedCompositePrice(this.formFields.order.products);
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    if (error.response.status == 403) {
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    }
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
                        id: 0,
                        products: [],
                    };
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
                this.saveDisabled = false;//enabling save button

            },
        },
        directives: {
            // create directive named 'removeZero' starting with v- for example v-remove-zero
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
    }

</script>

<style scoped>
    .accounting-row {
        display: flex;
        margin: 0.5rem 0;
    }

    .accounting-row div {
        display: flex;
        margin: 0 20px;
    }

    .accounting-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
    }

    .accounting-row div input {
        width: 80px;
        border: 1px solid #c4c4c4 !important;
    }

    .custom-row {
        display: flex;
        padding: 0.3rem;
        margin: 0.5rem 0rem 0rem 0rem;
    }

    .custom-row div {
        display: flex;
        margin: 0 0.2rem;
    }

    .custom-row div label {
        margin: auto 0.3rem;
        white-space: nowrap !important;
        /*font-size: 0.7rem;*/
    }

    .custom-row div input, textarea, .input-date {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.75rem;
        /*max-width: 20rem;*/

    }

    .input-field-margin {
        margin-left: 60px !important;
    }

    .input-lg {
        width: 10rem;
    }

    .input-md {
        width: 7rem;
    }

    .input-xl {
        width: 60%;
    }

    .input-sm {
        width: 45%;
    }

    .input-date {
        min-width: 8rem;
    }

    .border {
        border: 1px solid #c4c4c4 !important;
    }

    .product-table-width {
        min-width: 71.3% !important;
        max-width: 71.3% !important;
    }

    .order-form-btn {
        font-size: 0.5rem;
    }
</style>
