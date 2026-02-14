<template>
    <div :class="hideInModal?' custom-modal-margin':''">
        <div v-if="!hideInModal">
            <template v-if="!isCurrentURL">
                <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Monument</h5>
            </template>
            <template v-else-if="isCurrentURL">
                <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Price Estimator</h5>
            </template>
            <div class="bg-toolbar my-2 p-1">
                <Toolbar :id="formFields.id" :saveDisabled="saveDisabled" :quote_id="formFields.quote_id"></Toolbar>
            </div>
        </div>
        <div class="col-md-12 custom-margin pr-1 mt-2">
            <form class="div-shadow bg-white rounded">
                <template v-if="isLoading">
                    <div class="text-center text-info my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>
                <template v-else>
                    <div class="general-information-row-1">
                        <div>
                            <h6 class="pt-3 custom-form-heading">General Information</h6>
                        </div>
                        <template v-if="!isCurrentURL">
                            <div class="pt-2">
                                <button :disabled="qtySaleHistory" class="btn-info mx-4 mt-1 custom-infobtn-toolbar custom-infobtn-text" type="button"
                                        v-b-modal.product-sale-history v-if="id ? isUpdatePermitted : isCreatePermitted">
                                    {{'Sale History' }}<span class="spinner-grow spinner-grow-sm ml-1" v-if="qtySaleHistory"></span>
                                </button>
                            </div>
                        </template>
                    </div>
                    <div class="general-information-row-1 ml-n2">
                        <template v-if="!isCurrentURL">
                            <div>
                                <label>Product #</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-lg my-auto" name="product_number" size="sm"
                                              type="text" v-model="formFields.product_number"></b-form-input>
                            </div>
                        </template>
                        <template v-else-if="isCurrentURL">
                            <div>
                                <label>Quote #</label>
                                <b-form-input class="my-auto" disabled name="quote_id" size="sm"
                                              type="text" v-model="formFields.quote_id"></b-form-input>
                            </div>
                        </template>
                        <div class="mx-4 flex-grow-1">
                            <label>Item Name</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="w-100 my-auto" name="item_name" size="sm"
                                          type="text" v-model="formFields.item_name"></b-form-input>
                        </div>
                        <div class="mx-4 flex-grow-1">
                            <label>Item Description</label>
                            <b-form-textarea
                                :disabled="hideInModal || hideinAuth"
                                class="w-100"
                                name="description"
                                no-resize
                                size="sm"
                                v-model="formFields.description"
                            ></b-form-textarea>
                        </div>
                    </div>
                    <template v-if="!isCurrentURL">
                        <div class="general-information-row-2 ml-n2">
                            <div>
                                <label>Product Cost</label>
                                <vue-numeric :disabled="hideInModal || hideinAuth" class="input-sm-6 mt-1 form-control form-control-sm" currency="$" separator=","
                                             v-bind:minus="false" v-bind:precision="2" v-model="formFields.product_cost" v-remove-zero></vue-numeric>
                            </div>
                            <div>
                                <label title="Total Added - Total Sold" v-b-tooltip.hover>Total on Hand</label>
                                <label class="d-none">{{formFields.total_on_hand = formFields.total_added - formFields.total_sold }}</label>
                                <b-form-input class="input-sm" disabled min="0" name="total_on_hand"
                                              size="sm" type="number" v-model="formFields.total_on_hand"></b-form-input>
                            </div>
                            <div>
                                <label>Total Sold</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" disabled min="0" name="total_sold" size="sm"
                                              type="number" v-model="formFields.total_sold"></b-form-input>
                            </div>
                            <div>
                                <label>Quantity Stocked</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" min="0" name="quantity_stocked"
                                              size="sm" type="number" v-model="formFields.quantity_stocked"></b-form-input>
                            </div>
                            <div>
                                <label>Quantity Backordered</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" min="0" name="quantity_backordered"
                                              size="sm" type="number" v-model="formFields.quantity_backordered"></b-form-input>
                            </div>
                            <div>
                                <label>Total Added</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" disabled min="0" name="total_added"
                                              size="sm" type="number" v-model="formFields.total_added"></b-form-input>
                            </div>
                            <div v-if="!hideInModal">
                                <button :disabled="qtySaleHistory" class="btn-info mx-4 mt-1 custom-infobtn-toolbar custom-infobtn-text" type="button"
                                        v-b-modal.posted-product-inventory v-if="id ? isUpdatePermitted : isCreatePermitted">
                                    {{'Add Quantity' }}<span class="spinner-grow spinner-grow-sm ml-1" v-if="qtySaleHistory"></span>
                                </button>
                            </div>
                        </div>
                    </template>
                    <div class="general-information-row-2 ml-n2">
                        <div v-if="isCurrentURL">
                            <label>Reference ID</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-lg my-auto" name="reference_id" size="sm"
                                          type="text" v-model="formFields.reference_id"></b-form-input>
                        </div>
                        <div v-if="isCurrentURL">
                            <label>Product Cost</label>
                            <vue-numeric :disabled="hideInModal || hideinAuth" class="input-sm-6 mt-1 form-control form-control-sm" currency="$" separator=","
                                         v-bind:minus="false" v-bind:precision="2" v-model="formFields.product_cost" v-remove-zero></vue-numeric>
                        </div>
                        <div>
                            <label>Weight</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" @focus="removeZeroForWeight(formFields.total_weight)" @focusout="blurEventForWeight(formFields.total_weight)" class="input-sm ml-1"
                                          min="0" name="total_weight" size="sm" type="number" v-model="formFields.total_weight" v-remove-zero></b-form-input>
                        </div>
                        <div>
                            <label>Tax info.</label>
                            <b-form-select :disabled="hideInModal || hideinAuth"
                                           :options="taxInfoList"
                                           class="custom-caret-form input-lg"
                                           size="sm"
                                           v-model="formFields.tax_info">
                            </b-form-select>
                        </div>
                        <div>
                            <label>Stocking</label>
                            <b-form-select :disabled="hideInModal || hideinAuth"
                                           :options="stockList"
                                           class="custom-caret-form input-lg"
                                           size="sm"
                                           v-model="formFields.stock_info">
                            </b-form-select>
                        </div>
                        <div>
                            <label>Supplier</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-lg my-auto" name="product_number" size="sm"
                                          type="text" v-model="formFields.supplier"></b-form-input>
                        </div>
                    </div>
                    <div class="general-information-row-2 ml-n2 mb-4" v-if="!isCurrentURL">
                        <div>
                            <label>Misc. Notes</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-lg-width my-auto" name="gi_misc_note" size="sm"
                                          type="text" v-model="formFields.gi_misc_note"></b-form-input>
                        </div>
                        <div>
                            <label>Indep</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm m-0" name="gi_misc_note_indep"
                                          size="sm" type="text" v-model="formFields.indep"
                            ></b-form-input>
                            <label>Buckner</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm m-0" name="gi_misc_note_clinton"
                                          size="sm" type="text" v-model="formFields.clinton"
                            ></b-form-input>
                            <label>Ex-Spring</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm m-0" name="gi_misc_note_ex_spring"
                                          size="sm" type="text" v-model="formFields.ex_spring"
                            ></b-form-input>
                            <label>PH</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm m-0" name="gi_misc_note_ph"
                                          size="sm" type="text" v-model="formFields.ph"
                            ></b-form-input>
                            <label>BS</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm m-0" name="gi_misc_note_bs"
                                          size="sm" type="text" v-model="formFields.bs"
                            ></b-form-input>
                        </div>
                    </div>
                    <hr class="border my-2">
                    <div class="my-4"></div>
                    <h6 class="my-1 heading-of-row custom-form-heading">Specification</h6>
                    <div class="specification-row-1 ml-n2">
                        <div>
                            <label>Length (in)</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" @focus="removeZero(specification.length, specification, 'length')" @focusout="blurEventHandler(specification.length, specification, 'length')"
                                          class="input-sm specification-length-in-input" min="0" name="length"
                                          size="sm"
                                          type="number" v-model="specification.length"></b-form-input>
                        </div>
                        <div>
                            <label>Width (in)</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" @focus="removeZero(specification.width, specification, 'width')" @focusout="blurEventHandler(specification.width, specification, 'width')" class="input-sm ml-2" min="0"
                                          name="width" size="sm"
                                          type="number" v-model="specification.width"></b-form-input>
                        </div>
                        <div>
                            <label>Height (in)</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" @focus="removeZero(specification.height, specification, 'height')" @focusout="blurEventHandler(specification.height, specification, 'height')" class="input-sm ml-n1" min="0"
                                          name="height" size="sm"
                                          type="number" v-model="specification.height"></b-form-input>
                        </div>
                        <div>
                            <label title="Square (In) * Width (In)" v-b-tooltip.hover>Cubic (in)</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-md ml-1" min="0" name="cubic" readonly
                                          size="sm" type="number" v-model="specificationCalculatedFields.cubicIn"></b-form-input>
                        </div>
                        <div>
                            <label>Select Engraving Sq.in</label>
                            <b-form-select :disabled="hideInModal || hideinAuth"
                                           :options="engravingTypeList"
                                           class="custom-caret-form"
                                           size="sm"
                                           v-model="specification.specification_type">
                                <template #first>
                                    <b-form-select-option :value="null" disabled>Select option</b-form-select-option>
                                </template>
                            </b-form-select>
                        </div>
                    </div>
                    <div class="specification-row-2 flex-wrap  ml-n2 mb-4">
                        <div>
                            <label title="Length/12" v-b-tooltip.hover>Length (ft)</label>&nbsp;
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" name="length_ft" readonly size="sm"
                                          type="text"
                                          v-model="specification.length_ft = specificationCalculatedFields.lengthFt"></b-form-input>
                        </div>
                        <div>
                            <label title="Width/12" v-b-tooltip.hover>Width (ft)</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm ml-2" name="width_ft" readonly size="sm"
                                          type="text"
                                          v-model="specification.width_ft = specificationCalculatedFields.widthFt"></b-form-input>
                        </div>
                        <div>
                            <label title="Height/12" v-b-tooltip.hover>Height (ft)</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" name="height_ft" readonly size="sm"
                                          type="text"
                                          v-model="specification.height_ft = specificationCalculatedFields.heightFt"></b-form-input>
                        </div>
                        <div>
                            <label title="(Square Feet * Width)/12" v-b-tooltip.hover>Cubic (ft)</label>&nbsp;
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-md" name="cubic_ft" readonly size="sm"
                                          type="text"
                                          v-model="specification.cubic_ft = specificationCalculatedFields.cubicFt"></b-form-input>
                        </div>
                        <div>

                            <label :title="engraveType.squreFt" v-b-tooltip.hover>Material Square (ft)</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-md" name="square_ft"
                                          readonly size="sm"
                                          type="text"
                                          v-model="specification.square_ft =   specificationSqureFtCalculated.squreFt"></b-form-input>
                        </div>
                        <div>
                            <label>Weight Cubic (ft)</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" @focus="removeZero(specification.weight_cubic_ft, specification, 'weight_cubic_ft')" @focusout="blurEventHandler(specification.weight_cubic_ft, specification, 'weight_cubic_ft')" class="input-sm"
                                          min="0" name="weight_cubic_ft"
                                          onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                          size="sm"
                                          type="number" v-model="specification.weight_cubic_ft"></b-form-input>
                        </div>
                        <div style="padding: 0.46rem 0.5rem;">
                            <label>Cost p/sq.ft</label>
                                <b-dropdown :disabled="hideInModal || hideinAuth" class="border rounded" no-caret size="sm" style="width: 185px;" toggle-class=""
                                            variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small class="overflow-hidden custom-small-width-" :title="`${costPSqureFt}`" v-b-tooltip.hover>{{costPSqureFt}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1">
                                        <b-form-input
                                            class="mt-1"
                                            placeholder="Search..."
                                            size="sm"
                                            v-model="searchCostPSqFt"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="costPSqureFts.length > 0">
                                            <template v-for="(obj, key) of costPSqureFts">
                                                <b-dropdown-group @click="handleDropdownChange">
                                                    <b-dropdown-item-button :key="key" @click="setCostFtDetail(obj)"
                                                                            class="w-100">
                                                        <label class="btn btn-sm m-0">{{obj.text}}</label>
                                                    </b-dropdown-item-button>
                                               </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>
                            <vue-numeric :disable="hideInModal || hideinAuth" :empty-value="0.00"
                                         class="inputinstallation ml-2 form-control form-control-sm" currency="$"
                                         id="inline-form-input-installation_price" separator="," style="width: 5.5rem;" v-bind:minus="false"
                                         v-bind:precision="2" v-model="specification.cost_per_square_ft" v-on:change="costPerSqureFeet" v-remove-zero></vue-numeric>
                        </div>
                        <div>
                            <label title="Square Feet * Cost Per Sq.ft" v-b-tooltip.hover>Sq.ft Cost</label>
                            <Price :classes="'input-md ml-1'" :disable="hideInModal || hideinAuth" :readonly="true"
                                   v-model="specification.square_ft_cost = specificationCalculatedFields.squareFtCost"></Price>
                        </div>
                        <div class="my-2">
                            <label title="Cubic Feet * Weight Cubic Feet" v-b-tooltip.hover>Weight (lb)</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm" name="weight_lb" readonly size="sm"
                                          type="text"
                                          v-model="specification.weight_lb = specificationCalculatedFields.weightLB"></b-form-input>
                        </div>
                    </div>
                    <hr class="border my-2">
                    <div class="my-4"></div>
                    <h6 class="heading-of-row my-1 custom-form-heading">Polish</h6>
                    <div class="polish-row ml-n2 mb-4">
                        <div>
                            <label>Polish</label>
                            <b-form-group class="m-0 my-auto custom-radio-and-checkbox">
                                <b-form-radio-group :disabled="hideInModal || hideinAuth" @change="toggleComponent($event,'polish')" name="polish"
                                                    v-model="toggleFields.polish">
                                    <b-form-radio size="sm" value="1"><span class="mt-2">Yes</span></b-form-radio>
                                    <b-form-radio size="sm" value="0">No</b-form-radio>
                                </b-form-radio-group>
                            </b-form-group>
                        </div>
                        <div v-show="parseInt(toggleComponentFields.polish)">
                            <div>
                                <label>Polish Linear Cost (ft)</label>
                                <vue-numeric :disable="hideInModal || hideinAuth" class="input-md mt-1 form-control form-control-sm" currency="$"
                                             separator="," v-bind:minus="false" v-bind:precision="2" v-model="polish.polish_linear_cost_per_feet" v-remove-zero></vue-numeric>
                            </div>
                            <div>
                                <label>Polish Type</label>
                                <b-form-group class="m-0 my-auto custom-radio-and-checkbox">
                                    <b-form-radio-group :disabled="hideInModal || hideinAuth" name="polish_type"
                                                        v-model="polish.polish_type">
                                        <b-form-radio name="polish_type_radio" value="p2">P2</b-form-radio>
                                        <b-form-radio name="polish_type_radio" value="p3">P3</b-form-radio>
                                        <b-form-radio name="polish_type_radio" value="p5">P5</b-form-radio>
                                        <b-form-radio name="polish_type_radio" value="2* Polish Margin">2* Polish Margin</b-form-radio>
                                    </b-form-radio-group>
                                </b-form-group>
                            </div>
                            <div>
                                <label id="price-of-polish-tooltip">Price of Polish</label>
                                <b-tooltip target="price-of-polish-tooltip" triggers="hover">
                                    P2 : Polish price,<br>
                                    P3 : Length (ft) * Polish price,<br>
                                    P5 : Length (ft) + Height (ft) * Polish price
                                </b-tooltip>
                                <Price :classes="'input-md'" :disable="hideInModal || hideinAuth" :readonly="true"
                                       v-model="formFields.polish.price= polishCalculatedFields.price"></Price>
                            </div>
                        </div>
                    </div>
                    <hr class="border my-2">
                    <div class="my-4"></div>
                    <h6 class="heading-of-row my-1 custom-form-heading">Engrave</h6>
                    <div class="engrave-row-1 ml-n2">
                        <div class="flex-wrap">
                            <label>Engrave </label>
                            <b-form-group class="m-0 my-auto custom-radio-and-checkbox">
                                <b-form-radio-group :disabled="hideInModal || hideinAuth" @change="toggleComponent($event,'engrave')" name="engrave"
                                                    v-model="toggleFields.engrave">
                                    <b-form-radio name="engrave_radio" size="sm" value="1">Yes</b-form-radio>
                                    <b-form-radio name="engrave_radio" size="sm" value="0">No</b-form-radio>
                                </b-form-radio-group>
                            </b-form-group>
                            <template v-if="parseInt(toggleComponentFields.engrave)">
                                <div>
                                    <label :title="engraveType.type" v-b-tooltip.hover>Sq.in Engraving</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" class="input-md" name="square_in_engraving"
                                                  readonly size="sm"
                                                  type="text"
                                                  v-model="engrave.engrave_square_inches = engraveCalculatedFields.size"></b-form-input>
                                </div>
                                <div>
                                    <label>Engrave Front Sq.</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" @focus="removeZero(engrave.engrave_front_square, engrave, 'engrave_front_square')" @focusout="blurEventHandler(engrave.engrave_front_square, engrave, 'engrave_front_square')" class="input-md"
                                                  min="0" name="engrave_front_square"
                                                  size="sm"
                                                  type="number" v-model="engrave.engrave_front_square"></b-form-input>
                                </div>
                                <div>
                                    <label title="Square Feet * Engrave Front Square" v-b-tooltip.hover>Engrave Front Total
                                        Price</label>
                                    <Price :classes="'input-md'" :disable="hideInModal || hideinAuth" :readonly="true"
                                           v-model="engrave.engrave_front_total_price = engraveCalculatedFields.frontTotalPrice"></Price>
                                </div>
                                <div>
                                    <label>Engrave Back Sq.</label>
                                    <b-form-input :disabled="hideInModal || hideinAuth" @focus="removeZero(engrave.engrave_back_square, engrave, 'engrave_back_square')" @focusout="blurEventHandler(engrave.engrave_back_square, engrave, 'engrave_back_square')" class="input-md"
                                                  min="0" name="engrave_back_square"
                                                  size="sm"
                                                  type="number" v-model="engrave.engrave_back_square"></b-form-input>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="engrave-row-2 ml-n2" v-show="parseInt(toggleComponentFields.engrave)">
                        <div>
                            <label title="Square Feet * Engrave Back Square" v-b-tooltip.hover>Engrave Back Total
                                Price</label>
                            <Price :classes="'input-md'" :disable="hideInModal || hideinAuth" :readonly="true"
                                   v-model="engrave.engrave_back_total_price = engraveCalculatedFields.backTotalPrice"></Price>
                        </div>
                        <div>
                            <label>Premium Engrave Cost</label>
                            <vue-numeric :disabled="hideInModal || hideinAuth" class="input-md mt-1 prodcutPrice form-control form-control-sm" currency="$"
                                         separator="," v-bind:minus="false" v-bind:precision="2" v-model="engrave.engrave_premium_cost" v-remove-zero></vue-numeric>
                        </div>
                    </div>
                    <hr class="border my-2">
                    <div class="my-4"></div>
                    <h6 class="heading-of-row my-1 custom-form-heading">Installation Selling Price</h6>
                    <div class="installation-row ml-n2 mb-4">
                        <div>
                            <label>Installation</label>
                            <b-form-group class="m-0 my-auto custom-radio-and-checkbox">
                                <b-form-radio-group :disabled="hideInModal || hideinAuth" @change="toggleComponent($event,'installation')"
                                                    name="installation"
                                                    v-model="toggleFields.installation">
                                    <b-form-radio name="installation_radio" size="sm" value="1">Yes</b-form-radio>
                                    <b-form-radio name="installation_radio" size="sm" value="0">No</b-form-radio>
                                </b-form-radio-group>
                            </b-form-group>
                        </div>
                        <div v-show="parseInt(toggleComponentFields.installation)">
                            <div>
                                <label>Product Min. Install. Price</label>
                                <vue-numeric :disable="hideInModal || hideinAuth" class="input-md mt-1 form-control form-control-sm" currency="$"
                                             separator="," v-bind:minus="false" v-bind:precision="2" v-model="installation.product_min_install_price" v-remove-zero></vue-numeric>
                            </div>
                            <div>
                                <label>Install. Price</label>
                                <vue-numeric :disable="hideInModal || hideinAuth" class="input-md mt-1 form-control form-control-sm" currency="$"
                                             separator="," v-bind:minus="false" v-bind:precision="2" v-model="installation.installation_price" v-remove-zero></vue-numeric>
                            </div>
                            <div>
                                <label title="Installation Price * Square Inch" v-b-tooltip.hover>Install. Amount</label>
                                <Price :classes="'input-md'" :disable="hideInModal || hideinAuth" :readonly="true"
                                       v-model="installation.installation_amount = installationCalculatedFields.installation_amount"></Price>
                            </div>
                            <div>
                                <label title="Length * Width" v-b-tooltip.hover>Square Inch Install.</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" class="input-md" name="square_inch_installation" readonly size="sm" type="text" v-model="installation.square_inch_installation = installationCalculatedFields.square_inch_installation"></b-form-input>
                            </div>
                        </div>
                    </div>
                    <hr class="border my-2">
                    <div class="my-4"></div>
                    <h6 class="heading-of-row my-1 custom-form-heading">Installation Cost</h6>
                    <hr class="border my-2">
                    <div class="d-inline-block"></div>
                    <h6 class="heading-of-row my-1 custom-form-heading">Cost</h6>
                    <div class="installation-cost-row ml-n2 mb-4">
                        <div>
                            <label>Special Shape Cost</label>
                            <!--<vue-numeric :disabled="hideInModal || hideinAuth" class="input-md mt-1 form-control form-control-sm" currency="$"
                                         separator="," v-bind:minus="false" v-bind:precision="2" v-model="formFields.special_shape_cost" v-remove-zero></vue-numeric>-->
                            <vue-numeric :disable="hideInModal || hideinAuth" :empty-value="0.00"
                                         class="input-md inputinstallation form-control form-control-sm"
                                         currency="$" id="inline-form-input-installation_price" separator="," v-bind:minus="false"
                                         v-bind:precision="2" v-model="formFields.special_shape_cost" v-on:change="specialShapeCost" v-remove-zero></vue-numeric>
                        </div>
                        <div>
                            <hr class="border my-2">
                            <label id="total-cost-tooltip">Cost</label>
                            <b-tooltip target="total-cost-tooltip" triggers="hover">
                                Sq.ft. Cost + Engv. front total price + Engv. back total price + Prem. Engv. price + Price
                                Of Polish + Special Shape Cost
                            </b-tooltip>
                            <Price :classes="'input-md'" :disable="hideInModal || hideinAuth" :readonly="true"
                                   v-model="formFields.cost = costCalculationFields.cost"></Price>
                        </div>
                        <div>
                            <label title=" Cost + Freight Cost + Freight Amount + Tariff Amount" v-b-tooltip.hover>Total
                                Cost With Freight</label>
                            <Price :classes="'input-md'" :disable="hideInModal || hideinAuth" :readonly="true"
                                   v-model="formFields.total_cost_with_freight = costCalculationFields.total_cost_with_freight"></Price>
                        </div>
                    </div>
                    <hr class="border my-2">
                    <div class="my-4"></div>
                    <h6 class="heading-of-row my-1 custom-form-heading">Freight Cost</h6>
                    <div class="freight-row flex-wrap ml-n2 mb-4">
                        <div>
                            <label>Freight Cost</label>
                            <b-form-group class="m-0 my-auto custom-radio-and-checkbox">
                                <b-form-radio-group :disabled="hideInModal || hideinAuth" @change="toggleComponent($event,'freight')"
                                                    name="freight_cost"
                                                    v-model="toggleFields.freight">
                                    <b-form-radio name="freight_radio" size="sm" value="1">Yes</b-form-radio>
                                    <b-form-radio name="freight_radio" size="sm" value="0">No</b-form-radio>
                                </b-form-radio-group>
                            </b-form-group>
                            <div>
                                <label>Price per 100 LB</label>
                                <vue-numeric :disabled="hideInModal || hideinAuth" class="input-md mt-1 form-control form-control-sm" currency="$"
                                             separator="," v-bind:minus="false" v-bind:precision="2" v-model="freight.freight_cost_per_100_lb" v-remove-zero></vue-numeric>
                            </div>
                        </div>
                        <div class="my-2" v-show="parseInt(toggleComponentFields.freight)">
                            <div>
                                <label title="(Total Weight / 100) * Cost per lb" v-b-tooltip.hover>Freight Cost</label>
                                <Price :classes="'input-md'" :disable="hideInModal || hideinAuth" :readonly="true"
                                       v-model="freight.freight_cost = freightCalculatedFields.freightCost"></Price>
                            </div>
                            <div>
                                <label>Where it comes from</label>
                                <b-dropdown :disabled="hideInModal || hideinAuth" class="border rounded input-lg dropdown-width" no-caret size="sm"
                                            toggle-class="" variant="none">
                                    <template #button-content>
                                        <div class="d-flex product-color">
                                            <small>{{country}}</small>
                                            <small class="w-25 ml-auto custom-caret"></small>
                                        </div>
                                    </template>
                                    <b-dropdown-group class="overflow-auto scroll px-1 ">
                                        <b-form-input
                                            class="mt-1"
                                            placeholder="Search..."
                                            size="sm"
                                            v-model="searchCountry"
                                        ></b-form-input>
                                        <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                        <template v-if="countries.length > 0">
                                            <template v-for="(obj, key) of countries">
                                                <b-dropdown-group @click="handleDropdownChange">
                                                    <b-dropdown-item-button :key="key" @click="setCountry(obj)"
                                                                            class="w-100">
                                                        <label class="btn btn-sm m-0">{{obj.text}}
                                                        </label>
                                                    </b-dropdown-item-button>
                                                    <b-icon @click="deletDropDown(obj.value, 'country')" aria-hidden="true" class="mt-n4 float-right" icon="trash-fill" variant="danger"></b-icon>
                                                </b-dropdown-group>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                            <button @click="saveDetail" class="d-flex m-auto px-3 btn-sm btn-info custom-add-btn"
                                                    type="button">Add Country
                                            </button>
                                        </template>
                                    </b-dropdown-group>
                                </b-dropdown>
                            </div>
                            <div>
                                <label>Where it comes from Amt</label>
                                <vue-numeric :disabled="hideInModal || hideinAuth" class="input-md mt-1 form-control form-control-sm" currency="$"
                                             separator="," v-bind:minus="false" v-bind:precision="2" v-model="freight.freight_amount" v-remove-zero></vue-numeric>
                            </div>
                            <div>
                                <label>Tariff Percent</label>
                                <b-form-input :disabled="hideInModal || hideinAuth" @focus="removeZero(freight.tariff_percent, freight, 'tariff_percent')" @focusout="blurEventHandler(freight.tariff_percent, freight, 'tariff_percent')" class="input-sm"
                                              min="0" name="tariff_percent"
                                              size="sm"
                                              type="number" v-model="freight.tariff_percent"></b-form-input>
                            </div>
                            <div>
                                <label title="Cost * (Tariff Percent / 100)" v-b-tooltip.hover>Tariff Amt</label>
                                <Price :classes="'input-md'" :disable="hideInModal || hideinAuth" :readonly="true"
                                       v-model="freight.tariff_amount = freightCalculatedFields.tariffAmount"></Price>
                            </div>
                        </div>
                    </div>
                    <hr class="border my-2">
                    <div class="my-4"></div>
                    <h6 class="heading-of-row my-1 custom-form-heading">Selling Price</h6>
                    <div class="selling-price-row ml-n2">
                        <div>
                            <label>Selling Formula</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-md" min="0" name="selling-formula"
                                          size="sm" type="number"
                                          v-model="formFields.selling_formula"></b-form-input>
                        </div>
                        <div>
                            <label title="Cost with Freight * Selling Formula" v-b-tooltip.hover>Selling Price</label>
                            <Price :classes="'input-md'" :disable="hideInModal || hideinAuth" :readonly="true"
                                   v-model="formFields.selling_price = costCalculationFields.selling_price"></Price>
                        </div>
                        <div>
                            <label>Override Selling Price</label>
                            <vue-numeric :disabled="hideInModal || hideinAuth" class="input-md mt-1 form-control form-control-sm " currency="$"
                                         separator="," v-bind:minus="false" v-bind:precision="2" v-model="formFields.override_selling_price" v-remove-zero></vue-numeric>
                        </div>
                        <div>
                            <label title="Override Selling Price + Installation Selling Price" v-b-tooltip.hover>Selling
                                Price with install.</label>
                            <Price :classes="'input-md'" :disable="hideInModal || hideinAuth" :readonly="true"
                                   v-model="formFields.selling_price_with_installation = costCalculationFields.selling_price_with_installation"></Price>
                        </div>
                    </div>
                    <div class="selling-price-row ml-n2 mb-4" v-if="!isCurrentURL">
                        <div>
                            <label>Misc. Notes</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="ml-3 input-lg-width" name="misc_note"
                                          size="sm" type="text" v-model="formFields.misc_note"
                            ></b-form-input>
                        </div>
                        <div>
                            <label>A</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm m-0" name="misc_note_a"
                                          size="sm" type="text" v-model="formFields.misc_note_a"
                            ></b-form-input>

                            <label>B</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm m-0" name="misc_note_b"
                                          size="sm" type="text" v-model="formFields.misc_note_b"
                            ></b-form-input>

                            <label>C</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm m-0" name="misc_note_c"
                                          size="sm" type="text" v-model="formFields.misc_note_c"
                            ></b-form-input>

                            <label>D</label>
                            <b-form-input :disabled="hideInModal || hideinAuth" class="input-sm m-0" name="misc_note_d"
                                          size="sm" type="text" v-model="formFields.misc_note_d"
                            ></b-form-input>
                        </div>
                    </div>
                    <hr class="border my-2">
                    <div class="mt-4"></div>
                    <h6 class="heading-of-row my-1 custom-form-heading">Documents and Upload Details</h6>
                    <div class="documents-row ml-n2">
                        <div v-if="!hideInModal || hideinAuth">
                            <label class="my-2">Image:</label>
                            <div class="flex-column">
                                <b-form-file
                                    :disabled="hideInModal || hideinAuth"
                                    accept="image/*"
                                    browse-text="Choose File"
                                    class="border rounded custom-file-upload mt-0"
                                    drop-placeholder="Drop file here..."
                                    multiple
                                    placeholder="No Chosen File"
                                    plain
                                    ref="inputFile"
                                    v-model="uploadImages.files"
                                    v-on:change="previewImage"
                                ></b-form-file>
                                <label></label>
                            </div>
                        </div>
                        <div class="ml-5" v-if="!hideInModal || hideinAuth">
                            <label class="my-2">Files: </label>
                            <div class="flex-column">
                                <b-form-file
                                    :disabled="hideInModal || hideinAuth"
                                    browse-text="Choose File"
                                    class="border rounded custom-file-upload mt-0"
                                    drop-placeholder="Drop file here..."
                                    id="monument-files"
                                    multiple
                                    placeholder="No Chosen File"
                                    plain
                                    ref="inputFile1"
                                    v-model="uploadDocuments.files"
                                    v-on:change="checkFile"
                                ></b-form-file>
                                <label class="mt-0">You can also upload multiple files.<br> <span class="small text-danger">Docxs *, excel *, ai *, svg *, fs *, eps * and PDFs formats are allowed</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="documents-row ml-n2">
                        <div class="col-md-3 ml-n2">
                            <div class="flex-wrap m-1">
                                <template v-if="this.formFields.images">
                                    <template v-for="(file,index) of this.formFields.images">
                                        <div class="flex-column border mx-1 mb-2 py-1 justify-content-center file-container">
                                            <template v-if="checkFileType(file.file)">
                                                <i :title="`${file.name}`" @click="openPreviewNewPage(storagePath+file.file)"
                                                   class="fa fa-file fa-2x m-auto" style="cursor: pointer;" v-b-tooltip.hover></i>
                                                <label @click="openPreviewNewPage(storagePath+file.file)" class="" style="cursor: pointer;">
                                                    {{file.file.length > 10 ? file.file.substr(0,10)+'...' : file.path}}</label>
                                            </template>
                                            <template v-else>
                                                <img :src="storagePath + file.file" :title="`${file.name}`" @click="openPreviewNewPage(storagePath+file.file)"
                                                     alt="product-file" class="btn img-thumbnail product-image " height="51px"
                                                     v-b-tooltip.hover width="89px">
                                            </template>
                                            <div class="btn m-auto" v-if="!hideInModal || hideinAuth">
                                                <a :download="file.name" :href="`${storagePath+file.file}`" style="margin-top: -2px !important;color: #000 !important;">
                                                    <i aria-hidden="true" class="fa fa-download mx-2"></i></a>
                                                <i @click="deleteImage(file.id,index)" aria-hidden="true" class="fa fa-trash-o mx-2"
                                                   style='color: red'></i>
                                            </div>
                                        </div>
                                    </template>
                                </template>
                            </div>
                        </div>
                        <div class="col-md-3 flex-wrap m-1">
                            <template v-if="this.formFields.files">
                                <template v-for="(file,index) of this.formFields.files">
                                    <div class="flex-column border mx-1 mb-2 py-1 justify-content-center file-container">
                                        <i :title="`${file.name}`" @click="openPreviewNewPage(storagePath+file.file)" class="fa fa-file fa-2x m-auto"
                                           style="cursor: pointer;" v-b-tooltip.hover></i>
                                        <label :title="`${file.name}`" @click="openPreviewNewPage(storagePath+file.file)"
                                               style="cursor: pointer;" v-b-tooltip.hover>{{file.file.length > 10 ? file.file.substr(0,10)+'...' :
                                            file.path}}</label>
                                        <div class="btn m-auto" v-if="!hideInModal || hideinAuth">
                                            <a :download="file.name" :href="`${storagePath+file.file}`" style="margin-top: -2px !important;color: #000 !important;">
                                                <i aria-hidden="true" class="fa fa-download mx-2"></i></a>
                                            <i @click="deleteFile(file.id,index)" aria-hidden="true" class="fa fa-trash-o mx-2"
                                               style='color: red'></i>
                                        </div>
                                    </div>
                                </template>
                            </template>
                        </div>
                    </div>
                    <hr class="border my-2">
                    <div class="my-4"></div>
                    <h6 class="heading-of-row my-1 custom-form-heading">Additional Details</h6>
                    <div class="pb-3 additional-details-row ml-n3">
                        <div class="flex-grow-1">
                            <label>Color</label>
                            <!--   v-on:keyup="handleTabPress"  @click.native.capture.tab="handleTabPress"  @keyup.tab="handleTabPress"-->
                            <b-dropdown :disabled="hideInModal || hideinAuth" class="border rounded w-50" no-caret size="sm" toggle-class=""
                                        variant="none">
                                <template #button-content>
                                    <div class="d-flex product-color">
                                        <small>{{color}}</small>
                                        <small class="w-25 ml-auto custom-caret"></small>
                                    </div>
                                </template>
                                <b-dropdown-group class="overflow-auto scroll px-1">
                                    <b-form-input
                                        class="mt-1"
                                        placeholder="Search..."
                                        size="sm"
                                        v-model="searchColor"
                                    ></b-form-input>
                                    <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                    <template v-if="colors.length > 0">
                                        <template v-for="(obj, key) of colors">
                                            <b-dropdown-group @click="handleDropdownChange">
                                                <b-dropdown-item-button :key="key" @click="setDetail(obj,'color')"
                                                                        class="w-100">
                                                    <label class="btn btn-sm m-0">{{obj.text}}</label>
                                                </b-dropdown-item-button>
                                                <b-icon @click="deletDropDown(obj.value, 'monumentColor')" aria-hidden="true" class="mt-n4 float-right" icon="trash-fill" variant="danger"></b-icon>
                                            </b-dropdown-group>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                        <button @click="saveDetail('color')" class="d-flex m-auto px-3 btn-sm btn-info custom-add-btn"
                                                type="button">Add Color
                                        </button>
                                    </template>
                                </b-dropdown-group>
                            </b-dropdown>
                        </div>
                        <div class="flex-grow-1">
                            <label>Type</label>
                            <b-dropdown :disabled="hideInModal || hideinAuth" class="border rounded w-50" no-caret size="sm" toggle-class=""
                                        variant="none">
                                <template #button-content>
                                    <div class="d-flex product-color">
                                        <small>{{type}}</small>
                                        <small class="w-25 ml-auto custom-caret"></small>
                                    </div>
                                </template>
                                <b-dropdown-group class="overflow-auto scroll px-1">
                                    <b-form-input
                                        class="mt-1"
                                        placeholder="Search..."
                                        size="sm"
                                        v-model="searchType"
                                    ></b-form-input>
                                    <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                    <template v-if="types.length > 0">
                                        <template v-for="(obj, key) of types">
                                            <b-dropdown-group @click="handleDropdownChange">
                                                <b-dropdown-item-button :key="key" @click="setDetail(obj,'type')"
                                                                        class="w-100">
                                                    <label class="btn btn-sm m-0">{{obj.text}}</label>
                                                </b-dropdown-item-button>
                                                <b-icon @click="deletDropDown(obj.value, 'monumentType')" aria-hidden="true" class="mt-n4 float-right" icon="trash-fill" variant="danger"></b-icon>
                                            </b-dropdown-group>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                        <button @click="saveDetail('type')" class="d-flex m-auto px-3 btn-sm btn-info custom-add-btn"
                                                type="button">Add Type
                                        </button>
                                    </template>
                                </b-dropdown-group>
                            </b-dropdown>
                        </div>
                        <div class="flex-grow-1">
                            <label>Shape</label>
                            <b-dropdown :disabled="hideInModal || hideinAuth" class="border rounded w-50" no-caret size="sm" toggle-class=""
                                        variant="none">
                                <template #button-content>
                                    <div class="d-flex product-color">
                                        <small>{{shape}}</small>
                                        <small class="w-25 ml-auto custom-caret"></small>
                                    </div>
                                </template>
                                <b-dropdown-group class="overflow-auto scroll px-1">
                                    <b-form-input
                                        class="mt-1"
                                        placeholder="Search..."
                                        size="sm"
                                        v-model="searchShape"
                                    ></b-form-input>
                                    <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                    <template v-if="shapes.length > 0">
                                        <template v-for="(obj, key) of shapes">
                                            <b-dropdown-group @click="handleDropdownChange">
                                                <b-dropdown-item-button :key="key" @click="setDetail(obj,'shape')"
                                                                        class="w-100">
                                                    <label class="btn btn-sm m-0">{{obj.text}}</label>
                                                </b-dropdown-item-button>
                                                <b-icon @click="deletDropDown(obj.value, 'monumentShape')" aria-hidden="true" class="mt-n4 float-right" icon="trash-fill" variant="danger"></b-icon>
                                            </b-dropdown-group>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                        <button @click="saveDetail('shape')" class="d-flex m-auto px-3 btn-sm btn-info custom-add-btn"
                                                type="button">Add Shape
                                        </button>
                                    </template>
                                </b-dropdown-group>
                            </b-dropdown>
                        </div>
                        <div class="flex-grow-1">
                            <label>Side</label>
                            <b-dropdown :disabled="hideInModal || hideinAuth" class="border rounded w-50" no-caret size="sm" toggle-class=""
                                        variant="none">
                                <template #button-content>
                                    <div class="d-flex product-color">
                                        <small>{{side}}</small>
                                        <small class="w-25 ml-auto custom-caret"></small>
                                    </div>
                                </template>
                                <b-dropdown-group class="overflow-auto scroll px-1">
                                    <b-form-input
                                        class="mt-1"
                                        placeholder="Search..."
                                        size="sm"
                                        v-model="searchSide"
                                    ></b-form-input>
                                    <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                    <template v-if="sides.length > 0">
                                        <template v-for="(obj, key) of sides">
                                            <b-dropdown-group @click="handleDropdownChange">
                                                <b-dropdown-item-button :key="key" @click="setDetail(obj,'side')"
                                                                        class="w-100">
                                                    <label class="btn btn-sm m-0">{{obj.text}}</label>
                                                </b-dropdown-item-button>
                                                <b-icon @click="deletDropDown(obj.value, 'monumentSide')" aria-hidden="true" class="mt-n4 float-right" icon="trash-fill" variant="danger"></b-icon>
                                            </b-dropdown-group>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                        <button @click="saveDetail('side')" class="d-flex m-auto px-3 btn-sm btn-info custom-add-btn"
                                                type="button">Add Side
                                        </button>
                                    </template>
                                </b-dropdown-group>
                            </b-dropdown>
                        </div>
                        <div class="flex-grow-1">
                            <label>Polish</label>
                            <b-dropdown :disabled="hideInModal || hideinAuth" class="border rounded w-50" no-caret size="sm" toggle-class=""
                                        variant="none">
                                <template #button-content>
                                    <div class="d-flex product-color">
                                        <small>{{monumentPolish}}</small>
                                        <small class="w-25 ml-auto custom-caret"></small>
                                    </div>
                                </template>
                                <b-dropdown-group class="overflow-auto scroll px-1">
                                    <b-form-input
                                        class="mt-1"
                                        placeholder="Search..."
                                        size="sm"
                                        v-model="searchPolish"
                                    ></b-form-input>
                                    <b-dropdown-divider class="my-1"></b-dropdown-divider>
                                    <template v-if="monumentPolishes.length > 0">
                                        <template v-for="(obj, key) of monumentPolishes">
                                            <b-dropdown-group @click="handleDropdownChange">
                                                <b-dropdown-item-button :key="key" @click="setDetail(obj,'monument_polish')"
                                                                        class="w-100">
                                                    <label class="btn btn-sm m-0">{{obj.text}}</label>
                                                </b-dropdown-item-button>
                                                <b-icon @click="deletDropDown(obj.value, 'monumentPolish')" aria-hidden="true" class="mt-n4 float-right" icon="trash-fill" variant="danger"></b-icon>
                                            </b-dropdown-group>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <b-dropdown-text class="text-center small">No record found</b-dropdown-text>
                                        <button @click="saveDetail('monument_polish')" class="d-flex m-auto px-3 btn-sm btn-info custom-add-btn"
                                                type="button">Add Polish
                                        </button>
                                    </template>
                                </b-dropdown-group>
                            </b-dropdown>
                        </div>
                    </div>
                    <div class="documents-row ml-n2 mb-4" v-if="!hideInModal">
                        <div class="mb-3">
                            <button :disabled="saveDisabled" @click="storeMonument" class="btn-info mx-1 custom-infobtn-toolbar custom-infobtn-text" type="button" v-if="id ? isUpdatePermitted : isCreatePermitted">
                                {{ id ? 'Update' : 'Save' }}<span class="spinner-grow spinner-grow-sm ml-1" v-if="saveDisabled"></span>
                            </button>
                        </div>
                    </div>
                </template>
            </form>
        </div>
        <b-modal :title="modalData.title"
                 id="image-modal"
                 ok-only
                 ok-title="Cancel"
                 ok-variant="secondary"
                 scrollable
                 size="lg">
            <div class="d-flex">
                <img :src="modalData.src" class="w-100">
            </div>
        </b-modal>
        <b-modal hide-footer hide-header hide-header-close id="posted-product-inventory">
            <InventoryHistory :formRecord="monumentInventory" :id="formFields.id" :inventoryName="'monument_inventory'" :module="this.axiosParams.module"></InventoryHistory>
        </b-modal>
        <SaleHistory :invoice="'monument_invoice'" :module="this.axiosParams.module" :recordID="formFields.id"></SaleHistory>
    </div>
</template>

<script>
    import Vue from 'vue';
    import InventoryHistory from "../service/InventoryHistory";
    import SaleHistory from './SaleHistory';
    import Toolbar from "./Toolbar";
    import Price from "../../Modules/Price";
    import {event, eventBus} from "../../event-bus/event-bus";
    import {deleteProductFile, deleteRecord, downloadFile, fetchRecord, nextRecord, previousRecord, removeMonumentComponent, saveRecord} from "../../helpers/axios";
    import VueNumeric from 'vue-numeric';
    import Button from "../customer-dashboard/Button";

    export default {
        name: "Add",
        props: {
            id: {
                type: Number
            },
            quote_to_price_id: {
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
                currentURL: null,
                // storeID : this.$store.getters.getCurrentStoreID,
                formFields: {
                    // store_id: this.storeID,
                    id: 0,
                    product_number: null,
                    item_name: null,
                    image: null,
                    description: null,
                    product_cost: 0,
                    total_on_hand: null,
                    total_sold: null,
                    quantity_stocked: null,
                    total_added: null,
                    total_weight: 0,
                    quantity_backordered: null,
                    tax_info: 'taxable',
                    stock_info: 'stock',
                    special_shape_cost: 0,
                    total_cost_with_freight: 0,
                    selling_formula: 1,
                    selling_price: 0,
                    greater_price: 0,
                    override_selling_price: 0,
                    selling_price_with_installation: 0,
                    color_id: null,
                    shape_id: null,
                    side_id: null,
                    type_id: null,
                    supplier: null,
                    monument_polish_id: null,
                    cost_p_squ_ft_id: null,

                    specification: {
                        id: 0,
                        specification_type: null,
                        length: 0,
                        width: 0,
                        height: 0,
                        weight_cubic_ft: 0,
                        cost_per_square_ft: 0,
                        square_ft_cost: 0,
                        length_ft: 0,
                        width_ft: 0,
                        height_ft: 0,
                        cubic_ft: 0,
                        square_ft: 0,
                        weight_lb: 0,
                    },
                    polish: {
                        id: 0,
                        polish_linear_cost_per_feet: 0,
                        polish_type: 0,
                        price: 0
                    },
                    engrave: {
                        id: 0,
                        engrave_square_inches: 0,
                        engrave_front_square: 0,
                        engrave_front_total_price: 0,
                        engrave_back_square: 0,
                        engrave_back_total_price: 0,
                        engrave_premium_cost: 0,
                    },
                    installation: {
                        id: 0,
                        product_min_install_price: 0,
                        installation_price: 0,
                        square_inch_installation: 0,
                        installation_amount: 0,
                    },
                    freight: {
                        id: 0,
                        freight_cost_per_100_lb: 0,
                        freight_cost: 0,
                        freight_amount: 0,
                        tariff_percent: 0,
                        tariff_amount: 0,
                        country_id: null
                    },

                    uploadDocuments: {image: null, files: []},
                    uploadImages: {image: null, files: []}

                },
                engravingTypeList: [{value: 'base', text: "Base = (L(in)*W(in))/144"},
                    {value: 'die', text: "Die = (L(in)*H(in))/144"},
                    {value: 'grasser', text: "Grasser = (L(in)*W(in))/144"},
                    {value: 'slants', text: "Slants = (L(in)*H(in))/144"},
                ],
                taxInfoList: [{value: 'taxable', text: "Taxable"},
                    {value: 'taxexempt', text: "Tax Exempt"}
                ],
                stockList: [{value: 'stock', text: 'Stock'},
                    {value: 'non-stock', text: 'Non-Stock'}],
                searchCountry: "",
                searchColor: "",
                searchCostPSqFt: "",
                searchType: "",
                searchShape: "",
                searchSide: "",
                searchPolish: "",
                axiosParams: {module: 'monument'},
                axiosParamsComposite: {module: 'composite'},
                imageDefault: 'images/default-image.jpg',
                storagePath: 'images/monuments/',
                modalData: {src: '', title: ''},
                saveDisabled: false,
                qtySaleHistory: false,
                hideinAuth: false,
                toggleFields: {
                    polish: 0,
                    engrave: 0,
                    installation: 0,
                    freight: 0,
                },
                quantityMonumentFields: [
                    {key: 'date', label: 'Date'},
                    {key: 'total', label: 'Total Qty'},
                    {key: 'qty_add_or_remove', label: 'Quantity Added/Removed'},
                    {key: 'by_whom', label: 'By'},
                ],

            }
        },
        metaInfo() {
           if (this.currentURL == 'price-estimator' || this.currentURL == 'price-estimator-list'){
               return {
                   title: `${this.formFields.id ? 'Edit' : 'Add'} Price Estimator`,
               }
           }else{
               return {
                   title: `${this.formFields.id ? 'Edit' : 'Add'} Monument`,
               }
           }
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Products', action: 'read'}))
                this.$router.push('/access-denied');
        },
        created() {
            eventBus.$on(event.SAVE_MONUMENT, this.storeMonument);
            eventBus.$on(event.FIRST_MONUMENT_RECORD, this.first);
            eventBus.$on(event.LAST_MONUMENT_RECORD, this.last);
            eventBus.$on(event.NEXT_MONUMENT_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_MONUMENT_RECORD, this.prev);
            eventBus.$on(event.GET_MONUMENT, this.getMonumentDropDown);
            eventBus.$on(event.ADD_MONUMENT, this.clearForm);
            eventBus.$on(event.DELETE_MONUMENT, this.deleteRecord);
            eventBus.$on(event.HIDE_INVENTORY_MODEL, this.addUpdateQtyInventory);
            eventBus.$on(event.HIDE_INVENTORY_MODEL_CANCEL, this.hideQtyModal);
        },
        destroyed() {
            eventBus.$off(event.SAVE_MONUMENT);
            eventBus.$off(event.FIRST_MONUMENT_RECORD);
            eventBus.$off(event.LAST_MONUMENT_RECORD);
            eventBus.$off(event.NEXT_MONUMENT_RECORD);
            eventBus.$off(event.PREVIOUS_MONUMENT_RECORD);
            eventBus.$off(event.GET_MONUMENT);
            eventBus.$off(event.ADD_MONUMENT);
            eventBus.$off(event.DELETE_MONUMENT);
            eventBus.$off(event.HIDE_INVENTORY_MODEL);
            eventBus.$off(event.HIDE_INVENTORY_MODEL_CANCEL);
        },
        components: {
            Button,
            Toolbar,
            InventoryHistory,
            SaleHistory,
            Price,
            VueNumeric
        },
        watch: {
            /*'formFields.total_weight'(newValue, oldValue){
                if (this.formFields.id == 0){
                    if (newValue){
                        this.changeTotalWeight(newValue, oldValue);
                    }
                }
                else{
                    if(newValue){
                        newValue =  parseFloat(newValue).toFixed(2);
                    }
                    console.log("watch",newValue);
                    this.totalWeight = newValue;
                }
            },*/
            'formFields.special_shape_cost'(newValue, oldValue) {
                if (newValue == '' || newValue == 0) {
                    this.formFields.special_shape_cost = 0
                }
            },
            'formFields.specification.cost_per_square_ft'(newValue, oldValue) {
                if (newValue == '' || newValue == 0) {
                    this.formFields.specification.cost_per_square_ft = 0
                }
            },
            'formFields.specification.weight_lb'(newValue, oldValue) {
                if (this.formFields.id == 0) {
                    this.changeTotalWeight(newValue, oldValue);
                }
            },
            'formFields.override_selling_price'(newValue, oldValue) {
                if (this.formFields.id == 0) {
                    this.changeOverridePrice(newValue, oldValue);
                } else {
                    newValue = parseFloat(newValue);
                    if (newValue == null || isNaN(newValue)) {
                        newValue = 0
                    }
                    this.overrideSellingPrice = newValue;
                }
            },
            'formFields.selling_price'(newValue, oldValue) {
                if (this.formFields.id == 0) {
                    this.changeOverridePrice(newValue, oldValue);
                }
            },
            'formFields.product_cost'(newValue, oldValue) {
                if (newValue == '' || newValue == 0) {
                    this.formFields.product_cost = '0.00'
                }
            },
        },
        computed: {
            isLoading() {
                return this.$store.state[this.axiosParams.module].busy;
            },
            specification() {
                if (this.formFields.specification == null) {
                    this.formFields.specification = {
                        id: 0,
                        specification_type: null,
                        length: 0,
                        width: 0,
                        height: 0,
                        weight_cubic_ft: 0,
                        cost_per_square_ft: 0,
                        square_ft_cost: 0
                    };
                }
                this.formFields.specification = {...this.formFields.specification}
                return this.formFields.specification
            },
            isUpdatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Products', action: 'update'});
            },
            isCreatePermitted() {
                return this.$store.getters.isPermitted({resource: 'Products', action: 'create'});
            },
            polish() {
                if (this.formFields.polish == null) {
                    this.formFields.polish = {id: 0, polish_linear_cost_per_feet: 0, price: 0};
                }
                this.formFields.polish = {...this.formFields.polish}
                return this.formFields.polish;
            },
            engrave() {
                if (this.formFields.engrave == null) {
                    this.formFields.engrave = {
                        id: 0,
                        engrave_front_square: 0,
                        engrave_back_square: 0,
                        engrave_premium_cost: 0
                    };
                }
                this.formFields.engrave = {...this.formFields.engrave}
                return this.formFields.engrave;
            },
            freight() {

                if (this.formFields.freight == null || this.formFields.freight.freight_cost == "NaN") {
                    this.formFields.freight = {
                        id: 0,
                        freight_cost_per_100_lb: 0,
                        freight_cost: 0,
                        freight_amount: 0,
                        tariff_percent: 0,
                        tariff_amount: 0
                    };
                }
                this.formFields.freight = {...this.formFields.freight}
                return this.formFields.freight;
            },
            installation() {
                if (this.formFields.installation == null) {
                    this.formFields.installation = {
                        id: 0,
                        product_min_install_price: 0,
                        installation_price: 0,
                        square_inch_installation: 0,
                        installation_amount: 0
                    };
                }
                this.formFields.installation = {...this.formFields.installation}
                return this.formFields.installation;
            },
            specificationCalculatedFields() {
                let fields = {
                    lengthFt: 0,
                    widthFt: 0,
                    heightFt: 0,
                    cubicFt: 0,
                    squareFt: 0,
                    squareInch: 0,
                    cubicIn: 0,
                    squareFtCost: 0,
                    weightLB: 0
                };
                fields.cubicIn = (this.formFields.specification.length * this.formFields.specification.height) * this.formFields.specification.width;
                fields.lengthFt = (this.formFields.specification.length / 12).toFixed(2);
                fields.widthFt = (this.formFields.specification.width / 12).toFixed(2);
                fields.heightFt = (this.formFields.specification.height / 12).toFixed(2);
                fields.squareFt = ((this.formFields.specification.length * this.formFields.specification.height) / 144).toFixed(2);
                fields.squareInch = (this.formFields.specification.length * this.formFields.specification.width).toFixed(2);
                fields.cubicFt = ((fields.squareFt * this.formFields.specification.width) / 12).toFixed(2);
                // fields.squareFtCost = parseFloat((fields.squareFt * this.formFields.specification.cost_per_square_ft).toFixed(2));
                fields.squareFtCost = parseFloat((this.formFields.specification.square_ft * this.formFields.specification.cost_per_square_ft).toFixed(2));
                fields.weightLB = (fields.cubicFt * this.formFields.specification.weight_cubic_ft).toFixed(2);
                return fields;
            },
            specificationSqureFtCalculated() {
                let field = {squreFt: 0};
                switch (this.formFields.specification.specification_type) {
                    case 'base':
                        field.squreFt = (+this.formFields.specification.length * +this.formFields.specification.width) / 144;
                        break;
                    case 'slants':
                        field.squreFt = +this.formFields.specification.length / 12;
                        break;
                    case 'grasser':
                        field.squreFt = (+this.formFields.specification.length * +this.formFields.specification.width) / 144;
                        break;
                    case 'die':
                        field.squreFt = (+this.formFields.specification.length * +this.formFields.specification.height) / 144;
                        break;
                }
                field.squreFt = parseFloat((+field.squreFt).toFixed(2));
                return field;
            },
            polishCalculatedFields() {
                let fields = {price: 0};
                switch (this.formFields.polish.polish_type) {
                    case 'p2':
                        fields.price = this.formFields.polish.polish_linear_cost_per_feet;
                        break;
                    case 'p3':
                        fields.price = (this.formFields.polish.polish_linear_cost_per_feet * this.specificationCalculatedFields.lengthFt).toFixed(2);
                        break;
                    case 'p5':
                        fields.price = (this.formFields.polish.polish_linear_cost_per_feet * (+this.specificationCalculatedFields.lengthFt + +this.specificationCalculatedFields.heightFt)).toFixed(2);
                        break;
                }
                fields.price = parseFloat(fields.price);
                return fields;
            },
            engraveCalculatedFields() {
                let fields = {size: 0, frontTotalPrice: 0, backTotalPrice: 0};
                switch (this.formFields.specification.specification_type) {
                    case 'base':
                        fields.size = +this.formFields.specification.length * +this.formFields.specification.width;
                        break;
                    case 'slants':
                        fields.size = +this.formFields.specification.length * +this.formFields.specification.height;
                        break;
                    case 'grasser':
                        fields.size = +this.formFields.specification.length * +this.formFields.specification.width;
                        break;
                    case 'die':
                        fields.size = +this.formFields.specification.length * +this.formFields.specification.height;
                        break;
                }
                fields.frontTotalPrice = parseFloat((+this.formFields.engrave.engrave_front_square * +((fields.size) / 144)).toFixed(2));
                // fields.frontTotalPrice = parseFloat((+this.formFields.engrave.engrave_front_square * +this.specificationCalculatedFields.squareFt).toFixed(2));
                fields.backTotalPrice = parseFloat((+this.formFields.engrave.engrave_back_square * +this.specificationCalculatedFields.squareFt).toFixed(2));
                return fields;
            },
            freightCalculatedFields() {
                let fields = {freightCost: 0, tariffAmount: 0};
                fields.freightCost = parseFloat(((+this.specificationCalculatedFields.weightLB / 100) * +this.freight.freight_cost_per_100_lb).toFixed(2));
                fields.tariffAmount = parseFloat((+this.costCalculationFields.cost * (+this.freight.tariff_percent / 100)).toFixed(2));
                return fields;
            },
            installationCalculatedFields() {
                let fields = {installation_amount: 0, square_inch_installation: 0};
                let installationMinPrice = +this.installation.product_min_install_price;
                let installationAmount = (+this.installation.installation_price * +this.specificationCalculatedFields.squareInch).toFixed(2)
                fields.installation_amount = parseFloat(installationAmount > installationMinPrice ? installationAmount : installationMinPrice);
                fields.square_inch_installation = this.toggleFields.installation == 1 ? +this.specificationCalculatedFields.squareInch : 0;
                return fields;
            },
            costCalculationFields() {
                let fields = {
                    cost: 0,
                    total_cost_with_freight: 0,
                    selling_price: 0,
                    selling_price_with_installation: 0
                };
                fields.cost = parseFloat((+this.specificationCalculatedFields.squareFtCost + +this.engraveCalculatedFields.frontTotalPrice + +this.engraveCalculatedFields.backTotalPrice + +this.formFields.engrave.engrave_premium_cost + +this.polishCalculatedFields.price + this.formFields.special_shape_cost).toFixed(2));
                fields.total_cost_with_freight = parseFloat((+fields.cost + +this.freight.freight_cost + +this.formFields.freight.freight_amount + +this.freight.tariff_amount).toFixed(2));
                fields.selling_price = parseFloat((+fields.total_cost_with_freight * +this.formFields.selling_formula).toFixed(2));
                this.formFields.greater_price = +this.formFields.override_selling_price > +this.formFields.selling_price ? +this.formFields.override_selling_price : +this.formFields.selling_price;
                //fields.selling_price_with_installation = parseFloat((+this.formFields.greater_price + +this.installationCalculatedFields.installation_amount).toFixed(2));
                fields.selling_price_with_installation = parseFloat((+this.formFields.override_selling_price + +this.installationCalculatedFields.installation_amount).toFixed(2));
                if (fields.cost >= 0) {
                    return fields;
                } else {
                    fields.cost = 0;
                    fields.total_cost_with_freight = 0;
                    fields.selling_price = 0;
                    fields.selling_price_with_installation = 0;
                    return fields;
                }
            },
            /* sellingPrice: {
                 get() {
                     // let price = this.formFields.override_selling_price;
                     this.formFields.override_selling_price = +this.formFields.override_selling_price > +this.formFields.selling_price ? this.formFields.override_selling_price : this.formFields.selling_price;
                     return parseFloat(this.formFields.override_selling_price);
                 },
                 set(value) {
                     this.formFields.override_selling_price = +value > +this.formFields.selling_price ? value : this.formFields.selling_price;
                 }
             },*/
            overrideSellingPrice: {
                get() {
                    this.formFields.override_selling_price = +this.formFields.override_selling_price > 0 ? +this.formFields.override_selling_price : this.formFields.selling_price;
                    return parseFloat(this.formFields.override_selling_price);
                },
                set(value) {
                    this.formFields.override_selling_price = +value > +this.formFields.override_selling_price ? value : value;
                }
            },
            totalWeight: {
                get() {
                    this.formFields.total_weight = +this.formFields.total_weight > 0 ? +this.formFields.total_weight : this.formFields.specification.weight_lb;
                    return parseFloat(this.formFields.total_weight);
                },
                set(value) {
                    this.formFields.total_weight = +value > +this.formFields.total_weight ? value : value;
                }
            },
            imageFile() {
                let image = {id: 0, src: null, filename: null};
                if (this.formFields.image && this.formFields.image[0]) {
                    image.id = this.formFields.image[0].id;
                    image.src = this.storagePath + this.formFields.image[0].path;
                    image.filename = this.formFields.image[0].path;
                }
                return image;
            },
            uploadDocuments() {

                if (this.formFields.uploadDocuments == undefined || Object.keys(this.formFields.uploadDocuments).length == 0) {
                    this.formFields.uploadDocuments = {image: null, files: []};
                }
                return this.formFields.uploadDocuments;
            },
            uploadImages() {

                if (this.formFields.uploadImages == undefined || Object.keys(this.formFields.uploadImages).length == 0) {
                    this.formFields.uploadImages = {image: null, files: []};
                }
                return this.formFields.uploadImages;
            },
            toggleComponentFields() {
                this.toggleFields.polish = this.polish.id ? 1 : this.toggleFields.polish;
                this.toggleFields.engrave = this.engrave.id ? 1 : this.toggleFields.engrave;
                this.toggleFields.installation = this.installation.id ? 1 : this.toggleFields.installation;
                this.toggleFields.freight = this.freight.id ? 1 : this.toggleFields.freight;
                return this.toggleFields;
            },
            colors() {
                this.$store.getters.sortByAlphaNumeric({'module': 'monumentColor', 'fieldName': 'color_title'});
                let options = [];
                for (let opt of this.$store.state.monumentColor.recordList) {
                    let obj = {value: opt.id, text: opt.color_title, options: opt};
                    options.push(obj);
                }
                if (this.searchColor != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchColor.toUpperCase()) > -1)
                }
                return options;
            },
            color() {
                let opt = "Select a color";
                if (this.$store.state.monumentColor.recordList.length > 0 && this.formFields.color_id != 0 && this.formFields.color_id != null) {
                    opt = this.$store.state.monumentColor.recordList.filter(obj => obj.id == this.formFields.color_id);
                    opt = opt.length > 0 ? opt[0].color_title : "Select a color";
                }
                return opt
            },
            costPSqureFt() {
                let opt = "Select";
                if (this.$store.state.costPerSqureFeet.recordList.length > 0 && this.formFields.cost_p_squ_ft_id != 0 && this.formFields.cost_p_squ_ft_id != null) {
                    opt = this.$store.state.costPerSqureFeet.recordList.filter(obj => obj.id == this.formFields.cost_p_squ_ft_id);
                    opt = opt.length > 0 ? opt[0].granite_description : "Select";
                }
                return opt
            },
            costPSqureFts() {
                this.$store.getters.sortByAlphaNumeric({'module': 'costPerSqureFeet', 'fieldName': 'granite_description'});
                let options = [];
                for (let opt of this.$store.state.costPerSqureFeet.recordList) {
                    let obj = {value: opt.id, text: opt.granite_description, options: opt};
                    options.push(obj);
                }
                if (this.searchCostPSqFt != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchCostPSqFt.toUpperCase()) > -1)
                }
                return options;
            },
            types() {
                this.$store.getters.sortByAlphaNumeric({'module': 'monumentType', 'fieldName': 'type_title'});
                let options = [];
                for (let opt of this.$store.state.monumentType.recordList) {
                    let obj = {value: opt.id, text: opt.type_title, options: opt};
                    options.push(obj);
                }
                if (this.searchType != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchType.toUpperCase()) > -1)
                }
                return options;
            },
            type() {
                let opt = "Select a type";

                if (this.$store.state.monumentType.recordList.length > 0 && this.formFields.type_id != 0 && this.formFields.type_id != null) {
                    opt = this.$store.state.monumentType.recordList.filter(obj => obj.id == this.formFields.type_id);
                    opt = opt.length > 0 ? opt[0].type_title : "Select a type";// Return object instead of array of object
                }
                return opt
            },
            shapes() {
                this.$store.getters.sortByAlphaNumeric({'module': 'monumentShape', 'fieldName': 'shape_title'});
                let options = [];
                for (let opt of this.$store.state.monumentShape.recordList) {
                    let obj = {value: opt.id, text: opt.shape_title, options: opt};
                    options.push(obj);
                }
                if (this.searchShape != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchShape.toUpperCase()) > -1)
                }
                return options;
            },
            shape() {
                let opt = "Select a shape";

                if (this.$store.state.monumentShape.recordList.length > 0 && this.formFields.shape_id != 0 && this.formFields.shape_id != null) {
                    opt = this.$store.state.monumentShape.recordList.filter(obj => obj.id == this.formFields.shape_id);
                    opt = opt.length > 0 ? opt[0].shape_title : "Select a shape";
                }
                return opt
            },
            sides() {
                this.$store.getters.sortByAlphaNumeric({'module': 'monumentSide', 'fieldName': 'side_title'});
                let options = [];
                for (let opt of this.$store.state.monumentSide.recordList) {

                    let obj = {value: opt.id, text: opt.side_title, options: opt};
                    options.push(obj);
                }
                if (this.searchSide != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchSide.toUpperCase()) > -1)
                }
                return options;
            },
            side() {
                let opt = "Select a side";

                if (this.$store.state.monumentSide.recordList.length > 0 && this.formFields.side_id != 0 && this.formFields.side_id != null) {
                    opt = this.$store.state.monumentSide.recordList.filter(obj => obj.id == this.formFields.side_id);
                    opt = opt.length > 0 ? opt[0].side_title : "Select a side";// Return object instead of array of object
                }
                return opt
            },
            monumentPolishes() {
                this.$store.getters.sortByAlphaNumeric({'module': 'monumentPolish', 'fieldName': 'product_polish_title'});
                let options = [];
                for (let opt of this.$store.state.monumentPolish.recordList) {

                    let obj = {value: opt.id, text: opt.product_polish_title, options: opt};
                    options.push(obj);
                }
                if (this.searchPolish != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchPolish.toUpperCase()) > -1)
                }
                return options;
            },
            monumentPolish() {
                let opt = "Select a Polish";

                if (this.$store.state.monumentPolish.recordList.length > 0 && this.formFields.monument_polish_id != 0 && this.formFields.monument_polish_id != null) {
                    opt = this.$store.state.monumentPolish.recordList.filter(obj => obj.id == this.formFields.monument_polish_id);
                    opt = opt.length > 0 ? opt[0].product_polish_title : "Select a polish";
                }
                return opt
            },
            countries() {
                this.$store.getters.sortByAlphaNumeric({'module': 'country', 'fieldName': 'country_title'});
                let options = [];
                for (let opt of this.$store.state.country.recordList) {
                    let obj = {value: opt.id, text: opt.country_title, options: opt};
                    options.push(obj);
                }
                if (this.searchCountry != '') {
                    options = options.filter(obj => obj.text != null && obj.text.toUpperCase().indexOf(this.searchCountry.toUpperCase()) > -1)
                }
                return options;
            },
            country() {
                let opt = "Select a country";
                if (this.$store.state.country.recordList.length > 0 && this.formFields.freight.country_id != 0 && this.formFields.freight.country_id != null) {
                    opt = this.$store.state.country.recordList.filter(obj => obj.id == this.formFields.freight.country_id);
                    opt = opt.length > 0 ? opt[0].country_title : opt;
                }
                return opt
            },
            engraveType() {
                let fields = {type: '', squreFt: ''};
                if (this.specification.specification_type == 'die') {
                    fields.type = 'Length * Height'
                    fields.squreFt = '(Length * Height)/144'
                } else if (this.specification.specification_type == 'slants') {
                    fields.type = 'Length * Height'
                    fields.squreFt = 'Length/12'
                } else if (this.specification.specification_type == 'base' || this.specification.specification_type == 'grasser') {
                    fields.type = 'Length * Width'
                    fields.squreFt = '(Length * Width)/144'
                }
                return fields;
            },
            monumentInventory() {
                if (!this.formFields.monument_inventory) this.formFields.monument_inventory = [];
                if (!this.hideInModal) {
                    if (this.formFields.monument_inventory?.length && this.formFields.id) {
                        this.$store.getters.getProductInventory({
                            data: this.formFields.monument_inventory,
                            module: this.axiosParams.module,
                            id: this.formFields.id,
                            childModule: 'monument_inventory'
                        });
                    }
                }
                return this.formFields.monument_inventory;
            },
            isCurrentURL() {
                this.currentURL = this.$route.path.split('/')[1];
                return this.currentURL == 'price-estimator' || this.currentURL == 'price-estimator-list'
            },
        },
        mounted() {
            this.$store.state[this.axiosParams.module].busy = true
            this.formFields.quote_id = this.$props.quote_to_price_id ? this.$props.quote_to_price_id : null;
            // this.formFields.store_id = this.storeID
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            if (!this.$store.getters.isPermitted({resource: 'Products', action: 'create'}) && !this.$store.getters.isPermitted({resource: 'Products', action: 'update'}))
                this.$props.hideInModal = true;
            if (this.formFields.id > 0 && !this.$store.getters.isPermitted({resource: 'Products', action: 'update'}))
                this.hideinAuth = true;
            this.getMonument(this.formFields.id);
            this.getColumns();
            this.getRecords();
            this.$store.getters.detectFormChanges();
        },
        methods: {
            /** CRUD */
            deletDropDown: function (id, module) {
                if (confirm('Do you really want to delete this record ?')) {
                    deleteRecord({id: id, module: module}, (response) => {
                        let list = this.$store.state[module].recordList;
                        this.spliceRecord(list, id);
                    })
                }
            },
            spliceRecord: function (list, id) {
                let record = list.find(obj => obj.id == id);
                let currentIndex = list.indexOf(record);
                list.splice(currentIndex, 1);
            },
            getMonumentDropDown: function (id) {
                this.axiosParams.id = id;
                this.axiosParams.estimator = this.currentURL;
                fetchRecord(this.axiosParams, (response) => {
                    this.formFields = response.data;
                    this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                })
            },
            getMonument: function (id) {
                if (id) {
                    this.axiosParams.id = id;
                    this.axiosParams.estimator = this.currentURL;
                    fetchRecord(this.axiosParams, (response) => {
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                        if (this.$store.state[this.axiosParams.module].recordList.length > 0 || this.hideInModal)
                            this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                }
                this.$store.dispatch('getMonumentInfo');
            },
            removeZeroForWeight: function (value) {
                if (value == 0 || value == '0.00') {
                    this.formFields.total_weight = '';
                }
            },
            blurEventForWeight: function (value) {
                if (value == 0 || value == '0.00') {
                    this.formFields.total_weight = '0.00';
                } else if (value > 0) {
                    this.formFields.total_weight = parseFloat(value).toFixed(2);
                }
            },
            removeZero: function (value, obj, columnName) {
                if (value == 0 || value == '0.00') {
                    switch (columnName) {
                        case 'length':
                            obj.length = '';
                            break;
                        case 'width':
                            obj.width = '';
                            break;
                        case 'height':
                            obj.height = '';
                            break;
                        case 'weight_cubic_ft':
                            obj.weight_cubic_ft = '';
                            break;
                        case 'engrave_front_square':
                            obj.engrave_front_square = '';
                            break;
                        case 'engrave_back_square':
                            obj.engrave_back_square = '';
                            break;
                        case 'tariff_percent':
                            obj.tariff_percent = '';
                            break;
                    }
                }
                return obj;
            },
            blurEventHandler: function (value, obj, columnName) {
                if (value == 0) {
                    switch (columnName) {
                        case 'length':
                            obj.length = '0';
                            break;
                        case 'width':
                            obj.width = '0';
                            break;
                        case 'height':
                            obj.height = '0';
                            break;
                        case 'weight_cubic_ft':
                            obj.weight_cubic_ft = '0';
                            break;
                        case 'engrave_front_square':
                            obj.engrave_front_square = '0';
                            break;
                        case 'engrave_back_square':
                            obj.engrave_back_square = '0';
                            break;
                        case 'tariff_percent':
                            obj.tariff_percent = '0';
                            break;
                    }
                }
                return obj;
            },
            changeOverridePrice: function (newValue, oldValue) {
                this.formFields.override_selling_price = newValue;
            },
            changeTotalWeight: function (newValue, oldValue) {
                this.formFields.total_weight = newValue;
            },
            storeMonument: function () {
                this.saveDisabled = true;
                if (this.currentURL == 'price-estimator') {
                    this.formFields.price_estimator = 'price estimator'
                    this.formFields.product_type = 'Price Estimator'
                }else {
                    this.formFields.product_type = 'Monument'
                }
                let data = this.formFields;
                let formData = new FormData();
                if (this.uploadImages.files.length > 0) {
                    for (let file of data.uploadImages.files) {
                        formData.append('doc_images[]', file);
                    }
                }
                formData.append('data', JSON.stringify(data));
                if (this.uploadDocuments.files.length > 0) {
                    for (let file of data.uploadDocuments.files) {
                        formData.append('doc_files[]', file);
                    }
                }
                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: message, variant: 'danger'});
                    } else {
                        let message = `Record Successfully ${this.formFields.id ? 'Updated' : 'Added'}`;
                        this.makeToast({title: 'Success', message: message, variant: 'success'});
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                        this.axiosParams.data = response.data;
                        if (this.currentURL == 'price-estimator') {
                            this.axiosParams.data =
                                {
                                    id: this.formFields.id,
                                    item_name: this.formFields.item_name
                                };
                        } else {
                            this.axiosParams.data =
                                {
                                    id: this.formFields.id,
                                    product_number: this.formFields.product_number
                                };
                        }
                        this.$store.commit('appendOrUpdateDropDown', this.axiosParams)
                        let compositeRecord = Object.values(this.$store.state[this.axiosParamsComposite.module].recordList);
                        if (compositeRecord.length > 0) {
                            if (this.$store.state[this.axiosParamsComposite.module].recordList.length != 0) {
                                this.$store.state[this.axiosParamsComposite.module].recordList = [];
                            }
                        }
                    }
                }, (error) => {
                    this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                })
            },
            deleteRecord: function (id) {
                if (confirm("Do you really want to delete this record?")) {
                    this.axiosParams.id = id;
                    deleteRecord(this.axiosParams, (response) => {
                        if (response.data) {
                            this.$store.dispatch('removeRecordFromList', this.axiosParams);
                            if (this.$store.state[this.axiosParams.module].recordList.length == 0) {
                                this.clearForm();
                            } else {
                                this.first();
                            }
                        } else {
                            console.log(response.data);
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
                let desiredPart = 'monuments'
                if (this.currentURL == 'price-estimator' || this.currentURL == 'price-estimator-list') {
                    desiredPart = this.currentURL
                }
                if (!this.hideInModal) {
                    this.$store.dispatch('getDropDownInfo', {
                        module: this.axiosParams.module,
                        estimator: desiredPart, apiURL: 'dropDown', page: this.pageNumber
                    })
                }
            },
            specialShapeCost() {
                if (this.formFields.special_shape_cost == '')
                    this.formFields.special_shape_cost = 0;
                return this.formFields.special_shape_cost;
            },
            costPerSqureFeet() {
                if (this.formFields.specification.cost_per_square_ft == '')
                    this.formFields.specification.cost_per_square_ft = 0;
                return this.formFields.specification.cost_per_square_ft;
            },
            openPreviewNewPage: function (url) {
                window.open(url, '_blank');
            },
            handleDropdownChange: function (value) {
                window.detectChanges = true;
            },

            /** Pagination*/
            first: function () {
                if (this.$store.state[this.axiosParams.module].recordList.length) {
                    let firstIndex = this.$store.state[this.axiosParams.module].recordList[0]
                    if (firstIndex) {
                        this.axiosParams.id = firstIndex.id;
                        nextRecord(this.axiosParams, (response) => {
                            if (Object.keys(response.data).length > 0) {
                                this.formFields = response.data;
                                this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                            }
                            this.$store.state[this.axiosParams.module].busy = false
                        }, (error) => {
                            console.log(error)
                            this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                        })
                    }
                }
            },
            last: function () {
                if (this.$store.state[this.axiosParams.module].recordList.length) {
                    let lastIndex = this.$store.state[this.axiosParams.module].recordList.slice(-1)[0]
                    if (lastIndex) {
                        this.axiosParams.id = lastIndex.id;
                        nextRecord(this.axiosParams, (response) => {
                            if (Object.keys(response.data).length > 0) {
                                this.formFields = response.data;
                                this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                            }
                            this.$store.state[this.axiosParams.module].busy = false
                        }, (error) => {
                            console.log(error)
                            this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                        })
                    }
                }
            },
            next: function (id) {
                if (this.$store.state[this.axiosParams.module].recordList.length) {
                    let list = this.$store.state[this.axiosParams.module].recordList;
                    let nextIndex = list.findIndex(obj => obj.id == id);
                    nextIndex = list[nextIndex + 1].id
                    this.axiosParams.id = nextIndex;
                    nextRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.formFields = response.data;
                            this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                        }
                        this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                }
            },
            prev: function (id) {
                if (this.$store.state[this.axiosParams.module].recordList.length) {
                    let list = this.$store.state[this.axiosParams.module].recordList;
                    let previousIndex = list.findIndex(obj => obj.id == id);
                    if (previousIndex > -1) {
                        previousIndex = list[previousIndex - 1].id
                        this.axiosParams.id = previousIndex;
                        previousRecord(this.axiosParams, (response) => {
                            if (Object.keys(response.data).length > 0) {
                                this.formFields = response.data;
                                this.$store.state[this.axiosParams.module].currentSaleHistory = this.formFields
                            }
                            this.$store.state[this.axiosParams.module].busy = false
                        }, (error) => {
                            console.log(error)
                            this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                        })
                    }
                }
            },

            /** Select List */
            setDetail(obj, detail) {
                this.formFields[detail + '_id'] = obj.value;
                this.formFields[detail] = obj.text;
            },
            setCostFtDetail(obj) {
                this.formFields.cost_p_squ_ft_id = obj.value;
                if (obj.options.granite_sq_ft_price)
                    this.formFields.specification.cost_per_square_ft = obj.options.granite_sq_ft_price
            },
            setCountry(obj) {
                Vue.set(this.formFields.freight, 'country_id', obj.value);
            },


            /** Save List */
            saveDetail: function (detail) {
                let data = {
                    id: 0,
                    // store_id: this.storeID
                };
                let params = {};

                if (detail == 'color') {
                    data['color_title'] = this.searchColor;
                    params.module = 'monumentColor';
                } else if (detail == 'type') {
                    data['type_title'] = this.searchType;
                    params.module = 'monumentType';
                } else if (detail == 'shape') {
                    data['shape_title'] = this.searchShape;
                    params.module = 'monumentShape';
                } else if (detail == 'side') {
                    data['side_title'] = this.searchSide;
                    params.module = 'monumentSide';
                } else if (detail == 'monument_polish') {
                    data['product_polish_title'] = this.searchPolish;
                    params.module = 'monumentPolish';
                } else {
                    data['country_title'] = this.searchCountry;
                    params.module = 'country';
                }
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                saveRecord(params, formData, (response) => {
                    if (response.data.errorInfo) {
                        let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: message, variant: 'danger'});
                    } else {
                        params.data = response.data;
                        this.$store.commit('appendOrUpdateInRecordList', params);
                    }
                })
            },

            /** Generic*/
            makeToast(params) {
                this.$bvToast.toast(params.message, {
                    title: params.title,
                    variant: params.variant,
                    toaster: 'b-toaster-top-center',
                    autoHideDelay: 3000,
                    noCloseButton: true,
                })
                this.saveDisabled = false;
            },
            clearForm() {
                if (window.detectChanges && !confirm('You have unsaved changes. Are you sure you want to navigate away?')) {
                    this.$store.state[this.axiosParams.module].busy = false
                } else {
                    window.detectChanges = false;
                }
                if (!window.detectChanges) {
                    this.formFields = {
                        // store_id: this.storeID,
                        id: 0,
                        color_id: null,
                        type_id: null,
                        side_id: null,
                        shape_id: null,
                        cost_p_squ_ft_id: null,
                        total_weight: 0.00,
                        tax_info: 'taxable',
                        stock_info: 'stock',
                        monument_polish_id: null,
                        color: {},
                        type: {},
                        side: {},
                        shape: {},
                        monument_polish: {},
                        specification:
                            {
                                id: 0,
                                specification_type: null,
                                length: 0,
                                width: 0,
                                height: 0,
                                weight_cubic_ft: 0,
                                cost_per_square_ft: 0,
                                square_ft_cost: 0,
                                weight_lb: null,
                            },
                        polish: null,
                        engrave: null,
                        installation: null,
                        freight: null,
                        selling_formula: 1,
                        special_shape_cost: 0,
                        selling_price: 0,
                        override_selling_price: 0,
                        selling_price_with_installation: 0,
                        total_cost_with_freight: 0,
                        uploadDocuments: {image: null, files: []},
                    };
                    this.$store.state[this.axiosParams.module].currentSaleHistory = []
                    this.searchColor = '';
                    this.searchType = '';
                    this.searchShape = '';
                    this.searchSide = '';
                    this.searchPolish = '';
                    this.searchCountry = '';
                    Object.keys(this.toggleFields).forEach(key => this.toggleFields[key] = 0)
                }
            },
            customizeLabel(str) {
                let i, labels = str.split('_');
                for (i = 0; i < labels.length; i++) {
                    labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
                }
                return labels.join(' ');
            },
            setCurrentRecord() {
                this.$store.state[this.axiosParams.module].currentRecord = this.formFields;
            },
            setImageModalData(src, title) {
                this.modalData.src = src;
                this.modalData.title = title;
            },
            deleteFile(id, index) {
                if (confirm("Do you really want to delete this file?")) {
                    this.axiosParams.id = id;
                    this.axiosParams.method = '/deleteFile/';
                    deleteProductFile(this.axiosParams, (response) => {
                        if (response.data) {
                            this.formFields.files.splice(index, 1);

                        } else {
                            console.log(response.data);
                        }
                    })
                }
            },
            deleteImage(id, index) {
                if (confirm("Do you really want to delete this Image?")) {
                    this.axiosParams.id = id;
                    this.axiosParams.method = '/deleteImage/';
                    deleteProductFile(this.axiosParams, (response) => {
                        if (response.data) {
                            this.formFields.images.splice(index, 1);
                        } else {
                            console.log(response.data);
                        }
                    });
                }
            },
            downloadDocument(src, name) {
                let formData = new FormData();
                formData.append('module', this.axiosParams.module);
                formData.append('file', src);
                formData.append('name', name);
                downloadFile(formData, (response) => {
                    console.log(response)
                });
            },
            toggleComponent(status, type) {
                if (status == 0 && this.formFields.id != 0) {
                    let data = new FormData();
                    data.append('id', this.formFields.id);
                    data.append('type', type);
                    removeMonumentComponent(data, (response) => {
                        this.formFields[type] = null;
                    })
                }
            },
            previewImage: function (event) {
                let input = event.target;
                let invalidFileType = false;
                if (input.files.length > 0) {
                    for (let file of input.files) {
                        let FileSize = file.size / 1024 / 1024;
                        if (FileSize > 20 || (file.type.indexOf("image") == -1 && file.name.substr(file.name.lastIndexOf('.') + 1) != 'fs')) {
                            invalidFileType = true;
                            break;
                        }
                    }
                }
                if (invalidFileType) {
                    this.makeToast({title: 'Error', message: 'Invalid image type or File size exceeds 20 MB', variant: 'danger', duration: 3000});
                    this.$refs['inputFile'].reset();
                    return false;
                }
            },
            checkFile: function (event) {
                let input = event.target;
                for (let i = 0; i < input.files.length; i++) {
                    let FileSize = input.files[i].size / 1024 / 1024; // in MiB
                    if (FileSize > 20 || (input.files[i].type != "application/vnd.ms-excel"
                        && input.files[i].type != "text/plain" && input.files[i].type != "application/pdf" && input.files[i].type != "application/doc"
                        && input.files[i].type != "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                        && input.files[i].type != "application/postscript" && input.files[i].type != "image/svg+xml"
                        && input.files[i].name.substr(input.files[i].name.lastIndexOf('.') + 1) != 'fs'
                        && input.files[i].type != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")) {
                        this.makeToast({title: 'Error', message: 'Invalid file type or file size exceeds 20 MB', variant: 'danger'});
                        this.$refs['inputFile1'].reset();
                        return false;
                    }
                }
            },
            checkFileType: function (fileName) {
                let ext = fileName.substr(fileName.lastIndexOf('.') + 1);
                if (ext == 'fs') {
                    return true;
                }
                return false;
            },
            addUpdateQtyInventory: function (qty) {
                this.formFields.qty_add_or_remove = qty;
                let date = this.$store.getters.getCurrentDate;
                let userName = this.$store.getters.getUserName;
                if (qty) {
                    if (!this.formFields.monument_inventory) this.formFields.monument_inventory = [];
                    this.formFields.monument_inventory.push({
                        id: 0, date: date, by_whom: userName, qty_add_or_remove: qty
                    });
                    // this.monument_inventory;
                    this.monumentInventory;
                }
                this.$bvModal.hide('posted-product-inventory');
            },
            hideQtyModal: function (qty) {
                this.formFields.qty_add_or_remove = qty;
                this.$bvModal.hide('posted-product-inventory');
            },
        },
        directives: {
            // create directive named 'removeZero' starting with v- for example v-remove-zero
            removeZero: {
                bind: function (element, binding, vnode) {
                    element.onfocus = function () {
                        if (parseFloat(element.value) === 0) {
                            element.value = null;
                        }
                    };
                },
            },
        },

    }
</script>

<style scoped>

    .custom-margin {
        margin-top: -0.5rem;
        margin-left: -0.4rem;
        margin-bottom: -0.9rem;
    }
    .custom-small-width-{
        width: 153px;
    }

    .heading-of-row {
        padding-left: 1rem;
    }

    .general-information-row-1, .general-information-row-2, .specification-row-1, .specification-row-2, .polish-row, .engrave-row-1, .engrave-row-2,
    .installation-row, .installation-cost-row, .freight-row, .selling-price-row, .documents-row, .additional-details-row {
        display: flex;
        margin: 0.5rem 0;
        padding-left: 1rem;
    }

    .general-information-row-1 div, .general-information-row-2 div, .specification-row-1 div, .specification-row-2 div, .polish-row div, .engrave-row-1 div,
    .engrave-row-2 div, .installation-row div, .installation-cost-row div, .freight-row div, .selling-price-row div, .documents-row div, .additional-details-row div {
        display: flex;
    }

    .general-information-row-1 div label, .general-information-row-2 div label, .specification-row-1 div label, .specification-row-2 div label,
    .polish-row div label, .engrave-row-1 div label, .engrave-row-2 div label, .installation-row div label, .installation-cost-row div label, .freight-row div label,
    .selling-price-row div label, .documents-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
    }

    .additional-details-row div label {
        margin: auto 1rem;
        white-space: nowrap !important;
    }

    input, textarea, select {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.75rem;
    }

    .input-xl {
        width: 20rem;
    }

    .input-lg-width {
        width: 24rem;
    }

    .input-lg {
        width: 12rem;
    }

    .input-sm-6 {
        width: 6rem;
    }

    .input-md {
        width: 8rem;
    }

    .input-sm {
        width: 6rem;
    }

    .input-dropdown {
        width: 12rem;
    }

    .input-tariff {
        width: 5rem;
    }

    .product-image {
        width: 8rem;
        height: 4rem;
    }

    .description-width {
        min-width: 30rem;
    }

    .custom-add-btn {
        box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.25);
        border-radius: 5px;
        height: 26px;
        font-size: 12px;
        letter-spacing: 0.02em;
    }

    .specification-length-in-input {
        margin-left: 2px;
    }

    .border {
        border: 1px solid #c4c4c4 !important;
    }

    .custom-modal-margin {
        padding-top: 0.1rem;
        margin-right: -.9rem;
        padding-left: -0.2rem;
        padding-bottom: 1rem;
        background-color: #e9ecef;
    }

    .file-container {
        max-height: 7rem;
    }

    .file-container > div {
        opacity: 0;
        transition: 1s;
    }

    .file-container:hover > div {
        opacity: 1;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
    }

</style>
