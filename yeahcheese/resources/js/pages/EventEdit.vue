<template>
    <div id="event-edit">
        <button
            type="button"
            class="btn btn-primary btn-lg"
            @click="updateEvent"
        >
            更新
        </button>
        <div id="event-form-wrapper">
            <validation-messages
                :errors="errors"
            >
            </validation-messages>
            <div class="form-group">
                <label for="name">イベント名</label>
                <input
                    id="name"
                    class="form-control form-control-lg"
                    type="text"
                    :value="event.name"
                >
            </div>
            <div class="form-group">
                <label for="start-date">公開開始日</label>
                <div class="col-10">
                    <input
                        id="start-date"
                        class="form-control form-control-lg"
                        type="date"
                        :value="event.start_date"
                    >
                </div>
            </div>
            <div class="form-group">
                <label for="end-date">公開終了日</label>
                <div class="col-10">
                    <input
                        id="end-date"
                        class="form-control form-control-lg" 
                        type="date"
                        :value="event.end_date"
                    >
                </div>
            </div>
            <div class="event-photos">
                <div
                    class="photos"
                    v-for="photo in photos"
                    :key="photo.id"
                >
                    {{ photo.image_path }}
                    <!-- 
                        // TODO: 写真一枚一枚に削除ボタン追加
                    -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
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
];
/**
 * [イベント編集] - イベント情報の更新と写真の追加・削除が可能
 * ? 必要な情報
 *  * 単一のイベント情報
 *   * created内でstoreにあるeventsからルートパラメータのイベントを取得
 *   * 更新時に参照するため、eventに格納
 *  * イベントに紐づく写真情報
 *   * イベントのリレーションから取得
 *   * 削除時に参照するため、photosに格納
 * ? 表示させる情報
 *  * イベント名
 *  * 公開開始日
 *  * 公開終了日
 *  * イベントに紐づく写真(今は仮でpathだけ表示)
 * ! Laravel側で修正が必要かもしれない部分
 * ! * バリデーションエラーの場合、送信されてきたイベント情報をオウム返しする（これをVueで受け取り、再度表示させる）
 */
import { mapGetters, mapActions } from 'vuex';
import validationMessages from "../components/validationMessages";
export default {
    name: 'EventEdit',
    components: {
        validationMessages
    },
    data() {
        return {
            event: null,
            photos: null,
            validationMessages: []
        }
    },
    computed: {
        ...mapGetters({
            isSuccess: 'status/isApiSuccess'
        }),
        isValid() {
            return function(form_name) {
                return Object.keys(this.validationMessages).includes(form_name)
                ? "is-invalid"
                : "";
            };
        },
        errors() {
            var response = [];
            Object.values(this.validationMessages).forEach(val => {
                if (Array.isArray(val)) {
                val.forEach(innerText => {
                    response.push(innerText);
                });
                } else {
                response.push(val);
                }
            });
            return response;
        }
    },
    methods: {
        ...mapActions('events', [
            'eventUpdate'
        ]),
        getEvents() {
            return events;
        },
        setPhotos(event) {
            if (Array.isArray(event.photos)) {
                this.photos = event.photos;
            }
        },
        updateEvent() {
            // TODO: 定義したアクションを呼び出し、結果を再度eventに挿入
            const payload = {
                id: this.event,
                event: this.event
            };
            const response = this.eventUpdate(payload);
            this.validate(response);
        },
        validate(response) {
            if (this.isSuccess === false) {
                console.log(response);
                this.validationMessages = response;
            } else {
                this.$router.push({
                    'name': 'eventShow',
                    'params': {
                        id: this.event.id
                    }
                });
            }
        }
    },
    created() {
        const events = this.getEvents();
        const event_id = Number.parseInt(this.$route.params.id);
        const event = events.filter((event) => {
            return event.id === event_id;
        });
        this.event = event;
        this.setPhotos(this.event);
    }
}
</script>

<style scoped>
#event-edit {
    position: relative;
}
#event-edit #name {
    margin-left: 16px;
}
#event-edit button {
    margin-bottom: 80px;
}
</style>
