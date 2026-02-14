import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';

Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: "font-weight-bold",
    base: '/',
    routes,
});
router.beforeEach((to, from, next) => {
    NProgress.configure({showSpinner: false});
    if (window.detectChanges && !confirm('You have unsaved changes. Are you sure you want to navigate away?')) {
        console.log("MPS");
    } else {
        window.detectChanges = false;
        NProgress.start();
        next();
    }

})
router.afterEach(() => {
    NProgress.done()
})

export default router;


