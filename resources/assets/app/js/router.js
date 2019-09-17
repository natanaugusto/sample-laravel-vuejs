import Vue from 'vue'
import VueRouter from 'vue-router'

import Login from './components/Login.vue';
import Wellcome from './components/Wellcome.vue';
import Authenticator from './objects/authenticator'
import Product from './components/Products/index';
import ProductList from './components/Products/list';
import ProductForm from './components/Products/form';
import ProductView from './components/Products/view';

Vue.use(VueRouter)

const router = new VueRouter({
  routes: [
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta: {
        guest: true
      }
    },
    {
      path: '/',
      name: 'wellcome',
      component: Wellcome,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/products',
      name: 'products',
      component: Product,
      children: [
        {
          name: 'list',
          path: '',
          component: ProductList
        },
        {
          name: 'create',
          path: 'create',
          component: ProductForm
        },
        {
          name: 'edit',
          path: 'edit/:id',
          component: ProductForm
        },
        {
          name: 'view',
          path: 'view/:id',
          component: ProductView
        }
      ],
      meta: {
        requiresAuth: true
      }
    },
  ]
})

router.beforeEach((to, from, next) => {
  Authenticator.validateRouterAccess(to, next)
})

export default router
