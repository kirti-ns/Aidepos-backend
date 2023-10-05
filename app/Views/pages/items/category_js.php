<script>
$(".toggle-explore").click(function(){
  $(this).toggleClass("fa-angle-right fa-angle-up");
    $(this).closest("tr").next("tr").toggleClass("explore-Row"); 
});   
function addCategoryField(){
 var table = document.getElementById("myTable");
    var t1=(table.rows.length);
    var t = t1 - 1;
    console.log(t);
    var row = table.insertRow(t1);
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    row.className = "new-row";
    cell0.className='text-center ';
    cell2.className='text-center';
     $('<span class="tabledit-span" >'+t1+'</span>').appendTo(cell0)
   
     $('<input class="tabledit-input form-control" type="text" name="sub['+t+'][subcategory_name]" id="sub['+t+']subcategory_name[]" value=""  >').appendTo(cell1);
     $('<a href="#" class="transh-icon-color item-remove"><i class="fa fa-trash-o"></i></a>').appendTo(cell2);
}
 </script>