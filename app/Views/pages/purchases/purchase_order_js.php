<script>
  function addPurchaseOrderField (argument) {

    var table = document.getElementById("myTable");
    var t1=(table.rows.length);
    
    var row = table.insertRow(t1);
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    var cell4 = row.insertCell(4);
    var cell5 = row.insertCell(5);
    var cell6 = row.insertCell(6);
    var cell7 = row.insertCell(7);
    var cell8 = row.insertCell(8);
    
    var addClass = "";
    if($('#is_include_tax').prop('checked') == true){
      addClass="";
    }else{
      addClass="d-none";
    }
    row.className = "new-row";
      
    cell0.className='text-center orderControl tableOrder vert-align-md';
    cell1.className='text-left item-row';
    cell2.className='text-left';
    cell3.className='text-center';
    cell4.className='text-center';
    cell5.className='text-center'; 
    cell6.className='text-center form-group vert-align-md';
    cell7.className='text-center';
    cell8.className='text-center vert-align-md';
    
    var items = '<?php echo isset($data['items'])?$data['items']:""; ?>';
    var itemArray = JSON.parse(items);
    var options = "<option value=''>Click to select item</option>";
    $.each(itemArray,function(k,v){
        options += '<option value="'+v.id+'">'+v.item_name+'</option>'
    });

    var id = 'item_id-pr'+t1;

      $('<span class="tabledit-span" >'+t1+'</span>').appendTo(cell0)
      $('<select class="form-control form-border form-select item-add '+id+'" name="items['+t1+'][item_id]" data-row="'+t1+'">'+options+'</select>').appendTo(cell1);
      $('<input class="form-control form-border quantity" type="number" name="items['+t1+'][quantity]" value="1"><div style="margin: 5px;" class="uom-v">kg</div><input class="uom form-control form-border " type="hidden" name="items['+t1+'][uom]" value=""><input class="uomid form-control form-border " type="hidden" name="items['+t1+'][uomid]">').appendTo(cell2);
      $('<input class="form-control form-border rate" type="text" name="items['+t1+'][rate]" value=""  >').appendTo(cell3);
      $('<input class="discount form-control form-border " type="number" name="items['+t1+'][discount]" value="">&nbsp;<select class="form-control form-border discount_type form-select" name="items['+t1+'][discount_type]"><option value="%">%</option><option value="ZMW">ZMW</option></select><input class="discount_amount form-control " type="hidden" name="items['+t1+'][discount_amount]" value="0">').appendTo(cell4);
      $('<input type="text" class="form-control tax_amount" name="items['+t1+'][tax_amount]" readonly><input class="form-control form-border tax" type="hidden" name="items['+t1+'][tax]" value=""><input class="form-control form-border tax_type" readonly type="hidden" name="items['+t1+'][tax_type]">').appendTo(cell5);
      $('<input type="hidden" class="tax_exc_amt" name="items['+t1+'][tax_exc_amt]" value="0"><input class="tax_excl" id="tax_excl'+t1+'" type="checkbox" name="items['+t1+'][tax_excl]" value="1"><label for="tax_excl'+t1+'"></label>').appendTo(cell6);
      $('<input class="tabledit-input form-control form-border lot_no" type="hidden" name="items['+t1+'][lot_no]"><input class="tabledit-input form-control form-border dom" type="hidden" name="items['+t1+'][dom]"><input class="tabledit-input form-control form-border expiry_date" type="hidden" name="items['+t1+'][expiry_date]"><input class="tabledit-input form-control form-border amount" type="text" name="items['+t1+'][amount]">').appendTo(cell7);
      $('<a href="javascript:void(0);" class="transh-icon-color add-more" data-no="'+t1+'" title="Add more"><i class="fa fa-plus"></i></a>&nbsp;&nbsp;<a href="#" class="transh-icon-color item-remove" title="Remove"><i class="fa fa-trash-o"></i></a>').appendTo(cell8);

      /*$('.'+id).select2({
        minimumInputLength: 2
      });*/
      $('.'+id).select2({
          placeholder: 'Select Item',
          minimumInputLength: 3,
          ajax: {
              url: base_url+'searchItems?type=purchase',
              dataType: 'json',
              delay: 250,
              data: function (params) {
                  return {
                      term: params.term
                  };
              },
              processResults: function (data) {
                var results = [];
                $.each(data.data, function (index, obj) {
                    results.push({
                        id: obj.id,
                        text: obj.item_name
                    });
                });
                return {
                    results: results
                };
              }
          }
    });
  }

  /*$('.item_id-pr').select2({
    minimumInputLength: 2
  });*/
  $(document).ready(function() { 

    $('.item_id-pr').select2({
          placeholder: 'Select Item',
          minimumInputLength: 3,
          ajax: {
              url: base_url+'searchItems?type=purchase',
              dataType: 'json',
              delay: 250,
              data: function (params) {
                  return {
                      term: params.term
                  };
              },
              processResults: function (data) {
                var results = [];
                $.each(data.data, function (index, obj) {
                    results.push({
                        id: obj.id,
                        text: obj.item_name
                    });
                });
                return {
                    results: results
                };
              }
          }
    });
  });
  var isCurrencySelect = $("#currency_id option:selected");
  if(isCurrencySelect.val() != "" && isCurrencySelect.val() != undefined) {
    console.log(isCurrencySelect.val())
    $('.curr-row').removeClass('d-none');
    $('.conv-currency').css('visibility','visible');
  }

  if($('#v_currency_id').val() != "" && $('#v_currency_id').val() != undefined && $('#v_currency_id').val() != "N/A") {
    $('.curr-row').removeClass('d-none');
    $('.conv-currency').css('visibility','visible');
  }

$("#terms").change(function(){
    var val = parseInt($(this).val());
    var setDueDate = "";
    switch(val) {
      case 0:
        var d = new Date();
        var e = new Date(d.getFullYear(), d.getMonth() + 1, 0);
        setDueDate = e.getFullYear() + "-" + ("0"+(e.getMonth()+1)).slice(-2) + "-" + ("0" + e.getDate()).slice(-2);
      break;
      case 1:
        var d = new Date();
        var e = new Date(d.getFullYear(), d.getMonth() + 2, 0);
        setDueDate = e.getFullYear() + "-" + ("0"+(e.getMonth()+1)).slice(-2) + "-" + ("0" + e.getDate()).slice(-2);
      break;
      case 2:
        var d = new Date();
        setDueDate = d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2);
      break;
      default:
        var d = new Date();
        d.setDate(d.getDate() + val);
        setDueDate = d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2);
      break;
    }
    
    $("#due_date").val(setDueDate);
});

$(document).on('change','.item-add',function() {

    let self = $(this);
    let id = self.val();
    var tab = self.attr('data-tab');
    var i = self.attr('data-row');
    $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+'/getItemDetail',
        data: {id:id},
        success: function (res) { 
          res = JSON.parse(res);
          if(res.status == "true") {
            var data = res.data;
            var tax_amount = 0;

            /*if($('#is_include_tax').prop('checked')==true){
              var tax_perc = 1.0 + parseFloat(data.tax_rate/100); 
              tax_amount = parseFloat(data.retail_price) - (parseFloat(data.retail_price) / parseFloat(tax_perc));
            }*/

            // if(tab != undefined && tab == 'sell'){
              var tax_perc = 1.0 + parseFloat(data.tax_rate/100);
              var price = data.retail_price ? parseFloat(data.retail_price) : 0;
              tax_amount = parseFloat(price) - (parseFloat(price) / parseFloat(tax_perc));
            // }
            var itemOpt = JSON.parse(res.data.item_options)
            if(itemOpt.track_serial_no != undefined && itemOpt.track_serial_no == 1 && tab != 'sell') {
              self.parents('td').append('<textarea class="form-control serial_no" name="items['+i+'][serial_no]" placeholder="Add Serial Number"></textarea>');
            }
            self.parents('td').siblings('td').children('.uom-v').text(data.uom);
            self.parents('td').siblings('td').children('.uom').val(data.uom);
            self.parents('td').siblings('td').children('.uomid').val(data.uom_id);
            self.parents('td').siblings('td').children('.rate').val(data.retail_price);
            self.parents('td').siblings('td').children('.tax').val(data.tax_rate);
            //self.parents('td').siblings('td').children('.tax_type').val(data.tax_type);
            self.parents('td').siblings('td').children('.tax_type').val(data.tax_type);//.prop('selected', true);
            self.parents('td').siblings('td').children('.tax_amount').val(tax_amount.toFixed(2));
            /*transfer start*/
            self.parents('td').siblings('td').children('.sku_barcode').val(data.sku_barcode);
            self.parents('td').siblings('td').children('.inventory_qty').val(data.current_inventory);
            self.parents('td').siblings('td').children('.selling_price').val(data.retail_price);
            self.parents('td').siblings('td').children('.cost_price').val(data.supply_price);
            /*transfer end*/
           
            var quantity = self.parents('td').siblings('td').children('.quantity').val();

            self.parents('td').siblings('td').children('.amount').val(quantity*price);
            
            var currency_rate = $('#currency_id').find(':selected').attr('data-rate');
            if(currency_rate !== undefined) {
              currency_rate = (quantity*price)*currency_rate;
              self.parents('td').siblings('td').children('.currency').val(currency_rate.toFixed(2));
              $('.conv-currency').css('visibility','visible');
            }
            var count = $('#item-count').val();
            var rowCount = $('#sellItemTable >tbody >tr').length;
            var status = '<?= isset($data['status'])?strip_tags($data['status']):'Draft'?>'

            if(count > 0 && count != rowCount && status != 'Draft') {
              somethingChanged = true;
            }

            if(tab != undefined && tab == 'sell'){
              calculateSellAmount()
            }else{
              calculateAmount()
            }
          }
        }
    });

});
function discountCalculateAmount(discount,discount_type,tax_amount){
    return parseFloat(tax_amount) * parseFloat(discount) / 100;
}
$(document).on('change','.rate',function() {
   
    var self = $(this);
    var price = self.val();
    var quantity = self.parents('td').siblings('td').children('.quantity').val();
    var tax_rate = self.parents('td').siblings('td').children('.tax').val();
    var tab = self.parents('td').siblings('td').children('.item-add').attr('data-tab');
    var discount = self.parents('td').siblings('td').children('.discount').val();
    var discount_type =  self.parents('td').children('.discount_type').val();
   
    var discount_amount = 0;
   
    self.parents('td').siblings('td').children('.amount').val(quantity*price);
     if(parseFloat(discount) > 0){
          discount_amount =  discountCalculateAmount(discount,discount_type,quantity*price);
          self.parents('td').siblings('td').children('.discount_amount').val(discount_amount);
     }
    var tax_amount = 0.00;

    var isExcl = self.parents('td').siblings('td').children('.tax_excl');
    if(tax_rate > 0) {
      if(isExcl.is(":checked")) {
        var tax_perc = 1.0 + parseFloat(tax_rate/100); 
        tax_amount = parseFloat(quantity*price) - (parseFloat(quantity*price) / parseFloat(tax_perc));
              self.parents('td').siblings('td').children('.tax_amount').val(tax_amount.toFixed(2));
        var t = self.parents('td').children('.tax_exc_amt').val(tax_amount.toFixed(2));
        
      }else{
        var tax_perc = 1.0 + parseFloat(tax_rate/100); 
        tax_amount = parseFloat(quantity*price) - (parseFloat(quantity*price) / parseFloat(tax_perc));
        self.parents('td').siblings('td').children('.tax_amount').val(tax_amount.toFixed(2));
        self.parents('td').children('.tax_exc_amt').val('0');
        
      }
    }

    if(tab == 'sell'){
      calculateSellAmount();
    } else {
      calculateAmount();
    }
    
});
$(document).on('change','.quantity',function() {
   
    var self = $(this);
    var quantity = self.val();
    var price = self.parents('td').siblings('td').children('.rate').val();
    var tax_rate = self.parents('td').siblings('td').children('.tax').val();
    var tab = self.parents('td').siblings('td').children('.item-add').attr('data-tab');
    var discount = self.parents('td').siblings('td').children('.discount').val();
    var discount_type =  self.parents('td').children('.discount_type').val();
   
    var discount_amount = 0;
   
    self.parents('td').siblings('td').children('.amount').val(quantity*price);
    if(parseFloat(discount) > 0){
            discount_amount =  discountCalculateAmount(discount,discount_type,quantity*price);
           self.parents('td').siblings('td').children('.discount_amount').val(discount_amount);
    }
    var tax_amount = 0.00;
    var isExcl = self.parents('td').siblings('td').children('.tax_excl');
    if(tax_rate > 0) {
      if(isExcl.is(":checked")) {
        var tax_perc = 1.0 + parseFloat(tax_rate/100); 
        tax_amount = parseFloat(quantity*price) - (parseFloat(price) / parseFloat(tax_perc));
              self.parents('td').siblings('td').children('.tax_amount').val(tax_amount.toFixed(2));
        var t = self.parents('td').children('.tax_exc_amt').val(tax_amount.toFixed(2));
        
      }else{
        var tax_perc = 1.0 + parseFloat(tax_rate/100); 
        tax_amount = parseFloat(quantity*price) - (parseFloat(quantity*price) / parseFloat(tax_perc));
        self.parents('td').siblings('td').children('.tax_amount').val(tax_amount.toFixed(2));
        self.parents('td').children('.tax_exc_amt').val('0');
        
      }
    }   
    
    var currency_id = $('#currency_id').find(':selected').attr('data-rate');
    /*var currency_rate  = 0;
    if(currency_id != ""){
      currency_rate = (quantity*price)*currency_id;
      self.parents('td').siblings('td').children('.currency').val(currency_rate.toFixed(2));
    }*/
    if(tab == 'sell'){
      calculateSellAmount();
    } else {
      calculateAmount();
    }
    
});
$(document).on('click','.tax_excl',function(){
  
    var self = $(this);
    var tax_rate = self.parents('td').siblings('td').children('.tax').val();
    var retail_price = self.parents('td').siblings('td').children('.rate').val();
    var qty = self.parents('td').siblings('td').children('.quantity').val();
    var tab = self.parents('td').siblings('td').children('.item-add').attr('data-tab');
    var total_price = parseFloat(retail_price)*parseFloat(qty);
    if(tax_rate > 0) {
      if(self.is(":checked")) {
        var tax_perc = 1.0 + parseFloat(tax_rate/100); 
        var tax_amount = total_price - (total_price / parseFloat(tax_perc));
              self.parents('td').siblings('td').children('.tax_amount').val(tax_amount.toFixed(2));
        var t = self.parents('td').children('.tax_exc_amt').val(tax_amount.toFixed(2));
        if(tab == 'sell'){
          calculateSellAmount();
        } else {
          calculateAmount();
        }
      }else{
        var tax_perc = 1.0 + parseFloat(tax_rate/100); 
        var tax_amount = total_price - (total_price / parseFloat(tax_perc));
        self.parents('td').siblings('td').children('.tax_amount').val(tax_amount.toFixed(2));
        self.parents('td').children('.tax_exc_amt').val('0');
        if(tab == 'sell'){
          calculateSellAmount();
        } else {
          calculateAmount();
        }
      }
    }

});
$(document).on('change','#currency_id',function(){
    var currency_id = $(this).find(':selected').attr('data-rate');
    var type = $(this).attr('data-type');
    if(currency_id != undefined) {
      $('.curr-row').removeClass('d-none');

      $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+'/get_table_row_data',
        data: {table_name:'currencies',id:$(this).val()},
        success: function (res) { 
          res = JSON.parse(res);

          $('.conv-curr-symbol').text(res.data.currency_code);
          $('#conv-curr-name').text(res.data.currency_code);
        }
      })

    }else{
      $('.curr-row').addClass('d-none');
    }
    if(type == "sell") {
      calculateSellAmount()
    } else {
      calculateAmount();
    }
    // showCurrencyTab();
    /*$('.rate').each(function(){
        var inp = $(this);
        var qty = inp.parents('td').siblings('td').children('.quantity').val();
        var price = inp.val();
        if(price != "") {
          var currency_rate = (qty*price)*currency_id;
          inp.parents('td').siblings('td').children('.currency').val(currency_rate.toFixed(2));
        }
    })*/
    /*if(tab == 'sell'){
      tax_amount = parseFloat(quantity*price) - (parseFloat(quantity*price) / parseFloat(tax_perce)); 
      self.parents('td').siblings('td').children('.tax_amount').val(tax_amount.toFixed(2));
      var currency_id = $('#currency_id').find(':selected').attr('data-rate');
      var currency_rate  = 0;
      if(currency_id != ""){
        currency_rate = quantity*price/currency_id;
      }
      self.parents('td').siblings('td').children('.currency').val(currency_rate.toFixed(2));
    }*/

});
$(document).on('keyup','#currency_rate',function(){
    var c_rate = $(this).val();
    var type = $(this).attr('data-type');

    if(c_rate != "" || c_rate != undefined) {
        if(type == "sell") {
          calculateSellAmount()
        } else {
          calculateAmount();
        }
    }
});
$(document).on('change','.tax_type',function(){
    
    var self = $(this);
    var tax_rate = $('option:selected', this).attr('data-rate');
    var quantity = self.parents('td').siblings('td').children('.quantity').val();
    var price = self.parents('td').siblings('td').children('.rate').val();
    
    var tax = self.parents('td').children(".tax").val(tax_rate);
    
    var tax_amount = 0.00; 
    var tax_perc = 0;
     self.parents('td').children('.tax_amount').val(tax_amount);
     if(tax_rate > 0){
        tax_perc = 1.0 + parseFloat(tax_rate/100);

        tax_amount = parseFloat(quantity*price) - (parseFloat(quantity*price) / parseFloat(tax_perc));  
        self.parents('td').children('.tax_amount').val(tax_amount.toFixed(2));
        console.log(tax_amount);
    }
    calculateAmount();
   
})
$(document).on('change','.discount',function(){
    
    var self = $(this);
    var discount = self.val();
    var discount_type =  self.parents('td').children('.discount_type').val(); 
    var amount = self.parents('td').siblings('td').children('.amount').val();
    var discount_value = "";
    discount_value = amount * discount/ 100;
    self.parents('td').children('.discount_amount').val(discount_value); 
    calculateAmount();
    var tab = self.parents('td').siblings('td').children('.item-add').attr('data-tab');
    if(tab == 'sell') {
      calculateSellAmount();
    }
})
$(document).on('click','.item-refresh',function() {

    var self = $(this);
    self.parents('td').siblings('td').children('.uom').val('');
    self.parents('td').siblings('td').children('.uomid').val('');
    self.parents('td').siblings('td').children('.rate').val('');
    self.parents('td').siblings('td').children('.tax').val('');
    self.parents('td').siblings('td').children('.tax_type').val('');
    self.parents('td').siblings('td').children('.quantity').val('1');
    self.parents('td').siblings('td').children('.amount').val('');
    self.parents('td').siblings('td').children('.item-add').val('');
    calculateAmount()
});

$(document).on('click','.item-remove', function() {
    var del = $(this).attr('data-del');
    var tab = $(this).parents('td').siblings('td').children('.item-add').attr('data-tab');
    if(del !== undefined && del == 1) {

      var row = $(this).attr('data-row');
      var id = document.querySelector("#invoice_form input[name='items["+row+"][id]']");
      var item_id = document.querySelector("#invoice_form select[name='items["+row+"][item_id]']");
      var qty = document.querySelector("#invoice_form input[name='items["+row+"][quantity]']");

      var del = $('#deleted-items').val();
      var array = [];
      if(del !== "") {
        var prs = JSON.parse(del);
        array = prs
      }
      var obj = {
        'id':id.value,
        'item_id':item_id.value,
        'qty':qty.value
      }
      array.push(obj)
      $('#deleted-items').val(JSON.stringify(array));
    }
    $(this).closest("tr").remove();
    var count = $('#item-count').val();
    var rowCount = $('#sellItemTable >tbody >tr').length;
    var status = '<?= isset($data['status'])?strip_tags($data['status']):'Draft'?>'

    if(count > 0 && count != rowCount && status != 'Draft') {
      somethingChanged = true;
    }  
  
    if(tab == 'sell') {
      calculateSellAmount();
    } else {
      calculateAmount();
    }
});

/*function showCurrencyTab()
{
  var curr = $("#currency_id").val();
  if(curr == "") {
    $(".curr-row").addClass('d-none');
    $(".curr-th-row").addClass('d-none');
  } else {
    $(".curr-row").removeClass('d-none');
    $(".curr-th-row").removeClass('d-none');
  }
}*/

function calculateAmount()
{
  var subTotal = 0;var amount = 0;
  $('.amount').each(function()
  { 
    var value = $(this).val();
    if(value > 0)
      subTotal += parseFloat(value);
  });

  var tax = 0; var tax_text = "Tax";
  $('.tax').each(function()
  { 
    var value = $(this).val();
    if(value > 0)
      tax_text = 'Tax ';
  });
  $('#tax_text').text(tax_text);
  
  var tax_amount = 0; 
  $('.tax_amount').each(function()
  { 
    var value = $(this).val();

    if(value > 0)
      tax_amount += parseFloat(value);; 
  });

  var tax_excl_amt = 0; 
  $('.tax_exc_amt').each(function()
  { 
    var value = $(this).val();
    if(value > 0)
      tax_excl_amt += parseFloat(value);; 
  });
  
  var adjust = $('.adjustment_value').val();  
  if(adjust == ""){
    adjust = 0;
  }
  
  var discount_amount = 0; 
  $('.discount_amount').each(function()
  { 
    var value = $(this).val();
    if(value > 0)
      discount_amount += parseFloat(value); 
    });
  $('.discountAmount').text(discount_amount.toFixed(2));
  $('#total-discount').val(discount_amount.toFixed(2));

  var discount = 0; 
  $('.discount').each(function()
  { 
    var value = $(this).val();
    if(value > 0)
      discount += parseFloat(value); 
  });

  var total = subTotal + parseFloat(adjust) - parseFloat(discount_amount);
  var subTotalFinal = subTotal;
  if(discount > 0) {
    var subDiscount = subTotalFinal * discount /100;
    var txDiscount = tax_amount * discount /100;
    subTotalFinal = subTotalFinal - subDiscount;
    tax_amount = tax_amount - txDiscount
  }
  
  $('.taxAmount').text(tax_amount.toFixed(2));
  $('#total-tax').val(tax_amount);
  if(tax_excl_amt > 0) {
    total += tax_excl_amt;
    // subTotalFinal += tax_excl_amt;
  }
  $('#sub-total').val(subTotalFinal.toFixed(2));
  $('.subTotal').text(subTotalFinal.toFixed(2));
  $('#sub-curr-total').val(subTotal+'.00');
  $('#total-amount').val(total.toFixed(2));
  
  var currency_rate = $('#currency_rate').val();
  var currency_total  = 0, currency_sub_total= 0,c_discount=0;

  if(currency_rate !== "" && currency_rate != undefined){
    $('.conv-currency').css('visibility','visible');
    currency_total = total*parseFloat(currency_rate);
    currency_sub_total = subTotalFinal*parseFloat(currency_rate);
    currency_tax = tax_amount*parseFloat(currency_rate);
    c_discount = discount_amount*parseFloat(currency_rate);
    $('.subCurrTotal').text(currency_sub_total.toFixed(2))
    $('#sub-curr-total').val(currency_sub_total.toFixed(2))
    $('#curr-tax').val(currency_tax.toFixed(2));
    $('.currTax').text(currency_tax.toFixed(2));
    $('.currdiscountAmount').text(c_discount.toFixed(2));
    $('#curr-total-discount').val(c_discount.toFixed(2));
    $('#conv-total-amount').val(currency_total.toFixed(2));
  }
}

function calculateSellAmount()
{
  var subTotal = 0; var amount = 0;
  $('.amount').each(function()
  { 
    var value = $(this).val();
    if(value > 0)
      subTotal += parseFloat(value);
  });
  
  var tax = 0; var tax_text = "Tax";
  $('.tax').each(function()
  { 
    var value = $(this).val();
    if(value > 0)
      tax_text = 'Tax '// + $('.tax_type').val() +'('+value+'%)';
  });
  
  var tax_amount = 0; 
  $('.tax_amount').each(function()
  { 
    var value = $(this).val();

    if(value > 0)
      tax_amount += parseFloat(value);; 
  });

  var tax_excl_amt = 0; 
  $('.tax_exc_amt').each(function()
  { 
    var value = $(this).val();
    if(value > 0)
      tax_excl_amt += parseFloat(value);; 
  });
     
  $('.taxAmount').text(tax_amount.toFixed(2));
  $('#total-tax').val(tax_amount);
  $('#tax_text').text(tax_text);

  var adjust = $('.adjustment_value').val();  
  if(adjust == ""){
    adjust = 0;
  }
  
  var discount_amount = 0; 
  $('.discount_amount').each(function()
  { 
    var value = $(this).val();
    if(value > 0)
      discount_amount += parseFloat(value); 
    });
  $('.discountAmount').text(discount_amount.toFixed(2));
  $('#total-discount').val(discount_amount.toFixed(2));

  var total = subTotal + parseFloat(adjust) - parseFloat(discount_amount);
  var subTotalFinal = subTotal - tax_amount;
  if(tax_excl_amt > 0) {
    total += tax_excl_amt;
    subTotalFinal += tax_excl_amt;
  }
  $('#sub-total').val(subTotalFinal.toFixed(2));
  $('.subTotal').text(subTotalFinal.toFixed(2));
  $('#sub-curr-total').val(subTotal+'.00');
  $('#total-amount').val(total.toFixed(2));

  var tab = $('.item-add').attr('data-tab');
      // var currency_id = $('#currency_id').find(':selected').attr('data-rate');
      var currency_rate = $('#currency_rate').val();
      var currency_total  = 0, currency_sub_total= 0,c_discount=0;
      if(currency_rate !== "" && currency_rate != undefined){
        
        $('.conv-currency').css('visibility','visible');
        currency_total = total*parseFloat(currency_rate);
        currency_sub_total = subTotalFinal*parseFloat(currency_rate);
        currency_tax = tax_amount*parseFloat(currency_rate);
        c_discount = discount_amount*parseFloat(currency_rate);
        $('.subCurrTotal').text(currency_sub_total.toFixed(2))
        $('#sub-curr-total').val(currency_sub_total.toFixed(2))
        $('#curr-tax').val(currency_tax.toFixed(2));
        $('.currTax').text(currency_tax.toFixed(2));
        $('.currdiscountAmount').text(c_discount.toFixed(2));
        $('#curr-total-discount').val(c_discount.toFixed(2));
        $('#conv-total-amount').val(currency_total.toFixed(2));
      }
}
function addGoodsReturned(){
 var table = document.getElementById("Goods-Return");
    var t1=(table.rows.length);
    var row = table.insertRow(t1);
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    var cell4 = row.insertCell(4);
    var cell5 = row.insertCell(5);
    var cell6 = row.insertCell(6);
    var cell7 = row.insertCell(7);
    var cell8 = row.insertCell(8);
      /*cell1.className='abc';
      cell2.className='abc';*/
      row.className = "new-row";

   $('td:eq(1)', row).attr('colspan', 2);
   cell0.className='text-center';
   cell1.className='text-center';
   cell2.className='text-center';
   cell3.className='text-center';
   cell4.className='text-center';
   cell5.className='text-center';
   cell6.className='text-center';
   cell7.className='text-center';
   cell8.className='text-center pt-1';
     $('<span class="tabledit-span" >..</span>').appendTo(cell0)
     $('<select class="form-control form-select"><option value="0">Click to select item</option><option value="1">AIDE-00001 Bakery and Bread</option><option value="1">AIDE-00002 Pasta and Rice</option></select>').appendTo(cell1);
     $('<select class="form-control form-select"><option value="0"></option><option value="1">1</option></select>').appendTo(cell2);
     $('<input class="form-control " type="text" name="Last" value=""  >').appendTo(cell3);
     $('<input class="form-control " type="text" name="Last" value=""  >').appendTo(cell4);
     $('<input class="discount form-control" type="number" name="Last" value=""  >&nbsp;<select class="form-control discount form-select"><option value="0">%</option><option value="1">ZMW</option></select>').appendTo(cell5);
     $('<select class="form-control form-select"><option value="0"></option><option value="1">1</option></select>').appendTo(cell6);
     $('<input class="tabledit-input form-control" type="text" name="Last" value=""  >').appendTo(cell7);
     $('<a href=""><i class="fa fa-file-o"></i></a> &nbsp;&nbsp;&nbsp; <a href="" class=""><i class="fa fa-refresh"></i></a>&nbsp;&nbsp;&nbsp;<a href="#" data-id="" class="transh-icon-color "><i class="fa fa-trash-o"></i></a>').appendTo(cell8);
    
}

/*add purchase order*/
$(document).on('change','#get_category_id',function(){
     var id = $('#get_category_id').val();
     var store_id = $('#store_id').val();
      $.ajax({
         type: "POST",
         url: "<?= base_url('getItemsByCategoryId')?>",
         data: {
            id: id,
            store_id: store_id
         },
         dataType: "json",
         encode: true,
      }).done(function (data) {
         //if(data.status == 'true'){
         alertMessage(data.status, data.message);
         $('.item-add').html(data.data);
         //}

      })
})
$(document).on('click','#is_include_tax',function(){
    console.log($('#is_include_tax').prop('checked'));
    if($('#is_include_tax').prop('checked')==true){
        $('.is_include_tax').removeClass('d-none');
        var tax_amount = 0;
        var self = $(this);
         var tax = 0; var tax_text = "";
         $('.tax_amount').each(function()
          { 
            var value = $(this).val();
            if(value > 0)
              tax_amount += parseFloat(value);
                $('.taxAmount').text(tax_amount);
                $('#total-tax').val(tax_amount);
                calculateAmount();
              });
        
    }else if($('#is_include_tax').prop('checked')==false){
        $('.is_include_tax').addClass('d-none');
        $('#total-tax').val(0);
        $('.taxAmount').text(0);
        // $('.tax_amount').text(0);
        // $('.tax_amount').val(0);
        calculateAmount()

    }
})

$(document).on('change','.adjustment_value',function(){
    value = $(this).val();
    calculateAmount();
})
$(document).on('click','.auditeModel',function(){
    value = $(this).attr('data-id');
    $('#confirm-audited').modal('show')
    $('#audite_order_id').val(value);
    $('.order_id').text(value);
})
function GetTaxValue(){
    var quantity = 0;
    var price = 0;
    tax_amount = quantity*price;
    console.log(tax_amount);
}
$(document).on('click','.view-p-module',function() {

    $('#purchaseOrderTbl tbody tr').removeClass('selected-tr');
    $(".customizer").removeClass("open");

    var self = $(this);
    var id = self.attr("data-id");
    $('.loading').css('display','block');
    viewPurchaseModule(id);
});
function viewPurchaseModule(id) {
  $.ajax({
        type: "GET",
        url: '<?= base_url() ?>'+'/purchases/view_purchase_order/'+id,
        // data: {id:id},
        success: function (res) { 
            res = JSON.parse(res);
            var data = res.data.goods_purchase,
            items = res.data.purchase_items;
            
            $("#v-heading").text('PO-000'+data.id);
            $('#v-receipt-no').text('PO-000'+data.id);
            $('#v-supplier').html(data.supplier_name+'<br/>'+data.address);
            $('#v-module-date').text(data.date);
            $('#v-pay-terms').text(terms(data.terms));

            var menu = '',
                //ciUrl = '<?= base_url() ?>'+'sales/convert_quote_to_invoice/'+data.id,
                editUrl = '<?= base_url() ?>'+'/purchases/edit_purchase_order/'+data.id,
                recUrl = '<?= base_url() ?>'+'/purchases/add_goods_received/'+data.id;

            if(data.order_status == 0 || data.order_status == 1 || data.order_status == 4){
                menu += '<li class="nav-item overflow-hidden">'+
                        '<a href="'+editUrl+'" id="v-edit-module" class="details-menu-item text-center nav-link over-flow">'+
                            '<i class="fa fa-pencil"></i>&nbsp;&nbsp;'+
                            '<span>Edit</span>'+
                        '</a>'+
                        '</li>'+
                        '<li class="nav-item overflow-hidden">'+
                        '<a href="'+recUrl+'" id="v-edit-module" class="details-menu-item text-center nav-link over-flow">'+
                            '<i class="fa fa-arrow-circle-o-right"></i>&nbsp;&nbsp;'+
                            '<span>Receive</span>'+
                        '</a>'+
                        '</li>';
            } else {

            }
            $('.details-menu-bar').html(menu)

            $('#v-module-items-tbl tbody').html('');
            var i = 1;
            $.each(items,function(k,v) {
              var disc = v.discount != "" ? v.discount+' '+v.discount_type:'-';
              var html = '<tr>'+
                          '<td class="storeColor">'+i+'</td>'+
                           '<td>'+v.item_name+'</td>'+
                           '<td>'+v.qty+'</td>'+
                           '<td>'+v.rate+'</td>'+
                           '<td>'+disc+'</td>'+
                           '<td style="text-align:right">'+v.total_amount+'</td>'+
                        '</tr>';
              $('#v-module-items-tbl tbody').append(html);
              i++;
            });

            $('#v-disc').text(data.total_discount)
            $("#v-sub-total").text(data.sub_total);
            $("#v-tax").text(data.total_tax);
            $("#v-total-amount").html('<b>'+data.total_amount+'</b>');

            $('.purchase-id-'+id).parent('td').parent('tr').addClass('selected-tr');
            $(".customizer").toggleClass("open");
            $('.loading').css('display','none');
        }
    });
}
function terms(val)
{
  var term = "";
  switch(val) {
    case 0:
      term = "Due end of the month";
    break;
    case 1:
      term = "Due end of next month";
    break;
    case 2:
      term = "Due on receipt";
    break;
    default:
      term = "Net "+val;
    break;
  }

  return term;
}
$(document).on('click','.add-more',function(){
  var self = $(this);
  var lot =  self.parents('td').siblings('td').children('.lot_no').val();
  var dom =  self.parents('td').siblings('td').children('.dom').val();
  var expiry =  self.parents('td').siblings('td').children('.expiry_date').val();

  $('.a-lot-row').val(self.attr('data-no'));
  $('.a-lot-no').val(lot);
  $('.a-lot-dom').val(dom);
  $('.a-lot-expiry').val(expiry);

  $('#add-lot-info').modal('show');
});
$('#btnLotSubmit').click(function(){
  var n = $('.a-lot-row').val(), lot = $('.a-lot-no').val(), dom = $('.a-lot-dom').val(), ex = $('.a-lot-expiry').val();

  $("input[name='items["+n+"][lot_no]").val(lot);
  $("input[name='items["+n+"][dom]").val(dom);
  $("input[name='items["+n+"][expiry_date]").val(ex);
  $('#add-lot-info').modal('hide');
});
</script>