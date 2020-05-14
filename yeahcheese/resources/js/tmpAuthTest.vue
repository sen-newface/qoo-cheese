<template>
  <div>
    <div v-if="!this.token">
      ログインフォーム
      <br />
      <input type="email" v-model="form.email" />
      <br />
      <input type="password" v-model="form.password" />
      <br />
      <button type="button" @click="login">ログイン</button>
    </div>
    <div v-if="!this.token">
      作成
      <br />
      <input type="name" v-model="form.name" />
      <br />
      <input type="email" v-model="form.email" />
      <br />
      <input type="password" v-model="form.password" />
      <br />
      <button type="button" @click="signup">作成</button>
    </div>
    <div v-else>
      ログイン中！
      <br />
    </div>
    <button type="button" @click="getUser">ユーザー情報を取得</button>
    <button type="button" @click="logout">ログアウト</button>
  </div>
</template>

<script>
export default {
  name: "App",
  data() {
    return {
      form: {
        name: "test",
        email: "aa@aa.com",
        password: ""
      },
      token: ""
    };
  },
  created() {
    this.getUser();
  },

  methods: {
    login() {
      const url = "/api/login";
      const params = {
        email: this.form.email,
        password: this.form.password
      };
      axios
        .post(url, params)
        .then(response => {
          console.log(response);
          this.token = response.data.token;
          localStorage.setItem("authKey", this.token);
        })
        .catch(error => {
          console.log(error);
          console.log("ログインに失敗しました。");
        });
    },

    signup() {
      axios.post("/api/signup", this.form).then(
        response => {
          console.log(response);
          this.token = response.data.token;
          console.log(this.token);
          localStorage.setItem("authKey", this.token);
        },
        e => {
          console.log(e);
        }
      );
    },

    getUser() {
      let token = localStorage.getItem("authKey");
      let headers = {
        Accept: "application/json",
        Authorization: "Bearer " + token
      };
      axios
        .get("/api/user", {
          headers
        })
        .then(
          response => {
            console.log(response); // ユーザー情報を取得
            this.token = response.data.token;
          },
          e => {
            localStorage.removeItem("authKey");
            this.token = "";
          }
        );
    },
    logout() {
      localStorage.removeItem("authKey");
      this.token = "";
    }
  }
};
</script>

<style>
</style>
