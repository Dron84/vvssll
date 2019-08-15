<template>
    <div class="container">
        <h3>My Client`s</h3>
        <div class="companys">
            <div class="preload" v-if="preloader"><div class="centrize"><img src="/static/img/loading.gif" alt="" style="height: 20px;"></div></div>
            <div class="companys_body" v-else>
                <div class="companys_company box_shadow_hover_roundshadow" v-for="item in $store.getters.get_managerClients">
                    <router-link :to="'/manager/clients/'+item.id" style="text-decoration: none">
                        <div class="company_date"></div>
                        <h3 class="company_header">{{item.firstName+' '+item.lastName}}</h3>
                        <div class="company_country">{{item.email}}</div>
                        <div class="centrize" style="margin: 10px 0;">
                            <div class="change_avatar" style="width: 150px; height: 150px;"><img :src="checkAvatar(item.avatar)" alt="avatar"></div>
                        </div>
                        <div class="company_more box_shadow">more details</div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: "myclients",
        components:{},
        data(){
            return{
                clients: [],
                clientsCompany: [],
                preloader: false,
            }
        },
        methods:{
           loadAllData(){
               this.preloader = true
               if(this.$store.getters.getLogin.loginIn =='4'){
                   axios.post(this.$store.getters.getPostUrl,'getClients=all')
                       .then(res=>{
                           this.$store.commit('set_managerClients',res.data.users)
                           this.$store.commit('set_managerClientsCompany',res.data.companys)
                           this.preloader = false
                       })
               }else{
                   axios.post(this.$store.getters.getPostUrl,'getClients='+this.$store.getters.get_id)
                       .then(res=>{
                           this.$store.commit('set_managerClients',res.data.users)
                           this.$store.commit('set_managerClientsCompany',res.data.companys)
                           this.preloader = false
                       })
               }

           },
            checkAvatar(img){
               if(img!='' && img!=null){
                   return img
               }else{
                   return '/static/img/avatar.svg'
               }
            }
        },
        created(){
            this.loadAllData()
        }
    }
</script>

<style scoped>

</style>