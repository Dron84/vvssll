<template>
    <div class="checkbox small" :class="[iamPerson ? activeClass: notActive]" @click="person()">
        <div class="off_caption" style="width: 130px; left: -150px;"><slot>off</slot></div>
        <div class="checkbox_body"></div>
        <div class="checkbox_check">•</div>
        <div class="on_caption" style="width: 113px;"><slot>on</slot></div>
    </div>
</template>

<script>
    export default {
        name: "checkbox"
    }
</script>

<style scoped>

</style>