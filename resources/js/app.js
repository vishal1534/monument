import Vue from 'vue';
import App from './layout/App';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import './styles/custom.css';
import './styles/toolbar.css';
import './styles/print.css';
import axios from 'axios';
import store from './store/store';
import router from './router';
import VueMeta from 'vue-meta';
Vue.use(VueMeta);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);




Vue.config.productionTip = false;

Vue.mixin({
    created() {
        // console.log('[component created] ' + this.$options.name)
    },
});


new Vue({
    router,
    store,
    axios,
    ...App
});


