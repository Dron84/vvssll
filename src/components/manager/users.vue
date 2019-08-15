<template>
    <div class="container">
        <h3>Managers</h3>
        <div class="buttons">
            <div class="addnew" @click="newUserModal=true">
                <div id="addUser" class="add">+</div>
                <label for="addUser">Add New User</label>
            </div>
            <div class="modal-mask" v-if="newUserModal">
                <div class="modal-wrapper" >
                    <div class="modal-container" style="width: 900px;padding: 0;">
                        <button type="button" class="close" style="min-width: 33px;" @click.self="closeUser()">&times;</button>
                        <div class="modal-body" style="margin: 0;">
                            <register :modal="true"></register>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table"  style="max-height: 100vh;">
            <div class="tableHeader">
                <div class="centrize">ID</div>
                <div class="centrize">Last Name</div>
                <div class="centrize">First Name</div>
                <div class="centrize">Email
                    <img src="/static/img/magnifier.svg" alt="" class="magnifier">
                    <input type="text" placeholder="Email" class="border accent">
                </div>
                <div class="centrize">Edit</div>
                <div class="centrize">Remove</div>
            </div>
            <div class="table_body" style="max-height: 60vh;" >
                <div class="tableRow" v-if="preloader"><div class="centrize"><img src="/static/img/loading.gif" alt="" style="height: 20px;"></div></div>
                <div class="tableRow" v-else v-for="user in users">
                    <div class="centrize">{{user.id}}</div>
                    <div class="centrize">{{user.lastName}}</div>
                    <div class="centrize">{{user.firstName}}.</div>
                    <div class="centrize">{{user.email}}.</div>
                    <div class="centrize">
                        <div @click.prevent><img src="/static/img/edit.svg" alt="" class="edit"></div>
                    </div>
                    <div class="centrize">
                        <div @click.prevent><img src="/static/img/garbage_accent.svg" alt="" class="edit"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import register from '@/components/admin/authRegister.vue'
    export default {
        name: "users",
        components:{axios,register},
        data(){
            return{
                users: [],
                newUserModal: false,
                preloader: false,
            }
        },
        methods:{
            loadUsers(){
                this.preloader=true
                axios.post(this.$store.getters.getPostUrl,'load=UsersAll')
                    .then(res=>{
                        res.data.forEach(user=>{
                            if(user.premission_group=='3'||user.premission_group=='4'||user.premission_group=='9'){
                                this.users.push(user)
                            }
                        })
                        this.preloader=false
                    })
            },
            closeUser(){
                this.newUserModal = false
                this.loadUsers()
            }

        },
        mounted(){
            this.loadUsers()
        }
    }
</script>

<style scoped>

</style>