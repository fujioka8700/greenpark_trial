<template>
  <div>
    <p>Update Page</p>
    <p>{{ plantId }}</p>
  </div>
</template>

<script setup>
const props = defineProps({
  plantId: {
    type: Number,
    required: true,
  },
});
</script>

<style lang="scss" scoped></style>
