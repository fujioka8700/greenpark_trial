<template>
  <div>
    <h2>植物登録</h2>
    <ul>
      <li v-for="message in errorMessages">{{ message }}</li>
    </ul>
    <form @submit.prevent="sendButton">
      <label>
        <input type="text" v-model="name" placeholder="name" />
      </label>
      <br />
      <label>
        <input type="file" @change="fileSelected" />
      </label>
      <br />
      <p>よく生えている場所</p>
      <ul>
        <li v-for="place in places" :key="place.id">
          <input
            type="checkbox"
            :id="place.id"
            :value="place.id"
            v-model="placesCheckedValues"
          />
          <label :for="place.id">{{ place.name }}</label>
        </li>
      </ul>
      <p>花の色</p>
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
        ></textarea>
      </label>
      <br />
      <button type="submit">登録する</button>
    </form>
  </div>
  <div>
    <v-form @submit.prevent="sendButton">
      <v-text-field
        v-model="name"
        type="text"
        label="名前"
        :rules="[required]"
        :error="errors.name"
        :error-messages="errorMessages.name"
        clearable
        @keydown="clearError('name')"
      ></v-text-field>
      <v-file-input
        v-model="image"
        clearable
        accept="image/*"
        label="ファイルを選んでください"
        :error="errors.file"
        :error-messages="errorMessages.file"
        @change="changeFile"
      ></v-file-input>
      <v-img :src="url" width="100"></v-img>
      <div>
        <p>よく生えている場所</p>
        <v-container fluid>
          <v-row>
            <v-col
              v-for="place in places"
              :key="place.id"
              cols="4"
              sm="3"
              md="3"
            >
              <v-checkbox
                v-model="placesCheckedValues"
                :label="place.name"
                :value="place.id"
              ></v-checkbox>
            </v-col>
          </v-row>
        </v-container>
      </div>
      <div>
        <p>花の色</p>
        <v-container fluid>
          <v-row>
            <v-col
              v-for="color in colors"
              :key="color.id"
              cols="4"
              sm="3"
              md="3"
            >
              <v-checkbox
                v-model="colorsCheckedValues"
                :label="color.name"
                :value="color.id"
              ></v-checkbox>
            </v-col>
          </v-row>
        </v-container>
      </div>

      <v-btn type="submit" block color="light-blue-darken-1" class="mt-2">
        植物を登録する
      </v-btn>
    </v-form>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

/** @type {string[]} 植物登録時のエラー */
const errorMessages = ref({
  name: "",
  file: "",
});

/** @type {boolean[]} 入力部分のエラー状態 */
const errors = ref({
  name: false,
  file: false,
});

/** @type {string} 登録する植物の名前 */
const name = ref("");

/** @type {Object} 登録するファイル */
const fileInfo = ref({});

/** @type {string} 登録する植物の説明 */
const description = ref("");

/** @type {Object} 花の色、一覧 */
const colors = ref({});

/** @type {Object} よく生えている場所、一覧 */
const places = ref({});

/** @type {Array} 指定した花の色 */
const colorsCheckedValues = ref([]);

/** @type {Array} 指定したよく生えている場所 */
const placesCheckedValues = ref([]);

/** @type {Object} 植物の写真 */
const image = ref(null);

/**
 * バリデーション、必須入力
 * @param {string} value
 */
const required = (value) => !!value || "必須入力です。";

/**
 * ファイルのクリアボタンを押すと、
 * 選択していたファイルを解除する
 */
watch(image, () => {
  if (image.value[0] == null) {
    fileInfo.value = {};
  }
});

/** @type {string} 植物の写真のURL */
const url = computed(() => {
  if (image.value === null) {
    return;
  }

  if (image.value[0] != null) {
    return URL.createObjectURL(image.value[0]);
  }
});

/** @type {Object} axios ヘッダー定義 */
const config = {
  headers: {
    "content-type": "multipart/form-data",
  },
};

/**
 * よく生えている場所、一覧を取得する
 */
const placesList = () => {
  axios.get("/api/places").then((result) => {
    places.value = result.data;
  });
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
 * エラーをクリアにする
 * @param {string} item エラーをクリアにするプロパティ
 */
const clearError = (item) => {
  errors.value[item] = false;
  errorMessages.value[item] = "";
};

/**
 * 送信する写真ファイルをセットし、エラーを解除する
 * @param {Object} event 植物写真のファイル
 */
const changeFile = (event) => {
  fileSelected(event);

  clearError("file");
};

/**
 * 登録する植物の情報を送信する
 * @param {Object} formData
 */
const storePlant = (formData) => {
  axios
    .post("/api/plants", formData, config)
    .then((result) => {
      router.push({ name: "PlantPlaces" });
    })
    .catch((err) => {
      const response = err.response;

      // エラー内容を抽出して、表示できるよう整形する
      Object.keys(response.data.errors).forEach((item) => {
        errors.value[item] = true;
        errorMessages.value[item] = response.data.errors[item];
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
  formData.append("places", placesCheckedValues.value);
  formData.append("colors", colorsCheckedValues.value);

  storePlant(formData);
};

onMounted(() => {
  // 花の色、一覧を取得する
  colorsList();

  // よく生えている場所、一覧を取得する
  placesList();
});
</script>

<style lang="scss" scoped></style>
