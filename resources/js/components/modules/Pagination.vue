<template>
  <div class="text-center">
    <v-pagination
      v-model="page"
      :length="lastPage"
      rounded="circle"
      @click="navBtnClick"
    ></v-pagination>
  </div>
</template>

<script setup>
import { ref, inject } from "vue";

const updateListDisplay = inject("updateListDisplay");

/** @type {Number} 現在のページ*/
const page = ref(props.currentPage);

const props = defineProps({
  /** @type {String} 検索用URL */
  path: { type: String, required: false },

  /** @type {Number} 現在のページ*/
  currentPage: { type: Number, required: false },

  /** @type {Number} 最後のページ*/
  lastPage: { type: Number, required: false },

  /** @type {Object} 検索用キーワード */
  query: { type: Object, required: false },
});

/**
 * 植物一覧の表示を、更新する
 */
const navBtnClick = () => {
  axios
    .get(`${props.path}?page=${page.value}`, {
      params: props.query,
    })
    .then((result) => {
      updateListDisplay(result.data);
    })
    .catch((err) => {
      console.log(err);
    });
};
</script>

<style lang="scss" scoped></style>
