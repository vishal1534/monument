<template>
    <div class="bg-white mt-n1 pt-1">
        <!--<h3 class="mx-2 my-1 custom-form-heading">Monument (Headstone) Agreement</h3>
        <div class="d-flex non-print-elm justify-content-center bg-toolbar my-2 p-1">
            <button type="button" class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
                Save<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
            </button>
            <router-link class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/orders/' +id">Cancel</router-link>

        </div>-->

        <PDF :title="'printMonumentAgreement'">

            <div slot="header" class="my-3 pdf row pdf-margin">
                <div class="pdf-custom-margin-agreement py-3 " >
                    <h4 class="pdf-sub-title mt-5">FRISBIE MONUMENTS<br>
                        2320 S. CRYSLER AVE, INDEPENDENCE, MO. 64052</h4>
                    <h2 class="pdf-title col-md-12 my-5">MONUMENT (HEADSTONE) AGREEMENT</h2>
                    <form>
                         <div class=" agreement-row flex-column mx-auto">
                            <div class="mt-n2">
                                <p>
                                    <span>_______</span>

                                    <span class="pdf-label-form"> 1/2 of the monument must be paid for when the order is placed. If you have a bronze order.
                            <br>it must be paid in full up front. Any invoice total under $250.00 must be paid in advance.</span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <span>_______</span>

                                    <span class="pdf-label-form">If monument is not paid for in full within 45 days of completion or picked up you will lose <br> your deposit and Frisbie’s is not responsible for any damages if the monument is left. If we are waiting <br> for you to complete the order and you do not provided us with the information or payment to proceed <br> within 6 months of order date or you forfeit all moneys put towards the order.</span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <span>_______</span>

                                    <span class="pdf-label-form">Your monument must be paid in full before it will be installed at the cemetery.</span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <span>_______</span>

                                    <span class="pdf-label-form">You are responsible for any additional fees or price increase that the cemetery has such as <br>perpetual care fees, fees for opening and closing of the grave, ext... </span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <span>_______</span>

                                    <span class="pdf-label-form"> Once you have signed the final rough draft of what your monument will look like you are <br> responsible for any additional fees to correct the monument if something is misspelled, misplaced or <br> punctuation is incorrect. Frisbie Monuments is only held responsible if the monument looks different <br> than the final approval signed by you. <b>(Initials</b></span><label class="text-center ml-0 pdf-input-initial pdf-label-value">_______________</label><span class="pdf-label-form pdf-label-initial"><b>)</b></span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <span>_______</span>

                                    <span class="pdf-label-form">Once the order is written if you wish to have anything changed with your order the price <br> may increase or decrease.</span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <span>_______</span>
                                    <span class="pdf-label-form">If you decide to cancel your order it must be within 25 days of placing the order. On all <br> cancelled orders there will be a charge of 15% ($85 minimum).</span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <span>_______</span>
                                    <span class="pdf-label-form">Frisbie Monuments guarantees the monument to be free of defects that naturally occur.</span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <span>_______</span>

                                    <span class="pdf-label-form">Frisbie Monuments guarantees the foundation work to be free of defects.</span>
                                </p>
                            </div>
                            <div class="mt-n2">
                                <p>
                                    <span>_______</span>

                                    <span class="pdf-label-form">Our guarantee is that if you are not 100% satisfied with the outcome of your order (once <br> the monument is installed), we will have the opportunity to fix the issue to your satisfaction and if we <br> can not fix the issue to your satisfaction then we will replace your monument with a new one. (Problems <br> must be reported within 30 days of installation)</span>
                                </p>
                            </div>
                            <div class="mt-n2">

                                <span>_______</span>

                                <label class="pdf-label-form">Date Promised:</label>
                                <label class="text-center ml-0 pdf-input-approve pdf-label-value">______________________________________________</label>
                                <label class="pdf-label-form ml-2">(After Signed Approval &</label>
                            </div>
                             <div class="mt-n2">
                                 <label class="pdf-label-form ml-0">weather pending)</label>
                             </div>
                            <div class="pl-5 custom-div-padding">
                                <label class="ml-3 pdf-input-customer pdf-label-value">______________________________________________________________________</label>
                                <label class="pdf-label-form custom-label-width ml-n4">(Customer Name Printed)</label>
                            </div>
                            <div class="pl-5 custom-div-padding">
                                <label class="ml-3 pdf-input-customer pdf-label-value">______________________________________________________________________</label>
                                <label class="pdf-label-form ml-n4">(Customer Signature)</label>
                            </div>
                            <div>
                                <p class="pdf-label-form undertaking-height"> <span class="pdf-undertake-margin">I certify that I am the plot owner of the next in Kin. I understand that I am not to be present at the</span> <br> time the monument is installed. I give Frisbie Monuments my permission to install the monument.</p>
                            </div>
                            <div class="mt-4 pdf-input-padding">
                                <div class="flex-column">
                                    <label class="text-center ml-0 pdf-label-value">____________________</label>
                                    <label class="pdf-label-form text-center ml-0">Date</label>
                                </div>
                                <div class="flex-column pdf-inputs-margin">
                                    <label class="text-center ml-0 pdf-label-value">_____________</label>
                                    <label class="pdf-label-form text-center ml-0">Invoice No</label>
                                </div>
                                <div class="flex-column mr-2">
                                    <label class="text-center ml-0 pdf-label-value">___________________________</label>
                                    <label class="pdf-label-form text-center ml-0">Last Name on Stone</label>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </PDF>

        <div id="printable-view" >
            <div class="custom-margin-agreement py-3 " >
            <h4 class="sub-title mt-5">FRISBIE MONUMENTS<br>
                2320 S. CRYSLER AVE, INDEPENDENCE, MO. 64052</h4>
            <h2 class="title col-md-12 my-3">MONUMENT (HEADSTONE) AGREEMENT</h2>
            <form>
                <div class=" agreement-row flex-column mx-auto">
                    <div class="mt-n2">
                        <p>
                            <span>_______</span>

                            <span class="label-form"> 1/2 of the monument must be paid for when the order is placed. If you have a bronze order.
                            <br>it must be paid in full up front. Any invoice total under $250.00 must be paid in advance.</span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <span>_______</span>

                            <span class="label-form">If monument is not paid for in full within 45 days of completion or picked up you will lose <br> your deposit and Frisbie’s is not responsible for any damages if the monument is left. If we are waiting <br> for you to complete the order and you do not provided us with the information or payment to proceed <br> within 6 months of order date or you forfeit all moneys put towards the order.</span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <span>_______</span>

                            <span class="label-form">Your monument must be paid in full before it will be installed at the cemetery.</span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <span>_______</span>

                            <span class="label-form">You are responsible for any additional fees or price increase that the cemetery has such as <br>perpetual care fees, fees for opening and closing of the grave, ext... </span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <span>_______</span>

                            <span class="label-form"> Once you have signed the final rough draft of what your monument will look like you are <br> responsible for any additional fees to correct the monument if something is misspelled, misplaced or <br> punctuation is incorrect. Frisbie Monuments is only held responsible if the monument looks different <br> than the final approval signed by you. <b>(Initials</b></span><label class="text-center ml-0 input-initial label-value">_______________</label><span class="label-form label-initial"><b>)</b></span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <span>_______</span>

                            <span class="label-form">Once the order is written if you wish to have anything changed with your order the price <br> may increase or decrease.</span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <span>_______</span>
                            <span class="label-form">If you decide to cancel your order it must be within 25 days of placing the order. On all <br> cancelled orders there will be a charge of 15% ($85 minimum).</span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <span>_______</span>
                            <span class="label-form">Frisbie Monuments guarantees the monument to be free of defects that naturally occur.</span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <span>_______</span>

                            <span class="label-form">Frisbie Monuments guarantees the foundation work to be free of defects.</span>
                        </p>
                    </div>
                    <div class="mt-n2">
                        <p>
                            <span>_______</span>

                            <span class="label-form">Our guarantee is that if you are not 100% satisfied with the outcome of your order (once <br> the monument is installed), we will have the opportunity to fix the issue to your satisfaction and if we <br> can not fix the issue to your satisfaction then we will replace your monument with a new one. (Problems <br> must be reported within 30 days of installation)</span>
                        </p>
                    </div>
                    <div class="mt-n2">

                        <span>_______</span>

                        <label class="label-form">Date Promised:</label>
                        <label class="text-center ml-0 input-approve label-value">_____________________________________</label>
                        <label class="label-form ml-2">(After Signed Approval &</label>
                    </div>
                    <div class="mt-n2">
                        <label class="label-form ml-0">weather pending)</label>
                    </div>
                    <div class="pl-5 custom-div-padding">
                        <label class="ml-3 input-customer label-value">_________________________________________________</label>
                        <label class="label-form custom-label-width ml-n4">(Customer Name Printed)</label>
                    </div>
                    <div class="pl-5 custom-div-padding">
                        <label class="ml-3 input-customer label-value">________________________________________________</label>
                        <label class="label-form ml-n4">(Customer Signature)</label>
                    </div>
                    <div>
                        <p class="label-form undertaking-height"> <span class="undertake-margin">I certify that I am the plot owner of the next in Kin. I understand that I am not to be present at the</span> <br> time the monument is installed. I give Frisbie Monuments my permission to install the monument.</p>
                    </div>
                    <div class="mt-4 input-padding">
                        <div class="flex-column">
                            <label class="text-center ml-0 label-value">____________________</label>
                            <label class="label-form text-center ml-0">Date</label>
                        </div>
                        <div class="flex-column inputs-margin">
                            <label class="text-center ml-0 label-value">_____________</label>
                            <label class="abel-form text-center ml-0">Invoice No</label>
                        </div>
                        <div class="flex-column mr-2">
                            <label class="text-center ml-0 label-value">___________________________</label>
                            <label class="label-form text-center ml-0">Last Name on Stone</label>
                        </div>
                    </div>

                </div>
                <div class="agreement-row">
                    <div>
                        <button type="button" class="btn btn-sm btn-info custom-print-button  px-2" @click="printPDF">Print Preview</button>
                    </div>

                </div>
            </form>
        </div>
        </div>


    </div>
</template>

<script>
    import PDF from "../../../../Modules/PDF-Modal";
    import {event, eventBus} from "../../../../event-bus/event-bus";
    export default {
        name: "Add",
        data() {
            return  {}
        },
        metaInfo() {
            return {
                title: 'Printable Monument Agreement'
            }
        },
        beforeCreate(){
            if(!this.$store.getters.isPermitted({resource:'Orders',action:'read'}))
                this.$router.push( '/access-denied');
        },
        components:{
            PDF,
        },
        methods:{
            printPDF(){
                eventBus.$emit(event.PRINT_PDF)
            },
        }
    }
</script>

<style scoped>

    .pdf-title{
        font-family: "Times New Roman" !important;
        font-weight: 400;
        font-size: 30px;
        line-height: 30px;
        text-align: center;
        letter-spacing: 0.02em;
        margin-left: -4rem;
    }
    .pdf-sub-title{
        font-family: "Times New Roman" !important;
        font-weight: 400;
        font-size: 24px;
        line-height: 25px;
        text-align: center;
        letter-spacing: 0.02em;
        margin-left: -8rem;
    }
    .pdf-label-form{
        font-size:22px !important;
        font-family:'Times New Roman' !important;
        line-height: initial;
    }
    .pdf-label-value{
        font-size: 20px !important;
    }

    .pdf-label-initial{
        margin-top: -1.23rem !important;
        margin-left: 34.7rem !important;
        position:absolute;
    }
    .pdf-input-initial{
        margin-top:-2rem !important;
        margin-left: 26.2rem !important;
        height: 20px;
        width: 95px !important;
    }
    .pdf-input-approve{
        height: 22px;
        width: 400px !important;
    }
    .pdf-input-customer{
        width:40.5rem;
    }
    .pdf-input-padding{
        margin-left:-4rem !important;
    }
    .pdf-undertake-margin {
        margin-left: 4rem !important;
    }
    .pdf-inputs-margin{
        margin-left:2rem !important;
        margin-right:2rem !important;
    }
    .pdf label{
        display: block;
        font-size: 0.5em;
        margin-bottom: 0;
    }
    .pdf-custom-margin-agreement{
        margin-top:-8rem !important;
        margin-left: 3rem !important;
        margin-right: 0rem !important;
    }

    .custom-margin-agreement{
        margin-top:-3rem !important;
        width:45rem !important;
        margin: auto;
        /*margin-left: 25rem !important;
        margin-right: 0rem !important;*/
    }

    .title{
        font-family: "Times New Roman" !important;
        font-weight: 400;
        font-size: 20px;
        line-height: 20px;
        text-align: center;
        letter-spacing: 0.02em;
        margin-left: -5.5rem;
    }

    .sub-title{
        font-family: "Times New Roman" !important;
        font-weight: 400;
        font-size: 18px;
        line-height: 25px;
        text-align: center;
        letter-spacing: 0.02em;
        margin-left: -11rem;
    }
    .input-initial{
        margin-top:-2rem !important;
        margin-left: 0.2rem !important;
        height: 20px;
        width: 95px !important;
    }
    .input-approve{
        height: 22px;
        width: 270px !important;
    }
    .input-customer{
        width:25.5rem;
    }
    .input-padding{
        margin-left:-4rem !important;
    }
    .undertake-margin {
        margin-left: 2.5rem !important;
    }
    .inputs-margin{
        margin-left:-8rem !important;
        margin-right:-8rem !important;
    }
    .label-form{
        font-size:14px !important;
        font-family:'Times New Roman' !important;
        line-height: initial;
    }

    .label-initial{
        margin-top: 0.25rem !important;
        margin-left: 0.9rem !important;
        position:absolute;
    }

    .label-value{
        font-size: 17px !important;
    }


    .pdf .bottom-section label{
        font-size: 0.5em;
    }

    .pdf .first-row{
        width: 10rem;
        height: 2rem;
    }
    .printing {
        font-family: Roboto;
        padding: 3em;
        margin: 2em auto;
        font-size: 1.5em;
    }

    .agreement-row
    {
        display: flex;
        padding: 0;
    }
    .agreement-row div
    {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }
    .agreement-row div  label{
        margin: auto 0.5rem;
        white-space: nowrap !important;
    }
    .agreement-row div input,.input-date{
        border: 1px solid #dee2e6 !important;
        margin: auto;
        margin-right: 0;
        font-size: 12px;
    }
    header{
        padding: 0 3rem;
    }
    .custom-label-width{
        width:7rem;
    }
    .undertaking-height{
        line-height: inherit;
    }
    .custom-div-padding{
        padding-right: 10rem !important;
    }
</style>
