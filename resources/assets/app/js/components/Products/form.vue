<template>
  <b-form @submit="onSubmit">
    <div class="row">
      <div class="col-md-6">
        <b-form-group
          id="group-name"
          label="Name"
          label-for="input-name"
        >
          <b-form-input
            id="input-name"
            v-model="inputs.name"
            required
            placeholder="The product name"
          />
        </b-form-group>
        <b-form-group
          id="group-category_id"
          label="Category"
          label-for="input-category_id"
        >
          <b-form-select v-model="inputs.category_id" :options="categories" />
        </b-form-group>
      </div>
      <div class="col-md-6">
        <b-form-group
          id="group-price"
          label="Price"
          label-for="input-price"
        >
          <b-form-input
            id="input-price"
            v-model.lazy="inputs.price"
            v-money="money"
            required
            placeholder="The product Price"
          />
        </b-form-group>
      </div>
      <div class="col-md-12">
        <b-form-group
          id="group-description"
          label="Description"
          label-for="input-description"
        >
          <div class="row"></div>
          <Vueditor
            id="input-description"
            v-model="inputs.description"
            class="form-control"
          />
        </b-form-group>
      </div>
    </div>
    <b-button variant="success" type="submit">Submit</b-button>
  </b-form>
</template>

<script>
import Vue from 'vue'
import { mapActions } from 'vuex'
import { VMoney } from 'v-money'
import Vueditor from 'vueditor'
import money from '../../configs/money'
import editor from '../../configs/editor'

import 'vueditor/dist/style/vueditor.min.css'

Vue.use(Vueditor, editor)

export default {
  name: 'ProductForm',
  data() {
    return {
      inputs: {
        name: null,
        description: null,
        category_id: null,
        price: null
      },
      money
    }
  },
  computed: {
    categories() {
      const categories = []
      const getterCategories = this.$store.getters.categories
      Object.keys(getterCategories).forEach(key => {
        categories[key] = {
          value: getterCategories[key].id,
          text: getterCategories[key].name
        }
      })
      return categories
    }
  },
  methods: {
    ...mapActions([
      'loadCategories'
    ]),
    onSubmit() {
      return true
    }
  },
  mounted() {
    this.loadCategories()
  },
  directives: {
    money: VMoney
  }
}
</script>
