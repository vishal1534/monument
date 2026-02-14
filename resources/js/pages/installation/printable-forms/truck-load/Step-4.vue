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
                        <div  v-if="data.index == 3" style="height: 1.7rem !important">
                            <label class="mt-n2">MANUAL POST HOLE <br>DIGGER</label>
                        </div>
                        <div  v-else-if="data.index == 4" style="height: 1.7rem !important">
                            <label class="mt-n2">GAS POST HOLE AUGER
                                <br><span class="font-weight-bold font-italic">(CK GAS)</span></label>
                        </div>
                        <div  v-else-if="data.index == 8" style="height: 1.7rem !important">
                            <label class="mt-n2">WHEEL BARROW
                                <br><span class="font-weight-bold font-italic">CK TIRE PRESURE</span></label>
                        </div>
                        <div  v-else-if="data.index == 12" style="height: 1.7rem !important">
                            <label class="mt-n2">WATER BUCKETS<br>QTY. 3</label>
                        </div>
                        <div  v-else-if="data.index == 15" style="height: 1.7rem !important">
                            <label class="mt-n2">GRASS SEED
                                <br><span class="font-weight-bold font-italic">(IN FOLGERS CAN)</span></label>
                        </div>
                        <div  v-else-if="data.index == 16" style="height: 1.7rem !important">
                            <label class="mt-n2">BUCKET OF PEA<br> GRAVEL</label>
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
        name: "Step-4",
        data(){
            return {
                fields: [
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
                items: [
                    {back_of_truck:'RAKE'},{back_of_truck:'PICK AX'},{back_of_truck:'4FT LEVEL'},
                    {back_of_truck:'MANUAL POST HOLE DIGGER'},{back_of_truck:'GAS POST HOLE AUGER (CK GAS)'},
                    {back_of_truck:'DINGO ROLLER BAR'},{back_of_truck:'CRANE ROLLER BAR'},{back_of_truck:'TAMPER'},
                    {back_of_truck:'WHEEL BARROW CK TIRE PRESURE'},{back_of_truck:'ORANGE PINCH BAR'},
                    {back_of_truck:'BLUE ROLLER'}, {back_of_truck:'2 WHEEL CHALKS'},{back_of_truck:'WATER BUCKETS QTY. 3'},
                    {back_of_truck:'2x4’s'},{back_of_truck:'1x4’s'},{back_of_truck:'GRASS SEED (IN FOLGERS CAN)'},
                    {back_of_truck:'BUCKET OF PEA GRAVEL'}
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
