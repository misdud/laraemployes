<template>
  <div>
    <div class="row">
      <!-- {{ employe }}
    {{ employe.employment }}
    <hr />
      {{ headDepartametns }}-->
      <!-- {{ positions }} -->
      <hr />
      <div class="col">
        <img :src="photoLink" alt="Image" class="img-responsive" height="50%" width="50%" />
        <br />
        <input type="file" id="file" ref="file" v-on:change="onFileSelected" />
        <button v-on:click="onUpload">Загрузить</button>
      </div>

      <div class="col">
        <div v-if="! loaded">Загрузка...</div>
        <form v-on:submit.prevent="onSubmit($event)" v-else>
          <div class="form-group">
            <label for="employe">ФИО</label>
            <input class="form-control" id="employe" v-model.lazy="employe.name" />
          </div>
          <div class="form-group">
            <label for="position">Должность</label>
            <select class="form-control" id="position" v-model="selected">
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
          <p>Текущая зарплата: {{allSalary}}</p>
          <div class="form-group">
            <label for="name_head_depart">Начальник</label>
            <select class="form-control" id="name_head_depart">
              <option
                v-for="(head, index) in headDepartametns"
                v-bind:selected="head.name_head_depart === employe.name_head_depart"
                v-bind:key="index"
                v-bind:value="head.id"
              >
                {{ head.name_head_depart }} \
                {{ head.name }}
                id{{ head.id }}
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
    {{ selected.id }}
  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      photoLink: "http://laraemployes/storage/photos/123.jpeg",
      selectedFile: "",
      saving: null,
      msg: "",
      headDepartametns: [],
      positions: [],
      error: null,
      loaded: false,
      selected: {
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
      }
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
      axios
        .put("/api/employees/" + this.employe.id, {
          name: this.employe.name,
          position: this.employe.position,
          employment: this.employe.employment,
          ratio: this.employe.ratio,
          name_head_depart: this.employe.name_head_depart
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
    onFileSelected() {
      console.log(event);
      this.selectedFile = this.$refs.file.files[0];
    },
    onUpload() {
      let settings = { headers: { "Content-Type": "multipart/form-data" } };
      const formData = new FormData();
      formData.append("file", this.selectedFile, this.selectedFile.name);
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
