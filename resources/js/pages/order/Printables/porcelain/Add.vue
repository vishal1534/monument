<template>
    <div class="bg-white mt-n1 pt-1">
        <!--<div v-if="!hideInModal">
            <h3 class="mx-2 my-1 custom-form-heading">Porcelain Order Form</h3>
            <div class="d-flex non-print-elm justify-content-center bg-toolbar my-2 p-1">
                <button type="button" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                    Save<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                </button>
                <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/orders/' +id">Cancel</router-link>
            </div>
        </div>-->

        <PDF :title="'printPorcelain'">
            <div slot="header" class="pdf-custom-margin-form">
                <h2 class="pdf-title col-md-12 mt-5">FRISBIE PORCELAIN ORDER FORM</h2>
                <h2 class="text-center col-md-12 mt-n3">______________________________________________________________________________________</h2>
                <form>
                    <div class="porcelain-row mt-5">
                        <div class="mt-5">
                            <label class="font-weight-bold pdf-labels ">Date:</label>

                            <label class="font-weight-bold pdf-labels ml-0">_____________________</label>
                        </div>

                    </div>
                    <div class="porcelain-row mt-5">
                        <div class="">
                            <label class="font-weight-bold pdf-labels ">Family Name & Invoice #:</label>

                            <label class="font-weight-bold pdf-labels ml-n1">_________________________________________________</label>
                        </div>

                    </div>
                    <div class="porcelain-row my-5">
                        <div class="">
                            <label class="font-weight-bold pdf-labels ">Porcelain Size:</label>

                            <label class="font-weight-bold pdf-labels ml-0">__________________________________</label>
                        </div>

                    </div>

                    <div class="porcelain-row ml-2 pdf-custom-margin-format">

                            <div>
                                <label class="font-weight-bold pdf-labels ml-0">Format:</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox">
                                <label></label>
                            </div>
                            <div>
                                <label class="font-weight-bold pdf-labels ml-0">OVAL (Vertical)</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox">
                                <label></label>
                            </div>
                            <div>
                                <label class="font-weight-bold pdf-labels ml-0">OVAL (Horizontal)</label>
                            </div>
                    </div>
                    <div class="porcelain-row mt-5 ml-0 pdf-custom-margin-border">

                        <div class="form-group">
                            <input type="checkbox">
                            <label></label>
                        </div>
                        <div>
                            <label class="font-weight-bold pdf-labels ml-0">BUST</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox">
                            <label></label>
                        </div>
                        <div>
                            <label class="font-weight-bold pdf-labels ml-0">FULL FIGURE</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox">
                            <label></label>
                        </div>
                        <div>
                            <label class="font-weight-bold pdf-labels ml-0">OTHER(see instructions)</label>
                        </div>
                    </div>
                    <div class="porcelain-row mt-5 ml-0 pdf-custom-margin-photograph">

                        <div>
                            <label class="font-weight-bold pdf-labels ml-2">PHOTOGRAPH:</label>
                        </div>

                        <div class="form-group">
                            <input type="checkbox">
                            <label></label>
                        </div>
                        <div>
                            <label class="font-weight-bold pdf-labels ml-0">COLOR</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox">
                            <label></label>
                        </div>
                        <div>
                            <label class="font-weight-bold pdf-labels ml-0">BLACK & WHITE</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox">
                            <label></label>
                        </div>
                        <div>
                            <label class="font-weight-bold pdf-labels ml-0">SEPIA BROWN</label>
                        </div>
                    </div>
                    <div class="porcelain-row mt-5 ml-0 pdf-custom-margin-border">

                        <div>
                            <label class="font-weight-bold pdf-labels ml-2">BORDER:</label>
                        </div>

                        <div class="form-group">
                            <input type="checkbox">
                            <label></label>
                        </div>
                        <div>
                            <label class="font-weight-bold pdf-labels ml-0">BLACK LINE BORDER</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox">
                            <label></label>
                        </div>
                        <div>
                            <label class="font-weight-bold pdf-labels ml-0">NO BORDER</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox">
                            <label></label>
                        </div>
                        <div>
                            <label class="font-weight-bold pdf-labels ml-0">WHITE BORDER</label>
                        </div>
                    </div>
                    <div class="porcelain-row ml-0 pdf-custom-margin-background">

                        <div class="col-2">
                            <label class="font-weight-bold pdf-labels ml-2 mt-2">BACKGROUND:</label>
                        </div>
                        <div class="d-block col-2 ml-5">
                            <div>
                                <div class="form-group">
                                    <input type="checkbox">
                                    <label></label>
                                </div>
                                <div>
                                    <label class="font-weight-bold pdf-labels ml-0">OTHER(see instructions)</label>
                                </div>
                            </div>
                            <div>
                                <div class="form-group">
                                    <input type="checkbox">
                                    <label></label>
                                </div>
                                <div>
                                    <label class="font-weight-bold pdf-labels ml-0">KEEP SAME BACKGROUND AS SHOWN ON PHOTO</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="porcelain-row d-block mt-5">
                        <div class="flex-grow-1 mt-5">
                            <label class="font-weight-bold pdf-labels text-danger">SPECIAL INSTRUCTIONS:</label>
                            <label class="font-weight-bold pdf-labels ml-0">_______________________________________________</label>
                        </div>
                        <div class="flex-grow-1 mt-5 ml-2">
                            <label class="font-weight-bold pdf-labels ml-0">______________________________________________________________________</label>
                        </div>
                        <div class="flex-grow-1 mt-5 ml-2">
                            <label class="font-weight-bold pdf-labels ml-0">______________________________________________________________________</label>
                        </div>
                        <div class="flex-grow-1 mt-5 ml-2">
                            <label class="font-weight-bold pdf-labels ml-0">______________________________________________________________________</label>
                        </div>
                        <div class="flex-grow-1 mt-5 ml-2">
                            <label class="font-weight-bold pdf-labels ml-0">______________________________________________________________________</label>
                        </div>

                    </div>

                </form>
            </div>



        </PDF>

        <div class="custom-margin-form">
            <h2 class="title col-md-12 mt-5">FRISBIE PORCELAIN ORDER FORM</h2>
            <form>
                <div class="porcelain-row mt-5">
                    <div class="mt-2">
                        <label class="font-weight-bold labels ">Date:</label>

                        <label class="font-weight-bold labels ml-0">_____________________</label>
                    </div>

                </div>
                <div class="porcelain-row mt-2">
                    <div class="">
                        <label class="font-weight-bold labels ">Family Name & Invoice #:</label>

                        <label class="font-weight-bold labels ml-n1">__________________________________________________</label>
                    </div>

                </div>
                <div class="porcelain-row mt-2 mb-3">
                    <div class="">
                        <label class="font-weight-bold labels ">Porcelain Size:</label>

                        <label class="font-weight-bold labels ml-0">__________________________________</label>
                    </div>

                </div>

                <div class="porcelain-row ml-2 custom-margin-format">

                    <div>
                        <label class="font-weight-bold labels ml-0">Format:</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox">
                        <label></label>
                    </div>
                    <div>
                        <label class="font-weight-bold labels ml-0">OVAL (Vertical)</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox">
                        <label></label>
                    </div>
                    <div>
                        <label class="font-weight-bold labels ml-0">OVAL (Horizontal)</label>
                    </div>
                </div>
                <div class="porcelain-row mt-3 ml-0 custom-margin-border">

                    <div class="form-group">
                        <input type="checkbox">
                        <label></label>
                    </div>
                    <div>
                        <label class="font-weight-bold labels ml-0">BUST</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox">
                        <label></label>
                    </div>
                    <div>
                        <label class="font-weight-bold labels ml-0">FULL FIGURE</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox">
                        <label></label>
                    </div>
                    <div>
                        <label class="font-weight-bold labels ml-0">OTHER(see instructions)</label>
                    </div>
                </div>
                <div class="porcelain-row mt-4 ml-0 custom-margin-photograph">

                    <div>
                        <label class="font-weight-bold labels ml-2">PHOTOGRAPH:</label>
                    </div>

                    <div class="form-group">
                        <input type="checkbox">
                        <label></label>
                    </div>
                    <div>
                        <label class="font-weight-bold labels ml-0">COLOR</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox">
                        <label></label>
                    </div>
                    <div>
                        <label class="font-weight-bold labels ml-0">BLACK & WHITE</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox">
                        <label></label>
                    </div>
                    <div>
                        <label class="font-weight-bold labels ml-0">SEPIA BROWN</label>
                    </div>
                </div>
                <div class="porcelain-row mt-4 ml-0 custom-margin-border">

                    <div>
                        <label class="font-weight-bold labels ml-2">BORDER:</label>
                    </div>

                    <div class="form-group">
                        <input type="checkbox">
                        <label></label>
                    </div>
                    <div>
                        <label class="font-weight-bold labels ml-0">BLACK LINE BORDER</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox">
                        <label></label>
                    </div>
                    <div>
                        <label class="font-weight-bold labels ml-0">NO BORDER</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox">
                        <label></label>
                    </div>
                    <div>
                        <label class="font-weight-bold labels ml-0">WHITE BORDER</label>
                    </div>
                </div>
                <div class="porcelain-row ml-0 custom-margin-background">

                    <div class="col-1">
                        <label class="font-weight-bold labels ml-2 mt-2">BACKGROUND:</label>
                    </div>
                    <div class="d-block col-2 ml-5">
                        <div>
                            <div class="form-group">
                                <input type="checkbox">
                                <label></label>
                            </div>
                            <div>
                                <label class="font-weight-bold labels ml-0">OTHER(see instructions)</label>
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <input type="checkbox">
                                <label></label>
                            </div>
                            <div>
                                <label class="font-weight-bold labels ml-0">KEEP SAME BACKGROUND AS SHOWN ON PHOTO</label>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="porcelain-row d-block mt-5">
                    <div class="flex-grow-1 mt-2">
                        <label class="font-weight-bold labels text-danger">SPECIAL INSTRUCTIONS:</label>
                        <label class="font-weight-bold labels ml-0">__________________________________________________</label>
                    </div>
                    <div class="flex-grow-1 mt-2 ml-2">
                        <label class="font-weight-bold labels ml-0">_________________________________________________________________________</label>
                    </div>
                    <div class="flex-grow-1 mt-2 ml-2">
                        <label class="font-weight-bold labels ml-0">_________________________________________________________________________</label>
                    </div>
                    <div class="flex-grow-1 mt-2 ml-2">
                        <label class="font-weight-bold labels ml-0">_________________________________________________________________________</label>
                    </div>
                    <div class="flex-grow-1 mt-2 ml-2">
                        <label class="font-weight-bold labels ml-0">_________________________________________________________________________</label>
                    </div>

                </div>

            </form>
            <div class="porcelain-row">
                <div>
                    <button type="button" class="btn btn-sm btn-info custom-print-button py-1 ml-2 px-2" @click="printPDF">Print Preview</button>
                </div>

            </div>
        </div>


    </div>
</template>

<script>
    import PDF from "../../../../Modules/PDF-Modal";
    import {event, eventBus} from "../../../../event-bus/event-bus";
    export default {
        name: "Add",
        data() {
            return  {}
        },
        beforeCreate(){
            if(!this.$store.getters.isPermitted({resource:'Orders',action:'read'}) && !this.$store.getters.isPermitted({resource:'Production',action:'read'}))
                this.$router.push( '/access-denied');
        },
        metaInfo() {
            return {
                title: 'Printable Porcelain Form'
            }
        },
        components:{
            PDF,
        },
        methods:{
            printPDF(){
                eventBus.$emit(event.PRINT_PDF)
            },
        }
    }
</script>

<style scoped>


    .pdf-labels{
        font-family: Arial;
        font-size: 35px !important;
    }
    .pdf-custom-margin-form{
        margin-top:1rem !important;
        margin-left: 2rem !important;
        margin-right: 2rem !important;
    }
    .pdf-title{
        font-family: Arial;
        font-style: normal;
        font-weight: 400;
        font-size: 69px;
        line-height: 25px;
        text-align: center;
        letter-spacing: 0.02em;
        color: #000000;
    }
    .pdf-custom-margin-format{
        width: 20rem !important;
        margin-top: 8rem !important;
    }
    .pdf-custom-margin-photograph{
        width: 20rem !important;
    }
    .pdf-custom-margin-border{
        width: 25rem !important;
    }
    .pdf-custom-margin-background{
        width: 90rem !important;
        margin-top: 8rem !important;
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

    .custom-margin-format{
        width: 20rem !important;
        margin-top: 4rem !important;
    }
    .custom-margin-photograph{
        width: 20rem !important;
    }
    .custom-margin-border{
        width: 25rem !important;
    }
    .custom-margin-background{
        width: 90rem !important;
        margin-top: 4rem !important;
    }
    .labels{
        font-family: Arial;
        font-size: 15px !important;
    }
    .custom-margin-form{
        margin-top:1rem !important;
        width: 45rem !important;
        margin: auto;
        /*margin-left: 23rem !important;
        margin-right: 2rem !important;*/
    }
    .title{
        font-family: Arial;
        font-style: normal;
        font-weight: 400;
        font-size: 30px;
        line-height: 25px;
        text-align: center;
        letter-spacing: 0.02em;
        color: #000000;
        text-decoration: underline;
        margin-left: -3rem !important;
    }

    header{
        padding: 0 3rem;
    }

    .custom-print-button{
        font-size: 12px;
        background: #007BFF;
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



    /* This css is for normalizing styles. You can skip this. */
    *, *:before, *:after {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }


    .form-group {
        display: block;
        margin-bottom: 15px;
    }

    .form-group input {
        padding: 0;
        height: initial;
        width: initial;
        margin-bottom: 0;
        display: none;
        cursor: pointer;
    }

    .form-group label {
        position: relative;
        cursor: pointer;
    }

    .form-group label:before {
        content:'';
        -webkit-appearance: none;
        background-color: transparent;
        border: 4px solid #000;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
        padding: 10px;
        display: inline-block;
        position: relative;
        vertical-align: middle;
        cursor: pointer;
        margin-right: 5px;
    }

    .form-group input:checked + label:after {
        content: '';
        display: block;
        position: absolute;
        top: 2px;
        left: 9px;
        width: 6px;
        height: 14px;
        border: solid #0079bf;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
</style>
