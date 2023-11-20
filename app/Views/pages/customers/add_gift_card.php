<style type="text/css">
  .select2-container .select2-selection--single {
    height: 52px;
  }
  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 60px;
  }
</style>
<div class="app-content content">
       <div class="content-wrapper">
      <?= view('includes/breadcrumb.php');?> 
      <div class="content-body">
         <div class="card">
            <div class="card-body">
               <?php $value = isset($data['giftcard'])?$data['giftcard']:"";?>
                <form method="post" id="gift_card_form" name="gift_card_form">
                   <input type="hidden" name="action" id="action" value="post_data">
                      <input type="hidden" name="table_name" id="table_name" value="giftcards">
                      <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                      <section id="form-repeater">
                        <div class="row g-2">
                          <div class="col-md-6">
                            <div class="form-floating">
                              <select class="select2 form-control" id="batch_id" name="batch_id">
                                  <?php if(!empty($data['giftcardData'])){
                                  foreach($data['giftcardData'] as $row){
                                  ?>
                                  <option <?= isset($value['batch_id']) && ($value['batch_id'] == $row['id'])?'selected':''?> value="<?=$row['id']?>"><?=$row['batch_name']?></option>
                                  <?php } } ?>
                              </select>
                              <div class="wrapper" style="display: none;">
                                <a href="#" class="font-weight-300 font-color add-new-batch">&#43; Add New Batch</a>
                              </div>
                               <!-- <input type="text" name="batch_id" class="form-control" id="batch_id" placeholder="Gift Card Name" value="<?= isset($value['batch_name'])?$value['batch_name']:''?>"> -->
                               <label for="floatingInputGrid">Enter Gift Card Name</label>
                               <!-- <div class="form-control-position" style="padding: 10px;">
                                  <i class="fa fa-search"></i>
                               </div> -->
                            </div>
                          </div>
                          <div class="col-md-6">
                             <div class="form-floating">
                                 <input type="text" class="form-control" id="voucher_card_no" placeholder="Voucher Card No" name="voucher_card_no" value="<?= isset($value['voucher_card_no'])?$value['voucher_card_no']:''?>" >
                                <label for="voucher_card_no">Voucher Card No*</label>
                             </div>
                          </div>
                        </div>
                      </section>
                      <br>
                      <div class="row">
                        <div class="col-md-3">
                           <div class="form-floating">
                               <input type="date" class="form-control" id="expiry_date" placeholder="Expiry Date" name="expiry_date" value="<?= isset($value['expiry_date'])?$value['expiry_date']:''?>" >
                              <label for="expiry_date">Expiry Date*</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-floating">
                               <input type="text" class="form-control" id="amount" placeholder="amount" name="amount" value="<?= isset($value['amount'])?$value['amount']:''?>" >
                              <label for="amount">Amount*</label>
                           </div>
                        </div>
                      </div>
         
                      <div class="form-footer pt-1">
                        <div class="row">
                          <div class="col-md-6">
                             <?= StatusInput(isset($value['status'])?$value['status']:'1');?>
                          </div>
                          <div class="col-md-6 text-right">
                             <?= SubmitButton(isset($value['id'])?$value['id']:'0');?>
                          </div>
                       </div>
                      </div>
                </form>
            </div>
         </div>
      </div>        
    </div>
</div>

<!-- Model Start -->         
      <div class="modal fade text-left" id="add-new-batch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
         <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel18">Add New Gift Card Batch</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
               </div>
              <form method="post" id="model_gift_card_form" name="model_gift_card_form">
                <div class="modal-body">
                    <input type="hidden" name="action" id="action" value="post_data">
                    <input type="hidden" name="table_name" id="table_name" value="giftcardmasters">
                    <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                    <div class="row">
                       <div class="col-md-12 ">
                          <div class="form-floating">
                             <input type="text" class="form-control" name="batch_name" id="batch_name" placeholder="Batch Name" value="" >
                             <label for="floatingInputGrid">Batch Name</label>
                          </div>
                       </div>
                    </div>
                 </div>
                 <div class="modal-footer">
                     <button  type="button" data-dismiss="modal" aria-label="Close" class="btn btn-default_new"><i class="fa fa-close"></i> Cancel</button>
                     <button  type="submit" id="btnSubmit" class="btn btn-info"><i class="fa fa-file-o"></i> Save</button>
                 </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Model End--> 
    
     
    
     