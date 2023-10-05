 //Ruchika start
 $(".toggle-explore").click(function(){
  
  $(this).toggleClass("fa-angle-right fa-angle-up");
    $(this).closest("tr").next("tr").toggleClass("explore-Row"); 
 
}); 
  function addField (argument) {
    var table = document.getElementById("myTable");
    var t1=(table.rows.length);
    var row = table.insertRow(t1);
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    var cell4 = row.insertCell(4);
      row.className = "new-row";
   $('td:eq(0)', row).attr('colspan', 2);
   cell0.className='text-center';
   cell1.className='text-center';
   cell2.className='text-center';
   cell3.className='text-center';
   cell4.className='text-center';
     $('<span class="tabledit-span" ></span>').appendTo(cell0)
     $('<select class="form-control form-select "><option value="0">Click to select item</option><option value="1">AIDE-00001 Bakery and Bread</option><option value="1">AIDE-00002 Pasta and Rice</option></select>').appendTo(cell1);
     $('<input class="form-control " type="text" name="Last" value=""  >').appendTo(cell2);
     $('<input class="form-control " type="text" name="Last" value=""  >').appendTo(cell3);
     $('<a href=""><i class="fa fa-file-o" style="padding:10px;"></i></a> &nbsp;&nbsp;<a href="" class=""><i class="fa fa-refresh"></i></a>&nbsp;&nbsp;<a href="" class="transh-icon-color"><i class="fa fa-trash-o"></i></a>').appendTo(cell4);
    
}

 function addItem (argument) {
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
    var cell9 = row.insertCell(9);
      row.className = "new-row";
   $('td:eq(0)', row).attr('colspan', 2);
   cell0.className='text-center';
   cell1.className='text-center';
   cell2.className='text-center';
   cell3.className='text-center';
   cell4.className='text-center';
   cell5.className='text-center';
   cell6.className='text-center';
   cell7.className='text-center';
   cell8.className='text-center';
   cell9.className='text-center';
     $('<span class="tabledit-span" ></span>').appendTo(cell0)
     $('<select class="form-control form-select "><option value="0">Click to select item</option><option value="1">AIDE-00001 Bakery and Bread</option><option value="1">AIDE-00002 Pasta and Rice</option></select>').appendTo(cell1);
     $('<input class="form-control " type="text" name="Last" value=""  >').appendTo(cell2);
     $('<input class="form-control " type="text" name="Last" value=""  >').appendTo(cell3);
     $('<input class="form-control " type="text" name="Last" value=""  >').appendTo(cell4);
     $('<input class="form-control " type="text" name="Last" value=""  >').appendTo(cell5);
     $('<input class="form-control " type="text" name="Last" value=""  >').appendTo(cell6);
     $('<input class="form-control " type="text" name="Last" value=""  >').appendTo(cell7);
     $('<input class="form-control " type="text" name="Last" value=""  >').appendTo(cell8);
     $('<a href=""><i class="fa fa-file-o" style="padding:10px;"></i></a> &nbsp;&nbsp;<a href="" class=""><i class="fa fa-refresh"></i></a>&nbsp;&nbsp;<a href="" class="transh-icon-color"><i class="fa fa-trash-o"></i></a>').appendTo(cell9);
    
}

// Ruchika End
 $(document).ready(function(){
                  $(document).on('click','.edit-inventory',function(e) { 
                     e.preventDefault();
                     $('#inventory-modification').modal('show')
                  })
 })
