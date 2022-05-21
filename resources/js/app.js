// require('./bootstrap');
import Vue from 'vue';
import { createInertiaApp,Link } from '@inertiajs/inertia-vue';
import VueToastr from "vue-toastr";
import VueConfirmDialog from 'vue-confirm-dialog'

Vue.use(VueConfirmDialog);
Vue.component('vue-confirm-dialog', VueConfirmDialog.default);
Vue.use(VueToastr);
Vue.component("inertia-link", Link);


createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    Vue.use(plugin)

    new Vue({
      render: h => h(App, props),
    }).$mount(el)
  },
})
