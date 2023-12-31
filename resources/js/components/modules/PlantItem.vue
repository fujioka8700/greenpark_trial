<template>
  <div
    v-if="auth.user && auth.user.id === plantInfo.user_id"
    class="d-flex justify-end mb-2"
  >
    <UpdateButton :updatePlantId="Number(plantId)" class="mr-2" />
    <DestroyButton :destroyPlantId="Number(plantId)" />
  </div>
  <v-row>
    <v-col cols="12" sm="6" class="pb-0">
      <v-img cover :src="`../${plantInfo.file_path}`"></v-img>
      <ThumbUp :plantId="Number(plantId)" />
    </v-col>
    <v-col cols="12" sm="6" class="pb-0">
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
                <FlowerColorSearch :color="color.name" />
                <span v-if="index < plantInfo.colors.length - 1"> 、</span>
              </template>
            </td>
          </tr>
          <tr>
            <td
              colspan="2"
              class="font-weight-bold text-no-wrap m-plant-item-place--title"
            >
              生えている場所
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <template
                v-for="(place, index) in plantInfo.places"
                :key="place.id"
              >
                <FlowerPlaceSearch :place="place.name" />
                <span v-if="index < plantInfo.places.length - 1"> 、</span>
              </template>
            </td>
          </tr>
        </tbody>
      </v-table>
    </v-col>
  </v-row>
  <v-row>
    <v-col cols="12" class="pt-0">
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
      <CommentField
        :plantId="Number(plantId)"
        @isNotification="commentedEvent"
      />
      <WriteComments :plantId="Number(plantId)" ref="writeComments" />
    </v-col>
  </v-row>
</template>

<script setup>
import FlowerPlaceSearch from "./FlowerPlaceSearch.vue";
import FlowerColorSearch from "./FlowerColorSearch.vue";
import ThumbUp from "./ThumbUp.vue";
import UpdateButton from "./UpdateButton.vue";
import DestroyButton from "./DestroyButton.vue";
import CommentField from "./CommentField.vue";
import WriteComments from "./WriteComments.vue";
import { useStoreBreadCrumbs } from "../../store/breadCrumbs";
import { useStoreAuth } from "../../store/auth";
import { watch, onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();

const auth = useStoreAuth();

const breadCrumbs = useStoreBreadCrumbs();
const { addToBreadcrumbs } = breadCrumbs;

const props = defineProps({
  /** @type {String} 植物のid */
  plantId: String,
});

/** @type {Object} 植物の情報 */
const plantInfo = ref({});

/** @type {Object} 非親子間で、メソッドを実行用 */
const writeComments = ref();

/**
 * 植物が存在しなければ、NotFoundページへ遷移する
 * @param {boolean} beingPlant
 */
const moveToNotFound = (beingPlant) => {
  if (beingPlant === false) {
    router.push({ name: "NotFound" });
  }
};

/**
 * 1つの植物と、リレーションしているものを取得する
 * @param {number} plantId 植物のID
 * @return {boolean} 植物の有無
 */
const getPlant = async (plantId) => {
  return await axios
    .get(`/api/plants/${plantId}`)
    .then((result) => {
      plantInfo.value = result.data;
      return true;
    })
    .catch((result) => {
      return false;
    });
};

/**
 * CommentFieldコンポーネントから、
 * コメント書き込みの、emitを受け取り時に実行する
 * @param {Number} plantId
 */
const commentedEvent = (plantId) => {
  writeComments.value.getComments(plantId);
};

watch(route, async () => {
  /** @type {number} 植物のID */
  const plantId = route.params.plantId;

  // パスパラメータが植物IDの場合のみ、
  // 植物の詳細表示を更新する
  if (plantId !== undefined) {
    await getPlant(plantId);

    addToBreadcrumbs(plantInfo.value.name);
  }

  // PlantItem から、花の色を選択した時、
  // パンくずリストの最後を、「検索結果」にする
  if (route.path === "/plants/search") {
    addToBreadcrumbs("検索結果");
  }
});

onMounted(async () => {
  /** @type {number} 植物のID */
  const plantId = props.plantId;

  const beingPlant = await getPlant(plantId);

  moveToNotFound(beingPlant);

  addToBreadcrumbs(plantInfo.value.name);
});
</script>

<style lang="scss" scoped>
.m-plant-item-description {
  white-space: pre-wrap;
  word-wrap: break-word;
}

.m-plant-item-place--title {
  border-bottom: none !important;
}
</style>
