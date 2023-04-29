<template>
  <v-app>
    <Header />
    <v-main>
      <RouterView />
    </v-main>
  </v-app>
</template>

<script setup>
import Header from "./components/modules/Header.vue";
</script>

<style lang="scss" scoped></style>
