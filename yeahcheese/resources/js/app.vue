<template>
  <div id="app">
    <router-view></router-view>
    <base-event-detail :event-info="event"></base-event-detail>
  </div>
</template>

<script>
import BaseEventDetail from "./BaseEventDetail";
export default {
  name: "App",
  components: {
    BaseEventDetail
  },
  data() {
    return {
      event: {
        id: 1,
        name: '運動会',
        key: Math.random().toString(32).substring(2),
        start_date: '2020/08/30',
        end_date: '2020/09/5',
        photos: [
          {
            id: 2,
            name: '写真1'
          },
          {
            id: 4,
            name: '写真3'
          }
        ]
      }
    }
  }
};
</script>

<style>
</style>
