<template>
  <div v-if="!!user">
    <v-form @submit.prevent="sendButton">
      <v-text-field
        v-model="state.comment"
        prepend-inner-icon="mdi-pencil"
        variant="underlined"
        clearable
        :error-messages="v$.comment.$errors.map((e) => e.$message)"
        @input="v$.comment.$touch"
        @blur="v$.comment.$touch"
      ></v-text-field>
      <div class="text-right mb-5">
        <v-btn
          type="submit"
          :disabled="!state.comment || state.comment.length > 255"
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
import { reactive } from "vue";
import { useStoreAuth } from "../../store/auth";
import { storeToRefs } from "pinia";
import { maxLengthMessage } from "../../plugin/validatorMessage";
import { useVuelidate } from "@vuelidate/core";
import { helpers, maxLength } from "@vuelidate/validators";

const auth = useStoreAuth();
const { user } = storeToRefs(auth);

const emit = defineEmits(["isNotification"]);

const props = defineProps({
  plantId: {
    type: Number,
    default: null,
  },
});

/* start of vuelidate  */

const initialState = {
  comment: "",
};

const state = reactive({
  ...initialState,
});

const validations = {
  comment: {
    maxLength: helpers.withMessage(maxLengthMessage("255"), maxLength(255)),
  },
};

const v$ = useVuelidate(validations, state);

/* end of vuelidate  */

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
      comment: state.comment,
    })
    .then((result) => {
      emit("isNotification", result.data.plant_id);
    })
    .catch((err) => {
      const response = err.response;

      console.log(response.data);
    });

  // 入力していたコメントを消す
  state.comment = "";
};
</script>

<style lang="scss" scoped></style>
