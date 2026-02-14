<template>
    <div>
        <div class="non-print-elm" v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading" style="margin-bottom: 0rem !important;">OC Picture (Porcelain) Production Form</h5>
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

        <PDF :title="'printPorcelainProduction'">
            <div slot="header">
                <div class="d-flex justify-content-center">
                    <h3>OC PICTURE (PORCELAIN) PRODUCTION FORM</h3>
                </div>
            </div>
            <div slot="body">
                <Content :formFields="formData" :inPDF="true"></Content>
            </div>
            <div slot="footer"></div>
        </PDF>

    </div>
</template>

<script>

    import PDF from "../../../../Modules/PDF-Modal";
    import Toolbar from "./Toolbar";
    import Content from "./Content";
    import {event, eventBus} from "../../../../event-bus/event-bus";
    import {deleteRecord, fetchRecord, fetchRecords, firstRecord, lastRecord, nextRecord, previousRecord, saveRecord} from "../../../../helpers/axios";

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
                    date: null,
                    week_of: null,
                    picture_list: [],
                },
                axiosParams: {module: 'productionPicture'},
                saveDisabled: false,
            }
        },
        components: {
            PDF,
            Content,
            Toolbar
        },
        computed: {
            isLoading() {
                return this.$store.state[this.axiosParams.module].busy;
            },
            formData() {
                if (this.formFields.id == 0) {
                    this.formFields.date = this.getCurrentWeek().date;
                    this.formFields.week_of = this.getCurrentWeek().week;
                    this.formFields.total_entries = 0;
                }
                return this.formFields;
            }
        },
        created() {
            eventBus.$on(event.SAVE_PRODUCTION_PICTURE, this.save);
            eventBus.$on(event.DELETE_PRODUCTION_PICTURE, this.deleteRecord);
            eventBus.$on(event.FIRST_PRODUCTION_PICTURE_RECORD, this.first);
            eventBus.$on(event.LAST_PRODUCTION_PICTURE_RECORD, this.last);
            eventBus.$on(event.NEXT_PRODUCTION_PICTURE_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_PRODUCTION_PICTURE_RECORD, this.prev);
            eventBus.$on(event.GET_PRODUCTION_PICTURE, this.getRecord);
            eventBus.$on(event.ADD_PRODUCTION_PICTURE, this.clearForm);
        },
        destroyed() {
            eventBus.$off(event.SAVE_PRODUCTION_PICTURE);
            eventBus.$off(event.DELETE_PRODUCTION_PICTURE);
            eventBus.$off(event.FIRST_PRODUCTION_PICTURE_RECORD);
            eventBus.$off(event.LAST_PRODUCTION_PICTURE_RECORD);
            eventBus.$off(event.NEXT_PRODUCTION_PICTURE_RECORD);
            eventBus.$off(event.PREVIOUS_PRODUCTION_PICTURE_RECORD);
            eventBus.$off(event.GET_PRODUCTION_PICTURE);
            eventBus.$off(event.ADD_PRODUCTION_PICTURE);
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: 'Production', action: 'read'}))
                this.$router.push('/access-denied');
        },
        mounted() {
            this.$store.state[this.axiosParams.module].busy = true
            // this.formFields.store_id = this.storeID
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            this.getColumns();
            this.getRecords();
            if (this.formFields.id > 0) {
                this.getRecord(this.formFields.id);
            }
        },
        methods: {
            /** CRUD */
            getRecord: function (id) {
                if (id) {
                        this.axiosParams.id = id;
                        fetchRecord(this.axiosParams, (response) => {
                            this.formFields = response.data;
                            if (this.$store.state[this.axiosParams.module].recordList.length > 0)
                                this.$store.state[this.axiosParams.module].busy = false
                        }, (error) => {
                            console.log(error)
                            this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                        })
                }
            },
            getRecords() {
                if (!this.hideInModal)
                    this.$store.dispatch('getDropDownInfo', {module: this.axiosParams.module, apiURL: 'getDropDownRecord', page: this.pageNumber})
                fetchRecords({module: 'productionPicture/order'}, (response) => {
                    this.$store.state.order.recordList = response.data;
                }, (error) => {
                    console.log(error)
                    this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                });
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
                        this.axiosParams.data = {
                            id : this.formFields.id,
                            week_of : this.formFields.week_of
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
                                this.formFields = {id: 0, picture_list: []};
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

                const month = currentdate.getMonth() + 1
                const day = String(currentdate.getDate()).padStart(2, '0');
                const year = currentdate.getFullYear();
                // const date = month  + '/'+ day  + '/' + year;
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
                        id: 0,
                        // store_id: this.storeID,
                        date: null,
                        week_of: null,
                        picture_list: []
                    };
                }
            },
        },
        metaInfo() {
            return {
                title: 'OC Picture Production Form'
            }
        },
    }
</script>

<style scoped>
</style>
