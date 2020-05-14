<template>
    <div class="mx-auto col-md-6">
        <p>認証キー：<input type="text" class="form-control" v-model="authKey" @keyup.enter="findAuthKey(authKey)" placeholder="認証キーを入力してください"></p>
        <button @click="findAuthKey(authKey)" class="btn btn-outline-primary">送信する</button>
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
        findAuthKey(key) {  // ボタンを押した時に呼び出される
            if(key === "") {
                console.log("入力してください");
            }
            else console.log(key);
        }
    }
}
</script>

<style scoped>

</style>
