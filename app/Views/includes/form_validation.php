<script type="text/javascript">
   $(document).ready(function () {
    
      /*Login Start*/
      $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
          var re = new RegExp(regexp);
          return this.optional(element) || re.test(value);
        },
        "Please check your input."
      );

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

      $("form[name='role_form']").validate({
         // Specify validation rules
         rules: {
            role_name: "required",
         },
         // Specify validation error messages
         messages: {
            role_name: "Please enter user role",
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
            //form.submit(function (event){
            event.preventDefault();
            $("#btnSubmit").attr("disabled", true);
            var form_url = base_url + '/' + $("#action").val();
            var formData = $('#role_form').serialize();
            //var formData = new FormData($('#role_form')[0]);

            $.ajax({
               type: "POST",
               url: form_url,
               data: formData,
               dataType: "json",
               encode: true,
            }).done(function (data) {
               $("#btnSubmit").attr("disabled", false);
               //console.log(data.status);
               alertMessage(data.status, data.message);
               window.location.href = base_url + "/settings#roles";
            });
            //});

         }
      });

      /*Currency Form Validation*/
      $("form[name='currency_form']").validate({
         rules: {
            currency_code: "required",
            currency_symbol: "required",
            currency_name: "required",
            decimal_places: "required",
            exchange_date: "required",
            exchange_rate: "required",
            format: "required",
         },
         // Specify validation error messages
         messages: {
            currency_code: "Please enter currency code",
            currency_symbol: "Please enter currency symbol",
            currency_name: "Please enter currency name",
            decimal_places: "Please enter decimal places",
            exchange_date: "Please enter exchange date",
            exchange_rate: "Please enter exchange rate",
            format: "Please enter format",
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
            //form.submit(function (event){
            event.preventDefault();
            //$("#btnSubmit").attr("disabled", true);
            var form_url = base_url + '/' + $("#action").val();
            var formData = $('#currency_form').serialize();
            //var formData = new FormData($('#role_form')[0]);
            console.log(formData);
            $.ajax({
               type: "POST",
               url: form_url,
               data: formData,
               dataType: "json",
               encode: true,
            }).done(function (data) {
               //$("#btnSubmit").attr("disabled", false);
               //console.log(data.status);
               alertMessage(data.status, data.message);
               window.location.href = base_url + "/settings#currency";
            });
            //});

         }
      });
        
      /*General Form Validation*/
      
      $("form[name='general_form']").validate({
         // Specify validation rules
         rules: {
            store_id: "required",
            currency_id: "required",
            opening_hour: "required",
            closing_hour: "required"
         },
         // Specify validation error messages
         messages: {
            store_id: "Please select store",
            currency_id: "Please select currency",
            opening_hour: "Please enter opening hours",
            closing_hour: "Please enter closing hours"
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
            event.preventDefault();
            var form_url = base_url + '/' + $("#action").val();
            var formData = $('#general_form').serialize();

            $.ajax({
               type: "POST",
               url: form_url,
               data: formData,
               dataType: "json",
               encode: true,
            }).done(function (data) {
               if(data.status == 'true') {
                  $('#general_form')[0].reset();
                  $("#general_id").val('');
               }
               alertMessage(data.status, data.message);
            });
         }
      });
      
      /*Terminals Form Validation*/
      
      $("form[name='terminal_form']").validate({
         // Specify validation rules
         rules: {
            terminal_name: "required",
            store_id: "required",
            location_id: "required",
            type: "required",
            sales_invoice_prefix: "required",
            sales_invoice_starting_no: "required",
            sales_return_prefix: "required",
            sales_return_starting_no: "required",
            // status : "required",

         },
         // Specify validation error messages
         messages: {
            terminal_name: "Please enter terminal name",
            type: "Please select type",
            store_id: "Please select store name",
            location_id: "Please select location",
            sales_invoice_prefix: "Please enter sales invoice prefix",
            sales_invoice_starting_no: "Please enter sales invoice starting no",
            sales_return_prefix: "Please enter sales return prefix",
            sales_return_starting_no: "Please enter sales return starting no",
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
            event.preventDefault();
            var form_url = base_url + '/' + $("#action").val();
            var formData = $('#terminal_form').serialize();
            console.log(formData);
            $.ajax({
               type: "POST",
               url: form_url,
               data: formData,
               dataType: "json",
               encode: true,
            }).done(function (data) {
               //$("#btnSubmit").attr("disabled", false);
               alertMessage(data.status, data.message);
               window.location.href = base_url + "/settings#terminals";
            });
            //});

          }
       });
   

      /*Taxes Form Start*/
      $("form[name='tax_form']").validate({
         // Specify validation rules
         rules: {
            tax_type: "required",
            tax_rate: "required",
         },
         // Specify validation error messages
         messages: {
            tax_type: "Please select tax type",
            tax_rate: "Please enter tax rate",
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
            event.preventDefault();
            //$("#btnSubmit").attr("disabled", true);
            var form_url = base_url + '/' + $("#action").val();
            var formData = $('#tax_form').serialize();
            console.log(formData);
            $.ajax({
               type: "POST",
               url: form_url,
               data: formData,
               dataType: "json",
               encode: true,
            }).done(function (data) {
               //$("#btnSubmit").attr("disabled", false);
               alertMessage(data.status, data.message);
                window.location.href = base_url + "/settings#tax";
            });
            //});

         }
      });
      /*Taxes Form End*/

      /*Employee Start*/
      $("form[id='employee_form']").validate({
         // Specify validation rules
         rules: {
            first_name: "required",
            last_name: "required",
            role_id: "required",
            primary_email: "required",
            phone: "required",
            secondary_email: "required",
            address: "required",
            zip: "required",
            city: "required",
            password: "required",
            terminal_id:"required",
         },

         messages: {
           last_name: "Please enter user store name",
            role_id: "Please select user role",
            tax_no: "Please enter  tax",
            primary_email: "Please enter primary email",
            phone: "Please enter phone",
            secondary_email: "Please enter email",
            address: "Please enter user address",
            zip: "Please enter user zip",
            city: "Please enter user city",
            password: "Please enter password",
            terminal_id: "Please select terminal name",
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
      /*Employee End*/

      /*Store Start*/
      $("form[name='store_form']").validate({
         // Specify validation rules
         rules: {
            store_name: "required",
            phone: "required",
            tax_no: "required",
            address: "required",
            zip: "required",
            city: "required",
         },

         messages: {
            store_name: "Please enter user store name",
            phone: "Please enter user phone",
            tax_no: "Please enter user tax",
            address: "Please enter user address",
            zip: "Please enter user zip",
            city: "Please enter user city",
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
            form_submit('store_form', event);
            return false;

         }
      });
      /*Store End*/

      /*Customer Start*/
      
      $("form[name='customer_form']").validate({
         // Specify validation rules
         rules: {
            account_id: {
               required: true,
               maxlength: 30,
               regex: "^[A-Za-z0-9_-]*$"
            },
            tpin_no: {
               required: true,
               maxlength: 30,
               regex: "^[A-Za-z0-9]*$"
            },
            id_no: {
               required: true,
               maxlength: 50,
               regex: "^[A-Za-z0-9]*$"
            },
            registerd_name: {
               required: true,
               maxlength: 80,
               regex: "^[A-Za-z ]*$"
            },
            tax_account_name: {
               required: true,
               maxlength: 80,
               regex: "^[A-Za-z ]*$"
            },
            email: {
               required: true,
               maxlength: 30
            },
            address: {
               required: true,
               maxlength: 150
            },
            phone: {
               required: true,
               maxlength: 16,
               regex: "^[0-9]*$"
            },
         },

         messages: {
            account_id: {
               required: "Please enter account id",
               maxlength: "Maximum 30 characters allowed",
               regex: "Please enter alphabets, numbers & underscores only"
            },
            tpin_no: {
               required: "Please enter tpin no",
               maxlength: "Maximum 30 characters allowed",
               regex: "Please enter alphabets and numbers only"
            },
            id_no: {
               required: "Please enter id no",
               maxlength: "Maximum 80 characters allowed",
               regex: "Please enter alphabets and numbers only"
            },
            registerd_name: {
               required: "Please enter registered name",
               maxlength: "Maximum 80 characters allowed",
               regex: "Please enter alphabets only"
            },
            tax_account_name: {
               required: "Please enter tax account name",
               maxlength: "Maximum 80 characters allowed",
               regex: "Please enter alphabets only"
            },
            email: {
               required: "Please enter email id",
               maxlength: "Maximum 30 characters allowed"
            },
            address: {
               required: "Please enter address",
               maxlength: "Maximum 150 characters allowed"
            },
            phone: {
               required: "Please enter phone number",
               maxlength: "Maximum 16 digits allowed",
               regex: "Please enter numbers only"
            },
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
            form_submit('customer_form', event);
            return false;

         }
      });

      /*Customer End*/

      /*Model Gift Card Master Start*/
      
      $("form[name='model_gift_card_form']").validate({
         // Specify validation rules
         rules: {
            batch_name: "required"
         },

         messages: {
            batch_name: "Please enter batch name",
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
            form_submit('model_gift_card_form', event);
            return false;
         }
      });

      /*Model Gift card Master End*/

      /*Model Change Password Master Start*/
      
      $("form[name='change_pass_form']").validate({
         // Specify validation rules
         rules: {
            password: "required"

         },

         messages: {
            password: "Please enter password",
            con_password: {
               //minlength : 5,
               equalTo: "#new_password"
            }
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
            form_submit('change_pass_form', event);
            return false;
         }
      });

      /*Model  Change Password Master End*/

      /*Gift Card Start*/
      
      $("form[id='gift_card_form']").validate({
         // Specify validation rules
         rules: {
            batch_id: "required",
            voucher_card_no: {
               required: true,
               maxlength: 80,
               regex: "^[A-Za-z0-9_-]*$"
            },
            expiry_date: "required",
            amount: {
               required: true,
               maxlength: 20,
               regex: "^[0-9]*$"
            },
         },

         messages: {
            batch_id: "Please select batch name",
            voucher_card_no: {
               required: "Please enter voucher card no",
               maxlength: "Maximum 80 characters allowed",
               regex: "Please enter alphabets, numbers & underscores only"
            },
            expiry_date: "Please enter expiry date",
            amount: {
               required: "Please enter amount",
               maxlength: "Maximum 20 digits allowed",
               regex: "Please enter numbers only"
            },
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
            form_submit('gift_card_form', event);
            return false;

         }
      });
      /*Gift Card End*/

      /*Loyalty Points Start*/
      
      $("form[name='loyalty_form']").validate({
         // Specify validation rules
         rules: {
            loyalty_system: "required",
            bill_amount_to_earn: "required",
            point_in_amount: "required",
            minimum_redeem: "required",
         },

         messages: {
            loyalty_system: "Please select loyalty system",
            bill_amount_to_earn: "Please enter bill amount to earn",
            point_in_amount: "Please enter point in amount",
            minimum_redeem: "Please enter minimum redeem"
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
            form_submit('loyalty_form', event);
            return false;

         }
      });

      /*Loyalty Points End*/
        
        /*Receipt Start*/
      
      $("form[name='receipt_form']").validate({
         // Specify validation rules
         rules: {
            store_id: "required",
            receipt_title: "required",
            receipt_footer: "required",
            receipt_language: "required",
         },

         messages: {
            store_id: "Please select store name",
            receipt_title: "Please enter receipt title",
            receipt_footer: "Please enter receipt footer",
            receipt_language: "Please enter receipt language"
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
            form_submit('receipt_form', event);
            return false;

         }
      });

      /*Receipt End*/
      
      /*Weighing Scale Start*/
      
      $("form[name='weighingscale_form']").validate({
         // Specify validation rules
         rules: {
            prefix: "required",
            entry_code: "required",
            type: "required",
            digit: "required",
         },

         messages: {
            prefix: "Please enter prefix",
            entry_code: "Please enter entry code",
            type: "Please select type",
            digit: "Please enter digit"
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
            form_submit('weighingscale_form', event);
            return false;

         }
      });

      /*Weighing Scale End*/

      /*Supplier Start*/
      
      $("form[name='supplier_form']").validate({
         // Specify validation rules
         rules: {
            registered_name: "required",
            tax_amount_name: "required",
            operator: "required",
            payable: "required",
            email: "required",
            phone: "required",
            address: "required",
            date: "required",
            status_type: "required",
         },

         messages: {
            registered_name: "Please enter registerd name",
            tax_amount_name: "Please enter tax amount name",
            operator: "Please enter operator",
            payable: "Please enter payable",
            email: "Please enter email",
            phone: "Please enter phone no",
            address: "Please enter address",
            date: "Please enter date",
            status_type: "Please select status type"
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
            form_submit('supplier_form', event);
            return false;

         }
      });

      /*Supplier End*/
   
      /*uom Start*/
     
      $("form[id='uom_form']").validate({
         // Specify validation rules
         rules: {
            formal_name: "required",
            uom: "required",
            decimal_points: "required",
         },

         messages: {
            formal_name: "Please enter formal name",
            uom: "Please enter uom",
            decimal_points: "Please enter decimal points",
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
            form_submit('uom_form', event);
            return false;

         }
      });
      /*uom End*/
    
      /*Model Customer Start*/
      $("form[name='model_customer_form']").validate({
         // Specify validation rules
         rules: {
            account_id: "required",
            email: "required",
            id_no: "required",
            registerd_name: "required",
            tax_account_name: "required",
            address: "required",
            phone: "required"
         },

         messages: {
            account_id: "Please enter account id",
            email: "Please enter email id",
            id_no: "Please enter id no",
            registerd_name: "Please enter registerd name",
            tax_account_name: "Please enter tax account name",
            address: "Please enter address",
            phone: "Please enter phone",
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
            form_submit('model_customer_form', event);
            return false;
         }
      });

      /*Model Customer End*/
      $("form[name='department_form']").validate({
         // Specify validation rules
         rules: {
            department_name: {
               required: true,
               maxlength: 80,
               regex: "^[A-Za-z ]*$"
            },
            /*markup_percent: {
               maxlength: 10,
            }*/
         },
         messages: {
            department_name: {
               required: "Please enter department name",
               maxlength: "Maximum 80 characters allowed",
               regex: "Please enter alphabets only"
            },
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
            form_submit('department_form', event);
            return false;
         }
      });
      /*category Start*/
      
      $("form[id='category_form']").validate({
         // Specify validation rules
         rules: {
            category_name: {
               required: true,
               maxlength: 80,
               regex: "^[A-Za-z ]*$"
            },
            prefix: {
               required: true,
               maxlength: 50,
            },
            custom_report: {
               required: true,
               maxlength: 50,
            },
         },
         messages: {
            category_name: {
               required: "Please enter category name",
               maxlength: "Maximum 80 characters allowed",
               regex: "Please enter alphabets only"
            },
            prefix: {
               required: "Please enter prefix for SKU",
               maxlength: "Maximum 50 characters allowed"
            },
            custom_report: {
               required: "Please enter customer report",
               maxlength: "Maximum 50 characters allowed"
            }
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
            form_submit('category_form', event);
            return false;

         }
      });
      
      /*category End*/

      /*brand Start*/
      
      $("form[id='brand_form']").validate({
         // Specify validation rules
         rules: {
            brand_name: "required",
         },

         messages: {
            brand_name: "Please enter brand name",
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
            form_submit('brand_form', event);
            return false;

         }
      });
      
      /*brand End*/
      
       /*recipe Start*/
      
      $("form[id='recipe_form']").validate({
         // Specify validation rules
         rules: {
            group_name: "required",
         },

         messages: {
            group_name: "Please select group name",
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
            form_submit('recipe_form', event);
            return false;

         }
      });
      
      /*recipe End*/
      
      /*modifier Start*/
      
      $("form[id='modifier_form']").validate({
         // Specify validation rules
         rules: {
            name: "required",
            quantity: "required",
            group: "required",
            total_rate: "required",
            unit_rate: "required",
         },

         messages: {
            name: "Please enter name",
            quantity: "Please enter quantity",
            group: "Please enter quantity",
            total_rate: "Please enter total rate",
            unit_rate: "Please enter unit rate",
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
            form_submit('modifier_form', event);
            return false;

         }
      });
      
      /*modifier End*/
      
      /*item Start*/
      
      $("form[id='standard_item_form']").validate({
         // Specify validation rules
         rules: {
            item_name: "required",
            sku_barcode: "required",
            supply_price: "required",
            markup: "required",
            retail_price: "required",
            minimum_retail_price: "required",
            current_invetory: "required",
            inventory_value: "required",
            re_order_point: "required",
            category_id: "required",
            // subcategory_id: "required",
            uom_id: "required",
            tax_id: "required",
            purchase_tax_id: "required",
            // brand_id: "required",
            modifier_id: "required",
            // item_description: "required",
         },

         messages: {
            item_name: "Please enter item name",
            sku_barcode: "Please enter barcode",
            supply_price: "Please supply price",
            markup: "Please enter markup",
            retail_price: "Please enter retail price",
            minimum_retail_price: "Please enter minimum retail price",
            current_invetory: "Please enter curent inventory",
            inventory_value: "Please enter inventory value",
            re_order_point: "Please enter re-order point",
            category_id: "Please enter category",
            // subcategory_id: "Please enter subcategory",
            uom_id: "Please enter uom",
            tax_id: "Please enter tax",
            purchase_tax_id: "Please enter purchase tax",
            // brand_id: "Please enter brand",
            modifier_id: "Please enter modifier",
            // item_description: "Please enter item description",
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
            form_submit('standard_item_form', event);
            return false;

         }
      });
      
      /*item End*/

      /*variant Start*/
   
      $("form[name='variant_form']").validate({
         // Specify validation rules
         rules: {
            variant_name: "required",
         },

         messages: {
            variant_name: "Please enter variant name",
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
            form_submit('variant_form', event);
            return false;

         }
      });

      $("form[name='variant_master_form']").validate({
         // Specify validation rules
         rules: {
            variant_name: "required",
         },

         messages: {
            variant_name: "Please enter variant name",
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
            form_submit('variant_master_form', event);
            return false;

         }
      });

      $("form[name='copy_items_form']").validate({
         // Specify validation rules
         rules: {
            variant_name: "required",
         },

         messages: {
            variant_name: "Please enter variant name",
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
            form_submit('copy_items_form', event);
            return false;
         }
      });

      $("form[name='location_master_form']").validate({
         // Specify validation rules
         rules: {
            location_type: "required",
            store_id: "required",
            location_description: "required",
         },
         messages: {
            location_type: "Please select location type",
            store_id: "Please select store",
            location_description: "Please enter location description",
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
            form_submit('location_master_form', event);
            return false;

         }
      });

      $("form[name='model_item_form']").validate({
         // Specify validation rules
         rules: {
            item_name: "required",
         },

         messages: {
            item_name: "Please enter item name",
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
            form_submit('model_item_form', event);
            return false;

         }
      });

      /*variant End*/

      /*composite Start*/
      
      $("form[name='composite_form']").validate({
         // Specify validation rules
         rules: {
            variant_name: "required",
         },

         messages: {
            variant_name: "Please enter variant name",
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
            form_submit('composite_form', event);
            return false;

         }
      });

      /*composite End*/

      /*item Start*/
      $("form[id='variance_item_form']").validate({
         // Specify validation rules
         rules: {
            item_name: "required",
            category_id: "required",
            uom_id: "required",
            tax_id: "required",
            purchase_tax_id: "required",
            modifier_id: "required",
         },

         messages: {
            item_name: "Please enter item name",
            category_id: "Please select category",
            uom_id: "Please select uom",
            tax_id: "Please select tax",
            purchase_tax_id: "Please select purchase tax",
            modifier_id: "Please select modifier",
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
            form_submit('variance_item_form', event);
            return false;

         }
      });

      $("form[id='composite_item_form']").validate({
         // Specify validation rules
         rules: {
            item_name: "required",
            sku_barcode: "required",
            supply_price: "required",
            markup: "required",
            retail_price: "required",
            minimum_retail_price: "required",
            current_invetory: "required",
            inventory_value: "required",
            re_order_point: "required",
            category_id: "required",
            // subcategory_id: "required",
            uom_id: "required",
            tax_id: "required",
            purchase_tax_id: "required",
            // brand_id: "required",
            modifier_id: "required",
            // item_description: "required",
         },

         messages: {
            item_name: "Please enter item name",
            sku_barcode: "Please enter barcode",
            supply_price: "Please enter name",
            markup: "Please enter name",
            retail_price: "Please enter name",
            minimum_retail_price: "Please enter name",
            current_invetory: "Please enter name",
            inventory_value: "Please enter name",
            re_order_point: "Please enter name",
            category_id: "Please enter name",
            // subcategory_id: "Please enter name",
            uom_id: "Please enter name",
            tax_id: "Please enter name",
            purchase_tax_id: "Please enter name",
            // brand_id: "Please enter name",
            modifier_id: "Please enter name",
            // item_description: "Please enter name",
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
            form_submit('composite_item_form', event);
            return false;

         }
      });
      /*item End*/


      /*Update Order status start*/

      $("form[name='audite_form']").validate({
            // Specify validation rules
            rules: {
               order_status: "required",
            },

            messages: {
               order_status: "Please select status",
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
               form_submit('audite_form', event);
               return false;

            }
         });

      /*Update Order status end*/

      /*Payment start*/

      $("form[name='payment_form']").validate({
         // Specify validation rules
         rules: {
            payment_type_id: "required",
            // store_id : "required",
            type_id: "required",
            receipt_name: "required",
            track_card_details: "required",
            mdr_collect_from_customer: "required",

         },
         // Specify validation error messages
         messages: {
            payment_type_id: "Please select payment type",
            // store_id: "Please select type",
            type_id: "Please select type id",
            receipt_name: "Please enter receipt name",
            track_card_details: "Please select track card details",
            mdr_collect_from_customer: "Please select mdr collect from customer",
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
            event.preventDefault();
            //$("#btnSubmit").attr("disabled", true);
            var form_url = base_url + '/' + $("#action").val();
            var formData = $('#payment_form').serialize();

            $.ajax({
               type: "POST",
               url: form_url,
               data: formData,
               dataType: "json",
               encode: true,
            }).done(function (data) {
               //$("#btnSubmit").attr("disabled", false);
               alertMessage(data.status, data.message);
            });
            //});

         }
      });

      /*Payment end*/

      $("form[name='purchase_order_form']").validate({
         // Specify validation rules
         rules: {
            customer_id: "required",
            supplier_id: "required",
            category_id: "required",
            order_number: "required",
            due_date: "required",
            location: "required"
         },
         messages: {
            customer_id: "Please select customer",
            supplier_id: "Please select supplier",
            category_id: "Please select category",
            order_number: "Please enter order number",
            due_date: "Please enter due date",
            location: "Please select location"
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
            $(".save_n_receive").attr("disabled", true);
            $("#btnSubmit").attr("disabled", true);
            form_submit('purchase_order_form', event);
            return false;

         }
      });

      /*Goods received Start*/

      $("form[name='goods_received_form']").validate({
         // Specify validation rules
         rules: {
            customer_id: "required",
            supplier_id: "required",
            store_id: "required",
            location_id: "required",
            order_number: "required",
            due_date: "required"
         },

         messages: {
            customer_id: "Please select customer",
            supplier_id: "Please select supplier",
            store_id: "Please select store",
            location_id: "Please select category",
            order_number: "Please enter order number",
            due_date: "Please enter due date"
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
            form_submit('goods_received_form', event);
            return false;

         }
      });
      /*Goods received End*/
      
      $("form[name='direct_goods_receive_form']").validate({
         // Specify validation rules
         rules: {
            store_id: "required",
            location_id: "required",
            supplier_id: "required"
         },

         messages: {
            supplier_id: "Please select supplier",
            store_id: "Please select store",
            location_id: "Please select location",
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
            form_submit('direct_goods_receive_form', event);
            return false;

         }
      });
      /*Back Order Start*/

      $("form[name='purchase_back_order_form']").validate({
         // Specify validation rules
         rules: {
            order_number: "required",
            supplier_id: "required",
            store: "required",
            category_id: "required",
            due_date: "required"
         },

         messages: {
            order_number: "Please select order number",
            supplier_id: "Please select supplier",
            store: "Please select store",
            category_id: "Please select category",
            due_date: "Please enter due date"
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
            form_submit('purchase_back_order_form', event);
            return false;
         }
      });

      /*Back Order End*/

      /*Goods returned Start*/
      
      $("form[id='goods_returned_form']").validate({
            // Specify validation rules
            rules: {
            supplier_id: "required",
            store_id: "required",
            category_id: "required",
            order_number: "required",
            due_date: "required"
            },

            messages: {
            supplier_id: "Please select supplier",
            store_id: "Please select store",
            category_id: "Please select category",
            order_number: "Please enter order number",
            due_date: "Please enter due date",
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
               form_submit('goods_returned_form', event);
               return false;

            }
      });

      /*Goods returned End*/

      /*Invoice Start*/

      $("form[name='invoice_form']").validate({
         // Specify validation rules
         rules: {
            customer_id: "required",
            invoice: "required",
            terms: "required",
            due_date: "required",
            invoice_date: "required",
            subject: "required",
            order_number: "required",
            // currency_id: "required",
         },
         messages: {
            customer_id: "Please select customer name",
            invoice: "Please enter invoice",
            terms: "Please select terms",
            due_date: "Please select due date",
            invoice_date: "Please select invoice date",
            subject: "Please enter subject",
            order_number: "Please enter order number",
            // currency_id: "Please select exchange currency",
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
            <?php
               $current_url = current_url();
            ?>
            var urlCheck = '<?php echo $current_url; ?>'
            if(urlCheck.includes('edit_invoice')){
               if(somethingChanged){
                  var form = $('#invoice_form')[0];
                  $('#edit_invoice_id').val(form.id.value);
                  $('#edit_invoice_note_mdl').modal('show')
                  return false;
               }
            }
            form_submit('invoice_form', event);
            return false;
         }
      });

      $("form[name='credit_note_form']").validate({
         // Specify validation rules
         rules: {
            customer_id: "required",
            credit_note_no: "required",
            credit_date: "required",
         },
         messages: {
            customer_id: "Please select customer name",
            credit_note_no: "Please add credit note no",
            credit_date: "Please select credit date",
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
            form_submit('credit_note_form', event);
            return false;
         }
      });

      $("form[name='quotes_form']").validate({
         // Specify validation rules
         rules: {
            customer_id: "required",
            quote: "required",
            terms: "required",
            due_date: "required",
            quote_date: "required",
            quote_number: "required",
            // currency_id: "required",
         },
         messages: {
            customer_id: "Please select customer name",
            quote: "Please enter quote",
            terms: "Please select terms",
            due_date: "Please select due date",
            quote_date: "Please select quote date",
            quote_number: "Please enter quote number",
            // currency_id: "Please select exchange currency",
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
            form_submit('quotes_form', event);
            return false;
         }
      });

      $("form[name='edit_invoice_note']").validate({
         // Specify validation rules
         rules: {
            edit_notes: "required"
         },
         messages: {
            edit_notes: "Please add reason for edit invoice",
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
            form_submit('edit_invoice_note', event);
            return false;
         }
      });

      /*$("form[name='payment-received-form']").validate({
         // Specify validation rules
         rules: {
            customer: "required",
            amount_received: "required",
            type_id: "required",
         },

         messages: {
            customer_name: "Please enter customer name",
            amount_received: "Please enter received amount",
            type_id: "Please select payment mode"
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
            // form_submit('login_form', event);
            return false;

         }
      });*/

      /*Invoice End*/

      /*Payment Invoice Start*/

      $("form[name='payment_invoice_form']").validate({
         // Specify validation rules
         rules: {
            customer_id: "required",
            amount_received: "required",
            bank_charge: "required",
            payment_date: "required",
            payment_id: "required",
            payment_mode: "required",
            reference_id: "required",
            // currency_id: "required",
            // tax_deduction: "required",
         },

         messages: {
            customer_id: "Please select customer name",
            amount_received: "Please enter received amount",
            bank_charge: "Please enter bank charge",
            payment_date: "Please select payment date",
            payment_id: "Please enter payment",
            payment_mode: "Please select payment mode",
            reference_id: "Please enter reference number",
            // currency_id: "Please select exchange currency",
            // tax_deduction: "Please select tax deduction",
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
            form_submit('payment_invoice_form', event);
            return false;

         }
      });

      /*Payment Invoice End*/

      /*Stock Adjustment Start*/

      $("form[name='stock_adjust_form']").validate({
         // Specify validation rules
         rules: {
            reason: "required",
            store_id: "required",
            location_id: "required",
         },

         messages: {
            reason: "Please select reason",
            store_id: "Please select store",
            location_id: "Please select location",
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
            form_submit('stock_adjust_form', event);
            return false;

         }
      });
      $("form[name='adjustments_reason_form']").validate({
         // Specify validation rules
         rules: {
            reason: "required"
         },
         messages: {
            reason: "Please select reason",
            store_id: "Please select store",
            narration: "Please enter narration",
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
            form_submit('adjustments_reason_form', event);
            return false;

         }
      });
      /*Stock Adjustment End*/

      /*Transfer Start*/

      $("form[name='transfer_form']").validate({
         // Specify validation rules
         rules: {
            location_id:"required",
            supply_store_id: "required",
            receiver_store_id: "required",
            rec_location_id: "required",
            // category_id: "required",
            // order_number: "required",
            due_date: "required",
         },

         messages: {
            location_id: "Please select location",
            supply_store_id: "Please select supplier store name",
            receiver_store_id: "Please select receiver store name",
            rec_location_id: "Please select receiver location",
            // category_id: "Please select category name",
            // order_number: "Please enter order number",
            due_date: "Please select due date",
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
            form_submit('transfer_form', event);
            return false;

         }
      });

      /*Transfer End*/

      $("form[name='production_form']").validate({
         // Specify validation rules
         rules: {
            // item_id: "required",
            quantity: "required",
            store_id: "required",
            location_id: "required",
            date: "required",
         },

         messages: {
            // item_id: "Please select item",
            quantity: "Please enter quantity",
            store_id: "Please select store",
            location_id: "Please select location",
            date: "Please enter date",
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
            form_submit('production_form', event);
            return false;

         }
      });
      
      $("form[name='layby_contract_form']").validate({
         // Specify validation rules
         rules: {
            customer_id: "required",
            firstname: "required",
            lastname: "required",
            phone: "required",
            address: "required",
         },
         messages: {
            customer_id: "Please select customer name",
            firstname: "Please enter first name",
            lastname: "Please enter last name",
            phone: "Please enter phone",
            address: "Please enter address"
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
            form_submit('layby_contract_form', event);
            return false;
         }
      });

      /*Model Category Card Master Start*/
      
      $("form[name='model_category_form']").validate({
         // Specify validation rules
         rules: {
            category_name: "required",
            prefix: "required"
         },
         messages: {
            category_name: "Please enter category name",
            prefix: "Please enter prefix for SKU",
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
            form_submit('model_category_form', event);
            return false;
         }
      });

      $("form[name='model_subcategory_form']").validate({
         // Specify validation rules
         rules: {
            subcategory_name: "required"
         },
         messages: {
            subcategory_name: "Please enter subcategory name",
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
            form_submit('model_subcategory_form', event);
            return false;
         }
      });

      /*Model Category card Master End*/

      /*Model UOM Start*/
      
      $("form[name='model_uom_form']").validate({
         // Specify validation rules
         rules: {
            uom: "required"
         },
         messages: {
            uom: "Please enter uom",
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
            form_submit('model_uom_form', event);
            return false;
         }
      });

      /*Model UOM End*/

      /*Model Tax Start*/
      $("form[name='model_tax_form']").validate({
         // Specify validation rules
         rules: {
            tax_type_id :"required",
            tax_rate: "required",
         },
         messages: {
            tax_type_id: "Please enter category name",
            tax_rate: "Please enter tax rate",
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
            form_submit('model_tax_form', event);
            return false;
         }
      });

   /*Model Tax End*/

   /*Model Brand Start*/
      $("form[name='model_brand_form']").validate({
         // Specify validation rules
         rules: {
            brand_name :"required",
         },

         messages: {
            brand_name: "Please enter brand name",
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
            form_submit('model_brand_form', event);
            return false;
         }
      });

   /*Model Brand End*/

   /*Model Modifier Start*/
      $("form[name='model_modifier_form']").validate({
         // Specify validation rules
         rules: {
            name :"required",
            total_rate: "required",
            unit_rate: "required",
            quantity: "required",
            group: "required",
         },

         messages: {
            name: "Please enter name",
            quantity: "Please enter quantity",
            group: "Please enter quantity",
            total_rate: "Please enter total rate",
            unit_rate: "Please enter unit rate",
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
            form_submit('model_modifier_form', event);
            return false;
         }
      });
   /*Model Modifier End*/
  /*Validation form End*/
});
$(document).on('click','.save_n_complete',function(event){
   form_submit('goods_received_form', event,1);
})
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
   if (form_id != 'login_form' && form_id != 'forgot_password_form' && form_id != 'reset_password_form') {
      formData.append('country_code', iti.getSelectedCountryData().dialCode);
      //formData.push({ name: "country_code", value: iti.getSelectedCountryData().dialCode});
   }
   if(form_id == 'layby_contract_form') {
      formData.append('country_code', itiTel.getSelectedCountryData().dialCode);
   }

   if (form_id == 'employee_form') {
      formData.append('profile_image_name', $('#imagePreview_name').val());
   }
   
   if(type == 1){
      formData.append('status_type', 3);
      $(".save_n_complete").attr("disabled", true);
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
         case 'login_form':
            if (data.status == 'true') {
               window.location.href = base_url + "/dashboard";
            }
            break;
         case 'forgot_password_form':
         break;
         case 'reset_password_form':
            if (data.status == 'true') {
               window.location.href = base_url + "/login";
            }
            break;
         case 'model_gift_card_form':
            if(data.status == 'true') {
               $('#batch_id').append(data.data);
               $('#add-new-batch').modal('hide');
            }
            break;
         case 'gift_card_form':
            if(data.status == 'true') {
               window.location.href = base_url + "/customers#gift-cards";
            }
            break;
         case 'department_form':
          if (data.status == 'true') {
            window.location.href = base_url + "/items#department";
            }
            break;
         case 'category_form':
          if (data.status == 'true') {
            window.location.href = base_url + "/items#category";
            }
            break;
         case 'model_item_form':
            if (data.status == 'true') {
               $('.master_item').html(data.data);
               $('#add-master-item').modal('hide');
            }
            break;
         case 'model_category_form':
            if (data.status == 'true') {
               $('.category_list').html(data.data);
               $('#add-category').modal('hide');
             }
            break;
         case 'uom_form':
          if (data.status == 'true') {
              window.location.href = base_url + "/items#uom";
            }
            break;
         case 'model_uom_form':
            if (data.status == 'true') {
            $('.uom_list').html(data.data);
            $('#add-uom').modal('hide');
          }
         break;
         case 'model_tax_form':
            if (data.status == 'true') {
            $('.tax_list').html(data.data);
            $('#add-tax').modal('hide');
          }
         break;
         case 'model_brand_form':
            if (data.status == 'true') {
            $('.brand_list').html(data.data);
            $('#add-brand').modal('hide');
          }
         break;
         case 'brand_form':
         if (data.status == 'true') {
              window.location.href = base_url + "/items#brand";
            }
            break;
         case 'modifier_form':
         if (data.status == 'true') {
              window.location.href = base_url + "/items#modifiers";
            }
         break;
        case 'model_modifier_form':
            if (data.status == 'true') {
            $('.modifier_list').html(data.data);
            $('#add-modifier').modal('hide');
          }
         break;
         case 'recipe_form':
         if (data.status == 'true') {
              window.location.href = base_url + "/items#recipes";
            }
         break;
         case 'standard_item_form':
         if (data.status == 'true') {
              window.location.href = base_url + "/items#items-list";
            }
         break;
         case 'variance_item_form':
            if (data.status == 'true') {
              window.location.href = base_url + "/items#items-list";
            }
         break;
         case 'composite_item_form':
            if (data.status == 'true') {
              window.location.href = base_url + "/items#items-list";
            }
         break;
         case 'copy_items_form':
            $('#copy-items-mdl').modal('hide');
         break;
         case 'supplier_form':
            if (data.status == 'true') {
               window.location.href = base_url + "/purchases#supplier";
            }
            break;
         case 'purchase_order_form':
            if (data.status == 'true') {
               window.location.href = base_url + "/purchases#purchase-order";
            }
            break;
         case 'purchase_back_order_form':
            if (data.status == 'true') {
               window.location.href = base_url + "/purchases#back-order";
            }
            break;
         case 'audite_form':
            if(data.status == 'true') {
               window.location.reload();
               //window.location.href = base_url + "/purchases#purchase-order";
            }
            break; 
         case 'goods_returned_form':
            if(data.status == 'true') {
               window.location.href = base_url + "/purchases#goods-returned";
            }
            break;
         case 'goods_received_form':
            if(data.status == 'true') {
               window.location.href = base_url + "/purchases#goods-received";
            }
            break;
         case 'direct_goods_receive_form':
            if(data.status == 'true') {
               window.location.href = base_url + "/purchases#direct-goods-received";
            }
            break;
         case 'transfer_form':
            if(data.status == 'true') {
               window.location.href = base_url + "/inventory#transfer";
            }
            break; 
         case 'production_form':
            if(data.status == 'true') {
               window.location.href = base_url + "/inventory#production";
            }
            break; 
         case 'stock_adjust_form':
            if(data.status == 'true') {
               window.location.href = base_url + "/inventory#adjustment";
            }
            break;
         case 'adjustments_reason_form':
            if (data.status == 'true') {
               window.location.reload();
            }
            break;
         case 'receipt_form':
            if (data.status == 'true') {
              $('#receipt_form')[0].reset();
              window.location.href = base_url + "/settings#receipt";
            }
         break;
         case 'payment_form':
            if (data.status == 'true') {
               window.location.href = base_url + "/settings#payment";
            }
            break;
         case 'terminal_form':
            if (data.status == 'true') {
               window.location.href = base_url + "/settings#terminals";
            }
            break;
         case 'currency_form':
             if (data.status == 'true') {
               window.location.href = base_url + "/settings#currency";
            }
            break;
         case 'role_form':
             if (data.status == 'true') {
               window.location.href = base_url + "/settings#roles";
            }
            break;
         case 'employee_form':
             if (data.status == 'true') {
               window.location.href = base_url + "/settings#employees";
            }
            break;
         case 'store_form':
            if (data.status == 'true') {
               window.location.href = base_url + "/settings#stores";
            }
            break;
         case 'variant_form':
            if (data.status == 'true') {
               $('variant_name').val("");
               $('#add-new-variant').modal('hide')
               GetVariantList();
            }
            break;
         case 'variant_master_form':
            if (data.status == 'true') {
               window.location.reload();
            }
            break;
         case 'location_master_form':
            if (data.status == 'true') {
               window.location.reload();
            }
            break;
         case 'composite_form':
            if (data.status == 'true') {
               $('variant_name').val("");
               $('#add-new-composite').modal('hide')
               GetCompositeList();
            }
            break;
         case 'customer_form':
            if (data.status == 'true') {
               window.location.href = base_url + "/customers#customer-list";
            }
            break;
         case 'quotes_form':
            if (data.status == 'true') {
               window.location.href = base_url + "/sales#quotes";
            }
            break;
         case 'invoice_form':
            if (data.status == 'true') {
               window.location.href = base_url + "/sales#invoice-list";
            }
            break;
         case 'edit_invoice_note':
            if (data.status == 'true') {
               form_submit('invoice_form', event);
               return false;
            }
            break;
         case 'credit_note_form':
            if (data.status == 'true') {
               window.location.href = base_url + "/sales#invoice-list";
            }
            break;
         case 'layby_contract_form':
            if (data.status == 'true') {
               window.location.href = base_url + "/layby#layby-contract";
            }
            break;
         case 'model_customer_form':
            if (data.status == 'true') {
               $('.customer_list').html(data.data);
               $('#others').modal('hide');
            }
            break;
         case 'model_subcategory_form':
            $('#add-subcategory').modal('hide');
            $('.subcategory_id').html(data.data);
            $('.variance_subcategory_id').html(data.data);
            $('.composite_subcategory_id').html(data.data);
            if(data.type == 1) {
               window.location.href = base_url + "/items#subcategory";
            }
         break;
      }
   });

}
</script>