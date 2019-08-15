<template>
    <div class="container">
        <h3>{{HeaderCaption}}</h3>
        <div class="duble_side_box">
            <div class="left">
                <div class="input_group">
                    <vselect v-model="companion" id="companion" :options="companionOptions" autofocus required :tabindex="1" style="height: 40px"></vselect>
                    <label for="companion" class="label_up" style="left: 8px">Select companion</label>
                </div>
                <div class="input-wrapper">
                    <date class="form-control" :class="[startDate ? inputOk: inputErr]" id="startDate" v-model="startDate" :format="customFormatter" tabindex="2"></date>
                    <label for="startDate" class="label-up">The start Date</label>
                </div>
                <div class="input-wrapper">
                    <date class="form-control" :class="[endDate ? inputOk: inputErr]" id="endDate" v-model="endDate" :format="customFormatter" tabindex="3"></date>
                    <label for="endDate" class="label-up">The end Date</label>
                </div>
                <div class="input_group">
                    <timepicker id='endTime' v-model="endTime" tabindex="4" :class="[endTime ? inputOk: inputErr]" :minute-interval="5"></timepicker>
                    <label for="endTime" class="label_up">The end Time</label>
                </div>
            </div>
            <div class="right">
                <div class="input_group">
                    <input type="text" id='taskname' :class='[taskname ? inputOk : inputErr]' v-model="taskname" required tabindex="5">
                    <label for="taskname">Enter the task name</label>
                </div>
                <div class="input_group">
                    <textarea id="whatToDo" v-model="whatToDo" tabindex="6" :class='[whatToDo ? inputOk : inputErr]'></textarea>
                    <label for="whatToDo">What to do</label>
                </div>
            </div>
        </div>
        <addImage :btnRound="true" @files="taskAttach($event)" btnCaption="Add Attachments" v-if="reload == false"></addImage>
        <div class="input_group centrize" style="margin-top: 20px;">
            <button class="button" @click.prevent="addTask" v-if="!addTaskLoading" :disabled="checkAddTask">{{btnCaption}}</button>
            <button class="button" disabled="disabled" v-else><img src="/static/img/loading.gif" alt=""  style="display: inline-block; text-align: center"></button>
        </div>
    </div>
</template>

<script>
    import date from 'vuejs-datepicker'
    import vselect from 'vue-select'
    import timepicker from 'vue2-timepicker'
    import addImage from '@/components/addImage.vue'
    import axios from 'axios'
    const { base64encode, base64decode } = require('nodejs-base64');

    let moment = require('moment');

    export default {
        name: "tasks",
        data(){
            return{
                inputOk: 'valid',
                inputErr: 'err',
                companion: [],
                companionOptions: [],
                taskname: '',
                whatToDo: '',
                endTime: {
                    HH: "00",
                    mm: "00",
                },
                endDate: '',
                startDate: '',
                attachment: [],
                addTaskLoading: false,
                reload: false
            }
        },
        props: {
            HeaderCaption: {
                type: String,
                default: 'Add Task',
            },
            btnCaption: {
                type: String,
                default: 'Send a task'
            }
        },
        components:{
            date,
            vselect,
            moment,
            timepicker,
            addImage,
        },
        methods: {
            customFormatter(date) {
                return moment(date).format('YYYY-MM-DD');
            },
            taskAttach(data){
                this.attachment = data
            },
            loadCompanionOptions(){
                axios.post(this.$store.getters.getPostUrl, 'companion=load')
                    .then(res=>{
                        if(res.data!='Sql is empty'){
                            this.companionOptions = res.data
                        }else{
                            this.companionOptions=[{'index': 0,'label': 'No companion'}]
                        }

                    })
            },
            addTask(){
                this.addTaskLoading = true
                let fd = new FormData
                fd.append('task', 'add')
                if(this.attachment.length>0){
                    let files = this.attachment; //это массив файлов
                    for(let i=0;i<files.length;i++){
                        fd.append("attachment_"+i,files[i]);
                    }
                }
                fd.append('who', this.companion.index)
                fd.append('datepickerend', this.customFormatter(this.endDate))
                fd.append('datepickerstart', this.customFormatter(this.startDate))
                fd.append('time', this.endTime.HH+':'+this.endTime.mm)
                fd.append('howSendTask', this.$store.getters.get_id)
                fd.append('whatdo', base64encode(this.whatToDo))
                fd.append('shortname', base64encode(this.taskname))
                fd.append('status','Active')
                axios.post(this.$store.getters.getPostUrl, fd)
                    .then(()=>{
                        this.$emit('taskReload', 'true')
                        this.reload = true
                        setTimeout(()=>{
                            this.reload=false
                        },1000)
                        this.companion = []
                        this.taskname=''
                        this.whatToDo=''
                        this.endDate=''
                        this.startDate=''
                        this.attachment=[]
                        this.endTime= {
                            HH: "00",
                            mm: "00",
                        }
                        this.addTaskLoading = false
                    })
            },
            base64encode(string){
                return base64encode(string);
            },

        },
        computed:{
            checkAddTask(){
                console.log(this.companion.index,this.taskname,this.whatToDo,this.endDate,this.startDate)
                if(this.companion.index!=undefined && this.taskname!='' && this.whatToDo!='' &&  this.endDate!='' && this.startDate!=''){
                    return false
                }else{
                    return true
                }
            }
        },
        mounted(){
            this.loadCompanionOptions()
        }
    }
</script>

<style scoped>

</style>