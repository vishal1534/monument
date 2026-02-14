<template>

    <div>
        <h5 class="mx-2 my-1 non-print-elm custom-view-heading">Granit Bronz Precious Portrait Order Form</h5>
        <div class="d-flex non-print-elm justify-content-center bg-toolbar my-2 p-1">
            <button type="button" v-if="formFields.granit_bronz_precious.id > 0 ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1 px-4 w-auto custom-infobtn-toolbar custom-infobtn-text"
                    @click="save" :disabled="saveDisabled">
                {{ formFields.granit_bronz_precious.id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
            </button>
            <router-link class="btn btn-sm btn-warning mx-1 px-4 custom-dangerbtn-toolbar custom-dangerbtn-text"
                         :to="'/orders/'+formFields.id">Back
            </router-link>

        </div>

        <div class="row ">
            <div class="col-md-12">

                <div v-bind:class="[alertClasses, 'd-flex non-print-elm justify-content-center m-auto p-1 w-50']">
                    {{alertMessage}}
                </div>

                <form class="div-shadow bg-white rounded mx-2 mb-2 p-3">

                    <div class="form-content">
                        <div class="granit-precious-row border rounded">

                            <div class="d-block border-right px-1 m-0">
                                <label class="font-weight-bold">Date:</label>
                                <label class="d-block">{{ changeDateFormat(formFields.date) }}</label>
                            </div>
                            <div class="d-block border-right px-1 m-0">
                                <label class="font-weight-bold">GB Account #:</label>
                                <label v-if="inPDF" class="d-block">{{formFields.gb_account}}</label>
<!--                                <label v-if="inPDF" class="d-block">{{formFields.company.name}}</label>-->
                                <b-form-input v-if="!inPDF" type="text" name="po" class="input-lg " size="sm"
                                              v-model="formFields.gb_account"></b-form-input>
                            </div>
                            <div class="d-block border-right px-1 m-0">
                                <label class="font-weight-bold">Last Name on Stone:</label>
                                <label class="d-block">{{formFields.family.name_on_stone ? formFields.family.name_on_stone : ''}}</label>
                            </div>
                            <div class="d-block px-1 m-0">
                                <label class="font-weight-bold">Invoice No.</label>
                                <label class="d-block">{{ formFields.invoice.invoice_number }}</label>
                            </div>
                        </div>

                        <div class="granit-precious-row">
                            <label class="col-2 px-0 font-weight-bold mx-0 my-auto">Company Name:</label>
                            <b-form-input type="text" class="col-8 h-100" size="sm"
                                          v-model="formFields.granit_bronz_precious.company_name"></b-form-input>
                        </div>
                        <div class="granit-precious-row">
                            <label class="col-2 px-0 font-weight-bold">Address:</label>
                            <b-form-textarea
                                    class="col-8"
                                    size="sm"
                                    v-model="formFields.granit_bronz_precious.address"
                                    no-resize
                            ></b-form-textarea>
                        </div>
                        <div class="granit-precious-row">
                            <label class="col-2 px-0 font-weight-bold mx-0 my-auto">Family Name:</label>
                            <b-form-input type="text" class="col-8 h-100" size="sm"
                                          v-model="formFields.granit_bronz_precious.family_name"></b-form-input>
                        </div>



                        <div class="d-flex custom-border-top custom-border-bottom">
                            <div class="col-8 custom-border-right">
                                <div class="granit-precious-row">
                                    <label class="font-weight-bold mx-0">Photograph View</label>
                                </div>
                                <div class="granit-precious-row">
                                    <img :src="`/${storagePath + 'bust.svg'}`" class="col-2 product-image" alt="product-file">
                                    <img :src="`/${storagePath + 'half_view.svg'}`"  class="col-2 mx-3 product-image"
                                         alt="product-file">
                                    <img :src="`/${storagePath + 'three_by_four_view.svg'}`"  class="col-2 product-image"
                                         alt="product-file">
                                    <img :src="`/${storagePath + 'full_figure.svg'}`" class="col-2 mx-3 product-image"
                                         alt="product-file">
                                    <img :src="`/${storagePath + 'entire_photo.svg'}`" class="col-2 product-image"
                                         alt="product-file">
                                </div>
                                <div class="granit-precious-row">
                                    <b-form-group class="w-100 custom-radio-and-checkbox">
                                        <b-form-checkbox-group class="granit-bronz-precious-checkbox ml-2"
                                                               v-model="formFields.granit_bronz_precious.horizontal_photographs"
                                                               plain>
                                            <b-form-checkbox class="col-2 flex-column" value="bust">Bust*
                                            </b-form-checkbox>
                                            <b-form-checkbox class="col-2 flex-column mx-3 text-nowrap"
                                                             value="1-2-view">1/2 View
                                            </b-form-checkbox>
                                            <b-form-checkbox class="col-2 flex-column text-nowrap" value="3-4-view">3/4
                                                View
                                            </b-form-checkbox>
                                            <b-form-checkbox class="col-2 flex-column mx-3 text-nowrap"
                                                             value="full-figure">Full Figure
                                            </b-form-checkbox>
                                            <b-form-checkbox class="col-2 flex-column text-nowrap" value="entire-photo">
                                                Entire Photo
                                            </b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                                <div class="granit-precious-row flex-column">
                                    <label class="my-0"><b>*Default</b> is a bust shot if nothing is indicated</label>
                                    <label class="my-0 ml-4">If areas in photo are to be omitted - please indicate in
                                        special<br> instructions</label>
                                    <label class="my-0"><b>***Important:</b> Choose photos with good contrast and
                                        quality to achieve<br> desired outcomes</label>
                                    <label class="font-weight-bold my-0 ml-4">If submitting a scanned photo, image must
                                        be 300 dpi</label>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="col-6 d-flex flex-column">
                                    <img :src="`/${storagePath + 'subject_vertical.svg'}`" class="my-2 product-image"
                                         alt="product-file">
                                    <img :src="`/${storagePath + 'subjects_vertical.svg'}`" class="my-1 product-image"
                                         alt="product-file">
                                    <img :src="`/${storagePath + 'subject_horizontal.svg'}`" class="product-image"
                                         alt="product-file">
                                    <img :src="`/${storagePath + 'subjects_horizontal.svg'}`" class="product-image"
                                         alt="product-file">
                                </div>
                                <div class="col-6 p-0">
                                    <b-form-group class="w-100 custom-radio-and-checkbox pt-2">
                                        <b-form-checkbox-group
                                                v-model="formFields.granit_bronz_precious.vertical_photographs" plain>
                                            <b-form-checkbox value="subject_vertical" class="my-4 text-nowrap" :class="inPDF ? 'custom-margin-topCheckBox' : '' "
                                                             style="line-height: 1.5">Subject Vertical
                                            </b-form-checkbox>
                                            <b-form-checkbox value="subjects-vertical" class="my-4 text-nowrap" :class="inPDF ? 'custom-margin-snd-subjectVertical' : '' "
                                                             style="line-height: 1.5">Subjects Vertical
                                            </b-form-checkbox>
                                            <b-form-checkbox value="subject-horizontal" class="my-4 text-nowrap" :class="inPDF ? '' : 'custom-margin-SubjectHorizontal'"
                                                             style="line-height: 1.5">Subject Horizontal
                                            </b-form-checkbox>
                                            <b-form-checkbox value="subjects-horizontal" class="my-4 text-nowrap custom-margin-subjectHorizontal" :class="inPDF ? '' : 'custom-marginLast-subjectHorizon'"
                                                             style="line-height: 1.5">Subjects Horizontal
                                            </b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </div>

                        </div>

                        <div class="granit-precious-row">
                            <label class="font-weight-bold">Order Instructions:</label>
                        </div>
                        <div class="granit-precious-row">
                            <div class="w-auto">
                                <label class="font-weight-bold mt-1">Color</label>
                                <b-form-select
                                        v-model="formFields.granit_bronz_precious.color"
                                        :options="colors"
                                        class="custom-caret-agreement input-select custom-dropdown border rounded my-0 mx-4 non-print-elm"
                                        size="sm">
                                    <template #first>
                                        <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                                    </template>

                                </b-form-select>
                                <label class="print-elm my-1 mx-2 "><small>{{ formFields.granit_bronz_precious.color ?
                                    formFields.granit_bronz_precious.color : 'Select' }}
                                </small></label>
                                <!--<b-dropdown no-caret class="custom-dropdown border rounded my-0 mx-4 non-print-elm " size="sm"
                                            variant="none">

                                    <template #button-content>
                                        <div class="d-flex">
                                            <small>{{ formFields.granit_bronz_precious.color ?
                                                formFields.granit_bronz_precious.color : 'Select' }}
                                            </small>
                                            <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                                        </div>
                                    </template>

                                    <b-dropdown-group class="dropdown-align">
                                        <b-dropdown-group>
                                            <b-dropdown-item-button
                                                    @click="formFields.granit_bronz_precious.color = 'Color'">
                                                <button type="button" class="btn btn-sm m-0 my-n2">Color</button>
                                            </b-dropdown-item-button>
                                            <b-dropdown-item-button
                                                    @click="formFields.granit_bronz_precious.color = 'Black & White'">
                                                <button type="button" class="btn btn-sm m-0 my-n2">Black & White
                                                </button>
                                            </b-dropdown-item-button>
                                            <b-dropdown-item-button
                                                    @click="formFields.granit_bronz_precious.color = 'Brown & White'">
                                                <button type="button" class="btn btn-sm m-0 my-n2">Brown & White
                                                </button>
                                            </b-dropdown-item-button>
                                        </b-dropdown-group>
                                    </b-dropdown-group>

                                </b-dropdown>
                            --></div>

                            <div class="w-auto">
                                <label class="font-weight-bold mt-1">Orientation</label>
                                <b-form-select
                                        v-model="formFields.granit_bronz_precious.orientation"
                                        :options="orientations"
                                        class="custom-caret-agreement input-select custom-dropdown border rounded my-0 mx-4 non-print-elm"
                                        size="sm">
                                    <template #first>
                                        <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                                    </template>

                                </b-form-select>
                                <label class="print-elm my-1 mx-2"> <small>{{ formFields.granit_bronz_precious.orientation ?
                                    formFields.granit_bronz_precious.orientation : 'Select' }}
                                </small></label>
                                <!--<b-dropdown no-caret class="custom-dropdown border rounded my-0 mx-4 non-print-elm" toggle-class="p-0"
                                            size="sm" variant="none">

                                    <template #button-content>
                                        <div class="d-flex px-2">
                                            <small>{{ formFields.granit_bronz_precious.orientation ?
                                                formFields.granit_bronz_precious.orientation : 'Select' }}
                                            </small>
                                            <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                                        </div>
                                    </template>

                                    <b-dropdown-group>
                                        <b-dropdown-group>
                                            <b-dropdown-item-button
                                                    @click="formFields.granit_bronz_precious.orientation = 'Vertical'">
                                                <button type="button" class="btn btn-sm m-0 my-n2">Vertical</button>
                                            </b-dropdown-item-button>
                                            <b-dropdown-item-button
                                                    @click="formFields.granit_bronz_precious.orientation = 'Horizontal'">
                                                <button type="button" class="btn btn-sm m-0 my-n2">Horizontal</button>
                                            </b-dropdown-item-button>
                                        </b-dropdown-group>
                                    </b-dropdown-group>

                                </b-dropdown>
                           --> </div>

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
                                        <b-th>#1 <br> 4
                                            <small>1/4</small>
                                            x6
                                        </b-th>
                                        <b-th>#2 <br> 3
                                            <small>3/4</small>
                                            x5
                                        </b-th>
                                        <b-th>#3 <br> 3
                                            <small>1/4</small>
                                            x4
                                            <small>1/4</small>
                                        </b-th>
                                        <b-th>#4 <br> 2 5/8x3 3/8</b-th>
                                        <b-th>#5 <br> 2
                                            <small>1/4</small>
                                            x2
                                            <small>3/4</small>
                                        </b-th>
                                        <b-th>8x10</b-th>
                                        <b-th>5x7</b-th>
                                        <b-th>4x5</b-th>
                                        <b-th>4x4</b-th>
                                        <b-th>6x6</b-th>
                                        <b-th>4x4</b-th>
                                        <b-th>6 in</b-th>
                                        <b-th>3
                                            <small>1/2</small>
                                            in
                                        </b-th>
                                    </b-tr>
                                </b-thead>
                                <b-tbody>

                                    <b-tr>
                                        <b-td colspan="2">Flat Portrait</b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="portrait_oval_0"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait.oval_0"/>
                                                <label  class="table-checkbox my-0 mx-auto w-100 text-center"
                                                        :class="inPDF ? formFields.granit_bronz_precious.flat_portrait.oval_0 == true ? 'print_elm' : 'non-print-elm' : 'print_elm' "
                                                       for="portrait_oval_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="portrait_oval_1"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait.oval_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait.oval_1 == true ? 'print-elm' : 'non-print-elm' : 'print_elm' "
                                                       for="portrait_oval_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="portrait_oval_2"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait.oval_2"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait.oval_2 == true ? 'print-elm': 'non-print-elm' : 'print_elm' "
                                                       for="portrait_oval_2">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="portrait_oval_3"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait.oval_3"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait.oval_3 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="portrait_oval_3">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="portrait_oval_4"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait.oval_4"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait.oval_4 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="portrait_oval_4">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="portrait_oval_5"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait.oval_5"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait.oval_5 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="portrait_oval_5">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="portrait_rectangular_0"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait.rectangular_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait.rectangular_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="portrait_rectangular_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="portrait_rectangular_1"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait.rectangular_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait.rectangular_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="portrait_rectangular_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="portrait_rectangular_2"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait.rectangular_2"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait.rectangular_2 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="portrait_rectangular_2">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="portrait_rectangular_3"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait.rectangular_3"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait.rectangular_3 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="portrait_rectangular_3">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="portrait_heart_0"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait.heart_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait.heart_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="portrait_heart_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="portrait_heart_1"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait.heart_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait.heart_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="portrait_heart_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="portrait_round_0"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait.round_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait.round_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="portrait_round_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="portrait_round_1"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait.round_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait.round_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="portrait_round_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-td colspan="2">Flat Pinned Portrait</b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="pinned_portrait_oval_0"
                                                       v-model="formFields.granit_bronz_precious.flat_pinned_portrait.oval_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_pinned_portrait.oval_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="pinned_portrait_oval_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="pinned_portrait_oval_1"
                                                       v-model="formFields.granit_bronz_precious.flat_pinned_portrait.oval_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_pinned_portrait.oval_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="pinned_portrait_oval_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="pinned_portrait_oval_2"
                                                       v-model="formFields.granit_bronz_precious.flat_pinned_portrait.oval_2"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_pinned_portrait.oval_2 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="pinned_portrait_oval_2">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="pinned_portrait_oval_3"
                                                       v-model="formFields.granit_bronz_precious.flat_pinned_portrait.oval_3"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_pinned_portrait.oval_3 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="pinned_portrait_oval_3">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="pinned_portrait_oval_4"
                                                       v-model="formFields.granit_bronz_precious.flat_pinned_portrait.oval_4"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_pinned_portrait.oval_4 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="pinned_portrait_oval_4">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="pinned_portrait_oval_5"
                                                       v-model="formFields.granit_bronz_precious.flat_pinned_portrait.oval_5"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_pinned_portrait.oval_5 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="pinned_portrait_oval_5">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="pinned_portrait_rectangular_0"
                                                       v-model="formFields.granit_bronz_precious.flat_pinned_portrait.rectangular_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_pinned_portrait.rectangular_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="pinned_portrait_rectangular_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="pinned_portrait_rectangular_1"
                                                       v-model="formFields.granit_bronz_precious.flat_pinned_portrait.rectangular_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_pinned_portrait.rectangular_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="pinned_portrait_rectangular_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="pinned_portrait_rectangular_2"
                                                       v-model="formFields.granit_bronz_precious.flat_pinned_portrait.rectangular_2"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_pinned_portrait.rectangular_2 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="pinned_portrait_rectangular_2">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="pinned_portrait_rectangular_3"
                                                       v-model="formFields.granit_bronz_precious.flat_pinned_portrait.rectangular_3"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_pinned_portrait.rectangular_3 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="pinned_portrait_rectangular_3">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="pinned_portrait_heart_0"
                                                       v-model="formFields.granit_bronz_precious.flat_pinned_portrait.heart_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_pinned_portrait.heart_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="pinned_portrait_heart_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="pinned_portrait_heart_1"
                                                       v-model="formFields.granit_bronz_precious.flat_pinned_portrait.heart_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_pinned_portrait.heart_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="pinned_portrait_heart_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="pinned_portrait_round_0"
                                                       v-model="formFields.granit_bronz_precious.flat_pinned_portrait.round_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_pinned_portrait.round_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="pinned_portrait_round_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="pinned_portrait_round_1"
                                                       v-model="formFields.granit_bronz_precious.flat_pinned_portrait.round_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_pinned_portrait.round_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="pinned_portrait_round_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-td colspan="2">Flat Portrait w/VHB Tape</b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="vhb_tape_portrait_oval_0"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait_vhb_type.oval_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait_vhb_type.oval_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="vhb_tape_portrait_oval_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="vhb_tape_portrait_oval_1"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait_vhb_type.oval_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait_vhb_type.oval_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="vhb_tape_portrait_oval_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="vhb_tape_portrait_oval_2"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait_vhb_type.oval_2"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait_vhb_type.oval_2 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="vhb_tape_portrait_oval_2">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="vhb_tape_portrait_oval_3"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait_vhb_type.oval_3"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait_vhb_type.oval_3 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="vhb_tape_portrait_oval_3">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="vhb_tape_portrait_oval_4"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait_vhb_type.oval_4"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait_vhb_type.oval_4 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="vhb_tape_portrait_oval_4">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="vhb_tape_portrait_oval_5"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait_vhb_type.oval_5"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait_vhb_type.oval_5 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="vhb_tape_portrait_oval_5">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="vhb_tape_portrait_rectangular_0"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait_vhb_type.rectangular_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait_vhb_type.rectangular_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="vhb_tape_portrait_rectangular_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="vhb_tape_portrait_rectangular_1"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait_vhb_type.rectangular_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait_vhb_type.rectangular_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="vhb_tape_portrait_rectangular_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="vhb_tape_portrait_rectangular_2"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait_vhb_type.rectangular_2"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait_vhb_type.rectangular_2 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="vhb_tape_portrait_rectangular_2">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="vhb_tape_portrait_rectangular_3"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait_vhb_type.rectangular_3"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait_vhb_type.rectangular_3 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="vhb_tape_portrait_rectangular_3">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="vhb_tape_portrait_heart_0"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait_vhb_type.heart_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait_vhb_type.heart_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="vhb_tape_portrait_heart_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="vhb_tape_portrait_heart_1"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait_vhb_type.heart_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait_vhb_type.heart_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="vhb_tape_portrait_heart_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="vhb_tape_portrait_round_0"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait_vhb_type.round_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait_vhb_type.round_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="vhb_tape_portrait_round_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="vhb_tape_portrait_round_1"
                                                       v-model="formFields.granit_bronz_precious.flat_portrait_vhb_type.round_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.flat_portrait_vhb_type.round_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="vhb_tape_portrait_round_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-td colspan="2">Domed Portrait</b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="domed_portrait_oval_0"
                                                       v-model="formFields.granit_bronz_precious.domed_portrait.oval_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.domed_portrait.oval_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="domed_portrait_oval_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="domed_portrait_oval_1"
                                                       v-model="formFields.granit_bronz_precious.domed_portrait.oval_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.domed_portrait.oval_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="domed_portrait_oval_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="domed_portrait_oval_2"
                                                       v-model="formFields.granit_bronz_precious.domed_portrait.oval_2"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.domed_portrait.oval_2 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="domed_portrait_oval_2">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="domed_portrait_oval_3"
                                                       v-model="formFields.granit_bronz_precious.domed_portrait.oval_3"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.domed_portrait.oval_3 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="domed_portrait_oval_3">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="domed_portrait_oval_4"
                                                       v-model="formFields.granit_bronz_precious.domed_portrait.oval_4"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.domed_portrait.oval_4 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="domed_portrait_oval_4">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="domed_portrait_oval_5"
                                                       v-model="formFields.granit_bronz_precious.domed_portrait.oval_5"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.domed_portrait.oval_5 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="domed_portrait_oval_5">&#10004;</label>
                                            </div>
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
                                            <div class="mt-0">
                                                <input type="checkbox" id="domed_pinned_portrait_oval_0"
                                                       v-model="formFields.granit_bronz_precious.domed_pinned_portrait.oval_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.domed_pinned_portrait.oval_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="domed_pinned_portrait_oval_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="domed_pinned_portrait_oval_1"
                                                       v-model="formFields.granit_bronz_precious.domed_pinned_portrait.oval_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.domed_pinned_portrait.oval_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="domed_pinned_portrait_oval_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="domed_pinned_portrait_oval_2"
                                                       v-model="formFields.granit_bronz_precious.domed_pinned_portrait.oval_2"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.domed_pinned_portrait.oval_2 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="domed_pinned_portrait_oval_2">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="domed_pinned_portrait_oval_3"
                                                       v-model="formFields.granit_bronz_precious.domed_pinned_portrait.oval_3"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.domed_pinned_portrait.oval_3 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="domed_pinned_portrait_oval_3">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="domed_pinned_portrait_oval_4"
                                                       v-model="formFields.granit_bronz_precious.domed_pinned_portrait.oval_4"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.domed_pinned_portrait.oval_4 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="domed_pinned_portrait_oval_4">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="domed_pinned_portrait_oval_5"
                                                       v-model="formFields.granit_bronz_precious.domed_pinned_portrait.oval_5"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.domed_pinned_portrait.oval_5 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="domed_pinned_portrait_oval_5">&#10004;</label>
                                            </div>
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
                                        <b-td colspan="16"><label class="font-weight-bold m-0">Frames (optional)</label>
                                        </b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-td colspan="16">Open Bronze Frame</b-td>
                                    </b-tr>

                                    <b-tr>
                                        <b-td colspan="2" class="text-center">Original</b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="original_frame_oval_0"
                                                       v-model="formFields.granit_bronz_precious.original_frame.oval_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.original_frame.oval_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="original_frame_oval_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="original_frame_oval_1"
                                                       v-model="formFields.granit_bronz_precious.original_frame.oval_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.original_frame.oval_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="original_frame_oval_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="original_frame_oval_2"
                                                       v-model="formFields.granit_bronz_precious.original_frame.oval_2"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.original_frame.oval_2 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="original_frame_oval_2">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="original_frame_oval_3"
                                                       v-model="formFields.granit_bronz_precious.original_frame.oval_3"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.original_frame.oval_3 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="original_frame_oval_3">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="original_frame_oval_4"
                                                       v-model="formFields.granit_bronz_precious.original_frame.oval_4"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.original_frame.oval_4 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="original_frame_oval_4">&#10004;</label>
                                            </div>
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
                                            <div class="mt-0">
                                                <input type="checkbox" id="polished_frame_oval_0"
                                                       v-model="formFields.granit_bronz_precious.polished_frame.oval_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.polished_frame.oval_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="polished_frame_oval_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="polished_frame_oval_1"
                                                       v-model="formFields.granit_bronz_precious.polished_frame.oval_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.polished_frame.oval_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="polished_frame_oval_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="polished_frame_oval_2"
                                                       v-model="formFields.granit_bronz_precious.polished_frame.oval_2"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.polished_frame.oval_2 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="polished_frame_oval_2">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="polished_frame_oval_3"
                                                       v-model="formFields.granit_bronz_precious.polished_frame.oval_3"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.polished_frame.oval_3 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="polished_frame_oval_3">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="polished_frame_oval_4"
                                                       v-model="formFields.granit_bronz_precious.polished_frame.oval_4"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.polished_frame.oval_4 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="polished_frame_oval_4">&#10004;</label>
                                            </div>
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
                                        <b-td colspan="16">Covered Bronze Frame (Will not accept domed photos)</b-td>
                                    </b-tr>

                                    <b-tr>
                                        <b-td colspan="2">Plain Colored</b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td class="bg-secondary"></b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="plain_colored_bronze_frame_oval_3"
                                                       v-model="formFields.granit_bronz_precious.plain_colored.oval_3"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.plain_colored.oval_3 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="plain_colored_bronze_frame_oval_3">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="plain_colored_bronze_frame_oval_4"
                                                       v-model="formFields.granit_bronz_precious.plain_colored.oval_4"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.plain_colored.oval_4 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="plain_colored_bronze_frame_oval_4">&#10004;</label>
                                            </div>
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
                                            <div class="mt-0">
                                                <input type="checkbox" id="plain_polished_bronze_frame_oval_3"
                                                       v-model="formFields.granit_bronz_precious.plain_polished.oval_3"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.plain_polished.oval_3 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="plain_polished_bronze_frame_oval_3">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="plain_polished_bronze_frame_oval_4"
                                                       v-model="formFields.granit_bronz_precious.plain_polished.oval_4"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.plain_polished.oval_4 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="plain_polished_bronze_frame_oval_4">&#10004;</label>
                                            </div>
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
                                            <div class="mt-0">
                                                <input type="checkbox" id="decorative_colored_bronze_frame_oval_3"
                                                       v-model="formFields.granit_bronz_precious.decorative_colored.oval_3"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.decorative_colored.oval_3 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="decorative_colored_bronze_frame_oval_3">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="decorative_colored_bronze_frame_oval_4"
                                                       v-model="formFields.granit_bronz_precious.decorative_colored.oval_4"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.decorative_colored.oval_4 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="decorative_colored_bronze_frame_oval_4">&#10004;</label>
                                            </div>
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
                                            <div class="mt-0">
                                                <input type="checkbox" id="decorative_polished_bronze_frame_oval_3"
                                                       v-model="formFields.granit_bronz_precious.decorative_polished.oval_3"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.decorative_polished.oval_3 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="decorative_polished_bronze_frame_oval_3">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="decorative_polished_bronze_frame_oval_4"
                                                       v-model="formFields.granit_bronz_precious.decorative_polished.oval_4"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.decorative_polished.oval_4 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="decorative_polished_bronze_frame_oval_4">&#10004;</label>
                                            </div>
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
                                            <div class="mt-0">
                                                <input type="checkbox" id="cast_bronze_ring_oval_0"
                                                       v-model="formFields.granit_bronz_precious.cast_bronze_ring.oval_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.cast_bronze_ring.oval_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="cast_bronze_ring_oval_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="cast_bronze_ring_oval_1"
                                                       v-model="formFields.granit_bronz_precious.cast_bronze_ring.oval_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.cast_bronze_ring.oval_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="cast_bronze_ring_oval_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="cast_bronze_ring_oval_2"
                                                       v-model="formFields.granit_bronz_precious.cast_bronze_ring.oval_2"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.cast_bronze_ring.oval_2 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="cast_bronze_ring_oval_2">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="cast_bronze_ring_oval_3"
                                                       v-model="formFields.granit_bronz_precious.cast_bronze_ring.oval_3"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.cast_bronze_ring.oval_3 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="cast_bronze_ring_oval_3">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="cast_bronze_ring_oval_4"
                                                       v-model="formFields.granit_bronz_precious.cast_bronze_ring.oval_4"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.cast_bronze_ring.oval_4 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="cast_bronze_ring_oval_4">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="cast_bronze_ring_oval_5"
                                                       v-model="formFields.granit_bronz_precious.cast_bronze_ring.oval_5"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.cast_bronze_ring.oval_5 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="cast_bronze_ring_oval_5">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="cast_bronze_ring_rectangular_0"
                                                       v-model="formFields.granit_bronz_precious.cast_bronze_ring.rectangular_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.cast_bronze_ring.rectangular_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="cast_bronze_ring_rectangular_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="cast_bronze_ring_rectangular_1"
                                                       v-model="formFields.granit_bronz_precious.cast_bronze_ring.rectangular_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.cast_bronze_ring.rectangular_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="cast_bronze_ring_rectangular_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="cast_bronze_ring_rectangular_2"
                                                       v-model="formFields.granit_bronz_precious.cast_bronze_ring.rectangular_2"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.cast_bronze_ring.rectangular_2 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="cast_bronze_ring_rectangular_2">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="cast_bronze_ring_rectangular_3"
                                                       v-model="formFields.granit_bronz_precious.cast_bronze_ring.rectangular_3"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.cast_bronze_ring.rectangular_3 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="cast_bronze_ring_rectangular_3">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="cast_bronze_ring_heart_0"
                                                       v-model="formFields.granit_bronz_precious.cast_bronze_ring.heart_0"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.cast_bronze_ring.heart_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="cast_bronze_ring_heart_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="cast_bronze_ring_heart_1"
                                                       v-model="formFields.granit_bronz_precious.cast_bronze_ring.heart_1"/>
                                                <label class="table-checkbox my-0 mx-auto w-100 text-center"
                                                       :class="inPDF ? formFields.granit_bronz_precious.cast_bronze_ring.heart_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="cast_bronze_ring_heart_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="cast_bronze_ring_round_0"
                                                       v-model="formFields.granit_bronz_precious.cast_bronze_ring.round_0"/>
                                                <label class="table-checkbox my-0 mx-auto px-2"
                                                       :class="inPDF ? formFields.granit_bronz_precious.cast_bronze_ring.round_0 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="cast_bronze_ring_round_0">&#10004;</label>
                                            </div>
                                        </b-td>
                                        <b-td>
                                            <div class="mt-0">
                                                <input type="checkbox" id="cast_bronze_ring_round_1"
                                                       v-model="formFields.granit_bronz_precious.cast_bronze_ring.round_1"/>
                                                <label class="table-checkbox my-0 mx-auto px-2"
                                                       :class="inPDF ? formFields.granit_bronz_precious.cast_bronze_ring.round_1 == true ? 'print-elm': 'non-print-elm' : 'print_elm'"
                                                       for="cast_bronze_ring_round_1">&#10004;</label>
                                            </div>
                                        </b-td>
                                    </b-tr>

                                </b-tbody>
                                <b-tfoot>
                                    <b-tr>
                                        <b-td colspan="16" class="small">
                                            *Raised, polished frame cast on the bronze memorial to accent the portrait
                                            like a border.
                                        </b-td>
                                    </b-tr>
                                </b-tfoot>
                            </b-table-simple>
                        </div>

                        <hr class="border non-print-elm">

                        <div class="granit-precious-row mt-5"  style="page-break-before: always">
                            <label class="font-weight-bold mt-1">Special<br> Instructions:</label>
                            <b-form-textarea
                                    rows="4"
                                    class="ml-2"
                                    size="sm"
                                    v-model="formFields.granit_bronz_precious.special_instructions"
                                    no-resize
                            ></b-form-textarea>
                        </div>
                        <div class="granit-precious-row">
                            <label class="font-weight-bold my-auto">Individuals from different photos or area of photo
                                brought together on one medallion?</label>
                            <!--<label class="ml-2 mt-2 print-elm">{{formFields.granit_bronz_precious.medallion?'Yes':'No'}}</label>
                            -->
                            <label class="ml-2 mt-2 print-elm" v-if="formFields.granit_bronz_precious.medallion && formFields.granit_bronz_precious.medallion == 1">Yes</label>
                            <label class="ml-2 mt-2 print-elm" v-if="formFields.granit_bronz_precious.medallion == 0">No</label>
                            <b-form-group class="mx-4 my-auto custom-radio-and-checkbox non-print-elm">
                                <b-form-radio-group name="medallion"
                                                    v-model="formFields.granit_bronz_precious.medallion">
                                    <b-form-radio name="medallion-radio" class="mx-2" value="1" size="sm">Yes
                                    </b-form-radio>
                                    <b-form-radio name="medallion-radio" value="0" size="sm">No</b-form-radio>
                                </b-form-radio-group>
                            </b-form-group>
                        </div>
                        <div class="granit-precious-row">
                            <label class="font-weight-bold my-2">Person placement:</label>
                            <!--<label class="ml-2 mt-2 print-elm">{{formFields.granit_bronz_precious.person_placement ? 'Man on left / Woman on right':'Woman on left / Man on right'}}</label>
                           -->
                            <label class="ml-2 mt-2 print-elm" v-if="formFields.granit_bronz_precious.person_placement && formFields.granit_bronz_precious.person_placement == 1">Man on
                                left / Woman on right</label>
                            <label class="ml-2 mt-2 print-elm" v-if="formFields.granit_bronz_precious.person_placement == 0">Woman on left / Man
                                on right</label>
                            <b-form-group class="mx-4 my-auto custom-radio-and-checkbox non-print-elm">
                                <b-form-radio-group name="person_placement" class="m-0"
                                                    v-model="formFields.granit_bronz_precious.person_placement">
                                    <b-form-radio name="person_placement-radio" class="mx-2" value="1" size="sm">Man on
                                        left / Woman on right
                                    </b-form-radio>
                                    <b-form-radio name="person_placement-radio" value="0" size="sm">Woman on left / Man
                                        on right
                                    </b-form-radio>
                                </b-form-radio-group>
                                <label class="m-0">(There is no charge when people are already next to each other in the
                                    same photo)</label>
                            </b-form-group>
                        </div>
                        <div class="granit-precious-row">
                            <label class="font-weight-bold my-auto">Remove background from one photo?</label>
                            <!--<label class="ml-2 mt-2 print-elm">{{formFields.granit_bronz_precious.remove_background ? 'Yes':'No'}}</label>
                            -->
                            <label class="ml-2 mt-2 print-elm" v-if="formFields.granit_bronz_precious.remove_background && formFields.granit_bronz_precious.remove_background == 1">Yes</label>
                            <label class="ml-2 mt-2 print-elm" v-if="formFields.granit_bronz_precious.remove_background == 0">No</label>
                            <b-form-group class="mx-2 my-auto custom-radio-and-checkbox non-print-elm">
                                <b-form-radio-group name="remove_background"
                                                    v-model="formFields.granit_bronz_precious.remove_background">
                                    <b-form-radio name="remove_background-radio" class="mx-2" value="1" size="sm">Yes
                                    </b-form-radio>
                                    <b-form-radio name="remove_background-radio" value="0" size="sm">No</b-form-radio>
                                </b-form-radio-group>
                            </b-form-group>
                        </div>
                        <div class="granit-precious-row">
                            <label class="font-weight-bold my-auto">Precious Portrait to be attached to a Memorial by
                                Granit Bronz?</label>
                            <label class="ml-2 mt-2 print-elm" v-if="formFields.granit_bronz_precious.portrait_attached && formFields.granit_bronz_precious.portrait_attached == 1">Yes</label>
                            <label class="ml-2 mt-2 print-elm" v-if="formFields.granit_bronz_precious.portrait_attached == 0">No</label>
                           <!-- <label class="ml-2 mt-2 print-elm">{{formFields.granit_bronz_precious.portrait_attached ? 'Yes':'No'}}</label>
                           --> <b-form-group class="mx-2 my-auto custom-radio-and-checkbox non-print-elm">
                                <b-form-radio-group name="precious_portrait"
                                                    v-model="formFields.granit_bronz_precious.portrait_attached">
                                    <b-form-radio name="precious_portrait-radio" class="mx-2" value="1" size="sm">Yes
                                    </b-form-radio>
                                    <b-form-radio name="precious_portrait-radio" value="0" size="sm">No</b-form-radio>
                                </b-form-radio-group>
                            </b-form-group>
                        </div>
                        <div class="granit-precious-row">
                            <label class="font-weight-bold my-auto">Please indicate Name on Memorial:</label>
                            <b-form-input class="ml-2 h-100" size="sm"
                                          v-model="formFields.granit_bronz_precious.name_on_memorial"
                                          no-resize></b-form-input>
                        </div>
                        <div class="granit-precious-row mt-5">
                            <label class="font-weight-bold">Use this form when ordering Precious Portraits and attach to
                                appropriate Memorial Order Form when applicable</label>
                        </div>
                        <div class="granit-precious-row">
                            <div class="flex-column w-50">
                                <label class="font-weight-bold m-0">Cold Spring Memorial Group</label>
                                <label class="font-weight-bold m-0">17482 Granite West Road</label>
                                <label class="font-weight-bold m-0">Cold Spring, MN 56320-4578</label>
                            </div>
                            <div class="flex-column">
                                <div class="d-flex font-weight-bold m-0">
                                    <label class="col-2 m-0">Phone:</label>
                                    <label class="m-0">800-328-2312</label>
                                </div>
                                <div class="d-flex font-weight-bold m-0">
                                    <label class="col-2 m-0">Fax:</label>
                                    <label class="m-0">800-873-8122</label>
                                </div>
                                <div class="d-flex font-weight-bold m-0">
                                    <label class="col-2 m-0">Email:</label>
                                    <label class="m-0">gbmem@coldspringgranite.com</label>
                                </div>

                            </div>
                        </div>

                        <hr class="border non-print-elm">

                        <div class="granit-precious-row non-print-elm">
                            <div>
                                <button type="button" class="btn btn-sm btn-info custom-print-button  px-2" @click="printPDF">Print Preview</button>
                            </div>
                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

</template>

<script>
    import {saveRecord} from "../../../../helpers/axios";
    import {event, eventBus} from "../../../../event-bus/event-bus";

    export default {
        name: "Content",
        props: ['formFields','inPDF'],
        computed: {
            alertClasses: function () {
                return {
                    alert: true,
                    'alert-success': this.successResponse,
                    'alert-danger': this.errorResponse,
                    'd-none': this.hideAlert
                }
            },
            specifications() {
                let data = ['portrait', 'pinned_portrait', 'vhb_tape_portrait', 'domed_portrait', 'domed_pinned_portrait',
                    'original_frame', 'polished_frame', 'plain_colored_bronze_frame', 'plain_polished_bronze_frame',
                    'decorative_colored_bronze_frame', 'decorative_polished_bronze_frame', 'cast_bronze_ring'];



                // for (let item of data) {
                //     this.formFields.granit_bronz_precious.specifications[item] = {
                //         oval_0: 0,
                //         oval_1: 0,
                //         oval_2: 0,
                //         oval_3: 0,
                //         oval_4: 0,
                //         oval_5: 0,
                //         rectangular_0: 0,
                //         rectangular_1: 0,
                //         rectangular_2: 0,
                //         rectangular_3: 0,
                //         heart_0: 0,
                //         heart_1: 0,
                //         round_0: 0,
                //         round_1: 0
                //     };
                // }
                // return this.formFields.granit_bronz_precious.specifications;
            },
            isCreatePermitted(){
                return this.$store.getters.isPermitted({resource:'Orders',action:'create'});
            },
            isUpdatePermitted(){
                return this.$store.getters.isPermitted({resource:'Orders',action:'update'});
            },
        },
        data() {
            return {
                letterStyleList: [{value: 'oval', text: 'Oval'},
                    {value: 'flat', text: 'Flat'},
                    {value: 'traditional', text: 'Traditional'},
                    {value: 'veteran-flat', text: 'Veteran Flat'},
                    {value: 'engraved_roman', text: 'Engraved Roman'},
                    {value: 'engraved_script', text: 'Engraved Script'},
                    {value: 'other', text: 'Other'},
                ],
                scrollTypeList: [{value: 'split', text: 'Split - Year Date Only/unless otherwise specified'},
                    {value: 'standard', text: 'Standard Scroll (Extra for Preneed Scrolls)'},
                    {value: 'tri-scroll', text: 'Tri - Scroll'},
                    {value: 'tri-scroll-death-tab', text: 'Tri - Scroll - Death Date Tab'},
                ],
                axiosParams: {module: 'order/granit_bronz_precious'},
                storagePath: 'images/order/',
                alertMessage: '',
                hideAlert: true,
                successResponse: false,
                errorResponse: false,
                saveDisabled: false,
                colors:[
                    {value:'Color', text:'Color'},
                    {value:'Black & White', text:'Black & White'},
                    {value:'Brown & White', text:'Brown & White'},
                ],
                orientations:[
                    {value:'Horizontal', text:'Horizontal'},
                    {value:'Vertical', text:'Vertical'},
                ]
            }
        },
        methods: {
            save() {
                this.saveDisabled = true; //Disabling save button
                let data = this.formFields.granit_bronz_precious;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));

                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                       /* this.errorResponse = true;
                        this.handleAlert();*/
                        this.makeToast({title: "Error", message:this.alertMessage, variant: "danger", duration: 5000});
                        this.alertMessage = '';
                    } else {
                        let status = this.formFields.granit_bronz_precious.id ? 'Updated' : 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                        this.makeToast({title: 'Success', message: this.alertMessage, variant: 'success'});
                        this.alertMessage = '';
                       /* this.successResponse = true;
                        this.handleAlert();*/
                    }
                },(error) => {
                    if (error.response.status == 403){
                        this.makeToast({title: 'Error', message: error.response.data.message , variant: 'danger', duration: 3000});
                    }
                })
            },
            clickMe(e) {
                console.log(e)
            },

           async printPDF() {
                await eventBus.$emit(event.GRANITE_BRONZ_PRECIOUS, true)
                eventBus.$emit(event.PRINT_PDF)
                await eventBus.$emit(event.GRANITE_BRONZ_PRECIOUS, false)
            },
            handleAlert: function () {
                this.saveDisabled = false;//enabling save button
                this.hideAlert = false;
                setTimeout(() => {
                    this.alertMessage = "";
                    this.successResponse = false;
                    this.errorResponse = false;
                    this.hideAlert = true;
                }, 3000)
            },
            getDayOfWeek: function (date) {
                if (date != null) {
                    const dayOfWeek = new Date(date).getDay();

                    return isNaN(dayOfWeek) ? null :
                        ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
                }
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
            changeDateFormat: function(value){
                return this.$store.getters.changeDateFormat(value);
            },
        }

    }
</script>

<style scoped>
    .form-content {
        margin: 0 auto;
        width: 45rem;
    }

    .granit-precious-row {
        display: flex;
        margin: .5rem 0;
        padding: 0;
    }

    .granit-precious-row div {
        display: flex;
        margin: 0 0;
        /*margin: 0.3rem 0;*/
        width: 100%;
    }

    label {
        /*margin: auto 0.5rem;*/
        white-space: nowrap !important;
    }

    .granit-precious-row div input {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        margin-right: 0;
        height: 1.5rem;
        font-size: 0.75rem;
    }
    input,textarea{
        font-size: 0.75rem;
        border: 1px solid #c4c4c4 !important;
    }

    header {
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

    .input-xl {
        width: 20rem;
    }

    .input-lg {
        width: 12rem;
    }

    .input-md {
        width: 6rem;
    }

    .input-sm {
        width: 4rem;
    }

    .input-date {
        font-size: 0.8rem;
    }

    .product-image {
        width: 4rem;
        height: 4rem;
    }

    .custom-dropdown {
        width: 10rem !important;
    }

    .dropdown-align {
        left: -10px;
    }

    table {
        font-size: 0.7rem;
    }

    .table thead th {
        text-align: center !important;
        white-space: nowrap !important;
    }

    .table tbody td {
        /*padding: 0 0 0 .5rem !important;*/
        padding: 0 0 0 0 !important;
    }

    table.table-bordered, table.table-bordered > thead > tr > th, table.table-bordered > tbody > tr > td,
    table.table-bordered > tfoot > tr > td {
        border: 1px solid #000 !important;
    }

    table .bg-secondary {
        background: #6B6861 !important;
    }

    .table .table-checkbox {
        /*width: 3rem;*/
        height: 1.4rem;
        /*height: 1rem;*/
        color: #fff;
    }

    .table input[type=checkbox] {
        display: none;
    }

    .table input[type=checkbox]:checked + .table-checkbox {
        color: #000;
    }
    .border{
        color: #000000;
    }
    .custom-margin-topCheckBox{
    margin-top: 13px !important;
    }
    .custom-margin-snd-subjectVertical{
        margin-top: 31 !important;
    }
    .custom-margin-SubjectHorizontal{
        margin-top: 30px !important;
    }
    .custom-marginLast-subjectHorizon{
        margin-top: 27px !important;
    }

</style>
