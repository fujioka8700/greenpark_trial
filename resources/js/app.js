import "./bootstrap";

import { createApp, markRaw } from "vue";
import { createPinia } from "pinia";
import { useStoreAuth } from "./store/auth";
import router from "./router";
import App from "./App.vue";

// Vuetify
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import "@mdi/font/css/materialdesignicons.css";

const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: "mdi",
  },
});

const pinia = createPinia();
const app = createApp(App);

pinia.use(({ store }) => {
  /**
   * Piniaのactionから、
   * Vue Routerを使ってルーティングするための設定
   */
  store.router = markRaw(router);
});

app.use(pinia);

/**
 * ログイン中のユーザー情報を取得後、Vue インスタンスをマウントする
 */
const createAppVue = async () => {
  /** Vue マウント前に、ログイン中のユーザー情報を取得する */
  const auth = useStoreAuth();
  await auth.currentUser();

  app.use(router);
  app.use(vuetify);
  app.mount("#app");
};

createAppVue();
