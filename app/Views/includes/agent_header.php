
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
   <head>
    <?php
    $current_url =  current_url();
    $url = explode('/',$current_url);
    ?>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta name="description" content="">
      <meta name="keywords" content="">
      <meta name="author" content="PIXINVENT">
      <title><?php echo $data['title'] ?></title>
      <link rel="apple-touch-icon" href="<?= base_url()?>public/app-assets/images/ico/apple-icon-120.png">
      <link rel="shortcut icon" type="image/x-icon" href="https://pixinvent.com/bootstrap-admin-template/robust/app-assets/images/ico/favicon.ico">
      <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="<?= base_url('public/app-assets/css/vendors.min.css')?>">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/css/app.min.css?v=1.2">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/css/core/menu/menu-types/vertical-menu.min.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/css/core/colors/palette-gradient.min.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/fonts/meteocons/style.min.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/style.css">
      <!-- BEGIN Custom CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/css/menu/custom.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/css/menu/customers.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/css/menu/add_purchase_order.css">
      <!-- END Custom CSS-->
      <!-- BEGIN Font Awsome CSS -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <!-- END Font Awsome CSS -->
      <!-- Table Start -->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/vendors/css/tables/datatable/datatables.min.css">
      <!-- Table End -->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/css/menu/gift.css">

    <?php if(in_array("dashboard",$url)){  ?>
      <!-- Dashboard Start-->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/vendors/css/charts/morris.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/vendors/css/extensions/unslider.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/vendors/css/weather-icons/climacons.min.css">
      <!-- BEGIN Custom CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/css/menu/dashboard.css">
      <!-- Dashboard End-->
     <?php } ?> 
      <!-- Item Start CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/css/menu/item.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/css/menu/category.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/css/menu/recipe.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>public//app-assets/vendors/css/forms/tags/tagging.css">
       <!-- Item End-->
       <!-- Purchase Order Start -->
       <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/css/menu/purchase.css">
       <!-- Purchase Order End -->

       <!-- Inventory Start -->
       <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/css/menu/inventory.css">
       <!-- Inventory End -->
        <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/vendors/css/pickers/pickadate/pickadate.css">
<!-- Sales Start -->
       <!-- <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/css/menu/sales.css"> -->
       <!-- Sales End -->

       <!-- Settings Start -->
       <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css">
       <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/vendors/css/forms/toggle/switchery.min.css">
       <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/css/plugins/forms/switch.min.css">
       <!-- Settings End -->

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
        <!-- Role Start -->
         <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/vendors/css/forms/icheck/icheck.css">
         <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/vendors/css/forms/icheck/custom.css">
        <!-- Role End -->
        
        <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/vendors/css/forms/selects/select2.min.css">

        <!-- alert message start -->
         <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/vendors/css/extensions/toastr.css">
         <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/app-assets/css/plugins/extensions/toastr.min.css">
        <!-- alert message end -->
       <style type="text/css">
        body { font-family: 'Montserrat', sans-serif!important; }
        .dataTables_info { float: right; }
        #DataTables_Table_1 { width:none!important }
        .rowDt { margin-top:10px; }
        .pageDt { border-radius:2px !important;font-size:12.5px; }
        .inactive-span { margin-left:10px }
        .dataTable { width: 100%!important; }
        .flex {display: flex}.iti{display: block!important;}
        .iti .form-control {height: calc(3.5rem + 2px);}
        .f-20 {
          font-size: 20px;
          font-weight: 500;
        }
       </style>
       <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
      </style>
      <style type="text/css">
          

      </style>
   </head>
   <body class="vertical-layout vertical-menu 2-columns menu-collapsed menu-open fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns" id="main">
      <!-- fixed-top-->
     <?= view('includes/agent_navbar.php') ?>
     <?= view('includes/agent_sidebar.php') ?>
     