<template>
    <div v-if="successMessage">
        <ul class="alert alert-success">
            <li class="font-weight-bold">{{ message }}</li>
        </ul>
    </div>
</template>
<script>
    export default {
        name: "Success",
        data(){
            return {

            }
        },
        props: ['message'],
        computed: {
            successMessage(){
                return this.message;
            }
        }
    }
</script>

<style scoped>
    li{
        font-size: 12px !important;
    }
</style>


