var row=1;
function AddCategory(){
  var html = '<div class="pt-1 category_'+row+'" >';
  html += '<div class="form-floating">';
  html += '<input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="Food" >';
  html += '<label for="floatingInputGrid">Category</label>';
  html += '<a onclick="RemoveCategory('+row+')"><i class="fa fa-minus text-info"></i></a>';
  html += '</div>';
  $(".new_category").append(html);
  row++;
}
function RemoveCategory(id){

 $('.category_'+id).remove()

}
var row2=1;
function AddSubCategory(){
  var html = '<div class="pt-1 sub_category_'+row2+'">';
  html += '<div class="form-floating">';
  html += '<select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">';
  html += '<option selected>Grocery</option>';
  html += '<option value="1">One</option>';
  html += '<option value="2">Two</option>';
  html += '<option value="3">Three</option>';
  html += '</select>';
  html += '<label for="floatingSelectGrid">Sub Category*</label>';
  html += '<a onclick="RemoveSubCategory('+row2+')"><i class="fa fa-minus text-info"></i></a>';
  
  html += '</div>';
  $(".new_sub_category").append(html);
}
function RemoveSubCategory(id){

 $('.sub_category_'+id).remove()

}
var row3 = 1;
function AddNewUnit(){
  var html = '<div class="pt-1 unit_'+row3+'">';
  html += '<div class="form-floating">';
  html += '<input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="Food" >';
  html += '<label for="floatingInputGrid">Category</label>';
  html += '<a onclick="RemoveUnit('+row3+')"><i class="fa fa-minus text-info"></i></a>';
  html += '</div>';
  $(".new_unit").append(html);
} 
function RemoveUnit(id){

 $('.unit_'+id).remove()

}