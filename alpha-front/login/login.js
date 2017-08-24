/**
 * Created by alpharghrtbrtgt on 2017/6/16.
 */
$(function () {
    var emailReg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var pwdReg = /^[A-Za-z0-9]{4,20}$/;
    var accountReg = /^(?![0-9]+$)[A-Za-z0-9]{4,20}$/;
    var NameReg = /^[A-Za-z]{2,30}$/;
    var timer;

    // Login
    $('#btn-login').click(function (e) {
        var event = e || window.event;
        event.stopPropagation();
        sessionStorage.setItem('alpha_token', '');
        var account = $('#tab_login [name="account/email"]').val();
        var pwd = $('#tab_login [name="pwd"]').val();
        var data = {
            account: account,
            password: pwd
        };
        $('#tab_login .text-danger').html('');
        if (account && pwd && (accountReg.test(account) || emailReg.test(account)) && pwdReg.test(pwd)) {
            $.alpha.request_Url('POST', 'user/login', data, function (res) {
                if (res.archive.status == 0) {
                    sessionStorage.setItem('alpha_token', res.data.token);
                    window.location.href = '../alpha-index/index.html';
                } else if (res.archive.status == 101) {
                    // 弹出框提示用户名或密码错误
                    $('#tab_login .text-danger').html('Wrong Account or Password !');
                } else {
                    // 登录失败提示
                    $.alpha.alertBox('Fail', 'Login Failed!', 'javascript:(0);');
                }
            });
        } else {
            // 提示表单验证
            if (!account) {
                $.alpha.props($('#tab_login [name="account/email"]'), 'top', 'Can\'t Empty!');
            }
            if (!pwd) {
                $.alpha.props($('#tab_login [name="pwd"]'), 'bottom', 'Can\'t Empty!');
            }
        }
    });
    
    $('#tab_login [name="account/email"]').change(function () {
        $('#tab_login .text-danger').html('');
        if (accountReg.test($(this).val()) || emailReg.test($(this).val())) {
            $.alpha.props($(this), 'none');
        } else {
            $.alpha.props($(this), 'top', 'Invalid Account!');
        }
    });
    $('#tab_login [name="pwd"]').change(function () {
        $('#tab_login .text-danger').html('');
        if (pwdReg.test($(this).val())) {
            $.alpha.props($(this), 'none');
        } else {
            $.alpha.props($(this), 'bottom', 'Invalid Password!');
        }
    }).keyup(function(e){
        var event = e || window.event;
        if (event.keyCode == 13){
            $('#btn-login').trigger('click');
        }
    });
    


    // Register
    var isEmailCode = false;
    $('#btn-register').click(function (e) {
        var event = e || window.event;
        event.stopPropagation();
        sessionStorage.setItem('alpha_token', '');
        var account = $('#tab_register [name="account"]').val().trim(),
            pwd = $('#tab_register [name="pwd"]').val().trim(),
            pwdAgain = $('#tab_register [name="pwd"]').val().trim(),
            invite_code = $('#tab_register [name="inviteCode"]').val().trim();
            firstName = $('#tab_register [name="firstName"]').val().trim(),
            lastName = $('#tab_register [name="lastName"]').val().trim(),
            birth = $('#tab_register [name="birth"]').val().trim(),
            sex = $('#tab_register [name="sex"]').val().trim(),
            email = $('#tab_register [name="email"]').val().trim(),
            emailCode = $('#tab_register [name="emailCode"]').val().trim(),
            mt4Account = $('#tab_register [name="mt4Account"]').val().trim(),
            mt4Group = $('#tab_register [name="mt4Group"]').val().trim(),
            mt4Server = $('#tab_register [name="mt4Server"]').val().trim();

        var data = {
            first_name: firstName,
            last_name: lastName,
            email: email,
            password: pwd,
            invite_code: invite_code,
            birthdate: birth,
            sex:sex,
            code:emailCode,
            username:account
        };
        
        if (email && pwd && emailReg.test(email) && pwdReg.test(pwd) && isEmailCode && sex.length && invite_code) {
            $.alpha.request_Url('POST', 'user/register', data, function (res) {
                if (res.archive.status == 0) {
                    sessionStorage.setItem('alpha_token', res.data.token);
                    window.location.href = '../alpha-index/index.html';
                } else if (res.archive.status == 102) {
                    // 提示邮箱已存在
                    $.alpha.notification('warning', 'The email is exists!');
                } else {
                    // 提示注册失败
                    $.alpha.alertBox('Fail', 'Register Failed!', '#');
                }
            });
        }
    });

    // 选择日期
    $('.birthDate').datepicker({
            language: "zh-CN",
            autoclose: true,//选中之后自动隐藏日期选择框
            clearBtn: true,//清除按钮
            todayBtn: true,//今日按钮
            format: "yyyy-mm-dd"
    });
    
    $('#tab_register input[name="account"]').on('change',function (e) {
        var $this = $(this);
        $.alpha.props($this, 'none');
        $this.parent().find('.check').remove();
        if (!accountReg.test($this.val().trim()) || $this.val().indexOf('@') > -1){
            setTimeout(function () {
                $.alpha.props($this, 'right', 'Only enter 4 to 20 characters and can not contain @ symbols!');
            },400)
        }else{
            $.alpha.props($this, 'none');
            setChecked($this);
        }
    });
    $('#tab_register input[name="pwd"]').on('change',function (e) {
        var $this = $(this);
        $this.parent().find('.check').remove();
        if (!pwdReg.test($this.val())){
            setTimeout(function () {
                $.alpha.props($this, 'right', 'Only enter 4 to 20 characters!');
            },400)
        }else{
            $.alpha.props($this, 'none');
            setChecked($this);
        }
    });
    $('#tab_register input[name="pwdAgain"]').on('change',function (e) {
        var $this = $(this);
        $.alpha.props($this, 'none');
        $this.parent().find('.check').remove();
        if ($this.val() !== $('#tab_register input[name="pwd"]').val()){
            setTimeout(function () {
                $.alpha.props($this, 'right', 'Must Type the Same Password!');
            },400)
        }else{
            $.alpha.props($this, 'none');   
            setChecked($this);
        }
    });
    $('#tab_register input[name="inviteCode"]').on('change',function (e) {
        var $this = $(this);
        $this.parent().find('.check').remove();
        if (!$this.val()){
            setTimeout(function () {
                $.alpha.props($this, 'right', 'Please enter the invitation code!');
            },400)
        }else{
            $.alpha.props($this, 'none');   
            setChecked($this);
        }
    });
    $('#tab_register input[name="firstName"]').on('change',function (e) {
        var $this = $(this);
        $this.parent().find('.check').remove();
        if ($this.val()){
            $.alpha.props($this, 'none');   
            setChecked($this);
        }
    });
    $('#tab_register input[name="lastName"]').on('change',function (e) {
        var $this = $(this);
        $this.parent().find('.check').remove();
        if ($this.val()){
            $.alpha.props($this, 'none');   
            setChecked($this);
        }
    });
    $('#tab_register input[name="birth"]').on('change',function (e) {
        var $this = $(this);
        $this.parent().find('.check').remove();
        if ($this.val()){
            $.alpha.props($this, 'none');   
            setChecked($this);
        }
    });
    $('#tab_register input[name="sex"]').on('change',function (e) {
        var $this = $(this);
        $this.parent().find('.check').remove();
        if (!$this.val()){
            $.alpha.props($this,'right','Choose your sex');
        }else{
            $.alpha.props($this, 'none');   
            // setChecked($this);
        }
    });
    $('#tab_register input[name="email"]').on('change',function (e) {
        var $this = $(this);
        $this.parent().find('.check').remove();
        if (!$this.val().trim() || !emailReg.test($this.val().trim())){
            setTimeout(function () {
                $.alpha.props($this, 'right', 'Invalid email!');
            },400)
        }else{
            $.alpha.props($this, 'none');
            setChecked($this);
        }
    });
    $('#tab_register input[name="emailCode"]').on('change',function (e) {
        var $this = $(this);
        $this.parent().find('.check').remove();
        var code = $this.val().trim();
        var data = {
            email: $('#tab_register input[name="email"]').val().trim(),
            code: code
        };

        // todo request 
        setTimeout(function () {
            $.alpha.request_Url('POST', 'user/authentication', data, function(res){
                if(res.archive.status == 405 || !code){
                    $this.parent().append($('<span class="fa fa-close check text-danger"></span>'));
                    isEmailCode = false;
                }else if(res.archive.status == 0){
                    setChecked($this);
                    isEmailCode = true;
                }
            });
        },400)
    });
    $('#tab_register input[name="mt4Account"]').on('change',function (e) {
        if($(this).val()){
            $('#tab_register input[name="mt4Group"]').attr('disabled',false);
            $('#tab_register input[name="mt4Server"]').attr('disabled',false);
        }else{
            $('#tab_register input[name="mt4Group"]').attr('disabled',true);
            $('#tab_register input[name="mt4Server"]').attr('disabled',true);
        }

    });
    $('#tab_register,#tab_login,#tab_forgot_password').on('show.bs.tab', function (e) {
        var event = e || window.event;
        $.alpha.props($('input'), 'none');
    });
    $('.next').click(function(){
        var account = $('#tab_register [name="account"]').val().trim(),
            pwd = $('#tab_register [name="pwd"]').val().trim(),
            pwdAgain = $('#tab_register [name="pwdAgain"]').val().trim(),
            inviteCode = $('#tab_register [name="inviteCode"]').val().trim();
            firstName = $('#tab_register [name="firstName"]').val().trim(),
            lastName = $('#tab_register [name="lastName"]').val().trim(),
            birth = $('#tab_register [name="birth"]').val().trim(),
            sex = $('#tab_register [name="sex"]').val().trim(),
            email = $('#tab_register [name="email"]').val().trim(),
            emailCode = $('#tab_register [name="emailCode"]').val().trim(),
            mt4Account = $('#tab_register [name="mt4Account"]').val().trim(),
            mt4Group = $('#tab_register [name="mt4Group"]').val().trim(),
            mt4Server = $('#tab_register [name="mt4Server"]').val().trim();

        var nextIndex = parseInt($('.wizard-steps').find('li.active').length);
        if(nextIndex == 1){
            if(accountReg.test(account) && pwdReg.test(pwd) && pwdAgain === pwd && inviteCode){
                $('.previous').removeClass('hide');
                $('.wizard-steps').find('li').eq(nextIndex).addClass('active');
                $('#tab_register').find('.tab-pane').eq(nextIndex-1).removeClass('active');
                $('#tab_register').find('.tab-pane').eq(nextIndex).addClass('active');
            }
        }
        if(nextIndex == 2){
            if(isEmailCode && sex.length && emailReg.test(email)){
                $('.next').addClass('hide');
                $('#btn-register').removeClass('hide');
                $('.wizard-steps').find('li').eq(nextIndex).addClass('active');
                $('#tab_register').find('.tab-pane').eq(nextIndex-1).removeClass('active');
                $('#tab_register').find('.tab-pane').eq(nextIndex).addClass('active');
            }
        }
    });
    $('.previous').click(function(){
        var preIndex = parseInt($('.wizard-steps').find('li.active').length);
        if(preIndex > 1){
            $('.wizard-steps').find('li').eq(preIndex - 1).removeClass('active');
            $('#tab_register').find('.tab-pane').eq(preIndex - 1).removeClass('active');
            $('#tab_register').find('.tab-pane').eq(preIndex - 2).addClass('active');
        }
        if(preIndex == 2){
            $('.previous').addClass('hide');
        }
        if(preIndex == 3){
            $('#btn-register').addClass('hide');
            $('.previous').removeClass('hide');
            $('.next').removeClass('hide');
        }
    });
    
    
    // 忘记密码
    var isCode = false;
    $('#forgot_next_btn').click(function (e) {
        var account = $('#tab_forgot_password input[name="account"]').val().trim();
        var email = $('#tab_forgot_password input[name="email"]').val().trim();
        var inviteCode = $('#tab_forgot_password input[name="code"]').val().trim();
        var isNext = accountReg.test(account) && emailReg.test(email) && isCode;
        if (isNext){
            $('#forgot_password1').hide();
            $('#forgot_password2').show();
            $(this).hide();
            $('#forgot_submit_btn').show();
            $('#tab_forgot_password .return_pre').show();
            $('#tab_forgot_password .return_login').hide();
        }
    })
    
    $('#tab_forgot_password .return_pre').click(function (e) {
        $('#forgot_password1').show();
        $('#forgot_password2').hide();
        $('#forgot_next_btn').show();
        $('#forgot_submit_btn').hide();
        $(this).hide();
        $('#tab_forgot_password .return_login').show();
    })
    
    $('#forgot_submit_btn').click(function (e) {
        var password = $('#tab_forgot_password input[name="newPassword"]').val();
        var password2 = $('#tab_forgot_password input[name="new_pwdAgain"]').val();
        var account = $('#tab_forgot_password input[name="account"]').val().trim();
        var email = $('#tab_forgot_password input[name="email"]').val().trim();
        var data = {
            email: email,
            account: account,
            password: password
        };
        var $pwd = $('#tab_forgot_password input[name="newPassword"]');
        var $this = $(this);
        if (password && password2 == password){
            $.alpha.request_Url('POST', 'user/changePasswordFromForget', data, function(res){
                if(res.archive.status == 21){
                    $.alpha.props($pwd, 'right', res.archive.message);
                }else{
                    setTimeout(function(){
                        $this.hide().next('span').removeClass('hide');
                        window.location.href='Login.html';
                    }, 500);
                }
            });
        }
    })
    
    $('#tab_forgot_password input[name="account"]').on('change',function (e) {
        var $this = $(this);
        $this.parent().find('.check').remove();
        if (!accountReg.test($this.val().trim())){
            setTimeout(function () {
                $.alpha.props($this, 'right', 'Only 4 to 20 words and numbers!');
            },400)
        }else{
            $.alpha.props($this, 'none');
            setChecked($this);
        }
    })
    $('#tab_forgot_password input[name="email"]').on('change',function (e) {
        var $this = $(this);
        $this.parent().find('.check').remove();
        if (!$this.val().trim() || !emailReg.test($this.val().trim())){
            setTimeout(function () {
                $.alpha.props($this, 'right', 'Invalid email!');
            },400)
        }else{
            $.alpha.props($this, 'none');
            setChecked($this);
        }
    })
    $('#tab_forgot_password input[name="code"]').on('change',function (e) {
        var $this = $(this);
        $this.parent().find('.check').remove();
        var code = $this.val().trim();
        var data = {
            email: $('#tab_forgot_password input[name="email"]').val().trim(),
            code: code
        };

        // todo request 
        setTimeout(function () {
            $.alpha.request_Url('POST', 'user/authentication', data, function(res){
                if(res.archive.status == 405 || !code){
                    $this.parent().append($('<span class="fa fa-close check text-danger"></span>'));
                    isCode = false;
                }else if(res.archive.status == 0){
                    setChecked($this);
                    isCode = true;
                }
            });
        },400)
    })
    $('#tab_forgot_password input[name="newPassword"]').on('change',function (e) {
        var $this = $(this);
        $this.parent().find('.check').remove();
        if (!pwdReg.test($this.val())){
            setTimeout(function () {
                $.alpha.props($this, 'right', 'Invalid password!');
            },400)
        }else{
            $.alpha.props($this, 'none');
            setChecked($this);
        }
    })
    $('#tab_forgot_password input[name="new_pwdAgain"]').on('change',function (e) {
        var $this = $(this);
        $this.parent().find('.check').remove();
        if ($this.val() !== $('#tab_forgot_password input[name="newPassword"]').val()){
            setTimeout(function () {
                $.alpha.props($this, 'right', 'Must Type the Same Password!');
            },400)
        }else{
            $.alpha.props($this, 'none');   
            setChecked($this);
        }
    })

    function setChecked(obj){
        obj.parent().append($('<span class="fa fa-check check text-success"></span>'));
    }

    function sendCode(obj,text){
        $(obj + ' .send-code').click(function (e) {
            var event = e || window.event;
            event.stopPropagation();
            var email = $(obj + ' input[name="email"]').val().trim();
            var data = {
                email:email,
                username:$(obj + ' input[name="account"]').val().trim(),
                text:text
            };
            var count = 60, $this = $(this);
            clearInterval(timer);
            if (emailReg.test(email)){
                $.alpha.request_Url('POST', 'user/send_mail', data);
                $this.hide();
                timer = setInterval(function(){
                    if(count >= 1){
                        count--;
                        $this.next('.time-concloum').removeClass('hide').html(count + 's');
                    }else{
                        $this.show().next('.time-concloum').addClass('hide');
                    }
                },1000);
            }
        })
    }

    sendCode('#tab_forgot_password','forget');
    sendCode('#tab_register','verify');
});
