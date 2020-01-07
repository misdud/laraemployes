<template>
  <div>
    <!-- {{ employe }}
    {{ employe.employment }}
    <hr />
    {{ headDepartametns }}-->
    <!-- {{ positions }} -->
    <hr />
    <div v-if="! loaded">Загрузка...</div>
    <form @submit.prevent="onSubmit($event)" v-else>
      <div class="form-group">
        <label for="employe">ФИО</label>
        <input class="form-control" id="employe" v-model.lazy="employe.name" />
      </div>
      <div class="form-group">
        <label for="position">Должность</label>
        <select class="form-control" id="position">
          <option
            v-for="(posit, index) in positions"
            v-bind:selected="posit.name_position === employe.position"
            v-bind:key="index"
            v-bind:value="posit.id"
          >
            {{ posit.name_position}}
            \ Оклад: {{ posit.salary_position }}
            id{{ posit.id }}
          </option>
        </select>
      </div>
      <!-- {{ posit.id }} -->
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
      <p>{{allSalary}}</p>
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
        <button type="submit" class="btn btn-primary">Обновить</button>
      </div>
    </form>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      headDepartametns: [],
      positions: [],
      error: null,
      loaded: false,
      employe: {
        id: null,
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
  watch: {
    employe: function(val1, val2) {
      this.employe.salary_position + 222;
    }
  },
  methods: {
    onSubmit(event) {
      // @todo form submit event
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
