<template>
    <div class="bg-white mt-n1 pt-1">
        <!--<div>
            <h3 class="mx-2 my-1 custom-form-heading"> Misc. Monument Work Order Form</h3>
            <div class="d-flex non-print-elm justify-content-center bg-toolbar my-2 p-1">
                <button type="button" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                    Save<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                </button>
                <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/orders/' +id">Cancel</router-link>

            </div>
        </div>-->

        <PDF :title="'printWorkOrder'">

            <div slot="header" class="pdf-custom-margin-form">
              <h2 class="pdf-title col-md-12 my-5">DELIVERY - WORK ORDER FORM</h2>
                <form  class="pdf-fields">
                    <div class="work-order-row flex-grow-1 ">
                        <div class="custom-div-size1 mt-5">
                            <label class="pdf-labels">NAME ON MONUMENT:</label>
                            <label class="pdf-labels ml-0">_____________________________________</label>
                        </div>
                        <div class="pdf-custom-div-size2 pdf-margin-invoice mt-5">
                            <label class="pdf-labels">Invoice #</label>
                            <label class="pdf-labels ml-n2">_______________</label>
                        </div>
                    </div>
                    <div class="work-order-row d-block">
                        <div class="flex-grow-1 mt-3">
                            <label class="pdf-labels">DELIVERY TO STORE LOCATION:</label>
                            <label class="pdf-labels ml-n2">___________________________________________________</label>
                        </div>
                    </div>
                    <div class="work-order-row mt-3">
                        <div class="">
                            <label class="pdf-labels">COMPANY:</label>
                            <label class="pdf-labels ml-n1">_________________________________________________________________________</label>
                        </div>
                    </div>
                    <div class="work-order-row mt-3">
                        <div class="">
                            <label class="pdf-labels">ADDRESS:</label>
                            <label class="pdf-labels ml-n2">__________________________________________________________________________</label>
                        </div>

                    </div>
                    <div class="work-order-row flex-grow-1 mt-2">
                        <div class="pdf-custom-div-size2">
                            <label class="pdf-labels">CITY:</label>
                            <label class="pdf-labels ml-n1">__________________________</label>
                        </div>
                        <div class="pdf-custom-div-size2">
                            <label class="pdf-labels">STATE:</label>
                            <label class="pdf-labels ml-n1">________________________</label>
                        </div>
                        <div class="pdf-custom-div-size2">
                            <label class="pdf-labels">ZIP:</label>
                            <label class="pdf-labels ml-n2">________________</label>
                        </div>
                    </div>
                    <div class="work-order-row flex-grow-1 mt-2">
                        <div class="pdf-custom-div-size3">
                            <label class="pdf-labels">PHONE #:</label>
                            <label class="pdf-labels ml-0">________________________________</label>
                        </div>
                        <div class="pdf-custom-div-size3 pdf-margin-contact">
                            <label class="pdf-labels">CONTACT:</label>
                            <label class="pdf-labels ml-n1">_______________________________</label>
                        </div>
                    </div>
                    <div class="work-order-row d-block">
                        <div class="flex-grow-1 mt-3">
                            <label class="pdf-labels text-danger">WORK TO BE DONE:</label>
                            <label class="pdf-labels ml-n2">________________________________________________________________</label>
                        </div>
                        <div class="flex-grow-1 mt-3 ml-2">
                            <label class="pdf-labels ml-0">____________________________________________________________________________________</label>
                        </div>
                    </div>
                    <div class="work-order-row d-block">
                        <div class="flex-grow-1 mt-3">
                            <label class="pdf-labels text-danger">STONE SIZE, TYPE & COLOR (<span class="small font-italic">2-0 x 0-6 x 1-6 tablet grey</span>):</label>
                            <label class="pdf-labels ml-0">____________________________________</label>
                        </div>
                        <div class="flex-grow-1 mt-3 ml-2">
                            <label class="pdf-labels ml-0">____________________________________________________________________________________</label>
                        </div>
                        <div class="flex-grow-1 mt-3 ml-2">
                            <label class="pdf-labels ml-0">____________________________________________________________________________________</label>
                        </div>

                    </div>
                    <div class="work-order-row d-block">
                        <div class="flex-grow-1 mt-3">
                            <label class="pdf-labels text-danger">SUPPLIES NEEDED:</label>
                            <label class="pdf-labels ml-n2">_________________________________________________________________</label>
                        </div>
                        <div class="flex-grow-1 mt-3 ml-2">
                            <label class="pdf-labels ml-0">____________________________________________________________________________________</label>
                        </div>
                        <div class="flex-grow-1 mt-3 ml-2">
                            <label class="pdf-labels ml-0">____________________________________________________________________________________</label>
                        </div>
                    </div>
                    <div class="work-order-row d-block">
                        <div class="flex-grow-1 mt-3">
                            <label class="pdf-labels text-danger">WORK ORDER NOTES:</label>
                            <label class="pdf-labels ml-0">_____________________________________________________________</label>
                        </div>
                        <div class="flex-grow-1 mt-3 ml-2">
                            <label class="pdf-labels ml-0">____________________________________________________________________________________</label>
                        </div>
                        <div class="flex-grow-1 mt-3 ml-2">
                            <label class="pdf-labels ml-0">____________________________________________________________________________________</label>
                        </div>
                        <div class="flex-grow-1 mt-3 ml-2">
                            <label class="pdf-labels ml-0">____________________________________________________________________________________</label>
                        </div>
                    </div>
                    <div class="work-order-row mt-5">
                        <div class=" mt-5">
                            <label class="pdf-labels">COMPLETED BY:</label>

                            <label class="pdf-labels ml-1">_______________________</label>
                        </div>

                    </div>
                    <div class="work-order-row mt-3">
                        <div class="">
                            <label class="pdf-labels">DATE:</label>

                            <label class="pdf-labels ml-0">__________________________________</label>
                        </div>

                    </div>
                </form>
            </div>

        </PDF>

        <div class="custom-margin-form">
            <h2 class="title col-md-12 my-5">DELIVERY - WORK ORDER FORM</h2>
            <form  class="pdf-fields">
                <div class="work-order-row flex-grow-1 ">
                    <div class="custom-div-size1 mt-5">
                        <label class="labels">NAME ON MONUMENT:</label>
                        <label class="labels ml-n1">_____________________________________</label>
                    </div>
                    <div class="custom-div-size2 margin-invoice mt-5">
                        <label class="labels">Invoice #</label>
                        <label class="labels ml-n2">_______________</label>
                    </div>
                </div>
                <div class="work-order-row d-block">
                    <div class="flex-grow-1 mt-3">
                        <label class="labels">DELIVERY TO STORE LOCATION:</label>
                        <label class="labels ml-n2">___________________________________________________</label>
                    </div>
                </div>
                <div class="work-order-row mt-3">
                    <div class="">
                        <label class="labels">COMPANY:</label>
                        <label class="labels ml-n1">_________________________________________________________________________</label>
                    </div>
                </div>
                <div class="work-order-row mt-3">
                    <div class="">
                        <label class="labels">ADDRESS:</label>
                        <label class="labels ml-n2">__________________________________________________________________________</label>
                    </div>

                </div>
                <div class="work-order-row flex-grow-1 mt-2">
                    <div class="custom-div-size2">
                        <label class="labels">CITY:</label>
                        <label class="labels ml-n1">__________________________</label>
                    </div>
                    <div class="custom-div-size2">
                        <label class="labels">STATE:</label>
                        <label class="labels ml-n1">________________________</label>
                    </div>
                    <div class="custom-div-size2">
                        <label class="labels">ZIP:</label>
                        <label class="labels ml-n2">________________</label>
                    </div>
                </div>
                <div class="work-order-row flex-grow-1 mt-2">
                    <div class="custom-div-size3">
                        <label class="labels">PHONE #:</label>
                        <label class="labels ml-n1">________________________________</label>
                    </div>
                    <div class="custom-div-size3 margin-contact">
                        <label class="labels">CONTACT:</label>
                        <label class="labels ml-n1">_______________________________</label>
                    </div>
                </div>
                <div class="work-order-row d-block">
                    <div class="flex-grow-1 mt-3">
                        <label class="labels">WORK TO BE DONE:</label>
                        <label class="labels ml-n2">________________________________________________________________</label>
                    </div>
                    <div class="flex-grow-1 mt-3 ml-2">
                        <label class="labels ml-0">____________________________________________________________________________________</label>
                    </div>
                </div>
                <div class="work-order-row d-block">
                    <div class="flex-grow-1 mt-3">
                        <label class="labels">STONE SIZE, TYPE & COLOR (<span class="small font-italic">2-0 x 0-6 x 1-6 tablet grey</span>):</label>
                        <label class="pdf-labels ml-n1">_______________________</label>
                    </div>
                    <div class="flex-grow-1 mt-3 ml-2">
                        <label class="labels ml-0">____________________________________________________________________________________</label>
                    </div>
                    <div class="flex-grow-1 mt-3 ml-2">
                        <label class="labels ml-0">____________________________________________________________________________________</label>
                    </div>

                </div>
                <div class="work-order-row d-block">
                    <div class="flex-grow-1 mt-3">
                        <label class="labels">SUPPLIES NEEDED:</label>
                        <label class="labels ml-n2">_________________________________________________________________</label>
                    </div>
                    <div class="flex-grow-1 mt-3 ml-2">
                        <label class="labels ml-0">____________________________________________________________________________________</label>
                    </div>
                    <div class="flex-grow-1 mt-3 ml-2">
                        <label class="labels ml-0">____________________________________________________________________________________</label>
                    </div>
                </div>
                <div class="work-order-row d-block">
                    <div class="flex-grow-1 mt-3">
                        <label class="labels">WORK ORDER NOTES:</label>
                        <label class="labels ml-0">_____________________________________________________________</label>
                    </div>
                    <div class="flex-grow-1 mt-3 ml-2">
                        <label class="labels ml-0">____________________________________________________________________________________</label>
                    </div>
                    <div class="flex-grow-1 mt-3 ml-2">
                        <label class="labels ml-0">____________________________________________________________________________________</label>
                    </div>
                    <div class="flex-grow-1 mt-3 ml-2">
                        <label class="labels ml-0">____________________________________________________________________________________</label>
                    </div>
                </div>
                <div class="work-order-row mt-5">
                    <div class=" mt-5">
                        <label class="labels">COMPLETED BY:</label>

                        <label class="labels ml-1">_______________________</label>
                    </div>

                </div>
                <div class="work-order-row mt-3">
                    <div class="">
                        <label class="labels">DATE:</label>

                        <label class="labels ml-0">__________________________________</label>
                    </div>

                </div>
            </form>
            <div class="work-order-row">
                <div>
                    <button type="button" class="btn btn-sm btn-info custom-print-button px-2 ml-2" @click="printPDF">Print Preview</button>
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
            if(!this.$store.getters.isPermitted({resource:'Orders',action:'read'}))
                this.$router.push( '/access-denied');
        },
        metaInfo() {
            return {
                title: 'Printable Delivery Work Order'
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
    .pdf-fields{
        border:none !important;
        color: black !important;
        font-size: 22px !important;
    }
    .pdf-labels{
        font-family: "Times New Roman";
        font-size: 22px !important;
        font-weight: 700 !important;
    }
    .pdf-margin-invoice{
        margin-left: 26rem !important;
    }
    .pdf-margin-contact{
        margin-left: 3rem !important;
    }
    .pdf-custom-margin-form{
        margin-top:1rem !important;
        margin-left: 1rem !important;
        margin-right: 1rem !important;
    }
    .pdf-title{
        font-family: "Times New Roman";
        font-style: normal;
        font-weight: 700;
        font-size: 30px;
        line-height: 25px;
        text-align: center;
        letter-spacing: 0.02em;
        color: #000000;
    }


    .pdf label{
        display: block;
        font-size: 0.5em;
        margin-bottom: 0;
    }

    .labels{
        font-family: "Times New Roman";
        font-size: 14px !important;
        font-weight: 700 !important;
    }
    .margin-invoice{
        margin-left: 10.7rem !important;
    }
    .margin-contact{
        margin-left: -7.6rem !important;
    }
    .custom-margin-form{
        margin-top:1rem !important;
        width: 45rem !important;
        margin: auto;
        /*margin-left: 23rem !important;
        margin-right: 1rem !important;*/
    }
    .title{
        font-family: "Times New Roman";
        font-style: normal;
        font-weight: 700;
        font-size: 22px;
        line-height: 25px;
        text-align: center;
        letter-spacing: 0.02em;
        color: #000000;
        margin-left: -5rem !important;
    }
    .custom-title{
        font-family: "Times New Roman";
        font-style: italic;
        font-weight: 700;
        font-size: 12.3px;
        line-height: 20px;
        text-align: center;
        letter-spacing: 0.02em;
        margin-left: -22rem !important;
    }
    .custom-div-size2{
        width:14rem !important;
    }
    .custom-div-size3{
        width:26rem !important;
    }

    .form-width{
        width:45rem !important;
    }

    .work-order-row
    {
        display: flex;
        padding: 0;
    }
    .work-order-row div
    {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }
    .work-order-row div  label{
        margin: auto 0.5rem;
        white-space: nowrap !important;
        color: #000 !important;
    }
    .work-order-row div input,textarea{
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        margin-right: 0;
        font-size: 12px;
    }
    .work-order-row div input{
        height:1.5rem;
    }
    .pdf-custom-div-size2{
        width:22rem !important;
    }
    .pdf-custom-div-size3{
        width:26rem !important;
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

    .custom-div-size1{
        width:16rem !important;
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
</style>
