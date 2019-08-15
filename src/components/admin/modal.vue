<template>
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
</template>

<script>
    export default {
        name: "modal",
        data(){
            return{

            }
        },
        methods:{
            close(){
                this.$store.commit('modal', false)
            }
        }
    }
</script>

<style scoped>

</style>