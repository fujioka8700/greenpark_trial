<template>
  <v-app-bar :elevation="2" color="success" density="compact" height="80">
    <v-container class="d-flex align-center">
      <v-app-bar-title>
        <RouterLink
          class="text-decoration-none text-white"
          :to="{ name: 'PlantPlaces' }"
        >
          <div class="d-flex align-center">
            <div>
              <img src="/storage/design/logo.png" class="p-header-img" />
            </div>
            <div>
              <div class="text-caption pl-2 logo-text__lead">
                場所から探す植物図鑑
              </div>
              <div>
                <h1 class="text-h4 pl-2 logo logo-text">GreenPark</h1>
              </div>
            </div>
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
$logo-size: 43px;
$line-height: 1em;
$letter-spacing: 0.1em;

.p-header-img {
  width: $logo-size;
}

.v-application {
  .logo-text {
    line-height: $line-height;

    &__lead {
      line-height: $line-height;
      letter-spacing: $letter-spacing !important;
    }
  }
}
</style>
