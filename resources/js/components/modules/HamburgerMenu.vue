<template>
  <div>
    <v-app-bar-nav-icon
      variant="text"
      @click.stop="emit('drawerParent')"
    ></v-app-bar-nav-icon>
  </div>
</template>

<script setup>
const emit = defineEmits(["drawerParent"]);
</script>

<style lang="scss" scoped></style>
