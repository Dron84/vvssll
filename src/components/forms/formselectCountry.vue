<template>
    <div class="input_group_select">
        <div v-if="multiple==false">
            <img :src="imgSrc" v-if="value.code!=''" class="countryImg">
        </div>
        <Multiselect v-if="countryComplect=='all'" v-model="value" :options="allCountry" :placeholder="placeholder" label="label" track-by="index" :searchable="true" @input="onSelect" :class="[value!='' ? okClass : errorClass]" :close-on-select="closeOnSelect" :multiple="multiple"></Multiselect>
        <Multiselect v-if="countryComplect=='our'" v-model="value" :options="ourCountry" :placeholder="placeholder" label="label" track-by="index" :searchable="true" @input="onSelect" :class="[value!='' ? okClass : errorClass]" :close-on-select="closeOnSelect" :multiple="multiple"></Multiselect>
        <label class="label-up" style="position: absolute;top: -6px;left: 6px;font-family: 'Brandon Grotesque';font-weight: 500;font-size: .8em;letter-spacing: .05em;line-height: .8em;text-align: left;z-index: 1;color: #2f2f2f;background-color: #fff;">{{labelName}}</label>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    export default {
        name: "formselectCountry",
        components:{Multiselect},
        data(){
            return{
                okClass: 'ok',
                errorClass: 'err',
                ourCountry: [],
                allCountry: [],
                value: null,
            }
        },
        props:{
            labelName:{
                type: String,
                default: 'Select Country'
            },
            countryComplect: {
                type: String,
                default: 'our' // all
            },
            selectCountry:'',
            placeholder: {
                type: String,
                default: 'Select one'
            },
            closeOnSelect:{
                type: Boolean,
                default: true
            },
            multiple:{
                type: Boolean,
                default: false
            },
            values: null,
        },
        computed:{
            imgSrc() {
                if(this.value!=''){
                    return '/static/img/flag/'+this.value.code.toLowerCase()+'.png'
                }
            },
        },
        methods:{

            loadOurCountry(){
                for(let i=0; i<this.$store.getters.getOurCountry.length; i++){
                    let county = this.$store.getters.getOurCountry[i]
                    this.ourCountry.push({'index': county.id,'label': county.jurisdictionname, 'code': county.code})
                }
            },
            loadAllCountry(){
                for(let i=0; i<this.$store.getters.getAllCountry.length; i++){
                    let county = this.$store.getters.getAllCountry[i]
                    this.allCountry.push({'index': county.id,'label': county.jurisdictionname, 'code': county.code})
                }
            },
            onSelect(){
                this.$emit('selectedCountry',this.value)
            },
        },
        mounted(){
            this.loadOurCountry()
            this.loadAllCountry()
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>