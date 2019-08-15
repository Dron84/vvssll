<template>
  <div class="main_wrapper" :style="[modal==false ? 'margin: 15vh auto;' : 'margin: 0 auto;']">
    <div class="login-brand" v-if="modal==false">
      <img src="/static/img/logo.png" alt="logo" width="200">
    </div>
    <div class="profile">
      <div class='personal registration'>
        <h2 class='profile_header'>Personal Info</h2>
        <div class="prifile_header_top">
          <div class="change_avatar" @click="avatarUploadShow=true">
            <svg v-if="avatarDataImage==null" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
viewBox="0 0 135 124" style="enable-background:new 0 0 135 124;" xml:space="preserve" class='change_avatar_img'>
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
            <uploadAvatar @crop-success="cropSuccess"
                          v-model="avatarUploadShow"
                          :width="this.width.value"
                          :height="this.height.value"
                          :noRotate="this.noRotate.value"
                          :params="this.params"
                          langType="en"
                          field="img"
            ></uploadAvatar>
            <img v-if="avatarDataImage!=null" :src="avatarDataImage">
          </div>
        </div>
        <div class="profile_header_left">
          <div class="input_group">
            <input type="text" id='firstname' :class='[firstName ? okClass : errorClass]' v-model="firstName" autofocus required tabindex="1">
            <label for="firstname">First Name</label>
          </div>
          <div class="input_group">
            <input type="text" id='email' :class="[isEmailValid()]" v-model="email" tabindex="3" required>
            <label for="email">Email</label>
          </div>
          <div class="input_group" v-if="modal==false">
            <input type="text" id='phone' :class='[phone_valid ? okClass : errorClass]' v-model="phone" tabindex="5" required @change="checkPhone">
            <label for="phone">Phone</label>
          </div>
          <div class="input_group" v-if="modal==false">
            <input type="text" id='City' :class='[City ? okClass : errorClass]' v-model="City" tabindex="7" required>
            <label for="City">City</label>
          </div>
          <div class="input_group" v-if="modal==false">
            <input type="text" id='zip' :class='[zip_code ? okClass : errorClass]' v-model="zip_code" tabindex="9" required>
            <label for="zip">Zip code</label>
          </div>
        </div>
        <div class="profile_header_right">
          <div class="input_group">
            <input type="text" id='lastname' :class='[lastName ? okClass : errorClass]' v-model="lastName" tabindex="2" required>
            <label for="lastname">Last Name</label>
          </div>
          <div class="input_group" v-if="modal==false">
            <input type="password"  id='pass' :class='[pass && pass.length>8 ? okClass : errorClass]' v-model="pass" tabindex="4" required>
            <label for="pass">Password</label>
          </div>

          <div class="input_group" v-if="modal==false">
            <!--<vueSelect :options="allCounty" placeholder="Select a Country" label="label" v-model="Country" :searchable="true" :clearable="false" id="Country"></vueSelect>-->
              <select v-model="Country" id="Country" :class="[Country ? okClass:errorClass]">
                  <option :value="item.id" v-for="item in allCounty">{{item.label}}</option>
              </select>
              <label for="Country">Country</label>
          </div>
          <div class="input_group" v-if="modal==false">
            <input type="text" id='State' :class='[State ? okClass : errorClass]' v-model="State" tabindex="8" required>
            <label for="State">State</label>
          </div>
        <div class="input_group" v-if="modal==true">
            <vselect :options="ManagerType" :class='[typeManager.length>0 ? okClass : errorClass]' v-model="typeManager"></vselect>
            <label for="State" class="label_up" style="left: 5px;">Type manager</label>
        </div>
        </div>
        <div class="profile_footer" :style="[modal==true ? modalButtonStyle : ButtonStyle ]">
            <button class="button" @click="register" :disabled="checkForm" v-if="status==''">Register</button>
            <button class="button"  disabled="disabled" v-else-if="status=='wait'">WAIT</button>
            <button class="button confirm"  v-else-if="status=='ok'" @click.prevent="$router.push({path:'/login'})">ok! Redirect now</button>
            <button class="button notConfirm"  v-else-if="status=='err'">error</button>
            <p v-show="mess!=''">{{mess}}</p>
        </div>

      </div>

    </div>
  </div>
</template>

<script>
    import axios from 'axios'
    import uploadAvatar from 'vue-image-crop-upload'
    import vselect from 'vue-select'
    // import "vue-select/src/scss/vue-select.scss"
    export default {
        name: "authRegister",
        props:{
            modal: {
                type: Boolean,
                default: false,
            }
        },
        data(){
            return{
                modalButtonStyle: 'position: relative;top: 87px;',
                ButtonStyle: 'position: inherit;top: 0;',
                mess: '',
                firstName: '',
                lastName: '',
                phone: '',
                City: '',
                zip_code: '',
                Country: '',
                State: '',
                email: '',
                pass: '',
                avatarUploadShow: false,
                avatarDataImage: null,
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
                phone_carrier: '',
                phone_country_code: '',
                phone_country_name: '',
                phone_country_prefix: '',
                phone_international_format: '',
                phone_line_type: '',
                phone_local_format: '',
                phone_location: '',
                phone_number: '',
                phone_valid: '',
                allCounty: [],
                status: '',
                timer: 15,
                ManagerType: [{'index': '3','label': 'Manager'},{'index': '4','label': 'General Manager'},{'index': '9','label': 'Sales Manager'}],
                typeManager: {},
            }
        },
        methods:{
            register(){
                this.status='wait';
                let fd = new FormData()
                fd.append('firstName', this.firstName)
                fd.append('lastName', this.lastName)
                fd.append('email', this.email)
                fd.append('avatar', this.avatarDataImage)
                if(this.modal==false){
                    fd.append('phone', this.phone)
                    fd.append('City', this.City)
                    fd.append('zip_code', this.zip_code)
                    fd.append('Country', this.Country)
                    fd.append('State', this.State)
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
                    fd.append('pass', this.pass)
                    fd.append('register', 'registerApplicant')
                }else{
                    fd.append('register', 'registerManager')
                    fd.append('premission_group',this.typeManager.index)
                }
                axios.post(this.$store.getters.getPostUrl,fd).then((res)=>{
                    if(res.data.mess=="Sql INSERT is ok"){
                        if(this.modal==true){
                            this.status=''
                            this.firstName = ''
                            this.lastName = ''
                            this.email = ''
                            this.typeManager = {}
                            this.avatarDataImage = ''
                        }else{
                            this.status='ok'
                            this.mess='User added! Please login! You wil be redirect to login form in '+this.timer;
                            setInterval(()=>{
                                this.timer--
                                this.mess='User added! Please login! You wil be redirect to login form in '+this.timer;
                            },1000)
                        }

                    }else{
                        this.mess= res.data.mess
                        this.status='err'
                    }
                    setTimeout(()=>{
                        this.$router.push({path:'/login'})
                    },(this.timer*1000))
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

            cropSuccess(imgDataUrl){
                this.avatarDataImage = imgDataUrl;
            },
        },
        components:{
            uploadAvatar,
            vselect,
        },
        computed:{
            checkForm(){
                if(this.modal==true){
                    if(this.firstName.length>0&&this.lastName.length>0&&this.email.length>0&&this.typeManager.index!=undefined){
                        return false
                    }else{
                        return true
                    }
                }else{
                    if(this.firstName.length>0&&this.lastName.length>0&&this.phone_valid&&this.City.length>0&&this.zip_code.length>0&&this.Country.length>0&&this.State.length>0&&this.email.length>0&&this.pass.length>8){
                        return false
                    }else{
                        return true
                    }
                }

            }
        },
        mounted(){
            let fd = new FormData
            fd.append('loadJurisdiction','true')
            axios.post(this.$store.getters.getPostUrl, fd).then((res)=>{
                for(let i=0; i<res.data.length; i++){
                    let county = res.data[i]
                    this.allCounty.push({'label': county.jurisdictionname,'id': county.id})
                }
                this.$store.commit('setAllCountry',res.data)
            })
        }
    }
</script>

<style scoped lang="sass">

.profile_footer
    display: grid
    justify-content: center
    align-items: center
    button
        align-self: center
        justify-self: center
    p
        display: block
        text-align: center
.button
    width: 250px
.change_avatar
    img
        width: 100px
        height: 100px
        border-radius: 50%
input.vs__search
    border: none !important

</style>