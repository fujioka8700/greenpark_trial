<template>
  <v-btn color="info" @click="GoToPlantUpdatePage(updatePlantId)">修正</v-btn>
</template>

<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

const props = defineProps({
  updatePlantId: {
    type: Number,
    required: true,
  },
});

/**
 * @param {Number} plantId 修正する植物のid
 */
const GoToPlantUpdatePage = (plantId) => {
  router.push({ name: "UpdatePlant", params: plantId });
};
</script>

<style lang="scss" scoped></style>
