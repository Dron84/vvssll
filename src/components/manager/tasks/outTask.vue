<template>
    <div class="container">
        <h3 style="margin: 30px;">{{HeaderCaption}}</h3>
        <div class="table"  style="max-height: 100vh;">
            <div class="tableHeader">
                <div class="centrize">Status</div>
                <div class="centrize">Short Name</div>
                <div class="centrize">Date Start</div>
                <!--<div class="centrize">Date End</div>-->
                <!--<div class="centrize">Time End</div>-->
                <div class="centrize">What to do</div>
                <div class="centrize">Attachments</div>
            </div>
            <div class="table_body" style="max-height: 60vh;" v-if="err!=''"><div class="tableRow"><div class="centrize">{{err}}</div></div></div>
            <div class="table_body" style="max-height: 100%;" v-else>
                <div class="tableRow" v-if="preloader"><div class="centrize"><img src="/static/img/loading.gif" alt="" style="height: 20px;"></div></div>
                <div class="tableRow" v-else v-for="item in taskList">
                    <div class="centrize"><changeStatus :downStatusWidth="200" :dropDownList="eventList" @selectedItem="whatToDo($event, item.id)" :status-now="item.status"></changeStatus></div>
                    <div class="centrize">{{base64decode(item.shortname)}}</div>
                    <div class="centrize">{{item.datepickerstart}}</div>
                    <!--<div class="centrize">{{item.datepickerend}}</div>-->
                    <!--<div class="centrize">{{item.time}}</div>-->
                    <div class="centrize">{{base64decode(item.whatdo)}}</div>
                    <div class="centrize">{{item.attach}}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import changeStatus from './changeStatus'
    const { base64encode, base64decode } = require('nodejs-base64');

    export default {
        name: "outTask",
        data(){
            return{
                taskList:[],
                err: '',
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
                preloader: false,
            }
        },
        props:{
            HeaderCaption: {
                type: String,
                default: 'The Task set by me'
            }
        },
        components:{
            changeStatus,
        },
        methods:{
            loadTaskList(){
                this.preloader = true
                axios.post(this.$store.getters.getPostUrl,'task=loadFrom&my_id='+this.$store.getters.get_id)
                    .then(res=>{
                        if(res.data!="Sql is empty"){
                            this.preloader = false
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
        },
        mounted(){
            this.loadTaskList()
        }
    }
</script>

<style scoped>

</style>