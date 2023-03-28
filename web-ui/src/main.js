import "./bootstrap";
import { createApp } from "vue";
import "primevue/resources/themes/lara-light-indigo/theme.css";  
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";
import "@/styles/main.css";
import App from "./App.vue";
import router from "./router";
import { createPinia } from "pinia";

import PrimeVue from "primevue/config";
import ToastService from "primevue/toastservice";
import ConfirmationService from "primevue/confirmationservice";
import { registerGlobalComponents } from "./utils/import";

const app = createApp(App);
app.use(router);
app.use(createPinia());
app.use(PrimeVue, { ripple: true });
app.use(ToastService);
app.use(ConfirmationService);
registerGlobalComponents(app);
app.mount("#app");
