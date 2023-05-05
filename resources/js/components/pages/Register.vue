<template>
  <div>
    <h2>RegisterView</h2>
    <p>{{ errorMessage }}</p>
    <form @submit.prevent="auth.register(name, email, pass)">
      <label>
        <input type="text" v-model="name" placeholder="name" />
      </label>
      <br />
      <label>
        <input type="email" v-model="email" placeholder="email" />
      </label>
      <br />
      <label>
        <input type="password" v-model="pass" placeholder="password" />
      </label>
      <br />
      <button type="submit">登録</button>
    </form>
  </div>

  <div>
    <v-form v-model="form" @submit.prevent="onSubmit">
      <v-text-field
        v-model="name"
        type="text"
        label="名前"
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
        :rules="[required]"
        :error="errors.password"
        :error-messages="errorMessages.password"
        clearable
        @keydown="clearError('password')"
      ></v-text-field>
      <v-btn
        :disabled="!form"
        block
        color="success"
        size="large"
        type="submit"
        variant="elevated"
      >
        会員登録する
      </v-btn>
    </v-form>
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

/** @type {string} 新ユーザーの名前 */
const name = ref("");

/** @type {string} 新ユーザーのメールアドレス */
const email = ref("");

/** @type {string} 新ユーザーのパスワード */
const pass = ref("");

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
 * 会員登録をする。
 * 登録できなければ、バリデーションエラーの内容を表示する。
 */
const onSubmit = async () => {
  errorMessages.value = await auth.register(
    name.value,
    email.value,
    pass.value
  );

  toggleValidationErrors(errorMessages.value);
};

onUnmounted(() => {
  // エラーメッセージをクリアにする
  errorMessage.value = null;
});
</script>

<style lang="scss" scoped></style>
