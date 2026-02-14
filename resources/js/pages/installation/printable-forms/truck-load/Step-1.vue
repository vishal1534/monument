<template>

    <div>

        <div class="installation-row">
            <div class="installation-row flex-column">
                <h5 class="mx-2 my-1 text-center font-weight-bold" style="font-size:35px;">Frisbie Monument's
                    <br>Daily Load List For Diesel (f-350)
                    <br>Setting Trucks & Setting BOX</h5>
            </div>
        </div>
        <div class="installation-row border">
            <div class="d-block border-right px-1 pt-1 my-0">
                <label class="">Date:</label><br>
                <label  class="d-block my-5"></label>
            </div>

            <!--<div class="d-block border-right px-1 pt-1 my-0">
                <label class="">Day:</label><br>
                <label class="d-block my-5"></label>
            </div>-->
            <div class="d-block border-right px-1 pt-1 my-0">
                <label class="">Name of Installer:</label>
                <label class="d-block my-5"></label>
            </div>
            <div class="d-block px-1">
                <label class="">Name of Checker:</label>
                <label class="d-block my-5"></label>
            </div>
        </div>
        <div class="installation-row">
            <div>
                <b-table  bordered class="printable-truckload-table-border" :items="items" :fields="fields">

                    <template #head()="data">
                        <div class="my-n1 justify-content-start">
                            <label class="font-weight-normal mt-n4">{{ data.label }}</label>
                        </div>
                    </template>
                    <template #head(check_off)="data">
                        <div class="my-n1 justify-content-start">
                            <label class="font-weight-bold">MAINTENANCE<br> CHECK OFF</label>
                        </div>
                    </template>
                    <template #head(adjust)="data">
                        <div class="my-n1 justify-content-start">
                            <label><span  class="font-weight-normal">ADJUST</span><br> <span class="font-weight-bold font-italic"> (FILL,REPLACE,ADD)</span></label>
                        </div>
                    </template>
                    <template #cell(check_off)="data">
                        <div  v-if="data.index == 2" style="height: 1.7rem !important">
                            <label class="mt-n2">CHECK GAS & OIL <br>LEVEL IN TRUCK</label>
                        </div>
                        <div  v-else class="">
                            <label>{{ data.item.check_off}}</label>
                        </div>
                    </template>

                </b-table>
            </div>
        </div>
        <div class="installation-row" style="page-break-after: always;">
            <div>
                <b-table  bordered class="printable-truckload-table-border" :items="items1" :fields="fields1">

                    <template #head()="data">
                        <div class="my-n1 justify-content-start">
                            <label class="font-weight-normal mt-n4">{{ data.label }}</label>
                        </div>
                    </template>
                    <template #head(sand_box)="data">
                        <div class="my-n1 justify-content-start">
                            <label class="font-weight-bold mt-n4">DRIVER SAND BOX</label>
                        </div>
                    </template>
                    <template #head(adjust)="data">
                        <div class="my-n1 justify-content-start">
                            <label><span  class="font-weight-normal">ADJUST</span><br> <span class="font-weight-bold font-italic"> (FILL,REPLACE,ADD)</span></label>
                        </div>
                    </template>
                    <template #cell(sand_box)="data">
                        <div  v-if="data.index == 8" style="height: 1.7rem !important">
                            <label class="mt-n2">BLUE TOOL BOX
                                <br>MISC TOOLS</label>
                        </div>
                        <div  v-else class="">
                            <label>{{ data.item.sand_box}}</label>
                        </div>
                    </template>

                </b-table>
            </div>
        </div>





    </div>

</template>

<script>
    export default {
        name: "Step-1",
        data(){
            return {
                fields: [
                    {
                        key: 'check_off',
                        label: 'Customer Name',
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
                    {check_off:'CK ENGINE OIL'},{check_off:'CK TIRE PRESSURE'},{check_off:'CHECK GAS & OIL <br>LEVEL IN TRUCK'}
                ],
                fields1: [
                    {
                        key: 'sand_box',
                        label: 'DRIVER SAND BOX',
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
                items1: [
                    {sand_box:'COME ALONG'},{sand_box:'ROLL OFF ROPE'},{sand_box:'XTRA STRAPS'},
                    {sand_box:'FLASH LIGHT'},{sand_box:'CROW BAR'},{sand_box:'5lbs. SLEDGE'},
                    {sand_box:'HATCHET'},{sand_box:'CRANE CONTROL'},{sand_box:'BLUE TOOL BOX MISC TOOLS'},
                    {sand_box:'CABLE AND LOCK'},{sand_box:'D2 SPRAYER'}
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
        border: 1px solid #c4c4c4 !important;
    }

    .border-bottom{
        border-bottom: 1px solid #000 !important;
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

    th{
        width: 25% !important;
    }
</style>
