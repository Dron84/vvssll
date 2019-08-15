<template>
    <div class="companys">
        <h4 class="text-center page-name">Here is a list of your companies, you can edit the data or <router-link to="/addcompany">add another company</router-link></h4>
        <div class="companys_body">
            <div class="companys_company box_shadow_hover_roundshadow" v-for="item in myCompanys">
                <router-link :to="'/companys/'+item.id" style="text-decoration: none">
                    <img :src="item.CountryImg" class="company_flag"/>
                    <div class="company_date">{{item.datetime.split(' ')[0]}}</div>
                    <h3 class="company_header">{{item.CompanyName}}</h3>
                    <div class="company_country">{{item.CountryName}}</div>
                    <div class="centrize">
                        <div class="doughnut">
                            <DoughnutChart :percent="correctPercent(item)" :foregroundColor="ChartColor(parseInt(correctPercent(item)))" :backgroundColor="chart.backgroundColor" :radius="chart.radius" :width="chart.width" :height="chart.height" :strokeWidth="chart.strokeWidth" :visibleValue="chart.visibleValue" :classValue="chart.classValue"></DoughnutChart>
                            <div class="doughnut_chart_after" :style="ChartStyle(ChartColor(parseInt(correctPercent(item))))">{{Math.round(correctPercent(item))}}%</div>
                        </div>
                    </div>
                    <div class="company_more box_shadow">more details</div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import DoughnutChart from 'vue-doughnut-chart'
    export default {
        name: "companys",
        data(){
            return{
                chart: {
                    backgroundColor: "transperent",
                    radius: 90,
                    width: 140,
                    height: 140,
                    strokeWidth: 15,
                    visibleValue: false,
                    classValue: "percent"
                },
                CountryImg: '',
                CountryName: '',
                CompanyStatus: '',
                CompanyName: '',
                CompanyPercent: 0,
                CompanyForegroundColor: '',
                datetime: '',
                myCompanys: [],
            }
        },
        components: {
            DoughnutChart
        },
        methods:{
            correctPercent(companyData){
                if (companyData.docs=='Sql is empty'){
                    if(companyData.CompanyPercent>5){
                        return Number(companyData.CompanyPercent-5)
                    }else{
                        return Number(0)
                    }
                }else{
                    return Number(companyData.CompanyPercent)
                }
            },
            getCountry(id){
                const countrys = this.$store.getters.getOurCountry
                for(let i=0; i<countrys.length; i++){
                    if(countrys[i].id == id){
                        return {'CountryImg': '/static/img/flag/'+countrys[i].code.toLowerCase()+'.png', 'CountryName': countrys[i].jurisdictionname}
                    }
                }
            },
            companyStatus(data){
                this.CompanyPercent=0
                data = JSON.parse(data)
                if(data.general==100){
                    this.CompanyPercent = this.CompanyPercent+25
                }else if(data.general>=50&&data.general<=100){
                    this.CompanyPercent = this.CompanyPercent+5
                }else if(data.general<50){
                    this.CompanyPercent = this.CompanyPercent+0.25
                }
                if(data.ubo==100){
                    this.CompanyPercent = this.CompanyPercent+25
                }else if(data.ubo>=50&&data.ubo<=100){
                    this.CompanyPercent = this.CompanyPercent+5
                }else if(data.ubo<50){
                    this.CompanyPercent = this.CompanyPercent+0.25
                }
                if(data.dillegance==100){
                    this.CompanyPercent = this.CompanyPercent+25
                }else if(data.dillegance>=50&&data.dillegance<=100){
                    this.CompanyPercent = this.CompanyPercent+5
                }else if(data.dillegance<50){
                    this.CompanyPercent = this.CompanyPercent+0.25
                }
                if(data.fatca==100){
                    this.CompanyPercent = this.CompanyPercent+25
                }else if(data.fatca>=50&&data.fatca<=100){
                    this.CompanyPercent = this.CompanyPercent+5
                }else if(data.fatca<50){
                    this.CompanyPercent = this.CompanyPercent+0.25
                }
            },
            ChartColor(percent){
                let color = ''
                if(percent>=0&&percent<=12){
                    color="#c53312"
                }else if(percent > 12 && percent<=25){
                    color='#c53312'
                }else if(percent > 25 && percent<=37){
                    color='#ee5d11'
                }else if(percent > 37 && percent<=50){
                    color='#fb9f35'
                }else if(percent > 50 && percent<=62){
                    color='#dad00b'
                }else if(percent > 62 && percent<=75){
                    color='#c5e204'
                }else if(percent > 75 && percent<=87){
                    color='#62e502'
                }else if(percent > 87){
                    color='#0bc64c'
                }
                return color
            },
            ChartStyle(color){
                return 'background-color:'+color+';'
            },

        },
        computed:{

        },
        mounted(){
            this.$store.commit('setCompanyCreate', false)
            this.$store.commit('modal',false)

            const getCompanys = this.$store.getters.getMyCompanys
            const countrys = this.$store.getters.getOurCountry
            if(getCompanys!='Sql is empty'){
                getCompanys.forEach((item)=>{
                    // console.log(item)
                    let CompanyPercent = 0
                    let CountryImg =''
                    let CountryName =''
                    for(let i=0; i<countrys.length; i++){
                        if(countrys[i].id == item.jurisdiction){
                            CountryImg='/static/img/flag/'+countrys[i].code.toLowerCase()+'.png'
                            CountryName = countrys[i].jurisdictionname
                            // console.log(CountryImg,CountryName)
                        }
                    }
                    let data = JSON.parse(item.companyStatus)
                    if(data.general==100){
                        CompanyPercent = CompanyPercent+25
                    }else if(data.general>=50&&data.general<=100){
                        CompanyPercent = CompanyPercent+5
                    }else if(data.general<50){
                        CompanyPercent = CompanyPercent+0.25
                    }
                    if(data.ubo==100){
                        CompanyPercent = CompanyPercent+25
                    }else if(data.ubo>=50&&data.ubo<=100){
                        CompanyPercent = CompanyPercent+5
                    }else if(data.ubo<50){
                        CompanyPercent = CompanyPercent+0.25
                    }
                    if(data.dillegance==100){
                        CompanyPercent = CompanyPercent+25
                    }else if(data.dillegance>=50&&data.dillegance<=100){
                        CompanyPercent = CompanyPercent+5
                    }else if(data.dillegance<50){
                        CompanyPercent = CompanyPercent+0.25
                    }
                    if(data.fatca==100){
                        CompanyPercent = CompanyPercent+25
                    }else if(data.fatca>=50&&data.fatca<=100){
                        CompanyPercent = CompanyPercent+5
                    }else if(data.fatca<50){
                        CompanyPercent = CompanyPercent+0.25
                    }
                    let company = {'CountryImg': CountryImg,'CountryName':CountryName,'datetime':item.datetime,'CompanyName': item.companyName,'CompanyPercent': CompanyPercent, 'id': parseInt(item.id),'docs': item.docs}
                    this.myCompanys.push(company)
                })
            }


        }

    }

</script>

<style scoped lang="sass">
    .add-comp-btn
        margin-top: 55px
</style>