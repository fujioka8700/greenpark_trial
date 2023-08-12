<template>
  <div class="text-center">
    <v-pagination
      v-model="page"
      :length="lastPage"
      :density="toggleDensity"
      rounded="circle"
      @click="navBtnClick"
    ></v-pagination>
  </div>
  <!-- pageUpdate は何も表示しない -->
  <!-- 算出プロパティで、現在ページを更新するために使用 -->
  {{ pageUpdate }}
</template>

<script setup>
import { ref, inject, computed, onMounted } from "vue";

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
const page = ref();

/** @type {Boolean} モバイルとPC切り替え */
const mobileView = ref(true);

/** @type {Number} ディスプレイの横幅 */
const windowWidth = ref(0);

// ページネーションの、現在ページ更新に使用
const pageUpdate = computed({
  get() {
    page.value = props.currentPage;
    return;
  },
});

/** @type {String} ページネーションのサイズを切り替える */
const toggleDensity = computed(() => {
  return mobileView.value === true ? "comfortable" : "default";
});

/**
 * ディスプレイの横幅で、モバイルとPC切り替える
 */
const calculateWindowWidth = () => {
  windowWidth.value = window.innerWidth;

  mobileView.value = windowWidth.value < 600;
};

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

onMounted(() => {
  // resizeイベントでウィンドウサイズ変更を検知する
  window.addEventListener("resize", calculateWindowWidth);
});
</script>

<style lang="scss" scoped></style>
