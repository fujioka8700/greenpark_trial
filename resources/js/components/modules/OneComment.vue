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
          <CommentDestroyButton />
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script setup>
import CommentDestroyButton from "./CommentDestroyButton.vue";
</script>

<style lang="scss" scoped>
.m-one-comment {
  &--comment {
    white-space: pre-wrap;
    word-wrap: break-word;
  }
}
</style>
