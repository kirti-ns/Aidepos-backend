
<div class="modal fade text-left" id="change_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18">Change Password</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form method="post" id="change_pass_form" name="change_pass_form">
                  <input type="hidden" name="action" id="action" value="change_password">
                  <input type="hidden" name="table_name" id="table_name" value="employees">
                  <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
            <div class="row">
               <div class="col-md-6">
                  <img src="<?= base_url()?>/public/app-assets/images/change_password.png">
               </div>
               <div class="col-md-6">
                  <p class="text-bold-600" style="margin-left: -20px">Password Must Contain</p>
                  <ul class="checkmark">
                     <li>At least 6 characterd</li>
                     <li>At least 1 uppercase letter (A.Z)</li>
                     <li>At least 1 lowercase letter (A.Z)</li>
                     <li>At least 1 number (0.9)</li>
                  </ul>
               </div>
            </div>
            <div class="row mt-1">
               <div class="col-md-12 mb-1">
                  <div class="form-floating">
                     <input type="password" class="form-control" id="old_password" name="password"placeholder="Current Password" value="" >
                     <label for="floatingInputGrid">Current Password*</label>
                     <div class="form-control-eye-position form-control-position">
                        <i toggle="#password-field" data-id="old_password" class="toggle-cpassword fa fa-eye"></i>
                     </div>
                  </div>
               </div>
               <div class="col-md-12 mb-1">
                  <div class="form-floating">
                     <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" value="" >
                     <label for="floatingInputGrid">New Password*</label>
                     <div class="form-control-eye-position form-control-position">
                        <i data-id="new_password" toggle="#password-field" class="fa fa-eye toggle-cpassword"></i>
                     </div>
                  </div>
               </div>
               <div class="col-md-12 ">
                  <div class="form-floating">
                     <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" value="" >
                     <label for="floatingInputGrid">Confirm New Password*</label>
                     <div class="form-control-eye-position form-control-position">
                        <i data-id="confirm_password" toggle="#password-field" class="fa fa-eye toggle-cpassword"></i>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="" style="padding: 14px;">
            <a href="">Forgot Password?</a>
            <button type="submit" id="changepasswordButton" name="changepasswordButton"  class="btn btn-info float-right"> <i class="fa fa-file-o"></i> Submit</button>
         </div>
         </form>
      </div>
   </div>
</div>
<!-- Change Password End --> 
<!-- Two Factor Authentication Start -->
<div class="modal fade text-left" id="two_factor_auth" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18">Enable two-factor authentication</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12">
                  <p>Two-factor authentication adds an extra layer of security to your account by
                     requiring more than just a password to log in.
                  </p>
                  <p class="text-bold-600">SMS two-factor authentication</p>
                  <p>For security purposes, please re-enter your password below.</p>
               </div>
            </div>
            <div class="row mt-1">
               <div class="col-md-12 mb-1">
                  <div class="form-floating">
                     <input type="password" class="form-control" placeholder="123" value="" >
                     <label for="floatingInputGrid">Current Password*</label>
                     <div class="form-control-eye-position form-control-position">
                        <i toggle="#password-field" data-id="password" class="fa fa-eye toggle-cpassword"></i>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div style="padding: 14px;">
            <a href="<?=base_url()?>/forgot_password" target="_blank">Forgot Password?</a>
               <button  type="button" class="btn btn-default_new"><i class="fa fa-close"></i> Cancel</button>
               <button type="button" class="btn btn-info float-right phone_number_model"> <i class="fa fa-file-o"></i> Continue</button>   
         </div>
      </div>
   </div>
</div>
<!-- Two Factor Authentication End --> 
<!-- Phone number Authentication Start --> 
<div class="modal fade text-left" id="phone_number_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18">SMS two-factor authentication
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12">
                  <p>Enter a phone number where we can send an authentication code via SMS</p>
               </div>
            </div>
            <div class="row mt-1">
               <div class="col-md-12 mb-1">
                  <div class="form-floating">
                     <input type="tel" class="form-control" style="width: 115%;" id="phone" placeholder="123" value="" >
                  </div>
               </div>
            </div>
            <div class="" style="padding: 14px;">
               <a href="">Forgot Password?</a>
               <button  type="button"  data-dismiss="modal" aria-label="Close" class="btn btn-default_new  " style="margin-left: 130px"><i class="fa fa-close"></i> Cancel</button>
               <button type="button" class="btn btn-info float-right auth_code_model"> <i class="fa fa-file-o"></i> Continue</button>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Phone number Authentication End --> 
<!-- Auth Code Start --> 
<div class="modal fade text-left" id="auth_code_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18">SMS two-factor authentication
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12">
                  <p>SMS sent to <span class="text-info">+1 478512365</span>. Please allow up to a minute for the SMS to arrive, then enter the authentication code below.</p>
               </div>
            </div>
            <div class="row mt-1">
               <div class="col-md-12 mb-1">
                  <div class="form-floating">
                     <input type="password" class="form-control" placeholder="123" value="" >
                     <label for="floatingInputGrid">Authentication code*</label>
                  </div>
               </div>
            </div>
         </div>
         <div class="" style="padding: 14px;">
            <a href="">Resend code?</a>
            <button  type="button"  data-dismiss="modal" aria-label="Close" class="btn btn-default_new  " style="margin-left: 190px"><i class="fa fa-close"></i> Cancel</button>
            <button type="button" class="btn btn-info float-right auth_enabled"> Verify</button>
         </div>
      </div>
   </div>
</div>
<!-- Auth Code End --> 
<!-- Auth Enable Start --> 
<div class="modal fade text-left" id="auth_enabled" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18">SMS two-factor authentication is enabled
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12">
                  <p>Your phone number is set to <span class="text-info"> +1 478512365</span>. Authentication codes will be texted to this number for logging in.</p>
               </div>
            </div>
            <div class="row mt-1">
               <div class="col-md-12 mb-1">
                  <div class="form-floating">
                     <input type="password" class="form-control" placeholder="123" value="" >
                     <label for="floatingInputGrid">Authentication code*</label>
                  </div>
               </div>
            </div>
         </div>
         <div class="" style="padding: 14px;">
            <a href="">Unregister SMS number</a>
            <button  type="button"  data-dismiss="modal" aria-label="Close" class="btn btn-default_new  " style="margin-left: 140px"><i class="fa fa-close"></i> Cancel</button>
            <button type="button" class="btn btn-info float-right auth_disabled"> Ok</button>
         </div>
      </div>
   </div>
</div>
<!-- Auth Enable End -->
<!-- Auth Disabled Start --> 
<div class="modal fade text-left" id="auth_disabled" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18">Are you sure?
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12">
                  <p>This will disable two-factor authentication entirely.</p>
               </div>
            </div>
         </div>
         <div class="" style="padding: 14px;">
            <button  type="button"  data-dismiss="modal" aria-label="Close" class="btn btn-default_new  " style="margin-left: 65%"><i class="fa fa-close"></i> Cancel</button>
            <button type="button" class="btn btn-info float-right auth_disabled"> Yes</button>
         </div>
      </div>
   </div>
</div>
 <?php
$current_url =  current_url();
$url = explode('/',$current_url);
?>
<!-- Auth Disabled End -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/vendors/js/vendors.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/vendors/js/extensions/sweetalert.min.js?v=1.2"></script>
<script src="<?= base_url()?>/public/app-assets/js/core/app-menu.min.js?v=1.4"></script>
<script src="<?= base_url()?>/public/app-assets/js/core/app.min.js"></script>
<script src="<?= base_url()?>/public/bootstrap-tagsinput.min.js"></script>

<script src="<?= base_url()?>/public/app-assets/js/scripts/customizer.min.js"></script>
<!-- Table Start -->
<script src="<?= base_url()?>/public/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/js/scripts/tables/datatables/datatable-basic.min.js"></script>
<!-- Table End -->
<!-- Daterange -->
<script src="<?= base_url()?>/public/app-assets/vendors/js/pickers/pickadate/picker.js?v=1.2"></script>
<script src="<?= base_url()?>/public/app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
<script src="<?= base_url()?>/public/app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
<script src="<?= base_url()?>/public/app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
<script src="<?= base_url()?>/public/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>
<script src="<?= base_url()?>/public/app-assets/js/scripts/pickers/dateTime/pick-a-datetime.min.js"></script>
<!-- Custome Start -->
<script src="<?= base_url()?>/public/app-assets/js/menu/customers.js"></script>
<!-- Custome  End-->
<!-- customers Start -->
<!-- <script src="<?= base_url()?>/public/app-assets/js/menu/gift.js"></script> -->
<!-- customers End -->
<!-- item Start -->
<?php if(in_array("edit_category",$url) || in_array("add_category",$url)){
      echo view('pages/items/category_js.php');
    }
    ?>
<script src="<?= base_url()?>/public/app-assets/js/menu/customers.js"></script>
<script src="<?= base_url()?>/public/app-assets/js/scripts/tooltip/tooltip.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/js/menu/item.js?v=1.2"></script>
<!-- <script src="<?= base_url()?>/public/app-assets/js/menu/recipe.js"></script>
   <script src="<?= base_url()?>/public/app-assets/js/menu/brand.js"></script> -->
<script src="<?= base_url()?>/public/app-assets/vendors/js/forms/tags/tagging.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/js/scripts/forms/tags/tagging.min.js"></script>
<!-- item End -->
<!-- Purchase Order Start -->
<script src="<?= base_url()?>/public/app-assets/js/menu/purchase_order.js"></script>
<!-- Purchase Order End -->
<!-- Inventory Start -->

<!-- Inventory End -->
<!-- Payment Start -->
<script src="<?= base_url()?>/public/app-assets/js/menu/payment.js"></script>
<!-- Payment End -->
<!-- Lay Bye Start -->
<script src="<?= base_url()?>/public/app-assets/js/menu/lay_bye.js"></script>
<!-- Lay Bye End -->
<!-- Role Start -->
<script src="<?= base_url()?>/public/app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/vendors/js/forms/toggle/switchery.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/js/scripts/forms/switch.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
<!--Role End -->
<!-- alert message start -->
<script src="<?= base_url()?>/public/app-assets/vendors/js/extensions/toastr.min.js"></script>
<!-- <script src="<?= base_url()?>/public/app-assets/js/scripts/extensions/toastr.min.js"></script> -->
<!-- alert message end -->
 <!-- <script src="<?= base_url()?>/public/app-assets/js/scripts/pickers/dateTime/pick-a-datetime.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<?= view('includes/form_submit.php');?> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="<?= base_url(); ?>/public/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="<?= base_url(); ?>/public/app-assets/js/scripts/forms/select/form-select2.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.1/xlsx.full.min.js"></script> 

<script>
   const phoneInputField = document.querySelector("#phone");
   const iti = intlTelInput($('#phone').get(0), {
         separateDialCode:true,
        // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
     });
  //  alert(iti.getSelectedCountryData().iso2)
  // alert(iti.getSelectedCountryData().dialCode)
</script>
<!-- Add Employee Start-->
<script>
   $(document).on('click', '.toggle-password', function() {
   
      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $("#employee_password");
      input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
      });
     
</script>
<script>
   $(document).on('click', '.toggle-cnf_password', function() {
   
      $(this).toggleClass("fa-eye fa-eye-slash");
      
      var input = $("#employee__con_password");
      input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
   });
     
</script>
<!-- Add Employee End-->
<!-- Common header Start -->
<script type="text/javascript">
   $(document).on("click",".change_password",function (e) {
      $('#change_pass_form')[0].reset();
      $('input').removeClass('is-valid');
      $('#change_password').modal('show');
   });
   
    $(document).on("click",".two_factor_auth",function (e) { 
      $('#two_factor_auth').modal('show');
   });
    $(document).on("click",".phone_number_model",function (e) { 
      $('#phone_number_model').modal('show');
      $('#two_factor_auth').modal('hide');
   });
    $(document).on("click",".auth_code_model",function (e) { 
      
      $('#auth_code_model').modal('show');
      $('#phone_number_model').modal('hide');
   });
    $(document).on("click",".auth_enabled",function (e) { 
      $('#auth_enabled').modal('show');
      $('#auth_code_model').modal('hide');
   });
    $(document).on("click",".auth_disabled",function (e) { 
      $('#auth_disabled').modal('show');
      $('#auth_enabled').modal('hide');
   });
    $(document).on('click', '.form-control-eye-position i', function() {
     var id = $(this).data('id');
     $(this).toggleClass("fa-eye fa-eye-slash");
     var input = $("#"+id);
     input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
     });
    
</script>

<script type="text/javascript">
   var somethingChanged = false;
</script>
 <!-- custom js start -->
 <?php
 if(in_array("inventory",$url)){
      echo view('pages/inventory/inventory_js.php');
    }
 ?>
 <?php if(in_array("add_gift_card",$url)){
      echo view('pages/customers/brand_js.php');
    }
    
    /*if(in_array("add_purchase_order",$url) || in_array("purchases",$url) || in_array("edit_purchase_order",$url) || in_array("add_goods_received",$url) || in_array("add_goods_returned",$url)){*/
      
    //} 
 ?>
   <?php 
   if(in_array("sales",$url)){
      echo view('pages/sales/sales_js.php');
   }

   if(in_array("items",$url)){
      echo view('pages/items/recipe_js.php');
   }
   
   if(in_array("add_currency",$url) || in_array("edit_currency", $url) ){
      echo view('pages/settings/settings_js.php');
   }

   if(strpos(current_url(),"layby",) !== false){
      echo view('pages/lay-by/lay_by_js.php');
   } else {
      echo view('pages/purchases/purchase_order_js.php');
   }

   if(strpos(current_url(),"reports",) !== false){
      echo view('pages/reports/reports_js.php');
   }
 ?>
 <!-- custom js end -->

<!-- Common header End -->

 <script type="text/javascript">
   $(document).ready(function() {
      $("#changepasswordButton").click(function(e) {
         e.preventDefault();
       
         var params =$('#change_pass_form').serialize();
         $.ajax({
            type: "post",
            url: "<?= base_url('change_password') ?>",
            data: params,
            success: function (data) {
               var res = JSON.parse(data);
               if(res.status == 'true') {
                  alertMessage('true',res.message);
                  $('#change_password').modal('hide');
               }else {
                  alertMessage('false',res.message);
               }
            }
         });
      });
   });
 </script>
 
<script language="JavaScript">

<?php 
 if(in_array("edit_employee",$url)){ 
   $phone = '+';
   $phone .= $data['employees']['country_code'].''.$data['employees']['phone'];
    ?>
   
      iti.setNumber("<?= $phone;?>");
   <?php } ?>
<?php 
 if(in_array("edit_store",$url)){ 
   $phone1 = '+';
   $phone1 .= $data['stores']['country_code'].''.$data['stores']['phone'];
    ?>
   
      iti.setNumber("<?= $phone1;?>");
   <?php } ?>
   <?php  
 if(in_array("edit_customer",$url)){ 
   $phone1 = '+';
   $phone1 .= $data['customer']['country_code'].''.$data['customer']['phone'];
    ?>
   
      iti.setNumber("<?= $phone1;?>");
   <?php } ?>
    <?php  
 if(in_array("edit_supplier",$url)){ 
   $phone1 = '+';
   $phone1 .= $data['supplier']['country_code'].''.$data['supplier']['phone'];
    ?>
   
      iti.setNumber("<?= $phone1;?>");
   <?php } ?>
   <?php  
    if(in_array("edit_profile",$url)){ 
   $phone1 = '+';
   $phone1 .= $data['employees']['country_code'].''.$data['employees']['phone'];
    ?>
   
      iti.setNumber("<?= $phone1;?>");
   <?php } ?> 
   

</script>
   
<script>
$(function(){
   var hash = "";
   $('.main-menu-content .navigation-main .nav-item .menu-content a').click(function (e) {
        hash = $(this).attr("data-id");
        showTab(hash);
        // window.scrollTo({ top: 0, behavior: 'smooth' });
   });
   
   if(document.location.hash!='') {
        showTabByHash();
    }
    $(".navigate-tabs .nav-item a.nav-link").click(function (e) {
        e.preventDefault();
        showTab($(this).attr('href'));
    });
});
function showTab(tab) {
    $("ul.nav > li > a").removeClass('active show');
    $('.tab-pane').removeAttr('style');
    window.location.hash = tab
    showTabByHash()
}

function showTabByHash() {
   $('#sellStockTbl tbody tr').removeClass('selected-tr');
   $(".customizer").removeClass("open");
    var tabName = window.location.hash;

    $(tabName).show(); 
    $('ul.navigate-tabs a').removeClass('active');
    $('.tab-pane').removeClass('active show');

    $('ul.nav > li > a[href="'+tabName+'"]').addClass('active');
    $(tabName).addClass("active show");
    var top = document.getElementById("tab-bottom-line-drag").offsetTop;
    if(window.scrollTop != top) 
        window.scrollTo(0, top);
    // window.scrollTo({ top: 0, behavior: 'smooth' });
    /*var scrollmem = $('body').scrollTop() || $('html').scrollTop();
    $('html,body').scrollTop(scrollmem);*/
}
</script>
</body>
</html>

<!-- <div class="card collapse-icon accordion-icon-rotate" style="box-shadow: none;border: 1px solid #e2dbdb;">
   <div id="pay-records" class="card-header" style="background-color: #fff;">
      <a data-toggle="collapse" href="#collapse2" aria-expanded="false" aria-controls="collapse2" class="card-title lead collapsed">Payments Received</a>
   </div>
   <div id="collapse2" role="tabpanel" aria-labelledby="pay-records" class="collapse" aria-expanded="false">
      <div class="card-content">
         <div class="card-body">
            
            <div class="tab-content">
               <div role="tabpanel" class="tab-pane active" id="tab31" aria-expanded="true" aria-labelledby="base-tab31">
                  <p>Oat cake marzipan cake lollipop caramels wafer pie jelly beans. Icing halvah chocolate cake carrot cake. Jelly beans carrot cake marshmallow gingerbread chocolate cake. Gummies cupcake croissant.</p>
               </div>
               <div class="tab-pane" id="tab32" aria-labelledby="base-tab32">
                  <p>Sugar plum tootsie roll biscuit caramels. Liquorice brownie pastry cotton candy oat cake fruitcake jelly chupa chups. Pudding caramels pastry powder cake soufflé wafer caramels. Jelly-o pie cupcake.</p>
               </div>
            </div>
            <div class="table-responsive">
               <table class="table" id="v-payments-tbl">
                   <thead>
                       <tr>
                           <th>Date</th>
                           <th>Payment#</th>
                           <th>Payment Mode</th>
                           <th>Amount</th>
                       </tr>
                   </thead>
                   <tbody>
                   </tbody>
               </table>
           </div>
         </div>
      </div>
   </div>
</div>