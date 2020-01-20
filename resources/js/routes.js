import VueRouter from "vue-router";
import Hierarchy from "./components/Hierarchy";
//import Employees from "./components/employees";
//import EmployeesEdit from "./components/EmployeesEdit";
import EmployeesNew from "./components/EmployeesNew";

//lasy_down_component
const Employees = () => import(/* webpackChunkName: "employe" */'./components/employees')
//lasy_down_route
const EmployeesEdit = resolve => {
    require.ensure(['./components/EmployeesEdit'], () => {
      resolve(require('./components/EmployeesEdit.vue'))
    })
  }

let routes = [
    {
        path: "/",
        name: "hierarchy",
        component: Hierarchy
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
    }
];

export default new VueRouter({
    mode: "history",
    routes
});
