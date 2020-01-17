<template>
  <div class="jumbotron p-0">
    <div class="row justify-content-center pt-4 pb-3 bg-info border">
      <h3>Работа с карточкой сотрудника</h3>
    </div>
    <div class="row mt-4">
      <div class="col"></div>
      <div class="col border">
        <form>
          <div class="custom-file">

            <br />
            <div><img v-if="photo.photoLink" :src="photo.photoLink" height="240 px" width="240 px" />
            <img v-else :src="photo.photoLinkDefault+employe.id+'.jpeg'" height="240 px" width="240 px" /></div>
            <input
              type="file"
              id="file"
              ref="file"
              v-on:change="onFileSelected"
              class="custom-file-input"
            />
            <label for="file" class="custom-file-label myclassPhoto">Выберите фото:</label>
            <p class="border mt-5 p-2">Поддерживаемые форматы для загрузки: jpg, jepg<br />
            размер не более 5 мб.</p>
             <div class="border pl-2 pr-2"> {{ infoPhoto }}</div>
            <button v-on:click="onUpload" type="button" class="btn btn-primary mt-3">Загрузить</button>
          </div>
        </form>
      </div>

      <div class="col">
        <div v-if="status" class="alert alert-warning alert-dismissible" role="alert">
          <strong>{{ msg }}!</strong>
          <button v-on:click="status=false" type="button" class="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div v-if="! loaded">Загрузка...</div>
        <form v-on:submit.prevent="onSubmit($event)" v-else>
          <div class="form-group">
            <label for="employe">ФИО</label>
            <input class="form-control" id="employe" v-model.lazy="employe.name" />
          </div>
          <div class="form-group">
            <label for="position">
              Должность:
              <b>{{ employe.position}}</b>
              Оклад: {{ employe.salary_position}}
            </label>
            <select class="form-control" id="position" v-model="selectedPosit">
              <option disabled value>Выберите должность</option>
              <option
                v-for="(posit, index) in positions"
                v-bind:key="index"
              >{{ posit.name_position}}</option>
            </select>
          </div>

          <div class="form-group">
            <label for="employment">
              Дата приема:
              <b>{{employe.employment}}</b>
            </label>
            <input class="form-control" id="employment" type="date" v-model="employe.employment" />
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
          <p>Текущая зарплата: {{ allSalary }}</p>
          <p
            v-if="isSalEditPost"
            class="bg-info p-1 myclass"
          >При смене должности: {{ salaryEdtPost}}</p>
          <div class="form-group">
            <label for="name_head_depart">
              Текущий начальник:
              <b>{{ employe.name_head_depart}}.</b>
            </label>
            <select class="form-control" id="name_head_depart" v-model="selectedHedDep">
              <option disabled value>Выберите руководителя для смены</option>
              <option
                v-for="(head, index) in headDepartametns"
                v-bind:key="index"
              >{{ head.name_head_depart }}</option>
            </select>
          </div>
          <div class="form-group">
            <button type="submit" :disabled="saving" class="btn btn-primary">Обновить</button>
            <button type="button" class="btn btn-outline-danger" v-on:click="deleteEmpoye()">Удалить</button>
            {{ this.employe.id}}
          </div>
        </form>
      </div>
      <div class="col"></div>
    </div>
    <!-- {{ selected.id }} -->
  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      photo: {
        photoDat: null,
        photoLink: null,
        photoLinkDefault: "/storage/photos/",
      },
      infoPhoto: null,

      status: false,
      msg: "",
      saving: null,
      headDepartametns: [],
      positions: [],
      error: null,
      loaded: false,
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
      headDeprts: "",
      selectedPosit: "",
      selPosit: "",
      salaryEditPost: "",
      isSalEditPost: false
    };
  },
  computed: {
    allSalary: function() {
      return Math.ceil(this.employe.ratio * this.employe.salary_position);
    },
    salaryEdtPost() {
      return Math.ceil(this.salaryEditPost * this.employe.ratio);
    }
  },
  watch: {
    selectedPosit() {
      //console.log(this.selectedPosit);
      this.getSalaryEdit(this.positions, this.selectedPosit);
      this.isSalEditPost = true;
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
  },

  methods: {
    onSubmit(event) {
      this.saving = true;

      if (this.selectedHedDep !== "") {
        this.headDeprts = this.selectedHedDep;
      } else {
        this.headDeprts = this.employe.name_head_depart;
      }
      // console.log(this.headDeprts)
      if (this.selectedPosit !== "") {
        this.selPosit = this.selectedPosit;
      } else {
        this.selPosit = this.employe.position;
      }
      //   console.log(this.selPosit);
      //   console.log(typeof this.employe.employment);
      axios
        .put("/api/employees/" + this.employe.id, {
          name: this.employe.name,
          position: this.selPosit,
          employment:
            this.employe.employment == ""
              ? this.employe.employment
              : this.employe.employment,
          ratio: this.employe.ratio,
          name_head_depart: this.headDeprts
        })
        .then(response => {
          //console.log(response + "сотруд обн");
          this.employe = response.data;
          this.msg = "Сотрудник обновлён";
          this.status = true;
          this.isSalEditPost = false;
        })
        .catch(error => {
          console.log(error);
        })
        .then(() => (this.saving = false));
    },
    onFileSelected(e) {
      const file = this.$refs.file.files[0];
      this.photo.photoDat = file;
      this.photo.photoLink = URL.createObjectURL(file);
    },

    onUpload() {
      let settings = { headers: { "Content-Type": "multipart/form-data" } };
      const formData = new FormData();
      formData.append("file", this.photo.photoDat, this.employe.id);
      axios
        .post("/api/employees/storephotos", formData, settings)
        .then(response => {
          console.log(response.data.errorPhoto);
          this.infoPhoto = response.data.errorPhoto;
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
    },
    deleteEmpoye() {
      let conf = confirm("Вы точно хотите удалиь этого сотрудника?");
      if (conf === true) {
        this.message = null;
        axios
          .delete("/api/employees/" + this.employe.id)
          .then(response => {
            this.$router.push({ name: "employees" });
            alert("Сотрудник был удалён");
          })
          .catch(error => {
            console.log(error);
          });
      }
    },
    getSalaryEdit(array, search) {
      var value = "";
      array.forEach(function(item) {
        if (item.name_position === search) {
          value = item.salary_position;
        }
      });
      //console.log(values);
      this.salaryEditPost = value;
    }
  }
};
</script>

<style scoped>
.myclass {
  border: 1px solid yellow !important;
  border-radius: 5px;
}
.myclassPhoto {
  margin-top: 280px;
}
</style>
