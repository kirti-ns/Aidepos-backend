<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta name="description" content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template.">
      <meta name="keywords" content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
      <meta name="author" content="PIXINVENT">
      <title>Aidepos - <?= $data['title'];?></title>
      <link rel="apple-touch-icon" href="../public/app-assets/images/ico/apple-icon-120.png">
      <link rel="shortcut icon" type="image/x-icon" href="https://pixinvent.com/bootstrap-admin-template/robust/public/app-assets/images/ico/favicon.ico">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CMuli:300,400,500,700" rel="stylesheet">
      <!-- BEGIN VENDOR CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url();?>/public/app-assets/css/vendors.min.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/vendors/css/extensions/unslider.css">
      <!-- END VENDOR CSS-->
      <!-- BEGIN ROBUST CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/app.min.css">
      <!-- END ROBUST CSS-->
      <!-- BEGIN Page Level CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/core/menu/menu-types/vertical-menu.min.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/core/colors/palette-gradient.min.css">
      <!-- END Page Level CSS-->
      <!-- BEGIN Custom CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/menu/login.css">
      
      <!-- END Custom CSS-->

      <!-- input css -->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/vendors/css/ui/jquery-ui.min.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/plugins/ui/jqueryui.css">
     <!-- alert message start -->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/vendors/css/extensions/toastr.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/plugins/extensions/toastr.min.css">
      <!-- alert message end -->
      <style type="text/css">
        .card-header {
          padding: 1rem;
        }
         .mrg-h2 {
         margin: 20px 0px -10px 8px;
         font-weight: 700;
         font-weight: 700;
         font-size: 30px;
         line-height: 37px;
         color: #222222;
         }
         .mrg-left {
         margin-left: 10px;
         }
         .mrg-btn {
         margin: -13px 5px 22px 30px;
         }
         .btn-default {
         border-color: none;
         background-color: none;
         outline: none;
         }
         .mrg-form {
         margin: 15px 0px 0px 10px;
         }
         button:active {
         background-color: FFF6F2;
         color: FF5400;
         }
         .border-color {
         border-color: #FF5400;
         background-color: #FFF6F2;
         color: #FF5400;
         }
         .btn-col {
         background-color: #1A4170;
         color: #ffffff;
         margin: 20px 0px 0px 0px;
         }
         .rec-pwd {
         color: #767676;
         float: right;
         font-family: 'Montserrat';
         font-style: normal;
         font-weight: 500;
         font-size: 14px;
         line-height: 17px;
         /* identical to box height */
         }
         .colour{
         color: #767676;
         }
         .checkbox-left {
         float: left;
         font-family: 'Montserrat';
         font-style: normal;
         font-weight: 500;
         font-size: 14px;
         line-height: 17px;
         /* identical to box height */
         color: #222222;
         }
         .check-left {
         float: left;
         }
         .vertical-line{
         display: inline-block;
         border-left: 1px solid #D4D4D4;
         height: auto;
         }
         .d1{
         font-family: 'Montserrat';
         font-weight: 600;
         font-size: 22px;
         line-height: 27px;
         color: #222222;
         }
         .d2{
         font-family: 'Montserrat';
         font-style: normal;
         font-weight: 400;
         font-size: 16px;
         line-height: 20px;
         text-align: center;
         color: #767676;
         margin-top: 5px;
         }
         .log{
         font-weight: 400;
         font-size: 18px;
         line-height: 22px;
        color: #767676;
         }
       .box-shadow-2 {
            width: 1049.61px;
    height: 560px;
       }
       .mx-auto {
        margin-top: 25px;
       }
       html body.fixed-navbar {
    padding-top: 0;
}
.ui-button {
        padding: 0.5em 2.5em 0.5em 2.5em;
      }
    .ui-button:active, a.ui-button:active{
      border: 1px solid #FF5400;
    background: #FF5400;
    }
    #togglePassword{
          float: right;
          cursor: pointer;
          padding: 21px 20px 0px 0px;
    }
      </style>
      <!-- END Custom CSS-->
   </head>
   <body class="1-column fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="1-column">
      <!-- fixed-top-->
      <!-- ////////////////////////////////////////////////////////////////////////////-->
      <div class="app-content content">
         <div class="content-wrapper">
            <div class="content-header row"></div>
            <div class="content-body">
               <section class="flexbox-container">
                  <div class="d-flex align-items-center justify-content-center">
                     <div class="row box-shadow-2 p-0">
                        <div class="col-md-7 card border-grey border-lighten-3 m-0 text-left col">
                           <div>
                              <div class="card-header border-0  mrg-left">
                                 <div class="card-title">
                                    <img src="<?= base_url()?>/public/app-assets/images/logo/logo.jpg" alt="branding logo">
                                 </div>
                                 <div>
                                    <h2 class="mrg-h2">
                                       <b>Reset Password</b>
                                    </h2>
                                 </div>
                                 <div class="card-subtitle text-muted font-small-4 pt-2 mrg-left log" style="    padding-top: 1.5rem!important;">
                                    <!-- <p>Please enter your Email</p><p><b>Reset Password</b></p> -->
                                 </div>
                              </div>
                              <div class="card-content mrg-left">
                                 
                                 <div class="card-body pt-0 mrg-form">
                                    <form method="post" class="form-horizontal" id="forgot_password_form" name="forgot_password_form" action="<?= base_url('post-forgot-password')?>" >
                                       <input type="hidden" name="action" id="action" value="post-forgot_password">
                                       <input type="hidden" name="table_name" id="table_name" value="employee">
                                        <fieldset class="">
                                </fieldset>
                                <div class="row">
                                       <div class="col-md-12 mb-1">
                                          <div class="form-floating">
                                             <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="" >
                                             <!-- <div><i class="ft-mail prefix grey-text"></i></div> -->
                                             <label for="email">Email</label>
                                          </div>
                                       </div>
                                 </div>
                                       <!-- <div class="md-form">
                                <i class="ft-mail prefix grey-text"></i>
                                <input type="text" id="defaultForm-email" class="form-control" value="tanya.hill@example.com">
                                <label for="defaultForm-email" class="input-text">Email</label>
                               </div> -->
                                       <div class="row">
                                          <div class="col-md-6 checkbox-left">
                                             <!-- <input type="checkbox" class="" name="Remember_me"> Remember me -->
                                          </div>
                                          <div class="col-md-6 check-left">
                                             <!-- <a href="recover-password.html" class="rec-pwd">Reset password?</a> -->
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class="col-md-6 checkbox-left">
                                             <!-- <input type="checkbox" class="" name="Remember_me"> Remember me -->
                                          </div>
                                          <!-- <div class="col-md-6 check-left">
                                            <a href="<?= base_url('login')?>" class="rec-pwd">Login Here</a>
                                          </div> -->
                                       </div>
                                       <button type="submit" id="btnSubmit" class="btn btn-lg btn-block btn-col">
                                       SEND OTP </button>
                                    </form>
                                 </div>
                                 <div class="text-center">
                                    <!-- <a href="#" class="colour d2">Terms and Conditions  </a> -->
                                    <span class=""  class="colour d2"></span>
                                    <!-- <a href="#" class="colour d2">Privacy Policies</a> -->
                                 </div>
                               
                                 <div class="text-center colour d2">
                                    <!-- <div>Powered by AIDEPOS</div> -->
                                   </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-5 card border-grey border-lighten-3 m-0">
                           <div class=" card">
                              <div class="card-content">
                                 <div class="card-body">
                                    <div class="" style="height: 65px;">
                                    </div>
                                    <div class="mx-auto form-group" >
                                       <div id="automcatic-anim-slider" style="height: 272.4px;">
                                          <ul>
                                             <li><img src="<?= base_url()?>/public/app-assets/images/carousel/i1.jpg" alt="01" class="img-fluid" ></li>
                                             <li><img src="<?= base_url()?>/public/app-assets/images/carousel/i2.jpg" alt="02" class="img-fluid" ></li>
                                             <li><img src="<?= base_url()?>/public/app-assets/images/carousel/i3.jpg" alt="03" class="img-fluid" ></li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-12 text-center d1">
                                    Dummy text of the app
                                 </div>
                                 <div class="col-md-12 text-center d2">
                                    It is a long established fact that a reader will be distracted by the readable content
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </section>
            </div>
         </div>
      </div>
   </body>
</html>
<!-- BEGIN VENDOR JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->  
<script src="<?= base_url()?>/public/app-assets/vendors/js/extensions/unslider-min.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="<?= base_url()?>/public/app-assets/js/core/app-menu.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/js/core/app.min.js"></script>
<!-- <script src="<?= base_url()?>/public/app-assets/js/scripts/customizer.min.js"></script> -->
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="<?= base_url()?>/public/app-assets/js/scripts/extensions/unslider.min.js"></script>
<!-- END PAGE LEVEL JS-->
<!-- alert message start -->
<script src="<?= base_url()?>/public/app-assets/vendors/js/extensions/toastr.min.js"></script>
<!-- alert message end -->
<script src="<?= base_url()?>/public/app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<?= view('includes/login_js.php');?> 
<script>
    $(document).ready(function(){
    $(document).on('click', '#togglePassword', function() {

       $(this).toggleClass("ft-eye-off ft-eye");
       
       var input = $("#password");
       input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
       });
   });
</script>