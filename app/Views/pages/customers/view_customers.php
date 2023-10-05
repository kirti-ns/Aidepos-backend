<div class="app-content content">
   <div class="content-wrapper">
      <?= view('includes/breadcrumb.php');?> 
      <div class="content-body">
            <div class="row">
               <div class="card-body">
                     <h4 class="text-muted"><?= $data['customer']['registerd_name'];?></h4>
                     <!-- Icon Tab with bottom line -->
                     <div class="">
                        <ul class="nav nav-tabs navigate-tabs nav-underline nav-justified mb-1" id="tab-bottom-line-drag">
                           <li class="nav-item">
                              <a class="nav-link active" id="activeIcon12-tab1" data-toggle="tab" href="#transaction" aria-controls="activeIcon12" aria-expanded="true">Transactions</a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#statement" aria-controls="linkIcon12" aria-expanded="false">Statement</a>
                           </li>
                        </ul>
                     </div>
                  <div class="tab-content">
                     <div role="tabpanel" class="tab-pane active show" id="transaction" aria-labelledby="activeIcon12-tab1" aria-expanded="true">
                        <section class="mb-1">
                           <form class="filterCustomerview">
                              <div class="row">
                                <div class="col-md-2 pr-0">
                                    <select name="equal[status]" class="form-control form-select purchase-search">
                                       <option value="">Status</option>
                                       <option value="1">Active</option>
                                       <option value="2">Deactive</option>
                                    </select>
                                 </div>
                                 <div class="col-md-2">
                                    <select name="payment_by" class="form-control form-select purchase-search">
                                       <option value="0">Payment By</option>
                                    </select>
                                 </div>
                                 <div class="filter-bar-item" style="flex-grow:1;">
                                    <span>
                                       <input type="text" placeholder="Search" name="match[search]" class="form-control purchase-search searchDtField">
                                       <div class="form-control-position">
                                          <i class="fa fa-search"></i>
                                       </div>
                                    </span>
                                 </div>
                                 <div class="filter-bar-item">
                                    <span><button type="button" id="transactionbtn" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                                 </div>
                                 <div class="col-md-2">
                                    <div class="heading-elements">
                                       <!-- <a href="customers_view.php" class="btn btn-info btn-sm mr-15"><i class="fa fa-plus"></i> Add </a> -->
                                       <span class="dropdown">
                                         <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-h"></i></button>
                                          <span aria-labelledby="btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right">
                                             <a href="#" class="dropdown-item"><i class="fa fa-info-circle"></i> Things i can do</a>
                                             <a href="#" class="dropdown-item"><i class="fa fa-print"></i> Print </a>
                                             <a href="#" class="dropdown-item"><i class="fa fa-download"></i> Download</a>
                                             <a href="#" class="dropdown-item"><i class="fa fa-question-circle-o"></i> Help</a>
                                          </span>
                                       </span>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </section>
                        <div class="card card-content collapse show">
                           <div class="card-body card-dashboard">
                              <div class="status-div">
                                 <span class="paid-span"></span><span> Paid</span>   
                                 <span class="unpaid-span"></span><span> Unpaid</span>
                                 <span class="overdue-span"></span><span> OverDue</span>
                              </div>
                              <section id="configuration">
                                 <div class="row">
                                    <div class="col-12">
                                       <div class="card">
                                          
                                                <table id="view-customer-table" class="table table-striped table-bordered">
                                                   <thead>
                                                      <tr>
                                                         <th>Invoice ID</th>
                                                   <th>Order No.</th>
                                                   <th>Due Date</th>
                                                   <th>Amount</th>
                                                   <th>Balance Due</th>
                                                   <th>Date</th>
                                                   <th>Status</th>
                                                   <!-- <th>Action</th> -->
                                                    </tr>
                                                   </thead>
                                                   <tbody>
                                                     
                                                   </tbody>
                                                </table>
                                             </div>
                                         
                                    </div>
                                 </div>
                              </section>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane" id="statement" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
                        <section class="mb-1">
                           <form>
                              <div class="row">
                                 <div class="col-md-2 pr-0">
                                    <input type="date" name="" placeholder="This Month" class="form-control purchase-search">
                                 </div>
                                 <div class="col-md-10">
                                    <div class="row">
                                       <div class="col-md-3">
                                          <select name="stores" class="form-control form-select purchase-search">
                                             <option value="0">Filter by:All</option>
                                          </select>
                                       </div>
                                       <div class="col-md-7 border-side-right"></div>
                                       <div class="col-md-2">
                                          <div class="heading-elements">
                                          
                                             <button type="button" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add </button>
                                             <span class="dropdown">
                                                <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default_new btn-sm dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-h"></i></button>
                                                <span aria-labelledby="btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right">
                                                   <a href="#" class="dropdown-item"><i class="fa fa-info-circle"></i> Things i can do</a>
                                                   <a href="#" class="dropdown-item"><i class="fa fa-print"></i> Print </a>
                                                   <a href="#" class="dropdown-item"><i class="fa fa-download"></i> Download</a>
                                                   <a href="#" class="dropdown-item sendmail"><i class="fa fa-envelope"></i> Send Email</a>
                                                   <a href="#" class="dropdown-item"><i class="fa fa-question-circle-o"></i> Help</a>
                                                </span>
                                             </span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 
                                 
                              </div>
                           </form>
                        </section>
                        <span class="text-bold-600">Statement of Accounts</span> <span>01 Jul 2022 to 31 Jul 2022</span>
                        <hr>
                        <p style="margin-bottom: 0px;">To <span style="    float: right;">AIDPOS</span></p>
                        <p class="text-bold-600">Amrut Disti Pvt Ltd<span style="float: right;">USA</span></p>
                        <p>Account Summary</p>
                        <div class="border-bottom account-summary-div pb-1">
                           <div class=" pl-1 border-left-info border-left-3 ">
                              <div class="account-summary">
                                 <span>Opening Balance <span class="summary-amount"><b>$0.00</b></span></span> <span>Invoice Amount <span class="summary-amount"><b>$657.87</b></span></span> <span>Amount Received <span class="summary-amount "><b>$657.87</b></span></span>   
                              </div>
                           </div>
                        </div>
                        <div class="pl-1 pb-1 account-summary account-summary-div">
                           <span>Balance Due  <span class="summary-amount"><b>$0.00</b></span></span>   
                        </div>
                        <div class="card card-content collapse show">
                           <div class="ard-dashboard">
                              <table class="table table-striped table-bordered ">
                                 <thead>
                                    <tr>
                                       <th>Date</th>
                                       <th>Transactions</th>
                                       <th>Details</th>
                                       <th>Amount</th>
                                       <th>Payments</th>
                                       <th>Balance</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td style="font-size: 13px;">13 Jul,2022</td>
                                       <td >** Opening Balance**</td>
                                       <td>-</td>
                                       <td>$400.89</td>
                                       <td>1212</td>
                                       <td>$500</td>
                                    </tr>
                                    <tr>
                                       <td style="font-size: 13px;">13 Jul,2022</td>
                                       <td >Invoice</td>
                                       <td>-</td>
                                       <td>$100</td>
                                       <td>-</td>
                                       <td>$400.45</td>
                                    </tr>
                                    <tr>
                                       <td class="text-right" colspan="5">Balance Due
                                       </td>
                                       <td><b>$855.80</b></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            
            <!-- Model Start -->         
            <div class="modal fade text-left" id="import-customers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
               <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel18">Import Customers</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <div class="uploadOuter">
                           <div class="row">
                              <div class="col-md-5">
                                 <span class="dragBox" >
                                    <span><i class="fa fa-cloud-upload"></i></span>
                                    <span>Darg and Drop Files Here</span>
                                    <input type="file" onChange="dragNdrop(event)"  ondragover="drag()" ondrop="drop()" id="uploadFile"  />
                                 </span>
                              </div>
                              <div class="col-md-2 p-2">
                                 <strong>OR</strong>
                              </div>
                              <div class="col-md-5">
                                 <label for="uploadFile" class="btn btn-outline-info"><i class="fa fa-plus"></i>  Browse Files</label>
                                 <p>Supported upto to 25 MB</p>
                              </div>
                           </div>
                           <!-- <div id="preview"></div> -->
                        </div>
                        <div class="modal-footer">
                           <a href=""><i class="fa fa-download"></i> Download Format</a>
                           <button type="button" class="btn btn-info"> <i class="fa fa-file-o"></i> Submit</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Model End-->  
            <!--statement Model Start -->         
            <div class="modal fade text-left" id="preview-statement" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
               <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel18">Preview</h4>
                        <div>
                           <a href="" class="btn btn-outline-info mr-1"><i class="fa fa-print"></i> Print</a>

                           <button type="button" class="btn btn-info import-customers"> <i class="fa fa-download"></i> Download</button>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                     </div>
                     <div class="modal-body">
                        <p style="margin-bottom: 0px;">To <span style="float: right;">AIDPOS</span></p>
                        <p class="text-bold-600">Amrut Disti Pvt Ltd<span style="float: right;">USA</span></p>
                        <div class="row">
                           <div class="col-md-7">
                              <div class="border-bottom border-top">
                                 <span class="text-bold-600">Statement of Accounts</span>
                                 <span>01 Jul 2022 to 31 Jul 2022</span>
                              </div>
                           </div>
                           <div class="col-md-5">
                              <div class="border-bottom border-top bg-default">
                                 <b> &nbsp;Account Summary</b>
                              </div>
                              <div class="border-bottom account-summary-div pb-1 pt-1">
                                 <div class=" pl-1 border-left-info border-left-3 ">
                                    <div class="account-summary">
                                       <span>Opening Balance <span class="summary-amount"><b>$0.00</b></span></span> <span>Invoice Amount <span class="summary-amount"><b>$657.87</b></span></span> <span>Amount Received <span class="summary-amount "><b>$657.87</b></span></span>   
                                    </div>
                                 </div>
                              </div>
                              <div class="pl-1 pb-1 account-summary account-summary-div">
                                 <span>Balance Due  <span class="summary-amount"><b>$0.00</b></span></span>   
                              </div>
                           </div>
                        </div>
                        <div class="table-responsive">
                           <table class="table ">
                              <thead class="thead-dark">
                                 <tr>
                                    <tr>
                                       <th>Date</th>
                                       <th>Transactions</th>
                                       <th>Details</th>
                                       <th>Amount</th>
                                       <th>Payments</th>
                                       <th>Balance</th>
                                    </tr>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr style="font-size: 13px;">
                                    <td>13 Jul,2022</td>
                                    <td >** Opening Balance**</td>
                                    <td>-</td>
                                    <td>$400.89</td>
                                    <td>1212</td>
                                    <td>$500</td>
                                 </tr>
                                 <tr style="font-size: 13px;">
                                    <td>13 Jul,2022</td>
                                    <td >Invoice</td>
                                    <td>-</td>
                                    <td>$100</td>
                                    <td>-</td>
                                    <td>$400.45</td>
                                 </tr>
                                 <tr>
                                    <td class="text-right" colspan="5">Balance Due
                                    </td>
                                    <td><b>$855.80</b></td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                        <!-- <div class="modal-footer">
                        </div> -->
                     </div>
                  </div>
               </div>
            </div>
            <!--statement Model End-->           
         </div>
      </div>
   </div>
