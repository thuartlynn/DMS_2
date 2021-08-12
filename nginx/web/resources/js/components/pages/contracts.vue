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

    <div  v-else>
        <!-- <div class="p-3 table-responsive-sm">
            <table id="contentTable" class="table table-hover table-secondary"> 
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="width:6.5rem;">編號</th>
                        <th scope="col" style="width:14rem;">名稱</th>
                        <th scope="col" style="width:14rem;">對象</th>
                        <th scope="col">開始日期</th>
                        <th scope="col">到期日期</th>
                        <th scope="col">合約狀態</th>
                        <th scope="col">更新日期</th>
                        <th scope="col">維護人員</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="contractData in contractDatas" :key="contractData.number">
                        <td>{{ contractData.number }}</td>
                        <td>{{ contractData.name }}</td>
                        <td>{{ contractData.parties }}</td>
                        <td>{{ contractData.fromDate }}</td>
                        <td>{{ contractData.toDate }}</td>
                        <td>{{ contractData.status }}</td>
                        <td>{{ contractData.updateDate }}</td>
                        <td>{{ contractData.maintenanceStaff }}</td>
                    </tr>
                </tbody>
            </table>
        </div>  -->
        

        <div class="p-3">
            <vue-good-table
            max-height="600px" :fixed-header="true"
            :search-options="{
                enabled: true,
                placeholder: '請輸入欲查詢的關鍵字',
            }"
            :pagination-options="{
                enabled: true,
                mode: 'records',
                position: 'top',
            }"
            :columns="columns" :rows="contractDatas"
            :compactMode="false"
            @on-row-click="get"
            
            >
            </vue-good-table>
            <!-- Vue 過濾器測試 -->
            <!-- <div v-for="currency in info" :style="styleObject">
                <span>{{ currency.rate_float | currencydecimal }}</span> 
            </div>       -->
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                loading: true,
                contractDatas: [],
                columns: [
                            {
                                label: '編號',
                                field: 'number',
                                type: 'number',
                                thClass: 'vgt-left-align th-number',
                                tdClass: 'vgt-left-align td-class'
                            },
                            {
                                label: '名稱',
                                field: 'name',
                                thClass: 'vgt-left-align th-name',
                                tdClass: 'td-class'
                            },
                            {
                                label: '對象',
                                field: 'parties',
                                tdClass: 'td-class'
                            },
                            {
                                label: '開始日期',
                                field: 'fromDate',
                                type: 'date',
                                dateInputFormat: 'yyyy/MM/dd',
                                dateOutputFormat: 'yyyy/MM/dd',
                                thClass: 'vgt-left-align',
                                tdClass: 'vgt-left-align td-class'
                            },
                            {
                                label: '到期日期',
                                field: 'toDate',
                                type: 'date',
                                dateInputFormat: 'yyyy/MM/dd',
                                dateOutputFormat: 'yyyy/MM/dd',
                                thClass: 'vgt-left-align',
                                tdClass: 'vgt-left-align td-class'
                            },
                            {
                                label: '合約狀態',
                                field: 'status',
                                tdClass: 'td-class'
                            },
                            {
                                label: '更新日期',
                                field: 'updateDate',
                                type: 'date',
                                dateInputFormat: 'yyyy/MM/dd',
                                dateOutputFormat: 'yyyy/MM/dd',
                                thClass: 'vgt-left-align',
                                tdClass: 'vgt-left-align td-class'
                            },
                            {
                                label: '維護人員',
                                field: 'maintenanceStaff',
                                thClass: 'vgt-left-align',
                                tdClass: 'vgt-left-align td-class'
                            },
                        ],
                // info: [
                //     { rate_float: "56.13407534343" },
                //     { rate_float: "92.1343415235" }
                // ],
                // styleObject: {
                //     color: 'red'
                // }

            }
            
        },
        // filters: {
        //         currencydecimal: function (value) {
        //             return Math.floor(value * 100)/100
        //         }
        // },
        methods: {
            get (data) {
                let Contract_ID = data.row.number;
                // console.log(Contract_ID);
                this.$router.push({ path: `/rewritefile/${Contract_ID}` }) // rewritefile+帶合約編號
            },
            
        },
        components: {
        },
        created() {
            axios.get('/api/Contractinfo').then(
                response => {
                    this.contractDatas = response.data
                    // console.log(this.contractDatas)
                })
                .finally(() => this.loading = !this.loading)
        }
    }
</script>

<style lang="scss" scoped>
    // #contentTable{
	// 	table-layout:fixed; /* bootstrap-table設定colmuns中某列的寬度無效時，需要給整個表設定css屬性 */
	// 	word-break:break-all; word-wrap:break-all; /* 自動換行 */
	// }
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