<template>
    <div class="addBlock">
        <button class="button" @click="$refs.img.click()" v-if="btnRound==false">{{btnCaption}}</button>
        <div class="addTaskAttach box_shadow_hover_roundshadow" @click="$refs.img.click()" v-else><span>{{btnCaption}}</span></div>
        <input type="file" multiple @change="loadImg($event)" :accept="acceptType" ref="img" style="display: none;">
        <div class="loadedImages">
            <div class="prevImg" v-for="img in loadedImages" :style="style(img)" />
        </div>
    </div>
</template>

<script>
    export default {
        name: "addImage",
        data(){
            return{
                mess: '',
                images: [],
                loadedImages: [],
            }
        },
        props:{
            btnCaption: {type: String, default: 'Add Image'},
            btnRound: { type: Boolean, default: false},
            acceptType: { type: String, default: 'image/*,application/pdf'}
        },
        methods:{
            loadImg(data){
                let files = data.target.files;
                let loadedImages=[]
                for(let i=0; i<files.length; i++){
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        loadedImages.push(e.target.result)
                    }
                    reader.readAsDataURL(files[i]);
                }
                this.$emit('files', this.$refs.img.files)
                this.$emit('Base64Image', loadedImages)
                this.loadedImages = loadedImages
            },
            style(src){
                let s = src.split(',')
                if(s[0]=="data:application/pdf;base64"){
                    return "background-image: url('/static/img/pdf-file.svg')"
                }else{
                    return "background-image: url('"+src+"')"
                }

            }
        }
    }
</script>

<style scoped>

</style>