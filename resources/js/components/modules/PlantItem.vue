<template>
  <div>
    <h4>ばら</h4>
    <img src="dummy.jpg" alt="" />
    <p>ばらの説明文。</p>
    <p>{{ plantId }}</p>
  </div>
</template>

<script setup>
import { onMounted } from "vue";
const props = defineProps({
  /** @type {String} 植物のid */
  plantId: String,
});

/**
 * 1つの植物と、リレーションしているものを取得する
 */
const getPlant = () => {
  axios.get(`/api/plants/${props.plantId}`).then((result) => {
    console.log(result);
  });
};

onMounted(() => {
  // 1つの植物と、リレーションしているものを取得する
  getPlant();
});
</script>

<style lang="scss" scoped></style>
