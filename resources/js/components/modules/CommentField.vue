<template>
  <v-form @submit.prevent="sendButton">
    <v-text-field
      v-model="comment"
      prepend-inner-icon="mdi-pencil"
      variant="underlined"
      clearable
    ></v-text-field>
    <div class="text-right">
      <v-btn
        type="submit"
        :disabled="!comment"
        color="blue-lighten-1"
        rounded="xl"
        >コメント</v-btn
      >
    </div>
  </v-form>
</template>

<script setup>
import { ref } from "vue";

/** @type {string} 送信する前のコメント */
const comment = ref("");

/**
 * コメントを送信する
 */
const sendButton = () => {
  console.log(comment.value);
  comment.value = "";
};
</script>

<style lang="scss" scoped></style>
