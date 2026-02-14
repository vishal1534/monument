<template>

    <div>

        <form class="bg-white rounded mx-2 mb-2 p-3">

            <div class="form-content">
                <div class="custom-row border rounded">

                    <div class="d-block border-right px-1 m-0">
                        <label class="font-weight-bold">Date:</label>
                        <label class="d-block">{{ changeDateFormat(formFields.order.date) }}</label>
                    </div>
                    <!--<div class="d-block border-right px-1 m-0">
                        <label class="font-weight-bold">Day:</label>
                        <label class="d-block">{{getDayOfWeek(formFields.order.date)}}</label>
                    </div>-->
                    <div class="d-block border-right px-1 m-0">
                        <label class="font-weight-bold">Last name on stone:</label>
                        <label class="d-block">{{formFields.order.family.name_on_stone}}</label>
                    </div>
                    <div class="d-block px-1 m-0">
                        <label class="font-weight-bold">Invoice No.</label>
                        <label class="d-block">{{ formFields.order.invoice.invoice_number }}</label>
                    </div>
                </div>

                <div class="custom-row">
                    <div>
                        <label class="font-weight-bold">Was the grave flagged and ready when you
                            arrived?</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.grave_flagged && formFields.check_list.grave_flagged == 1">Yes</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.grave_flagged == 0">No</label>
                        <!--<label class="print-elm my-2">{{formFields.check_list.grave_flagged ? "Yes" : "No"}}</label>-->
                        <b-form-group class="non-print-elm m-0 my-auto custom-radio-and-checkbox">
                            <b-form-radio-group name="grave_flagged"
                                                v-model="formFields.check_list.grave_flagged">
                                <b-form-radio  :disabled="hideInModal" name="grave-flagged-radio" value="1" size="sm">Yes</b-form-radio>
                                <b-form-radio  :disabled="hideInModal" class="mx-2" name="grave-flagged-radio" value="0" size="sm">No
                                </b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>
                    </div>
                </div>

                <hr class="border non-print-elm">

                <div class="non-print-elm custom-row">
                    <div class="my-0">
                        <label class="font-weight-bold my-auto">Upload the picture of area where installing:</label>
                        <b-form-file
                                ref="inputFile1"
                                v-on:change="checkImage($event,'inputFile1')"
                                :disabled="hideInModal"
                                class="w-50 border rounded custom-file-upload my-1 ml-n1"
                                v-model="formFields.check_list.installing_area_image_file"
                                placeholder="No File Chosen"
                                drop-placeholder="Drop file here..."
                                accept="image/*"
                                browse-text="Choose File"
                                plain
                        ></b-form-file>
                    </div>
                </div>
                <div class="custom-row">
                    <div class="my-0">
                        <label class="font-weight-bold my-auto">Have you upload images?</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.installing_area_image_uploaded && formFields.check_list.installing_area_image_uploaded == 1">Yes</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.installing_area_image_uploaded == 0">No</label>
                        <!-- <label class="print-elm my-2">{{formFields.check_list.installing_area_image_uploaded ? "Yes" :
                            "No"}}</label>-->
                        <b-form-group class="non-print-elm m-0 my-auto custom-radio-and-checkbox">
                            <b-form-radio-group name="installing_area_image_uploaded" class="my-0"
                                                v-model="formFields.check_list.installing_area_image_uploaded">
                                <b-form-radio  :disabled="hideInModal" name="installing-area-image-uploaded-radio" value="1" size="sm">
                                    Yes
                                </b-form-radio>
                                <b-form-radio  :disabled="hideInModal" class="mx-2" name="installing-area-image-uploaded-radio" value="0"
                                              size="sm">No
                                </b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>
                        <button type="button"  :disabled="hideInModal" class="non-print-elm btn btn-sm my-1 ml-auto custom-btn" :class="formFields.check_list.installing_area_image ? 'btn-success' : 'btn-info'"
                                @click="showImage(formFields.check_list.installing_area_image,'Upload the picture of area where installing:')" v-b-modal.image-modal>View Image
                        </button>
                    </div>
                </div>

                <hr class="border non-print-elm">

                <div class="custom-row non-print-elm">
                    <div class="my-0">
                        <label class="font-weight-bold my-auto">Upload the picture of foundation hole before pouring
                            concrete</label>
                        <b-form-file
                                ref="inputFile2"
                                v-on:change="checkImage($event,'inputFile2')"
                                :disabled="hideInModal"
                                class="w-50 mb-0 border rounded custom-file-upload my-1 ml-n1"
                                v-model="formFields.check_list.before_pouring_concrete_image_file"
                                placeholder="No File Chosen"
                                drop-placeholder="Drop file here..."
                                accept="image/*"
                                browse-text="Choose File"
                                plain
                        ></b-form-file>
                    </div>
                </div>
                <div class="custom-row">
                    <div class="my-0">
                        <label class="font-weight-bold my-auto">Have you upload images?</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.before_pouring_concrete_image_uploaded && formFields.check_list.before_pouring_concrete_image_uploaded == 1">Yes</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.before_pouring_concrete_image_uploaded == 0">No</label>
                        <!--<label class="print-elm my-2">{{formFields.check_list.before_pouring_concrete_image_uploaded
                            ? "Yes" : "No"}}</label>-->
                        <b-form-group class="non-print-elm m-0 my-auto custom-radio-and-checkbox">
                            <b-form-radio-group name="before-pouring-concrete-image_uploaded" class="my-0"
                                                v-model="formFields.check_list.before_pouring_concrete_image_uploaded">
                                <b-form-radio  :disabled="hideInModal" name="before-pouring-concrete-image-uploaded-radio" value="1"
                                              size="sm">Yes
                                </b-form-radio>
                                <b-form-radio  :disabled="hideInModal" class="mx-2" name="before-pouring-concrete-image-uploaded-radio"
                                              value="0" size="sm">No
                                </b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>
                        <button type="button" :disabled="hideInModal"  class="non-print-elm btn btn-sm my-1 ml-auto custom-btn" :class="formFields.check_list.before_pouring_concrete_image ? 'btn-success' : 'btn-info'"
                                @click="showImage(formFields.check_list.before_pouring_concrete_image,'Upload the picture of foundation hole before pouring\n'+
'                            concrete:')"
                                v-b-modal.image-modal>View Image
                        </button>
                    </div>
                </div>

                <hr class="border non-print-elm">

                <div class="custom-row">
                    <div>
                        <label class="col-2 p-0">Grasser:</label>
                        <label class="col-2 p-0">Foundation: 10”</label>
                        <label class="col-2 p-0">Holes: 2 Pier 6-12”</label>
                    </div>
                </div>
                <div class="custom-row">
                    <div>
                        <label class="col-2 p-0">Slants without bases:</label>
                        <label class="col-2 p-0">Foundation: 12-16”</label>
                        <label class="col-2 p-0">Holes: 2 Pier 24”</label>
                    </div>
                </div>
                <div class="custom-row">
                    <div>
                        <label class="col-2 p-0">Uprights:</label>
                        <label class="col-2 p-0">Foundation: 16”</label>
                        <label class="col-2 p-0">Holes: 2-3 Pier 20-24” min.</label>
                    </div>
                </div>

                <hr class="border non-print-elm">

                <div class="custom-row">
                    <div>
                        <label class="font-weight-bold">Foundation Depth:</label>
<!--                        <label class="print-elm my-2">{{formFields.check_list.foundation_depth}}</label>-->
                        <label class="print-elm my-2">{{foundationDepthTitle}}</label>

                        <b-dropdown no-caret class="non-print-elm border rounded w-25" toggle-class="" size="sm" variant="none"
                                    :disabled="hideInModal">

                            <template #button-content>
                                <div class="d-flex product-color">
                                    <small>{{foundationDepthTitle}}</small>
                                    <small class="w-25 ml-auto custom-caret"></small>
                                </div>
                            </template>

                            <b-dropdown-group class="overflow-auto scroll px-1">
                                <b-form-input
                                    size="sm"
                                    placeholder="Search..."
                                    class="mt-1"
                                    v-model="searchDepth"
                                ></b-form-input>

                                <b-dropdown-divider class="my-1"></b-dropdown-divider>

                                <template v-if="fiundationDepths.length > 0">
                                    <template v-for="(obj, key) of fiundationDepths">
                                        <b-dropdown-group  @click="handleDropdownChange">
                                            <b-dropdown-item-button class="w-100" :key="key"
                                                                    @click="setDetail(obj,'foundation_depth')">
                                                <label class="btn btn-sm m-0">{{obj.text}}</label>
                                            </b-dropdown-item-button>
                                            <b-icon icon="trash-fill" variant="danger" aria-hidden="true" class="mt-n4 float-right" @click="deleteDropDown(obj.value, 'depth')"></b-icon>
                                        </b-dropdown-group>
                                    </template>
                                </template>

                                <template v-else>
                                    <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                    <button type="button" class="d-flex m-auto px-3 btn-sm btn-info custom-add-btn"
                                            @click="saveDetail('depth')">Add Depth
                                    </button>
                                </template>
                            </b-dropdown-group>

                        </b-dropdown>
                        <label class="font-weight-bold mx-3">(total depth for Slants & Uprights must be
                            36”)</label>
                    </div>
                </div>

                <hr class="border non-print-elm">

                <div class="custom-row">
                    <div>
                        <label class="font-weight-bold">Was there any obstacles or issues while digging
                            foundation?</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.is_issue_while_digging_foundation && formFields.check_list.is_issue_while_digging_foundation == 1">Yes</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.is_issue_while_digging_foundation == 0">No</label>
                        <!--<label class="print-elm my-2">{{formFields.check_list.is_issue_while_digging_foundation ?
                            'Yes' : 'No'}}</label>-->
                        <b-form-group class="non-print-elm m-0 my-auto custom-radio-and-checkbox">
                            <b-form-radio-group name="issues_while_digging_foundation"
                                                v-model="formFields.check_list.is_issue_while_digging_foundation">
                                <b-form-radio  :disabled="hideInModal" name="issues-while-digging-foundation-radio" value="1" size="sm">
                                    Yes
                                </b-form-radio>
                                <b-form-radio  :disabled="hideInModal" class="mx-2" name="issues-while-digging-foundation-radio"
                                              value="0" size="sm">No
                                </b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>
                    </div>
                </div>
                <div class="custom-row">
                    <div>
                        <label class="font-weight-bold">If yes, then specify</label>
                        <div class="print-elm my-2">{{formFields.check_list.digging_foundation_issues}}</div>
                        <b-form-textarea
                                :disabled="hideInModal"
                                class="non-print-elm  "
                                size="sm"
                                no-resize
                                v-model="formFields.check_list.digging_foundation_issues"
                        ></b-form-textarea>
                    </div>
                </div>

                <hr class="border non-print-elm">

                <div class="custom-row non-print-elm">
                    <div class="my-0">
                        <label class="font-weight-bold">Upload the picture of foundation hole after pouring
                            concrete</label>
                        <b-form-file
                                ref="inputFile3"
                                v-on:change="checkImage($event,'inputFile3')"
                                :disabled="hideInModal"
                                class="w-50 border rounded custom-file-upload my-1 ml-n1"
                                v-model="formFields.check_list.after_pouring_concrete_image_file"
                                placeholder="No File Chosen"
                                drop-placeholder="Drop file here..."
                                accept="image/*"
                                browse-text="Choose File"
                                plain
                        ></b-form-file>
                    </div>
                </div>
                <div class="custom-row">
                    <div class="my-0">
                        <label class="font-weight-bold">Have you upload images?</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.after_pouring_concrete_image_uploaded && formFields.check_list.after_pouring_concrete_image_uploaded == 1">Yes</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.after_pouring_concrete_image_uploaded == 0">No</label>
                       <!-- <label class="print-elm my-2">{{formFields.check_list.after_pouring_concrete_image_uploaded ?
                            'Yes' : 'No'}}</label>-->
                        <b-form-group class="non-print-elm m-0 my-auto custom-radio-and-checkbox">
                            <b-form-radio-group name="after-pouring-concrete-image_uploaded"
                                                v-model="formFields.check_list.after_pouring_concrete_image_uploaded">
                                <b-form-radio  :disabled="hideInModal" name="after-pouring-concrete-image-uploaded-radio" value="1"
                                              size="sm">Yes
                                </b-form-radio>
                                <b-form-radio  :disabled="hideInModal" class="mx-2" name="after-pouring-concrete-image-uploaded-radio"
                                              value="0" size="sm">No
                                </b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>
                        <button type="button"  :disabled="hideInModal" class="non-print-elm btn btn-sm my-1 ml-auto custom-btn" :class="formFields.check_list.after_pouring_concrete_image ? 'btn-success' : 'btn-info'"
                                @click="showImage(formFields.check_list.after_pouring_concrete_image,'Upload the picture of foundation hole after pouring\n'+
'                            concrete:')"
                                v-b-modal.image-modal>View Image
                        </button>
                    </div>
                </div>

                <hr class="border non-print-elm">

                <div class="custom-row">
                    <div>
                        <label class="font-weight-bold">Have you spread grass on backfill dirt around base,
                            before applying Silicone?</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.is_grass_spread && formFields.check_list.is_grass_spread == 1">Yes</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.is_grass_spread == 0">No</label>
                        <!--<label class="print-elm my-2">{{formFields.check_list.is_grass_spread ? 'Yes' :
                            'No'}}</label>-->
                        <b-form-group class="non-print-elm m-0 my-auto custom-radio-and-checkbox">
                            <b-form-radio-group name="is_grass_spread"
                                                v-model="formFields.check_list.is_grass_spread">
                                <b-form-radio  :disabled="hideInModal" name="grass-spread-radio" value="1" size="sm">Yes</b-form-radio>
                                <b-form-radio  :disabled="hideInModal" class="mx-2" name="grass-spread-radio" value="0" size="sm">No
                                </b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>
                    </div>
                </div>

                <hr class="border non-print-elm">

                <div class="custom-row non-print-elm">
                    <div class="my-0">
                        <label class="font-weight-bold">Upload the picture of finished installed</label>
                        <b-form-file
                                ref="inputFile4"
                                v-on:change="checkImage($event,'inputFile4')"
                                :disabled="hideInModal"
                                class="w-50 border rounded custom-file-upload my-1 ml-n1"
                                v-model="formFields.check_list.finished_installed_image_file"
                                placeholder="No File Chosen"
                                drop-placeholder="Drop file here..."
                                accept="image/*"
                                browse-text="Choose File"
                                plain
                        ></b-form-file>
                    </div>
                </div>
                <div class="custom-row">
                    <div class="my-0">
                        <label class="font-weight-bold">Have you upload images?</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.finished_installed_image_uploaded && formFields.check_list.finished_installed_image_uploaded == 1">Yes</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.finished_installed_image_uploaded == 0">No</label>
                        <!-- <label class="print-elm my-2">{{formFields.check_list.finished_installed_image_uploaded ?
                            'Yes' : 'No'}}</label>-->
                        <b-form-group class="non-print-elm m-0 my-auto custom-radio-and-checkbox">
                            <b-form-radio-group name="finished_installed_image_uploaded"
                                                v-model="formFields.check_list.finished_installed_image_uploaded">
                                <b-form-radio  :disabled="hideInModal" name="finished-installed-image-uploaded-radio" value="1"
                                              size="sm">Yes
                                </b-form-radio>
                                <b-form-radio  :disabled="hideInModal" class="mx-2" name="finished-installed-image-uploaded-radio"
                                              value="0" size="sm">No
                                </b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>
                        <button type="button"  :disabled="hideInModal" class="non-print-elm btn btn-sm my-1 ml-auto custom-btn" :class="formFields.check_list.finished_installed_image ? 'btn-success' : 'btn-info'"
                                @click="showImage(formFields.check_list.finished_installed_image,'Upload the picture of finished installed:')"
                                v-b-modal.image-modal>View Image
                        </button>
                    </div>
                </div>

                <hr class="border non-print-elm">

                <div class="custom-row">
                    <div class="my-0">
                        <label class="font-weight-bold">Were any knick nacks or grave decorations damaged during
                            the install?</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.grave_damaged_during_install && formFields.check_list.grave_damaged_during_install == 1">Yes</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.grave_damaged_during_install == 0">No</label>
                        <!--<label class="print-elm my-2">{{formFields.check_list.grave_damaged_during_install ? 'Yes' :
                            'No'}}</label>-->
                        <b-form-group class="non-print-elm m-0 my-auto custom-radio-and-checkbox">
                            <b-form-radio-group name="grave_damaged_during_install"
                                                v-model="formFields.check_list.grave_damaged_during_install">
                                <b-form-radio  :disabled="hideInModal" name="grave-damaged-during-install-radio" value="1" size="sm">
                                    Yes
                                </b-form-radio>
                                <b-form-radio  :disabled="hideInModal" class="mx-2" name="grave-damaged-during-install-radio" value="0"
                                              size="sm">No
                                </b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>
                    </div>
                </div>
                <div class="custom-row non-print-elm">
                    <div class="my-0">
                        <label class="font-weight-bold">If yes, then upload the image</label>
                        <b-form-file
                                ref="inputFile5"
                                v-on:change="checkImage($event,'inputFile5')"
                                :disabled="hideInModal"
                                class="w-50 border rounded custom-file-upload my-1 ml-n1"
                                v-model="formFields.check_list.damaged_grave_image_file"
                                placeholder="No File Chosen"
                                drop-placeholder="Drop file here..."
                                accept="image/*"
                                browse-text="Choose File"
                                plain
                        ></b-form-file>
                    </div>
                </div>
                <div class="custom-row">
                    <div class="my-0">
                        <label class="font-weight-bold">Have you upload images?</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.damaged_grave_image_uploaded && formFields.check_list.damaged_grave_image_uploaded == 1">Yes</label>
                        <label class="print-elm my-2" v-if="formFields.check_list.damaged_grave_image_uploaded == 0">No</label>
                        <!--<label class="print-elm my-2">{{formFields.check_list.damaged_grave_image_uploaded ? 'Yes' :
                            'No'}}</label>-->
                        <b-form-group class="non-print-elm m-0 my-auto custom-radio-and-checkbox">
                            <b-form-radio-group name="damaged_grave_image_uploaded"
                                                v-model="formFields.check_list.damaged_grave_image_uploaded">
                                <b-form-radio  :disabled="hideInModal" name="damaged-grave-image-uploaded-radio" value="1" size="sm">
                                    Yes
                                </b-form-radio>
                                <b-form-radio  :disabled="hideInModal" class="mx-2" name="damaged-grave-image-uploaded-radio" value="0"
                                              size="sm">No
                                </b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>
                        <button type="button"  :disabled="hideInModal" class="non-print-elm btn btn-sm my-1 ml-auto custom-btn" :class="formFields.check_list.damaged_grave_image ? 'btn-success' : 'btn-info'"
                                @click="showImage(formFields.check_list.damaged_grave_image,'Were any knick nacks or grave decorations damaged during\n'+
'                            the install:')"
                                v-b-modal.image-modal>View Image
                        </button>
                    </div>
                </div>

                <hr class="border non-print-elm">

                <div class="custom-row mt-2">
                    <label class="font-weight-bold">Which direction?</label>
                </div>
                <div class="custom-row">
                    <div class="my-0 check-list-border-right w-auto">
                        <label class="font-weight-bold">Man:</label>
                        <label class="print-elm my-2">{{formFields.check_list.man_direction}}</label>
                        <b-form-group class="non-print-elm m-0 my-auto custom-radio-and-checkbox">
                            <b-form-radio-group name="man_direction"
                                                v-model="formFields.check_list.man_direction">
                                <b-form-radio  :disabled="hideInModal" name="man-direction-radio" value="North" size="sm">North
                                </b-form-radio>
                                <b-form-radio  :disabled="hideInModal" class="mx-2" name="man-direction-radio" value="South" size="sm">
                                    South
                                </b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>
                    </div>
                    <div class="my-0 ml-1 check-list-border-right w-auto">
                        <label class="font-weight-bold">Woman:</label>
                        <label class="print-elm my-2">{{formFields.check_list.woman_direction}}</label>
                        <b-form-group class="non-print-elm m-0 my-auto custom-radio-and-checkbox">
                            <b-form-radio-group name="woman_direction"
                                                v-model="formFields.check_list.woman_direction">
                                <b-form-radio  :disabled="hideInModal" name="woman-direction-radio" value="North" size="sm">North
                                </b-form-radio>
                                <b-form-radio  :disabled="hideInModal" class="mx-2" name="woman-direction-radio" value="South" size="sm">
                                    South
                                </b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>
                    </div>
                    <div class="my-0 ml-1 w-auto">
                        <label class="font-weight-bold">Front Monument:</label>
                        <label class="print-elm my-2">{{formFields.check_list.front_monument_direction}}</label>
                        <b-form-group class="non-print-elm m-0 my-auto custom-radio-and-checkbox">
                            <b-form-radio-group name="front_monument_direction"
                                                v-model="formFields.check_list.front_monument_direction">
                                <b-form-radio  :disabled="hideInModal" name="front-monument-direction-radio" value="East" size="sm">
                                    East
                                </b-form-radio>
                                <b-form-radio  :disabled="hideInModal" class="mx-2" name="front-monument-direction-radio" value="West"
                                              size="sm">West
                                </b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>
                    </div>
                </div>

                <hr class="border non-print-elm">

                <div class="custom-row">
                    <div>
                        <label class="font-weight-bold">Was Granite seal or silicone used?</label>
                        <label class="print-elm my-2">{{formFields.check_list.granite_seal_or_silicon_used}}</label>
                        <b-form-group class="non-print-elm m-0 my-auto custom-radio-and-checkbox">
                            <b-form-radio-group name="granite_seal_or_silicon_used"
                                                v-model="formFields.check_list.granite_seal_or_silicon_used">
                                <b-form-radio  :disabled="hideInModal" name="granite-seal-or-silicon-used-radio" value="Granite"
                                              size="sm">Granite
                                </b-form-radio>
                                <b-form-radio  :disabled="hideInModal" class="mx-2" name="granite-seal-or-silicon-used-radio"
                                              value="Silicon" size="sm">Silicon
                                </b-form-radio>
                            </b-form-radio-group>
                        </b-form-group>
                    </div>
                </div>

                <hr class="border non-print-elm">

                <div class="custom-row">
                    <div>
                        <label class="font-weight-bold">How was the vase attached?</label>
                        <label class="print-elm my-2">{{vaseDirectionTitle}}</label>
<!--                        <label class="print-elm my-2">{{formFields.check_list.vase_attached}}</label>-->

                        <b-dropdown no-caret class="non-print-elm border rounded w-25" toggle-class="" size="sm" variant="none"
                                    :disabled="hideInModal">

                            <template #button-content>
                                <div class="d-flex product-color">
                                    <small>{{vaseDirectionTitle}}</small>
                                    <small class="w-25 ml-auto custom-caret"></small>
                                </div>
                            </template>

                            <b-dropdown-group class="overflow-auto scroll px-1">
                                <b-form-input
                                    size="sm"
                                    placeholder="Search..."
                                    class="mt-1"
                                    v-model="searchVase"
                                ></b-form-input>

                                <b-dropdown-divider class="my-1"></b-dropdown-divider>

                                <template v-if="vaseDirections.length > 0">
                                    <template v-for="(obj, key) of vaseDirections">
                                        <b-dropdown-group  @click="handleDropdownChange">
                                            <b-dropdown-item-button class="w-100" :key="key"
                                                                    @click="setDetail(obj,'vase_direction')">
                                                <label class="btn btn-sm m-0">{{obj.text}}</label>
                                            </b-dropdown-item-button>
                                            <b-icon icon="trash-fill" variant="danger" aria-hidden="true" class="mt-n4 float-right" @click="deleteDropDown(obj.value, 'direction')"></b-icon>
                                        </b-dropdown-group>
                                    </template>
                                </template>

                                <template v-else>
                                    <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                    <button type="button" class="d-flex m-auto px-3 btn-sm btn-info custom-add-btn"
                                            @click="saveDetail('direction')">Add Direction
                                    </button>
                                </template>
                            </b-dropdown-group>

                        </b-dropdown>
                    </div>
                </div>

                <hr class="border non-print-elm">

                <div class="custom-row">
                    <div class="w-auto">
                        <label class="ml-0">Time Arrived:</label>
                        <b-form-input type="text"  :disabled="hideInModal" class="input-md m-0" size="sm"
                                      v-model="formFields.check_list.time_arrived"></b-form-input>
                    </div>
                    <div class="w-auto mx-2">
                        <label>Time Finished:</label>
                        <b-form-input type="text"  :disabled="hideInModal" class="input-md m-0" size="sm"
                                      v-model="formFields.check_list.time_finished"></b-form-input>
                    </div>
                </div>

                <hr class="border non-print-elm">

                <div class="custom-row w-50">
                    <div>
                        <label class="font-weight-bold ml-0">Name of Installer:</label>
                        <b-form-input type="text"  :disabled="hideInModal" class="" size="sm"
                                      v-model="formFields.check_list.installer_name"></b-form-input>
                    </div>
                </div>


                <div class="custom-row non-print-elm">

                    <div v-if="!hideInModal" class="toolbar ml-auto w-auto">
                        <button type="button" v-if="id ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="saveRecord" :disabled="saveDisabled">
                            {{ id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                        </button>
                    </div>

                    <div>
<!--                        btn btn-sm btn-info rounded px-2 my-3-->
                        <button v-if="!hideInModal" type="button" class="btn-info px-2 w-auto custom-infobtn-toolbar custom-infobtn-text" @click="printPDF">
                            Print Form
                        </button>
<!--                        btn btn-sm btn-warning rounded px-2 my-3 ml-auto-->
                        <router-link v-if="!inInstallation"
                                     class="btn btn-sm btn-warning px-2 custom-dangerbtn-toolbar custom-dangerbtn-text ml-auto"
                                     :to="'/installation/'+formFields.id">Back to Installation
                        </router-link>
                    </div>

                </div>


            </div>

        </form>

        <div v-if="!inPdf">
            <b-modal id="image-modal"
                     size="lg"
                     scrollable
                     title="">
                <template #modal-footer="{ ok, cancel, hide }">

                    <b-button size="sm" variant="primary" @click="printImage(imageModalData.src); return false;">Print
                    </b-button>
                    <b-button size="sm" variant="secondary" @click="cancel()">Cancel</b-button>
                </template>

                <div class="custom-row d-block">
                    <h5 class="text-center">INSTALLATION CHECK LIST</h5>
                    <div class="custom-row border rounded">

                        <div class="d-block border-right px-1 m-0">
                            <label class="font-weight-bold">Date:</label>
                            <label class="d-block">{{ changeDateFormat(formFields.order.date)}}</label>
                        </div>
                        <!--<div class="d-block border-right px-1 m-0">
                            <label class="font-weight-bold">Day:</label>
                            <label class="d-block">{{getDayOfWeek(formFields.order.date)}}</label>
                        </div>-->
                        <div class="d-block border-right px-1 m-0">
                            <label class="font-weight-bold">Last name on stone:</label>
                            <label class="d-block">{{formFields.order.family.name_on_stone}}</label>
                        </div>
                        <div class="d-block px-1 m-0">
                            <label class="font-weight-bold">Invoice No.</label>
                            <label class="d-block">{{ formFields.order.invoice.invoice_number }}</label>
                        </div>
                    </div>
                    <div>
                        <label class="font-weight-bold">{{this.imageTitle}}</label>
                    </div>
                    <div>
                    <img :src="imageModalData.src" class="w-100">
                    </div>
                </div>

            </b-modal>
        </div>

       <!-- <imagePDF :title="'InstallationCheckListImage'">
            <div slot="header"></div>
            <div slot="body">
                <img :src="imageModalData.src" style='width: 100vw;'>
            </div>
            <div slot="footer"></div>
        </imagePDF>-->

    </div>

</template>

<script>
    import {saveRecord, fetchRecord, deleteRecord} from "../../../../helpers/axios";
    import {event, eventBus} from "../../../../event-bus/event-bus";
    import PDF from "../../../../Modules/PDF-Modal";
    import imagePDF from "../../../../Modules/imageModal";

    export default {
        name: "Content",
        components: {PDF,imagePDF},
        props: ['id', 'formFields','inInstallation', 'inPdf','hideInModal'],
        computed: {
            alertClasses: function () {
                return {
                    alert: true,
                    'alert-success': this.successResponse,
                    'alert-danger': this.errorResponse,
                    'd-none': this.hideAlert
                }
            },
            attachedVase(){
                return this.attachedVaseList = this.$store.getters.sortByAlphaNumeric({'fieldName': 'text', 'recordList': this.attachedVaseList});
            },
            vaseDirections() {
                let options = [];
                for (let opt of this.$store.state[this.axiosParamsIns.module].vaseDirection) {
                    let obj = {value: opt.id, text: opt.direction, options: opt};
                    options.push(obj);
                }
                if (this.searchVase != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchVase.toUpperCase()) > -1)
                }
                return options;
            },
            vaseDirectionTitle() {
                let opt = "Select";
                if (this.$store.state[this.axiosParamsIns.module].vaseDirection.length > 0 && this.formFields.vase_direction_id != 0 && this.formFields.vase_direction_id != null) {
                    opt = this.$store.state[this.axiosParamsIns.module].vaseDirection.filter(obj => obj.id == this.formFields.vase_direction_id);
                    opt = opt.length > 0 ? opt[0].direction : "Select";
                }
                return opt
            },
            fiundationDepths() {
                let options = [];
                for (let opt of this.$store.state[this.axiosParamsIns.module].foundationDepth) {
                    let obj = {value: opt.id, text: opt.depth, options: opt};
                    options.push(obj);
                }
                if (this.searchDepth != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchDepth.toUpperCase()) > -1)
                }
                return options;
            },
            foundationDepthTitle() {
                let opt = "Select";
                if (this.$store.state[this.axiosParamsIns.module].foundationDepth.length > 0 && this.formFields.foundation_depth_id != 0 && this.formFields.foundation_depth_id != null) {
                    opt = this.$store.state[this.axiosParamsIns.module].foundationDepth.filter(obj => obj.id == this.formFields.foundation_depth_id);
                    opt = opt.length > 0 ? opt[0].depth : "Select";
                }
                return opt
            },
            isUpdatePermitted(){
                return this.$store.getters.isPermitted({resource:'Installation',action:'update'});
            },
            isCreatePermitted(){
                return this.$store.getters.isPermitted({resource:'Installation',action:'create'});
            },
        },
        component: {
            PDF
        },
        data() {
            return {
                axiosParams: {module: 'installation/check-list'},
                axiosParamsIns: {module: 'installation'},
                axiosParamsVase: {module: 'installation/vase-direction'},
                axiosParamsDepth: {module: 'installation/foundation-depth'},
                foundationDepthList: [
                    {value: 12, text: '12"'},
                    {value: 24, text: '24"'},
                    {value: 36, text: '36"'},
                ],
                imageTitle: null,
                attachedVaseList: [
                    {value: 'pinned', text: 'Pinned'},
                    {value: 'silicon', text: 'Silicon'},
                    {value: 'epoxy', text: 'Epoxy'},
                    {value: 'tape', text: 'Tape'},
                ],
                imageModalData: {src: '', title: ''},
                alertMessage: '',
                hideAlert: true,
                successResponse: false,
                errorResponse: false,
                saveDisabled: false,
                searchVase: "",
                searchDepth: "",
            }
        },
        methods: {
            save() {

                this.saveDisabled = true; //Disabling save button
                let data = this.formFields.brick;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));

                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.errorResponse = true;
                        this.handleAlert();
                    } else {
                        let status = this.formFields.brick.id ? 'Updated' : 'Added';
                        this.alertMessage = `Record Successfully ${status}`;
                        this.successResponse = true;
                        this.handleAlert();
                    }
                })
            },
            saveDetail: function(detail){
                let data = {id: 0};
                let params = {};
                let recordList = null
                if (detail == 'direction'){
                    data[detail] = this.searchVase
                    params = this.axiosParamsVase
                    recordList = 'vaseDirection'
                }else if (detail == 'depth'){
                    data[detail] = this.searchDepth
                    params = this.axiosParamsDepth
                    recordList = 'foundationDepth'
                }
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                saveRecord(params, formData, (response) => {
                    if (response.data.errorInfo) {
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.errorResponse = true;
                        this.handleAlert();
                    } else {
                        this.$store.state[this.axiosParamsIns.module][recordList].splice(this.$store.state[this.axiosParamsIns.module][recordList].length +1, 0, response.data)
                    }
                })
            },
            saveRecord:function(){
                eventBus.$emit(event.SAVE_INSTALLATION);
            },
            handleDropdownChange: function(value){
                window.detectChanges = true;
            },
            showImage(src,title=null) {
                this.imageTitle = title;
                if(src)
                    this.imageModalData.src = '/images/' + src;
                else
                    this.imageModalData.src = '/images/default-image.jpg';
            },
            imageToPrint(source) {
                return "<html><head><scri" + "pt>function step1(){\n" +
                    "setTimeout('step2()', 10);}\n" +
                    "function step2(){window.print();window.close();}\n" +
                    "</scri" + "pt></head><body onload='step1()'> <img src='"+ source+ "' style='width: 100vw;'>\n" +
                    "</body></html>";
            },
            printImage(source) {
                this.$bvModal.hide('image-modal');
                let Pagelink = "about:blank";
                let pwa = window.open(Pagelink, "_new");
                pwa.document.open();
                pwa.document.write(this.imageToPrint(window.location.origin + "/" + source));
                pwa.document.close();

                /*this.imageData= source;
                this.$forceUpdate();
                eventBus.$emit(event.PRINT_IMAGE)*/
            },
            printPDF() {
                this.$bvModal.hide('image-modal')
                eventBus.$emit(event.PRINT_PDF)
            },
            checkImage: function(event,ref) {
                let input = event.target;
                let  FileSize = input.files[0].size / 1024 / 1024; // in MiB
                if (FileSize > 2 ||input.files[0].type.indexOf("image") == -1) {
                    // alert('Invalid image type or file size exceeds 2 MB');
                    this.makeToast({title : 'Error', message: 'Invalid image type or file size exceeds 2 MB', variant : 'danger', duration : 5000});
                    this.$refs[ref].reset();
                    return false;
                }
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
            customizeLabel: function (str) {
                // Remove underscore and capitalize first letter of each word
                console.info(str)
                let i, labels = str.split('_');
                for (i = 0; i < labels.length; i++) {
                    labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
                }
                return labels.join(' ');
            },
            makeToast: function (params) {
                this.$bvToast.toast(params.message, {
                    id: 'cemetery-toast',
                    title: params.title,
                    variant: params.variant,
                    toaster: 'b-toaster-top-center',
                    autoHideDelay: params.duration ? params.duration : 2000,
                    noAutoHide: this.toastHider,
                    noCloseButton: true,
                })
                this.saveDisabled = false;//enabling save button

            },
            changeDateFormat: function(value){
                return this.$store.getters.changeDateFormat(value);
            },
            deleteDropDown: function(id, detail){
                if (confirm('Do you really want to delete this record ?')){
                    let moduleName = null;
                    let recordList = null
                    if (detail == 'direction'){
                        moduleName = this.axiosParamsVase.module
                        recordList = 'vaseDirection'
                    }else if (detail == 'depth'){
                        moduleName = this.axiosParamsDepth.module
                        recordList = 'foundationDepth'
                    }
                    deleteRecord({id: id, module: moduleName}, (response) => {
                        let list =  this.$store.state[this.axiosParamsIns.module][recordList];
                        this.spliceRecord(list, id);
                    })
                }
            },
            spliceRecord: function(list, id){
                let record = list.find(obj => obj.id == id);
                let currentIndex = list.indexOf(record);
                list.splice(currentIndex, 1);
            },
            setDetail(obj, detail) {
                this.formFields[detail + '_id'] = obj.value;
                this.formFields[detail] = obj.text;
            },
        },
    }
</script>

<style scoped>
    .form-content {
        /*margin: 0 auto;*/
        width: 45rem;
    }

    .custom-row {
        display: flex;
        padding: 0;
    }

    .custom-row div {
        display: flex;
        margin: 0.2rem 0;
        width: 100%;
    }

    .custom-row div label {
        margin: auto 0.5rem auto 0;
        white-space: nowrap !important;
        color:#000 !important;
    }

    .custom-row div input {
        border: 1px solid #c4c4c4;
        margin: auto;
        margin-right: 0;
        height: 1.5rem;
        font-size: 0.75rem;
    }
    textarea {
        font-size: 0.75rem;
        border: 1px solid #c4c4c4;
    }
    input[type="file"] {
        height: auto !important;
    }

    header {
        padding: 0 3rem;
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
        width: 2.2rem;
        height: 1.4rem;
    }

    .input-date {
        font-size: .6rem;
    }

    .custom-btn {
        box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.25);
        border-radius: 5px;
        font-size: 12px;
        letter-spacing: 0.02em;
    }
    .check-list-border-right{
        border-right: 1px solid #dee2e6 !important;
    }
    .printing .check-list-border-right {
        border-color: transparent !important;
    }

</style>
