import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/login",
      name: "Login",
      component: () => import("../components/pages/Login.vue"),
    },
    {
      path: "/about",
      name: "About",
      component: () => import("../components/pages/About.vue"),
    },
  ],
});

export default router;
