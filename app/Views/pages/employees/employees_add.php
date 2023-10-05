<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-8 col-12 breadcrumb-new">
           <h3 class="content-header-title mb-0 d-inline-block">Add Employee</h3>
        </div>
    </div>
    <div class="card card-content collapse show">
      <div class="card-body card-dashboard">
            <div class="row">
               <div class="col-12">
                  <div class="card">
                     <form method="post" action="<?=  base_url('/public/save') ?>">
                     <div class="card-content collapse show">
                        <div class="card-body card-dashboard" >
                           <div class="row">
                              <div class="col-md-2">
                                 <div class="form-floating">
                                 <img class="brand-logo admin-logo" alt="robust admin logo" src="<?=base_url()?>/public/app-assets/images/logo/logo.png"></img>
                              </div>
                              </div>
                              <div class="col-md-2">
                                 <div class="form-floating">
                                 <button  type="button" name="profile" class="btn btn-info">Change Photo</button>
                              </div>
                              </div>
                              <div class="col-md-2 " style="padding-left: 10px;">
                                 <a href="" class="transh-icon-color"><i class="fa fa-trash-o"></i> Delete</a>                          
                              </div>
                           </div>
                           <hr>
                           <br>
                           <div class="row">
                              <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="floatingInputGrid" placeholder="" name="first_name" >
                                 <label for="floatingSelectGrid">First Name*</label>
                              </div>
                           </div>
                               <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="floatingInputGrid" placeholder="" value="" name="last_name" >
                                 <label for="floatingSelectGrid">Last Name*</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
                              <select class="form-select" name="role" id="floatingSelectGrid" aria-label="Floating label select example">
                                    <option >Manager</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                              </select>
                              <label for="floatingSelectGrid">Role</label>
                              </div>
                           </div>
                            <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="email" class="form-control" id="floatingInputGrid" placeholder="" value="" name="primary_email">
                                 <label for="floatingSelectGrid">Email ID*</label>
                              </div>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                              <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="floatingInputGrid" placeholder="" value="" name="phone">
                                 <label for="floatingSelectGrid">Phone*</label>
                              </div>
                           </div>
                               <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="email" class="form-control" id="floatingInputGrid" placeholder="" value="" name="secondary_email" >
                                 <label for="floatingSelectGrid">Email ID*</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="floatingInputGrid" placeholder="" value="" name="address" >
                                 <label for="floatingSelectGrid">Address</label>
                              </div>
                           </div>
                            <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="floatingInputGrid" placeholder="" value="" name="zip" >
                                 <label for="floatingSelectGrid">ZIP</label>
                              </div>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                              <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="floatingInputGrid" placeholder="" value="" name="city">
                                 <label for="floatingSelectGrid">City</label>
                              </div>
                           </div>
                               <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="password" class="form-control" id="pass_log_id" placeholder="" value="" name="password" >
                                 <div class="form-control-position"  style="padding: 9px;">
                                  <i toggle="#password-field" class="fa fa-eye toggle-password"></i>
                                  </div>
                                 <label for="floatingSelectGrid">New Password</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-floating">
                                 <input type="password" class="form-control" id="pass_log_cnf_id" placeholder="" value="" name="cpassword" >
                                 <div class="form-control-position"  style="padding: 9px;">
                                  <i toggle="#password-field" class="fa fa-eye toggle-cnf_password"></i>
                                  </div>
                                 <label for="floatingSelectGrid">Confirm Password</label>
                              </div>
                           </div>
                        </div>
                          <br>
                          <p>Select Stores</p>
                          <div class="row">
                           <div class="col-md-6">
                              <div class="form-floating">
                                 <select class="select2 form-control" name="store[]" multiple="multiple">
                                    <option >Access to all Stores</option>
                                    <option >Beguiled  and Dem</option>
                                    <option >Two</option>
                                    <option >Three</option>
                                 </select>
                              </div>
                           </div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-md-6">
                              <input type="radio" class="" name="is_smaller_unit" id="active" checked><label for="active" class="mr-1" >Active</label>
                              <input type="radio" class="" name="is_smaller_unit" id="inactive"><label for="inactive" class="mr-1">Inactive</label>
                           </div>
                            <div class="col-md-6 text-right">
                           <!-- <div class="form-footer text-right"> -->
                              <button  type="button" class="btn btn-default_new"><i class="fa fa-close"></i> Cancel</button>
                              <button  type="submit" class="btn btn-info" name="save"><i class="fa fa-file-o"></i> Save</button>
                           </div>
                          </div>
                        </div>
                     </div>
                  </form>
                  </div>
               </div>
            </div>
      </div>
   </div>
   


<script>
 $(document).on('click', '.toggle-password', function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    
    var input = $("#pass_log_id");
    input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
    });
   
</script>
<script>
 $(document).on('click', '.toggle-cnf_password', function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    
    var input = $("#pass_log_cnf_id");
    input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
    });
   
</script>