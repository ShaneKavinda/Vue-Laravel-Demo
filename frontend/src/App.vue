<script>
import { RouterLink, RouterView } from 'vue-router';
import Navbar from './components/Navbar.vue'

export default {
    data() {
        return {
          
        };
    },
    components: { RouterLink, RouterView, Navbar }
};
</script>

<template>
  <Navbar />  
  <RouterView/>
</template>

