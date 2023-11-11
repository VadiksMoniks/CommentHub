<template>
<div class="app">
    <HeaderComponent :session="this.session"></HeaderComponent>
    <router-view :user="this.user" :session="this.session"></router-view>
</div>
</template>

<script>
import HeaderComponent from './HeaderComponent.vue';
import MainPageComponent from './MainPageComponent.vue';
import RegisterFormComponent from './RegisterFormComponent.vue';

export default {

  props: {
    session: Boolean,
    user: String
  },

  components: {
        MainPageComponent, HeaderComponent, RegisterFormComponent
   },
}
</script>

<style>
a{
  text-decoration: underline;
  color:blue;
}
</style>