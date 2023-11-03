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
      <link rel="apple-touch-icon" href="<?= base_url()?>public/app-assets/icons/logo.png">
      <link rel="shortcut icon" type="image/x-icon" href="<?= base_url()?>public/app-assets/icons/logo.png">
      <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,600,600i,700,700i%7CMuli:300,400,500,700" rel="stylesheet">
      <!-- BEGIN VENDOR CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/vendors.min.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/vendors/css/extensions/unslider.css">
      <!-- END VENDOR CSS-->
      <!-- BEGIN ROBUST CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/app.min.css">
      <!-- END ROBUST CSS-->
      <!-- BEGIN Page Level CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/core/menu/menu-types/vertical-menu.min.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/core/colors/palette-gradient.min.css">
      <!-- END Page Level CSS-->
      <!-- input css -->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/vendors/css/ui/jquery-ui.min.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/plugins/ui/jqueryui.css">
      <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/css/mdb.min.css"> -->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/menu/login.css">
     
      <!-- alert message start -->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/vendors/css/extensions/toastr.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/plugins/extensions/toastr.min.css">
      <!-- alert message end -->
      <!-- END Custom CSS-->
   </head>
   <style>
   body{
      background-image: url("<?= base_url()?>/public/app-assets/images/logo/full_img.png");
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
   }
   .main-content {
      width: 60%;
      margin: 5em auto;
   }
   .input-icons i {
      position: absolute;
   }
    
   .input-icons {
      width: 100%;
      margin-bottom: 10px;
   }
    
   .icon {
      padding: 10px;
      color: green;
      min-width: 50px;
      text-align: center;
   }
   </style>
   <body>
      <div class="app-content content">
         <div class="content-wrapper">
            <div class="content-header row"></div>
            <div class="content-body">
               <div class="row">
                  <div class="col-md-12">
                     <section class="flexbox-container">
                        <div class="d-flex align-items-center justify-content-center">
                           <div class="row box-shadow-2 p-0" style="margin: 15px;">
                              <div class="col-md-7 card border-grey border-lighten-3 m-0 text-left col">
                                 <div>
                                    <div class="card-header border-0  mrg-left">
                                       <div class="card-title">
                                          <img src="<?= base_url()?>/public/app-assets/images/logo/logo.jpg" alt="branding logo">
                                       </div>
                                       <div>
                                          <h2 class="mrg-h2">
                                             <b>Welcome Back</b>
                                          </h2>
                                       </div>
                                       <div class="card-subtitle text-muted font-small-4 pt-2 mrg-left log" style="padding-top: 1.5rem!important;">
                                          <p>Log in to your account using email and password</p>
                                       </div>
                                    </div>
                                    <div class="card-content mrg-left">
                                       <div class="card-body pt-0 mrg-form">
                                          <form method="post" class="form-horizontal" id="login_form" name="login_form" action="<?= base_url('post-login')?>">
                                             <input type="hidden" name="action" id="action" value="post-login">
                                             <input type="hidden" name="table_name" id="table_name" value="employee">
                                             <fieldset class="mb-1">
                                                <label for="merchant">Merchant</label>
                                                <input type="radio" checked name="role_id" value="2" id="merchant" class="jui-ni-radio-buttons">
                                                <label for="staff">Staff</label>
                                                <input type="radio" name="role_id" value="3" id="staff" class="jui-ni-radio-buttons">
                                                <label for="agent">Agent</label>
                                                <input type="radio" name="role_id" value="4" id="agent" class="jui-ni-radio-buttons">
                                             </fieldset>
                                             <div class="row">
                                             <div class="col-md-12 mb-1">
                                                <div class="form-floating">
                                                   <div class="form-control-left-position">
                                                     <i class="ft-mail prefix grey-text"></i>
                                                   </div>
                                                
                                                   <input type="email" class="form-control" style="padding-left: calc(2.1em + 0.75rem);" id="email" name="email" placeholder="Email" value="" >
                                                   <!-- <div><i class="ft-mail prefix grey-text"></i></div> -->
                                                   <label for="email" style="padding-left: calc(2.5em + 0.75rem);">Email</label>
                                                </div>
                                             </div>
                                             <div class="col-md-12 mb-1">
                                                <div class="form-floating">
                                                  <div class="form-control-left-position">
                                                     <i class="ft-lock prefix grey-text"></i>
                                                   </div>
                                                   <input type="password" class="form-control" style="padding-left: calc(2.1em + 0.75rem);" id="password" name="password" placeholder="Password" value="" >
                                                   <div class="form-control-position">
                                                   <i class="ft-eye" id="togglePassword"></i>
                                                   </div>
                                                   <label for="password" style="padding-left: calc(2.5em + 0.75rem);">Password</label>
                                                </div>
                                             </div>
                                             </div>
                                            
                                             <div class="row">
                                                <div class="col-md-6 checkbox-left">
                                                <div class="form-group">
                                                <input type="checkbox" name="remember_me" id="remember_me" value="1"  >
                                                <label for="remember_me">Remember me</label>
                                                
                                             </div>
                                                   
                                                </div>
                                                <div class="col-md-6 check-left">
                                                   <a href="<?= base_url('forgot_password')?>" class="rec-pwd">Forgot Password?</a>
                                                </div>
                                             </div>
                                             <button type="submit" id="btnSubmit" class="btn btn-lg btn-block btn-col">
                                             Login</button>
                                          </form>
                                       </div>
                                       <div class="text-center">
                                          <a href="#" class="colour d2 pr-1">Terms & Conditions  </a>
                                          <span class="colour d2">|</span>
                                          <a href="#" class="colour d2 pl-1">Privacy Policies</a>
                                       </div>
                                       <div class="text-center colour d2 mb-1 mt-1 ">
                                          <div>Powered by AIDEPOS</div>
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
                                             <div id="automcatic-anim-slider" style="height: 272.4px; ">
                                                <ul>
                                                   <li><img src="<?= base_url()?>/public/app-assets/images/carousel/i1.jpg" alt="01" class="img-fluid"></li>
                                                   <li><img src="<?= base_url()?>/public/app-assets/images/carousel/i2.jpg" alt="02" class="img-fluid"></li>
                                                   <li><img src="<?= base_url()?>/public/app-assets/images/carousel/i3.jpg" alt="03" class="img-fluid"></li>
                                                </ul>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-12 text-center d1">                            Dummy text of the app
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
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="<?= base_url()?>/public/app-assets/js/scripts/extensions/unslider.min.js"></script>
<!-- END PAGE LEVEL JS-->
<!-- Login Page input-->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/js/mdb.min.js"></script> -->
<!-- LOgin page end -->
<script src="<?= base_url()?>/public/app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/js/scripts/ui/jquery-ui/buttons-selects.min.js"></script>
<!-- alert message start -->
<script src="<?= base_url()?>/public/app-assets/vendors/js/extensions/toastr.min.js"></script>
<!-- alert message end -->
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