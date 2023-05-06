<template>
  <div class="mt-10">
    <div v-if="errorMessage">
      <v-card
        variant="flat"
        rounded="0"
        color="red-lighten-5"
        class="mx-auto mb-3"
        max-width="650"
      >
        <v-card-title class="text-body-2 text-red-darken-3">
          {{ errorMessage }}
        </v-card-title>
      </v-card>
    </div>

    <v-sheet color="grey-lighten-3" class="mx-auto pa-2" max-width="650">
      <v-card class="mx-auto pa-6" max-width="634">
        <v-card-item class="pt-0">
          <v-card-title class="font-weight-bold text-center">
            会員登録
          </v-card-title>

          <v-card-subtitle class="pt-3">初めてご利用になる方</v-card-subtitle>

          <v-card-text>
            会員に登録すると、下記のサービスの機能がご利用になれます。
          </v-card-text>

          <v-card-text class="text-h5 text-center font-weight-bold">
            植物図鑑
          </v-card-text>
        </v-card-item>

        <v-divider class="mb-5"></v-divider>

        <v-sheet class="mx-auto pa-2" max-width="344">
          <v-form v-model="form" @submit.prevent="onSubmit">
            <v-text-field
              v-model="name"
              type="text"
              label="名前"
              :readonly="loading"
              :rules="[required]"
              :error="errors.name"
              :error-messages="errorMessages.name"
              clearable
              @keydown="clearError('name')"
            ></v-text-field>
            <v-text-field
              v-model="email"
              type="email"
              label="メールアドレス"
              :readonly="loading"
              :rules="[required]"
              :error="errors.email"
              :error-messages="errorMessages.email"
              @keydown="clearError('email')"
              clearable
            ></v-text-field>
            <v-text-field
              v-model="pass"
              type="password"
              label="パスワード"
              :readonly="loading"
              :rules="[required]"
              :error="errors.password"
              :error-messages="errorMessages.password"
              clearable
              @keydown="clearError('password')"
            ></v-text-field>
            <v-text-field
              v-model="pass2"
              type="password"
              label="パスワード(確認)"
              :readonly="loading"
              :rules="[required, pwdConfirm]"
              clearable
            ></v-text-field>
            <v-btn
              :disabled="!form"
              :loading="loading"
              block
              color="success"
              size="large"
              type="submit"
              variant="elevated"
            >
              会員登録する
            </v-btn>
          </v-form>
        </v-sheet>
      </v-card>
    </v-sheet>
  </div>
</template>

<script setup>
import { useStoreAuth } from "../../store/auth";
import { storeToRefs } from "pinia";
import { ref, onUnmounted } from "vue";

const auth = useStoreAuth();
const { errorMessage } = storeToRefs(auth);

/** @type {boolean} 名前、メール、パスワードの入力確認 */
const form = ref(false);

/** @type {boolean} 会員登録できるか確認時、テキストの入力不可にする */
const loading = ref(false);

/** @type {string} 新ユーザーの名前 */
const name = ref("");

/** @type {string} 新ユーザーのメールアドレス */
const email = ref("");

/** @type {string} 新ユーザーのパスワード */
const pass = ref("");

/** @type {string} 確認用のパスワード */
const pass2 = ref("");

/** @type {String[]} バリデーションエラー内容 */
const errorMessages = ref({
  name: "",
  email: "",
  password: "",
});

/** @type {boolean[]} テキスト入力部分のエラー状態 */
const errors = ref({
  name: false,
  email: false,
  password: false,
});

/**
 * エラーをクリアにする
 * @param {string} item エラーをクリアにするプロパティ
 */
const clearError = (item) => {
  errors.value[item] = false;
  errorMessages.value[item] = "";
};

/**
 * バリデーション、必須入力
 * @param {string} value
 */
const required = (value) => !!value || "必須入力です。";

/**
 * 2つの入力したパスワードが、合致しているか確認する
 * @param {string} value 確認用のパスワード
 */
const pwdConfirm = (value) =>
  value === pass.value || "パスワードが合っていません。";

/**
 * バリデーションエラー状態にして、送信できないようにする
 * @param {Object} messages バリデーションエラーの内容
 */
const toggleValidationErrors = (messages) => {
  if (messages) {
    Object.keys(errorMessages.value).forEach((key) => {
      errors.value[key] = true;
    });
  }
};

/**
 * 会員登録できない場合、ローディングを解除する
 * @param {string} error
 */
const unLoading = (error) => {
  if (error === null || error) {
    loading.value = false;
  }
};

/**
 * 会員登録をする。
 * 登録できなければ、バリデーションエラーの内容を表示する。
 */
const onSubmit = async () => {
  if (!form.value) return;

  // 会員登録できるか確認時、ローディングにし、
  // テキスト入力を出来ないようにする
  loading.value = true;

  errorMessages.value = await auth.register(
    name.value,
    email.value,
    pass.value
  );

  unLoading(errorMessage.value);

  toggleValidationErrors(errorMessages.value);
};

onUnmounted(() => {
  // エラーメッセージをクリアにする
  errorMessage.value = null;
});
</script>

<style lang="scss" scoped></style>
