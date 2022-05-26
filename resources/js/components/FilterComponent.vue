<template>
    <div>
        <div class="search">
            <form class="form-inline my-2 my-lg-0" @submit.prevent="searchProduct">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" v-model="search">
                <button type="submit">S</button>
            </form>
        </div>

        <div class="filter mt-4">
           <div class="card">
                <div class="card-header">Author</div>
                <div class="card-body">
                    <p class="card-text">
                        <input type="checkbox"> User 1
                    </p>
                    <p class="card-text">
                        <input type="checkbox"> User 2
                    </p>
                    <p class="card-text">
                        <input type="checkbox"> User 1
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Price</div>
                <div class="card-body">
                    <p class="card-text">
                        <input type="checkbox"> $100
                    </p>
                    <p class="card-text">
                        <input type="checkbox"> $500
                    </p>
                    <p class="card-text">
                        <input type="checkbox"> $1000
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "Filter",
        data() {
            return {
                search: '',
            }
        },
        methods: {
            searchProduct() {
                this.$emit('searchFilter', this.search);
            }
        }
    }

</script>

