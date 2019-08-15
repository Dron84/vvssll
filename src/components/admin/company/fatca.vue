<template>
    <div class="col-sm-6 col-md-4 col-lg-3 comp-card-wrapp">
        <div class="comp-card settings-card box_shadow_hover_roundshadow" data-toggle="modal" data-target="#fatca_info" id="comp-card-3" @click="fatcaForm = true">
            <div>
                <div class="comp-card-heading">
                    <h3>FATCA</h3>
                    <h4>You must add more  FATCA info</h4>
                </div>
                <div class="centrize">
                    <div class="doughnut">
                        <DoughnutChart :percent="Number(fatcaStatus)" :foregroundColor="ChartColor(fatcaStatus)" :backgroundColor="this.chart.backgroundColor" :radius="this.chart.radius" :width="this.chart.width" :height="this.chart.height" :strokeWidth="this.chart.strokeWidth" :visibleValue="this.chart.visibleValue" :classValue="this.chart.classValue"></DoughnutChart>
                        <div class="doughnut_chart_after" :style="ChartStyle(ChartColor(fatcaStatus))">{{fatcaStatus}}%</div>
                    </div>
                </div>
            </div>
            <button data-toggle="modal" data-target="#fatca_info" class="more-details"  @click="fatcaForm = true">Edit</button>
        </div>
        <div class="modal fade settings-modal" :class="{'show': fatcaForm}" id="fatca_info" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="min-width: 33px;">&times;</button>
                    <div class="modal-body">
                        <h4 class="modal-title text-center">FATCA INFORMATION FORM</h4>

                        <form action="" class="fatca-form">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-wrapper">
                                        <input type="text" class="form-control" :class="[this.$store.getters.get_firstName.toLowerCase()==firstName.toLowerCase() ? inputOk: inputErr ]" required name="fatca-fname" id="fatca-fname" v-model="firstName">
                                        <label for="fatca-fname" :class="{'label-up': firstName!=''}">First Name</label>
                                    </div>
                                    <div class="input-wrapper">
                                        <input type="text" class="form-control" :class="[this.$store.getters.get_lastName.toLowerCase()==lastName.toLowerCase() ? inputOk: inputErr ]" required name="fatca-lname" id="fatca-lname" v-model="lastName">
                                        <label for="fatca-lname" :class="{'label-up': lastName!=''}">Last Name</label>
                                    </div>
                                    <p ref="SignatureConfirmationLabel">I {{firstName}} {{lastName}} do hereby declare that the signature specimen below is my true signature, and the signature to be used for identification purposes.</p>
                                    <div class="signature">
                                        <signature @signed="canvasSave" class="signature-pad" ref="canvas"></signature>
                                        <div class="signature-buttons">
                                            <a href="#" class="submit-transparent" @click.prevent="clear">CLEAR</a>
                                            <a href="#" class="submit-yellow" @click.prevent="save">Success signature</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <p>Give the TEXT</p>

                                    <p>A set of legalized company documents consisting of:</p>

                                    <ul>
                                        <li>Certificate of Incorporation.</li>
                                        <li>Memorandum and Articles of Associations.</li>
                                        <li>Documents confirming the appointment of company directors and secretary (if any)</li>
                                        <li>Document confirming the location of the registered office.</li>
                                        <li>Share Certificate(s).</li>
                                        <li>Certificate of Good Standing if the company is more than 12 months old.</li>
                                        <li>Copy of the Corporate Structure, identifying the ultimate beneficial owner(s).</li>
                                        <li>Valid License (if applicable).</li>
                                        <li>In cases where shareholders and/or directors are corporate bodies, full apostilled set of corporate documents will be required:</li>
                                    </ul>

                                    <p>Certificate of Incorporation, List of Directors, Shareholders, Secretary, Share Certificate, copy of `Declaration of Trust' between nominee shareholder(s) and ultimate beneficial owner(s) (if applicable), Certificate of Good Standing (if the company has been operating for 1 year or more); Notarized copy of a valid passport, utility bill and the reference letter for each individual Director, Shareholder and Beneficial Owner.
                                    </p>

                                    <p>Please ensure all Key Parties and Account Signatories have read all Sections and signed this Application Form as appropriate.</p>

                                    <p>All of the above listed documents should be submitted by email to: Legal@comformo.com or uploaded to Comformo website in the relevant section and thereafter posted.</p>

                                </div>
                            </div>
                            <transition name="fade">
                            <button class="submit popup-submit" data-dismiss="modal" @click.prevent="saveFatca" :disabled="checkSign">save and continue</button>
                            </transition>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import DoughnutChart from 'vue-doughnut-chart'
    import signature from '@/components/admin/company/signature'

    export default {
        name: "fatca",
        data(){
            return{
                reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
                inputOk: 'valid',
                inputErr: 'err',
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
                fatcaStatus:'',
                fatcaForm: false,
                option:{
                    penColor:"rgb(0, 0, 0)",
                    backgroundColor:"rgb(255,255,255)"
                },
                lastName: '',
                firstName: '',
                signature: null,
            }
        },
        computed:{
            checkSign(){
                if(this.signature!=null&&this.$store.getters.get_lastName.toLowerCase()==this.lastName.toLowerCase()&&this.$store.getters.get_firstName.toLowerCase()==this.firstName.toLowerCase()){
                    return false
                }else{
                    return true
                }
            }
        },
        methods:{
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
            clear(){
                this.$refs.canvas.clearSignature();
            },
            save(){
                this.$refs.canvas.saveSignature();
            },
            canvasSave(signature){
                this.signature = signature
            },
            resizeCanvas: function() {
                let ratio =  Math.max(window.devicePixelRatio || 1, 1);
                this.$refs.canvas.width = this.$refs.canvas.offsetWidth * ratio
                this.$refs.canvas.height = this.$refs.canvas.offsetHeight * ratio
                this.$refs.canvas.getContext('2d').scale(ratio, ratio)
            },
            saveFatca(){
                let fd = new FormData
                fd.append('SignatureConfirmationLabel', this.$refs.SignatureConfirmationLabel.innerText)
                fd.append('SignatureFirstName', this.firstName)
                fd.append('SignatureLastName', this.lastName)
                fd.append('SignatureConfirm', true)
                fd.append('fatcaSign', this.signature)
                fd.append('companyStatus', 'fatca=100')
                fd.append('updateCompany', this.$route.params.id)
                axios.post(this.$store.getters.getPostUrl, fd)
                    .then((res)=>{
                        if(res.data.mess=='Sql UPDATE is ok'){
                            this.fatcaForm=false
                            let newfd = new FormData
                            newfd.append('myCompanys',this.$store.getters.get_id)
                            axios.post(this.$store.getters.getPostUrl,newfd).then((res)=>{
                                this.$store.commit('setMyCompanys',res.data)
                                this.fatcaStatus = 100
                            })
                        }
                    })
            }
        },
        components:{
            DoughnutChart,signature
        },
        mounted(){
            let id = this.$route.params.id
            const MyCompanys = this.$store.getters.getMyCompanys
            MyCompanys.forEach((item)=>{
                if(item.id == id){
                    this.company=item
                    let status = JSON.parse(item.companyStatus)
                    this.fatcaStatus =  status.fatca
                    this.companyName= item.companyName
                }
            })
        }

    }
</script>

<style scoped lang="sass">

</style>