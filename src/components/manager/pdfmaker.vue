<template>
    <div class="container">
        <h3>PDF Maker</h3>
        <div>
            <div v-if="preloader" class="centrize"><img src="/static/img/loading.gif" alt="" style="height: 20px;"></div>
            <div v-else class="table"  style="max-height: 100vh;margin: 30px;">
                <div class="tableHeader">
                    <div class="centrize">Last Name</div>
                    <div class="centrize">First Name</div>
                    <div class="centrize">Email
                        <img src="/static/img/magnifier.svg" alt="" class="magnifier">
                        <input type="text" placeholder="Email" class="border accent" @keyup="search('searchRow','searchEmail')" v-model="searchtext">
                    </div>
                    <div class="centrize">Open file</div>
                </div>
                <div class="table_body" style="max-height: 60vh;">
                    <div class="tableRow searchRow" v-for="user in users">
                        <div class="centrize" style="align-items: flex-start; height: 100%; ">{{user.lastName}}</div>
                        <div class="centrize" style="align-items: flex-start; height: 100%; ">{{user.firstName}}</div>
                        <div class="centrize searchEmail" style="align-items: flex-start; height: 100%; ">{{user.email}}</div>
                        <div class="centrize" style="display: grid;justify-content: center;grid-gap: 10px;align-items: center;">
                            <button @click.prevent="createPDF(item)" v-if="show(item)" class="button onmouse" style="height: 30px; width: 100%;outline: none;max-width: 250px;min-width: 250px;overflow: hidden;" v-for="item in sortCompany(user.id)">{{item.companyName}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios'
    import pdfMake from 'pdfmake'
    import pdfFonts from "pdfmake/build/vfs_fonts";
    let moment = require('moment')
    const camelCase = require('camelcase');
    pdfMake.vfs = pdfFonts.pdfMake.vfs;

    export default {
        name: "pdfmaker",
        components: {axios},
        data(){
            return{
                users: [],
                companys: [],
                peoples: [],
                searchtext: '',
                preloader: false,
            }
        },
        methods:{
            loadUrl(row,id){
                return '/server/post/getFile.php?loadmyfile='+row.base_name+'&companyId='+id+'&type='+row.type
            },
            changeStatus(status,id){
                axios.post(this.$store.getters.getPostUrl,'setDocStatus='+status+'&docID='+id)
                    .then(res=>{
                        if(res.data.mess=='Sql UPDATE is ok'){
                            this.loadApprovDocs()
                        }
                    })
            },
            search(RowClassName, ClassName){
                let searchRow = document.getElementsByClassName(RowClassName)
                for (let j = 0; j<searchRow.length; j++){
                    let search = searchRow[j].getElementsByClassName(ClassName)
                    for (let i = 0; i < search.length; i++) {
                        let searchtext = this.searchtext.toUpperCase()
                        let innertext = search[i].innerText.toUpperCase()
                        if (innertext.indexOf(searchtext) > -1) {
                            searchRow[j].style.display = "";
                        } else {
                            searchRow[j].style.display = "none";
                        }
                    }
                }
            },
            loadAllContent(){
                this.preloader = true
                axios.post(this.$store.getters.getPostUrl,'load=UsersCompanysPeople')
                    .then(res=>{
                        this.preloader = false
                        this.users = res.data.users
                        this.companys = res.data.companys
                        this.peoples = res.data.peoples
                    })
            },
            sortCompany(appID){
                let companys = this.companys
                let newCompany=[]
                companys.forEach(company=>{
                    if(appID == company.applicantid){
                        newCompany.push(company)
                    }
                })
                return newCompany
            },
            show(Company){
                let newPeople = []
                let status = JSON.parse(Company.companyStatus)
                if(status.general==100&&status.ubo==100&&status.dillegance==100&&status.fatca==100){
                    if(Company.jurisdiction == 60||Company.jurisdiction == 22){
                        newPeople = this.peopleCompany(Company.id,true)
                        // console.log(newPeople)
                        if(newPeople.length>0){
                            return true
                        }else{
                            return false
                        }
                    }else{
                        return false
                    }
                }else{
                    return false
                }
            },
            customFormatter(date) {
                return moment(date).format('DD/MM/YYYY');
            },
            createPDF(Company){
                let newPeople = this.peopleCompany(Company.id)
                if(Company.jurisdiction == 60){
                    // console.log('Company',Company,'newPeople',newPeople)
                    this.createDomenica(Company,newPeople)
                }else if(Company.jurisdiction == 22){
                    // console.log('Company',Company,'newPeople',newPeople)
                    this.createBulgaria(Company,newPeople)
                }
            },
            peopleCompany(companyId, sign = false){
                let newPeople = []
                this.peoples.forEach(people=>{
                    if(people.companyId == companyId){
                        if(sign==true){
                            if(people.DeclanationSign != null ){
                                newPeople.push(people)
                            }
                        }else{
                            newPeople.push(people)
                        }
                    }
                })
                return newPeople
            },
            createDomenica(Company,peoples) {
                let date = new Date()
                date = this.customFormatter(date)
                let CT = Company.CompanyType
                let CompanyType =''
                if(CT == '1'){CompanyType = 'Social Media Marketing'}
                else if(CT == '2'){CompanyType = 'HR Services and Recruiting'}
                else if(CT == '2'){CompanyType = 'HR Services and Recruiting'}
                else if(CT == "3"){CompanyType = 'Business Consulting'}
                else if(CT == "4"){CompanyType = 'Tutoring and Professional Training'}
                else if(CT == "5"){CompanyType = 'Construction Business'}
                else if(CT == "6"){CompanyType = 'Web Services and Hosting'}
                else if(CT == "7"){CompanyType = 'Translation Services'}
                else if(CT == "8"){CompanyType = 'Hospitality Services'}
                else if(CT == "9"){CompanyType = 'Affiliate Marketing'}
                else if(CT == "10"){CompanyType = 'Rental Services'}
                else if(CT == "11"){CompanyType = 'Event Management'}
                else if(CT == "12"){CompanyType = 'Retail Shop'}
                else if(CT == "13"){CompanyType = 'Legal Services'}
                else if(CT == "14"){CompanyType = 'Accounting Services'}
                else if(CT == "15"){CompanyType = Company.CompanyTypeOther}
                let content = []
                peoples.forEach(people => {
                    let newdata = [
                        {
                            text: 'BENEFICIAL OWNER’S DECLARATION',
                            fontSize: 12,
                            alignment: 'left',
                            bold: true
                        },
                        {
                            text: 'To be filled by all of the Beneficial Owners / Shareholders / Directors / Attorneys in Fact. ',
                            fontSize: 12,
                            alignment: 'left',
                            marginTop: 20,
                        },
                        {
                            text: [
                                {text: 'Company’s name: ', fontSize: 10},
                                {text: Company.companyName, decoration: 'underline'},
                            ],
                            fontSize: 10,
                            marginTop: 10,
                        },
                        {
                            text: [
                                {
                                    text: [
                                        {text: 'First Name '},
                                        {text: people.firstName, decoration: 'underline'}
                                    ],
                                    fontSize: 10,
                                    marginTop: 10,
                                },
                                {
                                    text: [
                                        {text: ' Middle Name '},
                                        {text: '            ', decoration: 'underline'}
                                    ],
                                    fontSize: 10,
                                    marginTop: 10,
                                },
                                {
                                    text: [
                                        {text: ' Last Name '},
                                        {text: people.lastName, decoration: 'underline'}
                                    ],
                                    fontSize: 10,
                                    marginTop: 10,
                                },
                            ],
                            fontSize: 10,
                            marginTop: 10,
                        },
                        {
                            text: 'Provide a clear scan copy of your valid passport (or national ID, or social security or driving license, containing a photograph and signature) by email.',
                            fontSize: 10,
                            marginTop: 20,
                            italics: true,
                            alignment: 'left',
                        },
                        {
                            text: [{text: [{text: 'Date of Birth '},{text: people.dateBirth,decoration: 'underline'}]},{text: [{text:' Place of Birth '},{text: people.placeBirth,decoration: 'underline'}]}],
                            fontSize: 10,
                            marginTop: 10,
                            alignment: 'left',
                        },
                        {
                            text: [{text: [{text: 'Country of Citizenship '},{text: people.сountryCitizenship,decoration: 'underline'}]},{text: [{text:' Passport or ID No. '},{text: people.passport,decoration: 'underline'}]}],
                            fontSize: 10,
                            marginTop: 10,
                            alignment: 'left',
                        },
                        {
                            text: 'Contact Details:',
                            fontSize: 10,
                            marginTop: 20,
                            marginBottom: 20,
                            alignment: 'left',
                            bold: true,
                        },
                        {
                            text: [{text: 'Street address: ',},{text: Company.CompanyAddress, decoration: 'underline'}],
                            fontSize: 10,
                        },
                        {
                            text: [{text: [{text: 'City '},{text: people.city,decoration: 'underline'}]},{text: [{text:' State/Province '},{text: people.state,decoration: 'underline'}]}],
                            fontSize: 10,
                            marginTop: 10,
                            alignment: 'left',
                        },
                        {
                            text: [{text: [{text: 'Country '},{text: people.country,decoration: 'underline'}]},{text: [{text:' Zip/Postal Code '},{text: people.zip,decoration: 'underline'}]}],
                            fontSize: 10,
                            marginTop: 10,
                            alignment: 'left',
                        },
                        {
                            text: [{text: [{text: 'Residence Telephone '},{text: people.phone,decoration: 'underline'}]},{text: [{text:' Mobile '},{text: people.phone,decoration: 'underline'}]}],
                            fontSize: 10,
                            marginTop: 10,
                            alignment: 'left',
                        },
                        {
                            text: [{text: [{text: 'Business Telephone '},{text: people.phone,decoration: 'underline'}]},{text: [{text:' Fax No. '},{text: people.fax,decoration: 'underline'}]}],
                            fontSize: 10,
                            marginTop: 10,
                            alignment: 'left',
                        },

                        {text: [{text: 'Email address: ',fontSize: 10},{text: Company.CompanyEmail,fontSize: 10,decoration: 'underline'}]},
                        {text: 'My business occupation for the past three (3) years has been: (Give details: Company, Nature of Business, Position held, Period etc.).',fontSize: 10},
                        {text: Company.activities, decoration: 'underline',fontSize: 10},
                        {text: [{text: 'The intended activity of your IBC is: ',},{text: CompanyType},],fontSize: 10},
                        {text: [{text: 'Country/countries where activity is to be undertaken: '},{text: '   '}],fontSize: 10},

                        {text: 'I authorize to obtain character reference if necessary on my behalf from (Lawyer/Accountant/Bank):',marginTop: 20,fontSize: 10},
                        {text: [{text: 'Name, position: '},{text: '   ', decoration: 'underline'}],fontSize: 10,marginTop: 10},
                        {text: [{text: 'Address: '},{text: '   ', decoration: 'underline'}],fontSize: 10,marginTop: 10},
                        {text: [{text: 'Telephone No. '},{text: '   ', decoration: 'underline'},{text: 'Email: '},{text: '   ', decoration: 'underline'}],fontSize: 10,marginTop: 10},

                        {text: 'None of my or the company’s assets, net worth, income or activities relate in any manner to money laundering; sales of illegal armaments, kidnapping, illegal drugs or other illegal controlled substances, or any activity that I know to be illegal in my country of citizenship, residence or domicile, or in the Commonwealth of Dominica.',fontSize: 10,marginTop: 10},
                        {text: 'I do not intend to hinder, delay or defraud any creditors, or engage in any illegal conduct in relation to creditors and do not intend to engage the services of CCP Inc. in order to facilitate or otherwise engage in such activity.',fontSize: 10,marginTop: 10},
                        {text: 'I hereby expressly, specifically and unqualifiedly agree to wholly hold harmless and indemnify CCP Inc. its shareholders, officers, directors, employees, agents and nominee shareholders and (or) nominee directors provided by CCP Inc. or its agents if any, from any liabilities of any kind or character arising out of any lawful actions taken by them in reliance upon any fact or statement contained in this declaration which may hereafter prove to be untrue or materially inaccurate.',fontSize: 10,marginTop: 10},
                        {image: people.DeclanationSign,width: 117, height: 50, relativePosition:{x:60,y:-20}},
                        {text: [{text:'Declaring: ',bold: true,fontSize: 12},{text: '                                                   ',decoration: 'underline'}, {text: [{text: ' '+ people.firstName,decoration: 'underline'},{text: ' '+ people.lastName,decoration: 'underline'}],},{text: ' '+date,decoration: 'underline'}],fontSize:12,marginTop: 20},
                        {text:'All the fields of present form must be filled in, please use a separate sheet if space is not sufficient.',italics: true,fontSize:12,marginTop: 10}
                    ]
                    content.push(newdata)
                })

                const documentDefinition = {
                    info:{
                        title: 'Documents by company '+ Company.companyName,
                        author: 'comformo.com',
                        keywords: 'create company '+ Company.companyName,
                    },
                    content,

                }
                pdfMake.createPdf(documentDefinition).download(Company.companyName);
            },
            createBulgaria(Company,peoples) {
                let date = new Date()
                date = this.customFormatter(date)
                // let CT = Company.CompanyType
                // let CompanyType =''
                // if(CT == '1'){CompanyType = 'Social Media Marketing'}
                // else if(CT == '2'){CompanyType = 'HR Services and Recruiting'}
                // else if(CT == '2'){CompanyType = 'HR Services and Recruiting'}
                // else if(CT == "3"){CompanyType = 'Business Consulting'}
                // else if(CT == "4"){CompanyType = 'Tutoring and Professional Training'}
                // else if(CT == "5"){CompanyType = 'Construction Business'}
                // else if(CT == "6"){CompanyType = 'Web Services and Hosting'}
                // else if(CT == "7"){CompanyType = 'Translation Services'}
                // else if(CT == "8"){CompanyType = 'Hospitality Services'}
                // else if(CT == "9"){CompanyType = 'Affiliate Marketing'}
                // else if(CT == "10"){CompanyType = 'Rental Services'}
                // else if(CT == "11"){CompanyType = 'Event Management'}
                // else if(CT == "12"){CompanyType = 'Retail Shop'}
                // else if(CT == "13"){CompanyType = 'Legal Services'}
                // else if(CT == "14"){CompanyType = 'Accounting Services'}
                // else if(CT == "15"){CompanyType = Company.CompanyTypeOther}
                let PeopleTextBul = ''
                let PeopleTextEng = ''
                let PeopleTextBul2 = ''
                let PeopleTextEng2 = ''
                let index = 1
                let Sign = []
                let SoPartner = []
                let PeopleTextDeclarer141Bul = '\nАз, долуподписаният, …, гражданин на …, роден на ... в …, с документ за самоличност паспорт №…, издаден на ..., валиден до ..., издаден от …, с адрес: …, като управител на „…”, с наименование на латиница – “…”, /в процес на рeгистрация/, със седалище и адрес на управление – …, декларирам, че: \n'
                let PeopleTextDeclarer141Eng = '\nI, the undersigned, …, citizen of …, born on … in …, holder of passport number …, issued on …, expired on …, issued by …, address: …, as a manager of “…” .., /in registration procedure/, seat and registered office – …, declare the following: \n'
                let PeopleTextDeclarer142Bul = '\nАз, долуподписаният, …, гражданин на …, роден на ... в …, с документ за самоличност паспорт №…, издаден на ..., валиден до ..., издаден от …, с адрес: …, като управител на „…”, с наименование на латиница – “…” /в процес на рeгистрация, със седалище и адрес на управление – …, декларирам, че:\n'
                let PeopleTextDeclarer142Eng = '\nI, the undersigned, …, citizen of …, born on … in …, holder of passport number …, issued on …, expired on …, issued by …, address: …, as a manager of “…” /in registration procedure/, seat and registered office – …, declare the following: \n'

                peoples.forEach(people => {
                    if(people.Shareholder=='true'){
                        Sign.push({text: index,width: 20, height: 30,marginLeft:50},{image: people.DeclanationSign,width:70,height: 30,marginLeft:50})
                        SoPartner.push(people.DeclanationSign)
                        PeopleTextBul = PeopleTextBul + index+'. '+this.tranlitToBulgaria(people.firstName,true)+' '+this.tranlitToBulgaria(people.lastName, true)+',  гражданин на …, роден на '+this.tranlitToBulgaria(people.placeBirth,true)+' в '+people.dateBirth+', с документ за самоличност паспорт №'+people.passport+', издаден на ..., валиден до ..., издаден от …, с адрес: …\n'
                        PeopleTextEng = PeopleTextEng + index+'. '+people.firstName+' '+people.lastName+', citizen of ., born on '+people.placeBirth+' in '+people.dateBirth+', holder of passport number '+people.passport+', issued on …, expired on …, issued by …, address: …\n'
                        PeopleTextBul2 = PeopleTextBul2 + index+'. /един/ дял е собственост на съдружника '+this.tranlitToBulgaria(people.firstName,true)+' '+this.tranlitToBulgaria(people.lastName,true)+',  гражданин на …, роден на '+this.tranlitToBulgaria(people.placeBirth,true)+' в '+people.dateBirth+', с документ за самоличност паспорт №'+people.passport+', издаден на ..., валиден до ..., издаден от …, с адрес: …\n'
                        PeopleTextEng2 = PeopleTextEng2 + index+'. /one/ share is owned by the co-partner '+people.firstName+' '+people.lastName+', citizen of ., born on '+people.placeBirth+' in '+people.dateBirth+', holder of passport number '+people.passport+', issued on …, expired on …, issued by …, address: …\n'
                        index++
                    }
                })
                this.bulgariaCompanyContract(Company,Sign,SoPartner,PeopleTextBul,PeopleTextEng,PeopleTextBul2,PeopleTextEng2)
                this.bulgariaManagerContract(Company,Sign,SoPartner,PeopleTextBul,PeopleTextEng)
                this.bulgariaDeclaration141(Company,Sign,SoPartner,PeopleTextDeclarer141Bul,PeopleTextDeclarer141Eng)
                this.bulgariaDeclaration142(Company,Sign,SoPartner,PeopleTextDeclarer142Bul,PeopleTextDeclarer142Eng)
            },
            //function from Bulgaria
            bulgariaCompanyContract(Company,Sign,SoPartner,PeopleTextBul,PeopleTextEng,PeopleTextBul2,PeopleTextEng2){
                let footer = [
                    {columns: Sign}
                ]
                let content = [
                    {
                        table: {
                            widths: ['53%','47%'],
                            body: [
                                [
                                    {
                                        text: [
                                            {
                                                text: 'ДРУЖЕСТВЕН ДОГОВОР\n',
                                                fontSize: 12,
                                                alignment: 'center',
                                                bold: true
                                            },
                                            {text:'Днес ...........................г. в ........................, в присъствието на:\n'},
                                            {
                                                text: 'на дружество с ограничена отговорност\n',
                                                fontSize: 12,
                                                alignment: 'center',
                                                bold: true
                                            },
                                            {
                                                text: '„'+Company.companyName+'”\n',
                                                fontSize: 12,
                                                alignment: 'center',
                                                bold: true
                                            },
                                            {text: PeopleTextBul},
                                            {text:'наричани по-нататък в договора СЪДРУЖНИЦИ, се сключи настоящия дружествен договор, посредством който страните се споразумяха за следното:\n'},
                                            {text:'1. Съдружниците учредяват дружество с ограничена отговорност с фирмено наименование „…”, с наименование на латиница – “…” със седалище и адрес на управление – … и предмет на дейност, както следва:\n'},
                                            {text: 'Покупка на стоки с цел продажба в първоначален, преработен или обработен вид;\n' +
                                                'продажба на стоки собствено производство; \n' +
                                                'сделки по осъществяване на търговско представителство и посредничество; \n' +
                                                'комисионни, спедиционни, складови и лизингови сделки.\n'},
                                            {text: '\nКАПИТАЛ И РАЗПРЕДЕЛЕНИЕ НА ДЯЛОВЕТЕ\n',bold: true, alignment: 'center'},
                                            {text: '2. Дружеството е с капитал в размер на 2 лв. /два/, разпределен в 2/два/ дяла от по 1 лв. /един лев/, разпределени между съдружниците, както следва:\n'},
                                            {text: PeopleTextBul2, marginLeft: 20},
                                            {text: '3. Към момента на учредяване на дружеството съдружниците внасят по 100% от дружествения си дял в капитала.\n'},
                                            {text: '\nОРГАНИ И УПРАВЛЕНИЕ\n' +
                                                'А. Общо събрание на съдружниците:\n',bold: true, alignment: 'center'},
                                            {text:'4. Общото събрание на съдружниците се състои от всички съдружници, притежаващи дялове от капитала на  дружеството.\n' +
                                                '5. Общото събрание има следната компетентност:\n' +
                                                'А/ изменя и допълва дружествения договор;\n' +
                                                'Б/ приема и изключва съдружници, дава съгласие за прехвърляне на дружествен дял на нов член, който не е съдружник;\n' +
                                                'В/ приема годишния отчет и баланса, разпределя печалбата и взема решение за нейното изплащане;\n' +
                                                'Г/ взема решение за намаляне и увеличаване на капитала;\n' +
                                                'Д/ избира управител, определя възнаграждението му и го освобождава от отговорност;\n' +
                                                'Е/ взема решения за придобиване и отчуждаване на недвижими имоти и вещни права върху тях;\n' +
                                                'Ж/ взема решение за допълнителни парични вноски;\n' +
                                                'З/ взема решение за предявяване на искове на дружеството срещу  управителя и назначава представител за водене на процеси срещу него;\n' +
                                                'И/ взема решение за откриване и закриване на клонове и участие в други дружества;\n' +
                                                'К/ взема решение за прекратяване на дружеството;\n' +
                                                '6. Всеки от съдружниците има толкова гласа в общото събрание, колкото е неговия дял в капитала. Общото събрание взема решение по всички въпроси, с изключение на тези по пунктове А,Б,Г, Е, Ж и К от предходния член, с мнозинство повече от 50% от капитала на дружеството. Решенията по пунктове Е и Ж се вземат с мнозинство повече от ¾ от капитала на дружеството, а решенията по пунктове A, Б, Г и К – с пълно единодушие.\n' +
                                                '7. Общото събрание се свиква от управителя на дружеството най-малко веднъж годишно.  \n' +
                                                '8. Всеки един от съдружниците може без  всякакви ограничения да осъществява  cамостоятелна търговска дейност, да участва като съдружник или член в управителните органи на други дружества, независимо от тяхния предмет на дейност.\n'},
                                            {text:'\nБ. Управител на дружеството:\n',bold: true, alignment: 'center'},
                                            {text: '9. Дружеството се управлява от един избран от общото събрание управител.\n' +
                                                '10. Управителят на дружеството организира и ръководи неговата дейност съобразно закона и решенията на общото събрание. За управител на дружеството може да бъде назначен както съдружник, така и външно за дружеството лице.  \n' +
                                                '11. Управителят носи имуществена отговорност за причинените на дружеството вреди.\n' +
                                                '12. Управителят на дружеството решават всички дружествени въпроси, непопадащи в компетентността на общото събрание на съдружниците съобразно уговореното в този договор и императивните норми на закона.'},
                                            {text:'\nПРЕКРАТЯВАНЕ НА УЧАСТИЕ\n' +
                                                'В ДРУЖЕСТВОТО\n',bold: true, alignment: 'center'},
                                            {text: '13. Участието на съдружник в дружеството се прекратява:      \n' +
                                                '   - с ликвидация на дружеството-съдружник;\n' +
                                                '   - при смърт или поставяне под пълно запрещение на съдружник – физическо лице;\n' +
                                                '   - при обявяване в несъстоятелност на дружество – съдружник;\n' +
                                                '   - при изключване на съдружник;\n' +
                                                '   - с тримесечно писмено предизвестие.\n' +
                                                '14. Имуществените последици се уреждат въз основа на счетоводен баланс към края на месеца, през който е настъпило прекратяването. \n' +
                                                '15. Останалите съдружници са длъжни да поемат дружествените дялове на прекратилият участие в дружеството съдружник в съсобственост, съобразно с дяловете си в капитала на дружеството, с изключение на случайте при които участието на съдружника се прекратявa поради смърт. При поемане на дяловете съдружниците внасят в дружеството стойността на дела на напускащия съдружник, определена по реда на чл.14.\n' +
                                                '16. Дружеството е длъжно да изплати  дела/дяловете/ на напускащия съдружник съобразно стойността му по баланса на дружеството към края на месеца, през който е настъпило прекратяването.\n' +
                                                '17. Дружественият дял може да се прехвърля и наследява. Прехвърлянето на дружествения дял от един съдружник на друг се извършва свободно, а на трети лица - при спазване на изискванията за приемане на нов съдружник.\n' +
                                                'Прехвърлянето на дружествения дял се извършва с договор, сключен с нотариално удостоверяване на подписите и съдържанието, извършени едновременно, и се вписва в търговския регистър.\n' +
                                                '18. Дружествените дялове се наследяват без ограничение, както по закон така и по завещание. Ако наследниците на починалия изявят желание да станат съдружници в дружеството, те могат да заявят това свое желание по реда на този договор, като останалите съдружници не могат да се противопоставят.\n' +
                                                '19. При смърт на съдружник, управителя на дружеството изпраща на всеки един от неговите наследници нотариална покана, с която го кани да встъпи в правата по дружествените дялове на наследодателя. Ако наследникът желае да стане съдружник в дружеството, следва в тримесечен срок от получаване на поканата да депозира пред управителя на дружеството нотариално заверена молба с която изразява съгласие с дружествения договор и желание да бъде приет за съдружник в дружеството. Наследникът може да депозира молба за встъпване като съдружник и преди да е получил покана от управителя.\n' +
                                                '20. При няколко сънаследници, и при условие, че между тях не е извършена делба на наследените дружествени дялове, правата за встъпване в дружеството се упражняват съвместно с оглед на произтеклата от наследяването съсобственост. Ако някой от сънаследниците не желае да стане съдружник в дружеството, управителя изпраща нотариални покани на останалите сънаследници, като ги кани да встъпят в дела на отказалия се сънаследник. В този случай, в тримесечен срок от поканата останалите сънаследници поемат в съсобственост идеалната част от наследените дялове на отказалия се наследник пропорционално на наследствените си права, като в тримесечен срок от поемането на правата изплащат паричната равностойност на тази идеална част на отказалия се наследник.\n' +
                                                '21. С подписването на този дружествен договор съдружниците предварително и безусловно приемат и се задължават един спрямо друг при смърт на който и да е от съдружниците да приемат наследниците на починалия за съдружници в дружеството без каквито и да е уговорки или условия. В този смисъл настоящата клауза има характер на предварително взето решение на общото събрание за приемане на нов съдружник. Всеки нов съдружник в дружеството се счита за абсолютно и безусловно обвързан от настоящата клауза. \n' +
                                                '22. При наследяване на дяловете на починал съдружник по завещание разпоредбите на предходните членове от този договор се прилагат съответно.\n'},
                                            {text:'\n ПРЕКРАТЯВАНЕ НА ДРУЖЕСТВОТО\n',bold:true, alignment: 'center'},
                                            {text:'23. Дружеството се прекратява:\n' +
                                                '   - по решение на общото събрание на съдружниците, взето с единодушие;\n' +
                                                '   - чрез сливане или вливане в акционерно дружество или в друго дружество с ограничена отговорност;\n' +
                                                '   - по решение на окръжния съд, в предвидените от Търговския Закон случаи;\n' +
                                                '   - при обявяване в несъстоятелност.\n' +
                                                '24. Дружеството е учрeдено безсрочно.\n' +
                                                'Относно неуредените в настоящия дружествен договор въпроси, се прилагат общите разпоредбите на Търговския закон. \n'},
                                            {text: '\n\nСЪДРУЖНИЦИ:\n\n',bold: true},
                                        ]
                                    },
                                    {
                                        text: [
                                            {
                                                text:'COMPANY`S CONTRACT\n',
                                                fontSize: 12,
                                                alignment: 'center',
                                                bold: true},
                                            {text:'Today …………. in ………….. in the presence of:\n'},
                                            {
                                                text: 'of Limited Liability company\n',
                                                fontSize: 12,
                                                alignment: 'center',
                                                bold: true},
                                            {
                                                text: '"'+Company.companyName+'"\n',
                                                fontSize: 12,
                                                alignment: 'center',
                                                bold: true},
                                            {text: PeopleTextEng},
                                            {text:'hereinafter in this contract are called PARTNERS, have concluded the present partners’ contract with which the parties agreed on the following:\n'},
                                            {text: '1. The partners establish limited liability company under the company name “…” seat and registered office – … and а sphere of activity, as follows: \n'},
                                            {text: 'Purchase of goods in order to resale them in their initial, processed or modified state; \n' +
                                                'sale of goods which are own production;\n' +
                                                'activities connected with the commercial representation and agency;\n' +
                                                'commission, spedition, storage and lease activities.\n'},
                                            {text:'\nCAPITAL AND SHARE DIVISION\n',bold: true, alignment: 'center'},
                                            {text:'2. The Company capital is to the amount of 2 /two/ levs, divided into 2/two/ shares of 1 /one/ lev each of which, divided between partners as follows: \n'},
                                            {text: PeopleTextEng2, marginLeft: 20},
                                            {text: '3. At the moment of registration of the company each of the partners deposits 100 % of their partner’s share in the capital.\n'},
                                            {text: '\nDIRECTORS BODY AND MANAGEMENT\n' +
                                                'A. General Meeting of Partners\n',bold:true, alignment: 'center'},
                                            {text:'4. The general meeting of partners consists of all partners having shares of the company’s capital.\n' +
                                                '5. The general meeting of partners has the competence, as follows:\n' +
                                                'A/ to change and add to the company contract;\n' +
                                                'B/ to accept and debar partners, give approval for transaction of company share on new member who is not partner;\n' +
                                                'C/ to accept the annual report and balance and divides the profit and takes decision for its payment;\n' +
                                                'D/ to decide for the capital decrease or increase;\n' +
                                                'E/ to choose director, appoint their wage and exempt from liability;\n' +
                                                'F/ to resolve on acquisition and alienation of real property and real rights therein;\n' +
                                                'G/ to decide for additional money deposits;\n' +
                                                'H/ to institute proceedings of the company against the director and appoint representative to carry on lawsuits against him;\n' +
                                                'I/ to decide to open or close company branches and participation in other partnerships;\n' +
                                                'J/ to decide for dissolution of the partnership\n' +
                                                '6. Each one of the partners has as much votes in the general meeting as much his /her/ share is in the capital. The general meeting takes decisions on all matters except those about points A, B, D, F, G, J from the previous article, with majority of more than 50% of the company’s capital. The decisions about points F and G are taken with majority of more than ¾ of the company’s capital, and the decisions about points A, B, D, and J are taken with full consensus.\n' +
                                                '7. The general meeting is assembled from the company director at least once a year.\n' +
                                                '8. Each partner can without any restrictions to conduct independent commercial activity, to participate as partner or member in board of Directors of other companies in spite of their sphere of activity.\n'},
                                            {text:'\nB. Company’s manager\n',bold:true, alignment: 'center'},
                                            {text: '9. The company is managed by one director, appointed by the general meeting.\n' +
                                                '10. The Director organizes and manages all company activities according the regulations of the law and the decisions of the general meeting. The Director of the company can be appointed either a partner or a person outside the company as well.\n' +
                                                '11. The Director is charged with financial liability for caused damages on the company.\n' +
                                                '12. The Director of the company settles all company’s matters outside the general meeting of the partners’ competence according the agreed in the contract herein and all imperative forms of the law.\n'},
                                            {text: '\nDISSOLUTION OF PARTNERSHIP \n' +
                                                ' IN THE COMPANY\n',bold:true, alignment: 'center'},
                                            {text: '13. Partner’s company participation is terminated in the case of:\n' +
                                                '   - Suspension because of liquidation of partner’s company;\n' +
                                                '   - Because of death or placing under judicial disability of partner – physical person;\n' +
                                                '   - If a partner’s company declares bankruptcy;\n' +
                                                '   - If a partner is suspended;\n' +
                                                '   - When a three month written notification.  \n' +
                                                '14. The financial consequences are settled on the basis of the balance sheet at the end of the month in which the termination occurred.\n' +
                                                '15. The rest of the partners are obliged to take upon the company shares from the partner with terminated participation in the company joint ownership according his shares in the company capital, except when a partner participation is terminated because of his death. Upon subscription of the shares, the partners shall transfer to the company the value of the share of the outgoing partner, determined by the order of art. 14.\n' +
                                                '16. The Company is obliged to pay the remaining shares of the outgoing partner according to the value of the company\'s balance sheet at the end of the month in which the termination occurs.\n' +
                                                '17. The company share can be transferred and inherit. The transfer of the company\'s share from one partner to another is freely carried out and to third parties - subject to the requirements for admission of a new partner.\n' +
                                                'The transfer of the shares shall be effected by a contract concluded with a notary certification of the signatures and the content carried out at the same time and shall be entered in the commercial register.\n' +
                                                '18. The company shares are inherited without any limitations by the virtue of law and stated will as well. If the survivors of the deceased wish to become partners in the company, they may declare this desire under the terms of this contract and the other partners can not resist\n' +
                                                '19. In case of partner’s death the company director sends a notary certified invitation to each of his successors with which he invites the successor to enter into the successor’s company shares rights. If the successor wishes to become a company partner, the same is obliged, in three months period after receiving the invitation, to deposit before the company director a notary certified application with which he declares his agreement with the company contract and his desire to be accepted as a company partner. The inheritor may submit an application to intervene as a partner and before receiving an invitation from the director.\n' +
                                                '20. When there are several successors and in case there is no partition of the succeeded shares between them, the rights to enter into company are exercised together with the succeeded joint ownership. If anyone of the successors refuses to become company partner, the director sends notary certified invitations to the rest of the successors, inviting them to enter into the renounced successor’s rights. In such case the rest of the successors in three months period from the date of the invitation take joint ownership the shares of the inherited shares of the renounced successor and in three months period after they enter into rights they pay the money equivalent of the shares to the renounced successor.\n' +
                                                '21. After this company contract is signed the partners unconditionally accept in advance and are obliged to each other in case of death of any of the partners to accept the heirs of the deceased for company partners without any reservations or conditions. In this sense this clause herein has the force of preliminary decision of the general meeting for the acceptance of new partner. Each new partner in the company is considered to be absolutely and unconditionally bond from this clause.\n' +
                                                '22. In case of inheriting the deceased partner’s shares as stated in his will the regulation of points in this contract herein are respectively applied.'},
                                            {text:'\n\n\n COMPANY TERMINATION\n',bold:true, alignment: 'center'},
                                            {text: '23. The company terminates:\n' +
                                                '   -In case of decision at the general meeting of partners taken with unanimity;\n' +
                                                '   -In case of incorporation and integration in joint stock company or in another limited liability company;\n' +
                                                '   -In case of district court resolution; in cases provided in CC;\n' +
                                                '   -In case of bankruptcy.\n' +
                                                '24. The company is term less registered.\n' +
                                                'In cases not settled in the present contract herein are applied the regulations of the Commercial Code.\n'},
                                            {text: '\n\nCO - PARTNERS:\n\n',bold: true},
                                        ],
                                    },
                                ],
                            ],
                        }
                    },
                ]
                SoPartner.forEach(partner=>{
                    let col = {
                        ol:{
                            image: partner,
                            width:70,
                            height: 30,
                            position: 'relative',
                            top: 10,
                            left: 20
                        }
                    }
                    content[0].table.body[0][0].text.push(col)
                    content[0].table.body[0][1].text.push(col)
                })

                let documentDefinition = {
                    info:{
                        title: 'Documents by company '+ Company.companyName,
                        author: 'comformo.com',
                        keywords: 'create company '+ Company.companyName,
                    },
                    footer,
                    content,
                    permissions: {
                        printing: 'highResolution', //'lowResolution'
                        modifying: false,
                        copying: false,
                        annotating: false,
                        fillingForms: false,
                        contentAccessibility: false,
                        documentAssembly: false
                    },

                }
                pdfMake.createPdf(documentDefinition).download('Company Contract by '+Company.companyName);
            },
            bulgariaManagerContract(Company,Sign,SoPartner,PeopleTextBul,PeopleTextEng){
                let content = [
                    {
                        table: {
                            widths: ['53%','47%'],
                            body: [
                                [
                                    {
                                        text: [
                                            {text: 'ДОГОВОР ЗА УПРАВЛЕНИЕ\n\n',fontSize: 12,alignment: 'center',bold: true},
                                            {text: 'Днес, ..........…….. в ................ между лицата:\n'},
                                            {text: PeopleTextBul},
                                            {text: 'се сключи настоящия договор за възлагане на управлението, по смисъла на чл. 141, ал. 7 от ТЗ, по силата на който страните се споразумяха за следното:\n'},
                                            {text: '1. Възложителят „…”, възлага на управителя …, да управлява и представлява дружеството, да организира и ръководи дейността му и изобщо да извършва всички дейности, присъщи на управителя на дружество с ограничена отговорност съобразно разпоредбите на Търговския закон, дружествения договор и решенията на общото събрание на съдружниците.\n'},
                                            {text: '2. УПРАВИТЕЛЯT се задължава да извършва дейностите, описани в пункт първи от настоящия договор с грижата на добър търговец.\n'},
                                            {text: '3. За неуредените от този договор въпроси ще се прилагат разпоредбите на Търговския закон и общото гражданско и търговско право.\n'},
                                            {text: '\n\nВЪЗЛОЖИТЕЛ:\n\n',bold: true},
                                            {text: '\n\nУПРАВИТЕЛ:\n\n',bold: true},
                                        ]
                                    },
                                    {
                                        text: [
                                            {text:'MANAGERS CONTRACT\n\n',fontSize: 12,alignment: 'center',bold: true},
                                            {text: 'Today, ……… in ................ between the parties:\n'},
                                            {text: PeopleTextEng},
                                            {text: 'Hereinafter the present contract was concluded for enduing of management within the meaning of article 141, paragraph 7 Trade Law by virtue of which the parties agreed on following:\n'},
                                            {text: '1. The principal “…”, endues to the manager …, to administer and represent the company, to organize and manage its activity and as a whole to fulfil all activities inherent to the manager of the limited liability company in consideration with the regulations of Trade Law, the Company contract and the Decisions of common meeting of the shareholders.\n'},
                                            {text: '2. The MANAGER is obliged to fulfil the activities described in the first point of the present contract in the care of a good trader.\n'},
                                            {text: '3. Regarding issues not settled in the present contract, regulations of Trade Law are to be applied as well as civil and commercial law.\n'},
                                            {text: '\n\nFor the Principal:\n\n',bold: true},
                                            {text: '\n\nManager:\n\n',bold: true},
                                        ],
                                    },
                                ],
                            ],
                        }
                    },
                ]

                let documentDefinition = {
                    info:{
                        title: 'Documents by company '+ Company.companyName,
                        author: 'comformo.com',
                        keywords: 'create company '+ Company.companyName,
                    },
                    content,
                    permissions: {
                        printing: 'highResolution', //'lowResolution'
                        modifying: false,
                        copying: false,
                        annotating: false,
                        fillingForms: false,
                        contentAccessibility: false,
                        documentAssembly: false
                    },

                }
                pdfMake.createPdf(documentDefinition).download('Manager Contract by '+Company.companyName);
            },
            bulgariaDeclaration141(Company,Sign,SoPartner,PeopleTextDeclarer141Bul,PeopleTextDeclarer141Eng){
                let content = [
                    {
                        table: {
                            widths: ['59%','41%'],
                            body: [
                                [
                                    {
                                        text: [
                                            {text: '\nД Е К Л А Р А Ц И Я\n',fontSize: 12,alignment: 'center',bold: true},
                                            {text: '\nпо чл.141 ал.8 ТЗ\n',alignment: 'center'},
                                            {text: '\n'+PeopleTextDeclarer141Bul+'\n'},
                                            {text: '\n1. Не съм и никога не съм бил обявяван в несъстоятелност.\n'},
                                            {text: '\n2. Не съм и никога не съм бил управител или член на управителен или контролен орган на Дружеството, което да е било прекратено поради несъстоятелност през последните две години, предхождащи датата на решението за обявяване на несъстоятелността, на което да са останали неудовлетворени кредитори.\n'},
                                            {text: '\n3. Не съм лице, което е било управител, член на управителен или контролен орган на дружество, за което е било установено с влязло в сила наказателно постановление неизпълнение на задължения по създаване и съхраняване на определените му нива от запаси по Закона за запасите от нефт и нефтопродукти\n'},
                                            {text: '\n\nДЕКЛАРАТОР:\n\n',bold: true},
                                        ]
                                    },
                                    {
                                        text: [
                                            {text: '\nD E C L A R A T I O N\n',fontSize: 12,alignment: 'center',bold: true},
                                            {text: '\nAccording to art.141, 8 of the Trade Law \n',alignment: 'center'},
                                            {text: '\n'+PeopleTextDeclarer141Eng+'\n'},
                                            {text: '\n1. I am not and I’ve never been in bankruptcy proceedings.\n'},
                                            {text: '\n2. I haven’t been a manager or supervisory body of a company closed due to bankruptcy in the last two years preceding the date of the declaration of bankruptcy and there are no satisfied creditors.\n'},
                                            {text: '\n3. I haven’t been manager or a member of supervisory body for which a criminal decree for non-execution of obligation to create and perseverance of the relevant oil reserves according the Law for oil and oil products reserves.\n'},
                                            {text: '\n\nDECLARER:\n\n',bold: true},
                                        ],
                                    },
                                ],
                            ],
                        }
                    },
                ]

                let documentDefinition = {
                    info:{
                        title: 'Documents by company '+ Company.companyName,
                        author: 'comformo.com',
                        keywords: 'create company '+ Company.companyName,
                    },
                    content,
                    permissions: {
                        printing: 'highResolution', //'lowResolution'
                        modifying: false,
                        copying: false,
                        annotating: false,
                        fillingForms: false,
                        contentAccessibility: false,    
                        documentAssembly: false
                    },

                }
                pdfMake.createPdf(documentDefinition).download('Declaration141 by '+Company.companyName);
            },
            bulgariaDeclaration142(Company,Sign,SoPartner,PeopleTextDeclarer142Bul,PeopleTextDeclarer142Eng){
                let content = [
                    {
                        table: {
                            widths: ['50%','50%'],
                            body: [
                                [
                                    {
                                        text: [
                                            {text: '\nД Е К Л А Р А Ц И Я\n',fontSize: 12,alignment: 'center',bold: true},
                                            {text: '\n'+PeopleTextDeclarer142Bul+'\n'},
                                            {text: '\n1.Не съм в производство по несъстоятелност;\n' +
                                                '\n2.Не съм невъзстановен в правата си несъстоятелен;\n' +
                                                '\n3.Не упражнявам самостоятелна търговска дейност в България;\n' +
                                                '\n4.Не съм бил член на обявено в несъстоятелност дружество;\n' +
                                                '\n5.Не съм член на ръководен орган на друго дружество в България и не членувам в друго търговско дружество в България без съгласие на едноличния собственик на капитала;\n' +
                                                '\n6.Hе съм съден за банкрут;\n' +
                                                '\n7.Не съм лишен от правото да заемам материалноотговорна, ръководна или отчетническа дейност.\n'},
                                            {text: '\n\nДЕКЛАРАТОР:\n\n',bold: true},
                                        ]
                                    },
                                    {
                                        text: [
                                            {text: '\nD E C L A R A T I O N\n',fontSize: 12,alignment: 'center',bold: true},
                                            {text: '\n'+PeopleTextDeclarer142Eng+'\n'},
                                            {text: '\n1. I am not in bankruptcy proceedings.\n' +
                                                '\n2. I am not discharged bankrupt.\n' +
                                                '\n3. I do not conduct independent trade activity on the territory of Bulgaria.\n' +
                                                '\n4. I have not been a member of a company declared bankrupt;\n' +
                                                '\n5. I am not a seat on the director’s board of another company in Bulgaria and I am not a member of another trade company in Bulgaria without the agreement of the single owner of the capital;\n' +
                                                '\n6. I have not been under trial for bankrupt;\n' +
                                                '\n7. I have not been denied the opportunity to perform material liability, director or accountant activity.\n'},
                                            {text: '\n\nDECLARER:\n\n',bold: true},
                                        ],
                                    },
                                ],
                            ],
                        }
                    },
                ]

                let documentDefinition = {
                    info:{
                        title: 'Documents by company '+ Company.companyName,
                        author: 'comformo.com',
                        keywords: 'create company '+ Company.companyName,
                    },
                    content,
                    permissions: {
                        printing: 'highResolution', //'lowResolution'
                        modifying: false,
                        copying: false,
                        annotating: false,
                        fillingForms: false,
                        contentAccessibility: false,
                        documentAssembly: false
                    },

                }
                pdfMake.createPdf(documentDefinition).download('Declaration142 by '+Company.companyName);
            },
            //end function from Bulgaria
            tranlitToBulgaria(text,camel = false ){
                let newText = text.toLowerCase().replace('ch','ч').replace('sh','ш').replace('sht','щ').replace('ju','ю').replace('zh','ж').replace('ja','я').replace('a','а').replace('b','б').replace('v','в').replace('w','в').replace('g','г').replace('d','д').replace('e','е').replace('z','з').replace('i','и').replace('j','й').replace('k','к').replace('l','л').replace('m','м').replace('n','н').replace('o','о').replace('p','п').replace('r','р').replace('t','т').replace('u','у').replace('f','ф').replace('x','х').replace('c','ц').replace('y','ь').replace('s','с').replace('h','х').replace('"','ъ')
                if(camel==true){
                    return this.toCamelCase(newText)
                }else{
                    return newText
                }
            },
            toCamelCase(str) {
            return str.toLowerCase().replace(/(?:(^.)|(\s+.))/g, function(match) {
                return match.charAt(match.length-1).toUpperCase();
            });
            }
        },
        mounted(){
            this.loadAllContent()
        }
    }
</script>

<style scoped>

</style>