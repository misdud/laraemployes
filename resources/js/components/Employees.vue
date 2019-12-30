<template>
    <div>
        <div class="row pl-3">
            <button type="button" class="btn btn-secondary btn-sm"> + Добавить сотрудника</button>
        </div>
        <br />

        <div v-if="error" class="error">
            <p>{{ error }}</p>
            <p>
                <button @click.prevent="fetchData" type="button" class="btn btn-warning">
                    Повторить
                </button>
            </p>
        </div>

        <table class="table table-hover" v-if="emplouees" >
            <thead class="thead-dark">
            <tr>
                <th scope="col">id</th>
                <th scope="col">ФИО <a v-on:click="sortFioData" href="#" >&#8659; </a></th>
                <th scope="col">Должность <a href="#">&#8659; </a></th>
                <th scope="col">Дата приёма <a href="#">&#8659; </a></th>
                <th scope="col">Размер з\п <a href="#">&#8659; </a></th>
                <th scope="col">Отдел <a href="#">&#8659; </a></th>
                <th scope="col">Фото</th>
                <th scope="col">Действие</th>
            </tr>
            <tr>
                <td class="bg-secondary"></td>
                <td class="bg-secondary"><form class="form-inline">
                    <input class="form-control mr-sm-2 w-50 border-right-1" width="7" type="search" placeholder="Введите фио" aria-label="Search">
                    <button class="btn btn-outline-success " type="submit">Найти</button>
                </form></td>
                <td class="bg-secondary"><form class="form-inline">
                    <input class="form-control mr-sm-2 w-50"  type="search" placeholder="Введите должность" aria-label="Search">
                    <button class="btn btn-outline-success " type="submit">Найти</button>
                </form></td>
                <td class="bg-secondary"><form class="form-inline">
                    <input class="form-control mr-sm-2 w-50"  type="date" placeholder="Введите дату" aria-label="Search">
                    <button class="btn btn-outline-success " type="submit">Найти</button>
                </form></td>
                <td class="bg-secondary"><form class="form-inline ">
                    <input class="form-control  mr-sm-2 w-50"  type="number" placeholder="Введите сумму" aria-label="Search">
                    <button class="btn btn-outline-success " type="submit">Найти</button>
                </form></td>
                <td class="bg-secondary"><form class="form-inline">
                    <input class="form-control mr-sm-2 w-50"  type="search" placeholder="Введите отдел" aria-label="Search">
                    <button class="btn btn-outline-success " type="submit">Найти</button>
                </form></td>
                <td class="bg-secondary"></td>
                <td class="bg-secondary"></td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="{ name, position, employment, department, salary_position, ratio, id } in emplouees ">
                <td>{{ id }}</td>
                <td>{{ name }}</td>
                <td>{{ position }}</td>
                <td>{{ employment}}</td>
                <td>{{ salary_position * ratio }}</td>
                <td>{{ department}}</td>
                <td>фото</td>
                <td><button type="button" class="btn btn-outline-secondary">
                    Изменить</button></td>
            </tr>
            </tbody>
        </table>

        <div class="pagination-centered" >
            <button type="button" class="btn btn-outline-secondary" :disabled="! prevPage" @click.prevent="goToPrev"> < </button>
            <span class="pt-2 ml-2 mr-2"> {{ paginatonCount }} </span>
            <button type="button" class="btn btn-outline-secondary" :disabled="! nextPage" @click.prevent="goToNext"> > </button>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    const getEmploue = (page, callback) => {
        const params = { page };
        axios
            .get('/api/employees', { params })
            .then(response => {
                callback(null, response.data);
            }).catch(error => {
            callback(error, error.response.data);
        });
    };

    export default {
        name: 'Hierarchyt',
        data() {
            return {
                sort:'',
                erorr: null,
                emplouees: null,
                meta: null,
                links: {
                    first: null,
                    last: null,
                    next: null,
                    prev: null,
                },

            };
        },
        computed: {
            nextPage() {
                if (! this.meta || this.meta.current_page === this.meta.last_page) {
                    return;
                }
                return this.meta.current_page + 1;
            },
            prevPage() {
                if (! this.meta || this.meta.current_page === 1) {
                    return;
                }
                return this.meta.current_page - 1;
            },
            paginatonCount() {
                if (! this.meta) {
                    return;
                }

                const { current_page, last_page } = this.meta;

                return `${current_page} of ${last_page}`;
            },
        },
        beforeRouteEnter (to, from, next) {
            getEmploue(to.query.page, (err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        beforeRouteUpdate (to, from, next) {
            this.users = this.links = this.meta = null
            getEmploue(to.query.page, (err, data) => {
                this.setData(err, data);
                next();
            });
        },

        created() {
            this.fetchData();
        },
        mounted(){

        },
        methods: {
            fetchData() {
                this.error = this.emplouees = null;
                axios
                    .get('/api/employees')
                    .then(response=>{
                        this.emplouees = response.data.data;
                    }).catch(error => {
                    this.error = error.response.data.message || error.message;
                });
            },
            sortFioData() {
                this.error = this.emplouees = null;
                axios
                    .get('/api/employees/sortfio')
                    .then(response=>{
                        this.emplouees = response.data.data;
                    }).catch(error => {
                    this.error = error.response.data.message || error.message;
                });
            },
            goToNext() {
                this.$router.push({
                    query: {
                        page: this.nextPage,
                    },
                });
            },
            goToPrev() {
                this.$router.push({
                    query: {
                        page: this.prevPage,
                    }
                });
            },
            setData(err, { data: emplouees, links, meta }) {
                if (err) {
                    this.error = err.toString();
                } else {
                    this.emplouees = emplouees;
                    this.links = links;
                    this.meta = meta;
                }
            },


        }
    }

</script>


<style>

</style>
