<template>
    <div class="wrapper">
        <b-navbar toggleable="md" type="dark" variant="secondary">
            <b-navbar-brand class="custom-navbar-brand mr-2" href="#">Monument</b-navbar-brand>
            <!--<router-link class="custom-navbar-brand mr-2" to="#">Monument</router-link>-->

            <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

            <b-collapse is-nav id="nav_collapse" class="justify-content-end">
                <b-navbar-nav >
                    <router-link class="nav-link" to="/login">Login</router-link>
                    <router-link class="nav-link" to="/register">Register</router-link>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>

    </div>
</template>

<script>
    export default {
        name: "NavBar",
    }
</script>

<style scoped>

</style>
