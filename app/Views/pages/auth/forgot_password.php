<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
    <!-- Mirrored from pixinvent.com/bootstrap-admin-template/robust/html/ltr/vertical-menu-template/recover-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Jul 2022 06:14:15 GMT -->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
        <meta name="description" content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template." />
        <meta name="keywords" content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard" />
        <meta name="author" content="PIXINVENT" />
        <title>Aidepos - <?= $data['title'];?></title>
        <link rel="apple-touch-icon" href="<?=base_url()?>/public/app-assets/images/ico/apple-icon-120.png" />
        <link rel="shortcut icon" type="image/x-icon" href="https://pixinvent.com/bootstrap-admin-template/robust/app-assets/images/ico/favicon.ico" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CMuli:300,400,500,700" rel="stylesheet" />
        <!-- BEGIN VENDOR CSS-->
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>/public/app-assets/css/vendors.min.css" />
        <!-- END VENDOR CSS-->
        <!-- BEGIN ROBUST CSS-->
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>/public/app-assets/css/app.min.css" />
        <!-- END ROBUST CSS-->
        <!-- BEGIN Page Level CSS-->
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>/public/app-assets/css/core/menu/menu-types/vertical-menu.min.css" />
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>/public/app-assets/css/core/colors/palette-gradient.min.css" />
        <!-- END Page Level CSS-->
        <!-- BEGIN Custom CSS-->
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>/public/assets/css/style.css" />
        <!-- END Custom CSS-->
        <!-- alert message start -->
         <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/vendors/css/extensions/toastr.css">
         <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/css/plugins/extensions/toastr.min.css">
    </head>
    <body class="vertical-layout vertical-menu 1-column menu-expanded blank-page blank-page" data-open="click" data-menu="vertical-menu" data-col="1-column">
        <!-- ////////////////////////////////////////////////////////////////////////////-->
        <div class="app-content content">
            <div class="content-wrapper">
                <div class="content-header row"></div>
                <div class="content-body">
                    <section class="flexbox-container">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <div class="col-md-6 col-8 box-shadow-2 p-0">
                                <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                                    <div class="card-header border-0 pb-0">
                                        <div class="card-title">
                                            <img src="<?=base_url()?>/public/app-assets/images/logo/logo.png" alt="branding logo" />
                                        </div>
                                        <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>We will send you a link to reset password.</span></h6>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form method="post" class="form-horizontal" id="forgot_password_form" name="forgot_password_form" action="<?= base_url('post-forgot-password')?>" >
                                                <input type="hidden" name="action" id="action" value="post-forgot_password">
                                                <input type="hidden" name="table_name" id="table_name" value="employee">
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="email" class="form-control form-control-lg input-lg" id="email" name="email" placeholder="Your Email Address" value="">
                                                    <div class="form-control-position">
                                                        <i class="ft-mail"></i>
                                                    </div>
                                                </fieldset>
                                                <button type="submit" id="btnSubmit" class="btn btn-outline-info btn-lg btn-block"><i class="ft-unlock"></i> Recover Password</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-footer border-0">
                                        <p class="float-sm-left text-center"><a href="<?=base_url('login')?>" class="card-link">Login</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!-- ////////////////////////////////////////////////////////////////////////////-->

        <!-- BEGIN VENDOR JS-->
        <script src="<?=base_url()?>/public/app-assets/vendors/js/vendors.min.js"></script>
        <!-- BEGIN VENDOR JS-->
        <!-- BEGIN PAGE VENDOR JS-->
        <script src="<?=base_url()?>/public/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
        <!-- END PAGE VENDOR JS-->
        <!-- BEGIN ROBUST JS-->
        <script src="<?=base_url()?>/public/app-assets/js/core/app-menu.min.js"></script>
        <script src="<?=base_url()?>/public/app-assets/js/core/app.min.js"></script>
        <!-- END ROBUST JS-->
        <!-- BEGIN PAGE LEVEL JS-->
        <script src="<?=base_url()?>/public/app-assets/js/scripts/forms/form-login-register.min.js"></script>
        <script src="<?= base_url()?>/public/app-assets/vendors/js/extensions/toastr.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
        <?= view('includes/login_js.php');?>
        <!-- END PAGE LEVEL JS-->
    </body>

    <!-- Mirrored from pixinvent.com/bootstrap-admin-template/robust/html/ltr/vertical-menu-template/recover-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Jul 2022 06:14:15 GMT -->
</html>
