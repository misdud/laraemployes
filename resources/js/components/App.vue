<template>
  <div>
    <h1>Vue\Laravel (SPA)</h1>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav">
          <!-- <li class="nav-item active">
            <router-link class="nav-link" :to="{ name: 'hierarchy' }">Иерархия</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" :to="{ name: 'employees' }">Сотрудники</router-link>
          </li>-->
          <router-link tag="li" class="nav-item" exact to="/" active-class="active">
            <a class="nav-link">Иерархия</a>
          </router-link>
          <router-link tag="li" class="nav-item" to="/employees" active-class="active">
            <a class="nav-link">Сотрудники</a>
          </router-link>
        </ul>
      </div>
    </nav>
    <!--
    <p>
      <router-link :to="{ name: 'hierarchy' }">Иерархия</router-link>|
      <router-link :to="{ name: 'employees' }">Сотрудники</router-link>
    </p>-->

    <div class="container-fluid">
      <router-view></router-view>
    </div>
          <!-- <app-hierarchy></app-hierarchy> -->
  </div>
</template>
<script>
import Hierarchy from "./Hierarchy";
export default {
  components: {
    appHierarchy: Hierarchy
  }
};
</script>
