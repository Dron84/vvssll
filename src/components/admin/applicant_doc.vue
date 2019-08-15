<template>
    <div class="container">
        <div v-if="this.$store.getters.getMyCompanys == 'Sql is empty'" class="centrize">
            <h3>You don`t have a company<br>Click to open a company in menu</h3>

        </div>
        <div v-else class="company" v-for="item in this.$store.getters.getMyCompanys">
            <h3 style="margin: 30px;"></h3>
            <div class="table" style="max-height: 100vh;">
                <div class="tableHeader">
                    <div class="centrize">Company name: <b>'{{item.companyName}}'</b></div>
                </div>
                <div class="tableHeader">
                    <div class="centrize"><b>ID</b></div>
                    <div class="centrize"><b>File name</b></div>
                    <div class="centrize"><b>Type</b></div>
                    <div class="centrize"><b>Status</b></div>
                    <div class="centrize"><b>Open Docs</b></div>
                </div>
                <div class="table_body" style="max-height: 60vh;">
                    <div class="tableRow" v-if="item.docs=='Sql is empty'">
                        <div class="centrize">No documents</div>
                    </div>
                    <div class="tableRow" v-for="row in item.docs" v-else>
                        <div class="centrize">{{row.id}}</div>
                        <div class="centrize">{{row.file_name.replace(row.uniqid,'')}}</div>
                        <div class="centrize">{{row.key_name}}</div>
                        <div class="centrize">{{row.status}}</div>
                        <div class="centrize">
                            <a :href="loadUrl(row,item.id)" class="button" style="height: 25px !important;">open</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "alldocs",
        data() {
            return {

            }
        },
        methods: {
            loadUrl(row,id){
                return '/server/post/getFile.php?loadmyfile='+row.base_name+'&companyId='+id+'&type='+row.type
            }
        },
    }
</script>

<style scoped>

</style>