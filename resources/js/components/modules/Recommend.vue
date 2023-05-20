<template>
  <div v-for="(img, index) in ary" key="index">
    <RouterLink
      class="text-decoration-none"
      :to="{ name: 'PlantItem', params: { plantId: index } }"
    >
      <v-card link flat rounded="0" class="d-flex py-4">
        <v-img
          src="https://picsum.photos/300/200"
          min-width="100"
          max-width="120"
          class="ml-2"
          cover
        ></v-img>
        <div class="pl-1">
          <p>植物タイトル</p>
          <p class="pl-1">
            {{
              omittedText20(
                "解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説解説"
              )
            }}
          </p>
        </div>
      </v-card>
    </RouterLink>
    <template v-if="index !== ary.length - 1">
      <v-divider />
    </template>
  </div>
</template>

<script setup>
/** @type {Array} （仮）注目の植物たち */
const ary = Array(5);

/**
 * 20字以上の説明は、3点リーダーにする
 * @param {string} text 説明
 * @return {string} 省略した説明
 */
const omittedText20 = (text) => {
  return text.length > 20 ? text.slice(0, 20) + "..." : text;
};
</script>

<style lang="scss" scoped></style>
