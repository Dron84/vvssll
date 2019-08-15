<template>
    <div>
    <h4 class="centrize" style="margin-bottom: 30px;">About Company: "{{company.companyName}}"</h4>
        <div class="row">
            <div class="col-md-4 border">
                <h3 style="margin: 20px;">Client info:</h3>
                <div class="centrize"><div class="change_avatar" style="width: 100px;height: 100px;"><img :src="checkAvatar(client.avatar)" alt="avatar" style="width: 100px; height: 100px;"></div></div>
                <div class="centrize">{{client.firstName+' '+client.lastName}}</div>
                <div>
                    <p style="text-align: left; font-size: .9em;"><b>About this contact</b></p>
                    <hr>
                    <p style="text-align: left; font-size: .9em;">Email: <br><a :href="'mailto:'+client.email">{{client.email}}</a></p>
                    <p style="text-align: left; font-size: .9em;">Phone: <br><a :href="'tel:+'+client.phone">+{{client.phone}}</a></p>
                    <br>
                    <p style="text-align: left; font-size: .9em;"><b>About this company</b></p>
                    <hr>
                    <p style="text-align: left; font-size: .9em;">Company Name: <br>{{company.companyName}}</p>
                    <p style="text-align: left; font-size: .9em;">Company Email: <br><a :href="'mailto:'+company.CompanyEmail">{{company.CompanyEmail}}</a></p>
                    <p style="text-align: left; font-size: .9em;">Company Country: <br><img :src="getCountryImg(company.jurisdiction)" :alt="getCountryName(company.jurisdiction)" style="height: 20px;position: relative;top: -2px;margin-right: 10px;">{{getCountryName(company.jurisdiction)}}</p>
                    <p style="text-align: left; font-size: .9em;">Company Package: <br><b>{{company.package}}</b></p>
                    <p style="text-align: left; font-size: .9em;">Payment Status: <br><b>{{CheckPaymentStatus(company.paymentstatus)}}</b></p>

                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-7 border" style="background-color: rgba(204,204,204,.2);">
                <h3 style="margin: 10px;">Company Documents</h3>
                <div class="table" style="margin-top: 10px; max-height: 100%;">
                    <div class="tableHeader">
                        <div class="centrize">File Name</div>
                        <div class="centrize">File date</div>
                        <div class="centrize">Open file</div>
                        <div class="centrize">Save file</div>
                        <div class="centrize">Status <changeStatus imageLink="/static/img/filter.svg" imageTitle="Change Filter" :dropDownList="filterList" statusNow="Not filtered" @selectedItem="changeFilter($event)"></changeStatus></div>
                    </div>
                    <div class="table_body" style="max-height: 100%;">
                        <div class="tableRow searchRow" v-for="item in docs">
                            <div class="centrize">{{item.file_name.replace(item.uniqid,'')}}</div>
                            <div class="centrize">{{item.date}}</div>
                            <div class="centrize"><a :href="showUrl(item,company.id)" target="_blank" class="button" style="height: 30px;">OPEN</a></div>
                            <div class="centrize"><a :href="loadUrl(item,company.id)" target="_blank" class="button" style="height: 30px;">Save</a></div>
                            <div class="centrize"><changeStatus :statusNow="item.status" :dropDownList="StatusDropdownList" @selectedItem="changeStatus($event,item.id)"></changeStatus></div>
                            <div class="centrize searchStatus" style="display: none;">{{item.status}}</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
</template>

<script>
    import changeStatus from '../tasks/changeStatus'
    const { base64encode, base64decode } = require('nodejs-base64');
    import axios from 'axios'
    export default {
        name: "company",
        components:{changeStatus,},
        data(){
            return{
                client: {},
                company: {},
                docs: {},
                StatusDropdownList: [
                    {
                        index:'Cancel',
                        label:'Cancel'
                    },
                    {
                        index:'Confirm',
                        label:'Confirm'
                    },
                ],
                filterList: [
                    {index: null, label: 'Not filtered'},
                    {index: 'loaded', label: 'loaded'},
                    {index: 'Cancel', label: 'Cancel'},
                    {index: 'Confirm', label: 'Confirm'},
                ]
            }
        },
        methods:{
            loadData(){
                let Clients = this.$store.getters.get_managerClients
                let ClientsCompany = this.$store.getters.get_managerClientsCompany
                let id = this.$route.params.id.split(',')
                Clients.forEach(item=>{
                    if(item.id==id[0]){
                        this.client = item
                    }
                })
                ClientsCompany.forEach(item=>{
                    if(item.company.id==id[1]){
                        this.company= item.company
                        this.docs = item.docs
                    }
                })
            },
            getCountryImg(id){
                const countrys = this.$store.getters.getOurCountry
                for(let i=0; i<countrys.length; i++){
                    if(countrys[i].id == id){
                        return '/static/img/flag/'+countrys[i].code.toLowerCase()+'.png'
                    }
                }
            },
            getCountryName(id){
                const countrys = this.$store.getters.getOurCountry
                for(let i=0; i<countrys.length; i++){
                    if(countrys[i].id == id){
                        return countrys[i].jurisdictionname
                    }
                }
            },
            CheckPaymentStatus(status){
                if(status!=null){
                    return 'Paid'
                }else{
                    return 'Pending Payment'
                }
            },
            checkAvatar(img){
                if(img!='' && img!=null){
                    return img
                }else{
                    return '/static/img/avatar.svg'
                }
            },
            base64decode(string){
                return base64decode(string)
            },
            base64encode(string){
                return base64encode(string)
            },
            changeFilter(filters){
                console.log(filters)
                if(filters!=null){
                    let searchRow = document.getElementsByClassName('searchRow')
                    for (let j = 0; j<searchRow.length; j++){
                        let search = searchRow[j].getElementsByClassName('searchStatus')
                        for (let i = 0; i < search.length; i++) {
                            let searchtext = filters.toUpperCase()
                            let innertext = search[i].innerText.toUpperCase()
                            if (innertext.indexOf(searchtext) > -1) {
                                searchRow[j].style.display = "grid";
                            } else {
                                searchRow[j].style.display = "none";
                            }
                        }
                    }
                }else{
                    let searchRow = document.getElementsByClassName('searchRow')
                    for (let j = 0; j<searchRow.length; j++){
                        searchRow[j].style.display = "grid";
                    }
                }

            },
            changeStatus(status,id){
                axios.post(this.$store.getters.getPostUrl,'setDocStatus='+status+'&docID='+id)
                    .then(res=>{
                        if(res.data.mess=='Sql UPDATE is ok'){
                            this.loadAllData()
                        }
                    })
            },
            loadAllData(){
                this.preloader = true
                if(this.$store.getters.getLogin.loginIn =='4'){
                    axios.post(this.$store.getters.getPostUrl,'getClients=all')
                        .then(res=>{
                            this.$store.commit('set_managerClients',res.data.users)
                            this.$store.commit('set_managerClientsCompany',res.data.companys)
                            this.preloader = false
                            this.loadData()
                        })
                }else{
                    axios.post(this.$store.getters.getPostUrl,'getClients='+this.$store.getters.get_id)
                        .then(res=>{
                            this.$store.commit('set_managerClients',res.data.users)
                            this.$store.commit('set_managerClientsCompany',res.data.companys)
                            this.preloader = false
                            this.loadData()
                        })
                }

            },
            loadUrl(row,id){
                return '/server/post/getFile.php?loadmyfile='+row.base_name+'&companyId='+id+'&type='+row.type
            },
            showUrl(row,id){
                return '/server/post/getFile.php?showmyfile='+row.base_name+'&companyId='+id+'&type='+row.type
            },
        },
        mounted(){
            this.loadData()
        }

    }
</script>

<style scoped>

</style>