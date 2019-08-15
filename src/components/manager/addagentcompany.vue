<template>
    <div class="container">
        <h3>Add Company in Jurisdiction</h3>
        <div class="duble_side_box" style="margin: 30px; grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));">
            <div>
                <h3>Add Agent Company</h3>
                <div class="border padding">
                    <div class="input_group">
                        <select type="text" id="jurisdiction">
                            <option value=""></option>
                        </select>
                        <label for="jurisdiction">Select Jurisdiction</label>
                    </div>
                    <div class="input_group">
                        <input type="text" id="companyName">
                        <label for="companyName">Company Name</label>
                    </div>
                    <div class="input_group centrize">
                        <button class="button">add Company</button>
                    </div>
                </div>
            </div>
            <div>
                <h3>Agent in company</h3>
                <div class="table" style="max-height: 250px;">
                    <div class="tableHeader">
                        <div class="centrize">ID</div>
                        <div class="centrize">Company Name</div>
                        <div class="centrize">Jurisdiction</div>
                    </div>
                    <div class="table_body" style="max-height: 210px;">
                        <div class="tableRow">
                            <div class="centrize">12</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">BUlgaria
                                <img src="/static/img/garbage_red.svg" alt="" class="removeRow">
                            </div>
                        </div>
                        <div class="tableRow">
                            <div class="centrize">12</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">BUlgaria
                                <img src="/static/img/garbage_red.svg" alt="" class="removeRow">
                            </div>
                        </div>
                        <div class="tableRow">
                            <div class="centrize">12</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">BUlgaria
                                <img src="/static/img/garbage_red.svg" alt="" class="removeRow">
                            </div>
                        </div>
                        <div class="tableRow">
                            <div class="centrize">12</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">BUlgaria
                                <img src="/static/img/garbage_red.svg" alt="" class="removeRow">
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "addagentcompany"
    }
</script>

<style scoped>

</style>