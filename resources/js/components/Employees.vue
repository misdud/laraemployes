<template>
    <div>
        <div class="row pl-3">
            <button type="button" class="btn btn-secondary btn-sm"> + Добавить сотрудника</button>
        </div>
        <br />
        <div v-if="loading" class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>

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
                <th scope="col">ФИО<a>&#9674;</a></th>
                <th scope="col">Должность<a>&#9674;</a></th>
                <th scope="col">Дата приёма <a>&#9674;</a></th>
                <th scope="col">Размер з\п<a>&#9674;</a></th>
                <th scope="col">Отдел<a>&#9674;</a></th>
                <th scope="col">Действие</th>
            </tr>
            <tr>

                <td><form class="form-inline">
                    <input class="form-control mr-sm-2" width="7" type="search" placeholder="Введите фио" aria-label="Search">
                    <button class="btn btn-outline-success mt-2" type="submit">Найти</button>
                </form></td>
                <td><form class="form-inline">
                    <input class="form-control mr-sm-2"  type="search" placeholder="Введите должность" aria-label="Search">
                    <button class="btn btn-outline-success mt-2" type="submit">Найти</button>
                </form></td>
                <td><form class="form-inline">
                    <input class="form-control mr-sm-2"  type="date" placeholder="Введите дату" aria-label="Search">
                    <button class="btn btn-outline-success mt-2" type="submit">Найти</button>
                </form></td>
                <td><form class="form-inline">
                    <input class="form-control mr-sm-2" type="search" placeholder="Введите сумму" aria-label="Search">
                    <button class="btn btn-outline-success mt-2" type="submit">Найти</button>
                </form></td>
                <td><form class="form-inline">
                    <input class="form-control mr-sm-2"  type="search" placeholder="Введите отдел" aria-label="Search">
                    <button class="btn btn-outline-success mt-2" type="submit">Найти</button>
                </form></td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="{ name, position, employment, department, salary_position, ratio, headDepartment } in emplouees ">
                <td>{{ name }}</td>
                <td>{{ position }}</td>
                <td>{{ employment}}</td>
                <td>{{ salary_position * ratio }}</td>
                <td>{{ department}}</td>
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
                sortBy: 'age',
                sortDesc: false,
                fields: [
                    { key: 'name', sortable: true },
                    { key: 'position', sortable: true },
                    { key: 'employment', sortable: true },
                    { key: 'department', sortable: false }
                ],
                loading: false,
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
                this.loading = true;
                axios
                    .get('/api/employees')
                    .then(response=>{
                        this.loading = false;
                        this.emplouees = response.data.data;
                    }).catch(error => {
                    this.loading = false;
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
