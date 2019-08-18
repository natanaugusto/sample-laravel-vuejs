import FormatMoney from '../objects/format_money'

const products = {
  state: {
    productPaginator: {}
  },
  actions: {
    loadProducts({ state }, page) {
      return axios.get('/api/products?page='+page)
        .then(res => {
          if(res.status === 200) {
            state.productPaginator = res.data
          }
        })
        .catch(err => {
          throw err.response
        })
    }
  },
  getters: {
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
    currentPage: (state) => state.productPaginator.current_page,
    totalRows: (state) => state.productPaginator.total,
    perPage: (state) => state.productPaginator.per_page,
    lastPage: (state) => state.productPaginator.last_page
  }
}

export default products
