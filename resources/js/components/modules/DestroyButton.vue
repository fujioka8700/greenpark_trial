<template>
  <div>
    <v-dialog v-model="dialog" width="auto">
      <template v-slot:activator="{ props }">
        <v-btn color="error" v-bind="props">削除</v-btn>
      </template>

      <v-card>
        <v-card-text>削除してよろしいですか？</v-card-text>
        <v-card-actions class="justify-space-around">
          <v-btn
            variant="tonal"
            color="error"
            @click="destroyOnePlant(destroyPlantId)"
          >
            削除する
          </v-btn>
          <v-btn variant="tonal" @click="dialog = false">キャンセル</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

const props = defineProps({
  destroyPlantId: String,
});

const dialog = ref(false);

/**
 * @param {Number} plantId 削除する植物のid
 */
const destroyOnePlant = (plantId) => {
  axios.delete(`/api/plants/${plantId}`).then((response) => {
    router.push({ name: "PlantPlaces" });
  });
};
</script>

<style lang="scss" scoped></style>
