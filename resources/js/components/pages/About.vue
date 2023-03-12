<template>
  <div>
    <h2>AboutView</h2>
    <p>名前: {{ user.name }}</p>
    <p>メールアドレス: {{ user.email }}</p>
    <button type="button" @click="logout">ログアウト</button>
  </div>
</template>

<script setup>
import { useStoreAuth } from "../../store/auth";
import { useRouter } from "vue-router";

const { user } = useStoreAuth();
const router = useRouter();

const logout = () => {
  axios
    .post("/api/logout")
    .then((res) => {
      router.push("/login");
    })
    .catch((err) => {});
};
</script>

<style lang="scss" scoped></style>
