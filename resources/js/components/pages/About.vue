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
  name: "",
  email: "",
});

onMounted(async () => {
  const store = useStoreAuth();
  await store.currentUser();

  user.name = store.user.name;
  user.email = store.user.email;
});
</script>

<style lang="scss" scoped></style>
