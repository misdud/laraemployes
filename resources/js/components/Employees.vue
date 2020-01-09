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
        <div class="col">
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
                <form class="form-inline">
                  <input
                    class="form-control mr-sm-2 w-50 border-right-1"
                    width="7"
                    type="search"
                    placeholder="Введите фио"
                    aria-label="Search"
                  />
                  <button class="btn btn-outline-success" type="submit">Найти</button>
                </form>
              </td>
              <td class="bg-secondary">
                <form class="form-inline">
                  <input
                    class="form-control mr-sm-2 w-50"
                    type="search"
                    placeholder="Введите должность"
                    aria-label="Search"
                  />
                  <button class="btn btn-outline-success" type="submit">Найти</button>
                </form>
              </td>
              <td class="bg-secondary">
                <form class="form-inline">
                  <input
                    class="form-control mr-sm-2 w-50"
                    type="date"
                    placeholder="Введите дату"
                    aria-label="Search"
                  />
                  <button class="btn btn-outline-success" type="submit">Найти</button>
                </form>
              </td>
              <td class="bg-secondary">
                <form class="form-inline">
                  <input
                    class="form-control mr-sm-2 w-50"
                    type="number"
                    placeholder="Введите сумму"
                    aria-label="Search"
                  />
                  <button class="btn btn-outline-success" type="submit">Найти</button>
                </form>
              </td>
              <td class="bg-secondary">
                <form class="form-inline">
                  <input
                    class="form-control mr-sm-2 w-50"
                    type="search"
                    placeholder="Введите отдел"
                    aria-label="Search"
                  />
                  <button class="btn btn-outline-success" type="submit">Найти</button>
                </form>
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
                  <a href="#" v-on:click="fetchData(employees.links.prev)" class="page-link">Назад</a>
                </li>

                <li v-bind:class="{disabled:!employees.links.next}" class="page-item">
                  <a href="#" v-on:click="fetchData(employees.links.next)" class="page-link">Вперёд</a>
                </li>

                <li v-bind:class="{disabled:!employees.links.last}" class="page-item">
                  <a href="#" v-on:click="fetchData(employees.links.last)" class="page-link">&raquo;</a>
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

  mounted() {
    this.fetchData();
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
    sortFioData() {
      axios
        .get("/api/employees/sortfio")
        .then(response => {
          this.employees = response.data.data;
        })
        .catch(error => {
          this.erorrMy = true;
          this.erorrMsg = error;
        });
    }
  }
};
</script>


<style scoped>
</style>


