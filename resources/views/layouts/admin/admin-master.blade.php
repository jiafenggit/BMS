<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title') @section('after-title') 后台管理系统 @show </title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">


    <!-- Basic Styles -->
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/admin/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/admin/css/font-awesome.min.css">


    <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/admin/css/smartadmin-production-plugins.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/admin/css/smartadmin-production.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/admin/css/smartadmin-skins.min.css">

    <!-- SmartAdmin RTL Support  -->
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/admin/css/smartadmin-rtl.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/vendor/validation-engine/css/validationEngine.jquery.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/vendor/summernote/summernote.css">

    @section('page-css-file')

    @show

    <!-- Specifying a Webpage Icon for Web Clip
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
    <link rel="apple-touch-icon" href="/assets/admin/img/splash/sptouch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/admin/img/splash/touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/admin/img/splash/touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/admin/img/splash/touch-icon-ipad-retina.png">


    <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Startup image for web apps -->
    <link rel="apple-touch-startup-image" href="/assets/admin/img/splash/ipad-landscape.png"
          media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
    <link rel="apple-touch-startup-image" href="/assets/admin/img/splash/ipad-portrait.png"
          media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
    <link rel="apple-touch-startup-image" href="/assets/admin/img/splash/iphone.png"
          media="screen and (max-device-width: 320px)">

    <link href="/assets/admin/js/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ elixir('/admin/css/app.css') }}" rel="stylesheet"> --}}

    <script>
        var api = {
            loginPage: 'http://admin.laravelshop.com/login',
        }
    </script>

    <script type="text/javascript">
        window.onload=function () {
            if (navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE6.0"
                    || navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE7.0"
                    || navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE8.0"){
                var target=document.createElement("div");
                target.innerHTML = '<div style="position:fixed;left: 0;top: 0;z-index: 999;width: 100%">'+
                                '<div style="position: relative;width: 100%;height: 327px;background-color: #7ECDF4;margin-top: 20%;">'+
                        '<img src="/assets/theme_1/pc/resource/image/pic.png" alt="" style="position:absolute;left: 20%;top: -166px;FILTER: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=/pic2.png)">'+
                        '<a href="http://www.google.cn/intl/zh-CN/chrome/browser/" style="position: absolute;left: 20%;top: 252px;text-decoration: none;color: #0c9ee6;width: 126px;margin-left: 472px;color: #fff;font-size: 18px">前往下载</a>'+
                        '<a href="https://support.microsoft.com/zh-cn/help/18520/download-internet-explorer-11-offline-installer" style="position: absolute;left: 20%;top: 181px;text-decoration: none;color: #fff;width: 126px;margin-left: 472px;color:#0c9ee6;font-size: 18px ">前往下载</a>'+
                                '</div>'+
                        '</div>';
                document.body.appendChild(target);
            }
        }
    </script>
</head>
<body class="smart-style-2 @if(isset($_COOKIE['minified']) && !empty($_COOKIE['minified'])) minified @endif">

@section('header')
    {{--HEADER--}}
    {{--<header id="header">
        <div id="logo-group">

            <!-- PLACE YOUR LOGO HERE -->
            --}}{{--<span id="logo"> <img src="/assets/admin/img/logo.png" alt="SmartAdmin"> </span>--}}{{--
            <!-- END LOGO PLACEHOLDER -->

        </div>


        <!-- pulled right: nav area -->
        <div class="pull-right">


            <!-- logout button -->
            <div id="logout" class="btn-header transparent pull-right">
            <span> <a href="{{ url('/logout') }}" ><i
                            class="fa fa-sign-out">退出登录</i></a> </span>
            </div>
            <!-- end logout button -->


        </div>
        <!-- end pulled right: nav area -->

    </header>--}}
    {{--END OF HEADER--}}
@show

@section('left-panel')
    {{--Left panel : Navigation area--}}
    {{--Note: This width of the aside area can be adjusted through LESS variables--}}
    <aside id="left-panel" style="padding-top: 10px">
   
        <!-- User info -->
        <div class="login-info">
				<span> <!-- User image size is adjusted inside CSS, it should stay as it -->

					<a href="javascript:void(0);" >
                        <img src="/assets/admin/img/avatars/sunny.png" alt="me" class="online"/>
                        @if (Auth::guard('admin')->guest())
                            <span>
                                尚未登录
						    </span>
                        @else
                            <span>
							{{ Auth::guard('admin')->user()->name }}
						    </span>
                            <!-- <i class="fa fa-angle-down"></i> -->
                        @endif
                    </a>

				</span>
        </div>
        <!-- end user info -->

        <!-- NAVIGATION : This navigation is also responsive-->
        @section('nav-menu')
        @include('admin.partials.nav')
        @show
    </aside>
    
    {{--END NAVIGATION--}}
@show


@section('main-panel')
    {{--MAIN PANEL--}}
    <div id="main" role="main">

        <!-- RIBBON -->
        <div id="ribbon">

            @section('breadcumb')
            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>后台</li>
                <li>首页</li>
            </ol>
            <!-- end breadcrumb -->
            @show

            <!-- You can also add more buttons to the
            ribbon for further usability

            Example below:

            <span class="ribbon-button-alignment pull-right">
            <span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
            <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
            <span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
            </span> -->

        </div>
        <!-- END RIBBON -->

        <!-- MAIN CONTENT -->
        <div id="content">

            <!-- widget grid -->
            <section id="widget-grid" class="">

                <!-- row -->
                <div class="row">
                    @section('content')
                    待开发
                    @show
                </div>

                <!-- end row -->

            </section>
            <!-- end widget grid -->

        </div>
        <!-- END MAIN CONTENT -->

    </div>
    {{--END MAIN PANEL--}}
@show

@section('footer')
    {{--PAGE FOOTER --}}
    <!-- <div class="page-footer">
        <div class="row">

        </div>
    </div> -->
    {{-- END PAGE FOOTER --}}
@show

@section('shortcut')
    <div id="shortcut">
        <ul>
            <li>
                <a href="inbox.html" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i
                                class="fa fa-envelope fa-4x"></i> <span>Mail <span
                                    class="label pull-right bg-color-darken">14</span></span> </span> </a>
            </li>
            <li>
                <a href="calendar.html" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span
                            class="iconbox"> <i class="fa fa-calendar fa-4x"></i> <span>Calendar</span> </span> </a>
            </li>
            <li>
                <a href="gmap-xml.html" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i
                                class="fa fa-map-marker fa-4x"></i> <span>Maps</span> </span> </a>
            </li>
            <li>
                <a href="invoice.html" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i
                                class="fa fa-book fa-4x"></i> <span>Invoice <span
                                    class="label pull-right bg-color-darken">99</span></span> </span> </a>
            </li>
            <li>
                <a href="gallery.html" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i
                                class="fa fa-picture-o fa-4x"></i> <span>Gallery </span> </span> </a>
            </li>
            <li>
                <a href="profile.html" class="jarvismetro-tile big-cubes selected bg-color-pinkDark"> <span
                            class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>My Profile </span> </span> </a>
            </li>
        </ul>
    </div>
    {{--END SHORTCUT AREA--}}
@show

@section('base-js-files')
    <script src="/assets/admin/js/libs/jquery-2.1.1.min.js"></script>
    <script src="/assets/admin/js/libs/jquery-ui-1.10.3.min.js"></script>
@show

@section('addon-js-files')

    <script src="/assets/admin/js/app.config.js"></script>

    <!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
    <script src="/assets/admin/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script>

    <!-- BOOTSTRAP JS -->
    <script src="/assets/admin/js/bootstrap/bootstrap.min.js"></script>

    <!-- CUSTOM NOTIFICATION -->
    <script src="/assets/admin/js/notification/SmartNotification.min.js"></script>

    <!-- JARVIS WIDGETS -->
    <script src="/assets/admin/js/smartwidgets/jarvis.widget.min.js"></script>

    <!-- EASY PIE CHARTS -->
    <script src="/assets/admin/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

    <!-- SPARKLINES -->
    <script src="/assets/admin/js/plugin/sparkline/jquery.sparkline.min.js"></script>

    <!-- JQUERY VALIDATE -->
    <script src="/assets/admin/js/plugin/jquery-validate/jquery.validate.min.js"></script>

    <!-- JQUERY MASKED INPUT -->
    <script src="/assets/admin/js/plugin/masked-input/jquery.maskedinput.min.js"></script>

    <!-- JQUERY SELECT2 INPUT -->
    <script src="/assets/admin/js/select2/dist/js/select2.min.js"></script>

    <!-- JQUERY UI + Bootstrap Slider -->
    <script src="/assets/admin/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

    <!-- browser msie issue fix -->
    <script src="/assets/admin/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

    <!-- FastClick: For mobile devices -->
    <script src="/assets/admin/js/plugin/fastclick/fastclick.min.js"></script>

    <script src="/assets/admin/js/plugin/fastclick/fastclick.min.js"></script>

    <script src="/assets/vendor/validation-engine/js/languages/jquery.validationEngine-zh_CN.js"></script>
    <script src="/assets/vendor/validation-engine/js/jquery.validationEngine.js"></script>
    <script src="/assets/vendor/layer2.4/layer/layer.js"></script>
    <script src="/assets/vendor/jquery-cookie/jquery.cookie.js"></script>

    <!-- MAIN APP JS FILE -->
    <script src="/assets/admin/js/app.min.js"></script>

    <script src="/assets/admin/js/admin.js"></script>
@show

@section('page-js-file')

@show

    <script>
        $(document).ready(function () {

            // DO NOT REMOVE : GLOBAL FUNCTIONS!
            pageSetUp();

            /*
             * PAGE RELATED SCRIPTS
             */

        });

        jQuery(document).ready(function(){
            jQuery("#form").validationEngine();

            // $('#form').on('submit',function(){
            //     alert(jQuery("#form").validationEngine('validate'));
            //     return false;
            // });
        });

    </script>

    <script>
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var success='{{Session::get("success")}}';
        var message='{{Session::get("message")}}';
        if(success==1){
            $.smallBox({
                title : "操作成功",
                content : message,
                color : "#739E73",
                iconSmall : "fa fa-check fa-2x fadeInRight animated",
                timeout : 3000
            }); 
        }else if(success==-1){
            $.smallBox({
                title : "操作失败",
                content : message,
                color : "#C46A69",
                iconSmall : "fa fa-check fa-2x fadeInRight animated",
                timeout : 3000
            }); 
        }
    });

    // var minified=!$.cookie('minified')?false:true;

    // if(minified){
    //     $('body').addClass('minified');
    // }

    $('.minifyme').click(function(){
        if($('body').hasClass('minified')){
            $('body').removeClass('minified');
            $.removeCookie('minified');
        }else{
            $('body').addClass('minified');
            $.cookie('minified', 'true', { expires: 30, path: '/' });
        }
    });
    </script>

    @if(count($errors)>0)
    <?php
        $error_message='';
    ?>
    @foreach($errors->all() as $k=>$v)
        <?php $error_message.=($k+1).".".$v."<br/>"; ?>
    @endforeach
    
    <script>
        $(function(){
            $.smallBox({
                title : "操作失败",
                content : '{!!$error_message!!}',
                color : "#C46A69",
                iconSmall : "fa fa-check fa-2x fadeInRight animated",
                timeout : 3000
            }); 
        });
    </script>
    @endif

@section('page-script')
    
@show

</body>
</html>
