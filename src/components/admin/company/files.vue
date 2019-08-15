<template>
    <div class="col-sm-6 col-md-4 col-lg-3 comp-card-wrapp">
        <div class="comp-card settings-card box_shadow_hover_roundshadow" id="comp-card-0" data-toggle="modal" data-target="#files_info" @click="filesForm=true">
            <div>
                <div class="comp-card-heading">
                    <h3>ADD DOCUMENTS</h3>
                    <h4>Add scan <br>documents</h4>
                </div>
                <div class="centrize">
                    <div v-if="preload"><img src="/static/img/loading.gif" alt="loder" style="height: 20px"></div>
                    <div v-else class="doughnut">
                        <DoughnutChart :percent="Number(filesStatus)" :foregroundColor="ChartColor(filesStatus)" :backgroundColor="this.chart.backgroundColor" :radius="this.chart.radius" :width="this.chart.width" :height="this.chart.height" :strokeWidth="this.chart.strokeWidth" :visibleValue="this.chart.visibleValue" :classValue="this.chart.classValue"></DoughnutChart>
                        <div class="doughnut_chart_after" :style="ChartStyle(ChartColor(filesStatus))">{{Math.round(filesStatus)}}%</div>
                    </div>
                </div>
            </div>
            <button data-toggle="modal" data-target="#files_info" class="more-details" @click="filesForm=true">Edit</button>
        </div>
        <div class="modal fade settings-modal" :class="{show: filesForm}" id="files_info" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="min-width: 33px;">&times;</button>
                    <div class="modal-body">
                        <h4 class="modal-title text-center">ADD SCAN DOCUMENTS</h4>
                        <div class="row">
                            <h5 class="centrize">Add scan documents</h5>
                            <div style="display: grid; width: 100%;">
                                <addImage :btnCaption="'Add Passport'" @files="passportAdd($event)"></addImage>
                                <addImage :btnCaption="'Add Address'" @files="addressAdd($event)"></addImage>
                                <addImage :btnCaption="'Add Other'" @files="otherAdd($event)"></addImage>
                                <!--<button class="submit" style="margin: 20px auto; width: 250px; " @click.prevent="">Upload Documents</button>-->
                                <!--<p v-if="documentMess!=''" class="text_accent centrize">{{documentMess}}</p>-->
                            </div>
                        </div>
                        <transition name="fade">
                            <button class="submit popup-submit" :disabled="filesCheckData" @click="addAllDocs()" data-dismiss="modal">Upload Documents and Save</button>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import DoughnutChart from 'vue-doughnut-chart'
    import vselect from 'vue-select'
    import addImage from '@/components/addImage'

    export default {
        name: "files",
        data(){
            return{
                reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
                inputOk: 'valid',
                inputErr: 'err',
                labelCaptionUp: 'label-up',
                chart: {
                    percent: 0,
                    foregroundColor: "red",
                    backgroundColor: "transperent",
                    radius: 90,
                    width: 140,
                    height: 140,
                    strokeWidth: 20,
                    visibleValue: false,
                    classValue: "percent"
                },
                company: '',
                resStatus: '',
                filesStatus: 0,
                filesForm: false,
                ducumentsUpload: false,
                documentMess: '',
                passportFiles: [],
                addressFiles: [],
                otherFiles: [],
                preload: false,
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
            passportAdd(data){
                this.passportFiles=data
            },
            addressAdd(data){
                this.addressFiles=data
            },
            otherAdd(data){
                this.otherFiles=data
            },
            addAllDocs(){
                this.AddDocumentsForm = false
                let fd = new FormData
                if(this.passportFiles){
                    let files = this.passportFiles; //это массив файлов
                    for(let i=0;i<files.length;i++){
                        fd.append("passportFile_"+i,files[i]);
                    }
                }
                if(this.addressFiles) {
                    let files = this.addressFiles; //это массив файлов
                    for (let i = 0; i < files.length; i++) {
                        fd.append("addressFile_" + i, files[i]);
                    }
                }
                if(this.otherFiles) {
                    let files = this.otherFiles; //это массив файлов
                    for (let i = 0; i < files.length; i++) {
                        fd.append("otherFile_" + i, files[i]);
                    }
                }
                fd.append('saveCompanyDocs','save')
                fd.append('companyId', this.$route.params.id)
                axios.post(this.$store.getters.getPostUrl, fd)
                    .then(res=>{
                        let data = res.data
                        data.forEach(item=>{
                            if(item.files.mess=='Sql INSERT is ok'){
                                this.ducumentsUpload = true
                                this.documentMess = 'Ok documents loaded!'
                                if(item.task.mess=='Sql INSERT is ok'){
                                    this.documentMess = this.documentMess+'Your Manager is notified!'
                                }
                            }else{
                                this.documentMess = 'Not all documents loaded'
                            }
                        })

                    })
            },
            allCountry(){
                let countrys = this.$store.getters.getAllCountry
                let SelCountry = []
                SelCountry.push({'index': 'all','label': 'All Country'})
                countrys.forEach(country=>{
                    let c = {'index': country.id,'label': country.jurisdictionname}
                    SelCountry.push(c)
                })
                return SelCountry
            },
            loadStatus(){
                this.preload=true
                axios.post(this.$store.getters.getPostUrl,'checkDocsStatus='+this.$route.params.id)
                    .then(res=>{
                        if(res.data.loaded=='Sql is empty'){
                            if(res.data.Confirm=='Sql is empty'){
                                if(res.data.Cancel=='Sql is empty'){
                                    this.filesStatus = 0

                                }else{
                                    this.filesStatus = 25
                                }
                            }else{
                                this.filesStatus = 100
                            }
                        }else{
                            this.filesStatus = 50
                        }
                        this.preload=false
                    })
            }
        },
        components: {
            DoughnutChart,
            vselect,
            addImage,
        },
        computed:{
            filesCheckData(){

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
        },
        mounted(){
            let id = this.$route.params.id
            const MyCompanys = this.$store.getters.getMyCompanys
            MyCompanys.forEach((item)=>{
                if(item.id == id){
                    let status = JSON.parse(item.companyStatus)
                    this.filesStatus = parseInt(status.files)
                    this.companyName= item.companyName
                }
            })
            this.loadStatus()
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
        h4
            font-size: .91em
            text-align: center
            margin: 10px
        h5
            margin: 8px
            font-size: 1.25em
        .companys_header_top
            font-size: 1em
</style>