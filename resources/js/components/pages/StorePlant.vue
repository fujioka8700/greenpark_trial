<template>
  <div>
    <h2>植物登録</h2>
    <p>{{ errorMessage }}</p>
    <form @submit.prevent="storePlants">
      <label>
        <!-- <input type="text" v-model="name" placeholder="name" required /> -->
        <input type="text" v-model="name" placeholder="name" />
      </label>
      <br />
      <label>
        <input type="file" @change="fileSelected" />
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

const errorMessage = ref("");
const name = ref("");
const fileInfo = ref("");

const fileSelected = (event) => {
  fileInfo.value = event.target.files[0];
  console.log(fileInfo.value);
};

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

      const response = err.response;

      errorMessage.value = response.data.message;
    });
};
</script>

<style lang="scss" scoped></style>
