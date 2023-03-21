<template>
  <div>
    <h1>タイトル</h1>
    <ul>
      <li><RouterLink :to="{ name: 'Home' }">ホーム</RouterLink></li>
      <div v-if="user">
        <li><RouterLink :to="{ name: 'StorePlant' }">植物登録</RouterLink></li>
        <li>
          <RouterLink :to="{ name: 'About' }">{{ user.name }}</RouterLink>
        </li>
      </div>
      <div v-else>
        <li><RouterLink :to="{ name: 'Register' }">会員登録</RouterLink></li>
        <li><RouterLink :to="{ name: 'Login' }">ログイン</RouterLink></li>
      </div>
    </ul>
  </div>
</template>

<script setup>
import { useStoreAuth } from "../../store/auth";
import { storeToRefs } from "pinia";

const auth = useStoreAuth();
const { user } = storeToRefs(auth);
</script>

<style lang="scss" scoped></style>
