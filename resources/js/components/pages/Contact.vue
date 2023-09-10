<template>
  <div>
    <v-sheet max-width="500" min-width="300" class="mx-auto pa-5">
      <h2>お問い合わせ</h2>
      <template v-if="!emailSent">
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
      </template>
      <template v-else>
        <p class="py-3">
          メッセージが送信されました。<br />ありがとうございました。
        </p>
      </template>
    </v-sheet>
  </div>
</template>

<script setup>
import { requiredMessage, emailMessage } from "../../plugin/validatorMessage";
import { ref, reactive } from "vue";
import { useVuelidate } from "@vuelidate/core";
import { required, email, helpers } from "@vuelidate/validators";

const emailSent = ref(false);

/* start of vuelidate  */

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

/* end of vuelidate  */

const submitForm = async () => {
  // 送信前に、フォームを検証する
  const isFormCorrect = await v$.value.$validate();
  if (!isFormCorrect) return;

  // 送信前に、送信していいか確認する
  if (!confirm("送信します。よろしいですか？")) return;

  axios
    .post("/api/contact", state)
    .then((res) => {
      console.log(res);

      // メッセージ送信後の、表示に切り替える
      emailSent.value = true;
    })
    .catch((err) => {
      console.log(err);
    });
};
</script>

<style lang="scss" scoped></style>
