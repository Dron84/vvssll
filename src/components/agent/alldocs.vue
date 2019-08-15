<template>
    <div class="container">
        <h2>All Applicant Documents</h2>
        <h3 style="margin: 30px;"></h3>
        <div class="table"  style="max-height: 100vh;">
            <div class="tableHeader">
                <div class="centrize">ID</div>
                <div class="centrize">Last Name</div>
                <div class="centrize">First Name</div>
                <div class="centrize">Email
                    <img src="/static/img/magnifier.svg" alt="" class="magnifier">
                    <input type="text" placeholder="Email" class="border accent">
                </div>
                <div class="centrize">Open Docs</div>
            </div>
            <div class="table_body" style="max-height: 100%;">
                <div class="tableRow">
                    <div class="centrize">Lorem ipsum dolor sit amet.</div>
                    <div class="centrize">Lorem ipsum dolor sit amet.</div>
                    <div class="centrize">Lorem ipsum dolor sit amet.</div>
                    <div class="centrize">Lorem ipsum dolor sit amet.</div>
                    <div class="centrize">
                        <button @click.prevent class="button" style="height: 25px !important;">open</button>
                    </div>
                    <transition name="modal" v-if="this.$store.state.modal">
                        <div class="modal-mask" >
                            <div class="modal-wrapper" @click.self="modalClose()">
                                <div class="modal-container" style="max-width: 700px; width: 100%;">
                                    <button type="button" class="close" @click="modalClose()">&times;</button>
                                    <h3>Applicant Documents</h3>

                                    <div class="table"  style="max-height: 100%;">
                                        <div class="tableHeader">
                                            <div class="centrize">Type</div>
                                            <div class="centrize">File</div>
                                            <div class="centrize">Status</div>
                                        </div>
                                        <div class="table_body" style="max-height: 60%;">
                                            <div class="tableRow">
                                                <div class="centrize">Lorem ipsum dolor sit amet.</div>
                                                <div class="centrize">
                                                    <button @click.prevent class="button" style="height: 25px !important;">open</button>
                                                </div>
                                                <div class="centrize">Lorem ipsum</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="centrize">
                                        <button v-if="CheckNameData.status==''" type="button" class="submit"  @click="checkName" style="background-image: -webkit-linear-gradient( 128deg, rgb(255,136,0) 0%, rgb(251,159,53) 0%, rgb(255,136,0) 97%);width: 100%;">CHECK AVAILABILITY</button>
                                        <button v-if="CheckNameData.status=='ok'" type="button" class="submit"  style="width: 100%;" @click="createCompany" :class="[CheckNameData.status=='ok' ? confirmClass: notConfirmClass]">CONFIRM</button>
                                        <button v-if="CheckNameData.status=='err'" type="button" class="submit"  style="width: 100%;" :class="[CheckNameData.status=='err' ? notConfirmClass: confirmClass]">NO AVAILABILITY</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "alldocs"
    }
</script>

<style scoped>

</style>