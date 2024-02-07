import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';
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

const app = createApp(App).use(
    Vue3Toasity,
    {
      autoClose: 3000,
    }
  )



app.use(vuetify)
app.component('VueDatePicker', VueDatePicker);

app.use(router);
app.mount('#app');


