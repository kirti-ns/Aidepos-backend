<script type = "text/javascript">
  var base_url = "<?= base_url();?>";
  let varianceSKU = "";
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
</script>
  
<!-- Validation form Start -->
   <?= view('includes/form_validation.php') ?>
<!-- Validation form End -->
<!-- Datatable Start -->
   <?= view('includes/table_pagination.php') ?>
<!-- Datatable End -->
<script>

function GetVariantList() {
   $.ajax({
      type: "GET",
      url: "<?= base_url('get_variant')?>",
      data: "",
      dataType: "json",
      encode: true,
   }).done(function (data) {

      $('#variant-table tr:last').children('td').find('.variant_data').html(data.data)
      // $('#variant_data').html(data.data);
      //}

   })
}

function GetCompositeList() {
   $.ajax({
      type: "GET",
      url: "<?= base_url('get_composite')?>",
      data: "",
      dataType: "json",
      encode: true,
   }).done(function (data) {
    
      $('#composite-item-table tr:last').children('td').find('.composite_data').html(data.data)
      //}

   })
}

function readURL(input) {
   if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
         $('#imagePreview').attr('src', e.target.result);
         $('#imagePreview_name').val(e.target.result);
         //$('#imagePreview').css('background-image', 'url('+e.target.result +')');
         $('#imagePreview').hide();
         $('#imagePreview').fadeIn(650);

         console.log(e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
   }
}

$("#imageUpload").change(function () {
   readURL(this);
});

$("ul#main-menu-navigation > li > a").each(function () {
  var currentURL = document.location.href;
  var thisURL = $(this).attr("href");
  if (currentURL.indexOf(thisURL) != -1) {
    $("li.nav-item").removeClass("active");
    $(this).parents("li.nav-item").addClass('active');
    $(this).parents("li.has-sub").addClass('open');
  }
}); 

$(function () {
  $('#tag-input').tagsinput({
        maxTags: 5
    });

  $(document).on('keypress','.bootstrap-tagsinput input', function(e){
      if (e.keyCode == 13){
        return false;
      };
    })
});
</script>

<!-- Kirti Datatables End -->
 <script type="text/javascript">
     
      //Ruchika End
     $('.pos-switchery').on('change', function(){
      var pos = $('#pos').is(":checked");
      if(pos == true){
         $('.pos-section').removeClass('d-none');
      }else{
         $('.pos-section').addClass('d-none');
      }
     
     });
   $('.back_office-switchery').on('change', function(){
      var pos = $('#back_office').is(":checked");
      if(pos == true){
         $('.back-office-section').removeClass('d-none');
      }else{
         $('.back-office-section').addClass('d-none');
      }
     
     });
   $('.waiter-switchery').on('change', function(){
      var pos = $('#waiter').is(":checked");
      if(pos == true){
         $('.waiter-section').removeClass('d-none');
      }else{
         $('.waiter-section').addClass('d-none');
      }
     
     });
     
$(document).on('change','#tranferStatus',function() {
    var id = $(this).attr('data-id');
    var status = $(this).val();
    $.ajax({
         type: "POST",
         url: base_url+'/update_transfer_status',
         data: {
            id: id,
            status: status
         },
         dataType: "json",
         encode: true,
      }).done(function (data) {
         alertMessage(data.status, data.message);
         if(data.status == 'true'){
          window.location.href = base_url + "inventory#transfer";
         }
      });
});      
/*Code added here*/

   $(document).on('change','#order_number',function(e){
        let self = $(this);
       let id = self.val();
     
      let type = $(this).attr('data-type');
       $.ajax({
           type: "POST",
           url: '<?= base_url() ?>'+'/purchases/get-purchase-data-by-order-id',
           data: { id:id,type:type},
           success: function (res) { 
               res = JSON.parse(res);
             if(res.status == "true") {
               data_res =  res.data;
               data = data_res.purchase_order;
               $('#store_id').val(data.store_id);
               $('#supplier_id').val(data.supplier_id);
               $('#category_id').val(data.category_id);
               $('#due_date').val(data.due_date);
               $('#date').val(data.date);
               $('#terms').val(data.terms);
               $('#v_currency_id').val(data.currency_id);
               $('.discountAmount').text(data.total_discount);
               $('#total-discount').val(data.total_discount)
               $('.subTotal').text(data.sub_total)
               $('#sub-total').val(data.sub_total)
               $('.taxAmount').text(data.total_tax)
               $('#total-tax').val(data.total_tax)
               $('#total-amount').val(data.total_amount)
               $('#location').val(data.location_id);
               if(data.currency_id != "") {
                $('.conv-currency').css({'visibility':'visible'})
               }
               $('#currency_rate').val(data.currency_rate)

               if(type == "received"){
                  item = data_res.purchase_items;
                  item = data_res.purchase_items;
                  html = data_res.purchase_items_pages;
             
                  $('#goods-received-section').html(html);
               }else{
                  item = data_res.purchase_items;
                  html = data_res.purchase_items_pages;
             
                  $('#goods-returned-section').html(html);
               }
              
             }
           }
         });
   }); 
/*$(document).on('click','.item-delete', function(e) {
  e.preventDefault();
  $(this).closest("tr").remove();
    var id = $(this).attr('data-id');
      var table = $(this).attr('data-table');

       $.ajax({
               type: "POST",
               url: "<?= base_url('/delete_data')?>",
               data: {id:id,table:table},
               dataType: "json",
               encode: true,
             }).done(function (data) {
               alertMessage(data.status,data.message);
             });
});*/

 $(document).ready(function () {

  $(document).on('click','#downloadFormat',function(){
    
    let fHead = ["Account_ID","Tpin_No","LPO_No","ID_No","Registered_Name","Tax_Account_Name","Address","Email","Country_Code","Phone"];

    let fRow = [
      ["PRT001","100200300","LOP07486","ID78562","Amrut Distilleries Pvt Ltd","Amrut Distilleries","Lusaka Africa","amrutdist@gmail.com","+1","84848484"],
      ["TWA002","789200300","LOP78412","ID71220","Diageo India Pvt Ltd","Diageo India Pvt Ltd","Lusaka Africa","diageo@gmail.com","+1","478512365"],
      ["TSG004","789500300","LOP71220","ID74123","Godavari Biorefineries","Godavari Biorefineries","Lusaka Africa","godavari.biorefineries@gmail.com","+1","478542685"],
      ["HLI098","100200300","LOP07486","ID78562","N.S.L Sugars Ltd","N.S.L Sugars Ltd","Lusaka Africa","nslsugars12@gmail.com","+1","478542685"],
      ["TSG004","8714700300","LOP74123","ID07486","United Spirits Ltd","Prganicum","US","prganicum@gmail.com","+1","478542685"]
    ];

    let head = Object.values(fHead).join(',') + '\n'; // header row
    let body = fRow.map(row => Object.values(row).join(',')).join('\n');

    var e = document.createElement('a');
    e.href = 'data:text/csv;charset=utf-8,' + encodeURI(head + body);
    e.target = '_blank';
    e.download = 'Customers.csv';
    e.click();

    $('#import-customers').modal('hide');
  })

  $("form[name='import_customer_form']").validate({
         rules: {
            file: {
              required:true
            }
         },
         messages: {
            file: "Please select file"
         },
         errorElement: "div",
         errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            error.insertAfter(element);
         },
         highlight: function (element) {
            $(element).removeClass('is-valid').addClass('is-invalid');
         },
         unhighlight: function (element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
         },
         submitHandler: function (form) {
            importFormSubmit('import_customer_form',event);
            return false;
         }
  });

  function importFormSubmit(formid,event){
       event.preventDefault();
       if (formid) {
          var form_id = formid;
       } else {
          var form_id = $("form").attr("id");
       }
       
       var form = $('#' + form_id)[0];
       var formData = new FormData(form)

       formData.append('_token','{{csrf_token()}}')
       
       $.ajax({
          type: "POST",
          url: '<?=base_url()?>'+'/customers/importCustomers',
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          dataType: "json",
          encode: true,
       }).done(function (data) {

        if (data.status == 'true') {
            toastr.success(data.msg, "Success", {
                closeButton: !0
            })
            setTimeout(function(){
              window.location.reload();
            },500)
        } else {
            toastr.error(data.msg.file, "Error", {
             closeButton: !0
            })
        }
          
       });

  }

  $('.set-modifiers').click(function() {
      var formData = $('#set-modifier-form').serializeArray();
      var modifierArr = [];
      $.each(formData,function(k,v){
        modifierArr.push(v.value)
      })
      $('.u-modifiers').val(JSON.stringify(modifierArr));
      $('#select-modifiers-item').modal('hide');
  });

  $('#receipt-store_id').on('change', function() {
      var id = $(this).val();

      $.ajax({
         type: "POST",
         url: "<?= base_url('settings/getReceipt')?>",
         data: { id: id },
         dataType: "json",
         encode: true,
      }).done(function (data) {
        if(data.status == "true") {
          var receiptData = data.data;
          $('#receipt_id').val(receiptData.id);
          $('#receipt_title').val(receiptData.receipt_title);
          $('#receipt_footer').val(receiptData.receipt_footer);
          $('#receipt_language').val(receiptData.receipt_language);
          $('#receipt_image_old').val(receiptData.receipt_logo);
          $('#store_image_old').val(receiptData.store_logo);
          if(receiptData.store_logo != "") {
            $('div#storeLogoView img').attr('src',base_url+'public/uploads/storelogo/'+receiptData.store_logo);
          }
          if(receiptData.receipt_logo != "") {
            $('div#recLogoView img').attr('src',base_url+'public/uploads/receiptlogo/'+receiptData.receipt_logo);
          }
          $('#storeLogoView, #recLogoView').removeClass('d-none');
          alertMessage(data.status, data.message);
        } else {
          $('#receipt_form')[0].reset();
          $('#receipt-store_id option[value='+id+']').attr('selected','selected');
        }
      })
  });

  $('#general-store_id').on('change', function() {
      var id = $(this).val();

      $.ajax({
         type: "POST",
         url: "<?= base_url('settings/getGeneralSettings')?>",
         data: { id: id },
         dataType: "json",
         encode: true,
      }).done(function (data) {
        if(data.status == "true") {
          var genrData = data.data;
          var location = data.location;

          $('#general_id').val(genrData.id);
          $('#tax_id').val(genrData.tax_id);
          $('#currency_id').val(genrData.currency_id);
          $('#opening_hour').val(genrData.opening_hour);
          $('#closing_hour').val(genrData.closing_hour);
          $('#from_email').val(genrData.from_email);
          $('#layby_deposit_per').val(genrData.layby_deposit_per);
          $('#rounding_to').val(genrData.rounding_to);
          $('#middle_point').val(genrData.middle_point);

          var genrFeature = JSON.parse(genrData.general_features);
          if(genrFeature.barcode_generation == "1") {
            $('#barcode_generation').click();
          }
          if(genrFeature.included_tax == "1") {
            $('#included_tax').click();
          }
          if(genrFeature.rounding == "1") {
            $('#rounding').click();
          }

          if(location.length > 0) {
          $('#layby_source_location').html('<option value="0" selected>Please select</option>');
            var options = '';
            $.each(location,function(k,v){
                options += '<option value="'+v.id+'">'+v.location_description+'</option>'
            });
            $('#layby_source_location').append(options);
            $('#layby_source_location').val(genrData.layby_source_location);
          } else {
            $('#layby_source_location').html('<option value="">Please select</option>');
          }
          alertMessage(data.status, data.message);
        } else {
          $('#general_form')[0].reset();
          $('#general_id').val('');
          $('#general-store_id option[value='+id+']').attr('selected','selected');
          $('#layby_source_location').html('<option value="">Please select</option>');
        }
      })
  });

  $('#receipt_form').on('reset', function() {
    $("#receipt_id", $(this)).val('');
    $("#receipt_image_old", $(this)).val('');
    $("#store_image_old", $(this)).val('');
    $('#storeLogoView, #recLogoView').addClass('d-none');
  });

  var flg = 0, flg2 = 0, fl3 = 0,flg4 = 0;

  $('.master_item-1').on("select2:open", function () {
    flg++;
    if (flg == 1) {
      $this_html = jQuery('.wrapper').html();
      $(".select2-results").append("<div class='select2-results__option'>"+$this_html+"</div>");
    }
  });
  $('#batch_id').on("select2:open", function () {
    flg4++;
    if (flg4 == 1) {
      $this_html = jQuery('.wrapper').html();
      $(".select2-results").append("<div class='select2-results__option'>"+$this_html+"</div>");
    }
  });
  $('.master_item-2').on("select2:open", function () {
    flg2++;
    if (flg2 == 1) {
      $this_html = jQuery('.wrapper').html();
      $(".select2-results").append("<div class='select2-results__option'>"+$this_html+"</div>");
    }
  });
  $('.master_item-3').on("select2:open", function () {
    fl3++;
    if (fl3 == 1) {
      $this_html = jQuery('.wrapper').html();
      $(".select2-results").append("<div class='select2-results__option'>"+$this_html+"</div>");
    }
  });

  $('#add-master-item').on('hidden.bs.modal', function () {
    $('#add-master-item form')[0].reset();
  });
  
  $(document).on("click", ".deleteRow", function (e) {
      e.preventDefault();
      var id = $(this).attr('data-id');
      var table = $(this).attr('data-table');
      toastr.error('Are you sure you want to delete it?<br /><br/><button data-table="'+table+'" data-id="'+id+'" type="button" class="btn btn-secondary clear confirm-delete">Yes</button>');
  });

   $(document).on("click", ".confirm-delete", function () {
      var id = $(this).attr('data-id');
      var table = $(this).attr('data-table');
     
      $.ajax({
         type: "POST",
         url: DELETE_URL,
         data: {
            id: id,
            table: table
         },
         dataType: "json",
         encode: true,
      }).done(function (data) {
         alertMessage(data.status, data.message);
         if(data.status == 'true'){
         window.location.reload();
         }
      });
   })

   $(document).on('change', '.category_id', function () {
      var id = $(this).val();
      var type = $(this).attr('data-type');
      if(id == "category"){
         $('#model_category_form')[0].reset();
         $('#add-category').modal('show');
         $('.category_id').val("");
      }
      else{
         $.ajax({
         type: "POST",
         url: "<?= base_url('/items/getCategoryDataById')?>",
         data: {
            id: id
         },
         dataType: "json",
         encode: true,
      }).done(function (data) {
        if(data.status == 'true') {
          if(type == "standard") {
            $('#sku_barcode').val(data.sku)
          }else if(type == "composite") {
            $('#c-sku_barcode').val(data.sku);
          }else if(type == "variance") {
            varianceSKU = data.sku
          }
        }
      })
      }
   })

   $(document).on('change', '.subcategory_id', function () {
      var id = $('.subcategory_id').val();
      /*var cat_id = $('.category_id').val();
      if(cat_id == "") {
        alert("Please select category id");
        $('.subcategory_id').val("");
        return false;
      }*/
      if(id == "subcategory"){
        // $('#set-category-id').val(cat_id);
         $('#model_subcategory_form')[0].reset();
         $('#add-subcategory').modal('show');
         $('.subcategory_id').val("");
      }
    })

   $(document).on('change', '.variance_subcategory_id', function () {
      var id = $('.variance_subcategory_id').val();
      var cat_id = $('.variance_category_id').val();
      if(cat_id == "") {
        alert("Please select category id");
        $('.variance_subcategory_id').val("");
        return false;
      }
      if(id == "subcategory"){
        $('#set-category-id').val(cat_id);
         $('#model_subcategory_form')[0].reset();
         $('#add-subcategory').modal('show');
      }
    })

   $(document).on('change', '.composite_subcategory_id', function () {
      var id = $('.composite_subcategory_id').val();
      var cat_id = $('.composite_category_id').val();
      if(cat_id == "") {
        alert("Please select category id");
        $('.composite_subcategory_id').val("");
        return false;
      }
      if(id == "subcategory"){
        $('#set-category-id').val(cat_id);
         $('#model_subcategory_form')[0].reset();
         $('#add-subcategory').modal('show');
      }
    })
      
   $(document).on('change', '.uom_list', function () {

      var id = $(this).val();
      if(id == "uom"){
          $('#model_uom_form')[0].reset();
          $('#add-uom').modal('show');
      }
   })
    
    $(document).on('change', '.customer_list', function () {
      var id = $(this).val();
      if(id == "others"){
          $('#model_customer_form')[0].reset();
          $('#others').modal('show');
      }
   })
   
    $(document).on('change', '.tax_list', function () {
      var id = $(this).val();
      if(id == "tax"){
          $('#model_tax_form')[0].reset();
          $('#add-tax').modal('show');
      }
       })

    $(document).on('change', '.brand_list', function () {
      var id = $(this).val();
      if(id == "brand"){
          $('#model_brand_form')[0].reset();
          $('#add-brand').modal('show');
      }
       })

    $(document).on('change', '.modifier_list', function () {
      var id = $(this).val();
      if(id == "modifier"){
          $('#model_modifier_form')[0].reset();
          $('#add-modifier').modal('show');
      }
     
       })

    $(document).on('change', '.variance_category_id', function () {

      var id = $('.variance_category_id').val();
      if(id == "category"){
          $('#model_category_form')[0].reset();
          $('#add-category').modal('show');
      }
      /*else{
      $.ajax({
         type: "POST",
         url: "<?= base_url('getSubcategory')?>",
         data: {
            id: id
         },
         dataType: "json",
         encode: true,
      }).done(function (data) {
         console.log(data.data);
         alertMessage(data.status, data.message);
         $('.variance_subcategory_id').html(data.data);
      })
   }*/
   })
  
   $(document).on('change', '.composite_category_id', function () {
      var id = $('#composite_category_id').val();
      if(id == "category"){
          $('#model_category_form')[0].reset();
          $('#add-category').modal('show');
      }
      /*else{
      $.ajax({
         type: "POST",
         url: "<?= base_url('getSubcategory')?>",
         data: {
            id: id
         },
         dataType: "json",
         encode: true,
      }).done(function (data) {
         console.log(data.data);
         alertMessage(data.status, data.message);
         $('.composite_subcategory_id').html(data.data);
      })
   }*/
   })
   $(document).on('click', '.update-status', function () {
      var order_status = $(this).attr('data-id');
      var order_id = $(this).attr('data-order_id');
      $.ajax({
         type: "POST",
         url: "<?= base_url('update_status')?>",
         data: {
            order_status: order_status,
            id:order_id,
            table_name:'purchaseorders'
         },
         dataType: "json",
         encode: true,
      }).done(function (data) {
         alertMessage(data.status, data.message);
         window.location.href = "<?= base_url('purchases#purchase-order')?>";
        
      })
   })
});
 
 $(document).on('change', '.emp-store_id', function () {
        var last_selected;
        var values = $(this).parent().data('values') || [];
        // var index = values.indexOf(this.value);
        // index >= 0 ? values.splice(index, 1) : values.push(this.value);
        // $(this).parent().data('values', values);
        /*if($(this).is(":selected")) {
          last_selected = $(this).attr('value');
        }*/

        var values = $(this).val();
        var lastSelectedID = values[values.length - 1];

        console.log(lastSelectedID)
        console.log(values)

      /*$.ajax({
         type: "POST",
         url: "<?= base_url('getTerminal')?>",
         data: {
            id: id
         },
         dataType: "json",
         encode: true,
      }).done(function (data) {
         console.log(data.data);
         alertMessage(data.status, data.message);
         $('.terminal_id').html(data.data);
      })*/
   });

   function checkTransferStores()
    {
      var supply_store_id = $('#supply_store_id').val();
      var receive_store_id = $('#receiver_store_id').val();
      var supply_loc_id = $('#location_id').val();
      var receive_loc_id = $('#rec_location_id').val();

      if(supply_store_id != "" && receive_store_id != "" && supply_loc_id != "" && receive_loc_id != ""){
        if(supply_store_id == receive_store_id && supply_loc_id == receive_loc_id) {
          alertMessage('false','You can not choose same store and locations for supply and receive');
          $('#rec_location_id').val('');
          return false;
        }
      }

    }

   $('#supply_store_id').change(checkTransferStores);
   $('#receiver_store_id').change(checkTransferStores);
   $('#location_id').change(checkTransferStores);
   $('#rec_location_id').change(checkTransferStores);

   $('#addLocation').click(function(){
      $('#add-new-location').modal('show')
    });

    $(document).on('click','.addLocation',function(){
      var self = $(this);
      var id = self.attr('data-id');
      $.ajax({
          type: "POST",
          url: '<?= base_url() ?>'+'/get_table_row_data',
          data: {table_name:'location',id:id},
          success: function (res) { 
            res = JSON.parse(res);
            if(res.status == "true") {
              var data = res.data;

              $('#location_id').val(id);
              $('#store_id').val(data.store_id);
              $('#store_id').attr('disabled','disabled');
              $('#location_type').val(data.location_type);
              $('#location_type').attr('disabled','disabled');
              $('#location_description').val(data.location_description);
              $('#add-new-location').modal('show')
            }
          }
      });
    });

    /*$('.clear-s-t').on('click',function(){
      var type = $(this).attr('data-type');
      var msg = 'Are you sure you wat to clear the data?';
      var date = $('#s-t-date').val();
      if(date == "") {
        alert('Please select date till which you want to clear stock');
        return false;
      }
      if(type == "1") {
        msg = 'Are you sure you want to clear the stock?';
      } else if(type == "2") {
        msg = 'Are you sure you want to clear the transactions?';
      } else if(type =="3") {
        msg = 'Are you sure you want to clear the stock & transactions?';
      }
      swal({
          title: msg,
          text: "",
          icon: "warning",
          buttons: {
                  cancel: {
                      text: "Cancel",
                      value: null,
                      visible: true,
                      className: "",
                      closeModal: false,
                  },
                  confirm: {
                      text: "Yes, Clear",
                      value: true,
                      visible: true,
                      className: "",
                      closeModal: false
                  }
          }
      }).then(isConfirm => {
          if (isConfirm) {
              $.ajax({
                 type: "POST",
                 url: '<?=base_url()?>'+'/settings/clear-stock-transaction',
                 data: {
                    type: type,
                    date: date
                 },
                 dataType: "json",
                 encode: true,
              }).done(function (data) {
                 if(data.status == 'true'){
                    swal("Cleared!", data.message, "success");
                 } else {
                    swal("Error", "Something went wrong", "error");
                 }
              });
          } else {
            $('.swal-overlay').removeClass('swal-overlay--show-modal');
          }
      });
    });*/

    $('.clear-s-t').on('click',function(){
        var type = $(this).attr('data-type');
        var msg = 'Are you sure you want to clear the data?';
        var date = $('#s-t-date').val();
        if(date == "") {
          alert('Please select date till which you want to clear stock');
          return false;
        }

        if(type == "1") {
          msg = 'Are you sure you want to clear the stock? If Yes, then please enter Pin';
        } else if(type == "2") {
          msg = 'Are you sure you want to clear the transactions? If Yes, then please enter Pin';
        } else if(type =="3") {
          msg = 'Are you sure you want to clear the stock & transactions? If Yes, then please enter Pin';
        }

        swal(msg, {
                content: "input",
                buttons: {
                      cancel: {
                          text: "Cancel",
                          value: "cancel",
                          visible: true,
                          className: "",
                          closeModal: true,
                      },
                      confirm: {
                          text: "OK",
                          value: true,
                          visible: true,
                          className: "",
                          closeModal: false
                      }
                }
            })
            .then((value) => {
              console.log(value)
              if(value == "cancel") {
                swal("Cancel successfully!", "", "error");
                setTimeout(function(){
                  window.location.reload();
                },500)
              } else {
                if (value === false) return false;
                if (value === "") {
                    swal("You need to add Pin!", "", "error");
                    return false;
                }
                $.ajax({
                   type: "POST",
                   url: '<?=base_url()?>'+'/check_pin',
                   data: {
                      pin: value
                   },
                   dataType: "json",
                   encode: true,
                }).done(function (data) {
                   if(data.status == 'true'){
                      $.ajax({
                         type: "POST",
                         url: '<?=base_url()?>'+'/settings/clear-stock-transaction',
                         data: {
                            type: type,
                            date: date
                         },
                         dataType: "json",
                         encode: true,
                      }).done(function (data) {
                         if(data.status == 'true'){
                            swal("Cleared!", data.message, "success");
                         } else {
                            swal("Error", "Something went wrong", "error");
                         }
                      });
                   } else {
                      swal("Error", "Incorrect pin", "error");
                   }
                });
              }
              
            })

    });

    $(document).on('click','.is_admin_role',function(){
      toastr.error('Admin role cannot be edited or deleted','Inconceivable');
    });

    $(document).on('click','.chk',function(){
      var switchery = $(this).parent('fieldset').closest('div.icheck_minimal');
      var sec = switchery.attr('data-sec');
      var row = switchery.siblings('div.'+sec).children('div.col-md-6').children('div').children('.switchery')
      var checkbox = row[0];

      if(!row.is(":checked")) {
        $(checkbox).trigger('click');
      }
    })

   document.body.style.zoom = '80%';
</script>