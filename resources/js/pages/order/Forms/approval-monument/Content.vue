<template>

    <div>
        <h5 class="mx-2 my-1 custom-form-heading non-print-elm">Approval Monument Form</h5>
        <div class="d-flex non-print-elm justify-content-center bg-toolbar my-2 p-1">
            <button type="button" class="btn-info mx-1 px-4 w-auto custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                Save<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
            </button>
            <router-link v-if="production_id != undefined"class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/productions/' +production_id">Cancel</router-link>
            <router-link v-else class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/orders/' +order_id">Cancel</router-link>

        </div>

        <div class="row">
            <div class="col-md-12">

                <div v-bind:class="[alertClasses, 'd-flex non-print-elm justify-content-center m-auto p-1 w-50']">{{alertMessage}}</div>

                <form class="bg-white rounded mx-2 mb-2 p-3">

                    <div class="form-content">
                        <div class="approval-monument-row border rounded">

                            <div class="d-block border-right px-1 pt-1 my-0">
                                <label class="font-weight-bold">Date:</label><br>
                                <label>{{formFields.order_date}}</label>
                            </div>
                            <div class="d-block border-right px-1 pt-1 my-0">
                                <label class="font-weight-bold">Day:</label><br>
                                <label>{{getDayOfWeek(formFields.order_date)}}</label>
                            </div>
                            <div class="d-block border-right px-1 pt-1 my-0">
                                <label class="font-weight-bold">TABLET:</label>
                                <label class="d-block">#210</label>
                            </div>
                            <div class="d-block px-1">
                                <label class="font-weight-bold">DESIGN FILE NAME:</label>
                                <label class="d-block">WILSON-7899</label>
                            </div>
                        </div>

                        <div class="approval-monument-row my-2 non-print-elm">
                            <div class="d-block col-8 mr-3">

                                <div class="my-2 mt-5">
                                    <label class="font-weight-bold col-2 my-auto p-0 ml-n2">Upload Front:</label>
                                    <b-form-file
                                            class="mx-2"
                                            size="sm"
                                            ref="inputFront"
                                            placeholder="No Chosen File"
                                            drop-placeholder="Drop file here..."
                                            browse-text="Choose File"
                                            v-on:change="previewImageFront"
                                    ></b-form-file>
                                </div>

                            </div>
                            <div class="justify-content-end">
                                <img class="ml-2 border p-1 rounded product-image" height=150 :src="formFields.imagefront" />
                            </div>
                        </div>

                        <div class="approval-monument-row my-2 non-print-elm">
                            <div class=" d-block col-8 mr-3">

                                <div class="my-2 mt-5">
                                    <label class="font-weight-bold col-2 my-auto p-0 ml-n2">Upload Back:</label>
                                    <b-form-file
                                            class="mx-2"
                                            size="sm"
                                            ref="inputBack"
                                            placeholder="No Chosen File"
                                            drop-placeholder="Drop file here..."
                                            browse-text="Choose File"
                                            v-on:change="previewImageBack"
                                    ></b-form-file>
                                </div>

                            </div>
                            <div class="justify-content-end">
                                <img class="ml-2 border p-1 rounded product-image" height=150 :src="formFields.imageback" />
                            </div>
                        </div>
                        <div class=" approval-monument-row d-block print-elm">
                            <div class="justify-content-center">
                                <label class="font-weight-bold text-center">FRONT</label>
                            </div>
                            <div class="justify-content-center d-block">
                                <img class="ml-0 product-print p-5" :src="formFields.imagefront" />
                            </div>
                        </div>
                        <div class="approval-monument-row mx-5 mt-5">
                            <div class="flex-grow-1 custom-div-size2">
                                <label class="font-weight-bold">Approved By:</label>
                                <label class="print-elm">{{formFields.approved_by}}</label>
                                <b-form-input
                                        class="ml-2 non-print-elm"
                                        size="sm"
                                        v-model="formFields.approved_by"
                                ></b-form-input>
                            </div>
                            <div class="flex-grow-1 custom-div-size1">
                                <label class="font-weight-bold">Date:</label>
                                <label class="print-elm">{{formFields.date}}</label>
                                <b-form-datepicker  :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" class="my-auto input-date non-print-elm" size="sm" name="date" placeholder="" v-model="formFields.date"
                                                    today-button
                                                    reset-button
                                                    close-button
                                                    locale="en">

                                </b-form-datepicker>
                            </div>

                        </div>
                        <div class="d-block text-center font-weight-bold my-3" style="font-family: Roboto;">
                            <label class="d-block m-0">BY SIGNING THE APPROVAL I ASSUME COMPLETE RESPONSIBILITY FOR LAYOUT/SPELLING/DATES.</label>
                            <label class="d-block m-0">I ALSO AGREE THAT AFTER SIGNING THE APPROVAL, NO FURTHER CHANGES WILL BE MADE & IF </label>
                            <label class="d-block m-0">SOMETHING IS INCORRECT UPON COMPLETION OF THE MONUMENT I AM RESPONSIBLE</label>
                            <label class="d-block m-0">FOR THE COST TO CORRECT IT.</label>
                        </div>
                        <hr class="border my-3 non-print-elm">
                        <hr class="print-hr my-3 print-elm">
                        <div class="approval-monument-row my-3">
                            <label class="font-weight-bold">Size & Description:</label>
                            <label class="col-5">Die: 3-0x0-6x1-8, SERP TOP, P2, BRP</label>
                            <label class="col-5">Base: 4-0x1-0x0-6 POL TOP, BRP</label>
                        </div>
                        <div class="approval-monument-row my-n2">
                                <label class="font-weight-bold mt-1">Granite Color:</label>
                                <label class="print-elm ml-3 mt-1">{{printGranite(formFields.granite_color)}}</label>
                                <b-form-group class="m-0 ml-2 my-auto custom-radio-and-checkbox flex-grow-1 non-print-elm">
                                    <b-form-radio-group   class="my-n1" v-model="formFields.granite_color">
                                        <b-form-radio  :value=0>GRAY</b-form-radio>
                                        <b-form-radio  :value=1>MEL.BLK.</b-form-radio>
                                        <b-form-radio  :value=2>D.BROWN</b-form-radio>
                                        <b-form-radio  :value=3>M.ROSE</b-form-radio>
                                        <b-form-radio  :value=4>BAHAMA BLUE</b-form-radio>
                                    </b-form-radio-group>
                                    <b-form-radio-group   class="my-n1" v-model="formFields.granite_color">
                                        <b-form-radio  :value=5>BLUE PEARL</b-form-radio>
                                        <b-form-radio  class="radio-margin":value=6>INDIA RED</b-form-radio>
                                        <b-form-radio  :value=7>OTHER</b-form-radio>
                                    </b-form-radio-group>
                                </b-form-group>

                        </div>
                        <div class="approval-monument-row my-3">
                            <label class="font-weight-bold mt-1">Carving Style:</label>
                            <label class="print-elm ml-3 mt-1">{{printCarving(formFields.carving_style)}}</label>
                            <b-form-group class="m-0 ml-2 my-auto custom-radio-and-checkbox flex-grow-1 non-print-elm">
                                <b-form-radio-group   class="my-n1" v-model="formFields.carving_style">
                                    <b-form-radio  :value=0>FLAT CURVE</b-form-radio>
                                    <b-form-radio  :value=1>SHAPE CURVE</b-form-radio>
                                    <b-form-radio  :value=2>LASER ETCH</b-form-radio>
                                    <b-form-radio  :value=3>HAND ETCH</b-form-radio>
                                </b-form-radio-group>
                            </b-form-group>
                        </div>
                        <div class="approval-monument-row my-n2">
                            <label class="font-weight-bold mt-1">Letter Carving Style:</label>
                            <label class="print-elm ml-3 mt-1">{{printLetter(formFields.letter_style)}} {{formFields.letter_style_other}}</label>
                            <b-form-group class="m-0 ml-2 my-auto custom-radio-and-checkbox flex-grow-1 non-print-elm">
                                <b-form-radio-group   class="my-n1" v-model="formFields.letter_style">
                                    <b-form-radio  class="mr-n5":value=0>V-CUT</b-form-radio>
                                    <b-form-radio  class="mx-n5":value=1>SKIN SUNK</b-form-radio>
                                    <b-form-radio  class="mx-n2":value=2>FROSTED OUTLINED</b-form-radio>
                                    <b-form-radio  class="mx-n1" :value=3>OTHER <b-form-input type="text" class="input-lg letter-field-margin" size="sm" v-model="formFields.letter_style_other"></b-form-input>
                                    </b-form-radio>
                                    </b-form-radio-group>
                            </b-form-group>
                        </div>
                        <div class="approval-monument-row my-2">
                            <label class="font-weight-bold mt-3 non-print-elm">Lithochrome Darkening or<br> Whitening Agent:</label>
                            <label class="print-elm font-weight-bold mt-3">Lithochrome Darkening or Whitening Agent:</label>
                            <label class="print-elm ml-3 mt-3">{{printLithochrome(formFields.lithochrome_agent)}}</label>
                            <b-form-group class="m-0 ml-2 my-auto custom-radio-and-checkbox flex-grow-1 non-print-elm">
                                <b-form-radio-group   class="my-n1" v-model="formFields.lithochrome_agent">
                                    <b-form-radio  :value=0>BLACK</b-form-radio>
                                    <b-form-radio  :value=1>LT. HI-LITE</b-form-radio>
                                    <b-form-radio  :value=2>MED HI-LITE</b-form-radio>
                                    <b-form-radio  :value=3>HVY. HI-LITE</b-form-radio>
                                </b-form-radio-group>
                            </b-form-group>

                        </div>

                        <div class="print-elm mt-5" style="page-break-before: always">
                            <div class="approval-monument-row justify-content-center">
                                <h3>APPROVAL MONUMENT FORM</h3>
                            </div>
                            <div class="approval-monument-row border rounded">

                                <div class="d-block border-right px-1 pt-1 my-0">
                                    <label class="font-weight-bold">Date:</label><br>
                                    <label>{{formFields.order_date}}</label>
                                </div>
                                <div class="d-block border-right px-1 pt-1 my-0">
                                    <label class="font-weight-bold">Day:</label><br>
                                    <label>{{getDayOfWeek(formFields.order_date)}}</label>
                                </div>
                                <div class="d-block border-right px-1 pt-1 my-0">
                                    <label class="font-weight-bold">TABLET:</label>
                                    <label class="d-block">#210</label>
                                </div>
                                <div class="d-block px-1">
                                    <label class="font-weight-bold">DESIGN FILE NAME:</label>
                                    <label class="d-block">WILSON-7899</label>
                                </div>
                            </div>
                            <div class="approval-monument-row d-block">
                                <div class="justify-content-center">
                                    <label class="font-weight-bold text-center">BACK</label>
                                </div>
                                <img class="ml-0 product-print p-5" :src="formFields.imageback" />
                            </div>
                            <div class="approval-monument-row mx-5 mt-5">
                                <div class="flex-grow-1 custom-div-size2">
                                    <label class="font-weight-bold">Approved By:</label>
                                    <label>{{formFields.approved_by}}</label>
                                </div>
                                <div class="flex-grow-1 custom-div-size1">
                                    <label class="font-weight-bold">Date:</label>
                                    <label>{{formFields.date}}</label>
                                </div>

                            </div>
                            <div class="d-block text-center font-weight-bold my-3" style="font-family: Roboto;">
                                <label class="d-block m-0">BY SIGNING THE APPROVAL I ASSUME COMPLETE RESPONSIBILITY FOR LAYOUT/SPELLING/DATES.</label>
                                <label class="d-block m-0">I ALSO AGREE THAT AFTER SIGNING THE APPROVAL, NO FURTHER CHANGES WILL BE MADE & IF </label>
                                <label class="d-block m-0">SOMETHING IS INCORRECT UPON COMPLETION OF THE MONUMENT I AM RESPONSIBLE</label>
                                <label class="d-block m-0">FOR THE COST TO CORRECT IT.</label>
                            </div>
                            <hr class="print-hr my-3">
                            <div class="approval-monument-row my-3">
                                <label class="font-weight-bold">Size & Description:</label>
                                <label class="col-5">Die: 3-0x0-6x1-8, SERP TOP, P2, BRP</label>
                                <label class="col-5">Base: 4-0x1-0x0-6 POL TOP, BRP</label>
                            </div>
                            <div class="approval-monument-row my-n2">
                                <label class="font-weight-bold mt-1">Granite Color:</label>
                                <label class="ml-3 mt-1">{{printGranite(formFields.granite_color)}}</label>
                            </div>
                            <div class="approval-monument-row my-3">
                                <label class="font-weight-bold mt-1">Carving Style:</label>
                                <label class="ml-3 mt-1">{{printCarving(formFields.carving_style)}}</label>
                            </div>
                            <div class="approval-monument-row my-n2">
                                <label class="font-weight-bold mt-1">Letter Carving Style:</label>
                                <label class="ml-3 mt-1">{{printLetter(formFields.letter_style)}} {{formFields.letter_style_other}}</label>
                            </div>
                            <div class="approval-monument-row my-2">
                                <label class="font-weight-bold mt-3">Lithochrome Darkening or Whitening Agent:</label>
                                <label class="ml-3 mt-3">{{printLithochrome(formFields.lithochrome_agent)}}</label>
                            </div>
                        </div>

                        <div class="approval-monument-row non-print-elm ml-n1">
                            <div>
                                <button type="button" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="printPDF">Print Preview</button>
                                <button type="button" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                                    Save<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                                </button>
                                <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/orders/'+formFields.order_id">Cancel</router-link>
                            </div>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

</template>

<script>
import Vue from 'vue';
import {saveRecord, fetchRecord} from "../../../../helpers/axios";
import {event, eventBus} from "../../../../event-bus/event-bus";

export default {
    name: "Content",
    props: ['formFields','production_id','order_id'],
    computed:{
        alertClasses: function () {
            return {
                alert: true,
                'alert-success': this.successResponse,
                'alert-danger': this.errorResponse,
                'd-none': this.hideAlert
            }
        },
        imageFront(){
            this.imagefront =  this.formFields.imagefront;

            console.log(this.formFields.imagefront);
            return this.formFields.imagefront;
        },
        imageBack(){
            if(this.imageback == null || this.imageback == this.imageDefault)
                this.imageback = this.formFields.image_back ? this.imagePath + this.formFields.image_back : this.imageDefault;

            return this.imageback;
        },
    },
    data(){
        return {
            imagefront:null,
            //imageback:null,
            imagePath:'images/approval-monument/',
            imageDefault: 'images/default-image.jpg',
            axiosParams:{module: 'order/approvalMonument'},
            alertMessage:'',
            hideAlert:true,
            successResponse: false,
            errorResponse: false,
            saveDisabled:false,
        }
    },
    methods:{
        save(){
            this.saveDisabled = true; //Disabling save button
            let data = this.formFields;
            let formData = new FormData();
            formData.append('image_front', this.image_front);
            formData.append('image_back', this.image_back);
            formData.append('data',JSON.stringify(data));

            saveRecord(this.axiosParams, formData, (response) => {
                if (response.data.errorInfo){
                    this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                    this.errorResponse = true;
                    this.handleAlert();
                }
                else{
                    let status = this.formFields.id ? 'Updated': 'Added';
                    this.alertMessage = `Record Successfully ${status}`;
                    this.successResponse = true;
                    this.handleAlert();
                }
            })
        },
        previewImageFront: function(event) {
            let input = event.target;
            let  FileSize = input.files[0].size / 1024 / 1024; // in MiB
            if (FileSize > 2 ||input.files[0].type.indexOf("image") == -1) {
                alert('Invalid image type or File size exceeds 2 MB');
                this.$refs['inputFront'].reset();
                this.formFields.imagefront = this.imageDefault;
                //this.$set(this.formFields,"imagefront",this.imageDefault);
                this.$forceUpdate();
                return false;
            }
            else {
                if (input.files && input.files[0]) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.$set(this.formFields, 'imagefront', e.target.result)
                        this.formFields.imagefront = e.target.result;
                        //this.$set(this.formFields,"imagefront", e.target.result);
                        this.$forceUpdate();
                        this.image_front = event.target.files[0];
                    }
                    reader.readAsDataURL(input.files[0]);
                }

            }
        },
        previewImageBack: function(event) {
            console.log(type);
            let input = event.target;
            let  FileSize = input.files[0].size / 1024 / 1024; // in MiB
            if (FileSize > 2 ||input.files[0].type.indexOf("image") == -1) {
                alert('Invalid image type or File size exceeds 2 MB');
                this.$refs['inputBack'].reset();
                this.formFields.imageback= this.imageDefault;
                return false;
            }
            else {
                if (input.files && input.files[0]) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        //Vue.set(this.formFields, 'imageback', e.target.result)
                        this.formFields.imageback = e.target.result;
                        this.image_back = event.target.files[0];
                    }
                    reader.readAsDataURL(input.files[0]);
                }

            }
        },
        getDayOfWeek:function(date) {
            if(date != null){
                const dayOfWeek = new Date(date).getDay();
                return isNaN(dayOfWeek) ? null :
                    ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
            }
        },
        printPDF(){
            eventBus.$emit(event.PRINT_PDF)
        },
        printGranite(val) {
            if(val == 0)
                return 'GRAY'
            else if(val == 1)
                return 'ML.BLK'
            else if(val == 2)
                return 'D.BROWN'
            else if(val == 3)
                return 'M.ROSE'
            else if(val == 4)
                return 'BAHAMA BLUE'
            else if(val == 5)
                return 'BLUE PEARL'
            else if(val == 6)
                return 'INDIA RED'
            else if(val == 7)
                return 'OTHER'
            else
                return ''
        },
        printCarving(val) {
            if(val == 0)
                return 'FLAT CURVE'
            else if(val == 1)
                return 'SHAPE CURVE'
            else if(val == 2)
                return 'LASER ETCH'
            else if(val == 3)
                return 'HAND ETCH'
            else
                return ''
        },
        printLetter(val) {
            if(val == 0)
                return 'V-CUT'
            else if(val == 1)
                return 'SKIN SUNK'
            else if(val == 2)
                return 'FROSTED OUTLINED'
            else if(val == 3)
                return 'OTHER'
            else
                return ''
        },
        printLithochrome(val) {
            if(val == 0)
                return 'BLACK'
            else if(val == 1)
                return 'LT.HI-LITE'
            else if(val == 2)
                return 'MED-HI-LITE'
            else if(val == 3)
                return 'HVY.HI-LITE'
            else
                return ''
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
    }

}
</script>

<style scoped>
.form-content{
    margin: 0 auto;
    width: 45rem;
}
.approval-monument-row
{
    display: flex;
    padding: 0;
}
.approval-monument-row div
{
    display: flex;
    margin: 0.3rem 0;
    width: 100%;
}
.approval-monument-row div label{
    margin: auto 0.5rem;
    white-space: nowrap !important;
}
.approval-monument-row div input,textarea,.input-date{
    border: 1px solid #c4c4c4 !important;
    margin: auto;
    margin-right: 0;
    font-size: 12px !important;
}
.approval-monument-row div input,.input-date{
    height:1.5rem;
}
.product-image{
    min-width: 13.5rem !important;
    max-width: 13.5rem !important;
}
.product-print{
    width: 100% !important;
    height: 50rem !important;
}
.print-hr{
     border: 1px solid #000 !important;
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
    width: 2.2rem;
    height: 1.4rem;
}
.letter-field-margin{
    margin-left: 3rem !important;
    margin-top: -1.5rem !important;
}

.input-date{
    font-size: .6rem;
}
.custom-div-size1{
    width:19rem !important;
}
.custom-div-size2{
    width:25rem !important;
}
.custom-dangerbtn-text{
    width: 89px !important;
}
.radio-margin{
    margin-left: -18rem !important;
    margin-right: -18rem !important;
}
.custom-print-button{
    font-size: 12px;
    background: #007BFF;
    box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.25);
    border-radius: 5px
}
.custom-title{
    font-weight: 600;
    font-size: 13px;
    line-height: 15px;
    text-align: center;
    letter-spacing: 0.02em;
}
/*.printing .form-content{
    width: 100%;
}
.printing label, .printing input, .printing textarea{
    font-size: 1.2rem;
}
.printing h5, .printing h3{
    font-size: 2rem;
}
.printing input, .printing textarea{
    border-color: transparent !important;
    background: transparent !important;
    pointer-events: none;
    height: auto;
}
.printing .non-print-elm{
    display: none !important;
}
.printing .print-elm{
    display: block !important;
}
.print-elm{
    display: none !important;
}*/
</style>
