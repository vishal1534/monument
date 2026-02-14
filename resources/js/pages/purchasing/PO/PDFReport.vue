<template>

    <div>

        <form class="bg-white rounded mx-2 mb-2 p-3">

            <div class="form-content">

                <div class="installation-row">
                    <div>
                        <b-table  bordered class="printable-truckload-table-border"
                                  :items="modifiedList"
                                  :fields="fields">

                            <template #head()="data">
                                <div class="my-n1 justify-content-center">
                                    <label class="header-label">{{ data.label }}</label>
                                </div>
                            </template>

                            <template #cell(day)="row">
                                <label v-if="row.item.day" class="bg-column px-1 w-100 m-auto">{{getDayOfWeek(row.item.day)}}, ({{getShortDate(row.item.day)}})</label>
                                <label v-if="row.item.person" class="">{{row.item.person}}</label>
                            </template>
                            <template #cell(person)="row">
                                <label class="text-center">{{row.item.person}}</label>
                            </template>
                            <template #cell(cemetery)="row">
                                <label class="text-center">{{row.item.cemetery}}</label>
                            </template>
                            <template #cell(monument_name)="row">
                                <label class="text-center">{{row.item.monument_name}}</label>
                            </template>
                            <template #cell(special_notes)="row">
                                <label class="text-center">{{row.item.special_notes}}</label>
                            </template>
                            <template #cell(approved)="row">
                                <!--<label>{{row.item.approved ? row.item.approved == 1 ? 'YES': 'NO' : ''}}</label>-->
                                <label v-if="row.item.approved && row.item.approved == 1">YES</label>
                                <label v-if="row.item.approved == 0">NO</label>
                            </template>
                            <template #cell(zone)="row">
                                <label>{{ row.item.zone ? row.item.zone : '' }}</label>
                            </template>

                        </b-table>
                    </div>
                </div>
            </div>

        </form>

    </div>

</template>

<script>
    export default {
        name: "Content",
        props: ['formFields', 'inPDF'],
        computed:{
            modifiedList(){
                let record_array = [], product_array = [], print_array = [];
                record_array= [... this.$store.state.PoOrder.recordList];
                //console.log(sorted_array,...this.formFields.weekly_schedule_list)
                for(let i=0; i < record_array.length; i++){
                    if(record_array[i].po_products) {
                        product_array= [... record_array[i].po_products];
                        for (let j = 0; j < product_array.length; j++) {
                            let obj = {},prodobj = {};
                            obj.id = record_array[i].id;
                            obj.date = record_array[i].po_date;
                            if(product_array[j].non_stock_product && product_array[j].non_stock_product.length > 0)
                                prodobj = product_array[j].non_stock_product[0];
                            else if(product_array[j].monument && product_array[j].monument.length > 0)
                                prodobj = product_array[j].monument[0];
                            else if(product_array[j].service && product_array[j].service.length > 0)
                                prodobj = product_array[j].service[0];
                            else if(product_array[j].simple && product_array[j].simple.length > 0)
                                prodobj = product_array[j].simple[0];
                            else if(product_array[j].composite && product_array[j].composite.length > 0)
                                prodobj = product_array[j].composite[0];
                            if(prodobj.type)
                                obj.item_type = prodobj.type.type_title;
                            if(prodobj.specification) {
                                obj.weight = product_array[j].unit_weight;
                                obj.total_weight = product_array[j].total_weight;
                            }
                            obj.product_number = prodobj.product_number;
                            obj.item_name = prodobj.item_name;
                            obj.quantity = product_array[j].quantity;
                            obj.price = product_array[j].cost;
                            obj.amount = product_array[j].amount;
                            obj.notes = product_array[j].notes;
                            if (record_array[i].supplier != null)
                                obj.supplier_name = record_array[i].supplier.supplier_name;
                            print_array.push(obj);
                        }
                    }
                }

                //console.log(structure_array,modified_array);
                return print_array;
            },

        },
        data() {
            return {
                fields: [
                    {
                        key: 'id',
                        label: 'PO#'
                    },
                    {
                        key: 'date',
                        label: 'Date',
                    },
                    {
                        key: 'product_number',
                        label: 'Line Item #',
                    },
                    {
                        key: 'item_name',
                        label: 'Item Name',
                    },
                    {
                        key: 'item_type',
                        label: 'Item Type',
                    },
                    {
                        key: 'price',
                        label: 'Unit Cost',
                    },
                    {
                        key: 'quantity',
                        label: 'Qty',
                    },
                    {
                        key: 'amount',
                        label: 'Amount',
                    },
                    {
                        key: 'weight',
                        label: 'Weight',
                    },
                    {
                        key: 'total_weight',
                        label: 'Total Weight',
                    },
                    {
                        key: 'notes',
                        label: 'Notes',
                    },
                    {
                        key: 'supplier_name',
                        label: 'Supplier',
                    }
                ],
                items: [
                ],
            }
        },
        mounted() {
            console.log(this.$store.state.PoOrder.recordList);
        },
        methods: {
            getShortDate:function(date) {

                if(date != null) {
                    let dd = String(new Date(date).getDate())//.padStart(2, '0');
                    let mm = String(new Date(date).getMonth() + 1)//.padStart(2, '0'); //January is 0!

                    return mm + '/' + dd ;
                }
            },
            checkDate:function(row) {
                if(this.formFields.weekly_schedule_list[row.index].day == "") {
                    this.formFields.weekly_schedule_list[row.index].day = null;
                    console.log(this.formFields.weekly_schedule_list[row.index].day);
                }
            },
            getDayOfWeek:function(date) {
                if(date != null){
                    const dayOfWeek = new Date(date).getDay();

                    return isNaN(dayOfWeek) ? null :
                        ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
                }
            }

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

    .bg-column{
        background-color:#FFF503 !important;
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
    @media print {
        body {
            -webkit-print-color-adjust: exact;
        }

    }


</style>
