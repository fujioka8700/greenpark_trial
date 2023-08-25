<template>
  <v-footer class="bg-grey-lighten-2">
    <v-row justify="center" no-gutters>
      <v-btn
        v-for="link in links"
        :key="link"
        variant="text"
        class="mx-3 text-capitalize"
      >
        {{ link }}
      </v-btn>
      <v-col class="text-center mt-2 text-caption" cols="12">
        &copy; {{ new Date().getFullYear() }} GreenPark
      </v-col>
    </v-row>
  </v-footer>
</template>

<script setup>
const links = ["GreenParkとは", "このサイトのご利用にあたって", "お問い合わせ"];
</script>

<style lang="scss" scoped></style>
