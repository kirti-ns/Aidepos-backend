<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Sales By Item</h3>
            </div>
        </div>
        <div class="content-body">
            <form class="filterReport">
                <section class="mb-1 filter-bar">
                    <div class="filter-bar-item">
                        <span>
                            <div class='input-group'>
                                <input type='text' name="daterange" class="form-control dateranges" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </span>
                    </div>
                    <div class="filter-bar-item f-12">
                        <span>
                            <select name="store_id" class="form-control form-select purchase-search">
                                <option value="">Stores: All</option>
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
                    <!-- <div class="filter-bar-item border-side-right"></div> -->
                    <div class="btn-group mr-1 mb-1">
                        <button type="button" class="btn btn-outline-info btn-min-width dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Export As</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0);" data-type="sales-by-item" id="export-to-pdf">PDF</a>
                            <!-- <a class="dropdown-item" href="#">Another action</a> -->
                        </div>
                    </div>
                    <!-- <div class="filter-bar-item filter-bar-last pl-2">
                        <span>
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
                    </div> -->
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
                                            <table id="report-sales-item" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Item name</th>
                                                        <th>SKU</th>
                                                        <th>Quantity Sold</th>
                                                        <th>Amount</th>
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