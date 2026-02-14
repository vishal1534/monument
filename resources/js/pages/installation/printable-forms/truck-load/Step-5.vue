<template>

    <div>

        <div class="installation-row">
            <div class="installation-row flex-column">
                <h5 class="mx-2 my-1 text-center font-weight-bold" style="font-size:35px;">Frisbie Monument's
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
                    <template #head(setting_box)="data">
                        <div class="my-n1 justify-content-start">
                            <label class="font-weight-bold">SETTING TOOL<br> BOX</label>
                        </div>
                    </template>
                    <template #head(adjust)="data">
                        <div class="my-n1 justify-content-start">
                            <label><span  class="font-weight-normal">ADJUST</span><br> <span class="font-weight-bold font-italic"> (FILL,REPLACE,ADD)</span></label>
                        </div>
                    </template>
                    <template #cell(setting_box)="data">
                        <div  v-if="data.index == 0" style="height: 1.7rem !important">
                            <label class="mt-n2">GRAY SILICONE <br>QTY 2 TUBES</label>
                        </div>
                        <div  v-else-if="data.index == 1" style="height: 1.7rem !important">
                            <label class="mt-n2">BROWN SILICONE <br>QTY. 2 TUBES</label>
                        </div>
                        <div v-else-if="data.index == 2" style="height: 1.7rem !important">
                            <label class="mt-n2">CAULK GUN <br> QTY. 2</label>
                        </div>
                        <div v-else-if="data.index == 3" style="height: 1.7rem !important">
                            <label class="mt-n2">TAPE MEASURE <br>QTY. 2</label>
                        </div>
                        <div  v-else-if="data.index == 8" style="height: 1.7rem !important">
                            <label class="mt-n2">BOX KNIFE <br> QTY. 2</label>
                        </div>
                        <div  v-else class="">
                            <label>{{ data.item.setting_box}}</label>
                        </div>
                    </template>

                </b-table>
            </div>
        </div>
        <div class="installation-row d-block">
            <div class="justify-content-center">
                <label>Signature of checker:_________________________________________________</label>
            </div>
            <div class="justify-content-center">
                <label class="ml-0">Signature of installer:_________________________________________________</label>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "Step-5",
        data(){
            return {
                fields: [
                    {
                        key: 'setting_box',
                        label: 'SETTING TOOL BOX',
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
                    {setting_box:'GRAY SILICONE QTY 2 TUBES'},{setting_box:'BROWN SILICONE QTY. 2 TUBES'},{setting_box:'CAULK GUN QTY. 2S'},
                    {setting_box:'TAPE MEASURE QTY. 2'},{setting_box:'TORPEDO LEVEL'},{setting_box:'MARKING PAINT'},
                    {setting_box:'PRY BAR'},{setting_box:'SCRAPERS'},{setting_box:'BOX KNIFE QTY. 2'}, {setting_box:'BLADES'},
                    {setting_box:'HAND BROOM'},{setting_box:'TROWEL'},{setting_box:'MASKING TAPE'},{setting_box:'SCREW DRIVERS'},
                    {setting_box:'SCRAPERS'},{setting_box:'STRING LINE'}
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
