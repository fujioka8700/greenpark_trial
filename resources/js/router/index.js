import { createRouter, createWebHistory } from "vue-router";
import { useStoreAuth } from "../store/auth";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/login",
      name: "Login",
      component: () => import("../components/pages/Login.vue"),
      beforeEnter: async (to, from) => {
        const store = useStoreAuth();
        const isLoggedIn = await store.currentUser();

        if (isLoggedIn) {
          return { name: "About" };
        }
      },
    },
    {
      path: "/about",
      name: "About",
      component: () => import("../components/pages/About.vue"),
      beforeEnter: async (to, from) => {
        const store = useStoreAuth();
        const isLoggedIn = await store.currentUser();

        if (isLoggedIn !== true) {
          return { name: "Login" };
        }
      },
    },
  ],
});

router.beforeEach(async (to, from) => {
  const store = useStoreAuth();
  store.currentUser();
});

export default router;
