 <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow border-bottom-nav">
         <div class="navbar-wrapper">
            <div class="navbar-header border-bottom-nav border-right-nav">
               <ul class="nav navbar-nav flex-row">
                  <li class="nav-item mobile-menu d-md-none mr-auto">
                     <a class="nav-link nav-menu-main menu-toggle hidden-xs is-active" href="#"><i class="ft-menu font-large-1"></i></a>
                  </li>
                  <li class="nav-item d-none d-md-block">
                     <a class="nav-link nav-menu-main menu-toggle hidden-xs admin-logo-a" href="#"><i class="ft-menu brand-text"></i></a>
                  </li>
                  <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
               </ul>
            </div>
            <div class="navbar-container content">
               <div class="collapse navbar-collapse" id="navbar-mobile" style="height: 61px;">
                  <ul class="nav navbar-nav mr-auto float-left">
                     <li class="nav-item">
                        <a class="navbar-brand" href="index.php">
                           <img class="brand-logo admin-logo" alt="robust admin logo" src="<?= base_url()?>/app-assets/images/logo/logo.png">
                           <!-- <h3 class="brand-text">Robust Admin</h3> -->
                        </a>
                     </li>
                     <li class="nav-item vertical-border" style="height:40px;"></li>
                     <!--  <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li> -->
                     <li class="nav-item nav-search">
                        <a class="nav-link nav-link-search" href="#" style="padding-top:30px;padding-right: 0px;"><i class="ficon ft-search"></i></a>
                        <div class="search-input open">
                           <input class="input search-input-div border-bottom-0" type="text" placeholder="Search Everything...">
                        </div>
                     </li>
                  </ul>
                  <?php //$user = GetUserProfile(); ?>
                  <ul class="nav navbar-nav float-right">
                     <li class=" dropdown dropdown-user nav-item ">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                           <div class="media">
                              <div class="media-body">
                                 <h6 class="media-heading mb-0">Tanya Hill</h6>
                                 <p class="media-sub-heading font-small-2 mb-0">Aidepos Admin</p>
                              </div>
                              <div class="media-left ">
                                 <span class="user-profile rounded-circle">TH</span>
                              </div>
                           </div>
                           <!-- <span class="avatar avatar-online"><img src="../app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"><i></i></span> -->
                        </a>
                           <div class="dropdown-menu dropdown-menu-right nav-question">
                              <a class="dropdown-item" href="<?= base_url("profile/profile")?>"><i class="ft-user"></i> Profile</a>
                              <a class="dropdown-item change_password" href="#"><i class="ft-lock"></i> Change Password</a>
                              <a class="dropdown-item two_factor_auth" href="#"><i class="ft-check-square"></i> Two Factor Authentication</a>
                </div>
                     </li>
                     <li class="nav-item vertical-border">
                     </li>
                     <li class="dropdown dropdown-notification nav-item">
                        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i><span class="badge badge-pill badge-default badge-danger badge-default badge-up">5</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
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
                     <li class="dropdown dropdown-notification  nav-item ">
                        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="fa-solid fa-question"></i></a>
                        <div class="dropdown-menu nav-question" aria-labelledby="dropdown-flag">
                           <a class="dropdown-item" href="faq.php"><i class="fa fa-question-circle-o"></i> FAQ's</a>
                           <a class="dropdown-item" href="send_email.php"><i class="fa fa-envelope-open-o
"></i> Send Email</a>
                           <a class="dropdown-item" href="help_documents.php"><i class="fa fa-file-o"></i> Help Documents</a>
                           </div>
                       
                     </li>
                     <li class=" nav-item"><a class="nav-link nav-link-label" href="#"><i class="fa-solid fa-right-from-bracket"></i></a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </nav>