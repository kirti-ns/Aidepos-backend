<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- Mirrored from pixinvent.com/bootstrap-admin-template/robust/html/ltr/vertical-menu-template/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Jul 2022 06:05:00 GMT -->
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <meta name="author" content="PIXINVENT">

   <title>Edit Payment</title>
   <link rel="apple-touch-icon" href="public/app-assets/images/ico/apple-icon-120.png">
   <link rel="shortcut icon" type="image/x-icon" href="https://pixinvent.com/bootstrap-admin-template/robupublic/app-assets/images/ico/favicon.ico">
   <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CMuli:300,400,500,700" rel="stylesheet">


   <link rel="stylesheet" type="text/css" href="public/app-assets/css/vendors.min.css">
   <link rel="stylesheet" type="text/css" href="public/app-assets/css/app.min.css">
   <link rel="stylesheet" type="text/css" href="public/app-assets/css/core/menu/menu-types/vertical-menu.min.css">
   <link rel="stylesheet" type="text/css" href="public/app-assets/css/core/colors/palette-gradient.min.css">
   <link rel="stylesheet" type="text/css" href="public/app-assets/fonts/meteocons/style.min.css">
   <!-- <link rel="stylesheet" type="text/css" href="../assets/css/style.css"> -->

   <!-- BEGIN Custom CSS-->
   <link rel="stylesheet" type="text/css" href="public/app-assets/css/menu/custom.css">
   <link rel="stylesheet" type="text/css" href="public/app-assets/css/menu/purchase.css">

   <!-- END Custom CSS-->

   <!-- BEGIN Font Awsome CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <!-- END Font Awsome CSS -->
   <!-- Table Start -->
   <link rel="stylesheet" type="text/css" href="public/app-assets/vendors/css/tables/datatable/datatables.min.css">
   <!--  <link rel="stylesheet" type="text/css" href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css"> -->
   <link rel="stylesheet" type="text/css" href="public/app-assets/css/menu/add_purchase_order.css">
   <!-- Table End -->
</head>
<body class="vertical-layout vertical-menu 2-columns menu-collapsed menu-open fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">
   <!-- fixed-top-->
   <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
      <div class="navbar-wrapper">
         <div class="navbar-header">
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
            <div class="collapse navbar-collapse" id="navbar-mobile">
               <ul class="nav navbar-nav mr-auto float-left">
                  <li class="nav-item">
                     <a class="navbar-brand" href="index.html">
                        <img class="brand-logo admin-logo" alt="robust admin logo" src="public/app-assets/images/logo/logo.png">
                        <!-- <h3 class="brand-text">Robust Admin</h3> -->
                     </a>
                  </li>
                  <li class="nav-item vertical-border"></li>
                  <!--  <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li> -->
                  <li class="nav-item nav-search">
                     <a class="nav-link nav-link-search" href="#"><i class="ficon ft-search"></i></a>
                     <div class="search-input open">
                        <input class="input" type="text" placeholder="Search Everything..." style="border-bottom:none;">
                     </div>
                  </li>
               </ul>
               <ul class="nav navbar-nav float-right">
                  <li class="dropdown-user nav-item">
                     <a class="nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                        <div class="media">
                           <div class="media-body">
                              <h6 class="media-heading mb-0">Tanya Hill</h6>
                              <p class="media-sub-heading font-small-2 mb-0">Aidepos Admin</p>
                           </div>
                           <div class="media-left ">
                              <span class="user-profile rounded-circle">TH</span>
                           </div>
                        </div>
                        <!-- <span class="avatar avatar-online"><img src="public/app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"><i></i></span> -->
                     </a>
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
                                 <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan"></i></div>
                                 <div class="media-body">
                                    <h6 class="media-heading">You have new order!</h6>
                                    <p class="notification-text font-small-3 text-muted">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                    <small>
                                       <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">30 minutes ago</time></small>
                                    </div>
                                 </div>
                              </a>
                              <a href="javascript:void(0)">
                                 <div class="media">
                                    <div class="media-left align-self-center"><i class="ft-download-cloud icon-bg-circle bg-red bg-darken-1"></i></div>
                                    <div class="media-body">
                                       <h6 class="media-heading red darken-1">99% Server load</h6>
                                       <p class="notification-text font-small-3 text-muted">Aliquam tincidunt mauris eu risus.</p>
                                       <small>
                                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Five hour ago</time></small>
                                       </div>
                                    </div>
                                 </a>
                                 <a href="javascript:void(0)">
                                    <div class="media">
                                       <div class="media-left align-self-center"><i class="ft-alert-triangle icon-bg-circle bg-yellow bg-darken-3"></i></div>
                                       <div class="media-body">
                                          <h6 class="media-heading yellow darken-3">Warning notifixation</h6>
                                          <p class="notification-text font-small-3 text-muted">Vestibulum auctor dapibus neque.</p>
                                          <small>
                                             <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time></small>
                                          </div>
                                       </div>
                                    </a>
                                    <a href="javascript:void(0)">
                                       <div class="media">
                                          <div class="media-left align-self-center"><i class="ft-check-circle icon-bg-circle bg-cyan"></i></div>
                                          <div class="media-body">
                                             <h6 class="media-heading">Complete the task</h6>
                                             <small>
                                                <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last week</time></small>
                                             </div>
                                          </div>
                                       </a>
                                       <a href="javascript:void(0)">
                                          <div class="media">
                                             <div class="media-left align-self-center"><i class="ft-file icon-bg-circle bg-teal"></i></div>
                                             <div class="media-body">
                                                <h6 class="media-heading">Generate monthly report</h6>
                                                <small>
                                                   <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last month</time></small>
                                                </div>
                                             </div>
                                          </a>
                                       </li>
                                       <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all notifications</a></li>
                                    </ul>
                                 </li>
                                 <li class=" nav-item"><a class="nav-link nav-link-label" href="#"><i class="ft-power"></i></a>
                                 </li>
                                 <li class=" nav-item"><a class="nav-link nav-link-label" href="#"><i class="ft-power"></i></a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </nav>
                 <div class="main-menu menu-fixed menu-accordion menu-shadow menu-light" data-scroll-to-active="true">
         <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
               
                <li class=" nav-item"><a href="index.html"><i class="icon-grid"></i><span class="menu-title" data-i18n="nav.email-application.main">Dashboard</span></a>
               </li>
               <li class=" nav-item">
                  <a href="customers_list.html"><i class="ft-users"></i><span class="menu-title" >Customers</span></a>
                  <ul class="menu-content">
                     <li><a class="menu-item" href="customers_list.html"> <i class="fa fa-minus"></i> Customers</a>
                     </li>
                     <li><a class="menu-item" href="customers_list.html" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Gift Cards</a>
                     </li>
                     <li><a class="menu-item" href="customers_list.html" data-i18n="nav.footers.footer_transparent"><i class="fa fa-minus"></i>  Loyalty Points</a>
                     </li>
                  </ul>
               </li>
               <li class=" nav-item">
                  <a href="items_list.html"><i class="ft-package"></i><span class="menu-title" data-i18n="nav.footers.main">Items</span></a>
                  <ul class="menu-content">
                     <li><a class="menu-item" href="items_list.html" data-i18n="nav.footers.footer_light"><i class="fa fa-minus"></i> Items List</a>
                     </li>
                     <li><a class="menu-item" href="items_list.html" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Category</a>
                     <li><a class="menu-item" href="items_list.html" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Modifiers</a>
                     </li>
                      <li><a class="menu-item" href="items_list.html" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Recipes</a>
                     </li>
                     <li><a class="menu-item" href="items_list.html" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> UOM</a>
                     </li>
                     <li><a class="menu-item" href="items_list.html" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Brand</a>
                     </li>
                  </ul>
               </li>
               <li class=" nav-item">
                  <a href=""><i class="icon-bag"></i><span class="menu-title" data-i18n="nav.email-application.main">Purchases</span></a>
                   <ul class="menu-content">
                     <li><a class="menu-item" href="purchase_order.html" data-i18n="nav.footers.footer_light"><i class="fa fa-minus"></i> Supplier</a>
                     </li>
                     <li><a class="menu-item" href="purchase_order.html" data-i18n="nav.footers.footer_light"><i class="fa fa-minus"></i> Purchase Order</a>
                     </li>
                     <li><a class="menu-item" href="purchase_order.html" data-i18n="nav.footers.footer_light"><i class="fa fa-minus"></i> Purchase Order Review</a>
                     </li>
                     <li><a class="menu-item" href="purchase_order.html" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Goods Received</a>
                     </li>
                     <li><a class="menu-item" href="purchase_order.html" data-i18n="nav.footers.footer_light"><i class="fa fa-minus"></i> Goods Return</a>
                     </li>
                     <li><a class="menu-item" href="purchase_order.html" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Back Order</a>
                     </li>
                  </ul>
               </li>
               <li class=" nav-item">
                  <a href="inventory.html"><i class="ft-repeat"></i><span class="menu-title" data-i18n="nav.email-application.main">Inventory</span></a>
                 <ul class="menu-content">
                     <li><a class="menu-item" href="inventory.html" data-i18n="nav.footers.footer_light"><i class="fa fa-minus"></i> Stock Movement</a>
                     </li>
                     <li><a class="menu-item" href="inventory.html" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Current Total Stock</a>
                     </li>
                     <li><a class="menu-item" href="inventory.html" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Stock Adjustments</a>
                     </li>
                     <li><a class="menu-item" href="inventory.html" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Transfers</a>
                     </li>
                  </ul>
               </li>

               <li class=" nav-item">
                  <a href="sales.html"><i class="ft-trending-up"></i><span class="menu-title" data-i18n="nav.email-application.main">Sales</span></a>
                   <ul class="menu-content">
                     <li><a class="menu-item" href="sales.html" data-i18n="nav.footers.footer_light"><i class="fa fa-minus"></i> Invoice</a>
                     </li>
                     <li><a class="menu-item" href="sales.html" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Credit/Debit Note</a>
                     </li>
                     <li><a class="menu-item" href="sales.html" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Payments</a>
                     </li>
                  </ul>
               </li>
               <li class=" nav-item">
                  <a href="modifiers.html"><i class="ft-shopping-cart"></i><span class="menu-title" data-i18n="nav.email-application.main">Lay-bye</span></a>
                  <ul class="menu-content">
                     <li><a class="menu-item" href="inventory.html" data-i18n="nav.footers.footer_light"><i class="fa fa-minus"></i> I1</a>
                     </li>
                     <li><a class="menu-item" href="inventory.html" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> I2</a>
                     </li>
                  </ul>
               </li>
               <li class=" nav-item"><a href="#"><i class="icon-note"></i><span class="menu-title" data-i18n="nav.email-application.main">Reports</span></a>
               </li>
               <li class=" nav-item">
                  <a href="#"><i class="icon-settings"></i><span class="menu-title" data-i18n="nav.email-application.main">Settings</span></a>
                  <ul class="menu-content">
                     <li><a class="menu-item" href="inventory.html" data-i18n="nav.footers.footer_light"><i class="fa fa-minus"></i> I1</a>
                     </li>
                     <li><a class="menu-item" href="inventory.html" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> I2</a>
                     </li>
                  </ul>
               </li>
            </ul>
         </div>
 </div>
                  <div class="app-content content">
                     <div class="content-wrapper">
                        <div class="content-header row">
                           <div class="content-header-left col-md-8 col-12 breadcrumb-new">
                              <h3 class="content-header-title mb-0 d-inline-block">Edit Payment</h3>
                           </div>
                        </div>
                        <div class="content-body">
                           <div class="card">
                              <div class="card-body">
                                 
                                <div class="row g-4">
                                   <div class="col-md">
                                     <div class="form-floating">
                                       <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                         <option selected>Authentic Corner</option>
                                         <option value="1">One</option>
                                         <option value="2">Two</option>
                                         <option value="3">Three</option>
                                      </select>
                                      <label for="floatingSelectGrid">Customer Name*</label>
                                   </div>
                                </div>
                                <div class="col-md">
                                  <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="INV-000002">
                                   <label for="floatingSelectGrid">Amount Received $*</label>
                                </div>
                             </div>
                             <div class="col-md">
                                  <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="00">
                                   <label for="floatingSelectGrid">Bank Charges(if any)</label>
                                </div>
                             </div>
                             <div class="col-md">
                                  <div class="form-floating">
                                    <input type="Date" class="form-control" id="floatingInputGrid" placeholder="123..." value="05,Jun,2022">
                                   <label for="floatingSelectGrid">Payment Date</label>
                                </div>
                             </div>
                       </div>

                       <br>
                       <div class="row g-4">
                          <div class="col-md">
                         <div class="form-floating">
                           <input type="text" class="form-control" id="floatingInputGrid" placeholder="" value="PAY-000002">
                           <label for="floatingInputGrid">Payment#*</label>
                        </div>
                     </div>
                        <div class="col-md">
                         <div class="form-floating">
                           <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                             <option selected>Bank Transfer</option>
                             <option value="1">One</option>
                             <option value="2">Two</option>
                             <option value="3">Three</option>
                          </select>
                          <label for="floatingSelectGrid">Payment Mode</label>
                        </div>
                     </div>

                     <div class="col-md">
                         <div class="form-floating">
                           <input type="text" class="form-control" id="floatingInputGrid" placeholder="" value="55">
                           <label for="floatingInputGrid">Reference#  <i class="fa fa-info-circle"></i></label>
                        </div>
                     </div>
                  <div class="col-md">
                                  <div class="form-floating">
                                    <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                      <option selected>ZAR(R)-South African Rand</option>
                                      <option value="1">One</option>
                                      <option value="2">Two</option>
                                      <option value="3">Three</option>
                                   </select>
                                   <label for="floatingSelectGrid">Exchange Currency</label>
                                </div>
                             </div>
                  </div>
                  <br>
                 <div class="row">
                     
                    <div class="col-md-6">
                     <input type="radio" class="" name="is_deduct" id="No Tax deducted"><label for="No Tax deducted" class="mr-1">No Tax deducted</label>
                     <input type="radio" class="" name="is_deduct" id="Yes,TDS"><label for="Yes,TDS" class="mr-1">Yes,TDS</label>
                  </div>
                  <div class="col-md-6">
                     <input type="radio" class="" name="is_smaller_unit" id="active"><label for="active" class="mr-1">Active</label>
                     <input type="radio" class="" name="is_smaller_unit" id="inactive"><label for="inactive" class="mr-1">Inactive</label>
                  </div>
                 </div>

               </div>
            </div>
            <div class="card">
               <div class="card-body">
                  <section id="form-repeater">
                   <div class="row">
                    <div class="col-12">
                     <div class="card">
                      <div class="card-content collapse show">
                       <div class="card-body">
                        <div class="repeater-default">
                         <div data-repeater-list="car">
                           <div class="">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="row">
                                       <div class="col-md-3">
                                          <span>Unpaid Invoices</span>
                                       </div>
                                       <div class="col-md-6">
                                          <input type="date" class="form-control" id="floatingInputGrid" placeholder="" value="">
                                       </div>
                                    </div>
                                 
                                 
                              </div>
                             
                              <div class="col-md-6 text-right">
                              <a href="" style="color:red;"><u>Clear Applied Amount</u></a>
                              </div>
                              </div>
                              <br>
                              <table id="myTable" class="table  table-bordered zero-configuration">

                                 <thead class="threadClass"> <tr> <th></th>
                                 <th>Date</th> <th>Due Date</th> <th>Invoice
                                 No.</th> <th>Currency</th> <th>Invoice
                                 Amount</th> <th>Amount Due</th>
                                 <th>Payment</th> </tr> </thead> <tbody> <tr>
                                 <td>..</td> <td class="text-center">05
                                 Jun,2022</td> <td
                                 class="text-center">08,Jun,2022</td> 
                                 <td class="text-center">INV-000002</td> 
                                 <td class="text-center">ZAR 108281.35</td> 
                                 <td class="text-center">$6256.00</td> 
                                 <td class="text-center">$1,526.00</td> 
                                 <td class="text-center">$100.00</td>
                                       
                                      </tr>
                                     
                                   </tbody>
                                </table>
                                <div class="row">
                                 <div class="col-md-10">
                                <h6>*List contains only SENT invoices</h6>
                             </div>
                             <div class="col-md-2" style="text-align: right;">
                                <h6>Total : $100.00</h6>
                             </div>
                             </div>
                             <br>
                          </div>
                         
                     </div>
                     <div class="row">
                       <div class="col-md-5">
                          <textarea placeholder="Notes (Internal use. Not visible to customer)" rows="4" cols="50" class="form-control"></textarea>
                       </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-4 add-form-footer p-2">
                          <div class="row">
                              <div class="col-md-7">
                                 <span>Amount Received</span>
                              </div>
                              <div class="col-md-2">
                              </div>
                              <div class="col-md-3">
                                 <span>$100.00</span>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-7">
                                 <span>Amount used for Payments</span>

                              </div>
                              <div class="col-md-2">
                              </div>
                              <div class="col-md-3">
                                 <span>$100.00</span>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-7">
                                 <span>Amount Refunded</span>

                              </div>
                              <div class="col-md-2">
                              </div>
                              <div class="col-md-3">
                                 <span>$00.00</span>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-7">
                                 <span>Amount in Excess</span>

                              </div>
                              <div class="col-md-2">
                              </div>
                              <div class="col-md-3">
                                 <span>$00.00</span>
                              </div>
                           </div>

                        </div>

                     </div>
               </div> 
               <br>
               <div class="row">
                  <div class="col-md-6">
                <div class="form-footer text-left">
                 <button  type="file" class="btn btn-outline-info import-payments " style="color:red;"><i class="fa fa-cloud-upload"></i> Upload File</button> You can upload a maximum of 3 files, 5MB each
              </div>
           </div>
           <div class="col-md-6">
               <div class="form-footer text-right">
                 <button  type="button" class="btn btn-default_new"><i class="fa fa-close"></i> Cancel</button>
                 <button  type="button" class="btn btn-info"><i class="fa fa-file-o"></i> Save</button>
              </div>
           </div>
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

<script src="public/app-assets/vendors/js/vendors.min.js"></script>
<script src="public/app-assets/js/core/app-menu.min.js"></script>
<script src="public/app-assets/js/core/app.min.js"></script>
<script src="public/app-assets/js/scripts/customizer.min.js"></script>

<!-- add form -->
<script src="public/app-assets/js/menu/inventory.js"></script>
<script src="public/app-assets/js/menu/payment.js"></script>

<!-- add form -->

</body>
</html>
 <!-- Model Start -->         
            <div class="modal fade text-left" id="import-payments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
               <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel18">Import Payments</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <div class="uploadOuter">
                           <div class="row">
                              <div class="col-md-5">
                                 <span class="dragBox" >
                                 <span><i class="fa fa-cloud-upload"></i></span>
                                 <span>Darg and Drop Files Here</span>
                                 <input type="file" onChange="dragNdrop(event)"  ondragover="drag()" ondrop="drop()" id="uploadFile"/>
                                 </span>
                              </div>
                              <div class="col-md-2 p-2">
                                 <strong>OR</strong>
                              </div>
                              <div class="col-md-5">
                                 <label for="uploadFile" class="btn btn-outline-info"><i class="fa fa-plus"></i>  Browse Files</label>
                                 <p>Supported upto to 25 MB</p>
                              </div>
                           </div>
                           <!-- <div id="preview"></div> -->
                        </div>
                        <div class="modal-footer">
                           <a href=""><i class="fa fa-download"></i> Download Format</a>
                           <button type="button" class="btn btn-info"> <i class="fa fa-file-o"></i> Submit</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Model End-->