import './bootstrap';
import { createApp, markRaw } from 'vue/dist/vue.esm-bundler';
import App from './web/App.vue';
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
/*import { createVuetify } from 'vuetify'*/
import vuetify from "./plugins/vuetify.js";
import router from "./router/index.js";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import Vue3Toasity from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

import { createPinia } from 'pinia';
import  createPersistedState  from 'pinia-plugin-persistedstate';
import axios from 'axios';

window.axios = axios
window.axios.defaults.headers.common['Accept'] = 'application/json';
window.axios.defaults.headers.common['Content-Type'] = 'application/json';
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;


const pinia = createPinia()
pinia.use(({store}) =>{
  store.router = markRaw(router)
})
pinia.use(createPersistedState)


const app = createApp(App)

app.use(
  Vue3Toasity,
  {
    autoClose: 3000,
  }
)

app.use(pinia)
app.use(vuetify)
app.component('VueDatePicker', VueDatePicker);

app.use(router);
app.mount('#app');


