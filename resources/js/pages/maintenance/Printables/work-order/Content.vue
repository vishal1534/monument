<template>

    <div>

        <div class="installation-row">
            <div class="installation-row flex-column">
                <h1 class="mx-auto font-weight-bold font-italic text-center mt-3" style="text-decoration: underline">MAINTENANCE WORK ORDER <br> FORM 146</h1>
            </div>
        </div>
        <div class="installation-row">
            <div class="mt-2">
                <label class="font-weight-bold">Person Requesting</label>
                <div class="mx-2 installation-custom-border-bottom"></div>

                <label class="font-weight-bold">Date Requested</label>
                <div class="mx-2 installation-custom-border-bottom"></div>
            </div>
        </div>
        <div class="installation-row">
            <div>
                <label class="font-weight-bold">Equipment  #</label>
                <div class="mx-2 installation-custom-border-bottom"></div>

                <label class="font-weight-bold">Work Order  #</label>
                <div class="mx-2 installation-custom-border-bottom"></div>
            </div>
        </div>
        <div class="installation-row">
            <div>
                <label class="font-weight-bold">Location</label>
                <div class="mx-2 installation-custom-border-bottom"></div>

                <label class="font-weight-bold">Dept</label>
                <div class="mx-2 installation-custom-border-bottom"></div>
            </div>
        </div>
        <div class="installation-row">
            <div>
                <label class="font-weight-bold">Type of Repair</label>
                <div class="mx-2 installation-custom-border-bottom"></div>

                <label class="font-weight-bold">Urgency</label>
                <div class="mx-2 installation-custom-border-bottom"></div>
            </div>
        </div>

        <div class="installation-row flex-column">
            <div>
                <h3 class="custom-sub-heading">DESCRIPTION OF THE PROBLEM:</h3>
            </div>
            <div >
                <div class="my-4 mr-2 installation-custom-border-bottom"></div>
            </div>
            <div >
                <div class="my-4 mr-2 installation-custom-border-bottom"></div>
            </div>
            <div >
                <div class="my-4 mr-2 installation-custom-border-bottom"></div>
            </div>
            <div >
                <div class="my-4 mr-2 installation-custom-border-bottom"></div>
            </div>
            <div >
                <div class="my-4 mr-2 installation-custom-border-bottom"></div>
            </div>
            <div >
                <div class="my-4 mr-2 installation-custom-border-bottom"></div>
            </div>
            <div >
                <div class="my-4 mr-2 installation-custom-border-bottom"></div>
            </div>
            <div >
                <div class="my-4 mr-2 installation-custom-border-bottom"></div>
            </div>
        </div>

        <div class="installation-row mt-n5 mb-4 col-7">
            <div class="mt-n1">
                <label class="non-print-elm font-weight-bold">.............................................</label>
                <label class="print-elm font-weight-bold">..............................................</label>
            </div>
            <div class="">
                <label class=" non-print-elm font-weight-bold">INTER OFFICE ONLY</label>
                <h3 class="print-elm custom-sub-heading">INTER OFFICE ONLY</h3>
            </div>
            <div class="mt-n1">
                <label class="font-weight-bold">..........................................</label>
            </div>
        </div>
        <div class="installation-row">
            <div>
                <label class="font-weight-bold">Person to do work order</label>
                <div class="mx-2 installation-custom-border-bottom"></div>
            </div>
            <div class="w-50">
                <label class="font-weight-bold">Date to perform w.o</label>
                <div class="mx-2 installation-custom-border-bottom"></div>
            </div>
        </div>
        <div class="installation-row w-50">
            <div>
                <label class="font-weight-bold">Estimated man hours</label>
                <div class="mx-2 installation-custom-border-bottom"></div>
            </div>
        </div>
        <div class="installation-row w-50">
            <div>
                <label class="font-weight-bold">Actual man hours required</label>
                <div class="mx-2 installation-custom-border-bottom"></div>
            </div>
        </div>
        <div class="installation-row w-50">
            <div>
                <label class="font-weight-bold">Date w.o. completed</label>
                <div class="mx-2 installation-custom-border-bottom"></div>
            </div>
        </div>


    </div>

</template>

<script>
export default {
    name: "Add",
    data(){
        return {
            }
        },

    methods:{
    }
    }
</script>

<style scoped>

    .installation-row
    {
        display: flex;
        padding: 0;
    }
    .installation-row div
    {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }
    label{
        font-size: 1.2rem;
    }
    h3{
        font-size: 18px;
        font-family:"Times New Roman";
        font-weight: bold;
    }
    label, h5, h6{
        margin: auto 0;
        white-space: nowrap !important;
        font-family: "Times New Roman";
    }
    .installation-row div input{
        border: 1px solid #dee2e6;
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
    .installation-custom-border-bottom{
        border-bottom: 1px solid #000 !important;
    }
    @supports (-moz-appearance:none) {
        .installation-custom-border-bottom{
            border-bottom: 2px solid #000 !important;
        }
    }

</style>
