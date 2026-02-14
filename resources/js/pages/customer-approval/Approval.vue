<template>
    <div>
        <h5 class="mx-2 my-1 custom-view-heading">Customer Portal</h5>
        <div class="bg-toolbar my-2 p-1">
            <Toolbar :customerName="customerName"></Toolbar>
        </div>
        <div>
            <Button :approval="true"></Button>
        </div>
        <hr class="my-3">
        <b-form class="div-shadow bg-white rounded mx-2 mb-2">
            <div class="d-flex justify-content-center title-style col-md-12 my-2">
                APPROVALS
            </div>
            <div class="row">
                        <div class="col-md-1 px-4 mb-1">
                            <label>Approvals</label>
                        </div>
                        <div class="col-md-5 px-4 mb-1">
                            <b-button
                                :class="visibleApprovals ? 'btn btn-sm bg-white text-dark  text-left border w-100' : 'w-100 btn btn-sm  bg-white text-dark text-left border collapsed'"
                                :aria-expanded="visibleApprovals ? 'true' : 'false'"
                                aria-controls="collapse-approval"
                                @click="visibleApprovals = !visibleApprovals">
                                <i :class="toggleIcon(visibleApprovals)"> </i> Click here to open or close the
                                approval section
                            </b-button>
                            <b-collapse id="collapse-approval" v-model="visibleApprovals">
                                <div class="flex-column flex-grow-1 border rounded bg-white">
                                    <div class="flex-column px-1 pb-1">

                                        <div class="flex-column p-0 my-2 py-1 div-border" v-for="(img, key) of collaborationImages.needApprovalImages">
                                            <div>
                                                <div class="flex-column flex-grow-1 text-center d-flex margin-bottom-zero">
                                                    <label class="font-weight-bold">Unviewed by customer</label>
                                                    <label class="text-info">Email {{img.sent_mail == 0 ? 'not sent':'sent'}}  to collaborator(s)</label>
                                                    <label class="text-info">Moved by {{img.moved_by }}</label>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex-column mx-2">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <img class="h-100 w-100 mx-1 border p-1 rounded my-1 custom-image"  :src="`/${img.path}`"/>
                                                        </div>
                                                        <div class="flex-column mt-1 col-md-4 line-height">
                                                            <label class="font-weight-bold custom-label customMarginUploadedFirst">{{ img.name.length > 20 ? img.name.substring(0,20) + '...' : img.name }}</label>
                                                            <label class="text-info custom-label customMarginUploaded">{{ img.size }}</label>
                                                            <label class="text-info custom-label customMarginUploaded">{{ img.custom_created_at }}</label>
                                                            <label class="custom-label customMarginUploaded">{{img.uploaded_by}}</label>
                                                            <div>
                                                                <button type="button" class="btn btn-sm my-1 bg-white"
                                                                        @click="printImage(img.path); return false;"><i
                                                                    class="fa fa-print fa-lg"> </i></button>
                                                                <button type="button" class="btn btn-sm my-1 bg-white ml-n2"
                                                                        @click="downloadImage(img.path)"><i
                                                                    class="fa fa-arrow-circle-down fa-lg"> </i></button>
                                                            </div>
                                                        </div>
                                                        <div class="flex-column col-md-4">
                                                            <div v-if="img.status == 'need approval'" class="flex-column">
                                                                <button type="button" class="btn-info w-100 my-1 custom-infobtn-toolbar custom-infobtn-text" @click="moveFile({moveTo:'approved', img:img})">Accept as Customer</button>
                                                                <button type="button" class="btn-info w-100 my-1 custom-infobtn-toolbar custom-infobtn-text" @click="">Reject as Customer</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="flex-column flex-wrap">
                                                        <div v-if="!hideInModal" class="flex-column" >
                                                            <label class="font-weight-bold">Rendering notes for customer:</label>
                                                            <label v-if="img.notes" class="custom-label customMarginUploaded">{{img.notes}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex-column p-0 my-2 py-1 div-border" v-for="(img, key) of collaborationImages.approvedImages">
                                            <div>
                                                <div class="flex-column flex-grow-1 text-center d-flex margin-bottom-zero">
                                                    <label class="font-weight-bold text-primary">Approved by {{ img.user? img.user.name: username }}</label>
                                                    <label class="text-info">Admin note:</label>
                                                    <label class="text-info">{{ img.custom_approved_at }}</label>
                                                    <label>Acknowledged by {{img.user? img.user.name: username }}  @ {{ img.custom_approved_at }}</label>
                                                    <label class="font-weight-bold" v-if="img.user.role.title == 'Customer' ">Accepted by Customer</label>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex-column mx-2">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <img class="h-100 w-100 mx-1 border p-1 rounded my-1 custom-image"  :src="`/${img.path}`"/>
                                                        </div>
                                                        <div class="flex-column mt-1 col-md-4 line-height">
                                                            <label class="font-weight-bold custom-label customMarginUploadedFirst">{{ img.name.length > 20 ? img.name.substring(0,20) + '...' : img.name }}</label>
                                                            <label class="text-info custom-label customMarginUploaded">{{ img.size }}</label>
                                                            <label class="text-info custom-label customMarginUploaded">{{ img.custom_created_at }}</label>
                                                            <label class="custom-label customMarginUploaded">{{img.uploaded_by}}</label>
                                                            <div>
                                                                <button type="button" class="btn btn-sm my-1 bg-white" @click="printImage(img.path); return false;"><i class="fa fa-print fa-lg"> </i></button>
                                                                <button type="button" class="btn btn-sm my-1 bg-white ml-n2" @click="downloadImage(img.path)"><i class="fa fa-arrow-circle-down fa-lg"> </i></button>
                                                            </div>
                                                        </div>
                                                        <div class="flex-column my-auto col-md-4">
                                                            <button v-if="img.user.role.title != 'Customer' " type="button" class="btn-info w-100 my-1 custom-infobtn-toolbar custom-infobtn-text" @click="moveFile({moveTo:'need approval', img:img})">Reject as Customer</button>
                                                        </div>
                                                    </div>
                                                    <div class="flex-column">
                                                        <div class="flex-column flex-wrap" v-if="!hideInModal">
                                                            <label class="font-weight-bold">Rendering notes for customer:</label>
                                                            <label v-if="img.notes" class="custom-label customMarginUploaded">{{img.notes}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </b-collapse>
                        </div>
            </div>
        </b-form>

    </div>
</template>

<script>
    import Button from '../customer-dashboard/Button';
    import Toolbar from '../customer-dashboard/Toolbar';
    import {fetchRecord, saveRecord} from "../../helpers/axios";

    export default {
        name: "Approval",
        props: {
            id : {
                type: Number
            },
            hideInModel:{
                type: Boolean,
                default: true,
            }
        },
        data (){
            return{
                formFields: {
                  id: 0,
                  images: [],
                },
                visibleApprovals: false,
                axiosParams: {module: 'customerApproval'},
                axiosApprovalParams: {module: 'customerApproval/approval'},
                hideInModal: false,
            }
        },
        beforeCreate(){
            if (!this.$store.getters.isPermitted({resource: 'Customer Portal', action: 'read'}))
                 this.$router.push('/access-denied');
        },
        computed:{
            customerName: function(){
              return this.$store.getters.getUserName;
            },
            collaborationImages() {
                let list = {uploadedImages: [], needApprovalImages: [], approvedImages: [], customerImages: []}

                for (let img of this.formFields.images) {
                    if (img.approved_at){
                        let customDate = new Date(img.approved_at);
                        img.custom_approved_at = customDate.toLocaleString('en-US',{
                            day: 'numeric',
                            year: 'numeric',
                            month: 'short',
                            hour: 'numeric',
                            minute: 'numeric',
                            second: 'numeric',
                        })
                    }
                    if (img.created_at){
                        let customDate = new Date(img.created_at);
                        img.custom_created_at = customDate.toLocaleString('en-US',{
                            day: 'numeric',
                            year: 'numeric',
                            month: 'short',
                            hour: 'numeric',
                            minute: 'numeric',
                            second: 'numeric',
                        })
                    }
                    if (img.status == 'uploads')
                        list.uploadedImages.push(img)
                    else if (img.status == 'need approval')
                        list.needApprovalImages.push(img)
                    else if (img.status == 'approved')
                        list.approvedImages.push(img)
                    else if (img.status == 'customers')
                        list.customerImages.push(img)
                }
                return list
            },
        },
        components:{
            Toolbar,
            Button,
        },
        mounted(){
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            this.getApproval(this.formFields.id);
        },
        methods:{
            getApproval: function(id){
                if (id) {
                    let record = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == id);
                    if (record != undefined) {
                        this.formFields = {...record};
                    } else {
                        this.axiosApprovalParams.id = id;
                        fetchRecord(this.axiosApprovalParams, (response) => {
                            console.log(response.data);
                            this.formFields = response.data;
                        })
                    }
                }
            },
            saveImage: function(data,isInfo){
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                console.log("this will be done later because we need create permisiion in customer portal in this approval module and we have only read permission");
                /*saveRecord({module: 'collaboration/updateImage'}, formData, (response) => {
                    console.log(response.data);
                    if (response.data.errorInfo) {
                        let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: message, variant: 'danger'});
                    } else {
                        let message = 'Image Updated';
                        this.makeToast({title: 'Success', message: message, variant: 'success'});
                        if(!isInfo){
                            data = response.data;
                            let index = this.formFields.images.findIndex(obj => obj.id == data.id);
                            console.log(index);
                            this.formFields.images.splice(index, 1);
                            this.formFields.images.unshift(data);
                        }
                    }
                })*/
            },
            toggleIcon: function (val) {
                return val ? 'fa fa-angle-down' : 'fa fa-angle-right'
            },
            imageToPrint: function (source) {
                return "<html><head><scri" + "pt>function step1(){\n" +
                    "setTimeout('step2()', 10);}\n" +
                    "function step2(){window.print();window.close();}\n" +
                    "</scri" + "pt></head><body onload='step1()'> <img src='" + source + "' style='width: 100vw;'>\n" +
                    "</body></html>";
            },
            printImage: function (source) {
                let Pagelink = "about:blank";
                let pwa = window.open(Pagelink, "_new");
                pwa.document.open();
                pwa.document.write(this.imageToPrint(window.location.origin + "/" + source));
                pwa.document.close();
            },
            downloadImage: function (src) {
                src = '/'+src;
                let a = document.createElement('a');
                a.href = src;
                let mapObj = {
                    images: "",
                    collaboration: "",
                    _: ""
                }
                src = src.replace(/images|_|collaboration/gi, function (matched) {
                    return mapObj[matched];
                });
                a.download = src;
                document.body.appendChild(a);
                console.log(a);
                a.click();
                document.body.removeChild(a);
            },
            moveFile: function (arg) {

                this.formFields.images.filter(obj => obj == arg.img)[0].status = arg.moveTo

                if(arg.moveTo == 'need approval'){
                    let userInfo = this.$store.state['auth'].user ? this.$store.state['auth'].user: null;
                    arg.img.moved_by = userInfo.name;
                    this.addTask('collaboration',arg);
                }

                if(arg.moveTo == 'approved'){
                    arg.img.user_id = this.$store.state['auth'].user.id ? this.$store.state['auth'].user.id: null;
                    arg.img.user = this.$store.state['auth'].user ? this.$store.state['auth'].user: null;
                    const date = new Date();
                    const [month, day, year]= [date.getMonth(), date.getDate(), date.getFullYear()];
                    const [hour, minutes, seconds] = [date.getHours(), date.getMinutes(), date.getSeconds()];
                    arg.img.approved_at = `${year}-${month}-${day} ${hour}:${minutes}:${seconds}` // Format : 2021-09-02 05:20:11
                }

                if(arg.moveTo == 'customers') {
                    this.customer_message ='File has been moved to customer view section';
                    this.customer_image = arg.img.path;
                    this.customer_image_name = arg.img.name;
                    this.sendCustomerViewMail();
                }

                this.saveImage(arg.img,false);

            },
        },
    }
</script>

<style scoped>
    .btn:focus, .btn:active {
        outline: none !important;
        box-shadow: none;
    }
    .margin-bottom-zero label{
        margin-bottom: 0rem;
    }
    .div-border {
        border: 1px solid #686868 !important;
    }
    .customMarginUploaded{
        margin: 1px 0.5rem !important;
    }
    .customMarginUploadedFirst{
        margin: 0.9rem 0.5rem 0 0.5rem !important;
    }
    .line-height {
        line-height: 1;
    }
</style>
