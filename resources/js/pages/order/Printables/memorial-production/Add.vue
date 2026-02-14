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
                <h2 class="pdf-title col-md-12 mt-0" >MEMORIAL PRODUCTION FORM</h2>
                <form  class="pdf-fields">
                    <div class="work-order-row flex-grow-1 mt-2">
                        <div class="custom-div-size1">
                            <label class="pdf-labels">CUSTOMER NAME:</label>
                            <label class="pdf-labels ml-0" style="font-weight: 700 !important;">____________________________________________</label>
                        </div>
                        <div class="pdf-custom-div-size2 pdf-margin-date">
                            <label class="pdf-labels">DATE:</label>
                            <label class="pdf-labels ml-n1" style="font-weight: 700 !important;">___________________________________</label>
                        </div>
                    </div>
                    <div class="work-order-row d-block mt-2">
                        <div class="flex-grow-1">
                            <label class="pdf-labels">NAME:</label>
                            <label class="pdf-labels ml-n1" style="font-weight: 700 !important;">________________________________________________________________________________________________</label>
                        </div>
                    </div>
                    <div class="work-order-row flex-grow-1 mt-2">
                        <div class="pdf-custom-div-size2">
                            <label class="pdf-labels">ADDRESS:</label>
                            <label class="pdf-labels ml-n1" style="font-weight: 700 !important;">_________________________________</label>
                        </div>
                        <div class="pdf-custom-div-size2 pdf-margin-customer">
                            <label class="pdf-labels ">CUSTOMER REF# / LAST NAME:</label>
                            <label class="pdf-labels ml-n1" style="font-weight: 700 !important;">_______________________________</label>
                        </div>
                    </div>
                    <div class="work-order-row flex-grow-1 mt-2">
                        <div class="pdf-custom-div-size3">
                            <label class="pdf-labels">SHIP TO ADDRESS #:</label>
                            <label class="pdf-labels ml-n1" style="font-weight: 700 !important;">____________________________________________________</label>
                        </div>
                        <div class="pdf-custom-div-size3 pdf-margin-trucking">
                            <label class="pdf-labels">TRUCKING:</label>
                            <label class="pdf-labels ml-n2" style="font-weight: 700 !important;">______________________</label>
                        </div>
                    </div>
                    <div class="work-order-row d-block mt-2">
                        <div class="flex-grow-1">
                            <label class="pdf-labels">REQUEST DATE:</label>
                            <label class="pdf-labels ml-n2" style="font-weight: 700 !important;">_____________________________________________</label>
                        </div>
                    </div>
                    <div class="work-order-row d-block mt-2">
                        <div class="flex-grow-1">
                            <label class="pdf-labels">SALES/CUSTOMER CARE REP:</label>
                            <label class="pdf-labels ml-n2" style="font-weight: 700 !important;">______________________________</label>
                        </div>
                    </div>
                    <div class="work-order-row d-block mt-1 custom-border" style="border:2px solid black !important;">
                        <div class="custom-border-bottom my-0">
                            <div class="col-1 custom-border-right my-0 p-1 justify-content-center"><label class="">Source</label></div>
                            <div class="col-3 custom-border-right my-0 p-1  justify-content-center"><label class="">Order Entry ONLY</label></div>
                            <div class="col-2 custom-border-right my-0 p-1 justify-content-center"><label class="">COLOR</label></div>
                            <div class="col-6 my-0 p-1"><label class="">SIZE AND DESCRIPTION <span class="ml-2">(Length x Width x Height)</span> <span class="ml-2">(Feet & Inches)</span></label></div>
                        </div>
                        <div class="custom-border-bottom">
                            <div class="col-1 custom-border-right my-n1">
                                <b-form-input type="text" size="sm"></b-form-input>
                            </div>
                            <div class="col-3 custom-border-right my-n1">
                                <b-form-input type="text" size="sm"></b-form-input>
                            </div>
                            <div class="col-2 custom-border-right my-n1">
                                <b-form-input type="text" size="sm"></b-form-input>
                            </div>
                            <div class="col-6 d-block">
                                <div>
                                    <b-form-input type="text" size="sm"></b-form-input>
                                </div>
                                <hr class="my-2 col-12 ml-n3 hr-border">
                                <div>
                                    <b-form-input type="text" size="sm"></b-form-input>
                                </div>
                            </div>
                        </div>
                        <div class="custom-border-bottom">
                            <div class="col-1 custom-border-right my-n1">
                                <b-form-input type="text" size="sm"></b-form-input>
                            </div>
                            <div class="col-3 custom-border-right my-n1">
                                <b-form-input type="text" size="sm"></b-form-input>
                            </div>
                            <div class="col-2 custom-border-right my-n1">
                                <b-form-input type="text" size="sm"></b-form-input>
                            </div>
                            <div class="col-6 d-block">
                                <div>
                                    <b-form-input type="text" size="sm"></b-form-input>
                                </div>
                                <hr class="my-2 col-12 ml-n3 hr-border">
                                <div>
                                    <b-form-input type="text" size="sm"></b-form-input>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="col-1 custom-border-right my-n1">
                                <b-form-input type="text" size="sm"></b-form-input>
                            </div>
                            <div class="col-3 custom-border-right my-n1">
                                <b-form-input type="text" size="sm"></b-form-input>
                            </div>
                            <div class="col-2 custom-border-right my-n1">
                                <b-form-input type="text" size="sm"></b-form-input>
                            </div>
                            <div class="col-6 d-block">
                                <div>
                                    <b-form-input type="text" size="sm"></b-form-input>
                                </div>
                                <hr class="my-2 col-12 ml-n3 hr-border">
                                <div>
                                    <b-form-input type="text" size="sm"></b-form-input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-block work-order-row mt-0">
                        <div class="custom-border-bottom mt-n1">
                            <div class="col-6 custom-border-right mb-0">
                                <div class="d-block">
                                    <div>
                                        <div class="d-block custom-carving-row-div ml-n3">
                                            <label class="ml-0">DESIGN AND CARVING STYLES</label>
                                            <b-form-checkbox  class="mt-5 mb-3 custom-checkbox memorial-production-pdf-checkbox">
                                                None
                                            </b-form-checkbox>
                                            <b-form-checkbox  class="my-3 custom-checkbox memorial-production-pdf-checkbox">
                                                Flat Curve
                                            </b-form-checkbox>
                                            <b-form-checkbox  class="my-3 custom-checkbox memorial-production-pdf-checkbox">
                                                Shape Curve
                                            </b-form-checkbox>
                                            <b-form-checkbox  class="my-3 custom-checkbox memorial-production-pdf-checkbox">
                                                Deluxe Curve (Add’l Charge)
                                            </b-form-checkbox>
                                            <b-form-checkbox  class="my-3 custom-checkbox memorial-production-pdf-checkbox">
                                                Skin Sunk
                                            </b-form-checkbox>
                                            <b-form-checkbox  class="my-3 custom-checkbox memorial-production-pdf-checkbox">
                                                Precision Carve
                                            </b-form-checkbox>
                                            <b-form-checkbox  class="my-3 custom-checkbox memorial-production-pdf-checkbox">
                                                Hand Diamond Etch
                                            </b-form-checkbox>
                                            <b-form-checkbox  class="my-3 custom-checkbox memorial-production-pdf-checkbox">
                                                Laser Etch
                                            </b-form-checkbox>
                                        </div>
                                        <div class="d-block ">
                                            <div class="justify-content-center"><label class="ml-0">Description - use name and number
                                                <br><span class="ml-5">Example: BARN02002</span></label></div>
                                            <b-form-input type="text" class="my-2" size="sm" ></b-form-input>
                                            <hr class="my-2 col-12 ml-n3 hr-border">
                                            <b-form-input type="text" class="my-2" size="sm" ></b-form-input>
                                            <hr class="my-2 col-12 ml-n3 hr-border">
                                            <b-form-input type="text" class="my-2" size="sm" ></b-form-input>
                                            <hr class="my-2 col-12 ml-n3 hr-border">
                                            <b-form-input type="text" class="my-2" size="sm" ></b-form-input>
                                            <hr class="my-2 col-12 ml-n3 hr-border">
                                            <b-form-input type="text" class="my-2" size="sm" ></b-form-input>
                                            <hr class="my-2 col-12 ml-n3 hr-border">
                                            <b-form-input type="text" class="my-2" size="sm" ></b-form-input>
                                            <hr class="my-2 col-12 ml-n3 hr-border">
                                            <b-form-input type="text" class="my-2" size="sm" ></b-form-input>
                                            <hr class="my-2 col-12 ml-n3 hr-border">
                                            <b-form-input type="text" class="my-2" size="sm"></b-form-input>
                                            <hr class="my-2 col-12 ml-n3 hr-border">
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <div class="my-n2">
                                            <label class="col-8 ml-n3">Attach Precious Portrait:</label>
                                            <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox" >
                                                Yes
                                            </b-form-checkbox>
                                            <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                No
                                            </b-form-checkbox>
                                        </div>
                                        <div class="my-n2">
                                            <label class="col-8  ml-n3">Recess area for Precious Portrait:</label>
                                            <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                Yes
                                            </b-form-checkbox>
                                            <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                No
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-block">
                                    <div class="my-2 d-block">
                                        <div class="ml-n3">
                                            <div class="col-4">
                                                <label class="ml-0">Panels</label>
                                            </div>
                                            <div class="col-1">
                                                <label class="ml-0">FN</label>
                                            </div>
                                            <div class="col-1">
                                                <label class="ml-0">INS</label>
                                            </div>
                                            <div class="col-1">
                                                <label class="ml-0">VRS</label>
                                            </div>
                                        </div>
                                        <div class="my-n3 ml-n3">
                                            <div class="col-4">
                                                <label class="ml-0">No Panel(s)</label>
                                            </div>
                                            <div class="col-1">

                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div class="col-1">
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div class="col-1">
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="my-n3 ml-n3">
                                            <div class="col-4">
                                                <label class="ml-0">Single Line</label>
                                            </div>
                                            <div class="col-1">

                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div class="col-1">
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div class="col-1">
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="my-n3 ml-n3">
                                            <div class="col-4">
                                                <label class="ml-0">Double Line</label>
                                            </div>
                                            <div class="col-1">

                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div class="col-1">
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div class="col-1">
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="my-n3 ml-n3">
                                            <div class="col-4">
                                                <label class="ml-0">Other: _______________</label>
                                            </div>
                                            <div class="col-1">
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div class="col-1">
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div class="col-1">
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="my-n3 ml-n3">
                                            <div class="col-4">
                                                <label class="ml-0">Other: _______________</label>
                                            </div>
                                            <div class="col-1">

                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div class="col-1">
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div class="col-1">
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="col-10 ml-n3 hr-border">
                                    <div class="my-2">
                                        <div class="d-block col-6 ml-n3">
                                            <label class=" ml-0">DARKENING AGENT</label>
                                            <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                No Artificial Agent
                                            </b-form-checkbox>
                                            <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                Transparent Gray Shadow
                                            </b-form-checkbox>
                                            <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                Dark Gray Shadow
                                            </b-form-checkbox>
                                            <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                Black Shadow
                                            </b-form-checkbox>
                                        </div>
                                        <div class="d-block col-6">
                                            <label class=" ml-0">WHITENING AGENT</label>
                                            <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                No Artificial Agent
                                            </b-form-checkbox>
                                            <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                Hilite
                                            </b-form-checkbox>
                                            <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                Heavy Hilite
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="custom-border-bottom mt-n2">
                            <div class="col-6 custom-border-right d-block mt-0 mb-0">
                                <div>
                                    <div class="col-5">
                                        <label class=" ml-n3">LETTERING FONTS</label>
                                    </div>
                                    <div>
                                        <label class="ml-0 font-weight-bold" style="font-size: 12px !important;">*See design book for Letter Font size limitations</label>
                                    </div>
                                </div>
                                <div>
                                    <div class="col-5">
                                        <label class=" ml-0"></label>
                                    </div>
                                    <div class="col-2">
                                        <label class="ml-n3">Fam Name</label>
                                    </div>
                                    <div class="col-2">
                                        <label class="ml-n2">Inscript</label>
                                    </div>
                                    <div class="col-2">
                                        <label class="ml-n2">Verse</label>
                                    </div>
                                </div>
                                <div class="my-n3">
                                    <div class="col-5">
                                        <label class="ml-n3" style="font-family: 'apple-chancery';">Apple Chancery</label>
                                    </div>
                                    <div class="col-2">

                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox" >
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                </div>
                                <div class="my-n3">
                                    <div class="col-5">
                                        <label class="ml-n3" style="font-family: tartine-script-regular;">Tartine Script Regular</label>
                                    </div>
                                    <div class="col-2">

                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                </div>
                                <div class="my-n3">
                                    <div class="col-5">
                                        <label class="ml-n3" style="font-family: government">GOVERNMENT</label>
                                    </div>
                                    <div class="col-2">

                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                </div>
                                <div class="my-n3">
                                    <div class="col-5">
                                        <label class="ml-n3" style="font-family: regular-roman">REGULAR ROMAN</label>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                </div>
                                <div class="my-n3">
                                    <div class="col-5">
                                        <label class="ml-n3" style="font-family: roman-condensed">ROMAN CONDENSED</label>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                </div>
                                <div class="my-n3">
                                    <div class="col-5">
                                        <label class="ml-n3" style="font-family: roman-more-condensed">ROMAN MORE CONDENSED</label>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                </div>
                                <div class="my-n3">
                                    <div class="col-5">
                                        <label class="ml-n3" style="font-family: alternate-gothic">Alternate Gothic No. 3D</label>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                </div>
                                <!--<div class="my-n3">
                                    <div class="col-5">
                                        <label class="ml-n3">VERMARCO</label>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                </div>
                                <div class="my-n3">
                                    <div class="col-5">
                                        <label class="ml-n3">COMMON GOTHIC</label>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                </div>-->
                                <div class="">
                                    <div class="col-5">
                                        <label class="ml-n3">Other: _________________</label>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                    <div class="col-2">
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                        </b-form-checkbox>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-block">
                                <div class="col-5 mt-1">
                                    <label class="ml-n3">LETTER CARVING STYLES</label>
                                </div>
                                <div class="">
                                    <div class="d-block">
                                        <div>
                                            <div class="col-7">
                                                <label class="ml-n3"></label>
                                            </div>
                                            <div>
                                                <label class="ml-0">FN</label>
                                            </div>
                                            <div>
                                                <label class="ml-0">INS</label>
                                            </div>
                                            <div>
                                                <label class="ml-0">VRS</label>
                                            </div>
                                        </div>
                                        <div class="my-n3">
                                            <div class="col-7">
                                                <label class="ml-n3">V - Sunk</label>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="my-n3">
                                            <div class="col-7">
                                                <label class="ml-n3">U - Sunk</label>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="my-n3">
                                            <div class="col-7">
                                                <label class="ml-n3">Shallow Sunk 1/16”</label>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="my-n2">
                                            <div class="col-7">
                                                <label class="ml-n3">Skin Sunk 1/32”</label>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <hr class="col-12 ml-n3 hr-border">
                                        <div class="my-1">
                                            <div class="col-7 mt-2">
                                                <label class="ml-n3">Polish Raised<br>
                                                    (not cleaned)</label>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="my-1 mt-n2">
                                            <div class="col-7 ">
                                                <label class="ml-n3">Polished Raised<br>
                                                    (cleaned) (additional charge)</label>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="mt-0 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="mt-0 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="mt-0 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="my-n2">
                                            <div class="justify-content-center">
                                                <label class="ml-0 text-center">(Use Square Raised (not listed)
                                                    <br>or Helvetica 1” min.)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-block">
                                        <div>
                                            <div class="col-6">
                                                <label class="ml-0"></label>
                                            </div>
                                            <div>
                                                <label class="ml-0">FN</label>
                                            </div>
                                            <div>
                                                <label class="ml-0">INS</label>
                                            </div>
                                            <div>
                                                <label class="ml-0">VRS</label>
                                            </div>
                                        </div>
                                        <div class="my-n3">
                                            <div class="col-6">
                                                <label class="ml-0">Frosted Inlaid*</label>
                                            </div>
                                            <div>

                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="my-n3">
                                            <div class="col-6">
                                                <label class="ml-0">Polish Inlaid*</label>
                                            </div>
                                            <div>

                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="my-n3">
                                            <div class="col-6">
                                                <label class="ml-0">Frosted Edge*</label>
                                            </div>
                                            <div>

                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="my-n3">
                                            <div class="col-6">
                                                <label class="ml-0">Polish Edge*</label>
                                            </div>
                                            <div>

                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="my-n3">
                                            <div class="col-6">
                                                <label class="ml-0">Shadow Bar*</label>
                                            </div>
                                            <div>

                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                            <div>
                                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-pdf-checkbox">
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="mt-5">
                                            <div class="justify-content-center mt-n1">
                                                <label class="ml-0 text-center" style="font-size: 12px !important;">*Above carving styles use a Modified Roman<br>
                                                    Font; Frosted Inlaid may use Connected Script<br>
                                                    or Opti SB. Use of other fonts, for these carving<br>
                                                    styles, is considered custom and will incur<br>
                                                    additional charges.</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </form>
            </div>

        </PDF>

        <div  class="custom-margin-form col-6">
            <h2 class="title col-md-12 mt-0" >MEMORIAL PRODUCTION FORM</h2>
            <form  class="fields">
                <div class="work-order-row flex-grow-1 mt-2 ml-n2">
                    <div class="custom-div-size1">
                        <label class="labels">CUSTOMER NAME:</label>
                        <label class="labels ml-0" style="font-weight: 700 !important;">____________________________________________</label>
                    </div>
                    <div class="pdf-custom-div-size2 margin-date">
                        <label class="labels">DATE:</label>
                        <label class="labels ml-n1" style="font-weight: 700 !important;">___________________________________</label>
                    </div>
                </div>
                <div class="work-order-row d-block mt-2 ml-n2">
                    <div class="flex-grow-1">
                        <label class="labels">NAME:</label>
                        <label class="labels ml-n1" style="font-weight: 700 !important;">_________________________________________________________________________________________________</label>
                    </div>
                </div>
                <div class="work-order-row flex-grow-1 mt-2 ml-n2">
                    <div class="custom-div-size2">
                        <label class="labels">ADDRESS:</label>
                        <label class="labels ml-n1" style="font-weight: 700 !important;">_________________________________</label>
                    </div>
                    <div class="custom-div-size2 margin-customer">
                        <label class="labels ">CUSTOMER REF# / LAST NAME:</label>
                        <label class="labels ml-n1" style="font-weight: 700 !important;">________________________________</label>
                    </div>
                </div>
                <div class="work-order-row flex-grow-1 mt-2 ml-n2">
                    <div class="custom-div-size3">
                        <label class="labels">SHIP TO ADDRESS #:</label>
                        <label class="labels ml-n2" style="font-weight: 700 !important;">____________________________________________________</label>
                    </div>
                    <div class="custom-div-size3 margin-trucking">
                        <label class="labels ml-1">TRUCKING:</label>
                        <label class="labels ml-n2" style="font-weight: 700 !important;">_______________________</label>
                    </div>
                </div>
                <div class="work-order-row d-block mt-2 ml-n2">
                    <div class="flex-grow-1">
                        <label class="labels">REQUEST DATE:</label>
                        <label class="labels ml-n2" style="font-weight: 700 !important;">_____________________________________________</label>
                    </div>
                </div>
                <div class="work-order-row d-block mt-2 ml-n2">
                    <div class="flex-grow-1">
                        <label class="labels">SALES/CUSTOMER CARE REP:</label>
                        <label class="labels ml-n2" style="font-weight: 700 !important;">______________________________</label>
                    </div>
                </div>
                <div class="work-order-row d-block mt-1 custom-border" style="border:2px solid black !important;">
                    <div class="custom-border-bottom my-0">
                        <div class="col-1 custom-border-right my-0 p-1 justify-content-center"><label class="">Source</label></div>
                        <div class="col-3 custom-border-right my-0 p-1  justify-content-center"><label class="">Order Entry ONLY</label></div>
                        <div class="col-2 custom-border-right my-0 p-1 justify-content-center"><label class="">COLOR</label></div>
                        <div class="col-6 my-0 p-1"><label class="">SIZE AND DESCRIPTION <span class="ml-2">(Length x Width x Height)</span> <span class="ml-2">(Feet & Inches)</span></label></div>
                    </div>
                    <div class="custom-border-bottom">
                        <div class="col-1 custom-border-right my-n1">
                            <b-form-input type="text" size="sm"></b-form-input>
                        </div>
                        <div class="col-3 custom-border-right my-n1">
                            <b-form-input type="text" size="sm"></b-form-input>
                        </div>
                        <div class="col-2 custom-border-right my-n1">
                            <b-form-input type="text" size="sm"></b-form-input>
                        </div>
                        <div class="col-6 d-block">
                            <div>
                                <b-form-input type="text" size="sm"></b-form-input>
                            </div>
                            <hr class="my-2 col-12 ml-n3 hr-border">
                            <div>
                                <b-form-input type="text" size="sm"></b-form-input>
                            </div>
                        </div>
                    </div>
                    <div class="custom-border-bottom">
                        <div class="col-1 custom-border-right my-n1">
                            <b-form-input type="text" size="sm"></b-form-input>
                        </div>
                        <div class="col-3 custom-border-right my-n1">
                            <b-form-input type="text" size="sm"></b-form-input>
                        </div>
                        <div class="col-2 custom-border-right my-n1">
                            <b-form-input type="text" size="sm"></b-form-input>
                        </div>
                        <div class="col-6 d-block">
                            <div>
                                <b-form-input type="text" size="sm"></b-form-input>
                            </div>
                            <hr class="my-2 col-12 ml-n3 hr-border">
                            <div>
                                <b-form-input type="text" size="sm"></b-form-input>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="col-1 custom-border-right my-n1">
                            <b-form-input type="text" size="sm"></b-form-input>
                        </div>
                        <div class="col-3 custom-border-right my-n1">
                            <b-form-input type="text" size="sm"></b-form-input>
                        </div>
                        <div class="col-2 custom-border-right my-n1">
                            <b-form-input type="text" size="sm"></b-form-input>
                        </div>
                        <div class="col-6 d-block">
                            <div>
                                <b-form-input type="text" size="sm"></b-form-input>
                            </div>
                            <hr class="my-2 col-12 ml-n3 hr-border">
                            <div>
                                <b-form-input type="text" size="sm"></b-form-input>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-block work-order-row mt-0">
                    <div class="custom-border-bottom mt-n1">
                        <div class="col-6 custom-border-right mb-0">
                            <div class="d-block">
                                <div>
                                    <div class="d-block custom-carving-row-div ml-n3">
                                        <label class="ml-0">DESIGN AND CARVING STYLES</label>
                                        <b-form-checkbox  class="mt-5 mb-3 custom-checkbox memorial-production-checkbox">
                                            None
                                        </b-form-checkbox>
                                        <b-form-checkbox  class="my-3 custom-checkbox memorial-production-checkbox">
                                            Flat Curve
                                        </b-form-checkbox>
                                        <b-form-checkbox  class="my-3 custom-checkbox memorial-production-checkbox">
                                            Shape Curve
                                        </b-form-checkbox>
                                        <b-form-checkbox  class="my-3 custom-checkbox memorial-production-checkbox">
                                            Deluxe Curve (Add’l Charge)
                                        </b-form-checkbox>
                                        <b-form-checkbox  class="my-3 custom-checkbox memorial-production-checkbox">
                                            Skin Sunk
                                        </b-form-checkbox>
                                        <b-form-checkbox  class="my-3 custom-checkbox memorial-production-checkbox">
                                            Precision Carve
                                        </b-form-checkbox>
                                        <b-form-checkbox  class="my-3 custom-checkbox memorial-production-checkbox">
                                            Hand Diamond Etch
                                        </b-form-checkbox>
                                        <b-form-checkbox  class="my-3 custom-checkbox memorial-production-checkbox">
                                            Laser Etch
                                        </b-form-checkbox>
                                    </div>
                                    <div class="d-block col-5 mt-2">
                                        <div class="justify-content-center"><label class="ml-0">Description - use name and number
                                            <br><span class="ml-3">Example: BARN02002</span></label></div>
                                        <b-form-input type="text" class="my-2" size="sm" ></b-form-input>
                                        <hr class="my-2 col-12 ml-n3 hr-border">
                                        <b-form-input type="text" class="my-2" size="sm" ></b-form-input>
                                        <hr class="my-2 col-12 ml-n3 hr-border">
                                        <b-form-input type="text" class="my-2" size="sm" ></b-form-input>
                                        <hr class="my-2 col-12 ml-n3 hr-border">
                                        <b-form-input type="text" class="my-2" size="sm" ></b-form-input>
                                        <hr class="my-2 col-12 ml-n3 hr-border">
                                        <b-form-input type="text" class="my-2" size="sm" ></b-form-input>
                                        <hr class="my-2 col-12 ml-n3 hr-border">
                                        <b-form-input type="text" class="my-2" size="sm" ></b-form-input>
                                        <hr class="my-2 col-12 ml-n3 hr-border">
                                        <b-form-input type="text" class="my-2" size="sm" ></b-form-input>
                                        <hr class="my-2 col-12 ml-n3 hr-border">
                                        <b-form-input type="text" class="my-2" size="sm"></b-form-input>
                                        <hr class="my-2 col-12 ml-n3 hr-border">
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="my-n2">
                                        <label class="col-8 ml-n3">Attach Precious Portrait:</label>
                                        <b-form-checkbox  class="my-2 custom-checkbox  memorial-production-checkbox" >
                                            Yes
                                        </b-form-checkbox>
                                        <b-form-checkbox  class="my-2 custom-checkbox  memorial-production-checkbox">
                                            No
                                        </b-form-checkbox>
                                    </div>
                                    <div class="my-n2">
                                        <label class="col-8  ml-n3">Recess area for Precious Portrait:</label>
                                        <b-form-checkbox  class="my-2 custom-checkbox  memorial-production-checkbox">
                                            Yes
                                        </b-form-checkbox>
                                        <b-form-checkbox  class="my-2 custom-checkbox  memorial-production-checkbox">
                                            No
                                        </b-form-checkbox>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-block">
                                <div class="my-2 d-block">
                                    <div class="ml-n3">
                                        <div class="col-4">
                                            <label class="ml-0">Panels</label>
                                        </div>
                                        <div class="col-1">
                                            <label class="ml-0">FN</label>
                                        </div>
                                        <div class="col-1">
                                            <label class="ml-0">INS</label>
                                        </div>
                                        <div class="col-1">
                                            <label class="ml-0">VRS</label>
                                        </div>
                                    </div>
                                    <div class="my-n3 ml-n3">
                                        <div class="col-4">
                                            <label class="ml-0">No Panel(s)</label>
                                        </div>
                                        <div class="col-1">

                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div class="col-1">
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div class="col-1">
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                    <div class="my-n3 ml-n3">
                                        <div class="col-4">
                                            <label class="ml-0">Single Line</label>
                                        </div>
                                        <div class="col-1">

                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div class="col-1">
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div class="col-1">
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                    <div class="my-n3 ml-n3">
                                        <div class="col-4">
                                            <label class="ml-0">Double Line</label>
                                        </div>
                                        <div class="col-1">

                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div class="col-1">
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div class="col-1">
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                    <div class="my-n3 ml-n3">
                                        <div class="col-4">
                                            <label class="ml-0">Other: _____________</label>
                                        </div>
                                        <div class="col-1">
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div class="col-1">
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div class="col-1">
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                    <div class="my-n3 ml-n3">
                                        <div class="col-4">
                                            <label class="ml-0">Other: _____________</label>
                                        </div>
                                        <div class="col-1">

                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div class="col-1">
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div class="col-1">
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                </div>
                                <hr class="col-11 ml-n3 hr-border">
                                <div class="my-2">
                                    <div class="d-block col-7 ml-n3">
                                        <label class=" ml-0">DARKENING AGENT:</label>
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-checkbox">
                                            No Artificial Agent
                                        </b-form-checkbox>
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-checkbox">
                                            Transparent Gray Shadow
                                        </b-form-checkbox>
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-checkbox">
                                            Dark Gray Shadow
                                        </b-form-checkbox>
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-checkbox">
                                            Black Shadow
                                        </b-form-checkbox>
                                    </div>
                                    <div class="d-block">
                                        <label class=" ml-0">WHITENING AGENT:</label>
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-checkbox">
                                            No Artificial Agent
                                        </b-form-checkbox>
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-checkbox">
                                            Hilite
                                        </b-form-checkbox>
                                        <b-form-checkbox  class="my-2 custom-checkbox memorial-production-checkbox">
                                            Heavy Hilite
                                        </b-form-checkbox>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-border-bottom mt-n2">
                        <div class="col-6 custom-border-right d-block mt-0 mb-0">
                            <div>
                                <div class="col-5">
                                    <label class=" ml-n3">LETTERING FONTS</label>
                                </div>
                                <div>
                                    <label class="ml-0 font-weight-bold" style="font-size: 8px !important;">*See design book for Letter Font size limitations</label>
                                </div>
                            </div>
                            <div>
                                <div class="col-5">
                                    <label class=" ml-0"></label>
                                </div>
                                <div class="col-2">
                                    <label class="ml-n3">Fam Name</label>
                                </div>
                                <div class="col-2">
                                    <label class="ml-n2">Inscript</label>
                                </div>
                                <div class="col-2">
                                    <label class="ml-n2">Verse</label>
                                </div>
                            </div>
                            <div class="my-n3">
                                <div class="col-5">
                                    <label class="ml-n3" style="font-family: apple-chancery;">Apple Chancery</label>
                                </div>
                                <div class="col-2">

                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                            </div>
                            <div class="my-n3">
                                <div class="col-5">
                                    <label class="ml-n3" style="font-family: tartine-script-regular;">Tartine Script Regular</label>
                                </div>
                                <div class="col-2">

                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                            </div>
                            <div class="my-n3">
                                <div class="col-5">
                                    <label class="ml-n3" style="font-family: government">GOVERNMENT</label>
                                </div>
                                <div class="col-2">

                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                            </div>
                            <div class="my-n3">
                                <div class="col-5">
                                    <label class="ml-n3" style="font-family: regular-roman">REGULAR ROMAN</label>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                            </div>
                            <div class="my-n3">
                                <div class="col-5">
                                    <label class="ml-n3" style="font-family: roman-condensed">ROMAN CONDENSED</label>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                            </div>
                            <div class="my-n3">
                                <div class="col-5">
                                    <label class="ml-n3" style="font-family: roman-more-condensed">ROMAN MORE CONDENSED</label>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                            </div>
                            <div class="my-n3">
                                <div class="col-5">
                                    <label class="ml-n3" style="font-family: alternate-gothic">Alternate Gothic No. 3D</label>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                            </div>
                            <!--<div class="my-n3">
                                <div class="col-5">
                                    <label class="ml-n3">VERMARCO</label>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                            </div>
                            <div class="my-n3">
                                <div class="col-5">
                                    <label class="ml-n3">COMMON GOTHIC</label>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                            </div>-->
                            <div class="my-n3">
                                <div class="col-5">
                                    <label class="ml-n3">Other: _________________</label>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                                <div class="col-2">
                                    <b-form-checkbox  class="my-2 custom-checkbox">
                                    </b-form-checkbox>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 d-block">
                            <div class="col-5 mt-1">
                                <label class="ml-n3">LETTER CARVING STYLES</label>
                            </div>
                            <div class="col-7">
                                <div class="d-block ml-n3">
                                    <div>
                                        <div class="col-8">
                                            <label class="ml-n3"></label>
                                        </div>
                                        <div>
                                            <label class="ml-0">FN</label>
                                        </div>
                                        <div>
                                            <label class="ml-0">INS</label>
                                        </div>
                                        <div>
                                            <label class="ml-0">VRS</label>
                                        </div>
                                    </div>
                                    <div class="my-n3">
                                        <div class="col-8">
                                            <label class="ml-n3">V - Sunk</label>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                    <div class="my-n3">
                                        <div class="col-8">
                                            <label class="ml-n3">U - Sunk</label>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                    <div class="my-n3">
                                        <div class="col-8">
                                            <label class="ml-n3">Shallow Sunk 1/16”</label>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                    <div class="my-n2">
                                        <div class="col-8">
                                            <label class="ml-n3">Skin Sunk 1/32”</label>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                    <hr class="col-12 ml-n3 hr-border">
                                    <div class="my-1">
                                        <div class="col-8 mt-2">
                                            <label class="ml-n3">Polish Raised<br>
                                                (not cleaned)</label>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                    <div class="my-1 mt-n2">
                                        <div class="col-8 ">
                                            <label class="ml-n3">Polish Raised<br>
                                                (cleaned) (Add’l charge)</label>
                                        </div>
                                        <div class="mt-n2">
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div class="mt-n2">
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div class="mt-n2">
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                    <div class="my-n2">
                                        <div class="justify-content-center">
                                            <label class="ml-0 text-center">(Use Square Raised (not listed)
                                                <br>or Helvetica 1” min.)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block ml-5">
                                    <div class="ml-n4">
                                        <div class="col-7">
                                            <label class="ml-0"></label>
                                        </div>
                                        <div>
                                            <label class="ml-0">FN</label>
                                        </div>
                                        <div>
                                            <label class="ml-0">INS</label>
                                        </div>
                                        <div>
                                            <label class="ml-0">VRS</label>
                                        </div>
                                    </div>
                                    <div class="my-n3 ml-n4">
                                        <div class="col-7">
                                            <label class="ml-0">Frosted Inlaid*</label>
                                        </div>
                                        <div>

                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                    <div class="my-n3 ml-n4">
                                        <div class="col-7">
                                            <label class="ml-0">Polish Inlaid*</label>
                                        </div>
                                        <div>

                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                    <div class="my-n3 ml-n4">
                                        <div class="col-7">
                                            <label class="ml-0">Frosted Edge*</label>
                                        </div>
                                        <div>

                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                    <div class="my-n3 ml-n4">
                                        <div class="col-7">
                                            <label class="ml-0">Polish Edge*</label>
                                        </div>
                                        <div>

                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                    <div class="my-n3 ml-n4">
                                        <div class="col-7">
                                            <label class="ml-0">Shadow Bar*</label>
                                        </div>
                                        <div>

                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                        <div>
                                            <b-form-checkbox  class="my-2 custom-checkbox">
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                    <div class="mt-5 ">
                                        <div class="justify-content-center">
                                            <label class="ml-n4 text-center" style="font-size: 8px !important;">*Above carving styles use a Modified Roman<br>
                                                Font; Frosted Inlaid may use Connected Script<br>
                                                or Opti SB. Use of other fonts, for these carving<br>
                                                styles, is considered custom and will incur<br>
                                                additional charges.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="work-order-row">
                    <div>
                        <button type="button" class="btn btn-sm btn-info custom-print-button  px-2" @click="printPDF">Print Preview</button>
                    </div>
                </div>


            </form>
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
                title: 'Printable Memorial Production'
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
        font-size: 18px !important;
    }
    .pdf-labels{
        font-family: Arial;
        font-size: 18px !important;
        font-weight: 400 !important;
    }
    .pdf-margin-date{
        margin-left: 22.5rem !important;
    }
    .pdf-margin-customer{
        margin-left: 5rem !important;
    }
    .pdf-margin-trucking{
        margin-left: 18rem !important;
    }
    .pdf-custom-margin-form{
        /*/margin-top:-2rem !important;*/
        margin-left: -1rem !important;
        margin-right: -1rem !important;
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
    .pdf-custom-title{
        font-family: "Times New Roman";
        font-style: italic;
        font-weight: 700;
        font-size: 19px;
        line-height: 20px;
        text-align: center;
        letter-spacing: 0.02em;
    }
    .pdf-custom-div-size2{
        width:22rem !important;
    }
    .pdf-custom-div-size3{
        width:26rem !important;
    }

    .pdf label{
        display: block;
        font-size: 0.5em;
        margin-bottom: 0;
    }
    .pdf-checkbox input[type='checkbox']{
        width: 11px !important;
        height: 11px !important;
        margin: 5px;
        -webkit-appearance: none;
        -moz-appearance: none;
        -o-appearance: none;
        appearance:none;
        outline: 1.5px solid black;
        box-shadow: none;
        font-size: 2em;
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
        font-size: 10px;
    }
    .work-order-row div input,textarea{
        border: 1px solid transparent !important;
        margin: auto;
        margin-right: 0;
        font-size: 12px;
    }
    .work-order-row div input{
        height:1.5rem;
    }
    .custom-div-size2{
        width:22rem !important;
    }
    .custom-div-size3{
        width:26rem !important;
    }

    .fields{
        border:none !important;
        color: black !important;
        font-size: 18px !important;
    }
    .labels{
        font-family: Arial;
        font-size: 12px !important;
        font-weight: 400 !important;
    }
    .margin-date{
        margin-left: 10rem !important;
    }
    .margin-customer{
        margin-left: -4rem !important;
    }
    .margin-trucking{
        margin-left: 3.5rem !important;
    }
    .custom-margin-form{
        margin-top:2rem !important;
        margin: auto;
        width: 45rem !important;
       /* margin-left: 20rem !important;
        margin-right: -1rem !important;*/
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
    }

    header{
        padding: 0 3rem;
    }

    .hr-border{
        border-width:2px!important;
        border-color: black !important;
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
    .custom-border-top{
        border-top: 2px solid #000000 !important;
    }
    .custom-border-bottom{
        border-bottom: 2px solid #000000 !important;
    }
    .custom-border-right{
        border-right: 2px solid #000000 !important;
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

    .custom-checkbox .custom-control-label::before {
        border-radius: 0 !important;
    }

</style>
