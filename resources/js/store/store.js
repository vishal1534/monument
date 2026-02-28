import Vue from 'vue';
import Vuex from 'vuex';
import { authUser, cemeteryInfo, companyInfo, compositeInfo, compositeReportFilterRecord, customerOrderInfo, deliveryWorkOrderInfo, departmentInfo, fetchPaginateRecord, fetchRecords, filterRecords, getCemeteries, getColumns, getCompanies, monumentInfo, paperLocationInfo, porcelainInfo, productCatalogRecord, reportFilterRecord, reportInfo, searchProducts, serviceInfo, simpleInfo, supplierInfo, userFamiliesInfo, userInfo } from '../helpers/axios';
import moment from "moment";

Vue.use(Vuex);
export default new Vuex.Store({
    state: {
        auth: {
            user: null,
            isLoggedIn: false
        },
        production: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
            currentRecord: [],
        },
        customerPortal: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        customerOrderStatus: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        customerApproval: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        customerCollaboration: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        productionLaser: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        maintenanceWorkOrder: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        productionPicture: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: false,
            isFiltered: false,
        },
        productionSandblasting: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: false,
            isFiltered: false,
        },
        cemetery: {
            cemeteryInfo: [],
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
            type: [],
        },
        cemeteryCategory: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        department: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            filterFields: {},
            busy: true,
            isFiltered: false,
        },
        costPerSqureFeet: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            filterFields: {},
            busy: true,
            isFiltered: false,
        },
        paperLocation: {
            paperLocationInfo: [],
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            filterFields: {},
            busy: true,
            isFiltered: false,
        },
        userResources: {
            resourcesInfo: [],
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            filterFields: {},
            busy: true,
            isFiltered: false,
        },
        orderStatus: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            filterRecords: {},
            busy: true,
            isFiltered: false,
        },
        order: {
            busy: true,
            columnList: [],
            firstRecord: [],
            isFiltered: false,
            lastRecord: [],
            productList: [],
            recordList: [],
            deptList: [
                { value: 'cemetery_dept', text: 'Cemetery Dept' },
                { value: 'design_dept', text: 'Design Dept' },
                { value: 'final_date_dept', text: 'Final Date Dept' },
                { value: 'installation_dept', text: 'OrderInstallation Dept' },
                { value: 'porcelain_dept', text: 'Porcelain Dept' },
                { value: 'purchasing_dept', text: 'Purchasing Dept' },
                { value: 'order_entry', text: 'Order Entry' },
                { value: 'stencil_cutting_dept', text: 'Stencil Cutting Dept.' }
            ],
            showHidePDF: false,
            currentRecord: [],
        },
        quote: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            productList: [],
            busy: true,
            isFiltered: false,
        },
        PoOrder: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            productList: [],
            busy: true,
            isFiltered: false,
        },
        monument: {
            monumentInfo: [],
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            filterFields: {},
            busy: true,
            isFiltered: false,
            currentSaleHistory: [],
        },
        monumentType: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            filterFields: {},
            busy: true,
            isFiltered: false,
        },
        monumentShape: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            filterFields: {},
            busy: true,
            isFiltered: false,
        },
        monumentSide: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            filterFields: {},
            busy: true,
            isFiltered: false,
        },
        monumentPolish: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            filterFields: {},
            busy: true,
            isFiltered: false,
        },
        monumentColor: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            filterFields: {},
            busy: true,
            isFiltered: false,
        },
        porcelain: {
            porcelainInfo: [],
            recordList: [],
            busy: true,
        },
        report: {
            columnList: [],
            recordList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        productCatalog: {
            columnList: [],
            recordList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        compositeReport: {
            columnList: [],
            recordList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        saleReport: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        deliveryWorkOrder: {
            deliveryWorkOrderInfo: [],
            recordList: [],
            busy: true,
        },
        country: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        orderInstallation: {
            busy: true,
            columnList: [],
            filterFields: {},
            firstRecord: [],
            isFiltered: false,
            lastRecord: [],
            recordList: [],
        },
        accounting: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        company: {
            companyInfo: [],
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            type: [],
            busy: true,
            isFiltered: false,
        },
        user: {
            userInfo: [],
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            userFamilies: [],
            busy: true,
            isFiltered: false,
        },
        userAddEdit: {
            recordList: [],
            firstRecord: [],
            lastRecord: [],

        },
        installation: {
            vaseDirection: [],
            foundationDepth: [],
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
            currentRecord: [],
        },
        weeklySchedule: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        installer: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        loader: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        installationProduction: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        simple: {
            simpleInfo: [],
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
            currentSaleHistory: [],
        },
        simpleCategory: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        service: {
            serviceInfo: [],
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
            currentSaleHistory: [],
        },
        serviceCategory: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        supplier: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
            supplierInfo: [],
        },
        equipment: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        composite: {
            compositeInfo: [],
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
            currentSaleHistory: [],
        },
        compositeCategory: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        collaboration: {
            departmentInfo: [],
            paperLocationInfo: [],
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
            currentRecord: [],
        },
        collaborator: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            type: [],
            isFiltered: false,
        },
        workorder_collaborator: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            type: [],
            isFiltered: false,
        },
        workorder_collaboratorType: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },

        collaboratorType: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        collaborationTask: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            printRecordList: [],
            busy: true,
            isFiltered: false,
        },
        correspondenceTask: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            printRecordList: [],
            busy: true,
            isFiltered: false,
        },
        userRole: {
            recordList: [],
            columnList: [],
            firstRecord: [],
            lastRecord: [],
            busy: true,
            isFiltered: false,
        },
        roleAddEdit: {
            recordList: [],
            firstRecord: [],
            lastRecord: [],
        },
        listNumberOfRecord: {
            recordList: [
                { value: '10', text: '10' },
                { value: '25', text: '25' },
                { value: '50', text: '50' },
            ],
        },
        checkChangeFormEdit: {
            record: {}
        }
    },
    mutations: {

        /**
         * General Mutations
         * */
        setFirstAndLastRecord: (state, payload) => {
            state[payload].firstRecord = state[payload].recordList.length > 0 ? state[payload].recordList[0] : [];
            state[payload].lastRecord = state[payload].recordList.length > 0 ? state[payload].recordList[state[payload].recordList.length - 1] : [];
        },
        appendOrUpdateInRecordList: (state, payload) => {
            let recordIndex = state[payload.module].recordList.findIndex(obj => obj.id == payload.data.id);
            if (recordIndex == -1) {

                state[payload.module].recordList.splice(0, 0, payload.data);
                // state[payload.module].recordList.splice(recordListLength+1,0,payload.data);
                state[payload.module].firstRecord = payload.data;

                if (state[payload.module].recordList.length == 1)
                    state[payload.module].lastRecord = payload.data;
            } else {
                if (recordIndex == 0)
                    state[payload.module].firstRecord = payload.data;
                if (recordIndex == state[payload.module].recordList.length - 1)
                    state[payload.module].lastRecord = payload.data;

                state[payload.module].recordList[recordIndex] = payload.data;
                Vue.set(state[payload.module].recordList, recordIndex, payload.data);
            }
            state[payload.module].busy = false;
        },
        appendOrUpdateDropDown: (state, payload) => {
            let recordIndex = state[payload.module].recordList.findIndex(obj => obj.id == payload.data.id)
            if (recordIndex == -1) {
                state[payload.module].recordList.splice(0, 0, payload.data);
            }
            state[payload.module].busy = false;
        },
        appendOrUpdateInUserFamilyList: (state, payload) => {
            let recordIndex = state[payload.module].userFamilies.findIndex(obj => obj.id == payload.data.id);

            if (recordIndex == -1) {
                let recordListLength = state[payload.module].userFamilies.length;
                // state[payload.module].recordList.splice(0,0,payload.data);
                state[payload.module].userFamilies.splice(recordListLength + 1, 0, payload.data);
                state[payload.module].firstRecord = payload.data;
            } else {
                state[payload.module].userFamilies[recordIndex] = payload.data;
                Vue.set(state[payload.module].userFamilies, recordIndex, payload.data);
            }
        },
        appendOrUpdateInSupplierInfo: (state, payload) => {
            let recordIndex = state[payload.module].supplierInfo.findIndex(obj => obj.id == payload.data.id);
            if (recordIndex == -1) {
                state[payload.module].supplierInfo.splice(0, 0, payload.data);
                state[payload.module].firstRecord = payload.data;
            } else {
                state[payload.module].supplierInfo[recordIndex] = payload.data;
                Vue.set(state[payload.module].supplierInfo, recordIndex, payload.data);
            }
        },
        setColumns: (state, payload) => {
            state[payload.module].columnList = payload.data;
        },
        setModuleList: (state, payload) => {
            state[payload.module].recordList = payload.data;
            state[payload.module].firstRecord = payload.data[0];
            state[payload.module].lastRecord = payload.data[payload.data.length - 1];
            state[payload.module].busy = false;
        },
        setDropDownInfo: (state, payload) => {
            if (payload.data) {
                state[payload.module].recordList = payload.data;
                state[payload.module].busy = false
            }
        },
        setCurrentFormData: (state, payload) => {
            state.checkChangeFormEdit.record = payload
        },

        setCustomerPortalInfo: (state, payload) => {
            state[payload.module].recordList = payload.data;
            state[payload.module].firstRecord = payload.data[0];
            state[payload.module].lastRecord = payload.data[payload.data.length - 1];
            state[payload.module].busy = false;
        },

        removeRecord: (state, payload) => {
            //let item = state[payload.module].recordList.find(obj => obj.id == payload.id);
            // state.quote.recordList.splice(item,1);
            state[payload.module].recordList = state[payload.module].recordList.filter(obj => obj.id != payload.id)
        },
        removeDetail: (state, payload) => {
            for (let obj of state[payload.module].recordList) {
                if (obj[payload.detail].id == payload.id)
                    obj[payload.detail] = {};
            }
        },
        removeInstallationDetail: (state, payload) => {
            for (let obj of state.installation.recordList) {
                console.log(payload);
                if (obj.id == payload.id)
                    obj[payload.detail] = { id: 0, installation_id: payload.id };
            }
        },
        removeOrderDetail: (state, payload) => {
            for (let i = 0; i < payload.details.length; i++) {
                let index = state[payload.details[i]].recordList.findIndex(obj => obj.order_id == payload.id);
                if (index > -1)
                    state[payload.details[i]].recordList.splice(index, 1);
            }

        },
        updatePermission: (state, payload) => {
            if (state.auth.user.role_id == payload.id)
                state.auth.user.role = payload;
        },

        /**
         * Auth Mutations
         * */
        setAuthUser: (state, payload) => {
            state.auth = payload;
        },


        /**
         * Cemetery Mutations
         * */
        setCemeteryInfo: (state, payload) => {
            state.cemetery.cemeteryInfo = payload;
        },
        setUserFamiliesInfo: (state, payload) => {
            state.user.userFamilies = payload;
        },
        setCemeteryList: (state, payload) => {
            state.cemetery.recordList = payload;
            state.cemetery.firstRecord = payload[0];
            state.cemetery.lastRecord = payload[payload.length - 1];
            state.cemetery.busy = false;
        },


        /**
         * supplier mutation
         */
        setSupplierInfo: (state, payload) => {
            state.supplier.supplierInfo = payload;
        },
        /**
         * Quote Mutations
         * */
        setProductList: (state, payload) => {
            state.quote.productList = payload;
        },
        /**
         * purchase order mutation
         */
        setPoProductList: (state, payload) => {
            state.PoOrder.productList = payload;
        },
        /**
         * Monument Mutations
         * */
        setMonumentInfo: (state, payload) => {
            state.monument.monumentInfo = payload;
            state.monumentType.recordList = payload.types;
            state.monumentColor.recordList = payload.colors;
            state.monumentSide.recordList = payload.sides;
            state.monumentShape.recordList = payload.shapes;
            state.monumentPolish.recordList = payload.monumentPolish;
            state.country.recordList = payload.countries;
            state.costPerSqureFeet.recordList = payload.costPSqureFeet;
            if (state.monumentType.recordList.length > 0)
                state.monumentType.busy = false;
            if (state.monumentColor.recordList.length > 0)
                state.monumentColor.busy = false;
            if (state.monumentSide.recordList.length > 0)
                state.monumentSide.busy = false;
            if (state.monumentShape.recordList.length > 0)
                state.monumentShape.busy = false;
            if (state.monumentPolish.recordList.length > 0)
                state.monumentPolish.busy = false;

        },

        /**
         * Porcelain Mutations
         * */
        setPorcelainInfo: (state, payload) => {
            state.porcelain.porcelainInfo = payload;
        },

        /**
         * Report info Mutations
         * @param state
         * @param payload
         */
        setReportInfo: (state, payload) => {
            state[payload.module].recordList = payload.data;
            state[payload.module].firstRecord = payload.data[0];
            state[payload.module].lastRecord = payload.data[payload.data.length - 1];
            state[payload.module].busy = false;
        },

        setReportFilter: (state, payload) => {
            state.report.recordList = state.report.recordList.concat(payload);
            state.report.busy = false;
            const uniqueItems = state.report.recordList.reduce((accumulator, currentItem) => {
                const duplicateIndex = accumulator.findIndex(item => item.id === currentItem.id && item.product_number === currentItem.product_number && item.item_name === currentItem.item_name);
                if (duplicateIndex === -1) {
                    accumulator.push(currentItem);
                }
                return accumulator;
            }, []);
            state.report.recordList = uniqueItems
        },

        setProductCatalog: (state, payload) => {
            state[payload.methodName].recordList = state[payload.methodName].recordList.concat(payload.data)
            state[payload.methodName].busy = false
            const uniqueItems = state[payload.methodName].recordList.reduce((accumulator, currentItem) => {
                const duplicateIndex = accumulator.findIndex(item => item.id === currentItem.id && item.product_number === currentItem.product_number && item.item_name === currentItem.item_name);
                if (duplicateIndex === -1) {
                    accumulator.push(currentItem);
                }
                return accumulator;
            }, []);
            state[payload.methodName].recordList = uniqueItems
        },

        /**
         * Delivery WOrk Order Mutations
         * */
        setDeliveryWorkOrderInfo: (state, payload) => {
            state.deliveryWorkOrder.deliveryWorkOrderInfo = payload;
        },

        /**
         * Companies Mutations
         * */
        setCompanyList: (state, payload) => {
            state.company.recordList = payload;
            state.company.firstRecord = payload[0];
            state.company.lastRecord = payload[payload.length - 1];
            state.company.busy = false;
        },

        /**
         * Company Mutations
         * */
        setCompanyInfo: (state, payload) => {
            state.company.companyInfo = payload;
        },
        /**
         * User List Mutation
         */
        setUserInfo: (state, payload) => {
            state.user.userInfo = payload;
        },
        /**
         * Department Mutations
         * */
        setDepartmentInfo: (state, payload) => {
            state.department.recordList = payload;
        },
        setPaperLocationInfo: (state, payload) => {
            state.paperLocation.recordList = payload;
        },

        /**
         * Service Mutations
         * */
        setServiceInfo: (state, payload) => {
            state.service.serviceInfo = payload;
            state.serviceCategory.recordList = payload;
            if (state.serviceCategory.recordList.length > 0)
                state.serviceCategory.busy = false;
        },

        /**
         * Simple Mutations
         * */
        setSimpleInfo: (state, payload) => {
            state.simple.simpleInfo = payload;
            state.simpleCategory.recordList = payload;
            if (state.simpleCategory.recordList.length > 0)
                state.simpleCategory.busy = false;

        },
        /**
         * Composite Mutations
         * */
        setCompositeInfo: (state, payload) => {
            state.composite.compositeInfo = payload;
            state.compositeCategory.recordList = payload;
            if (state.compositeCategory.recordList.length > 0)
                state.compositeCategory.busy = false;

        },
    },
    actions: {

        /**
         * Generic Actions
         * */
        getColumnList: (context, params) => {
            getColumns(params, (response) => {
                params.data = response.data;
                context.commit('setColumns', params);
            }, (error) => {
                console.log(error)
            });
        },
        getModuleInfo: (context, params) => {
            fetchRecords(params, function (response) {
                params.data = response.data;
                context.commit('setModuleList', params);
            }, (error) => {
                console.log(error)
            });
        },
        getDropDownInfo: (context, params) => {
            fetchPaginateRecord(params, function (response) {
                params.data = response.data
                context.commit('setDropDownInfo', params)
            }, (error) => {
                console.log(error)
            });
        },
        removeRecordFromList: (context, params) => {
            context.commit('removeRecord', params);
            context.commit('setFirstAndLastRecord', params.module);
        },
        removeDetailFromList: (context, params) => {
            context.commit('removeDetail', params);
        },
        removeInstallationDetailFromList: (context, params) => {
            context.commit('removeInstallationDetail', params);
        },
        removeOrderDetailFromList: (context, params) => {
            context.commit('removeOrderDetail', params);
        },
        getFilteredRecords: (context, params) => {

            filterRecords(params, (response) => {
                params.data = response.data;
                context.commit('setModuleList', params);
            }, error => {
                console.log(error)
                if (error.response.status == 403) {
                    params.data = [];
                    context.commit('setModuleList', params);
                }
            })
        },

        getReportFilteredRecord: (context, params) => {
            reportFilterRecord(params, (response) => {
                context.commit('setReportFilter', response.data);
            }, error => {
                console.log(error)
                if (error.response.status == 400) {
                    context.commit('setReportFilter', response.data);
                }
            })
        },

        getProductCatalogRecord: (context, params) => {
            productCatalogRecord(params, (response) => {
                params.data = response.data
                context.commit('setProductCatalog', params);
            }, error => {
                console.log(error)
                if (error.response.status == 400) {
                    params.data = response.data
                    context.commit('setProductCatalog', params);
                }
            })
        },

        getCompsiteReportFilteredRecord: (context, params) => {
            compositeReportFilterRecord(params, function (response) {
                params.data = response.data;
                context.commit('setReportInfo', params);
            }, (error) => {
                console.log(error)
            });
        },


        /**
         * Auth Actions
         * */
        getAuthUser(context) {
            authUser((data) => {
                context.commit('setAuthInfo', data);
            }, (error) => {
                console.error(error);
            });
        },

        /**
         * Production Actions
         * */

        /**
         * Cemetery Actions
         * */
        getCemeteryInfo(context, params) {
            cemeteryInfo(params, (data) => {
                context.commit('setCemeteryInfo', data);
            }, (error) => {
                console.error(error);
            });
        },
        /**
         * supplier action info
         * @param context
         */
        getSupplierInfo(context) {
            supplierInfo((data) => {
                context.commit('setSupplierInfo', data);
            }, (error) => {
                console.error(error);
            });
        },

        getUserFamiliesInfo(context) {
            userFamiliesInfo((data) => {
                context.commit('setUserFamiliesInfo', data);
            }, (error) => {
                console.error(error);
            });
        },
        /**
         *
         * @param context
         * @param params
         */
        getCustomerPortalInfo(context, params) {
            customerOrderInfo(params, (data) => {
                params.data = data;
                context.commit('setCustomerPortalInfo', params);
            }, (error) => {
                console.log(error);
            });
        },
        getCemeteriesInfo: context => {
            getCemeteries(function (response) {
                context.commit('setCemeteryList', response.data);
            }, (error) => {
                console.log(error)
            });
        },

        /**
         * Monument Actions
         **/
        getMonumentInfo(context) {
            monumentInfo((data) => {
                context.commit('setMonumentInfo', data);
            }, (error) => {
                console.error(error);
            });
        },

        /**
         * Porcelain Actions
         * */
        getPorcelainInfo(context) {
            porcelainInfo((data) => {
                context.commit('setPorcelainInfo', data);
            }, (error) => {
                console.error(error);
            });
        },

        /**
         * Reprt info Action
         * @param context
         */
        getReportInfo(context, params) {
            reportInfo(params, function (response) {
                params.data = response.data;
                context.commit('setReportInfo', params);
            }, (error) => {
                console.log(error)
            });
        },

        /**
         * Delivery Work Order Actions
         * */
        getDeliveryWorkOrderInfo(context) {
            deliveryWorkOrderInfo((data) => {
                context.commit('setDeliveryWorkOrderInfo', data);
            }, (error) => {
                console.error(error);
            });
        },

        /**
         * Companies Actions
         * */
        getCompaniesInfo: context => {
            getCompanies(function (response) {
                context.commit('setCompanyList', response.data);
            }, (error) => {
                console.log(error)
            });
        },

        /**
         * Company Actions
         **/
        getCompanyInfo(context) {
            companyInfo((data) => {
                context.commit('setCompanyInfo', data);
            }, (error) => {
                console.error(error);
            });
        },
        getUserInfo(context) {
            userInfo((data) => {
                context.commit('setUserInfo', data);
            }, (error) => {
                console.error(error);
            });
        },
        /** Quote Actions*/
        getProductList(context) {
            let formData = new FormData();
            formData.append('keywords', '');
            formData.append('type', '');

            searchProducts(formData, (data) => {
                context.commit('setProductList', data.data);
            }, (error) => {
                console.error(error);
            });
        },
        /**
         * Purchase Actions
         */
        getPoProductList(context) {
            let formData = new FormData();
            formData.append('keywords', '');
            formData.append('type', '');

            searchProducts(formData, (data) => {
                context.commit('setPoProductList', data.data);
            }, (error) => {
                console.error(error);
            });
        },

        /**
         * Department Actions
         **/
        getDepartmentInfo(context) {
            departmentInfo((data) => {
                context.commit('setDepartmentInfo', data);
            }, (error) => {
                console.error(error);
            });
        },
        /**
         * Paper Loaction Actions
         *
         */
        getPaperLocationInfo(context) {
            paperLocationInfo((data) => {
                context.commit("setPaperLocationInfo", data);
            }, (error) => {
                console.error(error);
            });
        },
        /**
         * Service Actions
         **/
        getServiceInfo(context) {
            serviceInfo((data) => {
                context.commit('setServiceInfo', data);
            }, (error) => {
                console.error(error);
            });
        },

        /**
         * Simple Actions
         **/
        getSimpleInfo(context) {
            simpleInfo((data) => {
                context.commit('setSimpleInfo', data);
            }, (error) => {
                console.error(error);
            });
        },

        /**
         * Composite Actions
         **/
        getCompositeInfo(context) {
            compositeInfo((data) => {
                context.commit('setCompositeInfo', data);
            }, (error) => {
                console.error(error);
            });
        },
    },
    getters: {

        /**
         * Accounting Getters
         * */
        getAccountingTableData: state => {
            let records = [...state.accounting.recordList];
            for (let key in records) {
                let obj = { ...records[key] };
                if (obj.order != null) {
                    obj = { ...obj.order, ...obj }
                    records[key] = obj;
                    if (obj.order.invoice != null) {
                        obj = { ...obj.order.invoice, ...obj }
                        records[key] = obj;
                    }
                    if (obj.order.family != null) {
                        obj = { ...obj.order.family, ...obj }
                        records[key] = obj;
                    }
                    if (obj.order_status != null) {
                        obj = { ...obj.order_status, ...obj }
                        records[key] = obj
                    }
                    if (obj.order_type != null && typeof obj.order_type === 'object') {
                        obj = { ...obj.order_type, ...obj }
                        records[key] = obj
                    }
                }
            }
            return records;
        },

        /**
         * Cemetery Getters
         * */
        getCemeteryTableData: state => {

            let records = [...state.cemetery.recordList];
            for (let key in records) {

                let obj = { ...records[key] };

                if (obj.regulation != null) {
                    obj = { ...obj.regulation, ...obj }
                    records[key] = obj;
                }

                if (obj.category != null) {
                    obj = { ...obj.category, ...obj }
                    records[key] = obj;
                }

                if (obj.city != null) {
                    obj = { ...obj.city, ...obj }
                    records[key] = obj;
                }

                if (obj.county != null) {
                    obj = { ...obj.county, ...obj }
                    records[key] = obj;
                }

                if (obj.state != null) {
                    obj = { ...obj.state, ...obj }
                    records[key] = obj;
                }
            }

            return records;

        },

        /**
         * Cemetery Category Getters
         * @param state
         * @returns {*[]}
         */
        getCemeteryCategoryData: state => {
            return state.cemeteryCategory.recordList.filter(obj => obj);
        },

        /**
         * Company Getters
         * */
        getCompanyTableData: state => {
            let records = [...state.company.recordList];
            for (let key in records) {
                let obj = { ...records[key] };

                if (obj.role != null) {
                    obj = { ...obj.role, ...obj }
                    records[key] = obj
                }
            }
            return records;
        },

        /**
         * user List Getter
         */
        getUserTableData: state => {
            let records = [...state.user.recordList];
            for (let key in records) {
                let obj = { ...records[key] };

                if (obj.role != null) {
                    let getTitle = obj.role;
                    if (getTitle.title != null) {
                        obj.title = getTitle.title;
                        obj.getTitle = getTitle;
                        records[key] = obj
                    }
                }
            }
            return records;
        },
        /**
         *
         * paper Location getter
         * @param state
         */
        getPaperLocationTableData: state => {
            let records = [...state.paperLocation.recordList];
            for (let key in records) {
                let obj = { ...records[key] };

                if (obj.location_title != null) {
                    obj = { ...obj.location_title, ...obj }
                    records[key] = obj
                }
            }
            return records;
        },
        getResourceTableDate: state => {
            let records = [...state.userResources.recordList];
            for (let key in records) {
                let obj = { ...records[key] };
                if (obj.title != null) {
                    obj = { ...obj.title, ...obj }
                    records[key] = obj
                }
            }
            return records;
        },
        /**
         * orderStatus table data
         */
        getOrderStatusTableDate: state => {
            let records = [...state.orderStatus.recordList];
            for (let key in records) {
                let obj = { ...records[key] };
                if (obj.title != null) {
                    obj = { ...obj.title, ...obj }
                    records[key] = obj
                }
            }
            return records;
        },
        /**
         * Composite Getters
         * */
        getCompositeTableData: state => {

            let records = [...state.composite.recordList];
            for (let key in records) {
                let obj = { ...records[key] };

                if (obj.category != null) {
                    obj = { ...obj.category, ...obj }
                    records[key] = obj
                }
            }
            return records;
        },

        /**
         * Composite Category Getters
         * */
        getCompositeCategoryTableData: state => {
            return state.compositeCategory.recordList;
        },

        /**
         * Production Getters
         * */
        getCollaborationTableData: state => (params) => {
            let records = [...state[params.module].recordList];
            for (let key in records) {
                let obj = { ...records[key] };
                if (obj.order != null) {
                    obj = { ...obj.order, ...obj }
                    records[key] = obj;
                    if (obj.order.invoice != null) {
                        obj = { ...obj.order.invoice, ...obj }
                        records[key] = obj;
                    }
                    if (obj.order.family != null) {
                        obj = { ...obj.order.family, ...obj }
                        records[key] = obj;
                    }
                    if (obj.order_status != null) {
                        obj = { ...obj.order_status, ...obj }
                        records[key] = obj
                    }
                    if (obj.order.order_type != null && typeof obj.order.order_type === 'object') {
                        obj = { ...obj.order.order_type, ...obj }
                        records[key] = obj
                    }
                    if (obj.order.paper_location != null && typeof obj.order.paper_location === 'object') {
                        obj = { ...obj.order.paper_location, ...obj }
                        records[key] = obj
                    }
                }
            }
            return records;
        },
        getCollaborationTaskData: state => {
            let records = [...state.collaborationTask.recordList];
            for (let key in records) {
                let obj = { ...records[key] };
                if (obj.department_id != null) {
                    obj = { ...obj.department, ...obj }
                    records[key] = obj
                }
                if (obj.collaboration.order.invoice != null) {
                    obj = { ...obj.collaboration.order.invoice, ...obj }
                    records[key] = obj
                }
                if (obj.collaboration.order.family != null) {
                    obj = { ...obj.collaboration.order.family, ...obj }
                    records[key] = obj
                }
            }
            return records;
        },
        getCorrespondenceTaskData: state => {
            let records = [...state.correspondenceTask.recordList];
            for (let key in records) {
                let obj = { ...records[key] };
                if (obj.correspondence.order.invoice != null) {
                    obj = { ...obj.correspondence.order.invoice, ...obj }
                    records[key] = obj
                }
                if (obj.correspondence.order.family != null) {
                    obj = { ...obj.correspondence.order.family, ...obj }
                    records[key] = obj
                }
            }
            return records;
        },
        getCollaborationPrintTaskData: state => {
            return state.collaborationTask.printRecordList.filter(obj => obj);
        },
        getCorrespondencePrintTaskData: state => {
            return state.correspondenceTask.printRecordList.filter(obj => obj);
        },

        /**
         * Collaborator Getters
         */
        getCollaboratorTableDate: state => {
            let records = [...state.collaborator.recordList];
            for (let key in records) {
                let obj = { ...records[key] };
                if (obj.type != null) {
                    obj = { ...obj.type, ...obj }
                    records[key] = obj;
                }
            }
            return records;
        },

        /**
         * Collaborator Type Getters
         */
        getCollaboratorTypeTableData: state => {
            return state.collaboratorType.recordList;
        },

        /**
         * Cost P/Sq. Ft. Getters
         * */
        getCostPerSqureFeetTableData: state => {
            return state.costPerSqureFeet.recordList;
        },

        /**
         * Department Getters
         * */
        getDepartmentTableData: state => {
            return state.department.recordList;
        },


        /**
         * Installation Getters
         * */
        getInstallationTableData: state => {

            let records = [...state.installation.recordList];
            for (let key in records) {

                let obj = { ...records[key] };

                if (obj.order != null) {

                    obj = { ...obj.order, ...obj }
                    records[key] = obj;

                    if (obj.order.invoice != null) {
                        obj = { ...obj.order.invoice, ...obj }
                        records[key] = obj;
                    }
                    if (obj.order.family != null) {
                        obj = { ...obj.order.family, ...obj }
                        records[key] = obj;
                    }
                    if (obj.order.order_status != null) {
                        obj = { ...obj.order.order_status, ...obj }
                        records[key] = obj;
                    }
                    if (obj.order.order_type != null && typeof obj.order.order_type === 'object') {
                        obj = { ...obj.order.order_type, ...obj }
                        records[key] = obj;
                    }
                    if (obj.order.paper_location != null && typeof obj.order.paper_location === 'object') {
                        obj = { ...obj.order.paper_location, ...obj }
                        records[key] = obj;
                    }
                }

            }

            return records;
        },

        /**
         * Weekly Schedule Getters
         * */
        getWeeklyScheduleTableData: state => {

            let records = [...state.weeklySchedule.recordList];
            return records;
        },


        /**
         * Installer Getters
         * */
        getInstallerTableData: state => {

            let records = [...state.installer.recordList];
            return records;
        },

        /**
         * Loader Getters
         * */
        getLoaderTableData: state => {

            let records = [...state.loader.recordList];
            return records;
        },


        /**
         * Installation Production Getters
         * */
        getInstallationProductionTableData: state => {

            let records = [...state.installationProduction.recordList];
            return records;
        },


        /**
         * Monument Getters
         * */
        getMonumentTableData: state => {
            let records = [...state.monument.recordList];

            for (let key in records) {
                let obj = { ...records[key] };

                if (obj.engrave != null) {
                    obj = { ...obj.engrave, ...obj }
                    records[key] = obj
                }
                if (obj.specification != null) {
                    obj = { ...obj.specification, ...obj }
                    records[key] = obj
                }
                if (obj.freight != null) {
                    obj = { ...obj.freight, ...obj }
                    records[key] = obj
                }
                if (obj.polish != null) {
                    obj = { ...obj.polish, ...obj }
                    records[key] = obj
                }
                if (obj.installation != null) {
                    obj = { ...obj.installation, ...obj }
                    records[key] = obj
                }
                if (obj.color != null) {
                    obj = { ...obj.color, ...obj }
                    records[key] = obj
                }
                if (obj.type != null) {
                    obj = { ...obj.type, ...obj }
                    records[key] = obj
                }
                if (obj.side != null) {
                    obj = { ...obj.side, ...obj }
                    records[key] = obj
                }
                if (obj.shape != null) {
                    obj = { ...obj.shape, ...obj }
                    records[key] = obj
                }

                records[key] = obj
            }
            return records;
        },

        /**
         * Report  Getters
         * @param state
         * @returns {*[]}
         */
        getReportTableData: state => {

            let records = [...state.report.recordList];
            for (let key in records) {
                let obj = { ...records[key] };
                if (obj.engrave != null) {
                    obj = { ...obj.engrave, ...obj }
                    records[key] = obj
                }
                if (obj.specification != null) {
                    obj = { ...obj.specification, ...obj }
                    records[key] = obj
                }
                if (obj.freight != null) {
                    obj = { ...obj.freight, ...obj }
                    records[key] = obj
                }
                if (obj.polish != null) {
                    obj = { ...obj.polish, ...obj }
                    records[key] = obj
                }
                if (obj.installation != null) {
                    obj = { ...obj.installation, ...obj }
                    records[key] = obj
                }
                if (obj.color != null) {
                    obj = { ...obj.color, ...obj }
                    records[key] = obj
                }
                if (obj.type != null) {
                    obj = { ...obj.type, ...obj }
                    records[key] = obj
                }
                if (obj.side != null) {
                    obj = { ...obj.side, ...obj }
                    records[key] = obj
                }
                if (obj.shape != null) {
                    obj = { ...obj.shape, ...obj }
                    records[key] = obj
                }
                records[key] = obj
            }
            return records;
        },
        getProductCatalogTableData: state => {
            return state.productCatalog.recordList.filter(obj => obj);
        },

        /**
         * Composite Report Getters
         * @param state
         * @returns {*[]}
         */
        getReportCompositeTableData: state => {
            let records = [...state.compositeReport.recordList];
            for (let key in records) {
                let obj = { ...records[key] };
                if (obj.category != null) {
                    obj = { ...obj.category, ...obj }
                    records[key] = obj
                }
            }
            return records;
        },

        /**
         * Monument Type Getters
         * */
        getMonumentTypeTableData: state => {
            return state.monumentType.recordList;
        },

        /**
         * Monument Side Getters
         * */
        getMonumentSideTableData: state => {
            return state.monumentSide.recordList;
        },

        /**
         * Monument Polish Getters
         * */
        getMonumentPolishTableData: state => {
            return state.monumentPolish.recordList;
        },

        /**
         * Monument Color Getters
         * */
        getMonumentColorTableData: state => {
            return state.monumentColor.recordList;
        },

        /**
         * Monument Shape Getters
         * */
        getMonumentShapeTableData: state => {
            return state.monumentShape.recordList;
        },

        /**
         * Simple Getters
         * */
        getSimpleTableData: state => {
            let records = [...state.simple.recordList];
            for (let key in records) {
                let obj = { ...records[key] };

                if (obj.category != null) {
                    obj = { ...obj.category, ...obj }
                    records[key] = obj
                }
            }
            return records;
        },

        /**
         * Simple Category Getters
         * */
        getSimpleCategoryTableData: state => {
            return state.simpleCategory.recordList;
        },

        /**
         * Service Getters
         * */
        getServiceTableData: state => {
            let records = [...state.service.recordList];
            for (let key in records) {
                let obj = { ...records[key] };

                if (obj.category != null) {
                    obj = { ...obj.category, ...obj }
                    records[key] = obj
                }
            }
            return records;
        },

        /**
         * Service Category Getters
         * */
        getServiceCategoryTableData: state => {
            return state.serviceCategory.recordList;
        },

        /**
         * Supplier Getters
         * */
        getSupplierTableData: state => {
            return state.supplier.recordList;
        },

        /**
         * Equipment Getters
         * */
        getEquipmentTableData: state => {
            return state.equipment.recordList;
        },

        /**
         * Order Getters
         * */
        getOrderTableData: state => (params) => {
            let records = [...state[params.module].recordList];
            for (let key in records) {
                let obj = { ...records[key] };

                if (obj.invoice != null) {
                    obj = { ...obj.invoice, ...obj }
                    records[key] = obj
                }
                if (obj.accounting != null) {
                    obj = { ...obj.accounting, ...obj }
                    records[key] = obj
                }
                if (obj.family != null) {
                    obj = { ...obj.family, ...obj }
                    records[key] = obj
                }
                if (obj.order_status != null) {
                    obj = { ...obj.order_status, ...obj }
                    records[key] = obj
                }
                if (obj.order_type != null && typeof obj.order_type === 'object') {
                    obj = { ...obj.order_type, ...obj }
                    records[key] = obj
                }
                if (obj.paper_location != null && typeof obj.paper_location === 'object') {
                    obj = { ...obj.paper_location, ...obj }
                    records[key] = obj
                }
            }
            return records;
        },

        /**
         * Production Getters
         * */
        getProductionTableData: state => (params) => {
            let records = [...state[params.module].recordList];
            for (let key in records) {

                let obj = { ...records[key] };

                if (obj.order != null) {
                    obj = { ...obj.order, ...obj }
                    records[key] = obj;

                    if (obj.order.invoice != null) {
                        obj = { ...obj.order.invoice, ...obj }
                        records[key] = obj;
                    }
                    if (obj.order.family != null) {
                        obj = { ...obj.order.family, ...obj }
                        records[key] = obj;
                    }
                    if (obj.order.order_status != null) {
                        obj = { ...obj.order.order_status, ...obj }
                        records[key] = obj;
                    }
                    if (obj.order.order_type != null && typeof obj.order.order_type === 'object') {
                        obj = { ...obj.order.order_type, ...obj }
                        records[key] = obj;
                    }
                    if (obj.order.paper_location != null && typeof obj.order.paper_location === 'object') {
                        obj = { ...obj.order.paper_location, ...obj }
                        records[key] = obj
                    }
                }


            }

            return records;
        },

        /**
         * Production OC Picture Getters
         * */
        getProductionOcPictureTableData: state => {

            let records = [...state.productionPicture.recordList];
            for (let key in records) {

                let obj = { ...records[key] };

                if (obj.production_oc_picture != null) {
                    obj = { ...obj.production_picture, ...obj }
                    records[key] = obj;
                }
            }

            return records;
        },

        /**
         * Production Laser Getters
         * */
        getProductionLaserTableData: state => {

            let records = [...state.productionLaser.recordList];
            for (let key in records) {

                let obj = { ...records[key] };

                if (obj.production_laser != null) {
                    obj = { ...obj.laser, ...obj }
                    records[key] = obj;
                }
            }

            return records;
        },

        /**
         *
         * Maintainanace work order getter
         */
        getWorkOrderTableData: state => {
            let records = [...state.maintenanceWorkOrder.recordList];
            for (let key in records) {
                let obj = { ...records[key] };
                if (obj.maintenanceWorkOrder != null) {
                    obj = { ...obj.maintenanceWorkOrder, ...obj }
                    records[key] = obj;
                }
            }
            return records;
        },

        /**
         * Production Sandblasting Getters
         * */
        getProductionSandblastingTableData: state => {

            let records = [...state.productionSandblasting.recordList];
            for (let key in records) {

                let obj = { ...records[key] };

                if (obj.production_sandblasting != null) {
                    obj = { ...obj.production_sandblasting, ...obj }
                    records[key] = obj;
                }
            }
            return records;
        },

        /**
         * Quotes Getters
         * */
        getQuoteTableData: state => {

            let records = [...state.quote.recordList];

            for (let key in records) {
                let obj = { ...records[key] };

                let companyData = obj.company;
                obj.account_number = companyData?.account_number ? companyData.account_number : '';
                obj.companyData = companyData;
                obj.company = obj.cemetery?.company ? obj.cemetery.company : '';

                records[key] = obj
            }
            return records;
        },

        /**
         * get purchase order
         */
        getPurchaseOrderTableData: state => {

            let records = [...state.PoOrder.recordList];

            for (let key in records) {
                let obj = { ...records[key] };

                if (obj.supplier != null) {
                    obj = { ...obj.supplier, ...obj }
                    records[key] = obj
                }
            }
            return records;
        },
        /**
         * User Role Getters
         * */
        getuserRoleTableData: state => {

            let records = [...state.userRole.recordList];

            for (let key in records) {
                let obj = { ...records[key] };

                records[key] = obj
            }
            return records;
        },

        isPermitted: (state) => (params) => {
            let permitted = false;
            let authUser = { ...state.auth };
            if (authUser.user && authUser.user.role) {
                let permissions = { ...authUser.user.role.permissions }
                for (let key in permissions)
                    if (params.resource == permissions[key].resource)
                        permitted = permissions[key][params.action];
            }
            return permitted;
        },

        isAdmin: (state) => {
            let userRole = false;
            let authUser = null;
            if (localStorage.authUser !== undefined)
                authUser = JSON.parse(localStorage.getItem('authUser'));
            if (authUser.user && authUser.user.role) {
                if (authUser.user.role.title == 'Customer')
                    userRole = 'Customer';
                else if (authUser.user.role.title == 'Admin')
                    userRole = 'Admin';
                else if (authUser.user.role.title == 'Supper Admin')
                    userRole = authUser.user.role.title;
            }

            return userRole;
        },
        getUserName: () => {
            let authUser = null;
            let userName = null;
            if (localStorage.authUser !== undefined)
                authUser = JSON.parse(localStorage.getItem('authUser'));
            if (authUser.user && authUser.user.role) {
                userName = authUser.user.name;
            }
            return userName;
        },
        getCurrentDate: () => {
            let date = new Date();
            const [month, day, year] = [date.getMonth() + 1, date.getDate(), date.getFullYear()];
            return `${month}/${day}/${year}`
        },
        getModuleAddEdit: state => (params) => {
            let childModule = params.childModule;
            let parentModule = params.parentModule;
            if (parentModule == 'user')
                state[childModule].recordList = state[parentModule].recordList.filter(record => (record.role.title != "Admin" && record.role.title != "Supper Admin"));
            else
                state[childModule].recordList = state[parentModule].recordList.filter(record => (record.title != "Customer" && record.title != "Admin"));
            let records = state[childModule].recordList;
            state[childModule].firstRecord = records[0];
            state[childModule].lastRecord = records[records.length - 1];
            return records;
        },
        sortByAlphaNumeric: state => (params) => {
            let moduleName = null;
            let records = null;
            if (params.module) {
                moduleName = params.module;
                records = state[moduleName].recordList;
            } else {
                records = params.recordList;
            }
            let fieldName = params.fieldName;
            if (records.length > 0) {
                const compareValues = new Intl.Collator(undefined, {
                    numeric: true,
                    sensitivity: 'base'
                });
                const sortedArray = records.sort((firstValue, secondValue) => {
                    return compareValues.compare(firstValue[fieldName], secondValue[fieldName]);
                });
                if (moduleName) {
                    state[moduleName].firstRecord = sortedArray[0];
                    state[moduleName].lastRecord = sortedArray[sortedArray.length - 1];
                }
                return sortedArray;
            }
        },
        calculatePercentage: state => (params) => {
            let calculated = 0;
            if (params.getPercent) {
                calculated = parseFloat((params.overridePrice) * (params.getPercent / 100));
            }
            return calculated;
        },
        getSimpleAndServicePrice: state => (params) => {
            let productPrice = [];
            if (params.service && params.service.length > 0) {
                productPrice = params.service[0];
            } else if (params.simple && params.simple.length > 0) {
                productPrice = params.simple[0];
            }
            return productPrice;
        },
        getInstallationPrice: state => (record) => {
            for (let prod of record) {
                let installationPrice = 0;
                for (let compo of prod.composite_products) {
                    if (compo.monument && compo.monument.length > 0) {
                        if (compo.monument[0].installation)
                            compo.installation_price = compo.monument[0].installation.installation_amount;
                    } else {
                        compo.installation_price = 0;
                    }
                    if (compo.installation)
                        installationPrice += compo.installation_price * compo.quantity;
                }
                prod.install_price = installationPrice;
            }
            return record;
        },
        changeDateFormat: state => (params) => {
            if (params)
                return moment(String(params)).format('MM/DD/YYYY');
        },
        changeNumberFormat: state => (params) => {
            if (params) {
                if (Number.isInteger(parseFloat(params))) {
                    return parseFloat(params).toLocaleString('en-US', { style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
                return new Intl.NumberFormat().format(params);
            }
        },
        productIdPrice: state => (params) => {
            let product = [];
            let type = null;
            if (params.service.length > 0) {
                product = params.service[0];
                type = 'service';
            } else if (params.simple.length > 0) {
                product = params.simple[0];
                type = 'simple';
            }
            product.type = type;
            return product
        },
        changedCompositePrice: state => (products) => {
            products = products.filter(obj => {
                if (obj.order_composite_product.length > 0) {
                    let compositeProduct = obj.order_composite_product;
                    compositeProduct = compositeProduct.filter(comp => {
                        if (comp.monument.length > 0) {
                            comp.monument[0].override_selling_price = comp.price_override;
                        } else if (comp.service.length > 0) {
                            comp.service[0].price = comp.price;
                        } else if (comp.simple.length > 0) {
                            comp.simple[0].price = comp.price;
                        }
                    });
                    obj.composite[0].composite_products = obj.order_composite_product;
                }
                return obj;
            });
            return products;
        },
        getProductInventory: (state, getters) => (params) => {
            let list = state[params.module].recordList;
            let record = list.find(obj => obj.id == params.id);
            if (record) {
                record[params.childModule] = [];
                params.data.filter(obj1 => {
                    record[params.childModule].push(obj1);
                });
            }
        },
        checkIsDateValid: state => (validateDate) => {
            let currentDate = validateDate;
            if (currentDate == '')
                return false;
            let rXDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
            let dateArray = currentDate.match(rXDatePattern);
            if (dateArray == null)
                return false;
            let dateMonth = dateArray[1];
            let dateDay = dateArray[3];
            let dateYear = dateArray[5];
            if (dateMonth < 1 || dateMonth > 12)
                return false;
            else if (dateDay < 1 || dateDay > 31)
                return false;
            else if ((dateMonth == 4 || dateMonth == 6 || dateMonth == 9 || dateMonth == 11) && dateDay == 31)
                return false;
            else if (dateMonth == 2) {
                let isleap = (dateYear % 4 == 0 && (dateYear % 100 != 0 || dateYear % 400 == 0));
                if (dateDay > 29 || (dateDay == 29 && !isleap))
                    return false;
            }
            return true;
        },
        removeDuplicatedDate: (state, getters) => (data) => {
            let removeDate = data.filter(remove => {
                if (getters.checkIsDateValid(remove.value)) {
                    data.splice(data.findIndex(sp => sp.value == remove.value), 1);
                }
            })
            let currentIndex = data.findIndex(findIn => findIn.value == 'currentDate')
            if (currentIndex === -1) {
                data.push({ value: 'currentDate', text: '"Today\'s Date"' })
            }
        },
        getCurrentStoreID: () => {
            let authUser = null;
            let storeID = null;
            if (localStorage.authUser !== undefined)
                authUser = JSON.parse(localStorage.getItem('authUser'));
            if (authUser.user && authUser.user.store) {
                storeID = authUser.user.store.id;
            }
            return storeID;
        },
        setOrderCollabProdInstallID: () => (params) => {
            let record = params.record
            let orderLinkList = params.recordList
            orderLinkList.forEach(obj => {
                if (obj.link === 'collaboration') {
                    obj.id = record.collaboration?.id;
                } else if (obj.link === 'productions') {
                    obj.id = record.production?.id;
                } else if (obj.link === 'installation') {
                    obj.id = record.installation?.id;
                } else if (obj.link === 'orders') {
                    obj.id = record.id;
                }
            });
            return orderLinkList;
        },
        detectFormChanges: () => () => {
            window.detectChanges = false;
            let form = document.getElementsByTagName("form")[0];
            if (form) {
                form.addEventListener("input", function () {
                    window.detectChanges = true;
                });
                let selectElement = form.querySelector("select");
            }
        },
    },
})
