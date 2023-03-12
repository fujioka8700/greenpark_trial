<template>
  <div>
    <h2>LoginView</h2>
    <p>{{ getUserMessage }}</p>
    <form @submit.prevent="login">
      <label>
        <input type="email" v-model="email" placeholder="email" />
      </label>
      <label>
        <input type="password" v-model="pass" placeholder="password" />
      </label>
      <br />
      <button type="submit">ログイン</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const email = ref("");
const pass = ref("");
const getUserMessage = ref("");

const login = () => {
  axios
    .get("/sanctum/csrf-cookie")
    .then((res) => {
      axios
        .post("/api/login", {
          email: email.value,
          password: pass.value,
        })
        .then((res) => {
          if (res.data.status_code == 200) {
            router.push("/about");
          }
          getUserMessage.value = "ログインに失敗しました。";
        })
        .catch((err) => {
          getUserMessage.value = "ログインに失敗しました。";
        });
    })
    .catch((err) => {});
};
</script>

<style lang="scss" scoped></style>
