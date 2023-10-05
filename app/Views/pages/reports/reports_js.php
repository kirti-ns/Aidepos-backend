<style type="text/css">
  .dropdown-toggle::after {
        font-size: .8rem;
        font-family: FontAwesome;
        content: '\f107'!important;
        border: none!important;
        position: relative;
        top: 0;
        right: 0;
        padding: 0 2px 0 6px!important;
        margin: 0 0.3em 0 0;
        vertical-align: 0;
    }
</style>
<script type="text/javascript">
  $(document).ready(function(){
    $('.layby_type').change(function(){
      var val = $(this).val();
      if(val == "4") {
        $('.filter-bl-amount').css('display','block');
      } else {
        $('.filter-bl-amount').css('display','none')
      }
    });      
    var sByItem = $('#report-sales-item').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          dom: "<'row'<'col-sm-12'tr>>" +
          "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
          'ajax': {
             'url':"<?=site_url('/reports/sales-by-item')?>",
             'data': function(data){
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var obj = $("form.filterReport").serializeArray();

                 let filter = {};
                 $.each(obj, function(k, v){
                   var aFName = v.name.replaceAll("]", "").split("[");;
                   switch(aFName.length){
                     case 1:
                       filter[aFName[0]] = v.value;
                       break;
                     case 2:
                       if(filter[aFName[0]] == undefined){
                         filter[aFName[0]] = {};
                       }
                       filter[aFName[0]][aFName[1]] = v.value;
                       break;
                   }
                 });

                return {
                   data: data, 
                   // length: 5,
                   filter: filter,
                   [csrfName]: csrfHash
                };
             },
             dataSrc: function(data){
               $('.txt_csrfname').val(data.token);
               return data.aaData;
             }
          },
          columnDefs: [
            {
               "defaultContent": "-",
               "targets": "_all"
            }
          ],
          createdRow: function(row, data, dataIndex ) {
            var c0 = data.item_name;
            var c1 = data.sku;
            var c2 = data.qty;
            var c3 = data.amount;
            
            $(row).children().eq(0).addClass(displayBorder('status',data.status)).html(c0);
            $(row).children().eq(1).html(c1);
            $(row).children().eq(2).html(c2);
            $(row).children().eq(3).html(c3);
                             
          }
    });
    $('.reportSearchBtn').click(function(e){
      e.preventDefault();
      sByItem.draw();
    });
    var sByTerminal = $('#report-sales-terminal').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          dom: "<'row'<'col-sm-12'tr>>" +
          "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
          'ajax': {
             'url':"<?=site_url('/reports/sales-by-terminal')?>",
             'data': function(data){
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var obj = $("form.filterReport").serializeArray();

                 let filter = {};
                 $.each(obj, function(k, v){
                   var aFName = v.name.replaceAll("]", "").split("[");;
                   switch(aFName.length){
                     case 1:
                       filter[aFName[0]] = v.value;
                       break;
                     case 2:
                       if(filter[aFName[0]] == undefined){
                         filter[aFName[0]] = {};
                       }
                       filter[aFName[0]][aFName[1]] = v.value;
                       break;
                   }
                 });

                return {
                   data: data, 
                   // length: 5,
                   filter: filter,
                   [csrfName]: csrfHash
                };
             },
             dataSrc: function(data){
               $('.txt_csrfname').val(data.token);
               return data.aaData;
             }
          },
          columnDefs: [
            {
               "defaultContent": "-",
               "targets": "_all"
            }
          ],
          createdRow: function(row, data, dataIndex ) {
            var c0 = data.store_name;
            var c1 = data.terminal_name;
            var c2 = data.item_code;
            var c3 = data.item_name;
            var c4 = data.sku;
            var c5 = data.date;
            var c6 = data.qty;
            var c7 = data.amount;
            
            $(row).children().eq(0).addClass(displayBorder('status',data.status)).html(c0);
            $(row).children().eq(1).html(c1);
            $(row).children().eq(2).html(c2);
            $(row).children().eq(3).html(c3);
            $(row).children().eq(4).html(c4);
            $(row).children().eq(5).html(c5);
            $(row).children().eq(6).html(c6);
            $(row).children().eq(7).html(c7);
                             
          }
    });
    $('.reportSearchBtn').click(function(e){
      e.preventDefault();
      sByTerminal.draw();
    });
    var creditNote = $('#report-credit-notes').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          dom: "<'row'<'col-sm-12'tr>>" +
          "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
          'ajax': {
             'url':"<?=site_url('/reports/credit-notes')?>",
             'data': function(data){
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var obj = $("form.filterReport").serializeArray();

                 let filter = {};
                 $.each(obj, function(k, v){
                   var aFName = v.name.replaceAll("]", "").split("[");;
                   switch(aFName.length){
                     case 1:
                       filter[aFName[0]] = v.value;
                       break;
                     case 2:
                       if(filter[aFName[0]] == undefined){
                         filter[aFName[0]] = {};
                       }
                       filter[aFName[0]][aFName[1]] = v.value;
                       break;
                   }
                 });

                return {
                   data: data, 
                   // length: 5,
                   filter: filter,
                   [csrfName]: csrfHash
                };
             },
             dataSrc: function(data){
               $('.txt_csrfname').val(data.token);
               return data.aaData;
             }
          },
          columnDefs: [
            {
               "defaultContent": "-",
               "targets": "_all"
            }
          ],
          createdRow: function(row, data, dataIndex ) {
            var c0 = 'CN-000'+data.credit_note;
            var c1 = data.date;
            var c2 = data.customer_name;
            var c3 = data.total_amount;
            var c4 = data.balance;
            
            $(row).children().eq(0).addClass(displayBorder('status',data.status)).html(c0);
            $(row).children().eq(1).html(c1);
            $(row).children().eq(2).html(c2);
            $(row).children().eq(3).html(c3);
            $(row).children().eq(4).html(c4);
                             
          }
    });
    $('.reportSearchBtn').click(function(e){
      e.preventDefault();
      creditNote.draw();
    });
    var stockOnHand = $('#report-stock-on-hand').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          dom: "<'row'<'col-sm-12'tr>>" +
          "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
          'ajax': {
             'url':"<?=site_url('/reports/stock-on-hand')?>",
             'data': function(data){
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var obj = $("form.filterReport").serializeArray();

                 let filter = {};
                 $.each(obj, function(k, v){
                   var aFName = v.name.replaceAll("]", "").split("[");;
                   switch(aFName.length){
                     case 1:
                       filter[aFName[0]] = v.value;
                       break;
                     case 2:
                       if(filter[aFName[0]] == undefined){
                         filter[aFName[0]] = {};
                       }
                       filter[aFName[0]][aFName[1]] = v.value;
                       break;
                   }
                 });

                return {
                   data: data, 
                   // length: 5,
                   filter: filter,
                   [csrfName]: csrfHash
                };
             },
             dataSrc: function(data){
               $('.txt_csrfname').val(data.token);
               return data.aaData;
             }
          },
          columnDefs: [
            {
               "defaultContent": "-",
               "targets": "_all"
            }
          ],
          createdRow: function(row, data, dataIndex ) {
            var c0 = data.store_name;
            var c1 = data.location;
            var c2 = data.sku;
            var c3 = data.item_name;
            var c4 = data.category_name;
            var c5 = data.brand_name;
            var c6 = data.cost_price;
            var c7 = data.unit;
            var c8 = data.current_inventory;
            var c9 = data.inventory_amount;
            
            $(row).children().eq(0).html(c0);
            $(row).children().eq(1).html(c1);
            $(row).children().eq(2).html(c2);
            $(row).children().eq(3).html(c3);
            $(row).children().eq(4).html(c4);
            $(row).children().eq(5).html(c5);
            $(row).children().eq(6).html(c6);
            $(row).children().eq(7).html(c7);
            $(row).children().eq(8).html(c8);
            $(row).children().eq(9).html(c9);
                             
          }
    });
    $('.reportSearchBtn').click(function(e){
      e.preventDefault();
      stockOnHand.draw();
    });
    var stockValuation = $('#report-stock-valuation').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          dom: "<'row'<'col-sm-12'tr>>" +
          "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
          'ajax': {
             'url':"<?=site_url('/reports/stock-valuation')?>",
             'data': function(data){
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var obj = $("form.filterReport").serializeArray();

                 let filter = {};
                 $.each(obj, function(k, v){
                   var aFName = v.name.replaceAll("]", "").split("[");;
                   switch(aFName.length){
                     case 1:
                       filter[aFName[0]] = v.value;
                       break;
                     case 2:
                       if(filter[aFName[0]] == undefined){
                         filter[aFName[0]] = {};
                       }
                       filter[aFName[0]][aFName[1]] = v.value;
                       break;
                   }
                 });

                return {
                   data: data, 
                   // length: 5,
                   filter: filter,
                   [csrfName]: csrfHash
                };
             },
             dataSrc: function(data){
               $('.txt_csrfname').val(data.token);
               return data.aaData;
             }
          },
          columnDefs: [
            {
               "defaultContent": "-",
               "targets": "_all"
            }
          ],
          createdRow: function(row, data, dataIndex ) {
            var c0 = data.store_name;
            var c1 = data.item_name;
            var c2 = data.sku_barcode;
            var c3 = data.uom;
            var c4 = data.current_inventory;
            var c5 = data.inventory_value;
            
            $(row).children().eq(0).html(c0);
            $(row).children().eq(1).html(c1);
            $(row).children().eq(2).html(c2);
            $(row).children().eq(3).html(c3);
            $(row).children().eq(4).html(c4);
            $(row).children().eq(5).html(c5);
                             
          }
    });
    $('.reportSearchBtn').click(function(e){
      e.preventDefault();
      stockValuation.draw();
    });
    var stockPrice = $('#report-stock-price').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          dom: "<'row'<'col-sm-12'tr>>" +
          "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
          'ajax': {
             'url':"<?=site_url('/reports/stock-price')?>",
             'data': function(data){
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var obj = $("form.filterReport").serializeArray();

                 let filter = {};
                 $.each(obj, function(k, v){
                   var aFName = v.name.replaceAll("]", "").split("[");;
                   switch(aFName.length){
                     case 1:
                       filter[aFName[0]] = v.value;
                       break;
                     case 2:
                       if(filter[aFName[0]] == undefined){
                         filter[aFName[0]] = {};
                       }
                       filter[aFName[0]][aFName[1]] = v.value;
                       break;
                   }
                 });

                return {
                   data: data, 
                   // length: 5,
                   filter: filter,
                   [csrfName]: csrfHash
                };
             },
             dataSrc: function(data){
               $('.txt_csrfname').val(data.token);
               return data.aaData;
             }
          },
          columnDefs: [
            {
               "defaultContent": "-",
               "targets": "_all"
            }
          ],
          createdRow: function(row, data, dataIndex ) {
            var c0 = data.store_name;
            var c1 = data.sku_barcode;
            var c2 = data.item_name;
            var c3 = data.category_name;
            var c4 = data.supply_price || '-';
            var c5 = data.retail_price || '-';
            var c6 = data.current_inventory;
            var c7 = data.inventory_value;;
            
            $(row).children().eq(0).html(c0);
            $(row).children().eq(1).html(c1);
            $(row).children().eq(2).html(c2);
            $(row).children().eq(3).html(c3);
            $(row).children().eq(4).html(c4);
            $(row).children().eq(5).html(c5);
            $(row).children().eq(6).html(c6);
            $(row).children().eq(7).html(c7);
                             
          }
    });
    $('.reportSearchBtn').click(function(e){
      e.preventDefault();
      stockPrice.draw();
    });
    var stockWithQty = $('#report-stock-with-qty').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          dom: "<'row'<'col-sm-12'tr>>" +
          "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
          'ajax': {
             'url':"<?=site_url('/reports/stock-take-with-qty')?>",
             'data': function(data){
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var obj = $("form.filterReport").serializeArray();

                 let filter = {};
                 $.each(obj, function(k, v){
                   var aFName = v.name.replaceAll("]", "").split("[");;
                   switch(aFName.length){
                     case 1:
                       filter[aFName[0]] = v.value;
                       break;
                     case 2:
                       if(filter[aFName[0]] == undefined){
                         filter[aFName[0]] = {};
                       }
                       filter[aFName[0]][aFName[1]] = v.value;
                       break;
                   }
                 });

                return {
                   data: data, 
                   // length: 5,
                   filter: filter,
                   [csrfName]: csrfHash
                };
             },
             dataSrc: function(data){
               $('.txt_csrfname').val(data.token);
               return data.aaData;
             }
          },
          columnDefs: [
            {
               "defaultContent": "-",
               "targets": "_all"
            }
          ],
          createdRow: function(row, data, dataIndex ) {

            var dt = new Date(data.created_at);

            var c0 = data.store_name;
            var c1 = data.location;
            var c2 = dt.getFullYear()+'-'+("00" + (dt.getMonth() + 1)).slice(-2)+'-'+("0" + dt.getDate()).slice(-2);
            var c3 = data.sku_barcode;
            var c4 = data.item_name;
            var c5 = data.category_name;
            var c6 = data.retail_price;
            var c7 = data.open_qty;
            var c8 = data.received_qty;
            var c9 = data.return_qty;
            var c10 = data.adjustment_qty;
            var c11 = data.production_qty;
            var c12 = data.transfer_qty;
            var c13 = data.sold_qty;
            var c14 = data.close_qty;
            
            $(row).children().eq(0).html(c0);
            $(row).children().eq(1).html(c1);
            $(row).children().eq(2).html(c2);
            $(row).children().eq(3).html(c3);
            $(row).children().eq(4).html(c4);
            $(row).children().eq(5).html(c5);
            $(row).children().eq(6).html(c6);
            $(row).children().eq(7).html(c7);
            $(row).children().eq(8).html(c8);
            $(row).children().eq(9).html(c9);
            $(row).children().eq(10).html(c10);
            $(row).children().eq(11).html(c11);
            $(row).children().eq(12).html(c12);
            $(row).children().eq(13).html(c13);
            $(row).children().eq(14).html(c14);
                             
          }
    });
    $('.reportSearchBtn').click(function(e){
      e.preventDefault();
      stockWithQty.draw();
    });
    var laybySales = $('#report-layby-sales').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          dom: "<'row'<'col-sm-12'tr>>" +
          "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
          'ajax': {
             'url':"<?=site_url('/reports/layby-sales')?>",
             'data': function(data){
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var obj = $("form.filterReport").serializeArray();

                 let filter = {};
                 $.each(obj, function(k, v){
                   var aFName = v.name.replaceAll("]", "").split("[");;
                   switch(aFName.length){
                     case 1:
                       filter[aFName[0]] = v.value;
                       break;
                     case 2:
                       if(filter[aFName[0]] == undefined){
                         filter[aFName[0]] = {};
                       }
                       filter[aFName[0]][aFName[1]] = v.value;
                       break;
                   }
                 });

                return {
                   data: data, 
                   // length: 5,
                   filter: filter,
                   [csrfName]: csrfHash
                };
             },
             dataSrc: function(data){
               $('.txt_csrfname').val(data.token);
               return data.aaData;
             }
          },
          columnDefs: [
            {
               "defaultContent": "-",
               "targets": "_all"
            }
          ],
          createdRow: function(row, data, dataIndex ) {
            var c0 = 'LAY-000'+data.contract;
            var c1 = data.store_name;
            var c2 = data.customer_name;
            var c3 = data.amount;
            var c4 = data.balance;
            var c5 = data.paid_amount;
            var c6 = data.date_last_paid;
            var c7 = data.due_date
            var c8 = data.status;
            
            $(row).children().eq(0).html(c0);
            $(row).children().eq(1).html(c1);
            $(row).children().eq(2).html(c2);
            $(row).children().eq(3).html(c3);
            $(row).children().eq(4).html(c4);
            $(row).children().eq(5).html(c5);
            $(row).children().eq(6).html(c6);
            $(row).children().eq(7).html(c7);
            $(row).children().eq(8).html(c8);
                             
          }
    });
    $('.reportSearchBtn').click(function(e){
      e.preventDefault();
      laybySales.draw();
    });
    $('#store_id').change(function(){
      var id = $(this).val();
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
              $('#location_id').html('<option value="">Location</option>');
            }
          }
      });
    });

    $('#export-to-pdf').click(function(){
      var type = $(this).attr('data-type');
      var obj = $("form.filterReport").serializeArray();

     let filter = {};
     $.each(obj, function(k, v){
       var aFName = v.name.replaceAll("]", "").split("[");

       switch(aFName.length){
         case 1:
           filter[aFName[0]] = v.value;
           break;
         case 2:
           if(filter[aFName[0]] == undefined){
             filter[aFName[0]] = {};
           }
           filter[aFName[0]][aFName[1]] = v.value;
           break;
       }
      });

      var aStr = JSON.stringify(filter);
      var encoded = encodeURIComponent(aStr);
      var url = '<?= base_url() ?>'+'/print-reports?type='+type+'&filter='+encoded;
      console.log(url);
      /*$('#reportLink').attr('href',url)
      return $('#reportLink').click();*/

      var link = document.createElement('a');
      link.href = url;
      document.body.appendChild(link);
      link.click();

      /*$.ajax({
          type: "POST",
          url: '<?= base_url() ?>'+'/reports/print-reports',
          data: {type:type, filter:filter},
          success: function (res) {
            res = JSON.parse(res);
            if(res.status == "true") {
              
            }
          }
      });*/
    });

  });
</script>