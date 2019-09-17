import createPersistedState from 'vuex-persistedstate';

const deepmerge = require('deepmerge')
const merge = (objs) => {
    if(objs.length < 2) {
        return objs[0]
    }

    let ret = deepmerge(objs[0], objs[1])
    if(objs.length > 2) {
        let len = objs.length - 1
        for(let i = 2; i <= len; i++) {
            ret = deepmerge(ret, objs[i])
        }
    }
    return ret
}

import Vue from 'vue'
import Vuex from 'vuex'
import auth from './auth'
import products from './products'
import categories from './categories'

Vue.use(Vuex)

const store = new Vuex.Store(
  merge([
    auth,
    products,
    categories,
    {
      plugins: [ createPersistedState() ]
    }
  ])
)
export default store
