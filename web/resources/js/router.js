import Vue from 'vue';
import Router from 'vue-router';

// 引用頁面的 Component
import indexMain from './components/index_main';
import uploadFile from './components/pages/uploadFile';
import contracts from './components/pages/contracts';
import software from './components/pages/software';
import rewriteFile from './components/pages/rewriteFile';
import uploadSW from './components/pages/uploadSW';
import pdf from './components/pages/pdf';

Vue.use(Router)

export const routes = [
  { path: '/', component: indexMain,
    children:[
      {path: '', component: contracts},
      {path: 'uploadfile', component: uploadFile, name:'uploadFile'},
      {path: 'contracts', component: contracts, name:'contracts'},
      {path: 'software', component: software, name:'software'},
      {path: 'rewritefile/:id', component: rewriteFile},
      {path: 'uploadSW', component: uploadSW, name:'uploadSW'}
    ]
  },
  { path: '/:id/:filename', component: pdf, name:'pdf'
  }
];
  
// 建立 Vue Router instance
const router = new Router({
  mode: 'history',
  routes
});

export default router; 