<template>
    <div id="base-event">
        <!-- イベント詳細を表示するコンポーネント内で、paramsで渡したidを用いてイベント情報を取得できる？ -->
        <router-link class="to-event-detail-link" :to="{ name: 'eventShow', params: { id: eventInfo.id } }"></router-link>
        <div class="event-texts">
            <span class="event-name">イベント名：{{ eventInfo.name }}</span>
            <span class="auth-key">認証キー：{{ eventInfo.key }}</span>
            <span class="event-date">期限：{{ eventInfo.start_date }} - {{ eventInfo.end_date }}</span>
        </div>
        <div class="event-photos">
            <!-- photosには『2枚』の写真まで挿入できる  -->
            <span
                v-for="photo in eventInfo.photos"
                :key="photo.id"
                class="event-photo"
            >
                <img :src="photo.image_path" :alt="alt(photo.id)">
            </span>
        </div>
    </div>
</template>

<script>
export default {
    name: 'BaseEvent',
    props: {
        eventInfo: {
            type: Object
        }
    },
    computed: {
        alt() {
            return function (id) {
                return this.eventInfo.name + 'の写真' + id;
            }
        }
    }
}
</script>

<style scoped>
h2,
h3 {
    text-align: center;
}
#base-event {
    position: relative;
    width: 80vw;
    margin: 0 auto 16px;
    padding: 16px 16px 8px 0;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}
#base-event * {
    font-size: 1.2em;
    color: #2a2929;
    margin: 0 32px;
}
#base-event::after {
    content: '';
    display: block;
    clear: both;
}
#base-event:hover {
    background-color: rgba(250, 159, 40, 0.2);
}
.to-event-detail-link {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
.event-texts {
    float: left;
    padding: 8px;
    border-left: 10px solid rgba(250, 159, 40, 0.9);
    border-radius: 8px 0 0 8px;
}
.event-photos {
    float: right;
}
.event-photos::after {
    content: '';
    display: block;
    clear: both;
}
.event-photos .event-photo {
    position: relative;
    display: inline-block;
    width: 100px;
    height: 100px;
    border: 1px solid rgba(0, 0, 0, 0.3);
    border-radius: 5px;
    margin-left: 16px;
}
.event-photos .event-photo img {
    position: absolute;
    top: 0;
    left: -32px;
    display: inline-block;
    width: inherit;
    height: inherit;
    background-color: rgba(250, 159, 40, 0.2);
    font-size: 0.7em;
}
.event-photos .event-photo:first-child {
    margin-left: 0;
}
/** ここまで  */
</style>
