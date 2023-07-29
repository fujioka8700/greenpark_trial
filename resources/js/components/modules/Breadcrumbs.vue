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
import { useStoreNewBreadCrumbs } from "../../store/newBreadCrumbs";

const newBreadCrumbs = useStoreNewBreadCrumbs();
const { items } = storeToRefs(newBreadCrumbs);
</script>

<style lang="scss" scoped></style>
