<?= view('includes/navbar.php') ?>
<?= view('includes/sidebar.php') ?>
     <div class="app-content content">
         <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
               <p class="dashboard-text mb-1"><?= $data['greeting'];?>, <?= session()->get('isLoggedIn') ? session()->get('name') : ''?></p>
               <!-- start -->
               <div class="row" style="padding-top:4px;">
                  <div class="col-xl-3 col-lg-6 col-12" >
                     <div class="card">
                        <div class="card-content">
                           <div class="card-body">
                              <div class="media d-flex">
                                 <div class="align-self-center dashboard-img" >
                                    <i class="ft-trending-up white font-large-1 float-left dashboard-icon" style="margin-left: 12px;"></i>
                                 </div>
                                 <div class="media-body">
                                    <h3>$<?= $data['today'];?></h3>
                                    <span class="first-content">Today Sales</span> <!-- <span class="second-content">Upto 5:11PM </span> -->
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12">
                     <div class="card">
                        <div class="card-content">
                           <div class="card-body">
                              <div class="media d-flex">
                                 <div class="align-self-center dashboard-img">
                                    <i class="fa fa-calendar white font-large-1 float-left dashboard-icon " style="margin-left: 12px;"></i>
                                 </div>
                                 <div class="media-body">
                                    <h3>$<?= $data['yesterday'];?></h3>
                                    <span class="first-content">Yesterday</span> <span class="second-content">vs same day  </span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12" >
                     <div class="card">
                        <div class="card-content">
                           <div class="card-body">
                              <div class="media d-flex">
                                 <div class="align-self-center dashboard-img">
                                    <i class="fa fa-calendar-check-o white font-large-1 float-left dashboard-icon " style="margin-left: 12px;"></i>
                                 </div>
                                 <div class="media-body">
                                    <h3>$<?= $data['current_month'];?></h3>
                                    <span class="first-content">This Month </span> <span class="second-content">vs same day </span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-12">
                     <div class="card">
                        <div class="card-content">
                           <div class="card-body">
                              <div class="media d-flex">
                                 <div class="align-self-center dashboard-img">
                                    <i class="fa fa-calendar-check-o white font-large-1 float-left dashboard-icon " style="margin-left: 12px;"></i>
                                 </div>
                                 <div class="media-body">
                                    <h3>$<?= $data['last_month'];?></h3>
                                    <span class="first-content">Last Month</span> <span class="second-content">vs month before</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-8">
                     <div class="card">
                        <div class="card-header">
                           <h4 class="card-title">Sales</h4>
                           <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                           <div class="heading-elements">
                              <ul class="list-inline text-center">
                                 <li>
                                    <h6><i class="ft-circle purple" style="color:#FF7D4D!important;"></i> <span id="current_text">Current Month</span></h6>
                                    <span>$</span><span id="current_total_sale"><?= numberFormat($data['current_year']['total']); ?></span>
                                 </li>
                                 <li>
                                    <h6><i class="ft-circle pink"  style="color:#00A5A8!important;"></i> <span id="previous_text">Previous Month</span></h6>
                                    <span>$</span><span id="previous_total_sale"><?= numberFormat($data['previous_year']['total']);  ?></span>
                                 </li>
                                 <li>
                                    <div class="">
                                       <select name="total_sale" class="form-control form-select total_sale">
                                          <option value="0">Yearly</option>
                                          <option value="1" selected>Monthly</option>
                                          <option value="2" >Weekly</option>
                                       </select>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                        <div class="card-content collapse show">
                           <div class="card-body" style="height:448px;">
                              <div id="bar-chart" class="height-400"></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="card">
                        <div class="card-header">
                           <h4 class="card-title">Top Items
                           </h4>
                           <div class="heading-elements">
                              <ul class="list-inline text-center">
                                 <div class="">
                                    <select name="top_items" class="form-control form-select top_items">
                                          <option value="0">Yearly</option>
                                          <option value="1" selected>Monthly</option>
                                          <option value="2" >Weekly</option>
                                       </select>
                                 </div>
                              </ul>
                           </div>
                           <div class="card-content mt-2">
                              <div class="card-body">
                                 <div class="height-400">
                                    <div id="top-items-nta"></div>
                                    <canvas id="simple-doughnut-chart"></canvas>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- end -->
               </div>
               <!-- Audience by country -->
               <div class="row match-height ">
                  <div class="col-md-4 ">
                     <div class="card">
            <div class="card-header no-border">
                <h4 class="card-title">Store Based Monthly Sales</span></h4>
                <a class="heading-elements-toggle"><i class="ft-more-horizontal font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline text-center">
                        <div class="">
                           <a href="<?= base_url('/reports/sales-by-store')?>" class="dft-color"><u>View All</u> ></a>
                        </div>
                     </ul>
                </div>
            </div>
            <div class="card-content">
               <div id="style-3" class="card-body height-350 position-relative scrollbar">
                 <div class="force-overflow">
                     <?php
                     foreach($data['sale'] as $row){
                     ?>
                     <div class="media">
                        <div class="pr-2">
                            <img class="media-object avatar avatar-md rounded-circle" src="<?=base_url()?>/public/app-assets/images/portrait/small/avatar-s-4.png" alt="Generic placeholder image">
                        </div>
                        <div class="media-body">
                            <p class="text-bold-600 m-0"><?= $row['store_name'] ?>
                              <span class="float-right "><?= numberFormat($row['total']) ?></span></p>
                            <p class="font-small-2 text-muted m-0"><?= $row['phone'] ?></p>
                        </div>
                    </div>
                     <hr>
                    <?php }
                    ?>
                 </div>
                </div>
                </div>
            </div>
        </div>
                  <div class="col-md-4">
                     <div class="card">
                        <div class="card-header no-border">
                           <h4 class="card-title">Item Statistics</h4>
                           <a class="heading-elements-toggle"><i class="ft-more-horizontal"></i></a>
                        </div>
                        <div class="card-content">
                           <div id="audience-list-scroll" class="table-responsive height-300 position-relative ">
                              <table class="table mb-0">
                                 <tbody>
                                    <tr>
                                       <td><span class="dft-color">Number of Items</span><br><span class="digit-size"><?= $data['total_items']?></span></td>
                                       <td><span class="dft-color">Number of Groups</span><br><span class="digit-size">5,892</span></td>
                                       <td><span class="dft-color">Active Items</span><br><span class="digit-size"><?= $data['active_items']?></span></td>
                                    </tr>
                                    <tr>
                                       <td><span class="dft-color">In Active Items</span><br><span class="digit-size"><?= $data['inactive_items']?></span></td>
                                       <td><span class="dft-color">Number of Brands</span><br><span class="digit-size"><?= $data['total_brands']?></span></td>
                                       <td></td>
                                    </tr>
                                    <tr>
                                       <td><span class="dft-color">Out of stock Items</span><br><span class="digit-size">2,214</span></td>
                                       <td><span class="dft-color">Non moving Items</span><br><span class="digit-size">3,782</span></td>
                                       <td></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="card">
                        <div class="card-header ">
                           <h4 class="card-title">Daily Terminal Sales</h4>
                           <a class="heading-elements-toggle"><i class="ft-more-horizontal font-medium-3"></i></a>
                           <div class="heading-elements">
                              <ul class="list-inline text-center">
                                 <div class="">
                                    <a href="<?= base_url('/reports/sales-by-terminal')?>" class="dft-color"><u>View All</u> ></a>
                                 </div>
                              </ul>
                           </div>
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
               <table class="table table-md table-bordered">
                  <thead>
                     <tr>
                        <th>Terminal</th>
                        <th>Store Name</th>
                        <th>Sales</th>
                     </tr>
                  </thead>
                  <tbody>
                      <?php
                      foreach( $data['daily_sales'] as $row){
                      ?>
                     <tr>
                        <th scope="row"><?= $row['terminal_name'] ?></th>
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
            </div>
         </div>
         <!--/ Audience by country -->
      </div>
      </div>

      <!-- BEGIN VENDOR JS-->
      
      <!-- END Barchart JS-->
   
      </div>
      
      <!-- BEGIN Barchart JS-->
      <script src="<?= base_url()?>/public/app-assets/vendors/js/vendors.min.js"></script>
      <script src="<?= base_url()?>/public/app-assets/vendors/js/charts/raphael-min.js"></script>
      <script src="<?= base_url()?>/public/app-assets/vendors/js/charts/morris.min.js"></script>
      <!-- <script src="<?= base_url()?>/app-assets/js/scripts/charts/morris/bar.min.js"></script> -->
      
      <script src="<?= base_url()?>/public/app-assets/vendors/js/charts/chart.min.js"></script>
      
   <script type="text/javascript">
      (function() {
            let data = <?= $data['sales']?>;
            let labels = <?= $data['sales_text']?>;
           createChart(data,labels,1);
         })();
       
        function createChart(data,labels,type){
               Morris.Bar({
               element: "bar-chart",
               data: data,
               xkey: "date",
               ykeys: ["current", "previous"],
               labels:labels,
               barGap: 5,
               barSizeRatio: .35,
               smooth: !0,
               gridLineColor: "#e3e3e3",
               numLines: 5,
               gridtextSize: 14,
               fillOpacity: .4,
               resize: !0,
               barColors: ["#FF7D4D","#00A5A8"]
            });
         }  
     
       
      $(document).on('change','.total_sale',function() {
         value = $(this).val();
         $.ajax({
            type: "POST",
            url: "<?= base_url('getGraphSale')?>",
            data: {
               value: value,
              },
            dataType: "json",
            encode: true,
         }).done(function (data) {
            firstRow = JSON.parse(data.data.sales);
             labels = JSON.parse(data.data.sales_text);
             $("#bar-chart").empty();
             createChart(firstRow,labels,2);
             $('#current_total_sale').text(data.data.total_sales);
             $('#current_text').text(data.data.current_text);
             $('#previous_total_sale').text(data.data.previous_total_sales);
             $('#previous_text').text(data.data.previous_text);
            })
      })
      
      
   </script>
   <script type="text/javascript">
      var piechart;
      var isTopItemsFlg = true;
      $(window).on("load",function(){

         <?php if($data['top_items']['top_items_total'] == "[]") { ?>
            isTopItemsFlg = false;
         <?php } ?>
         if(!isTopItemsFlg){
            $('#top-items-nta').html('No Data Found');
         }
         var a=$("#simple-doughnut-chart");
         piechart = new Chart(a,
         {
            type:"doughnut",
            options:{
                  responsive:!0,
                  maintainAspectRatio:!1,
                  responsiveAnimationDuration:500
            },
            data:{
               labels:<?= $data['top_items']['top_items'];?>,
               datasets:[
               {
                  label:"My First dataset",
                  data:<?= $data['top_items']['top_items_total'];?>,
                    backgroundColor:["#00A5A8","#626E82","#FF7D4D","#FF4558","#28D094"]
                }
               ]
            },
         })
      });
      $(document).on('change','.top_items',function() {
         value = $(this).val();
         $.ajax({
            type: "POST",
            url: "<?= base_url('getGraphTopItem')?>",
            data: {
               value: value,
              },
            dataType: "json",
            encode: true,
         }).done(function (data) {
            if(data.status == 'true'){
               labels = JSON.parse(data.data.top_items);
               datasets = JSON.parse(data.data.top_items_total);
               piechart.data.labels = labels;
               piechart.data.datasets[0].data = datasets;
               piechart.update();
               isTopItemsFlg = true;
               $('#simple-doughnut-chart').css({'display':'block'});
               $('#top-items-nta').html('');
            }else{
               alertMessage(data.status,data.message);
               isTopItemsFlg = false;
               $('#simple-doughnut-chart').css({'display':'none'});
               $('#top-items-nta').html('No Data Found');
            }
            })
      })
   </script>
   </body>
</html>