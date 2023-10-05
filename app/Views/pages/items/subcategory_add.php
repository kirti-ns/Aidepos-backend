      <div class="app-content content">
         <div class="content-wrapper">
             <?= view('includes/breadcrumb.php');?> 
            <div class="content-body">
               <form method="post" id="model_subcategory_form" name="model_subcategory_form">
               <div class="card">
               <div class="card-body">
                  <?php $value = isset($data['subcategory'])?$data['subcategory']:"";  ?>
                  <input type="hidden" name="action" id="action" value="post_items_data">
                  <input type="hidden" name="table_name" id="table_name" value="subcategories">
                  <input type="hidden" name="subCatform" value="yes">
                  <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="subcategory_name" name="subcategory_name" placeholder="Subcategory Name" value="<?= isset($value['subcategory_name'])?$value['subcategory_name']:''?>">
                                       <label for="floatingSelectGrid">Subcategory Name</label>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
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