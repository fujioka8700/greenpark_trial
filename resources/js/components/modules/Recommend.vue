<template>
  <div v-for="(img, index) in ary" key="index">
    <v-sheet class="d-flex my-4" :class="{ 'mt-0': index === 0 }">
      <v-img
        src="https://picsum.photos/300/200"
        min-width="100"
        max-width="120"
        cover
      ></v-img>
      <div class="pa-1">
        <p>植物タイトル</p>
        <p class="pl-1">
          {{
            omittedText20(
              "解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説"
            )
          }}
        </p>
      </div>
    </v-sheet>
    <template v-if="index !== ary.length - 1">
      <v-divider />
    </template>
  </div>
</template>

<script setup>
const ary = Array(5);
const omittedText20 = (text) => {
  return text.length > 20 ? text.slice(0, 20) + "..." : text;
};
</script>

<style lang="scss" scoped></style>
