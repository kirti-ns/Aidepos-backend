<script type = "text/javascript" >
   var base_url = "<?= base_url();?>";
function alertMessage(type, message) {
   if (type == 'false') {
      toastr.error(message, "Error", {
         closeButton: !0
      })
   } else if (type == "warning") {
      toastr.warning(message, "Warning", {
         closeButton: !0
      })
   } else if (type == "info") {
      toastr.info(message, "Info", {
         closeButton: !0
      })
   } else if (type == "true") {
      toastr.success(message, "Success", {
         closeButton: !0
      })
   }
}
//var table = $('#table_name').val();
//var URL = $('#action').val();
var DELETE_URL = base_url + '/delete_data';
// var CHANGE_STATUS_URL = "{{URL::to('common/change_status')}}";
// var GET_DATA_URL = "{{URL::to('common/getDataById')}}";

$(document).ready(function () {
   $(document).on("click", ".deleteRow", function () {
      var id = $(this).attr('data-id');
      var table = $(this).attr('data-table');
      toastr.error('Are you sure you want to delete it?<br /><br/><button data-table="'+table+'" data-id="'+id+'" type="button" class="btn btn-secondary clear confirm-delete">Yes</button>');
   })
   $(document).on("click", ".confirm-delete", function () {
      var id = $(this).attr('data-id');
      var table = $(this).attr('data-table');
     
      $.ajax({
         type: "POST",
         url: DELETE_URL,
         data: {
            id: id,
            table: table
         },
         dataType: "json",
         encode: true,
      }).done(function (data) {
         alertMessage(data.status, data.message);
      });
   })
});
   $(function () {
      /*Login Start*/
      $("form[name='login_form']").validate({
         // Specify validation rules
         rules: {
            email: "required",
            password: "required",
            role_id: "required",
         },

         messages: {
            email: "Please enter email",
            password: "Please enter password",
            role_id: "Please select role"
         },
         errorElement: "div",
         errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            error.insertAfter(element);
         },
         highlight: function (element) {
            $(element).removeClass('is-valid').addClass('is-invalid');
         },
         unhighlight: function (element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
         },
         submitHandler: function (form) {
            form_submit('login_form', event);
            return false;

         }
      });

      /*Login End*/

      $("form[name='ask_store_form']").validate({
         // Specify validation rules
         rules: {
            store: "required",
         },

         messages: {
            store: "Please select store",
         },
         errorElement: "div",
         errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            error.insertAfter(element);
         },
         highlight: function (element) {
            $(element).removeClass('is-valid').addClass('is-invalid');
         },
         unhighlight: function (element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
         },
         submitHandler: function (form) {
            form_submit('ask_store_form', event);
            return false;

         }
      });

      /*Forgot Password Start*/
      $("form[name='forgot_password_form']").validate({
         // Specify validation rules
         rules: {
            email: "required",
         },

         messages: {
            email: "Please enter email",
         },
         errorElement: "div",
         errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            error.insertAfter(element);
         },
         highlight: function (element) {
            $(element).removeClass('is-valid').addClass('is-invalid');
         },
         unhighlight: function (element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
         },
         submitHandler: function (form) {
            form_submit('forgot_password_form', event);
            return false;

         }
      });

      /*Forgot Password End*/

      /*Reset Password Start*/
      $("form[name='reset_password_form']").validate({
         // Specify validation rules
         rules: {
            new_password: "required",
            con_password: {
               //minlength : 5,
               equalTo: "#new_password"
            }
         },

         messages: {
            new_password: "Please enter password",
         },
         errorElement: "div",
         errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            error.insertAfter(element);
         },
         highlight: function (element) {
            $(element).removeClass('is-valid').addClass('is-invalid');
         },
         unhighlight: function (element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
         },
         submitHandler: function (form) {
            form_submit('reset_password_form', event);
            return false;

         }
      });

      /*Reset Password End*/

});

function form_submit(formid, event) {
   event.preventDefault();
   if (formid) {
      var form_id = formid;
   } else {
      var form_id = $("form").attr("id");
   }

   $("#btnSubmit").attr("disabled", true);
   var form_url = base_url + '/' + $('#' + form_id).find("#action").val();

   //var formData = $('#'+form_id).serializeArray();
   var form = $('#' + form_id)[0];
   var formData = new FormData(form)

   $.ajax({
      type: "POST",
      url: form_url,
      data: formData,
      cache: false,
      processData: false,
      contentType: false,
      dataType: "json",
      encode: true,
   }).done(function (data) {
      $("#btnSubmit").attr("disabled", false);
      //alert(11);
      alertMessage(data.status, data.message);
      switch (formid) {
         case 'login_form':
            if (data.status == 'true') {
               if(data.store_assigned) {
                  window.location.href = base_url + "store";
               } else {
                  window.location.href = base_url + "dashboard";
               }
            }
            break;
         case 'ask_store_form':
            if (data.status == 'true') {
               window.location.href = base_url + "dashboard";
            }
            break;
         case 'forgot_password_form':
         case 'reset_password_form':
            if (data.status == 'true') {
               window.location.href = base_url + "login";
            }
            break;
         }
   });

}

$('#store').change(function(){
    var id = $(this).val();

    $.ajax({
         type: "POST",
         url: "<?= base_url('getTerminal')?>",
         data: {
            id: id
         },
         dataType: "json",
         encode: true,
      }).done(function (data) {
         if(data.status == "true") {
            $('#terminal').html(data.data);
            $('.terminal-row').show();
         } else {
            alertMessage(data.status, data.message);
            $('.terminal-row').hide();
         }
      })    
 });

     </script>