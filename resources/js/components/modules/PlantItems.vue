<template>
  <div>
    <h4>植物アイテム</h4>
    <ul>
      <li v-for="item in searchResults.data" :key="item.id">
        <RouterLink :to="{ name: 'PlantItem', params: { plantId: item.id } }">
          <p>{{ item.name }}</p>
          <img :src="`../${item.file_path}`" alt="" />
        </RouterLink>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { useStoreBreadCrumbs } from "../../store/breadCrumbs";
import { onMounted, inject } from "vue";

const searchResults = inject("searchResults");

// パンくずリストはStoreに保存している
const breadCrumbs = useStoreBreadCrumbs();

onMounted(() => {
  // パンくずリストに、植物名があればリセットする
  if (breadCrumbs.items.length >= 3) {
    breadCrumbs.$reset();
  }

  // パンくずリストに「図鑑検索結果」を追加する
  breadCrumbs.push({ text: "図鑑検索結果", to: { name: "PlantItems" } });
});
</script>

<style lang="scss" scoped></style>
