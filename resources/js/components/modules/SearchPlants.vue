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
        <v-row>
          <v-col cols="12" sm="8">
            <Breadcrumbs />
            <RouterView />
          </v-col>

          <v-col cols="12" sm="4">
            <p class="pt-4 pb-2">注目の植物たち</p>
            <v-divider thickness="3" />
            <Recommend />
          </v-col>
        </v-row>
      </div>
    </v-container>
  </v-app>
</template>

<script setup>
import Breadcrumbs from "./Breadcrumbs.vue";
import Recommend from "./Recommend.vue";
import { ref, provide } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

/** @type {string} 検索する植物名 */
const keyword = ref("");

/** @type {Object[]} 検索後の植物 */
const searchResults = ref({});
provide("searchResults", searchResults);

/**
 * PlantItemsへ遷移し、検索した結果を表示する
 * @param {Object} result 検索結果
 * @param {Array} places 生育場所
 */
const changeResults = (result, places) => {
  searchResults.value = result;

  // 検索結果は、/plants/search で表示する
  router.push({ name: "PlantItems", query: { places } });
};
provide("changeResults", changeResults);

/**
 * ページネーションからの検索結果から、
 * 植物一覧を更新する。
 * @param {Object} result
 */
const updateListDisplay = (result) => {
  searchResults.value = result;
};
provide("updateListDisplay", updateListDisplay);

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
