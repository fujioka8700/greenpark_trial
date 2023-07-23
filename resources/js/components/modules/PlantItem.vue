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
import ThumbUp from "./ThumbUp.vue";
import UpdateButton from "./UpdateButton.vue";
import DestroyButton from "./DestroyButton.vue";
import CommentField from "./CommentField.vue";
import WriteComments from "./WriteComments.vue";
import { useStoreAuth } from "../../store/auth";
import { useStoreBreadCrumbs } from "../../store/breadCrumbs";
import { watch, onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();

const auth = useStoreAuth();

// パンくずリストはStoreに保存している
const breadCrumbs = useStoreBreadCrumbs();

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
 * パンくずリストに検索結果か、植物名を追加する
 */
const addBreadCrumbs = () => {
  if (plantInfo.value.name !== undefined) {
    breadCrumbs.push({
      text: plantInfo.value.name,
      to: {
        name: "PlantItem",
        params: {
          plantId: plantInfo.value.id,
        },
      },
    });
  }
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

    // パンくずリストが永遠に追加されるため、
    // パンくずリストの末尾を消しておく
    breadCrumbs.items.pop();

    addBreadCrumbs();
  }
});

onMounted(async () => {
  /** @type {number} 植物のID */
  const plantId = props.plantId;

  const beingPlant = await getPlant(plantId);

  moveToNotFound(beingPlant);

  addBreadCrumbs();
});
</script>

<style lang="scss" scoped>
.m-plant-item-description {
  white-space: pre-wrap;
  word-wrap: break-word;
}
</style>
