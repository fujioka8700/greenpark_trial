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

const emit = defineEmits(["isNotification"]);

const props = defineProps({
  plantId: {
    type: Number,
    default: null,
  },
});

/** @type {string} 送信する前のコメント */
const comment = ref("");

/**
 * コメントを送信する。
 * コメントの書き込み成功時emitし、
 * WriteCommentsコンポーネントの、
 * コメント一覧を更新する。
 */
const sendButton = () => {
  axios
    .post("/api/comments", {
      user_id: user.value.id,
      plant_id: props.plantId,
      comment: comment.value,
    })
    .then((result) => {
      console.log(result.data);

      emit("isNotification");
    })
    .catch((err) => {
      const response = err.response;

      console.log(response.data);
    });

  // 入力していたコメントを消す
  comment.value = "";
};
</script>

<style lang="scss" scoped></style>
