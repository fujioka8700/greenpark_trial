import { defineStore } from "pinia";
import { HTTP_OK } from "../util";

export const useStoreAuth = defineStore("auth", {
  state: () => ({
    user: null,
    errorMessage: null,
  }),

  actions: {
    async currentUser() {
      await axios
        .get("/api/user")
        .then((res) => {
          this.user = res.data;
        })
        .catch((err) => {});
    },

    login(email, pass) {
      axios
        .get("/sanctum/csrf-cookie")
        .then((res) => {
          axios
            .post("/api/login", {
              email: email,
              password: pass,
            })
            .then((res) => {
              if (res.data.status_code === HTTP_OK) {
                this.errorMessage = null;

                this.router.push("/about");
              } else {
                this.errorMessage = "ログインに失敗しました。";
              }
            })
            .catch((err) => {
              this.errorMessage = "ログインに失敗しました。";
            });
        })
        .catch((err) => {});
    },

    logout() {
      this.user = null;

      axios
        .post("/api/logout")
        .then((res) => {
          this.router.push("/login");
        })
        .catch((err) => {});
    },

    register(name, email, pass) {
      axios
        .post("/api/register", {
          name: name,
          email: email,
          password: pass,
        })
        .then((res) => {
          if (res.status === HTTP_OK) {
            this.errorMessage = null;

            this.login(email, pass);
          } else {
            this.errorMessage = "登録を失敗しました。";
          }
        })
        .catch((err) => {
          this.errorMessage = "登録を失敗しました。";
        });
    },
  },
});
