<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Credit Notes</h3>
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
                    <div class="filter-bar-item f-12">
                        <span>
                            <select name="customer_id" class="form-control form-select purchase-search">
                                <option value="">Customers: All</option>
                                <?php 
                                   if(!empty($data['customers']))
                                   {
                                      foreach($data['customers'] as $row)
                                      { ?>
                                         <option value="<?= $row['id']?>"><?=$row['registerd_name']?> </option>
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
                            <a class="dropdown-item export-report" href="javascript:void(0);" data-type="credit-notes" data-file="pdf">PDF</a>
                            <a class="dropdown-item export-report" href="javascript:void(0);" data-type="credit-notes" data-file="csv">CSV</a>
                            <a class="dropdown-item export-report" href="javascript:void(0);" data-type="credit-notes" data-file="xlsx">Excel</a>
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
                                            <table id="report-credit-notes" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Credit Note</th>
                                                        <th>Date</th>
                                                        <th>Customer Name</th>
                                                        <th>Amount</th>
                                                        <th>Balance</th>
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