<template>
    <div>
        <div class="centrize" style="margin: 20px 0;" v-if="$store.getters.getLogin.loginIn=='4'||$store.getters.getLogin.loginIn=='8'">
            <button class="button" @click="nav=false" :class="{'selected': nav==false}">Add New</button> | <button class="button" @click="nav=true" :class="{'selected': nav==true}">All Tasks</button>
        </div>
        <div v-if="!nav">
            <addTasks btnCaption="Add Task" v-if="$store.getters.getLogin.loginIn=='4'||$store.getters.getLogin.loginIn=='8'" @taskReload="reloadTasks()"></addTasks>
            <div v-if="allTasks == true">
                <inTasks v-if="$store.getters.getLogin.loginIn=='3'||$store.getters.getLogin.loginIn=='4'||$store.getters.getLogin.loginIn=='8'"></inTasks>
                <outTasks v-if="$store.getters.getLogin.loginIn=='4'||$store.getters.getLogin.loginIn=='8'"></outTasks>
            </div>
        </div>
        <div v-else>
            <allTasks></allTasks>
        </div>
    </div>
</template>

<script>
    import addTasks from './tasks/addTask'
    import inTasks from './tasks/inTask'
    import allTasks from './tasks/allTasks'
    import outTasks from './tasks/outTask'
    export default {
        name: "tasks",
        components: {
            addTasks,
            inTasks,
            outTasks,
            allTasks,
        },
        data(){
            return{
                allTasks: true,
                nav: false,
            }
        },
        methods: {
            reloadTasks(){
                this.allTasks=false;
                setTimeout(()=>{
                    this.allTasks=true;
                },100)
            }
        }
    }
</script>

<style scoped>

</style>