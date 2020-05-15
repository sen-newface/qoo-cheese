<template>
  <div id="app">
    <common-header></common-header>
    <router-view></router-view>
    <base-event
      v-for="event in events"
      :key="event.id"
      :event-info="event"
    >
    </base-event>
  </div>
</template>

<script>
import BaseEvent from "./BaseEvent";
import CommonHeader from './components/CommonHeader.vue';
export default {
  name: "App",
  components: {
    BaseEvent, CommonHeader
  },
  data() {
    return {
      events: [
        {
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
        },
        {
          id: 2,
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
        },
        {
          id: 3,
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
        },
        {
          id: 4,
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
      ]
    }
  }
};
</script>

<style>
</style>
