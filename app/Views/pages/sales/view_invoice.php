<style type="text/css">
   .pcs-payment-details-section {
       padding: 20px;
       background-color: #FBFAFA;
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
   .pcs-pd-section-label, .pcs-pd-section-value {
       padding-top: 10px;
   }

   .pcs-pd-section-label {
       width: 45%;
   }
   thead {
      background-color: #FBFAFA;
   }
   .pcs-bdr-top {
      border-top: 1px solid #d8d8d7;
   }
</style>
<div class="app-content content">
   <div class="content-wrapper">
      <div class="content-header row">
         <div class="content-header-left col-md-8 col-12 breadcrumb-new">
            <div class="row breadcrumbs-top d-inline-block">
               <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item">
                        <a href="index.html">
                           <p style="color:red;">Payment</p>
                        </a>
                     </li>
                     <li class="breadcrumb-item active">Payment Detail
                     </li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
      <div class="content-body">
         <div class="card">
            <div class="card-body">
               <div class="col-md-12 text-right">
                  <div class="heading-elements" >
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

               <div class="row">
                  <div class="col-md-12">
                     <h5><b>AIDEPOS</b></h5>
                     <p>
                        Company ID : 90605<br/>
                        Tax ID : 100900800<br/>
                        Goldcrest Mall<br/>
                        Lusaka Zambia   
                     </p>
                  </div>
               </div>

               <hr>
               
               <div class="row">
                  <div class="col-md-12">
                     <h3><b>SALES RECEIPT</b></h3>
                     <p>
                        Sales Receipt# SR-00001  
                     </p>
                  </div>
               </div>
               
               <div class="row pt-1">
                  <div class="col-md-8">
                     <h6><b>Bill To</b></h6>
                     <?= isset($data['invoice'])?$data['invoice']['registerd_name']:'' ?><br/>
                     <?= isset($data['invoice'])?$data['invoice']['address']:'' ?>
                  </div>
                  <div class="pl-1 pb-1 account-summary account-summary-div">
                     <span>
                        <h6>Receipt Date: <span class="summary-amount" style="font-weight: 500"><?= isset($data['invoice'])?$data['invoice']['invoice_date']:'' ?></span></h6>
                     </span>
                  </div>  
               </div>

               <div class="row pt-2">
                  <div class="col-md-12">
                     <table class="table table-striped">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Item Name</th>
                           <th>Qty</th>
                           <th>Rate</th>
                           <th>Amount</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                        if(isset($data['sell_items'])) {
                           $i = 1;
                           foreach ($data['sell_items'] as $key => $value) {
                        ?>
                        <tr>
                           <td class="storeColor"><?= $i; ?></td>
                           <td><?= $value['item_name']; ?></td>
                           <td><?= $value['qty']; ?></td>
                           <td><?= $value['rate']; ?></td>
                           <td><?= $value['item_amount']; ?></td>
                        </tr>
                        <?php $i++; } } ?>
                     </tbody>
                  </table>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-5">
                     <div style="width: 70%;padding: 10px 10px 3px 3px;" class="total-number-section">
                        <div class="pcs-payment-details-section">
                           <div class="pcs-label pcs-pd-section-title pcs-font-bolder">Payment Details</div>

                           <table style="width: 95%;border-collapse: collapse;table-layout: fixed;" cellspacing="0" cellpadding="0" border="0">
                             <tbody>
                               <tr>
                                 <td class="pcs-label pcs-pd-section-label">Payment Mode</td>
                                 <td class="pcs-font-bolder pcs-pd-section-value"><?= isset($data['invoice'])?$data['invoice']['p_mode']:'' ?></td>
                               </tr>
                             </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-7">
                     <div style="width: 50%;" class="float-right">
                        <table class="pcs-bdr-bottom" id="itemTable" cellspacing="0" border="0" width="100%">
                          <tbody>
                            <tr>
                              <td valign="middle" style="padding: 10px 7px 5px;" class="text-align-right">Sub Total <br><!-- <span style="color:#666;font-size:10px;">(Tax Inclusive)</span> --></td>
                              <td id="tmp_subtotal" valign="middle" style="width:110px;padding: 10px 7px 10px;" class="text-align-right"><?= isset($data['invoice'])?$data['invoice']['sub_total']:'' ?></td>
                            </tr>
                            <tr style="height:10px;">
                              <td valign="middle" style="padding: 5px 7px;" class="text-align-right">Tax(15%)</td>
                              <td valign="middle" style="width:110px;padding: 10px 7px;" class="text-align-right"><?= isset($data['invoice'])?$data['invoice']['total_tax']:'' ?></td>
                            </tr>
                            <!-- <tr style="height:10px;">
                              <td valign="middle" style="padding: 5px 7px;" class="text-align-right">Discount</td>
                              <td valign="middle" style="width:110px;padding: 10px 7px;" class="text-align-right">0.00</td>
                            </tr> -->
                            <tr style="height:10px;" class="pcs-balance">
                              <td valign="middle" style="padding: 10px 7px;" class="text-align-right total-section-label pcs-bdr-top"><b>Total</b></td>
                              <td id="tmp_total" valign="middle" style="width:110px;padding: 10px 7px;" class="text-align-right total-section-value pcs-bdr-top"><b><?= isset($data['invoice'])?$data['invoice']['total_amount']:'' ?></b></td>
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
</div>