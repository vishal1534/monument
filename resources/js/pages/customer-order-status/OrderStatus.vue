<template>
    <div>
        <div>
            <h5 class="mx-2 my-1 custom-view-heading">Customer Portal </h5>
            <div class="bg-toolbar my-2 p-1">
                <Toolbar :customerName="customerName"></Toolbar>
            </div>
        </div>

        <div>
            <Button :orderStatus="true"></Button>
        </div>

        <hr class="my-3">

        <b-form class="div-shadow bg-white rounded mx-2 mb-2">
            <div class="d-flex justify-content-center title-style col-md-12 my-4">
                ORDER STATUS
            </div>

            <b-row class="px-2">
                <b-col lg="2" md="2" sm="2" style="max-width: 9rem;">
                    <label class="ml-1 mt-1" for="inline-form-input-invoice">Invoice No.</label>
                </b-col>
                <b-col lg="2" md="2" sm="2">
                    <b-form-input :value="formFields.order.invoice.invoice_number" class="mb-2" id="inline-form-input-invoice" readonly size="sm"></b-form-input>
                </b-col>

                <b-col class="text-nowrap" lg="2" md="2" sm="2" style="max-width: 9rem;">
                    <label class="mt-1 ml-1" for="inline-form-is-installation">Last Name on Stone</label>
                </b-col>
                <b-col lg="3" md="2" sm="2">
                    <b-form-input :value="formFields.order.family.name_on_stone" class="mb-2" id="inline-form-is-installation"
                                  readonly
                                  size="sm"></b-form-input>
                </b-col>
            </b-row>

            <b-row class="px-2">
                <b-col lg="2" md="2" sm="2" style="max-width: 9rem;">
                    <label class="ml-1 mt-1" for="inline-form-order-status">Order Status</label>
                </b-col>
                <b-col lg="2" md="2" sm="2">
                    <b-form-input :value="formFields.order.order_status != null ? customizeLabel(formFields.order.order_status.title) : '' " class="mb-2" id="inline-form-order-status" readonly size="sm"></b-form-input>
                </b-col>
            </b-row>

            <b-row class="px-2">
                <b-col class="text-nowrap" lg="2" md="2" sm="2" style="max-width: 9rem;">
                    <label class="ml-1 mt-1" for="inline-form-date-promised">Date Promised</label>
                </b-col>
                <b-col lg="2" md="2" sm="2">
                    <b-form-input :value="formFields.order.invoice.date_promised ? changeDateFormate(formFields.order.invoice.date_promised) : ''" class="mb-2"
                                  id="inline-form-date-promised"
                                  readonly size="sm"></b-form-input>
                </b-col>
            </b-row>

            <b-row class="px-2">
                <div class="title-style col-md-12 my-2">
                    <span class="production-title">Order of Production</span>
                    <span class="small-text">(Date indicates production task complete)</span>
                </div>
            </b-row>

            <b-row class="px-2">
                <b-col class="text-nowrap" lg="2" md="2" sm="2" style="max-width: 9rem;">
                    <label class="ml-1 mt-1" for="inline-form-monument-in-stock">Monument in Stock</label>
                </b-col>
                <b-col lg="2" md="2" sm="2">
                    <b-form-input :value="formFields.monument_in_stock ? changeDateFormate(formFields.monument_in_stock) : ''" class="mb-2"
                                  id="inline-form-monument-in-stock" readonly size="sm"></b-form-input>
                </b-col>
            </b-row>

            <b-row class="px-2">
                <b-col class="text-nowrap" lg="2" md="2" sm="2" style="max-width: 9rem;">
                    <label class="ml-1 mt-1" for="inline-form-design-done">Design Done</label>
                </b-col>
                <b-col lg="2" md="2" sm="2">
                    <b-form-input :value="formFields.design_in_house ? changeDateFormate(formFields.design_in_house) : ''" class="mb-2"
                                  id="inline-form-design-done" readonly size="sm"></b-form-input>
                </b-col>
            </b-row>

            <b-row class="px-2">
                <b-col class="text-nowrap" lg="2" md="2" sm="2" style="max-width: 9rem;">
                    <label class="ml-1 mt-1" for="inline-form-customer-signed-proof">Customer Signed Proof</label>
                </b-col>
                <b-col lg="2" md="2" sm="2">
                    <b-form-input :value="formFields.design_customer ? changeDateFormate(formFields.design_customer) : ''" class="mb-2"
                                  id="inline-form-customer-signed-proof" readonly size="sm"></b-form-input>
                </b-col>
            </b-row>

            <b-row class="px-2">
                <b-col class="text-nowrap" lg="2" md="2" sm="2" style="max-width: 9rem;">
                    <label class="ml-1 mt-1" for="inline-form-monument-in-production">Monument in Production</label>
                </b-col>
                <b-col lg="2" md="2" sm="2">
                    <b-form-input :value="showLatestDate(formFields.monument_in_stock, formFields.design_customer)"
                                  class="mb-2"
                                  id="inline-form-monument-in-production" readonly size="sm"></b-form-input>
                </b-col>
            </b-row>

            <b-row class="px-2">
                <b-col class="text-nowrap" lg="2" md="2" sm="2" style="max-width: 9rem;">
                    <label class="ml-1 mt-1" for="inline-form-monument-made">Monument Made</label>
                </b-col>
                <b-col lg="2" md="2" sm="2">
                    <b-form-input :value="formFields.monument_make ? changeDateFormate(formFields.monument_make) : ''" class="mb-2"
                                  id="inline-form-monument-made" readonly size="sm"></b-form-input>
                </b-col>
            </b-row>

            <b-row class="px-2">
                <b-col class="text-nowrap" lg="2" md="2" sm="2" style="max-width: 9rem;">
                    <label class="ml-1 mt-1" for="inline-form-monument-paid">Paid</label>
                </b-col>
                <b-col lg="2" md="2" sm="2">
                    <b-form-input :value="formFields.paid ? changeDateFormate(formFields.paid) : ''" class="mb-2"
                                  id="inline-form-monument-paid" readonly size="sm"></b-form-input>
                </b-col>
            </b-row>

            <b-row class="px-2">
                <b-col class="text-nowrap" lg="2" md="2" sm="2" style="max-width: 9rem;">
                    <label class="ml-1 mt-1" for="inline-form-ready-to-install">Ready to Install</label>
                </b-col>
                <b-col lg="2" md="2" sm="2">
                    <b-form-input :value="formFields.order.installation.grave_flagged ? changeDateFormate(formFields.order.installation.grave_flagged) : ''" class="mb-2"
                                  id="inline-form-ready-to-install" readonly size="sm"></b-form-input>
                </b-col>
            </b-row>

            <b-row class="px-2">
                <b-col class="text-nowrap" lg="2" md="2" sm="2" style="max-width: 9rem;">
                    <label class="ml-1 mt-1" for="inline-form-monument-installed">Monument Installed</label>
                </b-col>
                <b-col lg="2" md="2" sm="2">
                    <b-form-input :value="formFields.order.installation.install_date ? changeDateFormate(formFields.order.installation.install_date) : ''" class="mb-2"
                                  id="inline-form-monument-installed" readonly size="sm"></b-form-input>
                </b-col>
            </b-row>

            <b-row class="px-2">
                <b-col class="text-nowrap" lg="2" md="2" sm="2" style="max-width: 9rem;">
                    <label class="ml-1 mt-1" for="inline-form-order-complete">Order Complete</label>
                </b-col>
                <b-col lg="2" md="2" sm="2">
                    <b-form-input :value="formFields.order.invoice.closed_date ? changeDateFormate(formFields.order.invoice.closed_date) : ''" class="mb-2"
                                  id="inline-form-order-complete" readonly size="sm"></b-form-input>
                </b-col>
            </b-row>

            <b-row class="px-2" v-if="checkCemteryToFlag">
                <b-col class="text-nowrap" lg="2" md="2" sm="2" style="max-width: 9rem;">
                    <label class="ml-1 mt-1" for="inline-form-cemetery-to-flag">Cemetery to Flag</label>
                </b-col>
                <b-col lg="2" md="2" sm="2">
                    <b-form-input :value="formFields.order.installation.cemetery_called_to_flag ? changeDateFormate(formFields.order.installation.cemetery_called_to_flag) : ''" class="mb-2"
                                  id="inline-form-cemetery-to-flag" readonly size="sm"></b-form-input>
                </b-col>
            </b-row>

        </b-form>
    </div>
</template>

<script>
    import {fetchRecord} from "../../helpers/axios";
    import Button from '../customer-dashboard/Button';
    import Toolbar from '../customer-dashboard/Toolbar';
    import moment from 'moment';

    export default {
        name: "OrderStatus",
        props: {
            id: {
                type: Number
            },
            hideInModel: {
                type: Boolean,
                default: false
            },
        },
        data() {
            return {
                formFields: {
                    id: 0,
                    order: {
                        invoice: {},
                        family: {},
                        status: null,
                        installation: {
                            cemetery_called_to_flag: null,
                        },
                        order_status: {},
                    },
                    monument_in_stock: null,
                    design_in_house: null,
                    design_customer: null,
                    monument_make: null,
                    paid: null,
                },
                axiosParams: {module: 'customerOrderStatus'},
                axiosProductionParams: {module: 'customerOrderStatus/production'},
                axiosOrderStatusParams: {module: 'customerOrderStatus/status'},
                searchCompany: "",
                searchCemetery: "",
            }
        },
        beforeCreate() {
            if (!this.$store.getters.isPermitted({resource: "Customer Portal", action: "read"}))
                this.$router.push('/access-denied');
        },
        computed: {
            customerName: function () {
                return this.$store.getters.getUserName;
            },
            checkCemteryToFlag: function () {
                if (this.formFields.order.installation.cemetery_called_to_flag)
                    return true;
            },
        },
        components: {
            Button,
            Toolbar
        },
        mounted() {
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            this.getProduction(this.formFields.id);
        },
        methods: {
            /**
             * CRUD
             */
            getProduction: function (id) {

                if (id) {
                    // Get data from store if exists
                    let record = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == id);
                    if (record != undefined) {
                        this.formFields = {...record};
                    } else {
                        this.axiosProductionParams.id = id;
                        fetchRecord(this.axiosProductionParams, (response) => {
                            this.formFields = response.data;
                        })
                    }
                }
            },
            customizeLabel: function (str) {
                if (str) {
                    let i, labels = str.split('_');
                    for (i = 0; i < labels.length; i++) {
                        labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
                    }
                    return labels.join(' ');
                }
            },
            changeDateFormate: function (value) {
                if (this.checkDateIsValid(value))
                    return moment(String(value)).format('MM/DD/YYYY');
                else
                    return value;
            },
            showLatestDate: function (stockDate, designDate) {
                if (stockDate || designDate) {
                    if ((this.checkDateIsValid(stockDate)) && (this.checkDateIsValid(designDate))) {
                        stockDate = this.changeDateFormate(stockDate);
                        designDate = this.changeDateFormate(designDate);
                        if (stockDate > designDate) {
                            return stockDate;
                        }
                        return designDate;
                    }
                }
            },
            checkDateIsValid: function (value) {
                return new Date(value) !== "Invalid Date" && !isNaN(new Date(value));
                // return moment(value, "YYYY-MM-DD", true).isValid()
            },
        },
    }
</script>

<style scoped>
    .title-style {
        font-size: 24px;
        font-style: normal;
        letter-spacing: 0.02em;
        line-height: 28px;
    }

    @media (min-width: 576px) {
        .form-inline label {
            align-items: flex-start;
            justify-content: left;
        }
    }

    input {
        font-size: 0.75rem;
    }

    .production-title {
        font-weight: 700;
        font-size: 20px;
        line-height: 23px;
    }

    .title-style .small-text {
        font-size: 12px;
        line-height: 14px;
    }
</style>
