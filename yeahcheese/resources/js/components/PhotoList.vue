<template>
  <div>
    <div id="img-thumbnail" class="d-flex justify-content-between flex-wrap mb-5 img-area">
      <img
        v-show="photos.length"
        v-for=" (image, index) in photos"
        :key="image.id"
        :alt="alt(image.id)"
        :src="image.image_path"
        class="img-thumbnail mb-2 bg-white"
        :class="imgThumbnailSize"
        @click="openPreview(index)"
      />
      <p v-show="!photos.length">写真はまだありません</p>
    </div>
    <div class="wrap" v-if="preview" @click="preview=''">
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
                    :class="likesClass"
                    @click="toggleLikesIcon(photos[preview_index].id)"
                  ></i>
                  <a
                    :href="this.photos[preview_index].image_path"
                    :download="this.photos[preview_index].image_path"
                    @click.stop
                    style="margin-top: auto;"
                  >
                    <i class="fa fa-download mr-2" style="font-size: 27px;"></i>
                  </a>
                  <i class="del_button fa fa-times" @click="preview=''"></i>
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
import { mapGetters } from "vuex";
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
      isLikedIcon: null,
      likesPhotoId: null
    };
  },
  computed: {
    ...mapGetters({
      selectedColumns: "display/selectedColumns"
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
      if (this.isLikedIcon !== null) {
        return { likes: this.isLikedIcon, dislikes: !this.isLikedIcon };
      }
      return "";
    }
  },
  methods: {
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
    toggleLikesIcon(photo_id) {
      this.isLikedIcon = !this.isLikedIcon;
      // TODO: event_idとphoto_idを保持しておく
      this.likesPhotoId = photo_id;
      console.log("お気に入り状態を変更する写真のID", this.likesPhotoId);
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
.img-area img {
  max-width: 49%;
  cursor: pointer;
  transition: all 0.3s ease 0s;
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
}
.photo-likes-icon.likes {
  color: palevioletred;
  animation: like 0.5s ease;
}
.photo-likes-icon.dislikes {
  color: ivory;
  animation: dislike 0.5s ease;
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
</style>
