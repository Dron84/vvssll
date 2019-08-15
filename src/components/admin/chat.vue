<template>
    <div class="messWrapper">
        <div class="messManagerBox">
            <div class="messManagerAvatar" :style="bg_img(ManagerData.avatar)"></div>
            <div class="messManagerName">{{ManagerData.firstName}}{{ManagerData.lastName}}</div>
            <div class="messManagerTitle">Manager</div>
            <button class="close messCloseBox" @click="closeMessBox">+</button>
        </div>
        <div class="messSelect">
            <div class="messages" style="height: 392px;" ref="messagesref">
                <div class='mrow' v-for="item in messages">
                    <div :class='item.type'>{{item.mess}}
                        <div class='mess_status' v-if="item.status!=undefined&&item.status=='read'">√√</div>
                        <div class='mess_status' v-else-if="item.status!=undefined&&item.status=='send'">√</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="inputbox">
            <!--<form id='attachments' name='attachments' method='post' enctype='multipart/form-data'>-->
                <!--<input type='file' name='files' class='input-file' style="display: none;">-->
                <!--<input type="hidden" name="messages" value="attach">-->
            <!--</form>-->
            <!--<svg version="1.1" class="attach" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129"-->
                 <!--xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">-->
                <!--<g>-->
                    <!--<path d="m60.4,58.2c1.6-1.6 1.6-4.2 0-5.8s-4.2-1.6-5.8,0l-21.7,21.7c-3.7,3.7-5.7,8.5-5.7,13.7 0,5.2 2,10 5.7,13.7 7.6,7.6 19.9,7.6 27.4,0l49-49c5.1-5.1 7.9-11.9 7.9-19.1s-2.8-14-7.9-19.1c-10.6-10.6-27.7-10.6-38.3,0l-48.9,48.9c-6.6,6.6-10.2,15.3-10.2,24.6 0,9.3 3.6,18.1 10.2,24.6 6.6,6.6 15.3,10.2 24.6,10.2 9.3,0 18.1-3.6 24.6-10.2l21.7-21.7c1.6-1.6 1.6-4.2 0-5.8s-4.2-1.6-5.8,0l-21.7,21.7c-5,5-11.7,7.8-18.8,7.8s-13.8-2.8-18.8-7.8-7.8-11.7-7.8-18.8 2.8-13.8 7.8-18.8l48.9-48.9c3.6-3.6 8.3-5.5 13.3-5.5 5,0 9.8,2 13.3,5.5 3.6,3.6 5.5,8.3 5.5,13.3s-2,9.8-5.5,13.3l-49,49c-4.3,4.3-11.4,4.3-15.8,0-2.1-2.1-3.3-4.9-3.3-7.9 0-3 1.2-5.8 3.3-7.9l21.8-21.7z"/>-->
                <!--</g>-->
            <!--</svg>-->
            <input type="text" v-model="mess" class="form-control" placeholder="Type your message here…" @keyup.enter="saveMess">
            <svg version="1.1" class="send" @click="saveMess" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 535.5 535.5" style="enable-background:new 0 0 535.5 535.5;" xml:space="preserve">
            <g>
                <polygon points="0,497.25 535.5,267.75 0,38.25 0,216.75 382.5,267.75 0,318.75 		"/>
            </g>
        </svg>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: 'chat',
        data() {
            return {
                messages: [],
                mess: '',
            }
        },
        methods: {
            closeMessBox(){
                this.$store.commit('setMessBox', false)
            },
            saveMess(){
                if(this.mess!=''){
                    let fd = new FormData
                    fd.append('from_id', this.ManagerData.id)
                    fd.append('my_id', this.$store.getters.get_id)
                    fd.append('mess', this.mess)
                    fd.append('messages','save')
                    axios.post(this.$store.getters.getPostUrl, fd)
                        .then((res)=>{
                            if(res.data.status=='ok'){
                                this.mess=''
                                this.loadMess()
                            }
                        })
                }

            },
            bg_img(data){
                return "background-image: url('"+data+"')"
            },
            loadMess(){
                this.messages = []
                let manager = this.$store.getters.getApplicantManagerData
                axios.post(this.$store.getters.getPostUrl,'messages=load&from_id='+manager.id+'&my_id='+this.$store.getters.get_id)
                    .then((res)=>{
                        // console.log(res.data);
                        if(res.data!='Sql is empty'){
                            let messages = res.data
                            messages.forEach(message=>{
                                if(message.my_id == this.$store.getters.get_id && message.who_send == this.$store.getters.get_id){
                                    this.messages.push({type: 'in', mess: message.mess, time: message.time})
                                }
                                if(message.my_id == manager.id && message.who_send == manager.id){
                                    this.messages.push({type: 'out', mess: message.mess, status: message.status, time: message.time })
                                }
                            })
                        }else{
                            this.messages.push({type: 'out', mess: 'No message', time: ''})
                        }
                    })
                setTimeout(()=>{
                    this.$refs.messagesref.scrollTop = this.$refs.messagesref.scrollHeight
                },1000)

            },

        },
        components:{
        },
        computed:{
            ManagerData(){
                let avatar = this.$store.state.applicantManagerData.avatar
                if(avatar=='null'|| avatar==null||avatar==undefined){
                    avatar = '/static/img/avatar.svg'
                }
                return {firstName: this.$store.state.applicantManagerData.firstName, lastName: this.$store.state.applicantManagerData.lastName, avatar: avatar, id: this.$store.state.applicantManagerData.id }
            }
        },
        mounted(){
            this.loadMess();

        }
    }
</script>

<style scoped>

</style>