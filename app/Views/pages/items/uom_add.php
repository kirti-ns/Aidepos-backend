      <div class="app-content content">
         <div class="content-wrapper">
            <?= view('includes/breadcrumb.php');?> 
            <div class="content-body">
               <div class="card">
                  <div class="card-body">
                        <?php $value = isset($data['uom'])?$data['uom']:"";  ?>
                     <form method="post" id="uom_form" name="uom_form">
                        <input type="hidden" name="action" id="action" value="post_items_data">
                        <input type="hidden" name="table_name" id="table_name" value="uom_master">
                        <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="row pt-1">
                              <div class="col-md-4">
                                  <div class="form-floating">
                                 <input type="text" class="form-control" name="formal_name" id="formal_name" placeholder="Formal Name"   value="<?= isset($value['formal_name'])?$value['formal_name']:''?>" >
                                    <label for="floatingInputGrid">Formal Name</label>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-floating">
                                    <input type="text" class="form-control" name="uom" id="uom" placeholder="UOM"  value="<?= isset($value['uom'])?$value['uom']:''?>" >
                                    <label for="floatingInputGrid">UOM</label>
                                 </div>
                                </div>
                                <div class="col-md-4">
                                 <div class="form-floating">
                                    <input type="number" class="form-control" name="decimal_point" id="decimal_point" placeholder="Decimal Point"  value="<?= isset($value['decimal_point'])?$value['decimal_point']:''?>" >
                                    <label for="floatingInputGrid">Decimal Point</label>
                                 </div>
                                </div>
                           </div>
                        </div>
                     </div>
                     <div class="row pt-1">
                           <div class="col-md-12">
                              <?= StatusInput(isset($value['status'])?$value['status']:'1');?>
                           </div>
                     </div>
                     <div class="form-footer text-right pt-1">
                           <?= SubmitButton(isset($value['id'])?$value['id']:'0');?>
                     </div>
                  </form>
                  </div>
               </div>
               
            </div>
         </div>
      </div>