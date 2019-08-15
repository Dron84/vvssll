<template>
    <div>
        <div class="input_group_select">
            <Multiselect v-model="status" :options="statusOption" :placeholder="placeholder" :label="selectLabelName" :track-by="selectLabelIndex" :searchable="searchable" @input="onSelect" :class="[status!='' ? okClass : errorClass]" :multiple="multiple" :close-on-select="closeOnSelect" :hideSelected="hideSelected"></Multiselect>
            <label class="label-up" style="position: absolute;top: -6px;left: 6px;font-family: 'Brandon Grotesque';font-weight: 500;font-size: .8em;letter-spacing: .05em;line-height: .8em;text-align: left;z-index: 1;color: #2f2f2f;background-color: #fff;">{{labelName}}</label>
        </div>
        <transition name="fade" v-if="status.index==2">
            <div class="input_group">
                        <textarea id="status" v-model="statusElse" rows="3"
                                  :class="[status!='' ? okClass : errorClass]" @keyup="onSelect" @change="onSelect"></textarea>
                <label for="status">Reason why irrelevant</label>
            </div>
        </transition>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import axios from 'axios'
    export default {
        name: "formUsersStatus",
        components:{Multiselect,},
        data(){
            return{
                okClass: 'ok',
                errorClass: 'err',
                statusOption: [],
                status: {},
                statusElse: '',
            }
        },
        props: {
            clientType: {
                type: Boolean,
                default: false,
            },
            labelName:{
                type: String,
                default: 'Label name'
            },
            placeholder: {
                type: String,
                default: 'Select one',
            },
            selectLabelName: {
                type: String,
                default: 'label',
            },
            selectLabelIndex: {
                type: String,
                default: 'index',
            },
            searchable: {
                type: Boolean,
                default: true
            },
            multiple: {
                type: Boolean,
                default: false
            },
            closeOnSelect:{
                type: Boolean,
                default: true
            },
            hideSelected:{
                type: Boolean,
                default: false
            },
        },
        methods:{
            onSelect(){
                this.$emit('selectedStatus',{status: this.status.index,statusElse: this.statusElse})
            },
            loadStatusOptions(){
                axios.post(this.$store.getters.getPostUrl,'load=usersStatus').then(res=>{
                    let data = res.data
                    if(this.clientType==true){
                       data.forEach(item=>{
                           if(item.forClient==1){
                               this.statusOption.push({index: item.index, label: item.label})
                           }
                       })
                    }else{
                        data.forEach(item=>{
                            if(item.forClient==0){
                                this.statusOption.push({index: item.index, label: item.label})
                            }
                        })
                    }
                })
            }
        },
        created(){
            this.loadStatusOptions()
        }
    }
</script>

<style scoped>

</style>