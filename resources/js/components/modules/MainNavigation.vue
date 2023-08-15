<template>
  <div v-for="(item, index) in menuList" :key="index">
    <v-btn class="text-none" @click.stop="movePage(item.dest)">
      <template v-slot:prepend>
        <v-icon :icon="item.icon"></v-icon>
      </template>
      <template v-if="item.title === 'ユーザー'">
        <!-- ログイン中の、ユーザー名を表示する -->
        {{ user.name }}
      </template>
      <template v-else>
        {{ item.title }}
      </template>
    </v-btn>
  </div>
</template>

<script setup>
import { menuItems } from "../../util";
import { useStoreAuth } from "../../store/auth";
import { storeToRefs } from "pinia";
import { computed } from "vue";
import { useRouter } from "vue-router";

const auth = useStoreAuth();
const { user } = storeToRefs(auth);

const router = useRouter();

/**
 * 未ログインなら、
 * 「会員登録、ログイン」を表示する
 * ログイン中なら、
 * 「植物登録、ログイン中ユーザー名」を表示する
 */
const menuList = computed(() => {
  let removals = [];

  if (user.value === null) {
    removals = ["TOPページ", "植物登録", "ユーザー"];
  } else {
    removals = ["TOPページ", "会員登録", "ログイン"];
  }

  return menuItems.filter((v) => {
    return !removals.includes(v.title);
  });
});

/**
 * ページ遷移する
 * @param {String} dest
 */
const movePage = (dest) => {
  switch (dest) {
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
    default:
      break;
  }
};
</script>

<style lang="scss" scoped></style>
