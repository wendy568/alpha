/**
 * Created by alpharghrtbrtgt on 2017/6/16.
 */
$(function () {
    var emailReg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var pwdReg = /^[A-Za-z0-9]{6,12}$/;
    
    // Login
    $('#btn-login').click(function (e) {
        var event = e || window.event;
        event.stopPropagation();
        sessionStorage.setItem('alpha_token', '');
        var email = $('#tab_login [name="email"]').val();
        var pwd = $('#tab_login [name="pwd"]').val();
        var data = {
            email: email,
            password: pwd
        };
        if (email && pwd && emailReg.test(email) && pwdReg.test(pwd)) {
            $.alpha.request_Url('POST', 'user/login', data, function (res) {
                if (res.archive.status == 0) {
                    sessionStorage.setItem('alpha_token', res.data.token);
                    window.location.href = 'index.html';
                } else if (res.archive.status == 101) {
                    // 弹出框提示用户名或密码错误
                    $.alpha.alertBox('Error', 'Invalid Account or Password !', '#');
                } else {
                    // 登录失败提示
                    $.alpha.alertBox('Fail', 'Login Failed!', '#');
                }
            });
        } else {
            // 提示表单验证
            if (!email) {
                $.alpha.props($('#tab_login [name="email"]'), 'top', 'Not Empty!');
            }
            if (!pwd) {
                $.alpha.props($('#tab_login [name="pwd"]'), 'bottom', 'Not Empty!');
            }
        }
    });
    
    $('#tab_login [name="email"]').change(function () {
        if (emailReg.test($(this).val())) {
            $.alpha.props($(this), 'none');
        } else {
            $.alpha.props($(this), 'top', 'Invalid Email!');
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
        var firstName = $('#tab_register [name="firstName"]').val(),
            lastName = $('#tab_register [name="lastName"]').val(),
            email = $('#tab_register [name="email"]').val(),
            pwd = $('#tab_register [name="pwd"]').val(),
            inviteCode = $('#tab_register [name="inviteCode"]').val();
        
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
    
    $('#tab_register [name="email"]').change(function () {
        if (emailReg.test($(this).val())) {
            $.alpha.props($(this), 'none');
        } else {
            $.alpha.props($(this), 'right', 'Invalid Email!');
        }
    });
    $('#tab_register [name="pwd"]').change(function () {
        if (pwdReg.test($(this).val())) {
            $.alpha.props($(this), 'none');
        } else {
            $.alpha.props($(this), 'right', 'Invalid Password!');
        }
    });
    $('#tab_register [name="pwdAgain"]').change(function () {
        if ($(this).val() === $('#tab_register [name="pwd"]').val()) {
            $.alpha.props($(this), 'none');
        } else {
            $.alpha.props($(this), 'right', 'Inconsistent Password!');
        }
    });
    $('#tab_register [name="firstName"]').change(function () {
        if ($(this).val()) {
            $.alpha.props($(this), 'none');
        } else {
            $.alpha.props($(this), 'top', 'Not Empty!');
        }
    });
    
    $('#tab_register,#tab_login,#tab_forgot_password').on('show.bs.tab', function (e) {
        var event = e || window.event;
        $.alpha.props($('input'), 'none');
    });
    
    
    // 忘记密码
    $('#forgot_next_btn').click(function (e) {
        var account = $('#tab_forgot_password input[name="account"]').val().trim();
        var email = $('#tab_forgot_password input[name="email"]').val().trim();
        var inviteCode = $('#tab_forgot_password input[name="code"]').val().trim();
        var isNext = account && email && inviteCode && emailReg.test(email);
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
        if (password && password2 == password){
        
        }
    })
    
    $('.send-code').click(function (e) {
        var email = $('#tab_forgot_password input[name="email"]').val().trim();
        if (emailReg.test(email)){
        
        }
    })
    
});
