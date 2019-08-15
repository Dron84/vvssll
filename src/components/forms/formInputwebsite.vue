<template>
    <div class="input_group">
        <div v-if="website_status=='wait'">
            <img src="/static/img/loading.gif" alt="loading" style="position: absolute;height: 15px;right: 20px;top: 30%;">
            <input type="text" disabled="disabled" v-model="models">
            <label class="label_up">{{labelName}}</label>
        </div>
        <div v-else>
            <input type="text" @change="check()" v-model="models" :class="website_status=='exist' ? 'ok' : 'err'">
            <label class="label_up">{{labelName}}</label>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: "input",
        data(){
            return{
                models: '',
                website_status: '',
            }
        },
        props:{
            labelName: {
                type: String,
                default: 'Label name'
            },
        },
        methods: {
            inputModel(){
                this.$emit('inputModel',{'ns':this.website_status, 'input': this.models})
            },
            check(){
                this.website_status = 'wait'
                axios.post(this.$store.getters.getPostUrl,'checkwebsite='+this.models)
                    .then((res)=>{
                        this.website_status = res.data.nsrecord
                        this.inputModel()
                    })
            }
        }
    }
</script>

<style scoped>

</style>