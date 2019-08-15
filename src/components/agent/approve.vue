<template>
    <div class="container">
        <h2>Documents on confirmation</h2>
        <h3 style="margin: 30px;">No files in this On Checking</h3>

        <div class="table"  style="max-height: 100vh;">
            <div class="tableHeader">
                <div class="centrize">Last Name</div>
                <div class="centrize">First Name</div>
                <div class="centrize">Email
                    <img src="/static/img/magnifier.svg" alt="" class="magnifier">
                    <input type="text" placeholder="Email" class="border accent">
                </div>
                <div class="centrize">File date</div>
                <div class="centrize">File status</div>
                <div class="centrize">Open file</div>
                <div class="centrize">Change status</div>
            </div>
            <div class="table_body" style="max-height: 100%;">
                <div class="tableRow">
                    <div class="centrize">Lorem ipsum dolor sit amet.</div>
                    <div class="centrize">Lorem ipsum dolor sit amet.</div>
                    <div class="centrize">Lorem ipsum dolor sit amet.</div>
                    <div class="centrize">Lorem ipsum dolor sit amet.</div>
                    <div class="centrize">Lorem ipsum dolor sit amet.</div>
                    <div class="centrize">Lorem ipsum dolor sit amet.</div>
                    <div class="centrize">
                        <div @click.prevent><img src="/static/img/edit.svg" alt="" class="edit"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "approve"
    }
</script>

<style scoped>

</style>