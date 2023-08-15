<template>
  <div>
    <v-btn color="error" @click.stop="destroyComment">削除</v-btn>
  </div>
</template>

<script setup>
const emit = defineEmits(["deleteCommentNotification"]);

const props = defineProps({
  commentId: {
    type: Number,
    required: true,
  },
});

/**
 * コメント1つ削除後、
 * 親コンポーネントに削除した事を通知する
 */
const destroyComment = () => {
  axios
    .delete(`/api/comments/${props.commentId}`)
    .then((res) => {
      emit("deleteCommentNotification");
    })
    .catch((err) => {
      console.log(err);
    });
};
</script>

<style lang="scss" scoped></style>
