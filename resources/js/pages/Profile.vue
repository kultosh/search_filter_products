<template>
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-8">
                <h4 class="bg-light p-4 text-center">My Products</h4>
                <div class="p-2">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">S.No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Image</th>
                            </tr>
                        </thead>
                        <tbody v-if="!isLoading">
                            <tr v-for="(product,index) in products" :key="product.id">
                                <th scope="row" class="align-middle">{{(pagination.current_page*pagination.per_page)-pagination.per_page + index+1}}</th>
                                <td class="align-middle">{{product.name}}</td>
                                <td class="align-middle">{{product.price}}</td>
                                <td><img :src="product.image" alt="" height="50" /></td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr><td colspan="4" class="text-center">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
                 <nav aria-label="Page navigation example" class="mt-4 mx-auto" style="width: 400px;">
                    <ul class="pagination">
                        <li v-bind:class="[{'page-item': true}, {disabled: !pagination.prev_page_url}]">
                        <a class="page-link" role="button" @click="getPagination(pagination.prev_page_url)">Previous</a>
                        </li>
                        <li class="page-item disabled">
                        <a
                            class="page-link text-dark"
                        >Page {{pagination.current_page}} of {{pagination.last_page}}</a>
                        </li>
                        <li v-bind:class="[{'page-item': true}, {disabled: !pagination.next_page_url}]">
                        <a class="page-link" role="button" @click="getPagination(pagination.next_page_url)">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-md-4">
                <h4 class="bg-light p-4 text-left">Info</h4>
                <div class="border p-3 mt-3">
                    <p>Name: {{user.name}}</p>
                    <p>Email: {{user.email}}</p>
                    <p>Total Products: {{user.total_products}}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {getRequest} from "../helpers/ApiHelper";
    export default ({
        data() {
            return {
                user: {},
                products: [],
                pagination: {},
                isLoading: false
            }
        },

        created() {
            const token = localStorage.getItem("token");
            this.isLoading = true;
            token ? getRequest("/api/profile").then((response) => {
              this.user = response.user;
              this.products = response.products.data;
              this.isLoading = false;
              this.makePagination(
                response.products.current_page,
                response.products.last_page,
                response.products.next_page_url,
                response.products.prev_page_url,
                response.products.per_page
              );
            }) : this.$router.push("/login");
        },

        methods: {
            getPagination(param) {
                const token = localStorage.getItem("token");
                const url = param.split("?");
                this.isLoading = true;
                getRequest('/api/pagination?'+url[1]).then((response) => {
                    this.products = response.data;
                    this.isLoading = false;
                    this.makePagination(
                        response.current_page,
                        response.last_page,
                        response.next_page_url,
                        response.prev_page_url,
                        response.per_page
                    );
                })  
            },

            // Pagination Data
            makePagination(current_page, last_page, next_page_url, prev_page_url, per_page) {
                let pagination = {
                    current_page: current_page,
                    last_page: last_page,
                    next_page_url: next_page_url,
                    prev_page_url: prev_page_url,
                    per_page: per_page
                };
                this.pagination = pagination;
            },
        }
    })
</script>
