<template>
    <div id="event-edit">
    </div>
</template>

<script>
/**
 * [イベント編集] - イベント情報の更新と写真の追加・削除が可能
 * * 必要な情報
 *  * 単一のイベント情報
 *   * created内でstoreにあるeventsからルートパラメータのイベントを取得
 *   * 更新時に参照するため、eventに格納
 *  * イベントに紐づく写真情報
 *   * イベントのリレーションから取得
 *   * 削除時に参照するため、photosに格納
 */
// ! 本来はルートコンポーネントでログイン確認後に
// ! ユーザーと紐づくイベント一覧を取得しているはずなので必要なし
const events = [
    {
        id: 1,
        name: '運動会',
        key: 'doaj432joj53io2oi2',
        start_date: '2020-07-12',
        end_date: '2020-09-21',
        user_id: 3,
        photos: [
            {
                id: 1,
                image_path: 'yeah1.jpeg'
            },
            {
                id: 2,
                image_path: 'yeah2.jpeg'
            },
            {
                id: 3,
                image_path: 'yeah3.jpeg'
            }
        ]
    },
    {
        id: 2,
        name: '餅つき大会',
        key: 'doaj432joj53io2oi2',
        start_date: '2020-07-12',
        end_date: '2020-09-21',
        user_id: 3,
        photos: [
            {
                id: 5,
                image_path: 'mochi1.jpeg'
            },
            {
                id: 6,
                image_path: 'mochi2.jpeg'
            }
        ]
    },
    {
        id: 3,
        name: '芋掘り大会',
        key: 'doaj432joj53io2oi2',
        start_date: '2020-07-12',
        end_date: '2020-09-21',
        user_id: 3,
        photos: [
            {
                id: 7,
                image_path: 'imo1.jpeg'
            },
            {
                id: 8,
                image_path: 'imo2.jpeg'
            },
            {
                id: 9,
                image_path: 'imo3.jpeg'
            },
            {
                id: 10,
                image_path: 'imo4.jpeg'
            }
        ]
    }
]
export default {
    name: 'EventEdit',
    data() {
        return {
            events: null
        }
    },
    methods: {
        getEvents() {
            return events;
        }
    },
    created() {
        this.events = getEvents();
    }
}
</script>

<style scoped>
</style>
