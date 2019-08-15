<template>
    <div class="companys">
        <h2 class="companys_header_top">Company name is: "{{company.companyName}}"</h2>
        <section class="companies">
            <div class="container">
                <div class="row">
                    <general></general>
                    <ubo></ubo>
                    <files></files>
                    <dilligance></dilligance>
                    <!--<fatca></fatca>-->
                </div>
                <div class="text-center">
                    <router-link to="/companys" class="submit"><slot name="caption">Back</slot></router-link>
                    <button class="button" @click="createPDF" style="display: inline-grid; height: 34px; position: absolute; right: 20px;" v-if="CStatus()">Download PDF</button>
                </div>
                <button class="button" @click="createXML" style="display: inline-grid; height: 34px; position: absolute; right: 20px;" v-if="CStatus()">Create XML</button>
            </div>
        </section>
    </div>
</template>

<script>
    import general from '@/components/admin/company/general'
    import files from '@/components/admin/company/files'
    import ubo from '@/components/admin/company/ubo'
    import fatca from '@/components/admin/company/fatca'
    import dilligance from '@/components/admin/company/dilligance'
    import pdfMake from 'pdfmake'
    import pdfFonts from "pdfmake/build/vfs_fonts";
    import axios from 'axios'
    let moment = require('moment')
    pdfMake.vfs = pdfFonts.pdfMake.vfs;

    export default {
        name: "company",
        components: {
            general,
            ubo,
            fatca,
            dilligance,
            pdfMake,
            files,
        },
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
                    strokeWidth: 15,
                    visibleValue: false,
                    classValue: "percent"
                },
                company: '',

            }
        },
        methods:{
            isInteger(num) {
                return (num ^ 0) === num;
            },
            ChartColor(percent){
                let color = ''
                if(percent>=0&&percent<=12){
                    color="#c53312"
                }else if(percent > 12 && percent<=25){
                    color='#c53312'
                }else if(percent > 25 && percent<=37){
                    color='#ee5d11'
                }else if(percent > 37 && percent<=50){
                    color='#fb9f35'
                }else if(percent > 50 && percent<=62){
                    color='#dad00b'
                }else if(percent > 62 && percent<=75){
                    color='#c5e204'
                }else if(percent > 75 && percent<=87){
                    color='#62e502'
                }else if(percent > 87){
                    color='#0bc64c'
                }
                return color
            },
            ChartStyle(color) {
                return 'background-color:' + color + ';'
            },
            createPDF(){
                let c = this.company
                if(c.CompanyType == "1"){
                    c.CompanyType = 'Social Media Marketing'
                }else if(c.CompanyType == "2"){
                    c.CompanyType = 'HR Services and Recruiting'
                }else if(c.CompanyType == "3"){
                    c.CompanyType = 'Business Consulting'
                }else if(c.CompanyType == "4"){
                    c.CompanyType = 'Tutoring and Professional Training'
                }else if(c.CompanyType == "5"){
                    c.CompanyType = 'Construction Business'
                }else if(c.CompanyType == "6"){
                    c.CompanyType = 'Web Services and Hosting'
                }else if(c.CompanyType == "7"){
                    c.CompanyType = 'Translation Services'
                }else if(c.CompanyType == "8"){
                    c.CompanyType = 'Hospitality Services'
                }else if(c.CompanyType == "9"){
                    c.CompanyType = 'Affiliate Marketing'
                }else if(c.CompanyType == "10"){
                    c.CompanyType = 'Rental Services'
                }else if(c.CompanyType == "11"){
                    c.CompanyType = 'Event Management'
                }else if(c.CompanyType == "12"){
                    c.CompanyType = 'Retail Shop'
                }else if(c.CompanyType == "13"){
                    c.CompanyType = 'Legal Services'
                }else if(c.CompanyType == "14"){
                    c.CompanyType = 'Accounting Services'
                }
                let p = this.$store.getters.getPersons
                let persons = []
                let decliam,declihave,declrelated,pepList,USACitizen,USAResident,USAValidGreenCard,USAMailAddressBoxNum,USAinCareAddress,USAphoneNumber,USAtransferFunds,USAvalidAttorney,sign = ''
                persons.push(['First Name', 'Last Name', 'Type', 'Email', 'Share','Signature'])
                p.forEach(item=>{
                    // console.log(item);
                    let type=[],sign =''
                    if(item.Director=='true'){
                        type.push('Director')
                    }
                    if(item.Owner=='true'){
                        type.push('Owner')
                    }
                    if(item.Secretary=='true'){
                        type.push('Secretary')
                    }
                    if(item.SignaturyAuthorized=='true'){
                        type.push('Signatury Authorized')
                    }
                    if(item.Shareholder=='true'){
                        type.push('Shareholder')
                    }

                    if(item.DeclanationSign!=''){
                        sign = 'Not Signed'
                    }else{
                        sign = 'Signed'
                    }
                    // console.log(type)
                    let typeStr = type.join(',')
                    persons.push([item.firstName,item.lastName,typeStr,item.email, item.share, sign])
                })
                if(c.decliam == 'false'){
                    decliam = 'I am not an individual with United States indicia i.e. address, phone no., place of birth, citizenship or dealings* with US.'
                }else{
                    decliam = 'I am an individual with United States indicia i.e. address, phone no., place of birth, citizenship or dealings* with US.'
                }
                if(c.declihave == 'false'){
                    declihave = 'Have not been entrusted with a public prominent function.'
                }else{
                    declihave = 'I have entrusted with a public prominent function.'
                }
                if(c.declrelated == 'false'){
                    declrelated = 'I am not related to any person who holds a public function.'
                }else{
                    declrelated = 'I am related to a person who holds a public function.'
                }
                if(c.pepList == 'false'){
                    pepList = 'Have never been included in any list of Politically Exposed Persons'
                }else{
                    pepList = 'I have been included in a list of Politically Exposed Persons'
                }

                if(c.USACitizen == 'false'){
                    USACitizen = 'Are you a U.S.A. Citizen? NO.'
                }else{
                    USACitizen = 'Are you a U.S.A. Citizen? YES.'
                }
                if(c.USAResident == 'false'){
                    USAResident = 'Are you a U.S.A. Resident? NO.'
                }else{
                    USAResident = 'Are you a U.S.A. Resident? YES.'
                }
                if(c.USAValidGreenCard == 'false'){
                    USAValidGreenCard = 'Do you hold a valid U.S.A. Permanent Resident Card (a Green Card)? NO.'
                }else{
                    USAValidGreenCard = 'Do you hold a valid U.S.A. Permanent Resident Card (a Green Card)? YES.'
                }
                if(c.USAMailAddressBoxNum == 'false'){
                    USAMailAddressBoxNum = 'Do you have a U.S.A. Mailing Address or P.O. Box number? NO.'
                }else{
                    USAMailAddressBoxNum = 'Do you have a U.S.A. Mailing Address or P.O. Box number? YES.'
                }
                if(c.USAinCareAddress == 'false'){
                    USAinCareAddress = 'Do you have a U.S.A In-Care-of Address? NO.'
                }else{
                    USAinCareAddress = 'Do you have a U.S.A In-Care-of Address? YES.'
                }
                if(c.USAphoneNumber == 'false'){
                    USAphoneNumber = 'Do you have a U.S.A Phone Number? NO.'
                }else{
                    USAphoneNumber = 'Do you have a U.S.A Phone Number? YES.'
                }
                if(c.USAtransferFunds == 'false'){
                    USAtransferFunds = 'Do you have a Standing Order to transfer funds to an account(s) maintained in the U.S.A.? NO.'
                }else{
                    USAtransferFunds = 'Do you have a Standing Order to transfer funds to an account(s) maintained in the U.S.A.? YES.'
                }
                if(c.USAvalidAttorney == 'false'){
                    USAvalidAttorney = 'Do you currently have a valid Power of Attorney or Signatory Authority granted to a U.S.A. person or a person with a U.S.A. address? NO.'
                }else{
                    USAvalidAttorney = 'Do you currently have a valid Power of Attorney or Signatory Authority granted to a U.S.A. person or a person with a U.S.A. address? YES.'
                }

                let content=[
                    {
                        image: 'data:image/png;base64,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',
                        width: 170,
                        height: 50,
                        alignment: 'left',
                    },
                    {
                        text: c.companyName,
                        fontSize: 25,
                        alignment: 'center',
                        bold: true
                    },
                    {
                        text: 'General information',
                        fontSize: 20,
                        alignment: 'center',
                        bold: true,
                        italics: true,
                        margin: 20,
                    },
                    {
                        text: [
                            {
                                text: 'Website: ',
                                fontSize: 14,
                                bold: true,
                            },
                            {
                                text: c.CompanyWebsite,
                                fontSize: 14,
                            }
                        ]

                    },
                    {
                        text: [
                            {
                                text: 'Email: ',
                                fontSize: 14,
                                bold: true,
                            },
                            {
                                text: c.CompanyEmail,
                                fontSize: 14,
                            }
                        ]

                    },
                    {
                        text: [
                            {
                                text: 'Address: ',
                                fontSize: 14,
                                bold: true,
                            },
                            {
                                text: c.CompanyAddress,
                                fontSize: 14,
                            }
                        ]

                    },
                    {
                        text: [
                            {
                                text: 'Company Type: ',
                                fontSize: 14,
                                bold: true,
                            },
                            {
                                text: c.CompanyType,
                                fontSize: 14,
                            }
                        ]

                    },
                    {
                        text: [
                            {
                                text: 'Authorized Share Capital: ',
                                fontSize: 14,
                                bold: true,
                            },
                            {
                                text: c.AuthorizedShareCapital,
                                fontSize: 14,
                            }
                        ]

                    },
                    {
                        text: [
                            {
                                text: 'Issued Share Capital: ',
                                fontSize: 14,
                                bold: true,
                            },
                            {
                                text: c.IssuedShareCapital,
                                fontSize: 14,
                            }
                        ]

                    },
                    {
                        text: [
                            {
                                text: 'Ordinary Share: ',
                                fontSize: 14,
                                bold: true,
                            },
                            {
                                text: c.OrdinaryShare,
                                fontSize: 14,
                            }
                        ]

                    },
                    {
                        text: [
                            {
                                text: 'Main Activities And Nature Of Company: ',
                                fontSize: 14,
                                bold: true,
                            },
                            {
                                text: c.Activities,
                                fontSize: 14,
                            }
                        ]

                    },
                    {
                        text: 'UBO and Shareholders',
                        fontSize: 20,
                        alignment: 'center',
                        bold: true,
                        italics: true,
                        margin: 20,
                    },
                    {
                        text: 'Persons:',
                        fontSize: 16,
                        bold: true,
                        italics: true,
                    },
                    {
                        table:{
                            heghts: 40,

                            body: persons,
                        }
                    },
                    {
                        text: 'DILLIGANCE INFORMATION FORM',
                        fontSize: 20,
                        alignment: 'center',
                        bold: true,
                        italics: true,
                        margin: 20,
                    },
                    {
                        text: [
                        '• Declaration by the ultimate beneficial owner (UBO) of Company',
                        ],
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: [
                            '• I, the undersigned, being the UBO of , request that II SERVICES LIMITED acts as our service provider and declare and affirm that:',
                        ],
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: [
                            '• I am aware that the provision of corporate services is regulated by the Prevention and Suppression of Money Laundering Activities Laws of 2007 as amended, and as such, directors and staff in Firms providing corporate services, having any knowledge or suspicion that another person is involved in a money laundering or terrorist financing offence and who has become aware of the information on which the knowledge or reasonable suspicion is based in the course of his occupation, profession or business, are required to disclose such information to the The Monetary Authority. In such circumstances they are not obliged to discuss such reports with clients because of the restrictions imposed by the tipping off provisions of the anti-money laundering legislation.',
                        ],
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: [
                            '• I have not been involved in any illegal activity in any part of the world and have not been declared bankrupt or have been a director or otherwise concerned in the management of any company which has been subject to an insolvent liquidation and/or I am unaware of any activities I have engaged in, that involve money-laundering.',
                        ],
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: [
                            '• Any contributions that will be made into the Company as share capital or otherwise as shareholder’s funds or from external financing will not derive from unlawful or immoral sources either in their country of origin or in my country of ordinary residence or in Cyprus.',
                        ],
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: [
                            '• If applicable - The settlor or named beneficiary(ies) of a trust holding a beneficial interest have not been involved in any illegal activity and have not been declared bankrupt anywhere in the world.',
                        ],
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: decliam,
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: '• standing instructions to transfer funds to an account maintained in the US, ii) a power of attorney or signatory authority which is granted to a person with a US address or iii) existence of an “in care of” or\n“hold mail address” or U.S. P.O.Box.',
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: declihave,
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: declrelated,
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: pepList,
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: [
                            {text: '(PEPs).', bold: true},
                            {text: 'Furthermore, I hereby confirm that the information provided above is true, correct and complete and agree to immediately notify Comformo in writing in case of a change with respect to the above and representations made herein.'},
                            {text: 'Additionally, I hereby agree for Comformo to disclose my identity as UBO of the Company to any commercial bank for the purpose of opening a bank account in the name of the Company.'}
                            ],
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: USACitizen,
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: USAResident,
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: USAValidGreenCard,
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: USAMailAddressBoxNum,
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: USAinCareAddress,
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: USAphoneNumber,
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: USAtransferFunds,
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        text: USAvalidAttorney,
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        image: c.sign,
                        width: 350,
                        height: 150
                    },
                    {
                        text: 'FATCA INFORMATION FORM',
                        fontSize: 20,
                        alignment: 'center',
                        bold: true,
                        italics: true,
                        margin: 20,
                    },
                    {
                        text: c.SignatureConfirmationLabel,
                        fontSize: 14,
                        margin: 10
                    },
                    {
                        image: c.fatcaSign,
                        width: 350,
                        height: 150
                    },

                ]
                const documentDefinition = {
                    info:{
                        title: 'Documents by company '+this.company.companyName,
                        author: 'comformo.com',
                        keywords: 'create company '+this.company.companyName,
                    },
                    content,

                }
                pdfMake.createPdf(documentDefinition).download(this.company.companyName);
            },
            CStatus(){
                if(this.generalStatus==100&&this.uboStatus==100&&this.dilliganceStatus==100&&this.fatcaStatus==100){
                    return true
                }else{
                    return false
                }
            },
            createXML(){
                let fd = new FormData
                let Persons = this.$store.getters.getPersons
                let Director = {}
                    Persons.forEach(item=>{
                        if(item.Director='true'){
                            Director = item
                        }
                    })
                fd.append('directorName', Director.firstName +' '+ Director.lastName)
                fd.append('directorPremise', Director.strit +' '+ Director.apartament+', '+ Director.city)
                fd.append('directorPostTown', Director.zip)
                fd.append('directorDOB', Director.dateBirth) //date format 2019-01-07
                fd.append('directorNationality', Director.nationality)
                fd.append('directorOccupation', Director.occupation)
                fd.append('Appointment', JSON.stringify(Persons))
                fd.append('CompanyInfo', JSON.stringify(this.company))
                axios.post('http://cabinet.comformo.com/server/genxml.php', fd).then(res=>{
                    console.log(res.data);
                })
            },

        },

        computed:{
            comp_website:{
                get(){
                    if(this.company.CompanyWebsite!=''){
                        return this.company.CompanyWebsite
                    }else{
                        return this.$store.getters.getEditCompany_website
                    }
                },
                set(value){
                    this.$store.commit('setEditCompany_website', value)
                }
            },
            comp_email:{
                get(){
                    if(this.company.CompanyEmail!=''){
                        return this.company.CompanyEmail
                    }else{
                        return this.$store.getters.getEditCompany_email
                    }
                },
                set(value){
                    this.$store.commit('setEditCompany_email', value)
                }
            },
            comp_addr:{
                get(){
                    if(this.company.CompanyAddress!=''){
                        return this.company.CompanyAddress
                    }else{
                        return this.$store.getters.getEditCompany_addr
                    }
                },
                set(value){
                    this.$store.commit('setEditCompany_addr', value)
                }
            },
            comp_type:{
                get(){
                    if(this.company.CompanyType!=''){
                        return this.company.CompanyType
                    }else{
                        return this.$store.getters.getEditCompany_type
                    }
                },
                set(value){
                    this.$store.commit('setEditCompany_type', value)
                }
            },
            other_comp_type:{
                get(){
                    if(this.company.CompanyTypeOther!=''){
                        return this.company.CompanyTypeOther
                    }else{
                        return this.$store.getters.getEditCompany_other_type
                    }
                },
                set(value){
                    this.$store.commit('setEditCompany_other_type', value)
                }
            },
            AuthorizedShareCapital:{
                get(){
                    if(this.company.AuthorizedShareCapital!=''){
                        return this.company.AuthorizedShareCapital
                    }else{
                        return this.$store.getters.getEditCompany_AuthorizedShareCapital
                    }
                },
                set(value){
                    this.$store.commit('setEditCompany_AuthorizedShareCapital', value)
                }
            },
            OrdinaryShare:{
                get(){
                    if(this.company.OrdinaryShare!=''){
                        return this.company.OrdinaryShare
                    }else{
                        return this.$store.getters.getEditCompany_OrdinaryShare
                    }

                },
                set(value){
                    this.$store.commit('setEditCompany_OrdinaryShare', value)
                }
            },
            IssuedShareCapital:{
                get(){
                    if(this.company.IssuedShareCapital!=''){
                        return this.company.IssuedShareCapital
                    }else{
                        return this.$store.getters.getEditCompany_IssuedShareCapital
                    }
                },
                set(value){
                    this.$store.commit('setEditCompany_IssuedShareCapital', value)
                }
            },
            Activities: {
                get(){
                    if(this.company.activities!=''){
                        return this.company.activities
                    }else{
                        return this.$store.getters.getEditCompany_Activities}
                },
                set(value){
                    this.$store.commit('setEditCompany_Activities', value)
                }
            },
            OrdinaryShareValid() {
                if (this.OrdinaryShare <= this.IssuedShareCapital) {
                    let val = this.IssuedShareCapital / this.OrdinaryShare
                    if (this.OrdinaryShare > 0 && this.isInteger(val) == true) {
                        return true
                    } else {
                        return false
                    }
                } else {
                    return false
                }
            },
            IssuedShareCapitalValid(){
                if(this.IssuedShareCapital<=this.AuthorizedShareCapital){
                    if(this.IssuedShareCapital>0){
                        return true
                    }else{
                        return false
                    }
                }else{
                    return false
                }
            },
            isEmailValid(){
                return (this.comp_email == "")? "" : (this.reg.test(this.comp_email)) ? 'valid' : 'err'
            },
            generalCheckData(){
                if(this.comp_website.length>0 && this.isEmailValid=='valid' &&this.comp_addr.length>0&& this.comp_type!=''
                    && this.AuthorizedShareCapital>=1000 && this.OrdinaryShareValid==true && this.IssuedShareCapitalValid==true && this.Activities.length>200){
                    if(this.comp_type==15){
                        if(this.other_comp_type.length>0 && this.other_comp_type.length<120) {
                            return false
                        }else{
                            return true
                        }
                    }else{
                        return false
                    }
                }else{
                    return true
                }
            },
            companyStatus(data){
                this.CompanyPercent=0
                data = JSON.parse(data)
                console.log(data)
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
                this.company=item
                let status = JSON.parse(item.companyStatus)
                this.generalStatus = Number(status.general)
                this.uboStatus =  Number(status.ubo)
                this.dilliganceStatus =  Number(status.dillegance)
                this.fatcaStatus =  Number(status.fatca)
                this.companyName= item.companyName
            }
        })
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
    .companies
        min-height: 500px
        height: 100%
</style>