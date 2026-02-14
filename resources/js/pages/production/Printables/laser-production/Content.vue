<template>

    <div>
        <h5 class="mx-2 my-1 non-print-elm text-center font-weight-bold" style="text-decoration: underline;">Laser</h5>
        <div class="row">
            <div class="col-md-12">
                <form class="bg-white rounded mx-2 mb-2 p-3">

                    <div class="form-content">

                        <div class="laser-production-row my-2">
                            <div>
                                    <h5 class="my-auto p-0 week-label">Week Of:</h5>
                            </div>
                        </div>
                        <div class="laser-production-row">
                            <div>
                                <b-table  bordered class="printable-production-table-border" :items="items" :fields="fields">
                                    <template #head()="data">
                                        <div class="my-n1 justify-content-center">
                                            <label class="header-label">{{ data.label }}</label>
                                        </div>
                                    </template>
                                    <template #cell(initials)="data">
                                        <b-form-input type="text"  readonly class="input-xs my-1 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(total_sq_ft)="data">
                                        <b-form-input type="text"  readonly class="input-sm  my-1 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(invoice_no)="data">
                                        <b-form-input type="text"  readonly class="input-md  my-1 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(date)="data">
                                        <b-form-input type="text"  class="input-md  my-1 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(last_name)="data">
                                        <b-form-input type="text"  readonly class="input-lg  my-1 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(size_of_die)="data">
                                        <b-form-input type="text"  readonly class="input-xl  my-1 bg-white" size="sm"></b-form-input>
                                    </template>

                                </b-table>
                            </div>
                        </div>
                        <div class="d-block text-center border-bottom mt-n1" style="font-family: Roboto; color:#000;">
                            <label class="d-block m-0 font-weight-bold">To Convert Sq. Inches to Sq.Ft.</label>
                            <label class="d-block m-0 font-weight-bold">Length (x) Width, Divided by 144 (24x12 = 288/144 = 2)</label>

                        </div>
                        <div class="laser-production-row justify-content-center ">
                            <div class="col-8 ml-5">
                            <div class="col-4 d-block ml-4">
                                <div><h5 class="font-weight-bold">GRASSER</h5></div>
                                <div><label class="ml-0 font-weight-bold">16x8 = 0.88 sq.ft.</label></div>
                                <div><label class="ml-0 font-weight-bold">20x10 = 1.4</label></div>
                                <div><label class="ml-0 font-weight-bold">24x12 = 2</label></div>
                                <div><label class="ml-0 font-weight-bold">36x12 = 3</label></div>
                                <div><label class="ml-0 font-weight-bold">36x14 = 3.5</label></div>
                            </div>
                            <div class="col-4 d-block">
                                <div><h5 class="font-weight-bold">SLANTS</h5></div>
                                <div><label class="ml-0 font-weight-bold">16x12 = 1.33 sq.ft.</label></div>
                                <div><label class="ml-0 font-weight-bold">20x16 = 2.2</label></div>
                                <div><label class="ml-0 font-weight-bold">24x16 = 2.6</label></div>
                                <div><label class="ml-0 font-weight-bold">36x16 = 4</label></div>
                                <div><label class="ml-0 font-weight-bold">42x16 = 4.7</label></div>
                            </div>
                            <div class="col-4 d-block">
                                <div><h5 class="font-weight-bold">DIES</h5></div>
                                <div><label class="ml-0 font-weight-bold">14x18 = 1.75 sq.ft.</label></div>
                                <div><label class="ml-0 font-weight-bold">24x18 = 3</label></div>
                                <div><label class="ml-0 font-weight-bold">36x20 = 5</label></div>
                                <div><label class="ml-0 font-weight-bold">42x22 = 6.41</label></div>
                                <div><label class="ml-0 font-weight-bold">48x24 = 8</label></div>
                            </div>
                            </div>
                        </div>

                        <div class="laser-production-row non-print-elm">
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
                        key: 'size_of_die',
                        label: 'Size Of Die inches',
                    },
                    {
                        key: 'total_sq_ft',
                        label: 'Total Sq ft',
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
          for (let i=0 ;i<15;i++){
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

    .laser-production-row {
        display: flex;
        padding: 0;
    }

    .laser-production-row div {
        display: flex;
        margin: 0.3rem 0;
        width: 100%;
    }

    .laser-production-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
        color:#000 !important;
    }

    .laser-production-row div input {
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

    .border-bottom{
        border-bottom: 2px solid #000 !important;
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
