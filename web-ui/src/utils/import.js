import { defineAsyncComponent } from "vue";

export function registerGlobalComponents(app) {
  app.component(
    "admin-layout",
    defineAsyncComponent(() => import("@/layouts/AdminLayout.vue"))
  );

  app.component(
    "app-layout",
    defineAsyncComponent(() => import("@/layouts/AppLayout.vue"))
  );

  app.component(
    "guest-layout",
    defineAsyncComponent(() => import("@/layouts/GuestLayout.vue"))
  );

  app.component("validation-error", defineAsyncComponent(() => import("@/components/ValidationError.vue")));
}
