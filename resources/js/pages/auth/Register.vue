<template>
    <div>
        <div class="flex flex-wrap w-full justify-center items-center">
            <NavBar></NavBar>
            <div class="d-flex justify-content-center">
                <div class="mt-5 border-3 p-5">
                    <Error :errors="validationErrors" v-if="validationErrors"></Error>
                    <Success :message="successMessage" v-if="successMessage"></Success>
                    <div class="form-row">
                        <div>
                            <h6 class="my-auto custom-form-heading">Register an account</h6>
                        </div>
                    </div>
                    <div class="form-row mt-4">
                        <div>
<!--                            <label class="font-weight-bold col-4">Name:</label>-->
                            <b-form-input type="text"  @keyup.enter="registerUser" class="input-lg" placeholder="Name" size="sm" v-model="formFields.name" ></b-form-input>
                        </div>
                    </div>
                    <div class="form-row">
                        <div>
                            <b-form-input type="text" name="phone_number" @keyup.enter="registerUser" class="input-lg" placeholder="Phone Number" size="sm" v-model="formFields.phone_number" autocomplete="nope" ></b-form-input>
                        </div>
                    </div>
                    <div class="form-row">
                        <div>
                            <!--                            <label class="font-weight-bold col-4">Email:</label>-->
                            <b-form-input type="text" name="emailaddress" @keyup.enter="registerUser" class="input-lg" placeholder="Email" size="sm" v-model="formFields.email" ></b-form-input>
                        </div>
                    </div>
                    <div class="form-row">
                        <div>
<!--                            <label class="font-weight-bold col-4">Password:</label>-->
                            <b-form-input type="password" name="password" @keyup.enter="registerUser" class="input-lg" placeholder="Password"  size="sm" v-model="formFields.password" autocomplete="nope" ></b-form-input>
                        </div>
                    </div>
                    <div class="form-row">
                        <div>
<!--                            <label class="font-weight-bold col-4">Confirm Password:</label>-->
                            <b-form-input type="password" name="confirm_password" @keyup.enter="registerUser" class="input-lg" placeholder="Confirm Password"  size="sm" v-model="formFields.password_confirmation" autocomplete="nope"></b-form-input>
                        </div>
                    </div>
                    <div class="form-row justify-content-center mt-4">
                        <button type="button" @click.prevent="registerUser" class="btn-info custom-infobtn-toolbar custom-infobtn-text input-lg">
                            Register
                        </button>
                    </div>
                    <div class="col-9 justify-content-center form-row mt-3">
                        <div class="ml-n2">
                            <label>Already have an account? <router-link class="text-info" to="/login">Log in</router-link></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Success from "../../Modules/Success";
    import Error from "../../Modules/Error"
    import NavBar from "./NavBar";
    import {registerUser} from "../../helpers/axios";
    export default {
        components: {
            NavBar,
            Error,
            Success
        },
        data(){
            return{
                formFields:{
                    name: '',
                    email: '',
                    phone_number: '',
                    password:'',
                    password_confirmation:''
                },
                validationErrors:'',
                successMessage:'',
                errors:[]
            }
        },
        methods:{
            registerUser(){
                registerUser(this.formFields, (response) => {
                    console.log('Auth',response);
                    this.validationErrors = '';
                    this.successMessage = response.data.message;
                    //setTimeout(()=>{this.successMessage ='';},3000);
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
                title: 'MPS - Register'
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
    input:-webkit-autofill {
        -webkit-box-shadow: 0 0 0 1000px white inset !important;
    }
</style>
