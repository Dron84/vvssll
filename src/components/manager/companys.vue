<template>
    <div class="container">
        <h3 style="margin: 30px;">Companys</h3>
        <div class="table"  style="max-height: 100vh;">
            <div class="tableHeader" style="grid-gap: 20px;">
                <div class="centrize">Change manager</div>
                <div class="centrize">Manager now</div>
                <div class="centrize">Agent now</div>
                <div class="centrize">Company Name</div>
                <div class="centrize">Company Email</div>
            </div>
            <div class="table_body" style="max-height: 60vh;" v-if="err!=''"><div class="tableRow"><div class="centrize">{{err}}</div></div></div>
            <div class="table_body" style="max-height: 60vh;" v-else>
                <div class="tableRow" v-if="preloader"><div class="centrize"><img src="/static/img/loading.gif" alt="" style="height: 20px;"></div></div>
                <div class="tableRow" v-else v-for="item in companyList" style="grid-gap: 20px;">
                    <div class="centrize">
                        <button class="button" @click="showModal(item.id)" style="min-width: 72px;height: 27px;">change</button>
                        <div class="modal-mask" :id="item.id+'_modal'" style="display: none; ">
                            <div class="modal-wrapper" >
                                <div class="modal-container" style="width: 900px;">
                                    <button type="button" class="close" style="min-width: 33px;" @click.self="closeModal(item.id)">&times;</button>
                                    <div class="modal-body" style="margin: 0;">
                                        <div class="duble_side_box" style="margin: 20px;">
                                            <div>Who now: {{showUserData(item.userid)}}</div>
                                            <div>Who agent now: {{showUserData(item.Agent)}}</div>
                                        </div>
                                        <div class="duble_side_box" style="margin: 20px;">
                                            <div class="input-wrapper" style="margin: 0 !important;">
                                                <vselect :options="managerList" class="form-control" :class="[changeManager.length>0 ? inputOk: inputErr]" v-model="changeManager" id="changeManager" :searchable="true"></vselect>
                                                <label for="changeManager" class="label_up" style="left: 7px;">Change Manager</label>
                                            </div>
                                            <div class="input-wrapper" style="margin: 0 !important;">
                                                <vselect :options="agentList" class="form-control" :class="[changeAgent.length>0 ? inputOk: inputErr]" v-model="changeAgent" id="changeAgent" :searchable="true"></vselect>
                                                <label for="changeAgent" class="label_up" style="left: 7px;">Change Agent</label>
                                            </div>
                                        </div>
                                        <p class="centrize text_accent" v-if="axErr!=''">{{axErr}}</p>

                                        <button class="submit popup-submit" style="position: relative; bottom: -20px;" @click.self="change(item.id)">save</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="centrize">{{showUserData(item.userid)}}</div>
                    <div class="centrize">{{showUserData(item.Agent)}}</div>
                    <div class="centrize">{{item.companyName}}</div>
                    <div class="centrize"><a :href="'mailto: '+ item.CompanyEmail">{{item.CompanyEmail}}</a></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import vselect from 'vue-select'

    export default {
        name: "companys",
        components:{
            axios,
            vselect,
        },
        data(){
            return{
                inputOk: 'valid',
                inputErr: 'err',
                eventList: [
                    {
                        index: 'Active',
                        label: 'Active',
                    },
                    {
                        index: 'Close',
                        label: 'Close',
                    },
                    {
                        index: 'Complete',
                        label: 'Complete',
                    },
                    {
                        index: 'Cancel',
                        label: 'Cancel',
                    },
                ],
                companyList: [],
                err: '',
                users: [],
                changeManager: {},
                changeAgent: {},
                managerList: [],
                agentList: [],
                who: '',
                whoAgent: '',
                axErr: '',
                preloader: false,
            }
        },
        methods: {
            loadcompanyList(){
                this.preloader=true
                axios.post(this.$store.getters.getPostUrl,'load=AllCompanys')
                    .then(res=>{
                        if(res.data!="Sql is empty"){
                            this.preloader=false
                            this.companyList = res.data
                        }else{
                            this.err = 'Companys not exist'
                        }
                    })
            },
            showModal(id){
                let modal = document.getElementById(id+'_modal')
                modal.style.display = 'table'
            },
            closeModal(id){
                let modal = document.getElementById(id+'_modal')
                modal.style.display = 'none'
            },
            showUserData(id){
                if(id!=null&&id!=''){
                    let u = ''
                    this.users.forEach(user=>{
                        if(id==user.id){
                            u = user.firstName+' '+user.lastName+' ('+user.email+')'
                        }
                    })
                    return u
                }else {
                    return 'No user or agent added'
                }

            },
            getManagerList(){
                this.managerList = []
                this.users.forEach(user=>{
                    if(user.premission_group=='3'||user.premission_group=='4'){
                        this.managerList.push({'index':user.id,'label': user.firstName+' '+user.lastName+' ('+user.email+')'})
                    }
                })
            },
            getAgentList(){
                this.agentList = []
                this.users.forEach(user=>{
                    if(user.premission_group=='5'){
                        this.agentList.push({'index':user.id,'label': user.firstName+' '+user.lastName+' ('+user.email+')'})
                    }
                })
            },
            loadUsers(){
                axios.post(this.$store.getters.getPostUrl,'load=UsersAll')
                    .then(res=>{
                        this.users = res.data
                        this.getManagerList()
                        this.getAgentList()
                    })
            },
            change(id){
                if(this.changeManager.index!=undefined){
                    let fd = new FormData
                    fd.append('userid', this.changeManager.index)
                    fd.append('Agent', this.changeAgent.index)
                    fd.append('changeManager', id)
                    axios.post(this.$store.getters.getPostUrl,fd)
                        .then(res=>{
                            if(res.data.mess=='Sql UPDATE is ok'){
                                this.changeManager = {}
                                this.changeAgent = {}
                                this.loadcompanyList()
                                this.closeModal(id)
                            }else{
                                this.axErr = 'Can`t update, try later!'
                            }
                            setTimeout(()=>{
                                this.axErr = ''
                            },10000)
                        })
                }else{
                    this.axErr = 'Can`t remove manager, Change to new manager!'
                    setTimeout(()=>{
                        this.axErr = ''
                    },10000)
                }

            }
        },
        mounted(){
            this.loadcompanyList()
            this.loadUsers()
        }
    }
</script>

<style scoped>

</style>