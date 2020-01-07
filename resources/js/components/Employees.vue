<template>
  <div>
    <div class="row">
      <div class="col-2">
        <div>
          <button type="button" class="btn btn-secondary btn-sm">+ Добавить сотрудника</button>
        </div>
      </div>
      <div class="col-5">
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
      <div v-if="status" class="alert alert-warning alert-dismissible" role="alert">
        <strong>{{ message }}!</strong>
        <button v-on:click="status=false" type="button" class="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div v-if="error" class="error">
        <p>{{ error ? erorr: '' }}</p>
        <p>
          <button @click.prevent="fetchData()" type="button" class="btn btn-warning">Повторить</button>
        </p>
      </div>

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
            <td class="bg-secondary"></td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in employees.data" v-bind:key="index">
            <td>{{ item.id }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.position }}</td>
            <td>{{ item.employment }}</td>
            <td>{{ item.salary_position * item.ratio }}</td>
            <td>{{ item.name_head_depart }}</td>
            <td>{{ item.id }}</td>
            <td>
              <button type="button" class="btn btn-outline-secondary">
                <router-link :to="{ name: 'employees.edit', params: { id: item.id  }}">
                  <span>Изменить</span>
                </router-link>
              </button>
              <button
                type="button"
                class="btn btn-outline-danger"
                v-on:click="deleteEmpoyes(item.id, index)"
              >Удалить</button>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="row">
        <div class="col-md-8">
          <nav>
            <ul class="pagination">
              <li v-bind:class="{disabled:!employees.links.first}" class="page-item">
                <a href="#" v-on:click="fetchData(employees.links.first)" class="page-link">&laquo;</a>
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
        Страница : {{ employees.meta.from }} - {{ employees.meta.to }}
        Всего: {{ employees.meta.total}}
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
      erorr: false,
      status: false,
      message: null,
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
  updated() {},
  methods: {
    fetchData(pagi) {
      this.error = null;
      pagi = pagi || "/api/employees";
      axios
        .get(pagi)
        .then(response => {
          this.employees = response.data;
        })
        .catch(error => {
          this.error = error.response.data.message || error.message;
        });
    },
    sortFioData() {
      this.error = null;
      axios
        .get("/api/employees/sortfio")
        .then(response => {
          this.employees = response.data.data;
        })
        .catch(error => {
          this.error = error.response.data.message || error.message;
        });
    },
    deleteEmpoyes(id, index) {
      let conf = confirm("Вы точно хотите удалиь этого сотрудника?");
      if (conf === true) {
        this.message = null;
        axios
          .delete("/api/employees/" + id)
          .then(response => {
            this.employees.data.splice(index, 1);
            this.message = response.data.message;
            this.status = true;
          })
          .catch(error => {
            this.error = error.response.data.message || error.message;
          });
      }
    }
  }
};
</script>


<style scoped>
</style>


