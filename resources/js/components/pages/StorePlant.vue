<template>
  <div>
    <h2>植物登録</h2>
    <ul>
      <li v-for="message in errorMessages">{{ message }}</li>
    </ul>
    <form @submit.prevent="storePlants" enctype="multipart/form-data">
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

const errorMessages = ref([]);
const name = ref("");
const fileInfo = ref("");

// ヘッダー定義
const config = {
  headers: {
    "content-type": "multipart/form-data",
  },
};

const fileSelected = (event) => {
  fileInfo.value = event.target.files[0];

  console.log(fileInfo.value);
};

const storePlants = () => {
  const formData = new FormData();

  formData.append("name", name.value);
  formData.append("file", fileInfo.value);

  axios
    .post("/api/plants", formData, config)
    .then((result) => {
      console.log(result);

      router.push({ name: "Home" });
    })
    .catch((err) => {
      console.log(err);

      errorMessages.value = [];

      const response = err.response;

      Object.keys(response.data.errors).forEach((data) => {
        const error = response.data.errors[data][0];

        errorMessages.value.push(error);
      });
    });
};
</script>

<style lang="scss" scoped></style>
