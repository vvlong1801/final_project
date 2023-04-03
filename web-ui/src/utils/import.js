import { defineAsyncComponent } from "vue";

export function registerGlobalComponents(app) {
  //==========button==========
  app.component(
    "Button",
    defineAsyncComponent(() => import("primevue/button"))
  );

  //==========form==========
  app.component(
    "InputText",
    defineAsyncComponent(() => import("primevue/inputtext"))
  );
  app.component(
    "Textarea",
    defineAsyncComponent(() => import("primevue/textarea"))
  );
  app.component(
    "Dropdown",
    defineAsyncComponent(() => import("primevue/dropdown"))
  );
  app.component(
    "MultiSelect",
    defineAsyncComponent(() => import("primevue/multiselect"))
  );

  //==========data==========
  app.component(
    "DataView",
    defineAsyncComponent(() => import("primevue/dataview"))
  );
  app.component(
    "Paginator",
    defineAsyncComponent(() => import("primevue/paginator"))
  );

  //==========message==========
  app.component(
    "Toast",
    defineAsyncComponent(() => import("primevue/toast"))
  );
  app.component(
    "Message",
    defineAsyncComponent(() => import("primevue/message"))
  );

  //==========media==========
  app.component(
    "Image",
    defineAsyncComponent(() => import("primevue/image"))
  );

  //==========panel==========
  app.component(
    "Toolbar",
    defineAsyncComponent(() => import("primevue/toolbar"))
  );
  app.component(
    "Card",
    defineAsyncComponent(() => import("primevue/card"))
  );
  app.component(
    "Divider",
    defineAsyncComponent(() => import("primevue/divider"))
  );

  //==========overlay==========
  app.component(
    "Dialog",
    defineAsyncComponent(() => import("primevue/dialog"))
  );

  app.component(
    "ConfirmDialog",
    defineAsyncComponent(() => import("primevue/confirmdialog"))
  );

  //==========overlay==========
  app.component(
    "Badge",
    defineAsyncComponent(() => import("primevue/badge"))
  );
}
