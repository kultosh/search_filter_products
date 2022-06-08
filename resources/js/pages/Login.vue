<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6 offset-3 bg-light p-5" v-if="!isLoading">
                <p class="text-danger">{{errorMessage}}</p>
                <form @submit.prevent="userLogIn">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="user.email" @click="errorMessage = ''" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" v-model="user.password" @click="errorMessage = ''" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
            <div class="col-md-6 offset-3 bg-light p-5" v-if="isLoading">
                <p class="text-center">Processing....</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            user: {
                'email': '',
                'password': ''
            },
            errorMessage: "",
            isLoading: false
        }
    },

    created() {
        localStorage.getItem('token') ? this.$router.push('/') : true;
    },

    methods: {
        userLogIn() {
            let data = this.user;
            this.isLoading = true;
            axios.post('/api/login', data, {
                headers: {
                    'content-type': 'application/json'
                }
            })
            .then(res => {
                this.isLoading = false;
                let token = res.data.token
                localStorage.setItem("token", token)
                this.$emit('getLoggedIn', this.token)
                this.$router.push('/')
            })
            .catch(err => {
                this.isLoading = false;
                err.response.status === 401 ? this.errorMessage = "Please enter valid credentials." : ""
            })
        }
    }
}
</script>