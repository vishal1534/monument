<template>
    <div class="bg-white mt-n1 pt-1">
        <div v-if="!hideInModal">
            <h3 class="mx-2 my-1 custom-form-heading">Porcelain Order Form</h3>
            <div class="d-flex non-print-elm justify-content-center bg-toolbar my-2 p-1">
                <button type="button" v-if="formFields.id > 0 ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                    {{ formFields.id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                </button>
                <router-link v-if="production_id > 0"class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/productions/' +production_id">Cancel</router-link>
                <router-link v-else class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/orders/' +id">Cancel</router-link>
            </div>
        </div>
        <div id="porcelain" class="d-flex justify-content-center py-3" >
            <form id="porcelain-form" class="form-width">
                <div v-bind:class="[alertClasses, 'd-flex justify-content-center m-auto p-0 w-50']">{{alertMessage}}</div>
                <div class=" porcelain-row border rounded">
                    <!--<div class="ml-1">
                        <table class="table table-sm table-bordered mt-3 ">
                            <thead class="custom-table-header">
                            <tr>
                                <th>Date:</th>
                                <th>Day:</th>
                                <th>Invoice No.:</th>
                                <th>Family Name:</th>
                            </tr>
                            </thead>
                            <tbody class="custom-table-body">
                            <tr>
                                <td>{{order_date}}</td>
                                <td>{{order_day}}</td>
                                <td>{{invoice_no}}</td>
                                <td>{{name_on_stone.toUpperCase()}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>-->
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
                    <div class="d-block border-right px-1 pt-1 my-0">
                        <label class="font-weight-bold">Invoice. No:</label>
                        <label class="d-block">{{invoice_no}}</label>
                    </div>
                   <!-- <div class="d-block px-1">
                        <label class="font-weight-bold">Family Name:</label>
                        <label class="d-block">{{name_on_stone ? name_on_stone.toUpperCase() : '' }}</label>
                    </div>-->
                </div>
                <div class="porcelain-row">
                    <div class="">
                        <label class="font-weight-bold">Part #:</label>

                        <!--<b-form-select
                                v-model="formFields.part_id"
                                :options="parts"
                                class="custom-caret-agreement input-select"
                                size="sm">
                            <template #first>
                                <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                            </template>

                        </b-form-select>-->
                        <b-form-input v-if="formFields.part_id" type="text" size="sm" class="notin" v-model="formFields.part.title"></b-form-input>
                        <b-form-input v-else type="text" size="sm" class="notin" v-model="formFields.part_title"></b-form-input>
                    </div>
                    <div class="">
                        <label class="font-weight-bold">Orientation:</label>

                        <!--<b-form-select
                                :options="orientations"
                                v-model="formFields.orientation_id"
                                class="custom-caret-agreement input-select"
                                size="sm">
                            <template #first>
                                <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                            </template>

                        </b-form-select>-->
                        <b-form-input v-if="formFields.orientation_id" type="text" size="sm" v-model="formFields.orientation.title"></b-form-input>
                        <b-form-input v-else type="text" size="sm" v-model="formFields.orientation_title"></b-form-input>
                    </div>
                    <div class="">
                        <label class="font-weight-bold">Shape:</label>

                        <!--<b-form-select
                                :options="shapes"
                                v-model="formFields.shape_id"
                                class="custom-caret-agreement input-select"
                                size="sm">
                            <template #first>
                                <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                            </template>

                        </b-form-select>-->
                        <b-form-input v-if="formFields.shape_id" type="text" size="sm" v-model="formFields.shape.title"></b-form-input>
                        <b-form-input v-else type="text" size="sm" v-model="formFields.shape_title"></b-form-input>
                    </div>

                </div>
                <div class="porcelain-row">
                    <div class="">
                        <label class="font-weight-bold">Size:</label>

                        <b-form-select
                                :options="sizes"
                                v-model="formFields.size_id"
                                class="custom-caret-agreement input-select input-size"
                                size="sm">
                            <template #first>
                                <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                            </template>

                        </b-form-select>
                    </div>

                </div>
                <div class="porcelain-row flex-grow-1">
                    <div class="">
                        <label class="font-weight-bold">Format:</label>

                        <b-form-select
                                :options="formats"
                                v-model="formFields.format_id"
                                class="custom-caret-agreement input-select input-format"
                                size="sm">
                            <template #first>
                                <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                            </template>

                        </b-form-select>
                    </div>
                </div>
                <div class="porcelain-row">
                    <div>
                        <label class="font-weight-bold">Photograph:</label>

                        <b-form-group class="m-0 my-auto custom-radio-and-checkbox ml-1">
                            <b-form-radio-group  v-model="formFields.photograph">
                                <b-form-radio class="input-sm"  :value=0>Color</b-form-radio>
                                <b-form-radio class="mx-4 input-lg"  :value=1>Black & White</b-form-radio>
                                <b-form-radio class=""  :value=2>Sepia Brown</b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>

                    </div>

                </div>
                <div class="porcelain-row my-n2">
                    <div>
                        <label class="font-weight-bold">Border:</label>

                        <b-form-group class="m-0 my-auto custom-radio-and-checkbox ml-1">
                            <b-form-radio-group  v-model="formFields.border">
                                <b-form-radio class="input-border"  :value=0>Black Line Order</b-form-radio>
                                <b-form-radio class="mx-4 input-md"  :value=1>No Border</b-form-radio>
                                <b-form-radio class=""  :value=2>White Border</b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>

                    </div>

                </div>
                <div class="porcelain-row my-n2">
                    <div >
                        <label class="font-weight-bold">Background:</label>

                        <b-form-group class="m-0 my-auto custom-radio-and-checkbox ml-1">
                            <b-form-radio-group  v-model="formFields.background">
                                <b-form-radio class="input-background"  :value=0>Other (see instructions)</b-form-radio>
                                <b-form-radio class=""  :value=1>Keep the same background as on photo</b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>

                    </div>

                </div>
                <div class="porcelain-row">
                    <div class=" flex-column flex-grow-1">
                        <label class="font-weight-bold">Special Instructions:</label>

                        <b-form-textarea
                                class="ml-1 mt-1"
                                rows="3"
                                size="sm"
                                v-model="formFields.special_instructions"
                                no-resize
                        ></b-form-textarea>
                    </div>

                </div>
                <div class="porcelain-row my-2">
                    <label class="font-weight-bold ml-2 mt-1" v-if="files.length || formFields.files?.length">Uploads:</label>
                    <div>
                        <ol>
                            <li v-if="formFields.files.length" class="uploads-name" v-for="(name, i) in uploadedFilesNames" :key="'A'+i">{{ name}}</li>
                            <li v-if="files.length" class="uploads-name" v-for="(name, i) in filesNames" :key="i">{{ name}}</li>
                        </ol>
                    </div>

                </div>

                <div>
                    <div class="my-2 ml-1" >
                        <!--<b-form-file
                            class="btn btn-sm btn-danger"
                            ref="inputFile"
                            browse-text="Upload Files"
                            :disabled="hideInModal"
                            plain
                        ></b-form-file>-->
                        <button class="btn btn-sm btn-danger custom-upload-button" @click="onPickFile">Upload Files</button>
                        <b-form-file
                            ref="fileInput"
                            v-on:change="checkImage($event,'fileInput')"
                            :disabled="hideInModal"
                            class="w-50 border rounded custom-file-upload my-1 ml-n1 d-none"
                            v-model="files"
                            placeholder="No File Chosen"
                            drop-placeholder="Drop file here..."
                            accept="image/*"
                            browse-text="Choose File"
                            plain
                            multiple
                        ></b-form-file>
                        <button type="button" class="btn btn-sm btn-info custom-print-button  px-2" @click="printPdf">Print Preview</button>
                        <!--<button type="button" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="storePorcelain" :disabled="saveDisabled">
                            {{ id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                        </button>
                        <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" to="/order-list">Cancel</router-link>
                   --> </div>
                </div>
            </form>
        </div>
        <PDF :title="'printPorcelain'">
            <div slot="header" class="pdf-custom-margin-form">
                <h2 class="pdf-title col-md-12">PORCELAIN ORDER FORM</h2>
                <form>
                    <div class=" porcelain-row border rounded">
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
                        <div class="d-block border-right px-1 pt-1 my-0">
                            <label class="font-weight-bold">Invoice. No:</label>
                            <label class="d-block">{{invoice_no}}</label>
                        </div>
                        <!--<div class="d-block px-1">
                            <label class="font-weight-bold">Family Name:</label>
                            <label class="d-block">{{name_on_stone ? name_on_stone.toUpperCase() : '' }}</label>
                        </div>-->
                    </div>
                    <div class="porcelain-row mt-4">
                        <div class="">
                            <label class="font-weight-bold pdf-labels">Part #:</label>
                            <label class="pdf-labels" >{{partTitle.title}}</label>
                            <!--                            <b-form-input type="text" size="sm" class="pdftest" v-model="formFields.part?.title"></b-form-input>-->
                        </div>
                        <div class="">
                            <label class="font-weight-bold pdf-labels">Orientation:</label>
                            <label class="pdf-labels">{{orientationTitle.title}}</label>
                        </div>
                        <div class="">
                            <label class="font-weight-bold pdf-labels">Shape:</label>
                            <label class="pdf-labels">{{shapeTitle.title}}</label>
                        </div>

                    </div>
                    <div class="porcelain-row">
                        <div class="">
                            <label class="font-weight-bold pdf-labels">Size:</label>
                            <label class="pdf-labels">{{size}}</label>
                        </div>

                    </div>
                    <div class="porcelain-row flex-grow-1">
                        <div class="">
                            <label class="font-weight-bold pdf-labels">Format:</label>
                            <label class="pdf-labels">{{format}}</label>
                        </div>
                    </div>
                    <div class="porcelain-row">
                        <div>
                            <label class="font-weight-bold pdf-labels">Photograph:</label>
                            <label class="pdf-labels">{{printPhotograph(formFields.photograph)}}</label>
                        </div>

                    </div>
                    <div class="porcelain-row my-2">
                        <div>
                            <label class="font-weight-bold pdf-labels">Border:</label>
                            <label class="pdf-labels">{{printBorder(formFields.border)}}</label>
                        </div>

                    </div>
                    <div class="porcelain-row my-2">
                        <div >
                            <label class="font-weight-bold pdf-labels">Background:</label>
                            <label class="pdf-labels">{{printBackground(formFields.background)}}</label>
                        </div>

                    </div>
                    <div class="porcelain-row">
                        <div class=" flex-column flex-grow-1">
                            <label class="font-weight-bold pdf-labels">Special Instructions:</label>

                            <b-form-textarea
                                class="ml-1 mt-1 pdf-fields"
                                rows="6"
                                size="sm"
                                v-model="formFields.special_instructions"
                                no-resize
                            ></b-form-textarea>
                        </div>

                    </div>
                    <div class="porcelain-row my-2">
                        <label class="font-weight-bold pdf-labels ml-2 mt-1" v-if="files.length || formFields.files?.length">Uploads:</label>
                        <div>
                            <ol>
                                <li v-if="formFields.files.length" class="uploads-name pdf-labels" v-for="(name, i) in uploadedFilesNames" :key="'A'+i">{{ name}}</li>
                                <li v-if="files.length" class="uploads-name pdf-labels" v-for="(name, i) in filesNames" :key="i">{{ name}}</li>
                            </ol>
                        </div>

                    </div>
                </form>
            </div>



        </PDF>
    </div>
</template>

<script>
    import PDF from "../../../../Modules/PDF-Modal";
    import {event, eventBus} from "../../../../event-bus/event-bus";
    import {saveRecord, fetchRecord, deleteRecord,nextRecord, previousRecord, firstRecord, lastRecord} from "../../../../helpers/axios";
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
            return  {
                formFields:{
                    id:0,
                    part_id:null,
                    format_id:null,
                    size_id:null,
                    shape_id:null,
                    orientation_id:null,
                    photograph:null,
                    border:null,
                    background:null,
                    special_instructions:null,
                    order_id:null,
                    part:{
                        id:0,
                        title:null,
                    },
                    shape:{
                        id:0,
                        title:null,
                    },
                    orientation:{
                        id:0,
                        title:null,
                    },
                },
                files:[],
                order_date:null,
                order_day:'',
                name_on_stone:'',
                invoice_no:null,
                axiosParams: {module: 'order/porcelain'},
                alertMessage:'',
                hideAlert:true,
                successResponse: false,
                errorResponse: false,
                saveDisabled:false,
                validFileTypes : ['jpeg' ,'JPEG' ,'jpg' ,'JPG' ,'png' ,'PNG' ,'svg' ,'SVG','pdf' ,'PDF', 'docx', 'DOCX', 'xlsx', 'ai', 'lwp', 'fs', 'eps', 'xls'],
            }
        },
        metaInfo() {
            return {
                title: 'Porcelain order',
            }
        },
        components:{
            PDF
        },
        computed:{
        filesNames() {
            const fn = []
            for (let i = 0; i < this.files?.length; ++i) {
                fn.push(this.files[i].name)
            }
            return fn
        },
        uploadedFilesNames() {
            this.files= [];
            const fn = []
            for (let i = 0; i < this.formFields.files?.length; ++i) {
                fn.push(this.formFields.files[i].name)
            }
            return fn
        },
        alertClasses: function () {
                return {
                    alert: true,
                    'alert-success': this.successResponse,
                    'alert-danger': this.errorResponse,
                    'd-none': this.hideAlert
                }
            },
            formats: function () {
                let options = [];
                if(this.$store.state.porcelain.porcelainInfo.formats){
                    this.$store.getters.sortByAlphaNumeric({'fieldName': 'title', 'recordList': this.$store.state.porcelain.porcelainInfo.formats});
                    for (let opt of this.$store.state.porcelain.porcelainInfo.formats){
                        let obj = {value: opt.id, text: opt.title};
                        options.push(obj);
                    }
                }
                return options;
            },
            format: function () {
                let format = '';
                if(this.$store.state.porcelain.porcelainInfo.formats)
                    for (let opt of this.$store.state.porcelain.porcelainInfo.formats){
                        if( opt.id == this.formFields.format_id)
                            format = opt.title;
                    }
                return format;
            },
            sizes: function () {
                let options = [];
                if(this.$store.state.porcelain.porcelainInfo.size){
                    this.$store.getters.sortByAlphaNumeric({'fieldName': 'title', 'recordList': this.$store.state.porcelain.porcelainInfo.size});
                    for (let opt of this.$store.state.porcelain.porcelainInfo.size){
                        let obj = {value: opt.id, text: opt.title};
                        options.push(obj);
                    }
                }
                return options;
            },
            size: function () {
                let size = '';
                if(this.$store.state.porcelain.porcelainInfo.size)
                    for (let opt of this.$store.state.porcelain.porcelainInfo.size){
                        if( opt.id == this.formFields.size_id)
                            size = opt.title;
                    }
                return size;
            },
            partTitle(){
                let fieldTitle = {title: null}
                if(this.formFields.part?.title == null){
                    this.formFields.part = {id:0,title: null};
                    fieldTitle.title = this.formFields.part_title
                } else {
                    this.formFields.part_title = this.formFields.part?.title;
                    fieldTitle.title = this.formFields.part_title
                }
                return fieldTitle
            },
            orientationTitle(){
                let fieldTitle = {title: null}
                if(this.formFields.orientation?.title == null){
                    this.formFields.orientation = {id:0,title: null};
                    fieldTitle.title = this.formFields.orientation_title
                } else {
                    this.formFields.orientation_title = this.formFields.orientation?.title;
                    fieldTitle.title = this.formFields.orientation_title
                }
                return fieldTitle
            },
            shapeTitle(){
                let fieldTitle = {title: null}
                if(this.formFields.shape?.title == null){
                    this.formFields.shape = {id:0,title: null};
                    fieldTitle.title = this.formFields.shape_title
                } else {
                    this.formFields.shape_title = this.formFields.shape?.title;
                    fieldTitle.title = this.formFields.shape_title
                }
                return fieldTitle
            },
            isCreatePermitted(){
                return (this.$store.getters.isPermitted({resource:'Orders',action:'create'})) || (this.$store.getters.isPermitted({resource:'Production',action:'create'}));
            },
            isUpdatePermitted(){
                return (this.$store.getters.isPermitted({resource:'Orders',action:'update'})) || (this.$store.getters.isPermitted({resource:'Production',action:'update'}));
            },
        },
        beforeCreate(){
            if((!this.$store.getters.isPermitted({resource:'Orders',action:'read'})) && (!this.$store.getters.isPermitted({resource:'Production',action:'read'})))
                this.$router.push( '/access-denied');
        },
        mounted() {
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            if(this.$store.state.porcelain.porcelainInfo.length == 0){
                this.$store.dispatch('getPorcelainInfo');
            }
            this.getPorcelain();
            this.$store.getters.detectFormChanges();
        },
        methods:{
            onPickFile (event) {
                event.preventDefault();
                this.$refs.fileInput.$el.click();
            },
            checkImage: function(event,ref) {
                let input = event.target;
                let invalidFileType = false;
                if (input.files.length > 0){
                    for (let file of input.files){
                        let fileType = file.name.split('.');
                        let  FileSize = file.size / 1024 / 1024;
                        if ( FileSize > 25 || this.validFileTypes.indexOf(fileType[fileType.length-1]) == -1){
                            invalidFileType = true;
                            break;
                        }
                    }
                }
                if (invalidFileType) {
                    this.makeToast({title: 'Error', message: 'Invalid image type or File size exceeds 25 MB' , variant: 'danger', duration: 3000});
                    this.$refs['fileInput'].reset();
                    return false;
                }
            },
            getPorcelain(){
                this.axiosParams.id = this.formFields.id;
                fetchRecord(this.axiosParams, (response) => {
                    this.formFields = response.data.porcelain;
                    this.order_date = response.data.date;
                    this.order_day = this.getDayOfWeek(response.data.date);

                    if(response.data.invoice != undefined)
                        this.invoice_no  = response.data.invoice.invoice_number;
                    if(response.data.family != undefined)
                        this.name_on_stone  = response.data.family.name_on_stone;
                })
            },
            changeDateFormat: function(value){
                return this.$store.getters.changeDateFormat(value);
            },
            save(){
                this.saveDisabled = true; //Disabling save button
                let data = this.formFields;
                let formData = new FormData();
                formData.append('data',JSON.stringify(data));

                if (this.files.length > 0){
                    for (let file of this.files){
                        formData.append('doc_files[]', file);
                    }
                }

                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo){
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title : 'Error', message: this.alertMessage, variant : 'danger', duration : 5000});
                        this.alertMessage = '';
                    }
                    else{
                        let status = this.formFields.id ? 'Updated': 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                        this.makeToast({title : 'Procelain '+status, message : this.alertMessage, variant : 'success'});


                        this.formFields = response.data;
                        this.alertMessage = '';
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
            printPhotograph(val) {
                if(val == 0)
                    return 'Color'
                else if(val == 1)
                    return 'Black & White'
                else if(val == 2)
                    return 'Sepia Brown'
                else
                    return ''
            },
            printBorder(val) {
                if(val == 0)
                    return 'Black Line Border'
                else if(val == 1)
                    return 'No Border'
                else if(val == 2)
                    return 'White Border'
                else
                    return ''
            },
            printBackground(val) {
                if(val == 0)
                    return 'Other (See Instructions)'
                else if(val == 1)
                    return 'keep the same background as on photo'
                else
                    return ''
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
    .pdf-custom-margin-form{
        margin-top:1rem !important;
        margin-left: 2rem !important;
        margin-right: 2rem !important;
    }
    .pdf-title{
        font-family: Roboto;
        font-style: normal;
        font-weight: 600;
        font-size: 28px;
        line-height: 25px;
        text-align: center;
        letter-spacing: 0.02em;
        color: #000000;
    }
    .pdf-input-select{
        font-size:22px !important;
        color:#000;
        border: none !important;
        box-sizing: border-box;
        border-radius: 3px;
        background: none !important;
    }
    .pdf-custom-table-header,.pdf-custom-table-body{
        font-size: 22px;
        border: 2px solid #c4c4c4;
    }

    .pdf label{
        display: block;
        font-size: 0.5em;
        margin-bottom: 0;
    }
    .form-width {
        width: 45rem !important;
    }

    .porcelain-row
    {
        display: flex;
        padding: 0;
    }
    .porcelain-row div
    {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }
    .porcelain-row div  label{
        margin: auto 0.5rem;
        white-space: nowrap !important;
        color: #000 !important;
    }
    .porcelain-row div input,textarea{
        border: 1px solid #C4C4C4 !important;
        margin: auto;
        margin-right: 0;
        font-size: 12px;
    }
    header{
        padding: 0 3rem;
    }
    .input-select{
        font-size:12px !important;
        color:#6C757D;
        border: 1px solid #C4C4C4;
        box-sizing: border-box;
        border-radius: 3px;
        height: 1.5rem !important;
        padding: 3px;
    }
    .input-size{
        width:14rem !important;;
    }
    .input-format{
        width:11rem !important;;
    }
    .input-xs{
        width:4rem !important;
    }
    .input-sm{
        width:6rem !important;
    }
    .input-md{
        width:9rem !important;
    }
    .input-lg{
        width:12rem !important;
    }
    .input-border{
        width: 13rem !important;
    }
    .input-background{
        width: 15rem !important;
    }
    .input-photograph{
        width: 25rem !important;
    }

    .custom-print-button{
        font-size: 12px;
        background: #007BFF;
        box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.25);
        border-radius: 5px
    }

    .custom-upload-button{
        font-size: 12px;
        box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.25);
        border-radius: 5px
    }

    .table-bordered th {
        border-bottom: none;
    }
    .table-bordered td {
        border-top: none;
    }
    .custom-dangerbtn-text{
        width: 89px;
    }
    .uploads-name{
        font-size: 12px;
    }
</style>
