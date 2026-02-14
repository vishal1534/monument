<template>

    <div>
        <h5 class="mx-2 my-1 non-print-elm text-center font-weight-bold" style="font-size:40px;">Installation Production</h5>
        <div class="row">
            <div class="col-md-12">
                <form class="bg-white rounded mx-2 mb-2 p-3">

                    <div class="form-content">

                        <div class="installation-row my-2">
                            <div>
                                    <h5 class="my-auto p-0 week-label">Week of:</h5>
                            </div>
                        </div>
                        <div class="installation-row">
                            <div>
                                <b-table  bordered class="memorial-table-border" :items="items" :fields="fields">
                                    <template #head()="data">
                                        <div class="my-n1 justify-content-center">
                                            <label class="header-label">{{ data.label }}</label>
                                        </div>
                                    </template>
                                    <template #cell(initials)="data">
                                        <b-form-input type="text" readonly class="input-xs my-1 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(total_sq_ft)="data">
                                        <b-form-input type="text" readonly class="input-sm  my-1 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(invoice_no)="data">
                                        <b-form-input type="text" readonly class="input-md  my-1 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(date)="data">
                                        <b-form-input type="text" readonly class="input-md  my-1 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(last_name)="data">
                                        <b-form-input type="text" readonly class="input-lg  my-1 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(size_of_base)="data">
                                        <b-form-input type="text" readonly class="input-xl  my-1 bg-white" size="sm"></b-form-input>
                                    </template>

                                </b-table>
                            </div>
                        </div>
                        <div class="installation-row d-block border mt-n4" >
                            <div class="border-bottom mb-n2 mt-n1">
                                <div class="col-3 border-right"><label class="mt-1 font-weight-bold" style="font-size: 14px;">STANDARD BASE SIZES</label></div>
                                <div><label class="mt-1 font-weight-bold" style="font-size: 14px;">LENGTH x WIDTH DIVIDED BY 144 36x12=432/144=3 SQ FT</label></div>
                            </div>
                            <div>
                                <div class="col-3 border-right my-n1">
                                    <div class="d-block">
                                        <div><label class="ml-n2 font-weight-bold">20x10=1.3 SQ FT</label></div>
                                        <div><label class="ml-n2 font-weight-bold">36x10=2.5</label></div>
                                        <div><label class="ml-n2 font-weight-bold">36x12=3</label></div>
                                        <div><label class="ml-n2 font-weight-bold">42x12=3.5</label></div>
                                    </div>
                                    <div class=" d-block">
                                        <div><label class="ml-2 font-weight-bold">48x12=4</label></div>
                                        <div><label class="ml-2 font-weight-bold">48x14=4.7</label></div>
                                        <div><label class="ml-2 font-weight-bold">54x12=4.5</label></div>
                                        <div><label class="ml-2 font-weight-bold">60x14=5.9</label></div>
                                    </div>
                                </div>
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
                        key: 'invoice_no',
                        label: 'Inv#',
                    },
                    {
                        key: 'last_name',
                        label: 'Last Name',
                    },
                    {
                        key: 'size_of_base',
                        label: 'Size of Base inches',
                    },
                    {
                        key: 'total_sq_ft',
                        label: 'Total Sqft.',
                    },
                    {
                        key: 'date',
                        label: 'Date',
                    },
                    {
                        key: 'initials',
                        label: 'Initials',
                    }
                ],
                items: []
            }
        },
        mounted() {
          for (let i=0 ;i<18;i++){
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
        border-left: 1px solid #c4c4c4 !important;
        border-right: 1px solid #c4c4c4 !important;
        border-bottom:  1px solid #c4c4c4 !important;
    }

    .border-bottom{
        border-bottom: 1px solid #c4c4c4 !important;
    }

    .border-right{
        border-right: 1px solid #c4c4c4 !important;
    }
    .printing .border{
        border-left: 1px solid #000 !important;
        border-right: 1px solid #000 !important;
        border-bottom:  1px solid #000 !important;
    }

    .printing  .border-bottom{
        border-bottom: 1px solid #000 !important;
    }

    .printing  .border-right{
        border-right: 1px solid #000!important;
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
