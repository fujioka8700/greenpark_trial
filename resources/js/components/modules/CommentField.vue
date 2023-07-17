<template>
  <div v-if="!!user">
    <v-form @submit.prevent="sendButton">
      <v-text-field
        v-model="comment"
        prepend-inner-icon="mdi-pencil"
        variant="underlined"
        clearable
      ></v-text-field>
      <div class="text-right mb-5">
        <v-btn
          type="submit"
          :disabled="!comment"
          color="blue-lighten-1"
          rounded="xl"
          >コメント</v-btn
        >
      </div>
    </v-form>
  </div>
  <div v-else class="ma-8">
    <!-- コメント入力、非表示なら、余白を挿入する -->
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useStoreAuth } from "../../store/auth";
import { storeToRefs } from "pinia";

const auth = useStoreAuth();
const { user } = storeToRefs(auth);

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
