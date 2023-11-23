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
            <li class="nav-item">
              <a class="navbar-brand" href="<?= base_url('dashboard')?>">
                <img class="brand-logo" alt="robust admin logo" src="<?= base_url()?>public/app-assets/icons/logo.png">
                <h3 class="brand-text">AIDEPOS</h3>
              </a>
            </li>
            <!-- <li class="nav-item d-none d-md-block">
               <a class="nav-link nav-menu-main menu-toggle hidden-xs admin-logo-a" href="#"><i class="ft-menu brand-text"></i></a>
            </li> -->
            <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
         </ul>
      </div>
      <div class="navbar-container content">
         <div class="collapse navbar-collapse" id="navbar-mobile" style="height: 61px;">
            <ul class="nav navbar-nav mr-auto float-left">
              <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu">         </i></a></li>
               <!-- <li class="nav-item">
                  <a class="navbar-brand" href="<?= base_url('dashboard')?>">
                     <img class="brand-logo admin-logo" alt="robust admin logo" src="<?= base_url()?>public/app-assets/images/logo/logo.png">
                  </a>
               </li> -->
               <!-- <li class="nav-item vertical-border" ></li> -->
               <?php if(session()->get('store_name')) { ?>
               <li class="nav-item">
                <span class="navbar-brand" style="padding-top: 22px;margin-left: 10px;">Logged In Store: <b><?=session()->get('store_name')?></b><?=session()->get('terminal_name')?', Terminal: <b>'.session()->get('terminal_name').'</b>' : '' ?></span>
               </li>
               <?php } ?>
               <li class="nav-item">
                  
               </li>
            </ul>
            <ul class="nav navbar-nav float-right">
              <li class=" dropdown dropdown-user nav-item ">
                  <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                     <div class="media">
                        <div class="media-body" style="width: auto">
                           <h6 class="media-heading mb-0"><?= session()->get('isLoggedIn') ? session()->get('name') : ''?></h6>
                           <p class="media-sub-heading font-small-2 mb-0">Agent</p>
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
              <li class=" nav-item  mt-15"><a class="nav-link nav-link-label" href="<?= base_url('/logout')?>"><i class="fa-solid fa-right-from-bracket"></i></a>
              </li>
            </ul>
         </div>
      </div>
   </div>
</nav>