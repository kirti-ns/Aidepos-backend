 $(document).ready(function(){
                  $(document).on('click','.import-customers',function(e) { 
                     e.preventDefault();
                     $('#import-customers').modal('show')
                  })
$(document).on('click','.sendmail',function(e) { 
                     e.preventDefault();
                     $('#preview-statement').modal('show')
                  })
 })

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
$(document).on('change','#loyalty_system',function(e){
    e.preventDefault;
    var value = $(this).val();
    if(value == 2){
        $('.point_in_amount').hide();
    }else{
        $('.point_in_amount').show();
    }
})