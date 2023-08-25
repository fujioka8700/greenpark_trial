<template>
  <v-app>
    <Header />
    <v-main>
      <v-sheet max-width="1020" min-height="85vh" class="mx-auto">
        <RouterView />
      </v-sheet>
    </v-main>
    <Footer />
  </v-app>
</template>

<script setup>
import Footer from "./components/modules/Footer.vue";
import Header from "./components/modules/Header.vue";
import { useStoreBreadCrumbs } from "./store/breadCrumbs";
import { watch } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const breadCrumbs = useStoreBreadCrumbs();

watch(route, () => {
  if (route.path === "/") {
    breadCrumbs.$reset();
  }
});
</script>

<style lang="scss" scoped></style>
