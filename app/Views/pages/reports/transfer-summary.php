<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Transfer Summary</h3>
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
                            <select name="supply_store_id" class="form-control form-select purchase-search">
                                <option value="">Supply Store</option>
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
                    <div class="filter-bar-item f-12">
                        <span>
                            <select name="receiver_store_id" class="form-control form-select purchase-search">
                                <option value="">Receiver Store</option>
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
                    <div class="filter-bar-item f-12">
                        <span>
                            <select name="status" class="form-control form-select purchase-search">
                                <option value="">Transfer: All</option>
                                <option value="0">Pending</option>
                                <option value="1">Approved</option>
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
                            <a class="dropdown-item export-report" href="javascript:void(0);" data-type="transfer-summary" data-file="pdf">PDF</a>
                            <a class="dropdown-item export-report" href="javascript:void(0);" data-type="transfer-summary" data-file="csv">CSV</a>
                            <a class="dropdown-item export-report" href="javascript:void(0);" data-type="transfer-summary" data-file="xlsx">Excel</a>
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
                                            <table id="report-transfer-summary" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Transfer No</th>
                                                        <th>Supply Store</th>
                                                        <th>Receive Store</th>
                                                        <th>Qty</th>
                                                        <th>Received Qty</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
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