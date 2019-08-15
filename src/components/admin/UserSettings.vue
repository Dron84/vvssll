<template>
    <section class="section">
        <div class="section-header">
            <h1>User Settings</h1>
        </div>

        <div class="section-body">
            <div class="settings_box">
                <div class='account_avatar' id='imagepreview' style="background-image: url()">
                    <form id='avatar' name='avatar' method='post' enctype='multipart/form-data'>
                        <input type='file' id="files_input" ref="files_input" class='input-file'>
                    </form>
                    <button class='account_avatar_add' style="background-color: transparent;" @click="NewAvatar">&nbsp;Edit avatar</button>
                </div>

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input type="text" class="form-control" name="settingsEmail" placeholder="Chenge email">
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" class="form-control" name="settingsoldpassword" placeholder="Old Password">
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" class="form-control" name="settingsnewpassword" placeholder="New Password">
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" class="form-control" name="settingsconfirmpassword" placeholder="Confirm Password">
                </div>
                <br>
                <button class="btn btn-success"><i class="glyphicon glyphicon-save"></i> Save Changes</button>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "UserSettings",
        data(){
            return{
                files: null
            }
        },
        methods:{
            NewAvatar(){
                let files_input = this.$refs.files_input
                console.log(files_input)
                // file = files.get(0).files;
                // let reader = new FileReader();
                // reader.onload = function (e) {
                //     console.log(e.target.result);
                //     $('#imagepreview').css({'background-image':'url("'+e.target.result+'")'}).html('&nbsp;Edit avatar');
                //     data = {'href': e.target.result,'saveAvatar': 'save'}
                //     $.ajax({
                //         type: "POST",
                //         url: post_url,
                //         data: data,
                //         success: function(data) {
                //             console.log(data);
                //         }
                //     });
                // }
                // reader.readAsDataURL(files[0]);
            }
        }
    }

</script>

<style scoped lang="sass">
    input[type='file']
        display: none
</style>