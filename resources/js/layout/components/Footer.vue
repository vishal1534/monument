<template>

        <footer class="main-footer card p-2">
            <div class="d-flex">
                <strong>Copyright &copy; 2021 <router-link to="/">Monument</router-link>.</strong>
                <p class="my-auto mx-2">All rights reserved.</p>
                <div class="ml-auto">
                    <strong>Version</strong> 2.0
                </div>
            </div>

        </footer>

</template>

<script>
    export default {
        name: "Footer"
    }
</script>

<style scoped>
    .main-footer{
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 2.5rem;
    }
</style>
