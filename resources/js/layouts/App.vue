<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <router-link :to="{ name: 'home' }" class="navbar-brand"
        >Kul Product</router-link
      >
      <button
        class="navbar-toggler"
        data-toggle="collapse"
        data-target="#navbarCollapse"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navbarCollapse" class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item" v-if="getToken">
            <router-link
              class="nav-link"
              data-toggle="collapse"
              :to="{ name: 'home' }"
            >
              Home
            </router-link>
          </li>

          <li class="nav-item" v-if="getToken">
            <router-link
              class="nav-link"
              data-toggle="collapse"
              :to="{ name: 'product' }"
            >
              Product
            </router-link>
          </li>

          <li class="nav-item" v-if="getToken">
            <router-link
              class="nav-link"
              data-toggle="collapse"
              :to="{ name: 'profile' }"
            >
              Profile
            </router-link>
          </li>
        </ul>
        <button class="btn btn-outline-danger my-2 my-sm-0" v-if="getToken" type="submit" @click="logOut">LogOut</button>
      </div>
    </nav>

    <div class="container">
      <router-view @getLoggedIn='loggedIn'></router-view>
    </div>
  </div>
</template>

<script>
export default {
  data() {
        return {
            getToken: false
        }
    },

  created() {
    this.myToken();
  },

  methods: {
      myToken() {
          if(localStorage.getItem('token'))
          {
              this.getToken = true
              // console.log(this.getToken)
          }
      },

      loggedIn() {
          this.getToken = true
      },

      logOut() {
          localStorage.removeItem('token')
          this.getToken = false
          this.$router.push('/login')
      }
  },
  watch: {
    // this.myToken();
    $route() {
      $("#navbarCollapse").collapse("hide");
    },
  },
};
</script>