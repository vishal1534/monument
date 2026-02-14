<template>
  <div id="app">
    <loading ref="loading" />
    <component :is="this.$route.meta.layout || 'div'">
<!--  :key="$route.path" this is used here because we have a scenario that we need to load monument list and edit form from 2 different links       -->
      <router-view :key="$route.path"/>
    </component>
  </div>
</template>

<script>
import Loading from './Loading';
import {userDetail} from "../helpers/axios";
export default {
  el: '#app',
  components: {
    Loading
  },
  mounted () {
    this.$loading = this.$refs.loading;
  },
  /*beforeCreate() {
    userDetail( (response) => {
      this.user = response.data
      let payload = {user:response.data[0],isLoggedIn:true};
      this.$store.commit('setAuthUser', payload);
      localStorage.setItem('authUser', JSON.stringify(payload));
    },(error) => {
      console.log('Auth',error);
    });
  },*/

}
</script>
