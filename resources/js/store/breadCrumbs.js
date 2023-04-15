import { defineStore } from "pinia";

export const useStoreBreadCrumbs = defineStore("breadCrumbs", {
  state: () => ({
    /** @type {Object} パンくずリスト */
    items: [
      {
        text: "図鑑トップ",
        to: "/",
      },
    ],
  }),
  actions: {
    /**
     * パンくずリストを追加する
     * @param {Object} url リンクするテキストとURL
     */
    push(url) {
      /** @type {Object} パンくずリストの末尾 */
      const last = this.items.slice(-1)[0];

      // 被っていなければ、パンくずリストに追加する
      if (last.text !== url.text) {
        this.items.push(url);
      }
    },
  },
});
