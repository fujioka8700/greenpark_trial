import { defineStore } from "pinia";
import { HTTP_OK } from "../util";

export const useStoreAuth = defineStore("auth", {
  state: () => ({
    /** @type {Object} ログインユーザーの情報 */
    user: null,

    /** @type {string} ログイン失敗時のエラーメッセージ */
    errorMessage: null,
  }),

  actions: {
    /**
     * ログイン中のユーザー情報を取得する
     */
    async currentUser() {
      await axios
        .get("/api/user")
        .then((res) => {
          this.user = res.data;
        })
        .catch((err) => {});
    },

    /**
     * ログインする
     * @param {string} email ログインするメールアドレス
     * @param {string} pass  ログインするためのパスワード
     */
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
                this.errorMessage = "入力項目に不備があります。";
              }
            })
            .catch((err) => {
              this.errorMessage = "入力項目に不備があります。";
            });
        })
        .catch((err) => {});
    },

    /**
     * ログアウトする
     */
    logout() {
      this.user = null;

      axios
        .post("/api/logout")
        .then((res) => {
          this.router.push("/login");
        })
        .catch((err) => {});
    },

    /**
     * 新たなユーザーを登録する
     * @param {string} name  新ユーザーの名前
     * @param {string} email 新ユーザーのメールアドレス
     * @param {string} pass  新ユーザーのパスワード
     * @retrun {Object} ユーザー登録状態
     */
    register(name, email, pass) {
      const response = axios
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
            this.errorMessage = "入力項目に不備があります。";
          }

          return res.data;
        })
        .catch((err) => {
          this.errorMessage = "入力項目に不備があります。";

          return err.response.data;
        });

      return response;
    },
  },
});
