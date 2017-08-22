// 项目请求根地址-----------------------------------------------------------------------------------------------
window.alpha_host='http://120.25.211.159/ww_edu/';

// common ajax request------------------------------------------------------------------------------------------
function request_Url(type, url, data, fn) {
    // 每次请求都会带上token信息
    data.token = '';
    try {
        data.token = sessionStorage.getItem("alpha_token") || '';
    }catch (e){
        console.log(e)
    }
    return $.ajax({
        type    : type || 'post',
        url     : alpha_host + url,
        data    : data,
        success : function(res){
            if(res.archive && res.archive.status == 400){
                window.location.href='../login/Login.html';
            }else {
                fn && fn(res);
            }
        },
        error   : function(err) {
            console.log(err);
        }
    });
};

function getUserInfo(fn){
    this.request_Url('post','user/userLayoutInfo',{},function(data){
        fn && fn(data.data);
    });
};

// choose Date  start--------------------------------------------------------------------------------------------
SYT="-2017-";
SMT="-08-";
SDT="-07-";
BYN=50;//年份范围往前50年
AYN=5;//年份范围往后0年
function YMDselect(){
    this.SelY = document.getElementsByName(arguments[0])[0];
    this.SelM = document.getElementsByName(arguments[1])[0];
    this.SelD = document.getElementsByName(arguments[2])[0];
    this.DefY = this.SelD?arguments[3]:arguments[2];
    this.DefM = this.SelD?arguments[4]:arguments[3];
    this.DefD = this.SelD?arguments[5]:arguments[4];
    this.SelY.YMD = this;
    this.SelM.YMD = this;
    YMDselect.SetY(this)
    this.SelY.onchange = function(){YMDselect.SetM(this.YMD)};
    if(this.SelD)this.SelM.onchange = function(){YMDselect.SetD(this.YMD)};

};
//设置年份
YMDselect.SetY = function(YMD){
    dDate = new Date();
    dCurYear = dDate.getFullYear();
    YMD.SelY.options.add(new Option(SYT,'0'));
    for(i = dCurYear+AYN; i>(dCurYear-BYN); i--){
        YMDYT = i;
        YMDYV = i;
        OptY = new Option(YMDYT,YMDYV);
        YMD.SelY.options.add(OptY);
        if(YMD.DefY == YMDYV) OptY.selected=true
    }
    YMDselect.SetM(YMD)
};
//设置月份
YMDselect.SetM = function(YMD){
    YMD.SelM.length = 0;
    YMD.SelM.options.add(new Option(SMT,'0'));
    if(YMD.SelY.value>0){
        for(var i = 1;i<=12;i++){
            YMDMT = i;
            YMDMV = i;
            OptM = new Option(YMDMT,YMDMV);
            YMD.SelM.options.add(OptM);
            if(YMD.DefM == YMDMV) OptM.selected=true
        }
    }
    if(YMD.SelD)YMDselect.SetD(YMD)
};
//设置日期
YMDselect.SetD = function(YMD){
    YI = YMD.SelY.value;
    MI = YMD.SelM.value;
    YMD.SelD.length = 0;
    YMD.SelD.options.add(new Option(SDT,'0'));
    if(YI>0 && MI>0){
        dPrevDate = new Date(YI, MI, 0);
        daysInMonth = dPrevDate.getDate();
        for (d = 1; d <= parseInt(daysInMonth); d++) {
            YMDDT = d;
            YMDDV = d;
            OptD = new Option(YMDDT,YMDDV);
            YMD.SelD.options.add(OptD);
            if(YMD.DefD == YMDDV)OptD.selected=true
        }
    }
}
// choose date end-------------------------------------------------------------------------------------------------------------



// addPeople---------------------------------------------------------------------------------------------------------------------
function addPeople(pram){
    var index = $(pram).find('.people-list li').length + 1;
    var pramName = pram.split('#')[1];
    var line = 
    '<li class="p-t-20">' +
        '<div class="p-b-15">' +
            '<label for="" class="font14 text-c2 m-r-20"> Member '+ index +' </label>' +
            '<div class="font14 text-c2 inlineblock icon-delete"></div>' +
        '</div>' +
        '<div>'+
            '<input type="text" name="studentName" placeholder="Name" class="personInput bd1 form-control inlineblock m-r-40">'+
            '<div class="radio radio-success inlineblock">'+
                '<input type="radio" name="'+pramName +'_sex0'+ index +'" id="'+pramName +'_male0'+ index +'" value="0">'+
                '<label class="radio-inline text-c2" for="'+pramName +'_male0'+ index +'">Male</label>'+
                '<input type="radio" name="'+pramName +'_sex0'+ index +'" id="'+pramName +'_female0'+ index +'" value="1">'+
                '<label class="radio-inline text-c2" for="'+pramName +'_female0'+ index +'">Female</label>'+
            '</div>'+
       '</div>'+
    '</li>';
    $(pram).find('.people-list').append(line);

    $(pram).find('.total').html( "€ 99.00 * "+ $(pram).find('.people-list li').length +" = € "+ 99 * $(pram).find('.people-list li').length +"");
}


// deletePeople-------------------------------------------------------------------------------------------------------------------------------
function deletePeople(pram){
    $(pram).find('.people-list').on('click','.icon-delete',function(){
        if(($('.people-list li').length-1) != 1){
            $(this).parent().parent().remove();
        }
        // 重写member数
        $.each($(pram).find('.people-list li'),function(index, item){
            $(item).find('label').eq(0).html('Member ' + (index + 1));
        });
        $('.total').html( "€ 99.00 * "+ $(pram).find('.people-list li').length +" = € "+ 99 * $(pram).find('.people-list li').length +"");
    });
}


// 滚动执行动画-------------------------------------------------------------------------------------------------------------------------------------------
$(function() {
    var $window           = $(window),
        win_height_padded = $window.height();

    $window.on('scroll', revealOnScroll);

    function revealOnScroll() {
        var scrolled = $window.scrollTop(),
            win_height_padded = $window.height();

        // Showed...
        $(".revealOnScroll:not(.animated)").each(function () {
            var $this     = $(this),
                offsetTop = $this.offset().top;

            if (scrolled + win_height_padded > offsetTop) {
                if ($this.data('timeout')) {
                    window.setTimeout(function(){
                        $this.addClass('animated ' + $this.data('animation'));
                    }, parseInt($this.data('timeout'),100));
                } else {
                    $this.addClass('animated ' + $this.data('animation'));
                }
            }
        });
        // Hidden...
       $(".revealOnScroll.animated").each(function (index) {
            var $this     = $(this),
                offsetTop = $this.offset().top;
            if (scrolled + win_height_padded < offsetTop) {
                $(this).removeClass('animated  flipInX flipInY fadeIn fadeInRight fadeInLeft fadeInUp fadeInDown  flash lightSpeedIn')
            }
        });
    }

    revealOnScroll();
});


// buy cart--------------------------------------------------------------------------------------------------------------------
function buyCartAlert() {
    var alert = document.createElement('div');
    var html = '<div class="cartAlert">'+
                        '<div class="animated fadeInDown alertBox"> '+
                            '<img src="assets/img/Alert_planlist.svg" alt="" class="m-t-40 m-b-30">'+
                            '<p class="font18 text-c1">Add To Plan List Successfull!</p>'+
                            '<div class="more">View More</div>'+
                            '<a href="../user-center/Order.html" class="go">Go To Plan List</a>'+
                        '</div>'+
                    '</div>';
    alert.innerHTML = html;
    $(alert).attr({id: 'alertBox'});
    $('.header').before(alert);
    this.closeBuyCartAlert();
    return this;
}
function closeBuyCartAlert(){
    $('.more').on('click',function(){
        $('#alertBox').addClass('animated fadeOut');
        setTimeout(function () {
             $('#alertBox').remove();
        },500);
    });
}


// 点击图片放大查看-------------------------------------------------------------------------------------------------------------
var viewer = new Viewer(document.getElementById('photos'), {
    url: 'data-original'
});

