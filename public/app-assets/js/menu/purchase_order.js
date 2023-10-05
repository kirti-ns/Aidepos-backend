 function addPurchaseOrderField (argument) {
    var table = document.getElementById("myTable");
    var t1=(table.rows.length);
    console.log(t1);  
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
      /*cell1.className='abc';
      cell2.className='abc';*/
      row.className = "new-row";
      /*row.setAttribute("onmousedown", "return false");*/
   $('td:eq(2)', row).attr('colspan', 2);
   cell0.className='text-center orderControl tableOrder';
   cell1.className='text-center';
   cell2.className='text-center';
   cell3.className='text-center';
   cell4.className='text-center';
   cell5.className='text-center'; 
   cell6.className='text-center';
   cell7.className='text-center';
   cell8.className='text-center';
   cell9.className='text-center';

   
     $('<span class="tabledit-span" >'+t1+'</span>').appendTo(cell0)
     $('<span class="tabledit-span" >..</span>').appendTo(cell1)
     $('<select class="form-control form-select "><option value="0">Click to select item</option><option value="1">AIDE-00001 Bakery and Bread</option><option value="1">AIDE-00002 Pasta and Rice</option></select>').appendTo(cell2);
     $('<select class="form-control form-select "><option value="0"></option><option value="1">1</option></select>').appendTo(cell3);
     $('<input class="form-control " type="text" name="Last" value=""  >').appendTo(cell4);
     $('<input class="form-control " type="text" name="Last" value=""  >').appendTo(cell5);
     $('<input class="discount form-control " type="number" name="Last" value=""  >&nbsp;<select class="form-control discount form-select"><option value="0">%</option><option value="1">ZMW</option></select>').appendTo(cell6);
     $('<select class="form-control form-select "><option value="0"></option><option value="1">1</option></select>').appendTo(cell7);
     $('<input class="tabledit-input form-control " type="text" name="Last" value=""  >').appendTo(cell8);
     $('<a href=""><i class="fa fa-file-o"></i></a> &nbsp;&nbsp;&nbsp; <a href="" class=""><i class="fa fa-refresh"></i></a>&nbsp;&nbsp;&nbsp;<a href="" class="transh-icon-color"><i class="fa fa-trash-o"></i></a>').appendTo(cell9);
    
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
     $('<a href=""><i class="fa fa-file-o"></i></a> &nbsp;&nbsp;&nbsp; <a href="" class=""><i class="fa fa-refresh"></i></a>&nbsp;&nbsp;&nbsp;<a href="" class="transh-icon-color"><i class="fa fa-trash-o"></i></a>').appendTo(cell8);
    
}


