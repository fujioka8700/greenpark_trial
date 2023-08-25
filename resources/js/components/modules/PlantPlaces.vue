<template>
  <v-card flat>
    <v-tabs
      v-model="tab"
      color="blue-darken-1"
      bg-color="grey-lighten-4"
      fixed-tabs
      align-tabs="center"
    >
      <v-tab value="one">生えている場所</v-tab>
      <v-tab value="two">花の色</v-tab>
    </v-tabs>
    <v-window v-model="tab" class="py-5">
      <v-window-item value="one">
        <!-- 「生えている場所」タブのコンテンツ、始まり -->
        <v-row>
          <v-col
            v-for="placeLink in placeLinks"
            :key="placeLink"
            cols="12"
            sm="4"
          >
            <v-card
              class="mx-auto"
              max-width="344"
              link
              @click.stop.prevent="createSearchPlaces(placeLink[0])"
            >
              <v-img :src="placeLink[1]" max-height="120" cover></v-img>

              <v-card-title class="text-body-1 text-center">
                {{ placeLink[0] }}
              </v-card-title>
            </v-card>
          </v-col>
        </v-row>
        <!-- 「生えている場所」タブのコンテンツ、終わり -->
      </v-window-item>

      <v-window-item value="two">
        <!-- 「花の色」タブのコンテンツ、始まり -->
        <PlantColors />
        <!-- 「花の色」タブのコンテンツ、終わり -->
      </v-window-item>
    </v-window>
  </v-card>
</template>

<script setup>
import PlantColors from "./PlantColors.vue";
import { placeLinks } from "../../util";
import { ref, inject } from "vue";

/** @type {Object} タブの切り替え */
const tab = ref(null);

/** @type {Function} Provide の searchResults を変更する */
const changeResults = inject("changeResults");

/**
 * 生育場所で植物を検索する
 * @param {Array} places 検索する生育場所
 */
const searchPlaces = (places) => {
  axios
    .get("/api/plants/search-places", {
      params: {
        places,
      },
    })
    .then((result) => {
      // Provide の searchResults を変更し、検索結果を表示する
      // ページネーションに「生育場所」で、
      // 検索をできるようにするため、places も投げる
      changeResults(result.data, places);
    })
    .catch((err) => {
      console.log(err);
    });
};

/**
 * 生育場所を作成後、検索する
 * @param {Object} place 検索する生育場所
 */
const createSearchPlaces = (place) => {
  /** @type {Array} 生育場所 */
  const places = place.split("・");

  searchPlaces(places);
};
</script>

<style lang="scss" scoped></style>
