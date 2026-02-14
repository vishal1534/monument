<template>

    <div class="form-content">

        <div class="custom-row border rounded">

            <div class="d-block border-right px-1">
                <label class="font-weight-bold">Date:</label>
                <label class="d-block">{{ changeDateFormat(formFields.date) }}</label>
            </div>
            <!--<div class="d-block border-right px-1">
                <label class="font-weight-bold">Day:</label>
                <label class="d-block">{{getDayOfWeek(formFields.date)}}</label>
            </div>
            <div class="d-block border-right px-1">
                <label class="font-weight-bold">Customer Name:</label>
                <label class="d-block">{{formFields.company.name}}</label>
            </div>-->
            <div class="d-block border-right px-1">
                <label class="font-weight-bold">Last Name on Stone:</label>
                <label class="d-block">{{formFields.family.name_on_stone}}</label>
            </div>
            <div class="d-block px-1">
                <label class="font-weight-bold">Invoice No.</label>
                <label class="d-block">{{ formFields.invoice.invoice_number }}</label>
            </div>
        </div>

        <div class="custom-row">
            <div>
                <h6 class="mx-1 my-1 text-purple">MONUMENT INFORMATION</h6>
            </div>
        </div>
        <div class="custom-row">
            <div class="w-75 my-0">
                <label class="font-weight-bold">Last Name on Monument</label>
                <div class="bg-yellow text-dark rounded p-1 mx-2">
                    <label>{{formFields.family.name_on_stone}}</label>
                </div>
            </div>
        </div>
        <div v-if="false" class="custom-row">
            <ul class="w-100">
                <li>
                    <div>
                        <label class="font-weight-bold">Tablet/Slant/Grasser (Size & Color):</label>
                        <b-form-input type="text" name="tablet_size_color" class="input-xl" size="sm" v-model="formFields.order_installation.monument.tablet_slant_grasser"></b-form-input>
                    </div>
                </li>
                <li>
                    <div>
                        <label class="font-weight-bold">Base (Size & Color):</label>
                        <b-form-input type="text" name="base_size_color" class="input-xl mr-0" size="sm" v-model="formFields.order_installation.monument.base"></b-form-input>
                    </div>
                </li>
                <li>
                    <div>
                        <label class="font-weight-bold">Apron/Cap (Size & Color):</label>
                        <b-form-input type="text" name="apron_size_color" class="input-xl mr-0" size="sm" v-model="formFields.order_installation.monument.apron_cap"></b-form-input>
                    </div>
                </li>
                <li>
                    <div>
                        <label class="font-weight-bold">Vases (Size, Color & Qty):</label>
                        <b-form-input type="text" name="vases_size_color" class="input-xl mr-0" size="sm" v-model="formFields.order_installation.monument.vases"></b-form-input>
                    </div>
                </li>
                <li>
                    <div>
                        <label class="font-weight-bold">Accessories:</label>
                        <b-form-input type="text" name="accessories" class="input-xl mr-0" size="sm" v-model="formFields.order_installation.monument.accessories"></b-form-input>
                    </div>
                </li>
            </ul>

        </div>
        <div class="custom-row d-block">
            <template v-if="formFields.products.length > 0">
                <template v-for="(prod, key) of formFields.products">
                    <div class="mb-2">
                        <label class="font-weight-bold">Item {{key + 1}}:</label>
                        <label class="mx-2"> #{{customizeProduct(prod)}}</label>
                    </div>
                </template>
            </template>
            <template v-else>
                <div>
                    <label>No products found</label>
                </div>
            </template>

        </div>

        <hr class="border">

        <div class="custom-row">
            <div>
                <h6 class="mx-1 my-1 text-purple">CEMETERY INFORMATION</h6>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold col-2 m-0 px-1">Cemetery Name:</label>
                <b-form-input type="text" class="" size="sm" :value="formFields.cemetery.company" readonly></b-form-input>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold col-2 m-0 px-1">Address:</label>
                <b-form-input type="text" class="" size="sm" :value="cemeteryAddress" readonly></b-form-input>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold col-2 m-0 px-1">Latitude/Longitude:</label>
                <b-form-input type="text" class="w-25 m-0" size="sm" :value="gpsCoords[0]" readonly></b-form-input>
                <label class="font-weight-bold"> <span class="mx-1">,</span> &nbsp; (-)</label>
                <b-form-input type="text" class="w-25 m-0" size="sm" :value="gpsCoords[1]" readonly></b-form-input>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold col-2 m-0 px-1">City:</label>
                <b-form-input type="text" class="input-md w-auto m-0 my-auto" size="sm" :value="formFields.cemetery.city.city_title" readonly></b-form-input>

                <label class="font-weight-bold ml-5 mr-2">State:</label>
                <b-form-input type="text" class="input-md m-0 my-auto" size="sm" :value="formFields.cemetery.state.state_title" readonly></b-form-input>

                <label class="font-weight-bold ml-5 mr-2">Zip:</label>
                <b-form-input type="text" class="input-md m-0 my-auto"  size="sm" :value="formFields.cemetery.zip_code" readonly></b-form-input>

            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold col-2 m-0 px-1">Contact:</label>
                <b-form-input type="text" class="input-xl mr-5" size="sm" :value="formFields.cemetery.contact_first_name  ? formFields.cemetery.contact_first_name : ' ' +' '+ formFields.cemetery.contact_last_name ? formFields.cemetery.contact_last_name :''" readonly></b-form-input>

                <label class="font-weight-bold" >Phone #:</label>
                <b-form-input type="text" class="input-xl ml-2" :class="inPDF ? 'custom-marginRight-input' : '' " size="sm" :value="formFields.cemetery.business_phone" readonly></b-form-input>
            </div>
        </div>

        <hr class="border">

        <div class="custom-row">
            <div>
                <h6 class="mx-auto my-1 text-purple">INSTALLATION / FLAGGING INFORMATION</h6>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold">Block #:</label>
                <b-form-input type="text" class="mx-2" name="installation_block_number" size="sm" v-model="flagging.block_number"></b-form-input>

                <label class="font-weight-bold">Lot #:</label>
                <b-form-input type="text" class="mx-2" name="installation_lot_number" size="sm" v-model="flagging.lot_number"></b-form-input>

                <label class="font-weight-bold">Section:</label>
                <b-form-input type="text" class="mx-2" name="installation_section" size="sm" v-model="flagging.section"></b-form-input>

                <label class="font-weight-bold">Plot/Grave(s) #:</label>
                <b-form-input type="text" class="ml-2" name="installation_grave_number" size="sm" v-model="flagging.plot_grave_number"></b-form-input>

            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="non-print-elm font-weight-bold">How is the Grave Marked Out:</label>
                <label class="print-elm font-weight-bold" style="margin: 0 !important;">How is the Grave Marked Out:</label>
                <b-form-textarea
                    class="py-0 ml-2 "
                    size="sm"
                    name="grave_marked_out"
                    v-model="formFields.cemetery.flagging_info"
                    no-resize
                ></b-form-textarea>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="non-print-elm font-weight-bold">Location of Grave(s):</label>
                <label class="print-elm font-weight-bold" style="margin: 0 !important;">Location of Grave(s):</label>
                <b-form-textarea
                    class="py-0 ml-2"
                    size="sm"
                    name="grave_location"
                    v-model="flagging.grave_location"
                    no-resize
                ></b-form-textarea>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold">Plot Close to the Road</label>
                <label class="print-elm"> : {{flagging.plot_close_to_road ? 'Yes' :
                    flagging.plot_close_to_road == 0 ? 'No' : ''}}</label>
                <b-form-group class="non-print-elm m-0 my-auto custom-radio-and-checkbox">
                    <b-form-radio-group name="plot_close_to_road" v-model="flagging.plot_close_to_road">
                        <b-form-radio class="mx-3" name="plot-close-to-road-radio" value="1" size="sm">Yes</b-form-radio>
                        <b-form-radio name="plot-close-to-road-radio" value="0" size="sm">No</b-form-radio>
                    </b-form-radio-group>
                </b-form-group>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="non-print-elm font-weight-bold">*Special Notes:</label>
                <label class="print-elm font-weight-bold" style="margin: 0 !important;">*Special Notes:</label>
                <b-form-textarea
                    class="py-0 ml-2"
                    size="sm"
                    name="special_notes"
                    v-model="flagging.special_notes"
                    no-resize
                ></b-form-textarea>
            </div>
        </div>

        <hr class="border">

        <div class="custom-row">
            <div>
                <h6 class="mx-auto my-1 text-purple">WORK COMPLETED BY / CEMETERY APPROVAL</h6>
            </div>
        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold">Foundation Person:</label>
                <b-form-input type="text" class="mx-2" name="foundation_person" size="sm" v-model="formFields.order_installation.foundation_person"></b-form-input>
            </div>
            <div>
                <label class="font-weight-bold">Foundation Complete:</label>
                <label class="print-elm ml-2">{{formFields.order_installation.foundation_complete ? 'Yes' :
                    formFields.order_installation.foundation_complete == 0 ? 'No' : '' }}</label>
                <b-form-group class="non-print-elm m-0 my-auto custom-radio-and-checkbox">
                    <b-form-radio-group name="foundation_complete" v-model="formFields.order_installation.foundation_complete">
                        <b-form-radio class="mx-2" name="foundation-complete-radio" value="1" size="sm">Yes</b-form-radio>
                        <b-form-radio name="foundation-complete-radio" value="0" size="sm">No</b-form-radio>
                    </b-form-radio-group>
                </b-form-group>
            </div>
            <div>
                <label class="font-weight-bold">Date:</label>
                <label class="print-elm ml-2">{{ changeDateFormat(formFields.order_installation.foundation_date) }}</label>
                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="non-print-elm input-date mx-2" size="sm" placeholder="" v-model="formFields.order_installation.foundation_date"
                                   today-button
                                   reset-button
                                   close-button
                                   locale="en">
                </b-form-datepicker>
            </div>
        </div>
        <div class="custom-row">

            <div>
                <label class="font-weight-bold mr-2">Installer Name:</label>
                <b-form-input type="text" class="ml-4 mr-2" name="installer_name" size="sm" v-model="formFields.order_installation.installer_name"></b-form-input>
            </div>
            <div>
                <label class="font-weight-bold">Installation Complete:</label>
                <label class="print-elm ml-2">{{formFields.order_installation.installation_complete ? 'Yes' :
                    formFields.order_installation.installation_complete == 0 ? 'No' : ''}}</label>
                <b-form-group class="non-print-elm m-0 my-auto custom-radio-and-checkbox">
                    <b-form-radio-group name="installation_complete" v-model="formFields.order_installation.installation_complete">
                        <b-form-radio class="mx-2" name="installation-complete-radio" value="1" size="sm">Yes</b-form-radio>
                        <b-form-radio name="installation-complete-radio" value="0" size="sm">No</b-form-radio>
                    </b-form-radio-group>
                </b-form-group>
            </div>
            <div>
                <label class="font-weight-bold">Date:</label>
                <label class="print-elm ml-2">{{ changeDateFormat(formFields.order_installation.installation_date) }}</label>
                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="non-print-elm input-date mx-2" size="sm" placeholder="" v-model="formFields.order_installation.installation_date"
                                   today-button
                                   reset-button
                                   close-button
                                   locale="en">
                </b-form-datepicker>
            </div>

        </div>
        <div class="custom-row">
            <div>
                <label class="font-weight-bold">I hereby certify that the install is complete and approved by the cemetery</label>
            </div>
        </div>
        <div class="custom-row">
            <div class="ml-4">
                <label class="font-weight-bold">Date:</label>
                <label class="print-elm mx-2">{{ changeDateFormat(formFields.order_installation.installation_complete_approved_date) }}</label>
                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="non-print-elm mx-2 input-date col-5" size="sm" placeholder="" v-model="formFields.order_installation.installation_complete_approved_date"
                                   today-button
                                   reset-button
                                   close-button
                                   locale="en">
                </b-form-datepicker>
            </div>

            <div class="">
                <label class="font-weight-bold my-auto non-print-elm">Signature:</label>
                <label class="font-weight-bold my-auto print-elm">Signature:</label>
                <b-form-input type="text" class="input-lg mx-2" name="signature" size="sm" v-model="formFields.order_installation.signature"></b-form-input>
            </div>
        </div>

    </div>

</template>

<script>
import {event, eventBus} from '../../../../event-bus/event-bus';

export default {
    name: "Step-1",
    props: ['formFields','inPDF'],
    computed:{

        flagging(){
            if (this.formFields.order_installation.flagging == null){
                this.formFields.order_installation.flagging = {id:0};
            }
            return this.formFields.order_installation.flagging;
        },
        gpsCoords(){
            let coords = ['',''];
            if(this.formFields.cemetery.gps && this.formFields.cemetery.gps.indexOf(',') > -1){
                coords = this.formFields.cemetery.gps.split(',');
            }
            return coords;
        },
        cemeteryAddress(){
            let street = this.formFields.cemetery.street? this.formFields.cemetery.street + ', ' : '' ;
            let city = this.formFields.cemetery.city.city_title ? this.formFields.cemetery.city.city_title + ', ' : '';
            let county = this.formFields.cemetery.county.county_title ? this.formFields.cemetery.county.county_title : '';
            return  street + city + county;
        },
        cemetery(){
            this.formFields.cemetery.street? this.formFields.cemetery.street: null ;
            this.formFields.cemetery.city.city_title ? this.formFields.cemetery.city.city_title : null;
            this.formFields.cemetery.county.county_title ? this.formFields.cemetery.county.county_title : null;
            //return  street + city + county;
        },
    },
    data(){
        return {
            }
        },
    created() {
        if(!this.$props.inPDF) {
            eventBus.$on(event.SAVE_ORDER_INSTALLATION_STEP1, this.storeStep);
        }
    },
    beforeDestroy() {
        if(!this.$props.inPDF) {
            eventBus.$off(event.SAVE_ORDER_INSTALLATION_STEP1);
        }
    },
    methods:{
        storeStep(){
            console.log('step-1');
            eventBus.$emit(event.SAVE_ORDER_INSTALLATION, this.formFields);
        },
        changeDateFormat: function(value){
            return this.$store.getters.changeDateFormat(value);
        },
        customizeProduct(product){
            let data = {number: 0, name: ''};

            if(product.monument && product.monument.length > 0){
                data.number = product.monument[0].product_number;
                data.name = product.monument[0].item_name;
            }
            else if(product.service && product.service.length > 0){
                data.number = product.service[0].product_number;
                data.name = product.service[0].item_name;
            }
            else if(product.simple && product.simple.length > 0){
                data.number = product.simple[0].product_number;
                data.name = product.simple[0].item_name;
            }
            else if(product.composite && product.composite.length > 0){
                data.number = product.composite[0].product_number;
                data.name = product.composite[0].item_name;
            }
            return data.number + " - "+ data.name;
        },
        getDayOfWeek:function(date) {
            if(date != null){
                const dayOfWeek = new Date(date).getDay();

                return isNaN(dayOfWeek) ? null :
                    ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
            }
        },
    }

    }
</script>

<style scoped>
    .form-content{
        margin: 0 auto;
        /*width: 40rem;*/
    }
    .custom-row
    {
        display: flex;
        padding: 0;
    }
    .custom-row div
    {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }
    .custom-row div label{
        margin: auto 0;
        white-space: nowrap !important;
    }
    .custom-row div input,.input-date{
        border: 1px solid #c4c4c4;
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
        width: 22rem;
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
        font-size: 0.7rem;
    }
    .custom-marginRight-input{
        margin-right: 50% !important;
    }
    /*.print-elm{*/
    /*    display: none;*/
    /*}*/
    /*.printing .form-content{*/
    /*    width: 100%;*/
    /*}*/
    /*.printing label, .printing input, .printing textarea{*/
    /*    font-size: 1.3rem;*/
    /*}*/
    /*.printing h6, .printing h3{*/
    /*    font-size: 1.5rem;*/
    /*}*/
    /*.printing input, .printing textarea{*/
    /*    border-color: transparent !important;*/
    /*    background: transparent !important;*/
    /*    pointer-events: none;*/
    /*    height: auto !important;*/
    /*}*/
    /*.printing .non-print-elm{*/
    /*    display: none !important;*/
    /*}*/
    /*.printing .print-elm{*/
    /*    display: block !important;*/
    /*    margin: auto .5rem;*/
    /*}*/
</style>
