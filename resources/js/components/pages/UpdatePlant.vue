<template>
  <div>
    <p>Update Page</p>
    <p>{{ plantId }}</p>
    <v-btn @click="sendUpdate(plantId)">修正する</v-btn>
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
 * @param {Number} plantId
 */
const sendUpdate = (plantId) => {
  axios
    .patch(`/api/plants/${plantId}`, {})
    .then((result) => {
      console.log(result);
    })
    .catch((err) => {
      console.log(err);
    });
};
</script>

<style lang="scss" scoped></style>
