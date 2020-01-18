<template>
  <div class="row ml-2 mr-2">
    <div v-if="erorrMy">
      <p>
        {{ erorrMsg }}
        <br />
        <button @click.prevent="fetchData()" type="button" class="btn btn-warning">Повторить</button>
      </p>
    </div>
    <div class="row" v-else>
      <app-redistr v-bind:nameHeads="headDepartametns"></app-redistr>
      <div class="row">
        <table class="table table-hover">
          <thead class="thead-dark">
            <tr>
              <th scope="col">id</th>
              <th scope="col">
                ФИО
                <a v-on:click="sortFioData" href="#">&#8659;</a>
                <a v-on:click="sortOrderName" href="#">&#8657;</a>
              </th>
              <th scope="col">
                Должность
                <a v-on:click="sortPosition" href="#">&#8659;</a>
                <a v-on:click="sortOrderPos" href="#">&#8657;</a>
              </th>
              <th scope="col">
                Дата приёма
                <a v-on:click="sortDate" href="#">&#8659;</a>
                <a v-on:click="sortOrderEmpl" href="#">&#8657;</a>
              </th>
              <th scope="col">
                Размер з\п
                <a v-on:click="sortSalary" href="#">&#8659;</a>
                <a v-on:click="sortOrderRatio" href="#">&#8657;</a>
              </th>
              <th scope="col">
                Начальник
                <a v-on:click="sortHead" href="#">&#8659;</a>
                <a v-on:click="sortOrderDepart" href="#">&#8657;</a>
              </th>
              <th scope="col">Фото</th>
              <th scope="col">Действие</th>
            </tr>
            <tr>
              <td class="bg-secondary"></td>
              <td class="bg-secondary">
                <input
                  class="form-control"
                  width="10"
                  type="text"
                  placeholder="фио"
                  v-model.lazy="keywords"
                />
              </td>
              <td class="bg-secondary">
                <select class="form-control" v-model="selectedPositEmpl">
                  <option value></option>
                  <option
                    v-for="(posit, index) in positions"
                    v-bind:key="index"
                  >{{ posit.name_position}}</option>
                </select>
              </td>
              <td class="bg-secondary">
                <input class="form-control" type="date" v-model.lazy="saerchDate" />
              </td>
              <td class="bg-secondary">
                <input
                  class="form-control"
                  type="number"
                  placeholder="Cумма"
                  min="1500"
                  max="2500"
                  step="100"
                  v-model.number="saerchSalary"
                />
              </td>
              <td class="bg-secondary">
                <select class="form-control" v-model="selectedDepart">
                  <option value></option>
                  <option
                    v-for="(head, index) in headDepartametns"
                    v-bind:key="index"
                  >{{ head.name_head_depart }}</option>
                </select>
              </td>
              <td class="bg-secondary"></td>
              <td class="bg-secondary">
                <router-link :to="{ name: 'employees.create' }">
                  <a class="btn btn-success mya">Добавить</a>
                </router-link>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in employees.data" v-bind:key="index">
              <td>{{ item.id }}</td>
              <td>{{ item.name }}</td>
              <td>{{ item.position }}</td>
              <td>{{ item.employment }}</td>
              <td>{{ Math.ceil(item.salary_position * item.ratio) }} руб. ({{ item.ratio }})</td>
              <td>{{ item.name_head_depart }}</td>
              <td>
                <img
                  :src="'/storage/photos/'+item.id+'.jpeg'"
                  title="фото"
                  height="40px"
                  width="35 px"
                />
              </td>
              <td>
                <button type="button" class="btn btn-outline-secondary">
                  <router-link :to="{ name: 'employees.edit', params: { id: item.id  }}">
                    <span>Изменить</span>
                  </router-link>
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <div class="row">
          <div class="col">
            <nav>
              <ul class="pagination">
                <li v-bind:class="{disabled:!employees.links.first}" class="page-item">
                  <a
                    href="#"
                    v-on:click="fetchDataSearch(employees.links.first)"
                    class="page-link"
                  >&laquo;</a>
                </li>

                <li v-bind:class="{disabled:!employees.links.prev}" class="page-item">
                  <a
                    href="#"
                    v-on:click="fetchDataSearch(employees.links.prev)"
                    class="page-link"
                  >Назад</a>
                </li>

                <li v-bind:class="{disabled:!employees.links.next}" class="page-item">
                  <a
                    href="#"
                    v-on:click="fetchDataSearch(employees.links.next)"
                    class="page-link"
                  >Вперёд</a>
                </li>

                <li v-bind:class="{disabled:!employees.links.last}" class="page-item">
                  <a
                    href="#"
                    v-on:click="fetchDataSearch(employees.links.last)"
                    class="page-link"
                  >&raquo;</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div>Страница : {{ employees.meta.from }} - {{ employees.meta.to }}</div>
          <div>Всего: {{ employees.meta.total}}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import EmployeRedistr from "./EmployeRedistr";

export default {
  name: "Employees",
  data() {
    return {
      keySort: [],
      order: "asc",
      positions: [],
      selectedPositEmpl: "",
      headDepartametns: [],
      selectedDepart: "",
      keywords: "",
      saerchDate: "",
      saerchSalary: "",
      //   order: "id_departament",
      pagi: [],
      erorrMy: false,
      erorrMsg: "",
      status: false,
      employees: {
        data: null,
        links: {
          first: ""
        },
        meta: {
          from: ""
        }
      }
    };
  },
  components: {
    appRedistr: EmployeRedistr
  },
  watch: {
    keywords(after, before) {
      this.fetchDataSearch();
    },
    selectedPositEmpl() {
      this.saerchDate = "";
      this.selectedDepart = "";
      this.fetchDataSearch();
    },
    saerchDate() {
      this.fetchDataSearch();
    },
    saerchSalary() {
      this.fetchDataSearch();
    },
    selectedDepart() {
      this.fetchDataSearch();
    },

    //--for-----sort
    keySort() {
      this.fetchDataSearch();
      //   this.fetchDataErase();
    },
    order() {
      this.fetchDataSearch();
      //   this.fetchDataErase();
    }
  },

  mounted() {
    this.fetchData();
    this.getPositions();
    this.getHeadDepartament();
  },
  methods: {
    fetchData(pagi) {
      pagi = pagi || "/api/employees";
      axios
        .get(pagi)
        .then(response => {
          this.employees = response.data;
        })
        .catch(error => {
          this.erorrMy = true;
          this.erorrMsg = error;
        });
    },
    fetchDataSearch(pagi) {
      pagi = pagi || "/api/employees/search";
      axios
        .get(pagi, {
          params: {
            keywords: this.keywords,
            selectedPosit: this.selectedPositEmpl,
            saerchDate: this.saerchDate,
            saerchSalary: this.saerchSalary,
            selectedDepart: this.selectedDepart,
            keySort: this.keySort,
            order: this.order
          }
        })
        .then(response => {
          this.employees = response.data;
        })
        .catch(error => {
          this.erorrMy = true;
          this.erorrMsg = error;
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
    sortFioData() {
      this.keySort = "full_name";
      this.order = "asc";
    },
    sortPosition() {
      this.keySort = "id_positione";
      this.order = "asc";
    },
    sortDate() {
      this.keySort = "employment";
      this.order = "asc";
    },
    sortSalary() {
      this.keySort = "ratio";
      this.order = "asc";
    },
    sortHead() {
      this.keySort = "id_departament";
      this.order = "asc";
    },
    //----for -- sort -- order --desc
    sortOrderName() {
      this.keySort = "full_name";
      this.order = "desc";
    },
    sortOrderPos() {
      this.keySort = "id_positione";
      this.order = "desc";
    },
    sortOrderEmpl() {
      this.keySort = "employment";
      this.order = "desc";
    },
    sortOrderRatio() {
      this.keySort = "ratio";
      this.order = "desc";
    },
    sortOrderDepart() {
      this.keySort = "id_departament";
      this.order = "desc";
    }
  }
};
</script>


<style scoped>
.mya {
  color: black;
}
.mya:hover {
  color: rgb(255, 255, 255);
}
</style>


