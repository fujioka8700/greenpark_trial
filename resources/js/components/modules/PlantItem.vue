<template>
  <v-row>
    <v-col cols="12" sm="6">
      <v-img cover :src="`../${plantInfo.file_path}`"></v-img>
    </v-col>
    <v-col cols="12" sm="6">
      <v-table>
        <tbody>
          <tr>
            <td class="font-weight-bold text-no-wrap">植物名</td>
            <td>{{ plantInfo.name }}</td>
          </tr>
          <tr>
            <td class="font-weight-bold text-no-wrap">花の色</td>
            <td>
              <template
                v-for="(color, index) in plantInfo.colors"
                :key="color.id"
              >
                {{ color.name }}
                <span v-if="index < plantInfo.colors.length - 1"> 、</span>
              </template>
            </td>
          </tr>
          <tr>
            <td class="font-weight-bold text-no-wrap">生育地</td>
            <td>
              <template
                v-for="(place, index) in plantInfo.places"
                :key="place.id"
              >
                {{ place.name }}
                <span v-if="index < plantInfo.places.length - 1"> 、</span>
              </template>
            </td>
          </tr>
        </tbody>
      </v-table>
    </v-col>
  </v-row>
  <v-row>
    <v-col cols="12">
      <v-card variant="text">
        <v-card-item>
          <v-card-title
            class="font-weight-bold bg-blue-grey-lighten-5 pa-1 pl-3"
            >特徴</v-card-title
          >
        </v-card-item>

        <v-card-text class="m-plant-item-description">
          {{ plantInfo.description }}
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script setup>
import { useStoreBreadCrumbs } from "../../store/breadCrumbs";
import { watch, onMounted, ref } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

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
 * @param {number} plantId 植物のID
 */
const getPlant = async (plantId) => {
  await axios.get(`/api/plants/${plantId}`).then((result) => {
    plantInfo.value = result.data;
  });
};

watch(route, async () => {
  const plantId = route.params.plantId;

  // パスパラメータが植物IDの場合のみ、
  // 植物の詳細表示を更新する
  if (plantId !== undefined) {
    await getPlant(plantId);
  }
});

onMounted(async () => {
  /** @type {number} 植物のID */
  const plantId = props.plantId;

  // 1つの植物と、リレーションしているものを取得する
  await getPlant(plantId);

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
