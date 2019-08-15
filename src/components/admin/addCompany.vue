<template>
    <div class="preload" v-if="preload">
        <div class="dash uno"></div>
        <div class="dash dos"></div>
        <div class="dash tres"></div>
        <div class="dash cuatro"></div>
    </div>
    <div style="position: relative;" v-else>
        <div class="addcompany" :class="{modal_show: this.$store.getters.getModal}">
            <h2>Open a Company</h2>
            <p>Go through a few simple steps to start a new company</p>
            <div class="add-comp-btn box_shadow_hover_roundshadow" @click="modalShow">
                <div>
                    <span></span>
                    <span></span>
                </div>
            </div>

        </div>
        <transition name="modal" v-if="this.$store.state.modal">
            <div class="modal-mask">
                <div class="modal-wrapper" @click.self="modalClose()">
                    <div class="modal-container" v-if="page==''">
                        <button type="button" class="close" @click="modalClose()">&times;</button>
                        <div class="input_group ">
                            <img :src="imgSrc" v-if="country.code!=''" class="countryImg">
                            <v-select id="CompanyCountry" class="form-control"  :class="[country!='' ? okClass: errorClass]" v-model="country" :options="ourCountry" :searchable="true"></v-select>
                            <!--<select id="CompanyCountry"  :class="[CompanyCountryCode!='' ? okClass: errorClass]" v-model="CompanyCountryCode">-->
                                <!--<option :value="item.code" v-for="item in ourCountry" @click="selectCountry(item.id)">{{item.label}}</option>-->
                            <!--</select>-->
                            <label for="CompanyCountry" class="label-up" style="position: absolute;top: -6px;left: 6px;font-family: 'Brandon Grotesque';font-weight: 500;font-size: .8em;letter-spacing: .05em;line-height: .8em;text-align: left;z-index: 1;color: #2f2f2f;background-color: #fff;">Select Country</label>
                        </div>
                        <div class="input_group">
                            <input type="text" id="CheckName" v-model="CompanyName" :class="CheckNameData.status">
                            <label for="CheckName">Company name</label>
                            <div class="CheckNameLTD">LTD</div>
                        </div>
                        <div class="centrize">
                            <button v-if="CheckNameData.status==''" type="button" class="submit"  @click="checkName" style="background-image: -webkit-linear-gradient( 128deg, rgb(255,136,0) 0%, rgb(251,159,53) 0%, rgb(255,136,0) 97%);width: 100%;">CHECK AVAILABILITY</button>
                            <button v-else-if="CheckNameData.status=='wait'" type="button" class="submit"  style="width: 100%;" disabled="disabled">WAIT</button>
                            <button v-else-if="CheckNameData.status=='ok'" type="button" class="submit"  style="width: 100%;" @click="createCompany" :class="[CheckNameData.status=='ok' ? confirmClass: notConfirmClass]">CONFIRM</button>
                            <button v-else-if="CheckNameData.status=='err'" type="button" class="submit"  style="width: 100%;" :class="[CheckNameData.status=='err' ? notConfirmClass: confirmClass]">NO AVAILABILITY</button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import vSelect from 'vue-select'
    import 'vue-select/dist/vue-select.css';
    import axios from 'axios'
    export default {
        name: "addcompany",
        data(){
            return{
                confirmClass: 'valid-button',
                notConfirmClass: 'notConfirm',
                okClass: 'ok',
                errorClass: 'err',
                ourCountry: [],
                CheckNameData: {
                    server: '',
                    api: '',
                    status: '',
                },
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
            checkName(){
                this.CheckNameData.status='wait'
                let fd = new FormData
                fd.append('CheckCompanyName', this.CompanyName)
                fd.append('CheckCompanyCountry', this.CompanyCountry)
                axios.post(this.$store.getters.getPostUrl, fd).then((res)=>{
                    this.CheckNameData.server = res.data.server.info
                    this.CheckNameData.api = res.data.api.count
                    if(res.data.api.count>0||res.data.server.info=='found'){
                        this.CheckNameData.status='err'
                    }else{
                        this.CheckNameData.status='ok'
                    }
                })
                // setTimeout(()=>{
                //     if(this.CheckNameData.api>0||this.CheckNameData.server=='found'){
                //         this.CheckNameData.status='err'
                //     }else{
                //         this.CheckNameData.status='ok'
                //     }
                // },1000)

            },
            createCompany(){
                this.page = 'package'
                this.$store.commit('setCompanyCreate', true);
                this.$router.push({path: '/packages'})
            }
        },
        computed: {
            imgSrc() {
                if(this.country!=''){
                    // console.log(this.country)
                    return '/static/img/flag/'+this.country.code.toLowerCase()+'.png'
                }
            },
            country:{
                get(){
                    return {'label': this.$store.getters.getCompanyCountry,'code': this.$store.getters.getCompanyCountryCode,'index':this.$store.getters.getCompanyJurusdictionId}
                },
                set(newValue){
                    this.$store.commit('setCompanyJurisdictionId', newValue.index)
                    this.$store.commit('setCompanyCountry', newValue.label);
                    this.$store.commit('setCompanyCountryCode', newValue.code);
                }
            },

            // CompanyCountry:{
            //     get(){
            //         return this.$store.getters.getCompanyCountry
            //     },
            //     set(){
            //         let Country=''
            //         for(let i=0; i<this.$store.getters.ourCountry.length; i++){
            //             if(this.$store.getters.ourCountry[i].code==this.CompanyCountryCode){
            //                 Country=this.$store.getters.ourCountry[i].jurisdictionname
            //             }
            //         }
            //         this.$store.commit('setCompanyCountry', Country);
            //     }
            // },
            // CompanyCountryCode:{
            //     get(){
            //         return this.$store.getters.getCompanyCountryCode
            //     },
            //     set(value){
            //         let val=''
            //         let ourCountry = this.$store.getters.getOurCountry
            //         let index = null
            //         for(let i=0; i<ourCountry.length; i++){
            //             if(ourCountry[i].index==value){
            //                 // console.log(ourCountry[i])
            //                 val= ourCountry[i].jurisdictionname
            //                 index = ourCountry[i].index
            //             }
            //         }
            //         this.$store.commit('setCompanyJurisdictionId', index)
            //         this.$store.commit('setCompanyCountry', val);
            //         this.$store.commit('setCompanyCountryCode', value);
            //     }
            // },
            CompanyName:{
                get(){
                    return this.$store.getters.getCompanyName
                },
                set(value){
                    this.$store.commit('setCompanyName', value);
                    this.CheckNameData.status=''
                }
            },
            page: {
                get(){
                    return this.$store.getters.getCompanyPage
                },
                set(value){
                    this.$store.commit('setCompanyPage', value);
                }
            },
            preload:{
                get(){
                    return this.$store.getters.preload
                },
                set(val){
                    this.$store.commit('preload',val)
                }
            }
        },
        mounted(){
            for(let i=0; i<this.$store.getters.getOurCountry.length; i++){
                let county = this.$store.getters.getOurCountry[i]
                this.ourCountry.push({'label': county.jurisdictionname,'index': county.id, 'code': county.code})
            }
        },
        components:{
            vSelect,
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