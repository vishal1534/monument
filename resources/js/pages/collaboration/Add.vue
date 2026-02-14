    <template>
        <div :class="hideInModal?' custom-modal-margin':'bg-order'">
            <div v-if="!hideInModal">
                <h5 class="mx-2 my-1 custom-view-heading"> {{ formFields.id ? 'Edit' : 'Add'}} Collaboration</h5>
                <div class="bg-toolbar my-2 p-1">
                    <Toolbar :id="formFields.id" :saveDisabled="saveDisabled"></Toolbar>
                </div>
            </div>
            <div class="col-md-12 custom-margin pr-1 my-2">
                <form>
                    <template v-if="isLoading">
                        <div class="text-center text-info my-2">
                            <b-spinner class="align-middle"></b-spinner>
                            <strong>Loading...</strong>
                        </div>
                    </template>
                    <template v-else>
                        <div class="custom-row">
                            <div>
                                <label>Order Status</label>
                                <b-form-select
                                    :disabled="hideInModal"
                                    :options="orderStatusList"
                                    class="form-control form-control-sm custom-caret-form b-select-width"
                                    name="collaboration[order_status_id]"
                                    size="sm"
                                    v-model="order.order_status_id"
                                    v-on:change="checkOrderStatus(order.order_status_id)">
                                    <template #first>
                                        <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                                    </template>
                                </b-form-select>
                            </div>
                            <div>
                                <label>Paper Location</label>
                                <b-form-select
                                    :disabled="hideInModal"
                                    :options="paperLocationList"
                                    class="form-control form-control-sm custom-caret-form paper-select-width"
                                    name="collaboration[order_status_id]"
                                    size="sm"
                                    v-model="order.paper_location_id"
                                    v-on:change="paperLocationLabel(order.paper_location_id)">
                                    <template #first>
                                        <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                                    </template>
                                </b-form-select>
                            </div>
                            <div>
                                <label>Order On Hold</label>
                                <b-form-input :disabled="hideInModal" class="input-md bg-order" name="order_on_hold" size="sm"
                                              type="text" v-model="order.on_hold"></b-form-input>
                            </div>
                            <div>
                                <label>Order On Hold Description</label>
                                <b-form-input :disabled="hideInModal" class="input-xxl bg-order" name="order_on_hold_description" size="sm"
                                              type="text" v-model="order.on_hold_description"></b-form-input>
                            </div>
                        </div>
                        <div class="custom-row">
                            <div class="col-6 px-0 flex-column">
                                 <div class="flex-column div-shadow bg-white rounded mr-3" v-if="!isClient">
                                    <div class="flex-column p-0">
                                        <div class="bg-toolbar mt-4 px-3">
                                            <b-form-group class="mb-0 custom-radio-and-checkbox text-nowrap overflow-auto">
                                                <b-form-radio-group :options="collaboratorTypeNavList" v-model="selectedCollaboratorAdd">
                                                </b-form-radio-group>
                                            </b-form-group>
                                        </div>
                                        <div class="flex-column" height="1850px">
                                            <div class="flex-column mt-2 mx-2">
                                                <b-button
                                                    :aria-expanded="visibleAddCollaborator ? 'true' : 'false'"
                                                    :class="visibleAddCollaborator ? 'btn-sm bg-white text-dark py-0 text-left border' : 'btn-sm py-0 bg-white text-dark text-left border collapsed'"
                                                    :disabled="hideInModal"
                                                    @click="visibleAddCollaborator = !visibleAddCollaborator"
                                                    aria-controls="collapse-collaborator">
                                                    <i :class="toggleIcon(visibleAddCollaborator)"> </i> Click to Add
                                                    Collaborators
                                                </b-button>
                                                <b-collapse class="border" id="collapse-collaborator"
                                                            v-model="visibleAddCollaborator">
                                                    <div class="flex-column flex-grow-1">
                                                        <div class="d-block">
                                                            <template v-for="(item, index) of collaboratorList.add">
                                                                <div class="d-flex" :key="item.id">
                                                                    <b-form-checkbox class="mx-2" v-model="item.is_box_checked" :value="1"><b :title="`${item.type.title}`" v-b-tooltip.hover v-if="item.type">
                                                                        {{item.type.title.charAt(0)}}</b> - {{item.first_name}} {{item.last_name ? `${item.last_name}` : "" }}
                                                                        {{item.email ? `| ${item.email}` : "" }}
                                                                    </b-form-checkbox>
                                                                    <button v-if="!item.is_custom" @click="collaborator = {...item}, visibleNewCollaborator = true"
                                                                            aria-controls="collapse-new-collaborator"
                                                                            aria-expanded="true"
                                                                            class="btn btn-sm p-0 font-italic edit-btn ml-n1 mt-0"
                                                                            type="button">(edit)
                                                                    </button>
                                                                </div>
                                                            </template>
                                                        </div>
                                                        <div class="bg-toolbar">
                                                            <b-button
                                                                :aria-expanded="visibleNewCollaborator ? 'true' : 'false'"
                                                                :class="visibleNewCollaborator ? 'btn-sm list-toolbar py-0 border-0 text-left flex-grow-1' : 'btn-sm list-toolbar py-0 border-0 text-left flex-grow-1 collapsed'"
                                                                @click="visibleNewCollaborator = !visibleNewCollaborator, collaborator = {id:0, type_id:collaboratorTypeList[0].value}"
                                                                aria-controls="collapse-new-collaborator">
                                                                <i :class="toggleIcon(visibleNewCollaborator)"> </i>
                                                                Click to add New Collaborator
                                                            </b-button>
                                                        </div>
                                                        <b-collapse class="mt-2 mx-n4" id="collapse-new-collaborator" v-model="visibleNewCollaborator">
                                                            <div class="custom-row d-block  col-12 px-2">
                                                                <div class="d-flex my-2 col-12">
                                                                    <div class="col-6">
                                                                        <label class="col-3 p-0">First Name</label>
                                                                        <b-form-input type="text"
                                                                                      v-model="collaborator.first_name"></b-form-input>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="col-3 p-0">Last Name</label>
                                                                        <b-form-input type="text"
                                                                                      v-model="collaborator.last_name"></b-form-input>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex my-2 col-12">
                                                                    <div class="col-12">
                                                                        <label class="col-1 p-0">Email</label>
                                                                        <b-form-input class="" style="margin-left: 1.25rem !important" type="text" v-model="collaborator.email"></b-form-input>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex my-2 col-12">
                                                                    <div class="col-6">
                                                                        <label class="col-3 p-0">Phone</label>
                                                                        <b-form-input class="margin-left-neg" type="text"
                                                                                      v-model="collaborator.phone"></b-form-input>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="col-3">Type</label>
                                                                        <b-dropdown :disabled="hideInModal"
                                                                                    class="border rounded flex-grow-1 input-lg dropdown-width"
                                                                                    no-caret size="sm"
                                                                                    variant="none">
                                                                            <template #button-content>
                                                                                <div class="d-flex">
                                                                                    <small>{{ collaborator.type_id ?
                                                                                        collaboratorTypeList.filter(obj =>
                                                                                        obj.value == collaborator.type_id)[0].text : 'Select'
                                                                                        }}
                                                                                    </small>
                                                                                    <i aria-hidden="true"
                                                                                       class="fa fa-caret-down ml-auto"></i>
                                                                                </div>
                                                                            </template>
                                                                            <b-dropdown-group class="overflow-auto px-1">
                                                                                <template v-for="obj of collaboratorTypeList">
                                                                                    <b-dropdown-group>
                                                                                        <b-dropdown-item-button @click="collaborator.type_id = obj.value"
                                                                                                                class="small">
                                                                                            {{ obj.text }}
                                                                                        </b-dropdown-item-button>
                                                                                    </b-dropdown-group>
                                                                                </template>
                                                                            </b-dropdown-group>
                                                                        </b-dropdown>
                                                                    </div>
                                                                </div>
                                                                <div class="my-2 justify-content-center">
                                                                    <div>
                                                                        <button @click="saveCollaborator"
                                                                                class="btn-info mx-1 custom-infobtn-toolbar custom-infobtn-text"
                                                                                type="button">Save
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </b-collapse>
                                                    </div>
                                                </b-collapse>
                                            </div>
                                            <div :class="visibleAddCollaborator ? 'showEmailSection' : 'hideEmailSection'" class="justify-content-center height-200">
                                                <h2 class="mt-5">E-mails</h2>
                                            </div>
                                            <div :class="visibleAddCollaborator ? 'hideEmailSection' : 'showEmailSection'" class="flex-column mt-2 mx-2">
                                                <b-table :fields="collaboratorEmailFields" :items="formFields.collaborator_mail" bordered
                                                         class="small"
                                                         responsive
                                                         small>
                                                    <template #cell(date)="row">
                                                        <template>
                                                            <label class="d-flex collaborator-mail-sent-table">{{ changeDateFormat(row.item.date) }}</label>
                                                        </template>
                                                    </template>
                                                    <template v-slot:cell(sent_by)="row">
                                                        <label class="d-flex collaborator-mail-sent-table">{{row.item.sent_by}}</label>
                                                    </template>
                                                    <template v-slot:cell(send_to)="row">
                                                        <label class="d-flex collaborator-mail-sent-table">{{row.item.send_to}}</label>
                                                    </template>
                                                    <template v-slot:cell(content)="row">
                                                        <label class="d-flex collaborator-mail-sent-table mail-content-white-space">{{row.item.content}}</label>
                                                    </template>
                                                    <template v-slot:cell(attachment)="row">
                                                        <label class="d-flex collaborator-mail-sent-table"> {{ row.item.attachment == 1 ? 'Yes' : 'No' }}</label>
                                                    </template>
                                                </b-table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-3 mr-3" v-if="!isClient && !hideInModal">
                                    <div class="col-2 p-0">
                                        <label class="">Email</label>
                                    </div>
                                    <div class="flex-column flex-grow-1">
                                        <b-button
                                            :aria-expanded="visibleEmail ? 'true' : 'false'"
                                            :class="visibleEmail ? 'btn btn-sm bg-white text-dark text-left border' : 'btn btn-sm  bg-white text-dark text-left border collapsed'"
                                            @click="visibleEmail = !visibleEmail"
                                            aria-controls="collapse-email">
                                            <i :class="toggleIcon(visibleEmail)"> </i> Click here to Email to Collaborators
                                        </b-button>
                                        <b-collapse class="flex-column border rounded bg-white" id="collapse-email"
                                                    v-model="visibleEmail">
                                            <div class="flex-column">
                                                <div class="bg-toolbar">
                                                    <b-form-group class="mb-0 custom-radio-and-checkbox text-nowrap overflow-auto" style="width: 601px;">
                                                        <b-form-radio-group :options="collaboratorTypeNavList" v-model="selectedCollaboratorEmail">
                                                        </b-form-radio-group>
                                                    </b-form-group>
                                                </div>
                                                <div class="my-2 flex-wrap">
                                                    <template v-for="item of collaboratorList.email">
                                                        <b-form-checkbox :value=item class="mx-2" v-model="sendToList">
                                                            {{item.first_name}}
                                                        </b-form-checkbox>
                                                    </template>
                                                </div>
                                                <div class="d-flex my-2">
                                                    <b-form-textarea
                                                        class="mx-2"
                                                        no-resize
                                                        placeholder="Type in your message and inform what image customer have to upload"
                                                        rows="3"
                                                        size="sm"
                                                        v-model="mailText"
                                                    ></b-form-textarea>
                                                </div>
                                                <div class="d-flex my-2">
                                                    <b-form-checkbox class="mx-2" v-model="uploadLink">Include Upload Link
                                                    </b-form-checkbox>
                                                    <button @click="sendMail()"
                                                            class="btn-info custom-infobtn-toolbar custom-infobtn-text w-auto mx-2 px-3"
                                                            type="button">
                                                        Send E-Mail / Upload
                                                    </button>
                                                </div>
                                            </div>
                                        </b-collapse>
                                    </div>
                                </div>
                                <div class="my-3 mr-3" v-if="!isClient">
                                    <div class="col-2 p-0">
                                        <label class="">Upload Files</label>
                                    </div>
                                    <div class="flex-column flex-grow-1">
                                        <b-button
                                            :aria-expanded="visibleUploadFiles ? 'true' : 'false'"
                                            :class="visibleUploadFiles ? 'btn btn-sm bg-white text-dark text-left border' : 'btn btn-sm  bg-white text-dark text-left border collapsed'"
                                            @click="visibleUploadFiles = !visibleUploadFiles"
                                            aria-controls="collapse-upload-file">
                                            <i :class="toggleIcon(visibleUploadFiles)"> </i> Click here to open or close the
                                            file upload
                                            section
                                        </b-button>
                                        <b-collapse class="flex-column border rounded bg-white" id="collapse-upload-file"
                                                    v-model="visibleUploadFiles">
                                            <div class="flex-column">
                                                <div class="bg-toolbar p-1" v-if="!hideInModal">
                                                    <button :disabled="hideInModal" @click="formFields.uploadedFrom = 'uploads'"
                                                            class="btn btn-sm border-0 list-toolbar custom-edit-text"
                                                            type="button"
                                                            v-b-modal.file-upload-modal>Add Files
                                                    </button>
                                                </div>
                                                <div class="my-2 mx-4" v-for="(img,key) of collaborationImages.uploadedImages">
                                                    <template v-if="checkFileType(img.path)">
                                                        <div class="flex-column border mx-1 mb-2 py-1 custom-image justify-content-center file-container">
                                                            <i class="fa fa-file fa-2x m-auto" @click="openPreviewNewPage(img.path)" style="cursor: pointer;"></i>
                                                            <label :title="`${img.name}`" class="text-center" v-b-tooltip.hover  @click="openPreviewNewPage(img.path)" style="cursor: pointer;">
                                                                {{img.name.length > 10 ? img.name.substr(0,10)+'...' : img.name}}</label>
                                                        </div>
                                                    </template>
                                                    <template v-else>
                                                        <img :src="`/${img.path}`" @click="openPreviewNewPage(img.path)" style="cursor: pointer;"
                                                             class="border mx-1 p-1 rounded custom-image">
                                                    </template>
                                                    <div class="flex-column mt-1">
                                                        <label :title="`${img.name}`" class="font-weight-bold custom-label customMarginUploadedFirst" v-b-tooltip.hover>{{ img.name.length > 20 ? img.name.substring(0,13)+'...' + img.name.substring(img.name.length - 7) : img.name }}</label>
                                                        <label class="text-info custom-label customMarginUploaded">{{img.size}}</label>
                                                        <label class="text-info custom-label customMarginUploaded">{{img.custom_created_at}}</label>
                                                        <label class="font-weight-bold custom-label customMarginUploaded">{{img.uploaded_by}}</label>
                                                        <div>
                                                            <template v-if="!checkFileType(img.path)">
                                                                <button @click="printImage(img.path); return false;" class="btn btn-sm my-1 bg-white"
                                                                        type="button">
                                                                    <i class="fa fa-print fa-lg"> </i>
                                                                </button>
                                                            </template>
                                                            <button :class="checkFileType(img.path) ? '': 'ml-n2'" @click="downloadImage(img.path , img.name)" class="btn btn-sm my-1 bg-white"
                                                                    type="button">
                                                                <i class="fa fa-arrow-circle-down fa-lg"> </i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="flex-column ml-auto" v-if="!hideInModal">
                                                        <button @click="moveFile({moveTo:'need approval', img:img})"
                                                                class="btn-info w-100 my-1 custom-infobtn-toolbar custom-infobtn-text"
                                                                type="button">Move to
                                                            Approval
                                                        </button>
                                                        <button @click="moveFile({moveTo:'customers', img:img})"
                                                                class="btn-info w-100 my-1 custom-infobtn-toolbar custom-infobtn-text"
                                                                type="button">Move to
                                                            Customer
                                                        </button>
                                                        <button @click="deleteFile(img)"
                                                                class="btn-info w-100 my-1 custom-infobtn-toolbar custom-infobtn-text"
                                                                type="button">Remove File
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </b-collapse>
                                    </div>
                                </div>
                                <div class="my-3 mr-3" v-if="!isClient">
                                    <div class="col-2 p-0">
                                        <label>Approvals</label>
                                    </div>
                                    <div class="flex-column flex-grow-1">
                                        <b-button
                                            :aria-expanded="visibleApprovals ? 'true' : 'false'"
                                            :class="visibleApprovals ? 'btn btn-sm bg-white text-dark  text-left border' : 'btn btn-sm  bg-white text-dark text-left border collapsed'"
                                            @click="visibleApprovals = !visibleApprovals"
                                            aria-controls="collapse-approval">
                                            <i :class="toggleIcon(visibleApprovals)"> </i> Click here to open or close the
                                            approval section
                                        </b-button>
                                        <b-collapse id="collapse-approval" v-model="visibleApprovals">
                                            <div class="flex-column flex-grow-1 border rounded bg-white">
                                                <div class="bg-toolbar p-1" v-if="!hideInModal">
                                                    <button @click="formFields.uploadedFrom = 'need approval'"
                                                            class="btn btn-sm border-0 list-toolbar custom-edit-text"
                                                            type="button"
                                                            v-b-modal.file-upload-modal>Add Files
                                                    </button>
                                                    <button @click="sendApprovalMail" class="btn btn-sm border-0 list-toolbar custom-edit-text" type="button">{{checkMailSent ? 'Resend':'Send'}} Customer Email(s)
                                                    </button>
                                                    <button @click="printPDF" class="btn btn-sm border-0 list-toolbar custom-edit-text" type="button">Print Approval Confirmation
                                                    </button>
                                                </div>
                                                <div class="my-2">
                                                    <label>Send a reminder to this client every<input :disabled="hideInModal" :max=30 :min=1 class="mx-1" style="border: 1px solid #000 !important;
                                                font-size: 20px;width:3rem" type="number" v-model="formFields.mail_remainder_days" v-on:change="setValidDays(formFields.mail_remainder_days)"> days</label>
                                                </div>
                                                <div class="flex-column px-1 pb-1">
                                                    <div class="flex-column p-0 my-2 py-1 div-border" v-for="(img, key) of collaborationImages.needApprovalImages">
                                                        <div>
                                                            <div class="btn-close mx-1 justify-content-center" v-if="!hideInModal">
                                                                <button @click="deleteFile(img)" class="btn btn-sm text-white p-0" type="button">X</button>
                                                            </div>
                                                            <div class="flex-column flex-grow-1 text-center">
                                                                <label class="font-weight-bold">Unviewed by customer</label>
                                                                <label class="text-info">Email {{img.sent_mail == 0 ? 'not sent':'sent'}} to collaborator(s)</label>
                                                                <label class="text-info">Moved by {{img.moved_by }}</label>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="flex-column mx-2">
                                                                <div class="d-flex">
                                                                    <template v-if="checkFileType(img.path)">
                                                                        <div class="flex-column border mx-1 mb-2 py-1 custom-image justify-content-center file-container">
                                                                            <i class="fa fa-file fa-2x m-auto"  @click="openPreviewNewPage(img.path)" style="cursor: pointer;"></i>
                                                                            <label :title="`${img.name}`" class="text-center" v-b-tooltip.hover  @click="openPreviewNewPage(img.path)" style="cursor: pointer;">
                                                                                {{img.name.length > 10 ? img.name.substr(0,10)+'...' : img.name}}</label>
                                                                        </div>
                                                                    </template>
                                                                    <template v-else>
                                                                        <img :src="`/${img.path}`"  @click="openPreviewNewPage(img.path)" style="cursor: pointer;" class="mx-1 border p-1 rounded my-1 custom-image"/>
                                                                    </template>
                                                                    <div class="flex-column mt-1">
                                                                        <label :title="`${img.name}`" class="font-weight-bold custom-label customMarginUploadedFirst" v-b-tooltip.hover>{{ img.name.length > 20 ? img.name.substring(0,13) + '...' + img.name.substring(img.name.length - 7) : img.name }}</label>
                                                                        <label class="text-info custom-label customMarginUploaded">{{ img.size }}</label>
                                                                        <label class="text-info custom-label customMarginUploaded">{{ img.custom_created_at }}</label>
                                                                        <label class="custom-label customMarginUploaded">{{img.uploaded_by}}</label>
                                                                        <div>
                                                                            <template v-if="!checkFileType(img.path)">
                                                                                <button @click="printImage(img.path); return false;" class="btn btn-sm my-1 bg-white"
                                                                                        type="button"><i
                                                                                    class="fa fa-print fa-lg"> </i></button>
                                                                            </template>
                                                                            <button :class="checkFileType(img.path) ? '': 'ml-n2'" @click="downloadImage(img.path, img.name)" class="btn btn-sm my-1 bg-white"
                                                                                    type="button"><i
                                                                                class="fa fa-arrow-circle-down fa-lg"> </i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-column flex-wrap">
                                                                    <div class="flex-column" v-if="!hideInModal">
                                                                        <label class="font-weight-bold">Rendering notes for customer:</label>
                                                                        <button @click="$set(img, 'approval_needed', !img.approval_needed)" class="btn btn-sm p-0 font-italic  text-left ml-1 edit-btn-hover" type="button">(edit)</button>
                                                                        <textarea class="font-italic wrap-text ml-2" readonly rows="3" v-if="img.notes">{{ img.notes }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="flex-column ml-5 mx-3" v-if="!hideInModal">
                                                                <b-form-checkbox :checked="img.approval_needed ? img.approval_needed : 'notTure'" :id="'approval_needed_'+img.id" :value="img.approval_needed ? img.approval_needed : 'false'"
                                                                                 @change="$set(img, 'approval_needed', $event), isApprovalNeeded(img)" class="mx-2 custom-radio-and-checkbox "
                                                                                 plain>Approval Needed
                                                                </b-form-checkbox>
                                                                <div class="flex-column" v-if="img.approval_needed">
                                                                    <label class="mx-0 my-1">Notes:</label>
                                                                    <b-form-textarea class="mx-0" no-resize size="sm" v-model="img.notes"></b-form-textarea>
                                                                    <div class="justify-content-center" v-if="!hideInModal">
                                                                        <button @click="saveImage({id: img.id, notes: img.notes},true)" class="btn btn-sm p-0 save-hover-bold" type="button">Save</button>
                                                                        <button @click="$set(img, 'approval_needed', false)" class="btn btn-sm cancel-btn-hover-bold" type="button">Cancel</button>
                                                                    </div>
                                                                    <button @click="moveFile({moveTo:'approved', img:img})" class="btn-info w-100 my-1 custom-infobtn-toolbar custom-infobtn-text" type="button">Accept for Customer</button>
                                                                    <button @click="" class="btn-info w-100 my-1 custom-infobtn-toolbar custom-infobtn-text" type="button">Reject for Customer</button>
                                                                    <button @click="neededApprovalMail(img)" class="btn-info w-100 my-1 custom-infobtn-toolbar custom-infobtn-text" type="button">Send In Email</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex-column p-0 my-2 py-1 div-border" v-for="(img, key) of collaborationImages.approvedImages">
                                                        <div>
                                                            <div class="btn-close mx-1 justify-content-center" v-if="!hideInModal">
                                                                <button @click="deleteFile(img)" class="btn btn-sm text-white p-0" type="button">X</button>
                                                            </div>
                                                            <div class="flex-column flex-grow-1 text-center">
                                                                <label class="font-weight-bold text-primary">Approved by {{ img.user? img.user.name: username }}</label>
                                                                <label class="text-info">Admin note:</label>
                                                                <label class="text-info">{{ img.custom_approved_at }}</label>
                                                                <label>Acknowledged by {{img.user? img.user.name: username }} @ {{ img.custom_approved_at }}</label>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="flex-column mx-2">
                                                                <div class="d-flex">
                                                                    <template v-if="checkFileType(img.path)">
                                                                        <div class="flex-column border mx-1 mb-2 py-1 custom-image justify-content-center file-container">
                                                                            <i class="fa fa-file fa-2x m-auto" @click="openPreviewNewPage(img.path)" style="cursor: pointer;"></i>
                                                                            <label class="text-center" @click="openPreviewNewPage(img.path)" style="cursor: pointer;">
                                                                                {{img.name.length > 10 ? img.name.substr(0,10)+'...' : img.name}}</label>
                                                                        </div>
                                                                    </template>
                                                                    <template v-else>
                                                                        <img :src="`/${img.path}`" @click="openPreviewNewPage(img.path)" style="cursor: pointer;" class="mx-1 border p-1 rounded my-1 custom-image"/>
                                                                    </template>
                                                                    <div class="flex-column mt-1">
                                                                        <label class="font-weight-bold custom-label customMarginUploadedFirst">{{ img.name.length > 20 ? img.name.substring(0,20) + '...' : img.name }}</label>
                                                                        <label class="text-info custom-label customMarginUploaded">{{ img.size }}</label>
                                                                        <label class="text-info custom-label customMarginUploaded">{{ img.custom_created_at }}</label>
                                                                        <label class="custom-label customMarginUploaded">{{img.uploaded_by}}</label>
                                                                        <div>
                                                                            <template v-if="!checkFileType(img.path)">
                                                                                <button @click="printImage(img.path); return false;" class="btn btn-sm my-1 bg-white" type="button"><i class="fa fa-print fa-lg"> </i></button>
                                                                            </template>
                                                                            <button :class="checkFileType(img.path) ? '': 'ml-n2'" @click="downloadImage(img.path, img.name)" class="btn btn-sm my-1 bg-white" type="button"><i class="fa fa-arrow-circle-down fa-lg"> </i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-column">
                                                                    <div class="flex-column flex-wrap" v-if="!hideInModal">
                                                                        <label class="font-weight-bold">Rendering notes for customer:</label>
                                                                        <button @click="$set(img, 'approval_needed', !img.approval_needed)" class="btn btn-sm p-0 font-italic  text-left ml-1" type="button">(<u>edit</u>)</button>
                                                                        <textarea class="font-italic wrap-text ml-2" readonly rows="3" v-if="img.notes">{{ img.notes }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="flex-column ml-auto mx-3 my-auto">
                                                                <div class="flex-column" v-if="img.approval_needed">
                                                                    <label class="mx-0 my-1">Notes:</label>
                                                                    <b-form-textarea class="mx-0" no-resize size="sm" v-model="img.notes"></b-form-textarea>
                                                                    <div class="justify-content-center">
                                                                        <button @click="saveImage({id: img.id, notes: img.notes},true)" class="btn btn-sm p-0" type="button">Save</button>
                                                                        <button @click="img.notes = ''" class="btn btn-sm" type="button">Cancel</button>
                                                                    </div>
                                                                </div>
                                                                <button @click="moveFile({moveTo:'rejected', img:img})" class="btn-info w-100 my-1 custom-infobtn-toolbar custom-infobtn-text" type="button">Reject for Customer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex-column p-0 my-2 py-1 div-border" v-for="(img, key) of collaborationImages.rejectedImages">
                                                        <div>
                                                            <div class="btn-close mx-1 justify-content-center" v-if="!hideInModal">
                                                                <button @click="deleteFile(img)" class="btn btn-sm text-white p-0" type="button">X</button>
                                                            </div>
                                                            <div class="flex-column flex-grow-1 text-center">
                                                                <label class="font-weight-bold text-primary">Rejected by {{ img.rejected_by ? img.rejected_by.name: username }} {{ whoRejectedImage(img.rejected_by) }}</label>
                                                                <label class="text-info">Admin note:</label>
                                                                <label class="text-info">{{ img.custom_approved_at }}</label>
                                                                <label>Acknowledged by {{img.user? img.user.name: username }} @ {{ img.custom_approved_at }}</label>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="flex-column mx-2">
                                                                <div class="d-flex">
                                                                    <template v-if="checkFileType(img.path)">
                                                                        <div class="flex-column border mx-1 mb-2 py-1 custom-image justify-content-center file-container">
                                                                            <i class="fa fa-file fa-2x m-auto" @click="openPreviewNewPage(img.path)" style="cursor: pointer;"></i>
                                                                            <label class="text-center" @click="openPreviewNewPage(img.path)" style="cursor: pointer;">
                                                                                {{img.name.length > 10 ? img.name.substr(0,10)+'...' : img.name}}</label>
                                                                        </div>
                                                                    </template>
                                                                    <template v-else>
                                                                        <img :src="`/${img.path}`" @click="openPreviewNewPage(img.path)" style="cursor: pointer;" class="mx-1 border p-1 rounded my-1 custom-image"/>
                                                                    </template>
                                                                    <div class="flex-column mt-1">
                                                                        <label class="font-weight-bold custom-label customMarginUploadedFirst">{{ img.name.length > 20 ? img.name.substring(0,20) + '...' : img.name }}</label>
                                                                        <label class="text-info custom-label customMarginUploaded">{{ img.size }}</label>
                                                                        <label class="text-info custom-label customMarginUploaded">{{ img.custom_created_at }}</label>
                                                                        <label class="custom-label customMarginUploaded">{{img.uploaded_by}}</label>
                                                                        <div>
                                                                            <template v-if="!checkFileType(img.path)">
                                                                                <button @click="printImage(img.path); return false;" class="btn btn-sm my-1 bg-white" type="button"><i class="fa fa-print fa-lg"> </i></button>
                                                                            </template>
                                                                            <button :class="checkFileType(img.path) ? '': 'ml-n2'" @click="downloadImage(img.path, img.name)" class="btn btn-sm my-1 bg-white" type="button"><i class="fa fa-arrow-circle-down fa-lg"> </i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-column">
                                                                    <div class="flex-column flex-wrap" v-if="!hideInModal">
                                                                        <label class="font-weight-bold">Rendering notes for customer:</label>
                                                                        <button @click="$set(img, 'approval_needed', !img.approval_needed)" class="btn btn-sm p-0 font-italic  text-left ml-1" type="button">(<u>edit</u>)</button>
                                                                        <textarea class="font-italic wrap-text ml-2" readonly rows="3" v-if="img.notes">{{ img.notes }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="flex-column ml-auto mx-3 my-auto">
                                                                <div class="flex-column" v-if="img.approval_needed">
                                                                    <label class="mx-0 my-1">Notes:</label>
                                                                    <b-form-textarea class="mx-0" no-resize size="sm" v-model="img.notes"></b-form-textarea>
                                                                    <div class="justify-content-center">
                                                                        <button @click="saveImage({id: img.id, notes: img.notes},true)" class="btn btn-sm p-0" type="button">Save</button>
                                                                        <button @click="img.notes = ''" class="btn btn-sm" type="button">Cancel</button>
                                                                    </div>
                                                                    <button @click="moveFile({moveTo:'approved', img:img})" class="btn-info w-100 my-1 custom-infobtn-toolbar custom-infobtn-text" type="button">Accept for Customer</button>
                                                                    <button @click="" class="btn-info w-100 my-1 custom-infobtn-toolbar custom-infobtn-text" type="button">Reject for Customer</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </b-collapse>
                                    </div>
                                </div>
                                <div class="my-3 mr-3">
                                    <div class="col-2 p-0">
                                        <label>Customer View</label>
                                    </div>
                                    <div class="flex-column flex-grow-1">
                                        <b-button
                                            :aria-expanded="visibleCustomerView ? 'true' : 'false'"
                                            :class="visibleCustomerView ? 'btn btn-sm bg-white text-dark text-left border' : 'btn btn-sm bg-white text-dark text-left border collapsed'"
                                            @click="visibleCustomerView = !visibleCustomerView"
                                            aria-controls="collapse-customer-view">
                                            <i :class="toggleIcon(visibleCustomerView)"> </i> Click here to open or close
                                            customer view section
                                        </b-button>
                                        <b-collapse id="collapse-customer-view" v-model="visibleCustomerView">
                                            <div class="flex-column flex-grow-1 border rounded bg-white px-0">
                                                <div class="bg-toolbar p-1" v-if="!isClient && !hideInModal">
                                                    <button @click="formFields.uploadedFrom = 'customers'"
                                                            class="btn btn-sm border-0 list-toolbar custom-edit-text"
                                                            type="button"
                                                            v-b-modal.file-upload-modal>Add Files
                                                    </button>
                                                </div>
                                                <div class="flex-column px-1 pb-1">
                                                    <div class="p-0 my-2 div-border py-2"
                                                         v-for="(img, key) of collaborationImages.customerImages">
                                                        <template v-if="checkFileType(img.path)">
                                                            <div class="flex-column border mx-1 mb-2 py-1 custom-image justify-content-center file-container">
                                                                <i class="fa fa-file fa-2x m-auto" @click="openPreviewNewPage(img.path)" style="cursor: pointer;"></i>
                                                                <label :title="`${img.name}`" class="text-center" v-b-tooltip.hover @click="openPreviewNewPage(img.path)"
                                                                       style="cursor: pointer;">
                                                                    {{img.name.length > 10 ? img.name.substr(0,10)+'...' : img.name }}</label>
                                                            </div>
                                                        </template>
                                                        <template v-else>
                                                            <img :src="`/${img.path}`" @click="openPreviewNewPage(img.path)" style="cursor: pointer;" class="mx-1 border p-1 rounded my-1 custom-image"/>
                                                        </template>
                                                        <div class="flex-column mt-1">
                                                            <label :title="`${img.name}`" class="font-weight-bold custom-label" v-b-tooltip.hover>{{ img.name.length > 20 ? img.name.substring(0,13)+'...' + img.name.substring(img.name.length - 7) : img.name }}</label>
                                                            <label class="text-info custom-label">{{ img.size }}</label>
                                                            <label class="text-info custom-label">{{ img.custom_created_at }}</label>
                                                            <label class="custom-label"></label>
                                                            <div>
                                                                <template v-if="!checkFileType(img.path)">
                                                                    <button @click="printImage(img.path); return false;" class="btn btn-sm my-1 bg-white"
                                                                            type="button"><i
                                                                        class="fa fa-print fa-lg"> </i></button>
                                                                </template>
                                                                <button :class="checkFileType(img.path) ? '': 'ml-n2'" @click="downloadImage(img.path, img.name)" class="btn btn-sm my-1 bg-white"
                                                                        type="button"><i
                                                                    class="fa fa-arrow-circle-down fa-lg"> </i></button>
                                                            </div>
                                                        </div>
                                                        <div class="flex-column col-4 mx-3 ml-auto" v-if="!isClient && !hideInModal">
                                                            <button @click="deleteFile(img)" class="btn-info mx-1 my-1 custom-infobtn-toolbar custom-infobtn-text mt-5 w-100" type="button">Remove File</button>
                                                            <button @click="showCustomerViewMailPopup(img)" class="btn-info mx-1 my-1 custom-infobtn-toolbar custom-infobtn-text mt-1 w-100" type="button" v-b-modal.customer-email-modal>Send Email</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </b-collapse>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 div-shadow bg-white rounded d-block pl-0">
                                <div class="custom-row justify-content-between">
                                    <div>
                                        <h6 class="m-0 custom-form-heading">Order Form</h6>
                                    </div>
                                    <div>
                                        <label>Date Promised</label>
                                        <b-form-datepicker
                                            :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                            :disabled="hideInModal"
                                            @input="order.invoice.date_promised = checkDate(order.invoice.date_promised)"
                                            class="input-xl ml-auto mr-0 input-date"
                                            close-button
                                            locale="en"
                                            placeholder=""
                                            reset-button
                                            size="sm"
                                            today-button
                                            v-model="order.invoice.date_promised">
                                        </b-form-datepicker>
                                    </div>
                                </div>
                                <div class="custom-row">
                                    <div class="ml-n2">
                                        <label>Order Date</label>
                                        <b-form-input :value="changeDateFormat(order.date)" class="input-md" disabled size="sm" type="text"></b-form-input>
                                    </div>
                                    <div>
                                        <label>Invoice No.</label>
                                        <b-form-input :value="order.invoice.invoice_number" class="input-md" disabled size="sm" type="text"></b-form-input>
                                    </div>
                                    <div>
                                        <label>Email</label>
                                        <b-form-input :value="order.family.email" class="input-xl-width" disabled size="sm"
                                                      type="text"></b-form-input>
                                    </div>
                                </div>
                                <div class="custom-row">
                                    <div>
                                        <h6 class="m-0 custom-form-heading mt-3">Store Location Info.</h6>
                                    </div>
                                </div>
                                <div class="custom-row mt-2 ml-n2">
                                    <div>
                                        <label>Stores</label>
                                        <b-form-input :value="order.company.name" class="input-xl" disabled size="sm"
                                                      type="text"></b-form-input>
                                    </div>
                                    <div>
                                        <label>Salesperson</label>
                                        <b-form-input :value="order.sales_person" class="input-xl" disabled size="sm"
                                                      type="text"></b-form-input>
                                    </div>
                                </div>
                                <div class="custom-row">
                                    <div>
                                        <h6 class="m-0 custom-form-heading mt-3">Family Information</h6>
                                    </div>
                                </div>
                                <div class="custom-row mt-2">
                                    <div class="ml-n2">
                                        <label>Last Name on Stone</label>
                                        <b-form-input :value="order.family.name_on_stone" class="input-lg" disabled size="sm"
                                                      type="text"></b-form-input>
                                    </div>
                                    <div>
                                        <label>Customer Contact</label>
                                        <b-form-input :value="order.family.contact" disabled size="sm"
                                                      type="text"></b-form-input>
                                    </div>
                                    <div>
                                        <label>Phone</label>
                                        <b-form-input :value="order.family.phone" class="input-sm" disabled size="sm"
                                                      type="text"></b-form-input>
                                    </div>
                                </div>
                                <div :class="!hideInModal ? 'custom-minwidth-47' : 'custom-minwidth-45'" class="custom-row">
                                    <div class="col-12 ml-n3">
                                        <b-table :fields="productsTableFields" :items="order.products" bordered
                                                 class="small"
                                                 responsive
                                                 small>
                                            <template #cell(product_number)="row">

                                                <template
                                                    v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{row.item.non_stock_product[0].product_number}}</label>
                                                </template>
                                                <template v-if="row.item.monument && row.item.monument.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{row.item.monument[0].product_number}}</label>
                                                </template>
                                                <template v-if="row.item.service && row.item.service.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{row.item.service[0].product_number}}</label>
                                                </template>
                                                <template v-if="row.item.simple && row.item.simple.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{row.item.simple[0].product_number}}</label>
                                                </template>
                                                <template v-if="row.item.composite && row.item.composite.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{row.item.composite[0].product_number}}</label>
                                                </template>
                                            </template>
                                            <template v-slot:cell(item_name)="row">
                                                <template
                                                    v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{row.item.non_stock_product[0].item_name}}</label>
                                                </template>
                                                <template v-if="row.item.monument && row.item.monument.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{row.item.monument[0].item_name}}</label>
                                                </template>
                                                <template v-if="row.item.service && row.item.service.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{row.item.service[0].item_name}}</label>
                                                </template>
                                                <template v-if="row.item.simple && row.item.simple.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{row.item.simple[0].item_name}}</label>
                                                </template>
                                                <template v-if="row.item.composite && row.item.composite.length > 0">
                                                    <label class="d-flex justify-content-center product-table">{{row.item.composite[0].item_name}}</label>
                                                </template>
                                            </template>
                                            <template v-slot:cell(client_price)="row">
                                                <template v-if="row.item.non_stock_product && row.item.non_stock_product.length > 0">
                                                    <label class="d-none">{{row.item.client_price > row.item.price ? row.item.client_price : row.item.client_price = row.item.price}}</label>
                                                    <label class="d-flex product-table">$ {{ changeNumberFormat(row.item.client_price) ?
                                                        changeNumberFormat(row.item.client_price) : '0.00' }}</label>
                                                </template>
                                                <template v-else>
                                                    <label class="d-flex product-table">$ {{ changeNumberFormat(row.item.client_price) ?
                                                        changeNumberFormat(row.item.client_price) : '0.00' }}</label>
                                                </template>
                                            </template>
                                            <template v-slot:cell(amount)="row">
                                                <label class="d-none">$ {{ row.item.amount =
                                                    Math.abs((row.item.quantity*row.item.client_price)).toFixed(2) }}</label>
                                                <label class="">$ {{ changeNumberFormat(row.item.amount) ? changeNumberFormat(row.item.amount) : '0.00' }}</label>
                                                <input :value="row.item.amount" disabled name="amount" type="hidden">
                                            </template>
                                            <template v-slot:cell(installation_price)="row">
                                                <label class="d-flex product-table">$ {{ changeNumberFormat(row.item.installation_price) ?
                                                    changeNumberFormat(row.item.installation_price) : '0.00' }}</label>
                                            </template>
                                            <template v-slot:cell(installation_amount)="row">
                                                <label class="d-none">$ {{
                                                    Math.abs((row.item.quantity * row.item.installation_price)).toFixed(2) }}</label>
                                                <label>$ {{ changeNumberFormat(row.item.quantity * row.item.installation_price) ? changeNumberFormat(row.item.quantity * row.item.installation_price)
                                                    : '0.00' }}</label>
                                            </template>
                                            <template v-slot:cell(total)="row">
                                                <label class="d-none">$ {{ row.item.total = Math.abs(+row.item.amount +
                                                    parseFloat(row.item.installation_price == '' ? 0 :
                                                    row.item.quantity * row.item.installation_price)).toFixed(2) }}</label>
                                                <label>$ {{ changeNumberFormat(row.item.total) ? changeNumberFormat(row.item.total) : '0.00' }}</label>
                                                <input :value="row.item.total" disabled name="total" type="hidden">
                                            </template>
                                            <template v-slot:cell(showProducts)="row">
                                                <b-button
                                                    @click="row.toggleDetails"
                                                    class="btn btn-sm btn-info order-form-btn py-1 mx-1 "
                                                    size="sm"
                                                    v-if="row.item.iscompositeDetails">
                                                    {{ row.detailsShowing ? 'Hide' : 'Show'}}
                                                </b-button>
                                            </template>
                                            <template v-slot:row-details="row">
                                                <b-card no-body>
                                                    <table class="table table-sm table-striped table-bordered my-2 ">
                                                        <thead class="custom-table-header">
                                                        <tr>
                                                            <th>Product #</th>
                                                            <th>Product Name</th>
                                                            <th>Qty</th>
                                                            <th>Price</th>
                                                            <th>Amount</th>
                                                            <th>Install Price</th>
                                                            <th>Install Amount</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="custom-table-body">
                                                        <tr v-for="(obj, key) of row.item.composite[0].composite_products">
                                                            <td>
                                                                <template v-if="obj.monument && obj.monument.length > 0">
                                                                    <label class="d-flex justify-content-center product-table">{{obj.monument[0].product_number}}</label>
                                                                </template>
                                                                <template v-if="obj.service && obj.service.length > 0">
                                                                    <label class="d-flex justify-content-center product-table">{{obj.service[0].product_number}}</label>
                                                                </template>
                                                                <template v-if="obj.simple && obj.simple.length > 0">
                                                                    <label class="d-flex justify-content-center product-table">{{obj.simple[0].product_number}}</label>
                                                                </template>
                                                            </td>
                                                            <td>
                                                                <template v-if="obj.monument && obj.monument.length > 0">
                                                                    <label class="d-flex justify-content-center product-table">{{obj.monument[0].item_name}}</label>
                                                                </template>
                                                                <template v-if="obj.service && obj.service.length > 0">
                                                                    <label class="d-flex justify-content-center product-table">{{obj.service[0].item_name}}</label>
                                                                </template>
                                                                <template v-if="obj.simple && obj.simple.length > 0">
                                                                    <label class="d-flex justify-content-center product-table">{{obj.simple[0].item_name}}</label>
                                                                </template>
                                                            </td>
                                                            <td>
                                                                <label class="d-flex justify-content-center product-table">{{row.item.quantity
                                                                    * obj.quantity}}</label>
                                                            </td>
                                                            <td>
                                                                <template v-if="obj.monument && obj.monument.length > 0">
                                                                    <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(obj.monument[0].override_selling_price) ?
                                                                        changeNumberFormat(obj.monument[0].override_selling_price) : '0.00' }}</label>
                                                                </template>
                                                                <template v-if="obj.service && obj.service.length > 0">
                                                                    <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(obj.service[0].override_selling_price) ?
                                                                        changeNumberFormat(obj.service[0].override_selling_price) : '0.00' }}</label>
                                                                </template>
                                                                <template v-if="obj.simple && obj.simple.length > 0">
                                                                    <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(obj.simple[0].override_selling_price) ?
                                                                        changeNumberFormat(obj.simple[0].override_selling_price) : '0.00' }}</label>
                                                                </template>
                                                            </td>
                                                            <td>
                                                                <template v-if="obj.monument && obj.monument.length > 0">
                                                                    <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(row.item.quantity * obj.quantity * obj.monument[0].override_selling_price) ?
                                                                        changeNumberFormat(row.item.quantity * obj.quantity * obj.monument[0].override_selling_price) : '0.00' }}</label>
                                                                </template>
                                                                <template v-if="obj.service && obj.service.length > 0">
                                                                    <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(row.item.quantity * obj.quantity * obj.service[0].override_selling_price) ?
                                                                        changeNumberFormat(row.item.quantity * obj.quantity * obj.service[0].override_selling_price) : '0.00' }}</label>
                                                                </template>
                                                                <template v-if="obj.simple && obj.simple.length > 0">
                                                                    <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(row.item.quantity * obj.quantity * obj.simple[0].override_selling_price) ?
                                                                        changeNumberFormat(row.item.quantity * obj.quantity * obj.simple[0].override_selling_price) : '0.00' }}</label>
                                                                </template>
                                                            </td>
                                                            <td>
                                                                <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(obj.installation_price) ?
                                                                    changeNumberFormat(obj.installation_price) : '0.00' }}</label>
                                                            </td>
                                                            <td>
                                                                <label class="d-flex justify-content-center product-table">$ {{ changeNumberFormat(row.item.quantity * obj.quantity * obj.installation_price) ?
                                                                    changeNumberFormat(row.item.quantity * obj.quantity * obj.installation_price) : '0.00' }}</label>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </b-card>
                                            </template>
                                        </b-table>
                                    </div>
                                </div>
                                <div class="custom-row d-block ml-n2">
                                    <div>
                                        <h6 class="ml-2 custom-form-heading mt-1">Notes</h6>
                                    </div>
                                    <div>
                                        <b-form-textarea
                                            :disabled="hideInModal"
                                            class="mx-2"
                                            no-resize
                                            rows="3"
                                            size="sm"
                                            v-model="formFields.notes"
                                        ></b-form-textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="custom-row d-block div-shadow bg-white rounded pb-2" v-if="!isClient">
                            <div class="custom-row d-block">
                                <div>
                                    <h6 class="ml-n4 my-2 custom-form-heading">Task Collaboration</h6>
                                </div>
                            </div>
                            <div class="custom-row bg-primary ml-n3" v-if="!hideInModal">
                                <button @click="addTask('collaboration')" class="btn btn-sm list-toolbar m-1 border-0"
                                        type="button">Add Task
                                </button>
                                <button :disabled="deleteCollaborationTasks.length==0" @click="deleteTask('collaboration')"
                                        class="btn btn-sm list-toolbar m-1 border-0" type="button">
                                    Delete Task
                                </button>
                            </div>
                            <div class="custom-row d-block">
                                <div v-if="order.collaboration.tasks.length>0">
                                    <div class="" style="visibility: hidden;">
                                        <input type="checkbox">
                                    </div>
                                    <div class="col-1 task-collaboration-date" style="margin-left: 3px;">
                                        <label class="m-0">Date</label>
                                    </div>
                                    <div class="col-2 ml-n4 collaboration-task-block">
                                        <label class="m-0">Assigned To</label>
                                    </div>
                                    <div class="col-4 ml-n4 collaboration-task-block">
                                        <label class="m-0">Task</label>
                                    </div>
                                    <div class="col-1 ml-n4 collaboration-task-block collaboration-dept-width">
                                        <label class="m-0">Dept</label>
                                    </div>
                                    <div class="col-1 ml-2 collaboration-task-block">
                                        <label class="m-0">Created By</label>
                                    </div>
                                    <div class="col-1 task-collaboration-closedate" style="margin-left: -23px;">
                                        <label class="m-0">Close Date</label>
                                    </div>
                                    <div class="col-1 ml-n4 collaboration-task-block">
                                        <label class="m-0">Task Status</label>
                                    </div>
                                </div>
                                <div :id="'collaboration-'+key" class="my-2" v-for="(task, key) in order.collaboration.tasks">
                                    <div :class="key == 0 ? '': '' " v-if="!hideInModal">
                                        <input @click="selectRow({event:$event, type: 'collaboration', id: order.collaboration.tasks[key].id, currentKey:key})"
                                               type="checkbox">
                                    </div>
                                    <div class="col-1 task-collaboration-date">
                                        <b-form-datepicker :date-format-options="{ year: '2-digit', month: 'numeric', day: 'numeric' }"
                                                           :disabled="hideInModal"
                                                           @input="order.collaboration.tasks[key].date = checkDate(order.collaboration.tasks[key].date)" class="my-auto input-date" close-button locale="en"
                                                           name="date"
                                                           placeholder=""
                                                           reset-button
                                                           size="sm"
                                                           today-button
                                                           v-model="order.collaboration.tasks[key].date">
                                        </b-form-datepicker>
                                    </div>
                                    <div class="col-2 ml-n4 collaboration-task-block">
                                        <b-dropdown :disabled="hideInModal" class="border rounded dropdown-width" no-caret
                                                    size="sm" toggle-class="" variant="none">
                                            <template #button-content>
                                                <div class="d-flex flex-wrap">
                                                    <small :title="order.collaboration.tasks[key].assigned_to ? order.collaboration.tasks[key].assigned_to:''" class="d-flex flex-wrap" v-b-tooltip.hover>
                                                        {{order.collaboration.tasks[key].assigned_to ?
                                                        order.collaboration.tasks[key].assigned_to.length > 25 ? order.collaboration.tasks[key].assigned_to.substr(0,25)+'...' : order.collaboration.tasks[key].assigned_to
                                                        : 'Search Collaborator' }}
                                                    </small>
                                                    <i aria-hidden="true" class="fa fa-caret-down ml-auto"></i>
                                                </div>
                                            </template>
                                            <b-dropdown-group class="overflow-auto scroll px-1">
                                                <div class="justify-content-center">
                                                    <div class="my-1 w-100 mx-1">
                                                        <b-form-input @keydown="stopOutline"
                                                                      class="mt-1"
                                                                      size="sm"
                                                                      v-model="searchTerm"
                                                        ></b-form-input>
                                                    </div>
                                                </div>
                                                <template v-for="obj of searchCollaboratorList">
                                                    <b-dropdown-group @click="handleDropdownChange"
                                                        :class="[isOutline ? '' : 'remove-outline']"
                                                        class="mx-2 drop-list-2">
                                                        <b-dropdown-item-button @click="order.collaboration.tasks[key].assigned_to = obj.full_name">
                                                            <label class="ml-n4 px-1" v-html="obj.text">{{obj.text}}</label>
                                                        </b-dropdown-item-button>
                                                    </b-dropdown-group>
                                                </template>
                                            </b-dropdown-group>
                                        </b-dropdown>
                                    </div>

                                    <div class="col-4 ml-n4 collaboration-task-block">
                                        <b-form-input :disabled="hideInModal" size="sm" type="text"
                                                      v-model="order.collaboration.tasks[key].task"></b-form-input>
                                    </div>
                                    <div class="col-1 ml-n4 collaboration-task-block collaboration-dept-width">
                                        <b-form-select
                                            :disabled="hideInModal"
                                            :options="deptList"
                                            class="form-control form-control-sm custom-caret-form dept-select-width"
                                            name="collaboration[dept_id]"
                                            size="sm"
                                            v-model="order.collaboration.tasks[key].department_id"
                                            v-on:change="departmentLabel(order.collaboration.tasks[key].department_id)">
                                            <template #first>
                                                <b-form-select-option :value="null" disabled>Select</b-form-select-option>
                                            </template>
                                        </b-form-select>
                                    </div>
                                    <div class="col-1 ml-2 collaboration-task-block">
                                        <b-form-input :disabled="hideInModal" size="sm" type="text"
                                                      v-model="order.collaboration.tasks[key].created_by"></b-form-input>
                                    </div>
                                    <div class="col-1 ml-n4 task-collaboration-closedate">
                                        <b-form-datepicker :date-format-options="{ year: '2-digit', month: 'numeric', day: 'numeric' }"
                                                           :disabled="hideInModal"
                                                           @input="order.collaboration.tasks[key].close_date = closeDateChanged(order.collaboration.tasks[key].close_date, key)" class="my-auto input-date" close-button locale="en"
                                                           name="date"
                                                           placeholder=""
                                                           reset-button
                                                           size="sm"
                                                           today-button
                                                           v-model="order.collaboration.tasks[key].close_date">
                                        </b-form-datepicker>
                                    </div>
                                    <div class="col-1 ml-n4 collaboration-task-block">
                                        <b-dropdown :class="order.collaboration.tasks[key].status == 'pending' ? 'bg-red' :
                                                order.collaboration.tasks[key].status == 'in_progress' ? 'bg-warning':
                                                 order.collaboration.tasks[key].status == 'Complete' ? 'bg-success':  '' " :disabled="hideInModal" class="border rounded dropdown-width" no-caret size="sm"
                                                    style="width:10rem"
                                                    variant="none">
                                            <template #button-content>
                                                <div class="d-flex" style="color: white;">
                                                    <small>{{ order.collaboration.tasks[key].status ?
                                                        customizeLabel(order.collaboration.tasks[key].status) : order.collaboration.tasks[key].status = 'pending' }}
                                                    </small>
                                                    <i aria-hidden="true" class="fa fa-caret-down ml-auto"></i>
                                                </div>
                                            </template>
                                            <b-dropdown-group class="px-1">
                                                <template v-for="obj of statusList">
                                                    <b-dropdown-group>
                                                        <b-dropdown-item-button @click="order.collaboration.tasks[key].status = obj.value"
                                                                                class="small">
                                                            {{ obj.text }}
                                                        </b-dropdown-item-button>
                                                    </b-dropdown-group>
                                                </template>
                                            </b-dropdown-group>
                                        </b-dropdown>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="custom-row d-block div-shadow bg-white rounded pb-2" v-if="!isClient">
                            <div class="custom-row d-block">
                                <div>
                                    <h6 class="ml-n4 my-2 custom-form-heading">Correspondence</h6>
                                </div>
                            </div>
                            <div class="custom-row bg-primary ml-n3" v-if="!hideInModal">
                                <button @click="addTask('correspondence',{})" class="btn btn-sm list-toolbar m-1 border-0"
                                        type="button">Add Task
                                </button>
                                <button :disabled="deleteCorrespondenceTask.length==0" @click="deleteTask('correspondence')"
                                        class="btn btn-sm list-toolbar m-1 border-0" type="button">
                                    Delete Task
                                </button>
                            </div>
                            <div class="custom-row d-block">
                                <div v-if="order.correspondence.tasks?.length>0">
                                    <div style="visibility: hidden;">
                                        <input type="checkbox">
                                    </div>
                                    <div class="col-1 task-collaboration-date">
                                        <label>Date</label>
                                    </div>
                                    <div class="col-1 ml-n4 collaboration-task-block" style="min-width:6.5rem;">
                                        <label>Who Corsp</label>
                                    </div>
                                    <div class="col-1 ml-n4 collaboration-task-block collaboration-form-communication">
                                        <label>Form of Communication</label>
                                    </div>
                                    <div class="col-2 ml-n4 collaboration-task-block" style="min-width:12rem;">
                                        <label class="">Why Contacted</label>
                                    </div>
                                    <div class="col-3 ml-n4 collaboration-task-block" style="min-width:20rem;">
                                        <label class="">Reasons From Customer</label>
                                    </div>
                                    <div class="col-3 ml-n4 collaboration-task-block">
                                        <label class="">Notes</label>
                                    </div>
                                    <div class="col-1 ml-n4 collaboration-task-block">
                                        <label class="">Name of Contact</label>
                                    </div>
                                </div>
                                <div class="my-2 correspondence-row" v-for="(task, key) in order.correspondence.tasks">
                                    <div :class="key == 0 ? '': '' " style="position: absolute;" v-if="!hideInModal">
                                        <input @change="selectRow({event:$event, type: 'correspondence', id: order.correspondence.tasks[key].id, currentKey:key})" class="correspondence-checkbox"
                                               type="checkbox">
                                    </div>
                                    <div class="col-1 task-collaboration-date">
                                        <b-form-datepicker :date-format-options="{ year: '2-digit', month: 'numeric', day: 'numeric' }"
                                                           :disabled="hideInModal"
                                                           @input="order.correspondence.tasks[key].date = checkDate(order.correspondence.tasks[key].date)" class="my-auto input-date correspondence-date" close-button
                                                           locale="en" name="date"
                                                           placeholder=""
                                                           reset-button
                                                           size="sm"
                                                           today-button
                                                           v-model="order.correspondence.tasks[key].date">
                                        </b-form-datepicker>
                                    </div>
                                    <div class="col-1 ml-n4 collaboration-task-block" style="min-width:6.5rem;">
                                        <b-form-textarea
                                            :disabled="hideInModal" :rows="autoResizeWhoCorsp(order.correspondence.tasks[key].who_corsp)" class="textarea-overflow"
                                            no-resize
                                            size="sm"
                                            type="text"
                                            v-model="order.correspondence.tasks[key].who_corsp"
                                        ></b-form-textarea>
                                    </div>
                                    <div class="col-1 ml-n4 collaboration-task-block collaboration-form-communication">
                                        <b-form-textarea
                                            :disabled="hideInModal" :rows="autoResizeFormCommunication(order.correspondence.tasks[key].form_of_communication)" class="textarea-overflow"
                                            no-resize
                                            size="sm"
                                            type="text"
                                            v-model="order.correspondence.tasks[key].form_of_communication"
                                        ></b-form-textarea>
                                    </div>
                                    <div class="col-2 ml-n4 collaboration-task-block" style="min-width:12rem;">
                                        <b-form-textarea
                                            :disabled="hideInModal" :rows="autoResizeWhyContacted(order.correspondence.tasks[key].why_contacted)" class="textarea-overflow"
                                            no-resize
                                            size="sm"
                                            type="text"
                                            v-model="order.correspondence.tasks[key].why_contacted"
                                        ></b-form-textarea>
                                    </div>
                                    <div class="col-3 ml-n4 collaboration-task-block" style="min-width:20rem;">
                                        <b-form-textarea
                                            :disabled="hideInModal" :rows="autoResizeCustomerReason(order.correspondence.tasks[key].customer_reasons)" class="textarea-overflow"
                                            no-resize
                                            size="sm"
                                            type="text"
                                            v-model="order.correspondence.tasks[key].customer_reasons"
                                        ></b-form-textarea>
                                    </div>
                                    <div class="col-3 ml-n4 collaboration-task-block">
                                        <b-form-textarea
                                            :disabled="hideInModal" :rows="autoResizeNotes(order.correspondence.tasks[key].notes)" class="textarea-overflow"
                                            no-resize
                                            size="sm"
                                            type="text"
                                            v-model="order.correspondence.tasks[key].notes"
                                        ></b-form-textarea>
                                    </div>
                                    <div class="col-1 ml-n4 collaboration-task-block">
                                        <b-form-textarea
                                            :disabled="hideInModal" :rows="autoResizeContactName(order.correspondence.tasks[key].contact_name,'contact_name')" class="textarea-overflow"
                                            no-resize
                                            size="sm"
                                            style="min-width: 8rem;"
                                            type="text"
                                            v-model="order.correspondence.tasks[key].contact_name"
                                        ></b-form-textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="custom-row d-block div-shadow bg-white rounded pb-2" v-if="!isClient">
                            <div class="custom-row d-block">
                                <div>
                                    <h6 class="ml-n4 my-2 custom-form-heading">Order Log</h6>
                                    <b-button
                                        :aria-expanded="visibleOrderLog ? 'true' : 'false'"
                                        :class="visibleOrderLog ? 'btn btn-sm bg-white text-dark text-left ml-5' : 'btn btn-sm  bg-white text-dark text-left collapsed ml-5'"
                                        @click="visibleOrderLog = !visibleOrderLog"
                                        aria-controls="collapse-order-logs"
                                        style="border-style: none;">
                                        <i :class="toggleIcon(visibleOrderLog)"> </i> Click here to Open/Close Order Log
                                    </b-button>
                                </div>
                            </div>
                            <b-collapse class="flex-column rounded bg-white" id="collapse-order-logs"
                                        v-model="visibleOrderLog">
                                <div class="custom-row d-block m-0 pl-0 ml-4">
                                    <template v-if="!hideInModal">
                                        <button :disabled="deleteOrderLog.length==0" @click="deleteLog()" class="btn-info mx-1 custom-infobtn-toolbar custom-infobtn-text"
                                                type="button" v-if="isAdmin">
                                            Delete Log
                                        </button>
                                    </template>
                                    <div v-if="orderLogs.length>0">
                                        <div style="visibility: hidden;">
                                            <input type="checkbox">
                                        </div>
                                        <div class="col-1 task-collaboration-date">
                                            <label>Date</label>
                                        </div>
                                        <div class="col-5 ml-n4 collaboration-task-block">
                                            <label>Logs</label>
                                        </div>
                                        <div class="col-1 ml-n4 collaboration-task-block collaboration-form-communication">
                                            <label>By</label>
                                        </div>
                                        <div class="col-5 ml-n4 collaboration-task-block" style="min-width:20rem;">
                                            <label class="">Notes</label>
                                        </div>
                                    </div>
                                    <div class="my-2" v-for="(task, key) in orderLogs">
                                        <div :class="key == 0 ? '': '' " v-if="!hideInModal">
                                            <input @change="selectOrderLog({event:$event, id: orderLogs[key].id, currentKey:key})"
                                                   type="checkbox">
                                        </div>
                                        <div class="col-1 task-collaboration-date">
                                            <b-form-input disabled size="sm" type="text"
                                                          v-model="orderLogs[key].date"></b-form-input>
                                        </div>
                                        <div class="col-5 ml-n4 collaboration-task-block">
                                            <b-form-input disabled size="sm" type="text"
                                                          v-model="orderLogs[key].log"></b-form-input>
                                        </div>
                                        <div class="col-1 ml-n4 collaboration-task-block collaboration-form-communication">
                                            <b-form-input disabled size="sm" type="text"
                                                          v-model="orderLogs[key].user.name"></b-form-input>
                                        </div>
                                        <div class="col-5 ml-n4 collaboration-task-block">
                                            <b-form-input :disabled="hideInModal" size="sm" type="text"
                                                          v-model="orderLogs[key].notes"></b-form-input>
                                        </div>
                                    </div>
                                </div>
                            </b-collapse>
                        </div>
                        <div class="toolbar ml-auto" v-if="!hideInModal">
                            <button :disabled="saveDisabled" @click="storeCollaboration" class="btn-info mx-1 custom-infobtn-toolbar custom-infobtn-text" type="button" v-if="isUpdatePermitted">
                                {{ id ? 'Update' : 'Save' }}<span class="spinner-grow spinner-grow-sm ml-1" v-if="saveDisabled"></span>
                            </button>
                        </div>
                    </template>
                </form>
            </div>
            <FileUploadModal :formFields="formFields"></FileUploadModal>
            <PDF :title="'printApprovalConfimation'" style="margin-left: -2rem !important;">
                <div slot="header">
                    <div class="d-flex flex-column text-center">
                        <h1 style="font-size: 40px !important;font-weight: 600">FRISBIE MONUMENTS</h1>
                        <label class="m-0" style="font-size: 18px !important;">Thank you for approving the monument for JOHN SMITH ? ordered from {{ order.company.name }}</label>
                        <label style="font-size: 18px !important;">Order # {{ order.id }} was ordered on {{ order.customDate }}.</label>
                    </div>
                </div>
                <div slot="body">
                    <b-table :fields="approvedTableFields" :items="collaborationImages.approvedImages"
                             class="no-border small"
                             responsive
                             small>
                        <template #head()="data">
                            <label style="font-size: 25px !important;">{{ data.label }}</label>
                        </template>
                        <template #cell(approved_by)="row">
                            {{ row.item.user? row.item.user.name: '' }}
                        </template>
                    </b-table>
                </div>
                <div slot="footer"></div>
            </PDF>
            <b-modal id="customer-email-modal" title="Customer View  -  Send Email">
                <template #modal-footer="{ ok, cancel, hide }">
                    <b-button @click="sendCustomerViewMail" size="sm" variant="primary">Send Email</b-button>
                </template>
                <div class="custom-row d-block">
                    <b-form-textarea :disabled="true" class="mx-0 mt-2" no-resize placeholder="Emails..." size="sm" v-model="customer_email"></b-form-textarea>
                    <b-form-textarea class="mx-0 mt-2" no-resize placeholder="Message here..." rows="4" size="sm" v-model="customer_message"></b-form-textarea>
                    <label>Uploaded Image:</label>
                    <a :href="customer_image" class="mt-3" size="sm" style="font-size: 12px !important;">{{ customer_image_name && customer_image_name.length > 20 ? customer_image_name.substring(0,20)+'...' : customer_image_name }}</a>
                </div>
            </b-modal>
        </div>
    </template>
    <script>
        let vue_global = '';
    </script>
    <script>
        import Toolbar from "./Toolbar";
        import PDF from "../../Modules/PDF-Modal";
        import Price from "../../Modules/Price";
        import FileUploadModal from "../../Modules/fileUploadModal";
        import {event, eventBus} from "../../event-bus/event-bus";
        import {searchForEmptyDate} from "../../helpers/common";
        import {compositeReportFilterRecord, deleteProductFile, deleteRecord, deleteTask, fetchRecord, fetchRecords, firstRecord, lastRecord, nextRecord, previousRecord, saveRecord, sendApprovalMail, sendCustomerViewMail, sendMail, updateRecord} from "../../helpers/axios";

        export default {
            name: "Add",
            props: {
                id: {
                    type: Number
                },
                hideInModal: {
                    type: Boolean,
                    default: false
                }
            },
            components: {
                Toolbar,
                Price,
                PDF,
                FileUploadModal,
            },
            computed: {
                isLoading() {
                    return this.$store.state[this.axiosParams.module].busy;
                },
                searchCollaboratorList: function () {
                    let options = [];
                    for (let opt of this.formFields.collaborators) {
                        if (!opt.type) {
                            opt.type = {title: ''}
                        }
                        if (opt.email && opt.is_box_checked) {
                            let obj = {value: opt.email, full_name : opt.first_name + ' ' + opt.last_name, text: opt.first_name + ' ' + opt.last_name + ' <b>(' + opt.type.title.charAt(0) + ')</b>' + '<br><b>' + opt.email + '</b>'};
                            options.push(obj);
                        }
                    }
                    if (this.searchTerm != '') {
                        options = options.filter(obj => obj.text.toUpperCase().indexOf(this.searchTerm.toUpperCase()) > -1)
                    }
                    return options;
                },
                isUpdatePermitted() {
                    return this.$store.getters.isPermitted({resource: 'Collaboration', action: 'update'});
                },
                filterCollaborators() {
                    return this.searchCollaboratorList.filter(obj => obj.value == this.email)
                },
                username: function () {
                    if (this.$store.state['auth'].user)
                        return this.$store.state['auth'].user.name ? this.$store.state['auth'].user.name : 'user';
                },
                isClient: function () {
                    if (this.$store.state['auth'].user && this.$store.state['auth'].user.role)
                        return this.$store.state['auth'].user.role.title == 'Client';
                    else
                        return true;
                },
                orderStatusList() {
                    // this.$store.getters.sortByAlphaNumeric({'module': 'orderStatus', 'fieldName': 'title'});
                    let list = []
                    for (let opt of this.$store.state.orderStatus.recordList) {
                        list.push({value: opt.id, text: opt.title});
                    }
                    return list;
                },
                paperLocationList() {
                    let list = []
                    for (let opt of this.$store.state.paperLocation.recordList) {
                        list.push({value: opt.id, text: opt.location_title});
                    }
                    this.$store.state.paperLocation.busy = false;
                    return list;
                },
                order() {
                    if (this.formFields.order == null) {
                        this.formFields.order = {
                            invoice: {}, company: {}, family: {}, products: [], collaboration: {tasks: []},
                            correspondence: {tasks: []}
                        };
                    }
                    if (this.formFields.order) {
                        let customDate = new Date(this.formFields.order.date);
                        this.formFields.order.customDate = customDate.toLocaleString('en-US', {
                            day: 'numeric',
                            year: 'numeric',
                            month: 'long',
                            hour: 'numeric',
                            minute: 'numeric',
                            second: 'numeric',
                        })
                    }
                    return this.formFields.order
                },
                collaboratorTypeList() {
                    let list = []
                    for (let item of this.collaboratorTypes) {
                        list.push({value: item.id, text: this.customizeLabel(item.title)})
                    }
                    return list
                },
                collaboratorTypeNavList() {
                    let list = []
                    list.push({value: 'all', text: 'Show All'})
                    for (let item of this.collaboratorTypes) {
                        list.push({value: item.title, text: this.customizeLabel(item.title)})
                    }
                    return list
                },
                /*collaboratorIsCheck() {
                    return (data) => {
                        if (data.collaborator_check && data.collaborator_check.length > 0) {
                            return data.collaborator_check[0].is_check;
                        }
                        return false;
                    };
                },*/
                collaboratorList() {
                    let sections = {add: [], email: []}
                    this.visibleNewCollaborator = false
                    this.collaborator = {}
                    window.vue_global = this;
                    if (this.selectedCollaboratorAdd == 'all') {
                        sections.add = this.formFields.collaborators
                        let defaultCustomer = {
                            is_custom: true,
                            family_id:this.formFields.order.family.id ,
                            collaboration_id: this.$props.id ? this.$props.id : 0,
                            email: this.formFields.order.family.email,
                            first_name: this.formFields.order.family.name_on_stone,
                            last_name: '',
                            is_box_checked:this.formFields.order.family.email_collaborate ,
                            phone: this.formFields.order.family.phone,
                            type: {title: "Customer"}
                        }
                        if (sections.add.findIndex(obj => obj.is_custom) === -1) sections.add.push(defaultCustomer);
                    } else {
                        sections.add = this.formFields.collaborators.filter(obj => obj.type.title.toUpperCase() == this.selectedCollaboratorAdd.toUpperCase());
                    }
                    this.formFields.collaborators.filter(obj => {
                        let currentIndex = this.sendEmailToList.findIndex(obj_two => obj_two.id == obj.id)
                        if (currentIndex === -1 && obj.is_box_checked) {
                            this.sendEmailToList.push(obj)
                        }
                    if (currentIndex > -1  && (obj.is_box_checked == 0)) {
                            this.sendEmailToList.splice(currentIndex, 1)
                        }
                    })
                    if (this.selectedCollaboratorEmail == 'all')
                        sections.email = this.formFields.collaborators
                    else
                        sections.email = this.formFields.collaborators.filter(obj => obj.type.title.toUpperCase() == this.selectedCollaboratorEmail.toUpperCase());
                    return sections
                },
                collaborationImages() {
                    let list = {uploadedImages: [], rejectedImages: [], needApprovalImages: [], approvedImages: [], customerImages: []}
                    for (let img of this.formFields.images) {
                        if (img.approved_at) {
                            let customDate = new Date(img.approved_at);
                            img.custom_approved_at = customDate.toLocaleString('en-US', {
                                day: 'numeric',
                                year: 'numeric',
                                month: 'short',
                                hour: 'numeric',
                                minute: 'numeric',
                                second: 'numeric',
                            })
                        }
                        if (img.created_at) {
                            let customDate = new Date(img.created_at);
                            img.custom_created_at = customDate.toLocaleString('en-US', {
                                day: 'numeric',
                                year: 'numeric',
                                month: 'short',
                                hour: 'numeric',
                                minute: 'numeric',
                                second: 'numeric',
                            })
                        }
                        if (img.status == 'uploads' || img.status == 'installing area' || img.status == 'before pouring concrete'
                            || img.status == 'after pouring concrete' || img.status == 'finished installed' || img.status == 'damaged grave' || img.status == 'porcelain') {
                            list.uploadedImages.push(img)
                        } else if (img.status == 'need approval') {
                            this.$set(img, 'approval_needed', img.is_approval_check)
                            list.needApprovalImages.push(img)
                        } else if (img.status == 'approved') {
                            list.approvedImages.push(img)
                        } else if (img.status == 'customers') {
                            list.customerImages.push(img)
                        } else if (img.status == 'rejected') {
                            list.rejectedImages.push(img);
                        }
                    }
                    return list
                },
                checkMailSent() {
                    let mail_sent = false;
                    for (let img of this.formFields.images) {
                        if (img.status == 'need approval' && img.sent_mail != 0)
                            mail_sent = true
                    }
                    return mail_sent;
                },
                deptList: function () {
                    let options = [];
                    for (let opt of this.$store.state.department.recordList) {
                        if (opt.generic == 0) {
                            let obj = {value: opt.id, text: opt.title};
                            options.push(obj);
                        }
                    }
                    return options;
                },
                orderLogs() {
                    if (this.formFields.order_logs == null) {
                        this.formFields.order_logs = [
                            user = {}
                        ]
                    }
                    return this.formFields.order_logs
                },
            },
            created() {
                eventBus.$on(event.SAVE_COLLABORATION, this.storeCollaboration);
                eventBus.$on(event.FIRST_COLLABORATION_RECORD, this.first);
                eventBus.$on(event.LAST_COLLABORATION_RECORD, this.last);
                eventBus.$on(event.NEXT_COLLABORATION_RECORD, this.next);
                eventBus.$on(event.PREVIOUS_COLLABORATION_RECORD, this.prev);
                eventBus.$on(event.GET_COLLABORATION, this.getDropDownCollab);
                eventBus.$on(event.ADD_COLLABORATION, this.clearForm);
                eventBus.$on(event.DELETE_COLLABORATION, this.deleteRecord);
                eventBus.$on(event.UPLOAD_COLLABORATION_IMAGE, this.uploadImage);
            },
            destroyed() {
                eventBus.$off(event.SAVE_COLLABORATION);
                eventBus.$off(event.FIRST_COLLABORATION_RECORD);
                eventBus.$off(event.LAST_COLLABORATION_RECORD);
                eventBus.$off(event.NEXT_COLLABORATION_RECORD);
                eventBus.$off(event.PREVIOUS_COLLABORATION_RECORD);
                eventBus.$off(event.GET_COLLABORATION);
                eventBus.$off(event.ADD_COLLABORATION);
                eventBus.$off(event.DELETE_COLLABORATION);
                eventBus.$off(event.UPLOAD_COLLABORATION_IMAGE);
            },
            data() {
                return {
                    pageNumber: 1,
                    // storeID : this.$store.getters.getCurrentStoreID,
                    deleteCollaborationTasks: [],
                    deleteCorrespondenceTask: [],
                    deleteOrderLog: [],
                    formFields: {
                        // store_id: this.storeID,
                        id: 0,
                        mail_remainder_days: 0,
                        collaborator_mail: [],
                        collaborators: [],
                        images: [],
                        order_logs: [],
                    },
                    isOutline: true,
                    collaborator: {id: 0},
                    collaboratorTypes: [],
                    collaboratorsList: [],
                    sendToList: [],
                    sendEmailToList: [],
                    mailText: '',
                    uploadLink: false,
                    toastHider: false,
                    productsTableFields: [
                        {key: 'product_number', label: "Product #", class: 'text-center text-nowrap'},
                        {key: 'item_name', label: "Product Name", class: 'text-center'},
                        {key: 'quantity', label: "Qty", class: 'text-center'},
                        {key: 'client_price', label: "Client Price", class: 'text-nowrap'},
                        {key: 'amount', label: "Amount"},
                        {key: 'installation_price', label: "Install"},
                        {key: 'installation_amount', label: "Install Amount", thClass: 'text-nowrap'},
                        {key: 'total', label: "Total", class: 'text-center'},
                        {key: "showProducts", label: "Details"},
                    ],
                    collaboratorEmailFields: [
                        {key: 'date', label: 'Date'},
                        {key: 'sent_by', label: 'Sent By', class: 'text-center'},
                        {key: 'send_to', label: 'Send To', class: 'text-center'},
                        {key: 'content', label: 'Content'},
                        {key: 'attachment', label: 'Attachment'}
                    ],
                    approvedTableFields: [
                        {key: 'approved_at', label: "Approved", class: 'text-center'},
                        {key: 'approved_by', label: "By", class: 'text-center'},
                        {key: 'name', label: "File Name", class: 'text-center'},
                    ],
                    searchTerm: "",
                    statusList: [
                        {value: 'Complete', text: 'Complete', active: true},
                        {value: 'in_progress', text: 'In Progress', class: 'bf-red'},
                        {value: 'pending', text: 'Pending'},
                    ],
                    options: [
                        {item: 'A', name: 'Show All'},
                        {item: 'B', name: 'Customer'},
                        {item: 'D', name: 'Production'},
                        {item: 'E', name: 'Cemetery'},
                        {item: 'F', name: 'Vendors'}
                    ],
                    optionsRadio: [
                        {value: 'all', text: 'Show All'},
                        {value: 'customer', text: 'Customer'},
                        {value: 'production', text: 'Production'},
                        {value: 'cemetery', text: 'Cemetery'},
                        {value: 'vendors', text: 'Vendors'}
                    ],
                    axiosParams: {module: 'collaboration'},
                    axiosOrderStatusParams: {module: 'orderStatus'},
                    axiosCollaboratorParams: {module: 'collaboration', method: 'collaboratorTypes'},
                    saveDisabled: false,
                    visibleAddCollaborator: false,
                    visibleNewCollaborator: false,
                    visibleEmail: false,
                    visibleUploadFiles: false,
                    visibleOrderLog: false,
                    visibleApprovals: false,
                    visibleCustomerView: false,
                    selectedCollaboratorAdd: 'all',
                    selectedCollaboratorEmail: 'all',
                    customer_image: null,
                    customer_image_name: null,
                    customer_email: null,
                    customer_message: null,
                    docLwpPdfAiTypes: ['pdf', 'PDF', 'fs', 'FS', 'docx', 'DOCX', 'xlsx', 'xls', 'ai', 'lwp', 'eps'],
                }
            },
            metaInfo() {
                return {
                    title: `${this.formFields.id ? 'Edit' : 'Add'} Collaboration`,
                }
            },
            beforeCreate() {
                if (!this.$store.getters.isPermitted({resource: 'Collaboration', action: 'read'}))
                    this.$router.push('/access-denied');
            },
            mounted() {
                this.$store.state[this.axiosParams.module].busy = true
                // this.formFields.store_id = this.storeID
                this.formFields.id = this.$props.id ? this.$props.id : 0;
                if (!this.$store.getters.isPermitted({resource: 'Collaboration', action: 'update'}))
                    this.$props.hideInModal = true;
                this.getCollaboration(this.formFields.id);
                this.getColumns();
                this.getRecords();
                this.$store.getters.detectFormChanges();
            },
            methods: {
                /** CRUD */
                getDropDownCollab: function (id) {
                    this.axiosParams.id = id;
                    fetchRecord(this.axiosParams, (response) => {
                        if (response.data.order.products.length > 0)
                            this.$store.getters.changedCompositePrice(response.data.order.products);
                        if (response.data.order_logs.length > 0)
                            this.sortItemByDate(response.data.order_logs)
                        this.sortOneCollection(response.data);
                        this.formFields = response.data;
                        this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                        this.formFields.collaborators = response.data.collaborator_checks
                        this.showCompositeProductDetails();
                        this.$store.state[this.axiosParams.module].busy = false
                    })
                },
                /*collaboratorIsCheck(data) {
                    if (data.collaborator_check && data.collaborator_check.length > 0) {
                        return data.collaborator_check[0].is_check;
                    }
                    return false;
                },*/
                getCollaboration: function (id) {
                    if (id) {
                        this.axiosParams.id = id;
                        fetchRecord(this.axiosParams, (response) => {
                            if (response.data.order.products.length > 0)
                                this.$store.getters.changedCompositePrice(response.data.order.products);
                            if (response.data.order_logs.length > 0)
                                this.sortItemByDate(response.data.order_logs)
                            this.sortOneCollection(response.data);
                            this.formFields = response.data;
                            this.formFields.collaborators = response.data.collaborator_checks
                            this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                            this.showCompositeProductDetails();
                            if (this.$store.state[this.axiosParams.module].recordList.length > 0)
                                this.$store.state[this.axiosParams.module].busy = false
                        })
                        this.mailText = '';
                    }
                    if (this.$store.state.collaboration.departmentInfo.length == 0) {
                        this.$store.dispatch('getDepartmentInfo');
                        this.$store.state.department.busy = false;
                    }
                    if (this.$store.state.collaboration.paperLocationInfo.length == 0) {
                        this.$store.dispatch('getPaperLocationInfo');
                    }
                    this.$store.dispatch('getModuleInfo', this.axiosOrderStatusParams);
                },
                whoRejectedImage: function (data) {
                    let adminReject = null;
                    if (data) {
                        if (data.role)
                            data.role.title == 'Admin' ? adminReject = 'For Customer' : data.role.title == 'Customer' ? adminReject = 'From Customer' : '';
                        return adminReject;
                    } else {
                        return adminReject
                    }
                },
                async sortItemByDate(sortData) {
                    await sortData.sort((valueA, ValueB) => new Date(valueA.date) - new Date(ValueB.date))
                    // setTimeout(()=>{ sortData.sort((valueA, ValueB) => new Date(valueA.date) - new Date(ValueB.date))}, 500);
                },
                sortOneCollection: function (data) {
                    if (data.order && data.order.collaboration.tasks.length > 0) {
                        this.sortItemByDate(data.order.collaboration.tasks)
                    }
                    if (data.order && data.order.correspondence.tasks?.length > 0) {
                        this.sortItemByDate(data.order.correspondence.tasks)
                    }
                },
                showCompositeProductDetails() {
                    for (let item of this.formFields.order.products) {
                        item.iscompositeDetails = false;
                        if (item.composite && item.composite.length > 0)
                            if (item.composite[0].composite_products && item.composite[0].composite_products.length > 0) {
                                item.iscompositeDetails = true;
                                //this.$set(item, "_showDetails", !item._showDetails);
                            }
                    }
                },
                changeDateFormat: function (value) {
                    return this.$store.getters.changeDateFormat(value);
                },
                changeNumberFormat: function (value) {
                    return this.$store.getters.changeNumberFormat(value);
                },
                stopOutline() {
                    this.isOutline = false;
                },
                checkOrderStatus: function (id) {
                    let arg = {moveTo: this.orderStatusLabel(id)};
                    if (arg.moveTo == 'Waiting On Customer') {
                        this.addTask('collaboration', arg);
                    }
                },
                autoResizeWhoCorsp(data) {
                    if (data) {
                        return Number((data.length / 10));
                    }
                    return 1;
                },
                autoResizeFormCommunication(data) {
                    if (data) {
                        return Number((data.length / 14));
                    }
                    return 1;
                },
                autoResizeWhyContacted(data) {
                    if (data) {
                        return Number((data.length / 19));
                    }
                    return 1;
                },
                autoResizeCustomerReason(data) {
                    if (data) {
                        return Number((data.length / 33));
                    }
                    return 1;
                },
                autoResizeNotes(data) {
                    if (data) {
                        return Number((data.length / 31));
                    }
                    return 1;
                },
                autoResizeContactName(data) {
                    if (data) {
                        return Number((data.length / 11));
                    }
                    return 1;
                },
                storeCollaboration: function () {
                    this.saveDisabled = true;
                    let data = this.formFields;
                    let formData = new FormData();
                    formData.append('data', JSON.stringify(data));
                    formData.append('image_file', this.formFields.upload_image);
                    saveRecord(this.axiosParams, formData, (response) => {
                        if (response.data.errorInfo) {
                            let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                            this.makeToast({title: 'Error', message: message, variant: 'danger'});
                        } else {
                            this.formFields = response.data
                            this.formFields.collaborators = response.data.collaborator_checks
                            let message = `Record Successfully ${this.formFields.id ? 'Updated' : 'Added'}`;
                            this.makeToast({title: 'Success', message: message, variant: 'success'});
                            this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                            this.$store.getters.changedCompositePrice(this.formFields.order.products);
                            this.axiosParams.data =
                                {
                                    id: this.formFields.id,
                                    order: {
                                        id: this.formFields.order_id, installation: {id: this.formFields.order.installation.id, order_id: this.formFields.order_id},
                                        invoice: {invoice_number: this.formFields.order.invoice.invoice_number, order_id: this.formFields.order_id},
                                        production: {id: this.formFields.order.production.id, order_id: this.formFields.order_id}
                                    },
                                    order_id: this.formFields.order_id
                                };
                            this.$store.commit('appendOrUpdateDropDown', this.axiosParams)
                            this.$store.commit('appendOrUpdateInRecordList', {
                                module: 'order',
                                data: this.formFields.order
                            });
                        }
                    }, (error) => {
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                },
                deleteRecord: function (id) {
                    if (confirm("Do you really want to delete this record?")) {
                        this.axiosParams.id = id;
                        deleteRecord(this.axiosParams, (response) => {
                            if (response.data) {
                                this.$store.dispatch('removeRecordFromList', this.axiosParams);
                                if (this.$store.state[this.axiosParams.module].recordList.length == 0)
                                    this.clearForm();
                                else
                                    this.first()
                            } else {
                                console.log(response.data);
                            }
                        }, (error) => {
                                this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                        })
                    }
                },
                getColumns: function () {
                    if (this.$store.state[this.axiosParams.module].columnList.length == 0) {
                        this.$store.dispatch('getColumnList', this.axiosParams);
                    }
                },
                getRecords: function () {
                    if (!this.hideInModal)
                        this.$store.dispatch('getDropDownInfo', {module: this.axiosParams.module, apiURL: 'getDropDownRecord', page: this.pageNumber})
                    /*fetchRecords({module: 'collaboration/collaboratorTypes'}, (response) => {
                        this.collaboratorTypes = response.data.collaboratorType
                        this.collaboratorsList = response.data.collaborator
                        this.formFields.collaborators = this.collaboratorsList
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })*/
                    let formData = new FormData();
                    formData.append('collaboration_id', JSON.stringify(this.formFields.id));
                    this.axiosCollaboratorParams.filterData = formData;
                    compositeReportFilterRecord(this.axiosCollaboratorParams, (response) =>{
                        this.collaboratorTypes = response.data.collaboratorType
                        this.collaboratorsList = response.data.collaborator
                        this.formFields.collaborators = this.collaboratorsList
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    });
                },
                saveCollaborator: function () {
                    let data = this.collaborator;
                    if (!data.type_id) {
                        let message = ("Please select Collaborator Type");
                        this.makeToast({title: 'Error', message: message, variant: 'danger'});
                        return
                    }
                    // data.collaboration_id = this.formFields.id
                    let formData = new FormData();
                    formData.append('data', JSON.stringify(data));
                    saveRecord({module: 'collaboration/saveCollaborator'}, formData, (response) => {
                        if (response.data.errorInfo) {
                            let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                            this.makeToast({title: 'Error', message: message, variant: 'danger'});
                        } else {
                            let message = `Collaborator ${this.collaborator.id ? 'Updated' : 'Added'}`;
                            this.makeToast({title: 'Success', message: message, variant: 'success'});

                            let key = this.formFields.collaborators.findIndex(obj => obj.id == response.data.id)
                            if (key == -1)
                                this.formFields.collaborators.push(response.data)
                            else
                                this.$set(this.formFields.collaborators, key, response.data)
                            key = this.sendToList.findIndex(obj => obj.id == response.data.id)
                            if (key > -1) {
                                this.sendToList.splice(key, 1);
                                this.sendToList.push(response.data);
                            }
                            key = this.sendEmailToList.findIndex(obj => obj.id == response.data.id)
                            if (key > -1) {
                                this.sendEmailToList.splice(key, 1);
                                this.sendEmailToList.push(response.data);
                            }
                        }
                    }, (error) => {
                        const errorObject = error.response.data.errors;
                        const dynamicKey = Object.keys(errorObject)[0];
                        if (dynamicKey)
                            this.makeToast({title: 'Error', message: errorObject[dynamicKey][0], variant: 'danger', duration: 3000});
                    })
                },
                uploadImage: function () {
                    if (!this.formFields.id) {
                        this.storeCollaboration()
                        return
                    }
                    this.toastHider = true
                    this.makeToast({title: 'Uploading', message: "Uploading file", variant: 'success', duration: 5000});
                    let data = {collaboration: this.formFields.id, uploaded_from: this.formFields.uploadedFrom}
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
                            let message = 'File uploaded successfull';
                            this.makeToast({title: 'Success', message: message, variant: 'success'});
                            this.formFields.images.unshift(response.data);
                            this.pushOrderLog(response.data.order_logs)
                            if (this.formFields.uploadedFrom == 'customers') {
                                this.customer_message = 'File has been moved to customer view section';
                                this.customer_image = response.data.path;
                                this.customer_image_name = response.data.name;
                                this.sendCustomerViewMail();
                            }
                        }
                    })
                },
                pushOrderLog: function (data) {
                    for (let log of data) {
                        let index = this.formFields.order_logs.findIndex(obj => obj.id == log.id)
                        if (index == -1) {
                            this.formFields.order_logs.push(log)
                        }
                    }
                },
                saveImage: function (data, isInfo) {
                    let formData = new FormData();
                    formData.append('data', JSON.stringify(data));
                    saveRecord({module: 'collaboration/updateImage'}, formData, (response) => {
                        if (response.data.errorInfo) {
                            let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                            this.makeToast({title: 'Error', message: message, variant: 'danger'});
                        } else {
                            let message = 'Image Updated';
                            this.makeToast({title: 'Success', message: message, variant: 'success'});
                            this.pushOrderLog(response.data.order_logs)
                            if (!isInfo) {
                                data = response.data;
                                let index = this.formFields.images.findIndex(obj => obj.id == data.id);
                                this.formFields.images.splice(index, 1);
                                this.formFields.images.unshift(data);
                            }
                        }
                    })
                },
                openPreviewNewPage: function (url) {
                    window.open(url, '_blank');
                },
                handleDropdownChange: function(value){
                    window.detectChanges = true;
                },
                /**
                 * Related modules
                 * */
                addTask: function (type, arg = null) {
                    let date = new Date();
                    const [month, day, year] = [date.getMonth() + 1, date.getDate(), date.getFullYear()];
                    date = `${year}-${month}-${day}`
                    if (type == 'collaboration') {
                        if (arg && (arg.moveTo == 'need approval' || arg.moveTo == 'rejected' || arg.moveTo == 'Waiting On Customer')) {
                            let assigned_to = '';
                            if (this.sendEmailToList.length){
                                assigned_to = this.sendEmailToList[0].first_name+ ' '+this.sendEmailToList[0].last_name
                            }
                            let date = new Date();
                            const [month, day, year] = [date.getMonth() + 1, date.getDate(), date.getFullYear()];
                            date = `${year}-${month}-${day}`
                            let task = {
                                id: 0, date: date, close_date: null, assigned_to: assigned_to, task: 'A new file has been Uploaded for your review', created_by: this.$store.state['auth'].user.name ? this.$store.state['auth'].user.name : '',
                                status: '', department_id: this.order.department_id
                            };
                            this.order.collaboration.tasks.push(task);
                        } else {
                            this.order.collaboration.tasks.push({
                                id: 0, date: date, close_date: null, assigned_to: '', task: '', created_by: this.$store.state['auth'].user.name ? this.$store.state['auth'].user.name : '',
                                status: '', dept: '', currentIndex: this.order.collaboration.tasks.length
                            });

                        }

                    }
                    if (type == 'correspondence')
                        this.order.correspondence.tasks.push({
                            id: 0, date: date, close_date: null, assigned_to: '', task: '', created_by: '',
                            status: '', dept: '', currentIndex: this.order.correspondence.tasks.length
                        });
                },
                deleteTask: function (type) {
                    let taskList = type == 'collaboration' ? this.deleteCollaborationTasks : this.deleteCorrespondenceTask;
                    for (let task of taskList) {
                        if (task.id) {
                            deleteTask({id: task.id, module: type}, (response) => {
                                task.element.checked = false;
                                this.order[type].tasks = this.order[type].tasks.filter(obj => obj.id != task.id)
                            })
                        } else {
                            this.order[type].tasks = this.order[type].tasks.filter(obj => obj.currentIndex != task.taskKey)
                            task.taskContainer.remove()
                        }
                    }
                    taskList = [];
                    type == 'collaboration' ? this.deleteCollaborationTasks = [] : this.deleteCorrespondenceTask = [];
                },
                deleteLog: function () {
                    if (confirm("Do you really want to delete log!!!?")) {
                        for (let logs of this.deleteOrderLog) {
                            let data = {};
                            data.logToDelete = logs.id
                            data.collaboration = this.formFields.id;
                            let formData = new FormData();
                            formData.append('data', JSON.stringify(data));
                            updateRecord({module: this.axiosParams.module, apiURL: 'deleteOrderLog'}, formData, (response) => {
                                logs.element.checked = false
                                this.formFields.order_logs = this.formFields.order_logs.filter(obj => obj.id != logs.id)
                            })
                        }
                        this.deleteOrderLog = []
                    }
                },
                selectRow: function (params) {
                    let taskList = params.type == 'collaboration' ? this.deleteCollaborationTasks : this.deleteCorrespondenceTask;
                    let taskContainer = params.event.target.parentElement.parentElement;
                    if (params.event.currentTarget.checked) {
                        taskContainer.style.background = '#fff';
                        taskList.push({id: params.id, element: params.event.currentTarget, taskContainer: taskContainer, taskKey: params.currentKey})
                    } else {
                        let currentIndexVal = taskList.findIndex(obj => obj.id == params.id);
                        if (taskList[currentIndexVal]) {
                            taskList.splice(currentIndexVal, 1)
                        }
                        taskContainer.style.background = '#fff';
                    }
                },
                selectOrderLog: function (params) {
                    let taskContainer = params.event.target.parentElement.parentElement;
                    if (params.event.currentTarget.checked) {
                        taskContainer.style.background = '#fff';
                        this.deleteOrderLog.push({id: params.id, element: params.event.currentTarget, taskContainer: taskContainer, taskKey: params.currentKey})
                    } else {
                        let currentIndexVal = this.deleteOrderLog.findIndex(obj => obj.id == params.id);
                        if (this.deleteOrderLog[currentIndexVal]) {
                            this.deleteOrderLog.splice(currentIndexVal, 1)
                        }
                        taskContainer.style.background = '#fff';
                    }
                },
                downloadImage: function (src, imgName = null) {
                    src = '/' + src;
                    let a = document.createElement('a');
                    a.href = src;
                    let ext = src.substr(src.lastIndexOf('.') + 1);
                    a.download = imgName.includes('.') ? imgName : imgName + '.' + ext;
                    let mapObj = {
                        images: "",
                        collaboration: "",
                        _: ""
                    }
                    src = src.replace(/images|_|collaboration/gi, function (matched) {
                        return mapObj[matched];
                    });
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
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
                deleteFile: function (img) {
                    if (confirm("Do you really want to delete this file!!!?")) {
                        this.axiosParams.id = img.id;
                        this.axiosParams.method = '/deleteFile/';
                        deleteProductFile(this.axiosParams, (response) => {
                            if (response.data) {
                                this.formFields.order_logs.push(response.data)
                                let key = this.formFields.images.findIndex(obj => obj.id == img.id)
                                this.formFields.images.splice(key, 1);
                            } else {
                                this.makeToast({title: 'Error', message: response.data, variant: 'danger'});
                            }
                        })
                    }
                },
                moveFile: function (arg) {
                    this.formFields.images.filter(obj => obj == arg.img)[0].status = arg.moveTo
                    if (arg.moveTo == 'need approval') {
                        let userInfo = this.$store.state['auth'].user ? this.$store.state['auth'].user : null;
                        arg.img.moved_by = userInfo.name;
                        this.addTask('collaboration', arg);
                    }
                    if (arg.moveTo == 'approved') {
                        arg.img.user_id = this.$store.state['auth'].user.id ? this.$store.state['auth'].user.id : null;
                        arg.img.user = this.$store.state['auth'].user ? this.$store.state['auth'].user : null;
                        if (arg.img.rejected_by) {
                            arg.img.rejected_by = arg.img.rejected_by.id
                        }
                        const date = new Date();
                        const [month, day, year] = [date.getMonth(), date.getDate(), date.getFullYear()];
                        const [hour, minutes, seconds] = [date.getHours(), date.getMinutes(), date.getSeconds()];
                        arg.img.approved_at = `${year}-${month}-${day} ${hour}:${minutes}:${seconds}`
                    }
                    if (arg.moveTo == 'rejected') {
                        let userInfo = this.$store.state['auth'].user ? this.$store.state['auth'].user : null;
                        arg.img.moved_by = userInfo.name;
                        arg.img.rejected_by = userInfo.id;
                        this.addTask('collaboration', arg);
                    }
                    if (arg.moveTo == 'customers') {
                        this.customer_message = 'File has been moved to customer view section';
                        this.customer_image = arg.img.path;
                        this.customer_image_name = arg.img.name;
                        this.sendCustomerViewMail();
                    }
                    this.saveImage(arg.img, false);

                },
                toggleSendToList: function (checked, user) {
                    if (checked) {
                        this.sendToList.push(user);
                    } else {
                        let key = this.sendToList.findIndex(item => item == user)
                        this.sendToList.splice(key, 1)
                    }
                },
                toggleSendEmailToList: function (checked, user) {
                    if (checked) {
                        this.sendEmailToList.push(user);
                    } else {
                        let key = this.sendEmailToList.findIndex(item => item == user)
                        this.sendEmailToList.splice(key, 1)
                    }
                },
                sendMail: function () {

                    if (this.sendToList.length == 0) {
                        this.makeToast({title: 'Warning', message: "Please select a Collaborator", variant: 'warning'});
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
                    data.collaboration = this.formFields.id;
                    let formData = new FormData();
                    formData.append('data', JSON.stringify(data));
                    sendMail(this.axiosParams, formData, (response) => {
                        this.toastHider = false
                        this.$bvToast.hide('collaboration-toast')
                        if (response.data.status == 'sent') {
                            this.makeToast({title: 'Mail Sent', message: "Mail sent successfully", variant: 'success'});
                            this.formFields.collaborator_mail = response.data.totalRecords;
                            this.getCollaboration(this.formFields.id)
                        } else {
                            this.makeToast({title: 'Error', message: response.data, variant: 'danger', duration: 5000});
                        }
                    })
                },
                showCustomerViewMailPopup: function (image) {
                    this.customer_email = '';
                    for (let i = 0; i < this.sendEmailToList.length; i++)
                        if (this.sendEmailToList[i].email)
                            this.customer_email += this.sendEmailToList[i].email + ',';
                    this.customer_message = '';
                    this.customer_image = image.path;
                    this.customer_image_name = image.name;
                },
                isUnapprovedFiles: function () {
                    let is_unapproved_files = false;
                    for (let img of this.formFields.images) {
                        if (img.status == 'need approval')
                            is_unapproved_files = true
                    }
                    return is_unapproved_files;
                },
                sendApprovalMail: function () {
                    if (this.sendEmailToList.length == 0) {
                        this.makeToast({title: 'Warning', message: "Please Select a collaborator", variant: 'warning'});
                        return;
                    }
                    if (!this.isUnapprovedFiles()) {
                        this.makeToast({title: 'Warning', message: "No Unapproved File Listed", variant: 'warning'});
                        return;
                    }
                    for (let img of this.formFields.images) {
                        if (img.status == 'need approval') {
                            this.toastHider = true;
                            this.makeToast({title: 'Sending', message: "Sending mail...", variant: 'success'});
                            let sendTo = this.sendEmailToList;
                            let message = 'File has been moved to approval section needs approval';
                            let data = {};
                            data.sendTo = sendTo;
                            data.message = message;
                            data.link = img.path;
                            data.order = this.order.id;
                            data.collaboration = this.formFields.id;
                            let formData = new FormData();
                            formData.append('data', JSON.stringify(data));
                            sendApprovalMail(this.axiosParams, formData, (response) => {
                                this.toastHider = false;
                                this.$bvToast.hide('collaboration-toast')
                                if (response.data == 'sent') {
                                    this.makeToast({title: 'Mail Sent', message: "Mail sent successfully For File " + img.name, variant: 'success'});
                                    let imgData = img;
                                    imgData.sent_mail = 1;
                                    let formData = new FormData();
                                    formData.append('data', JSON.stringify(imgData));
                                    saveRecord({module: 'collaboration/updateImage'}, formData, (res) => {
                                        if (res.data.errorInfo) {
                                            //let message = (response.data.errorInfo[response.data.errorInfo.length - 1]);
                                            //this.makeToast({title: 'Error', message: message, variant: 'danger'});
                                        } else {
                                            data = res.data;
                                            let index = this.formFields.images.findIndex(obj => obj.id == data.id);
                                            this.formFields.images.splice(index, 1);
                                            this.formFields.images.unshift(data);
                                            this.getCollaboration(this.formFields.id)
                                        }
                                    })
                                } else {
                                    this.makeToast({title: 'Error', message: response.data, variant: 'danger', duration: 5000});
                                }
                            })
                        }
                    }
                },
                sendCustomerViewMail: function () {
                    if (this.sendEmailToList.length == 0) {
                        this.makeToast({title: 'Warning', message: "Please Select a Collaborator", variant: 'warning'});
                        return;
                    }
                    this.toastHider = true
                    this.makeToast({title: 'Sending', message: "Sending mail...", variant: 'success'});
                    let sendTo = this.sendEmailToList;
                    let message = this.customer_message;
                    let data = {};
                    data.sendTo = sendTo;
                    data.message = message;
                    data.link = this.customer_image;
                    data.order = this.order.id;
                    data.collaboration = this.formFields.id;
                    let formData = new FormData();
                    formData.append('data', JSON.stringify(data));
                    sendCustomerViewMail(this.axiosParams, formData, (response) => {
                        this.toastHider = false
                        this.$bvToast.hide('collaboration-toast')
                        if (response.data == 'sent')
                            this.makeToast({title: 'Mail Sent', message: "Mail sent successfully", variant: 'success'});
                        else
                            this.makeToast({title: 'Error', message: response.data, variant: 'danger', duration: 5000});
                    })
                },
                /** Pagination*/
                first: function () {
                    firstRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.sortItemByDate(response.data.order_logs)
                            this.sortOneCollection(response.data);
                            this.formFields = response.data;
                            this.formFields.collaborators = response.data.collaborator_checks
                            this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                            this.$store.getters.changedCompositePrice(this.formFields.order.products);
                            this.showCompositeProductDetails();
                        }
                        this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                },
                last: function () {
                    lastRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.sortItemByDate(response.data.order_logs)
                            this.sortOneCollection(response.data);
                            this.formFields = response.data;
                            this.formFields.collaborators = response.data.collaborator_checks
                            this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                            this.$store.getters.changedCompositePrice(this.formFields.order.products);
                            this.showCompositeProductDetails();
                        }
                        this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                },
                next: function (id) {
                    this.axiosParams.id = id;
                    nextRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.sortItemByDate(response.data.order_logs)
                            this.sortOneCollection(response.data);
                            this.formFields = response.data;
                            this.formFields.collaborators = response.data.collaborator_checks
                            this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                            this.$store.getters.changedCompositePrice(this.formFields.order.products);
                            this.showCompositeProductDetails();
                        }
                        this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                },
                prev: function (id) {
                    this.axiosParams.id = id;
                    previousRecord(this.axiosParams, (response) => {
                        if (Object.keys(response.data).length > 0) {
                            this.sortItemByDate(response.data.order_logs)
                            this.sortOneCollection(response.data);
                            this.formFields = response.data;
                            this.formFields.collaborators = response.data.collaborator_checks
                            this.$store.state[this.axiosParams.module].currentRecord = this.formFields
                            this.$store.getters.changedCompositePrice(this.formFields.order.products);
                            this.showCompositeProductDetails();
                        }
                        this.$store.state[this.axiosParams.module].busy = false
                    }, (error) => {
                        console.log(error)
                        this.makeToast({title: 'Error', message: error, variant: 'danger', duration: 3000});
                    })
                },

                /** Generic*/
                printPDF() {
                    eventBus.$emit(event.PRINT_PDF)
                },
                clearForm: function () {
                    if (window.detectChanges && !confirm('You have unsaved changes. Are you sure you want to navigate away?')) {
                        this.$store.state[this.axiosParams.module].busy = false
                    } else {
                        window.detectChanges = false;
                    }
                    if (!window.detectChanges) {
                        this.formFields = {
                            id: 0,
                            // store_id: this.storeID,
                            collaborators: [], images: []
                        };
                        this.$store.state[this.axiosParams.module].currentRecord = []
                    }
                },
                makeToast: function (params) {
                    this.$bvToast.toast(params.message, {
                        id: 'collaboration-toast',
                        title: params.title,
                        variant: params.variant,
                        toaster: 'b-toaster-top-center',
                        autoHideDelay: params.duration ? params.duration : 2000,
                        noAutoHide: this.toastHider,
                        noCloseButton: true,
                    })
                    this.saveDisabled = false;
                },
                customizeLabel: function (str) {
                    let i, labels = str.split('_');
                    for (i = 0; i < labels.length; i++) {
                        labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
                    }
                    return labels.join(' ');
                },
                getTaskStatusRow: function (params) {
                    let taskContainer3 = params.event.target.parentElement.parentElement;
                },
                paperLocationLabel: function (id) {
                    let option = 'Select';
                    for (let opt of this.$store.state.paperLocation.recordList) {
                        if (opt.id == id)
                            option = opt.location_title;
                    }
                    return option;
                },
                departmentLabel: function (id) {
                    let option = 'Select';
                    for (let opt of this.$store.state.department.recordList) {
                        if (opt.id == id)
                            option = opt.title;
                    }
                    return option;
                },
                orderStatusLabel: function (id) {
                    let option = 'select';
                    for (let opt of this.$store.state.orderStatus.recordList) {
                        if (opt.id == id) {
                            option = opt.title;
                        }
                    }
                    return option;
                },
                setValidDays: function (value) {
                    this.formFields.mail_remainder_days = (parseInt(value) < 1 || parseInt(value) > 30) ? this.formFields.mail_remainder_days = 1 : this.formFields.mail_remainder_days
                },
                toggleIcon: function (val) {
                    return val ? 'fa fa-angle-down' : 'fa fa-angle-right'
                },
                checkDate: function (date) {
                    return searchForEmptyDate(date);
                },
                closeDateChanged: function (closeDate, key) {
                    if (closeDate != '')
                        this.order.collaboration.tasks[key].status = 'Complete';
                    return this.checkDate(closeDate)
                },
                isApprovalNeeded: function (imag) {
                    imag.is_approval_check = imag.approval_needed
                    this.saveImage(imag, false);
                },
                neededApprovalMail: function (img) {
                    let currenIndex = this.formFields.collaborators.findIndex(obj => obj.is_custom === true);
                    if (this.formFields.collaborators[currenIndex] && this.formFields.collaborators[currenIndex].email) {
                        let sendTo = [];
                        sendTo.push(this.formFields.collaborators[currenIndex])
                        let message = 'File has been moved to approval section needs approval';
                        let data = {};
                        data.sendTo = sendTo;
                        data.message = message;
                        data.link = img.path;
                        data.redirect = false;
                        data.order = this.order.id;
                        data.collaboration = this.formFields.id;
                        let formData = new FormData();
                        formData.append('data', JSON.stringify(data));
                        sendApprovalMail(this.axiosParams, formData, (response) => {
                            if (response.data == 'sent') {
                                this.makeToast({title: 'Mail Sent', message: "Mail sent successfully For File " + img.name, variant: 'success'});
                            } else {
                                this.makeToast({title: 'Error', message: response.data, variant: 'danger', duration: 5000});
                            }
                        })
                    } else {
                        this.makeToast({title: 'Error', message: "Please add customer email to send mail", variant: 'danger'});
                    }
                },
                checkFileType: function (fileName) {
                    let ext = fileName.substr(fileName.lastIndexOf('.') + 1);
                    let fileIndex = this.docLwpPdfAiTypes.indexOf(ext);
                    if (fileIndex > -1) {
                        return true;
                    }
                    return false;
                },
                isAdmin() {
                    return this.$store.getters.isAdmin == 'Admin'
                },
            },
        }
    </script>

    <style scoped>
        .custom-margin {
            margin-top: -1.5rem;
            margin-left: -0.4rem;
            margin-bottom: -0.9rem;
        }

        .b-select-width {
            width: 13rem;
        }

        .paper-select-width {
            width: 16rem;
        }

        .heading-of-row {
            padding-left: 1rem;
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

        .custom-row div input, textarea {
            border: 1px solid #c4c4c4 !important;
            margin: auto;
            font-size: 0.75rem;
        }

        .custom-checkbox {
            line-height: 1.5rem;
            custom-border-radius: 0;
        }

        .order-form-btn {
            font-size: 0.5rem;
        }

        .label-price {
            width: 5.5rem;
        }

        .label-modal-price {
            width: 4.5rem;
        }

        .custom-image {
            width: 10vw;
        }

        .input-xxl {
            width: 18rem;
        }

        .input-xl {
            width: 13.5rem;
        }

        .input-xl-width {
            width: 12.5rem;
        }

        .input-lg {
            width: 13rem;
        }

        .input-md {
            width: 7rem;
        }

        .input-sm {
            width: 6.3rem;
        }

        .input-xs {
            width: 4.5rem;
        }

        .input-date {
            font-size: 0.75rem !important;
        }

        .border {
            border: 1px solid #c4c4c4 !important;
        }

        .div-border {
            border: 1px solid #686868 !important;
        }

        .custom-modal-margin {
            padding-top: 0.5rem;
            margin-right: -4rem;
            padding-left: 0rem;
            padding-bottom: .2rem;
            background-color: #e9ecef;
        }

        textarea:focus, input:focus {
            outline: none;
        }

        .product-image {
            width: 15rem;
            height: 10rem;
        }

        .custom-label {
            font-size: 10px;
        }

        .btn:focus, .btn:active {
            outline: none !important;
            box-shadow: none;
        }

        .edit-btn {
            font-size: 10px !important;
        }

        .edit-btn:hover {
            text-decoration: underline !important;
        }

        .btn-close {
            width: 20px;
            height: 22px;
            background-color: #000;
        }

        .wrap-text {
            width: 20rem !important;
            font-size: 12px !important;
        }

        .save-hover-bold:hover, .cancel-btn-hover-bold:hover {
            font-weight: bold;
        }

        .edit-btn-hover:hover {
            text-decoration: underline;
        }

        .hideEmailSection {
            display: none !important;
        }

        .showEmailSection {
            display: flex !important;
        }

        .customMarginUploaded {
            margin: 1px 0.5rem !important;
        }

        .customMarginUploadedFirst {
            margin: 0.9rem 0.5rem 0 0.5rem !important;
        }

        .custom-row div table label.d-flex.mail-content-white-space {
            white-space: initial !important;
        }

        .custom-row .task-collaboration-date {
            padding-left: 5px;
        }

        .custom-row .task-collaboration-closedate, .custom-row .task-collaboration-date {
            min-width: 8.5rem;
            display: block;
        }

        .custom-row .collaboration-task-block {
            display: block;
        }

        .custom-row .collaboration-dept-width {
            min-width: 10rem;
        }

        .collaboration-form-communication {
            min-width: 11rem;
        }

        .custom-row div .margin-left-neg {
            margin-left: -6px;
        }

        select {
            border: 1px solid #c4c4c4 !important;
            margin: auto;
            font-size: 0.75rem;
        }

        .dept-select-width {
            width: 10rem;
        }

        .textarea-overflow {
            overflow: hidden;
        }

        .correspondence-checkbox {
            position: relative;
            top: 17px;
            left: -12px;
        }

        .correspondence-row {
            left: 15px;
            position: relative;
        }

        .correspondence-date {
            min-height: 44px;
            padding: 9px;
        }

        .custom-minwidth-47 {
            min-width: 47.5rem;
        }

        .custom-minwidth-45 {
            min-width: 45.5rem;
        }

        /*::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            -webkit-border-radius: 6px;
            border-radius: 6px;
        }
        ::-webkit-scrollbar-thumb {
            -webkit-border-radius: 6px;
            border-radius: 6px;
            !*background: rgba(255, 38, 0, 0.8);*!
            background: white;
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
        }
        ::-webkit-scrollbar-thumb:window-inactive {
            !*background: rgba(255,0,0,0.4);*!
            background: white;
            !*background: #007BFF;*!
        }*/

    </style>



