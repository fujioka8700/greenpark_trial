import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/about",
      name: "About",
      component: () => import("../components/pages/About.vue"),
    },
    {
      path: "/login",
      name: "Login",
      component: () => import("../components/pages/Login.vue"),
    },
    {
      path: "/register",
      name: "Register",
      component: () => import("../components/pages/Register.vue"),
    },
  ],
});

export default router;
