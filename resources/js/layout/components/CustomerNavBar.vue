<template>
    <div>
        <b-navbar toggleable="lg" type="dark" variant="info">
            <router-link class="custom-navbar-brand mr-2" to="/" exact>Monument</router-link>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav class="ml-auto">
                    <i class="fa fa-user fa-lg  mt-2" style="color: white;"></i>
                    <b-nav-item-dropdown :text="customerName" right>
                        <template>
                            <div class="mx-1">
                                <div class="text-center">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                            </div>
                            <div class="mx-2 text-center">
                                <div class="mx-1">
                                    <label style="font-size: 14px">{{userInfo.role ? userInfo.role.title : 'Inactive'}}</label>
                                </div>
                                <div class=" mx-1">
                                    <label style="font-size: 14px">{{userInfo.email? userInfo.email : ''}}</label>
                                </div>
                            </div>
                        </template>
                        <hr>
                        <div class="d-flex pt-2">
                            <div class="mx-1 w-50 pr-2 border-right">
                                <button class="dropdown-item custom-navbar-dropdown" @click.prevent="setUserProfile" v-b-modal.profile-update-modal >Profile</button>
                            </div>
                            <div class="mx-1 w-50">
                                <button class="dropdown-item custom-navbar-dropdown" @click.prevent="logoutUser">Logout</button>
                            </div>
                        </div>
                    </b-nav-item-dropdown>

                </b-navbar-nav>
            </b-collapse>
        </b-navbar>


        <b-modal id="profile-update-modal" title="User Profile">
            <template #modal-footer="{ ok, cancel, hide }">
                <b-button size="sm" variant="primary" @click="updateUserProfile">Update Profile</b-button>
            </template>
            <Error :errors="validationErrors" v-if="validationErrors"></Error>
            <Success :message="successMessage" v-if="successMessage"></Success>
            <div class="custom-row d-block">
                <b-form-input type="text" class="my-2" size="sm" placeholder="Name" v-model="formFields.name"></b-form-input>
                <b-form-input type="email" class="my-2" readonly size="sm" placeholder="Email" v-model="formFields.email"></b-form-input>
                <b-form-input type="password" class="my-2" size="sm" placeholder="New Password" v-model="formFields.password"></b-form-input>
                <b-form-input type="password" class="my-2" size="sm" placeholder="Confirm New Password" v-model="formFields.password_confirmation"></b-form-input>
            </div>
        </b-modal>

    </div>
</template>

<script>
    import Success from "../../Modules/Success";
    import Error from "../../Modules/Error";
    import {
        authUser, userDetail, updateProfile, logoutUser,
    } from "../../helpers/axios";
    import axios from "axios";
    export default {
        name: "CustomerNavBar",
        data() {
            return {
                formFields:{
                    name: '',
                    email: '',
                    password:'',
                    password_confirmation:''
                },
                user: {role:{}},
                errorResponse: false,
                hideMainMinWidth : false,
                validationErrors: '',
                successMessage: '',
            }
        },
        metaInfo() {
            return {
                title: 'MPS - Customer Portal'
            }
        },
        created() {
        },
        destroyed() {
        },
        computed:{
            userInfo:function () {
                let  element = document.getElementById('remove-width-style');
                element.classList.remove("remove-div-width-for-mobile");
                return this.user = this.$store.state['auth'].user ? this.$store.state['auth'].user: {role:{title:''}};
            },
            customerName:function () {
                if(this.$store.state['auth'].user && this.$store.state['auth'].user.role){
                    return  this.$store.state['auth'].user.name;
                }
            },
        },
        components:{
            Error,
            Success,
        },
        beforeCreate(){
            if (localStorage.authUser !== undefined) {
                let payload = JSON.parse(localStorage.getItem('authUser'));
                this.$store.commit('setAuthUser', payload);
                axios.defaults.headers.common['Authorization'] = `Bearer ${ localStorage.getItem('auth_token')}`
            }
            userDetail( (response) => {
                this.user = response.data;
                let payload = {user:response.data[0],isLoggedIn:true};
                this.$store.commit('setAuthUser', payload);
                localStorage.setItem('authUser', JSON.stringify(payload));
                axios.defaults.headers.common['Authorization'] = `Bearer ${ localStorage.getItem('auth_token')}`

            },(error) => {
                console.log('Auth',error);
            });

        },
        mounted() {
        },
        methods: {

            /**
             * CRUD
             * */
            setUserProfile(){
                this.successMessage = '';
                this.validationErrors = '';
                this.formFields.id = this.user.id ? this.user.id: 0;
                this.formFields.name = this.user.name ? this.user.name: '';
                this.formFields.email = this.user.email ? this.user.email: '';
                this.formFields.password ='';
                this.formFields.password_confirmation ='';
            },
            updateUserProfile(){
                updateProfile(this.formFields, (response) => {
                    let payload = {user:response.data,isLoggedIn:true};
                    this.$store.commit('setAuthUser', payload);
                    localStorage.setItem('authUser', JSON.stringify(payload));
                    this. validationErrors = '';
                    this.successMessage = 'Profile Successfully Updated';
                    setTimeout(()=>{this.successMessage ='';},3000);
                },(error) => {
                    if (error.response.status == 422){
                        this.successMessage = '';
                        this.validationErrors = error.response.data.errors;
                    }
                });
            },
            logoutUser(){
                logoutUser( (response) => {
                    let payload = {user:null,isLoggedIn:false,auth_token:null};
                    localStorage.clear();
                    this.$store.commit('setAuthUser', payload);
                    this.$router.push({ name: "Login"})
                },(error) => {
                    let payload = {user:null,isLoggedIn:false};
                    this.$store.commit('setAuthUser', payload);
                    this.$router.push({ name: "Login"})
                });
            },
        }
    }
</script>

<style scoped>

</style>
