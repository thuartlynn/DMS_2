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

    <div v-else>
    <div class="p-3 border border-white">
        <form class="m-5" enctype="multipart/form-data" @submit.prevent="submit">
            <template v-for="(item,index) in contractDatas">
                <p :key="index">
                    <p>
                        <label for="name"><i class="fab fa-connectdevelop fa-1x mr-1"></i>合約名稱：</label>
                        <input id="name" type="text" class="form-control" v-model="item.name" required="required" />
                    </p>

                    <p class="mt-4">  
                        <label for="date"><i class="fab fa-connectdevelop fa-1x mr-1"></i>原始合約時間(起迄)：{{ item.fromDate }} ~ {{ item.toDate }}</label>
                        <br><i class="fas fa-angle-double-right fa-1x mr-1 ml-4"></i>需要更改，請選擇：<date-picker id="date" v-model="newItem.date" valueType="format" range required="required" ></date-picker>
                    </p>

                    <p class="mt-4">
                        <label for="parties"><i class="fab fa-connectdevelop fa-1x mr-1"></i>合約相對人：</label>
                        <input id="parties" type="text" class="form-control" v-model="item.parties" required="required" />
                    </p>

                    <p class="mt-4">
                        <label for="persons"><i class="fab fa-connectdevelop fa-1x mr-1"></i>聯絡電子信箱：</label>
                        <input id="persons" type="text" class="form-control" v-model="item.Mails" />
                    </p>

                    <p class="mt-4">
                        <label for="status"><i class="fab fa-connectdevelop fa-1x mr-1"></i>狀態：</label>
                        <select class="form-control" id="status" v-model="item.status" required="required">
                            <option value="0" disabled selected>--請選擇--</option>
                            <option v-for="(item, index) in statusO" :value="item" :key="index">{{ item }}</option>
                        </select>
                    </p>

                    <p class="mt-4">
                        <label for="status"><i class="fab fa-connectdevelop fa-1x mr-1"></i>維護人員：</label>
                        <select class="form-control" id="Owner" v-model="item.Owner_ID" required="required">
                            <option value="0" disabled selected>--請選擇--</option>
                            <option v-for="(staff, index) in maintenanceStaffs" :key="index" :value="index">
                                {{ staff }}
                            </option>
                        </select>
                    </p>

                    <p class="mt-4">
                        <label for="file"><i class="fab fa-connectdevelop fa-1x mr-1"></i>已上傳的檔案名稱：</label>
                        <ul id="inline" v-if="files.length>0">
                            <li v-for="(file, index) in files" :key="'file - ' + index">
                                <i class="fas fa-file-pdf fa-1x ml-1"></i> <a v-bind:href="file.link" target="_blank" >{{ file.filename }}/</a>
                            </li>
                        </ul>
                        <!-- <i class="fas fa-angle-double-right fa-1x mr-1 ml-4"></i><button class="btn btn-outline-secondary" type="button" @click="show">新增檔案</button> -->
                        <i class="fas fa-angle-double-right fa-1x mr-1 ml-4"></i><button class="btn btn-outline-secondary" type="button" @click="$refs.file.click()" >新增檔案</button><span class="ml-2">{{ file }}</span>

                    </p>

                    <p class="mt-4">
                        <i class="fab fa-connectdevelop fa-1x mr-1"></i>最近更新日期：{{item.updateDate}}
                    </p>

                    <p class="pb-4"><button type="button" class="btn btn-primary float-right"  @click="rewriteC()">送出</button></p>

                </p>
            </template>

            <input type="file" ref="file" class="d-none" accept=".pdf" multiple="multiple" v-on:change="handleFileUpload()">
            <!-- <p :class=" isShow ? 'show' : '' " :style="isShow ? 'display:block' : 'display:none'">
                <input id="files" type="file" ref="file" accept=".pdf" multiple="multiple" >
            </p> -->
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
                contractDatas: [],
                date: null,
                newItem: {
                    date: '',
                },
                statusO: ['有效','無效','送簽中','洽談中'],
                maintenanceStaffs: [],
                files: [
                    {
                        id: 1, 
                        filename: "第一個檔案的名稱",
                        link: "https://drive.google.com/file/d/17iIsr29YeQMxo-MYskuDXG3N0V5Wc8zk/view?usp=sharing" 
                    },
                    {
                        id: 2, 
                        filename: "第二個檔案的名稱",
                        link: "https://drive.google.com/file/d/17iIsr29YeQMxo-MYskuDXG3N0V5Wc8zk/view?usp=sharing" 
                    }
                ],
                phoneNumbers: [{ phone: "" }],
                isShow: false,
                file:''
            }
        },
        methods: {

            handleFileUpload() {  
                this.file = '已夾帶';
            },

            rewriteC () {
                
                let formData = new FormData()

                // console.log(this.$refs.file)
                for( var i = 0; i < this.$refs.file.files.length; i++ ){
                    let file = this.$refs.file.files[i];
                    if (file.size > 30000000){
                        alert ('超過30MB! 請重新選取')
                    } else {
                        formData.append('files[' + i +']', file)
                    }
                }
                    
                formData.append('Data - ', JSON.stringify(this.contractDatas))
                formData.append('Other - ', JSON.stringify(this.newItem))

                axios.put('/api/rewriteFile/'+this.$route.params.id, formData)
                .then((response) => {
                    this.$router.push('/contracts')
                })
                .catch((err) => {
                    console.error(err)
                    // alert ('有錯誤，請洽管理員！')
                })
            },
            show () {
                this.isShow = !this.isShow;
            }
            
        },
        created() {
            // Get此頁合約ID資料
            let id = this.$route.params.id
            
            axios.get('/api/MaintenanceStaffs').then(
                response => {
                    this.maintenanceStaffs = response.data
                    // console.log(this.maintenanceStaffs)
                }
            )

            axios.get('/api/getInfo/'+id).then(
                response => {
                    // this.contractDatas = response.data[0]
                    this.contractDatas = response.data
                    //console.log(this.contractDatas)
                    this.loading = !this.loading
                }
            )
            
        },
        mounted() {
            
        },
        computed: {
            objKeys() {
                return Object.keys(this.contractDatas);

            },
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

.btn-outline-secondary {
  color: #6c757d;
  border-color: #6c757d;
}

.btn-outline-secondary:hover {
  color: #fff;
  background-color: #6c757d;
  border-color: #6c757d;
}

.btn-outline-secondary:focus,
.btn-outline-secondary.focus {
  box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.5);
}

.error {
  border: red solid 1px;
  color: red;
}

#inline{
    padding-left:1.1rem;

}

#inline li{
    display:inline;
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
