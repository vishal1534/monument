<template>

    <div>
        <h5 class="mx-2 my-1 non-print-elm text-center font-weight-bold" style="font-size:35px;">Frisbie Monument's
            <br>Daily Installation Load
            <br>Check List</h5>
        <div class="row">
            <div class="col-md-12">
                <form class="bg-white rounded mx-2 mb-2 p-3">

                    <div class="form-content">

                        <div class="installation-row border">
                            <div class="d-block border-right px-1 pt-1 my-0">
                                <label class="font-weight-bold">Date:</label><br>
                                <label  class="d-block my-5"></label>
                            </div>
                          <!--  <div class="d-block border-right px-1 pt-1 my-0">
                                <label class="font-weight-bold">Day:</label><br>
                                <label class="d-block my-5"></label>
                            </div>-->
                            <div class="d-block border-right px-1 pt-1 my-0">
                                <label class="font-weight-bold">Name of Installer:</label>
                                <label class="d-block my-5"></label>
                            </div>
                            <div class="d-block px-1">
                                <label class="font-weight-bold">Name of Checker:</label>
                                <label class="d-block my-5"></label>
                            </div>
                        </div>
                        <div class="installation-row d-block my-3" >
                            <div class="ml-n2">
                                <label><span class="font-weight-bold">Check load before installer leaves for the night.</span>
                                    <span class="font-italic">(make sure all monuments, foundation caps, vases,
                                    military markers,<br> etc. Are loaded.  Take install paperwork and go through it and make sure everything
                                    loaded is correct & go through it <br> with him, both you will sign off)</span></label>
                            </div>
                        </div>
                        <div class="installation-row">
                            <div>
                                <b-table  bordered class="memorial-table-border" :items="items" :fields="fields">
                                    <template #head()="data">
                                        <div class="my-n1 justify-content-center">
                                            <label class="font-weight-bold">{{ data.label }}</label>
                                        </div>
                                    </template>
                                    <template #head(customer_name)="data">
                                        <div class="my-n1 justify-content-center">
                                            <label class="font-weight-bold">Customer<br> Name</label>
                                        </div>
                                    </template>
                                    <template #head(monument_loaded)="data">
                                        <div class="my-n1 justify-content-center">
                                            <label class="font-weight-bold">Monument<br> Loaded</label>
                                        </div>
                                    </template>
                                    <template #head(no_of_vases)="data">
                                        <div class="my-n1 justify-content-center">
                                            <label class="font-weight-bold"># of<br> Vases</label>
                                        </div>
                                    </template>
                                    <template #head(apron_cap)="data">
                                        <div class="my-n1 justify-content-center">
                                            <label class="font-weight-bold">Apron/<br>Cap</label>
                                        </div>
                                    </template>
                                    <template #head(bags_concrete)="data">
                                        <div class="my-n1 justify-content-center">
                                            <label class="font-weight-bold">Bags of<br>Concrete</label>
                                        </div>
                                    </template>
                                    <template #cell(no_of_vases)="data">
                                        <b-form-input  type="text"  readonly class="input-xs my-n1 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(sign)="data">
                                        <b-form-input  type="text"  readonly class="input-xs  my-n1 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(invoice_no)="data">
                                        <b-form-input  type="text"  readonly class="input-sm  my-n1 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(bags_concrete)="data">
                                        <b-form-input  type="text"  readonly class="my-n1 bg-white" size="sm" style="width:5rem"></b-form-input>
                                    </template>
                                    <template #cell(customer_name)="data">
                                        <div  class="input-sm my-n1">
                                        </div>
                                    </template>
                                    <template #cell(monument_loaded)="data">
                                        <div class="input-sm my-n3">
                                        </div>
                                    </template>
                                    <template #cell(apron_cap)="data">
                                        <div  class="input-sm my-n3">
                                        </div>
                                    </template>

                                </b-table>
                            </div>
                        </div>
                        <div class="installation-row d-block mt-n3" >
                            <div class="ml-n2">
                                <label><span class="font-weight-bold">To determine the number of bags of concrete to use for a monument</span>
                                    <br>Each 80lbs. Bag of concrete will fill 0.60 cubic feet or 1,036 cubic inches
                                    <br>Cubic feet or inches = length x width x height
                                    <br>Divide the number of cubic feet your foundation has to be by 0.60 (cf per bag)
                                    <br>Divide the number of cubic inches your foundation has to be by 1,036 (ci per bag)
                                </label>
                            </div>
                        </div>
                        <div class="installation-row d-block mt-4" >
                            <div class="ml-n2">
                                <label><span class="font-weight-bold" style="font-size: 20px">Example: </span>If you were pouring a foundation for a 2-0 x 1-0 x 0-6 base
                                <br>You would dig a hole roughly 25"long x 13"wide x 18"deep (which is 3.5 cubic feet or 5,850 ci)
                                 <br>3.5 divided by 0.60 = 6 bags of concrete for a foundation under a 2-0 x 1-0 x 0-6 base
                                 <br>5,850 divided by 1036 = 6 bags of concrete for a foundation under a 2-0 x 1-0 x 0-6 base
                                </label>
                            </div>
                        </div>
                        <div class="installation-row mt-2" >
                            <div class="ml-n2">
                                <label style="font-size: 14px;">1-4x0-8x0-4 grasser = 2 bags of concrete
                                <br>1-8x0-10x0-4 grasser = 3 bags of concrete
                                <br>2-0x1-0x0-4 grasser = 4 bags of concrete
                                <br>1-8x0-8x0-6 base = 3 bags of concrete
                                <br>2-10x0-10x0-6 base = 6 bags of concrete	</label>
                            </div>
                            <div class="ml-n2">
                                <label style="font-size: 14px;">3-0x1-0x0-6 base = 8 bags of concrete
                                <br>3-6x1-0x0-6 base = 9 bags of concrete
                                <br>4-0x1-0x0-6 base = 10 bags of concrete
                                <br>4-6x1-0x0-6 base = 11 bags of concrete
                                <br>5-0x1-2x0-8 base = 15 bags of concrete</label>
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
    .header-label{
        font-family: Roboto;
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 14px;
        text-align: center;
        letter-spacing: 0.02em;
        color:#000;
    }
    .week-label{
        font-family: Roboto;
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 16px;
        text-align: center;
        letter-spacing: 0.02em;
        color:#000;
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
    label{
        font-size: 18px !important;
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
        border: 1px solid #c4c4c4 !important;
    }

    .border-bottom{
        border-bottom: 1px solid #c4c4c4 !important;
    }

    .border-right{
        border-right: 1px solid #c4c4c4 !important;
    }

    .printing .border{
        border: 1px solid #000 !important;
    }

    .printing .border-bottom{
        border-bottom: 1px solid #000 !important;
    }

    .printing .border-right{
        border-right: 1px solid #000 !important;
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
