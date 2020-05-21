<template>
  <div id="event-edit">
    <button type="button" class="btn btn-primary btn-lg" @click="updateEvent">更新</button>
    <div id="event-form-wrapper">
      <validation-messages :errors="valiMessages"></validation-messages>
      <div class="form-group">
        <label for="name">イベント名</label>
        <input
          id="name"
          class="form-control form-control-lg"
          :class="isValid('name')"
          type="text"
          v-model="eventForm.name"
        />
      </div>
      <div class="form-group">
        <label for="start-date">公開開始日</label>
        <div class="col-10">
          <input
            id="start-date"
            class="form-control form-control-lg"
            :class="isValid('start_date')"
            type="date"
            v-model="eventForm.start_date"
          />
        </div>
      </div>
      <div class="form-group">
        <label for="end-date">公開終了日</label>
        <div class="col-10">
          <input
            id="end-date"
            class="form-control form-control-lg"
            :class="isValid('end_date')"
            type="date"
            v-model="eventForm.end_date"
          />
        </div>
      </div>
      <preview-and-save-photo :event-id="eventForm.id" @photo-errors="pushErrors($event)"></preview-and-save-photo>
      <div class="event-photos">
        <div class="photos" v-for="photo in photos" :key="photo.id">
          <img :src="transformImgPath(photo.image_path)" />
          <!-- 
                        // TODO: 写真一枚一枚に削除ボタン追加
          -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
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
import { mapGetters, mapActions } from "vuex";
import validationMessages from "../components/validationMessages";
import PreviewAndSavePhoto from "../components/PreviewAndSavePhoto";
export default {
  name: "EventEdit",
  components: {
    validationMessages,
    PreviewAndSavePhoto
  },
  data() {
    return {
      photos: [],
      eventForm: {
        name: "",
        start_date: "",
        end_date: ""
      },
      validationMessages: []
    };
  },
  computed: {
    ...mapGetters({
      isSuccess: "status/isApiSuccess"
    }),
    isValid() {
      return function(form_name) {
        return Object.keys(this.validationMessages).includes(form_name)
          ? "is-invalid"
          : "";
      };
    },
    valiMessages() {
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
    ...mapActions("events", ["eventUpdate", "eventShow"]),
    async getEvent(event_id) {
      const response = await this.eventShow({ id: event_id });
      if (this.isSuccess) {
        this.eventForm = response;
        this.setPhotos(this.eventForm);
      }
      return false;
    },
    setPhotos(event) {
      if (Array.isArray(event.photos)) {
        this.photos = event.photos;
      }
    },
    async updateEvent() {
      // TODO: 定義したアクションを呼び出し、結果を再度eventに挿入
      const payload = {
        id: this.eventForm.id,
        event: {
          name: this.eventForm.name,
          start_date: this.eventForm.start_date,
          end_date: this.eventForm.end_date
        }
      };
      const response = await this.eventUpdate(payload);
      if (this.isSuccess === false) {
        this.validationMessages = response;
      } else {
        this.$router.push({
          name: "eventShow",
          params: {
            id: this.eventForm.id
          }
        });
      }
    },
    pushErrors(errors) {
      this.validationMessages = errors;
    },
    transformImgPath(image_path) {
      return image_path.replace("public", "");
    }
  },
  mounted() {
    const event_id = Number.parseInt(this.$route.params.id);
    this.getEvent(event_id);
  }
};
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
