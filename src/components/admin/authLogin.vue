<template>
    <div class="preload" v-if="preload">
      <div class="dash uno"></div>
      <div class="dash dos"></div>
      <div class="dash tres"></div>
      <div class="dash cuatro"></div>
    </div>

    <div class="loginin" v-else>
      <div class="login-brand">
        <img src="/static/img/logo.png" alt="logo" width="200">
      </div>
      <h2>Login</h2>
      <form method="post" class="needs-validation" novalidate="" @submit.prevent="loginin">
        <div class="input_group">
          <input id="email" type="email" v-model="user.email" tabindex="1" required autofocus>
          <label for="email">Email</label>
        </div>

        <div class="input_group">
          <input id="password" type="password" v-model="user.pass" tabindex="2" required>
          <label for="password">Password</label>
          <router-link to="/forgotpassword" >Forgot Password?</router-link>
        </div>

        <div class="input_group">
          <button class="button" tabindex="4" @click.enter="loginin" style="display: flex;justify-content: center;align-items: center;">Login</button>
        </div>
        <p class="mess">{{mess}}</p>
      </form>
      <div class="create_register">
        Don't have an account? <router-link to="/register" >Create One</router-link>
      </div>
    </div>
</template>
<script>
  import axios from 'axios'
  import VueCookie from 'vue-cookie'
  export default {
      name: 'authLogin',
      data(){
          return{
              user: {
                  email: null,
                  pass: null,
              },
              mess: '',
              loginIn: '',
          }
      },
      methods:{
          loginin(){
              this.preload = true
              let fd = new FormData();
              fd.append('loginin','submit');
              fd.append('email',this.user.email);
              fd.append('password',this.user.pass);
              axios.post(this.$store.getters.getPostUrl, fd )
                  .then((res)=>{
                      if (res.data.login==true){
                          this.$store.commit('userlogin', res.data)
                          this.$store.commit('setCompanyCreate', false)
                          this.$store.commit('modal',false)
                          this.preload = false
                          if(res.data.loginin=='6'){
                              this.$router.push({path:'/companys'})
                          }else if(res.data.loginin=='3'||res.data.loginin=='4'){
                              this.$router.push({path:'/manager/addcompany'})
                          }else if(res.data.loginin=='5'){
                              this.$router.push({path:'/agent/addcompany'})
                          }else if(res.data.loginin=='8'){
                              this.$router.push({path:'/manager/addcompany'})
                          }else if(res.data.loginin=='9'){
                              this.$router.push({path:'/sales/sales'})
                          }
                      }else{
                          this.$store.commit('setCompanyCreate', false)
                          this.$store.commit('modal',false)
                          this.mess= res.data.error
                      }

                  })
          },

      },
      computed:{
          preload:{
              get(){
                  return this.$store.getters.preload
              },
              set(val){
                  this.$store.commit('preload',val)
              }
          }
      }
  }
</script>
<style lang="sass" scoped>
  .mess
    color: red
    text-align: center
  a[href="/forgotpassword"]
    text-align: right
    display: block
    margin: 10px
  .input_group:nth-child(3)
    display: flex
    justify-content: center
    .button
      width: 200px
      max-width: 200px
      height: 33px
  .create_register
    text-align: center
</style>