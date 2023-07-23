<template>
  <div class="d-flex justify-end align-center">
    <v-btn
      class="mt-2"
      variant="text"
      icon="mdi-thumb-up"
      :color="likeColor"
      :disabled="!user"
      @click="clickedLike"
    ></v-btn>
    <span class="mt-2 mr-3">100</span>
  </div>
</template>

<script setup>
import { useStoreAuth } from "../../store/auth";
import { storeToRefs } from "pinia";
import { ref, watch, computed } from "vue";
import { useRoute } from "vue-router";

const auth = useStoreAuth();
const { user } = storeToRefs(auth);

const route = useRoute();

const props = defineProps({
  plantId: {
    type: Number,
    required: true,
  },
});

watch(route, () => {
  likeStatusCheck(route.params.plantId);
});

/** @type {boolean} いいね、されているか */
const likeStatus = ref(false);

/**
 * いいね、されていたら、青色にする
 * いいね、されていなかったら、灰色にする
 * @type {string} いいねボタンの色
 */
const likeColor = computed(() => {
  return likeStatus.value ? "blue-lighten-2" : "grey";
});

/**
 * いいねボタンの、色を切り替える
 */
const toggleLikeStatus = () => {
  likeStatus.value = !likeStatus.value;
};

/**
 * いいねボタンを押すと、いいねか、いいね解除する
 * その後、いいねボタンの色も切り替える
 */
const clickedLike = () => {
  if (likeStatus.value) {
    unLike();
  } else {
    like();
  }

  toggleLikeStatus();
};

/**
 * 「いいね」する
 */
const like = () => {
  axios
    .post(`/api/plants/${props.plantId}/like`)
    .then((result) => {
      console.log(result.data);
    })
    .catch((err) => {
      console.log(err);
    });
};

/**
 * 「いいね」を解除する
 */
const unLike = () => {
  axios
    .post(`/api/plants/${props.plantId}/unlike`)
    .then((result) => {
      console.log(result.data);
    })
    .catch((err) => {
      console.log(err);
    });
};

/**
 * 「いいね」の状態を確認する
 * @param {Number} plantId
 */
const likeStatusCheck = (plantId = props.plantId) => {
  // ログイン中のみ、いいねの状態を確認する
  if (!!user.value) {
    axios
      .get(`/api/plants/${plantId}/like-status`)
      .then((result) => {
        likeStatus.value = result.data;
      })
      .catch((err) => {
        console.log(err);
      });
  }
};

likeStatusCheck();
</script>

<style lang="scss" scoped></style>
