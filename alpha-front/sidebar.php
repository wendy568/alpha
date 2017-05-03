<?php
header('Content-Type:text/html;charset=UTF-8');
?>
<!-- sidebar left-->
<div class="page-sidebar " id="main-menu">
    <div class="page-sidebar-wrapper scroller scrollbar-dynamic" id="main-menu-wrapper">
        <!-- 用户头像信息 -->
        <div class="user-info-wrapper sm">
            <!-- 头像 -->
            <div class="profile-wrapper sm">
                <img src="assets/img/profiles/avatar.jpg" alt="" data-src="assets/img/profiles/avatar.jpg" data-src-retina="assets/img/profiles/avatar2x.jpg" width="69" height="69" />
            </div>
            <!-- 姓名、登录状态 -->
            <div class="user-info sm">
                <div class="username"><span class="semi-bold">Welcome</span></div>
                <div class="username">John <span class="semi-bold">Smith</span></div>
                <div class="status">Status
                    <div class="status-icon green"></div> online    
                </div>
            </div>
        </div>
        <!-- BROWSE    -->
        <p class="menu-title sm">BROWSE 
            <span class="pull-right">
                <a href="javascript:;">
                    <i class="fa fa-refresh"></i>
                </a>
            </span>
        </p>
        <!-- 链接列表 -->
        <ul>    
            <!-- index -->
            <li class="start  open active "> 
                <a href="index.html">
                    <i class="fa fa-home"></i> 
                    <span class="title">Index</span> 
                    <span class="badge badge-important pull-right">5</span>
                </a>
            </li>
            <!-- Tra Management -->
            <li>
                <a href="javascript:;"> 
                    <i class="fa fa-legal"></i>
                    <span class="title">Tra Management</span> 
                    <span class=" fa fa-angle-left pull-right "></span> 
                </a>
                <ul class="sub-menu">
                    <li> 
                        <a href="TradingStatistic.html"><i class="fa fa-bar-chart"></i>Trading Statistics </a> 
                    </li>
                    <li> 
                        <a href="Tools.html"><i class="fa fa-suitcase"></i>Tools</a> 
                    </li>
                </ul>
            </li>
            <!-- tv -->
            <li>
                <a href="email.html"> 
                    <i class="fa fa-tv"></i> 
                    <span class="title">TV</span> 
                </span>
                </a>
            </li>
            <!-- order -->
            <li>
                <a href="javascript:;"> 
                    <i class="fa fa-file-text"></i> 
                    <span class="title">Order</span> 
                </a>
            </li>
            <!-- help -->
            <li>
                <a href="javascript:;"> 
                    <i class="fa fa-question-circle"></i> 
                    <span class="title">Help</span> 
                </a>
            </li>
            <!-- table -->
            <li>
                <a href="javascript:;"> 
                    <i class="fa fa-th-large"></i>
                    <span class="title">Table</span> 
                </a>
            </li>
        </ul>
        <div class="side-bar-widgets">
            <p class="menu-title sm">Themes 
                <span class="pull-right">
                    <a href="#" class="create-folder"> 
                        <i class="fa fa-plus"></i>
                    </a>
                </span>
            </p>
            <ul class="folders">
              <li>
                <a href="#">
                    <i class="fa fa-circle-o"></i>  white
                </a>
              </li>
              <li>
                <a href="#">
                    <i class="fa fa-circle-o text-block"></i> block 
                </a>
              </li>
            </ul>
        </div>
    </div>
</div>
<a href="#" class="scrollup">Scroll</a>
<!-- exit -->
<div class="footer-widget">
    <div class="progress transparent progress-small no-radius no-margin">
      <div class="progress-bar progress-bar-success animate-progress-bar" data-percentage="79%" style="width: 79%;"></div>
    </div>
    <div class="pull-right">
        <div class="details-status"> 
            <span class="animate-number" data-value="86" data-animation-duration="560">86</span>% 
        </div>
        <a href="lockscreen.html">
            <i class="fa fa-power-off"></i>
        </a>
    </div>
</div>

 <!-- sidebar right notice-->
<div class="notice-box">
    <div  class="inner-content scroller scrollbar-dynamic">
        <div class="notice-header">
            <input type="text" placeholder="search" >
            <a href="#" class="pull-right">
                <div class="iconset top-settings-dark"></div>
            </a>
        </div>
        <!-- notice -->
        <div class="notice fadeIn">
            <!-- date -->
            <div class="notice-date">
                <div class="pull-left day-num text-c2">08.APR</div><span class="day"></span> Monday
                <i class="fa fa-plus pull-right"></i>
            </div>
            <!-- 中间线 -->
            <div class="notice-timeline"></div>
            <!-- notice content -->
            <div class="notice-content">
                <div class="notice-card">
                    <!-- title -->
                    <div class="card-title">
                        <div class="pull-left">12:00</div>
                        <div class="status-icon green pull-right"></div>
                    </div>
                    <!-- body -->
                    <div class="card-body">
                        <h5>The problem you submitted a new reply</h5>
                    </div>
                </div>
                <div class="notice-card">
                    <!-- title -->
                    <div class="card-title">
                        <div class="pull-left">11:00</div>
                        <div class="status-icon grey pull-right"></div>
                    </div>
                    <!-- body -->
                    <div class="card-body">
                        <h5>The problem you submitted a <span class="text-primary">new reply &gt;&gt;</span></h5>
                    </div>
                </div>
                <div class="notice-card">
                    <!-- title -->
                    <div class="card-title">
                        <div class="pull-left">10:00</div>
                        <div class="status-icon grey pull-right"></div>
                    </div>
                    <!-- body -->
                    <div class="card-body">
                        <h5>The problem you submitted a  <span class="text-success">new reply &gt;&gt;</span> </h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="notice fadeIn">
            <!-- date -->
            <div class="notice-date">
                <div class="pull-left day-num text-c2">08.APR</div><span class="day"></span> Monday
                <i class="fa fa-plus pull-right"></i>
            </div>
            <!-- 中间线 -->
            <div class="notice-timeline"></div>
            <!-- notice content -->
            <div class="notice-content">
                <div class="notice-card">
                    <!-- title -->
                    <div class="card-title">
                        <div class="pull-left">12:00</div>
                        <div class="status-icon green pull-right"></div>
                    </div>
                    <!-- body -->
                    <div class="card-body">
                        <h5>The problem you submitted a new reply</h5>
                    </div>
                </div>
                <div class="notice-card">
                    <!-- title -->
                    <div class="card-title">
                        <div class="pull-left">11:00</div>
                        <div class="status-icon grey pull-right"></div>
                    </div>
                    <!-- body -->
                    <div class="card-body">
                        <h5>The problem you submitted a <span class="text-primary">new reply &gt;&gt;</span></h5>
                    </div>
                </div>
                <div class="notice-card">
                    <!-- title -->
                    <div class="card-title">
                        <div class="pull-left">10:00</div>
                        <div class="status-icon grey pull-right"></div>
                    </div>
                    <!-- body -->
                    <div class="card-body">
                        <h5>The problem you submitted a  <span class="text-success">new reply &gt;&gt;</span> </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>