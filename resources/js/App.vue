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
</script>

<style lang="scss" scoped></style>
