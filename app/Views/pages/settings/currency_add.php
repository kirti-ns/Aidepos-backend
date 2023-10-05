  <style type="text/css">
    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #444;
      line-height: 60px;
    }
    .select2-container .select2-selection--single {
        height: 50px;
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
                      <?php 
                        $value = isset($data['currency'])?$data['currency']:"";
                        $currencyData = json_decode($data['currency_master_data']);
                      ?>
                      <form method="post" id="currency_form" name="currency_form">
                         <input type="hidden" name="action" id="action" value="post_data_settings">
                          <input type="hidden" name="table_name" id="table_name" value="currencies">
                          <input type="hidden" name="id" id="id" value="<?= isset($value['id'])?$value['id']:''?>">
                         <div class="row">
                            
                            <div class="col-md-4">
                            <div class="form-floating">
                              <select class="form-control form-select custom-select" id="currency_code" name="currency_code" >
                                  <option disabled selected>Please select</option>
                                  <?php if(!empty($currencyData)) {
                                    foreach($currencyData as $k => $v) { ?>
                                      <option value="<?= $k;?>" <?= isset($value['currency_code']) && ($value['currency_code'] == $k)?'selected':''?>><?= $k.' - '.$v->currency_name; ?></option>
                                  <?php } } ?>
                               </select>
                               <label for="floatingSelectGrid">Currency Code*</label>
                            </div>
                         </div>
                         
                          <div class="col-md-4">
                            <div class="form-floating">
                               <input type="text" class="form-control" id="currency_symbol" name="currency_symbol" placeholder="Currency Code" value="<?= isset($value['currency_symbol'])?$value['currency_symbol']:''?>" >
                               <div class="form-control-position">
                                </div>
                               <!-- <input type="text" class="form-control" id="currency_symbol" name="currency_symbol" placeholder="Currency Symbol" value="<?= isset($value['currency_symbol'])?$value['currency_symbol']:''?>" > -->
                               <label for="floatingSelectGrid">Currency Symbol*</label>
                            </div>
                         </div>
                         <div class="col-md-4">
                            <div class="form-floating">
                            <input type="text" class="form-control" id="currency_name" name="currency_name" placeholder="Currency Name" value="<?= isset($value['currency_name'])?$value['currency_name']:''?>" >
                               <label for="floatingSelectGrid">Currency Name*</label>
                            </div>
                         </div>
                      </div>
                      <br>
                      <div class="row">
                           <div class="col-md-4">
                             <div class="form-floating">
                              <select class="form-select" name="decimal_places" id="decimal_places" aria-label="Floating label select example" >
                                  <option>Select</option>
                                  <option <?= isset($value['decimal_places']) && ($value['decimal_places'] == 0)?'selected':''?> value="0">0</option>
                                  <option <?= isset($value['decimal_places']) && ($value['decimal_places'] == 2)?'selected':''?> value="2">2</option>
                                  <option  <?= isset($value['decimal_places']) && ($value['decimal_places'] == 3)?'selected':''?>value="3">3</option>
                               </select>
                              
                               <label for="floatingSelectGrid">Decimal Places</label>
                            </div>
                         </div>
                         <div class="col-md-4">
                             <div class="form-floating">
                               <input type="text" class="form-control" data-val="" id="format" name="format" placeholder="Decimal Places" value="<?= isset($value['format'])?$value['format']:''?>" >
                               <label for="floatingSelectGrid">Format</label>
                            </div>
                         </div>
                      </div>
                      <br>
                      <p><b>Add Exchange Rate - CNY</b></p>
                      <div class="row">
                          <div class="col-md-4">
                            <div class="form-floating">
                               <input type="date" name="exchange_date" class="form-control" id="exchange_date" placeholder="" value="<?= isset($value['exchange_date'])?$value['exchange_date']:''?>" >
                               <label for="floatingSelectGrid">Select Date*</label>
                            </div>
                         </div>
                         <div class="col-md-4">
                            <div class="form-floating">
                               <input type="text" class="form-control" id="exchange_rate" name="exchange_rate" placeholder="Exchange Rate" value="<?= isset($value['exchange_rate'])?$value['exchange_rate']:''?>" >
                               <label for="floatingSelectGrid">Exchange Rate (in ZMW)*</label>
                            </div>
                         </div>
                      </div>
                        <br>
                        <div class="row">
                          <div class="col-md-6">
                          <?= StatusInput(isset($value['status'])?$value['status']:'1');?>
                         </div>
                          <div class="col-md-6 text-right">
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
  </div>