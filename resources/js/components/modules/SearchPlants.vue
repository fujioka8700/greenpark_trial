<template>
  <div>
    <h3>植物を検索</h3>
    <form @submit.prevent="searchPlants">
      <label>
        <input type="text" v-model="keyword" placeholder="keyword" />
      </label>
      <br />
      <button type="submit">検索</button>
    </form>
    <div>
      <v-breadcrumbs :items="breadCrumbs.items" divider=">"></v-breadcrumbs>
    </div>
    <div>
      <RouterView />
    </div>
  </div>
</template>

<script setup>
import { ref, provide, watch } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useStoreBreadCrumbs } from "../../store/breadCrumbs";

const router = useRouter();
const route = useRoute();

// パンくずリストはStoreに保存している
const breadCrumbs = useStoreBreadCrumbs();

watch(route, () => {
  // 「図鑑トップ」をクリックした時、
  // パンくずリストのStoreをリセットする
  if (route.path === "/") {
    breadCrumbs.$reset();
  }
});

/** @type {string} 検索する植物名 */
const keyword = ref("");

/** @type {Object[]} 検索後の植物 */
const searchResults = ref({});
provide("searchResults", searchResults);

/**
 * 登録している植物を検索する
 */
const searchPlants = () => {
  axios
    .get("/api/plants/search", {
      params: {
        keyword: keyword.value,
      },
    })
    .then((result) => {
      console.log(result);

      // 検索結果を provide で使用する
      searchResults.value = result.data;

      // パンくずリストに「図鑑検索結果」を追加する
      breadCrumbs.push({ text: "図鑑検索結果", to: "/plants/search" });

      // 検索結果は、/plants/search で表示する
      router.push({ name: "PlantItems" });
    })
    .catch((err) => {
      console.log(err);
    });
};
</script>

<style lang="scss" scoped></style>
