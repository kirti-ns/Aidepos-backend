<script>
  function addSellItem (argument) {
    var table = document.getElementById("sellItemTable");
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
   cell0.className='text-center orderControl tableOrder';
   cell1.className='';
   cell2.className='text-center';
   cell3.className='text-center';
   cell4.className='text-center';
   cell5.className='text-center'; 
   cell6.className='text-center flex is_include_tax';
   cell7.className='text-center form-group';
   cell8.className='text-center';
   cell9.className='text-center';
  
   var items = '<?php echo isset($data['items'])?$data['items']:""; ?>';
   var itemArray = JSON.parse(items);
   var options = "";
   $.each(itemArray,function(k,v){
      options += '<option value="'+v.id+'">'+v.item_name+'</option>'
   });

   var id = 'item_id-sales'+t1;

    $('<span class="tabledit-span" >'+t1+'</span>').appendTo(cell0)
    $('<select class="form-control form-border form-select item-add '+id+'" data-tab="sell" name="items['+t1+'][item_id]"><option>Click to Select Item</option>'+options+'</select>').appendTo(cell1);
    $('<input class="uom form-control form-border" type="text" name="items['+t1+'][uom]" value=""><input class="uomid form-control form-border " type="hidden" name="items['+t1+'][uomid]">').appendTo(cell2);
    $('<input class="form-control form-border quantity" type="number" name="items['+t1+'][quantity]" value="1">').appendTo(cell3);
    $('<input class="form-control form-border rate" type="text" name="items['+t1+'][rate]" value="">').appendTo(cell4);
    $('<input class="discount form-control form-border " type="number" name="items['+t1+'][discount]" value="">&nbsp;<select class="form-control form-border discount form-select" name="items['+t1+'][discount_type]"><option value="%">%</option><option value="ZMW">ZMW</option></select><input class="discount_amount form-control" type="hidden" name="items['+t1+'][discount_amount]" value="0.00">').appendTo(cell5);
    $('<input type="text" class="form-control tax_amount" name="items['+t1+'][tax_amount]" readonly><input class="form-control form-border tax" type="hidden" name="items['+t1+'][tax]" value="">&nbsp;<input class="form-control form-border tax_type" readonly type="hidden" name="items['+t1+'][tax_type]">').appendTo(cell6);
    $('<input type="hidden" class="tax_exc_amt" name="items['+t1+'][tax_exc_amt]" value="0"><input class="tax_excl" id="tax_excl'+t1+'" type="checkbox" name="items['+t1+'][tax_excl]" value="1"><label for="tax_excl'+t1+'"></label>').appendTo(cell7);
    $('<input class="tabledit-input form-control form-border amount" type="text" name="items['+t1+'][amount]">').appendTo(cell8);
    $('<a href="#" class="transh-icon-color item-remove" title="Remove"><i class="fa fa-trash-o"></i></a>').appendTo(cell9);

    $('.'+id).select2({
      minimumInputLength: 3
    });
  }

  var url_string = this.location.href; 
  var url = new URL(url_string);
  var id = url.searchParams.get("id");

  if(id != null) {
    setTimeout(function(){
      $('.invoice-id-'+id).click();
    },2500)
  }
  function addQuoteItem (argument) {
    var table = document.getElementById("quoteItemTable");
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
   cell0.className='text-center tableOrder';
   cell1.className='';
   cell2.className='text-center';
   cell3.className='text-center';
   cell4.className='text-center';
   cell5.className='text-center'; 
   cell6.className='text-center flex';
   cell7.className='text-center form-group';
   cell8.className='text-center';
   cell9.className='text-center';
  
   var items = '<?php echo isset($data['items'])?$data['items']:""; ?>';
   var itemArray = JSON.parse(items);
   var options = "";
   $.each(itemArray,function(k,v){
      options += '<option value="'+v.id+'">'+v.item_name+'</option>'
   });

   var id = 'item_id-sales'+t1;

    $('<span class="tabledit-span" >'+t1+'</span>').appendTo(cell0)
    $('<select name="items['+t1+'][item_id]" data-tab="sell" class="quote-item-'+t1+' item-add form-control"></select>').appendTo(cell1);
    $('<input class="uom form-control form-border" type="text" name="items['+t1+'][uom]" value=""><input class="uomid form-control form-border " type="hidden" name="items['+t1+'][uomid]">').appendTo(cell2);
    $('<input class="form-control form-border quantity" type="number" name="items['+t1+'][quantity]" value="1">').appendTo(cell3);
    $('<input class="form-control form-border rate" type="text" name="items['+t1+'][rate]" value="">').appendTo(cell4);
    $('<input class="discount form-control form-border " type="number" name="items['+t1+'][discount]" value="">&nbsp;<select class="form-control form-border discount form-select" name="items['+t1+'][discount_type]"><option value="%">%</option><option value="ZMW">ZMW</option></select><input class="discount_amount form-control" type="hidden" name="items['+t1+'][discount_amount]" value="0.00">').appendTo(cell5);
    $('<input type="text" class="form-control tax_amount" name="items['+t1+'][tax_amount]" readonly><input class="form-control form-border tax" type="hidden" name="items['+t1+'][tax]" value="">&nbsp;<input class="form-control form-border tax_type" readonly type="hidden" name="items['+t1+'][tax_type]">').appendTo(cell6);
    $('<input type="hidden" class="tax_exc_amt" name="items['+t1+'][tax_exc_amt]" value="0"><input class="tax_excl" id="tax_excl'+t1+'" type="checkbox" name="items['+t1+'][tax_excl]" value="1"><label for="tax_excl'+t1+'"></label>').appendTo(cell7);
    $('<input class="tabledit-input form-control form-border amount" type="text" name="items['+t1+'][amount]">').appendTo(cell8);
    $('<a href="#" class="transh-icon-color item-remove" title="Remove"><i class="fa fa-trash-o"></i></a>').appendTo(cell9);

    $('.quote-item-'+t1).select2({
        placeholder: 'Select Item',
        minimumInputLength: 3,
        ajax: {
            url: base_url+'searchItems?type=sales',
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

$(document).ready(function() { 
  $('#invoice_form input').change(function() { 
        somethingChanged = true; 
  });

  $('.quote-item-o').select2({
        placeholder: 'Select Item',
        minimumInputLength: 3,
        ajax: {
            url: base_url+'searchItems?type=sales',
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

  $('.item_id-sales').select2({
        placeholder: 'Select Item',
        minimumInputLength: 2,
        ajax: {
            url: base_url+'searchItems?type=sales',
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

$(document).on('click','.view-module',function() {

    $('#sellStockTbl tbody tr').removeClass('selected-tr');
    $(".customizer").removeClass("open");

    var self = $(this);
    var id = self.attr("data-id");
    var tab = self.attr("data-tab")
    $('.loading').css('display','block');
    viewModule(id,tab); //For Invoice and Quote
    /*$.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+'/sales/view_invoice',
        data: {id:id},
        success: function (res) { 
            res = JSON.parse(res);
            var data = res.data.invoice,
            items = res.data.sell_items,
            payments = res.data.payments;

            $('#v-record-payment').attr('data-id',data.id);
            $('#sr-download').attr('href','<?= base_url() ?>'+'/sales/printInvoicePDF/'+data.id);
            $('#v-edit-invoice').attr('href','<?= base_url() ?>'+'/sales/edit_invoice/'+data.id+"?type=1");
            $("#v-heading").text('INV-000'+data.id);
            $("#v-receipt-no").text('000'+data.id);
            $("#v-cust-name").text(data.registerd_name);
            $("#v-cust-address").text(data.address);
            $("#v-invoice-date").text(data.invoice_date);

            $('#v-invoice-items-tbl tbody').html('');
            var i = 1;
            $.each(items,function(k,v) {
              var html = '<tr>'+
                          '<td class="storeColor">'+i+'</td>'+
                           '<td>'+v.item_name+'</td>'+
                           '<td>'+v.qty+'</td>'+
                           '<td>'+v.rate+'</td>'+
                           '<td style="text-align:right">'+v.item_amount+'</td>'+
                        '</tr>';
              $('#v-invoice-items-tbl tbody').append(html);
              i++;
            });

            if(payments.length > 0) {
                $('#v-payments-section').show();
                $('#v-payments-tbl tbody').html('');
                $.each(payments,function(k,v) {
                var pHtml = '<tr>'+
                             '<td>'+v.payment_date+'</td>'+
                             '<td>'+v.id+'</td>'+
                             '<td>'+v.p_mode+'</td>'+
                             '<td>'+v.amount_received+'</td>'+
                          '</tr>';
                $('#v-payments-tbl tbody').append(pHtml);
                i++;
              });
            } else {
              $('#v-payments-section').hide();
            }

            if(!res.data.is_payment_flg) {
              $('#v-record-payment').hide();
            }else{
              $('#v-record-payment').show();
            }

            $("#v-payment-mode").text(data.p_mode);
            $("#v-sub-total").text(data.sub_total);
            $("#v-tax").text(data.total_tax);
            $("#v-total-amount").text(data.total_amount);

            $('#inv-area').show();
            $('#v-opt-header').show();
            $('#payment-area').hide();
            
            self.parent('td').parent('tr').addClass('selected-tr');
            $(".customizer").toggleClass("open");
        }
    });*/
});

function viewModule(id,tab) {
  $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+'/sales/'+'view_'+tab,
        data: {id:id},
        success: function (res) { 
            res = JSON.parse(res);
            var data = res.data.module,
            items = res.data.items,
            payments = res.data.payments,
            credits = res.data.credits;

            var date = '', html = '', modl = '', shrt = '';
            if(tab == 'invoice') {
              date = data.invoice_date;
              modl = data.invoice_type == "1" ? 'Invoice' : 'Debit Note';
              shrt = data.invoice_type == "1" ? 'INV' : 'CDN';
              $('#sr-download').attr('href','<?= base_url() ?>'+'/sales/printInvoicePDF/'+data.id);

            } else {
              date = data.quote_date;
              modl = 'Quote';
              shrt = '';
            }

            
            // $('#v-edit-module').attr('href','<?= base_url() ?>'+'/sales/edit_'+tab+'/'+data.id);
            // $('#v-credit-note').attr('data-id',data.id);
            $("#v-heading").text(shrt+'-000'+data.id);
            $("#v-receipt-no").text('000'+data.id);
            $("#v-cust-name").text(data.registerd_name);
            $("#v-cust-address").text(data.address);
            $("#v-module-date").html('<h6 style="text-transform:capitalize">'+tab+' Date: <span class="summary-amount" id="" style="font-weight: 500;">'+date+'</span></h6>');
            if(tab == "invoice" && data.invoice_type == "2") {
              $("#v-module-date").html('<h6>Debit Note Date: <span class="summary-amount" id="" style="font-weight: 500;">'+date+'</span></h6>');
            }
            var head = tab == "invoice" && data.invoice_type == "2" ? 'DEBIT NOTE' : tab;
            $('.m-details').html('<span style="font-size: 30px;text-transform:uppercase" class="module">'+ head +'</span><br/><p>'+modl+'# '+shrt+'-<span id="v-receipt-no">000'+data.id+'</span></p>');
            if(tab == "quote") {
              $('.m-details').html('<span style="font-size: 30px;text-transform:uppercase" class="module">'+ head +'</span><br/><p>'+modl+' #<span id="v-receipt-no">'+data.quote_number+'</span></p>');
            }

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

            /*var txt = "Draft", cls = "p-badge-info";
            if(res.data.is_paid_status == "1") {
                txt = "Partially Paid";
                cls = "p-badge-success";
            } else if (res.data.is_paid_status == "2") {
                txt = "Paid";
                cls = "p-badge-success";
            }
            $('.p-badge-inner').addClass(cls);
            $('.p-badge-inner').text(txt);

            $('#creditNoteSec').removeClass('active');
            $('#paymentTab').addClass('active');

            $('#creditTab').removeClass('active');
            $('#tab31').addClass('active');*/



            $('#v-disc').text(data.total_discount)
            $("#v-sub-total").text(data.sub_total);
            $("#v-tax").text(data.total_tax);
            $("#v-total-amount").html('<b>'+data.total_amount+'</b>');
            $('#b-d-tr').css('display','none')
            var menu = '',
                ciUrl = '<?= base_url() ?>'+'sales/convert_quote_to_invoice/'+data.id,
                editUrl = '<?= base_url() ?>'+'sales/edit_'+tab+'/'+data.id;

            if(tab == 'quote') {
              $('#v-func-section').hide();

              menu += '<li class="nav-item overflow-hidden">'+
                      '<a href="'+editUrl+'" id="v-edit-module" class="details-menu-item text-center nav-link over-flow">'+
                          '<i class="fa fa-pencil"></i>&nbsp;&nbsp;'+
                          '<span>Edit</span>'+
                      '</a>'+
                      '</li>'+
                      '<li class="nav-item overflow-hidden">'+
                      '<a href="'+ciUrl+'" id="v-convert-invoice" class="details-menu-item text-center nav-link over-flow">'+
                        '<i class="fa fa-file"></i>&nbsp;&nbsp;'+
                        '<span>Convert to Invoice</span>'+
                      '</a>'+
                      '</li>';
              $('.details-menu-bar').html(menu)
            }
            if(tab == 'invoice') {
              var dnURL = '',
              crUrl = '<?= base_url() ?>'+'sales/add_credit_note/'+data.id;
              $('#b-d-tr').css('display','table-row')
              $('#v-balance-due').html('<b>'+data.balance_due+'</b>')

              if(res.data.is_appl_credits) {
                $('#crd-tr').css('display','table-row');
                $('#v-cr-applied').text('(-) ' + res.data.cr_applied);
              }else{
                $('#crd-tr').css('display','none');
                $('#v-cr-applied').text('');
              }

              if(res.data.payment_made > 0) {
                $('#pay-tr').css('display','table-row');
                $('#v-pay-made').text('(-) ' + res.data.payment_made);
                if(data.invoice_type == "1") {
                  dnURL = '<a href="'+'<?= base_url() ?>'+'sales/add_debit_note/'+data.id+'" class="dropdown-item"><i class="fa fa-plus-square-o"></i> Create Debit Note</a>'
                }
              } else {
                $('#pay-tr').css('display','none');
                $('#v-pay-made').text('');
              }
              menu += '<li class="nav-item overflow-hidden">'+
                      '<a href="'+editUrl+'" id="v-edit-module" class="details-menu-item text-center nav-link over-flow">'+
                          '<i class="fa fa-pencil"></i>&nbsp;&nbsp;'+
                          '<span>Edit</span>'+
                      '</a>'+
                      '</li>'+
                      '<li class="nav-item overflow-hidden">'+
                        '<a href="javascript:void(0);" id="v-sendmail" data-id="'+data.id+'" data-store-id="'+data.store_id+'" class="details-menu-item text-center nav-link over-flow">'+
                          '<i class="fa fa-envelope"></i>&nbsp;&nbsp;'+
                          '<span>Send Mail</span>'+
                        '</a>'+
                      '</li>'+
                      '<li class="nav-item overflow-hidden">'+
                        '<a href="'+'<?= base_url() ?>'+'/sales/printInvoicePDF/'+data.id+'" id="sr-download" class="details-menu-item text-center nav-link over-flow">'+
                          '<i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;'+
                          '<span>PDF</span>'+
                        '</a>'+
                      '</li>';
                      
              if(res.data.is_payment_flg) {
                menu += '<li class="nav-item overflow-hidden">'+
                        '<a href="javascript:void(0);" id="v-record-payment" data-sent="'+data.is_sent+'" data-id="'+data.id+'" class="details-menu-item text-center nav-link over-flow">'+
                          '<i class="fa fa-money"></i>&nbsp;&nbsp;'+
                          '<span>Record Payment</span>'+
                        '</a>'+
                        '</li>';
              }
              menu += '<li class="nav-item">'+
                        '<span class="dropdown">'+
                        '<button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn dropdown-toggle dropdown-menu-right" style="font-size: 15px;background-color:#f7f7f7">'+
                            '<i class="fa fa-ellipsis-h"></i>'+
                         '</button>'+
                          '<span aria-labelledby="btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right">'+
                              '<a href="'+crUrl+'" class="dropdown-item"><i class="fa fa-minus-square-o"></i> Create Credit Note </a>'
                              + dnURL +
                          '</span>'+
                        '</span>'+
                        '</li>';
              $('#v-func-section').html('')
              if(tab == "invoice") {
              $('#v-func-section').show();
                if(data.is_sent == "0") {
                  $('#v-func-section').html('<div class="col-md-12">'+
                          '<div class="bs-callout-primary callout-border-left callout-bordered p-1 d-flex">'+
                          '<p class="pr-5">You can click on the following button to<br/> mark invoice as sent.</p>'+
                          '<button class="btn btn-info flex-end mark-as-sent" data-id="'+data.id+'" data-tab="'+tab+'">Mark as Sent</button>'+
                      '</div>'+
                  '</div>');
                } else if(data.is_sent == "1" && data.balance_due > 0 && res.data.credits_available > 0) {
                  $('#v-func-section').html('<div class="col-md-12 mb-1">'+
                          '<div class="bs-callout-primary callout-border-left callout-bordered p-1 d-flex">'+
                          '<p class="pr-5" style="margin-top: 10px;">Credits Available: '+res.data.credits_available+'</p>'+
                          '<button class="btn btn-info btn-sm flex-end appl-credits-btn" data-id="'+data.id+'" data-tab="'+tab+'">Apply Now</button>'+
                      '</div>'+
                  '</div>');
                }
                if(payments.length > 0 && res.data.is_appl_credits) {
                  viewPaymentandCreditTbl(payments, credits)
                } else if(payments.length > 0 && !res.data.is_appl_credits) {
                  viewPaymentandCreditTbl(payments,[])
                } else if(payments.length == 0 && res.data.is_appl_credits) {
                  viewPaymentandCreditTbl([],credits)
                }

              }
              $('.details-menu-bar').html(menu)
            }

            $('#inv-area').show();
            $('#v-opt-header').show();
            $('#payment-area').hide();
            
            $('.'+tab+'-id-'+id).parent('td').parent('tr').addClass('selected-tr');
            $(".customizer").toggleClass("open");
            $('.loading').css('display','none');
        }
    });
}
function viewPaymentandCreditTbl(payments,credits = [])
{
  var html="", pList="", pTab="", cList="", cTab="";
  var i = 0;
  if(payments.length > 0) {
    var tbody = "";
    $.each(payments,function(k,v) {
      tbody += '<tr>'+
                   '<td>'+v.payment_date+'</td>'+
                   '<td>'+v.id+'</td>'+
                   '<td>'+v.p_mode+'</td>'+
                   '<td>'+v.amount_received+'</td>'+
                '</tr>';
      i++;
    });

    pList = '<li class="nav-item">'+
              '<a class="nav-link active" id="paymentTab" data-toggle="tab" aria-controls="tab31" href="#tab31" aria-expanded="true">Payment Received</a>'+
            '</li>';
    pTab = '<div role="tabpanel" class="tab-pane active" id="tab31" aria-expanded="true" aria-labelledby="paymentTab">'+
                '<div class="table-responsive">'+
                    '<table class="table" id="v-payments-tbl">'+
                        '<thead>'+
                            '<tr>'+
                                '<th>Date</th>'+
                                '<th>Payment#</th>'+
                                '<th>Payment Mode</th>'+
                                '<th>Amount</th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody>'+tbody+'</tbody>'+
                    '</table>'+
                '</div>'+
            '</div>';
  }
  if(credits.length > 0) {
    var tbody = "";
    $.each(credits,function(k,v) {
      tbody = '<tr>'+
                   '<td>'+v.credit_date+'</td>'+
                   '<td>'+v.id+'</td>'+
                   '<td>'+v.credit_applied+'</td>'+
                '</tr>';
      i++;
    });
    cList = '<li class="nav-item">'+
              '<a class="nav-link ml-2" id="creditNoteSec" data-toggle="tab" aria-controls="creditTab" href="#creditTab" aria-expanded="false">Credits Applied</a>'+
            '</li>';
    cTab = '<div class="tab-pane" id="creditTab" aria-labelledby="creditNote">'+
              '<div class="table-responsive">'+
                  '<table class="table" id="v-credits-tbl">'+
                      '<thead>'+
                          '<tr>'+
                              '<th>Date</th>'+
                              '<th>Credit Note#</th>'+
                              '<th>Amount</th>'+
                          '</tr>'+
                      '</thead>'+
                      '<tbody>'+tbody+'</tbody>'+
                  '</table>'+
              '</div>'+
          '</div>';
  }
  html += '<div class="col-md-12">'+
            '<div class="card" style="box-shadow: none;border: 1px solid #e2dbdb;margin-bottom: 0.6rem;">'+
                '<ul class="nav nav-tabs nav-underline nav-justified pl-1" style="padding-right: 400px; border-bottom: 1px solid #d5d5d9;">'+
                    pList + cList +
                '</ul>'+
                '<div class="tab-content px-1 pt-1">'+
                    pTab + cTab +
                '</div>'+
            '</div>'+
          '</div>';
  $('#v-func-section').append(html);
}
$(document).on('click','.appl-credits-btn',function(){
  var id = $(this).attr('data-id');
  $.ajax({
    type: "POST",
    url: '<?= base_url() ?>'+'/sales/get_customer_credits',
    data: {'id':id},
    dataType: "json",
    encode: true,
  }).done(function (data) {

    res = data.data;
    $('.appl-credit-title').html('Apply Credits for INV-000'+id);
    $('.invoice_bal_due').html(res.balance_due);
    $('.balance_due').val(res.balance_due);
    $('.c_invoice_id').val(id)
    $('.c_customer_id').val(res.customer_id)
    var rows = "";
    var i = 0;
    $.each(res.credit_note, function(k,v) {
      rows += '<tr>'+
              '<td><input type="hidden" name="credit['+i+'][crn_id]" value="'+v.id+'">'+'CN-000'+v.id+'</td>'+
              '<td>'+v.credit_date+'</td>'+
              '<td>'+v.total_amount+'</td>'+
              '<td>'+v.credits_available+'</td>'+
              '<td><input type="text" name="credit['+i+'][credit_applied]" class="form-control credit_applied_inp"></td>';
      i++;
    });
    $('#view-credits-tbl > tbody').append(rows);
    $('#apply_credits_mdl').modal('show');
  });
})
$(document).on('click','#btnCreditSubmit',function(){
  var id = $('.c_invoice_id').val();
  var form = $('#apply_credits_indv')[0];
  var formData = new FormData(form);

  var anyFieldIsEmpty = $(".credit_applied_inp").filter(function() {
      return $.trim(this.value).length === 0;
  }).length > 0;

  if (anyFieldIsEmpty) {
      $('.errortxt').html('Please enter amount to credit');
      return false;
  } else {
      $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+'/post_data_credits',
        data: formData,
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        encode: true,
      }).done(function (data) {
        $('#apply_credits_mdl').modal('hide');
        alertMessage(data.status, data.message);

        $(".customizer").removeClass("open");
        viewModule(id,'invoice');
      });
  }
});
$(document).on('click','.mark-as-sent',function(){
  var id = $(this).attr('data-id');
  var tab = $(this).attr('data-tab');
  $.ajax({
      type: "POST",
      url: '<?= base_url() ?>'+'/update_field',
      data: {'key':'is_sent','value':1,'table_name':'sell_orders','id':id},
      dataType: "json",
      encode: true,
    }).done(function (data) {
      window.location.reload();
      $(".customizer").removeClass("open");
      viewModule(id,tab);
    });
});
$(document).on('click','#v-record-payment',function() {
    var id = $(this).attr('data-id');

    $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+'/sales/record_new_payment',
        data: {id:id},
        success: function (res) {
          res = JSON.parse(res)
          var data = res.data;
           if(res.status == "true") {
              $('#v-opt-header').hide();
              $('#inv-area').hide();
              $('#payment-area').show();

              var options = '';
              $.each(data.payments, function(k,v) {
                var s = "";
                if(v.payment_type == "Cash" || v.payment_type == "cash") {
                  s = "selected";
                }
                options += '<option value="'+v.id+'" "'+s+'">'+v.payment_type+'</option>';
              });

              var html = '<form method="post" id="payment-received-form" name="payment-received-form">'+
                        '<input type="hidden" name="id" id="id" value="">'+
                        '<input type="hidden" name="table_name" id="table_name" value="sales_payment">'+
                        '<input type="hidden" name="invoice_id" id="invoice_id" value="'+data.invoice.id+'">'+
                        '<input type="hidden" name="store_id" id="store_id" value="'+data.invoice.store_id+'">'+
                        '<div class="row g-2" style="width: 100%;">'+
                           '<div class="col-md">'+
                            '<div class="form-floating">'+
                              '<input type="hidden" name="customer_id" id="customer_id" value="'+data.invoice.customer_id+'">'+
                              '<input type="text" class="form-control" id="customer" value="'+data.invoice.registerd_name+'" name="customer" placeholder="Customer name">'+
                              '<label for="floatingSelectGrid">Customer Name*</label>'+
                            '</div>'+
                          '</div>'+
                          '<div class="col-md">'+
                            '<div class="form-floating">'+
                              '<input type="text" class="form-control" id="payment_id" name="payment_id" placeholder="Payment">'+
                              '<label for="floatingSelectGrid">Payment #*</label>'+
                            '</div>'+
                          '</div>'+
                        '</div>'+
                        '<div class="amount-sec">'+
                           '<div class="row g-2">'+
                              '<div class="col-md">'+
                               '<div class="form-floating">'+
                                 '<input type="text" class="form-control" name="amount_received" id="amount_received" placeholder="Amount Received">'+
                                 '<label for="floatingSelectGrid">Amount Received*</label>'+
                               '</div>'+
                             '</div>'+
                          '</div>'+
                          '<div class="row g-2 pt-1">'+
                             '<div class="col-md">'+
                               '<div class="form-floating">'+
                                 '<input type="text" class="form-control" name="bank_charges" placeholder="Bank Charges">'+
                                 '<label for="floatingSelectGrid">Bank Charges(if any)</label>'+
                               '</div>'+
                             '</div>'+
                           '</div>'+
                        '</div>'+
                        '<div class="row g-2 pt-1" style="width: 100%;">'+
                           '<div class="col-md">'+
                            '<div class="form-floating">'+
                              '<input type="date" class="form-control" name="payment_date" placeholder="Payment Date" value="<?= date('Y-m-d'); ?>">'+
                              '<label for="floatingSelectGrid">Payment Date*</label>'+
                            '</div>'+
                          '</div>'+
                          '<div class="col-md">'+
                            '<div class="form-floating">'+
                              '<select class="form-select" name="type_id" id="type_id" aria-label="Floating label select example">'+options+'</select>'+
                              '<label for="floatingSelectGrid">Payment mode</label>'+
                            '</div>'+
                          '</div>'+
                          /*'<div class="col-md">'+
                            '<div class="form-floating">'+
                              '<input type="text" class="form-control" name="deposit_to" placeholder="Payment">'+
                              '<label for="floatingSelectGrid">Deposit To</label>'+
                            '</div>'+
                          '</div>'+*/
                        '</div>'+
                        '<div class="row g-2 pt-1" style="width: 100%;">'+
                           '<div class="col-md">'+
                              '<textarea name="notes" placeholder="Notes" rows="4" cols="50" class="form-control"></textarea>'+
                           '</div>'+
                        '</div>'+
                        '<div class="row p-1">'+
                           '<button id="add-payment-received" data-id="'+id+'" type="button" class="btn btn-info" style="line-height: 0">Record Payment</button>'+
                        '</div>'+
                      '</form>';

              $('#payment-area').html('');
              $('#payment-area').append(html);

              $('#amount_received').val(res.data.remaining_amt);

              $('#v-func-section').hide();
              $('#v-heading').text('Payment for INV-000'+data.invoice.id)
           }
        }
    });
});
$(document).on('click','#v-credit-note',function() {
    var id = $(this).attr('data-id');

    $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+'/sales/record_new_payment',
        data: {id:id},
        success: function (res) {
          res = JSON.parse(res)
          var data = res.data;
           if(res.status == "true") {
              $('#v-opt-header').hide();
              $('#inv-area').hide();
              $('#payment-area').show();

              var options = '';
              $.each(data.payments, function(k,v) {
                var s = "";
                if(v.payment_type == "Cash" || v.payment_type == "cash") {
                  s = "selected";
                }
                options += '<option value="'+v.id+'" "'+s+'">'+v.payment_type+'</option>';
              });

              var html = '<form method="post" id="credit-note-form" name="credit-note-form">'+
                        '<input type="hidden" name="id" id="id" value="">'+
                        '<input type="hidden" name="table_name" id="table_name" value="credits">'+
                        '<input type="hidden" name="invoice_id" id="invoice_id" value="'+data.invoice.id+'">'+
                        '<input type="hidden" name="store_id" id="store_id" value="'+data.invoice.store_id+'">'+
                        '<div class="row g-2" style="width: 100%;">'+
                           '<div class="col-md">'+
                            '<div class="form-floating">'+
                              '<input type="hidden" name="customer_id" id="customer_id" value="'+data.invoice.customer_id+'">'+
                              '<input type="text" class="form-control" id="customer" value="'+data.invoice.registerd_name+'" name="customer" placeholder="Customer name">'+
                              '<label for="floatingSelectGrid">Customer Name*</label>'+
                            '</div>'+
                          '</div>'+
                          '<div class="col-md">'+
                            '<div class="form-floating">'+
                              '<input type="text" class="form-control" id="credits_id" name="credits_id" placeholder="Credit Note">'+
                              '<label for="floatingSelectGrid">Credit Note #*</label>'+
                            '</div>'+
                          '</div>'+
                        '</div>'+
                        '<div class="row g-2 pt-1" style="width: 100%;">'+
                          '<div class="col-md">'+
                            '<div class="form-floating">'+
                              '<input type="text" class="form-control" name="amount" id="amount" placeholder="Amount">'+
                                 '<label for="floatingSelectGrid">Amount*</label>'+
                            '</div>'+
                          '</div>'+
                          '<div class="col-md">'+
                            '<div class="form-floating">'+
                              '<input type="date" class="form-control" name="credit_date" placeholder="Credit Note Date" value="<?= date('Y-m-d'); ?>">'+
                              '<label for="floatingSelectGrid">Credit Note Date*</label>'+
                            '</div>'+
                          '</div>'+
                        '</div>'+
                        '<div class="row g-2 pt-1" style="width: 100%;">'+
                           '<div class="col-md">'+
                              '<textarea name="notes" placeholder="Notes" rows="4" cols="50" class="form-control"></textarea>'+
                           '</div>'+
                        '</div>'+
                        '<div class="row p-1">'+
                           '<button id="add-credit-note" type="button" class="btn btn-info" style="line-height: 0">Submit</button>&nbsp;'+
                           '<button id="cncl" data-id="'+id+'" type="button" class="btn btn-light" style="line-height: 0">Cancel</button>'+
                        '</div>'+
                      '</form>';

              $('#payment-area').html('');
              $('#payment-area').append(html);

              $('#amount_received').val(res.data.remaining_amt);

              $('#v-func-section').hide();
              $('#v-heading').text('Create Credit Note');
           }
        }
    });
});
$(document).on('click','#v-sendmail',function() {
    var self = $(this);
    var id = self.attr('data-id'),
        storeId = self.attr('data-store-id');

    $.ajax({
      type: "POST",
        url: '<?= base_url() ?>'+'/sales/send_invoice_mail',
        data: {id:id,store_id:storeId},
        success: function (res) { 
          var data = JSON.parse(res);
           if(data.status == "true") {
              alertMessage(data.status, data.message);
           } else {
              alertMessage(data.status, data.message);
           }
        }
    })
});
$(document).on('click','#add-payment-received',function(){
    var invoice_id = $('#invoice_id').val();
    var id = $(this).attr('data-id');
    var formData = $('#payment-received-form').serialize();

    $.ajax({
      type: "POST",
      url: '<?= base_url() ?>'+'/post_data_sales',
      data: formData,
      dataType: "json",
      encode: true,
    }).done(function (data) {
      // $("#add-payment-received").attr("disabled", false);
      $(".customizer").removeClass("open");
      viewModule(invoice_id,'invoice');
      // alertMessage(data.status, data.message);
    });
    /*$('#payment-received-form').validate({
         rules: {
            amount_received: "required",
         },
         messages: {
            amount_received: "Please enter amount received",
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
            event.preventDefault();
            $("#add-payment-received").attr("disabled", true);
            var formData = $('#payment-received-form').serialize();

            $.ajax({
              type: "POST",
              url: '<?= base_url() ?>'+'/post_data_sales',
              data: formData,
              dataType: "json",
              encode: true,
            }).done(function (data) {
              $("#add-payment-received").attr("disabled", false);
              viewInvoice(invoice_id);
              // alertMessage(data.status, data.message);
            });

         }
    });*/
});
$(document).on('click','.view-cn',function(){
  $('#creditNoteTbl tbody tr').removeClass('selected-tr');
  $(".customizer").removeClass("open");

    var self = $(this);
    var id = self.attr("data-id");
    $('.loading').css('display','block');
    viewCNModule(id);
});
function viewCNModule(id){
  $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+'/sales/view_credit_note',
        data: {id:id},
        success: function (res) { 
            res = JSON.parse(res);
            var data = res.data.module,
            items = res.data.items,
            date = data.credit_date;

            $("#c-heading").text('CN-000'+data.id);
            $("#c-receipt-no").text('000'+data.id);
            $("#c-cust-name").text(data.registerd_name);
            $("#c-cust-address").text(data.address);
            $("#c-module-date").html('<h6 style="text-transform:capitalize">Credit Note Date: <span class="summary-amount" id="" style="font-weight: 500;">'+date+'</span></h6>');
            $("#c-module-date").html('<h6>Credit Note Date: <span class="summary-amount" style="font-weight: 500;">'+date+'</span></h6>');

            $('.m-details').html('<span style="font-size: 30px;text-transform:uppercase" class="module">Credit Note</span><br/><p>'+'Credit Note-<span id="v-receipt-no">000'+data.id+'</span></p>');

            $('#c-module-items-tbl tbody').html('');
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
              $('#c-module-items-tbl tbody').append(html);
              i++;
            });

            $('#c-disc').text(data.total_discount)
            $("#c-sub-total").text(data.sub_total);
            $("#c-tax").text(data.total_tax);
            $("#c-total-amount").html('<b>'+data.total_amount+'</b>');
            $("#c-total-amount").attr('data-amt',data.total_amount);

            $('#c-func-section').html('');
            if(!res.data.is_refund) {
              $('#c-func-section').html('<div class="col-md-12">'+
                      '<div class="bs-callout-primary callout-border-left callout-bordered p-1 d-flex">'+
                      '<p class="pr-5">You can click on the following button to<br/> refund back the amount.</p>'+
                      '<button class="btn btn-info flex-end refund-cn-amt" data-id="'+data.id+'" data-tab="credit-note">Refund Amount</button>'+
                  '</div>'+
              '</div>');
            } else {
              $('#c-func-section').html('<div class="col-md-12">'+
                      '<div class="bs-callout-primary callout-border-left callout-bordered p-1 d-flex">'+
                      '<p class="pr-5">Refunded amount: </p>'+
                      '<span class="flex-end" data-id="'+data.id+'">'+res.data.refund_amt+'</span>'+
                  '</div>'+
              '</div>');
            }

            $('#c-opt-header').show();
            
            $('.credit-id-'+id).parent('td').parent('tr').addClass('selected-tr');
            $(".customizr").toggleClass("open");
            $('.loading').css('display','none');
        }
    });
}
$(document).on('click','.refund-cn-amt',function(){
  $('#btnSubmitRefund').attr('data-id',$(this).attr('data-id'));
  $('#c-refund-amt').val($('#c-total-amount').attr('data-amt'));
  $('#refund-cn-amt-mdl').modal('show');
})
$(document).on('click','#btnSubmitRefund',function(){
  var id = $(this).attr('data-id');
  var type_id = $('#c-payment-type').val();
  var type = $('#c-payment-type option:selected').text();
  var amt = $('#c-refund-amt').val();

  $.ajax({
      type: "POST",
      url: '<?= base_url() ?>'+'/post_data_refund',
      data: {crn_id:id, type_id:type_id, type:type,amt:amt},
      dataType: "json",
      encode: true,
    }).done(function (data) {
      if(data.status == "true") {
        $(".customizer").removeClass("open");
        $('#refund-cn-amt-mdl').modal('hide');
        viewCNModule(id);
      }
    });
});
$(document).on('click','.nav-tabs > .nav-item',function(){
  $(".customizr").removeClass("open");
});
$(document).on('click','#add-credit-note',function(){
    var invoice_id = $('#invoice_id').val();
    var formData = $('#credit-note-form').serialize();

    $.ajax({
      type: "POST",
      url: '<?= base_url() ?>'+'/post_data_sales',
      data: formData,
      dataType: "json",
      encode: true,
    }).done(function (data) {
      $(".customizer").removeClass("open");
      viewModule(invoice_id);
    });
});
$(document).on('click','#cncl',function() {
    $(this).attr('data-id');
    $(".customizer").removeClass("open");
    viewModule(invoice_id);
});
function submit_received_payment(formData) {
  $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+'/post_data_sales',
        data: formData,
        success: function (res) {
        }
    });
}
/*$(document).on('click','#sr-download',function() {

    var id = $(this).attr("data-id");
    $.ajax({
        type: "POST",
        url: '<?= base_url() ?>'+'/sales/printInvoicePDF',
        data: {id:id},
        success: function (res) { 
            res = JSON.parse(res);
            console.log(res.status);

        }
    });
});*/
  function printInvoice() {
    var printContents = document.getElementById('inv-print-area').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
  }
</script>