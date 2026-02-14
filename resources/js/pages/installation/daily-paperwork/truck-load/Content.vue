<template>

    <div>

        <form class="bg-white rounded mx-2 mb-2 p-3">

            <div class="form-content">

                <div class="installation-row border rounded mb-2 mx-n2">
                    <div class="d-block border-right px-1 pt-1 m-0">
                        <label class="font-weight-bold">Date:</label>
                        <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                           class="input-date"
                                           :disabled="hideInModal"
                                           size="sm"
                                           placeholder=""
                                           v-model="formFields.date"
                                           @input="formFields.date = checkDate(formFields.date)"
                                           today-button
                                           reset-button
                                           close-button
                                           locale="en">
                        </b-form-datepicker>
                       <!-- <label class="d-block mt-2">{{formFields.date}}</label>-->
                    </div>
                  <!--  <div class="d-block border-right px-1 pt-1 m-0">
                        <label class="font-weight-bold">Day:</label>
                        <label class="d-block mt-2">{{getDayOfWeek(formFields.date)}}</label>
                    </div>
                    <div class="d-block border-right px-1 pt-1 my-0">
                        <label class="font-weight-bold">Name of Installer:</label>
                        <b-form-input  :disabled="hideInModal"  type="text" class="my-1 mx-0" size="sm"
                                      v-model="formFields.name_of_installer"></b-form-input>
                    </div>-->
                    <div class="d-block px-1 border-right px-1 pt-1 m-0">
                        <label class="font-weight-bold">Last Name on Stone:</label>
                        <b-form-input  disabled  type="text" class="my-1 mx-0 bg-white border-0" size="sm"
                                       v-model="formFields.last_name_on_stone"></b-form-input>
                    </div>
                    <div class="d-block px-1">
                        <label class="font-weight-bold">Name of Checker:</label>
                        <b-form-input  :disabled="hideInModal"  type="text" class="my-1 mx-0" size="sm"
                                      v-model="formFields.name_of_checker"></b-form-input>
                    </div>
                </div>
                <div class="installation-row d-block mt-2">
                    <div class="col-6 ml-n4 my-4">
                        <label class="">Truck Name/Info:</label>
                        <b-form-input  :disabled="hideInModal"  type="text" size="sm" v-model="formFields.truck_name_info"></b-form-input>
                    </div>
                </div>
                <div class="installation-row d-block mt-2">
                    <div>
                        <h3 class="custom-view-heading">MAINTENANCE CHECK OFF</h3>
                    </div>
                    <div>
                        <div class="col-7"></div>
                        <div class="col-4">
                            <div class="col-4"><label class="font-weight-bold ml-n1">FILL</label></div>
                            <div class="col-4"><label class="font-weight-bold ml-n3">REPLACE</label></div>
                            <div class="col-4"><label class="font-weight-bold ml-n2">ADD</label></div>
                        </div>
                        <div class="col-1"></div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">CK ENGINE OIL</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_maintenance.ck_engine_oil.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_maintenance.ck_engine_oil.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_maintenance.ck_engine_oil.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_maintenance.ck_engine_oil)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_maintenance','ck_engine_oil',formFields.truck_load_list.truck_load_maintenance.ck_engine_oil)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">CK TIRE PRESSURE</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_maintenance.ck_tire_pressure.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_maintenance.ck_tire_pressure.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_maintenance.ck_tire_pressure.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_maintenance.ck_tire_pressure)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_maintenance','ck_tire_pressure',formFields.truck_load_list.truck_load_maintenance.ck_tire_pressure)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">CHECK GAS & OIL LEVEL IN TRUCK</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_maintenance.ck_oil_level.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_maintenance.ck_oil_level.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_maintenance.ck_oil_level.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_maintenance.ck_oil_level)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_maintenance','ck_oil_level',formFields.truck_load_list.truck_load_maintenance.ck_oil_level)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="installation-row d-block mt-3">
                    <div>
                        <h3 class="custom-view-heading ">DRIVER SIDE BOX</h3>
                    </div>
                    <div>
                        <div class="col-7"></div>
                        <div class="col-4">
                            <div class="col-4"><label class="font-weight-bold ml-n1">FILL</label></div>
                            <div class="col-4"><label class="font-weight-bold ml-n3">REPLACE</label></div>
                            <div class="col-4"><label class="font-weight-bold ml-n2">ADD</label></div>
                        </div>
                        <div class="col-1"></div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">COME ALONG</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.come_along.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.come_along.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.come_along.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_driver.come_along)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_driver','come_along',formFields.truck_load_list.truck_load_driver.come_along)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">ROLL OFF ROPE</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.roll_rope.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.roll_rope.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.roll_rope.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_driver.roll_rope)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_driver','roll_rope',formFields.truck_load_list.truck_load_driver.roll_rope)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">XTRA STRAPS</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.xtra_straps.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.xtra_straps.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.xtra_straps.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_driver.xtra_straps)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_driver','xtra_straps',formFields.truck_load_list.truck_load_driver.xtra_straps)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">FLASH LIGHT</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.flash_light.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.flash_light.fill_replace_add " value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.flash_light.fill_replace_add " value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_driver.flash_light)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_driver','flash_light',formFields.truck_load_list.truck_load_driver.flash_light)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">CROW BAR</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.crow_bar.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.crow_bar.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.crow_bar.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_driver.crow_bar)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_driver','crow_bar',formFields.truck_load_list.truck_load_driver.crow_bar)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">5lbs. SLEDGE</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.sledge.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.sledge.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.sledge.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_driver.sledge)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_driver','sledge',formFields.truck_load_list.truck_load_driver.sledge)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">HATCHET</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.hatchet.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.hatchet.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.hatchet.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_driver.hatchet)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_driver','hatchet',formFields.truck_load_list.truck_load_driver.hatchet)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">CRANE CONTROL</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.crane_control.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.crane_control.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.crane_control.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_driver.crane_control)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_driver','crane_control',formFields.truck_load_list.truck_load_driver.crane_control)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">BLUE TOOL BOX MISC TOOLS</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.blue_tool_box.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.blue_tool_box.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.blue_tool_box.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_driver.blue_tool_box)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_driver','blue_tool_box',formFields.truck_load_list.truck_load_driver.blue_tool_box)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">CABLE AND LOCK</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.cable_lock.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.cable_lock.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.cable_lock.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_driver.cable_lock)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_driver','cable_lock',formFields.truck_load_list.truck_load_driver.cable_lock)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">D-2 SPRAYER</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.d2_sprayer.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.d2_sprayer.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_driver.d2_sprayer.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_driver.d2_sprayer)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_driver','d2_sprayer',formFields.truck_load_list.truck_load_driver.d2_sprayer)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="installation-row d-block mt-3">
                    <div>
                        <h3 class="custom-view-heading ">PASSENGER TOOLBOX</h3>
                    </div>
                    <div>
                        <div class="col-7"></div>
                        <div class="col-4">
                            <div class="col-4"><label class="font-weight-bold ml-n1">FILL</label></div>
                            <div class="col-4"><label class="font-weight-bold ml-n3">REPLACE</label></div>
                            <div class="col-4"><label class="font-weight-bold ml-n2">ADD</label></div>
                        </div>
                        <div class="col-1"></div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">RATCHET STRAPS QTY. 11</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.ratchet_srtap_qty11.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.ratchet_srtap_qty11.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.ratchet_srtap_qty11.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_passenger.ratchet_srtap_qty11)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_passenger','ratchet_srtap_qty11',formFields.truck_load_list.truck_load_passenger.ratchet_srtap_qty11)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">RED SETTING CUSHIONS</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.red_setting_cushions.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.red_setting_cushions.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.red_setting_cushions.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_passenger.red_setting_cushions)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_passenger','red_setting_cushions',formFields.truck_load_list.truck_load_passenger.red_setting_cushions)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">WHITE SETTING CUSHIONS</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.white_setting_cushions.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.white_setting_cushions.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.white_setting_cushions.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_passenger.white_setting_cushions)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_passenger','white_setting_cushions',formFields.truck_load_list.truck_load_passenger.white_setting_cushions)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">ROLL OF BLUE PAPERTOWELS</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.roll_blue_paper_towels.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.roll_blue_paper_towels.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.roll_blue_paper_towels.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_passenger.roll_blue_paper_towels)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_passenger','roll_blue_paper_towels',formFields.truck_load_list.truck_load_passenger.roll_blue_paper_towels)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">BLACK RUBBER MONUMENT PADS</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.black_rubber_monument_pads.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.black_rubber_monument_pads.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.black_rubber_monument_pads.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_passenger.black_rubber_monument_pads)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_passenger','black_rubber_monument_pads',formFields.truck_load_list.truck_load_passenger.black_rubber_monument_pads)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">SCREW DRIVERS</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.screw_drivers.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.screw_drivers.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.screw_drivers.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_passenger.screw_drivers)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_passenger','screw_drivers',formFields.truck_load_list.truck_load_passenger.screw_drivers)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">PLIERS</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.pliers.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.pliers.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.pliers.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_passenger.pliers)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_passenger','pliers',formFields.truck_load_list.truck_load_passenger.pliers)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">BOX KNIFE</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.box_knife.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.box_knife.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.box_knife.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_passenger.box_knife)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_passenger','box_knife',formFields.truck_load_list.truck_load_passenger.box_knife)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">TAPE</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.tape.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.tape.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.tape.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_passenger.tape)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_passenger','tape',formFields.truck_load_list.truck_load_passenger.tape)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">2 TUBES OF GRAY SILICONE</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.tubes_gray_silicone.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.tubes_gray_silicone.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.tubes_gray_silicone.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_passenger.tubes_gray_silicone)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_passenger','tubes_gray_silicone',formFields.truck_load_list.truck_load_passenger.tubes_gray_silicone)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">SQUIRT BOTTLE COLEMAN FULL</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.squirt_bottle_coleman_full.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.squirt_bottle_coleman_full.fill_replace_add " value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.squirt_bottle_coleman_full.fill_replace_add " value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_passenger.squirt_bottle_coleman_full)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_passenger','squirt_bottle_coleman_full',formFields.truck_load_list.truck_load_passenger.squirt_bottle_coleman_full)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">SCRUB BUSH</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.scrub_bush.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.scrub_bush.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.scrub_bush.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_passenger.scrub_bush)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_passenger','scrub_bush',formFields.truck_load_list.truck_load_passenger.scrub_bush)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">SPRAY BOTTLE WINDEX</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.spray_bottle_windex.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.spray_bottle_windex.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.spray_bottle_windex.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_passenger.spray_bottle_windex)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_passenger','spray_bottle_windex',formFields.truck_load_list.truck_load_passenger.spray_bottle_windex)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">2FT LEVEL</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.ft_level2.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.ft_level2.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_passenger.ft_level2.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_passenger.ft_level2)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_passenger','ft_level2',formFields.truck_load_list.truck_load_passenger.ft_level2)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="installation-row d-block mt-3">
                    <div>
                        <h3 class="custom-view-heading ">INSIDE TRUCK CAB</h3>
                    </div>
                    <div>
                        <div class="col-7"></div>
                        <div class="col-4">
                            <div class="col-4"><label class="font-weight-bold ml-n1">FILL</label></div>
                            <div class="col-4"><label class="font-weight-bold ml-n3">REPLACE</label></div>
                            <div class="col-4"><label class="font-weight-bold ml-n2">ADD</label></div>
                        </div>
                        <div class="col-1"></div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">BLACK BLANKETS QTY. 2</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.black_blankets.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.black_blankets.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.black_blankets.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_inside.black_blankets)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_inside','black_blankets',formFields.truck_load_list.truck_load_inside.black_blankets)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">RUBBING PAPER</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.rubbing_paper.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.rubbing_paper.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.rubbing_paper.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_inside.rubbing_paper)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_inside','rubbing_paper',formFields.truck_load_list.truck_load_inside.rubbing_paper)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">JUMPER CABLES</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.jumper_cabels.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.jumper_cabels.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.jumper_cabels.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_inside.jumper_cabels)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_inside','jumper_cabels',formFields.truck_load_list.truck_load_inside.jumper_cabels)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">EMERGENCY STUFF</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.emergency_stuff.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.emergency_stuff.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.emergency_stuff.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_inside.emergency_stuff)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_inside','emergency_stuff',formFields.truck_load_list.truck_load_inside.emergency_stuff)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">FIRE EXT.</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.fire_ext.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.fire_ext.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.fire_ext.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_inside.fire_ext)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_inside','fire_ext',formFields.truck_load_list.truck_load_inside.fire_ext)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">PROBE </label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"> <b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.probe.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.probe.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.probe.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_inside.probe)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_inside','probe',formFields.truck_load_list.truck_load_inside.probe)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">INSTALL CHECK LIST AND CATALOGS</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.install_check_list.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.install_check_list.fill_replace_add " value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.install_check_list.fill_replace_add " value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_inside.install_check_list)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_inside','install_check_list',formFields.truck_load_list.truck_load_inside.install_check_list)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">MARKING PENCIL WAX PENCILS qty3 (red, white & yellow)</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.marking_pencil_wax.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.marking_pencil_wax.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.marking_pencil_wax.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_inside.marking_pencil_wax)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_inside','marking_pencil_wax',formFields.truck_load_list.truck_load_inside.marking_pencil_wax)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">GRAY TARP</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.gray_tarp.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.gray_tarp.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.gray_tarp.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_inside.gray_tarp)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_inside','gray_tarp',formFields.truck_load_list.truck_load_inside.gray_tarp)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">TIRE REPAIR KIT</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.tire_repair_kit.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.tire_repair_kit.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.tire_repair_kit.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_inside.tire_repair_kit)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_inside','tire_repair_kit',formFields.truck_load_list.truck_load_inside.tire_repair_kit)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">BAG IT BAG FOR DIRT</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.bag_for_dirt.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.bag_for_dirt.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.bag_for_dirt.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button":class="toggleStatus(formFields.truck_load_list.truck_load_inside.bag_for_dirt)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_inside','bag_for_dirt',formFields.truck_load_list.truck_load_inside.bag_for_dirt)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">MONUMENT TAGS & BUSINESS CARDS</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.monument_tags_cards.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.monument_tags_cards.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_inside.monument_tags_cards.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_inside.monument_tags_cards)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_inside','monument_tags_cards',formFields.truck_load_list.truck_load_inside.monument_tags_cards)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="installation-row d-block mt-3">
                    <div>
                        <h3 class="custom-view-heading ">ON BACK OF TRUCK</h3>
                    </div>
                    <div>
                        <div class="col-7"></div>
                        <div class="col-4">
                            <div class="col-4"><label class="font-weight-bold ml-n1">FILL</label></div>
                            <div class="col-4"><label class="font-weight-bold ml-n3">REPLACE</label></div>
                            <div class="col-4"><label class="font-weight-bold ml-n2">ADD</label></div>
                        </div>
                        <div class="col-1"></div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">SETTING DOLLY <span class="font-italic font-weight-bold">CK TIRE PRESURE</span></label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.setting_dolly.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.setting_dolly.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.setting_dolly.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.setting_dolly)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','setting_dolly',formFields.truck_load_list.truck_load_back.setting_dolly)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">GRANITE SEAL</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.granite_seal.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.granite_seal.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.granite_seal.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.granite_seal)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','granite_seal',formFields.truck_load_list.truck_load_back.granite_seal)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">SHOVEL</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.shovel.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.shovel.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.shovel.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.shovel)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','shovel',formFields.truck_load_list.truck_load_back.shovel)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">SHARP SHOOTER SHOVEL</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.sharp_shooter_shovel.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.sharp_shooter_shovel.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.sharp_shooter_shovel.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.sharp_shooter_shovel)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','sharp_shooter_shovel',formFields.truck_load_list.truck_load_back.sharp_shooter_shovel)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">HOE</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.hoe.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.hoe.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.hoe.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.hoe)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','hoe',formFields.truck_load_list.truck_load_back.hoe)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">RAKE</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.rake.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.rake.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.rake.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.rake)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','rake',formFields.truck_load_list.truck_load_back.rake)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">PICK AX</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.pick_ax.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.pick_ax.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.pick_ax.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.pick_ax)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','pick_ax',formFields.truck_load_list.truck_load_back.pick_ax)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">4FT LEVEL</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.ft_level4.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.ft_level4.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.ft_level4.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.ft_level4)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','ft_level4',formFields.truck_load_list.truck_load_back.ft_level4)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">MANUAL POST HOLE DIGGER</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.manual_post_hole_digger.fill_replace_add"  value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.manual_post_hole_digger.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.manual_post_hole_digger.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.manual_post_hole_digger)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','manual_post_hole_digger',formFields.truck_load_list.truck_load_back.manual_post_hole_digger)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">GAS POST HOLE AUGER <span class="font-italic font-weight-bold">(CK GAS)</span></label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.gas_post_hole_auger.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.gas_post_hole_auger.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.gas_post_hole_auger.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.gas_post_hole_auger)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','gas_post_hole_auger',formFields.truck_load_list.truck_load_back.gas_post_hole_auger)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">DINGO ROLLER BAR</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.dingo_roller_bar.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.dingo_roller_bar.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.dingo_roller_bar.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.dingo_roller_bar)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','dingo_roller_bar',formFields.truck_load_list.truck_load_back.dingo_roller_bar)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">CRANE ROLLER BAR</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.crane_roller_bar.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.crane_roller_bar.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.crane_roller_bar.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.crane_roller_bar)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','crane_roller_bar',formFields.truck_load_list.truck_load_back.crane_roller_bar)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">TAMPER</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.tamper.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.tamper.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.tamper.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.tamper)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','tamper',formFields.truck_load_list.truck_load_back.tamper)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">WHEEL BARROW <span class="font-italic font-weight-bold">CK TIRE PRESURE</span></label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.wheel_barrow.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.wheel_barrow.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.wheel_barrow.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.wheel_barrow)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','wheel_barrow',formFields.truck_load_list.truck_load_back.wheel_barrow)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">ORANGE PINCH BAR</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.orange_pinch_bar.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.orange_pinch_bar.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.orange_pinch_bar.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.orange_pinch_bar)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','orange_pinch_bar',formFields.truck_load_list.truck_load_back.orange_pinch_bar)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">BLUE ROLLER</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.blue_roller.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.blue_roller.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.blue_roller.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.blue_roller)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','blue_roller',formFields.truck_load_list.truck_load_back.blue_roller)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">2 WHEEL CHALKS</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.two_wheel_chalks.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.two_wheel_chalks.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.two_wheel_chalks.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.two_wheel_chalks)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','two_wheel_chalks',formFields.truck_load_list.truck_load_back.two_wheel_chalks)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">WATER BUCKETS QTY. 3</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.water_buckets.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.water_buckets.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.water_buckets.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.water_buckets)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','water_buckets',formFields.truck_load_list.truck_load_back.water_buckets)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">2x4’s</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.two_by_fours.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.two_by_fours.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.two_by_fours.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.two_by_fours)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','two_by_fours',formFields.truck_load_list.truck_load_back.two_by_fours)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">1x4’s</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.one_by_fours.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.one_by_fours.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.one_by_fours.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.one_by_fours)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','one_by_fours',formFields.truck_load_list.truck_load_back.one_by_fours)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">GRASS SEED <span class="font-italic font-weight-bold">(IN FOLGERS CAN)</span></label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.grass_seed.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.grass_seed.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.grass_seed.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.grass_seed)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','grass_seed',formFields.truck_load_list.truck_load_back.grass_seed)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">BUCKET OF PEA GRAVEL</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.bucket_pea_gravel.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.bucket_pea_gravel.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_back.bucket_pea_gravel.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_back.bucket_pea_gravel)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_back','bucket_pea_gravel',formFields.truck_load_list.truck_load_back.bucket_pea_gravel)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="installation-row d-block mt-3">
                    <div>
                        <h3 class="custom-view-heading ">SETTING TOOL BOX</h3>
                    </div>
                    <div>
                        <div class="col-7"></div>
                        <div class="col-4">
                            <div class="col-4"><label class="font-weight-bold ml-n1">FILL</label></div>
                            <div class="col-4"><label class="font-weight-bold ml-n3">REPLACE</label></div>
                            <div class="col-4"><label class="font-weight-bold ml-n2">ADD</label></div>
                        </div>
                        <div class="col-1"></div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">GRAY SILICONE QTY 2 TUBES</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.gray_silicone_qty.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.gray_silicone_qty.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.gray_silicone_qty.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_setting.gray_silicone_qty)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_setting','gray_silicone_qty',formFields.truck_load_list.truck_load_setting.gray_silicone_qty)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">BROWN SILICONE QTY. 2 TUBES</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.brown_silicone_qty.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.brown_silicone_qty.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.brown_silicone_qty.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_setting.brown_silicone_qty)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_setting','brown_silicone_qty',formFields.truck_load_list.truck_load_setting.brown_silicone_qty)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">CAULK GUN QTY. 2</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.caulk_gun_qty.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.caulk_gun_qty.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.caulk_gun_qty.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_setting.caulk_gun_qty)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_setting','caulk_gun_qty',formFields.truck_load_list.truck_load_setting.caulk_gun_qty)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">TAPE MEASURE QTY. 2</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.tape_measure_qty.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.tape_measure_qty.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.tape_measure_qty.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_setting.tape_measure_qty)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_setting','tape_measure_qty',formFields.truck_load_list.truck_load_setting.tape_measure_qty)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">TORPEDO LEVEL</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.torpedo_level.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.torpedo_level.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.torpedo_level.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_setting.torpedo_level)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_setting','torpedo_level',formFields.truck_load_list.truck_load_setting.torpedo_level)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">MARKING PAINT</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.marking_paint.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.marking_paint.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.marking_paint.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_setting.marking_paint)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                   @click="showWorkOrder('truck_load_setting','marking_paint',formFields.truck_load_list.truck_load_setting.marking_paint)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">PRY BAR</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.pry_bar.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.pry_bar.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.pry_bar.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_setting.pry_bar)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_setting','pry_bar',formFields.truck_load_list.truck_load_setting.pry_bar)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">SCRAPERS</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.scrapers.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.scrapers.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.scrapers.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_setting.scrapers)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_setting','scrapers',formFields.truck_load_list.truck_load_setting.scrapers)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">BOX KNIFE QTY. 2</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.box_knife_qty.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.box_knife_qty.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.box_knife_qty.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_setting.box_knife_qty)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_setting','box_knife_qty',formFields.truck_load_list.truck_load_setting.box_knife_qty)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">BLADES</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.blades.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.blades.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.blades.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_setting.blades)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_setting','blades',formFields.truck_load_list.truck_load_setting.blades)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">HAND BROOM</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.hand_broom.fill_replace_add"  value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.hand_broom.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.hand_broom.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_setting.hand_broom)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_setting','hand_broom',formFields.truck_load_list.truck_load_setting.hand_broom)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">TROWEL</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.trowel.fill_replace_add " value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.trowel.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.trowel.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_setting.trowel)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_setting','trowel',formFields.truck_load_list.truck_load_setting.trowel)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">MASKING TAPE</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.masking_tape.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.masking_tape.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.masking_tape.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_setting.masking_tape)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_setting','masking_tape',formFields.truck_load_list.truck_load_setting.masking_tape)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">SCREW DRIVERS</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.screw_drivers1.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.screw_drivers1.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.screw_drivers1.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_setting.screw_drivers1)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_setting','screw_drivers1',formFields.truck_load_list.truck_load_setting.screw_drivers1)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">SCRAPERS</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.scrapers1.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.scrapers1.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.scrapers1.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_setting.scrapers1)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_setting','scrapers1',formFields.truck_load_list.truck_load_setting.scrapers1)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="my-n3">
                        <div class="col-7"><label class="ml-n3">STRING LINE</label></div>
                        <div class="col-5">
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.string_line.fill_replace_add" value="0"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.string_line.fill_replace_add" value="1"></b-form-radio></div>
                            <div class="col-3 mt-2"><b-form-radio :disabled="hideInModal" v-model="formFields.truck_load_list.truck_load_setting.string_line.fill_replace_add" value="2"></b-form-radio></div>
                            <div class=""><button type="button" :class="toggleStatus(formFields.truck_load_list.truck_load_setting.string_line)" v-b-modal.work-order-modal :disabled="hideInModal"
                                                  @click="showWorkOrder('truck_load_setting','string_line',formFields.truck_load_list.truck_load_setting.string_line)">
                                Work Order</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="installation-row justify-content-center mt-2">
                    <div class="d-block col-7">
                        <div class="">
                            <label class="">Sign of Checker:</label>
                            <b-form-input  :disabled="hideInModal"  type="text" size="sm" v-model="formFields.sign_of_checker"></b-form-input>
                        </div>
                        <div class="">
                            <label class="">Sign of Installer:</label>
                            <b-form-input  :disabled="hideInModal"  type="text" size="sm" v-model="formFields.sign_of_installer"></b-form-input>
                        </div>
                    </div>

                </div>

                <div class="installation-row non-print-elm">
                    <div>
                        <button type="button" :disabled="hideInModal" class="btn-info  custom-infobtn-toolbar custom-infobtn-text" @click="printPDF">
                            Print Form
                        </button>
                        <button type="button"  v-if="formFields.id ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1 w-auto px-3 custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled || hideInModal">
                            {{ formFields.id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                        </button>
                    </div>

                </div>

            </div>

        </form>
        <b-modal v-if="!inPDF"
                 id="work-order-modal"
                 size="lg"
                 scrollable
                 >
            <template #modal-footer="{ ok, cancel, hide }">

                <b-button size="sm" variant="primary" @click="setWorkOrder(workOrder);">Add work order
                </b-button>
            </template>
            <div class="installation-row d-block">
                <h5 class="text-center" style="color: #000!important;">WORK ORDER</h5>
                <div>
                    <div class="col-6">
                        <label class="">Date:</label>
                        <b-form-input type="date" size="sm" v-model="workOrder.date" @change="workOrder.date = checkDate(workOrder.date)"></b-form-input>
                        <!--<b-form-input type="text" size="sm" v-model="workOrder.date"></b-form-input>-->
                        <label class="">Day:</label>
                        <b-form-input type="text" size="sm" v-model="workOrder.day"></b-form-input>
                    </div>
                    <div class="col-5">
                        <label class="">Completed Date:</label>
                        <b-form-input type="date" size="sm" v-model="workOrder.completed_date" @change="workOrder.completed_date = checkDate(workOrder.completed_date)"></b-form-input>
                       <!-- <b-form-input type="text" size="sm" v-model="workOrder.completed_date"></b-form-input>
                   -->
                    </div>
                </div>
                <div>
                    <div class="col-6">
                        <label class="">Vehicle Name:</label>
                        <b-form-input type="text" size="sm" v-model="workOrder.vehicle_name"></b-form-input>
                    </div>
                    <div class="col-6">
                        <label class="">Vehicle Number:</label>
                        <b-form-input type="text" v-model="workOrder.vehicle_number" size="sm" ></b-form-input>
                    </div>
                </div>
                <div class="col-12">
                    <label class="">Urgency:</label>
                    <b-form-input type="text" v-model="workOrder.urgency" size="sm" ></b-form-input>
                </div>
                <div class="col-12 mt-2">
                    <label class="">Work Order <br>Description:</label>
                    <b-form-textarea
                            size="sm"
                            rows="2"
                            name="description"
                            no-resize
                            class="w-100"
                            v-model="workOrder.description"
                    ></b-form-textarea>
                </div>
            </div>

        </b-modal>

    </div>

</template>

<script>
    import Toolbar from "./Toolbar";
    import {saveRecord, fetchRecord} from "../../../../helpers/axios";
    import {event, eventBus} from "../../../../event-bus/event-bus";
    import {searchForEmptyDate} from "../../../../helpers/common";

    export default {
        name: "Content",
        props: ['formFields', 'inPDF', 'hideInModal', 'saveDisabled'],
        computed: {
            orders() {
                return this.$store.state.order.recordList;
            },
            isUpdatePermitted(){
                return this.$store.getters.isPermitted({resource:'Installation',action:'update'});
            },
            isCreatePermitted(){
                return this.$store.getters.isPermitted({resource:'Installation',action:'create'});
            },
            getDay() {
                if(this.formFields.date != null){
                    const dayOfWeek = new Date(this.formFields.date).getDay();

                    return isNaN(dayOfWeek) ? null :
                        ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
                }
            },
            checkIFOrderExists: {
                get(){
                    return this.formFields.truck_load_list.order ? this.formFields.truck_load_list.order.family.name_on_stone : '';
                },
                set(value){
                    this.formFields.truck_load_list.order.family.name_on_stone = value;
                }
            }
        },
        data() {
            return {
                workOrder:{
                    date:null,
                    day:null,
                    completed_date:null,
                    vehicle_name:null,
                    vehicle_number:null,
                    urgency:null,
                    description:null,
                },
                workOrderModalData:{},
                axiosParams: {module: 'loader'},
            }
        },
        components:{
            Toolbar
        },
        mounted() {
            this.$store.getters.detectFormChanges();
        },
        methods: {
            getRecord: function (id) {

                if (id) {
                    let record = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == id);
                    if (record != undefined) {
                        this.formFields = {...record};
                    } else {
                        this.axiosParams.id = id;
                        fetchRecord(this.axiosParams, (response) => {
                            this.formFields = response.data;
                        })
                    }
                }
            },

            /** Generic*/
            printPDF() {
                eventBus.$emit(event.PRINT_PDF)
            },
            save() {
                eventBus.$emit(event.SAVE_LOADER);
            },
            getDayOfWeek:function(date) {
                if(date != null){
                    const dayOfWeek = new Date(date).getDay();

                    return isNaN(dayOfWeek) ? null :
                        ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
                }
            },
            showWorkOrder:function(module,submodule,data) {
                this.workOrderModalData.module = module;
                this.workOrderModalData.submodule = submodule;
                this.workOrderModalData.data = {...data}
                this.workOrder = {
                    date:data.date ? data.date: null,
                    day:data.day ? data.day: null,
                    completed_date:data.completed_date ? data.completed_date: null,
                    vehicle_name:data.vehicle_name ? data.vehicle_name: null,
                    vehicle_number:data.vehicle_number ? data.vehicle_number: null,
                    urgency:data.urgency ? data.urgency: null,
                    description:data.description ? data.description: null
                }
            },
            setWorkOrder:function(data) {
                this.workOrderModalData.data = {...data}
                this.formFields.truck_load_list[this.workOrderModalData.module]
                    [this.workOrderModalData.submodule] = {
                    ...this.formFields.truck_load_list[this.workOrderModalData.module][this.workOrderModalData.submodule],...data
                }
                this.$bvModal.hide('work-order-modal');
            },
            toggleStatus: function (val) {

                if((val.date != null && val.date != '') && (val.completed_date != null && val.completed_date != ''))
                    return  'btn custom-success-btn custom-delete-text my-2'
                else if((val.date != null && val.date != '') && (val.completed_date == null || val.completed_date == ''))
                    return  'btn custom-delete-btn custom-delete-text my-2'
                else
                    return  'btn-info custom-infobtn-toolbar custom-infobtn-text my-2'
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
    .header-label{
        font-family: Roboto;
        font-style: normal;
        font-weight: normal;
        font-size: 12px;
        line-height: 14px;
        text-align: center;
        letter-spacing: 0.02em;
        color:#000;
    }
    .installation-row {
        display: flex;
        padding: 0;
    }

    .installation-row div {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }

    .installation-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
        color:#000 !important;
        font-size: 12px;
    }

    .installation-row div input,.input-date {
        border: 1px solid #c4c4c4;
        margin: auto;
        margin-right: 0;
        height: 1.75rem;
        font-size: 0.75rem;
    }
    .installation-row div textarea {
        border: 1px solid #c4c4c4;
    }

    .custom-view-heading{
        font-size: 16px !important;
    }
    .custom-delete-btn {
        background: #DC3545;
        box-shadow: 1px 1px 4px rgb(0 0 0 / 25%);
        border-radius: 5px;
        width: 89px;
        height: 26px;
    }

    .custom-success-btn {
        background: #28a745;
        box-shadow: 1px 1px 4px rgb(0 0 0 / 25%);
        border-radius: 5px;
        width: 89px;
        height: 26px;
        border: white;
    }

    header {
        padding: 0 3rem;
    }

    .input-xl {
        width: 12rem;
    }

    .input-lg {
        width: 10rem;
    }

    .input-md {
        width: 8rem;
    }

    .input-sm {
        width: 6rem;
    }
    .input-xs {
        width: 3.9rem;
    }

    .input-select{
        font-size:12px !important;
        color:#6C757D;
        border: 1px solid #C4C4C4;
        box-sizing: border-box;
        border-radius: 3px;
        height: 1.5rem !important;
        padding: 3px;
        width: 11.8rem;
    }
    .custom-caret-agreement{
        background: #FFF url(http:/images/agreement-icon.png) right 0.75rem center no-repeat;
    }

    .border {
        border: 1px solid #c4c4c4 !important;
    }
    .printing .border {
        border: 1px solid #000 !important;
    }

    /*.printing .form-content{
        width: 100%;
    }
    .printing label, .printing input, .printing textarea{
        font-size: 1.2rem;
    }
    .printing h5, .printing h3{
        font-size: 2rem;
    }
    .printing input, .printing textarea{
        border-color: transparent !important;
        background: transparent !important;
        pointer-events: none;
        height: auto;
    }
    .printing .non-print-elm{
        display: none !important;
    }
    .printing .print-elm{
        display: block !important;
    }*/
</style>
