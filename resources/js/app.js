import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';
import App from './web/App.vue';
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
/*import { createVuetify } from 'vuetify'*/
import vuetify from "./plugins/vuetify.js";
import router from "./router/index.js";


const app = createApp(App);



app.use(vuetify)


app.use(router);
app.mount('#app');


