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

        <PDF :title="'printFinalDate'">
            <div slot="header" class="pdf-custom-margin-form">

                <div class="final-date-row d-block">
                    <div class="d-flex justify-content-center">
                        <img class="ml-0 pdf-product-print" :src="'images/finaldate-logo.png'" />
                    </div>
                    <div class="d-block pdf-custom-div-top col-3">
                        <div class="my-2">
                            <label class="pdf-sub-labels ">ORDER DATE:</label>
                            <label class="font-weight-bold ml-n1">___________________________</label>
                        </div>
                        <div class="my-2">
                            <label class="pdf-sub-labels ">INVOICE NUMBER:</label>
                            <label class="font-weight-bold ml-n1">_______________________</label>
                        </div>
                    </div>
                </div>
                <h2 class="pdf-title col-md-12 pdf-custom-heading-margin">Final Date Request Form</h2>
                <form>
                    <div class="final-date-row d-block mt-5">
                        <div class="mb-2">
                            <label class="pdf-labels ">Contact:</label>
                            <label class="font-weight-bold pdf-underline-labels ml-0" style="color: transparent !important;">_________________________________________</label>
                            <label class="pdf-labels ">Order Date:</label>
                        </div>
                        <div class="mt-n4 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                        </div>
                        <div class="mt-n3 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4" style="color: transparent !important;">_______________________________________________________________________________________</label>
                        </div>

                    </div>

                    <div class="final-date-row d-block mt-3">
                        <div class="mb-2">
                            <label class="pdf-labels ">Address:</label>
                        </div>
                        <div class="mt-n4 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                        </div>

                    </div>

                    <div class="final-date-row d-block mt-3">
                        <div class="mb-2">
                            <label class="pdf-labels ">Phone:</label>
                            <label class="font-weight-bold pdf-underline-labels ml-0" style="color: transparent !important;">______________________________________</label>
                            <label class="pdf-labels ">Email:</label>
                        </div>
                        <div class="mt-n4 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                        </div>
                    </div>

                    <div class="final-date-row d-block mt-3">
                        <div class="mb-2">
                            <label class="pdf-labels ">Cemetery Name & City:</label>
                        </div>
                        <div class="mt-n4 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                        </div>

                    </div>

                    <div class="final-date-row d-block mt-3">
                        <div class="mb-2">
                            <label class="pdf-labels ">Last Name On Stone:</label>
                        </div>
                        <div class="mt-n4 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                        </div>

                    </div>

                    <div class="final-date-row d-block mt-3">
                        <div class="mb-2">
                            <label class="pdf-labels ">Name Of Whom The Engraving Is For:</label>
                        </div>
                        <div class="mt-n4 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                        </div>

                    </div>

                    <div class="final-date-row d-block mt-3">
                        <div class="mb-2">
                            <label class="pdf-labels ">Birth Date on Stone:</label>
                        </div>
                        <div class="mt-n4 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                        </div>

                    </div>
                    <div class="final-date-row d-block mt-3">
                        <div class="mb-2 ml-2 pdf-custom-div-size2">
                            <div>
                                <label class="pdf-labels ml-0"><span style="color: #6868FF !important;">Final Date to be added:</span></label>
                                <label class="font-weight-bold pdf-underline-labels ml-0" style="color: transparent !important;">________________________</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox">
                                <label></label>
                            </div>
                            <div>
                                <label class=" pdf-labels ml-0">Engraved</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox">
                                <label></label>
                            </div>
                            <div>
                                <label class="pdf-labels ml-0">Bronze Scroll</label>
                            </div>
                        </div>
                        <div class="mt-n4 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                        </div>
                    </div>
                    <div class="final-date-row d-block mt-3">
                        <div class="mb-2">
                            <label class="pdf-labels ">Scroll Size-Length:               </label>
                            <label class="font-weight-bold pdf-underline-labels ml-0" style="color: transparent !important;">__________</label>
                            <label class="pdf-labels ">Width:</label>
                            <label class="font-weight-bold pdf-underline-labels ml-0" style="color: transparent !important;">__________</label>
                            <label class="pdf-labels ">Drill Points Center to Center:</label>
                        </div>
                        <div class="mt-n4 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                        </div>
                    </div>
                    <div class="final-date-row d-block mt-3">
                        <div class="mb-2 ml-2 pdf-custom-div-size2">
                            <div>
                                <label class="pdf-labels ml-0">Rubbing Needed:</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox">
                                <label></label>
                            </div>
                            <div>
                                <label class=" pdf-labels ml-0">YES</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox">
                                <label></label>
                            </div>
                            <div>
                                <label class="pdf-labels ml-0">No/Date Of Rubbing:</label>
                            </div>
                        </div>
                        <div class="mt-n4 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                        </div>
                    </div>
                    <div class="final-date-row d-block mt-3">
                        <div class="mb-2">
                            <label class="pdf-labels ">Description Of Stone:</label>
                        </div>
                        <div class="mt-n4 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                        </div>

                    </div>

                    <div class="final-date-row d-block mt-3">
                        <div class="mb-2">
                            <label class="pdf-labels ">Size:</label>
                        </div>
                        <div class="mt-n4 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                        </div>

                    </div>

                    <div class="final-date-row d-block mt-3">
                        <div class="mb-2">
                            <label class="pdf-labels ">Color:</label>
                        </div>
                        <div class="mt-n4 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                        </div>

                    </div>

                    <div class="final-date-row d-block mt-3">
                        <div class="flex-grow-1 mt-4">
                            <label class="pdf-labels text-danger">*** Please give brief description of location of stone (pin location).</label>
                        </div>
                        <div class="flex-grow-1 mt-4 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                        </div>
                        <div class="flex-grow-1 mt-4 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                        </div>
                        <div class="flex-grow-1 mt-4 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                        </div>

                    </div>
                    <div class="final-date-row d-block mt-3">
                        <div class="mb-2">
                            <label class="pdf-labels ">Engraving Completed on (Date):</label>
                            <label class="font-weight-bold pdf-underline-labels ml-0" style="color: transparent !important;">__________________________</label>
                            <label class="pdf-labels ">Completed by:</label>
                        </div>
                        <div class="mt-n4 ml-2">
                            <label class="font-weight-bold pdf-underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                        </div>
                    </div>
                    <div class="final-date-row pdf-custom-margin-approval mt-3">
                        <div class="flex-grow-1 pdf-custom-div-size2 mr-3">
                            <label class="pdf-approval-label">APPROVED BY:</label>
                            <label>_________________________________________________</label>
                        </div>
                        <div class="flex-grow-1 pdf-custom-div-size2 ml-3">
                            <label class="pdf-approval-label">DATE:</label>
                            <label class="ml-0">_____________________________________</label>
                        </div>

                    </div>
                    <div class="d-block text-center my-3 " style="font-family: Roboto;">
                        <label class="d-block m-0 pdf-approval-label">BY SIGNING THE APPROVAL I ASSUME COMPLETE RESPONSIBILITY FOR LAYOUT/SPELLING/DATES.</label>
                        <label class="d-block m-0 pdf-approval-label">I ALSO AGREE THAT AFTER SIGNING THE APPROVAL, NO FURTHER CHANGES WILL BE MADE & IF </label>
                        <label class="d-block m-0 pdf-approval-label">SOMETHING IS INCORRECT UPON COMPLETION OF THE MONUMENT I AM RESPONSIBLE</label>
                        <label class="d-block m-0 pdf-approval-label">FOR THE COST TO CORRECT IT.</label>
                    </div>

                </form>
            </div>

        </PDF>

        <div slot="header" class="custom-margin-form">

            <div class="final-date-row d-block">
                <div class="d-flex">
                    <img class="ml-0 product-print" :src="'images/finaldate-logo.png'" />
                </div>
                <div class="d-block custom-div-top col-3">
                    <div class="my-2">
                        <label class="sub-labels ">ORDER DATE:</label>
                        <label class="font-weight-bold ml-n1">____________________</label>
                    </div>
                    <div class="my-2">
                        <label class="sub-labels ">INVOICE NUMBER:</label>
                        <label class="font-weight-bold ml-n1">_________________</label>
                    </div>
                </div>
            </div>
            <h2 class="title col-md-12 custom-heading-margin">Final Date Request Form</h2>
            <form>
                <div class="final-date-row d-block mt-5">
                    <div class="mb-2">
                        <label class="labels ">Contact:</label>
                        <label class="font-weight-bold underline-labels ml-0" style="color: transparent !important;">_________________________________________</label>
                        <label class="labels ">Order Date:</label>
                    </div>
                    <div class="mt-n2 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                    </div>
                    <div class="mt-n3 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4" style="color: transparent !important;">_______________________________________________________________________________________</label>
                    </div>

                </div>

                <div class="final-date-row d-block mt-3">
                    <div class="mb-2">
                        <label class="labels ">Address:</label>
                    </div>
                    <div class="mt-n2 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                    </div>

                </div>

                <div class="final-date-row d-block mt-3">
                    <div class="mb-2">
                        <label class="labels ">Phone:</label>
                        <label class="font-weight-bold underline-labels ml-0" style="color: transparent !important;">______________________________________</label>
                        <label class="labels ">Email:</label>
                    </div>
                    <div class="mt-n2 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                    </div>
                </div>

                <div class="final-date-row d-block mt-3">
                    <div class="mb-2">
                        <label class="labels ">Cemetery Name & City:</label>
                    </div>
                    <div class="mt-n2 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                    </div>

                </div>

                <div class="final-date-row d-block mt-3">
                    <div class="mb-2">
                        <label class="labels ">Last Name On Stone:</label>
                    </div>
                    <div class="mt-n2 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                    </div>

                </div>

                <div class="final-date-row d-block mt-3">
                    <div class="mb-2">
                        <label class="labels ">Name Of Whom The Engraving Is For:</label>
                    </div>
                    <div class="mt-n2 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                    </div>

                </div>

                <div class="final-date-row d-block mt-3">
                    <div class="mb-2">
                        <label class="labels ">Birth Date on Stone:</label>
                    </div>
                    <div class="mt-n2 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                    </div>

                </div>
                <div class="final-date-row d-block mt-3">
                    <div class="mb-2 ml-2 custom-div-size2">
                        <div>
                            <label class="labels ml-0"><span style="color: #6868FF !important;">Final Date to be added:</span></label>
                            <label class="font-weight-bold underline-labels ml-0" style="color: transparent !important;">________________________</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox">
                            <label></label>
                        </div>
                        <div>
                            <label class=" labels ml-0">Engraved</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox">
                            <label></label>
                        </div>
                        <div>
                            <label class="labels ml-0">Bronze Scroll</label>
                        </div>
                    </div>
                    <div class="mt-n2 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                    </div>
                </div>
                <div class="final-date-row d-block mt-3">
                    <div class="mb-2">
                        <label class="labels ">Scroll Size-Length:               </label>
                        <label class="font-weight-bold pdf-underline-labels ml-0" style="color: transparent !important;">__________</label>
                        <label class="labels ml-n5">Width:</label>
                        <label class="font-weight-bold pdf-underline-labels ml-0" style="color: transparent !important;">__________</label>
                        <label class="labels ml-n5">Drill Points Center to Center:</label>
                    </div>
                    <div class="mt-n2 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                    </div>
                </div>
                <div class="final-date-row d-block mt-3">
                    <div class="mb-2 ml-2 pdf-custom-div-size2">
                        <div>
                            <label class="labels ml-0">Rubbing Needed:</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox">
                            <label></label>
                        </div>
                        <div>
                            <label class=" labels ml-0">YES</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox">
                            <label></label>
                        </div>
                        <div>
                            <label class="labels ml-0">No/Date Of Rubbing:</label>
                        </div>
                    </div>
                    <div class="mt-n2 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                    </div>
                </div>
                <div class="final-date-row d-block mt-3">
                    <div class="mb-2">
                        <label class="labels ">Description Of Stone:</label>
                    </div>
                    <div class="mt-n2 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                    </div>

                </div>

                <div class="final-date-row d-block mt-3">
                    <div class="mb-2">
                        <label class="labels ">Size:</label>
                    </div>
                    <div class="mt-n2 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                    </div>

                </div>

                <div class="final-date-row d-block mt-3">
                    <div class="mb-2">
                        <label class="labels ">Color:</label>
                    </div>
                    <div class="mt-n2 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                    </div>

                </div>

                <div class="final-date-row d-block mt-3">
                    <div class="flex-grow-1 mt-4">
                        <label class="labels text-danger">*** Please give brief description of location of stone (pin location).</label>
                    </div>
                    <div class="flex-grow-1 mt-4 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                    </div>
                    <div class="flex-grow-1 mt-4 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                    </div>
                    <div class="flex-grow-1 mt-4 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                    </div>

                </div>
                <div class="final-date-row d-block mt-3">
                    <div class="mb-2">
                        <label class="labels ">Engraving Completed on (Date):</label>
                        <label class="font-weight-bold underline-labels ml-0" style="color: transparent !important;">__________________________</label>
                        <label class="labels ">Completed by:</label>
                    </div>
                    <div class="mt-n2 ml-2">
                        <label class="font-weight-bold underline-labels ml-0 mt-n4">__________________________________________________________________________________</label>
                    </div>
                </div>
                <div class="final-date-row custom-margin-approval mt-3">
                    <div class="flex-grow-1 custom-div-size2 mr-3">
                        <label class="approval-label">APPROVED BY:</label>
                        <label>__________________________________________</label>
                    </div>
                    <div class="flex-grow-1 custom-div-size2 ml-3">
                        <label class="approval-label">DATE:</label>
                        <label class="ml-0">____________________________</label>
                    </div>

                </div>
                <div class="d-block text-center my-3 ">
                    <label class="d-block m-0 approval-label">BY SIGNING THE APPROVAL I ASSUME COMPLETE RESPONSIBILITY FOR LAYOUT/SPELLING/DATES.</label>
                    <label class="d-block m-0 approval-label">I ALSO AGREE THAT AFTER SIGNING THE APPROVAL, NO FURTHER CHANGES WILL BE MADE & IF </label>
                    <label class="d-block m-0 approval-label">SOMETHING IS INCORRECT UPON COMPLETION OF THE MONUMENT I AM RESPONSIBLE</label>
                    <label class="d-block m-0 approval-label">FOR THE COST TO CORRECT IT.</label>
                </div>

            </form>
            <div class="final-date-row">
                <div>
                    <button type="button" class="btn btn-sm btn-info custom-print-button  px-2 py-1 ml-2" @click="printPDF">Print Preview</button>
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
        metaInfo() {
            return {
                title: 'Printable Final Date'
            }
        },
        beforeCreate(){
            if(!this.$store.getters.isPermitted({resource:'Orders',action:'read'}))
                this.$router.push( '/access-denied');
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

    .pdf-fields{
        border:none !important;
        color: black !important;
        font-size: 22px !important;
    }
    .pdf-underline-labels{
        font-size: 30px !important;
    }
    .pdf-labels{
        font-family: 'Anton';
        font-size: 30px !important;
    }
    .pdf-sub-labels{
        font-family: 'Anton';
        font-size: 15px !important;
    }
    .pdf-custom-margin-form{
        margin-top:1rem !important;
        margin-left: 2rem !important;
        margin-right: 2rem !important;
    }
    .pdf-title{
        font-family: Anton;
        font-style: normal;
        font-weight: 400;
        font-size: 60px;
        line-height: 25px;
        text-align: center;
        letter-spacing: 0.02em;
        color: #000000;
    }

    .pdf-approval-label{
        font-size: 22px !important;
    }
    .pdf-product-print{
        width: 230px!important;
        height: 130px!important;
    }
    .form-width {
        width: 45rem !important;
    }

    .pdf-fields{
        border:none !important;
        color: black !important;
        font-size: 22px !important;
    }

    .pdf-custom-heading-margin{
        margin-top: 7rem !important;

    }

    .pdf-custom-div-top{
        border: 2px solid #000 !important;
        margin-top: -7rem !important;
        margin-left: 50rem !important;
    }
    .pdf-custom-div-size2{
        width: 22rem !important;
    }
    .pdf-custom-margin-approval{
        margin-left: 6rem !important;
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
    .final-date-row div input,textarea{
        border: 1px solid #C4C4C4 !important;
        margin: auto;
        margin-right: 0;
        font-size: 12px;
    }

    .underline-labels{
        font-size: 20px !important;
    }
    .labels{
        font-family: 'Anton';
        font-size: 20px !important;
    }
    .sub-labels{
        font-family: 'Anton';
        font-size: 10px !important;
    }
    .custom-margin-form{
        margin-top:1rem !important;
        width:45rem !important;
        margin: auto;
        /*margin-left: 19rem !important;
        margin-right: 2rem !important;*/
    }
    .title{
        font-family: Anton;
        font-style: normal;
        font-weight: 400;
        font-size: 30px;
        line-height: 25px;
        text-align: center;
        letter-spacing: 0.02em;
        color: #000000;
       /* margin-left: -9rem !important;*/
    }

    .approval-label{
        font-size: 12px !important;
    }


    .custom-heading-margin{
        margin-top: 4rem !important;

    }

    .custom-div-top{
        border: 2px solid #000 !important;
        margin-top: -5.5rem !important;
        margin-left: 28rem !important;
    }

    .custom-div-size2{
        width: 22rem !important;
    }
    .custom-margin-approval{
        margin-left: 5rem !important;
    }
    .product-print{
        width: 130px!important;
        height: 80px!important;
        margin-left: 19rem !important;
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
