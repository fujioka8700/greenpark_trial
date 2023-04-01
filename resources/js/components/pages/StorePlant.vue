<template>
  <div>
    <h2>植物登録</h2>
    <ul>
      <li v-for="message in errorMessages">{{ message }}</li>
    </ul>
    <form @submit.prevent="sendButton">
      <label>
        <input type="text" v-model="name" placeholder="name" required />
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

/** @type {string[]} 植物登録時のエラー */
const errorMessages = ref([]);

/** @type {string} 登録する植物名 */
const name = ref("");

/** @type {Object} 登録するファイル */
const fileInfo = ref({});

/** @type {Object} axios ヘッダー定義 */
const config = {
  headers: {
    "content-type": "multipart/form-data",
  },
};

/**
 * 登録するファイルの情報を変更する
 * @param {Object} event ファイル情報
 */
const fileSelected = (event) => {
  fileInfo.value = event.target.files[0];
};

/**
 * 登録する植物の情報を送信する
 * @param {Object} formData
 */
const storePlant = (formData) => {
  axios
    .post("/api/plants", formData, config)
    .then((result) => {
      router.push({ name: "Home" });
    })
    .catch((err) => {
      /** エラー内容をクリアにする */
      errorMessages.value = [];

      const response = err.response;

      /** エラー内容を抽出して整形した配列にする */
      Object.keys(response.data.errors).forEach((data) => {
        const error = response.data.errors[data][0];

        errorMessages.value.push(error);
      });
    });
};

/**
 * 植物を登録するボタン
 */
const sendButton = () => {
  /** @type {Object} 登録する植物の情報 */
  const formData = new FormData();

  formData.append("name", name.value);
  formData.append("file", fileInfo.value);

  storePlant(formData);
};
</script>

<style lang="scss" scoped></style>
