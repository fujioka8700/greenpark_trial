<template>
  <div>
    <v-btn color="error" @click.stop="btnClick">削除</v-btn>
  </div>
</template>

<script setup>
const btnClick = () => {
  console.log("btnClick click");
};
</script>

<style lang="scss" scoped></style>
