<template>

    <div>

        <div class="installation-row">
            <div class="installation-row flex-column">
                <h5 class="mx-2 mt-n4 text-center font-weight-bold" style="font-size:35px;">Frisbie Monument's
                </h5>
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
                    <template #head(inside_truck)="data">
                        <div class="my-n1 justify-content-start">
                            <label class="font-weight-bold">INSIDE TRUCK<br> CAB</label>
                        </div>
                    </template>
                    <template #head(adjust)="data">
                        <div class="my-n1 justify-content-start">
                            <label><span  class="font-weight-normal">ADJUST</span><br> <span class="font-weight-bold font-italic"> (FILL,REPLACE,ADD)</span></label>
                        </div>
                    </template>
                    <template #cell(inside_truck)="data">
                        <div  v-if="data.index == 0" style="height: 1.7rem !important">
                            <label class="mt-n2">BLACK BLANKETS <br> QTY. 2</label>
                        </div>
                        <div  v-else-if="data.index == 6" style="height: 1.7rem !important">
                            <label class="mt-n2">INSTALL CK LIST <br> AND CATALOGS</label>
                        </div>
                        <div  v-else-if="data.index == 7" style="height: 3.2rem !important">
                            <label class="mt-n2">MARKING PENCIL <br> WAX PENCILS qty3
                                <br> (red, white & yellow)</label>
                        </div>
                        <div  v-else-if="data.index == 11" style="height: 1.7rem !important">
                            <label class="mt-n2">MONUMENT TAGS &
                                <br> BUSINESS CARDS</label>
                        </div>
                        <div  v-else class="">
                            <label>{{ data.item.inside_truck}}</label>
                        </div>
                    </template>

                </b-table>
            </div>
        </div>
        <div class="installation-row mt-n1" style="page-break-after: always;">
            <div>
                <b-table  bordered class="printable-truckload-table-border" :items="items1" :fields="fields1">

                    <template #head()="data">
                        <div class="my-n1 justify-content-start">
                            <label class="font-weight-normal mt-n4">{{ data.label }}</label>
                        </div>
                    </template>
                    <template #head(back_of_truck)="data">
                        <div class="my-n1 justify-content-start">
                            <label class="font-weight-bold mt-n4">ON BACK OF <br>TRUCK</label>
                        </div>
                    </template>
                    <template #head(adjust)="data">
                        <div class="my-n1 justify-content-start">
                            <label><span  class="font-weight-normal">ADJUST</span><br> <span class="font-weight-bold font-italic"> (FILL,REPLACE,ADD)</span></label>
                        </div>
                    </template>
                    <template #cell(back_of_truck)="data">
                        <div  v-if="data.index == 0" style="height: 1.7rem !important">
                            <label class="mt-n2">SETTING DOLLY
                                <br><span class="font-weight-bold font-italic"> CK TIRE PRESURE</span></label>
                        </div>
                        <div  v-else-if="data.index == 3" style="height: 1.7rem !important">
                            <label class="mt-n2">SHARP SHOOTER <br>SHOVEL</label>
                        </div>
                        <div  v-else class="">
                            <label>{{ data.item.back_of_truck}}</label>
                        </div>
                    </template>

                </b-table>
            </div>
        </div>





    </div>

</template>

<script>
    export default {
        name: "Step-3",
        data(){
            return {
                fields: [
                    {
                        key: 'inside_truck',
                        label: 'INSIDE TRUCK CAB',
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
                    {inside_truck:'BLACK BLANKETS QTY. 2'},{inside_truck:'RUBBING PAPER'},{inside_truck:'JUMPER CABLES'},
                    {inside_truck:'EMERGENCY STUFF'},{inside_truck:'FIRE EXT.'},{inside_truck:'PROBE'},
                    {inside_truck:'INSTALL CK LIST AND CATALOGS'},{inside_truck:'MARKING PENCIL WAX PENCILS qty3(red, white & yellow)'},{inside_truck:'GRAY TARP'},
                    {inside_truck:'TIRE REPAIR KIT'},{inside_truck:'BAG IT BAG FOR DIRT'},{inside_truck:'MONUMENT TAGS & BUSINESS CARDS'}
                ],
                fields1: [
                    {
                        key: 'back_of_truck',
                        label: 'ON BACK OF TRUCK',
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
                    {back_of_truck:'SETTING DOLLY CK TIRE PRESURE'},{back_of_truck:'GRANITE SEAL'},{back_of_truck:'SHOVEL'},
                    {back_of_truck:'SHARP SHOOTER SHOVEL'},{back_of_truck:'HOE'}
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
