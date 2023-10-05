  <div class="app-content content">
      <div class="content-wrapper">
         <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 breadcrumb-new">
               <h3 class="content-header-title mb-0 d-inline-block">New Aggregator</h3>
              
            </div>
         </div>
 <div class="card card-content collapse show">
      <div class="card-body card-dashboard">
            <div class="row">
               <div class="col-12">
                  <div class="card">
                     <div class="card-content collapse show">
                        <div class="card-body card-dashboard" >
                           <div class="row">
                              <div class="col-md-4">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="" >
                                 <label for="floatingSelectGrid">Aggregator Name</label>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-floating">
                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                    <option selected>Noon Food</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                 </select>
                                 <label for="floatingSelectGrid">Aggregator Type</label>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-floating">
                                 <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                    <option selected>Sale Rate</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                 </select>
                                 <label for="floatingSelectGrid">Rate</label>
                              </div>
                           </div>
                           
                        </div>
                        <br>
                        
                       <div class="row">
                           <div class="col-md-6">
                          <div class="media mt-1">
                              <div class="pr-2">
                                  <i class="feather ft-credit-card fa-2x " style="color: red;"></i> 
                              </div>
                              <div class="media-body">
                                  <p class="text-bold-600 m-0">Pay to Aggregator account</p>
                                   
                                  <p class="font-small-2 text-muted m-0">Payment creadited to aggregator account</p>
                              </div>
                          </div>
                       </div>
                       <div class="col-md-6">
                           <div class="mt-15">
                            <input type="checkbox" data-size="sm" data-color="danger"name="switchery" id="switchery0" class="switchery" checked/>
                          </div>
                       </div>
                          </div>
                          <br>
                          <div class="row">
                           <div class="col-md-6">
                          <div class="media mt-1">
                              <div class="pr-2">
                                  <i class="fa fa-calculator fa-2x " style="color: red;"></i> 
                              </div>
                              <div class="media-body">
                                  <p class="text-bold-600 m-0">Tax</p>
                                  <p class="font-small-2 text-muted m-0">Enable/Disable tax for this store</p>
                              </div>
                          </div>
                       </div>
                       <div class="col-md-6">
                           <div class="mt-15">
                            <input type="checkbox" data-size="sm" data-color="danger"name="switchery" id="switchery0" class="switchery" unchecked/>
                          </div>
                       </div>
                          </div>
                          <br>
                          <p>Select Stores</p>
                          <div class="row">
                           <div class="col-md-6">
                              <div class="form-floating">
                                 <select class="select2 form-control " multiple="multiple">
                                    <option selected>Store Name Came Here</option>
                                    <option selected>Beguiled  and Dem</option>
                                    <option selected>Two</option>
                                    <option value="3">Three</option>
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
                              <button  type="button" class="btn btn-info"><i class="fa fa-file-o"></i> Save</button>
                           </div>
                          </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
      </div>
   </div>
 <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/app-assets/vendors/css/forms/selects/select2.min.css">
<script src="<?=base_url()?>public/app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js"></script>
<script src="<?=base_url()?>public/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js"></script>
<script src="<?=base_url()?>public/app-assets/vendors/js/forms/toggle/switchery.min.js"></script>
<script src="<?=base_url()?>public/app-assets/js/scripts/forms/switch.min.js"></script>
 <script src="<?=base_url()?>public/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="<?=base_url()?>public/app-assets/js/scripts/forms/select/form-select2.min.js"></script>