<template>
    <div class="preload" v-if="preload">
        <div class="dash uno"></div>
        <div class="dash dos"></div>
        <div class="dash tres"></div>
        <div class="dash cuatro"></div>
    </div>
    <div style="position: relative;" v-else>
        <div class="container">
            <div class="tripple">
                <div class="border padding">
                    <h2 class="box_header">Account Details</h2>
                    <div class="input_group">
                        <input type="email" id='email' :class='[isEmailValid()]' v-model="email" tabindex="1" autofocus >
                        <label for="email" >Email</label>
                    </div>
                    <div class="input_group">
                        <select id="CompanyCountry"  :class="[CompanyCountryCode!='' ? okClass: errorClass]" v-model="CompanyCountryCode" tabindex="2">
                            <option :value="item.code" v-for="item in ourCountry" @click="selectCountry(item.id)">{{item.label}}</option>
                        </select>
                        <label for="CompanyCountry">Select Country</label>
                    </div>
                    <div class="input_group">
                        <select name="" id="packages" :class="[packages!='' ? okClass : errorClass]" v-model="packages" tabindex="3" :disabled="CompanyCountryCode==''">
                            <option :value="pack.index" v-for="pack in pakageList">{{pack.label}}</option>
                        </select>
                        <label for="packages">Packages</label>
                    </div>
                    <div class="input_group">
                        <input type="text" id='companyName' :class="[companyName!='' ? okClass : errorClass]" v-model="companyName" tabindex="4">
                        <label for="companyName">Company Name</label>
                    </div>
                    <div class="input_group" style="display: flex; justify-content: center;">
                        <button v-if='CheckNameData.status==""' class="button" tabindex="5" :disabled="(companyName==''&&CompanyCountryCode=='')" @click.prevent="checkName">Check Availability</button>
                        <button v-else-if="CheckNameData.status=='wait'" class="button" tabindex="5" disabled="disabled">Wait</button>
                        <button v-else-if="CheckNameData.status=='ok'" class="button confirm" tabindex="5">Available</button>
                        <button v-else-if="CheckNameData.status=='err'" class="button notConfirm" tabindex="5">Not Available</button>
                    </div>



                </div>
                <div class='border padding'>
                    <h2 class='box_header'>Personal Info</h2>
                    <div class="duble_side_box">
                        <div class="left">
                            <div class="input_group">
                                <input type="text" id='firstname' :class='[firstName ? okClass : errorClass]' v-model="firstName" autofocus required tabindex="6">
                                <label for="firstname">First Name</label>
                            </div>

                            <div class="input_group">
                                <input type="text" id='City' :class='[City ? okClass : errorClass]' v-model="City" tabindex="8" required>
                                <label for="City">City</label>
                            </div>
                            <div class="input_group">
                                <input type="text" id='zip' :class='[zip_code ? okClass : errorClass]' v-model="zip_code" tabindex="10" required>
                                <label for="zip">Zip code</label>
                            </div>
                        </div>
                        <div class="right">
                            <div class="input_group">
                                <input type="text" id='lastname' :class='[lastName ? okClass : errorClass]' v-model="lastName" tabindex="7" required>
                                <label for="lastname">Last Name</label>
                            </div>
                            <div class="input_group">
                                <input type="text" id='phone' :class='[phone_valid ? okClass : errorClass]' v-model="phone" tabindex="9" required @change="checkPhone">
                                <label for="phone">Phone</label>
                            </div>
                            <div class="input_group">
                                <!--<vueSelect :options="allCounty" placeholder="Select a Country" label="label" v-model="Country" :searchable="true" :clearable="false" id="Country"></vueSelect>-->
                                <select v-model="Country" id="Country" :class="[Country ? okClass:errorClass]" placeholder="Enter Country" tabindex="11">
                                    <option :value="item.id" v-for="item in allCounty">{{item.label}}</option>
                                </select>
                                <label for="Country">Country</label>
                            </div>
                            <div class="input_group">
                                <input type="text" id='State' :class='[State ? okClass : errorClass]' v-model="State" tabindex="12" required>
                                <label for="State">State</label>
                            </div>

                        </div>
                    </div>
                </div>
                <div class='border padding'>
                    <h2 class="box_header">Billing Details</h2>
                    <div class="duble_side_box">
                        <div class="left">
                            <div class="input_group">
                                <input type="text" id='billfirstname' :class="[billfirstname ? okClass:errorClass]" v-model="billfirstname" tabindex="13">
                                <label for="billfirstname">First Name</label>
                            </div>
                            <div class="input_group">
                                <input type="text" id='billCity'  :class="[billCity ? okClass:errorClass]" v-model="billCity" tabindex="15">
                                <label for="billCity">City</label>
                            </div>
                            <div class="input_group">
                                <input type="text" id='billzip'  :class="[billzip ? okClass:errorClass]" v-model="billzip" tabindex="17">
                                <label for="billzip">Zip code</label>
                            </div>
                            <div class="input_group">
                                <input type="text" id='billaddress1'  :class="[billaddress1 ? okClass:errorClass]" v-model="billaddress1" tabindex="19">
                                <label for="billaddress1">Address 1</label>
                            </div>

                        </div >
                        <div class="right">
                            <div class="input_group">
                                <input type="text"  id='billlastname' :class="[billlastname ? okClass:errorClass]" v-model="billlastname" tabindex="14">
                                <label for="billlastname">Last Name</label>
                            </div>
                            <div class="input_group">
                                <!--<vueSelect :options="allCounty" placeholder="Select a Country" label="label" v-model="Country" :searchable="true" :clearable="false" id="Country"></vueSelect>-->
                                <select id="billCountry" :class="[billCountry ? okClass:errorClass]" v-model="billCountry" tabindex="16" placeholder="Enter Billing Country">
                                    <option :value="item.id" v-for="item in allCounty">{{item.label}}</option>
                                </select>
                                <label for="billCountry">Country</label>
                            </div>
                            <div class="input_group">
                                <input type="text" id='billState' :class="[billState ? okClass:errorClass]" v-model="billState"  tabindex="18">
                                <label for="billState">State</label>
                            </div>
                            <div class="input_group">
                                <input type="text" id='billaddress2' :class="[billaddress2 ? okClass:errorClass]" v-model="billaddress2"  tabindex="20">
                                <label for="billaddress2">Address 2</label>
                            </div>
                        </div >
                    </div>

                </div>
            </div>
            <div class="input_group" style="display: flex; justify-content: flex-end; align-items: end;">
                <div><p :class="[mess=='Update Success' ? text_ok: text_err]" v-if="mess!=''">{{mess}}</p></div>
                <button class="button" @click="" tabindex="21" :disabled="checkAddApplicant" @click.prevent="addCompany">SAVE COMPANY</button>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: "addcompany",
        data(){
            return{
                confirmClass: 'confirm',
                notConfirmClass: 'notConfirm',
                okClass: 'ok',
                errorClass: 'err',
                text_ok: 'text_ok',
                text_err: 'text_err',
                mess:'',
                reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
                ourCountry: [],
                allCounty:[],
                CheckNameData: {
                    server: '',
                    api: '',
                    status: '',
                },
                pakageList: ['Basic','Standart','Premium','Ultimate']
            }
        },
        methods: {
            modalShow(){
                this.$store.commit('modal', true)
            },
            modalClose(){
                this.$store.commit('modal', false)
                this.page= ''
            },
            get_applicant_PackagePrice(name){
                if(name=='Basic'){
                    return this.$store.state.manager.newCompany.applicant_Price.Basic
                }else if(name=='Standart'){
                    return this.$store.state.manager.newCompany.applicant_Price.Standart
                }else if(name=='Premium'){
                    return this.$store.state.manager.newCompany.applicant_Price.Premium
                }else if(name=='Ultimate'){
                    return this.$store.state.manager.newCompany.applicant_Price.Ultimate
                }
            },
            checkName(){
                this.CheckNameData.status='wait'
                let fd = new FormData
                fd.append('CheckCompanyName', this.companyName)
                fd.append('CheckCompanyCountry', this.CompanyCountry)
                axios.post(this.$store.getters.getPostUrl, fd).then((res)=>{
                    this.CheckNameData.server = res.data.server.info
                    this.CheckNameData.api = res.data.api.count
                    if(res.data.server.info=='found'||res.data.api.count>0){
                        this.CheckNameData.status='err'
                    }else{
                        this.CheckNameData.status='ok'
                    }
                })
            },
            checkPhone(){
                axios.get('http://apilayer.net/api/validate?access_key=b0d668b30957a7b8b63149412ee30ab5&number='+phone.value+'&country_code=&format=0')
                    .then((res)=>{
                        this.phone_carrier = res.data.carrier
                        this.phone_country_code = res.data.country_code
                        this.phone_country_name = res.data.country_name
                        this.phone_country_prefix = res.data.country_prefix
                        this.phone_international_format = res.data.international_format
                        this.phone_line_type = res.data.line_type
                        this.phone_local_format = res.data.local_format
                        this.phone_location = res.data.location
                        this.phone_number = res.data.number
                        this.phone_valid = res.data.valid
                    })
            },
            isEmailValid(){
                return (this.email == "")? "" : (this.reg.test(this.email)) ? 'ok' : 'err'
            },
            clearForm(){
                this.email = ''
                this.firstName = ''
                this.City = ''
                this.zip_code = ''
                this.lastName = ''
                this.phone = ''
                this.Country = ''
                this.CompanyCountryCode = ''
                this.State = ''
                this.billfirstname = ''
                this.billCity = ''
                this.billzip = ''
                this.billaddress1 = ''
                this.billlastname = ''
                this.billCountry = ''
                this.billState = ''
                this.billaddress2 = ''
                this.phone_carrier = ''
                this.phone_country_code = ''
                this.phone_country_name = ''
                this.phone_country_prefix = ''
                this.phone_international_format = ''
                this.phone_line_type = ''
                this.phone_local_format = ''
                this.phone_location = ''
                this.phone_number = ''
                this.phone_valid = ''
                this.packages = ''
                this.companyName = ''
                this.billfirstname = ''
                this.billCity = ''
                this.billzip = ''
                this.billaddress1 = ''
                this.billlastname = ''
                this.billCountry = ''
                this.billState = ''
                this.billaddress2 = ''
            },
            addCompany(){
                let fd = new FormData
                fd.append('email', this.email)
                fd.append('firstName', this.firstName)
                fd.append('lastName', this.City)
                fd.append('phone', this.zip_code)
                fd.append('City', this.lastName)
                fd.append('zip_code', this.phone)
                fd.append('Country', this.Country)
                fd.append('State', this.State)
                fd.append('billfirstname' , this.billfirstname)
                fd.append('billCity' , this.billCity)
                fd.append('billzip' , this.billzip)
                fd.append('billaddress1' , this.billaddress1)
                fd.append('billlastname' , this.billlastname)
                fd.append('billCountry' , this.billCountry)
                fd.append('billState' , this.billState)
                fd.append('billaddress2' , this.billaddress2)
                fd.append('phone_carrier' , this.phone_carrier)
                fd.append('phone_country_code' , this.phone_country_code)
                fd.append('phone_country_name' , this.phone_country_name)
                fd.append('phone_country_prefix' , this.phone_country_prefix)
                fd.append('phone_international_format' , this.phone_international_format)
                fd.append('phone_line_type' , this.phone_line_type)
                fd.append('phone_local_format' , this.phone_local_format)
                fd.append('phone_location' , this.phone_location)
                fd.append('phone_number' , this.phone_number)
                fd.append('phone_valid' , this.phone_valid)
                fd.append('register','managerApplicantRegister')
                axios.post(this.$store.getters.getPostUrl, fd)
                    .then((res)=>{
                        // console.log(res.data)
                        this.mess=res.data.email+'.'
                        if(res.data.mess=='Sql INSERT is ok'){
                            let fd=new FormData
                            fd.append('package', this.packages)
                            fd.append('packageSum', this.get_applicant_PackagePrice(this.packages))
                            fd.append('totalPrice', this.get_applicant_PackagePrice(this.packages))
                            fd.append('jurisdiction', this.$store.getters.get_applicant_CompanyJurisdictionId)
                            fd.append('companyName', this.companyName)
                            fd.append('billFirstName', this.billfirstname)
                            fd.append('billCity', this.billCity)
                            fd.append('billZipcode', this.billzip)
                            fd.append('billAddress1', this.billaddress1)
                            fd.append('billLastName', this.billlastname)
                            fd.append('billCountry', this.billCountry)
                            fd.append('billState', this.billState)
                            fd.append('billAddress2', this.billaddress2)
                            fd.append('applicantid', res.data.id)
                            fd.append('createCompany', 'create')
                            axios.post(this.$store.getters.getPostUrl,fd)
                                .then((res)=>{
                                    // console.log(res.data)
                                    if(res.data.mess=='Sql INSERT is ok'){
                                        this.mess = this.mess+' Company is created'
                                        this.clearForm();
                                        setTimeout(()=>{
                                            this.mess=''
                                        },10000)
                                    }

                                })
                        }
                    })





                //
            },
        },
        computed: {
            imgSrc() {
                if(this.CompanyCountryCode!=''){
                    return '/static/img/flag/'+this.CompanyCountryCode.toLowerCase()+'.png'
                }
            },
            CompanyCountryCode:{
                get(){
                    return this.$store.getters.get_applicant_CompanyCountryCode
                },
                set(value){
                    let val=''
                    let ourCountry = this.$store.getters.getOurCountry
                    let id,Basic,Standart,Premium,Ultimate = null
                    for(let i=0; i<ourCountry.length; i++){
                        if(ourCountry[i].code==value){
                            // console.log(ourCountry[i])
                            val= ourCountry[i].jurisdictionname
                            id = ourCountry[i].id
                            Basic = ourCountry[i].basicPrice
                            Standart = ourCountry[i].standartPrice
                            Premium = ourCountry[i].premiumPrice
                            Ultimate = ourCountry[i].ultimatePrice
                        }
                    }
                    this.$store.commit('set_applicant_CompanyJurisdictionId', id)
                    this.$store.commit('set_applicant_CompanyCountry', val);
                    this.$store.commit('set_applicant_CompanyCountryCode', value);
                    this.$store.commit('set_applicant_Price_Basic',Basic)
                    this.$store.commit('set_applicant_Price_Standart',Standart)
                    this.$store.commit('set_applicant_Price_Premium',Premium)
                    this.$store.commit('set_applicant_Price_Ultimate',Ultimate)
                    this.pakageList = []
                    this.pakageList = [{index: 'Basic',label:'Basic €'+Basic},{index:'Standart',label:'Standart €'+Standart},{index:'Premium',label:'Premium €'+Premium},{index:'Ultimate',label:'Ultimate €'+Ultimate}]
                }
            },
            email:{
                get(){
                    return this.$store.getters.get_applicant_Email
                },
                set(newValue){
                    this.$store.commit('set_applicant_Email', newValue)
                }
            },
            CompanyCountry:{
                get(){
                    return this.$store.getters.get_applicant_CompanyCountry
                },
                set(){
                    let Country=''
                    for(let i=0; i<this.$store.getters.ourCountry.length; i++){
                        if(this.$store.getters.ourCountry[i].code==this.CompanyCountryCode){
                            Country=this.$store.getters.ourCountry[i].jurisdictionname
                        }
                    }
                    this.$store.commit('set_applicant_CompanyCountry', Country);
                }
            },
            packages:{
                get(){
                    return this.$store.getters.get_applicant_packages
                },
                set(newValue){
                    this.$store.commit('set_applicant_packages', newValue)
                }
            },
            companyName:{
                get(){
                    return this.$store.getters.get_applicant_companyName
                },
                set(newValue){
                    this.CheckNameData.status=''
                    this.$store.commit('set_applicant_companyName', newValue)
                }
            },
            firstName:{
                get(){
                    return this.$store.getters.get_applicant_firstName
                },
                set(newValue){
                    this.$store.commit('set_applicant_firstName', newValue)
                }
            },
            City:{
                get(){
                    return this.$store.getters.get_applicant_City
                },
                set(newValue){
                    this.$store.commit('set_applicant_City', newValue)
                }
            },
            zip_code:{
                get(){
                    return this.$store.getters.get_applicant_zip_code
                },
                set(newValue){
                    this.$store.commit('set_applicant_zip_code', newValue)
                }
            },
            lastName:{
                get(){
                    return this.$store.getters.get_applicant_lastName
                },
                set(newValue){
                    this.$store.commit('set_applicant_lastName', newValue)
                }
            },
            phone:{
                get(){
                    return this.$store.getters.get_applicant_phone
                },
                set(newValue){
                    this.$store.commit('set_applicant_phone', newValue)
                }
            },
            Country:{
                get(){
                    return this.$store.getters.get_applicant_Country
                },
                set(newValue){
                    this.$store.commit('set_applicant_Country', newValue)
                }
            },
            State:{
                get(){
                    return this.$store.getters.get_applicant_State
                },
                set(newValue){
                    this.$store.commit('set_applicant_State', newValue)
                }
            },
            billfirstname:{
                get(){
                    return this.$store.getters.get_applicant_billfirstname
                },
                set(newValue){
                    this.$store.commit('set_applicant_billfirstname', newValue)
                }
            },
            billCity:{
                get(){
                    return this.$store.getters.get_applicant_billCity
                },
                set(newValue){
                    this.$store.commit('set_applicant_billCity', newValue)
                }
            },
            billzip:{
                get(){
                    return this.$store.getters.get_applicant_billzip
                },
                set(newValue){
                    this.$store.commit('set_applicant_billzip', newValue)
                }
            },
            billaddress1:{
                get(){
                    return this.$store.getters.get_applicant_billaddress1
                },
                set(newValue){
                    this.$store.commit('set_applicant_billaddress1', newValue)
                }
            },
            billlastname:{
                get(){
                    return this.$store.getters.get_applicant_billlastname
                },
                set(newValue){
                    this.$store.commit('set_applicant_billlastname', newValue)
                }
            },
            billCountry:{
                get(){
                    return this.$store.getters.get_applicant_billCountry
                },
                set(newValue){
                    this.$store.commit('set_applicant_billCountry', newValue)
                }
            },
            billState:{
                get(){
                    return this.$store.getters.get_applicant_billState
                },
                set(newValue){
                    this.$store.commit('set_applicant_billState', newValue)
                }
            },
            billaddress2:{
                get(){
                    return this.$store.getters.get_applicant_billaddress2
                },
                set(newValue){
                    this.$store.commit('set_applicant_billaddress2', newValue)
                }
            },
            preload:{
                get(){
                    return this.$store.getters.preload
                },
                set(val){
                    this.$store.commit('preload',val)
                }
            },
            phone_carrier:{
                get(){
                    return this.$store.getters.get_applicant_phone_carrier
                },
                set(newValue){
                    this.$store.commit('set_applicant_phone_carrier', newValue)
                }
            },
            phone_country_code:{
                get(){
                    return this.$store.getters.get_applicant_phone_country_code
                },
                set(newValue){
                    this.$store.commit('set_applicant_phone_country_code', newValue)
                }
            },
            phone_country_name:{
                get(){
                    return this.$store.getters.get_applicant_phone_country_name
                },
                set(newValue){
                    this.$store.commit('set_applicant_phone_country_name', newValue)
                }
            },
            phone_country_prefix:{
                get(){
                    return this.$store.getters.get_applicant_phone_country_prefix
                },
                set(newValue){
                    this.$store.commit('set_applicant_phone_country_prefix', newValue)
                }
            },
            phone_international_format:{
                get(){
                    return this.$store.getters.get_applicant_phone_international_format
                },
                set(newValue){
                    this.$store.commit('set_applicant_phone_international_format', newValue)
                }
            },
            phone_line_type:{
                get(){
                    return this.$store.getters.get_applicant_phone_line_type
                },
                set(newValue){
                    this.$store.commit('set_applicant_phone_line_type', newValue)
                }
            },
            phone_local_format:{
                get(){
                    return this.$store.getters.get_applicant_phone_local_format
                },
                set(newValue){
                    this.$store.commit('set_applicant_phone_local_format', newValue)
                }
            },
            phone_location:{
                get(){
                    return this.$store.getters.get_applicant_phone_location
                },
                set(newValue){
                    this.$store.commit('set_applicant_phone_location', newValue)
                }
            },
            phone_number:{
                get(){
                    return this.$store.getters.get_applicant_phone_number
                },
                set(newValue){
                    this.$store.commit('set_applicant_phone_number', newValue)
                }
            },
            phone_valid:{
                get(){
                    return this.$store.getters.get_applicant_phone_valid
                },
                set(newValue){
                    this.$store.commit('set_applicant_phone_valid', newValue)
                }
            },
            checkAddApplicant(){
                console.log(this.isEmailValid(),this.CompanyCountryCode,this.packages,this.companyName,this.CheckNameData.status,this.firstName,this.City,this.zip_code,this.lastName,this.phone,this.Country,this.State,this.billfirstname,this.billCity,this.billzip,this.billaddress1,this.billlastname,this.billCountry,this.billState,this.billaddress2)
                if(this.isEmailValid()=='ok'&&
                    this.CompanyCountryCode!=''&&
                    this.packages!=''&&
                    this.companyName!=''&&
                    this.CheckNameData.status=='ok'&&
                    this.firstName!=''&&
                    this.City!=''&&
                    this.zip_code!=''&&
                    this.lastName!=''&&
                    this.phone!=''&&
                    this.Country!=''&&
                    this.State!=''&&
                    this.billfirstname!=''&&
                    this.billCity!=''&&
                    this.billzip!=''&&
                    this.billaddress1!=''&&
                    this.billlastname!=''&&
                    this.billCountry!=''&&
                    this.billState!=''&&
                    this.billaddress2!=''){
                    return false
                }else{
                    return true
                }
            }
        },
        mounted(){
            for(let i=0; i<this.$store.getters.getOurCountry.length; i++){
                let county = this.$store.getters.getOurCountry[i]
                this.ourCountry.push({'label': county.jurisdictionname,'id': county.id, 'code': county.code})
            }
            for(let i=0; i<this.$store.getters.getAllCountry.length; i++){
                let county = this.$store.getters.getAllCountry[i]
                this.allCounty.push({'label': county.jurisdictionname,'id': county.id})
            }
        }
    }
</script>

<style scoped lang="sass">
.countryImg
    position: absolute
    top: 0px
    right: 5px
    width: 34px
    height: 40px
    z-index: 9
.modal-footer
    display: flex
    justify-content: center
#CheckName
    box-sizing: border-box
    border-right: 40px solid #fb9f35
    &.ok
        border-right: 40px solid #1ed75f
    &.err
        border-right: 40px solid #f3300c
.CheckNameLTD
    position: absolute
    top: 12px
    right: 5px
    color: #ffffff
    font-family: "Brandon Grotesque"
    font-weight: bold
    font-size: .9em
    line-height: 1em
    text-transform: uppercase
    cursor: not-allowed
    z-index: 9
.modal-container
    height: auto
    max-height: 100vh
    overflow: scroll
</style>