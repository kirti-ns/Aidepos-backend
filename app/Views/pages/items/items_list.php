<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Items</h3>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <!-- Icon Tab with bottom line -->
                <div class="col-xl-12 col-lg-12">
                    <ul class="nav nav-tabs navigate-tabs nav-underline nav-justified mb-1" id="tab-bottom-line-drag">
                        <li class="nav-item">
                            <a class="nav-link active" id="activeIcon12-tab1" data-toggle="tab" href="#items-list" aria-controls="activeIcon12" aria-expanded="true">Items List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="linkIcon12-tab2" data-toggle="tab" href="#department" aria-controls="linkIcon12" aria-expanded="false">Department</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="linkIcon12-tab3" data-toggle="tab" href="#category" aria-controls="linkIcon12" aria-expanded="false">Category</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="linkIcon12-tab4" data-toggle="tab" href="#subcategory" aria-controls="linkIcon12" aria-expanded="false">Subcategory</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="linkIcon12-tab5" data-toggle="tab" href="#modifiers" aria-controls="linkIcon12" aria-expanded="false">Modifiers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="linkIcon12-tab6" data-toggle="tab" href="#recipes" aria-controls="linkIcon12" aria-expanded="false">Recipes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="linkIcon12-tab7" data-toggle="tab" href="#uom" aria-controls="linkIcon12" aria-expanded="false">UOM</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="linkIcon12-tab8" data-toggle="tab" href="#brand" aria-controls="linkIcon12" aria-expanded="false">Brand</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="linkIcon12-tab9" data-toggle="tab" href="#variants" aria-controls="linkIcon12" aria-expanded="false">Variant</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- <div class="card">
            <div class="card-body"> -->
            <div class="tab-content">
                <!-- Items List start -->
                <div role="tabpanel" class="tab-pane active show" id="items-list" aria-labelledby="activeIcon12-tab1" aria-expanded="true">
                    <form class="filterItem">
                        <section class="mb-1 filter-bar">
                            <div class="filter-bar-item f-12">
                                <span>
                                    <select name="equal[status]" class="form-control form-select purchase-search">
                                        <option value="">Item: All</option>
                                        <option value="1">Active</option>
                                        <option value="2">Deactive</option>
                                    </select>
                                </span>
                            </div>
                            <div class="filter-bar-item f-12">
                                <span>
                                    <select name="equal[item_type]" class="form-control form-select purchase-search">
                                        <option value="">Item Type: All</option>
                                        <option value="1">Standard Item</option>
                                        <option value="2">Variance Item</option>
                                        <option value="3">Composite Item</option>
                                    </select>
                                </span>
                            </div>
                            <div class="filter-bar-item f-12">
                                <span>
                                    <select name="equal[category_id]" class="form-control form-select purchase-search">
                                       <option value="">Category: All</option>
                                       <?php if(isset($data['category'])){
                                       foreach($data['category'] as $row){ ?>
                                       <option value="<?= $row['id']?>"><?= $row['category_name']?></option>
                                       <?php }
                                       } ?>
                                    </select>
                                </span>
                            </div>
                            <div class="filter-bar-item f-12">
                                <span>
                                    <select name="equal[brand_id]" class="form-control form-select purchase-search">
                                       <option value="">Brand: All</option>
                                       <?php if(isset($data['brand'])){
                                       foreach($data['brand'] as $row){ ?>
                                       <option value="<?= $row['id']?>"><?= $row['brand_name']?></option>
                                       <?php }
                                       } ?>
                                    </select>
                                </span>
                            </div>
                            <div class="filter-bar-item" style="flex-grow: 1;">
                                <span>
                                    <input type="text" name="match[search]" placeholder="Search" class="form-control purchase-search" />
                                    <div class="form-control-position">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </span>
                            </div>
                            <div class="filter-bar-item">
                                <span><button id="itemSubmit" type="button" class="btn btn-outline-info btn-sm">Search</button></span>
                            </div>
                            <div class="filter-bar-item border-side-right"></div>
                            <div class="filter-bar-item filter-bar-last pl-2">
                                <span>
                                    <button type="button" class="btn btn-outline-info btn-sm import-customers mr-15"><i class="fa fa-download"></i></button>
                                    <a href="<?= base_url('items/add_item');?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
                                    <span class="dropdown">
                                        <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>
                                        <span aria-labelledby="btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right">
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
                                    <div class="status-div"><span class="active-span"></span><span> Active</span> <span class="inactive-span"></span><span> Inactive</span></div>
                                </div>
                                <div class="col-12 dt-btn">
                                    <div class="form-group">
                                        <!-- dt-buttons btn-group -->
                                        <button class="btn btn-sm btn-info" type="button" onclick="return exportItemFunc('export_all');"><span>Export all</span></button>
                                        <button class="btn btn-sm btn-info" onclick="return batchDelete();" type="button"><span>Batch Delete</span></button>
                                        <button class="btn btn-sm btn-info" id="delete-all-items" data-type="all_delete" type="button"><span>All Delete</span></button>
                                        <button class="btn btn-sm btn-info" data-target="#synchronize-price-mdl" data-toggle="modal" type="button"><span>Synchronized Store Prices</span></button>
                                        <button class="btn btn-sm btn-info" data-target="#copy-items-mdl" data-toggle="modal" type="button"><span>Copy Location Items</span></button>
                                        <button class="btn btn-sm btn-info" type="button" onclick="return exportItemFunc('plu_export_csv');"><span>PLU Export</span></button>
                                        <button class="btn btn-sm btn-info" type="button" onclick="return exportItemFunc('plu_export_txt');"><span>PLU Export TXT</span></button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-content collapse show">
                                                <div class="card-body card-dashboard">
                                                    <table id="item-table" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                               <!-- <th>Store Name</th> -->
                                                               <th><input type="checkbox" id="example-select-all" /></th>
                                                               <th>SKU</th>
                                                               <th>Item</th>
                                                               <th>Category</th>
                                                               <th>Subcategory</th>
                                                               <th>UOM</th>
                                                               <th>Tax</th>
                                                               <!--  <th>Has Batch</th>
                                                               <th>Serial No.</th>
                                                               <th>Stockable</th>
                                                               <th>Can Sale</th>
                                                               <th>Sell Online</th> -->
                                                               <th>Cost</th>
                                                               <th>Price</th>
                                                               <th>Stock</th>
                                                               <th>Stock Value</th>
                                                               <th>Action</th>
                                                            </tr>
                                                        </thead>
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
                <!-- Item List End -->
                <!-- Department Start -->
                <div class="tab-pane" id="department" role="tabpanel" aria-labelledby="linkIcon12-tab2" aria-expanded="false">
                    <form class="filterDept">
                        <section class="mb-1 filter-bar">
                            <div class="filter-bar-item f-12">
                                <span>
                                    <select name="status" class="form-control form-select purchase-search">
                                        <option value="">Status: All</option>
                                        <option value="1">Active</option>
                                        <option value="2">Deactive</option>
                                    </select>
                                </span>
                            </div>
                            <div class="filter-bar-item" style="flex-grow: 1;">
                                <span>
                                    <input type="text" name="search" placeholder="Search" class="form-control purchase-search" />
                                    <div class="form-control-position">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </span>
                            </div>
                            <div class="filter-bar-item">
                                <span><button type="button" id="deptSubmit" class="btn btn-outline-info btn-sm">Search</button></span>
                            </div>
                            <div class="filter-bar-item border-side-right"></div>
                            <div class="filter-bar-item filter-bar-last pl-2">
                                <span>
                                    <a href="<?= base_url('items/add_department')?>" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add New</a>
                                </span>
                            </div>
                        </section>
                    </form>
                    <div class="card card-content collapse show">
                        <div class="card-body card-dashboard">
                            <section id="configuration">
                                <div class="col-12">
                                    <div class="status-div"><span class="active-span"></span><span> Active</span> <span class="inactive-span"></span><span> Inactive</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-content collapse show">
                                                <div class="card-body card-dashboard">
                                                    <table id="dept-table" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Department Name</th>
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
                <!-- Department End -->
                <!-- Category Start -->
                <div class="tab-pane" id="category" role="tabpanel" aria-labelledby="linkIcon12-tab3" aria-expanded="false">
                    <form class="filterCategory">
                        <section class="mb-1 filter-bar">
                            <div class="filter-bar-item f-12">
                                <span>
                                    <select name="status" class="form-control form-select purchase-search">
                                        <option value="">Status: All</option>
                                        <option value="1">Active</option>
                                        <option value="2">Deactive</option>
                                    </select>
                                </span>
                            </div>
                            <div class="filter-bar-item f-12">
                                <span>
                                    <select name="category" class="form-control form-select purchase-search">
                                       <option value="">Category: All</option>
                                       <?php
                                       if(isset($data['category'])){
                                       foreach($data['category'] as $row) { ?>
                                       <option value="<?= $row['id']?>"><?= $row['category_name']?></option>
                                       <?php
                                       } } ?>
                                    </select>
                                </span>
                            </div>
                            <div class="filter-bar-item" style="flex-grow: 1;">
                                <span>
                                    <input type="text" name="search" placeholder="Search" class="form-control purchase-search" />
                                    <div class="form-control-position">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </span>
                            </div>
                            <div class="filter-bar-item">
                                <span><button type="button" id="categorySubmit" class="btn btn-outline-info btn-sm">Search</button></span>
                            </div>
                            <div class="filter-bar-item border-side-right"></div>
                            <div class="filter-bar-item filter-bar-last pl-2">
                                <span>
                                    <a href="<?= base_url('items/add_category')?>" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add New</a>
                                    <span class="dropdown">
                                        <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right" style="height: 28px;">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>
                                        <span aria-labelledby="btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right">
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
                                    <div class="status-div"><span class="active-span"></span><span> Active</span> <span class="inactive-span"></span><span> Inactive</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-content collapse show">
                                                <div class="card-body card-dashboard">
                                                    <table id="category-table" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Category Name</th>
                                                                <th>Prefix</th>
                                                                <!-- <th>No. of Subcategory</th> -->
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
                <!-- Category End -->
                <!-- SubCategory Start -->
                <div class="tab-pane" id="subcategory" role="tabpanel" aria-labelledby="linkIcon12-tab4" aria-expanded="false">
                    <form class="filterSubCategory">
                        <section class="mb-1 filter-bar">
                            <div class="filter-bar-item f-12">
                                <span>
                                    <select name="status" class="form-control form-select purchase-search">
                                        <option value="">Status: All</option>
                                        <option value="1">Active</option>
                                        <option value="2">Deactive</option>
                                    </select>
                                </span>
                            </div>
                            <div class="filter-bar-item" style="flex-grow: 1;">
                                <span>
                                    <input type="text" name="search" placeholder="Search" class="form-control purchase-search" />
                                    <div class="form-control-position">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </span>
                            </div>
                            <div class="filter-bar-item">
                                <span><button type="button" id="subcategorySubmit" class="btn btn-outline-info btn-sm">Search</button></span>
                            </div>
                            <div class="filter-bar-item border-side-right"></div>
                            <div class="filter-bar-item filter-bar-last pl-2">
                                <span>
                                    <a href="<?= base_url('items/add_subcategory')?>" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add New</a>
                                    <span class="dropdown">
                                        <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default btn-sm dropdown-toggle dropdown-menu-right" style="height: 28px;">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>
                                        <span aria-labelledby="btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right">
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
                                    <div class="status-div"><span class="active-span"></span><span> Active</span> <span class="inactive-span"></span><span> Inactive</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-content collapse show">
                                                <div class="card-body card-dashboard">
                                                    <table id="subcategory-table" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Subcategory Name</th>
                                                                <!-- <th>Description</th> -->
                                                                <!-- <th>No. of Subcategory</th> -->
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
                <!-- SubCategory End -->
                <!-- Modifier Start -->
                <div class="tab-pane" id="modifiers" role="tabpanel" aria-labelledby="dropdownOptIcon21-tab5" aria-expanded="false">
                    <form class="filterModifiers">
                        <section class="mb-1 filter-bar">
                            <div class="filter-bar-item f-12">
                                <span>
                                    <select name="equal[status]" class="form-control form-select purchase-search">
                                        <option value="">Status: All</option>
                                        <option value="1">Active</option>
                                        <option value="2">Deactive</option>
                                    </select>
                                </span>
                            </div>
                            <div class="filter-bar-item" style="flex-grow: 1;">
                                <span>
                                    <input type="text" placeholder="Search" name="match[search]" class="form-control purchase-search searchDtField" value="" />
                                    <div class="form-control-position">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </span>
                            </div>
                            <div class="filter-bar-item">
                                <span><button id="modifierSubmit" type="button" class="btn btn-outline-info btn-sm">Search</button></span>
                            </div>
                            <div class="filter-bar-item border-side-right"></div>
                            <div class="filter-bar-item filter-bar-last pl-2">
                                <span>
                                    <a href="<?= base_url("items/add_modifier")?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
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
                    </form>
                    <div class="card card-content collapse show">
                        <div class="card-body card-dashboard">
                            <section id="configuration">
                                <div class="col-12">
                                    <div class="status-div"><span class="active-span"></span><span> Active</span> <span class="inactive-span"></span><span> Inactive</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-content collapse show">
                                                <div class="card-body card-dashboard">
                                                    <table id="modifiers-table" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <!-- <th>Rate</th> -->
                                                                <th>Group</th>
                                                                <th>Product</th>
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
                <!-- Modifiers End -->
                <!-- Recipe Start -->
                <div class="tab-pane" id="recipes" role="tabpanel" aria-labelledby="dropdownOptIcon21-tab6" aria-expanded="false">
                    <form class="filterRecipe">
                        <section class="mb-1 filter-bar">
                              <div class="filter-bar-item f-12">
                                 <span>
                                    <select name="equal[status]" class="form-control form-select purchase-search">
                                        <option value="">Status: All</option>
                                        <option value="1">Active</option>
                                        <option value="2">Deactive</option>
                                    </select>
                                 </span>
                              </div>
                              <!--  <div class="filter-bar-item f-12">
                              <span>
                                 <select name="equal[category]" class="form-control form-select purchase-search">
                                    <option>Category: All</option>
                                    <?php
                                     if(isset($data['category'])){
                                      foreach($data['category'] as $row){
                                    ?>
                                    <option value="<?= $row['id']?>"><?= $row['category_name']?></option>
                                    <?php
                                       }
                                    } ?>
                                 </select>
                              </span>
                           </div> -->
                            <div class="filter-bar-item" style="flex-grow: 1;">
                                <span>
                                    <input type="text" placeholder="Search" name="match[search]" class="form-control purchase-search searchDtField" value="" />
                                    <div class="form-control-position">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </span>
                            </div>
                            <div class="filter-bar-item">
                                <span><button type="button" id="recipeSubmit" class="btn btn-outline-info btn-sm">Search</button></span>
                            </div>
                            <div class="filter-bar-item border-side-right"></div>
                            <div class="filter-bar-item filter-bar-last pl-2">
                                <span>
                                    <a href="<?= base_url("items/add_recipe") ?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
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
                    </form>
                    <div class="card card-content collapse show">
                        <div class="card-body card-dashboard">
                            <section id="configuration">
                                <div class="col-12">
                                    <div class="status-div"><span class="active-span"></span><span> Active</span> <span class="inactive-span"></span><span> Inactive</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-content collapse show">
                                                <div class="card-body card-dashboard">
                                                    <table id="recipe-table" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Group Name</th>
                                                                <th>No. of Items</th>
                                                                <th>Total Cost</th>
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
                <!-- Recipe End -->
                <!-- UOM Start -->
                <div role="tabpanel" class="tab-pane" id="uom" aria-labelledby="activeIcon12-tab7" aria-expanded="true">
                    <form class="filteruom">
                        <section class="mb-1 filter-bar">
                            <div class="filter-bar-item f-12">
                                <span>
                                    <select name="equal[status]" class="form-control form-select purchase-search">
                                        <option value="">Status: All</option>
                                        <option value="1">Active</option>
                                        <option value="2">Deactive</option>
                                    </select>
                                </span>
                            </div>
                            <div class="filter-bar-item" style="flex-grow: 1;">
                                <span>
                                    <input type="text" placeholder="Search" name="match[search]" class="form-control purchase-search searchDtField" value="" />
                                    <div class="form-control-position">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </span>
                            </div>
                            <div class="filter-bar-item">
                                <span><button id="uomSubmit" type="button" class="btn btn-outline-info btn-sm">Search</button></span>
                            </div>
                            <div class="filter-bar-item border-side-right"></div>
                            <div class="filter-bar-item filter-bar-last pl-2">
                                <span>
                                    <a href="<?= base_url("items/add_uom")?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
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
                    </form>
                    <div class="card card-content collapse show">
                        <div class="card-body card-dashboard">
                            <section id="configuration">
                                <div class="col-12">
                                    <div class="status-div"><span class="active-span"></span><span> Active</span> <span class="inactive-span"></span><span> Inactive</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-content collapse show">
                                                <div class="card-body card-dashboard">
                                                    <table id="uom-table" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>UOM</th>
                                                                <th>Formal Name</th>
                                                                <th>Decimal Point</th>
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
                <!-- UOM End -->
                <!-- Brand Start -->
                <div class="tab-pane" id="brand" role="tabpanel" aria-labelledby="linkIcon12-tab8" aria-expanded="false">
                    <form class="filterBrand">
                        <section class="mb-1 filter-bar">
                            <div class="filter-bar-item f-12">
                                <span>
                                    <select name="equal[status]" class="form-control form-select purchase-search">
                                        <option value="">Status: All</option>
                                        <option value="1">Active</option>
                                        <option value="2">Deactive</option>
                                    </select>
                                </span>
                            </div>
                            <div class="filter-bar-item" style="flex-grow: 1;">
                                <span>
                                    <input type="text" name="match[search]" placeholder="Search" class="form-control purchase-search" />
                                    <div class="form-control-position">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </span>
                            </div>
                            <div class="filter-bar-item">
                                <span><button type="button" id="brandSubmit" class="btn btn-outline-info btn-sm">Search</button></span>
                            </div>
                            <div class="filter-bar-item border-side-right"></div>
                            <div class="filter-bar-item filter-bar-last pl-2">
                                <span>
                                    <a href="<?= base_url("items/add_brand")?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
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
                    </form>
                    <div class="card card-content collapse show">
                        <div class="card-body card-dashboard">
                            <section id="configuration">
                                <div class="col-12">
                                    <div class="status-div">
                                        <div class=""><span class="active-span"></span> Active <span class="inactive-span"></span><span> Inactive</span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-content collapse show">
                                                <div class="card-body card-dashboard">
                                                    <table id="brand-table" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Brand</th>
                                                                <th>Number of Items</th>
                                                                <th>Stock</th>
                                                                <th>Stock Value</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
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
                <div role="tabpanel" class="tab-pane" id="variants" aria-labelledby="activeIcon12-tab9" aria-expanded="true">
                    <form class="filtervar">
                        <section class="mb-1 filter-bar">
                            <div class="filter-bar-item" style="flex-grow: 1;">
                                <span>
                                    <input type="text" placeholder="Search" name="match[search]" class="form-control purchase-search searchDtField" value="" />
                                    <div class="form-control-position">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </span>
                            </div>
                            <div class="filter-bar-item">
                                <span><button id="varSubmit" type="button" class="btn btn-outline-info btn-sm">Search</button></span>
                            </div>
                            <div class="filter-bar-item border-side-right"></div>
                            <div class="filter-bar-item filter-bar-last pl-2">
                                <span>
                                    <a href="javascript:void(0);" class="btn btn-info btn-sm mr-10" id="addVariant"><i class="fa fa-plus"></i> Add New</a>
                                </span>
                            </div>
                        </section>
                    </form>
                    <div class="card card-content collapse show">
                        <div class="card-body card-dashboard">
                            <section id="configuration">
                                <div class="col-12">
                                    <div class="status-div"><span class="active-span"></span><span> Active</span> <span class="inactive-span"></span><span> Inactive</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-content collapse show">
                                                <div class="card-body card-dashboard">
                                                    <table id="vars-table" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Variant Name</th>
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
                <!--  </div>
                </div> -->
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
                                    <span class="dragBox">
                                        <span><i class="fa fa-cloud-upload"></i></span>
                                        <span> Darg and Drop Files Here</span><br />
                                        <input type="file" onChange="dragNdrop(event)" ondragover="drag()" ondrop="drop()" id="uploadFile" />
                                    </span>
                                </div>
                                <div class="col-md-2 p-2">
                                    <strong>OR</strong>
                                </div>
                                <div class="col-md-5">
                                    <label for="uploadFile" class="btn btn-outline-info"><i class="fa fa-plus"></i> Browse Files</label>
                                    <p>Supported upto to 25 MB</p>
                                </div>
                            </div>
                            <!-- <div id="preview"></div> -->
                        </div>
                        <div class="modal-footer">
                            <a href=""><i class="fa fa-download"></i> Download Format</a>
                            <button type="button" class="btn btn-info"><i class="fa fa-file-o"></i> Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model End-->

        <div class="modal fade text-left" id="export-items-mdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabelexp" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabelexp">Store Selection</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body ml-1">
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-select" id="exp-store" name="store" aria-label="Floating label select example">
                                    <?php 
                                    if(!empty($data['stores'])) { 
                                    foreach($data['stores'] as $row) { ?>
                                    <option value="<?= $row['id']?>"><?=$row['store_name']?> </option>
                                    <?php } 
                                    } else { ?>
                                    <option value="">Select</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2 mb-2">
                            <div class="col-md-6">
                                <a href="javascript:void(0);" class="downloadItemsXls"><i class="fa fa-download"></i> Download</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade text-left" id="synchronize-price-mdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabelexp" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabelexp">Store Selection</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body ml-1">
                        <form id="synchronize_price_form" name="synchronize_price_form" method="post">
                            <div class="row">
                                <div class="col-md-2" style="padding-top: 5px;">
                                    <span>Store Prices</span>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select" id="main-store" name="main_store" aria-label="Floating label select example">
                                       <option value="">Select</option>
                                       <?php 
                                       if(!empty($data['stores'])) { 
                                       foreach($data['stores'] as $row) { ?>
                                       <option value="<?= $row['id']?>"><?=$row['store_name']?> </option>
                                       <?php } } ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-info btn-sm" type="button" id="submitSynchronizeBtn">Submit Update</button>
                                </div>
                            </div>
                            <div class="row mt-2 mb-2">
                                <div class="col-md-12">
                                    <span>Synchronized Stores</span><br />
                                    <br />
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select_all_stores" name="stores[]" /></th>
                                                <th>Store ID</th>
                                                <th>Store Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <?php 
                                             if(!empty($data['stores'])) { 
                                             foreach($data['stores'] as $row) { ?>
                                             <tr>
                                                <td><input type="checkbox" class="select_store" name="stores[]" value="<?= $row['id'] ?>" /></td>
                                                <td><?= $row['id'] ?></td>
                                                <td><?= $row['store_name'] ?></td>
                                             </tr>
                                             <?php } } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <span class="error-msg" style="color: #ff0000;"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="copy-items-mdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabelexp" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabelexp">Copy Items within store from one location to another</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body ml-1">
                        <form id="copy_items_form" name="copy_items_form" method="post">
                            <div class="row">
                                <div class="col-md-12" style="padding-top: 5px;">
                                    <span>Store</span>
                                </div>
                                <div class="col-md-6" style="margin-top:2px;">
                                    <select class="form-select" id="c-store" name="main_store" aria-label="Floating label select example">
                                       <option value="">Select</option>
                                       <?php 
                                       if(!empty($data['stores'])) { 
                                       foreach($data['stores'] as $row) { ?>
                                       <option value="<?= $row['id']?>"><?=$row['store_name']?> </option>
                                       <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2 mb-2">
                                <div class="col-md-12">
                                    <br />
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select_all_stores" name="stores[]" /></th>
                                                <th>Store ID</th>
                                                <th>Store Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <?php 
                                             if(!empty($data['stores'])) { 
                                             foreach($data['stores'] as $row) { ?>
                                             <tr>
                                                <td><input type="checkbox" class="select_store" name="stores[]" value="<?= $row['id'] ?>" /></td>
                                                <td><?= $row['id'] ?></td>
                                                <td><?= $row['store_name'] ?></td>
                                             </tr>
                                             <?php } } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <span class="error-msg" style="color: #ff0000;"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="add-new-variant" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel18">Add New Variant</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="variant_master_form" name="variant_master_form">
                        <input type="hidden" name="action" id="action" value="post_items_data" />
                        <input type="hidden" name="table_name" id="table_name" value="location" />
                        <input type="hidden" name="id" id="id" value="" />

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="variant_name" id="variant_name" placeholder="Product Variant" value="" />
                                        <label for="variant_name">Product Variant</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i> Cancel</button>
                            <button id="btnSubmitVariant" type="submit" class="btn btn-info"><i class="fa fa-file-o"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
