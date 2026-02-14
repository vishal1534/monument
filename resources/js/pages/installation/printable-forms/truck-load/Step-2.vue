<template>

    <div>

        <div class="installation-row">
            <div class="installation-row flex-column">
                <h5 class="mx-2 my-1 text-center font-weight-bold" style="font-size:35px;">Frisbie Monument's
                </h5>
            </div>
        </div>
        <div class="installation-row" style="page-break-after: always;">
            <div>
                <b-table  bordered class="printable-truckload-table-border" :items="items" :fields="fields">

                    <template #head()="data">
                        <div class="my-n1 justify-content-start">
                            <label class="font-weight-normal mt-n4">{{ data.label }}</label>
                        </div>
                    </template>
                    <template #head(passenger_box)="data">
                        <div class="my-n1 justify-content-start">
                            <label class="font-weight-bold">PASSENGER<br> TOOLBOX</label>
                        </div>
                    </template>
                    <template #head(adjust)="data">
                        <div class="my-n1 justify-content-start">
                            <label><span  class="font-weight-normal">ADJUST</span><br> <span class="font-weight-bold font-italic"> (FILL,REPLACE,ADD)</span></label>
                        </div>
                    </template>
                    <template #cell(passenger_box)="data">
                        <div  v-if="data.index == 0" style="height: 1.7rem !important">
                            <label class="mt-n2">RATCHET STRAPS<br>QTY. 11</label>
                        </div>
                        <div  v-else-if="data.index == 1" style="height: 1.7rem !important">
                            <label class="mt-n2">RED SETTING <br> CUSHIONS</label>
                        </div>
                        <div  v-else-if="data.index == 2" style="height: 1.7rem !important">
                            <label class="mt-n2">WHITE SETTING<br>CUSHIONS</label>
                        </div>
                        <div  v-else-if="data.index == 3" style="height: 1.7rem !important">
                            <label class="mt-n2">ROLL OF BLUE <br>PAPERTOWELS</label>
                        </div>
                        <div  v-else-if="data.index == 4" style="height: 1.7rem !important">
                            <label class="mt-n2">BLACK RUBBER <br>MONUMENT PADS</label>
                        </div>
                        <div  v-else-if="data.index == 9" style="height: 1.7rem !important">
                            <label class="mt-n2">2 TUBES OF GRAY<br>SILICONE</label>
                        </div>
                        <div  v-else-if="data.index == 10" style="height: 1.7rem !important">
                            <label class="mt-n2">SQUIRT BOTTLE<br>COLEMAN FULL</label>
                        </div>
                        <div  v-else-if="data.index == 12" style="height: 1.7rem !important">
                            <label class="mt-n2">SPRAY BOTTLE<br>WINDEX</label>
                        </div>
                        <div  v-else class="">
                            <label>{{ data.item.passenger_box}}</label>
                        </div>
                    </template>

                </b-table>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "Step-2",
        data(){
            return {
                fields: [
                    {
                        key: 'passenger_box',
                        label: 'PASSENGER TOOLBOX',
                    },
                    {
                        key: 'date',
                        label: 'Date:',
                    },
                    {
                        key: 'adjust',
                        label: 'ADJUST',
                    },
                    {
                        key: 'work_order',
                        label: 'WORK ORDER',
                    },
                ],
                items: [
                    {passenger_box:'RATCHET STRAPS QTY. 11'},{passenger_box:'RED SETTING CUSHIONS'},{passenger_box:'WHITE SETTING CUSHIONS'},
                    {passenger_box:'ROLL OF BLUE PAPERTOWELS'},{passenger_box:'BLACK RUBBER MONUMENT PADS'},{passenger_box:'SCREW DRIVERS'},
                    {passenger_box:'PLIERS'},{passenger_box:'BOX KNIFE'},{passenger_box:'TAPE'}, {passenger_box:'2 TUBES OF GRAY SILICONE'},
                    {passenger_box:'SQUIRT BOTTLE COLEMAN FULL'},{passenger_box:'SCRUB BUSH'},{passenger_box:'SPRAY BOTTLE WINDEX'},{passenger_box:'2FT LEVEL'}
                ]
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
        font-size: 14px;
        color:#000000 !important;
    }
    label, h5, h6{
        margin: auto 0;
        white-space: nowrap !important;
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

    .installation-custom-label{
        font-family: "Times New Roman" !important;
        text-transform: uppercase !important;
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
    th{
        width: 25% !important;
    }
</style>
