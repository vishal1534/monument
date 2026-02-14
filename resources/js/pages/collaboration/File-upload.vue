<template>

    <div class="col-md-12 d-flex main">

        <div class="custom-row flex-column m-auto" id="file-upload-modal">
            <b-form-group id="fileInput" class="dragdrop m-0">
                <b-form-file
                        ref="inputFile"
                        v-on:change="previewImage"
                        v-model="file"
                        accept="image/*"
                        placeholder="Drag&Drop or select file ..."
                ></b-form-file>
            </b-form-group>
            <label class="file-size mx-auto">Max file size : 2MB</label>

            <button type="button" class="btn btn-primary" @click="uploadImage()" :disabled="!formFields.upload_image">
                Upload
            </button>
        </div>

    </div>

</template>

<script>

    import {saveRecord, fetchRecord, fetchRecords, sendMail, EncodeDecodeData} from "../../helpers/axios";

    export default {
        name: "File-upload",
        props: {
            id: {
                type: String
            },
        },
        computed: {
            file: {
                get: function () {
                    return this.formFields.upload_image
                },
                set: function (file) {
                    if (file && file.size / 1000000 > 2) {
                        alert("File must be less than 2MB")
                        this.$set(this.formFields, 'upload_image', null)
                    } else
                        this.$set(this.formFields, 'upload_image', file)
                }
            }
        },
        data() {
            return {
                formFields: {
                    id: 0,
                },
                axiosParams: {module: 'collaboration'},
                saveDisabled: false,
                toastHider: false,
            }
        },
        metaInfo() {
            return {
                title: `File Upload`,
            }
        },
        mounted() {
            let data = {str: this.$props.id, type:'decrypt'};
            let formData = new FormData();
            formData.append('data', JSON.stringify(data));
            EncodeDecodeData(formData, (res) => {
                console.log(res)
                this.formFields.id = res.data;
                this.getCollaboration(this.formFields.id);
            })

        },
        methods: {
            /** CRUD */
            getCollaboration: function (id) {

                if (id) {
                    let record = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == id);
                    if (record != undefined) {
                        this.formFields = {...record};
                    } else {
                        this.axiosParams.id = id;
                        fetchRecord(this.axiosParams, (response) => {
                            this.formFields = response.data;
                        })
                    }
                }
            },
            storeCollaboration: function () {
                this.saveDisabled = true; //Disabling save button
                let data = this.formFields;
                let formData = new FormData();
                formData.append('data', JSON.stringify(data));
                formData.append('image_file', this.formFields.upload_image);

                saveRecord(this.axiosParams, formData, (response) => {
                    if (response.data.errorInfo) {
                        let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: message, variant: 'danger'});
                    } else {
                        let message = `Record Successfully ${this.formFields.id ? 'Updated' : 'Added'}`;
                        this.makeToast({title: 'Success', message: message, variant: 'success'});

                        this.formFields = response.data;
                        this.axiosParams.data = response.data;
                        this.$store.commit('appendOrUpdateInRecordList', this.axiosParams);
                        // Update Order record in store (in case of changing order_status, paper_location,on_hold_order,on_hold_order_description)
                        this.$store.commit('appendOrUpdateInRecordList', {
                            module: 'order',
                            data: this.formFields.order
                        });
                    }
                })
            },
            getRecords: function () {
                if (this.$store.state[this.axiosParams.module].recordList.length == 0) {
                    this.$store.dispatch('getModuleInfo', this.axiosParams);
                }

                fetchRecords({module: 'collaboration/collaboratorTypes'}, (response) => {
                    this.collaboratorTypes = response.data
                })
            },
            uploadImage: function () {

                this.toastHider = true
                this.makeToast({title: 'Uploading', message: "Uploading images...", variant: 'success'});

                let data = {collaboration: this.formFields.id, uploaded_from: 'uploads'}
                let formData = new FormData();
                formData.append('image_file', this.formFields.upload_image);
                formData.append('data', JSON.stringify(data));
                this.formFields.upload_image = null

                saveRecord({module: 'collaboration/uploadImage'}, formData, (response) => {
                    if (response.data.errorInfo) {
                        this.toastHider = false
                        this.$bvToast.hide('collaboration-toast')
                        let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        this.makeToast({title: 'Error', message: message, variant: 'danger'});
                    } else {
                        this.toastHider = false
                        this.$bvToast.hide('collaboration-toast')
                        let message = 'Image Uploaded';
                        this.makeToast({title: 'Success', message: message, variant: 'success'});

                        this.formFields.images.push(response.data);
                    }
                })
            },
            previewImage: function(event) {
                let input = event.target;
                let  FileSize = input.files[0].size / 1024 / 1024; // in MiB
                if (FileSize > 2 ||input.files[0].type.indexOf("image") == -1) {
                    // alert('Invalid image type or file size exceeds 2 MB');
                    this.makeToast({title : 'Error', message: 'Invalid image type or file size exceeds 2 MB', variant : 'danger', duration : 5000});
                    this.$refs['inputFile'].reset();
                    return false;
                }
            },

            /**
             * Related modules
             * */
            sendMail: function () {

                if (this.sendToList.length == 0) {
                    this.makeToast({title: 'Warning', message: "Please select a user", variant: 'warning'});
                    return;
                }

                this.toastHider = true
                this.makeToast({title: 'Sending', message: "Sending mail...", variant: 'success'});


                let sendTo = this.sendToList;
                let message = this.mailText;
                let data = {};
                data.sendTo = sendTo;
                data.message = message
                data.link = this.uploadLink
                data.order = this.order.id;

                let formData = new FormData();
                formData.append('data', JSON.stringify(data));

                sendMail(this.axiosParams, formData, (response) => {
                    this.toastHider = false
                    this.$bvToast.hide('collaboration-toast')
                    if (response.data == 'sent')
                        this.makeToast({title: 'Mail Sent', message: "Mail sent successfully", variant: 'success'});
                    else
                        this.makeToast({title: 'Error', message: response.data, variant: 'danger', duration: 5000});

                    console.log(response.data)
                })
            },

            /** Generic*/
            makeToast: function(params) {
                this.$bvToast.toast(params.message, {
                    id:'collaboration-toast',
                    title: params.title,
                    variant: params.variant,
                    toaster: 'b-toaster-top-center',
                    autoHideDelay: params.duration ? params.duration : 2000,
                    noAutoHide: this.toastHider,
                    noCloseButton: true,
                })
                this.saveDisabled = false;//enabling save button

            },
        },
    }
</script>

<style scoped>
    .main {
        height: 85vh;
    }

    .custom-row {
        display: flex;
        margin: 0.5rem 0;
        padding-left: 1rem;
    }

    .custom-row div {
        display: flex;
    }

    .custom-row div label {
        margin: auto 0.5rem;
        white-space: nowrap !important;
    }

</style>
