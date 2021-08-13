<template>
    <div class="preview-pdf">
        <div :style="`margin:0 auto;width:${pdfWidth};`">
        <canvas
            v-for="page in pdfPages"
            :key="page"
            :id="'pdfCanvas' + page"
        ></canvas>
        </div>
    </div>
</template>

<script>
    const PDFJS = require("pdfjs-dist");
    PDFJS.GlobalWorkerOptions.workerSrc =
    "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.5.207/pdf.worker.js";
    export default {
        data() {
                return {
                pdfPages: [], // 頁數
                pdfWidth: "", // 寬度
                pdfSrc: "", // 網址
                pdfDoc: "", // 文件內容
                pdfScale: 1.0 // 放大倍數
                };
        },
        mounted() {
            this.getPdfUrl();
        },
        methods: {
            getPdfUrl() {
                // todo 请求后台，获取pdf的url，这里用的是线上的地址
                let path = this.$route.path;
                this.pdfSrc =
                    "https://raw.githubusercontent.com/mozilla/pdf.js/ba2edeae/web/compressed.tracemonkey-pldi-09.pdf";
                    // "http://dms" + path;
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
                    // 将 PDF 页面渲染到 canvas 上下文中
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

<style lang="scss" scoped>
    .preview-pdf {
    
        margin: 30px auto;
    
    }
</style>