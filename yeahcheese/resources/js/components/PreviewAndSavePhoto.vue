<template>
  <div id="preview-and-save-photo">
    <label>
      <span type="button" class="btn btn-outline-success" :class="isFullWidth">写真追加</span>
      <input id="add-button" type="file" @change="loadPhoto" accept="image/*" multiple="multiple" />
    </label>
    <validationMessages v-show="!files.length" :errors="valiMessages" />
    <div class="wrap" v-if="files.length" id="previewPhotos">
      <validationMessages v-show="files.length" :errors="valiMessages" />
      <div class="inner_wrap">
        <div id="preview-photo">
          <div class="preview_box" v-for="(preview, index) in files" :key="`preview${index}`">
            <img :src="preview.preview" class="rounded" />
            <span class="file_name" style="display: block; text-align: center;">{{preview.name}}</span>
            <i class="file_remove fa fa-times" @click="removeFile(index)"></i>
            <input
              type="text"
              v-model="files[index].title"
              style="margin-top: 7px;"
              placeholder="画像タイトル"
            />
          </div>
        </div>
        <label class="mt-3 buttons">
          <button id="save-button" class="btn btn-success" @click="upPhoto">保存</button>
          <label for="add-button" type="button" class="btn btn-info" style="margin-bottom: 0">追加する</label>
          <button id="cancel-button" class="btn btn-warning" @click="upCancel">キャンセル</button>
        </label>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import validationMessages from "../components/validationMessages";
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
      files: [],
      error: null,
      validationMessages: []
    };
  },
  computed: {
    ...mapGetters({
      isSuccess: "status/isApiSuccess",
      accessDevice: "display/accessDevice"
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
      return response.filter((x, i, self) => self.indexOf(x) === i);
    },
    isFullWidth() {
      return this.accessDevice ? "ml-4 mr-4" : "is-full-width";
    }
  },
  methods: {
    ...mapActions("photos", ["postPhotos", "setPhotosForEventId"]),
    //preview関連始まり
    async loadPhoto(e) {
      this.delValidation();
      let files = await this.fileListToBase64(e);
      this.files = this.files.concat(files.filter(f => f !== null));
    },
    async fileListToBase64(e) {
      const promises = [];
      const files = e.target.files || e.DataTransfer.files;
      for (let i = 0; i < files.length; i++) {
        promises.push(this.createPhotos(files[i]));
      }
      return await Promise.all(promises);
    },
    createPhotos(file) {
      const fr = new FileReader();
      fr.readAsDataURL(file);
      return new Promise(resolve => {
        fr.onload = res => {
          if (file.size > 2000000) {
            this.validationMessages.push(
              "一枚につきファイルサイズは2MB以下にしてください。"
            );
            resolve(null);
          }
          if (!this.checkExt(file.name)) {
            this.validationMessages.push(
              "拡張子は[jpeg]のみ認められています。"
            );
            resolve(null);
          }
          file.preview = res.target.result;
          file.title = "";
          resolve(file);
        };
        fr.onerror = err => {
          return (this.error = err);
        };
      });
    },
    getExt(filename) {
      let pos = filename.lastIndexOf(".");
      if (pos === -1) return "";
      return filename.slice(pos + 1);
    },
    checkExt(filename) {
      const allow_exts = new Array("jpeg", "jpg");
      let ext = this.getExt(filename).toLowerCase();
      if (allow_exts.indexOf(ext) === -1) return false;
      return true;
    },
    //preview関連終わり
    removeFile(index) {
      this.files.splice(index, 1);
    },
    async upPhoto() {
      let data = new FormData();
      data.append("event_id", this.eventId);
      this.files.forEach(v => {
        data.append("titles[]", v.title || "");
        data.append("images[]", v);
      });
      this.delValidation();
      const response = await this.postPhotos({ id: this.eventId, data: data });
      if (this.isSuccess) {
        document.getElementById("add-button").value = "";
        this.files = [];
      } else {
        this.validationMessages = response;
      }
    },
    upCancel() {
      document.getElementById("add-button").value = "";
      this.files = [];
    },
    delValidation() {
      this.validationMessages = [];
    }
  }
};
</script>

<style scoped>
#preview-photo {
  width: 100%;
  max-height: 78vh;
  margin-bottom: 0 !important;
  text-align: center;
  position: relative;
  overflow-y: scroll;
  -webkit-overflow-scrolling: touch;
  transform: translateZ(0);
  display: flex;
  flex-wrap: wrap;
  /* align-content: space-between; */
  justify-content: space-between;
}
.preview_box {
  width: 49%;
  margin-bottom: 12px;
  position: relative;
  display: inline-table;
}
@media screen and (max-width: 767px) {
  .preview_box {
    width: 100%;
  }
  .inner_wrap {
    width: 90%;
    max-width: 90%;
    padding: 15px;
    height: 100%;
  }
  #preview-photo {
    max-height: 90%;
  }
  .buttons * {
    margin-top: 1rem !important;
    font-size: 0.8rem;
  }
}
.file_remove {
  color: red;
  position: absolute;
  top: 2px;
  right: 5px;
  z-index: 2000;
  cursor: pointer;
  margin: 0px;
  font-size: 23px;
}
.file_name {
  word-wrap: break-word;
  font-size: 0.8rem;
  position: absolute;
  width: 100%;
  z-index: 200;
  bottom: 37px;
  background: rgba(45, 45, 45, 0.4);
  color: white;
  padding: 4px;
}
.preview_box img {
  object-fit: cover;
  max-width: 100%;
}
#add-button {
  display: none;
}
.wrap {
  z-index: 50;
  width: 100vw;
  height: 100vh;
  background: gray;
  position: absolute;
  top: 0;
  left: 0;
  background: rgba(45, 45, 45, 0.5);
  position: fixed;
}

.inner_wrap {
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
