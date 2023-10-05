      <div class="app-content content">
      <div class="content-wrapper">
         <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 breadcrumb-new">
               <h3 class="content-header-title mb-0 d-inline-block">Edit Item</h3>
            </div>
         </div>
         <div class="content-body">
            <div class="card">
               <div class="card-body">
                  <div class="row">
                     <!-- Icon Tab with bottom line -->
                     <div class="col-xl-12 col-lg-12">
                        <ul class="nav nav-tabs navigate-tabs nav-underline nav-justified mb-1" id="tab-bottom-line-drag">
                           <li class="nav-item">
                              <a class="nav-link active" id="activeIcon12-tab1" data-toggle="tab" href="#standard-item" aria-controls="activeIcon12" aria-expanded="true">
                                 <h4 class="card-title"><span>Standard Item</span> <small class="block">This Item has one SKU<br> with its own inventory</small></h4>
                              </a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#item-with-varience" aria-controls="linkIcon12" aria-expanded="false">
                                 <h4 class="card-title"><span>Item With Variance</span> <small class="block">This item has different<br>variants like sizes, colors</small></h4>
                              </a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" id="linkIcon12-tab1" data-toggle="tab" href="#composite-item" aria-controls="linkIcon12" aria-expanded="false">
                                 <h4 class="card-title"><span>Composite Item</span> <small class="block">This item contains a specified<br>
                                    quantity of other items</small>
                                 </h4>
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="tab-content ">
                     <div role="tabpanel" class="tab-pane active show" id="standard-item" aria-labelledby="activeIcon12-tab1" aria-expanded="true">
                        <div class="card card-content collapse show">
                           <div class="card-body card-dashboard">
                              <form id="standard-item-form">
                                 <p class="text-bold-400">Item Details</p>
                                 <div class="row">
                                    <div class="col-8 border-right">
                                       <div class="row">
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="Food" >
                                                <label for="floatingInputGrid">Item Name</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="Food" >
                                                <label for="floatingInputGrid">SKU/Barcode</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="Food" >
                                                <label for="floatingInputGrid">Supply Price</label>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row pt-1">
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="" >
                                                <label for="floatingInputGrid">Markup</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="" >
                                                <label for="floatingInputGrid">Retail Price</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="" >
                                                <label for="floatingInputGrid">Minimum Retail Price</label>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row pt-1">
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="" >
                                                <label for="floatingInputGrid">Current Inventory</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="" >
                                                <label for="floatingInputGrid">Inventory Value</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="" >
                                                <label for="floatingInputGrid">Re-order Point</label>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row pt-1">
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Category</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Sub Category</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">UOM</label>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row pt-1">
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Tax</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Purchase Tax</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Brand</label>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row pt-1">
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Item Modifier</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Status</label>
                                             </div>
                                             <div class="new_sub_category">
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="Food" >
                                                <label for="floatingInputGrid">Item Description</label>
                                             </div>
                                             <div class="new_category">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row pt-1">
                                          <div class="col-md-12">
                                             <input type="radio" class="" name="status" id="Active" placeholder="123..." value="" ><label class="mr-1" for="Active"> Active</label>
                                             <input type="radio" class="" name="status" id="Deactive" placeholder="123..." value="" ><label class="mr-1" for="Deactive">Deactive</label>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-4">
                                       <p class="text-bold-400">Item Image</p>
                                       <div class="row">
                                          <div class="col-md-6">
                                             <div class="uploadOuter">
                                                <input type="file" onChange="dragNdrop(event)"  ondragover="drag()" ondrop="drop()" id="uploadFile"  />
                                                <label for="uploadFile" class="btn btn-outline-info btn-sm"><i class="fa fa-plus"></i>  Browse Files</label>
                                                <p>128 * 128 Size</p>
                                                <p>Supported upto to 25 MB</p>
                                             </div>
                                          </div>
                                       </div>
                                       <p class="text-bold-400 pt-1">Item Options</p>
                                       <div class="row ">
                                          <div class="col-md-6 ">
                                             <div class="form-group">
                                                <input type="checkbox" id="Block from point od sale"  >
                                                <label for="Block from point od sale">Stockable</label>
                                                <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                             </div>
                                          </div>
                                          <div class="col-md-6 ">
                                             <div class="form-group">
                                                <input type="checkbox" id="Plate Control" checked  >
                                                <label for="Plate Control">CanSale</label> 
                                                <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                             </div>
                                          </div>
                                          <div class="col-md-6 ">
                                             <div class="form-group">
                                                <input type="checkbox" id="Is Minibar"  >
                                                <label for="Is Minibar">Weighing Scale</label>
                                                <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                             </div>
                                          </div>
                                          <div class="col-md-6 ">
                                             <div class="form-group">
                                                <input type="checkbox" id="Is Full Day"  >
                                                <label for="Is Full Day">Weight Item</label>
                                                <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                             </div>
                                          </div>
                                          <div class="col-md-6 ">
                                             <div class="form-group">
                                                <input type="checkbox" id="Favourite"  >
                                                <label for="Favourite">Favourite</label>
                                                <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                             </div>
                                          </div>
                                          <div class="col-md-6 ">
                                             <div class="form-group">
                                                <input type="checkbox" id="Is Service"  >
                                                <label for="Is Service">Is Service</label>
                                                <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="form-footer text-right">
                                          <button  type="button" class="btn btn-default_new"><i class="fa fa-close"></i> Cancel</button>
                                          <button  type="button" class="btn btn-info"><i class="fa fa-file-o"></i> Save</button>
                                       </div>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane" id="item-with-varience" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
                        <div class="card card-content collapse show">
                           <div class="card-body card-dashboard">
                              <form id="variance-form">
                                 <p class="text-bold-400">Item Details</p>
                                 <div class="row">
                                    <div class="col-8 border-right">
                                       <div class="row">
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="Food" >
                                                <label for="floatingInputGrid">Item Name</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Category</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Sub Category</label>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row pt-1">
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">UOM</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Tax</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Purchase Tax</label>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row pt-1">
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Brand</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Item Modifier</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Status</label>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row pt-1">
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="Food" >
                                                <label for="floatingInputGrid">Item Description</label>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-4">
                                       <p class="text-bold-400">Item Image</p>
                                       <div class="row">
                                          <div class="col-md-6">
                                             <div class="uploadOuter">
                                                <input type="file" onChange="dragNdrop(event)"  ondragover="drag()" ondrop="drop()" id="uploadFile"  />
                                                <label for="uploadFile" class="btn btn-outline-info btn-sm"><i class="fa fa-plus"></i>  Browse Files</label>
                                                <p>128 * 128 Size</p>
                                                <p>Supported upto to 25 MB</p>
                                             </div>
                                          </div>
                                       </div>
                                       <p class="text-bold-400 pt-1">Item Options</p>
                                       <div class="row ">
                                          <div class="col-md-6 ">
                                             <div class="form-group">
                                                <input type="checkbox" id="Block from point od sale"  >
                                                <label for="Block from point od sale">Stockable</label>
                                                <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                             </div>
                                          </div>
                                          <div class="col-md-6 ">
                                             <div class="form-group">
                                                <input type="checkbox" id="Plate Control" checked  >
                                                <label for="Plate Control">CanSale</label> 
                                                <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                             </div>
                                          </div>
                                          <div class="col-md-6 ">
                                             <div class="form-group">
                                                <input type="checkbox" id="Is Full Day"  >
                                                <label for="Is Full Day">Weight Item</label>
                                                <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                             </div>
                                          </div>
                                          <div class="col-md-6 ">
                                             <div class="form-group">
                                                <input type="checkbox" id="Favourite"  >
                                                <label for="Favourite">Favourite</label>
                                                <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                             </div>
                                          </div>
                                          <div class="col-md-6 ">
                                             <div class="form-group">
                                                <input type="checkbox" id="Is Service"  >
                                                <label for="Is Service">Is Service</label>
                                                <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </form>
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
                                                <h4 class="card-title pb-1">Variants <small class="block">Choose variable attributes for this product to create and manage SKUs and their inventory levels.</small></h4>
                                                <div class="repeater-default">
                                                   <div data-repeater-list="car">
                                                      <div class="">
                                                         <table id="variant-table" class="table  table-bordered zero-configuration">
                                                            <thead class="threadClass">
                                                               <tr>
                                                                  <th></th>
                                                                  <th>Product Variant</th>
                                                                  <th>Attribute (e.g. Colour)</th>
                                                                  <th>Action</th>
                                                               </tr>
                                                            </thead>
                                                            <tbody>
                                                               <tr>
                                                                  <td>..</td>
                                                                  <td>AIDE-000001</td>
                                                                  <td>Meat and Seafood</td>
                                                                  <td class="text-center"><a href=""><i class="fa fa-file-o"></i></a> &nbsp;&nbsp;&nbsp; <a href="" class=""><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;
                                                                     <a href="" class="transh-icon-color"><i class="fa fa-trash-o"></i></a>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <td>..</td>
                                                                  <td>$174.20</td>
                                                                  <td>
                                                                     2323
                                                                  </td>
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
                                                         <button  onclick="addVarient();" data-repeater-create type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Variants</button>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="form-footer">
                                                   <div class="row">
                                                      <div class="col-md-6">
                                                         <input type="radio" class="" name="status" id="Active" placeholder="123..." value="" ><label class="mr-1" for="Active"> Active</label>
                                                         <input type="radio" class="" name="status" id="Deactive" placeholder="123..." value="" ><label class="mr-1" for="Deactive">Deactive</label>
                                                      </div>
                                                      <div class="col-md-6 text-right">
                                                         <button  type="button" class="btn btn-default"><i class="fa fa-close"></i> Cancel</button>
                                                         <button  type="button" class="btn btn-info"><i class="fa fa-file-o"></i> Save</button>
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
                     <div class="tab-pane" id="composite-item" role="tabpanel" aria-labelledby="linkIcon12-tab1" aria-expanded="false">
                        <div class="card card-content collapse show">
                           <div class="card-body card-dashboard">
                              <form id="composite-item-form">
                                 <p class="text-bold-400">Item Details</p>
                                 <div class="row">
                                    <div class="col-8 border-right">
                                       <div class="row">
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="Food" >
                                                <label for="floatingInputGrid">Item Name</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="Food" >
                                                <label for="floatingInputGrid">SKU/Barcode</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="Food" >
                                                <label for="floatingInputGrid">Supply Price</label>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row pt-1">
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="" >
                                                <label for="floatingInputGrid">Markup</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="" >
                                                <label for="floatingInputGrid">Retail Price</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="" >
                                                <label for="floatingInputGrid">Minimum Retail Price</label>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row pt-1">
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="" >
                                                <label for="floatingInputGrid">Current Inventory</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="" >
                                                <label for="floatingInputGrid">Inventory Value</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="" >
                                                <label for="floatingInputGrid">Re-order Point</label>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row pt-1">
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Category</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Sub Category</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">UOM</label>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row pt-1">
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Tax</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Purchase Tax</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Brand</label>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row pt-1">
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Item Modifier</label>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                                   <option selected>Units</option>
                                                   <option value="1">One</option>
                                                   <option value="2">Two</option>
                                                   <option value="3">Three</option>
                                                </select>
                                                <label for="floatingSelectGrid">Status</label>
                                             </div>
                                             <div class="new_sub_category">
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="Food" >
                                                <label for="floatingInputGrid">Item Description</label>
                                             </div>
                                             <div class="new_category">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-4">
                                       <p class="text-bold-400">Item Image</p>
                                       <div class="row">
                                          <div class="col-md-6">
                                             <div class="uploadOuter">
                                                <input type="file" onChange="dragNdrop(event)"  ondragover="drag()" ondrop="drop()" id="uploadFile"  />
                                                <label for="uploadFile" class="btn btn-outline-info btn-sm"><i class="fa fa-plus"></i>  Browse Files</label>
                                                <p>128 * 128 Size</p>
                                                <p>Supported upto to 25 MB</p>
                                             </div>
                                          </div>
                                       </div>
                                       <p class="text-bold-400 pt-1">Item Options</p>
                                       <div class="row ">
                                          <div class="col-md-6 ">
                                             <div class="form-group">
                                                <input type="checkbox" id="Block from point od sale"  >
                                                <label for="Block from point od sale">Stockable</label>
                                                <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                             </div>
                                          </div>
                                          <div class="col-md-6 ">
                                             <div class="form-group">
                                                <input type="checkbox" id="Plate Control" checked  >
                                                <label for="Plate Control">CanSale</label> 
                                                <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                             </div>
                                          </div>
                                          <div class="col-md-6 ">
                                             <div class="form-group">
                                                <input type="checkbox" id="Is Minibar"  >
                                                <label for="Is Minibar">Weighing Scale</label>
                                                <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                             </div>
                                          </div>
                                          <div class="col-md-6 ">
                                             <div class="form-group">
                                                <input type="checkbox" id="Is Full Day"  >
                                                <label for="Is Full Day">Weight Item</label>
                                                <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                             </div>
                                          </div>
                                          <div class="col-md-6 ">
                                             <div class="form-group">
                                                <input type="checkbox" id="Favourite"  >
                                                <label for="Favourite">Favourite</label>
                                                <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                             </div>
                                          </div>
                                          <div class="col-md-6 ">
                                             <div class="form-group">
                                                <input type="checkbox" id="Is Service"  >
                                                <label for="Is Service">Is Service</label>
                                                <span data-toggle="tooltip" data-placement="right" title="Mark Item"> <i class="fa fa-info-circle"></i></span>
                                             </div>
                                          </div>
                                       </div>
                                       
                                    </div>
                                 </div>
                              </form>
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
                                             <p class="text-bold-400">Composite Image</p>
                                                <div class="repeater-default">
                                                   <div data-repeater-list="car">
                                                      <div class="">
                                                        <table id="composite-item-table" class="table  table-bordered zero-configuration">
                                                            <thead class="threadClass">
                                                               <tr>
                                                                  <th></th>
                                                                  <th>Component</th>
                                                                  <th>Quantity</th>
                                                                  <th>Optional</th>
                                                                  <th>Category</th>
                                                                  <th>Action</th>
                                                               </tr>
                                                            </thead>
                                                            <tbody>
                                                               <tr>
                                                                  <td>..</td>
                                                                  <td>Chicken Burger</td>
                                                                  <td>Burger</td>
                                                                        <td class="text-center"><div class="form-group">
                                                      <input type="checkbox" id="0">
                                                      <label for="0"></label>
                                                   </div></td>
                                                   <td></td>
                                                                  <td class="text-center"><a href=""><i class="fa fa-file-o"></i></a> &nbsp;&nbsp;&nbsp; <a href="" class=""><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;
                                                                     <a href="" class="transh-icon-color"><i class="fa fa-trash-o"></i></a>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <td>..</td>
                                                                  <td>Chicken Burger</td>
                                                                  <td>Burger</td>
                                                                  <td class="text-center"><div class="form-group">
                                                      <input type="checkbox" id="1">
                                                      <label for="1"></label>
                                                   </div></td>
                                                                  <td></td>
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
                                                         <button  onclick="addCompositeItem();" data-repeater-create type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Composite Item</button>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="form-footer">
                                                   <div class="row">
                                                      <div class="col-md-6">
                                                         <input type="radio" class="" name="status" id="Active" placeholder="123..." value="" ><label class="mr-1" for="Active"> Active</label>
                                                         <input type="radio" class="" name="status" id="Deactive" placeholder="123..." value="" ><label class="mr-1" for="Deactive">Deactive</label>
                                                      </div>
                                                      <div class="col-md-6 text-right">
                                                         <button  type="button" class="btn btn-default"><i class="fa fa-close"></i> Cancel</button>
                                                         <button  type="button" class="btn btn-info"><i class="fa fa-file-o"></i> Save</button>
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
         </div>
      </div>
      <!-- Model Start -->         
      <div class="modal fade text-left" id="add-new-variant" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
         <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel18">Add New Variants</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12 ">
                        <div class="form-floating">
                           <input type="text" class="form-control" id="floatingInputGrid" placeholder="123..." value="" >
                           <label for="floatingInputGrid">Product Variant</label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"> <i class="fa fa-close"></i> Cancel</button>
                  <button type="button" class="btn btn-info"> <i class="fa fa-file-o"></i> Submit</button>
               </div>
            </div>
         </div>
      </div>
      <!-- Model End-->          
      