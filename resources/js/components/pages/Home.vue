<template>
  <div>
    <h2>HomeView</h2>
    <SearchPlants />
  </div>
</template>

<script setup>
import { useStoreBreadCrumbs } from "../../store/breadCrumbs";
import { onMounted } from "vue";
import SearchPlants from "../modules/SearchPlants.vue";

// パンくずリストはStoreに保存している
const breadCrumbs = useStoreBreadCrumbs();

onMounted(() => {
  // パンくずリストをリセットする
  if (breadCrumbs.items) {
    breadCrumbs.$reset();
  }
});
</script>

<style lang="scss" scoped></style>
