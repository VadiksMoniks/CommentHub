<template>
    <div>
        <router-link :to="{ name: 'signin' }">Don't have an account?</router-link><br>
        <input @input="username = $event.target.value" type='text' placeholder='username'><br>
        <input @input="password = $event.target.value" type='password' placeholder='password'><br>
        <button @click="auth">Log In</button>
        <div id="answer" class="mt-5" x-text="errorMessage">{{errorMessage}}</div>
    </div>
</template>

<script>
import axios from 'axios';

    export default {

        data(){
            return{
                username: '',
                password: '',
                errorMessage: '',
            }
        },

        methods:{

            auth(){
                const formData = new FormData();
                formData.append('username', this.username);
                formData.append('password', this.password);

                axios.post('http://localhost/CommentHub/public/auth', formData)
                .then(response => {
                    if (response.data.message === 'OK') {
                    window.location.reload();
                    }
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        this.errorMessage = error.response.data.message;
                    } 
                });
            }
        }
    }
</script>