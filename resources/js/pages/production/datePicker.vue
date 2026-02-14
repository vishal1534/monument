<template>
    <div>
        <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                           @hidden="datePickerHide" @input="formDate = checkDate(formDate)" class="my-auto input-date" close-button
                           locale="en"
                           placeholder=""
                           reset-button
                           size="sm"
                           today-button
                           v-model="formDate">
        </b-form-datepicker>
    </div>
</template>

<script>
    import {searchForEmptyDate} from "../../helpers/common";

    export default {
        name: "datePicker",
        props: ['datePickerRefName', 'formFieldName', 'datePickerProp'],
        data() {
            return {
                formDate: null,
                formField: this.formFieldName,
                customDatePickerRef: this.datePickerRefName,
                customShowHidePicker: this.datePickerProp,
            }
        },
        methods: {
            checkDate: function (date) {
                return searchForEmptyDate(date);
            },
            datePickerHide: function () {
                if (this.formDate == null || this.formDate == '') {
                    this.$emit('open-datePicker', this.customDatePickerRef);
                } else {
                    this.$emit('hide-datePicker', this.datePickerProp);
                    this.formDate = null
                }
            },
        },
        watch: {
            'formDate'(newValue, oldValue) {
                if (newValue != '' && newValue != null)
                    this.$emit('set--date-value-event', newValue, this.formField)
            },
        },
    }
</script>

<style scoped>

</style>
