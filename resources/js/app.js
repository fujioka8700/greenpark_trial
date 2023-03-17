import "./bootstrap";

import { createApp, markRaw } from "vue";
import { createPinia } from "pinia";
import { useStoreAuth } from "./store/auth";
import router from "./router";
import App from "./App.vue";

const pinia = createPinia();
const app = createApp(App);

/**
 * Piniaのactionから、
 * Vue Routerを使ってルーティングするための設定です。
 */
pinia.use(({ store }) => {
  store.router = markRaw(router);
});

app.use(pinia);

const getAuth = async () => {
  const store = useStoreAuth();
  await store.currentUser();

  app.use(router);
  app.mount("#app");
};

getAuth();
