<template>

    <div class="form-content">

        <div class="custom-row">
            <div>
                <h6 class="mx-auto text-red">OFFICE USE ONLY</h6>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <h6 class="mx-auto text-purple">CEMETERY CONFIRMATION</h6>
            </div>
        </div>

        <div class="custom-row">
            <div>
                <label class="font-weight-bold">** Does the Cemetery need to be called to confirm PLACEMENT of Monument:</label>
                <label class="print-elm ml-2">{{cemeteryConfirmation.confirm_placement_of_monument == 1 ? 'Yes' :
                    cemeteryConfirmation.confirm_placement_of_monument == 0 ?  'No' : '' }}</label>

                <b-form-group class="non-print-elm my-auto custom-radio-and-checkbox">
                    <b-form-radio-group name="cemetery_call_to_confirm_monument_placement" v-model="cemeteryConfirmation.confirm_placement_of_monument">
                        <b-form-radio class="mx-2 " name="cemetery-call-to-confirm-monument-placement-radio" value="1" size="sm">Yes</b-form-radio>
                        <b-form-radio class="mx-2 " name="cemetery-call-to-confirm-monument-placement-radio" value="0" size="sm">No</b-form-radio>
                    </b-form-radio-group>
                </b-form-group>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold">** Is PLACEMENT different then above:</label>
                <label class="print-elm ml-2">{{cemeteryConfirmation.different_placement == 1 ? 'Yes':
                    cemeteryConfirmation.different_placement == 0 ? 'No' : '' }}</label>
                <b-form-group class="non-print-elm my-auto custom-radio-and-checkbox">
                    <b-form-radio-group name="is_placement_different" v-model="cemeteryConfirmation.different_placement">
                        <b-form-radio class="mx-2 " name="is-placement-different-radio" value="1" size="sm">Yes</b-form-radio>
                        <b-form-radio class="mx-2 " name="is-placement-different-radio" value="0" size="sm">No</b-form-radio>
                    </b-form-radio-group>
                </b-form-group>
            </div>
        </div>
        <div class="custom-row">

            <div>
                <label class="non-print-elm font-weight-bold">If Yes, What is the new information:</label>
                <label class="print-elm font-weight-bold" style="margin: 0 !important;">If Yes, What is the new information:</label>
                <b-form-textarea
                    class="ml-2 py-0"
                    size="sm"
                    name="new_placement_information"
                    v-model="cemeteryConfirmation.placement_new_information"
                    no-resize
                ></b-form-textarea>
            </div>

        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold">** Does the Cemetery need to be called to confirm FACING of Monument:</label>
                <label class="print-elm ml-2">{{cemeteryConfirmation.confirm_facing_of_monument == 1 ? 'Yes' :
                    cemeteryConfirmation.confirm_facing_of_monument == 0 ? 'No' : '' }}</label>
                <b-form-group class="non-print-elm my-auto custom-radio-and-checkbox">
                    <b-form-radio-group name="cemetery_call_to_confirm_monument_facing" v-model="cemeteryConfirmation.confirm_facing_of_monument">
                        <b-form-radio class="mx-2 " name="different-monument-facing-radio" value="1" size="sm">Yes</b-form-radio>
                        <b-form-radio class="mx-2 " name="different-monument-facing-radio" value="0" size="sm">No</b-form-radio>
                    </b-form-radio-group>
                </b-form-group>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold">** Is FACING different then above:</label>
                <label class="print-elm ml-2">{{cemeteryConfirmation.different_facing == 1 ? 'Yes' :
                    cemeteryConfirmation.different_facing == 0 ? 'No' : ''}}</label>
                <b-form-group class="non-print-elm my-auto custom-radio-and-checkbox">
                    <b-form-radio-group name="is_facing_different" v-model="cemeteryConfirmation.different_facing">
                        <b-form-radio class="mx-2 " name="different-monument-facing-radio" value="1" size="sm">Yes</b-form-radio>
                        <b-form-radio class="mx-2 " name="different-monument-facing-radio" value="0" size="sm">No</b-form-radio>
                    </b-form-radio-group>
                </b-form-group>
            </div>
        </div>
        <div class="custom-row my-2">

            <div>
                <label class="non-print-elm font-weight-bold">If Yes, What is the new information:</label>
                <label class="print-elm font-weight-bold" style="margin: 0 !important;">If Yes, What is the new information:</label>
                <b-form-textarea
                    class="ml-2 py-0"
                    size="sm"
                    name="new_facing_information"
                    v-model="cemeteryConfirmation.facing_new_information"
                    no-resize
                ></b-form-textarea>
            </div>

        </div>

        <hr class="border">

        <div class="custom-row">
            <div>
                <h6 class="mx-1 text-purple">CEMETERY & PAYMENT INFORMATION</h6>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold">Make Check Payable to:</label>
                <b-form-input disabled type="text" class="ml-2" :class="inPDF ? 'input-border' : '' " name="payable_check" size="sm" v-model="formFields.cemetery.check_payable_to"></b-form-input>
            </div>
        </div>
        <div class="custom-row my-2">
            <div>
                <label class="font-weight-bold">Mailing Address:</label>
                <b-form-input disabled type="text" class="ml-2" :class="inPDF ? 'input-border' : '' " name="cemetery_mail_address" size="sm" v-model="formFields.cemetery.mailing_address"></b-form-input>
            </div>
        </div>
        <div class="custom-row">
            <div class="w-auto">
                <label class="font-weight-bold">City:</label>
                <b-form-input disabled type="text" class="input-md w-auto mx-2" :class="inPDF ? 'input-border' : '' " name="cemetery_city" size="sm" v-model="formFields.cemetery.city_name"></b-form-input>
            </div>
            <div class="w-auto mx-3">
                <label class="font-weight-bold">State:</label>
                <b-form-input disabled type="text" class="input-md mx-2" :class="inPDF ? 'input-border' : '' " name="cemetery_state" size="sm" v-model="formFields.cemetery.state_name"></b-form-input>
            </div>
            <div class="w-auto">
                <label class="font-weight-bold">Zip:</label>
                <b-form-input disabled type="text" class="input-md mx-2" :class="inPDF ? 'input-border' : '' " name="cemetery_zip" size="sm" v-model="formFields.cemetery.zip"></b-form-input>
            </div>
        </div>
        <div class="custom-row my-2">
            <div class="col-6 px-0">
                <label class="font-weight-bold">Cemetery Fees: $</label>
                <b-form-input type="text" class="mx-2" :class="inPDF ? 'input-border' : '' " name="cemetery_fees" size="sm" v-model="payment.cemetery_fees"></b-form-input>
            </div>
            <div class="col-6 px-0">
                <label class="font-weight-bold">Check Wrote on:</label>
                <b-form-input type="text" class="mx-2" :class="inPDF ? 'input-border' : '' " name="cemetery_check_wrote_on" size="sm" v-model="payment.check_wrote_on"></b-form-input>
            </div>
        </div>
        <div class="custom-row">
            <div class="">
                <label class="print-elm mx-auto" style="margin-left: 55% !important;">{{payment.check_delivered ? 'Takes(ing) to Jobsite': 'Mailed'}}</label>
                <b-form-group class="non-print-elm ml-auto text-nowrap custom-radio-and-checkbox">
                    <b-form-radio-group name="send_check_to" v-model="payment.check_delivered">
                        <b-form-radio class="mx-2" name="send-check-to-radio" value="0" size="sm">Mailed</b-form-radio>
                        <b-form-radio class="mx-2" name="send-check-to-radio" value="1" size="sm">Takes(ing) to Jobsite</b-form-radio>
                    </b-form-radio-group>
                </b-form-group>
            </div>
        </div>

        <hr class="border">

        <div class="custom-row">
            <div>
                <h6 class="mx-auto text-purple">FLAGGING</h6>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold col-3 px-0">Has Cemetery been called:</label>
                <label class="print-elm ml-n4">{{formFields.order_installation.cemetery_called == 1  ? 'Yes' :
                    formFields.order_installation.cemetery_called == 0 ? 'No' : ''}}</label>
                <b-form-group class="non-print-elm my-auto custom-radio-and-checkbox">
                    <b-form-radio-group name="has_cemetery_been_called" v-model="formFields.order_installation.cemetery_called">
                        <b-form-radio class="mx-2" name="has-cemetery-been-called-radio" value="1" size="sm">Yes</b-form-radio>
                        <b-form-radio class="mx-2" name="has-cemetery-been-called-radio" value="0" size="sm">No</b-form-radio>
                    </b-form-radio-group>
                </b-form-group>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold col-3 px-0">Has the Grave been flagged:</label>
                <label class="print-elm ml-n4">{{formFields.order_installation.grave_flagged == 1 ? 'Yes' :
                    formFields.order_installation.grave_flagged == 0 ? 'No' : ''}}</label>
                <b-form-group class="non-print-elm my-auto custom-radio-and-checkbox">
                    <b-form-radio-group name="has_grave_been_flagged" v-model="formFields.order_installation.grave_flagged">
                        <b-form-radio class="mx-2" name="has-grave-been-flagged-radio" value="1" size="sm">Yes</b-form-radio>
                        <b-form-radio class="mx-2" name="has-grave-been-flagged-radio" value="0" size="sm">No</b-form-radio>
                    </b-form-radio-group>
                </b-form-group>
            </div>
        </div>
        <div class="custom-row mb-5">
            <div>
                <label class="font-weight-bold">Last Name on Monument</label>
                <div class="bg-yellow text-dark rounded p-1 mx-2">
                    <label>{{formFields.family.name_on_stone}}</label>
                </div>

                <label class="font-weight-bold">Inv. #</label>
                <div class="bg-yellow text-dark rounded p-1 w-50 ml-2">
                    <label>{{formFields.invoice.invoice_number}}</label>
                </div>

            </div>
        </div>

    </div>

</template>

<script>
import {event, eventBus} from '../../../../event-bus/event-bus';

export default {
    name: "Step-3",
    props: ['formFields','inPDF'],
    computed:{
        cemeteryConfirmation(){
            if (this.formFields.order_installation.cemetery_confirmation == null){
                this.formFields.order_installation.cemetery_confirmation = {id:0};
            }
            return this.formFields.order_installation.cemetery_confirmation;
        },
        payment(){
            if (this.formFields.order_installation.payment == null){
                this.formFields.order_installation.payment = {id:0};
            }
            return this.formFields.order_installation.payment;
        }
    },
    data() {
        return {}
    },
    created() {
        if(!this.$props.inPDF)
            eventBus.$on(event.SAVE_ORDER_INSTALLATION_STEP3, this.storeStep);
    },
    beforeDestroy() {
        if(!this.$props.inPDF)
            eventBus.$off(event.SAVE_ORDER_INSTALLATION_STEP3);
    },
    methods:{
        storeStep(){
            console.log('step-3');
            eventBus.$emit(event.SAVE_ORDER_INSTALLATION, this.formFields);
        }
    }

    }
</script>

<style scoped>
    .form-content{
        margin: 0 auto;
        /*width: 40rem;*/
    }
    .custom-row {
        display: flex;
        padding: 0;
    }
    .custom-row div {
        display: flex;
        margin: 0.1rem 0;
        width: 100%;
    }
    .custom-row div label{
        margin: auto 0;
        white-space: nowrap !important;
    }
    .custom-row div input {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        margin-right: 0;
        height: 1.5rem;
        font-size: 0.75rem;
    }
    textarea{
        font-size: 0.75rem;
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
    .custom-row div .input-border{
        border: none !important;
    }

    /*.print-elm{
        display: none !important;
    }

    .printing .form-content{
        width: 100%;
    }
    .printing label, .printing input, .printing textarea{
        font-size: 1.3rem;
    }
    .printing h6, .printing h3{
        font-size: 1.5rem;
    }
    .printing input, .printing textarea{
        border-color: transparent !important;
        background: transparent !important;
        pointer-events: none;
        height: auto !important;
    }
    .printing .non-print-elm{
        display: none !important;
    }
    .printing .print-elm{
        display: block !important;
        margin: auto .5rem;
    }*/
</style>
