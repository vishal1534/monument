<template>

    <div>
        <h5 class="mx-2 my-1 non-print-elm custom-view-heading">Granit Bronz Memorial Order Form</h5>
        <div class="d-flex non-print-elm justify-content-center bg-toolbar my-2 p-1">
            <button type="button" v-if="formFields.granit_bronz_memorial.id > 0 ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1 px-4 w-auto custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                {{ formFields.granit_bronz_memorial.id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
            </button>
            <router-link class="btn btn-sm btn-warning mx-1 px-4 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/orders/'+formFields.id">Back</router-link>

        </div>

        <div class="row ">
            <div class="col-md-12">

                <form class="div-shadow bg-white rounded mx-2 mb-2 p-3">

                    <div class="form-content">
                        <div class="granit-memorial-row border rounded">

                            <div class="d-block border-right px-1 m-0">
                                <label class="font-weight-bold">Date:</label>
                                <label class="d-block">{{ changeDateFormat(formFields.date) }}</label>
                            </div>
                            <div class="d-block border-right px-1 m-0">
                                <label class="font-weight-bold">Last Name on Stone:</label>
                                <label class="d-block">{{ formFields.family.name_on_stone }}</label>
                            </div>
                            <!--<div class="d-block border-right px-1 m-0">
                                <label class="font-weight-bold">Day:</label>
                                <label class="d-block">{{getDayOfWeek(formFields.date)}}</label>
                            </div>
                            <div class="d-block border-right px-1 m-0">
                                <label class="font-weight-bold">Customer Name:</label>
                                <label class="d-block">{{formFields.company.name}}</label>
                            </div>-->
                            <div class="d-block px-1 m-0">
                                <label class="font-weight-bold">Invoice No.</label>
                                <label class="d-block">{{ formFields.invoice.invoice_number }}</label>
                            </div>
                        </div>

                        <div class="granit-memorial-row">
                            <div>
                                <label class="font-weight-bold mx-0 my-auto">Customer Account #:</label>
                                <b-form-input type="text" class="mx-4 w-50" size="sm" v-model="formFields.granit_bronz_memorial.customer_account_no"></b-form-input>
                            </div>
                        </div>

                        <hr class="border">

                        <div class="granit-memorial-row m-0">
                            <label class="font-weight-bold mt-2">Order Type</label>
                        </div>
                        <div class="granit-memorial-row m-0">
                            <b-form-group class="w-100 m-0 custom-radio-and-checkbox">
                                <b-form-checkbox-group v-model="formFields.granit_bronz_memorial.order_types" plain>
                                    <b-form-checkbox class="w-75" value="immediate-production">Enter for Immediate Production</b-form-checkbox>
                                    <b-form-checkbox class="w-50" value="warehousing">Warehousing</b-form-checkbox>
                                    <b-form-checkbox value="pre-need-protection">Register for Pre-need Protection</b-form-checkbox>
                                </b-form-checkbox-group>
                            </b-form-group>
                        </div>

                        <hr class="border">

                        <div class="granit-memorial-row">
                            <div>
                                <label class="font-weight-bold mx-0 my-auto">Preneed Contract No.:</label>
                                <b-form-input type="text" class="mx-4 w-50" size="sm" v-model="formFields.granit_bronz_memorial.preneed_contract_no"></b-form-input>
                            </div>
                        </div>
                        <div class="granit-memorial-row">
                            <div>
                                <label class="font-weight-bold my-auto">Date of Initial Payment:</label>
                                <label class="print-elm my-0 mx-2">{{ changeDateFormat(formFields.granit_bronz_memorial.initial_payment_date) }}</label>
                                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="non-print-elm input-date mx-2" size="sm" placeholder=""
                                                   v-model="formFields.granit_bronz_memorial.initial_payment_date"
                                                   @input="formFields.granit_bronz_memorial.initial_payment_date = checkDate(formFields.granit_bronz_memorial.initial_payment_date)"
                                                   today-button
                                                   reset-button
                                                   close-button
                                                   locale="en">
                                </b-form-datepicker>
                            </div>
                            <div>
                                <label class="font-weight-bold my-auto ml-4">Length of Contract:</label>
                                <b-form-input type="number" class="ml-2 non-print-elm" size="sm" v-model="formFields.granit_bronz_memorial.length_of_contract"></b-form-input>
                                <label class="print-elm mx-2 my-0">{{ formFields.granit_bronz_memorial.length_of_contract }}</label>
                                <label class="my-auto mx-2">(months)</label>
                            </div>
                        </div>

                        <hr class="border">

                        <div class="granit-memorial-row">

                            <div class="col-6 d-block pl-0 custom-border-right">
                                <div class="granit-memorial-row justify-content-center">
                                    <label class="font-weight-bold">Bronze Information</label>
                                </div>
                                <div class="granit-memorial-row">
                                    <div>
                                        <label class="font-weight-bold col-4 px-0">Bronze Design:</label>
                                        <b-form-input type="text" size="sm" class="my-0" v-model="formFields.granit_bronz_memorial.bronze_design"></b-form-input>
                                    </div>
                                </div>
                                <div class="granit-memorial-row">
                                    <div>
                                        <label class="font-weight-bold col-4 px-0">Bronze Size:</label>
                                        <b-form-input type="text" size="sm" class="my-0" v-model="formFields.granit_bronz_memorial.bronze_size"></b-form-input>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 d-block pl-0">
                                <div class="granit-memorial-row justify-content-center">
                                    <label class="font-weight-bold">Granite Information</label>
                                </div>
                                <div class="granit-memorial-row">
                                    <div>
                                        <label class="font-weight-bold col-4">Granite Color:</label>
                                        <b-form-input type="text" size="sm" class="my-0" v-model="formFields.granit_bronz_memorial.granite_color"></b-form-input>
                                    </div>
                                </div>
                                <div class="granit-memorial-row">
                                    <div>
                                        <label class="font-weight-bold col-4">Granite Size:</label>
                                        <b-form-input type="text" size="sm" class="my-0" v-model="formFields.granit_bronz_memorial.granite_size"></b-form-input>
                                    </div>
                                </div>
                                <div class="granit-memorial-row">
                                    <div>
                                        <label class="font-weight-bold col-4">Granite Finish:</label>
                                        <b-form-input type="text" size="sm" class="my-0" v-model="formFields.granit_bronz_memorial.granite_finish"></b-form-input>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <hr class="border">

                        <div class="d-flex">
                            <div class="col-6 d-block pl-0 custom-border-right">

                                <div class="granit-memorial-row">
                                    <label class="font-weight-bold">Vases</label>
                                </div>

                                <div>
                                    <b-form-group class="m-0 custom-radio-and-checkbox">
                                        <b-form-checkbox-group
                                            v-model="formFields.granit_bronz_memorial.vases"
                                            stacked
                                            plain>
                                            <b-form-group >
                                                <b-form-checkbox value="patrician_vase">Patrician Vase</b-form-checkbox>
                                                <b-form-checkbox value="garden_vase">Garden Vase</b-form-checkbox>
                                                <b-form-checkbox value="patrician_vase_guard">Patrician Vase w/ Guard</b-form-checkbox>
                                                <b-form-checkbox value="garden_vase_guard">Garden Vase w/ Guard</b-form-checkbox>
                                                <b-form-checkbox value="signature_vase">**Signature Vase</b-form-checkbox>
                                                <b-form-checkbox value="regency_vase">**Regency Vase</b-form-checkbox>
                                                <b-form-checkbox value="vase_ring">
                                                    <div class="d-flex">
                                                        Vase Ring #
                                                        <b-input class="h-auto py-0 w-50 mx-2" type="text" size="sm" v-model="formFields.granit_bronz_memorial.vase_ring_no"></b-input>
                                                    </div>
                                                </b-form-checkbox>
                                                <b-form-checkbox value="no_vase">No Vase</b-form-checkbox>

                                                <b-form-checkbox value="other">
                                                    <div class="d-flex">
                                                        Other
                                                        <b-input class="h-auto py-0 w-50 mx-2" type="text" size="sm" v-model="formFields.granit_bronz_memorial.vase_other"></b-input>
                                                    </div>
                                                </b-form-checkbox>
                                            </b-form-group>


                                        </b-form-checkbox-group>
                                    </b-form-group>
                                    <label>Note: Vases with ** cost extra</label>

                                </div>

                            </div>

                            <div class="col-6 d-block">
                                <div class="granit-memorial-row">
                                    <label class="font-weight-bold">Bronze Oxidation Colors</label>
                                </div>

                                <div>
                                    <b-form-group class="custom-radio-and-checkbox m-0">
                                        <b-form-checkbox-group
                                            class="d-flex"
                                            v-model="formFields.granit_bronz_memorial.oxidation_colors"
                                            stacked
                                            plain>
                                            <b-form-group class="my-0">
                                                <b-form-checkbox value="dark_brown">Dark Brown</b-form-checkbox>
                                                <b-form-checkbox value="golden_brown">Golden Brown</b-form-checkbox>
                                                <b-form-checkbox value="light_brown">Light Brown</b-form-checkbox>
                                                <b-form-checkbox value="veteran">Veteran</b-form-checkbox>
                                                <b-form-checkbox value="antique">Antique**</b-form-checkbox>
                                                <b-form-checkbox value="arbor_green">Arbor Green**</b-form-checkbox>
                                            </b-form-group>

                                            <b-form-group class="mx-5 my-0">
                                                <b-form-checkbox value="rose_red">Rose Red</b-form-checkbox>
                                                <b-form-checkbox value="emerald_green">Emerald Green</b-form-checkbox>
                                                <b-form-checkbox class="mb-4" value="black">Black</b-form-checkbox>
                                                <b-form-checkbox value="biscay">Biscay**</b-form-checkbox>
                                                <b-form-checkbox value="terra_rouge">Terra Rouge**</b-form-checkbox>
                                            </b-form-group>

                                        </b-form-checkbox-group>
                                    </b-form-group>

                                </div>

                                <div class="granit-memorial-row">
                                    <label>Note: ** will incur an additional charge</label>
                                </div>
                            </div>
                        </div>

                        <hr class="border">

                        <div class="d-flex">
                            <div class="col-6 d-block pl-0 custom-border-right">

                                <div class="granit-memorial-row">
                                    <label class="font-weight-bold">Letter Style</label>
                                </div>

                                <div>
                                    <b-form-group class="m-0 custom-radio-and-checkbox">
                                        <b-form-checkbox-group
                                            v-model="formFields.granit_bronz_memorial.letter_styles"
                                            :options="letterStyleList"
                                            stacked
                                            plain>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>

                            </div>

                            <div class="col-6 d-block">
                                <div class="granit-memorial-row">
                                    <label class="font-weight-bold">Scroll Type</label>
                                </div>

                                <div>
                                    <b-form-group class="custom-radio-and-checkbox">
                                        <b-form-checkbox-group
                                            v-model="formFields.granit_bronz_memorial.scroll_types"
                                            :options="scrollTypeList"
                                            stacked
                                            plain>
                                            <b-form-checkbox value="4">
                                                <div class="d-flex">
                                                    <label class="my-auto">Other</label>
                                                    <b-input class="h-auto py-0 input-md mx-2" type="text" size="sm" v-model="formFields.granit_bronz_memorial.scroll_type_other"></b-input>
                                                </div>
                                            </b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>

                                <div class="d-flex">
                                    <label class="my-auto">Scroll No.</label>
                                    <b-input class="h-auto py-0 input-lg mx-2" type="text" size="sm" v-model="formFields.granit_bronz_memorial.scroll_no"></b-input>
                                </div>

                                <div class="d-flex my-2">
                                    <label class="my-auto">Original Order No.</label>
                                    <b-input class="h-auto py-0 input-lg mx-2" type="text" size="sm" v-model="formFields.granit_bronz_memorial.original_order_no"></b-input>
                                </div>
                            </div>
                        </div>

                        <hr class="border">

                        <div class="d-block">

                            <div>
                                <label class="font-weight-bold mt-2 d-block">Custom Color Options</label>
                                <label>Select Option “1” or “2” - ** custom colors will incus an additional charge **</label>
                            </div>
                            <div class="custom-radio-and-checkbox">
                                <b-form-checkbox-group
                                    v-model="formFields.granit_bronz_memorial.custom_colors"
                                    stacked
                                    plain>
                                    <b-form-checkbox value="custom-color">
                                        <div class="d-flex">
                                            <span class="text-nowrap my-auto">1. Custom Color</span>
                                            <label class="ml-3 my-auto">Brand:</label>
                                            <b-input class="h-100 mx-2 " type="text" size="sm" v-model="formFields.granit_bronz_memorial.custom_color_brand"></b-input>

                                            <label class="my-auto">Color:</label>
                                            <b-input class="h-100 mx-2 " type="text" size="sm" v-model="formFields.granit_bronz_memorial.custom_color_color"></b-input>

                                            <label class="my-auto">Color #:</label>
                                            <b-input class="h-100 mx-2 " type="text" size="sm" v-model="formFields.granit_bronz_memorial.custom_color_color_no"></b-input>
                                        </div>
                                    </b-form-checkbox>

                                    <b-form-checkbox value="custom-color-swatch">2. Custom Color - Swatch w/Order</b-form-checkbox>

                                </b-form-checkbox-group>

                            </div>
                            <div>
                                <label>*No cloth, printed or photocopied color paper can be used for swatch*</label>
                            </div>

                        </div>

                        <hr class="border">

                        <div class="granit-memorial-row">
                            <b-form-group class="w-100 m-0 custom-radio-and-checkbox">
                                <b-form-checkbox-group v-model="formFields.granit_bronz_memorial.layouts" plain>
                                    <b-form-checkbox class="w-75" value="best-appearance">Layout for Best Appearance</b-form-checkbox>
                                    <b-form-checkbox class="w-50" value="no-change">No Layout Change</b-form-checkbox>
                                    <b-form-checkbox value="approval-on-drawing-required">Approval on Drawing Required</b-form-checkbox>
                                </b-form-checkbox-group>
                            </b-form-group>
                        </div>

                        <hr class="border">

                        <div class="granit-memorial-row" style="page-break-before: always">
                            <div class="col-7 pl-0 flex-column">
                                <label class="font-weight-bold">Inscription:</label>
                                <label>Type or print all information. Sketch on back (if more space is needed)</label>
                                <b-form-textarea
                                    class="h-100"
                                    size="sm"
                                    v-model="formFields.granit_bronz_memorial.inscription"
                                    no-resize
                                ></b-form-textarea>
                            </div>
                            <div class="col-1 border-right"></div>
                            <div class="flex-column pl-2">
                                <label class="font-weight-bold">Emblems:</label>
                                <label>Include placement</label>
                                <div>
                                    <label class="my-auto">1.</label>
                                    <b-input class="ml-2" type="text" size="sm" v-model="formFields.granit_bronz_memorial.emblem_one"></b-input>
                                </div>
                                <div>
                                    <label class="my-auto">2.</label>
                                    <b-input class="ml-2" type="text" size="sm" v-model="formFields.granit_bronz_memorial.emblem_two"></b-input>
                                </div>
                                <div>
                                    <label class="my-auto">3.</label>
                                    <b-input class="ml-2" type="text" size="sm" v-model="formFields.granit_bronz_memorial.emblem_three"></b-input>
                                </div>
                                <div>
                                    <label class="my-auto">4.</label>
                                    <b-input class="ml-2" type="text" size="sm" v-model="formFields.granit_bronz_memorial.emblem_four"></b-input>
                                </div>
                                <div>
                                    <label class="my-auto">5.</label>
                                    <b-input class="ml-2" type="text" size="sm" v-model="formFields.granit_bronz_memorial.emblem_five"></b-input>
                                </div>
                            </div>
                        </div>

                        <hr class="border">

                        <div class="granit-memorial-row">
                            <label class="font-weight-bold non-print-elm">Shipping Address: </label>
                            <label class="font-weight-bold print-elm mt-1">Shipping Address: </label>
                            <b-form-textarea
                                class="ml-2"
                                size="sm"
                                v-model="formFields.granit_bronz_memorial.shipping_address"
                                no-resize
                            ></b-form-textarea>
                        </div>
                        <div class="granit-memorial-row">
                            <label class="my-auto">For prompt handling use your Granite Bronze Account No.</label>
                            <b-input class="ml-2 w-25" type="text" size="sm" v-model="formFields.granit_bronz_memorial.granit_bronze_account_no"></b-input>
                        </div>
                        <div class="granit-memorial-row">
                            <label class="font-weight-bold non-print-elm">Invoicing Address: </label>
                            <label class="font-weight-bold print-elm mt-1">Invoicing Address: </label>
                            <b-form-textarea
                                class="ml-2"
                                size="sm"
                                v-model="formFields.granit_bronz_memorial.invoicing_address"
                                no-resize
                            ></b-form-textarea>
                        </div>

                        <hr class="border">

                        <div class="granit-memorial-row">
                            <div class="col-8 pl-0 flex-column border-right">
                                <label class="font-weight-bold">Granit Bronz Section:</label>
                                <div class="print-elm">{{formFields.granit_bronz_memorial.granit_bronz_section}}</div>
                                <b-form-textarea
                                    class="h-100 non-print-elm"
                                    size="sm"
                                    v-model="formFields.granit_bronz_memorial.granit_bronz_section"
                                    no-resize
                                ></b-form-textarea>
                            </div>

                            <div class="flex-column pl-2">
                                <div>
                                    <label class="my-auto">1.</label>
                                    <b-input class="ml-2" type="text" size="sm" v-model="formFields.granit_bronz_memorial.granit_bronz_section_one"></b-input>
                                </div>
                                <div>
                                    <label class="my-auto">2.</label>
                                    <b-input class="ml-2" type="text" size="sm" v-model="formFields.granit_bronz_memorial.granit_bronz_section_two"></b-input>
                                </div>
                                <div>
                                    <label class="my-auto">3.</label>
                                    <b-input class="ml-2" type="text" size="sm" v-model="formFields.granit_bronz_memorial.granit_bronz_section_three"></b-input>
                                </div>
                            </div>
                        </div>

                        <hr class="border">

                        <div class="granit-memorial-row">
                            <label class="font-weight-bold mr-2">Cemetery:</label>
                            <label>Compute price here</label>
                        </div>
                        <div class="d-flex">
                            <div class="col-4 p-0">
                                <div class="d-flex my-1">
                                    <label class="col-6 p-0 my-auto">Price:</label>
                                    <label class="my-auto">$</label><b-input class="ml-2 h-100" type="text" size="sm" v-model="formFields.granit_bronz_memorial.price"></b-input>
                                </div>
                                <div class="d-flex my-1">
                                    <label class="col-6 p-0 my-auto">Scrolls:</label>
                                    <label class="my-auto">$</label><b-input class="ml-2 h-100" type="text" size="sm" v-model="formFields.granit_bronz_memorial.scrolls"></b-input>
                                </div>
                                <div class="d-flex my-1">
                                    <label class="col-6 p-0 my-auto">Extra Lettering:</label>
                                    <label class="my-auto">$</label><b-input class="ml-2 h-100" type="text" size="sm" v-model="formFields.granit_bronz_memorial.extra_lettering"></b-input>
                                </div>
                                <div class="d-flex my-1">
                                    <label class="col-6 p-0 my-auto">Graphic Color:</label>
                                    <label class="my-auto">$</label><b-input class="ml-2 h-100" type="text" size="sm" v-model="formFields.granit_bronz_memorial.graphic_color"></b-input>
                                </div>
                                <div class="d-flex my-1">
                                    <label class="col-6 p-0 my-auto">Miscellaneous:</label>
                                    <label class="my-auto">$</label><b-input class="ml-2 h-100" type="text" size="sm" v-model="formFields.granit_bronz_memorial.miscellaneous"></b-input>
                                </div>
                                <div class="d-flex my-1">
                                    <label class="col-6 p-0 my-auto font-weight-bold">Tax:</label>
                                    <label class="my-auto">$</label><b-input class="ml-2 h-100" type="text" size="sm" v-model="formFields.granit_bronz_memorial.tax"></b-input>
                                </div>
                                <div class="d-flex my-1">
                                    <label class="col-6 p-0 my-auto font-weight-bold">TOTAL:</label>
                                    <label class="my-auto">$</label><b-input class="ml-2 h-100" type="text" size="sm" v-model="formFields.granit_bronz_memorial.total"></b-input>
                                </div>
                            </div>

                            <div class="col-1"></div>

                            <div class="col-4 p-0">
                                <div class="d-flex my-1">
                                    <label class="col-6 p-0 my-auto">PAID w/Order:</label>
                                    <label class="my-auto">$</label><b-input class="ml-2 h-100" type="text" size="sm" v-model="formFields.granit_bronz_memorial.paid_with_order"></b-input>
                                </div>
                                <div class="d-flex my-1">
                                    <label class="col-6 p-0 my-auto font-weight-bold">BALANCE DUE:</label>
                                    <label class="my-auto">$</label><b-input class="ml-2 h-100" type="text" size="sm" v-model="formFields.granit_bronz_memorial.balance_due"></b-input>
                                </div>
                            </div>
                        </div>
                        <div class="granit-memorial-row mt-2">
                            <label class="font-weight-bold my-auto">Ordered By:</label>
                            <b-input class="ml-2 h-100 w-25" type="text" size="sm" v-model="formFields.granit_bronz_memorial.ordered_by"></b-input>
                        </div>
                        <div class="granit-memorial-row">
                            <label class="font-weight-bold mr-2">Email:</label>
                            <label>gbmem@coldspringgranite.com</label>
                        </div>
                        <div class="granit-memorial-row">
                            <label class="font-weight-bold mr-4">Fax:</label>
                            <label>800-873-8122</label>

                            <label class="font-weight-bold mx-4">Phone:</label>
                            <label>800-328-2312</label>
                        </div>
                        <div class="granit-memorial-row">
                            <label>Fill in appropriately and mail to:</label>
                            <div class="flex-column m-0">
                                <label class="font-weight-bold mx-2 my-0">GRANIT BRONZ, INC. 17482 Granite West Road, Cold Spring,</label>
                                <label class="font-weight-bold mx-2">MN 56320-4578</label>
                            </div>

                        </div>

                        <div class="granit-memorial-row non-print-elm">
                            <div>
                                <button type="button" class="btn btn-sm btn-info custom-print-button  px-2" @click="printPDF">Print Preview</button>
                            </div>
                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

</template>

<script>
import {saveRecord} from "../../../../helpers/axios";
import {event, eventBus} from "../../../../event-bus/event-bus";
import {searchForEmptyDate} from "../../../../helpers/common";

export default {
    name: "Content",
    props: ['formFields'],
    computed: {
        isCreatePermitted(){
            return this.$store.getters.isPermitted({resource:'Orders',action:'create'});
        },
        isUpdatePermitted(){
            return this.$store.getters.isPermitted({resource:'Orders',action:'update'});
        },
    },
    data(){
        return {

            letterStyleList:[{value: 'oval', text:'Oval'},
                {value: 'flat', text:'Flat'},
                {value: 'traditional', text:'Traditional'},
                {value: 'veteran_flat', text:'Veteran Flat'},
                {value: 'engraved_roman', text:'Engraved Roman'},
                {value: 'engraved_script', text:'Engraved Script'},
                {value: 'other', text:'Other'},
            ],
            scrollTypeList:[{value: 'split', text:'Split - Year Date Only/unless otherwise specified'},
                {value: 'standard', text:'Standard Scroll (Extra for Preneed Scrolls)'},
                {value: 'tri-scroll', text:'Tri - Scroll'},
                {value: 'tri-scroll-death-tab', text:'Tri - Scroll - Death Date Tab'},
            ],
            axiosParams:{module: 'order/granit_bronz_memorial'},
            saveDisabled:false,
        }
    },
    methods:{
        save(){
            this.saveDisabled = true; //Disabling save button
            let data = this.formFields.granit_bronz_memorial;
            let formData = new FormData();
            formData.append('data',JSON.stringify(data));

            saveRecord(this.axiosParams, formData, (response) => {
                if (response.data.errorInfo){
                    let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                    this.makeToast({title: 'Error', message: message, variant: 'danger'});
                }
                else{
                    let message = `Record Successfully ${this.formFields.id ? 'Updated' : 'Added'}`;
                    this.makeToast({title: 'Success', message: message, variant: 'success'});
                }
            },(error) => {
                if (error.response.status == 403){
                    this.makeToast({title: 'Error', message: error.response.data.message , variant: 'danger', duration: 3000});
                }
            })
        },


        printPDF(){
            eventBus.$emit(event.PRINT_PDF)
        },
        getDayOfWeek:function(date) {
            if(date != null){
                const dayOfWeek = new Date(date).getDay();

                return isNaN(dayOfWeek) ? null :
                    ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
            }
        },
        makeToast(params) {
            this.$bvToast.toast(params.message, {
                title: params.title,
                variant: params.variant,
                toaster: 'b-toaster-top-center',
                autoHideDelay: 3000,
                noCloseButton: true,
            })
            this.saveDisabled = false;//enabling save button
        },
        checkDate: function(date){
            return searchForEmptyDate(date);
        },
        changeDateFormat: function(value){
            return this.$store.getters.changeDateFormat(value);
        },
    }

}
</script>

<style scoped>
.form-content{
    margin: 0 auto;
    width: 45rem;
}
.granit-memorial-row
{
    display: flex;
    margin: .5rem 0;
    padding: 0;
}
.granit-memorial-row div
{
    display: flex;
    margin: 0.3rem 0;
    width: 100%;
}
label{
    /*margin: auto 0.5rem;*/
    white-space: nowrap !important;
}
.granit-memorial-row div input{
    border: 1px solid #c4c4c4;
    margin: auto;
    margin-right: 0;
    height: 1.5rem;
    font-size: 0.75rem;
}
input, textarea{
    font-size: 0.75rem;
    border: 1px solid #c4c4c4;
}
header{
    padding: 0 3rem;
}
.input-xl{
    width: 20rem;
}
.input-lg{
    width: 12rem;
}
.input-md{
    width: 6rem;
}
.input-sm{
    width: 4rem;
}
.input-date{
    font-size: 0.75rem;
}

</style>
