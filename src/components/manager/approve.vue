<template>
    <div class="container">

        <h3>Documents on confirmation</h3>
        <div style="display: inline-block; position: relative; left: 50px;">
            <img src="/static/img/list-menu.svg" alt="" style="height: 20px;" class="onmouse box_shadow_hover_roundshadow" @click="changeTableView(false)">
            <img src="/static/img/list-menu-accordion.svg" alt="" style="height: 20px;"  class="onmouse box_shadow_hover_roundshadow" @click="changeTableView(true)">
        </div>
        <div class="table" style="max-height: 100vh;margin: 30px;" v-if="!tableAccordion">
            <div class="tableHeader">
                <div class="centrize">Company Name</div>
                <div class="centrize">Last Name</div>
                <div class="centrize">First Name</div>
                <div class="centrize">Email
                    <img src="/static/img/magnifier.svg" alt="" class="magnifier">
                    <input type="text" placeholder="Email" class="border accent" @keyup="search('searchRow','searchEmail')" v-model="searchtext">
                </div>
                <div class="centrize">File date</div>
                <div class="centrize">Open file</div>
                <div class="centrize">Status</div>
            </div>
            <div class="table_body" style="max-height: 100%;">
                <div class="tableRow" v-if="preloader"><div class="centrize"><img src="/static/img/loading.gif" alt="" style="height: 20px;"></div></div>
                <div class="tableRow searchRow" v-else v-for="item in this.$store.getters.get_approveDocs">
                    <div class="centrize">{{item.company.companyName}}</div>
                    <div class="centrize">{{item.user.lastName}}</div>
                    <div class="centrize">{{item.user.firstName}}</div>
                    <div class="centrize searchEmail">{{item.user.email}}</div>
                    <div class="centrize">{{item.doc.date}}</div>
                    <div class="centrize"><a :href="loadUrl(item.doc,item.company.id)" target="_blank" class="button" style="height: 30px;">OPEN</a></div>
                    <div class="centrize">
                        <changeStatus :statusNow="item.doc.status" :dropDownList="StatusDropdownList" @selectedItem="changeStatus($event,item.doc.id)"></changeStatus>
                    </div>
                </div>
            </div>
        </div>

        <div class="table" style="max-height: 100vh;margin: 30px;" v-else>
            <div class="tableHeader">
                <div class="centrize">Company Name</div>
            </div>
            <div class="table_body onmouse" style="max-height: 100%;border-top: 1px solid #ccc;" v-for="item in this.$store.getters.get_approveDocs">
                <div class="tableRow" @click="showId(item.company.id)">
                    <div class="centrize">{{item.company.companyName}}</div>
                </div>
                <transition name="fade">
                    <div class="tableRow" :id="item.company.id" style="display: none;">
                        <div class="table" style="max-height: 100%; margin: 0;">
                        <div class="tableHeader">
                            <div class="centrize">File Name</div>
                            <div class="centrize">File Date</div>
                            <div class="centrize">File Type</div>
                            <div class="centrize">Open file</div>
                            <div class="centrize">Save file</div>
                            <div class="centrize">Status</div>
                        </div>
                        <div class="table_body" style="max-height: 100%;">
                            <div class="tableRow searchRow" v-for="document in item.doc">
                                <div class="centrize">{{document.file_name.replace(document.uniqid,'')}}</div>
                                <div class="centrize">{{document.date}}</div>
                                <div class="centrize">{{document.key_name}}</div>
                                <div class="centrize"><a :href="showUrl(item.doc,item.company.id)" target="_blank" class="button" style="height: 30px;">OPEN</a></div>
                                <div class="centrize"><a :href="loadUrl(item.doc,item.company.id)" target="_blank" class="button" style="height: 30px;">SAVE</a></div>
                                <div class="centrize">
                                    <changeStatus :statusNow="item.doc.status" :dropDownList="StatusDropdownList" @selectedItem="changeStatus($event,item.doc.id)"></changeStatus>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
    import changeStatus from './tasks/changeStatus'
    const { base64encode, base64decode } = require('nodejs-base64');
    import axios from 'axios'
    export default {
        name: "approve",
        data(){
            return{
               StatusDropdownList: [
                   {
                       index:'Cancel',
                       label:'Cancel'
                   },
                   {
                       index:'Confirm',
                       label:'Confirm'
                   },
               ],
                searchtext:'',
                preloader: false,
                tableAccordion: false,
            }
        },
        methods: {
            loadUrl(row,id){
                return '/server/post/getFile.php?loadmyfile='+row.base_name+'&companyId='+id+'&type='+row.type
            },
            showUrl(row,id){
                return '/server/post/getFile.php?showmyfile='+row.base_name+'&companyId='+id+'&type='+row.type
            },
            base64decode(string){
                return base64decode(string)
            },
            base64encode(string){
                return base64encode(string)
            },
            changeStatus(status,id){
                axios.post(this.$store.getters.getPostUrl,'setDocStatus='+status+'&docID='+id)
                    .then(res=>{
                        if(res.data.mess=='Sql UPDATE is ok'){
                            this.loadApprovDocs()
                        }
                    })
            },
            loadApprovDocs(){
                this.preloader = true
                axios.post(this.$store.getters.getPostUrl,'getApprovDocs='+this.$store.getters.get_id)
                    .then(res=>{
                        this.$store.commit('set_approvDocs',res.data)
                        this.preloader = false
                    })
            },
            changeTableView(view){
                this.tableAccordion = view
                if(!view){
                    this.loadApprovDocs()
                }else{
                    this.loadApprovDocsAccordion()
                }
            },
            loadApprovDocsAccordion(){
                this.preloader = true
                axios.post(this.$store.getters.getPostUrl,'getApprovDocs='+this.$store.getters.get_id+'&accordion=true')
                    .then(res=>{
                        this.$store.commit('set_approvDocs',res.data)
                        this.preloader = false
                    })
            },
            showId(id){
              let block = document.getElementById(id)
              let dis = block.style.display
                if(dis == 'none'){
                    block.style.display = 'grid'
                }else{
                    block.style.display = 'none'
                }
            },
            search(RowClassName, ClassName){
                let searchRow = document.getElementsByClassName(RowClassName)
                for (let j = 0; j<searchRow.length; j++){
                    let search = searchRow[j].getElementsByClassName(ClassName)
                    for (let i = 0; i < search.length; i++) {
                        let searchtext = this.searchtext.toUpperCase()
                        let innertext = search[i].innerText.toUpperCase()
                        if (innertext.indexOf(searchtext) > -1) {
                            searchRow[j].style.display = "";
                        } else {
                            searchRow[j].style.display = "none";
                        }
                    }
                }
            },
        },
        components:{
            changeStatus,
        },
        mounted(){
            this.loadApprovDocs()
        }
    }
</script>