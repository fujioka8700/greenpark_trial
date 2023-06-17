import { defineStore } from "pinia";

export const useStorePlant = defineStore("plant", {
  state: () => ({
    /** @type {Number} 削除した植物id */
    destroyedPlantId: null,
  }),

  actions: {
    setDestroyedPlantId(plantId) {
      this.destroyedPlantId = plantId;
    },
  },
});
