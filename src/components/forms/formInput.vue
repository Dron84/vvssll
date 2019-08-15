<template>
    <div class="input_group">
        <input type="text" @keyup="inputModel()" v-model="models" :class="inputModel!='' ? 'ok' : 'err'">
        <label class="label_up">{{labelName}}</label>
    </div>
</template>

<script>
    export default {
        name: "input",
        data(){
            return{
                models: '',
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
                this.$emit('inputModel',this.models)
            }
        }
    }
</script>

<style scoped>

</style>