<template>
    <div>
        <b-dropdown :disabled="hideInModal" class="border dropdown-width rounded m-auto" no-caret size="sm" style="width: 8.2rem;"
                    variant="none">
            <template #button-content>
                <div class="d-flex product-color">
                    <small :class="customStock == 'Select' ? 'invisible' : '' " :title="`${customStock}`"
                           class="text-custom-width overflow-hidden" v-b-tooltip.hover>{{customStock}}</small>
                    <small class="w-25 ml-auto custom-caret"></small>
                </div>
            </template>
            <b-dropdown-group class="overflow-auto scroll px-1 w-15">
                <b-form-input
                    @keyup.enter="saveCustomText"
                    class="mt-1"
                    placeholder="Custom Text"
                    size="sm"
                    v-model="custom_search"
                ></b-form-input>
                <b-dropdown-divider class="my-1"></b-dropdown-divider>
                <template v-if="customStocks.length > 0">
                    <template v-for="(obj, key) of customStocks">
                        <b-dropdown-group @click="handleDropdownChange">
                            <b-dropdown-item-button :key="key"
                                                    @click="emitSelected(obj.value)">
                                <label class="btn btn-sm m-0 ml-n4 px-1" style="font-size: 12px!important;">{{obj.text}}</label>
                            </b-dropdown-item-button>
                        </b-dropdown-group>
                    </template>
                    <button @click="openDatePicker" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                            type="button">Custom Date
                    </button>
                </template>
                <template v-else>
                    <b-dropdown-text class="text-center small"></b-dropdown-text>
                    <button @click="saveCustomText" class="d-flex m-auto px-3 btn-sm btn-info custom-btn"
                            type="button">Add
                    </button>
                </template>
            </b-dropdown-group>
        </b-dropdown>
    </div>
</template>

<script>
    export default {
        name: "dropDownGroup",
        props: ['customStock', 'customStocks', 'refName', 'fieldName', 'searchFieldName', 'hideInModal', 'pickerShowHide'],
        data() {
            return {
                custom_search: null,
                formFieldName: this.fieldName,
                formSearchFieldName: this.searchFieldName,
                datePickerRef: this.refName,
                showHidePicker: this.pickerShowHide,
            }
        },
        methods: {
            emitSelected: function (value) {
                this.$emit('search-value-event', '', '', value, this.formFieldName, this.formSearchFieldName)
            },
            saveCustomText: function () {
                this.$emit('search-value-event', this.custom_search, 'saveText', '', this.formFieldName, this.formSearchFieldName)
            },
            openDatePicker: function () {
                this.$emit('set-datePicker-true', this.showHidePicker);
                this.$emit('open-datePicker', this.datePickerRef);
            },
            handleDropdownChange: function(value){
                window.detectChanges = true;
            },
        },
        watch: {
            'custom_search'(newValue, oldValue) {
                this.$emit('search-value-event', newValue, '', '', '', this.formSearchFieldName)
            },
        },
    }
</script>

<style scoped>
    input {
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.75rem;
    }
    .text-custom-width {
        width: 5rem;
    }
</style>
