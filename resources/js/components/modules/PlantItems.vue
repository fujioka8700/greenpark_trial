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
import { useStoreNewBreadCrumbs } from "../../store/newBreadCrumbs";
import { ref, onMounted, inject } from "vue";
import { useRoute } from "vue-router";

const searchResults = inject("searchResults");
const changeResults = inject("changeResults");

const route = useRoute();

const newBreadCrumbs = useStoreNewBreadCrumbs();
const { addToBreadcrumbs } = newBreadCrumbs;

/** @type {Array} ページネーションへ渡すクエリ */
const query = ref(route.query);

/**
 * ブラウザを更新した時、クエリパラメータから、
 * 検索する「生育場所」を引数として、植物一覧を更新する
 * @param {Array} places
 */
const plantListUpdate = (places) => {
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

onMounted(() => {
  //  植物一覧で、ブラウザを更新した時の処理
  if (searchResults.value.data === undefined) {
    const places = route.query.places;

    plantListUpdate(places);
  }

  addToBreadcrumbs("検索結果");
});
</script>

<style lang="scss" scoped></style>
