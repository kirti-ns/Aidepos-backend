
<div class="content-header row">
            <div class="content-header-left col-md-8 col-12 breadcrumb-new">
               <h3 class="content-header-title mb-0 d-inline-block"><?= $data['title'];?></h3>
               
            </div>
           
            <div class="content-header-right col-md-4 col-12">
              <div class="row breadcrumbs-top  float-md-right">
                  <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                      <?php if(isset($data['main_menu'])){ ?>
                      <li class="breadcrumb-item"><a href="<?= @$data['main_menu_url'];?>" class="storeColor"><?= @$data['main_menu'];?></a>
                      </li>
                      <?php } ?>
                      <li class="breadcrumb-item active"><?= $data['title'];?>
                      </li>
                    </ol>
                  </div>
                  </div>
               </div>
             
         </div>