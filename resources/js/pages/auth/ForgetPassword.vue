<template>
    <div class="flex flex-wrap w-full justify-center items-center">
        <NavBar></NavBar>
        <div class="d-flex justify-content-center">
            <div class="mt-5 border-3 p-5">
                <Error :errors="validationErrors" v-if="validationErrors"></Error>
                <Success :message="successMessage" v-if="successMessage"></Success>
                <div class="form-row">
                    <div>
                        <h6 class="my-auto custom-form-heading">Forget your password</h6>
                    </div>
                </div>
                <div class="form-row justify-content-center   mt-4">
                    <div>
                        <b-form-input type="text"  @keyup.enter="forgetPassword"  required  placeholder="Email" class="input-lg" name="name" size="sm" v-model="formFields.email" ></b-form-input>
                    </div>
                </div>
                <div class="form-row justify-content-center mt-2">
                    <button type="button"  @click.prevent="forgetPassword" class="btn-info custom-infobtn-toolbar custom-infobtn-text input-lg">
                        Send Reset Password Link
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    import Error from "../../Modules/Error";
    import NavBar from "./NavBar";
    import Success from "../../Modules/Success";
    import {forgetPassword} from "../../helpers/axios";
    export default {
        components: {
            Success,
            NavBar,
            Error
        },
        data(){
            return{
                formFields:{
                    email: '',
                },
                validationErrors: '',
                successMessage:''
            }
        },
        methods:{

            forgetPassword(){
                forgetPassword(this.formFields, (response) => {
                    console.log('Auth',response);
                    this. validationErrors = '';
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
                title: 'MPS - Forget Password'
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
