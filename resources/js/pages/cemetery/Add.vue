<template>
    <div :class="hideInModal?' custom-modal-margin':''">
        <div v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Cemetery</h5>
            <div class="bg-toolbar my-2 p-1">
                <Toolbar :id="formFields.id" :saveDisabled="saveDisabled"></Toolbar>
            </div>
        </div>
        <div id="cemetery">
            <div class="row m-0">
                <div class="col-md-12">
                    <div v-bind:class="[alertClasses, 'd-flex justify-content-center m-auto p-1 w-50']">{{alertMessage}}</div>
                    <div class=" border-0 bg-white rounded mx-n2 mb-2">
                        <form enctype="multipart/form-data" id="cemetery-form" method="post"
                              ref="form" role="form">
                            <template v-if="isLoading">
                                <div class="text-center text-info my-2">
                                    <b-spinner class="align-middle"></b-spinner>
                                    <strong>Loading...</strong>
                                </div>
                            </template>
                            <template v-else>
                                <div class="card-body cemetery-form">
                                    <div class="row custom-border-bottom">
                                        <div class="col-md-4">
                                            <div class="row form-group p-1">
                                                <b-form-input hidden name="cemetery[id]" type="text" v-model="formFields.id"></b-form-input>
                                                <label class="col-md-4 my-1">Company</label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-8" name="cemetery[company]" size="sm" type="text" v-model="formFields.company"></b-form-input>
                                            </div>
                                            <div class="row form-group p-1">
                                                <label class="col-md-4  my-1">Contact First Name</label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-8" name="cemetery[contact_first_name]" size="sm" type="text" v-model="formFields.contact_first_name"></b-form-input>
                                            </div>
                                            <div class="row form-group p-1">
                                                <label class="col-md-4  my-1">Contact Last Name</label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-8" name="cemetery[contact_last_name]" size="sm" type="text" v-model="formFields.contact_last_name"></b-form-input>
                                            </div>
                                            <div class="row form-group p-1">
                                                <label class="col-md-4  my-1">Job Title </label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-8" name="cemetery[job_title]" size="sm" type="text" v-model="formFields.job_title"></b-form-input>
                                            </div>
                                            <div class="row form-group p-1">
                                                <label class="col-md-4  my-1">Additional Contact</label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-8" name="cemetery[additional_contact]" size="sm" type="text" v-model="formFields.additional_contact"></b-form-input>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row form-group p-1 ml-0">
                                                <label class="col-md-1  my-1">Category</label>
                                                <b-dropdown :disabled="hideInModal" class="col-md-11 border rounded ml-0 custom-dropdown-toggle cutsom-width-dropdown"
                                                            no-caret size="sm" toggle-class=""
                                                            variant="none">
                                                    <template #button-content>
                                                        <div class="d-flex product-color">
                                                            <small>{{customizeLabel(cemeteryCategoryTitle)}}</small>
                                                            <small class="w-25 ml-auto custom-caret"></small>
                                                        </div>
                                                    </template>
                                                    <b-dropdown-group class="overflow-auto scroll px-1">
                                                        <b-form-input
                                                            class="mt-1"
                                                            placeholder="Search..."
                                                            size="sm"
                                                            v-model="searchCategory"
                                                        ></b-form-input>
                                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                                        <template v-if="cemeteryCategories.length > 0">
                                                            <template v-for="(obj, key) of cemeteryCategories">
                                                                <b-dropdown-group @click="handleDropdownChange">
                                                                    <b-dropdown-item-button :key="key" @click="setDetail(obj,'category')"
                                                                                            class="w-100">
                                                                        <label class="btn btn-sm m-0">{{obj.text}}</label>
                                                                    </b-dropdown-item-button>
                                                                    <b-icon @click="deleteDropDown(obj.value)" aria-hidden="true" class="mt-n4 float-right" icon="trash-fill" variant="danger"></b-icon>
                                                                </b-dropdown-group>
                                                            </template>
                                                        </template>
                                                        <template v-else>
                                                            <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                                            <button @click="saveDetail('title')" class="d-flex m-auto px-3 btn-sm btn-info custom-add-btn"
                                                                    type="button">Add Category
                                                            </button>
                                                        </template>
                                                    </b-dropdown-group>
                                                </b-dropdown>
                                            </div>
                                            <div class="row form-group p-1 ml-0">
                                                <label class="col-md-1  my-1">Email</label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-11" name="cemetery[email]" size="sm" type="text" v-model="formFields.email"></b-form-input>
                                            </div>
                                            <div class="row form-group p-1 ml-0">
                                                <label class="col-md-1  my-1">Web Page</label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-11" name="cemetery[web_page]" size="sm" type="text" v-model="formFields.web_page"></b-form-input>
                                            </div>
                                            <div class="row form-group p-1 ml-0">
                                                <label class="col-md-1  my-1">GPS</label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-11" name="cemetery[gps]" size="sm" type="text" v-model="formFields.gps"></b-form-input>
                                            </div>
                                            <div class="row form-group p-1 ml-0">
                                                <label class="col-md-1  my-1">Files</label>
                                                <b-form-file
                                                    :disabled="hideInModal || hideinAuth"
                                                    browse-text="Choose File"
                                                    class="col-md-11 border rounded custom-file-upload"
                                                    drop-placeholder="Drop file here..."
                                                    multiple
                                                    placeholder="No Chosen File"
                                                    plain
                                                    ref="inputFile"
                                                    v-model="documents.files"
                                                    v-on:change="previewImage"
                                                ></b-form-file>
                                            </div>
                                            <div class="documents-row ml-n2">
                                                <div class="flex-wrap m-1 ">
                                                    <template v-if="this.formFields.files">
                                                        <template v-for="(file,index) of this.formFields.files">
                                                            <div class="flex-column border mx-1  pl-0 py-1 justify-content-center file-container">
                                                                <template v-if="checkFileType(file.file)">
                                                                    <i :title="`${file.name}`" @click="openPreviewNewPage(storagePath+file.file)" style="cursor: pointer;"
                                                                       class="fa fa-file fa-2x m-auto" v-b-tooltip.hover></i>
                                                                    <label class="" @click="openPreviewNewPage(storagePath+file.file)" style="cursor: pointer;">
                                                                        {{file.file.length > 10 ? file.file.substr(0,10)+'...' : file.path}}</label>
                                                                </template>
                                                                <template v-else>
                                                                    <img :src="storagePath + file.file" :title="`${file.name}`" alt="product-file"
                                                                         class="btn img-thumbnail product-image " height="51px"
                                                                         @click="openPreviewNewPage(storagePath+file.file)" style="cursor: pointer;"
                                                                         v-b-tooltip.hover width="89px">
                                                                </template>
                                                                <div class="btn m-auto" v-if="!hideInModal || hideinAuth">
                                                                    <a :download="file.file" :href="`${storagePath+file.file}`" style="margin-top: -2px !important;color: #000 !important;">
                                                                        <i aria-hidden="true" class="fa fa-download mx-2"></i></a>
                                                                    <i @click="deleteFile(file.id,index)" aria-hidden="true" class="fa fa-trash-o mx-2"
                                                                       style='color: red'></i>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row custom-border-bottom">
                                        <div class="col-md-4">
                                            <div class="row form-group p-1 mr-2">
                                                <h6 class="col-md-12 my-2 custom-form-heading">Phone Numbers</h6><br><br>
                                                <label class="col-md-4  my-1">Business Phone</label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-8" name="cemetery[business_phone]" size="sm" type="text" v-model="formFields.business_phone"></b-form-input>
                                            </div>
                                            <div class="row form-group p-1 mr-2">
                                                <label class="col-md-4  my-1">Fax Number</label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-8" name="cemetery[fax_number]" size="sm" type="text" v-model="formFields.fax_number"></b-form-input>
                                            </div>
                                            <div class="row form-group p-1 mr-2">
                                                <label class="col-md-4  my-1">Home Phone</label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-8" name="cemetery[home_phone]" size="sm" type="text" v-model="formFields.home_phone"></b-form-input>
                                            </div>
                                            <div class="row form-group p-1 mr-2">
                                                <label class="col-md-4  my-1">Mobile Phone</label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-8" name="cemetery[mobile_phone]" size="sm" type="text" v-model="formFields.mobile_phone"></b-form-input>
                                            </div>
                                        </div>
                                        <div class="col-md-8 custom-border-left">
                                            <div class="row">
                                                <h6 class="col-md-12 my-2 custom-form-heading">Cemetery Regulation Info</h6><br><br>
                                                <div class="col-sm-6">
                                                    <div class="row form-group p-1">
                                                        <label class="col-md-5  my-1">Authorization for Install</label>
                                                        <b-form-select
                                                            :disabled="hideInModal || hideinAuth"
                                                            class="form-control form-control-sm col-md-6 custom-caret-form ml-0"
                                                            name="regulation[auth_for_install]"
                                                            size="sm"
                                                            v-model="formFields.regulation.auth_for_install">
                                                            <option :value=1>Yes</option>
                                                            <option :value=0>No</option>
                                                        </b-form-select>
                                                    </div>
                                                    <div class="row form-group p-1">
                                                        <label class="col-md-4  my-1">Perpetual Care Fee</label>
                                                        <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-7 m-0" name="cemetery[perpetual_care_fee]" size="sm" type="text" v-model="formFields.regulation.perpetual_care_fee = regulation.perpetual_care_fee"></b-form-input>
                                                    </div>
                                                    <div class="row form-group p-1">
                                                        <label class="col-md-4  my-1">Flagging Fee</label>
                                                        <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-7 m-0" name="cemetery[flagging_fee]" size="sm" type="text" v-model="formFields.regulation.flagging_fee = regulation.flagging_fee"></b-form-input>
                                                    </div>
                                                    <div class="row form-group p-1">
                                                        <label class="col-md-4  my-1">Setting Fee</label>
                                                        <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-7 m-0" name="cemetery[setting_fee]" size="sm" type="text" v-model="formFields.regulation.setting_fee = regulation.setting_fee"></b-form-input>
                                                    </div>
                                                    <div class="row form-group p-1">
                                                        <label class="col-md-4  my-1">Miscellaneous Fee</label>
                                                        <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-7 m-0" name="cemetery[mis_fee]" size="sm" type="text" v-model="formFields.regulation.mis_fee = regulation.mis_fee"></b-form-input>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row form-group p-1">
                                                        <label class="col-md-6  my-1">Authorization for Install Customer</label>
                                                        <b-form-select
                                                            :disabled="hideInModal || hideinAuth"
                                                            class="form-control form-control-sm col-md-6 custom-caret-form"
                                                            name="regulation[auth_for_install_customer]"
                                                            size="sm"
                                                            v-model="formFields.regulation.auth_for_install_customer = regulation.auth_for_install_customer">
                                                            <option :value=1>Yes</option>
                                                            <option :value=0>No</option>
                                                        </b-form-select>
                                                    </div>
                                                    <div class="row form-group p-1">
                                                        <label class="col-md-4  my-1">Cemeteries Style</label>
                                                        <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-8" name="regulation[cemeteries_style]" size="sm" type="text" v-model="formFields.regulation.cemeteries_style = regulation.cemeteries_style"></b-form-input>
                                                    </div>
                                                    <div class="row form-group p-1">
                                                        <label class="col-md-4  my-1">Apron Size</label>
                                                        <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-8" name="regulation[apron_size]" size="sm" type="text" v-model="formFields.regulation.apron_size = regulation.apron_size"></b-form-input>
                                                    </div>
                                                    <div class="row form-group p-1">
                                                        <label class="col-md-4  my-1">Mont Single Size</label>
                                                        <b-form-input :disabled="hideInModal|| hideinAuth" class="form-control form-control-sm col-md-8" name="regulation[mont_single_size]" size="sm" type="text" v-model="formFields.regulation.mont_single_size = regulation.mont_single_size"></b-form-input>
                                                    </div>
                                                    <div class="row form-group p-1">
                                                        <label class="col-md-4  my-1">Mont Double Size</label>
                                                        <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-8" name="regulation[mont_double_size]" size="sm" type="text" v-model="formFields.regulation.mont_double_size = regulation.mont_double_size"></b-form-input>
                                                    </div>
                                                    <div class="row form-group p-1">
                                                        <label class="col-md-4  my-1">Grave Size</label>
                                                        <b-form-input :disabled=" hideInModal || hideinAuth" class="form-control form-control-sm col-md-8" name="regulation[grave_size]" size="sm" type="text" v-model="formFields.regulation.grave_size = regulation.grave_size"></b-form-input>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row form-group p-1 mr-2">
                                                <h6 class="col-md-4 mt-3 custom-form-heading">Address</h6><br><br>
                                                <button :disabled="hideInModal || hideinAuth" @click="openMap" class="col-md-8 view-larger-map btn btn-link text-left"
                                                        id="mps-map-link" type="button">
                                                    <img height="auto" src="/images/maps.png" width="50">
                                                    Click to Map
                                                </button>
                                            </div>
                                            <div class="row form-group p-1 mr-2">
                                                <label class="col-md-4  my-1">State / Province</label>
                                                <b-form-select
                                                    :disabled="hideInModal || hideinAuth"
                                                    :options="states"
                                                    class="form-control form-control-sm col-md-8 custom-caret-form"
                                                    name="cemetery[state_id]"
                                                    size="sm"
                                                    v-model="formFields.state_id"
                                                    v-on:change="getSelectedCity">
                                                    <template #first>
                                                        <b-form-select-option :value="null" disabled>Select a state</b-form-select-option>
                                                    </template>
                                                </b-form-select>
                                            </div>
                                            <div class="row form-group p-1 mr-2">
                                                <label class="col-md-4  my-1">City</label>
                                                <b-form-select
                                                    :disabled="hideInModal || hideinAuth || disabledCity"
                                                    :options="cities"
                                                    class="form-control form-control-sm col-md-8 custom-caret-form"
                                                    name="cemetery[city_id]"
                                                    size="sm"
                                                    v-model="formFields.city_id">
                                                    <template #first>
                                                        <b-form-select-option :value="null" disabled>Select a city</b-form-select-option>
                                                    </template>
                                                </b-form-select>
                                            </div>
                                            <div class="row form-group p-1 mr-2">
                                                <label class="col-md-4  my-1">Street</label>
                                                <b-form-textarea
                                                    :disabled="hideInModal || hideinAuth"
                                                    class="form-control form-control-sm col-md-8"
                                                    name="cemetery[street]"
                                                    no-resize
                                                    rows="2"
                                                    size="sm"
                                                    v-model="formFields.street"
                                                ></b-form-textarea>
                                            </div>
                                            <div class="row form-group p-1 mr-2">
                                                <label class="col-md-4  my-1">Zip/Postal Code</label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-8" name="cemetery[zip_code]" size="sm" type="text" v-model="formFields.zip_code"></b-form-input>
                                            </div>
                                            <hr class="row border my-0">
                                            <div class="row form-group p-1 mr-2">
                                                <h6 class="col-md-12 my-2 custom-form-heading">Billing Info</h6><br>
                                                <label class="col-md-4  my-1">Check Payable to</label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-8" name="cemetery[check_payable_to]" size="sm" type="text" v-model="formFields.check_payable_to"></b-form-input>
                                            </div>
                                            <div class="row form-group p-1 mr-2">
                                                <label class="col-md-4  my-1">W9 Required</label>
                                                <b-form-select
                                                    :disabled="hideInModal || hideinAuth"
                                                    class="form-control form-control-sm col-md-8 custom-caret-form"
                                                    name="cemetery[w9_required]"
                                                    size="sm"
                                                    v-model="formFields.w9_required">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </b-form-select>
                                            </div>
                                            <div class="row form-group p-1 mr-2">
                                                <label class="col-md-4  my-1">Mailing Address</label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-8" name="cemetery[mailing_address]" size="sm" type="text" v-model="formFields.mailing_address"></b-form-input>
                                            </div>
                                            <div class="row form-group p-1 mr-2">
                                                <label class="col-md-4 my-1">City</label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-3" name="cemetery[city]" size="sm" type="text" v-model="formFields.city_name"></b-form-input>
                                                <label class="col-md-2 my-1">State</label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-3" name="cemetery[state]" size="sm" type="text" v-model="formFields.state_name"></b-form-input>
                                            </div>
                                            <div class="row form-group p-1 mr-2">
                                                <label class="col-md-4 my-1">Zip</label>
                                                <b-form-input :disabled="hideInModal || hideinAuth" class="form-control form-control-sm col-md-3 m-0" name="cemetery[zip]" size="sm" type="text" v-model="formFields.zip"></b-form-input>
                                            </div>
                                        </div>
                                        <div class="col-md-8 custom-border-left">
                                            <div class="row custom-border-bottom">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <h6 class="col-md-12 mt-3 custom-form-heading">Cemetery Info</h6><br>
                                                    </div>
                                                    <div class="row form-group">
                                                        <label class="col-md-2  my-1">Flagging Info</label>
                                                        <b-form-input :disabled=" hideInModal || hideinAuth" class="form-control form-control-sm col-md-10" name="flagginginfo"
                                                                      size="sm" type="text"
                                                                      v-model="formFields.flagging_info"></b-form-input>
                                                    </div>
                                                    <div class="row form-group">
                                                        <label class="col-md-2  my-1">Installation Zone</label>
                                                        <b-form-input :disabled=" hideInModal || hideinAuth" class="form-control form-control-sm col-md-10" name="installationZone"
                                                                      size="sm" type="text"
                                                                      v-model="formFields.installation_zone"></b-form-input>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <h6 class="col-md-12 mt-4 custom-form-heading">Notes</h6><br>
                                                <b-form-textarea
                                                    :disabled="hideInModal || hideinAuth"
                                                    class="form-control form-control-sm col-md-12"
                                                    name="cemetery[notes]"
                                                    no-resize
                                                    rows="21"
                                                    size="sm"
                                                    v-model="formFields.notes"
                                                ></b-form-textarea>
                                            </div>
                                            <div class="dbupdate-row">
                                                <div class="flex-row ml-n3">
                                                    <label>Database Updated Date</label>
                                                </div>
                                                <div class="flex-row mx-1">
                                                    <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                                                       :disabled="hideInModal || hideinAuth"
                                                                       class="input-date"
                                                                       close-button
                                                                       locale="en"
                                                                       placeholder=""
                                                                       reset-button
                                                                       size="sm"
                                                                       today-button
                                                                       v-model="formFields.db_updated_date">
                                                    </b-form-datepicker>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="custom-border-top" v-if="!hideInModal">
                                        <button :disabled="saveDisabled" @click="storeCemetery" class=" mt-3 btn-info mx-1 custom-infobtn-toolbar custom-infobtn-text" type="button" v-if="formFields.id ? isUpdatePermitted : isCreatePermitted">
                                            {{ formFields.id ? 'Update' : 'Save' }}<span class="spinner-grow spinner-grow-sm ml-1" v-if="saveDisabled"></span>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Toolbar from "./Toolbar";
    import Price from "../../Modules/Price";
    import {event, eventBus} from "../../event-bus/event-bus";
    import {deleteProductFile, deleteRecord, fetchRecord, firstRecord, lastRecord, nextRecord, previousRecord, saveRecord} from "../../helpers/axios";

    export default {
        name: "Add",
        props: {
            id: {
                type: Number
            },
            hideInModal: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                pageNumber: 1,
                // storeID : this.$store.getters.getCurrentStoreID,
                formFields: {
                    // store_id: this.storeID,
                    id: 0,
                    company: null,
                    contact_first_name: null,
                    contact_last_name: null,
                    job_title: null,
                    additional_contact: null,
                    email: null,
                    web_page: null,
                    gps: null,
                    notes: null,
                    business_phone: null,
                    fax_number: null,
                    home_phone: null,
                    mobile_phone: null,
                    installation_zone: null,
                    flagging_info: null,
                    notes: null,
                    zip_code: null,
                    street: null,
                    db_updated_date: null,
                    check_payable_to: null,
                    w9_required: null,
                    mailing_address: null,
                    city_name: null,
                    state_name: null,
                    zip: null,
                    category_id: null,
                    city_id: null,
                    state_id: null,
                    county_id: null,
                    regulation: {
                        id: 0,
                        auth_for_install: null,
                        auth_for_install_customer: null,
                        perpetual_care_fee: null,
                        cemeteries_style: null,
                        flagging_fee: null,
                        apron_size: null,
                        setting_fee: null,
                        mont_single_size: null,
                        mont_double_size: null,
                        mis_fee: null,
                        grave_size: null
                    },
                    documents: {image: null, files: []},
                },
                image: null,
                imagePath: '/images/cemetery/',
                imageDefault: '/images/default-image.jpg',
                storagePath: '/images/cemetery/',
                validFileTypes: ['jpeg', 'JPEG', 'jpg', 'JPG', 'png', 'PNG', 'svg', 'SVG', 'pdf', 'PDF', 'docx', 'DOCX', 'xlsx', 'ai', 'lwp'],
                imageFileTypes: ['jpeg', 'JPEG', 'jpg', 'JPG', 'png', 'PNG', 'svg', 'SVG'],
                docLwpPdfAiTypes: ['pdf', 'PDF', 'docx', 'DOCX', 'xlsx', 'ai', 'lwp'],
                axiosParams: {module: 'cemetery'},
                axiosParamsCategory: {module: 'cemetery/category'},
                axiosParamsGetCategory: {module: 'cemeteryCategory'},
                searchCategory: "",
                alertMessage: '',
                hideAlert: true,
                successResponse: false,
                errorResponse: false,
                saveDisabled: false,
                hideinAuth: false,
                disabledCity: false,
            }
        },
        metaInfo() {
            return {
                title: `${this.formFields.id ? 'Edit' : 'Add'} Cemetery`,
            }
        },
        created() {
            eventBus.$on(event.SAVE_CEMETERY, this.storeCemetery);
            eventBus.$on(event.FIRST_CEMETERY_RECORD, this.first);
            eventBus.$on(event.LAST_CEMETERY_RECORD, this.last);
            eventBus.$on(event.NEXT_CEMETERY_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_CEMETERY_RECORD, this.prev);
            eventBus.$on(event.GET_CEMETERY, this.getCemetery);
            eventBus.$on(event.ADD_CEMETERY, this.clearForm);
            eventBus.$on(event.DELETE_CEMETERY, this.deleteRecord);
        },
        destroyed() {
            eventBus.$off(event.SAVE_CEMETERY, this.storeCemetery);
            eventBus.$off(event.FIRST_CEMETERY_RECORD, this.first);
            eventBus.$off(event.LAST_CEMETERY_RECORD, this.last);
            eventBus.$off(event.NEXT_CEMETERY_RECORD, this.next);
            eventBus.$off(event.PREVIOUS_CEMETERY_RECORD, this.prev);
            eventBus.$off(event.GET_CEMETERY, this.getCemetery);
            eventBus.$off(event.ADD_CEMETERY, this.clearForm);
            eventBus.$off(event.DELETE_CEMETERY, this.deleteRecord);
        },
        components: {
            Toolbar,
            Price
        },
        computed: {
            isLoading() {
                return this.$store.state[this.axiosParams.module].busy;
            },
            isCreatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Cemetery', action: 'create'});
            },
            isUpdatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Cemetery', action: 'update'});
            },
            alertClasses: function () {
                return {
                    alert: true,
                    'alert-success': this.successResponse,
                    'alert-danger': this.errorResponse,
                    'd-none': this.hideAlert
                }
            },
            regulation: function () {
                if (this.formFields.regulation == null) {
                    this.formFields.regulation = {
                        id: 0,
                        auth_for_install: null,
                        auth_for_install_customer: null,
                        perpetual_care_fee: null,
                        cemeteries_style: null,
                        flagging_fee: null,
                        apron_size: null,
                        setting_fee: null,
                        mont_single_size: null,
                        mont_double_size: null,
                        mis_fee: null,
                        grave_size: null
                    }
                }
                this.formFields.regulation = {...this.formFields.regulation}
                return this.formFields.regulation;
            },
            cemeteryCategoryTitle() {
                let opt = "Select";
                if (this.$store.state[this.axiosParams.module].type?.length > 0 && this.formFields.category_id != 0 && this.formFields.category_id != null) {
                    opt = this.$store.state[this.axiosParams.module].type.filter(obj => obj.id == this.formFields.category_id);
                    opt = opt.length > 0 ? opt[0].title : "Select";
                }
                return opt
            },
            cemeteryCategories() {
                let options = [];
                if (this.$store.state[this.axiosParams.module].type) {
                    for (let opt of this.$store.state[this.axiosParams.module].type) {
                        let obj = {value: opt.id, text: opt.title};
                        options.push(obj);
                    }
                    if (this.searchCategory != '') {
                        options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchCategory.toUpperCase()) > -1)
                    }
                }
                return options;
            },
            cities: function () {
                let options = [];
                if (this.$store.state.cemetery.cemeteryInfo.cities) {
                    this.$store.getters.sortByAlphaNumeric({'fieldName': 'city_title', 'recordList': this.$store.state.cemetery.cemeteryInfo.cities});
                    for (let opt of this.$store.state.cemetery.cemeteryInfo.cities) {
                        let obj = {value: opt.id, text: opt.city_title};
                        options.push(obj);
                    }
                }
                this.formFields.state_id ? this.disabledCity = false : this.disabledCity = true;
                return options;
            },
            getCity: function () {
                this.formFields.state_id ? this.getSelectedCity() : '';
            },
            counties: function () {
                let options = [];
                if (this.$store.state.cemetery.cemeteryInfo.counties) {
                    this.$store.getters.sortByAlphaNumeric({'fieldName': 'county_title', 'recordList': this.$store.state.cemetery.cemeteryInfo.counties});
                    for (let opt of this.$store.state.cemetery.cemeteryInfo.counties) {
                        let obj = {value: opt.id, text: opt.county_title};
                        options.push(obj);
                    }
                }
                return options;
            },
            states: function () {
                let options = [];
                if (this.$store.state.cemetery.cemeteryInfo.states) {
                    this.$store.getters.sortByAlphaNumeric({'fieldName': 'state_title', 'recordList': this.$store.state.cemetery.cemeteryInfo.states});
                    for (let opt of this.$store.state.cemetery.cemeteryInfo.states) {
                        let obj = {value: opt.id, text: opt.state_title};
                        options.push(obj);
                    }
                }
                return options;
            },
            documents() {

                if (this.formFields.documents == undefined || Object.keys(this.formFields.documents).length == 0) {
                    this.formFields.documents = {image: null, files: []};
                }
                return this.formFields.documents;
            },
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Cemetery', action: 'read'}))
                this.$router.push('/access-denied');
        },
        mounted() {
            // this.formFields.store_id = this.storeID
            this.$store.state[this.axiosParams.module].busy = true
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            if (!this.$store.getters.isPermitted({resource: 'Cemetery', action: 'create'}) && !this.$store.getters.isPermitted({resource: 'Cemetery', action: 'update'}))
                this.$props.hideInModal = true;
            if (this.formFields.id > 0 && !this.$store.getters.isPermitted({resource: 'Cemetery', action: 'update'}))
                this.hideinAuth = true;
            this.getCemetery(this.formFields.id);
            this.getColumns();
            this.getRecords();
            this.$store.getters.detectFormChanges();
        },
        methods: {
            /** Map*/
            checkFileType: function (fileName) {
                let ext = fileName.substr(fileName.lastIndexOf('.') + 1);
                let fileIndex = this.docLwpPdfAiTypes.indexOf(ext);
                if (fileIndex > -1) {
                    return true;
                }
                return false;
            },
            openPreviewNewPage: function (url) {
                window.open(url, '_blank');
            },
            getSelectedCity: function () {
                this.axiosParams.id = this.formFields.state_id;
                this.axiosParams.method = '/cityInfo/';
                deleteProductFile(this.axiosParams, (response) => {
                    if (response.data) {
                        this.$store.state.cemetery.cemeteryInfo.cities = response.data.cities;
                        this.cities;
                    }
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                })
            },
            deleteFile(id, index) {
                if (confirm("Do you really want to delete this file?")) {
                    this.axiosParams.id = id;
                    this.axiosParams.method = '/deleteFile/';
                    deleteProductFile(this.axiosParams, (response) => {
                        if (response.data) {
                            this.formFields.files.splice(index, 1);
                        }
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                }
            },
            openMap: function () {
                let Street = this.formFields.street;
                let City = this.formFields.city_id ? this.cities.find(option => option.value === this.formFields.city_id).text : "";
                let State = this.formFields.state_id ? this.states.find(option => option.value === this.formFields.state_id).text : "";
                let County = this.formFields.county_id ? this.counties.find(option => option.value === this.formFields.county_id).text : "United States";
                let ZipCode = this.formFields.zip_code;
                let map_href = "https://maps.google.com/?q='" + Street + "','" + City + "' + '" + State + "' +  '" + County + "' + '" + ZipCode + "' +";
                window.open(map_href, '_blank');
            },
            handleDropdownChange: function(value){
                window.detectChanges = true;
            },

            getCurrentLocation: function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(this.getCurrentCoordinates);
                }
            },
            getCurrentCoordinates: function (position) {
                return position.coords.latitude + ", " + position.coords.longitude;
            },
            previewImage: function (event) {
                let input = event.target;
                let invalidFileType = false;
                if (input.files.length > 0) {
                    for (let file of input.files) {
                        let fileType = file.name.split('.');
                        let FileSize = file.size / 1024 / 1024;
                        if (FileSize > 25 || this.validFileTypes.indexOf(fileType[fileType.length - 1]) == -1) {
                            invalidFileType = true;
                            break;
                        }
                    }
                }
                if (invalidFileType) {
                    this.makeToast({title: 'Error', message: 'Invalid image type or File size exceeds 25 MB', variant: 'danger', duration: 3000});
                    this.$refs['inputFile'].reset();
                    return false;
                }
            },
            /** CRUD */
            getCemetery: function (id) {
                if (id) {
                    this.axiosParams.id = id;
                    fetchRecord(this.axiosParams, (response) => {
                        this.image = null;
                        this.formFields = response.data;
                        this.$store.dispatch('getCemeteryInfo', this.formFields.state_id)
                        if (this.$store.state[this.axiosParams.module].recordList.length > 0)
                            this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                }
                if (this.$store.state[this.axiosParams.module].type.length == 0) {
                    this.axiosParamsGetCategory.id = 0
                    fetchRecord(this.axiosParamsGetCategory, (response) => {
                        this.$store.state[this.axiosParams.module]['type'] = response.data
                        this.$store.getters.sortByAlphaNumeric({'fieldName': 'title', 'recordList': this.$store.state[this.axiosParams.module].type});
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                }
            },

            storeCemetery: function () {
                this.saveDisabled = true;
                let data = this.formFields;
                let formData = new FormData();
                if (this.documents.image)
                    formData.append('image_file', this.documents.image);
                formData.append('data', JSON.stringify(data));
                if (data.documents.files.length > 0) {
                    for (let file of data.documents.files) {
                        formData.append('doc_files[]', file);
                    }
                }
                saveRecord(this.axiosParams, formData, (response) => {
                        if (response.data.errorInfo) {
                            this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                            this.makeToast({title: 'Error', message: this.alertMessage, variant: 'danger', duration: '5000'});
                            this.alertMessage = '';
                        } else {
                            let status = this.formFields.id ? 'Updated' : 'Added';
                            this.alertMessage = `Record Successfully ${status}`;
                            this.makeToast({title: 'Cemetery ' + status, message: this.alertMessage, variant: 'success'});
                            this.image = null;
                            this.$refs['inputFile'].reset();
                            this.formFields = response.data;
                            this.axiosParams.data = response.data;
                            this.alertMessage = '';
                            this.$store.commit('appendOrUpdateInRecordList', this.axiosParams);
                        }
                    }, (error) => {
                            this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
            },

            deleteRecord: function (id) {
                if (confirm("Do you really want to delete this record?")) {
                    this.axiosParams.id = id;
                    this.$store.dispatch('removeRecordFromList', this.axiosParams);
                    deleteRecord(this.axiosParams, (response) => {
                        if (response.data) {
                            let params = {module: 'quote', detail: 'cemetery', id: this.axiosParams.id}
                            this.$store.dispatch('removeDetailFromList', params);
                            if (this.$store.state[this.axiosParams.module].recordList.length == 0)
                                this.clearForm();
                            else
                                this.first()
                        }
                    }, (error) => {
                            this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                }
            },

            getColumns() {
                if (this.$store.state[this.axiosParams.module].columnList.length == 0) {
                    this.$store.dispatch('getColumnList', this.axiosParams);
                }
            },
            getRecords() {
                if (!this.hideInModal)
                    this.$store.dispatch('getDropDownInfo', {module: this.axiosParams.module, apiURL: 'getDropDownRecord', page: this.pageNumber})
            },
            setDetail(obj, detail) {
                this.formFields[detail + '_id'] = obj.value;
                this.formFields[detail] = obj.text;
            },
            deleteDropDown: function (id) {
                if (confirm('Do you really want to delete this record ?')) {
                    let moduleName = this.axiosParamsCategory.module;
                    deleteRecord({id: id, module: moduleName}, (response) => {
                        let list = this.$store.state[this.axiosParams.module]['type'];
                        this.spliceRecord(list, id);
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                }
            },
            spliceRecord: function (list, id) {
                let record = list.find(obj => obj.id == id);
                let currentIndex = list.indexOf(record);
                list.splice(currentIndex, 1);
            },
            saveDetail: function (detail) {
                let data = {id: 0};
                data[detail] = this.searchCategory
                let params = this.axiosParamsCategory;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                saveRecord(params, formData, (response) => {
                    if (response.data.errorInfo) {
                        this.alertMessage = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.errorResponse = true;
                        this.handleAlert();
                    } else {
                        this.$store.state[this.axiosParams.module]['type'].splice(this.$store.state[this.axiosParams.module]['type'].length + 1, 0, response.data)
                    }
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                })
            },

            /** Pagination*/
            first: function () {
                this.$refs['inputFile'].reset();
                this.$store.state[this.axiosParams.module].busy = true
                firstRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.image = null;
                        this.formFields = response.data;
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                })
            },
            last: function () {
                this.$refs['inputFile'].reset();
                this.$store.state[this.axiosParams.module].busy = true
                lastRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.image = null;
                        this.formFields = response.data;
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                })
            },
            next: function (id) {
                this.$refs['inputFile'].reset();
                this.$store.state[this.axiosParams.module].busy = true
                this.axiosParams.id = id;
                nextRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.image = null;
                        this.formFields = response.data;
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                })
            },
            prev: function (id) {
                this.$refs['inputFile'].reset();
                this.$store.state[this.axiosParams.module].busy = true
                this.axiosParams.id = id;
                previousRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.image = null;
                        this.formFields = response.data;
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                })
            },

            /** Generic*/
            clearForm: function () {
                if (window.detectChanges && !confirm('You have unsaved changes. Are you sure you want to navigate away?')) {
                    this.$store.state[this.axiosParams.module].busy = false
                } else {
                    window.detectChanges = false;
                }
                if (!window.detectChanges) {
                    this.$refs['inputFile'].reset();
                    this.formFields = {
                        // store_id: this.storeID,
                        id: 0,
                        w9_required: null,
                        category_id: null,
                        regulation: {
                            id: 0,
                            auth_for_install: null,
                            auth_for_install_customer: null,
                            perpetual_care_fee: null,
                            flagging_fee: null,
                            setting_fee: null,
                            mis_fee: null,
                        }
                    };
                    this.image = null;
                }
            },
            handleAlert: function () {
                this.saveDisabled = false;
                this.hideAlert = false;
                setTimeout(() => {
                    this.alertMessage = "";
                    this.successResponse = false;
                    this.errorResponse = false;
                    this.hideAlert = true;
                }, 3000)
            },
            customizeLabel: function (str) {
                let i, labels = str.split('_');
                for (i = 0; i < labels.length; i++) {
                    labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
                }
                return labels.join(' ');
            },
            setCurrentRecord() {
                this.$store.state[this.axiosParams.module].currentRecord = this.formFields;
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
                this.saveDisabled = false;

            },
        },
    }
</script>

<style scoped>
    .border {
        border: 1px solid #c4c4c4 !important;
    }

    .cemetery-form div input, select, textarea, .input-date {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.75rem;
    }

    .dbupdate-row, .documents-row div {
        display: flex;
        margin: 0.5rem 0;
        padding-left: 1rem;
    }

    .documents-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
    }

    .input-cemetery {
        width: 18rem !important;
    }

    .custom-modal-margin {
        padding-top: 0rem;
        margin-right: -.9rem;
        padding-left: 0rem;
        padding-bottom: -0.9rem;
        background-color: #e9ecef;
    }


</style>
