<template>
  <div>
    <h3>植物を検索</h3>
    <form @submit.prevent="searchPlants">
      <label>
        <input type="text" v-model="keyword" placeholder="keyword" />
      </label>
      <br />
      <button type="submit">検索</button>
    </form>
    <div>
      <PlantItems />
    </div>
  </div>
</template>

<script setup>
import PlantItems from "./PlantItems.vue";
import { ref, provide } from "vue";

const keyword = ref("");
const searchResults = ref({});

provide("searchResults", searchResults);

const searchPlants = () => {
  axios
    .get("/api/plants/search", {
      params: {
        keyword: keyword.value,
      },
    })
    .then((result) => {
      console.log(result);

      searchResults.value = result.data;
    })
    .catch((err) => {
      console.log(err);
    });
};
</script>

<style lang="scss" scoped></style>
