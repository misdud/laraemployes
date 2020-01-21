<template>
  <div>
    <div v-if="loading" class="spinner-border" role="status">
      <span class="sr-only">Loading...</span>
    </div>

    <div v-if="erorrMs" class="error">
      <p>{{ erorrMs ? erorrMs: '' }}</p>
      <p>
        <button @click.prevent="fetchData()" type="button" class="btn btn-warning">Повторить</button>
      </p>
    </div>

    <ul v-if="supervisor" class="list-group">
      <li v-for="(name, index ) in supervisor" v-bind:key="index" class="list-group-item">
        {{ name.position}}:
        <b>{{ name.name }}</b>
        <span class="my">
          <button type="button" class="btn btn-light ml-4" v-on:click="clearData()">Очистить</button>
        </span>
      </li>
    </ul>
    <!--111-->
    <div>
      <template v-if="status1">
        <ul class="list-group my-margin-1">
          <li class="list-group-item">
            {{ dirTree.position }}
            <b>{{ dirTree.name }}</b>
          </li>
          <template v-if="status2">
            <ul class="list-group my-margin-1">
              <li class="list-group-item">
                {{ HeadDepart.position }}
                <b>{{ HeadDepart.name}}</b>
              </li>
              <ul class="list-group my-margin-2">
                <li class="list-group-item">
                  {{ employeHeadDepart.position }}
                  {{ employeHeadDepart.nameOtdel }}
                  <b>{{ employeHeadDepart.name}}</b>
                </li>
                <ul class="list-group my-margin-2">
                  <li
                    v-for="( empl, index ) in employeTree"
                    v-bind:key="index"
                    class="list-group-item"
                  >
                    {{ empl.position}}
                    <b>{{ empl.name }}</b>
                    <span class="my">
                      <img
                        :src="'/storage/photos/'+empl.id+'.jpeg'"
                        title="фото"
                        height="40px"
                        width="35 px"
                      />
                    </span>
                  </li>
                </ul>
                <li v-for="( dep, index ) in departTree" v-bind:key="index" class="list-group-item">
                  {{ dep.position}}
                  {{ dep.nameOtdel}}:
                  <b>{{ dep.name }}</b>
                  <span class="my">
                    <button
                      type="button"
                      class="btn btn-light ml-1"
                      v-on:click="getEmploye(dep.id)"
                    >Посмотреть cотрудников</button>
                  </span>
                </li>
              </ul>
            </ul>
          </template>
        </ul>
      </template>
      <template v-if="statusDep">
        <ul class="list-group my-margin-2">
          <li v-for="( deput, index ) in deputysTree" v-bind:key="index" class="list-group-item">
            {{ deput.position}}:
            <b>{{ deput.name }}</b>
            <span class="my">
              <button
                type="button"
                class="btn btn-light ml-1"
                v-on:click="getDepart(deput.id)"
              >Посмотреть начальников</button>
            </span>
          </li>
        </ul>
      </template>
    </div>

    <!-- 111 -->
    <template v-if="statusDir">
      <ul class="list-group my-margin-1">
        <li v-for="( director, index ) in directors" v-bind:key="index" class="list-group-item">
          {{ director.position}}:
          <b>{{ director.name }}</b>
          <span class="my">
            <button
              type="button"
              class="btn btn-light ml-1"
              v-on:click="getDeputy(director.id)"
            >Посмотреть заместителей</button>
          </span>
        </li>
      </ul>
    </template>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Hierarchy",
  data() {
    return {
      loading: false,
      erorrMs: null,
      supervisor: null,
      directors: null,
      deputysTree: null,
      dirTree: "",
      deputys: null,
      departs: null,
      departTree: null,
      HeadDepart: "",
      employeTree: null,
      employeHeadDepart: "",
      status1: false,
      status2: false,
      statusDir: true,
      statusDep: true
    };
  },
  created() {},
  mounted() {
    this.fetchData();
    this.getDirector();
  },
  methods: {
    fetchData() {
      this.erorrMs = this.supervisor = null;
      this.loading = true;
      axios
        .get("/api/supervisor")
        .then(response => {
          this.loading = false;
          this.supervisor = response.data;
          console.log(response.data);
        })
        .catch(error => {
          this.loading = false;
          this.errorM = error.response.data.message || error.message;
        });
    },
    getDirector() {
      //  this.erorrMs = this.supervisor = null;
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
          this.erorrMs = error;
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
          //this.deputys = response.data;
          //   console.log(response.data.dir);
          //   console.log(response.data.collDeputys);
          this.deputysTree = response.data.collDeputys;
          this.dirTree = response.data.dir;
          this.departs = [];
          this.departTree = null;
          this.HeadDepart = "";
          this.status1 = true;
          this.statusDir = false;
        })
        .catch(error => {
          this.loading = false;
          this.erorrMs = error;
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
          //this.departs = response.data;
          this.departTree = response.data.collDepart;
          this.HeadDepart = response.data.depart;
          // console.log(response.data);
          this.status2 = true;
          this.statusDep = false;
        })
        .catch(error => {
          this.loading = false;
          this.erorrMs = error;
          console.log(error);
        });
    },
    getEmploye(num) {
      //   this.loading = true;
      axios
        .get("/api/supervisor/employes", {
          params: {
            id: num
          }
        })
        .then(response => {
          this.loading = false;
          //this.departs = response.data;
          this.employeTree = response.data.collEmploye;
          this.employeHeadDepart = response.data.headDepart;
          this.departTree = [];
          //console.log(response.data);
          this.status2 = true;
        })
        .catch(error => {
          this.loading = false;
          this.erorrMs = error;
          console.log(error);
        });
    },

    clearData() {
      this.deputys = [];
      this.departs = [];
      this.deputysTree = null;
      this.dirTree = "";
      this.departTree = null;
      this.HeadDepart = "";
      this.status1 = false;
      this.status2 = false;
      this.employeTree = null;
      this.employeHeadDepart = "";
      this.statusDir = true;
      this.statusDep = true;
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
