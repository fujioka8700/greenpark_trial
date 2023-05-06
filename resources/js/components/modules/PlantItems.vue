<template>
  <h4>検索結果</h4>

  <ul>
    <li
      class="my-3"
      style="list-style: none"
      v-for="item in searchResults.data"
      :key="item.id"
    >
      <RouterLink
        class="text-decoration-none"
        :to="{ name: 'PlantItem', params: { plantId: item.id } }"
      >
        <v-card link max-height="200" class="overflow-hidden">
          <v-card-title class="text-h6 bg-blue-grey-lighten-5">
            {{ item.name }}
          </v-card-title>

          <div class="d-flex">
            <v-avatar class="ma-3" size="125" rounded="0">
              <v-img :src="`../${item.file_path}`" cover></v-img>
            </v-avatar>

            <div>
              <v-card-text class="pa-3 pl-0 text-caption">
                {{ item.description }}
              </v-card-text>
            </div>
          </div>
        </v-card>
      </RouterLink>
    </li>
  </ul>
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
  breadCrumbs.push({ text: "検索結果", to: { name: "PlantItems" } });
});
</script>

<style lang="scss" scoped></style>
