<template>
  <div>
    <h4>植物アイテム</h4>
    <ul>
      <li v-for="item in searchResults.data" :key="item.id">
        <RouterLink :to="{ name: 'PlantItem', params: { plantId: item.id } }">
          <p>{{ item.name }}</p>
          <img :src="item.file_path" alt="" />
        </RouterLink>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { inject } from "vue";

const searchResults = inject("searchResults");
</script>

<style lang="scss" scoped></style>
