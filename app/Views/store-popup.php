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
      <link rel="apple-touch-icon" href="<?= base_url()?>/public/app-assets/images/ico/apple-icon-120.png">
      <link rel="shortcut icon" type="image/x-icon" href="https://pixinvent.com/bootstrap-admin-template/robust/public/app-assets/images/ico/favicon.ico">
      <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,600,600i,700,700i%7CMuli:300,400,500,700" rel="stylesheet">
      <!-- BEGIN VENDOR CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/vendors.min.css">
      <!-- END VENDOR CSS-->
      <!-- BEGIN ROBUST CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/app.min.css">
      <!-- END ROBUST CSS-->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/menu/custom.css">
      <!-- input css -->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/vendors/css/ui/jquery-ui.min.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/plugins/ui/jqueryui.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/menu/login.css">
     
      <!-- alert message start -->
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/vendors/css/extensions/toastr.css">
      <link rel="stylesheet" type="text/css" href="<?= base_url()?>/public/app-assets/css/plugins/extensions/toastr.min.css">
      <!-- alert message end -->
      <!-- END Custom CSS-->
   </head>

   <body>
    <div class="modal fade text-left" id="store-popup" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
       <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
             <div class="modal-header">
                <h4 class="modal-title" id=""><?= $data['modal-title']; ?></h4>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button> -->
             </div>
            <form method="post" id="ask_store_form" name="ask_store_form" action="<?= base_url('postEmpStore')?>">
              <div class="modal-body">
                  <input type="hidden" name="action" id="action" value="postEmpStore">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-floating">
                          <select class="form-select" id="store" name="store" aria-label="Floating label select example">
                              <option disabled>Select Store</option>
                                <?php 
                                 if(!empty($data['stores']))
                                 {
                                    foreach($data['stores'] as $row)
                                       { ?>
                                          <option value="<?= $row['id']?>"><?= $row['store_name']?></option>
                                 <?php
                                       }
                                  } 
                                 ?>
                            </select>
                           <label for="floatingInputGrid">Store</label>
                        </div>
                     </div>
                  </div>
                  <?php if(isset($data['terminals']) && !empty($data['terminals'])) { ?>
                  <div class="row pt-1">
                     <div class="col-md-12">
                        <div class="form-floating terminal-row">
                          <select class="form-select" id="terminal" name="terminal" aria-label="Floating label select example">
                              <option disabled>Select Terminal</option>
                                <?php
                                  foreach($data['terminals'] as $row)
                                  { ?>
                                    <option value="<?= $row['id']?>"><?= $row['terminal_name']?></option>
                                 <?php
                                  } ?>
                          </select>
                          <label for="floatingInputGrid">Terminal</label>
                        </div>
                     </div>
                  </div>
                <?php } ?>
               </div>
               <div class="modal-footer">
                   <!-- <button  type="button" data-dismiss="modal" aria-label="Close" class="btn btn-default_new">Cancel</button> -->
                   <button type="submit" id="btnSubmit" class="btn btn-info">Save</button>
               </div>
             </form>
          </div>
       </div>
    </div>

    <script src="<?= base_url()?>/public/app-assets/vendors/js/vendors.min.js"></script>
    
    <script src="<?= base_url()?>/public/app-assets/vendors/js/extensions/toastr.min.js"></script>
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <?= view('includes/login_js.php');?>

    <script type="text/javascript">
      $(window).on("load",function(){ 
        $('#store-popup').modal({backdrop: 'static', keyboard: false}, 'show')
      });
    </script>

  </body>
</html>