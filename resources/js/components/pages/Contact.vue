<template>
  <div>
    <v-sheet max-width="500" min-width="300" class="mx-auto pa-5">
      <h2>お問い合わせ</h2>
      <p class="py-3">
        GreenParkに対するご意見、ご感想などは、<br />こちらのフォームよりお問い合わせ下さい。
      </p>
      <v-form @submit.prevent="submitForm">
        <!-- お名前 -->
        <v-text-field
          v-model="state.name"
          :error-messages="v$.name.$errors.map((e) => e.$message)"
          label="お名前"
          required
          @input="v$.name.$touch"
          @blur="v$.name.$touch"
        ></v-text-field>

        <!-- メールアドレス -->
        <v-text-field
          v-model="state.email"
          :error-messages="v$.email.$errors.map((e) => e.$message)"
          label="メールアドレス"
          required
          @input="v$.email.$touch"
          @blur="v$.email.$touch"
        ></v-text-field>

        <!-- お問い合わせ内容 -->
        <v-textarea
          v-model="state.body"
          :error-messages="v$.body.$errors.map((e) => e.$message)"
          variant="filled"
          auto-grow
          label="お問い合わせ内容"
          rows="4"
          @input="v$.body.$touch"
          @blur="v$.body.$touch"
        ></v-textarea>

        <div class="text-center">
          <v-btn type="submit" width="200" color="success" class="mt-5"
            >送信する</v-btn
          >
        </div>
      </v-form>
    </v-sheet>
  </div>
</template>

<script setup>
import { requiredMessage, emailMessage } from "../../plugin/validatorMessage";
import { reactive } from "vue";
import { useVuelidate } from "@vuelidate/core";
import { required, email, helpers } from "@vuelidate/validators";

const initialState = {
  name: "",
  email: "",
  body: "",
};

const state = reactive({
  ...initialState,
});

const validations = {
  name: {
    required: helpers.withMessage(requiredMessage("お名前"), required),
  },
  email: {
    required: helpers.withMessage(requiredMessage("メールアドレス"), required),
    email: helpers.withMessage(emailMessage, email),
  },
  body: {
    required: helpers.withMessage(
      requiredMessage("お問い合わせ内容"),
      required
    ),
  },
};

const v$ = useVuelidate(validations, state);

const submitForm = async () => {
  // 送信前にフォームを検証する
  const isFormCorrect = await v$.value.$validate();
  if (!isFormCorrect) return;

  axios
    .post("/api/contact", state)
    .then((res) => {
      console.log(res);
    })
    .catch((err) => {
      console.log(err);
    });
};
</script>

<style lang="scss" scoped></style>
