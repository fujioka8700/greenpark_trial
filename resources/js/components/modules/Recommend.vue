<template>
  <div v-for="(plant, index) in recommendPlants" :key="index">
    <RouterLink
      class="text-decoration-none"
      :to="{ name: 'PlantItem', params: { plantId: plant.id } }"
    >
      <v-card link flat rounded="0" class="d-flex py-4">
        <v-img
          :src="`../${plant.file_path}`"
          min-width="120"
          max-width="120"
          height="80"
          class="ml-2"
          cover
        ></v-img>
        <div class="pl-1">
          <p>{{ plant.name }}</p>
          <p class="pl-1">
            {{ omittedText20(plant.description) }}
          </p>
        </div>
      </v-card>
    </RouterLink>
    <template v-if="index !== recommendPlants.length - 1">
      <v-divider />
    </template>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { onBeforeRouteUpdate } from "vue-router";
import { storeToRefs } from "pinia";
import { useStorePlant } from "../../store/plant";

const plant = useStorePlant();
const { destroyedPlantId } = storeToRefs(plant);

/** @type {Object} 注目の植物たち */
const recommendPlants = ref({});

/**
 * 20字以上の説明は、3点リーダーにする
 * @param {string} text 説明
 * @return {string} 省略した説明
 */
const omittedText20 = (text) => {
  return text.length > 20 ? text.slice(0, 20) + "..." : text;
};

/**
 * 「注目の植物たち」を取得する
 */
const fetchRecommendedPlants = () => {
  axios.get(`/api/plants/recommend`).then((result) => {
    recommendPlants.value = result.data;
  });
};

/**
 * 「注目の植物たち」リストの中に、
 * 削除された植物があれば、リストから消す
 * @param {Object} recommendList 注目の植物たちのリスト
 * @param {Number} destroyedPlantId 削除した植物id
 */
const removeFromRecommendPlantsList = (recommendList, destroyedPlantId) => {
  recommendList.forEach((element, index) => {
    if (element.id == destroyedPlantId) {
      recommendPlants.value.splice(index, 1);
    }
  });
};

onMounted(() => {
  fetchRecommendedPlants();
});

onBeforeRouteUpdate(() => {
  removeFromRecommendPlantsList(recommendPlants.value, destroyedPlantId.value);
});
</script>

<style lang="scss" scoped></style>
