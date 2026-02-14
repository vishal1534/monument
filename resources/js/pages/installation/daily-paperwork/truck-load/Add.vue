<template>
    <div>
        <div class="non-print-elm" v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading" style="margin-bottom: 0rem !important;">Daily Load List for Diesel (F-350) Setting Trucks & Setting Box - {{ formFields.id ? 'Edit' : 'Add'}}</h5>
            <div class="bg-toolbar">
                <Toolbar :id="formFields.id" :saveDisabled="saveDisabled"></Toolbar>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <template v-if="isLoading">
                    <div class="text-center text-info my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong>Loading...</strong>
                    </div>
                </template>
                <template v-else>
                    <Content :formFields="formData" :hide-in-modal="hideInModal" :saveDisabled="saveDisabled"></Content>
                </template>
            </div>
        </div>

        <PDF :title="'printTruckLoadList'">
            <div slot="header">
                <div class="d-flex justify-content-center">
                    <h3>Daily Load List for Diesel (F-350) Setting Trucks & Setting Box</h3>
                </div>
            </div>
            <div slot="body">
                <PDFContent :formFields="formData" :inPDF="true"></PDFContent>
            </div>
            <div slot="footer"></div>
        </PDF>

    </div>
</template>

<script>

    import Toolbar from "./Toolbar";
    import PDF from "../../../../Modules/PDF-Modal";
    import {event, eventBus} from "../../../../event-bus/event-bus";
    import Content from "./Content";
    import PDFContent from "./PDFContent";
    import {deleteRecord, fetchRecord, firstRecord, lastRecord, nextRecord, previousRecord, saveRecord} from "../../../../helpers/axios";

    export default {
        name: "Add",
        props: {
            id: {
                type: Number
            },
            install_id: {
                type: String,
                default: null
            },
            hideInModal: {
                type: Boolean,
                default: false
            },
            inPDF: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                pageNumber: 1,
                // storeID : this.$store.getters.getCurrentStoreID,
                family_name_on_stone: null,
                formFields: {
                    // store_id: this.storeID,
                    id: 0,
                    last_name_on_stone: null,
                    truck_load_list: {
                        id: 0,
                        truck_load_maintenance: {
                            id: 0,
                            ck_engine_oil: {id: 0},
                            ck_tire_pressure: {id: 0},
                            ck_oil_level: {id: 0},
                        },
                        truck_load_driver: {
                            id: 0,
                            come_along: {id: 0},
                            roll_rope: {id: 0},
                            xtra_straps: {id: 0},
                            flash_light: {id: 0},
                            crow_bar: {id: 0},
                            sledge: {id: 0},
                            hatchet: {id: 0},
                            crane_control: {id: 0},
                            blue_tool_box: {id: 0},
                            cable_lock: {id: 0},
                            d2_sprayer: {id: 0},
                        },
                        truck_load_passenger: {
                            id: 0,
                            ratchet_srtap_qty11: {id: 0},
                            red_setting_cushions: {id: 0},
                            white_setting_cushions: {id: 0},
                            roll_blue_paper_towels: {id: 0},
                            black_rubber_monument_pads: {id: 0},
                            screw_drivers: {id: 0},
                            pliers: {id: 0},
                            box_knife: {id: 0},
                            tape: {id: 0},
                            tubes_gray_silicone: {id: 0},
                            squirt_bottle_coleman_full: {id: 0},
                            scrub_bush: {id: 0},
                            spray_bottle_windex: {id: 0},
                            ft_level2: {id: 0},
                        },
                        truck_load_inside: {
                            black_blankets: {id: 0},
                            rubbing_paper: {id: 0},
                            jumper_cabels: {id: 0},
                            emergency_stuff: {id: 0},
                            fire_ext: {id: 0},
                            probe: {id: 0},
                            install_check_list: {id: 0},
                            marking_pencil_wax: {id: 0},
                            gray_tarp: {id: 0},
                            tire_repair_kit: {id: 0},
                            bag_for_dirt: {id: 0},
                            monument_tags_cards: {id: 0},
                        },
                        truck_load_back: {
                            setting_dolly: {id: 0},
                            granite_seal: {id: 0},
                            shovel: {id: 0},
                            sharp_shooter_shovel: {id: 0},
                            hoe: {id: 0},
                            rake: {id: 0},
                            pick_ax: {id: 0},
                            ft_level4: {id: 0},
                            manual_post_hole_digger: {id: 0},
                            gas_post_hole_auger: {id: 0},
                            dingo_roller_bar: {id: 0},
                            crane_roller_bar: {id: 0},
                            tamper: {id: 0},
                            wheel_barrow: {id: 0},
                            orange_pinch_bar: {id: 0},
                            blue_roller: {id: 0},
                            two_wheel_chalks: {id: 0},
                            water_buckets: {id: 0},
                            two_by_fours: {id: 0},
                            one_by_fours: {id: 0},
                            grass_seed: {id: 0},
                            bucket_pea_gravel: {id: 0},
                        },
                        truck_load_setting: {
                            gray_silicone_qty: {id: 0},
                            brown_silicone_qty: {id: 0},
                            caulk_gun_qty: {id: 0},
                            tape_measure_qty: {id: 0},
                            torpedo_level: {id: 0},
                            marking_paint: {id: 0},
                            pry_bar: {id: 0},
                            scrapers: {id: 0},
                            box_knife_qty: {id: 0},
                            blades: {id: 0},
                            hand_broom: {id: 0},
                            trowel: {id: 0},
                            masking_tape: {id: 0},
                            scrapers1: {id: 0},
                            screw_drivers1: {id: 0},
                            string_line: {id: 0}
                        }
                    }
                },
                axiosParams: {module: 'loader'},
                axiosParamsInstall: {module: 'loader/getInstall'},
                axiosParamsLoad: {module: 'loader/getLoader'},
                saveDisabled: false,
            }
        },
        components: {
            PDF,
            Content,
            PDFContent,
            Toolbar
        },
        computed: {
            isLoading() {
                return this.$store.state[this.axiosParams.module].busy;
            },
            formData() {
                if (this.formFields.id == 0) {
                    this.formFields.date = this.getCurrentWeek().date;

                }
                if (this.formFields.truck_load_list == null) {
                    this.formFields.truck_load_list = {
                        truck_load_maintenance: null,
                        truck_load_driver: null,
                        truck_load_passenger: null,
                        truck_load_inside: null,
                        truck_load_back: null,
                        truck_load_setting: null
                    };
                }
                if (this.formFields.last_name_on_stone == null)
                    this.formFields.last_name_on_stone = ''

                if (this.formFields.truck_load_list.truck_load_maintenance == null) {
                    this.formFields.truck_load_list.truck_load_maintenance = {
                        id: 0,
                        ck_engine_oil: {id: 0, fill_replace_add: ''},
                        ck_tire_pressure: {id: 0, fill_replace_add: ''},
                        ck_oil_level: {id: 0, fill_replace_add: ''},
                    };
                }
                if (this.formFields.truck_load_list.truck_load_driver == null) {
                    this.formFields.truck_load_list.truck_load_driver = {
                        id: 0,
                        come_along: {id: 0},
                        roll_rope: {id: 0},
                        xtra_straps: {id: 0},
                        flash_light: {id: 0},
                        crow_bar: {id: 0},
                        sledge: {id: 0},
                        hatchet: {id: 0},
                        crane_control: {id: 0},
                        blue_tool_box: {id: 0},
                        cable_lock: {id: 0},
                        d2_sprayer: {id: 0},
                    }
                }
                if (this.formFields.truck_load_list.truck_load_passenger == null) {
                    this.formFields.truck_load_list.truck_load_passenger = {
                        id: 0,
                        ratchet_srtap_qty11: {id: 0},
                        red_setting_cushions: {id: 0},
                        white_setting_cushions: {id: 0},
                        roll_blue_paper_towels: {id: 0},
                        black_rubber_monument_pads: {id: 0},
                        screw_drivers: {id: 0},
                        pliers: {id: 0},
                        box_knife: {id: 0},
                        tape: {id: 0},
                        tubes_gray_silicone: {id: 0},
                        squirt_bottle_coleman_full: {id: 0},
                        scrub_bush: {id: 0},
                        spray_bottle_windex: {id: 0},
                        ft_level2: {id: 0},
                    }
                }
                if (this.formFields.truck_load_list.truck_load_inside == null) {
                    this.formFields.truck_load_list.truck_load_inside = {
                        black_blankets: {id: 0},
                        rubbing_paper: {id: 0},
                        jumper_cabels: {id: 0},
                        emergency_stuff: {id: 0},
                        fire_ext: {id: 0},
                        probe: {id: 0},
                        install_check_list: {id: 0},
                        marking_pencil_wax: {id: 0},
                        gray_tarp: {id: 0},
                        tire_repair_kit: {id: 0},
                        bag_for_dirt: {id: 0},
                        monument_tags_cards: {id: 0},
                    }
                }
                if (this.formFields.truck_load_list.truck_load_back == null) {
                    this.formFields.truck_load_list.truck_load_back = {
                        setting_dolly: {id: 0},
                        granite_seal: {id: 0},
                        shovel: {id: 0},
                        sharp_shooter_shovel: {id: 0},
                        hoe: {id: 0},
                        rake: {id: 0},
                        pick_ax: {id: 0},
                        ft_level4: {id: 0},
                        manual_post_hole_digger: {id: 0},
                        gas_post_hole_auger: {id: 0},
                        dingo_roller_bar: {id: 0},
                        crane_roller_bar: {id: 0},
                        tamper: {id: 0},
                        wheel_barrow: {id: 0},
                        orange_pinch_bar: {id: 0},
                        blue_roller: {id: 0},
                        two_wheel_chalks: {id: 0},
                        water_buckets: {id: 0},
                        two_by_fours: {id: 0},
                        one_by_fours: {id: 0},
                        grass_seed: {id: 0},
                        bucket_pea_gravel: {id: 0}
                    }
                }
                if (this.formFields.truck_load_list.truck_load_setting == null) {
                    this.formFields.truck_load_list.truck_load_setting = {
                        gray_silicone_qty: {id: 0},
                        brown_silicone_qty: {id: 0},
                        caulk_gun_qty: {id: 0},
                        tape_measure_qty: {id: 0},
                        torpedo_level: {id: 0},
                        marking_paint: {id: 0},
                        pry_bar: {id: 0},
                        scrapers: {id: 0},
                        box_knife_qty: {id: 0},
                        blades: {id: 0},
                        hand_broom: {id: 0},
                        trowel: {id: 0},
                        masking_tape: {id: 0},
                        scrapers1: {id: 0},
                        screw_drivers1: {id: 0},
                        string_line: {id: 0}
                    }
                }

                return this.formFields;
            }
        },
        created() {
            eventBus.$on(event.SAVE_LOADER, this.save);
            eventBus.$on(event.DELETE_LOADER, this.deleteRecord);
            eventBus.$on(event.FIRST_LOADER_RECORD, this.first);
            eventBus.$on(event.LAST_LOADER_RECORD, this.last);
            eventBus.$on(event.NEXT_LOADER_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_LOADER_RECORD, this.prev);
            eventBus.$on(event.GET_LOADER, this.getRecord);
            eventBus.$on(event.ADD_LOADER, this.clearForm);
        },
        destroyed() {
            eventBus.$off(event.SAVE_LOADER);
            eventBus.$off(event.DELETE_LOADER);
            eventBus.$off(event.FIRST_LOADER_RECORD,);
            eventBus.$off(event.LAST_LOADER_RECORD);
            eventBus.$off(event.NEXT_LOADER_RECORD);
            eventBus.$off(event.PREVIOUS_LOADER_RECORD);
            eventBus.$off(event.GET_LOADER);
            eventBus.$off(event.ADD_LOADER);
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Installation', action: 'read'}))
                this.$router.push('/access-denied');
        },
        mounted() {
            // this.formFields.store_id = this.storeID
            this.$store.state[this.axiosParams.module].busy = true
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            if (!this.$store.getters.isPermitted({resource: 'Installation', action: 'create'}) && !this.$store.getters.isPermitted({resource: 'Installation', action: 'update'}))
                this.$props.hideInModal = true;
            if (this.formFields.id > 0 && !this.$store.getters.isPermitted({resource: 'Installation', action: 'update'}))
                this.hideinAuth = true;
            this.getColumns();
            this.getRecords();
            if (this.formFields.id > 0)
                this.getRecord(this.formFields.id);
            if (this.$route.query.install_id > 0) {
                this.formFields.install_id = this.$route.query.install_id
                this.getNameOnStone(this.$route.query.install_id)
                this.getLoaderFromInstall(this.$route.query.install_id)
            }
        },
        methods: {
            /** CRUD */
            getRecord: function (id) {
                if (id) {
                    this.axiosParams.id = id;
                    fetchRecord(this.axiosParams, (response) => {
                        this.formFields = response.data;
                        if (response.data.truck_load_list?.order?.family?.name_on_stone) {
                            this.family_name_on_stone = response.data.truck_load_list.order?.family?.name_on_stone
                            this.formFields.last_name_on_stone = response.data.truck_load_list.order?.family?.name_on_stone
                        }
                        if (this.$store.state[this.axiosParams.module].recordList.length > 0)
                            this.$store.state[this.axiosParams.module].busy = false
                        /* this.axiosParams.data = this.formFields;
                         this.$store.commit('appendOrUpdateInRecordList', this.axiosParams);*/
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    })
                }
            },
            getNameOnStone(install_id) {
                this.axiosParamsInstall.id = install_id;
                fetchRecord(this.axiosParamsInstall, (response) => {
                    this.formFields.last_name_on_stone = response.data
                    this.family_name_on_stone = response.data
                })
            },
            getLoaderFromInstall(id) {
                this.axiosParamsLoad.id = id;
                fetchRecord(this.axiosParamsLoad, (response) => {
                    if (response.data[0] != undefined)
                        this.formFields = response.data[0]
                    this.formFields.last_name_on_stone = this.family_name_on_stone
                })
            },
            getRecords() {
                if (!this.hideInModal)
                    this.$store.dispatch('getDropDownInfo', {module: this.axiosParams.module, apiURL: 'getDropDownRecord', page: this.pageNumber})
                /*fetchRecords({module: 'loader/order'}, (response) => {
                    this.$store.state.order.recordList = response.data;
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                });*/
            },
            getColumns() {
                if (this.$store.state[this.axiosParams.module].columnList.length == 0) {
                    this.$store.dispatch('getColumnList', this.axiosParams);
                }
            },
            save() {
                this.saveDisabled = true;
                let data = this.formFields
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: message, variant: 'danger'});
                    } else {
                        let message = `Record Successfully ${this.formFields.id ? 'Updated' : 'Added'}`;
                        this.makeToast({title: 'Success', message: message, variant: 'success'});
                        this.formFields = response.data;
                        // this.axiosParams.data = response.data;
                        this.formFields.last_name_on_stone = this.family_name_on_stone
                        // this.$store.commit('appendOrUpdateInRecordList', this.axiosParams);
                        this.axiosParams.data = {
                            id: this.formFields.id
                        }
                        this.$store.commit('appendOrUpdateDropDown', this.axiosParams)
                    }
                }, (error) => {
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            deleteRecord: function (id) {
                if (confirm("Do you really want to delete this record?")) {
                    this.axiosParams.id = id;
                    deleteRecord(this.axiosParams, (response) => {
                        if (response.data) {
                            this.$store.dispatch('removeRecordFromList', this.axiosParams);
                            this.first()
                            if (this.$store.state[this.axiosParams.module].firstRecord)
                                this.first()
                            else
                                this.formFields = {id: 0, truck_load_list: {}};
                            if (this.$store.state[this.axiosParams.module].recordList.length == 0)
                                this.clearForm();
                        } else {
                            console.log(response.data);
                        }
                    }, (error) => {
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    })
                }
            },

            /** Pagination*/
            first: function () {
                firstRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.formFields = response.data;
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            last: function () {
                lastRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.formFields = response.data;
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            next: function (id) {
                this.axiosParams.id = id;
                nextRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.formFields = response.data;
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },
            prev: function (id) {
                this.axiosParams.id = id;
                previousRecord(this.axiosParams, (response) => {
                    if (Object.keys(response.data).length > 0) {
                        this.formFields = response.data;
                    }
                    this.$store.state[this.axiosParams.module].busy = false
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                })
            },

            /** Generic */
            getCurrentWeek() {
                let currentdate = new Date();
                let oneJan = new Date(currentdate.getFullYear(), 0, 1);
                let numberOfDays = Math.floor((currentdate - oneJan) / (24 * 60 * 60 * 1000));
                let currentWeek = Math.floor((currentdate.getDay() + 1 + numberOfDays) / 7);
                const month = String(currentdate.getMonth() + 1).padStart(2, '0');
                const day = String(currentdate.getDate()).padStart(2, '0');
                const year = currentdate.getFullYear();
                const date = year + '-' + month + "-" + day;
                return {week: currentWeek, date: date};
            },
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
            clearForm: function () {
                if (window.detectChanges && !confirm('You have unsaved changes. Are you sure you want to navigate away?')) {
                    this.$store.state[this.axiosParams.module].busy = false
                } else {
                    window.detectChanges = false;
                }
                if (!window.detectChanges) {
                    this.formFields = {
                        // store_id: this.storeID,
                        id: 0, date: this.getCurrentWeek().date, truck_load_list: {id: 0}
                    };
                }
            },
        },
        metaInfo() {
            return {
                title: 'Daily Truck Load List'
            }
        },
    }
</script>

<style scoped>
</style>
