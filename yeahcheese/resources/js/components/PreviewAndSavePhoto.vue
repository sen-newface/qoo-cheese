<template>
  <div id="preview-and-save-photo">
    <label v-show="canAdd">
      <span class="btn btn-primary btn-lg">追加</span>
      <input id="add-button" type="file" @change="loadPhoto" />
    </label>
    <label v-show="!canAdd">
      <button id="save-button" class="btn btn-primary btn-lg" @click="upPhoto">保存</button>
      <button id="cancel-button" class="btn btn-secondary btn-lg" @click="upCancel">キャンセル</button>
    </label>
    <div id="preview-photo">
      <img :src="preview" />
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  name: "PreviewAndSavePhoto",
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
      error: null
    };
  },
  computed: {
    ...mapGetters({
      isSuccess: "status/isApiSuccess"
    })
  },
  methods: {
    ...mapActions("photos", ["postPhoto"]),
    async loadPhoto(e) {
      const files = e.target.files || e.DataTransfer.files;
      this.file = files[0];
      const response = await this.createPhoto(this.file);
    },
    async upPhoto() {
      let data = new FormData();
      data.append("event_id", this.eventId);
      data.append("image_path", this.file);
      const response = await this.postPhoto({ id: this.eventId, data: data });
      this.$emit("photo-errors", []);
      if (!this.isSuccess) {
        this.$emit("photo-errors", response);
      }
      document.getElementById("add-button").value = "";
      this.canAdd = true;
      this.file = null;
      this.preview = null;
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
      this.canAdd = true;
      this.file = null;
      this.preview = null;
    }
  }
};
</script>

<style scoped>
#preview-photo {
  width: 50vw;
  height: 40vh;
}
#preview-photo img {
  object-fit: cover;
}
</style>
