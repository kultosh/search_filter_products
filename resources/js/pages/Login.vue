<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6 offset-3 bg-light p-5">
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    data () {
        return {
            user: {
                'email': '',
                'password': ''
            },
            errorMessage: "",
        }
    },

    created() {
        localStorage.getItem('token') ? this.$router.push('/product') : true;
    },

    methods: {
        userLogIn() {
            console.log(this.user)
            let data = this.user
            axios.post('/api/login', data, {
                headers: {
                    'content-type': 'application/json'
                }
            })
            .then(res => {
                console.log(res.data.token)
                let token = res.data.token
                localStorage.setItem("token", token)
                this.$emit('getLoggedIn', this.token)
                this.$router.push('/product')
            })
            .catch(err => {
                err.response.status === 401 ? this.errorMessage = "Please enter valid credentials." : ""
            })
        }
    }
}
</script>