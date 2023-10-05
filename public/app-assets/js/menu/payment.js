 $(document).ready(function(){
                  $(document).on('click','.import-payments',function(e) { 
                     e.preventDefault();
                     $('#import-payments').modal('show')
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