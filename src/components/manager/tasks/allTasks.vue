<template>
    <div class="container">
        <h3 style="margin: 30px;">All Tasks</h3>
        <div class="table"  style="max-height: 100vh;">
            <div class="tableHeader" style="grid-gap: 20px;">
                <div class="centrize">Change accompanies</div>
                <div class="centrize">Accompanies now</div>
                <div class="centrize">Status</div>
                <div class="centrize">Short Name</div>
                <div class="centrize">Date Start</div>
                <!--<div class="centrize">Date End</div>-->
                <!--<div class="centrize">Time End</div>-->
                <div class="centrize">What to do</div>
                <div class="centrize">Attachments</div>
            </div>
            <div class="table_body" style="max-height: 60vh;" v-if="err!=''"><div class="tableRow"><div class="centrize">{{err}}</div></div></div>
            <div class="table_body" style="max-height: 60vh;" v-else>
                <div class="tableRow" v-if="preloader"><div class="centrize"><img src="/static/img/loading.gif" alt="" style="height: 20px;"></div></div>
                <div class="tableRow" v-else v-for="item in taskList" style="grid-gap: 20px;">
                    <div class="centrize">
                        <button class="button" @click="showModal(item.id)" style="min-width: 72px;height: 27px;">change</button>
                        <div class="modal-mask" :id="item.id+'_modal'" style="display: none; ">
                            <div class="modal-wrapper" >
                                <div class="modal-container" style="width: 900px;">
                                    <button type="button" class="close" style="min-width: 33px;" @click.self="closeModal(item.id)">&times;</button>
                                    <div class="modal-body" style="margin: 0;">
                                        <div class="duble_side_box" style="margin: 20px;">
                                            <div>Who now: {{showUserData(item.who)}}</div>
                                            <div>Who agent now: {{showUserData(item.whoAgent)}}</div>
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

                                        <button class="submit popup-submit" style="position: relative; bottom: -20px;" @click.self="changeAccompanies(item.id)">save</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="centrize">{{showUserData(item.who)}}</div>
                    <!--{{showUserData(item.who,item.whoAgent)}}-->
                    <div class="centrize"><changeStatus :dropDownList="eventList" @selectedItem="whatToDo($event, item.id)" :status-now="item.status" :downStatusWidth="200"></changeStatus></div>
                    <div class="centrize">{{base64decode(item.shortname)}}</div>
                    <div class="centrize">{{item.datepickerstart}}</div>
                    <!--<div class="centrize">{{item.datepickerend}}</div>-->
                    <!--<div class="centrize">{{item.time}}</div>-->
                    <div class="centrize">{{base64decode(item.whatdo)}}</div>
                    <div class="centrize">
                        <div v-if="item.attach!='[]'" :id="'createZip_'+item.id" title="Create Zip Arcive" class="onmouse">
                            <img src="/static/img/zip.svg" alt="attach" style="height: 20px;" :id="'imgZip_'+item.id" @click="createZip(item.attach,item.id)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import changeStatus from './changeStatus'
    import axios from 'axios'
    import vselect from 'vue-select'
    const { base64encode, base64decode } = require('nodejs-base64');

    export default {
        name: "allTasks",
        components:{
            changeStatus,
            axios,
            vselect,
        },
        data(){
            return{
                inputOk: 'valid',
                inputErr: 'err',
                eventList: [
                    {
                        index: 'Payment Received',
                        label: 'Payment Received'
                    },
                    {
                        index: 'Name Choosen Approved',
                        label: 'Name Choosen Approved'
                    },
                    {
                        index: 'Documents on review',
                        label: 'Documents on review'
                    },
                    {
                        index: 'Documents under registry review',
                        label: 'Documents under registry review'
                    },
                    {
                        index: 'Documents accepted by register',
                        label: 'Documents accepted by register'
                    },
                    {
                        index: 'Company under registration',
                        label: 'Company under registration'
                    },
                    {
                        index: 'Company registered',
                        label: 'Company registered'
                    },
                    {
                        index: 'Documents shipped',
                        label: 'Documents shipped'
                    }
                ],
                taskList: [],
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
            whatToDo(data, id){
                console.log('data',data,'id',id);
                let fd = new FormData
                fd.append('task','changeStatus')
                fd.append('status', data)
                fd.append('id', id)
                axios.post(this.$store.getters.getPostUrl,fd)
                    .then(()=>{
                        this.loadTaskList()
                    })
            },
            loadTaskList(){
                this.preloader=true
                axios.post(this.$store.getters.getPostUrl,'task=loadAll')
                    .then(res=>{
                        if(res.data!="Sql is empty"){
                            this.preloader=false
                            this.taskList = res.data
                        }else{
                            this.err = 'Tasks do not exist'
                        }
                    })
            },
            base64decode(string){
                return base64decode(string)
            },
            base64encode(string){
                return base64encode(string)
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
                if(id!=null){
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
            changeAccompanies(id){
                if(this.changeManager.index!=undefined){
                    let fd = new FormData
                    fd.append('who', this.changeManager.index)
                    fd.append('whoAgent', this.changeAgent.index)
                    fd.append('changeAccompanies', id)
                    axios.post(this.$store.getters.getPostUrl,fd)
                        .then(res=>{
                            if(res.data.mess=='Sql UPDATE is ok'){
                                this.changeManager = {}
                                this.changeAgent = {}
                                this.loadTaskList()
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

            },
            createZip(fileList,id){
                let img = document.getElementById('imgZip_'+id)
                let block = document.getElementById('createZip_'+id)
                img.src = '/static/img/loading.gif'
                axios.post(this.$store.getters.getPostUrl,'createZip='+fileList)
                    .then(res=>{
                        if(res.data.link!=undefined){
                            block.innerHTML = '<a href="'+res.data.link+'" target="_blank"><img src="/static/img/zip-download.svg" alt="zip download" style="height: 20px;"></a>'
                            block.title = 'Download Zip Archive'
                        }

                    })
            }
        },
        computed: {
        },
        mounted(){
            this.loadTaskList()
            this.loadUsers()
        }
    }
</script>

<style scoped>

</style>