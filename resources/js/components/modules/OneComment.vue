<template>
  <div>
    <v-container class="pa-0">
      <v-row no-gutters>
        <v-col cols="9" sm="10">
          <div>
            <p class="text-body-2">
              <span class="font-weight-bold mr-2">
                <slot name="user_name">投稿者名</slot>
              </span>
              <span class="text-grey">
                <slot name="created_at">2000-01-01 00:00:00</slot>
              </span>
            </p>
            <p class="text-body-1 m-one-comment--comment">
              <slot name="comment">コメント</slot>
            </p>
          </div>
        </v-col>
        <v-col cols="3" sm="2" class="d-flex justify-center align-center">
          <!-- 書き込みした本人のみ「削除」ボタンを表示する -->
          <template v-if="auth.user && auth.user.id === commentUserId">
            <CommentDestroyButton
              :commentId="Number(commentId)"
              @deleteCommentNotification="deleteCommentNotification"
            />
          </template>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script setup>
import { useStoreAuth } from "../../store/auth";
import CommentDestroyButton from "./CommentDestroyButton.vue";

const auth = useStoreAuth();

const emit = defineEmits(["deleteCommentNotification"]);

const props = defineProps({
  commentId: {
    type: Number,
    required: true,
  },
  commentUserId: {
    type: Number,
    required: true,
  },
});

/**
 * コメント1つ削除した事を、
 * 親コンポーネントに通知する
 */
const deleteCommentNotification = () => {
  emit("deleteCommentNotification");
};
</script>

<style lang="scss" scoped>
.m-one-comment {
  &--comment {
    white-space: pre-wrap;
    word-wrap: break-word;
  }
}
</style>
