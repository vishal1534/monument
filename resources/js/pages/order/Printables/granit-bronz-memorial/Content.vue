<template>

    <div>

        <div class="row">
            <div class="col-md-12">

                <form class="div-shadow bg-white rounded mx-n5 mb-2 p-3">
                    <div class="form-content">

                        <div class="granit-memorial-custom-border py-5">

                            <h5 class="font-weight-bold my-1 text-center"><u>Granit Bronz Memorial Order Form</u></h5>

                            <div class="granit-memorial-row m-2">
                                <div class="w-25">
                                    <label class="m-0 granit-memorial-custom-label">Date:</label>
                                    <div class="mx-2 granit-memorial-custom-border-bottom"></div>
                                </div>
                                <div class="w-25 ml-auto">
                                    <label class="m-0 granit-memorial-custom-label">Order No:</label>
                                    <div class="mx-2 granit-memorial-custom-border-bottom"></div>
                                </div>
                            </div>
                            <div class="granit-memorial-row m-2">
                                <div class="w-50">
                                    <label class="m-0 granit-memorial-custom-label">Purchaser:</label>
                                    <div class="mx-2 granit-memorial-custom-border-bottom"></div>
                                </div>
                                <div class="w-25"></div>
                                <div class="w-50 ml-auto">
                                    <label class="m-0 granit-memorial-custom-label">Customer Account #:</label>
                                    <div class="mx-2 granit-memorial-custom-border-bottom"></div>
                                </div>
                            </div>

                            <hr class="granit-memorial-custom-border-bottom">

                            <div class="granit-memorial-row mx-2">
                                <label class="font-weight-bold mr-4">Order Type:</label>
                                <b-form-group class="w-100 m-0 custom-radio-and-checkbox">
                                    <b-form-checkbox-group plain>
                                        <b-form-checkbox class="w-75" value="immediate-production">Enter for Immediate Production</b-form-checkbox>
                                        <b-form-checkbox class="w-50" value="warehousing">Warehousing</b-form-checkbox>
                                        <b-form-checkbox value="pre-need-protection">Register for Pre-need Protection</b-form-checkbox>
                                    </b-form-checkbox-group>
                                </b-form-group>
                            </div>

                            <hr class="granit-memorial-custom-border-bottom">

                            <div class="granit-memorial-row m-2">
                                <div>
                                    <label>Preneed Contract No.:</label>
                                    <div class="mx-2 granit-memorial-custom-border-bottom"></div>
                                </div>
                                <div>
                                    <label>Date of Initial Payment:</label>
                                    <div class="mx-2 granit-memorial-custom-border-bottom"></div>
                                </div>
                                <div>
                                    <label>Length of Contract:</label>
                                    <div class="granit-memorial-custom-border-bottom"></div>
                                    <label>(months)</label>
                                </div>
                            </div>

                            <hr class="granit-memorial-custom-border-bottom">

                            <div class="granit-memorial-row">

                                <div class="col-6 d-block pl-0 m-0 granit-memorial-custom-border-right">
                                    <div class="granit-memorial-row justify-content-center">
                                        <h5>Bronze Information</h5>
                                    </div>
                                    <div class="granit-memorial-row">
                                        <label class="font-weight-bold col-3 px-0">Bronze Design:</label>
                                        <div class="mx-2 granit-memorial-custom-border-bottom"></div>
                                    </div>
                                    <div class="granit-memorial-row">
                                        <label class="font-weight-bold col-3 px-0">Bronze Size:</label>
                                        <div class="mx-2 granit-memorial-custom-border-bottom"></div>
                                    </div>
                                </div>

                                <div class="col-6 d-block pl-0">
                                    <div class="granit-memorial-row justify-content-center">
                                        <h5>Granite Information</h5>
                                    </div>
                                    <div class="granit-memorial-row">
                                        <label class="font-weight-bold col-4">Granite Color:</label>
                                        <div class="mx-2 granit-memorial-custom-border-bottom"></div>
                                    </div>
                                    <div class="granit-memorial-row">
                                        <label class="font-weight-bold col-4">Granite Size:</label>
                                        <div class="mx-2 granit-memorial-custom-border-bottom"></div>
                                    </div>
                                    <div class="granit-memorial-row">
                                        <label class="font-weight-bold col-4">Granite Finish:</label>
                                        <div class="mx-2 granit-memorial-custom-border-bottom"></div>
                                    </div>
                                </div>

                            </div>

                            <hr class="granit-memorial-custom-border-bottom">

                            <div class="d-flex">

                                <div class="flex-column granit-memorial-custom-border-right px-2">
                                    <label class="font-weight-bold"><u>Vases</u></label>

                                    <b-form-group class="m-0 custom-radio-and-checkbox">
                                        <b-form-checkbox-group
                                            plain
                                            stacked>
                                            <b-form-group class="m-0">
                                                <b-form-checkbox value="patrician_vase"><label>Patrician Vase</label></b-form-checkbox>
                                                <b-form-checkbox value="garden_vase"><label>Garden Vase</label></b-form-checkbox>
                                                <b-form-checkbox class="text-nowrap" value="patrician_vase_guard"><label>Patrician Vase w/ Guard</label></b-form-checkbox>
                                                <b-form-checkbox value="garden_vase_guard"><label>Garden Vase w/ Guard</label></b-form-checkbox>
                                                <b-form-checkbox value="signature_vase"><label>**Signature Vase</label></b-form-checkbox>
                                                <b-form-checkbox value="regency_vase"><label>**Regency Vase</label></b-form-checkbox>
                                                <b-form-checkbox value="vase_ring">
                                                    <div class="granit-memorial-row">
                                                        <label>Vase Ring #</label>
                                                        <b-input class="h-100 pb-0 border-0 granit-memorial-custom-border-bottom" type="text" size="sm" ></b-input>
                                                    </div>
                                                </b-form-checkbox>
                                                <b-form-checkbox value="no_vase"><label>No Vase</label></b-form-checkbox>
                                                <b-form-checkbox value="other">
                                                    <div class="d-flex"><label>Other</label></div>
                                                </b-form-checkbox>
                                            </b-form-group>

                                        </b-form-checkbox-group>
                                    </b-form-group>
                                    <label class="font-weight-bold m-0">Note: Vases with ' ** '<br> (astericks) cost extra</label>
                                </div>

                                <div class="d-flex flex-wrap">

                                    <div class="granit-memorial-custom-border-right granit-memorial-custom-border-bottom px-2">

                                        <label class="font-weight-bold m-0"><u>Bronze Oxidation Colors</u></label>

                                        <b-form-group class="custom-radio-and-checkbox m-0">
                                            <b-form-checkbox-group
                                                class="d-flex"
                                                plain
                                                stacked>
                                                <b-form-group class="my-0">
                                                    <b-form-checkbox value="dark_brown"><label>Dark Brown</label></b-form-checkbox>
                                                    <b-form-checkbox value="golden_brown"><label>Golden Brown</label></b-form-checkbox>
                                                    <b-form-checkbox value="light_brown"><label>Light Brown</label></b-form-checkbox>
                                                    <b-form-checkbox value="veteran"><label>Veteran</label></b-form-checkbox>
                                                    <b-form-checkbox value="antique"><label>Antique**</label></b-form-checkbox>
                                                    <b-form-checkbox value="arbor_green"><label>Arbor Green**</label></b-form-checkbox>
                                                </b-form-group>
                                                <b-form-group class="my-0 mx-3">
                                                    <b-form-checkbox value="rose_red"><label>Rose Red</label></b-form-checkbox>
                                                    <b-form-checkbox value="emerald_green"><label>Emerald Green</label></b-form-checkbox>
                                                    <b-form-checkbox class="mb-4" value="black"><label>Black</label></b-form-checkbox>
                                                    <b-form-checkbox value="biscay"><label>Biscay**</label></b-form-checkbox>
                                                    <b-form-checkbox value="terra_rouge"><label>Terra Rouge**</label></b-form-checkbox>
                                                </b-form-group>
                                            </b-form-checkbox-group>
                                        </b-form-group>

                                        <label class="font-weight-bold m-0">Note: ** will incur an additional charge</label>

                                    </div>

                                    <div class="granit-memorial-custom-border-right granit-memorial-custom-border-bottom px-2">

                                        <label class="font-weight-bold m-0"><u>Letter Style</u></label>

                                        <b-form-group class="m-0 custom-radio-and-checkbox">
                                            <b-form-checkbox-group
                                                plain
                                                stacked>
                                                <b-form-group class="m-0">
                                                    <b-form-checkbox value="oval"><label>Oval</label></b-form-checkbox>
                                                    <b-form-checkbox value="flat"><label>Flat</label></b-form-checkbox>
                                                    <b-form-checkbox value="traditional"><label>Traditional</label></b-form-checkbox>
                                                    <b-form-checkbox value="veteran_flat"><label>Veteran Flat</label></b-form-checkbox>
                                                    <b-form-checkbox value="engraved_roman"><label>Engraved Roman</label></b-form-checkbox>
                                                    <b-form-checkbox value="engraved_script"><label>Engraved Script</label></b-form-checkbox>
                                                    <b-form-checkbox value="other"><label>Other</label></b-form-checkbox>
                                                </b-form-group>

                                            </b-form-checkbox-group>
                                        </b-form-group>

                                    </div>

                                    <div class="px-2 granit-memorial-custom-border-bottom">

                                        <label class="font-weight-bold m-0"><u>Scroll Type</u></label>

                                        <b-form-group class="m-0 custom-radio-and-checkbox">
                                            <b-form-checkbox-group
                                                plain
                                                stacked>
                                                <b-form-group class="m-0">
                                                    <b-form-checkbox value="split"><label>Split - Year Date Only/unless otherwise specified</label></b-form-checkbox>
                                                    <b-form-checkbox value="standard"><label>Standard Scroll (Extra for Preneed Scrolls)</label></b-form-checkbox>
                                                    <b-form-checkbox value="tri_scroll"><label>Tri - Scroll</label></b-form-checkbox>
                                                    <b-form-checkbox value="tri_scroll_date"><label>Tri - Scroll - Death Date Tab</label></b-form-checkbox>
                                                    <b-form-checkbox value="other"><label>Other</label></b-form-checkbox>
                                                </b-form-group>

                                            </b-form-checkbox-group>
                                        </b-form-group>

                                        <div class="granit-memorial-row m-0">
                                            <label class="mx-0">Scroll No.</label>
                                            <div class="granit-memorial-custom-border-bottom"></div>
                                        </div>

                                        <div class="granit-memorial-row m-0">
                                            <label class="mx-0">Original Order No.</label>
                                            <div class="granit-memorial-custom-border-bottom"></div>
                                        </div>
                                    </div>

                                    <div class="px-2">

                                        <div>
                                            <label class="font-weight-bold m-0 mt-2 d-block"><u>Custom Color Options</u></label>
                                            <label class="font-weight-bold m-0">Select Option “1” or “2” - ** custom colors will incs an additional charge **</label>
                                        </div>
                                        <div class="custom-radio-and-checkbox">
                                            <b-form-checkbox-group
                                                plain
                                                stacked>
                                                <b-form-checkbox value="custom-color" class="small">
                                                    <div class="granit-memorial-row mt-n2">
                                                        <span class="text-nowrap my-auto"><label class="m-0 label-sm">1. Custom Color</label></span>
                                                        <div>
                                                            <label class="m-0 ml-3 label-sm">Brand:</label>
                                                            <div class="granit-memorial-custom-border-bottom px-5"></div>
                                                        </div>

                                                        <div class="mx-1">
                                                            <label class="m-0 label-sm">Color:</label>
                                                            <div class="granit-memorial-custom-border-bottom px-5"></div>
                                                        </div>

                                                        <div class="mx-1">
                                                            <label class="m-0 label-sm">Color #:</label>
                                                            <div class="granit-memorial-custom-border-bottom px-5"></div>
                                                        </div>

                                                    </div>
                                                </b-form-checkbox>

                                                <b-form-checkbox value="custom-color-swatch">
                                                    <label class="label-sm">2. Custom Color - Swatch w/Order <span class="font-weight-bold ml-5"> *No cloth, printed or photocopied color paper can be used for swatch*</span></label>
                                                </b-form-checkbox>

                                            </b-form-checkbox-group>

                                        </div>

                                    </div>

                                </div>


                            </div>

                            <hr class="granit-memorial-custom-border-bottom">

                            <div class="granit-memorial-row px-5">
                                <b-form-group class="w-100 m-0 custom-radio-and-checkbox">
                                    <b-form-checkbox-group plain>
                                        <b-form-checkbox value="best-appearance">Layout for Best Appearance</b-form-checkbox>
                                        <b-form-checkbox value="no-change">No Layout Change</b-form-checkbox>
                                        <b-form-checkbox value="approval-on-drawing-required">Approval on Drawing Required</b-form-checkbox>
                                    </b-form-checkbox-group>
                                </b-form-group>
                            </div>

                            <hr class="granit-memorial-custom-border-bottom">

                            <div class="granit-memorial-row">
                                <div class="col-9 m-0 granit-memorial-custom-border-right">
                                    <label class="font-weight-bold m-0">Inscription:</label>
                                    <label class="m-0 mx-2">Type or print all information. Sketch on back (if more space is needed)</label>
                                </div>

                                <div class="flex-column">
                                    <div>
                                        <label class="font-weight-bold">Emblems:</label>
                                        <label class="m-0">Include placement</label>
                                    </div>

                                    <div class="d-block">
                                        <label>1.</label>
                                        <div class="m-0 granit-memorial-custom-border-bottom"></div>
                                    </div>
                                    <div class="d-block">
                                        <label>2.</label>
                                        <div class="m-0 granit-memorial-custom-border-bottom"></div>
                                    </div>
                                    <div class="d-block">
                                        <label>3.</label>
                                        <div class="m-0 granit-memorial-custom-border-bottom"></div>
                                    </div>
                                    <div class="d-block">
                                        <label>4.</label>
                                        <div class="m-0 granit-memorial-custom-border-bottom"></div>
                                    </div>
                                    <div class="d-block">
                                        <label>5.</label>
                                        <div class="m-0 granit-memorial-custom-border-bottom"></div>
                                    </div>
                                </div>
                            </div>

                            <hr class="granit-memorial-custom-border-bottom">

                            <div class="d-flex">

                                <div class="col-6 p-0">

                                    <div class="granit-memorial-custom-border-bottom">
                                        <div class="granit-memorial-row mx-2">
                                            <label class="font-weight-bold m-0">SHIPPING ADDRESS: </label>
                                        </div>
                                        <div class="granit-memorial-row mt-5 mx-2">
                                            <label class="m-0 label-sm">For prompt handling use your Granite Bronze Account No.</label>
                                            <div class="granit-memorial-custom-border-bottom mx-2"></div>
                                        </div>
                                    </div>

                                    <div class="granit-memorial-custom-border-bottom">
                                        <div class="granit-memorial-row mx-2">
                                            <label class="font-weight-bold m-0 mb-5">INVOICING ADDRESS: </label>
                                        </div>
                                    </div>

                                    <div class="mx-2">
                                        <div class="granit-memorial-row mt-2">
                                            <label class="font-weight-bold mx-0">Ordered By:</label>
                                            <div class="granit-memorial-custom-border-bottom mx-2"></div>
                                        </div>
                                        <div class="granit-memorial-row">
                                            <label class="col-2 p-0 font-weight-bold mx-0">Email:</label>
                                            <label>gbmem@coldspringgranite.com</label>
                                        </div>
                                        <div class="granit-memorial-row">
                                            <label class="col-2 p-0 font-weight-bold mx-0">Fax:</label>
                                            <label>800-873-8122</label>

                                            <label>Phone:</label>
                                            <label>800-328-2312</label>
                                        </div>
                                        <div class="granit-memorial-row mt-2">
                                            <label class="col-2 p-0 mx-0"></label>
                                            <label>Fill in appropriately and mail to:</label>
                                            <label class="font-weight-bold mx-2 my-0">GRANIT BRONZ, INC. 17482 Granite West Road, Cold Spring, MN 56320-4578</label>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-3 p-0 granit-memorial-custom-border-bottom granit-memorial-custom-border-right granit-memorial-custom-border-left h-100">
                                    <div class="granit-memorial-row flex-column">
                                        <div class="mb-5">
                                            <label class="font-weight-bold mx-1">Granit Bronz Section:</label>
                                        </div>

                                        <div class="flex-column px-2 mt-5 granit-memorial-custom-border-top">
                                            <div class="mt-3">
                                                <label class="m-0">1.</label>
                                                <div class="granit-memorial-custom-border-bottom"></div>
                                            </div>
                                            <div class="m-0">
                                                <label class="m-0">2.</label>
                                                <div class="m-0 granit-memorial-custom-border-bottom"></div>
                                            </div>
                                            <div>
                                                <label class="m-0">3.</label>
                                                <div class="m-0 granit-memorial-custom-border-bottom"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-2 h-100">
                                    <div class="granit-memorial-row">
                                        <label class="font-weight-bold m-0">Cemetery:</label>
                                        <label class="mx-1">Compute price here</label>
                                    </div>
                                    <div>
                                        <div class="granit-memorial-row">
                                            <label class="col-6 d-flex p-0 mx-0 label-sm">Price: <div class="granit-memorial-custom-dotted-border-bottom mx-1"></div></label>
                                            <label class="mx-0">$</label><div class="granit-memorial-custom-border-bottom"></div>
                                        </div>
                                        <div class="granit-memorial-row">
                                            <label class="col-6 d-flex p-0 mx-0 label-sm">Scrolls: <div class="granit-memorial-custom-dotted-border-bottom mx-1"></div></label>
                                            <label class="mx-0">$</label><div class="granit-memorial-custom-border-bottom"></div>
                                        </div>
                                        <div class="granit-memorial-row">
                                            <label class="col-6 d-flex p-0 mx-0 label-sm">Extra Lettering: <div class="granit-memorial-custom-dotted-border-bottom mx-1"></div></label>
                                            <label class="mx-0">$</label><div class="granit-memorial-custom-border-bottom"></div>
                                        </div>
                                        <div class="granit-memorial-row">
                                            <label class="col-6 d-flex p-0 mx-0 label-sm">Graphic Color: <div class="granit-memorial-custom-dotted-border-bottom mx-1"></div></label>
                                            <label class="mx-0">$</label><div class="granit-memorial-custom-border-bottom"></div>
                                        </div>
                                        <div class="granit-memorial-row">
                                            <label class="col-6 d-flex p-0 mx-0 label-sm">Miscellaneous: <div class="granit-memorial-custom-dotted-border-bottom mx-1"></div></label>
                                            <label class="mx-0">$</label><div class="granit-memorial-custom-border-bottom"></div>
                                        </div>
                                        <div class="granit-memorial-row">
                                            <label class="col-6 d-flex p-0 mx-0 label-sm font-weight-bold">Tax: <div class="granit-memorial-custom-dotted-border-bottom mx-1"></div></label>
                                            <label class="mx-0">$</label><div class="granit-memorial-custom-border-bottom"></div>
                                        </div>
                                        <div class="granit-memorial-row">
                                            <label class="col-6 d-flex p-0 mx-0 label-sm font-weight-bold">TOTAL: <div class="granit-memorial-custom-dotted-border-bottom mx-1"></div></label>
                                            <label class="mx-0">$</label><div class="granit-memorial-custom-border-bottom"></div>
                                        </div>

                                        <div class="granit-memorial-row mt-3">
                                                <label class="col-6 d-flex p-0 m-0 label-sm">PAID w/Order:<div class="granit-memorial-custom-dotted-border-bottom mx-1"></div></label>
                                                <label class="mx-0">$</label><div class="granit-memorial-custom-border-bottom"></div>
                                            </div>
                                        <div class="granit-memorial-row">
                                                <label class="col-6 d-flex p-0 mx-0 label-sm font-weight-bold">BALANCE DUE:<div class="granit-memorial-custom-dotted-border-bottom mx-1"></div></label>
                                                <label class="mx-0">$</label><div class="granit-memorial-custom-border-bottom"></div>
                                            </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="granit-memorial-row non-print-elm mt-2">
                            <button type="button" class="btn btn-sm btn-info custom-print-button  px-2" @click="printPDF">Print Preview</button>
                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

</template>

<script>
import {event, eventBus} from "../../../../event-bus/event-bus";

export default {
    name: "Content",
    computed:{
    },
    data(){
        return {
        }
    },
    methods:{
        printPDF(){
            eventBus.$emit(event.PRINT_PDF)
        },
    }

}
</script>

<style scoped>
.form-content{
    margin: 0 auto;
    width: 55rem;
}
.granit-memorial-row
{
    display: flex;
    padding: 0;
}
.granit-memorial-row div
{
    display: flex;
    margin: 0.3rem 0;
    width: 100%;
}
.granit-memorial-row label{
    margin: auto 0.7rem;
    white-space: nowrap !important;
    color: #000;
}
.granit-memorial-row div input{
    margin: auto;
    margin-right: 0;
    height: 1.5rem;
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
fieldset label{
    font-size: 0.7rem !important;
    margin: 0 !important;
}
.label-sm{
    font-size: 0.7rem !important;
}
.granit-memorial-custom-label{
    font-family: "Arial" !important;
}
.granit-memorial-custom-border{
    border: 1px solid #000 !important;
}
.granit-memorial-custom-border-left{
    border-left: 1px solid #000 !important;
}
.granit-memorial-custom-border-bottom{
    border-bottom: 1px solid #000 !important;
}
.granit-memorial-custom-border-right{
    border-right: 1px solid #000 !important;
}
.granit-memorial-custom-border-top{
    border-top: 1px solid #000 !important;
}
.granit-memorial-custom-dotted-border-bottom{
    border-bottom: 1px dotted #000 !important;
}

.printing input, .printing textarea{
    border-color: inherit !important;
}

</style>
