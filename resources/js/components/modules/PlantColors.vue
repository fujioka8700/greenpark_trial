<template>
  <v-row>
    <v-col v-for="color in plantColors" :key="color" cols="12" sm="4">
      <v-card class="mx-auto" max-width="344" link>
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

/**
 * 花の色で検索
 */
const searchFlowerColor = () => {
  axios
    .get("/api/plants/search-colors", {
      params: {
        colors: ["赤"],
      },
    })
    .then((result) => {
      console.log(result.data);
    })
    .catch((err) => {
      console.log(err);
    });
};

searchFlowerColor();
</script>

<style lang="scss" scoped></style>
