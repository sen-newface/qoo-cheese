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
    <router-link
      class="btn btn-outline-primary float-right"
      :to="{ name: 'eventShow', params: { id: 1 } }"
    >1</router-link>
    <router-link
      class="btn btn-outline-primary float-right"
      :to="{ name: 'eventShow', params: { id: 2 } }"
    >2</router-link>
    <router-link
      class="btn btn-outline-primary float-right"
      :to="{ name: 'eventShow', params: { id: 3 } }"
    >3</router-link>
    <router-link
      class="btn btn-outline-primary float-right"
      :to="{ name: 'eventShow', params: { id: 4 } }"
    >4</router-link>
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
