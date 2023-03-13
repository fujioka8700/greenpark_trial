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
import { reactive, onMounted } from "vue";

const router = useRouter();

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
