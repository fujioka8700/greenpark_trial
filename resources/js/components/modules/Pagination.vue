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

/** @type {Number} 現在のページ*/
const page = ref(props.currentPage);

/**
 * ナビボタンのいずれかを押すと、
 * 自動スクロールでページトップへ移動する
 */
const moveToTop = () => {
  const duration = 10; // 移動速度（0.01秒で終了）
  const interval = 25; // 0.025秒ごとに移動
  const step = -window.scrollY / Math.ceil(duration / interval); // 1回に移動する距離
  const timer = setInterval(() => {
    window.scrollBy(0, step); // スクロール位置を移動

    if (window.scrollY <= 0) {
      clearInterval(timer);
    }
  }, interval);
};

/**
 * 植物一覧の表示を更新し、
 * 自動スクロールでページトップへ移動する
 */
const navBtnClick = async () => {
  let query = props.query;

  // 花の色は、文字列なので配列へ変換する
  if (query.hasOwnProperty("colors")) {
    query = { colors: Object.values(query) };
  }

  await axios
    .get(`${props.path}?page=${page.value}`, {
      params: query,
    })
    .then((result) => {
      updateListDisplay(result.data);
    })
    .catch((err) => {
      console.log(err);
    });

  moveToTop();
};
</script>

<style lang="scss" scoped></style>
