<style type="text/css">
    .pcs-payment-details-section {
        padding: 20px;
        background-color: #fbfafa;
    }
    .pcs-font-bolder {
        font-weight: 600;
    }

    .pcs-pd-section-title {
        font-size: 10pt;
    }
    .pcs-label {
        color: #000000;
    }
    .pcs-pd-section-label,
    .pcs-pd-section-value {
        padding-top: 10px;
    }
    .pcs-pd-section-label {
        width: 70%;
    }
    #v-invoice-items-tbl thead {
        background-color: #000;
    }
    @media print {
        body {
            -webkit-print-color-adjust: exact;
        }
    }
    #v-invoice-items-tbl thead th {
        color: #fff !important;
    }
    .pcs-bdr-top {
        border-top: 1px solid #d8d8d7;
    }
    .customizer-content .card {
        box-shadow: 0 0 6px #ccc;
    }
    .customizer-content .card .card-body {
        padding: 3rem !important;
    }
    #v-func-section .card .card-body {
        padding: 1rem !important;
    }
    .customizer-content .card .card-header {
        background-color: #eee;
        padding: 0.5rem !important;
    }
    .view-module, .view-cn {
        cursor: pointer;
    }
    .selected-tr {
        background-color: rgb(244 244 244) !important;
        box-shadow: 0 0 6px #ccc !important;
    }
    .amount-sec {
        border: 1px solid #eee;
        border-left-color: #f05b2a;
        box-shadow: 1px 1px 1px 0 rgba(0, 0, 0, 0.1);
        padding: 20px 20px 15px;
        margin: 20px 25px 25px 0;
        width: 74%;
    }
    .p-badge {
        position: absolute !important;
        top: -5px;
        left: -5px;
        overflow: hidden;
        width: 96px;
        height: 94px;
    }
    .p-badge-inner {
        text-align: center;
        color: #fff;
        top: 24px;
        left: -31px;
        width: 135px;
        padding: 5px;
        position: relative;
        transform: rotate(-45deg);
    }
    .p-badge-success {
        background-color: #43d758;
    }
    .p-badge-info {
        background-color: #788e8f;
    }
    .text-align-right {
        text-align: right;
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
    .b-shadow {
        box-shadow: 0 2.8px 2.2px rgba(0, 0, 0, 0.034), 0 6.7px 5.3px rgba(0, 0, 0, 0.048), 0 12.5px 10px rgba(0, 0, 0, 0.06), 0 22.3px 17.9px rgba(0, 0, 0, 0.072), 0 41.8px 33.4px rgba(0, 0, 0, 0.086), 0 100px 80px rgba(0, 0, 0, 0.12);
    }
</style>
<div class="app-content content">
    <div class="loading" style="display: none; position: fixed; left: 50%; top: 60%; z-index: 999999;">
        <img src="<?php echo base_url();?>/public/app-assets/images/loading-gif.gif" style="height: 50px; width: 50px;" alt="loader" title="loader.gif" />
    </div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Sales</h3>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <!-- Icon Tab with bottom line -->
                <div class="col-xl-12 col-lg-12">
                    <ul class="nav nav-tabs navigate-tabs nav-underline nav-justified mb-1" id="tab-bottom-line-drag">
                        <li class="nav-item">
                            <a class="nav-link active" id="activeIcon12-tab1" data-toggle="tab" href="#quotes" aria-controls="activeIcon12" aria-expanded="true">Quotes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="activeIcon12-tab1" data-toggle="tab" href="#invoice-list" aria-controls="activeIcon12" aria-expanded="true">Invoice</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#credit-debit-note" aria-controls="linkIcon12" aria-expanded="false">Credit Note</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#payments" aria-controls="linkIcon12" aria-expanded="false">Payments</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- <div class="card">
               <div class="card-body"> -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active show" id="quotes" aria-labelledby="activeIcon12-tab1" aria-expanded="true">
                    <form class="filterQuote">
                        <section class="mb-1 filter-bar">
                            <div class="filter-bar-item f-12">
                                <span>
                                    <select name="customer_id" class="form-control form-select purchase-search">
                                        <option value="">Customers: All</option>
                                        <?php foreach($data['customer'] as $c) { ?>
                                        <option value="<?= $c['id']; ?>"><?= $c['registerd_name'] ?></option>
                                        <?php } ?>
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
                            <div class="filter-bar-item" style="flex-grow: 1;">
                                <span>
                                    <input type="text" placeholder="Search" name="search" class="form-control purchase-search searchDtField" value="" />
                                    <div class="form-control-position">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </span>
                            </div>
                            <div class="filter-bar-item">
                                <span><button type="button" class="btn btn-outline-info btn-sm quoteBtn">Search</button></span>
                            </div>
                            <div class="filter-bar-item border-side-right"></div>
                            <div class="filter-bar-item filter-bar-last pl-2">
                                <span>
                                    <a href="<?= base_url("sales/add_quote")?>?type=1" class="btn btn-sm btn-info mr-10"><i class="fa fa-plus"></i> Add New</a>
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
                                                    <table id="quote-tbl" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Quote</th>
                                                                <th>Customer Name</th>
                                                                <th>Date</th>
                                                                <th>Due date</th>
                                                                <th>Amount</th>
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
                <div role="tabpanel" class="tab-pane" id="invoice-list" aria-labelledby="activeIcon12-tab1" aria-expanded="true">
                    <form class="filterSellStock">
                        <section class="mb-1 filter-bar">
                            <div class="filter-bar-item f-12">
                                <span>
                                    <select name="customer_id" class="form-control form-select purchase-search">
                                        <option value="">Customers: All</option>
                                        <?php foreach($data['customer'] as $c) { ?>
                                        <option value="<?= $c['id']; ?>"><?= $c['registerd_name'] ?></option>
                                        <?php } ?>
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
                            <div class="filter-bar-item" style="flex-grow: 1;">
                                <span>
                                    <input type="text" placeholder="Search" name="search" class="form-control purchase-search searchDtField" value="" />
                                    <div class="form-control-position">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </span>
                            </div>
                            <div class="filter-bar-item">
                                <span><button type="button" class="btn btn-outline-info btn-sm sellStockBtn">Search</button></span>
                            </div>
                            <div class="filter-bar-item border-side-right"></div>
                            <div class="filter-bar-item filter-bar-last pl-2">
                                <span>
                                    <a href="<?= base_url("sales/add_invoice")?>?type=1" class="btn btn-sm btn-info mr-10"><i class="fa fa-plus"></i> Add New</a>
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
                                                    <table id="sellStockTbl" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Invoice</th>
                                                                <th>Order No</th>
                                                                <th>Customer Name</th>
                                                                <th>Status</th>
                                                                <th>Due date</th>
                                                                <th>Amount</th>
                                                                <th>Balance Due</th>
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
                <div class="tab-pane" id="credit-debit-note" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
                    <form class="filterPaymentSellStock">
                        <section class="mb-1 filter-bar">
                            <!--<div class="filter-bar-item">-->
                            <!--   <span>-->
                            <!--      <select name="customer" class="form-control form-select  purchase-search">-->
                            <!--         <option value="0">Invoice: All</option>-->
                            <!--      </select>-->
                            <!--   </span>-->
                            <!--</div>-->
                            <div class="filter-bar-item">
                                <span>
                                    <select name="invoice_type" class="form-control form-select purchase-search">
                                        <option value="">Invoice Type:All</option>
                                        <option value="1">Credit Note</option>
                                        <option value="2">Debit Note</option>
                                    </select>
                                </span>
                            </div>
                            <div class="filter-bar-item">
                                <span>
                                    <select name="customer_id" class="form-control form-select purchase-search">
                                        <option value="">Customers: All</option>
                                        <?php foreach($data['customer'] as $c) { ?>
                                        <option value="<?= $c['id']; ?>"><?= $c['registerd_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </span>
                            </div>
                            <div class="filter-bar-item">
                                <span>
                                    <select name="store_id" class="form-control form-select purchase-search">
                                        <option value="">Stores: All</option>
                                        <?php foreach($data['stores'] as $c) { ?>
                                        <option value="<?= $c['id']; ?>"><?= $c['store_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </span>
                            </div>
                            <!--<div class="filter-bar-item">-->
                            <!--   <span>-->
                            <!--      <select name="customer" class="form-control form-select  purchase-search">-->
                            <!--         <option value="0">Terminals: All</option>-->
                            <!--      </select>-->
                            <!--   </span>-->
                            <!--</div>-->
                            <div class="filter-bar-item">
                                <span>
                                    <select name="payment_by" class="form-control form-select purchase-search">
                                        <option value="">Payment By</option>
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
                                <span><button type="button" class="btn btn-outline-info btn-sm crNoteBtn">Search</button></span>
                            </div>
                            <div class="filter-bar-item border-side-right"></div>
                            <div class="filter-bar-item filter-bar-last pl-2">
                                <span>
                                    <a href="<?= base_url("sales/add_invoice")?>?type=2" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add New</a>
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
                                                    <table id="creditNoteTbl" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Credit Note</th>
                                                                <th>Customer Name</th>
                                                                <th>Invoice</th>
                                                                <!-- <th>Status</th> -->
                                                                <th>Amount</th>
                                                                <th>Balance</th>
                                                                <!-- <th>Action</th> -->
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
                <div class="tab-pane" id="payments" role="tabpanel" aria-labelledby="dropdownOptIcon21-tab1" aria-expanded="false">
                    <section class="mb-1 filter-bar">
                        <div class="filter-bar-item f-12">
                            <span>
                                <select name="payment_by" class="form-control form-select purchase-search">
                                    <option value="0">Payment:All</option>
                                </select>
                            </span>
                        </div>
                        <div class="filter-bar-item f-12">
                            <span>
                                <select name="customer_id" class="form-control form-select purchase-search">
                                    <option value="">Customers: All</option>
                                    <?php foreach($data['customer'] as $c) { ?>
                                    <option value="<?= $c['id']; ?>"><?= $c['registerd_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </span>
                        </div>
                        <div class="filter-bar-item f-12">
                            <span>
                                <select name="stores" class="form-control form-select purchase-search">
                                    <option value="0">Mode:All</option>
                                </select>
                            </span>
                        </div>
                        <div class="filter-bar-item">
                            <span><input type="date" name="" placeholder="" class="form-control purchase-search" /></span>
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
                            <span><button type="button" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
                        </div>
                        <div class="filter-bar-item border-side-right"></div>
                        <div class="filter-bar-item filter-bar-last pl-2">
                            <span>
                                <a href="<?= base_url("sales/add_payment_invoice")?>" class="btn btn-info btn-sm mr-10"><i class="fa fa-plus"></i> Add New</a>
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
                            <section id="configuration">
                                <div class="col-12">
                                    <div class="status-div"><span class="active-span"></span><span> Active</span> <span class="inactive-span"></span><span> Inactive</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-content collapse show">
                                                <div class="card-body card-dashboard">
                                                    <table class="table table-striped table-bordered zero-configuration">
                                                        <thead>
                                                            <tr>
                                                                <th>Payment ID</th>
                                                                <th>Date</th>
                                                                <!-- <th>Reference No.</th> -->
                                                                <th>Customer Name</th>
                                                                <th>Invoice ID</th>
                                                                <th>Mode</th>
                                                                <th>Amount</th>
                                                                <!-- <th>Unused Amount</th> -->
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if(!empty($data['payment_invoice'])){
                                                               foreach($data['payment_invoice'] as $row){
                                                            ?>
                                                            <tr>
                                                                <td class="<?= RowStatus($row['status']) ?>"><a class="storeColor" href="<?=base_url()?>/sales/view_payment/<?=$row['id']?>">PAY-0000<?= $row['id'] ?></a></td>
                                                                <td><?= $row['payment_date'] ?></td>
                                                                <!-- <td><?= $row['reference_id'] ?></td> -->
                                                                <td><?= $row['registerd_name'] ?></td>
                                                                <td>INV-000<?= $row['invoice_id'] ?></td>
                                                                <td><?= $row['payment_type'] ?></td>
                                                                <!-- <td><?= $row['payment_id'] ?></td> -->
                                                                <td><?= $row['amount_received'] ?></td>

                                                                <td>
                                                                    <a href="<?= base_url('sales/view_payment/'. $row['id'])?>"><i class="fa fa-eye"></i></a> &nbsp;&nbsp;&nbsp;
                                                                    <a href="#" data-id="<?= $row['id']?>" class="transh-icon-color deleteRow" data-table="sales_payment"><i class="fa fa-trash-o"></i></a>
                                                                </td>
                                                            </tr>
                                                            <?php } } ?>
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
<div class="modal fade text-left" style="z-index: 1052" id="apply_credits_mdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-lg b-shadow" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title appl-credit-title"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="post" id="apply_credits_indv" name="apply_credits_indv">
            <input type="hidden" name="invoice_id" class="c_invoice_id" value="">
            <input type="hidden" name="customer_id" class="c_customer_id" value="">
            <div class="modal-body">
               <div class="row">
                   
                   <div class="col-md-12">
                     <table class="table" id="view-credits-tbl">
                         <thead>
                             <tr>
                                 <th>Credit Note</th>
                                 <th>Credit Note Date</th>
                                 <th>Credit Amount</th>
                                 <th>Credits Available</th>
                                 <th>Amount To Credit</th>
                             </tr>
                         </thead>
                         <tbody>

                         </tbody>
                     </table>
                     <div class="col-md-12">
                        Invoice Balance Due: <span class="invoice_bal_due"></span>
                        <input type="hidden" name="balance_due" class="balance_due" value="">
                     </div><br/><br/>
                     <div class="col-md-12"><span class="errortxt" style="color:red"></span></div>
                  </div>
               </div><br>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"> <i class="fa fa-close"></i> Cancel</button>
               <button id="btnCreditSubmit" type="button" class="btn btn-info"> <i class="fa fa-file-o"></i> Save</button>
            </div>
         </form>
      </div>
   </div>
</div>
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
                    <div class="col-md-6">
                        <h5><b>AIDEPOS</b></h5>
                        <p>
                            Company ID : 90605<br />
                            Tax ID : 100900800<br />
                            Goldcrest Mall<br />
                            Lusaka Zambia
                        </p>
                    </div>
                    <div class="col-md-6 text-right m-details">
                        <span style="font-size: 30px;" class="module">INVOICE</span><br/>

                    </div>
                </div>
                <hr/>

                <!-- <div class="row">
                    <div class="col-md-12">
                        <h3 id="module-title" style="text-transform: uppercase;"></h3>
                        <p>Invoice# INV-<span id="v-receipt-no"></span></p>
                    </div>
                </div> -->

                <div class="row pt-1">
                    <div class="col-md-8">
                        <h6><b>Bill To</b></h6>
                        <span id="v-cust-name"></span><br />
                        <span id="v-cust-address"></span>
                    </div>
                    <div class="col-md-4 pl-1 pb-1 account-summary account-summary-div text-right">
                        <span id="v-module-date"> </span>
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
                                    <tr style="height: 10px;display: none;" id="pay-tr">
                                        <td valign="middle" style="padding: 10px 7px;" class="total-section-label">Payment Made</td>
                                        <td id="v-pay-made" valign="middle" style="width: 110px; padding: 10px 7px;" class="text-align-right total-section-value danger"><b></b></td>
                                    </tr>
                                    <tr style="height: 10px;display: none;" id="crd-tr">
                                        <td valign="middle" style="padding: 10px 7px;" class="total-section-label">Credits Applied</td>
                                        <td id="v-cr-applied" valign="middle" style="width: 110px; padding: 10px 7px;" class="text-align-right total-section-value danger"><b></b></td>
                                    </tr>
                                    <tr style="height: 10px; background: #eee;" id="b-d-tr" style="display: none;">
                                        <td valign="middle" style="padding: 10px 7px;" class="total-section-label pcs-bdr-top"><b>Balance Due</b></td>
                                        <td id="v-balance-due" valign="middle" style="width: 110px; padding: 10px 7px;" class="text-align-right total-section-value pcs-bdr-top"></td>
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
<div class="customizr border-left-blue-grey border-left-lighten-4 d-none d-xl-block">
    <div class="cloading" style="display: none; position: fixed; left: 50%; top: 60%; z-index: 999999;">
        <img src="<?php echo base_url();?>/public/app-assets/images/loading-gif.gif" style="height: 50px; width: 50px;" alt="loader" title="loader.gif" />
    </div>

    <!-- <a class="customizer-close" href="#"><i class="ft-x font-medium-3"></i></a> -->
    <!-- <a class="customizer-toggle box-shadow-3" href="#"><i class="ft-settings font-medium-3 spinner white"></i></a> -->
    <div class="customizr-content p-2">
        <h4 class="text-uppercase mb-0">
            <span id="c-heading"><!-- Heading --></span>
        </h4>
        <a class="customizr-close" href="#"><i class="ft-x font-medium-3"></i></a>
        <hr />
        <ul class="details-menu-bar font-small nav flex-nowrap" id="c-opt-header">
            
        </ul>
        <br />
        <div class="row mb-1" id="c-func-section">
            
        </div>
        <div class="card" id="c-print-area">
            <!-- <div class="p-badge">
               <div class="p-badge-inner"></div>
            </div> -->
            <div class="card-body" id="c-area">
                <div class="row">
                    <div class="col-md-6">
                        <h5><b>AIDEPOS</b></h5>
                        <p>
                            Company ID : 90605<br />
                            Tax ID : 100900800<br />
                            Goldcrest Mall<br />
                            Lusaka Zambia
                        </p>
                    </div>
                    <div class="col-md-6 text-right m-details">
                        <span style="font-size: 30px;" class="module">CREDIT NOTE</span><br/>

                    </div>
                </div>
                <hr/>

                <div class="row">
                    <div class="col-md-12">
                        <h3 id="module-title" style="text-transform: uppercase;"></h3>
                        <p>Invoice# INV-<span id="c-receipt-no"></span></p>
                    </div>
                </div>

                <div class="row pt-1">
                    <div class="col-md-8">
                        <h6><b>Bill To</b></h6>
                        <span id="c-cust-name"></span><br />
                        <span id="c-cust-address"></span>
                    </div>
                    <div class="col-md-4 pl-1 pb-1 account-summary account-summary-div text-right">
                        <span id="c-module-date"> </span>
                    </div>
                </div>

                <div class="row pt-2">
                    <div class="col-md-12">
                        <table class="table table-striped" id="c-module-items-tbl">
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
      
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div style="width: 70%;" class="float-right">
                            <table class="pcs-bdr-bottom" id="citemTable" cellspacing="0" border="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td valign="middle" style="padding: 10px 7px 5px;">
                                            Discount<br />
                                        </td>
                                        <td id="c-disc" valign="middle" style="width: 110px; padding: 10px 7px 10px;" class="text-align-right"></td>
                                    </tr>
                                    <tr style="height: 10px;" class="pcs-bdr-top">
                                        <td valign="middle" style="padding: 5px 7px;">Tax</td>
                                        <td valign="middle" style="width: 110px; padding: 10px 7px;" id="c-tax" class="text-align-right"></td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" style="padding: 10px 7px 5px;">
                                            Sub Total <br />
                                        </td>
                                        <td id="c-sub-total" valign="middle" style="width: 110px; padding: 10px 7px 10px;" class="text-align-right"></td>
                                    </tr>
                                    <tr style="height: 10px;" class="pcs-balance">
                                        <td valign="middle" style="padding: 10px 7px;" class="total-section-label pcs-bdr-top"><b>Total</b></td>
                                        <td id="c-total-amount" valign="middle" style="width: 110px; padding: 10px 7px;" class="text-align-right total-section-value pcs-bdr-top"><b></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade text-left" id="refund-cn-amt-mdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel19" aria-hidden="true" style="z-index:1054">
  <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel19">Refund Amount</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>

              <div class="modal-body">
                  <div class="row">
                      <div class="col-md-12">
                        <span>Customer Name: </span> <span id="c-customer-name"></span>
                      </div>
                      <div class="col-md-12 pt-1">
                          <div class="form-floating">
                              <select class="form-control form-select" name="payment_type" id="c-payment-type" />
                                <option value="">Select Payment Type</option>
                                <?php foreach($data['payment_type'] as $v) { ?>
                                <option value="<?=$v['id'];?>" <?= $v['id'] == 1 ? 'selected' : '' ?>><?=$v['payment_type'];?></option>
                                <?php } ?>
                              </select>
                              <label>Payment Type</label>
                          </div>
                      </div>
                      <div class="col-md-12 pt-1">
                          <div class="form-floating">
                              <input type="text" class="form-control" name="refund_amount" id="c-refund-amt" placeholder="Refund Amount" value="" />
                              <label>Amount</label>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default_new" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i> Cancel</button>
                  <button id="btnSubmitRefund" type="submit" class="btn btn-info"><i class="fa fa-file-o"></i> Save</button>
              </div>
      </div>
  </div>
</div>