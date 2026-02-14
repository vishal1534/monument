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

        <PDF :title="'printApprovalMonument'">
            <div slot="header" class="pdf-custom-margin-form">
                <form >
                    <div class="order-form-row d-block">
                            <div>
                                <div class="d-block">
                                    <div>
                                        <img class="ml-0 border moz-border" :src="'images/approvalform-image.png'" />
                                    </div>
                                    <div>
                                        <label class="font-weight-bold pdf-labels border moz-border px-5 ml-0 mt-n1 " style ="color:transparent !important;">TABLET</label>
                                    </div>
                                </div>
                                <div class=" col-3 d-block border moz-border">
                                    <div class="border-bottom moz-border-bottom justify-content-center">
                                        <label class="font-weight-bold pdf-title">Design File Name</label>
                                    </div>
                                    <div class="justify-content-center">
                                        <label class="pdf-sub-labels" style ="font-size: 14px !important;color:transparent !important;">WILSON-7899</label>
                                    </div>

                                </div>

                            </div>
                            <div>
                                <div class="mt-n3">
                                    <label class="font-weight-bold pdf-labels ">FRONT</label>
                                </div>
                            </div>

                    </div>
                    <div class="order-form-row ml-0">
                        <div class="">
                            <div class="justify-content-center">
                                <img class="ml-0 pdf-product-print" style="visibility: hidden;" :src="'images/approvalform-product.png'" />
                            </div>
                        </div>

                    </div>
                    <div class="order-form-row pdf-custom-margin-approval mt-3">
                        <div class="">
                            <label class="pdf-sub-labels">APPROVED BY:</label>
                            <label>________________________________________________</label>
                        </div>
                        <div class="">
                            <label class="pdf-sub-labels">DATE:</label>
                            <label class="ml-0">______________________________</label>
                        </div>
                    </div>
                    <div class="d-block text-center my-3 mb-5">
                        <label class="d-block m-0 pdf-sub-labels">BY SIGNING THE APPROVAL I ASSUME COMPLETE RESPONSIBILITY FOR LAYOUT/SPELLING/DATES.</label>
                        <label class="d-block m-0 pdf-sub-labels">I ALSO AGREE THAT AFTER SIGNING THE APPROVAL, NO FURTHER CHANGES WILL BE MADE & IF </label>
                        <label class="d-block m-0 pdf-sub-labels">SOMETHING IS INCORRECT UPON COMPLETION OF THE MONUMENT I AM RESPONSIBLE</label>
                        <label class="d-block m-0 pdf-sub-labels">FOR THE COST TO CORRECT IT.</label>
                    </div>
                    <div class="order-form-row border moz-border moz-margin" style="margin-top: 8rem !important;">
                        <div class="d-block">
                            <div class="border-bottom moz-border-bottom my-2">
                                <div class="border-right moz-border-right mt-n2 j col-2"><label class="pdf-sub-labels">Size & Description:</label></div>
                                <div class="border-right moz-border-right mt-n2 col-5"><label class="pdf-sub-labels">Die :<span style="visibility: hidden;">3-0X0-6X1-8, SERP TOP, P2, BRP</span></label></div>
                                <div class="mt-n2"><label class="pdf-sub-labels">Base: <span style="visibility: hidden;">4-0X1-0X0-6 POL TOP, BRP</span> </label></div>
                            </div>
                            <div class="border-bottom moz-border-bottom my-2">
                                <div class="border-right moz-border-right mt-n1"><label class="pdf-sub-labels">Granite Color:</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox">
                                    <label class="pdf-sub-labels mt-0">GRAY</label></div>
                                <div class="border-right moz-border-right mt-n1 ml-0 pdf-checkbox"><input type="checkbox" class="custom-checkbox">
                                    <label class="pdf-sub-labels mt-0">MEL. BLK.</label></div>
                                <div class="border-right moz-border-right  mt-n1 ml-0 pdf-checkbox"><input type="checkbox" class="custom-checkbox">
                                    <label class="pdf-sub-labels mt-0">D.BRWN</label></div>
                                <div class="border-right moz-border-right mt-n1 ml-0 pdf-checkbox"><input type="checkbox" class="custom-checkbox">
                                    <label class="pdf-sub-labels mt-0">M. ROSE</label></div>
                                <div class="border-right moz-border-right mt-n1 ml-0 pdf-checkbox"><input type="checkbox" class="custom-checkbox">
                                    <label class="pdf-sub-labels mt-0">BAHAMA BLUE</label></div>
                                <div class="border-right moz-border-right mt-n1 ml-0 pdf-checkbox"><input type="checkbox" class="custom-checkbox">
                                    <label class="pdf-sub-labels mt-0">BLUE PEARL</label></div>
                                <div class="border-right moz-border-right mt-n1 ml-0 pdf-checkbox"><input type="checkbox" class="custom-checkbox">
                                    <label class="pdf-sub-labels mt-0 pdf-checkbox">INDIA RED</label></div>
                                <div class="mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox">
                                    <label class="pdf-sub-labels mt-0">OTHER</label></div>
                            </div>
                            <div class="border-bottom moz-border-bottom  my-2">
                                <div class="border-right moz-border-right mt-n1"><label class="pdf-sub-labels">Carving Style:</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-4">
                                    <label class="pdf-sub-labels mt-0">FLAT CARVE</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-4">
                                    <label class="pdf-sub-labels mt-0">SHAPE CARVE</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-5">
                                    <label class="pdf-sub-labels mt-0">LASER ETCH</label></div>
                                <div class=" mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-5">
                                    <label class="pdf-sub-labels mt-0">HAND ETCH</label></div>
                            </div>
                            <div class="border-bottom moz-border-bottom  my-2">
                                <div class="border-right moz-border-right mt-n1"><label class="pdf-sub-labels">Letter Carving Style:</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-4">
                                    <label class="pdf-sub-labels mt-0">V-CUT</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-4">
                                    <label class="pdf-sub-labels mt-0">SKIN SUNK</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-3">
                                    <label class="pdf-sub-labels mt-0">FROSTED OUTLINED</label></div>
                                <div class=" mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-2">
                                    <label class="pdf-sub-labels mt-0">Other:______________</label></div>
                            </div>
                            <div class="mb-n2 my-2">
                                <div class="border-right moz-border-right mt-n1"><label class="pdf-sub-labels">Lithochrome Darkening or Whitening Agent:</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-4">
                                    <label class="pdf-sub-labels mt-0">BLACK</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-4">
                                    <label class="pdf-sub-labels mt-0">LT. HI-LITE</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-4">
                                    <label class="pdf-sub-labels mt-0">MED HI-LITE</label></div>
                                <div class=" mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-4">
                                    <label class="pdf-sub-labels mt-0">HVY. HI-LITE</label></div>
                            </div>
                        </div>
                    </div>

                    <div class="order-form-row d-block mt-5" style="page-break-before: always">
                        <div>
                            <div class="d-block">
                                <div>
                                    <img class="ml-0 border moz-border" :src="'images/approvalform-image.png'" />
                                </div>
                                <div>
                                    <label class="font-weight-bold pdf-labels border moz-border px-5 ml-0 mt-n1 " style ="color:transparent !important;">TABLET</label>
                                </div>
                            </div>
                            <div class=" col-3 d-block border moz-border">
                                <div class="border-bottom moz-border-bottom justify-content-center">
                                    <label class="font-weight-bold pdf-title">Design File Name</label>
                                </div>
                                <div class="justify-content-center">
                                    <label class="pdf-sub-labels" style ="font-size: 14px !important;color:transparent !important;">WILSON-7899</label>
                                </div>

                            </div>

                        </div>
                        <div>
                            <div class="mt-n3">
                                <label class="font-weight-bold pdf-labels ">BACK</label>
                            </div>
                        </div>

                    </div>
                    <div class="order-form-row ml-0">
                        <div class="">
                            <div class="justify-content-center">
                                <img class="ml-0 pdf-product-print" style="visibility: hidden;" :src="'images/approvalform-product.png'" />

                            </div>
                        </div>

                    </div>
                    <div class="order-form-row pdf-custom-margin-approval mt-3">
                        <div class="">
                            <label class="pdf-sub-labels">APPROVED BY:</label>
                            <label>________________________________________________</label>
                        </div>
                        <div class="">
                            <label class="pdf-sub-labels">DATE:</label>
                            <label class="ml-0">______________________________</label>
                        </div>
                    </div>
                    <div class="d-block text-center my-3 ">
                        <label class="d-block m-0 pdf-sub-labels">BY SIGNING THE APPROVAL I ASSUME COMPLETE RESPONSIBILITY FOR LAYOUT/SPELLING/DATES.</label>
                        <label class="d-block m-0 pdf-sub-labels">I ALSO AGREE THAT AFTER SIGNING THE APPROVAL, NO FURTHER CHANGES WILL BE MADE & IF </label>
                        <label class="d-block m-0 pdf-sub-labels">SOMETHING IS INCORRECT UPON COMPLETION OF THE MONUMENT I AM RESPONSIBLE</label>
                        <label class="d-block m-0 pdf-sub-labels">FOR THE COST TO CORRECT IT.</label>
                    </div>
                    <div class="order-form-row border moz-border moz-margin" style="margin-top: 8rem !important;">
                        <div class="d-block">
                            <div class="border-bottom moz-border-bottom  my-2">
                                <div class="border-right moz-border-right mt-n2 j col-2"><label class="pdf-sub-labels">Size & Description:</label></div>
                                <div class="border-right moz-border-right mt-n2 col-5"><label class="pdf-sub-labels">Die: <span style="visibility: hidden;"> 3-0X0-6X1-8, SERP TOP, P2, BRP</span></label></div>
                                <div class="mt-n2"><label class="pdf-sub-labels">Base: <span style="visibility: hidden;">4-0X1-0X0-6 POL TOP, BRP</span> </label></div>
                            </div>
                            <div class="border-bottom moz-border-bottom   my-2">
                                <div class="border-right moz-border-right  mt-n1"><label class="pdf-sub-labels">Granite Color:</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox">
                                    <label class="pdf-sub-labels mt-0">GRAY</label></div>
                                <div class="border-right moz-border-right mt-n1 ml-0 pdf-checkbox"><input type="checkbox" class="custom-checkbox">
                                    <label class="pdf-sub-labels mt-0">MEL. BLK.</label></div>
                                <div class="border-right moz-border-right mt-n1 ml-0 pdf-checkbox"><input type="checkbox" class="custom-checkbox">
                                    <label class="pdf-sub-labels mt-0">D.BRWN</label></div>
                                <div class="border-right moz-border-right mt-n1 ml-0 pdf-checkbox"><input type="checkbox" class="custom-checkbox">
                                    <label class="pdf-sub-labels mt-0">M. ROSE</label></div>
                                <div class="border-right moz-border-right mt-n1 ml-0 pdf-checkbox"><input type="checkbox" class="custom-checkbox">
                                    <label class="pdf-sub-labels mt-0">BAHAMA BLUE</label></div>
                                <div class="border-right moz-border-right mt-n1 ml-0 pdf-checkbox"><input type="checkbox" class="custom-checkbox">
                                    <label class="pdf-sub-labels mt-0">BLUE PEARL</label></div>
                                <div class="border-right moz-border-right mt-n1 ml-0 pdf-checkbox"><input type="checkbox" class="custom-checkbox">
                                    <label class="pdf-sub-labels mt-0 pdf-checkbox">INDIA RED</label></div>
                                <div class="mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox">
                                    <label class="pdf-sub-labels mt-0">OTHER</label></div>
                            </div>
                            <div class="border-bottom moz-border-bottom  my-2">
                                <div class="border-right moz-border-right mt-n1"><label class="pdf-sub-labels">Carving Style:</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-4">
                                    <label class="pdf-sub-labels mt-0">FLAT CARVE</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-4">
                                    <label class="pdf-sub-labels mt-0">SHAPE CARVE</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-5">
                                    <label class="pdf-sub-labels mt-0">LASER ETCH</label></div>
                                <div class=" mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-5">
                                    <label class="pdf-sub-labels mt-0">HAND ETCH</label></div>
                            </div>
                            <div class="border-bottom moz-border-bottom  my-2">
                                <div class="border-right moz-border-right mt-n1"><label class="pdf-sub-labels">Letter Carving Style:</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-4">
                                    <label class="pdf-sub-labels mt-0">V-CUT</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-4">
                                    <label class="pdf-sub-labels mt-0">SKIN SUNK</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-3">
                                    <label class="pdf-sub-labels mt-0">FROSTED OUTLINED</label></div>
                                <div class=" mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-2">
                                    <label class="pdf-sub-labels mt-0">Other:______________</label></div>
                            </div>
                            <div class="mb-n2 my-2">
                                <div class="border-right moz-border-right mt-n1"><label class="pdf-sub-labels">Lithochrome Darkening or Whitening Agent:</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-4">
                                    <label class="pdf-sub-labels mt-0">BLACK</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-4">
                                    <label class="pdf-sub-labels mt-0">LT. HI-LITE</label></div>
                                <div class="border-right moz-border-right mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-4">
                                    <label class="pdf-sub-labels mt-0">MED HI-LITE</label></div>
                                <div class=" mt-n1 pdf-checkbox"><input type="checkbox" class="custom-checkbox ml-4">
                                    <label class="pdf-sub-labels mt-0">HVY. HI-LITE</label></div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>



        </PDF>

        <div slot="header" class="custom-margin-form col-6">
            <form >
                <div class="order-form-row d-block">
                    <div>
                        <div class="d-block">
                            <div>
                                <img class="ml-0 border" :src="'images/approvalform-image.png'" />
                            </div>
                            <div>
                                <label class="font-weight-bold approval-label border px-5 ml-0 mt-n1 " style ="color:transparent !important;">TABLET</label>
                            </div>
                        </div>
                        <div class=" col-3 d-block border">
                            <div class="border-bottom justify-content-center">
                                <label class="font-weight-bold title">Design File Name</label>
                            </div>
                            <div class="justify-content-center">
                                <label class="sub-labels" style ="font-size: 14px !important;color:transparent !important;">WILSON-7899</label>
                            </div>

                        </div>

                    </div>
                    <div>
                        <div class="mt-n3">
                            <label class="font-weight-bold approval-label">FRONT</label>
                        </div>
                    </div>

                </div>
                <div class="order-form-row ml-0">
                    <div class="">
                        <div class="justify-content-center">
                            <img class="ml-0 product-print" style="visibility: hidden;" :src="'images/approvalform-product.png'" />

                        </div>
                    </div>

                </div>
                <div class="order-form-row custom-margin-approval mt-3">
                    <div class="">
                        <label class="approval-labels">APPROVED BY:</label>
                        <label>________________________________________________</label>
                    </div>
                    <div class="">
                        <label class="approval-labels">DATE:</label>
                        <label class="ml-0">______________________________</label>
                    </div>
                </div>
                <div class="d-block text-center my-3 ">
                    <label class="d-block m-0 approval-labels">BY SIGNING THE APPROVAL I ASSUME COMPLETE RESPONSIBILITY FOR LAYOUT/SPELLING/DATES.</label>
                    <label class="d-block approval-labels">I ALSO AGREE THAT AFTER SIGNING THE APPROVAL, NO FURTHER CHANGES WILL BE MADE & IF </label>
                    <label class="d-block m-0 approval-labels">SOMETHING IS INCORRECT UPON COMPLETION OF THE MONUMENT I AM RESPONSIBLE</label>
                    <label class="d-block m-0 approval-labels">FOR THE COST TO CORRECT IT.</label>
                </div>
                <div class="order-form-row border mt-5">
                    <div class="d-block">
                        <div class="border-bottom my-2">
                            <div class="border-right mt-n2 j col-2"><label class="sub-labels">Size & Description:</label></div>
                            <div class="border-right mt-n2 col-5"><label class="sub-labels">Die:</label></div>
                            <div class="mt-n2"><label class="sub-labels">Base:</label></div>
                        </div>
                        <div class="border-bottom my-2">
                            <div class="border-right mt-n1"><label class="sub-labels">Granite Color:</label></div>
                            <div class="border-right mt-n1 "><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">GRAY</label></div>
                            <div class="border-right mt-n1 ml-2"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">MEL. BLK.</label></div>
                            <div class="border-right mt-n1 ml-1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">D.BRWN</label></div>
                            <div class="border-right mt-n1 ml-2"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">M. ROSE</label></div>
                            <div class="border-right mt-n1 ml-2"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">BAHAMA BLUE</label></div>
                            <div class="border-right mt-n1 ml-2"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">BLUE PEARL</label></div>
                            <div class="border-right mt-n1 ml-2"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">INDIA RED</label></div>
                            <div class="mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">OTHER</label></div>
                        </div>
                        <div class="border-bottom my-2">
                            <div class="border-right mt-n1"><label class="sub-labels">Carving Style:</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">FLAT CARVE</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">SHAPE CARVE</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">LASER ETCH</label></div>
                            <div class=" mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">HAND ETCH</label></div>
                        </div>
                        <div class="border-bottom my-2">
                            <div class="border-right mt-n1"><label class="sub-labels">Letter Carving Style:</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">V-CUT</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">SKIN SUNK</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">FROSTED OUTLINED</label></div>
                            <div class=" mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">Other:______________</label></div>
                        </div>
                        <div class="mb-n2 my-2">
                            <div class="border-right mt-n1"><label class="sub-labels">Lithochrome Darkening or Whitening Agent:</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">BLACK</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">LT. HI-LITE</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">MED HI-LITE</label></div>
                            <div class=" mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">HVY. HI-LITE</label></div>
                        </div>
                    </div>
                </div>

                <div class="order-form-row d-block mt-5 ">
                    <div>
                        <div class="d-block">
                            <div>
                                <img class="ml-0 border" :src="'images/approvalform-image.png'" />
                            </div>
                            <div>
                                <label class="font-weight-bold approval-label border px-5 ml-0 mt-n1 " style ="color:transparent !important;">TABLET</label>
                            </div>
                        </div>
                        <div class=" col-3 d-block border">
                            <div class="border-bottom justify-content-center">
                                <label class="font-weight-bold title">Design File Name</label>
                            </div>
                            <div class="justify-content-center">
                                <label class="sub-labels"style ="font-size: 14px !important;color:transparent !important;">WILSON-7899</label>
                            </div>

                        </div>

                    </div>
                    <div>
                        <div class="mt-n3">
                            <label class="font-weight-bold approval-label">BACK</label>
                        </div>
                    </div>

                </div>
                <div class="order-form-row ml-0">
                    <div class="">
                        <div class="justify-content-center">
                            <img class="ml-0 product-print" style="visibility: hidden;" :src="'images/approvalform-product.png'" />

                        </div>
                    </div>

                </div>
                <div class="order-form-row custom-margin-approval mt-3">
                    <div class="">
                        <label class="approval-labels">APPROVED BY:</label>
                        <label>________________________________________________</label>
                    </div>
                    <div class="">
                        <label class="approval-labels">DATE:</label>
                        <label class="ml-0">______________________________</label>
                    </div>
                </div>
                <div class="d-block text-center my-3 ">
                    <label class="d-block m-0 approval-labels">BY SIGNING THE APPROVAL I ASSUME COMPLETE RESPONSIBILITY FOR LAYOUT/SPELLING/DATES.</label>
                    <label class="d-block approval-labels">I ALSO AGREE THAT AFTER SIGNING THE APPROVAL, NO FURTHER CHANGES WILL BE MADE & IF </label>
                    <label class="d-block m-0 approval-labels">SOMETHING IS INCORRECT UPON COMPLETION OF THE MONUMENT I AM RESPONSIBLE</label>
                    <label class="d-block m-0 approval-labels">FOR THE COST TO CORRECT IT.</label>
                </div>
                <div class="order-form-row border mt-5">
                    <div class="d-block">
                        <div class="border-bottom my-2">
                            <div class="border-right mt-n2 j col-2"><label class="sub-labels">Size & Description:</label></div>
                            <div class="border-right mt-n2 col-5"><label class="sub-labels">Die:</label></div>
                            <div class="mt-n2"><label class="sub-labels">Base:</label></div>
                        </div>
                        <div class="border-bottom my-2">
                            <div class="border-right mt-n1"><label class="sub-labels">Granite Color:</label></div>
                            <div class="border-right mt-n1 "><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">GRAY</label></div>
                            <div class="border-right mt-n1 ml-2"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">MEL. BLK.</label></div>
                            <div class="border-right mt-n1 ml-1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">D.BRWN</label></div>
                            <div class="border-right mt-n1 ml-2"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">M. ROSE</label></div>
                            <div class="border-right mt-n1 ml-2"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">BAHAMA BLUE</label></div>
                            <div class="border-right mt-n1 ml-2"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">BLUE PEARL</label></div>
                            <div class="border-right mt-n1 ml-2"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">INDIA RED</label></div>
                            <div class="mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">OTHER</label></div>
                        </div>
                        <div class="border-bottom my-2">
                            <div class="border-right mt-n1"><label class="sub-labels">Carving Style:</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">FLAT CARVE</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">SHAPE CARVE</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">LASER ETCH</label></div>
                            <div class=" mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">HAND ETCH</label></div>
                        </div>
                        <div class="border-bottom my-2">
                            <div class="border-right mt-n1"><label class="sub-labels">Letter Carving Style:</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">V-CUT</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">SKIN SUNK</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">FROSTED OUTLINED</label></div>
                            <div class=" mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">Other:______________</label></div>
                        </div>
                        <div class="mb-n2 my-2">
                            <div class="border-right mt-n1"><label class="sub-labels">Lithochrome Darkening or Whitening Agent:</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">BLACK</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">LT. HI-LITE</label></div>
                            <div class="border-right mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">MED HI-LITE</label></div>
                            <div class=" mt-n1"><input type="checkbox" disabled class="custom-checkbox">
                                <label class="sub-labels mt-0">HVY. HI-LITE</label></div>
                        </div>
                    </div>
                </div>

            </form>
            <div class="order-form-row">
                <div>
                    <button type="button" class="btn btn-sm btn-info custom-print-button py-1 px-2" @click="printPDF">Print Preview</button>
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
                title: 'Printable Approval Monument'
            }
        },
        beforeCreate(){
            if(!this.$store.getters.isPermitted({resource:'Orders',action:'read'}) && !this.$store.getters.isPermitted({resource:'Production',action:'read'}))
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


    .pdf-labels{
        font-family: Arial;
        font-size: 15px !important;
    }
    .pdf-sub-labels{
        font-family: Arial;
        font-size: 13px !important;
        font-weight: 700;
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
        font-size: 17px !important;
        line-height: 25px;
        text-align: center;
        letter-spacing: 0.02em;
        color: #000000;
    }
    .pdf-custom-margin-approval{
        margin-left: 5rem;
    }
    .pdf-product-print{
        margin-top: 8rem !important;
        margin-bottom: 17rem !important;
        width: 50rem;
        height: auto;
    }

    .pdf label{
        display: block;
        font-size: 0.5em;
        margin-bottom: 0;
    }
    .border{
        border:1px solid black !important;

    }
    .form-width {
        width: 45rem !important;
    }

    .labels{
        font-family: Arial;
        font-size: 10px !important;
    }
    .approval-labels{
        font-family: Arial;
        font-size: 12px !important;
    }
    .sub-labels{
        font-family: Arial;
        font-size: 8px !important;
        font-weight: 700;
    }
    .custom-margin-form{
        margin-top:3rem !important;
        margin: auto;
      /*  margin-left: 20rem !important;
        margin-right: 2rem !important;*/
    }
    .title{
        font-family: Arial;
        font-style: normal;
        font-weight: 400;
        font-size: 17px !important;
        line-height: 25px;
        text-align: center;
        letter-spacing: 0.02em;
        color: #000000;
    }
    .custom-margin-approval{
        margin-left: 2.5rem;
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

    .custom-div-top{
        border:7px solid #FFFF00 !important;
    }



    .custom-margin-div-image{
        margin-left: .8rem !important;

    }
    .product-print{
        margin-top: 4rem !important;
        margin-bottom: 4rem !important;
        width: 50rem;
        height: auto;
    }

    header{
        padding: 0 3rem;
    }

    .border-right{
        border-right: 1px solid black !important;
    }

    .border-bottom{
        border-bottom: 1px solid black !important;
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

    .pdf-checkbox input[type='checkbox']{
        width: 11px !important;
        height: 11px !important;
        margin: 5px;
        -webkit-appearance: none;
        -moz-appearance: none;
        -o-appearance: none;
        appearance:none;
        outline: 2px solid black;
        box-shadow: none;
        font-size: 2em;
        border: none !important;
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
        border: 2px solid #000;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
        padding: 5px;
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
        width: 3px;
        height: 7px;
        border: solid #FF0000;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    @supports (-moz-appearance:none) {
        .moz-border {
            border: 2px solid #000!important;
        }
        .moz-border-right {
            border-right: 2px solid #000 !important;
        }
        .moz-border-bottom {
            border-bottom: 2px solid #000 !important;
        }
        .moz-margin {
            margin-left: -4rem !important;
            margin-right: -4rem !important;
        }
    }
</style>
