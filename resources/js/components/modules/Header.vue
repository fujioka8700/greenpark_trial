<template>
  <div>
    <v-app-bar :elevation="2" color="green" density="compact">
      <v-app-bar-title>
        <RouterLink
          class="text-decoration-none text-white"
          :to="{ name: 'PlantPlaces' }"
          >植物図鑑</RouterLink
        >
      </v-app-bar-title>
      <template v-slot:append>
        <div v-if="user">
          <v-btn variant="text">
            <RouterLink
              class="text-decoration-none text-white"
              :to="{ name: 'StorePlant' }"
              >植物登録</RouterLink
            ></v-btn
          >
          <v-btn variant="text">
            <RouterLink
              class="text-decoration-none text-white"
              :to="{ name: 'About' }"
              >{{ user.name }}</RouterLink
            ></v-btn
          >
        </div>
        <div v-else>
          <v-btn variant="text">
            <RouterLink
              class="text-decoration-none text-white"
              :to="{ name: 'Register' }"
              >会員登録</RouterLink
            ></v-btn
          >
          <v-btn variant="text">
            <RouterLink
              class="text-decoration-none text-white"
              :to="{ name: 'Login' }"
              >ログイン</RouterLink
            ></v-btn
          >
        </div>
      </template>
    </v-app-bar>
  </div>
</template>

<script setup>
import { useStoreAuth } from "../../store/auth";
import { storeToRefs } from "pinia";

const auth = useStoreAuth();
const { user } = storeToRefs(auth);
</script>

<style lang="scss" scoped></style>
