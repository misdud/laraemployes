<template>
  <div class="jumbotron p-0">
    <div class="row justify-content-center pt-4 pb-3 bg-info border">
      <h3>Добавление сотрудника</h3>
    </div>
    <div class="row mt-4">
      <div class="col"></div>
      <div class="col border">
        <form>
          <div class="form-group">
            <label for="file" class="pt-3">Фото сотрудника:</label>
            <br />
            <img v-if="photo.photoLink" :src="photo.photoLink" height="240 px" width="240 px" />
            <img v-else :src="photo.photoLinkDefault" height="240 px" width="240 px" />
            <input
              type="file"
              id="file"
              ref="file"
              v-on:change="onFileSelected"
              class="form-control-file mt-3"
            />
            <button v-on:click="onUpload" type="button" class="btn btn-primary mt-3">Загрузить</button>
          </div>
        </form>
      </div>

      <div class="col">
        <div v-if="status" class="alert alert-warning alert-dismissible" role="alert">
          <strong>{{ msg }}!</strong>
          <button v-on:click="status = false" type="button" class="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div v-if="!loaded">Загрузка...</div>
        <form v-else v-on:submit.prevent="onSubmit($event)">
          <div class="form-group">
            <label for="emplName">
              ФИО:
              <b>{{ employeName ? employeName : "" }}</b>
            </label>
            <input
              type="text"
              class="form-control"
              :class="{'is-invalid': $v.employeName.$error}"
              id="emplName"
              placeholder="Введите ФИО"
              v-model="employeName"
              v-on:blur="$v.employeName.$touch()"
            />
            <div class="invalid-feedback" v-if="!$v.employeName.required">Поле не должно быть пустым</div>
            <div class="invalid-feedback" v-if="!$v.employeName.minLength">Минимум 5 символов</div>
          </div>

          <pre>{{ $v.employeName }}</pre>
          <div class="form-group">
            <label for="position">Должность:</label>
            <select class="form-control" id="position" v-model="selectedPosit">
              <option disabled value>Выберите должность</option>
              <option
                v-for="(posit, index) in positions"
                v-bind:key="index"
              >{{ posit.name_position }}</option>
            </select>
          </div>

          <div class="form-group">
            <label for="employment">Дата приема: {{ toDay }}</label>
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
              v-model="employeRatio"
            />
          </div>
          <p
            v-if="isPositSelect"
            class="bg-info p-1 myclass"
          >Зарплата: {{ salaryPost ? salaryPost : "" }}</p>
          <div class="form-group">
            <label for="name_head_depart">Начальник:</label>
            <select class="form-control" id="name_head_depart" v-model="selectedHedDep">
              <option disabled value>Выберите руководителя</option>
              <option
                v-for="(head, index) in headDepartametns"
                v-bind:key="index"
              >{{ head.name_head_depart }}</option>
            </select>
          </div>
          <div class="form-group">
            <button type="submit" :disabled="saving" class="btn btn-primary">Создать</button>
            <input
              v-on:click="isPositSelect = false"
              type="reset"
              class="btn btn-outline-secondary"
            />
          </div>
        </form>
      </div>
      <div class="col"></div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import { required, minLength } from "vuelidate/lib/validators";
export default {
  data() {
    return {
      photo: {
        photoDat: null,
        photoLink: null,
        photoLinkDefault: "/storage/photos/no_photo.png"
      },
      status: false,
      msg: "",
      saving: null,
      headDepartametns: [],
      positions: [],
      error: null,
      loaded: false,
      employeName: "",
      employeRatio: 1,

      toDay: "",
      selectedHedDep: "",
      headDeprts: "",
      selectedPosit: "",
      selPosit: "",

      salaryEditPost: "",
      isPositSelect: false
    };
  },
  validations: {
    employeName: {
      required: required,
      minLength: minLength(5)
    }
  },
  computed: {
    salaryPost: function() {
      return Math.ceil(this.employeRatio * this.salaryEditPost);
    }
  },
  watch: {
    selectedPosit() {
      this.getSalaryEdit(this.positions, this.selectedPosit);
      this.isPositSelect = true;
    }
  },
  methods: {
    onSubmit(event) {
      this.saving = true;

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
          console.log(response + "сотруд доб");
          this.employe = response.data;
          this.msg = "Сотрудник добавлен";
          this.status = true;
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
      let settings = {
        headers: { "Content-Type": "multipart/form-data" }
      };
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
          this.loaded = true;
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
          this.loaded = true;
        })
        .catch(error => {
          console.log(error);
        });
    },
    getDate() {
      let Data = new Date();
      let Year = Data.getFullYear();
      let Month = Data.getMonth();
      let Day = Data.getDate();
      let fMonth = "";

      switch (Month) {
        case 0:
          fMonth = "января";
          break;
        case 1:
          fMonth = "февраля";
          break;
        case 2:
          fMonth = "марта";
          break;
        case 3:
          fMonth = "апреля";
          break;
        case 4:
          fMonth = "мае";
          break;
        case 5:
          fMonth = "июня";
          break;
        case 6:
          fMonth = "июля";
          break;
        case 7:
          fMonth = "августа";
          break;
        case 8:
          fMonth = "сентября";
          break;
        case 9:
          fMonth = "октября";
          break;
        case 10:
          fMonth = "ноября";
          break;
        case 11:
          fMonth = "декабря";
          break;
      }

      let today = Day + " " + fMonth + " " + Year;
      this.toDay = today;
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
    },
    resetForm() {
      this.isPositSelect = false;
      console.log(this.isPositSelect, "--1");
    }
  },

  mounted() {
    this.getHeadDepartament();
    this.getPositions();
    this.getDate();
  },

  created() {
    this.error = null;
    axios
      .get("/api/employees/")
      .then(response => {
        this.employe = response.data;
      })
      .catch(error => {
        this.error = error.response.data || error.message;
        console.log(error);
      });
  }
};
</script>

<style scoped>
.myclass {
  border: 1px solid yellow;
  border-radius: 5px;
}
</style>
