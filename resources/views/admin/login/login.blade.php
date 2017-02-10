
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title> 大王椰微信商城管理系统 </title>
    <meta name="description" content="">
    <meta name="author" content="">

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


    
    <script>
        var api = {
            loginPage: '',
        }
    </script>
</head>
<body>

        <header id="header">

        <div id="logo-group">
            <span id="logo"> <img src="/assets/admin/img/logo.png" alt="大王椰微信商城管理系统"> </span>
        </div>


    </header>
    

    <div id="main" role="main" style="margin-left:0;">

        <!-- MAIN CONTENT -->
        <div id="content" class="container-fluid">

            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                    <div class="well no-padding">
                        <form action="/login" method="post" id="login-form" class="smart-form client-form">
                            <header>
                                登录
                            </header>

                            <fieldset>

                                <input type="hidden" name="_token" value="moxA55rw4rlIRIb2S2kVIq30ZKPXAKWjT1uqZypC">
                                <section>
                                    <label class="label">用户名</label>
                                    <label class="input"> <i class="icon-append fa fa-user"></i>
                                        <input type="text" name="name">
                                        <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i>
                                            管理员帐号</b></label>
                                </section>

                                <section>
                                    <label class="label">密码</label>
                                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                                        <input type="password" name="password">
                                        <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i>
                                            请输入密码</b> </label>
                                    <div class="note">
                                                                            </div>
                                </section>

                                <section>
                                    <label class="checkbox">
                                        <input type="checkbox" name="remember" value="1">
                                        <i></i>记住我</label>
                                </section>
                            </fieldset>
                            <footer>
                                {{csrf_field()}}
                                <button type="submit" class="btn btn-primary">
                                    登录
                                </button>
                            </footer>
                        </form>

                    </div>

                </div>
            </div>
        </div>

    </div>

        <div class="page-footer">
        <div class="row">

        </div>
    </div>
    
    <script src="/assets/admin/js/libs/jquery-2.1.1.min.js"></script>
    <script src="/assets/admin/js/libs/jquery-ui-1.10.3.min.js"></script>


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
    <script src="/assets/admin/js/plugin/select2/select2.min.js"></script>

    <!-- JQUERY UI + Bootstrap Slider -->
    <script src="/assets/admin/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

    <!-- browser msie issue fix -->
    <script src="/assets/admin/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

    <!-- FastClick: For mobile devices -->
    <script src="/assets/admin/js/plugin/fastclick/fastclick.min.js"></script>



    <!-- MAIN APP JS FILE -->
    <script src="/assets/admin/js/app.min.js"></script>

    

    <script src="/assets/vendor/jquery.form/jquery.form.js"></script>

    <script>
        $(document).ready(function () {

            // DO NOT REMOVE : GLOBAL FUNCTIONS!
            pageSetUp();

            // Validation
            $("#login-form").validate({
                // Rules for form validation
                rules: {
                    name: {
                        required: true,
                        minlength: 1,
                        maxlength: 20
                    },
                    password: {
                        required: true,
                        minlength: 1,
                        maxlength: 20
                    }
                },

                // Messages for form validation
                messages: {
                    name: {
                        required: '请输入账号'
                    },
                    password: {
                        required: '请输入密码'
                    }
                },

                // Do not change code below
                errorPlacement: function (error, element) {
                    error.insertAfter(element.parent());
                },
                submitHandler: function (form) {
                    $(form).ajaxSubmit({
                        type: "post",
                        dataType: "json",
                        success: function (res) {
                            if (res.error == 0) {
                                location.href = res.redirect_url;
                            }else{
                                $.smallBox({
                                    title : "登录失败",
                                    content : res.msg,
                                    color : "#C46A69",
                                    iconSmall : "fa fa-check fa-2x fadeInRight animated",
                                    timeout : 3000
                                }); 
                            }
                        }
                    });

                }

            });
            /*
             * PAGE RELATED SCRIPTS
             */

        });

    </script>

</body>
</html>
