      <div class="app-content content">
         <div class="content-wrapper">
            <?= view('includes/breadcrumb.php');?> 
            <div class="content-body">
               <?php $value = isset($data['stock_adjust'])?$data['stock_adjust']:"";  ?>
                       
               <div class="card">
                  <div class="card-body">
                      <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:""?>">
                      <div class="row g-3">
                        <div class="col-md-3">
                           <div class="form-floating">
                            <input type="text" class="form-control" value="<?= $value['reason'] ?>" disabled>
                            <label for="floatingSelectGrid">Reason</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-floating">
                              <div class="form-floating">
                                <input type="text" class="form-control" value="<?= $value['store_name'] ?>" disabled>  
                                <label for="floatingSelectGrid">Store*</label>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-floating">
                              <input type="text" class="form-control" value="<?= $value['location_description'] ?>" disabled>
                              <label for="floatingSelectGrid">Location*</label>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-floating">
                            <input type="text" class="form-control" value="<?= $value['narration'] ?>" disabled>
                            <label for="floatingSelectGrid">Narration</label>
                           </div>
                        </div>
                      </div>
                  </div>
               </div>
               <div class="card">
                  <div class="card-body">
                     <section id="form-repeater">
                        <div class="row">
                           <div class="col-12">
                              <div class="card">
                                 <div class="card-content collapse show">
                                    <div class="card-body">
                                       <div class="repeater-default">
                                          <div data-repeater-list="car">
                                             <div class="">
                                                <table class="table  table-bordered ">
                                                   <thead class="threadClass">
                                                      <tr>
                                                        <th>Item Name</th>
                                                        <th>Quantity</th>
                                                        <th>Item Per Cost</th>
                                                        <th>Cost</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                     <?php if(isset($data['stocks_item']) && !empty($data['stocks_item'])) { 
                                                      foreach($data['stocks_item'] as $k => $row2) { ?>
                                                      <tr class="new-row">
                                                        <td><?= $row2['item_name'] ?></td>
                                                        <td><?= $row2['quantity'] ?></td>
                                                        <td><?= $row2['item_per_cost'] ?> </td>
                                                        <td><?= $row2['cost']  ?> </td>
                                                      </tr>
                                                   <?php } } ?>
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
                     </section>
                  </div>
               </div>

            </div>
         </div>
      </div>
      </div>