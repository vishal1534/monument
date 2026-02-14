<template>

    <div>

        <Content :formFields="formFieldsData"></Content>

        <PDF :title="'printGranitBronzPreciousForm'">

            <div slot="header">
                <div class="d-flex justify-content-center">
                    <h3>Granit Bronz Precious Portrait Order Form</h3>
                </div>
            </div>

            <div slot="body">
                <Content v-if="pdfButtonClicked" :formFields="formFieldsData" :inPDF="true"></Content>
            </div>

        </PDF>

    </div>

</template>

<script>
import PDF from "../../../../Modules/PDF-Modal";
import Content from "./Content";
import {fetchRecord} from "../../../../helpers/axios";
import {event, eventBus} from "../../../../event-bus/event-bus";

export default {
    name: "GranitBronzPreciousForm",
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
            title: 'Granit Bronz Precious Form'
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
            if (this.formFields.granit_bronz_precious == null){
                this.formFields.granit_bronz_precious = {};
            }

            if (this.formFields.granit_bronz_precious.horizontal_photographs == undefined)
                this.formFields.granit_bronz_precious.horizontal_photographs = [];
            else if (typeof this.formFields.granit_bronz_precious.horizontal_photographs == 'string')
                this.formFields.granit_bronz_precious.horizontal_photographs = this.formFields.granit_bronz_precious.horizontal_photographs.split(',');

            if (this.formFields.granit_bronz_precious.vertical_photographs == undefined)
                this.formFields.granit_bronz_precious.vertical_photographs = [];
            else if (typeof this.formFields.granit_bronz_precious.vertical_photographs == 'string')
                this.formFields.granit_bronz_precious.vertical_photographs = this.formFields.granit_bronz_precious.vertical_photographs.split(',');

            if (this.formFields.company == null){
                this.formFields.company = {};
            }
            if (this.formFields.family == null){
                this.formFields.family = {};
            }
            if (this.formFields.invoice == null){
                this.formFields.invoice = {payments:[]};
            }

            if (this.formFields.granit_bronz_precious.flat_portrait == null){
                this.formFields.granit_bronz_precious.flat_portrait = {};
                this.formFields.granit_bronz_precious.flat_pinned_portrait = {};
                this.formFields.granit_bronz_precious.flat_portrait_vhb_type = {};
                this.formFields.granit_bronz_precious.domed_portrait = {};
                this.formFields.granit_bronz_precious.domed_pinned_portrait = {};
                this.formFields.granit_bronz_precious.original_frame = {};
                this.formFields.granit_bronz_precious.polished_frame = {};
                this.formFields.granit_bronz_precious.plain_colored = {};
                this.formFields.granit_bronz_precious.plain_polished = {};
                this.formFields.granit_bronz_precious.decorative_colored = {};
                this.formFields.granit_bronz_precious.decorative_polished = {};
                this.formFields.granit_bronz_precious.cast_bronze_ring = {};
            }
            // if (this.formFields.granit_bronz_precious.specifications == null){
            //     // this.formFields.granit_bronz_precious.specifications = [];
            //     this.$set(this.formFields.granit_bronz_precious, 'specifications', ['portrait'])
            //
            // }
            return this.formFields;
        }
    },
    data(){
        return {
            formFields:{
                id:0,
                specifications: []
            },
            pdfButtonClicked: false,
            axiosParams: {module: 'order/granit_bronz_precious'},
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
    created() {
        eventBus.$on(event.GRANITE_BRONZ_PRECIOUS, this.updateFormField);
    },
    destroyed() {
        eventBus.$off(event.GRANITE_BRONZ_PRECIOUS);
    },
    methods:{
        getRecord(){
            this.axiosParams.id = this.formFields.id;
            fetchRecord(this.axiosParams, (response) => {
                this.formFields = response.data;
            })
        },
        updateFormField: function (togglePDF) {
                this.pdfButtonClicked = togglePDF
        },
    }
}
</script>

<style scoped>
</style>
