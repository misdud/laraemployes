import VueRouter from "vue-router";
import Hierarchyt from "./components/hierarchy";
import Employees from "./components/employees";
import EmployeesEdit from "./components/EmployeesEdit";

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
        path: "/employees/:id/edit",
        name: "employees.edit",
        component: EmployeesEdit
    }
];

export default new VueRouter({
    mode: "history",
    routes
});
