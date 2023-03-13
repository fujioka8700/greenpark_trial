import "./bootstrap";

import { createApp } from "vue";
import { createPinia } from "pinia";
import { useStoreAuth } from "./store/auth";
import router from "./router";
import App from "./App.vue";

const pinia = createPinia();
const app = createApp(App);

app.use(pinia);

const getAuth = async () => {
  const store = useStoreAuth();
  await store.currentUser();

  app.use(router);
  app.mount("#app");
};

getAuth();
