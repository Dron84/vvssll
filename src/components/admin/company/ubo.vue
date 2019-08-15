<template>
    <div class="col-sm-6 col-md-4 col-lg-3 comp-card-wrapp">
        <div class="comp-card settings-card box_shadow_hover_roundshadow" id="comp-card-1" data-toggle="modal" data-target="#ubo_info"  @click="uboForm=true">
            <div>
                <div class="comp-card-heading">
                    <h3>UBO</h3>
                    <h4>You must add more UBO  and Shareholders info</h4>
                </div>
                <div class="centrize">
                    <div class="doughnut">
                        <DoughnutChart :percent="Number(uboStatus)" :foregroundColor="ChartColor(uboStatus)" :backgroundColor="this.chart.backgroundColor" :radius="this.chart.radius" :width="this.chart.width" :height="this.chart.height" :strokeWidth="this.chart.strokeWidth" :visibleValue="this.chart.visibleValue" :classValue="this.chart.classValue"></DoughnutChart>
                        <div class="doughnut_chart_after" :style="ChartStyle(ChartColor(uboStatus))">{{Math.round(uboStatus)}}%</div>
                    </div>
                </div>
            </div>
            <button data-toggle="modal" data-target="#ubo_info" class="more-details" @click="uboForm=true">Edit</button>
        </div>
        <div class="modal fade settings-modal" :class="{show: uboForm}" id="ubo_info" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="min-width: 33px;">&times;</button>
                    <div class="modal-body">
                        <h4 class="modal-title text-center">UBO INFORMATION FORM</h4>

                        <form action="" class="ubo-form">
                            <h5><b>ADD NEW</b></h5>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-wrapper">
                                                <input type="text" class="form-control" :class="[ubo_lname ? inputOk: inputErr]" required name="ubo_lname" id="ubo_lname" v-model="ubo_lname">
                                                <label for="ubo_lname" class="label-up">Last Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-wrapper">
                                                <input type="text" class="form-control" :class="[ubo_fname ? inputOk: inputErr]" required name="ubo_fname" id="ubo_fname" v-model="ubo_fname">
                                                <label for="ubo_fname" class="label-up">First Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-wrapper">
                                                <input type="email" class="form-control" :class="[ubo_email ? inputOk: inputErr]" required name="ubo_email" id="ubo_email" v-model="ubo_email">
                                                <label for="ubo_email" class="label-up">Email Address</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-wrapper">
                                                <input type="text" class="form-control" :class="[ubo_nationality ? inputOk: inputErr]" required name="ubo_nationality" id="ubo_nationality" v-model="ubo_nationality">
                                                <label for="ubo_nationality" class="label-up">Nationality</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-wrapper">
                                                <input type="text" class="form-control" :class="[ubo_passport ? inputOk: inputErr]" required name="ubo_passport" id="ubo_passport" v-model="ubo_passport">
                                                <label for="ubo_passport" class="label-up">Passport Number</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-wrapper">
                                                <date class="form-control" :class="[ubo_birth ? inputOk: inputErr]" id="ubo_birth" v-model="ubo_birth" :format="customFormatter"></date>
                                                <label for="ubo_birth" class="label-up">Date of Birth</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-wrapper">
                                                <input type="text" class="form-control" :class="[ubo_placeBirth ? inputOk: inputErr]" id="ubo_placeBirth" v-model="ubo_placeBirth" >
                                                <label for="ubo_placeBirth" class="label-up">Place of Birth</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-wrapper">
                                                <vselect :options="allCountry()" class="form-control" v-model="ubo_сountryCitizenship" :class="[ubo_сountryCitizenship!='' ? inputOk: inputErr]" id="ubo_сountryCitizenship" :searchable="true"></vselect>
                                                <!--<input type="text" class="form-control" :class="[ubo_сountryCitizenship ? inputOk: inputErr]" id="ubo_сountryCitizenship" v-model="ubo_сountryCitizenship" >-->
                                                <label for="ubo_сountryCitizenship" class="label_up" style="left: 7px;">Country Citizenship</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="input-wrapper">
                                                <input type="text" class="form-control" :class="[ubo_address ? inputOk: inputErr]" required name="ubo_address" id="ubo_address" v-model="ubo_address">
                                                <label for="ubo_address" class="label-up">Street Address</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-wrapper">
                                                <input type="text" class="form-control" :class="[ubo_apartment ? inputOk: inputErr]" required name="ubo_apartment" id="ubo_apartment" v-model="ubo_apartment">
                                                <label for="ubo_apartment" class="label-up">Apartment/Unit</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-wrapper">
                                                <input type="text" class="form-control" :class="[ubo_city ? inputOk: inputErr]" required name="ubo_city" id="ubo_city" v-model="ubo_city">
                                                <label for="ubo_city" class="label-up">City</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-wrapper">
                                                <input type="text" class="form-control" :class="[ubo_state ? inputOk: inputErr]" required name="ubo_state" id="ubo_state" v-model="ubo_state">
                                                <label for="ubo_state" class="label-up">State/Region</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-wrapper">
                                                <vselect :options="allCountry()" class="form-control" :class="[ubo_country!='' ? inputOk: inputErr]" v-model="ubo_country" id="ubo_country" :searchable="true"></vselect>
                                                <label for="ubo_country" class="label_up" style="left: 7px;">Enter Country</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-wrapper">
                                                <input type="text" class="form-control" :class="[ubo_zip ? inputOk: inputErr]" required name="ubo_zip" id="ubo_zip" v-model="ubo_zip">
                                                <label for="ubo_zip" class="label-up">ZIP</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-wrapper">
                                                <input type="text" id='ubo_phone' class="form-control" :class='[phone_valid == true ? inputOk : inputErr]' v-model="ubo_phone" required @change="checkPhone" @keypress="isNumber($event)">
                                                <label for="ubo_phone" class="label-up">Phone</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-wrapper">
                                                <input type="text" id='ubo_fax' class="form-control" :class='[fax_valid == true ? inputOk : inputErr]' v-model="ubo_fax" required @change="checkFax" @keypress="isNumber($event)">
                                                <label for="ubo_fax" class="label-up">FAX</label>
                                            </div>
                                        </div>

                                        <!--<div class="col-md-6">-->
                                            <!--<div class="input-wrapper">-->
                                                <!--<input type="text" class="form-control" :class="[ubo_occupation ? inputOk: inputErr]" required name="ubo_occupation" id="ubo_occupation" v-model="ubo_occupation">-->
                                                <!--<label for="ubo_occupation" class="label-up">Occupation</label>-->
                                            <!--</div>-->
                                        <!--</div>-->
                                        <!--<div class="col-md-6">-->
                                            <!--<div class="input-wrapper">-->
                                                <!--<input type="text" class="form-control" :class="[ubo_coupon ? inputOk: inputErr]" required name="ubo_coupon" id="ubo_coupon" v-model="ubo_coupon">-->
                                                <!--<label for="ubo_coupon" class="label-up">Coupon Code</label>-->
                                            <!--</div>-->
                                        <!--</div>-->
                                        <transition name="fade" v-if="$store.getters.getCheckShareholder">
                                        <div class="col-md-6">
                                            <div class="input-wrapper">
                                                <input type="text" class="form-control" :class="[!checkUboShare ? inputOk: inputErr]" required name="ubo_share" id="ubo_share" v-model="ubo_share">
                                                <label for="ubo_share" class="label-up">Share %</label>
                                            </div>
                                        </div>
                                        </transition>
                                        <div class="col-md-6">
                                            <button class="add-person submit d-none d-md-block" @click.prevent="addPerson" :disabled="checkAddPerson">Add Person to company</button>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <h5>Who will be added?</h5>
                                    <div class="ubo-checkboxes clearfix">
                                        <div class="ubo-checkbox">
                                            <input type="checkbox" class="c_checkbox" value="true" id="role1" v-model="Owner">
                                            <label for="role1"><span></span>Owner</label>
                                        </div>
                                        <div class="ubo-checkbox" v-if="this.$store.getters.get_personsShare !=100">
                                            <input type="checkbox" class="c_checkbox" value="true" id="role2" v-model="Shareholder">
                                            <label for="role2"><span></span>Shareholder</label>
                                        </div>
                                        <div class="ubo-checkbox">
                                            <input type="checkbox" class="c_checkbox"  value="true" id="role3" v-model="Secretary">
                                            <label for="role3" :class="{'text_accent': secretryMess}" :title="{'In your country, a Secretary is required': secretryMess}"><span></span>Secretary (if applicable)</label>
                                        </div>
                                        <div class="ubo-checkbox">
                                            <input type="checkbox" class="c_checkbox" value="true" id="role4" v-model="Director">
                                            <label for="role4"><span></span>Director</label>
                                        </div>
                                        <div class="ubo-checkbox">
                                            <input type="checkbox" class="c_checkbox" value="true" id="role5" v-model="Authorized">
                                            <label for="role5"><span></span>Authorized</label>
                                        </div>
                                    </div>
                                    <h5>This is a Politically Exposed Persons?</h5>
                                    <div class="ubo-checkboxes clearfix">
                                        <div class="input_group">
                                            <div class="checkbox small duble" :class="[pep ? activeClass: notActive]" @click="clickpep">
                                                <div class="off_caption">No</div>
                                                <div class="checkbox_body"></div>
                                                <div class="checkbox_check">•</div>
                                                <div class="on_caption" style="left: 76px;">Yes</div>
                                            </div>
                                        </div>
                                    </div>
                                    <h5>Added person is same as applicant?</h5>
                                    <div class="input_group">
                                    <div class="checkbox small duble" :class="[iamPerson ? activeClass: notActive]" @click="person()">
                                        <div class="off_caption">No</div>
                                        <div class="checkbox_body"></div>
                                        <div class="checkbox_check">•</div>
                                        <div class="on_caption" style="left: 76px;">Yes</div>
                                    </div>
                                    </div>
                                    <h5>ALREADY ADDED</h5>
                                    <div class="table" style="min-height: 180px;">
                                        <div class="tableHeader">
                                            <div>Full Name</div>
                                            <div>Passport Number</div>
                                            <div>Email</div>
                                            <div>Position</div>
                                        </div>
                                        <div class="table_body" style="max-height: 148px;">
                                            <div class="tableRow" v-for="person in this.$store.getters.getPersons" v-if="$store.getters.getPersons!='Sql is empty'">
                                                <div>{{person.firstName}} {{person.lastName}}</div>
                                                <div>{{person.passport}}</div>
                                                <div>{{person.email}}</div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <transition name="fade">
                        <button class="submit popup-submit" data-dismiss="modal" :disabled="!checkUbo" @click="uboComplete">save and continue</button>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import date from 'vuejs-datepicker'
    import DoughnutChart from 'vue-doughnut-chart'
    import vselect from 'vue-select'
    let moment = require('moment');
    export default {
        name: "ubo",
        components: {
            DoughnutChart,
            date,
            moment,
            vselect,
        },
        data(){
            return{
                reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
                inputOk: 'valid',
                inputErr: 'err',
                activeClass: 'active',
                notActive: '',
                labelCaptionUp: 'label-up',
                chart: {
                    backgroundColor: "transperent",
                    radius: 90,
                    width: 140,
                    height: 140,
                    strokeWidth: 20,
                    visibleValue: false,
                    classValue: "percent"
                },
                company: '',
                uboStatus:'',
                uboForm: false,
                iamPerson: false,
                pep: false,
                secretryMess: false,
                dateFormat: 'yyyy-MM-dd',
                fax_carrier: '',
                fax_country_code: '',
                fax_country_name: '',
                fax_country_prefix: '',
                fax_international_format: '',
                fax_line_type: '',
                fax_local_format: '',
                fax_location: '',
                fax_number: '',
                fax_valid: {
                    type: Boolean,
                    default: false
                },
                phone_carrier: '',
                phone_country_code: '',
                phone_country_name: '',
                phone_country_prefix: '',
                phone_international_format: '',
                phone_line_type: '',
                phone_local_format: '',
                phone_location: '',
                phone_number: '',
                phone_valid: {
                    type: Boolean,
                    default: false
                },
            }
        },
        methods:{
            isInteger(num) {
                return (num ^ 0) === num;
            },
            isNumber: function(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                    evt.preventDefault();;
                } else {
                    return true;
                }
            },
            addPerson(){
                let fd = new FormData
                fd.append('lastName', this.ubo_lname)
                fd.append('firstName', this.ubo_fname)
                fd.append('nationality', this.ubo_nationality)
                fd.append('passport', this.ubo_passport)
                fd.append('dateBirth', this.customFormatter(this.ubo_birth))
                fd.append('placeBirth', this.ubo_placeBirth)
                fd.append('strit', this.ubo_address)
                fd.append('apartament', this.ubo_apartment)
                fd.append('city', this.ubo_city)
                fd.append('state', this.ubo_state)
                fd.append('country', this.ubo_country.index)
                fd.append('сountryCitizenship', this.ubo_сountryCitizenship.index)
                fd.append('zip', this.ubo_zip)
                fd.append('phone', this.ubo_phone)
                fd.append('phone_carrier', this.phone_carrier)
                fd.append('phone_country_code', this.phone_country_code)
                fd.append('phone_country_name', this.phone_country_name)
                fd.append('phone_country_prefix', this.phone_country_prefix)
                fd.append('phone_international_format', this.phone_international_format)
                fd.append('phone_line_type', this.phone_line_type)
                fd.append('phone_local_format', this.phone_local_format)
                fd.append('phone_location', this.phone_location)
                fd.append('phone_number', this.phone_number)
                fd.append('phone_valid', this.phone_valid)
                fd.append('fax_carrier', this.fax_carrier)
                fd.append('fax_country_code', this.fax_country_code)
                fd.append('fax_country_name', this.fax_country_name)
                fd.append('fax_country_prefix', this.fax_country_prefix)
                fd.append('fax_international_format', this.fax_international_format)
                fd.append('fax_line_type', this.fax_line_type)
                fd.append('fax_local_format', this.fax_local_format)
                fd.append('fax_location', this.fax_location)
                fd.append('fax_number', this.fax_number)
                fd.append('fax_valid', this.fax_valid)
                fd.append('fax', this.ubo_fax)
                fd.append('email', this.ubo_email)
                // fd.append('occupation', this.ubo_occupation)
                // fd.append('couponCode', this.ubo_coupon)
                fd.append('share', this.ubo_share)
                fd.append('Owner', this.Owner)
                fd.append('Shareholder', this.Shareholder)
                fd.append('Secretary', this.Secretary)
                fd.append('Director', this.Director)
                fd.append('SignaturyAuthorized', this.Authorized)
                fd.append('pep', this.pep)
                fd.append('sameapp',this.iamPerson)
                fd.append('companyId', this.$route.params.id)
                fd.append('applicantid', this.$store.getters.get_id)
                fd.append('person','add')
                axios.post(this.$store.getters.getPostUrl, fd)
                    .then((res)=>{
                        if(res.data.people=='added'){
                            this.peopleLoad()
                            this.ubo_lname = ''
                            this.ubo_fname = ''
                            this.ubo_nationality = ''
                            this.ubo_passport = ''
                            this.ubo_birth = ''
                            this.ubo_placeBirth = ''
                            this.ubo_address = ''
                            this.ubo_apartment = ''
                            this.ubo_city = ''
                            this.ubo_state = ''
                            this.ubo_country = ''
                            this.ubo_сountryCitizenship = ''
                            this.ubo_zip = ''
                            this.ubo_phone = ''
                            this.ubo_fax = ''
                            this.ubo_email = ''
                            // this.ubo_occupation = ''
                            // this.ubo_coupon = ''
                            this.ubo_share = ''
                            this.Owner=false
                            this.Shareholder=false
                            this.Secretary=false
                            this.Director=false
                            this.Authorized=false
                            this.pep=false
                            this.iamPerson=false
                        }
                    })
            },
            person(){
                if(this.iamPerson==false){
                    this.iamPerson=true
                    this.$store.commit('setUbo_lname', this.$store.getters.get_lastName)
                    this.$store.commit('setUbo_fname', this.$store.getters.get_firstName)
                    this.$store.commit('setUbo_city', this.$store.getters.get_City)
                    this.$store.commit('setUbo_country', this.$store.getters.get_Country)
                    this.$store.commit('setUbo_zip', this.$store.getters.get_zip_code)
                    this.$store.commit('setUbo_phone',this.$store.getters.get_phone)
                    this.$store.commit('setUbo_email', this.$store.getters.get_email)
                }else{
                    this.iamPerson=false
                    this.$store.commit('setUbo_lname', '')
                    this.$store.commit('setUbo_fname', '')
                    this.$store.commit('setUbo_city', '')
                    this.$store.commit('setUbo_country', '')
                    this.$store.commit('setUbo_zip', '')
                    this.$store.commit('setUbo_phone','')
                    this.$store.commit('setUbo_email', '')
                }
            },
            peopleLoad(){
                axios.post(this.$store.getters.getPostUrl,'person=load&companyId='+this.$route.params.id)
                    .then((res)=>{
                        this.$store.commit('setPersons', res.data.persons)
                        this.$store.commit('set_mondatoryPerson', res.data.mandatoryPerson)
                        this.$store.commit('set_personsShare', res.data.share)
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
            clickpep(){
                if(this.pep==false){
                    this.pep = true
                    this.$store.commit('setpep', true)
                }else{
                    this.pep =false
                    this.$store.commit('setpep', false)
                }
            },
            uboComplete(){
                let fd = new FormData
                fd.append('companyStatus', 'ubo=100')
                fd.append('updateStatusOnly', this.$route.params.id)
                axios.post(this.$store.getters.getPostUrl, fd).then((res) => {
                    if(res.data.mess=='Sql UPDATE is ok'){
                        this.uboForm=false
                        let newfd = new FormData
                        newfd.append('myCompanys',this.$store.getters.get_id)
                        axios.post(this.$store.getters.getPostUrl,newfd).then((res)=>{
                            this.$store.commit('setMyCompanys',res.data)
                            this.uboStatus = 100
                        })
                    }
                })

            },
            customFormatter(date) {
                return moment(date).format('YYYY-MM-DD');
            },
            checkPhone(){
                axios.get('http://apilayer.net/api/validate?access_key=b0d668b30957a7b8b63149412ee30ab5&number='+Number(this.ubo_phone)+'&country_code=&format=0')
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
                        this.phone_valid = Boolean(res.data.valid)
                    })
            },
            checkFax(){
                axios.get('http://apilayer.net/api/validate?access_key=b0d668b30957a7b8b63149412ee30ab5&number='+Number(this.ubo_fax)+'&country_code=&format=0')
                    .then((res)=>{
                        this.fax_carrier = res.data.carrier
                        this.fax_country_code = res.data.country_code
                        this.fax_country_name = res.data.country_name
                        this.fax_country_prefix = res.data.country_prefix
                        this.fax_international_format = res.data.international_format
                        this.fax_line_type = res.data.line_type
                        this.fax_local_format = res.data.local_format
                        this.fax_location = res.data.location
                        this.fax_number = res.data.number
                        this.fax_valid = Boolean(res.data.valid)
                    })
            },
            allCountry(){
                let countrys = this.$store.getters.getAllCountry
                let SelCountry = []
                countrys.forEach(country=>{
                    let c = {'index': country.id,'label': country.jurisdictionname}
                    SelCountry.push(c)
                })
                // console.log(SelCountry)
                return SelCountry
            }
        },
        computed:{
            isEmailValid(){
                return (this.comp_email == "")? "" : (this.reg.test(this.comp_email)) ? 'valid' : 'err'
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
            checkAddPerson(){
                // console.log(this.ubo_country,this.ubo_сountryCitizenship)
                if(this.ubo_lname!=''&&
                    this.ubo_fname!=''&&
                    this.ubo_nationality!=''&&
                    this.ubo_passport!=''&&
                    this.ubo_birth!=''&&
                    this.ubo_placeBirth!=''&&
                    this.ubo_address!=''&&
                    this.ubo_apartment!=''&&
                    this.ubo_city!=''&&
                    this.ubo_country!=''&&
                    this.ubo_сountryCitizenship!=''&&
                    this.ubo_zip!=''&&
                    this.ubo_phone!=''&&
                    this.ubo_email!=''&&(this.Owner==true || this.Director==true|| this.Shareholder== true || this.Authorized==true|| this.Secretary==true)){
                    if(this.Shareholder==true){
                        let share = this.$store.getters.get_personsShare
                        if(share==undefined){
                            share = 0
                        }
                        if(this.ubo_share!=''&&this.ubo_share<=(100-share)){
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
            ubo_lname:{
                get(){
                    return this.$store.getters.getUbo_lname
                },
                set(value){
                    this.$store.commit('setUbo_lname', value)
                }
            },
            ubo_fname:{
                get(){
                    return this.$store.getters.getUbo_fname
                },
                set(value){
                    this.$store.commit('setUbo_fname', value)
                }
            },
            ubo_nationality:{
                get(){
                    return this.$store.getters.getUbo_nationality
                },
                set(value){
                    this.$store.commit('setUbo_nationality', value)
                }
            },
            ubo_passport:{
                get(){
                    return this.$store.getters.getUbo_passport
                },
                set(value){
                    this.$store.commit('setUbo_passport', value)
                }
            },
            ubo_fax:{
                get(){
                    return this.$store.getters.getUbo_fax
                },
                set(value){
                    this.$store.commit('setUbo_fax', value)
                }
            },
            ubo_birth:{
                get(){
                    return this.$store.getters.getUbo_birth
                },
                set(value){
                    this.$store.commit('setUbo_birth', value)
                }
            },
            ubo_placeBirth:{
                get(){
                    return this.$store.getters.getUbo_placeBirth
                },
                set(value){
                    this.$store.commit('setUbo_placeBirth', value)
                }
            },
            ubo_сountryCitizenship:{
                get(){
                    return this.$store.getters.getUbo_сountryCitizenship
                },
                set(value){
                    this.$store.commit('setUbo_сountryCitizenship', value)
                }
            },
            ubo_address:{
                get(){
                    return this.$store.getters.getUbo_address
                },
                set(value){
                    this.$store.commit('setUbo_address', value)
                }
            },
            ubo_apartment:{
                get(){
                    return this.$store.getters.getUbo_apartment
                },
                set(value){
                    this.$store.commit('setUbo_apartment', value)
                }
            },
            ubo_city:{
                get(){
                    return this.$store.getters.getUbo_city
                },
                set(value){
                    this.$store.commit('setUbo_city', value)
                }
            },
            ubo_state:{
                get(){
                    return this.$store.getters.getUbo_state
                },
                set(value){
                    this.$store.commit('setUbo_state', value)
                }
            },
            ubo_country:{
                get(){
                    return this.$store.getters.getUbo_country
                },
                set(value){
                    this.$store.commit('setUbo_country', value)
                }
            },
            ubo_zip:{
                get(){
                    return this.$store.getters.getUbo_zip
                },
                set(value){
                    this.$store.commit('setUbo_zip', value)
                }
            },
            ubo_phone:{
                get(){
                    return this.$store.getters.getUbo_phone
                },
                set(value){
                    this.$store.commit('setUbo_phone', value)
                }
            },
            ubo_email:{
                get(){
                    return this.$store.getters.getUbo_email
                },
                set(value){
                    this.$store.commit('setUbo_email', value)
                }
            },
            ubo_occupation:{
                get(){
                    return this.$store.getters.getUbo_occupation
                },
                set(value){
                    this.$store.commit('setUbo_occupation', value)
                }
            },
            ubo_coupon:{
                get(){
                    return this.$store.getters.getUbo_coupon
                },
                set(value){
                    this.$store.commit('setUbo_coupon', value)
                }
            },
            ubo_share:{
                get(){
                    return this.$store.getters.getUbo_share
                },
                set(value){
                    this.$store.commit('setUbo_share', value)
                }
            },
            Owner:{
                get(){
                    return this.$store.getters.getCheckOwner
                },
                set(value){
                    this.$store.commit('setCheckOwner', value)
                }
            },
            Shareholder:{
                get(){
                    return this.$store.getters.getCheckShareholder
                },
                set(value){
                    this.$store.commit('setCheckShareholder', value)
                }
            },
            Secretary:{
                get(){
                    return this.$store.getters.getCheckSecretary
                },
                set(value){
                    this.$store.commit('setCheckSecretary', value)
                }
            },
            Director:{
                get(){
                    return this.$store.getters.getCheckDirector
                },
                set(value){
                    this.$store.commit('setCheckDirector', value)
                }
            },
            Authorized:{
                get(){
                    return this.$store.getters.getCheckAuthorized
                },
                set(value){
                    this.$store.commit('setCheckAuthorized', value)
                }
            },
            checkUboShare(){
                let share = this.$store.getters.get_personsShare
                if(share==undefined){
                    share = 0
                }
                if(this.ubo_share!=''&&this.ubo_share<=(100-share)){
                    return false
                }else{
                    return true
                }
            },
            checkUbo(){
                if(this.$store.getters.get_personsShare>0&&this.persons!=[] ){
                    let get_mondatoryPerson = this.$store.getters.get_mondatoryPerson
                    if(get_mondatoryPerson.length>0){
                        get_mondatoryPerson.forEach((person)=>{
                            if(person == 'Owner'){
                                this.$store.commit('editCompanyOwner', true)
                            }
                            if(person == 'Director'){
                                this.$store.commit('editCompanyDirector', true)
                            }
                            if(person == 'Shareholder'){
                                this.$store.commit('editCompanyShareholder', true)
                            }
                            if(person == 'Secretary'){
                                this.$store.commit('editCompanySecretary', true)
                            }
                        })
                    }

                }

                if(this.$store.getters.get_editCompanyDirector && this.$store.getters.get_editCompanyOwner&&this.$store.getters.get_editCompanyShareholder){
                    // return true
                    let secretry = false
                    this.$store.getters.getOurCountry.forEach((cou)=>{
                        if(cou.id==this.company.jurisdiction){
                            if(cou.secretary=='1'){
                                this.secretryMess =true
                                if(this.$store.getters.get_editCompanySecretary===true){
                                    secretry = true
                                }else{
                                    secretry = false
                                }
                            }else{
                                this.secretryMess =false
                                secretry = true
                            }
                        }
                    })

                    return secretry
                }else{
                    return false
                }
                //
            },

        },
        mounted(){
            let id = this.$route.params.id
            const MyCompanys = this.$store.getters.getMyCompanys
            MyCompanys.forEach((item)=>{
            if(item.id == id){
                this.company=item
                let status = JSON.parse(item.companyStatus)
                this.uboStatus =  status.ubo
                this.companyName= item.companyName
            }
            this.peopleLoad()
        })
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
    .comp-card-heading
        h4
            font-size: 16px !important
    h4
        font-size: 1.5rem
        text-align: center
        margin: 10px
    h5
        margin: 8px
        font-size: 1.25em
    .companys_header_top
        font-size: 1em

</style>