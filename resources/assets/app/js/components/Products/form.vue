<template>
  <section class="col-md-12 text-center justify-content-center">
    <div class="card col-md-12">
      <b-form @submit.prevent="onSubmit">
        <div class="row">
          <div class="col-md-6">
            <b-form-group
              id="group-name"
              label="Name"
              label-for="input-name"
              :invalid-feedback="inputs.name.message"
            >
              <b-form-input
                id="input-name"
                v-model="inputs.name.value"
                required
                placeholder="The product name"
                :state="inputs.name.state"
              />
            </b-form-group>
            <b-form-group
              id="group-category_id"
              label="Category"
              label-for="input-category_id"
              :invalid-feedback="inputs.category_id.message"
            >
              <b-form-select
                v-model="inputs.category_id.value"
                :options="categories"
                :state="inputs.category_id.state"
              />
            </b-form-group>
          </div>
          <div class="col-md-6">
            <b-form-group
              id="group-price"
              label="Price"
              label-for="input-price"
              :invalid-feedback="inputs.price.message"
            >
              <b-form-input
                id="input-price"
                v-model.lazy="inputs.price.value"
                v-money="money"
                required
                placeholder="The product Price"
                :state="inputs.price.state"
              />
            </b-form-group>
          </div>
          <div class="col-md-12">
            <b-form-group
              id="group-description"
              label="Description"
              label-for="input-description"
              :invalid-feedback="inputs.description.message"
            >
              <div class="row"></div>
              <Vueditor id="input-description" ref="vueditor" class="form-control" />
            </b-form-group>
          </div>
        </div>
        <b-button variant="success" type="submit">Submit</b-button>
      </b-form>
    </div>
  </section>
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
        id: null,
        name: {
          state: null,
          message: null,
          value: null
        },
        description: {
          state: null,
          message: null,
          value: null
        },
        category_id: {
          state: null,
          message: null,
          value: null
        },
        price: {
          state: null,
          message: null,
          value: null
        }
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
      'loadCategories',
      'createProduct',
      'updateProduct',
      'productByID'
    ]),
    getValues() {
      const values = {}
      Object.keys(this.inputs).forEach(key => {
        if(key === 'id') {
          values[key] = this.inputs[key]
        } else {
          values[key] = this.inputs[key].value
        }
      })
      //Hack
      values.description = this.$refs['vueditor'].getContent()
      return values
    },
    handleReturn(promise) {
      promise.then(res => {
          if(res.status === 201) {
            this.$router.push({ path: '/products' })
          }
        })
        .catch(err => {
          if(err.status === 422) {
            Object.keys(err.data).forEach(key => {
              this.inputs[key].state = false
              this.inputs[key].message = err.data[key][0]
            })
          }
        })
    },
    onSubmit() {
      const values = this.getValues()
      if(values.id) {
        this.handleReturn(this.updateProduct(values))
      } else {
        this.handleReturn(this.createProduct(values))
      }
    }
  },
  mounted() {
    this.loadCategories()
    if(!!this.$route.params.id) {
      this.productByID(this.$route.params.id)
        .then(product => {
          this.inputs.id = product.id
          this.inputs.name.value = product.name
          this.$refs['vueditor'].setContent(product.description)
          this.inputs.category_id.value = product.category_id
          // Hack
          this.inputs.price.value = product.price.toFixed(2)
        })
    }
  },
  directives: {
    money: VMoney
  }
}
</script>
