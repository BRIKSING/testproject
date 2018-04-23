
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';

import axios from 'axios';
import VueResource from 'vue-resource';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);



window.Vue = require('vue');


/**


 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
 // Vue.component('button-counter', {
 //   data: function () {
 //     return {
 //       count: 0
 //     }
 //   },
 //   template: '<button v-on:click="count++">You clicked me {{ count }} times.</button>'
 // });

import RegisterPage from './RegisterForm.vue';
import App from './App.vue';
import exampl from './components/Example.vue';
import LoginPage from './LoginForm.vue';
import Header from './Header.vue';

import User from './User.vue';
import UserUpdate from './UserUpdate.vue';
import UserLogout from './UserLogout.vue';
import Calendar from './Calendar.vue';
import TaskUpdate from './TaskUpdate.vue'

Vue.component('example', require('./components/Example.vue'));

const routes = [
  {
    path: '/login',
    name: 'Зайти',
    component: LoginPage
  },
  {
    path: '/calendar',
    name: 'Календарь',
    component: Calendar
  },
  {
    path: '/register',
    name: 'Регистрация',
    component: RegisterPage,
    children: [
      {
        path: '/login',
        name: 'Войти',
        component: LoginPage
      }
    ]
  },
  {
    path: '/user',
    name: 'Информация о пользователе',
    component: User,
    children: [
      {
        path: 'userUpdate',
        name: 'Изменить профиль',
        component: UserUpdate
      }
    ]
  },
  {
    path: '/',
    name: 'Главная',
    component: exampl
  },
  {
    path: '/logout',
    name: 'Выход',
    component: UserLogout
  }
]

const router = new VueRouter({
  routes
})



Vue.router = router;
App.router = Vue.router;

const app2 = new Vue({
    el: '#app',
    router,
    components: {
      App
    },
    template: '<App></App>'
});
