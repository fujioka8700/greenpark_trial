<template>
  <div>
    <h4>{{ plantInfo.name }}</h4>
    <img :src="`../${plantInfo.file_path}`" alt="" />
    <ul>
      <li v-for="place in plantInfo.places" :key="place.id">
        {{ place.name }}
      </li>
    </ul>
    <ul>
      <li v-for="color in plantInfo.colors" :key="color.id">
        {{ color.name }}
      </li>
    </ul>
    <p class="m-plant-item-description">
      {{ plantInfo.description }}
    </p>
  </div>
</template>

<script setup>
import { useStoreBreadCrumbs } from "../../store/breadCrumbs";
import { onMounted, ref } from "vue";

const props = defineProps({
  /** @type {String} 植物のid */
  plantId: String,
});

// パンくずリストはStoreに保存している
const breadCrumbs = useStoreBreadCrumbs();

/** @type {Object} 植物の情報 */
const plantInfo = ref({});

/**
 * 1つの植物と、リレーションしているものを取得する
 */
const getPlant = async () => {
  await axios.get(`/api/plants/${props.plantId}`).then((result) => {
    plantInfo.value = result.data;
  });
};

onMounted(async () => {
  // 1つの植物と、リレーションしているものを取得する
  await getPlant();

  // パンくずリストに植物名を追加する
  breadCrumbs.push({
    text: plantInfo.value.name,
    to: {
      name: "PlantItem",
      params: {
        plantId: plantInfo.value.id,
      },
    },
  });
});
</script>

<style lang="scss" scoped>
.m-plant-item-description {
  white-space: pre-wrap;
  word-wrap: break-word;
}
</style>
