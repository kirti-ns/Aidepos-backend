<style type="text/css">
  .avatar-upload {
  position: relative;
  max-width: 145px;
  /*margin: 50px auto;*/
}
.avatar-upload .avatar-edit {
  position: absolute;
  right: -50px;
  z-index: 1;
  top: 10px;
}
.avatar-upload .avatar-edit input {
  display: none;
}
.avatar-upload .avatar-edit input + label {
  display: inline-block;
  /*width: 34px;
  height: 34px;*/
  margin-bottom: 0;
  /*border-radius: 100%;*/
  background: #FFFFFF;
  border: 1px solid F05624;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
  cursor: pointer;
  font-weight: normal;
  transition: all 0.2s ease-in-out;
}
.avatar-upload .avatar-edit input + label:hover {
  background-color: #F05624;
    color: #FFF!important;
}
.avatar-upload .avatar-preview {
  width: 65px;
  height: 65px;
  position: relative;
  border-radius: 100%;
  border: 3px solid #F8F8F8;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
}
#imagePreview  {
  width: 100%;
  height: 100%;
  border-radius: 100%;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}
.delete-image-btn {
   left: -80px;
    z-index: 1;
    top: 14px;
}
</style>
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
                         <?php $value = isset($data['employees'])?$data['employees']:"";
                         $stores_array = [];
                          if(!empty($value)){
                            $stores_array = json_decode($value['store_id']);
                            }
                         ?>
                        <form method="post" enctype="multipart/form-data" action="<?= base_url('post-profile-data') ?>" id="employee_form">
                           <input type="hidden" name="action" id="action" value="post-profile-data">
                           <input type="hidden" name="table_name" id="table_name" value="employees">
                           <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                           <input type="hidden" name="profile_image_old" id="profile_image_old" value="<?= isset($value['profile'])?$value['profile']:''?>">
                           <input type="hidden" name="profile_image_name" id="imagePreview_name" value="">
                           <input type="hidden" name="store_id[]" id="" value="<?= isset($value['store_id'])?$value['store_id']:''?>">
                           <input type="hidden" name="role_id" id="" value="<?= isset($value['role_id'])?$value['role_id']:''?>">
                           <input type="hidden" name="terminal_id" id="" value="<?= isset($value['terminal_id'])?$value['terminal_id']:''?>">
                              <div class="row">
                                 <div class="col-md-3">
                                    <div class="avatar-upload">
                                         <div class="avatar-edit">
                                             <input type='file' name="profile_image" id="imageUpload"/>
                                             <!-- accept=".png, .jpg, .jpeg" -->
                                             <label for="imageUpload" class="btn btn-outline-info btn-sm">Change Photo</button>
                                         </div>
                                         <div class="avatar-preview">
                                          <img  id="imagePreview" src="<?=GetImagePath(isset($value['profile'])?$value['profile']:'','employees')?>">

                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-md-2 delete-image-btn" style="padding-left: 28px;">
                                    <a href="" class="transh-icon-color " ><i class="fa fa-trash-o"></i> Delete</a>                          
                                 </div>
                              </div>
                              <hr>
                              <br>
                              <div class="row">
                                 <div class="col-md-3">
                                    <div class="form-floating">
                                       <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name*" value="<?= isset($value['first_name'])?$value['first_name']:''?>" >
                                       <label for="floatingSelectGrid">First Name*</label>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-floating">
                                       <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name*" value="<?= isset($value['last_name'])?$value['last_name']:''?>" >
                                       <label for="floatingSelectGrid">Last Name*</label>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-floating">
                                       <input type="email" class="form-control" name="primary_email" id="primary_email" placeholder="Email Id" value="<?= isset($value['primary_email'])?$value['primary_email']:''?>" >
                                       <label for="floatingSelectGrid">Primary Email ID*</label>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-floating">
                                       <input type="email" class="form-control" name="secondary_email" id="secondary_email" placeholder="Email" value="<?= isset($value['secondary_email'])?$value['secondary_email']:''?>" >
                                       <label for="floatingSelectGrid">Official Email ID*</label>
                                    </div>
                                 </div>
                                 
                                 
                              </div>
                              <br>
                              <div class="row">
                                 <div class="col-md-3">
                              <div class="form-floating">
                              <select class="form-select" name="gender" id="gender" aria-label="Floating label select example">
                                    <option >Select</option>
                                    <option <?= isset($value['gender']) && ($value['gender'] == 'Male')?'selected':''?> value="Male">Male</option>
                                    <option <?= isset($value['gender']) && ($value['gender'] == 'Female')?'selected':''?> value="Female">Female</option>
                              </select>
                              <label for="floatingSelectGrid">Gender</label>
                              </div>
                           </div>
                                 <div class="col-md-3">
                                    <div class="form-floating">
                                       <input type="number" class="form-control" name="phone" id="phone" placeholder="Phone" value="<?= isset($value['phone'])?$value['phone']:''?>" style="height: 50px;" >
                                    </div>
                                   
                                 </div>
                                 
                                 <div class="col-md-3">
                                    <div class="form-floating">
                                       <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="<?= isset($value['address'])?$value['address']:''?>" >
                                       <label for="floatingSelectGrid">Address</label>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-floating">
                                       <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip" value="<?= isset($value['zip'])?$value['zip']:''?>" >
                                       <label for="floatingSelectGrid">ZIP</label>
                                    </div>
                                 </div>
                              </div>
                              <br>
                              
                              <div class="row">
                                 <div class="col-md-3">
                                    <div class="form-floating">
                                       <input type="text" class="form-control" name="city" id="city" placeholder="City" value="<?= isset($value['city'])?$value['city']:''?>" >
                                       <label for="floatingSelectGrid">City</label>
                                    </div>
                                 </div>

                                 <div class="col-md-3">
                                    <div class="form-floating" >
                                    <select class="select2 form-control store_id" name="store_id[]" id="store_id" multiple="multiple" disabled >

                                    <?php 
                                    if(!empty($stores_array)){

                                    if(!empty($data['stores']))
                                    {
                                       foreach($data['stores'] as $row)
                                          { ?>
                                             <option <?= isset($stores_array) && in_array($row['id'],$stores_array)? 'selected="selected"':"" ?> value="<?=$row['id']?>"><?=$row['store_name']?></option>
                                          <?php
                                          }
                                     } 
                                  }else{
                                    if(!empty($stores_array)){
                                    if(!empty($data['stores'])){
                                    foreach($data['stores'] as $row)
                                    { ?>
                                       <option <?= isset($stores_array) && in_array($row['id'],$stores_array)? 'selected="selected"':"" ?>  value="<?=$row['id']?>"><?=$row['store_name']?></option>
                                    <?php
                                    }
                                       }
                                  }
                               }
                                    ?>
                                 </select>
                                 <label for="floatingSelectGrid">Store</label>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-floating">
                                      <select class="form-select terminal_id" id="terminal_id" name="terminal_id" aria-label="Floating label select example" disabled>
                                          <option value="" >Select Terminals</option>
                                           <?php 
                                             if(!empty($data['terminals']))
                                             {
                                                foreach($data['terminals'] as $row)
                                                { ?>
                                                <option <?= isset($value['terminal_id']) && ($value['terminal_id'] == $row['id'])?'selected':''?> value="<?= $row['id']?>"><?= $row['terminal_name']?></option>
                                             <?php
                                                }
                                              } 
                                             ?>
                                       </select>
                                       <label for="floatingSelectGrid">Terminal</label>
                                    </div>
                                 </div>
                                 
                                  <div class="col-md-3">
                                    <div class="form-floating">
                                      <select class="form-select" id="role_id" name="role_id" aria-label="Floating label select example" disabled>
                                    <option value="" >Select Role</option>
                                     <?php 
                                       if(!empty($data['roles']))
                                       {
                                          foreach($data['roles'] as $row)
                                             { ?>
                                                <option <?= isset($value['role_id']) && ($value['role_id'] == $row['id'])?'selected':''?> value="<?= $row['id']?>"><?= $row['role_name']?></option>
                                       <?php
                                             }
                                        } 
                                       ?>
                                 </select>
                                       <label for="floatingSelectGrid">Role</label>
                                    </div>
                                 </div>
                                
                                  
                              </div>
                              <br>
                              <div class="row">
                                 <!-- <div class="col-md-6">
                                <?= StatusInput(isset($value['status'])?$value['status']:'1');?>
                                 </div> -->
                                 <div class="col-md text-right">
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
</div>