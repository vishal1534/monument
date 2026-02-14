<template>
    <div>
        <b-modal :header-bg-variant="headerBgVariant" hide-footer id="multiple-file-upload-collab"
                 modal-class="headWidth-">
            <template #modal-header="{ close }">
                <h5 class="m-auto">Upload</h5>
                <b-button @click="close()" class="bg-danger text-light" size="sm" variant="">
                    <span aria-hidden="true">×</span>
                </b-button>
            </template>

            <div class="form-group mt-4">
                <b-form-file
                    browse-text="Choose File"
                    class="col-md-11 border h6 rounded custom-file-upload"
                    drop-placeholder="Drop file here..."
                    multiple
                    placeholder="No Chosen File"
                    plain
                    ref="inputFile"
                    v-model="documents.files"
                    v-on:change="previewImage"
                ></b-form-file>
                <small class="custom-font-size text-danger">Docxs *, excel *, ai *, svg *, fs *, eps *, PDFs *, jpg * and png * formats are allowed</small>
            </div>

            <div class="form-group">
                <button @click="uploadFiles" class="btn-info mx-1 custom-infobtn-toolbar custom-infobtn-text" type="button">
                    Upload
                </button>
            </div>

        </b-modal>
    </div>
</template>

<script>
    import {event, eventBus} from "../../event-bus/event-bus";
    import {saveRecord} from "../../helpers/axios";

    export default {
        name: "MultipleFileUpload",
        props: {
            orderID: {
                type: Number,
                default: null
            }
        },
        data() {
            return {
                documentFile: {image: null, files: []},
                headerBgVariant: 'toolbar',
                validFileTypes: ['jpeg', 'JPEG', 'jpg', 'JPG', 'png', 'PNG', 'eps', 'EPS', 'svg', 'SVG', 'pdf', 'PDF', 'docx', 'DOCX', 'xlsx', 'ai', 'lwp'],
            }
        },
        computed: {
            documents() {

                if (this.documentFile == undefined || Object.keys(this.documentFile).length == 0) {
                    this.documentFile = {image: null, files: []};
                }
                return this.documentFile;
            },
        },
        methods: {
            uploadFiles: function () {
                let data = {'order_id': this.orderID};
                let formData = new FormData();
                this.$bvModal.hide('multiple-file-upload-collab');
                if (this.documentFile.files?.length) {
                    for (let file of this.documentFile.files) {
                        formData.append('doc_files[]', file);
                    }
                }
                formData.append('data', JSON.stringify(data));
                saveRecord({module: 'order/uploadOrderImage'}, formData, (response) => {
                    console.log(response.data);
                    if (response.data.errorInfo) {
                        let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                        eventBus.$emit(event.MULTIPLE_FILE_UPLOAD_MSG, {title: 'Error', message: message, variant: 'danger', duration: 3000})
                    } else {

                        let message = 'Files Uploaded Successfully';
                        eventBus.$emit(event.MULTIPLE_FILE_UPLOAD_MSG, {title: 'Success', message: message, variant: 'success', duration: 3000})
                    }
                })
                this.documentFile = {image: null, files: []};
            },
            previewImage: function (e) {
                let input = e.target;
                let invalidFileType = false;
                if (input.files.length > 0) {
                    for (let file of input.files) {
                        let fileType = file.name.split('.');
                        let FileSize = file.size / 1024 / 1024;
                        if (FileSize > 20 ||
                            (this.validFileTypes.indexOf(fileType[fileType.length - 1]) == -1 &&
                                ['fs', 'FS'].indexOf(file.name.substr(file.name.lastIndexOf('.') + 1)) == -1)) {
                            invalidFileType = true;
                            break;
                        }
                    }
                }
                if (invalidFileType) {
                    eventBus.$emit(event.MULTIPLE_FILE_UPLOAD_MSG, {title: 'Error', message: 'Invalid File type or File size exceeds 20 MB', variant: 'danger', duration: 3000})
                    this.$refs['inputFile'].reset();
                    return false;
                }
            },
        },
    }
</script>

<style>
    div.modal.headWidth- {
        width: 99% !important;
    }

    .custom-font-size {
        font-size: 0.8em;
    }

    .custom-file-upload {
        margin-bottom: auto;
    }
</style>
