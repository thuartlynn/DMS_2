    <template>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 border border-secondary p-5 mb-5">
                    <h1 class="text-center">請輸入員工編號與密碼!</h1>

                    <form class="form-group" @submit.prevent="submit">
                        <div class="m-5">
                            <label for="username">員工編號</label>
                            <input type="text" class="form-control" placeholder="員工編號，例如 T00xxxx" id="username" v-model.trim="username" :class="{ 'is-invalid': nameError }">  <!-- v-bind:class="{ 'is-invalid': usernameError }" -->
                            <div class="invalid-feedback">
                                {{ nameErrMsg }}
                            </div>
                            <!-- <div class="invalid-feedback">{{ userErrMsg }}</div> -->
                        </div>

                        <div class="m-5">
                            <label for="password">密碼</label>
                            <!-- <input type="password" class="form-control" placeholder="密碼，例如 xxxxx" id="password" v-model="user.pwd" >  v-bind:class="{ 'is-invalid': pwdError }" -->

                            <!-- <div class="invalid-feedback">{{ pwdErrMsg }}</div> -->

                            <!-- <div v-if="switchPassDisFlag">
                                <input type="text" v-model="password" autocomplete="off" class="form-control" :class="{ 'is-invalid': pwdError }">
                                <div class="invalid-feedback">
                                    {{ pwdErrMsg }}
                                </div>
                                <button class="btn btn-sm" :key="1" @click="SwitchPassDis()">
                                    <i class="fas fa-eye-slash" ></i>
                                </button>
                            </div>
                            <div v-else>
                                <input type="password" v-model="password" placeholder="密碼，例如 xxxxx" autocomplete="off" class="form-control" :class="{ 'is-invalid': pwdError }">
                                <div class="invalid-feedback">
                                    {{ pwdErrMsg }}
                                </div>
                                <button class="btn btn-sm" :key="2" @click="SwitchPassDis()">
                                    <i class="fas fa-eye" ></i>
                                </button> 
                            </div> -->
                        <!-- <v-btn type="submit" class="btn btn-primary float-right"  @click="login()">Submit</v-btn> -->
                            <input :type="this.registration_data.pwdType" v-model="password" autocomplete="off" class="form-control" :class="{ 'is-invalid': pwdError }">
                                <div class="invalid-feedback">
                                    {{ pwdErrMsg }}
                                </div>
                                <div>
                                    <img :src="this.registration_data.src" class="w-25" @click="changeType()" />
                                    <!--@click="changeType()" <button class="btn btn-sm" @click="Change()" v-show="eye"><i class="fas fa-eye fa-2x"></i></button>
                                    <button class="btn btn-sm" @click="Change()" v-show="!eye"><i class="fas fa-eye-slash fa-2x" ></i></button> -->
                                </div>
                             <button type="button" class="btn btn-primary float-right"  @click="login()">Submit</button>
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
                username: '',
                nameError: false,
                nameErrMsg: '',
                password: '',
                pwdError: false,
                pwdErrMsg: '',
                eye: true,
                eyeClose: false,
                registration_data:{
                    pwdType:"password",
                    src:require("../../../public/images/eye-solid.svg")
                }
            }
        },
        watch: {
            username: function () {
                var isText = /^[a-zA-Z0-9]+$/;
                    if (!isText.test(this.username)) {
                        this.nameError = true;
                        this.nameErrMsg = '請勿包含特殊字元';
                    }
                    else {
                        this.nameError = false;
                        this.nameErrMsg = '';
                    }
            },

            password: function() {
                if (this.password.length <= 0) {
                    this.pwdError = true;
                    this.pwdErrMsg = '請輸入';
                }
                else {
                    this.pwdError = false;
                    this.pwdErrMsg = '';
                }
            }
        },
        methods: {
            SwitchPassDis () {
                this.switchPassDisFlag=!this.switchPassDisFlag;
            },
            Change () {
                this.eye = !this.eye;
            },
            changeType(){
                this.registration_data.pwdType = this.registration_data.pwdType==='password'?'text':'password';
                this.registration_data.src=this.registration_data.src==require("../../../public/images/eye-solid.svg")?require("../../../public/images/eye-slash-solid.svg"):require("../../../public/images/eye-slash-solid.svg");
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
        },
        computed: {
            
            
        }
    }
</script>

<style lang="scss" scoped>
// .pwdError{border: 1px solid #f37474 !important;}


</style>
