<template>
  <div>
    <h3>植物を検索</h3>
    <v-sheet width="300">
      <v-form @submit.prevent="searchPlants">
        <v-text-field
          v-model="keyword"
          label="植物の名前を入力してください"
        ></v-text-field>
        <v-btn type="submit" block class="mt-1">検索する</v-btn>
      </v-form>
    </v-sheet>
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

/** @type {string} 検索する植物名 */
const keyword = ref("");

/** @type {Object[]} 検索後の植物 */
const searchResults = ref({});
provide("searchResults", searchResults);

/**
 * 子コンポーネントで検索した結果を表示する
 * @param {Object} result 検索結果
 */
const changeResults = (result) => {
  searchResults.value = result;

  // 検索結果は、/plants/search で表示する
  router.push({ name: "PlantItems" });
};
provide("changeResults", changeResults);

watch(route, () => {
  // 「図鑑トップ」をクリックした時、
  // パンくずリストのStoreをリセットする
  if (route.path === "/") {
    breadCrumbs.$reset();
  }
});

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
      // 検索結果を provide で使用する
      searchResults.value = result.data;

      // 検索結果は、/plants/search で表示する
      router.push({ name: "PlantItems" });
    })
    .catch((err) => {
      console.log(err);
    });
};
</script>

<style lang="scss" scoped></style>
