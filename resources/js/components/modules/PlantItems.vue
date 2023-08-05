<template>
  <h4>検索結果</h4>

  <ul>
    <li
      class="my-3"
      style="list-style: none"
      v-for="item in searchResults.data"
      :key="item.id"
    >
      <RouterLink
        class="text-decoration-none"
        :to="{ name: 'PlantItem', params: { plantId: item.id } }"
      >
        <v-card link max-height="200" class="overflow-hidden">
          <v-card-title class="text-h6 bg-blue-grey-lighten-5">
            {{ item.name }}
          </v-card-title>

          <div class="d-flex">
            <v-avatar class="ma-3" size="125" rounded="0">
              <v-img :src="`../${item.file_path}`" cover></v-img>
            </v-avatar>

            <div>
              <v-card-text class="pa-3 pl-0 text-caption">
                {{ item.description }}
              </v-card-text>
            </div>
          </div>
        </v-card>
      </RouterLink>
    </li>
  </ul>
  <Pagination
    :currentPage="searchResults.current_page"
    :lastPage="searchResults.last_page"
    :path="searchResults.path"
    :query="query"
  />
</template>

<script setup>
import Pagination from "./Pagination.vue";
import { useStoreBreadCrumbs } from "../../store/breadCrumbs";
import { onMounted, inject, computed } from "vue";
import { useRoute } from "vue-router";

const searchResults = inject("searchResults");
const changeResults = inject("changeResults");
const changeColorResults = inject("changeColorResults");

const route = useRoute();

const breadCrumbs = useStoreBreadCrumbs();
const { addToBreadcrumbs } = breadCrumbs;

/** @type {Array} ページネーションへ渡すクエリ */
const query = computed(() => {
  return route.query;
});

/**
 * ブラウザを更新した時、クエリパラメータから、
 * 検索する「生育場所」を引数として、植物一覧を更新する
 * @param {Array} places
 */
const updatePlantListByLocation = (places) => {
  axios
    .get("/api/plants/search-places", {
      params: {
        places,
      },
    })
    .then((result) => {
      changeResults(result.data, places);
    })
    .catch((err) => {
      console.log(err);
    });
};

/**
 * ブラウザを更新した時、クエリパラメータから、
 * 検索キーワードを引数として、植物一覧を更新する
 * @param {String} keyword
 */
const updatePlantListByKeyword = (keyword) => {
  axios
    .get("/api/plants/search", {
      params: {
        keyword,
      },
    })
    .then((result) => {
      changeResults(result.data, keyword);
    })
    .catch((err) => {
      console.log(err);
    });
};

/**
 * ブラウザを更新した時、クエリパラメータから、
 * 花の色を引数として、植物一覧を更新する
 * @param {String} color
 */
const updatePlantListByColor = (colors) => {
  axios
    .get("/api/plants/search-colors", {
      params: {
        colors,
      },
    })
    .then((result) => {
      changeColorResults(result.data, colors);
    })
    .catch((err) => {
      console.log(err);
    });
};

onMounted(() => {
  //  植物一覧で、ブラウザをリロードした時の処理
  if (searchResults.value.data === undefined) {
    // 「生えている場所」を選択していた時
    if (route.query.hasOwnProperty("places")) {
      const places = route.query.places;

      updatePlantListByLocation(places);
    }

    // 「植物の名前・特徴」から検索していた時
    if (route.query.hasOwnProperty("keyword")) {
      const keyword = route.query.keyword;

      updatePlantListByKeyword(keyword);
    }

    // 「花の色」を選択していた時
    if (route.query.hasOwnProperty("colors")) {
      const colors = [];
      colors.push(route.query.colors);

      updatePlantListByColor(colors);
    }
  }

  addToBreadcrumbs("検索結果");
});
</script>

<style lang="scss" scoped></style>
