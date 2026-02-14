<template>
<div>
    <div>
        <h5 class="mx-2 my-1 custom-view-heading">Customer Portal </h5>
        <div class="bg-toolbar my-2 p-1">
            <Toolbar :customerName="customerName"></Toolbar>
        </div>
    </div>
    <div>
        <Button :invoice="true"></Button>
    </div>
    <hr class="my-3">
    <div>
        <b-form inline class="div-shadow bg-white rounded mx-2 mb-2">
            <div class="d-flex justify-content-center title-style col-md-12 my-4">
                INVOICE
            </div>

                <label class="mr-sm-2 ml-2" for="inline-form-input-invoice" >Invoice No.</label>
                <b-form-input id="inline-form-input-invoice" size="sm" class="mb-2 mr-sm-2 mb-sm-0 col-md-2 mx-1" v-model="invoice.invoice_number" readonly></b-form-input>

                <label class="mr-sm-2 ml-1" for="inline-form-order-date">Order Date</label>
            <b-form-input id="inline-form-order-date" size="sm" class="mb-2 mr-sm-2 mb-sm-0 col-md-2 mx-1" :value="formFields.date = changeDateFormat(formFields.date)" readonly></b-form-input>

            <label class="mr-sm-2 ml-1" for="inline-form-input-po" >Po.</label>
            <b-form-input id="inline-form-input-po"  size="sm"  class="mb-2 mr-sm-2 mb-sm-0 col-md-2 mx-1" v-model="formFields.po" disabled></b-form-input>

            <hr class="mt-3 col-md-12">

            <div class="row w-100 px-2">

            <div class="col-md-4 custom-border-right">
                <h6 class="m-0 custom-form-heading mt-3 ml-1">Company Information</h6>
<!--refernece for b-row label and input  https://bootstrap-vue.org/docs/components/form-input -->
                <b-row class="my-1">
                <b-col sm="12">
                    <b-form-input size="sm" v-model="company.selectedOpt" readonly class="mb-2 mr-sm-2 mb-sm-0 mx-1 w-100"></b-form-input>
                <!--<b-dropdown no-caret class="border rounded my-1 w-100 dropdown-width ml-1" toggle-class="" size="sm" variant="none" disabled>
                    <template #button-content>
                        <div class="d-flex product-color">
                            <small >{{company.selectedOpt}}</small>
                            <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                        </div>
                    </template>

                    <b-dropdown-group class="overflow-auto scroll px-1">
                        <b-form-input
                            size="sm"
                            placeholder="Search..."
                            class="mt-1"
                            v-model="searchCompany"
                        ></b-form-input>

                        <b-dropdown-divider class="my-1"></b-dropdown-divider>

                        <template v-if="companies.length > 0">
                            <template v-for="(obj, key) of companies">
                                <b-dropdown-group>
                                    <b-dropdown-item-button :key="key"
                                                            @click="formFields.company_id = obj.value">
                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                    </b-dropdown-item-button>
                                </b-dropdown-group>
                            </template>
                        </template>

                        <template v-else>
                            <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                        </template>
                    </b-dropdown-group>

                </b-dropdown>-->
                </b-col>
                </b-row>

                <b-row class="my-1">
                    <b-col sm="2">
                        <label class="mr-sm-2 ml-1 w-75 mt-1" for="inline-form-input-name">Name</label>
                    </b-col>
                    <b-col sm="10">
                        <b-form-input id="inline-form-input-name" size="sm" :value="company.data.name" readonly class="mb-2 mr-sm-2 mb-sm-0 mx-1 w-100"></b-form-input>
                    </b-col>
                </b-row>

                <b-row class="my-1">
                    <b-col sm="2">
                        <label class="mr-sm-2 ml-1 w-100 mt-1" for="inline-form-input-address">Address</label>
                    </b-col>
                    <b-col sm="10">
                        <b-form-input id="inline-form-input-address" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1 w-100" v-model="company.data.address" readonly></b-form-input>
                    </b-col>
                </b-row>

                <b-row class="my-1">
                    <b-col sm="2" md="2" lg="1" xl="1">
                        <label class="mr-sm-2 ml-1 mt-2" for="inline-form-input-city">City</label>
                    </b-col>
                    <b-col sm="4" md="2" lg="1" xl="3">
                        <b-form-input id="inline-form-input-city" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1" :value="company.data.city" readonly style="width: inherit;"></b-form-input>
                    </b-col>

                    <b-col sm="1" md="2" lg="1" xl="1">
                        <label class="mr-sm-2 ml-1 mt-2" for="inline-form-input-state">State</label>
                    </b-col>
                    <b-col sm="2" md="2" lg="1" xl="3">
                        <b-form-input id="inline-form-input-state" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1" :value="company.data.state" readonly style="width: inherit;"></b-form-input>
                    </b-col>

                    <b-col sm="1" md="2" lg="2" xl="1">
                        <label class="mr-sm-2 ml-1 mt-2" for="inline-form-input-zip">Zip</label>
                    </b-col>
                    <b-col sm="2" md="2" lg="2" xl="3">
                        <b-form-input id="inline-form-input-zip" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1" :value="company.data.zip" readonly style="width: inherit;"></b-form-input>
                    </b-col>
                </b-row>

                <b-row class="my-1">
                    <b-col sm="2" md="3" lg="1" xl="2">
                        <label class="mr-sm-2 ml-1 w-100 mt-2" for="inline-form-input-contact">Contact</label>
                    </b-col>
                    <b-col sm="4" md="3" lg="1" xl="4">
                        <b-form-input id="inline-form-input-contact" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1" :value="company.data.contact" readonly style="width: inherit;"></b-form-input>
                    </b-col>

                    <b-col sm="1" md="3" lg="1" xl="1">
                        <label class="mr-sm-2 mt-2" for="inline-form-input-phone">Phone</label>
                    </b-col>
                    <b-col sm="4" md="3" lg="1" xl="5">
                        <b-form-input id="inline-form-input-phone" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1" :value="company.data.phone" readonly style="width: inherit;"></b-form-input>
                    </b-col>
                </b-row>

                <b-row class="my-1">
                    <b-col sm="2">
                        <label class="mr-sm-2 ml-1 w-100 mt-1" for="inline-form-input-emailc">Email</label>
                    </b-col>
                    <b-col sm="10">
                        <b-form-input id="inline-form-input-emailc" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1 w-100" v-model="company.data.email" readonly></b-form-input>
                    </b-col>
                </b-row>

            </div>

            <div class="col-md-4 custom-border-right">

                <h6 class="m-0 custom-form-heading mt-3 ml-1">Family Information</h6>

                <b-row class="my-1 text-nowrap">
                    <b-col sm="4">
                        <label class="mr-sm-2 ml-1 mt-1 " for="inline-form-last-name-on-stone">Last Name on Stone</label>
                    </b-col>
                    <b-col sm="8">
                        <b-form-input id="inline-form-last-name-on-stone" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1 w-100" v-model="family.name_on_stone" readonly></b-form-input>
                    </b-col>
                </b-row>

                <b-row class="my-1 pl-1">
                    <b-col sm="2">
                        <label class="mr-sm-2 w-100  mt-1" for="inline-form-input-address2">Address</label>
                    </b-col>
                    <b-col sm="10">
                        <b-form-input id="inline-form-input-address2" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1 w-100" v-model="family.address" readonly></b-form-input>
                    </b-col>
                </b-row>

                <b-row class="my-1">
                    <b-col sm="2" md="2" lg="1" xl="1">
                        <label class="mr-sm-2 ml-1 mt-2" for="inline-form-input-city2">City</label>
                    </b-col>
                    <b-col sm="4" md="2" lg="1" xl="3">
                        <b-form-input id="inline-form-input-city2" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1" v-model="family.city" readonly style="width: inherit;"></b-form-input>
                    </b-col>

                    <b-col sm="1" md="2" lg="1" xl="1">
                        <label class="mr-sm-2 ml-1 mt-2" for="inline-form-input-state2">State</label>
                    </b-col>
                    <b-col sm="2" md="2" lg="1" xl="3">
                        <b-form-input id="inline-form-input-state2" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1" v-model="family.state" readonly style="width: inherit;"></b-form-input>
                    </b-col>

                    <b-col sm="1" md="2" lg="2" xl="1">
                        <label class="mr-sm-2 ml-1 mt-2" for="inline-form-input-zip2">Zip</label>
                    </b-col>
                    <b-col sm="2" md="2" lg="2" xl="3">
                        <b-form-input id="inline-form-input-zip2" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1" v-model="family.zip" readonly style="width: inherit;"></b-form-input>
                    </b-col>
                </b-row>

                <b-row class="my-1">
                    <b-col sm="2" md="3" lg="1" xl="2">
                        <label class="mr-sm-2 ml-1 w-100 mt-2" for="inline-form-input-contact2">Contact</label>
                    </b-col>
                    <b-col sm="4" md="3" lg="1" xl="4">
                        <b-form-input id="inline-form-input-contact2" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1" v-model="family.contact" readonly style="width: inherit;"></b-form-input>
                    </b-col>

                    <b-col sm="1" md="3" lg="1" xl="1">
                        <label class="mr-sm-2 mt-2" for="inline-form-input-phone2">Phone</label>
                    </b-col>
                    <b-col sm="4" md="3" lg="1" xl="5">
                        <b-form-input id="inline-form-input-phone2" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1" v-model="family.phone" readonly style="width: inherit;"></b-form-input>
                    </b-col>
                </b-row>

                <b-row class="my-1 pl-1">
                    <b-col sm="2">
                        <label class="mr-sm-2 w-100 mt-1" for="inline-form-input-email2">Email</label>
                    </b-col>
                    <b-col sm="10">
                        <b-form-input id="inline-form-input-email2" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1 w-100" v-model="family.email" readonly></b-form-input>
                    </b-col>
                </b-row>

            </div>
            <div class="col-md-4">
                <h6 class="m-0 custom-form-heading mt-3 ml-1">Invoice Info</h6>

                <b-row class="my-1">
                    <b-col sm="4">
                        <label class="mr-sm-2 ml-1 mt-1" for="inline-form-type-of-order">Type of Oder</label>
                    </b-col>
                    <b-col sm="8">
                        <b-form-input id="inline-form-type-of-order" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1 w-100" v-model="orderType.order_type" readonly></b-form-input>
                    </b-col>
                </b-row>

                <b-row class="my-1">
                    <b-col sm="4">
                        <label class="mr-sm-2 ml-1 mt-1" for="inline-form-inv-closed-date">Inv. Closed Date</label>
                    </b-col>
                    <b-col sm="8">
                        <b-form-input id="inline-form-inv-closed-date" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1 w-100" :value="invoice.closed_date = changeDateFormat(invoice.closed_date)" readonly></b-form-input>
                    </b-col>
                </b-row>

                <b-row class="my-1">
                    <b-col sm="4">
                        <label class="mr-sm-2 ml-1 mt-1" for="inline-form-org-inv-no">Org. Inv. No.</label>
                    </b-col>
                    <b-col sm="8">
                        <b-form-input id="inline-form-org-inv-no" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1 w-100" v-model="invoice.original_invoice_number" readonly></b-form-input>
                    </b-col>
                </b-row>

                <b-row class="my-1">
                    <b-col sm="4">
                        <label class="mr-sm-2 ml-1 mt-1" for="inline-form-ship-invoice-date">Ship/Invoice Date</label>
                    </b-col>
                    <b-col sm="8">
                        <b-form-input id="inline-form-ship-invoice-date" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1 w-100" :value="invoice.ship_date = changeDateFormat(invoice.ship_date)"  readonly></b-form-input>
                    </b-col>
                </b-row>

                <b-row class="my-1">
                    <b-col sm="4">
                        <label class="mr-sm-2 ml-1 mt-1" for="inline-form-sales-person">Sales Person</label>
                    </b-col>
                    <b-col sm="8">
                        <b-form-input id="inline-form-sales-person" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1 w-100" v-model="formFields.sales_person" readonly></b-form-input>
                    </b-col>
                </b-row>

                <b-row class="my-1">
                    <b-col sm="4">
                        <label class="mr-sm-2 ml-1 mt-1" for="inline-form-date-promised">Date Promised</label>
                    </b-col>
                    <b-col sm="8">
                        <b-form-input id="inline-form-date-promised" size="sm" class="mb-2 mr-sm-2 mb-sm-0 mx-1 w-100" :value="invoice.date_promised = changeDateFormat(invoice.date_promised)" readonly></b-form-input>
                    </b-col>
                </b-row>

            </div>
            </div>
            <hr class="col-md-12">

            <div class="row w-100 px-2">

                <div class="col-md-8 custom-border-right">
                <b-table striped hover responsive bordered small class="ml-2 mt-2"
                         :items="formFields.products"
                         :fields="productTableFields" show-empty>
                    <template #empty="scope">
                        No Record
                    </template>
                    <template #head()="data">
                        <span class="custom-form-heading ml-2">{{ data.label }}</span>
                    </template>

                    <!-- For non-stocking products show product_number and product_name fields as input fields
                        Otherwise just print them -->

                    <template v-slot:cell(product_number)="row">

                        <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                            <b-form-input type="text" class="input-md"
                                          name="product_number" size="sm"
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
                            <b-form-input type="text" class="input-md" name="item_name"
                                          size="sm"
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

                    <!--<template v-slot:cell(price)="row">
                        <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                            <Price :classes="'input-md'"
                                   v-model="row.item.price" readonly></Price>
                        </template>

                        <template v-if="row.item.monument && row.item.monument.length > 0">
                            <label class="d-flex justify-content-center product-table">$ {{row.item.price}}</label>
                        </template>

                        <template v-if="row.item.service && row.item.service.length > 0">
                            <label class="d-flex justify-content-center product-table">$
                                {{row.item.price}}</label>
                        </template>

                        <template v-if="row.item.simple && row.item.simple.length > 0">
                            <label class="d-flex justify-content-center product-table">$
                                {{row.item.price}}</label>
                        </template>

                        <template v-if="row.item.composite && row.item.composite.length > 0">
                            <label class="d-flex justify-content-center product-table">$
                                {{row.item.price}}</label>
                        </template>
                    </template>-->

                    <template v-slot:cell(quantity)="row">
                        <b-form-input type="number" min="0" class="input-md w-100" readonly
                                      name="quantity" size="sm" v-model="row.item.quantity"></b-form-input>
                    </template>

                   <!-- <template v-slot:cell(client_price)="row">
                        <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                            <label class="d-none">{{row.item.client_price > row.item.price ? row.item.client_price : row.item.client_price = row.item.price}}</label>
                            <Price :classes="'input-md'" v-model="row.item.client_price" readonly></Price>
                        </template>
                        <template v-else>
                            <Price :classes="'input-md'" v-model="row.item.client_price" readonly></Price>
                        </template>

                    </template>-->
                    <template v-slot:cell(amount)="row">
                        <label class="">$ {{ changeNumberFormat(row.item.quantity*row.item.client_price) ?
                            changeNumberFormat(row.item.quantity*row.item.client_price) : '0.00' }}</label>
                        <input type="hidden" readonly name="amount" :value="row.item.amount">
                    </template>
                    <template v-slot:cell(installation_price)="row">
                        <!--<Price :classes="'input-md'"
                               v-model="row.item.installation_price" readonly></Price>-->
                        <label class="">$ {{ changeNumberFormat(row.item.installation_price) ?
                            changeNumberFormat(row.item.installation_price) : '0.00' }}</label>
                        </template>
                    <template v-slot:cell(total)="row">
                        <!--<label>$ {{ row.item.total = Math.abs(+row.item.amount +
                            parseFloat(row.item.installation_price == '' ? 0 :
                            row.item.installation_price)).toFixed(2) }}</label>-->
                        <label class="">$ {{ getTotalAmount(+row.item.amount +row.item.installation_price )
                            }}</label>
                        <input type="hidden" name="total" :value="row.item.total" readonly>
                    </template>

                    <template #cell(action)="data">
                        <a class="btn btn-sm btn-danger mx-1 py-1" href="javascript:void(0)">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </template>
                    <template v-slot:cell(showProducts)="row">
                        <b-button
                            size="sm"
                            @click="row.toggleDetails"
                            class="btn btn-sm btn-info order-form-btn py-1 mx-1 "
                            v-if="row.item.iscompositeDetails">
                            {{ row.detailsShowing ? 'Hide' : 'Show'}}
                        </b-button>
                    </template>

                    <template v-slot:row-details="row">
                        <b-card>
                            <table class="table table-sm table-striped table-bordered my-2 ">
                                <thead class="custom-table-header">
                                <tr>
                                    <th>Proudct #</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <!--<th>Cost</th>
                                    <th>Price Override</th>
                                    <th>Computer Selling Price</th>
                                    <th>Installation Price</th>-->
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
                                    <!--<td>
                                        <template v-if="obj.monument && obj.monument.length > 0">
                                            <label class="d-flex justify-content-center product-table">${{obj.monument[0].product_cost}}</label>
                                        </template>

                                        <template v-if="obj.service && obj.service.length > 0">
                                            <label class="d-flex justify-content-center product-table">${{obj.service[0].product_cost}}</label>
                                        </template>

                                        <template v-if="obj.simple && obj.simple.length > 0">
                                            <label class="d-flex justify-content-center product-table">${{obj.simple[0].product_cost}}</label>
                                        </template>
                                    </td>
                                    <td>
                                        <label class="d-flex justify-content-center product-table">${{(row.item.quantity
                                            * obj.price_override).toFixed(2)}}</label>
                                    </td>
                                    <td>
                                        <label class="d-flex justify-content-center product-table">${{obj.computer_selling_price}}</label>
                                    </td>
                                    <td>
                                        <label class="d-flex justify-content-center product-table">${{obj.installation_price}}</label>
                                    </td>-->
                                </tr>
                                </tbody>
                            </table>
                        </b-card>
                    </template>
                </b-table>

                    <div class="row w-100 m-auto">
                    <b-form-group
                        id="input-group-1"
                        label="Sub Total"
                        label-for="inline-form-input-sub-total"
                        class="d-block col-sm-3">
                        <vue-numeric disable="true" readonly="true"
                                     class="mb-2 mr-sm-2 mx-1 input-total input-md form-control form-control-sm"
                                     currency="$" id="inline-form-input-sub-total"
                                     separator="," v-bind:precision="2" v-model="formFields.sub_total= getTotal[0]"></vue-numeric>
                    </b-form-group>

                    <b-form-group
                        id="input-group-1"
                        label="Tax Rate"
                        label-for="inline-form-tax-rate"
                        class="d-block col-sm-3">
                        <b-input-group size="sm" prepend="%" class="input-tax-group">
                            <b-form-input  id="inline-form-tax-rate" type="number" disabled min="0"  name="tax_rate"
                                           class="input-total tax-rate-margin-size"
                                          size="sm" v-model="formFields.tax_rate" v-on:change="taxRate"></b-form-input>
                        </b-input-group>
                    </b-form-group>


                    <b-form-group
                            id="input-group-1"
                            label="Tax Amount"
                            label-for="inline-form-tax-amount"
                            class="d-block col-sm-3">
                        <vue-numeric disable="true" readonly="true"
                                     class="mb-2 mr-sm-2 mx-1 input-total input-md form-control form-control-sm"
                                     currency="$" id="inline-form-tax-amount"
                                     separator="," v-bind:precision="2" v-model="formFields.tax_amount = getTax"></vue-numeric>
                        </b-form-group>

                    <b-form-group
                            id="input-group-1"
                            label="Invoice Total"
                            label-for="inline-form-invoice-total"
                            class="d-block col-sm-3">
                        <vue-numeric disable="true" readonly="true"
                                     class="mb-2 mr-sm-2 mx-1 input-total input-md form-control form-control-sm"
                                     currency="$" id="inline-form-invoice-total"
                                     separator="," v-bind:precision="2" v-model="invoice.invoice_total = getTotal[1]"></vue-numeric>
                        </b-form-group>
                    </div>

                </div>

                <div class="col-md-4">
                    <div>
                        <h6 class="custom-form-heading ml-1 mt-2">Payments</h6>
                    </div>

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
                    <b-col sm="12">
                        <div class="d-flex justify-content-around">
                            <label><b>Total</b> : $ {{ convertDecimal(invoicePayment.total) ? convertDecimal(invoicePayment.total) : '0.00' }}</label>
<!--                            <label><b>Total</b> : $ {{ parseFloat((invoicePayment.total).toFixed(2)) }}</label>-->
                            <label><b>Paid</b> : $ {{ convertDecimal(invoicePayment.paid) ? convertDecimal(invoicePayment.paid) : '0.00' }}</label>
<!--                            <label><b>Paid</b> : $ {{ parseFloat((invoicePayment.paid).toFixed(2)) }}</label>-->
                            <label><b>Remaining</b> : $ {{ convertDecimal(invoicePayment.remaining) ? convertDecimal(invoicePayment.remaining) : '0.00' }}</label>
<!--                            <label><b>Remaining</b> : $ {{ parseFloat((invoicePayment.remaining).toFixed(2)) }}</label>-->
                        </div>
                    </b-col>

                </div>

            </div>

            <hr class="col-md-12 mb-2">

            <b-row class="px-2">
                <b-col sm="2">
                    <label class="ml-1 mt-1">Cemetery</label>
                </b-col>
                <b-col sm="4">
                    <b-form-input id="inline-form-is-installation" size="sm" class="mb-2" v-model="cemetery" readonly></b-form-input>
                    <!--<b-dropdown no-caret class="border rounded input-select mb-2 w-100" toggle-class="" size="sm" variant="none"
                                disabled>

                        <template #button-content>
                            <div class="d-flex product-color">
                                <small>{{cemetery}}</small>
                                <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                            </div>
                        </template>

                        <b-dropdown-group class="overflow-auto scroll px-1">
                            <b-form-input
                                size="sm"
                                placeholder="Search..."
                                class="mt-1"
                                v-model="searchCemetery"
                            ></b-form-input>

                            <b-dropdown-divider class="my-1"></b-dropdown-divider>

                            <template v-if="cemeteries.length > 0">
                                <template v-for="(obj, key) of cemeteries">
                                    <b-dropdown-group>
                                        <b-dropdown-item-button class="small m-0 p-0" :key="key"
                                                                @click="formFields.cemetery_id = obj.value, $set(formFields, 'cemetery', {company:obj.text}) ">
                                            {{obj.text}}
                                        </b-dropdown-item-button>
                                    </b-dropdown-group>
                                </template>
                            </template>

                            <template v-else>
                                <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                            </template>

                        </b-dropdown-group>
                    </b-dropdown>-->
                </b-col>

                <b-col sm="2">
                    <label class="mt-1 ml-1" for="inline-form-is-installation" >Installation</label>
                </b-col>
                <b-col sm="3">
                    <b-form-input id="inline-form-is-installation" size="sm" class="mb-2" v-model="formFields.is_installation == 1 ? 'Yes' : 'No'" readonly></b-form-input>
                </b-col>

            </b-row>


        </b-form>
    </div>
</div>
</template>

<script>
    import Button from '../customer-dashboard/Button';
    import Toolbar from '../customer-dashboard/Toolbar';
    import Price from '../../Modules/Price';
    import {searchForEmptyDate} from "../../helpers/common";
    import VueNumeric from 'vue-numeric';
    import {fetchRecord} from "../../helpers/axios";
    import moment from "moment";

    export default {
        name: "Invoice",
        props: {
            id: {
                type: Number
            },
            hideInModal: {
                type: Boolean,
                default: true
            }
        },
        data(){
            return{
                formFields: {
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
                    invoice: {invoice_number: 0, payments: [],invoice_total:0},
                    order_type: null,
                    po: null,
                    production: {id: 0},
                    products: [],
                    sales_person: null,
                    store_address: null,
                    store_location: null,
                    sub_total: 0,
                    tax_rate: 0,
                    tax_amount: 0,
                },
                productTableFields: [
                    {key: 'product_number', label: "Product #", thClass: 'text-nowrap'},
                    {key: 'item_name', label: "Product Name", thClass: 'text-nowrap'},
                    {key: 'quantity', label: "Quantity"},
                    /*{key: 'price', label: "Price"},
                    {key: 'client_price', label: "Client Price"},*/
                    {key: 'amount', label: "Amount"},
                    {key: 'installation_price', label: "Installation"},
                    {key: 'total', label: "Total"},
                    {key: "showProducts", label: "Details"},
                    {
                        key: 'action',
                        label: "Action",
                        thClass: this.$props.hideInModal ? 'd-none' : '',
                        tdClass: this.$props.hideInModal ? 'd-none' : ''
                    },
                ],
                invoiceList : false,
                axiosParams: {module: 'customerPortal'},
                axiosOrderParams: {module: 'customerPortal/showOrder'},
                axiosCompanyParams: {module: 'customerPortal/companyInfo'},
                axiosCemeteryParams: {module: 'customerPortal/cemeteryInfo'},
                searchCompany: "",
                searchCemetery: ""
            }
        },
        beforeCreate(){
            if (!this.$store.getters.isPermitted({resource:'Customer Portal', action:'read'}))
                this.$router.push('/access-denied');
        },
        computed:{
            customerName: function () {
                return this.$store.getters.getUserName;
            },
            getTotal() {
                let subTotal = 0;
                let total = 0;
                for (let prod of this.formFields.products) {
                    subTotal += parseFloat(prod.total);
                }
                total = subTotal + parseFloat(this.formFields.tax_amount);
                return [parseFloat(subTotal.toFixed(2)), parseFloat(total.toFixed(2))];
            },
            getTax: function () {
                return parseFloat((this.formFields.sub_total * (this.formFields.tax_rate / 100)).toFixed(2));
            },
            invoice() {
                if (this.formFields.invoice == null) {
                    this.formFields.invoice = {invoice_number: 0, payments: [],invoice_total:0};
                }
                return this.formFields.invoice;
            },
            orderType(){
                let orderType = {
                    order_type : null
                }
                if (this.formFields.order_type_id){
                   orderType.order_type = this.formFields.order_type.type_title
                }
                return orderType
            },
            invoicePayment() {
                let data = {total: 0, paid: 0, remaining: 0};
                data.total = this.invoice.invoice_total;
                for (let payment of this.invoice.payments) {
                    data.paid += +payment.amount;
                }
                data.remaining = data.total - data.paid;
                //data.remaining = data.remaining < 0 ? 0 : data.remaining;

                return {total: data.total, paid: data.paid, remaining: data.remaining};
            },
            family() {
                if (this.formFields.family == null) {
                    this.formFields.family = {id: 0};
                }
                return this.formFields.family;
            },
            companies: function () {
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
            company() {
                let opt = "Select a company";
                let obj = {};
                if (this.$store.state.company.recordList.length > 0 && this.formFields.company_id != 0 && this.formFields.company_id != null) {
                    obj = this.$store.state.company.recordList.filter(obj => obj.id == this.formFields.company_id);
                    obj = obj[0];
                    opt = Object.keys(obj).length > 0 ? obj.name : opt;
                }
                return {selectedOpt: opt, data: obj}
            },
            cemeteries: function () {
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
                    opt = opt[0].company;
                }
                return opt
            },
        },
        components:{
            Toolbar,
            Button,
            Price,
            VueNumeric
        },
        mounted() {
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            this.getOrder(this.formFields.id);
        },
        methods:{
            /**
             * CRUD
             * */

            checkDate: function(date){
                return searchForEmptyDate(date);
            },
            changeDateFormat: function(value){
                return this.$store.getters.changeDateFormat(value);
            },
            loadInvoiceList: function () {
                this.invoiceList = !this.invoiceList;
            },
            getOrder: function (id){
                if (id){
                    // Get data from store if exists
                    let record = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == id);
                    if (record != undefined) {
                        this.formFields = {...record};
                        this.showCompositeProductDetails();
                    } else {
                        this.axiosOrderParams.id = id;
                        fetchRecord(this.axiosOrderParams, (response) => {
                            this.formFields = response.data;
                            this.showCompositeProductDetails();
                        })
                    }
                }
                // Get companies List
                if (this.$store.state.company.recordList.length == 0) {
                    this.axiosCompanyParams.id = 0;
                    fetchRecord(this.axiosCompanyParams, (response) => {
                        this.$store.state.company.recordList = response.data;
                    })
                }
                //Get cemeteries List
                if (this.$store.state.cemetery.recordList.length == 0) {
                    this.axiosCemeteryParams.id = 0;
                    fetchRecord(this.axiosCemeteryParams, (response) => {
                        this.$store.state.cemetery.recordList = response.data;
                    })
                }
            },
            showCompositeProductDetails() {
                for (let item of this.formFields.products) {
                    item.iscompositeDetails = false;
                    if (item.composite && item.composite.length > 0)
                        if (item.composite[0].composite_products && item.composite[0].composite_products.length > 0) {
                            item.iscompositeDetails = true;
                        }
                }
            },
            taxRate (){
                if(this.formFields.tax_rate == '')
                    this.formFields.tax_rate = 0;
                return this.formFields.tax_rate;
            },
            changeNumberFormat: function (value) {
                return this.$store.getters.changeNumberFormat(value);
            },
            getTotalAmount(total){
                return this.changeNumberFormat(total)
            },
            convertDecimal: function (value) {
                return this.$store.getters.changeNumberFormat(value);
            },
        },
    }
</script>

<style scoped>
    .input-date {
        min-width: 8rem;
    }
    .title-style{
        font-size: 24px;
        font-style: normal;
        letter-spacing: 0.02em;
        line-height: 28px;
    }
    @media (min-width: 576px)
    {
        .form-inline label {
            align-items:flex-start;
             justify-content: left;
        }
    }
    input{
        font-size: 0.75rem;
    }
    .tax-rate-margin-size{
        margin-top: 1.3px;
        font-size: 0.75rem;
    }
</style>
