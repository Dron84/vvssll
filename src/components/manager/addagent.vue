<template>
    <div class="container">
        <h3>Add Agent in company</h3>
        <div class="duble_side_box" style="margin: 30px; grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));">
            <div>
                <h3>Add users in Agents Company</h3>
                <div class="border padding">
                    <div class="input_group">
                        <select type="text" id="agent">
                            <option value=""></option>
                        </select>
                        <label for="agent">Select Agents Company</label>
                    </div>
                    <div class="duble_side_box">
                        <div class="left">
                            <div class="input_group">
                                <input type="text" id="firstName">
                                <label for="firstName">First Name</label>
                            </div>
                            <div class="input_group">
                                <input type="email" id="email">
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="right">
                            <div class="input_group">
                                <input type="text" id="lastName">
                                <label for="lastName">Last Name</label>
                            </div>
                            <div class="input_group">
                                <input type="text" id="nickName">
                                <label for="nickName">Nick Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="input_group centrize">
                        <button class="button">add new</button>
                    </div>
                </div>
            </div>
            <div>
                <h3>Agent in company</h3>
                <div class="table" style="max-height: 250px;">
                    <div class="tableHeader">
                        <div class="centrize">ID</div>
                        <div class="centrize">Email</div>
                        <div class="centrize">Company</div>
                        <div class="centrize">Jurisdiction</div>
                    </div>
                    <div class="table_body" style="max-height: 210px;">
                        <div class="tableRow">
                            <div class="centrize">12</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">BUlgaria
                                <img src="/static/img/garbage_red.svg" alt="" class="removeRow">
                            </div>
                        </div>
                        <div class="tableRow">
                            <div class="centrize">12</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">BUlgaria
                                <img src="/static/img/garbage_red.svg" alt="" class="removeRow">
                            </div>
                        </div>
                        <div class="tableRow">
                            <div class="centrize">12</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">BUlgaria
                                <img src="/static/img/garbage_red.svg" alt="" class="removeRow">
                            </div>
                        </div>
                        <div class="tableRow">
                            <div class="centrize">12</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">BUlgaria
                                <img src="/static/img/garbage_red.svg" alt="" class="removeRow">
                            </div>
                        </div>
                        <div class="tableRow">
                            <div class="centrize">12</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">BUlgaria
                                <img src="/static/img/garbage_red.svg" alt="" class="removeRow">
                            </div>
                        </div>
                        <div class="tableRow">
                            <div class="centrize">12</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">BUlgaria
                                <img src="/static/img/garbage_red.svg" alt="" class="removeRow">
                            </div>
                        </div>
                        <div class="tableRow">
                            <div class="centrize">12</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">BUlgaria
                                <img src="/static/img/garbage_red.svg" alt="" class="removeRow">
                            </div>
                        </div>
                        <div class="tableRow">
                            <div class="centrize">12</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
                            <div class="centrize">BUlgaria
                                <img src="/static/img/garbage_red.svg" alt="" class="removeRow">
                            </div>
                        </div>
                        <div class="tableRow">
                            <div class="centrize">12</div>
                            <div class="centrize">Lorem ipsum dolor sit amet.</div>
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
        name: "addagent"
    }
</script>

<style scoped>

</style>