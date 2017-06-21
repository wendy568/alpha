/**
 * Created by alpharghrtbrtgt on 2017/6/16.
 */
$(function () {
  var emailReg=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  var pwdReg = /^[A-Za-z0-9]{6,12}$/;
  
  // Login
  $('#btn-login').click(function (e) {
    var event = e || window.event;
    event.stopPropagation();
    sessionStorage.setItem('alpha_token','');
    var email = $('#tab_login [name="email"]').val();
    var pwd = $('#tab_login [name="pwd"]').val();
    var data = {
      email : email,
      password : pwd
    };
    if (email && pwd && emailReg.test(email) && pwdReg.test(pwd)){
      $.alpha.request_Url('POST','user/login',data,function (res) {
        if(res.archive.status == 0){
          sessionStorage.setItem('alpha_token',res.data.token);
          window.location.href = 'index.html';
        }else if(res.archive.status == 101){
          // 弹出框提示用户名或密码错误
          $.alpha.alertBox('Error','Invalid Account or Password !','#');
        }else{
          // 登录失败提示
          $.alpha.alertBox('Fail','Login Failed!','#');
        }
      });
    }else{
      // 提示表单验证
      if(!email){
        $.alpha.props($('#tab_login [name="email"]'),'top','Not Empty!');
      }
      if(!pwd){
        $.alpha.props($('#tab_login [name="pwd"]'),'bottom','Not Empty!');
      }
    }
  });
  
  $('#tab_login [name="email"]').change(function () {
    if(emailReg.test($(this).val())){
      $.alpha.props($(this),'none');
    }else{
      $.alpha.props($(this),'top','Invalid Email!');
    }
  });
  $('#tab_login [name="pwd"]').change(function () {
    if(pwdReg.test($(this).val())){
      $.alpha.props($(this),'none');
    }else{
      $.alpha.props($(this),'bottom','Invalid Password!');
    }
  });
  
  // Register
  $('#btn-register').click(function (e) {
    var event = e || window.event;
    event.stopPropagation();
    sessionStorage.setItem('alpha_token','');
    var firstName = $('#tab_register [name="firstName"]').val(),
      lastName = $('#tab_register [name="lastName"]').val(),
      email = $('#tab_register [name="email"]').val(),
      pwd = $('#tab_register [name="pwd"]').val(),
      inviteCode = $('#tab_register [name="inviteCode"]').val();
    
    var data = {
      first_name : firstName,
      last_name : lastName,
      email : email,
      password : pwd,
      invite_code : inviteCode
    };
    
    if (firstName && email && pwd && emailReg.test(email) && pwdReg.test(pwd)){
      $.alpha.request_Url('POST','user/register',data,function (res) {
        if(res.archive.status == 0){
          sessionStorage.setItem('alpha_token',res.data.token);
          window.location.href = 'index.html';
        }else if(res.archive.status == 102){
          // 提示邮箱已存在
          $.alpha.props($('#tab_register [name="email"]'),'right','The email has been registered!');
        }else{
          // 提示注册失败
          $.alpha.alertBox('Fail','Register Failed!','#');
        }
      });
    }else{
      // 提示表单验证
      if(!email){
        $.alpha.props($('#tab_register [name="email"]'),'right','Not Empty!');
      }
      if(!pwd){
        $.alpha.props($('#tab_register [name="pwd"]'),'right','Not Empty!');
      }
      if(!firstName){
        $.alpha.props($('#tab_register [name="firstName"]'),'top','Not Empty!');
      }
    }
    
  });
  
  $('#tab_register [name="email"]').change(function () {
    if(emailReg.test($(this).val())){
      $.alpha.props($(this),'none');
    }else{
      $.alpha.props($(this),'right','Invalid Email!');
    }
  });
  $('#tab_register [name="pwd"]').change(function () {
    if(pwdReg.test($(this).val())){
      $.alpha.props($(this),'none');
    }else{
      $.alpha.props($(this),'right','Invalid Password!');
    }
  });
  $('#tab_register [name="pwdAgain"]').change(function () {
    if($(this).val() === $('#tab_register [name="pwd"]').val()){
      $.alpha.props($(this),'none');
    }else{
      $.alpha.props($(this),'right','Inconsistent Password!');
    }
  });
  $('#tab_register [name="firstName"]').change(function () {
    if($(this).val()){
      $.alpha.props($(this),'none');
    }else{
      $.alpha.props($(this),'top','Not Empty!');
    }
  });
  
  $('#tab_register,#tab_login').on('show.bs.tab', function (e) {
    var event = e || window.event;
    $.alpha.props($('input'),'none');
  });
});
