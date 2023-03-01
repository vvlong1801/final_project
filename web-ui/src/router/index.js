import { createRouter, createWebHistory } from "vue-router";
import { ADMIN_LAYOUT, GUEST_LAYOUT } from "@/utils/constants";

const auth = (to, from, next) => {
  if (!localStorage.getItem("access_token")) {
    return next({ name: "Login" });
  }

  next();
};

const guest = (to, from, next) => {
  if (localStorage.getItem("access_token")) {
    return next({ name: "Dashboard" });
  }
  next();
};

const routes = [
  {
    path: "/",
    beforeEnter: auth,
    component: () => import("@/layouts/admin/AdminLayout.vue"),
    children: [
      {
        path: "/",
        name: "Dashboard",
        component: () => import("@/view/DashboardView.vue"),
      },
      {
        path: "/exercises",
        name: "Exercise.index",
        component: () => import("@/view/exercises/IndexView.vue"),
      },
      {
        path: "/exercises/new",
        name: "Exercise.create",
        component: () => import("@/view/exercises/CreateView.vue"),
      },
      {
        path: "/equipments",
        name: "Equipment.index",
        component: () => import("@/view/equipments/IndexView.vue"),
      },
      {
        path: "/muscles",
        name: "Muscle.index",
        component: () => import("@/view/muscles/IndexView.vue"),
      },
    ],
  },
  {
    path: "/",
    beforeEnter: guest,
    component: () => import("@/layouts/admin/GuestLayout.vue"),
    children: [
      {
        path: "/login",
        name: "Login",
        component: () => import("@/view/auth/LoginView.vue"),
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: routes,
});

export default router;
