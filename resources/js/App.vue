<template>
  <div>
    <v-app>
      <Header />
      <v-main>
        <RouterView />
      </v-main>
    </v-app>
  </div>
</template>

<script setup>
import Header from "./components/modules/Header.vue";
</script>

<style lang="scss" scoped></style>
