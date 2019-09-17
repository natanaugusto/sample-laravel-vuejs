<template>
  <b-navbar toggleable="lg" type="dark" variant="main-menu">
    <b-navbar-brand>
      <slot name="logo" />
    </b-navbar-brand>
    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
    <b-collapse id="nav-collapse" is-nav>
      <nav-item :items="menus" />
      <nav-item
        v-show="menusRight.length === 0 ? false : true"
        class="right"
        :items="menusRight"
      />
    </b-collapse>
  </b-navbar>
</template>

<script>
import NavItem from './Item'

export default {
  name: 'Nav',
  components: {
    NavItem
  },
  props: {
    menus: {
      type: Array,
      required: true
    },
    menusRight: {
      type: Array,
      required: false,
      default: () => {
        return []
      }
    }
  }
}
</script>
