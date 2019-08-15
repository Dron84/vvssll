<template>
    <div>
    <h4 class="centrize" style="margin-bottom: 30px;">About Lead: "{{client.firstName+' '+client.lastName}}"</h4>
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
                    <p style="text-align: left; font-size: .9em;" v-if="client.instagram!=''&&client.instagram!=null">Instagram: <br><instagram :href="client.instagram"></instagram></p>
                    <p style="text-align: left; font-size: .9em;" v-if="client.facebook!=''&&client.facebook!=null">Facebook: <br><facebook :href="client.facebook"></facebook></p>
                    <p style="text-align: left; font-size: .9em;" v-if="client.twitter!=''&&client.twitter!=null">Twitter: <br><twitter :href="client.twitter"></twitter></p>
                    <br>
                </div>
                <div class="centrize"><button class="button" data-toggle="modal" data-target="#addInvoce" style="margin-bottom: 30px;">Add Invoce</button></div>
                <div id="addInvoce" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" style="width: 22px;height: 22px;right: -3px;top: -4px;line-height: 5px;display: flex;justify-content: center;">&times;</button>
                                <h4 class="modal-title centrize">Add Invoce</h4>
                            </div>
                            <div class="modal-body">
                                <form-input @inputModel="setInvoceNum($event)" labelName="Number"></form-input>
                                <form-input @inputModel="setInvoceSum($event)" labelName="Sum"></form-input>
                                <form-input @inputModel="setInvoceDesc($event)" labelName="Description"></form-input>
                                <form-input @inputModel="setInvoceCN($event)" labelName="Company Name"></form-input>
                                <formInputwebsite @inputModel="setInvoceWebsite($event)" labelName="Company website"></formInputwebsite>
                                <!--<form-input @inputModel="setInvocePSP($event)" labelName="PSP"></form-input>-->
                                <formselectCountry countryComplect="our" @selectedCountry="selectedCountry($event)"></formselectCountry>
                                <div class="centrize"><button class="button" @click.prevent="addInvoce()" style="margin-top: 20px;" data-dismiss="modal">Add</button></div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-md-1"></div>
            <div class="col-md-7 border" style="background-color: rgba(204,204,204,.2);">
                <h3 style="margin: 10px;">Lead LOG</h3>
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
    import changeStatus from '@/components/manager/tasks/changeStatus'
    import instagram from '@/components/forms/social/instagram'
    import facebook from '@/components/forms/social/facebook'
    import twitter from '@/components/forms/social/twitter'
    import formInput from '@/components/forms/formInput'
    import formInputwebsite from '@/components/forms/formInputwebsite'
    import formselect from '@/components/forms/formselect'
    import formselectCountry from '@/components/forms/formselectCountry'
    import axios from 'axios'
    const { base64encode, base64decode } = require('nodejs-base64');

    export default {
        name: "company",
        components:{changeStatus,instagram,facebook,twitter,formInput,formselect,formInputwebsite,formselectCountry},
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
                ],
                invoce:{
                    num: '',
                    sum: 0,
                    description: '',
                    companyName: '',
                    jurisdiction: '',
                    psp:'',
                    website: '',
                }
            }
        },
        methods:{
            loadData(){
                let Clients = this.$store.getters.get_salesManagerLeads
                let ClientsCompany = this.$store.getters.get_salesManagerClientsCompanys
                let id = this.$route.params.id.split(',')
                Clients.forEach(item=>{
                    if(item.id==id[0]){
                        this.client = item
                    }
                })
                ClientsCompany.forEach(item=>{
                    if(item.id==id[1]){
                        this.company= item.company
                        this.docs = item.docs
                    }
                })
            },
            getCountryName(id){
                const countrys = this.$store.getters.getOurCountry
                for(let i=0; i<countrys.length; i++){
                    if(countrys[i].id == id){
                        return countrys[i].jurisdictionname
                    }
                }
            },
            getCountryImg(id){
                const countrys = this.$store.getters.getOurCountry
                for(let i=0; i<countrys.length; i++){
                    if(countrys[i].id == id) {
                        return '/static/img/flag/'+countrys[i].code.toLowerCase()+'.png'
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
            loadUrl(row,id){
                return '/server/post/getFile.php?loadmyfile='+row.base_name+'&companyId='+id+'&type='+row.type
            },
            showUrl(row,id){
                return '/server/post/getFile.php?showmyfile='+row.base_name+'&companyId='+id+'&type='+row.type
            },
            selectedCountry(data){
                this.invoce.jurisdiction = data.index
            },
            addInvoce(){
                let fd = new FormData
                let userId = this.$route.params.id
                fd.append('num', this.invoce.num)
                fd.append('sum', this.invoce.sum)
                fd.append('description', this.invoce.description)
                fd.append('companyName', this.invoce.companyName)
                fd.append('jurisdictionId', this.invoce.jurisdiction)
                fd.append('CompanyWebsite', this.invoce.website)
                fd.append('PSP', this.invoce.psp)
                fd.append('userId', userId)
                fd.append('invoce','add')
               // console.log(this.invoce.num,this.invoce.sum,this.invoce.description,this.invoce.companyName,this.invoce.jurisdiction,userId)
                axios.post(this.$store.getters.getPostUrl,fd).then(res=>{
                    if(res.data.company.mess == 'Sql INSERT is ok'&&res.data.invoce.mess == 'Sql INSERT is ok'&&res.data.user.mess == 'Sql INSERT is ok'){
                        this.$router.push({path:'/sales/client/'+userId})
                    }
                })
            },
            setInvoceNum(e){
                this.invoce.num = e
            },
            setInvoceSum(e){
                this.invoce.sum = e
            },
            setInvoceDesc(e){
                this.invoce.description = e
            },
            setInvoceCN(e){
                this.invoce.companyName = e
            },
            setInvoceWebsite(e){
                // console.log(e)
                this.invoce.website = e.input
            },
            setInvocePSP(e){
                this.invoce.psp = e
            },
        },
        mounted(){
            this.loadData()
        }

    }
</script>

<style scoped>

</style>