<template>
    <div class="profile">
        <div class='personal'>
            <h2 class='profile_header'>Personal Info</h2>
            <div class="prifile_header_top">
                <div class="change_avatar" @click="avatarUploadShow = true">
                    <uploadAvatar @crop-success="cropSuccess"
                                  v-model="avatarUploadShow"
                                  :width="this.width.value"
                                  :height="this.height.value"
                                  :noRotate="this.noRotate.value"
                                  :params="this.params"
                                  langType="en"
                                  field="img"
                    ></uploadAvatar>
                    <svg v-if="this.$store.getters.get_avatar=='null'||this.$store.getters.get_avatar==null" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        viewBox="0 0 135 124" style="enable-background:new 0 0 135 124;z-index: 999;" xml:space="preserve" class='change_avatar_img'>
                        <rect id="_x3C_Slice_x3E__100_" y="0" class="st0"/>
                        <path d="M69,92.1c-7.5,0-13.5,6-13.5,13.5c0,7.5,6,13.5,13.5,13.5s13.5-6,13.5-13.5C82.5,98.1,76.5,92.1,69,92.1z M76.4,106.1
                        c0,0.4-0.2,0.6-0.6,0.6h-5.2c-0.2,0-0.3,0.1-0.3,0.3v5.2c0,0.4-0.2,0.6-0.6,0.6h-1.2c-0.4,0-0.6-0.2-0.6-0.6v-5.2
                        c0-0.2-0.1-0.3-0.3-0.3h-5.2c-0.4,0-0.6-0.2-0.6-0.6v-1.2c0-0.4,0.2-0.6,0.6-0.6h5.2c0.2,0,0.3-0.1,0.3-0.3v-5.2
                        c0-0.4,0.2-0.6,0.6-0.6h1.2c0.4,0,0.6,0.2,0.6,0.6v5.2c0,0.2,0.1,0.3,0.3,0.3h5.2c0.4,0,0.6,0.2,0.6,0.6V106.1z"/>
                        <g>
                        <path d="M62,92.8c2.1-1,4.5-1.6,7-1.6s4.9,0.6,7,1.6h37.8l-25-45.2l-7.6,13.8L69,39.4l-12.2,22l-7.6-13.8l-25,45.2H62z"/>
                        <path d="M13.8,25.3v76.8h39.8c0.5-1.5,1.3-2.9,2.2-4.2H18.1V29.6h101.8v68.3H82.2c0.9,1.3,1.7,2.7,2.2,4.2h39.8V25.3H13.8z"/>
                        <path d="M40,47.3c0-4.4-3.6-7.9-7.9-7.9c-4.4,0-7.9,3.6-7.9,7.9s3.5,7.8,7.9,7.9C36.5,55.2,40,51.6,40,47.3z"/>
                        </g>
                    </svg>
                    <img v-else @mouseover="showAdd = true" @mouseleave="showAdd = false" :src="this.$store.getters.get_avatar">
                </div>
            </div>
            <div class="profile_header_left">
                <div class="input_group">
                    <input type="text" id='firstname' :class='[firstName ? okClass : errorClass]' v-model="firstName" autofocus required tabindex="1">
                    <label for="firstname">First Name</label>
                </div>
                <!--<div class="input_group">-->
                    <!--<input type="text" id='email' class="ok" v-model="email" tabindex="3" disabled title="only with the manager">-->
                    <!--<label for="email">Email</label>-->
                <!--</div>-->

                <div class="input_group">
                    <input type="text" id='City' :class='[City ? okClass : errorClass]' v-model="City" tabindex="7" required>
                    <label for="City">City</label>
                </div>
                <div class="input_group">
                    <input type="text" id='zip' :class='[zip_code ? okClass : errorClass]' v-model="zip_code" tabindex="9" required>
                    <label for="zip">Zip code</label>
                </div>
            </div>
            <div class="profile_header_right">
                <div class="input_group">
                    <input type="text" id='lastname' :class='[lastName ? okClass : errorClass]' v-model="lastName" tabindex="2" required>
                    <label for="lastname">Last Name</label>
                </div>
                <!--<div class="input_group">-->
                    <!--<input type="text" id='phone' class="ok" v-model="phone" tabindex="5" disabled title="only with the manager">-->
                    <!--<label for="phone">Phone</label>-->
                <!--</div>-->
                <!--<div class="input_group">-->
                    <!--<label for="pass">Password</label>-->
                    <!--<input type="password" placeholder="Enter Password" id='pass' :class='[pass && pass.length>8 ? okClass : errorClass]' v-model="pass" tabindex="4" required>-->
                <!--</div>-->

                <div class="input_group">
                    <!--<vueSelect :options="allCounty" placeholder="Select a Country" label="label" v-model="Country" :searchable="true" :clearable="false" id="Country"></vueSelect>-->
                    <select v-model="Country" id="Country" :class="[Country ? okClass:errorClass]" placeholder="Enter Country">
                        <option :value="item.id" v-for="item in allCounty">{{item.label}}</option>
                    </select>
                    <label for="Country">Country</label>
                </div>
                <div class="input_group">
                    <input type="text" id='State' :class='[State ? okClass : errorClass]' v-model="State" tabindex="8" required>
                    <label for="State">State</label>
                </div>
                <div class="input_group" style="display: flex; justify-content: center; align-items: center;">
                    <button class="button" @click="changePassModal = !changePassModal">Change Password</button>
                </div>
                <div class="modal-mask" v-if="changePassModal">
                    <div class="modal-wrapper" @click.self="close()">
                        <div class="modal-container">
                            <div class="input_group">
                                <input type="password" id='OldPass' :class='[OldPass.length>8 ? okClass : errorClass]' v-model="OldPass" autofocus required>
                                <label for="OldPass">Old Password</label>
                            </div>
                            <div class="input_group">
                                <input type="password" id='NewPass' :class='[NewPass.length>8 ? okClass : errorClass]' v-model="NewPass" required>
                                <label for="NewPass">New Password</label>
                            </div>
                            <div class="input_group">
                                <input type="password" id='confirmPass' :class='[NewPass==confirmPass ? okClass : errorClass]' v-model="confirmPass" required>
                                <label for="confirmPass">Confirm Password</label>
                            </div>
                            <div class="input_group" style="display: flex; justify-content: center; align-items: center;">
                                <button class="button" @click="changePassword"  :disabled="checkPassChange">Change Password</button>
                            </div>
                            <p v-if="changePassMess!=''" :class="[changePassMess=='Password changed'? text_err: text_err]">{{changePassMess}}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class='billing' v-if="this.$store.getters.getLogin.loginIn =='6'">
            <h2 class="billing_header">Billing Details</h2>
            <div class="billing_header_left" style="margin-top: 50px">
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
                <div><p :class="[mess=='Update Success' ? text_ok: text_err]" v-if="mess!=''">{{mess}}</p></div>
            </div >
            <div class="billing_header_right" style="margin-top: 50px">
                <div class="input_group">
                    <input type="text"  id='billlastname' :class="[billlastname ? okClass:errorClass]" v-model="billlastname" tabindex="11">
                    <label for="billlastname">Last Name</label>
                </div>
                <div class="input_group">
                    <!--<vueSelect :options="allCounty" placeholder="Select a Country" label="label" v-model="Country" :searchable="true" :clearable="false" id="Country"></vueSelect>-->
                    <select id="billCountry" :class="[billCountry ? okClass:errorClass]" v-model="billCountry" tabindex="13" placeholder="Enter Billing Country">
                        <option :value="item.id" v-for="item in allCounty">{{item.label}}</option>
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
                <div class="input_group" style="display: flex; justify-content: center; align-items: center;">
                    <button class="button" @click="setUserData" tabindex="18">Update my info</button>
                </div>
            </div >
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import uploadAvatar from 'vue-image-crop-upload'
    export default {
        name: "myprofile",
        data(){
            return{
                mess: '',
                avatarUploadShow: false,
                okClass: 'ok',
                errorClass: 'err',
                params: {
                    name: 'avatarUpload'
                },
                width: {
                    type: Number,
                    value: 200
                },
                height: {
                    type: Number,
                    value: 200
                },
                noRotate:{
                    type: Boolean,
                    value: false
                },
                reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
                allCounty: [],
                changePassModal: false,
                OldPass: '',
                NewPass: '',
                confirmPass: '',
                changePassMess: '',
                text_ok: 'text_ok',
                text_err: 'text_err',
            }
        },
        methods:{
            setUserData(){
                let fd = new FormData
                fd.append('billfirstname', this.billfirstname)
                fd.append('billCity', this.billCity)
                fd.append('billzip', this.billzip)
                fd.append('billaddress1', this.billaddress1)
                fd.append('billlastname', this.billlastname)
                fd.append('billCountry', this.billCountry)
                fd.append('billState', this.billState)
                fd.append('billaddress2', this.billaddress2)
                fd.append('firstName', this.firstName)
                fd.append('lastName', this.lastName)
                fd.append('phone', this.phone)
                fd.append('City', this.City)
                fd.append('zip_code', this.zip_code)
                fd.append('Country', this.Country)
                fd.append('State', this.State)
                fd.append('email', this.email)
                fd.append('id', this.id)
                if(this.avatarDataImage!=null){
                    fd.append('avatar', this.avatarDataImage)
                }else{
                    fd.append('avatar', this.$store.getters.get_avatar)
                }
                fd.append('setUserData', 'set')
                axios.post(this.$store.getters.getPostUrl, fd).then((res)=>{
                    this.mess=res.data.mess

                })
                setTimeout(()=>{this.mess=''},5000);
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
            cropSuccess(imgDataUrl){
                this.$store.commit('set_avatar', imgDataUrl)
                let fd = new FormData
                fd.append('avatarSave',imgDataUrl)
                fd.append('userId', this.$store.getters.get_id)
                axios.post(this.$store.getters.getPostUrl,fd)
                    .then((res)=>{
                        console.log(res.data)
                    })
            },
            changePassword(){
                let fd = new FormData
                fd.append('oldPass', this.OldPass)
                fd.append('NewPass', this.NewPass)
                fd.append('id', this.$store.getters.get_id)
                fd.append('email', this.$store.getters.get_email)
                fd.append('changePassword', 'true')
                axios.post(this.$store.getters.getPostUrl, fd).then((res)=>{
                    if(res.data.mess=='Password changed'){
                        this.OldPass=''
                        this.NewPass=''
                        this.confirmPass=''
                        this.changePassModal=false
                    }else{
                        this.changePassMess= res.data.mess
                    }
                })
            },
            close(){
                this.changePassModal = false
            },

        },
        computed: {
            billfirstname:{
              get(){
                return this.$store.getters.get_billfirstname
              },
                set(value){
                this.$store.commit('set_billfirstname', value)
                }
            },
            id:{
                get(){
                    return this.$store.getters.get_id
                },
                set(value){
                    this.$store.commit('set_id', value)
                }
            },
            billCity:{
              get(){
                return this.$store.getters.get_billCity
              },
                set(value){
                this.$store.commit('set_billCity', value)
                }
            },
            billzip:{
              get(){
                return this.$store.getters.get_billzip
              },
                set(value){
                this.$store.commit('set_billzip', value)
                }
            },
            billaddress1:{
              get(){
                return this.$store.getters.get_billaddress1
              },
                set(value){
                this.$store.commit('set_billaddress1', value)
                }
            },
            billlastname:{
              get(){
                return this.$store.getters.get_billlastname
              },
                set(value){
                this.$store.commit('set_billlastname', value)
                }
            },
            billCountry:{
              get(){
                return this.$store.getters.get_billCountry
              },
                set(value){
                this.$store.commit('set_billCountry', value)
                }
            },
            billState:{
              get(){
                return this.$store.getters.get_billState
              },
                set(value){
                this.$store.commit('set_billState', value)
                }
            },
            billaddress2:{
              get(){
                return this.$store.getters.get_billaddress2
              },
                set(value){
                this.$store.commit('set_billaddress2', value)
                }
            },
            firstName:{
              get(){
                return this.$store.getters.get_firstName
              },
                set(value){
                this.$store.commit('set_firstName', value)
                }
            },
            lastName:{
              get(){
                return this.$store.getters.get_lastName
              },
                set(value){
                this.$store.commit('set_lastName', value)
                }
            },
            phone:{
              get(){
                return this.$store.getters.get_phone
              },
                set(value){
                this.$store.commit('set_phone', value)
                }
            },
            City:{
              get(){
                return this.$store.getters.get_City
              },
                set(value){
                this.$store.commit('set_City',value)
                }
            },
            zip_code:{
              get(){
                return this.$store.getters.get_zip_code
              },
                set(value){
                this.$store.commit('set_zip_code', value)
                }
            },
            Country:{
              get(){
                return this.$store.getters.get_Country
              },
                set(value){
                this.$store.commit('set_Country', value)
                }
            },
            State:{
              get(){
                return this.$store.getters.get_State
              },
                set(value){
                this.$store.commit('set_State', value)
                }
            },
            email:{
              get(){
                return this.$store.getters.get_email
              },
                set(value){
                this.$store.commit('set_email', value)
                }
            },
            pass:{
              get(){
                // return this.$store.getters.get_pass
              },
                set(value){
                this.$store.commit('set_pass',value)
                }
            },
            checkForm(){
                if(this.firstName.length>0&&this.lastName.length>0&&this.phone_valid&&this.City.length>0&&this.zip_code.length>0&&this.Country.length>0&&this.State.length>0&&this.email.length>0&&this.pass.length>8){
                    return false
                }else{
                    return true
                }
            },
            checkPassChange(){
                if (this.OldPass.length>8&&(this.NewPass==this.confirmPass)&&this.NewPass.length>8){
                    return false
                }else{
                    return true
                }
            },
            showAvatar(){
                console.log(this.$store.getters.get_avatar)
                if (this.$store.getters.get_avatar==null || this.$store.getters.get_avatar=='null'){
                    console.log('false')
                    return false
                }else{
                    console.log('true')
                    return true

                }
            }
        },
        components:{
            uploadAvatar,
        },
        mounted(){
            for(let i=0; i<this.$store.getters.getAllCountry.length; i++){
                let county = this.$store.getters.getAllCountry[i]
                this.allCounty.push({'label': county.jurisdictionname,'id': county.id})
            }
        }

    }
</script>
<style scoped lang="sass">
    .profile_footer
        display: flex
        justify-content: center
        align-items: center
    .button
        width: 250px
    .change_avatar
        img
            width: 100px
            height: 100px
            border-radius: 50%
    input.vs__search
        border: none !important
    .input_center
        display: flex
        justify-content: center
        align-items: center
    .text_ok
        display: block
        text-align: center
        color: green
    text_err
        display: block
        text-align: center
        color: red
</style>