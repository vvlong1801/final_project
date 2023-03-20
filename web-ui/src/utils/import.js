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

  //==========data==========
  app.component(
    "DataView",
    defineAsyncComponent(() => import("primevue/dataview"))
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

  //==========overlay==========
  app.component(
    "Dialog",
    defineAsyncComponent(() => import("primevue/dialog"))
  );
}
