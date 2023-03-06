import "./bootstrap";
import { createApp } from "vue";
import "@/styles/main.css";
import 'primeicons/primeicons.css';
import App from "./App.vue";
import router from "./router";
import { createPinia } from "pinia";

import PrimeVue from "primevue/config";
import ToastService from "primevue/toastservice";
import { registerGlobalComponents } from "./utils/import";

const app = createApp(App);
app.use(router);
app.use(createPinia());
app.use(PrimeVue);
app.use(ToastService);
registerGlobalComponents(app);
app.mount("#app");
