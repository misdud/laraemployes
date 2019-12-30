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
            <tr v-for="(item, index) in emplouees.data">
                <td>{{ index+1 }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.position }}</td>
                <td>{{ item.employment}}</td>
                <td>{{ item.salary_position * item.ratio }}</td>
                <td>{{ item.department}}</td>
                 <td>{{ item.id }}</td>
                <td><button type="button" class="btn btn-outline-secondary">
                    Изменить</button></td>
            </tr>
            </tbody>
        </table>
                        
        <div class="row">
        	<div class="col-md-8">
        		<nav>
        			<ul class="pagination">
<li v-bind:class="{disabled:!emplouees.links.first}" class="page-item"><a href="#" v-on:click="fetchData(emplouees.links.first)" class="page-link">&laquo;</a></li>

<li v-bind:class="{disabled:!emplouees.links.prev}" class="page-item"><a href="#" v-on:click="fetchData(emplouees.links.prev)" class="page-link">&lt</a></li>


<li v-bind:class="{disabled:!emplouees.links.next}" class="page-item"><a href="#" v-on:click="fetchData(emplouees.links.next)" class="page-link">&gt</a></li>

<li v-bind:class="{disabled:!emplouees.links.last}" class="page-item"><a href="#" v-on:click="fetchData(emplouees.links.last)" class="page-link">&raquo;</a></li>
        			</ul>
        		</nav>
        	
        	</div>
        	
        	</div>

        	<div class="col-md-4">
        		Страница : {{ emplouees.meta.from }} - {{ emplouees.meta.to }}
        		Всего: {{ emplouees.meta.total}}
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
                erorr: null,
                emplouees: null,
                pagination:{}

            }
        },
        computed: {

        },
        created() {
            this.fetchData();
        },
        mounted(){

        },
        methods: {
            fetchData(pagi) {
                this.error = this.emplouees = null;
                pagi = pagi || '/api/employees';
                axios
                    .get(pagi)
                    .then(response=>{
                        this.emplouees = response.data;
      
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
