<template>
  <div class="row mt-5">
    <div class="col-md-3">
      <FilterComponent
        v-on:searchFilter="search($event)"
        v-on:userFilter="filterUser($event)"
        v-on:priceFilter="filterPrice($event)"
      />
    </div>

    <div class="col-md-9">
      <span v-if="!isLoading">
        <div class="row">
          <div
            class="col-md-4 mb-5"
            v-for="product in products"
            v-bind:key="product.id"
          >
            <div class="card">
              <img :src="product.image" alt="" />
              <div class="card-body text-center">
                <h5 class="card-title">{{ product.name }}</h5>
                <p class="card-text">
                  {{ product.description.substring(0, 45) + "...." }}
                </p>
              </div>

              <div class="card-body">${{ product.price }}</div>
            </div>
          </div>
        </div>
        <nav
          aria-label="Page navigation example"
          class="mt-4 mx-auto"
          style="width: 400px"
          v-if="pagination.total>0"
        >
          <ul class="pagination">
            <li
              v-bind:class="[
                { 'page-item': true },
                { disabled: !pagination.prev_page_url },
              ]"
            >
              <a
                class="page-link"
                role="button"
                v-if="isSearch && isSort && isSortPrice"
                @click="searchPricePagination(pagination.prev_page_url)"
                >Previous</a
              >
              <a
                class="page-link"
                role="button"
                v-else-if="isSort && isSortPrice"
                @click="searchPricePagination(pagination.prev_page_url)"
                >Previous</a
              >
              <a
                class="page-link"
                role="button"
                v-else-if="isSearch && isSort"
                @click="searchSortPagination(pagination.prev_page_url)"
                >Previous</a
              >
              <a
                class="page-link"
                role="button"
                v-else-if="isSearch && isSortPrice"
                @click="searchPricePagination(pagination.prev_page_url)"
                >Previous</a
              >
              <a
                class="page-link"
                role="button"
                v-else-if="isSearch"
                @click="searchPagination(pagination.prev_page_url)"
                >Previous</a
              >
              <a
                class="page-link"
                role="button"
                v-else-if="isSort"
                @click="sortPagination(pagination.prev_page_url)"
                >Previous</a
              >
              <a
                class="page-link"
                role="button"
                v-else-if="isSortPrice"
                @click="searchPricePagination(pagination.prev_page_url)"
                >Previous</a
              >
              <a
                class="page-link"
                role="button"
                v-else
                @click="fetchProducts(pagination.prev_page_url)"
                >Previous</a
              >
            </li>
            <li class="page-item disabled">
              <a class="page-link text-dark"
                >Page {{ pagination.current_page }} of
                {{ pagination.last_page }}</a
              >
            </li>
            <li
              v-bind:class="[
                { 'page-item': true },
                { disabled: !pagination.next_page_url },
              ]"
            >
              <a
                class="page-link"
                role="button"
                v-if="isSearch && isSort && isSortPrice"
                @click="searchPricePagination(pagination.next_page_url)"
                >Next</a
              >
              <a
                class="page-link"
                role="button"
                v-else-if="isSort && isSortPrice"
                @click="searchPricePagination(pagination.next_page_url)"
                >Next</a
              >
              <a
                class="page-link"
                role="button"
                v-else-if="isSearch && isSort"
                @click="searchSortPagination(pagination.next_page_url)"
                >Next</a
              >
              <a
                class="page-link"
                role="button"
                v-else-if="isSearch && isSortPrice"
                @click="searchPricePagination(pagination.next_page_url)"
                >Next</a
              >
              <a
                class="page-link"
                role="button"
                v-else-if="isSearch"
                @click="searchPagination(pagination.next_page_url)"
                >Next</a
              >
              <a
                class="page-link"
                role="button"
                v-else-if="isSort"
                @click="sortPagination(pagination.next_page_url)"
                >Next</a
              >
              <a
                class="page-link"
                role="button"
                v-else-if="isSortPrice"
                @click="searchPricePagination(pagination.next_page_url)"
                >Next</a
              >
              <a
                class="page-link"
                role="button"
                v-else
                @click="fetchProducts(pagination.next_page_url)"
                >Next</a
              >
            </li>
          </ul>
        </nav>
        <div class="container bg-secondary" style="height: 100px" v-else>
            <p class="text-center text-white pt-4">Currently no data available!</p>
        </div>
      </span>
      <span v-else>
        <div class="container mt-5 pt-5">
          <p class="text-center font-weight-bold mt-5">Loading....</p>
        </div>
      </span>
    </div>
  </div>
</template>

<script>
import {getRequest} from "../helpers/ApiHelper";
import FilterComponent from "../components/FilterComponent.vue";
export default {
  components: {
    FilterComponent,
  },
  data() {
    return {
      products: [],
      pagination: {},
      isSearch: false,
      isSort: false,
      isSortPrice: false,
      searchValue: "",
      sortValue: "",
      sortPrice: "",
      page: null,
      token: null,
      isLoading: false,
    };
  },

  created() {
    if (localStorage.getItem("token")) {
      this.token = localStorage.getItem("token");
      this.fetchProducts();
    } else {
      this.$router.push("/login");
    }
  },

  methods: {
    // Search
    search(param) {
      const url = "/api/product?search=" + param;
      this.searchValue = param;
      this.isSearch = true;
      if ((this.isSort && this.isSortPrice) || this.isSortPrice) {
        this.searchPriceFilter();
      } else if (this.isSort) {
        this.searchSortFilter();
      } else {
        this.isLoading = true;
        getRequest(url).then((response) => {
            this.products = response.data;
            this.page = response.next_page_url;
            this.isLoading = false;
            console.log(response);
            this.makePagination(
              response.current_page,
              response.last_page,
              response.next_page_url,
              response.prev_page_url,
              response.total
            );
          });
      }
    },

    // Search Pagination
    searchPagination(param) {
      const url = param + "&search=" + this.searchValue;
      this.isLoading = true;
      getRequest(url).then((response) => {
          this.products = response.data;
          this.page = response.next_page_url;
          this.isLoading = false;
          this.makePagination(
            response.current_page,
            response.last_page,
            response.next_page_url,
            response.prev_page_url,
            response.total
          );
        });
    },

    // Default Pagination
    fetchProducts(page_url) {
      page_url = page_url || "/api/product";
      this.isLoading = true;
      getRequest(page_url).then((response) => {
          this.products = response.data;
          this.isLoading = false;
          this.makePagination(
            response.current_page,
            response.last_page,
            response.next_page_url,
            response.prev_page_url,
            response.total
          );
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // Filter
    filterUser(param) {
      if (param.length > 0) {
        this.sortValue = JSON.stringify(param);
        this.isSort = true;
        if ((this.isSearch && this.isSortPrice) || this.isSortPrice) {
          this.searchPriceFilter();
        } else if (this.isSearch) {
          this.searchSortFilter();
        } else {
          this.isLoading = true;
          getRequest("/api/filter?sort=" + this.sortValue).then((response) => {
              this.products = response.data;
              this.isLoading = false;
              this.makePagination(
                response.current_page,
                response.last_page,
                response.next_page_url,
                response.prev_page_url,
                response.total
              );
            });
        }
      } else {
        this.sortValue = "";
        this.isSort = false;
        if ((this.isSearch && this.isSortPrice) || this.isSortPrice) {
          this.searchPriceFilter();
        } else if (this.isSearch) {
          this.search(this.searchValue);
        } else {
          this.isLoading = true;
          getRequest("/api/filter?sort=" + this.sortValue).then((response) => {
              this.products = response.data;
              this.isLoading = false;
              this.makePagination(
                response.current_page,
                response.last_page,
                response.next_page_url,
                response.prev_page_url,
                response.total
              );
            });
        }
      }
    },

    // Sort Pagination
    sortPagination(param) {
      const url = param + "&sort=" + this.sortValue;
      this.isLoading = true;
      getRequest(url).then((response) => {
          this.products = response.data;
          this.isLoading = false;
          this.page = response.next_page_url;
          this.makePagination(
            response.current_page,
            response.last_page,
            response.next_page_url,
            response.prev_page_url,
            response.total
          );
        });
    },

    // SearchSort Filter
    searchSortFilter() {
      this.isLoading = true;
      this.searchValue
        ? getRequest("/api/search-filter?sort=" +
                this.sortValue +
                "&search=" +
                this.searchValue).then((response) => {
              this.isLoading = false;
              this.products = response.data;
              this.page = response.next_page_url;
              this.makePagination(
                response.current_page,
                response.last_page,
                response.next_page_url,
                response.prev_page_url,
                response.total
              );
            })
        : this.sortFilter();
    },

    searchSortPagination(param) {
      const url = param + "&sort=" + this.sortValue + "&search=" + this.searchValue;
      this.isLoading = true;
      getRequest(url).then((response) => {
          this.products = response.data;
          this.isLoading = false;
          this.page = response.next_page_url;
          this.makePagination(
            response.current_page,
            response.last_page,
            response.next_page_url,
            response.prev_page_url,
            response.total
          );
        });
    },

    sortFilter() {
      getRequest("/api/filter?sort=" + this.sortValue).then((response) => {
          this.isLoading = false;
          this.products = response.data;
          this.makePagination(
            response.current_page,
            response.last_page,
            response.next_page_url,
            response.prev_page_url,
            response.total
          );
        });
    },

    // Price Filter
    filterPrice(param) {
      if (param.length > 0) {
        this.sortPrice = JSON.stringify(param);
        this.isSortPrice = true;
        this.isLoading = true;
        getRequest("/api/search-filter-price?sort=" +
              this.sortPrice +
              "&search=" +
              this.searchValue +
              "&user=" +
              this.sortValue).then((response) => {
            this.products = response.data;
            this.isLoading = false;
            this.makePagination(
              response.current_page,
              response.last_page,
              response.next_page_url,
              response.prev_page_url,
              response.total
            );
          });
      } else {
        this.sortPrice = "";
        this.isSortPrice = false;
        this.isLoading = true;
        this.isSearch
          ? this.search(this.searchValue)
          : getRequest("/api/search-filter-price?sort=" +
                  this.sortPrice +
                  "&user=" +
                  this.sortValue).then((response) => {
                this.products = response.data;
                this.isLoading = false;
                this.makePagination(
                  response.current_page,
                  response.last_page,
                  response.next_page_url,
                  response.prev_page_url,
                  response.total
                );
              });
      }
    },

    searchPriceFilter() {
      this.isLoading = true;
      getRequest("/api/search-filter-price?sort=" +
            this.sortPrice +
            "&search=" +
            this.searchValue +
            "&user=" +
            this.sortValue).then((response) => {
          this.products = response.data;
          this.isLoading = false;
          this.page = response.next_page_url;
          this.makePagination(
            response.current_page,
            response.last_page,
            response.next_page_url,
            response.prev_page_url,
            response.total
          );
        });
    },

    searchPricePagination(param) {
      const url =
        param +
        "&sort=" +
        this.sortPrice +
        "&search=" +
        this.searchValue +
        "&user=" +
        this.sortValue;
        this.isLoading = true;
        getRequest(url).then((response) => {
          this.products = response.data;
          this.isLoading = false;
          this.page = response.next_page_url;
          this.makePagination(
            response.current_page,
            response.last_page,
            response.next_page_url,
            response.prev_page_url,
            response.total
          );
        });
    },

    // Pagination Data
    makePagination(current_page, last_page, next_page_url, prev_page_url,total) {
      let pagination = {
        current_page: current_page,
        last_page: last_page,
        next_page_url: next_page_url,
        prev_page_url: prev_page_url,
        total: total
      };
      this.pagination = pagination;
    },
  },
};
</script>