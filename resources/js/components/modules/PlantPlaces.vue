<template>
  <v-row>
    <v-col v-for="placeLink in placeLinks" :key="placeLink" cols="12" sm="4">
      <v-card
        class="mx-auto"
        max-width="344"
        link
        @click.stop.prevent="createSearchPlaces(placeLink[0])"
      >
        <v-img :src="placeLink[1]" max-height="130" cover></v-img>

        <v-card-title class="text-body-1">{{ placeLink[0] }}</v-card-title>
      </v-card>
    </v-col>
  </v-row>
</template>

<script setup>
import { placeLinks } from "../../util";
import { inject } from "vue";

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
      changeResults(result.data);
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
