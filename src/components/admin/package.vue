<template>
    <div>
        <progressBar></progressBar>
        <section class="package">
            <h2>Select Package</h2>
            <p>New Company Name: <span>{{this.$store.getters.getCompanyName}}</span></p>
            <p>Country: <span>{{this.$store.getters.getCompanyCountry}}</span><img :src="flagSrc" alt="flag"></p>
            <div class="package_body">
                <div class="pack" :class="{active: this.$store.state.newCompany.package_selected=='Basic'}">
                    <h3 class="pack_price">$ {{this.$store.getters.getCompanyPriceBasic}}</h3>
                    <div class="pack_type">Basic</div>
                    <ul class="pack_list">
                        <li v-for="list in this.$store.getters.getServiseList" :class="{unenabled: list.package!='b'}">• {{list.name}}</li>
                    </ul>
                    <div class="pack_button" @click="selectPackage('Basic')">select</div>
                </div>
                <div class="pack" :class="{active: this.$store.state.newCompany.package_selected=='Standart'}">
                    <h3 class="pack_price">$ {{this.$store.getters.getCompanyPriceStandart}}</h3>
                    <div class="pack_type">Standart</div>
                    <ul class="pack_list">
                        <li v-for="list in this.$store.getters.getServiseList" :class="{unenabled: list.package=='p'||list.package=='u'||list.package=='0'}">• {{list.name}}</li>
                    </ul>
                    <div class="pack_button" @click="selectPackage('Standart')">select</div>
                </div>
                <div class="pack" :class="{active: this.$store.state.newCompany.package_selected=='Premium'}">
                    <h3 class="pack_price">$ {{this.$store.getters.getCompanyPricePremium}}</h3>
                    <div class="pack_type">Premium</div>
                    <ul class="pack_list">
                        <li v-for="list in this.$store.getters.getServiseList" :class="{unenabled: list.package=='u'||list.package=='0'}">• {{list.name}}</li>
                    </ul>
                    <div class="pack_button" @click="selectPackage('Premium')">select</div>
                </div>
                <div class="pack" :class="{active: this.$store.state.newCompany.package_selected=='Ultimate'}">
                    <h3 class="pack_price">$ {{this.$store.getters.getCompanyPriceUltimate}}</h3>
                    <div class="pack_type">Ultimate</div>
                    <ul class="pack_list">
                        <li v-for="list in this.$store.getters.getServiseList" :class="{unenabled: list.package=='0'}">• {{list.name}}</li>
                    </ul>
                    <div class="pack_button" @click="selectPackage('Ultimate')">select</div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import progressBar from './progressbar'
    export default {
        name: "package",
        data(){
            return{

            }
        },
        methods:{
            selectPackage(name){
                this.$store.commit('setPackage',name)
                this.$store.commit('setTotal',this.$store.getters.getPackagePrice)
                this.$store.commit('setCompanyPage', 'service')
                this.$router.push({path: '/additionalService'})
            },
        },
        computed:{
            flagSrc(){
                return 'static/img/flag/'+this.$store.getters.getCompanyCountryCode.toLowerCase()+'.png'
            },
        },
        components:{
            progressBar,
        },
        mounted(){
            let code = this.$store.getters.getCompanyCountryCode
            let country = this.$store.getters.getOurCountry
            country.forEach((item)=>{
                if(item.code== code){
                    this.$store.commit('setCompanyPriceBasic', item.basicPrice)
                    this.$store.commit('setCompanyPriceStandart', item.standartPrice)
                    this.$store.commit('setCompanyPricePremium', item.premiumPrice)
                    this.$store.commit('setCompanyPriceUltimate', item.ultimatePrice)
                    this.$store.commit('setCompanyServiceList',JSON.parse(item.package))
                    // console.log(item.package)
                }

            })

        }
    }
</script>

<style scoped>

</style>