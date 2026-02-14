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

        <PDF :title="'printOrderForm'">
            <div slot="header" class="pdf-custom-margin-form">
                <form >
                    <div class="order-form-row">
                        <div class="col-4 d-block">
                            <div class="d-block pdf-custom-div-top ml-2">
                                <div class="d-block">
                                    <div class="justify-content-end mb-n3">
                                        <label class="pdf-labels ">AM/PM</label>
                                    </div>
                                    <div>
                                        <label class="font-weight-bold pdf-labels ml-1">___________________________________________</label>
                                    </div>
                                    <div class="mt-n1">
                                        <label class="pdf-labels ">Date/Time</label>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-block">
                                        <label class="font-weight-bold pdf-labels ml-1">_____________________</label>
                                        <label class="pdf-labels ">Appointment Location:</label>
                                    </div>
                                    <div class="d-block">
                                        <label class="font-weight-bold pdf-labels ml-0">_____________________</label>
                                        <label class="pdf-labels ">Store To Get Credit</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9 ml-5 mt-n1">
                                <div class="border d-block">
                                    <div class="order-form-row d-block mt-0">
                                        <div class="border-bottom">
                                            <label class="pdf-labels mb-3">Date</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-0">
                                        <div class="border-bottom">
                                            <label class="pdf-labels mb-3">Part#</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-0">
                                        <div class="border-bottom">
                                            <label class="pdf-labels mb-3">Color</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-0">
                                        <div class="border-bottom">
                                            <label class="pdf-labels mb-3">Type</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-0">
                                        <div class="border-bottom">
                                            <label class="pdf-labels mb-3">Shape</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-0">
                                        <div class="border-bottom">
                                            <label class="pdf-labels mb-3">Size</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-0">
                                        <div class="border-bottom">
                                            <label class="pdf-labels mb-3">Top Finish</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-0">
                                        <div class="border-bottom">
                                            <label class="pdf-labels mb-3">Base</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-0">
                                        <div class="border-bottom">
                                            <label class="pdf-labels mb-3">Base Finish</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-0">
                                        <div class="border-bottom">
                                            <label class="pdf-labels mb-3">Picture</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-0">
                                        <div class="">
                                            <label class="pdf-labels mb-4"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-7  d-block mt-4 ml-5">
                            <div class="justify-content-center">
                                <label class="pdf-title ">Customer To Fill Out</label>
                            </div>
                            <div class="border d-block">
                                <div class="order-form-row d-block mt-4">
                                    <div class="mb-3 border-bottom">
                                        <label class="pdf-labels mb-0">LAST NAME ON MONUMENT</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-4">
                                    <div class="mb-3 border-bottom">
                                        <label class="pdf-labels mb-0">PURCHASER</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-4">
                                    <div class="mb-3 border-bottom">
                                        <label class="pdf-labels mb-0">ADDRESS</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-4">
                                    <div class="mb-3 border-bottom">
                                        <label class="pdf-labels mb-0">CITY, STATE, ZIP</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-4">
                                    <div class="mb-3 border-bottom">
                                        <label class="pdf-labels mb-0">PHONE <span style="margin-left: 15rem !important;">ALT.PHONE</span></label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-4">
                                    <div class="mb-3 border-bottom">
                                        <label class="pdf-labels mb-0">EMAIL</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-4">
                                    <div class="mb-3 border-bottom">
                                        <label class="pdf-labels mb-0">NAME</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-4">
                                    <div class="mb-3 border-bottom">
                                        <label class="pdf-labels mb-0">BIRTH DATE <span style="margin-left: 12rem !important;">DEATH DATE</span></label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-4">
                                    <div class="mb-3 border-bottom">
                                        <label class="pdf-labels mb-0 ">2nd NAME (COMPANION STONE)</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-4">
                                    <div class="mb-3 border-bottom">
                                        <label class="pdf-labels mb-0">BIRTH DATE <span style="margin-left: 12rem !important;">DEATH DATE</span></label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-4">
                                    <div class="mb-3 border-bottom">
                                        <label class="pdf-labels mb-0">MARRIAGE DATE</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-4">
                                    <div class="mb-n1">
                                        <label class="pdf-labels mb-0">CEMETERY <span style="margin-left: 12rem !important;">CITY,STATE,ZIP</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="order-form-row ml-5">
                        <div class="col-5 d-block">
                            <div class="col-10 offset-1">
                                <div class="border d-block">
                                    <div class="order-form-row d-block mt-2">
                                        <div class="border-bottom justify-content-center">
                                            <label class="pdf-labels mb-1 ">Price</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-2">
                                        <div class="border-bottom justify-content-center">
                                            <label class="pdf-labels mb-1 ">Engraving</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-2">
                                        <div class=" border-bottom justify-content-center">
                                            <label class="pdf-labels mb-1">Back</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-2">
                                        <div class="border-bottom justify-content-center">
                                            <label class="pdf-labels mb-1">Adt. Lettering</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-2">
                                        <div class="border-bottom justify-content-center">
                                            <label class="pdf-labels mb-1 ">Laser Etching ( )</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-2">
                                        <div class=" border-bottom justify-content-center">
                                            <label class="pdf-labels mb-1">Apron</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-2">
                                        <div class="border-bottom justify-content-center">
                                            <label class="pdf-labels mb-1">Other</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-2">
                                        <div class="border-bottom justify-content-center">
                                            <label class="pdf-labels mb-1">Vases</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-2">
                                        <div class="border-bottom justify-content-center">
                                            <label class="pdf-labels mb-1">Setting</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-2">
                                        <div class="border-bottom justify-content-center">
                                            <label class="pdf-labels mb-1">Freight</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-4">
                                        <div class="border-bottom">
                                            <label class="pdf-labels mb-1"></label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-2">
                                        <div class="border-bottom justify-content-center">
                                            <label class="pdf-labels mb-1">Tax</label>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-n1">
                                        <div class="border-bottom justify-content-center">
                                            <h6 class="mb-0">Total $</h6>
                                        </div>
                                    </div>
                                    <div class="order-form-row d-block mt-4">
                                        <div class="">
                                            <label class="pdf-labels mb-0"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-7 d-block">
                            <div class="border col-11 pdf-custom-margin-div-image pb-2 justify-content-center">
                                <img class="ml-0 pdf-custom-margin-image" :src="'images/orderform-image.png'" />
                            </div>
                        </div>

                    </div>

                    <div class="order-form-row d-block mt-5" style="margin-left: 5rem !important;">
                        <div class="flex-grow-1 mt-5">
                            <label class="pdf-labels text-danger">Notes:</label>
                        </div>
                        <div class="flex-grow-1 mt-n3 ml-2">
                            <label class="font-weight-bold pdf-labels ml-0">__________________________________________________________________________________________________________________</label>
                        </div>
                        <div class="flex-grow-1 mt-5 ml-2">
                            <label class="font-weight-bold pdf-labels ml-0">__________________________________________________________________________________________________________________</label>
                        </div>

                    </div>


                </form>
            </div>
        </PDF>
        <div  class="custom-margin-form col-6">
            <form >
                <div class="order-form-row">
                    <div class="col-4 d-block">
                        <div class="d-block custom-div-top ml-4">
                            <div class="d-block">
                                <div class="justify-content-end mb-n3">
                                    <label class="labels " style="font-size: 9px !important;">AM/PM</label>
                                </div>
                                <div>
                                    <label class="font-weight-bold pdf-labels ml-1">_______________________________</label>
                                </div>
                                <div class="mt-n1">
                                    <label class="labels" style="font-size: 9px !important;">Date/Time</label>
                                </div>
                            </div>
                            <div>
                                <div class="d-block">
                                    <label class="font-weight-bold pdf-labels ml-1">______________</label>
                                    <label class="labels ml-1" style="font-size: 9px !important;">Appointment Location</label>
                                </div>
                                <div class="d-block">
                                    <label class="font-weight-bold pdf-labels ml-1">_______________</label>
                                    <label class="labels ml-1" style="font-size: 9px !important;">Store To Get Credit</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-9 ml-5 mt-n1">
                            <div class="border d-block">
                                <div class="order-form-row d-block mt-0">
                                    <div class="border-bottom">
                                        <label class="labels mb-3">Date</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-0">
                                    <div class="border-bottom">
                                        <label class="labels mb-3">Part#</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-0">
                                    <div class="border-bottom">
                                        <label class="labels mb-3">Color</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-0">
                                    <div class="border-bottom">
                                        <label class="labels mb-3">Type</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-0">
                                    <div class="border-bottom">
                                        <label class="labels mb-3">Shape</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-0">
                                    <div class="border-bottom">
                                        <label class="labels mb-3">Size</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-0">
                                    <div class="border-bottom">
                                        <label class="labels mb-3">Top Finish</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-0">
                                    <div class="border-bottom">
                                        <label class="labels mb-3">Base</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-0">
                                    <div class="border-bottom">
                                        <label class="labels mb-3">Base Finish</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-0">
                                    <div class="border-bottom">
                                        <label class="labels mb-3">Picture</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-0">
                                    <div class="">
                                        <label class="labels mb-4"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-7  d-block mt-4 ml-5">
                        <div class="justify-content-center">
                            <label class="title ">Customer To Fill Out</label>
                        </div>
                        <div class="border d-block">
                            <div class="order-form-row d-block mt-4">
                                <div class="mb-3 border-bottom">
                                    <label class="labels mb-0">LAST NAME ON MONUMENT</label>
                                </div>
                            </div>
                            <div class="order-form-row d-block mt-4">
                                <div class="mb-3 border-bottom">
                                    <label class="labels mb-0">PURCHASER</label>
                                </div>
                            </div>
                            <div class="order-form-row d-block mt-4">
                                <div class="mb-3 border-bottom">
                                    <label class="labels mb-0">ADDRESS</label>
                                </div>
                            </div>
                            <div class="order-form-row d-block mt-4">
                                <div class="mb-3 border-bottom">
                                    <label class="labels mb-0">CITY, STATE, ZIP</label>
                                </div>
                            </div>
                            <div class="order-form-row d-block mt-4">
                                <div class="mb-3 border-bottom">
                                    <label class="labels mb-0">PHONE <span style="margin-left: 9rem !important;">ALT.PHONE</span></label>
                                </div>
                            </div>
                            <div class="order-form-row d-block mt-4">
                                <div class="mb-3 border-bottom">
                                    <label class="labels mb-0">EMAIL</label>
                                </div>
                            </div>
                            <div class="order-form-row d-block mt-4">
                                <div class="mb-3 border-bottom">
                                    <label class="labels mb-0">NAME</label>
                                </div>
                            </div>
                            <div class="order-form-row d-block mt-4">
                                <div class="mb-3 border-bottom">
                                    <label class="labels mb-0">BIRTH DATE <span style="margin-left: 7rem !important;">DEATH DATE</span></label>
                                </div>
                            </div>
                            <div class="order-form-row d-block mt-4">
                                <div class="mb-3 border-bottom">
                                    <label class="labels mb-0 ">2nd NAME (COMPANION STONE)</label>
                                </div>
                            </div>
                            <div class="order-form-row d-block mt-4">
                                <div class="mb-3 border-bottom">
                                    <label class="labels mb-0">BIRTH DATE <span style="margin-left: 7rem !important;">DEATH DATE</span></label>
                                </div>
                            </div>
                            <div class="order-form-row d-block mt-4">
                                <div class="mb-3 border-bottom">
                                    <label class="labels mb-0">MARRIAGE DATE</label>
                                </div>
                            </div>
                            <div class="order-form-row d-block mt-4">
                                <div class="mb-n1">
                                    <label class="labels mb-0">CEMETERY <span style="margin-left: 7rem !important;">CITY,STATE,ZIP</span></label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="order-form-row ml-5">
                    <div class="col-5 d-block">
                        <div class="col-10 offset-1">
                            <div class="border d-block">
                                <div class="order-form-row d-block mt-2">
                                    <div class="border-bottom justify-content-center">
                                        <label class="labels mb-1 ">Price</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-2">
                                    <div class="border-bottom justify-content-center">
                                        <label class="labels mb-1 ">Engraving</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-2">
                                    <div class=" border-bottom justify-content-center">
                                        <label class="labels mb-1">Back</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-2">
                                    <div class="border-bottom justify-content-center">
                                        <label class="labels mb-1">Adt. Lettering</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-2">
                                    <div class="border-bottom justify-content-center">
                                        <label class="labels mb-1 ">Laser Etching ( )</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-2">
                                    <div class=" border-bottom justify-content-center">
                                        <label class="labels mb-1">Apron</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-2">
                                    <div class="border-bottom justify-content-center">
                                        <label class="labels mb-1">Other</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-2">
                                    <div class="border-bottom justify-content-center">
                                        <label class="labels mb-1">Vases</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-2">
                                    <div class="border-bottom justify-content-center">
                                        <label class="labels mb-1">Setting</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-2">
                                    <div class="border-bottom justify-content-center">
                                        <label class="labels mb-1">Freight</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-4">
                                    <div class="border-bottom">
                                        <label class="labels mb-1"></label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-2">
                                    <div class="border-bottom justify-content-center">
                                        <label class="labels mb-1">Tax</label>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-n1">
                                    <div class="border-bottom justify-content-center">
                                        <h6 class="mb-0">Total $</h6>
                                    </div>
                                </div>
                                <div class="order-form-row d-block mt-4">
                                    <div class="">
                                        <label class="labels mb-0"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-7 d-block">
                        <div class="border col-11 custom-margin-div-image pb-2 justify-content-center">
                            <img class="ml-0 custom-margin-image" :src="'images/orderform-image.png'" />
                        </div>
                    </div>

                </div>

                <div class="order-form-row d-block mt-5" style="margin-left: 5rem !important;">
                    <div class="flex-grow-1 mt-5">
                        <label class="labels text-danger">Notes:</label>
                    </div>
                    <div class="flex-grow-1 mt-n3 ml-2">
                        <label class="font-weight-bold labels ml-0">________________________________________________________________________________</label>
                    </div>
                    <div class="flex-grow-1 mt-5 ml-2">
                        <label class="font-weight-bold labels ml-0">________________________________________________________________________________</label>
                    </div>

                </div>


            </form>
            <div class="order-form-row ml-2">
                <div>
                    <button type="button" class="btn btn-sm btn-info custom-print-button ml-5 py-1 px-2" @click="printPDF">Print Preview</button>
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
                title: 'Printable Order Form'
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
        font-size: 12px !important;
    }
    .pdf-custom-margin-form{
        margin-top:3rem !important;
        margin-left: 2rem !important;
        margin-right: 2rem !important;
    }
    .pdf-title{
        font-family: Arial;
        font-style: normal;
        font-weight: 400;
        font-size: 20px !important;
        line-height: 25px;
        text-align: center;
        letter-spacing: 0.02em;
        color: #000000;
    }
    .pdf-custom-div-top{
        border:7px solid #FFFF00 !important;
    }

    .pdf-custom-margin-image{
        margin-top: 20.4rem !important;
    }

    .pdf-custom-margin-div-image{
        margin-left: .8rem !important;
    }

    .pdf label{
        display: block;
        font-size: 0.5em;
        margin-bottom: 0;
    }
    .form-width {
        width: 45rem !important;
    }

    .order-form-row
    {
        display: flex;
        padding: 0;
    }
    .order-form-row div
    {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }
    .order-form-row div  label{
        margin: auto 0.5rem;
        white-space: nowrap !important;
        color: #000 !important;
    }
    .order-form-row div input,textarea{
        border: 1px solid #C4C4C4 !important;
        margin: auto;
        margin-right: 0;
        font-size: 12px;
    }

    .labels{
        font-family: Arial;
        font-size: 12px !important;
    }
    .custom-margin-form{
        margin-top:3rem !important;
        margin: auto;
        /*margin-left: 20rem !important;
        margin-right: 2rem !important;*/
    }
    .title{
        font-family: Arial;
        font-style: normal;
        font-weight: 400;
        font-size: 18px !important;
        line-height: 25px;
        text-align: center;
        letter-spacing: 0.02em;
        color: #000000;
    }

    .custom-div-top{
        border:7px solid #FFFF00 !important;
    }

    .custom-margin-image{
        margin-top: 20.4rem !important;
    }

    .custom-margin-div-image{
        margin-left: .8rem !important;

    }
    .product-print{
        width: 39rem;
        height: auto;
        margin-top: 14.5rem !important;
        margin-bottom: 3px !important;
        margin-right: 2px !important;
        margin-left: 2px !important;
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
