import { createRouter, createWebHistory } from "vue-router";
import AppLayout from "@/layouts/admin/AppLayout.vue";
import GuestLayout from "@/layouts/admin/GuestLayout.vue";

const guest = (to, from, next) => {
  if (localStorage.getItem("access_token")) {
    return next({ name: "dashboard" });
  }
  next();
};

const auth = (to, from, next) => {
  if (!localStorage.getItem("access_token")) {
    return next({ name: "login" });
  }
  next();
};

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      component: AppLayout,
      beforeEnter: auth,
      children: [
        {
          path: "/",
          name: "dashboard",
          component: () => import("@/views/Dashboard.vue"),
        },
        {
          path: "/exercises",
          name: "exercises.index",
          component: () => import("@/views/exercises/Index.vue"),
        },
        {
          path: "/exercises/edit/:id",
          name: "exercises.edit",
          component: () => import("@/views/exercises/Edit.vue"),
        },
        {
          path: "/exercises/create",
          name: "exercises.create",
          component: () => import("@/views/exercises/Create.vue"),
        },
        {
          path: "/equipments",
          name: "equipments.index",
          component: () => import("@/views/equipments/Index.vue"),
        },
        {
          path: "/muscles",
          name: "muscles.index",
          component: () => import("@/views/muscles/Index.vue"),
        },
      ],
    },
    {
      path: "/",
      component: GuestLayout,
      beforeEnter: guest,
      children: [
        {
          path: "/auth/login",
          name: "login",
          component: () => import("@/views/auth/LoginView.vue"),
        },
      ],
    },
    // {
    //   path: "/pages/notfound",
    //   name: "notfound",
    //   component: () => import("@/views/pages/NotFound.vue"),
    // },

    // {
    //   path: "/auth/access",
    //   name: "accessDenied",
    //   component: () => import("@/views/pages/auth/Access.vue"),
    // },
    // {
    //   path: "/auth/error",
    //   name: "error",
    //   component: () => import("@/views/pages/auth/Error.vue"),
    // },
  ],
});

export default router;
