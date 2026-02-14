<template>
    <div :class="divClasses">
        <b-form-input type="text" :class="classes" :disabled="disable"
                      :readonly="readonly" v-model="displayValue" size="sm"
                      @blur="isInputActive = false" @focus="isInputActive = true"/>
    </div>
</template>
<script>
    export default {
        name: "Price",
        props: {
            value: {
                type: Number
            },
            classes:{
                type: String
            },
            divClasses:{
                type: String
            },
            disable:{
                type: Boolean
            },
            readonly:{
                type: Boolean
            }
        },
        data: function() {
            return {
                isInputActive: false
            }
        },
        computed: {
            displayValue: {
                get: function() {
                    if (this.isInputActive) {
                        // Cursor is inside the input field. unformat display value for user
                        return this.value.toString()
                    } else {
                        //console.log("value of price is ",this.value);
                        // User is not modifying now. Format display value for user interface
                        if(this.value !=null && !isNaN(this.value) ) {
                            let value = parseFloat(this.value);
                            return "$ " + value.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,")
                        }else if (isNaN(this.value)){
                            console.log("value is nan")
                            return "$ 0.00"
                        }
                        else
                            return "$ 0.00"
                    }
                },
                set: function(modifiedValue) {
                    // Recalculate value after ignoring "$" and "," in user input
                    let newValue = parseFloat(modifiedValue.replace(/[^\d\.]/g, ""))
                    // Ensure that it is not NaN
                    if (isNaN(newValue)) {
                        newValue = 0
                    }
                    // Note: we cannot set this.value as it is a "prop". It needs to be passed to parent component
                    // $emit the event so that parent component gets it
                    this.$emit('input', parseFloat(newValue))
                }
            }
        }
    }
</script>

<style scoped>
    input{
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.75rem;
    }
    .input-payment{
        width: 17.9rem !important;
        margin-left: 5.1rem;
    }
    .input-price{
        width: 13rem !important;
    }
    .input-price-modal{
        width: 5.4rem;
    }
    .input-cemetery{
        width: 15.7rem !important;
    }
    .input-cemetery-modal{
        width: 12.75rem !important;
    }
    .input-total{
        width:8.0rem;
    }
    .input-lg{
        width: 12rem;
    }
    .input-md{
        width: 6rem;
    }
    .input-sm{
        width: 5.55rem;
    }
</style>


