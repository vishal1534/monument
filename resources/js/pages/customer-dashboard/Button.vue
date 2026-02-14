<template>
    <div>
        <div class="d-flex justify-content-center">
            <div class="toolbar">
                <router-link :class="invoice ? 'button-background-color' : '' " class="btn-info btn-sm mx-1  custom-dangerbtn-toolbar custom-infobtn-text py-2 text-decoration-none" to="/invoice-list" exact>Invoice</router-link>
                <router-link :class="orderStatus ? 'button-background-color' : '' " class="btn-info btn-sm mx-1 custom-dangerbtn-toolbar custom-infobtn-text py-2 text-decoration-none" to="/customer-order-status-list" exact>Order Status</router-link>
                <router-link :class="approval ? 'button-background-color' : '' " class="btn-info btn-sm mx-1 custom-dangerbtn-toolbar custom-infobtn-text py-2 text-decoration-none" to="/customer-approval-list" exact>Approvals</router-link>
                <router-link :class="collaboration ? 'button-background-color' : '' " class="btn-info btn-sm mx-1 custom-dangerbtn-toolbar custom-infobtn-text py-2 text-decoration-none" to="/customer-collaboration-list" exact>Collaboration</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Button",
        props:{
          invoice :{
              type: Boolean,
              default: false
          },
          orderStatus:{
              type: Boolean,
              default: false
          },
          approval:{
              type: Boolean,
              default: false
          },
          collaboration: {
              type: Boolean,
              default: false
          }
        },
        data(){
            return{
                axiosParams: {module: 'customerToolButton'},
            }
        },
        computed:{
        },
        methods:{
        },
    }
</script>

<style scoped>
    .button-background-color{
        background: #58A8FF !important;
    }
</style>
