<template>
    <div id="app">
        <common-header></common-header>
        <div class="container mt-5">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import Index from './pages/index'
import CommonHeader from './components/CommonHeader.vue';
export default {
    name: 'App',
    components: {
        Index,CommonHeader
    }
}
</script>

<style>
</style>
