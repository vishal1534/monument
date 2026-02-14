<template>
    <div>
        <div class="non-print-elm" v-if="!hideInModal">
            <h5 class="mx-2 my-1 custom-view-heading" style="margin-bottom: 0rem !important;">Weekly Schedule - {{ formFields.id ? 'Edit' : 'Add'}}</h5>
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
                    <Content :formFields="formData" :hide-in-modal="hideInModal"></Content>
                </template>
            </div>
        </div>

        <PDF :title="'printWeeklySchedule'">
            <div slot="header">
                <div class="d-flex justify-content-center">
                    <h3>WEEKLY SCHEDULE</h3>
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
    import PDF from "../../../Modules/PDF-Modal";
    import {event, eventBus} from "../../../event-bus/event-bus";
    import Content from "./Content";
    import PDFContent from "./PDFContent";
    import {deleteRecord, fetchRecord, fetchRecords, firstRecord, lastRecord, nextRecord, previousRecord, saveRecord} from "../../../helpers/axios";

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
                    weekly_schedule_list: []
                },
                axiosParams: {module: 'weeklySchedule'},
                saveDisabled: false,
            }
        },
        components: {
            PDF,
            Content,
            Toolbar,
            PDFContent
        },
        computed: {
            isLoading() {
                return this.$store.state[this.axiosParams.module].busy;
            },
            formData() {
                if (this.formFields.id == 0) {
                    this.formFields.date = this.getCurrentWeek().date;
                    this.formFields.week_of = this.getCurrentWeek().week;
                }
                return this.formFields;
            }
        },
        created() {
            eventBus.$on(event.SAVE_WEEKLY_SCHEDULE, this.save);
            eventBus.$on(event.DELETE_WEEKLY_SCHEDULE, this.deleteRecord);
            eventBus.$on(event.FIRST_WEEKLY_SCHEDULE_RECORD, this.first);
            eventBus.$on(event.LAST_WEEKLY_SCHEDULE_RECORD, this.last);
            eventBus.$on(event.NEXT_WEEKLY_SCHEDULE_RECORD, this.next);
            eventBus.$on(event.PREVIOUS_WEEKLY_SCHEDULE_RECORD, this.prev);
            eventBus.$on(event.GET_WEEKLY_SCHEDULE, this.getRecord);
            eventBus.$on(event.ADD_WEEKLY_SCHEDULE, this.clearForm);
        },
        destroyed() {
            eventBus.$off(event.SAVE_WEEKLY_SCHEDULE);
            eventBus.$off(event.DELETE_WEEKLY_SCHEDULE);
            eventBus.$off(event.FIRST_WEEKLY_SCHEDULE_RECORD,);
            eventBus.$off(event.LAST_WEEKLY_SCHEDULE_RECORD);
            eventBus.$off(event.NEXT_WEEKLY_SCHEDULE_RECORD);
            eventBus.$off(event.PREVIOUS_WEEKLY_SCHEDULE_RECORD);
            eventBus.$off(event.GET_WEEKLY_SCHEDULE);
            eventBus.$off(event.ADD_WEEKLY_SCHEDULE);
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
                fetchRecords({module: 'weeklySchedule/order'}, (response) => {
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
                                this.formFields = {id: 0, sandblast_list: []};
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
                        this.makeToast({title: 'Error', message: error.response.data.message, variant: 'danger', duration: 3000});
                    })
            },

            /** Generic */
            getCurrentWeek() {
                let currentDate = new Date();
                let oneJan = new Date(currentDate.getFullYear(), 0, 1);
                let numberOfDays = Math.floor((currentDate - oneJan) / (24 * 60 * 60 * 1000));
                let currentWeek = Math.floor((currentDate.getDay() + 1 + numberOfDays) / 7);
                const month = currentDate.getMonth() + 1
                const day = String(currentDate.getDate()).padStart(2, '0');
                const year = currentDate.getFullYear();
                const date = year + '-' + month + "-" + day;
                return {week: currentWeek.toString(), date: date};
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
                        id: 0, weekly_schedule_list: []
                    };
                }
            },
        },
        metaInfo() {
            return {
                title: 'Weekly Schedule'
            }
        },
    }
</script>

<style scoped>
</style>
