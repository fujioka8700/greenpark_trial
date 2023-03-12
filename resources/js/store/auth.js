import { defineStore } from "pinia";

export const useStoreAuth = defineStore("auth", {
  state: () => ({
    count: 1,
  }),
});
