webpackJsonp([1],{"9bBU":function(e,t,a){a("mClu");var r=a("FeBl").Object;e.exports=function(e,t,a){return r.defineProperty(e,t,a)}},C4MV:function(e,t,a){e.exports={default:a("9bBU"),__esModule:!0}},GrBH:function(e,t){},MG0Z:function(e,t,a){e.exports=a.p+"static/img/shouye.070dc71.png"},bOdI:function(e,t,a){"use strict";t.__esModule=!0;var r,o=a("C4MV"),s=(r=o)&&r.__esModule?r:{default:r};t.default=function(e,t,a){return t in e?(0,s.default)(e,t,{value:a,enumerable:!0,configurable:!0,writable:!0}):e[t]=a,e}},mClu:function(e,t,a){var r=a("kM2E");r(r.S+r.F*!a("+E39"),"Object",{defineProperty:a("evD5").f})},xJsL:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=a("bOdI"),o=a.n(r),s=(a("mtWM"),a("YtJ0")),i=a("iPXC"),c={name:"login",data:function(){var e=this;return{checkCode:"",checked:!1,ruleForm2:{username:"",passWorld:"",autocode:""},rules2:{username:[{required:!0,message:"请输入用户名",trigger:"blur"}],passWorld:[{required:!0,message:"请输入密码",trigger:"blur"}],autocode:[{validator:function(t,a,r){return a?a.toUpperCase()!=e.checkCode&&a!=e.checkCode?(e.createCode(),a="",r(new Error("验证码不正确"))):void r():(e.createCode(),a="",r(new Error("验证码不能为空")))},required:!0,trigger:"blur"}]}}},methods:{submitForm:function(e){var t=this;console.log(this.$store);this.$store.state.id;this.$refs[e].validate(function(e){if(e){delete t.ruleForm2.autocode;var a={username:t.ruleForm2.username,password:t.ruleForm2.passWorld};t.$postLogin("/levy/login/login",a).then(function(e){if(1!==e.data.status)t.$message({message:e.data.msg,type:"error"});else{var a;if(Object(i.b)("session",e.data.data.token,36e5),Object(i.b)("u_uuid",e.data.data.id,36e5),t.$route.query.redirect)t.$router.push(t.$route.query.redirect);else console.log(t),console.log(t.$store),t.$router.push({name:"preliminary",params:(a={isshow:!0,avatarimg:e.data.data.avatarimg,mdbile:e.data.data.mdbile},o()(a,"isshow",e.data.data.advance_status),o()(a,"recsname",e.data.data.recsname),a)})}})}})},createCode:function(){for(var e="",t=new Array(0,1,2,3,4,5,6,7,8,9,"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"),a=0;a<4;a++){e+=t[Math.floor(36*Math.random())]}this.checkCode=e},checkLpicma:function(){},routerRegister:function(){this.$router.push("/index/register")},autoLogin:function(){var e=this,t={};t.token=Object(i.a)("session"),this.$postLogin("/levy/login/index",t).then(function(t){var a;1!==t.data.status?e.$message({message:t.data.msg,type:"error"}):e.$router.push({name:"preliminary",params:(a={isshow:!0,avatarimg:t.data.data.avatarimg,mdbile:t.data.data.mdbile},o()(a,"isshow",t.data.data.advance_status),o()(a,"recsname",t.data.data.recsname),a)})})}},created:function(){this.createCode(),this.autoLogin()},watch:{checked:function(e,t){e&&Object(i.b)("autoLog",1,864e5)}},store:s.a},n={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"bgc"},[a("div",{staticClass:"logo"},[e._m(0),e._v(" "),a("div",{staticClass:"bottom"},[a("div",{staticClass:"bottomWrapper"},[a("p",[e._v("登录")]),e._v(" "),a("el-form",{ref:"ruleForm2",staticClass:"demo-ruleForm",attrs:{model:e.ruleForm2,"status-icon":"",rules:e.rules2,"label-width":"100px"}},[a("el-form-item",{staticStyle:{width:"300px"},attrs:{label:"用户名",prop:"username"}},[a("el-input",{attrs:{size:"mini","auto-complete":"off"},model:{value:e.ruleForm2.username,callback:function(t){e.$set(e.ruleForm2,"username",t)},expression:"ruleForm2.username"}}),e._v(" "),a("a",{attrs:{href:"javascript:;"},on:{click:e.routerRegister}},[e._v("还没账号？点我注册")])],1),e._v(" "),a("el-form-item",{staticStyle:{width:"300px"},attrs:{label:"密码",prop:"passWorld"}},[a("el-input",{attrs:{type:"password",size:"mini","auto-complete":"off"},model:{value:e.ruleForm2.passWorld,callback:function(t){e.$set(e.ruleForm2,"passWorld",t)},expression:"ruleForm2.passWorld"}})],1),e._v(" "),a("el-form-item",{staticStyle:{width:"230px"},attrs:{label:"验证码",prop:"autocode"}},[a("el-input",{attrs:{size:"mini"},on:{blur:e.checkLpicma},model:{value:e.ruleForm2.autocode,callback:function(t){e.$set(e.ruleForm2,"autocode",t)},expression:"ruleForm2.autocode"}}),e._v(" "),a("div",{staticClass:"security",on:{click:e.createCode}},[e._v(e._s(e.checkCode))])],1),e._v(" "),a("el-form-item",[a("button",{staticClass:"login",on:{click:function(t){t.preventDefault(),e.submitForm("ruleForm2")}}},[e._v("立即登录")])]),e._v(" "),a("el-form-item",{staticStyle:{"margin-top":"-20px"},attrs:{prop:"age"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.checked,expression:"checked"}],staticStyle:{"vertical-align":"middle"},attrs:{type:"checkbox",id:"checkbox"},domProps:{checked:Array.isArray(e.checked)?e._i(e.checked,null)>-1:e.checked},on:{change:function(t){var a=e.checked,r=t.target,o=!!r.checked;if(Array.isArray(a)){var s=e._i(a,null);r.checked?s<0&&(e.checked=a.concat([null])):s>-1&&(e.checked=a.slice(0,s).concat(a.slice(s+1)))}else e.checked=o}}}),e._v(" "),a("span",[e._v("下次自动登录")])])],1)],1)])])])},staticRenderFns:[function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"top"},[t("img",{attrs:{src:a("MG0Z"),alt:""}})])}]};var l=a("VU/8")(c,n,!1,function(e){a("GrBH")},"data-v-ad64ffc6",null);t.default=l.exports}});
//# sourceMappingURL=1.88b19ac55ff585888e1d.js.map