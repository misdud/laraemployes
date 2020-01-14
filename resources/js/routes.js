import VueRouter from "vue-router";
import Hierarchyt from "./components/hierarchy";
import Employees from "./components/employees";
import EmployeesEdit from "./components/EmployeesEdit";
import EmployeesNew from "./components/EmployeesNew";

let routes = [
    {
        path: "/",
        name: "hierarchy",
        component: Hierarchyt
    },
    {
        path: "/employees",
        name: "employees",
        component: Employees
    },
    {
        path: "/employees/create",
        name: "employees.create",
        component: EmployeesNew
    },

    {
        path: "/employees/:id/edit",
        name: "employees.edit",
        component: EmployeesEdit
    },

];

export default new VueRouter({
    mode: "history",
    routes
});
