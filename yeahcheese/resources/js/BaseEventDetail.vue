<template>
    <div id="base-event-detail" class="container">
        <h2>イベント詳細</h2>
        <p class="event-name">イベント名：{{ eventInfo.name }}</p>
        <p class="auth-key">認証キー：{{ eventInfo.key }}</p>
        <p class="event-date">期限：{{ eventInfo.start_date }} - {{ eventInfo.end_date }}</p>
        <h3>写真一覧</h3>
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
#base-event-detail * {
    font-size: 1.5em;
    color: #2a2929;
    margin-top: 16px;
}
/** ここから下は後に削除 */
h2,
h3 {
    text-align: center;
}
.event-photos {
    display: flex;
}
.event-photos .event-photo {
    font-size: 1.0em;
    border: 1px solid rgba(0, 0, 0, 0.3);
    border-radius: 5px;
    padding: 40px;
    margin-left: 16px;
}
.event-photos .event-photo:first-child {
    margin-left: 0;
}
/** ここまで  */
</style>
