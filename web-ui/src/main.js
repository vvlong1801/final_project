import "@/bootstrap.js";

import { createApp } from "vue";
import "@/styles/main.css";
import App from "./App.vue";
import router from "./router";
import { createPinia } from "pinia";
import { registerGlobalComponents } from "@/utils/import";
/* import the fontawesome core */
import { library } from "@fortawesome/fontawesome-svg-core";

/* import font awesome icon component */
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

/* import specific icons */
import {
  faUserSecret,
  faPlus,
  faPencil,
  faTrashCan,
} from "@fortawesome/free-solid-svg-icons";
library.add([faUserSecret, faPlus, faPencil, faTrashCan]);

const app = createApp(App);
app.use(router);
app.use(createPinia());
app.component("font-awesome-icon", FontAwesomeIcon);
registerGlobalComponents(app);
app.mount("#app");
