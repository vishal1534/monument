<template>
    <div :class="hideInModal?' custom-modal-margin':''">
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Production</h5>
            <div class="bg-toolbar my-2 p-1">
                <Toolbar :id="formFields.id" :saveDisabled="saveDisabled"></Toolbar>
            </div>
        </div>
        <div class="col-md-12 custom-margin pr-1 my-3">
            <form class="div-shadow bg-white rounded">
                <template v-if="isLoading">
                    <div class="text-center text-info my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>
                <template v-else>
                    <div class="custom-row ml-auto justify-content-between">

                        <div class="mt-2">
                            <h6 class="m-0 custom-form-heading">Order Entry</h6>
                        </div>

                        <div class="bg-primary text-white p-1 rounded mb-1 mr-1 mt-2" v-if="!hideInModal && formFields.id">
                            <label class="">Forms</label>
                            <router-link :class="formFields.order.porcelain?.id ? 'btn-success' : 'btn-info' " :to="{name: 'production_porcelain', params: { id:formFields.order_id,production_id: formFields.id }}"
                                         class="btn btn-sm custom-form-btn py-1 px-1 mx-1 order-form">Porcelain
                            </router-link>
                            <router-link :class="formFields.order.order_installation?.id ? 'btn-success' : 'btn-info' " :to="{name: 'production_install', params: { id:formFields.order_id,production_id: formFields.id }}"
                                         class="btn btn-sm custom-form-btn py-1 px-1 order-form">Install
                            </router-link>
                            <router-link :class="formFields.order.memorial_production?.id ? 'btn-success' : 'btn-info' " :to="{name: 'production_memorial', params: { id:formFields.order_id,production_id: formFields.id }}"
                                         class="btn btn-sm custom-form-btn py-1 px-1 mx-1 order-form">Memorial
                            </router-link>
                            <router-link :class="formFields.order.approval_monument?.id ? 'btn-success' : 'btn-info' " :to="{name: 'production_approval', params: { id:formFields.order_id,production_id: formFields.id }}"
                                         class="btn btn-sm custom-form-btn py-1 px-1 order-form">Approval
                            </router-link>
                        </div>

                    </div>
                    <div class="custom-row">
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
                            <b-form-input :value="changeDateFormat(order.invoice.closed_date)" class="input-md" readonly size="sm" type="text"></b-form-input>
                        </div>
                        <div>
                            <label>Type Of Order</label>
                            <b-dropdown class="border dropdown-width rounded m-auto" disabled no-caret size="sm" style="width: 11.2rem; background-color: #e9ecef;opacity: 1;"
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
                    <div class="custom-row">
                        <div class="custom-border-right my-n2 pr-1">
                            <div>
                                <label>Monument in Stock</label>
                                <dropDownGroup :customStock="monumentStock" :customStocks="monumentStocks" :fieldName="'monument_in_stock'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isMonumentStock'" :refName="'monumentDatePicker'" :searchFieldName="'searchMonumentStock'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isMonumentStock'" :datePickerRefName="'monumentDatePicker'" :formFieldName="'monument_in_stock'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="monumentDatePicker"
                                            v-show="isMonumentStock"></datePicker>
                                <!--

                                                                <b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                                                            variant="none">
                                                                    <template #button-content>
                                                                        <div class="d-flex product-color">
                                                                            <small :class="monumentStock == 'Select' ? 'invisible' : '' " :title="`${monumentStock}`"
                                                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{monumentStock}}</small>
                                                                            <small class="w-25 ml-auto custom-caret"></small>
                                                                        </div>
                                                                    </template>
                                                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                                                        <b-form-input
                                                                            :disabled="hideInModal || hideinAuth"
                                                                            @keyup.enter="saveCustomText('monument_in_stock', searchMonumentStock, 'searchMonumentStock')"
                                                                            class="mt-1"
                                                                            placeholder="Custom Text"
                                                                            size="sm"
                                                                            v-model="searchMonumentStock"
                                                                        ></b-form-input>
                                                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                                                        <template v-if="monumentStocks.length > 0">
                                                                            <template v-for="(obj, key) of monumentStocks">
                                                                                <b-dropdown-group>
                                                                                    &lt;!&ndash;                                                @click="formFields.monument_in_stock = obj.value" checkForDate(obj)&ndash;&gt;
                                                                                    <b-dropdown-item-button :key="key"
                                                                                                            @click="formFields.monument_in_stock = obj.value">
                                                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                                                    </b-dropdown-item-button>
                                                                                </b-dropdown-group>
                                                                            </template>
                                                                        </template>
                                -->
                                <!--

                                                                        <template v-else>
                                                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                                                            <button @click="saveCustomText('monument_in_stock', searchMonumentStock, 'searchMonumentStock')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                                                    type="button">Add
                                                                            </button>
                                                                        </template>
                                                                    </b-dropdown-group>
                                                                </b-dropdown>
                                -->
                            </div>
                            <div>
                                <label>On-Order Who</label>
                                <dropDownGroup :customStock="onOrderWho" :customStocks="onOrderWhos" :fieldName="'on_order_who'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isOrderWho'" :refName="'orderWhoDatePicker'" :searchFieldName="'searchOrderWho'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isOrderWho'" :datePickerRefName="'orderWhoDatePicker'" :formFieldName="'on_order_who'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="orderWhoDatePicker"
                                            v-show="isOrderWho"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="onOrderWho == 'Select' ? 'invisible' : '' " :title="`${onOrderWho}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{onOrderWho}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('on_order_who', searchOrderWho, 'searchOrderWho')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchOrderWho"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="onOrderWhos.length > 0">
                                            <template v-for="(obj, key) of onOrderWhos">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.on_order_who = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('on_order_who', searchOrderWho, 'searchOrderWho')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                        </div>
                        <div class="custom-border-right my-n2 pr-1">
                            <div>
                                <label>Vendor Proof</label>
                                <dropDownGroup :customStock="vendorProof" :customStocks="vendorProofs" :fieldName="'order_who_vendor_proof'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isVendorProof'" :refName="'vendorProofDatePicker'" :searchFieldName="'searchVendorProof'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isVendorProof'" :datePickerRefName="'vendorProofDatePicker'" :formFieldName="'order_who_vendor_proof'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="vendorProofDatePicker"
                                            v-show="isVendorProof"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="vendorProof == 'Select' ? 'invisible' : '' " :title="`${vendorProof}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{vendorProof}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('order_who_vendor_proof', searchVendorProof, 'searchVendorProof')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchVendorProof"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="vendorProofs.length > 0">
                                            <template v-for="(obj, key) of vendorProofs">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.order_who_vendor_proof = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('order_who_vendor_proof', searchVendorProof, 'searchVendorProof')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>On-Order In Stock</label>
                                <dropDownGroup :customStock="orderInStock" :customStocks="orderInStocks" :fieldName="'on_order_in_stock'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isOrderInStock'" :refName="'orderInStockDatePicker'" :searchFieldName="'searchOrderInStock'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isOrderInStock'" :datePickerRefName="'orderInStockDatePicker'" :formFieldName="'on_order_in_stock'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="orderInStockDatePicker"
                                            v-show="isOrderInStock"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="orderInStock == 'Select' ? 'invisible' : '' " :title="`${orderInStock}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{orderInStock}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('on_order_in_stock', searchOrderInStock, 'searchOrderInStock')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchOrderInStock"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="orderInStocks.length > 0">
                                            <template v-for="(obj, key) of orderInStocks">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.on_order_in_stock = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('on_order_in_stock', searchOrderInStock, 'searchOrderInStock')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                        </div>
                        <div>
                            <div>
                                <label>Picture Who</label>
                                <dropDownGroup :customStock="pictureWho" :customStocks="pictureWhos" :fieldName="'picture_who'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isPickureWho'" :refName="'pictureWhoDatePicker'" :searchFieldName="'searchPictureWho'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isPickureWho'" :datePickerRefName="'pictureWhoDatePicker'" :formFieldName="'picture_who'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="pictureWhoDatePicker"
                                            v-show="isPickureWho"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="pictureWho == 'Select' ? 'invisible' : '' " :title="`${pictureWho}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{pictureWho}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('picture_who', searchPictureWho, 'searchPictureWho')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchPictureWho"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="pictureWhos.length > 0">
                                            <template v-for="(obj, key) of pictureWhos">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.picture_who = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('picture_who', searchPictureWho, 'searchPictureWho')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Vendor Proof</label>
                                <dropDownGroup :customStock="pictureVendorProof" :customStocks="pictureVendorProofs" :fieldName="'picture_who_vendor_proof'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isPickureVenProof'" :refName="'pictureVenProofDatePicker'" :searchFieldName="'searchPictureVendorProof'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isPickureVenProof'" :datePickerRefName="'pictureVenProofDatePicker'" :formFieldName="'picture_who_vendor_proof'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="pictureVenProofDatePicker"
                                            v-show="isPickureVenProof"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="pictureVendorProof == 'Select' ? 'invisible' : '' " :title="`${pictureVendorProof}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{pictureVendorProof}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('picture_who_vendor_proof', searchPictureVendorProof, 'searchPictureVendorProof')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchPictureVendorProof"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="pictureVendorProofs.length > 0">
                                            <template v-for="(obj, key) of pictureVendorProofs">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.picture_who_vendor_proof = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('picture_who_vendor_proof', searchPictureVendorProof, 'searchPictureVendorProof')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                        </div>
                    </div>
                    <hr class="border">
                    <div class="custom-row">
                        <div class="custom-border-right my-n2 pr-1">
                            <div>
                                <label>Picture In Stock</label>
                                <dropDownGroup :customStock="pictureInStock" :customStocks="pictureInStocks" :fieldName="'picture_in_stock'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isPickureInStock'" :refName="'pictureInStockPicker'" :searchFieldName="'searchPictureInStock'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isPickureInStock'" :datePickerRefName="'pictureInStockPicker'" :formFieldName="'picture_in_stock'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="pictureInStockPicker"
                                            v-show="isPickureInStock"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="pictureInStock == 'Select' ? 'invisible' : '' " :title="`${pictureInStock}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{pictureInStock}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('picture_in_stock', searchPictureInStock, 'searchPictureInStock')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchPictureInStock"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="pictureInStocks.length > 0">
                                            <template v-for="(obj, key) of pictureInStocks">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.picture_in_stock = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('picture_in_stock', searchPictureInStock, 'searchPictureInStock')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Vase Who</label>
                                <dropDownGroup :customStock="vaseWho" :customStocks="vaseWhos" :fieldName="'vase_who'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isVaseWho'" :refName="'vaseWhoPicker'" :searchFieldName="'searchVaseWho'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isVaseWho'" :datePickerRefName="'vaseWhoPicker'" :formFieldName="'vase_who'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="vaseWhoPicker"
                                            v-show="isVaseWho"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="vaseWho == 'Select' ? 'invisible' : '' " :title="`${vaseWho}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{vaseWho}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('vase_who', searchVaseWho, 'searchVaseWho')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchVaseWho"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="vaseWhos.length > 0">
                                            <template v-for="(obj, key) of vaseWhos">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.vase_who = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('vase_who', searchVaseWho, 'searchVaseWho')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Vase In Stock</label>
                                <dropDownGroup :customStock="vaseInStock" :customStocks="vaseInStocks" :fieldName="'vase_in_stock'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isVaseInStock'" :refName="'vaseInStockPicker'" :searchFieldName="'searchVaseInStock'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isVaseInStock'" :datePickerRefName="'vaseInStockPicker'" :formFieldName="'vase_in_stock'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="vaseInStockPicker"
                                            v-show="isVaseInStock"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="vaseInStock == 'Select' ? 'invisible' : '' " :title="`${vaseInStock}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{vaseInStock}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('vase_in_stock', searchVaseInStock, 'searchVaseInStock')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchVaseInStock"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="vaseInStocks.length > 0">
                                            <template v-for="(obj, key) of vaseInStocks">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.vase_in_stock = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('vase_in_stock', searchVaseInStock, 'searchVaseInStock')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                        </div>
                        <div class="custom-border-right my-n2 pr-1">
                            <div>
                                <label>Access Who</label>
                                <dropDownGroup :customStock="accessWho" :customStocks="accessWhos" :fieldName="'access_who'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isAccessWho'" :refName="'accessWhoPicker'" :searchFieldName="'searchAccessWho'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isAccessWho'" :datePickerRefName="'accessWhoPicker'" :formFieldName="'access_who'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="accessWhoPicker"
                                            v-show="isAccessWho"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="accessWho == 'Select' ? 'invisible' : '' " :title="`${accessWho}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{accessWho}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('access_who', searchAccessWho, 'searchAccessWho')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchAccessWho"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="accessWhos.length > 0">
                                            <template v-for="(obj, key) of accessWhos">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.access_who = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('access_who', searchAccessWho, 'searchAccessWho')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Access In Stock</label>
                                <dropDownGroup :customStock="accessInStock" :customStocks="accessInStocks" :fieldName="'access_in_stock'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isAccessInStock'" :refName="'accessInStockPicker'" :searchFieldName="'searchAccessInStock'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isAccessInStock'" :datePickerRefName="'accessInStockPicker'" :formFieldName="'access_in_stock'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="accessInStockPicker"
                                            v-show="isAccessInStock"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="accessInStock == 'Select' ? 'invisible' : '' " :title="`${accessInStock}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{accessInStock}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('access_in_stock', searchAccessInStock, 'searchAccessInStock')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchAccessInStock"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="accessInStocks.length > 0">
                                            <template v-for="(obj, key) of accessInStocks">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.access_in_stock = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('access_in_stock', searchAccessInStock, 'searchAccessInStock')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                        </div>
                        <div>
                            <div>
                                <label>Rubbing Need</label>
                                <dropDownGroup :customStock="rubbingNeed" :customStocks="rubbingNeeds" :fieldName="'rubbing_need'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isRubbingNeed'" :refName="'rubbingNeedPicker'" :searchFieldName="'searchRubbingNeed'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isRubbingNeed'" :datePickerRefName="'rubbingNeedPicker'" :formFieldName="'rubbing_need'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="rubbingNeedPicker"
                                            v-show="isRubbingNeed"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="rubbingNeed == 'Select' ? 'invisible' : '' " :title="`${rubbingNeed}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{rubbingNeed}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('rubbing_need', searchRubbingNeed, 'searchRubbingNeed')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchRubbingNeed"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="rubbingNeeds.length > 0">
                                            <template v-for="(obj, key) of rubbingNeeds">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.rubbing_need = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('rubbing_need', searchRubbingNeed, 'searchRubbingNeed')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                        </div>
                    </div>
                    <hr class="border">
                    <div class="custom-row">
                        <div>
                            <div>
                                <label>Design In House</label>
                                <dropDownGroup :customStock="designInHouse" :customStocks="designInHouses" :fieldName="'design_in_house'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isDesignInHouse'" :refName="'designInHousePicker'" :searchFieldName="'searchDesignInHouse'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isDesignInHouse'" :datePickerRefName="'designInHousePicker'" :formFieldName="'design_in_house'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="designInHousePicker"
                                            v-show="isDesignInHouse"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="designInHouse == 'Select' ? 'invisible' : '' " :title="`${designInHouse}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{designInHouse}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('design_in_house', searchDesignInHouse, 'searchDesignInHouse')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchDesignInHouse"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="designInHouses.length > 0">
                                            <template v-for="(obj, key) of designInHouses">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.design_in_house = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('design_in_house', searchDesignInHouse, 'searchDesignInHouse')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Design Customer</label>
                                <dropDownGroup :customStock="designInCustomer" :customStocks="designInCustomers" :fieldName="'design_customer'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isDesignInCustomer'" :refName="'designInCustomerPicker'" :searchFieldName="'searchDesignInCustomer'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isDesignInCustomer'" :datePickerRefName="'designInCustomerPicker'" :formFieldName="'design_customer'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="designInCustomerPicker"
                                            v-show="isDesignInCustomer"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="designInCustomer == 'Select' ? 'invisible' : '' " :title="`${designInCustomer}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{designInCustomer}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('design_customer', searchDesignInCustomer, 'searchDesignInCustomer')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchDesignInCustomer"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="designInCustomers.length > 0">
                                            <template v-for="(obj, key) of designInCustomers">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.design_customer = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('design_customer', searchDesignInCustomer, 'searchDesignInCustomer')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Cemetery Approval Needed</label>
                                <dropDownGroup :customStock="cemeteryApproved" :customStocks="cemeteryApprovedes" :fieldName="'cemetery_approval_needed'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isCemetApproveNeeded'" :refName="'cemeteryApprovedNeedPicker'" :searchFieldName="'searchCemeteryApproved'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isCemetApproveNeeded'" :datePickerRefName="'cemeteryApprovedNeedPicker'" :formFieldName="'cemetery_approval_needed'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="cemeteryApprovedNeedPicker"
                                            v-show="isCemetApproveNeeded"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="cemeteryApproved == 'Select' ? 'invisible' : '' " :title="`${cemeteryApproved}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{cemeteryApproved}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('cemetery_approval_needed', searchCemeteryApproved, 'searchCemeteryApproved')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchCemeteryApproved"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="cemeteryApprovedes.length > 0">
                                            <template v-for="(obj, key) of cemeteryApprovedes">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.cemetery_approval_needed = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('cemetery_approval_needed', searchCemeteryApproved, 'searchCemeteryApproved')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Install Form Cemetery</label>
                                <dropDownGroup :customStock="installCemetery" :customStocks="installCemeteries" :fieldName="'install_from_cemetery'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isInstallCemetery'" :refName="'installFromCemetPicker'" :searchFieldName="'searchInstallCemetery'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isInstallCemetery'" :datePickerRefName="'installFromCemetPicker'" :formFieldName="'install_from_cemetery'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="installFromCemetPicker"
                                            v-show="isInstallCemetery"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="installCemetery == 'Select' ? 'invisible' : '' " :title="`${installCemetery}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{installCemetery}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('install_from_cemetery', searchInstallCemetery, 'searchInstallCemetery')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchInstallCemetery"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="installCemeteries.length > 0">
                                            <template v-for="(obj, key) of installCemeteries">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.install_from_cemetery = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('install_from_cemetery', searchInstallCemetery, 'searchInstallCemetery')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                        </div>
                    </div>
                    <hr class="border">
                    <div class="custom-row d-block">
                        <div>
                            <h6 class="my-2 custom-form-heading">Collaboration</h6>
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
                                    v-on:change="checkOrderStatus(order.order_status_id)">
                                    <template #first>
                                        <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                                    </template>
                                </b-form-select>
                                <!--<b-dropdown no-caret class="border rounded" style="width:10rem" size="sm" variant="none" :disabled="hideInModal || hideinAuth">

                                    <template #button-content>
                                        <div class="d-flex">
                                            <small>{{ order.order_status_id ?
                                                orderStatusLabel(order.order_status_id) : 'Select' }}</small>
                                            <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                                        </div>
                                    </template>

                                    <b-dropdown-group class="overflow-auto scroll px-1">
                                        <template v-for="obj of orderStatusList" >
                                            <b-dropdown-group>
                                                <b-dropdown-item-button class="small"  @click="checkOrderStatus(order.order_status_id = obj.value)">
                                                    {{ obj.text }}
                                                </b-dropdown-item-button>
                                            </b-dropdown-group>
                                        </template>
                                    </b-dropdown-group>

                                </b-dropdown>-->
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
                                <!--<b-dropdown no-caret class="border rounded" style="width:18rem" toggle-class="" size="sm" variant="none" :disabled="hideInModal || hideinAuth">

                                    <template #button-content>
                                        <div class="d-flex">
    &lt;!&ndash;                                        <small>{{ order.paper_location ? customizeLabel(order.paper_location) : 'Select' }}</small>&ndash;&gt;
                                            <small>{{ order.paper_location_id ? paperLocationLabel(order.paper_location_id) : 'Select'
                                                }}
                                            </small>
                                            <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                                        </div>
                                    </template>

                                    <b-dropdown-group class="overflow-auto scroll px-1">
                                        <template v-for="obj of paperLocationList" >
                                            <b-dropdown-group>
                                               &lt;!&ndash; <b-dropdown-item-button class="small"  @click="order.paper_location = obj.value">
                                                    {{ obj.text }}
                                                </b-dropdown-item-button>&ndash;&gt;
                                                <b-dropdown-item-button class="small" @click="order.paper_location_id = obj.value">
                                                    {{ obj.text }}
                                                </b-dropdown-item-button>
                                            </b-dropdown-group>
                                        </template>
                                    </b-dropdown-group>

                                </b-dropdown>-->
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
                    <div class="custom-row bg-primary mt-2" v-if="!hideInModal">
                        <button @click="addTask('collaboration')" class="btn btn-sm list-toolbar m-1 border-0" type="button">Add Task</button>
                        <button :disabled="deleteCollaborationTasks.length==0" @click="deleteTask('collaboration')" class="btn btn-sm list-toolbar m-1 border-0" type="button">Delete Task</button>
                    </div>
                    <div class="custom-row d-block">
                        <div v-if="order.collaboration.tasks.length>0">

                            <div class="" style="visibility: hidden;">
                                <input type="checkbox">
                            </div>

                            <div class="col-1 task-collaboration-date" style="margin-left: 3px;">
                                <label class="m-0">Date</label>
                            </div>

                            <div class="col-2 ml-n4 collaboration-task-block">
                                <label class="m-0">Assigned To</label>
                            </div>

                            <div class="col-4 ml-n4 collaboration-task-block">
                                <label class="m-0">Task</label>
                            </div>

                            <div class="col-1 ml-n4 collaboration-task-block collaboration-dept-width">
                                <label class="m-0">Dept</label>
                            </div>

                            <div class="col-1 ml-2 collaboration-task-block">
                                <label class="m-0">Created By</label>
                            </div>

                            <div class="col-1 task-collaboration-closedate" style="margin-left: -23px;">
                                <label class="m-0">Close Date</label>
                            </div>

                            <div class="col-1 ml-n4 collaboration-task-block">
                                <label class="m-0">Task Status</label>
                            </div>
                        </div>
                        <div :id="'collaboration-'+key" class="my-2" v-for="(task, key) in order.collaboration.tasks">
                            <div :class="key == 0 ? '': '' " v-if="!hideInModal">
                                <input @click="selectRow({event:$event, type: 'collaboration', id: order.collaboration.tasks[key].id})" type="checkbox">
                            </div>
                            <div class="col-1 task-collaboration-date">
                                <b-form-datepicker :date-format-options="{ year: '2-digit', month: 'numeric', day: 'numeric' }" :disabled="hideInModal || hideinAuth" @input="order.collaboration.tasks[key].date = checkDate(order.collaboration.tasks[key].date)" class="my-auto input-date" close-button locale="en" name="date"
                                                   placeholder=""
                                                   reset-button
                                                   size="sm"
                                                   today-button
                                                   v-model="order.collaboration.tasks[key].date">
                                </b-form-datepicker>
                            </div>
                            <div class="col-2 ml-n4 collaboration-task-block">
                                <b-form-input :disabled="hideInModal || hideinAuth" size="sm" type="text" v-model="order.collaboration.tasks[key].assigned_to"></b-form-input>
                            </div>
                            <div class="col-4 ml-n4 collaboration-task-block">
                                <b-form-input :disabled="hideInModal || hideinAuth" size="sm" type="text" v-model="order.collaboration.tasks[key].task"></b-form-input>
                            </div>
                            <div class="col-1 ml-n4 collaboration-task-block collaboration-dept-width">
                                <b-form-select
                                    :disabled="hideInModal"
                                    :options="deptList"
                                    class="form-control form-control-sm custom-caret-form dept-select-width"
                                    name="collaboration[dept_id]"
                                    size="sm"
                                    v-model="order.collaboration.tasks[key].department_id"
                                    v-on:change="departmentLabel(order.collaboration.tasks[key].department_id)">
                                    <template #first>
                                        <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                                    </template>
                                </b-form-select>
                            </div>
                            <div class="col-1 ml-2 collaboration-task-block">
                                <b-form-input :disabled="hideInModal || hideinAuth" size="sm" type="text" v-model="order.collaboration.tasks[key].created_by"></b-form-input>
                            </div>
                            <div class="col-1 ml-n4 task-collaboration-closedate">
                                <b-form-datepicker :date-format-options="{ year: '2-digit', month: 'numeric', day: 'numeric' }" :disabled="hideInModal || hideinAuth"
                                                   @input="order.collaboration.tasks[key].close_date = closeDateChanged(order.collaboration.tasks[key].close_date, key)" class="my-auto input-date" close-button locale="en" name="date"
                                                   placeholder=""
                                                   reset-button
                                                   size="sm"
                                                   today-button
                                                   v-model="order.collaboration.tasks[key].close_date">
                                </b-form-datepicker>
                            </div>
                            <div class="col-1 ml-n4 collaboration-task-block">
                                <b-dropdown :class="order.collaboration.tasks[key].status == 'pending' ? 'bg-red' :
                                            order.collaboration.tasks[key].status == 'in_progress' ? 'bg-warning':
                                             order.collaboration.tasks[key].status == 'Complete' ? 'bg-success':  '' " :disabled="hideInModal || hideinAuth" class="border rounded" no-caret size="sm"
                                            style="width:10rem"
                                            variant="none">

                                    <template #button-content>
                                        <div class="d-flex" style="color: white;">
                                            <small>{{ order.collaboration.tasks[key].status ?
                                                customizeLabel(order.collaboration.tasks[key].status) : order.collaboration.tasks[key].status = 'pending' }}</small>
                                            <i aria-hidden="true" class="fa fa-caret-down ml-auto"></i>
                                        </div>
                                    </template>

                                    <b-dropdown-group class="px-1">
                                        <template v-for="obj of statusList">
                                            <b-dropdown-group>
                                                <b-dropdown-item-button @click="order.collaboration.tasks[key].status = obj.value" class="small">
                                                    {{ obj.text }}
                                                </b-dropdown-item-button>
                                            </b-dropdown-group>
                                        </template>
                                    </b-dropdown-group>

                                </b-dropdown>
                            </div>
                        </div>
                    </div>
                    <hr class="border">
                    <div class="custom-row d-block">
                        <div>
                            <h6 class=" custom-form-heading">Correspondence</h6>
                        </div>
                    </div>
                    <div class="custom-row bg-primary" v-if="!hideInModal">
                        <button @click="addTask('correspondence')" class="btn btn-sm list-toolbar m-1 border-0" type="button">Add Task</button>
                        <button :disabled="deleteCorrespondenceTask.length==0" @click="deleteTask('correspondence')" class="btn btn-sm list-toolbar m-1 border-0" type="button">Delete Task</button>
                    </div>
                    <div class="custom-row d-block">
                        <div v-if="order.correspondence.tasks?.length>0">

                            <div style="visibility: hidden;">
                                <input type="checkbox">
                            </div>

                            <div class="col-1 task-collaboration-date">
                                <label>Date</label>
                            </div>

                            <div class="col-1 ml-n4 collaboration-task-block" style="min-width:6.5rem;">
                                <label>Who Corsp</label>
                            </div>

                            <div class="col-1 ml-n4 collaboration-task-block collaboration-form-communication">
                                <label>Form of Communication</label>
                            </div>

                            <div class="col-2 ml-n4 collaboration-task-block" style="min-width:12rem;">

                                <label class="">Why Contacted</label>
                            </div>

                            <div class="col-3 ml-n4 collaboration-task-block" style="min-width:20rem;">
                                <label class="">Reasons From Customer</label>
                            </div>

                            <div class="col-3 ml-n4 collaboration-task-block">
                                <label class="">Notes</label>
                            </div>

                            <div class="col-1 ml-n4 collaboration-task-block">
                                <label class="">Name of Contact</label>
                            </div>
                        </div>
                        <div class="my-2 correspondence-row" v-for="(task, key) in order.correspondence.tasks">
                            <div :class="key == 0 ? '': '' " style="position: absolute;" v-if="!hideInModal">
                                <input @change="selectRow({event:$event, type: 'correspondence', id: order.correspondence.tasks[key].id})" class="correspondence-checkbox" type="checkbox">
                            </div>
                            <div class="col-1 task-collaboration-date">
                                <b-form-datepicker :date-format-options="{ year: '2-digit', month: 'numeric', day: 'numeric' }" :disabled="hideInModal || hideinAuth" @input="order.correspondence.tasks[key].date = checkDate(order.correspondence.tasks[key].date)" class="my-auto input-date correspondence-date" close-button locale="en" name="date"
                                                   placeholder=""
                                                   reset-button
                                                   size="sm"
                                                   today-button
                                                   v-model="order.correspondence.tasks[key].date">
                                </b-form-datepicker>
                            </div>
                            <div class="col-1 ml-n4 collaboration-task-block" style="min-width:6.5rem;">
                                <b-form-textarea
                                    :disabled="hideInModal || hideinAuth" :rows="autoResizeWhoCorsp(order.correspondence.tasks[key].who_corsp)" class="textarea-overflow"
                                    no-resize
                                    size="sm"
                                    type="text"
                                    v-model="order.correspondence.tasks[key].who_corsp"
                                ></b-form-textarea>
                            </div>
                            <div class="col-1 ml-n4 collaboration-task-block collaboration-form-communication">
                                <b-form-textarea
                                    :disabled="hideInModal || hideinAuth" :rows="autoResizeFormCommunication(order.correspondence.tasks[key].form_of_communication)" class="textarea-overflow"
                                    no-resize
                                    size="sm"
                                    type="text"
                                    v-model="order.correspondence.tasks[key].form_of_communication"
                                ></b-form-textarea>
                            </div>
                            <div class="col-2 ml-n4 collaboration-task-block" style="min-width:12rem;">
                                <b-form-textarea
                                    :disabled="hideInModal || hideinAuth" :rows="autoResizeWhyContacted(order.correspondence.tasks[key].why_contacted)" class="textarea-overflow"
                                    no-resize
                                    size="sm"
                                    type="text"
                                    v-model="order.correspondence.tasks[key].why_contacted"
                                ></b-form-textarea>
                            </div>
                            <div class="col-3 ml-n4 collaboration-task-block" style="min-width:20rem;">
                                <b-form-textarea
                                    :disabled="hideInModal || hideinAuth" :rows="autoResizeCustomerReason(order.correspondence.tasks[key].customer_reasons)" class="textarea-overflow"
                                    no-resize
                                    size="sm"
                                    type="text"
                                    v-model="order.correspondence.tasks[key].customer_reasons"
                                ></b-form-textarea>
                            </div>
                            <div class="col-3 ml-n4 collaboration-task-block">
                                <b-form-textarea
                                    :disabled="hideInModal || hideinAuth" :rows="autoResizeNotes(order.correspondence.tasks[key].notes)" class="textarea-overflow"
                                    no-resize
                                    size="sm"
                                    type="text"
                                    v-model="order.correspondence.tasks[key].notes"
                                ></b-form-textarea>
                            </div>
                            <div class="col-1 ml-n4 collaboration-task-block">
                                <b-form-textarea
                                    :disabled="hideInModal || hideinAuth" :rows="autoResizeContactName(order.correspondence.tasks[key].contact_name,'contact_name')" class="textarea-overflow"
                                    no-resize
                                    size="sm"
                                    style="min-width: 8rem;"
                                    type="text"
                                    v-model="order.correspondence.tasks[key].contact_name"
                                ></b-form-textarea>
                            </div>
                        </div>
                    </div>
                    <hr class="border">
                    <div class="custom-row d-block">
                        <div>
                            <h6 class="custom-form-heading">Production</h6>
                        </div>
                    </div>
                    <hr class="border">
                    <div class="custom-row">
                        <div class="custom-border-right my-n2 pr-1">
                            <div>
                                <label>TempMarker Who</label>
                                <dropDownGroup :customStock="tempMarker" :customStocks="tempMarkers" :fieldName="'temp_maker_who'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isTempMarkerWho'" :refName="'tempMarkerWhoPicker'" :searchFieldName="'searchTempMarker'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isTempMarkerWho'" :datePickerRefName="'tempMarkerWhoPicker'" :formFieldName="'temp_maker_who'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="tempMarkerWhoPicker"
                                            v-show="isTempMarkerWho"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="tempMarker == 'Select' ? 'invisible' : '' " :title="`${tempMarker}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{tempMarker}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('temp_maker_who', searchTempMarker, 'searchTempMarker')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchTempMarker"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="tempMarkers.length > 0">
                                            <template v-for="(obj, key) of tempMarkers">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.temp_maker_who = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('temp_maker_who', searchTempMarker, 'searchTempMarker')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>TempMarker In Stock</label>
                                <dropDownGroup :customStock="tempMarkerInStock" :customStocks="tempMarkerInStocks" :fieldName="'temp_maker_in_stock'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isTempMarkerStock'" :refName="'tempMarkerStockPicker'" :searchFieldName="'searchTempMarkerInStock'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isTempMarkerStock'" :datePickerRefName="'tempMarkerStockPicker'" :formFieldName="'temp_maker_in_stock'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="tempMarkerStockPicker"
                                            v-show="isTempMarkerStock"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="tempMarkerInStock == 'Select' ? 'invisible' : '' " :title="`${tempMarkerInStock}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{tempMarkerInStock}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('temp_maker_in_stock', searchTempMarkerInStock, 'searchTempMarkerInStock')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchTempMarkerInStock"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="tempMarkerInStocks.length > 0">
                                            <template v-for="(obj, key) of tempMarkerInStocks">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.temp_maker_in_stock = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('temp_maker_in_stock', searchTempMarkerInStock, 'searchTempMarkerInStock')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                        </div>
                        <div>
                            <div>
                                <label>Final Date</label>
                                <dropDownGroup :customStock="finalDate" :customStocks="finalDates" :fieldName="'final_date'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isFinalDate'" :refName="'finalDatePicker'" :searchFieldName="'searchFinalDate'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isFinalDate'" :datePickerRefName="'finalDatePicker'" :formFieldName="'final_date'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="finalDatePicker"
                                            v-show="isFinalDate"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="finalDate == 'Select' ? 'invisible' : '' " :title="`${finalDate}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{finalDate}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('final_date', searchFinalDate, 'searchFinalDate')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchFinalDate"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="finalDates.length > 0">
                                            <template v-for="(obj, key) of finalDates">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.final_date = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('final_date', searchFinalDate, 'searchFinalDate')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Porcelain Made</label>
                                <dropDownGroup :customStock="procelainMade" :customStocks="procelainMades" :fieldName="'porcelain_made'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isPorcelainMade'" :refName="'porcelainMadePicker'" :searchFieldName="'searchProcelainMade'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isPorcelainMade'" :datePickerRefName="'porcelainMadePicker'" :formFieldName="'porcelain_made'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="porcelainMadePicker"
                                            v-show="isPorcelainMade"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="procelainMade == 'Select' ? 'invisible' : '' " :title="`${procelainMade}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{procelainMade}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('porcelain_made', searchProcelainMade, 'searchProcelainMade')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchProcelainMade"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="procelainMades.length > 0">
                                            <template v-for="(obj, key) of procelainMades">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.porcelain_made = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('porcelain_made', searchProcelainMade, 'searchProcelainMade')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Monument Made</label>
                                <dropDownGroup :customStock="monumentMake" :customStocks="monumentMakes" :fieldName="'monument_make'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isMonumentMake'" :refName="'monumentMakePicker'" :searchFieldName="'searchMonumentMake'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isMonumentMake'" :datePickerRefName="'monumentMakePicker'" :formFieldName="'monument_make'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="monumentMakePicker"
                                            v-show="isMonumentMake"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="monumentMake == 'Select' ? 'invisible' : '' " :title="`${monumentMake}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{monumentMake}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('monument_make', searchMonumentMake, 'searchMonumentMake')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchMonumentMake"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="monumentMakes.length > 0">
                                            <template v-for="(obj, key) of monumentMakes">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.monument_make = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('monument_make', searchMonumentMake, 'searchMonumentMake')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Paid</label>
                                <dropDownGroup :customStock="proPaid" :customStocks="proPaids" :fieldName="'paid'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isProPaid'" :refName="'proPaidPicker'" :searchFieldName="'searchPaid'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isProPaid'" :datePickerRefName="'proPaidPicker'" :formFieldName="'paid'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="proPaidPicker"
                                            v-show="isProPaid"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="proPaid == 'Select' ? 'invisible' : '' " :title="`${proPaid}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{proPaid}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('paid', searchPaid, 'searchPaid')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchPaid"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="proPaids.length > 0">
                                            <template v-for="(obj, key) of proPaids">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.paid = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('paid', searchPaid, 'searchPaid')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                        </div>
                    </div>
                    <hr class="border">
                    <div class="custom-row">
                        <div class="custom-border-right my-n2 pr-1">
                            <div>
                                <label>Cust. Viewed</label>
                                <dropDownGroup :customStock="custViewed" :customStocks="custVieweds" :fieldName="'cust_viewed'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isCustViewed'" :refName="'custViewedPicker'" :searchFieldName="'searchCustViewed'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isCustViewed'" :datePickerRefName="'custViewedPicker'" :formFieldName="'cust_viewed'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="custViewedPicker"
                                            v-show="isCustViewed"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="custViewed == 'Select' ? 'invisible' : '' " :title="`${custViewed}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{custViewed}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('cust_viewed', searchCustViewed, 'searchCustViewed')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchCustViewed"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="custVieweds.length > 0">
                                            <template v-for="(obj, key) of custVieweds">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.cust_viewed = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('cust_viewed', searchCustViewed, 'searchCustViewed')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Blast Who</label>
                                <dropDownGroup :customStock="blastWho" :customStocks="blastWhos" :fieldName="'blast_who'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isBlastWho'" :refName="'blastWhoPicker'" :searchFieldName="'searchBlastWho'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isBlastWho'" :datePickerRefName="'blastWhoPicker'" :formFieldName="'blast_who'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="blastWhoPicker"
                                            v-show="isBlastWho"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="blastWho == 'Select' ? 'invisible' : '' " :title="`${blastWho}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{blastWho}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('blast_who', searchBlastWho, 'searchBlastWho')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchBlastWho"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="blastWhos.length > 0">
                                            <template v-for="(obj, key) of blastWhos">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.blast_who = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('blast_who', searchBlastWho, 'searchBlastWho')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Stencil</label>
                                <dropDownGroup :customStock="proStencial" :customStocks="proStencials" :fieldName="'stencial'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isStencial'" :refName="'stencialPicker'" :searchFieldName="'searchStencial'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isStencial'" :datePickerRefName="'stencialPicker'" :formFieldName="'stencial'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="stencialPicker"
                                            v-show="isStencial"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="proStencial == 'Select' ? 'invisible' : '' " :title="`${proStencial}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{proStencial}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('stencial', searchStencial, 'searchStencial')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchStencial"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="proStencials.length > 0">
                                            <template v-for="(obj, key) of proStencials">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.stencial = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('stencial', searchStencial, 'searchStencial')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Blast Complete</label>
                                <dropDownGroup :customStock="blastComplete" :customStocks="blastCompletes" :fieldName="'blast_complete'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isBlastComplete'" :refName="'blastCompletePicker'" :searchFieldName="'searchBlastComplete'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isBlastComplete'" :datePickerRefName="'blastCompletePicker'" :formFieldName="'blast_complete'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="blastCompletePicker"
                                            v-show="isBlastComplete"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="blastComplete == 'Select' ? 'invisible' : '' " :title="`${blastComplete}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{blastComplete}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('blast_complete', searchBlastComplete, 'searchBlastComplete')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchBlastComplete"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="blastCompletes.length > 0">
                                            <template v-for="(obj, key) of blastCompletes">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.blast_complete = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('blast_complete', searchBlastComplete, 'searchBlastComplete')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                        </div>
                        <div class="custom-border-right my-n2 pr-1">
                            <div>
                                <label>Etch Who</label>
                                <dropDownGroup :customStock="etchWho" :customStocks="etchWhos" :fieldName="'etch_who'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isEtchWho'" :refName="'etchWhoPicker'" :searchFieldName="'searchEtchWho'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isEtchWho'" :datePickerRefName="'etchWhoPicker'" :formFieldName="'etch_who'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="etchWhoPicker"
                                            v-show="isEtchWho"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="etchWho == 'Select' ? 'invisible' : '' " :title="`${etchWho}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{etchWho}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('etch_who', searchEtchWho, 'searchEtchWho')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchEtchWho"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="etchWhos.length > 0">
                                            <template v-for="(obj, key) of etchWhos">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.etch_who = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('etch_who', searchEtchWho, 'searchEtchWho')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Etch Complete</label>
                                <dropDownGroup :customStock="etchComplete" :customStocks="etchCompletes" :fieldName="'etch_complete'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isEtchComplete'" :refName="'etchCompletePicker'" :searchFieldName="'searchEtchComplete'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isEtchComplete'" :datePickerRefName="'etchCompletePicker'" :formFieldName="'etch_complete'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="etchCompletePicker"
                                            v-show="isEtchComplete"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="etchComplete == 'Select' ? 'invisible' : '' " :title="`${etchComplete}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{etchComplete}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('etch_complete', searchEtchComplete, 'searchEtchComplete')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchEtchComplete"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="etchCompletes.length > 0">
                                            <template v-for="(obj, key) of etchCompletes">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.etch_complete = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('etch_complete', searchEtchComplete, 'searchEtchComplete')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                        </div>
                        <div style="visibility: hidden;">
                            <div>
                                <label>Picture Mounted</label>
                                <b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="pictureMounted == 'Select' ? 'invisible' : '' " :title="`${pictureMounted}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{pictureMounted}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('picture_mounted', searchPictureMounted, 'searchPictureMounted')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchPictureMounted"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="pictureMounteds.length > 0">
                                            <template v-for="(obj, key) of pictureMounteds">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.picture_mounted = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('picture_mounted', searchPictureMounted, 'searchPictureMounted')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>
                            </div>
                            <div>
                                <label>Access Mounted</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-xs " name="access_mounted" size="sm" type="text" v-model="formFields.access_mounted"></b-form-input>
                            </div>
                        </div>
                    </div>
                    <hr class="border">
                    <div class="custom-row">
                        <div class="pr-1">
                            <div>
                                <label>Picture Mounted</label>
                                <dropDownGroup :customStock="pictureMounted" :customStocks="pictureMounteds" :fieldName="'picture_mounted'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isPictureMounted'" :refName="'pictureMountedPicker'" :searchFieldName="'searchPictureMounted'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isPictureMounted'" :datePickerRefName="'pictureMountedPicker'" :formFieldName="'picture_mounted'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="pictureMountedPicker"
                                            v-show="isPictureMounted"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="pictureMounted == 'Select' ? 'invisible' : '' " :title="`${pictureMounted}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{pictureMounted}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('picture_mounted', searchPictureMounted, 'searchPictureMounted')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchPictureMounted"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="pictureMounteds.length > 0">
                                            <template v-for="(obj, key) of pictureMounteds">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.picture_mounted = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('picture_mounted', searchPictureMounted, 'searchPictureMounted')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Access Mounted</label>
                                <dropDownGroup :customStock="accessMounted" :customStocks="accessMounteds" :fieldName="'access_mounted'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isAccessMounted'" :refName="'accessMountedPicker'" :searchFieldName="'searchAccessMounted'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isAccessMounted'" :datePickerRefName="'accessMountedPicker'" :formFieldName="'access_mounted'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setDateValue" ref="accessMountedPicker"
                                            v-show="isAccessMounted"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small :class="accessMounted == 'Select' ? 'invisible' : '' " :title="`${accessMounted}`"
                                                   class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{accessMounted}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                                        <b-form-input
                                            :disabled="hideInModal || hideinAuth"
                                            @keyup.enter="saveCustomText('access_mounted', searchAccessMounted, 'searchAccessMounted')"
                                            class="mt-1"
                                            placeholder="Custom Text"
                                            size="sm"
                                            v-model="searchAccessMounted"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="accessMounteds.length > 0">
                                            <template v-for="(obj, key) of accessMounteds">
                                                <b-dropdown-group>
                                                    <b-dropdown-item-button :key="key"
                                                                            @click="formFields.access_mounted = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveCustomText('access_mounted', searchAccessMounted, 'searchAccessMounted')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                        </div>
                    </div>
                    <hr class="border">
                    <div class="custom-row d-block">
                        <div>
                            <label>Special Install Instructions</label>
                        </div>
                        <div>
                            <b-form-textarea
                                :disabled="hideInModal || hideinAuth"
                                class=" mx-2"
                                no-resize
                                placeholder=""
                                rows="3"
                                size="sm"
                                v-model="formFields.special_install_instructions"
                            ></b-form-textarea>
                        </div>
                    </div>
                    <hr class="border">
                    <div class="custom-row d-block">
                        <div>
                            <h6 class="my-2 custom-form-heading">Installation</h6>
                        </div>
                        <div>

                            <div>
                                <label>Install Who</label>
                                <dropDownGroup :customStock="installWho" :customStocks="installWhos" :fieldName="'install_who'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isInstallWho'" :refName="'installWhoPicker'" :searchFieldName="'searchInstallWho'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchInstallFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isInstallWho'" :datePickerRefName="'installWhoPicker'" :formFieldName="'install_who'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setInstallDateValue" ref="installWhoPicker"
                                            v-show="isInstallWho"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
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
                                            @keyup.enter="saveInstallCustomText('install_who', searchInstallWho, 'searchInstallWho')"
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
                                                                            @click="order.installation.install_who = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveInstallCustomText('install_who', searchInstallWho, 'searchInstallWho')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Install Where</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-xxl" size="sm" type="text" v-model="order.cemetery.company"></b-form-input>
                            </div>
                            <div>
                                <label>Cemetery Amount</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-xs" size="sm" type="text" v-model="order.installation.cemetery_amount"></b-form-input>
                            </div>
                            <div>
                                <label>Cemetery Paid</label>
                                <dropDownGroup :customStock="cemeteryPaid" :customStocks="cemeteryPaids" :fieldName="'cemetery_paid'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isCemeteryPaid'" :refName="'cemeteryPaidPicker'" :searchFieldName="'searchCemeteryPaid'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchInstallFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isCemeteryPaid'" :datePickerRefName="'cemeteryPaidPicker'" :formFieldName="'cemetery_paid'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setInstallDateValue" ref="cemeteryPaidPicker"
                                            v-show="isCemeteryPaid"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
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
                                            @keyup.enter="saveInstallCustomText('cemetery_paid', searchCemeteryPaid, 'searchCemeteryPaid')"
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
                                                                            @click="order.installation.cemetery_paid = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveInstallCustomText('cemetery_paid', searchCemeteryPaid, 'searchCemeteryPaid')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Cemetery Called To Flag</label>
                                <dropDownGroup :customStock="callToFlag" :customStocks="callToFlags" :fieldName="'cemetery_called_to_flag'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isCemeteryCallFlag'" :refName="'cemeteryCallFlagPicker'" :searchFieldName="'searchCallToFlag'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchInstallFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isCemeteryCallFlag'" :datePickerRefName="'cemeteryCallFlagPicker'" :formFieldName="'cemetery_called_to_flag'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setInstallDateValue" ref="cemeteryCallFlagPicker"
                                            v-show="isCemeteryCallFlag"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
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
                                            @keyup.enter="saveInstallCustomText('cemetery_called_to_flag', searchCallToFlag, 'searchCallToFlag')"
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
                                                                            @click="order.installation.cemetery_called_to_flag = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveInstallCustomText('cemetery_called_to_flag', searchCallToFlag, 'searchCallToFlag')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                        </div>
                        <div class="mt-1">
                            <div>
                                <label>Grave Flagged</label>
                                <dropDownGroup :customStock="graveFlag" :customStocks="graveFlags" :fieldName="'grave_flagged'"
                                               :hideInModal="hideInModal" :pickerShowHide="'isGraveFlagged'" :refName="'graveFlagPicker'" :searchFieldName="'searchGraveFlag'"
                                               @open-datePicker="datePickerClick" @search-value-event="searchInstallFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                                <datePicker :datePickerProp="'isGraveFlagged'" :datePickerRefName="'graveFlagPicker'" :formFieldName="'grave_flagged'" @hide-datePicker="hideDatePicker"
                                            @open-datePicker="datePickerClick" @set--date-value-event="setInstallDateValue" ref="graveFlagPicker"
                                            v-show="isGraveFlagged"></datePicker>
                                <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
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
                                            @keyup.enter="saveInstallCustomText('grave_flagged', searchGraveFlag, 'searchGraveFlag')"
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
                                                                            @click="order.installation.grave_flagged = obj.value">
                                                        <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small"></b-dropdown-text>
                                            <button @click="saveInstallCustomText('grave_flagged', searchGraveFlag, 'searchGraveFlag')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                    type="button">Add
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>-->
                            </div>
                            <div>
                                <label>Cemetery Take/Mail check</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-xs" size="sm" type="text" v-model="order.installation.cemetery_take_mail_check"></b-form-input>
                            </div>
                        </div>
                    </div>
                    <hr class="border">
                    <div class="custom-row">
                        <div>
                            <label>Installation Zone</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-xxl" size="sm" type="text" v-model="order.cemetery.installation_zone"></b-form-input>
                        </div>
                        <div>
                            <label>Date Promised</label>
                            <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" :disabled="hideInModal || hideinAuth"
                                               @input="order.invoice.date_promised = checkDate(order.invoice.date_promised)" class="my-auto input-date" close-button locale="en" name="date"
                                               placeholder=""
                                               reset-button
                                               size="sm"
                                               today-button
                                               v-model="order.invoice.date_promised">
                            </b-form-datepicker>
                        </div>
                        <div>
                            <label>Foundation Done</label>
                            <dropDownGroup :customStock="foundationDone" :customStocks="foundationDones" :fieldName="'foundation_done'"
                                           :hideInModal="hideInModal" :pickerShowHide="'isFoundationDone'" :refName="'foundationDonePicker'" :searchFieldName="'searchFoundationDone'"
                                           @open-datePicker="datePickerClick" @search-value-event="searchInstallFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                            <datePicker :datePickerProp="'isFoundationDone'" :datePickerRefName="'foundationDonePicker'" :formFieldName="'foundation_done'" @hide-datePicker="hideDatePicker"
                                        @open-datePicker="datePickerClick" @set--date-value-event="setInstallDateValue" ref="foundationDonePicker"
                                        v-show="isFoundationDone"></datePicker>
                            <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
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
                                        @keyup.enter="saveInstallCustomText('foundation_done', searchFoundationDone, 'searchFoundationDone')"
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
                                                                        @click="order.installation.foundation_done = obj.value">
                                                    <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                </b-dropdown-item-button>
                                            </b-dropdown-group>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <b-dropdown-text class="text-center small"></b-dropdown-text>
                                        <button @click="saveInstallCustomText('foundation_done', searchFoundationDone, 'searchFoundationDone')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                type="button">Add
                                        </button>
                                    </template>
                                </b-dropdown-group>
                            </b-dropdown>-->
                        </div>
                        <div>
                            <label>Set Stone</label>
                            <dropDownGroup :customStock="setStone" :customStocks="setStones" :fieldName="'set_stone'"
                                           :hideInModal="hideInModal" :pickerShowHide="'isSetStone'" :refName="'setStonePicker'" :searchFieldName="'searchSetStone'"
                                           @open-datePicker="datePickerClick" @search-value-event="searchInstallFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                            <datePicker :datePickerProp="'isSetStone'" :datePickerRefName="'setStonePicker'" :formFieldName="'set_stone'" @hide-datePicker="hideDatePicker"
                                        @open-datePicker="datePickerClick" @set--date-value-event="setInstallDateValue" ref="setStonePicker"
                                        v-show="isSetStone"></datePicker>
                            <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
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
                                        @keyup.enter="saveInstallCustomText('set_stone', searchSetStone, 'searchSetStone')"
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
                                                                        @click="order.installation.set_stone = obj.value">
                                                    <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                </b-dropdown-item-button>
                                            </b-dropdown-group>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <b-dropdown-text class="text-center small"></b-dropdown-text>
                                        <button @click="saveInstallCustomText('set_stone', searchSetStone, 'searchSetStone')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                type="button">Add
                                        </button>
                                    </template>
                                </b-dropdown-group>
                            </b-dropdown>-->
                        </div>
                        <div>
                            <label>Install Date</label>
                            <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" :disabled="hideInModal || hideinAuth"
                                               @input="order.installation.install_date = checkDate(order.installation.install_date)" class="my-auto input-date" close-button locale="en" name="install_date"
                                               placeholder=""
                                               reset-button
                                               size="sm"
                                               today-button
                                               v-model="order.installation.install_date">
                            </b-form-datepicker>
                        </div>
                        <div>
                            <label>Customer Called After Install</label>
                            <dropDownGroup :customStock="customerInstall" :customStocks="customerInstalls" :fieldName="'customer_called_after_installation'"
                                           :hideInModal="hideInModal" :pickerShowHide="'isCustomerCallInstall'" :refName="'customerCallInstallPicker'" :searchFieldName="'searchCustomerInstall'"
                                           @open-datePicker="datePickerClick" @search-value-event="searchInstallFieldCustomText" @set-datePicker-true="showDatePicker"></dropDownGroup>
                            <datePicker :datePickerProp="'isCustomerCallInstall'" :datePickerRefName="'customerCallInstallPicker'" :formFieldName="'customer_called_after_installation'" @hide-datePicker="hideDatePicker"
                                        @open-datePicker="datePickerClick" @set--date-value-event="setInstallDateValue" ref="customerCallInstallPicker"
                                        v-show="isCustomerCallInstall"></datePicker>
                            <!--<b-dropdown :disabled="hideInModal || hideinAuth" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
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
                                        @keyup.enter="saveInstallCustomText('customer_called_after_installation', searchCustomerInstall, 'searchCustomerInstall')"
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
                                                                        @click="order.installation.customer_called_after_installation = obj.value">
                                                    <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                                                </b-dropdown-item-button>
                                            </b-dropdown-group>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <b-dropdown-text class="text-center small"></b-dropdown-text>
                                        <button @click="saveInstallCustomText('customer_called_after_installation', searchCustomerInstall, 'searchCustomerInstall')" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                                                type="button">Add
                                        </button>
                                    </template>
                                </b-dropdown-group>
                            </b-dropdown>-->
                        </div>
                    </div>
                    <div class="custom-row d-block">
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
                                v-model="order.installation.install_memo"
                            ></b-form-textarea>
                        </div>
                    </div>
                    <hr class="border">
                    <div class="custom-row d-block">
                        <div>
                            <h6 class="my-2 custom-form-heading">Order Info</h6>
                        </div>
                        <div>
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
                    <div class="custom-row">
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
                    <div class="custom-row d-block" v-if="!hideInModal">
                        <button :disabled="saveDisabled" @click="storeProduction" class="btn-info mx-2 mb-2 custom-infobtn-toolbar custom-infobtn-text" type="button" v-if="id ? isUpdatePermitted : isCreatePermitted">
                            {{ id ? 'Update' : 'Save' }}<span class="spinner-grow spinner-grow-sm ml-1" v-if="saveDisabled"></span>
                        </button>
                    </div>
                </template>
            </form>
        </div>

        <PDF :title="'printProductionForm'">
            <div class="" slot="header">
                <div class="d-flex justify-content-center font-weight-bold">
                    <h2>Production Form</h2>
                </div>
            </div>
            <div class="pdf" slot="body">
                <div class="custom-row-pdf">
                    <div>
                        <label>Date</label>
                        <b-form-input :value="changeDateFormat(order.date)" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>Invoice No.</label>
                        <b-form-input :value="order.invoice.invoice_number" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>Last Name on Stone</label>
                        <b-form-input :value="order.family.name_on_stone" class="input-print-xxxl" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>Type Of Order</label>
                        <b-form-input :value="orderTypeTitle" class="" readonly size="sm" type="text" v-if="orderTypeTitle != 'Select'"></b-form-input>
                        <b-form-input class="" readonly size="sm" type="text" v-else></b-form-input>
                    </div>
                </div>
                <hr class="border mb-4 mt-4 mr-n4 ml-n4">
                <div class="custom-row-pdf">
                    <div>
                        <label>Monument in Stock</label>
                        <b-form-input :value="formFields.monument_in_stock" class="custom-input-md-pdf" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>On-Order Who</label>
                        <b-form-input :value="formFields.on_order_who" class="custom-input-md-pdf" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>On-Order In Stock</label>
                        <b-form-input :value="formFields.on_order_in_stock" class="custom-input-md-pdf" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>Vendor Proof</label>
                        <b-form-input :value="formFields.order_who_vendor_proof" class="custom-input-md-pdf" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>Vase Who</label>
                        <b-form-input :value="formFields.vase_who" class="custom-input-md-pdf" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>Vase In Stock</label>
                        <b-form-input :value="formFields.vase_in_stock" class="custom-input-md-pdf" readonly size="sm" type="text"></b-form-input>
                    </div>
                </div>
                <div class="custom-row-pdf mt-4">
                    <div>
                        <label>Accessory Who</label>
                        <b-form-input :value="formFields.access_who" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>Accessory In Stock</label>
                        <b-form-input :value="formFields.access_in_stock" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>Accessory Installed</label>
                        <b-form-input class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                </div>
                <div class="custom-row-pdf mt-4">
                    <div>
                        <label>Picture In Stock</label>
                        <b-form-input :value="formFields.picture_in_stock" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>Picture Who</label>
                        <b-form-input :value="formFields.picture_who" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>Picture Installed</label>
                        <b-form-input class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>Mis Who (Temp)</label>
                        <b-form-input :value="formFields.temp_maker_who" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>Mis In Stock Temp</label>
                        <b-form-input :value="formFields.temp_maker_in_stock" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                </div>
                <div class="custom-row-pdf mt-4">
                    <div>
                        <label>Rubbing</label>
                        <b-form-input :value="formFields.rubbing_need" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>Final Date</label>
                        <b-form-input :value="formFields.final_date" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                </div>
                <div class="custom-row-pdf mt-4">
                    <div>
                        <label>Design In House</label>
                        <b-form-input :value="formFields.design_in_house" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>Design Customer</label>
                        <b-form-input :value="formFields.design_customer" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                </div>
                <div class="custom-row-pdf mt-4">
                    <div>
                        <label>Stencil</label>
                        <b-form-input :value="formFields.stencial" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                </div>
                <div class="custom-row-pdf mt-4">
                    <div>
                        <label>Blast Who</label>
                        <b-form-input :value="formFields.blast_who" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>Blast Complete</label>
                        <b-form-input :value="formFields.blast_complete" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                </div>
                <div class="custom-row-pdf mt-4">
                    <div>
                        <label>Etch Who</label>
                        <b-form-input :value="formFields.etch_who" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                    <div class="ml-4">
                        <label>Etch Complete</label>
                        <b-form-input :value="formFields.etch_complete" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                </div>
                <div class="custom-row-pdf mt-4">
                    <div>
                        <label>Monument Make</label>
                        <b-form-input :value="formFields.monument_make" class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                </div>
                <div class="custom-row-pdf mt-4">
                    <div>
                        <label>Customer Viewed</label>
                        <b-form-input class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                </div>
                <div class="custom-row-pdf mt-4">
                    <div>
                        <label>Ship/Invoice Date</label>
                        <b-form-input class="" readonly size="sm" type="text"></b-form-input>
                    </div>
                </div>
            </div>
            <div slot="footer"></div>
        </PDF>

    </div>
</template>
<script>
    import Toolbar from "./Toolbar";
    import dropDownGroup from "./dropDownGroup";
    import datePicker from "./datePicker";
    import PDF from "../../Modules/PDF-Modal";
    import Price from "../../Modules/Price";
    import {event, eventBus} from "../../event-bus/event-bus";
    import {searchForEmptyDate} from "../../helpers/common";
    import {deleteRecord, deleteTask, fetchRecord, firstRecord, lastRecord, nextRecord, previousRecord, saveRecord, updateRecord} from "../../helpers/axios";

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
                isMonumentStock: false,
                isOrderWho: false,
                isVendorProof: false,
                isOrderInStock: false,
                isPickureWho: false,
                isPickureVenProof: false,
                isPickureInStock: false,
                isVaseWho: false,
                isVaseInStock: false,
                isAccessWho: false,
                isAccessInStock: false,
                isRubbingNeed: false,
                isDesignInHouse: false,
                isDesignInCustomer: false,
                isCemetApproveNeeded: false,
                isInstallCemetery: false,
                isTempMarkerWho: false,
                isTempMarkerStock: false,
                isFinalDate: false,
                isPorcelainMade: false,
                isMonumentMake: false,
                isProPaid: false,
                isCustViewed: false,
                isBlastWho: false,
                isStencial: false,
                isBlastComplete: false,
                isEtchWho: false,
                isEtchComplete: false,
                isPictureMounted: false,
                isAccessMounted: false,
                isInstallWho: false,
                isCemeteryPaid: false,
                isCemeteryCallFlag: false,
                isGraveFlagged: false,
                isFoundationDone: false,
                isSetStone: false,
                isCustomerCallInstall: false,
                pageNumber: 1,
                // storeID : this.$store.getters.getCurrentStoreID,
                deleteCollaborationTasks: [],
                deleteCorrespondenceTask: [],
                formFields: {
                    id: 0,
                    // store_id: this.storeID
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
                statusList: [
                    {value: 'Complete', text: 'Complete'},
                    {value: 'in_progress', text: 'In Progress'},
                    {value: 'pending', text: 'Pending'}
                ],
                axiosParams: {module: 'production'},
                axiosOrderStatusParams: {module: 'orderStatus'},
                saveDisabled: false,
                hideinAuth: false,
                dropdownMStockList: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchMonumentStock: "",
                dropdownOrderWhoList: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchOrderWho: "",
                dropdownVendorProList: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchVendorProof: "",
                dropdownOrderInStock: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchOrderInStock: "",
                dropdownPictureWho: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchPictureWho: "",
                dropdownPictureVendorProof: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchPictureVendorProof: "",
                dropdownPictureInStock: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchPictureInStock: "",
                dropdownVaseWho: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchVaseWho: "",
                dropdownVaseInStock: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchVaseInStock: "",
                dropdownAccessWho: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchAccessWho: "",
                dropdownAccessInStock: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchAccessInStock: "",
                dropdownRubbingNeed: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchRubbingNeed: "",
                dropdownDesignInHouse: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchDesignInHouse: "",
                dropdownDesignInCustomer: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchDesignInCustomer: "",
                dropdownCemeteryApproved: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchCemeteryApproved: "",
                dropdownInstallCemetery: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchInstallCemetery: "",
                dropdownTempMarker: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchTempMarker: "",
                dropdownTempMarkerInStock: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchTempMarkerInStock: "",
                dropdownFinalDate: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchFinalDate: "",
                dropdownProcelainMade: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchProcelainMade: "",
                dropdownMonumentMake: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchMonumentMake: "",
                dropdownPaid: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchPaid: "",
                dropdownCustViewed: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchCustViewed: "",
                dropdownBlastWho: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchBlastWho: "",
                dropdownStencial: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchStencial: "",
                dropdownBlastComplete: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchBlastComplete: "",
                dropdownEtchWho: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchEtchWho: "",
                dropdownEtchComplete: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchEtchComplete: "",
                dropdownPictureMounted: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchPictureMounted: "",
                dropdownAccessMounted: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchAccessMounted: "",
                dropdownInstallWho: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchInstallWho: "",
                dropdownCemeteryPaid: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchCemeteryPaid: "",
                dropdownCallToFlag: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchCallToFlag: "",
                dropdownGraveFlag: [{value: 'yes', text: 'Yes'},
                    {value: 'n/a', text: 'N/A'},
                    {value: 'currentDate', text: '"Today\'s Date"'}],
                searchGraveFlag: "",
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
                title: `${this.formFields.id ? 'Edit' : 'Add'} Production`,
            }
        },
        created() {
            eventBus.$on(event.SAVE_PRODUCTION, this.storeProduction);
            eventBus.$on(event.FIRST_PRODUCTION_RECORD, this.first);
            eventBus.$on(event.LAST_PRODUCTION_RECORD, this.last);
            eventBus.$on(event.NEXT_PRODUCTION_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_PRODUCTION_RECORD, this.prev);
            eventBus.$on(event.GET_PRODUCTION, this.getDropDownProd);
            eventBus.$on(event.ADD_PRODUCTION, this.clearForm);
            eventBus.$on(event.DELETE_PRODUCTION, this.deleteRecord);
        },
        destroyed() {
            eventBus.$off(event.SAVE_PRODUCTION);
            eventBus.$off(event.FIRST_PRODUCTION_RECORD);
            eventBus.$off(event.LAST_PRODUCTION_RECORD);
            eventBus.$off(event.NEXT_PRODUCTION_RECORD);
            eventBus.$off(event.PREVIOUS_PRODUCTION_RECORD);
            eventBus.$off(event.GET_PRODUCTION);
            eventBus.$off(event.ADD_PRODUCTION);
            eventBus.$off(event.DELETE_PRODUCTION);
        },
        components: {
            Toolbar,
            Price,
            PDF,
            dropDownGroup,
            datePicker,
        },
        computed: {
            isLoading() {
                return this.$store.state[this.axiosParams.module].busy;
            },
            order() {
                if (this.formFields.order == null) {
                    this.formFields.order = {
                        invoice: {}, procelain: {}, order_installation: {}, family: {}, cemetery: {installation_zone: ""}, company: {}, installation: {}, products: [],
                        collaboration: {tasks: []}, memorial_production: {}, approval_monument: {},
                        correspondence: {tasks: []}
                    };
                }
                return this.formFields.order
            },
            isUpdatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Production', action: 'update'});
            },
            isCreatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Production', action: 'create'});
            },
            deptList: function () {
                let options = [];
                for (let opt of this.$store.state.department.recordList) {
                    if (opt.generic == 0) {
                        let obj = {value: opt.id, text: opt.title};
                        options.push(obj);
                    }
                }
                return options;
            },
            orderStatusList() {
                let list = []
                for (let opt of this.$store.state.orderStatus.recordList) {
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
            monumentStock() {
                let opt = 'Select'
                if (this.formFields.monument_in_stock != null && (this.formFields.monument_in_stock == 'yes' || this.formFields.monument_in_stock == 'n/a')) {
                    opt = this.dropdownMStockList.filter(obj => obj.value == this.formFields.monument_in_stock)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.monument_in_stock != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.monument_in_stock)
                    && this.formFields.monument_in_stock != 'currentDate') {
                    opt = this.formFields.monument_in_stock
                } else if (this.formFields.monument_in_stock != null) {
                    opt = this.dropdownMStockList.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.monument_in_stock)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownMStockList.findIndex(findIn => findIn.value == this.formFields.monument_in_stock)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.monument_in_stock
                                    objTwo.text = this.formFields.monument_in_stock
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownMStockList)
                    this.formFields.monument_in_stock = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            onOrderWho() {
                let opt = 'Select'
                if (this.formFields.on_order_who != null && (this.formFields.on_order_who == 'yes' || this.formFields.on_order_who == 'n/a')) {
                    opt = this.dropdownOrderWhoList.filter(obj => obj.value == this.formFields.on_order_who)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.on_order_who != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.on_order_who)
                    && this.formFields.on_order_who != 'currentDate') {
                    opt = this.formFields.on_order_who
                } else if (this.formFields.on_order_who != null) {
                    opt = this.dropdownOrderWhoList.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.on_order_who)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownOrderWhoList.findIndex(findIn => findIn.value == this.formFields.on_order_who)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.on_order_who
                                    objTwo.text = this.formFields.on_order_who
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownOrderWhoList)
                    this.formFields.on_order_who = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            onOrderWhos() {
                let options = this.dropdownOrderWhoList;
                if (this.searchOrderWho != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchOrderWho.toUpperCase()) > -1)
                }
                return options
            },
            monumentStocks() {
                let options = this.dropdownMStockList;
                if (this.searchMonumentStock != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchMonumentStock.toUpperCase()) > -1)
                }
                return options
            },
            vendorProof() {
                let opt = 'Select'
                if (this.formFields.order_who_vendor_proof != null && (this.formFields.order_who_vendor_proof == 'yes' || this.formFields.order_who_vendor_proof == 'n/a')) {
                    opt = this.dropdownVendorProList.filter(obj => obj.value == this.formFields.order_who_vendor_proof)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.order_who_vendor_proof != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.order_who_vendor_proof)
                    && this.formFields.order_who_vendor_proof != 'currentDate') {
                    opt = this.formFields.order_who_vendor_proof
                } else if (this.formFields.order_who_vendor_proof != null) {
                    opt = this.dropdownVendorProList.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.order_who_vendor_proof)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownVendorProList.findIndex(findIn => findIn.value == this.formFields.order_who_vendor_proof)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.order_who_vendor_proof
                                    objTwo.text = this.formFields.order_who_vendor_proof
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownVendorProList)
                    this.formFields.order_who_vendor_proof = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            vendorProofs() {
                let options = this.dropdownVendorProList;
                if (this.searchVendorProof != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchVendorProof.toUpperCase()) > -1)
                }
                return options
            },
            orderInStock() {
                let opt = 'Select'
                if (this.formFields.on_order_in_stock != null && (this.formFields.on_order_in_stock == 'yes' || this.formFields.on_order_in_stock == 'n/a')) {
                    opt = this.dropdownOrderInStock.filter(obj => obj.value == this.formFields.on_order_in_stock)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.on_order_in_stock != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.on_order_in_stock)
                    && this.formFields.on_order_in_stock != 'currentDate') {
                    opt = this.formFields.on_order_in_stock
                } else if (this.formFields.on_order_in_stock != null) {
                    opt = this.dropdownOrderInStock.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.on_order_in_stock)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownOrderInStock.findIndex(findIn => findIn.value == this.formFields.on_order_in_stock)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.on_order_in_stock
                                    objTwo.text = this.formFields.on_order_in_stock
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownOrderInStock)
                    this.formFields.on_order_in_stock = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            orderInStocks() {
                let options = this.dropdownOrderInStock;
                if (this.searchOrderInStock != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchOrderInStock.toUpperCase()) > -1)
                }
                return options
            },
            pictureWho() {
                let opt = 'Select'
                if (this.formFields.picture_who != null && (this.formFields.picture_who == 'yes' || this.formFields.picture_who == 'n/a')) {
                    opt = this.dropdownPictureWho.filter(obj => obj.value == this.formFields.picture_who)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.picture_who != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.picture_who)
                    && this.formFields.picture_who != 'currentDate') {
                    opt = this.formFields.picture_who
                } else if (this.formFields.picture_who != null) {
                    opt = this.dropdownPictureWho.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.picture_who)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownPictureWho.findIndex(findIn => findIn.value == this.formFields.picture_who)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.picture_who
                                    objTwo.text = this.formFields.picture_who
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownPictureWho)
                    this.formFields.picture_who = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            pictureWhos() {
                let options = this.dropdownPictureWho;
                if (this.searchPictureWho != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchPictureWho.toUpperCase()) > -1)
                }
                return options
            },
            pictureVendorProof() {
                let opt = 'Select'
                if (this.formFields.picture_who_vendor_proof != null && (this.formFields.picture_who_vendor_proof == 'yes' || this.formFields.picture_who_vendor_proof == 'n/a')) {
                    opt = this.dropdownPictureVendorProof.filter(obj => obj.value == this.formFields.picture_who_vendor_proof)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.picture_who_vendor_proof != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.picture_who_vendor_proof)
                    && this.formFields.picture_who_vendor_proof != 'currentDate') {
                    opt = this.formFields.picture_who_vendor_proof
                } else if (this.formFields.picture_who_vendor_proof != null) {
                    opt = this.dropdownPictureVendorProof.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.picture_who_vendor_proof)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownPictureVendorProof.findIndex(findIn => findIn.value == this.formFields.picture_who_vendor_proof)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.picture_who_vendor_proof
                                    objTwo.text = this.formFields.picture_who_vendor_proof
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownPictureVendorProof)
                    this.formFields.picture_who_vendor_proof = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            pictureVendorProofs() {
                let options = this.dropdownPictureVendorProof;
                if (this.searchPictureVendorProof != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchPictureVendorProof.toUpperCase()) > -1)
                }
                return options
            },
            pictureInStock() {
                let opt = 'Select'
                if (this.formFields.picture_in_stock != null && (this.formFields.picture_in_stock == 'yes' || this.formFields.picture_in_stock == 'n/a')) {
                    opt = this.dropdownPictureInStock.filter(obj => obj.value == this.formFields.picture_in_stock)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.picture_in_stock != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.picture_in_stock)
                    && this.formFields.picture_in_stock != 'currentDate') {
                    opt = this.formFields.picture_in_stock
                } else if (this.formFields.picture_in_stock != null) {
                    opt = this.dropdownPictureInStock.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.picture_in_stock)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownPictureInStock.findIndex(findIn => findIn.value == this.formFields.picture_in_stock)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.picture_in_stock
                                    objTwo.text = this.formFields.picture_in_stock
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownPictureInStock)
                    this.formFields.picture_in_stock = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            pictureInStocks() {
                let options = this.dropdownPictureInStock;
                if (this.searchPictureInStock != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchPictureInStock.toUpperCase()) > -1)
                }
                return options
            },
            vaseWho() {
                let opt = 'Select'
                if (this.formFields.vase_who != null && (this.formFields.vase_who == 'yes' || this.formFields.vase_who == 'n/a')) {
                    opt = this.dropdownVaseWho.filter(obj => obj.value == this.formFields.vase_who)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.vase_who != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.vase_who)
                    && this.formFields.vase_who != 'currentDate') {
                    opt = this.formFields.vase_who
                } else if (this.formFields.vase_who != null) {
                    opt = this.dropdownVaseWho.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.vase_who)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownVaseWho.findIndex(findIn => findIn.value == this.formFields.vase_who)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.vase_who
                                    objTwo.text = this.formFields.vase_who
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownVaseWho)
                    this.formFields.vase_who = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            vaseWhos() {
                let options = this.dropdownVaseWho;
                if (this.searchVaseWho != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchVaseWho.toUpperCase()) > -1)
                }
                return options
            },
            vaseInStock() {
                let opt = 'Select'
                if (this.formFields.vase_in_stock != null && (this.formFields.vase_in_stock == 'yes' || this.formFields.vase_in_stock == 'n/a')) {
                    opt = this.dropdownVaseInStock.filter(obj => obj.value == this.formFields.vase_in_stock)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.vase_in_stock != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.vase_in_stock)
                    && this.formFields.vase_in_stock != 'currentDate') {
                    opt = this.formFields.vase_in_stock
                } else if (this.formFields.vase_in_stock != null) {
                    opt = this.dropdownVaseInStock.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.vase_in_stock)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownVaseInStock.findIndex(findIn => findIn.value == this.formFields.vase_in_stock)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.vase_in_stock
                                    objTwo.text = this.formFields.vase_in_stock
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownVaseInStock)
                    this.formFields.vase_in_stock = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            vaseInStocks() {
                let options = this.dropdownVaseInStock;
                if (this.searchVaseInStock != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchVaseInStock.toUpperCase()) > -1)
                }
                return options
            },
            accessWho() {
                let opt = 'Select'
                if (this.formFields.access_who != null && (this.formFields.access_who == 'yes' || this.formFields.access_who == 'n/a')) {
                    opt = this.dropdownAccessWho.filter(obj => obj.value == this.formFields.access_who)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.access_who != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.access_who)
                    && this.formFields.access_who != 'currentDate') {
                    opt = this.formFields.access_who
                } else if (this.formFields.access_who != null) {
                    opt = this.dropdownAccessWho.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.access_who)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownAccessWho.findIndex(findIn => findIn.value == this.formFields.access_who)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.access_who
                                    objTwo.text = this.formFields.access_who
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownAccessWho)
                    this.formFields.access_who = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            accessWhos() {
                let options = this.dropdownAccessWho;
                if (this.searchAccessWho != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchAccessWho.toUpperCase()) > -1)
                }
                return options
            },
            accessInStock() {
                let opt = 'Select'
                if (this.formFields.access_in_stock != null && (this.formFields.access_in_stock == 'yes' || this.formFields.access_in_stock == 'n/a')) {
                    opt = this.dropdownAccessInStock.filter(obj => obj.value == this.formFields.access_in_stock)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.access_in_stock != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.access_in_stock)
                    && this.formFields.access_in_stock != 'currentDate') {
                    opt = this.formFields.access_in_stock
                } else if (this.formFields.access_in_stock != null) {
                    opt = this.dropdownAccessInStock.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.access_in_stock)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownAccessInStock.findIndex(findIn => findIn.value == this.formFields.access_in_stock)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.access_in_stock
                                    objTwo.text = this.formFields.access_in_stock
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownAccessInStock)
                    this.formFields.access_in_stock = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            accessInStocks() {
                let options = this.dropdownAccessInStock;
                if (this.searchAccessInStock != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchAccessInStock.toUpperCase()) > -1)
                }
                return options
            },
            rubbingNeed() {
                let opt = 'Select'
                if (this.formFields.rubbing_need != null && (this.formFields.rubbing_need == 'yes' || this.formFields.rubbing_need == 'n/a')) {
                    opt = this.dropdownRubbingNeed.filter(obj => obj.value == this.formFields.rubbing_need)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.rubbing_need != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.rubbing_need)
                    && this.formFields.rubbing_need != 'currentDate') {
                    opt = this.formFields.rubbing_need
                } else if (this.formFields.rubbing_need != null) {
                    opt = this.dropdownRubbingNeed.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.rubbing_need)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownRubbingNeed.findIndex(findIn => findIn.value == this.formFields.rubbing_need)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.rubbing_need
                                    objTwo.text = this.formFields.rubbing_need
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownRubbingNeed)
                    this.formFields.rubbing_need = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            rubbingNeeds() {
                let options = this.dropdownRubbingNeed;
                if (this.searchRubbingNeed != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchRubbingNeed.toUpperCase()) > -1)
                }
                return options
            },
            designInHouse() {
                let opt = 'Select'
                if (this.formFields.design_in_house != null && (this.formFields.design_in_house == 'yes' || this.formFields.design_in_house == 'n/a')) {
                    opt = this.dropdownDesignInHouse.filter(obj => obj.value == this.formFields.design_in_house)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.design_in_house != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.design_in_house)
                    && this.formFields.design_in_house != 'currentDate') {
                    opt = this.formFields.design_in_house
                } else if (this.formFields.design_in_house != null) {
                    opt = this.dropdownDesignInHouse.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.design_in_house)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownDesignInHouse.findIndex(findIn => findIn.value == this.formFields.design_in_house)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.design_in_house
                                    objTwo.text = this.formFields.design_in_house
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownDesignInHouse)
                    this.formFields.design_in_house = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            designInHouses() {
                let options = this.dropdownDesignInHouse;
                if (this.searchDesignInHouse != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchDesignInHouse.toUpperCase()) > -1)
                }
                return options
            },
            designInCustomer() {
                let opt = 'Select'
                if (this.formFields.design_customer != null && (this.formFields.design_customer == 'yes' || this.formFields.design_customer == 'n/a')) {
                    opt = this.dropdownDesignInCustomer.filter(obj => obj.value == this.formFields.design_customer)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.design_customer != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.design_customer)
                    && this.formFields.design_customer != 'currentDate') {
                    opt = this.formFields.design_customer
                } else if (this.formFields.design_customer != null) {
                    opt = this.dropdownDesignInCustomer.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.design_customer)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownDesignInCustomer.findIndex(findIn => findIn.value == this.formFields.design_customer)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.design_customer
                                    objTwo.text = this.formFields.design_customer
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownDesignInCustomer)
                    this.formFields.design_customer = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            designInCustomers() {
                let options = this.dropdownDesignInCustomer;
                if (this.searchDesignInCustomer != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchDesignInCustomer.toUpperCase()) > -1)
                }
                return options
            },
            cemeteryApproved() {
                let opt = 'Select'
                if (this.formFields.cemetery_approval_needed != null && (this.formFields.cemetery_approval_needed == 'yes' || this.formFields.cemetery_approval_needed == 'n/a')) {
                    opt = this.dropdownCemeteryApproved.filter(obj => obj.value == this.formFields.cemetery_approval_needed)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.cemetery_approval_needed != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.cemetery_approval_needed)
                    && this.formFields.cemetery_approval_needed != 'currentDate') {
                    opt = this.formFields.cemetery_approval_needed
                } else if (this.formFields.cemetery_approval_needed != null) {
                    opt = this.dropdownCemeteryApproved.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.cemetery_approval_needed)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownCemeteryApproved.findIndex(findIn => findIn.value == this.formFields.cemetery_approval_needed)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.cemetery_approval_needed
                                    objTwo.text = this.formFields.cemetery_approval_needed
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownCemeteryApproved)
                    this.formFields.cemetery_approval_needed = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            cemeteryApprovedes() {
                let options = this.dropdownCemeteryApproved;
                if (this.searchCemeteryApproved != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchCemeteryApproved.toUpperCase()) > -1)
                }
                return options
            },
            installCemetery() {
                let opt = 'Select'
                if (this.formFields.install_from_cemetery != null && (this.formFields.install_from_cemetery == 'yes' || this.formFields.install_from_cemetery == 'n/a')) {
                    opt = this.dropdownInstallCemetery.filter(obj => obj.value == this.formFields.install_from_cemetery)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.install_from_cemetery != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.install_from_cemetery)
                    && this.formFields.install_from_cemetery != 'currentDate') {
                    opt = this.formFields.install_from_cemetery
                } else if (this.formFields.install_from_cemetery != null) {
                    opt = this.dropdownInstallCemetery.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.install_from_cemetery)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownInstallCemetery.findIndex(findIn => findIn.value == this.formFields.install_from_cemetery)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.install_from_cemetery
                                    objTwo.text = this.formFields.install_from_cemetery
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownInstallCemetery)
                    this.formFields.install_from_cemetery = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            installCemeteries() {
                let options = this.dropdownInstallCemetery;
                if (this.searchInstallCemetery != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchInstallCemetery.toUpperCase()) > -1)
                }
                return options
            },
            tempMarker() {
                let opt = 'Select'
                if (this.formFields.temp_maker_who != null && (this.formFields.temp_maker_who == 'yes' || this.formFields.temp_maker_who == 'n/a')) {
                    opt = this.dropdownTempMarker.filter(obj => obj.value == this.formFields.temp_maker_who)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.temp_maker_who != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.temp_maker_who)
                    && this.formFields.temp_maker_who != 'currentDate') {
                    opt = this.formFields.temp_maker_who
                } else if (this.formFields.temp_maker_who != null) {
                    opt = this.dropdownTempMarker.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.temp_maker_who)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownTempMarker.findIndex(findIn => findIn.value == this.formFields.temp_maker_who)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.temp_maker_who
                                    objTwo.text = this.formFields.temp_maker_who
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownTempMarker)
                    this.formFields.temp_maker_who = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            tempMarkers() {
                let options = this.dropdownTempMarker;
                if (this.searchTempMarker != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchTempMarker.toUpperCase()) > -1)
                }
                return options
            },
            tempMarkerInStock() {
                let opt = 'Select'
                if (this.formFields.temp_maker_in_stock != null && (this.formFields.temp_maker_in_stock == 'yes' || this.formFields.temp_maker_in_stock == 'n/a')) {
                    opt = this.dropdownTempMarkerInStock.filter(obj => obj.value == this.formFields.temp_maker_in_stock)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.temp_maker_in_stock != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.temp_maker_in_stock)
                    && this.formFields.temp_maker_in_stock != 'currentDate') {
                    opt = this.formFields.temp_maker_in_stock
                } else if (this.formFields.temp_maker_in_stock != null) {
                    opt = this.dropdownTempMarkerInStock.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.temp_maker_in_stock)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownTempMarkerInStock.findIndex(findIn => findIn.value == this.formFields.temp_maker_in_stock)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.temp_maker_in_stock
                                    objTwo.text = this.formFields.temp_maker_in_stock
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownTempMarkerInStock)
                    this.formFields.temp_maker_in_stock = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            tempMarkerInStocks() {
                let options = this.dropdownTempMarkerInStock;
                if (this.searchTempMarkerInStock != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchTempMarkerInStock.toUpperCase()) > -1)
                }
                return options
            },
            finalDate() {
                let opt = 'Select'
                if (this.formFields.final_date != null && (this.formFields.final_date == 'yes' || this.formFields.final_date == 'n/a')) {
                    opt = this.dropdownFinalDate.filter(obj => obj.value == this.formFields.final_date)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.final_date != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.final_date)
                    && this.formFields.final_date != 'currentDate') {
                    opt = this.formFields.final_date
                } else if (this.formFields.final_date != null) {
                    opt = this.dropdownFinalDate.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.final_date)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownFinalDate.findIndex(findIn => findIn.value == this.formFields.final_date)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.final_date
                                    objTwo.text = this.formFields.final_date
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownFinalDate)
                    this.formFields.final_date = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            finalDates() {
                let options = this.dropdownFinalDate;
                if (this.searchFinalDate != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchFinalDate.toUpperCase()) > -1)
                }
                return options
            },
            procelainMade() {
                let opt = 'Select'
                if (this.formFields.porcelain_made != null && (this.formFields.porcelain_made == 'yes' || this.formFields.porcelain_made == 'n/a')) {
                    opt = this.dropdownProcelainMade.filter(obj => obj.value == this.formFields.porcelain_made)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.porcelain_made != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.porcelain_made)
                    && this.formFields.porcelain_made != 'currentDate') {
                    opt = this.formFields.porcelain_made
                } else if (this.formFields.porcelain_made != null) {
                    opt = this.dropdownProcelainMade.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.porcelain_made)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownProcelainMade.findIndex(findIn => findIn.value == this.formFields.porcelain_made)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.porcelain_made
                                    objTwo.text = this.formFields.porcelain_made
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownProcelainMade)
                    this.formFields.porcelain_made = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            procelainMades() {
                let options = this.dropdownProcelainMade;
                if (this.searchProcelainMade != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchProcelainMade.toUpperCase()) > -1)
                }
                return options
            },
            monumentMake() {
                let opt = 'Select'
                if (this.formFields.monument_make != null && (this.formFields.monument_make == 'yes' || this.formFields.monument_make == 'n/a')) {
                    opt = this.dropdownMonumentMake.filter(obj => obj.value == this.formFields.monument_make)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.monument_make != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.monument_make)
                    && this.formFields.monument_make != 'currentDate') {
                    opt = this.formFields.monument_make
                } else if (this.formFields.monument_make != null) {
                    opt = this.dropdownMonumentMake.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.monument_make)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownMonumentMake.findIndex(findIn => findIn.value == this.formFields.monument_make)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.monument_make
                                    objTwo.text = this.formFields.monument_make
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownMonumentMake)
                    this.formFields.monument_make = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            monumentMakes() {
                let options = this.dropdownMonumentMake;
                if (this.searchMonumentMake != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchMonumentMake.toUpperCase()) > -1)
                }
                return options
            },
            proPaid() {
                let opt = 'Select'
                if (this.formFields.paid != null && (this.formFields.paid == 'yes' || this.formFields.paid == 'n/a')) {
                    opt = this.dropdownPaid.filter(obj => obj.value == this.formFields.paid)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.paid != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.paid)
                    && this.formFields.paid != 'currentDate') {
                    opt = this.formFields.paid
                } else if (this.formFields.paid != null) {
                    opt = this.dropdownPaid.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.paid)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownPaid.findIndex(findIn => findIn.value == this.formFields.paid)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.paid
                                    objTwo.text = this.formFields.paid
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownPaid)
                    this.formFields.paid = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            proPaids() {
                let options = this.dropdownPaid;
                if (this.searchPaid != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchPaid.toUpperCase()) > -1)
                }
                return options
            },
            custViewed() {
                let opt = 'Select'
                if (this.formFields.cust_viewed != null && (this.formFields.cust_viewed == 'yes' || this.formFields.cust_viewed == 'n/a')) {
                    opt = this.dropdownCustViewed.filter(obj => obj.value == this.formFields.cust_viewed)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.cust_viewed != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.cust_viewed)
                    && this.formFields.cust_viewed != 'currentDate') {
                    opt = this.formFields.cust_viewed
                } else if (this.formFields.cust_viewed != null) {
                    opt = this.dropdownCustViewed.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.cust_viewed)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownCustViewed.findIndex(findIn => findIn.value == this.formFields.cust_viewed)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.cust_viewed
                                    objTwo.text = this.formFields.cust_viewed
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownCustViewed)
                    this.formFields.cust_viewed = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            custVieweds() {
                let options = this.dropdownCustViewed;
                if (this.searchCustViewed != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchCustViewed.toUpperCase()) > -1)
                }
                return options
            },
            blastWho() {
                let opt = 'Select'
                if (this.formFields.blast_who != null && (this.formFields.blast_who == 'yes' || this.formFields.blast_who == 'n/a')) {
                    opt = this.dropdownBlastWho.filter(obj => obj.value == this.formFields.blast_who)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.blast_who != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.blast_who)
                    && this.formFields.blast_who != 'currentDate') {
                    opt = this.formFields.blast_who
                } else if (this.formFields.blast_who != null) {
                    opt = this.dropdownBlastWho.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.blast_who)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownBlastWho.findIndex(findIn => findIn.value == this.formFields.blast_who)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.blast_who
                                    objTwo.text = this.formFields.blast_who
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownBlastWho)
                    this.formFields.blast_who = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            blastWhos() {
                let options = this.dropdownBlastWho;
                if (this.searchBlastWho != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchBlastWho.toUpperCase()) > -1)
                }
                return options
            },
            proStencial() {
                let opt = 'Select'
                if (this.formFields.stencial != null && (this.formFields.stencial == 'yes' || this.formFields.stencial == 'n/a')) {
                    opt = this.dropdownStencial.filter(obj => obj.value == this.formFields.stencial)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.stencial != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.stencial)
                    && this.formFields.stencial != 'currentDate') {
                    opt = this.formFields.stencial
                } else if (this.formFields.stencial != null) {
                    opt = this.dropdownStencial.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.stencial)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownStencial.findIndex(findIn => findIn.value == this.formFields.stencial)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.stencial
                                    objTwo.text = this.formFields.stencial
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownStencial)
                    this.formFields.stencial = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            proStencials() {
                let options = this.dropdownStencial;
                if (this.searchStencial != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchStencial.toUpperCase()) > -1)
                }
                return options
            },
            blastComplete() {
                let opt = 'Select'
                if (this.formFields.blast_complete != null && (this.formFields.blast_complete == 'yes' || this.formFields.blast_complete == 'n/a')) {
                    opt = this.dropdownBlastComplete.filter(obj => obj.value == this.formFields.blast_complete)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.blast_complete != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.blast_complete)
                    && this.formFields.blast_complete != 'currentDate') {
                    opt = this.formFields.blast_complete
                } else if (this.formFields.blast_complete != null) {
                    opt = this.dropdownBlastComplete.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.blast_complete)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownBlastComplete.findIndex(findIn => findIn.value == this.formFields.blast_complete)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.blast_complete
                                    objTwo.text = this.formFields.blast_complete
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownBlastComplete)
                    this.formFields.blast_complete = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            blastCompletes() {
                let options = this.dropdownBlastComplete;
                if (this.searchBlastComplete != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchBlastComplete.toUpperCase()) > -1)
                }
                return options
            },
            etchWho() {
                let opt = 'Select'
                if (this.formFields.etch_who != null && (this.formFields.etch_who == 'yes' || this.formFields.etch_who == 'n/a')) {
                    opt = this.dropdownEtchWho.filter(obj => obj.value == this.formFields.etch_who)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.etch_who != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.etch_who)
                    && this.formFields.etch_who != 'currentDate') {
                    opt = this.formFields.etch_who
                } else if (this.formFields.etch_who != null) {
                    opt = this.dropdownEtchWho.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.etch_who)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownEtchWho.findIndex(findIn => findIn.value == this.formFields.etch_who)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.etch_who
                                    objTwo.text = this.formFields.etch_who
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownEtchWho)
                    this.formFields.etch_who = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            etchWhos() {
                let options = this.dropdownEtchWho;
                if (this.searchEtchWho != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchEtchWho.toUpperCase()) > -1)
                }
                return options
            },
            etchComplete() {
                let opt = 'Select'
                if (this.formFields.etch_complete != null && (this.formFields.etch_complete == 'yes' || this.formFields.etch_complete == 'n/a')) {
                    opt = this.dropdownEtchComplete.filter(obj => obj.value == this.formFields.etch_complete)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.etch_complete != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.etch_complete)
                    && this.formFields.etch_complete != 'currentDate') {
                    opt = this.formFields.etch_complete
                } else if (this.formFields.etch_complete != null) {
                    opt = this.dropdownEtchComplete.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.etch_complete)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownEtchComplete.findIndex(findIn => findIn.value == this.formFields.etch_complete)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.etch_complete
                                    objTwo.text = this.formFields.etch_complete
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownEtchComplete)
                    this.formFields.etch_complete = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            etchCompletes() {
                let options = this.dropdownEtchComplete;
                if (this.searchEtchComplete != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchEtchComplete.toUpperCase()) > -1)
                }
                return options
            },
            pictureMounted() {
                let opt = 'Select'
                if (this.formFields.picture_mounted != null && (this.formFields.picture_mounted == 'yes' || this.formFields.picture_mounted == 'n/a')) {
                    opt = this.dropdownPictureMounted.filter(obj => obj.value == this.formFields.picture_mounted)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.picture_mounted != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.picture_mounted)
                    && this.formFields.picture_mounted != 'currentDate') {
                    opt = this.formFields.picture_mounted
                } else if (this.formFields.picture_mounted != null) {
                    opt = this.dropdownPictureMounted.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.picture_mounted)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownPictureMounted.findIndex(findIn => findIn.value == this.formFields.picture_mounted)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.picture_mounted
                                    objTwo.text = this.formFields.picture_mounted
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownPictureMounted)
                    this.formFields.picture_mounted = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            pictureMounteds() {
                let options = this.dropdownPictureMounted;
                if (this.searchPictureMounted != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchPictureMounted.toUpperCase()) > -1)
                }
                return options
            },
            accessMounted() {
                let opt = 'Select'
                if (this.formFields.access_mounted != null && (this.formFields.access_mounted == 'yes' || this.formFields.access_mounted == 'n/a')) {
                    opt = this.dropdownAccessMounted.filter(obj => obj.value == this.formFields.access_mounted)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.access_mounted != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.access_mounted)
                    && this.formFields.access_mounted != 'currentDate') {
                    opt = this.formFields.access_mounted
                } else if (this.formFields.access_mounted != null) {
                    opt = this.dropdownAccessMounted.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.access_mounted)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownAccessMounted.findIndex(findIn => findIn.value == this.formFields.access_mounted)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.access_mounted
                                    objTwo.text = this.formFields.access_mounted
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownAccessMounted)
                    this.formFields.access_mounted = opt.length > 0 ? opt[0].value : ''
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                }
                return opt
            },
            accessMounteds() {
                let options = this.dropdownAccessMounted;
                if (this.searchAccessMounted != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchAccessMounted.toUpperCase()) > -1)
                }
                return options
            },
            installWho() {
                let opt = 'Select'
                if (this.formFields.order.installation.install_who != null && (this.formFields.order.installation.install_who == 'yes' || this.formFields.order.installation.install_who == 'n/a')) {
                    opt = this.dropdownInstallWho.filter(obj => obj.value == this.formFields.order.installation.install_who)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.order.installation.install_who != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.order.installation.install_who)
                    && this.formFields.order.installation.install_who != 'currentDate') {
                    opt = this.formFields.order.installation.install_who
                } else if (this.formFields.order.installation.install_who != null) {
                    opt = this.dropdownInstallWho.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.order.installation.install_who)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownInstallWho.findIndex(findIn => findIn.value == this.formFields.order.installation.install_who)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.order.installation.install_who
                                    objTwo.text = this.formFields.order.installation.install_who
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownInstallWho)
                    this.formFields.order.installation.install_who = opt.length > 0 ? opt[0].value : ''
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
                if (this.formFields.order.installation.cemetery_paid != null && (this.formFields.order.installation.cemetery_paid == 'yes' || this.formFields.order.installation.cemetery_paid == 'n/a')) {
                    opt = this.dropdownCemeteryPaid.filter(obj => obj.value == this.formFields.order.installation.cemetery_paid)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.order.installation.cemetery_paid != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.order.installation.cemetery_paid)
                    && this.formFields.order.installation.cemetery_paid != 'currentDate') {
                    opt = this.formFields.order.installation.cemetery_paid
                } else if (this.formFields.order.installation.cemetery_paid != null) {
                    opt = this.dropdownCemeteryPaid.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.order.installation.cemetery_paid)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownCemeteryPaid.findIndex(findIn => findIn.value == this.formFields.order.installation.cemetery_paid)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.order.installation.cemetery_paid
                                    objTwo.text = this.formFields.order.installation.cemetery_paid
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownCemeteryPaid)
                    this.formFields.order.installation.cemetery_paid = opt.length > 0 ? opt[0].value : ''
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
                if (this.formFields.order.installation.cemetery_called_to_flag != null && (this.formFields.order.installation.cemetery_called_to_flag == 'yes' || this.formFields.order.installation.cemetery_called_to_flag == 'n/a')) {
                    opt = this.dropdownCallToFlag.filter(obj => obj.value == this.formFields.order.installation.cemetery_called_to_flag)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.order.installation.cemetery_called_to_flag != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.order.installation.cemetery_called_to_flag)
                    && this.formFields.order.installation.cemetery_called_to_flag != 'currentDate') {
                    opt = this.formFields.order.installation.cemetery_called_to_flag
                } else if (this.formFields.order.installation.cemetery_called_to_flag != null) {
                    opt = this.dropdownCallToFlag.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.order.installation.cemetery_called_to_flag)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownCallToFlag.findIndex(findIn => findIn.value == this.formFields.order.installation.cemetery_called_to_flag)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.order.installation.cemetery_called_to_flag
                                    objTwo.text = this.formFields.order.installation.cemetery_called_to_flag
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownCallToFlag)
                    this.formFields.order.installation.cemetery_called_to_flag = opt.length > 0 ? opt[0].value : ''
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
                if (this.formFields.order.installation.grave_flagged != null && (this.formFields.order.installation.grave_flagged == 'yes' || this.formFields.order.installation.grave_flagged == 'n/a')) {
                    opt = this.dropdownGraveFlag.filter(obj => obj.value == this.formFields.order.installation.grave_flagged)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.order.installation.grave_flagged != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.order.installation.grave_flagged)
                    && this.formFields.order.installation.grave_flagged != 'currentDate') {
                    opt = this.formFields.order.installation.grave_flagged
                } else if (this.formFields.order.installation.grave_flagged != null) {
                    opt = this.dropdownGraveFlag.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.order.installation.grave_flagged)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownGraveFlag.findIndex(findIn => findIn.value == this.formFields.order.installation.grave_flagged)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.order.installation.grave_flagged
                                    objTwo.text = this.formFields.order.installation.grave_flagged
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownGraveFlag)
                    this.formFields.order.installation.grave_flagged = opt.length > 0 ? opt[0].value : ''
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
                if (this.formFields.order.installation.foundation_done != null && (this.formFields.order.installation.foundation_done == 'yes' || this.formFields.order.installation.foundation_done == 'n/a')) {
                    opt = this.dropdownFoundationDone.filter(obj => obj.value == this.formFields.order.installation.foundation_done)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.order.installation.foundation_done != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.order.installation.foundation_done)
                    && this.formFields.order.installation.foundation_done != 'currentDate') {
                    opt = this.formFields.order.installation.foundation_done
                } else if (this.formFields.order.installation.foundation_done != null) {
                    opt = this.dropdownFoundationDone.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.order.installation.foundation_done)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownFoundationDone.findIndex(findIn => findIn.value == this.formFields.order.installation.foundation_done)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.order.installation.foundation_done
                                    objTwo.text = this.formFields.order.installation.foundation_done
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownFoundationDone)
                    this.formFields.order.installation.foundation_done = opt.length > 0 ? opt[0].value : ''
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
                if (this.formFields.order.installation.set_stone != null && (this.formFields.order.installation.set_stone == 'yes' || this.formFields.order.installation.set_stone == 'n/a')) {
                    opt = this.dropdownSetStone.filter(obj => obj.value == this.formFields.order.installation.set_stone)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.order.installation.set_stone != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.order.installation.set_stone)
                    && this.formFields.order.installation.set_stone != 'currentDate') {
                    opt = this.formFields.order.installation.set_stone
                } else if (this.formFields.order.installation.set_stone != null) {
                    opt = this.dropdownSetStone.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.order.installation.set_stone)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownSetStone.findIndex(findIn => findIn.value == this.formFields.order.installation.set_stone)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.order.installation.set_stone
                                    objTwo.text = this.formFields.order.installation.set_stone
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownSetStone)
                    this.formFields.order.installation.set_stone = opt.length > 0 ? opt[0].value : ''
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
                if (this.formFields.order.installation.customer_called_after_installation != null && (this.formFields.order.installation.customer_called_after_installation == 'yes' || this.formFields.order.installation.customer_called_after_installation == 'n/a')) {
                    opt = this.dropdownCustomerInstall.filter(obj => obj.value == this.formFields.order.installation.customer_called_after_installation)
                    opt = opt.length > 0 ? opt[0].text : 'Select'
                } else if (this.formFields.order.installation.customer_called_after_installation != null
                    && !this.$store.getters.checkIsDateValid(this.formFields.order.installation.customer_called_after_installation)
                    && this.formFields.order.installation.customer_called_after_installation != 'currentDate') {
                    opt = this.formFields.order.installation.customer_called_after_installation
                } else if (this.formFields.order.installation.customer_called_after_installation != null) {
                    opt = this.dropdownCustomerInstall.filter(objTwo => {
                        if (objTwo.value == 'currentDate') {
                            if (!this.$store.getters.checkIsDateValid(this.formFields.order.installation.customer_called_after_installation)) {
                                let date = this.$store.getters.getCurrentDate;
                                objTwo.value = date
                                objTwo.text = date
                                return objTwo
                            } else {
                                let currentIndex = this.dropdownCustomerInstall.findIndex(findIn => findIn.value == this.formFields.order.installation.customer_called_after_installation)
                                if (currentIndex === -1) {
                                    objTwo.value = this.formFields.order.installation.customer_called_after_installation
                                    objTwo.text = this.formFields.order.installation.customer_called_after_installation
                                }
                            }
                            return objTwo
                        }
                    })
                    this.$store.getters.removeDuplicatedDate(this.dropdownCustomerInstall)
                    this.formFields.order.installation.customer_called_after_installation = opt.length > 0 ? opt[0].value : ''
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
            if (!this.$store.getters.isPermitted({resource: 'Production', action: 'read'}))
                this.$router.push('/access-denied');
        },
        mounted() {
            this.$store.state[this.axiosParams.module].busy = true
            // this.formFields.store_id = this.storeID
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            if (!this.$store.getters.isPermitted({resource: 'Production', action: 'create'}) && !this.$store.getters.isPermitted({resource: 'Production', action: 'update'}))
                this.$props.hideInModal = true;
            if (this.formFields.id > 0 && !this.$store.getters.isPermitted({resource: 'Production', action: 'update'}))
                this.hideinAuth = true;
            this.getProduction(this.formFields.id);
            this.getColumns();
            this.getRecords();
            this.$store.getters.detectFormChanges();
        },
        methods: {
            /** CRUD */
            getDropDownProd: async function (id) {
                this.axiosParams.id = id;
                await fetchRecord(this.axiosParams, (response) => {
                    if (response.data.order.products.length > 0)
                        this.$store.getters.changedCompositePrice(response.data.order.products);
                    this.sortOneCollection(response.data);
                    this.formFields = response.data;
                    this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                    this.showCompositeProductDetails();
                    this.$store.state[this.axiosParams.module].busy = false
                })
            },
            getProduction: function (id) {

                if (id) {
                    this.axiosParams.id = id;
                    fetchRecord(this.axiosParams, (response) => {
                        if (response.data.order.products.length > 0)
                            this.$store.getters.changedCompositePrice(response.data.order.products);
                        this.sortOneCollection(response.data);
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.showCompositeProductDetails();
                        if (this.$store.state[this.axiosParams.module].recordList.length > 0)
                            this.$store.state[this.axiosParams.module].busy = false
                    })
                }
                if (this.$store.state.collaboration.departmentInfo.length == 0) {
                    this.$store.dispatch('getDepartmentInfo');
                    this.$store.state.department.busy = false;
                }
                this.$store.dispatch('getPaperLocationInfo');
                this.$store.dispatch('getModuleInfo', this.axiosOrderStatusParams);
            },
            changeDateFormat: function (value) {
                return this.$store.getters.changeDateFormat(value);
            },

            departmentLabel: function (id) {
                let option = 'Select';
                for (let opt of this.$store.state.department.recordList) {
                    if (opt.id == id) {
                        option = opt.title;
                    }

                }
                return option;
            },
            autoResizeWhoCorsp(data) {
                if (data) {
                    return Number((data.length / 10));
                }
                return 1;
            },
            autoResizeFormCommunication(data) {
                if (data) {
                    return Number((data.length / 14));
                }
                return 1;
            },
            autoResizeWhyContacted(data) {
                if (data) {
                    return Number((data.length / 19));
                }
                return 1;
            },
            autoResizeCustomerReason(data) {
                if (data) {
                    return Number((data.length / 33));
                }
                return 1;
            },
            autoResizeNotes(data) {
                if (data) {
                    return Number((data.length / 31));
                }
                return 1;
            },
            autoResizeContactName(data) {
                if (data) {
                    return Number((data.length / 11));
                }
                return 1;
            },
            storeProduction: function () {
                this.saveDisabled = true;
                let data = this.formFields;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: message, variant: 'danger'});
                    } else {
                        let message = `Record Successfully ${this.formFields.id ? 'Updated' : 'Added'}`;
                        this.makeToast({title: 'Success', message: message, variant: 'success'});
                        this.sortOneCollection(response.data);
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        if (this.formFields.order.products.length > 0)
                            this.$store.getters.changedCompositePrice(this.formFields.order.products);
                        this.showCompositeProductDetails();
                        this.axiosParams.data =
                            {
                                id: this.formFields.id,
                                order: {
                                    id: this.formFields.order_id, collaboration: {id: this.formFields.order.collaboration.id, order_id: this.formFields.order_id},
                                    invoice: {invoice_number: this.formFields.order.invoice.invoice_number, order_id: this.formFields.order_id},
                                    installation: {id: this.formFields.order.installation.id, order_id: this.formFields.order_id}
                                },
                                order_id: this.formFields.order_id
                            };
                        this.$store.commit('appendOrUpdateDropDown', this.axiosParams)
                        this.$store.commit('appendOrUpdateInRecordList', {module: 'order', data: response.data.order});
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
                            this.first();
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

            /**
             * Related modules
             * */
            addTask(type) {
                if (type == 'collaboration') {
                    let date = new Date();
                    const [month, day, year] = [date.getMonth() + 1, date.getDate(), date.getFullYear()];
                    date = `${year}-${month}-${day}`

                    this.order.collaboration.tasks.push({
                        id: 0, date: date, close_date: null, assigned_to: '', task: '', created_by: '',
                        status: '', dept: ''
                    });
                }
                if (type == 'correspondence')
                    this.order.correspondence.tasks.push({
                        id: 0, date: null, close_date: null, assigned_to: '', task: '', created_by: '',
                        status: '', dept: ''
                    });
            },
            deleteTask(type) {
                let taskList = type == 'collaboration' ? this.deleteCollaborationTasks : this.deleteCorrespondenceTask;
                for (let task of taskList) {
                    if (task.id) {
                        deleteTask({id: task.id, module: type}, (response) => {
                            task.element.checked = false;
                            this.order[type].tasks = this.order[type].tasks.filter(obj => obj.id != task.id)
                        })
                    } else {
                        task.taskContainer.remove()
                    }
                }
                taskList = [];
                type == 'collaboration' ? this.deleteCollaborationTasks = [] : this.deleteCorrespondenceTask = [];
            },
            selectRow(params) {

                let taskList = params.type == 'collaboration' ? this.deleteCollaborationTasks : this.deleteCorrespondenceTask;
                let taskContainer = params.event.target.parentElement.parentElement;
                if (params.event.currentTarget.checked) {
                    taskContainer.style.background = '#fff';
                    taskList.push({id: params.id, element: params.event.currentTarget, taskContainer: taskContainer})
                } else {
                    let currenIndex = taskList.findIndex(obj => obj.id == params.id);
                    if (taskList[currenIndex]) {
                        taskList.splice(currenIndex, 1);
                    }
                    taskContainer.style.background = '#fff';
                }
            },

            /** Pagination*/
            first: function () {
                firstRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.sortOneCollection(response.data);
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.$store.getters.changedCompositePrice(this.formFields.order.products);
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                })
            },
            last: function () {
                lastRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.sortOneCollection(response.data);
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.$store.getters.changedCompositePrice(this.formFields.order.products);
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                })
            },
            next: function (id) {
                this.axiosParams.id = id;
                nextRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.sortOneCollection(response.data);
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.$store.getters.changedCompositePrice(this.formFields.order.products);
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                })
            },
            prev: function (id) {
                this.axiosParams.id = id;
                previousRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.sortOneCollection(response.data);
                        this.formFields = response.data;
                        this.$store.getters.changedCompositePrice(this.formFields.order.products);
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.showCompositeProductDetails();
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                })
            },

            /** Generic*/
            makeToast(params) {
                this.$bvToast.toast(params.message, {
                    title: params.title,
                    variant: params.variant,
                    toaster: 'b-toaster-top-center',
                    autoHideDelay: 2000,
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
                        id: 0,
                        // store_id: this.storeID
                    };
                    this.$store.state[this.axiosParams.module].currentRecord = []
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
            checkOrderStatus: function (id) {
                console.log(this.orderStatusLabel(id));
                let arg = {moveTo: this.orderStatusLabel(id)};
                if (arg.moveTo == 'Waiting On Customer') {
                    this.addTask('collaboration', arg);
                }
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
            paperLocationLabel: function (id) {
                let option = 'Select';
                for (let opt of this.$store.state.paperLocation.recordList) {
                    if (opt.id == id)
                        option = opt.location_title;
                }
                return option;
            },
            checkDate: function (date) {
                return searchForEmptyDate(date);
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
            changeNumberFormat: function (value) {
                return this.$store.getters.changeNumberFormat(value);
            },

            async sortItemByDate(sortData) {
                await sortData.sort((valueA, ValueB) => new Date(valueA.date) - new Date(ValueB.date))
            },
            sortOneCollection: function (data) {
                if (data.order && data.order.collaboration.tasks.length > 0) {
                    this.sortItemByDate(data.order.collaboration.tasks)
                }
                if (data.order && data.order.correspondence.tasks?.length > 0) {
                    this.sortItemByDate(data.order.correspondence.tasks)
                }
            },
            closeDateChanged: function (closeDate, key) {
                if (closeDate != '')
                    this.order.collaboration.tasks[key].status = 'Complete';
                return this.checkDate(closeDate)
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
            saveInstallCustomText: function (columnName, searchValue, searchState) {
                if (searchValue && this.formFields.order.installation.id) {
                    let data = {}
                    data.id = this.formFields.order.installation.id
                    data.columnName = columnName
                    data.valueToSave = searchValue
                    let formData = new FormData()
                    formData.append('data', JSON.stringify(data));
                    updateRecord({module: this.axiosParams.module, apiURL: 'saveInstallCustomText'}, formData, (response) => {
                        if (response.data) {
                            this.formFields.order.installation[columnName] = searchValue
                            this[searchState] = ''
                        }
                    })
                }
            },
            searchInstallFieldCustomText: function (searchValue, valueToSave = null, selectedValue = null, fieldStateName = null, searchStateName = null) {
                if (selectedValue) {
                    this.formFields.order.installation[fieldStateName] = selectedValue
                }
                this[searchStateName] = searchValue
                if (valueToSave) {
                    this.saveInstallCustomText(fieldStateName, searchValue, searchStateName);
                }
            },
            searchFieldCustomText: function (searchValue, valueToSave = null, selectedValue = null, fieldStateName = null, searchStateName = null) {
                if (selectedValue) {
                    this.formFields[fieldStateName] = selectedValue
                }
                this[searchStateName] = searchValue
                if (valueToSave) {
                    this.saveCustomText(fieldStateName, searchValue, searchStateName);
                }
            },
            setDateValue: function (value, fieldState) {
                this.formFields[fieldState] = this.changeDateFormat(value)
            },
            setInstallDateValue: function (value, fieldState) {
                this.formFields.order.installation[fieldState] = this.changeDateFormat(value)
            },
            datePickerClick: function (refName) {
                this.$refs[refName].$el.querySelector('.btn').click();
            },
            showDatePicker: function (fieldState) {
                this[fieldState] = true
            },
            hideDatePicker: function (fieldState) {
                this[fieldState] = false
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

    .custom-row {
        display: flex;
        margin: 0.5rem 0;
        padding-left: 1rem;
    }

    .custom-row-pdf {
        display: flex;
        margin: 0.5rem 0;
    }

    .custom-input-md-pdf {
        width: 12.5rem;
    }

    .custom-row div {
        display: flex;
    }

    .custom-row div label, .custom-row-pdf div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
    }

    .custom-row div input, .custom-row-pdf div input {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.75rem;
    }

    textarea {
        border: 1px solid #c4c4c4 !important;
    }

    .custom-form-btn {
        font-size: 0.5rem;
    }

    .label-price {
        width: 5.5rem;
    }

    .label-modal-price {
        width: 4.5rem;
    }

    .input-xxl {
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

    .custom-row .task-collaboration-date {
        padding-left: 5px;
    }

    .custom-row .task-collaboration-closedate, .custom-row .task-collaboration-date {
        min-width: 8.5rem;
        display: block;
    }

    .custom-row .collaboration-task-block {
        display: block;
    }

    .custom-row .collaboration-dept-width {
        min-width: 10rem;
    }

    .collaboration-form-communication {
        min-width: 11rem;
    }

    .order-form-btn {
        font-size: 0.5rem;
    }

    .input-xxxxl {
        width: 20rem;
    }

    .input-print-xxxl {
        width: 25rem;
    }

    .textarea-overflow {
        overflow: hidden;
        font-size: 0.75rem;
    }

    .correspondence-checkbox {
        position: relative;
        top: 17px;
        left: -12px;
    }

    .correspondence-row {
        left: 15px;
        position: relative;
    }

    .correspondence-date {
        min-height: 44px;
        padding: 9px;
    }

    .dept-select-width {
        width: 10rem;
        font-size: 0.75rem;
    }

    select {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.75rem;
    }

    .text-custom-width {
        width: 5rem;
    }
</style>


