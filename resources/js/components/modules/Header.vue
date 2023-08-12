<template>
  <v-app-bar :elevation="2" color="success" density="compact">
    <v-container class="d-flex align-center">
      <v-app-bar-title>
        <RouterLink
          class="text-decoration-none text-white"
          :to="{ name: 'PlantPlaces' }"
        >
          <div class="d-flex align-center">
            <img
              src="../../../../../storage/design/logo.png"
              class="p-header-img"
            />
            <h1 class="text-h4 pl-2 p-header-logo">GreenPark</h1>
          </div>
        </RouterLink>
      </v-app-bar-title>

      <!-- PC版メニュー、始まり -->
      <div class="d-none d-sm-flex">
        <template v-if="user">
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
        </template>
        <template v-else>
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
        </template>
      </div>
      <!-- PC版メニュー、終わり -->
      <div class="d-flex d-sm-none">
        <HamburgerMenu @drawerParent="toggleDrawer" />
      </div>
    </v-container>
  </v-app-bar>
  <DrawerMenu ref="drawerMenu" />
</template>

<script setup>
import HamburgerMenu from "./HamburgerMenu.vue";
import DrawerMenu from "./DrawerMenu.vue";
import { useStoreAuth } from "../../store/auth";
import { storeToRefs } from "pinia";
import { ref } from "vue";

const auth = useStoreAuth();
const { user } = storeToRefs(auth);

const drawerMenu = ref();

/**
 * テンプレート参照にて、
 * DrawerMenuコンポーネントのtoggleDrawerメソッドを実行する。
 */
const toggleDrawer = () => {
  drawerMenu.value.toggleDrawer();
};
</script>

<style lang="scss" scoped>
.v-application {
  .p-header {
    &-img {
      width: 38px;
    }

    &-logo {
      font-family: "Righteous", cursive !important;
    }
  }
}
</style>
