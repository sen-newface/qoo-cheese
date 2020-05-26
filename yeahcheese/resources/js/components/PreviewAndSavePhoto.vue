<template>
  <div id="preview-and-save-photo">
    <label v-show="canAdd">
      <span type="button" class="btn btn-outline-success ml-4">写真追加</span>
      <input id="add-button" type="file" @change="loadPhoto" accept="image/*" />
    </label>
    <div class="lap" v-if="preview">
      <validationMessages :errors="valiMessages" />
      <div class="innner_lap">
        <p class="contnt" id="preview-photo">
          <img :src="preview" />
          <span style="display: block; text-align: center;">{{file.name}}</span>
        </p>
        <label class="mt-3" v-show="!canAdd">
          <button id="save-button" class="btn btn-success" @click="upPhoto">保存</button>
          <label for="add-button" type="button" class="btn btn-info" style="margin-bottom: 0">選び直す</label>
          <button id="cancel-button" class="btn btn-warning" @click="upCancel">キャンセル</button>
        </label>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import validationMessages from "../components/validationMessages";
import scrollControllable from "../mixins/scrollControllable";
export default {
  name: "PreviewAndSavePhoto",
  components: {
    validationMessages
  },
  props: {
    eventId: {
      type: Number
    }
  },
  data() {
    return {
      canAdd: true,
      file: null,
      preview: null,
      error: null,
      validationMessages: []
    };
  },
  computed: {
    ...mapGetters({
      isSuccess: "status/isApiSuccess"
    }),
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
    ...mapActions("photos", ["postPhoto", "setPhotosForEventId"]),
    async loadPhoto(e) {
      this.delValidation();
      const files = e.target.files || e.DataTransfer.files;
      this.file = files[0];
      const response = await this.createPhoto(this.file);
    },
    async upPhoto() {
      let data = new FormData();
      data.append("event_id", this.eventId);
      data.append("image_path", this.file);
      this.delValidation();
      const response = await this.postPhoto({ id: this.eventId, data: data });

      if (this.isSuccess) {
        document.getElementById("add-button").value = "";
        this.canAdd = true;
        this.file = null;
        this.preview = null;
      } else {
        this.validationMessages = response;
      }
    },
    async createPhoto(file) {
      const fr = new FileReader();
      fr.readAsDataURL(this.file);
      fr.onload = res => {
        this.preview = res.target.result;
        this.canAdd = false;
      };
      fr.onerror = err => {
        this.error = err;
        this.canAdd = true;
        this.file = null;
        this.preview = null;
      };
    },
    upCancel() {
      document.getElementById("add-button").value = "";
      this.canAdd = true;
      this.file = null;
      this.preview = null;
    },
    delValidation() {
      this.validationMessages = [];
    }
  },
  watch: {
    preview: {
      handler(val) {
        if (val) {
          this.no_scroll();
        } else {
          this.return_scroll();
        }
      }
    }
  },
  mixins: [scrollControllable]
};
</script>

<style scoped>
#preview-photo {
  margin-bottom: 0 !important;
  text-align: center;
}
#preview-photo img {
  object-fit: cover;
  max-width: 100%;
}
#add-button {
  display: none;
}
.lap {
  width: 100vw;
  height: 100vh;
  background: gray;
  position: absolute;
  top: 0;
  left: 0;
  background: rgba(45, 45, 45, 0.5);
  position: fixed;
}

.innner_lap {
  background: white;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  max-width: 88%;
  max-height: 88%;
  padding: 21px;
}
</style>
