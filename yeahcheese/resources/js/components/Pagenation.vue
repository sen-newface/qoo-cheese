<template>
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
      <li class="page-item">
        <router-link
          class="page-link"
          :to="{ path: '/events/', query: {page: 1}}"
          aria-label="Previous"
        >
          <span aria-hidden="true">&laquo;</span>
          <span class="sr-only">最初へ</span>
        </router-link>
      </li>
      <li class="page-item" :class="isCurrent(num)" v-for="num in numbers" :key="num">
        <router-link class="page-link" :to="{ path: '/events/', query: {page: num}}">{{num}}</router-link>
      </li>
      <li class="page-item">
        <router-link
          class="page-link"
          :to="{ path: '/events/', query: {page: last_page}}"
          aria-label="Next"
        >
          <span aria-hidden="true">&raquo;</span>
          <span class="sr-only">最後へ</span>
        </router-link>
      </li>
    </ul>
  </nav>
</template>



<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({
      currentEventPage: "events/currentEventPage",
      last_page: "events/last_page"
    }),
    isCurrent() {
      return function(num) {
        return this.currentEventPage == num ? "active" : "";
      };
    },
    numbers() {
      //ページネーションは5こ表示
      //総数が5こ以下 1からlastまで
      if (this.last_page <= 5) {
        return this.createNumbers(1, this.last_page);
      }

      //現在ページが1から3 1~5を出す
      if (this.currentEventPage <= 3) {
        return this.createNumbers(1, 5);
      }
      //現在ページが 最終ページ手前から3番目以内 last -4 から last まで
      if (this.last_page - 2 <= this.currentEventPage) {
        return this.createNumbers(this.last_page - 4, this.last_page);
      }
      //上記以外 現在ページを中心に前後２つずつ表示
      return this.createNumbers(
        this.currentEventPage - 2,
        this.currentEventPage + 2
      );
    }
  },

  methods: {
    createNumbers(start, end) {
      let nums = [];
      for (let i = start; i <= end; i++) {
        nums.push(i);
      }
      return nums;
    }
  }
};
</script>
