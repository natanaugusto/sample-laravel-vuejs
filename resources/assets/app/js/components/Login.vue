<template>
<div class="container">
  <section class="container col-md-8 text-center justify-content-center">
    <Logo id="logo" src="/images/logo.png" width="200px" />
    <div class="card col-md-12 big-top">
      <h1>Login</h1>
      <b-form @submit.prevent="onSubmit">
        <div class="row">
          <div class="col-md-6">
            <b-input-group label="E-mail" label-for="username">
              <b-input-group-text slot="prepend">
                <font-awesome-icon fas icon="envelope" />
              </b-input-group-text>
              <b-input
                id="username"
                v-model="inputs.username"
                placeholder="E-mail de acesso"
                type="text"
              />
            </b-input-group>
          </div>
          <div class="col-md-6">
            <b-input-group label="Senha" label-for="password">
              <b-input
                id="password"
                v-model="inputs.password"
                placeholder="Senha"
                type="password"
              />
              <b-input-group-text slot="append">
                <font-awesome-icon fas icon="lock" />
              </b-input-group-text>
            </b-input-group>
          </div>
        </div>
        <div class="row justify-content-center">
          <b-button variant="success" size="lg" type="submit">Entrar</b-button>
        </div>
      </b-form>
    </div>
  </section>
</div>
</template>

<script>
import Logo from './Logo'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faLock, faEnvelope } from '@fortawesome/free-solid-svg-icons'
import { mapActions } from 'vuex'

library.add(faLock, faEnvelope)

export default {
  components: {
    Logo
  },
  data() {
    return {
      inputs: {
        username: null,
        password: null
      }
    }
  },
  methods: {
    ...mapActions([
      'login'
    ]),
    onSubmit() {
      this.login(this.inputs)
        .then(res => {
          return this.$router.push({ name: 'wellcome' })
        })
    }
  }
}
</script>

<style lang="scss" scoped>
@import 'node_modules/bootstrap/scss/functions';
@import 'node_modules/bootstrap/scss/variables';
@import 'node_modules/bootstrap/scss/mixins/_breakpoints';

section {
  margin-top: 8%;
}

.card .row input {
  width: auto;
}

@include media-breakpoint-down(sm) {
  #logo {
    width: 100px;
  }

  .col-md-6 {
    margin-bottom: 0.5em;
  }
}
</style>
