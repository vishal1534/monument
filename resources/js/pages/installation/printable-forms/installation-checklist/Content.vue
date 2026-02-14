<template>

    <div>
        <div class="row">
            <div class="col-md-12">
                <form class="bg-white rounded mx-2 mb-2 p-3">

                    <div class="form-content">

                        <div class="installation-row d-block my-3" style="margin-left: 45rem !important;">
                            <div>
                                <label class="font-weight-bold" style="font-size: 15px !important;">DAY: ____________________</label>
                            </div>
                            <div>
                                <label class="font-weight-bold" style="font-size: 15px !important;">DATE: ___________________</label>
                            </div>
                        </div>
                        <h5 class="mx-2 my-1 text-center" style="font-size:40px;font-weight: 600">FRISBIE MONUMENT’S
                            <br>INSTALLATION CHECK LIST</h5>
                        <div class="installation-row d-block my-3" >
                            <div class="ml-n2 pdf-checkbox">
                                <input type="checkbox" class="checkbox-margin">
                                <label class="font-weight-bold">Was the grave flagged and ready when you arrived YES NO</label>
                            </div>
                        </div>
                        <div class="installation-row d-block my-3" >
                            <div class="ml-n2 pdf-checkbox">
                                <input type="checkbox" style="margin-top: 1.5rem !important;">
                                <label class="font-weight-bold">Take picture of the area where installing, far enough back so you can see
                                    <br>at least three other headstones on each side.</label>
                            </div>
                        </div>
                        <div class="installation-row d-block my-3" >
                            <div class="ml-n2 pdf-checkbox">
                                <input type="checkbox" style="margin-top: 1.5rem !important;">
                                <label class="font-weight-bold">Take picture of foundation hole before pouring concrete
                                    <br>w/ tape measure to show it is proper depth.</label>
                            </div>
                        </div>
                        <div class="installation-row d-block my-3" >
                            <div class="ml-n2 pdf-checkbox">
                                <input type="checkbox" style="margin-top: 2.5rem !important;">
                                <label class="font-weight-bold">
                                    Grassers need 10" foundation & 2 pier holes 6-12"
                                    <br>Slants without bases need 12"- 16" foundation & 2 pier holes 24"
                                    <br>Uprights need 16" foundation & 2-3 pier holes 20"-24" min.
                                </label>
                            </div>
                        </div>
                        <div class="installation-row d-block my-3" >
                            <div class="ml-n2 pdf-checkbox">
                                <input type="checkbox" class="checkbox-margin">
                                <label class="font-weight-bold">
                                    Foundation depth________(total depth for slants & uprights must be 36")
                                </label>
                            </div>
                        </div>
                        <div class="installation-row d-block my-3" >
                            <div class="ml-n2 pdf-checkbox">
                                <input type="checkbox" class="checkbox-margin">
                                <label class="font-weight-bold"> Was there any obstacles or issues while digging foundation
                                    <br>___________________________________________________________
                                </label>
                            </div>
                        </div>
                        <div class="installation-row d-block my-3" >
                            <div class="ml-n2 pdf-checkbox">
                                <input type="checkbox" class="checkbox-margin">
                                <label class="font-weight-bold">Take picture of foundation hole after pouring concrete
                                </label>
                            </div>
                        </div>
                        <div class="installation-row d-block my-3" >
                            <div class="ml-n2 pdf-checkbox">
                                <input type="checkbox" style="margin-top: 1.5rem !important;">
                                <label class="font-weight-bold">Spread grass on the backfill dirt around base, do this before silicone
                                    <br>(MONUMENT MUST BE TAPED OFF BEFORE APPLING SILICONE)
                                </label>
                            </div>
                        </div>
                        <div class="installation-row d-block my-3" >
                            <div class="ml-n2 pdf-checkbox">
                                <input type="checkbox" class="checkbox-margin">
                                <label class="font-weight-bold">Take picture of finished installed, grass seeds already spread
                                </label>
                            </div>
                        </div>
                        <div class="installation-row d-block my-3" >
                            <div class="ml-n2 pdf-checkbox">
                                <input type="checkbox" style="margin-top: 3rem !important;">
                                <label class="font-weight-bold">Were any knick nacks or grave decorations damaged during the
                                    <br>install, if so take pictures and email immediatley and write down
                                    <br>what happened._______________________________________________
                                </label>
                            </div>
                        </div>
                        <div class="installation-row d-block my-3" >
                            <div class="ml-n2 pdf-checkbox">
                                <input type="checkbox" style="margin-top: 1.5rem !important;">
                                <label class="font-weight-bold">Which direction was front of headstone faced (have to do per install sheet )
                                    <br>Man N / S <span class="ml-4 mr-2">Woman N / S</span> Front Monument  E / W
                                </label>
                            </div>
                        </div>
                        <div class="installation-row d-block my-3" >
                            <div class="ml-n2 pdf-checkbox">
                                <input type="checkbox" class="checkbox-margin">
                                <label class="font-weight-bold"> Was Granite seal or silicone used____________________________
                                </label>
                            </div>
                        </div>
                        <div class="installation-row d-block my-3" >
                            <div class="ml-n2 pdf-checkbox">
                                <input type="checkbox" class="checkbox-margin">
                                <label class="font-weight-bold">How was the vase attached_____________________________________
                                </label>
                            </div>
                        </div>
                        <div class="installation-row d-block my-3" >
                            <div class="ml-n2 pdf-checkbox">
                                <input type="checkbox" class="checkbox-margin">
                                <label class="font-weight-bold">TIME ARRIVED________________ TIME FINISHED__________________</label>
                            </div>
                        </div>
                        <div class="installation-row my-3 ml-n5" >
                            <div class="">
                                <label class="font-weight-bold">NAME OF INSTALLER___________________</label>
                            </div>
                            <div class=" ml-2">
                                <label class="font-weight-bold">NAME OF CUSTOMER___________________</label>
                            </div>
                        </div>

                        <div class="installation-row non-print-elm">
                            <div>
                                <button type="button" class="btn-info mx-1 px-2 w-auto custom-infobtn-toolbar custom-infobtn-text" @click="printPDF">
                                    Print Form
                                </button>
                                <router-link class="btn btn-sm btn-warning mx-1 px-4 custom-dangerbtn-toolbar custom-dangerbtn-text"
                                             :to="'/production-list'">Cancel
                                </router-link>
                            </div>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

</template>

<script>
    import {event, eventBus} from "../../../../event-bus/event-bus";

    export default {
        name: "Content",
        data() {
            return {
                fields: [
                    {
                        key: 'customer_name',
                        label: 'Customer Name',
                    },
                    {
                        key: 'invoice_no',
                        label: 'Invoice',
                    },
                    {
                        key: 'monument_loaded',
                        label: 'Monument Loaded',
                    },
                    {
                        key: 'no_of_vases',
                        label: '# of vases',
                    },
                    {
                        key: 'apron_cap',
                        label: 'Apron/Cap',
                    },
                    {
                        key: 'bags_concrete',
                        label: 'Bags of Concrete',
                    },
                    {
                        key: 'sign',
                        label: 'Signatures',
                    }
                ],
                items: []
            }
        },
        mounted() {
          for (let i=0 ;i<12;i++){
              this.items.push({})
          }
        },
        methods: {
            printPDF() {
                eventBus.$emit(event.PRINT_PDF)
            },
        }
    }
</script>

<style scoped>
    .form-content {
        margin: 0 auto;
        width: 58rem;
    }
    .pdf-checkbox input[type='checkbox']{
        width: 20px !important;
        height: 20px !important;
        margin: 5px;
        -webkit-appearance: none;
        -moz-appearance: none;
        -o-appearance: none;
        appearance:none;
        outline: 2.5px solid black;
        box-shadow: none;
        font-size: 2em;
    }

    .checkbox-margin{
        margin-top: 0.6rem !important;
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
        font-size: 25px !important;
    }

    .installation-row div input {
        border: 2px solid transparent;
        margin: auto;
        margin-right: 0;
        height: 1.5rem;
    }

    header {
        padding: 0 3rem;
    }
    h5{
        color:#000000 !important;
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
        width: 4rem;
    }

    .border{
        border: 2px solid #000 !important;
    }

    .border-bottom{
        border-bottom: 2px solid #000 !important;
    }

    .border-right{
        border-right: 2px solid #000 !important;
    }

    /*.printing .form-content{
        width: 100%;
    }
    .printing label, .printing input,{
        font-size: 1.2rem;
    }
    .printing h5, .printing h3{
        font-size: 2rem;
    }
    .printing input{
        border-color: transparent !important;
        background: transparent !important;
        pointer-events: none;
        height: 2.5rem;
    }
    .printing .non-print-elm{
        display: none !important;
    }
    .printing .print-elm{
        display: block !important;
    }*/
</style>
