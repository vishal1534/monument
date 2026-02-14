<template>
    <b-table :fields="productsTableFields" :items="orderProduct" bordered
             responsive="md"
             show-empty small>
        <template #empty="scope">
            No Record
        </template>
        <template #cell(product_number)="row">

            <template
                v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                <label class="d-flex justify-content-center product-table">{{row.item.non_stock_product[0].product_number}}</label>
            </template>

            <template v-if="row.item.monument && row.item.monument.length > 0">
                <label class="d-flex justify-content-center product-table">{{row.item.monument[0].product_number}}</label>
            </template>

            <template v-if="row.item.service && row.item.service.length > 0">
                <label class="d-flex justify-content-center product-table">{{row.item.service[0].product_number}}</label>
            </template>

            <template v-if="row.item.simple && row.item.simple.length > 0">
                <label class="d-flex justify-content-center product-table">{{row.item.simple[0].product_number}}</label>
            </template>

            <template v-if="row.item.composite && row.item.composite.length > 0">
                <label class="d-flex justify-content-center product-table">{{row.item.composite[0].product_number}}</label>
            </template>

        </template>
        <template v-slot:cell(item_name)="row">
            <template
                v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                <label class="d-flex justify-content-center product-table">{{row.item.non_stock_product[0].item_name}}</label>
            </template>

            <template v-if="row.item.monument && row.item.monument.length > 0">
                <label class="d-flex justify-content-center product-table">{{row.item.monument[0].item_name}}</label>
            </template>

            <template v-if="row.item.service && row.item.service.length > 0">
                <label class="d-flex justify-content-center product-table">{{row.item.service[0].item_name}}</label>
            </template>

            <template v-if="row.item.simple && row.item.simple.length > 0">
                <label class="d-flex justify-content-center product-table">{{row.item.simple[0].item_name}}</label>
            </template>

            <template v-if="row.item.composite && row.item.composite.length > 0">
                <label class="d-flex justify-content-center product-table">{{row.item.composite[0].item_name}}</label>
            </template>

        </template>
        <template v-slot:cell(quantity)="row">
            <label class="d-flex product-table"> {{ row.item.quantity }}</label>
        </template>
        <template v-slot:cell(client_price)="row">
            <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                <label class="d-none">{{row.item.client_price > row.item.price ? row.item.client_price : row.item.client_price = row.item.price}}</label>
                <label class="text-nowrap">$ {{ changeNumberFormat(row.item.client_price) ?
                    changeNumberFormat(row.item.client_price) : '0.00' }}</label>
            </template>
            <template v-else>
                <label class="text-nowrap">$ {{ changeNumberFormat(row.item.client_price) ?
                    changeNumberFormat(row.item.client_price) : '0.00' }}</label>
            </template>
        </template>
        <template v-slot:cell(amount)="row">
            <label class="d-none">$ {{ row.item.amount =
                Math.abs((row.item.quantity*row.item.client_price)).toFixed(2) }}</label>
            <label class="text-nowrap">$ {{ changeNumberFormat(row.item.amount) ? changeNumberFormat(row.item.amount) : '0.00' }}</label>
            <input :value="row.item.amount" disabled name="amount" type="hidden">
        </template>
        <template v-slot:cell(installation_price)="row">
            <label class="text-nowrap">$ {{ changeNumberFormat(row.item.installation_price) ?
                changeNumberFormat(row.item.installation_price) : '0.00' }}</label>
        </template>
        <template v-slot:cell(installation_amount)="row">
            <label class="d-none">$ {{
                Math.abs((row.item.quantity * row.item.installation_price)).toFixed(2) }}</label>
            <label class="text-nowrap">$ {{ changeNumberFormat(row.item.quantity * row.item.installation_price) ? changeNumberFormat(row.item.quantity * row.item.installation_price)
                : '0.00' }}</label>
        </template>
        <template v-slot:cell(total)="row">
            <label class="d-none">$ {{ row.item.total = Math.abs(+row.item.amount +
                parseFloat(row.item.installation_price == '' ? 0 :
                row.item.quantity * row.item.installation_price)).toFixed(2) }}</label>
            <label class="text-nowrap">$ {{ changeNumberFormat(row.item.total) ? changeNumberFormat(row.item.total) : '0.00' }}</label>
            <input :value="row.item.total" disabled name="total" type="hidden">
        </template>
        <template v-slot:cell(showProducts)="row">
            <b-button
                @click="row.toggleDetails"
                class="btn btn-sm btn-info order-form-btn py-1 mx-1 "
                size="sm"
                v-if="row.item.iscompositeDetails">
                {{ row.detailsShowing ? 'Hide' : 'Show'}}
            </b-button>
        </template>
        <template v-slot:row-details="row">
            <b-card no-body>
                <table class="table table-sm table-striped table-bordered my-2 ">
                    <thead class="custom-table-header">
                    <tr>
                        <th>Product #</th>
                        <th>Product Name</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Amount</th>
                        <th>Install Price</th>
                        <th>Install Amount</th>
                    </tr>
                    </thead>
                    <tbody class="custom-table-body">
                    <tr v-for="(obj, key) of row.item.composite[0].composite_products">
                        <td>
                            <template v-if="obj.monument && obj.monument.length > 0">
                                <label class="d-flex justify-content-center product-table">{{obj.monument[0].product_number}}</label>
                            </template>
                            <template v-if="obj.service && obj.service.length > 0">
                                <label class="d-flex justify-content-center product-table">{{obj.service[0].product_number}}</label>
                            </template>
                            <template v-if="obj.simple && obj.simple.length > 0">
                                <label class="d-flex justify-content-center product-table">{{obj.simple[0].product_number}}</label>
                            </template>
                        </td>
                        <td>
                            <template v-if="obj.monument && obj.monument.length > 0">
                                <label class="d-flex justify-content-center product-table">{{obj.monument[0].item_name}}</label>
                            </template>
                            <template v-if="obj.service && obj.service.length > 0">
                                <label class="d-flex justify-content-center product-table">{{obj.service[0].item_name}}</label>
                            </template>
                            <template v-if="obj.simple && obj.simple.length > 0">
                                <label class="d-flex justify-content-center product-table">{{obj.simple[0].item_name}}</label>
                            </template>
                        </td>
                        <td>
                            <label class="d-flex justify-content-center product-table">{{row.item.quantity
                                * obj.quantity}}</label>
                        </td>
                        <td>
                            <template v-if="obj.monument && obj.monument.length > 0">
                                <label class="d-flex justify-content-center text-nowrap">$ {{ changeNumberFormat(obj.monument[0].override_selling_price) ?
                                    changeNumberFormat(obj.monument[0].override_selling_price) : '0.00' }}</label>
                            </template>
                            <template v-if="obj.service && obj.service.length > 0">
                                <label class="d-flex justify-content-center text-nowrap">$ {{ changeNumberFormat(obj.service[0].override_selling_price) ?
                                    changeNumberFormat(obj.service[0].override_selling_price) : '0.00' }}</label>
                            </template>
                            <template v-if="obj.simple && obj.simple.length > 0">
                                <label class="d-flex justify-content-center text-nowrap">$ {{ changeNumberFormat(obj.simple[0].override_selling_price) ?
                                    changeNumberFormat(obj.simple[0].override_selling_price) : '0.00' }}</label>
                            </template>
                        </td>
                        <td>
                            <template v-if="obj.monument && obj.monument.length > 0">
                                <label class="d-flex justify-content-center text-nowrap">$ {{ changeNumberFormat(row.item.quantity * obj.quantity * obj.monument[0].override_selling_price) ?
                                    changeNumberFormat(row.item.quantity * obj.quantity * obj.monument[0].override_selling_price) : '0.00' }}</label>
                            </template>
                            <template v-if="obj.service && obj.service.length > 0">
                                <label class="d-flex justify-content-center text-nowrap">$ {{ changeNumberFormat(row.item.quantity * obj.quantity * obj.service[0].override_selling_price) ?
                                    changeNumberFormat(row.item.quantity * obj.quantity * obj.service[0].override_selling_price) : '0.00' }}</label>
                            </template>
                            <template v-if="obj.simple && obj.simple.length > 0">
                                <label class="d-flex justify-content-center text-nowrap">$ {{ changeNumberFormat(row.item.quantity * obj.quantity * obj.simple[0].override_selling_price) ?
                                    changeNumberFormat(row.item.quantity * obj.quantity * obj.simple[0].override_selling_price) : '0.00' }}</label>
                            </template>
                        </td>
                        <td>
                            <label class="d-flex justify-content-center text-nowrap">$ {{ changeNumberFormat(obj.installation_price) ?
                                changeNumberFormat(obj.installation_price) : '0.00' }}</label>
                        </td>
                        <td>
                            <label class="d-flex justify-content-center text-nowrap">$ {{ changeNumberFormat(row.item.quantity * obj.quantity * obj.installation_price) ?
                                changeNumberFormat(row.item.quantity * obj.quantity * obj.installation_price) : '0.00' }}</label>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </b-card>
        </template>

    </b-table>

</template>

<script>
    export default {
        name: "ProductTable",
        props: {
            productsTableFields: {},
            id: {
                type: Number,
                default: null
            },
        },
        data() {
            return {
                axiosParams: {module: 'customerCollaboration'},
            }
        },
        computed: {
            orderProduct: function () {
                let list = this.$store.state[this.axiosParams.module].recordList;
                let record = list.find(obj => obj.id == this.id);
                if (record) {
                    if (record.order.products) {
                        this.$store.getters.changedCompositePrice(record.order.products);
                        this.showCompositeProductDetails(record.order.products);
                        return record.order.products;
                    }
                }
            },
        },
        methods: {
            changeNumberFormat: function (value) {
                return this.$store.getters.changeNumberFormat(value);
            },
            showCompositeProductDetails(products) {
                for (let item of products) {
                    item.iscompositeDetails = false;
                    if (item.composite && item.composite.length > 0)
                        if (item.composite[0].composite_products && item.composite[0].composite_products.length > 0) {
                            item.iscompositeDetails = true;
                        }
                }
            },
        },
    }
</script>

<style scoped>

</style>
