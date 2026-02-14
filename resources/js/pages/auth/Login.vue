<template>
     <div class="flex flex-wrap w-full justify-center items-center">
         <NavBar></NavBar>
        <div class="d-flex justify-content-center">
            <div class="mt-5 border-3 p-5">
                <Error :errors="validationErrors" v-if="validationErrors"></Error>
                <div class="form-row">
                    <div>
                        <h6 class="my-auto custom-form-heading">Login to your account</h6>
                    </div>
                </div>
                <div class="form-row justify-content-center   mt-4">
                    <div>
                        <b-form-input type="text"  @keyup.enter="loginUser"  required  placeholder="Email" class="input-lg" name="name" size="sm" v-model="formFields.email" ></b-form-input>
                    </div>
                </div>
                <div class="form-row justify-content-center ">
                        <div>
                            <b-form-input type="password" @keyup.enter="loginUser" required  placeholder="Password" class="input-lg" name="address" size="sm" v-model="formFields.password" ></b-form-input>
                        </div>
                </div>
              <!--  <div class="form-row">
                        <div class="justify-content-start mt-2">
                            <div class="ml-n2">
                                <b-form-checkbox
                                        class="custom-radio-and-checkbox"
                                        id="checkbox-1"
                                        v-model="formFields.remember_me"
                                        name="checkbox-1"
                                        :value=true
                                        :unchecked-value=false
                                >
                                    Remember Me
                                </b-form-checkbox>
                            </div>
                        </div>
                </div>-->
                <div class="form-row justify-content-center mt-2">
                    <button type="button" @click.prevent="loginUser" class="btn-info custom-infobtn-toolbar custom-infobtn-text input-lg">
                        Login
                    </button>
                </div>
                <div class="form-row justify-content-end ">
                    <div class="mr-4">
                        <label class="col-4 mr-5 "> <router-link class="text-info" to="/forget-password">Forget Your Password?</router-link></label>
                    </div>
                </div>
                <div class="col-9 justify-content-center form-row mt-3">
                    <div class="ml-n2">
                        <label>Don't have an account? <router-link class="text-info" to="/register">Create one</router-link></label>
                    </div>
                </div>
            </div>
        </div>
         {{removeWidth}}

    </div>
</template>
<script>
    import axios from 'axios';
    import Error from "../../Modules/Error";
    import NavBar from "./NavBar";
    import {loginUser,authUser} from "../../helpers/axios";
    export default {
        components: {
            NavBar,
            Error
        },
        data(){
            return{
                formFields:{
                    email: '',
                    password: '',
                    remember_me:false
                },
                validationErrors: '',
                errors: []
            }
        },
        computed:{
          removeWidth(){
              let  element = document.getElementById('remove-width-style');
              element.classList.remove("remove-div-width-for-mobile");
          }
        },
        methods:{

             loginUser(){
                 axios.get('/sanctum/csrf-cookie').then(()=>{
                     axios.get('/api/authenticated').then(()=>{
                         authUser( (response) => {
                             alert('User Already Logged In');
                             //console.log('Auth',response);
                             this.user = response.data;
                             let auth_token = response.data.auth_token;
                             let payload = {user:response.data[0],isLoggedIn:true};
                             this.$store.commit('setAuthUser', payload);
                             localStorage.setItem('auth_token', JSON.stringify(auth_token));
                             localStorage.setItem('authUser', JSON.stringify(payload));
                             auth_token = auth_token.replace(/['"]+/g, '');
                            axios.defaults.headers['Authorization'] = `Bearer ${auth_token}`;
                            // axios.defaults.headers.common = {'Authorization': `Bearer ${auth_token}`};
                             if (response.data[0].role.title == 'Customer'){
                                 this.$router.push("/customer-portal").catch(()=>{});
                             }else{
                                 this.$router.push({ name: "Dashboard"});
                             }

                         },(error) => {
                             console.log('Auth',error);
                         });
                     }).catch(()=>{
                         loginUser(this.formFields, (response) => {
                             //console.log('Auth',response);
                             let auth_token = response.data.auth_token;
                             auth_token = auth_token.replace(/['"]+/g, '');
                             let payload = {user:response.data[0],isLoggedIn:true};
                             this.$store.commit('setAuthUser', payload);
                             localStorage.setItem('authUser', JSON.stringify(payload));
                             localStorage.setItem('auth_token', JSON.stringify(auth_token));
                             axios.defaults.headers['Authorization'] = `Bearer ${auth_token}`;
                             //axios.defaults.headers.common = {'Authorization': `Bearer ${auth_token}`};
                             if (response.data[0].role.title == 'Customer'){
                                 this.$router.push("/customer-portal").catch(()=>{});
                             }else{
                                 this.$router.push(this.$route.query.redirect || '/');
                             }
                         },(error) => {
                             if (error.response.status == 422){
                                 this.validationErrors = error.response.data.errors;
                                 //setTimeout(()=>{this.validationErrors ='';},3000);
                             }
                         });
                     })
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
