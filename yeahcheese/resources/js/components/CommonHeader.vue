<template>
    <header id="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <router-link class="top-link" to="/"><span class="title">Yeahcheese</span></router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <router-link to="/">トップへ戻る</router-link>
                </li>
                <!-- ログイン時 -->
                <template>
                    <li class="nav-item">
                        <router-link to="/events">イベント一覧</router-link>
                    </li>
                    <li class="nav-item">
                        <form @submit.prevent="logout">
                            <button type="submit">ログアウト</button>
                        </form>
                    </li>
                </template>
                <!-- 未ログイン時 -->
                <template>
                    <li class="nav-item">
                        <router-link to="/login">ログイン</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/register">アカウント作成</router-link>
                    </li>
                </template>
                </ul>
                </form>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    name: 'CommonHeader',
}
</script>

<style scoped>
#header .top-link {
    text-decoration: none;
}
#header .title {
    font-size: 2em;
    color: #2b2828;
}
#navbarSupportedContent * {
    color: #007bff;
}
#navbarSupportedContent li {
    margin-bottom: 16px;
}
#navbarSupportedContent li:first-child {
    margin-top: 24px;
}
button {
    outline: none;
}
form button {
    outline: none;
    border: none;
    text-align: left;
    padding: 0;
    background-color: rgba(0, 0, 0, 0);
}
</style>
