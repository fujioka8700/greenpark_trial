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
        <input type="file" @change="fileSelected" required />
      </label>
      <br />
      <ul>
        <li v-for="color in colors" :key="color.id">
          <input
            type="checkbox"
            :id="color.id"
            :value="color.id"
            v-model="colorsCheckedValues"
          />
          <label :for="color.id">{{ color.name }}</label>
        </li>
      </ul>
      <label>
        <textarea
          v-model="description"
          cols="30"
          rows="10"
          placeholder="説明"
          required
        ></textarea>
      </label>
      <br />
      <button type="submit">登録する</button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

/** @type {string[]} 植物登録時のエラー */
const errorMessages = ref([]);

/** @type {string} 登録する植物の名前 */
const name = ref("");

/** @type {Object} 登録するファイル */
const fileInfo = ref({});

/** @type {string} 登録する植物の説明 */
const description = ref("");

/** @type {Object} 花の色、一覧 */
const colors = ref({});

/** @type {Array} 指定した花の色 */
const colorsCheckedValues = ref([]);

/** @type {Object} axios ヘッダー定義 */
const config = {
  headers: {
    "content-type": "multipart/form-data",
  },
};

/**
 * 花の色、一覧を取得する
 */
const colorsList = () => {
  axios.get("/api/colors").then((result) => {
    colors.value = result.data;
  });
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
      // エラー内容をクリアにする
      errorMessages.value = [];

      const response = err.response;

      // エラー内容を抽出して整形した配列にする
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

  // 植物の情報を formData に追加する
  formData.append("name", name.value);
  formData.append("file", fileInfo.value);
  formData.append("description", description.value);
  formData.append("colors", colorsCheckedValues.value);

  storePlant(formData);
};

onMounted(() => {
  // 花の色、一覧を取得する
  colorsList();
});
</script>

<style lang="scss" scoped></style>
