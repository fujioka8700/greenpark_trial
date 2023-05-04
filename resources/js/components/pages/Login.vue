<template>
  <div class="mt-10">
    <div v-if="errorMessage">
      <v-card
        variant="flat"
        rounded="0"
        color="red-lighten-5"
        class="mx-auto mb-3"
        max-width="344"
      >
        <v-card-title
          ><span class="text-body-2 text-red-darken-3">{{
            errorMessage
          }}</span></v-card-title
        >
      </v-card>
    </div>

    <v-card class="mx-auto px-6 py-6" max-width="344">
      <v-card-item class="pl-2">
        <v-card-title>ログイン</v-card-title>
      </v-card-item>

      <v-form v-model="form" @submit.prevent="onSubmit">
        <v-text-field
          v-model="email"
          :readonly="loading"
          :rules="[required]"
          class="mb-2"
          clearable
          label="メールアドレス"
        ></v-text-field>
        <v-text-field
          v-model="pass"
          :readonly="loading"
          :rules="[required]"
          class="mb-2"
          clearable
          label="パスワード"
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
          ログイン
        </v-btn>
      </v-form>
    </v-card>
  </div>
</template>

<script setup>
import { useStoreAuth } from "../../store/auth";
import { storeToRefs } from "pinia";
import { ref, onUnmounted } from "vue";

const auth = useStoreAuth();
const { errorMessage } = storeToRefs(auth);

/** @type {string} ログインするユーザー */
const email = ref("");

/** @type {string} ログインするためのパスワード */
const pass = ref("");

/** @type {boolean} メール、パスワードの入力確認 */
const form = ref(false);

/** @type {boolean} ログイン確認時、ローディングにする */
const loading = ref(false);

// 開発中、仮のユーザーとパスワード
email.value = "test@example.com";
pass.value = "password";

/**
 * バリデーション、必須入力
 * @param {string} value
 */
const required = (value) => !!value || "必須です。";

/**
 * ログインできない場合、ローディングを解除する
 * @param {string} error
 */
const unLoading = (error) => {
  if (error === null || error) {
    loading.value = false;
  }
};

/**
 * ログイン処理
 */
const onSubmit = () => {
  if (!form.value) return;

  // ログインボタンをローディングにし、
  // テキスト入力を出来ないようにする
  loading.value = true;

  auth.login(email.value, pass.value);

  unLoading(errorMessage.value);
};

onUnmounted(() => {
  // エラーメッセージをクリアにする
  errorMessage.value = null;
});
</script>

<style lang="scss" scoped></style>
