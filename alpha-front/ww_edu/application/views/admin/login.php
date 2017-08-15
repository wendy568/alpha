<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <script src="<?=base_url()?>static/panel/js/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="<?=base_url()?>static/panel/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?=base_url()?>static/panel/css/template.css"/>
    <title></title>
    <style>
        html,body{
            height: 100%;
        }
    </style>
</head>
<body>
<div class="login_clu">
    <div class="login">
        <div class="login_form">
            <div class="login_ing">
                <a href="#"><img src="" alt=""/></a>
            </div>
            <form id="foo">
            <div class="login_input">
                <label><span>用户名</span><input name='username' value="<?=set_value('username')?>" type="text"/></label>
                <label><span>密码</span><input name='password' value="<?=set_value('password')?>" type="password"/></label>
                <label class="sub"><input type="submit" value="登录" class="btn x-btn gray"/></label>
            </div>
            </form>
        </div>
        <div id="result"></div>
    </div>
</div>
<script type="text/javascript">

$("#foo").submit(function(event) {
     var ajaxRequest;

    event.preventDefault();

    $("#result").html('');

    var values = $(this).serialize();

       ajaxRequest= $.ajax({
            url: "<?=site_url(array('login','do_login'))?>",
            type: "post",
            data: values
        });

     ajaxRequest.done(function (response, textStatus, jqXHR){

          if(response!= 'TRUE')
          {
            alert(response);
          }
          else
          {
            window.location.href="<?=site_url(array('admin_index','index'))?>";
          }
     });

     ajaxRequest.fail(function (response){

       console.log(response);
     });
});
</script>
</body>
</html>