<template>
    <div>
        <progressBar></progressBar>
        <section class="additionalService">
            <h2>Additional Services</h2>
            <p>New Company Name: <span>{{this.$store.getters.getCompanyName}}</span></p>
            <p>Country: <span>{{this.$store.getters.getCompanyCountry}}</span><img :src="flagSrc" alt="flag"></p>
            <p>Package: <span>{{this.$store.state.newCompany.package_selected}}</span></p>
            <p>TOTAL: <span class="text_accent">$ {{this.$store.getters.getTotal}} </span><button class="button" @click="nextStep">SAVE SERVICE</button></p>
            <div class="additionalService_body">
                <div class="service" :class="{active: getService(item.id)>-1}" v-for="item in this.$store.getters.getServiseList" v-if="service(item.package)" >
                    <div class="service_price">${{item.price}}</div>
                    <div class="service_header">{{item.name}}</div>
                    <div class="service_caption">{{item.description}}</div>
                    <div class="center">
                        <div class="input_group">
                            <div class="checkbox" :class="{active: getService(item.id)>-1}" @click="addRemoveService(item.id,item.price)">
                                <div class="off_caption">off</div>
                                <div class="checkbox_body"></div>
                                <div class="checkbox_check">•</div>
                                <div class="on_caption">on</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hr_footer">
                <p>TOTAL: <span class="text_accent">$ {{this.$store.getters.getTotal}} </span></p><button class="button" @click="nextStep" >SAVE SERVICE</button>
            </div>
        </section>
        <section class="navigation-buttons">
            <button class="prev-page" @click="backStep"></button>
        </section>
    </div>

</template>

<script>
    import progressBar from './progressbar'
    export default {
        name: "additionalService",
        data(){
            return{
                addedServices: null
            }
        },
        methods:{
            selectPackage(name){
                this.$store.commit('setPackage',name)
            },
            nextStep(){
                this.$store.commit('setCompanyPage', 'payment')
                this.$router.push({path: '/payment'})
            },
            backStep(){
                this.$store.commit('setCompanyPage', 'package')
                this.$router.push({path: '/packages'})
            },
            addRemoveService(serviceId,price){
                if(this.getService(serviceId)==-1){
                    this.addService(serviceId,price)
                }else if(this.getService(serviceId)>-1){
                    this.removeService(serviceId,price)
                }
            },
            addService(serviceId,price){
                let Total = this.$store.getters.getTotal
                let newTotal = parseInt(Total)+parseInt(price)
                this.$store.commit('setTotal', newTotal)
                this.$store.commit('addService', serviceId)
            },
            removeService(serviceId,price){
                let Total = this.$store.getters.getTotal
                let newTotal = parseInt(Total)-parseInt(price)
                this.$store.commit('setTotal', newTotal)
                this.$store.commit('removeService',serviceId)
            },
            getService(serviceId){
                let addedServices = this.$store.getters.getAddedServices
                return addedServices.indexOf(serviceId)
            },
            service(pack){
                let selPack = this.$store.state.newCompany.package_selected
                if(selPack=='Basic'&&pack=='b'){
                    return false
                }else{
                    if(selPack=='Standart'&&(pack=='b' || pack=='s')){
                        return false
                    }else{
                        if(selPack=='Premium'&&(pack=='b' || pack=='s'|| pack=='p')){
                            return false
                        }else{
                            if(selPack=='Ultimate'&&(pack=='b' || pack=='s'|| pack=='p'|| pack=='u')){
                                return false
                            }else{
                                return true
                            }
                        }

                    }

                }


            }
        },
        computed:{
            flagSrc(){
                return 'static/img/flag/'+this.$store.getters.getCompanyCountryCode.toLowerCase()+'.png'
            },
            page: {
                get(){
                    return this.$store.getters.getCompanyPage
                },
                set(value){
                    this.$store.commit('setCompanyPage', value);
                }
            },
        },
        components: {
            progressBar,
        },
        mounted(){
        }

    }
</script>

<style scoped lang="sass">
    .fade-enter-active, .fade-leave-active
        opacity: 1
        transition: all .5s ease-in-out
    .fade-enter, .fade-leave-to
        opacity: 0
</style>