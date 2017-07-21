/**
 * Created by alpharghrtbrtgt on 2017/6/16.
 */
$(function () {
    var emailReg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var pwdReg = /^[A-Za-z0-9]{4,20}$/;
    var accountReg = /^(?![0-9]+$)[A-Za-z0-9]{4,20}$/;
    var NameReg = /^[A-Za-z]{2,30}$/;

    // Login
    $('#btn-login').click(function (e) {
        var event = e || window.event;
        event.stopPropagation();
        sessionStorage.setItem('alpha_token', '');
        var account = $('#tab_login [name="account"]').val();
        var pwd = $('#tab_login [name="pwd"]').val();
        var data = {
            email: account,
            password: pwd
        };
        $('#tab_login .text-danger').html('');
        if (account && pwd && accountReg.test(account) && pwdReg.test(pwd)) {
            $.alpha.request_Url('POST', 'user/login', data, function (res) {
                if (res.archive.status == 0) {
                    sessionStorage.setItem('alpha_token', res.data.token);
                    window.location.href = 'index.html';
                } else if (res.archive.status == 101) {
                    // 弹出框提示用户名或密码错误
                    $('#tab_login .text-danger').html('Invalid Account or Password !');
                } else {
                    // 登录失败提示
                    $.alpha.alertBox('Fail', 'Login Failed!', 'javascript:(0);');
                }
            });
        } else {
            // 提示表单验证
            if (!account) {
                $.alpha.props($('#tab_login [name="account"]'), 'top', 'Can\'t Empty!');
            }
            if (!pwd) {
                $.alpha.props($('#tab_login [name="pwd"]'), 'bottom', 'Can\'t Empty!');
            }
        }
    });
    
    $('#tab_login [name="account"]').change(function () {
        if (accountReg.test($(this).val())) {
            $.alpha.props($(this), 'none');
        } else {
            $.alpha.props($(this), 'top', 'Invalid Account!');
        }
    });
    $('#tab_login [name="pwd"]').change(function () {
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
    $('#btn-register').click(function (e) {
        var event = e || window.event;
        event.stopPropagation();
        sessionStorage.setItem('alpha_token', '');
        var account = $('#tab_register [name="account"]').val().trim(),
            pwd = $('#tab_register [name="pwd"]').val().trim(),
            pwdAgain = $('#tab_register [name="pwd"]').val().trim(),
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

        var data = {
            first_name: firstName,
            last_name: lastName,
            email: email,
            password: pwd,
            invite_code: inviteCode
        };
        
        if (firstName && email && pwd && emailReg.test(email) && pwdReg.test(pwd)) {
            $.alpha.request_Url('POST', 'user/register', data, function (res) {
                if (res.archive.status == 0) {
                    sessionStorage.setItem('alpha_token', res.data.token);
                    window.location.href = 'index.html';
                } else if (res.archive.status == 102) {
                    // 提示邮箱已存在
                    $.alpha.props($('#tab_register [name="email"]'), 'right', 'The email has been registered!');
                } else {
                    // 提示注册失败
                    $.alpha.alertBox('Fail', 'Register Failed!', '#');
                }
            });
        } else {
            // 提示表单验证
            if (!email) {
                $.alpha.props($('#tab_register [name="email"]'), 'right', 'Not Empty!');
            }
            if (!pwd) {
                $.alpha.props($('#tab_register [name="pwd"]'), 'right', 'Not Empty!');
            }
            if (!firstName) {
                $.alpha.props($('#tab_register [name="firstName"]'), 'top', 'Not Empty!');
            }
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
        $this.parent().find('.check').remove();
        if (!accountReg.test($this.val().trim())){
            setTimeout(function () {
                $.alpha.props($this, 'right', 'Only 4 to 20 words and numbers!');
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
                $.alpha.props($this, 'right', 'Invalid password!');
            },400)
        }else{
            $.alpha.props($this, 'none');
            setChecked($this);
        }
    });
    $('#tab_register input[name="pwdAgain"]').on('change',function (e) {
        var $this = $(this);
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
        if (!$this.val().trim()){
            setTimeout(function () {
                // to request
                $this.parent().append($('<span class="fa fa-close check text-danger"></span>'));
                isCode = false;
            },400)
        }else{
            $.alpha.props($this, 'none');
            setChecked($this);
            isCode = true;
        }
    });
    $('#tab_register input[name="mt4Account"]').on('change',function (e) {
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
            
        if((accountReg.test(account) && pwdReg.test(pwd) && pwdAgain === pwd && inviteCode) || (sex && emailReg.test(email) && emailCode)){
            var nextIndex = parseInt($('.wizard-steps').find('li.active').length);
            if(nextIndex < 3){
                $('.wizard-steps').find('li').eq(nextIndex).addClass('active');
                $('#tab_register').find('.tab-pane').eq(nextIndex-1).removeClass('active');
                $('#tab_register').find('.tab-pane').eq(nextIndex).addClass('active');
            }
            if(nextIndex == 1){
                $('.previous').removeClass('hide');
            }
            if(nextIndex == 2){
                $('.next').addClass('hide');
                $('#btn-register').removeClass('hide');
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
        if (true){
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
        if (password && password2 == password){
        
        }
    })
    
    $('.send-code').click(function (e) {
        var email = $('#tab_forgot_password input[name="email"]').val().trim();
        if (emailReg.test(email)){
        
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
        if (!$this.val().trim()){
            setTimeout(function () {
                // to request
                $this.parent().append($('<span class="fa fa-close check text-danger"></span>'));
                isCode = false;
            },400)
        }else{
            $.alpha.props($this, 'none');
            setChecked($this);
            isCode = true;
        }
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
});
