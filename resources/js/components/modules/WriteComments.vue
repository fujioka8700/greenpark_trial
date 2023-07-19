<template>
  <div class="mb-5" v-for="comment in comments" :key="comment.id">
    <p class="text-body-2">
      <span class="font-weight-bold mr-2">{{ comment.user.name }}</span>
      <span class="text-grey">{{ comment.created_at }}</span>
    </p>
    <p class="text-body-1">{{ comment.comment }}</p>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const props = defineProps({
  plantId: {
    type: Number,
    default: null,
  },
});

const comments = ref(null);

watch(route, () => {
  // ページ遷移時、コメント一覧を取得する。
  getComments(route.params.plantId);
});

/**
 * コメント一覧を取得し、更新する。
 * @param {Number} plantId
 */
const getComments = (plantId) => {
  axios
    .get("/api/comments", {
      params: {
        plant_id: plantId,
      },
    })
    .then((result) => {
      comments.value = result.data;
    })
    .catch((err) => {
      console.log(err);
    });
};

// created時、コメント一覧を取得する。
getComments(props.plantId);

// 非親子コンポーネントから、
// メソッドを実行できるようにする。
defineExpose({ getComments });
</script>

<style lang="scss" scoped></style>
