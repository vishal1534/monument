<template>

    <div>

        <div class="installation-row">
            <label class="mx-auto text-red font-weight-bold">OFFICE USE ONLY</label>
        </div>
        <div class="installation-row">
            <label class="mx-auto text-purple font-weight-bold">CEMETERY CONFIRMATION</label>
        </div>

        <div class="installation-row my-2">
            <label class="font-weight-bold">** Does the Cemetery need to be called to confirm PLACEMENT of Monument: YES / NO</label>
        </div>
        <div class="installation-row">
            <label class="font-weight-bold">** Is PLACEMENT different then above: YES / NO</label>
        </div>
        <div class="installation-row my-2">
            <div>
                <label class="font-weight-bold">If Yes, What is the New Information:</label>
                <div class="installation-custom-border-bottom"></div>
            </div>
        </div>
        <div class="installation-row">
            <label class="font-weight-bold">** Does the Cemetery Need to be Called to Confirm FACING of Monument: YES / NO</label>
        </div>
        <div class="installation-row my-2">
            <label class="font-weight-bold">** Is FACING Different Then Above: YES / NO</label>
        </div>
        <div class="installation-row my-2">
            <div>
                <label class="font-weight-bold">If Yes, What is the New Information:</label>
               <div class="installation-custom-border-bottom"></div>
            </div>
        </div>

        <div class="installation-row my-2">
            <label class="font-weight-bold text-purple">CEMETERY & PAYMENT INFORMATION</label>
        </div>
        <div class="installation-row">
            <div>
                <label class="font-weight-bold">Make Check Payable to:</label>
                <div class="installation-custom-border-bottom"></div>
            </div>
        </div>
        <div class="installation-row my-2">
            <div>
                <label class="font-weight-bold">Mailing Address:</label>
                <div class="installation-custom-border-bottom"></div>
            </div>
        </div>
        <div class="installation-row">
            <div>
                <label class="font-weight-bold">City:</label>
                <div class="installation-custom-border-bottom"></div>
            </div>
            <div class="w-50">
                <label class="font-weight-bold">State:</label>
                <div class="installation-custom-border-bottom"></div>
            </div>
            <div class="w-25">
                <label class="font-weight-bold">Zip:</label>
                <div class="installation-custom-border-bottom"></div>
            </div>
        </div>
        <div class="installation-row my-2">
            <div>
                <label class="font-weight-bold">Cemetery Fees: $</label>
                <div class="installation-custom-border-bottom"></div>
            </div>
            <div>
                <label class="font-weight-bold">Check Wrote on:</label>
                <div class="installation-custom-border-bottom"></div>
            </div>
        </div>
        <div class="installation-row">
            <div class="w-50 mx-auto">
                <label class="font-weight-bold">()Mailed</label>
                <div class="installation-custom-border-bottom"></div>
                <label class="font-weight-bold">()Takes(ing) to Jobsite</label>
                <div class="installation-custom-border-bottom"></div>
            </div>
        </div>


        <div class="installation-row my-2">
            <label class="mx-auto text-purple font-weight-bold">FLAGGING</label>
        </div>
        <div class="installation-row flex-column">
            <div>
                <label class="font-weight-bold ">Has Cemetery Been Called: YES / NO</label>
                <div class="installation-custom-border-bottom"></div>
            </div>
            <div>
                <label class="font-weight-bold">Has the Grave Been Flagged: YES / NO</label>
                <div class="installation-custom-border-bottom"></div>
            </div>
        </div>

        <div class="installation-row my-4">
            <div class="my-0 bg-yellow">

                <label class="font-weight-bold">Last Name on Monument</label>
                <div class="mx-2 installation-custom-border-bottom"></div>

                <label class="font-weight-bold">Inv.#</label>
                <div class="mx-2 w-50 installation-custom-border-bottom"></div>

            </div>
        </div>

    </div>

</template>

<script>

export default {
    name: "Step-3",
    data() {
        return {}
    },
    methods:{
    }

    }
</script>

<style scoped>

    .installation-row {
        display: flex;
        padding: 0;
    }
    .installation-row div {
        display: flex;
        margin: 0.1rem 0;
        width: 100%;
    }
    label, h5, h6{
        margin: auto 0;
        white-space: nowrap !important;
        font-family: "Times New Roman";
    }
    label{
        font-size: 1.2rem !important;
    }
    .installation-row div input{
        margin: auto;
        margin-right: 0;
        height: 1.5rem;
    }
    header{
        padding: 0 3rem;
    }
    div{
        margin: 1rem 0;
    }

    .installation-custom-label{
        font-family: "Times New Roman" !important;
        text-transform: uppercase !important;
    }
    .installation-custom-border{
        border: 2px solid #000 !important;
    }
    .installation-custom-border-left{
        border-left: 2px solid #000 !important;
    }
    .installation-custom-border-bottom{
        border-bottom: 2px solid #000 !important;
    }
    .installation-custom-border-right{
        border-right: 2px solid #000 !important;
    }
    .installation-custom-border-top{
        border-top: 2px solid #000 !important;
    }
</style>
