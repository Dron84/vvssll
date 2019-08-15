<template>
    <section>
        <div class="container">
            <sm></sm>
            <h header="All Leads" @searchInfo="searchInfo($event)" placeholder="Enter Name or Email"></h>
        </div>
        <div class="container">
            <div class="companys" style="grid-template-rows: 1fr;grid-template-areas: 'companys_body';grid-template-columns: 1fr;width: 100%;">
                <div class="preload" v-if="preloader">
                    <div class="centrize"><img src="/static/img/loading.gif" alt="" style="height: 20px;"></div>
                </div>
                <div v-else-if="!preloader">
                    <div class="companys_body" v-if="users!='Sql is empty'">
                        <div class="companys_company box_shadow_hover_roundshadow" v-for="item in users" >
                            <router-link :to="'/sales/lead/'+item.id" style="text-decoration: none;">
                                <div class="company_date"></div>
                                <h3 class="company_header">{{item.firstName+' '+item.lastName}}</h3>
                                <div class="company_country">{{item.email}}</div>
                                <div class="centrize" style="margin: 10px 0;">
                                    <div class="change_avatar" style="width: 150px; height: 150px;"><img
                                            :src="checkAvatar(item.avatar)" alt="avatar"></div>
                                </div>
                            </router-link>
                                <div class="tripple" style="grid-template-columns: repeat(auto-fit, minmax(20px, 1fr));">
                                    <a :href="'tel:'+item.phone" v-if="item.phone!=''&&item.phone!=null"><svg xmlns="http://www.w3.org/2000/svg" width="20.984" height="20.97" viewBox="0 0 20.984 20.97"><path class="a" d="M20.974,16.737a1.014,1.014,0,0,1-.311.889l-2.954,2.932a1.663,1.663,0,0,1-.522.378,2.157,2.157,0,0,1-.633.2q-.022,0-.133.011t-.289.011a10.241,10.241,0,0,1-1.366-.144,10.375,10.375,0,0,1-2.31-.711,19.391,19.391,0,0,1-3.1-1.7,23.1,23.1,0,0,1-3.687-3.11,24.342,24.342,0,0,1-2.577-2.932A20.892,20.892,0,0,1,1.448,9.973,13.938,13.938,0,0,1,.515,7.818,11.432,11.432,0,0,1,.093,6.152,5.5,5.5,0,0,1,0,5.053q.022-.4.022-.444a2.159,2.159,0,0,1,.2-.633A1.665,1.665,0,0,1,.6,3.453L3.558.5A.978.978,0,0,1,4.269.188.829.829,0,0,1,4.78.355a1.544,1.544,0,0,1,.378.411L7.534,5.275a1.081,1.081,0,0,1,.111.777,1.385,1.385,0,0,1-.378.711L6.179,7.852A.37.37,0,0,0,6.1,8a.548.548,0,0,0-.033.167,4.011,4.011,0,0,0,.4,1.066,9.788,9.788,0,0,0,.822,1.3,14.429,14.429,0,0,0,1.577,1.766,14.714,14.714,0,0,0,1.777,1.588,10.262,10.262,0,0,0,1.3.833,3.454,3.454,0,0,0,.8.322l.278.056a.53.53,0,0,0,.144-.033.371.371,0,0,0,.144-.078l1.266-1.288a1.361,1.361,0,0,1,.933-.355,1.161,1.161,0,0,1,.6.133h.022L20.418,16A1.117,1.117,0,0,1,20.974,16.737Z" transform="translate(0 -0.188)"/></svg></a>
                                    <a :href="item.instagram" v-if="item.instagram!=''&&item.instagram!=null" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="21.17" height="21.17" viewBox="0 0 21.17 21.17"><path class="a" d="M10.585,1.882A32.455,32.455,0,0,1,14.819,2a5.455,5.455,0,0,1,2,.353,4.13,4.13,0,0,1,2,2,5.455,5.455,0,0,1,.353,2c0,1.058.118,1.411.118,4.234a32.455,32.455,0,0,1-.118,4.234,5.455,5.455,0,0,1-.353,2,4.13,4.13,0,0,1-2,2,5.455,5.455,0,0,1-2,.353c-1.058,0-1.411.118-4.234.118a32.455,32.455,0,0,1-4.234-.118,5.455,5.455,0,0,1-2-.353,4.13,4.13,0,0,1-2-2,5.455,5.455,0,0,1-.353-2c0-1.058-.118-1.411-.118-4.234A32.455,32.455,0,0,1,2,6.351a5.455,5.455,0,0,1,.353-2,4.224,4.224,0,0,1,.823-1.176,1.988,1.988,0,0,1,1.176-.823,5.455,5.455,0,0,1,2-.353,32.455,32.455,0,0,1,4.234-.118m0-1.882A34.75,34.75,0,0,0,6.233.118a7.261,7.261,0,0,0-2.587.47A4.6,4.6,0,0,0,1.764,1.764,4.6,4.6,0,0,0,.588,3.646a5.359,5.359,0,0,0-.47,2.587A34.75,34.75,0,0,0,0,10.585a34.75,34.75,0,0,0,.118,4.352,7.261,7.261,0,0,0,.47,2.587,4.6,4.6,0,0,0,1.176,1.882,4.6,4.6,0,0,0,1.882,1.176,7.261,7.261,0,0,0,2.587.47,34.75,34.75,0,0,0,4.352.118,34.75,34.75,0,0,0,4.352-.118,7.261,7.261,0,0,0,2.587-.47,4.934,4.934,0,0,0,3.058-3.058,7.261,7.261,0,0,0,.47-2.587c0-1.176.118-1.529.118-4.352a34.75,34.75,0,0,0-.118-4.352,7.261,7.261,0,0,0-.47-2.587,4.6,4.6,0,0,0-1.176-1.882A4.6,4.6,0,0,0,17.524.588a7.261,7.261,0,0,0-2.587-.47A34.75,34.75,0,0,0,10.585,0m0,5.175a5.323,5.323,0,0,0-5.41,5.41,5.41,5.41,0,1,0,5.41-5.41m0,8.938a3.465,3.465,0,0,1-3.528-3.528,3.465,3.465,0,0,1,3.528-3.528,3.465,3.465,0,0,1,3.528,3.528,3.465,3.465,0,0,1-3.528,3.528M16.23,3.646A1.294,1.294,0,1,0,17.524,4.94,1.305,1.305,0,0,0,16.23,3.646"/></svg></a>
                                    <a :href="item.facebook" v-if="item.facebook!=''&&item.facebook!=null" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="11.055" height="21.17" viewBox="0 0 11.055 21.17"><path class="a" d="M87.174,21.17V11.526h3.293l.47-3.764H87.174V5.41c0-1.058.353-1.882,1.882-1.882h2V.118c-.47,0-1.647-.118-2.94-.118a4.54,4.54,0,0,0-4.822,4.94V7.762H80v3.764h3.293V21.17Z" transform="translate(-80)"/></svg></a>
                                    <a :href="item.twitter" v-if="item.twitter!=''&&item.twitter!=null" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="21.17" height="17.171" viewBox="0 0 21.17 17.171"><path class="a" d="M44.7,19.171A12.239,12.239,0,0,0,57.053,6.822V6.234A9.56,9.56,0,0,0,59.17,4a9.763,9.763,0,0,1-2.47.706,4.576,4.576,0,0,0,1.882-2.352,10.788,10.788,0,0,1-2.705,1.058A4.2,4.2,0,0,0,52.7,2,4.419,4.419,0,0,0,48.35,6.352a2.293,2.293,0,0,0,.118.941,12.16,12.16,0,0,1-8.938-4.587,4.5,4.5,0,0,0-.588,2.235,4.673,4.673,0,0,0,1.882,3.646,3.965,3.965,0,0,1-2-.588h0a4.3,4.3,0,0,0,3.528,4.234,3.626,3.626,0,0,1-1.176.118,2,2,0,0,1-.823-.118,4.456,4.456,0,0,0,4.116,3.058,8.88,8.88,0,0,1-5.41,1.882A3.256,3.256,0,0,1,38,17.054a11.1,11.1,0,0,0,6.7,2.117" transform="translate(-38 -2)"/></svg></a>
                                    <a :href="'mailto:'+item.email" v-if="item.email!=''&&item.email!=null"><svg xmlns="http://www.w3.org/2000/svg" width="21.367" height="18.697" viewBox="0 0 21.367 18.697"><path class="a" d="M20.032,1H1.335A1.335,1.335,0,0,0,0,2.335V18.361A1.335,1.335,0,0,0,1.335,19.7h18.7a1.335,1.335,0,0,0,1.335-1.335V2.335A1.335,1.335,0,0,0,20.032,1ZM18.7,17.026H2.671V8.643l7.35,4.2a1.333,1.333,0,0,0,1.325,0l7.35-4.2Zm0-11.458-8.013,4.579L2.671,5.567v-1.9H18.7Z" transform="translate(0 -1)"/></svg></a>
                                </div>
                            <router-link :to="'/sales/lead/'+item.id" style="text-decoration: none;">
                                <div class="company_more box_shadow">more details</div>
                            </router-link>
                        </div >
                    </div>
                    <div class="centrize" v-else-if="users=='Sql is empty'" style="position: relative;top: 40px;">No Leads in system</div>
                </div>

            </div>
        </div>
    </section>
</template>

<script>
    import sm from './submenu'
    import h from './h'
    import axios from 'axios'

    export default {
        name: "lead",
        components: {sm, h},
        data() {
            return {
                preloader: false,
                users: [],
            }
        },
        methods: {
            searchInfo(filters) {
                if(filters!=null){
                    let searchRow = document.getElementsByClassName('companys_company box_shadow_hover_roundshadow')
                    for (let j = 0; j<searchRow.length; j++){
                        let search = searchRow[j].getElementsByClassName('company_header')
                        for (let i = 0; i < search.length; i++) {
                            let searchtext = filters.toUpperCase()
                            let innertext = search[i].innerText.toUpperCase()
                            if (innertext.indexOf(searchtext) > -1) {
                                searchRow[j].style.display = "block";
                            } else {
                                searchRow[j].style.display = "none";
                            }
                        }
                        let email = searchRow[j].getElementsByClassName('company_country')
                        for (let i = 0; i < email.length; i++) {
                            let searchtext = filters.toUpperCase()
                            let innertext = email[i].innerText.toUpperCase()
                            if (innertext.indexOf(searchtext) > -1) {
                                searchRow[j].style.display = "block";
                            } else {
                                searchRow[j].style.display = "none";
                            }
                        }
                    }
                }else{
                    let searchRow = document.getElementsByClassName('companys_company box_shadow_hover_roundshadow')
                    for (let j = 0; j<searchRow.length; j++){
                        searchRow[j].style.display = "block";
                    }
                }
            },
            loadAllLeads() {
                this.preloader = true
                this.users = this.$store.getters.get_salesManagerLeads
                this.preloader = false
            },
            checkAvatar(img) {
                if (img != '' && img != null) {
                    return img
                } else {
                    return '/static/img/avatar.svg'
                }
            },
            getAllLeads(){
                axios.post(this.$store.getters.getPostUrl,'load=UsersAll').then(res=>{
                    let data = res.data
                    let leads = []
                    data.forEach(item=>{
                        if(item.premission_group == 10){
                            leads.push(item)
                        }
                    })
                    this.$store.commit('set_salesManagerLeads',leads)
                })
            },
        },
        mounted() {
            this.getAllLeads()
            this.loadAllLeads()
        }
    }
</script>

<style scoped>

</style>