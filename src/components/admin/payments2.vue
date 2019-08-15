<template>
    <div>
        <progressBar></progressBar>
        <section class="payment">
            <div v-if="paymentStatus==''">
                <h2><span class="text_accent">Special offer</span> for Barcelona<br>Tranding Conference</h2>
                <p>New Company Name: <span>{{this.$store.getters.getCompanyName}}</span></p>
                <p>Country: <span>{{this.$store.getters.getCompanyCountry}}</span><img :src="flagSrc" alt="flag"></p>
                <p>Package: <span>{{this.$store.state.newCompany.package_selected}}</span></p>
                <p>TOTAL: <span class="text_accent">${{this.$store.getters.getTotal}}</span></p>
                <div class="centrize">
                    <button v-if="!savepreload" class="button confirm" style="width: 300px; margin: 0 auto;" @click="payNow()">Continue</button>
                    <button v-else class="button" style="width: 300px; margin: 0 auto;" disabled="disabled">WAIT <img src="/static/img/loading.gif" alt="load" style="height: 15px;position: relative;top: -2px;left:5px;"></button>
                </div>
                <div style="margin-top: 20px;position: relative;">
                    <img src="/static/img/banner.jpg" alt="banner">
                    <p style="position: absolute;top: 43px;display: block;margin: 0 auto;text-align: center;color: white;font-size: 3em;width: 100%;">We will send our special pricing to your email</p>
                </div>
            </div>
        </section>
        <section class="navigation-buttons">
            <button class="prev-page" @click="backStep"></button>
        </section>
    </div>
</template>

<script>
    import progressBar from './progressbar'
    import axios from 'axios'

    export default {
        name: "payments",
        data(){
            return{
                okClass: 'ok',
                errorClass: 'err',
                activeClass: 'active',
                notActive: '',
                savepreload: false,
            }
        },
        computed:{
            flagSrc(){
                return 'static/img/flag/'+this.$store.getters.getCompanyCountryCode.toLowerCase()+'.png'
            },
            paymentStatus:{
                get(){
                    return this.$store.getters.getCompanyPaymentStatus
                },
                set(value){
                    this.$store.commit('setCompanyPaymentStatus', value)
                }
            },
        },
        methods: {
            payNow(){
                this.savepreload = true
                let fd = new FormData
                fd.append('package', this.$store.getters.getPackage)
                fd.append('services', this.$store.getters.getAddedServices)
                fd.append('totalPrice', this.$store.getters.getTotal)
                fd.append('jurisdiction', this.$store.getters.getCompanyJurusdictionId)
                fd.append('companyName', this.$store.getters.getCompanyName)
                fd.append('billFirstName', this.$store.getters.get_billfirstname)
                fd.append('billCity', this.$store.getters.get_billCity)
                fd.append('billZipcode', this.$store.getters.get_billzip)
                fd.append('billAddress1', this.$store.getters.get_billaddress1)
                fd.append('billLastName', this.$store.getters.get_billlastname)
                fd.append('billCountry', this.$store.getters.get_billCountry)
                fd.append('billState', this.$store.getters.get_billState)
                fd.append('billAddress2', this.$store.getters.get_billaddress2)
                fd.append('applicantid', this.$store.getters.get_id)
                fd.append('createCompany', 'create')
                axios.post(this.$store.getters.getPostUrl, fd)
                    .then((res)=>{
                        this.$store.commit('setCompanyId', res.data.id)
                        let fd = new FormData
                        fd.append('myCompanys', this.$store.getters.get_id)
                        axios.post(this.$store.getters.getPostUrl, fd)
                            .then((res)=>{
                                this.$store.commit('setMyCompanys', res.data)
                                this.paymentStatus='success'
                                this.$store.commit('setCompanyPage','')
                                this.$router.push({path: '/companys/'})
                                this.savepreload = false
                                this.clearData()
                            })
                    })



                //todo Payment
                // fd.append('card', this.)
                // fd.append('mounth', this.)
                // fd.append('year', this.)
                // fd.append('cvv', this.)
                // fd.append('holder', this.)
                // fd.append('cardData', this.)
                // fd.append('paymentStatus', this.)
                // fd.append('wire_fullname', this.)
                // fd.append('wire_regaddress', this.)
                // fd.append('wire_regnum', this.)
                // fd.append('wire_emailinvice', this.)
            },  //payment original

            backStep(){
                this.$store.commit('setCompanyPage', 'service')
                this.$router.push({path: '/additionalService'})
            },
            clearData(){
                this.$store.commit('setPackage' , '')
                this.$store.commit('setCompanyServiceList' , '')
                this.$store.commit('setTotal' , '')
                this.$store.commit('setCompanyJurisdictionId', '')
                this.$store.commit('setCompanyCountry', '');
                this.$store.commit('setCompanyCountryCode', '');
                this.$store.commit('setCompanyName' , '')
                this.$store.commit('set_billfirstname' , '')
                this.$store.commit('set_billCity' , '')
                this.$store.commit('set_billzip' , '')
                this.$store.commit('set_billaddress1' , '')
                this.$store.commit('set_billlastname' , '')
                this.$store.commit('set_billCountry' , '')
                this.$store.commit('set_billState' , '')
                this.$store.commit('set_billaddress2' , '')
            },
        },
        components: {
            progressBar,
        }
    }
</script>
