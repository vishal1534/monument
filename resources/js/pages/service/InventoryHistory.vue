<template>
    <div>
        <div class="bg-toolbar text-center margin-top-left-right h5 p-2">Add or Remove Qty</div>
        <div class="d-flex my-3">
            <label class="mt-2 text-nowrap">Quantity to Add(+0) or Remove(-0)</label>
            <b-form-input type="number" min="0" name="qty_add_or_remove" v-model="formFieldsOne.qty_add_or_remove"
                          class="input-sm ml-2" size="sm"></b-form-input>
        </div>

        <div class="d-flex justify-content-center">
            <button type="button" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" :disabled="saveDisabled"
                    @click="addOrUpdateQty()">
                OK<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
            </button>
            <button type="button" class="btn btn-sm btn-warning mx-3 px-4 custom-dangerbtn-toolbar custom-dangerbtn-text"
                    :disabled="saveDisabled" @click="hideQtyCancel()">
                Cancel<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
            </button>
        </div>

        <div class="bg-toolbar text-center margin-left-right h5 p-2 mt-3">History</div>

        <template>
            <div>
                <b-table small responsive bordered hover striped
                         class="table-font-size"
                         :items="inventory"
                         :fields="quantityMonumentFields" show-empty>

                    <template #empty="scope">
                        No Record
                    </template>
                    <template #cell()="data">
                        <span class="custom-table-body ml-1"> {{ data.value }}</span>
                    </template>
                    <template #cell(date)="data">
                        <span class="custom-table-body ml-1">{{ changeDateFormat(data.item.date) }}</span>
                    </template>

                </b-table>
            </div>
        </template>
    </div>
</template>

<script>
    import {event, eventBus} from "../../event-bus/event-bus";

    export default {
        name: "InventoryHistory",
        props: {
            id: {
                type: Number,
                default: null
            },
            module: {
                type: String,
                default: null
            },
            inventoryName: {
                type: String,
                default: null
            },
            formRecord: {
                type: Array,
                default: null
            }
        },
        data() {
            return {
                quantityMonumentFields: [
                    {key: 'date', label: 'Date'},
                    {key: 'qty_add_or_remove', label: 'Quantity Added/Removed'},
                    {key: 'by_whom', label: 'By'},
                ],
                saveDisabled: false,
                formFieldsOne: {
                    qty_add_or_remove: null,
                    monument_inventory: [],
                    service_inventory: [],
                    simple_inventory: [],
                },
            }
        },
        computed: {
            inventory: function () {
                if (this.id) {
                    let list = this.$store.state[this.module].recordList;
                    let record = list.find(obj => obj.id == this.id);
                    return record[this.inventoryName];
                } else {
                    return this.formRecord
                }
            },
        },
        methods: {
            addOrUpdateQty: function () {
                eventBus.$emit(event.HIDE_INVENTORY_MODEL, this.formFieldsOne.qty_add_or_remove);
            },
            hideQtyCancel: function () {
                this.formFieldsOne.qty_add_or_remove = null;
                eventBus.$emit(event.HIDE_INVENTORY_MODEL_CANCEL, this.formFieldsOne.qty_add_or_remove);
            },
            changeDateFormat: function (value) {
                if (this.id)
                    return this.$store.getters.changeDateFormat(value);
                else
                    return value;
            },
        },
    }
</script>

<style scoped>
    .margin-left-right, .margin-top-left-right {
        margin-left: -1rem;
        margin-right: -1.1rem;
    }

    .margin-top-left-right {
        margin-top: -1rem;
    }

    .table-font-size {
        max-height: calc(68vh - 300px);
        overflow-y: scroll;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
    }
</style>
