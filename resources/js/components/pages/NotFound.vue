<template>
  <div class="pa-3">
    <h2>Not Found</h2>
    <p>アクセスしたページは存在しません。</p>
    <p>
      <RouterLink :to="{ name: 'PlantPlaces' }">TOP画面</RouterLink>に戻ります。
    </p>
  </div>
</template>

<script setup></script>

<style lang="scss" scoped></style>
