<template>
    <div class="col-sm-6 col-md-4 col-lg-3 comp-card-wrapp">
        <div class="comp-card settings-card box_shadow_hover_roundshadow" id="comp-card-2" data-toggle="modal"
             data-target="#dilligance_info" @click="dilliganceForm = true">
            <div>
                <div class="comp-card-heading">
                    <h3>DILLIGENCE</h3>
                    <h4>You must add more diligence info</h4>
                </div>
                <div class="centrize">
                    <div class="doughnut">
                        <DoughnutChart :percent="Number(dilliganceStatus)"
                                       :foregroundColor="ChartColor(dilliganceStatus)"
                                       :backgroundColor="this.chart.backgroundColor" :radius="this.chart.radius"
                                       :width="this.chart.width" :height="this.chart.height"
                                       :strokeWidth="this.chart.strokeWidth" :visibleValue="this.chart.visibleValue"
                                       :classValue="this.chart.classValue"></DoughnutChart>
                        <div class="doughnut_chart_after" :style="ChartStyle(ChartColor(dilliganceStatus))">
                            {{Math.round(Number(dilliganceStatus))}}%
                        </div>
                    </div>
                </div>
            </div>
            <button data-toggle="modal" data-target="#dilligance_info" class="more-details"
                    @click="dilliganceForm = true">Edit
            </button>
        </div>
        <div class="modal fade settings-modal" :class="{'show': dilliganceForm}" id="dilligance_info"
             data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="min-width: 33px;">&times;</button>
                    <div class="modal-body">
                        <h4 class="modal-title text-center">DILLIGANCE INFORMATION FORM</h4>

                        <form action="" class="ubo-form">
                            <p>• Declaration by the ultimate beneficial owner (UBO) of Company</p>
                            <p>• I, the undersigned, being the UBO of , request that II SERVICES LIMITED acts as our
                                service provider and declare and affirm that:</p>
                            <p>• I am aware that the provision of corporate services is regulated by the Prevention and
                                Suppression of Money Laundering Activities Laws of 2007 as amended, and as such,
                                directors and staff in Firms providing corporate services, having any knowledge or
                                suspicion that another person is involved in a money laundering or terrorist financing
                                offence and who has become aware of the information on which the knowledge or reasonable
                                suspicion is based in the course of his occupation, profession or business, are required
                                to disclose such information to the The Monetary Authority. In such circumstances they
                                are not obliged to discuss such reports with clients because of the restrictions imposed
                                by the tipping off provisions of the anti-money laundering legislation.</p>
                            <p>• I have not been involved in any illegal activity in any part of the world and have not
                                been declared bankrupt or have been a director or otherwise concerned in the management
                                of any company which has been subject to an insolvent liquidation and/or I am unaware of
                                any activities I have engaged in, that involve money-laundering.</p>
                            <p>• Any contributions that will be made into the Company as share capital or otherwise as
                                shareholder’s funds or from external financing will not derive from unlawful or immoral
                                sources either in their country of origin or in my country of ordinary residence or in
                                Cyprus.</p>
                            <p>• If applicable - The settlor or named beneficiary(ies) of a trust holding a beneficial
                                interest have not been involved in any illegal activity and have not been declared
                                bankrupt anywhere in the world.</p>
                            <!--<div class="ubo-checkboxes clearfix">-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="decliam" checked value="true" id="d-rad-1">-->
                            <!--<label for="d-rad-1"><span></span>I am</label>-->
                            <!--</div>-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="decliam" value="false" id="d-rad-2">-->
                            <!--<label for="d-rad-2"><span></span>I am not</label>-->
                            <!--</div>-->
                            <!--<span>an individual with United States indicia i.e. address, phone no., place of birth, citizenship or dealings* with US.</span>-->
                            <!--</div>-->
                            <!--<p>• standing instructions to transfer funds to an account maintained in the US, ii) a power of attorney or signatory authority which is granted to a person with a US address or iii) existence of an “in care of” or-->
                            <!--<br>“hold mail address” or U.S. P.O.Box.</p>-->

                            <div class="ubo-checkboxes clearfix">
                                <div class="ubo-checkbox">
                                    <input type="radio" class="c_checkbox" v-model="declihave" checked value="true"
                                           id="d-rad-3">
                                    <label for="d-rad-3"><span></span>I have</label>
                                </div>
                                <div class="ubo-checkbox">
                                    <input type="radio" class="c_checkbox" v-model="declihave" value="false"
                                           id="d-rad-4">
                                    <label for="d-rad-4"><span></span>have not been</label>
                                </div>
                                <span>entrusted with a public prominent function.</span>
                            </div>

                            <div class="ubo-checkboxes clearfix">
                                <div class="ubo-checkbox">
                                    <input type="radio" class="c_checkbox" v-model="declrelated" checked value="true"
                                           id="d-rad-5">
                                    <label for="d-rad-5"><span></span>I am related to a person</label>
                                </div>
                                <div class="ubo-checkbox">
                                    <input type="radio" class="c_checkbox" v-model="declrelated" value="false"
                                           id="d-rad-6">
                                    <label for="d-rad-6"><span></span>am not related to any person</label>
                                </div>
                                <span>who holds a public function.</span>
                            </div>

                            <div class="ubo-checkboxes clearfix">
                                <div class="ubo-checkbox">
                                    <input type="radio" class="c_checkbox" v-model="pepList" checked value="true"
                                           id="d-rad-7">
                                    <label for="d-rad-7"><span></span>I have been included in a list</label>
                                </div>
                                <div class="ubo-checkbox">
                                    <input type="radio" class="c_checkbox" v-model="pepList" value="false" id="d-rad-8">
                                    <label for="d-rad-8"><span></span>have never been included in any list</label>
                                </div>
                                <span>of Politically Exposed Persons</span>
                            </div>

                            <p>(PEPs). <br>
                                Furthermore, I hereby confirm that the information provided above is true, correct and
                                complete and agree to immediately notify Comformo in writing in case of a change with
                                respect to the above and representations made herein.</p>

                            <p>Additionally, I hereby agree for Comformo to disclose my identity as UBO of the Company
                                to any commercial bank for the purpose of opening a bank account in the name of the
                                Company.</p>


                            <!--<div class="ubo-checkboxes clearfix">-->
                            <!--<span style="float: left; margin-right: 20px;">Are you a U.S.A. Citizen? </span>-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="usa_citizen" checked value="true" id="d-rad-9">-->
                            <!--<label for="d-rad-9"><span></span>Yes</label>-->
                            <!--</div>-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="usa_citizen" value="false" id="d-rad-10">-->
                            <!--<label for="d-rad-10"><span></span>No</label>-->
                            <!--</div>-->
                            <!--</div>-->

                            <!--<div class="ubo-checkboxes clearfix">-->
                            <!--<span style="float: left; margin-right: 20px;">Are you a U.S.A. Resident?</span>-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="usa_rezident" checked value="true" id="d-rad-11">-->
                            <!--<label for="d-rad-11"><span></span>Yes</label>-->
                            <!--</div>-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="usa_rezident" value="false" id="d-rad-12">-->
                            <!--<label for="d-rad-12"><span></span>No</label>-->
                            <!--</div>-->
                            <!--</div>-->

                            <!--<div class="ubo-checkboxes clearfix">-->
                            <!--<span style="float: left; margin-right: 20px;">Do you hold a valid U.S.A. Permanent Resident Card (a Green Card)? </span>-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="usa_resident_card" checked value="true" id="d-rad-13">-->
                            <!--<label for="d-rad-13"><span></span>Yes</label>-->
                            <!--</div>-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="usa_resident_card" value="false" id="d-rad-14">-->
                            <!--<label for="d-rad-14"><span></span>No</label>-->
                            <!--</div>-->
                            <!--</div>-->

                            <!--<div class="ubo-checkboxes clearfix">-->
                            <!--<span style="float: left; margin-right: 20px;">Do you have a U.S.A. Mailing Address or P.O. Box number?</span>-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="usa_mail_address" checked value="true" id="d-rad-15">-->
                            <!--<label for="d-rad-15"><span></span>Yes</label>-->
                            <!--</div>-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="usa_mail_address" value="false" id="d-rad-16">-->
                            <!--<label for="d-rad-16"><span></span>No</label>-->
                            <!--</div>-->
                            <!--</div>-->

                            <!--<div class="ubo-checkboxes clearfix">-->
                            <!--<span style="float: left; margin-right: 20px;">Do you have a U.S.A In-Care-of Address?</span>-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="usa_care" checked value="true" id="d-rad-17">-->
                            <!--<label for="d-rad-17"><span></span>Yes</label>-->
                            <!--</div>-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="usa_care" value="false" id="d-rad-18">-->
                            <!--<label for="d-rad-18"><span></span>No</label>-->
                            <!--</div>-->
                            <!--</div>-->

                            <!--<div class="ubo-checkboxes clearfix">-->
                            <!--<span style="float: left; margin-right: 20px;">Do you have a U.S.A Phone Number? </span>-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="usa_phone" checked value="true" id="d-rad-19">-->
                            <!--<label for="d-rad-19"><span></span>Yes</label>-->
                            <!--</div>-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="usa_phone" value="false" id="d-rad-20">-->
                            <!--<label for="d-rad-20"><span></span>No</label>-->
                            <!--</div>-->
                            <!--</div>-->

                            <!--<div class="ubo-checkboxes clearfix">-->
                            <!--<span style="float: left; margin-right: 20px;">Do you have a Standing Order to transfer funds to an account(s) maintained in the U.S.A.? </span>-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="usa_standing_order" checked value="true" id="d-rad-21">-->
                            <!--<label for="d-rad-21"><span></span>Yes</label>-->
                            <!--</div>-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="usa_standing_order" value="false" id="d-rad-22">-->
                            <!--<label for="d-rad-22"><span></span>No</label>-->
                            <!--</div>-->
                            <!--</div>-->

                            <!--<div class="ubo-checkboxes clearfix">-->
                            <!--<span style="float: left; margin-right: 20px;">Do you currently have a valid Power of Attorney or Signatory Authority granted to a U.S.A. person or a person with a U.S.A. address?  </span>-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="usa_sign_auth" checked value="true" id="d-rad-23">-->
                            <!--<label for="d-rad-23"><span></span>Yes</label>-->
                            <!--</div>-->
                            <!--<div class="ubo-checkbox">-->
                            <!--<input type="radio" class="c_checkbox" v-model="usa_sign_auth" value="false" id="d-rad-24">-->
                            <!--<label for="d-rad-24"><span></span>No</label>-->
                            <!--</div>-->
                            <!--</div>-->

                            <div class="signature-block clearfix">
                                <div class="signature">
                                    <signature @signed="canvasSave" class="signature-pad" ref="canvas"></signature>
                                </div>
                                <div class="signature-buttons">
                                    <button class="submit-transparent" style="width: 250px; margin-bottom: 20px"
                                            @click.prevent="clear">CLEAR
                                    </button>
                                    <button class="submit-yellow" style="width: 250px" @click.prevent="save">Success
                                        signature
                                    </button>
                                </div>
                            </div>
                            <transition name="fade">
                                <button class="submit popup-submit" :disabled="checkSign"
                                        @click.prevent="saveDillegance" data-dismiss="modal">save and continue
                                </button>
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
        name: "dilligance",
        data() {
            return {
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
                dilliganceStatus: '',
                option: {
                    penColor: "rgb(0, 0, 0)",
                    backgroundColor: "rgb(255,255,255)"
                },

                decliam: false,
                declihave: false,
                declrelated: false,
                pepList: false,
                usa_citizen: false,
                usa_rezident: false,
                usa_resident_card: false,
                usa_mail_address: false,
                usa_care: false,
                usa_phone: false,
                usa_standing_order: false,
                usa_sign_auth: false,
                signature: null,
                dilliganceForm: false,
            }
        },
        computed: {
            checkSign() {
                if (this.signature != null) {
                    return false
                } else {
                    return true
                }
            }
        },
        methods: {
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
            clear() {
                this.$refs.canvas.clearSignature();
            },
            save() {
                this.$refs.canvas.saveSignature();
            },
            canvasSave(signature) {
                this.signature = signature
            },
            resizeCanvas: function () {
                let ratio = Math.max(window.devicePixelRatio || 1, 1);
                this.$refs.canvas.width = this.$refs.canvas.offsetWidth * ratio
                this.$refs.canvas.height = this.$refs.canvas.offsetHeight * ratio
                this.$refs.canvas.getContext('2d').scale(ratio, ratio)
            },
            saveDillegance() {
                let fd = new FormData
                fd.append('decliam', this.decliam)
                fd.append('declihave', this.declihave)
                fd.append('declrelated', this.declrelated)
                fd.append('pepList', this.pepList)
                fd.append('USACitizen', this.usa_citizen)
                fd.append('USAResident', this.usa_rezident)
                fd.append('USAValidGreenCard', this.usa_resident_card)
                fd.append('USAMailAddressBoxNum', this.usa_mail_address)
                fd.append('USAinCareAddress', this.usa_care)
                fd.append('USAphoneNumber', this.usa_phone)
                fd.append('USAtransferFunds', this.usa_standing_order)
                fd.append('USAvalidAttorney', this.usa_sign_auth)
                fd.append('sign', this.signature)
                fd.append('companyStatus', 'dillegance=100')
                fd.append('updateCompany', this.$route.params.id)
                axios.post(this.$store.getters.getPostUrl, fd)
                    .then((res) => {
                        if (res.data.mess == 'Sql UPDATE is ok') {
                            this.dilliganceForm = false
                            let newfd = new FormData
                            newfd.append('myCompanys', this.$store.getters.get_id)
                            axios.post(this.$store.getters.getPostUrl, newfd).then((res) => {
                                this.$store.commit('setMyCompanys', res.data)
                                this.dilliganceStatus = 100
                            })
                        }
                    })
            }
        },
        components: {
            DoughnutChart, signature
        },
        mounted() {
            let id = this.$route.params.id
            const MyCompanys = this.$store.getters.getMyCompanys
            MyCompanys.forEach((item) => {
                if (item.id == id) {
                    this.company = item
                    let status = JSON.parse(item.companyStatus)
                    this.dilliganceStatus = status.dillegance
                    this.companyName = item.companyName
                }
            })
        }

    }
</script>

<style scoped>

</style>