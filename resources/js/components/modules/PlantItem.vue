<template>
  <div>
    <h4>ばら</h4>
    <img src="dummy.jpg" alt="" />
    <p>ばらの説明文。</p>
    <p>{{ plantId }}</p>
  </div>
</template>

<script setup>
const props = defineProps({
  /** @type {String} 植物のid */
  plantId: String,
});
</script>

<style lang="scss" scoped></style>
