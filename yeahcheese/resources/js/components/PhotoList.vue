<template>
  <div>
    <div class="my_grid mb-5 img-area" :class="imgThumbnailSize">
      <div
        class="text-center grid_item"
        v-show="photos.length"
        v-for=" (image, index) in photos"
        :key="image.id"
      >
        <div class="image_set">
          <img
            :alt="alt(image.id)"
            :src="image.image_path"
            @click="openPreview(index)"
            class="img-thumbnail mb-2 bg-white"
          />
          <i
            v-if="isLogin"
            class="fa fa-gratipay photo-likes-icon thumbnail"
            :class="likesClass(image)"
            @click="toggleLikesIcon(image)"
          ></i>
          <div class="file_title">
            <p class="preview_title" @click="openPreview(index)">{{getTitle(image)}}</p>
            <p class="file_icons">
              <i
                class="fa fas fa-trash"
                style="color: red; margin-right: auto; margin-left: 6px;"
                @click="delPhoto(index)"
                v-if="isMyEvent"
              ></i>
              <a
                :href="image.image_path"
                :download="getTitle(image)"
                @click.stop
                style="margin-top: auto; margin-left: auto;"
              >
                <i class="fa fa-download mr-2" style="font-size: 27px;"></i>
              </a>
            </p>
          </div>
        </div>
      </div>
      <p v-show="!photos.length">写真はまだありません</p>
    </div>
    <input
      type="text"
      class="visile_input"
      v-on:keyup.left="openPreview(preview_index - 1)"
      v-on:keyup.right="openPreview(preview_index + 1)"
      ref="r1"
    />
    <div class="wrap" v-if="preview" @click="preview=''">
      <div class="inner_wrap">
        <div class="content">
          <div class="preview_set width100perSp" @click.stop>
            <div class="preview_contents width100perSp">
              <i
                class="fa fa-arrow-left arrow_icon"
                :class="isFirstArrow(preview_index)"
                @click="openPreview(preview_index - 1)"
              ></i>
              <div class="width100perSp" @click="toKeyInputForcus()">
                <div class="d-flex preview_icons width100perSp">
                  <i
                    class="fa fas fa-trash"
                    style="color: red; margin-right: auto; margin-left: 6px;"
                    @click="delPhoto(preview_index)"
                    v-if="isMyEvent"
                  ></i>
                  <i
                    v-if="isLogin"
                    class="fa fa-gratipay photo-likes-icon"
                    :class="likesClass(photos[preview_index])"
                    @click="toggleLikesIcon(photos[preview_index])"
                  ></i>
                  <a
                    :href="this.photos[preview_index].image_path"
                    :download="getTitle(this.photos[preview_index])"
                    @click.stop
                    style="margin-top: auto;"
                  >
                    <i class="fa fa-download mr-2" style="font-size: 27px;"></i>
                  </a>
                  <i class="del_button fa fa-times" @click="initPreview"></i>
                </div>
                <img :src="preview" class="preview-photo" />
                <p class="preview_title">{{preview_title}}</p>
              </div>
              <i
                class="fa fa-arrow-right arrow_icon"
                :class="isLastArrow(preview_index)"
                @click="openPreview(preview_index + 1)"
              ></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from "../api";
import { mapGetters, mapActions } from "vuex";
import scrollControllable from "../mixins/scrollControllable";
export default {
  props: {
    photos: {
      type: Array,
      required: true
    },
    event: {
      type: Object,
      required: true
    },
    isMyEvent: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      preview: "",
      preview_index: "",
      preview_title: ""
    };
  },
  computed: {
    ...mapGetters({
      user: "users/user",
      isLogin: "users/isLogin",
      selectedColumns: "display/selectedColumns",
      isSuccess: "status/isApiSuccess",
      getTitle: "photos/getTitle"
    }),
    alt() {
      return function(id) {
        return this.event.name + "の写真" + id;
      };
    },
    isFirstArrow() {
      return function(index) {
        return index === 0 ? "passive" : "";
      };
    },
    isLastArrow() {
      return function(index) {
        return index === this.photos.length - 1 ? "passive" : "";
      };
    },
    createFileName() {
      return function(photo) {
        let ext = this.getExt(photo.image_path);
        return photo.title ? photo.title : photo.image_path;
      };
    },
    imgThumbnailSize() {
      return "img-thumbnail-size" + this.selectedColumns;
    },
    likesClass() {
      // ! ステートが変更されれば自動的に変化する
      return photo => {
        return { likes: photo.is_favorite };
      };
    }
  },
  methods: {
    ...mapActions("photos", ["photoLikesStore", "photoLikesDestroy"]),
    getExt(filename) {
      let pos = filename.lastIndexOf(".");
      if (pos === -1) return "";
      return filename.slice(pos + 1);
    },
    openPreview(index) {
      if (this.photos[index]) {
        this.preview = this.photos[index].image_path;
        this.preview_index = index;
        this.preview_title = this.getTitle(this.photos[index]);
      }
    },
    async delPhoto(index) {
      var result = confirm("本当に写真を削除してよろしいですか？");
      if (result) {
        await this.$store.dispatch("photos/deletePhoto", {
          event_id: this.event.id,
          photo_id: this.photos[index].id
        });
        this.preview = "";
        this.preview_index = "";
        this.preview_title = "";
      }
    },
    toggleLikesIcon(photo) {
      const user_id = this.user.id;
      const photo_id = photo.id;
      const event_id = photo.event_id;
      const payload = {
        user_id,
        photo_id,
        photo,
        event_id
      };
      const request_type = photo.is_favorite ? "DELETE" : "POST";
      this.likesRequest(request_type, payload);
      this.initPreview();
    },
    initPreview() {
      this.preview = "";
    },
    async likesRequest(request_type, payload) {
      if (request_type === "DELETE") {
        delete payload.user_id;
        const response = await this.photoLikesDestroy(payload);
        this.$store.commit("photos/toggleEventPhotoFavorite", {
          event_id: payload.event_id,
          photo_id: payload.photo_id,
          bool: false
        });
        this.ifSuccessLikes(payload.photo);
      } else {
        const response = await this.photoLikesStore(payload);
        this.$store.commit("photos/toggleEventPhotoFavorite", {
          event_id: payload.event_id,
          photo_id: payload.photo_id,
          bool: true
        });
        this.ifSuccessLikes(payload.photo);
      }
    },
    ifSuccessLikes(photo) {
      // if (this.isSuccess) {
      //   console.log("aaaaaaaaa");
      //   photo.is_favorite = !photo.is_favorite;
      // }
    },
    toKeyInputForcus() {
      this.$refs.r1.focus();
    }
  },
  watch: {
    preview: {
      handler(val) {
        if (val) {
          this.no_scroll();
          this.toKeyInputForcus();
        } else {
          this.return_scroll();
        }
      }
    }
  },
  beforeDestroy() {
    const user_id = this.user.id;
  },
  mixins: [scrollControllable]
};
</script>

<style scoped lang="scss">
// .img-area img {
//   cursor: pointer;
//   transition: all 0.3s ease 0s;
// }
// .img-thumbnail-wrap {
//   position: relative;
// }
// .img-thumbnail-wrap .img-thumbnail {
//   display: block;
//   width: 100%;
//   height: 100%;
// }
// .img-area * {
//   transition: max-width 0.2s ease;
.my_grid {
  margin: 0 auto;
  column-count: 2;
}

.img-area .image_set {
  max-width: 100%;
  cursor: pointer;
  position: relative;
  display: inline-block;
}

.img-area .image_set:hover {
  box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.4);
  transform: scale(1.02, 1.02);
  transition: all 0.3s ease 0s;
}

.img-area .image_set:hover .file_title {
  display: block !important;
  transition: all 0.3s ease 0s;
}

.file_title {
  display: none;
  word-wrap: break-word;
  font-size: 1.1rem;
  margin-bottom: 13px;
  position: absolute;
  width: 98%;
  padding: 6px;
  z-index: 20;
  bottom: 0;
  background: rgba(45, 45, 45, 0.4);
  color: white;
  left: 50%;
  transform: translateX(-50%);
  -webkit-transform: translateX(-50%);
  -ms-transform: translateX(-50%);
}

.file_title p {
  margin-bottom: 0;
}

.file_title .preview_title {
  float: left;
  width: 78%;
  text-align: left;
}

.file_icons {
  color: white;
  float: right;
}

.file_icons i {
  color: white;
  font-size: 28px;
}

.img-thumbnail-size1 {
  column-count: 1;
}
.img-thumbnail-size2 {
  column-count: 2;
}
.img-thumbnail-size3 {
  column-count: 3;
}
.img-thumbnail-size4 {
  column-count: 4;
}
.img-thumbnail-size5 {
  column-count: 5;
}

.img-thumbnail-size4 .file_title {
  font-size: 0.8rem;
}
.img-thumbnail-size5 .file_title {
  font-size: 0.8rem;
}

.img-thumbnail-size4 .file_title .file_icons i {
  font-size: 20px !important;
}
.img-thumbnail-size5 .file_title .file_icons i {
  font-size: 20px !important;
}

@media screen and (max-width: 767px) {
  .my_grid {
    column-count: 1;
  }
  .file_title {
    display: block;
  }
  .img-area {
    display: block !important;
  }
  .img-area .image_set {
    max-width: 100%;
  }
  .inner_wrap {
    padding: 0 !important;
    max-width: 92% !important;
  }
  .preview_contents {
    flex-direction: column;
  }
  .preview_contents .fa-arrow-left {
    transform: rotate(90deg);
  }
  .preview_contents .fa-arrow-right {
    transform: rotate(90deg);
  }
  .width100perSp {
    width: 100%;
  }
}

.arrow_icon {
  color: white;
  font-size: 41px;
  margin: 10px;
  cursor: pointer;
}

.passive {
  cursor: initial;
  color: gray;
}
.preview_set {
  display: inline-block;
}

.preview_contents {
  display: flex;
  align-items: center;
  text-align: center;
}

.preview_title {
  color: white;
  margin-top: 6px;
  word-wrap: break-word;
}

.content {
  text-align: center;
  margin: 0 auto;
}

.preview_icons i {
  color: white;
  font-size: 32px;
  cursor: pointer;
}
.preview-photo {
  margin-bottom: 0 !important;
  object-fit: cover;
  max-width: 100%;
  max-height: 82vh;
}
.photo-likes-icon {
  margin-left: auto;
  margin-right: 6px;
  animation: dislike 0.5s ease;
  cursor: pointer;
}
.photo-likes-icon:hover {
  transform: scale(1.02, 1.02);
}
.photo-likes-icon.likes {
  color: palevioletred;
  animation: like 0.5s ease;
}
.photo-likes-icon.thumbnail {
  position: absolute;
  top: 7px;
  right: 7px;
  font-size: 42px;
  animation: dislike 0.5s ease;
  -webkit-animation: dislike-data-v-f535a7d6 0.5s ease;
  animation: dislike-data-v-f535a7d6 0.5s ease;
  color: ivory;
}
/**後でまとめる */
.photo-likes-icon.thumbnail.likes {
  color: palevioletred;
  animation: like 0.5s ease;
}

@keyframes like {
  0% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-5px);
    text-shadow: 0 0 10px palevioletred;
  }
  100% {
    transform: translateY(0px);
  }
}

@keyframes dislike {
  0% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-5px);
    text-shadow: 0 0 10px ivory;
  }
  100% {
    transform: translateY(0px);
  }
}

.wrap {
  z-index: 50;
  width: 100vw;
  height: 100vh;
  top: 0;
  left: 0;
  background: rgba(45, 45, 45, 0.9);
  position: fixed;
}
.inner_wrap {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  max-width: 88%;
  max-height: 88%;
  width: 88%;
  padding: 21px;
}
// .fade-enter,
// .fade-leave-to {
//   opacity: 0;
// }
// .fade-enter-active,
// .fade-leave-active {
//   transition: all 0.5s;
// }
// .fade-leave-active {
//   position: absolute;

.visile_input {
  width: 1px;
  height: 1px;
  color: white;
  border: white;
  position: absolute;
  top: 0;
  z-index: -100;
}
</style>
