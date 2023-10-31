<script type="text/javascript">
    var currency = '<?= isset($data['currency_symbol'])?$data['currency_symbol']:'' ?>'
    $(document).ready(function(){
      
      /*----------------Purchase Menu-------------*/

      /*Supplier Start*/
      var supplierTbl = $('#supplierTbl').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=site_url('purchases/getSupplier')?>",
               'data': function(data){
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                  var obj = $("form.filterSupplier").serializeArray();

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
              var c0 = data.id;
              var c1 = "<a href=\" "+base_url+"/purchases/edit_supplier/"+data.id+" \" class=\"storeColor\">"+data.registered_name+"</a>";
              var c2 = data.tax_amount_name;
              var c3 = data.operator;
              var c4 = data.email;
              var c5 = data.phone;
              var c6 = data.payable;
              var c7 = data.created_at;
             
              var c9 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"suppliers\"><i class=\"fa fa-trash-o\"></i></a>";
              $(row).children().eq(0).addClass(displayBorder('status',data.status)).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);
              $(row).children().eq(5).html(c5);
              $(row).children().eq(6).html(c6);
              $(row).children().eq(7).html(c7);
              $(row).children().eq(8).html(displayStatus('status',data.status));
              $(row).children().eq(9).html(c9);
                               
            }
        });
      $('.searchDtBtn').click(function(e){
              e.preventDefault();
              supplierTbl.draw();
      });  
      /*Supplier End*/ 

      /*Purchase Order Start*/
      var pOrderTbl = $('#purchaseOrderTbl').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'sPagingType': 'simple',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=site_url('purchases/getPurchaseOrder')?>",
               'data': function(data){
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                  var obj = $("form.filterPOrder").serializeArray();

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

                  return {
                     data: data, 
                     // length: 5,
                     filter: filter,
                     search: $('.psearchDtField').val(),
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
              // var c0 = data.order_number;
              var c0 = "<span class=\"storeColor view-p-module purchase-id-"+data.id+"\" data-id=\""+data.id+"\">PO-000"+data.id+"</span>";
              /*if(data.order_status == 0 || data.order_status == 1 || data.order_status == 4){
                c0 = "<a href=\" "+base_url+"/purchases/edit_purchase_order/"+data.id+" \" class=\"storeColor\">PO-000"+data.order_number+"</a>";
              }else{
                c0 = "<a href=\" "+base_url+"/purchases/view_purchase_order/"+data.id+" \" class=\"storeColor\">PO-000"+data.order_number+"</a>";
              }*/
              var c1 = data.store_name;
              var c2 = data.supplier_name;
              var c3 = data.date;
              var c4 = data.due_date;
              var c5 = data.total_amount;
              var c6 = data.total_amount;
              var c7 = "";
              if(data.order_status == "0") {
                c7 = "<button class=\"btn btn-outline-info sb-approval\" style=\"font-size: 12px;height: 30px;padding:.5rem 1rem\" data-id="+data.id+">Submit for Approval</button>"; 
              } else {
                c7 = displayStatus('purchase_order',data.order_status)
              }
             
              if(data.order_status == 0 || data.order_status == 1 || data.order_status == 4){
                var c8 = "<a href=\"#\" data-id=\""+data.id+ "\" data-table=\"purchaseorders\" class=\"transh-icon-color deleteRow\"><i class=\"fa fa-trash-o\"></i></a>";
              }else{
                var c8 = "";
              }
              $(row).children().eq(0).addClass(displayBorder('purchase_order',data.order_status)).html(c0);
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
      $('.searchPoDtBtn').click(function(e){
              e.preventDefault();
              pOrderTbl.draw();
      }); 
      /*Purchase Order End*/ 
      $(document).on('click','.sb-approval',function(){
        var self = $(this)
        var id = self.attr('data-id');
        var thisRow = self.parent('td');
        $.ajax({
           type: "POST",
           url: "<?= base_url('update_status')?>",
           data: {
              id: id,
              order_status: 5,
              table_name: 'purchaseorders'
           },
           dataType: "json",
           encode: true,
        }).done(function (data) {
           alertMessage(data.status, data.message);
           thisRow.html('<span class="td-pending">Pending Approval</span>')
           pOrderReviewTbl.draw();
        })
      })
      /*Purchase Order Review Start*/
      var pOrderReviewTbl = $('#purchaseOrderReviewTbl').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'sPagingType': 'simple',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=site_url('purchases/getPurchaseOrderReview')?>",
               'data': function(data){
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                  var obj = $("form.filterReviewOrder").serializeArray();

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
                     search: $('.psearchDtField').val(),
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
              var c0 = "<a href=\" "+base_url+"/purchases/edit_purchase_order/"+data.id+" \" class=\"storeColor\">PO-000"+data.order_number+"</a>";
              var c1 = data.store_name;
              var c2 = data.supplier_name;
              var c3 = data.date;
              var c4 = data.due_date;
              var c5 = data.total_amount;
              /*var c7 = "<a href=\"#\" class=\"auditeModel\" data-id=\""+data.id+"\"><i class=\"fa fa-pencil\"></i></a>";*/
              var c6 = displayStatus('purchase_order',data.order_status);
              var c7 = '<div><a href="#" title="Approved" data-id="1" data-order_id="'+data.id+'" class="btn btn-success btn-sm update-status"><i class="fa fa-check"></i></a>&nbsp;<a href="#" title="Not Approved" class="btn btn-danger btn-sm update-status" data-id="2" data-order_id="'+data.id+'"><i class="fa fa-close"></i></a></div>';
              $(row).children().eq(0).addClass(displayBorder('purchase_order',data.order_status)).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);
              $(row).children().eq(5).html(c5);
              $(row).children().eq(6).html(c6);
              $(row).children().eq(7).html(c7);                 
            }
        });

      /*Purchase Order Review End*/

      /*Goods Received Start*/
      
      var goodReceiveTbl = $('#goodReceiveTbl').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=site_url('purchases/getGoodsReceived')?>",
               'data': function(data){
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                  var obj = $("form.filterGoodsReceived").serializeArray();

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
              var c0 = data.order_number;
              var c1 = data.store_name;
              var c2 = data.supplier_name;
              var c3 = data.location_type;
              var c4 = data.date;
             
              //var c5 = displayStatus('purchase_order',data.status);
              if(data.status == 3){
                  var c6 = "<a href=\" "+base_url+"/purchases/view_goods_received/"+data.id+" \"><i class=\"fa fa-eye\"></i></a>";
              }else{
                  var c6 = "<a href=\" "+base_url+"/purchases/edit_goods_received/"+data.id+" \"><i class=\"fa fa-pencil\"></i></a> &nbsp;&nbsp;&nbsp; <a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"goods_received\"><i class=\"fa fa-trash-o\"></i></a>";
              } 
              
              $(row).children().eq(0).addClass(displayBorder('purchase_order',data.status)).html( c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);
              $(row).children().eq(5).html(displayStatus('purchase_order',data.status));
              $(row).children().eq(6).html(c6);
                               
            }
        });

      $('.goodReceiveDtBtn').click(function(e){
           e.preventDefault();
           goodReceiveTbl.draw();
      })
      /*Goods Received End*/

      /*Goods Returned Start*/
      var goodReturnTbl = $('#goodReturnTbl').DataTable({ 
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=site_url('purchases/getGoodsReturned')?>",
               'data': function(data){
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                  var obj = $("form.filterGoodsReturned").serializeArray();

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
             
              var c0 = data.order_number;
              var c1 = data.store_name;
              var c2 = data.supplier_name;
              var c3 = data.return_qty;
              var c4 = data.rate;
              var c5 = data.due_date;
              var c6 = displayStatus('purchase_order',data.status);
              var c7 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"goods_returned\"><i class=\"fa fa-trash-o\"></i></a>";
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
      $('.goodReturnDtBtn').click(function(e){
           e.preventDefault();
           goodReturnTbl.draw();
        })
      /*Goods Returned End*/
      var directgoodReceiveTbl = $('#directGoodReceiveTbl').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=site_url('purchases/getDirectGoodsReceived')?>",
               'data': function(data){
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                  var obj = $("form.filterGoodsReceived").serializeArray();

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
              var c0 = dataIndex+1;
              var c1 = data.store_name;
              var c2 = data.supplier_name;
              var c3 = data.location_type;
              var c4 = data.date;
             
              var c5 = "<a href=\" "+base_url+"/purchases/view_direct_goods_received/"+data.id+" \"><i class=\"fa fa-eye\"></i></a>";

              $(row).children().eq(0).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);
              $(row).children().eq(5).html(c5);
                               
            }
        });

      $('.directReceiveDtBtn').click(function(e){
           e.preventDefault();
           directgoodReceiveTbl.draw();
      })
      /*Back Order Start*/
      var backOrderTbl = $('#backOrderTbl').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=site_url('purchases/getBackOrder')?>",
               'data': function(data){
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                  var obj = $("form.filterBackOrder").serializeArray();

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
              var c0 = "<a href=\" "+base_url+"/purchases/edit_back_order/"+data.id+" \" class=\"storeColor\">P-000"+data.order_number+"</a>";;
              var c1 = data.store_name;
              var c2 = data.supplier_name;
              var c3 = data.due_date;
              var c4 = data.due_date;
              var c5 = data.total_amount;
              // var c6 = data.balance_due;

              var c6 = displayStatus('purchase_order',data.status);
              var c7 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"back_order\"><i class=\"fa fa-trash-o\"></i></a>";
              $(row).children().eq(0).addClass(displayBorder('status',data.status)).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);
              $(row).children().eq(5).html(c5);
              $(row).children().eq(6).html(c6);
              $(row).children().eq(7).html(c7);
              // $(row).children().eq(8).html(c8);

            }
        });
      $('.bkorderDtBtn').click(function(e){
           e.preventDefault();
           backOrderTbl.draw();
        })
      /*Back Order End*/

    /*------------------Purchase Order End-------------------*/    
    
    /*------------------Customer Menu Start-------------------*/    
      /*Customer Tbl*/
      var customerTbl = $('#customer-tbl').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          dom: "<'row'<'col-sm-12'tr>>" +
          "<'row rowDt'<'col-sm-6 colDt'l><'col-sm-4'i><'col-sm-2'p>>",
          'ajax': {
             'url':"<?=site_url('customers/getCustomers')?>",
              'data': function(data){
                var obj = $("form.filterCustomer").serializeArray();
              
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var obj = $("form.filterCustomer").serializeArray();

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
                   [csrfName]: csrfHash
                };
              },
              dataSrc: function(data){
               $('.txt_csrfname').val(data.token);
               return data.aaData;
              }
          },
          lengthMenu: [5, 10, 50, 100],
          columnDefs: [
            {
               "defaultContent": "-",
               "targets": "_all"
            }
          ],
          createdRow: function(row, data, dataIndex ) {
            var c0 = "<a href=\" "+base_url+"/customers/edit_customer/"+data.id+" \" class=\"storeColor\">"+data.account_id+"</a>";
            var c1 = data.tpin_no;
            var c2 = data.lpo_no;
            var c3 = data.id_no;
            var c4 = data.registerd_name;
            var c5 = data.tax_account_name;
            var c6 = data.email;
            var c7 = data.phone;
            var c8 = data.loyalty;
            var statusBorder = "active-border";
            if(data.status == 0) {
               statusBorder = "inactive-border";
            }
            var c9 = "<a href=\" "+base_url+"/customers/view_customer/"+data.id+" \"><i class=\"fa fa-eye\"></i></a> &nbsp;&nbsp;&nbsp; <a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"customers\"><i class=\"fa fa-trash-o\"></i></a>";
            $(row).children().eq(0).addClass(statusBorder).html(c0);
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
        
      $(document).on("click", "#csubmit", function(e){
        e.preventDefault();
        customerTbl.draw();
      });
      /*Customer Tbl End*/

      /*Gift Card Start*/  
        var gift_cardTbl = $('#gift-card-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=base_url('customers/getGiftCards')?>",
               'data': function(data){
                var obj = $("form.filterGiftcards").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){
                  
                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
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
               var c0 = "<a href=\" "+base_url+"/customers/edit_gift_card/"+data.id+" \" class=\"storeColor\">"+data.voucher_card_no+"</a>";
              var c1 = data.batch_name;
              var c2 = data.amount;
              var c3 = data.amount;
              var c4= data.expiry_date;
              var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }
              var c5 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"giftcards\"><i class=\"fa fa-trash-o\"></i></a>";
              $(row).children().eq(0).addClass(statusBorder).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);
              $(row).children().eq(5).html(c5);
                          
                          
            }
        });
        $(document).on("click", "#giftcardbtn", function(e){
              e.preventDefault();
              gift_cardTbl.draw();
          });
      /*Gift Card End*/ 
    
     /*View Customer Transaction Start*/  
      var view_customerTbl = $('#view-customer-table').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          dom: "<'row'<'col-sm-12'tr>>" +
          "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
          'ajax': {
             'url':"<?=base_url('customers/getViewCustomers')?>",
             'data': function(data){
              var obj = $("form.filterCustomerview").serializeArray();
              
              data["advFilter"] = {};
              $.each(obj, function(k, v){
                var aFName = v.name.replaceAll("]", "").split("[");;
                switch(aFName.length){
                  case 1:
                    data["advFilter"][aFName[0]] = v.value;
                    break;
                  case 2:
                    if(data["advFilter"][aFName[0]] == undefined){
                      data["advFilter"][aFName[0]] = {};
                    }
                    data["advFilter"][aFName[0]][aFName[1]] = v.value;
                    break;
                }
              });
              
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                return {
                  data: data,
                  user_id:"<?= isset($data['customer_id'])?$data['customer_id']:""?>",
                  [csrfName]: csrfHash // CSRF Token
                };
             },
             dataSrc: function(data){
                
                // Update token hash
                $('.txt_csrfname').val(data.token);

                // Datatable data
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
            var c0 = 'INV-000'+data.id;
            var c1 = data.order_number;
            var c2 = data.due_date;
            var c3 = data.total_amount;
            var c4= data.balance_due;
            var c5= data.date;
            var c6= data.status;
            var statusBorder = "active-border";
            if(data.status == 0) {
               statusBorder = "inactive-border";
            }
            /*var c7 = "<a href=\" "+base_url+"/customers/edit_gift_card/"+data.id+" \"><i class=\"fa fa-pencil\"></i></a> &nbsp;&nbsp;&nbsp; <a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"giftcards\"><i class=\"fa fa-trash-o\"></i></a>";*/
            $(row).children().eq(0).addClass(statusBorder).html(c0);
            $(row).children().eq(1).html(c1);
            $(row).children().eq(2).html(c2);
            $(row).children().eq(3).html(c3);
            $(row).children().eq(4).html(c4);
            $(row).children().eq(5).html(c5);            
            $(row).children().eq(6).html(c6);//displayStatus('view_customer_transcation',data.payment_status)
            // $(row).children().eq(7).html(c7);            
          }
      });
        $(document).on("click", "#transactionbtn", function(e){
            e.preventDefault();
            view_customerTbl.draw();
        });
    /*View Customer Transaction End*/ 
      /*------------------Customer Menu End-------------------*/   


      /*------------------Item Menu Start-------------------*/   

        /*Item Start*/
        var itemsTbl = $('#item-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=base_url('items/getItem')?>",
               'data': function(data){
                var obj = $("form.filterItem").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){
                  
                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
                  return data.aaData;
               }
            },
            columnDefs: [
              { "orderable": false, "targets": 0 },
              {
                 "defaultContent": "-",
                 "targets": "_all"
              }
            ],
            createdRow: function(row, data, dataIndex ) {
              //;
              var item_type = ""
              if(data.item_type == 2){
                item_type = "#item-with-varience";
              }else if(data.item_type == 3){
                item_type="#composite-item";
              }else{
                item_type="#standard-item";
              }
              
              var c0 = data.sku_barcode;
              var c1 = "<a href=\" "+base_url+"/items/edit_item/"+data.id+item_type+" \" class=\"storeColor\">"+data.item_name+"</a>";
              var c2 = data.category_name;
              var c3 = data.subcategory_name;
              var c4 = data.uom;
              var c5 = data.tax_type;
              var c6 = data.supply_price;
              var c7 = data.retail_price;
              var c8 = data.current_inventory;
              var c9 = data.inventory_value;
              
              var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }
              var c10 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"items\"><i class=\"fa fa-trash-o\"></i></a>";
              var c ="<input type=\"checkbox\" name=\"deleteRow[]\" value=\" "+data.id+" \" class=\"\">"
              $(row).children().eq(0).addClass(statusBorder).html(c);
              $(row).children().eq(1).html(c0);
              $(row).children().eq(2).html(c1);
              $(row).children().eq(3).html(c2);
              $(row).children().eq(4).html(c3);
              $(row).children().eq(5).html(c4);
              $(row).children().eq(6).html(c5);
              $(row).children().eq(7).html(c6);
              $(row).children().eq(8).html(c7);
              $(row).children().eq(9).html(c8);
              $(row).children().eq(10).html(c9);
              $(row).children().eq(11).html(c10);
              // $(row).children().eq(11).html(c10);
              /*$(row).children().eq(11).html(c11);
              $(row).children().eq(12).html(c12);
              $(row).children().eq(13).html(c13);
              $(row).children().eq(14).html(c14);
              $(row).children().eq(15).html(c15);*/
              
            }
      });
        $(document).on("click", "#itemSubmit", function(e){
              e.preventDefault();
              itemsTbl.draw();
          });
        /*Item End*/

       /*Modeifier Start*/
         $(document).on("click", "#modifierSubmit", function(e){
              e.preventDefault();
              modifiersTbl.draw();
          });
        var modifiersTbl = $('#modifiers-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=base_url('items/getModifiers')?>",
               'data': function(data){
                var obj = $("form.filterModifiers").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){
                  
                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
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
               var c0 = "<a href=\" "+base_url+"/items/edit_modifier/"+data.id+" \" class=\"storeColor\">"+data.name+"</a>";
              var c1 = data.groups;
              var c2 = data.product;
              var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }
              var c4 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"modifiers\"><i class=\"fa fa-trash-o\"></i></a>";
              $(row).children().eq(0).addClass(statusBorder).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c4);
              }
          });
        /*Modeifier End*/

        /*UOM Start*/
        var uomTbl = $('#uom-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=base_url('items/getUom')?>",
               'data': function(data){
                var obj = $("form.filteruom").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){
                  
                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
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
               var c0 = "<a href=\" "+base_url+"/items/edit_uom/"+data.id+" \" class=\"storeColor\">"+data.uom+"</a>";
              var c1 = data.formal_name;
              var c2 = data.decimal_point;
              var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }
              var c3 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"uom_master\"><i class=\"fa fa-trash-o\"></i></a>";
              $(row).children().eq(0).addClass(statusBorder).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              }
          });
          $(document).on("click", "#uomSubmit", function(e){
              e.preventDefault();
              uomTbl.draw();
        });
        /*UOM End*/
       
        /*Brand Start*/

        var brandTbl = $('#brand-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=base_url('items/getBrand')?>",
               'data': function(data){
                var obj = $("form.filterBrand").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){
                  
                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
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
              //;
              
              var c0 = "<a href=\" "+base_url+"/items/edit_brand/"+data.id+" \" class=\"storeColor\">"+data.brand_name+"</a>";
              var c1 = data.total_items;
              var c2 = data.total_qty;
              var c3 = data.total_price;
              var c5 = '<span class="exploder fa fa-angle-right" data-toggle="collapse" data-id="'+data.id+'" data-target="#cat'+dataIndex+'" class="accordion-toggle"></span>';


              var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }
              var c4 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"brandmasters\"><i class=\"fa fa-trash-o\"></i></a>";
              $(row).children().eq(0).addClass(statusBorder).html(c5+ ' ' +c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);
             
            }
          });
        $('#brand-table').on('click', '.exploder', function (e) {
              var tr = $(this).closest('tr');
             var row = $('#brand-table').DataTable().row( tr );
              e.preventDefault();
              $(this).toggleClass("fa-angle-right fa-angle-up");
             
             var id = $(this).attr('data-id');
              $.ajax({
                 type: "POST",
                 url: base_url + '/items/getItemDataById',
                 data: {
                    id: id,
                   },
                 dataType: "json",
                 encode: true,
              }).done(function (data) {
              ;
              if(data.status == "true"){


                if (row.child.isShown()) {
                     row.child.hide();
                     tr.removeClass('shown');
                 } else {
                    ;
                   var c6 = '';
                    c6 += '<table class="table DataTable table-striped table-bordered">';
                    c6 += '<thead>';
                    c6 += '<tr>';
                    c6 += '<th>SKU</th>';
                    c6 += '<th>Items</th>';
                    c6 += '<th>Category</th>';
                    c6 += '<th>Sub Category</th>';
                    c6 += '<th>UOM</th>';
                    c6 += '<th>Cost</th>';
                    c6 += '<th>Price</th>';
                    c6 += '<th>Stock</th>';
                    c6 += '<th>Stock Value</th>';
                    c6 += '</tr>';
                    c6 += '</thead>';
                    c6 += '<tbody>';
                     $.each(data.data,function(k,v){
                    c6 += '<tr>';
                    c6 += '<td>'+v.sku_barcode+'</td>';
                    c6 += '<td>'+v.item_name+'</td>';
                    c6 += '<td>'+v.category_name+'</td>';
                    c6 += '<td>'+v.subcategory_name+'</td>';
                    c6 += '<td>'+v.uom+'</td>';
                    c6 += '<td>$'+v.supply_price+'</td>';
                    c6 += '<td>$'+v.retail_price+'</td>';
                    c6 += '<td>'+v.current_inventory+'</td>';
                    c6 += '<td>'+v.inventory_value+'</td>';
                    c6 += '</tr>';
                     });
                    c6 += '</tbody>';
                    c6 += '</table>';
                     row.child(c6).show();
                     tr.addClass('shown');
                }
               }else{
                 alertMessage(data.status,data.message);
              }
              });
           });
        $(document).on("click", "#brandSubmit", function(e){
              e.preventDefault();
              brandTbl.draw();
        });
        /*Brand End*/
        
        var varTbl = $('#vars-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-4 colDt'><'col-sm-4'i><'col-sm-4'p>>",
            'ajax': {
               'url':"<?=base_url('items/getVariants')?>",
               'data': function(data){
                var obj = $("form.filtervar").serializeArray();

                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });

                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){

                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
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
              var c0 = data.id;
              var c1 = data.product_name;

              var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }
              var c2 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"variant_master\"><i class=\"fa fa-trash-o\"></i></a>";
              $(row).children().eq(0).addClass(statusBorder).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              }
        });
        $(document).on("click", "#varSubmit", function(e){
          e.preventDefault();
          varTbl.draw();
        });
        var exTbl = $('#expiry-dt-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=base_url('items/getExpiryItems')?>",
               'data': function(data){
                var obj = $("form.filterExpire").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){
                  
                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
                  return data.aaData;
               }
            },
            columnDefs: [
              { "orderable": false, "targets": 0 },
              {
                 "defaultContent": "-",
                 "targets": "_all"
              }
            ],
            createdRow: function(row, data, dataIndex ) {
              var c0 = dataIndex+1;
              var c1 = data.store_name;
              var c2 = data.location_description;
              var c3 = data.item_name;
              var c4 = data.sku_barcode;
              // var c5 = data.retail_price;
              var c6 = data.qty;
              var c7 = data.lot_no;
              var c8 = data.dom;
              var c9 = data.expiry_date;
              var c10 = data.remaining_days;
              var c11 = data.overdue_days;
              
              $(row).children().eq(0).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);
              // $(row).children().eq(5).html(c5);
              $(row).children().eq(5).html(c6);
              $(row).children().eq(6).html(c7);
              $(row).children().eq(7).html(c8);
              $(row).children().eq(8).html(c9);
              $(row).children().eq(9).html(c10);
              $(row).children().eq(10).html(c11);
              
            }
      });
        $(document).on("click", "#exSubmit", function(e){
              e.preventDefault();
              exTbl.draw();
          });
        var locationTbl = $('#location-tbl').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-4 colDt'><'col-sm-4'i><'col-sm-4'p>>",
            'ajax': {
               'url':"<?=base_url('items/getLocation')?>",
               'data': function(data){
                var obj = $("form.filterloc").serializeArray();

                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });

                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){

                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
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
              var c0 = data.id;
              var c1 = "<a href=\"javascript:void(0);\" data-id=\" "+data.id+ "\" class=\"addLocation storeColor\">"+data.location_description+"</a>";
              var c2 = data.store_name;
              var c3 = data.location_type;
              var c4 = '';

              /*var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }*/
              var c4 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"location\"><i class=\"fa fa-trash-o\"></i></a>";
              $(row).children().eq(0).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);
            }
        });
        $(document).on("click", "#locSubmit", function(e){
          e.preventDefault();
          locationTbl.draw();
        });
      /*------------------Item Menu End-------------------*/
      
      /*------------------Settings Menu Start-------------------*/   
      /*Tax*/
        $(document).ready(function(){
        $(document).on("click", "#taxbtn", function(e){
              e.preventDefault();
              oTable2.draw();
          });
        var oTable2 = $('#tax-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=base_url('settings/getTax')?>",
               'data': function(data){
                var obj = $("form.filterTax").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){
                  
                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
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
               var c0 = "<a href=\" "+base_url+"/settings/edit_tax/"+data.id+" \" class=\"storeColor\">"+data.tax_type+"</a>";
              var c1 = data.tax_rate;
              
              var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }
              var c2 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"taxes\"><i class=\"fa fa-trash-o\"></i></a>";
              $(row).children().eq(0).addClass(statusBorder).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
                          
                          
            }
          });
        });

         /*Store*/
        $(document).ready(function(){
        $(document).on("click", "#storebtn", function(e){
              e.preventDefault();
              oTable2.draw();
          });
        var oTable2 = $('#store-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=base_url('settings/getStore')?>",
               'data': function(data){
                var obj = $("form.filterStore").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){
                  
                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
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
              var c0 = "<a href=\" "+base_url+"/settings/edit_store/"+data.id+" \" class=\"storeColor\">"+data.store_name+"</a>";
              var c1 = data.phone;
              var c2 = data.tax_no;
              var c3 = data.address;
              var c4 = data.total_terminals;

              var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }
              var c5 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"stores\"><i class=\"fa fa-trash-o\"></i></a>";
              $(row).children().eq(0).addClass(statusBorder).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);
              $(row).children().eq(5).html(c5);
                          
                          
            }
          });
        });
        /*Pyamnet Type Start*/
        
        var PaymentTypeTbl = $('#payment-type-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=base_url('settings/getPaymenttype')?>",
               'data': function(data){
                var obj = $("form.filterPayment").serializeArray();
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){
                  
                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
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
               // var c0 = data.payment_type_id;
              var c1 = "<a href=\" "+base_url+"/settings/edit_payment/"+data.id+" \" class=\"storeColor\">"+data.payment_type+"</a>";;
              var c2 = data.receipt_name;
              
              var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }
              var c3 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"payments\"><i class=\"fa fa-trash-o\"></i></a>";
              $(row).children().eq(0).addClass(statusBorder).html(c1);
              $(row).children().eq(1).html(c2);
              $(row).children().eq(2).html(c3);
                          
                          
            }
          });
         $(document).on("click", "#paymenttypebtn", function(e){
              e.preventDefault();
              PaymentTypeTbl.draw();
          });

        /*Pyamnet Type End*/
         
         /*Category Start*/
        $(document).on("click", "#categorySubmit", function(e){
              e.preventDefault();
              categoryTbl.draw();
        });
        var categoryTbl = $('#category-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=base_url('items/getCategory')?>",
               'data': function(data){
                var obj = $("form.filterCategory").serializeArray();
                data['advFilter'] = {};
                   $.each(obj, function(k, v){
                     var aFName = v.name.replaceAll("]", "").split("[");;
                     switch(aFName.length){
                       case 1:
                         data['advFilter'][aFName[0]] = v.value;
                         break;
                       case 2:
                         if(data['advFilter'][aFName[0]] == undefined){
                           data['advFilter'][aFName[0]] = {};
                         }
                         data['advFilter'][aFName[0]][aFName[1]] = v.value;
                         break;
                     }
                  });
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){
                  
                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
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
              var c0 = "<a href=\" "+base_url+"/items/edit_category/"+data.id+" \" class=\"storeColor\">"+data.category_name+"</a>";
              // var c1 = data.description;
              var c1 = data.prefix;
              var c5 = '<span class="fa fa-angle-right" data-toggle="collapse" data-target="#cat'+dataIndex+'" data-id="'+data.id+'" class="accordion-toggle"></span>';


              var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }
              var c2 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"categories\"><i class=\"fa fa-trash-o\"></i></a>";
              $(row).children().eq(0).addClass(statusBorder).html(c0);
              $(row).children().eq(1).html(c1);
              // $(row).children().eq(2).html(c2);
              $(row).children().eq(2).html(c2);
            }
          });
        
        $('#category-table').on('click', '.exploder', function (e) {
           var tr = $(this).closest('tr');
           var row = $('#category-table').DataTable().row( tr );
           e.preventDefault();
           $(this).toggleClass("fa-angle-right fa-angle-up");
          
          var id = $(this).attr('data-id');
           $.ajax({
              type: "POST",
              url: base_url + '/items/getSubcategoryDataById',
              data: {
                 id: id,
                },
              dataType: "json",
              encode: true,
           }).done(function (data) {
            if(data.status == "true"){


             if (row.child.isShown()) {
               // This row is already open - close it.
                  row.child.hide();
                  tr.removeClass('shown');
               } else {
               // Open row.
                var c6 = '';
                 c6 += '<table class="table DataTable table-striped table-bordered">';
                 c6 += '<thead>';
                 c6 += '<tr>';
                 c6 += '<th>Subcategory Name</th>';
                 // c6 += '<th>Description</th>';
                 c6 += '</tr>';
                 c6 += '</thead>';
                 c6 += '<tbody>';
                  $.each(data.data,function(k,v){
                 c6 += '<tr>';
                 c6 += '<td>'+v.subcategory_name+'</td>';
                 // c6 += '<td>'+v.description+'</td>';
                 c6 += '</tr>';
                  });
                 c6 += '</tbody>';
                 c6 += '</table>';
                
                 row.child(c6).show();
                tr.addClass('shown');
                }
            }else{
                 alertMessage(data.status,data.message);
           }
        });
        });

        $(document).on("click", "#subcategorySubmit", function(e){
          e.preventDefault();
          scategoryTbl.draw();
        });
        var scategoryTbl = $('#subcategory-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-4 colDt'><'col-sm-4'i><'col-sm-4'p>>",
            'ajax': {
               'url':"<?=base_url('items/getSubcategory')?>",
               'data': function(data){
                var obj = $("form.filterSubCategory").serializeArray();
                data['advFilter'] = {};
                   $.each(obj, function(k, v){
                     var aFName = v.name.replaceAll("]", "").split("[");;
                     switch(aFName.length){
                       case 1:
                         data['advFilter'][aFName[0]] = v.value;
                         break;
                       case 2:
                         if(data['advFilter'][aFName[0]] == undefined){
                           data['advFilter'][aFName[0]] = {};
                         }
                         data['advFilter'][aFName[0]][aFName[1]] = v.value;
                         break;
                     }
                  });
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){

                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
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
              var c0 = "<a href=\" "+base_url+"/items/edit_subcategory/"+data.id+" \" class=\"storeColor\">"+data.subcategory_name+"</a>";

              var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }
              var c1 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"subcategories\"><i class=\"fa fa-trash-o\"></i></a>";
              $(row).children().eq(0).addClass(statusBorder).html(c0);
              $(row).children().eq(1).html(c1);
            }
        });

        $(document).on("click", "#deptSubmit", function(e){
          e.preventDefault();
          deptTbl.draw();
        });
        var deptTbl = $('#dept-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-4 colDt'><'col-sm-4'i><'col-sm-4'p>>",
            'ajax': {
               'url':"<?=base_url('items/getDepartment')?>",
               'data': function(data){
                var obj = $("form.filterDept").serializeArray();
                data['advFilter'] = {};
                   $.each(obj, function(k, v){
                     var aFName = v.name.replaceAll("]", "").split("[");;
                     switch(aFName.length){
                       case 1:
                         data['advFilter'][aFName[0]] = v.value;
                         break;
                       case 2:
                         if(data['advFilter'][aFName[0]] == undefined){
                           data['advFilter'][aFName[0]] = {};
                         }
                         data['advFilter'][aFName[0]][aFName[1]] = v.value;
                         break;
                     }
                  });
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){

                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
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
              var c0 = "<a href=\" "+base_url+"/items/edit_department/"+data.id+" \" class=\"storeColor\">"+data.department_name+"</a>";

              var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }
              var c1 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"department\"><i class=\"fa fa-trash-o\"></i></a>";
              $(row).children().eq(0).addClass(statusBorder).html(c0);
              $(row).children().eq(1).html(c1);
            }
        });
       
        /*Category Start*/
        
        /*Recipe Start*/
        $(document).on("click", "#recipeSubmit", function(e){
              e.preventDefault();
              recipeTbl.draw();
          });
        var recipeTbl = $('#recipe-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=base_url('items/getRecipe')?>",
               'data': function(data){
                var obj = $("form.filterRecipe").serializeArray();
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){
                  
                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
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
              
              var c0 = "<a href=\" "+base_url+"/items/edit_recipe/"+data.id+" \" class=\"storeColor\">"+data.item_name+"</a>";;
               var c1 = data.total_items;
               var c2 = data.total;
              var c5 = '<span class="exploder fa fa-angle-right" data-toggle="collapse" data-target="#cat'+dataIndex+'" data-id="'+data.id+'" class="accordion-toggle"></span>';

              var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }
              var c3 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"recipes_master\"><i class=\"fa fa-trash-o\"></i></a>";
              $(row).children().eq(0).addClass(statusBorder).html(c5+ ' ' +c0);
               $(row).children().eq(1).html(c1);
               $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
            }
          });

          $('#recipe-table').on('click', '.exploder', function (e) {
           var tr = $(this).closest('tr');
           var row = $('#recipe-table').DataTable().row( tr );
           e.preventDefault();
           $(this).toggleClass("fa-angle-right fa-angle-up");
          
          var id = $(this).attr('data-id');
           $.ajax({
              type: "POST",
              url: base_url + '/items/getRecipeItemsDataById',
              data: {
                 id: id,
                },
              dataType: "json",
              encode: true,
           }).done(function (data) {
           
            if(data.status == "true"){
             if (row.child.isShown()) {
               // This row is already open - close it.
                  row.child.hide();
                  tr.removeClass('shown');
               } else {
               // Open row.
                var c6 = '';
                 c6 += '<table class="table DataTable table-striped table-bordered">';
                 c6 += '<thead>';
                 c6 += '<tr>';
                 c6 += '<th>Item Name</th>';
                 c6 += '<th>Unit</th>';
                 c6 += '<th>Cost</th>';
                 c6 += '</tr>';
                 c6 += '</thead>';
                 c6 += '<tbody>';
                  $.each(data.data,function(k,v){
                 c6 += '<tr>';
                 c6 += '<td>'+v.item_name+'</td>';
                 c6 += '<td>'+v.unit+'</td>';
                 c6 += '<td>'+v.cost+'</td>';
                 c6 += '</tr>';
                  });
                 c6 += '</tbody>';
                 c6 += '</table>';
                
                 row.child(c6).show();
                tr.addClass('shown');
                }
            }else{
                 alertMessage(data.status,data.message);
           }
        });
        });

         /*Recipe End*/
         
        /*Terminal Start*/  
         $(document).on("click", "#terminalbtn", function(e){
              e.preventDefault();
              terminalTbl.draw();
          });
        var terminalTbl = $('#terminal-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=base_url('settings/getTerminal')?>",
               'data': function(data){
                var obj = $("form.filterTerminal").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){
                  
                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
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
              var c0 = "<a href=\" "+base_url+"/settings/edit_terminal/"+data.id+" \" class=\"storeColor\">"+data.terminal_name+"</a>";;
              var c1 = data.store_name;
              var c2 = data.type;
              var c3 = data.sales_invoice_starting_no;
              var c4 = data.sales_return_starting_no;

              var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }
              var c5 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"terminals\"><i class=\"fa fa-trash-o\"></i></a>";
              $(row).children().eq(0).addClass(statusBorder).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);
              $(row).children().eq(5).html(c5);
                          
                          
            }
          });
          /*Terminal End*/  

        /*Employee Start*/
        var employeeTbl = $('#employee-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=base_url('settings/getEmployee')?>",
               'data': function(data){
                var obj = $("form.filterEmployee").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){
                  
                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
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
              var c0 = data.profile;
              var c1 = "<a href=\" "+base_url+"/settings/edit_employee/"+data.id+" \" class=\"storeColor\">"+data.first_name+"</a>";;
              var c2 = data.role_name;
              var c3 = data.primary_email;
              var c4 = data.phone;
              var c5 = data.address;

              var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }
              var c6 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"employees\"><i class=\"fa fa-trash-o\"></i></a>";
              $(row).children().eq(0).addClass(statusBorder).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);
              $(row).children().eq(5).html(c5);
              $(row).children().eq(6).html(c6);
                          
                          
            }
        });

        $(document).on("click", "#employeebtn", function(e){
              e.preventDefault();
              employeeTbl.draw();
        });
        
        /*Employee End*/

        /*Role Start*/
        var roleTbl = $('#role-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=base_url('settings/getRole')?>",
               'data': function(data){
                var obj = $("form.filterRole").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){
                  
                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
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
              var c0 = "<a href=\" "+base_url+"/settings/edit_role/"+data.id+" \" class=\"storeColor\">"+data.role_name+"</a>";

              var c1 = data.description;

              var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }
              var c2 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"role\"><i class=\"fa fa-trash-o\"></i></a>";
              if(data.is_admin == "1") {
                c0 = "<span class=\"storeColor is_admin_role\" style=\"cursor:pointer;\">"+data.role_name+"</span>";
                c2 = "";
              }
              $(row).children().eq(0).addClass(statusBorder).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
                          
            }
        });
         $(document).on("click", "#rolebtn", function(e){
              e.preventDefault();
              roleTbl.draw();
          });
       /*Role End*/

       /*Currency Start*/  

        var currencyTbl = $('#currency-table').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=base_url('settings/getCurrency')?>",
               'data': function(data){
                var obj = $("form.filterCurrency").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                  return {
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                  };
               },
               dataSrc: function(data){
                  
                  // Update token hash
                  $('.txt_csrfname').val(data.token);

                  // Datatable data
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
              var c0 = "<a href=\" "+base_url+"/settings/edit_currency/"+data.id+" \" class=\"storeColor\">"+data.currency_name+"</a>";
              var c1 = data.currency_symbol;
              var c2 = data.exchange_rate;
              var c3 = data.exchange_date;

              var statusBorder = "active-border";
              if(data.status == 0) {
                 statusBorder = "inactive-border";
              }
              var c4 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"currencies\"><i class=\"fa fa-trash-o\"></i></a>";
              if(data.is_base_currency) {
                c2 = "";
                c3 = "";
                c4 = "";
              }
              $(row).children().eq(0).addClass(statusBorder).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);          
            }
          });

          $(document).on("click", "#currencybtn", function(e){
              e.preventDefault();
              currencyTbl.draw();
          });
       /*Currency End*/

       /*----------Setting Menu End----------*/

      /*Inventory Start*/
    var curruntStockTbl = $('#currentStockTbl').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'sPagingType': 'simple',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=site_url('inventory/getCurrentStock')?>",
               'data': function(data){
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                  var obj = $("form.filterCurrentSTock").serializeArray();

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
                     search: $('.psearchDtField').val(),
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
              var c0 = parseFloat(dataIndex) + parseFloat(1);
              var c1 = data.store_name;
              var c2 = data.location_type;
              var c3 = data.item_code;
              var c4 = data.item_name;
              var c5 = data.barcode;
              var c6 = data.unit;
              var c7 = data.current_inventory;
              var c8 = data.cost_price;
              var c9 = data.inventory_amount;
              var c10 = '-';
              var c11 = "<a href=\"javascript:void(0);\" class=\"edit-inventory\" data-id=\""+data.id+"\"><i class=\"fa fa-pencil\"></i></a>";
              
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
                               
            }
        });
     $('.currentStockBtn').click(function(e){
           e.preventDefault();
           curruntStockTbl.draw();
      })
    var transferStockTbl = $('#transferStockTbl').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'sPagingType': 'simple',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=site_url('inventory/getTransferStock')?>",
               'data': function(data){
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                  var obj = $("form.filterTransferStock").serializeArray();
                  
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
                     search: $('.psearchDtField').val(),
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
              var c0 = data.id;
              var c1 = data.supply_store;
              var c2 = data.receiver_store;
              var c3 = data.quantity;
              var c4 = data.date;
              // var c5 = data.amount;
              var c5 = displayStatus('transfer',data.status);
              var c6 = "";
              if(data.status == 0 || data.status == 2){
                c0 = "<a href=\" "+base_url+"/inventory/edit_transfer/"+data.id+" \" class=\"storeColor\">TO-000"+data.id+"</a>"
                c6 = "<a href=\"#\" data-id=\""+data.id+ "\" data-table=\"transfer\" class=\"transh-icon-color deleteRow\"><i class=\"fa fa-trash-o\"></i></a>";
              }else{
                c0 = "<a href=\" "+base_url+"/inventory/transfer_view/"+data.id+" \" class=\"storeColor\">TO-000"+data.id+"</a>";
              }
              $(row).children().eq(0).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);
              $(row).children().eq(5).html(c5);
              $(row).children().eq(6).html(c6);
              // $(row).children().eq(7).html(c7);
                                 
            }
        });
        $('.transferStockBtn').click(function(e){
           e.preventDefault();
           transferStockTbl.draw();
        })

        var productionTbl = $('#productionTbl').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'sPagingType': 'simple',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-4 colDtbl'><'col-sm-4'i><'col-sm-4'p>>",
            'ajax': {
               'url':"<?=site_url('inventory/getProductionStock')?>",
               'data': function(data){
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                  var obj = $("form.filterProdStock").serializeArray();

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
                     search: $('.psearchDtField').val(),
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
              var c0 = data.id;
              var c1 = data.date;
              var c2 = data.item_name;
              var c3 = data.quantity;
              var c4 = data.store_name;

              $(row).children().eq(0).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);
            }
    });
       
     var getStockAdjustmentTbl = $('#adjustmentStockTbl').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'sPagingType': 'simple',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=site_url('inventory/getStockAdjustment')?>",
               'data': function(data){
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                  var obj = $("form.filterAdjustmentStock").serializeArray();

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
                     search: $('.psearchDtField').val(),
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
              
              var c0 = data.id;
              var c1 = data.reason;
              var c2 = data.store_name;
              var c3 = data.narration;
              var c4 = data.date;
              //var c5 = displayStatus('transfer',data.status);
             /* var c5 = "<a href=\" "+base_url+"/inventory/edit_stock_adjustment/"+data.id+" \"><i class=\"fa fa-pencil\"></i></a> &nbsp;&nbsp;&nbsp; <a data-id=\""+data.id+"\" data-table=\"stockadjusts\" href=\"#\" class=\"transh-icon-color item-delete\"><i class=\"fa fa-trash-o\"></i></a>";*/
               var c5 = "<a href=\" "+base_url+"/inventory/edit_stock_adjustment/"+data.id+" \"><i class=\"fa fa-eye\"></i></a>";
             var  explore = '<span class="exploder" data-toggle="collapse" data-id="'+data.id+'"  data-target="#demo'+dataIndex+'" class="accordion-toggle"><i class="fa fa-angle-right toggle-explore"></i></span>';
              $(row).children().eq(0).addClass(displayBorder('status',data.status)).html(explore  + " " + c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);
              $(row).children().eq(5).html(c5);
                                 
            }
        });
          $('#adjustmentStockTbl').on('click', '.exploder', function (e) {
           var tr = $(this).closest('tr');
          var row = $('#adjustmentStockTbl').DataTable().row( tr );
           e.preventDefault();
           $(this).toggleClass("fa-angle-right fa-angle-up");
          
          var id = $(this).attr('data-id');
           $.ajax({
              type: "POST",
              url: base_url + '/inventory/getAdjustmentDataById',
              data: {
                 id: id,
                },
              dataType: "json",
              encode: true,
           }).done(function (data) {
           
            if(data.status == "true"){


             if (row.child.isShown()) {
               // This row is already open - close it.
                  row.child.hide();
                  tr.removeClass('shown');
               } else {
               // Open row.
               var total_qty = total_cost = 0;

               
                var c6 = '';
                 c6 += '<table class="table DataTable table-striped table-bordered">';
                 c6 += '<thead>';
                 c6 += '<tr>';
                 c6 += '<th>Unit</th>';
                 c6 += '<th>Item Name</th>';
                 c6 += '<th>Quantity</th>';
                 c6 += '<th>Cost</th>';
                 c6 += '</tr>';
                 c6 += '</thead>';
                 c6 += '<tbody>';
                  $.each(data.data,function(k,v){
                    total_qty += parseFloat(v.quantity);
                    total_cost += parseFloat(v.cost);
                   
                 c6 += '<tr>';
                 c6 += '<td>'+v.id+'</td>';
                 c6 += '<td>'+v.item_name+'</td>';
                 c6 += '<td class="sub_item">'+v.quantity+'</td>';
                 c6 += '<td class="sub_cost">'+v.cost+'</td>';
                 c6 += '</tr>';
                  });
                 c6 += '</tbody>';
                 c6 += '</table>';
                 c6 += '<div class="row">';
                 c6 += '<div class="col-md-6"></div>';
                 c6 += '<div class="col-md-6"><span style="padding-left: 70px;">Total : $'+total_qty+'</span><span style="float: right;padding-right: 105px;">Total : $'+total_cost+'</span></div>';
                 c6 += '</div>';
                 c6 += '</table>';
                
                
              row.child(c6).show();
             tr.addClass('shown');
             }
            }else{
                 alertMessage(data.status,data.message);
              }
        });
        });
         $('.adjustStockBtn').click(function(e){
           e.preventDefault();
           getStockAdjustmentTbl.draw();
        })

        var getReasonTbl = $('#adjustmentReasonTbl').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'sPagingType': 'simple',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-4 colDtbl'><'col-sm-4'i><'col-sm-4'p>>",
            'ajax': {
               'url':"<?=site_url('inventory/getStockAdjustmentReason')?>",
               'data': function(data){
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                  var obj = $("form.filterAdjustmentReason").serializeArray();

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
                     search: $('.psearchDtField').val(),
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

              var c0 = data.id;
              var c1 = "<a href=\"javascript:void(0);\" class=\"storeColor addReason\" data-act=\"edit\" data-id=\""+data.id+"\" data-val=\""+data.reason+"\">"+data.reason+"</a>";
              var c2 = data.status == 1 ? '<span class="td-approved">Active</span>' : '<span class="StoreColor">Deactive</span>';

              var c3 = "<a href=\"javascript:void(0);\" data-id=\""+data.id+"\" data-table=\"stock_adjustments_reason\" href=\"#\" class=\"transh-icon-color item-delete\"><i class=\"fa fa-trash-o\"></i></a>";

              $(row).children().eq(0).addClass(displayBorder('status',data.status)).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);

            }
        });
        $('.adjustReasonBtn').click(function(e){
           e.preventDefault();
           getReasonTbl.draw();
        })

      var movementStockTbl = $('#movementStockTbl').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'sPagingType': 'simple',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=site_url('inventory/getStockMovement')?>",
               'data': function(data){
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                  var obj = $("form.filterMovementStock").serializeArray();
                  
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
                     search: $('.psearchDtField').val(),
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
              var c1 = data.location_type;
              var c2 = data.date;
              var c3 = data.item_name;
              var c4 = data.open_qty;
              var c5 = data.open_value;
              var c6 = data.received_qty;
              var c7 = data.received_value;
              var c8 = data.sold_qty;
              var c9 = data.sold_value;
              var c10 = data.adjustment_qty;
              var c11 = data.adjustment_value;
              var c12 = data.transfer_qty;
              var c13 = data.transfer_value;
              var c14 = data.production_qty;
              var c15 = data.production_value;
              var c16 = data.close_qty;
              var c17 = data.close_value;

              //var c5 = displayStatus('transfer',data.status);
              var c18 = "<a href=\" "+base_url+"/inventory/edit_transfer/"+data.id+" \"><i class=\"fa fa-pencil\"></i></a> &nbsp;&nbsp;&nbsp; <a data-id=\""+data.id+"\" data-table=\"transfer\" href=\"#\" class=\"transh-icon-color item-delete\"><i class=\"fa fa-trash-o\"></i></a>";
              
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
              $(row).children().eq(15).html(c15);
              $(row).children().eq(16).html(c16);
              $(row).children().eq(17).html(c17);
              $(row).children().eq(18).html(c18);
                                 
            }
        });
       $('.movementStockBtn').click(function(e){
           e.preventDefault();
           movementStockTbl.draw();
        })
        $('.clearMovementBtn').click(function(e){
           e.preventDefault();
           $('.filterMovementStock')[0].reset();
           movementStockTbl.draw();
        })

      var sellStockTbl = $('#sellStockTbl').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'sPagingType': 'simple',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=site_url('sales/getStockSell')?>",
               'data': function(data){
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                  var obj = $("form.filterSellStock").serializeArray();
                  
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
                     search: $('.psearchDtField').val(),
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
             
              var c0 = data.date;
              var c1 = "<span class=\"storeColor view-module invoice-id-"+data.id+"\" data-id=\""+data.id+"\" data-tab=\"invoice\">INV-000"+data.id+"</span>";
              if(data.invoice_type == "2") {
                c1 = "<span class=\"storeColor view-module invoice-id-"+data.id+"\" data-id=\""+data.id+"\" data-tab=\"invoice\">CDN-000"+data.id+"</span>"
              }
              var c2 = data.order_number;
              var c3 = data.customer_name;
              var c4 = data.status;
              var c5 = data.due_date;
              var c6 = currency+data.total_amount;
              var c7 = currency+data.balance_due;
              
              var c8 = "<a data-id=\""+data.id+"\" data-table=\"sell_orders\" href=\"#\" class=\"transh-icon-color item-delete\"><i class=\"fa fa-trash-o\"></i></a>";
              
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
       $('.sellStockBtn').click(function(e){
           e.preventDefault();
           sellStockTbl.draw();
        })
      
  /*Inventory End*/ 

  /*Sales Start*/
    var quoteTbl = $('#quote-tbl').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'sPagingType': 'simple',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=site_url('sales/getQuotes')?>",
               'data': function(data){
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                  var obj = $("form.filterPaymentSellStock").serializeArray();
                  
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
                     search: $('.psearchDtField').val(),
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
             
              var c0 = data.id;
              var c1 = "<span class=\"storeColor view-module quote-id-"+data.id+"\" data-id=\""+data.id+"\" data-tab=\"quote\">"+data.quote_number+"</span>";
              var c2 = data.customer_name;
              var c3 = data.date;
              var c4 = data.due_date;
              var c5 = currency+data.total_amount;
              
              var c6 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"quotes\"><i class=\"fa fa-trash-o\"></i></a>";
              
              $(row).children().eq(0).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);
              $(row).children().eq(5).html(c5);
              $(row).children().eq(6).html(c6);
                              
            }
        });
       $('.quoteBtn').click(function(e){
           e.preventDefault();
           quoteTbl.draw();
        })
    var creditNoteTbl = $('#creditNoteTbl').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'sPagingType': 'simple',
            dom: "<'row'<'col-sm-12'tr>>" +
            "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
            'ajax': {
               'url':"<?=site_url('sales/getCreditNotes')?>",
               'data': function(data){
                  // CSRF Hash
                  var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                  var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                  var obj = $("form.filterPaymentSellStock").serializeArray();
                  
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
                     search: $('.psearchDtField').val(),
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
             
              var c0 = data.date;
              var c1 = "<span class=\"storeColor view-cn credit-id-"+data.id+"\" data-id=\""+data.id+"\" data-tab=\"credit\">CN-000"+data.credit_note+"</span>";
              var c2 = data.customer_name;
              var c3 = 'INV-000'+data.invoice;
              var c4 = currency+data.total_amount;
              var c5 = currency+data.balance;
              //var c5 = displayStatus('transfer',data.status);
              // var c8 = "<a href=\" "+base_url+"/sales/edit_invoice/"+data.id+"?type=1 \"><i class=\"fa fa-pencil\"></i></a> &nbsp;&nbsp;&nbsp; <a data-id=\""+data.id+"\" data-table=\"sell_orders\" href=\"#\" class=\"transh-icon-color item-delete\"><i class=\"fa fa-trash-o\"></i></a>";
              
              $(row).children().eq(0).html(c0);
              $(row).children().eq(1).html(c1);
              $(row).children().eq(2).html(c2);
              $(row).children().eq(3).html(c3);
              $(row).children().eq(4).html(c4);
              $(row).children().eq(5).html(c5);
                              
            }
        });
       $('.crNoteBtn').click(function(e){
           e.preventDefault();
           creditNoteTbl.draw();
        })
      /*Sales End*/

    var laybyContractTbl = $('#layby-contract-dt').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        dom: "<'row'<'col-sm-12'tr>>" +
        "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
        'ajax': {
            'url':"<?=site_url('layby/getLaybyContract')?>",
            'data': function(data){
                var obj = $("form.filterLaybyContract").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                  // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var obj = $("form.filterLaybyContract").serializeArray();

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
          var c0 = dataIndex+1;
          var c1 = "<a href=\" "+base_url+"/layby/edit_contract/"+data.id+" \" class=\"storeColor\">LAY-000"+data.id+"</a>";
          var c2 = data.registerd_name;
          var cnCode = '';
          if(data.country_code !== null) {
            cnCode = '('+data.country_code+')'+' ';
          }
          var c3 = cnCode+data.phone;
          var c4 = data.address;
          var c5 = data.currency+data.balance;
          var c6 = data.currency+data.total_amount;
          var ex = '';
          if(data.deposit_count > 0) {
            ex = '<span class="exploder fa fa-angle-right" data-toggle="collapse" data-act=\"contract\" data-target="#cat'+dataIndex+'" data-id="'+data.id+'" class="accordion-toggle"></span>'
          }
          var statusBorder = "active-border";
          if(data.status == 0) {
             statusBorder = "inactive-border";
          }
          var c7 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"customers\"><i class=\"fa fa-trash-o\"></i></a>";
          $(row).children().eq(0).addClass(statusBorder).html(c0);
          $(row).children().eq(1).html(c1);
          $(row).children().eq(2).html(c2);
          $(row).children().eq(3).html(c3);
          $(row).children().eq(4).html(c4);
          $(row).children().eq(5).html(c5);
          $(row).children().eq(6).html(c6);  
          $(row).children().eq(7).html(c7);            
        }
    });

    $('#layby-contract-dt, #layby-payment-dt').on('click', '.exploder', function (e) {
      var tr = $(this).closest('tr');
      var act = $(this).attr('data-act');

      var row = $('#layby-contract-dt').DataTable().row( tr );
      if(act == "payment") {
        row = $('#layby-payment-dt').DataTable().row( tr );
      }
      e.preventDefault();
      $(this).toggleClass("fa-angle-right fa-angle-up");
          
      var id = $(this).attr('data-id');
      $.ajax({
        type: "POST",
        url: base_url + '/layby/getContractDepositData',
        data: {
          id: id,
        },
        dataType: "json",
        encode: true,
      }).done(function (data) {
        if(data.status == "true"){

          if (row.child.isShown()) {
              row.child.hide();
              tr.removeClass('shown');
          } else {
              var c6 = '';
              var payBtn = '';
              if(data.remaining_amt > 0 && act == "contract") {
                payBtn = '<button class="btn btn-lb-white add-payment show-layby-details" data-type="p" data-id='+data.contractData.id+'>Pay Now</button>';
              }
              c6 += '<table class="depositTbl table DataTable table-striped table-bordered">';
              c6 += '<thead>';
              c6 += '<tr>';
              c6 += '<th>S/N</th>';
              c6 += '<th>Date</th>';
              c6 += '<th>Deposit</th>';
              c6 += '</tr>';
              c6 += '</thead>';
              c6 += '<tbody>';
              var i = 1;
              $.each(data.data,function(k,v){
                c6 += '<tr>';
                c6 += '<td>'+i+'</td>';
                c6 += '<td>'+v.date+'</td>';
                c6 += '<td>'+v.amount+'</td>';
                c6 += '</tr>';
                i++;
              });
              c6 += '</tbody>';
              c6 += '</table>';
              c6 += '<div class="row">'+
                    '<div class="col-md-6 text-center">Total Deposit: <b>'+data.total_deposit+'</b></div>'+
                    '<div class="col-md-6 text-right" style="margin-top: -5px;">'+
                    'Remaining Amount: <b>'+data.remaining_amt+'</b> &nbsp;&nbsp;'+
                    payBtn+
                    '</div>'+
                    '</div>';
              row.child(c6).show();
              tr.addClass('shown');
          }

        }
      });
    });

    var laybyPaymentTbl = $('#layby-payment-dt').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        dom: "<'row'<'col-sm-12'tr>>" +
        "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
        'ajax': {
            'url':"<?=site_url('layby/getLaybyContractPayment')?>",
            'data': function(data){
                var obj = $("form.filterLaybyContract").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                  // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var obj = $("form.filterLaybyPayment").serializeArray();

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

          var c0 = dataIndex+1;
          var c1 = 'LAY-000'+data.id;
          var c2 = data.registerd_name;
          var cnCode = '';
          if(data.country_code !== null) {
            cnCode = '('+data.country_code+')'+' ';
          }
          var c3 = cnCode+data.phone;
          var c4 = data.address;
          var dt = new Date(data.created_at);
          var c5 = ("0" + dt.getDate()).slice(-2)+' '+dt.toLocaleString('en-US', {month: 'short'})+', '+dt.getFullYear();
          var c6 = data.currency+data.balance;
          var ex = '';
          if(data.deposit_count > 0) {
            ex = '<span class="exploder fa fa-angle-right" data-act=\"payment\" data-toggle="collapse" data-target="#cat'+dataIndex+'" data-id="'+data.id+'" class="accordion-toggle"></span>'
          }
          var c7 = "<button class=\"btn btn-lb-white add-payment show-layby-details\" data-type=\"p\" data-id=\""+data.id+"\">Pay</button>";
          $(row).children().eq(0).html(ex+' '+c0);
          $(row).children().eq(1).html(c1);
          $(row).children().eq(2).html(c2);
          $(row).children().eq(3).html(c3);
          $(row).children().eq(4).html(c4);
          $(row).children().eq(5).html(c5);
          $(row).children().eq(6).html(c6);
          $(row).children().eq(7).html(c7);             
        }
    });

    var laybyRefundTbl = $('#layby-refund-dt').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        dom: "<'row'<'col-sm-12'tr>>" +
        "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
        'ajax': {
            'url':"<?=site_url('layby/getLaybyContractTxn')?>",
            'data': function(data){
                var obj = $("form.filterLaybyContract").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                data["advFilter"]['tab'] = 'refund';
                  // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var obj = $("form.filterLaybyPayment").serializeArray();

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

          var c0 = dataIndex+1;
          var c1 = 'LAY-000'+data.id;
          var c2 = data.registerd_name;
          var cnCode = '';
          if(data.country_code !== null) {
            cnCode = '('+data.country_code+')'+' ';
          }
          var c3 = cnCode+data.phone;
          var dt = new Date(data.created_at);
          var c4 = ("0" + dt.getDate()).slice(-2)+' '+dt.toLocaleString('en-US', {month: 'short'})+', '+dt.getFullYear();
          var c5 = data.is_cancel == 1 ? 'Yes' : 'No';
          var c6 = '-';
          var c7 = data.address;
          var c8 = '-';
          var c9 = data.currency+data.total_amount;
          var c10 = data.currency+data.balance;
          var c_status = '-';
          if(data.contract_status == 4) {
            c_status = "Refunded";
          }
          var c12 = "<button class=\"btn btn-lb-white show-layby-details\" data-type=\"r\" data-id=\""+data.id+"\">Refund</button>";
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
          $(row).children().eq(11).html('<span class="storeColor">'+c_status+'</span>');            
          $(row).children().eq(12).html(c12);             
        }
    });

    var laybyCancelTbl = $('#layby-cancel-dt').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        dom: "<'row'<'col-sm-12'tr>>" +
        "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
        'ajax': {
            'url':"<?=site_url('layby/getLaybyContractTxn')?>",
            'data': function(data){
                var obj = $("form.filterLaybyContract").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                data["advFilter"]['tab'] = 'cancel';
                  // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var obj = $("form.filterLaybyPayment").serializeArray();

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

          var c0 = dataIndex+1;
          var c1 = 'LAY-000'+data.id;
          var c2 = data.registerd_name;
          var cnCode = '';
          if(data.country_code !== null) {
            cnCode = '('+data.country_code+')'+' ';
          }
          var c3 = cnCode+data.phone;
          var dt = new Date(data.created_at);
          var c4 = ("0" + dt.getDate()).slice(-2)+' '+dt.toLocaleString('en-US', {month: 'short'})+', '+dt.getFullYear();
          var c5 = data.is_cancel == 1 ? 'Yes' : 'No';
          var c6 = '-';
          var c7 = data.address;
          var c8 = '-';
          var c9 = data.currency+data.total_amount;
          var c10 = data.currency+data.balance;
          var c11 = "<button class=\"btn btn-lb-white show-layby-details\" data-type=\"c\" data-id=\""+data.id+"\">Cancel</button>";
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
        }
    });

    var laybyCancelRefundTbl = $('#layby-cancel-refund').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        dom: "<'row'<'col-sm-12'tr>>" +
        "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
        'ajax': {
            'url':"<?=site_url('layby/getLaybyContractTxn')?>",
            'data': function(data){
                var obj = $("form.filterLaybyContract").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                data["advFilter"]['tab'] = 'cancel_refund';
                  // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var obj = $("form.filterLaybyPayment").serializeArray();

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

          var c0 = dataIndex+1;
          var c1 = 'LAY-000'+data.id;
          var c2 = data.registerd_name;
          var cnCode = '';
          if(data.country_code !== null) {
            cnCode = '('+data.country_code+')'+' ';
          }
          var c3 = cnCode+data.phone;
          var dt = new Date(data.created_at);
          var c4 = ("0" + dt.getDate()).slice(-2)+' '+dt.toLocaleString('en-US', {month: 'short'})+', '+dt.getFullYear();
          var c5 = data.is_cancel == 1 ? 'Yes' : 'No';
          var c6 = '-';
          var c7 = data.address;
          var c8 = '-';
          var c9 = data.currency+data.total_amount;
          var c10 = data.currency+data.balance;
          var c11 = "<button class=\"btn btn-lb-white add-payment show-layby-details\" data-type=\"cr\" data-id=\""+data.id+"\">Cancel</button>";
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
        }
    });

    var laybyCompletedTbl = $('#layby-completed-dt').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        dom: "<'row'<'col-sm-12'tr>>" +
        "<'row rowDt'<'col-sm-6 colDt'><'col-sm-4'i><'col-sm-2'p>>",
        'ajax': {
            'url':"<?=site_url('layby/getCompletedLaybyContract')?>",
            'data': function(data){
                var obj = $("form.filterLaybyCompleted").serializeArray();
                
                data["advFilter"] = {};
                $.each(obj, function(k, v){
                  var aFName = v.name.replaceAll("]", "").split("[");;
                  switch(aFName.length){
                    case 1:
                      data["advFilter"][aFName[0]] = v.value;
                      break;
                    case 2:
                      if(data["advFilter"][aFName[0]] == undefined){
                        data["advFilter"][aFName[0]] = {};
                      }
                      data["advFilter"][aFName[0]][aFName[1]] = v.value;
                      break;
                  }
                });
                  // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var obj = $("form.filterLaybyCompleted").serializeArray();

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
          var c0 = dataIndex+1;
          var c1 = 'LAY-000'+data.id;
          var c2 = data.registerd_name;
          var cnCode = '';
          if(data.country_code !== null) {
            cnCode = '('+data.country_code+')'+' ';
          }
          var c3 = cnCode+data.phone;
          var c4 = data.address;
          var c5 = data.currency+data.balance;
          var ex = '';
          if(data.deposit_count > 0) {
            ex = '<span class="exploder fa fa-angle-right" data-toggle="collapse" data-act=\"contract\" data-target="#cat'+dataIndex+'" data-id="'+data.id+'" class="accordion-toggle"></span>'
          }
          var statusBorder = "active-border";
          if(data.status == 0) {
             statusBorder = "inactive-border";
          }
          var c6 = "<a href=\" "+base_url+"/layby/edit_contract/"+data.id+" \"><i class=\"fa fa-pencil\"></i></a> &nbsp;&nbsp;&nbsp; <a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"customers\"><i class=\"fa fa-trash-o\"></i></a>";
          $(row).children().eq(0).addClass(statusBorder).html(ex+' '+c0);
          $(row).children().eq(1).html(c1);
          $(row).children().eq(2).html(c2);
          $(row).children().eq(3).html(c3);
          $(row).children().eq(4).html(c4);
          $(row).children().eq(5).html(c5);
          $(row).children().eq(6).html(c6);              
        }
    });
  })
  </script>