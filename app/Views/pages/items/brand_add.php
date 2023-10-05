      <div class="app-content content">
         <div class="content-wrapper">
            <?= view('includes/breadcrumb.php');?> 
            <div class="content-body">
               <div class="card">
                  <div class="card-body">
                        <?php $value = isset($data['brand'])?$data['brand']:"";  ?>
                     <form method="post" id="brand_form" name="brand_form">
                          <input type="hidden" name="action" id="action" value="post_items_data">
                        <input type="hidden" name="table_name" id="table_name" value="brandmasters">
                        <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                      <div class="row g-2">
                           <div class="col-md">
                              <div class="form-floating">
                                 <input type="text" class="form-control" name="brand_name" id="brand_name" placeholder="brand_name" value="<?= isset($value['brand_name'])?$value['brand_name']:''?>">
                                 <label for="brand_name">Enter Brand Name</label>
                              </div>
                           </div>
                           <div class="col-md">
                           </div>
                        </div>
                        <hr>
                     <!-- <div class="row">
                        <div class="col-12">
                           <div class="card">
                              <div class="card-content collapse show">
                                 <div class="">
                                    <p class="text-bold-400">Add Items</p>
                                    <div class="repeater-default">
                                       <div data-repeater-list="car">
                                          <div class="">
                                             <table id="Add-Brand" class="table  table-bordered zero-configuration">
                                                <thead class="threadClass">
                                                   <tr>
                                                      <th></th>
                                                      <th>SKU</th>
                                                      <th>Item ID</th>
                                                      <th>Category</th>
                                                      <th>Sub Category</th>
                                                      <th>UOM</th>
                                                      <th>Cost</th>
                                                      <th>Price</th>
                                                      <th>Stock</th>
                                                      <th>Stock Value</th>
                                                      <th>Action</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   <tr>
                                                      <td class="text-center">..</td>
                                                      <td>1026</td>
                                                      <td>Bags Bin Pap</td>
                                                      <td>Food</td>
                                                      <td>Burgers</td>
                                                      <td>KGS</td>
                                                      <td>$478</td>
                                                      <td>$478</td>
                                                      <td>7896</td>
                                                      <td>$7896</td>
                                                      <td class="text-center">
                                                         <a href="" class="transh-icon-color"><i class="fa fa-trash-o"></i></a>
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                       <div class="form-group overflow-hidden">
                                          <div class="col-12">
                                             <button  onclick="addBrandField();" data-repeater-create type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Item</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 
                              </div>
                           </div>
                        </div>
                     </div> -->
                     <div class="form-footer">
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
      </div>