<style type="text/css">
  #sTbl td, .pd-0 {
     padding: 0px!important; 
  }
</style>
<div class="app-content content">
  <div class="content-wrapper">
     <?= view('includes/breadcrumb.php');?> 
     <div class="content-body">
      <div class="row">
         <!-- Icon Tab with bottom line -->
         <div class="col-xl-12 col-lg-12">
            <ul class="nav nav-tabs navigate-tabs nav-underline nav-justified mb-1" id="tab-bottom-line-drag">
               <li class="nav-item">
                  <a class="nav-link active" id="activeIcon12-tab1" data-toggle="tab" href="#term" aria-controls="activeIcon12" aria-expanded="true">Term</a>
               </li>
            </ul>
         </div>
      </div>
      <div class="tab-content ">

         <div class="tab-pane active show" id="term" role="tabpanel" aria-labelledby="activeIcon12-tab1" aria-expanded="true">
              <form class="filterTerm">
              <section class="mb-1 filter-bar">
                <div class="filter-bar-item" style="flex-grow:1;">
                   <span>
                      <input type="text" placeholder="Search" name="match[search]" class="form-control purchase-search searchDtField" value="">
                      <div class="form-control-position">
                         <i class="fa fa-search"></i>
                      </div>
                   </span>
                </div>
                <div class="filter-bar-item">
                   <span><button type="button" class="btn btn-outline-info btn-sm searchTermDtBtn">Search</button></span>
                </div>
         </section>
         </form>
         <div class="card card-content collapse show">
               <div class="card-body card-dashboard">
                  <section id="configuration">
                      <div class="col-12">
                           <div class="status-div">
                        <span class="active-span"></span><span> Active</span>   
                        <span class="inactive-span"></span><span> Inactive</span>
                     </div>
                        </div>
                     <div class="row">
                        <div class="col-12">
                           <div class="card">
                              <div class="card-content collapse show">
                                 <div class="card-body card-dashboard">
                                  <table id="terms-tbl" class="table table-striped table-bordered">
                                    <thead>
                                       <tr>
                                          <th>Merchant ID</th>
                                          <th>Merchant Name</th>
                                          <th>No of Stores</th>
                                          <th>License Validity</th>
                                          <th>Expiry Date</th>
                                          <th>Next Renewal Date</th>
                                          <th>No of Users per Store</th>
                                          <!-- <th>Action</th> -->
                                       </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                 </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </section>
               </div>
            </div>
         </div>
      </div>
      <div class="modal fade text-left" id="edit-staff-store-mdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel18">No of Staff</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="staff_store_management" name="staff_store_management">

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                  <table class="table table-bordered" id="sTbl">
                                    <thead>
                                      <th style="width: 30px;">Store ID</th>
                                      <th>Store Name</th>
                                      <th>No of Employees</th>
                                    </thead>
                                    <tbody id="append-row">
                                      
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i> Cancel</button>
                            <button id="btnSubmitStoreandStaff" type="button" class="btn btn-info"><i class="fa fa-file-o"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
      </div>
    </div>
  </div>
</div>