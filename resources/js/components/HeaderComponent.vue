<template>
    <div class="flex w-full h-20 bg-deepWater text-white items-center">
        <p class="text-xl ml-[20px] no-underline text-yellow-400">CommentHub</p>
        <button @click="logOut" v-if="session" class="ml-auto mr-8 ">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
            </svg>
        </button>
        <router-link v-else :to="{ name: 'signin' }" class="ml-auto mr-8 ">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-8 h-8 hover:w-9 h-9">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </router-link>
    </div>
</template>
<script>
import axios from 'axios';

    export default{
        props: {
            session: Boolean,
        },
        methods:{
            logOut(){
                axios.post('http://localhost/CommentHub/public/logOut')
               .then(response => {
                    if (response.data.message === 'OK') {
                    window.location.reload();
                    }
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        alert(error.response.data.message);
                    } 
                });
            },
        }
    }
</script>