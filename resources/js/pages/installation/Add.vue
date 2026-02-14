<template>
    <div :class="hideInModal?' custom-modal-margin':''">
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Installation</h5>
            <div class="bg-toolbar my-2 p-1">
                <Toolbar :id="formFields.id" :saveDisabled="saveDisabled"></Toolbar>
            </div>
        </div>
        <div class="col-md-12 custom-margin pr-1 my-2">
            <form class="div-shadow bg-white rounded" id="monument-form">
                <template v-if="isLoading">
                    <div class="text-center text-info my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>
                <template v-else>
                    <div v-bind:class="[alertClasses, 'd-flex justify-content-center m-auto p-1 w-50']">{{alertMessage}}</div>
                    <div class="installation-row ml-2">

                        <div>
                            <h6 class="my-auto custom-form-heading text-nowrap">Order Entry</h6>
                        </div>

                        <div>
                            <div>
                                <label>Order Status</label>
                                <b-form-select
                                    :disabled="hideInModal"
                                    :options="orderStatusList"
                                    class="form-control form-control-sm custom-caret-form b-select-width"
                                    name="collaboration[order_status_id]"
                                    size="sm"
                                    v-model="order.order_status_id"
                                    v-on:change="orderStatusLabel(order.order_status_id)">
                                    <template #first>
                                        <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                                    </template>
                                </b-form-select>
                            </div>
                            <div>
                                <label>Paper Location</label>
                                <b-form-select
                                    :disabled="hideInModal"
                                    :options="paperLocationList"
                                    class="form-control form-control-sm custom-caret-form paper-select-width"
                                    name="collaboration[order_status_id]"
                                    size="sm"
                                    v-model="order.paper_location_id"
                                    v-on:change="paperLocationLabel(order.paper_location_id)">
                                    <template #first>
                                        <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                                    </template>
                                </b-form-select>
                            </div>
                            <div>
                                <label>Order On Hold</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-md" name="order_on_hold" size="sm" type="text" v-model="order.on_hold"></b-form-input>
                            </div>
                            <div>
                                <label>Order On Hold Description</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-xxl" name="order_on_hold_description" size="sm" type="text" v-model="order.on_hold_description"></b-form-input>
                            </div>
                        </div>

                    </div>
                    <div class="installation-row">
                        <div>
                            <label>Invoice No.</label>
                            <b-form-input :value="order.invoice.invoice_number" class="input-md" readonly size="sm" type="text"></b-form-input>
                        </div>
                        <div>
                            <label>Order Date</label>
                            <b-form-input :value="changeDateFormat(order.date)" class="input-md" readonly size="sm" type="text"></b-form-input>
                        </div>
                        <div>
                            <label>Last Name on Stone</label>
                            <b-form-input :value="order.family.name_on_stone" class="input-xxxxl" readonly size="sm" type="text"></b-form-input>
                        </div>
                        <div>
                            <label>Invoice Closed Date</label>
                            <b-form-datepicker
                                :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                :disabled="hideInModal"
                                @input="order.invoice.closed_date = checkDate(order.invoice.closed_date)"
                                class="input-xl ml-auto mr-0 input-date"
                                close-button
                                locale="en"
                                placeholder=""
                                reset-button
                                size="sm"
                                today-button
                                v-model="order.invoice.closed_date">

                            </b-form-datepicker>
                        </div>
                        <div>
                            <label>Type Of Order</label>
                            <b-dropdown class="border dropdown-width rounded ml-auto" disabled no-caret size="sm" style="width: 11.5rem; background-color: #e9ecef;opacity: 1;"
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
                    </div>
                    <hr class="border">
                    <div class="installation-row d-block ml-2">
                        <div>
                            <h6 class="my-2 custom-form-heading">Installation</h6>
                        </div>
                        <div>
                            <div>
                                <label class="ml-0">Install Who</label>
                                <b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="installWho == 'Select' ? 'invisible' : '' " :title="`${installWho}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{installWho}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('install_who', searchInstallWho, 'searchInstallWho')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchInstallWho"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="installWhos.length > 0">
                                            <template v-for="(obj, key) of installWhos">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.install_who = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('install_who', searchInstallWho, 'searchInstallWho')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>
                            </div>
                            <div>
                                <label>Install Where</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-xxxl" size="sm" type="text" v-model="order.cemetery.company"></b-form-input>
                            </div>
                            <div>
                                <label>Cemetery Amount</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-xs" size="sm" type="text" v-model="formFields.cemetery_amount"></b-form-input>
                            </div>
                            <div>
                                <label>Cemetery Paid</label>
                                <b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="cemeteryPaid == 'Select' ? 'invisible' : '' " :title="`${cemeteryPaid}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{cemeteryPaid}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('cemetery_paid', searchCemeteryPaid, 'searchCemeteryPaid')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchCemeteryPaid"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="cemeteryPaids.length > 0">
                                            <template v-for="(obj, key) of cemeteryPaids">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.cemetery_paid = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('cemetery_paid', searchCemeteryPaid, 'searchCemeteryPaid')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>
                            </div>
                            <div>
                                <label>Cemetery Called To Flag</label>
                                <b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="callToFlag == 'Select' ? 'invisible' : '' " :title="`${callToFlag}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{callToFlag}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('cemetery_called_to_flag', searchCallToFlag, 'searchCallToFlag')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchCallToFlag"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="callToFlags.length > 0">
                                            <template v-for="(obj, key) of callToFlags">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.cemetery_called_to_flag = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('cemetery_called_to_flag', searchCallToFlag, 'searchCallToFlag')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>
                            </div>
                           </div>
                        <div class="mt-1">
                            <div>
                                <label class="ml-auto">Grave Flagged</label>
                                <b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="graveFlag == 'Select' ? 'invisible' : '' " :title="`${graveFlag}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{graveFlag}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('grave_flagged', searchGraveFlag, 'searchGraveFlag')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchGraveFlag"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="graveFlags.length > 0">
                                            <template v-for="(obj, key) of graveFlags">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.grave_flagged = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('grave_flagged', searchGraveFlag, 'searchGraveFlag')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>
                            </div>
                            <div>
                                <label>Cemetery Take/Mail check</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-xs" size="sm" type="text" v-model="formFields.cemetery_take_mail_check"></b-form-input>
                            </div>
                        </div>
                    </div>
                    <hr class="border">
                    <div class="installation-row">
                        <div>
                            <label>Installation Zone</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-xxl" size="sm" type="text" v-model="order.cemetery.installation_zone"></b-form-input>
                        </div>
                        <div>
                            <label>Date Promised</label>
                            <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" :disabled="hideInModal || hideinAuth"
                                               @input="formFields.order.invoice.date_promised = checkDate(formFields.order.invoice.date_promised)" class="my-auto input-date" close-button locale="en" name="date"
                                               placeholder=""
                                               reset-button
                                               size="sm"
                                               today-button
                                               v-model="formFields.order.invoice.date_promised">
                            </b-form-datepicker>
                        </div>
                        <div>
                            <label>Foundation Done</label>
                            <b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                        variant="none">
                                <template #button-content>
                                    <div class="d-flex product-color">
                                        <small :class="foundationDone == 'Select' ? 'invisible' : '' " :title="`${foundationDone}`"
                                               class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{foundationDone}}</small>
                                        <small class="w-25 ml-auto custom-caret"></small>
                                    </div>
                                </template>
                                <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                    <b-form-input
                                        :disabled="hideInModal || hideinAuth"
                                        @keyup.enter="saveCustomText('foundation_done', searchFoundationDone, 'searchFoundationDone')"
                                        class="mt-1"
                                        placeholder="Custom Text"
                                        size="sm"
                                        v-model="searchFoundationDone"
                                    ></b-form-input>
                                    <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                    <template v-if="foundationDones.length > 0">
                                        <template v-for="(obj, key) of foundationDones">
                                            <b-dropdown-group>
                                                <b-dropdown-item-button :key="key"
                                                                        @click="formFields.foundation_done = obj.value">
                                                    <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                </b-dropdown-item-button>
                                            </b-dropdown-group>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <b-dropdown-text class="text-center small"></b-dropdown-text>
                                        <button @click="saveCustomText('foundation_done', searchFoundationDone, 'searchFoundationDone')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                type="button">Add
                                        </button>
                                    </template>
                                </b-dropdown-group>
                            </b-dropdown>
                        </div>
                        <div>
                            <label>Set Stone</label>
                            <b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                        variant="none">
                                <template #button-content>
                                    <div class="d-flex product-color">
                                        <small :class="setStone == 'Select' ? 'invisible' : '' " :title="`${setStone}`"
                                               class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{setStone}}</small>
                                        <small class="w-25 ml-auto custom-caret"></small>
                                    </div>
                                </template>
                                <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                    <b-form-input
                                        :disabled="hideInModal || hideinAuth"
                                        @keyup.enter="saveCustomText('set_stone', searchSetStone, 'searchSetStone')"
                                        class="mt-1"
                                        placeholder="Custom Text"
                                        size="sm"
                                        v-model="searchSetStone"
                                    ></b-form-input>
                                    <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                    <template v-if="setStones.length > 0">
                                        <template v-for="(obj, key) of setStones">
                                            <b-dropdown-group>
                                                <b-dropdown-item-button :key="key"
                                                                        @click="formFields.set_stone = obj.value">
                                                    <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                </b-dropdown-item-button>
                                            </b-dropdown-group>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <b-dropdown-text class="text-center small"></b-dropdown-text>
                                        <button @click="saveCustomText('set_stone', searchSetStone, 'searchSetStone')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                type="button">Add
                                        </button>
                                    </template>
                                </b-dropdown-group>
                            </b-dropdown>
                       </div>
                        <div>
                            <label>Install Date</label>
                            <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" :disabled="hideInModal || hideinAuth" @input="formFields.install_date = checkDate(formFields.install_date)" class="my-auto input-date" close-button
                                               locale="en" placeholder=""
                                               reset-button
                                               size="sm"
                                               today-button
                                               v-model="formFields.install_date">
                            </b-form-datepicker>
                        </div>
                        <div>
                            <label>Customer Called After Install</label>
                            <b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                        variant="none">
                                <template #button-content>
                                    <div class="d-flex product-color">
                                        <small :class="customerInstall == 'Select' ? 'invisible' : '' " :title="`${customerInstall}`"
                                               class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{customerInstall}}</small>
                                        <small class="w-25 ml-auto custom-caret"></small>
                                    </div>
                                </template>
                                <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                    <b-form-input
                                        :disabled="hideInModal || hideinAuth"
                                        @keyup.enter="saveCustomText('customer_called_after_installation', searchCustomerInstall, 'searchCustomerInstall')"
                                        class="mt-1"
                                        placeholder="Custom Text"
                                        size="sm"
                                        v-model="searchCustomerInstall"
                                    ></b-form-input>
                                    <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                    <template v-if="customerInstalls.length > 0">
                                        <template v-for="(obj, key) of customerInstalls">
                                            <b-dropdown-group>
                                                <b-dropdown-item-button :key="key"
                                                                        @click="formFields.customer_called_after_installation = obj.value">
                                                    <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                </b-dropdown-item-button>
                                            </b-dropdown-group>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <b-dropdown-text class="text-center small"></b-dropdown-text>
                                        <button @click="saveCustomText('customer_called_after_installation', searchCustomerInstall, 'searchCustomerInstall')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                type="button">Add
                                        </button>
                                    </template>
                                </b-dropdown-group>
                            </b-dropdown>
                        </div>
                    </div>
                    <div class="installation-row d-block">
                        <div>
                            <label>Install Memo</label>
                        </div>
                        <div>
                            <b-form-textarea
                                :disabled="hideInModal || hideinAuth"
                                class="mx-2"
                                no-resize
                                rows="3"
                                size="sm"
                                v-model="formFields.install_memo"
                            ></b-form-textarea>
                        </div>
                    </div>
                    <hr class="border">
                    <div class="installation-row d-block ml-2">
                        <div>
                            <h6 class="my-2 custom-form-heading">Order Info</h6>
                        </div>
                        <div class="ml-n2">
                            <div>
                                <label>Email</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" :value="order.family.email" class="input-xl" readonly size="sm" type="text"></b-form-input>
                            </div>
                            <div>
                                <label>Company</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" :value="order.company.name" class="input-xl" readonly size="sm" type="text"></b-form-input>
                            </div>
                            <div>
                                <label>Customer Contact</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" :value="order.family.contact" class="input-xl" readonly size="sm" type="text"></b-form-input>
                            </div>
                            <div>
                                <label>Phone</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" :value="order.family.phone" class="input-xl" readonly size="sm" type="text"></b-form-input>
                            </div>
                        </div>
                    </div>
                    <div class="installation-row ml-n2">
                        <div class="col-9">
                            <b-table :fields="productsTableFields" :items="order.products" bordered
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
                        </div>
                    </div>
                    <hr class="border">
                    <div class="installation-row ml-2">
                        <router-link class="btn btn-sm btn-info custom-btn" to="/installation-load-list" v-if="!hideInModal">Installation Load Check List</router-link>
                        <router-link :to="{ name: 'TruckLoadAddInstall', query: { install_id: this.formFields.id }}" class="btn btn-sm btn-info custom-btn mx-4"
                                     v-if="!hideInModal">Truck Load List
                        </router-link>
                        <router-link class="btn btn-sm btn-info custom-btn" to="/installation-production" v-if="!hideInModal">Installation Production Form</router-link>
                        <router-link class="btn btn-sm btn-info custom-btn mx-4" to="/weekly-schedule" v-if="!hideInModal">Weekly Schedule</router-link>

                    </div>
                    <hr class="border">
                    <div class="d-flex">
                        <h5 style="margin-left: 16rem!important;">INSTALLATION CHECK LIST</h5>
                    </div>
                    <CheckList :form-fields="formFields" :hide-in-modal="hideInModal" :id="formFields.check_list.id" :in-installation="true"></CheckList>
                    <PDF :title="'InstallationCheckListForm'">

                        <div slot="header">
                            <div class="d-flex justify-content-center">
                                <h3>Installation Check List</h3>
                            </div>
                        </div>

                        <div slot="body">
                            <CheckList :formFields="formFields" :in-pdf="true"></CheckList>
                        </div>
                    </PDF>
                </template>
            </form>
        </div>
    </div>
</template>
<script>
    import Toolbar from "./Toolbar";
    import Price from "../../Modules/Price";
    import PDF from "../../Modules/PDF-Modal";
    import CheckList from "./daily-paperwork/installation-check-list/Content";
    import {event, eventBus} from "../../event-bus/event-bus";
    import {searchForEmptyDate} from "../../helpers/common";
    import {saveRecord, fetchRecord, deleteRecord, nextRecord, previousRecord, firstRecord, lastRecord, deleteTask, updateRecord} from "../../helpers/axios";

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
                    check_list: {}
                },
                productsTableFields: [
                    {key: 'product_number', label: "Product #", class: 'text-center'},
                    {key: 'item_name', label: "Product Name", class: 'text-center'},
                    {key: 'quantity', label: "Qty", class: 'text-center'},
                    {key: 'client_price', label: "Client Price"},
                    {key: 'amount', label: "Amount"},
                    {key: 'installation_price', label: "Install"},
                    {key: 'installation_amount', label: "Install Amount", thClass: 'text-nowrap'},
                    {key: 'total', label: "Total", class: 'text-center'},
                    {key: "showProducts", label: "Details"},
                ],
                axiosParams: {module: 'installation'},
                axiosOrderStatusParams: {module: 'orderStatus'},
                axiosParamsVase: {module: 'installation/vase-direction'},
                axiosParamsDepth: {module: 'installation/foundation-depth'},
                printDoc: false,
                alertMessage: '',
                hideAlert: true,
                successResponse: false,
                errorResponse: false,
                saveDisabled: false,
                hideinAuth: false,
                dropdownInstallWho: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchInstallWho: "",
                dropdownCemeteryPaid: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchCemeteryPaid: "",
                dropdownGraveFlag: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchGraveFlag: "",
                dropdownCallToFlag: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchCallToFlag: "",
                dropdownFoundationDone: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchFoundationDone: "",
                dropdownSetStone: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchSetStone: "",
                dropdownCustomerInstall: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchCustomerInstall: "",
            }
        },
        metaInfo() {
            return {
                title: `${this.formFields.id ? 'Edit' : 'Add'} Installation`,
            }
        },
        created() {
            eventBus.$on(event.SAVE_INSTALLATION, this.storeInstallation);
            eventBus.$on(event.FIRST_INSTALLATION_RECORD, this.first);
            eventBus.$on(event.LAST_INSTALLATION_RECORD, this.last);
            eventBus.$on(event.NEXT_INSTALLATION_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_INSTALLATION_RECORD, this.prev);
            eventBus.$on(event.GET_INSTALLATION, this.getDropDownInstall);
            eventBus.$on(event.ADD_INSTALLATION, this.clearForm);
            eventBus.$on(event.DELETE_INSTALLATION, this.deleteRecord);
        },
        destroyed() {
            eventBus.$off(event.SAVE_INSTALLATION, this.storeInstallation);
            eventBus.$off(event.FIRST_INSTALLATION_RECORD, this.first);
            eventBus.$off(event.LAST_INSTALLATION_RECORD, this.last);
            eventBus.$off(event.NEXT_INSTALLATION_RECORD, this.next);
            eventBus.$off(event.PREVIOUS_INSTALLATION_RECORD, this.prev);
            eventBus.$off(event.GET_INSTALLATION, this.getDropDownInstall);
            eventBus.$off(event.ADD_INSTALLATION, this.clearForm);
            eventBus.$off(event.DELETE_INSTALLATION, this.deleteRecord);
        },
        components: {
            Toolbar,
            Price,
            CheckList,
            PDF
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
            order() {
                if (this.formFields.order == null) {
                    this.formFields.order = {invoice: {}, cemetery: {}, family: {}, company: {}, products: []};
                }
                return this.formFields.order
            },
            orderStatusList() {
                let list = []
                for (let opt of this.$store.state[this.axiosOrderStatusParams.module].recordList) {
                    list.push({value: opt.id, text: opt.title});
                }
                return list;
            },
            paperLocationList() {
                let list = []
                for (let opt of this.$store.state.paperLocation.recordList) {
                    list.push({value: opt.id, text: opt.location_title});
                }
                this.$store.state.paperLocation.busy = false;
                return list;

            },
            installWho() {
                let opt = 'Select'
                if (this.formFields.install_who != null && (this.formFields.install_who == 'yes' || this.formFields.install_who == 'n/a')) {
                    opt = this.dropdownInstallWho.filter(obj => obj.value == this.formFields.install_who)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.install_who != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.install_who)
                    && this.formFields.install_who != 'currentDate') {
                    opt = this.formFields.install_who
                } else if (this.formFields.install_who != null) {
                    opt = this.dropdownInstallWho.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.install_who)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownInstallWho.findIndex(findIn => findIn.value == this.formFields.install_who)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.install_who
                                    objTwo.text = this.formFields.install_who
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownInstallWho)
                    this.formFields.install_who = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            installWhos() {
                let options = this.dropdownInstallWho;
                if (this.searchInstallWho != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchInstallWho.toUpperCase()) > -1)
                }
                return options
            },
            cemeteryPaid() {
                let opt = 'Select'
                if (this.formFields.cemetery_paid != null && (this.formFields.cemetery_paid == 'yes' || this.formFields.cemetery_paid == 'n/a')) {
                    opt = this.dropdownCemeteryPaid.filter(obj => obj.value == this.formFields.cemetery_paid)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.cemetery_paid != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.cemetery_paid)
                    && this.formFields.cemetery_paid != 'currentDate') {
                    opt = this.formFields.cemetery_paid
                } else if (this.formFields.cemetery_paid != null) {
                    opt = this.dropdownCemeteryPaid.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.cemetery_paid)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownCemeteryPaid.findIndex(findIn => findIn.value == this.formFields.cemetery_paid)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.cemetery_paid
                                    objTwo.text = this.formFields.cemetery_paid
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownCemeteryPaid)
                    this.formFields.cemetery_paid = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            cemeteryPaids() {
                let options = this.dropdownCemeteryPaid;
                if (this.searchCemeteryPaid != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchCemeteryPaid.toUpperCase()) > -1)
                }
                return options
            },
            callToFlag() {
                let opt = 'Select'
                if (this.formFields.cemetery_called_to_flag != null && (this.formFields.cemetery_called_to_flag == 'yes' || this.formFields.cemetery_called_to_flag == 'n/a')) {
                    opt = this.dropdownCallToFlag.filter(obj => obj.value == this.formFields.cemetery_called_to_flag)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.cemetery_called_to_flag != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.cemetery_called_to_flag)
                    && this.formFields.cemetery_called_to_flag != 'currentDate') {
                    opt = this.formFields.cemetery_called_to_flag
                } else if (this.formFields.cemetery_called_to_flag != null) {
                    opt = this.dropdownCallToFlag.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.cemetery_called_to_flag)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownCallToFlag.findIndex(findIn => findIn.value == this.formFields.cemetery_called_to_flag)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.cemetery_called_to_flag
                                    objTwo.text = this.formFields.cemetery_called_to_flag
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownCallToFlag)
                    this.formFields.cemetery_called_to_flag = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            callToFlags() {
                let options = this.dropdownCallToFlag;
                if (this.searchCallToFlag != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchCallToFlag.toUpperCase()) > -1)
                }
                return options
            },
            graveFlag() {
                let opt = 'Select'
                if (this.formFields.grave_flagged != null && (this.formFields.grave_flagged == 'yes' || this.formFields.grave_flagged == 'n/a')) {
                    opt = this.dropdownGraveFlag.filter(obj => obj.value == this.formFields.grave_flagged)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.grave_flagged != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.grave_flagged)
                    && this.formFields.grave_flagged != 'currentDate') {
                    opt = this.formFields.grave_flagged
                } else if (this.formFields.grave_flagged != null) {
                    opt = this.dropdownGraveFlag.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.grave_flagged)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownGraveFlag.findIndex(findIn => findIn.value == this.formFields.grave_flagged)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.grave_flagged
                                    objTwo.text = this.formFields.grave_flagged
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownGraveFlag)
                    this.formFields.grave_flagged = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            graveFlags() {
                let options = this.dropdownGraveFlag;
                if (this.searchGraveFlag != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchGraveFlag.toUpperCase()) > -1)
                }
                return options
            },
            foundationDone() {
                let opt = 'Select'
                if (this.formFields.foundation_done != null && (this.formFields.foundation_done == 'yes' || this.formFields.foundation_done == 'n/a')) {
                    opt = this.dropdownFoundationDone.filter(obj => obj.value == this.formFields.foundation_done)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.foundation_done != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.foundation_done)
                    && this.formFields.foundation_done != 'currentDate') {
                    opt = this.formFields.foundation_done
                } else if (this.formFields.foundation_done != null) {
                    opt = this.dropdownFoundationDone.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.foundation_done)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownFoundationDone.findIndex(findIn => findIn.value == this.formFields.foundation_done)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.foundation_done
                                    objTwo.text = this.formFields.foundation_done
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownFoundationDone)
                    this.formFields.foundation_done = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            foundationDones() {
                let options = this.dropdownFoundationDone;
                if (this.searchFoundationDone != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchFoundationDone.toUpperCase()) > -1)
                }
                return options
            },
            setStone() {
                let opt = 'Select'
                if (this.formFields.set_stone != null && (this.formFields.set_stone == 'yes' || this.formFields.set_stone == 'n/a')) {
                    opt = this.dropdownSetStone.filter(obj => obj.value == this.formFields.set_stone)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.set_stone != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.set_stone)
                    && this.formFields.set_stone != 'currentDate') {
                    opt = this.formFields.set_stone
                } else if (this.formFields.set_stone != null) {
                    opt = this.dropdownSetStone.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.set_stone)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownSetStone.findIndex(findIn => findIn.value == this.formFields.set_stone)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.set_stone
                                    objTwo.text = this.formFields.set_stone
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownSetStone)
                    this.formFields.set_stone = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            setStones() {
                let options = this.dropdownSetStone;
                if (this.searchSetStone != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchSetStone.toUpperCase()) > -1)
                }
                return options
            },
            customerInstall() {
                let opt = 'Select'
                if (this.formFields.customer_called_after_installation != null && (this.formFields.customer_called_after_installation == 'yes' || this.formFields.customer_called_after_installation == 'n/a')) {
                    opt = this.dropdownCustomerInstall.filter(obj => obj.value == this.formFields.customer_called_after_installation)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.customer_called_after_installation != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.customer_called_after_installation)
                    && this.formFields.customer_called_after_installation != 'currentDate') {
                    opt = this.formFields.customer_called_after_installation
                } else if (this.formFields.customer_called_after_installation != null) {
                    opt = this.dropdownCustomerInstall.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.customer_called_after_installation)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownCustomerInstall.findIndex(findIn => findIn.value == this.formFields.customer_called_after_installation)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.customer_called_after_installation
                                    objTwo.text = this.formFields.customer_called_after_installation
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownCustomerInstall)
                    this.formFields.customer_called_after_installation = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            customerInstalls() {
                let options = this.dropdownCustomerInstall;
                if (this.searchCustomerInstall != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchCustomerInstall.toUpperCase()) > -1)
                }
                return options
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
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Installation', action: 'read'}))
                this.$router.push('/access-denied');
        },
        mounted() {
            this.$store.state[this.axiosParams.module].busy = true
            // this.formFields.store_id = this.storeID
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            if (!this.$store.getters.isPermitted({resource: 'Installation', action: 'create'}) && !this.$store.getters.isPermitted({resource: 'Installation', action: 'update'}))
                this.$props.hideInModal = true;
            if (this.formFields.id > 0 && !this.$store.getters.isPermitted({resource: 'Installation', action: 'update'}))
                this.hideinAuth = true;
            this.getInstallation(this.formFields.id);
            this.getColumns();
            this.getRecords();
            this.$store.getters.detectFormChanges();
        },
        methods: {
            /** CRUD */
            getDropDownInstall: function (id) {
                this.axiosParams.id = id;
                fetchRecord(this.axiosParams, (response) => {
                    this.$store.getters.changedCompositePrice(response.data.order.products);
                    this.formFields = response.data;
                    this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                    this.showCompositeProductDetails();
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                })
            },
            getInstallation: function (id) {
                if (id) {
                    this.axiosParams.id = id;
                    fetchRecord(this.axiosParams, (response) => {
                        this.$store.getters.changedCompositePrice(response.data.order.products);
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.showCompositeProductDetails();
                        if (this.$store.state[this.axiosParams.module].recordList.length > 0)
                            this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        console.log(error)
                    })
                }
                this.$store.dispatch('getPaperLocationInfo');
                this.$store.dispatch('getModuleInfo', this.axiosOrderStatusParams);

                this.axiosParamsVase.id = 0;
                fetchRecord(this.axiosParamsVase, (response) => {
                    this.$store.state[this.axiosParams.module].vaseDirection = response.data;
                    this.$store.getters.sortByAlphaNumeric({'fieldName': 'direction', 'recordList': this.$store.state[this.axiosParams.module].vaseDirection});
                })
                this.axiosParamsDepth.id = 0
                fetchRecord(this.axiosParamsDepth, (response) => {
                    this.$store.state[this.axiosParams.module].foundationDepth = response.data
                    this.$store.getters.sortByAlphaNumeric({'fieldName': 'depth', 'recordList': this.$store.state[this.axiosParams.module].foundationDepth});
                })
            },
            changeDateFormat: function (value) {
                return this.$store.getters.changeDateFormat(value);
            },
            changeNumberFormat: function (value) {
                return this.$store.getters.changeNumberFormat(value);
            },
            storeInstallation: function () {
                this.saveDisabled = true;
                let data = this.formFields;
                let formData = new FormData();
                formData.append('installing_area_image_file', this.formFields.check_list.installing_area_image_file);
                formData.append('before_pouring_concrete_image_file', this.formFields.check_list.before_pouring_concrete_image_file);
                formData.append('after_pouring_concrete_image_file', this.formFields.check_list.after_pouring_concrete_image_file);
                formData.append('finished_installed_image_file', this.formFields.check_list.finished_installed_image_file);
                formData.append('damaged_grave_image_file', this.formFields.check_list.damaged_grave_image_file);
                formData.append('data', JSON.stringify(data));

                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: this.alertMessage, variant: 'danger', duration: 5000});
                        this.alertMessage = '';
                    } else {
                        let status = this.formFields.id ? 'Updated' : 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                        this.makeToast({title: 'Installation ' + status, message: this.alertMessage, variant: 'success'});


                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.$store.getters.changedCompositePrice(this.formFields.order.products);
                        this.showCompositeProductDetails();
                        //this.axiosParams.data = response.data;
                        this.alertMessage = '';
                        this.axiosParams.data =
                            {
                                id: this.formFields.id,
                                order: {
                                    id: this.formFields.order_id, collaboration: {id: this.formFields.order.collaboration.id, order_id: this.formFields.order_id},
                                    invoice: {invoice_number: this.formFields.order.invoice.invoice_number, order_id: this.formFields.order_id},
                                    production: {id: this.formFields.order.production.id, order_id: this.formFields.order_id}
                                },
                                order_id: this.formFields.order_id
                            };
                        this.$store.commit('appendOrUpdateDropDown', this.axiosParams)
                        //this.$store.commit('appendOrUpdateInRecordList', this.axiosParams);

                        // Update Order record in store (in case of changing order_status, paper_location,on_hold_order,on_hold_order_description)
                        this.$store.commit('appendOrUpdateInRecordList', {module: 'order', data: this.formFields.order});
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

            /** Pagination*/
            first: function () {
                firstRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.$store.getters.changedCompositePrice(this.formFields.order.products);
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                })
            },
            last: function () {
                lastRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.$store.getters.changedCompositePrice(this.formFields.order.products);
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                })
            },
            next: function (id) {
                this.axiosParams.id = id;
                nextRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.$store.getters.changedCompositePrice(this.formFields.order.products);
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                })
            },
            prev: function (id) {
                this.axiosParams.id = id;
                previousRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.$store.getters.changedCompositePrice(this.formFields.order.products);
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
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
                        id: 0, check_list: {}
                    };
                    this.$store.state[this.axiosParams.module].currentRecord = []
                }
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
                this.saveDisabled = false;

            },
            paperLocationLabel: function (id) {
                let option = 'Select';
                for (let opt of this.$store.state.paperLocation.recordList) {
                    if (opt.id == id)
                        option = opt.location_title;
                }
                return option;
            },
            orderStatusLabel: function (id) {
                let option = 'select';
                for (let opt of this.$store.state.orderStatus.recordList) {
                    if (opt.id == id) {
                        option = opt.title;
                    }
                }
                return option;
            },
            checkDate: function (date) {
                return searchForEmptyDate(date);
            },
            saveCustomText: function (columnName, searchValue, searchState) {
                if (searchValue && this.formFields.id) {
                    let data = {}
                    data.id = this.formFields.id
                    data.columnName = columnName
                    data.valueToSave = searchValue
                    let formData = new FormData()
                    formData.append('data', JSON.stringify(data));
                    updateRecord({module: this.axiosParams.module, apiURL: 'saveCustomText'}, formData, (response) => {
                        if (response.data) {
                            this.formFields[columnName] = searchValue
                            this[searchState] = ''
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

    .installation-row {
        display: flex;
        margin: 0.5rem 0;
        padding-left: 1rem;
    }

    .installation-row div {
        display: flex;
    }

    .installation-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
    }

    .installation-row div input, textarea {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.75rem;
    }

    .input-xxl {
        width: 15rem;
    }

    .input-xxxl {
        width: 23rem;
    }

    .input-xl {
        width: 13rem;
    }

    .input-lg {
        width: 10rem;
    }

    .input-md {
        width: 7rem;
    }

    .input-sm {
        width: 6.3rem;
    }

    .input-xs {
        width: 4.5rem;
    }

    .input-date {
        font-size: 0.75rem !important;
    }

    .border {
        border: 1px solid #c4c4c4 !important;
    }

    .custom-btn {
        box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.25);
        border-radius: 5px;
        font-size: 12px;
        letter-spacing: 0.02em;
    }

    .custom-modal-margin {
        padding-top: 0.5rem;
        margin-right: -4rem;
        padding-left: 0rem;
        padding-bottom: .2rem;
        background-color: #e9ecef;
    }

    textarea:focus, input:focus {
        outline: none;
    }

    .b-select-width {
        width: 13rem;
    }

    .paper-select-width {
        width: 16rem;
    }

    .input-xxxxl {
        width: 20rem;
    }

    .text-custom-width {
        width: 5rem;
    }

    .order-form-btn {
        font-size: 0.5rem;
    }
</style>


