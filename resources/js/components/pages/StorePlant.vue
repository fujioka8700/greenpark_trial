<template>
  <div>
    <h2>植物登録</h2>
    <p>{{ errorMessage }}</p>
    <form @submit.prevent="storePlants">
      <label>
        <input type="text" v-model="name" placeholder="name" required />
      </label>
      <br />
      <button type="submit">登録する</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

const name = ref("");
const errorMessage = ref("");

const storePlants = () => {
  axios
    .post("/api/plants", {
      name: name.value,
    })
    .then((result) => {
      console.log(result);
      router.push({ name: "Home" });
    })
    .catch((err) => {
      console.log(err);
      errorMessage.value = "登録できませんでした。";
    });
};
</script>

<style lang="scss" scoped></style>
