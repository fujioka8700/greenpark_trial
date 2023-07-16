<template>
  <div>
    <v-sheet
      elevation="3"
      max-width="800"
      rounded
      width="100%"
      class="pa-4 px-6 ma-4 mx-auto"
    >
      <h2 class="text-h5 pt-2 text-center">植物を修正する</h2>
      <v-divider class="my-5 mx-7"></v-divider>
      <v-form v-model="form" @submit.prevent="sendButton">
        <p>名前</p>
        <v-text-field
          v-model="name"
          type="text"
          label="名前を入力してください"
          :rules="[required]"
          :error="errors.name"
          :error-messages="errorMessages.name"
          clearable
          @keydown="clearError('name')"
        ></v-text-field>
        <p>植物の写真</p>
        <v-switch
          label="写真を変更する場合は、スイッチをオンしてください"
          v-model="imageChange"
        ></v-switch>
        <v-file-input
          v-model="image"
          :disabled="!imageChange"
          clearable
          accept="image/*"
          label="ファイルを選んでください"
          :error="errors.file"
          :error-messages="errorMessages.file"
          @change="changeFile"
        ></v-file-input>
        <v-sheet
          color="grey-lighten-4"
          rounded
          class="mx-auto mb-7 d-flex align-center justify-center pa-1"
          height="150"
          width="250"
        >
          <template v-if="url">
            <v-img :src="url" max-width="250"></v-img>
          </template>
          <template v-else>
            <v-img
              :src="`../../${plantInfo.file_path}`"
              max-width="250"
            ></v-img>
          </template>
        </v-sheet>
        <div>
          <p>よく生えている場所</p>
          <div v-if="errorMessages.places">
            <p class="text-error text-caption">
              {{ errorMessages.places[0] }}
            </p>
          </div>
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
                  :error="errors.places"
                  @change="clearError('places')"
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
        <div>
          <p>説明</p>
          <v-textarea
            v-model="description"
            clearable
            clear-icon="mdi-close-circle"
            label="説明を入力してください"
            :rules="[required]"
            :error="errors.description"
            :error-messages="errorMessages.description"
            @keydown="clearError('description')"
          ></v-textarea>
        </div>

        <div class="d-flex justify-space-evenly">
          <v-btn
            type="submit"
            :disabled="!form"
            color="light-blue-darken-1"
            class="mt-2"
            >植物を修正する</v-btn
          >
          <v-btn
            color="blue-grey-lighten-5"
            class="mt-2"
            @click="$router.back()"
            >キャンセル</v-btn
          >
        </div>
      </v-form>
    </v-sheet>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

const props = defineProps({
  plantId: {
    type: Number,
    required: true,
  },
});

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

/** @type {Object} 植物の情報 */
const plantInfo = ref({});

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

/** @type {boolean} フォームの入力確認 */
const form = ref(false);

/** @type {boolean} 画像変更の入力許可 */
const imageChange = ref(false);

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
    "X-HTTP-Method-Override": "PUT",
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
    .post(`/api/plants/${props.plantId}`, formData, config)
    .then((result) => {
      // 修正完了後は、1つの植物ページへ遷移する
      router.back();
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
 * 新しい画像を選択していれば、その画像を送信する
 * @param {*} formData
 */
const changeToNewImage = (formData) => {
  if (fileInfo.value.size !== undefined) {
    formData.append("file", fileInfo.value);
  }
};

/**
 * 植物を登録するボタン
 */
const sendButton = () => {
  /** @type {Object} 登録する植物の情報 */
  const formData = new FormData();

  changeToNewImage(formData);

  // 植物の情報を formData に追加する
  formData.append("name", name.value);
  formData.append("description", description.value);
  formData.append("places", placesCheckedValues.value);
  formData.append("colors", colorsCheckedValues.value);

  storePlant(formData);
};

/**
 * 1つの植物と、リレーションしているものを取得する
 * @param {number} plantId 植物のID
 * @return {boolean} 植物の有無
 */
const getPlant = async (plantId) => {
  return await axios
    .get(`/api/plants/${plantId}`)
    .then((result) => {
      plantInfo.value = result.data;
      return true;
    })
    .catch((result) => {
      return false;
    });
};

/**
 * 植物からリレーションしているものに、チェックをする
 * @param {Array} checkedValues
 */
const selectedCheckValues = (checkedValues) => {
  let ary = [];

  checkedValues.forEach((elm) => {
    ary.push(elm.id);
  });

  return ary;
};

/**
 * 登録されている植物を、入力部分に表示する
 */
const registeredPlant = () => {
  name.value = plantInfo.value.name;
  colorsCheckedValues.value = selectedCheckValues(plantInfo.value.colors);
  placesCheckedValues.value = selectedCheckValues(plantInfo.value.places);
  description.value = plantInfo.value.description;
};

onMounted(async () => {
  // 花の色、一覧を取得する
  colorsList();

  // よく生えている場所、一覧を取得する
  placesList();

  await getPlant(props.plantId);

  registeredPlant();
});
</script>

<style lang="scss" scoped></style>
