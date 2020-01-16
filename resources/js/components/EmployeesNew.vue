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
          <strong>{{ msg ? msg: '' }}</strong>
          <ul>
            <li v-for="error in errors">{{ error }}</li>
          </ul>
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

          <div class="form-group">
            <label for="position">Должность:</label>
            <select
              class="custom-select"
              :class="{'is-valid': $v.selectedPosit.required}"
              required
              id="position"
              v-model="selectedPosit"
            >
              <option selected disabled value>Выберите должность</option>
              <option
                v-for="(posit, index) in positions"
                v-bind:key="index"
                v-on:value="$v.selectedPosit.$touch()"
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
            <select
              class="custom-select"
              :class="{'is-valid': $v.selectedHedDep.required}"
              id="name_head_depart"
              v-model="selectedHedDep"
            >
              <option disabled value>Выберите руководителя</option>
              <option
                v-for="(head, index) in headDepartametns"
                v-bind:key="index"
                v-on:value="$v.selectedHedDep.$touch()"
              >{{ head.name_head_depart }}</option>
            </select>
          </div>

          <button
            type="submit"
            v-bind:disabled="$v.$invalid || this.saving"
            class="btn btn-primary"
          >Создать</button>
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
      errors: [],
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
    },
    selectedHedDep: {
      required: required
    },
    selectedPosit: {
      required: required
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
        .post("/api/employees", {
          employeName: this.employeName,
          position: this.selectedPosit,
          ratio: this.employeRatio,
          departament: this.selectedHedDep
        })
        .then(response => {
          console.log("отправлено");
          this.errors = response.data.errors;
          this.status = true;
          this.msg = response.data.msg;
          console.log(response.data.msg);
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
    }
  },

  mounted() {
    this.getHeadDepartament();
    this.getPositions();
    this.getDate();
  }
};
</script>

<style scoped>
.myclass {
  border: 1px solid yellow;
  border-radius: 5px;
}
</style>
