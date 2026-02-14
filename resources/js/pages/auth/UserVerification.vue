<template>
    <div class="flex flex-wrap w-full justify-center items-center">
        <NavBar></NavBar>
        <div class="d-flex justify-content-center">
            <div class="mt-5 border-3 p-5">
                <Error :errors="validationErrors" v-if="validationErrors"></Error>
                <Success :message="successMessage" v-if="successMessage"></Success>
                <div class="form-row">
                    <div>
                        <h6 class="my-auto custom-form-heading">Login into your account</h6>
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        <b-form-input type="email" @keyup.enter="verifyUser" class="input-lg" placeholder="Email" size="sm" v-model="formFields.email" ></b-form-input>
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        <b-form-input type="password" @keyup.enter="verifyUser" class="input-lg" placeholder="Password"  size="sm" v-model="formFields.password" ></b-form-input>
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        <b-form-input type="password" @keyup.enter="verifyUser" class="input-lg" placeholder="Confirm Password"  size="sm" v-model="formFields.password_confirmation" ></b-form-input>
                    </div>
                </div>
                <div class="form-row justify-content-center mt-4">
                    <button type="button" @click.prevent="verifyUser" class="btn-info custom-infobtn-toolbar custom-infobtn-text input-lg">
                        Login
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Success from "../../Modules/Success";
    import Error from "../../Modules/Error";
    import NavBar from "./NavBar";
    import {verifyUser} from "../../helpers/axios";
    export default {
        props: {
            hideInModal: {
                type: Boolean,
                default: false
            }
        },
        components: {
            NavBar,
            Error,
            Success
        },
        data(){
            return{
                formFields:{
                    token:null,
                    email: '',
                    password:'',
                    password_confirmation:''
                },
                validationErrors: '',
                successMessage: '',
                errors: []
            }
        },
        mounted() {
            this.formFields.token= this.$route.params.token ? this.$route.params.token : null;
        },
        methods:{
            verifyUser(){
                verifyUser(this.formFields, (response) => {
                    console.log('Auth',response);
                    let payload = {user:response.data[0],isLoggedIn:true};
                    this.$store.commit('setAuthUser', payload);
                    localStorage.setItem('authUser', JSON.stringify(payload));
                    this.validationErrors = '';
                    this.successMessage = 'You have been verified';
                    setTimeout(()=>{this.$router.push({ name: "Dashboard"});},3000);
                },(error) => {
                    if (error.response.status == 422){
                        this.successMessage = '';
                        this.validationErrors = error.response.data.errors;
                        //setTimeout(()=>{this.validationErrors ='';},3000);
                    }
                });
            }
        },
        metaInfo() {
            return {
                title: 'MPS - Login'
            }
        },
    }
</script>
<style scoped>
    .form-row
    {
        display: flex;
        margin: 0.5rem 0;
    }
    .form-row div
    {
        display: flex;
        margin: 0 10px;
    }
    .form-row div label{
        margin: auto 0.5rem;
        white-space: nowrap !important;
        width: 5rem;
    }
    .form-row div input,select,textarea{
        border: 1px solid #c4c4c4 !important;
        margin: auto;
        font-size: 0.7rem;
    }
    .input-lg{
        width: 18rem;
    }
</style>
