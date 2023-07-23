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
    <span class="mt-2 mr-3">{{ totalLikes }}</span>
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
  totalLikesCheck(route.params.plantId);
});

/** @type {boolean} いいね、されているか */
const likeStatus = ref(false);

/** @type {Number} 1つの植物に対しての、いいね合計数 */
const totalLikes = ref(null);

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
 * いいねボタンを押すと、いいね・いいね解除する
 * その後、いいねボタンの色も切り替える
 */
const clickedLike = () => {
  if (likeStatus.value) {
    // いいね解除し、いいね数を減らす
    unLike();
    totalLikes.value--;
  } else {
    // いいねし、いいね数を増やす
    like();
    totalLikes.value++;
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

/**
 * 1つの植物に対して、いいね合計数を確認する
 * @param {Number} plantId
 */
const totalLikesCheck = (plantId = props.plantId) => {
  axios
    .get(`/api/plants/${plantId}/like-count`)
    .then((result) => {
      totalLikes.value = result.data;
    })
    .catch((err) => {
      console.log(err);
    });
};

likeStatusCheck();
totalLikesCheck();
</script>

<style lang="scss" scoped></style>
