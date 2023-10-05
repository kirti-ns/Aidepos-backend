  <div class="app-content content">
      <div class="content-wrapper">
          <?= view('includes/breadcrumb.php');?> 
 <div class="card card-content collapse show">
      <div class="card-body card-dashboard">
            <div class="row">
               <div class="col-12">
                  <div class="card">
                     <div class="card-content collapse show">
                        <?php $value = isset($data['terminals'])?$data['terminals']:"";
                        
                            if(!empty($value)){
                            $stores = json_decode($value['store_id']);
                            }
                        ?>
                        <form method="post" id="terminal_form" name="terminal_form">
                           <input type="hidden" name="action" id="action" value="post_data_settings">
                            <input type="hidden" name="table_name" id="table_name" value="terminals">
                            <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                           <div class="row">
                              <div class="col-md-4">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="terminal_name" name="terminal_name" placeholder="terminal name" value="<?= isset($value['terminal_name'])?$value['terminal_name']:''?>" >
                                 <label for="floatingSelectGrid">Terminal Name</label>
                              </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-floating">
                                 <select class="form-select" name="store_id" id="store_id" aria-label="Floating label select example"  >
                                    <option value="">Please Select</option>
                                    <?php 
                                    if(!empty($data['stores']))
                                    {
                                        foreach($data['stores'] as $row)
                                        { ?>
                                           <option <?= isset($value['store_id']) && ($value['store_id'] == $row['id']) || (isset($data['store_id']) && $data['store_id'] == $row['id'])?'selected':''?> value="<?= $row['id']?>"><?=$row['store_name']?> </option>
                                          <?php
                                        }
                                    } 
                                    
                                    ?>
                                    </select>
                                 <label for="floatingSelectGrid">Store Name</label>
                              </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-floating">
                                 <select class="form-select" name="location_id" id="location_id" aria-label="Floating label select example"  >
                                    <option value="">Please Select</option>
                                    <?php 
                                    if(!empty($data['location']))
                                    {
                                        foreach($data['location'] as $row)
                                        { ?>
                                           <option <?= isset($value['location_id']) && ($value['location_id'] == $row['id']) || (isset($data['location_id']) && $data['location_id'] == $row['id'])?'selected':''?> value="<?= $row['id']?>"><?=$row['location_description']?> </option>
                                          <?php
                                        }
                                    } 
                                    
                                    ?>
                                    </select>
                                 <label for="floatingSelectGrid">Location</label>
                              </div>
                           </div>
                           
                        </div>
                        <br>
                        <div class="row">

                            <div class="col-md-4">
                               <div class="form-floating">
                                 <select class="form-select" name="type" id="type" aria-label="Floating label select example"  >
                                    <option value="">Select</option>
                                    <option <?= isset($value['type']) && ($value['type'] == 'POS')?'selected':''?> value="POS">POS</option>
                                 </select>
                                 <label for="floatingSelectGrid">Type</label>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="sales_invoice_prefix" name="sales_invoice_prefix" placeholder="sales invoice prefix" value="<?= isset($value['sales_invoice_prefix'])?$value['sales_invoice_prefix']:''?>" >
                                 <label for="floatingSelectGrid">Sales Invoice Prefix</label>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-floating">
                                 <input type="number" class="form-control" id="sales_invoice_starting_no" name="sales_invoice_starting_no" placeholder="sales invoice starting no" value="<?= isset($value['sales_invoice_starting_no'])?$value['sales_invoice_starting_no']:''?>" >
                                 <label for="floatingSelectGrid">Sales Invoice Starting No</label>
                              </div>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                              <div class="form-floating">
                                 <input type="text" class="form-control" id="sales_return_prefix" name="sales_return_prefix" placeholder="sales return prefix" value="<?= isset($value['sales_return_prefix'])?$value['sales_return_prefix']:''?>" >
                                 <label for="floatingSelectGrid">Sales Return Prefix</label>
                              </div>
                           </div>
                            <div class="col-md-4">
                              <div class="form-floating">
                                 <input type="number" class="form-control" name="sales_return_starting_no" id="sales_return_starting_no" placeholder="sales return starting no" value="<?= isset($value['sales_return_starting_no'])?$value['sales_return_starting_no']:''?>" >
                                 <label for="floatingSelectGrid">Sales Return Starting No</label>
                              </div>
                           </div>
                        </div>
                          <br>
                          <div class="row">
                            <div class="col-md-6">
                             <?= StatusInput(isset($value['status'])?$value['status']:'1');?>
                           </div>
                            <div class="col-md-6 text-right">
                              <?= SubmitButton(isset($value['id'])?$value['id']:'0');?>
                           </div>
                          </div>
                       </form>
                     </div>
                  </div>
               </div>
            </div>
      </div>
   </div>