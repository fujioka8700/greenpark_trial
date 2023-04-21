<template>
  <div>
    <v-app>
      <Header />
      <RouterView />
    </v-app>
  </div>
</template>

<script setup>
import Header from "./components/modules/Header.vue";
</script>

<style lang="scss" scoped></style>
