<template>
    <section class="progress-bar-section">
        <div class="container">
            <div class="progress-bar" :data-step="currentStep">
                <ul class="progress-time">
                    <li class="current-step">1 min</li>
                    <li :class="{'current-step': currentStep>2}">2 min</li>
                    <li :class="{'current-step': currentStep>3}">5 min</li>
                    <!--<li :class="{'current-step': currentStep>4}">3 min</li>-->
                    <!--<li :class="{'current-step': currentStep>5}">2 min</li>-->
                </ul>
            </div>
            <ul class="progress-points" >
                <li class="complete-step edit-company-step">
                    <span v-if="currentStep>=1&&paymentStatus==''" class="step-num" @click="goto('','addcompany')">1</span>
                    <span v-else class="step-num">1</span>
                    <span class="progress-heading">Basic Info</span></li>
                <li :class="{'current-step' : currentStep==2, 'complete-step' :currentStep>2}">
                    <span v-if="currentStep>2&&paymentStatus==''" class="step-num" @click="goto('package','packages')">2</span>
                    <span v-else class="step-num">2</span>
                    <span class="progress-heading">Select Package</span>
                </li>
                <li :class="{'current-step' : currentStep==3, 'complete-step' :currentStep>3}">
                    <span v-if="currentStep>3&&paymentStatus==''" class="step-num" @click="goto('service','additionalService')">3</span>
                    <span v-else class="step-num">3</span>
                    <span class="progress-heading">Additional services</span>
                </li>
                <li :class="{'current-step' : currentStep==4, 'complete-step' :currentStep>4}">
                    <span class="step-num">4</span>
                    <span class="progress-heading">Payments</span>
                </li>
                <!--<li :class="{'current-step' : currentStep==5, 'complete-step' :currentStep>5}"><span class="step-num">5</span><span class="progress-heading">Due Dilligence</span></li>-->
                <!--<li ><span class="step-num">6</span><span class="progress-heading">Submission</span></li>-->
            </ul>

        </div>
    </section>
</template>

<script>
    export default {
        name: "progressbar.vue",
        data(){
            return{
                currentStep: 0,
            }
        },
        computed:{
            page: {
                get(){
                    return this.$store.getters.getCompanyPage
                },
                set(value){
                    this.$store.commit('setCompanyPage', value);
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

        },
        methods:{
            goto(pages,link){
                this.page=pages
                this.$router.push({path: '/'+link})
            }
        },
        mounted(){
            if(this.page == "package"){
                this.currentStep=2
            }else if(this.page =="service"){
                this.currentStep=3
            }else if(this.page == "payment"){
                this.currentStep=4
            }else if(this.page == "dilligence"){
                this.currentStep=5
            }
        }
    }
</script>

<style scoped>
    /* Progress Bar Start */
    a{
        text-decoration: none;
    }
    span{
        text-decoration: none;
    }
    .progress-bar-section{
        margin: 15px 0 65px;
    }
    .progress-bar-section .container{
        width: 100%;
        max-width: 1280px;
        padding-left: 70px;
        padding-right: 70px;
    }
    .progress-time{
        padding: 0;
        margin: 0;
        list-style: none;
        color: #000;
        font-size: 15px !important;
        display: flex;
        justify-content: space-between;
        position: relative;
        z-index: 10;
    }
    .progress-time li{
        width: 33.3%;
        text-align: center;
        height: 20px;
        line-height: 21px;
    }
    .progress-time li.current-step{
        color: #fff;
        width: 33.3% !important;
    }
    .progress-bar{
        width: 100%;
        height: 20px;
        border-radius: 10px;
        background: #f3300c; /* Old browsers */
        background: -moz-linear-gradient(left, #f3300c 0%, #fb9f35 50%, #0bc64c 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(left, #f3300c 0%,#fb9f35 50%,#0bc64c 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to right, #f3300c 0%,#fb9f35 50%,#0bc64c 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        position: relative;
        overflow: hidden;
    }
    .progress-bar:after{
        position: absolute;
        width: 100%;
        height: 100%;
        content: '';
        top:0;
        left: 0;
        background-color: #eee;
        z-index: 5;
    }
    .progress-bar[data-step="2"]:after{
        left: 33.3%;
    }
    .progress-bar[data-step="3"]:after{
        left: 66.6%;
    }
    .progress-bar[data-step="4"]:after{
        left: 100%;
    }
    /*.progress-bar[data-step="5"]:after{*/
        /*left: 80%;*/
    /*}*/
    /*.progress-bar[data-step="6"]:after{*/
        /*left: 100%;*/
    /*}*/
    .progress-points{
        padding: 0;
        margin: -25px -10px 0;
        list-style: none;
        display: flex;
        justify-content: space-between;
        position: relative;
        text-align: center;
    }
    .progress-points li{
        position: relative;
        cursor: pointer;
        width: 30px;
        height: 30px;
        background-color: #fff;
        border-radius: 50%;
        display: block;
        box-shadow: 0 0 5px rgba(0,0,0,0.4);
        z-index: 15;
    }
    .progress-points a:hover{
        text-decoration: none;
        cursor: pointer;
    }
    /*.step-point{
        width: 25px;
        height: 25px;
        background-color: #fff;
        border-radius: 50%;
        display: block;
        box-shadow: 0 0 5px rgba(0,0,0,0.4);
    }*/
    .progress-heading{
        position: absolute;
        padding: 10px;
        width: 140px;
        left: 50%;
        transform: translateX(-50%);
        top:20px;
        opacity: 0;
        visibility: hidden;
        box-shadow: 0 0 5px rgba(0,0,0,0.4);
        border-radius: 10px;
        background-color: #fff;
        color: #6e6e6e;
        cursor: default;
        transition: 0.3s all ease;
    }
    .progress-points li:hover .progress-heading,
    .progress-points .current-step .progress-heading{
        opacity: 1;
        visibility: visible;
        top:35px;
    }
    .step-num{
        color: #000;
        display: block;
        line-height: 30px;
    }
    .complete-step .step-num{
        opacity: 0;
    }
    .complete-step:before{
        position: absolute;
        width: 13px;
        height: 7px;
        border-left: 2px solid #1ed75f;
        border-bottom: 2px solid #1ed75f;
        transform: rotate(-45deg);
        content: '';
        top:10px;
        left: 8px;
    }
    .progress-heading{
        font-size: 14px !important;
    }
    @media (max-width: 767px){
        .progress-bar-section{
            display: none;
        }
    }
    /* Progress Bar End */
</style>