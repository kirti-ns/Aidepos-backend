      <div class="app-content content">
         <div class="content-wrapper">
            <div class="content-header row">
               <div class="content-header-left col-md-8 col-12 breadcrumb-new">
                  <h3 class="content-header-title mb-0 d-inline-block">Inventory</h3>
               </div>
            </div>
            <div class="content-body">
               <div class="row">
                  <!-- Icon Tab with bottom line -->
                  <div class="col-xl-12 col-lg-12">
                     <ul class="nav nav-tabs navigate-tabs nav-underline nav-justified mb-1" id="tab-bottom-line-drag">
                        <li class="nav-item">
                           <a class="nav-link active" id="linkIcon12-tab1" data-toggle="tab" href="#current-stock" aria-controls="linkIcon12" aria-expanded="false">Current Stock</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" id="activeIcon12-tab1" data-toggle="tab" href="#stock" aria-controls="activeIcon12" aria-expanded="true">Stock Movement</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="adjustment-reason-tab1" data-toggle="tab" href="#adjustment-reason" aria-controls="adjustment-reason" aria-expanded="false">Stock Adjustment Reason</a>
                        </li>
                        <?php if(isset($data['permission']->stock_adjustment) && $data['permission']->stock_adjustment == 1) { ?>
                        <li class="nav-item">
                           <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#adjustment" aria-controls="linkIcon12" aria-expanded="false">Stock Adjustments</a>
                        </li>
                        <?php } if(isset($data['permission']->stock_transfer) && $data['permission']->stock_transfer == 1) { ?> 
                        <li class="nav-item">
                           <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#transfer" aria-controls="linkIcon12" aria-expanded="false">Transfers</a>
                        </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link" id="production-tab1" data-toggle="tab" href="#production" aria-controls="production" aria-expanded="false">Pre Production</a>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="tab-content ">
                  <div class="tab-pane active show" id="current-stock" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
                     <form class="filterCurrentSTock">
                        <section class="mb-1 filter-bar">
                           <div class="filter-bar-item">
                              <span>
                                 <select name="store_id" class="form-control form-select purchase-search">
                                    <option value="">Store:All</option>
                                    <?php 
                                       if(!empty($data['store']))
                                       {
                                          foreach($data['store'] as $row)
                                          { ?>
                                             <option value="<?= $row['id']?>"><?=$row['store_name']?> </option>
                                       <?php
                                          }
                                        } 
                                       ?>
                                 </select>
                              </span>
                           </div>
                           <div class="filter-bar-item">
                              <span>
                                 <select name="location_id" class="form-control form-select purchase-search">
                                    <option value="">Location:All</option>
                                    <?php 
                                       if(!empty($data['location']))
                                       {
                                          foreach($data['location'] as $row)
                                          { ?>
                                             <option value="<?= $row['id']?>"><?=$row['location_description']?> </option>
                                       <?php
                                          }
                                        } 
                                       ?>
                                 </select>
                              </span>
                           </div>
                           <div class="filter-bar-item f-12">
                              <span>
                                 <select name="category_id" class="form-control form-select purchase-search">
                                    <option value="">Category: All</option>
                                    <?php if(isset($data['category'])){
                                       foreach($data['category'] as $row){ ?>
                                          <option value="<?= $row['id']?>"><?= $row['category_name']?></option>
                                      <?php }
                                    } ?>
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
                              <span><button type="button" class="btn btn-outline-info btn-sm  currentStockBtn">Search</button></span>
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
                     </form>
                     <div class="card card-content collapse show">
                        <div class="card-body card-dashboard">
                           <section id="configuration">
                              <div class="row">
                                 <div class="col-12">
                                    <div class="card">
                                       <div class="card-content collapse show">
                                          <div class="card-body card-dashboard">
                                             <table id="currentStockTbl" class="table table-striped table-bordered">
                                                <thead>
                                                   <tr>
                                                      <th>S/N</th>
                                                      <th>Store</th>
                                                      <th>Location</th>
                                                      <th>Item Code</th>
                                                      <th>Item Name</th>
                                                      <th>Barcode</th>
                                                      <th>Unit</th>
                                                      <th>Inventory QTY</th>
                                                      <th>Cost Price</th>
                                                      <th>Inventory Amount</th>
                                                      <th>Pack</th>
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
                  <div role="tabpanel" class="tab-pane " id="stock" aria-labelledby="activeIcon12-tab1" aria-expanded="true">
                     <form class="filterMovementStock">
                        <section class="mb-1 filter-bar">
                           <!-- <div class="filter-bar-item f-12">
                              <span>
                                 <select name="" class="form-control form-select purchase-search" >
                                    <option value="0">Movement: All</option>
                                 </select>
                              </span>
                           </div> -->
                           <div class="filter-bar-item f-12">
                              <span>
                                 <select name="store_id" class="form-control form-select purchase-search" >
                                    <option value="">Store All</option>
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
                           <div class="filter-bar-item">
                              <span>
                                 <select name="item_id" class="form-control form-select purchase-search" >
                                    <option value="">Item Name</option>
                                    <?php if(!empty($data['items'])){
                                       $items = json_decode($data['items']);
                                       foreach($items as $row){
                                          ?>
                                          <option value="<?= $row->id?>"><?= $row->item_name?></option>
                                          <?php
                                       }
                                    } ?>
                                 </select>
                              </span>
                           </div>
                           <div class="filter-bar-item f-12">
                              <span>
                                 <input type="date"  name="date" placeholder="Time Interval" class="form-control purchase-search ">
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
                              <span><button type="button" class="btn btn-outline-info btn-sm movementStockBtn">Search</button></span>
                           </div>
                           <div class="filter-bar-item">
                              <span><button type="button" class="btn btn-outline-info btn-sm clearMovementBtn">Clear</button></span>
                           </div>
                           <div class="filter-bar-item border-side-right"></div>
                           <div class="filter-bar-item filter-bar-last pl-2">
                              <span>
                                 <span class="dropdown">
                                 <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right"><i class="fa fa-ellipsis-h"></i></button>
                                    <span aria-labelledby="#btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right" style="top:190px;">
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
                           <section id="configuration" >
                              <div class="row">
                                 <div class="col-12">
                                    <div class="card">
                                       <div class="card-content collapse show">
                                          <div class="card-body card-dashboard">
                                             <table id="movementStockTbl" class="table table-striped table-bordered " >
                                                <thead>
                                                   <tr>
                                                      <th rowspan="2" class="rowSpan">Store</th>
                                                      <th rowspan="2" class="rowSpan">Location</th>
                                                      <th rowspan="2" class="rowSpan">Time Interval</th>
                                                      <th rowspan="2" class="rowSpan">Item Name</th>
                                                      <th colspan="2">Open</th>
                                                      <th colspan="2">Rec</th>
                                                      <th colspan="2">Sold</th>
                                                      <th colspan="2">Adj</th>
                                                      <th colspan="2">Trf</th>
                                                      <th colspan="2">Prod</th>
                                                      <th colspan="2">Close</th>
                                                   </tr>
                                                   <tr>
                                                      <th>Units</th>
                                                      <th>Value</th>
                                                      <th>Units</th>
                                                      <th>Value</th>
                                                      <th>Units</th>
                                                      <th>Value</th>
                                                      <th>Units</th>
                                                      <th>Value</th>
                                                      <th>Units</th>
                                                      <th>Value</th>
                                                      <th>Units</th>
                                                      <th>Value</th>
                                                      <th>Units</th>
                                                      <th>Value</th>
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
                  <div class="tab-pane" id="adjustment-reason" role="tabpanel" aria-labelledby="adjustment-reason-tab1" aria-expanded="false">
                     <form class="filterAdjustmentReason">
                        <section class="mb-1 filter-bar">
                            <div class="filter-bar-item" style="flex-grow: 1;">
                                <span>
                                    <input type="text" placeholder="Search" name="search" class="form-control purchase-search searchDtField" value="" />
                                    <div class="form-control-position">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </span>
                            </div>
                            <div class="filter-bar-item">
                                <span><button type="button" class="btn btn-outline-info btn-sm adjustReasonBtn">Search</button></span>
                            </div>
                            <div class="filter-bar-item border-side-right"></div>
                            <div class="filter-bar-item filter-bar-last pl-2">
                                <span>
                                    <a href="javascript:void(0);" class="btn btn-info btn-sm mr-10 addReason" data-act="add"><i class="fa fa-plus"></i> Add New</a>
                                </span>
                            </div>
                        </section>
                     </form>
                     <div class="card card-content collapse show">
                        <div class="card-body card-dashboard">
                            <div class="status-div"><span class="active-span"></span><span> Active</span> <span class="inactive-span"> </span><span> Inactive</span></div>
                              <section id="configuration">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-content collapse show">
                                                <div class="card-body card-dashboard">
                                                    <table id="adjustmentReasonTbl" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>S/N</th>
                                                                <th>Reason</th>
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
                  <?php if(isset($data['permission']->stock_adjustment) && $data['permission']->stock_adjustment == 1) { ?>
                  <div class="tab-pane" id="adjustment" role="tabpanel" aria-labelledby="dropdownOptIcon21-tab1" aria-expanded="false">
                     <form class="filterAdjustmentStock">
                    <section class="mb-1 filter-bar">
                        
                        <div class="filter-bar-item f-12">
                           <span>
                              <select name="reason_id" class="form-control form-select purchase-search">
                                 <option value="">Reason: All</option>
                                 <?php if(isset($data['reason'])){
                                    foreach($data['reason'] as $row){ 
                                       ?>
                                       <option value="<?=$row['id']?>"><?=$row['reason']?></option>
                                       <?php 
                                    }
                                 } ?>
                              </select>
                           </span>
                        </div>
                        
                        <div class="filter-bar-item f-12">
                           <span>
                              <select name="store_id" class="form-control form-select purchase-search">
                                 <option value="">Stores: All</option>
                                 <?php if(isset($data['stores'])){
                                    foreach($data['stores'] as $row){ 
                                       ?>
                                       <option value="<?=$row['id']?>"><?=$row['store_name']?></option>
                                       <?php 
                                    }
                                 } ?>
                              </select>
                           </span>
                        </div>
                        <div class="filter-bar-item f-12">
                           <span>
                              <input type="date" name="" placeholder="Select Date Range" class="form-control purchase-search">
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
                           <span><button type="button" class="btn btn-outline-info btn-sm adjustStockBtn">Search</button></span>
                        </div>
                        <div class="filter-bar-item border-side-right"></div>
                        <div class="filter-bar-item filter-bar-last pl-2">
                           <span>
                              <a href="<?= base_url("inventory/add_stock_adjustment")?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
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
                                             <table id="adjustmentStockTbl" class="table table-striped table-bordered ">
                                                <thead>
                                                   <tr>
                                                      <th>S/N</th>
                                                      <th>Reason</th>
                                                      <th>Store</th>
                                                      <th>Narration</th>
                                                      <th>Date & Time</th>
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
                  <?php } if(isset($data['permission']->stock_transfer) && $data['permission']->stock_transfer == 1) { ?>
                  <div class="tab-pane" id="transfer" role="tabpanel" aria-labelledby="dropdownOptIcon21-tab1" aria-expanded="false">
                    <form class="filterTransferStock">
                    <section class="mb-1 filter-bar">
                        <div class="filter-bar-item">
                           <span>
                              <select name="supply_store" class="form-control form-select purchase-search">
                                 <option value="">Supply Store</option>
                                  <?php if(isset($data['supplyStore'])){
                                    foreach($data['supplyStore'] as $row){
                                       ?>
                                       <option value="<?=$row['id']?>"><?=$row['store_name']?></option>
                                       <?php 
                                    }
                                 } ?>
                              </select>
                           </span>
                        </div>
                        <div class="filter-bar-item f-12">
                           <span>
                              <select name="receiver_store" class="form-control form-select purchase-search">
                                 <option value="">Receiving Stores</option>
                                 <?php if(isset($data['receiveStore'])){
                                    foreach($data['receiveStore'] as $row){ 
                                       ?>
                                       <option value="<?=$row['id']?>"><?=$row['store_name']?></option>
                                       <?php 
                                    }
                                 } ?>
                              </select>
                           </span>
                        </div>
                        <!-- <div class="filter-bar-item f-12">
                           <span>
                              <select name="category_id" class="form-control form-select purchase-search">
                                 <option value="">Category: All</option>
                                 <?php if(isset($data['category'])){
                                    foreach($data['category'] as $row){ 
                                       ?>
                                       <option value="<?=$row['id']?>"><?=$row['category_name']?></option>
                                       <?php 
                                    }
                                 } ?>
                              </select>
                           </span>
                        </div> -->
                        <div class="filter-bar-item f-12">
                           <span>
                              <input type="date" name="date" placeholder="Select Date Range" class="form-control purchase-search">
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
                           <span><button type="button" class="btn btn-outline-info btn-sm transferStockBtn">Search</button></span>
                        </div>
                        <div class="filter-bar-item border-side-right"></div>
                        <div class="filter-bar-item filter-bar-last pl-2">
                           <span>
                              <a href="<?= base_url("inventory/add_transfer")?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
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
                        <div class="card-body card-dashboard" >
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
                                             <table id="transferStockTbl" class="table table-striped table-bordered">
                                                <thead>
                                                   <tr>
                                                      <th>Transfer Number</th>
                                                      <th>Supply Store</th>
                                                      <th>Receiving Store</th>
                                                      <th>Quantity</th>
                                                      <th>Date</th>
                                                      <!-- <th>Amount</th> -->
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
                     </form>
                  </div>
                  <?php } ?>
                  
                <div class="tab-pane" id="production" role="tabpanel" aria-labelledby="production-tab1" aria-expanded="false">
                    <form class="filterProdStock">
                        <section class="mb-1 filter-bar">
                            <div class="filter-bar-item f-12">
                                <span>
                                    <input type="date" name="date" placeholder="Select Date Range" class="form-control purchase-search" />
                                </span>
                            </div>

                            <div class="filter-bar-item" style="flex-grow: 1;">
                                <span>
                                    <input type="text" placeholder="Search" name="search" class="form-control purchase-search searchDtField" value="" />
                                    <div class="form-control-position">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </span>
                            </div>
                            <div class="filter-bar-item">
                                <span><button type="button" class="btn btn-outline-info btn-sm transferStockBtn">Search</button></span>
                            </div>
                            <div class="filter-bar-item border-side-right"></div>
                            <div class="filter-bar-item filter-bar-last pl-2">
                                <span>
                                    <a href="<?= base_url("inventory/add_production")?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
                                    <span class="dropdown">
                                        <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>
                                        <span aria-labelledby="#btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right" style="top: 185px;">
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
                                <div class="status-div"><span class="active-span"></span><span> Active</span> <span class="inactive-span"> </span><span> Inactive</span></div>
                                <section id="configuration">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-content collapse show">
                                                    <div class="card-body card-dashboard">
                                                        <table id="productionTbl" class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Date</th>
                                                                    <th>Item</th>
                                                                    <th>Quantity</th>
                                                                    <th>Store</th>
                                                                    <!-- <th>User</th> -->
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
                    </form>
                </div>
               </div>
            </div>
            
           <div class="modal fade text-left" id="add-new-reason" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
              <div class="modal-dialog modal-md" role="document">
                 <div class="modal-content">
                    <div class="modal-header">
                       <h4 class="modal-title" id="myModalLabel18">Add New Reason</h4>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                       </button>
                    </div>
                    <form method="post" id="adjustments_reason_form" name="adjustments_reason_form">
                       <input type="hidden" name="action" id="action" value="post_data_inventory">
                       <input type="hidden" name="table_name" id="table_name" value="stock_adjustments_reason">
                       <input type="hidden" name="id" id="reason-id" value="">

                       <div class="modal-body">
                          <div class="row">
                             <div class="col-md-12">
                                <div class="form-floating">
                                   <input type="text" class="form-control" name="reason" id="reason" placeholder="Stock Adustment Reason" value="" >
                                   <label for="reason">Reason</label>
                                </div>
                             </div>
                             <div class="col-md-12 pt-1">
                               <?= StatusInput(isset($value['status'])?$value['status']:'1');?>
                             </div>
                          </div>
                       </div>
                       <div class="modal-footer">
                          <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"> <i class="fa fa-close"></i> Cancel</button>
                          <button id="btnSubmit" type="submit" class="btn btn-info"> <i class="fa fa-file-o"></i> Save</button>
                       </div>
                    </form>
                 </div>
              </div>
           </div>
            <!-- Model Start -->         
            <div class="modal fade text-left" id="inventory-modification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
               <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel18">Inventory Modification</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <form name="inventory_details_form" id="inventory_details_form">
                        <input type="hidden" name="current_inventory_id" id="current_inventory_id" value="">
                        <div class="modal-body">
                              <table id="inventory-details-tbl" class="table table-bordered module-items-tbl">
                                 <thead class="threadClass">
                                    <tr>
                                       <th>Lot No.</th>
                                       <th>Date of manufacture</th>
                                       <th>Expiry Date</th>
                                       <th>Inventory Qty</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    
                                 </tbody>
                              </table>
                        </div>
                        <div class="modal-footer">
                           <!-- <div class="col-md-6">
                              <input type="radio" class="" name="status" id="Active" placeholder="123..." value="" ><label class="mr-1" for="Active"> Active</label>
                              <input type="radio" class="" name="status" id="Deactive" placeholder="123..." value="" ><label class="mr-1" for="Deactive">Inactive</label>
                           </div> -->
                           <div class="col-md-6 text-right">
                              <input type="radio">
                              <button type="button" class="btn grey btn-default_new" data-dismiss="modal"> <i class="fa fa-close"></i> Cancel</button>
                              <button type="button" id="btnSubmitInventory" class="btn btn-info"> <i class="fa fa-file-o"></i> Save</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
               <!-- Model End-->         
            </div>
         </div>
      </div>