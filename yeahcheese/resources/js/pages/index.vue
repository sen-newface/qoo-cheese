<template>
  <div class="mx-auto col-md-6">
    <p>
      認証キー：
      <input
        type="text"
        class="form-control"
        v-model="authKey"
        @keyup.enter="findAuthKey()"
        placeholder="認証キーを入力してください"
      />
    </p>
    <button @click="findAuthKey()" class="btn btn-outline-primary">送信する</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      authKey: ""
    };
  },
  methods: {
    findAuthKey() {
      // ボタンを押した時に呼び出される
      if (this.authKey.trim() === "") {
        console.log("入力してください");
      } else console.log(this.authKey);
    }
  }
};
</script>

<style scoped>
</style>
