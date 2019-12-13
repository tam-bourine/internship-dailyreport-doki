import Vue from 'vue'
import Router from 'vue-router'
import { interopDefault } from './utils'
import scrollBehavior from './router.scrollBehavior.js'

const _0c3d58a0 = () => interopDefault(import('../pages/editor.vue' /* webpackChunkName: "pages/editor" */))
const _291aace2 = () => interopDefault(import('../pages/home.vue' /* webpackChunkName: "pages/home" */))
const _181fd5f6 = () => interopDefault(import('../pages/login.vue' /* webpackChunkName: "pages/login" */))
const _68d5c1d1 = () => interopDefault(import('../pages/user/index.vue' /* webpackChunkName: "pages/user/index" */))
const _eb58ac06 = () => interopDefault(import('../pages/userPage.vue' /* webpackChunkName: "pages/userPage" */))
const _d83be5d6 = () => interopDefault(import('../pages/users.vue' /* webpackChunkName: "pages/users" */))
const _e30adcae = () => interopDefault(import('../pages/user/_user.vue' /* webpackChunkName: "pages/user/_user" */))
const _4e7832df = () => interopDefault(import('../pages/index.vue' /* webpackChunkName: "pages/index" */))

Vue.use(Router)

export const routerOptions = {
  mode: 'history',
  base: decodeURI('/'),
  linkActiveClass: 'nuxt-link-active',
  linkExactActiveClass: 'nuxt-link-exact-active',
  scrollBehavior,

  routes: [{
    path: "/editor",
    component: _0c3d58a0,
    name: "editor"
  }, {
    path: "/home",
    component: _291aace2,
    name: "home"
  }, {
    path: "/login",
    component: _181fd5f6,
    name: "login"
  }, {
    path: "/user",
    component: _68d5c1d1,
    name: "user"
  }, {
    path: "/userPage",
    component: _eb58ac06,
    name: "userPage"
  }, {
    path: "/users",
    component: _d83be5d6,
    name: "users"
  }, {
    path: "/user/:user",
    component: _e30adcae,
    name: "user-user"
  }, {
    path: "/",
    component: _4e7832df,
    name: "index"
  }],

  fallback: false
}

export function createRouter () {
  return new Router(routerOptions)
}
