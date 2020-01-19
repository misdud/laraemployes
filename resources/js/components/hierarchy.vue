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
      <li v-for="(name, index ) in supervisor" v-bind:key="index" class="list-group-item">
        {{ name.position}}:
        <b>{{ name.name }}</b>
        <span class="my">
          <button
            type="button"
            class="btn btn-light ml-4"
            v-on:click="getDirector()"
          >Показать директоров</button>
        </span>
      </li>
    </ul>
    <ul class="list-group my-margin-1">
      <li v-for="( director, index ) in directors" v-bind:key="index" class="list-group-item">
        {{ director.position}}:
        <b>{{ director.name }}</b>
        <span class="my">
          <button
            type="button"
            class="btn btn-light ml-1"
            v-on:click="getDeputy(director.id)"
          >Показать его заместителей</button>
        </span>
      </li>
    </ul>
    <ul class="list-group my-margin-2">
      <li v-for="(deputy, index ) in deputys" v-bind:key="index" class="list-group-item">
        {{ deputy.position}}:
        <b>{{ deputy.name }}</b>
        <span class="my">
          <button
            type="button"
            class="btn btn-light ml-1"
            v-on:click="getDepart(deputy.id)"
          >Показать его начальников</button>
          <button type="button" class="btn btn-light ml-1" v-on:click="clearData()">Вернуться</button>
        </span>
      </li>
    </ul>
    <ul class="list-group my-margin-3">
      <li v-for="(depart, index ) in departs" v-bind:key="index" class="list-group-item">
        {{ depart.position}}-
        {{ depart.nameOtdel}}
        <b>{{ depart.name }}</b>
        <span class="my">
          <!-- <button type="button" class="btn btn-light ml-1">Показать подчинённых</button>
          <button type="button" class="btn btn-light ml-1" v-on:click="clearData()">Вернуться</button>-->
        </span>
      </li>
    </ul>
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
      directors: null,
      deputys: null,
      departs: null
    };
  },
  created() {
    this.fetchData();
  },
  mounted() {
    this.getDirector();
  },
  methods: {
    fetchData() {
      this.error = this.supervisor = null;
      this.loading = true;
      axios
        .get("/api/supervisor")
        .then(response => {
          this.loading = false;
          this.supervisor = response.data;
        })
        .catch(error => {
          this.loading = false;
          this.error = error.response.data.message || error.message;
        });
    },
    getDirector() {
      //   this.error = this.supervisor = null;
      //   this.loading = true;
      axios
        .get("/api/supervisor/directors")
        .then(response => {
          this.loading = false;
          this.directors = response.data;
          this.deputys = [];
          // console.log(response.data);
        })
        .catch(error => {
          this.loading = false;
          this.error = error;
          console.log(error);
        });
    },
    getDeputy(num) {
      axios
        .get("/api/supervisor/deputys", {
          params: {
            id: num
          }
        })
        .then(response => {
          this.loading = false;
          this.deputys = response.data;
          // console.log(response.data);
          this.departs = [];
        })
        .catch(error => {
          this.loading = false;
          this.error = error;
          console.log(error);
        });
    },
    getDepart(num) {
      //   this.loading = true;
      axios
        .get("/api/supervisor/departs", {
          params: {
            id: num
          }
        })
        .then(response => {
          this.loading = false;
          this.departs = response.data;
        })
        .catch(error => {
          this.loading = false;
          this.error = error;
          console.log(error);
        });
    },
    clearData() {
      this.deputys = [];
      this.departs = [];
    }
  }
};
</script>


<style>
.my {
  float: right !important;
}

.my-margin-1 {
  margin-left: 50px;
}
.my-margin-2 {
  margin-left: 100px;
}
.my-margin-3 {
  margin-left: 150px;
}
</style>
