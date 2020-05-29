<template>
  <div id="alert-modal" v-show="isShow">
    <div class="modal-wrapper">
      <div class="modal-disp">
        <div class="float-right-box">
          <button class="close-modal-btn">
            <span>✖️</span>
          </button>
        </div>
        <div class="alert-text-box">
          <slot name="alert-text">
            <p>ここにアラートさせたい文章を追加してください。</p>
          </slot>
        </div>
        <div class="h-center-box">
          <slot name="additional">
            <button>ボタン</button>
          </slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    isShow: {
      type: Boolean,
      default: false
    }
  }
};
</script>

<style scoped>
#alert-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(10, 10, 10, 0.7);
  z-index: 999999;
}
#alert-modal .modal-wrapper {
  position: relative;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}
#alert-modal .modal-wrapper .modal-disp {
  position: relative;
  width: 80vw;
  padding: 8px;
  background-color: whitesmoke;
  border-radius: 5px;
}
#alert-modal .modal-wrapper .modal-disp::after {
  display: block;
  content: "";
  clear: both;
}
#alert-modal .alert-text-box {
  padding: 32px 0 16px;
}
#alert-modal .h-center-box {
  display: flex;
  justify-content: center;
}
#alert-modal .float-right-box::after {
  content: "";
  clear: both;
}
#alert-modal .close-modal-btn {
  float: right;
  padding: 0;
  width: 50px;
  height: 50px;
  line-height: 50px;
  text-align: center;
}
#alert-modal .close-modal-btn span {
  display: inline-block;
  width: 100%;
  height: 100%;
}
/**
ボタンや文字の大きさとかはこっちでコントロールした方が良いかも
*/
p {
  text-align: center;
  font-size: 1.3rem;
}
button {
  width: 25%;
  margin: 0 16px;
  padding: 16px 8px;
  font-size: 1.25rem;
  outline: none;
  border: 1px solid gray;
  border-radius: 5px;
  cursor: pointer;
}
</style>
