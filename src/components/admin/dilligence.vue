<template>
    <div>
        <progressBar></progressBar>
        <section class="companies">
            <div class="container">
                <h1 class="text-center">Due Dilligence</h1>
                <h4 class="text-center page-name">You are almost done. Please fill in all the necessary data to open your new company.
                    <br>An additional list of documents that need to be downloaded - you will receive an email.</h4>
                <company :caption="Continue"></company>
            </div>
        </section>
    </div>
</template>

<script>
    import progressBar from './progressbar'
    import company from './company'
    export default {
        name: "package",
        data(){
            return{
            }
        },
        methods:{
        },
        computed:{
        },
        components:{
            progressBar,
            company
        }
    }
</script>

<style scoped>

</style>