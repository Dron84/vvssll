<template>
    <section class="section">
        <div class="section-header">
            <h1>Service's</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-sm-12 col-sx-12 col-md-6 col-12">
                    <input type="text" v-model="companyname">
                    <button @click="CheckName">Check name</button>
                </div>
                <div class="col-sm-12 col-sx-12 col-md-6 col-12">
                    {{this.res}}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-sx-12 col-md-6 col-12">
                    <button @click="Jurisdiction">Check jurisdiction</button>
                </div>
                <div class="col-sm-12 col-sx-12 col-md-6 col-12">
                    <select name="" id="">
                        <option v-for="item in this.jurisdictions" :value="item.jurisdiction.code">{{item.jurisdiction.country}}</option>
                    </select>

                </div>
            </div>
            <button class="button" @click="submit">Next Step</button>
        </div>
    </section>
</template>

<script>
    import axios from 'axios'
    export default {
        name: "services",
        data(){
            return{
                companyname: '',
                res: null,
                jurisdictions: null
            }
        },
        methods:{
            CheckName(){
                axios.get('https://api.opencorporates.com/v0.4/companies/search?q='+this.companyname.replace(' ','+')).then((res)=>{
                    this.res = res.data.results.companies
                })
            },
            Jurisdiction(){
              axios.get('https://api.opencorporates.com/v0.4/jurisdictions').then((res)=>{
                  this.jurisdictions = res.data.results.jurisdictions
              })
            },
            submit(){
                this.$store.commit('setCompanyPage', 'payment')
            }
        }
    }
</script>

<style scoped>

</style>