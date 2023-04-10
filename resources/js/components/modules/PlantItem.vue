<template>
  <div>
    <h4>{{ plant.name }}</h4>
    <img :src="`../${plant.file_path}`" alt="" />
    <ul>
      <li v-for="color in plant.colors" :key="color.id">{{ color.name }}</li>
    </ul>
    <p class="m-plant-item-description">
      {{ plant.description }}
    </p>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";

const props = defineProps({
  /** @type {String} 植物のid */
  plantId: String,
});

/** @type {Object} 植物の情報 */
const plant = ref({});

/**
 * 1つの植物と、リレーションしているものを取得する
 */
const getPlant = () => {
  axios.get(`/api/plants/${props.plantId}`).then((result) => {
    plant.value = result.data;
  });
};

onMounted(() => {
  // 1つの植物と、リレーションしているものを取得する
  getPlant();
});
</script>

<style lang="scss" scoped>
.m-plant-item-description {
  white-space: pre-wrap;
  word-wrap: break-word;
}
</style>
