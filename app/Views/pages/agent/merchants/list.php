<style>
    .table1 td, .table1 th{
    padding: 0.75rem;
}
</style>
<div class="app-content content">
<div class="content-wrapper">
   <?= view('includes/breadcrumb.php');?> 
   <div class="content-body">
      <div class="row">
         
         <!-- Icon Tab with bottom line -->
         <div class="col-xl-12 col-lg-12">
            <ul class="nav nav-tabs navigate-tabs nav-underline nav-justified mb-1" id="tab-bottom-line-drag">
               <li class="nav-item">
                  <a class="nav-link active" id="activeIcon12-tab1" data-toggle="tab" href="#customer-list" aria-controls="activeIcon12" aria-expanded="true">Merchants List</a>
               </li>
            </ul>
         </div>
      </div>
      <div class="tab-content ">
         <div role="tabpanel" class="tab-pane active show" id="customer-list" aria-labelledby="activeIcon12-tab1" aria-expanded="true">
               <form class="filterMerchant">
            <section class="mb-1 filter-bar">
               <div class="filter-bar-item f-12">
                  <span>
                     <select name="equal[status]" class="form-control form-select purchase-search">
                        <option value="">Merchants: All</option>
                        <option value="1">Active</option>
                        <option value="2">Deactive</option>
                     </select>
                  </span>
               </div>
               
               <div class="filter-bar-item" style="flex-grow:1;">
                  <span>
                     <input type="text" placeholder="Search" name="match[search]" class="form-control purchase-search searchDtField">
                     <div class="form-control-position">
                        <i class="fa fa-search"></i>
                     </div>
                  </span>
               </div>
               <div class="filter-bar-item">
                  <span><button type="button" id="csubmit" class="btn btn-outline-info btn-sm searchDtBtn">Search</button></span>
               </div>
            
               <div class="filter-bar-item border-side-right"></div>
               <div class="filter-bar-item filter-bar-last pl-2">
                  <span>
                     <a href="<?= base_url("agent/merchants/add_merchant")?>" class="btn btn-info btn-sm mr-15"><i class="fa fa-plus"></i> Add New</a>
                  </span>
               </div>
            </section>
            </form>
            <div class="card card-content collapse show">
               <div class="card-body card-dashboard">
                  <section id="configuration">
                     <div class="col-12">
                        <div class="status-div">
                           <span class="active-span"></span><span> Active</span>   
                           <span class="inactive-span"></span><span> Inactive</span>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-12">
                           <div class="card">
                              <div class="card-content collapse show">
                                 <div class="card-body card-dashboard">
                                    <table id="merchants-tbl" class="table1 table-bordered table-striped ">
                                       <thead>
                                          <tr>
                                             <th>#</th>
                                             <th>Name</th>
                                             <th>Created By</th>
                                             <th>Email</th>
                                             <th>Phone</th>
                                             <th>City</th>
                                             <th>Stores</th>
                                             <th>Created Date</th>
                                             <!-- <th class="text-left">Action</th> -->
                                          </tr>
                                       </thead>
                                       <tbody>
                                       </tbody>
                                       
                                    </table>
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
