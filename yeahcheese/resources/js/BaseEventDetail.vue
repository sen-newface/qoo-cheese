<template>
    <div id="base-event-detail" class="container">
        <p class="event-name">イベント名：{{ eventInfo.name }}</p>
        <p class="auth-key">認証キー：{{ eventInfo.key }}</p>
        <p class="event-date">期限：{{ eventInfo.start_date }}-{{ eventInfo.end_date }}</p>
        <div class="event-photos">
            <div 
                v-for="photo in eventInfo.photos"
                :key="photo.id"
                class="event-photo"
             >
                {{ photo.name }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        eventInfo: {
            type: Object
        }
    }
}
</script>

<style scoped>

</style>
