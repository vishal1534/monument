<template>
    <div>
        <h5 class="mx-2 my-1 custom-form-heading non-print-elm">Approval Monument Form</h5>
        <div class="d-flex non-print-elm justify-content-center bg-toolbar my-2 p-1">
            <button :disabled="saveDisabled" @click="save" class="btn-info mx-1 px-4 w-auto custom-infobtn-toolbar custom-infobtn-text" type="button" v-if="formFields.id > 0 ? isUpdatePermitted : isCreatePermitted">
                {{ formFields.id ? 'Update' : 'Save' }}<span class="spinner-grow spinner-grow-sm ml-1" v-if="saveDisabled"></span>
            </button>
            <router-link :to="'/productions/' +production_id" class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" v-if="production_id != undefined">Cancel</router-link>
            <router-link :to="'/orders/' +id" class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" v-else>Cancel</router-link>
        </div>
        <PDF :title="'printApprovalMonument'">
            <div class="pdf-custom-margin-form" slot="header" v-for="(task, key) in uploadMoreFile">
                <div class="bg-white rounded mx-2 mb-2 p-3">
                    <div class="form-content" v-if="uploadMoreFile[key].printable">
                        <div class="print-elm mt-5">
                            <div class="approval-monument-row">
                                <div class="col-6">
                                    <img :src="'/images/approvalform-image.png'" class="ml-n3 mb-3 border"/>
                                </div>
                                <div class="col-6">
                                    <h3>APPROVAL MONUMENT FORM</h3>
                                </div>
                            </div>
                            <div class="approval-monument-row border rounded">
                                <div class="d-block border-right px-1 pt-1 my-0">
                                    <label class="font-weight-bold">Date:</label><br>
                                    <label>{{ changeDateFormat(formFields.order_date) }}</label>
                                </div>
                                <div class="d-block border-right px-1 pt-1 my-0">
                                    <label class="font-weight-bold">Product #:</label><br>
                                    <label> {{ formFields.product_numbers}}</label>
                                </div>
                                <div class="d-block px-1">
                                    <label class="font-weight-bold">DESIGN FILE NAME:</label>
                                    <label class="d-block">{{formFields.company_name}}-{{formFields.name_on_stone}}-{{formFields.invoice_no}}</label>
                                </div>
                            </div>
                            <div class="approval-monument-row d-block" :class="checkFileType(uploadMoreFile[key].name)?' ':' text-center'"
                                 >
                                <div class="justify-content-center">
                                    <label class="font-weight-bold text-center">{{uploadMoreFile[key].title}}</label>
                                </div>
                                <template v-if="!checkFileType(uploadMoreFile[key].name)">
                                    <img :class="checkNoImage(uploadMoreFile[key].name) ? 'invisible' : '' " :src="`${uploadMoreFile[key].file}`"
                                         class="ml-0 p-5 maxwidth-webkit"/>
                                </template>
                                <template v-else>
                                    <i class="fa fa-file fa-2x ml-0 product-print p-5 custom-fontsize-ml-pdf"></i>
                                </template>
                            </div>
                            <div class="approval-monument-row mx-5 mt-5">
                                <div class="flex-grow-1 custom-div-size2" style="margin-left: 8rem !important;">
                                    <label class="font-weight-bold">Approved By:</label>
                                    <label>{{formFields.approved_by}}</label>
                                </div>
                                <div class="flex-grow-1 custom-div-size1">
                                    <label class="font-weight-bold">Date:</label>
                                    <label>{{ changeDateFormat(formFields.date) }}</label>
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
                                <label class="col-5">Die: {{formFields.die}}</label>
                                <label class="col-5">Base: {{formFields.base}}</label>
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
                                <label class="print-elm ml-3 mt-1" v-if="formFields.letter_style == 3">{{printLetter(formFields.letter_style)}} {{formFields.letter_style_other}}</label>
                                <label class="print-elm ml-3 mt-1" v-else>{{printLetter(formFields.letter_style)}}</label>
                            </div>
                            <div class="approval-monument-row my-2">
                                <label class="font-weight-bold mt-3">Lithochrome Darkening or Whitening Agent:</label>
                                <label class="ml-3 mt-3">{{printLithochrome(formFields.lithochrome_agent)}}</label>
                            </div>
                        </div>
                        <div style="page-break-after: always;"></div>
                    </div>
                </div>
            </div>
        </PDF>
        <div class="row">
            <div class="col-md-12">
                <div v-bind:class="[alertClasses, 'd-flex non-print-elm justify-content-center m-auto p-1 w-50']">{{alertMessage}}</div>
                <form class="bg-white rounded mx-2 mb-2 p-3">
                    <div class="form-content">
                        <div class="approval-monument-row border rounded">
                            <div class="d-block border-right px-1 pt-1 my-0">
                                <label class="font-weight-bold">Date:</label><br>
                                <label>{{ changeDateFormat(formFields.order_date) }}</label>
                            </div>
                            <div class="d-block border-right px-1 pt-1 my-0">
                                <label class="font-weight-bold">Product #:</label><br>
                                <b-form-input
                                    class="mb-1"
                                    size="sm"
                                    v-model="formFields.product_numbers"
                                ></b-form-input>
                            </div>
                           <div class="d-block px-1">
                                <label class="font-weight-bold">DESIGN FILE NAME:</label>
                                <label class="d-block">{{formFields.company_name}}-{{formFields.name_on_stone}}-{{formFields.invoice_no}}</label>
                            </div>
                        </div>
                        <div class="approval-monument-row my-2 non-print-elm" v-for="(task, key) in uploadMoreFile">
                            <div class="d-block col-8 mr-3">
                                <div class="mt-4">
                                    <label class="font-weight-bold col-2 my-auto p-0 ml-n2">Title:</label>
                                    <b-form-input
                                        class="ml-2 mx-2 non-print-elm"
                                        size="sm"
                                        v-model="uploadMoreFile[key].title"
                                    ></b-form-input>
                                </div>
                                <div class="my-2">
                                    <label class="font-weight-bold col-2 my-auto p-0 ml-n2">Upload {{uploadMoreFile[key].no}}:</label>
                                    <b-form-file
                                        :ref="'inputFront_'+uploadMoreFile[key].no"
                                        browse-text="Choose File"
                                        class="mx-2 border rounded custom-file-upload"
                                        drop-placeholder="Drop file here..."
                                        placeholder="No Chosen File"
                                        plain
                                        size="sm"
                                        v-on:change="previewImageFront($event, uploadMoreFile[key].no)"
                                    ></b-form-file>
                                </div>
                            </div>
                            <template v-if="!checkFileType(uploadMoreFile[key].name)">
                                <div class="justify-content-end d-block" style="text-align: center;">
                                    <img :src="`${uploadMoreFile[key].file}`" class="ml-2 border p-1 rounded maxwidth-webkit"
                                         @click="openPreviewNewPage(uploadMoreFile[key].file)" style="cursor: pointer;" height=150/>
                                    <div class="justify-content-center">
                                        <input class="m-0" id="chkPrimary" type="checkbox" v-model="uploadMoreFile[key].printable"/>
                                        <label for="chkPrimarys">Printable</label>
                                    </div>
                                </div>
                            </template>
                            <template v-else>
                                <div class="justify-content-end file-container d-block">
                                    <i class="fa fa-file fa-2x ml-2 p-1 rounded product-image custom-width-height-icon"
                                       @click="openPreviewNewPage(uploadMoreFile[key].file)" style="cursor: pointer;"></i>
                                    <div class="justify-content-center">
                                        <input class="m-0" id="chkPrimary" type="checkbox" v-model="uploadMoreFile[key].printable"/>
                                        <label for="chkPrimarys">Printable</label>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="approval-monument-row my-2 non-print-elm">
                            <div class="d-block col-8 mr-3">
                                <div class="my-2 mt-5">
                                    <button @click="uploadMoreImage" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" type="button">Upload More</button>
                                </div>
                            </div>
                        </div>
                        <div class="approval-monument-row mx-5 mt-5">
                            <div class="flex-grow-1 custom-div-size2">
                                <label class="font-weight-bold">Approved By:</label>
                                <b-form-input
                                    class="ml-2 non-print-elm"
                                    size="sm"
                                    v-model="formFields.approved_by"
                                ></b-form-input>
                            </div>
                            <div class="flex-grow-1 custom-div-size1">
                                <label class="font-weight-bold">Date:</label>
                                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" @input="formFields.date = checkDate(formFields.date)" class="my-auto input-date non-print-elm" close-button locale="en" name="date"
                                                   placeholder=""
                                                   reset-button
                                                   size="sm"
                                                   today-button
                                                   v-model="formFields.date">

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
                            <label class="col-1">Die:</label>
                            <b-form-input class="input-lg custom-height-mt" size="sm" type="text" v-model="formFields.die"></b-form-input>
                           <label class="col-1">Base:</label>
                            <b-form-input class="input-lg custom-height-mt" size="sm" type="text" v-model="formFields.base"></b-form-input>
                        </div>
                        <div class="approval-monument-row my-n2">
                            <label class="font-weight-bold mt-1">Granite Color:</label>
                            <b-form-group class="m-0 ml-2 my-auto custom-radio-and-checkbox flex-grow-1 non-print-elm">
                                <b-form-radio-group class="my-n1" v-model="formFields.granite_color">
                                    <b-form-radio :value=0>GRAY</b-form-radio>
                                    <b-form-radio :value=1>MEL.BLK.</b-form-radio>
                                    <b-form-radio :value=2>D.BROWN</b-form-radio>
                                    <b-form-radio :value=3>M.ROSE</b-form-radio>
                                    <b-form-radio :value=4>BAHAMA BLUE</b-form-radio>
                                </b-form-radio-group>
                                <b-form-radio-group class="my-n1" v-model="formFields.granite_color">
                                    <b-form-radio :value=5>BLUE PEARL</b-form-radio>
                                    <b-form-radio :value=6 class="radio-margin">INDIA RED</b-form-radio>
                                    <b-form-radio :value=7>OTHER</b-form-radio>
                                </b-form-radio-group>
                            </b-form-group>
                        </div>
                        <div class="approval-monument-row my-3">
                            <label class="font-weight-bold mt-1">Carving Style:</label>
                            <b-form-group class="m-0 ml-2 my-auto custom-radio-and-checkbox flex-grow-1 non-print-elm">
                                <b-form-radio-group class="my-n1" v-model="formFields.carving_style">
                                    <b-form-radio :value=0>FLAT CURVE</b-form-radio>
                                    <b-form-radio :value=1>SHAPE CURVE</b-form-radio>
                                    <b-form-radio :value=2>LASER ETCH</b-form-radio>
                                    <b-form-radio :value=3>HAND ETCH</b-form-radio>
                                </b-form-radio-group>
                            </b-form-group>
                        </div>
                        <div class="approval-monument-row my-n2">
                            <label class="font-weight-bold mt-1">Letter Carving Style:</label>
                            <b-form-group class="m-0 ml-2 my-auto custom-radio-and-checkbox flex-grow-1 non-print-elm">
                                <b-form-radio-group class="my-n1" v-model="formFields.letter_style">
                                    <b-form-radio :value=0 class="mr-n5">V-CUT</b-form-radio>
                                    <b-form-radio :value=1 class="mx-n5">SKIN SUNK</b-form-radio>
                                    <b-form-radio :value=2 class="mx-n2">FROSTED OUTLINED</b-form-radio>
                                    <b-form-radio :value=3 class="mx-n1">OTHER
                                        <b-form-input class="input-lg letter-field-margin" size="sm" type="text" v-if="formFields.letter_style == 3" v-model="formFields.letter_style_other"></b-form-input>
                                    </b-form-radio>
                                </b-form-radio-group>
                            </b-form-group>
                        </div>
                        <div class="approval-monument-row my-2">
                            <label class="font-weight-bold mt-3 non-print-elm">Lithochrome Darkening or<br> Whitening Agent:</label>
                            <label class="print-elm font-weight-bold mt-3">Lithochrome Darkening or Whitening Agent:</label>
                            <b-form-group class="m-0 ml-2 my-auto custom-radio-and-checkbox flex-grow-1 non-print-elm">
                                <b-form-radio-group class="my-n1" v-model="formFields.lithochrome_agent">
                                    <b-form-radio :value=0>BLACK</b-form-radio>
                                    <b-form-radio :value=1>LT. HI-LITE</b-form-radio>
                                    <b-form-radio :value=2>MED HI-LITE</b-form-radio>
                                    <b-form-radio :value=3>HVY. HI-LITE</b-form-radio>
                                </b-form-radio-group>
                            </b-form-group>
                        </div>
                        <div class="approval-monument-row non-print-elm ml-n1">
                            <div>
                                <button @click="printPDF" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" type="button">Print Preview</button>
                                <button :disabled="saveDisabled" @click="save" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" type="button" v-if="formFields.id ? isUpdatePermitted : isCreatePermitted">
                                    Save<span class="spinner-grow spinner-grow-sm ml-1" v-if="saveDisabled"></span>
                                </button>
                                <router-link :to="'/productions/' +production_id" class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" v-if="production_id != undefined">Cancel</router-link>
                                <router-link :to="'/orders/' +id" class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" v-else>Cancel</router-link>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import PDF from "../../../../Modules/PDF-Modal";
    import {fetchRecord, saveRecord} from "../../../../helpers/axios";
    import {event, eventBus} from "../../../../event-bus/event-bus";
    import {searchForEmptyDate} from "../../../../helpers/common";

    export default {
        name: "Add",
        props: {
            id: {
                type: Number
            },
            production_id: {
                type: Number
            },
            hideInModal: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                formFields: {
                    id: 0,
                    image: [],
                    filetitle: [],
                    baseSixtyFourImg: [],
                    fileCheckBox: [],
                    production_id: 0,
                    imagefront: null,
                    imageback: null,
                    deleteImage: [],
                },
                imagefront: null,
                imageback: null,
                imagePath: '/images/approval-monument/',
                imageDefault: '/images/default-image.jpg',
                axiosParams: {module: 'order/approvalMonument'},
                axiosParamsOrder: {module: 'order'},
                alertMessage: '',
                approvalImage: [{no: 1, id: 0, title: null, file: '/images/default-image.jpg', printable: false, name: 'default-image.jpg', file_to_upload: null}],
                imagesToPrint: [],
                currentNumber: 1,
                hideAlert: true,
                successResponse: false,
                errorResponse: false,
                saveDisabled: false,
                validFileTypes: ['jpeg', 'JPEG', 'jpg', 'JPG', 'png', 'PNG', 'eps', 'EPS', 'svg', 'SVG', 'pdf', 'PDF', 'docx', 'DOCX', 'xlsx', 'ai', 'lwp'],
                docLwpPdfAiTypes: ['pdf', 'PDF', 'fs', 'docx', 'DOCX', 'xlsx', 'xls', 'ai', 'lwp', 'eps'],
            }
        },
        components: {
            PDF
        },
        computed: {
            alertClasses: function () {
                return {
                    alert: true,
                    'alert-success': this.successResponse,
                    'alert-danger': this.errorResponse,
                    'd-none': this.hideAlert
                }
            },
            isCreatePermitted() {
                return (this.$store.getters.isPermitted({resource: 'Orders', action: 'create'})) || (this.$store.getters.isPermitted({resource: 'Production', action: 'create'}));
            },
            isUpdatePermitted() {
                return (this.$store.getters.isPermitted({resource: 'Orders', action: 'update'})) || (this.$store.getters.isPermitted({resource: 'Production', action: 'update'}));
            },
            uploadMoreFile() {
                if (Object.keys(this.formFields.image).length > 0) {
                    this.assignFileNumber()
                }
                return this.approvalImage
            },
        },
        metaInfo() {
            return {
                title: 'Approval Monument'
            }
        },
        beforeCreate() {
            if ((!this.$store.getters.isPermitted({resource: 'Orders', action: 'read'})) && (!this.$store.getters.isPermitted({resource: 'Production', action: 'read'})))
                this.$router.push('/access-denied');
        },
        mounted() {
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            this.getAppovalMonument();
            this.$store.getters.detectFormChanges();
        },
        methods: {
            getAppovalMonument() {
                this.axiosParams.id = this.formFields.id;
                fetchRecord(this.axiosParams, (response) => {
                    this.formFields = response.data.approval_monument;
                    this.formFields.order_date = response.data.date;
                    this.formFields.order_day = this.getDayOfWeek(response.data.date);

                    if (response.data.invoice != undefined)
                        this.formFields.invoice_no = response.data.invoice.invoice_number;
                    if (response.data.family != undefined)
                        this.formFields.name_on_stone = response.data.family.name_on_stone;
                    if (response.data.company != undefined)
                        this.formFields.company_name = response.data.company.name;

                    this.formFields.image = this.formFields.image ? this.formFields.image : []
                    this.formFields.deleteImage = []
                    this.formFields.filetitle = []
                    this.formFields.baseSixtyFourImg = []
                    this.formFields.imagefront = this.formFields.image_front ? this.imagePath + this.formFields.image_front : this.imageDefault;
                    this.formFields.imageback = this.formFields.image_back ? this.imagePath + this.formFields.image_back : this.imageDefault;
                    this.formFields.production_id = this.$props.production_id ? this.$props.production_id : 0;
                })
            },
            openPreviewNewPage: function (url) {
                window.open(url, '_blank');
            },
            changeDateFormat: function (value) {
                return this.$store.getters.changeDateFormat(value);
            },
            save() {
                this.saveDisabled = true;
                let formData = new FormData();
               /* if (this.formFields.id){
                    if (this.approvalImage?.length) {
                        for (let file of this.approvalImage) {
                            file.id == 0 ? this.formFields.filetitle.push({name: file.name, title: file.title, printable: file.printable}) : ''
                            if (file.file_to_upload)
                                formData.append('doc_files[]', file.file_to_upload);
                        }
                    }
                }
                else */
                    // if(this.formFields.id == 0){
                    if (this.approvalImage?.length) {
                        for (let file of this.approvalImage) {
                            file.id == 0 ? this.formFields.baseSixtyFourImg.push({name: file.name, title: file.title, printable: file.printable, base64file: file.file}) : ''
                        }
                    }
                // }
                let data = this.formFields;
                formData.append('data', JSON.stringify(data));
                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: this.alertMessage, variant: 'danger', duration: 5000});
                        this.alertMessage = '';
                    } else {
                        let status = this.formFields.id ? 'Updated' : 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                        this.makeToast({title: 'Production Approval ' + status, message: this.alertMessage, variant: 'success'});
                        this.alertMessage = '';
                        if (this.approvalImage?.length) {
                            for (let refNo of this.approvalImage) {
                                let refNumber = 'inputFront_'.concat(refNo.no)
                                this.$refs[refNumber][0].reset();
                            }
                        }
                        Object.keys(response.data.image).length > 0 ? this.formFields.image = response.data.image : ''
                        this.formFields.id == 0 ? this.formFields.id = response.data.id : ''
                        Object.keys(response.data.image).length > 0 ? this.assignFileNumber() : ''
                        this.formFields.deleteImage = []
                        this.imagesToPrint = []
                        this.formFields.filetitle = []
                        this.formFields.baseSixtyFourImg = []
                        let record = Object.values(this.$store.state[this.axiosParamsOrder.module].recordList).find(obj => obj.id == this.id);
                        if (record != undefined) {
                            record.approval_monument.id = response.data.id
                        }
                    }
                }, (error) => {
                    if (error) {
                        this.makeToast({title: 'Error', message: error.response, variant: 'danger', duration: 3000});
                    }
                })
            },
            assignFileNumber: function () {
                let refNumber = 0;
                for (let data of this.formFields.image) {
                    refNumber++
                    data.no = refNumber
                }
                this.currentNumber = refNumber
                this.approvalImage = this.formFields.image
            },
            previewImageFront: function (event, refNo) {
                let input = event.target;
                let refInput = 'inputFront_'.concat(refNo)
                let FileSize = input.files[0].size / 1024 / 1024;
                let fileType = input.files[0].name.split('.');
                if (FileSize > 20 || (this.validFileTypes.indexOf(fileType[fileType.length - 1]) == -1 && input.files[0].name.substr(input.files[0].name.lastIndexOf('.') + 1) != 'fs')) {
                    this.makeToast({title: 'Error', message: 'Invalid image type or File size exceeds 20 MB', variant: 'danger', duration: 3000});
                    this.$refs[refInput][0].reset();
                    this.formFields.imagefront = this.imageDefault;
                   this.$forceUpdate();
                    return false;
                } else {
                    if (input.files && input.files[0]) {
                        let reader = new FileReader();
                        reader.onload = (e) => {
                            this.$forceUpdate();
                            let key = this.approvalImage.findIndex(obj => obj.no == refNo)
                            if (key > -1) {
                                // this.approvalImage[key].id > 0 ? this.formFields.deleteImage.push({id: this.approvalImage[key].id}) : ''
                                this.approvalImage[key].file = e.target.result
                                this.approvalImage[key].name = input.files[0].name
                                this.approvalImage[key].file_to_upload = input.files[0];
                                this.approvalImage[key].title = this.approvalImage[key].title
                                if (this.approvalImage[key].id > 0){
                                    this.formFields.deleteImage.push({id: this.approvalImage[key].id})
                                    this.approvalImage[key].id = 0
                                }
                            }
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            },
            previewImageBack: function (event) {
                let input = event.target;
                let FileSize = input.files[0].size / 1024 / 1024;
                if (FileSize > 2 || input.files[0].type.indexOf("image") == -1) {
                    this.makeToast({title: 'Error', message: 'Invalid image type or File size exceeds 2 MB', variant: 'danger', duration: 5000});
                    this.$refs['inputBack'].reset();
                    this.formFields.imageback = this.imageDefault;
                    this.$forceUpdate();
                    return false;
                } else {
                    if (input.files && input.files[0]) {
                        let reader = new FileReader();
                        reader.onload = (e) => {
                            this.formFields.imageback = e.target.result;
                            this.$forceUpdate();
                            this.image_back = event.target.files[0];
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            },
            getDayOfWeek: function (date) {
                if (date != null) {
                    const dayOfWeek = new Date(date).getDay();
                    return isNaN(dayOfWeek) ? null :
                        ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
                }
            },
            printPDF() {
                eventBus.$emit(event.PRINT_PDF)
            },
            printGranite(val) {
                if (val == 0)
                    return 'GRAY'
                else if (val == 1)
                    return 'ML.BLK'
                else if (val == 2)
                    return 'D.BROWN'
                else if (val == 3)
                    return 'M.ROSE'
                else if (val == 4)
                    return 'BAHAMA BLUE'
                else if (val == 5)
                    return 'BLUE PEARL'
                else if (val == 6)
                    return 'INDIA RED'
                else if (val == 7)
                    return 'OTHER'
                else
                    return ''
            },
            printCarving(val) {
                if (val == 0)
                    return 'FLAT CURVE'
                else if (val == 1)
                    return 'SHAPE CURVE'
                else if (val == 2)
                    return 'LASER ETCH'
                else if (val == 3)
                    return 'HAND ETCH'
                else
                    return ''
            },
            printLetter(val) {
                if (val == 0)
                    return 'V-CUT'
                else if (val == 1)
                    return 'SKIN SUNK'
                else if (val == 2)
                    return 'FROSTED OUTLINED'
                else if (val == 3)
                    return 'OTHER'
                else
                    return ''
            },
            printLithochrome(val) {
                if (val == 0)
                    return 'BLACK'
                else if (val == 1)
                    return 'LT.HI-LITE'
                else if (val == 2)
                    return 'MED-HI-LITE'
                else if (val == 3)
                    return 'HVY.HI-LITE'
                else
                    return ''
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
            checkDate: function (date) {
                return searchForEmptyDate(date);
            },
            uploadMoreImage: function () {
                this.currentNumber++;
                this.approvalImage.push({no: this.currentNumber, title: null, id: 0, file: '/images/default-image.jpg', printable: false, name: 'default-image.jpg', file_to_upload: null})
            },
            checkFileType: function (fileName) {
                let ext = fileName.substr(fileName.lastIndexOf('.') + 1);
                let fileIndex = this.docLwpPdfAiTypes.indexOf(ext);
                return fileIndex > -1;
            },
            checkNoImage: function (filename) {
                return 'default-image.jpg' == filename
            },
            printImagesElement: function (refNo) {
                let record = this.imagesToPrint.find(objRef => objRef.no == refNo)
                let key = this.approvalImage.findIndex(obj => obj.no == refNo)
                this.approvalImage[key].printable == true ? this.imagesToPrint.push(this.approvalImage[key]) :
                    this.imagesToPrint.splice(this.imagesToPrint.indexOf(record), 1)
            }
        }

    }
</script>

<style scoped>
    .form-content {
        margin: 0 auto;
        width: 45rem;
    }

    .approval-monument-row {
        display: flex;
        padding: 0;
    }

    .approval-monument-row div {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }

    .approval-monument-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
    }

    .approval-monument-row div input, textarea, .input-date {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        margin-right: 0;
        font-size: 12px !important;
        height: 1.5rem;
    }

    input[type="file"] {
        height: auto !important;
    }

    .product-image {
        min-width: 13.5rem !important;
        max-width: 13.5rem !important;
    }

    .product-print {
        width: 100% !important;
        height: 50rem !important;
    }
    .maxwidth-webkit{
        max-width: -webkit-fill-available;
    }

    .print-hr {
        border: 1px solid #000 !important;
    }


    header {
        padding: 0 3rem;
    }

    .input-xl {
        width: 20rem;
    }

    .input-lg {
        width: 15.5rem;
    }

    .input-md {
        width: 6rem;
    }

    .input-sm {
        width: 2.2rem;
        height: 1.4rem;
    }

    .letter-field-margin {
        margin-left: 3rem !important;
        margin-top: -1.5rem !important;
    }

    .input-date {
        font-size: .6rem;
    }

    .custom-div-size1 {
        width: 19rem !important;
    }

    .custom-div-size2 {
        width: 25rem !important;
    }

    .custom-dangerbtn-text {
        width: 89px !important;
    }

    .radio-margin {
        margin-left: -18rem !important;
        margin-right: -18rem !important;
    }

    .custom-print-button {
        font-size: 12px;
        background: #007BFF;
        box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.25);
        border-radius: 5px
    }

    .custom-title {
        font-weight: 600;
        font-size: 13px;
        line-height: 15px;
        text-align: center;
        letter-spacing: 0.02em;
    }

    .custom-width-height-icon {
        height: 150px;
        font-size: 8.7rem;
    }

    .custom-width-height-icon:before {
        margin-left: 48px;
    }

    .checkbox-round {
        margin-top: 2px !important;
        width: 1em;
        height: 1.1em !important;
        background-color: white;
        border-radius: 50%;
        vertical-align: middle;
        border: 1px solid #ddd;
        appearance: none;
        -webkit-appearance: none;
        outline: none;
        cursor: pointer;
    }

    .checkbox-round:checked {
        border-color: #007bff;
        background-color: #007bff;
    }

    .custom-fontsize-ml-pdf {
        font-size: 43.9rem;
    }

    .custom-fontsize-ml-pdf:before {
        margin-left: 19rem;
    }

    .custom-height-mt {
        height: 1.5rem;
        margin-top: -3px;
        font-size: 0.75rem;
    }

</style>
