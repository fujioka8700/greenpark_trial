import { useStoreAuth } from "../store/auth";
import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(),
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      // 戻るや進むの場合は、ページ遷移前のスクロール位置を維持する
      return savedPosition;
    } else {
      // ページ遷移時にスクロール位置をトップにする
      return {
        top: 0,
      };
    }
  },
  routes: [
    {
      path: "/",
      name: "Home",
      component: () => import("../components/pages/Home.vue"),
      children: [
        {
          path: "",
          name: "PlantPlaces",
          component: () => import("../components/modules/PlantPlaces.vue"),
        },
        {
          path: "/plants/search",
          name: "PlantItems",
          component: () => import("../components/modules/PlantItems.vue"),
        },
        {
          path: "/plants/:plantId",
          name: "PlantItem",
          component: () => import("../components/modules/PlantItem.vue"),
          props: true,
        },
      ],
    },
    {
      path: "/about",
      name: "About",
      component: () => import("../components/pages/About.vue"),
      beforeEnter: async (to, from) => {
        /** ログイン中のユーザー情報を取得する */
        const auth = useStoreAuth();
        await auth.currentUser();

        const isAuthenticated = auth.user;

        /** 未ログインなら、Aboutページは表示させない。 */
        if (!isAuthenticated && to.name !== "Home") {
          return { name: "Home" };
        }
      },
    },
    {
      path: "/contact",
      name: "Contact",
      component: () => import("../components/pages/Contact.vue"),
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
    {
      path: "/rules",
      name: "Rules",
      component: () => import("../components/pages/Rules.vue"),
    },
    {
      path: "/sample",
      name: "Sample",
      component: () => import("../components/pages/Sample.vue"),
    },
    {
      path: "/store-plant",
      name: "StorePlant",
      component: () => import("../components/pages/StorePlant.vue"),
    },
    {
      path: "/plants/:plantId/update",
      name: "UpdatePlant",
      props: (route) => ({
        plantId: Number(route.params.plantId),
      }),
      component: () => import("../components/pages/UpdatePlant.vue"),
    },
    {
      path: "/:pathMatch(.*)*",
      name: "NotFound",
      component: () => import("../components/pages/NotFound.vue"),
    },
  ],
});

router.beforeEach((to, from) => {
  /** ログイン中のユーザー情報を取得する */
  const auth = useStoreAuth();

  const isAuthenticated = auth.user;

  /** ログイン済みなら、ログインページと会員登録ページは、表示させない。 */
  if (isAuthenticated && (to.name === "Login" || to.name === "Register")) {
    return { name: "Home" };
  }
});

export default router;
