import { defineStore } from "pinia";

export const useStoreAuth = defineStore("auth", {
  state: () => ({
    user: null,
  }),

  actions: {
    async currentUser() {
      const isLoggedIn = await axios
        .get("/api/user")
        .then((res) => {
          this.user = res.data;
          // console.log(res.data);
          return true;
        })
        .catch((err) => {
          // console.log(err);
          return false;
        });
      return isLoggedIn;
    },
  },
});
