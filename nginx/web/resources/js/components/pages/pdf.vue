<template>
    <div class="preview-pdf">
        <div :style="`margin:3rem auto; width:${pdfWidth};`">
            <canvas
                v-for="page in pdfPages"
                :key="page"
                :id="'pdfCanvas' + page"
            >
            </canvas>
        </div>
  </div>
</template>

<script>
    const PDFJS = require("pdfjs-dist");
    //console.log("成功：",PDFJS )
    PDFJS.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.5.207/pdf.worker.js";

    export default {
        data() {
            return {
                pdfPages: [], // 頁數
                pdfWidth: "", // 寬度
                pdfSrc: "", // 位置
                pdfDoc: "", // 文件內容
                pdfScale: 1.0 // 放大倍數
            }
        },
        mounted() {
            this.getPdfUrl();
        },
        methods: {
            getPdfUrl() {
                let x = this.$route.path
                
                // todo 请求后台，获取pdf的url，这里用的是线上的地址
                this.pdfSrc =
                    "http://storage.xuetangx.com/public_assets/xuetangx/PDF/PlayerAPI_v1.0.6.pdf";
                    // "http://dms" + x;
                
                // this.$axios.get('')
                // .then((res)=>{
                //     this.pdf_src = res.url
                //     this._loadFile(this.pdf_src)
                // })
                this.loadFile(this.pdfSrc);
            },
            loadFile(url) {
                let loadingTask = PDFJS.getDocument(url);
                loadingTask.promise.then(pdf => {
                    this.pdfDoc = pdf;
                    this.pdfPages = pdf.numPages;
                    this.$nextTick(() => { 
                    this.renderPage(1);
                    });
                });
            },
            renderPage(num) {
                const that = this;
                this.pdfDoc.getPage(num).then(page => {
                    let canvas = document.getElementById("pdfCanvas" + num);
                    let ctx = canvas.getContext("2d");
                    let dpr = window.devicePixelRatio || 1;
                    let bsr =
                    ctx.webkitBackingStorePixelRatio ||
                    ctx.mozBackingStorePixelRatio ||
                    ctx.msBackingStorePixelRatio ||
                    ctx.oBackingStorePixelRatio ||
                    ctx.backingStorePixelRatio ||
                    1;
                    let ratio = dpr / bsr;
                    let viewport = page.getViewport({ scale: this.pdfScale });
                    canvas.width = viewport.width * ratio;
                    canvas.height = viewport.height * ratio;

                    canvas.style.width = viewport.width + "px";

                    that.pdfWidth = viewport.width + "px";

                    canvas.style.height = viewport.height + "px";

                    ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
                    // 將pdf渲染到 canvas 上下置中
                    let renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                    };
                    page.render(renderContext);
                    if (this.pdfPages > num) {
                    this.renderPage(num + 1);
                    }
                });
            }
        }

    }
</script>

<style scoped="" type="text/css ">

</style>