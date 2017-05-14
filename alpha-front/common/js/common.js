// 项目请求根地址
window.alpha_host='http://120.25.211.159/ww_edu/';

(function($) {
    'use strict';
    var alpha = function() {
        this.$body = $('body');
        //COLORS
        this.color_green="#27cebc";
        this.color_blue="#00acec";
        this.color_yellow="#FDD01C";
        this.color_red="#f35958";
        this.color_grey="#dce0e8";
        this.color_black="#1b1e24";
        this.color_purple="#6d5eac";
        this.color_primary="#6d5eac";
        this.color_success="#4eb2f5";
        this.color_danger="#f35958";
        this.color_warning="#f7cf5e";
        this.color_info="#3b4751";
    }
    // Set environment vars
    alpha.prototype.initHorizontalMenu = function() {
        $('.horizontal-menu .bar-inner > ul > li').on('click', function () {
            $(this).toggleClass('open').siblings().removeClass('open');

        });
         if($('body').hasClass('horizontal-menu')){
            $('.content').on('click', function () {
                $('.horizontal-menu .bar-inner > ul > li').removeClass('open');
            });
         }
    }
    // Tooltip
    alpha.prototype.initTooltipPlugin = function() {
        $.fn.tooltip && $('[data-toggle="tooltip"]').tooltip();
    }
    // Popover
    alpha.prototype.initPopoverPlugin = function() {
        $.fn.popover && $('[data-toggle="popover"]').popover();
    }
    // Retina Images
    alpha.prototype.initUnveilPlugin = function() {
        $.fn.unveil && $("img").unveil();
    }
    // Auto Scroll Up
    alpha.prototype.initScrollUp = function() {
        $('[data-webarch="scrollup"]').click(function () {
            $("html, body").animate({
                scrollTop: 0
            }, 700);
            return false;
        });
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('[data-webarch="scrollup"]').fadeIn();
            } else {
                $('[data-webarch="scrollup"]').fadeOut();
            }
        });
    }
    // Portlet / Panel Tools
    alpha.prototype.initPortletTools = function() {
        var $this = this;
        $('.grid .tools a.remove').on('click', function () {
            var removable = jQuery(this).parents(".grid");
            if (removable.next().hasClass('grid') || removable.prev().hasClass('grid')) {
                jQuery(this).parents(".grid").remove();
            } else {
                jQuery(this).parents(".grid").parent().remove();
            }
        });

        $('.grid .tools a.reload').on('click', function () {
            var el = jQuery(this).parents(".grid");
            $this.blockUI(el);
            window.setTimeout(function () {
                $this.unblockUI(el);
            }, 1000);
        });

        $('.grid .tools .collapse, .grid .tools .expand').on('click', function () {
            var el = jQuery(this).parents(".grid").children(".grid-body");
            if (jQuery(this).hasClass("collapse")) {
                jQuery(this).removeClass("collapse").addClass("expand");
                el.slideUp(200);
            } else {
                jQuery(this).removeClass("expand").addClass("collapse");
                el.slideDown(200);
            }
        });
        $('.widget-item > .controller .reload').click(function () {
            var el = $(this).parent().parent();
            $this.blockUI(el);
            window.setTimeout(function () {
                $this.unblockUI(el);
            }, 1000);
        });
        $('.widget-item > .controller .remove').click(function () {
            $(this).parent().parent().parent().addClass('animated fadeOut');
            $(this).parent().parent().parent().attr('id', 'id_remove_temp_id');
            setTimeout(function () {
                $('#id_remove_temp_id').remove();
            }, 400);
        });

        $('.tiles .controller .reload').click(function () {
            var el = $(this).parent().parent().parent();
            $this.blockUI(el);
            window.setTimeout(function () {
                $this.unblockUI(el);
            }, 1000);
        });
        $('.tiles .controller .remove').click(function () {
            $(this).parent().parent().parent().parent().addClass('animated fadeOut');
            $(this).parent().parent().parent().parent().attr('id', 'id_remove_temp_id');
            setTimeout(function () {
                $('#id_remove_temp_id').remove();
            }, 400);
        });
        $('.tab .controller .remove').click(function () {
            $(this).parent().parent().addClass('animated fadeOut');
            $(this).parent().parent().attr('id', 'id_remove');
            setTimeout(function () {
                $('#id_remove').remove();
            }, 400);
        });

        $('.alert .alert-head .controller .remove').click(function () {
           $(this).parent().parent().parent().remove();
        });

        if (!jQuery().sortable) {
            return;
        }
        $(".sortable").sortable({
            connectWith: '.sortable',
            iframeFix: false,
            items: 'div.grid',
            opacity: 0.8,
            helper: 'original',
            revert: true,
            forceHelperSize: true,
            placeholder: 'sortable-box-placeholder round-all',
            forcePlaceholderSize: true,
            tolerance: 'pointer'
        });
    }
    // Scrollbar Plugin
    alpha.prototype.initScrollBar = function(){
        $.fn.scrollbar && $('.scroller').each(function () {
            var h = $(this).attr('data-height');
            $(this).scrollbar({
                ignoreMobile:true
            });
            if(h != null  || h !=""){
                if($(this).parent('.scroll-wrapper').length > 0)
                    $(this).parent().css('max-height',h);
                else
                    $(this).css('max-height',h);
            }
        });
    }
    // Sidebar
    alpha.prototype.initSideBar = function(){
        var sidebar = $('.page-sidebar');
        var sidebarWrapper = $('.page-sidebar .page-sidebar-wrapper');
        sidebar.find('li > a').on('click', function (e) {
            if ($(this).next().hasClass('sub-menu') === false) {
                return;
            }
            var parent = $(this).parent().parent();
            parent.children('li.open').children('a').children('.fa').removeClass('open');
            parent.children('li.open').children('a').children('.fa').removeClass('active');
            parent.children('li.open').children('a').children('span.fa').addClass('fa-angle-left');
            parent.children('li.open').children('a').children('span.fa').removeClass('fa-angle-down');
            parent.children('li.open').children('.sub-menu').slideUp(200);
            parent.children('li').removeClass('open');

            var sub = jQuery(this).next();
            if (sub.is(":visible")) {
                jQuery('.fa', jQuery(this)).removeClass("open");
                jQuery(this).parent().removeClass("active");

                sub.slideUp(200, function () {
                });
            } else {
                jQuery('.fa', jQuery(this)).addClass("open");
                jQuery(this).parent().addClass("open");
                parent.children('li.open').children('a').children('span.fa').removeClass('fa-angle-left');
                parent.children('li.open').children('a').children('span.fa').addClass('fa-angle-down');
                sub.slideDown(200, function () {
                });
            }
            e.preventDefault();
        });
        //Auto close open menus in Condensed menu
        if (sidebar.hasClass('mini')) {
            var elem = jQuery('.page-sidebar ul');
            elem.children('li.open').children('a').children('.fa').removeClass('open');
            elem.children('li.open').children('a').children('.fa').removeClass('active');

            elem.children('li.open').children('.sub-menu').slideUp(200);
            elem.children('li').removeClass('open');
        }
        $.fn.scrollbar && sidebarWrapper.scrollbar();
    }
    // Sidebar Toggler
    alpha.prototype.initSideBarToggle = function(){
        var $this = this;
        $('[data-webarch="toggle-left-side"]').on('touchstart click', function (e) {
            e.preventDefault();
            $this.toggleLeftSideBar();
        });
        $('[data-webarch="toggle-right-side"]').on('touchstart click', function (e) {
            e.preventDefault();
            $this.toggleRightSideBar();
        });
    }
    // Left Side Bar / Chat view
    alpha.prototype.toggleLeftSideBar = function(){
        var timer;
        if($('body').hasClass('open-menu-left')){
            $('body').removeClass('open-menu-left');
            timer= setTimeout(function(){
                $('.page-sidebar').removeClass('visible');
            }, 300);

        }
        else{
            clearTimeout(timer);
            $('.page-sidebar').addClass('visible');
            setTimeout(function(){
                 $('body').addClass('open-menu-left');
            }, 50);
        }
    }
    // Right Side Bar / Mobile
    alpha.prototype.toggleRightSideBar = function(){
        var timer;
        if($('body').hasClass('open-menu-right')){
            $('body').removeClass('open-menu-right');
            timer= setTimeout(function(){
                $('.notice-box').removeClass('visible');
            }, 300);
        }
        else{
            clearTimeout(timer);
            $('.notice-box').addClass('visible');
            $('body').addClass('open-menu-right');
        }
    }
    // Util Functions
    alpha.prototype.initUtil = function(){
        $('[data-height-adjust="true"]').each(function () {
            var h = $(this).attr('data-elem-height');
            $(this).css("min-height", h);
            $(this).css('background-image', 'url(' + $(this).attr("data-background-image") + ')');
            $(this).css('background-repeat', 'no-repeat');
            if ($(this).attr('data-background-image')) {

            }
        });

        $('[data-aspect-ratio="true"]').each(function () {
            $(this).height($(this).width());
        });

        $('[data-sync-height="true"]').each(function () {
            equalHeight($(this).children());
        });

        $('[data-webarch-toggler="checkall"]').on('click', function () {
            var $el = $(this);
            var $table =  $el.closest('table');
            if ($el.is(':checked')) {
                $table.find(':checkbox').attr('checked', true);
                $table.find('tr').addClass('row_selected');
            } else {
               $table.find(':checkbox').attr('checked', false);
               $table.find('tr').removeClass('row_selected');
            }
        });

        $(window).resize(function () {
            $('[data-aspect-ratio="true"]').each(function () {
                $(this).height($(this).width());
            });
            $('[data-sync-height="true"]').each(function () {
                equalHeight($(this).children());
            });

        });
        function equalHeight(group) {
            var tallest = 0;
            group.each(function () {
                var thisHeight = $(this).height();
                if (thisHeight > tallest) {
                    tallest = thisHeight;
                }
            });
            group.height(tallest);
        }
        $('#my-task-list').popover({
            html: true,
            content: function () {
                return $('#notification-list').html();
            }
        });

        $('#user-options').click(function () {
            $('#my-task-list').popover('hide');
        });

        $('table th .checkall').on('click', function () {
            if ($(this).is(':checked')) {
                $(this).closest('table').find(':checkbox').attr('checked', true);
                $(this).closest('table').find('tr').addClass('row_selected');
                //$(this).parent().parent().parent().toggleClass('row_selected');
            } else {
                $(this).closest('table').find(':checkbox').attr('checked', false);
                $(this).closest('table').find('tr').removeClass('row_selected');
            }
        });
    }
    // Progress bar animation
    alpha.prototype.initProgress = function(){
        $('[data-init="animate-number"], .animate-number').each(function () {
            var data = $(this).data();
            $(this).animateNumbers(data.value, true, parseInt(data.animationDuration, 10));
        });
        $('[data-init="animate-progress-bar"], .animate-progress-bar').each(function () {
            var data = $(this).data();
            $(this).css('width', data.percentage);
        });
    }
    // Select2 Plugin
    alpha.prototype.initSelect2Plugin = function() {
        $.fn.select2 && $('[data-init-plugin="select2"]').each(function() {
            $(this).select2({
                minimumResultsForSearch: ($(this).attr('data-disable-search') == 'true' ? -1 : 1)
            }).on('select2-opening', function() {
                $.fn.scrollbar && $('.select2-results').scrollbar({
                    ignoreMobile: false
                })
            });
        });
    }
    // Form Elements
    alpha.prototype.initFormElements = function(){
        $(".inside").children('input').blur(function () {
            $(this).parent().children('.add-on').removeClass('input-focus');
        });

        $(".inside").children('input').focus(function () {
            $(this).parent().children('.add-on').addClass('input-focus');
        });

        $(".input-group.transparent").children('input').blur(function () {
            $(this).parent().children('.input-group-addon').removeClass('input-focus');
        });

        $(".input-group.transparent").children('input').focus(function () {
            $(this).parent().children('.input-group-addon').addClass('input-focus');
        });

        $(".bootstrap-tagsinput input").blur(function () {
            $(this).parent().removeClass('input-focus');
        });

        $(".bootstrap-tagsinput input").focus(function () {
            $(this).parent().addClass('input-focus');
        });
    }
    // Block UI
    alpha.prototype.blockUI = function(el){
        $(el).block({
            message: '<div class="loading-animator"></div>',
            css: {
                border: 'none',
                padding: '2px',
                backgroundColor: 'none'
            },
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.3,
                cursor: 'wait'
            }
        });
    }
    alpha.prototype.unblockUI = function(el){
        $(el).unblock();
    }
    // Call initializers
    alpha.prototype.init = function() {
        // init layout
        this.initSideBar();
        this.initSideBarToggle();
        this.initHorizontalMenu();
        this.initPortletTools();
        this.initScrollUp();
        this.initProgress();
        this.initFormElements();
        this.initSelect2Plugin();
        this.initUnveilPlugin();
        this.initScrollBar();
        this.initTooltipPlugin();
        this.initPopoverPlugin();
        this.initUtil();

    }
    // common ajax request
    alpha.prototype.request_Url = function (type, url, data, fn) {

        // 每次请求都会带上token信息

        data.token = sessionStorage.getItem("alpha_token") || '';

        return $.ajax({
          type    : type,
          url     : alpha_host + url,
          data    : data,
          success : function(res){
            fn && fn(res);
          },
          error   : function(err) {
            console.log(err);
          }
      });
    };

    // alert box
    alpha.prototype.alertBox = function(title, msg, url){
        var alert = document.createElement('div');
        var html = '<div class="alert animated fadeInDown">' +
                        '<div class="alert-head">' +
                            '<i class="fa fa-exclamation"></i>' +
                            '<span>'+title+'</span>' +
                            '<div class="controller"><a class="remove remove_alertBox"></a></div></div> <div class="alert-body">' +
                            '<p>'+msg+'</p> <a href="'+url+'" class="btn btn-success m-t-30 remove_alertBox" style="width: 60px;">OK</a></div></div>';
        alert.innerHTML = html;
        $(alert).attr({id: 'alert_box'});
        $('body').append(alert);
        this.closeAlert();
        return this;
    };

    // close alertBox
    alpha.prototype.closeAlert = function () {
        $('.remove_alertBox').on('click',function () {
            $('#alert_box').remove();
        });
        $('body').on('click',function () {
            $('#alert_box').remove();
        }).on('click','#alert_box',function (e) {
            var event = e || window.event;
            event.stopPropagation();
        });
    };

   // props
    alpha.prototype.props = function (target, direction,msg) {
        if(direction == 'up'){
          $(target).addClass('form-item-notification-up').attr('data-tooltip',msg);
        }else if(direction == 'right'){
          $(target).addClass('form-item-notification-right').attr('data-tooltip',msg);
        }else if(direction == 'down'){
          $(target).addClass('form-item-notification-down').attr('data-tooltip',msg);
        }else if(direction == 'left'){
          $(target).addClass('form-item-notification-left').attr('data-tooltip',msg);
        }else{
          $(target).removeClass('form-item-notification-up').removeAttr('data-tooltip');
          $(target).removeClass('form-item-notification-right').removeAttr('data-tooltip');
          $(target).removeClass('form-item-notification-down').removeAttr('data-tooltip');
          $(target).removeClass('form-item-notification-left').removeAttr('data-tooltip');
        }
    };

    // notification
    alpha.prototype.notification = function (type,msg) {
        var cType = type || 'information';
        var $nof = $('<div class="notification animation nof-'+cType+'">' +
          '<span class="fa fa-circle-o nof-head"></span><span>'+msg+'</span></div>');
        $('body').append($nof);
        $nof.animate({'right':0},700);
        setTimeout(function () {
            $nof.remove();
        },3000);
    };

    $.alpha = new alpha();
    $.alpha.Constructor = alpha;

})(window.jQuery);

// DEMO STUFF
$(document).ready(function () {

    $("#menu-collapse").click(function () {
        if ($('.page-sidebar').hasClass('mini')) {
            $('.page-sidebar').removeClass('mini');
            $('.page-content').removeClass('condensed-layout');
            $('.footer-widget').show();
        } else {
            $('.page-sidebar').addClass('mini');
            $('.page-content').addClass('condensed-layout');
            $('.footer-widget').hide();
        }
    });

    $(".simple-chat-popup").click(function () {
        $(this).addClass('hide');
        $('#chat-message-count').addClass('hide');
    });

    setTimeout(function () {
        $('#chat-message-count').removeClass('hide');
        $('#chat-message-count').addClass('animated bounceIn');
        $('.simple-chat-popup').removeClass('hide');
        $('.simple-chat-popup').addClass('animated fadeIn');
    }, 5000);
    setTimeout(function () {
        $('.simple-chat-popup').addClass('hide');
        $('.simple-chat-popup').removeClass('animated fadeIn');
        $('.simple-chat-popup').addClass('animated fadeOut');
    }, 8000);


    //***********************************END Grids*****************************



    //***********************************BEGIN Main Menu Toggle *****************************
    $('#layout-condensed-toggle').click(function () {
        if ($('#main-menu').attr('data-inner-menu') == '1') {
            //Do nothing
            console.log("Menu is already condensed");
        } else {
            if ($('#main-menu').hasClass('mini')) {
                $('body').removeClass('grey');
                $('body').removeClass('condense-menu');
                $('#main-menu').removeClass('mini');
                $('.page-content').removeClass('condensed');
                $('.scrollup').removeClass('to-edge');
                $('.header-seperation').show();
                //Bug fix - In high resolution screen it leaves a white margin
                $('.header-seperation').css('height', '61px');
                $('.footer-widget').show();
            } else {
                $('body').addClass('grey');
                $('#main-menu').addClass('mini');
                $('.page-content').addClass('condensed');
                $('.scrollup').addClass('to-edge');
                $('.header-seperation').hide();
                $('.footer-widget').hide();
                $('.main-menu-wrapper').scrollbar('destroy');
            }
        }
    });

    if ($.fn.sparkline) {
        $('.sparklines').sparkline('html', {
            enableTagOptions: true
        });
    }

});



//******************************* Bind Functions Jquery- LAYOUT OPTIONS API ***************

(function ($) {
    //Show/Hide Main Menu
    $.fn.toggleMenu = function () {
        var windowWidth = window.innerWidth;
        if(windowWidth >768){
            $(this).toggleClass('hide-sidebar');
        }
    };
    //Condense Main Menu
    $.fn.condensMenu = function () {
        var windowWidth = window.innerWidth;
        if(windowWidth >768){
            if ($(this).hasClass('hide-sidebar')) $(this).toggleClass('hide-sidebar');

            $(this).toggleClass('condense-menu');
            $(this).find('#main-menu').toggleClass('mini');
        }
    };
    //Toggle Fixed Menu Options
    $.fn.toggleFixedMenu = function () {
        var windowWidth = window.innerWidth;
        if(windowWidth >768){
        $(this).toggleClass('menu-non-fixed');
        }
    };

    $.fn.toggleHeader = function () {
        $(this).toggleClass('hide-top-content-header');
    };

    $.fn.toggleChat = function () {
        $.Webarch.toggleRightSideBar();
    };
    $.fn.layoutReset = function () {
        $(this).removeClass('hide-sidebar');
        $(this).removeClass('condense-menu');
        $(this).removeClass('hide-top-content-header');
        if(!$('body').hasClass('extended-layout'))
        $(this).find('#main-menu').removeClass('mini');
    };
    $.fn.toggleTradingDetail = function () {
        $.Webarch.toggleClass('hide');
    };

})(jQuery);


$(function() {
    'use strict';
    // Initialize layouts and plugins
    $.alpha.init();
});

// END--------------------------------------------------------------------

// common  datepicker--------------------------------------------------------------
$('.input-append.date').datepicker({
            autoclose: true,
            todayHighlight: true
   });
 
 $('#dp5').datepicker();
 
 $('#sandbox-advance').datepicker({
        format: "dd/mm/yyyy",
        startView: 1,
        daysOfWeekDisabled: "3,4",
        autoclose: true,
        todayHighlight: true
});

$('.my-colorpicker-control').colorpicker();

Date.prototype.Format = function (fmt) { //author: meizz
  var o = {
    "M+": this.getMonth() + 1, //月份
    "d+": this.getDate(), //日
    "h+": this.getHours(), //小时
    "m+": this.getMinutes(), //分
    "s+": this.getSeconds(), //秒
    "q+": Math.floor((this.getMonth() + 3) / 3), //季度
    "S": this.getMilliseconds() //毫秒
  };
  if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
  for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
  return fmt;
};
