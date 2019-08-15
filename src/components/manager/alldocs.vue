<template>
    <div class="container">
        <h3>All Applicant Documents</h3>

        <div class="table" style="max-height: 100vh;margin: 30px;">
            <div class="tableHeader">
                <div class="centrize">Last Name</div>
                <div class="centrize">First Name</div>
                <div class="centrize">Email
                    <img src="/static/img/magnifier.svg" alt="" class="magnifier">
                    <input type="text" placeholder="Email" class="border accent" @keyup="search('searchRow','searchEmail')" v-model="searchtext">
                </div>
                <div class="centrize">File date</div>
                <div class="centrize">Open file</div>
                <div class="centrize">Status <changeFilter imageLink="/static/img/filter.svg" imageTitle="Change Filter" :dropDownList="filterList" statusNow="Not filtered" @selectedItem="changeFilter($event)"></changeFilter></div>
            </div>
            <div class="table_body" style="max-height: 100%;">
                <div class="tableRow" v-if="preloader"><div class="centrize"><img src="/static/img/loading.gif" alt="" style="height: 20px;"></div></div>
                <div class="tableRow searchRow" v-else v-for="item in allDocs">
                    <div class="centrize">{{item.user.lastName}}</div>
                    <div class="centrize">{{item.user.firstName}}</div>
                    <div class="centrize searchEmail">{{item.user.email}}</div>
                    <div class="centrize">{{item.doc.date}}</div>
                    <div class="centrize"><a :href="loadUrl(item.doc,item.company.id)" target="_blank" class="button" style="height: 30px;">OPEN</a></div>
                    <div class="centrize searchStatus">{{item.doc.status}}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import changeFilter from '@/components/manager/tasks/changeStatus.vue'
    export default {
        name: "alldocs",
        components:{changeFilter,},
        data(){
            return{
                allDocs: [],
                searchtext: '',
                preloader: false,
                filterList: [
                    {index: null, label: 'Not filtered'},
                    {index: 'loaded', label: 'loaded'},
                    {index: 'Cancel', label: 'Cancel'},
                    {index: 'Confirm', label: 'Confirm'},
                ]
            }
        },
        methods: {
            loadUrl(row,id){
                return '/server/post/getFile.php?loadmyfile='+row.base_name+'&companyId='+id+'&type='+row.type
            },
            loadAllDocs(){
                this.preloader = true
                axios.post(this.$store.getters.getPostUrl,'getAllDocs=load')
                    .then(res=>{
                        console.log(res.data)
                        this.allDocs = res.data
                        this.preloader = false
                    })
            },
            search(RowClassName, ClassName){
                let searchRow = document.getElementsByClassName(RowClassName)
                for (let j = 0; j<searchRow.length; j++){
                    let search = searchRow[j].getElementsByClassName(ClassName)
                    for (let i = 0; i < search.length; i++) {
                        let searchtext = this.searchtext.toUpperCase()
                        let innertext = search[i].innerText.toUpperCase()
                        if (innertext.indexOf(searchtext) > -1) {
                            searchRow[j].style.display = "grid";
                        } else {
                            searchRow[j].style.display = "none";
                        }
                    }
                }
            },
            changeFilter(filters){
                console.log(filters)
                if(filters!=null){
                    let searchRow = document.getElementsByClassName('searchRow')
                    for (let j = 0; j<searchRow.length; j++){
                        let search = searchRow[j].getElementsByClassName('searchStatus')
                        for (let i = 0; i < search.length; i++) {
                            let searchtext = filters.toUpperCase()
                            let innertext = search[i].innerText.toUpperCase()
                            if (innertext.indexOf(searchtext) > -1) {
                                searchRow[j].style.display = "grid";
                            } else {
                                searchRow[j].style.display = "none";
                            }
                        }
                    }
                }else{
                    let searchRow = document.getElementsByClassName('searchRow')
                    for (let j = 0; j<searchRow.length; j++){
                        searchRow[j].style.display = "grid";
                    }
                }

            },
        },
        mounted(){
            this.loadAllDocs()
        }
    }
</script>

<style scoped>

</style>