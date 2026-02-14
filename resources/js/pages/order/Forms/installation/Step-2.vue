<template>

    <div class="form-content">

        <div class="custom-row">
            <div>
                <h5 class="mx-auto text-purple">PLACEMENT</h5>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold px-0 col-3 mr-n4">The <span class="text-red">Female</span> is buried in the</label>

                <label class="print-elm d-none mx-2 ml-n2">{{placement.female_buried_direction ? placement.female_buried_direction.toUpperCase() : ''}}</label>
                <b-form-group class="non-print-elm m-0 my-auto custom-radio-and-checkbox">
                    <b-form-radio-group name="placement_of_buried_female" v-model="placement.female_buried_direction">
                        <b-form-radio class="mx-2" name="placement-of-buried-female-radio" value="n" size="sm">N</b-form-radio>
                        <b-form-radio class="mx-2" name="placement-of-buried-female-radio" value="s" size="sm">S</b-form-radio>
                        <b-form-radio class="mx-2" name="placement-of-buried-female-radio" value="e" size="sm">E</b-form-radio>
                        <b-form-radio class="mx-2" name="placement-of-buried-female-radio" value="w" size="sm">W</b-form-radio>
                    </b-form-radio-group>
                </b-form-group>
                <label class="font-weight-bold">Grave</label>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold px-0 col-3 mr-n4">The <span class="text-red">Male</span> is buried in the</label>

                <label class="print-elm d-none mx-2 ml-n4" :class="inPDF ? '' : '' ">{{placement.male_buried_direction ? placement.male_buried_direction.toUpperCase() : ''}}</label>
                <b-form-group class="non-print-elm my-auto custom-radio-and-checkbox">
                    <b-form-radio-group name="placement_of_buried_male" v-model="placement.male_buried_direction">
                        <b-form-radio class="mx-2" name="placement-of-buried-female-radio" value="n" size="sm">N</b-form-radio>
                        <b-form-radio class="mx-2" name="placement-of-buried-female-radio" value="s" size="sm">S</b-form-radio>
                        <b-form-radio class="mx-2" name="placement-of-buried-female-radio" value="e" size="sm">E</b-form-radio>
                        <b-form-radio class="mx-2" name="placement-of-buried-female-radio" value="w" size="sm">W</b-form-radio>
                    </b-form-radio-group>
                </b-form-group>
                <label class="font-weight-bold">Grave</label>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold">The Names on the Monument Should Face:</label>
                <label class="print-elm d-none" :class="inPDF ? 'ml-2' : '' ">{{placement.name_should_face == 1 ? 'Away from the Grave' :
                    placement.name_should_face == 0 ? 'The Grave' : '' }}</label>
                <label class="print-elm d-none" :class="inPDF ? 'ml-2' : '' ">{{placement.face_dimension}}</label>

                <b-form-group class="non-print-elm my-auto custom-radio-and-checkbox ml-2">

                    <b-form-radio-group name="the_grave" v-model="placement.name_should_face">

                        <b-form-radio class="mx-2 text-nowrap" name="the-grave-radio" value="0" size="sm">The Grave</b-form-radio>

                        <!--<b-form-select size="sm"
                                       class="input-md custom-caret-agreement"
                                       :options="dimensionList"
                                       v-model="placement.face_dimension">
                            <template #first>
                                <b-form-select-option :value="null" disabled >Select</b-form-select-option>
                            </template>
                        </b-form-select>-->

                        <b-form-radio class="mx-2 text-nowrap" name="the-grave-radio" value="1" size="sm">Away from the Grave</b-form-radio>

                        <b-form-select size="sm"
                                       class="input-md ml-4 custom-caret-agreement"
                                       :options="dimensionList"
                                       v-model="placement.face_dimension">
                            <template #first>
                                <b-form-select-option :value="null" disabled >Select</b-form-select-option>
                            </template>
                        </b-form-select>

                    </b-form-radio-group>

                </b-form-group>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold"># of Graves the Monument is Going Over:</label>
                <b-form-input type="text" class="input-md mx-2 my-auto " :class="inPDF ? 'ml-1 input-border' : '' " name="per_graves_monument_going_over" size="sm" v-model="placement.graves_monument_going_over"></b-form-input>

                <label class="print-elm d-none ml-n5">{{placement.burial_type == 0 ? 'Traditional Burial' : placement.burial_type == 1 ? 'Cremation Burial' :
                    placement.burial_type == 2 ? 'Pre-Need' : ''}}</label>

                <b-form-group class="non-print-elm my-auto custom-radio-and-checkbox">
                    <b-form-radio-group name="burial_type" v-model="placement.burial_type">
                        <b-form-radio class="mx-2 text-nowrap" name="burial-type-radio" value="0" size="sm">Traditional Burial</b-form-radio>
                        <b-form-radio class="mx-2 text-nowrap" name="burial-type-radio" value="1" size="sm">Cremation Burial</b-form-radio>
                        <b-form-radio class="mx-2 text-nowrap" name="burial-type-radio" value="2" size="sm">Pre-Need</b-form-radio>
                    </b-form-radio-group>
                </b-form-group>

            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="non-print-elm font-weight-bold">Details on Burial (<u>if needed</u>):</label>
                <label class="print-elm my-0 font-weight-bold">Details on Burial (<u>if needed</u>):</label>
                <b-form-textarea
                    class="ml-2 py-0"
                    size="sm"
                    name="burial_details"
                    v-model="placement.burial_details"
                    no-resize
                ></b-form-textarea>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold">Is there currently any Monuments making in the Grave(s):</label>
                <label class="print-elm d-none ml-1">{{placement.currently_monuments_making_in_grave == 1 ? 'Yes' :
                    placement.currently_monuments_making_in_grave == 0 ? 'No' : ''}}</label>

                <b-form-group class="non-print-elm my-auto custom-radio-and-checkbox">
                    <b-form-radio-group name="current_monument_making" v-model="placement.currently_monuments_making_in_grave">
                        <b-form-radio class="mx-2 " name="current-monument-making-radio" value="1" size="sm">Yes</b-form-radio>
                        <b-form-radio class="mx-2 " name="current-monument-making-radio" value="0" size="sm">No</b-form-radio>
                    </b-form-radio-group>
                </b-form-group>

                <label class="non-print-elm font-weight-bold ml-auto">If Yes, fill out</label>
<!--                <router-link class="non-print-elm btn btn-info custom-infobtn-text custom-infobtn-toolbar mx-1 px-2" :to="'/monument-work-order/' + formFields.id">Work Order</router-link>-->
                <a class="non-print-elm btn btn-info custom-infobtn-text custom-infobtn-toolbar mx-1 px-2"  href="javascript:void(0)" @click="saveInstallForm(formFields.id)">Work Order</a>
            </div>
        </div>

        <div class="custom-row">
            <div>
                <img src="/images/installation-image.png">
            </div>
            <div class="d-block text-center">
                <label class="font-weight-bold">*Special Notes:</label>
                <b-form-textarea
                    class="custom-height-textarea"
                    :class="inPDF ? 'custom-overflowHiden' : '' "
                    size="sm"
                    name="special_notes:"
                    v-model="placement.special_notes"
                    @keyup="keyMonitor"
                    no-resize
                ></b-form-textarea>
            </div>

        </div>
        <div class="custom-row mt-5">
            <div>
                <label class="font-weight-bold">Date:</label>
                <label class="print-elm d-none" :class="inPDF ? 'ml-2' : '' ">{{ changeDateFormat(placement.placement_date) }}</label>
                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="non-print-elm mx-2 input-date" size="sm" placeholder="" v-model="placement.placement_date"
                                   today-button
                                   reset-button
                                   close-button
                                   locale="en">
                </b-form-datepicker>
            </div>
            <div>
                <label class="font-weight-bold ml-auto">Signature:</label>
                <label class="print-elm d-none input-lg">{{placement.signature}}</label>
                <b-form-input type="text" class="non-print-elm input-lg ml-2" name="signature" size="sm" v-model="placement.signature"></b-form-input>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold ml-auto" style="white-space: pre-line !important;">I understand that I am not to be
                    present at the time of install</label>
            </div>
        </div>

        <div class="custom-row my-5">
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
import {deleteRecord} from "../../../../helpers/axios";

export default {
    name: "Step-2",
    props: ['formFields','inPDF'],
    computed:{
        placement(){
            if (this.formFields.order_installation.placement == null){
                this.formFields.order_installation.placement = {id:0};
            }
            return this.formFields.order_installation.placement;
        },
    },
    data() {
        return {
            dimensionList:[
                {value:'North', text:'North'},
                {value:'South', text:'South'},
                {value:'East', text:'East'},
                {value:'West', text:'West'},
            ],
            textCount: 10,


        }
    },
    created() {
        if(!this.$props.inPDF)
            eventBus.$on(event.SAVE_ORDER_INSTALLATION_STEP2, this.storeStep);
    },
    beforeDestroy() {
        if(!this.$props.inPDF)
            eventBus.$off(event.SAVE_ORDER_INSTALLATION_STEP2);

    },
    methods:{
        storeStep(){
            console.log('step-2');
            eventBus.$emit(event.SAVE_ORDER_INSTALLATION, this.formFields);
        },
        changeDateFormat: function(value){
            return this.$store.getters.changeDateFormat(value);
        },
        saveInstallForm: function(id){
            if (confirm("Do you want to save changes?")){
                eventBus.$emit(event.SAVE_ORDER_INSTALLATION_STEP2);
                setTimeout( () => this.$router.push('/monument-work-order/'+id), 1000);
            }else{
                this.$router.push('/monument-work-order/'+id);
            }
        },
        keyMonitor: function (event){
            /*let key = event.keyCode || event.charCode;

            if (key == 8 ){
                return
            }
                if (this.placement.special_notes){
                    let abc= this.placement.special_notes.trim(this.placement.special_notes.replace(/ +(?= )/g,'')).split(' ').length;
                    if (abc > 10){
                        event.preventDefault();
                    }
                }else{
                    console.log("itis empty");
                }*/
        } ,
    }


};
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
    .custom-row div input,select,.input-date{
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
    .custom-height-textarea{
        height: 100%;
    }
    .custom-overflowHiden{
        overflow: hidden !important;
        height: 400px !important;
    }
    .custom-row div .input-border{
        border: none !important;
    }
   /* .print-elm{
        display: none;
    }

    .printing .form-content{
        width: 100%;
    }
    .printing label, .printing input, .printing textarea{
        font-size: 1.3rem;
    }
    .printing h5, .printing h3{
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
