<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&display=swap" rel="stylesheet">
    <title>Aidepos</title>
    <style>
      html body {
        font-family: 'Open Sans', sans-serif!important;
        color: #373A3C;
      }
      p.heading {
        font-weight: 500;
        letter-spacing: 0.5px;
        margin:10px;
        font-family: 'Open Sans', sans-serif;
        font-size: 25px;
      }
      p {
        font-size: 12.5px;
        margin-bottom: 30px;
      }
      table {  
        font-family: arial, sans-serif;  
        border-collapse: collapse;  
        width: 100%;
        margin: 0px auto;
        border: 2px solid #e6e6e6;
      }
      #htmlContent{
        font-family: 'Open Sans', sans-serif;
        text-align: center;
      }
      .table thead > th {
        font-family: 'Open Sans', sans-serif;
        font-weight: 600;
        background-color: #f5f5f5
      }
      td, th {  
        border: 2px solid #e6e6e6;
        text-align: left; 
        font-size: 14px;
        padding: 8px;  
      }
      @font-face {
        font-family: 'Open Sans', sans-serif;
        font-style: normal;
        font-weight: normal;
      }
    </style>  
</head>
<body>
  <div id="htmlContent">
    <p class="heading"><?= $heading; ?></p>  
    <p><?= $date; ?></p>  
    <table class="table">  
      <thead> 
        <tr>  
          <th>Store</th>
          <th>Location</th>
          <th>Date</th>
          <th>SKU</th>
          <th>Item Name</th>
          <th>Category</th>
          <th>Rate</th>
          <th>Opening</th>
          <th>Received</th>
          <th>Returned</th>
          <th>Sold</th>
          <th>Adjustment</th>
          <th>Transfer</th>
          <th>Production</th>
          <th>Closing</th>
        </tr>
      </thead>  
      <tbody>  
        <?php 
        if(count($report_data) > 0) {
          foreach($report_data as $k => $v) { 
        ?>
        <tr>  
            <td><?= $v['store_name']; ?></td>
            <td><?= $v['location']; ?></td>
            <td><?= date('Y-m-d',strtotime($v['created_at'])); ?></td>
            <td><?= $v['sku_barcode']; ?></td>
            <td><?= $v['item_name']; ?></td>
            <td><?= $v['category_name']; ?></td>
            <td><?= $v['retail_price']; ?></td>
            <td><?= $v['open_qty']; ?></td>
            <td><?= $v['received_qty']; ?></td>
            <td><?= $v['return_qty']; ?></td>
            <td><?= $v['adjustment_qty']; ?></td>
            <td><?= $v['production_qty']; ?></td>
            <td><?= $v['transfer_qty']; ?></td>
            <td><?= $v['sold_qty']; ?></td>
            <td><?= $v['close_qty']; ?></td>
        </tr>
          <?php } } else {  ?>
          <tr>
            <td colspan="15" style="text-align: center;">No Data Found</td>
          </tr>
        <?php } ?>
      </tbody>  
    </table>    
  </div>
</body>
</html>