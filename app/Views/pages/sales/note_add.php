      <div class="app-content content">
         <div class="content-wrapper">
             <?= view('includes/breadcrumb.php');?> 
            <div class="content-body">
                <?php $value = isset($data['note'])?$data['note']:"";  ?>
               <form method="post" id="note_form" name="note_form">
               <div class="card">
                  <div class="card-body">
                     <h6>Store Name</h6>
                     <h5><b>Freshcommerce</b></h5>
                     <div class="row g-4">
                        <div class="col-md">
                           <div class="form-floating">
                              <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                 <option selected>Authentic Corner</option>
                                 <option value="1">One</option>
                                 <option value="2">Two</option>
                                 <option value="3">Three</option>
                              </select>
                              <label for="floatingSelectGrid">Customer Name*</label>
                           </div>
                        </div>
                        <div class="col-md">
                           <div class="form-floating">
                              <input type="text" class="form-control" id="floatingInputGrid" placeholder="Invoice" value="">
                              <label for="floatingSelectGrid">Invoice*</label>
                           </div>
                        </div>
                        <div class="col-md">
                           <div class="form-floating">
                              <input type="text" class="form-control" id="floatingInputGrid" placeholder="Order Number" value="">
                              <label for="floatingSelectGrid">Order Number*</label>
                           </div>
                        </div>
                        <div class="col-md">
                           <div class="form-floating">
                              <input type="Date" class="form-control" id="floatingInputGrid" placeholder="Invoice Date" value="">
                              <label for="floatingSelectGrid">Invoice Date</label>
                           </div>
                        </div>
                     </div>
                     <br>
                     <div class="row g-4">
                        <div class="col-md">
                           <div class="form-floating">
                              <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                 <option selected>Due on Receipt</option>
                                 <option value="1">One</option>
                                 <option value="2">Two</option>
                                 <option value="3">Three</option>
                              </select>
                              <label for="floatingSelectGrid">Terms</label>
                           </div>
                        </div>
                        <div class="col-md">
                           <div class="form-floating">
                              <input type="date" class="form-control" id="floatingInputGrid" placeholder="Due Date" value="">
                              <label for="floatingInputGrid">Due Date</label>
                           </div>
                        </div>
                        <div class="col-md">
                           <div class="form-floating">
                              <input type="text" class="form-control" id="floatingInputGrid" placeholder="Subject" value="">
                              <label for="floatingInputGrid">Subject  <i class="fa fa-info-circle"></i></label>
                           </div>
                        </div>
                        <div class="col-md">
                           <div class="form-floating">
                              <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                 <option selected>ZAR (R) - South African Rand</option>
                                 <option value="1">One</option>
                                 <option value="2">Two</option>
                                 <option value="3">Three</option>
                              </select>
                              <label for="floatingSelectGrid">Exchange Currency</label>
                           </div>
                        </div>
                     </div>
                     <br>
                     <div class="row">
                        <div class="col-md">
                           <div class="form-floating">
                              <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                 <option selected>Credit Note</option>
                                 <option value="1">One</option>
                                 <option value="2">Two</option>
                                 <option value="3">Three</option>
                              </select>
                              <label for="floatingSelectGrid">Invoice Type</label>
                           </div>
                        </div>
                        <div class="col-md">
                            <?= StatusInput(isset($value['status'])?$value['status']:'1');?>
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
                                                <table id="myTable" class="table  table-bordered zero-configuration">
                                                   <thead class="threadClass">
                                                      <tr>
                                                         <th></th>
                                                         <th>Item ID</th>
                                                         <th>Item Name</th>
                                                         <th>UOM</th>
                                                         <th>Quantity</th>
                                                         <th>Rate</th>
                                                         <th>Discount</th>
                                                         <th>Tax</th>
                                                         <th>Currency</th>
                                                         <th>Amount</th>
                                                         <th>Action</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                      <tr>
                                                         <td>..</td>
                                                         <td class="text-center">AIDE-000001</td>
                                                         <td class="text-center">Meat and Seafood</td>
                                                         <td class="text-center">Package</td>
                                                         <td class="text-center">20</td>
                                                         <td class="text-center">$25.00</td>
                                                         <td class="text-center">10 %</td>
                                                         <td class="text-center">FICA (18%)</td>
                                                         <td class="text-center">ZAR 7663.8</td>
                                                         <td class="text-center">$450.00</td>
                                                         <td class="text-center"><a href=""><i class="fa fa-file-o"></i></a> &nbsp;&nbsp;&nbsp; <a href="" class=""><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;
                                                            <a href="" class="transh-icon-color"><i class="fa fa-trash-o"></i></a>
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <td>..</td>
                                                         <td class="text-center">AIDE-000002</td>
                                                         <td class="text-center">Oils,Sauces,Salad Dressings</td>
                                                         <td class="text-center">Gross</td>
                                                         <td class="text-center">05</td>
                                                         <td class="text-center">$35.88</td>
                                                         <td class="text-center">0.8 ZMW</td>
                                                         <td class="text-center">-</td>
                                                         <td class="text-center">ZAR 7663.8</td>
                                                         <td class="text-center">$174.20</td>
                                                         <td class="text-center"><a href=""><i class="fa fa-file-o"></i></a> &nbsp;&nbsp;&nbsp; <a href="" class=""><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;
                                                            <a href="" class="transh-icon-color"><i class="fa fa-trash-o"></i></a>
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </div>
                                          </div>
                                          <div class="form-group overflow-hidden">
                                             <div class="col-12">
                                                <button  onclick="addItem();" data-repeater-create type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Item</button>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class="col-md-5">
                                             <textarea placeholder="Customer Notes" rows="4" cols="50" class="form-control"></textarea>
                                          </div>
                                          <div class="col-md-3"></div>
                                          <div class="col-md-4 add-form-footer p-2">
                                             <div class="row">
                                                <div class="col-md-4">
                                                   <span>Subtotal</span>
                                                </div>
                                                <div class="col-md-4">
                                                </div>
                                                <div class="col-md-4">
                                                   <span>$620.00</span>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-4">
                                                   <span>Tax FICA (18%)</span>
                                                </div>
                                                <div class="col-md-4">
                                                </div>
                                                <div class="col-md-4">
                                                   <span>$81.00</span>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-4">
                                                   <span><input type="text" class="form-control adjustment" name="" placeholder="Adjustment"></span>
                                                </div>
                                                <div class="col-md-4">
                                                   <input type="text" class="form-control amount-footer" name="" placeholder="Amount">
                                                   <i class="fa fa-info-circle"></i>
                                                </div>
                                                <div class="col-md-4 form-footer-center">
                                                   <span>$0.00</span>
                                                </div>
                                             </div>
                                             <hr>
                                             <div class="row form-footer-right">
                                                <div class="col-md-4">
                                                   <span>Total (ZWM)</span>
                                                </div>
                                                <div class="col-md-4">
                                                </div>
                                                <div class="col-md-4">
                                                   <span>$720.00</span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-footer text-right">
                                       <?= SubmitButton(isset($value['id'])?$value['id']:'0');?>
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