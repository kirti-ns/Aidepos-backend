<script type="text/javascript">
$(document).ready(function(){
  
    var merchantTbl = $('#merchants-tbl').DataTable({
        'processing': true,
        'serverSide': true,
        'ordering': false,
        'serverMethod': 'post',
        dom: "<'row'<'col-sm-12'tr>>" +
        "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
        'ajax': {
           'url':"<?=site_url('agent/merchants/getMerchants')?>",
           'data': function(data){
              // CSRF Hash
              var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
              var csrfHash = $('.txt_csrfname').val(); // CSRF hash
              var obj = $("form.filterMerchant").serializeArray();

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
          var c0 = dataIndex+1;
          var c1 = "<a href=\" "+base_url+"/agent/merchants/edit_merchant/"+data.id+" \" class=\"storeColor\">"+data.first_name+' '+data.last_name+"</a>";
          var c2 = "Administrator";
          if(data.created_by == "2") {
            c2 = "Agent";
          }
          var c3 = data.primary_email;
          var c4 = data.phone;
          var c5 = data.city;
          var c6 = data.stores;
          var c7 = data.created_at;
          var c8 = data.expiry_date;
         
          // var c8 = "<a href=\"#\" data-id=\" "+data.id+ "\" class=\"transh-icon-color deleteRow\" data-table=\"suppliers\"><i class=\"fa fa-trash-o\"></i></a>";
          $(row).children().eq(0).addClass(displayBorder('status',data.status)).html(c0);
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
    $('.searchDtBtn').click(function(e){
            e.preventDefault();
            merchantTbl.draw();
    });

    var termsTbl = $('#terms-tbl').DataTable({
        'processing': true,
        'serverSide': true,
        'ordering': false,
        'serverMethod': 'post',
        dom: "<'row'<'col-sm-12'tr>>" +
        "<'row rowDt'<'col-sm-6 colDtbl'><'col-sm-4'i><'col-sm-2'p>>",
        'ajax': {
           'url':"<?=site_url('agent/renewals/getTerms')?>",
           'data': function(data){
              // CSRF Hash
              var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
              var csrfHash = $('.txt_csrfname').val(); // CSRF hash
              var obj = $("form.filterTerm").serializeArray();

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
          var c1 = data.first_name+' '+data.last_name;
          var c2 = '<input type="number" class="form-control num_of_store_inp" data-id="'+data.id+'" value="'+data.num_of_store+'">';
          var c3 = data.license;
          var c4 = data.expiry_date;
          var c5 = data.next_renw;
          var c6 = "<a href=\"#\" data-id=\" "+data.pos_id+ "\" class=\"transh-icon-color editTermRow\"><i class=\"fa fa-pencil\"></i></a>";
          var c7 = '-';

          $(row).children().eq(0).html(c0);
          $(row).children().eq(1).html(c1);
          $(row).children().eq(2).addClass('pd-0').html(c2);
          $(row).children().eq(3).html(c3);
          $(row).children().eq(4).html(c4);
          $(row).children().eq(5).html(c5);
          $(row).children().eq(6).html(c6);
          $(row).children().eq(7).html(c7);
          // $(row).children().eq(8).html(c8);
                           
        }
    });
    $('.searchTermDtBtn').click(function(e){
            e.preventDefault();
            termsTbl.draw();
    });

    $("form[id='employee_form']").validate({
         // Specify validation rules
         rules: {
            first_name: "required",
            last_name: "required",
            primary_email: "required",
            phone: "required",
            secondary_email: "required",
            address: "required",
            zip: "required",
            city: "required",
            password: "required",
            employee__con_password: {
               equalTo: "#employee_password"
            }
         },

         messages: {
            first_name: "Please enter user firstname",
            last_name: "Please enter user lastname",
            primary_email: "Please enter primary email",
            phone: "Please enter phone",
            secondary_email: "Please enter email",
            address: "Please enter user address",
            zip: "Please enter user zip",
            city: "Please enter user city",
            password: "Please enter password",
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
            form_submit('employee_form', event);
            return false;

         }
      });

    function form_submit(formid, event,type=0) {
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

         formData.append('country_code', iti.getSelectedCountryData().dialCode);
         if (form_id == 'employee_form') {
            formData.append('profile_image_name', $('#imagePreview_name').val());
         }
         
         $.ajax({
            type: "POST",
            url: form_url,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            // dataType: "json",
            encode: true,
         }).done(function (data) {
            $("#btnSubmit").attr("disabled", false);
            data = JSON.parse(data)
            alertMessage(data.status, data.message);
            switch (formid) {
               case 'employee_form':
                  if (data.status == 'true') {
                     window.location.href = base_url + "/agent/merchants";
                  }
                  break;
            }
         });

      }

      $(document).on('click','.editTermRow',function(){

      var id = $(this).attr('data-id');
      $.ajax({
         type: "POST",
         url: '<?=base_url()?>/agent/term/editStoreandStaff',
         data: {
            id: id
         },
         dataType: "json",
         encode: true,
      }).done(function (data) {
         alertMessage(data.status, data.message);
         if(data.status == 'true'){
          var row = '';
          var i =0;
          $.each(data.data,function(k,v){
            row += '<tr>'+
                      '<td>'+
                      '<input type="text" class="form-control" name="store['+i+'][store_id]" placeholder="Store" value="'+v.id+'" readonly />'+
                      '</td>'+
                      '<td>'+
                      '<input type="text" class="form-control" name="store['+i+'][store_name]" placeholder="Store Name" value="'+v.store_name+'" readonly />'+
                      '</td>'+
                      '<td>'+
                        '<input type="number" class="form-control" name="store['+i+'][no_of_staff]" placeholder="Enter No of Staff" value="'+v.no_of_staff+'" />'+
                      '</td>'+
                    '</tr>';
            i++;
          })
          $('#append-row').html(row);
          $('#edit-staff-store-mdl').modal('show');
         }
      });
   });

   $(document).on('click','#btnSubmitStoreandStaff',function(){
      var form = $('#staff_store_management')[0];
      var formData = new FormData(form);
      
      $.ajax({
         type: "POST",
         url: '<?=base_url()?>/agent/term/postNumofStaff',
         data: formData,
         cache: false,
         processData: false,
         contentType: false,
         dataType: "json",
         encode: true,
      }).done(function (data) {
         if(data.status == 'true'){
          swal("Staff Updated!", data.message, "success");
          setTimeout(function(){
            window.location.reload();
          },500);
         }
      });
   });

   $(document).on('change','.num_of_store_inp',function(){
      var id = $(this).attr('data-id');
      var val = $(this).val();

      $.ajax({
         type: "POST",
         url: '<?=base_url()?>/agent/term/editNumofStore',
         data: {
            id: id,
            num_of_store: val
         },
         dataType: "json",
         encode: true,
      }).done(function (data) {
         if(data.status == 'true'){
          swal("Store Updated!", data.message, "success");
          setTimeout(function(){
            window.location.reload();
          },500);
         }
      });

   })
});
</script>