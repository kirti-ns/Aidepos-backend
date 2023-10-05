
  <div class="app-content content">
      <div class="content-wrapper">
          <?= view('includes/breadcrumb.php');?> 
 <div class="card card-content collapse show">
      <div class="card-body card-dashboard">
            <div class="row">
               <div class="col-12">
                  <div class="card">
                     <div class="card-content collapse show">
                        <div class="card-body card-dashboard" >
                           <div class="row">
                           <?php  if(!empty($data['employees'])){$row = $data['employees'];?>
                              <div class="col-md-1">
                                 <div class="form-floating">
                               <img  class="brand-logo profile-logo" style="border-radius: 50%;height: 80px;width:80px;" alt="robust admin logo" src="<?=GetImagePath(isset($row['profile'])?$row['profile']:'','employees')?>"></img>
                              </div>
                              </div>
                              <div class="col-md 2 ml-1">
                                 <div class="form-floating">
                                 <p class="mb-0"><b><?= $row['first_name'] ?> <?= $row['last_name'] ?></b></p>
                                 <p class="mb-0"><?= $row['role_name'] ?></p>
                              </div>
                              </div>
                              <div class="col-md-6 text-right">
                                 <div class="form-floating">
                                 <a href="<?= base_url('edit_profile/'. $row['id'])?>" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                              </div>
                              </div>
                           </div>
                           <hr>
                          <br>
                          <div class="row">
                          <div class="col-md-6">
                           <p class="mb-0"><b>Full Name</b></p>
                           <span><?= $row['first_name'] ?> <?= $row['last_name'] ?></span>
                          </div>
                          <div class="col-md-6">
                           <p class="mb-0"><b>Role</b></p>
                           <span><?= $row['role_name'] ?></span>
                          </div>
                       </div>
                           <br>
                          <div class="row">
                          
                          <div class="col-md-6">
                           <p class="mb-0"><b>Gender</b></p>
                           <span>Female</span>
                          </div>
                          <div class="col-md-6">
                           <p class="mb-0"><b>Phone</b></p>
                           <span> &plus;<?= $row['country_code'] ?> <?= $row['phone'] ?></span>
                          </div>
                       </div>
                       <br>
                          <div class="row">
                          <div class="col-md-6">
                           <p class="mb-0"><b>Primary Email Id</b></p>
                           <span><?= $row['primary_email'] ?></span>
                          </div>
                          <div class="col-md-6">
                           <p class="mb-0"><b>Secondary Email Id</b></p>
                           <span><?= $row['secondary_email'] ?></span>
                          </div>
                       </div>
                       <br>
                          <div class="row">
                          <div class="col-md-6">
                           <p class="mb-0"><b>Address</b></p>
                           <span><?= $row['address'] ?></span>
                          </div>
                          <div class="col-md-6">
                           <p class="mb-0"><b>Zip</b></p>
                           <span><?= $row['zip'] ?></span>
                          </div>
                       </div>
                       <br>
                        <div class="row">
                          <div class="col-md-6">
                           <p class="mb-0"><b>City</b></p>
                           <span><?= $row['city'] ?></span>
                        </div>
                       </div>
                        <?php 
                        } ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
      </div>
   </div>
 
 