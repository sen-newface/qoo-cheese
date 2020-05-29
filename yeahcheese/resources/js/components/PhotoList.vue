<template>
  <div>
    <div>
      <transition-group
        id="img-thumbnail"
        class="d-flex justify-content-between flex-wrap mb-5 img-area"
        name="fade"
        mode="out-in"
      >
        <div
          class="img-thumbnail-wrap"
          v-show="photos.length"
          v-for=" (image, index) in photos"
          :key="image.id"
          :class="imgThumbnailSize"
        >
          <img
            :alt="alt(image.id)"
            :src="image.image_path"
            class="img-thumbnail mb-2 bg-white"
            @click="openPreview(index)"
          />
          <i
            v-if="isLogin"
            class="fa fa-gratipay photo-likes-icon thumbnail"
            :class="likesClass(image)"
            @click="toggleLikesIcon(image)"
          ></i>
        </div>
      </transition-group>
      <p v-show="!photos.length">写真はまだありません</p>
    </div>
    <div class="wrap" v-if="preview && photos.length > 0" @click="preview=''">
      <div class="inner_wrap">
        <div class="content">
          <div class="preview_set" @click.stop>
            <div class="text-center" style="display: flex; align-items: center;">
              <i
                class="fa fa-arrow-left arrow_icon"
                :class="isFirstArrow(preview_index)"
                @click="openPreview(preview_index - 1)"
              ></i>
              <div>
                <div class="d-flex preview_icons">
                  <i
                    class="fa fas fa-trash"
                    style="color: red; margin-right: auto; margin-left: 6px;"
                    @click="delPhoto"
                    v-if="isMyEvent"
                  ></i>
                  <i
                    class="fa fa-gratipay photo-likes-icon"
                    :class="likesClass(photos[preview_index])"
                    @click="toggleLikesIcon(photos[preview_index])"
                  ></i>
                  <a
                    :href="this.photos[preview_index].image_path"
                    :download="this.photos[preview_index].image_path"
                    @click.stop
                    style="margin-top: auto;"
                  >
                    <i class="fa fa-download mr-2" style="font-size: 27px;"></i>
                  </a>
                  <i class="del_button fa fa-times" @click="initPreview"></i>
                </div>
                <img :src="preview" class="preview-photo" />
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
      preview_index: ""
    };
  },
  computed: {
    ...mapGetters({
      user: "users/user",
      isLogin: "users/isLogin",
      selectedColumns: "display/selectedColumns",
      isSuccess: "status/isApiSuccess"
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
    openPreview(index) {
      if (this.photos[index]) {
        this.preview = this.photos[index].image_path;
        this.preview_index = index;
      }
    },
    async delPhoto() {
      var result = confirm("本当に写真を削除してよろしいですか？");
      if (result) {
        await this.$store.dispatch("photos/deletePhoto", {
          event_id: this.event.id,
          photo_id: this.photos[this.preview_index].id
        });
        this.preview = "";
        this.preview_index = "";
      }
    },
    toggleLikesIcon(photo) {
      const user_id = this.user.id;
      const photo_id = photo.id;
      const payload = {
        user_id,
        photo_id,
        photo
      };
      const request_type = photo.is_favorite ? "DELETE" : "POST";
      this.likesRequest(request_type, payload);
      this.initPreview();
    },
    initPreview() {
      this.preview = "";
    },
    async likesRequest(request_type, payload, photo) {
      if (request_type === "DELETE") {
        delete payload.user_id;
        const response = await this.photoLikesDestroy(payload);
        this.ifSuccessLikes(payload.photo);
      } else {
        const response = await this.photoLikesStore(payload);
        this.ifSuccessLikes(payload.photo);
      }
    },
    ifSuccessLikes(photo) {
      if (this.isSuccess) {
        photo.is_favorite = !photo.is_favorite;
      }
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
  beforeDestroy() {
    const user_id = this.user.id;
  },
  mixins: [scrollControllable]
};
</script>



<style scoped>
.img-area img {
  cursor: pointer;
  transition: all 0.3s ease 0s;
}
.img-thumbnail-wrap {
  position: relative;
}
.img-thumbnail-wrap .img-thumbnail {
  display: block;
  width: 100%;
  height: 100%;
}
.img-area * {
  transition: max-width 0.2s ease;
}

.img-area img:hover {
  box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.4);
  transform: scale(1.02, 1.02);
}

#img-thumbnail.img-area .img-thumbnail-size1 {
  max-width: 100%;
}
#img-thumbnail.img-area .img-thumbnail-size2 {
  max-width: 49.5%;
}
#img-thumbnail.img-area .img-thumbnail-size3 {
  max-width: 33.33333333%;
}
#img-thumbnail.img-area .img-thumbnail-size4 {
  max-width: 24.5%;
}
#img-thumbnail.img-area .img-thumbnail-size5 {
  max-width: 19.5%;
}

@media screen and (max-width: 767px) {
  .img-area {
    display: block !important;
  }
  .img-area img {
    max-width: 100%;
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
  bottom: 0;
  right: 0;
  font-size: 55px;
  animation: dislike 0.5s ease;
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
  width: 100vw;
  height: 100vh;
  background: gray;
  position: absolute;
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
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
.fade-enter-active,
.fade-leave-active {
  transition: all 0.5s;
}
</style>
