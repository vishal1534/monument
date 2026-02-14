<template>

    <b-modal id="file-upload-modal"
             centered
             button-size="sm"
             title="Upload File">

        <template #modal-footer="{ ok, cancel }">

            <b-button size="sm" variant="primary" @click="uploadImage()" :disabled="!formFields.upload_image">Upload</b-button>
            <b-button size="sm" variant="secondary" @click="cancel(); formFields.upload_image=null">Cancel</b-button>

        </template>

        <b-form-group id="fileInput" class="dragdrop m-0">
            <b-form-file
                    v-on:change="previewImage"
                    ref="inputFile"
                    v-model="file"
                    :accept="accept"
                    placeholder="Drag&Drop or select file ..."
            ></b-form-file>
        </b-form-group>

        <label class="file-size">Max file size : 20MB</label>
    </b-modal>
</template>

<script>
    import {event, eventBus} from "../event-bus/event-bus";

    export default {
        name: "fileUploadModal",
        props:{
            formFields: {
                type: Object
            },
            accept:{
                type: String
            },
        },
        computed:{
          file:{
              get: function(){
                  return this.formFields.upload_image
              },
              set: function(file){
                  if (file && file.size/1000000 > 20) {
                      alert("File must be less than 20MB")
                      this.$set(this.formFields, 'upload_image', null)
                  }
                  else
                      this.$set(this.formFields, 'upload_image', file)
              }
          }
        },
        methods:{
            uploadImage(){
                this.$bvModal.hide('file-upload-modal')
                eventBus.$emit(event.UPLOAD_COLLABORATION_IMAGE)
            },
            previewImage: function(event) {
                let input = event.target;
                let  FileSize = input.files[0].size / 1024 / 1024; // in MiB
                if (FileSize > 20 || (input.files[0].type != "application/vnd.ms-excel"
                    && input.files[0].type != "text/plain" && input.files[0].type != "application/pdf"
                    && input.files[0].type != "application/doc" && input.files[0].type.indexOf("image") == -1
                    && input.files[0].type != "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                    && input.files[0].type != "application/postscript" && input.files[0].type != "image/svg+xml"
                    && input.files[0].name.substr(input.files[0].name.lastIndexOf('.')+1) != 'fs'
                    && input.files[0].name.substr(input.files[0].name.lastIndexOf('.')+1) != 'FS'
                    && input.files[0].type != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"))
                {
                    this.makeToast({title : 'Error', message: 'Invalid image type or file size exceeds 20 MB', variant : 'danger', duration : 5000});

                    this.$refs['inputFile'].reset();
                    return false;
                }
            },
            makeToast: function(params) {
                this.$bvToast.toast(params.message, {
                    id:'fileUpload-model',
                    title: params.title,
                    variant: params.variant,
                    toaster: 'b-toaster-top-center',
                    autoHideDelay: params.duration ? params.duration : 2000,
                    noAutoHide: this.toastHider,
                    noCloseButton: true,
                })
                this.saveDisabled = false;

            },
        }
    }
</script>

<style scoped>
.file-size{
    font-size: 10px;
}
</style>
