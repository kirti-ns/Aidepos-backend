<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Stock Valuation</h3>
            </div>
        </div>
        <div class="content-body">
            <form class="filterReport">
                <section class="mb-1 filter-bar">
                    <div class="filter-bar-item f-12">
                        <span>
                            <select name="store_id" id="store_id" class="form-control form-select purchase-search">
                                <option value="">Stores: All</option>
                                <?php 
                                   if(!empty($data['store']))
                                   {
                                      foreach($data['store'] as $k => $row)
                                      {
                                         $selected = "";
                                         if($k == 0) {
                                            $selected = "selected";
                                         }
                                      ?>
                                         <option value="<?= $row['id']?>" <?=$selected?>><?=$row['store_name']?> </option>
                                   <?php
                                      }
                                    } 
                                ?>
                            </select>
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
                        <span><button type="button" class="btn btn-outline-info btn-sm reportSearchBtn">Search</button></span>
                    </div>
                    <div class="btn-group mr-1 mb-1">
                        <button type="button" class="btn btn-outline-info btn-min-width dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Export As</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0);" data-type="stock-valuation" id="export-to-pdf">PDF</a>
                            <!-- <a class="dropdown-item" href="#">Another action</a> -->
                        </div>
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
                                            <table id="report-stock-valuation" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Store</th>
                                                        <th>Item Name</th>
                                                        <th>SKU</th>
                                                        <th>Unit</th>
                                                        <th>Stock On Hand</th>
                                                        <th>Inventory Asset Value</th>
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
    </div>
</div>