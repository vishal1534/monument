<template>

    <div>
        <div class="row">
            <div class="col-md-12">

                <form class="bg-white rounded mx-2 mb-2 p-3">

                    <div class="form-content">

                        <div class="custom-row border rounded my-2">

                            <div class="d-block custom-border-right px-1 pt-1 my-0">
                                <label class="font-weight-bold">Date:</label><br>
                                <label>{{ changeDateFormat(formFields.date) }}</label>

                            </div>
                            <!--<div class="d-block custom-border-right px-1 pt-1 my-0">
                                <label class="font-weight-bold">Day:</label><br>
                                <label>{{getDayOfWeek(formFields.date)}}</label>
                            </div>
                            <div class="d-block custom-border-right px-1 pt-1 my-0">
                                <label class="font-weight-bold">Customer Name:</label><br>
                                <label>{{formFields.company.name}}</label>
                            </div>-->
                            <div class="d-block custom-border-right px-1 pt-1 my-0">
                                <label class="font-weight-bold">Last Name on Stone:</label><br>
                                <label>{{formFields.family.name_on_stone}}</label>
                            </div>
                            <div class="d-block px-1 pt-1 my-0">
                                <label class="font-weight-bold">Invoice No.</label><br>
                                <label>{{formFields.invoice.invoice_number }}</label>
                            </div>
                        </div>

                        <div class="custom-row">
                            <div>
                                <label class="font-weight-bold label-contact ml-0">Name:</label>
                                <b-form-input type="text" class="form-control form-control-sm" size="sm"
                                              v-model="formFields.memorial_production.name"></b-form-input>
                            </div>
                            <div>
                                <label class="font-weight-bold">Last Name:</label>
                                <b-form-input type="text" class="form-control form-control-sm" size="sm"
                                              v-model="formFields.memorial_production.last_name"></b-form-input>
                            </div>

                        </div>
                        <div class="custom-row">
                            <div class="">
                                <label class="font-weight-bold input-label col-2 ml-n3">Address:</label>

                                <b-form-input
                                    class=""
                                    size="sm"
                                    v-model="formFields.memorial_production.address"
                                ></b-form-input>
                            </div>

                        </div>
                        <div class="custom-row">
                            <div class="">
                                <label class="font-weight-bold input-label col-2 ml-n3">Ship To Address:</label>

                                <b-form-input
                                    class=""
                                    size="sm"
                                    v-model="formFields.memorial_production.ship_to_address"
                                ></b-form-input>
                            </div>

                        </div>
                        <div class="custom-row custom-sales-row-div">
                            <div>
                                <label class="font-weight-bold ml-0">Trucking:</label>
                                <b-form-input type="text" class="form-control form-control-sm" size="sm"
                                              v-model="formFields.memorial_production.trucking"></b-form-input>
                            </div>
                            <div>
                                <label class="font-weight-bold">Request Date:</label>
                                <label class="print-elm">{{ changeDateFormat(formFields.memorial_production.request_date) }}</label>
                                <b-form-datepicker
                                    :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                    class="my-auto input-date non-print-elm" size="sm" name="date"
                                    placeholder=""
                                    v-model="formFields.memorial_production.request_date"
                                    @input="formFields.memorial_production.request_date = checkDate(formFields.memorial_production.request_date)"
                                    today-button
                                    reset-button
                                    close-button
                                    locale="en">
                                </b-form-datepicker>
                            </div>

                        </div>

                        <div class="custom-row custom-sales-row-div">
                            <div class="">
                                <label class="font-weight-bold ml-0">Sales/Customer Care Rep:</label>
                                <b-form-input type="text" size="sm"
                                              v-model="formFields.memorial_production.sales_rep"></b-form-input>
                            </div>
                        </div>
                        <b-table bordered small class="memorial-table-border"
                                 :items="inPDF ? memorialProducts.slice(0, memorialProducts.length -1) : memorialProducts"
                                 :fields="productTableFields">

                            <template #head()="data">
                                <span class="custom-form-heading ml-2" style="font-size: 12px !important;">{{ data.label }}</span>
                            </template>

                            <!-- For non-stocking products show product_number and product_name fields as input fields
                                Otherwise just print them -->

                            <template #cell(product_number)="row">
                                <!--                                <label class="d-flex justify-content-center product-table">{{row.item.product_number}}</label>-->
                                <b-dropdown no-caret class="border rounded m-0 non-print-elm dropdown-style mt-1 w-75" size="sm" variant="none">

                                    <template #button-content>
                                        <div class="d-flex m-0">
                                            <small>{{ row.item.product_number ? row.item.product_number : 'Select' }}</small>
                                            <i class="fa fa-caret-down ml-auto" aria-hidden="true"></i>
                                        </div>
                                    </template>

                                    <b-dropdown-group class="overflow-auto scroll px-1">
                                        <template v-for="obj of formFields.products" >
                                            <b-dropdown-group>

                                                <template v-if="obj.monument && obj.monument[0]">
                                                    <b-dropdown-item-button class="small" @click="row.item.product_number = obj.monument[0].product_number, row.item.description = obj.monument[0].description, row.item.type = obj.monument[0].type ? obj.monument[0].type.type_title: '', row.item.color = obj.monument[0].color ? obj.monument[0].color.color_title: '' ">
                                                        {{ obj.monument[0].product_number}}
                                                    </b-dropdown-item-button>
                                                </template>

                                                <template v-if="obj.composite && obj.composite[0]">
                                                    <b-dropdown-item-button class="small" @click="row.item.product_number = obj.composite[0].product_number, row.item.description = obj.composite[0].description">
                                                        {{ obj.composite[0].product_number}}
                                                    </b-dropdown-item-button>
                                                </template>

                                                <template v-if="obj.service && obj.service[0]">
                                                    <b-dropdown-item-button class="small" @click="row.item.product_number = obj.service[0].product_number, row.item.description = obj.service[0].description, row.item.type = obj.service[0].type ? obj.service[0].type: '', row.item.color = obj.service[0].color ? obj.service[0].color: '' ">
                                                        {{ obj.service[0].product_number}}
                                                    </b-dropdown-item-button>
                                                </template>

                                                <template v-if="obj.simple && obj.simple[0]">
                                                    <b-dropdown-item-button class="small" @click="row.item.product_number = obj.simple[0].product_number, row.item.description = obj.simple[0].description, row.item.type = obj.simple[0].type ? obj.simple[0].type: '', row.item.color = obj.simple[0].color ? obj.simple[0].color: '' ">
                                                        {{ obj.simple[0].product_number}}
                                                    </b-dropdown-item-button>
                                                </template>

                                            </b-dropdown-group>
                                        </template>
                                    </b-dropdown-group>

                                </b-dropdown>
                                <label class="print-elm">{{ row.item.product_number ? row.item.product_number  : 'Select' }}</label>
                            </template>

                            <template #cell(description)="row">
                                <label class="d-flex ml-2 product-table">{{row.item.description}}</label>
                            </template>

                            <template #cell(type)="row">
                                <label class="d-flex ml-2 product-table">{{row.item.type}}</label>
                            </template>

                            <template #cell(color)="row">
                                <label class="d-flex ml-2 product-table">{{row.item.color}}</label>
                            </template>

                            <template #cell(action)="data">
                                <a v-if="data.item.id" class="btn btn-sm btn-danger mx-1 py-1" href="javascript:void(0)"
                                   @click="removeProduct(data.index, data.item.id)">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                            </template>
                        </b-table>

                        <div class="custom-row my-0">
                            <div class="d-block custom-carving-row-div">
                                <div>
                                    <label class="font-weight-bold ml-0">Design and Carving Styles:</label>
                                </div>
                                <div>
                                    <b-form-group class="custom-checkbox">
                                        <b-form-checkbox-group
                                            class="custom-checkbox flex-column"
                                            v-model="formFields.memorial_production.design_carving_styles"
                                            stacked
                                            plain>
                                            <b-form-checkbox
                                                v-for="design in designStyleList"
                                                :value="design.value"
                                                :key="design.value"
                                                :class="inPDF?'mt-2 mb-2':'my-1'"
                                            >
                                                {{ design.text }}
                                            </b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                                <!--                                <b-form-checkbox  class="my-2 custom-checkbox memorial-production-print-checkbox" value=1 unchecked-value=0 v-model="formFields.memorial_production.design_none">-->
                                <!--                                </b-form-checkbox>-->

                            </div>
                            <div class="d-block">
                                <label :class="inPDF?'ml-0 mt-1':'ml-0'" >Description: use name & number <span
                                    class="ml-5">Example: BARN02002</span></label>
                                <b-form-input type="text" :class="inPDF?'mt-3 mb-2':'my-2'" size="sm"
                                              v-model="formFields.memorial_production.desc_design_none"></b-form-input>
                                <b-form-input type="text" :class="inPDF?'mt-3 mb-2':'my-2'" size="sm"
                                              v-model="formFields.memorial_production.desc_design_curve"></b-form-input>
                                <b-form-input type="text" :class="inPDF?'mt-3 mb-2':'my-2'" size="sm"
                                              v-model="formFields.memorial_production.desc_design_shape"></b-form-input>
                                <b-form-input type="text" :class="inPDF?'mt-3 mb-2':'my-2'" size="sm"
                                              v-model="formFields.memorial_production.desc_design_deluxe"></b-form-input>
                                <b-form-input type="text" :class="inPDF?'mt-3 mb-2':'my-2'" size="sm"
                                              v-model="formFields.memorial_production.desc_design_skin"></b-form-input>
                                <b-form-input type="text" :class="inPDF?'mt-3 mb-2':'my-2'" size="sm"
                                              v-model="formFields.memorial_production.desc_design_precision"></b-form-input>
                                <b-form-input type="text" :class="inPDF?'mt-3 mb-2':'my-2'" size="sm"
                                              v-model="formFields.memorial_production.desc_design_diamond"></b-form-input>
                                <b-form-input type="text" :class="inPDF?'mt-3 mb-2':'my-2'" size="sm"
                                              v-model="formFields.memorial_production.desc_design_laser"></b-form-input>
                            </div>
                        </div>
                        <div class="custom-row d-block my-n2">
                            <div class="my-n2">
                                <label class="font-weight-bold col-4 ml-n3">Attach Precious Portrait:</label>
                                <label class="print-elm my-1">{{printVal(formFields.memorial_production.attach_precious_portrait)}}</label>
                                <b-form-group class="m-0 my-auto custom-radio-and-checkbox input-md non-print-elm">
                                    <b-form-radio-group
                                        v-model="formFields.memorial_production.attach_precious_portrait">
                                        <b-form-radio :value=1>Yes</b-form-radio>
                                        <b-form-radio :value=0>No</b-form-radio>
                                    </b-form-radio-group>
                                </b-form-group>
                            </div>
                            <div class="my-n2">
                                <label class="font-weight-bold col-4 ml-n3">Recess area for Precious Portrait:</label>
                                <label class="print-elm my-1">{{printVal(formFields.memorial_production.recess_precious_portrait)}}</label>
                                <b-form-group class="m-0 my-auto custom-radio-and-checkbox input-md non-print-elm">
                                    <b-form-radio-group
                                        v-model="formFields.memorial_production.recess_precious_portrait">
                                        <b-form-radio :value=1>Yes</b-form-radio>
                                        <b-form-radio :value=0>No</b-form-radio>
                                    </b-form-radio-group>
                                </b-form-group>
                            </div>
                        </div>
                        <hr class="custom-border-top my-3">
                        <div class="custom-row my-2 d-block">
                            <div class="ml-n3">
                                <div class="col-3">
                                    <label class="font-weight-bold ml-0">Panels</label>
                                </div>
                                <div class="col-1">
                                    <label class="ml-0">FN</label>
                                </div>
                                <div class="col-1">
                                    <label class="ml-0 non-print-elm">INS</label>
                                    <label class="ml-n2 print-elm">INS</label>
                                </div>
                                <div class="col-1">
                                    <label class="ml-0 non-print-elm">VRS</label>
                                    <label class="ml-n3 print-elm">VRS</label>
                                </div>
                            </div>
                            <div class="my-n3 ml-n3">
                                <div class="col-3">
                                    <label class="ml-0">No Panel(s):</label>
                                </div>
                                <div>
                                    <b-form-group class="w-100 m-0">
                                        <b-form-checkbox-group v-model="formFields.memorial_production.no_panels" plain>
                                            <b-form-checkbox class="col-1 mx-3" value="fn"></b-form-checkbox>
                                            <b-form-checkbox class="col-1" value="ins"></b-form-checkbox>
                                            <b-form-checkbox class="col-1 mx-3" value="vrs"></b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="my-n3 ml-n3">
                                <div class="col-3">
                                    <label class="ml-0">Single Line:</label>
                                </div>
                                <div>
                                    <b-form-group class="w-100 m-0">
                                        <b-form-checkbox-group
                                            v-model="formFields.memorial_production.single_line_panels" plain>
                                            <b-form-checkbox class="col-1 mx-3" value="fn"></b-form-checkbox>
                                            <b-form-checkbox class="col-1" value="ins"></b-form-checkbox>
                                            <b-form-checkbox class="col-1 mx-3" value="vrs"></b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="my-n3 ml-n3">
                                <div class="col-3">
                                    <label class="ml-0">Double Line:</label>
                                </div>
                                <div>
                                    <b-form-group class="w-100 m-0">
                                        <b-form-checkbox-group
                                            v-model="formFields.memorial_production.double_line_panels" plain>
                                            <b-form-checkbox class="col-1 mx-3" value="fn"></b-form-checkbox>
                                            <b-form-checkbox class="col-1" value="ins"></b-form-checkbox>
                                            <b-form-checkbox class="col-1 mx-3" value="vrs"></b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="my-n3 ml-n3">
                                <div class="col-3">
                                    <label class="ml-0">Other:</label>
                                    <b-form-input type="text" class="input-md mr-4 " size="sm"
                                                  v-model="formFields.memorial_production.other_panel_first_desc"></b-form-input>
                                </div>
                                <div>
                                    <b-form-group class="w-100 m-0">
                                        <b-form-checkbox-group
                                            v-model="formFields.memorial_production.other_first_panels" plain>
                                            <b-form-checkbox class="col-1 mx-3" value="fn"></b-form-checkbox>
                                            <b-form-checkbox class="col-1" value="ins"></b-form-checkbox>
                                            <b-form-checkbox class="col-1 mx-3" value="vrs"></b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="my-n3 ml-n3">
                                <div class="col-3">
                                    <label class="ml-0">Other:</label>
                                    <b-form-input type="text" class="input-md mr-4" size="sm"
                                                  v-model="formFields.memorial_production.other_panel_second_desc"></b-form-input>
                                </div>
                                <div>
                                    <b-form-group class="w-100 m-0">
                                        <b-form-checkbox-group
                                            v-model="formFields.memorial_production.other_second_panels" plain>
                                            <b-form-checkbox class="col-1 mx-3" value="fn"></b-form-checkbox>
                                            <b-form-checkbox class="col-1" value="ins"></b-form-checkbox>
                                            <b-form-checkbox class="col-1 mx-3" value="vrs"></b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </div>
                        </div>
                        <hr class="custom-border-top my-3">
                        <div class="custom-row my-n2">
                            <div class="d-block col-4 ml-n3">
                                <div>
                                    <label class="font-weight-bold ml-0">Darkening Agent:</label>
                                </div>
                                <div>
                                    <b-form-group class="custom-checkbox">
                                        <b-form-checkbox-group
                                            class="custom-checkbox flex-column"
                                            v-model="formFields.memorial_production.darkening_agents"
                                            :options="darkeningAgentList"
                                            stacked
                                            plain>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="d-block col-4">
                                <div>
                                    <label class="font-weight-bold ml-0">Whitening Agent:</label>
                                </div>
                                <div>
                                    <b-form-group class="custom-checkbox">
                                        <b-form-checkbox-group
                                            class="custom-checkbox flex-column"
                                            v-model="formFields.memorial_production.whitening_agents"
                                            :options="whiteningAgentList"
                                            stacked
                                            plain>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </div>
                        </div>
                        <hr class="custom-border-top non-print-elm">
                        <div class="custom-row my-2 d-block" style="page-break-before: always">
                            <div class="print-elm mt-5"></div>
                            <div>
                                <div class="col-3">
                                    <label class="font-weight-bold ml-n3">Lettering Fonts</label>
                                </div>
                                <div>
                                    <label class="ml-0">*See design book for Letter Font size limitations</label>
                                </div>
                            </div>
                            <div>
                                <div class="col-4">
                                    <label class="font-weight-bold ml-0"></label>
                                </div>
                                <div class="col-2">
                                    <label class="ml-n3">Fam Name</label>
                                </div>
                                <div class="col-2">
                                    <label class="ml-n2 non-print-elm">Inscript</label>
                                    <label class="ml-n4 print-elm ">Inscript</label>
                                </div>
                                <div class="col-2">
                                    <label class="ml-n2 non-print-elm">Verse</label>
                                    <label class="print-elm" style="margin-left: -1.9rem !important;">Verse</label>
                                </div>
                            </div>
                            <div class="my-n3">
                                <div class="col-4">
                                    <label class="ml-n3" style="font-family: apple-chancery;">Apple Chancery</label>
                                </div>
                                <div>
                                    <b-form-group class="w-100 m-0">
                                        <b-form-checkbox-group
                                            v-model="formFields.memorial_production.cqc_script_lettering" plain>
                                            <b-form-checkbox class="col-2 mx-3" value="fam_name"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-4" value="inscript"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-3" value="verse"></b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>

                            </div>
                            <div class="my-n3">
                                <div class="col-4">
                                    <label class="ml-n3" style="font-family: tartine-script-regular;">Tartine Script Regular</label>
                                </div>
                                <div>
                                    <b-form-group class="w-100 m-0">
                                        <b-form-checkbox-group
                                            v-model="formFields.memorial_production.govt_text_lettering" plain>
                                            <b-form-checkbox class="col-2 mx-3" value="fam_name"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-4" value="inscript"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-3" value="verse"></b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="my-n3">
                                <div class="col-4">
                                    <label class="ml-n3" style="font-family: government">GOVERNMENT</label>
                                </div>
                                <div>
                                    <b-form-group class="w-100 m-0">
                                        <b-form-checkbox-group
                                            v-model="formFields.memorial_production.modified_roman_lettering" plain>
                                            <b-form-checkbox class="col-2 mx-3" value="fam_name"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-4" value="inscript"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-3" value="verse"></b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="my-n3">
                                <div class="col-4">
                                    <label class="ml-n3" style="font-family: regular-roman">REGULAR ROMAN</label>
                                </div>
                                <div>
                                    <b-form-group class="w-100 m-0">
                                        <b-form-checkbox-group
                                            v-model="formFields.memorial_production.runstone_lettering" plain>
                                            <b-form-checkbox class="col-2 mx-3" value="fam_name"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-4" value="inscript"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-3" value="verse"></b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="my-n3">
                                <div class="col-4">
                                    <label class="ml-n3" style="font-family: roman-condensed">ROMAN CONDENSED</label>
                                </div>
                                <div>
                                    <b-form-group class="w-100 m-0">
                                        <b-form-checkbox-group
                                            v-model="formFields.memorial_production.connected_script_lettering"
                                            plain>
                                            <b-form-checkbox class="col-2 mx-3" value="fam_name"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-4" value="inscript"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-3" value="verse"></b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="my-n3">
                                <div class="col-4">
                                    <label class="ml-n3" style="font-family: roman-more-condensed">ROMAN MORE CONDENSED</label>
                                </div>
                                <div>
                                    <b-form-group class="w-100 m-0">
                                        <b-form-checkbox-group
                                            v-model="formFields.memorial_production.helvetica_lettering" plain>
                                            <b-form-checkbox class="col-2 mx-3" value="fam_name"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-4" value="inscript"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-3" value="verse"></b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="my-n3">
                                <div class="col-4">
                                    <label class="ml-n3" style="font-family: alternate-gothic">Alternate Gothic No. 3D</label>
                                </div>
                                <div>
                                    <b-form-group class="w-100 m-0">
                                        <b-form-checkbox-group
                                            v-model="formFields.memorial_production.opti_sb_lettering" plain>
                                            <b-form-checkbox class="col-2 mx-3" value="fam_name"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-4" value="inscript"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-3" value="verse"></b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </div>
                            <!--<div class="my-n3">
                                <div class="col-4">
                                    <label class="ml-n3">VERMARCO</label>
                                </div>
                                <div>
                                    <b-form-group class="w-100 m-0">
                                        <b-form-checkbox-group
                                            v-model="formFields.memorial_production.vermarco_lettering" plain>
                                            <b-form-checkbox class="col-2 mx-3" value="fam_name"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-4" value="inscript"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-3" value="verse"></b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="my-n3">
                                <div class="col-4">
                                    <label class="ml-n3">COMMON GOTHIC</label>
                                </div>
                                <div>
                                    <b-form-group class="w-100 m-0">
                                        <b-form-checkbox-group
                                            v-model="formFields.memorial_production.common_gothic_lettering" plain>
                                            <b-form-checkbox class="col-2 mx-3" value="fam_name"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-4" value="inscript"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-3" value="verse"></b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </div>-->
                            <div class="my-n3">
                                <div class="col-4">
                                    <label class="ml-n3">Other:</label>
                                    <b-form-input type="text" class="input-lg mr-4 ml-n1" size="sm"
                                                  v-model="formFields.memorial_production.lettering_other_desc"></b-form-input>

                                </div>
                                <div>
                                    <b-form-group class="w-100 m-0">
                                        <b-form-checkbox-group v-model="formFields.memorial_production.other_lettering"
                                                               plain>
                                            <b-form-checkbox class="col-2 mx-3" value="fam_name"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-4" value="inscript"></b-form-checkbox>
                                            <b-form-checkbox class="col-2 mx-3" value="verse"></b-form-checkbox>
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </div>
                        </div>
                        <div class="custom-row mt-3 custom-border-top custom-border-bottom">
                            <div class="d-block custom-border-right mr-2">

                                <div>
                                    <div class="d-block">
                                        <div>
                                            <div class="col-5">
                                                <label class="font-weight-bold ml-n3">Letter Carving Styles</label>
                                            </div>
                                            <div>
                                                <label class="ml-0">FN</label>
                                            </div>
                                            <div>
                                                <label class="ml-n1">INS</label>
                                            </div>
                                            <div>
                                                <label class="ml-n1">VRS</label>
                                            </div>
                                        </div>
                                        <div class="my-n3">
                                            <div class="col-5">
                                                <label class="ml-n3">V - Sunk</label>
                                            </div>
                                            <div>
                                                <b-form-group class="w-100 m-0">
                                                    <b-form-checkbox-group
                                                        v-model="formFields.memorial_production.carving_v_sunk"
                                                        plain>
                                                        <b-form-checkbox value="fn"></b-form-checkbox>
                                                        <b-form-checkbox value="ins"></b-form-checkbox>
                                                        <b-form-checkbox value="vrs"></b-form-checkbox>
                                                    </b-form-checkbox-group>
                                                </b-form-group>
                                            </div>

                                        </div>
                                        <div class="my-n3">
                                            <div class="col-5">
                                                <label class="ml-n3">U - Sunk</label>
                                            </div>
                                            <div>
                                                <b-form-group class="w-100 m-0">
                                                    <b-form-checkbox-group
                                                        v-model="formFields.memorial_production.carving_u_sunk"
                                                        plain>
                                                        <b-form-checkbox value="fn"></b-form-checkbox>
                                                        <b-form-checkbox value="ins"></b-form-checkbox>
                                                        <b-form-checkbox value="vrs"></b-form-checkbox>
                                                    </b-form-checkbox-group>
                                                </b-form-group>
                                            </div>
                                        </div>
                                        <div class="my-n3">
                                            <div class="col-5">
                                                <label class="ml-n3">Shallow Sunk 1/16”</label>
                                            </div>
                                            <div>
                                                <b-form-group class="w-100 m-0">
                                                    <b-form-checkbox-group
                                                        v-model="formFields.memorial_production.carving_shallow_sunk"
                                                        plain>
                                                        <b-form-checkbox value="fn"></b-form-checkbox>
                                                        <b-form-checkbox value="ins"></b-form-checkbox>
                                                        <b-form-checkbox value="vrs"></b-form-checkbox>
                                                    </b-form-checkbox-group>
                                                </b-form-group>
                                            </div>
                                        </div>
                                        <div class="my-n2 custom-border-bottom">
                                            <div class="col-5">
                                                <label class="ml-n3">Skin Sunk 1/32”</label>
                                            </div>
                                            <div>
                                                <b-form-group class="w-100 m-0">
                                                    <b-form-checkbox-group
                                                        v-model="formFields.memorial_production.carving_skin_sunk"
                                                        plain>
                                                        <b-form-checkbox value="fn"></b-form-checkbox>
                                                        <b-form-checkbox value="ins"></b-form-checkbox>
                                                        <b-form-checkbox value="vrs"></b-form-checkbox>
                                                    </b-form-checkbox-group>
                                                </b-form-group>
                                            </div>
                                        </div>
                                        <div class="my-1">
                                            <div class="col-5 mt-3">
                                                <label class="ml-n3">Polish Raised<br>
                                                    (not cleaned)</label>
                                            </div>
                                            <div>
                                                <b-form-group class="w-100 m-0">
                                                    <b-form-checkbox-group
                                                        v-model="formFields.memorial_production.carving_polish_raised_not_cleaned"
                                                        plain>
                                                        <b-form-checkbox value="fn"></b-form-checkbox>
                                                        <b-form-checkbox value="ins"></b-form-checkbox>
                                                        <b-form-checkbox value="vrs"></b-form-checkbox>
                                                    </b-form-checkbox-group>
                                                </b-form-group>
                                            </div>
                                        </div>
                                        <div class="my-1">
                                            <div class="col-5 mt-3">
                                                <label class="ml-n3">Polish Raised<br>
                                                    (cleaned) (Add’l charge)</label>
                                            </div>
                                            <div>
                                                <b-form-group class="w-100 m-0">
                                                    <b-form-checkbox-group
                                                        v-model="formFields.memorial_production.carving_polish_raised_cleaned"
                                                        plain>
                                                        <b-form-checkbox value="fn"></b-form-checkbox>
                                                        <b-form-checkbox value="ins"></b-form-checkbox>
                                                        <b-form-checkbox value="vrs"></b-form-checkbox>
                                                    </b-form-checkbox-group>
                                                </b-form-group>
                                            </div>
                                        </div>
                                        <div class="my-n2">
                                            <div class="justify-content-center">
                                                <label class="ml-0 text-center">(Use Square Raised (not listed)
                                                    <br>or Helvetica 1” min.)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div>
                                    <div class="col-4">
                                        <label class="font-weight-bold ml-0"></label>
                                    </div>
                                    <div>
                                        <label class="ml-0">FN</label>
                                    </div>
                                    <div>
                                        <label class="ml-n1">INS</label>
                                    </div>
                                    <div>
                                        <label class="ml-n1">VRS</label>
                                    </div>
                                </div>
                                <div class="my-n3">
                                    <div class="col-4">
                                        <label class="ml-0">Frosted Inlaid*</label>
                                    </div>
                                    <div>
                                        <b-form-group class="w-100 m-0">
                                            <b-form-checkbox-group
                                                v-model="formFields.memorial_production.carving_frosted_inlaid"
                                                plain>
                                                <b-form-checkbox value="fn"></b-form-checkbox>
                                                <b-form-checkbox value="ins"></b-form-checkbox>
                                                <b-form-checkbox value="vrs"></b-form-checkbox>
                                            </b-form-checkbox-group>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="my-n3">
                                    <div class="col-4">
                                        <label class="ml-0">Polish Inlaid*</label>
                                    </div>
                                    <div>
                                        <b-form-group class="w-100 m-0">
                                            <b-form-checkbox-group
                                                v-model="formFields.memorial_production.carving_polish_inlaid"
                                                plain>
                                                <b-form-checkbox value="fn"></b-form-checkbox>
                                                <b-form-checkbox value="ins"></b-form-checkbox>
                                                <b-form-checkbox value="vrs"></b-form-checkbox>
                                            </b-form-checkbox-group>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="my-n3">
                                    <div class="col-4">
                                        <label class="ml-0">Frosted Edge*</label>
                                    </div>
                                    <div>
                                        <b-form-group class="w-100 m-0">
                                            <b-form-checkbox-group
                                                v-model="formFields.memorial_production.carving_frosted_edge" plain>
                                                <b-form-checkbox value="fn"></b-form-checkbox>
                                                <b-form-checkbox value="ins"></b-form-checkbox>
                                                <b-form-checkbox value="vrs"></b-form-checkbox>
                                            </b-form-checkbox-group>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="my-n3">
                                    <div class="col-4">
                                        <label class="ml-0">Polish Edge*</label>
                                    </div>
                                    <div>
                                        <b-form-group class="w-100 m-0">
                                            <b-form-checkbox-group
                                                v-model="formFields.memorial_production.carving_polish_edge" plain>
                                                <b-form-checkbox value="fn"></b-form-checkbox>
                                                <b-form-checkbox value="ins"></b-form-checkbox>
                                                <b-form-checkbox value="vrs"></b-form-checkbox>
                                            </b-form-checkbox-group>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="my-n3">
                                    <div class="col-4">
                                        <label class="ml-0">Shadow Bar*</label>
                                    </div>
                                    <div>
                                        <b-form-group class="w-100 m-0">
                                            <b-form-checkbox-group
                                                v-model="formFields.memorial_production.carving_shadow_bar" plain>
                                                <b-form-checkbox value="fn"></b-form-checkbox>
                                                <b-form-checkbox value="ins"></b-form-checkbox>
                                                <b-form-checkbox value="vrs"></b-form-checkbox>
                                            </b-form-checkbox-group>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="justify-content-center">
                                        <label class="ml-0 text-center">*Above carving styles use a Modified Roman<br>
                                            Font; Frosted Inlaid may use Connected Script<br>
                                            or Opti SB. Use of other fonts, for these carving<br>
                                            styles, is considered custom and will incur<br>
                                            additional charges.</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="custom-row non-print-elm">
                            <div>
                                <button type="button" class="btn btn-sm btn-info rounded px-2 my-3" @click="printPDF">
                                    Print Preview
                                </button>
                            </div>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

</template>

<script>
    import {event, eventBus} from "../../../../event-bus/event-bus";
    import {searchForEmptyDate} from "../../../../helpers/common";

    export default {
        name: "Content",
        props: ['formFields', 'production_id', 'order_id', 'inPDF'],
        computed: {
            memorialProducts() {
                if (this.formFields.memorial_production.products && (this.formFields.memorial_production.products.length == 0 || !this.hasNewRow))
                    this.addRow()
                if (this.formFields.memorial_production.products == undefined)
                    this.formFields.memorial_production.products = [];
                //console.log( this.formFields.memorial_production.products ? true:false);
                return this.formFields.memorial_production.products;
            },
            hasNewRow() {
                for (let item of this.formFields.memorial_production.products) {
                    if (item.id == 0)
                        return true
                }
                return false;
            },
        },
        data() {
            return {
                axiosParams: {module: 'order/memorialProduction'},
                productTableFields: [
                    {key: 'product_number', label: "Product #"},
                    {key: 'description', label: "Size & Description"},
                    {key: 'type', label: "Type"},
                    {key: 'color', label: "Color"},
                    {
                        key: 'action',
                        label: "Action",
                        thClass: this.$props.inPDF ? 'd-none' : '',
                        tdClass: this.$props.inPDF ? 'd-none' : ''
                    },
                ],
                designStyleList: [
                    {value: 'none', text: 'None'},
                    {value: 'flat_curve', text: 'Flat Curve'},
                    {value: 'shape_curve', text: 'Shape Curve'},
                    {value: 'deluxe_curve', text: 'Deluxe Curve (Add\'l Charge)'},
                    {value: 'skin_sunk', text: 'Skin Sunk'},
                    {value: 'precision_carve', text: 'Precision Carve'},
                    {value: 'hand_diamond_etch', text: 'Hand Diamond Etch'},
                    {value: 'laser_etch', text: 'Laser Etch'},
                ],
                darkeningAgentList: [
                    {value: 'no_artificial_agent', text: 'No Artificial Agent'},
                    {value: 'transparent_gray_shadow', text: 'Transparent Gray Shadow'},
                    {value: 'dark_gray_shadow', text: 'Dark Gray Shadow'},
                    {value: 'black_shadow', text: 'Black Shadow'},
                ],
                whiteningAgentList: [
                    {value: 'no_artificial_agent', text: 'No Artificial Agent'},
                    {value: 'hilite', text: 'Hilite'},
                    {value: 'heavy_hilite', text: 'Heavy Hilite'},
                ],
            }
        },
        metaInfo() {
            return {
                title: 'Memorial Production'
            }
        },
        methods: {
            save() {
                eventBus.$emit(event.SAVE_MEMORIAL_PRODUCTION)
            },
            changeDateFormat: function(value){
                return this.$store.getters.changeDateFormat(value);
            },
            removeProduct: function (index, id) {
                eventBus.$emit(event.REMOVE_MEMORIAL_PRODUCTION, {index: index, id: id})
            },
            getDayOfWeek: function (date) {
                if (date != null) {
                    const dayOfWeek = new Date(date).getDay();
                    return isNaN(dayOfWeek) ? null :
                        ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
                }
            },
            printVal(val) {
                if (val == 0)
                    return 'No'
                else if (val == 1)
                    return 'Yes'
                else
                    return ''
            },
            printPDF() {
                eventBus.$emit(event.PRINT_PDF)
            },
            addRow() {
                if (!this.inPDF)
                    this.formFields.memorial_production.products.push({id: 0, product_number:'', description:'', type:'', color:''})
            },
            checkDate: function(date){
                return searchForEmptyDate(date);
            },

        }

    }
</script>

<style scoped>
    .form-content {
        margin: 0 auto;
        width: 45rem;
    }

    .custom-row {
        display: flex;
        padding: 0;
    }

    .custom-row div {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }

    .custom-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
        color: #000 !important;
    }

    .custom-row div input, .input-date {
        margin: auto;
        margin-right: 0;
        height: 1.5rem;
        font-size: 12px;
    }
    .custom-row div input, .input-date {
        border: 1px solid #c4c4c4 !important;
    }
    .printing .custom-row div input, .printing .input-date {
        border: transparent !important;
    }

    .border {
        border: 1px solid #c4c4c4 !important;
    }
    .printing .border {
        border: 1px solid #000 !important;
    }

    .custom-border-right {
        border-right: 1px solid #c4c4c4 !important;
    }

    .custom-border-top {
        border-top: 1px solid #c4c4c4 !important;
    }
    .custom-border-bottom {
        border-bottom: 1px solid #c4c4c4 !important;
    }

    .printing .custom-border-right {
        border-right: 1px solid #000 !important;
    }

    .printing .custom-border-top {
        border-top: 1px solid #000 !important;
    }

    .printing .custom-border-bottom {
        border-bottom: 1px solid #000 !important;
    }

    .custom-border-div {
        border: 2px solid #c4c4c4!important;
    }

    header {
        padding: 0 3rem;
    }

    .input-xl {
        width: 18rem;
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

    .custom-checkbox {
        line-height: 1.5rem;
        custom-border-radius: 0;
    }

    .custom-sales-row-div {
        width: 38rem !important;
    }

    .custom-carving-row-div {
        width: 20rem !important;
    }


    .input-select {
        font-size: 12px !important;
        color: #6C757D;
        border: 1px solid #C4C4C4;
        box-sizing: border-box;
        border-radius: 3px;
        height: 1.5rem !important;
        padding: 3px;
    }

    .custom-caret-agreement {
        background: #FFF url(http:/images/agreement-icon.png) right 0.75rem center no-repeat;
    }

    .custom-font-cqc {
        font-family: 'cqc script';
    }

    .custom-font-govt {
        font-family: 'GOVT TEXT';
    }

    .custom-font-roman {
        font-family: 'Modifed Roman';
    }

    .custom-font-runstone {
        font-family: 'Modifed Roman';
    }

    .custom-font-runstone {
        font-family: 'Runstone';
    }

    .custom-font-connected {
        font-family: 'Connected Script';
    }

    .custom-font-helvetica {
        font-family: 'Helvetica';
    }

    .custom-font-opti {
        font-family: 'Opti SB';
    }

    .custom-font-vermarco {
        font-family: 'Vermarco';
    }

    .custom-font-gothic {
        font-family: 'Common Gothic';
    }

    .my-checkbox input[type='checkbox'] {
        width: 11px !important;
        height: 11px !important;
        margin: 5px;
        -webkit-appearance: none;
        -moz-appearance: none;
        -o-appearance: none;
        appearance: none;
        outline: 1.5px solid black;
        box-shadow: none;
        font-size: 2em;
    }

    @font-face {
        font-family: "Bitstream Vera Serif Bold";
        src: url("https://mdn.mozillademos.org/files/2468/VeraSeBd.ttf");
    }
</style>
