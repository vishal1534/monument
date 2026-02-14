<template>
    <div>
        <div class="form-content" style="page-break-after: always;">
            <div class="custom-row border rounded">

                <div class="d-block border-right px-1">
                    <label class="font-weight-bold">Date:</label>
                    <label class="d-block">{{ changeDateFormat(formFields.date) }}</label>
                </div>
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
                </div>
            </div>
            <div class="custom-row">
                <div>
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
                </div>
                <div>
                    <label class="font-weight-bold">Date:</label>
                    <label class="print-elm ml-2">{{ changeDateFormat(formFields.order_installation.foundation_date) }}</label>
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
                </div>
                <div>
                    <label class="font-weight-bold">Date:</label>
                    <label class="print-elm ml-2">{{ changeDateFormat(formFields.order_installation.installation_date) }}</label>
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
                </div>

                <div class="">
                    <label class="font-weight-bold my-auto print-elm">Signature:</label>
                    <b-form-input type="text" class="input-lg mx-2" name="signature" size="sm" v-model="formFields.order_installation.signature"></b-form-input>
                </div>
            </div>
        </div>


        <div class="form-content" style="page-break-after: always;">
            <div class="custom-row">
                <div>
                    <h5 class="mx-auto text-purple">PLACEMENT</h5>
                </div>
            </div>
            <div class="custom-row">
                <div>
                    <label class="font-weight-bold px-0 col-3 mr-n4">The <span class="text-red">Female</span> is buried in the</label>

                    <label class="print-elm d-none mx-2 ml-n2">{{placement.female_buried_direction ? placement.female_buried_direction.toUpperCase() : ''}}</label>
                    <label class="font-weight-bold">Grave</label>
                </div>
            </div>
            <div class="custom-row">
                <div>
                    <label class="font-weight-bold px-0 col-3 mr-n4">The <span class="text-red">Male</span> is buried in the</label>

                    <label class="print-elm d-none mx-2 ml-n4" :class="inPDF ? '' : '' ">{{placement.male_buried_direction ? placement.male_buried_direction.toUpperCase() : ''}}</label>
                    <label class="font-weight-bold">Grave</label>
                </div>
            </div>
            <div class="custom-row">
                <div>
                    <label class="font-weight-bold">The Names on the Monument Should Face:</label>
                    <label class="print-elm d-none" :class="inPDF ? 'ml-2' : '' ">{{placement.name_should_face == 1 ? 'Away from the Grave' :
                        placement.name_should_face == 0 ? 'The Grave' : '' }}</label>
                    <label class="print-elm d-none" :class="inPDF ? 'ml-2' : '' ">{{placement.face_dimension}}</label>
                </div>
            </div>
            <div class="custom-row">
                <div>
                    <label class="font-weight-bold"># of Graves the Monument is Going Over:</label>
                    <b-form-input type="text" class="input-md mx-2 my-auto " :class="inPDF ? 'ml-1 input-border' : '' " name="per_graves_monument_going_over" size="sm" v-model="placement.graves_monument_going_over"></b-form-input>
                    <label class="print-elm d-none ml-n5">{{placement.burial_type == 0 ? 'Traditional Burial' : placement.burial_type == 1 ? 'Cremation Burial' :
                        placement.burial_type == 2 ? 'Pre-Need' : ''}}</label>
                </div>
            </div>
            <div class="custom-row">
                <div>
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
                        no-resize
                    ></b-form-textarea>
                </div>

            </div>
            <div class="custom-row mt-5">
                <div>
                    <label class="font-weight-bold">Date:</label>
                    <label class="print-elm d-none" :class="inPDF ? 'ml-2' : '' ">{{ changeDateFormat(placement.placement_date) }}</label>
                </div>
                <div>
                    <label class="font-weight-bold ml-auto">Signature:</label>
                    <label class="print-elm d-none input-lg">{{placement.signature}}</label>
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
                </div>
            </div>
            <div class="custom-row">
                <div>
                    <label class="font-weight-bold">** Is PLACEMENT different then above:</label>
                    <label class="print-elm ml-2">{{cemeteryConfirmation.different_placement == 1 ? 'Yes':
                        cemeteryConfirmation.different_placement == 0 ? 'No' : '' }}</label>
                </div>
            </div>
            <div class="custom-row">

                <div>
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
                </div>
            </div>
            <div class="custom-row">
                <div>
                    <label class="font-weight-bold">** Is FACING different then above:</label>
                    <label class="print-elm ml-2">{{cemeteryConfirmation.different_facing == 1 ? 'Yes' :
                        cemeteryConfirmation.different_facing == 0 ? 'No' : ''}}</label>
                </div>
            </div>
            <div class="custom-row my-2">

                <div>
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
                </div>
            </div>
            <div class="custom-row">
                <div>
                    <label class="font-weight-bold col-3 px-0">Has the Grave been flagged:</label>
                    <label class="print-elm ml-n4">{{formFields.order_installation.grave_flagged == 1 ? 'Yes' :
                        formFields.order_installation.grave_flagged == 0 ? 'No' : ''}}</label>
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
    </div>
</template>

<script>

    export default {
        name: "Installation-PDF",
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
            },
            placement(){
                if (this.formFields.order_installation.placement == null){
                    this.formFields.order_installation.placement = {id:0};
                }
                return this.formFields.order_installation.placement;
            },
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
            },
        },
        data(){
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
        },
        beforeDestroy() {
        },
        methods:{
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
        }
    }
</script>

<style scoped>
    .form-content{
        margin: 0 auto;
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
    .custom-row div input,select,.input-date{
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
</style>
