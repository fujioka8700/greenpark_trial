<template>
  <div>
    <p class="text-body-2">
      <span class="font-weight-bold mr-2">
        <slot name="user_name">投稿者名</slot>
      </span>
      <span class="text-grey">
        <slot name="created_at">2000-01-01 00:00:00</slot>
      </span>
    </p>
    <p class="text-body-1">
      <slot name="comment">コメント</slot>
    </p>
  </div>
</template>

<script setup></script>

<style lang="scss" scoped></style>
