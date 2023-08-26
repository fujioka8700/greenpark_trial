<template>
  <v-footer class="bg-grey-lighten-2">
    <v-row justify="center" no-gutters>
      <v-btn
        v-for="(link, index) in links"
        :key="index"
        variant="text"
        class="mx-3 text-capitalize"
        @click.stop="movePage(link.dest)"
      >
        {{ link.title }}
      </v-btn>
      <v-col class="text-center mt-2 text-caption" cols="12">
        &copy; {{ new Date().getFullYear() }} GreenPark
      </v-col>
    </v-row>
  </v-footer>
</template>

<script setup>
import { links } from "../../util";
import { useRouter } from "vue-router";

const router = useRouter();

/**
 * @param {String} dest
 */
const movePage = (dest) => {
  switch (dest) {
    case "information":
      router.push({ name: "Information" });
      break;
    case "rules":
      router.push({ name: "Rules" });
      break;
    case "privacy":
      router.push({ name: "Privacy" });
      break;
    default:
      break;
  }
};
</script>

<style lang="scss" scoped></style>
