<template>
    <div>
        <h1>Vue Main </h1>

        <p>
            <router-link :to="{ name: 'hierarchy' }">Иерархия</router-link> |
            <router-link :to="{ name: 'employees' }">Сотрудники</router-link>
        </p>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script>