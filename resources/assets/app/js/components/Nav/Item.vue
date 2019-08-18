<template>
  <b-navbar-nav>
    <template v-for="item in items">
      <b-nav-item
        v-if="!item.children"
        :id="item.id"
        :key="item.id"
        :href="item.link"
      >
        {{ item.text }}
      </b-nav-item>
      <b-nav-item-dropdown
        v-else
        :id="item.id"
        :key="item.id"
        :text="item.text"
      >
        <template v-for="child in item.children">
          <b-dropdown-item :id="child.id" :key="child.id" :href="child.link">
            {{ child.text }}
          </b-dropdown-item>
        </template>
      </b-nav-item-dropdown>
    </template>
  </b-navbar-nav>
</template>

<script>
export default {
  name: 'NavItem',
  props: {
    items: {
      type: Array,
      required: true
    }
  }
}
</script>
