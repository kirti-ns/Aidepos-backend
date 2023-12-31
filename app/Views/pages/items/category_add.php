      <div class="app-content content">
         <div class="content-wrapper">
             <?= view('includes/breadcrumb.php');?> 
            <div class="content-body">
               <form method="post" id="category_form" name="category_form">
               <div class="card">
               <div class="card-body">
                  <?php $value = isset($data['category'])?$data['category']:"";  ?>
                  <input type="hidden" name="action" id="action" value="post_items_data">
                  <input type="hidden" name="table_name" id="table_name" value="categories">
                  <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Category Name" value="<?= isset($value['category_name'])?$value['category_name']:''?>">
                                       <label for="floatingSelectGrid">Category Name</label>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="form-floating">
                                       <input type="number" class="form-control" id="prefix" name="prefix" placeholder="SKU Prefix"  value="<?= isset($value['prefix'])?$value['prefix']:''?>">
                                       <label for="prefix">SKU Prefix</label>
                                    </div>
                                 </div>
                              </div>
                              <div class="row pt-2">
                                
                                 <div class="col-md-6">
                                    <div class="form-floating">
                                       <input type="text" class="form-control" id="custom_report" name="custom_report" placeholder="Custom Report"  value="<?= isset($value['custom_reports'])?$value['custom_reports']:''?>">
                                       <label for="custom_report">Custom Report</label>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
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