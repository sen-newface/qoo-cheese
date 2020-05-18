<template>
  <form @submit.prevent="eventStore">
    <validationMessages :errors="valiMessages" />
    <div class="form-group">
      <label for="name">名前</label>
      <input
        type="text"
        class="form-control"
        :class="isValid('name')"
        id="name"
        placeholder="名前"
        v-model="eventStoreForm.name"
      />
    </div>
    <div class="form-group">
      <label for="exampleInputStartDate">公開開始日</label>
      <input
        type="date"
        class="form-control"
        :class="isValid('start_date')"
        id="exampleInputStartDate"
        placeholder="公開開始日"
        v-model="eventStoreForm.start_date"
      />
    </div>
    <div class="form-group">
      <label for="exampleInputEndDate">公開終了日</label>
      <input
        type="date"
        class="form-control"
        :class="isValid('end_date')"
        id="exampleInputEndDate"
        placeholder="公開終了日"
        v-model="eventStoreForm.end_date"
      />
    </div>
    <button type="submit" class="btn btn-primary">登録</button>
  </form>
</template>

<script>
import api from "../api";
import { mapGetters } from "vuex";
import validationMessages from "../components/validationMessages";
export default {
  name: "EventStore",
  components: {
    validationMessages
  },
  data() {
    return {
      eventStoreForm: {
        name: "",
        start_date: "",
        end_date: "",
      },
      validationMessages: []
    };
  },
  computed: {
    ...mapGetters({
      isApiSuccess: "status/isApiSuccess"
    }),
    isValid() {
      return function(form_name) {
        return Object.keys(this.validationMessages).includes(form_name)
          ? "is-invalid"
          : "";
      };
    },
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
      return response;
    }
  },
  methods: {
    async eventStore() {
      this.delValidation();
      const response = await this.$store.dispatch(
        "events/eventStore",
        this.eventStoreForm
      );

      if (this.isApiSuccess) {
        this.$router.push({ path: "/events" });
      } else {
        this.validationMessages = response;
      }
    },
    delValidation() {
      this.validationMessages = [];
    }
  }
};
</script>

<style scoped>

</style>
