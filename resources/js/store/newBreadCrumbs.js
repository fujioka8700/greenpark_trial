import { defineStore } from "pinia";

export const useStoreNewBreadCrumbs = defineStore("newBreadCrumbs", {
  state: () => ({
    items: [
      {
        title: "図鑑トップ",
        disabled: true,
        to: "/",
      },
    ],
  }),
  actions: {
    /**
     * パンくずリスト2個目を追加する
     * クリックはできないようにしている
     * @param {String} title
     */
    addToBreadcrumbs(title) {
      this.enableTop();

      if (this.items.length >= 2) {
        this.items.pop();
      }

      this.items.push({
        title,
        disabled: true,
      });
    },
    /**
     * 「図鑑トップ」をクリックできるようにする
     */
    enableTop() {
      this.items[0].disabled = false;
    },
  },
});
