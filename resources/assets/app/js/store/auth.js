import createPersistedState from 'vuex-persistedstate';

const auth = {
  state: {
    user: null
  },
  getters: {
    isAuthenticated(state) {
      return !!state.user
    }
  },
  actions: {
    login({ state }, user) {
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
          state.user = res.data
        }
        return res
      })
      .catch(err => {
        throw err.response
      })
    }
  },
  plugins: [ createPersistedState() ]
}

export default auth
