/*$(document).ready(function(){
                  $(document).on('click','.add-payment',function(e) { 
                     e.preventDefault();
                     $('#add-payment').modal('show')
               })

                  $(document).on('click','.add-refunds',function(e) { 
                     e.preventDefault();
                     $('#add-refunds').modal('show')
                  })
                    $(document).on('click','.add-cancel',function(e) { 
                     e.preventDefault();
                     $('#add-cancel').modal('show')
                  })
                  $(document).on('click','.add-cancel_refund',function(e) { 
                     e.preventDefault();
                     $('#add-cancel_refund').modal('show')
                  })
                   $(document).on('click','.tender-media',function(e) { 
                     e.preventDefault();
                     $('#tender-media').modal('show')
                  })
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
   cell8.className='text-center';
     $('<span class="tabledit-span" >..</span>').appendTo(cell0)
     $('<select class="form-control form-select "><option value="0">Click to select item</option><option value="1">AIDE-00001 Bakery and Bread</option><option value="1">AIDE-00002 Pasta and Rice</option></select>').appendTo(cell1);
     $('<select class="form-control form-select "><option value="0"></option><option value="1">1</option></select>').appendTo(cell2);
     $('<input class="form-control " type="text" name="Last" value=""  >').appendTo(cell3);
     $('<input class="form-control " type="text" name="Last" value=""  >').appendTo(cell4);
     $('<input class="discount form-control " type="number" name="Last" value=""  >&nbsp;<select class="form-control discount form-select"><option value="0">%</option><option value="1">ZMW</option></select>').appendTo(cell5);
     $('<select class="form-control form-select "><option value="0"></option><option value="1">1</option></select>').appendTo(cell6);
     $('<input class="tabledit-input form-control " type="text" name="Last" value=""  >').appendTo(cell7);
     $('<a href=""><i class="fa fa-file-o"></i></a> &nbsp;&nbsp;&nbsp; <a href="" class=""><i class="fa fa-refresh"></i></a>&nbsp;&nbsp;&nbsp;<a href="" class="transh-icon-color"><i class="fa fa-trash-o"></i></a>').appendTo(cell8);
    
}
*/