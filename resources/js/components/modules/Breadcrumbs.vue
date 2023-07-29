<template>
  <div>
    <v-breadcrumbs
      class="text-caption"
      :items="items"
      divider=">"
    ></v-breadcrumbs>
  </div>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { useStoreBreadCrumbs } from "../../store/breadCrumbs";

const breadCrumbs = useStoreBreadCrumbs();
const { items } = storeToRefs(breadCrumbs);
</script>

<style lang="scss" scoped></style>
