<template>

    <div>

        <div class="installation-row">
            <div class="flex-column">
                <h6 class="font-weight-bold text-uppercase">I hereby certify that the install is complete and approved by the</h6>
                <div>
                    <h6 class="font-weight-bold text-uppercase">cemetery:</h6>
                    <div class="mx-2 installation-custom-border-bottom"></div>
                </div>

            </div>
        </div>
        <div class="installation-row w-75 mx-auto my-4">
            <div>
                <label class="font-weight-bold label-md">Signature:</label>
                <div></div>
            </div>
            <div>
                <label class="font-weight-bold label-md">Date:</label>
                <div></div>
            </div>
        </div>


        <div class="installation-row">
            <label class="mx-auto font-weight-bold label-md text-purple">PLACEMENT</label>
        </div>
        <div class="installation-row">
            <label class="font-weight-bold px-0">The <span class="text-red">Female</span> is buried in the N S E W Grave</label>
        </div>
        <div class="installation-row">
            <label class="font-weight-bold px-0">The <span class="text-red">Male</span> is buried in the N S E W Grave</label>
        </div>
        <div class="installation-row">
            <label class="font-weight-bold">The Names on the Monument Should Face: THE GRAVE (N S E W) or AWAY FROM THE GRAVE (N S E W)</label>
        </div>
        <div class="installation-row">
            <div>
                <label class="font-weight-bold"># of Graves the Monument is Going Over:</label>
                <div class="installation-custom-border-bottom w-25"></div>
            </div>
            <div>
                <b-form-group class="my-auto custom-radio-and-checkbox">
                    <b-form-checkbox-group plain>
                        <b-form-checkbox value="0"><label class="font-weight-bold">Traditional Burial</label></b-form-checkbox>
                        <b-form-checkbox value="1" class="mx-2 font-weight-bold"><label>Cremation Burial</label></b-form-checkbox>
                        <b-form-checkbox value="2"><label class="font-weight-bold">Pre-Need</label></b-form-checkbox>
                    </b-form-checkbox-group>
                </b-form-group>

            </div>
        </div>
        <div class="installation-row">
            <div>
                <label class="font-weight-bold">Details on Burial (<u>if needed</u>):</label>
                <div class="installation-custom-border-bottom"></div>
            </div>
        </div>
        <div class="installation-row my-2">
            <label class="font-weight-bold">Is There Currently Any Monuments Making The Grave(s): YES / NO If Yes, fill out a "Monument Work Order"</label>
        </div>

        <div class="installation-row flex-column">
            <div>
                <label class="font-weight-bold">**Special Notes:</label>
                <div class="installation-custom-border-bottom"></div>
            </div>
            <div>
                <div class="installation-custom-border-bottom my-4"></div>
            </div>

        </div>
        <div class="installation-row">
            <div>
                <img src="/images/installation-image.png">
            </div>

            <div class="h-100 flex-column">
                <div class="installation-custom-border-bottom"></div>
                <div class="installation-custom-border-bottom my-4"></div>
                <div class="installation-custom-border-bottom"></div>
            </div>

        </div>

        <hr class="installation-custom-border-bottom">

        <div class="installation-row" style="page-break-after: always">
            <div>
                <label class="font-weight-bold ml-auto">SIGNATURE (I understand that I am not to be present at the time of install)</label>
            </div>
            <div>
                <label class="font-weight-bold mx-5">DATE:</label>
            </div>

        </div>


    </div>

</template>

<script>
export default {
    name: "Step-2",

    data() {
        return {
        }
    },
    methods:{
    }

};
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
        /*border: 1px solid #dee2e6 !important;*/
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
