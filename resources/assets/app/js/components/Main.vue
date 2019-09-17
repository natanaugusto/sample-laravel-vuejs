<template>
  <section id="app-main">
    <Nav :menus="menus" v-show="isAuthenticated">
      <template v-slot:logo>
        <Logo id="logo" src="/images/logo.png" width="100px" />
      </template>
    </Nav>
    <router-view></router-view>
  </section>
</template>

<script>
import Logo from './Logo'
import Nav from './Nav/index'
import { menus } from '../configs/menus'
import { mapGetters } from 'vuex'

export default {
  components: {
    Nav,
    Logo
  },
  data() {
    return {
        menus
    }
  },
  computed: {
    ...mapGetters([
      'isAuthenticated'
    ])
  }
}
</script>
