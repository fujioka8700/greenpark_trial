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
