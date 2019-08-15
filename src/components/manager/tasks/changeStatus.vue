<template>
    <div class="changeStatus" @mouseover="hover = true" @mouseout="hover=false" style="position: relative;">
        <img :src="imageLink" class="edit" :title="imageTitle" ><span class="onmouse">{{statusNow}}</span>
        <div class="downStatus" :class="{'show': hover==true}" :style="'width: '+downStatusWidth+'px;'">
            <ul>
                <li v-for="item in dropDownList" @click="selectItem(item.index)">{{item.label}}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "changeStatus",
        data(){
            return{
                hover: false,
            }
        },
        props:{
            imageLink: {
                type: String,
                default: "/static/img/edit.svg"
            },
            imageTitle: {
                type: String,
                default: 'Change Status'
            },
            statusNow: {
                type: String,
                default: 'Active'
            },
            dropDownList: {
                type: Array,
                default(){
                    return [
                        {
                            index: 0,
                            label: 'active',
                        },
                        {
                            index: 1,
                            label: 'close',
                        },
                        {
                            index: 2,
                            label: 'complete',
                        },
                        {
                            index: 3,
                            label: 'cancel',
                        },
                    ]
                }
            },
            downStatusWidth: {
                type: Number,
                default: 100
            }
        },
        methods: {
            selectItem(id){
                this.hover=false
                this.$emit('selectedItem', id);
            }
        }

    }
</script>

<style scoped>

</style>