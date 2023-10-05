<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Aidepos</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400" rel="stylesheet">
  <style type="text/css">
      .top_rw{ background-color:#f4f4f4; }
      .invoice-box {
          max-width: 890px;
          margin: auto;
          padding:10px;
          border: 1px solid #eee;
          box-shadow: 0 0 10px rgba(0, 0, 0, .15);
          font-size: 12.5px;
          line-height: 24px;
          font-family: 'Montserrat', sans-serif !important;
          color: #555;
      }
      .invoice-box .top table {
          border-bottom: solid 1px #ccc;
      }
      .invoice-box table {
          width: 100%;
          line-height: inherit;
          text-align: left;
        /*border-bottom: solid 1px #ccc;*/
      }
      .invoice-box table td {
          padding: 5px;
          vertical-align:middle;
      }
      .invoice-box table tr td:nth-child(2) {
          text-align: right;
      }
      .invoice-box table tr.top table td {
          padding-bottom: 20px;
      }
      .invoice-box table tr.top table td.title {
          font-size: 45px;
          line-height: 45px;
          color: #555;
      }
      .invoice-box table tr.information table td {
          padding-bottom: 20px;
      }
      .invoice-box table tr.heading td {
          background: #eee;
          border-bottom: 1px solid #ddd;
          font-weight: bold;
          font-size:12.5px;
      }
      .invoice-box table tr.details td {
          padding-bottom: 20px;
      }
      .invoice-box table tr.item td{
          border-bottom: 1px solid #eee;
      }
      .invoice-box table tr.item.last td {
          border-bottom: none;
      }
      .invoice-box table tr.total td:nth-child(2) {
          border-top: 2px solid #eee;
          font-weight: 600;
      }
      @media only screen and (max-width: 600px) {
          .invoice-box table tr.top table td {
              width: 100%;
              display: block;
              text-align: center;
          }
          .invoice-box table tr.information table td {
              width: 100%;
              display: block;
              text-align: center;
          }
      }
      .pcs-payment-details-section {
          padding: 20px;
          background-color: #FBFAFA;
      }
      .pcs-font-bolder {
          font-weight: 600;
      }
      .pcs-pd-section-title {
          font-size: 10pt;
      }
      .pcs-label {
          color: #555;
          font-family: 'Montserrat', sans-serif;
      }
      .pcs-pd-section-label, .pcs-pd-section-value {
          padding-top: 10px;
      }
      thead {
         background-color: #FBFAFA;
      }
      .pcs-bdr-top {
         border-top: 1px solid #d8d8d7;
      }
  </style>
</head>
<body>
    <div class="invoice-box">
      <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="3">
                <table>
                    <tr>
                        <td>
                            <h3><b>AIDEPOS</b></h3>
                            Company ID : 90605<br/>
                            Tax ID : 100900800<br/>
                            Goldcrest Mall<br/>
                            Lusaka Zambia  
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="information">
          <td colspan="3">
            <table>
                <tr>
                    <td colspan="3">
                    <h3><b>INVOICE</b></h3>
                    <p>
                      Invoice# INV-000<?= $invoice['id']; ?> 
                    </p>
                  </td>
                </tr>
              </table>
          </td>
        </tr>
        <tr class="information">
            <td colspan="3">
            <table>
                <tr>
                    <td colspan="2">
                      <b>Bill To</b><br>
                      <b><?= $invoice['registerd_name']; ?> </b><br>
                      <?= $invoice['address']; ?> 
                    </td>
                    <td> 
                      <b> Invoice Date:&nbsp;</b><?= $invoice['invoice_date']; ?> 
                    </td>
                </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="3">
            <table cellspacing="0px" cellpadding="2px">
              <tr class="heading">
                  <td style="width:10%;">
                      #
                  </td>
                  <td style="width:35%;text-align:left;">
                      ITEM
                  </td>
                  <td style="width:10%; text-align:right;">
                      QTY
                  </td>
                  <td style="width:15%; text-align:right;">
                     RATE
                  </td>
                  <td style="width:20%; text-align:right;">
                      AMOUNT
                  </td>
              </tr>
              <?php 
              $i = 1;
              if(isset($sell_items) && !empty($sell_items)) {
              foreach($sell_items as $val) { ?>
              <tr class="item">
                  <td style="width:10%;text-align:left;">
                  	  <?= $i; ?>
                  </td>
                  <td style="width:35%;text-align:left;">
                      <?= $val['item_name']; ?>
                  </td>
                  <td style="width:10%; text-align:right;">
                      <?= $val['qty']; ?>
                  </td>
                  <td style="width:15%; text-align:right;">
                      <?= $val['rate']; ?>
                  </td>
                  <td style="width:20%; text-align:right;">
                      <?= $val['item_amount']; ?>
                  </td>
              </tr>
          	  <?php $i++; } } ?>
            </table>
          </td>
        </tr>
        <!-- <tr class="total">
            <td colspan="3" align="right">  Total Amount in Words :  <b> Three Hundred Eighty Rupees Only </b> </td>
        </tr> -->
        <tr>
         <td colspan="3">
          <table cellspacing="0px" cellpadding="2px">
            <tr>
              <td width="30%">
                <!-- <div style="padding: 10px 20px;background-color: #FBFAFA;">
                  <div class="pcs-label"><b>Payment Details</b></div>
                  <table style="width: 70%;" cellspacing="0" cellpadding="0" border="0">
                   <tbody>
                     <tr>
                       <td class="pcs-label pcs-pd-section-label" style="padding: 5px 0px;">Payment Mode</td>
                       <td id="v-payment-mode" style="font-weight:bold;padding: 5px 0px;"><?= $invoice['p_mode']; ?></td>
                     </tr>
                   </tbody>
                  </table>
                </div> -->
              </td>
              <td width="20%"></td>
            <!-- </tr>
            <tr> -->
              <td width="30%">
                <table class="pcs-bdr-bottom" id="itemTable" cellspacing="0" border="0" width="">
                    <tbody>
                        <tr>
                          <td valign="middle" style="padding: 10px 7px 5px;" class="text-align-right">Sub Total <br><!-- <span style="color:#666;font-size:10px;">(Tax Inclusive)</span> --></td>
                          <td id="v-sub-total" valign="middle" style="width:110px;padding: 10px 7px 10px;" class="text-align-right"><?= $invoice['sub_total']; ?></td>
                        </tr>
                        <tr style="height:10px;">
                          <td valign="middle" style="padding: 5px 7px;" class="text-align-right">Tax</td>
                          <td valign="middle" style="width:110px;padding: 10px 7px;" id="v-tax" class="text-align-right"><?= $invoice['total_tax']; ?></td>
                        </tr>
                        <tr style="height:10px;" class="pcs-balance">
                          <td valign="middle" style="padding: 10px 7px;" class="text-align-right total-section-label pcs-bdr-top"><b>Total</b></td>
                          <td id="v-total-amount" valign="middle" style="width:110px;padding: 10px 7px;" class="text-align-right total-section-value pcs-bdr-top"><b><?= $invoice['total_amount']; ?></b></td>
                        </tr>
                    </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td width="50%" colspan="3"><br><br></td>
              <!-- <td>
                <b> Authorized Signature </b>
                <br>
                <br>
                ...................................
                <br>
                <br>
                <br>
              </td> -->
            </tr>
          </table>
         </td>
        </tr>
      </table>
    </div>
</body>
</html>