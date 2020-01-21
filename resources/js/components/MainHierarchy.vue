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
          <button
            type="button"
            class="btn btn-light ml-4"
            v-on:click="clearData()"
          >Очистить</button>
        </span>
      </li>
    </ul>
        <!-- <p>1111111</p> -->
    <div>
        <ul class="list-group my-margin-1">
              <li class="list-group-item ">
                {{ dirTree.position ? dirTree.position: ''}} {{ dirTree.name ? dirTree.name+'  его заместители:': ''}}
              </li> 
                    <ul class="list-group my-margin-1">
                        <li class="list-group-item">
                            {{ HeadDepart.position ? HeadDepart.position: ''}} {{ HeadDepart.name ? HeadDepart.name+'  его начальники': ''}}
                        </li> 
                                <ul class="list-group my-margin-2">
                                    <li v-for="( dep, index ) in departTree" v-bind:key="index" class="list-group-item">
                                        {{ dep.position}} 
                                        {{ dep.nameOtdel}}:
                                        <b>{{ dep.name }}</b>
                                        <span class="my">
                                        <button
                                            type="button"
                                            class="btn btn-light ml-1"
                                            v-on:click="getDepart(dep.id)"
                                        >Показать начальников</button>
                                        </span>
                                    </li>
                                    </ul>
                        
                    </ul>
        </ul>
     <ul class="list-group my-margin-2">
      <li v-for="( deput, index ) in deputysTree" v-bind:key="index" class="list-group-item">
        {{ deput.position}}:
        <b>{{ deput.name }}</b>
        <span class="my">
          <button
            type="button"
            class="btn btn-light ml-1"
            v-on:click="getDepart(deput.id)"
          >Показать начальников</button>
        </span>
      </li>
     </ul>
    </div>

        <!-- <p>1111111</p> -->

    <ul class="list-group my-margin-1">
      <li v-for="( director, index ) in directors" v-bind:key="index" class="list-group-item">
        {{ director.position}}:
        <b>{{ director.name }}</b>
        <span class="my">
          <button
            type="button"
            class="btn btn-light ml-1"
            v-on:click="getDeputy(director.id)"
          >Показать заместителей</button>
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
          >Показать начальников</button>
          <button type="button" class="btn btn-light ml-1" v-on:click="clearData()">Вернуться</button>
        </span>

        <template v-if="0">
           <li v-for="(depart, index ) in departs" v-bind:key="index" class="list-group-item mt-2">
        {{ depart.position}}-
        {{ depart.nameOtdel}}
        <b>{{ depart.name }}</b>
        <span class="my">
          <button type="button" class="btn btn-light ml-1">Показать подчинённых</button>
          <button type="button" class="btn btn-light ml-1" v-on:click="clearData()">Вернуться</button>
        </span>
      </li>
        </template>

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
  name: "Hierarchy",
  data() {
    return {
      loading: false,
      erorrMs: null,
      supervisor: null,
      directors: null,
      deputysTree:null,
      dirTree:{},
      deputys: null,
      departs: null,
      departTree:null,
      HeadDepart:{},
    };
  },
  created() {
   // this.fetchData();
  },
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
          console.log(response.data)
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
          this.HeadDepart='';
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
          console.log(response.data);
        //   console.log(response.data.collDepart);
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
      this.deputysTree=null;
      this.dirTree='';
      this.departTree = null;
      this.HeadDepart='';
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
