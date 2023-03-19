<template>
  <div>
    <h1>タイトル</h1>
    <ul>
      <li><RouterLink :to="{ name: 'Home' }">ホーム</RouterLink></li>
      <li><RouterLink :to="{ name: 'Register' }">会員登録</RouterLink></li>
      <li><RouterLink :to="{ name: 'Login' }">ログイン</RouterLink></li>
      <li><RouterLink :to="{ name: 'About' }">About</RouterLink></li>
    </ul>
  </div>
</template>

<script setup></script>

<style lang="scss" scoped></style>
