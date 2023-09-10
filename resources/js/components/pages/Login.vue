<template>
  <div class="mt-10">
    <div v-if="errorMessage">
      <v-card
        variant="flat"
        rounded="0"
        color="red-lighten-5"
        class="mx-auto mb-3"
        max-width="360"
      >
        <v-card-title class="text-body-2 text-red-darken-3">
          {{ errorMessage }}
        </v-card-title>
      </v-card>
    </div>

    <v-card class="mx-auto pa-6" max-width="344" border>
      <v-card-item class="pl-2 pt-0">
        <v-card-title class="font-weight-bold text-center">
          ログイン
        </v-card-title>
      </v-card-item>

      <v-divider class="mb-5"></v-divider>

      <v-form v-model="form" @submit.prevent="onSubmit">
        <v-text-field
          v-model="email"
          type="email"
          :readonly="loading"
          :rules="[required]"
          class="mb-2"
          clearable
          label="メールアドレス"
        ></v-text-field>
        <v-text-field
          v-model="pass"
          type="password"
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

/** @type {boolean} ログイン確認時、テキスト入力不可にする */
const loading = ref(false);

/**
 * バリデーション、必須入力
 * @param {string} value
 */
const required = (value) => !!value || "必須入力です。";

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
