<template>
  <div class="mt-10">
    <v-card class="mx-auto" max-width="344">
      <v-img height="200px" cover class="text-center p-about-avatar-bg">
        <v-avatar class="p-about-avatar" color="surface-variant" size="100">
          <v-icon icon="mdi-account" size="90"></v-icon>
        </v-avatar>
      </v-img>

      <v-card-title class="text-center">{{ user.name }}&nbsp;様</v-card-title>

      <v-card-text class="text-center">
        <v-icon icon="mdi-email"></v-icon>&nbsp;{{ user.email }}
      </v-card-text>

      <v-card-actions>
        <div class="mx-auto mb-6">
          <v-btn
            color="green-lighten-2"
            variant="outlined"
            @click="auth.logout"
          >
            ログアウト
          </v-btn>
        </div>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script setup>
import { useStoreAuth } from "../../store/auth";
import { reactive, onMounted } from "vue";

const auth = useStoreAuth();

const user = reactive({
  /** @type {string} ログインユーザーの名前 */
  name: "",

  /** @type {string} ログインユーザーのメールアドレス */
  email: "",
});

onMounted(async () => {
  /** コンポーネントをマウント時に、ログインユーザーの情報を取得する */
  const auth = useStoreAuth();
  await auth.currentUser();

  user.name = auth.user.name;
  user.email = auth.user.email;
});
</script>

<style lang="scss" scoped>
.p-about-avatar {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

  &-bg {
    background-image: linear-gradient(#89f7fe 0%, #66a6ff 100%);
    position: relative;
  }
}
</style>
