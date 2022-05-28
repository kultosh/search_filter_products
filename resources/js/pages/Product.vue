<template>
  <div class="row mt-5">
     <div class="col-md-3">
        <FilterComponent v-on:searchFilter="search($event)" v-on:userFilter="filterUser($event)" />
     </div>

     <div class="col-md-9">
        <div class="row">
          <div class="col-md-4 mb-5" v-for="product in products" v-bind:key="product.id">
            <div class="card">
              <img :src="product.image" alt="">
              <div class="card-body text-center">
                <h5 class="card-title">{{product.name}}</h5>
                <p class="card-text">{{product.description.substring(0,45)+'....'}}</p>
              </div>
              
              <div class="card-body">${{product.price}}</div>
            </div>
          </div>
        </div>
        <nav aria-label="Page navigation example" class="mt-4 mx-auto" style="width: 400px;">
          <ul class="pagination">
            <li v-bind:class="[{'page-item': true}, {disabled: !pagination.prev_page_url}]">
              <a class="page-link" role="button" v-if="isSearch && isSort" @click="searchSortPagination(pagination.prev_page_url)">Previous</a>
              <a class="page-link" role="button" v-else-if="isSearch" @click="searchPagination(pagination.prev_page_url)">Previous</a>
              <a class="page-link" role="button" v-else-if="isSort" @click="sortPagination(pagination.prev_page_url)">Previous</a>
              <a class="page-link" role="button" v-else @click="fetchProducts(pagination.prev_page_url)">Previous</a>
            </li>
            <li class="page-item disabled">
              <a
                class="page-link text-dark"
              >Page {{pagination.current_page}} of {{pagination.last_page}}</a>
            </li>
            <li v-bind:class="[{'page-item': true}, {disabled: !pagination.next_page_url}]">
              <!-- <a class="page-link" role="button" @click="isSearch ? searchPagination(pagination.next_page_url) :fetchProducts(pagination.next_page_url)">Next</a> -->
              <a class="page-link" role="button" v-if="isSearch && isSort" @click="searchSortPagination(pagination.next_page_url)">Next</a>
              <a class="page-link" role="button" v-else-if="isSearch" @click="searchPagination(pagination.next_page_url)">Next</a>
              <a class="page-link" role="button" v-else-if="isSort" @click="sortPagination(pagination.next_page_url)">Next</a>
              <a class="page-link" role="button" v-else @click="fetchProducts(pagination.next_page_url)">Next</a>
            </li>
          </ul>
        </nav>
     </div>
   </div>
</template>

<script>
import FilterComponent from '../components/FilterComponent.vue'
export default {
    components: {
      FilterComponent
    },
    data() {
      return {
        products: [],
        pagination: {},
        isSearch: false,
        isSort: false,
        searchValue: "",
        sortValue: "",
        page: null,
      };
    },

    created() {
      this.fetchProducts()
    },

    methods: {
      // Search
      search(param) {
        const url = '/api/product?search='+param;
        this.searchValue = param;
        this.isSearch = true;
        this.isSort ? this.searchSortFilter() :
        axios.get(url)
        .then((response) => {
          this.products = response.data.data;
          this.page = response.data.next_page_url
          this.makePagination(response.data.current_page, response.data.last_page, response.data.next_page_url, response.data.prev_page_url);
        });
      },

      // Search Pagination
      searchPagination(param) {
        console.log(param);
        const url = param+'&search='+this.searchValue;
        axios.get(url)
        .then((response) => {
          this.products = response.data.data;
          this.page = response.data.next_page_url
          this.makePagination(response.data.current_page, response.data.last_page, response.data.next_page_url, response.data.prev_page_url);
        });
      },

      // Default Pagination
      fetchProducts(page_url) {
        page_url = page_url || '/api/product';
        axios.get(page_url)
        .then((response) => {
          console.log(response.data.data);
          this.products = response.data.data;
          this.makePagination(response.data.current_page, response.data.last_page, response.data.next_page_url, response.data.prev_page_url);
        })
        .catch(error => {
          console.log(error);
        })
      },

      // Filter 
      filterUser(param) {
        if(param.length > 0)
        {
          this.sortValue = JSON.stringify(param);
          this.isSort = true;
          this.isSearch ? this.searchSortFilter() :
          axios.get('/api/filter?sort='+this.sortValue)
            .then((response) => {
              console.log(response.data);
              this.products = response.data.data;
              this.makePagination(response.data.current_page, response.data.last_page, response.data.next_page_url, response.data.prev_page_url);
            })
        }
        else
        {
          this.sortValue = "";
          this.isSort = false;
          // this.isSearch = false;
          this.isSearch ? this.search(this.searchValue) : 
          axios.get('/api/filter?sort='+this.sortValue)
            .then((response) => {
              console.log(response.data);
              this.products = response.data.data;
              this.makePagination(response.data.current_page, response.data.last_page, response.data.next_page_url, response.data.prev_page_url);
            })
        }
      },

      // Sort Pagination
      sortPagination(param) {
        console.log(param);
        const url = param+'&sort='+this.sortValue;
        axios.get(url)
        .then((response) => {
          this.products = response.data.data;
          this.page = response.data.next_page_url
          this.makePagination(response.data.current_page, response.data.last_page, response.data.next_page_url, response.data.prev_page_url);
        });
      },

      // SearchSort Filter
      searchSortFilter() {
        this.searchValue ? axios.get('/api/search-filter?sort='+this.sortValue+'&search='+this.searchValue)
        .then((response) => {
          console.log(response.data.data);
          this.products = response.data.data;
          this.page = response.data.next_page_url
          this.makePagination(response.data.current_page, response.data.last_page, response.data.next_page_url, response.data.prev_page_url);
        }) : this.sortFilter();
      },

      searchSortPagination(param) {
        console.log(param);
        const url = param+'&sort='+this.sortValue+'&search='+this.searchValue;
        axios.get(url)
        .then((response) => {
          this.products = response.data.data;
          this.page = response.data.next_page_url
          this.makePagination(response.data.current_page, response.data.last_page, response.data.next_page_url, response.data.prev_page_url);
        })
      },

      sortFilter() {
        axios.get('/api/filter?sort='+this.sortValue)
        .then((response) => {
          console.log(response.data);
          this.products = response.data.data;
          this.makePagination(response.data.current_page, response.data.last_page, response.data.next_page_url, response.data.prev_page_url);
        })
      },

      // Pagination Data
      makePagination(current_page, last_page, next_page_url, prev_page_url) {
        let pagination = {
          current_page: current_page,
          last_page: last_page,
          next_page_url: next_page_url,
          prev_page_url: prev_page_url,
        };
        this.pagination = pagination;
      },
    }
}
</script>