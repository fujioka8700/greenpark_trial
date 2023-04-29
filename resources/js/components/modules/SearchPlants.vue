<template>
  <v-app>
    <v-container>
      <v-card class="mx-auto px-3 py-3" max-width="544" color="grey-lighten-4">
        <v-form class="d-flex align-center" @submit.prevent="searchPlants">
          <v-text-field
            class="mr-3"
            label="花の名前から検索する"
            v-model="keyword"
            hide-details="auto"
            density="comfortable"
          ></v-text-field>

          <v-btn color="success" size="large" type="submit" variant="elevated">
            <v-icon icon="mdi-magnify"></v-icon>検索
          </v-btn>
        </v-form>
      </v-card>

      <div>
        <v-breadcrumbs :items="breadCrumbs.items" divider=">"></v-breadcrumbs>
      </div>
      <div>
        <v-row>
          <v-col cols="8" class="bg-red">
            <RouterView />
          </v-col>

          <v-col cols="4" class="bg-blue">
            <p>ここにピックアップ情報</p>
          </v-col>
        </v-row>
      </div>
    </v-container>
  </v-app>
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
