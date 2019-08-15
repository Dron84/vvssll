// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import Vuex from 'vuex'
import BootstrapVue from 'bootstrap-vue';
// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'
import VueCookie from 'vue-cookie'
import axios from 'axios'


Vue.config.productionTip = true
Vue.config.devtools = true

Vue.use(Vuex,BootstrapVue,VueCookie)

const store = new Vuex.Store({
    state:{
        // post_url: 'http://comformo.local/server/post/index.php',
        post_url: 'https://cabinet.comformo.com/server/post/index.php',
        preload: false,
        login: false,
        loginIn: null,
        userData: {
            firstName: '',
            lastName: '',
            phone: '',
            City: '',
            zip_code: '',
            Country: '',
            State: '',
            email: '',
            pass: '',
            phone_carrier: '',
            phone_country_code: '',
            phone_country_name: '',
            phone_country_prefix: '',
            phone_international_format: '',
            phone_line_type: '',
            phone_local_format: '',
            phone_location: '',
            phone_number: '',
            phone_valid: '',
            avatar: null,
            id: null,
            billfirstname: '',
            billCity: '',
            billzip: '',
            billaddress1: '',
            billlastname: '',
            billCountry: '',
            billState: '',
            billaddress2: '',
            agentNameId: null,
            allJurisdiction: null,
        },
        modal: false,
        newCompany: {
            create: false,
            package_selected: 'Standart',
            price: {
                Basic: 300,
                Standart: 500,
                Premium: 700,
                Ultimate: 1000,
            },
            services_list: [],
            addService: [],
            total: null,
            jurisdictionId: null ,
            CompanyCountry: '',
            CompanyCountryCode: '',
            CompanyName: '',
            CompanyPage: '',
            CompanyId: null,
            card: '',
            mounth: '',
            year: '',
            cvv: '',
            holder: '',
            cardData: '',
            billfirstname: '',
            billCity: '',
            billzip: '',
            billaddress1: '',
            billlastname: '',
            billCountry: '',
            billState: '',
            billaddress2: '',
            paymentStatus: '',
            wire_fullname: '',
            wire_regaddress: '',
            wire_regnum: '',
            wire_emailinvice: '',
        },
        myCompanys: [],
        editCompany: {
            website: '',
            email: '',
            addr: '',
            type: '0',
            other_type: '',
            AuthorizedShareCapital: '',
            OrdinaryShare: '',
            IssuedShareCapital: '',
            Activities: '',
            ActivitiesLenght: 0,
            countryUndertaken: [],
            uboStatus:{
                Owner: false,
                Director: false,
                Shareholder: false,
                Secretary: false,
            },
        },
        allCountry: [],
        ourCountry: [],
        persons:[],
        mondatoryPerson: [],
        personsShare: 0,
        addPerson:{
            ubo_lname: '',
            ubo_fname: '',
            ubo_nationality: '',
            ubo_passport: '',
            ubo_birth: '',
            ubo_placeBirth: '',
            ubo_сountryCitizenship: '',
            ubo_address: '',
            ubo_apartment: '',
            ubo_city: '',
            ubo_state: '',
            ubo_country: '',
            ubo_zip: '',
            ubo_phone: '',
            ubo_fax: '',
            ubo_email: '',
            ubo_occupation: '',
            ubo_coupon: '',
            ubo_share: '',
            checkOwner: false,
            checkShareholder: false,
            checkSecretary: false,
            checkDirector: false,
            checkAuthorized: false,
            pep: false,
        },
        manager:{
            newCompany:{
                applicant_Email: '',
                applicant_CompanyCountry: '',
                applicant_CompanyCountryCode: '',
                applicant_CompanyJurisdictionId: '',
                applicant_CompanyPackage: 'Basic',
                applicant_Price:
                    {
                        Basic: '',
                        Standart: '',
                        Premium: '',
                        Ultimate: '',
                    },
                applicant_CompanyTotal: '0',
                applicant_packages: '',
                applicant_companyName: '',
                applicant_firstName: '',
                applicant_City: '',
                applicant_zip_code: '',
                applicant_lastName: '',
                applicant_phone: '',
                applicant_Country: '',
                applicant_State: '',
                applicant_billfirstname: '',
                applicant_billCity: '',
                applicant_billzip: '',
                applicant_billaddress1: '',
                applicant_billlastname: '',
                applicant_billCountry: '',
                applicant_billState: '',
                applicant_billaddress2: '',
                applicant_phone_carrier: '',
                applicant_phone_country_code: '',
                applicant_phone_country_name: '',
                applicant_phone_country_prefix: '',
                applicant_phone_international_format: '',
                applicant_phone_line_type: '',
                applicant_phone_local_format: '',
                applicant_phone_location: '',
                applicant_phone_number: '',
                applicant_phone_valid: '',

            },
            managerClients: [],
            managerClientsCompany: [],
        },
        messBox: false,
        applicantManagerData: null,
        sicCode:[],
        approveDocs: [],
        salesManager:{
            leads: [],
            clients: [],
            companys: [],
        }
    },
    mutations:{
        setMessBox(state, newValue){
          state.messBox = newValue
        },
        login(state, newValue){
            state.login = newValue
        },
        userlogin(state, userData){
            // console.log(userData)
            state.login = userData.login
            state.loginIn = userData.loginin
            state.userData=userData.userdata
            state.applicantManagerData=userData.managerData
            state.allCountry=userData.allCountry
            state.salesManager.leads = userData.allLeads
            state.salesManager.clients = userData.allUsers
            state.salesManager.companys = userData.allCompanys
            state.ourCountry=userData.ourCountry
            state.myCompanys=userData.myCompanys
            state.sicCode = userData.sicCode
            state.approveDocs=userData.approveDocs
            // console.log('href',window.location)
            // VueCookie.set('login', userData.login,2)
            // VueCookie.set('loginIn', userData.loginin,2)
            // VueCookie.set('userData_phone', userData.userdata.phone,2)
            // VueCookie.set('userData_email', userData.userdata.email,2)
            // VueCookie.set('userData_id', userData.userdata.id,2)
        },
        preload(state, newValue){
            state.preload = newValue
        },
        modal(state, action){
            state.modal=action;
        },
        setPackage(state,name){
            state.newCompany.package_selected=name;
        },
        addService(state, serviceId){
            state.newCompany.addService.push(serviceId)
        },
        setMyCompanys(state, newValue){
            state.myCompanys = newValue
        },
        removeService(state, serviceId){
            state.newCompany.addService.splice( state.newCompany.addService.indexOf(serviceId), 1 );
        },
        setPersons(state,newValue){
          state.persons = newValue
        },
        setTotal(state, newValue){
            state.newCompany.total = newValue
        },
        setAllCountry(state, newValue){
            state.allCountry
        },
        setUserData(state,newValue){
            state.userData.email= newValue.email
            state.userData.firstName= newValue.firstName
            state.userData.lastName= newValue.lastName
            state.userData.phone= newValue.phone
            state.userData.City= newValue.City
            state.userData.zip_code= newValue.zip_code
            state.userData.Country= newValue.Country
            state.userData.State= newValue.State
            state.userData.pass= newValue.pass
            state.userData.billfirstname= newValue.billfirstname
            state.userData.billCity= newValue.billCity
            state.userData.billzip= newValue.billzip
            state.userData.billaddress1= newValue.billaddress1
            state.userData.billlastname= newValue.billlastname
            state.userData.billCountry= newValue.billCountry
            state.userData.billState= newValue.billState
            state.userData.billaddress2= newValue.billaddress2
        },
        set_email(state, newValue){
            state.userData.email = newValue
        },
        set_avatar(state, newValue){
            state.userData.avatar = newValue
        },
        set_id(state, newValue){
            state.userData.id = newValue
        },
        set_firstName(state, newValue){
            state.userData.firstName = newValue
        },
        set_lastName(state, newValue){
            state.userData.lastName = newValue
        },
        set_phone(state, newValue){
            state.userData.phone = newValue
        },
        set_City(state, newValue){
            state.userData.City = newValue
        },
        set_zip_code(state, newValue){
            state.userData.zip_code = newValue
        },
        set_Country(state, newValue){
            state.userData.Country = newValue
        },
        set_State(state, newValue){
            state.userData.State = newValue
        },
        set_pass(state, newValue){
            state.userData.pass = newValue
        },
        set_billfirstname(state, newValue){
            state.userData.billfirstname = newValue
        },
        set_billCity(state, newValue){
            state.userData.billCity = newValue
        },
        set_billzip(state, newValue){
            state.userData.billzip = newValue
        },
        set_billaddress1(state, newValue){
            state.userData.billaddress1 = newValue
        },
        set_billlastname(state, newValue){
            state.userData.billlastname = newValue
        },
        set_billCountry(state, newValue){
            state.userData.billCountry = newValue
        },
        set_billState(state, newValue){
            state.userData.billState = newValue
        },
        set_billaddress2(state, newValue){
            state.userData.billaddress2 = newValue
        },
        setCompanyCountry(state, newValue){
            state.newCompany.CompanyCountry = newValue
        },
        setCompanyCountryCode(state, newValue){
            state.newCompany.CompanyCountryCode = newValue
        },
        setCompanyServiceList(state, newValue){
            state.newCompany.services_list = newValue
        },
        setCompanyName(state, newValue){
            state.newCompany.CompanyName = newValue
        },
        setCompanyPage(state, newValue){
            state.newCompany.CompanyPage = newValue
        },
        setCompanyId(state, newValue){
            state.newCompany.CompanyId = newValue
        },
        setCompanyCard(state, newValue){
            state.newCompany.card = newValue
        },
        setCompanyMounth(state, newValue){
            state.newCompany.mounth = newValue
        },
        setCompanyYear(state, newValue){
            state.newCompany.year = newValue
        },
        setCompanyCVV(state, newValue){
            state.newCompany.cvv = newValue
        },
        setCompanyHolder(state, newValue){
            state.newCompany.holder = newValue
        },
        setCompanyCardData(state, newValue){
            state.newCompany.cardData = newValue
        },
        setCompanyBillfirstname(state, newValue){
            state.newCompany.billfirstname=newValue
        },
        setCompanyBillCity(state, newValue){
            state.newCompany.billCity=newValue
        },
        setCompanyBillzip(state, newValue){
            state.newCompany.billzip=newValue
        },
        setCompanyBilladdress1(state, newValue){
            state.newCompany.billaddress1=newValue
        },
        setCompanyBilllastname(state, newValue){
            state.newCompany.billlastname=newValue
        },
        setCompanyBillCountry(state, newValue){
            state.newCompany.billCountry=newValue
        },
        setCompanyBillState(state, newValue){
            state.newCompany.billState=newValue
        },
        setCompanyBilladdress2(state, newValue){
            state.newCompany.billaddress2=newValue
        },
        setCompanyPaymentStatus(state, newValue){
          state.newCompany.paymentStatus = newValue
        },
        setCompanyJurisdictionId(state, newValue){
            state.newCompany.jurisdictionId = newValue
        },
        setCompanyPriceBasic(state, newValue){
            state.newCompany.price.Basic = newValue
        },
        setCompanyPriceStandart(state, newValue){
            state.newCompany.price.Standart = newValue
        },
        setCompanyPricePremium(state, newValue){
            state.newCompany.price.Premium = newValue
        },
        setCompanyPriceUltimate(state, newValue){
            state.newCompany.price.Ultimate = newValue
        },
        setCompanyCreate(state, newValue){
            state.newCompany.create = newValue
        },
        setCompanyWire_fullname(state, newValue){
            state.newCompany.wire_fullname = newValue
        },
        setCompanyWire_regaddress(state, newValue){
            state.newCompany.wire_regaddress = newValue
        },
        setCompanyWire_regnum(state, newValue){
            state.newCompany.wire_regnum = newValue
        },
        setCompanyWire_emailinvice(state, newValue){
            state.newCompany.wire_emailinvice = newValue
        },
        setEditCompany_website(state, newValue){
            state.editCompany.website = newValue
        },
        setEditCompany_email(state, newValue){
            state.editCompany.email = newValue
        },
        setEditCompany_addr(state, newValue){
            state.editCompany.addr = newValue
        },
        setEditCompany_type(state, newValue){
            state.editCompany.type = newValue
        },
        setEditCompany_other_type(state, newValue){
            state.editCompany.other_type = newValue
        },
        setEditCompany_AuthorizedShareCapital(state, newValue){
            state.editCompany.AuthorizedShareCapital = newValue
        },
        setEditCompany_OrdinaryShare(state, newValue){
            state.editCompany.OrdinaryShare = newValue
        },
        setEditCompany_IssuedShareCapital(state, newValue){
            state.editCompany.IssuedShareCapital = newValue
        },
        setEditCompany_Activities(state, newValue){
            state.editCompany.Activities = newValue
        },
        setEditCompany_countryUndertaken(state, newValue){
            state.editCompany.countryUndertaken = newValue
        },
        setEditCompany_ActivitiesLenght(state, newValue){
            state.editCompany.ActivitiesLenght = newValue
        },
        setUbo_lname(state,newValue){
            state.addPerson.ubo_lname = newValue
        },
        setUbo_fname(state,newValue){
            state.addPerson.ubo_fname = newValue
        },
        setUbo_nationality(state,newValue){
            state.addPerson.ubo_nationality = newValue
        },
        setUbo_passport(state,newValue){
            state.addPerson.ubo_passport = newValue
        },
        setUbo_birth(state,newValue){
            state.addPerson.ubo_birth = newValue
        },
        setUbo_placeBirth(state,newValue){
            state.addPerson.ubo_placeBirth = newValue
        },
        setUbo_сountryCitizenship(state,newValue){
            state.addPerson.ubo_сountryCitizenship = newValue
        },
        setUbo_fax(state,newValue){
            state.addPerson.ubo_fax = newValue
        },
        setUbo_address(state,newValue){
            state.addPerson.ubo_address = newValue
        },
        setUbo_apartment(state,newValue){
            state.addPerson.ubo_apartment = newValue
        },
        setUbo_city(state,newValue){
            state.addPerson.ubo_city = newValue
        },
        setUbo_state(state,newValue){
            state.addPerson.ubo_state = newValue
        },
        setUbo_country(state,newValue){
            state.addPerson.ubo_country = newValue
        },
        setUbo_zip(state,newValue){
            state.addPerson.ubo_zip = newValue
        },
        setUbo_phone(state,newValue){
            state.addPerson.ubo_phone = newValue
        },
        setUbo_email(state,newValue){
            state.addPerson.ubo_email = newValue
        },
        setUbo_occupation(state,newValue){
            state.addPerson.ubo_occupation = newValue
        },
        setUbo_coupon(state,newValue){
            state.addPerson.ubo_coupon = newValue
        },
        setUbo_share(state,newValue){
            state.addPerson.ubo_share = newValue
        },
        setCheckOwner(state, newValue){
          state.addPerson.checkOwner = newValue
        },
        setCheckShareholder(state, newValue){
          state.addPerson.checkShareholder = newValue
        },
        setCheckSecretary(state, newValue){
          state.addPerson.checkSecretary = newValue
        },
        setCheckDirector(state, newValue){
          state.addPerson.checkDirector = newValue
        },
        setCheckAuthorized(state, newValue){
          state.addPerson.checkAuthorized = newValue
        },
        setpep(state, newValue){
            state.addPerson.pep = newValue
        },
        set_mondatoryPerson(state, newValue){
            state.mondatoryPerson = newValue
        },
        set_personsShare(state, newValue){
            state.personsShare = newValue
        },
        editCompanyOwner(state,newValue){
          state.editCompany.uboStatus.Owner = newValue
        },
        editCompanyDirector(state,newValue){
          state.editCompany.uboStatus.Director = newValue
        },
        editCompanyShareholder(state,newValue){
          state.editCompany.uboStatus.Shareholder = newValue
        },
        editCompanySecretary(state,newValue){
          state.editCompany.uboStatus.Secretary = newValue
        },
        set_applicant_Email(state, newValue){
            state.manager.newCompany.applicant_Email = newValue
        },
        set_applicant_CompanyCountry(state, newValue){
            state.manager.newCompany.applicant_CompanyCountry = newValue
        },
        set_applicant_CompanyJurisdictionId(state, newValue){
            state.manager.newCompany.applicant_CompanyJurisdictionId = newValue
        },
        set_applicant_CompanyCountryCode(state, newValue){
            state.manager.newCompany.applicant_CompanyCountryCode = newValue
        },
        set_applicant_packages(state, newValue){
            state.manager.newCompany.applicant_packages = newValue
        },
        set_applicant_companyName(state, newValue){
            state.manager.newCompany.applicant_companyName = newValue
        },
        set_applicant_firstName(state, newValue){
            state.manager.newCompany.applicant_firstName = newValue
        },
        set_applicant_City(state, newValue){
            state.manager.newCompany.applicant_City = newValue
        },
        set_applicant_zip_code(state, newValue){
            state.manager.newCompany.applicant_zip_code = newValue
        },
        set_applicant_lastName(state, newValue){
            state.manager.newCompany.applicant_lastName = newValue
        },
        set_applicant_phone(state, newValue){
            state.manager.newCompany.applicant_phone = newValue
        },
        set_applicant_Country(state, newValue){
            state.manager.newCompany.applicant_Country = newValue
        },
        set_applicant_State(state, newValue){
            state.manager.newCompany.applicant_State = newValue
        },
        set_applicant_billfirstname(state, newValue){
            state.manager.newCompany.applicant_billfirstname = newValue
        },
        set_applicant_billCity(state, newValue){
            state.manager.newCompany.applicant_billCity = newValue
        },
        set_applicant_billzip(state, newValue){
            state.manager.newCompany.applicant_billzip = newValue
        },
        set_applicant_billaddress1(state, newValue){
            state.manager.newCompany.applicant_billaddress1 = newValue
        },
        set_applicant_billlastname(state, newValue){
            state.manager.newCompany.applicant_billlastname = newValue
        },
        set_applicant_billCountry(state, newValue){
            state.manager.newCompany.applicant_billCountry = newValue
        },
        set_applicant_billState(state, newValue){
            state.manager.newCompany.applicant_billState = newValue
        },
        set_applicant_billaddress2(state, newValue){
            state.manager.newCompany.applicant_billaddress2 = newValue
        },
        set_applicant_Price_Basic(state,newValue){
            state.manager.newCompany.applicant_Price.Basic = newValue
        },
        set_applicant_Price_Standart(state,newValue){
            state.manager.newCompany.applicant_Price.Standart = newValue
        },
        set_applicant_Price_Premium(state,newValue){
            state.manager.newCompany.applicant_Price.Premium = newValue
        },
        set_applicant_Price_Ultimate(state,newValue){
            state.manager.newCompany.applicant_Price.Ultimate = newValue
        },
        set_applicant_phone_carrier(state,newValue){
            state.manager.newCompany.applicant_phone_carrier =newValue
        },
        set_applicant_phone_country_code(state,newValue){
            state.manager.newCompany.applicant_phone_country_code =newValue
        },
        set_applicant_phone_country_name(state,newValue){
            state.manager.newCompany.applicant_phone_country_name =newValue
        },
        set_applicant_phone_country_prefix(state,newValue){
            state.manager.newCompany.applicant_phone_country_prefix =newValue
        },
        set_applicant_phone_international_format(state,newValue){
            state.manager.newCompany.applicant_phone_international_format =newValue
        },
        set_applicant_phone_line_type(state,newValue){
            state.manager.newCompany.applicant_phone_line_type =newValue
        },
        set_applicant_phone_local_format(state,newValue){
            state.manager.newCompany.applicant_phone_local_format =newValue
        },
        set_applicant_phone_location(state,newValue){
            state.manager.newCompany.applicant_phone_location =newValue
        },
        set_applicant_phone_number(state,newValue){
            state.manager.newCompany.applicant_phone_number =newValue
        },
        set_applicant_phone_valid(state,newValue){
            state.manager.newCompany.applicant_phone_valid =newValue
        },
        set_approvDocs(state,newValue){
            state.approveDocs = newValue
        },
        set_managerClients(state, newValue){
            state.manager.managerClients = newValue
        },
        set_managerClientsCompany(state, newValue){
            state.manager.managerClientsCompany = newValue
        },
        set_salesManagerClients(state, newValue){
            state.salesManager.clients = newValue
        },
        set_salesManagerLeads(state, newValue){
            state.salesManager.leads = newValue
        },
        set_salesManagerClientsCompanys(state, newValue){
            state.salesManager.companys = newValue
        }
    },
    getters:{
        getMessBox(state){
            return state.messBox
        },
        getPostUrl(state){
            return state.post_url
        },
        preload(state){
          return state.preload
        },
        getLogin(state){
            return {"loginIn": state.loginIn, "login": state.login}
        },
        getModal(state){
            return state.modal
        },
        getServiseList(state){
            return state.newCompany.services_list
        },
        getAddedServices(state){
            return state.newCompany.addService
        },
        getMyCompanys(state){
            return state.myCompanys
        },
        getPackagePrice(state){
            if(state.newCompany.package_selected=='Basic'){
                return state.newCompany.price.Basic
            }else if(state.newCompany.package_selected=='Standart'){
                return state.newCompany.price.Standart
            }else if(state.newCompany.package_selected=='Premium'){
                return state.newCompany.price.Premium
            }else if(state.newCompany.package_selected=='Ultimate'){
                return state.newCompany.price.Ultimate
            }
        },
        getPackage(state){
            return state.newCompany.package_selected
        },
        getTotal(state){
            return state.newCompany.total
        },
        getUserData(state){
            return state.userData
        },
        getPersons(state){
            return state.persons
        },
        get_email(state){
            return state.userData.email
        },
        get_id(state){
            return state.userData.id
        },
        get_firstName(state){
            return state.userData.firstName
        },
        get_lastName(state){
            return state.userData.lastName
        },
        get_phone(state){
            return state.userData.phone
        },
        get_City(state){
            return state.userData.City
        },
        get_zip_code(state){
            return state.userData.zip_code
        },
        get_Country(state){
            return state.userData.Country
        },
        get_State(state){
            return state.userData.State
        },
        get_pass(state){
            return state.userData.pass
        },
        get_avatar(state){
            return state.userData.avatar
        },
        get_billfirstname(state){
            return state.userData.billfirstname
        },
        get_billCity(state){
            return state.userData.billCity
        },
        get_billzip(state){
            return state.userData.billzip
        },
        get_billaddress1(state){
            return state.userData.billaddress1
        },
        get_billlastname(state){
            return state.userData.billlastname
        },
        get_billCountry(state){
            return state.userData.billCountry
        },
        get_billState(state){
            return state.userData.billState
        },
        get_billaddress2(state){
            return state.userData.billaddress2
        },
        getAllCountry(state){
            return state.allCountry
        },
        getOurCountry(state){
            return state.ourCountry
        },
        getCompanyCountry(state){
            return state.newCompany.CompanyCountry
        },
        getCompanyCountryCode(state){
            return state.newCompany.CompanyCountryCode
        },
        getCompanyName(state){
            return state.newCompany.CompanyName
        },
        getCompanyPage(state){
            return state.newCompany.CompanyPage
        },
        getCompanyId(state){
            return state.newCompany.CompanyId
        },
        getCompanyCard(state){
            return state.newCompany.card
        },
        getCompanyMounth(state){
            return state.newCompany.mounth
        },
        getCompanyYear(state){
            return state.newCompany.year
        },
        getCompanyCVV(state){
            return state.newCompany.cvv
        },
        getCompanyHolder(state){
            return state.newCompany.holder
        },
        getCompanyCardData(state){
            return state.newCompany.cardData
        },
        getCompanyBillfirstname(state){
            return state.newCompany.billfirstname
        },
        getCompanyBillCity(state){
            return state.newCompany.billCity
        },
        getCompanyBillzip(state){
            return state.newCompany.billzip
        },
        getCompanyBilladdress1(state){
            return state.newCompany.billaddress1
        },
        getCompanyBilllastname(state){
            return state.newCompany.billlastname
        },
        getCompanyBillCountry(state){
            return state.newCompany.billCountry
        },
        getCompanyBillState(state){
            return state.newCompany.billState
        },
        getCompanyBilladdress2(state){
            return state.newCompany.billaddress2
        },
        getCompanyPaymentStatus(state){
            return state.newCompany.paymentStatus
        },
        getCompanyJurusdictionId(state){
            return state.newCompany.jurisdictionId
        },
        getCompanyPriceBasic(state){
            return state.newCompany.price.Basic
        },
        getCompanyPriceStandart(state){
            return state.newCompany.price.Standart
        },
        getCompanyPricePremium(state){
            return state.newCompany.price.Premium
        },
        getCompanyPriceUltimate(state){
            return state.newCompany.price.Ultimate
        },
        getCompanyCreate(state){
            return state.newCompany.create
        },
        getCompanyWire_fullname(state){
            return state.newCompany.wire_fullname
        },
        getCompanyWire_regaddress(state){
            return state.newCompany.wire_regaddress
        },
        getCompanyWire_regnum(state){
            return state.newCompany.wire_regnum
        },
        getCompanyWire_emailinvice(state){
            return state.newCompany.wire_emailinvice
        },
        getEditCompany_website(state){
            return state.editCompany.website
        },
        getEditCompany_email(state){
            return state.editCompany.email
        },
        getEditCompany_addr(state){
            return state.editCompany.addr
        },
        getEditCompany_type(state){
            return state.editCompany.type
        },
        getEditCompany_other_type(state){
            return state.editCompany.other_type
        },
        getEditCompany_AuthorizedShareCapital(state){
            return state.editCompany.AuthorizedShareCapital
        },
        getEditCompany_OrdinaryShare(state){
            return state.editCompany.OrdinaryShare
        },
        getEditCompany_IssuedShareCapital(state){
            return state.editCompany.IssuedShareCapital
        },
        getEditCompany_Activities(state){
            return state.editCompany.Activities
        },
        getEditCompany_countryUndertaken(state){
            return state.editCompany.countryUndertaken
        },
        getEditCompany_ActivitiesLenght(state){
            return state.editCompany.ActivitiesLenght
        },
        getUbo_lname(state){
            return state.addPerson.ubo_lname
        },
        getUbo_fname(state){
            return state.addPerson.ubo_fname
        },
        getUbo_nationality(state){
            return state.addPerson.ubo_nationality
        },
        getUbo_passport(state){
            return state.addPerson.ubo_passport
        },
        getUbo_birth(state){
            return state.addPerson.ubo_birth
        },
        getUbo_placeBirth(state){
            return state.addPerson.ubo_placeBirth
        },
        getUbo_сountryCitizenship(state){
            return state.addPerson.ubo_сountryCitizenship
        },
        getUbo_fax(state){
            return state.addPerson.ubo_fax
        },
        getUbo_address(state){
            return state.addPerson.ubo_address
        },
        getUbo_apartment(state){
            return state.addPerson.ubo_apartment
        },
        getUbo_city(state){
            return state.addPerson.ubo_city
        },
        getUbo_state(state){
            return state.addPerson.ubo_state
        },
        getUbo_country(state){
            return state.addPerson.ubo_country
        },
        getUbo_zip(state){
            return state.addPerson.ubo_zip
        },
        getUbo_phone(state){
            return state.addPerson.ubo_phone
        },
        getUbo_email(state){
            return state.addPerson.ubo_email
        },
        getUbo_occupation(state){
            return state.addPerson.ubo_occupation
        },
        getUbo_coupon(state){
            return state.addPerson.ubo_coupon
        },
        getUbo_share(state){
            return state.addPerson.ubo_share
        },
        getCheckOwner(state){
            return state.addPerson.checkOwner
        },
        getCheckShareholder(state){
            return state.addPerson.checkShareholder
        },
        getCheckSecretary(state){
            return state.addPerson.checkSecretary
        },
        getCheckDirector(state){
            return state.addPerson.checkDirector
        },
        getCheckAuthorized(state){
            return state.addPerson.checkAuthorized
        },
        getpep(state){
            return state.addPerson.pep
        },
        get_mondatoryPerson(state){
            return state.mondatoryPerson
        },
        get_personsShare(state){
            return state.personsShare
        },
        get_editCompanyOwner(state){
            return state.editCompany.uboStatus.Owner
        },
        get_editCompanyDirector(state){
            return state.editCompany.uboStatus.Director
        },
        get_editCompanyShareholder(state){
            return state.editCompany.uboStatus.Shareholder
        },
        get_editCompanySecretary(state){
            return state.editCompany.uboStatus.Secretary
        },
        get_applicant_Email(state){
            return state.manager.newCompany.applicant_Email
        },
        get_applicant_CompanyCountry(state){
            return state.manager.newCompany.applicant_CompanyCountry
        },
        get_applicant_CompanyJurisdictionId(state){
            return state.manager.newCompany.applicant_CompanyJurisdictionId
        },
        get_applicant_CompanyCountryCode(state){
            return state.manager.newCompany.applicant_CompanyCountryCode
        },
        get_applicant_packages(state){
            return state.manager.newCompany.applicant_packages
        },
        get_applicant_companyName(state){
            return state.manager.newCompany.applicant_companyName
        },
        get_applicant_firstName(state){
            return state.manager.newCompany.applicant_firstName
        },
        get_applicant_City(state){
            return state.manager.newCompany.applicant_City
        },
        get_applicant_zip_code(state){
            return state.manager.newCompany.applicant_zip_code
        },
        get_applicant_lastName(state){
            return state.manager.newCompany.applicant_lastName
        },
        get_applicant_phone(state){
            return state.manager.newCompany.applicant_phone
        },
        get_applicant_Country(state){
            return state.manager.newCompany.applicant_Country
        },
        get_applicant_State(state){
            return state.manager.newCompany.applicant_State
        },
        get_applicant_billfirstname(state){
            return state.manager.newCompany.applicant_billfirstname
        },
        get_applicant_billCity(state){
            return state.manager.newCompany.applicant_billCity
        },
        get_applicant_billzip(state){
            return state.manager.newCompany.applicant_billzip
        },
        get_applicant_billaddress1(state){
            return state.manager.newCompany.applicant_billaddress1
        },
        get_applicant_billlastname(state){
            return state.manager.newCompany.applicant_billlastname
        },
        get_applicant_billCountry(state){
            return state.manager.newCompany.applicant_billCountry
        },
        get_applicant_billState(state){
            return state.manager.newCompany.applicant_billState
        },
        get_applicant_billaddress2(state){
            return state.manager.newCompany.applicant_billaddress2
        },
        get_applicant_phone_carrier(state){
            return state.manager.newCompany.applicant_phone_carrier
        },
        get_applicant_phone_country_code(state){
            return state.manager.newCompany.applicant_phone_country_code
        },
        get_applicant_phone_country_name(state){
            return state.manager.newCompany.applicant_phone_country_name
        },
        get_applicant_phone_country_prefix(state){
            return state.manager.newCompany.applicant_phone_country_prefix
        },
        get_applicant_phone_international_format(state){
            return state.manager.newCompany.applicant_phone_international_format
        },
        get_applicant_phone_line_type(state){
            return state.manager.newCompany.applicant_phone_line_type
        },
        get_applicant_phone_local_format(state){
            return state.manager.newCompany.applicant_phone_local_format
        },
        get_applicant_phone_location(state){
            return state.manager.newCompany.applicant_phone_location
        },
        get_applicant_phone_number(state){
            return state.manager.newCompany.applicant_phone_number
        },
        get_applicant_phone_valid(state){
            return state.manager.newCompany.applicant_phone_valid
        },
        getApplicantManagerData(state){
            return state.applicantManagerData
        },
        get_sicCode(state){
            return state.sicCode
        },
        get_approveDocs(state){
            return state.approveDocs
        },
        get_managerClients(state){
            return state.manager.managerClients
        },
        get_managerClientsCompany(state){
            return state.manager.managerClientsCompany
        },
        get_salesManagerClients(state){
            return state.salesManager.clients
        },
        get_salesManagerLeads(state){
            return state.salesManager.leads
        },
        get_salesManagerClientsCompanys(state){
            return state.salesManager.companys
        },
    }
})
/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    store,
    components: {App},
    template: '<App/>',
    computed: Vuex.mapState(['login', 'loginIn', 'userData', 'modal', 'newCompany','ourCountry']),
    mounted(){
        if(VueCookie.get('login')=='true'){
            this.$store.commit('preload',true)
            axios.post(this.$store.getters.getPostUrl, 'loginin=second&email='+VueCookie.get('email')+'&phone='+VueCookie.get('phone')+'&id='+VueCookie.get('id'))
                .then((res)=>{
                    // console.log(res.data)
                    if(res.data.loginin=='6'){
                        this.$store.commit('userlogin', res.data)
                        this.$store.commit('setCompanyCreate', false)
                        this.$store.commit('modal',false)
                        this.$store.commit('preload',false)
                        this.$router.push({path:'/companys'})
                    }else if(res.data.loginin=='3'||res.data.loginin=='4'){
                        this.$store.commit('userlogin', res.data)
                        this.$store.commit('modal',false)
                        this.$store.commit('preload',false)
                        this.$router.push({path:'/manager/addcompany'})
                    }else if(res.data.loginin=='5'){
                        this.$store.commit('userlogin', res.data)
                        this.$store.commit('modal',false)
                        this.$store.commit('preload',false)
                        this.$router.push({path:'/agent/addcompany'})
                    }else if(res.data.loginin=='9'){
                        this.$store.commit('userlogin', res.data)
                        this.$store.commit('modal',false)
                        this.$store.commit('preload',false)
                        this.$router.push({path:'/sales/sales'})
                    }

                })

        }
    }

})

