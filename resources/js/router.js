import { createRouter, createWebHistory } from 'vue-router';
import MainPageComponent from './components/MainPageComponent.vue';
import RegisterFormComponent from './components/RegisterFormComponent.vue';
import AuthenticateFormComponent from './components/AuthenticateFormComponent.vue';

export default createRouter({
    routes: [{
            path: '/CommentHub/public/',
            name: 'home',
            component: MainPageComponent
        },
        {
            path: '/CommentHub/public/SignIn',
            name: 'signin',
            component: RegisterFormComponent
        },
        {
            path: '/CommentHub/public/LogIn',
            name: 'login',
            component: AuthenticateFormComponent
        }
        
    ],

    history: createWebHistory(),
    
});