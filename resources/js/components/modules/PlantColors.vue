<template>
  <v-row>
    <v-col v-for="color in plantColors" :key="color" cols="12" sm="4">
      <v-card
        class="mx-auto"
        max-width="344"
        link
        @click="chooseFlowerColor(color)"
      >
        <v-img
          src="https://lovegreen.net/wp-content/uploads/2020/12/c8c593c9d3528f2d0e0803a375d0bfc7.jpg"
          max-height="130"
          cover
        ></v-img>

        <v-card-title class="text-body-1 text-center">{{ color }}</v-card-title>
      </v-card>
    </v-col>
  </v-row>
</template>

<script setup>
import { plantColors } from "../../util";
import { inject } from "vue";

const changeColorResults = inject("changeColorResults");

/**
 * 選択した色から、植物一覧のデータを受け取る
 * @param {Array} colors
 */
const getFlowerColorList = (colors) => {
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

/**
 * 花の色タブから、花の色を選択する
 * @param {String} color
 */
const chooseFlowerColor = (color) => {
  const colors = [];
  colors.push(color);

  getFlowerColorList(colors);
};
</script>

<style lang="scss" scoped></style>
