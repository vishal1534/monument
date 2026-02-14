<template>
    <div>
        <b-modal id="product-sale-history" size="lg" :header-bg-variant="headerBgVariant"
                 hide-footer>
            <template #modal-header="{ close }">
                <h5 class="m-auto">Sale History</h5>
                <b-button size="sm" class="bg-danger text-light" variant="" @click="close()">
                    <span aria-hidden="true">×</span>
                </b-button>
            </template>

            <b-table small responsive striped hover bordered
                     class="table-font-size"
                     :items="saleHistory"
                     :fields="saleHistoryFields" show-empty>

                <template #empty="scope">
                    No Record
                </template>
                <template #cell()="data">
                    <span class="custom-table-body ml-1"> {{ data.value }}</span>
                </template>
                <template #cell(date)="data">
                    <span class="custom-table-body ml-1"> {{ changeDateFormat(data.item.date) }}</span>
                </template>

            </b-table>

        </b-modal>
    </div>
</template>

<script>
    export default {
        name: "SaleHistory",
        props: {
            recordID: {
                type: Number,
                default: null
            },
            module: {
                type: String,
                default: null
            },
            invoice: {
                type: String,
                default: null
            }
        },
        data() {
            return {
                saleHistoryFields: [
                    {key: 'date', label: 'Date'},
                    {key: 'invoice_number', label: 'Inv. No.'},
                    {key: 'name_on_stone', label: 'Last Name On Stone'},
                    {key: 'name', label: 'Company Name'},
                    {key: 'item_order', label: 'Qty Sold'},
                ],
                tableDate: [
                    {date: '2022', invoice_number: '1010', name_on_stone: 'rashid', company_name: 'company name', qty_sold: '20'}
                ],
                headerBgVariant: 'toolbar',
            }
        },
        computed: {
            saleHistory: function () {
                // let list = this.$store.state[this.module].recordList;
                //  let record = list.find(obj => obj.id == this.recordID);
                let record = this.$store.state[this.module].currentSaleHistory
                if (record) {
                    if (this.invoice == "composite_invoice") {
                        if (record.composite_inventory) {
                            let history = [...record.composite_inventory]
                            for (let key in history) {
                                let obj = {...history[key]}
                                if (Object.keys(obj).indexOf('composite_invoice') > -1) {
                                    obj = {...obj.composite_invoice.order?.family, ...obj}
                                    obj = {...obj.composite_invoice.order?.company, ...obj}
                                }
                                history[key] = obj
                                history[key] = obj
                            }
                            return history;
                        }
                    } else {
                        if (record.sale_history) {
                            let history = [...record.sale_history]
                            for (let key in history) {
                                let obj = {...history[key]}
                                if (Object.keys(obj).indexOf('monument_invoice') > -1) {
                                    obj = {...obj.monument_invoice.order?.family, ...obj}
                                    obj = {...obj.monument_invoice.order?.company, ...obj}
                                } else if (Object.keys(obj).indexOf('service_invoice') > -1) {
                                    obj = {...obj.service_invoice.order?.family, ...obj}
                                    obj = {...obj.service_invoice.order?.company, ...obj}
                                } else if (Object.keys(obj).indexOf('simple_invoice') > -1) {
                                    obj = {...obj.simple_invoice.order?.family, ...obj}
                                    obj = {...obj.simple_invoice.order?.company, ...obj}
                                }
                                history[key] = obj
                                history[key] = obj
                            }
                            return history;
                        }
                    }

                }
            },
        },
        methods: {
            changeDateFormat: function (value) {
                return this.$store.getters.changeDateFormat(value);
            },
        },
    }
</script>

<style scoped>

</style>
