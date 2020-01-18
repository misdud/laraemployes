<template>
  <div>
    <!-- lev 1-->
    <div v-if="loading" class="spinner-border" role="status">
      <span class="sr-only">Loading...</span>
    </div>

    <div v-if="error" class="error">
      <p>{{ error }}</p>
      <p>
        <button @click.prevent="fetchData()" type="button" class="btn btn-warning">Повторить</button>
      </p>
    </div>

    <ul v-if="supervisor" class="list-group">
      <li v-for="{ name, position } in supervisor" class="list-group-item">
        {{ position}}:
        ({{ name }})
        <button
          type="button"
          class="btn btn-light ml-4"
          v-on:click="getDirector"
        >Показать подчинённых</button>
        <button type="button" class="btn btn-light ml-2">Скрыть подчинённых</button>
      </li>
    </ul>

    <li v-for="{ name, position } in director" class="list-group-item">
      {{ position}}:
      ({{ name }})
      <button
        type="button"
        class="btn btn-light ml-4"
      >Показать подчинённых</button>
      <button type="button" class="btn btn-light ml-2">Скрыть подчинённых</button>
    </li>

    <!-- end lev 1-->
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Hierarchyt",
  data() {
    return {
      loading: false,
      erorr: null,
      supervisor: null,
      director: null
    };
  },
  created() {
    this.fetchData();
  },
  mounted() {
    //this.getDirector();
  },
  methods: {
    fetchData() {
      this.error = this.supervisor = null;
      this.loading = true;
      axios
        .get("/api/supervisor")
        .then(response => {
          this.loading = false;
          this.supervisor = response.data.data;
        })
        .catch(error => {
          this.loading = false;
          this.error = error.response.data.message || error.message;
        });
    },
    getDirector() {
      this.error = this.supervisor = null;
      this.loading = true;
      axios
        .get("/api/supervisor/1")
        .then(response => {
          this.loading = false;
          this.supervisor = response.data.data;
        })
        .catch(error => {
          this.loading = false;
          this.error = error;
          console.log(error);
        });
    }
  }
};
</script>


<style>
</style>
