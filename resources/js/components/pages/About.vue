<template>
  <div>
    <h2>AboutView</h2>
    <p>名前: {{ user.name }}</p>
    <p>メールアドレス: {{ user.email }}</p>
    <button type="button" @click="auth.logout">ログアウト</button>
  </div>
</template>

<script setup>
import { useStoreAuth } from "../../store/auth";
import { reactive, onMounted } from "vue";

const auth = useStoreAuth();

const user = reactive({
  /** @type {string} ログインユーザーの名前 */
  name: "",

  /** @type {string} ログインユーザーのメールアドレス */
  email: "",
});

onMounted(async () => {
  /** コンポーネントをマウント時に、ログインユーザーの情報を取得する */
  const auth = useStoreAuth();
  await auth.currentUser();

  user.name = auth.user.name;
  user.email = auth.user.email;
});
</script>

<style lang="scss" scoped></style>
