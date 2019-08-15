<template>
  <div class="preload" v-if="preload">
    <div class="dash uno"></div>
    <div class="dash dos"></div>
    <div class="dash tres"></div>
    <div class="dash cuatro"></div>
  </div>
  <div v-else>
    <div v-if="$store.getters.getLogin.login">
      <div v-if="$store.getters.getLogin.loginIn=='6'">
        <div class="container_header">
          <header class="header">
            <router-link to="/companys"><img src="/static/img/logo.png" alt="logo" class="logo"></router-link>
            <div class="user_menu">
              <router-link to="/myprofile"><div class="avatar box_shadow_hover_roundshadow" :style="backgroundAvatar()"></div></router-link>
              <img src="/static/img/notification.svg" alt="" class="notification">
              <img src="/static/img/message.svg" class="message" alt="" @click="openMessBox">
              <chats v-if="this.$store.getters.getMessBox"></chats>
              <div @click="logout" class="logout">Logout</div>
            </div>
          </header>
        </div>
        <div class="container">
          <nav class="top_menu" v-if="!this.$store.getters.getCompanyCreate">
            <router-link to="/companys">My Companies</router-link>
            <router-link to="/addcompany">Open Company</router-link>
            <router-link to="/applicantdoc">All documents</router-link>
            <!--<a href="/reports">Reports</a>-->
            <router-link to="/support">Support</router-link>
            <router-link to="/myprofile">My Profile</router-link>
          </nav>
          <section class="main_wrapper">
            <router-view></router-view>
          </section>
          <!--<footer class="site-footer">-->
            <!--<div class="top-footer">-->
              <!--<div class="container">-->
                <!--<div class="row">-->
                  <!--<div class="col-md-6 col-lg-3 footer-widget">-->
                    <!--<a href="#" class="footer-logo">-->
                      <!--<img src="/static/img/logo.png" alt="">-->
                    <!--</a>-->
                    <!--<div class="copy">-->
                      <!--Copyright 2019 © Comformo Ltd, trading as one of the top Quality Company formations-->
                    <!--</div>-->
                  <!--</div>-->
                  <!--<div class="col-md-6 col-lg-3 footer-widget">-->
                    <!--<h3 class="widget-title">-->
                      <!--Company-->
                    <!--</h3>-->
                    <!--<ul class="footer-menu">-->

                      <!--<li><a href="https://comformo.com/blog/" target="_blank">Blog</a></li>-->
                      <!--<li><a href="https://comformo.com/contact/" target="_blank">Contact us</a></li>-->

                    <!--</ul>-->
                  <!--</div>-->
                  <!--<div class="col-md-6 col-lg-3 footer-widget">-->
                    <!--<h3 class="widget-title">-->
                      <!--Useful Links-->
                    <!--</h3>-->
                    <!--<ul class="footer-menu">-->

                      <!--<li><a href="https://comformo.com/faq/" target="_blank">FAQ</a></li>-->
                      <!--<li><a href="https://comformo.com/partnership/" target="_blank">Partner ship</a></li>-->
                    <!--</ul>-->
                  <!--</div>-->
                  <!--<div class="col-md-6 col-lg-3 footer-widget">-->
                    <!--<h3 class="widget-title">-->
                      <!--Subscribe for our news-->
                    <!--</h3>-->
                    <!--<form action="" class="newsletter-form">-->
                      <!--<div class="input-wrapp">-->
                        <!--<input type="email" name="user-enail" class="form-control" placeholder="Your Email Here">-->
                        <!--<button class="btn">Subscribe</button>-->
                      <!--</div>-->
                    <!--</form>-->
                  <!--</div>-->
                <!--</div>-->
              <!--</div>-->
            <!--</div>-->
            <!--<div class="bottom-footer">-->
              <!--<div class="container">-->
                <!--<ul>-->
                  <!--<li><a href="https://comformo.com/disclaimer/" class='' target="_blank">Disclaimer</a></li>-->
                  <!--<li><a href="https://comformo.com/refund-policy/" class='' target="_blank">Refund Policy</a></li>-->
                  <!--<li><a href="https://comformo.com/privacy-policy/" class='' target="_blank">Privacy Policy</a></li>-->
                  <!--<li><a href="https://comformo.com/terms-of-payment/" class='' target="_blank">Terms of Payment</a></li>-->
                  <!--<li><a href="https://comformo.com/terms-and-conditions/" class='' target="_blank">Terms and Conditions</a></li>-->
                <!--</ul>-->
                <!--<div class="footer-visa">-->
                  <!--<img width="100" height="30" src="https://comformo.com/wp-content/uploads/2019/05/visa_PNG39.png" class="size-100x30" alt="" style="max-width: 100%; height: auto;">-->
                <!--</div>-->
              <!--</div>-->
            <!--</div>-->
          <!--</footer>-->
            <foot></foot>
        </div>
      </div>
      <div v-else-if="$store.getters.getLogin.loginIn=='3'||$store.getters.getLogin.loginIn=='4'">
        <div class="container_header">
          <header class="header">
            <router-link to="/manager/addcompany"><img src="/static/img/logo.png" alt="logo" class="logo"></router-link>
            <div class="user_menu">
              <router-link to="/myprofile"><div class="avatar box_shadow_hover_roundshadow" :style="backgroundAvatar()"></div></router-link>
              <img src="/static/img/notification.svg" alt="" class="notification">
              <img src="/static/img/message.svg" class="message" alt="">
              <div @click="logout" class="logout">Logout</div>
            </div>
          </header>
        </div>
        <div class="container">
          <nav class="top_menu">
            <router-link to="/manager/addcompany">Add Company</router-link>
            <router-link to="/manager/approve">Approve Documents</router-link>
            <router-link to="/manager/alldocs" v-if="$store.getters.getLogin.loginIn=='4'">Documents</router-link>
            <router-link to="/manager/tasks">Tasks</router-link>
            <router-link to="/manager/pdfmaker">PDF maker</router-link>
            <router-link to="/manager/users" v-if="$store.getters.getLogin.loginIn=='4'">Managers</router-link>
            <router-link to="/manager/companys">Companys</router-link>
            <router-link to="/manager/clients">My Client`s</router-link>
            <router-link to="/manager/addagentcompany" v-if="$store.getters.getLogin.loginIn=='4'">Add Agents Company</router-link>
            <router-link to="/manager/addagent" v-if="$store.getters.getLogin.loginIn=='4'">Add Agent</router-link>
          </nav>
          <section class="main_wrapper">
            <router-view></router-view>
          </section>
        </div>
      </div>
      <div v-else-if="$store.getters.getLogin.loginIn=='8'">
            <div class="container_header">
                <header class="header">
                    <router-link to="/seo/tasks"><img src="/static/img/logo.png" alt="logo" class="logo"></router-link>
                    <div class="user_menu">
                        <router-link to="/myprofile"><div class="avatar box_shadow_hover_roundshadow" :style="backgroundAvatar()"></div></router-link>
                        <img src="/static/img/notification.svg" alt="" class="notification">
                        <img src="/static/img/message.svg" class="message" alt="">
                        <div @click="logout" class="logout">Logout</div>
                    </div>
                </header>
            </div>
            <div class="container">
                <nav class="top_menu">
                    <router-link to="/seo/tasks">Tasks</router-link>
                    <router-link to="/seo/users">Managers</router-link>
                    <router-link to="/seo/addagentcompany">Add Agents Company</router-link>
                    <router-link to="/seo/addagent">Add Agent</router-link>
                </nav>
                <section class="main_wrapper">
                    <router-view></router-view>
                </section>
            </div>
        </div>
      <div v-else-if="$store.getters.getLogin.loginIn=='5'">
        <div class="container_header">
          <header class="header">
            <router-link to="/agent/addcompany"><img src="/static/img/logo.png" alt="logo" class="logo"></router-link>
            <div class="user_menu">
              <router-link to="/myprofile"><div class="avatar box_shadow_hover_roundshadow" :style="backgroundAvatar()"></div></router-link>
              <img src="/static/img/notification.svg" alt="" class="notification">
              <img src="/static/img/message.svg" class="message" alt="">
              <div @click="logout" class="logout">Logout</div>
            </div>
          </header>
        </div>
        <div class="container">
          <nav class="top_menu">
            <router-link to="/agent/addcompany">Add Company</router-link>
            <router-link to="/agent/approve">Approve Documents</router-link>
            <router-link to="/agent/companys">Company’s</router-link>
          </nav>
          <section class="main_wrapper">
            <router-view></router-view>
          </section>
        </div>
      </div>
      <div v-else-if="$store.getters.getLogin.loginIn=='9'">
        <div class="container_header">
          <header class="header">
            <router-link to="/sales/sales"><img src="/static/img/logo.png" alt="logo" class="logo"></router-link>
            <div class="user_menu">
              <router-link to="/myprofile"><div class="avatar box_shadow_hover_roundshadow" :style="backgroundAvatar()"></div></router-link>
              <img src="/static/img/notification.svg" alt="" class="notification">
              <img src="/static/img/message.svg" class="message" alt="">
              <div @click="logout" class="logout">Logout</div>
            </div>
          </header>
        </div>
        <div class="container">
          <nav class="top_menu">
            <router-link to="/sales/sales">Sale's</router-link>
            <router-link to="/sales/reports">Reports</router-link>
            <router-link to="/support">Support</router-link>
          </nav>
          <section class="main_wrapper">
            <router-view></router-view>
          </section>
        </div>
      </div>
    </div>
    <section class="container" v-else="$store.getters.getLogin.login==null||!$store.getters.getLogin.login">
        <router-view></router-view>
    </section>
  </div>
</template>

<script>
  import VueCookie from 'vue-cookie'
  import authLogin from '@/components/admin/authLogin'
  import Chats from '@/components/admin/chat'
  import foot from '@/components/footer'

export default {
  name: 'App',
  data(){
    return{
    }
  },
  mounted() {
      if(!this.$store.getters.getLogin.login) {
          this.$router.replace({path:'/login', name: "login" });
      }
  },
  components:{
      authLogin,Chats,foot
  },
  methods: {
      logout(){
          VueCookie.delete('login')
          VueCookie.delete('loginIn')
          VueCookie.delete('phone')
          VueCookie.delete('email')
          VueCookie.delete('id')
          this.$store.state.login=false
          this.$router.push({name: 'login'})
      },
      backgroundAvatar(){
          // console.log(this.$store.getters.get_avatar)
          if(this.$store.getters.get_avatar!=null && this.$store.getters.get_avatar!='' && this.$store.getters.get_avatar!='null'){
              return 'background-image: url('+this.$store.getters.get_avatar+');'
          }else{
              return 'background-image: url("/static/img/avatar.svg"); background-size: 70%; background-position: center'
          }
      },
      openMessBox(){
          this.$store.commit('setMessBox', true)
      }
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
