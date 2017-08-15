
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?><?=STATIC_CSS?>uploadify.css">
    <link rel="stylesheet" href="<?=base_url()?>static/panel/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?=base_url()?>static/panel/css/template.css"/>
    <link rel="stylesheet" href="<?=base_url()?>static/panel/css/font-awesome.css"/>
    <script type="text/javascript" src="<?=base_url()?><?=STATIC_JS?>jquery.min.js"></script>
    <script type='text/javascript' src="<?=base_url()?>static/panel/js/artTemplate.js"></script> 
    <script type='text/javascript' src="<?=base_url()?>static/panel/js/artTemplate-plugin.js"></script> 
    <script type='text/javascript' src="<?=base_url()?>static/panel/js/common.js"></script> 
    <script type="text/javascript" src="<?=base_url()?><?=STATIC_JS?>jquery.uploadify.min.js"></script>
    <title></title>
</head>
<body>

	<div class="x-nav">
    <div class="x-nav-status">
        <ul class="clear">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-warning-sign">
                    </i>
                    <span class="badge">5</span>
                </a>
                <ul class="dropdown-menu x-nav-dropdown">
                    <li><p> you have 14 person get to</p> </li>
                    <li><a href="#">gafew agfwa</a>  </li>
                    <li> <a href="#">gafew agfwa</a> </li>
                    <li class="external"><a href="#">to see more<i class="glyphicon glyphicon-circle-arrow-right"></i></a> </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-envelope">
                    </i>
                    <span class="badge">5</span>
                </a>
                <ul class="dropdown-menu x-nav-dropdown">
                    <li><p> you have 14 person get to</p> </li>
                    <li><a href="#">gafew agfwa</a>  </li>
                    <li> <a href="#">gafew agfwa</a> </li>
                    <li class="external"><a href="#">to see more<i class="glyphicon glyphicon-circle-arrow-right"></i></a> </li>
                </ul>

            </li>
        </ul>
    </div>
</div>
<div class="x-contain">
    <div class="x-aside">
        <div class="x-aside-user">
            <!-- <div class="imgClu">
                <img src="<?=base_url()?>static/panel/img/t1.jpg" class="img-circle" alt=""/>
            </div> -->
            <div class="x-aside-info">
                <h4>欢迎</h4>
                <p><?=$admin_name?></p>
                <!-- <button class="btn btn-info btn-xs glyphicon glyphicon-cog">设置</button> -->
            </div>
        </div>
        <ul class="x-aside-menu">
            <li class="aside-search">
                <form action="#">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
          <span class="input-group-btn">
            <button class="btn btn-info btn-sm" type="button">
                <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
                    </div>
                </form>
            </li>
            <?foreach(get_menu() as $key => $val):?>
            <li>
                <a href="#">
                    <!-- <i class="glyphicon glyphicon-home"></i> -->
                    <span><?=$key?></span>
                    <span class="glyphicon glyphicon-menu-down aside-i-dowm"></span>
                </a>
                <ul class="x-aside-menu2">
                <?foreach($val as $k => $v):?>
                    <li>
                        <a href="<?=site_url($v)?>">
                            <!-- <i class="glyphicon glyphicon-home"></i> -->
                            <span><?=$k?></span>
                        </a>
                    </li>
                <?endforeach;?>
                </ul>
            </li>
           <?endforeach;?>
        </ul>
    </div>