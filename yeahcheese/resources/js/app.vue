<template>
    <div id="app">
        <common-header></common-header>
        <router-view></router-view>
    </div>
</template>

<script>
import CommonHeader from './components/CommonHeader.vue';
export default {
    name: 'App',
    components: {
        CommonHeader
    }
}
</script>

<style>

</style>
