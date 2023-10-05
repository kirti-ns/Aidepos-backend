<style type="text/css">
   .btn-lb-white {
      border-color: #F05624;
      background-color: #fff!important;
      color: #F05624;
      padding: 0.5rem 0.75rem;
      font-size: .875rem;
      line-height: 1.5;
      border-radius: 0.18rem;
   }
   .btn-lb-white:hover {
       border-color: #F05624;
       background-color: #fff!important;
       color: #F05624!important;
   }
</style>
<div class="app-content content">
   <div class="content-wrapper">
      <div class="content-header row">
         <div class="content-header-left col-md-8 col-12 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Lay By</h3>
         </div>
      </div>
      <div class="content-body">
         <div class="row">
            <!-- Icon Tab with bottom line -->
            <div class="col-xl-12 col-lg-12">
               <ul class="nav nav-tabs navigate-tabs nav-underline nav-justified mb-1" id="tab-bottom-line-drag">
                  <li class="nav-item">
                     <a class="nav-link active" id="linkIcon12-tab1" data-toggle="tab" href="#layby-contract" aria-controls="linkIcon12" aria-expanded="false">Contract</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="activeIcon12-tab1" data-toggle="tab" href="#layby-payment" aria-controls="activeIcon12" aria-expanded="true">Payment</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#layby-refund" aria-expanded="false">Refund</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#layby-cancel" aria-expanded="false">Cancel</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#layby-cancellation-refund" aria-expanded="false">Cancellation Refund</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#layby-completed" aria-expanded="false">Completed</a>
                  </li>
               </ul>
            </div>
         </div>
         <div class="tab-content">
            <div class="tab-pane active show" id="layby-contract" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
               <form class="filterLaybyContract">
                  <section class="mb-1 filter-bar">
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="stores" class="form-control form-select purchase-search">
                              <option value="0">New Contract: All</option>
                           </select>
                        </span>
                     </div>
                     <div class="filter-bar-item" style="flex-grow:1;">
                        <span>
                           <input type="text" placeholder="Search" name="search" class="form-control purchase-search searchDtField" value="">
                           <div class="form-control-position">
                              <i class="fa fa-search"></i>
                           </div>
                        </span>
                     </div>
                     <div class="filter-bar-item">
                        <span><button type="button" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                     </div>
                     <div class="filter-bar-item border-side-right"></div>
                     <div class="filter-bar-item filter-bar-last pl-2">
                        <span>
                           <a href="<?= base_url('layby/add_contract');?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
                           <span class="dropdown">
                           <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-h"></i></button>
                              <span aria-labelledby="#btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right" style="top:185px;">
                              <a href="#" class="dropdown-item"><i class="fa fa-info-circle"></i> Things i can do</a>
                              <a href="#" class="dropdown-item"><i class="fa fa-print"></i> Print </a>
                              <a href="#" class="dropdown-item"><i class="fa fa-download"></i> Download</a>
                              <a href="#" class="dropdown-item"><i class="fa fa-question-circle-o"></i> Help</a>
                              </span>
                           </span>
                        </span>
                     </div>
                  </section>
               </form>
               <div class="card card-content collapse show">
                  <div class="card-body card-dashboard">
                     <section id="configuration">
                        <div class="row">
                           <div class="col-12">
                              <div class="card">
                                 <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                       <table id="layby-contract-dt" class="table table-striped table-bordered">
                                          <thead>
                                             <tr>
                                                <th>S/N</th>
                                                <th>Lay-Bye ID</th>
                                                <th>Customer Name</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Balance</th>
                                                <th>Amount</th>
                                                <th>Action</th>
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
            <div role="tabpanel" class="tab-pane" id="layby-payment" aria-labelledby="activeIcon12-tab1" aria-expanded="true">
              <section class="mb-1 filter-bar">
                  <div class="filter-bar-item" style="flex-grow:1;">
                     <span>
                        <input type="text" placeholder="Search" name="search" class="form-control purchase-search searchDtField" value="">
                        <div class="form-control-position">
                           <i class="fa fa-search"></i>
                        </div>
                     </span>
                  </div>
                  <div class="filter-bar-item">
                     <span><button type="button" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                  </div>
                  <div class="filter-bar-item border-side-right"></div>
                  <div class="filter-bar-item filter-bar-last pl-2">
                     <span>
                       <span class="dropdown">
                        <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-h"></i></button>
                           <span aria-labelledby="#btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right" style="top:185px;">
                           <a href="#" class="dropdown-item"><i class="fa fa-info-circle"></i> Things i can do</a>
                           <a href="#" class="dropdown-item"><i class="fa fa-print"></i> Print </a>
                           <a href="#" class="dropdown-item"><i class="fa fa-download"></i> Download</a>
                           <a href="#" class="dropdown-item"><i class="fa fa-question-circle-o"></i> Help</a>
                           </span>
                        </span>
                     </span>
                  </div>
               </section>
               <div class="card card-content collapse show">
                  <div class="card-body card-dashboard">
                     <section id="configuration" >
                        <div class="row">
                           <div class="col-12">
                              <div class="card">
                                 <div class="card-content collapse show">
                                    <div class="card-body card-dashboard" >
                                       <table id="layby-payment-dt" class="table table-striped table-bordered">
                                          <thead>
                                             <tr>
                                                <th>S/N</th>
                                                <th>Lay-Bye ID</th>
                                                <th>Customer Name</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Date</th>
                                                <th>Balance</th>
                                                <th>Action</th>
                                             </tr>
                                          </thead>
                                          <tbody></tbody>
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
            <div class="tab-pane" id="layby-refund" role="tabpanel" aria-labelledby="dropdownOptIcon21-tab1" aria-expanded="false">
               <section class="mb-1 filter-bar">
                  <div class="filter-bar-item" style="flex-grow:1;">
                     <span>
                        <input type="text" placeholder="Search" name="search" class="form-control purchase-search searchDtField" value="">
                        <div class="form-control-position">
                           <i class="fa fa-search"></i>
                        </div>
                     </span>
                  </div>
                  <div class="filter-bar-item">
                     <span><button type="button" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                  </div>
                  <div class="filter-bar-item border-side-right"></div>
                  <div class="filter-bar-item filter-bar-last pl-2">
                     <span>
                       <span class="dropdown">
                        <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-h"></i></button>
                           <span aria-labelledby="#btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right" style="top:185px;">
                           <a href="#" class="dropdown-item"><i class="fa fa-info-circle"></i> Things i can do</a>
                           <a href="#" class="dropdown-item"><i class="fa fa-print"></i> Print </a>
                           <a href="#" class="dropdown-item"><i class="fa fa-download"></i> Download</a>
                           <a href="#" class="dropdown-item"><i class="fa fa-question-circle-o"></i> Help</a>
                           </span>
                        </span>
                     </span>
                  </div>
               </section>
               <div class="card card-content collapse show">
                  <div class="card-body card-dashboard">
                     <div class="status-div">
                        <span class="active-span"></span><span> Active</span>   
                        <span class="inactive-span"> </span><span> Inactive</span>
                     </div>
                     <section id="configuration">
                        <div class="row">
                           <div class="col-12">
                              <div class="card">
                                 <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                       <table id="layby-refund-dt" class="table table-striped table-bordered">
                                          <thead>
                                             <tr>
                                                <th>S/N</th>
                                                <th>Lay-Bye ID</th>
                                                <th>Customer Name</th>
                                                <th>Phone</th>
                                                <th>Date</th>
                                                <th>Cancelled</th>
                                                <th>Parcels</th>
                                                <th>Location</th>
                                                <th>Default</th>
                                                <th>Amount</th>
                                                <th>Balance</th>
                                                <th>Status</th>
                                                <th>Action</th>
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
            <div class="tab-pane" id="layby-cancel" role="tabpanel" aria-labelledby="dropdownOptIcon21-tab1" aria-expanded="false">
               <section class="mb-1 filter-bar">
                  <div class="filter-bar-item" style="flex-grow:1;">
                     <span>
                        <input type="text" placeholder="Search" name="search" class="form-control purchase-search searchDtField" value="">
                        <div class="form-control-position">
                           <i class="fa fa-search"></i>
                        </div>
                     </span>
                  </div>
                  <div class="filter-bar-item">
                     <span><button type="button" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                  </div>
                  <div class="filter-bar-item border-side-right"></div>
                  <div class="filter-bar-item filter-bar-last pl-2">
                     <span>
                       <span class="dropdown">
                        <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-h"></i></button>
                           <span aria-labelledby="#btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right" style="top:185px;">
                           <a href="#" class="dropdown-item"><i class="fa fa-info-circle"></i> Things i can do</a>
                           <a href="#" class="dropdown-item"><i class="fa fa-print"></i> Print </a>
                           <a href="#" class="dropdown-item"><i class="fa fa-download"></i> Download</a>
                           <a href="#" class="dropdown-item"><i class="fa fa-question-circle-o"></i> Help</a>
                           </span>
                        </span>
                     </span>
                  </div>
               </section>
               <div class="card card-content collapse show">
                  <div class="card-body card-dashboard">
                     <div class="status-div">
                        <span class="active-span"></span><span> Active</span>   
                        <span class="inactive-span"> </span><span> Inactive</span>
                     </div>
                     <section id="configuration">
                        <div class="row">
                           <div class="col-12">
                              <div class="card">
                                 <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                       <table id="layby-cancel-dt" class="table table-striped table-bordered">
                                          <thead>
                                             <tr>
                                                <th>S/N</th>
                                                <th>Lay-Bye ID</th>
                                                <th>Customer Name</th>
                                                <th>Phone</th>
                                                <th>Date</th>
                                                <th>Cancelled</th>
                                                <th>Parcels</th>
                                                <th>Location</th>
                                                <th>Default</th>
                                                <th>Amount</th>
                                                <th>Balance</th>
                                                <th>Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <tr>
                                             </tr>
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
            <div class="tab-pane" id="layby-cancellation-refund" role="tabpanel" aria-labelledby="dropdownOptIcon21-tab1" aria-expanded="false">
               <section class="mb-1 filter-bar">
                  <div class="filter-bar-item" style="flex-grow:1;">
                     <span>
                        <input type="text" placeholder="Search" name="search" class="form-control purchase-search searchDtField" value="">
                        <div class="form-control-position">
                           <i class="fa fa-search"></i>
                        </div>
                     </span>
                  </div>
                  <div class="filter-bar-item">
                     <span><button type="button" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                  </div>
                  <div class="filter-bar-item border-side-right"></div>
                  <div class="filter-bar-item filter-bar-last pl-2">
                     <span>
                       <span class="dropdown">
                        <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-h"></i></button>
                           <span aria-labelledby="#btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right" style="top:185px;">
                           <a href="#" class="dropdown-item"><i class="fa fa-info-circle"></i> Things i can do</a>
                           <a href="#" class="dropdown-item"><i class="fa fa-print"></i> Print </a>
                           <a href="#" class="dropdown-item"><i class="fa fa-download"></i> Download</a>
                           <a href="#" class="dropdown-item"><i class="fa fa-question-circle-o"></i> Help</a>
                           </span>
                        </span>
                     </span>
                  </div>
               </section>
               <div class="card card-content collapse show">
                  <div class="card-body card-dashboard">
                     <div class="status-div">
                        <span class="active-span"></span><span> Active</span>   
                        <span class="inactive-span"> </span><span> Inactive</span>
                     </div>
                     <section id="configuration">
                        <div class="row">
                           <div class="col-12">
                              <div class="card">
                                 <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                       <table id="layby-cancel-refund" class="table table-striped table-bordered">
                                          <thead>
                                             <tr>
                                                <th>S/N</th>
                                                <th>Lay-Bye ID</th>
                                                <th>Customer Name</th>
                                                <th>Phone</th>
                                                <th>Date</th>
                                                <th>Cancelled</th>
                                                <th>Parcels</th>
                                                <th>Location</th>
                                                <th>Default</th>
                                                <th>Amount</th>
                                                <th>Balance</th>
                                                <th>Action</th>
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
            <div class="tab-pane" id="layby-completed" role="tabpanel" aria-expanded="false">
               <form class="filterLaybyCompleted">
                  <section class="mb-1 filter-bar">
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="stores" class="form-control form-select purchase-search">
                              <option value="0">New Contract: All</option>
                           </select>
                        </span>
                     </div>
                     <div class="filter-bar-item" style="flex-grow:1;">
                        <span>
                           <input type="text" placeholder="Search" name="search" class="form-control purchase-search searchDtField" value="">
                           <div class="form-control-position">
                              <i class="fa fa-search"></i>
                           </div>
                        </span>
                     </div>
                     <div class="filter-bar-item">
                        <span><button type="button" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                     </div>
                     <div class="filter-bar-item border-side-right"></div>
                  </section>
               </form>
               <div class="card card-content collapse show">
                  <div class="card-body card-dashboard">
                     <section>
                        <div class="row">
                           <div class="col-12">
                              <div class="card">
                                 <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                       <table id="layby-completed-dt" class="table table-striped table-bordered">
                                          <thead>
                                             <tr>
                                                <th>S/N</th>
                                                <th>Lay-Bye ID</th>
                                                <th>Customer Name</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Balance</th>
                                                <th>Action</th>
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
      </div>
   </div>
</div>
</div>
<!--Add Payment Model Start -->         
<div class="modal fade text-left" id="add-payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><b>Add Payment Amount</b></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <p class="text-info"><span id="pInfoId">LAY-354895</span></p>
            <p style="font-weight: 600;"><span id="pInfoCustomer">DollarSmart</span></p>
            <p><i class="feather ft-phone"></i>&nbsp;<span id="pInfoPhone"> (684) 555-0102 </span></p>
            <p><i class="feather ft-map-pin"></i>&nbsp;<span id="pInfoAddress">2972 Westheimer Rd.Santa Ana,Illinois 85486</span></p>
            <br>
            <div class="row">
               <div class="col-md-12">
                  <div class="d-flex">
                     <fieldset class="tender_media">
                        <input type="radio" name="layby_pay_type" value="1" class="inp-radio" id="input-radio-11" checked>
                        <label for="input-radio-11">Cash</label>
                     </fieldset>
                     <fieldset class="tender_media">
                        <input type="radio" name="layby_pay_type" value="2" class="inp-radio" id="input-radio-12">
                        <label for="input-radio-12">Credit Card</label>
                     </fieldset>
                     <fieldset class="tender_media">
                        <input type="radio" name="layby_pay_type" value="3" class="inp-radio" id="input-radio-13">
                        <label for="input-radio-13">Cheque</label>
                     </fieldset>
                     <fieldset class="tender_media">
                        <input type="radio" name="layby_pay_type" value="4" class="inp-radio" id="input-radio-14">
                        <label for="input-radio-14">Gift Voucher</label>
                     </fieldset>
                  </div><br>
               </div>
               <div class="col-md-4">
                  <span class="f-20" id="pInfoAmount">$925.05</span><br>
                  <span>Full Amount</span>
               </div>
               <div class="col-md-4">
                  <span class="f-20" id="pInfoBalance">$808.05</span><br>
                  <span>Paid Amount</span>
               </div>
               <div class="col-md-4 text-right">
                  <div class="form-floating">
                     <input type="hidden" id="pContractId">
                     <input type="hidden" id="pTxnType" value="1"> 
                     <input type="text" class="form-control" id="pPayAmount" placeholder="123..." value="">
                     <label>Amount*</label>
                  </div>
                  <span>Amount to Pay</span>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"> <i class="fa fa-close"></i>&nbsp;Cancel</button>
               <button type="button" class="btn btn-info" data-type="p" id="addLaybyAmounts">Submit</button>
            </div>
         </div>
      </div>
   </div>
</div>
<!--Add Payment Model End-->
<!--Add Refund Model Start -->         
<div class="modal fade text-left" id="add-refunds" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true" style="top:10%;">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content" >
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><b>Add Refund Amount</b></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <p>
               <span class="text-info" id="rInfoId">LAY-054789</span><br/>
               <span style="font-weight:600;color:#000;" id="rInfoCustomer">The Authentic Corner</span>
            </p>
            <p><i class="feather ft-phone"></i>&nbsp;<span id="rInfoPhone"> (684) 555-0108</span></p>
            <p><i class="feather ft-map-pin"></i>&nbsp;<span id="rInfoAddress"></span></p>
            <br>
            <div class="row">
               <div class="col-md-4">
                  <span style="font-weight:500;color:#000;" class="f-20" id="rInfoAmount">$925.05</span><br>
                  <span>Full Amount</span>
               </div>
               <div class="col-md-4">
                  <span style="font-weight:500;color:#000;" class="f-20" id="rInfoBalance">$808.05</span><br>
                  <span>Remaining Amount</span>
               </div>
               <div class="col-md-4 text-right">
                   <div class="form-floating">
                     <input type="hidden" id="rContractId">
                     <input type="hidden" id="rTxnType" value="2">
                     <input type="text" id="rPayAmount" class="form-control" placeholder="Enter Amount" value="">
                     <label for="floatingSelectGrid">Amount*</label>
                  </div>
                  <span>Refund Amount</span>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default_new"> <i class="fa fa-close"></i> Cancel</button>
               <button type="button" class="btn btn-info" data-type="r" id="addLaybyAmounts"> Submit</button>
            </div>
         </div>
      </div>
   </div>
</div>
<!--Add Refund Model End-->  
<!--Add Cancel Model Start -->         
<div class="modal fade text-left" id="add-cancel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><b>Add Cancel Amount</b></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <p>
               <span class="text-info" id="cInfoId">LAY-054789</span><br/>
               <span style="font-weight:600;color:#000;" id="cInfoCustomer">The Authentic Corner</span>
            </p>
            <p><i class="feather ft-phone"></i>&nbsp;<span id="cInfoPhone"> (684) 555-0108</span></p>
            <p><i class="feather ft-map-pin"></i>&nbsp;<span id="cInfoAddress"></span></p>
            <br>
            <div class="row">
               <div class="col-md-4">
                  <span style="font-weight:500;color:#000;" class="f-20" id="cInfoAmount">$925.05</span><br>
                  <span>Full Amount</span>
               </div>
               <div class="col-md-3">
                  <span style="font-weight:500;color:#000;" class="f-20" id="cInfoBalance">$808.05</span><br>
                  <span>Balance</span>
               </div>
               <div class="col-md-5 text-right" >
                  <div class="form-floating">
                     <input type="hidden" id="cContractId">
                     <input type="hidden" id="cTxnType" value="3">
                     <input type="text" class="form-control" id="cPayAmount" placeholder="123..." readonly value="0004" >
                     <label for="floatingSelectGrid">Amount*</label>
                  </div>
                   <span>Cancellation Amount</span>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"> <i class="fa fa-close"></i> Cancel</button>
               <button type="button" class="btn btn-info" data-type="c" id="addLaybyAmounts"> Submit</button>
            </div>
         </div>
      </div>
   </div>
</div>
<!--Add Cancel Model End-->
<!--Add Cancel Refund Model Start -->         
<div class="modal fade text-left" id="add-cancel-refund" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><b>Add Cancellation Refund Amount</b></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <span class="text-info" id="crInfoId">LAY-054789</span><br/>
            <span style="font-weight:600;color:#000;" id="crInfoCustomer">The Authentic Corner</span>
            <p><i class="feather ft-phone"></i>&nbsp;<span id="crInfoPhone"> (684) 555-0108</span></p>
            <p><i class="feather ft-map-pin"></i>&nbsp;<span id="crInfoAddress"></span></p>
            <br><br>
            <div class="row">
               <div class="col-md-4">
                  <span style="font-weight:500;color:#000;" class="f-20" id="crInfoAmount">$925.05</span><br>
                  <span>Full Amount</span>
               </div>
               <div class="col-md-4">
                  <span style="font-weight:500;color:#000;" class="f-20" id="crInfoBalance">$808.05</span><br>
                  <span>Balance</span>
               </div>
               <div class="col-md-4 text-right">
                 <div class="form-floating">
                     <input type="hidden" id="crContractId">
                     <input type="hidden" id="crTxnType" value="4">
                     <input type="text" class="form-control" id="crPayAmount" placeholder="123..." readonly value="0004" >
                     <label for="floatingSelectGrid">Amount*</label>
                  </div>
                  <span>Refund Amount</span>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"> <i class="fa fa-close"></i> Cancel</button>
               <button type="button" class="btn btn-info" data-type="cr" id="addLaybyAmounts"> Submit</button>
            </div>
         </div>
      </div>
   </div>
</div>
<!--Add Cancel Refund Model End-->  