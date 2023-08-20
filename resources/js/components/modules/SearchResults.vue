<template>
  <p class="pl-3 text-subtitle-2">
    全{{ total }}件
    <template v-if="total >= 1"> {{ firstAndLast }}件目 </template>
  </p>
  <template v-if="total === 0">
    <p class="text-center py-5">該当する植物がありません。</p>
  </template>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  /** @type {Number} 検索後の合計数 */
  total: {
    type: Number,
    required: true,
  },
  /** @type {Number} 検索結果の表示ページ数 */
  currentPage: {
    type: Number,
    required: true,
  },
});

/** @type {String} 検索結果の表示している範囲 */
const firstAndLast = computed(() => {
  const MAX_DISPLAY = 10;
  let firstNumber = props.currentPage;
  let lastNumber;

  // 開始数を決定する
  if (props.currentPage > 1) {
    firstNumber =
      props.currentPage +
      (props.currentPage - 1) * MAX_DISPLAY -
      props.currentPage +
      1;
  }

  // 終了数を決定する
  if (props.currentPage * MAX_DISPLAY > props.total) {
    lastNumber = props.total;
  } else {
    lastNumber = props.currentPage * MAX_DISPLAY;
  }

  return `${firstNumber}～${lastNumber}`;
});
</script>

<style lang="scss" scoped></style>
