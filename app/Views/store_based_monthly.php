<?= view('includes/navbar.php') ?>
<?= view('includes/sidebar.php') ?>
<div class="app-content content">
    <div class="content-wrapper">
    	<?= view('includes/breadcrumb.php');?> 
    	<div class="card card-content collapse show">
			   <div class="card-body card-dashboard">
			   	<div class="card-header">
                    <h4 class="card-title">View Store Based Monthly Sales</h4>
                </div>
                     <!-- <div class="card-body"> -->
                           <div class="table-responsive">
                           <table class="table table-md table-bordered">
                              <thead>
                                 <tr>
                                 	<th>Store Id</th>
                                    <th>Store Name</th>
                                    <th>Phone no</th>
                                    <th>Sales</th>
                                 </tr>
                              </thead>
                               <tbody>
                               	<?php
			                    foreach($data['sales'] as $row){
			                    ?>
                                 <tr>
                                 	<td><?= $row['id'] ?></td>
                                    <td scope="row"><?= $row['store_name'] ?></td>
                                    <td><?= $row['phone'] ?></td>
                                    <td><?= numberFormat($row['total']) ?></td>
                                 </tr>
                                 <?php }
                    			?>
                              </tbody>
                           </table>
                        </div>   
                       
            </div>
        </div>
    </div>
</div>