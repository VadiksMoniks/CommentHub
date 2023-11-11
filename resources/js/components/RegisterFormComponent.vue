<template>
    <div>
        <router-link :to="{ name: 'login' }">Already have an account?</router-link><br>
        <input @input="username = $event.target.value" type='text' placeholder='username'><br>
        <input @input="email = $event.target.value" type='text' placeholder='email'><br>
        <input @input="password = $event.target.value" type='password' placeholder='password'><br>
        <input @change="onAvatarChange" type="file" id="avatar"><br>
        <button @click="register" >Sign In</button>
        <div id="answer" class="mt-5" x-text="errorMessage">{{errorMessage}}</div>
    </div>
</template>

<script>
import axios from 'axios';

    export default {

        data(){
            return{
                username: '',
                email: '',
                password: '',
                avatar: null,
                errorMessage: '',
            }
        },

        methods:{
            onAvatarChange(event) {
                this.avatar = event.target.files[0];
            },

            register(){
                const formData = new FormData();
                formData.append('username', this.username);
                formData.append('email', this.email);
                formData.append('password', this.password);
                if (this.avatar) {
                    formData.append('avatar', this.avatar);
                }

                axios.post('http://localhost/CommentHub/public/register', formData)
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