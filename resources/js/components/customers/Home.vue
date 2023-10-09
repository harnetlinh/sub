<template>
    <div class="relative py-16 bg-gradient-to-br from-sky-50 to-gray-200">  
        <SideBar/>
        <router-view />
    </div>
</template>
  
<script>
import SideBar from '../layout/SideBar.vue';

  export default {
    name: "home",
    components:{
        SideBar
    },
    data() {
        return {  
            msg: "Welcome to Your Vue.js App" 
        };
    },
    methods:{
       
    }
  }
</script>
