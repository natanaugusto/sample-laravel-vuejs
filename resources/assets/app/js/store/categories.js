const categories = {
  state: {
    categories: {}
  },
  actions: {
    loadCategories({ state }) {
      return axios.get('/api/categories')
        .then(res => {
          if(res.status === 200) {
            state.categories = res.data
          }
        })
        .catch(err => {
          throw err.response
        })
    }
  },
  getters: {
    categories: state => state.categories
  }
}

export default categories
