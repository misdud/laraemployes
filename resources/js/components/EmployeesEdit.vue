<template>
  <div>
    <div class="row">
      <!-- {{ employe }}
    {{ employe.employment }}
    <hr />
      {{ headDepartametns }}-->
      <!-- {{ positions }} -->
      <div class="col-3 border">
        <form >
          <div class="form-group">
           <label for="file" class="pt-3">Фото сотрудника:</label>
           <br />
             <img v-if="photo.photoLink" :src="photo.photoLink" height="240 px" width="240 px" />
              <img v-else :src="photo.photoLinkDefault" height="240 px" width="240 px" />
            <input type="file" id="file" ref="file" v-on:change="onFileSelected"  class="form-control-file mt-3"/>
            <button v-on:click="onUpload" type="button" class="btn btn-primary mt-3" >Загрузить</button>

        </div>
        </form>

      </div>

      <div class="col-5">
        <div v-if="! loaded">Загрузка...</div>
        <form v-on:submit.prevent="onSubmit($event)" v-else>
          <div class="form-group">
            <label for="employe">ФИО</label>
            <input class="form-control" id="employe" v-model.lazy="employe.name" />
          </div>
          <div class="form-group">
            <label for="position">Должность</label>
            <select class="form-control" id="position" v-model="selectedPosit">
              <option
                v-for="(posit, index) in positions"
                v-bind:key="index"
                v-bind:value="{ id: posit.id }"
              >
                {{ posit.name_position}}
                \ Оклад: {{ posit.salary_position }}
                id{{ posit.id }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label for="employment">Дата приема на работу</label>
            <input class="form-control" id="employment" type="text" v-model="employe.employment" />
          </div>
          <div class="form-group">
            <label for="ratio">КТУ</label>
            <input
              class="form-control"
              id="ratio"
              type="number"
              min="1.0"
              max="1.5"
              step="0.01"
              v-model="employe.ratio"
            />
          </div>
          <p>Текущая зарплата: {{ Math.ceil(allSalary) }}</p>
          <div class="form-group">
            <label for="name_head_depart">Текущий начальник: <b>{{ employe.name_head_depart}}.</b> </label>
            <select class="form-control" id="name_head_depart" v-model="selectedHedDep">
              <option disabled value="">Выберите руководителя для смены</option>
              <option
                v-for="(head, index) in headDepartametns"
                v-bind:key="index"
              >
                {{ head.name_head_depart }}
                <!-- {{ head.name }}
                {{ head.id }} -->
              </option>
            </select>
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-outline-primary">
              <router-link :to="{ name: 'employees' }">Возвратиться</router-link>
            </button>
            <button type="submit" :disabled="saving" class="btn btn-primary">Обновить</button>
          </div>
        </form>
      </div>
    </div>
    <!-- {{ selected.id }} -->
  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      photo:{
        photoDat: null,
        photoLink: null,
        photoLinkDefault: "/storage/photos/no_photo.png"
      },
      saving: null,
      msg: "",
      headDepartametns: [],
      positions: [],
      error: null,
      loaded: false,
      selectedPosit: {
        id: ""
      },
      employe: {
        id: "",
        name: "",
        position: "",
        employment: "",
        ratio: "",
        salary_position: "",
        name_head_depart: ""
      },
        selectedHedDep: "",
        headDeprts:""
    };
  },
  computed: {
    allSalary: function() {
      return this.employe.ratio * this.employe.salary_position;
    }

  },
  watch: {},
  methods: {
    onSubmit(event) {
      this.saving = true;

        this.headDeprts = '';
      if(this.selectedHedDep !== ''){
         this.headDeprts = this.selectedHedDep;
      }else{
         this.headDeprts = this.employe.name_head_depart;
      }
      // console.log(this.headDeprts)

      axios
        .put("/api/employees/" + this.employe.id, {
          name: this.employe.name,
          position: this.employe.position,
          employment: this.employe.employment,
          ratio: this.employe.ratio,
          name_head_depart: this.headDeprts
        })
        .then(response => {
          this.msg = "Сотрудник обновлён";
          console.log(response + "сотруд обн");
          this.employe = response.data;
        })
        .catch(error => {
          console.log(error);
        })
        .then(() => (this.saving = false));
    },
    onFileSelected(e) {
      const file = this.$refs.file.files[0];
      this.photo.photoDat = file;
      this.photo.photoLink = URL.createObjectURL(file)
    },

    onUpload() {
      let settings = { headers: { "Content-Type": "multipart/form-data" } };
      const formData = new FormData();
      formData.append("file", this.photo.photoDat, this.photo.photoDat.name);
      axios
        .post("/api/employees/storephotos", formData, settings)
        .then(response => {
          console.log(response);
        })
        .catch(response => {
          console.log(response);
        });
    },

    getHeadDepartament() {
      axios
        .get("/api/employees/headdeparts")
        .then(response => {
          this.headDepartametns = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    getPositions() {
      axios
        .get("/api/employees/positions")
        .then(response => {
          this.positions = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    }
  },

  mounted() {
    this.getHeadDepartament();
    this.getPositions();
  },

  created() {
    this.error = null;
    axios
      .get("/api/employees/" + this.$route.params.id + "/edit")
      .then(response => {
        this.employe = response.data;
        this.loaded = true;
      })
      .catch(error => {
        this.error = error.response.data || error.message;
        console.log(error);
      });
  }
};
</script>

<style scoped>
</style>
