<template>
    <div class="col-sm-6 col-md-4 col-lg-3 comp-card-wrapp">
        <div class="comp-card settings-card box_shadow_hover_roundshadow" id="comp-card-0" data-toggle="modal" data-target="#general_info" @click="generalForm=true">
            <div>
                <div class="comp-card-heading">
                    <h3>GENERAL INFO</h3>
                    <h4>You must add more  company info</h4>
                </div>
                <div class="centrize">
                    <div class="doughnut">
                        <DoughnutChart :percent="Number(generalStatus)" :foregroundColor="ChartColor(generalStatus)" :backgroundColor="this.chart.backgroundColor" :radius="this.chart.radius" :width="this.chart.width" :height="this.chart.height" :strokeWidth="this.chart.strokeWidth" :visibleValue="this.chart.visibleValue" :classValue="this.chart.classValue"></DoughnutChart>
                        <div class="doughnut_chart_after" :style="ChartStyle(ChartColor(generalStatus))">{{Math.round(generalStatus)}}%</div>
                    </div>
                </div>
            </div>
            <button data-toggle="modal" data-target="#general_info" class="more-details" @click="generalForm=true">Edit</button>
        </div>
        <div class="modal fade settings-modal" :class="{show: generalForm}" id="general_info" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="min-width: 33px;">&times;</button>
                    <div class="modal-body">
                        <h4 class="modal-title text-center">GENERAL INFORMATION FORM</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-wrapper">
                                            <input type="text" class="form-control" :class="[website_status]" required name="comp-website" id="comp_website" v-model="comp_website">
                                            <label for="comp_website" :class="{'label-up': comp_website}">Company Website</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-wrapper">
                                            <input type="text" class="form-control" :class="isEmailValid" required name="comp-email" id="comp_email" v-model="comp_email">
                                            <label for="comp_email" :class="{'label-up': comp_email}">Company Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-wrapper">
                                            <input type="text" class="form-control" :class="[comp_addr ? inputOk: inputErr]" required name="comp-addr" id="comp_addr" v-model="comp_addr">
                                            <label for="comp_addr" :class="{'label-up': comp_addr}">Company address</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-wrapper">
                                            <select class="form-control" :class="[comp_type != null && comp_type != '0' ? inputOk : inputErr]" required name="comp-type" id="comp_type" v-model="comp_type">
                                                <option value="0"></option>
                                                <option value="1">Social Media Marketing</option>
                                                <option value="2">HR Services and Recruiting</option>
                                                <option value="3">Business Consulting</option>
                                                <option value="4">Tutoring and Professional Training</option>
                                                <option value="5">Construction Business</option>
                                                <option value="6">Web Services and Hosting</option>
                                                <option value="7">Translation Services</option>
                                                <option value="8">Hospitality Services</option>
                                                <option value="9">Affiliate Marketing</option>
                                                <option value="10">Rental Services</option>
                                                <option value="11">Event Management</option>
                                                <option value="12">Retail Shop</option>
                                                <option value="13">Legal Services</option>
                                                <option value="14">Accounting Services</option>
                                                <option value="15">Other</option>
                                            </select>
                                            <label for="comp_type" :class="{'label-up': comp_type!='0'}">Company Type</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6" v-if="comp_type==15">
                                        <div class="input-wrapper">
                                            <input type="text" class="form-control" :class="[other_comp_type!='' ? inputOk: inputErr]" required name="other_comp_type" id="other_comp_type" v-model="other_comp_type">
                                            <label for="other_comp_type" :class="{'label-up': other_comp_type}">Other Company Type</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-wrapper">
                                            <input type="text" class="form-control" :class="[AuthorizedShareCapital>=1000 ? inputOk: inputErr]" required id="authorized-capital" v-model="AuthorizedShareCapital">
                                            <label for="authorized-capital" :class="{'label-up': AuthorizedShareCapital}">Authorized Share Capital</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-wrapper">
                                            <input type="text" class="form-control" :class="[IssuedShareCapitalValid? inputOk: inputErr]" required id="share-value" v-model="IssuedShareCapital">
                                            <label for="share-value" :class="{'label-up': IssuedShareCapital}">Issued Share Capital</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-wrapper">
                                            <input type="text" class="form-control" :class="[OrdinaryShareValid? inputOk: inputErr]" required id="issued-capital" v-model="OrdinaryShare">
                                            <label for="issued-capital" :class="{'label-up': OrdinaryShare}">Value of 1 Ordinary Share</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="button" style="text-transform: unset; padding: 9px; width: 100%;">I want other class of shares</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <p style="text-align: left;">Share capital <br>The proposed Authorized capital of the company is usually expressed in <span class="text_accent">Jurisdiction local Currency</span>. Stamp Duty is payable and calculated on the basis of the value of the nominal capital.<br><span class="text_accent">A minimum of 1 share must be issued.</span></p>
                                <p style="text-align: left;">Unless we are otherwise instructed, the company will be incorporated with an authorized & issued share capital of 1.000 divided into 1.000 <span class="text_accent">ORDINARY</span> shares of 1 Jurisdiction Currency each.</p>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-wrapper">
                                    <textarea name="" id="general-msg" cols="30" rows="3" class="form-control" :class="[ActivitiesLenght>200 ? inputOk: inputErr]" v-model="Activities"></textarea>
                                    <label for="general-msg" :class="{'label-up': Activities!=''}">Main Activities And Nature Of Company</label>
                                </div>
                                <div class="input-wrapper">
                                    <vselect :options="allCountry()" class="form-control" :class="[countryUndertaken!='' ? inputOk: inputErr]" v-model="countryUndertaken" id="countryUndertaken" :searchable="true" :multiple="true"></vselect>
                                    <label for="countryUndertaken" class="label_up" style="left: 7px;">Country/countries where activity is to be undertaken</label>
                                </div>
                            </div>

                        </div>
                        <!--<div class="row">-->
                            <!--<div class="col-md-12">-->
                                <!--<vselect :options="sicCodes" id="sicCodes" v-model="sic" :multiple="true" :searchable="true" @change="checkSic()" :class="[sic.length>0 && sic.length<=4 ? inputOk: inputErr]"></vselect>-->
                                <!--<label for="sicCodes" :class="{'label_up': sic.length>0}">Select a SIC Codes</label>-->
                            <!--</div>-->
                            <!--<div class="col-md-12 text_accent" v-if="sicMess!=''">{{sicMess}}</div>-->
                        <!--</div>-->
                        <transition name="fade">
                            <button class="submit popup-submit" :disabled="generalCheckData" @click="saveGeneral" data-dismiss="modal">save and continue</button>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import DoughnutChart from 'vue-doughnut-chart'
    import vselect from 'vue-select'
    import addImage from '@/components/addImage'

    export default {
        name: "general",
        data(){
            return{
                reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
                inputOk: 'valid',
                inputErr: 'err',
                labelCaptionUp: 'label-up',
                chart: {
                    percent: 0,
                    foregroundColor: "red",
                    backgroundColor: "transperent",
                    radius: 90,
                    width: 140,
                    height: 140,
                    strokeWidth: 20,
                    visibleValue: false,
                    classValue: "percent"
                },
                company: '',
                resStatus: '',
                generalStatus:'',
                generalForm: false,
                comp_website_status: false,
                sicCodes:[],
                sic: [],
                sicMess: '',
            }
        },
        methods:{
            isInteger(num) {
                return (num ^ 0) === num;
            },
            saveGeneral() {
                let fd = new FormData
                let siccode = []
                this.sic.forEach(row=>{
                    siccode.push(row.index)
                })
                let sic = siccode.join(',')
                let countryUndertaken = this.countryUndertaken
                let undertaken = []
                countryUndertaken.forEach(country=>{
                    undertaken.push(country.index)
                })
                let cu = undertaken.join(',')
                fd.append('CompanyWebsite', this.comp_website)
                fd.append('CompanyEmail', this.comp_email)
                fd.append('AuthorizedShareCapital', this.AuthorizedShareCapital)
                fd.append('IssuedShareCapital', this.IssuedShareCapital)
                fd.append('OrdinaryShare', this.OrdinaryShare)
                fd.append('activities', this.Activities)
                fd.append('CompanyAddress', this.comp_addr)
                fd.append('CompanyType', this.comp_type)
                fd.append('CompanyTypeOther', this.other_comp_type)
                fd.append('companyStatus', 'general=100')
                fd.append('countryUndertaken', cu)
                fd.append('updateCompany', this.$route.params.id)
                fd.append('sic_codes', sic)
                axios.post(this.$store.getters.getPostUrl, fd).then((res) => {
                    // console.log(res.data)
                    if(res.data.mess=='Sql UPDATE is ok'){
                        this.generalForm =false
                        this.generalStatus = 100
                        let newfd = new FormData
                        newfd.append('myCompanys', this.$store.getters.get_id)
                        axios.post(this.$store.getters.getPostUrl,newfd).then((res)=>{
                            this.$store.commit('setMyCompanys',res.data)
                        })
                    }
                })
            },
            ChartColor(percent) {
                let color = ''
                if (percent >= 0 && percent <= 12) {
                    color = "#c53312"
                } else if (percent > 12 && percent <= 25) {
                    color = '#c53312'
                } else if (percent > 25 && percent <= 37) {
                    color = '#ee5d11'
                } else if (percent > 37 && percent <= 50) {
                    color = '#ff9e00'
                } else if (percent > 50 && percent <= 62) {
                    color = '#dad00b'
                } else if (percent > 62 && percent <= 75) {
                    color = '#c5e204'
                } else if (percent > 75 && percent <= 87) {
                    color = '#62e502'
                } else if (percent > 87) {
                    color = '#54ff00'
                }
                return color
            },
            ChartStyle(color) {
                return 'background-color:' + color + ';'
            },
            checkSic(){
                if(this.sic.length>4){
                    this.sicMess = 'Please remove SIC code, Max 4 SIC Codes'
                }else{
                    this.sicMess = '';
                }
            },
            allCountry(){
                let countrys = this.$store.getters.getAllCountry
                let SelCountry = []
                SelCountry.push({'index': 'all','label': 'All Country'})
                countrys.forEach(country=>{
                    let c = {'index': country.id,'label': country.jurisdictionname}
                    SelCountry.push(c)
                })
                return SelCountry
            },
        },
        components: {
            DoughnutChart,
            vselect,
        },
        computed:{
            comp_website:{
                get(){
                    this.comp_website_status = 'wait'
                    axios.post(this.$store.getters.getPostUrl,'checkwebsite='+this.$store.getters.getEditCompany_website)
                        .then((res)=>{
                            this.comp_website_status = res.data.nsrecord
                        })
                    return this.$store.getters.getEditCompany_website
                },
                set(value){
                    this.$store.commit('setEditCompany_website', value)
                }
            },
            website_status(){
                if(this.comp_website_status=='wait'){
                    return 'loading'
                }else if(this.comp_website_status=='exist'){
                    return 'valid'
                }else{
                    return 'err'
                }
            },
            comp_email:{
                get(){
                    return this.$store.getters.getEditCompany_email
                },
                set(value){
                    this.$store.commit('setEditCompany_email', value)
                }
            },
            comp_addr:{
                get(){
                    return this.$store.getters.getEditCompany_addr
                },
                set(value){
                    this.$store.commit('setEditCompany_addr', value)
                }
            },
            comp_type:{
                get(){
                    return this.$store.getters.getEditCompany_type
                },
                set(value){
                    this.$store.commit('setEditCompany_type', value)
                }
            },
            other_comp_type:{
                get(){
                    return this.$store.getters.getEditCompany_other_type
                },
                set(value){
                    this.$store.commit('setEditCompany_other_type', value)
                }
            },
            AuthorizedShareCapital:{
                get(){
                    return this.$store.getters.getEditCompany_AuthorizedShareCapital
                },
                set(value){
                    this.$store.commit('setEditCompany_AuthorizedShareCapital', value)
                }
            },
            OrdinaryShare:{
                get(){
                    return this.$store.getters.getEditCompany_OrdinaryShare
                },
                set(value){
                    this.$store.commit('setEditCompany_OrdinaryShare', value)
                }
            },
            IssuedShareCapital:{
                get(){
                    return this.$store.getters.getEditCompany_IssuedShareCapital
                },
                set(value){
                    this.$store.commit('setEditCompany_IssuedShareCapital', value)
                }
            },
            Activities: {
                get(){
                    return this.$store.getters.getEditCompany_Activities
                },
                set(value){
                    this.$store.commit('setEditCompany_ActivitiesLenght', value.length)
                    this.$store.commit('setEditCompany_Activities', value)
                }
            },
            ActivitiesLenght:{
                get(){
                    return this.$store.getters.getEditCompany_ActivitiesLenght
                },
                set(value){
                    this.$store.commit('setEditCompany_ActivitiesLenght', value)
                }
            },
            countryUndertaken:{
                get(){
                    return this.$store.getters.getEditCompany_countryUndertaken
                },
                set(value){
                    this.$store.commit('setEditCompany_countryUndertaken', value)
                }
            },
            OrdinaryShareValid() {
                if (this.OrdinaryShare <= this.IssuedShareCapital) {
                    let val = this.IssuedShareCapital / this.OrdinaryShare
                    if (this.OrdinaryShare > 0 && this.isInteger(val) == true) {
                        return true
                    } else {
                        return false
                    }
                } else {
                    return false
                }
            },
            IssuedShareCapitalValid(){
                if(this.IssuedShareCapital<=this.AuthorizedShareCapital){
                    if(this.IssuedShareCapital>0){
                        return true
                    }else{
                        return false
                    }
                }else{
                    return false
                }
            },
            isEmailValid(){
                return (this.comp_email == "")? "" : (this.reg.test(this.comp_email)) ? 'valid' : 'err'
            },
            generalCheckData(){
                if(this.comp_website!='' && this.isEmailValid=='valid' &&this.comp_addr!='' && this.comp_type!='' && this.countryUndertaken!=''
                    && this.AuthorizedShareCapital>=1000 && this.OrdinaryShareValid==true && this.IssuedShareCapitalValid==true && this.Activities!=''){
                    if(this.comp_type==15){
                        if(this.other_comp_type!='') {
                            return false
                        }else{
                            return true
                        }
                    }else{
                        return false
                    }
                }else{
                    return true
                }
            },
            companyStatus(data){
                this.CompanyPercent=0
                data = JSON.parse(data)
                // console.log(data)
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

        },
        mounted(){
            let id = this.$route.params.id
            const MyCompanys = this.$store.getters.getMyCompanys
            MyCompanys.forEach((item)=>{
                if(item.id == id){
                    this.$store.commit('setEditCompany_Activities', item.activities)
                    this.$store.commit('setEditCompany_IssuedShareCapital', item.IssuedShareCapital)
                    this.$store.commit('setEditCompany_OrdinaryShare', item.OrdinaryShare)
                    this.$store.commit('setEditCompany_AuthorizedShareCapital', item.AuthorizedShareCapital)
                    this.$store.commit('setEditCompany_other_type', item.CompanyTypeOther)
                    this.$store.commit('setEditCompany_type', item.CompanyType)
                    this.$store.commit('setEditCompany_addr', item.CompanyAddress)
                    this.$store.commit('setEditCompany_email', item.CompanyEmail)
                    this.$store.commit('setEditCompany_website', item.CompanyWebsite)
                    this.countryUndertaken = item.countryUndertaken
                    let status = JSON.parse(item.companyStatus)
                    this.generalStatus = parseInt(status.general)
                    this.companyName= item.companyName
                    if(item.sic_codes!= null){
                        let sicCodes = this.$store.getters.get_sicCode
                        let code = item.sic_codes.split(',')
                        code.forEach(row=>{
                            sicCodes.forEach(sic=>{
                                if(sic.index==row){
                                    this.sic.push(sic)
                                }
                            })
                        })
                    }

                }
            })
            this.sicCodes = this.$store.getters.get_sicCode
        }

    }

</script>

<style scoped lang="sass">
    .add-comp-btn
        margin-top: 55px
        .companys_company
            height: 293px
        .modal-container
            max-width: 1200px
            width: 90% !important
            max-height: 90vh !important
        .modal-container-scroll
            overflow: scroll
            height: 80vh
        .modal-mask
            width: 100%
            height: 100%
        .modal-wrapper
            width: 100%
            height: 100%
        p.small
            text-align: left
        h4
            font-size: .91em
            text-align: center
            margin: 10px
        h5
            margin: 8px
            font-size: 1.25em
        .companys_header_top
            font-size: 1em
</style>