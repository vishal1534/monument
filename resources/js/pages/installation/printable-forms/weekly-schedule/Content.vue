<template>

    <div>
        <h5 class="mx-2 my-1 non-print-elm text-center font-weight-bold" style="font-size: 35px;">WEEKLY SCHEDULE</h5>
        <div class="row">
            <div class="col-md-12">
                <form class="bg-white rounded mx-2 mb-2 p-3">
                    <div class="form-content">
                        <div class="installation-row">
                            <div>
                                <b-table  bordered class="memorial-table-border" :items="items" :fields="fields">
                                    <template #head()="data">
                                        <div class="my-n1 justify-content-start">
                                            <label class="header-label ml-0">{{ data.label }}</label>
                                        </div>
                                    </template>
                                    <template #cell(day)="data">
                                        <b-form-input type="text" readonly class="input-md my-0 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(cemetery)="data">
                                        <b-form-input type="text" readonly class="input-lg my-0 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(monument_name)="data">
                                        <b-form-input type="text" readonly class="input-lg  my-0 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(special_notes)="data">
                                        <b-form-input type="text"  readonly class="input-xl  my-0 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(approved)="data">
                                        <b-form-input type="text"  readonly class="input-sm  my-0 bg-white" size="sm"></b-form-input>
                                    </template>
                                    <template #cell(zone)="data">
                                        <b-form-input type="text"  readonly class="input-sm  my-0 bg-white" size="sm"></b-form-input>
                                    </template>

                                </b-table>
                            </div>
                        </div>

                        <div class="installation-row non-print-elm">
                            <div>
                                <button type="button" class="btn-info mx-1 px-2 w-auto custom-infobtn-toolbar custom-infobtn-text" @click="printPDF">
                                    Print Form
                                </button>
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
                        key: 'day',
                        label: 'DAY/PERSON',
                    },
                    {
                        key: 'cemetery',
                        label: 'CEMETERY',
                    },
                    {
                        key: 'monument_name',
                        label: 'MONUMENT NAME',
                    },
                    {
                        key: 'special_notes',
                        label: 'SPECIAL NOTES',
                    },
                    {
                        key: 'approved',
                        label: 'APPROVED',
                    },
                    {
                        key: 'zone',
                        label: 'ZONE',
                    }
                ],
                items: []
            }
        },
        mounted() {
          for (let i=0 ;i<16;i++){
              this.items.push({})
          }
        },
        methods: {
            printPDF() {
                eventBus.$emit(event.PRINT_PDF)
            }
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
        font-weight: 500;
        font-size: 16px;
        line-height: 14px;
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
        height: 0.5rem;
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
        width: 9rem;
    }

    .input-md {
        width: 7.5rem;
    }

    .input-sm {
        width: 5.5rem;
    }
    .input-xs {
        width: 4rem;
    }

    .border-bottom{
        border-bottom: 2px solid #000 !important;
    }
    .border {
        border: 1px solid #c4c4c4 !important;
    }
    .border-right {
        border-right: 2px solid #000 !important;
    }
    .printing .border {
        border: 1px solid #000 !important;
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
