<template>
    <div class="bg-white mt-n1 pt-1">
        <div>
            <h3 class="mx-2 my-1 custom-form-heading"> Final Date Request Form</h3>
            <div class="d-flex non-print-elm justify-content-center bg-toolbar my-2 p-1">
                <button type="button" v-if="formFields.id > 0 ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                    {{ formFields.id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                </button>
                <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/orders/' +id">Cancel</router-link>

            </div>
        </div>

        <PDF :title="'printFinalDate'">

            <div slot="header" class="pdf-custom-margin-form">
                <h2 class="pdf-title col-md-12">FINAL DATE REQUEST FORM</h2>
                <div>
                    <div class=" final-date-row border rounded">
                        <div class="d-block border-right px-1 pt-1 my-0">
                            <label class="font-weight-bold">Date:</label><br>
                            <label>{{ changeDateFormat(order_date) }}</label>
                        </div>
                        <!--<div class="d-block border-right px-1 pt-1 my-0">
                            <label class="font-weight-bold">Day:</label><br>
                            <label>{{getDayOfWeek(order_date)}}</label>
                        </div>-->
                        <div class="d-block border-right px-1 pt-1 my-0">
                            <label class="font-weight-bold">Last Name on Stone:</label>
                            <label class="d-block">{{name_on_stone ? name_on_stone.toUpperCase() : '' }}</label>
                        </div>
                        <div class="d-block px-1">
                            <label class="font-weight-bold">Invoice. No:</label>
                            <label class="d-block">{{invoice_no}}</label>
                        </div>
                    </div>
                    <div class="final-date-row">
                        <div class="">
                            <label class="font-weight-bold pdf-labels">Contact:</label>

                            <b-form-input
                                    class="ml-2 input-xl pdf-fields"
                                    size="sm"

                                    v-model="formFields.contact"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="final-date-row my-2">
                        <div class="flex-grow-1">
                            <label class="font-weight-bold pdf-labels">Address</label>

                            <b-form-input
                                    class="ml-2 pdf-fields"
                                    rows="1"
                                    size="sm"
                                    name="who_follow_up"

                                    v-model="formFields.address"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="final-date-row flex-grow-1 my-2">
                        <div class="custom-div-size1">
                            <label class="font-weight-bold pdf-labels">Phone:</label>
                            <b-form-input type="text"  class="form-control form-control-sm pdf-fields " size="sm" style="border:none !important" v-model="formFields.phone"></b-form-input>
                        </div>
                        <div class="pdf-custom-div-size2 pdf-margin-email">
                            <label class="font-weight-bold pdf-labels">E-Mail:</label>
                            <b-form-input type="text"  class="form-control form-control-sm pdf-fields" size="sm" style="border:none !important" v-model="formFields.email"></b-form-input>
                        </div>
                    </div>
                    <div class="final-date-row my-2">
                        <div class="flex-grow-1">
                            <label class="font-weight-bold pdf-labels">Cemetery Name and City</label>

                            <b-form-input
                                    class="ml-2 pdf-fields"
                                    size="sm"

                                    v-model="formFields.cemetery_details"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="final-date-row my-2">
                        <div class="flex-grow-1">
                            <label class="font-weight-bold pdf-labels">Last Name on Stone:</label>

                            <b-form-input
                                    class="ml-1 input-lg pdf-fields"
                                    size="sm"

                                    v-model="formFields.name_on_stone"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="final-date-row my-2">
                        <div class="flex-grow-1">
                            <label class="font-weight-bold pdf-labels">Name of whom the Engraving is for:</label>

                            <b-form-input
                                    class="ml-1 input-xl pdf-fields"
                                    size="sm"

                                    v-model="formFields.engraving_for"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="final-date-row my-2">
                        <div class="custom-div-size2">
                            <label class="font-weight-bold pdf-labels">Birth Date On Stone:</label>
<!--                            v-model="formFields.birth_date"-->
                            <b-form-input
                                    class="my-1 ml-2 input-date input-lg pdf-fields"
                                    size="sm"
                                    :value="changeDateFormat(formFields.birth_date)"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="final-date-row my-2">
                        <div class="flex-grow-1">
                            <label class="font-weight-bold pdf-labels text-final-date" style="color: #007BFF !important">Final Date to be added:</label>
<!--                            v-model="formFields.final_date"-->
                            <b-form-input
                                    class="my-2 ml-2 input-date input-lg pdf-fields"
                                    size="sm"
                                    :value="changeDateFormat(formFields.final_date)"
                                    style="border:none !important;color: #007BFF !important"
                            ></b-form-input>
                        </div>
                        <div class="custom-div-size2 pdf-final-type-margin">
                            <label class="m-0 my-auto custom-radio-and-checkbox input-lg pdf-labels">{{printFinalType(formFields.final_type)}}</label>
                        </div>

                    </div>
                    <div class="final-date-row my-2 ">
                        <div class="flex-grow-1">
                            <label class="font-weight-bold pdf-labels">Scroll Size:</label>

                            <label class="font-weight-bold pdf-labels">Length:</label>
                            <b-form-input
                                    class="ml-1 input-md pdf-fields"
                                    size="sm"

                                    v-model="formFields.scroll_length"
                                    style="border:none !important"
                            ></b-form-input>
                            <label class="font-weight-bold pdf-labels">Width:</label>
                            <b-form-input
                                    class="ml-1 input-md pdf-fields"
                                    size="sm"

                                    v-model="formFields.scroll_width"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>
                        <div class="custom-div-size2">
                            <label class="font-weight-bold pdf-drill-margin pdf-labels">Drills Points Center to Center:</label>
                            <b-form-input
                                    class="scroll-margin input-md pdf-fields"
                                    size="sm"
                                    v-model="formFields.drill_points"
                                    style="border:none !important;"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="final-date-row my-2">
                        <div class="flex-grow-1">
                            <label class="font-weight-bold pdf-labels">Rubbing needed:</label>
                            <label class="m-0 my-auto custom-radio-and-checkbox input-lg pdf-labels ml-3">{{printRubbing(formFields.rubbing_needed)}}</label>
                        </div>
                        <div class="custom-div-size2 ml-2">
                            <label class="font-weight-bold pdf-labels">Date of Rubbing:</label>
<!--                            v-model="formFields.rubbing_date"-->
                            <b-form-input
                                    class="my-2 ml-2 input-date input-lg pdf-fields"
                                    size="sm"
                                    :value="changeDateFormat(formFields.rubbing_date)"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="final-date-row my-2">
                        <div class="flex-grow-1">
                            <label class="font-weight-bold pdf-labels">Description of Stone:</label>

                            <b-form-input
                                    class="ml-2 pdf-fields"
                                    size="sm"

                                    v-model="formFields.stone_description"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="final-date-row my-2">
                        <div class="custom-div-size2">
                            <label class="font-weight-bold pdf-labels">Size:</label>

                            <b-form-input
                                    class="ml-2 pdf-fields"
                                    size="sm"

                                    v-model="formFields.size"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="final-date-row my-2">
                        <div class="custom-div-size2">
                            <label class="font-weight-bold pdf-labels">Color:</label>

                            <b-form-input
                                    class="ml-2 pdf-fields"
                                    size="sm"

                                    v-model="formFields.color"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="final-date-row mt-2">
                        <div class=" flex-column flex-grow-1">
                            <label class="font-weight-bold pdf-labels">*** Please give brief description of location of stone (pin location)</label>

                            <b-form-textarea
                                    class="ml-1 pdf-fields"
                                    rows="4"
                                    size="sm"

                                    v-model="formFields.description"
                                    no-resize
                            ></b-form-textarea>
                        </div>

                    </div>
                    <div class="final-date-row mt-3">
                        <div class="flex-grow-1 custom-div-size2">
                            <label class="font-weight-bold pdf-labels">Engraving Completed on (Date):</label>
<!--                            v-model="formFields.date_on_completion"-->
                            <b-form-input
                                    class="my-auto input-date pdf-fields"
                                    size="sm"
                                    :value="changeDateFormat(formFields.date_on_completion)"
                                    style="border:none !important"
                            ></b-form-input>

                        </div>
                        <div class="flex-grow-1 custom-div-size1">
                            <label class="font-weight-bold pdf-labels">Completed By:</label>
                            <b-form-input
                                    class="ml-2 pdf-fields"
                                    size="sm"

                                    v-model="formFields.completed_by"
                                    style="border:none !important"
                            ></b-form-input>


                        </div>

                    </div>
                    <div class="final-date-row mx-5 mt-5">
                        <div class="flex-grow-1 custom-div-size2">
                            <label class="font-weight-bold pdf-labels">Approved By:</label>

                            <b-form-input
                                    class="ml-2 pdf-fields"
                                    size="sm"

                                    v-model="formFields.approved_by"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>
                        <div class="flex-grow-1 custom-div-size1">
                            <label class="font-weight-bold pdf-labels">Date:</label>
<!--                            v-model="formFields.date"-->
                            <b-form-input
                                    class="my-auto input-date pdf-fields"
                                    size="sm"
                                    :value="changeDateFormat(formFields.date)"
                                    style="border:none !important"
                            ></b-form-input>
                        </div>

                    </div>
                    <div class="pdf-custom-title mt-3">
                        BY SIGNING THE APPROVAL I ASSUME COMPLETE RESPONSIBILITY FOR LAYOUT/SPELLING/DATES.<br>
                        I ALSO AGREE THAT AFTER SIGNING THE APPROVAL, NO FURTHER CHANGES WILL BE MADE & IF <br>
                        SOMETHING IS INCORRECT UPON COMPLETION OF THE MONUMENT I AM RESPONSIBLE <br>
                        FOR THE COST TO CORRECT IT.
                    </div>

                </div>
            </div>

        </PDF>

        <div id="final-date" class="d-flex justify-content-center py-0" >
            <form id="final-date-form" class="form-width" >
                <div v-bind:class="[alertClasses, 'd-flex justify-content-center m-auto p-0 w-50']">{{alertMessage}}</div>
                <div class=" final-date-row border rounded">
                    <div class="d-block border-right px-1 pt-1 my-0">
                        <label class="font-weight-bold">Date:</label><br>
                        <label>{{ changeDateFormat(order_date) }}</label>
                    </div>
                    <!--<div class="d-block border-right px-1 pt-1 my-0">
                        <label class="font-weight-bold">Day:</label><br>
                        <label>{{getDayOfWeek(order_date)}}</label>
                    </div>-->
                    <div class="d-block border-right px-1 pt-1 my-0">
                        <label class="font-weight-bold">Last Name on Stone:</label>
                        <label class="d-block">{{name_on_stone ? name_on_stone.toUpperCase() : '' }}</label>
                    </div>
                    <div class="d-block px-1">
                        <label class="font-weight-bold">Invoice. No:</label>
                        <label class="d-block">{{invoice_no}}</label>
                    </div>
                </div>
                <div class="final-date-row">
                    <div class="">
                        <label class="font-weight-bold">Contact:</label>

                        <b-form-input
                                class="ml-2 input-xl"
                                size="sm"
                                v-model="formFields.contact"
                                readonly
                        ></b-form-input>
                    </div>

                </div>
                <div class="final-date-row">
                    <div class="flex-grow-1">
                        <label class="font-weight-bold">Address</label>

                        <b-form-input
                                class="ml-2"
                                rows="1"
                                size="sm"
                                name="who_follow_up"
                                v-model="formFields.address"
                                no-resize
                                readonly
                        ></b-form-input>
                    </div>

                </div>
                <div class="final-date-row flex-grow-1">
                    <div class="custom-div-size1">
                        <label class="font-weight-bold">Phone:</label>
                        <b-form-input type="text"  class="form-control form-control-sm" size="sm" v-model="formFields.phone" readonly></b-form-input>
                    </div>
                    <div class="custom-div-size2">
                        <label class="font-weight-bold">E-Mail:</label>
                        <b-form-input type="text"  class="form-control form-control-sm" size="sm" v-model="formFields.email" readonly></b-form-input>
                    </div>
                </div>
                <div class="final-date-row">
                    <div class="flex-grow-1">
                        <label class="font-weight-bold">Cemetery Name and City</label>

                        <b-form-input
                                class="ml-2"
                                size="sm"
                                v-model="formFields.cemetery_details"
                                no-resize
                                readonly
                        ></b-form-input>
                    </div>

                </div>
                <div class="final-date-row">
                    <div class="flex-grow-1">
                        <label class="font-weight-bold">Last Name on Stone:</label>

                        <b-form-input
                                class="ml-1 input-lg"
                                size="sm"
                                v-model="formFields.name_on_stone"
                                readonly
                        ></b-form-input>
                    </div>

                </div>
                <div class="final-date-row">
                    <div class="flex-grow-1">
                        <label class="font-weight-bold">Name of whom the Engraving is for:</label>

                        <b-form-input
                                class="ml-1 input-xl"
                                size="sm"
                                v-model="formFields.engraving_for"
                        ></b-form-input>
                    </div>

                </div>
                <div class="final-date-row">
                    <div class="custom-div-size2">
                        <label class="font-weight-bold">Birth Date On Stone:</label>

                        <b-form-datepicker  :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="my-auto ml-2 input-date input-lg" size="sm" name="date" placeholder="" v-model="formFields.birth_date"
                                            @input="formFields.birth_date = checkDate(formFields.birth_date)"
                                           today-button
                                           reset-button
                                           close-button
                                           locale="en">

                        </b-form-datepicker>
                    </div>

                </div>
                <div class="final-date-row my-n2">
                    <div class="custom-div-size2">
                        <label class="font-weight-bold text-final-date" style="color: #007BFF !important">Final Date to be added:</label>

                        <b-form-datepicker  :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="my-auto ml-2 input-date input-lg" size="sm" name="date" placeholder="" v-model="formFields.final_date"
                                            @input="formFields.final_date = checkDate(formFields.final_date)"
                                           today-button
                                           reset-button
                                           close-button
                                           locale="en">

                        </b-form-datepicker>
                    </div>
                    <div class="custom-div-size2">
                        <b-form-group class="m-0 my-auto custom-radio-and-checkbox input-lg">
                            <b-form-radio-group  v-model="formFields.final_type">
                                <b-form-radio name="call-customer-radio"  :value=1>Engraved</b-form-radio>
                                <b-form-radio name="call-customer-radio"  :value=0>Bronze Scroll</b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>

                    </div>

                </div>
                <div class="final-date-row my-n1 ">
                    <div class="flex-grow-1">
                        <label class="font-weight-bold">Scroll Size:</label>

                        <label class="font-weight-bold">Length:</label>
                        <b-form-input
                                class="ml-1 input-md"
                                size="sm"
                                v-model="formFields.scroll_length"
                        ></b-form-input>
                        <label class="font-weight-bold">Width:</label>
                        <b-form-input
                                class="ml-1 input-md"
                                size="sm"
                                v-model="formFields.scroll_width"
                        ></b-form-input>
                    </div>
                    <div class="custom-div-size2">
                        <label class="font-weight-bold">Drills Points Center to Center:</label>
                        <b-form-input
                                class="scroll-margin input-md"
                                style="width: 6.9rem !important;"
                                size="sm"
                                v-model="formFields.drill_points"
                        ></b-form-input>
                    </div>

                </div>
                <div class="final-date-row my-n2">
                    <div class="flex-grow-1">
                       <label class="font-weight-bold">Rubbing needed:</label>
                        <b-form-group class="m-0 my-auto custom-radio-and-checkbox input-md">
                            <b-form-radio-group   v-model="formFields.rubbing_needed">
                                <b-form-radio name="call-customer-radio"  :value=1>Yes</b-form-radio>
                                <b-form-radio name="call-customer-radio"  :value=0>No</b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>
                    </div>
                    <div class="custom-div-size2">
                        <label class="font-weight-bold">Date of Rubbing:</label>

                        <b-form-datepicker  :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="my-auto ml-2 input-date input-lg" size="sm" name="date" placeholder="" v-model="formFields.rubbing_date"
                                            @input="formFields.rubbing_date = checkDate(formFields.rubbing_date)"
                                           today-button
                                           reset-button
                                           close-button
                                           locale="en">

                        </b-form-datepicker>
                    </div>

                </div>
                <div class="final-date-row">
                    <div class="flex-grow-1">
                        <label class="font-weight-bold">Description of Stone:</label>

                        <b-form-input
                                class="ml-2"
                                size="sm"
                                v-model="formFields.stone_description"
                                no-resize
                        ></b-form-input>
                    </div>

                </div>
                <div class="final-date-row">
                    <div class="custom-div-size2">
                        <label class="font-weight-bold">Size:</label>

                        <b-form-input
                                class="ml-2"
                                size="sm"
                                v-model="formFields.size"
                        ></b-form-input>
                    </div>

                </div>
                <div class="final-date-row">
                    <div class="custom-div-size2">
                        <label class="font-weight-bold">Color:</label>

                        <b-form-input
                                class="1"
                                size="sm"
                                v-model="formFields.color"
                        ></b-form-input>
                    </div>

                </div>
                <div class="final-date-row">
                    <div class=" flex-column flex-grow-1">
                        <label class="font-weight-bold">*** Please give brief description of location of stone (pin location)</label>

                        <b-form-textarea
                                class="ml-1"
                                rows="3"
                                size="sm"
                                v-model="formFields.description"
                                no-resize
                        ></b-form-textarea>
                    </div>

                </div>
                <div class="final-date-row ">
                    <div class="flex-grow-1 custom-div-size2">
                        <label class="font-weight-bold">Engraving Completed on (Date):</label>

                        <b-form-datepicker  :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="my-auto input-date" size="sm" name="date" placeholder="" v-model="formFields.date_on_completion"
                                            @input="formFields.date_on_completion = checkDate(formFields.date_on_completion)"
                                           today-button
                                           reset-button
                                           close-button
                                           locale="en">

                        </b-form-datepicker>
                    </div>
                    <div class="flex-grow-1 custom-div-size1">
                        <label class="font-weight-bold">Completed By:</label>
                        <b-form-input
                                class="ml-2"
                                size="sm"
                                v-model="formFields.completed_by"
                        ></b-form-input>


                    </div>

                </div>
                <div class="final-date-row mx-5">
                    <div class="flex-grow-1 custom-div-size2">
                        <label class="font-weight-bold">Approved By:</label>

                        <b-form-input
                                class="ml-2"
                                size="sm"
                                v-model="formFields.approved_by"
                        ></b-form-input>
                    </div>
                    <div class="flex-grow-1 custom-div-size1">
                        <label class="font-weight-bold">Date:</label>

                        <b-form-datepicker  :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="my-auto input-date" size="sm" name="date" placeholder="" v-model="formFields.date"
                                            @input="formFields.date = checkDate(formFields.date)"
                                           today-button
                                           reset-button
                                           close-button
                                           locale="en">

                        </b-form-datepicker>
                    </div>

                </div>
                <div class="custom-title mt-2">
                    BY SIGNING THE APPROVAL I ASSUME COMPLETE RESPONSIBILITY FOR LAYOUT/SPELLING/DATES.<br>
                    I ALSO AGREE THAT AFTER SIGNING THE APPROVAL, NO FURTHER CHANGES WILL BE MADE & IF <br>
                    SOMETHING IS INCORRECT UPON COMPLETION OF THE MONUMENT I AM RESPONSIBLE <br>
                    FOR THE COST TO CORRECT IT.
                </div>

                <div>
                    <div class="my-2 ml-1" >
                        <button type="button" class="btn btn-sm btn-info custom-print-button  px-2" @click="printPdf">Print Preview</button>
                        <!--<button type="button" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="storeFinalDate" :disabled="saveDisabled">
                            {{ id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                        </button>
                        <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" to="/order-list">Cancel</router-link>
                   --> </div>
                </div>
            </form>
        </div>


    </div>
</template>

<script>
    import PDF from "../../../../Modules/PDF-Modal";
    import {event, eventBus} from "../../../../event-bus/event-bus";
    import {saveRecord, fetchRecord, deleteRecord,nextRecord, previousRecord, firstRecord, lastRecord} from "../../../../helpers/axios";
    import {searchForEmptyDate} from "../../../../helpers/common";
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
            return  {
                formFields:{
                    id:0,
                    contact:null,
                    address:null,
                    phone:null,
                    email:null,
                    cemetery_details:null,
                    name_on_stone:null,
                    engraving_for:null,
                    birth_date:null,
                    final_date:null,
                    final_type:null,
                    scroll_length:null,
                    scroll_width:null,
                    drill_points:null,
                    rubbing_needed:null,
                    rubbing_date:null,
                    stone_description:null,
                    size:null,
                    color:null,
                    description:null,
                    date_on_completion:null,
                    completed_by:null,
                    approved_by:null,
                    date:null,
                    order_id:null
                },
                order_day:'',
                order_date:null,
                name_on_stone:'',
                invoice_no:null,
                axiosParams: {module: 'order/finalDate'},
                axiosParamsOrder: {module: 'order'},
                alertMessage:'',
                hideAlert:true,
                successResponse: false,
                errorResponse: false,
                saveDisabled:false,
            }
        },
        metaInfo() {
            return {
                title: 'Final Date Request'
            }
        },
        components:{
            PDF
        },
        computed:{
            alertClasses: function () {
                return {
                    alert: true,
                    'alert-success': this.successResponse,
                    'alert-danger': this.errorResponse,
                    'd-none': this.hideAlert
                }
            },
            isCreatePermitted(){
                return this.$store.getters.isPermitted({resource:'Orders',action:'create'});
            },
            isUpdatePermitted(){
                return this.$store.getters.isPermitted({resource:'Orders',action:'update'});
            },
        },
        beforeCreate(){
            if(!this.$store.getters.isPermitted({resource:'Orders',action:'read'}))
                this.$router.push( '/access-denied');
        },
        mounted() {
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            this.getFinalDate();
            this.$store.getters.detectFormChanges();
        },
        methods:{
            getFinalDate(){
                this.axiosParams.id = this.formFields.id;
                fetchRecord(this.axiosParams, (response) => {
                    this.formFields = response.data.final_date;

                    this.order_date = response.data.date;
                    this.order_day = this.getDayOfWeek(response.data.date);

                    if(response.data.invoice != undefined)
                        this.invoice_no  = response.data.invoice.invoice_number;
                    if(response.data.family != undefined)
                        this.name_on_stone  = response.data.family.name_on_stone;
                        this.formFields = response.data.family;
                    if(response.data.cemetery != undefined)
                        this.formFields.cemetery_details  = response.data.cemetery.company.concat(", ",response.data.cemetery.city.city_title);

                })
            },
            save(){
                this.saveDisabled = true; //Disabling save button
                let data = this.formFields;
                let formData = new FormData();
                formData.append('data',JSON.stringify(data));

                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo){
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                      /*  this.errorResponse = true;
                        this.handleAlert();*/
                        this.makeToast({title: "Error", message:this.alertMessage, variant: "danger", duration: 5000});
                        this.alertMessage = '';
                    }
                    else{
                        let status = this.formFields.id ? 'Updated': 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                        /*this.successResponse = true;
                        this.handleAlert();*/
                        this.makeToast({title: 'Success', message: this.alertMessage, variant: 'success'});
                        this.alertMessage = '';

                        this.formFields = response.data;
                        let record = Object.values(this.$store.state[this.axiosParamsOrder.module].recordList).find(obj => obj.id == this.id);
                        if (record != undefined) {
                            record.final_date.id = this.formFields.id
                        }
                        // this.axiosParams.data = response.data;
                        // this.$store.commit('appendOrUpdateInRecordList', this.axiosParams);
                    }
                },(error) => {
                    if (error.response.status == 403){
                        this.makeToast({title: 'Error', message: error.response.data.message , variant: 'danger', duration: 3000});
                    }
                })
            },
            handleAlert: function(){
                this.saveDisabled = false;//enabling save button
                this.hideAlert = false;
                setTimeout(() => {
                    this.alertMessage = "";
                    this.successResponse = false;
                    this.errorResponse = false;
                    this.hideAlert = true;
                }, 3000)
            },
            printPdf() {
                eventBus.$emit(event.PRINT_PDF);
            },
            getDayOfWeek:function(date) {
                if(date != null){
                    const dayOfWeek = new Date(date).getDay();

                    return isNaN(dayOfWeek) ? null :
                        ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
                }
            },
            printFinalType(val) {
                if(val == 1)
                    return 'Engraved'
                else if(val == 0)
                    return 'Bronze Scroll'
                else
                    return ''
            },
            printRubbing(val) {
                if(val == 1)
                    return 'Yes'
                else if(val == 0)
                    return 'No'
                else
                    return ''
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
            checkDate: function(date){
                return searchForEmptyDate(date);
            },
            changeDateFormat: function(value){
                return this.$store.getters.changeDateFormat(value);
            },
        },
    }
</script>

<style scoped>

    .pdf-fields{
        border:none !important;
        color: black !important;
        font-size: 22px !important;
    }
    .pdf-labels{
        font-size: 22px !important;
    }
    .pdf-margin-email{
        margin-left: 10rem !important;
    }
    .pdf-custom-margin-form{
        margin-top:1rem !important;
        margin-left: 2rem !important;
        margin-right: 2rem !important;
    }
    .pdf-title{
        font-family: Roboto;
        font-style: normal;
        font-weight: 600;
        font-size: 30px;
        line-height: 25px;
        text-align: center;
        letter-spacing: 0.02em;
        color: #000000;
    }
    .pdf-custom-title{
        font-weight: 600;
        font-size: 18px;
        line-height: 17px;
        text-align: center;
        letter-spacing: 0.02em;
    }
    .pdf-custom-table-header,.pdf-custom-table-body{
        font-size: 22px;
        border: 2px solid #c4c4c4;
    }
    .pdf-custom-div-size2{
        width:30rem !important;
    }
    .pdf-drill-margin{
        margin-left: 1.6rem !important;
    }
    .pdf-final-type-margin{
        margin-left: -19.8rem !important;
    }

    .pdf label{
        display: block;
        font-size: 0.5em;
        margin-bottom: 0;
    }

    .form-width{
        width:45rem !important;
    }

    .final-date-row
    {
        display: flex;
        padding: 0;
    }
    .final-date-row div
    {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }
    .final-date-row div  label{
        margin: auto 0.5rem;
        white-space: nowrap !important;
        color: #000 !important;
    }
    .final-date-row div input,textarea,.input-date{
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        margin-right: 0;
        font-size: 12px;
    }
    .final-date-row div input,.input-date{
        height:1.5rem;
    }

    header{
        padding: 0 3rem;
    }
    .scroll-margin{
        margin-left: 1.2rem !important;
    }

    .input-xl{
        width: 20rem !important;
    }
    .input-lg{
        width: 12rem !important;
    }
    .input-md{
        width: 6rem !important;
    }

    .custom-print-button{
        font-size: 12px;
        background: #007BFF;
        box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.25);
        border-radius: 5px
    }
    .text-final-date{
        color:#007BFF !important;
    }

    .custom-div-size1{
        width:20rem !important;
    }
    .custom-div-size2{
        width:25rem !important;
    }

    .table-bordered th {
        border-bottom: none;
    }
    .table-bordered td {
        border-top: none;
    }
    .custom-title{
        font-weight: 600;
        font-size: 13px;
        line-height: 15px;
        text-align: center;
        letter-spacing: 0.02em;
    }
    .custom-dangerbtn-text{
        width: 89px;
    }

</style>
