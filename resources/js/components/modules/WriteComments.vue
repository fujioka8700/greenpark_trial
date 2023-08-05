<template>
  <div class="mb-5" v-for="(comment, index) in comments" :key="comment.id">
    <div v-if="index < COMMENT_COUNT">
      <OneComment>
        <template v-slot:user_name>{{ comment.user.name }}</template>
        <template v-slot:created_at>{{ comment.created_at }}</template>
        <template v-slot:comment>{{ comment.comment }}</template>
      </OneComment>
    </div>
    <div v-else :class="{ comment_section__body: showAllComments }">
      <OneComment>
        <template v-slot:user_name>{{ comment.user.name }}</template>
        <template v-slot:created_at>{{ comment.created_at }}</template>
        <template v-slot:comment>{{ comment.comment }}</template>
      </OneComment>
    </div>
  </div>
  <div v-if="toggleComment">
    <p
      class="text-decoration-underline comment__toggle"
      @click="showAllComments = !showAllComments"
    >
      <template v-if="showAllComments">コメントを全て表示する</template>
      <template v-else>コメントを閉じる</template>
    </p>
  </div>
</template>

<script setup>
import { COMMENT_COUNT } from "../../util";
import OneComment from "./OneComment.vue";
import { ref, watch, computed } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const props = defineProps({
  plantId: {
    type: Number,
    default: null,
  },
});

/** @type {Object} コメント */
const comments = ref([]);

/** @type {Boolean} コメント全件表示 */
const showAllComments = ref(true);

watch(route, () => {
  // ページ遷移時、コメント一覧を取得する。
  getComments(route.params.plantId);
});

/** @type {Boolean} 規定数以上なら「コメントを全て表示する」を表示する */
const toggleComment = computed(() => {
  return comments.value.length > COMMENT_COUNT;
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

<style lang="scss" scoped>
.comment_section__body {
  display: none;
}

.comment__toggle {
  cursor: pointer;
}
</style>
