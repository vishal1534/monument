<template>
    <div>
        <Content :formFields="formFields" :production_id="production_id" :order_id="id"></Content>

        <PDF :title="'printApprovalMonument'">

            <div slot="header" class="">
                <div class="d-flex justify-content-center">
                    <h3>APPROVAL MONUMENT FORM</h3>
                </div>
            </div>

            <div slot="body">
                <Content :formFields="formFields" ></Content>
            </div>

            <div slot="footer"></div>
        </PDF>

    </div>

</template>

<script>

import PDF from "../../../../Modules/PDF-Modal";
import Content from "./Content";
import {fetchRecord} from "../../../../helpers/axios";
export default {
    name: "Add",
    props: {
        id: {
            type: Number
        },
        production_id: {
            type: Number
        },
        hideInModal: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return  {
            formFields:{
                id:0,
                production_id:0,
                imagefront:null,
                imageback:null,
            },
            imagePath:'images/approval-monument/',
            imageDefault: 'images/default-image.jpg',
            axiosParams: {module: 'order/approvalMonument'},

        }
    },
    components:{
        PDF,
        Content
    },
    metaInfo() {
        return {
            title: 'Approval Monument'
        }
    },
    computed:{
    },
    mounted() {
        this.formFields.id = this.$props.id ? this.$props.id : 0;
        this.getAppovalMonument();
    },
    methods:{
        getAppovalMonument(){
            this.axiosParams.id = this.formFields.id;
            fetchRecord(this.axiosParams, (response) => {
                this.formFields = response.data.approval_monument;
                this.formFields.order_date = response.data.date;
                this.formFields.imagefront =  this.formFields.image_front ? this.imagePath + this.formFields.image_front : this.imageDefault;
                this.formFields.imageback =  this.formFields.image_back ? this.imagePath + this.formFields.image_back : this.imageDefault;
                this.formFields.production_id = this.$props.production_id ? this.$props.production_id : 0;
            })
        },
    },
}
</script>

<style scoped>

.buttons-row{
    display: flex;
    margin: 0.5rem auto;
    width: 40rem;
}
</style>
