<template>
  <a
    href="javaScript:void(0)"
    class="text-decoration-underline"
    @click.stop="chooseFlowerPlace(place)"
  >
    {{ place }}
  </a>
</template>

<script setup>
import { inject } from "vue";

const changeResults = inject("changeResults");

defineProps({
  place: {
    type: String,
    required: true,
  },
});

/**
 * 選択した場所から、植物一覧のデータを受け取る
 * @param {Array} places 生えている場所
 */
const getFlowerPlaceList = (places) => {
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
 * 生えている場所から、場所を選択し、
 * Laravelで扱えるように配列に変換する
 * @param {String} place 生えている場所
 */
const chooseFlowerPlace = (place) => {
  const places = [];
  places.push(place);

  getFlowerPlaceList(places);
};
</script>

<style lang="scss" scoped></style>
