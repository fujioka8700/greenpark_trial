<template>
  <v-app>
    <Header />
    <v-main>
      <v-sheet max-width="1020" class="mx-auto">
        <RouterView />
      </v-sheet>
    </v-main>
  </v-app>
</template>

<script setup>
import Header from "./components/modules/Header.vue";
import { useStoreNewBreadCrumbs } from "./store/newBreadCrumbs";
import { watch } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const newBreadCrumbs = useStoreNewBreadCrumbs();

watch(route, () => {
  if (route.path === "/") {
    newBreadCrumbs.$reset();
  }
});
</script>

<style lang="scss" scoped></style>
