<template>
    <div>
        <h5 class="mx-2 my-1 custom-view-heading">Customer Portal </h5>
        <div class="bg-toolbar my-2 p-1">
            <Toolbar :customerName="customerName"></Toolbar>
        </div>
        <div>
            <Button></Button>
        </div>
    </div>
</template>

<script>
    import { event , eventBus } from '../../event-bus/event-bus';
    import Toolbar from "./Toolbar";
    import Button from './Button';

    export default {
        name: "Dashboard",
        data() {
            return {
                formFields:{
                },
                axiosParams: {module: 'customerPortal'},
                saveDisabled:false,
                invoiceList : false,
            }
        },
        metaInfo() {
            return {
                title: 'MPS - Customer Portal'
            }
        },
        created() {
            eventBus.$on(event.LOAD_CUSTOMER_INVOICE_LIST, this.loadInvoiceList);
        },
        destroyed() {
            eventBus.$off(event.LOAD_CUSTOMER_INVOICE_LIST, this.loadInvoiceList);
        },
        computed:{
            customerName:function () {
                return this.$store.getters.getUserName;
            },
        },
        components:{
            Toolbar,
            Button
        },
        beforeCreate(){
            if(!this.$store.getters.isPermitted({resource:'Customer Portal',action:'read'}))
                this.$router.push( '/access-denied');
        },
        mounted() {
        },
        methods: {

            /**
             * CRUD
             * */
            loadInvoiceList: function () {
             this.invoiceList = !this.invoiceList;
            },
        }
    }

</script>

<style scoped>
    .company-row div
    {
        display: flex;
        margin: 0 10px;
    }
    .company-row div label{
        margin: auto 0.5rem;
        white-space: nowrap !important;
        width: 5rem;
    }
    .company-row div input,select,textarea{
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.7rem;
    }
</style>
