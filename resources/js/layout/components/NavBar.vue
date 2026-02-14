<template>
    <div class="wrapper">
        <b-navbar toggleable="md" type="dark" variant="secondary" style="justify-content: unset;">
            <router-link class="custom-navbar-brand mr-2" exact to="/">Monument</router-link>
            <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
            <b-collapse id="nav_collapse" is-nav>
                <b-navbar-nav>
                    <router-link active-link="active" class="nav-link" to="/dashboard" v-if="isDashboardPermitted">Home</router-link>
                    <li class="nav-item dropdown" v-if="isUserPermitted">
                        <a aria-expanded="true" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"> <span class="nav-label ">Users</span> <span
                        ></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu" v-if="!isSupperAdmin">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/company-list">Company Info.</router-link>
                            </li>
                            <li class="dropdown-submenu" v-if="isAdmin">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/roles-list">Role Management</router-link>
                            </li>
                            <li class="dropdown-submenu" v-if="isAdmin">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/customer-portal">Customer Portal</router-link>
                            </li>
                            <li class="dropdown-submenu" v-if="isAdmin">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/user-list">Users Info</router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown" v-if="isQuotesPermitted">
                        <a aria-expanded="true" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"> <span class="nav-label">Quotes</span> <span
                        ></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/quote-list">Quotes List</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link :key="componentId" :to="{name: 'PriceEstimator'}"
                                             class="dropdown-item custom-navbar-dropdown" exact>Price Estimator
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown" v-if="isOrdersPermitted">
                        <a aria-expanded="true" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"> <span class="nav-label">Orders</span> <span
                        ></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/order-list">Order List</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link @click.native.capture.stop aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle custom-navbar-dropdown" data-toggle="dropdown" to="#">Printable Forms</router-link>
                                <ul class="dropdown-menu">
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-monument-agreement">Monument Agreement</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/installation-printable-form">Installation Form</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-final-date">Final Date Request Form</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-monument-work-order">Work Order Form</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-porcelain">Porcelain Form</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-monument-order-notes">Monument Order Notes</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/brick-printable-form">Brick Form</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-delivery-work-order">Delivery-Work Order Form</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-memorial-production">Memorial Production Form</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/granit-bronz-memorial-printable-form">Granit Bronze Memorial Order Form</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/granit-bronz-precious-printable-form">Granit Bronze Porcelain Order Form</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-order-form">Order Form</router-link>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link @click.native.capture.stop aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle custom-navbar-dropdown" data-toggle="dropdown" to="#">Reports</router-link>
                                <ul class="dropdown-menu">
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/sale-report">Sales Report</router-link>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <router-link class="nav-link" to="/cemetery-list" v-if="isCemeteryPermitted">Cemetery</router-link>
                    <li class="nav-item dropdown" v-if="isProductPermitted">
                        <a aria-expanded="true" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"> <span class="nav-label ">Product</span> <span
                        ></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/product-catalog-list">All Products</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/monuments-list">Monument</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/service-list">Service</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/simple-list">Simple Product</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/composite-list">Composite</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link @click.native.capture.stop aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle custom-navbar-dropdown" data-toggle="dropdown" exact to="#">Reports</router-link>
                                <ul class="dropdown-menu">
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/display-inventory">Cost of Display Inventory</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/production-inventory">Cost of Production Inventory</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/reorder-quantity">Reorder Quantity</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/sale-product-report">Sales by Product</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/price-sheet-number">Price Sheet</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/price-sheet-number-composite">Price Sheet Composite</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/price-sheet-color-type-composite">Price Sheet by Color & Type Composite</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/price-sheet-by-color-and-type">Price Sheet by Color & Type</router-link>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown" v-if="isCollaborationPermitted">
                        <a aria-expanded="true" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"> <span class="nav-label ">Collaboration</span> <span
                        ></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/collaboration-list">Collaboration List</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/collaborator-list">Collaborators List</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/task-collaboration-list">Task Collaboration Report</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/correspondence-list">Correspondence Report</router-link>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown" v-if="isProductionPermitted">
                        <a aria-expanded="true" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"> <span class="nav-label ">Production</span> <span
                        ></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/production-list">Production List</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link @click.native.capture.stop aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle custom-navbar-dropdown" data-toggle="dropdown" to="#">Daily Production</router-link>
                                <ul class="dropdown-menu">
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/picture-production-list">OC Picture (Porcelain) Form</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/sandblasting-production-list">Sandblasting</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/laser-production-list">Laser</router-link>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link @click.native.capture.stop aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle custom-navbar-dropdown" data-toggle="dropdown" to="#">Printable Forms</router-link>
                                <ul class="dropdown-menu">
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-picture-production">Porcelain Form</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-sandblasting-production">Sandblasting</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-laser-production">Laser</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-approval-monument">Approval Monument</router-link>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link @click.native.capture.stop aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle custom-navbar-dropdown" data-toggle="dropdown" to="#">Reports</router-link>
                                <ul class="dropdown-menu">
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/production-report">Production Report</router-link>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown" v-if="isInstallationPermitted">
                        <a aria-expanded="true" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"> <span class="nav-label">Installation</span> <span
                        ></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/installation-list">Installation List</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/weekly-schedule-list">Weekly Schedule</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link @click.native.capture.stop aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle custom-navbar-dropdown" data-toggle="dropdown" to="#">Daily Paperwork</router-link>
                                <ul class="dropdown-menu">
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/installation-load-list">Installation Load List</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/installation-check-list">Installation Check List</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/truck-load-list">Truck Load List</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/installation-production-list">Install Production Form</router-link>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link @click.native.capture.stop aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle custom-navbar-dropdown" data-toggle="dropdown" to="#">Printable Forms</router-link>
                                <ul class="dropdown-menu">
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-installation-load">Installation Load List</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-installation-checklist">Installation Check List</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-truck-load">Truck Load List</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-installation-production">Install Production Form</router-link>
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-weekly-schedule">Weekly-Schedule</router-link>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown" v-if="isPOPermitted">
                        <a aria-expanded="true" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"> <span class="nav-label ">Purchasing</span> <span
                        ></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/purchase-order-list">PO List</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/supplier-list">Supplier Information</router-link>
                            </li>
                        </ul>
                    </li>
                    <router-link class="nav-link" exact to="/accounting-list" v-if="isAccountingPermitted">Accounting</router-link>
                    <li class="nav-item dropdown" v-if="isMaintenancePermitted">
                        <a aria-expanded="true" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"> <span class="nav-label ">Eq. Maintenance</span> <span
                        ></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/equipment-list">Equipment List</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" exact to="/maintenance-work-order-list">Work Orders</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link @click.native.capture.stop aria-expanded="false" aria-haspopup="true" class="dropdown-item dropdown-toggle custom-navbar-dropdown" data-toggle="dropdown" to="#">Printables</router-link>
                                <ul class="dropdown-menu">
                                    <router-link class="dropdown-item custom-navbar-dropdown" exact to="/printable-maintenance-work-order">Work Order</router-link>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown" v-if="isSettingPermitted">
                        <a aria-expanded="true" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"> <span class="nav-label ">Setting</span> <span
                        ></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" to="/department-list">Department</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" to="/order-status-list">Order Status</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" to="/paper-location-list">Paper Location</router-link>
                            </li>
                            <li class="dropdown-submenu">
                                <router-link class="dropdown-item custom-navbar-dropdown" to="/cost-per-squre-feet-list">Cost P/Sq. Ft.</router-link>
                            </li>
                        </ul>
                    </li>
                </b-navbar-nav>
            </b-collapse>
            <b-navbar-nav>
                <b-nav-item-dropdown right>
                    <template #button-content>
                        <i class="fa fa-user fa-lg"></i>
                        {{userInfo.name}}
                    </template>
                    <template>
                        <div class="mx-1">
                            <div class="text-center">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                        </div>
                        <div class="mx-2 text-center">
                            <div class="mx-1">
                                <label style="font-size: 14px">{{userInfo.role ? userInfo.role.title : 'Inactive'}}</label>
                            </div>
                            <div class=" mx-1">
                                <label style="font-size: 14px">{{userInfo.email? userInfo.email : ''}}</label>
                            </div>
                        </div>
                    </template>
                    <hr>
                    <div class="d-flex pt-2">
                        <div class="mx-1 w-50 pr-2 border-right">
                            <button @click.prevent="setUserProfile" class="dropdown-item custom-navbar-dropdown" v-b-modal.profile-update-modal>Profile</button>
                        </div>
                        <div class="mx-1 w-50">
                            <button @click.prevent="logoutUser" class="dropdown-item custom-navbar-dropdown">Logout</button>
                        </div>
                    </div>
                </b-nav-item-dropdown>
            </b-navbar-nav>
        </b-navbar>
        <b-modal id="profile-update-modal" title="User Profile">
            <template #modal-footer="{ ok, cancel, hide }">
                <b-button @click="updateUserProfile" size="sm" variant="primary">Update Profile</b-button>
            </template>
            <Error :errors="validationErrors" v-if="validationErrors"></Error>
            <Success :message="successMessage" v-if="successMessage"></Success>
            <div class="custom-row d-block">
                <b-form-input class="my-2" placeholder="Name" size="sm" type="text" v-model="formFields.name"></b-form-input>
                <b-form-input class="my-2" placeholder="Email" readonly size="sm" type="email" v-model="formFields.email"></b-form-input>
                <b-form-input class="my-2" placeholder="New Password" size="sm" type="password" v-model="formFields.password"></b-form-input>
                <b-form-input class="my-2" placeholder="Confirm New Password" size="sm" type="password" v-model="formFields.password_confirmation"></b-form-input>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import Success from "../../Modules/Success";
    import Error from "../../Modules/Error";
    import axios from 'axios';
    import {authUser, logoutUser, updateProfile, userDetail} from "../../helpers/axios";

    export default {
        name: "NavBar",
        components: {
            Error,
            Success
        },
        data() {
            return {
                formFields: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                componentId: 1,
                user: {role: {}},
                validationErrors: '',
                successMessage: '',
            }
        },
        computed: {
            userInfo: function () {
                let element = document.getElementById('remove-width-style');
                element.classList.add("remove-div-width-for-mobile");
                return this.user = this.$store.state['auth'].user ? this.$store.state['auth'].user : {role: {title: ''}};
            },
            isQuotesPermitted() {
                return this.$store.getters.isPermitted({resource: 'Quotes', action: 'read'});
            },
            isOrdersPermitted() {
                return this.$store.getters.isPermitted({resource: 'Orders', action: 'read'});
            },
            isCemeteryPermitted() {
                return this.$store.getters.isPermitted({resource: 'Cemetery', action: 'read'});
            },
            isProductPermitted() {
                return this.$store.getters.isPermitted({resource: 'Products', action: 'read'});
            },
            isCollaborationPermitted() {
                return this.$store.getters.isPermitted({resource: 'Collaboration', action: 'read'});
            },
            isProductionPermitted() {
                return this.$store.getters.isPermitted({resource: 'Production', action: 'read'});
            },
            isInstallationPermitted() {
                return this.$store.getters.isPermitted({resource: 'Installation', action: 'read'});
            },
            isAccountingPermitted() {
                return this.$store.getters.isPermitted({resource: 'Accounting', action: 'read'});
            },
            isPOPermitted() {
                return this.$store.getters.isPermitted({resource: 'Purchasing', action: 'read'});
            },
            isUserPermitted() {
                return this.$store.getters.isPermitted({resource: 'User', action: 'read'});
            },
            isMaintenancePermitted() {
                return this.$store.getters.isPermitted({resource: 'Maintenance', action: 'read'});
            },
            isDashboardPermitted() {
                return this.$store.getters.isPermitted({resource: 'Dashboard', action: 'read'});
            },
            isSettingPermitted() {
                return this.$store.getters.isPermitted({resource: 'Setting', action: 'read'});
            },
            isAdmin() {
                if (this.$store.getters.isAdmin == 'Admin' || this.$store.getters.isAdmin == 'Supper Admin')
                    return true;
            },
            isSupperAdmin() {
                return this.$store.getters.isAdmin == 'Supper Admin' ? true : false
            },
        },
        beforeCreate() {
            if (localStorage.authUser !== undefined) {
                let payload = JSON.parse(localStorage.getItem('authUser'));
                this.$store.commit('setAuthUser', payload);
                axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('auth_token')}`
            }
            userDetail((response) => {
                this.user = response.data;
                let payload = {user: response.data[0], isLoggedIn: true};
                this.$store.commit('setAuthUser', payload);
                localStorage.setItem('authUser', JSON.stringify(payload));
                axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('auth_token')}`

            }, (error) => {
                console.log('Auth', error);
            });
            if (this.$store.getters.isAdmin == 'Customer') {
                this.$router.push("/customer-portal").catch(() => {
                });
            }
        },
        methods: {
            setUserProfile() {
                this.successMessage = '';
                this.validationErrors = '';
                this.formFields.id = this.user.id ? this.user.id : 0;
                this.formFields.name = this.user.name ? this.user.name : '';
                this.formFields.email = this.user.email ? this.user.email : '';
                this.formFields.password = '';
                this.formFields.password_confirmation = '';
            },
            updateUserProfile() {
                updateProfile(this.formFields, (response) => {
                    let payload = {user: response.data, isLoggedIn: true};
                    this.$store.commit('setAuthUser', payload);
                    localStorage.setItem('authUser', JSON.stringify(payload));
                    this.validationErrors = '';
                    this.successMessage = 'Profile Successfully Updated';
                    setTimeout(() => {
                        this.successMessage = '';
                    }, 3000);
                }, (error) => {
                    if (error.response.status == 422) {
                        this.successMessage = '';
                        this.validationErrors = error.response.data.errors;
                    }
                });
            },
            logoutUser() {
                logoutUser((response) => {
                    let payload = {user: null, isLoggedIn: false, auth_token: null};
                    localStorage.clear();
                    this.$store.commit('setAuthUser', payload);
                    this.$router.push({name: "Login"})
                }, (error) => {
                    console.log('Auth', error);
                    let payload = {user: null, isLoggedIn: false};
                    this.$store.commit('setAuthUser', payload);
                    this.$router.push({name: "Login"})
                });
            }
        }
    }
</script>

<style scoped>

</style>
