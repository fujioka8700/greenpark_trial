<template>
  <div>
    <ul>
      <li>
        <a href="" @click.stop.prevent="createSearchPlaces">街路・生け垣</a>
      </li>
      <li>
        <a href="" @click.stop.prevent="createSearchPlaces">市街地・公園</a>
      </li>
      <li>
        <a href="" @click.stop.prevent="createSearchPlaces">神社・寺院</a>
      </li>
      <li>道端・草地</li>
      <li>空き地・土手</li>
      <li>田畑・あぜ</li>
      <li>雑木林・林緑・やぶ</li>
      <li>水辺・海辺</li>
    </ul>
  </div>
</template>

<script setup>
const emit = defineEmits(["changeSearchResults"]);

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
      // 親コンポーネント(SearchPlants.vue)にデータを渡す
      emit("changeSearchResults", result.data);
    });
};

/**
 * 生育場所を作成後、検索する
 * @param {Object} event クリックした li 要素
 */
const createSearchPlaces = (event) => {
  const string = event.target.innerText;

  /** @type {Array} 生育場所 */
  const places = string.split("・");

  searchPlaces(places);
};
</script>

<style lang="scss" scoped></style>
