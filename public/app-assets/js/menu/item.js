"use strict";
function dragNdrop(event) {
    var fileName = URL.createObjectURL(event.target.files[0]);
   /* var preview = document.getElementById("preview");
    var previewImg = document.createElement("img");
    previewImg.setAttribute("src", fileName);
    preview.innerHTML = "";
    preview.appendChild(previewImg);*/
}
function drag() {
    document.getElementById('uploadFile').parentNode.className = 'draging dragBox';
}
function drop() {
    document.getElementById('uploadFile').parentNode.className = 'dragBox';
}

$(".toggle-explore").click(function(){
  
  $(this).toggleClass("fa-angle-right fa-angle-up");
    $(this).closest("tr").next("tr").toggleClass("explore-Row"); 
 
}); 

function addItemField(){
 var table = document.getElementById("myTable");
    var t1=(table.rows.length);
    var t = t1 - 1;
    console.log(t);
    var row = table.insertRow(t1);
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    // var cell4 = row.insertCell(4);
    
    row.className = "new-row";
    cell0.className='text-center ';
    cell3.className='text-center';
     // $('<span class="tabledit-span" >'+t1+'</span>').appendTo(cell0)
     $('<span class="tabledit-span" >..</span>').appendTo(cell0)
     $('<input class="tabledit-input form-control" type="text" name="sub['+t+'][subcategory_name]" id="sub['+t+']subcategory_name[]" value=""  >').appendTo(cell1);
     $('<input class="tabledit-input form-control" type="text" name="sub['+t+'][sub_description]" id="sub['+t+']sub_description[]" value=""  >').appendTo(cell2);
     $('<a href="#" class="transh-icon-color item-remove"><i class="fa fa-trash-o"></i></a>').appendTo(cell3);
    
}



