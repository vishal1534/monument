import axios from 'axios';
import { isLoggedIn } from "../helpers/axios";
import { watch } from "vue";


/*import Master from '../layout/Master';
import Dashboard from '../pages/Dashboard';
import NotFound from '../pages/NotFound';
import NotAccess from '../pages/NotAccess';

import Register from '../pages/auth/Register';
import Login from '../pages/auth/Login';
import ForgetPassword from '../pages/auth/ForgetPassword';
import ResetPassword from '../pages/auth/ResetPassword';
import UserVerification from '../pages/auth/UserVerification';
import CreatePassword from "../pages/auth/CreatePassword";

import ProductionAdd from '../pages/production/Add';
import ProductionList from '../pages/production/List';

import MaintenanceWorkOrderAdd from '../pages/maintenance/work-order/Add';
import MaintenanceWorkOrderList from '../pages/maintenance/work-order/List';
import PrintableMaintenanceWorkOrder from '../pages/maintenance/printables/work-order/Add';

import LaserProductionAdd from '../pages/production/Forms/laser-production/Add';
import LaserProductionList from '../pages/production/Forms/laser-production/List';
import PictureProductionAdd from '../pages/production/Forms/picture-production/Add';
import PictureProductionList from '../pages/production/Forms/picture-production/List';
import SandblastingProductionAdd from '../pages/production/Forms/sandblasting-production/Add';
import SandblastingProductionList from '../pages/production/Forms/sandblasting-production/List';

import PrintableLaserProductionAdd from '../pages/production/printables/laser-production/Add';
import PrintablePorcelainProductionAdd from '../pages/production/printables/porcelain-production/Add';
import PrintableSandblastingProductionAdd from '../pages/production/printables/sandblasting-production/Add';

import CemeteryAdd from '../pages/cemetery/Add';
import CemeteryList from '../pages/cemetery/List';

import DepartmentAdd from '../pages/setting/department/Add';
import DepartmentList from '../pages/setting/department/List';

import ResourceAdd from '../pages/setting/resource/Add';
import ResourceList from '../pages/setting/resource/List';

import QuoteAdd from '../pages/quote/Add';
import QuoteList from '../pages/quote/List';

import InstallationAdd from '../pages/installation/Add';
import InstallationList from '../pages/installation/List';

import WeeklyScheduleAdd from '../pages/installation/weekly-schedule/Add';
import WeeklyScheduleList from '../pages/installation/weekly-schedule/List';

import InstallationLoadAdd from '../pages/installation/daily-paperwork/installation-load/Add';
import InstallationLoadList from '../pages/installation/daily-paperwork/installation-load/List';
import TruckLoadAdd from '../pages/installation/daily-paperwork/truck-load/Add';
import TruckLoadList from '../pages/installation/daily-paperwork/truck-load/List';
import InstallationProductionAdd from '../pages/installation/daily-paperwork/installation-production/Add';
import InstallationProductionList from '../pages/installation/daily-paperwork/installation-production/List';
import InstallationCheckListAdd from '../pages/installation/daily-paperwork/installation-check-list/Add';


import PrintableWeeklySchedule from '../pages/installation/printable-Forms/weekly-schedule/Add';
import PrintableInstallationProduction from '../pages/installation/printable-Forms/installation-production/Add';
import PrintableInstallationLoad from '../pages/installation/printable-Forms/installation-load/Add';
import PrintableInstallationChecklist from '../pages/installation/printable-Forms/installation-checklist/Add';
import PrintableTruckLoad from '../pages/installation/printable-Forms/truck-load/Add';

import OrderAdd from '../pages/order/Add';
import OrderList from '../pages/order/List';

import OrderInstallationAdd from '../pages/order/Forms/installation/Add';
import OrderForm from '../pages/order/Forms/order-form/Add';
import BrickForm from '../pages/order/Forms/brick/Add';
import GranitBronzMemorialForm from '../pages/order/Forms/granit-bronz-memorial/Add';
import GranitBronzPreciousForm from '../pages/order/Forms/granit-bronz-precious/Add';
import MonumentAgreementAdd from '../pages/order/Forms/monument-agreement/Add';
import MonumentWorkOrderAdd from '../pages/order/Forms/monument-work-order/Add';
import FinalDateAdd from '../pages/order/Forms/final-date/Add';
import PorcelainAdd from '../pages/order/Forms/porcelain/Add';
import MonumentOrderNotesAdd from '../pages/order/Forms/monument-order-notes/Add';
import DeliveryWorkOrderAdd from '../pages/order/Forms/delivery-work-order/Add';
import MemorialProductionAdd from '../pages/order/Forms/memorial-production/Add';
import ApprovalMonumentAdd from '../pages/order/Forms/approval-monument/Add1';

import PrintableBrickForm from '../pages/order/Printables/brick/Add';
import PrintableInstalltionForm from '../pages/order/Printables/installation/Add';
import PrintableGranitBronzMemorialForm from '../pages/order/Printables/granit-bronz-memorial/Add';
import PrintableGranitBronzPreciousForm from '../pages/order/Printables/granit-bronz-precious/Add';
import PrintableMonumentAgreement from '../pages/order/Printables/monument-agreement/Add';
import PrintableMonumentWorkOrder from '../pages/order/Printables/monument-work-order/Add';
import PrintableDeliveryWorkOrder from '../pages/order/Printables/delivery-work-order/Add';
import PrintablePorcelain from '../pages/order/Printables/porcelain/Add';
import PrintableFinalDate from '../pages/order/Printables/final-date/Add';
import PrintableMonumentOrderNotes from '../pages/order/Printables/monument-order-notes/Add';
import PrintableOrderForm from '../pages/order/Printables/order-form/Add';
import PrintableApprovalMonument from '../pages/order/Printables/approval-monument/Add';
import PrintableMemorialProduction from '../pages/order/Printables/memorial-production/Add';

import CollaborationAdd from '../pages/collaboration/Add';
import CollaborationList from '../pages/collaboration/List';
import CollaborationFileUpload from '../pages/collaboration/File-upload';

import CompositeAdd from '../pages/composite/Add';
import CompositeList from '../pages/composite/List';

import CompositeCategoryAdd from '../pages/composite-category/Add';
import CompositeCategoryList from '../pages/composite-category/List';

import SimpleAdd from '../pages/simple-product/Add';
import SimpleList from '../pages/simple-product/List';

import SimpleCategoryAdd from '../pages/simple-category/Add';
import SimpleCategoryList from '../pages/simple-category/List';

import ServiceAdd from '../pages/service/Add';
import ServiceList from '../pages/service/List';

import ServiceCategoryAdd from '../pages/service-category/Add';
import ServiceCategoryList from '../pages/service-category/List';

import AccountingAdd from '../pages/accounting/Add';
import AccountingList from '../pages/accounting/List';

import CompanyAdd from '../pages/company/Add';
import CompanyList from '../pages/company/List';

import UserList from '../pages/user/List';
import UserAdd from '../pages/user/Add';

import PaperLocationList from '../pages/setting/paper-location/List';
import PaperLocationAdd from '../pages/setting/paper-location/Add';

import MonumentAdd from '../pages/product-monument/Add';
import MonumentList from '../pages/product-monument/List';

import MonumentTypeAdd from '../pages/monument-type/Add';
import MonumentTypeList from '../pages/monument-type/List';

import MonumentSideAdd from '../pages/monument-side/Add';
import MonumentSideList from '../pages/monument-side/List';

import MonumentShapeAdd from '../pages/monument-shape/Add';
import MonumentShapeList from '../pages/monument-shape/List';

import MonumentColorAdd from '../pages/monument-color/Add';
import MonumentColorList from '../pages/monument-color/List';

import RolesList from '../pages/user-role/List';
import RolesAdd from '../pages/user-role/Add';*/


let Master = () => import(/* webpackChunkName: "master" */ '../layout/Master');
let CustomerMaster = () => import(/* webpackChunkName "customerMaster" */ '../layout/CustomerMaster');
let Dashboard = () => import(/* webpackChunkName: "dashboard" */ '../pages/Dashboard');
let NotFound = () => import(/* webpackChunkName: "not_found" */ '../pages/NotFound');
let NotAccess = () => import(/* webpackChunkName: "not_access" */ '../pages/NotAccess');


let Register = () => import(/* webpackChunkName: "register" */ '../pages/auth/Register');
let Login = () => import(/* webpackChunkName: "login" */ '../pages/auth/Login');
let ForgetPassword = () => import(/* webpackChunkName: "forget_password" */ '../pages/auth/ForgetPassword');
let ResetPassword = () => import(/* webpackChunkName: "reset_password" */ '../pages/auth/ResetPassword');
let UserVerification = () => import(/* webpackChunkName: "user_verification" */ '../pages/auth/UserVerification');
let CreatePassword = () => import(/* webpackChunkName: "create_password" */ '../pages/auth/CreatePassword');


let ProductionAdd = () => import(/* webpackChunkName: "production_add" */ '../pages/production/Add');
let ProductionList = () => import(/* webpackChunkName: "production_list" */ '../pages/production/List');

let MaintenanceWorkOrderAdd = () => import(/* webpackChunkName: "maintenance_work_order_add" */ '../pages/maintenance/work-order/Add');
let MaintenanceWorkOrderList = () => import(/* webpackChunkName: "maintenance_work_order_list" */ '../pages/maintenance/work-order/List');
let PrintableMaintenanceWorkOrder = () => import(/* webpackChunkName: "printable_maintenance_work_order" */ '../pages/maintenance/printables/work-order/Add');

let LaserProductionAdd = () => import(/* webpackChunkName: "laser_production_add" */ '../pages/production/Forms/laser-production/Add');
let LaserProductionList = () => import(/* webpackChunkName: "laser_production_list" */ '../pages/production/Forms/laser-production/List');
let PictureProductionAdd = () => import(/* webpackChunkName: "picture_production_add" */  '../pages/production/Forms/picture-production/Add');
let PictureProductionList = () => import(/* webpackChunkName: "picture_production_list" */ '../pages/production/Forms/picture-production/List');
let SandblastingProductionAdd = () => import(/* webpackChunkName: "sandblasting_production_add" */ '../pages/production/Forms/sandblasting-production/Add');
let SandblastingProductionList = () => import(/* webpackChunkName: "sandblasting_production_list" */ '../pages/production/Forms/sandblasting-production/List');


let PrintableLaserProductionAdd = () => import(/* webpackChunkName: "printable_laser_production" */ '../pages/production/printables/laser-production/Add');
let PrintablePorcelainProductionAdd = () => import(/* webpackChunkName: "printable_porcelain_production" */ '../pages/production/printables/porcelain-production/Add');
let PrintableSandblastingProductionAdd = () => import(/* webpackChunkName: "printable_sandblasting_production" */ '../pages/production/printables/sandblasting-production/Add');


let CemeteryAdd = () => import(/* webpackChunkName: "cemetery_add" */ '../pages/cemetery/Add');
let CemeteryList = () => import(/* webpackChunkName: "cemetery_list" */ '../pages/cemetery/List');

let CemeteryCategoryAdd = () => import(/* webpackChunkName: "cemetery_category_add" */ '../pages/cemetery-category/Add');
let CemeteryCategoryList = () => import(/* webpackChunkName: "cemetery_category_list" */ '../pages/cemetery-category/List');

let DepartmentAdd = () => import(/* webpackChunkName: "department_add" */ '../pages/setting/department/Add');
let DepartmentList = () => import(/* webpackChunkName: "department_list" */ '../pages/setting/department/List');

let CostSqureFeetAdd = () => import(/* webpackChunkName: "cost_per_squre_feet_add" */ '../pages/setting/cost-per-squre-feet/Add');
let CostSqureFeetList = () => import(/* webpackChunkName: "cost_per_squre_feet_list" */ '../pages/setting/cost-per-squre-feet/List');

let OrderStatusAdd = () => import(/* webpackChunkName: "order_status_add" */ '../pages/setting/order-status/Add');
let OrderStatusList = () => import(/* webpackChunkName: "order_status_list" */ '../pages/setting/order-status/List');

let QuoteAdd = () => import(/* webpackChunkName: "quote_add" */ '../pages/quote/Add');
let QuoteList = () => import(/* webpackChunkName: "quote_list" */ '../pages/quote/List');


let InstallationAdd = () => import(/* webpackChunkName: "installation_add" */ '../pages/installation/Add');
let InstallationList = () => import(/* webpackChunkName: "installation_list" */ '../pages/installation/List');


let WeeklyScheduleAdd = () => import(/* webpackChunkName: "weekly_schedule_add" */ '../pages/installation/weekly-schedule/Add');
let WeeklyScheduleList = () => import(/* webpackChunkName: "weekly_schedule_list" */ '../pages/installation/weekly-schedule/List');


let InstallationLoadAdd = () => import(/* webpackChunkName: "installation_load_add" */ '../pages/installation/daily-paperwork/installation-load/Add');
let InstallationLoadList = () => import(/* webpackChunkName: "installation_load_list" */ '../pages/installation/daily-paperwork/installation-load/List');
let TruckLoadAdd = () => import(/* webpackChunkName: "truck_load_add" */  '../pages/installation/daily-paperwork/truck-load/Add');
let TruckLoadAddInstall = () => import(/* webpackChunkName: "truck_load_add" */  '../pages/installation/daily-paperwork/truck-load/Add');
let TruckLoadList = () => import(/* webpackChunkName: "truck_load_list" */ '../pages/installation/daily-paperwork/truck-load/List');
let InstallationProductionAdd = () => import(/* webpackChunkName: "installation_production_add" */  '../pages/installation/daily-paperwork/installation-production/Add');
let InstallationProductionList = () => import(/* webpackChunkName: "installation_production_list" */ '../pages/installation/daily-paperwork/installation-production/List');
let InstallationCheckListAdd = () => import(/* webpackChunkName: "installation_checklist_add" */ '../pages/installation/daily-paperwork/installation-check-list/Add');


let PrintableWeeklySchedule = () => import(/* webpackChunkName: "printable_weekly_schedule" */ '../pages/installation/printable-Forms/weekly-schedule/Add');
let PrintableInstallationProduction = () => import(/* webpackChunkName: "printable_installation_production" */ '../pages/installation/printable-Forms/installation-production/Add');
let PrintableInstallationLoad = () => import(/* webpackChunkName: "printable_installation_load" */ '../pages/installation/printable-Forms/installation-load/Add');
let PrintableInstallationChecklist = () => import(/* webpackChunkName: "printable_installation_check_list" */ '../pages/installation/printable-Forms/installation-checklist/Add');
let PrintableTruckLoad = () => import(/* webpackChunkName: "printable_truck_load" */ '../pages/installation/printable-Forms/truck-load/Add');


let OrderAdd = () => import(/* webpackChunkName: "order_add" */ '../pages/order/Add');
let OrderList = () => import(/* webpackChunkName: "order_list" */ '../pages/order/List');


let OrderInstallationAdd = () => import(/* webpackChunkName: "order_installation_add" */ '../pages/order/Forms/installation/Add');
let OrderForm = () => import(/* webpackChunkName: "order_form" */ '../pages/order/Forms/order-form/Add');
let BrickForm = () => import(/* webpackChunkName: "brick_form" */ '../pages/order/Forms/brick/Add');
let GranitBronzMemorialForm = () => import(/* webpackChunkName: "granit_bronz_memorial_form" */ '../pages/order/Forms/granit-bronz-memorial/Add');
let GranitBronzPreciousForm = () => import(/* webpackChunkName: "granit_bronz_precious_form" */ '../pages/order/Forms/granit-bronz-precious/Add');
let MonumentAgreementAdd = () => import(/* webpackChunkName: "monument_agreement_add" */ '../pages/order/Forms/monument-agreement/Add');
let MonumentWorkOrderAdd = () => import(/* webpackChunkName: "monument_work_order_add" */ '../pages/order/Forms/monument-work-order/Add');
let FinalDateAdd = () => import(/* webpackChunkName: "final_date_add" */ '../pages/order/Forms/final-date/Add');
let PorcelainAdd = () => import(/* webpackChunkName: "porcelain_add" */ '../pages/order/Forms/porcelain/Add');
let MonumentOrderNotesAdd = () => import(/* webpackChunkName: "monument_order_notes" */ '../pages/order/Forms/monument-order-notes/Add');
let DeliveryWorkOrderAdd = () => import(/* webpackChunkName: "delivery_work_order" */ '../pages/order/Forms/delivery-work-order/Add');
let MemorialProductionAdd = () => import(/* webpackChunkName: "memorial_production" */ '../pages/order/Forms/memorial-production/Add');
let ApprovalMonumentAdd = () => import(/* webpackChunkName: "approval_monument" */ '../pages/order/Forms/approval-monument/Add1');

let PrintableBrickForm = () => import(/* webpackChunkName: "printable_brick_form" */ '../pages/order/Printables/brick/Add');
let PrintableInstalltionForm = () => import(/* webpackChunkName: "printable_Installation_Form" */ '../pages/order/Printables/installation/Add');
let PrintableGranitBronzMemorialForm = () => import(/* webpackChunkName: "printable_granit_bronz_memorial_form" */  '../pages/order/Printables/granit-bronz-memorial/Add');
let PrintableGranitBronzPreciousForm = () => import(/* webpackChunkName: "printable_granit_bronz_precious_form" */ '../pages/order/Printables/granit-bronz-precious/Add');
let PrintableMonumentAgreement = () => import(/* webpackChunkName: "printable_monument_agreement" */ '../pages/order/Printables/monument-agreement/Add');
let PrintableMonumentWorkOrder = () => import(/* webpackChunkName: "printable_work_order" */ '../pages/order/Printables/monument-work-order/Add');
let PrintableDeliveryWorkOrder = () => import(/* webpackChunkName: "printable_delivery_work_order" */ '../pages/order/Printables/delivery-work-order/Add');
let PrintablePorcelain = () => import(/* webpackChunkName: "printable_porcelain" */ '../pages/order/Printables/porcelain/Add');
let PrintableFinalDate = () => import(/* webpackChunkName: "printable_final_date" */ '../pages/order/Printables/final-date/Add');
let PrintableMonumentOrderNotes = () => import(/* webpackChunkName: "printable_monument_order_notes" */ '../pages/order/Printables/monument-order-notes/Add');
let PrintableOrderForm = () => import(/* webpackChunkName: "printable_order_form" */ '../pages/order/Printables/order-form/Add');
let PrintableApprovalMonument = () => import(/* webpackChunkName: "printable_approval_monument" */ '../pages/order/Printables/approval-monument/Add');
let PrintableMemorialProduction = () => import(/* webpackChunkName: "printable_memorial_production" */ '../pages/order/Printables/memorial-production/Add');


let CollaborationAdd = () => import(/* webpackChunkName: "collaboration_add" */ '../pages/collaboration/Add');
let CollaborationList = () => import(/* webpackChunkName: "collaboration_list" */ '../pages/collaboration/List');
let CollaborationFileUpload = () => import(/* webpackChunkName: "collaboration_file_upload" */ '../pages/collaboration/File-upload');
let TaskCollaborationReport = () => import(/* webpackChunkName: "task_collaboration_report" */ '../pages/collaboration/task-collaboration-report/List');
let CorrespondanceReport = () => import(/* webpackChunkName: "task_correspondance_report" */ '../pages/collaboration/correspondance-report/List');

let CollaboratorAdd = () => import(/* webpackChunkName: "collaborator_add" */ '../pages/collaborator/Add');
let CollaboratorList = () => import(/* webpackChunkName: "collaborator_list" */ '../pages/collaborator/List');

let CollaboratorTypeAdd = () => import(/* webpackChunkName: "collaborator_type_add" */ '../pages/collaborator-type/Add');
let CollaboratorTypeList = () => import(/* webpackChunkName: "collaborator_type_list" */ '../pages/collaborator-type/List');

let WorkOrderCollaboratorList = () => import(/* webpackChunkName: "workordercollaborater_list"  */ '../pages/workorder-collaborator/List')
let WorkorderCollaboratorAdd = () => import(/* webpackChunkName: "workordercollaborator_add" */ '../pages/workorder-collaborator/Add');

let WorkOrderCollaboratorTypeAdd = () => import(/* webpackChunkName: "work_order_collaborator_type_add" */ '../pages/workorder-collaborator-type/Add');
let WorkOrderCollaboratorTypeList = () => import(/* webpackChunkName: "work_order_collaborator_type_list" */ '../pages/workorder-collaborator-type/List');

let CompositeAdd = () => import(/* webpackChunkName: "composite_add" */ '../pages/composite/Add');
let CompositeList = () => import(/* webpackChunkName: "composite_list" */ '../pages/composite/List');


let CompositeCategoryAdd = () => import(/* webpackChunkName: "composite_category_add" */ '../pages/composite-category/Add');
let CompositeCategoryList = () => import(/* webpackChunkName: "composite_category_list" */ '../pages/composite-category/List');


let SimpleAdd = () => import(/* webpackChunkName: "simple_product_add" */ '../pages/simple-product/Add');
let SimpleList = () => import(/* webpackChunkName: "simple_product_list" */ '../pages/simple-product/List');


let SimpleCategoryAdd = () => import(/* webpackChunkName: "simple_category_add" */ '../pages/simple-category/Add');
let SimpleCategoryList = () => import(/* webpackChunkName: "simple_category_list" */  '../pages/simple-category/List');

let ServiceAdd = () => import(/* webpackChunkName: "service_add" */ '../pages/service/Add');
let ServiceList = () => import(/* webpackChunkName: "service_list" */ '../pages/service/List');


let ServiceCategoryAdd = () => import(/* webpackChunkName: "service_category_add" */ '../pages/service-category/Add');
let ServiceCategoryList = () => import(/* webpackChunkName: "service_category_list" */ '../pages/service-category/List');


let AccountingAdd = () => import(/* webpackChunkName: "accounting_add" */ '../pages/accounting/Add');
let AccountingList = () => import(/* webpackChunkName: "accounting_list" */ '../pages/accounting/List');


let CompanyAdd = () => import(/* webpackChunkName: "company_add" */ '../pages/company/Add');
let CompanyList = () => import(/* webpackChunkName: "company_list" */ '../pages/company/List');


let UserList = () => import(/* webpackChunkName: "user_list" */ '../pages/user/List');
let UserAdd = () => import(/* webpackChunkName: "user_add" */ '../pages/user/Add');


let PaperLocationList = () => import(/* webpackChunkName: "paper_location_list" */  '../pages/setting/paper-location/List');
let PaperLocationAdd = () => import(/* webpackChunkName: "paper_location_add" */  '../pages/setting/paper-location/Add');


let MonumentAdd = () => import(/* webpackChunkName: "product_monument_add" */ '../pages/product-monument/Add');
let MonumentList = () => import(/* webpackChunkName: "product_monument_list" */ '../pages/product-monument/List');

let ProductCatalogList = () => import(/* webpackChunkName: "product_catalog_list" */ '../pages/product-catalog/List');

let MonumentTypeAdd = () => import(/* webpackChunkName: "monument_type_add" */ '../pages/monument-type/Add');
let MonumentTypeList = () => import(/* webpackChunkName: "monument_type_list" */ '../pages/monument-type/List');


let MonumentSideAdd = () => import(/* webpackChunkName: "monument_side_add" */ '../pages/monument-side/Add');
let MonumentSideList = () => import(/* webpackChunkName: "monument_side_list" */ '../pages/monument-side/List');


let MonumentPolishAdd = () => import(/* webpackChunkName: "monument_polish_add" */ '../pages/monument-polish/Add');
let MonumentPolishList = () => import(/* webpackChunkName: "monument_polish_list" */ '../pages/monument-polish/List');


let MonumentShapeAdd = () => import(/* webpackChunkName: "monument_shape_add" */ '../pages/monument-shape/Add');
let MonumentShapeList = () => import(/* webpackChunkName: "monument_shape_list" */ '../pages/monument-shape/List');


let MonumentColorAdd = () => import(/* webpackChunkName: "monument_color_add" */ '../pages/monument-color/Add');
let MonumentColorList = () => import(/* webpackChunkName: "monument_color_list" */ '../pages/monument-color/List');

let ReOrderQuantityList = () => import(/* webpackChunkName: "reorder_quantity_list" */ '../pages/report/reorder-quantity/list');
let ProductionInventory = () => import(/* webpackChunkName: "cost_of_production_inventory" */ '../pages/report/production-inventory/List');
let DisplayInventory = () => import(/* webpackChunkName: "cost_of_display_inventory" */ '../pages/report/display-inventory/List');
let SaleProductReport = () => import(/* webpackChunkName: "sales_by_product_report" */ '../pages/report/sale-product-report/List');
let PriceSheetByNumber = () => import(/* webpackChunkName: "price_sheet_by_number" */ '../pages/report/price-sheet-by-number/List');
let PriceSheetByNumberComposite = () => import(/* webpackChunkName: "price_sheet_by_number_composite" */ '../pages/report/price-sheet-number-composite/List');
let PriceSheetByColorAndType = () => import(/* webpackChunkName: "price_sheet_by_color_and_type" */ '../pages/report/price-sheet-by-color-and-type/List');
let SaleReport = () => import(/* webpackChunkName: "sale-report" */ '../pages/report/sale-report/List');
let ProductionReport = () => import(/* webpackChunkName: "production-report" */ '../pages/report/production-report/List');
let PriceSheetByColorAndTypeComposite = () => import(/* webpackChunkName: "price_sheet_by_color_and_type_composite" */ '../pages/report/sheet-color-type-composite/List')


let RolesList = () => import(/* webpackChunkName: "role_list" */ '../pages/user-role/List');
let RolesAdd = () => import(/* webpackChunkName: "role_add" */ '../pages/user-role/Add');


let SupplierAdd = () => import(/* webpackChunkName: "supplier_add" */ '../pages/purchasing/supplier/Add');
let SupplierList = () => import(/* webpackChunkName: "supplier_list" */ '../pages/purchasing/supplier/List');

let EquipmentAdd = () => import(/* webpackChunkName: "equipment_add" */ '../pages/maintenance/equipment/Add');
let EquipmentList = () => import(/* webpackChunkName: "equipment_list" */ '../pages/maintenance/equipment/List');

let PoAdd = () => import(/*  webpackChunkName: "po_add" */ '../pages/purchasing/PO/Add');
let PoList = () => import(/*  webpackChunkName: "po_list" */ '../pages/purchasing/PO/List');

let CustomerPortal = () => import(/* webpackChunkName: "customer_portal_add" */ '../pages/customer-dashboard/Dashboard');
let CustomerInvoice = () => import(/* webpackChunkName: "customer_invoice" */ '../pages/customer-invoice/Invoice');
let CustomerInvoiceList = () => import(/* webpackChunkName: "customer_invoice_list" */ '../pages/customer-invoice/InvoiceList');

let CustomerOrderStatusList = () => import(/* webpackChunkName: "customer_order_status_list" */ '../pages/customer-order-status/OrderStatusList');
let CustomerOrderStatus = () => import(/* webpackChunkName: "customer_order_status" */ '../pages/customer-order-status/OrderStatus');

let CustomerApprovalList = () => import(/* webpackChunkName: "customer_approval_list" */ '../pages/customer-approval/ApprovalList');
let CustomerApproval = () => import(/* webpackChunkName: "customer_approval" */ '../pages/customer-approval/Approval');

let CustomerCollaborationList = () => import(/* webpackChunkName: "customer_collaboration_list" */ '../pages/customer-collaboration/CollaborationList');
let CustomerCollaboration = () => import(/* webpackChunkName: "customer_collaboration" */ '../pages/customer-collaboration/Collaboration');



const isAuthenticated = (to, from, next) => {
    isLoggedIn((response) => {
        next()
    }, (error) => {
        return next({ name: 'Login', query: { redirect: to.path } })
    });

};
const checkIsCustomer = (to, from, next) => {
    isLoggedIn((response) => {
        let authUser = null;
        if (localStorage.authUser !== undefined)
            authUser = JSON.parse(localStorage.getItem('authUser'));
        if (authUser.user && authUser.user.role) {
            if (authUser.user.role.title == 'Customer') {
                next({ name: 'CustomerPortal' })
            } else {
                next()
            }
        }
    }, (error) => {
        return next({ name: 'Login', query: { redirect: to.path } })
    });
};

const routes = [
    {
        path: '*',
        component: NotFound
    },
    {
        path: '/access-denied',
        component: NotAccess,
        name: 'NotAccess',
    },
    {
        path: '/register',
        component: Register,
        name: 'Register',
        beforeEnter: (to, form, next) => {
            axios.get('/api/authenticated').then(() => {
                return next({ name: 'Dashboard' })
            }).catch(() => {
                next()
            })
        }
    },
    {
        path: '/login',
        component: Login,
        name: 'Login',
        beforeEnter: (to, form, next) => {
            axios.get('/api/authenticated').then(() => {
                return next({ name: 'Dashboard' })
            }).catch(() => {
                next()
            })
        }
    },
    {
        path: '/forget-password',
        component: ForgetPassword,
        name: 'ForgetPassword',
        beforeEnter: (to, form, next) => {
            axios.get('/api/authenticated').then(() => {
                return next({ name: 'Dashboard' })
            }).catch(() => {
                next()
            })
        }
    },
    {
        path: '/reset-password/:token',
        component: ResetPassword,
        name: 'ResetPassword',
        beforeEnter: (to, form, next) => {
            axios.get('/api/authenticated').then(() => {
                return next({ name: 'Dashboard' })
            }).catch(() => {
                next()
            })
        }
    },
    {
        path: '/user-verification/:token',
        component: UserVerification,
        name: 'UserVerification',
        beforeEnter: (to, form, next) => {
            axios.get('/api/authenticated').then(() => {
                return next({ name: 'Dashboard' })
            }).catch(() => {
                next()
            })
        }
    },
    {
        path: '/user-createPassword/:token',
        component: CreatePassword,
        name: 'CreatePassword',
        beforeEnter: (to, form, next) => {
            axios.get('/api/authenticated').then(() => {
                return next({ name: 'Dashboard' })
            }).catch(() => {
                next()
            })
        }
    },

    {
        path: '/',
        component: Dashboard,
        meta: { layout: Master },
        beforeEnter: checkIsCustomer,
    },
    {
        path: '/dashboard',
        component: Dashboard,
        meta: { layout: Master },
        name: 'Dashboard',
        beforeEnter: checkIsCustomer,
    },
    /**
     * Production Routes
     * */
    {
        path: '/productions',
        component: ProductionAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/productions/:id',
        component: ProductionAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/production-list',
        component: ProductionList,
        meta: { layout: Master },
        props: true,
        beforeEnter: isAuthenticated,
    },

    {
        path: '/printable-laser-production',
        component: PrintableLaserProductionAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/laser-production',
        component: LaserProductionAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/laser-production/:id',
        component: LaserProductionAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/laser-production-list',
        component: LaserProductionList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/maintenance-work-order-list',
        component: MaintenanceWorkOrderList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/maintenance-work-order',
        component: MaintenanceWorkOrderAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/maintenance-work-order/:id',
        component: MaintenanceWorkOrderAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/printable-maintenance-work-order',
        component: PrintableMaintenanceWorkOrder,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },


    {
        path: '/printable-picture-production',
        component: PrintablePorcelainProductionAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/picture-production',
        component: PictureProductionAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/picture-production/:id',
        component: PictureProductionAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/picture-production-list',
        component: PictureProductionList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/printable-sandblasting-production',
        component: PrintableSandblastingProductionAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/sandblasting-production',
        component: SandblastingProductionAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/sandblasting-production/:id',
        component: SandblastingProductionAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
    },
    {
        path: '/sandblasting-production-list',
        component: SandblastingProductionList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Cemetery Routes
     * */
    {
        path: '/cemeteries',
        component: CemeteryAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/cemeteries/:id',
        component: CemeteryAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/cemetery-list',
        component: CemeteryList,
        meta: { layout: Master },
        props: true,
        beforeEnter: isAuthenticated,
    },

    /**
     * Cemetery Category Routes
     */
    {
        path: '/cemetery-category',
        component: CemeteryCategoryAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/cemetery-category/:id',
        component: CemeteryCategoryAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/cemetery-category-list',
        component: CemeteryCategoryList,
        meta: { layout: Master },
        props: true,
        beforeEnter: isAuthenticated,
    },

    /**
     * Order Routes
     * */
    {
        name: 'Orders',
        path: '/orders',
        component: OrderAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.quote_to_order_id = +props.quote_to_order_id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/orders/:id',
        component: OrderAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/order-list',
        component: OrderList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Quote Routes
     * */
    {
        path: '/quotes',
        alias: ['/quote', '/quoteAdd'],
        component: QuoteAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/quotes/:id',
        component: QuoteAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/quote-list',
        component: QuoteList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Order Installation Forms Routes
     * */
    {
        path: '/installation-printable-form',
        component: PrintableInstalltionForm,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/order-installation',
        component: OrderInstallationAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/order-installation/:id',
        component: OrderInstallationAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        name: 'production_install',
        path: '/production-install/:id',
        component: OrderInstallationAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            props.production_id = +props.production_id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/order-form',
        component: OrderForm,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/order-form/:id',
        component: OrderForm,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/printable-order-form',
        component: PrintableOrderForm,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/brick-printable-form',
        component: PrintableBrickForm,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/brick-form',
        component: BrickForm,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/brick-form/:id',
        component: BrickForm,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/granit-bronz-memorial-printable-form',
        component: PrintableGranitBronzMemorialForm,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/granit-bronz-memorial-form',
        component: GranitBronzMemorialForm,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/granit-bronz-memorial-form/:id',
        component: GranitBronzMemorialForm,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/granit-bronz-precious-printable-form',
        component: PrintableGranitBronzPreciousForm,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/granit-bronz-precious-form',
        component: GranitBronzPreciousForm,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/granit-bronz-precious-form/:id',
        component: GranitBronzPreciousForm,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/monument-agreement',
        component: MonumentAgreementAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/monument-agreement/:id',
        component: MonumentAgreementAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/printable-monument-agreement',
        component: PrintableMonumentAgreement,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/monument-work-order',
        component: MonumentWorkOrderAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/monument-work-order/:id',
        component: MonumentWorkOrderAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/printable-monument-work-order',
        component: PrintableMonumentWorkOrder,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/final-date',
        component: FinalDateAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/final-date/:id',
        component: FinalDateAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/printable-final-date',
        component: PrintableFinalDate,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/printable-monument-order-notes',
        component: PrintableMonumentOrderNotes,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/monument-order-notes',
        component: MonumentOrderNotesAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/monument-order-notes/:id',
        component: MonumentOrderNotesAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/printable-porcelain',
        component: PrintablePorcelain,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/porcelain',
        component: PorcelainAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/porcelain/:id',
        component: PorcelainAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
    },
    {
        name: 'production_porcelain',
        path: '/production-porcelain/:id',
        component: PorcelainAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            props.production_id = +props.production_id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/printable-delivery-work-order',
        component: PrintableDeliveryWorkOrder,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/delivery-work-order',
        component: DeliveryWorkOrderAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/delivery-work-order/:id',
        component: DeliveryWorkOrderAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/memorial-production',
        component: MemorialProductionAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/memorial-production/:id',
        component: MemorialProductionAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/production-memorial/:id',
        component: MemorialProductionAdd,
        meta: { layout: Master },
        name: 'production_memorial',
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            props.production_id = +props.production_id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/printable-memorial-production',
        component: PrintableMemorialProduction,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/approval-monument',
        component: ApprovalMonumentAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/approval-monument/:id',
        component: ApprovalMonumentAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        name: 'production_approval',
        path: '/production-approval/:id',
        component: ApprovalMonumentAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            props.production_id = +props.production_id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/printable-approval-monument',
        component: PrintableApprovalMonument,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Collaboration Routes
     * */
    {
        path: '/collaborations',
        component: CollaborationAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/collaboration/:id',
        component: CollaborationAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/collaboration-list',
        component: CollaborationList,
        meta: { layout: Master },
        props: true,
        beforeEnter: isAuthenticated,
    },
    {
        path: '/upload-files/:id',
        component: CollaborationFileUpload,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/task-collaboration-list',
        component: TaskCollaborationReport,
        meta: { layout: Master },
        props: true,
        beforeEnter: isAuthenticated,
    },
    {
        path: '/correspondence-list',
        component: CorrespondanceReport,
        meta: { layout: Master },
        props: true,
        beforeEnter: isAuthenticated,
    },

    /**
     * Collaborator Routes
     */

    {
        path: '/collaborators',
        component: CollaboratorAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/collaborator/:id',
        component: CollaboratorAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/collaborator-list',
        component: CollaboratorList,
        meta: { layout: Master },
        props: true,
        beforeEnter: isAuthenticated,
    },

    /**
     * Collaborator Type Routes
     */
    {
        path: '/collaborator-types',
        component: CollaboratorTypeAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/collaborator-type/:id',
        component: CollaboratorTypeAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/collaboratorType-list',
        component: CollaboratorTypeList,
        meta: { layout: Master },
        props: true,
        beforeEnter: isAuthenticated,
    },


    // workorder 
    // Collaborator routes 

    {
        path: '/workorder-collaborator-list',
        component: WorkOrderCollaboratorList,
        meta: { layout: Master },
        props: true,
        beforeEnter: isAuthenticated,
    },
    {
        path: '/workorder-collaborators',
        component: WorkorderCollaboratorAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/workorder-collaborator/:id',
        component: WorkorderCollaboratorAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/work-order-collaboratorType-list',
        component: WorkOrderCollaboratorTypeList,
        meta: { layout: Master },
        props: true,
        beforeEnter: isAuthenticated,
    },

    {
        path: '/work-order-collaborator-types',
        component: WorkOrderCollaboratorTypeAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/work-order-collaborator-type/:id',
        component: WorkOrderCollaboratorTypeAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },


    /**
     * Accounting Routes
     * */
    {
        path: '/accountings',
        component: AccountingAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/accountings/:id',
        component: AccountingAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/accounting-list',
        component: AccountingList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Company Routes
     * */
    {
        path: '/company',
        component: CompanyAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/company/:id',
        component: CompanyAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/company-list',
        component: CompanyList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * User
     * */
    {
        path: '/user',
        component: UserAdd,
        beforeEnter: isAuthenticated,
        meta: { layout: Master },
    },
    {
        path: '/user-list',
        component: UserList,
        beforeEnter: isAuthenticated,
        meta: { layout: Master },
    },
    {
        path: '/user/:id',
        component: UserAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },

    /**
     * Paper Location
     * */
    {
        path: '/paper-location',
        component: PaperLocationAdd,
        beforeEnter: isAuthenticated,
        meta: { layout: Master },
    },
    {
        path: '/paper-location-list',
        component: PaperLocationList,
        beforeEnter: isAuthenticated,
        meta: { layout: Master },
    },
    {
        path: '/paper-location/:id',
        component: PaperLocationAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },

    /**
     * Department
     * */
    {
        path: '/department',
        component: DepartmentAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/department/:id',
        component: DepartmentAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/department-list',
        component: DepartmentList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Cost Per Squre Feet
     * */
    {
        path: '/cost-per-squre-feet',
        component: CostSqureFeetAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/cost-per-squre-feet/:id',
        component: CostSqureFeetAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/cost-per-squre-feet-list',
        component: CostSqureFeetList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Order status
     */
    {
        path: '/orderstatus',
        component: OrderStatusAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/orderstatus/:id',
        component: OrderStatusAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/order-status-list',
        component: OrderStatusList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    /**
     * Installation Routes
     * */
    {
        path: '/installation',
        component: InstallationAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/installation/:id',
        component: InstallationAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/installation-list',
        component: InstallationList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/printable-weekly-schedule',
        component: PrintableWeeklySchedule,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/weekly-schedule',
        component: WeeklyScheduleAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/weekly-schedule/:id',
        component: WeeklyScheduleAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/weekly-schedule-list',
        component: WeeklyScheduleList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/printable-installation-load',
        component: PrintableInstallationLoad,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/installation-load',
        component: InstallationLoadAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/installation-load/:id',
        component: InstallationLoadAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/installation-load-list',
        component: InstallationLoadList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/printable-truck-load',
        component: PrintableTruckLoad,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/truck-load',
        component: TruckLoadAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/truck-load-install',
        component: TruckLoadAddInstall,
        name: 'TruckLoadAddInstall',
        meta: { layout: Master },
        props: true,
        beforeEnter: isAuthenticated,
    },
    {
        path: '/truck-load/:id',
        component: TruckLoadAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/truck-load-list',
        component: TruckLoadList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/printable-installation-production',
        component: PrintableInstallationProduction,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/installation-production',
        component: InstallationProductionAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/installation-production/:id',
        component: InstallationProductionAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/installation-production-list',
        component: InstallationProductionList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    {
        path: '/printable-installation-checklist',
        component: PrintableInstallationChecklist,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/installation-check-list',
        component: InstallationCheckListAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/installation-check-list/:id',
        component: InstallationCheckListAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },

    /**
     * Product - Monument Type
     * */
    {
        path: '/monument-types',
        component: MonumentTypeAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/monument-types/:id',
        component: MonumentTypeAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/monument-type-list',
        component: MonumentTypeList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Product - Monument Side
     * */
    {
        path: '/monument-sides',
        component: MonumentSideAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/monument-sides/:id',
        component: MonumentSideAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/monument-side-list',
        component: MonumentSideList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    /**
     * Product Monument Polish
     */
    {
        path: '/monument-polish',
        component: MonumentPolishAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/monument-polish/:id',
        component: MonumentPolishAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/monument-polish-list',
        component: MonumentPolishList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    /**
     * Product - Monument Shape
     * */
    {
        path: '/monument-shapes',
        component: MonumentShapeAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/monument-shapes/:id',
        component: MonumentShapeAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/monument-shape-list',
        component: MonumentShapeList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Product - Monument Color
     * */
    {
        path: '/monument-colors',
        component: MonumentColorAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/monument-colors/:id',
        component: MonumentColorAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/monument-color-list',
        component: MonumentColorList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     *
     * Product Report Re Order Quantity
     */
    {
        path: '/reorder-quantity',
        component: ReOrderQuantityList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Cost of Production Inventory
     * ProductionInventory
     */
    {
        path: '/production-inventory',
        component: ProductionInventory,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Cost of Display Inventory
     * DisplayInventory
     */
    {
        path: '/display-inventory',
        component: DisplayInventory,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Sale by Product Report
     * SaleProductReport
     */
    {
        path: '/sale-product-report',
        component: SaleProductReport,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Price sheet By Number
     * PriceSheetByNumber
     */
    {
        path: '/price-sheet-number',
        component: PriceSheetByNumber,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Price Sheet By Number - Composite
     */
    {
        path: '/price-sheet-number-composite',
        component: PriceSheetByNumberComposite,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Price Sheet By Color & Type
     */
    {
        path: '/price-sheet-by-color-and-type',
        component: PriceSheetByColorAndType,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Sale Report
     */
    {
        path: '/sale-report',
        component: SaleReport,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Production Report
     */
    {
        path: '/production-report',
        component: ProductionReport,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * price-sheet-color-type-composite
     *
     */
    {
        path: '/price-sheet-color-type-composite',
        component: PriceSheetByColorAndTypeComposite,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Product - Monument
     * */
    {
        path: '/monuments',
        component: MonumentAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/monuments/:id',
        component: MonumentAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/monuments-list',
        component: MonumentList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        name: 'PriceEstimator',
        path: '/price-estimator-list',
        component: MonumentList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        name: 'QuotePriceEstimator',
        path: '/price-estimator',
        component: MonumentAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.quote_to_price_id = +props.quote_to_price_id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/price-estimator/:id',
        component: MonumentAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },

    /**
     *  Products Catalog
     */
    {
        path: '/product-catalog-list',
        component: ProductCatalogList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Product - Composite
     * */
    {
        path: '/composites',
        component: CompositeAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/composites/:id',
        component: CompositeAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/composite-list',
        component: CompositeList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,

    },

    /**
     * Product - Composite Category
     * */
    {
        path: '/composite-categories',
        component: CompositeCategoryAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/composite-categories/:id',
        component: CompositeCategoryAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/composite-category-list',
        component: CompositeCategoryList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,

    },

    /**
     * Product - Simple
     * */
    {
        path: '/simples',
        component: SimpleAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/simples/:id',
        component: SimpleAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/simple-list',
        component: SimpleList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Product - Simple Category
     * */
    {
        path: '/simple-categories',
        component: SimpleCategoryAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/simple-categories/:id',
        component: SimpleCategoryAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/simple-category-list',
        component: SimpleCategoryList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,

    },

    /**
     * Product - Service
     * */
    {
        path: '/services',
        component: ServiceAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/services/:id',
        component: ServiceAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/service-list',
        component: ServiceList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Product - Service Category
     * */
    {
        path: '/service-categories',
        component: ServiceCategoryAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/service-categories/:id',
        component: ServiceCategoryAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/service-category-list',
        component: ServiceCategoryList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * User Role
     * */
    {
        path: '/roles-manager/',
        component: RolesAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/roles-manager/:id',
        component: RolesAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/roles-list',
        component: RolesList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Supplier
     * */
    {
        path: '/supplier',
        component: SupplierAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/supplier/:id',
        component: SupplierAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/supplier-list',
        component: SupplierList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * Equipment
     * */
    {
        path: '/equipment',
        component: EquipmentAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/equipment/:id',
        component: EquipmentAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/equipment-list',
        component: EquipmentList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

    /**
     * customer invoice
     */
    {
        path: '/customer-portal',
        component: CustomerPortal,
        meta: { layout: CustomerMaster },
        name: 'CustomerPortal',
        beforeEnter: isAuthenticated,
    },
    {
        path: '/invoice-list',
        component: CustomerInvoiceList,
        meta: { layout: CustomerMaster },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/customer-invoice/:id',
        component: CustomerInvoice,
        meta: { layout: CustomerMaster },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },

    /**
     * customer order status
     */
    {
        path: '/customer-order-status-list',
        component: CustomerOrderStatusList,
        meta: { layout: CustomerMaster },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/customer-order-status/:id',
        component: CustomerOrderStatus,
        meta: { layout: CustomerMaster },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },

    /**
     * customer approval routes
     */
    {
        path: '/customer-approval-list',
        component: CustomerApprovalList,
        meta: { layout: CustomerMaster },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/customer-approval/:id',
        component: CustomerApproval,
        meta: { layout: CustomerMaster },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },

    /**
     * customer collaboration routes
     */
    {
        path: '/customer-collaboration-list',
        component: CustomerCollaborationList,
        meta: { layout: CustomerMaster },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/customer-collaboration/:id',
        component: CustomerCollaboration,
        meta: { layout: CustomerMaster },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },


    /**
     *
     * purchase order
     */
    {
        path: '/purchase-order',
        component: PoAdd,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/purchase-order/:id',
        component: PoAdd,
        meta: { layout: Master },
        props(route) {
            const props = { ...route.params };
            props.id = +props.id;
            return props;
        },
        beforeEnter: isAuthenticated,
    },
    {
        path: '/purchase-order-list',
        component: PoList,
        meta: { layout: Master },
        beforeEnter: isAuthenticated,
    },

];

export default routes;
