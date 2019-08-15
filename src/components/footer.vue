<template>
    <div ref="foot" id="top-footer"></div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: "foot",
        components:{axios,},
        data(){
            return{
            }
        },
        methods:{
            loadData(){
                let foot = document.implementation.createDocument('','');
               axios.post('https://cabinet.comformo.com/server/post/','getFooterComformo').then(res=>{
                   foot = document.createRange().createContextualFragment(res.data)
                   this.$refs.foot.innerHTML = foot.getElementById('top-footer').innerHTML
               })
            }
        },
        mounted(){
            this.loadData()
        }
    }
</script>
<style>

</style>
