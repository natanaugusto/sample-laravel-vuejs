<template>
  <img
    :id="id"
    :src="src"
    :width="rWidth"
    :height="rHeight"
  />
</template>

<script>
export default {
  props: {
    id: {
      type: String,
      required: true
    },
    src: {
      type: String,
      required: true
    },
    width: {
      type: [String, Boolean],
      default: false,
      required: false
    },
    height: {
      type: [String, Boolean],
      default: false,
      required: false
    },
    percent: {
      type: [String, Boolean],
      default: false,
      required: false
    }
  },
  computed: {
    rWidth() {
      return !this.width ? this.rPercent() : this.width
    },
    rHeight() {
      return !this.height ? this.rPercent() : this.height
    }
  },
  methods: {
    rPercent() {
      return !this.percent ? '100%' : this.percent
    }
  }
}
</script>
