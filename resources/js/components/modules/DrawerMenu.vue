<template>
  <div>
    <v-navigation-drawer v-model="drawer" location="right" temporary>
      <v-list>
        <!-- メインコンテンツ、始まり -->
        <v-list-item
          v-for="(item, index) in menuList"
          :key="index"
          @click.stop="movePage(item.dest)"
          link
        >
          <template v-slot:prepend>
            <v-icon :icon="item.icon"></v-icon>
          </template>
          <template v-if="item.title === 'ユーザー'">
            <!-- ログイン中の、ユーザー名を表示する -->
            <v-list-item-title v-text="user.name"></v-list-item-title>
          </template>
          <template v-else>
            <v-list-item-title v-text="item.title"></v-list-item-title>
          </template>
        </v-list-item>
        <!-- メインコンテンツ、終わり -->

        <!-- 補足情報、始まり -->
        <v-list-item
          variant="tonal"
          v-for="(link, index) in links"
          :key="index"
          @click.stop="movePage(link.dest)"
          link
        >
          <template v-slot:prepend>
            <v-icon :icon="link.icon"></v-icon>
          </template>
          <v-list-item-title v-text="link.title"></v-list-item-title>
        </v-list-item>
        <!-- 補足情報、終わり -->
      </v-list>

      <!-- Copyright -->
      <p class="text-caption drawer_menu_copyright">
        &copy; {{ new Date().getFullYear() }} GreenPark
      </p>
    </v-navigation-drawer>
  </div>
</template>

<script setup>
import { menuItems, links } from "../../util";
import { useStoreAuth } from "../../store/auth";
import { storeToRefs } from "pinia";
import { ref, computed } from "vue";
import { useRouter } from "vue-router";

const auth = useStoreAuth();
const { user } = storeToRefs(auth);

const router = useRouter();

/** @type {boolean} ドロワーメニューの開閉 */
const drawer = ref(false);

/**
 * 未ログインなら、
 * 「TOPページ、会員登録、ログイン」を表示する
 * ログイン中なら、
 * 「TOPページ、植物登録、ログイン中ユーザー名」を表示する
 */
const menuList = computed(() => {
  let removals = [];

  if (user.value === null) {
    removals = ["植物登録", "ユーザー"];
  } else {
    removals = ["会員登録", "ログイン"];
  }

  return menuItems.filter((v) => {
    return !removals.includes(v.title);
  });
});

const toggleDrawer = () => {
  drawer.value = !drawer.value;
};

/**
 * ページ遷移後、ドロワーメニューを閉じる
 * @param {String} dest
 */
const movePage = (dest) => {
  switch (dest) {
    case "top":
      router.push({ name: "PlantPlaces" });
      break;
    case "register":
      router.push({ name: "Register" });
      break;
    case "login":
      router.push({ name: "Login" });
      break;
    case "storePlant":
      router.push({ name: "StorePlant" });
      break;
    case "about":
      router.push({ name: "About" });
      break;
    case "information":
      router.push({ name: "Information" });
      break;
    case "rules":
      router.push({ name: "Rules" });
      break;
    case "privacy":
      router.push({ name: "Privacy" });
      break;
    default:
      break;
  }

  drawer.value = !drawer.value;
};

defineExpose({
  toggleDrawer,
});
</script>

<style lang="scss" scoped>
.drawer_menu_copyright {
  width: 100%;
  position: absolute;
  bottom: 0;
  text-align: center;
}
</style>
