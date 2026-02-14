<template>
    <div>
        <!-- The modal -->
        <b-modal id="'Select'"
                 size="xl"
                 scrollable
                 ok-only
                 ok-title="Cancel"
                 ok-variant="secondary"
                 :title="title">

            <template #modal-footer="{ ok, cancel}">
                <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
                <!-- Button with custom method trigger -->
                <b-button size="sm" variant="secondary" @click="save">Save</b-button>
            </template>

            <component is="Company" :hide-in-modal="false"></component>
        </b-modal>
    </div>
</template>

<script>

    import Company from "../company/Add";
    import { event , eventBus } from '../../event-bus/event-bus';
    export default {
        name: "Modal",
        props: {
            title: {
                type: String
            },
        },
        components:{
            Company,
            event,
            eventBus
        },
        methods:{
            save(){
                eventBus.$emit(event.SAVE_COMPANY);
            }
        }
    }
</script>

<style scoped>

</style>
