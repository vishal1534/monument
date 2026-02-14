<template>

    <div>

        <div class="row">
            <div class="col-md-12">

                <form class="div-shadow bg-white rounded mx-2 mb-2 p-3">
                    <div class="form-content">


                        <h5 class="font-weight-bold my-1 text-center">Granit Bronz Precious Portrait Order Form</h5>

                        <div class="granit-precious-row my-2">
                            <div class="w-50">
                                <label class="m-0">GB Account #:</label>
                                <div class="mx-2 granit-precious-custom-border-bottom"></div>
                            </div>
                            <div class="w-25"></div>
                            <div class="w-50 ml-auto">
                                <label class="m-0 ">Company Name:</label>
                                <div class="mx-2 granit-precious-custom-border-bottom"></div>
                            </div>
                        </div>
                        <div class="granit-precious-row">
                            <div class="w-50 h-100">
                                <label class="m-0 ">Date:</label>
                                <div class="mx-2 granit-precious-custom-border-bottom"></div>
                            </div>
                            <div class="w-25"></div>
                            <div class="w-50 ml-auto flex-column my-0">
                                <div>
                                    <label class="m-0 col-2 p-0">Address:</label>
                                    <div class="mx-2 granit-precious-custom-border-bottom"></div>
                                </div>
                                <div><label class="m-0 col-2 p-0"></label><div class="mx-2 granit-precious-custom-border-bottom"></div></div>
                                <div><label class="m-0 col-2 p-0"></label><div class="mx-2 granit-precious-custom-border-bottom"></div></div>
                            </div>
                        </div>
                        <div class="granit-precious-row">
                            <div class="w-50 my-0">
                                <label class="m-0">Family Name:</label>
                                <div class="mx-2 granit-precious-custom-border-bottom"></div>
                            </div>
                            <div class="w-25"></div>
                            <div class="w-50"></div>
                        </div>

                        <div class="d-flex granit-precious-custom-border">

                            <div class="granit-precious-custom-border-right px-2">
                                <div>
                                    <h6>Photograph View</h6>
                                </div>

                                <div>
                                    <b-form-group class="custom-radio-and-checkbox">
                                        <b-form-checkbox-group plain>

                                            <div class="d-flex">
                                                <div class="col-2 p-0 text-center">
                                                    <img :src="storagePath + 'bust.svg'" class="d-block mx-auto product-image" alt="product-file">
                                                    <b-form-checkbox value="bust"><label>Bust*</label></b-form-checkbox>
                                                </div>
                                                <div class="col-2 p-0 text-center">
                                                    <img :src="storagePath + 'half_view.svg'" class="d-block mx-auto product-image" alt="product-file">
                                                    <b-form-checkbox value="1-2-view"><label>1/2 View</label></b-form-checkbox>
                                                </div>
                                                <div class="col-2 p-0 text-center">
                                                    <img :src="storagePath + 'three_by_four_view.svg'" class="d-block mx-auto product-image" alt="product-file">
                                                    <b-form-checkbox value="3-4-view"><label>3/4 View</label></b-form-checkbox>
                                                </div>
                                                <div class="col-2 p-0 text-center">
                                                    <img :src="storagePath + 'full_figure.svg'" class="d-block mx-auto product-image" alt="product-file">
                                                    <b-form-checkbox value="full-figure"><label>Full Figure</label></b-form-checkbox>
                                                </div>
                                                <div class="col-2 text-center">
                                                    <img :src="storagePath + 'entire_photo.svg'" class="d-block mx-auto product-image" alt="product-file">
                                                    <b-form-checkbox value="entire-photo"><label>Entire Photo</label></b-form-checkbox>
                                                </div>
                                            </div>

                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>

                                <div class="granit-precious-row flex-column">
                                    <label class="my-0"><b>*Default</b> is a bust shot if nothing is indicated</label>
                                    <label class="my-0 ml-4">If areas in photo are to be omitted - please indicate in special<br> instructions</label>
                                    <label class="my-0"><b>***Important:</b> Choose photos with good contrast and quality to achieve<br> desired outcomes</label>
                                    <label class="font-weight-bold my-0 ml-4">If submitting a scanned photo, image must be 300 dpi</label>
                                </div>

                            </div>

                            <div class="px-2">

                                <b-form-group>
                                    <b-form-checkbox-group plain>

                                        <div class="d-flex">
                                            <div class="col-6 text-center">
                                                <img :src="storagePath + 'subject_vertical.svg'" class="d-block mx-auto my-1 product-image" alt="product-file">
                                                <b-form-checkbox value="subject_vertical" class="custom-radio-and-checkbox"><label>1 Subject Vertical</label></b-form-checkbox>
                                            </div>
                                            <div class="text-center">
                                                <img :src="storagePath + 'subjects_vertical.svg'" class="d-block mx-auto my-1 product-image" alt="product-file">
                                                <b-form-checkbox value="subjects-vertical" class="custom-radio-and-checkbox"><label>2 Subjects Vertical</label></b-form-checkbox>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <div class="col-6 text-center">
                                                <img :src="storagePath + 'subject_horizontal.svg'" class="d-block mx-auto product-image" alt="product-file">
                                                <b-form-checkbox value="subject-horizontal" class="custom-radio-and-checkbox"><label>1 Subject Horizontal</label></b-form-checkbox>
                                            </div>
                                            <div class="text-center">
                                                <img :src="storagePath + 'subjects_horizontal.svg'" class="d-block mx-auto product-image" alt="product-file">
                                                <b-form-checkbox value="subjects-horizontal" class="custom-radio-and-checkbox"><label>2 Subjects Horizontal</label></b-form-checkbox>
                                            </div>
                                        </div>

                                    </b-form-checkbox-group>
                                </b-form-group>

                            </div>

                        </div>

                        <div class="granit-precious-row">
                            <h6 class="font-weight-bold my-2">Order Instructions:</h6>
                        </div>
                        <div class="granit-precious-custom-border-bottom"></div>
                        <div class="granit-precious-row">
                            <label class="mx-5">Please select one:</label>

                            <div class="col-2 p-0">
                                <div class="granit-precious-custom-border-bottom w-25"></div>
                                <label>Color</label>
                            </div>

                            <div class="col-3 ml-3 p-0">
                                <div class="granit-precious-custom-border-bottom w-25"></div>
                                <label>Black & White</label>
                            </div>

                            <div>
                                <div class="granit-precious-custom-border-bottom w-25"></div>
                                <label class="w-75">Brown & White</label>
                            </div>


                        </div>
                        <div class="granit-precious-row w-75">
                            <label class="mx-5">Please select one:</label>

                            <div class="col-3 p-0">
                                <div class="granit-precious-custom-border-bottom w-25"></div>
                                <label>Vertical</label>
                                <div class="granit-precious-custom-border vertical-shape my-0"></div>
                            </div>

                            <div >
                                <div class="granit-precious-custom-border-bottom w-25"></div>
                                <label>Horizontal</label>
                                <div class="granit-precious-custom-border my-auto horizontal-shape"></div>
                            </div>


                        </div>

                        <div class="granit-precious-row">
                            <b-table-simple small bordered class="small">

                                <b-thead>
                                    <b-tr>
                                        <b-th colspan="2"></b-th>
                                        <b-th colspan="6">Oval</b-th>
                                        <b-th colspan="4">Rectangular</b-th>
                                        <b-th colspan="2">Heart</b-th>
                                        <b-th colspan="2">Round</b-th>
                                    </b-tr>
                                    <b-tr>
                                        <b-th colspan="2">Portraits (choose one)</b-th>
                                        <b-th>#0 <br> 5x7</b-th>
                                        <b-th>#1 <br> 4<small>1/4</small>x6</b-th>
                                        <b-th>#2 <br> 3<small>3/4</small>x5 </b-th>
                                        <b-th>#3 <br> 3<small>1/4</small>x4<small>1/4</small></b-th>
                                        <b-th>#4 <br> 2 5/8x3 3/8</b-th>
                                        <b-th>#5 <br> 2<small>1/4</small>x2<small>3/4</small></b-th>
                                        <b-th>8x10</b-th>
                                        <b-th>5x7</b-th>
                                        <b-th>4x5</b-th>
                                        <b-th>4x4</b-th>
                                        <b-th>6x6</b-th>
                                        <b-th>4x4</b-th>
                                        <b-th>6 in</b-th>
                                        <b-th>3<small>1/2</small> in</b-th>
                                    </b-tr>
                                </b-thead>
                                <b-tbody>

                                    <b-tr>
                                        <b-td colspan="2">Flat Portrait</b-td>
                                        <b-td>
                                            <div class="mt-0">

                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">

                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">

                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">

                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">

                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">

                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                            </div>
                                        </b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-td colspan="2">Flat Pinned Portrait</b-td>
                                        <b-td>
                                            <div class="mt-0">
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-td colspan="2">Flat Portrait w/VHB Tape</b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-td colspan="2">Domed Portrait</b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-td colspan="2">Domed Pinned Portrait</b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                    </b-tr>

                                    <b-tr>
                                        <b-td colspan="16"><label class="font-weight-bold m-0">Frames (optional)</label></b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-td colspan="16">Open Bronze Frame</b-td>
                                    </b-tr>

                                    <b-tr>
                                        <b-td colspan="2" class="text-center">Original</b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-td colspan="2" class="text-center">Polished</b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                    </b-tr>

                                    <b-tr>
                                        <b-td colspan="16">Covered Bronze Frame  (Will not accept domed photos)</b-td>
                                    </b-tr>

                                    <b-tr>
                                        <b-td colspan="2">Plain Colored</b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-td colspan="2">Plain Polished</b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-td colspan="2">Decorative Colored</b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-td colspan="2">Decorative Polished</b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                    </b-tr>

                                    <b-tr>
                                        <b-td colspan="16"><label></label></b-td>
                                    </b-tr>

                                    <b-tr>
                                        <b-td colspan="2">Cast Bronze Ring*</b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0"></div>
                                        </b-td>
                                    </b-tr>

                                </b-tbody>
                                <b-tfoot>
                                    <b-tr>
                                        <b-td colspan="16" class="small">
                                            *Raised, polished frame cast on the bronze memorial to accent the portrait like a border.
                                        </b-td>
                                    </b-tr>
                                </b-tfoot>
                            </b-table-simple>
                        </div>

                        <div class="granit-precious-row">
                            <h6 class="text-nowrap my-0">Special Instructions:</h6>
                            <div class="granit-precious-custom-border-bottom my-0"></div>
                        </div>

                        <hr class="granit-precious-custom-border-bottom my-2">
                        <hr class="granit-precious-custom-border-bottom mt-4">

                        <div class="granit-precious-row">
                            <label class="mx-0">Individuals from different photos or area of photo brought together on one medallion?</label>
                            <b-form-group class="mx-4 my-auto custom-radio-and-checkbox">
                                <b-form-checkbox-group plain>
                                    <b-form-checkbox value="1">Yes</b-form-checkbox>
                                    <b-form-checkbox value="0" class="mx-2">No</b-form-checkbox>
                                </b-form-checkbox-group>
                            </b-form-group>
                        </div>
                        <div class="granit-precious-row flex-column mx-5">
                            <div>
                                <div class="granit-precious-custom-border-bottom w-25"></div>
                                <label>Man on left / Woman on right</label>
                            </div>
                            <div>
                                <div class="granit-precious-custom-border-bottom w-25"></div>
                                <label>Woman on left / Woman on right</label>
                            </div>

                            <label class="m-0">(There is no charge when people are already next to each other in the same photo)</label>
                        </div>
                        <div class="granit-precious-row">
                            <label class="mx-0">Remove background from one photo</label>
                            <b-form-group class="mx-2 my-auto custom-radio-and-checkbox">
                                <b-form-checkbox-group plain>
                                    <b-form-checkbox value="1">Yes</b-form-checkbox>
                                    <b-form-checkbox value="0" class="mx-2">No</b-form-checkbox>
                                </b-form-checkbox-group>
                            </b-form-group>
                        </div>
                        <div class="granit-precious-row">
                            <label class="mx-0">Precious Portrait to be attached to a Memorial by Granit Bronz</label>
                            <b-form-group class="mx-2 my-auto custom-radio-and-checkbox">
                                <b-form-checkbox-group plain>
                                    <b-form-checkbox value="1">Yes</b-form-checkbox>
                                    <b-form-checkbox value="0" class="mx-2">No</b-form-checkbox>
                                </b-form-checkbox-group>
                            </b-form-group>
                        </div>
                        <div class="granit-precious-row">
                            <label class="mx-0">Please indicate Name on Memorial:</label>
                            <div class="granit-precious-custom-border-bottom mx-2 w-50"></div>
                        </div>
                        <div class="granit-precious-row my-2">
                            <label class="mx-0">Use this form when ordering Precious Portraits and attach to appropriate Memorial Order Form when applicable.</label>
                        </div>
                        <div class="granit-precious-row">
                            <div class="flex-column w-50">
                                <label class="m-0">Cold Spring Memorial Group</label>
                                <label class="m-0">17482 Granite West Road</label>
                                <label class="m-0">Cold Spring, MN 56320-4578</label>
                            </div>
                            <div class="flex-column">
                                <div class="m-0">
                                    <label class="m-0">Phone:</label>
                                    <label class="m-0 mx-1">800-328-2312</label>

                                    <label class="m-0 ml-4">Fax:</label>
                                    <label class="m-0 mx-1">800-873-8122</label>
                                </div>
                                <div class="m-0">
                                    <label class="m-0">Email:</label>
                                    <label class="m-0 mx-1">gbmem@coldspringgranite.com</label>
                                </div>

                            </div>
                        </div>

                        <div class="granit-precious-row non-print-elm mt-1">
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
            storagePath: 'images/order/',
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
    width: 45rem;
}
.granit-precious-row
{
    display: flex;
    padding: 0;
}
.granit-precious-row div
{
    display: flex;
    margin: 0.3rem 0;
    width: 100%;
}
.granit-precious-row label{
    margin: auto 0.5rem;
    white-space: nowrap !important;
    color: #000;
}
.granit-precious-row div input{
    /*border: 1px solid #dee2e6;*/
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
    white-space: nowrap !important;
}
.label-sm{
    font-size: 0.6rem !important;
}
.granit-precious-custom-label{
    font-family: "Times New Roman" !important;
    text-transform: uppercase !important;
}
.granit-precious-custom-border{
    border: 2px solid #000 !important;
}
.granit-precious-custom-border-left{
    border-left: 2px solid #000 !important;
}
.granit-precious-custom-border-bottom{
    border-bottom: 1px solid #000 !important;
}
.granit-precious-custom-border-right{
    border-right: 2px solid #000 !important;
}
.granit-precious-custom-border-top{
    border-top: 2px solid #000 !important;
}

.granit-precious-custom-dotted-border-bottom{
    border-bottom: 2px dotted #000 !important;
}

.printing input, .printing textarea{
    border-color: inherit !important;
}

table{
    font-size: 0.7rem;
}
.table thead th{
    text-align: center !important;
    white-space: nowrap !important;
}
.table tbody td{
    padding: 0 0 0 .5rem !important;
}
table.table-bordered, table.table-bordered > thead > tr > th, table.table-bordered > tbody > tr > td,
table.table-bordered > tfoot > tr > td{
    border:1px solid #000 !important;
}


table .bg-secondary{
    background: #6B6861 !important;
}

.vertical-shape{
    height: 30px !important;
    width: 20px !important;
    border-radius: 50%;
}
.horizontal-shape {
    height: 20px !important;
    width: 35px !important;
    border-radius: 50%;
}
</style>
