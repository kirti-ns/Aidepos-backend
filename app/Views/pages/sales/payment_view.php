
      <div class="app-content content">
      <div class="content-wrapper">
         <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 breadcrumb-new">
               <div class="row breadcrumbs-top d-inline-block">
                  <div class="breadcrumb-wrapper col-12">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                           <a href="<?=base_url()?>/sales#payments">
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
                  <?php $value = isset($data['payment'])?$data['payment']:""; ?>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="heading-elements float-right">
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

                        <h3 class="list-group-item-heading">AIDEPOS <i class="fa fa-pencil" style="padding:5px;font-size:15px;"></i><i class="fa fa-trash-o" style="padding:5px;color:red;font-size:15px;"></i></h3>

                     </div>

                     <div class="col-md-12">
                        <h6>Zambia</h6>
                        <hr>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-12">
                        <h6><b>Payment Receipt</b>&nbsp;&nbsp;$<?= isset($value['amount_received'])?$value['amount_received']:""; ?></h6>
                        <hr>
                     </div>
                  </div>

                  
                  <div class="row">
                     <div class="col-md-4">
                        <h6>Bill To</h6>
                        <h5><b><?= isset($value['registerd_name'])?$value['registerd_name']:""; ?></b></h5>

                        <div class="account-summary-div pb-1 pt-1" style="border-bottom: 1px solid #dfdfdf;">
                           <div class="pl-1 border-left-info border-left-3 ">
                              <div class="account-summary">
                                 <h6>Payment Date:  <span class="summary-val"><?= isset($value['payment_date'])?date('d M, Y', strtotime($value['payment_date'])):""; ?></span></h6>
                                 <!-- <h6>Reference Number: <span class="summary-val">55</span></h6> -->
                                 <h6>Payment Mode: <span class="summary-val "><?= isset($value['payment_type'])?$value['payment_type']:""; ?></span></h6>
                              </div>
                           </div>
                        </div>
                        <div class="pl-1 pb-1 pt-1 account-summary account-summary-div">
                           <span>
                              <h6>Amount Received: <span class="summary-val">$<?= isset($value['amount_received'])?$value['amount_received']:""; ?></span></h6>
                           </span>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div style="padding:15px;background-color: #f4f4f4;border:1px solid #dbd4d4;height:100px;overflow-y: scroll;">
                           Notes: <br/>
                           <span style="color:#000;"><?= isset($value['notes'])?$value['notes']:""; ?></span>
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-12">
                        <h6><b>Payment for</b></h6>

                        <table class="table table-striped table-bordered ">
                           <thead>
                              <tr>
                                 <th>Invoice Number</th>
                                 <th>Invoice Date</th>
                                 <th>Invoice Amount</th>
                                 <th>Payment Amount</th>
                              </tr>
                           </thead>
                           <tbody>
                              <td><a href="<?=base_url()?>sales?id=<?=$value['invoice_id']?>#invoice-list" class="storeColor"><?= isset($value['invoice_id'])?$value['invoice_id']:"" ?></a></td>
                              <td><?= isset($value['invoice_date'])?$value['invoice_date']:"" ?></td>
                              <td><?= isset($value['total_amount'])?$value['total_amount']:"" ?></td>
                              <td><?= isset($value['amount_received'])?$value['amount_received']:"" ?></td>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  
               </div>
            </div>
         </div>
      </div>
      
<!--statement Model Start -->         
<div class="modal fade text-left" id="preview-statement" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><b>Preview</b></h4>
            <div>
               <a href="" class="btn btn-outline-info mr-1"><i class="fa fa-print"></i> Print</a>
               <button type="button" class="btn btn-info import-payments"> <i class="fa fa-download"></i> Download</button>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
         </div>
         <div class="modal-body">
            <p style="margin-bottom: 0px;">To <span style="float: right;">AIDPOS</span></p>
            <p class="text-bold-600">Katema Nyirenda<span style="float: right;">Zambia</span></p>
            <div class="row">
               <div class="col-md-5">
                  <div class="border-bottom border-top bg-default">
                     <b> &nbsp;Payment Receipt &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$100.00</b>
                  </div>
                  <div class="border-bottom account-summary-div pb-1 pt-1">
                     <div class=" pl-1 border-left-info border-left-3 ">
                        <div class="account-summary">
                           <span>Payment Date:<span class="summary-val"><b><?= isset($value['payment_date'])?$value['payment_date']:"" ?></b></span></span> <span>Reference Number: <span class="summary-val"><b><?= isset($value['reference_id'])?$value['reference_id']:"" ?></b></span></span> <span>Payment Mode: <span class="summary-val "><b><?= isset($value['payment_mode'])?$value['payment_mode']:"" ?></b></span></span>   
                        </div>
                     </div>
                  </div>
                  <div class="pl-1 pb-1 account-summary account-summary-div">
                     <span>Amount Received  <span class="summary-val"><b><?= isset($value['amount_received'])?$value['amount_received']:"" ?></b></span></span>
                  </div>
               </div>
            </div>
            <div class="table-responsive">
               <table class="table table-xs">
                  <thead class="thead-dark">
                     <tr>
                     <tr>
                        <th>Invoice Number</th>
                        <th>Invoice Date</th>
                        <th>Invoice Amount</th>
                        <th>Payment Amount</th>
                     </tr>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>&nbsp;&nbsp;&nbsp;<?= isset($value['payment_date'])?$value['payment_date']:"" ?></td>
                        <td>&nbsp;&nbsp;&nbsp;<?= isset($value['invoice_date'])?$value['payment_date']:"" ?></td>
                        <td>&nbsp;&nbsp;&nbsp;<?= isset($value['payment_date'])?$value['payment_date']:"" ?></td>
                        <td>&nbsp;&nbsp;&nbsp;<?= isset($value['payment_date'])?$value['payment_date']:"" ?></td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <!-- <div class="modal-footer">
               </div> -->
         </div>
      </div>
   </div>
</div>
<!--statement Model End--> 
<!-- Model Start -->         
<div class="modal fade text-left" id="import-payments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18">Import Payments</h4>
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
                     <input type="file" onChange="dragNdrop(event)"  ondragover="drag()" ondrop="drop()" id="uploadFile"/>
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
            <div class="modal-footer">
               <a href=""><i class="fa fa-download"></i> Download Format</a>
               <button type="button" class="btn btn-info"> <i class="fa fa-file-o"></i> Submit</button>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Model End-->