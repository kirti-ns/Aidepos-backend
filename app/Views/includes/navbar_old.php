<style type="text/css">
   #imagePreviewProfile  {
    width: 40px;
    height: 40px;
    border-radius: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
  .avatar-upload .avatar-preview {
    width: 65px;
    height: 65px;
    position: relative;
    border-radius: 100%;
    border: 3px solid #F8F8F8;
    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
  }
  .avatar-upload .avatar-edit {
    position: absolute;
    right: -50px;
    z-index: 1;
    top: 10px;
  }
  .avatar-upload .avatar-edit input {
    display: none;
  }
  .avatar-upload .avatar-edit input + label {
    display: inline-block;
    /*width: 34px;
    height: 34px;*/
    margin-bottom: 0;
    /*border-radius: 100%;*/
    background: #FFFFFF;
    border: 1px solid F05624;
    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
    cursor: pointer;
    font-weight: normal;
    transition: all 0.2s ease-in-out;
  }
  .mt-15{
         margin-top: 15px;
  }
  .mt-12{
     margin-top: -12px;
  }
</style>
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
   <div class="navbar-wrapper">
      <div class="navbar-header border-bottom-nav border-right-nav">
         <ul class="nav navbar-nav flex-row">
            <li class="nav-item mobile-menu d-md-none mr-auto">
               <a class="nav-link nav-menu-main menu-toggle hidden-xs is-active" href="#"><i class="ft-menu font-large-1"></i></a>
            </li>
            <li class="nav-item d-none d-md-block">
               <a class="nav-link nav-menu-main menu-toggle hidden-xs admin-logo-a " href="#"><i class="ft-menu brand-text"></i></a>
            </li>
            <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
         </ul>
      </div>
      <div class="navbar-container content">
         <div class="collapse navbar-collapse" id="navbar-mobile" style="height: 61px;">
            <ul class="nav navbar-nav mr-auto float-left">
               <li class="nav-item">
                  <a class="navbar-brand" href="<?= base_url('dashboard')?>">
                     <img class="brand-logo admin-logo" alt="robust admin logo" src="<?= base_url()?>public/app-assets/images/logo/logo.png">
                     <!-- <h3 class="brand-text">Robust Admin</h3> -->
                  </a>
               </li>
               <li class="nav-item vertical-border" ></li>
               <?php if(session()->get('store_name')) { ?>
               <li class="nav-item">
                <span class="navbar-brand" style="padding-top: 30px;margin-left: 10px;">Logged In Store: <b><?=session()->get('store_name')?></b><?=session()->get('terminal_name')?', Terminal: <b>'.session()->get('terminal_name').'</b>' : '' ?></span>
               </li>
               <?php } ?>
               <li class="nav-item">
                  
               </li>
            </ul>
            <ul class="nav navbar-nav float-right">
              <li class=" dropdown dropdown-user nav-item ">
                  <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                     <div class="media">
                        <div class="media-body">
                           <h6 class="media-heading mb-0"><?= session()->get('isLoggedIn') ? session()->get('name') : ''?></h6>
                           <p class="media-sub-heading font-small-2 mb-0"><?= session()->get('isLoggedIn') ? session()->get('role_name') : ''?></p>
                        </div>
                        <?php
                        $f = session()->get('isLoggedIn') ? session()->get('name') : '';
                        $p =  session()->get('isLoggedIn') ? session()->get('profile') : '';
                        $n = mb_substr($f, 0, 1, "UTF-8");
                        $result = mb_strtoupper($n);
                        ?>
                        <div class="media-left">
                          <div class="avatar-preview">
                            <img  id="imagePreviewProfile" src="<?=GetImagePath(isset($p)?$p:'','employees')?>">
                          </div>
                        </div>
                     </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right nav-question mt-12">
                      <a class="dropdown-item" href="<?= base_url('/my-profile')?>"><i class="ft-user"></i> Profile</a>
                      <a class="dropdown-item change_password" href="#"><i class="ft-lock"></i> Change Password</a>
                      <a class="dropdown-item two_factor_auth" href="#"><i class="ft-check-square"></i> Two Factor Authentication</a>
                  </div>
              </li>
              <li class="nav-item vertical-border">
              </li>
              <li class="dropdown dropdown-notification nav-item mt-15">
                  <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i><span class="badge badge-pill badge-default badge-danger badge-default badge-up">5</span></a>
                  <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right" style="margin-top: -12px;">
                     <li class="dropdown-menu-header">
                        <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span></h6>
                        <span class="notification-tag badge badge-default badge-danger float-right m-0">5 New</span>
                     </li>
                     <li class="scrollable-container media-list w-100">
                        <a href="javascript:void(0)">
                           <div class="media">
                              <div class="media-body">
                                 <h6 class="text-bold-700">You have new order!</h6>
                                 <p class="notification-text font-small-3 text-muted">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                 <small>
                                 <time class="media-meta text-info" datetime="2015-06-11T18:29:20+08:00">30 min ago</time></small>
                              </div>
                           </div>
                        </a>
                        <a href="javascript:void(0)">
                           <div class="media">
                             <div class="media-body">
                                 <h6 class="text-bold-700">99% Server load</h6>
                                 <p class="notification-text font-small-3 text-muted">Aliquam tincidunt mauris eu risus.</p>
                                 <small>
                                 <time class="media-meta text-info" datetime="2015-06-11T18:29:20+08:00">5 hour ago</time></small>
                              </div>
                           </div>
                        </a>
                        <a href="javascript:void(0)">
                           <div class="media">
                             <div class="media-body">
                                 <p class="text-bold-700">Warning notifixation</p>
                                 <p class="notification-text font-small-3 text-muted">Vestibulum auctor dapibus neque.</p>
                                 <small>
                                 <time class="media-meta text-info" datetime="2015-06-11T18:29:20+08:00">Today</time></small>
                              </div>
                           </div>
                        </a>
                     </li>
                     <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="notification_list.php">View All Notifications</a></li>
                  </ul>
              </li>
              <li class="dropdown dropdown-notification  nav-item  mt-15">
                 <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="fa-solid fa-question"></i></a>
                  <div class="dropdown-menu nav-question mt-12" aria-labelledby="dropdown-flag">
                     <a class="dropdown-item" href="<?= base_url('faq');?>"><i class="fa fa-question-circle-o"></i> FAQ's</a>
                     <a class="dropdown-item" href="<?= base_url('send_email');?>"><i class="fa fa-envelope-open-o"></i> Send Email</a>
                     <a class="dropdown-item" href="<?= base_url('help_documents');?>"><i class="fa fa-file-o"></i> Help Documents</a>
                  </div>
              </li>
              <li class=" nav-item  mt-15"><a class="nav-link nav-link-label" href="<?= base_url('/logout')?>"><i class="fa-solid fa-right-from-bracket"></i></a>
              </li>
            </ul>
         </div>
      </div>
   </div>
</nav>