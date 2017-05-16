<?php
header('Content-Type:text/html;charset=UTF-8');
?>
 <!-- navbar -->
<div class="header navbar navbar-inverse ">
    <div class="navbar-inner">
        <!-- sidebar top -->
        <div class="header-seperation">
            <!-- 响应式隐藏菜单 左侧-->
            <ul class="nav pull-left notifcation-center visible-xs visible-sm">
                <li class="dropdown">
                    <a href="#main-menu" data-webarch="toggle-left-side">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
            </ul>
            <!-- LOGO -->
            <a href="index.html">
                <img src="assets/img/alpha_logo.png" class="logo" alt="" data-src="assets/img/alpha_logo.png" data-src-retina="assets/img/alpha_logo.png"  />
            </a>
            <!-- 主页和邮箱 -->
            <ul class="nav pull-right notifcation-center">
                <!-- 主页 -->
                <li class="dropdown hidden-xs hidden-sm">
                    <a href="index.html" class="dropdown-toggle active" data-toggle="">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <!-- 邮箱 -->
                <li class="dropdown hidden-xs hidden-sm">
                    <a href="" class="dropdown-toggle">
                        <i class="fa fa-envelope-o"></i><span class="badge badge-important">2</span>
                    </a>
                </li>
                <li class="dropdown visible-xs visible-sm">
                    <a href="" data-webarch="toggle-right-side">
                        <i class="fa fa-search"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- navbar-->
        <div class="header-quick-nav">
            <!-- navbar left-->
            <div class="pull-left">
                <ul class="nav quick-section">
                    <li class="quicklinks">
                        <a href="#" class="" id="layout-condensed-toggle">
                            <i class="fa fa-reorder"></i>
                        </a>
                    </li>
                </ul>
                <ul class="nav quick-section">
                    <li class="quicklinks  m-r-10">
                        <a href="#" class="">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                    <li class="m-r-10 input-prepend inside search-form no-boarder" >
                        <span class="add-on" > <i class="fa fa-search"></i></span>
                        <input name="" type="text" class="no-boarder" placeholder="Search Dashboard" style="width:250px;">
                    </li>
                </ul>
            </div>
            <div id="notification-list" style="display:none">
                <div style="width:300px">
                    <div class="notification-messages info">
                        <div class="user-profile">
                          <img src="assets/img/profiles/d.jpg" alt="" data-src="assets/img/profiles/d.jpg" data-src-retina="assets/img/profiles/d2x.jpg" width="35" height="35">
                        </div>
                        <div class="message-wrapper">
                          <div class="heading">
                            David Nester - Commented on your wall
                          </div>
                          <div class="description">
                            Meeting postponed to tomorrow
                          </div>
                          <div class="date pull-left">
                            A min ago
                          </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="notification-messages danger">
                        <div class="iconholder">
                          <i class="icon-warning-sign"></i>
                        </div>
                        <div class="message-wrapper">
                          <div class="heading">
                            Server load limited
                          </div>
                          <div class="description">
                            Database server has reached its daily capicity
                          </div>
                          <div class="date pull-left">
                            2 mins ago
                          </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="notification-messages success">
                        <div class="user-profile">
                            <img src="assets/img/profiles/h.jpg" alt="" data-src="assets/img/profiles/h.jpg" data-src-retina="assets/img/profiles/h2x.jpg" width="35" height="35">
                        </div>
                        <div class="message-wrapper">
                            <div class="heading"> You haveve got 150 messages</div>
                            <div class="description">150 newly unread messages in your inbox </div>
                            <div class="date pull-left"> An hour ago </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- navbar right -->
            <div class="pull-right">
                <ul class="nav quick-section ">
                    <!-- 邮箱 -->
                    <li class="dropdown hidden-xs hidden-sm">
                        <a href="" class="dropdown-toggle" data-webarch="toggle-right-side">
                            <i class="fa fa-envelope-o"></i><span class="badge badge-important">2</span>
                        </a>
                         <div class="simple-chat-popup chat-menu-toggle hide">
                            <div class="simple-chat-popup-arrow"></div>
                            <div class="simple-chat-popup-inner">
                                <div style="width:100px">
                                    <div class="semi-bold">David Nester</div>
                                    <div class="message">Hey you there </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>