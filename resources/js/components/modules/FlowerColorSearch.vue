<template>
  <a
    href="javaScript:void(0)"
    class="text-decoration-underline"
    @click.stop="chooseFlowerColor(color)"
  >
    {{ color }}
  </a>
</template>

<script setup>
import { inject } from "vue";

const changeColorResults = inject("changeColorResults");

defineProps({
  color: {
    type: String,
    required: true,
  },
});

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
 * 花の色から、色を選択する
 * @param {String} color
 */
const chooseFlowerColor = (color) => {
  const colors = [];
  colors.push(color);

  getFlowerColorList(colors);
};
</script>

<style lang="scss" scoped></style>
