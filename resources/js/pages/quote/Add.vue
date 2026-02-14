<template>
    <div :class="hideInModal?' p-3':''" class="quote-body" id="quote">
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Quote</h5>
            <div class="bg-toolbar my-2 p-1">
                <Toolbar :id="formFields.id" :saveDisabled="saveDisabled"></Toolbar>
            </div>
        </div>
        <div class="col-md-12 mb-2">
            <form class="quote-form mx-n2 py-2">
                <template v-if="isLoading">
                    <div class="text-center text-info my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>
                <template v-else>
                    <div class="d-flex justify-content-end" v-if="hideInModal">
                        <button @click="printPdf" class="btn-warning custom-infobtn-toolbar custom-dangerbtn-text m-1 mx-3" type="button">Print Quote</button>
                    </div>
                    <div class="custom-row mt-n2">
                        <div>
                            <label>Acct #</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" :value="formFields.company.account_number" class="input-md" name="account_number"
                                          readonly size="sm" type="text"></b-form-input>
                        </div>
                        <div>
                            <label>Quote #</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" :value="formFields.id" class="input-md" name="quote_number" readonly size="sm"
                                          type="text"></b-form-input>
                        </div>
                        <div>
                            <label>Date</label>
                            <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                               :disabled="hideInModal || hideinAuth"
                                               @input="formFields.date = checkDate(formFields.date)"
                                               class="input-date"
                                               close-button
                                               locale="en"
                                               placeholder=""
                                               reset-button
                                               size="sm"
                                               today-button
                                               v-model="formFields.date">
                            </b-form-datepicker>
                        </div>
                        <div>
                            <label>Sales Person</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-lg" name="sales_person" size="sm" type="text"
                                          v-model="formFields.sales_person"></b-form-input>
                        </div>
                        <div class="flex-grow-1">
                            <label>Company Information</label>
                            <b-form-select
                                :disabled="hideInModal"
                                :options="companies"
                                class="form-control form-control-sm custom-caret-form paper-select-width"
                                name="quote[company_id]"
                                size="sm"
                                v-model="formFields.company_id"
                                v-on:change="companyInfoLabel(formFields.company_id)">
                                <template #first>
                                    <b-form-select-option :value="null" disabled>Select a company</b-form-select-option>
                                </template>
                            </b-form-select>
                        </div>
                    </div>
                    <hr class="border my-2">
                    <div class="family-row">
                        <div>
                            <h6 class="my-auto ml-2 custom-form-heading">Family Information</h6>
                        </div>
                        <div class="ml-auto" v-if="!hideInModal">
                            <!--                            :to="{name: 'QuotePriceEstimator', params: { quote_to_price_id: formFields.id }}"-->
                            <router-link :class="formFields.id ? '' : 'disabled'" @click.native="saveAndOpenPrceEstimator"
                                         class="btn btn-sm mx-1 custom-infobtn-light-toolbar custom-infobtn-light-text text-nowrap" style="background: #007BFF;" to="#"
                            >Price Estimator
                            </router-link>
                        </div>
                    </div>
                    <div class="family-row pt-0">
                        <label class="family-col-1 my-auto">Last Name on Stone</label>

                        <div class="w-50 m-0">
                            <div class="w-50">
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-lg m-0" name="name_on_stone" size="sm"
                                              type="text" v-model="formFields.name_on_stone"></b-form-input>
                            </div>
                            <div class="w-50">
                                <label>Customer Contact</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-lg" name="customer_name" size="sm"
                                              type="text" v-model="formFields.customer_name"></b-form-input>
                            </div>
                        </div>
                    </div>
                    <div class="family-row pt-0">
                        <label class="family-col-1 my-auto">Address</label>
                        <div class="w-50">
                            <b-form-input :disabled="hideInModal || hideinAuth" autocomplete="off" class="" name="address"
                                          size="sm" type="text" v-model="formFields.family_address"></b-form-input>
                        </div>
                    </div>
                    <div class="family-row pt-0">
                        <label class="family-col-1 my-auto">City</label>
                        <div class="w-50 m-0">
                            <div class="w-50">
                                <b-form-input :disabled="hideInModal || hideinAuth" autocomplete="off" class="input-lg m-0" name="city"
                                              size="sm" type="text" v-model="formFields.family_city"></b-form-input>
                            </div>
                            <div class="w-50">
                                <div>
                                    <label class="family-col-2">State</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" autocomplete="off" class="" name="state"
                                                  size="sm" type="text" v-model="formFields.family_state"></b-form-input>
                                </div>
                                <div>
                                    <label class="family-col-3">Zip</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" autocomplete="off" class="" name="zip" size="sm"
                                                  type="text" v-model="formFields.family_zip"></b-form-input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="family-row pt-0">
                        <label class="family-col-1 my-auto">Phone</label>
                        <div>
                            <b-form-input :disabled="hideInModal || hideinAuth" autocomplete="off" class="input-lg m-0" name="phone"
                                          size="sm" type="text" v-model="formFields.family_phone"></b-form-input>
                        </div>
                        <div class="w-50">
                            <label class="family-col-2">Email</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" autocomplete="off" class="w-50 input-lg m-0" name="email"
                                          size="sm" type="text" v-model="formFields.customer_email"></b-form-input>
                        </div>
                    </div>
                    <hr class="border my-2">
                    <div class="custom-row d-block m-0 product-table-width">
                        <b-table :fields="productTableFields" :items="formFields.products" bordered class="ml-n2" hover id="data-table" responsive
                                 small
                                 striped>
                            <template #head()="data">
                                <span class="custom-form-heading ml-2">{{ data.label }}</span>
                            </template>
                            <template v-slot:cell(product_number)="row">
                                <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                    <b-form-input :disabled="hideInModal || hideinAuth" @change="row.item.non_stock_product[0].product_number = checkNegativeValue(row.item.non_stock_product[0].product_number)" class="qoutesproductnumber" name="product_number"
                                                  type="text"
                                                  v-model="row.item.non_stock_product[0].product_number"></b-form-input>
                                </template>
                                <template v-if="row.item.monument && row.item.monument.length > 0">
                                    <label class="d-flex mt-2 qoutesproductnumber product-table"><span class="proNumbermarginLeft">{{row.item.monument[0].product_number}}</span></label>
                                </template>
                                <template v-if="row.item.service && row.item.service.length > 0">
                                    <label class="d-flex mt-2 qoutesproductnumber product-table"><span class="proNumbermarginLeft">{{row.item.service[0].product_number}}</span></label>
                                </template>
                                <template v-if="row.item.simple && row.item.simple.length > 0">
                                    <label class="d-flex mt-2 qoutesproductnumber product-table"><span class="proNumbermarginLeft">{{row.item.simple[0].product_number}}</span></label>
                                </template>
                                <template v-if="row.item.composite && row.item.composite.length > 0">
                                    <label class="d-flex mt-2 qoutesproductnumber product-table"><span class="proNumbermarginLeft">{{row.item.composite[0].product_number}}</span></label>
                                </template>
                            </template>
                            <template v-slot:cell(item_name)="row">
                                <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                    <b-form-input :disabled="hideInModal || hideinAuth" class="input-md mt-1 w-100" name="item_name" size="sm"
                                                  type="text"
                                                  v-model="row.item.non_stock_product[0].item_name"></b-form-input>
                                </template>
                                <template v-if="row.item.monument && row.item.monument.length > 0">
                                    <label class="d-flex mt-2 product-table">{{row.item.monument[0].item_name}}</label>
                                </template>
                                <template v-if="row.item.service && row.item.service.length > 0">
                                    <label class="d-flex mt-2 product-table">{{row.item.service[0].item_name}}</label>
                                </template>
                                <template v-if="row.item.simple && row.item.simple.length > 0">
                                    <label class="d-flex product-table">{{row.item.simple[0].item_name}}</label>
                                </template>
                                <template v-if="row.item.composite && row.item.composite.length > 0">
                                    <label class="d-flex mt-2 product-table">{{row.item.composite[0].item_name}}</label>
                                </template>
                            </template>
                            <template v-slot:cell(price)="row">
                                <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                    <vue-numeric :disable="hideInModal || hideinAuth" class="input-md mt-1 prodcutPrice form-control form-control-sm" currency="$" separator="," v-bind:minus="false" v-bind:precision="2" v-model="row.item.price" v-remove-zero></vue-numeric>
                                    <!--                              <Price :disable="hideInModal || hideinAuth" :classes="'input-md mt-1'" v-model="row.item.price"></Price>-->
                                    <!--<b-form-input type="text" :disabled="hideInModal || hideinAuth"  class="input-md mt-1 prodcutPrice" name="price"
                                 @focusout="blurEventHandler(row.item.price, row.item, 'price')"  @focus="removeZero(row.item.price, row.item, 'price')" size="sm" v-model="row.item.price"></b-form-input>-->
                                </template>
                                <template v-if="row.item.monument && row.item.monument.length > 0">
                                    <label class="d-flex mt-2 product-table">$ {{ changeNumberFormat(row.item.price) ?
                                        changeNumberFormat(row.item.price) : '0.00' }}</label>
                                </template>
                                <template v-if="row.item.service && row.item.service.length > 0">
                                    <label class="d-flex mt-2 product-table">$ {{ changeNumberFormat(row.item.price) ?
                                        changeNumberFormat(row.item.price) : '0.00' }}</label>
                                </template>
                                <template v-if="row.item.simple && row.item.simple.length > 0">
                                    <label class="d-flex mt-2 product-table">$ {{ changeNumberFormat(row.item.price) ?
                                        changeNumberFormat(row.item.price) : '0.00' }}</label>
                                </template>
                                <template v-if="row.item.composite && row.item.composite.length > 0">
                                    <label class="d-flex mt-2 product-table">$ {{ changeNumberFormat(row.item.price) ?
                                        changeNumberFormat(row.item.price) : '0.00' }}</label>
                                </template>
                            </template>
                            <template v-slot:cell(quantity)="row">
                                <b-form-input :disabled="hideInModal || hideinAuth" @focus="removeZero(row.item.quantity, row.item, 'quantity')" @focusout="blurEventHandler(row.item.quantity, row.item, 'quantity')" class="qoutesQuantity mt-1 input-xsmall" min="0"
                                              name="quantity" size="sm" type="number" v-model="row.item.quantity"></b-form-input>
                            </template>
                            <template v-slot:cell(client_price)="row">
                                <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                    <label class="d-none">{{row.item.client_price > row.item.price ? row.item.client_price : row.item.client_price = row.item.price}}</label>
                                    <vue-numeric :disable="hideInModal || hideinAuth"
                                                 class="input-md mt-1 qoutesClientPrice form-control form-control-sm" currency="$"
                                                 id="inline-form-input-client-price-one" separator=","
                                                 v-bind:precision="2" v-model="row.item.client_price" v-remove-zero></vue-numeric>
                                </template>
                                <template v-else>
                                    <vue-numeric :disable="hideInModal || hideinAuth"
                                                 class="input-md mt-1 qoutesClientPrice form-control form-control-sm" currency="$"
                                                 id="inline-form-input-client-price-two" separator=","
                                                 v-bind:precision="2" v-model="row.item.client_price" v-remove-zero></vue-numeric>
                                </template>
                            </template>
                            <template v-slot:cell(amount)="row">
                                <label class="mt-2 d-none">$ {{ row.item.amount = Math.abs((row.item.quantity * row.item.client_price))
                                    }}
                                </label>
                                <label class="mt-2">$ {{ changeNumberFormat(row.item.amount) ? changeNumberFormat(row.item.amount) : '0.00' }}</label>
                                <input :disabled="hideInModal || hideinAuth" :value="row.item.amount" name="amount" type="hidden">
                            </template>
                            <template v-slot:cell(installation_price)="row">
                                <vue-numeric :disable="hideInModal || hideinAuth"
                                             class="input-md mt-1 inputinstallation form-control form-control-sm" currency="$"
                                             id="inline-form-input-installation_price" separator=","
                                             v-bind:precision="2" v-model="row.item.installation_price" v-remove-zero></vue-numeric>
                            </template>
                            <template v-slot:cell(installation_amount)="row">
                                <label class="d-none">$ {{
                                    Math.abs((row.item.quantity * row.item.installation_price)) }}</label>
                                <label>$ {{ changeNumberFormat(row.item.quantity * row.item.installation_price) ?
                                    changeNumberFormat(row.item.quantity * row.item.installation_price) : '0.00' }}</label>
                            </template>
                            <template v-slot:cell(total)="row">
                                <label class="mt-2 d-none">$ {{ row.item.total = Math.abs(+row.item.amount +
                                    parseFloat(row.item.installation_price == '' ? 0 :
                                    row.item.quantity * row.item.installation_price)) }}</label>
                                <label class="mt-2">$ {{ changeNumberFormat(row.item.total) ? changeNumberFormat(row.item.total) : '0.00' }}</label>
                                <input :disabled="hideInModal || hideinAuth" :value="row.item.total" name="total" type="hidden">
                            </template>
                            <template #cell(action)="data">
                                <a @click="removeProduct(data.index, data.item.id)" class="btn btn-danger mx-1 py-1"
                                   href="javascript:void(0)">
                                    <i aria-hidden="true" class="fa fa-trash-o"></i>
                                </a>
                            </template>
                            <template v-slot:cell(showProducts)="row">
                                <b-button
                                    :disabled="hideinAuth"
                                    @click="row.toggleDetails"
                                    class="btn btn-sm btn-info quote-form-btn py-1 mx-1 "
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
                                                        changeNumberFormat(obj.simple[0].override_selling_price): '0.00' }}</label>
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
                    </div>
                    <div class="custom-row" v-if="!hideInModal">
                        <div>
                            <h6 class="my-auto ml-2 custom-form-heading">Products</h6>
                        </div>
                        <div>
                            <b-dropdown class="border rounded input-product dropdown-width" no-caret size="sm"
                                        toggle-class="p-0" variant="none">
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
                        <div>
                            <b-dropdown class="border rounded input-product dropdown-width" no-caret size="sm"
                                        toggle-class="p-0" variant="none">
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
                        <div>
                            <button @click="addNonStockingProduct" class="btn btn-sm btn-info px-3 mt-1 custom-add-btn custom-add-text"
                                    type="button">Add New
                            </button>
                        </div>
                    </div>
                    <div class="custom-row justify-content-end col-md-10 ml-n3">
                        <div class="flex-column">
                            <label class="label-total">Discount</label>
                            <price :disabled="hideInModal || hideinAuth" class="input-total" min="0" name="discount" size="sm" type="number"
                                   v-model="formFields.discount" v-on:change="discount" v-remove-zero></price>
                        </div>
                        <div class="flex-column">
                            <label class="label-total">Sub Total</label>
                            <Price :classes="'input-total'" :disable="hideInModal || hideinAuth" :readonly="true"
                                   v-model="formFields.sub_total= getTotal[0]"></Price>
                        </div>
                        <div class="flex-column">
                            <label class="label-total">Tax Rate</label>
                            <div>
                                <b-input-group class="input-tax-group ml-n2" prepend="%" size="sm" title="Enter Tax in Percentage" v-b-tooltip.hover>
                                    <!--<b-form-input :disabled="hideInModal || hideinAuth" class="margin-top-2 ml-n2" min="0" name="tax_rate" size="sm" type="number"
                                                  v-model="formFields.tax_rate" v-on:change="taxRate" v-remove-zero></b-form-input>-->
                                    <vue-numeric :disable="hideInModal || hideinAuth" :empty-value="0.00"
                                                 class="input-md margin-top-2 ml-n2 inputinstallation form-control form-control-sm"
                                                 id="inline-form-input-installation_price" separator="," style="margin-top: 2px;" v-bind:minus="false"
                                                 v-bind:precision="2" v-model="formFields.tax_rate" v-on:change="taxRate" v-remove-zero></vue-numeric>
                                </b-input-group>
                            </div>
                        </div>
                        <div class="flex-column">
                            <label class="label-total">Tax Amount</label>
                            <Price :classes="'input-total'" :disable="hideInModal || hideinAuth" :readonly="true"
                                   v-model="formFields.tax_amount = getTax"></Price>
                        </div>
                        <div class="flex-column">
                            <label class="label-total">Total Selling Price</label>
                            <Price :classes="'input-total'" :disable="hideInModal || hideinAuth" :readonly="true"
                                   v-model="formFields.total_selling_price = getTotal[1]"></Price>
                        </div>
                    </div>
                    <hr class="border my-2">
                    <div class="custom-row">
                        <div>
                            <label>Call Back Date</label>
                            <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                               :disabled="hideInModal || hideinAuth" @input="formFields.callback_date = checkDate(formFields.callback_date)" class="px-1 ml-2 input-date"
                                               close-button locale="en"
                                               placeholder=""
                                               reset-button
                                               size="sm"
                                               today-button
                                               v-model="formFields.callback_date">

                            </b-form-datepicker>

                        </div>
                        <div class="col-3 m-0">
                            <label>Cemetery</label>
                            <b-dropdown :disabled="hideInModal || hideinAuth" class="border rounded input-email dropdown-width" no-caret
                                        size="sm" toggle-class="p-0" variant="none">
                                <template #button-content>
                                    <div class="d-flex product-color">
                                        <small>{{cemetery}}</small>
                                        <small class="w-25 ml-auto custom-caret-form"></small>
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
                                    <template v-if="cemeteries.length > 0">
                                        <template v-for="(obj, key) of cemeteries">
                                            <b-dropdown-group @click="handleDropdownChange">
                                                <b-dropdown-item-button :key="key" @click="formFields.cemetery_id = obj.value, $set(formFields, 'cemetery', {company:obj.text}) "
                                                                        class="small">
                                                    {{obj.text}}
                                                </b-dropdown-item-button>
                                            </b-dropdown-group>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                        <button @click="addCemetery(searchCemetery)" class="d-flex m-auto px-3 btn-sm btn-info custom-add-btn"
                                                type="button">Add Cemetery
                                        </button>
                                    </template>
                                </b-dropdown-group>
                            </b-dropdown>
                        </div>
                        <div>
                            <label>Installation</label>
                            <b-form-group class="m-0 my-auto custom-radio-and-checkbox">
                                <b-form-radio-group :disabled="hideInModal || hideinAuth" name="installation"
                                                    v-model="formFields.installation">
                                    <b-form-radio name="installation-radio" size="sm" value="1">Yes</b-form-radio>
                                    <b-form-radio name="installation-radio" size="sm" value="0">No</b-form-radio>
                                </b-form-radio-group>
                            </b-form-group>
                        </div>
                    </div>
                    <div class="custom-row">
                        <div>
                            <label>Referred By</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-lg ml-4" name="referred_by" size="sm"
                                          type="text" v-model="formFields.referred_by"></b-form-input>
                        </div>
                        <div>
                            <label>Call Customer</label>
                            <b-form-group class="m-0 my-auto custom-radio-and-checkbox">
                                <b-form-radio-group :disabled="hideInModal || hideinAuth" name="call_customer"
                                                    v-model="formFields.call_customer">
                                    <b-form-radio name="call-customer-radio" value="1">Yes</b-form-radio>
                                    <b-form-radio name="call-customer-radio" value="0">No</b-form-radio>
                                </b-form-radio-group>
                            </b-form-group>
                        </div>
                    </div>
                    <div class="custom-row">
                        <div class="flex-grow-1">
                            <label>Comments</label>
                            <b-form-textarea
                                :disabled="hideInModal || hideinAuth"
                                class="ml-4"
                                name="comments"
                                no-resize
                                placeholder="Comment here..."
                                size="sm"
                                v-model="formFields.comments"
                            ></b-form-textarea>
                        </div>
                    </div>
                    <div class="custom-row">
                        <div class="flex-grow-1">
                            <label>Who Follow Up</label>
                            <b-form-textarea
                                :disabled="hideInModal || hideinAuth"
                                class="ml-1"
                                name="who_follow_up"
                                no-resize
                                placeholder="Type..."
                                size="sm"
                                v-model="formFields.who_follow_up"
                            ></b-form-textarea>
                        </div>
                    </div>
                    <div class="custom-row">
                        <div class="flex-grow-1 justify-content-start" v-if="!hideInModal">
                            <button :disabled="saveDisabled" @click="storeQuote" class="btn-info mx-2  custom-infobtn-toolbar custom-infobtn-text" type="button" v-if="formFields.id ? isUpdatePermitted : isCreatePermitted">
                                {{ formFields.id ? 'Update' : 'Save' }}<span class="spinner-grow spinner-grow-sm ml-1" v-if="saveDisabled"></span>
                            </button>
                        </div>
                    </div>
                </template>
            </form>
        </div>
        <PDF :title="'printQuote'" class="px-0">
            <div class="mb-3 margin-print pdf row" slot="header">
                <div class="align-self-center">
                    <img class=" ml-2 w-100 height-150" src="/images/monument-logo.png">
                    <h6 class="text-center">816-833-5111</h6>
                </div>
                <div class="ml-5">
                    <img class="w-100 mt-n4" src="/images/monument-text-logo.png">
                </div>
            </div>
            <div class="pdf" slot="body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Account No</label>
                    </div>
                    <div class="col-md-4">
                        <label>Date</label>
                    </div>
                    <div class="col-md-4">
                        <label>Quote #</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="border p-1 first-row">
                            <label class="margin-fields">{{formFields.company.account_number}}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border p-1 first-row">
                            <label class="margin-fields">{{ changeDateFormat(formFields.date) }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border p-1 first-row">
                            <label class="margin-fields">{{formFields.id}}</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Company Information</label>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-5 p-0">
                        <label>Family Information</label>
                    </div>
                </div>
                <div class="row m-0">
                    <div class="col-md-6 border p-2">
                        <label><b>Name:</b> {{formFields.company.name}}</label>
                        <label style="word-break: break-all;"><b>Address:</b> {{formFields.company.address}}</label>
                        <label><b>City:</b> {{formFields.company.city}}</label>
                        <label><b>State:</b> {{formFields.company.state}}</label>
                        <label><b>Email:</b> {{formFields.company.email}}</label>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-5 border p-2">
                        <label><b>Name on Stone:</b> {{formFields.name_on_stone}}</label>
                        <label><b>Contact:</b> {{formFields.customer_name}} </label>
                        <label style="word-break: break-all;"><b>Address:</b> {{formFields.family_address}}</label>
                        <label><b>City:</b> {{formFields.family_city}}</label>
                        <label><b>Phone:</b> {{formFields.family_phone}}</label>
                    </div>
                </div>
                <div class="row my-1">
                    <div class="col-md-4 offset-md-7">
                        <label class="ml-n2"><b>Email:</b> {{formFields.customer_email}}</label>
                    </div>
                </div>
                <div class="row my-4 mx-0">
                    <div class="col-md-12 border p-3">
                        <b-table :fields="pdfTableFields" :items="formFields.products" bordered
                                 class="printing-table"
                                 responsive
                                 small>
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
                            <template v-slot:cell(quantity)="row">
                                <label class="d-flex justify-content-center product-table">{{row.item.quantity}}</label>
                            </template>
                            <template v-slot:cell(client_price)="row">
                                <label class="d-flex justify-content-center product-table text-nowrap">$ {{ changeNumberFormat(row.item.client_price) ?
                                    changeNumberFormat(row.item.client_price) : '0.00' }}</label>
                            </template>
                            <template v-slot:cell(installation_price)="row">
                                <label class="d-flex justify-content-center product-table text-nowrap">$ {{ changeNumberFormat(row.item.installation_price) ?
                                    changeNumberFormat(row.item.installation_price) : '0.00' }}</label>
                            </template>
                            <template v-slot:cell(total)="row">
                                <label class="d-flex justify-content-center product-table text-nowrap">$ {{ changeNumberFormat(row.item.total) ?
                                    changeNumberFormat(row.item.total) : '0.00' }}</label>
                            </template>
                            <template v-slot:row-details="row">
                                <b-card class="w-75 border-0">
                                    <table class="table table-sm table-striped table-bordered my-2 ">
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
                        <div class="d-flex mb-5 bottom-section">
                            <div class="col-md-5 ml-auto">
                                <div class="d-flex justify-content-end">
                                    <div class="text-right pr-0"><label>Sub Total</label></div>
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
                                    <div class="col-md-3 text-right"><label>${{ changeNumberFormat(formFields.total_selling_price) ?
                                        changeNumberFormat(formFields.total_selling_price) : '0.00' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row bottom-section">
                    <div class="col-md-5">
                        <label><b>Cemetery:</b> {{formFields.cemetery.company}}</label>
                        <label><b>Comments:</b> {{formFields.comments}}</label>
                        <label><b>Referred by:</b> {{formFields.referred_by}}</label>
                    </div>
                </div>
                <div style="margin-top: 20rem !important;">
                    <label>816-833-5111</label>
                    <label>Frisbie Monuments</label>
                    <label>2330 S. Crvsler Ave</label>
                    <label>Independence, Mo 64052</label>
                </div>
            </div>
        </PDF>
        <Modal :title="'Company'"></Modal>
        <div>
            <VueHtml2Pdf :enable-download="true"
                         :float-layout="true" :htmlToPdfOptions="{filename: `${formFields.name_on_stone}-${formFields.id}.pdf`, margin: [10, 0, 10, 0],
 html2canvas:{width:'1500', dpi: 192, scale: 2,bottom: 20, letterRendering: true} , jsPDF:{
                unit: 'mm' , format:'a3', orientation:'portrait'  }}" :manual-pagination="true" :pdf-margin="10"
                         :pdf-quality="2"
                         :preview-modal="false" :show-layout="false" pdf-content-width="1500px" pdf-format="letter"
                         pdf-orientation="landscape" ref="DownloadQuotePDF"
            >
                <section slot="pdf-content">
                    <PdfDownload :title="'printQuote'" class="" style="padding: 8rem 3.4rem 0rem 3.4rem">
                        <div class="mb-3 margin-print pdf row" slot="header">
                            <div class="align-self-center">
                                <img class=" ml-2 w-75 height-150" src="/images/monument-logo.png">
                                <h6 class="text-center">816-833-5111</h6>
                            </div>
                            <div class="ml-n5" style="margin-left: -9rem;">
                                <img class="w-100 mt-n4" src="/images/monument-text-logo.png">
                            </div>
                        </div>
                        <div class="pdf" slot="body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Account No</label>
                                </div>
                                <div class="col-md-4">
                                    <label>Date</label>
                                </div>
                                <div class="col-md-4">
                                    <label>Quote #</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="border p-1 first-row">
                                        <label class="margin-fields">{{formFields.company.account_number}}</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border p-1 first-row">
                                        <label class="margin-fields">{{ changeDateFormat(formFields.date) }}</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border p-1 first-row">
                                        <label class="margin-fields">{{formFields.id}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Company Information</label>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-5 p-0">
                                    <label>Family Information</label>
                                </div>
                            </div>
                            <div class="row m-0">
                                <div class="col-md-6 border p-2">
                                    <label><b>Name:</b> {{formFields.company.name}}</label>
                                    <label style="word-break: break-all;"><b>Address:</b> {{formFields.company.address}}</label>
                                    <label><b>City:</b> {{formFields.company.city}}</label>
                                    <label><b>State:</b> {{formFields.company.state}}</label>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-5 border p-2">
                                    <label><b>Name on Stone:</b> {{formFields.name_on_stone}}</label>
                                    <label><b>Contact:</b> {{formFields.customer_name}} </label>
                                    <label style="word-break: break-all;"><b>Address:</b> {{formFields.family_address}}</label>
                                    <label><b>City:</b> {{formFields.family_city}}</label>
                                    <label><b>Phone:</b> {{formFields.family_phone}}</label>
                                </div>
                            </div>
                            <div class="row my-4 mx-0">
                                <div class="col-md-12 border p-3">
                                    <b-table :fields="pdfTableFields" :items="formFields.products" bordered
                                             class="printing-table"
                                             responsive
                                             small>
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
                                        <template v-slot:cell(quantity)="row">
                                            <label class="d-flex justify-content-center product-table">{{row.item.quantity}}</label>
                                        </template>
                                        <template v-slot:cell(client_price)="row">
                                            <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(row.item.client_price) ?
                                                changeNumberFormat(row.item.client_price) : '0.00' }}</label>
                                        </template>
                                        <template v-slot:cell(installation_price)="row">
                                            <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(row.item.installation_price) ?
                                                changeNumberFormat(row.item.installation_price) : '0.00' }}</label>
                                        </template>
                                        <template v-slot:cell(total)="row">
                                            <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(row.item.total) ?
                                                changeNumberFormat(row.item.total) : '0.00' }}</label>
                                        </template>
                                        <template v-slot:row-details="row">
                                            <b-card class="w-75 border-0">
                                                <table class="table table-sm table-striped table-bordered my-2 ">
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
                                    <div class="d-flex mb-5 bottom-section">
                                        <div class="col-md-5 ml-auto">
                                            <section class="pdf-item justify-content-end">
                                                <div class="d-flex justify-content-end">
                                                    <div class="text-right pr-0"><label>Sub Total</label></div>
                                                    <div class="col-md-3 text-right"><label>${{ changeNumberFormat(formFields.sub_total) ?
                                                        changeNumberFormat(formFields.sub_total) : '0.00' }}</label></div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <div class=" text-right pr-0"><label>Tax </label></div>
                                                    <div class="col-md-3 text-right text-nowrap"><label>{{ changeNumberFormat(formFields.tax_rate) ?
                                                        changeNumberFormat(formFields.tax_rate) : '0.00' }} %</label></div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <div class=" text-right pr-0"><label>Tax Amount</label></div>
                                                    <div class="col-md-3 text-right text-nowrap"><label>$ {{ changeNumberFormat(formFields.tax_amount) ?
                                                        changeNumberFormat(formFields.tax_amount) : '0.00' }}</label></div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <div class=" text-right pr-0"><label>Total</label></div>
                                                    <div class="col-md-3 text-right text-nowrap"><label>$ {{ changeNumberFormat(formFields.total_selling_price) ?
                                                        changeNumberFormat(formFields.total_selling_price) : '0.00' }}</label>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row bottom-section">
                                <div class="col-md-5">
                                    <label class="text-nowrap"><b>Cemetery:</b> {{formFields.cemetery.company}}</label>
                                    <label class="text-nowrap"><b>Comments:</b> {{formFields.comments}}</label>
                                    <label class="text-nowrap"><b>Referred by:</b> {{formFields.referred_by}}</label>
                                </div>
                            </div>
                            <div style="margin-top: 20rem !important;">
                                <label>816-833-5111</label>
                                <label>Frisbie Monuments</label>
                                <label>2330 S. Crvsler Ave</label>
                                <label>Independence, Mo 64052</label>
                            </div>
                        </div>
                    </PdfDownload>
                </section>
            </VueHtml2Pdf>
        </div>
    </div>
</template>

<script>
    import Toolbar from "./Toolbar";
    import Price from "../../Modules/Price";
    import PDF from "../../Modules/PDF-Modal";
    import Modal from "./Modal";
    import {event, eventBus} from "../../event-bus/event-bus";
    import {searchForEmptyDate} from "../../helpers/common";
    import VueNumeric from 'vue-numeric';
    import VueHtml2Pdf from 'vue-html2pdf';
    import PdfDownload from "./PdfDownload";
    import {deleteProduct, deleteRecord, fetchRecord, firstRecord, lastRecord, nextRecord, previousRecord, saveRecord, searchProducts} from "../../helpers/axios";

    let current_date = new Date().getFullYear() + "-" + String((new Date().getMonth() + 1)).padStart(2, '0') + "-" + String(new Date().getDate()).padStart(2, '0');
    export default {
        name: "Add",
        props: {
            id: {
                type: Number
            },
            hideInModal: {
                type: Boolean,
                default: false
            },

        },
        data() {
            return {
                pageNumber: 1,
                // storeID : this.$store.getters.getCurrentStoreID,
                formFields: {
                    // store_id: this.storeID,
                    id: 0,
                    company: {
                        account_number: null,
                    },
                    date: current_date,
                    callback_date: null,
                    sales_person: null,
                    store_location: null,
                    referred_by: null,
                    comments: null,
                    call_customer: 0,
                    installation: 0,
                    who_follow_up: null,
                    sub_total: 0,
                    tax_rate: 0,
                    tax_amount: 0,
                    discount: 0,
                    total_selling_price: 0,
                    company_id: 0,
                    cemetery_id: 0,
                    cemetery: {},
                    name_on_stone: null,
                    customer_name: null,
                    family_address: null,
                    family_city: null,
                    family_state: null,
                    family_zip: null,
                    family_phone: null,
                    customer_email: null,
                    products: [],
                },
                pdfTableFields: [
                    {key: 'product_number', label: "Item#", class: 'text-center small'},
                    {key: 'item_name', label: "Item Name", class: 'text-center small'},
                    {key: 'quantity', label: "QTY", class: 'text-center small'},
                    {key: 'client_price', label: "Price", class: 'text-center small'},
                    {key: 'installation_price', label: "Installation", class: 'text-center small'},
                    {key: 'total', label: "Amount", class: 'text-center small'}
                ],
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
                productsByNumber: {},
                productsByTitle: {},
                searchByNumber: "",
                searchByTitle: "",
                searchCompany: "",
                searchCemetery: "",
                axiosParams: {module: 'quote'},
                saveDisabled: false,
                hideinAuth: false,
            }
        },
        metaInfo() {
            return {
                title: `${this.formFields.id ? 'Edit' : 'Add'} Quote`,
            }
        },
        created() {
            eventBus.$on(event.SAVE_QUOTE, this.storeQuote);
            eventBus.$on(event.FIRST_QUOTE_RECORD, this.first);
            eventBus.$on(event.LAST_QUOTE_RECORD, this.last);
            eventBus.$on(event.NEXT_QUOTE_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_QUOTE_RECORD, this.prev);
            eventBus.$on(event.GET_QUOTE, this.getDropDownQuote);
            eventBus.$on(event.ADD_QUOTE, this.clearForm);
            eventBus.$on(event.DELETE_QUOTE, this.deleteRecord);
            eventBus.$on(event.QUOTE_PRINT_PDF, this.storePrintPDF);
            eventBus.$on(event.QUOTE_DOWNLOAD_PDF, this.autoDownloadQuotePDF);
            eventBus.$on(event.SHOW_HIDE_COMPOSITE_PRODUCT, this.toggleCompositeProduct);
        },
        destroyed() {
            eventBus.$off(event.SAVE_QUOTE);
            eventBus.$off(event.FIRST_QUOTE_RECORD);
            eventBus.$off(event.LAST_QUOTE_RECORD);
            eventBus.$off(event.NEXT_QUOTE_RECORD);
            eventBus.$off(event.PREVIOUS_QUOTE_RECORD);
            eventBus.$off(event.GET_QUOTE);
            eventBus.$off(event.ADD_QUOTE);
            eventBus.$off(event.DELETE_QUOTE);
            eventBus.$off(event.QUOTE_PRINT_PDF);
            eventBus.$off(event.QUOTE_DOWNLOAD_PDF);
            eventBus.$off(event.SHOW_HIDE_COMPOSITE_PRODUCT);
        },
        components: {
            PdfDownload,
            Toolbar,
            PDF,
            Modal,
            Price,
            VueNumeric,
            VueHtml2Pdf
        },
        computed: {
            isLoading() {
                return this.$store.state[this.axiosParams.module].busy;
            },
            companies: function () {
                let list = []
                for (let opt of this.$store.state.company.recordList) {
                    list.push({value: opt.id, text: opt.name});
                }
                return list;
            },
            company() {
                let opt = "Select a company";
                this.$store.getters.sortByAlphaNumeric({'module': 'company', 'fieldName': 'name'});
                if (this.$store.state.company.recordList.length > 0 && this.formFields.company_id != 0 && this.formFields.company_id != null) {
                    opt = this.$store.state.company.recordList.filter(obj => obj.id == this.formFields.company_id);
                    opt = opt.length > 0 ? opt[0].name : "Select a company";
                }
                return opt
            },
            cemeteries: function () {
                this.$store.getters.sortByAlphaNumeric({'module': 'cemetery', 'fieldName': 'company'});
                let options = [];
                for (let opt of this.$store.state.cemetery.recordList) {
                    if (opt.company != null || opt.company != '') {
                        let obj = {value: opt.id, text: opt.company};
                        options.push(obj);
                    }
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
                    opt = opt[0].company;
                }
                return opt
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
            getTax: function () {
                return parseFloat((this.formFields.sub_total * (this.formFields.tax_rate / 100)).toFixed(2));
            },
            products() {
                let prods = {productsByNumber: [], productsByTitle: []};

                if (Object.keys(this.$store.state[this.axiosParams.module].productList).length > 0) {
                    this.productsByNumber = this.$store.state[this.axiosParams.module].productList;
                    this.productsByTitle = this.$store.state[this.axiosParams.module].productList;
                }
                return prods;
            },
            isCreatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Quotes', action: 'create'});
            },
            isUpdatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Quotes', action: 'update'});
            }
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Quotes', action: 'read'}))
                this.$router.push('/access-denied');
        },
        mounted() {
            this.$store.state[this.axiosParams.module].busy = true
            // this.formFields.store_id = this.$store.getters.getCurrentStoreID
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            if (!this.$store.getters.isPermitted({resource: 'Quotes', action: 'create'}) && !this.$store.getters.isPermitted({resource: 'Quotes', action: 'update'}))
                this.$props.hideInModal = true;
            if (this.formFields.id > 0 && !this.$store.getters.isPermitted({resource: 'Quotes', action: 'update'}))
                this.hideinAuth = true;
            this.getQuote(this.formFields.id);
            this.getColumns();
            this.getRecords();
            this.$store.getters.detectFormChanges();
        },
        methods: {
            /** CRUD */
            getDropDownQuote: async function (id) {
                this.axiosParams.id = id;
                await fetchRecord(this.axiosParams, (response) => {
                    let products = response.data.products;
                    products = this.changeCompositePrice(products);
                    this.formFields = response.data;
                    if (this.formFields.cemetery == null) {
                        this.formFields.cemetery = {};
                    }
                    this.showCompositeProductDetails();
                    this.$store.state[this.axiosParams.module].busy = false
                })
            },
            getQuote: async function (id) {
                if (id) {
                    this.axiosParams.id = id;
                    await fetchRecord(this.axiosParams, (response) => {
                        let products = response.data.products;
                        products = this.changeCompositePrice(products);
                        this.formFields = response.data;
                        if (this.formFields.cemetery == null) {
                            this.formFields.cemetery = {};
                        }
                        this.showCompositeProductDetails();
                        if (this.$store.state[this.axiosParams.module].recordList.length > 0)
                            this.$store.state[this.axiosParams.module].busy = false
                    })
                }
                this.$store.dispatch('getCompaniesInfo')
                this.$store.dispatch('getCemeteriesInfo')
                this.findProducts('byNumber')
                this.findProducts('byTitle')
            },
            removeZero: function (value, products, columnName) {
                if (value == 0 || value == '0.00') {
                    switch (columnName) {
                        case 'quantity':
                            products.quantity = '';
                            break;
                        case 'price':
                            products.price = '';
                            break;
                        case 'client_price':
                            products.price = '';
                            products.client_price = '';
                            break;
                    }
                } else if (value > 0) {
                    let newValue = parseFloat(value).toFixed(2).replace(/\.00$/, '')
                    switch (columnName) {
                        case 'price':
                            products.price = newValue;
                            break;
                        case 'client_price':
                            products.client_price = newValue;
                            break;
                    }
                }
                return products;
            },
            blurEventHandler: function (value, products, columnName) {
                if (value == 0) {
                    switch (columnName) {
                        case 'quantity':
                            products.quantity = '0';
                            break;
                        case 'price':
                            products.price = '0.00';
                            break;
                        case 'client_price':
                            products.client_price = '0.00';
                            break;
                    }
                } else if (value > 0) {
                    let newValue = parseFloat(value).toFixed(2)
                    let symbolWithVal = "$ " + newValue.replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,")
                    switch (columnName) {
                        case 'price':
                            products.price = newValue;
                            products.productPrice = symbolWithVal
                            break;
                        case 'client_price':
                            products.client_price = newValue;
                            break;
                    }
                }
                return products;
            },
            storePrintPDF() {
                let data = this.formFields;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                saveRecord(this.axiosParams, formData, (response) => {
                    if (!response.data.errorInfo) {
                        this.formFields = response.data;
                        this.axiosParams.data = response.data;
                        this.$store.commit('appendOrUpdateInRecordList', this.axiosParams);
                        this.showHideProductPrint();
                        this.showCompositeProductDetails();
                    }
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })

            },
            async showHideProductPrint() {
                await this.toggleCompositeProduct(true);
                eventBus.$emit(event.PRINT_PDF);
                await this.toggleCompositeProduct(false);
            },
            async autoDownloadQuotePDF() {
                eventBus.$emit(event.SHOW_HIDE_COMPOSITE_PRODUCT, true);
                await this.$refs.DownloadQuotePDF.generatePdf();
                eventBus.$emit(event.SHOW_HIDE_COMPOSITE_PRODUCT, false);
            },
            checkNegativeValue: function (checkVal) {
                return checkVal;
            },
            changeCompositePrice: function (products) {
                products = products.filter(obj => {
                    if (obj.quote_composite_product.length > 0) {
                        let compositeProduct = obj.quote_composite_product;
                        compositeProduct = compositeProduct.filter(comp => {
                            if (comp.monument.length > 0) {
                                comp.monument[0].override_selling_price = comp.price_override;
                            } else if (comp.service.length > 0) {
                                comp.service[0].price = comp.price;
                            } else if (comp.simple.length > 0) {
                                comp.simple[0].price = comp.price;
                            }
                        });
                        obj.composite[0].composite_products = obj.quote_composite_product;
                    }
                    return obj;
                });
                return products;
            },
            calculateRetailPrice: function (data) {
                if (data.composite != "No record found") {
                    let overridePrice = 0, subTotal = 0, getPercent = null, productNumber = null;
                    for (let prod of data.composite) {
                        productNumber = prod.product_number;
                        getPercent = prod.percentage;
                        getPercent = parseFloat(getPercent);
                        if (prod.composite_products.length > 0) {
                            for (let compo of prod.composite_products) {
                                if (compo.monument && compo.monument.length > 0) {
                                    compo.installation_price = compo.monument[0].installation != null ? compo.monument[0].installation.installation_amount : compo.installation_price;
                                    overridePrice += parseFloat(compo.monument[0].override_selling_price) * compo.quantity;
                                    subTotal += parseFloat(compo.monument[0].override_selling_price) ? parseFloat(compo.monument[0].override_selling_price) * compo.quantity : 0;
                                } else {
                                    let productPrice = this.$store.getters.getSimpleAndServicePrice(compo);
                                    overridePrice += parseFloat(productPrice.price) * compo.quantity;
                                }
                            }
                            overridePrice = parseFloat(overridePrice.toFixed(2));
                            subTotal = this.$store.getters.calculatePercentage({'overridePrice': overridePrice, 'getPercent': getPercent});
                            subTotal = overridePrice + (subTotal);
                            subTotal = parseFloat(subTotal.toFixed(2));
                        }
                        prod.retail_price = subTotal;
                        overridePrice = 0;
                        subTotal = 0;
                    }
                }
                return data;

            },
            storeQuote: function () {
                this.saveDisabled = true;
                let data = this.formFields;
                let products = this.formFields.products;
                products = products.filter(obj => {
                    if ((obj.iscompositeDetails) && (obj.composite[0].composite_products.length > 0) && (obj.quote_composite_product.length == 0)) {
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
                            obj.quote_composite_product.push(customObj);
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
                        this.formFields = response.data;
                        let products = response.data.products;
                        products = this.changeCompositePrice(products);
                        this.axiosParams.data = {
                            id: this.formFields.id
                        }
                        this.$store.commit('appendOrUpdateDropDown', this.axiosParams)
                        this.showCompositeProductDetails();
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
                            this.first();
                            if (this.$store.state[this.axiosParams.module].recordList.length == 0)
                                this.clearForm();
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
            handleDropdownChange: function (value) {
                window.detectChanges = true;
            },
            saveAndOpenPrceEstimator: function () {
                this.storeQuote()
                const routeParams = {
                    name: 'QuotePriceEstimator',
                    params: {quote_to_price_id: this.formFields.id}
                };
                this.$router.push(routeParams);
            },
            discount() {
                if (this.formFields.discount == '')
                    this.formFields.discount = 0;
                return this.formFields.discount;
            },

            /** Products*/
            findProducts: function (type = 'byNumber') {
                let keywords = type == 'byNumber' ? this.searchByNumber : this.searchByTitle;
                let formData = new FormData();
                formData.append('keywords', keywords);
                formData.append('type', type);
                searchProducts(formData, (response) => {
                    response.data = this.calculateRetailPrice(response.data);
                    type == 'byNumber' ? this.productsByNumber = response.data : this.productsByTitle = response.data;
                });
            },
            addProduct: function (obj, type) {
                window.detectChanges = true
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
                    recordList.push(obj);
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
                        quote_composite_product: [],
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

            /** Pagination*/
            first: function () {
                firstRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        let products = response.data.products;
                        products = this.changeCompositePrice(products);
                        this.formFields = response.data;
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            last: function () {
                lastRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        let products = response.data.products;
                        products = this.changeCompositePrice(products);
                        this.formFields = response.data;
                        this.showCompositeProductDetails();
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
                        let products = response.data.products;
                        products = this.changeCompositePrice(products);
                        this.formFields = response.data;
                        this.showCompositeProductDetails();
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
                        let products = response.data.products;
                        products = this.changeCompositePrice(products);
                        this.formFields = response.data;
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },

            /** Select List */
            setCompany(obj) {
                this.formFields.company_id = obj.value;
                this.formFields.company = obj.options;
            },
            addCemetery(name) {
                let data = {id: 0, company: name, regulation: []};
                let formData = new FormData();
                let params = {module: 'cemetery'};
                formData.append('data', JSON.stringify(data));
                saveRecord(params, formData, (response) => {
                    this.$store.dispatch('getCemeteriesInfo')
                })
            },
            taxRate() {
                if (this.formFields.tax_rate == '')
                    this.formFields.tax_rate = '0.00';
                return this.formFields.tax_rate;
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
                        date: current_date,
                        company_id: 0,
                        cemetery_id: 0,
                        sub_total: 0,
                        tax_rate: 0,
                        tax_amount: 0,
                        company: {},
                        cemetery: {},
                        products: [],
                        discount: 0,
                    };
                    this.searchCemetery = '';
                    this.searchCompany = '';
                    this.searchByNumber = '';
                    this.searchByTitle = '';
                }
            },
            customizeLabel: function (str) {
                let i, labels = str.split('_');
                for (i = 0; i < labels.length; i++) {
                    labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
                }
                return labels.join(' ');
            },
            showCompositeProductDetails() {
                for (let item of this.formFields.products) {
                    for (let item of this.formFields.products) {
                        item.iscompositeDetails = false;
                        if (item.composite && item.composite.length > 0)
                            if (item.composite[0].composite_products && item.composite[0].composite_products.length > 0) {
                                item.iscompositeDetails = true;
                                let retailPrice = this.calculateRetailPrice(item);
                                item.price = retailPrice.composite[0].retail_price;
                                //this.$set(item, "_showDetails", !item._showDetails);
                            }
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
            async printPdf() {
                await this.toggleCompositeProduct(true);
                this.$bvModal.hide('view-modal');
                eventBus.$emit(event.PRINT_PDF);
                await this.toggleCompositeProduct(false);
            },
            checkDate: function (date) {
                return searchForEmptyDate(date);
            },
            changeDateFormat: function (value) {
                return this.$store.getters.changeDateFormat(value);
            },
            changeNumberFormat: function (value) {
                return this.$store.getters.changeNumberFormat(value);
            },
            companyInfoLabel: function (id) {
                let option = 'Select';
                for (let opt of this.$store.state.company.recordList) {
                    if (opt.id == id)
                        option = opt.title;
                }
                return option;
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
        watch: {
            'formFields.tax_rate'(newValue, oldValue) {
                if (newValue == '' || newValue == 0) {
                    this.formFields.tax_rate = '0.00'
                }
            },
        },
    }
</script>

<style scoped>
    .pdf label {
        display: block;
        font-size: 0.75em;
        margin-bottom: 0;
    }

    .pdf .product-table {
        font-size: 1.2rem;
    }

    .pdf .first-row {
        width: 10rem;
        height: 2rem;
    }

    .printing {
        font-family: Roboto;
        padding: 3em;
        margin: 2em auto;
        font-size: 1.5em;
    }

    .quote-body {
        background-color: #F7F7F5;
    }

    .custom-row, .family-row {
        display: flex;
        padding: 0.5rem;
    }

    .custom-row div, .family-row div {
        display: flex;
        margin: 0 .2rem;
    }

    .custom-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
    }

    .family-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
    }

    .family-col-1 {
        width: 7rem;
    }

    .family-col-2 {
        width: 2rem;
    }

    .family-col-3 {
        width: 1.5rem;
    }

    .custom-row div input, select, datepicker, .family-row div input, .input-date {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.75rem;
    }

    .input-date {
        min-width: 8rem;
    }

    .custom-row div textarea {
        border: 1px solid #c4c4c4 !important;
        font-size: 0.75rem;
    }

    header {
        padding: 0 3rem;
    }

    .input-product {
        width: 250px;
    }

    .input-total {
        width: 130px;
    }

    .input-email {
        width: 100%;
    }

    .input-state {
        width: 6.9rem;
    }

    .label-total {
        margin-left: 0.0rem !important;
    }

    .input-xl {
        width: 30.8rem;
    }

    .input-lg {
        width: 90%;
    }

    .input-md {
        width: 60%;
    }

    .input-xsmall {
        width: 4rem;
    }

    .input-sm {
        width: 5.55rem;
    }

    .product-table {
        font-size: 0.8rem;
    }

    .quote-form {
        background: #FFFFFF;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.15);
        border-radius: 7px;
    }

    .custom-add-btn {
        box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.25);
        border-radius: 5px;
        width: 111px;
        height: 26px;
        font-size: 12px;
        letter-spacing: 0.02em;
    }

    .quote-form-btn {
        font-size: 0.7rem;
    }

    .border {
        border: 1px solid #c4c4c4 !important;
    }

    .printing label {
        font-size: 1.3rem !important;
        color: #000 !important;
    }

    .height-150 {
        height: 120px;
    }

    .margin-print {
        margin-top: -5rem !important;
    }

    .margin-fields {
        margin-top: -0.25rem !important;
    }

    .printing-table .table-bordered th, .table-bordered td {
        border: 3px solid #dee2e6 !important;
    }

    .product-color {
        color: #6C757D;
    }

    .proNumbermarginLeft {
        margin-left: 13px;
    }

    .prodcutPrice, .clientPrice {
        width: 6rem !important;
    }

    .th-text-align-center {
        text-align: center;
    }
</style>
