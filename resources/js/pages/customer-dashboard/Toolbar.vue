<template>
    <div class="d-flex align-items-center w-100">
        <div  class="toolbar d-flex ml-auto">
            Welcome {{customerName}}!
        </div>

        <div class="toolbar ml-auto">
            <div class="d-flex mt-1">
                <img class="toolbar-image mx-1 mt-1" src="/images/video-chat.png" width="26" height="26"/>
                <img class="toolbar-image mx-1" src="/images/help-icon.png" width="30" height="30"/>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "Toolbar",
        props:{
            customerName:{
                type:String,
                default: null
            }
        },
        computed:{

        },
        data() {
            return {
                axiosParams: {module: 'CustomerPortal'},
                searchTerm: "",
            }
        },
        methods: {

        }
    }
</script>

<style scoped>
    .toolbar
    {
        display: flex;
        margin: 0 1rem;
    }
</style>
