webpackJsonp([18,11],{209:function(e,o){"use strict";Object.defineProperty(o,"__esModule",{value:!0}),o.default={data:function(){return{detail:{},is_follow:!1,is_sub:!1,is_like:!1,show_more:!1}},methods:{showMore:function(){var e=this;e.show_more=!e.show_more},toComment:function(){document.body.scrollTop=650,document.getElementsByClassName("tp-edit")[0].focus()},like:function(){var e=this;if(!sessionStorage.getItem("token"))return void e.$store.dispatch("TOGGLETIP",e.$store.state.tip.login);var o=new FormData;o.append("class_id",e.$route.query.id),o.append("token",sessionStorage.getItem("token")),fetch(e.$store.state.api_addr+"video/like",{mode:"cors",method:"post",body:o}).then(function(o){o.ok&&o.json().then(function(o){switch(o.archive.status){case 0:e.is_like=!e.is_like,e.is_like===!1?e.$set(e.detail,"like",e.detail.like-0-1):e.$set(e.detail,"like",e.detail.like-0+1);break;case 400:}})})},follow:function(){var e=this;if(!sessionStorage.getItem("token"))return void e.$store.dispatch("TOGGLETIP",e.$store.state.tip.login);var o=new FormData;o.append("class_id",e.$route.query.id),o.append("token",sessionStorage.getItem("token")),fetch(e.$store.state.api_addr+"video/follow_video",{mode:"cors",method:"post",body:o}).then(function(o){o.ok&&o.json().then(function(o){switch(o.archive.status){case 0:e.is_follow=!e.is_follow,e.is_follow===!1?e.$set(e.detail,"follow_count",e.detail.follow_count-0-1):e.$set(e.detail,"follow_count",e.detail.follow_count-0+1);break;case 400:}})})}},mounted:function(){var e=this,o=new FormData;o.append("class_id",e.$route.query.id),fetch(e.$store.state.api_addr+"video/videos_detail",{method:"post",mode:"cors",body:o}).then(function(o){o.ok&&o.json().then(function(o){e.detail=o.data,e.detail.source="//content.jwplatform.com/players/"+o.data.source+"-T351KaXB.html"})})}}},246:function(e,o,t){o=e.exports=t(5)(),o.push([e.id,'.heading1{font-size:24px}.heading2{font-size:18px}.heading3{font-size:16px}.heading4{font-size:14px}.heading5{font-size:12px}.heading6{font-size:10px}.btn-default{border:1px solid #e4e4e5;color:#464b4f;width:100px;height:32px;box-sizing:border-box}.btn-success{border:none;background:#1ab394;color:#fff;cursor:pointer;border-radius:3px}.btn-primary{border:none;background:#cdb083;color:#fff}.btn-info{border:none;background:#3c54e8;color:#fff}.btn-warning{border:none;background:#f8ac59;color:#fff}.btn-danger{border:none;background:#ed5565;color:#fff}.btn-disabled{border:none;background:#f1f5f6!important;color:#ccd5dc!important}.btn-lg{width:100px;height:44px}.btn-no{width:90px;height:36px}.btn-md{width:80px;height:32px}.btn-xs{width:60px;height:24px}.btn-default-out{width:100px;height:32px;font-size:12px;border-radius:3px;outline:none;cursor:pointer;color:#616567;background:transparent;border:1px solid #a5a7a9;transition:all .2s}.btn-default-out:hover{color:#fff;background:#1ab394}.btn-success-out{color:#1ab394;border-color:#1ab394}.btn-primary-out{color:#cdb083;border-color:#cdb083}.btn-info-out{color:#3c54e8;border-color:#3c54e8}.btn-warning-out{color:#f8ac59;border-color:#f8ac59}.btn-danger-out{color:#ed5565;border-color:#ed5565}.btn-disabled-out{color:#d2d3d4;border-color:#d2d3d4}.alert-success{border-radius:5px;background:#d7e9c5;color:#1ab394;border:2px solid #c7dcb5}.alert-primary,.alert-success{position:fixed;width:426px;height:80px;left:50%;top:150px;box-sizing:border-box;margin-left:-213px;padding:25px 120px;font-size:21px}.alert-primary{border-radius:5px;background:#d9edf7;color:#3c54e8;border:2px solid #bce8f1}.alert-warning{border-radius:5px;background:#fcf8e3;color:#f8ac59;border:2px solid #faebcc}.alert-danger,.alert-warning{position:fixed;width:426px;height:80px;left:50%;top:150px;box-sizing:border-box;margin-left:-213px;padding:25px 120px;font-size:21px}.alert-danger{border-radius:5px;background:#f2dede;color:#ed5565;border:2px solid #ebccd1}.para{display:inline-block;position:relative;padding:0 10px;height:24px;line-height:24px;margin-left:8px;color:#fff;background-color:#1ab394}.para:after{right:-8px;border-color:#1ab394 transparent transparent #1ab394}.para:after,.para:before{content:"";display:block;width:0;height:0;position:absolute;border-style:solid;border-width:12px 4px;top:0}.para:before{left:-8px;border-color:transparent #1ab394 #1ab394 transparent}.badge{padding:5px 8px;border-radius:5px;color:#111;background:#ccd5dc;display:inline-block}.badge-success{padding:5px 15px;background:#1ab394}.badge-primary,.badge-success{border-radius:5px;color:#fff;display:inline-block}.badge-primary{padding:5px 8px;background:#cdb083}.badge-warning{padding:10px 15px;border-radius:5px;color:#fff;background:#f8ac59;display:inline-block}.badge-danger{background:#ed5565}.badge-danger,.badge-info{padding:5px 8px;border-radius:5px;color:#fff;display:inline-block}.badge-info{background:#3c54e8}.checkbox{-webkit-appearance:none;-moz-appearance:none;appearance:none;width:22px;height:22px;border:1px solid #a5a7a9;border-radius:3px;background:#fff;outline:none;margin:0;cursor:pointer;box-sizing:border-box}.checkbox:checked{background-image:url('+t(2)+");background-position:50%;background-repeat:no-repeat;background-size:110% 110%;border-color:#cdb083;color:#cdb083}.radio{-webkit-appearance:none;-moz-appearance:none;appearance:none;width:22px;height:22px;border:1px solid #a5a7a9;border-radius:50%;background:#fff;outline:none;margin:0;cursor:pointer}.radio:checked{background-image:url("+t(3)+");background-position:50%;background-repeat:no-repeat;background-color:#cdb083;background-size:100%;border-color:#cdb083;color:#fff}.tooltips-top{position:absolute;background-color:#111;font-size:14px;color:#fff;text-align:center;width:426px;height:60px;margin-left:-213px;left:50%;top:-15px;padding:15px 0;border-radius:10px}.tooltips-top .tooltips-top-arrow{display:block;border-left:15px solid transparent;border-right:15px solid transparent;border-top:15px solid #111;width:0;height:0;position:absolute;left:50%;bottom:-15px;margin-left:-12.5px}.tooltips-bottom{position:absolute;background-color:#111;font-size:14px;color:#fff;text-align:center;width:426px;height:60px;margin-left:-213px;left:50%;top:-15px;padding:15px 0;border-radius:10px}.tooltips-bottom .tooltips-bottom-arrow{display:block;border-left:15px solid transparent;border-right:15px solid transparent;border-bottom:15px solid #111;width:0;height:0;position:absolute;left:50%;top:-15px;margin-left:-12.5px}.tvi-container{width:100%;overflow:hidden}.tvi-container .tvi-player{width:100%;height:467px;background-color:#88909f}.tvi-container .tvi-options{width:100%;overflow:hidden;padding-top:20px}.tvi-container .tvi-options .tvi-header{width:100%;overflow:hidden}.tvi-container .tvi-options .tvi-header .tvi-header-box{width:70%;padding-bottom:7px;float:left;margin:0;letter-spacing:0}.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-comments,.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-like,.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-star,.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-views{padding-right:15px;float:left;font-size:15px}.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-comments>span,.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-like>span,.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-star>span,.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-views>span{line-height:16px}.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-views{color:#a5a7a9;font-size:15px}.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-views .tvi-header-views-icon{width:18px;height:18px;margin-right:4px;float:left;vertical-align:text-top;background-image:url("+t(186)+");background-position:50%;background-size:100%;background-repeat:no-repeat}.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-comments{color:#a5a7a9;cursor:pointer}.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-comments .tvi-header-comment-icon{width:18px;height:18px;vertical-align:text-top;display:inline-block;background-image:url("+t(184)+");background-position:50%;background-size:100%;background-repeat:no-repeat}.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-comments:hover{color:#ccc}.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-like{color:#a5a7a9;cursor:pointer}.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-like .tvi-header-like-icon{width:18px;height:18px;vertical-align:text-top;display:inline-block;background-image:url("+t(185)+");background-position:50%;background-size:100%;background-repeat:no-repeat}.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-like .liked{color:#ed5565}.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-star{color:#a5a7a9;cursor:pointer}.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-star .tvi-header-star-icon{width:18px;height:18px;vertical-align:text-top;display:inline-block;background-image:url("+t(333)+");background-position:50%;background-size:100%;background-repeat:no-repeat}.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-star .liked{color:#ed5565}.tvi-container .tvi-options .tvi-header .tvi-header-sub{width:30%;float:right;line-height:58px}.tvi-container .tvi-options .tvi-header .tvi-header-sub .tvi-header-author{color:#111;font-size:16px;float:right;padding:0 10px}.tvi-container .tvi-options .tvi-header .tvi-header-sub .tvi-header-sub-btn{font-size:13px;color:#88909f;border-radius:2px;float:right;text-decoration:none}.tvi-container .tvi-options .tvi-header .tvi-header-sub .tvi-header-sub-btn .tvi-header-sub-name{background-color:#f25b42;color:#fff;text-align:center;padding:6px 10px;border-radius:3px;cursor:pointer}.tvi-container .tvi-options .tvi-header .tvi-header-sub .tvi-header-sub-btn .subscribed{background-color:#999}.tvi-container .tvi-options .tvi-header .tvi-header-sub .tvi-header-sub-btn .tvi-header-sub-count{text-align:center;padding:5px 10px;border:1px solid #ccc;border-left:none;border-top-right-radius:3px;border-bottom-right-radius:3px;color:#111}.tvi-container .tvi-options .tvi-info{float:left;width:100%;overflow:hidden}.tvi-container .tvi-options .tvi-info .tvi-info-title{padding-top:5px;width:100%;color:#111;font-size:20px;margin:0;line-height:2rem}.tvi-container .tvi-options .tvi-info .tvi-info-text{width:100%;color:#88909f;font-size:13px;line-height:1.5;margin:0;padding:10px 0;max-height:30px;overflow:hidden}.tvi-container .tvi-options .tvi-info .tvi-info-text .tvi-info-more{display:block;color:#ed5565;text-align:center;font-size:16px;position:relative;text-decoration:none;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.tvi-container .tvi-options .tvi-info .tvi-info-text .tvi-info-more:hover{color:#169e83;border-color:#169e83}.tvi-container .tvi-options .tvi-info .show-all{max-height:500px}","",{version:3,sources:["/./src/components/tv_video.vue"],names:[],mappings:"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",file:"tv_video.vue",sourcesContent:["\n.heading1{font-size:24px\n}\n.heading2{font-size:18px\n}\n.heading3{font-size:16px\n}\n.heading4{font-size:14px\n}\n.heading5{font-size:12px\n}\n.heading6{font-size:10px\n}\n.btn-default{border:1px solid #e4e4e5;color:#464b4f;width:100px;height:32px;box-sizing:border-box\n}\n.btn-success{border:none;background:#1ab394;color:#fff;cursor:pointer;border-radius:3px\n}\n.btn-primary{border:none;background:#cdb083;color:#fff\n}\n.btn-info{border:none;background:#3c54e8;color:#fff\n}\n.btn-warning{border:none;background:#f8ac59;color:#fff\n}\n.btn-danger{border:none;background:#ed5565;color:#fff\n}\n.btn-disabled{border:none;background:#f1f5f6 !important;color:#ccd5dc !important\n}\n.btn-lg{width:100px;height:44px\n}\n.btn-no{width:90px;height:36px\n}\n.btn-md{width:80px;height:32px\n}\n.btn-xs{width:60px;height:24px\n}\n.btn-default-out{width:100px;height:32px;font-size:12px;border-radius:3px;outline:none;cursor:pointer;color:#616567;background:transparent;border:1px solid #a5a7a9;transition:all .2s\n}\n.btn-default-out:hover{color:#fff;background:#1ab394\n}\n.btn-success-out{color:#1ab394;border-color:#1ab394\n}\n.btn-primary-out{color:#cdb083;border-color:#cdb083\n}\n.btn-info-out{color:#3c54e8;border-color:#3c54e8\n}\n.btn-warning-out{color:#f8ac59;border-color:#f8ac59\n}\n.btn-danger-out{color:#ed5565;border-color:#ed5565\n}\n.btn-disabled-out{color:#d2d3d4;border-color:#d2d3d4\n}\n.alert-success{position:fixed;width:426px;height:80px;left:50%;top:150px;box-sizing:border-box;margin-left:-213px;border-radius:5px;padding:25px 120px;font-size:21px;background:#d7e9c5;color:#1ab394;border:2px solid #c7dcb5\n}\n.alert-primary{position:fixed;width:426px;height:80px;left:50%;top:150px;box-sizing:border-box;margin-left:-213px;border-radius:5px;padding:25px 120px;font-size:21px;background:#d9edf7;color:#3c54e8;border:2px solid #bce8f1\n}\n.alert-warning{position:fixed;width:426px;height:80px;left:50%;top:150px;box-sizing:border-box;margin-left:-213px;border-radius:5px;padding:25px 120px;font-size:21px;background:#fcf8e3;color:#f8ac59;border:2px solid #faebcc\n}\n.alert-danger{position:fixed;width:426px;height:80px;left:50%;top:150px;box-sizing:border-box;margin-left:-213px;border-radius:5px;padding:25px 120px;font-size:21px;background:#f2dede;color:#ed5565;border:2px solid #ebccd1\n}\n.para{display:inline-block;position:relative;padding:0 10px;height:24px;line-height:24px;margin-left:8px;color:#fff;background-color:#1ab394\n}\n.para:after{content:'';display:block;width:0;height:0;position:absolute;border-style:solid;border-width:12px 4px;top:0;right:-8px;border-color:#1ab394 transparent transparent #1ab394\n}\n.para:before{content:'';display:block;width:0;height:0;position:absolute;border-style:solid;border-width:12px 4px;top:0;left:-8px;border-color:transparent #1ab394 #1ab394 transparent\n}\n.badge{padding:5px 8px;border-radius:5px;color:#111;background:#ccd5dc;display:inline-block\n}\n.badge-success{padding:5px 15px;border-radius:5px;color:#fff;background:#1ab394;display:inline-block\n}\n.badge-primary{padding:5px 8px;border-radius:5px;color:#fff;background:#cdb083;display:inline-block\n}\n.badge-warning{padding:10px 15px;border-radius:5px;color:#fff;background:#f8ac59;display:inline-block\n}\n.badge-danger{padding:5px 8px;border-radius:5px;color:#fff;background:#ed5565;display:inline-block\n}\n.badge-info{padding:5px 8px;border-radius:5px;color:#fff;background:#3c54e8;display:inline-block\n}\n.checkbox{-webkit-appearance:none;-moz-appearance:none;appearance:none;width:22px;height:22px;border:1px solid #a5a7a9;border-radius:3px;background:#fff;outline:none;margin:0;cursor:pointer;box-sizing:border-box\n}\n.checkbox:checked{background-image:url(../assets/images/checkbox.png);background-position:center center;background-repeat:no-repeat;background-size:110% 110%;border-color:#cdb083;color:#cdb083\n}\n.radio{-webkit-appearance:none;-moz-appearance:none;appearance:none;width:22px;height:22px;border:1px solid #a5a7a9;border-radius:50%;background:#fff;outline:none;margin:0;cursor:pointer\n}\n.radio:checked{background-image:url(../assets/svg/checkbox.svg);background-position:center center;background-repeat:no-repeat;background-color:#cdb083;background-size:100%;border-color:#cdb083;color:#fff\n}\n.tooltips-top{position:absolute;background-color:#111;font-size:14px;color:#fff;text-align:center;width:426px;height:60px;margin-left:-213px;left:50%;top:-15px;padding:15px 0;border-radius:10px\n}\n.tooltips-top .tooltips-top-arrow{display:block;border-left:15px solid transparent;border-right:15px solid transparent;border-top:15px solid #111;width:0;height:0;position:absolute;left:50%;bottom:-15px;margin-left:-12.5px\n}\n.tooltips-bottom{position:absolute;background-color:#111;font-size:14px;color:#fff;text-align:center;width:426px;height:60px;margin-left:-213px;left:50%;top:-15px;padding:15px 0;border-radius:10px\n}\n.tooltips-bottom .tooltips-bottom-arrow{display:block;border-left:15px solid transparent;border-right:15px solid transparent;border-bottom:15px solid #111;width:0;height:0;position:absolute;left:50%;top:-15px;margin-left:-12.5px\n}\n.tvi-container{width:100%;overflow:hidden\n}\n.tvi-container .tvi-player{width:100%;height:467px;background-color:#88909f\n}\n.tvi-container .tvi-options{width:100%;overflow:hidden;padding-top:20px\n}\n.tvi-container .tvi-options .tvi-header{width:100%;overflow:hidden\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-box{width:70%;padding-bottom:7px;float:left;margin:0;letter-spacing:0\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-views,.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-like,.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-comments,.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-star{padding-right:15px;float:left;font-size:15px\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-views>span,.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-like>span,.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-comments>span,.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-star>span{line-height:16px\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-views{color:#a5a7a9;font-size:15px\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-views .tvi-header-views-icon{width:18px;height:18px;margin-right:4px;float:left;vertical-align:text-top;background-image:url(../assets/svg/play.svg);background-position:center center;background-size:100%;background-repeat:no-repeat\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-comments{color:#a5a7a9;cursor:pointer\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-comments .tvi-header-comment-icon{width:18px;height:18px;vertical-align:text-top;display:inline-block;background-image:url(../assets/svg/comment.svg);background-position:center center;background-size:100%;background-repeat:no-repeat\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-comments:hover{color:#ccc\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-like{color:#a5a7a9;cursor:pointer\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-like .tvi-header-like-icon{width:18px;height:18px;vertical-align:text-top;display:inline-block;background-image:url(../assets/svg/like.svg);background-position:center center;background-size:100%;background-repeat:no-repeat\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-like .liked{color:#ed5565\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-star{color:#a5a7a9;cursor:pointer\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-star .tvi-header-star-icon{width:18px;height:18px;vertical-align:text-top;display:inline-block;background-image:url(../assets/svg/star.svg);background-position:center center;background-size:100%;background-repeat:no-repeat\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-box .tvi-header-star .liked{color:#ed5565\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-sub{width:30%;float:right;line-height:58px\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-sub .tvi-header-author{color:#111;font-size:16px;float:right;padding:0 10px\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-sub .tvi-header-sub-btn{font-size:13px;color:#88909f;border-radius:2px;float:right;text-decoration:none\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-sub .tvi-header-sub-btn .tvi-header-sub-name{background-color:#f25b42;color:#fff;text-align:center;padding:6px 10px;border-radius:3px;cursor:pointer\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-sub .tvi-header-sub-btn .subscribed{background-color:#999\n}\n.tvi-container .tvi-options .tvi-header .tvi-header-sub .tvi-header-sub-btn .tvi-header-sub-count{text-align:center;padding:5px 10px;border:1px solid #ccc;border-left:none;border-top-right-radius:3px;border-bottom-right-radius:3px;color:#111\n}\n.tvi-container .tvi-options .tvi-info{float:left;width:100%;overflow:hidden\n}\n.tvi-container .tvi-options .tvi-info .tvi-info-title{padding-top:5px;width:100%;color:#111;font-size:20px;margin:0;line-height:2rem\n}\n.tvi-container .tvi-options .tvi-info .tvi-info-text{width:100%;color:#88909f;font-size:13px;line-height:1.5;margin:0;padding:10px 0;max-height:30px;overflow:hidden\n}\n.tvi-container .tvi-options .tvi-info .tvi-info-text .tvi-info-more{display:block;color:#ed5565;text-align:center;font-size:16px;position:relative;text-decoration:none;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none\n}\n.tvi-container .tvi-options .tvi-info .tvi-info-text .tvi-info-more:hover{color:#169e83;border-color:#169e83\n}\n.tvi-container .tvi-options .tvi-info .show-all{max-height:500px\n}\n"],sourceRoot:"webpack://"}])},266:function(e,o,t){var i=t(246);"string"==typeof i&&(i=[[e.id,i,""]]);t(6)(i,{});i.locals&&(e.exports=i.locals)},333:function(e,o){e.exports="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBzdGFuZGFsb25lPSJubyI/PjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+PHN2ZyB0PSIxNDg0NjM1MjEzMTk2IiBjbGFzcz0iaWNvbiIgc3R5bGU9IiIgdmlld0JveD0iMCAwIDEwMjQgMTAyNCIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHAtaWQ9IjE5OTYiIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMzIiIGhlaWdodD0iMzIiPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PC9zdHlsZT48L2RlZnM+PHBhdGggZD0iTTUxMy4xMzY2NCA1Mi4zMzY2NCA2NjAuNjY0MzIgMzUxLjI1MjQ4IDk5MC41MzIyNjcgMzk5LjE4NTkyIDc1MS44MzQ0NTMgNjMxLjg1MjM3MyA4MDguMTg1MTczIDk2MC4zOTI1MzMgNTEzLjEzNjY0IDgwNS4yODA0MjcgMjE4LjA5NDkzMyA5NjAuMzkyNTMzIDI3NC40Mzg4MjcgNjMxLjg1MjM3MyAzNS43NDQ0MjcgMzk5LjE4MjUwNyAzNjUuNjEyMzczIDM1MS4yNTI0OFoiIHAtaWQ9IjE5OTciIGZpbGw9IiNkM2Q3ZDgiPjwvcGF0aD48L3N2Zz4="},352:function(e,o,t){t(266);var i=t(4)(t(209),t(353),null,null);e.exports=i.exports},353:function(e,o){e.exports={render:function(){var e=this,o=e.$createElement,t=e._self._c||o;return t("div",{staticClass:"tvi-container"},[t("div",{staticClass:"tvi-player"},[t("iframe",{attrs:{src:e.detail.source,height:"100%",width:"100%",frameborder:"0",scrolling:"auto",allowfullscreen:""}})],1),e._v(" "),t("div",{staticClass:"tvi-options"},[t("div",{staticClass:"tvi-header"},[t("p",{staticClass:"tvi-header-box"},[t("span",{staticClass:"tvi-header-views"},[t("i",{staticClass:"tvi-header-views-icon"}),e._v(" "),t("span",[e._v(e._s(e.detail.views))])]),e._v(" "),t("span",{staticClass:"tvi-header-comments",on:{click:e.toComment}},[t("i",{staticClass:"tvi-header-comment-icon"}),e._v(" "),t("span",[e._v(e._s(e.detail.message_count))])]),e._v(" "),t("span",{staticClass:"tvi-header-like",on:{click:e.like}},[t("i",{staticClass:"tvi-header-like-icon",class:{liked:e.is_like}}),e._v(" "),t("span",[e._v(e._s(e.detail.like))])]),e._v(" "),t("span",{staticClass:"tvi-header-star",class:{subscribed:e.is_follow},on:{click:e.follow}},[t("i",{staticClass:"tvi-header-star-icon",class:{subed:e.is_sub}}),e._v(" "),t("span",[e._v(e._s(e.detail.follow_count))])])])]),e._v(" "),t("div",{staticClass:"tvi-info"},[t("p",{staticClass:"tvi-info-title"},[e._v("\n\t\t\t\t"+e._s(e.detail.name)+"\n\t\t\t")]),e._v(" "),t("p",{staticClass:"tvi-info-text",class:{"show-all":e.show_more}},[e._v("\n\t\t\t\t"+e._s(e.detail.describe)+"\n\t\t\t\t"),e.show_more?t("span",{staticClass:"tvi-info-more",on:{click:e.showMore}},[e._v("show less")]):t("span",{staticClass:"tvi-info-more",on:{click:e.showMore}},[e._v("show more")])])])])])},staticRenderFns:[]}}});
//# sourceMappingURL=18.61e255a1535226a9380b.js.map