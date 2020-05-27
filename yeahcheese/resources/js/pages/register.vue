<template>
  <form @submit.prevent="register">
    <validationMessages :errors="valiMessages" />
    <div class="form-group">
      <label for="name">名前</label>
      <input
        type="text"
        class="form-control"
        :class="isValid('name')"
        id="name"
        placeholder="名前"
        v-model="registerForm.name"
      />
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">メールアドレス</label>
      <input
        type="email"
        class="form-control"
        :class="isValid('email')"
        id="exampleInputEmail1"
        placeholder="メールアドレス"
        v-model="registerForm.email"
      />
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">パスワード</label>
      <input
        type="password"
        class="form-control"
        :class="isValid('password')"
        id="exampleInputPassword1"
        placeholder="パスワード"
        v-model="registerForm.password"
      />
    </div>
    <div class="form-group">
      <label for="password_conf">パスワード確認</label>
      <input
        type="password"
        class="form-control"
        :class="isValid('password')"
        id="password_conf"
        placeholder="パスワード確認"
        v-model="registerForm.password_confirmation"
      />
    </div>
    <button type="submit" class="btn btn-primary">登録</button>
  </form>
</template>

<script>
import api from "../api";
import { mapGetters } from "vuex";
import validationMessages from "../components/validationMessages";
export default {
  name: "Register",
  components: {
    validationMessages
  },
  data() {
    return {
      registerForm: {
        name: "",
        email: "",
        password: "",
        password_confirmation: ""
      },
      validationMessages: []
    };
  },
  computed: {
    ...mapGetters({
      isApiSuccess: "status/isApiSuccess"
    }),
    isValid() {
      return function(form_name) {
        return Object.keys(this.validationMessages).includes(form_name)
          ? "is-invalid"
          : "";
      };
    },
    valiMessages() {
      var response = [];
      Object.values(this.validationMessages).forEach(val => {
        if (Array.isArray(val)) {
          val.forEach(innerText => {
            response.push(innerText);
          });
        } else {
          response.push(val);
        }
      });
      return response;
    }
  },
  methods: {
    async register() {
      this.delValidation();
      if (this.emptyCheckValidation()) {
        this.validationMessages = ["入力内容に不備があります"];
        return false;
      }
      const response = await this.$store.dispatch(
        "users/register",
        this.registerForm
      );

      if (this.isApiSuccess) {
        this.$router.push({ path: "/events" });
      } else {
        this.validationMessages = response;
      }
    },
    delValidation() {
      this.validationMessages = [];
    },
    emptyCheckValidation() {
      const values = Object.values(this.registerForm);
      return values.some(val => {
        return val.trim() === "";
      });
    }
  }
};
</script>
