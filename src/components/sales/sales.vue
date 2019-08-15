<template>
    <div class="companys">
        <h4 class="text-center page-name">Sale's</h4>
        <div class="companys_body">
            <div class="companys_company box_shadow_hover_roundshadow">
                <router-link to="/sales/add" style="text-decoration: none">
                    <div class="company_date"></div>
                    <h3 class="company_header">Add</h3>
                    <div class="company_country">New Lead</div>
                    <div class="centrize">
                        <div class="addcompany" style="top: 52px;">
                            <div class="button">+</div>
                        </div>
                    </div>
                    <div class="company_more box_shadow">GO TO</div>
                </router-link>
            </div>
            <div class="companys_company box_shadow_hover_roundshadow" >
                <router-link to="/sales/lead" style="text-decoration: none">
                    <div class="company_date"></div>
                    <h3 class="company_header">TOTAL</h3>
                    <div class="company_country">lead</div>
                    <div class="centrize">
                        <div class="doughnut">
                            <div v-if="preloadLeads" class="doughnut_chart_after" style="top: 45px;background: linear-gradient(rgba(200, 226, 18, 0.85) 0%, #f3300c 0%, #dc7d00 96.95%, #dc2200 100%);">
                                <div class="centrize">
                                    <img src="/static/img/loading.gif" alt="loading">
                                </div>
                            </div>
                            <div v-else class="doughnut_chart_after" style="top: 45px;background: linear-gradient(rgba(200, 226, 18, 0.85) 0%, #f3300c 0%, #dc7d00 96.95%, #dc2200 100%);">{{checkLeads()}}</div>
                        </div>
                    </div>
                    <div class="company_more box_shadow">more details</div>
                </router-link>
            </div>
            <div class="companys_company box_shadow_hover_roundshadow" >
                <router-link to="/sales/clients" style="text-decoration: none">
                    <div class="company_date"></div>
                    <h3 class="company_header">TOTAL</h3>
                    <div class="company_country">Clients</div>
                    <div class="centrize">
                        <div class="doughnut">
                            <div v-if="preloadClients" class="doughnut_chart_after" style="top: 45px;background: linear-gradient(rgba(200, 226, 18, 0.85) 0%, #f3300c 0%, #dc7d00 96.95%, #dc2200 100%);">
                                <div class="centrize">
                                    <img src="/static/img/loading.gif" alt="loading">
                                </div>
                            </div>
                            <div v-else class="doughnut_chart_after" style="top: 45px;background: linear-gradient(rgba(200, 226, 18, 0.85) 0%, #f3300c 0%, #dc7d00 96.95%, #dc2200 100%);">{{checkClients()}}</div>
                        </div>
                    </div>
                    <div class="company_more box_shadow">more details</div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: "sales",
        data(){
            return{
                preloadLeads: false,
                preloadClients: false,
            }
        },
        methods:{
            checkLeads(){
                let leads = this.$store.getters.get_salesManagerLeads
                if(leads!='Sql is empty'){
                    return leads.length
                }else{
                    return 0
                }
            },
            checkClients(){
                let clients = this.$store.getters.get_salesManagerClients
                if(clients!='Sql is empty'){
                    return clients.length
                }else{
                    return 0
                }
            },
            getAllData(){
                this.preloadLeads = true
                this.preloadClients = true
                axios.post(this.$store.getters.getPostUrl,'load=UsersAll').then(res=>{
                    let data = res.data
                    let clients = []
                    let leads = []
                    data.forEach(item=>{
                        if(item.premission_group == 6){
                            clients.push(item)
                        }
                        if(item.premission_group == 10){
                            leads.push(item)
                        }
                    })
                    this.$store.commit('set_salesManagerLeads',leads)
                    this.$store.commit('set_salesManagerClients',clients)
                    this.preloadLeads = false
                    this.preloadClients = false
                })
                axios.post(this.$store.getters.getPostUrl,'load=AllCompanys').then(res=>{
                    this.$store.commit('set_salesManagerClientsCompanys',res.data)
                })
            },
        },
        mounted(){
            this.getAllData()
        }

    }
</script>
