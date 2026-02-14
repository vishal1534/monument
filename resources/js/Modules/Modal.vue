<template>
    <div>
        <!-- The modal -->
        <b-modal id="view-modal"
                 size="xl"
                 scrollable
                 ok-only
                 ok-title="Cancel"
                 modal-class="custom-modal-size"
                 ok-variant="secondary"
                 :title="title">
            <component :is="module" :id="recordID" :hide-in-modal="true" ></component>
        </b-modal>
    </div>
</template>

<script>
    import Quote from "../pages/quote/Add";
    import Order from "../pages/order/Add";
    import Cemetery from "../pages/cemetery/Add";
    import CemeteryCategory from '../pages/cemetery-category/Add';
    import Department from "../pages/setting/department/Add";
    import Service from "../pages/service/Add";
    import ServiceCategory from "../pages/service-category/Add";
    import Simple from "../pages/simple-product/Add";
    import SimpleCategory from "../pages/simple-category/Add";
    import Composite from "../pages/composite/Add";
    import CompositeCategory from "../pages/composite-category/Add";
    import Accounting from "../pages/accounting/Add";
    import Company from "../pages/company/Add";
    import User from '../pages/user/Add';
    import UserRole from '../pages/user-role/Add';
    import PaperLocation from '../pages/setting/paper-location/Add';
    import Resources from '../pages/setting/resource/Add';
    import OrderStatus from '../pages/setting/order-status/Add';
    import Production from "../pages/production/Add";
    import Collaboration from "../pages/collaboration/Add";
    import Monument from "../pages/product-monument/Add";
    import MonumentType from "../pages/monument-type/Add";
    import MonumentColor from "../pages/monument-color/Add";
    import MonumentSide from "../pages/monument-side/Add";
    import MonumentPolish from "../pages/monument-polish/Add";
    import MonumentShape from "../pages/monument-shape/Add";
    import Installation from "../pages/installation/Add";
    import ProductionPicture from "../pages/production/Forms/picture-production/Add";
    import ProductionSandBlasting from "../pages/production/Forms/sandblasting-production/Add";
    import InstallationDailyLoad from "../pages/installation/daily-paperwork/installation-load/Add";
    import WorkOrder from '../pages/maintenance/work-order/Add';
    import Supplier from '../pages/purchasing/supplier/Add';
    import PurchaseOrder from '../pages/purchasing/PO/Add';
    import Equipment from '../pages/maintenance/equipment/Add';
    import Invoice from "../pages/customer-invoice/Invoice";
    import Collaborator from '../pages/collaborator/Add';
    import CollaboratorType from '../pages/collaborator-type/Add';
    import TruckLoadList from '../pages/installation/daily-paperwork/truck-load/Add';
    import weeklySchedule from '../pages/installation/weekly-schedule/Add';
    import installationProduction from "../pages/installation/daily-paperwork/installation-production/Add";
    import CostPSqureFeet from '../pages/setting/cost-per-squre-feet/Add';
    export default {
        name: "Modal",
        props: {
            title: {
                type: String
            },
            module: {
                type: String
            },
            recordID: {
              type: Number
            }
        },
        components:{
            Quote,
            Order,
            Cemetery,
            CemeteryCategory,
            Department,
            Service,
            ServiceCategory,
            Simple,
            SimpleCategory,
            Composite,
            CompositeCategory,
            Accounting,
            Company,
            User,
            UserRole,
            PaperLocation,
            Resources,
            OrderStatus,
            Production,
            Monument,
            MonumentType,
            MonumentSide,
            MonumentPolish,
            MonumentShape,
            MonumentColor,
            Installation,
            ProductionPicture,
            ProductionSandBlasting,
            InstallationDailyLoad,
            Collaboration,
            WorkOrder,
            Supplier,
            PurchaseOrder,
            Equipment,
            Invoice,
            Collaborator,
            CollaboratorType,
            TruckLoadList,
            weeklySchedule,
            installationProduction,
            CostPSqureFeet
        }
    }
</script>

<style scoped>
    /deep/  .custom-modal-size{
        /*min-width: 1300px;*/
        /*overflow: auto !important;*/
    }
</style>
