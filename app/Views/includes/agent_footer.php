
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

<script src="<?= base_url()?>/public/app-assets/js/menu/customers.js"></script>
<script src="<?= base_url()?>/public/app-assets/js/scripts/tooltip/tooltip.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/js/menu/item.js?v=1.2"></script>
<script src="<?= base_url()?>/public/app-assets/vendors/js/forms/tags/tagging.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/js/scripts/forms/tags/tagging.min.js"></script>

<script src="<?= base_url()?>/public/app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/vendors/js/forms/toggle/switchery.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/js/scripts/forms/switch.min.js"></script>
<script src="<?= base_url()?>/public/app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
<!--Role End -->
<!-- alert message start -->
<script src="<?= base_url()?>/public/app-assets/vendors/js/extensions/toastr.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script type="text/javascript">
  var base_url = "<?= base_url();?>";
  let varianceSKU = "";
  let sku = 0;
  var DELETE_URL = base_url + '/delete_data';
/*Common functions Start*/
function alertMessage(type, message) {
   if (type == 'false') {
      toastr.error(message, "Error", {
         closeButton: !0
      })
   } else if (type == "warning") {
      toastr.warning(message, "Warning", {
         closeButton: !0
      })
   } else if (type == "info") {
      toastr.info(message, "Info", {
         closeButton: !0
      })
   } else if (type == "true") {
      toastr.success(message, "Success", {
         closeButton: !0
      })
   }
}
function displayStatus(status_type,type){
   var clStat = "";
   var vlStat = "";
   var statusBorder = "";
   if(status_type == 'purchase_order'){
      if(type == 0){
            clStat = "td-pending";
            vlStat = "Submit for Approval";
         }else if(type == 1){
            clStat = "td-approved";
            vlStat = "Approved";
        }else if(type == 2){
            clStat = "td-rejected";
            vlStat = "Not Approved";
         }
         else if(type == 3){
            clStat = "td-approved";
            vlStat = "Received";
         }else if(type == 4){
            clStat = "td-rejected";
            vlStat = "Partially Received";
         }else if(type == 5){
            clStat = "td-pending";
            vlStat = "Pending Approval";
         }
   }else if(status_type == 'status'){
      
      if(type == 0){
            clStat = "td-pending";
            vlStat = "Deactive";
      }else if(type == 1){
            clStat = "td-paid";
            vlStat = "Active";
      }
   }else if(status_type == 'transfer'){
      if(type == 0){
            clStat = "td-pending";
            vlStat = "Pending";
         }else if(type == 1){
            clStat = "td-approved";
            vlStat = "Approved";
        }else if(type == 2){
            clStat = "td-rejected";
            vlStat = "Cancelled";
         }
      }
     else if(status_type == 'view_customer_transcation'){
      if(type == 0){
            clStat = "td-paid";
            vlStat = "Paid";
         }else if(type == 1){
            clStat = "td-unpaid";
            vlStat = "Unpaid";
        }else if(type == 2){
            clStat = "td-cancelled";
            vlStat = "Cancelled";
         }
   }
      return '<span class="'+clStat+'">'+vlStat+'</span>';

}
function displayBorder(status_type,type){
   var statusBorder = "";
   if(status_type = 'purchase_order'){
      if(type == 0){
         statusBorder = "inactive-border";
      }else if(type == 1){
         statusBorder = "active-border";
      }else if(type == 2){
         statusBorder = "rejected-border";
      }else if(type == 3){
         statusBorder = "active-border";
      }else if(type == 4){
         statusBorder = "rejected-border";
      }
   }else if(status_type = 'status'){
      if(type == 0){
         statusBorder = "inactive-border";
      }else if(type == 1){
         statusBorder = "active-border";
      }
   }
    return statusBorder;
}
/*Common functions End*/
document.body.style.zoom = '80%';
</script>
<?= view('pages/agent/agent_js.php');?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="<?= base_url(); ?>/public/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="<?= base_url(); ?>/public/app-assets/js/scripts/forms/select/form-select2.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.1/xlsx.full.min.js"></script> 

<script>
   const phoneInputField = document.querySelector("#phone");
   const iti = intlTelInput($('#phone').get(0), {
         separateDialCode:true
     });
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
 
<script>
<?php 
 if(in_array("edit_merchant",$url)){ 
   $phone = '+';
   $phone .= $data['profile']['country_code'].''.$data['profile']['phone'];
  ?>
  iti.setNumber("<?= $phone;?>");
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