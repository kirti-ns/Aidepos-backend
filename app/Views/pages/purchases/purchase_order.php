<style type="text/css">
    .view-p-module {
        cursor: pointer;
    }
    /*Header*/
    .details-menu-bar {
        border-bottom: 1px solid #eee;
        left: 0;
        right: 0;
        background-color: #f7f7f7;
        flex-shrink: 0;
    }
    ul.details-menu-bar li {
        line-height: 0;
    }
    ul.details-menu-bar li a {
        font-size: 14px;
    }
    @media (max-width: 1550px) and (min-width: 1280px) {
        .details-menu-bar .details-menu-item,
        .column .details-menu-bar .dropdown {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }
    .details-menu-bar .details-menu-item {
        text-align: center;
        border: 0;
        border-right: 1px solid #eee;
        padding: 12px;
        background-color: #f7f7f7;
        outline: 0;
        cursor: pointer;
    }
    .details-menu-bar .details-menu-item i {
        font-size: 14px;
        margin-right: 0rem;
    }
</style>
<div class="app-content content">
   <div class="loading" style="display: none; position: fixed; left: 50%; top: 60%; z-index: 999999;">
        <img src="<?php echo base_url();?>/public/app-assets/images/loading-gif.gif" style="height: 50px; width: 50px;" alt="loader" title="loader.gif" />
   </div>
   <div class="content-wrapper">
      <div class="content-header row">
         <div class="content-header-left col-md-8 col-12 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Purchase</h3>
         </div>
      </div>
      <div class="content-body">
         <div class="row">
            <div class="col-xl-12 col-lg-12">
               <ul class="nav nav-tabs navigate-tabs nav-underline nav-justified mb-1" id="tab-bottom-line-drag">
                  <li class="nav-item">
                     <a class="nav-link active" id="activeIcon12-tab1" data-toggle="tab" href="#supplier" aria-controls="activeIcon12" aria-expanded="true">Supplier</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="activeIcon12-tab1" data-toggle="tab" href="#purchase-order" aria-controls="activeIcon12" aria-expanded="true">Purchase Order</a>
                  </li>
                  <?php if(isset($data['permission']->purchase_approvals) && $data['permission']->purchase_approvals == 1) { ?>
                  <li class="nav-item">
                     <a class="nav-link" id="activeIcon12-tab1" data-toggle="tab" href="#purchase-order-review" aria-controls="activeIcon12" aria-expanded="true">Purchase Order Review</a>
                  </li>
                  <?php } ?>
                  <li class="nav-item">
                     <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#goods-received" aria-controls="linkIcon12" aria-expanded="false">Goods Received</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#goods-returned" aria-controls="linkIcon12" aria-expanded="false">Goods Returned</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#direct-goods-received" aria-controls="linkIcon12" aria-expanded="false">Direct Goods Received</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="linkIconOpt11-tab1" data-toggle="tab" href="#back-order" aria-controls="linkIconOpt11"> Back Order</a>
                  </li>
               </ul>
            </div>
         </div>
         <!-- <div class="card">
            <div class="card-body"> -->
         <div class="tab-content ">
            <div role="tabpanel" class="tab-pane active show" id="supplier" aria-labelledby="activeIcon12-tab1" aria-expanded="true">
               <form class="filterSupplier">
                  <section class="mb-1 filter-bar">
                      <div class="filter-bar-item f-12">
                        <span>
                           <select name="status" class="form-control form-select purchase-search">
                              <option value="">Supplier: All</option>
                              <option value="1">Active</option>
                              <option value="2">Deactive</option>
                           </select>
                        </span>
                     </div>
                     <div class="filter-bar-item" style="flex-grow:1;">
                        <span>
                           <input type="text" placeholder="Search" name="search" class="form-control purchase-search suSearchDtField" value="">
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
                           <button type="button" class="btn btn-outline-info btn-sm import-customers mr-15"><i class="fa fa-download"></i></button>
                           <a href="<?= base_url("purchases/add_supplier")?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
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
                  <div class="card-body card-dashboard" >
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
                                       <table class="table table-striped table-bordered" id="supplierTbl">
                                          <thead>
                                             <tr>
                                                <th>Supplier ID</th>
                                                <th>Registered Name</th>
                                                <th>Tax Account Name</th>
                                                <th>Operator</th>
                                                <th style="text-align: left;">Email</th>
                                                <th>Phone</th>
                                                <th>Payable</th>
                                                <th>Create Date</th>
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
            <div role="tabpanel" class="tab-pane" id="purchase-order" aria-labelledby="activeIcon12-tab1" aria-expanded="true">
               <form class="filterPOrder">
                  <section class="mb-1 filter-bar">
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="supplier" class="form-control form-select purchase-search">
                              <option value="">Supplier: All</option>
                              <?php foreach($data['supplier'] as $c) { ?>
                                 <option value="<?= $c['id']; ?>"><?= $c['registered_name'] ?></option>
                              <?php } ?>
                           </select>
                        </span>
                     </div>
                     <!-- <div class="filter-bar-item f-12">
                        <span>
                           <select name="customer" class="form-control form-select purchase-search">
                              <option value="0">Customers: All</option>
                              <?php foreach($data['customer'] as $c) { ?>
                                 <option value="<?= $c['id']; ?>"><?= $c['registerd_name'] ?></option>
                              <?php } ?>
                           </select>
                        </span>
                     </div> -->
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="store" class="form-control form-select purchase-search">
                              <option value="">Stores: All</option>
                              <?php foreach($data['stores'] as $c) { ?>
                                 <option value="<?= $c['id']; ?>"><?= $c['store_name'] ?></option>
                              <?php } ?>
                           </select>
                        </span>
                     </div>
                     <!--<div class="filter-bar-item f-12">-->
                     <!--   <span>-->
                     <!--      <select name="terminal" class="form-control form-select purchase-search">-->
                     <!--         <option value="0">Terminals: All</option>-->
                     <!--      </select>-->
                     <!--   </span>-->
                     <!--</div>-->
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="paymentBy" class="form-control form-select purchase-search">
                              <option value="0">Payment By</option>
                           </select>
                        </span>
                     </div>
                     <div class="filter-bar-item" style="flex-grow:1;">
                        <span>
                           <input type="text" placeholder="Search" name="search" class="form-control purchase-search psearchDtField" value="">
                           <div class="form-control-position">
                              <i class="fa fa-search"></i>
                           </div>
                        </span>
                     </div>
                     <div class="filter-bar-item">
                        <span><button type="button" class="btn btn-outline-info btn-sm searchPoDtBtn">Search</button></span>
                     </div>
                     <div class="filter-bar-item border-side-right"></div>
                     <div class="filter-bar-item filter-bar-last pl-2">
                        <span>
                           <a href="<?= base_url("purchases/add_purchase_order")?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
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
                                       <table class="table table-striped table-bordered" id="purchaseOrderTbl">
                                          <thead>
                                             <tr>
                                                <th>Order No</th>
                                                <th>Store Name</th>
                                                <th>Supplier Name</th>
                                                <th>Date</th>
                                                <th>Due date</th>
                                                <th>Amount</th>
                                                <th>Balance Due</th>
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
            <?php if(isset($data['permission']->purchase_approvals) && $data['permission']->purchase_approvals == 1) { ?>
            <div role="tabpanel" class="tab-pane" id="purchase-order-review" aria-labelledby="activeIcon12-tab1" aria-expanded="true">
               <form class="filterReviewOrder">
                  <section class="mb-1 filter-bar">
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="customer_id" class="form-control form-select purchase-search">
                              <option value="">Purchase Order</option>
                           </select>
                        </span>
                     </div>
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="store_id" class="form-control form-select purchase-search">
                              <option value="">Stores: All</option>
                              <?php foreach($data['stores'] as $c) { ?>
                                 <option value="<?= $c['id']; ?>"><?= $c['store_name'] ?></option>
                              <?php } ?>
                           </select>
                        </span>
                     </div>
                     <div class="filter-bar-item f-12">
                        <span>
                           <input type="date" name="date" placeholder="Search" class="form-control purchase-search">
                        </span>
                     </div>
                     
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="supplier_id" class="form-control form-select purchase-search">
                              <option value="">Supplier Name</option>
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
                        <span><button type="button" class="btn btn-outline-info btn-sm searchPoRDtBtn">Search</button></span>
                     </div>
                     <div class="filter-bar-item border-side-right"></div>
                     <div class="filter-bar-item filter-bar-last pl-2">
                        <span>
                           <!--<a href="purchase_order_add.php" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>-->
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
                                       <table class="table table-striped table-bordered" id="purchaseOrderReviewTbl">
                                          <thead>
                                             <tr>
                                                <th>Order No</th>
                                                <th>Store ID</th>
                                                <th>Supplier Name</th>
                                                <th>Creation Date & Time</th>
                                                <th>Submission Date & Time</th>
                                                <th>Amount</th>
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
            <?php } ?>
            <div class="tab-pane" id="goods-received" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
               <form class="filterGoodsReceived">
                  <section class="mb-1 filter-bar">
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="supplier" class="form-control form-select purchase-search">
                              <option value="">Supplier: All</option>
                              <?php foreach($data['supplier'] as $c) { ?>
                                 <option value="<?= $c['id']; ?>"><?= $c['registered_name'] ?></option>
                              <?php } ?>
                           </select>
                        </span>
                     </div>
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="stores" class="form-control form-select purchase-search">
                              <option value="">All Stores: All</option>
                              <?php if(!empty($data['stores'])){
                                 foreach($data['stores'] as $row){
                                    ?>
                                    <option value="<?= $row['id']?>"><?= $row['store_name']?></option>
                                    <?php
                                 }
                              } ?>
                           </select>
                        </span>
                     </div>
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="location" class="form-control form-select purchase-search">
                              <option value="">Location: All</option>
                              <?php foreach($data['location'] as $c) { ?>
                                 <option value="<?= $c['id']; ?>"><?= $c['location_description'] ?></option>
                              <?php } ?>
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
                        <span><button type="button" class="btn btn-outline-info btn-sm goodReceiveDtBtn">Search</button></span>
                     </div>
                     <div class="filter-bar-item border-side-right"></div>
                     <div class="filter-bar-item filter-bar-last pl-2">
                        <span>
                           <a href="<?= base_url("purchases/add_goods_received")?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
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
                                       <table class="table table-striped table-bordered" id="goodReceiveTbl">
                                          <thead>
                                             <tr>
                                                <th>Order No</th>
                                                <th>Store Name</th>
                                                <th>Supplier Name</th>
                                                <th>Location</th>
                                                <th>Date</th>
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
            <div class="tab-pane" id="goods-returned" role="tabpanel" aria-labelledby="dropdownOptIcon21-tab1" aria-expanded="false">
               <form class="filterGoodsReturned">
                  <section class="mb-1 filter-bar">
                    <div class="filter-bar-item f-12">
                        <span>
                           <select name="supplier" class="form-control form-select purchase-search">
                              <option value="">Supplier: All</option>
                              <?php foreach($data['supplier'] as $c) { ?>
                                 <option value="<?= $c['id']; ?>"><?= $c['registered_name'] ?></option>
                              <?php } ?>
                           </select>
                        </span>
                     </div>
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="store" class="form-control form-select purchase-search">
                              <option value="">Stores: All</option>
                              <?php foreach($data['stores'] as $c) { ?>
                                 <option value="<?= $c['id']; ?>"><?= $c['store_name'] ?></option>
                              <?php } ?>
                           </select>
                        </span>
                     </div>
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="location" class="form-control form-select purchase-search">
                              <option value="">Location: All</option>
                              <?php foreach($data['location'] as $c) { ?>
                                 <option value="<?= $c['id']; ?>"><?= $c['location_description'] ?></option>
                              <?php } ?>
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
                        <span><button type="button" class="btn btn-outline-info btn-sm goodReturnDtBtn">Search</button></span>
                     </div>
                     <div class="filter-bar-item border-side-right"></div>
                     <div class="filter-bar-item filter-bar-last pl-2">
                        <span>
                           <a href="<?= base_url("purchases/add_goods_returned")?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
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
                                       <table class="table table-striped table-bordered" id="goodReturnTbl">
                                          <thead>
                                             <tr>
                                                <th>Order No</th>
                                                <th>Store Name</th>
                                                <th>Supplier Name</th>
                                                <th>Return Qty.</th>
                                                <th>Rate</th>
                                                <th>Date</th>
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
            <div class="tab-pane" id="direct-goods-received" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
               <form class="filterDirectReceived">
                  <section class="mb-1 filter-bar">
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="supplier" class="form-control form-select purchase-search">
                              <option value="">Supplier: All</option>
                              <?php foreach($data['supplier'] as $c) { ?>
                                 <option value="<?= $c['id']; ?>"><?= $c['registered_name'] ?></option>
                              <?php } ?>
                           </select>
                        </span>
                     </div>
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="stores" class="form-control form-select purchase-search">
                              <option value="">All Stores: All</option>
                              <?php if(!empty($data['stores'])){
                                 foreach($data['stores'] as $row){
                                    ?>
                                    <option value="<?= $row['id']?>"><?= $row['store_name']?></option>
                                    <?php
                                 }
                              } ?>
                           </select>
                        </span>
                     </div>
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="location" class="form-control form-select purchase-search">
                              <option value="">Location: All</option>
                              <?php foreach($data['location'] as $c) { ?>
                                 <option value="<?= $c['id']; ?>"><?= $c['location_description'] ?></option>
                              <?php } ?>
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
                        <span><button type="button" class="btn btn-outline-info btn-sm directReceiveDtBtn">Search</button></span>
                     </div>
                     <div class="filter-bar-item border-side-right"></div>
                     <div class="filter-bar-item filter-bar-last pl-2">
                        <span>
                           <a href="<?= base_url("purchases/direct_goods_received")?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
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
                                       <table class="table table-striped table-bordered" id="directGoodReceiveTbl">
                                          <thead>
                                             <tr>
                                                <th>S/N</th>
                                                <th>Store Name</th>
                                                <th>Supplier Name</th>
                                                <th>Location</th>
                                                <th>Date</th>
                                                <!-- <th>Status</th> -->
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
            <div class="tab-pane" id="back-order" role="tabpanel" aria-labelledby="linkIconOpt11-tab1" aria-expanded="false">
               <form class="filterBackOrder">
                  <section class="mb-1 filter-bar">
                      <div class="filter-bar-item f-12">
                        <span>
                           <select name="supplier" class="form-control form-select purchase-search">
                              <option value="">Supplier: All</option>
                              <?php foreach($data['supplier'] as $c) { ?>
                                 <option value="<?= $c['id']; ?>"><?= $c['registered_name'] ?></option>
                              <?php } ?>
                           </select>
                        </span>
                     </div>
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="customer" class="form-control form-select purchase-search">
                              <option value="0">Customers: All</option>
                              <?php foreach($data['customer'] as $c) { ?>
                                 <option value="<?= $c['id']; ?>"><?= $c['registerd_name'] ?></option>
                              <?php } ?>
                           </select>
                        </span>
                     </div>
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="store" class="form-control form-select purchase-search">
                              <option value="">Stores: All</option>
                           </select>
                        </span>
                     </div>
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="customer" class="form-control form-select purchase-search">
                              <option value="0">Terminals: All</option>
                           </select>
                        </span>
                     </div>
                     <div class="filter-bar-item f-12">
                        <span>
                           <select name="customer" class="form-control form-select purchase-search">
                              <option value="0">Payment By</option>
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
                        <span><button type="button" class="btn btn-outline-info btn-sm bkorderDtBtn">Search</button></span>
                     </div>
                     <div class="filter-bar-item border-side-right"></div>
                     <div class="filter-bar-item filter-bar-last pl-2">
                        <span>
                           <a href="<?= base_url("purchases/add_back_order")?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
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
                                       <table class="table table-striped table-bordered" id="backOrderTbl">
                                          <thead>
                                             <tr>
                                                <th>Order No</th>
                                                <th>Store Name</th>
                                                <th>Supplier Name</th>
                                                <th>Date</th>
                                                <th>Due date</th>
                                                <th>Amount</th>
                                                <!-- <th>Balance Due</th> -->
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
         </div>
         <!--  </div>
            </div> -->
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
            <div class="" style="padding: 1rem;">
               <a href=""><i class="fa fa-download"></i> Download Format</a>
               <button type="button" class="btn btn-info float-right"> <i class="fa fa-file-o"></i> Submit</button>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Model End-->
<div class="customizer border-left-blue-grey border-left-lighten-4 d-none d-xl-block">
    <div class="cloading" style="display: none; position: fixed; left: 50%; top: 60%; z-index: 999999;">
        <img src="<?php echo base_url();?>/public/app-assets/images/loading-gif.gif" style="height: 50px; width: 50px;" alt="loader" title="loader.gif" />
    </div>

    <!-- <a class="customizer-close" href="#"><i class="ft-x font-medium-3"></i></a> -->
    <!-- <a class="customizer-toggle box-shadow-3" href="#"><i class="ft-settings font-medium-3 spinner white"></i></a> -->
    <div class="customizer-content p-2">
        <h4 class="text-uppercase mb-0">
            <span id="v-heading"><!-- Heading --></span>
        </h4>
        <a class="customizer-close" href="#"><i class="ft-x font-medium-3"></i></a>
        <hr />
        <ul class="details-menu-bar font-small nav flex-nowrap" id="v-opt-header">
            
        </ul>
        <br />
        <div class="row mb-1" id="v-func-section">
            
        </div>
        <div class="card" id="inv-print-area">
            <!-- <div class="p-badge">
               <div class="p-badge-inner"></div>
            </div> -->
            <div class="card-body" id="inv-area">
                <div class="row">
                    <div class="col-md-6 m-details">
                        <span style="font-size: 30px;" class="module">PURCHASE ORDER</span>
                        <p>Purchase Order# <span id="v-receipt-no"></span></p>
                    </div>
                    <div class="col-md-6 text-right">
                        <h5><b>Supplier</b></h5>
                        <p id="v-supplier">
                            
                        </p>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-6">
                        <h3 id="module-title" style="text-transform: uppercase;"></h3>
                        <p>Order Date: <span id="v-module-date"></span></p>
                    </div>
                </div>
                <div class="row pt-1">
                    <div class="col-md-4">
                       <p>Payment Terms: <span id="v-pay-terms"></span></p>
                    </div>
                </div>

                <div class="row pt-2">
                    <div class="col-md-12">
                        <table class="table table-striped" id="v-module-items-tbl">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item Name</th>
                                    <th>Qty</th>
                                    <th>Rate</th>
                                    <th>Discount</th>
                                    <th style="text-align: right;">Amount</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <div style="padding: 10px 10px 3px 3px;" class="total-number-section">
                            <!-- <div class="pcs-payment-details-section">
                           <div class="pcs-label pcs-pd-section-title pcs-font-bolder">Payment Details</div>

                           <table style="width: 95%;border-collapse: collapse;table-layout: fixed;" cellspacing="0" cellpadding="0" border="0">
                             <tbody>
                               <tr>
                                 <td class="pcs-label pcs-pd-section-label">Payment Mode</td>
                                 <td class="pcs-font-bolder pcs-pd-section-value" id="v-payment-mode"></td>
                               </tr>
                             </tbody>
                           </table>
                        </div> -->
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div style="width: 70%;" class="float-right">
                            <table class="pcs-bdr-bottom" id="itemTable" cellspacing="0" border="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td valign="middle" style="padding: 10px 7px 5px;">
                                            Discount<br />
                                        </td>
                                        <td id="v-disc" valign="middle" style="width: 110px; padding: 10px 7px 10px;" class="text-align-right"></td>
                                    </tr>
                                    <tr style="height: 10px;" class="pcs-bdr-top">
                                        <td valign="middle" style="padding: 5px 7px;">Tax</td>
                                        <td valign="middle" style="width: 110px; padding: 10px 7px;" id="v-tax" class="text-align-right"></td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" style="padding: 10px 7px 5px;">
                                            Sub Total <br />
                                        </td>
                                        <td id="v-sub-total" valign="middle" style="width: 110px; padding: 10px 7px 10px;" class="text-align-right"></td>
                                    </tr>
                                    <tr style="height: 10px;" class="pcs-balance">
                                        <td valign="middle" style="padding: 10px 7px;" class="total-section-label pcs-bdr-top"><b>Total</b></td>
                                        <td id="v-total-amount" valign="middle" style="width: 110px; padding: 10px 7px;" class="text-align-right total-section-value pcs-bdr-top"><b></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" id="payment-area"></div>
        </div>
    </div>
</div>              