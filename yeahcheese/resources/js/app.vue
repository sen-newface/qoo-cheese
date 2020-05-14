<template>
    <div id="app">
        <div class="container mt-5">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import Index from './pages/index'

export default {
    name: 'App',
    components: {
        Index
    }
}
</script>

<style>
</style>
