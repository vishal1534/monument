<template>

    <div>

        <Content :formFields="formFields"></Content>

        <PDF :title="'printQuoteToOrderForm'">

            <div slot="header" class="">
                <div class="d-flex justify-content-center">
                    <h3>Quote Order FORM</h3>
                </div>
            </div>

            <div slot="body">
                <Content :formFields="formFields"></Content>
            </div>

        </PDF>

    </div>

</template>

<script>
import PDF from "../../../../Modules/PDF-Modal";
import Content from "./Content";
import {fetchRecord} from "../../../../helpers/axios";

export default {
    name: "OrderForm",
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
            title: 'Order Form'
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
    },
    data(){
        return {
            formFields:{
                id:0,
                company:{},
                invoice:{},
                order_form:{}
            },
            axiosParams: {module: 'order/form'},
        }
    },
    beforeCreate(){
        if(!this.$store.getters.isPermitted({resource:'Orders',action:'read'}))
            this.$router.push( '/access-denied');
    },
    mounted() {
        this.formFields.id = this.$props.id ? this.$props.id : 0;
        this.getOrderForm();
        this.$store.getters.detectFormChanges();
    },
    methods:{
        getOrderForm(){
            this.axiosParams.id = this.formFields.id;
            fetchRecord(this.axiosParams, (response) => {
                this.formFields = response.data;
            })
        },
    }

}
</script>

<style scoped>
</style>
