<template>
    <div>
        <progressBar></progressBar>
        <section class="payment">
            <div v-if="paymentStatus==''">
                <h2>Payment</h2>
                <p>New Company Name: <span>{{this.$store.getters.getCompanyName}}</span></p>
                <p>Country: <span>{{this.$store.getters.getCompanyCountry}}</span><img :src="flagSrc" alt="flag"></p>
                <p>Package: <span>{{this.$store.state.newCompany.package_selected}}</span></p>
                <p>TOTAL: <span class="text_accent">${{this.$store.getters.getTotal}}</span></p>
                <div class="selecter">
                    <transition name="fade"><button :class="{button: CardPay}" @click="CardPay=true">Credit Card</button></transition> | <transition name="fade"><button :class="{button: !CardPay}" @click="CardPay=false">Wire Transfer</button></transition>
                </div>
                <div v-if="CardPay">
                    <div class="infoCards">
                        <div class="card">
                            <h3>Please Enter Your Credit Card Details</h3>
                            <div class="left cards" style="position: relative;top: -38px;left: 20px;">
                                <!--<img src="/static/img/card.png" alt="" class="cardimg">-->
                                <div class="card-wrapper">
                                    <creditCard v-model="AllData" :invertCard="invertCard" style="transform: scale(0.668571);"></creditCard>
                                </div>
                                <!--<transition name="fade">-->
                                <!--<img v-if="srcCardLogo!=null" :src="srcCardLogo" alt="" class="cardlogoimg">-->
                                <!--</transition>-->
                            </div>
                            <div class="right" style="position: relative;top: -16px;">
                                <form action="" class="pay-form">
                                    <div class="input_group col3toCol1">
                                        <div class="col3">
                                            <input type="text" v-model="cardNumber" id="CardNumber" :maxlength="cardLenght" :class="[checkValid ? okClass: errorClass]">
                                            <label for="CardNumber">Card Number</label>
                                        </div>
                                        <div class="col1">
                                            <input type="text" v-model="cvv" :maxlength="cvvLenght" id="cvv" :class="[cvv.length==cvvLenght ? okClass: errorClass]" @focus="onFocus" @blur="onBlur">
                                            <label for="cvv" style="left: 198px;">CVV</label>
                                        </div>
                                    </div>
                                    <div class="input_group col1toCol1">
                                        <div class="col1">
                                            <select id="month" v-model="month" :class="[month!='' ? okClass: errorClass]">
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                            <label for="month">Month</label>
                                        </div>
                                        <div class="toCol1">
                                            <select id="year" v-model="year" :class="[year!='' ? okClass: errorClass]">
                                                <option :value="item" v-for="item in years" >{{item}}</option>
                                            </select>
                                            <label for="year">Year</label>
                                        </div>
                                    </div>
                                    <div class="input_group">
                                        <input type="text" id="holder" v-model="holder" :class="[holder.length>2 ? okClass: errorClass]">
                                        <label for="holder">Full Name</label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class='card'>
                            <h3>Billing Details of this company</h3>
                            <div class="input_group billingCheck">
                                <div class="checkbox small duble" id="sameAsApplicant" :class="[sameAsApplicant ? activeClass: notActive]" @click="sameAs" style="left: 23px;">
                                    <div class="off_caption">off</div>
                                    <div class="checkbox_body"></div>
                                    <div class="checkbox_check">•</div>
                                    <div class="on_caption" style="width: 113px;left: 80px;">Same as User</div>
                                </div>
                            </div>
                            <div class="left">
                                <div class="input_group">
                                    <input type="text" id='billfirstname' :class="[billfirstname ? okClass:errorClass]" v-model="billfirstname" tabindex="10">
                                    <label for="billfirstname">First Name</label>
                                </div>
                                <div class="input_group">
                                    <input type="text" id='billCity'  :class="[billCity ? okClass:errorClass]" v-model="billCity" tabindex="12">
                                    <label for="billCity">City</label>
                                </div>
                                <div class="input_group">
                                    <input type="text" id='billzip'  :class="[billzip ? okClass:errorClass]" v-model="billzip" tabindex="14">
                                    <label for="billzip">Zip code</label>
                                </div>
                                <div class="input_group">
                                    <input type="text" id='billaddress1'  :class="[billaddress1 ? okClass:errorClass]" v-model="billaddress1" tabindex="16">
                                    <label for="billaddress1">Address 1</label>
                                </div>
                            </div>
                            <div class="right">
                                <div class="input_group">
                                    <input type="text" id='billlastname' :class="[billlastname ? okClass:errorClass]" v-model="billlastname" tabindex="11">
                                    <label for="billlastname">Last Name</label>
                                </div>
                                <div class="input_group">
                                    <!--<vueSelect :options="allCounty" placeholder="Select a Country" label="label" v-model="Country" :searchable="true" :clearable="false" id="Country"></vueSelect>-->
                                    <select id="billCountry" :class="[billCountry ? okClass:errorClass]" v-model="billCountry" tabindex="13" placeholder="Enter Billing Country">
                                        <option :value="item.id" v-for="item in this.$store.getters.getAllCountry">{{item.jurisdictionname}}</option>
                                    </select>
                                    <label for="billCountry">Country</label>
                                </div>
                                <div class="input_group">
                                    <input type="text" id='billState' :class="[billState ? okClass:errorClass]" v-model="billState"  tabindex="15">
                                    <label for="billState">State</label>
                                </div>
                                <div class="input_group">
                                    <input type="text" id='billaddress2' :class="[billaddress2 ? okClass:errorClass]" v-model="billaddress2"  tabindex="17">
                                    <label for="billaddress2">Address 2</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hr_footer">
                        <p>TOTAL: <span class="text_accent">$ {{this.$store.getters.getTotal}}</span></p><button class="button" @click="payNow" >PAY NOW</button>
                    </div>
                </div>
                <div v-if="!CardPay">
                    <div class="infoCards" style="display: grid; justify-content: center;">
                        <div class="input_group" style="margin: 10px auto;">
                            <div class="checkbox small duble" :class="[iamPerson ? activeClass: notActive]" @click="person()">
                                <div class="off_caption" style="width: 130px; left: -136px;">I am а Company</div>
                                <div class="checkbox_body"></div>
                                <div class="checkbox_check">•</div>
                                <div class="on_caption" style="width: 113px;">I am а Person</div>
                            </div>
                        </div>
                        <div class="cardWire">
                            <h3>Please Enter Your Credit Card Details</h3>
                            <div v-if="!iamPerson">
                                <div class="input_group">
                                    <input type="text" id="fullname" v-model="wire_fullname">
                                    <label for="fullname">Full name</label>
                                </div>
                                <div class="input_group">
                                    <input type="text" id="regaddress" v-model="wire_regaddress">
                                    <label for="regaddress">Registered address</label>
                                </div>
                                <div class="input_group">
                                    <input type="text" id="regnum" v-model="wire_regnum">
                                    <label for="regnum">Registered number</label>
                                </div>
                                <div class="input_group">
                                    <input type="text" id="emailinvice" v-model="wire_emailinvice">
                                    <label for="emailinvice">Email for invoicing</label>
                                </div>
                            </div>
                            <div v-if="iamPerson">
                                <div class="input_group">
                                    <input type="text" id="personfullname" v-model="wire_fullname">
                                    <label for="personfullname">Full name</label>
                                </div>
                                <div class="input_group">
                                    <input type="text" id="personregaddress" v-model="wire_regaddress">
                                    <label for="personregaddress">Residential address</label>
                                </div>
                                <div class="input_group">
                                    <input type="text" id="personregnum" v-model="wire_regnum">
                                    <label for="personregnum">ID/Passport number</label>
                                </div>
                                <div class="input_group">
                                    <input type="text" id="personemailinvice" v-model="wire_emailinvice">
                                    <label for="personemailinvice">Email for invoicing</label>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <button class="button" @click="">Receive my invoice</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <transition name="modal" v-if="paymentStatus=='success'">
                <div class="modal-mask" >
                    <div class="modal-wrapper" @click.self="close()">
                        <div class="modal-container" style="width: 700px;">
                            <div class="success" style="display: grid; justify-content: center;">
                                <!--<svg version="1.1" class="successImg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"-->
                     <!--viewBox="0 0 511 511" style="enable-background:new 0 0 511 511;" xml:space="preserve">-->
                <!--<linearGradient id="SVGID_1" gradientUnits="userSpaceOnUse" x1="392.7684" y1="41.8535" x2="115.84" y2="521.5076" gradientTransform="matrix(0.998 0 0 -0.998 -9.758174e-02 511.1325)">-->
                    <!--<stop  offset="0" style="stop-color:#1ED75F"/>-->
                    <!--<stop  offset="1" style="stop-color:#DC7200"/>-->
                <!--</linearGradient>-->
                <!--<path class="st0" d="M392.9,338c0-11-8.9-20-20-20h-333V172.7h396.9v81.5c0,11,8.9,20,20,20c11,0,20-8.9,20-20V68.9-->
                    <!--c0-11-8.9-20-20-20H20c-11,0-20,8.9-20,20V338c0,11,8.9,20,20,20h353C384,358,392.9,349,392.9,338z M436.8,88.8v43.9H39.9V88.8-->
                    <!--H436.8z M506.8,335.2L413,455.5c-7.4,9.4-21.4,10.3-29.9,1.8l-40.8-40.8c-7.8-7.8-7.8-20.4,0-28.2c7.8-7.8,20.4-7.8,28.2,0-->
                    <!--l24.8,24.8l79.9-102.4c6.8-8.7,19.3-10.2,28-3.5C512,314,513.6,326.5,506.8,335.2z"/>-->
                <!--</svg>-->
                                <h3>Payment was processed Successfully</h3>
                                <p>Please take some time to complete all subsequent documents.</p>
                                <button class="button confirm" style="width: 300px; margin: 0 auto;" @click="success">GET STARTED</button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
            <transition name="modal" v-if="paymentStatus=='error'">
                <div class="modal-mask" >
                    <div class="modal-wrapper" @click.self="close()">
                        <div class="modal-container" style="width: 700px;">
                            <div class="error" style="display: grid; justify-content: center;">
                                <svg version="1.1" class="errorImg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     viewBox="0 0 542.5 511" style="enable-background:new 0 0 542.5 511;" xml:space="preserve">
                <linearGradient id="SVGID_2" gradientUnits="userSpaceOnUse" x1="589.5192" y1="330.4499" x2="144.294" y2="-76.1229" gradientTransform="matrix(-0.1286 0.9897 0.9897 0.1286 185.7325 -138.8595)">
                    <stop  offset="0" style="stop-color:#BF0015"/>
                    <stop  offset="9.693617e-02" style="stop-color:#C51711"/>
                    <stop  offset="0.2626" style="stop-color:#CD380B"/>
                    <stop  offset="0.4334" style="stop-color:#D45106"/>
                    <stop  offset="0.6094" style="stop-color:#D86403"/>
                    <stop  offset="0.7937" style="stop-color:#DB6E01"/>
                    <stop  offset="1" style="stop-color:#DC7200"/>
                </linearGradient>
                <path class="st0" d="M436.8,88.8v43.9H39.9V88.8H436.8z M376.8,459.3 M392.9,338c0-11-8.9-20-20-20h-333V172.7h396.9v81.5
                    c0,11,8.9,20,20,20c11,0,20-8.9,20-20V68.9c0-11-8.9-20-20-20H20c-11,0-20,8.9-20,20V338c0,11,8.9,20,20,20h353
                    C384,358,392.9,349,392.9,338z M381.4,406.3c-6.5-12.3-3.3-20.6,7.3-32.7c36.2-35.8,72.5-71.6,108.7-107.4c8.2-8.1,21.5-8,29.7,0.2
                    c8.2,8.2,8.1,21.5-0.2,29.6L412.8,408.4 M514.4,283.1c6.5,12.3,3.3,20.6-7.3,32.7c-36.2,35.8-72.5,71.6-108.7,107.4
                    c-8.2,8.1-21.5,8-29.7-0.2c-8.2-8.2-8.1-21.5,0.2-29.6L483,281 M385.9,278.8c12.3-6.5,20.6-3.3,32.7,7.3
                    c35.8,36.2,71.6,72.5,107.4,108.7c8.1,8.2,8,21.5-0.2,29.7c-8.2,8.2-21.5,8.1-29.6-0.2L383.8,310.2 M509.1,411.8
                    c-12.3,6.5-20.6,3.3-32.7-7.3c-35.8-36.2-71.6-72.5-107.4-108.7c-8.1-8.2-8-21.5,0.2-29.7c8.2-8.2,21.5-8.1,29.6,0.2l112.5,114.1"/>
                </svg>
                                <h3>The transaction has been Declined!</h3>
                                <p>Please try again with a different card or contact us via Live Chat <br>to place you order over our Customer Support representatives.</p>
                                <button class="button notConfirm" style="width: 300px; margin: 0 auto; cursor: pointer;" @click="tryAgen">TRY AGAIN</button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>

        </section>
        <section class="navigation-buttons">
            <button class="prev-page" @click="backStep"></button>
        </section>
    </div>
</template>

<script>
    import progressBar from './progressbar'
    import creditCard from 'vuetify-credit-card'
    import cardValid from 'card-validator'
    import axios from 'axios'

    export default {
        name: "payments",
        data(){
            return{
                okClass: 'ok',
                errorClass: 'err',
                activeClass: 'active',
                notActive: '',
                sameAsApplicant: false,
                invertCard: false,
                CardPay: true,
                iamPerson: false
            }
        },
        computed:{
            flagSrc(){
                return 'static/img/flag/'+this.$store.getters.getCompanyCountryCode.toLowerCase()+'.png'
            },
            cardNumber: {
                get() {
                    return this.$store.getters.getCompanyCard
                },
                set(value){
                    this.$store.commit('setCompanyCardData',cardValid.number(value))
                    this.$store.commit('setCompanyCard', value)
                }
            },
            cvv:{
              get(){
                  return this.$store.getters.getCompanyCVV
              },
                set(value){
                    this.$store.commit('setCompanyCVV',value)
                }
            },
            month:{
              get(){
                  return this.$store.getters.getCompanyMounth
              },
                set(value){
                    this.$store.commit('setCompanyMounth',value)
                }
            },
            year:{
              get(){
                  return this.$store.getters.getCompanyYear
              },
                set(value){
                    this.$store.commit('setCompanyYear',value)
                }
            },
            holder:{
              get(){
                  return this.$store.getters.getCompanyHolder
              },
                set(value){
                    this.$store.commit('setCompanyHolder',value)
                }
            },
            srcCardLogo(){
                let data = this.$store.getters.getCompanyCardData
                if(data.card!=null){
                    if(data.card.type!=undefined){
                            return '/static/img/cardslogo/'+data.card.type+'.svg'
                        }
                }else{
                    return null
                }
            },
            cvvLenght(){
                let data = this.$store.getters.getCompanyCardData
                if(data.card!=null){
                    if(data.card.code.size!=undefined){
                        return data.card.code.size
                    }
                }else{
                    return 4
                }
            },
            cardLenght(){
                let data = this.$store.getters.getCompanyCardData
                let lenght=16
                if(data.card!=null){
                    for (let i=0; i<data.card.lengths.length; i++){
                        if(lenght<data.card.lengths[i]){
                            lenght=data.card.lengths[i]
                        }
                    }
                    return lenght
                }else{
                    return lenght
                }
            },
            years(){
                let date = new Date().getFullYear()
                let maxdate = date + 10
                let dateArray = []
                for(let i=date; i<maxdate; i++){
                   dateArray.push(i)
                }
                return dateArray
            },
            checkValid(){
                return this.$store.getters.getCompanyCardData.isValid
            },
            billfirstname: {
                get(){
                    if(this.sameAsApplicant){
                        return this.$store.getters.get_billfirstname
                    }else{
                        return this.$store.getters.getCompanyBillfirstname
                    }
                },
                set(value){
                    this.$store.commit('setCompanyBillfirstname', value)
                }
            },
            billCity: {
                get(){
                    if(this.sameAsApplicant){
                        return this.$store.getters.get_billCity
                    }else{
                        return this.$store.getters.getCompanyBillCity
                    }

                },
                set(value){
                    this.$store.commit('setCompanyBillCity', value)
                }
            },
            billzip: {
                get(){
                    if(this.sameAsApplicant){
                        return this.$store.getters.get_billzip
                    }else{
                        return this.$store.getters.getCompanyBillzip
                    }
                },
                set(value){
                    this.$store.commit('setCompanyBillzip', value)
                }
            },
            billaddress1: {
                get(){
                    if(this.sameAsApplicant){
                        return this.$store.getters.get_billaddress1
                    }else{
                        return this.$store.getters.getCompanyBilladdress1
                    }
                },
                set(value){
                    this.$store.commit('setCompanyBilladdress1', value)
                }
            },
            billlastname: {
                get(){
                    if(this.sameAsApplicant){
                        return this.$store.getters.get_billlastname
                    }else{
                        return this.$store.getters.getCompanyBilllastname
                    }
                },
                set(value){
                    this.$store.commit('setCompanyBilllastname', value)
                }
            },
            billCountry: {
                get(){
                    if(this.sameAsApplicant){
                        return this.$store.getters.get_billCountry
                    }else{
                        return this.$store.getters.getCompanyBillCountry
                    }
                },
                set(value){
                    this.$store.commit('setCompanyBillCountry', value)
                }
            },
            billState: {
                get(){
                    if(this.sameAsApplicant){
                        return this.$store.getters.get_billState
                    }else{
                        return this.$store.getters.getCompanyBillState
                    }
                },
                set(value){
                    this.$store.commit('setCompanyBillState', value)
                }
            },
            billaddress2: {
                get(){
                    if(this.sameAsApplicant){
                        return this.$store.getters.get_billaddress2
                    }else{
                        return this.$store.getters.getCompanyBilladdress2
                    }

                },
                set(value){
                    this.$store.commit('setCompanyBilladdress2', value)
                }
            },
            paymentStatus:{
                get(){
                    return this.$store.getters.getCompanyPaymentStatus
                },
                set(value){
                    this.$store.commit('setCompanyPaymentStatus', value)
                }
            },
            AllData(){
                return {
                    number: this.cardNumber,
                    name: this.holder,
                    expiry: this.expiry,
                    cvc: this.cvv
                }
            },
            expiry(){
                return this.month+'/'+this.year
            },
            wire_fullname:{
                get(){
                    this.$store.getters.getCompanyWire_fullname
                },
                set(value){
                    this.$store.commit('setCompanyWire_fullname', value)
                }
            },
            wire_regaddress:{
                get(){
                    this.$store.getters.getCompanyWire_regaddress
                },
                set(value){
                    this.$store.commit('setCompanyWire_regaddress', value)
                }
            },
            wire_regnum:{
                get(){
                    this.$store.getters.getCompanyWire_regnum
                },
                set(value){
                    this.$store.commit('setCompanyWire_regnum', value)
                }
            },
            wire_emailinvice:{
                get(){
                    this.$store.getters.getCompanyWire_emailinvice
                },
                set(value){
                    this.$store.commit('setCompanyWire_emailinvice', value)
                }
            },
        },
        methods: {
            sameAs(){
                if(this.sameAsApplicant==true){
                    this.sameAsApplicant = false
                    this.$store.commit('setCompanyBillfirstname', '')
                    this.$store.commit('setCompanyBillCity', '')
                    this.$store.commit('setCompanyBillzip', '')
                    this.$store.commit('setCompanyBilllastname', '')
                    this.$store.commit('setCompanyBillState', '')
                    this.$store.commit('setCompanyBillCountry', '')
                    this.$store.commit('setCompanyBilladdress1', '')
                    this.$store.commit('setCompanyBilladdress2', '')
                }else{
                    this.sameAsApplicant = true
                    this.$store.commit('setCompanyBillfirstname', this.$store.getters.get_billfirstname)
                    this.$store.commit('setCompanyBillCity', this.$store.getters.get_billCity)
                    this.$store.commit('setCompanyBillzip', this.$store.getters.get_billzip)
                    this.$store.commit('setCompanyBilllastname', this.$store.getters.get_billlastname)
                    this.$store.commit('setCompanyBillState', this.$store.getters.get_billState)
                    this.$store.commit('setCompanyBillCountry', this.$store.getters.get_billCountry)
                    this.$store.commit('setCompanyBilladdress1', this.$store.getters.get_billaddress1)
                    this.$store.commit('setCompanyBilladdress2', this.$store.getters.get_billaddress2)
                }
            },
            person(){
                if(this.iamPerson==false){
                    this.iamPerson=true
                }else if(this.iamPerson==true){
                    this.iamPerson=false
                }
            },
            success(){
                this.$store.commit('setCompanyPage','dilligence')
                this.$router.push({path: '/dilligence/'+this.$store.getters.getCompanyId})
            },
            tryAgen(){
                this.paymentStatus = ''
                this.$store.commit('modal', false)
            },
            onFocus(){
                this.invertCard = true
            },
            onBlur(){
                this.invertCard = false
            },
            backStep(){
                this.$store.commit('setCompanyPage', 'service')
                this.$router.push({path: '/additionalService'})
            },
            payNow(){
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
                                // console.log(res.data)
                                this.$store.commit('setMyCompanys', res.data)
                                this.paymentStatus='success'
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
            },
            close(){
                this.$store.commit('modal', false)
            }
        },
        components: {
            progressBar,
            creditCard,
        }
    }
</script>
