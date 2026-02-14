<template>

    <div>

        <div class="row">
            <div class="col-md-12">

                <form class="div-shadow bg-white rounded mx-2 mb-2 p-3">
                    <div class="form-content">
                        <h6 class="font-weight-bold my-1 text-center">Soldier's Memorial Legacy Brick</h6>

                        <div class="brick-row brick-custom-border-bottom my-3">
                            <label class="m-0 brick-custom-label">Name:</label>
                        </div>
                        <div class="brick-row brick-custom-border-bottom my-3">
                            <label class="m-0 brick-custom-label">Phone:</label>
                        </div>
                        <div class="brick-row brick-custom-border-bottom my-3">
                            <label class="m-0 brick-custom-label">Address:</label>
                        </div>
                        <div class="brick-row">
                            <label class="mx-auto">Message for your Legacy Brick:</label>
                        </div>
                        <div class="brick-row flex-wrap">
                            <div class="justify-content-between">
                                <template v-for="(s, i) in 14">
                                    <b-form-input type="text" class="input-sm my-1 mx-2 border-3 border-dark rounded-0 bg-white" readonly size="sm" maxlength="1"></b-form-input>
                                </template>
                            </div>
                            <div class="justify-content-between">
                                <template v-for="(s, i) in 14">
                                    <b-form-input type="text" class="input-sm my-1 mx-2 border-3 border-dark rounded-0 bg-white" readonly size="sm" maxlength="1"></b-form-input>
                                </template>
                            </div>
                            <div class="justify-content-between">
                                <template v-for="(s, i) in 14">
                                    <b-form-input type="text" class="input-sm my-1 mx-2 border-3 border-dark rounded-0 bg-white" readonly size="sm" maxlength="1"></b-form-input>
                                </template>
                            </div>

                        </div>

                        <div style="margin-top: 6rem;"></div>

                        <div class="brick-row brick-custom-border-bottom my-3">
                            <label class="m-0 brick-custom-label">Name:</label>
                        </div>
                        <div class="brick-row brick-custom-border-bottom my-3">
                            <label class="m-0 brick-custom-label">Phone:</label>
                        </div>
                        <div class="brick-row brick-custom-border-bottom my-3">
                            <label class="m-0 brick-custom-label">Address:</label>
                        </div>
                        <div class="brick-row">
                            <label class="mx-auto">Message for your Legacy Brick:</label>
                        </div>
                        <div class="brick-row flex-wrap">
                            <div class="justify-content-between">
                                <template v-for="(s, i) in 14">
                                    <b-form-input type="text" class="input-sm my-1 mx-2 border-3 border-dark rounded-0 bg-white" readonly size="sm" maxlength="1"></b-form-input>
                                </template>
                            </div>
                            <div class="justify-content-between">
                                <template v-for="(s, i) in 14">
                                    <b-form-input type="text" class="input-sm my-1 mx-2 border-3 border-dark rounded-0 bg-white" readonly size="sm" maxlength="1"></b-form-input>
                                </template>
                            </div>
                            <div class="justify-content-between">
                                <template v-for="(s, i) in 14">
                                    <b-form-input type="text" class="input-sm my-1 mx-2 border-3 border-dark rounded-0 bg-white" readonly size="sm" maxlength="1"></b-form-input>
                                </template>
                            </div>

                        </div>


                        <div class="brick-row px-5" style="margin-top: 8rem;">
                            <div>
                                <label class="brick-custom-label" style="font-family: Arial !important;">Approved by:</label>
<!--                                <div class="custom-border-bottom mx-1"></div>-->
                            <hr class="bg-dark mt-3 w-100">
                            </div>
                            <div>
                                <label class="brick-custom-label" style="font-family: Arial !important;">Date:</label>
<!--                                <div class="custom-border-bottom mx-1"></div>-->
                                <hr class="bg-dark mt-3 w-100">
                            </div>
                        </div>
                        <div class="d-block text-center m-0 brick-custom-label" style="font-family: Arial !important; line-height: 16.5px !important;">
                            <label class="d-block m-0">BY SIGNING THE APPROVAL I ASSUME COMPLETE RESPONSIBILITY FOR LAYOUT/SPELLING/DATES.</label>
                            <label class="d-block m-0">I ALSO AGREE THAT AFTER SIGNING THE APPROVAL, NO FURTHER CHANGES WILL BE MADE & IF </label>
                            <label class="d-block m-0">SOMETHING IS INCORRECT UPON COMPLETION OF THE MONUMENT I AM RESPONSIBLE</label>
                            <label class="d-block m-0">FOR THE COST TO CORRECT IT.</label>

                        </div>

                        <div class="brick-row non-print-elm">
                            <div>
                                <button type="button" class="btn btn-sm btn-info custom-print-button px-2 ml-2" @click="printPDF">Print Preview</button>
                            </div>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

</template>

<script>
import {saveRecord, fetchRecord} from "../../../../helpers/axios";
import {event, eventBus} from "../../../../event-bus/event-bus";

export default {
    name: "Content",

    computed:{
    },
    data(){
        return {
        }
    },
    methods:{
        printPDF(){
            eventBus.$emit(event.PRINT_PDF)
        },
    }

}
</script>

<style scoped>
.form-content{
    margin: 0 auto;
    width: 45rem;
}
.brick-row
{
    display: flex;
    padding: 0;
}
.brick-row div
{
    display: flex;
    margin: 0.3rem 0;
    width: 100%;
}
.brick-row div label{
    margin: auto 0.5rem;
    white-space: nowrap !important;
}
.brick-row div input{
    /*border: 1px solid #dee2e6;*/
    margin: auto;
    margin-right: 0;
    height: 1.5rem;
}
header{
    padding: 0 3rem;
}
.input-xl{
    width: 20rem;
}
.input-lg{
    width: 12rem;
}
.input-md{
    width: 6rem;
}
.input-sm{
    width: 2.2rem;
    height: 1.4rem;
}
.brick-custom-label{
    font-family: "Times New Roman" !important;
    text-transform: uppercase !important;
}
.brick-custom-border-bottom{
    border-bottom: 2px solid #000 !important;
}
.printing input, .printing textarea{
    border-color: inherit !important;
}

</style>
