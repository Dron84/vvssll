<template>
    <div class="loginin">
    <div class="login-brand">
      <img src="static/img/logo.png" alt="logo" width="200">
    </div>
    <h2>Restore password</h2>
    <form method="post" class="needs-validation" novalidate="" @submit.prevent="restore">
      <div class="input_group">
        <input id="email" type="email" v-model="email" tabindex="1" required autofocus>
        <label for="email" class="label_up">Email</label>
      </div>

      <div class="input_group" style="display: flex;justify-content: center;align-items: center;">
        <div class="button" tabindex="4" @click="restore" style="display: flex;justify-content: center;align-items: center;">Restore</div>
      </div>
      <p class="mess">{{mess}}</p>
    </form>
  </div>
</template>
<script>
  import axios from 'axios'
    export default {
        name: 'forgotpassword',
        data(){
            return{
              email: '',
              mess: ''

            }
        },
        methods: {
            restore(){
              let fd = new FormData
              fd.append('loginin', 'restore')
              fd.append('email', this.email)
              axios.post(this.$store.getters.getPostUrl, fd).then((res)=>{
                  this.mess = res.data.mess
              })
            }
        }
    }
</script>