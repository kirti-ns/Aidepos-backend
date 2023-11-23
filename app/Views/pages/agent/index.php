
      <div class="app-content content">
         <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
               <p class="dashboard-text mb-1"><?= $data['greeting'];?>, <?= session()->get('isLoggedIn') ? session()->get('name') : ''?></p>
               <!-- start -->
               <div class="row mt-1">
                  <div class="col-lg-12">
                     <div class="card pl-1 pr-1">
                        <div class="card-header">
                           <h4 class="card-title">Merchant Details</h4>
                        </div>
                        <div class="card-content">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Merchant ID</th>
                                            <th>Merchant Name</th>
                                            <th>Email</th>
                                            <th>Expiry Date</th>
                                            <th>Registration Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php if(!empty($data['merchants'])) {
                                        foreach($data['merchants'] as $val) { ?>
                                        <tr>
                                            <td><?= $val['id'] ?></td>
                                            <td><?= $val['first_name'].' '.$val['last_name']; ?></td>
                                            <td><?= $val['primary_email'] ?></td>
                                            <td><?= $val['expiry_date'] ?></td>
                                            <td><?= date('Y-m-d',strtotime($val['created_at'])); ?></td>
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
      
      <!-- BEGIN Barchart JS-->
      <script src="<?= base_url()?>/public/app-assets/vendors/js/vendors.min.js"></script>

   </body>
</html>