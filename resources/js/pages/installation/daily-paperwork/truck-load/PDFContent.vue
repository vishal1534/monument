<template>

    <div>

        <form class="bg-white rounded mx-2 mb-2 p-3">

            <div class="form-content">

                <div class="installation-row border rounded mb-2">
                    <div class="d-block border-right px-1 pt-1 m-0">
                        <label class="font-weight-bold">Date:</label>
                        <label class="d-block mt-1">{{ changeDateFormat(formFields.date) }}</label>
                    </div>
                    <div class="d-block border-right px-1 pt-1 m-0">
                        <label class="font-weight-bold">Day:</label>
                        <label class="d-block mt-1">{{getDayOfWeek(formFields.date)}}</label>
                    </div>
                    <div class="d-block border-right px-1 pt-1 my-0">
                        <label class="font-weight-bold">Name of Installer:</label>
                        <b-form-input type="text" class="my-1 mx-0" size="sm"
                                      v-model="formFields.name_of_installer"></b-form-input>
                    </div>
                    <div class="d-block px-1">
                        <label class="font-weight-bold">Name of Checker:</label>
                        <b-form-input type="text" class="my-1 mx-0" size="sm"
                                      v-model="formFields.name_of_checker"></b-form-input>
                    </div>
                </div>
                <div class="installation-row">
                    <div>
                        <b-table  bordered class="printable-truckload-table-border" :items="items" :fields="fields">

                            <template #head()="data">
                                <div class="my-n1 justify-content-start">
                                    <label class="font-weight-normal mt-n4">{{ data.label }}</label>
                                </div>
                            </template>
                            <template #head(check_off)="data">
                                <div class="my-n1 justify-content-start">
                                    <label class="font-weight-bold">MAINTENANCE<br> CHECK OFF</label>
                                </div>
                            </template>
                            <template #head(adjust)="data">
                                <div class="my-n1 justify-content-start">
                                    <label><span  class="font-weight-normal">ADJUST</span><br> <span class="font-weight-bold font-italic"> (FILL,REPLACE,ADD)</span></label>
                                </div>
                            </template>
                            <template #cell(check_off)="data">
                                <div  v-if="data.index == 2" style="height: 1.7rem !important">
                                    <label class="mt-n2">CHECK GAS & OIL <br>LEVEL IN TRUCK</label>
                                </div>
                                <div  v-else class="">
                                    <label>{{ data.item.check_off}}</label>
                                </div>
                            </template>
                            <template #cell(date)="data">
                                <div class="my-n1 justify-content-start">
                                    <label>{{ changeDateFormat(formFields.truck_load_list.truck_load_maintenance[data.item.adjust]['date']) }}</label>
                                </div>
                            </template>
                            <template #cell(adjust)="data">
                                <div class="my-n1 justify-content-start">
                                    <label>{{printAdjustValue(formFields.truck_load_list.truck_load_maintenance[data.item.adjust]['fill_replace_add'])}}</label>
                                </div>
                            </template>
                            <template #cell(work_order)="data">
                                <div class="my-n1 justify-content-start">
                                    <p>{{formFields.truck_load_list.truck_load_maintenance[data.item.adjust]['description']}}</p>
                                </div>
                            </template>

                        </b-table>
                    </div>
                </div>

                <div class="installation-row">
                    <div>
                        <b-table  bordered class="printable-truckload-table-border" :items="items1" :fields="fields1">

                            <template #head()="data">
                                <div class="my-n1 justify-content-start">
                                    <label class="font-weight-normal mt-n4">{{ data.label }}</label>
                                </div>
                            </template>
                            <template #head(sand_box)="data">
                                <div class="my-n1 justify-content-start">
                                    <label class="font-weight-bold mt-n4">DRIVER SAND BOX</label>
                                </div>
                            </template>
                            <template #head(adjust)="data">
                                <div class="my-n1 justify-content-start">
                                    <label><span  class="font-weight-normal">ADJUST</span><br> <span class="font-weight-bold font-italic"> (FILL,REPLACE,ADD)</span></label>
                                </div>
                            </template>
                            <template #cell(sand_box)="data">
                                <div  v-if="data.index == 8" style="height: 1.7rem !important">
                                    <label class="mt-n2">BLUE TOOL BOX
                                        <br>MISC TOOLS</label>
                                </div>
                                <div  v-else class="">
                                    <label>{{ data.item.sand_box}}</label>
                                </div>
                            </template>
                            <template #cell(date)="data">
                                <div class="my-n1 justify-content-start">
                                    <label>{{ changeDateFormat(formFields.truck_load_list.truck_load_driver[data.item.adjust]['date']) }}</label>
                                </div>
                            </template>
                            <template #cell(adjust)="data">
                                <div class="my-n1 justify-content-start">
                                    <label>{{printAdjustValue(formFields.truck_load_list.truck_load_driver[data.item.adjust]['fill_replace_add'])}}</label>
                                </div>
                            </template>
                            <template #cell(work_order)="data">
                                <div class="my-n1 justify-content-start">
                                    <p>{{formFields.truck_load_list.truck_load_driver[data.item.adjust]['description']}}</p>
                                </div>
                            </template>

                        </b-table>
                    </div>
                </div>

                <div class="installation-row mt-5" style="page-break-before: always">
                    <div class="installation-row flex-column">
                        <h5 class="mx-2 my-1 text-center font-weight-bold" style="font-size:35px;">Frisbie Monument's
                        </h5>
                    </div>
                </div>
                <div class="installation-row">
                    <div>
                        <b-table  bordered class="printable-truckload-table-border" :items="items2" :fields="fields2">

                            <template #head()="data">
                                <div class="my-n1 justify-content-start">
                                    <label class="font-weight-normal mt-n4">{{ data.label }}</label>
                                </div>
                            </template>
                            <template #head(passenger_box)="data">
                                <div class="my-n1 justify-content-start">
                                    <label class="font-weight-bold">PASSENGER<br> TOOLBOX</label>
                                </div>
                            </template>
                            <template #head(adjust)="data">
                                <div class="my-n1 justify-content-start">
                                    <label><span  class="font-weight-normal">ADJUST</span><br> <span class="font-weight-bold font-italic"> (FILL,REPLACE,ADD)</span></label>
                                </div>
                            </template>
                            <template #cell(passenger_box)="data">
                                <div  v-if="data.index == 0" style="height: 1.7rem !important">
                                    <label class="mt-n2">RATCHET STRAPS<br>QTY. 11</label>
                                </div>
                                <div  v-else-if="data.index == 1" style="height: 1.7rem !important">
                                    <label class="mt-n2">RED SETTING <br> CUSHIONS</label>
                                </div>
                                <div  v-else-if="data.index == 2" style="height: 1.7rem !important">
                                    <label class="mt-n2">WHITE SETTING<br>CUSHIONS</label>
                                </div>
                                <div  v-else-if="data.index == 3" style="height: 1.7rem !important">
                                    <label class="mt-n2">ROLL OF BLUE <br>PAPERTOWELS</label>
                                </div>
                                <div  v-else-if="data.index == 4" style="height: 1.7rem !important">
                                    <label class="mt-n2">BLACK RUBBER <br>MONUMENT PADS</label>
                                </div>
                                <div  v-else-if="data.index == 9" style="height: 1.7rem !important">
                                    <label class="mt-n2">2 TUBES OF GRAY<br>SILICONE</label>
                                </div>
                                <div  v-else-if="data.index == 10" style="height: 1.7rem !important">
                                    <label class="mt-n2">SQUIRT BOTTLE<br>COLEMAN FULL</label>
                                </div>
                                <div  v-else-if="data.index == 12" style="height: 1.7rem !important">
                                    <label class="mt-n2">SPRAY BOTTLE<br>WINDEX</label>
                                </div>
                                <div  v-else class="">
                                    <label>{{ data.item.passenger_box}}</label>
                                </div>
                            </template>
                            <template #cell(date)="data">
                                <div class="my-n1 justify-content-start">
                                    <label>{{ changeDateFormat(formFields.truck_load_list.truck_load_passenger[data.item.adjust]['date']) }}</label>
                                </div>
                            </template>
                            <template #cell(adjust)="data">
                                <div class="my-n1 justify-content-start">
                                    <label>{{printAdjustValue(formFields.truck_load_list.truck_load_passenger[data.item.adjust]['fill_replace_add'])}}</label>
                                </div>
                            </template>
                            <template #cell(work_order)="data">
                                <div class="my-n1 justify-content-start">
                                    <p>{{formFields.truck_load_list.truck_load_passenger[data.item.adjust]['description']}}</p>
                                </div>
                            </template>

                        </b-table>
                    </div>
                </div>

                <div class="installation-row mt-5" style="page-break-before: always">
                    <div class="installation-row flex-column">
                        <h5 class="mx-2 mt-n4 text-center font-weight-bold" style="font-size:35px;">Frisbie Monument's
                        </h5>
                    </div>
                </div>
                <div class="installation-row">
                    <div>
                        <b-table  bordered class="printable-truckload-table-border" :items="items3" :fields="fields3">

                            <template #head()="data">
                                <div class="my-n1 justify-content-start">
                                    <label class="font-weight-normal mt-n4">{{ data.label }}</label>
                                </div>
                            </template>
                            <template #head(inside_truck)="data">
                                <div class="my-n1 justify-content-start">
                                    <label class="font-weight-bold">INSIDE TRUCK<br> CAB</label>
                                </div>
                            </template>
                            <template #head(adjust)="data">
                                <div class="my-n1 justify-content-start">
                                    <label><span  class="font-weight-normal">ADJUST</span><br> <span class="font-weight-bold font-italic"> (FILL,REPLACE,ADD)</span></label>
                                </div>
                            </template>
                            <template #cell(inside_truck)="data">
                                <div  v-if="data.index == 0" style="height: 1.7rem !important">
                                    <label class="mt-n2">BLACK BLANKETS <br> QTY. 2</label>
                                </div>
                                <div  v-else-if="data.index == 6" style="height: 1.7rem !important">
                                    <label class="mt-n2">INSTALL CK LIST <br> AND CATALOGS</label>
                                </div>
                                <div  v-else-if="data.index == 7" style="height: 3.2rem !important">
                                    <label class="mt-n2">MARKING PENCIL <br> WAX PENCILS qty3
                                        <br> (red, white & yellow)</label>
                                </div>
                                <div  v-else-if="data.index == 11" style="height: 1.7rem !important">
                                    <label class="mt-n2">MONUMENT TAGS &
                                        <br> BUSINESS CARDS</label>
                                </div>
                                <div  v-else class="">
                                    <label>{{ data.item.inside_truck}}</label>
                                </div>
                            </template>
                            <template #cell(date)="data">
                                <div class="my-n1 justify-content-start">
                                    <label>{{ changeDateFormat(formFields.truck_load_list.truck_load_inside[data.item.adjust]['date']) }}</label>
                                </div>
                            </template>
                            <template #cell(adjust)="data">
                                <div class="my-n1 justify-content-start">
                                    <label>{{printAdjustValue(formFields.truck_load_list.truck_load_inside[data.item.adjust]['fill_replace_add'])}}</label>
                                </div>
                            </template>
                            <template #cell(work_order)="data">
                                <div class="my-n1 justify-content-start">
                                    <p>{{formFields.truck_load_list.truck_load_inside[data.item.adjust]['description']}}</p>
                                </div>
                            </template>

                        </b-table>
                    </div>
                </div>
                <div class="installation-row mt-n1">
                    <div>
                        <b-table  bordered class="printable-truckload-table-border" :items="items4" :fields="fields4">

                            <template #head()="data">
                                <div class="my-n1 justify-content-start">
                                    <label class="font-weight-normal mt-n4">{{ data.label }}</label>
                                </div>
                            </template>
                            <template #head(back_of_truck)="data">
                                <div class="my-n1 justify-content-start">
                                    <label class="font-weight-bold mt-n4">ON BACK OF <br>TRUCK</label>
                                </div>
                            </template>
                            <template #head(adjust)="data">
                                <div class="my-n1 justify-content-start">
                                    <label><span  class="font-weight-normal">ADJUST</span><br> <span class="font-weight-bold font-italic"> (FILL,REPLACE,ADD)</span></label>
                                </div>
                            </template>
                            <template #cell(back_of_truck)="data">
                                <div  v-if="data.index == 0" style="height: 1.7rem !important">
                                    <label class="mt-n2">SETTING DOLLY
                                        <br><span class="font-weight-bold font-italic"> CK TIRE PRESURE</span></label>
                                </div>
                                <div  v-else-if="data.index == 3" style="height: 1.7rem !important">
                                    <label class="mt-n2">SHARP SHOOTER <br>SHOVEL</label>
                                </div>
                                <div  v-else class="">
                                    <label>{{ data.item.back_of_truck}}</label>
                                </div>
                            </template>
                            <template #cell(date)="data">
                                <div class="my-n1 justify-content-start">
                                    <label>{{ changeDateFormat(formFields.truck_load_list.truck_load_back[data.item.adjust]['date']) }}</label>
                                </div>
                            </template>
                            <template #cell(adjust)="data">
                                <div class="my-n1 justify-content-start">
                                    <label>{{printAdjustValue(formFields.truck_load_list.truck_load_back[data.item.adjust]['fill_replace_add'])}}</label>
                                </div>
                            </template>
                            <template #cell(work_order)="data">
                                <div class="my-n1 justify-content-start">
                                    <p>{{formFields.truck_load_list.truck_load_back[data.item.adjust]['description']}}</p>
                                </div>
                            </template>

                        </b-table>
                    </div>
                </div>

                <div class="installation-row mt-5" style="page-break-before: always">
                    <div class="installation-row flex-column">
                        <h5 class="mx-2 my-1 text-center font-weight-bold" style="font-size:35px;">Frisbie Monument's
                        </h5>
                    </div>
                </div>
                <div class="installation-row">
                    <div>
                        <b-table  bordered class="printable-truckload-table-border" :items="items5" :fields="fields5">

                            <template #head()="data">
                                <div class="my-n1 justify-content-start">
                                    <label class="font-weight-normal mt-n4">{{ data.label }}</label>
                                </div>
                            </template>
                            <template #head(back_of_truck)="data">
                                <div class="my-n1 justify-content-start">
                                    <label class="font-weight-bold mt-n4">ON BACK OF <br>TRUCK</label>
                                </div>
                            </template>
                            <template #head(adjust)="data">
                                <div class="my-n1 justify-content-start">
                                    <label><span  class="font-weight-normal">ADJUST</span><br> <span class="font-weight-bold font-italic"> (FILL,REPLACE,ADD)</span></label>
                                </div>
                            </template>
                            <template #cell(back_of_truck)="data">
                                <div  v-if="data.index == 3" style="height: 1.7rem !important">
                                    <label class="mt-n2">MANUAL POST HOLE <br>DIGGER</label>
                                </div>
                                <div  v-else-if="data.index == 4" style="height: 1.7rem !important">
                                    <label class="mt-n2">GAS POST HOLE AUGER
                                        <br><span class="font-weight-bold font-italic">(CK GAS)</span></label>
                                </div>
                                <div  v-else-if="data.index == 8" style="height: 1.7rem !important">
                                    <label class="mt-n2">WHEEL BARROW
                                        <br><span class="font-weight-bold font-italic">CK TIRE PRESURE</span></label>
                                </div>
                                <div  v-else-if="data.index == 12" style="height: 1.7rem !important">
                                    <label class="mt-n2">WATER BUCKETS<br>QTY. 3</label>
                                </div>
                                <div  v-else-if="data.index == 15" style="height: 1.7rem !important">
                                    <label class="mt-n2">GRASS SEED
                                        <br><span class="font-weight-bold font-italic">(IN FOLGERS CAN)</span></label>
                                </div>
                                <div  v-else-if="data.index == 16" style="height: 1.7rem !important">
                                    <label class="mt-n2">BUCKET OF PEA<br> GRAVEL</label>
                                </div>
                                <div  v-else class="">
                                    <label>{{ data.item.back_of_truck}}</label>
                                </div>
                            </template>
                            <template #cell(date)="data">
                                <div class="my-n1 justify-content-start">
                                    <label>{{ changeDateFormat(formFields.truck_load_list.truck_load_back[data.item.adjust]['date']) }}</label>
                                </div>
                            </template>
                            <template #cell(adjust)="data">
                                <div class="my-n1 justify-content-start">
                                    <label>{{printAdjustValue(formFields.truck_load_list.truck_load_back[data.item.adjust]['fill_replace_add'])}}</label>
                                </div>
                            </template>
                            <template #cell(work_order)="data">
                                <div class="my-n1 justify-content-start">
                                    <p>{{formFields.truck_load_list.truck_load_back[data.item.adjust]['description']}}</p>
                                </div>
                            </template>

                        </b-table>
                    </div>
                </div>

                <div class="installation-row mt-5" style="page-break-before: always">
                    <div class="installation-row flex-column">
                        <h5 class="mx-2 my-1 text-center font-weight-bold" style="font-size:35px;">Frisbie Monument's
                        </h5>
                    </div>
                </div>
                <div class="installation-row">
                    <div>
                        <b-table  bordered class="printable-truckload-table-border" :items="items6" :fields="fields6">

                            <template #head()="data">
                                <div class="my-n1 justify-content-start">
                                    <label class="font-weight-normal mt-n4">{{ data.label }}</label>
                                </div>
                            </template>
                            <template #head(setting_box)="data">
                                <div class="my-n1 justify-content-start">
                                    <label class="font-weight-bold">SETTING TOOL<br> BOX</label>
                                </div>
                            </template>
                            <template #head(adjust)="data">
                                <div class="my-n1 justify-content-start">
                                    <label><span  class="font-weight-normal">ADJUST</span><br> <span class="font-weight-bold font-italic"> (FILL,REPLACE,ADD)</span></label>
                                </div>
                            </template>
                            <template #cell(setting_box)="data">
                                <div  v-if="data.index == 0" style="height: 1.7rem !important">
                                    <label class="mt-n2">GRAY SILICONE <br>QTY 2 TUBES</label>
                                </div>
                                <div  v-else-if="data.index == 1" style="height: 1.7rem !important">
                                    <label class="mt-n2">BROWN SILICONE <br>QTY. 2 TUBES</label>
                                </div>
                                <div v-else-if="data.index == 2" style="height: 1.7rem !important">
                                    <label class="mt-n2">CAULK GUN <br> QTY. 2</label>
                                </div>
                                <div v-else-if="data.index == 3" style="height: 1.7rem !important">
                                    <label class="mt-n2">TAPE MEASURE <br>QTY. 2</label>
                                </div>
                                <div  v-else-if="data.index == 8" style="height: 1.7rem !important">
                                    <label class="mt-n2">BOX KNIFE <br> QTY. 2</label>
                                </div>
                                <div  v-else class="">
                                    <label>{{ data.item.setting_box}}</label>
                                </div>
                            </template>
                            <template #cell(date)="data">
                                <div class="my-n1 justify-content-start">
                                    <label>{{ changeDateFormat(formFields.truck_load_list.truck_load_setting[data.item.adjust]['date']) }}</label>
                                </div>
                            </template>
                            <template #cell(adjust)="data">
                                <div class="my-n1 justify-content-start">
                                    <label>{{printAdjustValue(formFields.truck_load_list.truck_load_setting[data.item.adjust]['fill_replace_add'])}}</label>
                                </div>
                            </template>
                            <template #cell(work_order)="data">
                                <div class="my-n1 justify-content-start">
                                    <p>{{formFields.truck_load_list.truck_load_setting[data.item.adjust]['description']}}</p>
                                </div>
                            </template>

                        </b-table>
                    </div>
                </div>

                <div class="installation-row justify-content-center mt-2">
                    <div class="d-block col-7">
                        <div class="">
                            <label class="">Sign of Checker:</label>
                            <b-form-input type="text" size="sm" v-model="formFields.sign_of_checker"></b-form-input>
                        </div>
                        <div class="">
                            <label class="">Sign of Installer:</label>
                            <b-form-input type="text" size="sm" v-model="formFields.sign_of_installer"></b-form-input>
                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>

</template>

<script>
    export default {
        name: "Content",
        props: ['formFields', 'inPdf'],
        data() {
            return {
                fields: [
                    {
                        key: 'check_off',
                        label: 'CHECK OFF',
                    },
                    {
                        key: 'date',
                        label: 'Date:',
                    },
                    {
                        key: 'adjust',
                        label: 'ADJUST',
                    },
                    {
                        key: 'work_order',
                        label: 'WORK ORDER',
                    },
                ],
                items: [
                    {check_off:'CK ENGINE OIL',adjust:'ck_engine_oil'},{check_off:'CK TIRE PRESSURE',adjust:'ck_tire_pressure'},{check_off:'CHECK GAS & OIL <br>LEVEL IN TRUCK',adjust:'ck_oil_level'}
                ],
                fields1: [
                    {
                        key: 'sand_box',
                        label: 'DRIVER SAND BOX',
                    },
                    {
                        key: 'date',
                        label: 'Date:',
                    },
                    {
                        key: 'adjust',
                        label: 'ADJUST',
                    },
                    {
                        key: 'work_order',
                        label: 'WORK ORDER',
                    },
                ],
                items1: [
                    {sand_box:'COME ALONG',adjust:'come_along'},{sand_box:'ROLL OFF ROPE',adjust:'roll_rope'},{sand_box:'XTRA STRAPS',adjust:'xtra_straps'},
                    {sand_box:'FLASH LIGHT',adjust:'flash_light'},{sand_box:'CROW BAR',adjust:'crow_bar'},{sand_box:'5lbs. SLEDGE',adjust:'sledge'},
                    {sand_box:'HATCHET',adjust:'hatchet'},{sand_box:'CRANE CONTROL',adjust:'crane_control'},{sand_box:'BLUE TOOL BOX MISC TOOLS',adjust:'blue_tool_box'},
                    {sand_box:'CABLE AND LOCK',adjust:'cable_lock'},{sand_box:'D2 SPRAYER',adjust:'d2_sprayer'}
                ],
                fields2: [
                    {
                        key: 'passenger_box',
                        label: 'PASSENGER TOOLBOX',
                    },
                    {
                        key: 'date',
                        label: 'Date:',
                    },
                    {
                        key: 'adjust',
                        label: 'ADJUST',
                    },
                    {
                        key: 'work_order',
                        label: 'WORK ORDER',
                    },
                ],
                items2: [
                    {passenger_box:'RATCHET STRAPS QTY. 11',adjust:'ratchet_srtap_qty11'},{passenger_box:'RED SETTING CUSHIONS',adjust:'red_setting_cushions'},{passenger_box:'WHITE SETTING CUSHIONS',adjust:'white_setting_cushions'},
                    {passenger_box:'ROLL OF BLUE PAPERTOWELS',adjust:'roll_blue_paper_towels'},{passenger_box:'BLACK RUBBER MONUMENT PADS',adjust:'black_rubber_monument_pads'},{passenger_box:'SCREW DRIVERS',adjust:'screw_drivers'},
                    {passenger_box:'PLIERS',adjust:'pliers'},{passenger_box:'BOX KNIFE',adjust:'box_knife'},{passenger_box:'TAPE',adjust:'tape'}, {passenger_box:'2 TUBES OF GRAY SILICONE',adjust:'tubes_gray_silicone'},
                    {passenger_box:'SQUIRT BOTTLE COLEMAN FULL',adjust:'squirt_bottle_coleman_full'},{passenger_box:'SCRUB BUSH',adjust:'scrub_bush'},{passenger_box:'SPRAY BOTTLE WINDEX',adjust:'spray_bottle_windex'},{passenger_box:'2FT LEVEL',adjust:'ft_level2'}
                ],
                fields3: [
                    {
                        key: 'inside_truck',
                        label: 'INSIDE TRUCK CAB',
                    },
                    {
                        key: 'date',
                        label: 'Date:',
                    },
                    {
                        key: 'adjust',
                        label: 'ADJUST',
                    },
                    {
                        key: 'work_order',
                        label: 'WORK ORDER',
                    },
                ],
                items3: [
                    {inside_truck:'BLACK BLANKETS QTY. 2',adjust:'black_blankets'},{inside_truck:'RUBBING PAPER',adjust:'rubbing_paper'},{inside_truck:'JUMPER CABLES',adjust:'jumper_cabels'},
                    {inside_truck:'EMERGENCY STUFF',adjust:'emergency_stuff'},{inside_truck:'FIRE EXT.',adjust:'fire_ext'},{inside_truck:'PROBE',adjust:'probe'},
                    {inside_truck:'INSTALL CK LIST AND CATALOGS',adjust:'install_check_list'},{inside_truck:'MARKING PENCIL WAX PENCILS qty3(red, white & yellow)',adjust:'marking_pencil_wax'},{inside_truck:'GRAY TARP',adjust:'gray_tarp'},
                    {inside_truck:'TIRE REPAIR KIT',adjust:'tire_repair_kit'},{inside_truck:'BAG IT BAG FOR DIRT',adjust:'bag_for_dirt'},{inside_truck:'MONUMENT TAGS & BUSINESS CARDS',adjust:'monument_tags_cards'}
                ],
                fields4: [
                    {
                        key: 'back_of_truck',
                        label: 'ON BACK OF TRUCK',
                    },
                    {
                        key: 'date',
                        label: 'Date:',
                    },
                    {
                        key: 'adjust',
                        label: 'ADJUST',
                    },
                    {
                        key: 'work_order',
                        label: 'WORK ORDER',
                    },
                ],
                items4: [
                    {back_of_truck:'SETTING DOLLY CK TIRE PRESURE',adjust:'setting_dolly'},{back_of_truck:'GRANITE SEAL,',adjust:'granite_seal'},{back_of_truck:'SHOVEL',adjust:'shovel'},
                    {back_of_truck:'SHARP SHOOTER SHOVEL',adjust:'sharp_shooter_shovel'},{back_of_truck:'HOE',adjust:'hoe'}
                ],
                fields5: [
                    {
                        key: 'back_of_truck',
                        label: 'ON BACK OF TRUCK',
                    },
                    {
                        key: 'date',
                        label: 'Date:',
                    },
                    {
                        key: 'adjust',
                        label: 'ADJUST',
                    },
                    {
                        key: 'work_order',
                        label: 'WORK ORDER',
                    },
                ],
                items5: [
                    {back_of_truck:'RAKE',adjust:'rake'},{back_of_truck:'PICK AX',adjust:'pick_ax'},{back_of_truck:'4FT LEVEL',adjust:'ft_level4'},
                    {back_of_truck:'MANUAL POST HOLE DIGGER',adjust:'manual_post_hole_digger'},{back_of_truck:'GAS POST HOLE AUGER (CK GAS)',adjust:'gas_post_hole_auger'},
                    {back_of_truck:'DINGO ROLLER BAR',adjust:'dingo_roller_bar'},{back_of_truck:'CRANE ROLLER BAR',adjust:'crane_roller_bar'},{back_of_truck:'TAMPER',adjust:'tamper'},
                    {back_of_truck:'WHEEL BARROW CK TIRE PRESURE',adjust:'wheel_barrow'},{back_of_truck:'ORANGE PINCH BAR',adjust:'orange_pinch_bar'},
                    {back_of_truck:'BLUE ROLLER',adjust:'blue_roller'}, {back_of_truck:'2 WHEEL CHALKS',adjust:'two_wheel_chalks'},{back_of_truck:'WATER BUCKETS QTY. 3',adjust:'water_buckets'},
                    {back_of_truck:'2x4’s',adjust:'two_by_fours'},{back_of_truck:'1x4’s',adjust:'one_by_fours'},{back_of_truck:'GRASS SEED (IN FOLGERS CAN)',adjust:'grass_seed'},
                    {back_of_truck:'BUCKET OF PEA GRAVEL',adjust:'bucket_pea_gravel'}
                ],
                fields6: [
                    {
                        key: 'setting_box',
                        label: 'SETTING TOOL BOX',
                    },
                    {
                        key: 'date',
                        label: 'Date:',
                    },
                    {
                        key: 'adjust',
                        label: 'ADJUST',
                    },
                    {
                        key: 'work_order',
                        label: 'WORK ORDER',
                    },
                ],
                items6: [
                    {setting_box:'GRAY SILICONE QTY 2 TUBES',adjust:'gray_silicone_qty'},{setting_box:'BROWN SILICONE QTY. 2 TUBES',adjust:'brown_silicone_qty'},{setting_box:'CAULK GUN QTY. 2S',adjust:'caulk_gun_qty'},
                    {setting_box:'TAPE MEASURE QTY. 2',adjust:'tape_measure_qty'},{setting_box:'TORPEDO LEVEL',adjust:'torpedo_level'},{setting_box:'MARKING PAINT',adjust:'marking_paint'},
                    {setting_box:'PRY BAR',adjust:'pry_bar'},{setting_box:'SCRAPERS',adjust:'scrapers'},{setting_box:'BOX KNIFE QTY. 2',adjust:'box_knife_qty'}, {setting_box:'BLADES',adjust:'blades'},
                    {setting_box:'HAND BROOM',adjust:'hand_broom'},{setting_box:'TROWEL',adjust:'trowel'},{setting_box:'MASKING TAPE',adjust:'masking_tape'},{setting_box:'SCREW DRIVERS',adjust:'screw_drivers1'},
                    {setting_box:'SCRAPERS',adjust:'scrapers1'},{setting_box:'STRING LINE',adjust:'string_line'}
                ]
            }
        },
        methods: {
            printAdjustValue(val) {
                if(val == 0)
                    return 'FILL'
                else if(val == 1)
                    return 'REPLACE'
                else if(val == 2)
                    return 'ADD'
                else
                    return ''
            },
            getDayOfWeek:function(date) {
                if(date != null){
                    const dayOfWeek = new Date(date).getDay();

                    return isNaN(dayOfWeek) ? null :
                        ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
                }
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

    .installation-row div input {
        border: 1px solid #c4c4c4;
        margin: auto;
        margin-right: 0;
        height: 1.5rem;
    }
    .installation-row div textarea {
        border: 1px solid #c4c4c4;
    }

    .custom-view-heading{
        font-size: 16px !important;
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
    .border-right {
        border-right: 1px solid #000 !important;
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
