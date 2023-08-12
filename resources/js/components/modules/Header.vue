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
            <h1 class="text-h4 pl-2 logo">GreenPark</h1>
          </div>
        </RouterLink>
      </v-app-bar-title>

      <!-- PC版メニュー、始まり -->
      <div class="d-none d-sm-flex">
        <MainNavigation />
      </div>
      <!-- PC版メニュー、終わり -->
      <div class="d-flex d-sm-none">
        <HamburgerMenu @drawerParent="toggleDrawer" />
      </div>
    </v-container>
  </v-app-bar>
  <!-- スマホ版メニュー、始まり -->
  <DrawerMenu ref="drawerMenu" />
  <!-- スマホ版メニュー、終わり -->
</template>

<script setup>
import MainNavigation from "./MainNavigation.vue";
import HamburgerMenu from "./HamburgerMenu.vue";
import DrawerMenu from "./DrawerMenu.vue";
import { ref } from "vue";

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
$logo-size: 38px;

.v-application {
  .p-header {
    &-img {
      width: $logo-size;
    }
  }
}
</style>
