export default {
  methods: {
    no_scroll() {
      document.addEventListener("mousewheel", this.scroll_control, {
        passive: false
      });
      document.addEventListener("touchmove", this.scroll_control, {
        passive: false
      });
    },
    return_scroll() {
      document.removeEventListener("mousewheel", this.scroll_control, {
        passive: false
      });
      document.removeEventListener("touchmove", this.scroll_control, {
        passive: false
      });
    },
    scroll_control(event) {
      event.preventDefault();
    }
  },
}
