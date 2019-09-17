const auth = {
  state: {
    user: null
  },
  mutations: {
    /**
     * Set the authenticated user
     *
     * @param {object} state
     * @param {object} user
     */
    SET_USER(state, user) {
      state.user = user
    }
  },
  getters: {
    /**
     * Verify if exist a user authenticated setted
     *
     * @param {object} state
     */
    isAuthenticated(state) {
      return !!state.user
    }
  },
  actions: {
    /**
     * Attempt a user login on the API
     *
     * @param {object} param0
     * @param {object} user
     */
    login({ commit }, user) {
      return axios.post('/oauth/token', {
        username: user.username,
        password: user.password,
        grant_type: 'password',
        client_id: process.env.OAUTH_CLIENT_ID,
        client_secret: process.env.OAUTH_CLIENT_SECRET,
        scope: '*'
      })
      .then(res => {
        if(res.status === 200) {
          commit('SET_USER', res.data)
        }
        return res
      })
      .catch(err => {
        throw err.response
      })
    }
  }
}

export default auth
