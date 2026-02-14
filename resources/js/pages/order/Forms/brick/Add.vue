<template>
    <div>
        <Content :formFields="formFieldsData"></Content>

        <PDF :title="'printBrickForm'">

            <div slot="header" class="">
                <div class="d-flex justify-content-center">
                    <h3>BRICK FORM</h3>
                </div>
            </div>

            <div slot="body">
                <Content :formFields="formFieldsData"></Content>
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
            hideInModal: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                formFields: {
                    id: 0
                },
                axiosParams: {module: 'order/brick'},
            }
        },
        components: {
            PDF,
            Content
        },
        computed: {
            formFieldsData() {
                if (this.formFields.brick == null) {
                    this.formFields.brick = {};
                }
                if (this.formFields.company == null) {
                    this.formFields.company = {};
                }
                if (this.formFields.invoice == null) {
                    this.formFields.invoice = {};
                }
                if (this.formFields.family == null) {
                    this.formFields.family = {};
                }

                return this.formFields;
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
        methods: {
            getRecord() {
                this.axiosParams.id = this.formFields.id;
                fetchRecord(this.axiosParams, (response) => {
                    this.formFields = response.data;
                })
            },
        },
        metaInfo() {
            return {
                title: 'Brick Form'
            }
        },
    }
</script>

<style scoped>

    .buttons-row {
        display: flex;
        margin: 0.5rem auto;
        width: 40rem;
    }
</style>
