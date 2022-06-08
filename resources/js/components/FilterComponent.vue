<template>
  <div>
    <div class="search">
      <form class="form-inline my-2 my-lg-0" @submit.prevent="searchProduct">
        <input
          class="form-control mr-sm-2"
          type="search"
          placeholder="Search..."
          aria-label="Search"
          v-model="search"
          size="19"
        />
        <button class="btn btn-secondary btn-sm" type="submit" title="Click to search" size="2">O</button>
      </form>
    </div>

    <div class="filter mt-4">
      <div class="card">
        <div class="card-header">Author</div>
        <div class="card-body">
          <p class="card-text" v-for="user in users" v-bind:key="user.id">
            <input
              type="checkbox"
              :value="user.id"
              @click="(e) => filterUser(user.id, e)"
            />
            {{ user.name }}
          </p>
        </div>
      </div>
      <div class="card">
        <div class="card-header">Price</div>
        <div class="card-body">
          <p class="card-text" v-for="price in prices" :key="price.id">
            <input
              type="checkbox"
              :value="price.id"
              @click="(e) => filterPrice(price.id, e)"
            />
            {{ price.amount }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {getRequest} from "../helpers/ApiHelper";
export default {
  name: "Filter",
  data() {
    return {
      search: "",
      users: [],
      getFilter: [],
      getPriceFilter: [],
      prices: [
        { id: 1, amount: "Less than 100" },
        { id: 2, amount: "From 100 to 500" },
        { id: 3, amount: "From 500 to 1000" },
        { id: 4, amount: "More than 1000" },
      ],
    };
  },
  created() {
    if (localStorage.getItem("token")) {
      this.getUsers();
    } else {
      this.$router.push("/login");
    }
  },
  methods: {
    searchProduct() {
      this.$emit("searchFilter", this.search);
    },

    getUsers() {
       getRequest("/api/user/filter").then((response) => {
        this.users = response.data;
      });
    },

    filterUser(param, event) {
      if (event.target.checked) {
        this.getFilter.push(param);
      } else {
        this.getFilter.filter((data, index) => {
          if (data === param) {
            this.getFilter.splice(index, 1);
          }
        });
      }
      // console.log(this.getFilter);
      this.$emit("userFilter", this.getFilter);
    },

    filterPrice(param, event) {
      if (event.target.checked) {
        this.getPriceFilter.push(param);
      } else {
        this.getPriceFilter.filter((data, index) => {
          if (data === param) {
            this.getPriceFilter.splice(index, 1);
          }
        });
      }
      // console.log(this.getPriceFilter);
      this.$emit("priceFilter", this.getPriceFilter);
    },
  },
};
</script>

