<template>
  <div id="event-edit">
    <AlertModel :isShow="openAlertModel" @close-modal="closeModal">
      <p slot="alert-text">編集内容を保存していません</p>
      <button class="modal-btn save-btn" slot="additional" @click="saveAndMove(true)">⓵変更を保存して移動</button>
      <button class="modal-btn unsave-btn" slot="additional" @click="saveAndMove(false)">②変更を保存せずに移動</button>
    </AlertModel>
    <router-link
      class="btn btn-outline-info mb-5"
      :to="{ name: 'eventShow', params: { id: eventForm.id } }"
    >詳細へ戻る</router-link>
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
      <button type="button" class="btn btn-primary btn-lg" @click="updateEvent">更新</button>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import validationMessages from "../components/validationMessages";
import PreviewAndSavePhoto from "../components/PreviewAndSavePhoto";
import AlertModel from "../components/AlertModal";
export default {
  name: "EventEdit",
  components: {
    validationMessages,
    PreviewAndSavePhoto,
    AlertModel
  },
  data() {
    return {
      photos: [],
      eventForm: {
        name: "",
        start_date: "",
        end_date: ""
      },
      validationMessages: [],
      isUnsave: false,
      openAlertModel: false,
      transitionPath: null
    };
  },
  computed: {
    ...mapGetters({
      isSuccess: "status/isApiSuccess",
      getEventForId: "events/getEventForId",
      tmpEvent: "events/tmpEvent"
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
  watch: {
    eventForm: {
      handler: function(newFormData, oldFormData) {
        // セーブしていない、尚且つデータに変更があった場合のみ、アンセーブにする
        // 一度isUnsaveをtrueにすれば、isInitDataは起動されない
        if (
          this.isUnsave === false &&
          this.isInitData(newFormData, oldFormData)
        ) {
          this.isUnsave = true;
        }
      },
      deep: true
    }
  },
  methods: {
    ...mapActions("events", ["eventUpdate"]),
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
      if (this.isSuccess) {
        this.$router.push({
          name: "eventShow",
          params: { id: this.eventForm.id }
        });
      } else {
        this.validationMessages = response;
      }
    },
    pushErrors(errors) {
      this.validationMessages = errors;
    },
    registerReloadEvent() {
      console.log("ok");
      const self = this;
      window.addEventListener("beforeunload", function(e) {
        if (self.isUnsave) {
          e.preventDefault();
          e.returnValue = "chotomate";
        }
      });
    },
    isInitData(newData, oldData) {
      // ! watchで受け取った変更前と変更後のデータを比較
      // ! watchで受け取った変更前の初期値(newData)がイベント情報
      // ! watchで受け取った変更後の初期値(oldData)が空
      // ! => 初回だけfalseが返るメソッド
      // ! => 以降はnewDataもoldDataも同じ値のため、常にtrueを返す
      const {
        name: newName,
        start_date: newStartDate,
        end_date: newEndDate
      } = newData;
      const {
        name: oldName,
        start_date: oldStartDate,
        end_date: oldEndDate
      } = oldData;
      return (
        oldName === newName ||
        oldStartDate === newStartDate ||
        oldEndDate == newEndDate
      );
    }
  },
  async created() {
    let event_id = this.$route.params["id"];
    await this.$store.dispatch("events/getEventsAndPhotosIfNotExits", event_id);
    this.eventForm = this.getEventForId(event_id);
    this.registerReloadEvent(); //リロード対策
  },
  beforeRouteLeave(to, from, next) {
    if (this.isUnsave) {
      this.openAlertModel = true;
      this.transitionPath = to.fullPath; // !保存せずに移動するとき使用
    } else {
      next();
    }
  },
  beforeDestroy() {
    // TODO: 保存フラグを確認して、trueなら入力値を更新するapiを起動させる
    // TODO:                   falseならフルパスを取得してRoutePush
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
.modal-btn {
  color: white;
  margin-top: 24px;
  margin-bottom: 0;
}
.save-btn {
  background-color: dodgerblue;
}
.unsave-btn {
  background-color: indianred;
}
</style>
