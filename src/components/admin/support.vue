<template>
    <div>
        <h2>Send Support request</h2>
        <div class="input_group">
            <input type="text" id='name' :class="{'ok': Name.length>2}" v-model="Name" autofocus required tabindex="1">
            <label for="name" class="label_up">Your Name</label>
        </div>
        <div class="input_group">
            <input type="email" id='email' :class="[isEmailValid()]" v-model="email" tabindex="2" required>
            <label for="email" class="label_up">Your Email</label>
        </div>
        <div class="input_group">
            <textarea v-model="messToSupport" id="messToSupport" cols="30" rows="10" required :class="{'ok': messToSupport.length>10}" tabindex="3"></textarea>
            <label for="messToSupport" class="label_up">Text message</label>
        </div>
        <div class="input_group">
            <button class="button" @click="SendSupport()" :disabled="checkData" ref="button">Send</button>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: "support",
        data(){
            return{
                Name: '',
                email: '',
                messToSupport: '',
                okClass: 'ok',
                errorClass: 'err',
                info: '',
                reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
            }
        },
        methods:{
            isEmailValid(){
                return (this.email == "")? "" : (this.reg.test(this.email)) ? 'ok' : 'err'
            },
            SendSupport(){
                this.$refs.button.innerHTML='Message Sending'
                let fd = new FormData
                fd.append('name', this.Name)
                fd.append('email', this.email)
                fd.append('MessToSupport',this.messToSupport)
                axios.post(this.$store.getters.getPostUrl, fd)
                    .then((res)=>{
                        if(res.data=="Message has been sent"){
                            this.Name=''
                            this.email=''
                            this.messToSupport=''
                            this.$refs.button.innerHTML='Message Send'
                        }
                    })
                setTimeout(()=>{
                    this.$refs.button.innerHTML='Send'
                },5000)
            }
        },
        computed:{
            checkData(){
                if (this.Name.length>2 &&this.isEmailValid() && this.messToSupport.length>10){return false}else{return true}
            }
        }

    }
</script>

<style scoped>

</style>