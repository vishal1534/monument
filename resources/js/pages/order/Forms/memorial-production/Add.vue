<template>
    <div>

        <div>
            <h5 class="mx-2 my-1 custom-view-heading non-print-elm">Memorial Production Form</h5>
            <div class="d-flex non-print-elm justify-content-center bg-toolbar my-2 p-1">
                <button type="button" v-if="formFields.memorial_production.id > 0 ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1 px-4 w-auto custom-infobtn-toolbar custom-infobtn-text"
                        @click="save" :disabled="saveDisabled">
                    {{ formFields.memorial_production.id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
                </button>
                <router-link v-if="production_id != undefined"
                             class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text"
                             :to="'/productions/' +production_id">Cancel
                </router-link>
                <router-link v-else class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text"
                             :to="'/orders/' +formFields.id">Cancel
                </router-link>

            </div>

            <Content :formFields="formFieldData" :production_id="production_id" :order_id="id"></Content>
        </div>


        <PDF :title="'printMemorialProduction'">

            <div slot="header" class="">
                <div class="mt-5 d-flex justify-content-center">
                    <h3>MEMORIAL PRODUCTION FORM</h3>
                </div>
            </div>

            <div slot="body">
                <Content :formFields="formFieldData" :inPDF="true"></Content>
            </div>

            <div slot="footer"></div>
        </PDF>

    </div>

</template>

<script>

    import {event, eventBus} from "../../../../event-bus/event-bus";
    import PDF from "../../../../Modules/PDF-Modal";
    import Content from "./Content";
    import {fetchRecord, saveRecord, deleteProduct} from "../../../../helpers/axios";
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
        computed:{
          formFieldData(){

              let list = ['design_carving_styles','darkening_agents','whitening_agents','no_panels','single_line_panels','double_line_panels',
                  'other_first_panels','other_second_panels','cqc_script_lettering','govt_text_lettering','modified_roman_lettering',
                  'runstone_lettering', 'connected_script_lettering','helvetica_lettering','opti_sb_lettering','vermarco_lettering',
                  'common_gothic_lettering', 'other_lettering', 'carving_v_sunk', 'carving_u_sunk', 'carving_shallow_sunk','carving_skin_sunk',
                  'carving_polish_raised_not_cleaned','carving_polish_raised_cleaned','carving_frosted_inlaid','carving_polish_inlaid',
                  'carving_frosted_edge','carving_polish_edge','carving_shadow_bar','products'];

              for (let i of list){
                  if (this.formFields.memorial_production[i] == undefined)
                      this.formFields.memorial_production[i] = [];
              }
              if(this.formFields.family == undefined){
                  this.formFields.family = {id:0};
              }

              return this.formFields
          },
          isCreatePermitted(){
            return (this.$store.getters.isPermitted({resource:'Orders',action:'create'})) || (this.$store.getters.isPermitted({resource:'Production',action:'create'}));
          },
          isUpdatePermitted(){
            return (this.$store.getters.isPermitted({resource:'Orders',action:'update'})) || (this.$store.getters.isPermitted({resource:'Production',action:'update'}));
          },
        },
        created(){
            eventBus.$on(event.SAVE_MEMORIAL_PRODUCTION, this.save);
            eventBus.$on(event.REMOVE_MEMORIAL_PRODUCTION, this.removeProduct);
        },
        destroyed(){
          eventBus.$off(event.SAVE_MEMORIAL_PRODUCTION)
          eventBus.$off(event.REMOVE_MEMORIAL_PRODUCTION)
        },
        data() {
            return  {
                formFields:{
                    id:0,
                    company:{},
                    invoice:{},
                    memorial_production:{products:[]}
                },
                axiosParams: {module: 'order/memorialProduction'},
                saveDisabled:false,
            }
        },
        components:{
            PDF,
            Content
        },
        beforeCreate(){
            if((!this.$store.getters.isPermitted({resource:'Orders',action:'read'})) && (!this.$store.getters.isPermitted({resource:'Production',action:'read'})))
                this.$router.push( '/access-denied');
        },
        mounted() {
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            this.formFields.production_id = this.$props.production_id ? this.$props.production_id : 0;
            this.getMemorialProduction();
            this.$store.getters.detectFormChanges();
        },
        methods:{
            getMemorialProduction(){
                this.axiosParams.id = this.formFields.id;
                fetchRecord(this.axiosParams, (response) => {
                    this.formFields = response.data;
                    this.formFields.production_id = this.$props.production_id ? this.$props.production_id : 0;

                })
            },
            save() {
                this.saveDisabled = true;
                let data = this.formFields;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));

                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: message, variant: 'danger'});
                    } else {
                        let message = `Record Successfully ${this.formFields.id ? 'Updated' : 'Added'}`;
                        this.makeToast({title: 'Success', message: message, variant: 'success'});
                        this.formFields.memorial_production = response.data
                    }
                },(error) => {
                    if (error.response.status == 403){
                        this.makeToast({title: 'Error', message: error.response.data.message , variant: 'danger', duration: 3000});
                    }
                })
            },
            getDayOfWeek:function(date) {
                if(date != null){
                    const dayOfWeek = new Date(date).getDay();

                    return isNaN(dayOfWeek) ? null :
                        ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'][dayOfWeek];
                }
            },
            makeToast(params) {
                this.$bvToast.toast(params.message, {
                    title: params.title,
                    variant: params.variant,
                    toaster: 'b-toaster-top-center',
                    autoHideDelay: 3000,
                    noCloseButton: true,
                })
                this.saveDisabled = false;//enabling save button
            },
            removeProduct: function (arg) {

                if (this.formFields.memorial_production.products.length == 1) {
                    this.makeToast({title: 'Alert', message: "At least one product required", variant: 'danger'});
                    return
                }

                this.formFields.memorial_production.products.splice(arg.index, 1);

                if (arg.id) {
                    let params = {module: 'order/deleteMemorialProductionProduct/', id: arg.id};
                    deleteProduct(params, (response) => {
                        if (response.data)
                            this.makeToast({title: 'Success', message: "Product deleted", variant: 'success'})
                    })
                }
            },
        },
    }
</script>

<style scoped>
</style>
