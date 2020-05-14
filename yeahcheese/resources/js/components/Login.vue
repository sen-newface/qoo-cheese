<template>
    <div>
        <div class="mx-auto col-md-6">
            <p>Eメール：<input type="text" class="form-control" v-model="email"  @keyup.enter="login()" placeholder="メールアドレスを入力してください"></p>
            <p>パスワード：<input type="password" class="form-control" v-model="password" @keyup.enter="login()" placeholder="パスワードを入力してください"></p>
            <button @click="login()" class="btn btn-outline-primary">送信する</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: "",
            password: ""
        };
    },
    methods: {
        login() {  // ボタンを押した時に呼び出される
            if(this.email === "" || this.password === "") {
                console.log("メールアドレスとパスワードを入力してください");
            }
            else console.log(this.email, this.password);
        }
    }
}
</script>

<style scoped>

</style>
