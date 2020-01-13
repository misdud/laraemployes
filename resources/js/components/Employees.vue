<template>
  <div>
    <div v-if="erorrMy">
      <p>
        {{ erorrMsg }}
        <br />
        <button @click.prevent="fetchData()" type="button" class="btn btn-warning">Повторить</button>
      </p>
    </div>
    <div class="row" v-else>
      <div class="row">
        <div class="col bg-">
          <p>Cортировать по:</p>
          <div class="form-check form-check-inline">
            <input
              class="form-check-input"
              type="radio"
              name="inlineRadioOptions"
              id="inlineRadio1"
              value="option1"
            />
            <label class="form-check-label" for="inlineRadio1">По ФИО</label>
          </div>
          <div class="form-check form-check-inline">
            <input
              class="form-check-input"
              type="radio"
              name="inlineRadioOptions"
              id="inlineRadio2"
              value="option2"
            />
            <label class="form-check-label" for="inlineRadio2">По должности</label>
          </div>
          <div class="form-check form-check-inline">
            <input
              class="form-check-input"
              type="radio"
              name="inlineRadioOptions"
              id="inlineRadio1"
              value="option1"
            />
            <label class="form-check-label" for="inlineRadio1">Дате приёма</label>
          </div>
          <div class="form-check form-check-inline">
            <input
              class="form-check-input"
              type="radio"
              name="inlineRadioOptions"
              id="inlineRadio2"
              value="option2"
            />
            <label class="form-check-label" for="inlineRadio2">По размеру з\п</label>
          </div>
        </div>
      </div>

      <br />
      <div class="row">
        <table class="table table-hover">
          <thead class="thead-dark">
            <tr>
              <th scope="col">id</th>
              <th scope="col">
                ФИО
                <a v-on:click="sortFioData" href="#">&#8659;</a>
                <a v-on:click="sortOrder" href="#">&#8657;</a>
              </th>
              <th scope="col">
                Должность
                <a href="#">&#8659;</a>
              </th>
              <th scope="col">
                Дата приёма
                <a href="#">&#8659;</a>
              </th>
              <th scope="col">
                Размер з\п
                <a href="#">&#8659;</a>
              </th>
              <th scope="col">
                Начальник
                <a href="#">&#8659;</a>
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
                <button type="button" class="btn btn-success">+ Добавить сотрудника</button>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in employees.data" v-bind:key="index">
              <td>{{ item.id }}</td>
              <td>{{ item.name }}</td>
              <td>{{ item.position }}</td>
              <td>{{ item.employment }}</td>
              <td>{{ Math.ceil(item.salary_position * item.ratio) }} руб.</td>
              <td>{{ item.name_head_depart }}</td>
              <td>{{ item.id }}</td>
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
          <div class="col-md-8">
            <nav>
              <ul class="pagination">
                <li v-bind:class="{disabled:!employees.links.first}" class="page-item">
                  <a
                    href="#"
                    v-on:click="fetchData(employees.links.first)"
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

        <div class="col-md-4">
          <div>Страница : {{ employees.meta.from }} - {{ employees.meta.to }}</div>
          <div>Всего: {{ employees.meta.total}}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Employees",
  data() {
    return {
      keySort:[],
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
  watch: {
    keywords(after, before) {
      this.fetchDataSearch();
    },
    selectedPositEmpl(after1, before1) {
      this.saerchDate = "";
      this.fetchDataSearch();
    },
    saerchDate(after2, before2) {
      this.fetchDataSearch();
    },
    saerchSalary(after3, before3) {
      this.fetchDataSearch();
    },
    selectedDepart(after4, before4) {
      this.fetchDataSearch();
    },

    //--for-----sort
    keySort(after5, before5){
      this.fetchDataErase();
    },
     order(after6, before6){
      this.fetchDataErase();
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
      console.log(this.keySort, '1test')
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
    sortOrder(){
           this.order = 'desc';
    },
      fetchDataErase(pagi) {
        console.log(this.keySort)
      pagi = pagi || "/api/employees/erases";
      axios
        .get(pagi, {
          params: {
            keySort: this.keySort,
            //---test
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
  }
};
</script>


<style scoped>
</style>


