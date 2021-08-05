<template>
    <div v-if="loading"> 
        <div class="loader">
            <div class="loader-inner">
                <div class="loader-line-wrap">
                    <div class="loader-line"></div>
                </div>
                <div class="loader-line-wrap">
                    <div class="loader-line"></div>
                </div>
                <div class="loader-line-wrap">
                    <div class="loader-line"></div>
                </div>
                <div class="loader-line-wrap">
                    <div class="loader-line"></div>
                </div>
                <div class="loader-line-wrap">
                    <div class="loader-line"></div>
                </div>
            </div>
        </div>
    </div>

    <div v-else class="px-4">
        <div class="row border border-white">
            <form class="m-5 w-100" enctype="multipart/form-data" @submit.prevent="submit">
                <div class="form-group">
                    <label for="name"><i class="fab fa-connectdevelop fa-1x mr-1"></i>軟體名稱：</label>
                    <input id="name" type="text" class="form-control" placeholder="請輸入" v-model="name" required="required" />
                </div>

                <div class="form-group">
                    <label for="date"><i class="fab fa-connectdevelop fa-1x mr-1"></i>軟體簽約時間：</label>
                    <date-picker id="date" v-model="date" valueType="format" range required="required" ></date-picker>
                </div>

                <div class="form-group">
                    <label for="department"><i class="fab fa-connectdevelop fa-1x mr-1"></i>歸屬部門：</label>
                    <select class="form-control" id="department" v-model="department" required="required">
                        <option value="0" disabled selected>--請選擇--</option>
                        <option v-for="(d, index) in departments" :key="index" :value="index">
                            {{ d }}
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status"><i class="fab fa-connectdevelop fa-1x mr-1"></i>狀態：</label>
                    <select class="form-control" id="status" v-model="status" required="required">
                        <option value="0" disabled selected>--請選擇--</option>
                        <option :value="s" v-for="(s, index) in statusO" :key="index">{{ s }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="maintenanceStaff"><i class="fab fa-connectdevelop fa-1x mr-1"></i>維護人員：</label>
                    <select class="form-control" id="maintenanceStaff" v-model="owner" required="required">
                        <option value="0" disabled selected>--請選擇--</option>
                        <option v-for="(owner, index) in Owners" :key="index" :value="index">{{ owner }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-primary float-right"  @click="uploadSW()">送出</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    
    import 'vue2-datepicker/index.css';

    export default {
        
        data() {
            return {
                loading: true,
                date: null,
                name: '',
                date: '',
                status: 0,
                statusO: ['有效','送簽中','洽談中'],
                owner: 0,
                Owners: [],
                department: 0,
                departments:['專案開拓一課','專案開拓二課','專案開拓三課'],
            }
        },
        methods: {

            uploadSW () {
                let formData = new FormData()
                
                formData.append('name', this.name)
                formData.append('date', this.date)
                formData.append('department', this.department)
                formData.append('status', this.status)
                formData.append('owner', this.owner)

                // let config = {
                //     headers: {
                //     'Content-Type': 'multipart/form-data'
                //     }
                // }
                axios.post('/api/AddNewSW', formData)
                .then((response) => {
                    this.$router.push('/software')
                })
                .catch((err) => {
                    console.error(err)
                    //alert ('有錯誤，請洽管理員！')
                })
            }
        },
        created() {
            var today = new Date();
            axios.get('/api/MaintenanceStaffs').then(
                response => {
                    this.Owners = response.data
                    // console.log(this.maintenanceStaffs)
                    this.loading = !this.loading
                }
            )
        },
        mounted() {
            // isValid: function () {
            //     return this.contract.name.length > 1;
            // },
            // msgStyle: function () {
            //     return {
            //         'border': this.isValid ? '': 'red solid 1px',
            //         'color': this.isValid ? '': 'red'
            //     }
            // }
        }
    }
</script>

<style lang="scss" scoped>

.form-control::-moz-placeholder {
  color: #d2d2d2;
  opacity: .8;
}

.form-control:-ms-input-placeholder {
  color: #d2d2d2;
  opacity: .8;
}

.form-control::placeholder {
  color: #d2d2d2;
  opacity: .8;
}

.btn {
  display: inline-block;
  font-weight: 400;
  color: #212529;
  text-align: center;
  vertical-align: middle;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  background-color: transparent;
  border: 1px solid transparent;
  padding: 0.375rem 0.75rem;
  font-size: 0.9rem;
  line-height: 1.6;
  border-radius: 0.25rem;
  transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.btn-primary {
  color: #fff;
  background-color: #3490dc;
  border-color: #3490dc;
}

.btn-primary:hover {
  color: #fff;
  background-color: #227dc7;
  border-color: #2176bd;
}

.btn-primary:focus,
.btn-primary.focus {
  color: #fff;
  background-color: #227dc7;
  border-color: #2176bd;
  box-shadow: 0 0 0 0.2rem rgba(82, 161, 225, 0.5);
}

.error {
  border: red solid 1px;
  color: red;
}

.loader {
    background: linear-gradient(180deg, rgba(50,50,50,0.6)0%, rgba(0,0,0,1)35%);
    bottom: 0;
    left: 0;
    overflow: hidden;
    position: fixed;
    right: 0;
    top: 0;
    z-index: 99999;
}

.loader-inner {
    bottom: 0;
    height: 60px;
    left: 0;
    margin: auto;
    position: absolute;
    right: 0;
    top: 0;
    width: 100px;
}

.loader-line-wrap {
    animation: 
		spin 3000ms cubic-bezier(.175, .885, .32, 1.275) infinite
	;
    box-sizing: border-box;
    height: 35px;
    left: 0;
    overflow: hidden;
    position: absolute;
    top: 0;
    transform-origin: 50% 100%;
    width: 70px;
}
.loader-line {
    border: 4px solid transparent;
    border-radius: 100%;
    box-sizing: border-box;
    height: 70px;
    left: 0;
    margin: 0 auto;
    position: absolute;
    right: 0;
    top: 0;
    width: 70px;
}
.loader-line-wrap:nth-child(1) { animation-delay: -50ms; }
.loader-line-wrap:nth-child(2) { animation-delay: -100ms; }
.loader-line-wrap:nth-child(3) { animation-delay: -150ms; }
.loader-line-wrap:nth-child(4) { animation-delay: -200ms; }
.loader-line-wrap:nth-child(5) { animation-delay: -250ms; }

.loader-line-wrap:nth-child(1) .loader-line {
    border-color: #063356;
    height: 60px;
    width: 60px;
    top: 7px;
}
.loader-line-wrap:nth-child(2) .loader-line {
    border-color: rgb(50, 50, 50);
    height: 50px;
    width: 50px;
    top: 14px;
}
.loader-line-wrap:nth-child(3) .loader-line {
    border-color: rgb(100, 100, 100);
    height: 40px;
    width: 40px;
    top: 21px;
}
.loader-line-wrap:nth-child(4) .loader-line {
    border-color: rgb(190, 190, 190 );
    height: 30px;
    width: 30px;
    top: 28px;
}
.loader-line-wrap:nth-child(5) .loader-line {
    border-color: rgb(245, 245, 245);
    height: 20px;
    width: 20px;
    top: 35px;
}

@keyframes spin {
    0%, 15% {
		transform: rotate(0);
	}
	100% {
		transform: rotate(360deg);
	}
}

</style>
