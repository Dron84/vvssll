<template>
    <a :href="href">
        <svg xmlns="http://www.w3.org/2000/svg" width="11.055" height="21.17" viewBox="0 0 11.055 21.17">
            <path class="a"
                  d="M87.174,21.17V11.526h3.293l.47-3.764H87.174V5.41c0-1.058.353-1.882,1.882-1.882h2V.118c-.47,0-1.647-.118-2.94-.118a4.54,4.54,0,0,0-4.822,4.94V7.762H80v3.764h3.293V21.17Z"
                  transform="translate(-80)"/>
        </svg>
    </a>
</template>

<script>
    export default {
        name: "facebook",
        data(){
            return{}
        },
        props:{
            href: {type: String, default: 'https://facebook.com'}
        }
    }
</script>

<style scoped>

</style>