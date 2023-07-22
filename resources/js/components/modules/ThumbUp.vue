<template>
  <div class="d-flex justify-end align-center">
    <v-btn
      class="mt-2"
      variant="text"
      icon="mdi-thumb-up"
      color="blue-lighten-2"
      @click="like"
    ></v-btn>
    <span class="mt-2 mr-3">100</span>
  </div>
</template>

<script setup>
const props = defineProps({
  plantId: {
    type: Number,
    required: true,
  },
});

/**
 * 「いいね」する
 */
const like = () => {
  axios
    .post(`/api/plants/${props.plantId}/like`)
    .then((result) => {
      console.log(result);
    })
    .catch((err) => {
      console.log(err);
    });
};
</script>

<style lang="scss" scoped></style>
