<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <label>Account No</label>
            </div>

            <div class="col-md-4">
                <label>Date</label>
            </div>

            <div class="col-md-4">
                <label>Invoice No.</label>
            </div>
        </div>

        <div class="row">

            <div class="col-md-4">
                <div class="border p-1 first-row">
                    <label>{{company.data.account_number}}</label>
                </div>
            </div>

            <div class="col-md-4">
                <div class="border p-1 first-row">
                    <label>{{ changeDateFormat(formFields.date) }}</label>
                </div>
            </div>

            <div class="col-md-4">
                <div class="border p-1 first-row">
                    <label>{{invoice.invoice_number}}</label>
                </div>
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label>Company Information</label>
            </div>

            <div class="col-md-1"></div>

            <div class="col-md-5 p-0">
                <label class="ml-n3">Family Information</label>
            </div>

        </div>

        <div class="row mb-3">

            <div class="col-md-6 border p-2 ml-3 d-flex flex-column">
                <label><b>Name:</b> {{company.data.name}}</label>
                <label style="word-break: break-all;"><b>Address:</b> {{company.data.address}}</label>
                <label><b>City:</b> {{company.data.city}}</label>
                <label><b>State:</b> {{company.data.state}}</label>
                <label><b>Email:</b> {{company.data.email}}</label>
            </div>

            <div class="col-md-1 mx-n3"></div>

            <div class="col-md-5 border p-2 d-flex flex-column">
                <label><b>Name on Stone:</b> {{family.name_on_stone}}</label>
                <label><b>Contact:</b> {{family.contact}} </label>
                <label style="word-break: break-all;"><b>Address:</b> {{family.address}}</label>
                <label><b>City:</b> {{family.city}}</label>
                <label><b>Phone:</b> {{family.phone}}</label>
            </div>

        </div>

        <div class="row my-1">
            <div class="col-md-4 offset-md-7">
                <label class="ml-n4"><b>Email:</b> {{family.email}}</label>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "Company-Family-PDF",
        props:{
           company: Object,
            formFields: Object,
            invoice: Object,
            family : Object
        },
        computed:{
        },
        methods:{
            changeDateFormat: function(value){
                return this.$store.getters.changeDateFormat(value);
            },
        },
    }
</script>

<style scoped>
    .border {
        border: 1px solid #c4c4c4 !important;
    }
</style>
