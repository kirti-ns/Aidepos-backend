      <div class="app-content content">
         <div class="content-wrapper">
             <?= view('includes/breadcrumb.php');?> 
            <div class="content-body">
               <form method="post" id="department_form" name="department_form">
               <div class="card">
               <div class="card-body">
                  <?php $value = isset($data['department'])?$data['department']:"";  ?>
                  <input type="hidden" name="action" id="action" value="post_items_data">
                  <input type="hidden" name="table_name" id="table_name" value="department">
                  <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="department_name" name="department_name" placeholder="Department Name" value="<?= isset($value['department_name'])?$value['department_name']:''?>">
                                       <label for="floatingSelectGrid">Department Name</label>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="markup_percent" name="markup_percent" placeholder="Markup %" value="<?= isset($value['markup_percent'])?$value['markup_percent']:''?>">
                                       <label for="floatingSelectGrid">Markup %</label>
                                    </div>
                                 </div>
                                 <div class="col-md-6 pt-1">
                                    <?= StatusInput(isset($value['status'])?$value['status']:'1');?>
                                 </div>
                              </div>

                              <div class="form-footer text-right">
                                 <?= SubmitButton(isset($value['id'])?$value['id']:'0');?>
                              </div>
                           </div>
                        </div>
                        
                  </div>
               </div>
               </form>
            </div>
         </div>
      </div>
    </div>