<template>

    <div>

        <Content :formFields="formFieldsData"></Content>

        <PDF :title="'printGranitBronzMemorialForm'">

            <div slot="header">
                <div class="d-flex justify-content-center">
                    <h3>Granit Bronz Memorial Order Form</h3>
                </div>
            </div>

            <div slot="body">
                <Content :formFields="formFieldsData"></Content>
            </div>

        </PDF>

    </div>

</template>

<script>
import PDF from "../../../../Modules/PDF-Modal";
import Content from "./Content";
import {fetchRecord} from "../../../../helpers/axios";

export default {
    name: "GranitBronzMemorialForm",
    props: {
        id:{
            type: Number,
            default: null
        },
    },
    components:{
        PDF,
        Content
    },
    metaInfo() {
        return {
            title: 'Granit Bronz Memorial Form'
        }
    },
    computed:{
        alertClasses: function () {
            return {
                alert: true,
                'alert-success': this.successResponse,
                'alert-danger': this.errorResponse,
                'd-none': this.hideAlert
            }
        },
        formFieldsData (){
            if (this.formFields.granit_bronz_memorial == null){
                this.formFields.granit_bronz_memorial = {};
            }
            if (this.formFields.company == null){
                this.formFields.company = {};
            }
            if (this.formFields.invoice == null){
                this.formFields.invoice = {payments:[]};
            }

            if (this.formFields.family == null){
                this.formFields.family = {};
            }

            if (this.formFields.granit_bronz_memorial.order_types == undefined)
                this.formFields.granit_bronz_memorial.order_types = [];


            if (this.formFields.granit_bronz_memorial.vases == undefined)
                this.formFields.granit_bronz_memorial.vases = [];

            if (this.formFields.granit_bronz_memorial.oxidation_colors == undefined)
                this.formFields.granit_bronz_memorial.oxidation_colors = [];

            if (this.formFields.granit_bronz_memorial.letter_styles == undefined)
                this.formFields.granit_bronz_memorial.letter_styles = [];

            if (this.formFields.granit_bronz_memorial.scroll_types == undefined)
                this.formFields.granit_bronz_memorial.scroll_types = [];

            if (this.formFields.granit_bronz_memorial.custom_colors == undefined)
                this.formFields.granit_bronz_memorial.custom_colors = [];

            if (this.formFields.granit_bronz_memorial.layouts == undefined)
                this.formFields.granit_bronz_memorial.layouts = [];

            return this.formFields;
        }
    },
    data(){
        return {
            formFields:{
                id:0
            },
            axiosParams: {module: 'order/granit_bronz_memorial'},
        }
    },
    beforeCreate(){
        if(!this.$store.getters.isPermitted({resource:'Orders',action:'read'}))
            this.$router.push( '/access-denied');
    },
    mounted() {
        this.formFields.id = this.$props.id ? this.$props.id : 0;
        this.getRecord();
        this.$store.getters.detectFormChanges();
    },
    methods:{
        getRecord(){
            this.axiosParams.id = this.formFields.id;
            fetchRecord(this.axiosParams, (response) => {
                this.formFields = response.data;
            })
        },
    },
    metaInfo() {
        return {
            title: 'Granit Bronz Memorial Form'
        }
    },

}
</script>

<style scoped>
</style>
