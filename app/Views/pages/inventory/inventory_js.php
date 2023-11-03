<script>
  $(".toggle-explore").click(function(){
    $(this).toggleClass("fa-angle-right fa-angle-up");
    $(this).closest("tr").next("tr").toggleClass("explore-Row"); 
  }); 
  
  function addStockAdjustment (argument) {

    var items = '<?php echo isset($data['items'])?$data['items']:""; ?>';
    var itemArray = JSON.parse(items);

    var table = document.getElementById("myTable");
    var t1=(table.rows.length);
    var t = t1;
    var row = table.insertRow(t1);
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    var cell4 = row.insertCell(4);
    var cell5 = row.insertCell(5);
    row.className = "new-row";
    //$('td:eq(0)', row).attr('colspan', 2);
    cell0.className='text-center';
    cell1.className='text-center';
    cell2.className='text-center';
    cell3.className='text-center';
    cell4.className='text-center';
    cell5.className='text-center';

    var options = "";
    $.each(itemArray,function(k,v){
        options += '<option data-price="'+v.supply_price+'" value="'+v.id+'">'+v.item_name+'</option>'
    });

     // $('<span class="tabledit-span" >'+t1+'</span>').appendTo(cell0)
    $('<select class="form-control form-select item-add item_id" name="item['+t+'][item_id]"><option value="">Click to select item</option>'+options+'</select>').appendTo(cell0);
    $('<input class="tabledit-input form-control quantity" type="number" name="item['+t+'][quantity]" id="item['+t+']quantity[]" value=""  >').appendTo(cell1); 
    $('<input class="tabledit-input form-control item_per_cost" type="number" name="item['+t+'][item_per_cost]" id="item['+t+'][item_per_cost]" value="">').appendTo(cell2);
    $('<input class="tabledit-input form-control cost" type="number" name="item['+t+'][cost]" id="item['+t+']cost[]" value=""  >').appendTo(cell3);
    $('<a href="" class="transh-icon-color"><i class="fa fa-trash-o"></i></a>').appendTo(cell4);
  
  }

  $(document).on('click','.addReason',function(){
    if($(this).attr('data-act') == "edit") {
      $('#reason-id').val($(this).attr('data-id'))
      $('#reason').val($(this).attr('data-val'))
    } else {
      $('#reason-id').val('')
      $('#reason').val('')
    }
    $('#add-new-reason').modal('show')
  })
  $(document).on('change','.transfer-status',function() {
    var i = 0;
    if($(this).val() == '1') {
      $('#transfer-tbody').find('tr').each(function(){
          $('.approve-td').removeClass('d-none');
          $(this).find('td').eq(7).after('<td class="approve-th"><input type="text" name="items['+i+'][received_qty]" class="form-control received_qty"></td>');//<td class="approve-th"><input type="text" name="items['+i+'][variance]" class="form-control variance"></td>
          i++;
      });
    }else{
      $('.approve-td').addClass('d-none');
      $('.approve-th').remove();
    }
  });
  $(document).on('keyup','.received_qty',function(){
    
      var self = $(this);
      var row = $(this).closest("tr");
      var qty = parseFloat(row.find('.qty').val());
      var num = '';
      /*if(self.val() != '') {
        num = Math.abs(parseInt(self.val()) - qty);
      }
      var variance = num;
      setTimeout(function(){
      row.find('.variance').val(variance);
    },500);*/
  });
  $(document).on('change','.item_id',function() { 
      var self = $(this);
      var price = self.find(':selected').attr('data-price');
      var row = $(this).closest("tr");
      parseFloat(row.find('.item_per_cost').val(price));
  });
  $(document).on('keyup','.quantity',function() {

      var self = $(this);
      var quantity = self.val();
      var row = $(this).closest("tr");
      var qty = parseFloat(row.find('.quantity').val());

      var item_per_cost = parseFloat(row.find('.item_per_cost').val());
      netTotal = qty * item_per_cost;
     parseFloat(row.find('.cost').val(netTotal));
      calculateAdjustAmount()
  });
  $(document).on('keyup','.item_per_cost',function() {

      var self = $(this);
      var item_per_cost = self.val();
      var row = $(this).closest("tr");
      var qty = parseFloat(row.find('.quantity').val());
      var item_per_cost = parseFloat(row.find('.item_per_cost').val());
      netTotal = qty * item_per_cost;
     parseFloat(row.find('.cost').val(netTotal));
      calculateAdjustAmount()
  });
  $(document).on('keyup','.cost',function() {

      var self = $(this);
      var cost = self.val();

      calculateAmount()
  });
  function calculateAdjustAmount()
  {
    var qty = parseFloat($('.qty').val());
      var item_per_cost = parseFloat($('.item_per_cost').val());

    var sum = 0;
    $('.quantity').each(function()
    { 
      var value = $(this).val();
      if(value > 0)
        sum += parseFloat(value);
      });
    
    $('.total_quantity').val(sum);
    $('#total_qty').html(sum);

   var sum2 = 0;
    $('.cost').each(function()
    { 
      var value = $(this).val();
      if(value > 0)
        sum2 += parseFloat(value);
    });
    console.log(sum2);
   $('.total_cost').val(sum2+'.00');
   $('#total_cost').html(sum2+'.00');
  }

  $(document).ready(function(){
    $(document).on('click','.edit-inventory',function(e) { 
      e.preventDefault();
      var id = $(this).attr('data-id');
      $.ajax({
          type: "POST",
          url: '<?= base_url() ?>'+'/inventory/getInventoryDetails',
          data: {id:id},
          success: function (res) {
            if(res.status == "true") {
              var data = res.data;
              $('#current_inventory_id').val(id);
              var rows = "";
              $.each(data,function(k,v){
                rows += '<tr class="new-row">'+
                         '<td class="text-center inventory-id">'+
                            '<input type="hidden" name="details['+k+'][id]" value="'+v.id+'">'+
                            '<input type="text" class="form-control" name="details['+k+'][lot_no]" value="'+v.lot_no+'">'+
                         '</td>'+
                         '<td class="text-center">'+
                            '<input type="date" class="form-control" name="details['+k+'][dom]" value="'+v.dom+'">'+
                         '</td>'+
                         '<td class="text-center">'+
                            '<input type="date" class="form-control" name="details['+k+'][expiry_date]" value="'+v.expiry_date+'">'+
                         '</td>'+
                         '<td class="text-center">'+
                            '<input type="number" class="form-control" name="details['+k+'][qty]" value="'+v.qty+'">'+
                         '</td>'+
                        '</tr>';
              });
              $('#inventory-details-tbl > tbody').html(rows)
              $('#inventory-modification').modal('show')
            } else {
              alertMessage(res.status,res.message);
            }
          }
      });
    })

    $('#btnSubmitInventory').click(function(){
      var formData = $('#inventory_details_form').serializeArray();
      $.ajax({
          type: "POST",
          url: '<?= base_url() ?>'+'/inventory/submitInventoryDetails',
          data: formData,
          success: function (res) { 
            if(res.status == "true") {
              alertMessage(res.status,res.message);
              window.location.reload();
            }
          }
      });
    });

    $('.pr-items').select2({
      minimumInputLength: 2,
      containerCssClass: "main-item"
    });
    $('.items-pr-1').select2({
      minimumInputLength: 2
    });
  })

  function addTransferField(){

    var table = document.getElementById("Add-Transfer");
    var t1=(table.rows.length);
    var row = table.insertRow(t1);
    var t1 = t1-1;
    var t = t1+1;
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    var cell4 = row.insertCell(4);
    var cell5 = row.insertCell(5);
    var cell6 = row.insertCell(6);
    var cell7 = row.insertCell(7);
    var cell8 = row.insertCell(8);

    row.className = "new-row";
    cell0.className='text-center';
    cell1.className='text-left';
    cell2.className='text-center';
    cell3.className='text-center';
    cell4.className='text-center';
    cell5.className='text-center';
    cell6.className='text-center';
    cell7.className='text-center';
    cell8.className='text-center';

    var items = '<?= isset($data['items'])?$data['items']:""?>';
    var itemArray =  JSON.parse(items);
   
    var options = "";
    options += '<option value="">Please Select</option>';
    $.each(itemArray,function(k,v){
        options += '<option value="'+v.id+'">'+v.item_name+'</option>'
    });

    var cls = 't-item-id'+t;
    $('<span class="tabledit-span" >'+t+'</span>').appendTo(cell0)
    $('<select class="form-control form-select transfer-item-add '+cls+'" name="items['+t1+'][item_id]">'+options+'</select>').appendTo(cell1);
    $('<input type="text" class="form-control sku_barcode"  name="items['+t1+'][barcode]">').appendTo(cell2);
    $('<select class="form-control form-select manufacture_date" name="items['+t1+'][manufacture_date]"><option value="">Select</option></select>').appendTo(cell3);
    $('<input class="form-control cost_price" type="text" name="items['+t1+'][cost_price]">').appendTo(cell4);
    $('<input class="form-control selling_price" type="number" name="items['+t1+'][selling_price]">').appendTo(cell5);
    $('<input class="form-control inventory_qty" type="number" name="items['+t1+'][inventory_qty]">').appendTo(cell6);
    $('<input class="form-control qty" type="number" name="items['+t1+'][quantity]">').appendTo(cell7);
    if($('#status').val() == "1") {
      var cell9 = row.insertCell(9);
      cell8.className='approve-td';
      cell9.className='text-center';

      $('<input type="text" name="items['+t1+'][received_qty]" class="form-control received_qty">').appendTo(cell8);
      $('<a href="#"  class="transh-icon-color item-remove"><i class="fa fa-trash-o"></i></a>').appendTo(cell9);
    } else {
      $('<a href="#"  class="transh-icon-color item-remove"><i class="fa fa-trash-o"></i></a>').appendTo(cell8);
    }
    $('.'+cls).select2({
      minimumInputLength: 2
    });
  }

  $('.t-item-id').select2({
      minimumInputLength: 2
  });

  function addProductionField(){

   var table = document.getElementById("production-tbl");
      var t1=(table.rows.length);
      var row = table.insertRow(t1);
      var t1 = t1;

      var cell0 = row.insertCell(0);
      var cell1 = row.insertCell(1);
      var cell2 = row.insertCell(2);
      var cell3 = row.insertCell(3);
      var cell4 = row.insertCell(4);

      row.className = "new-row";
      cell0.className='text-center';
      cell1.className='';
      cell2.className='text-center';
      cell3.className='text-center';
      cell4.className='text-center';
      
      var id = 'item_id-pr'+t1;

      var items = '<?= isset($data['ingredients'])?$data['ingredients']:""?>';
      var itemArray =  JSON.parse(items);
   
      var options = "";
      options += '<option value="">Please Select</option>';
      $.each(itemArray,function(k,v){
        options += '<option value="'+v.id+'">'+v.item_name+'</option>'
      });
      $('<span class="tabledit-span">'+t1+'</span>').appendTo(cell0)
      $('<select class="form-control form-select item-add '+id+'" name="items['+t1+'][item_id]">'+options+'</select>').appendTo(cell1);
      $('<input class="form-control selling_price" type="number" name="items['+t1+'][selling_price]">').appendTo(cell2);
      $('<input class="form-control qty" type="number" name="items['+t1+'][quantity]" value="1">').appendTo(cell3);
      $('<a href="#"  class="transh-icon-color item-remove"><i class="fa fa-trash-o"></i></a>').appendTo(cell4);
      
      $('.'+id).select2({
        minimumInputLength: 2
      });
  }
  $(document).on('change','.transfer-item-add',function() {

      let self = $(this);
      let id = self.val();
      let location = $('#location_id').val();
      let supplyStore = $('#supply_store_id').val();

      var i = self.attr('data-row');
      $.ajax({
          type: "POST",
          url: '<?= base_url() ?>'+'/getItemDetail',
          data: {id:id,location_id:location,supply_store_id:supplyStore},
          success: function (res) { 
            res = JSON.parse(res);
            if(res.status == "true") {
              var data = res.data;

              self.parents('td').siblings('td').children('.rate').val(data.retail_price);
              self.parents('td').siblings('td').children('.sku_barcode').val(data.sku_barcode);
              self.parents('td').siblings('td').children('.inventory_qty').val(res.qty);
              self.parents('td').siblings('td').children('.selling_price').val(data.retail_price);
              self.parents('td').siblings('td').children('.cost_price').val(data.supply_price);
              var quantity = self.parents('td').siblings('td').children('.quantity').val();

              var lot = res.details;
              var options = "";
              $.each(lot,function(k,v){
                options += '<option value="'+v.id+'" data-qty="'+v.qty+'">'+v.dom+' - '+v.expiry_date+' ('+v.lot_no+')'+'</option>';
              });
              self.parents('td').siblings('td').children('.manufacture_date').html(options);
            }
          }
      });

  });

  $(document).on('change','#location_id',function(){
    var location = $(this).val();
    var store = $('#supply_store_id').val();
    if(location != "" && store != "") {
      $('.transfer-item-add').each(function(k,v){
        var self = $(this);
        if($(this).val() != "") {
          $.ajax({
              type: "POST",
              url: '<?= base_url() ?>'+'/getInventoryDetailsByLocation',
              data: {location_id:location,store_id:store,item_id:$(this).val()},
              success: function (res) { 
                res = JSON.parse(res);
                if(res.status == "true") {

                  var lot = res.details;
                  var options = "";
                  $.each(lot,function(k,v){
                    options += '<option value="'+v.id+'" data-qty="'+v.qty+'">'+v.dom+' - '+v.expiry_date+' ('+v.lot_no+')'+'</option>';
                  });
                  self.parents('td').siblings('td').children('.manufacture_date').html(options);
                } else {
                  alertMessage(res.status,res.message)
                }
              }
          });
        }
      })
    }
  })

  $(document).on('change','.manufacture_date',function(){
    var qty = $('option:selected', this).attr('data-qty');
    $(this).parents('td').siblings('td').children('.inventory_qty').val(qty)
  })
  $('#supply_store_id').change(function(){
      var id = $(this).val();
      var rec_id = $('#receiver_store_id').val();
      if(id == rec_id) {
        $('#status').val('1');
        // $('#status').attr('disabled','disabled');
        var i=0;
        $('#transfer-tbody').find('tr').each(function(){
            $('.approve-td').removeClass('d-none');
            $(this).find('td').eq(7).after('<td class="approve-th"><input type="text" name="items['+i+'][received_qty]" class="form-control received_qty"></td>');//<td class="approve-th"><input type="text" name="items['+i+'][variance]" class="form-control variance"></td>
            i++;
        });
      } else {
        $('#status').val('');
        // $('#status').removeAttr('disabled');
        $('.approve-td').addClass('d-none');
        $('.approve-th').remove();
      }

      $.ajax({
          type: "POST",
          url: '<?= base_url() ?>'+'/get_location_by_store',
          data: {id:id},
          success: function (res) {
            res = JSON.parse(res);
            if(res.status == "true") {
              var data = res.data;
              $('#location_id').html(data);
            } else {
              alertMessage('false','No Location in the selected store');
              $('#location_id').html('<option value="">NLocation</option>');
            }
          }
      });
  })

  $('#receiver_store_id').change(function(){
      var id = $(this).val();
      var supply_id = $('#supply_store_id').val();
      if(id == supply_id) {
        $('#status').val('1');
        // $('#status').attr('disabled','disabled');
        var i=0;
        $('#transfer-tbody').find('tr').each(function(){
            $('.approve-td').removeClass('d-none');
            $(this).find('td').eq(7).after('<td class="approve-th"><input type="text" name="items['+i+'][received_qty]" class="form-control received_qty"></td>');//<td class="approve-th"><input type="text" name="items['+i+'][variance]" class="form-control variance"></td>
            i++;
        });
      } else {
        $('#status').val('');
        // $('#status').removeAttr('disabled');
        $('.approve-td').addClass('d-none');
        $('.approve-th').remove();
      }
      $.ajax({
          type: "POST",
          url: '<?= base_url() ?>'+'/get_location_by_store',
          data: {id:id},
          success: function (res) {
            res = JSON.parse(res);
            if(res.status == "true") {
              var data = res.data;
              $('#rec_location_id').html(data);
            } else {
              alertMessage('false','No Location added in the selected store');
              $('#rec_location_id').html('<option value="">Location</option>');
            }
          }
      });
  })
  $(document).on('keyup','.qty',function(){
    if($('#status').val() == "1") {
      var qty = $(this).val();
      $(this).parents('td').siblings('td').children('.received_qty').val(qty);
    }
  })
</script>