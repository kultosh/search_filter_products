<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-4 mb-5" v-for="product in products" v-bind:key="product.id">
        <div class="card">
          <img :src="product.image" alt="">
          <div class="card-body text-center">
            <h5 class="card-title">{{product.name}}</h5>
            <!-- <p class="card-text">{{product.description.substring(0,100)+'....'}}</p> -->
          </div>
          
          <div class="card-body">${{product.price}}</div>
        </div>
      </div>
      <!-- <div class="col-md-4 mb-5">
        <div class="card">
          <img src="https://m.media-amazon.com/images/I/B1DBWbloIpS._CLa%7C2140%2C2000%7C61ug1HZspNL.png%7C0%2C0%2C2140%2C2000%2B0.0%2C0.0%2C2140.0%2C2000.0_AC_SX342._SX._UX._SY._UY_.png" alt="">
          <div class="card-body text-center">Progrmaing T-Shirt Gray </div>
          <div class="card-body">$19</div>
        </div>
      </div>
       <div class="col-md-4 mb-5">
        <div class="card">
          <img src="https://m.media-amazon.com/images/I/B1OGJ8t+8ZS._CLa%7C2140%2C2000%7C61ug1HZspNL.png%7C0%2C0%2C2140%2C2000%2B0.0%2C0.0%2C2140.0%2C2000.0_AC_SX342._SX._UX._SY._UY_.png" alt="">
          <div class="card-body text-center">Progrmaing T-Shirt Brown </div>
          <div class="card-body">$19</div>
        </div>
      </div>
       <div class="col-md-4 mb-5">
        <div class="card">
          <img src="https://m.media-amazon.com/images/I/B1F9XqluwtS._CLa%7C2140%2C2000%7C61ug1HZspNL.png%7C0%2C0%2C2140%2C2000%2B0.0%2C0.0%2C2140.0%2C2000.0_AC_SX342._SX._UX._SY._UY_.png" alt="">
          <div class="card-body text-center">Gold Sunflower</div>
          <div class="card-body">$19</div>
        </div>
      </div>
       <div class="col-md-4 mb-5">
        <div class="card">
          <img src="https://m.media-amazon.com/images/I/A13usaonutL._CLa%7C2140%2C2000%7C61ug1HZspNL.png%7C0%2C0%2C2140%2C2000%2B0.0%2C0.0%2C2140.0%2C2000.0_AC_SX342._SX._UX._SY._UY_.png" alt="">
          <div class="card-body text-center">Gold Sunflower</div>
          <div class="card-body">$19</div>
        </div>
      </div> -->
    </div>
    <nav aria-label="Page navigation example" class="mt-4 mx-auto" style="width: 400px;">
      <ul class="pagination">
        <li v-bind:class="[{'page-item': true}, {disabled: !pagination.prev_page_url}]">
          <a class="page-link" role="button" @click="fetchProducts(pagination.prev_page_url)">Previous</a>
        </li>
        <li class="page-item disabled">
          <a
            class="page-link text-dark"
          >Page {{pagination.current_page}} of {{pagination.last_page}}</a>
        </li>
        <li v-bind:class="[{'page-item': true}, {disabled: !pagination.next_page_url}]">
          <a class="page-link" role="button" @click="fetchProducts(pagination.next_page_url)">Next</a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
    data() {
      return {
        products: [],
        pagination: {},
      };
    },

    created() {
      this.fetchProducts()
    },

    methods: {
      fetchProducts(page_url) {
        page_url = page_url || "/api/product";
        axios.get(page_url)
        .then((response) => {
          console.log(response);
          this.products = response.data.products.data;
          this.makePagination(response.data.products.current_page, response.data.products.last_page, response.data.products.next_page_url, response.data.products.prev_page_url);
        })
        .catch(error => {
          console.log(error);
        })
      },

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