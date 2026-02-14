<template>

    <div class="d-flex justify-content-center">

        <button type="button" v-if="installation_id > 0 ? isUpdatePermitted : isCreatePermitted" class="btn-info mx-1 px-4 w-auto custom-infobtn-toolbar custom-infobtn-text" @click="save" :disabled="saveDisabled">
            {{ installation_id ? 'Update' : 'Save' }}<span v-if="saveDisabled" class="spinner-grow spinner-grow-sm ml-1"></span>
        </button>
        <router-link v-if="production_id > 0"class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/productions/' +production_id">Cancel</router-link>
        <router-link v-else class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" :to="'/orders/' +id">Cancel</router-link>

    </div>

</template>

<script>
    import { event , eventBus } from '../../../../event-bus/event-bus';
    export default {
        name: "Toolbar",
        props: {
            id:{
                type: Number,
                default: null
            },
            installation_id:{
                type: Number,
                default: null
            },
            production_id: {
                type: Number
            },
            saveDisabled:{
                type: Boolean,
                default: false
            },
            component:{
                type: Number,
                default: null
            },
        },
        computed:{
            recordList: function () {
                let options = [];
                for (let opt of this.$store.state[this.axiosParams.module].recordList){
                    let obj = {value: opt.id, text: opt.account_number};
                    options.push(obj);
                }
                return options;
            },
            totalRecords: function () {
                return this.$store.state[this.axiosParams.module].recordList.length;
            },
            currentRecord: function () {
                let list = this.$store.state[this.axiosParams.module].recordList;
                let record = list.find(obj => obj.id == this.id);
                let currentIndex = list.indexOf(record) + 1;
                return currentIndex
            },
            isCreatePermitted(){
                return (this.$store.getters.isPermitted({resource:'Orders',action:'create'})) || (this.$store.getters.isPermitted({resource:'Production',action:'create'}));
            },
            isUpdatePermitted(){
                return (this.$store.getters.isPermitted({resource:'Orders',action:'update'})) || (this.$store.getters.isPermitted({resource:'Production',action:'update'}));
            },
            /**
             * Directly placing id in v-model causing error "can not change prop in child component", so that's why
             using computed property to only get value and setting nothing in return
             */
            getSelected: {
                get () { return this.$props.id },
                set (value) { return value },
            }
        },
        data(){
            return {
                axiosParams: {module: 'installation'},
            }
        },
        methods: {
            save:function(){
                console.log('toolbar');
                let eventName = 'SAVE_ORDER_INSTALLATION_STEP'+this.$props.component;
                eventBus.$emit(event[eventName]);
            },
            getRecord: function (value) {
                eventBus.$emit(event.GET_ORDER_INSTALLATION, value);
            },
        }
    }
</script>

<style scoped>
    .toolbar
    {
        display: flex;
        margin: 0 1rem;
    }
    .input-md{
        width: 8rem;
    }
</style>
