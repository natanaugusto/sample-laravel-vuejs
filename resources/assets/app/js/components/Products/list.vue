<template>
  <section class="col-md-12 text-center justify-content-center">
    <div class="card col-md-12">
      <b-form @submit.prevent="() => false" @keyup="searchByName">
        <b-form-group
          id="group-search"
          label="Search"
          label-for="input-search"
        >
          <b-form-input
            id="input-search"
            v-model="inputs.search"
            required
            placeholder="Search by the product name"
          />
        </b-form-group>
      </b-form>
    </div>
    <div class="card col-md-12">
      <div id="products">
        <b-table
          id="products-table"
          :fields="fields"
          :items="products"
          striped
          bordered
        >
          <template slot="[actions]" slot-scope="data">
            <router-link :to="{ path: `products/view/${data.item.id}`}">
              <font-awesome-icon fas icon="eye" />
            </router-link>
            <router-link :to="{ path: `products/edit/${data.item.id}`}">
              <font-awesome-icon fas icon="edit" />
            </router-link>
            <a @click.prevent="deleteItem(data.item.id)">
              <font-awesome-icon fas icon="trash" />
            </a>
          </template>
        </b-table>
        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          aria-controls="products-table"
          @change="pageChange"
        />
      </div>
    </div>
  </section>
</template>

<style lang="scss" scoped>
a {
  text-decoration: none;
  color: inherit;
  cursor: pointer;
}
</style>

<script>
import { mapGetters, mapActions } from 'vuex'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faEdit, faEye, faTrash } from '@fortawesome/free-solid-svg-icons'
library.add(faEdit, faEye, faTrash)

export default {
  name: 'ProductList',
  data() {
    return {
      inputs: {
        search: null
      },
      fields: [
        'id',
        'name',
        'category',
        'price',
        { key: 'actions', label: 'Actions' }
      ],
      currentPage: 1
    }
  },
  computed: {
    ...mapGetters([
      'products',
      'totalRows',
      'perPage'
    ]),
  },
  methods: {
    ...mapActions([
      'loadProducts',
      'deleteProduct',
      'productsSearchByName'
    ]),
    searchByName() {
      this.productsSearchByName(this.inputs.search)
    },
    load(page) {
      this.loadProducts(page)
    },
    deleteItem(id) {
      this.deleteProduct(id)
        .then(res => {
          this.loadProducts(this.currentPage)
        })
    },
    pageChange(page) {
      this.loadProducts(page)
    }
  },
  mounted() {
    this.currentPage = !!this.$route.params.page ? this.$route.params.page : 1
    this.loadProducts(this.currentPage)
  }
}
</script>
