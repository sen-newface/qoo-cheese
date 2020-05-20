<template>
  <form @submit.prevent="login">
    <validationMessages :errors="validationMessages" />
    <div class="form-group">
      <label for="exampleInputEmail">メールアドレス</label>
      <input
        type="email"
        class="form-control"
        id="exampleInputEmail"
        placeholder="メールアドレス"
        v-model="loginForm.email"
      />
    </div>
    <div class="form-group">
      <label for="exampleInputPassword">パスワード</label>
      <input
        type="password"
        class="form-control"
        id="exampleInputPassword"
        placeholder="パスワード"
        v-model="loginForm.password"
      />
    </div>
    <button type="submit" class="btn btn-primary">ログイン</button>
  </form>
</template>

<script>
import api from "../api";
import { mapGetters } from "vuex";
import validationMessages from "../components/validationMessages";

export default {
  name: "Login",
  components: {
    validationMessages
  },
  data() {
    return {
      loginForm: {
        email: "",
        password: ""
      },
      validationMessages: []
    };
  },
  computed: {
    ...mapGetters({
      isApiSuccess: "status/isApiSuccess"
    })
  },
  methods: {
    async login() {
      this.delValidation();
      if (
        this.loginForm.email.trim() === "" ||
        this.loginForm.password.trim() === ""
      ) {
        this.validationMessages.push(
          "メールアドレスとパスワードを入力してください"
        );
        return false;
      }
      const response = await this.$store.dispatch(
        "users/login",
        this.loginForm
      );
      if (this.isApiSuccess) {
        this.$router.push({ path: "/events" });
      } else {
        this.validationMessages.push(
          "メールアドレスかパスワードが間違っています"
        );
      }
    },
    delValidation() {
      this.validationMessages = [];
    }
  }
};
</script>
