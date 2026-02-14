<template>
    <div>
        <h5 class="mx-2 my-1 custom-view-heading">Customer Portal</h5>
        <div class="bg-toolbar my-2 p-1">
            <Toolbar :customerName="customerName"></Toolbar>
        </div>
        <div>
            <Button :collaboration="true"></Button>
        </div>
        <hr class="my-3">

        <b-form inline class="div-shadow bg-white rounded mx-2 mb-2">
            <div class="d-flex justify-content-center title-style col-md-12 my-2">
                COLLABORATION
            </div>

                <label class="mr-sm-2 ml-2" for="inline-form-input-order_status" >Order Status</label>
                <b-form-input id="inline-form-input-order_status" size="sm" :value="order.order_status != null ? customizeLabel(order.order_status.title) : '' " class="mb-2 mr-sm-2 mb-sm-0 col-md-1 mx-1" readonly></b-form-input>

                <label class="mr-sm-2 ml-2" for="inline-form-input-paper_location" >Paper Location</label>
                <b-form-input id="inline-form-input-paper_location" size="sm" :value="order.paper_location != null ? customizeLabel(order.paper_location.title) : '' " class="mb-2 mr-sm-2 mb-sm-0 col-md-3 mx-1" readonly></b-form-input>

                <label class="mr-sm-2 ml-2" for="inline-form-input-order_on_hand" >Order On Hold</label>
                <b-form-input id="inline-form-input-order_on_hand" size="sm" :value="order.on_hold" class="mb-2 mr-sm-2 mb-sm-0 col-md-1 mx-1" readonly></b-form-input>

                <label class="mr-sm-2 ml-2" for="inline-form-input-description" >Order On Hold Description</label>
                <b-form-input id="inline-form-input-description" size="sm" :value="order.on_hold_description" class="mb-2 mr-sm-2 mb-sm-0 col-md-3 mx-1" readonly></b-form-input>

            <div class="row row-width-media mt-2">
                <div class="col-md-6 px-4">
                    <div class="div-shadow bg-white rounded">
                        <div class="">
                            <div class="bg-toolbar mt-4 px-3">
                                <b-form-group class="mb-0 custom-radio-and-checkbox" :disabled="hideInModal">
                                    <b-form-radio-group v-model="selectedCollaboratorAdd">
                                        <b-form-radio value="all">Show All</b-form-radio>
                                        <b-form-radio value="customer">Customer</b-form-radio>
                                        <b-form-radio value="production">Production</b-form-radio>
                                        <b-form-radio value="cemetery">Cemetery</b-form-radio>
                                        <b-form-radio value="vendor">Vendors</b-form-radio>
                                        <b-form-radio value="design">Design</b-form-radio>
                                    </b-form-radio-group>
                                </b-form-group>
                            </div>
                            <div class="flex-column" height="1850px">
                                <!--<div class="flex-column mt-2 mx-2">
                                    <b-button
                                        :class="visibleAddCollaborator ? 'btn-sm bg-white text-dark py-0 text-left border' : 'btn-sm py-0 bg-white text-dark text-left border collapsed'"
                                        :aria-expanded="visibleAddCollaborator ? 'true' : 'false'"
                                        aria-controls="collapse-collaborator"
                                        :disabled="hideInModal"
                                        @click="visibleAddCollaborator = !visibleAddCollaborator">
                                        <i :class="toggleIcon(visibleAddCollaborator)"> </i> Click to Add
                                        Collaborators
                                    </b-button>
                                    <b-collapse id="collapse-collaborator" v-model="visibleAddCollaborator"
                                                class="border">
                                        <div class="flex-column flex-grow-1">
                                            <div class="d-block">
                                                <template v-for="item of collaboratorList.add">
                                                    <div class="d-flex">
                                                        <b-form-checkbox class="mx-2" :value=item v-model="sendEmailToList" ><b  v-b-tooltip.hover :title="`${item.type.title}`">{{item.type.title.charAt(0)}}</b> - {{item.first_name}}  {{item.last_name ? `${item.last_name}` : "" }} {{item.email ? `| ${item.email}` : "" }}
                                                        </b-form-checkbox>

                                                        <button type="button"
                                                                class="btn btn-sm p-0 font-italic edit-btn ml-n1 mt-0"
                                                                @click="collaborator = {...item}, visibleNewCollaborator = true"
                                                                aria-expanded="true"
                                                                aria-controls="collapse-new-collaborator">(edit)
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>

                                            <div class="bg-toolbar">
                                                <b-button
                                                    :class="visibleNewCollaborator ? 'btn-sm list-toolbar py-0 border-0 text-left flex-grow-1' : 'btn-sm list-toolbar py-0 border-0 text-left flex-grow-1 collapsed'"
                                                    :aria-expanded="visibleNewCollaborator ? 'true' : 'false'"
                                                    aria-controls="collapse-new-collaborator"
                                                    @click="visibleNewCollaborator = !visibleNewCollaborator, collaborator = {id:0}">
                                                    <i :class="toggleIcon(visibleNewCollaborator)"> </i> Click to
                                                    add New Collaborator
                                                </b-button>
                                            </div>
                                            <b-collapse id="collapse-new-collaborator" v-model="visibleNewCollaborator" class="mt-2 mx-n4">
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
                                                            <b-form-input type="text" class="margin-left-neg"
                                                                          v-model="collaborator.phone"></b-form-input>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="col-3">Type</label>
                                                            <b-dropdown no-caret
                                                                        class="border rounded flex-grow-1 input-lg dropdown-width"
                                                                        size="sm" variant="none"
                                                                        :disabled="hideInModal">

                                                                <template #button-content>
                                                                    <div class="d-flex">
                                                                        <small>{{ collaborator.type_id ?
                                                                            collaboratorTypeList.filter(obj =>
                                                                            obj.value == collaborator.type_id)[0].text : 'Select'
                                                                            }}
                                                                        </small>
                                                                        <i class="fa fa-caret-down ml-auto"
                                                                           aria-hidden="true"></i>
                                                                    </div>
                                                                </template>

                                                                <b-dropdown-group class="overflow-auto px-1">
                                                                    <template v-for="obj of collaboratorTypeList">
                                                                        <b-dropdown-group>
                                                                            <b-dropdown-item-button class="small"
                                                                                                    @click="collaborator.type_id = obj.value">
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
                                                            <button type="button"
                                                                    class="btn-info mx-1 custom-infobtn-toolbar custom-infobtn-text"
                                                                    @click="saveCollaborator">Save
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </b-collapse>

                                        </div>
                                    </b-collapse>
                                </div>-->
                                <div :class="visibleAddCollaborator ? 'showEmailSection' : 'hideEmailSection'" class="justify-content-center height-200">
                                    <h2 class="mt-5">E-mails</h2>
                                </div>

                                <div :class="visibleAddCollaborator ? 'hideEmailSection' : 'showEmailSection'"  class="mt-2 mx-2">
                                    <b-table responsive bordered small
                                             class="small"
                                             :items="formFields.collaborator_mail"
                                             :fields="collaboratorEmailFields">

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
                </div>
                <div class="col-md-6">

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <h6 class="m-0 custom-form-heading ml-2">Order Form</h6>
                        </div>
                        <div class="col-md-6 px-4 div-column-display">
                            <label class="mr-sm-2 text-nowrap" for="inline-form-input-date_promised" >Date Promised</label>
                            <b-form-input id="inline-form-input-date_promised" size="sm" :value="order.invoice.date_promised = changeDateFormat(order.invoice.date_promised)" class="mb-2 mr-sm-2 mb-sm-0 w-100" readonly></b-form-input>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12 px-4 div-column-display">
                            <label class="mr-sm-2 text-nowrap" for="inline-form-input-order-date" >Order Date</label>
                            <b-form-input id="inline-form-input-order-date" size="sm" :value="changeDateFormat(order.date)" class="mb-2 mr-sm-2 mb-sm-0 w-100" readonly></b-form-input>

                            <label class="mr-sm-2 text-nowrap" for="inline-form-input-invoice" >Invoice #</label>
                            <b-form-input id="inline-form-input-invoice" size="sm" :value="order.invoice.invoice_number" class="mb-2 mr-sm-2 mb-sm-0 w-15" readonly></b-form-input>

                            <label class="mr-sm-2 text-nowrap" for="inline-form-input-email" >Email</label>
                            <b-form-input id="inline-form-input-email" size="sm" :value="order.family.email" class="mb-2 mr-sm-2 mb-sm-0 w-100" readonly></b-form-input>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h6 class="m-0 custom-form-heading ml-2">Store Location Info.</h6>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12 px-4 div-column-display">
                            <label class="mr-sm-2 text-nowrap" for="inline-form-input-stores" >Stores</label>
                            <b-form-input id="inline-form-input-stores" size="sm" :value="order.company.name" class="mb-2 mr-sm-2 mb-sm-0 w-100" readonly></b-form-input>

                            <label class="mr-sm-2 text-nowrap" for="inline-form-input-sale-person" >Salesperson</label>
                            <b-form-input id="inline-form-input-sale-person" size="sm" :value="order.sales_person" class="mb-2 mr-sm-2 mb-sm-0 w-100" readonly></b-form-input>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h6 class="m-0 custom-form-heading ml-2">Family Information</h6>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12 px-4 div-column-display">
                            <label class="mr-sm-2 text-nowrap" for="inline-form-input-last-name-stone" >Last Name On Stone</label>
                            <b-form-input id="inline-form-input-last-name-stone" size="sm" :value="order.family.name_on_stone" class="mb-2 mr-sm-2 mb-sm-0 w-100" readonly></b-form-input>

                            <label class="mr-sm-2 text-nowrap" for="inline-form-input-customer-contact" >Customer Contact</label>
                            <b-form-input id="inline-form-input-customer-contact" size="sm" :value="order.family.contact" class="mb-2 mr-sm-2 mb-sm-0 w-15" readonly></b-form-input>

                            <label class="mr-sm-2 text-nowrap" for="inline-form-input-phone" >Phone</label>
                            <b-form-input id="inline-form-input-phone" size="sm" :value="order.family.phone" class="mb-2 mr-sm-2 mb-sm-0 w-15" readonly></b-form-input>
                        </div>
                    </div>
            <!-- this code will work on desktop and laptop screens -->
                    <div class="row mt-2 showHide-div-large">
                        <div class="col-md-12 px-4">
                            <ProductTable :productsTableFields="productsTableFields" :id="formFields.id"></ProductTable>
                        </div>
                    </div>

                </div>
            </div>
            <!-- this part of code will work only on mobile screens -->
            <div class="row mt-2 product-table-row-width showHide-div-mobile">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <div class="row mt-2 px-2">
                        <div class="col-md-12">
                            <ProductTable :productsTableFields="productsTableFields" :id="formFields.id"></ProductTable>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-width-media mt-2">
                <div class="col-md-1 px-4 mb-1">
                    <label class="justify-content-lg-start">Approvals</label>
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
                        <div class="flex-grow-1 border rounded bg-white">
                            <div class="px-1 pb-1">

                                <div class="p-0 my-2 py-1 div-border" v-for="(img, key) of collaborationImages.needApprovalImages">
                                    <div>
                                        <div class="flex-column flex-grow-1 text-center d-flex margin-bottom-zero">
                                            <label class="font-weight-bold">Unviewed by customer</label>
                                            <label class="text-info">Email {{img.sent_mail == 0 ? 'not sent':'sent'}}  to collaborator(s)</label>
                                            <label class="text-info">Moved by {{img.moved_by }}</label>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="mx-2">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img class="h-100 w-100 mx-1 border p-1 rounded my-1 custom-image"  :src="`/${img.path}`"/>
                                                </div>
                                                <div class="mt-1 col-md-4 line-height">
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
                                                <div class="col-md-4">
                                                    <div v-if="img.status == 'need approval'" class="">
                                                        <button type="button" class="btn-info w-100 my-1 custom-infobtn-toolbar custom-infobtn-text" @click="moveFile({moveTo:'approved', img:img})">Accept as Customer</button>
                                                        <button type="button" class="btn-info w-100 my-1 custom-infobtn-toolbar custom-infobtn-text" @click="">Reject as Customer</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex-wrap">
                                                <div v-if="!hideInModal" class="flex-column" >
                                                    <label class="font-weight-bold">Rendering notes for customer:</label>
                                                    <label v-if="img.notes" class="custom-label customMarginUploaded">{{img.notes}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-0 my-2 py-1 div-border" v-for="(img, key) of collaborationImages.approvedImages">
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
                <div class="col-md-6">

                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="m-0 custom-form-heading ml-2">Notes</h6>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12 px-4">
                            <b-form-textarea
                                disabled
                                rows="3"
                                class="w-100"
                                v-model="formFields.notes"
                                size="sm"
                                no-resize
                            ></b-form-textarea>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row row-width-media mt-2">

                <div class="col-md-1 px-4 mb-1">
                    <label class="justify-content-lg-start text-nowrap">Customer View</label>
                </div>

                <div class="col-md-5 px-4 mb-1">
                    <b-button
                        :class="visibleCustomerView ? 'btn btn-sm bg-white text-dark text-left border w-100' : 'w-100 btn btn-sm bg-white text-dark text-left border collapsed'"
                        :aria-expanded="visibleCustomerView ? 'true' : 'false'"
                        aria-controls="collapse-customer-view"
                        @click="visibleCustomerView = !visibleCustomerView">
                        <i :class="toggleIcon(visibleCustomerView)"> </i> Click here to open or close
                        customer view section
                    </b-button>
                    <b-collapse id="collapse-customer-view" v-model="visibleCustomerView">
                        <div class="flex-grow-1 border rounded bg-white px-0">
                            <div class="px-1 pb-1">
                                <div class="p-0 my-2 div-border py-2"
                                     v-for="(img, key) of collaborationImages.customerImages">
                                    <div class="mx-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="h-100 w-100 mx-1 border p-1 rounded my-1 custom-image" :src="`/${img.path}`"/>
                                        </div>
                                        <div class="mt-1 col-md-4 line-height">
                                            <label class="font-weight-bold custom-label">{{ img.name.length > 20 ? img.name.substring(0,20)+'...' : img.name }}</label>
                                            <label class="text-info custom-label">{{ img.size }}</label>
                                            <label class="text-info custom-label">{{ img.custom_created_at }}</label>
                                            <div>
                                                <button  type="button" class="btn btn-sm my-1 bg-white"
                                                         @click="printImage(img.path); return false;"><i
                                                    class="fa fa-print fa-lg"> </i></button>
                                                <button type="button" class="btn btn-sm my-1 bg-white ml-n2"
                                                        @click="downloadImage(img.path)"><i
                                                    class="fa fa-arrow-circle-down fa-lg"> </i></button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn-info mx-1 my-1 custom-infobtn-toolbar custom-infobtn-text mt-5 w-100" @click="deleteFile(img)">Remove File</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </b-collapse>

                </div>

            </div>

            <div class="row mt-2 d-block ml-0 div-shadow w-100 rounded pb-2">

                    <div class="col-md-12 ml-n2">
                            <h6 class="my-2 custom-form-heading">Task Collaboration</h6>
                    </div>

                    <div v-if="!hideInModal" class="col-md-12 row-width-media bg-primary">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-sm list-toolbar m-1 border-0"
                                >Add Task
                                </button>
                                <button type="button" class="btn btn-sm list-toolbar m-1 border-0"
                                >
                                    Delete Task
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <b-table small responsive borderless
                                     class="table-font-size"
                                     thead-class=""
                                     :items="order.collaboration.tasks"
                                     :fields="taskCollaborationFields" show-empty>

                                <template #empty="scope">
                                    No Record
                                </template>

                                <template #head(date)="data">
                                    <span class="task-table-heading">{{data.label}}</span>
                                </template>

                                <template #head(assigned_to)="data">
                                    <span class="task-table-heading">{{data.label}}</span>
                                </template>

                                <template #head(task)="data">
                                    <span class="task-table-heading">{{data.label}}</span>
                                </template>

                                <template #head(department_id)="data">
                                    <span class="task-table-heading">{{data.label}}</span>
                                </template>

                                <template #head(created_by)="data">
                                    <span class="task-table-heading">{{data.label}}</span>
                                </template>

                                <template #head(close_date)="data">
                                    <span class="task-table-heading">{{data.label}}</span>
                                </template>

                                <template #head(status)="data">
                                    <span class="task-table-heading">{{data.label}}</span>
                                </template>

                                <template v-slot:cell(date)="row">
                                    <label class="justify-content-lg-start w-100 border border-radius product-table">
                                        <span v-if="row.item.date" class="ml-1 mr-1 p-1">{{ changeDateFormat(row.item.date) }}</span>
                                        <span v-else class="ml-1 mr-1 p-1 span-visibilty-none">here</span>
                                    </label>
                                </template>

                                <template v-slot:cell(assigned_to)="row">
                                    <label class="justify-content-lg-start w-100 border border-radius product-table">
                                        <span v-if="row.item.assigned_to" class="ml-1 mr-1 p-1">{{ row.item.assigned_to }}</span>
                                        <span v-else class="ml-1 mr-1 p-1 span-visibilty-none">here</span>
                                    </label>
                                </template>

                                <template v-slot:cell(task)="row">
                                    <label class="justify-content-lg-start w-100 border border-radius product-table">
                                        <span  v-if="row.item.task" class="ml-1 mr-1 p-1">{{ row.item.task }}</span>
                                        <span  v-else class="ml-1 mr-1 p-1 span-visibilty-none">here</span>
                                    </label>
                                </template>

                                <template v-slot:cell(department_id)="row">
                                    <label class="justify-content-lg-start w-100 border border-radius product-table">
                                        <span v-if="row.item.department_id" class="ml-1 mr-1 p-1">{{
                                            row.item.department_id ? row.item.department.title : '' }}</span>
                                        <span v-else class="ml-1 mr-1 p-1 span-visibilty-none">here</span>
                                    </label>
                                </template>

                                <template v-slot:cell(created_by)="row">
                                    <label class="justify-content-lg-start w-100 border border-radius product-table">
                                        <span v-if="row.item.created_by" class="ml-1 mr-1 p-1">{{ row.item.created_by }}</span>
                                        <span v-else class="ml-1 mr-1 p-1 span-visibilty-none">here</span>
                                    </label>
                                </template>

                                <template v-slot:cell(close_date)="row">
                                    <label class="justify-content-lg-start w-100 border border-radius product-table">
                                        <span v-if="row.item.close_date" class="ml-1 mr-1 p-1">{{ changeDateFormat(row.item.close_date) }}</span>
                                        <span v-else class="ml-1 mr-1 p-1 span-visibilty-none">here</span>
                                    </label>
                                </template>

                                <template v-slot:cell(status)="row">
                                    <label class="justify-content-lg-start w-100 border border-radius product-table">
                                        <span v-if="row.item.status" class="ml-1 mr-1 p-1">{{ customizeLabel(row.item.status) }}</span>
                                        <span v-else class="ml-1 mr-1 p-1 span-visibilty-none">here</span>
                                    </label>
                                </template>

                            </b-table>
                        </div>
                    </div>
            </div>

        </b-form>
    </div>
</template>

<script>
    import Button from '../customer-dashboard/Button';
    import Toolbar from '../customer-dashboard/Toolbar';
    import ProductTable from "./ProductTable";
    import {fetchRecord, saveRecord} from "../../helpers/axios";
    import {searchForEmptyDate} from "../../helpers/common";

    export default {
        name: "Collaboration",
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
                visibleAddCollaborator: false,
                visibleNewCollaborator: false,
                visibleCustomerView: false,
                visibleEmail: false,
                axiosParams: {module: 'customerCollaboration'},
                axiosCollaborationParams: {module: 'customerCollaboration/collaboration'},
                hideInModal: false,
                selectedCollaboratorAdd: 'all',
                selectedCollaboratorEmail: 'all',
                collaboratorEmailFields: [
                    {key: 'date', label: 'Date'},
                    {key: 'sent_by', label: 'Sent By', class: 'text-center text-nowrap'},
                    {key: 'send_to', label: 'Send To', class: 'text-center text-nowrap'},
                    {key: 'content', label: 'Content'},
                    {key: 'attachment', label: 'Attachment'}
                ],
                productsTableFields: [
                    {key: 'product_number', label: "Product #", thClass: 'text-center text-nowrap'},
                    {key: 'item_name', label: "Product Name", thClass: 'text-center text-nowrap'},
                    {key: 'quantity', label: "Qty", thClass: 'text-center'},
                    {key: 'client_price', label: "Client Price", thClass:'text-nowrap'},
                    {key: 'amount', label: "Amount"},
                    {key: 'installation_price', label: "Install"},
                    {key: 'installation_amount', label: "Install Amount", thClass: 'text-nowrap'},
                    {key: 'total', label: "Total", class: 'text-nowrap'},
                    {key: "showProducts", label: "Details"},
                ],
                taskCollaborationFields: [
                    {key: 'date', label: 'Date', tdClass: 'text-nowrap' },
                    {key: 'assigned_to', label: 'Assigned To', thClass: 'text-nowrap' },
                    {key: 'task', label: 'Task', tdClass: 'text-nowrap' },
                    {key: 'department_id', label: 'Dept', tdClass: 'text-nowrap' },
                    {key: 'created_by', label: 'Created By', thClass: 'text-nowrap', tdClass: 'text-nowrap'},
                    {key: 'close_date', label: 'Close Date', thClass: 'text-nowrap', tdClass: 'text-nowrap' },
                    {key: 'status', label: 'Task Status', thClass: 'text-nowrap', tdClass: 'text-nowrap' },
                ],
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
            order() {
                if (this.formFields.order == null) {
                    this.formFields.order = {
                        invoice: {}, order_status:{}, paper_location:{}, company: {}, family: {}, products: [], collaboration: {tasks: []},
                        correspondence: {tasks: []}
                    };
                }
                if (this.formFields.order){
                    let customDate = new Date(this.formFields.order.date);
                    this.formFields.order.customDate = customDate.toLocaleString('en-US',{
                        day: 'numeric',
                        year: 'numeric',
                        month: 'long',
                        hour: 'numeric',
                        minute: 'numeric',
                        second: 'numeric',
                    })
                }
                if (this.formFields.order.collaboration.tasks.length > 0){
                    this.getCurrentUserTask(this.formFields.order.collaboration.tasks)
                }
                return this.formFields.order
            },
        },
        components:{
            Toolbar,
            Button,
            ProductTable,
        },
        mounted(){
            this.formFields.id = this.$props.id ? this.$props.id : 0;
            this.getCollaboration(this.formFields.id);
            this.getRecordList();
        },
        methods:{
            getCollaboration: function(id){
                if (id) {
                    let record = Object.values(this.$store.state[this.axiosParams.module].recordList).find(obj => obj.id == id);
                    if (record != undefined) {
                        this.formFields = {...record};
                    } else {
                        this.axiosCollaborationParams.id = id;
                        fetchRecord(this.axiosCollaborationParams, (response) => {
                            this.formFields = response.data;
                        })
                    }
                }
            },
            getCurrentUserTask: function(tasks) {
                let defaultCustomer = {
                    is_custom:true,
                    collaboration_id: this.$props.id ? this.$props.id : 0,
                    email:this.formFields.order.family.email,
                    first_name:this.formFields.order.family.name_on_stone,
                    last_name: '',
                    phone:this.formFields.order.family.phone,
                    type:{title:"Customer"}
                }
                if (this.formFields.collaborators.findIndex(obj => obj.is_custom) === -1) this.formFields.collaborators.push(defaultCustomer);
                let collaborator = this.formFields.collaborators;
                tasks = tasks.filter(obj =>{
                   let assignedTo = obj.assigned_to;
                    let key = collaborator.findIndex(obj => obj.email == assignedTo)
                   if (key != -1 && collaborator[key].type.title == 'Customer'){
                       return tasks;
                   }
                });
                this.sortItemByDate(tasks)
                this.formFields.order.collaboration.tasks = tasks
            },
            getRecordList: function () {
                if (this.$store.state[this.axiosParams.module].recordList.length == 0){
                    this.axiosParams.methodName = 'collaborationInfo';
                    this.$store.dispatch('getCustomerPortalInfo', this.axiosParams);
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
            changeDateFormat: function(value){
                return this.$store.getters.changeDateFormat(value);
            },
            customizeLabel: function (str) {
                if (str){
                    let i, labels = str.split('_');
                    for (i=0; i < labels.length; i++) {
                        labels[i] = labels[i].charAt(0).toUpperCase() + labels[i].slice(1);
                    }
                    return labels.join(' ');
                }
            },
            async sortItemByDate(sortData) {
                await sortData.sort((valueA, ValueB) => new Date(valueA.date) - new Date(ValueB.date))
            },

        },
    }
</script>

<style scoped>
    .btn:focus, .btn:active {
        outline: none !important;
        box-shadow: none;
    }
    textarea:focus, input:focus {
        outline: none;
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
    .row-width-media {
        width: 100%;
    }
    .hideEmailSection{
        display: none !important;
    }
    .showEmailSection{
        display: flex !important;
    }
    .div-column-display{
        display: flex;
    }
    input{
        font-size: 0.75rem;
    }
    .product-table-row-width{
        width: 100%;
    }
    .showHide-div-large{
        display: block;
    }
    .showHide-div-mobile{
        display: none;
    }
    .border {
        border: 1px solid #c4c4c4 !important;
    }
    .border-radius{
        border-radius: 0.2rem;
    }
    .task-table-heading {
        font-size: 12px;
        font-weight: 400;
    }
    .span-visibilty-none{
        visibility: hidden;
    }
    @media (max-width: 576px)
    {
        .row-width-media {
            width: auto;
        }
        .div-column-display{
            display: block;
        }
        .product-table-row-width{
            width: 109%;
        }
        .showHide-div-large{
            display: none;
        }
        .showHide-div-mobile{
            display: block;
        }
    }
</style>
