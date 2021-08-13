    <template>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 border border-secondary p-5 mb-5">
                    <h1 class="text-center">請輸入員工編號與密碼!</h1>

                    <form class="form-group" @submit.prevent="submit">
                        <div class="m-5">
                            <label for="username">員工編號</label>
                            <input type="text" class="form-control" placeholder="員工編號，例如 T00xxxx" id="username" v-model.trim="user.username" >  <!-- v-bind:class="{ 'is-invalid': usernameError }" -->

                            <!-- <div class="invalid-feedback">{{ userErrMsg }}</div> -->
                        </div>

                        <div class="m-5">
                            <label for="password">密碼</label>
                            <!-- <input type="password" class="form-control" placeholder="密碼，例如 xxxxx" id="password" v-model="user.pwd" >  v-bind:class="{ 'is-invalid': pwdError }" -->

                            <!-- <div class="invalid-feedback">{{ pwdErrMsg }}</div> -->

                            <div v-if="switchPassDisFlag">
                                <input type="text" v-model="user.pwd" autocomplete="off" class="form-control" >
                                <button class="btn btn-sm" @click="SwitchPassDis()">
                                    <i class="far fa-eye-slash"></i>
                                </button>
                            </div>
                            <div v-else>
                                <input type="password" v-model="user.pwd" placeholder="密碼，例如 xxxxx" autocomplete="off" class="form-control" >
                                <button class="btn btn-sm" @click="SwitchPassDis()">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                            </div>
                        <button type="button" class="btn btn-primary float-right"  @click="login()">Submit</button>
                        <!-- <v-btn type="submit" class="btn btn-primary float-right"  @click="login()">Submit</v-btn> -->
                        </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            // console.log('This is content component.')
        },
        data () {
            return {
                user: {
                    username: '',
                    pwd: ''
                },
                switchPassDisFlag: false,
                // username: '',
                // password: '',
                // usernameError: false,
                // pwdError: false,
                // userErrMsg: '',
                // pwdErrMsg: ''
            }
        },
        watch: {
            // username: function () {
            //     var isText = /^[a-zA-Z0-9]+$/;
            //         if (!isText.test(this.username)) {
            //             this.usernameError = true;
            //             this.userErrMsg = '請勿包含特殊字元';
            //         }
            //         else {
            //             this.usernameError = false;
            //             this.userErrMsg = '';
            //         }
            // },
            // password: function () {
            //     if (this.password.length <= 0) {
            //         this.pwdError = true;
            //         this.pwdErrMsg = '請輸入';
            //     }
            //     else {
            //         this.pwdError = false;
            //         this.pwdErrMsg = '';
            //     }
            // }
        },
        methods: {
            SwitchPassDis () {
                this.switchPassDisFlag=!this.switchPassDisFlag;
            },
            login () {
                axios({ // 保留正式開發使用
                    method: 'post',
                    url: '/api/login',
                    'Content-Type': 'application/json',
                    data: this.user,
                })
                .then((result) => {
                    if (result.response.success === true) {
                        alert('OK')
                        // this.$router.push('/userinfo')
                    }
                })
                .catch((err) => {
                    if (err.response.status === 404) {
                        console.log(err.response)
                        
                        // this.$router.push({ path: `/userinfo/${id}` })
                        //this.$router.push({ name: 'userinfo', params: { id: '1' } })
                    }
                })
                .finally(() => {
                })
                }
            }
    }
</script>

<style lang="scss" scoped>
</style>
