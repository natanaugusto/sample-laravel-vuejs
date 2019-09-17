import store from '../store'

/**
 * Object to manipulate authentication
 */
const Authenticator = {
  /**
   * Token do usuário autenticado
   */
  token: null,
  /**
   * Load the user token
   */
  loadToken() {
    try {
      this.token = store.state.user.oauth.access_token
      if(!this.token) {
        this.token = false
      } else {
        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token
      }
    } catch (err) {
      this.token = false
      setTimeout(this.loadToken, 5000)
    }
  },
  /**
   * Validate a route
   * @param {object} to
   * @param {object} next
   */
  validateRouterAccess(to, next) {
    this.loadToken()
    if(this.requiresAuth(to, next) === true) {
      return next()
    } else {
      this.isGuestAccess(to, next)
    }
  },
  /**
   * Verify if the route need authentication
   *
   * @param {object} to
   * @param {object} next
   */
  requiresAuth(to, next) {
    if(to.matched.some(record => record.meta.requiresAuth)) {
      if(this.token === false) {
        return next({
            name: 'login',
            params: { nextUrl: to.fullPath }
        })
      } else {
        return true
      }
    }
  },
  /**
   * Validate if is a guest route
   * @param {object} to
   * @param {object} next
   */
  isGuestAccess(to, next) {
    if(to.matched.some(record => record.meta.guest)) {
      if(this.token === false) {
          return next()
      } else {
          return next({name: 'wellcome'})
      }
    } else {
      return next()
    }
  }
}

export default Authenticator
