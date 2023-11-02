<style>
    .table1 td, .table1 th{
    padding: 0.75rem;
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
                  <a class="nav-link active" id="activeIcon12-tab1" data-toggle="tab" href="#customer-list" aria-controls="activeIcon12" aria-expanded="true">Customers List</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#gift-cards" aria-controls="linkIcon12" aria-expanded="false">Gift Cards</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#loyalty-points" aria-controls="linkIcon12" aria-expanded="false">Loyalty Points</a>
               </li>
            </ul>
         </div>
      </div>
      <div class="tab-content ">
         <div role="tabpanel" class="tab-pane active show" id="customer-list" aria-labelledby="activeIcon12-tab1" aria-expanded="true">
               <form class="filterCustomer">
            <section class="mb-1 filter-bar">
               <div class="filter-bar-item f-12">
                  <span>
                     <select name="equal[status]" class="form-control form-select purchase-search">
                        <option value="">Customers: All</option>
                        <option value="1">Active</option>
                        <option value="2">Deactive</option>
                     </select>
                  </span>
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
                  <span><button type="button" id="csubmit" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
               </div>
            
               <div class="filter-bar-item border-side-right"></div>
               <div class="filter-bar-item filter-bar-last pl-2">
                  <span>
                     <button type="button" class="btn btn-outline-info btn-sm import-customers mr-15" ><i class="fa fa-file-import"></i></button>
                     <a href="<?= base_url("customers/add_customer")?>" class="btn btn-info btn-sm mr-15"><i class="fa fa-plus"></i> Add New</a>
                     <!-- <span class="dropdown">
                        <i id="btnSearchDrop1" class="fa fa-ellipsis-h" ></i>
                        <span aria-labelledby="#btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right">
                        <a href="#" class="dropdown-item"><i class="fa fa-info-circle"></i> Things i can do</a>
                        <a href="#" class="dropdown-item"><i class="fa fa-print"></i> Print </a>
                        <a href="#" class="dropdown-item"><i class="fa fa-download"></i> Download</a>
                        <a href="#" class="dropdown-item"><i class="fa fa-question-circle-o"></i> Help</a>
                        </span>
                     </span> -->
                  </span>
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
                                    <table id="customer-tbl" class="table1 table-bordered table-striped ">
                                       <!-- table-striped table-bordered  -->
                                       <thead>
                                          <tr>
                                             <th class="text-left">Account ID</th>
                                             <th class="text-left">TPIN No.</th>
                                             <th class="text-left">LPO No.</th>
                                             <th class="text-left">ID No.</th>
                                             <th class="text-left">Registered</th>
                                             <th class="text-left">Amount</th>
                                             <th class="text-left">Email</th>
                                             <th class="text-left">Phone</th>
                                             <th class="text-left">Loyalty</th>
                                             <th class="text-left">Action</th>
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
         <div class="tab-pane" id="gift-cards" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
            <form class="filterGiftcards">
               <section class="mb-1 filter-bar">
                     <div class="filter-bar-item f-12">
                        <span>
                          
                            <select name="equal[batch_id]" class="form-control form-select purchase-search">
                           <option value="">Batch: All</option>
                           <?php
                              if(isset($data['giftcards'])){
                                 foreach($data['giftcards'] as $row){
                                    ?>
                              <option value="<?= $row['id']?>"><?= $row['batch_name']?></option>
                              <?php
                                    }
                                 }
                               ?>
                        </select>
                        </span>
                     </div>
                     <div class="filter-bar-item f-12">
                        <span>
                             <select name="equal[status]" class="form-control form-select purchase-search">
                                 <option value="">All</option>
                                 <option value="1">Active</option>
                                 <option value="2">Deactive</option>
                              </select>
                        </span>
                     </div>
                     <div class="filter-bar-item" style="flex-grow:1;">
                        <span>
                           <input type="text" placeholder="Search" name="match[search]" class="form-control purchase-search searchDtField" value="">
                           <div class="form-control-position">
                              <i class="fa fa-search"></i>
                           </div>
                        </span>
                     </div>
                     <div class="filter-bar-item">
                        <span><button type="button" id="giftcardbtn" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                     </div>
                     <div class="filter-bar-item border-side-right"></div>
                     <div class="filter-bar-item filter-bar-last pl-2">
                        <span>
                           <button type="button" class="btn btn-outline-info btn-sm import-customers mr-15"><i class="fa fa-download"></i></button>
                           <a href="<?= base_url("customers/add_gift_card")?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
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
                                    <table id="gift-card-table" class="table table-bordered table-striped ">
                                       <thead>
                                          <tr>
                                             <th>Card No.</th>
                                             <th>Batch</th>
                                             <th>Amount</th>
                                             <th>Balance</th>
                                             <th>Expiry Date</th>
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
         <div class="tab-pane" id="loyalty-points" role="tabpanel" aria-labelledby="dropdownOptIcon21-tab1" aria-expanded="false">
            <div class="card card-content collapse show">
               <div class="card-body card-dashboard">
                     <?php $value = isset($data['loyalty_points'])?$data['loyalty_points']:"";?>
                  <form method="post" id="loyalty_form" name="loyalty_form">
                         <input type="hidden" name="action" id="action" value="post_data">
                            <input type="hidden" name="table_name" id="table_name" value="loyaltypoints">
                            <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                     <div class="row">
                        <div class="col-12">
                           <div class="card">
                              <div class="card-content collapse show">
                                 <div class="card-body card-dashboard">
                                    <div class="row g-4">
                                       <div class="col-md">
                                          <div class="form-floating">
                                            <select class="form-select" id="loyalty_system" name="loyalty_system" aria-label="Floating label select example">
                                                <option value="1">Loyalty Point</option>
                                                <option value="2" >Loyalty Amount</option>
                                            </select>
                                             <label for="floatingSelectGrid">Loyalty System</label>
                                          </div>
                                       </div>
                                       <div class="col-md">
                                          <div class="form-floating">
                                             <input type="text" class="form-control" name="bill_amount_to_earn" id="bill_amount_to_earn" placeholder="Bill Amount" value="" >
                                             <label for="floatingSelectGrid">Bil amount to earn 1 point*</label>
                                          </div>
                                       </div>
                                       <div class="col-md point_in_amount">
                                          <div class="form-floating">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="point_in_amount" placeholder="Point in Amount" name="point_in_amount" value="" ><label for="point_in_amount">Point in Amount*</label>                       
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md">
                                          <div class="form-floating">
                                             <div class="form-floating">
                                                <input type="number" class="form-control" id="minimum_redeem" placeholder="Minimun Redeem" value="" name="minimum_redeem">
                                                <label for="floatingSelectGrid">Minimun Redeem*</label>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="form-footer text-right">
                        <?= SubmitButton();?>
                     </div>
                  </form>
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
               <form method="POST" action="#" id="import_customer_form" name="import_customer_form" enctype="multipart/form-data">
                  <div class="modal-body">
                     <div class="uploadOuter-2">
                        <div class="uploadOuter">
                           <div class="row">
                              <div class="col-md-5">
                                 <span class="dragBox" style="line-height: 35px;">
                                 <span><i class="fa fa-cloud-upload" style="font-size: 30px;color: #a2a2a2"></i></span><br/>
                                 <span>Drag and Drop Files Here</span>
                                 <input type="file" name="file" onChange="dragNdrop(event)" ondragover="drag()" ondrop="drop()" id="uploadFile"/>
                                 </span>
                              </div>
                              <div class="col-md-2 pt-2">
                                 <strong>OR</strong>
                              </div>
                              <div class="col-md-5">
                                 <label for="uploadFile" class="btn btn-outline-info"><i class="fa fa-plus"></i>Browse Files</label>
                                 <p>Supported upto to 25 MB</p>
                              </div>
                           </div>
                        </div>
                        <!-- <div id="preview"></div> -->
                     </div>
                     <div class="row p-1">
                        <div class="col-md-6">
                           <a href="javascript:void(0);" id="downloadFormat" class="text-left storeColor"><i class="fa fa-cloud-arrow-down"></i> Download Format</a>
                        </div>
                        <div class="col-md-6 text-right">
                           <button type="submit" class="btn btn-sm btn-info"> <i class="fa fa-file-o"></i> Submit</button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Model End-->           
   </div>
</div>
