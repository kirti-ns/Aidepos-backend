<?= view('includes/navbar.php') ?>
<?= view('includes/sidebar.php') ?>
<div class="app-content content">
    <div class="content-wrapper">
    	<?= view('includes/breadcrumb.php');?> 
    	<div class="card card-content collapse show">
			   <div class="card-body card-dashboard">
			   	<div class="card-header">
                    <h4 class="card-title">View Daily Terminal Based Sales</h4>
                </div>
                    <div class="table-responsive">
                    <table class="table table-md table-bordered">
                        <thead>
                        <tr>
                            <th>Store Id</th>
                            <th>Terminal</th>
                            <th>Store Name</th>
                            <th>Sales</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($data['daily_sales'] as $row){
                            ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td scope="row"><?= $row['terminal_name'] ?></td>
                                <td><?= $row['store_name'] ?></td>
                                <td><?= $row['total'] ?></td>
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