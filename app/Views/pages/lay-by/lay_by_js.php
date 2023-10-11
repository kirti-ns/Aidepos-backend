<script type="text/javascript">
  if(window.location.href.includes('add_contract') || window.location.href.includes('edit_contract')) {
    var itiTel = intlTelInput($('#tel-phone').get(0), {
      separateDialCode:true,
    });
  }
  $(document).ready(function(){
        // Setting dialCode and phoneNumber while contract edit
        
        if(window.location.href.includes('edit_contract')) {
          let country_code = '<?php echo isset($data['contract'])?$data['contract']['country_code']:''; ?>'
          let phone = '<?php echo isset($data['contract'])?$data['contract']['phone']:''; ?>'
          if(country_code !== "" && phone !== "") {
            itiTel.setNumber("+"+country_code+phone);
          }else{
            itiTel.setCountry("us")
          }
        }
        
        $(document).on('click','.add-refunds',function(e) { 
          e.preventDefault();
          $('#add-refunds').modal('show');
        });
        $(document).on('click','.add-cancel',function(e) { 
          e.preventDefault();
          $('#add-cancel').modal('show')
        })
        $(document).on('click','.add-cancel_refund',function(e) { 
          e.preventDefault();
          $('#add-cancel_refund').modal('show')
        });
  });
  $(document).on("click",".show-layby-details",function() {
      var type = $(this).attr('data-type');
      var id = $(this).attr('data-id');
      $.ajax({
        type: "POST",
        url: base_url + '/layby/getContractDepositData',
        data: {id: id},
        dataType: "json",
        encode: true,
      }).done(function (data) {
        if(data.status == "true"){
          $('#'+type+'InfoId').text('LAY-000'+data.contractData.id);
          $('#'+type+'InfoCustomer').text(data.contractData.first_name+' '+data.contractData.last_name);
          $('#'+type+'InfoPhone').text(data.contractData.phone);
          $('#'+type+'InfoAddress').text(data.contractData.address);
          $('#'+type+'InfoAmount').text(data.total_amount);
          $('#'+type+'InfoBalance').text(data.total_deposit);
          $('#'+type+'ContractId').val(data.contractData.id);
          $('#'+type+'PayAmount').val(data.remaining_amt);
          if(type == "p") {
            $('#add-payment').modal('show');
          } else if(type == "r") {
            $('#'+type+'InfoBalance').text(data.remaining_amt);
            $('#'+type+'PayAmount').val(data.total_deposit);
            $('#add-refunds').modal('show');
          } else if(type == "c") {
            $('#'+type+'PayAmount').val(data.total_amount);
            $('#add-cancel').modal('show');
          } else {
            $('#'+type+'PayAmount').val(data.total_amount);
            $('#add-cancel-refund').modal('show');
          }
        }
      });
  });
  $(document).on('change','.customer-id',function(){
      
      var id = $(this).val();
      $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+'/customers/getCustomerById',
        data: { customer_id:id},
        success: function (res) { 
          res = JSON.parse(res);
          if(res.status == "true") {
            var data = res.data;

            var name = data.registerd_name.split(' ');
            let country_code = data.country_code;
            let phone = data.phone;
            if(country_code != "" && phone != "") {
              itiTel.setNumber("+"+country_code+phone);
            }
            $('#f-name').val(name[0])
            $('#l-name').val(name[1])
            // $("#phone").intlTelInput("setDialCode", data.country_code)
            $('#tel-phone').val(data.phone)
            $('#address').val(data.address)
          }
        }
      });
  })
  $(document).on('click','#addLaybyAmounts',function() {

      var type = $(this).attr('data-type');
      var amount = $('#'+type+'PayAmount').val();
      var id = $('#'+type+'ContractId').val();

      var formData = new FormData();
      formData.append('amount', amount);
      formData.append('contract_id', id);
      formData.append('payment_type',$('input[name="layby_pay_type"]:checked').val() || 0)
      formData.append('id', '');
      formData.append('transaction_type',$('#'+type+'TxnType').val());
      formData.append('table_name', 'layby_contract_transactions');

      $.ajax({
          type: "POST",
          url: '<?=base_url()?>'+'/post_layby_data',
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          dataType: "json",
          encode: true,
      }).done(function (data) {
          alertMessage(data.status, data.message);
          if(type == "p") {
            $('#add-payment').modal('hide');
          } else if(type == "r") {
            $('#add-refunds').modal('hide');
          } else if(type == "c") {
            $('#add-cancel').modal('hide');
          }
      });
  })
  function addContractField(argument) {
      var table = document.getElementById("contract");
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
      var cell9 = row.insertCell(9);
      
        row.className = "new-row";
      $('td:eq(1)', row).attr('colspan', 2);
      cell0.className='text-center';
      cell1.className='text-center';
      cell2.className='text-center';
      cell3.className='text-center';
      cell4.className='text-center';
      cell5.className='text-center d-flex'; 
      cell6.className='text-center';
      cell7.className='form-group text-center';
      cell8.className='text-center';
      cell9.className='text-center';

      var id = 'item_id-contract'+t1;

      var items = '<?php echo isset($data['items'])?$data['items']:""; ?>';
      var itemArray = JSON.parse(items);
      
      var options = "";
      $.each(itemArray,function(k,v){
          options += '<option value="'+v.id+'">'+v.item_name+'</option>'
      });

      $('<span class="tabledit-span" >'+t1+'</span>').appendTo(cell0)
      $('<select class="form-control form-border form-select select2 cont-item-add '+id+'" name="items['+t1+'][item_id]"><option>Click to Select Item</option>'+options+'</select>').appendTo(cell1);
      $('<input class="uom form-control" type="text" name="items['+t1+'][uom]"><input class="uomid form-control " type="hidden" name="items['+t1+'][uomid]">').appendTo(cell2);
      $('<input class="form-control quantity" type="number" name="items['+t1+'][quantity]" value="1">').appendTo(cell3);
      $('<input class="form-control rate" type="text" name="items['+t1+'][rate]">').appendTo(cell4);
      $('<input class="discount_amount form-control" type="hidden" name="items['+t1+'][discount_amount]" value="0.00"><input class="lb-discount form-control " type="number" name="items['+t1+'][discount]"><select class="form-control lb-discount form-select" name="items['+t1+'][discount_type]"><option value="%">%</option><option value="ZMW">ZMW</option></select>').appendTo(cell5);
      $('<input type="text" name="items['+t1+'][tax_amount]" class="form-control tax_amount" readonly><input class="form-control form-border tax" type="hidden" name="items['+t1+'][tax]"><input class="form-control form-border tax_type" type="hidden" name="items['+t1+'][tax_type]">').appendTo(cell6);
      $('<input type="hidden" class="tax_exc_amt" name="items['+t1+'][tax_exc_amt]" value="0"><input class="tax_excl" id="tax_excl'+t1+'" type="checkbox" name="items['+t1+'][tax_excl]" value="1"><label for="tax_excl'+t1+'"></label>').appendTo(cell7);
      $('<input class="tabledit-input form-control amount" type="text" name="items['+t1+'][amount]" value="">').appendTo(cell8);
      $('<a href="" class="transh-icon-color"><i class="fa fa-trash-o"></i></a>').appendTo(cell9);

      $('.'+id).select2({
        minimumInputLength: 2
      });
  }

$('.cont-item-add').select2({
  minimumInputLength: 2
});
$('.conv-currency').css('visibility','hidden');
var isCurrencySelect = $("#exchange-rate option:selected");
  console.log(isCurrencySelect.val())
if(isCurrencySelect.val() > 0) {
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

  $(document).on('change','.cont-item-add',function() {

    let self = $(this);
    let id = self.val();
    
    $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+'/getItemDetail',
        data: { id:id},
        success: function (res) { 
          res = JSON.parse(res);
          if(res.status == "true") {
            var data = res.data;
            var tax_amount = 0;

            var tax_perc = 1.0 + parseFloat(data.tax_rate/100);
            tax_amount = parseFloat(data.retail_price) - (parseFloat(data.retail_price) / parseFloat(tax_perc));
            
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
            var price = data.retail_price;

            self.parents('td').siblings('td').children('.amount').val(quantity*price);
            
            var currency_rate = $('#exchange-rate').find(':selected').attr('data-rate');

            if(currency_rate !== undefined) {
              currency_rate = (quantity*price)*currency_rate;
              self.parents('td').siblings('td').children('.currency').val(currency_rate.toFixed(2));
            }
            calculateLaybyAmount()
            
          }
        }
    });

  });

  $(document).on('change','.rate',function() {
   
    var self = $(this);
    var price = parseFloat(self.val());
    var quantity = self.parents('td').siblings('td').children('.quantity').val();
    var tax_rate = self.parents('td').siblings('td').children('.tax').val();
    var tab = self.parents('td').siblings('td').children('.item-add').attr('data-tab');
    var discount = self.parents('td').siblings('td').children('.lb-discount').val();
    var discount_type =  self.parents('td').children('.discount_type').val();
   
    var discount_amount = 0;
   
    self.parents('td').siblings('td').children('.amount').val(quantity*price);
     if(parseFloat(discount) > 0){
            discount_amount =  discountCalculateAmount(discount,discount_type,quantity*price);
           self.parents('td').siblings('td').children('.discount_amount').val(discount_amount);
     }
    var tax_excl = self.parents('td').siblings('td').children('.tax_excl')
    if(tax_rate > 0) {
      if(tax_excl.is(":checked")) {
        var tax_perc = 1.0 + parseFloat(tax_rate/100); 
        var tax_amount = parseFloat(quantity*price) * parseFloat(tax_perc);
      
        self.parents('td').siblings('td').children('.tax_amount').val(tax_amount.toFixed(2));
        self.parents('td').children('.tax_exc_amt').val(tax_amount.toFixed(2));
      }else{
        var tax_perc = 1.0 + parseFloat(tax_rate/100); 
        var tax_amount = parseFloat(quantity*price) - (parseFloat(quantity*price) / parseFloat(tax_perc));
        self.parents('td').siblings('td').children('.tax_amount').val(tax_amount.toFixed(2));
        self.parents('td').children('.tax_exc_amt').val('0');
      }
    }
    
    var currency_id = $('#exchange-rate').find(':selected').attr('data-rate');
    var currency_rate  = 0;
    if(currency_id != undefined && currency_id != ""){
      currency_rate = (quantity*price)*currency_id;
      self.parents('td').siblings('td').children('.currency').val(currency_rate.toFixed(2));
    }

    calculateLaybyAmount()
  });

  $(document).on('change','.quantity',function() {
   
    var self = $(this);
    var quantity = self.val();
    var price = self.parents('td').siblings('td').children('.rate').val();
    var tax_rate = self.parents('td').siblings('td').children('.tax').val();
    var tab = self.parents('td').siblings('td').children('.item-add').attr('data-tab');
    var discount = self.parents('td').siblings('td').children('.lb-discount').val();
    var discount_type =  self.parents('td').children('.discount_type').val();
   
    var discount_amount = 0;
   
    self.parents('td').siblings('td').children('.amount').val(quantity*price);
    if(parseFloat(discount) > 0){
            discount_amount =  discountCalculateAmount(discount,discount_type,quantity*price);
           self.parents('td').siblings('td').children('.discount_amount').val(discount_amount);
    }
    var tax_amount = 0.00;
    var tax_excl = self.parents('td').siblings('td').children('.tax_excl')
    if(tax_rate > 0) {
      if(tax_excl.is(":checked")) {
        var tax_perc = 1.0 + parseFloat(tax_rate/100); 
        tax_amount = parseFloat(quantity*price) * parseFloat(tax_perc);
      
        self.parents('td').siblings('td').children('.tax_amount').val(tax_amount.toFixed(2));
        self.parents('td').children('.tax_exc_amt').val(tax_amount.toFixed(2));
      }else{
        var tax_perc = 1.0 + parseFloat(tax_rate/100); 
        tax_amount = parseFloat(quantity*price) - (parseFloat(quantity*price) / parseFloat(tax_perc));
        self.parents('td').siblings('td').children('.tax_amount').val(tax_amount.toFixed(2));
        self.parents('td').children('.tax_exc_amt').val('0');
      }
    }

    
    var currency_id = $('#exchange-rate').find(':selected').attr('data-rate');
    var currency_rate  = 0;
    if(currency_id != undefined && currency_id != ""){
      currency_rate = (quantity*price)*currency_id;
      self.parents('td').siblings('td').children('.currency').val(currency_rate.toFixed(2));
    }

    calculateLaybyAmount()
  });

  $(document).on('change','.lb-discount',function(){
    
    var self = $(this);
    var discount = self.val();
    var discount_type =  self.parents('td').children('.discount_type').val(); 
    var amount = self.parents('td').siblings('td').children('.amount').val();
    var discount_value = "";
    discount_value = amount * discount/ 100;
    self.parents('td').children('.discount_amount').val(discount_value); 
    calculateLaybyAmount();
  })

  $(document).on('click','.tax_excl',function(){
  
    var self = $(this);
    var tax_rate = self.parents('td').siblings('td').children('.tax').val();
    var retail_price = self.parents('td').siblings('td').children('.rate').val();
    var qty = self.parents('td').siblings('td').children('.quantity').val();
    var total_price = parseFloat(retail_price)*parseFloat(qty)
    if(tax_rate > 0) {
      if(self.is(":checked")) {
        var tax_perc = parseFloat(tax_rate/100); 
        var tax_amount = total_price * tax_perc;
        self.parents('td').siblings('td').children('.tax_amount').val(tax_amount.toFixed(2));
        var t = self.parents('td').children('.tax_exc_amt').val(tax_amount.toFixed(2));
        calculateLaybyAmount();
      }else{
        var tax_perc = 1.0 + parseFloat(tax_rate/100); 
        var tax_amount = total_price - (total_price / parseFloat(tax_perc));
        self.parents('td').siblings('td').children('.tax_amount').val(tax_amount.toFixed(2));
        self.parents('td').children('.tax_exc_amt').val('0');
        calculateLaybyAmount();
      }
    }
  });

  $('#deposit_amount').change(function(){
    var gTotal = $('.total-amount').val();
    var deposit = $(this).val();
    if(deposit != "") {
      var calc = (deposit * 100 / gTotal);
      if(!Number.isInteger(calc)) {
        calc = calc.toFixed(2)
      }
      $('.layby_deposit_per').val(calc);
      $('.curr-deposit_per').text(calc);

      var currency_rate = $('#currency_rate').val();

      if(currency_rate !== "" && currency_rate != undefined){
        var currency_deposit = (deposit*parseFloat(currency_rate)).toFixed(2);
        $('.currency_deposit').text(currency_deposit);
        $('#currency_deposit').val(currency_deposit)
      }
    }
  });

  $('.layby_deposit_per').change(function(){
    var per = $(this).val();
    $('.curr-deposit_per').text(per);
    var gTotal = $('.total-amount').val();
    if(per != "" && gTotal > 0) {
      var gDepositAmt = ((gTotal * per)/100).toFixed(2);
      $('.deposit_amount').val(gDepositAmt);
      var currency_rate = $('#currency_rate').val();

      if(currency_rate !== "" && currency_rate != undefined){
        var currency_deposit = (gDepositAmt*parseFloat(currency_rate)).toFixed(2);
        $('.currency_deposit').text(currency_deposit);
        $('#currency_deposit').val(currency_deposit)
      }
    }
  })

  $(document).on('change','#exchange-rate',function(){

    var self = $(this);
    var currency_id = $('#exchange-rate').find(':selected').attr('data-rate');
    var type = $(this).attr('data-type');
    if(currency_id != undefined) {
      $('.conv-currency').css('visibility','visible');

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
      $('#currency_rate').val('');
      $('.conv-currency').css('visibility','hidden');
    }

    calculateLaybyAmount();
    /*$('.amount').each(function(){
        var inp = $(this);
        var price = inp.val();

        var currency_rate  = 0;
        if(currency_id != ""){
          currency_rate = price*currency_id;
          inp.parents('td').siblings('td').children('.currency').val(currency_rate.toFixed(2));
        }
    })*/
    
  });

  function calculateLaybyAmount()
  {
    var table = document.getElementById("contract");
    var rowCount=table.rows.length;

    $('.totalRow').text(rowCount-1)
    $('#total-quantity').val(rowCount-1)

    var subTotal = 0;var amount = 0;
    $('.amount').each(function()
    { 
      var value = $(this).val();
      if(value > 0)
        subTotal += parseFloat(value);
    });

    var tax = 0.00; var tax_text = "Tax";
    $('.tax').each(function()
    { 
      var value = $(this).val();
      if(value > 0)
        tax_text = 'Tax ';
    });
    $('#tax_text').text(tax_text);
    
    var tax_amount = 0.00; 
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
    if(adjust == "" || adjust == undefined){
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
    
    var total = subTotal + (parseFloat(adjust) - parseFloat(discount_amount));
    var subTotalFinal = subTotal - tax_amount;
    
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
      subTotalFinal += tax_excl_amt;
    }

    $('#sub-total').val(subTotalFinal.toFixed(2));
    $('.subTotal').text(subTotalFinal.toFixed(2));
    $('#sub-curr-total').val(subTotal+'.00');
    var gTotal = total.toFixed(2);
    $('.total-amount').val(gTotal);
    $('.total-amount').text(gTotal);

    var depositPer = parseFloat($('.layby_deposit_per').val());
    var gDepositAmt = ((gTotal * depositPer)/100).toFixed(2);
    $('.deposit_amount').val(gDepositAmt);
    $('.deposit_amount').text(gDepositAmt);

    var currency_rate = $('#currency_rate').val();
    var currency_total  = 0, currency_sub_total= 0,c_discount=0,currency_deposit=0;

    if(currency_rate !== "" && currency_rate != undefined){
      $('.conv-currency').css('visibility','visible');
      currency_total = gTotal*parseFloat(currency_rate);
      currency_sub_total = subTotalFinal*parseFloat(currency_rate);
      currency_tax = tax_amount*parseFloat(currency_rate);
      c_discount = discount_amount*parseFloat(currency_rate);
      currency_deposit = gDepositAmt*parseFloat(currency_rate);
      $('.subCurrTotal').text(currency_sub_total.toFixed(2))
      $('#sub-curr-total').val(currency_sub_total.toFixed(2))
      $('#curr-tax').val(currency_tax.toFixed(2));
      $('.currTax').text(currency_tax.toFixed(2));
      $('.currdiscountAmount').text(c_discount.toFixed(2));
      $('#curr-total-discount').val(c_discount.toFixed(2));
      $('.currency_deposit').text(currency_deposit.toFixed(2));
      $('#currency_deposit').val(currency_deposit.toFixed(2))
      $('.conv-total-amount').val(currency_total.toFixed(2));
      $('.conv-total-amount').text(currency_total.toFixed(2));
    }
    
  }
</script>