webpackJsonp([5],{"ddO+":function(e,t){},q3Wa:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r={name:"register",data:function(){var e=this;return{checkCode:"",ruleForm:{name:"",pass:"",checkPass:"",email:"",phone:"",autocode:""},rules:{name:[{validator:function(e,t,n){""===t?n(new Error("请输入账号")):t.length<=5?n(new Error("长度需大于6位")):n()},required:!0,trigger:"blur"}],pass:[{validator:function(t,n,r){""===n?r(new Error("请输入密码")):n.length<=5?r(new Error("长度大于6位")):(""!==e.ruleForm.checkPass&&e.$refs.ruleForm.validateField("checkPass"),r())},required:!0,trigger:"blur"}],checkPass:[{validator:function(t,n,r){""===n?r(new Error("请再次输入密码")):n!==e.ruleForm.pass?r(new Error("两次输入密码不一致!")):r()},required:!0,trigger:"blur"}],email:[{type:"email",required:!0,message:"请输入正确的邮箱地址",trigger:["blur"]}],phone:[{validator:function(e,t,n){return t?/^[1][3,4,5,7,8][0-9]{9}$/.test(t)?void n():n(new Error("手机号码格式不正确")):n(new Error("手机不能为空"))},required:!0,trigger:"blur"}],autocode:[{validator:function(t,n,r){return n?n.toUpperCase()!=e.checkCode&&n!=e.checkCode?(console.log(e.checkCode),e.createCode(),n="",r(new Error("验证码不正确"))):void r():r(new Error("验证码不能为空"))},required:!0,trigger:"blur"}]},strength1:!1,strength2:!1,strength3:!1,msg:"1.\t特别提示\n\n中国数字出版网（大佳网）（以下简称大佳网）同意按照本协议的规定及其不时发布的操作规则提供基于互联网以及移动网的相关服务（以下称“网络服务”），为获得网络服务，服务使用人（以下称“用户”）应当同意本协议的全部条款并按照页面上的提示完成全部的注册程序。用户在进行注册程序过程中点击“同意”按钮即表示用户 完全接受本协议项下的全部条款。本协议下的条款可由中国数字出版网（大佳网）适时变更，协议条款一旦发生变动，大佳网将会在相关的页面上提示变更内容。变更后的服务协议一旦在页面上公布即有效代替原来的服务协议。用户在使用大佳网提供的各项服务之前，应仔细阅读本服务协议，如用户不同意本服务协议及/或随时对其的修改，用户可以主动取消大佳网提供的服务。\n\n2.\t服务内容\n\n2.1.\t大佳网服务的具体内容由大佳网根据实际情况提供，例如图书作品阅读、微博、手机图片铃声下载、电子邮件、发表新闻评论等。大佳网保留随时变更、中止或终止部分或全部网络服务的权利。\n\n2.2.\t大佳网在提供网络服务时，可能会对部分网络服务(例如VIP作品阅读)的用户收取一定的费用。在此情况下，大佳网会在相关页面上做明确的提示。如用户不同意支付该等费用，则可不接受相关的网络服务。\n\n2.3.\t用户理解，大佳网仅提供相关的网络服务，除此之外与相关网络服务有关的设备(如电脑、调制解调器及其他与接入互联网有关的装置)及所需的费用(如为接入互联网而支付的电话费及上网费)均应由用户自行负担。\n\n3.\t使用规则\n\n3.1.\t用户在申请使用大佳网网络服务时，必须向大佳网申请注册并提供准确的个人资料，如个人资料有任何变动，必须及时更新。如因资料提供不准确而享受不到相关服务时，大佳网不承担任何责任。\n\n3.2.\t用户注册成功后，大佳网将给予每个用户一个用户帐号及相应的密码，该用户帐号和密码由用户负责保管；用户应当对以其用户帐号进行的所有活动和事件负法律责任。\n\n3.3.\t用户同意接受大佳网通过电子邮件或其他方式向用户发送的商品促销或其他相关商业信息。\n\n3.4.\t用户在使用大佳网服务过程中，必须遵循以下原则：\n\n(A) 遵守中国有关的法律和法规；\n\n(B) 不得为任何非法目的而使用网络服务系统；\n\n(C) 遵守所有与网络服务有关的网络协议、规定和程序；\n\n(D) 不得利用大佳网服务系统进行任何可能对互联网的正常运转造成不利影响的行为；\n\n(E) 不得利用大佳网服务系统传输任何骚扰性的、中伤他人的、辱骂性的、恐吓性的、庸俗淫秽的或其他任何非法的信息资料；\n\n(F) 不得利用大佳网服务系统进行任何不利于大佳网的行为；\n\n(G) 就大佳网及合作商业伙伴的服务、产品、业务咨询应采取相应机构提供的沟通渠道，不得在公众场合发布有关大佳网及相关服务的负面宣传。\n\n(H) 如发现任何非法使用用户帐号或帐号出现安全漏洞的情况，应立即通告大佳网。\n\n4.\t版权\n\n4.1.\t大佳网提供的网络服务内容可能涉及：文字、软件、声音、图片、录象、图表等。所有这些内容受国家版权法律法规的保护。\n\n4.2.\t用户只有在获得大佳网或其他相关权利人的书面授权之后才能按照国家版权法律法规使用这些内容。\n\n5.\t隐私保护\n\n5.1.\t保护用户（特别是未成年人）的隐私是大佳网的一项基本原则，因此，若父母（监护人）希望未成年人（尤其是十岁以下子女）得以使用本服务，必须以父 母（监护人）名义申请注册，在接受本服务时，应以法定监护人身份加以判断本服务是否符合于未成年人。大佳网保证不对外公开或向第三方（5.2所列情况除外）提供单个用户的注册资料及用户在使用网络服务时存储在大佳网的非公开内容，但下列情况除外：\n\n(A) 事先获得用户的明确授权；\n\n(B) 根据有关的法律法规要求；\n\n(C) 按照相关政府主管部门的要求；\n\n(D) 为维护社会公众的利益；\n\n(E) 为维护大佳网的合法权益。\n\n5.2.\t大佳网可能会与第三方合作向用户提供相关的网络服务，在此情况下，如该第三方同意承担与大佳网同等的保护用户隐私的责任，则大佳网有权将用户的注册资料等提供给该第三方。\n\n5.3.\t在不透露单个用户隐私资料的前提下，大佳网有权对整个用户数据库进行分析并对用户数据库进行商业上的利用。\n\n6.\t免责声明\n\n6.1.\t大佳网不保证以下事宜：\n\n(A)本站提供的服务将绝对符合您的要求\n\n(B)本站提供的服务将绝对不受干扰、及时、安全可靠或绝对不会出错。\n\n(C)大佳网将努力保证连载作品的完整性，但如果由于作者或其它非大佳网所能控制的原因导致作品的连载不能继续时，大佳网对用户不承担任何责任。\n\n(D)因用户滥用帐户权力而对大佳网服务构成破坏、损害时，大佳网有权停止该帐号的使用权力。\n\n6.2.\t用户明确同意其使用大佳网网络服务所存在的风险将完全由其自己承担；因其使用大佳网网络服务而产生的一切后果也由其自己承担，大佳网对用户及任何第三方不承担任何责任。\n\n7.\t服务变更、中断或终止\n\n7.1.\t如因系统维护或升级的需要而需暂停网络服务，大佳网将尽可能事先进行通告。\n\n7.2.\t如发生下列任何一种情形，大佳网有权随时中止或终止向用户提供本协议项下的网络服务而无需通知用户：\n\n(A)用户提供的个人资料不真实；\n\n(B)用户违反本协议中规定的使用规则。\n\n7.3.\t除前款所述情形外，大佳网同时保留在不事先通知用户的情况下随时中止或终止部分或全部网络服务的权利，对于所有服务的中止或终止而造成的任何损失，大佳网无需对用户或任何第三方承担任何责任。\n\n8.\t违约赔偿\n\n用户同意保障和维护大佳网及其他用户的利益，如因用户违反有关法律、法规或本协议项下的任何条款而给大佳网或任何其他第三人造成损失，用户同意承担由此造成的损害赔偿责任。\n\n9.\t法律管辖\n\n9.1.\t本协议的订立、执行和解释及争议的解决均应适用中国法律。\n\n9.2.\t如双方就本协议内容或其执行发生任何争议，双方应尽量友好协商解决；协商不成时，任何一方均应向大佳网域名所有者所在地的人民法院提起诉讼。\n\n10.\t通知和送达\n\n本协议项下所有的通知均可通过重要页面公告、电子邮件或常规的信件传送等方式进行；该等通知于发送之日视为已送达收件人。\n\n11.\t其他规定\n\n11.1.\t本协议构成双方对本协议之约定事项及其他有关事宜的完整协议，除本协议规定的之外，未赋予本协议各方其他权利。\n\n11.2.\t如本协议中的任何条款无论因何种原因完全或部分无效或不具有执行力，本协议的其余条款仍应有效并且有约束力。\n\n11.3.\t本协议中的标题仅为方便而设，不具法律或契约效果。\n\n"}},methods:{submitForm:function(e){this.$refs[e].validate(function(e){if(!e)return console.log("error submit!!"),!1;alert("submit!")})},resetForm:function(e){this.$refs[e].resetFields()},createCode:function(){for(var e="",t=new Array(0,1,2,3,4,5,6,7,8,9,"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"),n=0;n<4;n++){e+=t[Math.floor(36*Math.random())]}this.checkCode=e},checkLpicma:function(){},gainSMS:function(){},showstrength:function(e){console.log(e),/^[a-zA-Z]+$/.test(e)||/^\d+$/.test(e)?(this.strength1=!0,this.strength2=!1,this.strength3=!1):/^(?!\d+$)(?![a-zA-Z]+$)[a-zA-Z\d]+$/.test(e)?(this.strength2=!0,this.strength1=!1,this.strength3=!1):/^(?!\d+$)(?![a-zA-Z]+$)(?![@#$%^&]+$)[\da-zA-Z@#$%^&]+$/.test(e)&&(this.strength3=!0,this.strength2=!1,this.strength1=!1)},register:function(e){var t=this,n={};n.username=this.ruleForm.name,n.password=this.ruleForm.pass,n.email=this.ruleForm.email,n.mobile=this.ruleForm.phone,this.$refs[e].validate(function(e){e&&t.$fetch("http://118.31.112.11/levy/login/signin",n).then(function(e){1==e.data.status?(t.$message({message:"注册成功",type:"success"}),t.$router.push("/")):t.$message({message:e.data.msg,type:"error"})})})}},created:function(){this.createCode()}},s={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"register"},[n("p",{staticClass:"message"},[e._v("填 写 注 册 信 息")]),e._v(" "),n("el-form",{ref:"ruleForm",staticClass:"demo-ruleForm",staticStyle:{width:"450px"},attrs:{model:e.ruleForm,rules:e.rules,"label-width":"100px"}},[n("el-form-item",{staticStyle:{width:"300px"},attrs:{label:"用户名称",prop:"name"}},[n("el-input",{attrs:{size:"mini"},model:{value:e.ruleForm.name,callback:function(t){e.$set(e.ruleForm,"name",t)},expression:"ruleForm.name"}})],1),e._v(" "),n("el-form-item",{staticStyle:{width:"300px"},attrs:{label:"密　　码",prop:"pass"}},[n("el-input",{attrs:{size:"mini",type:"password","auto-complete":"off"},nativeOn:{keyup:function(t){e.showstrength(e.ruleForm.pass)}},model:{value:e.ruleForm.pass,callback:function(t){e.$set(e.ruleForm,"pass",t)},expression:"ruleForm.pass"}})],1),e._v(" "),n("el-form-item",{staticStyle:{width:"300px"},attrs:{label:"密码强度"}},[n("div",{staticClass:"strength"},[n("p",{class:e.strength1?"strengthLv1":"strengthLv0"},[e._v("弱")]),e._v(" "),n("p",{class:e.strength2?"strengthLv2":"strengthLv0"},[e._v("中")]),e._v(" "),n("p",{class:e.strength3?"strengthLv3":"strengthLv0"},[e._v("强")])])]),e._v(" "),n("el-form-item",{staticStyle:{width:"300px"},attrs:{label:"确认密码",prop:"checkPass"}},[n("el-input",{attrs:{size:"mini",type:"password",placeholder:"请再次确认密码","auto-complete":"off"},model:{value:e.ruleForm.checkPass,callback:function(t){e.$set(e.ruleForm,"checkPass",t)},expression:"ruleForm.checkPass"}})],1),e._v(" "),n("el-form-item",{staticStyle:{width:"300px"},attrs:{label:"绑定邮箱",prop:"email"}},[n("el-input",{attrs:{size:"mini",placeholder:"可用于找回密码"},model:{value:e.ruleForm.email,callback:function(t){e.$set(e.ruleForm,"email",t)},expression:"ruleForm.email"}})],1),e._v(" "),n("el-form-item",{staticStyle:{width:"300px"},attrs:{label:"手机号码",prop:"phone"}},[n("el-input",{attrs:{size:"mini",placeholder:"请输入合法的手机号"},model:{value:e.ruleForm.phone,callback:function(t){e.$set(e.ruleForm,"phone",t)},expression:"ruleForm.phone"}})],1),e._v(" "),n("el-form-item",{staticStyle:{width:"300px"},attrs:{label:"验 证 码",prop:"autocode"}},[n("el-input",{attrs:{placeholder:"请输入右侧所见",size:"mini"},on:{blur:e.checkLpicma},model:{value:e.ruleForm.autocode,callback:function(t){e.$set(e.ruleForm,"autocode",t)},expression:"ruleForm.autocode"}}),e._v(" "),n("div",{staticClass:"security",on:{click:e.createCode}},[e._v(e._s(e.checkCode))])],1),e._v(" "),n("el-form-item",[n("el-button",{staticClass:"sub",on:{click:function(t){e.register("ruleForm")}}},[e._v("马 上 注 册")])],1)],1),e._v(" "),n("p",{staticStyle:{"font-size":"14px",margin:"-10px 0 10px 88px"}},[e._v("点击注册按钮视为认同下方用户协议")]),e._v(" "),n("el-input",{staticStyle:{width:"420px"},attrs:{type:"textarea",rows:3},model:{value:e.msg,callback:function(t){e.msg=t},expression:"msg"}})],1)},staticRenderFns:[]};var a=n("VU/8")(r,s,!1,function(e){n("ddO+")},"data-v-4eaf12de",null);t.default=a.exports}});
//# sourceMappingURL=5.ecaa09beadf352c3b317.js.map