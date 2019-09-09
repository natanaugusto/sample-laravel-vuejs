<template>
  <section class="col-md-12 text-center justify-content-center">
    <div class="card col-md-12">
      <div class="row">
        <div class="col-md-6">
          <div class="row">
            <label>Name</label>
            <div>{{ product.name }}</div>
          </div>
          <div class="row">
            <label>Category</label>
            <div>{{ product.category_name }}</div>
          </div>
          <div class="row">
            <label>Price</label>
            <div>{{ product.price }}</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <label>Description</label>
            <div>{{ product.description }}</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style lang="scss" scoped>
label {
  font-weight: bold;
  margin-right: 0.4em;

  &:after {
    content: ':';
  }
}
</style>

<script>
import { mapActions } from 'vuex'
import FormatMoney from '../../objects/format_money'

export default {
  name: 'ProductView',
  data() {
    return {
      product: null
    }
  },
  methods: {
    ...mapActions([
      'productByID'
    ])
  },
  mounted() {
    if(!this.$route.params.id) {
      this.$route.push({ path: '/products' })
    }
    this.productByID(this.$route.params.id)
      .then(product => {
        this.product = product
        this.product.price = FormatMoney.toString(this.product.price)
      })
  }
}
</script>
