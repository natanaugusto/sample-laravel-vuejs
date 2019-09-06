import FormatMoney from '../objects/format_money'

const products = {
  state: {
    productPaginator: {}
  },
  mutations: {
    /**
     * Set the product paginator
     *
     * @param {object} state
     * @param {object} productPaginator
     */
    SET_PRODUCT_PAGINATOR(state, productPaginator) {
      state.productPaginator = productPaginator
    }
  },
  actions: {
    /**
     * Load the products from API
     *
     * @param {object} param0
     * @param {object} page
     */
    loadProducts({ commit }, page) {
      return axios.get(`/api/products?page=${page}`)
        .then(res => {
          if(res.status === 200) {
            commit('SET_PRODUCT_PAGINATOR', res.data)
          }
          return res
        })
        .catch(err => {
          throw err.response
        })
    },
    /**
     * Create a product
     *
     * @param {*} param0
     * @param {object} product
     */
    createProduct({}, product) {
      product.price = FormatMoney.toFloat(product.price)
      return axios.post('/api/products', product)
        .then(res => {
          return res
        })
        .catch(err => {
          throw err.response
        })
    },
    /**
     * Delete a product
     *
     * @param {*} param0
     * @param {integer} id
     */
    deleteProduct({}, id) {
      return axios.delete(`/api/products/${id}`)
        .then(res => {
          return res
        })
        .catch(err => {
          throw err.response
        })
    },
    /**
     * Update a product
     *
     * @param {*} param0
     * @param {object} product
     */
    updateProduct({}, product) {
      product.price = FormatMoney.toFloat(product.price)
      return axios.put(`/api/products/${product.id}`, product)
        .then(res => {
          return res
        })
        .catch(err => {
          throw err.response
        })
    },
    /**
     * Get a product from API
     *
     * @param {*} param0
     * @param {integer} id
     */
    productByID({}, id) {
      return axios.get(`/api/products/${id}`)
        .then(res => {
          if(res.status === 200) {
            return res.data
          }
        })
        .catch(err => {
          throw err.response
        })
    }
  },
  getters: {
    /**
     * Get the products from @var state.productPaginator.data
     *
     * @param {object}
     */
    products: (state) =>  {
      const products = state.productPaginator.data
      if(!products) {
        return []
      }
      const retProducts = []
      Object.keys(products).forEach(key => {
        retProducts[key] = {
          id: products[key].id,
          name: products[key].name,
          category: products[key].category_name,
          price: FormatMoney.toString(products[key].price)
        }
      })
      return retProducts
    },
    /**
     * Get the current page from @var state.productPaginator.current_page
     *
     * @param {object}
     */
    currentPage: (state) => state.productPaginator.current_page,
    /**
     * Get the total rows from @var state.productPaginator.total
     *
     * @param {object}
     */
    totalRows: (state) => state.productPaginator.total,
    /**
     * Get the products per page from @var state.productPaginator.per_page
     *
     * @param {object}
     */
    perPage: (state) => state.productPaginator.per_page,
    /**
     * Get the products last page from @var state.productPaginator.last_page
     *
     * @param {object}
     */
    lastPage: (state) => state.productPaginator.last_page
  }
}

export default products
